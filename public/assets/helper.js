$(document).ready(function () {
    $(".logout-btn").click(function () {
        Swal.fire({
            title: 'Are you sure?',
            text: "You can login again in this system!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, logout it!'
        }).then((result) => {
            if (result.value) {
                Swal.fire(
                    'Logout!',
                    'Successfully logout from this system.',
                    'success'
                )
                setTimeout(function () {
                    document.getElementById('logout-form').submit();
                }, 1000); //2 second
            }
        })
    });

    // Listen for click on toggle checkbox
    $('.select-all').click(function (event) {
        var checkboxes = document.querySelectorAll('input[type="checkbox"]');
        for (var checkbox of checkboxes) {
            checkbox.checked = true;
        }
    });

    $('.un-select-all').click(function (event) {
        var checkboxes = document.querySelectorAll('input[type="checkbox"]');
        for (var checkbox of checkboxes) {
            checkbox.checked = false;
        }
    });

    // Image chose related code
    $(".image-chose-btn").click(function () {
        // console.log($(this).parentsUntil(".middle-image-helper").find('.image-importer'));
        $(this).parentsUntil(".middle-image-helper").find('.image-importer').click();
    })

    //Display image
    $(".image-importer").change(function (event) {
        if (event.target.files.length > 0) {
            $(this).parentsUntil(".middle-image-helper").find('.image-display').attr("src", URL.createObjectURL(event.target.files[0]));
        }
    })
    //Reset image
    $(".image-reset-btn").click(function () {
        $(this).parentsUntil(".middle-image-helper").find('.image-display').attr("src", $(this).val());
        $(this).parentsUntil(".middle-image-helper").find('.image-importer').val('');
    })

    // subscribe now
    $('.subscribe-now-btn').click(function () {
        $.ajax({
            method: 'POST',
            url: "/subscribe/store",
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: { email: $('#subscribe-email').val() },
            dataType: 'JSON',
            beforeSend: function () {
                $(".subscribe-now-btn").prop("disabled", true);
            },
            complete: function () {
                $(".subscribe-now-btn").prop("disabled", false);
            },
            success: function (response) {
                if (response.type == 'success') {
                    $('#subscribe-email').val("");
                    Swal.fire(
                        'Thank you !',
                        response.message,
                        'success'
                    )

                } else {
                    Swal.fire(
                        'Sorry !',
                        response.message,
                        response.type
                    )
                }
            },
            error: function (xhr) {
                var errorMessage = '<div class="card bg-danger">\n' +
                    '                        <div class="card-body text-center p-5">\n' +
                    '                            <span class="text-white">';
                $.each(xhr.responseJSON.errors, function (key, value) {
                    errorMessage += ('' + value + '<br>');
                });
                errorMessage += '</span>\n' +
                    '                        </div>\n' +
                    '                    </div>';
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    footer: errorMessage
                })
            },
        })
    });
});


// function previewImages() {
//     var preview = document.querySelector('#preview');
//     if (this.files) {
//         [].forEach.call(this.files, readAndPreview);
//     }

//     function readAndPreview(file) {
//         // Make sure `file.name` matches our extensions criteria
//         if (!/\.(jpe?g|png|gif)$/i.test(file.name)) {
//             return alert(file.name + " is not an image");
//         } // else...
//         var reader = new FileReader();
//         reader.addEventListener("load", function () {
//             var image = new Image();
//             image.height = 100;
//             image.title = file.name;
//             image.src = this.result;
//             preview.appendChild(image);
//         });
//         reader.readAsDataURL(file);
//     }
// }
// document.querySelector('#image').addEventListener("change", previewImages);

function delete_function(objButton) {
    var url = objButton.value;
    alert(url)
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {

            $.ajax({
                method: 'DELETE',
                url: url,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    console.log(data);
                    if (data.type == 'success') {

                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted. ' + data.message,
                            'success'
                        )
                        if (data.url) {
                            setTimeout(function () {
                                location.replace(data.url);
                            }, 800); //
                        } else {
                            setTimeout(function () {
                                location.reload();
                            }, 800); //
                        }
                    } else {
                        Swal.fire(
                            'Wrong!',
                            'Something going wrong. ' + data.message,
                            'warning'
                        )
                    }
                },
            })
        }
    })


}
function show_warning_message(message) {
    Swal.fire(
        'Wrong !',
        message,
        'warning'
    );
}
