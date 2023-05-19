<div class="row">
    <div class="col-12">
        <div class="modal-window modal fade" id="enrollModalGeneral" tabindex="-1"
             aria-labelledby="enrollModalGeneral"
             aria-hidden="true" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content" id="enroll-Movila-Miresei">
                    <div class="modal-header close-modal">
                        <h5 class="modal-title" id="enroll-action-title">Înscriere pentru o acțiune de
                            Ecologizare</h5>

                        <div class="modal-close-text-container">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                    style="color: #a00404">X
                            </button>
                        </div>
                    </div>

                    <div class="modal-body">
                        <div class="container">
                            <div class="pop-content">
                                <form method="POST" action="{{ route('volunteer_registration.store') }}">
                                    @csrf
                                    <div class="row form-group">
                                        <div class="col-12 col-sm-5">
                                            <label for="nume_voluntar_general"
                                                   class="col-form-label form-modal-label">Nume, 
                                                Prenume</label>
                                        </div>

                                        <div class="col-12 col-sm-7">
                                            <div class="row">
                                                <div class="col-12">
                                                    <input type="text" required
                                                           class=" form-control fs-6 volunteer-input"
                                                           placeholder="Nume"
                                                           name="name" id="nume_voluntar_general"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-12 col-sm-5">
                                            <label for="email_voluntar_general"
                                                   class="col-form-label form-modal-label">Email</label>
                                        </div>

                                        <div class="col-12 col-sm-7">
                                            <div class="row">
                                                <div class="col-12">
                                                    <input type="email" required
                                                           class=" form-control fs-6 volunteer-input"
                                                           name="email" placeholder="Email"
                                                           id="email_voluntar_general"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-12 col-sm-5">
                                            <label for="tel_voluntar_general"
                                                   class="col-form-label form-modal-label">Telefon</label>
                                        </div>

                                        <div class="col-12 col-sm-7">
                                            <div class="row">
                                                <div class="col-12">
                                                    <input type="tel" required
                                                           class=" form-control fs-6 volunteer-input"
                                                           placeholder="Telefon"
                                                           name="phone" id="tel_voluntar_general"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-12 col-sm-5">
                                            <label
                                                class="col-form-label form-modal-label">Judet:</label>
                                        </div>

                                        <div class="col-12 col-sm-7">
                                            <div class="row">
                                                <div class="col-12">
                                                    <select name="region" class="form-control fs-6" required>
                                                        <option value="">Selecteaza</option>
                                                        @foreach($regions as $region)
                                                            <option value="{{$region->id}}">{{$region->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-12 col-sm-5">
                                            <label
                                                class="col-form-label form-modal-label">Localitate:</label>
                                        </div>

                                        <div class="col-12 col-sm-7">
                                            <div class="row">
                                                <div class="col-12">
                                                    <select name="city" required>
                                                        <option value="">selecteaza</option>

                                                        @foreach($cities as $city)
                                                            <option value="{{$city->id}}">{{$city->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row form-group">
                                        <div class="col-12 col-sm-5">
                                            <label for="friends_enrolled_modal_2_general"
                                                   class="fs-6 col-form-label form-modal-label">Mai vin</label>
                                                   
                                        </div>

                                        <div class="col-12 col-sm-5">

                                        
                                                    <div class="col-12 col-sm-6">
                                                        <input type="text" required
                                                               class=" fs-6 form-control input-number-of-friends-eco4 eco-input-text-modal"
                                                               name="transport" placeholder="Numar"
                                                               id="friends_enrolled_modal_2_general"
                                                               />prieteni să facem
                                                   treabă
                                                               <label 
                                                   class="fs-6"></label>
                                                               
                                                    </div>

                                                    {{-- <div class="col-12 col-sm-6">
                                                        <label for="friends_enrolled_modal_2_general"
                                                               class=" form-control fs-6 friends-enrolled"
                                                               style="width: 133px; height: 17px;"></label>
                                                    </div> --}}
                                               
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row form-group" id="i-have-car-section">
                                        <div class="col-12 col-sm-5">
                                            <label for="car_modal_2_general">Am mașină și</label>
                                        </div>

                                        <div class="col-12 col-sm-7">
                                            <div class="fix-alignment-1">
                                                <div>
                                                    <input type="text" required class="input-number-of-seats-eco4"
                                                           name="seats_available" id="car_modal_2_general"/>
                                                </div>

                                                <div>
                                                    <label for="car_modal_2_general" style="padding-right: 15px;">locuri
                                                        libere in ea</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-12 text-start" id="field-completion-message">
                                                <label id="confirmation-for-number-of-people">
                                                    Atenție: completarea acestui câmp presupune că vei
                                                    lua de la locul de pornire numărul de persoane specificat
                                                </label>
                                            </div>
                                        </div>

                                        <div class="row form-group m-1">
                                            <div class="col-12">
                                                <div class="terms-conditions-text">
                                                    <span id="eco-action-general-enroll-modal-check-1-span"></span>
                                                    <input class="form-check-input" required value="1" type="checkbox"
                                                           name="terms_site"
                                                           id="eco-action-general-enroll-modal-check-1"/>
                                                    <label style="display: inline;" style="display: inline;"
                                                           for="eco-action-general-enroll-modal-check-1">Sunt de
                                                        acord
                                                        cu </label>
                                                    <a href="#" data-bs-toggle="modal" data-bs-target="#tandc"
                                                       style="color: #A6CE39;">termenii și condițiile acestui</a>
                                                    site.
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row form-group m-1">
                                            <div class="col-12">
                                                <div class="terms-conditions-text">
                                                    <span id="eco-action-general-enroll-modal-check-2-span"></span>
                                                    <input class="form-check-input" required value="1" type="checkbox"
                                                           name="terms_workshop"
                                                           id="eco-action-general-enroll-modal-check-2"/>
                                                    <label style="display: inline;" style="display: inline;"
                                                           for="eco-action-general-enroll-modal-check-2">Sunt de
                                                        acord
                                                        cu </label>
                                                    <a href="#" data-bs-toggle="modal" data-bs-target="#workshop"
                                                       style="color: #A6CE39;">termenii și condițiile de
                                                        participare</a>
                                                    la
                                                    workshop-ul de ecologizare.
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row form-group m-1">
                                            <div class="col-12">
                                                <div class="terms-conditions-text">
                                                    <span id="eco-action-general-enroll-modal-check-3-span"></span>
                                                    <input class="form-check-input" required value="1" type="checkbox"
                                                           name="volunteering_contract"
                                                           id="eco-action-general-enroll-modal-check-3"/>
                                                    <label style="display: inline;" style="display: inline;"
                                                           for="eco-action-general-enroll-modal-check-3">Sunt de
                                                        acord
                                                        cu </label>
                                                    <a href="#" data-bs-toggle="modal" data-bs-target="#contract"
                                                       style="color: #A6CE39;;">contractul de voluntariat.</a>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" required class="users_event_location_id"
                                               name="users_event_location_id">
                                        <div class="error-messages"></div>

                                        <div class="row form-group">
                                            <div class="col-12 fix-alignment-2">
                                                <input type="submit" id="volunteer-enroll-general-button"
                                                       class="form-submit modal-register-button"
                                                       value="Mă inscriu"/>
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
    </div>
</div>

<script>
    $(document).ready(function () {

    });
</script>
