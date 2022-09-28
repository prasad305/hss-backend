<form  id="edit-form" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="_method" value="PUT">
    <div class="row form-group">
        <div class="col-md-6">
              <label for="first_name">Country Name</label>
              <input type="text" class="form-control" id="country" name="country" placeholder="United States...." value="{{$currency->country}}">
              <span class="text-danger" id="currency_country_error"></span>
         </div> 
         
         <div class="col-md-6">
              <label for="currency">Currency</label>
              <input type="text" class="form-control" id="currency" name="currency" placeholder="Dollars..." value="{{$currency->currency}}">
              <span class="text-danger" id="currency_error"></span>
        </div>
     </div>

    <div class="form-group row">
        <div class="col-md-6">
          <label for="currency_code">Currency Code</label>
          <input type="text" class="form-control" id="currency_code" name="currency_code" placeholder="USD..." value="{{$currency->currency_code}}">
          <span class="text-danger" id="currency_code_error"></span>
        </div>
        <div class="col-md-6">
             <label for="symbol">Currency Symbol</label>
             <input type="text" class="form-control" id="symbol" name="symbol" placeholder="$...." value="{{$currency->symbol}}">
             <span class="text-danger" id="currency_symbol_error"></span>
        </div>  
    </div>
    
    <div class="form-group row">
        <div class="col-md-6">
          <label for="country_code">Country Code</label>
          <input type="text" class="form-control" id="country_code" name="country_code" value="{{$currency->country_code}}" placeholder="US...">
        </div>
        <div class="col-md-6">
             <label for="currency_value">Country Value</label>
             <input type="text" class="form-control" id="currency_value" name="currency_value" value="{{$currency->currency_value}}" placeholder="1.000...">
        </div>
    </div>
  
    <button type="submit" class="btn btn-primary" id="btnUpdateAdmin"><i class="fa fa-save"></i>&nbsp; Update Currency</button>

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
        url: "{{ route('superAdmin.currency.update',$currency->id) }}",// your request url
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
</script>