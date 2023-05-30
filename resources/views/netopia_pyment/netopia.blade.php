<p>
<form name="frmPaymentRedirect" method="post" action="{{ $payment_url }}">
    <input type="hidden" name="env_key" value="{{ $EnvKey }}"/>
    <input type="hidden" name="data" value="{{ $data }}"/>
    <p>
        Vei redirectat catre pagina de plati securizata a mobilpay.ro
    </p>
     <p>
        Pentru a continua apasa <input type="image" src="images/mobilpay.gif" />
    </p>
</form>
</p>
