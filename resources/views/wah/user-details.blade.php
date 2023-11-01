@extends('layouts.app')
@section('dashboard', 'selected')
@section('styles')
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
    </style>
@endsection
@section('content')

    <div class="app-main">
        <!-- BEGIN .main-content -->
        <div class="main-content">
            <!-- Row start -->
            <div class="row gutters">
                <div class="col-12 pb-3">
                    {{-- <a href="{{ route('wah.artist.create') }}" class="float-right btn btn-info">Create Artist</a> --}}
                    <h3>User Details</h3>
                    <div class="clearfix"></div>
                    <hr style="border-color: black">
                </div>
                <div class="col-md-10 offset-md-1">
                    <br>
                    <table class="table">
                        <tbody>
                            <tr>
                                <th>#</th>
                                <td><img src="{{ $user->image ?? '' }}" alt="image"></td>
                            </tr>
                            <tr>
                                <th>Name</th>
                                <td>{{ $user->name ?? '' }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $user->email ?? '' }}</td>
                            </tr>
                            <tr>
                                <th>Gender</th>
                                <td>{{ $user->gender ?? '' }}</td>
                            </tr>
                            <tr>
                                <th>Phone</th>
                                <td>{{ $user->phone ?? '' }}</td>
                            </tr>
                            <tr>
                                <th>City</th>
                                <td>{{ $user->city ?? '' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>


            </div>
        </div>
    </div>

@endsection

@section('scripts')


@endsection
