<form id="create-form" enctype="multipart/form-data">
    @csrf

    <div class="col-md-12">
        <label for="title">Title</label>
        <input type="text" name="title" class="form-control" id="title">
        <span class="text-danger" id="title_error"></span>
    </div>
    <br>
    <div class="col-md-12">
        <label for="type">Type</label>
        <select name="type" class="form-control" id="type">
            <option value="">Select Type</option>
            <option value="web">Web Video</option>
            <option value="phone">Phone Video</option>
        </select>
        <span class="text-danger" id="type_error"></span>
    </div>
    <br>
    <div class="col-md-12" id="linksection">
        <label for="link">Video Link</label>
        <input type="text" name="link" class="form-control" id="link">
        <span class="text-danger" id="link_error"></span>
    </div>
    <br>
    <div class="col-md-12" style="display:none;" id="videosection">
        <label for="video">Upload Video</label>
        <br>
        <input type="file" name="video"  id="video">
        <span class="text-danger" id="video_error"></span>
    </div>
    <br>
    <input type="checkbox" id="chooseBtn" name="chooseBtn"> Upload Video
    <br>
    <br>
    <button type="submit" class="btn btn-success" id="btnSave"><i class="fa fa-save"></i>&nbsp; Save</button>

</form>


<script>
    $('.textarea').summernote()
    let Checkbox = document.getElementById('chooseBtn');
    let Linksection = document.getElementById('linksection');
    let Videosection = document.getElementById('videosection');

    Checkbox.addEventListener('change', e => {
        if(e.target.checked){
            Linksection.style.display = "none";
            Videosection.style.display = "block";
        }else{
            Linksection.style.display = "block";
            Videosection.style.display = "none";
        }
    });

    $(document).on('click', '#btnSave', function(e) {
        e.preventDefault();

       
        
        var form = $('#create-form')[0];
        var formData = new FormData(form);

        // Set header if need any otherwise remove setup part
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="token"]').attr('value')
            }
        });
        $.ajax({
            url: "{{ route('superAdmin.virtual-tour.store') }}", // your request url
            data: formData,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function(data) {
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

<script>
    $('.summernote').summernote({
      placeholder: '',
      height: 200
    });
  </script>
