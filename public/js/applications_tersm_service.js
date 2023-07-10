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

function get_privacy_policy() {
    $.ajax({
        url: '/get-privacy-terms',
        method: 'GET',
        beforeSend: function() {
            $('.loading_indicator').show();
        },
        success: function(response) {
            $('#privacy-policy-modal-body').html(response.data);
        },
        complete: function() {
            $('.loading_indicator').hide();
        },
        error: function(xhr, status, error) {
            alert('A apărut o eroare: ' + error);
        }
    });
}

function get_terms_site() {
    $.ajax({
        url: '/get-terms-site',
        method: 'GET',
        beforeSend: function () {
            $('.loading_indicator').show();
        },
        success: function (response) {
            $('#terms_site_body').html(response.data);
        },
        complete: function () {
            $('.loading_indicator').hide();
        },
        error: function (xhr, status, error) {
            alert('A apărut o eroare: ' + error);
        }
    });
}
