<form id="edit-form" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="_method" value="PUT">
    <div class="row form-group">
        <div class="col-md-12">
            <label for="first_name">Title</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="Enter Admin First Name"
                value="{{ $event->title }}">
            <span class="text-danger" id="title_error"></span>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-12">
            <label for="phone">Description</label>
            <textarea class="summernote" name="description">
            {!! $event->description !!}
          </textarea>
            <span class="text-danger" id="description_error"></span>
        </div>


    </div>
    <div class="form-group row">
        <div class="col-md-12">
            <label for="phone">Instruction</label>
            <textarea class="summernote" name="instruction">
            {!! $event->instruction !!}
          </textarea>
            <span class="text-danger" id="instruction_error"></span>
        </div>
    </div>



    <span class="row">
        <div class="form-group col-md-12">
            <label for="image">Banner</label>
            <br><img id="image1" onchange="validateMultipleImage('image1')" alt="icon"
                src="{{ asset($event->banner) }}" height="300px" width="100%"
                onerror="this.onerror=null;this.src='{{ asset(get_static_option('no_image')) }}';" required />
            <br><br>
            <input type="file" class="mt-2" id="image" name="banner"
                onchange="document.getElementById('image1').src = window.URL.createObjectURL(this.files[0]); show(this)"
                accept=".jfif,.jpg,.jpeg,.png,.gif" required>
        </div>
        <div class="form-group col-md-12">
            <label for="video">Video</label>
            </br>
            <video id="videoPreview" width="420" height="315" controls src="{{ asset($event->video) }}">
            </video>
            <br><br>
            <input type="file" class="mt-2" id="video" name="video"
                onchange="document.getElementById('video1').src = window.URL.createObjectURL(this.files[0]); show(this)"
                accept=".jfif,.jpg,.jpeg,.png,.gif,.mp4,.mkv,.3gp" required>
        </div>
    </span>

    <div class="row form-group">
        <div class="col-md-6">
            <label for="first_name">Fee</label>
            <input type="text" class="form-control" name="fee" placeholder="" value="{{ $event->fee }}">
            <span class="text-danger" id="fee_error"></span>
        </div>
        {{-- <div class="col-md-6">
            <label for="first_name">Slots</label>
            <input type="text" class="form-control" name="slots" placeholder="" value="{{$event->total_seat }}">
       </div> --}}
    </div>


    <button type="submit" class="btn btn-primary" id="btnUpdateData"><i class="fa fa-save"></i>&nbsp; Update
        Event</button>

</form>

<script>
    $(document).on("change", "#video", function(evt) {
        var $source = $('#videoPreview');
        $source[0].src = URL.createObjectURL(this.files[0]);
        $source.parent()[0].load();
    });

    $(document).on('click', '#btnUpdateData', function(event) {
        event.preventDefault();
        var form = $('#edit-form')[0];
        var formData = new FormData(form);
        formData.append('_method', 'PUT');
        // Set header if need any otherwise remove setup part
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="token"]').attr('value')
            }
        });

        $.ajax({
            url: "{{ route('managerAdmin.qna.update', $event->id) }}", // your request url
            data: formData,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function(response) {
                Swal.fire(
                    'Success!',
                    response.message,
                    'success'
                )
                setTimeout(function() {
                    location.reload();
                }, 1000);
            },
            error: function(response) {
                $.each(response.responseJSON.errors, function(key, value) {
                    ErrorMessage(key, value);
                });
            }
        });

    });
</script>

<script>
    $('.summernote').summernote({
        placeholder: '',
        height: 150
    });
</script>
