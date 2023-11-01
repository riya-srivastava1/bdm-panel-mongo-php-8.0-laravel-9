var base_url = $('meta[name="base_url"]').attr("content");
var componentForm = {
    street_number: "short_name",
    route: "long_name",
    locality: "long_name",
    administrative_area_level_1: "short_name",
    country: "long_name",
    postal_code: "short_name",
};

if ($("#lat_txt").val() == "null" || $("#lng_txt").val() == "null") {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            var lat = position.coords.latitude;
            var lng = position.coords.longitude;
            var latlng = { lat: lat, lng: lng };
            //  console.log(latlng);
            document.getElementById("lat_txt").value = lat;
            document.getElementById("lng_txt").value = lng;
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({ location: latlng }, function (results, status) {
                if (status === "OK") {
                    // console.log(results[0].place_id);
                    document.getElementById("map_place_id").value =
                        results[0].place_id;
                    localStorage.setItem(
                        "formatted_address",
                        results[0].formatted_address
                    );
                    for (
                        var i = 0;
                        i < results[0].address_components.length;
                        i++
                    ) {
                        var types = results[0].address_components[i].types[0];
                        var value = results[0].address_components[i].long_name;
                        // console.log(`type - ${types} , value - ${value}`);
                        if (types === "political") {
                            $("#locality").val(value);
                        }
                        if (types === "administrative_area_level_1") {
                            $("#state").val(value);
                        }
                        if (types === "locality") {
                            document.getElementById("profile-city").value =
                                value;
                        }
                        if (types === "postal_code") {
                            //  console.log("postal code");
                            document.getElementById("zipcode").value = value;
                        }
                        document.getElementById("searchbox").value =
                            results[0].formatted_address;
                    }
                }
            });
        });
    }
}

$(document).on("click", ".locate-me-btn", function () {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            var lat = position.coords.latitude;
            var lng = position.coords.longitude;
            var latlng = { lat: lat, lng: lng };
            //  console.log(latlng);
            document.getElementById("lat_txt").value = lat;
            document.getElementById("lng_txt").value = lng;
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({ location: latlng }, function (results, status) {
                if (status === "OK") {
                    console.log(results);
                    document.getElementById("map_place_id").value =
                        results[0].place_id;

                    localStorage.setItem(
                        "formatted_address",
                        results[0].formatted_address
                    );
                    for (
                        var i = 0;
                        i < results[0].address_components.length;
                        i++
                    ) {
                        var types = results[0].address_components[i].types[0];
                        var value = results[0].address_components[i].long_name;
                        // console.log(`type - ${types} , value - ${value}`);
                        if (types === "political") {
                            $("#locality").val(value);
                        }
                        if (types === "administrative_area_level_1") {
                            $("#state").val(value);
                        }
                        if (types === "locality") {
                            document.getElementById("profile-city").value =
                                value;
                        }
                        if (types === "postal_code") {
                            //  console.log("postal code");
                            document.getElementById("zipcode").value = value;
                        }
                        document.getElementById("searchbox").value =
                            results[0].formatted_address;
                    }
                }
            });
        });
    }
});

function initMap() {
    var input = document.getElementById("searchbox");
    var autocomplete = new google.maps.places.Autocomplete(input);
    autocomplete.setComponentRestrictions({ country: ["in"] });
    autocomplete.addListener("place_changed", function () {
        var place = autocomplete.getPlace();
        console.log(place);
        var lat = place.geometry.location.lat();
        var lng = place.geometry.location.lng();
        $("#lat_txt").val(lat);
        $("#lng_txt").val(lng);
        document.getElementById("map_place_id").value = place.place_id;

        localStorage.setItem("formatted_address", place.formatted_address);
        for (var i = 0; i < place.address_components.length; i++) {
            var types = place.address_components[i].types[0];
            var value = place.address_components[i].long_name;
            // console.log(`type - ${types} , value - ${value}`);
            // console.log(value);
            if (types === "political") {
                $("#locality").val(value);
            }
            if (types === "administrative_area_level_1") {
                $("#state").val(value);
            }
            if (types === "locality") {
                document.getElementById("profile-city").value = value;
            }
            if (types === "postal_code") {
                document.getElementById("zipcode").value = value;
            }
        }
    });
}
