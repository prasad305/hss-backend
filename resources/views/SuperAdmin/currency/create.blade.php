<form id="create-form" enctype="multipart/form-data">
    @csrf
    <div class="row form-group">
        <div class="col-md-6">
            <label for="country">Country Name</label>
            <input type="text" class="form-control" id="country" name="country" placeholder="United States...">
            <span class="text-danger" id="country_error"></span>
        </div>
        <div class="col-md-6">
            <label for="currency_code">Currency Code</label>
            <input type="text" class="form-control" id="currency_code" name="currency_code" placeholder="USD...">
            <span class="text-danger" id="currency_code_error"></span>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-6">
            <label for="currency">Currency</label>
            <input type="text" class="form-control" id="currency" name="currency" placeholder="Dollars...">
            <span class="text-danger" id="currency_error"></span>
        </div>
        <div class="col-md-6">
            <label for="symbol">Symbol</label>
            <input type="text" class="form-control" id="symbol" name="symbol" placeholder="$...">
            <span class="text-danger" id="symbol_error"></span>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-6">
            <label for="country_code">Country Code</label>
            <input type="text" class="form-control" id="country_code" name="country_code" placeholder="US...">
        </div>
        <div class="col-md-6">
            <label for="currency_value">Country Value</label>
            <input type="text" class="form-control" id="currency_value" name="currency_value" placeholder="1.000...">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-6">
            <label for="country_code">Time difference between bangladesh </label>
            <input type="text" class="form-control" id="country_code" name="time" placeholder="hh:mm (1:30)">
        </div>
        <div class="col-md-6">
            <label for="currency_value">Time action</label>
            <div class="form-check">
                <label class="form-check-label mx-4">
                    <input type="radio" class="form-check-input" name="time_action" value="add" checked>Add
                </label>
                <label class="form-check-label mx-4">
                    <input type="radio" class="form-check-input" name="time_action" value="remove">Subtract
                </label>
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-primary" id="btnSaveAdmin"><i class="fa fa-save"></i>&nbsp; Save
        Currency</button>

</form>

<script>
    $(document).on('click', '#btnSaveAdmin', function(event) {
        event.preventDefault();
        $('#country_error').text('');
        $('#currency_code_error').text('');
        $('#currency_error').text('');
        $('#symbol_error').text('');

        var form = $('#create-form')[0];
        var formData = new FormData(form);

        // Set header if need any otherwise remove setup part
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="token"]').attr('value')
            }
        });
        $.ajax({
            url: "{{ route('superAdmin.currency.store') }}", // your request url
            data: formData,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function(data) {
                Swal.fire(
                    'Success!',
                    'Currency has been Added. ' + data.message,
                    'success'
                )
                setTimeout(function() {
                    location.reload();
                }, 1000);
            },
            error: function(data) {
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
