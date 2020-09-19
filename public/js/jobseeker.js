$( document ).ready(function() {
  $("li").click(function () {
    $('li > div').not($(this).children("div").toggle()).hide();
  });
  $("#jobSeekerModal").on("hidden.bs.modal", () => {
    $('.form-control').val('');
    $("#description").text('');
    $("#location").val(1).trigger("change");
    $("#profilePhotoEditDiv").html('');
  });
  getLocationList()
  //Fetch Location Data
  //Fetch Job Seeker Data
  getJobSeekerList();
  //Fetch Job Seeker Data
    $('.textOnly').keypress(function (e) { 
      var regex = new RegExp("^[a-zA-Z ]+$");
      var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
			if (regex.test(str)) {
				return true;
			}else{
        e.preventDefault();
        return false;
			}
    });
    $('.numberOnly').keypress(function (e) { 
      var regex = new RegExp("^[0-9]+$");
      var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
			if (regex.test(str)) {
				return true;
			}else{
        e.preventDefault();
        return false;
			}
    });
    $("#saveJobSeekerBtn").click(function(){
        var jobseeker_name = $("#jobseeker_name").val();
        var jobseeker_title = $("#jobseeker_title").val();
        var jobseeker_email = $("#jobseeker_email").val();
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        var flag = true;
        var formData = new FormData($("#jobseekerForm")[0]);
        var fileExtension = $("#profile_photo").val().split('.').pop().toLowerCase();
        var extensions = ['jpeg', 'jpg', 'png', 'gif', 'bmp'];


        if($.trim(jobseeker_name) == ''){
          $("#nameError").html('Please enter jobseeker name').removeClass('hide');
          $("#jobseeker_name").focus();
          commonSetTimeOut('nameError');
          flag = false;
        }
        if($.trim(jobseeker_title) == ''){
          $("#titleError").html('Please enter jobseeker title').removeClass('hide');
          $("#jobseeker_title").focus();
          commonSetTimeOut('titleError');
          flag = false;
        }
        if($.trim(jobseeker_email) == ''){
          $("#emailError").html('Please enter jobseeker email').removeClass('hide');
          $("#jobseeker_email").focus();
          commonSetTimeOut('emailError');
          flag = false;
        }
        if($.trim(jobseeker_email) !=''){
          if(!regex.test(jobseeker_email)){
            $("#emailError").html('Please enter a valid email').removeClass('hide').focus();
            commonSetTimeOut('emailError');
            flag = false;
          }
        }
        if(fileExtension){
          if($.inArray(fileExtension, extensions) == -1){
            $("#profileError").html("Only formats are allowed : "+extensions.join(', ')).removeClass('hide');
            commonSetTimeOut('profileError');
            flag = false;
          }
        }        
        if(flag){
          $.ajax({
              url: '/api/job-seeker/post-data',
              dataType: 'json',
              type: 'post',
              data: formData,
              success: function (result){
                  if(result.status == 'error'){
                      $("#emailError").html(result.message).removeClass('hide');
                      commonSetTimeOut('emailError');
                  }
                  if(result.status == 'success'){
                      $("#successMsg").html(result.message).removeClass('d-none');
                      commonSetTimeOut('successMsg');
                      $('#jobSeekerModal').modal('hide');
                      getJobSeekerList();                      
                  }
              },
              cache: false,
              contentType: false,
              processData: false,
              encode  : true
          });
        }
    });
});
function commonSetTimeOut(uiAccessId){
  setTimeout(function () {
    if(uiAccessId == 'successMsg'){
      $('#'+uiAccessId).html('').addClass('d-none');
    }else{
      $('#'+uiAccessId).html('').addClass('hide');
    }
  }, 3000);
}
function getJobSeekerList(page_number=1, job_id='',callFrom='',loc_id=''){
  if(loc_id){
    loc_id = '&loc_id='+loc_id;
  }
  $.ajax({
    url: '/api/job-seekers/list/'+btoa(job_id)+'?page='+page_number+loc_id,
    dataType: 'json',
    type: 'get',
    success: function (result){
        if(result.status == 'success'){
          //console.log(result.data.length);
          if(result.data.length == 1){
            var resultSet = result.data[0];
            if(callFrom == 'edit'){
              $('#jobSeekerModal').modal('show');
              $("#job_id").val(resultSet.id);
              $("#jobseeker_name").val(resultSet.name);
              $("#jobseeker_title").val(resultSet.job_title);
              $("#jobseeker_email").val(resultSet.email);
              $("#description").text(resultSet.description);
              $("#description").val(resultSet.description);
              $("#location").val(resultSet.location).trigger("change");
              $("#phone_number").val(resultSet.phone_number);
              if(resultSet.profile_photo != null){
                $("#profilePhotoEditDiv").html('<img src="/uploads/'+resultSet.profile_photo+'" width="120" >');
              }else{
                $("#profilePhotoEditDiv").html('');
              }
              $("#saveJobSeekerBtn").html('Update');
              $("#jobSeekerModalLabel").html('Edit JobSeeker Record');
            }else if(callFrom == 'view'){
              $('#jobSeekerViewModal').modal('show');
              $("#job_name").val(resultSet.name);
              $("#job_title").val(resultSet.job_title);
              $("#job_email").val(resultSet.email);
              $("#job_description").val(resultSet.description);
              $("#job_location").val(resultSet.location_name);
              $("#job_phone").val(resultSet.phone_number);
              if(resultSet.profile_photo != null){
                $("#profilePhotoDiv").html('<img src="/uploads/'+resultSet.profile_photo+'" width="120" >');
              }else{
                $("#profilePhotoDiv").html('');
              }
            }           
          }else{
            //console.log(result.data.data);
            var res = result.data;
            var dataObj = res.data;//jQuery.parseJSON(result.data.data);
            
            //console.log(dataObj);
            var html = '';
            var paginate = '';
            if(dataObj.length > 0){
              $.each(dataObj, function(key,value) {
                html+= '<tr> <th scope="row">'+parseInt(key+1)+'</th> <td class="nameClass">'+value.name+'</td><td>'+value.job_title+'</td><td>'+value.location_name+'</td><td>'+value.email+'</td><td>'+value.phone_number+'</td><td rel="'+value.id+'">';
                if(!$("#isLoggedIn").val()){
                  html+= '<button type="button" class="btn btn-primary btn-sm viewBtn"><i class="fa fa-eye" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="View"></i></button>';
                }else{
                  html+= '<button type="button" class="btn btn-primary btn-sm viewBtn"><i class="fa fa-eye" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="View"></i></button><button type="button" class="btn btn-primary btn-sm mx-1 my-1 editBtn"><i class="fa fa-pencil-square" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Edit"></i></button><button type="button" class="btn btn-primary btn-sm deleteBtn"><i class="fa fa-trash" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Delete"></i></button>';
                }
                html+= '</td></tr>';
              });
            }else{
              html+='<td colspan="8" class="text-center">No Record Found !!</td>';
            }
            
            $('.nameClass').css('textTransform', 'capitalize');
            $("#jobListTR").html(html);
            editRecord();
            deleteRecord();
            viewRecord();
            console.log(res.total);
            console.log(res.per_page);
            if(res.total < res.per_page){
              $("#paginationNav").addClass('d-none');
            }else{
              $("#paginationNav").removeClass('d-none');
            }
            paginate += '';
            var prevDisable = 'disabled';
            if (res.current_page > 1) {
              prevDisable = '';
            }
            var previousPage = parseInt(res.current_page)-1;
            paginate += '<li class="page-item '+prevDisable+'"><a class="page-link paginateClass" href="javascript:void(0);" aria-label="Previous" rel="'+previousPage+'"><span aria-hidden="true">&laquo;</span></a></li>';
            for (var i = 1; i <= res.last_page; i++) {
              if (i > 0) {
                var active = '';
                var paginateClass = 'paginateClass';
                if(res.current_page == i){
                  active = 'active';
                  var paginateClass = '';
                }
                paginate += '<li class="page-item '+active+'"><a class="page-link '+paginateClass+'" href="javascript:void(0);" rel="'+i+'">'+i+'</a></li>';
              }
            }
            var nextDisable = '';
            if (res.current_page == res.last_page) {
              var nextDisable = 'disabled';
            }
            var nextPage = parseInt(res.current_page)+1;
            if(nextPage > res.last_page){
              nextPage = res.last_page;
            }
            paginate += '<li class="page-item '+nextDisable+'"><a class="page-link paginateClass" href="javascript:void(0);" aria-label="Next" rel="'+nextPage+'"><span aria-hidden="true">&raquo;</span></a></li>';
            $("#paginationUL").html(paginate);
            callPagination(loc_id);

          }
        }
    },
    cache: false,
    contentType: false,
    processData: false,
    encode  : true
  });
}
function getLocationList(loc_id=''){
  $.ajax({
    url: '/api/locations/list/'+loc_id,
    dataType: 'json',
    type: 'get',
    success: function (result){
        if(result.status == 'success'){
          console.log(result.data.length);
          if(result.data.length == 1){

          }else{
            console.log(result.data);
            //localStorage.setItem('locationObj',JSON.stringify(result.data));
            var dataObj = result.data;//jQuery.parseJSON(result.data.data);
            //console.log(dataObj);
            var html = '<option value="">Select Location</option>';
            $.each(dataObj, function(key,value) {
              html+= '<option value="'+value.id+'">'+value.location_name+'</option>';
            });
            $("#selectLocation").html(html);
            selectLocationData();
          }
        }
    },
    cache: false,
    contentType: false,
    processData: false,
    encode  : true
  });
}
function callPagination(loc_id=''){
	$(".paginateClass").off('click').on('click', function(){
		var getPageNumer = $(this).attr('rel');
		getJobSeekerList(getPageNumer,'','',loc_id);
	});
}
function editRecord(){
  $(".editBtn").off('click').on('click', function(){
    var getJobId = $(this).parent().attr('rel');
    getJobSeekerList(1,getJobId,'edit');
  });
}
function deleteRecord(){
  $(".deleteBtn").off('click').on('click', function(){
    var getJobId = $(this).parent().attr('rel');
    $("#jobId").val(getJobId);
    $('#deleteModal').modal('show');
    $("#deleteJob").off('click').on('click', function(){
      var formData = new FormData($("#deleteForm")[0]);
      $.ajax({
          url: '/api/job-seeker/delete-data',
          dataType: 'json',
          type: 'post',
          data: formData,
          success: function (result){
              if(result.status == 'success'){
                  $("#successDeleteMsg").html(result.message).removeClass('d-none');
                  commonSetTimeOut('successMsg');
                  $('#deleteModal').modal('hide');
                  getJobSeekerList();                      
              }
          },
          cache: false,
          contentType: false,
          processData: false,
          encode  : true
      }); 
    });
  });
}
function viewRecord(){
  $(".viewBtn").off('click').on('click', function(){
    var getJobId = $(this).parent().attr('rel');
    getJobSeekerList(1,getJobId,'view');
  });  
}
function selectLocationData(){
  $("#selectLocation").off('change').on('change', function(){
    var getLocId = $('option:selected',this).val();
    getJobSeekerList(1,'','',getLocId)
    console.log(getLocId);
  });
}