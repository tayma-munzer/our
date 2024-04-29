<?php

namespace App\Http\Controllers;

use App\Http\Requests\addserviceRequest;
use App\Http\Requests\loginRequest;
use App\Http\Requests\addjobRequest;
use App\Models\services;
use App\Models\job;
use App\Http\Controllers\gets;
use App\Http\Requests\add_course_request;
use App\Http\Requests\add_cv_request;
use App\Http\Requests\add_education_request;
use App\Http\Requests\add_exp_request;
use App\Http\Requests\add_language_request;
use App\Http\Requests\add_media_request;
use App\Http\Requests\add_projects_request;
use App\Http\Requests\add_skill_request;
use App\Http\Requests\add_training_request;
use App\Http\Requests\addalt_serviceRequest;
use App\Http\Requests\deleteRequest;
use App\Http\Requests\discountRequest;
use App\Http\Requests\edit_profile_request;
use App\Http\Requests\get_type_service_request;
use App\Http\Requests\getsectype;
use App\Models\alt_services;
use App\Models\course;
use App\Models\cv;
use App\Models\cv_lang;
use App\Models\education;
use App\Models\experience;
use App\Models\media;
use App\Models\projects;
use App\Models\sec_type;
use App\Models\skills;
use App\Models\token;
use App\Models\training_courses;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class authenticationController extends Controller
{
    //done
    public function login(loginRequest $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email:rfc,dns',
            'password' => 'required|min:5',
        ], $messages = [
            'required' => 'The :attribute field is required.',
            'min:5'=> 'the :attribute field should be minimum 5 chars'
        ]);
        if ($validator->fails()){
            $errors = $validator->errors();
            return response($errors,402);
        }else{
        $user = User::where('email','=', $request->email)->first();
        if(empty($user) || !($request->password === $user->password)){
            return response([
                'message'=> 'username or password are wrong'
            ],422);
        }
        else
        $token = $user->createToken('apitoken')->plainTextToken;
        return response([
            'message'=> 'logged in',
            'token'=>$token,
        ],200);
    }
    }
//done
    public function sec_types (getsectype $request){
        $types = sec_type::where('t_id','=',$request->t_id);
        return $types->get() ;
    }

    // static public function getuser_id(string $token){
    //     $user_id = DB::table('personal_access_tokens')->where('token','=',$token);
    //     return $user_id;
    // }

// done 
    public function addservice(addserviceRequest $request){
        $validator = Validator::make($request->all(), [
            'service_name' => 'required|string',
            'service_price' => 'required|gte:50000',
            'service_desc' => 'required|string',
            'service_duration' => 'required|string',
            'service_sec_type' => 'required|exists:secondry_type,sec_type',
            'token'=>'required',
        ], $messages = [
            'required' => 'The :attribute field is required.',
            'gte:50000'=> 'the :attribute field should be minimum 50000',
            'string'=> 'the :attribute field should be string',
            'exists'=> 'the :attribute field should be exist',
            'integer'=>'the :attribute field should be integer ',
        ]);
        if ($validator->fails()){
            $errors = $validator->errors();
            return response($errors,402);
        }else{
        $user_token = token::where('token','=',$request->token)->first();
        $service = services::create([ 
        's_name' => $request->service_name,
        's_price' => $request->service_price,
        'num_of_buyers' => 0,
        's_desc' => $request->service_desc,
        's_duration' => $request->service_duration,
        'u_id'=> $user_token->tokenable_id ,
        'st_id'=>gets::sec_service_type_id($request->service_sec_type),
        's_img' => $request->img_path,
        'status' => 'pinding',
        'discount' => 0,
        ]);
        return response([
            'message'=> 'added successfully'
        ],200);   
    }   
    }
    // done 
    public function addalt_service(addalt_serviceRequest $request){
        $validator = Validator::make($request->all(), [
            's_id' => 'required|exists:services,s_id',
            'a_name' => 'required|string',
            'a_price' => 'required|gte:5000',
            'added_duration'=>'required|string'
        ], $messages = [
            'required' => 'The :attribute field is required.',
            'gte:5000'=> 'the :attribute field should be minimum 5000',
            'string'=> 'the :attribute field should be string',
            'exists'=> 'the :attribute field should be exist',
        ]);
        if ($validator->fails()){
            $errors = $validator->errors();
            return response($errors,402);
        }else{
        $alt_service = alt_services::create([ 
        's_id' => $request->s_id,
        'a_name' => $request->a_name,
        'a_price' => $request->a_price,
        'added_duration' => $request->added_duration,
        ]);
        return response([
            'message'=> 'added successfully'
        ],200); 
    } 
    }
