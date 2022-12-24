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
                <option {{ $event->banner != null ? 'selected' : '' }} value="0">Banner</option>
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
            url: "{{ route('superAdmin.learningSession.update', $event->id) }}", // your request url
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
