<div class="row">
    <div class="col-12">
        <div class="modal-window modal fade" id="donateModal" tabindex="-1" aria-labelledby="donateModalLabel"
             aria-hidden="true" role="dialog">
            <div class="modal-dialog" style="max-width: 900px;">
                <div class="modal-content" id="donate">
                    <div class="modal-header close-modal">
                        <h5 class="modal-title">Donează pentru o țară mai curată:</h5>

                        <div class="modal-close-text-container">
                            <button type="button" class="close-modal-button text fs-5" style="color: #a00404"
                                    data-bs-dismiss="modal" aria-label="Close" id="close-modal-8">X
                            </button>
                        </div>
                    </div>

                    <div class="modal-body">
                        <form id="registration-form" method="put">
                            @csrf
                            <div class="container">
                                <div class="pop-content">
                                    <div class="row">
                                        <div class="col-12 col-sm-6">
                                            <div class="form-group row">
                                                <div class="form-info-text donate-text">
                                                    <ul>
                                                        <li>
                                                            dezvoltarea unui proiect ambitios
                                                        </li>
                                                        <li>
                                                            ajuti la organizarea acțiunilor de ecologizare
                                                        </li>
                                                        <li>
                                                            ajuți la creșterea conștiinței legate de un mediu mai
                                                            curat
                                                        </li>
                                                    </ul>

                                                    <p>Primești din partea noastră:</p>

                                                    <br/>

                                                    <ul>
                                                        <li>
                                                            diplomă de donator implicat în proiect (pe email)
                                                        </li>
                                                        <li>
                                                            mulțumirea noastră și a societății pentru implicarea ta
                                                        </li>
                                                        <li>
                                                            sentimentul că ai pus umărul la o acțiune care contează
                                                        </li>
                                                    </ul>

                                                    <p style="margin-bottom: 20px;">Pentru virament bancar:</p>

                                                    <div class="Asociatia-Crestem-Romania-Contact-Info">
                                                        <h6>Asociația Creștem România Împreună</h6>
                                                        <p>str. Ciucaș nr. 54, Săcele</p>
                                                        <p>CIF: 34521305</p>
                                                        <p>RO14 BTRL RONC RT05 1252 4901</p>
                                                        <p>Transilvania Brasov</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-6">
                                            <div class="row form-group">
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-12 col-sm-4">
                                                            <label for="adresaemail"
                                                                   class="col-form-label form-modal-label">Metoda de
                                                                plată</label>
                                                        </div>

                                                        <div class="col-12 col-sm-4">
                                                            <div class="row radio-wrap plat payment-type paypal">
                                                                <input type="radio" name="pay_mode"
                                                                       value="1"/>

                                                                <span class="money text-center"
                                                                      style="background-color: #FFFFFF;">
                                                                        <svg width="20" height="25"
                                                                             viewBox="0 0 20 25" fill="none"
                                                                             xmlns="http://www.w3.org/2000/svg">
                                                                            <path fill-rule="evenodd"
                                                                                  clip-rule="evenodd"
                                                                                  d="M5.58821 23.3168L5.99045 20.6601L5.09442 20.6383H0.815704L3.78926 1.03336C3.79852 0.973994 3.82847 0.918884 3.8722 0.87968C3.91615 0.840476 3.97217 0.81897 4.03077 0.81897H11.2453C13.6406 0.81897 15.2935 1.33714 16.1564 2.36003C16.561 2.83989 16.8186 3.34148 16.9434 3.89325C17.0742 4.47235 17.0763 5.16413 16.9488 6.00803L16.9395 6.06941V6.61021L17.3441 6.84857C17.6847 7.03652 17.9555 7.25159 18.1632 7.49779C18.5092 7.9082 18.7331 8.42973 18.8277 9.04781C18.9255 9.68359 18.8932 10.4403 18.7331 11.297C18.5484 12.2823 18.2501 13.1405 17.847 13.8426C17.4764 14.4896 17.0041 15.0263 16.4433 15.4421C15.908 15.8373 15.272 16.1373 14.5528 16.3292C13.8559 16.5179 13.0613 16.6131 12.1898 16.6131H11.6284C11.227 16.6131 10.8371 16.7634 10.5309 17.0329C10.2239 17.308 10.021 17.6839 9.9587 18.095L9.91626 18.3343L9.20551 23.017L9.17341 23.1889C9.16479 23.2433 9.15014 23.2704 9.1286 23.2888C9.10942 23.3056 9.08185 23.3168 9.05492 23.3168H5.58821Z"
                                                                                  fill="#28356A"/>
                                                                            <path fill-rule="evenodd"
                                                                                  clip-rule="evenodd"
                                                                                  d="M17.7275 6.13184C17.7062 6.27499 17.6814 6.42127 17.6539 6.57159C16.7025 11.6511 13.4473 13.4059 9.29012 13.4059H7.17339C6.66494 13.4059 6.23642 13.7896 6.15736 14.3112L4.76667 23.4838C4.71518 23.8263 4.96897 24.1348 5.30118 24.1348H9.0555C9.49997 24.1348 9.87764 23.799 9.94766 23.3431L9.9845 23.1449L10.6914 18.4805L10.7368 18.2246C10.806 17.7672 11.1845 17.4311 11.629 17.4311H12.1904C15.8278 17.4311 18.6753 15.8957 19.5075 11.4519C19.8551 9.59569 19.6752 8.04567 18.7552 6.95557C18.4769 6.62693 18.1315 6.35407 17.7275 6.13184Z"
                                                                                  fill="#298FC2"/>
                                                                             <path fill-rule="evenodd"
                                                                                   clip-rule="evenodd"
                                                                                   d="M16.7318 5.71927C16.5864 5.67514 16.4365 5.63527 16.2826 5.5992C16.128 5.56403 15.9696 5.53289 15.8065 5.50556C15.2358 5.40967 14.6104 5.3642 13.9405 5.3642H8.28579C8.1464 5.3642 8.01412 5.3969 7.89584 5.45605C7.63494 5.58643 7.44125 5.84316 7.39429 6.15746L6.19125 14.0803L6.15678 14.3112C6.23584 13.7897 6.66436 13.406 7.17281 13.406H9.28955C13.4468 13.406 16.7019 11.6503 17.6533 6.57168C17.6817 6.42136 17.7056 6.27508 17.727 6.13193C17.4863 5.99908 17.2256 5.8855 16.9449 5.78872C16.8755 5.76475 16.804 5.74168 16.7318 5.71927Z"
                                                                                   fill="#22284F"/>
                                                                            <path fill-rule="evenodd"
                                                                                  clip-rule="evenodd"
                                                                                  d="M7.39461 6.15751C7.44158 5.8432 7.63526 5.58647 7.89616 5.45699C8.0153 5.39762 8.14672 5.36491 8.28612 5.36491H13.9409C14.6107 5.36491 15.2361 5.41061 15.8068 5.5065C15.9699 5.5336 16.1283 5.56497 16.283 5.60014C16.4368 5.63598 16.5867 5.67608 16.7322 5.71999C16.8043 5.74239 16.8759 5.76569 16.9459 5.78877C17.2266 5.88554 17.4875 6.00002 17.7282 6.13197C18.0112 4.25488 17.7258 2.97682 16.7498 1.81952C15.6737 0.545273 13.7317 0 11.2465 0H4.03175C3.52416 0 3.09112 0.383752 3.0127 0.906175L0.00769052 20.7128C-0.0515565 21.1046 0.239077 21.4581 0.61912 21.4581H5.0732L7.39461 6.15751Z"
                                                                                  fill="#28356A"/>
                                                                        </svg>

                                                                        <p class="col-form-label form-modal-label">PayPal</p>
                                                                    </span>
                                                            </div>
                                                        </div>

                                                        <div class="col-12 col-sm-4">
                                                            <div class="row radio-wrap plat payment-type">
                                                                <input type="radio" class="" name="pay_mode"
                                                                       value="2"/>

                                                                <span class="money text-center"
                                                                      style="background-color: #FFFFFF;">
                                                                        <svg width="93" height="25"
                                                                             viewBox="0 0 93 25" fill="none"
                                                                             xmlns="http://www.w3.org/2000/svg">
                                                                            <path fill-rule="evenodd"
                                                                                  clip-rule="evenodd"
                                                                                  d="M10.8433 19.8519H7.08979L4.2751 8.7311C4.14151 8.21955 3.85784 7.7673 3.44058 7.55416C2.39926 7.01851 1.25179 6.59221 0 6.37721V5.94906H6.04664C6.88116 5.94906 7.50705 6.59221 7.61137 7.33915L9.07179 15.3609L12.8235 5.94906H16.4727L10.8433 19.8519ZM18.559 19.8519H15.0141L17.9331 5.94906H21.478L18.559 19.8519ZM26.0642 9.80056C26.1685 9.05176 26.7944 8.62361 27.5246 8.62361C28.6721 8.51611 29.9221 8.73111 30.9652 9.26491L31.5911 6.27157C30.548 5.84342 29.4005 5.62842 28.3592 5.62842C24.9186 5.62842 22.415 7.55416 22.415 10.2269C22.415 12.2601 24.1884 13.3277 25.4402 13.9708C26.7944 14.6121 27.316 15.0403 27.2117 15.6816C27.2117 16.6435 26.1685 17.0717 25.1272 17.0717C23.8754 17.0717 22.6237 16.751 21.478 16.2154L20.8521 19.2106C22.1039 19.7444 23.4582 19.9594 24.71 19.9594C28.5678 20.065 30.9652 18.1411 30.9652 15.2534C30.9652 11.617 26.0642 11.4038 26.0642 9.80056ZM43.3714 19.8519L40.5568 5.94906H37.5334C36.9075 5.94906 36.2816 6.37721 36.073 7.01851L30.8609 19.8519H34.5101L35.2385 17.8205H39.7222L40.1395 19.8519H43.3714ZM38.055 9.69306L39.0963 14.9328H36.1773L38.055 9.69306Z"
                                                                                  fill="#172B85"/>
                                                                            <path fill-rule="evenodd"
                                                                                  clip-rule="evenodd"
                                                                                  d="M72.3718 21.6323C70.214 23.4621 67.4151 24.5667 64.3566 24.5667C57.5323 24.5667 52 19.0672 52 12.2833C52 5.49944 57.5323 0 64.3566 0C67.4151 0 70.214 1.10458 72.3718 2.93433C74.5295 1.10458 77.3284 0 80.3869 0C87.2113 0 92.7435 5.49944 92.7435 12.2833C92.7435 19.0672 87.2113 24.5667 80.3869 24.5667C77.3284 24.5667 74.5295 23.4621 72.3718 21.6323Z"
                                                                                  fill="#ED0006"/>
                                                                            <path fill-rule="evenodd"
                                                                                  clip-rule="evenodd"
                                                                                  d="M72.3718 21.6324C75.0286 19.3794 76.7133 16.0269 76.7133 12.2833C76.7133 8.53974 75.0286 5.1873 72.3718 2.93431C74.5295 1.10457 77.3284 0 80.3869 0C87.2113 0 92.7435 5.49944 92.7435 12.2833C92.7435 19.0672 87.2113 24.5667 80.3869 24.5667C77.3284 24.5667 74.5295 23.4621 72.3718 21.6324Z"
                                                                                  fill="#F9A000"/>
                                                                            <path fill-rule="evenodd"
                                                                                  clip-rule="evenodd"
                                                                                  d="M72.3718 21.6323C75.0286 19.3793 76.7133 16.0269 76.7133 12.2834C76.7133 8.53979 75.0286 5.18738 72.3718 2.93439C69.715 5.18738 68.0303 8.53979 68.0303 12.2834C68.0303 16.0269 69.715 19.3793 72.3718 21.6323Z"
                                                                                  fill="#FF5E00"/>
                                                                        </svg>

                                                                        <p class="col-form-label form-modal-label">Credit Card</p>
                                                                    </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row form-group">
                                                <div class="col-12 col-sm-4">
                                                    <label class="col-form-label form-modal-label">Vreau să
                                                        donez</label>
                                                </div>

                                                <div class="col-12 col-sm-9">
                                                    <div class="row radio-wrap">
                                                        <div class="col-12 col-sm-3">
                                                            <label>
                                                                <input class="amount_box" type="radio" id="20"
                                                                       value="20"
                                                                       name="donate_amount"/>
                                                                <span class="amount_selected">20 lei</span>
                                                            </label>
                                                        </div>

                                                        <div class="col-12 col-sm-3">
                                                            <label>
                                                                <input class="amount_box" type="radio" id="50"
                                                                       value="50"
                                                                       name="donate_amount"/>
                                                                <span class="amount_selected">50 lei</span>
                                                            </label>
                                                        </div>

                                                        <div class="col-12 col-sm-3">
                                                            <label>
                                                                <input class="amount_box" type="radio" id="100" value="100"
                                                                       name="donate_amount"/>
                                                                <span class="amount_selected">100 lei</span>
                                                            </label>
                                                        </div>

                                                        <div class="col-12 col-sm-3">
                                                            <label>
                                                                <input
                                                                    class="donate-amount-container another_sum amount_selected"
                                                                    id="suma" name="sum" type="number"
                                                                    placeholder="Altă sumă"
                                                                />
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div id="show_if_is_netopia" style="display: none">
                                                <div class="row form-group">
                                                    <div class="col-12 col-sm-4">
                                                        <label for="name-donate-modal"
                                                               class="col-form-label form-modal-label">Nume</label>
                                                    </div>

                                                    <div class="col-12 col-sm-8">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <input type="text"
                                                                       class="input-text-eco4 eco-input-text-modal input-text-eco4-donate"
                                                                       name="name" id="name-donate-modal"
                                                                />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row form-group">
                                                    <div class="col-12 col-sm-4">
                                                        <label for="name-donate-modal"
                                                               class="col-form-label form-modal-label">Prenume</label>
                                                    </div>

                                                    <div class="col-12 col-sm-8">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <input type="text"
                                                                       class="input-text-eco4 eco-input-text-modal input-text-eco4-donate"
                                                                       name="last_name" id="name-donate-modal"
                                                                />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row form-group">
                                                    <div class="col-12 col-sm-4">
                                                        <label for="tel-donate-modal"
                                                               class="col-form-label form-modal-label">Telefon</label>
                                                    </div>

                                                    <div class="col-12 col-sm-8">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <input type="tel"
                                                                       class="input-text-eco4 eco-input-text-modal input-text-eco4-donate"
                                                                       name="phone" id="tel-donate-modal"
                                                                />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row form-group">
                                                    <div class="col-12 col-sm-4">
                                                        <label for="email-donate-modal"
                                                               class="col-form-label form-modal-label">Email</label>
                                                    </div>

                                                    <div class="col-12 col-sm-8">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <input type="email"
                                                                       class="input-text-eco4 eco-input-text-modal input-text-eco4-donate"
                                                                       name="email" id="email-donate-modal"
                                                                />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-12 col-sm-4">
                                                    <label for="observations-donate-modal"
                                                           class="col-form-label form-modal-label">Observații</label>
                                                </div>

                                                <div class="col-12 col-sm-8">
                                                    <div class="row">
                                                        <div class="col-12">
                                                                <textarea id="observations-donate-modal"
                                                                          class="company-package-modal-textarea eco-input-text-modal"
                                                                          name="observations-donate-modal"
                                                                ></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12 terms-conditions-text">
                                                    <input class="form-check-input" type="checkbox"
                                                           name="donate-modal-check" id="donate-modal-check" required/>
                                                    <label style="display: inline;" style="display: inline;"
                                                           for="donate-modal-check">Sunt de acord cu </label>
                                                    <a href="#" style="color: #A6CE39;" id="term_donate_modal">Termenii și
                                                        Condițiile
                                                        acestui</a> site.
                                                </div>
                                            </div>

                                            <div class="row form-group">
                                                <div class="col-12">
                                                    <div class="text-end">
                                                        <button type="submit" class="form-submit">
                                                            Mă inscriu!
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {

        $('.payment-type').click(function () {
            $('.payment-type').removeClass('active');
            $(this).addClass('active');
            if ($(this).hasClass('paypal')) {
                $('#show_if_is_netopia').hide();
            } else {
                $('#show_if_is_netopia').show();
            }
        });

        $('#registration-form').submit(function (event) {

            const selectedRadioButton = $('input[name="donate_amount"]:checked').val();
            const enteredSum = $('#suma').val().trim();

            if (!selectedRadioButton && enteredSum === '') {
                event.preventDefault();
                alert('Vă rugăm să selectați o sumă sau să introduceți o valoare în câmpul de introducere a sumei.');
            } else {
                let payment_type = $('.payment-type');

                if (!payment_type.hasClass('active')) {
                    alert('Vă rugăm să selectați o metodă de plată!')
                    return false;
                }

                if (payment_type.hasClass('paypal active')) {
                    $(this).attr('action', 'process-transaction')
                } else {
                    $(this).attr('action', 'process-netopia-transaction')
                }
            }
        });


        $('.amount_selected').click(function () {
            $('.amount_selected').removeClass('active');
            $(this).addClass('active');
        });

        $('.another_sum').click(function () {
            $('.amount_box').prop('checked', false);
        });

        //open terms and hidde propose modal
        $("#term_donate_modal").click(function () {
            $("#donateModal").modal("hide");
            $("#tandc").addClass("show-donate-modal");
            $("#tandc").modal("show");
        });

        $("#tandc").on("hidden.bs.modal", function () {
            if ($("#tandc").hasClass("show-donate-modal")) {
                $("#donateModal").modal("show");
                $("#tandc").removeClass("show-donate-modal");
            }
        });

    });
</script>
<style>
    .active {
        border: 1px solid black !important;
    }

    .another_sum {
        font-style: normal;
        font-weight: 500;
        font-size: 12px;
        color: #FFFFFF !important;
        background: #A6CE39;
        border: 1px solid #F6F4F4;
        box-sizing: border-box;
        box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.05);
        border-radius: 4px;
        width: 100%;
        display: block;
        padding: 3px;
    }

</style>
