<?php

Route::post('/login', 'AuthController@login');
Route::post('/register', 'AuthController@register');

//Public Resources
Route::get('/specialties', 'SpecialtyController@index');
Route::get('/specialties/{specialty}/doctors', 'SpecialtyController@doctors');
Route::get('/schedule/hours', 'ScheduleController@hours');

Route::middleware('auth:api')->group( function(){
    Route::get('/user', 'UserController@show');
    Route::post('/user', 'UserController@update');


    Route::post('/logout', 'AuthController@logout');

    //apointments
    Route::post('/appointments', 'AppointmentController@store');
    Route::get('/appointments', 'AppointmentController@index');

    //FCM
    Route::post('/fcm/token', 'FirebaseController@postToken');
});


