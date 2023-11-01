@extends('layouts.app')

@section('content')
    @php
        $artists = collect($artists);
        $active_data = [];
        $in_active_data = [];
        $active_artist_count = 0;
        $in_active_artist_count = 0;

        if (isset($artists['active'])) {
            $active_data = $artists['active'];
            $active_artist_count = count($artists['active']);
        }
        if (isset($artists['in-active'])) {
            $in_active_data = $artists['in-active'];
            $in_active_artist_count = count($artists['in-active']);
        }

    @endphp
    <div class="app-main">
        <!-- BEGIN .main-content -->
        <div class="main-content">
            <input type="hidden" id="order_id" value="{{ $order_id }}">
            <!-- Row start -->
            <div class="row gutters">
                <div class="col-12 pb-3">
                    <a href="{{ route('wah.artist.assign.send.notification', $order_id) }}" class="float-right btn btn-info"
                        onclick="return confirm('Are you sure you want to send this notification?')">Send
                        Notification</a>
                    <h3>WAH Artists - {{ $active_artist_count + $in_active_artist_count }}</h3>
                    <div class="clearfix"></div>
                    <hr style="border-color: black">
                </div>
                <div class="col-md-12">

                    <table class="table"
                        style="background-color: beige;
                                margin-bottom: 40px;
                                border-radius: 10px;">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>ORDER_ID</th>
                                <th>USER</th>
                                <th>GENDER</th>
                                <th>LOCATION</th>
                                <th>SERVICES</th>
                                <th>ARTIST_PRICE</th>
                                <th>C/W</th>
                                <th>NET_AMOUNT</th>
                                <th>DATE</th>
                                <th>TIME</th>
                            </tr>
                        </thead>

                        <tbody>
                            @php
                                $serviceData = collect($booking->services);
                            @endphp
                            <tr>
                                <td># </td>
                                <td>{{ $booking->order_id }}</td>
                                <td>
                                    <a target="_blank" href="{{ route('wah.user.details', $booking->user_id) }}"
                                        class="text-info">
                                        {{ $booking->user->name ?? '' }}
                                    </a>
                                </td>
                                <td
                                    style="font-weight:bold;color: {{ $booking->gender == 'Male' ? 'blue' : 'darkmagenta' }}">
                                    {{ $booking->gender }}</td>

                                <td style="width: 160px;">{{ $booking->address['full_address'] ?? '' }}</td>
                                <td>{{ is_array($serviceData) ? '--' : $serviceData->pluck('name')->implode(',') }}
                                </td>
                                <td>{{ $booking->artist_price }} </td>
                                <td>{{ intval($booking->coupon_discount) }} / {{ intval($booking->wallet_discount) }}
                                </td>
                                <td>{{ $booking->net_amount }} </td>
                                <td>{{ $booking->booking_date }} </td>
                                <td>{{ $booking->booking_time }} </td>
                            </tr>

                        </tbody>
                    </table>

                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active active_tab" id="nav-home-tab" data-toggle="tab"
                                href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Active -
                                {{ $active_artist_count }}</a>
                            <a class="nav-item nav-link in_active_tab" id="nav-profile-tab" data-toggle="tab"
                                href="#nav-profile" role="tab" aria-controls="nav-profile"
                                aria-selected="false">In-Active -
                                {{ $in_active_artist_count }}</a>
                        </div>
                    </nav>

                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                            aria-labelledby="nav-home-tab">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Distance</th>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th style="width: 150px">Address</th>
                                        <th>Image</th>
                                        <th>Gender</th>
                                        <th>Status</th>
                                        <th>IAB</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    @foreach ($active_data as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item['distance'] }}</td>
                                            <td>
                                                <a target="blank" class="text-info font-weight-bold"
                                                    href="{{ route('wah.artist.details', $item['id']) }}">{{ $item['name'] }}</a>
                                            </td>
                                            <td>{{ $item['phone'] }}</td>
                                            <td>{{ $item['address'] }}</td>
                                            {{-- <td>{{ implode(',', $item->services) ?? '' }}</td> --}}
                                            <td><img src="{{ $item['image'] }}" height="50" alt="icon" />
                                            </td>
                                            <td>{{ $item['gender'] }} </td>
                                            <td>
                                                <a href="javascript:void(0)"
                                                    class="{{ $item['status'] ? 'circle-success' : 'circle-warning' }}"></a>
                                            </td>
                                            <td>
                                                <a href="javascript:void(0)"
                                                    class="{{ $item['is_booking_accepted'] ? 'circle-success' : 'circle-warning' }}"></a>
                                            </td>

                                            <td>
                                                <a class="text-primary assign_artist" {{-- onclick="return confirm('Are you sure you want to assign this Artist?')" --}}
                                                    href="{{ route('wah.artist.assign.custom.artist', [$order_id, $item['id']]) }}">Assign</a>
                                                {{-- <a class="text-primary"
                                                    href="{{ route('wah.artist.details', $item->id) }}">details</a> --}}
                                                {{-- |
                                                <a class="text-danger" onclick="return confirm('Are you sure?')"
                                                    href="{{ route('wah.sub.services.delete', $item->id) }}">delete</a> --}}
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>

                        </div>
                        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Distance</th>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th style="width: 150px">Address</th>
                                        <th>Image</th>
                                        <th>Gender</th>
                                        <th>Status</th>
                                        <th>IAB</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    @foreach ($in_active_data as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item['distance'] }}</td>
                                            <td>
                                                <a target="blank" class="text-info font-weight-bold"
                                                    href="{{ route('wah.artist.details', $item['id']) }}">{{ $item['name'] }}</a>
                                            </td>
                                            <td>{{ $item['phone'] }}</td>
                                            <td>{{ $item['address'] }}</td>
                                            {{-- <td>{{ implode(',', $item->services) ?? '' }}</td> --}}
                                            <td><img src="{{ $item['image'] }}" height="50" alt="icon" />
                                            </td>
                                            <td>{{ $item['gender'] }} </td>
                                            <td>
                                                <a href="javascript:void(0)"
                                                    class="{{ $item['status'] ? 'circle-success' : 'circle-warning' }}"></a>
                                            </td>
                                            <td>
                                                <a href="javascript:void(0)"
                                                    class="{{ $item['is_booking_accepted'] ? 'circle-success' : 'circle-warning' }}"></a>
                                            </td>

                                            <td>
                                                <a class="text-primary"
                                                    onclick="return confirm('Are you sure you want to assign this Artist?')"
                                                    href="{{ route('wah.artist.assign.custom.artist', [$order_id, $item['id']]) }}">Assign</a>
                                                {{-- <a class="text-primary"
                                                    href="{{ route('wah.artist.details', $item->id) }}">details</a> --}}
                                                {{-- |
                                                <a class="text-danger" onclick="return confirm('Are you sure?')"
                                                    href="{{ route('wah.sub.services.delete', $item->id) }}">delete</a> --}}
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

                <div class="col-12">
                    <div id="map" style="height: 500px; width: auto;">
                    </div>
                </div>


            </div>
        </div>
    </div>
    <input type="hidden" id="mapData" value="{{ json_encode($mapData) }}">
    <input type="hidden" id="user_lat" value="{{ $booking->address['lat'] }}">
    <input type="hidden" id="user_lng" value="{{ $booking->address['lng'] }}">
