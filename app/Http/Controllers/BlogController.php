<?php namespace App\Http\Controllers;

use Config;
use Request;
use Input;
use Parse\ParseUser;
use Parse\ParseObject;
use Parse\ParseQuery;
use Parse\ParseClient;
use Parse\ParseFile;

class BlogController extends Controller {

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(Request $request)
   {
       $this->request = $request;
   }

	public function blog()
  {
    if ($currentUser = ParseUser::getCurrentUser())
    {
      if($currentUser->get("role") == Config::get("app.roles")[1])
      {
        return view('blog.create');
      }
    }
  }

	public function edit($id)
	{
		if ($currentUser = ParseUser::getCurrentUser())
		{
			$blog=$this->getBlog($id);
			if($currentUser->get("role") == Config::get("app.roles")[1] && $blog->get("doctor_id") == $currentUser->getObjectId() )
			{

				return view('blog.edit',
				[
					"blog" => $blog
				]
				);
			}
		}
	}

  public function all()
  {
    if ($currentUser = ParseUser::getCurrentUser())
    {
      if($currentUser->get("role") == Config::get("app.roles")[1])
      {
        $is_doctor = true;
        $doctor_id = $currentUser->getObjectId();
      }
      else
      {
        $is_doctor = false;
        $doctor_id = "";
      }
      $blogs = $this->getBlogs();
			$userquery = ParseUser::query();

      return view('blog.list',
      [
  			"is_doctor" => $is_doctor,
  			"doctor_id" => $doctor_id,
  			"blogs" => $blogs,
				"userquery" => $userquery
      ]);


    }
  }

  private function getBlogs()
	{
		$query = new ParseQuery("Blog");
    try {
		  return $query->find();
		} catch (ParseException $ex) {
			return null;
		}
	}

	private function getBlog($id)
	{
		$query = new ParseQuery("Blog");
    try {
		  return  $query->get($id);
		} catch (ParseException $ex) {
			return null;
		}
	}

	private function getImages($id)
	{
		$query = new ParseQuery("Blog_Image");
		$query->equalTo("blog_id", $id);
    try {
		  return $query->find();
		} catch (ParseException $ex) {
			return null;
		}
	}

	private function getDoctor($id)
	{
		$query = new ParseQuery("_User");
		try {
		  return $query->get($id);
		} catch (ParseException $ex) {
			return null;
		}
	}


	private function getComments($id)
	{
		$query = new ParseQuery("Blog_Comment");
		$query->equalTo("blog_id", $id);
		$query->descending("createdAt");
    try {
		  return $query->find();
		} catch (ParseException $ex) {
			return null;
		}
	}

	private function getComment($id)
	{
		$query = new ParseQuery("Blog_Comment");
    try {
			return $query->get($id);
		} catch (ParseException $ex) {
			return null;
		}
	}

  public function post()
  {
    if ($currentUser = ParseUser::getCurrentUser())
		{
			if($currentUser->get("role") != Config::get("app.roles")[1])
			{
        return redirect('/auth/login');
			}
    }

    $files = Request::file('images');
		$content = Request::input('content');
		$name = Request::input('name');

		$blog = new ParseObject("Blog");
    $blog->set("name", $name);
		$blog->set("content", $content);
    $blog->set("doctor_id", $currentUser->getObjectId() );

    try {
      $blog->save();
    } catch (ParseException $ex) {
			echo 'Failed to create new object, with error message: ' + $ex->getMessage();
    }

		if(is_null($files[0]))
		{
			return redirect('blogs');
		}

    foreach($files as $file) {
      $ext = $file->guessExtension();
  		$parsefile = ParseFile::createFromFile($file, "image.".$ext);
      $uploadedfile = new ParseObject("Blog_Image");
      $uploadedfile->set("image", $parsefile);
			$uploadedfile->set("blog_id", $blog->getObjectId());
      try {
        $uploadedfile->save();
      } catch (ParseException $ex) {
  			echo 'Failed to create new object, with error message: ' + $ex->getMessage();
      }
    }

    return redirect('/blogs');

  }

	public function update($id)
  {
    if ($currentUser = ParseUser::getCurrentUser())
		{
			if($currentUser->get("role") != Config::get("app.roles")[1])
			{
        return redirect('/auth/login');
			}
    }

    $files = Request::file('images');
		$content = Request::input('content');
		$name = Request::input('name');

		$blog = $this->getBlog($id);

		if($blog->get('doctor_id') != $currentUser->getObjectId())
		{
			return redirect('/home');
		}

    $blog->set("name", $name);
		$blog->set("content", $content);

    try {
      $blog->save();
    } catch (ParseException $ex) {
			echo 'Failed to create new object, with error message: ' + $ex->getMessage();
    }

		if(is_null($files[0]))
		{
			return redirect('blog/'.$blog->getObjectId());
		}

    foreach($files as $file) {
      $ext = $file->guessExtension();
  		$parsefile = ParseFile::createFromFile($file, "image.".$ext);
      $uploadedfile = new ParseObject("Blog_Image");
      $uploadedfile->set("image", $parsefile);
			$uploadedfile->set("blog_id", $blog->getObjectId());
      try {
        $uploadedfile->save();
      } catch (ParseException $ex) {
  			echo 'Failed to create new object, with error message: ' + $ex->getMessage();
      }
    }

    return redirect('blog/'.$blog->getObjectId());

  }

	public function view($id)
	{
		if (!$currentUser = ParseUser::getCurrentUser())
		{
			return redirect('/auth/login');
		}

		$blog = $this->getBlog($id);
		$images = $this->getImages($id);
		$comments = $this->getComments($id);
		$doctor = $this->getDoctor($blog->get('doctor_id'));
		$userquery = ParseUser::query();

		if(!is_null($doctor->get("dp")))
		{
			$url = $doctor->get("dp")->getURL();
		}
		else
		{
			$url = null;
		}

		return view('blog.view',
		[
			"blog" => $blog,
			"images" => $images,
			"doctor" => $doctor,
			"comments" => $comments,
			"url" => $url,
			"userquery" => $userquery,
			"user" => $currentUser
		]);

	}

	public function addcomment($id)
	{
		if (!$currentUser = ParseUser::getCurrentUser())
		{
			return redirect('/auth/login');
		}
		$comment = Request::input('comment');

		$blog_comment = new ParseObject("Blog_Comment");
    $blog_comment->set("user_id", $currentUser->getObjectId());
		$blog_comment->set("blog_id", $id);
		$blog_comment->set("comment", $comment);

    try {
      $blog_comment->save();
    } catch (ParseException $ex) {
			echo 'Failed to create new object, with error message: ' + $ex->getMessage();
    }

		return redirect('blog/'.$id);

	}

	public function deletecomment($id)
	{
		if (!$currentUser = ParseUser::getCurrentUser())
		{
			return redirect('/auth/login');
		}
		$comment = $this->getComment($id);
		if ($currentUser->getObjectId() != $comment->get('user_id') )
		{
			return redirect('/auth/login');
		}
		else
		{
			$comment->destroy();
		}
		return redirect('blog/'.$comment->get('blog_id'));
	}

	public function delete($id)
	{
		if (!$currentUser = ParseUser::getCurrentUser())
		{
			return redirect('/auth/login');
		}
		$blog = $this->getBlog($id);
		if ($currentUser->getObjectId() != $blog->get('doctor_id') )
		{
			return redirect('/auth/login');
		}
		else
		{
			$blog->destroy();
		}
		return redirect('blogs');
	}

}
