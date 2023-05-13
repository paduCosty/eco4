const getUrl = window.location;
if (getUrl.pathname === '/') {
    $(document).ready(function () {
        var APP_URL = window.location.origin;
        $('#propose_regions_home').change(function () {
            get_cities_by_region(this, 'region_cities_home')
        });

        $('#propose_regions_modal').change(function () {
            get_cities_by_region(this, 'region_cities_modal')
        });

        function get_cities_by_region(element, element_class_name) {
            $('.' + element_class_name).remove();
            var region_id = $(element).val();
            $.ajax({
                url: APP_URL + '/cities-if-event-exists',
                type: 'Get',
                data: {region_id: region_id},

                success: function (response) {
                    console.log(response);
                    var options = '';
                    $.each(response.data, function (index, value) {
                        options += `<option class="${element_class_name}" lat="${value.latitude}" lng="${value.longitude}" value="${value.id}">${value.name}</option>`;
                    });

                    $('#' + element_class_name).append(options);

                },
                error: function (xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
        }

        $(document).on('change', '.insert-localities', function () {
            const cityId = $(this).val();
            $.ajax({
                url: APP_URL + '/get-event-locations/' + cityId,
                success: function (data) {
                    initMapPropose(data)
                },
                error: function () {
                    alert('Could not get locations for selected city.');
                }
            });
        });

        /*stop sending propose form*/
        $("#volunteer-proposal-add-button").on("click", function () {
            let form = $('#proposalModal form');
            let place_selected = $('#gps_place_selected').val();
            let isFormValid = true;
            form.find('[required]').each(function () {
                if (!$(this).val()) {
                    isFormValid = false;
                    return false;
                }
            });
            if (!place_selected) {
                alert('Nu ați selectat un punct pe hartă!');
                return false;
            } else if (!isFormValid) {
                alert('Completați toate câmpurile obligatorii!');
                return false;
            } else {
                form.submit();
            }
        });

    });

    let selectedMarker = null;

    function initMapPropose(data) {
        let lat = 44.439663;
        let lng = 26.096306;
        let zoom = 7;

        if (data) {
            zoom = 15;
            lat = data.city.latitude;
            lng = data.city.longitude;

        }
        var mapOptions = {
            zoom: zoom,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            center: new google.maps.LatLng(lat, lng)
        };

        const map = new google.maps.Map(document.getElementById('map'), mapOptions);

        if (data) {
            for (i = 0; i < data.event_locations.length; i++) {
                const location = data.event_locations[i];
                const marker = new google.maps.Marker({
                    map: map,
                    position: new google.maps.LatLng(location.latitude, location.longitude)
                });

                marker.addListener('click', function () {
                    // deselectare marker anterior
                    if (selectedMarker !== null) {
                        selectedMarker.setIcon(null);
                    }

                    selectedMarker = marker;
                    marker.setIcon('https://maps.google.com/mapfiles/kml/paddle/grn-stars.png');

                    document.getElementById('gps_place_selected').value = location.id;

                    console.log(location);
                    $('#gps-elements').remove();
                    $('#marker-values').append(`
                         <div id="gps-elements" class="bg-light p-3 rounded">
                            <p class="font-weight-bold mb-1">Tipul reliefului: <span class="text-secondary">${location.relief_type}</span></p>
                            <p class="font-weight-bold mb-1">Adresa evenimentului: <span class="text-secondary">${location.address}</span></p>
                            <p class="font-weight-bold mb-1">Necesarul de voluntari: <span class="text-secondary">${location.size_volunteer.name}</span></p>
                        </div>

                        <style>
                            #gps-elements {
                                border: 1px solid #ddd;
                            }
                        </style>
                    `);
                });
            }
        }

    }

    function initializeMaps() {
        initMapPropose()
    }

}
