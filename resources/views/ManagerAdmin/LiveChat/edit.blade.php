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
        </div>
        <span class="text-danger" id="image_error"></span>
    </span>

    <hr>

    <div class="row form-group">
        <div class="col-md-6">
            <label for="first_name">Event Date</label>
            <input type="date" class="form-control" name="date" value="{{ $event->date }}">
        </div>
        <span class="text-danger" id="date_error"></span>
    </div>

    <div class="row form-group">
        <div class="col-md-6">
            <label for="first_name">Event Start Time</label>
            <input type="time" class="form-control" name="start_time" value="{{ $event->start_time }}">
            <span class="text-danger" id="start_time_error"></span>
        </div>
        <div class="col-md-6">
            <label for="first_name">Event End Time</label>
            <input type="time" class="form-control" name="end_time" value="{{ $event->end_time }}">
            <span class="text-danger" id="end_time_error"></span>
        </div>
    </div>

    <hr>

    <div class="row form-group">
        <div class="col-md-6">
            <label for="first_name">Registration Start Date</label>
            <input type="date" class="form-control" name="registration_start_date" value="{{ $event->registration_start_date }}">
            <span class="text-danger" id="registration_start_date_error"></span>
        </div>
        <div class="col-md-6">
            <label for="first_name">Registration End Date</label>
            <input type="date" class="form-control" name="registration_end_date" value="{{ $event->registration_end_date }}">
            <span class="text-danger" id="registration_end_date_error"></span>
        </div>
    </div>

    <div class="row form-group">
        <div class="col-md-6">
            <label for="first_name">Fee</label>
            <input type="text" class="form-control" name="fee" placeholder="" value="{{ $event->fee }}">
            <span class="text-danger" id="fee_error"></span>
        </div>
        <div class="col-md-6">
            <label for="first_name">Slots</label>
            <input type="text" class="form-control" name="total_seat" placeholder="" value="{{ $event->total_seat }}">
            <span class="text-danger" id="total_seat_error"></span>
        </div>
    </div>

    <div class="row form-group">
        <div class="col-md-6">
            <label for="first_name">Maximum Time</label>
            <input type="text" class="form-control" name="max_time" placeholder="" value="{{ $event->max_time }}">
            <span class="text-danger" id="max_time_error"></span>
        </div>
        <div class="col-md-6">
            <label for="first_name">Minimum Time</label>
            <input type="text" class="form-control" name="min_time" placeholder="" value="{{ $event->min_time }}">
            <span class="text-danger" id="min_time_error"></span>
        </div>
    </div>

    <div class="row form-group">
        <div class="col-md-6">
            <label for="first_name">Interval</label>
            <input type="text" class="form-control" name="interval" placeholder="" value="{{ $event->interval }}">
            <span class="text-danger" id="interval_error"></span>
        </div>
    </div>




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
            url: "{{ route('managerAdmin.liveChat.update', $event->id) }}", // your request url
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
                    ErrorMessage(key,value)
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

    $('#summernote2').summernote({
        placeholder: '',
        height: 200
    });
</script>