// done 
    public function addjob (addjobRequest $request){
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'j_name' => 'required|string',
            'j_desc' => 'required|string',
            'j_sal' => 'required|integer',
            'j_req'=>'required|string',
        ], $messages = [
            'required' => 'The :attribute field is required.',
            'string'=> 'the :attribute field should be string',
            'exists'=> 'the :attribute field should be exist',
            'integer' => 'the :attribute field should be a number',
        ]);
        if ($validator->fails()){
            $errors = $validator->errors();
            return response($errors,402);
        }else{
        $user_token = token::where('token','=',$request->token)->first();
        $job = job::create([ 
        'u_id' => $user_token->tokenable_id,
        'j_name' => $request->j_name,
        'j_desc' => $request->j_desc,
        'j_sal' => $request->j_sal,
        'j_req' => $request->j_req,
        ]);
        return response([
            'message'=> 'added successfully'
        ],200);  
    }
    }
// not done yet 
    public function delete_account(deleteRequest $request){
        $request->validated();

        // deleting process 
    }
// done
    public function add_discount(discountRequest $request){
        $validator = Validator::make($request->all(), [
            's_id' => 'required|exists:services,s_id',
            'discount' => 'required|integer|gt:0|lte:100',
        ], $messages = [
            'required' => 'The :attribute field is required.',
            'gt'=> 'the :attribute field should be minimum 0.1',
            'exists'=> 'the :attribute field should be exist',
            'lte'=> 'the :attribute field should be maximum 100',
            'integer' => 'The :attribute field must be integer.',
        ]);
        if ($validator->fails()){
            $errors = $validator->errors();
            return response($errors,402);
        }else{
        $effected_rows=services::where('s_id','=',$request->s_id)->update(['discount'=>$request->discount]);
        if ($effected_rows!=0){
        return response([
            'message'=> 'updated successfully'
        ],200); }
        else {
            return response([
                'message'=> 'nothing is updated something went wrong'
            ],402);
        }
    } 
    }
