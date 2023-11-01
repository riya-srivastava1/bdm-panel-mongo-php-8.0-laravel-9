@extends('layouts.app')
@section('content')
    <!-- BEGIN #content -->
    <div id="content" class="app-content">
        <!-- BEGIN panel -->
        <h3> Bookings - {{ $bookings->total() }} <small class="text-muted">(Except today's)</small></h3>
        <div class="panel panel-inverse" data-sortable-id="table-basic-9">
            <!-- BEGIN panel-body -->
            <div class="panel-body">
                <div class="filter mb-3" id="filter">
                    <div class="d-flex w-50 justify-content-between">
                        <div class="input-group input-group-sm mr-4">
                            <select name="filtertype" id="" class="form-select" title="Filter Type">
                                <option selected>Select Filter Type</option>
                                <option value="order_id">Order id</option>
                                <option value="artist-status">Artist Status</option>
                                <option value="gender">Gender</option>
                                <option value="user">User</option>
                                <option value="artist">Artist</option>
                                <option value="date">Date</option>
                                <option value="price-range">Price Range</option>
                            </select>
                        </div>
                        <div class="input-group input-group-sm" id="f-type"></div>
                    </div>
                </div>
                <!-- BEGIN table-responsive -->
                <div class="table-responsive text-nowrap " id="table-data">
                    <table id="data-table-default" class="table table-bordered align-middle ">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>ORDER ID </th>
                                <th>USER</th>
                                <th>GENDER</th>
                                <th>ARTIST</th>
                                <th>LOCATION</th>
                                <th>SERVICES</th>
                                <th>ARTIST PRICE</th>
                                <th>C/W DISCOUNT</th>
                                <th>NET AMOUNT</th>
                                <th>DATE</th>
                                <th>TIME</th>
                                <th>ARTIST STATUS</th>
                                <th>BOOKING STATUS</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bookings as $item)
                                @php
                                    // $serviceData = collect($item->services);
                                    $package = str_contains($item->services[0]['name'], 'Package');
                                    $service_data = '';
                                    foreach ($item->services as $service) {
                                        $quantity = $service['quantity'] > 1 ? ' | X ' . $service['quantity'] : '';
                                        $service_data = '<li>' . $service['name'] . $quantity . ',' . $service_data . '</li>';
                                    }
                                @endphp
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><a class="text-info font-weight-bold text-nowrap"
                                            href="{{ route('wah.booking.action', $item->order_id) }}">
                                            {{ $item->order_id }}
                                        </a></td>
                                    <td>
                                        <a target="_blank" href="{{ route('wah.user.details', $item->user_id) }}"
                                            class="text-info">
                                            @if ($artist_name = getPreArtistNameGF($item))
                                                <p class="bg-success text-white p-1 rounded text-center">
                                                    {{ $item->user->name ?? '' }} <br>
                                                    <span class="badge badge-warning py-0 px-1 mt-1  rounded">
                                                        PA - {{ $artist_name }}
                                                    </span>
                                                </p>
                                            @else
                                                {{ $item->user->name ?? '' }}
                                            @endif
                                        </a>
                                    </td>
                                    <td
                                        style="font-weight:bold;color: {{ $item->gender == 'Male' ? 'blue' : 'darkmagenta' }}">
                                        {{ $item->gender }}</td>
                                    <td class="{{ isset($item->artist->name) ? 'bg-info ' : 'bg-warning' }}">
                                        <a class="text-white" target="_blank"
                                            href="{{ isset($item->artist->name) ? route('wah.artist.details', $item->artist->id) : '' }}">
                                            {{ $item->artist->name ?? '' }}</a>
                                    </td>
                                    <td style="width: 160px;">{{ $item->address['full_address'] ?? '' }}</td>

                                    <td>
                                        {!! $package
                                            ? '<b>' .
                                                $item->services[0]['name'] .
                                                '</b> | <br/> <b>(</b> ' .
                                                implode(',', $item->services[0]['summery']) .
                                                ' <b>)</b>'
                                            : '<ol class="ol-cls">' . $service_data . '</ol>' !!}
                                    </td>
                                    <td>{{ $item->artist_price }}</td>
                                    <td>{{ intval($item->coupon_discount) }}/{{ intval($item->wallet_discount) }}</td>
                                    <td>{{ $item->net_amount }}</td>
                                    <td>{{ $item->booking_date }} </td>
                                    <td>{{ $item->booking_time }} </td>
                                    <td>{{ $item->wah_action_status ?? (isset($item->artist->name) ? 'in_progress' : 'confirmed') }}
                                    </td>
                                    @if (boolval($item->service_status))
                                        <td class="bg-success">
                                            Completed
                                        </td>
                                    @elseif (boolval($item->is_canceled))
                                        <td class="bg-danger">Cancelled</td>
                                    @else
                                        <td class="bg-white">Pending</td>
                                    @endif
                                    <td>
                                        @if (!boolval($item->service_status) && !boolval($item->is_canceled))
                                            @if (isset($item->artist->name))
                                                <a onclick="return confirm('Artist has Already assigned,You want to changed this artist?')"
                                                    class="text-primary" target="_blank"
                                                    href="{{ route('wah.artist.assign', $item->order_id) }}">
                                                    Assign Artist
                                                </a>
                                            @else
                                                <a class="text-primary" target="_blank"
                                                    href="{{ route('wah.artist.assign', $item->order_id) }}">
                                                    Assign Artist
                                                </a>
                                            @endif
                                        @else
                                            <a target="_blank"
                                                href="{{ route('wah.pre.booking.images', $item->order_id) }}"
                                                class="text-primary">Show Images</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center">
                        {{ $bookings->links('pagination::bootstrap-4') }}
                    </div>
                </div>
                <!-- END table-responsive -->
            </div>
            <!-- END panel-body -->
        </div>
        <!-- END panel -->
    </div>
