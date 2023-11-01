@extends('layouts.app')
@section('content')
    <!-- BEGIN #app -->

    <!-- BEGIN #content -->
    <div id="content" class="app-content">
        <h3>
            Today's Bookings - {{ $bookings->count() }}
        </h3>
        <div class="card border-0">
            <ul class="nav nav-tabs nav-tabs-v2 px-3">
                <!-- ... Your existing code ... -->
                <li class="nav-item me-2"><a class="nav-link px-2 active" href="#payment-success" data-bs-toggle="tab">Payment
                        Success</a>
                </li>
                <li class="nav-item me-2"><a href="#payment-pending" class="nav-link px-2" data-bs-toggle="tab">Payment
                        Pending & Failed</a>
                </li>

                <!-- <li class="nav-item me-2 align-items-end"> <a href="#"
                                        onclick="return confirm('Are you sure want to Export?')" class="nav-link px-2"><i
                                            class="fa fa-download fa-fw me-1 text-dark text-opacity-50"></i> Export</a></li> -->
                <div class="col-md-6">
                    <p class="text-right">
                        Completed : {{ $compleated }} |
                        Rescheduled : {{ $rescheduled }} |
                        Canceled : {{ $canceled }} |
                        Pending : {{ $pending }}</p>
                </div>
            </ul>
            <div class="tab-content p-3">
                <!-- BEGIN table -->
                <div class="tab-pane table-responsive mb-3 active" id="payment-success" role="tabpanel">
                    <table class="table table-panel text-nowrap align-middle mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>ORDER_ID</th>
                                <th>USER</th>
                                <th>GENDER</th>
                                <th>ARTIST</th>
                                <th>LOCATION</th>
                                <th>SERVICES</th>
                                <th>ARTIST_PRICE</th>
                                <th>C/W_DISCOUNT</th>
                                <th>NET_AMOUNT</th>
                                <th>DATE</th>
                                <th>TIME</th>
                                <th>ASTATUS</th>
                                <th>STATUS</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($bookings as $item)
                                @php
                                    $package = str_contains($item->services[0]['name'], 'Package');
                                    $service_data = '';
                                    foreach ($item->services as $service) {
                                        $quantity = $service['quantity'] > 1 ? ' | X ' . $service['quantity'] : '';
                                        $service_data = '<li>' . $service['name'] . $quantity . ',' . $service_data . '</li>';
                                    }
                                @endphp
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <a class="text-info font-weight-bold"
                                            href="{{ route('wah.booking.action', $item->order_id) }}">
                                            {{ $item->order_id }}
                                        </a>
                                    </td>
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
                                    <td>
                                        @if($item->artist)
                                        <a target="_blank"
                                            href="{{ isset($item->artist->name) ? route('wah.artist.details', $item->artist->id) : '#' }}"
                                            class="text-info text-decoration-none">
                                            <p
                                                class="bg-info-900 text-white p-1 rounded text-center{{ isset($item->artist->name) ? 'bg-info' : 'bg-warning' }}">
                                                {{ $item->artist->name ?? '' }}
                                            </p>
                                        </a>
                                        @endif
                                    </td>

                                    <td>{{ $item->address['full_address'] ?? '' }}</td>
                                    <td>{!! $package
                                        ? '<b>' .
                                            $item->services[0]['name'] .
                                            '</b> | <br/> <b>(</b> ' .
                                            implode(',', $item->services[0]['summery']) .
                                            ' <b>)</b>'
                                        : '<ol class="ol-cls">' . $service_data . '</ol>' !!}</td>
                                    <td>{{ $item->artist_price }}</td>
                                    <td>{{ intval($item->coupon_discount) }}/{{ intval($item->wallet_discount) }}
                                    </td>
                                    <td>{{ $item->net_amount }}</td>
                                    <td>{{ $item->booking_date }} </td>
                                    <td>{{ $item->booking_time }} </td>
                                    <td>{{ $item->wah_action_status ?? (isset($item->artist->name) ? 'in_progress' : 'confirmed') }}
                                    </td>
                                    <td>
                                        @if (boolval($item->service_status))
                                            <span
                                                class="badge border border-success text-success px-2 pt-5px pb-5px rounded fs-12px d-inline-flex align-items-center">
                                                <i class="fa fa-circle fs-9px fa-fw me-5px"></i> Completed
                                            </span>
                                        @elseif (boolval($item->is_canceled))
                                            <span
                                                class="badge border bg-danger text-danger px-2 pt-5px pb-5px rounded fs-12px d-inline-flex align-items-center">
                                                <i class="fa fa-circle fs-9px fa-fw me-5px"></i> Cancelled
                                            </span>
                                        @else
                                            <span
                                                class="badge border border-warning bg-white text-warning-600  px-2 pt-5px pb-5px rounded fs-12px d-inline-flex align-items-center">
                                                <i class="fa fa-circle fs-9px fa-fw me-5px"></i> Pending
                                            </span>
                                        @endif
                                    </td>

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
                </div>
                <div class="tab-pane table-responsive mb-3" id="payment-pending" role="tabpanel"
                    aria-labelledby="nav-profile-tab">
                    <table class="table table-panel text-nowrap align-middle mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>ORDER_ID</th>
                                <th>USER</th>
                                <th>GENDER</th>
                                <th>LOCATION</th>
                                <th>SERVICES</th>
                                <th>ARTIST_PRICE</th>
                                <th>C/W_DISCOUNT</th>
                                <th>NET_AMOUNT</th>
                                <th>DATE</th>
                                <th>TIME</th>
                                <th>ASTATUS</th>
                                <th>PAYMENT STATUS</th>
                                <th>PAYMENT MESSAGE</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($pending_payments as $item)
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
                                    <td>
                                        <a class="text-info font-weight-bold"
                                            href="{{ route('wah.booking.action', $item->order_id) }}">
                                            {{ $item->order_id }}
                                        </a>
                                    </td>
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
                                                {{ $item->user->name ??'' }}
                                            @endif
                                        </a>
                                    </td>
                                    <td
                                        style="font-weight:bold;color: {{ $item->gender == 'Male' ? 'blue' : 'darkmagenta' }}">
                                        {{ $item->gender }}</td>
                                    <td style="width: 160px;">{{ $item->address['full_address'] ?? '' }}</td>
                                    <td>{!! $package
                                        ? '<b>' .
                                            $item->services[0]['name'] .
                                            '</b> | <br/> <b>(</b> ' .
                                            implode(',', $item->services[0]['summery']) .
                                            ' <b>)</b>'
                                        : '<ol class="ol-cls">' . $service_data . '</ol>' !!}</td>
                                    <td>{{ $item->artist_price }}</td>
                                    <td>{{ intval($item->coupon_discount) }}/{{ intval($item->wallet_discount) }}
                                    </td>
                                    <td>{{ $item->net_amount }}</td>
                                    <td>{{ $item->booking_date }} </td>
                                    <td>{{ $item->booking_time }} </td>
                                    <td>{{ $item->wah_action_status ?? (isset($item->artist->name) ? 'in_progress' : 'confirmed') }}
                                    </td>
                                    <td>
                                        @if ($item->status == 'failed')
                                            <span
                                                class="badge border border-danger text-danger px-2 pt-5px pb-5px rounded fs-12px d-inline-flex align-items-center">
                                                <i class="fa fa-circle fs-9px fa-fw me-5px"></i> Failed
                                            </span>
                                        @endif
                                    </td>
                                    <td class="">
                                        {{ $item->payment_message ?? '' }}
                                    </td>

                                    <td>
                                        <a href="{{ route('pay-status') }}/{{ $item->order_id }}">Verify Pemrnt</a>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                    {{ $pending_payments->links() }}
                </div>
                <!-- END table -->
            </div>
        </div>
    </div>
    <!-- END #content -->
@endsection
