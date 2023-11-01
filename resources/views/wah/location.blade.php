@extends('layouts.app')
@section('content')
    <!-- BEGIN #content -->
    <div id="content" class="app-content">
        <!-- BEGIN row -->
        <div class="row">
            <!-- BEGIN col-6 -->
            <div class="col-xl-6">

                <!-- BEGIN panel -->
                <div class="panel panel-inverse" data-sortable-id="table-basic-6">
                    <!-- BEGIN panel-body -->
                    <div class="panel-body">
                        <!-- BEGIN table-responsive -->
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($location as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->city }}</td>
                                            <td>
                                                <a class="text-primary"
                                                    href="{{ route('wah.location.edit', $item->id) }}">edit</a>
                                                |
                                                <a class="text-danger" onclick="return confirm('Are you sure?')"
                                                    href="{{ route('wah.location.delete', $item->id) }}">delete</a>
                                            </td>
                                        </tr>
                                    @endforeach
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
            <div class="col-xl-6">
                <!-- BEGIN panel -->
                <div class="panel panel-inverse" data-sortable-id="form-validation-1">
                    <!-- BEGIN panel-heading -->
                    {{-- <div class="panel-heading">
                        <h4 class="panel-title">Basic Form Validation</h4>
                    </div> --}}
                    <!-- END panel-heading -->
                    <!-- BEGIN panel-body -->
                    <div class="panel-body">
                        {{-- <form class="form-horizontal" data-parsley-validate="true" name="demo-form">
                            <div class="form-group row mb-3">
                                <label class="col-lg-4 col-form-label form-label" for="fullname">Full Name * :</label>
                                <div class="col-lg-8">
                                    <input class="form-control" type="text" id="fullname" name="fullname"
                                        placeholder="Required" data-parsley-required="true" />
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="col-lg-4 col-form-label form-label" for="email">Email * :</label>
                                <div class="col-lg-8">
                                    <input class="form-control" type="text" id="email" name="email"
                                        data-parsley-type="email" placeholder="Email" data-parsley-required="true" />
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="col-lg-4 col-form-label form-label" for="website">Website :</label>
                                <div class="col-lg-8">
                                    <input class="form-control" type="url" id="website" name="website"
                                        data-parsley-type="url" placeholder="url" />
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="col-lg-4 col-form-label form-label" for="message">Message (20 chars min, 200
                                    max) :</label>
                                <div class="col-lg-8">
                                    <textarea class="form-control" id="message" name="message" rows="4" data-parsley-minlength="20"
                                        data-parsley-maxlength="100" placeholder="Range from 20 - 200"></textarea>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="col-lg-4 col-form-label form-label" for="message">Digits :</label>
                                <div class="col-lg-8">
                                    <input class="form-control" type="text" id="digits" name="digits"
                                        data-parsley-type="digits" placeholder="Digits" />
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="col-lg-4 col-form-label form-label" for="message">Number :</label>
                                <div class="col-lg-8">
                                    <input class="form-control" type="text" id="number" name="number"
                                        data-parsley-type="number" placeholder="Number" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label form-label">&nbsp;</label>
                                <div class="col-lg-8">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </form> --}}
                        @if ($isEdit)
                            <form action="{{ route('wah.location.update', $editLocation->id) }}" method="post">
                                @csrf
                                @method('PATCH')
                                <div class="row pb-3">
                                    <div class="col-md">
                                        <label for="lat" class="small text-muted">lat*</label>
                                        <input type="text"
                                            value="{{ $editLocation->coordinates ? $editLocation->coordinates['coordinates'][1] : '' }}"
                                            id="lat_txt" readonly class="form-control" name="lat" placeholder="lat"
                                            required>
                                    </div>
                                    <div class="col-md">
                                        <label for="lng" class="small text-muted">lng*</label>
                                        <input type="text"
                                            value="{{ $editLocation->coordinates ? $editLocation->coordinates['coordinates'][0] : '' }}"
                                            id="lng_txt" class="form-control" name="lng" placeholder="lng" readonly
                                            required>
                                    </div>
                                    <div class="col-md">
                                        <label for="map_place_id" class="small text-muted">map_place_id*</label>
                                        <input type="text" value="{{ $editLocation->map_place_id }}" id="map_place_id"
                                            class="form-control" name="map_place_id" placeholder="map_place_id" readonly
                                            required>
                                    </div>

                                </div>
                                <div class="row pb-3">

                                    <div class="col-md">
                                        <label for="zipcode" class="small text-muted">Zipcode*</label>
                                        <input type="text" value="{{ $editLocation->zipcode }}" id="zipcode"
                                            maxlength="6" minlength="6" class="form-control" name="zipcode"
                                            placeholder="Zip Code" required>
                                    </div>
                                    <div class="col-md">
                                        <label for="City" class="small text-muted">City*</label>
                                        <input type="text" value="{{ $editLocation->city }}" id="profile-city"
                                            class="form-control" name="city" placeholder="City" required>
                                    </div>
                                </div>

                                <div class="row pb-3">
                                    <div class="col-md">
                                        <label for="Address" class="small text-muted">Address*</label>
                                        <textarea id="searchbox" name="address" cols="30" rows="5" class="form-control" placeholder="Address">{{ $editLocation->address }}</textarea>
                                        <button type="button" class="btn btn-outline-info py-0 rounded-0 locate-me-btn">
                                            Auto Locate
                                        </button>
                                    </div>
                                </div>

                                <div class="row pb-3">

                                    <div class="col-md text-right">
                                        <input type="submit" class=" btn btn-block btn-warning" value="Submit" />
                                    </div>
                                </div>
                            </form>
                        @else
                            <h3 class="text-center pb-2">Create</h3>
                            <hr class="border-dark pb-2">
                            <form action="{{ route('wah.location.store') }}" method="post">
                                @csrf
                                <div class="row pb-3">
                                    <div class="col-md">
                                        <label for="lat" class="small text-muted">lat*</label>
                                        <input type="text" id="lat_txt" readonly class="form-control" name="lat"
                                            placeholder="lat" required>
                                    </div>
                                    <div class="col-md">
                                        <label for="lng" class="small text-muted">lng*</label>
                                        <input type="text" id="lng_txt" class="form-control" name="lng"
                                            placeholder="lng" readonly required>
                                    </div>
                                    <div class="col-md">
                                        <label for="map_place_id" class="small text-muted">map_place_id*</label>
                                        <input type="text" id="map_place_id" class="form-control" name="map_place_id"
                                            placeholder="map_place_id" readonly required>
                                    </div>
                                </div>
                                <div class="row pb-3">

                                    <div class="col-md">
                                        <label for="zipcode" class="small text-muted">Zipcode*</label>
                                        <input type="text" id="zipcode" maxlength="6" minlength="6"
                                            class="form-control" name="zipcode" placeholder="Zip Code" required>
                                    </div>
                                    <div class="col-md">
                                        <label for="City" class="small text-muted">City*</label>
                                        <input type="text" id="profile-city" class="form-control" name="city"
                                            placeholder="City" required>
                                    </div>
                                </div>

                                <div class="row pb-3">
                                    <div class="col-md">
                                        <label for="Address" class="small text-muted">Address*</label>
                                        <textarea id="searchbox" name="address" cols="30" rows="5" class="form-control" placeholder="Address"></textarea>
                                        <button type="button" class="btn btn-outline-info py-0 rounded-0 locate-me-btn">
                                            Auto Locate
                                        </button>
                                    </div>
                                </div>
                                <div class="row pb-3">
                                    <div class="col-md text-right">
                                        <input type="submit" class=" btn btn-block btn-warning" value="Submit" />
                                    </div>
                                </div>
                            </form>
                        @endif
                    </div>
                    <!-- END panel-body -->

                </div>
                <!-- END panel -->
            </div>

        </div>
        <!-- END row -->
    </div>
    <!-- END #content -->
@endsection


@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="{{ asset('bs-select/bs-select.min.js') }}"></script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC3tBEtsH0JPA8Hh-lbBphyfgZM5KY0Hko&libraries=places&callback=initMap"
        async defer></script>
    <script src="{{ asset('js/map.js') }}"></script>
@endsection
