<form id="edit-form" enctype="multipart/form-data">
    @csrf
    {{-- @method('PUT') --}}
    <div class="col-md-12">
        <label for="title">Product Purchase Title</label>
        <input type="text" name="title" class="form-control" id="title" value="{{$productpurchase->title}}">
        <span class="text-danger" id="error"></span>
    </div>
    <div class="col-md-12">
        <label for="details">Product Purchase Description</label>
        <textarea name="details" class="summernote" id="details">{!!$productpurchase->details!!}</textarea>
        <span class="text-danger" id="details_error"></span>
    </div>

    <div class="form-group">

    <input type="radio" id="active" name="status" value="1"  {{ $productpurchase->status == 1 ? 'checked' : '' }}>
    <label for="active">Active</label>
    <input type="radio" id="inactive" name="status" value="0" {{ $productpurchase->status == 0 ? 'checked' : '' }}>
    <label for="inactive">Inactive</label>
      
    </div>

    <button type="submit" id="updateCategoryBtn" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp; Update Occupation</button>
</form>

<script>
     $('.textarea').summernote()
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
        url: "{{ route('superAdmin.productpurchase.update',$productpurchase->id) }}",// your request url
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
<script>
    $('.summernote').summernote({
      placeholder: '',
      height: 200
    });
  </script>
