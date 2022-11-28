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


    <span class="row">
        <div class="form-group col-md-12">
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



    <button type="submit" class="btn btn-primary" id="btnUpdateData"><i class="fa fa-save"></i>&nbsp; Update
        Event</button>

</form>




<script>
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
            url: "{{ route('superAdmin.audition.update', $event->id) }}", // your request url
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
</script>

<script>
    $('#summernote').summernote({
        placeholder: '',
        height: 200
    });
</script>

<script>
    $('#summernote2').summernote({
        placeholder: '',
        height: 200
    });
</script>
