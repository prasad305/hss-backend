<form id="edit-form" enctype="multipart/form-data">
    @csrf
    {{-- @method('PUT') --}}
    <div class="form-group">
      <label for="name">Occupation Title</label>
      <input type="text" class="form-control" id="name" name="name" placeholder="Enter Occupation Title" value="{{ $occupation->title }}">
      <div id="error" class="text-danger"></div>
    </div>
    <div class="form-group">
    
    <input type="radio" id="active" name="status" value="1"  {{ $occupation->status == 1 ? 'checked' : '' }}>
    <label for="active">Active</label>
    <input type="radio" id="inactive" name="status" value="0" {{ $occupation->status == 0 ? 'checked' : '' }}>
    <label for="inactive">Inactive</label>
      
    </div>

    <button type="submit" id="updateCategoryBtn" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp; Update Occupation</button>
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
        url: "{{ route('superAdmin.occupation.update',$occupation->id) }}",// your request url
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
            document.getElementById("error").innerHTML =data.responseJSON.errors.name[0];
        }
    });

 });

</script>

