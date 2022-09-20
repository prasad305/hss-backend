<form id="edit-form" enctype="multipart/form-data">
    @csrf
    {{-- @method('PUT') --}}
    <div class="row">
      <div class="form-group col-md-6">
      <label for="name">Package Name</label>
      <input type="text" class="form-control" id="title" name="title" placeholder="Enter Country Name" value="{{ $package->title }}">
      </div>
      <div class="form-group col-md-6">
        <label for="" class="form-label">Club Points</label>
        <input type="text" class="form-control" id="club_points" name="club_points" value="{{ $package->club_points }}" placeholder="Club points value">
      </div>
      <div class="form-group col-md-6">
        <label for="" class="form-label">Auditions</label>
        <input type="text" class="form-control" id="auditions" name="auditions" value="{{ $package->auditions }}" placeholder="Auditions value">
      </div>
      <div class="form-group col-md-6">
        <label for="" class="form-label">Learning Session</label>
        <input type="text" class="form-control" id="learning_session" value="0" value="{{ $package->learning_session }}" name="learning_session" placeholder="Learning session value">
      </div>
      <div class="form-group col-md-6">
        <label for="" class="form-label">Live Chats</label>
        <input type="text" class="form-control" id="live_chats" value="{{ $package->live_chats }}" name="live_chats" placeholder="Live chats value">
      </div>
      <div class="form-group col-md-6">
        <label for="" class="form-label">Meetup Events</label>
        <input type="text" class="form-control" id="meetup" value="{{ $package->meetup }}" name="meetup" placeholder="Meetup Events value">
      </div>
      <div class="form-group col-md-6">
        <label for="" class="form-label">Greetings</label>
        <input type="text" class="form-control" id="greetings" value="{{ $package->greetings }}" name="greetings" placeholder="Greetings value">
      </div>
      <div class="form-group col-md-6">
        <label for="" class="form-label">Q&A</label>
        <input type="text" class="form-control" id="qna" value="{{ $package->qna }}" name="qna" placeholder="Q & A value">
      </div>
      <div class="form-group col-md-6">
        <label for="" class="form-label">Color Code</label>
        <input type="text" class="form-control" id="color_code" value="{{ $package->color_code }}" name="color_code" placeholder="Color Code value">
      </div>
      <div class="form-group col-md-6">
        <label for="" class="form-label">Price</label>
        <input type="text" class="form-control" id="price" name="price" value="{{ $package->price }}" placeholder="Price value">
      </div>
      <div class="col-md-12">
        <button type="submit" id="updateCategoryBtn" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp; Update Package</button>
      </div>
    </div>
</form>

<script>
    $(document).on('click','#updateCategoryBtn',function (event) {
    event.preventDefault();
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
        url: "{{ route('superAdmin.package.update',$package->id) }}",// your request url
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
                    })
        }
    });

 });
</script>

