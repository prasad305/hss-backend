<form id="create-form" enctype="multipart/form-data">
    @csrf

    <div class="row">
          <div class="form-group col-md-12">
            <label for="" class="form-label">Package Name</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="Package name">
          </div>
          <div class="form-group col-md-6">
            <label for="" class="form-label">Club Points</label>
            <input type="text" class="form-control" id="club_points" name="club_points" placeholder="Club points value">
          </div>
          <div class="form-group col-md-6">
            <label for="" class="form-label">Auditions</label>
            <input type="text" class="form-control" id="auditions" value="0" name="auditions" placeholder="Auditions value">
          </div>
          <div class="form-group col-md-6">
            <label for="" class="form-label">Learning Session</label>
            <input type="text" class="form-control" id="learning_session" value="0" name="learning_session" placeholder="Learning session value">
          </div>
          <div class="form-group col-md-6">
            <label for="" class="form-label">Live Chats</label>
            <input type="text" class="form-control" id="live_chats" value="0" name="live_chats" placeholder="Live chats value">
          </div>
          <div class="form-group col-md-6">
            <label for="" class="form-label">Meetup Events</label>
            <input type="text" class="form-control" id="meetup" value="0" name="meetup" placeholder="Meetup Events value">
          </div>
          <div class="form-group col-md-6">
            <label for="" class="form-label">Greetings</label>
            <input type="text" class="form-control" id="greetings" value="0" name="greetings" placeholder="Greetings value">
          </div>
        <div class="form-group col-md-6">
          <label for="" class="form-label">Q&A</label>
          <input type="text" class="form-control" id="qna" name="qna" value="0" placeholder="Q & A value">
        </div>
        
          <div class="form-group col-md-6">
            <label for="" class="form-label">Price</label>
            <input type="text" class="form-control" id="price" name="price" placeholder="Price value">
          </div>

          <!-- <div class="form-group col-md-6">
            <label for="" class="form-label">Color Code</label>
            <input type="text" class="form-control" id="color_code" value="#000" name="color_code" placeholder="Color Code value">
          </div> -->

          <div class="form-group col-md-12">
          <label for="" class="form-label">Color Code</label>
            <div class="input-group mb-2">
              <div class="input-group-prepend">
                <!-- <div class="input-group-text">@</div> -->
                <input name="color" value="@" class="form-control" style="width: 60px;" type="color" id="get" onchange="fetch()"/><br />
              </div>
              <!-- <input type="text" class="form-control" id="put" placeholder="Username"> -->
              <input name="color_code"  class="form-control" type="text" id="color_code"/>
            </div>
          </div>


          <!-- <div class="form-group col-md-6">
            <label for="color">Color pick: </label>
            <input name="color" type="color" id="get" onchange="fetch()"/><br />
            <label for="hexa">Hex Code: </label>
            <input name="hexa" type="text" id="put"/><br />
        </div> -->


          


      </div>

    <button type="submit" id="addCategoryBtn" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp; Add Package</button>
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
            url: "{{route('superAdmin.package.store')}}",// your request url
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
