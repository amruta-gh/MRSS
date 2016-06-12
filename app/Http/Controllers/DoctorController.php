<?php namespace App\Http\Controllers;

use Config;
use Request;
use Parse\ParseUser;
use Parse\ParseObject;
use Parse\ParseQuery;
use Parse\ParseClient;
use Parse\ParseFile;


class DoctorController extends Controller {

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
			if($currentUser->get("role") == Config::get("app.roles")[1])
			{
				$availableAppointments = $this->getAvailableAppointments();
				$bookedAppointments = $this->getBookedAppointments();
				$patient = ParseUser::query();
				return view('doctor.appointments',["availableAppointments" => $availableAppointments,
																						"bookedAppointments" => $bookedAppointments,
																						"patient" =>$patient  ]);
			}
    }
		return view('auth.login');
	}

	public function addappointment()
	{
		if ($currentUser = ParseUser::getCurrentUser())
		{
			if($currentUser->get("role") == Config::get("app.roles")[1])
			{

				return view('doctor.addappointment');
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

				return view('doctor.addappointment');
			}
    }
		return view('auth.login');
	}

	private function getAvailableAppointments()
	{
		$query = new ParseQuery("Appointment");
		$query->equalTo("doctorid", ParseUser::getCurrentUser()->getObjectId());
		$query->containedIn("appointmentfor",[null, ""]);
		$results = $query->find();
		return $results;
	}

	private function getAvailableAppointmentsFor($id)
	{
		$query = new ParseQuery("Appointment");
		$query->equalTo("doctorid", $id);
		$query->containedIn("appointmentfor",[null, ""]);
		$results = $query->find();
		return $results;
	}

	private function getBookedAppointments()
	{
		$query = new ParseQuery("Appointment");
		$query->equalTo("doctorid", ParseUser::getCurrentUser()->getObjectId());
		$query->notContainedIn("appointmentfor",[null, ""]);
		$results = $query->find();
		return $results;
	}

	public function patients()
	{
		$query = new ParseQuery("Appointment");
		$query->equalTo("doctorid", ParseUser::getCurrentUser()->getObjectId());
		$query->notContainedIn("appointmentfor",[null, ""]);
		$results = $query->find();
		$query = new ParseQuery("_User");
		//$query->containedIn("objectId",$this->getPatients($results));
		$query->equalTo("role",Config::get("app.roles")[0]);
		$results = $query->find();
		return view('doctor.patients', ["patients" => $results]);
	}

	public function all()
	{
		$query = new ParseQuery("_User");
		//$query->containedIn("objectId",$this->getPatients($results));
		$query->equalTo("role",Config::get("app.roles")[1]);
		$results = $query->find();
		return view('doctor.all', ["doctors" => $results]);
	}

	private function getPatients($results)
	{
		$array = array();
		foreach($results as $result)
		{
			array_push($array,$result->get('appointmentfor'));
		}
		return array_unique($array);
	}

	public function editprofile()
	{
		if ($currentUser = ParseUser::getCurrentUser())
		{
			if($currentUser->get("role") == Config::get("app.roles")[1])
			{
				if(!is_null($currentUser->get("dp")))
				{
					$url = $currentUser->get("dp")->getURL();
				}
				else
				{
					$url = null;
				}
				return view('doctor.profileedit',["user" => $currentUser, "url" => $url]);
			}
    }
		return view('auth.login');
	}

	public function updateprofile()
	{
		if ($currentUser = ParseUser::getCurrentUser())
		{
			if($currentUser->get("role") == Config::get("app.roles")[1])
			{
				if($this->updateProfileAttributes())
				{
					return redirect('home');
				}
				else
				{
					return redirect('doctor/profile/edit');
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
		$about =Request::input('about');
		$regid =Request::input('regid');
		$qualifications =Request::input('qualifications');

		$user = ParseUser::getCurrentUser();
		$user->set('name',$name);
		$user->set('address',$address);
		$user->set('state',$state);
		$user->set('zip',$zip);
		$user->set('email', $email);
		$user->set('dob',$dob);
		$user->set('gender',$gender);
		$user->set('about',$about);
		$user->set('regid',$regid);
		$user->set('qualifications',$qualifications);

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

	public function profile($id)
	{
		$query = new ParseQuery("_User");
		$doctor = $query->get($id);
		$is_Patient = false;
		if($currentUser = ParseUser::getCurrentUser())
		{
			if($currentUser->get("role") == Config::get("app.roles")[0])
			{
				$is_Patient = true;
			}

		}

		if(!is_null($doctor->get("dp")))
		{
			$url = $doctor->get("dp")->getURL();
		}
		else
		{
			$url = null;
		}

		$appointments = array();

		if($is_Patient)
		{
			$appointments = $this->getAvailableAppointmentsFor($id);
		}
		return view('doctor.profile', ["doctor" => $doctor, "url"=>$url, "ispatient" => $is_Patient, "appointments" => $appointments]);
	}

	public function deleteappointment($id)
	{
		$query = new ParseQuery("Appointment");
		$appointment = $query->get($id);
		$currentUser = ParseUser::getCurrentUser();
		if($currentUser->getObjectId() == $appointment->get('doctorid'))
		{
			$appointment->destroy();
		}
		return redirect('/doctor/appointments');
	}



}
