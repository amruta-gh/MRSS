<?php namespace App\Http\Controllers;

use Config;
use Request;
use Parse\ParseUser;
use Parse\ParseObject;
use Parse\ParseQuery;
use Parse\ParseClient;
use Parse\ParseFile;

class RecordController extends Controller {

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(Request $request)
   {
       $this->request = $request;
   }

	public function record($id)
	{
		if ($currentUser = ParseUser::getCurrentUser())
		{
			if($currentUser->get("role") == Config::get("app.roles")[1])
			{
				$role = 1;
			}
			if($currentUser->get("role") == Config::get("app.roles")[0])
			{
				if($currentUser->getObjectId() != $id)
				{
					return redirect('/auth/login');
				}
				$role = 0;
			}
			if($currentUser->get("role") == Config::get("app.roles")[2])
			{
				$role = 2;
			}
    }
		else{
			return redirect('/auth/login');
		}

		$patient = $this->getPatient($id);
    $notes = $this->getNotes($id);
    $prescriptions = $this->getPrescriptions($id);
		$bp = $this->getBP($id);
		$weight = $this->getWeight($id);
		$temperature = $this->getTemperature($id);
		$scans = $this->getScans($id);
		$pulse = $this->getPulse($id);
		$doctor = ParseUser::query();

		if(!is_null($patient->get("dp")))
		{
			$url = $patient->get("dp")->getURL();
		}
		else
		{
			$url = null;
		}

		return view('record.record',
    [
			"role" => $role,
			"user" => $patient,
			"url" => $url,
      "patient" => $patient,
      "notes" => $notes,
			"doctor" => $doctor,
      "prescriptions" => $prescriptions,
			"bps" => $bp,
			"temperatures" => $temperature,
			"weights" => $weight,
			"pulses" => $pulse,
			"scans" => $scans,
			"currentuser" => $currentUser
    ]);
	}

  public function notes($id)
	{
		if ($currentUser = ParseUser::getCurrentUser())
		{
			if($currentUser->get("role") != Config::get("app.roles")[1])
			{
        return redirect('/auth/login');
			}
    }

		return view('record.addnotes', ["patientid" => $id]);
	}

  public function addnotes($id)
	{
		if ($currentUser = ParseUser::getCurrentUser())
		{
			if($currentUser->get("role") != Config::get("app.roles")[1])
			{
        return redirect('/auth/login');
			}
    }

    $note = Request::input('note');

    $doctornote = new ParseObject("DoctorNotes");

    $doctornote->set("patientid", $id);
    $doctornote->set("doctorId", $currentUser->getObjectId());
    $doctornote->set("note", $note);

    try {
      $doctornote->save();

    } catch (ParseException $ex) {

    }

    return redirect('/patient/record/'.$id);
	}

	public function scan($id)
	{
		if ($currentUser = ParseUser::getCurrentUser())
		{
			if($currentUser->get("role") != Config::get("app.roles")[1])
			{
        return redirect('/auth/login');
			}
    }

		return view('record.addscan', ["patientid" => $id]);
	}

  public function addscan($id)
	{
		if ($currentUser = ParseUser::getCurrentUser())
		{
			if(!($currentUser->get("role") == Config::get("app.roles")[1] || $currentUser->get("role") == Config::get("app.roles")[2]))
			{
        return redirect('/auth/login');
			}
    }

		if (!Request::hasFile('scan'))
		{
			return redirect('record/scan/add/'.$id);
		}

    $note = Request::input('note');
		$name = Request::input('name');
		$ext = Request::file('scan')->guessExtension();
		$file = ParseFile::createFromFile(Request::file('scan'), "image.".$ext);

    $doctornote = new ParseObject("Scan");

    $doctornote->set("patientid", $id);
    $doctornote->set("doctorId", $currentUser->getObjectId());
    $doctornote->set("note", $note);
		$doctornote->set("name", $name);
		$doctornote->set("file", $file);

    try {
      $doctornote->save();

    } catch (ParseException $ex) {
			echo 'Failed to create new object, with error message: ' + $ex->getMessage();
    }

    return redirect('/patient/record/'.$id);
	}

