<form id="create-form" enctype="multipart/form-data">
    @csrf
    <div class="row form-group">
        <div class="col-md-6">
              <label for="first_name">First Name</label>
              <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter Audition Admin First Name">
         </div>
         <div class="col-md-6">
              <label for="last_name">Last Name</label>
              <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter Audition Admin Last Name">
        </div>
     </div>

    <div class="form-group row">
        <div class="col-md-6">
          <label for="phone">Phone</label>
          <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter Audition Admin Phone">
        </div>
        <div class="col-md-6">
             <label for="email">Email</label>
             <input type="text" class="form-control" id="email" name="email" placeholder="Enter Audition Admin Email">
        </div>
    </div>
    <span class="row">
        <div class="form-group col-md-6">
            <label for="image">Image</label>
            <br><img id="image1" onchange="validateMultipleImage('image1')" alt="icon" src="{{ asset(get_static_option('no_image')) }}" height="180px" width="180px" onerror="this.onerror=null;this.src='{{ asset(get_static_option('no_image')) }}';" required/>
            <br><br>
            <input type="file" class="mt-2" id="image" name="image" onchange="document.getElementById('image1').src = window.URL.createObjectURL(this.files[0]); show(this)" accept=".jfif,.jpg,.jpeg,.png,.gif" required>
      </div>
      <div class="form-group col-md-6">
          <label for="image">Cover</label>
          <br><img id="image2" onchange="validateMultipleImage('image2')" alt="icon" src="{{asset(get_static_option('no_image'))}}" height="180px" width="180px" onerror="this.onerror=null;this.src='{{ asset(get_static_option('no_image')) }}';" required/>

          <br><br>

          <input type="file" class="mt-2" id="cover" name="cover" onchange="document.getElementById('image2').src = window.URL.createObjectURL(this.files[0]); show(this)" accept=".jfif,.jpg,.jpeg,.png,.gif" required>

    </div>
    </span>

    <button type="submit"  class="btn btn-primary" id="btnSendData"><i class="fa fa-save"></i>&nbsp; Save Admin</button>

</form>

<script>
   $(document).on('click','#btnSendData',function (event) {
    event.preventDefault();
    var form = $('#create-form')[0];
    var formData = new FormData(form);

    // Set header if need any otherwise remove setup part
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="token"]').attr('value')
        }
    });
    $.ajax({
        url: "{{route('managerAdmin.admin.store')}}",// your request url
        data: formData,
        processData: false,
        contentType: false,
        type: 'POST',
        success: function (data) {
            Swal.fire(
                'Success!',
                'Admin has been Added. ' + data.message,
                'success'
            )
            setTimeout(function() {
                location.reload();
            }, 1000);
        },
        error: function (data) {
            var errorMessage = '<div class="card bg-danger">\n' +
                '<div class="card-body text-center p-5">\n' +
                '<span class="text-white">';
            $.each(data.responseJSON.errors, function(key, value) {
                errorMessage += ('' + value + '<br>');
            });
            errorMessage += '</span>\n' +
                '</div>\n' +
                '</div>';
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                footer: errorMessage
            })
        }
    });
});
</script>
