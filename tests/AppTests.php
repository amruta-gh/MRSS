<?php
use Parse\ParseUser;

class AppTests extends TestCase {

	/**
	 * Test home page
	 *
	 * @return void
	 */
	public function testHome()
	{
		$response = $this->call('GET', '/');

		$this->assertEquals(200, $response->getStatusCode());
	}

    /**
	 * Test if login form is oading
	 *
	 * @return void
	 */
	public function testLoginForm()
	{
		$response = $this->call('GET', 'auth/login');

		$this->assertEquals(200, $response->getStatusCode());
	}

    /**
	 * Test if Register form is loading
	 *
	 * @return void
	 */
	public function testSignUpForm()
	{
		$response = $this->call('GET', 'auth/register');

		$this->assertEquals(200, $response->getStatusCode());
	}

    /**
	 * TEst if blogs page is working
	 *
	 * @return void
	 */
    public function testBlogHome()
  	{
  		$response = $this->call('GET', 'blogs');

  		$this->assertEquals(200, $response->getStatusCode());
  	}

    /**
	 * Test if Parse authentication is working
	 *
	 * @return void
	 */
    public function testPasreLogin()
  	{
  		$user = ParseUser::logIn("jonathan", "qwe123");
  		$this->assertEquals("qM5bReOEHB", $user->getObjectId());
      ParseUser::logOut();
  	}

     /**
	 * Test if login form is working for doctor
	 *
	 * @return void
	 */
    public function testDoctorAppLogin()
  	{
      $params = [
          '_token' => csrf_token(),
          'username' => 'jonathan',
          'password' => 'qwe123'
      ];
  		$response = $this->call('POST', 'auth/login', $params);
  		$this->assertRedirectedTo('');
  	}

     /**
	 * Test if login form is working for patient
	 *
	 * @return void
	 */
    public function testPatientAppLogin()
    {
      $params = [
          '_token' => csrf_token(),
          'username' => 'janet',
          'password' => 'qwe123'
      ];
    	$response = $this->call('POST', 'auth/login', $params);
    	$this->assertRedirectedTo('');
    }

    /**
	 * Test if doctor profile edit loads
	 *
	 * @return void
	 */
    public function testDoctorEdit()
  	{
  		$user = ParseUser::logIn("jonathan", "qwe123");
      $response = $this->call('GET', 'doctor/profile/edit');
  		$this->assertViewHas('url');
      $this->assertViewHas('user', $user);
      ParseUser::logOut();
  	}

    /**
	 * Test if pateint profile edit loads
	 *
	 * @return void
	 */
    public function testPatientEdit()
  	{
  		$user = ParseUser::logIn("janet", "qwe123");
      $response = $this->call('GET', 'patient/profile/edit');
  		$this->assertViewHas('url');
      $this->assertViewHas('user', $user);
      ParseUser::logOut();
  	}

    /**
	 * A basic functional test
	 *
	 * @return void
	 */
    public function testBlogView()
  	{
  		$user = ParseUser::logIn("jonathan", "qwe123");
      $response = $this->call('GET', 'blog/WVcabysb1Z');
  		$this->assertViewHas('blog');
      $this->assertViewHas('images');
      $this->assertViewHas('doctor');
      $this->assertViewHas('comments');
      $this->assertViewHas('url');
      ParseUser::logOut();
  	}

    /**
	 * Test if blog create form shows up
	 *
	 * @return void
	 */
    public function testBlogCreate()
  	{
  		$user = ParseUser::logIn("jonathan", "qwe123");
      $response = $this->call('GET', 'doctor/blog/post');
  		$this->assertEquals(200, $response->getStatusCode());
      ParseUser::logOut();
  	}

    /**
	 * Test if user is redirected to login on blog create if the user not a doctor
	 *
	 * @return void
	 */
    public function testPatientBlogRedirect()
  	{
      $params = [
          '_token' => csrf_token()
      ];
  		$user = ParseUser::logIn("janet", "qwe123");
      $response = $this->call('POST', 'doctor/blog/post', $params);
  		$this->assertEquals(302, $response->getStatusCode());
      ParseUser::logOut();
  	}

    /**
	 * Test if doctor's appointments are shown
	 *
	 * @return void
	 */
    public function testDoctorAppointmentList()
  	{
  		$user = ParseUser::logIn("jonathan", "qwe123");
      $response = $this->call('GET', 'doctor/appointments');
  		$this->assertViewHas('bookedAppointments');
      $this->assertViewHas('availableAppointments');
      $this->assertViewHas('patient');
      ParseUser::logOut();
  	}

     /**
	 * Test if doctor's profile is shown as patient
	 *
	 * @return void
	 */
    public function testDoctorProfileViewPatient()
  	{
  		$user = ParseUser::logIn("janet", "qwe123");
      $response = $this->call('GET', 'doctor/profile/qM5bReOEHB');
  		$this->assertEquals(200, $response->getStatusCode());
      $this->assertViewHas('doctor');
      $this->assertViewHas('url');
      $this->assertViewHas('ispatient', true);
      ParseUser::logOut();
  	}

