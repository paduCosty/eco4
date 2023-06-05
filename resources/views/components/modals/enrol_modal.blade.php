<div class="row">
    <div class="col-12">
        <div class="modal-window modal fade" id="enrollModalGeneral" tabindex="-1"
             aria-labelledby="enrollModalGeneral"
             aria-hidden="true" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content" id="enroll-Movila-Miresei">
                    <div class="modal-header close-modal">
                        <h5 class="modal-title" id="enroll-action-title">
                            Înscriere la acțiunea de Ecologizare din
                            <span id="event_region_name"></span>,
                            <span id="event_city_name"></span>
                        </h5>

                        <div class="modal-close-text-container">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                    style="color: #a00404">X
                            </button>
                        </div>
                    </div>

                    <div class="modal-body">
                        <div class="container">
                            <div class="pop-content">
                                <div class="col-12">
                                    <div class="form-group row">
                                        <div class="form-info-text">
                                            <h6 class="modal-title mb-2 fs-6">Descriere eveniment:</h6>

                                            <ul class="how-it-works ">
                                                <p class="text-gray fs-6" id="event-description">

                                                </p>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
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
                                                    <select name="region" class="form-control fs-6" required
                                                            id="propose_regions_enrol">
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
                                                    <select name="city" class="form-control fs-6" required
                                                            id="region_cities_enrol">
                                                        <option value="">selecteaza</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-12 col-sm-5">
                                            <label for="friends_enrolled_modal_2_general"
                                                   class="fs-6 col-form-label form-modal-label">Câți prieteni mai vin cu
                                                tine?</label>
                                        </div>

                                        <div class="col-12 col-sm-7">
                                            <div class="row">
                                                <div class="col-7">
                                                    <input type="text" required class="form-control fs-6"
                                                           name="transport" placeholder="Număr"
                                                           id="friends_enrolled_modal_2_general"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row form-group" id="i-have-car-section">
                                        <div class="col-12 col-sm-5 fs-6" style="color:rgb(150, 149, 149)">
                                            <label for="car_modal_2_general">Am mașină și am</label>
                                        </div>
                                        <div class="col-12 col-sm-7">
                                            <div class="row align-items-center">
                                                <div class="col-5">
                                                    <input type="text" required class="form-control fs-6"
                                                           name="transport" placeholder="Număr"
                                                           id="car_modal_2_general"/>
                                                </div>
                                                <div class="col-7 fs-6" style="color:rgb(150, 149, 149)">
                                                    <label for="car_modal_2_general">locuri libere.</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row form-group m-1">
                                        <div class="col-12">
                                            <div class="terms-conditions-text">
                                                <span id="eco-action-general-enroll-modal-check-2-span"></span>
                                                <input type="checkbox" value="1"
                                                       class="form-check-input"
                                                       name="terms_site"
                                                       id="eco-proposal-modal-check-3" required/>
                                                <label style="display: inline;" style="display: inline;"
                                                       for="eco-proposal-modal-check-3">Sunt de acord
                                                    cu </label>
                                                <a href="#" data-bs-toggle="modal"
                                                   data-bs-target="#workshop" style="color: #A6CE39;;">Termenii și
                                                    Condițiile acestui</a>
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
                                                   style="color: #A6CE39;">Termenii și Condițiile de
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
                                                   style="color: #A6CE39;;">Contractul de voluntariat.</a>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" required class="users_event_location_id"
                                           name="users_event_location_id">
                                    <div class="error-messages"></div>

                                    <div class="row form-group">
                                        <div class="col-12 fix-alignment-2">
                                            <button type="submit" id="volunteer-enroll-general-button"
                                                    class="form-submit modal-register-button"
                                                    value="">Mă inscriu
                                            </button>
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
        var APP_URL = window.location.origin;
        /*get all cities wo has a propose event set*/
        $('#propose_regions_enrol').change(function () {
            $('.region_cities_enrol').remove();
            var region_id = $(this).val();
            console.log(region_id)

            $.ajax({
                url: APP_URL + '/get-cities',
                type: 'Get',
                data: {
                    region_id: region_id,
                },
                success: function (response) {
                    var options = '';
                    $.each(response.data, function (index, value) {
                        options += `<option class="region_cities_enrol" lat="${value.latitude}" lng="${value.longitude}" value="${value.id}">${value.name}</option>`;
                    });

                    $('#region_cities_enrol').append(options);

                },
                error: function (xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
        });
    });
</script>
