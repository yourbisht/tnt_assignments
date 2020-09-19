<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jobseekers extends Model
{
    protected $table = 'jobseekers';
    public function getActiveRecords($job_id='', $loc_id = ''){
        $data = $this->where('jobseekers.status', '1')
                    ->where(function ($query) use ($job_id) {
                        if($job_id > 0){
                            $query->where('jobseekers.id', $job_id);
                        }
                    })
                    ->where(function ($query) use ($loc_id) {
                        if($loc_id > 0){
                            $query->where('jobseekers.location', $loc_id);
                        }
                    })                    
                    ->join('locations', 'Locations.id', 'jobseekers.location')
                    ->select('jobseekers.id', 'jobseekers.name', 'jobseekers.job_title', 'jobseekers.email', 'jobseekers.location',  'jobseekers.phone_number', 'jobseekers.description', 'jobseekers.status', 'locations.location_name', 'jobseekers.profile_photo');
            if($job_id > 0){
                $result = $data->get()
                ->toArray();
            }else{
                $result = $data->paginate(2);
            }
        return $result;
    }
    public function locations(){
        return $this->hasMany('App\Locations', 'location', 'id');
    }
    public function deleteRecord($job_id){
        $this->where(['id' => $job_id])->update(['status' => 0, 'updated_at' => date('Y-m-d H:i:s')]);
    }
}
