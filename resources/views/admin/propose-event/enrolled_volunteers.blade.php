<div id="volunteers-modal" class="modal fade volunteers-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Voluntari înscriși</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table id="volunteers-table" class="table table-striped">
                    <thead>
                    <tr>
                        <th>Email</th>
                        <th>Nume</th>
                        <th>Telefon</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
                <div id="volunteers-pagination" class="pagination"></div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        // Variabile globale pentru gestionarea paginării
        var currentPage = 1;
        var volunteersPerPage = 10; // Numărul de voluntari afișați pe pagină

        // Event handler pentru deschiderea modalului
        $('.open-volunteers-modal').click(function () {
            // Resetați paginația la prima pagină
            currentPage = 1;

            // Afișează modalul

            $('.volunteers-modal').modal('show');

            // Încărcați voluntarii pentru pagina curentă
            loadVolunteers(currentPage);
        });

        // Funcție pentru încărcarea voluntarilor pe o anumită pagină
        function loadVolunteers(page) {
            // Apel AJAX pentru obținerea voluntarilor pe pagina specificată
            $.ajax({
                url: '/api/volunteers',  // URL-ul endpoint-ului pentru obținerea datelor voluntarilor
                method: 'GET',
                data: {
                    page: page,
                    perPage: volunteersPerPage
                },
                success: function (data) {
                    // Populează tabelul cu datele voluntarilor
                    var tableBody = $('#volunteers-table tbody');
                    tableBody.empty();

                    for (var i = 0; i < data.length; i++) {
                        var volunteer = data[i];
                        var row = '<tr>' +
                            '<td>' + volunteer.email + '</td>' +
                            '<td>' + volunteer.name + '</td>' +
                            '<td>' + volunteer.phone + '</td>' +
                            '</tr>';

                        tableBody.append(row);
                    }

                    // Actualizează paginarea
                    updatePagination(page, data.totalVolunteers);
                },
                error: function (xhr, status, error) {
                    console.log(error);
                }
            });
        }

        // Funcție pentru actualizarea paginării
        function updatePagination(currentPage, totalVolunteers) {
            // Calculează numărul de pagini
            var totalPages = Math.ceil(totalVolunteers / volunteersPerPage);

            // Construiește elementele paginării
            var pagination = $('#volunteers-pagination');
            pagination.empty();

            // Construiește butoanele pentru fiecare pagină
            for (var i = 1; i <= totalPages; i++) {
                var button = $('<button class="btn btn-link page-link"></button>');
                button.text(i);
                button.data('page', i);

                // Adaugă evenimentul de click pentru fiecare buton de paginare
                button.click(function () {
                    var page = $(this).data('page');
                    loadVolunteers(page);
                });

                // Adaugă butonul la paginare
                pagination.append(button);
            }

            // Adaugă clasele CSS pentru stilizare
            pagination.addClass('pagination');

            // Selectează pagina curentă
            pagination.find('button[data-page="' + currentPage + '"]').addClass('active');
        }

    });
</script>