// done
    public function delete_discount(discountRequest $request){
        $validator = Validator::make($request->all(), [
            's_id' => 'required|exists:services,s_id',
        ], $messages = [
            'required' => 'The :attribute field is required.',
            'exists'=> 'the :attribute field should be exist',
        ]);
        if ($validator->fails()){
            $errors = $validator->errors();
            return response($errors,402);
        }else{
        $effected_rows=services::where('s_id','=',$request->s_id)->update(['discount'=>0]);
        if ($effected_rows!=0){
        return response([
            'message'=> 'discount deleted successfully'
        ],200); }
        else {
            return response([
                'message'=> 'nothing is deleted something went wrong'
            ],402);
        }
    } 
    }
    // done
    public function get_type_services(get_type_service_request $request){
        $validator = Validator::make($request->all(), [
            'st_id' => 'required|integer',
        ], $messages = [
            'required' => 'The :attribute field is required.',
            'integer' => 'the :attribute field should be a number',
        ]);
        if ($validator->fails()){
            $errors = $validator->errors();
            return response($errors,402);
        }else{
            //$services =  services::where('st_id','=',$request->st_id);
            $services=services::all()->where('st_id','=',$request->st_id);
            return response($services,200);
        }
    }
    //done
    public function edit_profile(edit_profile_request $request){
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'age' => 'required|integer|gte:10',
            'u_desc' => 'required|string',
            'u_img' => 'required|string',
            'f_name' => 'required|string',
            'l_name' => 'required|string',
            'email' => 'required|email:rfc,dns',
            'password' => 'required|min:5',
            'username' => 'required|string',
        ], $messages = [
            'required' => 'The :attribute field is required.',
            'integer' => 'the :attribute field should be a number',
            'min:5'=> 'the :attribute field should be minimum 5 chars',
            'gte'=> 'the :attribute field should be minimum 10',
            'string'=> 'the :attribute field should be string',
        ]);
        if ($validator->fails()){
            $errors = $validator->errors();
            return response($errors,402);
        }else{
            $user_token = token::where('token','=',$request->token)->first();
            $effected_rows=User::where('u_id','=',$user_token->tokenable_id)->update(
                ['age'=>$request->age,
                'u_desc'=>$request->u_desc,
                'u_img'=>$request->u_img,
                'f_name'=>$request->f_name,
                'l_name'=>$request->l_name,
                'email'=>$request->email,
                'password'=>$request->password,
                'u_img'=>$request->u_img,
                'username'=>$request->username,
                ]
            );
            if ($effected_rows!=0){
            return response([
                'message'=> 'edit profile successfully'
            ],200); }
        else {
            return response([
                'message'=> 'nothing is edited something went wrong'
            ],402);
        }
    } 
    }
    //done
    public function add_course(add_course_request $request){
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'c_name' => 'required|string',
            'c_price' => 'required|integer|gte:50000',
            'c_img' => 'required|string',
            'c_desc' => 'required|string',
        ], $messages = [
            'required' => 'The :attribute field is required.',
            'integer' => 'the :attribute field should be a number',
            'gte'=> 'the :attribute field should be minimum 50000',
            'string'=> 'the :attribute field should be string',
        ]);
        if ($validator->fails()){
            $errors = $validator->errors();
            return response($errors,402);
        }else{
        $user_token = token::where('token','=',$request->token)->first();
        $job = course::create([ 
        'u_id' => $user_token->tokenable_id,
        'c_name' => $request->c_name,
        'c_desc' => $request->c_desc,
        'c_price' => $request->c_price,
        'c_img' => $request->c_img,
        ]);
        return response([
            'message'=> 'added successfully'
        ],200);  
    }
    }
    //done
    public function add_media(add_media_request $request){
        $validator = Validator::make($request->all(), [
            'c_id' => 'required|integer|exists:courses,c_id',
            'm_name' => 'required|string',
            'm_path' => 'required|string',
        ], $messages = [
            'required' => 'The :attribute field is required.',
            'string'=> 'the :attribute field should be string',
        ]);
        if ($validator->fails()){
            $errors = $validator->errors();
            return response($errors,402);
        }else{
        $job = media::create([ 
        'c_id' =>$request->c_id,
        'm_name' => $request->m_name,
        'm_path' => $request->m_path,
        ]);
        return response([
            'message'=> 'added successfully'
        ],200);  
    }
    }
    //done 
    public function add_cv(add_cv_request $request){
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'email' => 'required|email:rfc,dns',
            'phone' => 'required|numeric|min:10',
            'career_obj' => 'required|string',
            'address' => 'required|string',
        ], $messages = [
            'required' => 'The :attribute field is required.',
            'string'=> 'the :attribute field should be string',
            'integer' => 'the :attribute field should be a number',
            'min' => 'the :attribute field should be minimun 10 digits',
        ]);
        if ($validator->fails()){
            $errors = $validator->errors();
            return response($errors,402);
        }else{
        $user_token = token::where('token','=',$request->token)->first();
        $job = cv::create([ 
        'u_id' =>$user_token->tokenable_id,
        'email' => $request->email,
        'address' => $request->address,
        'phone'=>$request->phone,
        'career_obj'=>$request->career_obj,
        ]);
        return response([
            'message'=> 'added successfully'
        ],200);  
    }
    }
    //done 
    public function add_skills(add_skill_request $request){
        $validator = Validator::make($request->all(), [
            'cv_id' => 'required|integer|exists:cv,cv_id',
            's_name' => 'required|string',
            's_level' => 'required|string',
            'years_of_exp' => 'required|integer',
        ], $messages = [
            'required' => 'The :attribute field is required.',
            'string'=> 'the :attribute field should be string',
            'integer'=> 'the :attribute field should be integer',
            'exists'=> 'the :attribute field should be existed',
        ]);
        if ($validator->fails()){
            $errors = $validator->errors();
            return response($errors,402);
        }else{
        $job = skills::create([ 
        'cv_id' =>$request->cv_id,
        's_name' => $request->s_name,
        's_level' => $request->s_level,
        'years_of_exp' => $request->years_of_exp,
        ]);
        return response([
            'message'=> 'added successfully'
        ],200);  
    }
    }
    //done 
    public function add_language(add_language_request $request){
        $validator = Validator::make($request->all(), [
            'cv_id' => 'required|integer|exists:cv,cv_id',
            'l_id' => 'required|integer|exists:languages,l_id',
        ], $messages = [
            'required' => 'The :attribute field is required.',
            'integer'=> 'the :attribute field should be integer',
            'exists'=> 'the :attribute field should be existed',
        ]);
        if ($validator->fails()){
            $errors = $validator->errors();
            return response($errors,402);
        }else{
        $job = cv_lang::create([ 
        'cv_id' =>$request->cv_id,
        'l_id' => $request->l_id,
        ]);
        return response([
            'message'=> 'added successfully'
        ],200);  
    }
    }
    //done without testing
    public function add_projects(add_projects_request $request){
        $validator = Validator::make($request->all(), [
            'cv_id' => 'required|integer|exists:cv,cv_id',
            'p_name' => 'required|string',
            'p_desc' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'responsibilities' => 'required|string',
        ], $messages = [
            'required' => 'The :attribute field is required.',
            'string'=> 'the :attribute field should be string',
            'exists'=> 'the :attribute field should be existed',
            'date' => 'the :attribute field should be date',
        ]);
        if ($validator->fails()){
            $errors = $validator->errors();
            return response($errors,402);
        }else{
        $job = projects::create([ 
        'cv_id' =>$request->cv_id,
        'p_name' => $request->p_name,
        'p_desc' => $request->p_desc,
        'start_date' =>$request ->start_date,
        'end_date' =>$request ->end_date,
        'responsibilities' =>$request ->responsibilities,
        ]);
        return response([
            'message'=> 'added successfully'
        ],200);  
    }
    }
