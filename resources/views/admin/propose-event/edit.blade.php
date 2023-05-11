<div class="modal fade" id="edit-propose-event-modal" tabindex="-1" aria-labelledby="edit-propose-event-modal-label"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="edit-product-modal-label">Edit Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="form_edit_propose_event" method="POST"
                      enctype="multipart/form-data">
                    @csrf

                    <div class="form-group row">
                        <label for="name" class="col-form-label text-md-right">{{ __('Name') }}</label>

                        <div class="col-md-6">
                            <input id="name" type="text"
                                   class="form-control @error('name') is-invalid @enderror event_location_name"
                                   name="name"
                                   required autocomplete="name"
                                   autofocus>

                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email"
                               class="col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                        <div class="col-md-6">
                            <input id="email" type="email"
                                   class="form-control @error('email') is-invalid @enderror event_location_email"
                                   name="email"
                                   required autocomplete="email">

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                        </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="due_date"
                               class="col-form-label text-md-right">{{ __('Due Date') }}</label>

                        <div class="col-md-6">
                            <input id="due_date" type="date"
                                   class="form-control @error('due_date') is-invalid @enderror event_location_due_date"
                                   name="due_date"
                                   required>

                            @error('due_date')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="status"
                               class="col-form-label text-md-right">{{ __('Status') }}</label>

                        <div class="col-md-6">
                            <select id="status"
                                    class="form-control @error('status') is-invalid @enderror event_location_status"
                                    name="status" required>
                                <option value="">Selecteaza status</option>
                                <option value="in asteptare">In asteptare</option>
                                <option value="aprobat">Aprobat</option>
                                <option value="refuzat">Refuzat</option>
                                <option value="in desfasurare">In desfasurare</option>
                                <option value="desfasurat">Desfasurat</option>
                            </select>
                        </div>

                    </div>
                    <button type="submit" class="btn btn-default butts fs-5"> Send</button>

                </form>
            </div>
        </div>
    </div>
</div>

