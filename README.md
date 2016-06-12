##Medicalize

###About
Class project for CPSC 542, California State University, Fullerton.
Medicalize  is the most enhanced technique which enables the users(patients) to easily make appointments with the doctor’s and obtain best treatment.  
>Melina Devaraj &  Amruta Ghangale

###Installation
Requirements: [PHP](http://php.net/) and [Composer](https://getcomposer.org/) (dependency manager for PHP)
Clone this project from [GitHub](https://github.com/melinapaul/mrss).  
```cd``` into the root of the project folder and run
```composer install```  

Use a web server like Apache to serve the application. The root of the web application should be the ```/public/``` folder of the project. Alternatively you can use Laravel's built in server to run the application. To use the built in server, run the command ```php artisan serve``` from the root of the project.


###Testing
To run tests, run the command ```./vendor/bin/phpunit``` from the root of the project.  
Note: You might need to comment out the line ```session_start();``` from the file ```/bootstrap/app.php``` while running the tests.



### Official Laravel Documentation

Documentation for the framework can be found on the [Laravel website](http://laravel.com/docs).
