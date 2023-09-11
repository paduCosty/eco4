function image_box(response, element, edit_or_show) {
    $('#' + element).empty();
    $.each(response[element], function (index, image) {
        let image_data = {'cdn_api': response.cdn_api, 'path': image.path}
        image_box_render(image_data, image.id, element, edit_or_show, response.table);
    });
}

function image_box_render(image_data, image_id, element, edit_or_show, table = null, photo_index = null) {
    var cdn_api = image_data && image_data.hasOwnProperty('cdn_api') && image_data.cdn_api !== null ? image_data.cdn_api : '';
    var imageTemplate =
        `<div class="col-sm-4 mb-4 images-box">
            <div class="card">
                <div class="card-body position-relative d-flex align-items-center justify-content-center">
                    ${edit_or_show ? `
                        <a href="#"
                            style="text-decoration: none"
                            data-image_id="${image_id}"
                            data-file_path="${image_data.path}"
                            data-table="${table}"
                            data-img_index="${photo_index}"
                            class="delete-image position-absolute top-0 end-0 m-2 text-danger"
                        >
                            &times;
                        </a>` : ''}
                    <div class="square-container bg-light">
                        <img src="${cdn_api + image_data.path}" class="uploaded-image" alt="Uploaded Image" style="width: 100%; height: 100%">
                    </div>
                </div>
            </div>
        </div>`;

    $('#' + element).append(imageTemplate);
}

$(document).on('click', '.uploaded-image', function () {
    var imageUrl = $(this).attr('src');
    var modalTemplate =
        `<div class="modal fade" tabindex="-1" aria-labelledby="image-modal-label" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                    style="color: #a00404">X
                            </button>
                        </div>
                        <div class="modal-body d-flex align-items-center justify-content-center">
                            <img src="${imageUrl}" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
            `;

    var modalElement = $(modalTemplate); // Create the modal element from the template string

    // Append the modal to the body and show it
    $('.show-images-modal').append(modalElement);
    modalElement.modal('show');

    // Remove the modal from the DOM after it is closed
    modalElement.on('hidden.bs.modal', function () {
        modalElement.remove();
    });
});

function preview_selected_files(e, location_id, element, edit_or_show) {
    var files = e.target.files; // List of selected files
    let index = 0;
    // Iterate through each file and display them in HTML

    for (var i = 0; i < files.length; i++) {
        var file = files[i];
        var reader = new FileReader();

        reader.onload = (function (index) {
            return function (e) {
                let data = {'path': e.target.result}
                image_box_render(data, null, element, edit_or_show, null, index);
            };
        })(i);

        reader.readAsDataURL(file);
    }
}

$(document).on('click', '.delete-image', function () {
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    const table = $(this).data('table');
    const photo_index = $(this).data('img_index');
    const image_box = $(this).closest('.images-box');
    if (table) {
        $.ajax({
            url: 'events/destroy-image/' + $(this).data('image_id'),
            type: 'DELETE',
            data: {
                _token: csrfToken,
                table: table,
                file_path: $(this).data('file_path'),
            },
            success: function (response) {
                var messageContainer = $('.message-container');
                if (response.success) {
                    image_box.remove();
                    messageContainer.html('<div class="alert alert-success">' + response.success + '</div>');
                } else {
                    messageContainer.html('<div class="alert alert-danger">A apărut o eroare: ' + response.error + '</div>');
                }

                setTimeout(function () {
                    messageContainer.empty();
                }, 3000);
            },
            error: function (xhr, status, error) {
                var messageContainer = $('.message-container');
                messageContainer.html('<div class="alert alert-danger">A apărut o eroare: ' + error + '</div>');
                setTimeout(function () {
                    messageContainer.empty();
                }, 3000);
            }
        });
    } else {
        image_box.remove();
    }
});

function event_file_filter(e, this_object, element) {
    const fileWrapper = $(this_object).closest('.file-input-wrapper');
    const fileWarning = fileWrapper.find('.file-warning');
    const submitButton = $('#volunteer-proposal-add-button');

    if (this_object.files.length > 2) {
        fileWarning.text("Puteți încărca doar două imagini.");
        $(this_object).val('');
        filesSelected = false;
    } else {
        fileWarning.text('');
        filesSelected = true;
    }

    if (filesSelected) {
        submitButton.prop('disabled', false);
    } else {
        submitButton.prop('disabled', true);
    }
    $('#uploaded_images').empty();
    alert('sd')
    preview_selected_files(e, null, element, false);
}