@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        // alert("ok");
        var selectOpen = `<select name="search" id="search" class="form-select" title="Filter Type">`;
        var selectClose = `</select>`;
        var searchInput = `<input type="text" name="search" id="search" title="Search..."
                                    placeholder="Search..." class="form-control">`;
        var date = `<input type="date" name="search" id="search" title="Search..."
                                    placeholder="Search..." class="form-control">`;

        var priceRange = `<input type="text" name="search" id="min" title="Minimum Amount"
                                    placeholder="Minimum Amount..." class="form-select mr-4">
                          <input type="text" name="search" id="max" title="Maximum Amount"
                                    placeholder="Maximum Amount..." class="form-select">`;
        var bookingStatus = $(document).on("change", "[name='filtertype']", function() {
            let type = $(this).val();
            // console.log(type);
            if (type == 'booking-status') {
                let gender = selectOpen +
                    `<option selected disabled>Select Booking Status</option>
                        <option value='pending'>Pending</option>
                    <option value='complete'>Completed</option>
                    <option value='cancelled'>Cancelled</option>` +
                    selectClose;
                $("#f-type").html(gender);
            } else if (type == 'order_id') {
                $("#f-type").html(searchInput);
            } else if (type == 'artist-status') {
                let wahActionStatus = selectOpen +
                    `<option selected disabled>Select Artist Action Status</option>
                        <option value='in_progress'>In Progress</option>
                        <option value='proceed'>Proceed</option>
                        <option value='reached'>Reached</option>
                        <option value='start'>Start</option>
                        <option value='completed'>Completed</option>` +
                    selectClose;
                $("#f-type").html(wahActionStatus);
            } else if (type == 'gender') {
                let gender = selectOpen +
                    `<option selected disabled>Select Gender</option>
                        <option value='male'>Male</option>
                    <option value='female'>Female</option>` +
                    selectClose;
                $("#f-type").html(gender);
            } else if (type == 'services') {
                $("#f-type").html(searchInput);
            } else if (type == 'date') {
                $("#f-type").html(date);
            } else if (type == 'user') {
                $("#f-type").html(searchInput);
            } else if (type == 'artist') {
                $("#f-type").html(searchInput);
            } else if (type == 'price-range') {
                $("#f-type").html(priceRange);
            }
        });

        // else if (type == 'booking-date') {
        //     let bookingDate = selectOpen +
        //         `<option selected disabled>Booking Date Order</option>
    //                 <option value='asc'>Ascending</option>
    //             <option value='desc'>Descending</option>` +
        //         selectClose;
        //     $("#f-type").html(bookingDate);
        // }

        $(document).on("change", "[name='search']", function() {
            let ftype = $("[name='filtertype']").val();
            let val = $(this).val();
            let url = '{{ route('wah.bookings.filter') }}';
            if (ftype !== 'price-range') {
                searchAjaxFunction(ftype, val, 1, url);
            } else {
                let min = $("#min").val();
                let max = $("#max").val();
                console.log(min + "," + max);
                if (min != '' && max != '') {
                    console.log("done");
                    let val = min + "-" + max;
                    searchAjaxFunction(ftype, val, 1, url);
                }
            }
        });

        // $(document).on("keyup", "[name='search']", function() {

        //     let ftype = $("[name='filtertype']").val();
        //     if (ftype == 'price-range') {
        //         let min = $("#min").val();
        //         let max = $("#max").val();
        //         if (min != '' && max > min) {
        //             let val = min + "-" + max;
        //             searchAjaxFunction(ftype, val, 1);
        //         }
        //     } else {
        //         let val = $(this).val();
        //         if (val.lenght >= 2) {
        //             searchAjaxFunction(ftype, val, 1);
        //         }
        //     }
        // });

        function searchAjaxFunction(ftype, val, page, url) {
            $("#loading-wrapper").css('display', 'block');
            $.ajax({
                type: 'GET',
                url: url,
                data: {
                    _token: '{{ csrf_token() }}',
                    type: ftype,
                    val: val,
                    wah_artist_id: $('#wah_artist_id').val()
                },
                success: function(data) {
                    // console.log(data);
                    $("#loading-wrapper").css('display', 'none');
                    $("#table-data").html(data.html);
                    // table-data
                    // console.log(data);
                }
            });
        }
        // alert("Hello");

        $(document).on("click", ".pagination a", function(e) {
            e.preventDefault();
            // let url = $(this).attr('href');
            let url = '{{ route('wah.bookings.filter') }}?page=' + $(this).text().trim();
            let page = $(this).text();
            let ftype = $("[name='filtertype']").val();
            let val = $("[name='search']").val();
            if (ftype == 'price-range') {
                let min = $("#min").val();
                let max = $("#max").val();
                if (min != '' && max != '') {
                    val = min + "-" + max;
                }
            }
            searchAjaxFunction(ftype, val, page, url);
        });

        $(function() {
            $('.app-side').toggleClass('is-mini');
        });
    </script>
@endsection
@endsection
