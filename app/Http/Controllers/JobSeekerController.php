<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobseekers;
use App\Locations;
use Response as Res;
use Validator;
use Auth;

class JobSeekerController extends Controller
{
    public function __construct()
    {
        $this->location = new Locations();
        $this->jobseeker = new Jobseekers();
    }
    public function index(Request $request){
        
        $data = $this->location->getActiveLocationRecords();
        //echo '<pre>';print_r($data);exit;
        return view('jobseekers.list',['data' => $data]);
    }
    public function postData(Request $request){
        if($request->job_id > 0){
            $rules = array (
                'email' => 'required|email|unique:jobseekers,email,'.$request->job_id
            ); 
        }else{
            $rules = array (
                'email' => 'required|email|unique:jobseekers'
            );
        }
        
        $validator = Validator::make($request->all(), $rules);
        $messages = $validator->messages();
        if ($validator-> fails()){
            foreach ($messages->all() as $message)
            {
                return response()->json([
                    'status' => 'error',
                    'status_code' => 400,
                    'message' => $message
                ]);
            }
        }else{
            if($request->job_id > 0){
                $jobseeker = Jobseekers::find($request->job_id);
                $message = 'Job Seeker Info Updated Successfully !';
            }else{
                $jobseeker = new Jobseekers();
                $message = 'Job Seeker Added Successfully !';
            }
            //Upload Profile Img
            $profile_photo = $request->file('profile_photo');
            
            if($profile_photo != null){
                $fileExtension = $profile_photo->getClientOriginalExtension();
                $image_name = time().'.'.$fileExtension;

                $destinationPath = public_path() . '/uploads/';
                if (!is_dir($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }
                $profile_photo->move($destinationPath, $image_name);
                $jobseeker->profile_photo = $image_name;
            }
            
            //Upload Profile Img
            $jobseeker->name = $request->name;
            $jobseeker->job_title = $request->title;
            $jobseeker->email = $request->email;
            $jobseeker->location = $request->location;
            $jobseeker->description = $request->description;
            $jobseeker->phone_number = $request->phone_number;
            
            $jobseeker->save();
            return response()->json([
                'status'   =>  'success',
                'message'   =>  $message,
                'status_code' => 200,
            ]);
        }
    }
    public function listData(Request $request){
        $jobId = $request->job_id?base64_decode($request->job_id):'';
        $locId = $request->loc_id?$request->loc_id:'';
        $data = $this->jobseeker->getActiveRecords($jobId, $locId);
 
        return response()->json([
            'status' =>  'success',
            'data' =>  $data,
            'status_code' => 200,
        ]);
    }
    public function locationListData(Request $request){
        $locId = $request->loc_id?$request->loc_id:'';
       
        $data = $this->location->getActiveLocationRecords($locId);
        return response()->json([
            'status' =>  'success',
            'data' =>  $data,
            'status_code' => 200,
        ]);
    }
    public function deleteJobSeekerRecord(Request $request){
        $this->jobseeker->deleteRecord($request->job_id);
        return response()->json([
            'status' =>  'success',
            'message' =>  'Record Deleted Successfully !!',
            'status_code' => 200,
        ]);
    }
    // public function locBasisData(Request $request){
    //     $locId = $request->loc_id?base64_decode($request->loc_id):'';
       
    //     $data = $this->jobseeker->getActiveRecords('',$locId);
 
    //     return response()->json([
    //         'status' =>  'success',
    //         'data' =>  $data,
    //         'status_code' => 200,
    //     ]);
    // }
}
