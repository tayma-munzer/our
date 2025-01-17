<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\course;
use App\Models\job;
use App\Models\services;
use App\Models\training_courses;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AdminDashboardController extends Controller
{
    public function get_complaints(): JsonResponse
    {
        $complaints = Complaint::with(['user','complainable'])->get();
        return response()->json([
            "complaints" => $complaints
        ]);
    }

     public function accept_job($id): JsonResponse
     {
         $job = job::findOrFail($id);
         $job->update([
             'is_accepted' => true
         ]);
         return response()->json([
             'message' => "accepted job successfully"
         ]);
     }
     public function reject_job($id): JsonResponse
     {
         $job = job::findOrFail($id);
         $job->delete();
         return response()->json([
             'message' => "rejected job successfully"
         ]);
     }
    public function accept_course($id): JsonResponse
    {
        $course = course::findOrFail($id);
        $course->update([
            'is_accepted' => true
        ]);
        return response()->json([
            'message' => "accepted course successfully"
        ]);
    }
    public function reject_course($id): JsonResponse
    {
        $course = course::findOrFail($id);
        $course->delete();
        return response()->json([
            'message' => "rejected course successfully"
        ]);
    }

   public function accept_service($id): JsonResponse
   {
       $service = services::findOrFail($id);
       $service->update([
           'status' =>"approved"
       ]);
       return response()->json([
           'message' => "accepted service successfully"
       ]);
   }
   public function reject_service($id): JsonResponse
   {
       $service = services::findOrFail($id);
       $service->delete();
       return response()->json([
           'message' => "rejected service successfully"
       ]);
   }

    public function get_profiles(): JsonResponse
    {
        $users = User::with('cv.cvLangs.language', 'cv.education', 'cv.experiences', 'cv.projects', 'cv.skills')->get();
        return response()->json($users);
    }


    public function get_profits(): JsonResponse
    {
        $totalProfitServices = DB::table('services')
            ->where('status', "approved")
            ->select(DB::raw('SUM(s_price * num_of_buyers) as total_profit'))
            ->first()
            ->total_profit;
        return response()->json([
            "total_profit" => $totalProfitServices
        ]);
    }
    public function delete_user($id): JsonResponse
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(['message'=>"deleted user successfully"]);
    }

    public function get_courses_count($id): JsonResponse
    {
        $user = User::findOrFail($id);
        $count = $user->courses()->count();
        return response()->json(['courses_count'=>$count]);
    }
    public function get_services_count($id): JsonResponse
    {
        $user = User::findOrFail($id);
        $count = $user->services()->count();
        return response()->json(['services_count'=>$count]);
    }
    public function get_jobs_count($id): JsonResponse
    {
        $user = User::findOrFail($id);
        $count = $user->jobs()->count();
        return response()->json(['jobs_count'=>$count]);
    }
    public function get_service_requests(): JsonResponse
    {
        $services = services::with('user')->where('status', 'pinding')->get();
        return response()->json(['services'=>$services]);
    }
    
    public function get_course_user($id): JsonResponse
    {
        $user = User::findOrFail($id);
        $courses=$user->courses;
        return response()->json ($courses) ;
    }

    public function get_service_user($id): JsonResponse
    {
        $user = User::findOrFail($id);
        $services=$user->services;
        return response()->json ($services) ;
    }

    public function get_job_user($id): JsonResponse
    {
        $user = User::findOrFail($id);
        $jobs=$user->jobs;
        return response()->json ($jobs) ;
    }
    
}
