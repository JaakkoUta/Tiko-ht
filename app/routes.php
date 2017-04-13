<?php

$router->get('/', 'HomeController@index');

$router->get('/student-login', 'StudentController@create');
$router->post('/student-login', 'StudentController@save');
$router->get('/logout', 'StudentController@destroy');

$router->get('/teacher-login', 'TeacherController@create');
$router->post('/teacher-login', 'TeacherController@save');

$router->get('/student-registration', 'DevController@create');
$router->post('/student-registration', 'DevController@save');
$router->get('/teacher-registration', 'DevController@create2');
$router->post('/teacher-registration', 'DevController@save2');