	private function getPatient($id)
	{
		$query = new ParseQuery("_User");
		try {
		  return $query->get($id);
		} catch (ParseException $ex) {
			return null;
		}
	}

  private function getNotes($id)
  {
    $query = new ParseQuery("DoctorNotes");
    $query->equalTo("patientid", $id);
		try {
		  return $query->find();
		} catch (ParseException $ex) {
			return null;
		}
  }

	private function getScans($id)
  {
    $query = new ParseQuery("Scan");
    $query->equalTo("patientid", $id);
		try {
		  return $query->find();
		} catch (ParseException $ex) {
			return null;
		}
  }

  public function prescription($id)
	{
		if ($currentUser = ParseUser::getCurrentUser())
		{
			if($currentUser->get("role") != Config::get("app.roles")[1])
			{
        return redirect('/auth/login');
			}
    }

		return view('record.addprescription', ["patientid" => $id]);
	}

  public function addprescription($id)
	{
		if ($currentUser = ParseUser::getCurrentUser())
		{
			if($currentUser->get("role") != Config::get("app.roles")[1])
			{
        return redirect('/auth/login');
			}
    }

    $drug = Request::input('drug');
    $dosage = Request::input('dosage');

    $prescription = new ParseObject("Prescription");

    $prescription->set("patientid", $id);
    $prescription->set("doctorId", $currentUser->getObjectId());
    $prescription->set("drug", $drug);
    $prescription->set("dosage", $dosage);
		$prescription->set('is_dispensed', false);

    try {
      $prescription->save();

    } catch (ParseException $ex) {

    }

    return redirect('/patient/record/'.$id);
	}

  private function getPrescriptions($id)
  {
    $query = new ParseQuery("Prescription");
    $query->equalTo("patientid", $id);
		try {
		  return $query->find();
		} catch (ParseException $ex) {
			return null;
		}
  }

	public function addbp($id)
	{
		if ($currentUser = ParseUser::getCurrentUser())
		{
			if(!($currentUser->get("role") == Config::get("app.roles")[1] || $currentUser->get("role") == Config::get("app.roles")[2]))
			{
        return redirect('/auth/login');
			}
    }

    $systolic = Request::input('systolic');
    $diastolic = Request::input('diastolic');

    $vital = new ParseObject("Vital_BloodPresure");

    $vital->set("patientid", $id);
    $vital->set("doctorId", $currentUser->getObjectId());
    $vital->set("systolic", $systolic);
    $vital->set("diastolic", $diastolic);

    try {
      $vital->save();

    } catch (ParseException $ex) {

    }

    return redirect('/patient/record/'.$id);
	}

	public function addweight($id)
	{
		if ($currentUser = ParseUser::getCurrentUser())
		{
			if(!($currentUser->get("role") == Config::get("app.roles")[1] || $currentUser->get("role") == Config::get("app.roles")[2]))
			{
        return redirect('/auth/login');
			}
    }

    $weight = Request::input('weight');
    $diastolic = Request::input('diastolic');

    $vital = new ParseObject("Vital_Weight");

    $vital->set("patientid", $id);
    $vital->set("doctorId", $currentUser->getObjectId());
    $vital->set("weight", $weight);

    try {
      $vital->save();

    } catch (ParseException $ex) {

    }

    return redirect('/patient/record/'.$id);
	}

	public function addtemperature($id)
	{
		if ($currentUser = ParseUser::getCurrentUser())
		{
			if(!($currentUser->get("role") == Config::get("app.roles")[1] || $currentUser->get("role") == Config::get("app.roles")[2]))
			{
        return redirect('/auth/login');
			}
    }

    $temperature = Request::input('temperature');

    $vital = new ParseObject("Vital_Temperature");

    $vital->set("patientid", $id);
    $vital->set("doctorId", $currentUser->getObjectId());
    $vital->set("temperature", $temperature);

    try {
      $vital->save();

    } catch (ParseException $ex) {

    }

    return redirect('/patient/record/'.$id);
	}

