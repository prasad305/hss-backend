<form id="create-form" enctype="multipart/form-data">
    @csrf

    <div class="row">
      <div class="form-group col-md-12">
        <label for="" class="form-label">Package Name</label>
        <input type="text" class="form-control" id="title" name="title" placeholder="Package name">
      </div>
          <div class="form-group col-md-12">
            <label for="" class="form-label">Love React <img height="15px;" width="15px;" 
              src="{{ asset('uploads/love3.jpg') }}" alt="Card image cap"></label>
            <input type="text" class="form-control" id="love_points" name="love_points" placeholder="Love react value">
          </div>
          <div class="form-group col-md-12">
            <label for="" class="form-label">Price</label>
            <input type="text" class="form-control" id="price" name="price" placeholder="Price value">
          </div>

          <div class="form-group col-md-12">
          <label for="" class="form-label">Color Code</label>
            <div class="input-group mb-2">
              <div class="input-group-prepend">
                <input name="color" value="@" class="form-control" style="width: 60px;" type="color" id="get" onchange="fetch()"/><br />
              </div>
              <input name="color_code"  class="form-control" type="text" id="color_code"/>
            </div>
          </div>

      </div>

    <button type="submit" id="addCategoryBtn" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp; Add Love</button>
  </form>

  <script>
    function fetch()
    {
      var get = document.getElementById("get").value;
      document.getElementById("color_code").value = get;
    }
  </script>
  <script>
    $(document).on('click','#addCategoryBtn',function (event) {
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
            url: "{{route('superAdmin.love.store')}}",// your request url
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
                });
                errorMessage += '</span>\n' +
                    '</div>\n' +
                    '</div>';
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    footer: errorMessage
                });

                console.log(data);
            }
        });
    
    });
 </script>
