function initialize() {
    const successCallback = (position) => {
        var lat = position.coords.latitude;
        var long = position.coords.longitude;

        // Creating map object
        var map = new google.maps.Map(document.getElementById("map_canvas"), {
            zoom: 12,
            center: new google.maps.LatLng(lat, long),
            mapTypeId: google.maps.MapTypeId.ROADMAP,
        });

        // creates a draggable marker to the given coords
        var vMarker = new google.maps.Marker({
            position: new google.maps.LatLng(lat, long),
            draggable: true,
        });

        // adds a listener to the marker
        // gets the coords when drag event ends
        // then updates the input with the new coords
        google.maps.event.addListener(vMarker, "dragend", function (evt) {
            $("#latitude").val(evt.latLng.lat().toFixed(6));
            $("#longitude").val(evt.latLng.lng().toFixed(6));

            let myLat = evt.latLng.lat().toFixed(6);
            let myLong = evt.latLng.lng().toFixed(6);

            // const geoApiUrl = `https://api.bigdatacloud.net/data/reverse-geocode-client?latitude=${myLat}&longitude=${myLong}&localityLanguage=id`;

            const geocodeApiReverse = `https://nominatim.openstreetmap.org/reverse.php?lat=${myLat}&lon=${myLong}&format=jsonv2`;

            fetch(geocodeApiReverse)
                .then((res) => res.json())
                .then((data) => {
                    // console.log(data);
                    // var lengtAdministrative = Object.keys(data.localityInfo.administrative);
                    // $("#alamat").val(data.localityInfo.administrative[lengtAdministrative.length - 1].name + ", " + data.localityInfo.administrative[lengtAdministrative.length - 2].name);
                    $("#alamat").val(data.display_name);
                });

            map.panTo(evt.latLng);
        });

        // centers the map on markers coords
        map.setCenter(vMarker.position);

        // adds the marker on the map
        vMarker.setMap(map);
    };

    const errorCallback = (error) => {
        console.log(error);
    };

    navigator.geolocation.getCurrentPosition(successCallback, errorCallback, {
        enableHighAccuracy: true,
        timeout: 1000,
    });
}
