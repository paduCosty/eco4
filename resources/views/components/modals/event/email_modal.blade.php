<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<div class="modal fade" id="event_email_modal" tabindex="-1" aria-labelledby="event_email_modal_label"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="event_email_modal_label">Trimite email</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        style="color: #a00404">X
                </button>
            </div>
            <form id="send_email_to_volunteers">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="email-body" class="form-label">Scrie aici email-ul tău și se va
                            trimite la toți cei selectați.</label>
                        <textarea id="email-body" class="form-control" name="message"
                                  rows="5"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="send-email-button">
                        <span id="send-email-icon" class="d-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                 class="bi bi-envelope"
                                 viewBox="0 0 16 16">
                                <path
                                    d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2Zm13 2.383-4.708 2.825L15 11.105V5.383Zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741ZM1 11.105l4.708-2.897L1 5.383v5.722Z"/>
                            </svg>
                        </span>
                        <span id="send-email-text" class="d-inline-block">
                            Trimite
                        </span>
                    </button>

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Anulează</button>
                </div>
            </form>

        </div>
    </div>
</div>


