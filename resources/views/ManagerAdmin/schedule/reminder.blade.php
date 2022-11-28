<form  id="edit-form" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="_method" value="PUT">

     <div class="form-group col-md-6">
        <label for="reminder_date">Reminder Date {{$schedule->id}}</label>
        <input type="date" name="reminder_date" id="reminder_date" class="form-control">
        <span class="text-danger" id="reminder_error"></span>
      </div>

    <button type="submit" class="btn btn-success" id="btnUpdateData"><i class="fa fa-save"></i>&nbsp; Set Reminder</button>

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
        url: "{{ route('managerAdmin.schedule.update',$schedule->id) }}",// your request url
        data: formData,
        processData: false,
        contentType: false,
        type: 'POST',
        success: function (data) {
            if (data.status == 'success') {
                Swal.fire(
                    'Success!',
                    data.message,
                    'success'
                )
                setTimeout(function() {
                    location.reload();
                }, 1000);
            }
        },
        error: function (data) {
            $.each(data.responseJSON.errors, function(key, value) {
                ErrorMessage(key,value); //this function on master page for showing error message
            });
        }
    });

});

</script>
