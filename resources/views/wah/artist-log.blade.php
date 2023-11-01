{{-- @extends('layouts.app')
@section('content')
    <div class="app-main">
        <!-- BEGIN .main-content -->
        <div class="main-content">
            <!-- Row start -->
            <div class="row gutters">
                <div class="col-12 pb-3">
                    <!-- <h3>Logs - {{ $logs->count() }}</h3> -->
                    <div class="clearfix"></div>
                    <hr style="border-color: black">
                </div>
                <div class="col-md-12 mb-5">
                    <!-- <input type="text" id="search" class="form-control rounded" placeholder="Enter Serach Booking"
                        style="max-width: 400px" /> -->
                    <br>

                    <!-- <ul class="list-group list-group-flush">
                        @foreach ($logs as $item)
                            @php
                                if ($item->color_code == 'lightgreen') {
                                    $color_code = 'lightgreen-gradient';
                                } elseif ($item->color_code == 'orange') {
                                    $color_code = 'orange-gradient';
                                } else {
                                    $color_code = 'blue-gradient';
                                }
                            @endphp
                            <li
                                class="list-group-item d-flex justify-content-between align-items-center {{ $color_code }}">
                                {{ $loop->iteration }}
                                &nbsp;&nbsp;&mdash;
                                {!! $item->description !!}
                                <span
                                    class="badge
                                badge-primary badge-pill">{{ $item->created_at->diffForHumans() }}</span>
                                |
                                <span class="">{{ date('d-m-Y', strtotime($item->created_at)) }}</span>
                            </li>
                        @endforeach
                    </ul> -->
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Status</th>
                                <th scope="col">Last Update</th>
                                <th scope="col">Time</th>
                                <th scope="col">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($logs as $item)
                                @php
                                    if ($item->color_code == 'lightgreen') {
                                        $color_code = 'lightgreen-gradient';
                                    } elseif ($item->color_code == 'orange') {
                                        $color_code = 'orange-gradient';
                                    } else {
                                        $color_code = 'blue-gradient';
                                    }
                                @endphp

                                <tr class="{{ $color_code }}">
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{!! $item->description !!}</td>
                                    <td>
                                        <span class="badge badge-primary badge-pill">
                                            {{ $item->created_at->diffForHumans() }}
                                        </span>
                                    </td>
                                    <td>{{ date('H:i:s', strtotime($item->created_at)) }}</td>
                                    <td>{{ date('d-m-Y', strtotime($item->created_at)) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection --}}

@extends('layouts.app')

@section('content')

<style>
    .ck-content {
        height: 130px !important;
    }

    .circle-success {
        height: 15px;
        width: 15px;
        border-radius: 100%;
        background-color: lightgreen;
        display: inline-block;
    }

    .circle-warning {
        height: 15px;
        width: 15px;
        border-radius: 100%;
        background-color: orangered;
        display: inline-block;
    }

    .lightgreen-gradient {
        background: linear-gradient(90deg, lightgreen 0%, rgba(163, 163, 191, 0.056) 35%, rgba(184, 212, 218, 0.106) 100%);
        font-size: 13px;

    }

    .orange-gradient {
        background: linear-gradient(90deg, orange 0%, rgba(163, 163, 191, 0.056) 35%, rgba(184, 212, 218, 0.106) 100%);
        font-size: 13px;

    }

    .blue-gradient {
        background: linear-gradient(90deg, lightblue 0%, rgba(163, 163, 191, 0.056) 35%, rgba(184, 212, 218, 0.106) 100%);
        font-size: 13px;

    }
</style>
    <!-- BEGIN #content -->
    <div id="content" class="app-content">
        <!-- BEGIN row -->
        <div class="row">
            <!-- BEGIN col-6 -->
            <div class="col-xl-12">
                <!-- BEGIN panel -->
                <div class="panel panel-inverse" data-sortable-id="table-basic-6">
                    <!-- BEGIN panel-body -->
                    <div class="panel-body">

                        <!-- BEGIN table-responsive -->
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Last Update</th>
                                        <th scope="col">Time</th>
                                        <th scope="col">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                         $counter = ($logs->currentPage() - 1) * $logs->perPage() + 1;
                                    @endphp
                                    @foreach ($logs as $item)
                                        @php
                                            if ($item->color_code == 'lightgreen') {
                                                $color_code = 'lightgreen-gradient';
                                            } elseif ($item->color_code == 'orange') {
                                                $color_code = 'orange-gradient';
                                            } else {
                                                $color_code = 'blue-gradient';
                                            }
                                        @endphp

                                        <tr class="{{ $color_code }}">
                                            <th scope="row">{{ $counter++ }}</th>
                                            <td>{!! $item->description !!}</td>
                                            <td>
                                                <span class="badge badge-primary badge-pill">
                                                    {{ $item->created_at->diffForHumans() }}
                                                </span>
                                            </td>
                                            <td>{{ date('H:i:s', strtotime($item->created_at)) }}</td>
                                            <td>{{ date('d-m-Y', strtotime($item->created_at)) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- END table-responsive -->
                        <div class="d-flex justify-content-center">
                            {{ $logs->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                    <!-- END panel-body -->
                </div>
                <!-- END panel -->
            </div>
            <!-- END col-6 -->
        </div>
        <!-- END row -->
    </div>
    <!-- END #content -->
@endsection
