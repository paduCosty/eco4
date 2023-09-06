<div class="modal fade" id="edit-propose-event-modal" tabindex="-1" aria-labelledby="edit-propose-event-modal-label"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="edit-product-modal-label">Editeaza evenimentul de ecologizare propus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        style="color: #a00404">X
                </button>
            </div>
            <div class="modal-body">
                <form class="form_edit_propose_event" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group row">

                        <div class="mb-3 col-md-6">
                            <label for="due_date" class="col-form-label text-md-right">{{ __('Due Date') }}</label>
                            <input id="due_date"
                                   class="form-control-plaintext input-normal date-input @error('due_date') is-invalid @enderror event_location_due_date"
                                   name="due_date" required type="date">

                            @error('due_date')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        @if(auth()->check() && auth()->user()->role !== 'coordinator')
                            <div class="mb-3 col-md-6">
                                <label for="status" class="col-form-label text-md-right">{{ __('Status') }}</label>
                                <select id="status"
                                        class="form-control-plaintext input-normal @error('status') is-invalid @enderror event_location_status"
                                        name="status" required>
                                    <option value="">Selecteaza status</option>
                                    <option value="in asteptare">In asteptare</option>
                                    <option value="aprobat">Aprobat</option>
                                    <option value="refuzat">Refuzat</option>
                                    <option value="in desfasurare">In desfasurare</option>
                                    <option value="desfasurat">Desfasurat</option>
                                </select>
                            </div>
                        @endif
                        <div class="mb-3 col-md-12">
                            <label for="description"
                                   class="col-form-label text-md-right">{{ __('Description') }}</label>

                            <textarea id="description"
                                      class="form-control-plaintext input-normal @error('description') is-invalid @enderror event_location_description"
                                      name="description" required autocomplete="email">
                            </textarea>

                            @error('description')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="event-photos">
                            <h2>Poze eveniment</h2>
                            <div class="row mt-3" id="edit_before_photos"></div>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-sm-12 text-end">
                            <button type="submit"
                                    class="form-submit">Salveaza
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
