<!-- Modal -->
<div class="modal fade" id="create-event-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title" id="exampleModalLabel">Adauga o noua locatie</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="color: #a00404">X</button>
            </div>
            <div class="modal-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('event-locations.store') }}" method="POST">
                    @csrf
                    <div class="row form-group">

                        <div class="col-md-6 mb-3">
                            <label class="fs-5">Judet:</label>
                            <select id="regions" class="form-control select-location fs-6" required>
                                <option value="">Judet</option>

                                @foreach ($regions as $region)
                                    <option value="{{ $region->id }}">{{ $region->name }} </option>
                                @endforeach

                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="fs-5">Localitate: </label>
                            <div class="fs-6" id="city"></div>
                        </div>

                        <div class="mt-4">
                            <input id="gps_longitude" type="hidden" name="longitude" required>
                            <input id="gps_latitude" type="hidden" name="latitude" required>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label class="fs-5 ">Tip teren:</label>
                            <select name="relief_type" class="form-control fs-6" required>
                                <option value="">Selecteaza</option>
                                <option value="Campie">Campie</option>
                                <option value="Deal">Deal</option>
                                <option value="Munte">Munte</option>
                            </select>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label class="fs-5">La fata locului:</label>
                            <select name="size_volunteer_id" class="form-control select-location fs-6"
                                required>
                                <option value="">Selecteaza</option>
                                @foreach ($size_volunteers as $size_volunteer)
                                    <option class="size-volunteers-create" value="{{ $size_volunteer->id }}">{{ $size_volunteer->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="container mb-3">
                            <div id="create_event_map"></div>
                        </div>

                        <div class="mb-3 col-md-6"  id="address_display">
                            <label class="fs-5" for="pin_address">Adresa selectata:</label>
                            <input class="form-control fs-6" readonly name="address" id="pin_address">
                        </div>

                        <div class="row form-group">
                            <div class="col-sm-12 text-end">
                                <button type="submit" id="volunteer-proposal-add-button"
                                        class="form-submit">Salveaza loc
                                </button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    /*stop sending propose form*/
    $("#volunteer-proposal-add-button").on("click", function() {
        let form = $('#proposalModal form');
        let gps_latitude = $('#gps_latitude').val();
        let gps_longitude = $('#gps_longitude').val();
        let isFormValid = true;
        form.find('[required]').each(function() {
            if (!$(this).val()) {
                isFormValid = false;
                return false;
            }
        });
        if (!gps_latitude && !gps_longitude) {
            alert('Nu ați selectat un punct pe hartă!');
            return false;
        } else if (!isFormValid) {
            alert('Completați toate câmpurile obligatorii!');
            return false;
        } else {
            form.submit();
        }
    });
</script>

<style type="text/css">
    #create_event_map {
        height: 500px;
        width: 100%;
        /* width: 700px;
        height: 500px; */
    }
</style>
