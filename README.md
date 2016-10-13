
# Medicalize

: Medical Record System Software(MRSS)

- Medicalize is the most enhanced easy-to-use yet powerful software application which enables and speeds up the doctor's interaction with the patients, which helps to go paperless and is fully automated ensuring better care for patients.  

- MRSS is HIPAA compliant software application that simplifies the way patient’s charts are managed in the doctor's office.  
- Benefits of MRSS Software are:
a. Enable the reduction of the number of charts and filing cabinets in a doctor’s office.
b. Physicians can spend more time with their patients and less time on documentation.  
c. Can help reduce errors through better documentation and alerts. MRSS eliminates the task of looking for filing charts. 
d. Can help physician’s speed up medication refills. 
e. Aid in the management of reports and images such as doctor reports, labs, x-rays etc.
f. Provide for secure data due to HIPAA laws; only doctors and patients can access specific patient information.


# Installation
 Requirements: 

- Framework: Laravel  
- [PHP](http://php.net/) and [Composer](https://getcomposer.org/) (dependency manager for PHP)
.
- Clone this project from [GitHub](https://github.com/melinapaul/mrss).  
```cd``` into the root of the project folder and run
```composer install```  


- Use a web server like Apache to serve the application. 
- The root of the web application should be the ```/public/``` folder of the project. 
- Alternatively you can use Laravel's built in server to run the application. To use the built in server, run the command ```php artisan serve``` from the root of the project.




# Testing


- Tools: Selenium Webriver for Black box testing.
- To run tests, run the command ```./vendor/bin/phpunit``` from the root of the project for white box/ unit testing.
- 
Note: You might need to comment out the line ```session_start();``` from the file ```/bootstrap/app.php``` while running the tests.



- Official Laravel Documentation

Documentation for the framework can be found on the [Laravel website](http://laravel.com/docs).


-------------------------------------------------

> Amruta Ghangale

  > Melina Devaraj