<form id="redirectForm" name="frmPaymentRedirect" method="post" action="{{ $payment_url }}">
    <input type="hidden" name="env_key" value="{{ $EnvKey }}"/>
    <input type="hidden" name="data" value="{{ $data }}"/>
</form>

<div id="loadingIndicator">
    <div id="spinner"></div>
</div>
<div>
    <p>
        Loading...
    </p>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function () {
        $('#loadingIndicator').show().addClass('spinner');
        // Aici poți adăuga
    });

    window.onload = function() {
        document.getElementById('redirectForm').submit();
    };
</script>

<style>
    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }

    #loadingIndicator {
        display: flex;
        justify-content: center;
        align-items: center;
        position: fixed;
        top: 50%;
        left: 0;
        right: 0;
        transform: translateY(-50%);
        z-index: 9999;
    }

    .spinner {
        width: 40px;
        height: 40px;
        margin: 0 auto;
        border-radius: 50%;
        border: 4px solid #f3f3f3;
        border-top: 4px solid #3498db;
        animation: spin 1s linear infinite;
    }
</style>
