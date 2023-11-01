
@extends('layouts.app')
@section('content')
    <!-- BEGIN #content -->
    <div id="content" class="app-content">
        <!-- BEGIN row -->
        <div class="row">
            <!-- BEGIN col-6 -->
            <div class="col-xl-14">
                <!-- BEGIN panel -->
                <div class="panel panel-inverse" data-sortable-id="table-basic-6">
                    <!-- BEGIN panel-body -->
                    <div class="panel-body">
                        <!-- BEGIN table-responsive -->
                        <div class="table-responsive">
                            <h3>Booking Action</h3>
                            <table class="table text-nowrap">
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
                                    @php
                                        // $serviceData = collect($booking->services);
                                        $is_pending = false;
                                        $package = str_contains($booking->services[0]['name'], 'Package');
                                        $service_data = '';
                                        foreach ($booking->services as $service) {
                                            $quantity = $service['quantity'] > 1 ? ' | X ' . $service['quantity'] : '';
                                            $service_data = '<li>' . $service['name'] . $quantity . ',' . $service_data . '</li>';
                                        }
                                    @endphp
                                    <tr>
                                        {{-- @if (!boolval($booking->service_status) && !boolval($booking->is_canceled))
                                            <td class="badge badge-primary badge-pill">
                                                <a href="{{ route('wah.bookings.reschedule', $booking->id) }}">
                                                    Reschedule
                                                </a>
                                            </td>
                                        @else
                                            <td></td>
                                        @endif --}}
                                        <td>1</td>
                                        <td>{{ $booking->order_id }}</td>
                                        <td>
                                            <a target="_blank" href="{{ route('wah.user.details', $booking->user_id) }}"
                                                class="text-info">
                                                {{ $booking->user->name ?? '' }}
                                            </a>
                                        </td>
                                        <td style="font-weight:bold;color: {{ $booking->gender == 'Male' ? 'blue' : 'darkmagenta' }}">
                                            {{ $booking->gender }}</td>
                                        <td class="{{ isset($booking->artist->name) ? 'bg-info ' : 'bg-warning' }}">
                                            <a class="text-white" target="_blank"
                                                href="{{ isset($booking->artist->name) ? route('wah.artist.details', $booking->artist->id) : '' }}">
                                                {{ $booking->artist->name ?? '' }}</a>
                                        </td>
                                        <td style="width: 160px;">{{ $booking->address['full_address'] ?? '' }}</td>
                                        <td>
                                            {!! $package
                                                ? '<b>' .
                                                    $booking->services[0]['name'] .
                                                    '</b> | <br/> <b>(</b> ' .
                                                    implode(',', $booking->services[0]['summery']) .
                                                    ' <b>)</b>'
                                                : '<ol class="ol-cls">' . $service_data . '</ol>' !!}
                                        </td>
                                        <td>{{ $booking->artist_price }}</td>
                                        <td>{{ intval($booking->coupon_discount) }}/{{ intval($booking->wallet_discount) }}</td>
                                        <td>{{ $booking->net_amount }}</td>
                                        <td>{{ $booking->booking_date }} </td>
                                        <td>{{ $booking->booking_time }} </td>
                                        <td>{{ $booking->wah_action_status ?? (isset($booking->artist->name) ? 'in_progress' : 'confirmed') }}
                                        </td>
                                        @if (boolval($booking->service_status))
                                            <td class="bg-success">
                                                Completed
                                            </td>
                                        @elseif (boolval($booking->is_canceled))
                                            <td class="bg-danger">Cancelled</td>
                                        @else
                                            <td class="bg-white">Pending</td>
                                            @php
                                                $is_pending = true;
                                            @endphp
                                        @endif
                                        <td>
                                            @if (!boolval($booking->service_status) && !boolval($booking->is_canceled))
                                                @if (isset($booking->artist->name))
                                                    <a onclick="return confirm('Artist has Already assigned,You want to changed this artist?')"
                                                        class="text-primary" target="_blank"
                                                        href="{{ route('wah.artist.assign', $booking->order_id) }}">
                                                        Assign Artist
                                                    </a>
                                                @else
                                                    <a class="text-primary" target="_blank"
                                                        href="{{ route('wah.artist.assign', $booking->order_id) }}">
                                                        Assign Artist
                                                    </a>
                                                @endif
                                            @else
                                                <a target="_blank" href="{{ route('wah.pre.booking.images', $booking->order_id) }}"
                                                    class="text-primary">Show Images</a>
                                            @endif
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                        <!-- END table-responsive -->
                    </div>
                    <!-- END panel-body -->
                </div>
                <!-- END panel -->
            </div>
            <!-- END col-6 -->
            {{-- <div class="col-xl-6">
                <!-- BEGIN panel -->
                <div class="panel panel-inverse" data-sortable-id="form-validation-1">
                    <!-- BEGIN panel-body -->
                    <div class="panel-body"> --}}
                        <div class="col-md-6  text-center mt-5 bg-white rounded p-4 border-right border-left">
                            <h3>Update Action -
                                <a href="{{ route('wah.bookings.reschedule', $booking->id) }}"
                                    class="btn btn-warning {{ $booking->service_status || $booking->is_canceled ? 'd-none' : '' }}">Reschedule</a>
                            </h3>
                            <form
                                class="{{ empty($booking->wah_artist_id) ? 'd-none' : '' }} {{ $booking->service_status || $booking->is_canceled ? 'd-none' : '' }}"
                                action="{{ route('wah.booking.artist.action', $booking->order_id) }}" method="post">
                                @csrf
                                <!-- {{ $booking->service_status || $booking->is_canceled ? 'd-none' : '' }} -->
                                <table class="table  table-striped table-hover mt-4">
                                    <tbody>
                                        <tr>
                                            <td>Update Artist Action</td>
                                            <td>
                                                <select class="form-select" name="artist_action">
                                                    <option {{ $booking->wah_action_status == 'proceed' ? 'selected' : '' }}
                                                        value="proceed">proceed</option>
                                                    <option {{ $booking->wah_action_status == 'reached' ? 'selected' : '' }}
                                                        value="reached">reached</option>
                                                    <option {{ $booking->wah_action_status       == 'start' ? 'selected' : '' }}
                                                        value="start">start</option>
                                                    <option {{ $booking->wah_action_status == 'completed' ? 'selected' : '' }}
                                                        value="complete">complete</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input onclick="return confirm('Are you sure?')" type="submit" class="btn btn-info"
                                                    value="Update" />
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </form>
                            <form action="{{ route('wah.booking.status.action', $booking->order_id) }}" method="post">
                                @csrf
                                <table class="table  table-striped table-hover mt-4">
                                    <tbody>
                                        <tr>
                                            <td>Update Booking Status</td>
                                            <td>
                                                <select name="booking_action">
                                                    @if (!$is_pending)
                                                        <option value="in_progress">In Progress</option>
                                                    @endif
                                                    <option value="Complete">Complete</option>
                                                    <option value="Cancel">Cancel</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input onclick="return confirm('Are you sure?')" type="submit" class="btn btn-info"
                                                    value="Update" />
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </form>
                        </div>

                        <div class="col-md-6  text-center mt-5 bg-white rounded p-4 border-left border-right">



                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Comment</th>
                                            <th>Rating</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($userCommentToZoylee && $userCommentToZoylee->count())
                                            <tr style="background: rgba(151, 176, 176, 0.442)">
                                                <td colspan="2" class="text-center">User Comment to Zoylee</td>
                                            </tr>
                                            <tr>
                                                <td>{{ $userCommentToZoylee->comment }}</td>
                                                <td class="{{ $userCommentToZoylee->rating < 3 ? 'bg-danger' : '' }}">
                                                    {{ $userCommentToZoylee->rating }}</td>
                                            </tr>
                                        @endif
                                        @if ($userCommentToArtist && $userCommentToArtist->count())
                                            <tr style="background: rgba(233, 240, 199, 0.468)">
                                                <td colspan="2" class="text-center">User Comment to Artist</td>
                                            </tr>
                                            <tr>
                                                <td>{{ $userCommentToArtist->comment }}</td>
                                                <td class="{{ $userCommentToArtist->rating < 3 ? 'bg-danger' : '' }}">
                                                    {{ $userCommentToArtist->rating }}</td>
                                            </tr>
                                        @endif
                                        @if ($artistCommentToCustomer && $artistCommentToCustomer->count())
                                            <tr style="background: rgba(211, 206, 171, 0.416)">
                                                <td colspan="2" class="text-center">Artist Comment to Customer</td>
                                            </tr>
                                            <tr>
                                                <td>{{ $artistCommentToCustomer->comment }}</td>
                                                <td class="{{ $artistCommentToCustomer->rating < 3 ? 'bg-danger' : '' }}">
                                                    {{ $artistCommentToCustomer->rating }}</td>
                                            </tr>
                                        @endif

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    {{-- </div>
                    <!-- END panel-body -->
                </div>
                <!-- END panel -->
            </div> --}}
        </div>
        <!-- END row -->
    </div>
    <!-- END #content -->
@endsection
