<div class="row">
    <div class="col-12">
        <div class="modal-window modal fade" id="contactModal" tabindex="-1" aria-labelledby="contactModalLabel"
             aria-hidden="true" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content" id="contact">
                    <div class="modal-header close-modal">
                        <h5 class="modal-title">Contact</h5>

                        <div class="col-12 col-sm-6 modal-close-text-container">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                    style="color: #a00404">X
                            </button>
                        </div>
                    </div>

                    <div class="modal-body">
                        <form action="{{ route('contact.send') }}" method="POST">
                            @csrf
                            <div class="container">
                                <div class="pop-content">
                                    <div class="form-group row">
                                        <div
                                            class="form-info-text donate-text Asociatia-Crestem-Romania-Contact-Info">
                                            <div style="margin-bottom: 20px;">
                                                <h6>Asociația Creștem România Împreună</h6>
                                                <p>str. Ciucaș nr. 54, Săcele, jud. Brașov, România</p>
                                                <p>Tel: 0788 419 771</p>
                                            </div>

                                            <div>
                                                <p>Pentru a lua legătura cu noi, te rugăm să completezi formularul
                                                    de
                                                    mai jos.</p>
                                                <p>Vom răspunde în maxim 24 de ore. Îți mulțumim!</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-12 col-sm-4">
                                            <label for="name-company-modal-contact"
                                                   class="col-form-label form-modal-label">Nume companie</label>
                                        </div>

                                        <div class="col-12 col-sm-8">
                                            <div class="row">
                                                <div class="col-12">
                                                    <input type="text" class="input-text-eco4 eco-input-text-modal"
                                                           name="company_name"
                                                           id="name-company-modal-contact" required/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-12 col-sm-4">
                                            <label for="name-contact-person--modal-contact"
                                                   class="col-form-label form-modal-label">Persoana contact</label>
                                        </div>

                                        <div class="col-12 col-sm-8">
                                            <div class="row">
                                                <div class="col-12">
                                                    <input type="text" class="input-text-eco4 eco-input-text-modal"
                                                           name="contact_person_name"
                                                           id="name-contact-person--modal-contact" required/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-12 col-sm-4">
                                            <label for="tel-contact-modal" class="col-form-label form-modal-label">Telefon</label>
                                        </div>

                                        <div class="col-12 col-sm-8">
                                            <div class="row">
                                                <div class="col-12">
                                                    <input type="tel" class="input-text-eco4 eco-input-text-modal"
                                                           name="phone" id="tel-contact-modal"
                                                           required/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-12 col-sm-4">
                                            <label for="email-contact-modal"
                                                   class="col-form-label form-modal-label">Email</label>
                                        </div>

                                        <div class="col-12 col-sm-8">
                                            <div class="row">
                                                <div class="col-12">
                                                    <input type="email" class="input-text-eco4 eco-input-text-modal"
                                                           id="email-contact-modal" name="email" required/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-12 col-sm-4">
                                            <label for="message-contact-modal"
                                                   class="col-form-label form-modal-label">Mesaj</label>
                                        </div>

                                        <div class="col-12 col-sm-8">
                                            <div class="row">
                                                <div class="col-12">
                                                    <textarea
                                                        class="company-package-modal-textarea eco-input-text-modal"
                                                        name="message" id="message-contact-modal"
                                                        required></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12 terms-conditions-text">
                                            <input class="form-check-input" type="checkbox"
                                                   name="contact-check-modal"
                                                   id="contact-check-modal"/>
                                            <label style="display: inline;" for="contact-check-modal">Sunt de acord
                                                cu </label><a href="#" style="color: #A6CE39;" id="term_contact_modal">Termenii
                                                și Condițiile
                                                acestui</a>
                                            site.
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-sm-12">
                                            <div class="text-end">
                                                <button class="form-submit">Trimite
                                                </button>
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

        //open terms and hidde propose modal
        $("#term_contact_modal").click(function () {
            $("#contactModal").modal("hide");
            $("#tandc").addClass("show-contact-modal");
            $("#tandc").modal("show");
        });

        $("#tandc").on("hidden.bs.modal", function () {
            if ($("#tandc").hasClass("show-contact-modal")) {
                $("#contactModal").modal("show");
                $("#tandc").removeClass("show-contact-modal");
            }
        });
    });
</script>
