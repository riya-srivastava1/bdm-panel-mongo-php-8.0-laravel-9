@extends('layouts.app')
@section('content')
    <!-- BEGIN #content -->
    <div id="content" class="app-content">
        <!-- BEGIN row -->
        <div class="row">
            <!-- BEGIN col-6 -->
            <div class="col-xl-16">
                <!-- BEGIN panel -->
                <div class="app-main">
                    <!-- BEGIN .main-content -->
                    <div class="main-content">
                        <!-- Row start -->
                        <div class="row gutters">
                            <h3>Total Artist - {{ $artists->count() }}</h3>
                            <div class="col-12">
                                <div id="map" style="height: 500px; width: auto;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="mapData" value="{{ json_encode($mapData) }}">
                <input type="hidden" id="user_lat" value="28.581598757334735">
                <input type="hidden" id="user_lng" value="77.31933803945806">
            </div>
            <!-- END col-6 -->

        </div>
        <!-- END row -->
    </div>
    <!-- END #content -->
@endsection

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script type="text/javascript"
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC3tBEtsH0JPA8Hh-lbBphyfgZM5KY0Hko"></script>
<script type="text/javascript">


$(document).ready(function() {
    var locations = JSON.parse($('#mapData').val());
  console.log(locations);
    function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 13,
            center: new google.maps.LatLng(parseFloat($('#user_lat').val()), parseFloat($('#user_lng').val())),
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        var infowindow = new google.maps.InfoWindow();

        var marker, i;
        for (i = 0; i < locations.length; i++) {
            marker = new google.maps.Marker({
                position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                map: map
            });

            google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
                    infowindow.setContent(locations[i][0]);
                    infowindow.open(map, marker);
                }
            })(marker, i));
        }
    }

    initMap();
});
</script>
