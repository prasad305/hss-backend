<form id="edit-form" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="col-md-12">
        <label for="title">Title</label>
        <input type="text" name="title" class="form-control" id="title" value="{{$virtualtour->title}}">
        <span class="text-danger" id="title_error"></span>
    </div>
    <br>
    <div class="col-md-12">
        <label for="type">Type</label>
        <select name="type" class="form-control" id="type">
            <option value="">Select Type</option>
            <?php 
            $webselected ='';
            $phoneselected='';
             if($virtualtour->type=='web'){
                $webselected ='selected';
             }elseif($virtualtour->type=='phone'){ 
                $phoneselected ='selected';
             }
            ?>
            <option value="web" {{$webselected}}>Web Video</option>
            <option value="phone" {{$phoneselected}}>Phone Video</option>
        </select>
        <span class="text-danger" id="type_error"></span>
    </div>
    <br>
    <div class="col-md-12" id="upLinksection">
        <label for="link">Video Link</label>
        <input type="text" name="link" class="form-control" id="link">
        <span class="text-danger" id="link_error"></span>
    </div>
    <br>
    <div class="col-md-12" style="display:none;" id="upVideosection">
        <label for="video">Upload Video</label>
        <br>
        <input type="file" name="video"  id="video">
        <span class="text-danger" id="video_error"></span>
    </div>
    <br>
    <input type="checkbox" id="upChooseBtn" name="chooseBtn"> Upload Video
    <br>
    <br>

    <button type="submit" id="updateBtn" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;
        Update </button>
</form>


<script>

    let UpChooseBtn = document.getElementById('upChooseBtn');
    let UpLinksection = document.getElementById('upLinksection');
    let UpVideosection = document.getElementById('upVideosection');

    UpChooseBtn.addEventListener('change', e => {
        if(e.target.checked){
            UpLinksection.style.display = "none";
            UpVideosection.style.display = "block";
        }else{
            UpLinksection.style.display = "block";
            UpVideosection.style.display = "none";
        }
    });

    $(document).on('click', '#updateBtn', function(event) {
        event.preventDefault();
       
        var form = $('#edit-form')[0];
        var formData = new FormData(form);
        formData.append('_method', 'PUT');
        // Set header if need any otherwise remove setup part
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="token"]').attr('value')
            }
        });

        $.ajax({
            url: "{{ route('superAdmin.virtual-tour.update', $virtualtour->id) }}", // your request url
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
