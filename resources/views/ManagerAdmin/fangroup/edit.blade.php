<form  id="edit-form" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="_method" value="PUT">
    <input type="hidden" name="start_date" value="{{$event->start_date }}">
    <input type="hidden" name="end_date" value="{{$event->end_date }}">
    <div class="row form-group">
        <div class="col-md-12">
              <label for="first_name">Group Name</label>
              <input type="text" class="form-control" id="group_name" name="group_name" placeholder="Group Name" value="{{$event->group_name }}">
              
              <span id="group_name_error" class="text-danger"></span>
         </div>
    </div>

    <!-- <div class="row form-group">
        <div class="col-md-6">
              <label for="first_name">Min Member</label>
              <input type="text" class="form-control" id="min_member" name="min_member" placeholder="Min Member" value="{{$event->min_member }}">
         </div>
         <div class="col-md-6">
            <label for="first_name">Max Member</label>
            <input type="text" class="form-control" id="max_member" name="max_member" placeholder="Max Member" value="{{$event->max_member }}">
       </div>
    </div> -->

     <!-- <div class="row form-group">
        <div class="col-md-6">
              <label for="first_name">Start Date</label>
              <input type="text" class="form-control datepicker" id="start_date" name="start_date" placeholder="Start Date" value="{{$event->start_date }}">
         </div>
         <div class="col-md-6">
            <label for="first_name">End Date</label>
            <input type="text" class="form-control" id="end_date" name="end_date" placeholder="End Date" value="{{$event->end_date }}">
       </div>
    </div>  -->

    
    <div class="form-group row">
        <div class="col-md-12">
          <label for="phone">Description</label>
          <textarea id="summernote" name="description">
            {!! $event->description !!}
          </textarea>
          <span id="descriptions_error" class="text-danger"></span>
        </div>
    </div>


    <span class="row">
           <div class="form-group col-md-12">
              <label for="image">Image</label>
              <br><img id="image1" src="{{ asset($event->banner) }}" height="300px" width="100%" />
              <br><br>
              <input type="file" class="mt-2" id="banner" name="banner" />
        </div>
    </span>

     <!-- <div class="row form-group">
        <div class="col-md-6">
              <label for="first_name">Fee</label>
              <select name="type" id="" class="form-control">
                  <option value="paid">Paid</option>
                  <option value="free">Free</option>
              </select>
         </div>

     </div>  -->


    <button type="submit" class="btn btn-primary" id="btnUpdateData"><i class="fa fa-save"></i>&nbsp; Update FanGroup</button>

</form>

<script>
    $(document).on('click','#btnUpdateData',function (event) {
     event.preventDefault();
     ErrorMessageClear();
     var form = $('#edit-form')[0];
     var formData = new FormData(form);
     formData.append('_method','PUT');
     // Set header if need any otherwise remove setup part
     $.ajaxSetup({
         headers: {
             'X-CSRF-TOKEN': $('meta[name="token"]').attr('value')
         }
     });

     $.ajax({
         url: "{{ route('managerAdmin.fangroup.update',$event->id) }}",// your request url
         data: formData,
         processData: false,
         contentType: false,
         type: 'POST',
         success: function (data) {
             Swal.fire(
                     'Success!',
                     data.message,
                     'success'
                 )
                 setTimeout(function() {
                     location.reload();
                 }, 1000);
             console.log(data);
         },
         error: function (data) {
             console.log(data);
             $.each(data.responseJSON.errors, function(key, value) {
                        ErrorMessage(key,value)
                     });

            //  var errorMessage = '<div class="card bg-danger">\n' +
            //              '<div class="card-body text-center p-5">\n' +
            //              '<span class="text-white">';
            //          $.each(data.responseJSON.errors, function(key, value) {
            //              errorMessage += ('' + value + '<br>');
            //          });
            //          errorMessage += '</span>\n' +
            //              '</div>\n' +
            //              '</div>';
            //          Swal.fire({
            //              icon: 'error',
            //              title: 'Oops...',
            //              footer: errorMessage
            //          })
         }
     });

 });

 </script>

<script>
    $('#summernote').summernote({
      placeholder: '',
      height: 200
    });
  </script>
