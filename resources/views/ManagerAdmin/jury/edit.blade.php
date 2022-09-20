<form id="edit-form" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="_method" value="PUT">
    <div class="row form-group">


        <div class="col-md-6">
            <label for="first_name">Select Sub Category</label>
            <select name="sub_category_id" id="sub_category_id" class="form-control">
                <option value="">Select One</option>
                @if(isset($sub_categories[0]))
                @foreach ($sub_categories as $key => $subCategory)
                <option {{$subCategory->id == $jury['assignjuries']['sub_category_id'] ? 'selected' : ''}}
                    value="{{$subCategory->id}}">{{$subCategory->name}}</option>
                @endforeach
                @endif
            </select>
            <span class="text-danger" id="sub_category_error"></span>
        </div>
        <div class="col-md-6">
            <label for="first_name">Select Jury Group</label>
            <select name="group_id" id="group_id" class="form-control">
                <option value="">Select One</option>
                @if(isset($groups[0]))
                @foreach ($groups as $key => $group)
                <option {{$group->id == $jury['group_id'] ? 'selected' : ''}} value="{{$group->id}}">{{$group->name}}</option>
                @endforeach
                @endif
            </select>
            <span class="text-danger" id="group_id_error"></span>
        </div>
        

    </div>



    <div class="row form-group">
        <div class="col-md-6">
            <label for="first_name">First Name</label>
            <input type="text" class="form-control" id="first_name" name="first_name"
                placeholder="Enter Audition Admin First Name" value="{{$jury['assignjuries']['first_name']}}">
            <span class="text-danger" id="first_name_error"></span>
        </div>
        <div class="col-md-6">
            <label for="last_name">Last Name</label>
            <input type="text" class="form-control" id="last_name" name="last_name"
                placeholder="Enter Audition Admin Last Name" value="{{$jury['assignjuries']['last_name']}}">
            <span class="text-danger" id="last_name_error"></span>
        </div>
    </div>



    <div class="row form-group">
        <div class="col-md-12">
            <label for="terms_and_condition">Terms and Condition</label>
            <textarea name="terms_and_condition" class="form-control"
                id="summernote">{!! $jury['terms_and_condition'] ? $jury['terms_and_condition'] : '' !!}</textarea>
        </div>
    </div>

    {{-- <div class="form-group row">
        <div class="col-md-6">
            <label for="profile_file1">Jury Profile File 1</label>
            <input type="file" class="form-control" id="profile_file1" name="profile_file1">
        </div>
        <div class="col-md-6">
            <label for="profile_file2">Jury Profile File 2</label>
            <input type="file" class="form-control" id="profile_file2" name="profile_file2">
        </div>
    </div> --}}

    <span class="row">
        <div class="form-group col-md-6">
            <label for="image">Image</label>
            <br><img id="image1" onchange="validateMultipleImage('image1')" alt="icon" src="{{ asset($jury['assignjuries']['image']) }}"
                height="180px" width="180px"
                onerror="this.onerror=null;this.src='{{ asset(get_static_option('no_image')) }}';" required />
            <br><br>
            <input type="file" class="mt-2" id="image" name="image"
                onchange="document.getElementById('image1').src = window.URL.createObjectURL(this.files[0]); show(this)"
                accept=".jfif,.jpg,.jpeg,.png,.gif" required>
            <span class="text-danger" id="image_error"></span>
        </div>
        <div class="form-group col-md-6">
            <label for="image">Cover</label>
            <br><img id="image2" onchange="validateMultipleImage('image2')" alt="icon"
                src="{{asset($jury['assignjuries']['cover_photo'])}}" height="180px" width="180px"
                onerror="this.onerror=null;this.src='{{ asset(get_static_option('no_image')) }}';" required />

            <br><br>

            <input type="file" class="mt-2" id="cover" name="cover"
                onchange="document.getElementById('image2').src = window.URL.createObjectURL(this.files[0]); show(this)"
                accept=".jfif,.jpg,.jpeg,.png,.gif" required>
            <span class="text-danger" id="cover_error"></span>

        </div>
    </span>

    <button type="submit" class="btn btn-success" id="btnUpdateData"><i class="fa fa-save"></i>&nbsp; Update
        Jury</button>

</form>


<script>
    $('#summernote').summernote({
        height: 300,
        focus: true
    });

   $(document).on('click','#btnUpdateData',function (event) {
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
        url: "{{ route('managerAdmin.jury.update',$jury['assignjuries']['id']) }}",// your request url
        data: formData,
        processData: false,
        contentType: false,
        type: 'POST',
        success: function (data) {
            Swal.fire(
                    'Success!',
                    'Audition Admin has been Added. ' + data.message,
                    'success'
                )
                setTimeout(function() {
                    location.reload();
                }, 1000);
        },
        error: function (data) {
            $.each(data.responseJSON.errors, function(key, value) {
                ErrorMessage(key,value); //this function on master page for showing error message
            });
        }
    });

});

// getSubCategory();

function getSubCategory(){
    $.ajax({
      url: "{{url('manager-admin/get-subcategory')}}/"+$('#category').val(),
      type: 'GET',
      dataType: 'json',
      data: {},
    })
    .done(function(response) {
      var sub_category='';
      $.each(response, function(index, val) {
        sub_category+='<option value="'+val.id+'">'+val.name+'</option>';
      });
      $('#sub_category').html(sub_category);
    })
    .fail(function() {
      $('#sub_category').html('');
    });
  }
</script>