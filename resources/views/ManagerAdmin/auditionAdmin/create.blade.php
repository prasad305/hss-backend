<form id="create-form" enctype="multipart/form-data">
    @csrf
    <div class="row form-group">

        <div class="col-md-12">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="Enter Audition Title">
            <span class="text-danger" id="title_error"></span>
        </div>
        <div class="col-md-6">
            <label for="first_name">Select Sub Category</label>
            <select name="sub_category_id" id="sub_category_id" class="form-control">
                <option value="">Select One</option>
                @if (isset($subCategories[0]))
                    @foreach ($subCategories as $key => $subCategory)
                        <option value="{{ $subCategory->id }}">{{ $subCategory->name }}</option>
                    @endforeach
                @endif
            </select>
            <span class="text-danger" id="sub_category_error"></span>
        </div>
        <div class="col-md-6">
            <label for="first_name">Select Audition Admin</label>
            <select name="audition_admin_id" id="audition_admin_id" class="form-control">
                <option value="">Select One</option>
                @if (isset($auditionAdmins[0]))
                    @foreach ($auditionAdmins as $key => $auditionAdmin)
                        @if ($auditionAdmin->status == 0 || $auditionAdmin->active_status == 0)
                            <option value="" disabled>
                                {{ $auditionAdmin->first_name . ' ' . $auditionAdmin->last_name }}
                            </option>
                        @else
                            <option value="{{ $auditionAdmin->id }}" class="bg-success text-white py-3">
                                {{ $auditionAdmin->first_name . ' ' . $auditionAdmin->last_name }}
                            </option>
                            </option>
                        @endif
                    @endforeach
                @endif
            </select>
            <span class="text-danger" id="audition_admin_id_error"></span>
        </div>
    </div>
    <button type="submit" class="btn btn-success" id="btnSendData"><i class="fa fa-save"></i>&nbsp; Save Audition</button>

</form>

<script>
    $(document).on('click', '#btnSendData', function(event) {
        event.preventDefault();
        ErrorMessageClear();
        var form = $('#create-form')[0];
        var formData = new FormData(form);

        // Set header if need any otherwise remove setup part
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="token"]').attr('value')
            }
        });
        $.ajax({
            url: "{{ route('managerAdmin.auditionAdmin.store') }}", // your request url
            data: formData,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function(data) {
                Swal.fire(
                    'Success!',
                    'Audition Admin has been Added. ' + data.message,
                    'success'
                )
                setTimeout(function() {
                    location.reload();
                }, 1000);
            },
            error: function(data) {
                $.each(data.responseJSON.errors, function(key, value) {
                    ErrorMessage(key, value);
                });
            }
        });

    });
</script>
