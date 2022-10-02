<form id="edit-form" enctype="multipart/form-data">
    @csrf
    {{-- @method('PUT') --}}
    <div class="form-group">
      <label for="name">City Name</label>
      <input type="text" class="form-control" id="name" name="name" placeholder="Enter City Name" value="{{ $cities->name }}">
      <span class="text-danger" id="name_error"></span>
    </div>

    {{-- <div class="form-group">
        <label for="name">Country Name</label>
        <select name="country_id" id="edit_category_name" class="form-control select2">
            @foreach($countries as $country)
            <option @if($cities->country_id == $country->id ) selected @endif value="{{ $country->id }}">{{ $country->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="name">State Name</label>
        <select name="state_id" id="edit_category_name" class="form-control select2">
            @foreach($states as $state)
            <option @if($cities->state_id == $state->id ) selected @endif value="{{ $state->id }}">{{ $state->name }}</option>
            @endforeach
        </select>
    </div> --}}

    <div class="form-group">
        <label for="name">Country Name</label>
        <input type="hidden" class="form-control" id="stateId" name="stateId" value="{{ $cities->state_id }}">
        <select name="country_id" id="country_id" class="form-control select2" onchange="getCountryId">
            <option value="0">--Select Country--</option>
            @foreach($countries as $country)
            <option @if($cities->country_id == $country->id ) selected @endif value="{{ $country->id }}">{{ $country->name }}</option>
            @endforeach
        </select>
        <span class="text-danger" id="country_id_error"></span>
    </div>

    <div class="form-group">
        <label for="name">State Name</label>
        <select name="state_id" id="state_id" class="form-control select2">
            @foreach($states as $state)
            <option value="{{ $state->id }}" {{ $state->id == $cities->state_id ? 'selected' : '' }}>{{ $state->name }}</option>
            @endforeach
        </select>
        <span class="text-danger" id="state_id_error"></span>
    </div>

    <button type="submit" id="updateCategoryBtn" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp; Update Country</button>
</form>

<script>
    $(document).on('click','#updateCategoryBtn',function (event) {
    event.preventDefault();
    $('#name_error').text('');
        $('#country_id_error').text('');
        $('#state_id_error').text('');
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
        url: "{{ route('superAdmin.city.update',$cities->id) }}",// your request url
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

//  $(document).on('hover','#edit-form',function(e){
//         var countryID = $(this).val(); 
//         var stateId = '{{$cities->state_id}}'; 
//     })

// getCountryId();

//  $(document).on('change','#country_id',function(e){

 $(document).on('change','#country_id',function(e){
        var countryID = $(this).val(); 
        var stateId = '{{$cities->state_id}}'; 

        if(countryID){
            $.ajax({
                type:"GET",
                url:"{{ url('super-admin/get-state') }}/" + countryID,
                success:function(response){    
                    if(response){
                        var state='';
                        // var district_id = {{isset($officeInformation->id) ? $officeInformation->district_id : ''}}
                        $.each(response, function(index, val) {
                            var selected = val.id == stateId ? 'selected' : '';
                            state+='<option value="'+val.id+'" '+selected+'>'+val.name+'</option>';
                        });
                        $('#state_id').html(state);
                    
                    }else{
                        $("#state").empty();
                    }
                }
            });
        }else{
            $("#state").empty();
            $("#city").empty();
        } 
    })
  
</script>

