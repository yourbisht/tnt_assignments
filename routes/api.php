<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/job-seeker/post-data', 'JobSeekerController@postData')->name('postData');
Route::get('/job-seekers/list/{job_id?}', 'JobSeekerController@listData')->name('listData');
Route::get('/locations/list/{loc_id?}', 'JobSeekerController@locationListData')->name('locationListData');
Route::post('/job-seeker/delete-data', 'JobSeekerController@deleteJobSeekerRecord')->name('deleteRecord');
//Route::get('/job-seekers/loc-basis-list/{loc_id?}', 'JobSeekerController@locBasisData')->name('locBasisData');