	public function addpulse($id)
	{
		if ($currentUser = ParseUser::getCurrentUser())
		{
			if(!($currentUser->get("role") == Config::get("app.roles")[1] || $currentUser->get("role") == Config::get("app.roles")[2]))
			{
        return redirect('/auth/login');
			}
    }

    $pulse = Request::input('pulse');

    $vital = new ParseObject("Vital_Pulse");

    $vital->set("patientid", $id);
    $vital->set("doctorId", $currentUser->getObjectId());
    $vital->set("pulse", $pulse);

    try {
      $vital->save();

    } catch (ParseException $ex) {

    }

    return redirect('/patient/record/'.$id);
	}

	private function getBP($id)
  {
    $query = new ParseQuery("Vital_BloodPresure");
    $query->equalTo("patientid", $id);
		$query->descending("createdAt");
		try {
		  return $query->find();
		} catch (ParseException $ex) {
			return null;
		}
  }

	private function getWeight($id)
  {
    $query = new ParseQuery("Vital_Weight");
    $query->equalTo("patientid", $id);
		$query->descending("createdAt");
		try {
		  return $query->find();
		} catch (ParseException $ex) {
			return null;
		}
  }

	private function getTemperature($id)
  {
    $query = new ParseQuery("Vital_Temperature");
    $query->equalTo("patientid", $id);
		$query->descending("createdAt");
		try {
		  return $query->find();
		} catch (ParseException $ex) {
			return null;
		}
  }

	private function getPulse($id)
  {
    $query = new ParseQuery("Vital_Pulse");
    $query->equalTo("patientid", $id);
		$query->descending("createdAt");
		try {
		  return $query->find();
		} catch (ParseException $ex) {
			return null;
		}
  }

	public function dispense($id)
  {
		if ($currentUser = ParseUser::getCurrentUser())
		{
			if($currentUser->get("role") != Config::get("app.roles")[1] && $currentUser->get("role") != Config::get("app.roles")[2])
			{
        return redirect('/auth/login');
			}
    }

    $query = new ParseQuery("Prescription");
		try {
		  $result = $query->get($id);
			$result->set('is_dispensed', true);
			try {
	      $result->save();
				if($currentUser->get("role") == Config::get("app.roles")[1])
				return redirect('patient/record/'.$result->get('patientid'));
				else
				return redirect('nurse/prescriptions');
	    } catch (ParseException $ex) {
	    }
		} catch (ParseException $ex) {
		}

		return redirect('home');
  }

	public function refill($id)
  {
		if ($currentUser = ParseUser::getCurrentUser())
		{
			if($currentUser->get("role") != Config::get("app.roles")[1])
			{
        return redirect('/auth/login');
			}
    }

    $query = new ParseQuery("Prescription");
		try {
		  $result = $query->get($id);
			$result->set('is_dispensed', false);
			try {
	      $result->save();
				return redirect('patient/record/'.$result->get('patientid'));
	    } catch (ParseException $ex) {
	    }
		} catch (ParseException $ex) {
		}

		return redirect('home');
  }

	public function cancel($id)
  {
		if ($currentUser = ParseUser::getCurrentUser())
		{
			if($currentUser->get("role") != Config::get("app.roles")[1])
			{
        return redirect('/auth/login');
			}
    }

    $query = new ParseQuery("Prescription");
		try {
		  $result = $query->get($id);
			$result->destroy();
			return redirect('patient/record/'.$result->get('patientid'));
		} catch (ParseException $ex) {
		}

		return redirect('home');
  }

  public function deletescan($id)
  {
		if ($currentUser = ParseUser::getCurrentUser())
		{
			if($currentUser->get("role") != Config::get("app.roles")[1])
			{
        return redirect('/auth/login');
			}
    }

    $query = new ParseQuery("Scan");
		try {
		  $result = $query->get($id);
			$result->destroy();
			return redirect('patient/record/'.$result->get('patientid'));
		} catch (ParseException $ex) {
		}

		return redirect('home');
  }

	public function deletenotes($id)
  {
		if ($currentUser = ParseUser::getCurrentUser())
		{
			if($currentUser->get("role") != Config::get("app.roles")[1])
			{
        return redirect('/auth/login');
			}
    }

    $query = new ParseQuery("DoctorNotes");
		try {
		  $result = $query->get($id);
			$result->destroy();
			return redirect('patient/record/'.$result->get('patientid'));
		} catch (ParseException $ex) {
		}

		return redirect('home');
  }



}
