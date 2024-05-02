<?php

use App\Http\Controllers\authenticationController;
use App\Http\Controllers\gets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('/login',[authenticationController::class,'login']);//added
Route::get('/getservices',[gets::class,'services']);
Route::get('/getfirst_type',[gets::class,'first_types']);//added
Route::post('/getsec_type',[authenticationController::class,'sec_types']);//added
Route::post('/addalt_service',[authenticationController::class,'addalt_service']); //added
Route::get('/getlanguages',[gets::class,'languages']);
Route::get('/getroles/{u_id}',[gets::class,'user_role']);
Route::post('/addjob',[authenticationController::class,'addjob']); //added
Route::post('/addservice',[authenticationController::class,'addservice']); //added
Route::get('/getsec_types',[gets::class,'sec_types']); // added
Route::post('/get_type_services',[authenticationController::class,'get_type_services']); //added
Route::post('/add_discount',[authenticationController::class,'add_discount']);//added 
Route::post('/edit_discount',[authenticationController::class,'add_discount']);//added
Route::post('/delete_discount',[authenticationController::class,'delete_discount']);//added
Route::post('/edit_profile',[authenticationController::class,'edit_profile']);//added
Route::post('/add_course',[authenticationController::class,'add_course']);//added
Route::post('/add_media',[authenticationController::class,'add_media']);//added
Route::post('/add_cv',[authenticationController::class,'add_cv']);//added
Route::post('/add_skills',[authenticationController::class,'add_skills']);//added
Route::post('/add_language',[authenticationController::class,'add_language']);//added
Route::post('/add_projects',[authenticationController::class,'add_projects']);//added
Route::post('/add_exp',[authenticationController::class,'add_exp']);//added
Route::post('/add_training_courses',[authenticationController::class,'add_training_courses']);//added
Route::post('/add_education',[authenticationController::class,'add_education']);//added
Route::post('/edit_job',[authenticationController::class,'edit_job']);//added
Route::post('/edit_media',[authenticationController::class,'edit_media']);//added
Route::post('/edit_service',[authenticationController::class,'edit_service']);//added
Route::post('/edit_cv',[authenticationController::class,'edit_cv']);//added
Route::post('/delete_job',[authenticationController::class,'delete_job']);//added
Route::post('/delete_service',[authenticationController::class,'delete_service']);//added
Route::post('/delete_media',[authenticationController::class,'delete_media']);//added
Route::get('/get_all_jobs',[gets::class,'get_all_jobs']);//added
Route::post('/get_job',[authenticationController::class,'get_job']);//added
Route::post('/get_media',[authenticationController::class,'get_media']);//added
Route::post('/get_all_media',[authenticationController::class,'get_all_media']);//added
Route::post('/get_service',[authenticationController::class,'get_service']);//added
Route::post('/get_all_cv',[authenticationController::class,'get_all_cv']);
Route::post('/delete_all_cv',[authenticationController::class,'delete_all_cv']);
Route::post('/get_cv_projects',[authenticationController::class,'get_projects']);
Route::post('/get_cv_languages',[authenticationController::class,'get_languages']);
Route::post('/get_cv_skills',[authenticationController::class,'get_skills']);
Route::post('/get_all_alt_services',[authenticationController::class,'get_all_alt_services']);
Route::post('/delete_project',[authenticationController::class,'delete_project']);
Route::post('/delete_cv_language',[authenticationController::class,'delete_cv_language']);
Route::post('/delete_skill',[authenticationController::class,'delete_skill']);
Route::post('/delete_alt_service',[authenticationController::class,'delete_alt_service']);
Route::post('/edit_experience',[authenticationController::class,'edit_experience']);
Route::post('/edit_projects',[authenticationController::class,'edit_projects']);
Route::post('/edit_language',[authenticationController::class,'edit_language']);
Route::post('/edit_skills',[authenticationController::class,'edit_skills']);
Route::post('/edit_alt_service',[authenticationController::class,'edit_alt_service']);


