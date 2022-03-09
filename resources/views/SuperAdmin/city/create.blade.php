<form id="create-form" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
      <label for="name">City Name</label>
      <input type="text" class="form-control" id="name" name="name" placeholder="Enter City name">
    </div>

    <div class="form-group">
        <label for="name">Country Name</label>
        <select name="country_id" id="country_id" class="form-control select2">
            <option value="0">--Select Country--</option>
            @foreach($countries as $country)
            <option value="{{ $country->id }}">{{ $country->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="name">State Name</label>
        <select name="state_id" id="state_id" class="form-control select2">
            
        </select>
    </div>

    <button type="submit" id="addCategoryBtn" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp; Add City</button>
  </form>

  <script>
    $(document).on('click','#addCategoryBtn',function (event) {
        event.preventDefault();
        var form = $('#create-form')[0];
        var formData = new FormData(form);
        
        // Set header if need any otherwise remove setup part
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="token"]').attr('value')
            }
        });
        $.ajax({
            url: "{{route('superAdmin.city.store')}}",// your request url
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
                });
                errorMessage += '</span>\n' +
                    '</div>\n' +
                    '</div>';
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    footer: errorMessage
                });

                console.log(data);
            }
        });
    
    });

//     function getCreateMenu(){
//     $.ajax({
//       url: "{{url('setups/submenu')}}/"+$('#create_module_id').val()+"/get-menu",
//       type: 'GET',
//       dataType: 'json',
//       data: {},
//     })
//     .done(function(response) {
//       var menu='';
//       $.each(response, function(index, val) {
//         menu+='<option value="'+val.id+'">'+val.name+'</option>';
//       });
//       $('#create_menu_id').html(menu);
//     })
//     .fail(function() {
//       $('#create_menu_id').html('');
//     });
//   }
    
    $(document).on('change','#country_id',function(e){
        var countryID = $(this).val(); 
        // alert(countryID);

        if(countryID){
            $.ajax({
            type:"GET",
            url:"{{ url('super-admin/get-state') }}/" + countryID,
            success:function(response){        
            if(response){
                // $("#state_id").empty();
                // $("#state_id").append('<option>Select State</option>');
                // console.log(res);
                // $.each(res,function(key,value){
                //     $("#state_id").html('<option value="'+value.id+'">'+value.name+'</option>');
                // });
                var state='';
                $.each(response, function(index, val) {
                    state+='<option value="'+val.id+'">'+val.name+'</option>';
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
