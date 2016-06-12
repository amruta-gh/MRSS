<?php namespace App\Http\Controllers;

use Config;
use Request;
use Parse\ParseUser;
use Parse\ParseObject;
use Parse\ParseQuery;
use Parse\ParseClient;
use Parse\ParseFile;


class NurseController extends Controller {

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
	public function prescriptions()
	{
		if ($currentUser = ParseUser::getCurrentUser())
		{
			if($currentUser->get("role") == Config::get("app.roles")[2])
			{
				$query = new ParseQuery("Prescription");
				$query->equalTo('is_dispensed', false);
				try {
				  $results = $query->find();
					$doctor = new ParseQuery("_User");
					return view('nurse.prescriptions', ["prescriptions" => $results, "doctor" => $doctor]);
				} catch (ParseException $ex) {
					return redirect('home');
				}
			}
    }
	}


	public function patients()
	{
		if ($currentUser = ParseUser::getCurrentUser())
		{
			if($currentUser->get("role") == Config::get("app.roles")[2])
			{
				$query = new ParseQuery("_User");
				$query->equalTo("role",Config::get("app.roles")[0]);
				$results = $query->find();
				return view('doctor.patients', ["patients" => $results]);
			}
    }
		return redirect('home');

	}



}