//done without testing
    public function add_exp(add_exp_request $request){
        $validator = Validator::make($request->all(), [
            'cv_id' => 'required|integer|exists:cv,cv_id',
            'position' => 'required|string',
            'company' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'responsibilities' => 'required|string',
        ], $messages = [
            'required' => 'The :attribute field is required.',
            'string'=> 'the :attribute field should be string',
            'exists'=> 'the :attribute field should be existed',
            'date' => 'the :attribute field should be date',
        ]);
        if ($validator->fails()){
            $errors = $validator->errors();
            return response($errors,402);
        }else{
        $job = experience::create([ 
        'cv_id' =>$request->cv_id,
        'position' => $request->position,
        'company' => $request->company,
        'start_date' =>$request ->start_date,
        'end_date' =>$request ->end_date,
        'responsibilities' =>$request ->responsibilities,
        ]);
        return response([
            'message'=> 'added successfully'
        ],200);  
    }
    }
    //done without testing
    public function add_training_courses(add_training_request $request){
        $validator = Validator::make($request->all(), [
            'cv_id' => 'required|integer|exists:cv,cv_id',
            'course_name' => 'required|string',
            'training_center' => 'required|string',
            'completion_date' => 'required|date',
        ], $messages = [
            'required' => 'The :attribute field is required.',
            'string'=> 'the :attribute field should be string',
            'exists'=> 'the :attribute field should be existed',
            'date' => 'the :attribute field should be date',
        ]);
        if ($validator->fails()){
            $errors = $validator->errors();
            return response($errors,402);
        }else{
        $job = training_courses::create([ 
        'cv_id' =>$request->cv_id,
        'course_name' => $request->course_name,
        'training_center' => $request->training_center,
        'completion_date' =>$request ->completion_date,
        ]);
        return response([
            'message'=> 'added successfully'
        ],200);  
    }
    }
    //done without testing
    public function add_education(add_education_request $request){
        $validator = Validator::make($request->all(), [
            'cv_id' => 'required|integer|exists:cv,cv_id',
            'degree' => 'required|string',
            'uni' => 'required|string',
            'field_of_study' => 'required|string',
            'grad_year' => 'required|integer',
            'gba' => 'required|float',
        ], $messages = [
            'required' => 'The :attribute field is required.',
            'string'=> 'the :attribute field should be string',
            'integer'=> 'the :attribute field should be integer',
            'float'=> 'the :attribute field should be float',
            'exists'=> 'the :attribute field should be existed',
            'date' => 'the :attribute field should be date',
        ]);
        if ($validator->fails()){
            $errors = $validator->errors();
            return response($errors,402);
        }else{
        $job = education::create([ 
        'cv_id' =>$request->cv_id,
        'degree' => $request->degree,
        'uni' => $request->uni,
        'grad_year' =>$request ->grad_year,
        'field_of_study' =>$request ->field_of_study,
        'gba' =>$request ->gba,
        ]);
        return response([
            'message'=> 'added successfully'
        ],200);  
    }
    }
    
    




    



    


}
