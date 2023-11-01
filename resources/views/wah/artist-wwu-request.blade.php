@extends('layouts.app')
@section('content')
    <div id="content" class="app-content">
        {{-- <h1 class="page-header">Tabs & Accordions <small>header small text goes here...</small></h1> --}}
        <!-- BEGIN row -->
        <div class="row">
            <!-- BEGIN col-6 -->
            <div class="col-xl-12">
                <!-- BEGIN nav-pills -->
                <ul class="nav nav-pills mb-2">
                    <li class="nav-item">
                        {{-- <a href="#nav-pills-tab-1" data-bs-toggle="tab" class="nav-link active">
                            <span class="d-sm-none">Pills 1</span>
                            <span class="d-sm-block d-none">Pills Tab 1</span>
                        </a> --}}
                        <a href="?type=not_registered" class="btn btn-sm rounded"
                            style="{{ request()->get('type') == 'not_registered' || !request()->has('type') ? '  background: rgb(74, 71, 71);color:white' : '' }}">Not
                            Registered
                        </a>
                    </li>
                    <li class="nav-item">
                        {{-- <a href="#nav-pills-tab-2" data-bs-toggle="tab" class="nav-link">
                             <span class="d-sm-none">Pills 2</span>
                             <span class="d-sm-block d-none">Pills Tab 2</span>
                         </a> --}}
                        <a href="?type=registered" class="btn btn-sm rounded"
                            style="{{ request()->get('type') == 'registered' ? '  background: rgb(74, 71, 71);color:white' : '' }}">Registered</a>
                    </li>
                </ul>
                <!-- END nav-pills -->
                <!-- BEGIN tab-content -->
                <div class="tab-content p-3 rounded-top panel rounded-0 m-0  table-responsive">
                    {{-- <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($artists as $item)
                                <tr>
                                    <td>
                                        <span
                                            class="badge {{ $item->is_registred ? 'badge-success' : ' badge-danger' }} badge-pill">{{ $loop->iteration }}</span>
                                    </td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->phone }} </td>
                                    <td>
                                        --
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="6">
                                    {{ $artists->links() }}
                                </td>
                            </tr>
                        </tbody>
                    </table> --}}


                    {{-- <div class="col-md-8 offset-md-2"> --}}
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @php
                                $counter = ($artists->currentPage() - 1) * $artists->perPage() + 1;
                            @endphp
                            @foreach ($artists as $item)
                                <tr>
                                    <td>
                                        <span
                                            class="btn-{{ $item->is_registred ? 'btn-success' : ' btm-danger' }} badge-pill">{{ $counter++ }}</span>
                                    </td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->phone }} </td>
                                    <td>
                                        --
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center">
                        {{ $artists->links('pagination::bootstrap-4') }}
                    </div>
                </div>
                <!-- END tab-content -->

            </div>
            <!-- END col-6 -->

        </div>
        <!-- END row -->
    </div>
    <!-- END #content -->
    </div>
@endsection
