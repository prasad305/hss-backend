<form  id="edit-form" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="_method" value="PUT">
    <div class="row form-group">
        <div class="col-md-6">
              <label for="first_name">First Name</label>
              <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter Admin First Name" value="{{$admin->first_name}}">
              <span class="text-danger" id="first_name_error"></span>
         </div> 
         
         <div class="col-md-6">
              <label for="last_name">Last Name</label>
              <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter Admin Last Name" value="{{$admin->last_name}}">
              <span class="text-danger" id="last_name_error"></span>
        </div>
     </div>

    <div class="form-group row">
        <div class="col-md-6">
          <label for="phone">Phone</label>
          <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter Admin Phone" value="{{$admin->phone}}">
          <span class="text-danger" id="phone_error"></span>
        </div>
        <div class="col-md-6">
             <label for="email">Email</label>
             <input type="text" class="form-control" id="email" name="email" placeholder="Enter Admin Email" value="{{$admin->email}}">
             <span class="text-danger" id="email_error"></span>
        </div>  
    </div>
    <div class="form-group row">
        <div class="col-6">
            <label for="name">Category</label>
            <select name="category_id" id="category_id" class="form-control select2" onchange="getSubCategory()">
                @foreach($categories as $data)
                    <option @if($data->id == $admin->category_id) selected @endif value="{{ $data->id }}">{{ $data->name }}</option>
                @endforeach
            </select>
            <span class="text-danger" id="category_error"></span>
        </div>  

        <div class="col-6">
            <label for="name">Sub Category</label>
            <select name="sub_category_id" id="sub_category_id" class="form-control select2">
                
            </select>
            <span class="text-danger" id="sub_category_error"></span>
        </div>  
    </div>
    <span class="row">
           <div class="form-group col-md-6">
              <label for="image">Image</label>
              <br><img id="image1" onchange="validateMultipleImage('image1')" alt="icon" src="{{ asset($admin->image) }}" height="180px" width="180px" onerror="this.onerror=null;this.src='{{ asset(get_static_option('no_image')) }}';" required/>
              <br><br>
              <input type="file" class="mt-2" id="image" name="image" onchange="document.getElementById('image1').src = window.URL.createObjectURL(this.files[0]); show(this)" accept=".jfif,.jpg,.jpeg,.png,.gif" required>
              <span class="text-danger" id="image_error"></span>
        </div>
        <div class="form-group col-md-6">
            <label for="image">Cover</label>
            <br><img id="image2" onchange="validateMultipleImage('image2')" alt="icon" src="{{asset($admin->cover_photo)}}" height="180px" width="180px" onerror="this.onerror=null;this.src='{{ asset(get_static_option('no_image')) }}';" required/>

            <br><br>
            
            <input type="file" class="mt-2" id="cover" name="cover" onchange="document.getElementById('image2').src = window.URL.createObjectURL(this.files[0]); show(this)" accept=".jfif,.jpg,.jpeg,.png,.gif" required>
            <span class="text-danger" id="cover_error"></span>

      </div>
    </span>

    <button type="submit" class="btn btn-primary" id="btnUpdateAdmin"><i class="fa fa-save"></i>&nbsp; Update Admin</button>

</form> 


<script>
   $(document).on('click','#btnUpdateAdmin',function (event) {
    event.preventDefault();
    ErrorMessageClear();
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
        url: "{{ route('superAdmin.admin.update',$admin->id) }}",// your request url
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
            $.each(data.responseJSON.errors, function(key, value) {
                ErrorMessage(key,value);
            });       
        }
    });

  

});

getSubCategory();

function getSubCategory(){
    $.ajax({
      url: "{{url('super-admin/admin')}}/"+$('#category_id').val()+"/get-subcategory",
      type: 'GET',
      dataType: 'json',
      data: {},
    })
    .done(function(response) {
      var subcategory='';
      var sub_category_id = '{{$admin->sub_category_id}}';
      $.each(response, function(index, val) {
          var selected = sub_category_id == val.id ? 'selected' : '';
        subcategory+='<option value="'+val.id+'" '+selected+'>'+val.name+'</option>';
      });
      $('#sub_category_id').html(subcategory);
    })
    .fail(function() {
      $('#sub_category_id').html('');
    });
  }
</script>