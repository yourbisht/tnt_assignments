@extends('layouts.app')
@section('content')
<input type="hidden" id="isLoggedIn" name="isLoggedIn" value="{{Auth::check()?true:false}}">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header font-weight-bold">{{ __('JobSeekers List') }}</div>
                <div class="card-body">
                    <div class="form-group pull-right ml-2 mt-1">
                      @guest
                      @else
                      <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#jobSeekerModal"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add JobSeeker</button>
                      @endif
                    </div>
                    <div class="form-group pull-right">
                      <select class="form-control  pull-right" id="selectLocation" name="selectLocation">
                      </select>
                    </div>      
                    <table class="table table-bordered">
                        <thead class="thead-dark">
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Job Title</th>
                            <th scope="col">Location</th>
                            <th scope="col">Email</th>
                            <th scope="col">Phone Number</th>
                            <th scope="col">Action</th>
                          </tr>
                        </thead>
                        <tbody id="jobListTR">
                          <tr>
                            <td colspan="8" class="text-center"><img src="/img/ajax-loader.gif"></td>
                          </tr>
                        </tbody>
                    </table>
                    <nav aria-label="..." class="float-right" id="paginationNav">
                      <ul class="pagination" id="paginationUL"> </ul>     
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="jobSeekerModal" tabindex="-1" aria-labelledby="jobSeekerModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content" style="height: 530px; overflow-y:scroll;">
      <div class="modal-header">
        <h5 class="modal-title font-weight-bold" id="jobSeekerModalLabel">Add JobSeeker</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="alert alert-success d-none" role="alert" id="successMsg"></div>
        <form name="jobseekerForm" id="jobseekerForm" enctype="multipart/form-data">
          @csrf
          <input type="hidden" name="job_id" id="job_id">
          <div class="form-group">
            <label for="jobseeker_name">Name</label>
            <input type="text" class="form-control textOnly" id="jobseeker_name" placeholder="Name" name="name">
            <span class="text-danger hide" id="nameError"></span>
          </div>
          <div class="form-group">
            <label for="jobseeker_title">Title</label>
            <input type="text" class="form-control textOnly" id="jobseeker_title" placeholder="Title" name="title">
            <span class="text-danger hide" id="titleError"></span>
          </div>
          <div class="form-group">
            <label for="jobseeker_email">Email</label>
            <input type="email" class="form-control" id="jobseeker_email" placeholder="Email" name="email">
            <span class="text-danger hide" id="emailError"></span>
          </div>
          <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" rows="2" name="description"></textarea>
            <span class="text-danger hide" id="descriptionError"></span>
          </div>
          <div class="form-group">
            <label for="location">Location</label>
            <select class="form-control" id="location" name="location">
              @foreach ($data as $item)
                <option value="{{$item['id']}}">{{$item['location_name']}}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="phone_number">Phone Number</label>
            <input type="text" class="form-control numberOnly" id="phone_number" placeholder="Phone Number" name="phone_number">
            <span class="text-danger hide" id="phoneError"></span>
          </div>
          <div class="form-group">
            <label for="exampleFormControlFile1">Profile Photo</label>
            <input type="file" class="form-control-file" id="profile_photo" name="profile_photo"> <span id="profilePhotoEditDiv" class="my-1"></span>
            <span class="text-danger hide" id="profileError"></span>
          </div>
          {{-- <div class="form-group">
            <label for="exampleFormControlFile1">Gallery Photo</label>
            <input type="file" class="form-control-file" id="gallery_photo" name="gallery_photo" multiple="multiple">
            <span class="text-danger hide" id="galleryError"></span>
          </div> --}}
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="saveJobSeekerBtn">Save</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">Delete Record</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="alert alert-success d-none" role="alert" id="successDeleteMsg"></div>
        <form name="deleteForm" id="deleteForm" enctype="multipart/form-data">
          @csrf
          <input type="hidden" id="jobId" name="job_id">
          Are you sure to delete this record?
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-danger" id="deleteJob">Delete</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="jobSeekerViewModal" tabindex="-1" aria-labelledby="jobSeekerViewModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title font-weight-bold" id="jobSeekerViewModalLabel">View JobSeeker Info</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group row">
            <label for="staticEmail" class="col-sm-4 col-form-label">Name</label>
            <div class="col-sm-2"> - </div>
            <div class="col-sm-6">
              <input type="text" readonly class="form-control-plaintext" id="job_name">
            </div>
          </div>
          <div class="form-group row">
            <label for="staticEmail" class="col-sm-4 col-form-label">Title</label>
            <div class="col-sm-2"> - </div>
            <div class="col-sm-6">
              <input type="text" readonly class="form-control-plaintext" id="job_title">
            </div>
          </div>
          <div class="form-group row">
            <label for="staticEmail" class="col-sm-4 col-form-label">Email</label>
            <div class="col-sm-2"> - </div>
            <div class="col-sm-6">
              <input type="text" readonly class="form-control-plaintext" id="job_email">
            </div>
          </div>
          <div class="form-group row">
            <label for="staticEmail" class="col-sm-4 col-form-label">Description</label>
            <div class="col-sm-2"> - </div>
            <div class="col-sm-6">
              <input type="text" readonly class="form-control-plaintext" id="job_description">
            </div>
          </div>
          <div class="form-group row">
            <label for="staticEmail" class="col-sm-4 col-form-label">Location</label>
            <div class="col-sm-2"> - </div>
            <div class="col-sm-6">
              <input type="text" readonly class="form-control-plaintext" id="job_location">
            </div>
          </div>
          <div class="form-group row">
            <label for="staticEmail" class="col-sm-4 col-form-label">Phone Number</label>
            <div class="col-sm-2"> - </div>
            <div class="col-sm-6">
              <input type="text" readonly class="form-control-plaintext" id="job_phone">
            </div>
          </div>
          <div class="form-group row">
            <label for="staticEmail" class="col-sm-4 col-form-label">Profile Phone</label>
            <div class="col-sm-2"> - </div>
            <div class="col-sm-6" id="profilePhotoDiv">
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
@stop
@section('scripts')
<script src="/js/jobseeker.js"></script>
@stop