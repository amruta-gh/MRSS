<?php namespace App\Http\Controllers\ParseAuth;
use App\Http\Controllers\Controller;
use Config;
use Request;
use Parse\ParseUser;
use Parse\ParseObject;
use Parse\ParseQuery;
use Parse\ParseClient;

class AuthController extends Controller {

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
	public function index()
	{
		if ($currentUser = ParseUser::getCurrentUser()) {
      return redirect('/');
    }
		return view('auth.login');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function registerform()
	{
		$roles = Config::get("app.roles");
		return view('auth.register', ['roles' => $roles]);
	}

	public function register()
	{
		$username = Request::input('username');
    $password = Request::input('password');
    $role =Request::input('role');
    $email = Request::input('email');
		$name = Request::input('name');

		$user = new ParseUser();
		$user->set("username", $username);
		$user->set("password", $password);
		$user->set("email", $email);
		$user->set("role", $role);
		$user->set("name", $name);

		try {
		  $user->signUp();
			return redirect('/auth/login');
		} catch (ParseException $ex) {
			return redirect('/auth/register');
		}

	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function login()
	{
		$username = Request::input('username');
    $password = Request::input('password');

		try {
		  $user = ParseUser::logIn($username, $password);
			return redirect('/');

		} catch (ParseException $error) {
			return redirect('/auth/login');
		}
	}

	public function logout()
	{
		ParseUser::logOut();
		return redirect('/auth/login');
	}

}
