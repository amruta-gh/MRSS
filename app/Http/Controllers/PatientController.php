<?php namespace App\Http\Controllers;

use Config;
use Request;
use Parse\ParseUser;
use Parse\ParseObject;
use Parse\ParseQuery;
use Parse\ParseClient;
use Parse\ParseFile;

class PatientController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Auth Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(Request $request)
   {
       $this->request = $request;
   }


	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function appointments()
	{
		if ($currentUser = ParseUser::getCurrentUser())
		{
			if($currentUser->get("role") == Config::get("app.roles")[0])
			{
				$myapoointments = $this->getMyAppointments($currentUser->getObjectId());
				$doctor = ParseUser::query();
				return view('patient.appointments', ["myAppointments" => $myapoointments, "doctor" => $doctor ]);
			}
    }
		return view('auth.login');
	}

	public function editprofile()
	{
		if ($currentUser = ParseUser::getCurrentUser())
		{
			if($currentUser->get("role") == Config::get("app.roles")[0])
			{
				if(!is_null($currentUser->get("dp")))
				{
					$url = $currentUser->get("dp")->getURL();
				}
				else
				{
					$url = null;
				}
				return view('patient.profileedit',["user" => $currentUser, "url" => $url]);
			}
    }
		return view('auth.login');
	}

	public function updateprofile()
	{
		if ($currentUser = ParseUser::getCurrentUser())
		{
			if($currentUser->get("role") == Config::get("app.roles")[0])
			{
				if($this->updateProfileAttributes())
				{
					return redirect('home');
				}
				else
				{
					return redirect('patient/profile/edit');
				}
			}
		}
		return view('auth.login');
	}

	private function updateProfileAttributes()
	{
		$name = Request::input('name');
		$address = Request::input('address');
		$state =Request::input('state');
		$zip =Request::input('zip');
		$email =Request::input('email');
		$dob =Request::input('dob');
		$gender =Request::input('gender');
		$allergies =Request::input('allergies');
		$notes =Request::input('notes');

		$user = ParseUser::getCurrentUser();
		$user->set('name',$name);
		$user->set('address',$address);
		$user->set('state',$state);
		$user->set('zip',$zip);
		$user->set('email', $email);
		$user->set('dob',$dob);
		$user->set('gender',$gender);
		$user->set('allergies',$allergies);
		$user->set('notes',$notes);

		if (Request::hasFile('dp'))
		{
			$ext = Request::file('dp')->guessExtension();
			$user->set('dp', ParseFile::createFromFile(Request::file('dp'), "dp.".$ext));
		}

		try {
			$user->save();
			return true;
		} catch (ParseException $ex) {
			echo 'Failed to update object, with error message: ' + $ex->getMessage();
			return false;
		}

	}
	public function addappointment()
	{
		if ($currentUser = ParseUser::getCurrentUser())
		{
			if($currentUser->get("role") == Config::get("app.roles")[0])
			{
				$availableAppointments = $this->getAvailableAppointments();
				$doctor = ParseUser::query();;
				return view('patient.addappointment',["availableAppointments" => $availableAppointments, "doctor" => $doctor ]);
			}
    }
		return view('auth.login');
	}

	public function makeappointment($id)
	{
		if ($currentUser = ParseUser::getCurrentUser())
		{
			if($currentUser->get("role") == Config::get("app.roles")[0])
			{
				$this->makeanappointment($currentUser->getObjectId(), $id);
				return redirect('patient/appointments');
			}
		}
		return view('auth.login');
	}

	public function cancelappointment($id)
	{
		if ($currentUser = ParseUser::getCurrentUser())
		{
			if($currentUser->get("role") == Config::get("app.roles")[0])
			{
				$this->cancelanappointment($currentUser->getObjectId(), $id);
				return redirect('patient/appointments');
			}
		}
		return view('auth.login');
	}

	public function saveappointment()
	{
		if ($currentUser = ParseUser::getCurrentUser())
		{
			if($currentUser->get("role") == Config::get("app.roles")[1])
			{
				$location = Request::input('location');
		    $date = Request::input('date');
		    $time =Request::input('time');
				$doctor = $currentUser->getObjectId();

				$appointment = new ParseObject("Appointment");

				$appointment->set("doctorid", $doctor);
				$appointment->set("location", $location);
				$appointment->set("date", $date);
				$appointment->set("time", $time);

				try {
				  $appointment->save();
				  echo 'New appointment created with objectId: ' . $appointment->getObjectId();
				} catch (ParseException $ex) {
				  echo 'Failed to create new object, with error message: ' + $ex->getMessage();
				}

				return view('patient.addappointment');
			}
    }
		return view('auth.login');
	}

	private function getAvailableAppointments()
	{
		$query = new ParseQuery("Appointment");
		$query->containedIn("appointmentfor",[null, ""]);
		$results = $query->find();
		return $results;
	}

	private function makeanappointment($patientid, $appointmentid)
	{
		$query = new ParseQuery("Appointment");
		$appointment = $query->get($appointmentid);
		if($appointment->get("appointmentfor") == null || $appointment->get("appointmentfor") == "")
		{
			$appointment->set("appointmentfor", $patientid);
			try {
			  $appointment->save();
				return true;
			} catch (ParseException $ex) {
			}
			return false;
		}
		return false;
	}

	private function cancelanappointment($patientid, $appointmentid)
	{
		$query = new ParseQuery("Appointment");
		$appointment = $query->get($appointmentid);
		if($appointment->get('appointmentfor') != $patientid)
		{
			return false;
		}
		$appointment->set("appointmentfor", null);
		try {
		  $appointment->save();
			return true;
		} catch (ParseException $ex) {
		}
		return false;
	}

	private function getMyAppointments($id)
	{
		$query = new ParseQuery("Appointment");
		$query->equalTo("appointmentfor", $id);
		$results = $query->find();
		return $results;
	}

	private function getMyPrescriptions($id)
	{
		$query = new ParseQuery("Prescription");
		$query->equalTo("patientid", $id);
		$results = $query->find();
		return $results;
	}

	public function prescriptions()
	{
		if ($currentUser = ParseUser::getCurrentUser())
		{
			if($currentUser->get("role") == Config::get("app.roles")[0])
			{
				$prescriptions = $this->getMyPrescriptions($currentUser->getObjectId());
				$doctor = ParseUser::query();
				return view('patient.prescriptions', ["prescriptions" => $prescriptions, "doctor" => $doctor ]);
			}
    }
		return view('auth.login');
	}



}
