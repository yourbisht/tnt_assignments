<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Locations extends Model
{
    protected $table = 'locations';
    public function getActiveLocationRecords($id=''){
        return $this->where('status', '1')
                    ->where(function ($query) use ($id) {
                        if($id > 0){
                            $query->where('id', $id);
                        }
                    })
                    ->select('locations.id', 'locations.location_name')
            ->get()
            ->toArray();
    }
    public function jobSeekers(){
        return $this->belongsTo('App\Jobseekers','id','location');
    }
}
