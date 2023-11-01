<table class="table">
    <thead>
        <tr>
            {{-- <th>X</th> --}}
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
            <th>STATUS</th>
            {{-- <th>Action</th> --}}
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

                {{-- @if (!boolval($item->service_status) && !boolval($item->is_canceled))
                    <td class="badge badge-primary badge-pill">
                        <a href="{{ route('wah.bookings.reschedule', $item->id) }}">
                            Reschedule
                        </a>
                    </td>
                @else
                    <td></td>
                @endif --}}
                <td>{{ $loop->iteration }}</td>
                <td><a class="text-info font-weight-bold" href="{{ route('wah.booking.action', $item->order_id) }}">
                        {{ $item->order_id }}
                    </a></td>
                <td>
                    <a target="_blank" href="{{ route('wah.user.details', $item->user_id) }}" class="text-info">
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
                <td style="font-weight:bold;color: {{ $item->gender == 'Male' ? 'blue' : 'darkmagenta' }}">
                    {{ $item->gender }}</td>
                <td class="{{ isset($item->artist->name) ? 'bg-info ' : 'bg-warning' }}">
                    <a class="text-white" target="_blank"
                        href="{{ isset($item->artist->name) ? route('wah.artist.details', $item->artist->id) : '' }}">
                        {{ $item->artist->name ?? '' }}</a>
                </td>
                <td style="width: 160px;">{{ $item->address['full_address'] ?? '' }}</td>
                {{-- <td>{{ is_array($serviceData) ? '--' : $serviceData->pluck('name')->implode(',') }}
                </td> --}}
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
                        <a target="_blank" href="{{ route('wah.pre.booking.images', $item->order_id) }}"
                            class="text-primary">Show Images</a>
                    @endif
                </td>
            </tr>
        @endforeach
        {{-- <tr>
            <td colspan="3"></td>
            <td colspan="6">
                {{ $bookings->appends($_GET)->links() }}
            </td>
        </tr> --}}
    </tbody>
</table>
