function image_box(response, element, edit_or_show) {
    $.each(response.images, function (index, image) {
        var imageTemplate =
            `<div class="col-sm-4 mb-4 images-box">
                <div class="card">
                    <div class="card-body position-relative">
                        ${edit_or_show ? `<a href="#" style="text-decoration: none" data-image_id="${image.id}" class="delete-image position-absolute top-0 end-0 m-2 text-danger">&times;</a>` : ''}
                        <div class="square-container bg-light d-flex align-items-center justify-content-center">
                            <img src="${window.location.origin + '/' + image.path}" class="uploaded-image" alt="Uploaded Image">
                        </div>
                    </div>
                </div>
            </div>`;

        $('#' + element).append(imageTemplate);
    });
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
