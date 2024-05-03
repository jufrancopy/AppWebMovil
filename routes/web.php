<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    // return view('welcome');
    return redirect()->route('login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware(['auth', 'admin'])->namespace('Admin')->group(function () {
    // Speciality
    Route::get('/specialties', 'SpecialtyController@index');
    Route::get('/specialties/create', 'SpecialtyController@create'); //form register
    Route::get('/specialties/{specialty}/edit', 'SpecialtyController@edit');
    Route::post('/specialties', 'SpecialtyController@store'); //
    Route::put('/specialties/{specialty}', 'SpecialtyController@update');
    Route::delete('/specialties/{specialty}', 'SpecialtyController@destroy');

    //Doctors
    Route::resource('doctors', 'DoctorController');
    Route::get('doctor/{id}/schedule', 'DoctorController@showHours')->name('asignHour');

    //Schedule
    Route::get('/schedule', 'ScheduleController@edit');
    Route::post('/schedule', 'ScheduleController@store');

    //Patients
    Route::resource('patients', 'PatientController');

    //Charts
    Route::get('/charts/appoinments/line', 'ChartController@appointments');
    Route::get('/charts/doctors/column', 'ChartController@doctorAppointments');
    Route::get('/charts/doctors/column/data', 'ChartController@doctorAppointmentsJson');

    //Studies
    Route::resource('studies', 'StudyController');
    Route::get('studies/{study}/confirmDelete', 'StudyController@confirmDelete')->name('studies.confirmDelete');
    Route::put('studies/{stuty}/restore', 'StudyController@restore')->name('studies.restore');
    //
    Route::resource('items', 'ItemController');
    Route::get('items/{item}/confirmDelete', 'ItemController@confirmDelete')->name('items.confirmDelete');
    Route::put('items/{item}/restore', 'ItemController@restore')->name('items.restore');

    
    Route::resource('form-templates', 'FormTemplateController');
    Route::get('form-templates/{formTemplate}/confirmDelete', 'FormTemplateController@confirmDelete')->name('form-templates.confirmDelete');
    Route::put('form-templates/{formTemplate}/restore', 'FormTemplateController@restore')->name('form-templates.restore');

    Route::resource('form-fields', 'FormFieldController');
    Route::get('form-fields/{formField}/confirmDelete', 'FormFieldController@confirmDelete')->name('form-fields.confirmDelete');
    Route::put('form-fields/{formField}/restore', 'FormFieldController@restore')->name('form-fields.restore');

    Route::view('odontogram', 'admin.odontograma.index')->name('odontogram');

});

// Route::middleware(['auth', 'doctor'])->namespace('Doctor')->group(function () {
//     //Agendamientos
//     Route::get('/schedule', 'ScheduleController@edit');
//     Route::post('/schedule', 'ScheduleController@store');
// });

Route::middleware('auth')->group(function () {
    Route::get('/appointments/create', 'AppointmentController@create')->name('appointments.create');
    Route::post('/appointments', 'AppointmentController@store');

    Route::get('/appointments', 'AppointmentController@index')->name('appointments.index');
    Route::get('/appointments/{appointment}', 'AppointmentController@show');
    Route::get('/appointments/{appointment}/cancel', 'AppointmentController@showCancelForm');
    Route::post('/appointments/{appointment}/cancel', 'AppointmentController@postCancel');
    Route::post('/appointments/{appointment}/confirm', 'AppointmentController@postConfirm');

    // Json
    Route::get('/specialties/{specialty}/doctors', 'Api\SpecialtyController@doctors');
    Route::get('/schedule/hours', 'Api\ScheduleController@hours');
});
