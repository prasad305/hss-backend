<form id="create-form" enctype="multipart/form-data">
    @csrf
    <div class="row form-group">
        <div class="col-md-6">
              <label for="first_name">First Name</label>
              <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter Admin First Name">
              <span class="text-danger" id="first_name_error"></span>
         </div> 
         <div class="col-md-6">
              <label for="last_name">Last Name</label>
              <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter Admin Last Name">
              <span class="text-danger" id="last_name_error"></span>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-6">
          <label for="phone">Phone</label>
          <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter Admin Phone">
          <span class="text-danger" id="phone_error"></span>
        </div>
        <div class="col-md-6">
             <label for="email">Email</label>
             <input type="text" class="form-control" id="email" name="email" placeholder="Enter Admin Email">
             <span class="text-danger" id="email_error"></span>
        </div>  
    </div>
    <div class="form-group row">
        <div class="col-12">
            <label for="name">Category</label>
            <select name="category_id" id="category_id" class="form-control select2">
                @foreach($categories as $data)
                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                @endforeach
            </select>
        </div>  
    </div>
    <span class="row">
        <div class="form-group col-md-6">
            <label for="icon">image</label>
            <br><img id="icon1" onchange="validateMultipleImage('icon1')" alt="image" src="" height="180px" width="180px" onerror="this.onerror=null;this.src='{{ asset(get_static_option('no_image')) }}';" required/>

            <br><br>
            
            <input type="file" class="mt-2" id="image" name="image" onchange="document.getElementById('icon1').src = window.URL.createObjectURL(this.files[0]); show(this)" accept=".jfif,.jpg,.jpeg,.png,.gif" required>

          </div>
          <div class="form-group col-md-6">
              <label for="image">Cover</label>
              <br><img id="image1" onchange="validateMultipleImage('image1')" alt="icon" src="" height="180px" width="180px" onerror="this.onerror=null;this.src='{{ asset(get_static_option('no_image')) }}';" required/>

              <br><br>
              
              <input type="file" class="mt-2" id="cover" name="cover" onchange="document.getElementById('image1').src = window.URL.createObjectURL(this.files[0]); show(this)" accept=".jfif,.jpg,.jpeg,.png,.gif" required>

        </div>
    </span>



    <button type="submit"  class="btn btn-primary" id="btnSaveManagerAdmin"><i class="fa fa-save"></i>&nbsp; Save Manager Admin</button>

  </form>

  <script>
    $(document).on('click','#btnSaveManagerAdmin',function (event) {
        event.preventDefault();
        $('#first_name_error').text('');
        $('#last_name_error').text('');
        $('#phone_error').text('');
        $('#email_error').text('');
        var form = $('#create-form')[0];
        var formData = new FormData(form);
        
        // Set header if need any otherwise remove setup part
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="token"]').attr('value')
            }
        });
        $.ajax({
            url: "{{route('superAdmin.managerAdmin.store')}}",// your request url
            data: formData,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function (data) {
                Swal.fire({
                    position: 'top-end',
                    icon: data.type,
                    title: data.message,
                    showConfirmButton: false,
                    // timer: 1500
                })
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
                    $("#" + key + "_error").text(value[0]);
                
                });
                errorMessage += '</span>\n' +
                    '</div>\n' +
                    '</div>';
               
            }
        });
    
    });
 </script>