<form id="edit-form" enctype="multipart/form-data">
    @csrf
    {{-- @method('PUT') --}}
    <div class="form-group">
      <label for="name">State Name</label>
      <input type="text" class="form-control" id="name" name="name" placeholder="Enter State Name" value="{{ $state->name }}">
      <span class="text-danger" id="name_error"></span>
        </div>

    <div class="form-group">
        <label for="name">Country Name</label>
        <select name="country_id" id="edit_category_name" class="form-control select2">
            <option value="0">--Select Country--</option>
            @foreach($countries as $country)
            <option @if($state->country_id == $country->id ) selected @endif value="{{ $country->id }}">{{ $country->name }}</option>
            @endforeach
        </select>
        <span class="text-danger" id="ncountry_id_error"></span>
    </div>

    <button type="submit" id="updateCategoryBtn" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp; Update Country</button>
</form>

<script>
    $(document).on('click','#updateCategoryBtn',function (event) {
    event.preventDefault();
    $('#name_error').text('');
        $('#country_id_error').text('');
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
        url: "{{ route('superAdmin.state.update',$state->id) }}",// your request url
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
                        $("#" + key + "_error").text(value[0]);
                    });
                    errorMessage += '</span>\n' +
                        '</div>\n' +
                        '</div>';
                    
        }
    });

 });
</script>

