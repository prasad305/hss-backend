<form id="edit-form" enctype="multipart/form-data">
    @csrf
    {{-- @method('PUT') --}}
    <div class="row">
      <div class="form-group col-md-6">
        <label for="name">Package Name</label>
        <input type="text" class="form-control" id="title" name="title" placeholder="Enter Country Name" value="{{ $package->title }}">
        </div>
     
      <div class="form-group col-md-6">
        <label for="" class="form-label">Love React <img height="15px;" width="15px;" 
          src="{{ asset('assets/super-admin/dist/img/love.png')}}" alt="Card image cap"></label>
        <input type="text" class="form-control" id="love_points" name="love_points" value="{{ $package->love_points }}" placeholder="Love react value">
        <span class="text-danger" id="love_points_error"></span>
      </div>
  
      <div class="form-group col-md-12">
        <label for="" class="form-label">Price</label>
        <input type="text" class="form-control" id="price" name="price" value="{{ $package->price }}" placeholder="Price value">
      </div>
      <div class="form-group col-md-12">
        <label for="" class="form-label">Color Code</label>
        <input type="text" class="form-control" id="color_code" value="{{ $package->color_code }}" name="color_code" placeholder="Color Code value">
      </div>
      <div class="col-md-12">
        <button type="submit" id="updateCategoryBtn" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp; Update Love</button>
      </div>
    </div>
</form>

<script>
    $(document).on('click','#updateCategoryBtn',function (event) {
    event.preventDefault();
    $('#love_points_error').text('');
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
        url: "{{ route('superAdmin.love.update',$package->id) }}",// your request url
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

