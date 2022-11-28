<form id="edit-form" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="_method" value="PUT">
    <div class="row form-group">
        <div class="col-md-12">
            <label for="first_name">Title</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="Enter Admin First Name"
                value="{{ $event->title }}">
            <span id="title_error" class="text-danger"></span>
        </div>

    </div>

    <div class="row form-group">
        <div class="col-md-12">
            <label for="first_name">Keywords</label>
            <input type="text" class="form-control" id="keywords" name="keywords"
                placeholder="Enter Admin First Name" value="{{ $event->keywords }}">
            <span id="keywords_error" class="text-danger"></span>
        </div>

    </div>

    <!-- <div class="row form-group">
        <div class="col-md-12">
              <label for="first_name">Total Items</label>
              <input type="text" class="form-control" id="title" name="total_items" readonly placeholder="Enter Admin First Name" value="{{ $event->total_items }}">
         </div>
    </div>

    <div class="row form-group">
        <div class="col-md-12">
              <label for="first_name">Unit Price</label>
              <input type="text" class="form-control" id="title" name="unit_price" readonly placeholder="Enter Admin First Name" value="{{ $event->unit_price }}">
          <span class="text-danger" id="unit_price"></span>
         </div>
    </div> -->

    <div class="form-group row">
        <div class="col-md-12">
            <label for="phone">Description</label>
            <textarea id="summernote" name="description">
            {!! $event->description !!}
          </textarea>
            <span id="descriptions_error" class="text-danger"></span>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-12">
            <label for="phone">Terms & Conditions</label>
            <textarea id="summernote2" name="terms_conditions">
            {!! $event->terms_conditions !!}
          </textarea>
            <span class="text-danger" id="terms_conditions_error"></span>
        </div>
    </div>


    <span class="row">
        <div class="form-group col-md-12">
            <label for="image">Image</label>
            <br><img id="image1" onchange="validateMultipleImage('image1')" alt="icon"
                src="{{ asset($event->image) }}" height="300px" width="100%"
                onerror="this.onerror=null;this.src='{{ asset(get_static_option('no_image')) }}';" required />
            <br><br>
            <input type="file" class="mt-2" id="image" name="image"
                onchange="document.getElementById('image1').src = window.URL.createObjectURL(this.files[0]); show(this)"
                accept=".jfif,.jpg,.jpeg,.png,.gif" required>
        </div>
    </span>

    {{-- <div class="row form-group">
        <div class="col-md-6">
              <label for="first_name">Fee</label>
              <select name="type" id="" class="form-control">
                  <option value="paid">Paid</option>
                  <option value="free">Free</option>
              </select>
         </div>

     </div> --}}


    <button type="submit" class="btn btn-primary" id="btnUpdateData"><i class="fa fa-save"></i>&nbsp; Update</button>

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
            url: "{{ route('superAdmin.marketplace.update', $event->id) }}", // your request url
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
    $('#summernote2').summernote({
        placeholder: '',
        height: 200
    });
</script>
