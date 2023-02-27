<form id="create-form" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
      <label for="name">Country Name</label>
      <input type="text" class="form-control" id="country" name="country" placeholder="Enter Country name">
      <span class="text-danger" id="country_error"></span>
    </div>
    <div class="form-group">
      <label for="name">Courier Charge</label>
      <input type="text" class="form-control" id="courier_charge" name="courier_charge" placeholder="Enter Courier Charge">
      <span class="text-danger" id="courier_charge_error"></span>
    </div>
    <div class="form-group">
      <label for="name">Company Name</label>
      <input type="text" class="form-control" id="courier_company" name="courier_company" placeholder="Enter Courier Company name">
      <span class="text-danger" id="courier_company_error"></span>
    </div>

    <button type="submit" id="addDeliveryBtn" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp; Add </button>
  </form>

  <script>
    $(document).on('click','#addDeliveryBtn',function (event) {
        event.preventDefault();
        $('#country_error').text('');
        $('#courier_charge_error').text('');
        $('#courier_company_error').text('');
        var form = $('#create-form')[0];
        var formData = new FormData(form);
        
        // Set header if need any otherwise remove setup part
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="token"]').attr('value')
            }
        });
        $.ajax({
            url: "{{route('superAdmin.marketplacedeliverycharge.store')}}",// your request url
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
