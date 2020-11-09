function loadmap(){
    map = new google.maps.Map(document.getElementById('map'),{
        zoom : 11,
        center : new google.maps.LatLng(5.355656,10.426239),
        mapTypeControl: true,
        scrollwheel: false,
        mapTypeControlOptions: {
            style: google.maps.NavigationControlStyle.ZOOM_PAN
        }
    });
}