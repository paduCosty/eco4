/*get contract terms by crm*/
function get_contract() {
    $.ajax({
        url: '/get-contract-terms',
        method: 'GET',
        beforeSend: function() {
            $('#loading_indicator').show();
        },
        success: function(response) {
            $('#contract_modal_body').html(response.data);
        },
        complete: function() {
            $('#loading_indicator').hide();
        },
        error: function(xhr, status, error) {
            alert('A apărut o eroare: ' + error);
        }
    });
}
