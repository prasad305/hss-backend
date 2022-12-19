<form id="edit-form" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="_method" value="PUT">
    <div class="row form-group">
        <div class="col-md-12">
            <label for="first_name">Title</label>
            <input type="text" class="form-control" id="first_name" name="title" placeholder="Enter Admin First Name"
                value="{{ $event->title }}">
            <span class="text-danger" id="title_error"></span>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-12">
            <label for="phone">Description</label>
            <textarea id="summernote" name="description">
            {!! $event->description !!}
          </textarea>
            <span class="text-danger" id="description_error"></span>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-12">
            <label for="phone">Instruction</label>
            <textarea id="summernote2" name="instruction">
            {!! $event->instruction !!}
          </textarea>
            <span class="text-danger" id="instruction_error"></span>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-12">
            <label for="phone">Select Banner Or Video</label>
            <select name="banner_or_video" id="banner_or_video" onchange="getBannerOrVideo()" class="form-control">
                <option {{ $event->banner != null ? 'selected' : '' }} value="0">Bnner</option>
                <option {{ $event->video != null ? 'selected' : '' }} value="1">Video</option>
            </select>
        </div>
    </div>



    <span class="row">
        <div class="form-group col-md-12" id="hide_show_banner" style="display: block">
            <label for="image">Banner</label>
            <br><img id="image1" onchange="validateMultipleImage('image1')" alt="icon"
                src="{{ asset($event->banner) }}" height="300px" width="100%"
                onerror="this.onerror=null;this.src='{{ asset(get_static_option('no_image')) }}';" required />
            <br><br>
            <input type="file" class="mt-2" id="image" name="image"
                onchange="document.getElementById('image1').src = window.URL.createObjectURL(this.files[0]); show(this)"
                accept=".jfif,.jpg,.jpeg,.png,.gif" required>
            <span class="text-danger" id="image_error"></span>
        </div>
    </span>

    <span class="row">
        <div class="form-group col-md-12" id="hide_show_video" style="display: none">
            <label for="video">Video</label>
            <br>
            <video width="312" controls>
                <source id="videoPreview" src="{{ asset($event->video) }}" />
            </video>
            <br>
            <input type="file" class="mt-2" id="video" name="video" accept="video/mp4,video/x-m4v,video/*"
                required>
        </div>
        <span class="text-danger" id="video_error"></span>
    </span>


    {{-- <div class="row">
        <div class="col-md-12">
            <label for="event_date">Event Date</label>
            <input type="date" class="form-control" name="event_date" value="{{ date('Y-m-d',strtotime($event->event_date)) }}">
            <span class="text-danger" id="event_date_error"></span>
        </div>
    </div>
    <hr>
    
    <div class="row form-group">
        <div class="col-md-6">
            <label for="start_time">Event Start Time</label>
            <input type="time" class="form-control" name="start_time" value="{{ $event->start_time }}">
            <span class="text-danger" id="start_time_error"></span>
        </div>
        <div class="col-md-6">
            <label for="end_time">Event End Time</label>
            <input type="time" class="form-control" name="end_time" value="{{ $event->end_time }}">
            <span class="text-danger" id="end_time_error"></span>
        </div>
    </div> --}}

    {{-- <hr>

    <div class="row form-group">
        <div class="col-md-6">
            <label for="registration_start_date">Registration Start Date</label>
            <input type="date" class="form-control" name="registration_start_date" value="{{ date('Y-m-d',strtotime($event->registration_start_date)) }}">
            <span class="text-danger" id="registration_start_date_error"></span>
        </div>
        <div class="col-md-6">
            <label for="registration_end_date">Registration End Date</label>
            <input type="date" class="form-control" name="registration_end_date" value="{{ date('Y-m-d',strtotime($event->registration_end_date)) }}">
            <span class="text-danger" id="registration_end_date_error"></span>
        </div>
    </div>

    <hr>
    <div class="form-group row">
        <div class="col-md-12">
            <label for="phone">Select Assignment Type</label>
            <select name="assignment" id="assignment" class="form-control">
                <option value="">Select One</option>
                <option {{$event->assignment == 0 ? 'selected' : ''}} value="0">Without Assignment</option>
                <option {{$event->assignment == 1 ? 'selected' : ''}} value="1">With Assignment</option>
            </select>
            <span class="text-danger" id="assignment_error"></span>
        </div>
    </div>
    <hr>

    <div class="row form-group">
        <div class="col-md-6">
            <label for="fee">Fee</label>
            <input type="text" class="form-control" name="fee" placeholder="" value="{{$event->fee }}">
            <span class="text-danger" id="fee_error"></span>
        </div>
        <div class="col-md-6">
            <label for="participant_number">Participant</label>
            <input type="text" class="form-control" name="participant_number" value="{{$event->participant_number }}">
            <span class="text-danger" id="participant_number_error"></span>
        </div>
    </div> --}}


    <button type="submit" class="btn btn-primary" id="btnUpdateData"><i class="fa fa-save"></i>&nbsp; Update
        Event</button>

</form>




<script>
    $(document).on('click', '#btnUpdateData', function(event) {
        event.preventDefault();
        ErrorMessageClear();
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
            url: "{{ route('managerAdmin.learningSession.update', $event->id) }}", // your request url
            data: formData,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function(data) {
                Swal.fire(
                    'Success!',
                    data.message,
                    'success'
                )
                setTimeout(function() {
                    location.reload();
                }, 1000);
            },
            error: function(data) {
                $.each(data.responseJSON.errors, function(key, value) {
                    ErrorMessage(key, value)
                });
            }
        });

    });

    $(document).on("change", "#video", function(evt) {
        var $source = $('#videoPreview');
        $source[0].src = URL.createObjectURL(this.files[0]);
        $source.parent()[0].load();
    });
</script>

<script>
    $('#summernote').summernote({
        placeholder: '',
        height: 200
    });
    $('#summernote2').summernote({
        placeholder: '',
        height: 200
    });
    getBannerOrVideo();

    function getBannerOrVideo() {
        var banner_or_video = $('#banner_or_video').val();
        if (banner_or_video == 0) {
            $("#hide_show_video").css("display", "none");
            $("#hide_show_banner").css("display", "block");
        } else {
            $("#hide_show_banner").css("display", "none");
            $("#hide_show_video").css("display", "block");
        }
    }
</script>
