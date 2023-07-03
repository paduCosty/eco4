const APP_URL = window.location.origin;
$(document).ready(function () {

    $("#see-next-edition-details").on("click", function () {
        var regionId = $("#propose_regions_home").val();
        if (regionId) {
            get_region_events(regionId);
        }
    });

    $(document).on('click', '.enrol-button', function () {
        enrol_event_data($(this).attr('users_event_location_id'))
    });

    $('#user_region_address').change(function () {
        $(".cities_by_event_location").remove();
        var region_id = $(this).val();
        $.ajax({
            url: APP_URL + '/cities_by_region_id',
            type: 'Get',
            data: {region_id: region_id},

            success: function (response) {
                var options = '';
                $.each(response.data, function (index, value) {
                    options += '<option class="cities_by_event_location" value="' + value.id + '">' + value.name + '</option>';
                });

                $('#region_volunteer').append(options);

            },
            error: function (xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    });
});

function get_region_events(region_id, event_id = null) {
    if (region_id) {
        $(document).ready(function () {
            $.ajax({
                url: APP_URL + '/approved-events/' + region_id,
                type: 'Get',
                data: {region_id: region_id},

                success: function (response) {
                    $('.remove-card, .change-event-place-title').remove();
                    let event = `<h2 id="next-edition-title" class="common-titles change-event-place-title">Alege locul de desfasurare al actiunii din localitatea selectata</h2>`;
                    if (response.data.length) {
                        $.each(response.data, function (index, value) {
                            event += `
                            <div class="col-12 col-md-4 mb-3 remove-card ">
                                <div class="slider-wrap">
                                    <div class="slider-icon float-start">
                                        <div class="slider-svg ">
                                            <svg width="35" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="18" cy="18" r="18" fill="#F26464"></circle>
                                                <path opacity="0.4" d="M18.9763 9.11361L21.2028 13.5879C21.3668 13.9121 21.6799 14.1372 22.041 14.1872L27.042 14.9156C27.3341 14.9566 27.5992 15.1107 27.7782 15.3458C27.9552 15.5779 28.0312 15.8721 27.9882 16.1612C27.9532 16.4013 27.8402 16.6234 27.6672 16.7935L24.0434 20.3063C23.7783 20.5514 23.6583 20.9146 23.7223 21.2698L24.6145 26.2083C24.7095 26.8046 24.3144 27.3669 23.7223 27.48C23.4783 27.519 23.2282 27.478 23.0082 27.3659L18.5472 25.0417C18.2161 24.8746 17.8251 24.8746 17.494 25.0417L13.033 27.3659C12.4849 27.657 11.8058 27.4589 11.5007 26.9187C11.3877 26.7036 11.3477 26.4584 11.3847 26.2193L12.2769 21.2798C12.3409 20.9256 12.2199 20.5604 11.9558 20.3153L8.33202 16.8045C7.90092 16.3883 7.88792 15.703 8.30301 15.2717C8.31201 15.2627 8.32201 15.2527 8.33202 15.2427C8.50405 15.0676 8.7301 14.9566 8.97415 14.9276L13.9752 14.1982C14.3353 14.1472 14.6484 13.9241 14.8134 13.5979L16.9599 9.11361C17.1509 8.72942 17.547 8.4903 17.9771 8.5003H18.1111C18.4842 8.54533 18.8093 8.77644 18.9763 9.11361Z" fill="white" fill-opacity="0.5"></path>
                                                <path d="M17.992 24.9171C17.7983 24.9231 17.6096 24.9752 17.4399 25.0682L13.0007 27.3871C12.4576 27.6464 11.8076 27.4452 11.503 26.9258C11.3902 26.7136 11.3493 26.4704 11.3872 26.2322L12.2738 21.3032C12.3338 20.9449 12.2139 20.5806 11.9533 20.3284L8.32794 16.8185C7.8976 16.3971 7.88961 15.7056 8.31096 15.2742C8.31695 15.2682 8.32195 15.2632 8.32794 15.2582C8.49967 15.0881 8.72133 14.976 8.95996 14.9409L13.9652 14.2043C14.3277 14.1583 14.6422 13.9321 14.8019 13.6038L16.9776 9.06312C17.1843 8.69682 17.5806 8.47864 18 8.50166C17.992 8.7989 17.992 24.715 17.992 24.9171Z" fill="white" fill-opacity="0.5"></path>
                                            </svg>
                                        </div>

                                        <div class="slider-icon-text ">
                                            <h6>20</h6>
                                            <p>puncte</p>
                                        </div>
                                    </div>

                                    <div class="slider-text float-start mb-3">
                                        <a href="#"
                                        class="enrol-button"
                                             data-bs-toggle="modal"
                                             users_event_location_id="${value.id}"
                                             event_description="${value.description}"
                                             data-bs-target="#enrollModalGeneral"
                                        >
                                            <h5 style="color: #F26464;">${value.event_location.city.name}, ${value.event_location.city.region.name} </h5>
                                        </a>
                                        <p>Când: ${value.due_date}</p>
                                        <p>${value.size_volunteer_name}</p>
                                        <p>Relief: ${value.event_location.relief_type}</p>
                                        <p>Adresa: ${value.event_location.address}</p>
                                    </div>
                                        <div class="button-inscriere text-end ">
                                            <a href="#" class="enrol-button"
                                             data-bs-toggle="modal"
                                             users_event_location_id="${value.id}"
                                             event_description="${value.description}"
                                             data-bs-target="#enrollModalGeneral"
                                               >
                                                Inscriere +
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>`
                            if (event_id === value.id) {
                                $('#enrollModalGeneral').modal('show');
                                enrol_event_data(value.id);
                            }

                        });


                    } else {
                        event += `<h3 id="next-edition-title" class="remove-card common-titles">Nici un eveniment in judetul selectat</h3>`
                    }
                    $("#eco-actions-to-county-count").html(response.cont_data);
                    $('#eco-actions-container').append(event);

                },
                error: function (xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
        });
    }
}

function enrol_event_data(event_id) {
    $.ajax({
        url: APP_URL + '/get-event-location/' + event_id,
        type: 'Get',

        success: function (response) {
            $('.users_event_location_id').val(response.event.id)
            $('#event-description').text(response.event.description)
            $('#event_region_name').text(response.event.region_name)
            $('#event_city_name').text(response.event.city_name)
            $('#event-address').text(response.event.address)

            initMapEnrol(response.event.lat, response.event.lng);
        },
        error: function (xhr, status, error) {
            console.log(xhr.responseText);
        }
    });
}

function initMapEnrol(lat, lng) {
    let zoom = 14;

    if (!lat || !lng) {
        lat = 44.439663;
        lng = 26.096306;
    }

    const map = new google.maps.Map(document.getElementById("enrol_map"), {
        zoom: zoom,
        mapTypeId: google.maps.MapTypeId.HYBRID, // Setarea modului hibrid (satelit cu străzi și etichete)
        center: {
            lat: lat,
            lng: lng
        },
        mapTypeControl: true, // Afișarea controlului pentru selectarea modului de vizualizare
        mapTypeControlOptions: {
            style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
            position: google.maps.ControlPosition.TOP_RIGHT,
            mapTypeIds: [
                google.maps.MapTypeId.HYBRID,
                google.maps.MapTypeId.SATELLITE,
                google.maps.MapTypeId.ROADMAP
            ]
        },
    });

    const marker = new google.maps.Marker({
        position: {
            lat: lat,
            lng: lng
        },
        map: map,
    });
}

