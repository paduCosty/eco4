<script defer
        src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}&libraries=places&callback=initializeMaps"></script>

<div class="row">
    <div class="col-12">
        <div class="modal-window modal-lg modal fade" id="proposalModal" tabindex="-1"
             aria-labelledby="proposalModalLabel"
             aria-hidden="true" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header close-modal">
                        <h3 class="modal-title eco-proposal-title form-info-text">Propunere acțiune de ecologizare</h3>
                        <div class="modal-close-text-container ">
                            <button type="button" class="close-modal-button fs-5" style="color: #a00404"
                                    data-bs-dismiss="modal" aria-label="Close" id="close-modal-4">X
                            </button>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class=" pop-content">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="form-info-text">
                                                <h6 class="modal-title mb-2 fs-5">Cum funcționează:</h6>

                                                <ul class="how-it-works ">
                                                    <li class="text-gray fs-6">
                                                        Te înscrii, completând formularul de mai jos.
                                                    </li>

                                                    <li class="text-gray fs-6">
                                                        Noi analizăm propunerea ta. Dacă sunt și alte acțiuni în
                                                        zonă
                                                        este posibil să le cumulăm.
                                                    </li>

                                                    <li class="text-gray fs-6">
                                                        Dacă acțiunea ta a fost selectată, vei semna un contract de
                                                        voluntariat cu noi, iar ulterior te ținem la curent cu
                                                        situația
                                                        acesteia
                                                        (acte, relația cu operatorul desalubritate, etc.) Între timp
                                                        tu
                                                        începi să strângi voluntari. vei primi un link personalizat
                                                        prin
                                                        intermediul căruia
                                                        vom știi că voluntarii au venit din partea ta.
                                                    </li>

                                                    <li class="text-gray fs-6">
                                                        Vei primi o parolă cu care te vei loga pe
                                                        platformă
                                                        pentru a vedea numărul voluntarilor, situația acestora și
                                                        detalii
                                                        despre ei.
                                                    </li>

                                                    <li class="text-gray fs-6">
                                                        Cu câteva zile înainte de acțiune, vei primi saci de gunoi
                                                        și
                                                        mănuși.
                                                    </li>

                                                    <li class="text-gray fs-6">
                                                        În ziua acțiunii, vei scana qr code-urile voluntarilor
                                                        participanți la acțiune. În baza acestui scan ei vor primi
                                                        diplomele de participare și
                                                        punctele de implicare socială.
                                                    </li>

                                                    <li class="text-gray fs-6">
                                                        Vei face poze la acțiunea pe care o coordonezi, iar acestea
                                                        se
                                                        vor posta pe pagina de Facebook și nu numai.
                                                    </li>

                                                    <li class="text-gray fs-6 mb-2">
                                                        Vei primii un număr de puncte de implicare socială,
                                                        respectiv
                                                        diploma de coordonator la interval de maxim o săptămână de
                                                        la
                                                        încheierea acțiunii.
                                                    </li>


                                                    <span class="text-gray fs-5">Ce părere
                                                        ai? Te bagi la o treabă de
                                                        lungă durată?</span>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    @if ($errors->any())
                                        <div class="alert alert-danger mb-3">
                                            <strong>Whoops!</strong> There were some problems with your
                                            input.
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    <div class="container">
                                        <form id="volunteer_proposal_form" action="{{ route('home.store') }}"
                                              method="POST">
                                            @csrf
                                            <div class="row form-group">
                                                <div class="mb-3 col-md-6">
                                                    <label for="nume_voluntar_propus"
                                                           class="col-form-label form-modal-label text-gray fs-6">Nume,
                                                        Prenume
                                                    </label> <span id="eroare_nume_voluntar_propus"></span>
                                                    <input type="text"
                                                           class="form-control input-normal text-gray fs-6" name="name"
                                                           required
                                                    >
                                                </div>

                                                <div class="mb-3 col-md-6">
                                                    <label for=""
                                                           class="col-form-label form-modal-label text-gray fs-6">Email:
                                                    </label>
                                                    <input type="text"
                                                           class="form-control input-normal text-gray fs-6" name="email"
                                                           required
                                                    >
                                                </div>

                                                <div class="mb-3 col-md-6">
                                                    <label for=""
                                                           class="col-form-label form-modal-label text-gray fs-6">Telefon:
                                                    </label>
                                                    <input type="text"
                                                           class="form-control input-normal text-gray fs-6" name="phone"
                                                           required
                                                    >
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label
                                                        class="col-form-label form-modal-label text-gray fs-6">Selecteaza
                                                        Data: </label>
                                                    <input type="date"
                                                           class="text-gray fs-6 form-control input-normal "
                                                           name="due_date" required>
                                                </div>

                                                <div class=" mb-3  col-md-6">
                                                    <label for="judet_voluntar_propus"
                                                           class="col-form-label form-modal-label text-gray fs-6">Propune
                                                        acțiune la:
                                                    </label>
                                                    <select name="region_id"
                                                            class="form-control input-normal select-location text-gray fs-6"
                                                            id="propose_regions" required>
                                                        <option value="">Judet</option>
                                                        @foreach ($regions as $region)
                                                            <option value="{{ $region->id }}">{{ $region->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class=" col-md-6 ">
                                                    <label for="judet_voluntar_propus"
                                                           class="col-form-label form-modal-label text-gray fs-6">Localitate:
                                                    </label>
                                                    <select class="form-control  insert-localities text-gray fs-6"
                                                            id="region_cities" required>
                                                        <option value="">Localitate</option>
                                                    </select>

                                                </div>
                                            </div>

                                            <div class="col-16 col-sm-6 mb-4">
                                                <div id="map"></div>
                                            </div>
                                            <div>
                                                <input type="text" id="gps_place_selected" name="event_location_id"
                                                       hidden>
                                            </div>

                                            <div class="row m-1">
                                                <div class="col-12 terms-conditions-text text-dark fs-6">
                                                    <span id="eco-proposal-modal-check-1-span"></span>
                                                    <input type="checkbox" name="terms_site" value="1"/>
                                                    <label class="text-dark fs-6" for="eco-proposal-modal-check-1">Sunt
                                                        de acord cu</label>
                                                    <a href="#" data-bs-toggle="modal" data-bs-target="#tandc"
                                                       style="color: #A6CE39;">Termenii
                                                        și Condițiile acestui</a>
                                                    site.
                                                </div>
                                            </div>

                                            <div id="marker_details"></div>

                                            <div class="row m-1">
                                                <div class="col-12 terms-conditions-text text-dark fs-6">
                                                    <input type="checkbox" name="terms_workshop"
                                                           id="eco-proposal-modal-check-2" value="1"/>
                                                    <label style="display: inline;"
                                                           for="eco-proposal-modal-check-2">Sunt
                                                        de acord cu</label>
                                                    <a href="#" data-bs-toggle="modal"
                                                       data-bs-target="#workshop" style="color: #A6CE39;">Termenii și
                                                        Condițiile de
                                                        participare</a>
                                                    la workshop-ul de ecologizare.
                                                </div>
                                            </div>


                                            <div class="row m-1">
                                                <div class="col-12 terms-conditions-text text-dark fs-6">
                                                    <span id="eco-proposal-modal-check-3-span"></span>
                                                    <input type="checkbox" value="1"
                                                           name="volunteering_contract"
                                                           id="eco-proposal-modal-check-3"/>
                                                    <label style="display: inline;" style="display: inline;"
                                                           for="eco-proposal-modal-check-3">Sunt de acord
                                                        cu </label>
                                                    <a href="#" data-bs-toggle="modal"
                                                       data-bs-target="#contract" style="color: #A6CE39;;">Contractul
                                                        de voluntariat.</a>
                                                </div>
                                            </div>

                                            <div class="error-messages"></div>

                                            <div class="row form-group">
                                                <div class="col-sm-12 text-end">
                                                    <input type="button" id="voluteer-proposal-add-button"
                                                           class="form-submit modal-register-button" value="Propune"/>
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
    </div>
</div>

