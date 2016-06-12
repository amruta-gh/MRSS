<?php namespace App\Http\Controllers;

use Config;
use Parse\ParseUser;
use Parse\ParseObject;
use Parse\ParseQuery;
use Parse\ParseClient;

class WelcomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Welcome Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest');
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		if ($currentUser = ParseUser::getCurrentUser())
		{
			if(!is_null($currentUser->get("dp")))
			{
				$url = $currentUser->get("dp")->getURL();
			}
			else
			{
				$url = null;
			}
			if($currentUser->get("role") == Config::get("app.roles")[0])
			{
				return view('patient.home', ["user" => $currentUser, "url" => $url]);
			}
			if($currentUser->get("role") == Config::get("app.roles")[1])
			{
				return view('doctor.home', ["user" => $currentUser, "url" => $url]);
			}
			if($currentUser->get("role") == Config::get("app.roles")[2])
			{
				return view('nurse.home', ["user" => $currentUser, "url" => $url]);
			}
      //return redirect('/');
    }
		return view('welcome');
	}

}
