<div class="row">
    <div class="col-12">
        <div class="modal-window modal-lg modal fade" id="propose-action-modal" tabindex="-1"
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
                                                    <li class="">
                                                        Pentru a participa la acțiunea de ecologizare, te poți înscrie
                                                        completând formularul de mai jos. În cazul în care nu ai un
                                                        cont, poți crea unul chiar acum.
                                                    </li>

                                                    <li class="">
                                                        Noi analizăm propunerea ta. Dacă sunt și alte acțiuni în
                                                        zonă
                                                        este posibil să le cumulăm.
                                                    </li>

                                                    <li class="">
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

                                                    <li class="">
                                                        Vei primi o parolă cu care te vei loga pe
                                                        platformă
                                                        pentru a vedea numărul voluntarilor, situația acestora și
                                                        detalii
                                                        despre ei.
                                                    </li>

                                                    <li class="">
                                                        Cu câteva zile înainte de acțiune, vei primi saci de gunoi
                                                        și
                                                        mănuși.
                                                    </li>

                                                    <li class="">
                                                        În ziua acțiunii, vei scana qr code-urile voluntarilor
                                                        participanți la acțiune. În baza acestui scan ei vor primi
                                                        diplomele de participare și
                                                        punctele de implicare socială.
                                                    </li>

                                                    <li class="">
                                                        Vei face poze la acțiunea pe care o coordonezi, iar acestea
                                                        se
                                                        vor posta pe pagina de Facebook și nu numai.
                                                    </li>

                                                    <li class=" mb-2">
                                                        Vei primii un număr de puncte de implicare socială,
                                                        respectiv
                                                        diploma de coordonator la interval de maxim o săptămână de
                                                        la
                                                        încheierea acțiunii.
                                                    </li>


                                                    <span>Ce părere
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
                                        <form id="volunteer_proposal_form" action="{{ route('home.store') }}" enctype="multipart/form-data"
                                              method="POST">
                                            @csrf
                                            <div class="row form-group">
                                                @if(!auth()->check())
                                                    <div class="mb-3 col-md-6">
                                                        <label for="name"
                                                               class="col-form-label form-modal-label">Nume,
                                                            Prenume</label>
                                                        <span id="eroare_nume_voluntar_propus"></span>
                                                        <input type="text"
                                                               class="form-control-plaintext input-normal"
                                                               name="name" required>
                                                    </div>

                                                    <div class="mb-3 col-md-6">
                                                        <label for="email"
                                                               class="col-form-label form-modal-label">Email:</label>
                                                        <input type="text"
                                                               class="form-control-plaintext input-normal"
                                                               name="email" required>
                                                    </div>

                                                    <div class="mb-3 col-md-6">
                                                        <label for="phone"
                                                               class="col-form-label form-modal-label ">Telefon:</label>
                                                        <input type="text"
                                                               class="form-control-plaintext input-normal"
                                                               name="phone" required>
                                                    </div>

                                                    <div class="mb-3 col-md-6">
                                                        <label for="password"
                                                               class="col-form-label form-modal-label ">Password:</label>
                                                        <input type="password"
                                                               class="form-control-plaintext input-normal"
                                                               name="password" required>
                                                    </div>

                                                    <div class="mb-3 col-md-6">
                                                        <label for="gender"
                                                               class="col-form-label form-modal-label ">Gen:</label>
                                                        <select name="gender"
                                                                class="form-control input-normal">
                                                            <option value="">Selecteaza Genul</option>
                                                            <option value="masculin">Masculin</option>
                                                            <option value="feminin">Feminin</option>
                                                        </select>
                                                    </div>
                                                @endif
                                                <div class="mb-3 col-md-6">
                                                    <label
                                                        class="col-form-label form-modal-label ">Propune data pentru
                                                        actiunea de ecologizare: </label>
                                                    <input type="date"
                                                           class="form-control-plaintext input-normal"
                                                           name="due_date" required>
                                                </div>
                                            </div>
                                            <div class="row form-group">


                                                <div class=" mb-3 col-md-6">
                                                    <label for="judet_voluntar_propus"
                                                           class="col-form-label form-modal-label ">Propune
                                                        acțiune la:
                                                    </label>
                                                    <div class="special-input-wrap">
                                                        <select name="region_id"
                                                                class="form-control input-normal select-location"
                                                                id="propose_regions_modal" required>
                                                            <option value="">Selecteaza Judet</option>
                                                            @foreach ($events_regions as $region)
                                                                <option value="{{ $region->id }}">
                                                                    {{ $region->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <div class="svg-wrap-input">
                                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                                 xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M16.59 8.59L12 13.17L7.41 8.59L6 10L12 16L18 10L16.59 8.59Z"
                                                                    fill="#A6CE39"></path>
                                                            </svg>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class=" col-md-6 ">
                                                    <label for="judet_voluntar_propus"
                                                           class="col-form-label form-modal-label ">Selecteaza
                                                        Localitate:
                                                    </label>
                                                    <div class="special-input-wrap">
                                                        <select class="form-control input-normal  insert-localities"
                                                                id="region_cities_modal" required>
                                                            <option value="">Localitate</option>
                                                        </select>
                                                        <div class="svg-wrap-input">
                                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                                 xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M16.59 8.59L12 13.17L7.41 8.59L6 10L12 16L18 10L16.59 8.59Z"
                                                                    fill="#A6CE39"></path>
                                                            </svg>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                            <label class="col-form-label form-modal-label ">Selecteaza unul din punctele
                                                existente pe harta, unde iti propunem organizarea unei actiuni de
                                                ecologizare.</label>

                                            <div class="form-group">
                                                <div id="map"></div>
                                            </div>
                                            <div>
                                                <input type="text" id="gps_place_selected" name="event_location_id"
                                                       hidden>
                                            </div>

                                            <div id="marker_details"></div>

                                            <div class="mb-3 col-md-12">
                                                <label for="" class="col-form-label form-modal-label ">
                                                    Adauga imagini de la fata locului:
                                                </label>
                                                <div class="file-input-wrapper">
                                                    <input type="file" name="event_images[]" id="propose-photos"
                                                           class="form-control input-normal" multiple="multiple"
                                                           accept="image/*" required>
                                                    <span class="file-warning how-it-works" style="color: red;"></span>

                                                </div>
                                                <div class="row mt-3" id="uploaded_images"></div>
                                            </div>

                                            <div class="mb-3 col-md-12">
                                                <label for="" class="col-form-label form-modal-label ">Descriere:
                                                </label>
                                                <textarea type="text" maxlength="500" id="textarea-details"
                                                          class="form-control input-normal"
                                                          name="description"
                                                          required></textarea>
                                            </div>

                                            <!--terms and conditions site-->
                                            <x-terms_site></x-terms_site>

                                            <!-- privacy_policy -->
                                            <x-privacy_policy></x-privacy_policy>

                                            <!--   terms and conditions for contract -->
                                            <x-terms-contract></x-terms-contract>

                                            <div class="row form-group">
                                                <div class="col-sm-12 text-end">
                                                    <button type="button" id="volunteer-proposal-add-button"
                                                            class="form-submit">Propune
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
    const textarea = $("#textarea-details");
    const form = $("#volunteer_proposal_form");

    form.submit(function (event) {
        const descriptionContent = textarea.val();
        const formattedDescription = descriptionContent.replace(/(\r\n|\n|\r)/g, "<br>");
        textarea.val(formattedDescription);
    });

    $('form').on('submit', function (event) {
        const fileInput = $('input[type="file"]');

        if (fileInput[0].files.length > 2) {
            alert("Puteți încărca doar două imagini.");
            fileInput.val('');
            event.preventDefault();
        }
    });

    let filesSelected = false;

    $('input[type="file"]').on('change', function(e) {
        event_file_filter(e, this, 'uploaded_images')
    });

</script>
