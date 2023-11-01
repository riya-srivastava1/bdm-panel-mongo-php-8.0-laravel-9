@extends('layouts.app')
@section('styles')
    <style>
        .ck-content {
            height: 130px !important;
        }

        .lbl_btn_div a {
            border-bottom: 1px solid gray;
            padding: 20px;
        }
    </style>

    <link rel="stylesheet" href="{{ asset('bs-select/bs-select.css') }}" />
@endsection
@section('content')

    <div class="app-main">
        <!-- BEGIN .main-content -->
        <div class="main-content">
            <!-- Row start -->
            <div class="row gutters">
                <div class="col-12 pb-3">
                    <a href="{{ route('wah.artist') }}" class="float-right btn btn-info">Back</a>
                    <h3>WAH Artists Create</h3>
                    <div class="clearfix"></div>
                    <hr style="border-color: black">
                </div>
                <div class="col-md-3 pt-4 lbl_btn_div" style="background-color:aliceblue">
                    <a href="javascript:void()" class="btn btn-block btn-success">Basic Info - Step 1</a>
                    @if ($artist && $artist->count())
                        <a href="{{ route('wah.artist.create.step.two', $artist->id) }}" class="btn btn-block">Address Info
                            -
                            Step 2</a>
                        @if ($artist->steps >= 2)
                            <a href="{{ route('wah.artist.create.step.three', $artist->id) }}" class="btn btn-block">Data -
                                3</a>
                        @endif
                        @if ($artist->steps >= 3)
                            <a href="{{ route('wah.artist.create.step.four', $artist->id) }}" class="btn btn-block">Picture
                                -
                                4</a>
                            <a href="{{ route('wah.artist.create.step.five', $artist->id) }}" class="btn btn-block">Bank
                                Info -
                                5</a>
                        @endif


                    @endif

                </div>
                <div class="col-md-7 offset-md-1">
                    <h3 class="text-center pb-4">Step - 1 (Basic Info)</h3>

                    <div class="py-2">
                        @if (Session::has('success'))
                            <div class="alert alert-danger alert-dismissible fade show text-success" role="alert">
                                {{ Session::get('success') }}
                            </div>
                        @endif
                        @if (Session::has('error'))
                            <div class="alert alert-danger alert-dismissible fade show text-danger" role="alert">
                                {{ Session::get('error') }}
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-warning alert-dismissible fade show text-danger" role="alert">
                                @foreach ($errors->all() as $err)
                                    <p>{{ $err }}</p>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    @if ($artist)
                        <form action="{{ route('wah.artist.store.step.one.update', $artist->id) }}" method="post">
                            @csrf
                            @method('PATCH')
                            <div class="row pb-2">
                                <div class="col-md">
                                    <label for="name" class="small text-muted">Name*</label>
                                    <input type="text" value="{{ $artist->name }}" class="form-control" name="name"
                                        placeholder="Name" required>
                                </div>
                                <div class="col-md">
                                    <label for="email" class="small text-muted">Email*</label>
                                    <input type="email" value="{{ $artist->email }}" class="form-control" name="email"
                                        placeholder="Email">
                                </div>
                            </div>
                            <div class="row pb-2">
                                <div class="col-md">
                                    <label for="Phone" class="small text-muted">Phone*</label>
                                    <input type="text" value="{{ $artist->phone }}" minlength="10" maxlength="10"
                                        class="number form-control" name="phone" placeholder="Phone" required>
                                </div>
                                <div class="col-md">
                                    <label for="Alternate no" class="small text-muted">Alternate no</label>
                                    <input maxlength="10" value="{{ $artist->alternate_no }}" minlength="10" type="text"
                                        class="form-control number" name="alternate_no" placeholder="Alternate no">
                                </div>
                            </div>

                            <div class="row pb-2">
                                <div class="col-md">
                                    <label for="Experience" class="small text-muted">Experience*</label>
                                    <input type="number" value="{{ $artist->experience }}" class="form-control"
                                        name="experience" placeholder="Experience" required>
                                </div>
                                <div class="col-md">
                                    <label for="Gender" class="small text-muted">Gender*</label>
                                    <select name="gender" class="form-control " required>
                                        <option value="">Select Gender</option>
                                        <option {{ $artist->gender == 'Male' ? 'selected' : '' }} value="Male">Male
                                        </option>
                                        <option {{ $artist->gender == 'Female' ? 'selected' : '' }} value="Female">Female
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="row pb-2">
                                <div class="col-md">
                                    <label for="dob" class="small text-muted">DOB*</label>
                                    <input type="date" value="{{ $artist->dob }}" class="form-control" name="dob"
                                        placeholder="DOB*" required>
                                </div>
                                <div class="col-md">
                                    <label for="Services" class="small text-muted">Services*</label>
                                    <select multiple title="Select services" name="services[]"
                                        class="form-control selectpicker" required>
                                        @foreach ($services as $item)
                                            <option value="{{ $item->name }}"
                                                {{ in_array($item->name, $artist->services) ? 'selected' : '' }}>
                                                {{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>

                            <div class="row pb-2">
                                <div class="col-md">
                                    <label for="Equipment" class="small text-muted">Equipment*</label>
                                    <select multiple title="Select equipments" name="equipments[]"
                                        class="form-control selectpicker" required>
                                        @foreach ($equips as $item)
                                            <option value="{{ $item->name }}"
                                                {{ in_array($item->name, $artist->equipments) ? 'selected' : '' }}>
                                                {{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                {{-- <div class="col-md">
                                    <label for="Password" class="small text-muted">Password*</label>
                                    <input type="password" class="form-control" name="password" placeholder="Password">
                                </div> --}}
                                <div class="col-md text-right">
                                    <label for="Password" class="small text-muted">-</label>
                                    <input type="submit" class=" btn btn-block btn-warning" value="Submit" />
                                </div>
                            </div>
                        </form>

                        <div class="py-2 text-right ">
                            @if ($artist && $artist->count())
                                <a href="{{ route('wah.artist.create.step.two', $artist->id) }}"
                                    class="text-primary border px-2 border-success rounded py-1">
                                    Next >>>
                                </a>
                            @endif
                        </div>
                    @else
                        <form action="{{ route('wah.artist.store.step.one') }}" method="post">
                            @csrf
                            <div class="row pb-3">
                                <div class="col-md">
                                    <label for="Name" class="small text-muted">Name*</label>
                                    <input type="text" class="form-control" name="name" placeholder="Name"
                                        required>
                                </div>
                                <div class="col-md">
                                    <label for="Email" class="small text-muted">Email*</label>
                                    <input type="email" class="form-control" name="email" placeholder="Email">
                                </div>
                            </div>
                            <div class="row pb-3">
                                <div class="col-md">
                                    <label for="Phone" class="small text-muted">Phone*</label>
                                    <input type="text" minlength="10" maxlength="10" class="number form-control"
                                        name="phone" placeholder="Phone" required>
                                </div>
                                <div class="col-md">
                                    <label for="Alternate no" class="small text-muted">Alternate no</label>
                                    <input maxlength="10" minlength="10" type="text" class="form-control number"
                                        name="alternate_no" placeholder="Alternate no" required>
                                </div>
                            </div>

                            <div class="row pb-3">
                                <div class="col-md">
                                    <label for="Experience" class="small text-muted">Experience*</label>
                                    <input type="number" class="form-control" name="experience"
                                        placeholder="Experience" required>
                                </div>
                                <div class="col-md">
                                    <label for="Gender" class="small text-muted">Gender*</label>
                                    <select name="gender" class="form-control " required>
                                        <option value="">Select Gender</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row pb-3">
                                <div class="col-md">
                                    <label for="dob" class="small text-muted">DOB*</label>
                                    <input type="date" value="2022-08-22" class="form-control" name="dob"
                                        placeholder="DOB*" required>
                                </div>
                                <div class="col-md">
                                    <label for="Services" class="small text-muted">Services*</label>
                                    <select multiple title="Select services" name="services[]"
                                        class="form-control selectpicker" required>
                                        @foreach ($services as $item)
                                            <option value="{{ $item->name }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row pb-3">

                                <div class="col-md">
                                    <label for="Equipments" class="small text-muted">Equipments*</label>
                                    <select multiple title="Select equipments" name="equipments[]"
                                        class="form-control selectpicker" required>
                                        @foreach ($equips as $item)
                                            <option value="{{ $item->name }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md text-right">
                                    <label for="Password" class="small text-muted">-</label>
                                    <input type="submit" class=" btn btn-block btn-warning" value="Submit" />
                                </div>
                            </div>

                            <div class="row pb-3">
                                {{-- <div class="col-md">
                                    <label for="Password" class="small text-muted">Password*</label>
                                    <input type="password" class="form-control" name="password" placeholder="Password"
                                        required>
                                </div> --}}

                            </div>
                        </form>
                    @endif

                </div>


            </div>
        </div>
    </div>

@endsection

@section('scripts')

    <script src="{{ asset('bs-select/bs-select.min.js') }}"></script>

@endsection
