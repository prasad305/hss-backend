 <form  id="edit-form" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="_method" value="PUT">
        <div class="col-md-12">
            <label for="star_id">Select Star</label>
            <select name="star_id" id="star_id" class="form-control">
                <option value="">Select One</option>
                @if(isset($unassigned_stars[0]))
                    @foreach ($unassigned_stars as $key => $star)
                        <option value="{{$star->id}}">{{$star->first_name.' '.$star->last_name}}</option>
                    @endforeach
                @endif
            </select>
            <span class="text-danger" id="star_error"></span>
       </div>
       <br>
        <button type="submit" class="btn btn-success" id="btnUpdateData"><i class="fa fa-save"></i>&nbsp; Assign Admin</button>
    
    </form>





<script>
   $(document).on('click','#btnUpdateData',function (event) {
    event.preventDefault();
    var star_id = $('#star_id').val();
    ErrorMessageClear();
    var form = $('#edit-form')[0];
    var formData = new FormData(form);
    formData.append('_method','PUT');
    formData.append('star_id',star_id);
    // Set header if need any otherwise remove setup part
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="token"]').attr('value')
        }
    });

    $.ajax({
        url: "{{ route('managerAdmin.assigned.update',$admin->id) }}",// your request url
        data: formData,
        processData: false,
        contentType: false,
        type: 'POST',
        success: function (data) {
            Swal.fire(
                    'Success!',
                    data.message,
                    'success'
                )
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
