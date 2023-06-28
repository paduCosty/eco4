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
                        <h3 class="modal-title form-info-text">Propunere acțiune de ecologizare</h3>
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
                                                        Pentru a participa la acțiunea de ecologizare, te poți înscrie
                                                        completând formularul de mai jos. În cazul în care nu ai un
                                                        cont, poți crea unul chiar acum.
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
                                                @if(!auth()->check())
                                                    <div class="mb-3 col-md-6">
                                                        <label for="name"
                                                               class="col-form-label form-modal-label text-gray fs-6">Nume,
                                                            Prenume</label>
                                                        <span id="eroare_nume_voluntar_propus"></span>
                                                        <input type="text"
                                                               class="form-control input-normal text-gray fs-6"
                                                               name="name" required>
                                                    </div>

                                                    <div class="mb-3 col-md-6">
                                                        <label for="email"
                                                               class="col-form-label form-modal-label text-gray fs-6">Email:</label>
                                                        <input type="text"
                                                               class="form-control input-normal text-gray fs-6"
                                                               name="email" required>
                                                    </div>

                                                    <div class="mb-3 col-md-6">
                                                        <label for="phone"
                                                               class="col-form-label form-modal-label text-gray fs-6">Telefon:</label>
                                                        <input type="text"
                                                               class="form-control input-normal text-gray fs-6"
                                                               name="phone" required>
                                                    </div>

                                                    <div class="mb-3 col-md-6">
                                                        <label for="password"
                                                               class="col-form-label form-modal-label text-gray fs-6">Password:</label>
                                                        <input type="password"
                                                               class="form-control input-normal text-gray fs-6"
                                                               name="password" required>
                                                    </div>

                                                    <div class="mb-3 col-md-6">
                                                        <label for="gender"
                                                               class="col-form-label form-modal-label text-gray fs-6">Gen:</label>
                                                        <select name="gender"
                                                                class="form-control input-normal text-gray fs-6">
                                                            <option value="masculin">Masculin</option>
                                                            <option value="feminin">Feminin</option>
                                                        </select>
                                                    </div>
                                                @endif
                                                <div class="mb-3 col-md-6">
                                                    <label
                                                        class="col-form-label form-modal-label text-gray fs-6">Propune data pentru actiunea de ecologizare: </label>
                                                    <input type="date"
                                                           class="text-gray fs-6 form-control input-normal "
                                                           name="due_date" required>
                                                </div>
                                            </div>
                                            <div class="row form-group">


                                                <div class=" mb-3 col-md-6">
                                                    <label for="judet_voluntar_propus"
                                                           class="col-form-label form-modal-label text-gray fs-6">Propune
                                                        acțiune la:
                                                    </label>
                                                    <select name="region_id"
                                                            class="form-control input-normal select-location text-gray fs-6"
                                                            id="propose_regions_modal" required>
                                                        <option value="">Judet</option>
                                                        @foreach ($events_regions as $region)
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
                                                            id="region_cities_modal" required>
                                                        <option value="">Localitate</option>
                                                    </select>

                                                </div>
                                            </div>

                                            <label class="col-form-label form-modal-label text-gray fs-6">Selecteaza unul din punctele existente pe harta, unde iti propunem organizarea unei actiuni de ecologizare.</label>

                                            <div class="form-group">
                                                <div id="map"></div>
                                            </div>
                                            <div>
                                                <input type="text" id="gps_place_selected" name="event_location_id"
                                                       hidden>
                                            </div>

                                            <div id="marker_details"></div>

                                            <div class="mb-3 col-md-12">
                                                <label for="" class="col-form-label form-modal-label text-gray fs-6">Descriere:
                                                </label>
                                                <textarea type="text" maxlength="500" id="textarea-details"
                                                          class="form-control input-normal text-gray fs-6"
                                                          name="description"
                                                          required></textarea>
                                            </div>

                                            <div class="row m-1">
                                                <div class="col-12 terms-conditions-text  fs-6"
                                                     style="color:rgb(150, 149, 149)">
                                                    <span id="eco-proposal-modal-check-1-span"></span>
                                                    <input type="checkbox" name="terms_site" value="1" required/>
                                                    <label class="fs-6" for="eco-proposal-modal-check-1">Sunt
                                                        de acord cu</label>
                                                    <a href="#"
                                                       id="term_from_prop_modal"
                                                       style="color: #A6CE39;"
                                                    >Termenii
                                                        și Condițiile acestui</a>
                                                    site.
                                                </div>
                                            </div>

                                            <div class="row m-1">
                                                <div class="col-12 terms-conditions-text fs-6"
                                                     style="color:rgb(150, 149, 149)">
                                                    <input type="checkbox" name="terms_workshop"
                                                           id="eco-proposal-modal-check-2" value="1" required/>
                                                    <label style="display: inline;"
                                                           for="eco-proposal-modal-check-2">Sunt
                                                        de acord cu</label>
                                                    <a href="#"
                                                       style="color: #A6CE39;"
                                                       id="workshop-propose-modal"
                                                    >
                                                        Termenii și
                                                        Condițiile de
                                                        participare
                                                    </a>
                                                    la workshop-ul de ecologizare.
                                                </div>
                                            </div>

                                            <div class="row m-1">
                                                <div class="col-12 terms-conditions-text  fs-6"
                                                     style="color:rgb(150, 149, 149)">
                                                    <span id="eco-proposal-modal-check-3-span"></span>
                                                    <input type="checkbox" value="1"
                                                           name="volunteering_contract"
                                                           id="eco-proposal-modal-check-3" required/>
                                                    <label style="display: inline;" style="display: inline;"
                                                           for="eco-proposal-modal-check-3">Sunt de acord
                                                        cu </label>
                                                    <a href="#"
                                                            id="volunteering_from_prop_modal"
                                                       style="color: #A6CE39;;">
                                                        Contractul de voluntariat.
                                                    </a>
                                                </div>
                                            </div>

                                            <div class="row form-group">
                                                <div class="col-sm-12 text-end">
                                                    <button type="button" id="volunteer-proposal-add-button"
                                                            class="form-submit modal-register-button">Propune
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
    </div>
</div>

<script>
    $(document).ready(function () {
        //open terms and hidde propose modal
        $("#term_from_prop_modal").click(function () {
            $("#proposalModal").modal("hide");
            $("#tandc").addClass("show-propose-modal");
            $("#tandc").modal("show");
        });

        $("#tandc").on("hidden.bs.modal", function () {
            if ($("#tandc").hasClass("show-propose-modal")) {
                $("#proposalModal").modal("show");
                $("#tandc").removeClass("show-propose-modal");
            }
        });

        /*open workshop contract*/
        $("#workshop-propose-modal").click(function () {
            $("#proposalModal").modal("hide");
            $("#workshop").addClass("show-propose-modal");
            $("#workshop").modal("show");
        });

        $("#workshop").on("hidden.bs.modal", function () {
            if ($("#workshop").hasClass("show-propose-modal")) {
                $("#proposalModal").modal("show");
                $("#workshop").removeClass("show-propose-modal");
            }
        });


        /*open volunteering contract*/
        $("#volunteering_from_prop_modal").click(function () {
            $("#proposalModal").modal("hide");
            $("#contract").addClass("show-propose-modal");
            $("#contract").modal("show");
        });

        $("#contract").on("hidden.bs.modal", function () {
            if ($("#contract").hasClass("show-propose-modal")) {
                $("#proposalModal").modal("show");
                $("#contract").removeClass("show-propose-modal");
            }
        });
    });
</script>
