<div class="modal fade" id="volunteers-modal" tabindex="-1" aria-labelledby="volunteers-modal-label"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="edit-product-modal-label">Voluntari inscrisi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        style="color: #a00404">X
                </button>
            </div>
            <div class="modal-body">
                <table id="volunteers-table" class="table table-striped">
                    <thead>
                    <tr>
                        <th>
                            <label>
                                <input type="checkbox" name="email-checkbox-all" id="select_all_volunteers" value="1">
                                Toti
                            </label>

                        </th>
                        <th>Email</th>
                        <th>Nume</th>
                        <th>Telefon</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
                <div id="pagination-container" class="pagination"></div>

                <div class="d-flex justify-content-center">
                    <div id="page-info"></div>
                </div>
<br>
                <div class="container" id="send-email-btn">
                    <div class="border p-3">
                        <div class="row">
                            <div class="col-12 col-sm-8">
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label for="observations-donate-modal" class="form-label">Scrie aici email-ul
                                            tău și se va trimite la toți cei selectați.</label>
                                        <textarea id="observations-donate-modal" class="form-control"
                                                  name="observations-donate-modal" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-4 mt-auto">
                                <div class="d-grid">
                                    <button id="" class="btn btn-primary">Trimite Email</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    var volunteers_selected = {};

    function loadVolunteers(event_id, page) {
        $.ajax({
            url: '/admin/volunteers/' + event_id,
            method: 'GET',
            data: {
                page: page,
            },
            success: function (data) {
                var tableBody = $('#volunteers-table tbody');
                tableBody.empty();


                for (var i = 0; i < data.data.length; i++) {
                    var volunteer = data.data[i];
                    var isChecked = volunteers_selected[volunteer.id] ? 'checked' : '';

                    var row = `<tr>
                        <td><input type="checkbox" class="select-volunteer" name="email-checkbox" value="${volunteer.id}" ${isChecked}></td>
                        <td> ${volunteer.email} </td>
                        <td> ${volunteer.name} </td>
                        <td> ${volunteer.phone} </td>
                        </tr>`;

                    tableBody.append(row);
                }

                if ($("#select_all_volunteers").is(":checked")) {
                    selectAllVolunteers(true);

                } else if (Object.keys(volunteers_selected).length === 0) {
                    selectAllVolunteers(false);
                }
                // Actualizează paginarea
                updatePagination(page, data.total_pages, event_id);
            },
            error: function (xhr, status, error) {
                console.log(error);
            }
        });
    }

    function updatePagination(currentPage, totalPages, event_id) {

        var paginationContainer = $('#pagination-container');
        var pageInfoContainer = $('#page-info');

        paginationContainer.empty();
        pageInfoContainer.empty();

        if (totalPages <= 1) {
            return false;
        }
        for (var i = 1; i <= totalPages; i++) {
            var button = $('<button class="btn btn-link page-link"></button>');
            button.text(i);
            button.data('page', i);

            button.click(function () {
                var page = $(this).data('page');
                loadVolunteers(event_id, page);
            });

            paginationContainer.append(button);
        }
        paginationContainer.addClass('pagination');
        pageInfoContainer.text('Pagina ' + currentPage + ' din ' + totalPages);
    }

    $(document).on('change', '[name="email-checkbox"]', function () {
        var checkbox = $(this);
        var value = checkbox.val();

        // Actualizează starea checkbox-ului în obiectul global
        if (checkbox.is(':checked')) {
            volunteers_selected[value] = value;
        } else {
            delete volunteers_selected[value];
        }

        if (Object.keys(volunteers_selected).length > 0) {
            $('#send-email-btn').show();
        } else {
            $('#send-email-btn').hide();
        }

    });


    $("#select_all_volunteers").on("change", function () {
        selectAllVolunteers($(this).is(":checked"));
        var keys = Object.keys(volunteers_selected);
        keys.forEach(function (key) {
            delete volunteers_selected[key];
        });
    });

    function selectAllVolunteers(checked) {
        if (checked) {
            $('.select-volunteer').each(function () {
                $(this).prop('checked', true);
                $(this).prop('disabled', true);
            });
            $('#send-email-btn').show();

        } else {
            $('.select-volunteer').each(function () {
                $(this).prop('disabled', false);
                $(this).prop('checked', false);
            });
            $('#send-email-btn').hide();

        }
    }

</script>

<style>
    #email-form {
        margin-top: 20px;
    }

    #email-form .form-label {
        font-weight: bold;
    }

    #email-form .form-control {
        resize: vertical;
    }
</style>