@endsection

@section('scripts')
    <script>
        $('#nav-home-tab').click(function() {
            $(this).addClass('active');
            $('#nav-home').addClass('show active');
            $('#nav-profile').removeClass('show active');
            $('#nav-profile-tab').removeClass('active');

        });
        $('#nav-profile-tab').click(function() {
            $(this).addClass('active');
            $('#nav-profile').addClass('show active');
            $('#nav-home').removeClass('show active');
            $('#nav-home-tab').removeClass('active');
        });

        $('.assign_artist').click(function(e) {
            e.preventDefault();
            var order_id = $('#order_id').val();
            var url = $(this).attr('href');
            if (confirm('Are you sure you want to assign this Artist?')) {
                var base_url = $("meta[name=base_url]").attr("content");

                $.ajax({
                    type: 'get',
                    url: base_url + "/wah-artist/check-artist-already-assign/" + order_id,
                    success: function(data) {
                        if (data.status) {
                            if (confirm(
                                    'Artist Already Assigned. Are you sure you want to assign this Artist?'
                                )) {
                                window.open(url, '_self');
                            }
                        } else {
                            window.open(url, '_self');
                        }
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            }
        });
    </script>
    <script type="text/javascript"
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC3tBEtsH0JPA8Hh-lbBphyfgZM5KY0Hko"></script>
    <script type="text/javascript">
        var locations = JSON.parse($('#mapData').val());

        function InitMap() {

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
            infowindow.setContent(locations[i][0]);
            infowindow.open(map, marker);
        }

        InitMap();
    </script>

@endsection