    /**
	 * Test if doctor's profile is shown as doctor
	 *
	 * @return void
	 */
    public function testDoctorProfileViewDoctor()
  	{
  		$user = ParseUser::logIn("jonathan", "qwe123");
      $response = $this->call('GET', 'doctor/profile/qM5bReOEHB');
  		$this->assertEquals(200, $response->getStatusCode());
      $this->assertViewHas('doctor');
      $this->assertViewHas('url');
      $this->assertViewHas('ispatient', false);
      ParseUser::logOut();
  	}

    /**
	 * Test if patient record is shown as doctor
	 *
	 * @return void
	 */
    public function testRecordViewDoctor()
  	{
  		$user = ParseUser::logIn("jonathan", "qwe123");
      $response = $this->call('GET', 'patient/record/AONr5aNrcg');
  		$this->assertEquals(200, $response->getStatusCode());
      $this->assertViewHas('role', 1);
      $this->assertViewHas('user');
      $this->assertViewHas('url');
      $this->assertViewHas('patient');
      $this->assertViewHas('doctor');
      $this->assertViewHas('url');
      $this->assertViewHas('notes');
      $this->assertViewHas('doctor');
      $this->assertViewHas('prescriptions');
      $this->assertViewHas('bps');
      $this->assertViewHas('temperatures');
      $this->assertViewHas('weights');
      $this->assertViewHas('pulses');
      $this->assertViewHas('scans');
      $this->assertViewHas('currentuser');
      ParseUser::logOut();
  	}

    /**
	 * Test if patient record is shown as Patient
	 *
	 * @return void
	 */
    public function testRecordViewPateint()
  	{
  		$user = ParseUser::logIn("janet", "qwe123");
      $response = $this->call('GET', 'patient/record/AONr5aNrcg');
  		$this->assertEquals(200, $response->getStatusCode());
      $this->assertViewHas('role', 0);
      $this->assertViewHas('user');
      $this->assertViewHas('url');
      $this->assertViewHas('patient');
      $this->assertViewHas('doctor');
      $this->assertViewHas('url');
      $this->assertViewHas('notes');
      $this->assertViewHas('doctor');
      $this->assertViewHas('prescriptions');
      $this->assertViewHas('bps');
      $this->assertViewHas('temperatures');
      $this->assertViewHas('weights');
      $this->assertViewHas('pulses');
      $this->assertViewHas('scans');
      $this->assertViewHas('currentuser');
      ParseUser::logOut();
  	}

    /**
	 * Test if patient can see apoointments
	 *
	 * @return void
	 */
    public function testPatientAppointmentView()
  	{
  		$user = ParseUser::logIn("janet", "qwe123");
      $response = $this->call('GET', 'patient/appointments');
  		$this->assertEquals(200, $response->getStatusCode());
      $this->assertViewHas('myAppointments');
      $this->assertViewHas('doctor');
      ParseUser::logOut();
  	}

    /**
	 * Test if patient can add apoointment
	 *
	 * @return void
	 */
    public function testPatientAppointmentAdd()
  	{
  		$user = ParseUser::logIn("janet", "qwe123");
      $response = $this->call('GET', 'patient/appointments/add');
  		$this->assertEquals(200, $response->getStatusCode());
      ParseUser::logOut();
  	}

    /**
	 * Test if patient can see prescriptions
	 *
	 * @return void
	 */
    public function testPatientPrescriptionsView()
  	{
  		$user = ParseUser::logIn("janet", "qwe123");
      $response = $this->call('GET', 'patient/prescriptions');
  		$this->assertEquals(200, $response->getStatusCode());
      $this->assertViewHas('prescriptions');
      $this->assertViewHas('doctor');
      ParseUser::logOut();
  	}

    /**
	 * Test if doctor can add prescription
	 *
	 * @return void
	 */
    public function testDoctorPrescriptionsAdd()
  	{
  		$user = ParseUser::logIn("jonathan", "qwe123");
      $response = $this->call('GET', 'record/prescription/add/AONr5aNrcg');
  		$this->assertEquals(200, $response->getStatusCode());
      ParseUser::logOut();
  	}

    /**
	 * Test if doctor can add scan
	 *
	 * @return void
	 */
    public function testDoctorScansAdd()
  	{
  		$user = ParseUser::logIn("jonathan", "qwe123");
      $response = $this->call('GET', 'record/scan/add/AONr5aNrcg');
  		$this->assertEquals(200, $response->getStatusCode());
      ParseUser::logOut();
  	}

    /**
	 * Test if doctor can add notes
	 *
	 * @return void
	 */
    public function testDoctorNotesAdd()
  	{
  		$user = ParseUser::logIn("jonathan", "qwe123");
      $response = $this->call('GET', 'record/notes/add/AONr5aNrcg');
  		$this->assertEquals(200, $response->getStatusCode());
      ParseUser::logOut();
  	}

    /**
	 * Test if nurse can view prescriptions
	 *
	 * @return void
	 */
    public function testNursePrescriptionsView()
  	{
  		$user = ParseUser::logIn("nurse", "qwe123");
      $response = $this->call('GET', 'nurse/prescriptions');
  		$this->assertEquals(200, $response->getStatusCode());
      ParseUser::logOut();
  	}

}
