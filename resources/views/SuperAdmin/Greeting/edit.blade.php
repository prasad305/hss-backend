<form id="edit-form" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="_method" value="PUT">
    <div class="row form-group">
        <div class="col-md-12">
            <label for="first_name">Title</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="Enter Admin First Name"
                value="{{ $greeting->title }}">
            <span class="text-danger" id="title_error"></span>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-12">
            <label for="phone">Instruction</label>
            <textarea id="summernote2" name="instruction">
            {!! $greeting->instruction !!}
          </textarea>
            <span class="text-danger" id="instruction_error"></span>
        </div>
    </div>


    <span class="row">
        <div class="form-group col-md-12">
            <label for="banner">Banner</label>
            <br><img id="image1" onchange="validateMultipleImage('image1')" alt="icon"
                src="{{ asset($greeting->banner) }}" height="300px" width="100%"
                onerror="this.onerror=null;this.src='{{ asset(get_static_option('no_image')) }}';" />
            <br><br>
            <input type="file" class="mt-2" id="banner" name="banner"
                onchange="document.getElementById('image1').src = window.URL.createObjectURL(this.files[0]);"
                accept=".jfif,.jpg,.jpeg,.png,.gif">
        </div>
        <span class="text-danger" id="banner_error"></span>
    </span>

    <span class="row">
        <div class="form-group col-md-12">
            <label for="video">Video</label>
            <br>
            {{-- @if ($greeting->video !== null) --}}
            <video width="312" controls>
                <source id="videoPreview" src="{{ asset('http://localhost:8000/' . $greeting->video) }}" />
            </video>
            {{-- @endif --}}
            <br>
            <input type="file" class="mt-2" id="video" name="video" accept="video/mp4,video/x-m4v,video/*">
        </div>
        <span class="text-danger" id="video_error"></span>
    </span>

    <div class="row form-group">
        <div class="col-md-6">
            <label for="cost">Cost</label>
            <input readonly id="cost" type="number" class="form-control" name="cost" placeholder=""
                value="{{ $greeting->cost }}">
            <span class="text-danger" id="cost_error"></span>
        </div>
        <div class="col-md-6">
            <label for="minimum_required_day">Minimum day before apply</label>
            <input readonly id="minimum_required_day" type="number" class="form-control" name="minimum_required_day"
                placeholder="" value="{{ $greeting->user_required_day }}">
            <span class="text-danger" id="minimum_required_day_error"></span>
        </div>
    </div>
    <button type="submit" class="btn btn-primary" id="btnUpdateData"><i class="fa fa-save"></i>&nbsp; Update
        Greeting</button>

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
            url: "{{ route('superAdmin.greeting.update', $greeting->id) }}", // your request url
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
                console.log(data);
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
</script>
