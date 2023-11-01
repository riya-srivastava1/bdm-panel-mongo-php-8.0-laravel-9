@extends('layouts.app')
@section('content')
    <!-- BEGIN #content -->
    <div id="content" class="app-content">
        <!-- BEGIN row -->
        <div class="row">
            <!-- BEGIN col-6 -->
            <div class="col-xl-3">
                <!-- BEGIN panel -->
                <div class="panel panel-inverse" data-sortable-id="table-basic-6">
                    <!-- BEGIN panel-body -->
                    <div class="panel-body">
                        <!-- BEGIN table-responsive -->

                        <div class="col-md-12 p-3 rounded" style="background-color:aliceblue">
                            <h4>
                                Fliter :
                                <hr>
                            </h4>
                            <a href="{{ route('wah.artist') }}"
                                class="float-right badge badge-pill badge-danger"><small>CLEAR</small></a>
                            <form action="" method="get">
                                <strong>SEARCH</strong>
                                <br><br>
                                <input type="text" value="{{ request()->get('search') }}" name="search"
                                    class="form-control" placeholder="Search name,phone">
                                <hr>
                                <strong>STATUS</strong>
                                <div class="custom-control custom-checkbox mt-2">
                                    <input type="radio" {{ request()->get('status') == 'active' ? 'checked' : '' }}
                                        class="custom-control-input" id="active" name="status" value="active">
                                    <label class="custom-control-label" for="active">Active</label>
                                </div>
                                <div class="custom-control custom-checkbox mt-2">
                                    <input type="radio" {{ request()->get('status') == 'in-active' ? 'checked' : '' }}
                                        class="custom-control-input" id="in-active" name="status" value="in-active">
                                    <label class="custom-control-label" for="in-active">In - Active</label>
                                </div>

                                <br>
                                <hr>
                                <strong>IBA</strong>
                                <div class="custom-control custom-checkbox mt-2">
                                    <input type="radio" {{ request()->get('iba') == 'active' ? 'checked' : '' }}
                                        class="custom-control-input" id="active_iba" name="iba" value="active">
                                    <label class="custom-control-label" for="active_iba">Active</label>
                                </div>
                                <div class="custom-control custom-checkbox mt-2">
                                    <input type="radio" {{ request()->get('iba') == 'in-active' ? 'checked' : '' }}
                                        class="custom-control-input" id="in-active_iba" name="iba" value="in-active">
                                    <label class="custom-control-label" for="in-active_iba">In - Active</label>
                                </div>

                                <br>
                                <hr>
                                <strong>GENDER</strong>
                                <div class="custom-control custom-checkbox mt-2">
                                    <input type="radio" {{ request()->get('gender') == 'Male' ? 'checked' : '' }}
                                        class="custom-control-input" id="male" name="gender" value="Male">
                                    <label class="custom-control-label" for="male">Male</label>
                                </div>
                                <div class="custom-control custom-checkbox mt-2">
                                    <input type="radio" {{ request()->get('gender') == 'Female' ? 'checked' : '' }}
                                        class="custom-control-input" id="female" name="gender" value="Female">
                                    <label class="custom-control-label" for="female">Female</label>
                                </div>
                                <br><br>
                                <input type="submit" value="Apply" class="btn btn-primary">
                            </form>
                        </div>
                        <!-- END table-responsive -->
                    </div>
                    <!-- END panel-body -->
                </div>
                <!-- END panel -->
            </div>
            <!-- BEGIN col-6 -->
            <div class="col-xl-9">
                <!-- BEGIN panel -->
                <div class="panel panel-inverse" data-sortable-id="table-basic-6">
                    <!-- BEGIN panel-body -->
                    <div class="panel-body">
                        <!-- BEGIN table-responsive -->
                        <div class="table-responsive">
                            <table class="table text-nowrap">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Booking Count</th>
                                        <th>City</th>
                                        <th>Reg. Date</th>
                                        <th>Phone</th>
                                        <th>Steps</th>
                                        <th>Image</th>
                                        <th>Gender</th>
                                        <th>Status</th>
                                        <th>IAB</th>
                                        <th>Block Status</th>
                                        <th>Note</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @php
                                        $counter = ($artists->currentPage() - 1) * $artists->perPage() + 1;
                                    @endphp
                                    @foreach ($artists as $item)
                                        <tr>
                                            <td>{{ $counter++ }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>
                                                <a class="text-primary" target="_blank"
                                                    href="{{ route('wah.bookings', ['wah_artist_id' => $item->id]) }}">
                                                    {{ $item->booking ? $item->booking->count() : 0 }}
                                                </a>
                                            </td>
                                            <td>{{ $item->city }}</td>
                                            <td>{{ date('d-M-Y', strtotime($item->created_at)) }}</td>
                                            <td>{{ $item->phone }}</td>
                                            <td>{{ $item->steps }}</td>
                                            {{-- <td>{{ implode(',', $item->services) ?? '' }}</td> --}}
                                            <td><img src="{{ $item->image ? cdn($item->image) : '' }}" height="50"
                                                    alt="NO IMAGE" />
                                            </td>
                                            <td>{{ $item->gender }} </td>
                                            <td>
                                                <a href="{{ route('wah.artist.update.status', $item->id) }}"
                                                    onclick="return confirm('Are you sure! you want to change status?')"
                                                    class="{{ $item->status ? 'circle-success' : 'circle-warning' }}"></a>
                                            </td>
                                            <td>
                                                <a href="{{ route('wah.artist.update.is.booking.status', $item->id) }}"
                                                    onclick="return confirm('Are you sure! you want to change status?')"
                                                    class="{{ $item->is_booking_accepted ? 'circle-success' : 'circle-warning' }}"></a>
                                            </td>

                                            <th>
                                                @if ($item->is_block === false)
                                                    <a href="javascript:void(0)" data-toggle="modal"
                                                        data-target="#blockUserModal_{{ $item->id }}"
                                                        class="circle-success" data-toggle="modal"></a>
                                                @else
                                                    <a href="javascript:void(0)" data-toggle="modal"
                                                        data-target="#unBlockUserModal_{{ $item->id }}"
                                                        class="circle-warning" data-toggle="modal"></a>
                                                @endif

                                            </th>


                                            <td>
                                                <a class="text-primary" target="_blank"
                                                    href="{{ route('wah.artist.log', ['a_id' => $item->id]) }}">logs</a>
                                                |
                                                <a class="text-primary"
                                                    href="{{ route('wah.artist.create', $item->id) }}">edit</a>
                                                |
                                                <a class="text-primary"
                                                    href="{{ route('wah.artist.details', $item->id) }}">details</a>
                                                |
                                                <a class="text-danger" onclick="return confirm('Are you sure?')"
                                                    href="{{ route('wah.artist.delete', $item->id) }}">delete</a>


                                                {{-- Artist Report Form Model --}}
                                                <div class="modal fade" id="blockUserModal_{{ $item->id }}"
                                                    tabindex="-1" role="dialog" aria-labelledby="blockUserModalLabel"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">


                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="blockUserModalLabel">Block
                                                                    Artist
                                                                </h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="{{ route('wah.block.artist', $item->id) }}"
                                                                    style="max-width: 300px" class="mx-auto"
                                                                    method="post">
                                                                    @csrf

                                                                    <div class="form-group mb-2">
                                                                        <label for="name">Name</label>
                                                                        <input class="form-control" type="text"
                                                                            value="{{ $item->name }}" readonly
                                                                            id="name">
                                                                    </div>

                                                                    <div class="form-group mb-2">
                                                                        <label for="remark">Remark*</label>
                                                                        <textarea required name="remark" id="remark" cols="30" rows="2" class="form-control"></textarea>
                                                                    </div>

                                                                    <div class="form-group mb-2">
                                                                        <label for="block_type">Block Type</label>
                                                                        <select name="block_type" class="form-control"
                                                                            id="block_type">
                                                                            <option value="spacific_time">Spacific Time
                                                                            </option>
                                                                            <option value="all_time">All Time</option>
                                                                        </select>
                                                                    </div>

                                                                    <div class="form-group mb-2">
                                                                        <label for="valid_till">Valid Till</label>
                                                                        <input type="date" class="form-control"
                                                                            name="valid_till" id="valid_till"
                                                                            value="{{ date('Y-m-d') }}" />
                                                                    </div>
                                                                    <div class="py-3 text-right">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-dismiss="modal">Close</button>
                                                                        <button type="submit"
                                                                            class="btn btn-primary">Save
                                                                            changes</button>
                                                                    </div>

                                                                </form>

                                                            </div>


                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- Artist Report Form Model --}}
                                                {{-- UnBlock Artist Report Form Model --}}
                                                <div class="modal fade" id="unBlockUserModal_{{ $item->id }}"
                                                    tabindex="-1" role="dialog" aria-labelledby="blockUserModalLabel"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">


                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="blockUserModalLabel">Update
                                                                    Block
                                                                    Artist
                                                                </h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form
                                                                    action="{{ route('wah.update.block.artist', $item->id) }}"
                                                                    style="max-width: 300px" class="mx-auto"
                                                                    method="post">
                                                                    @csrf

                                                                    <div class="form-group mb-2">
                                                                        <label for="name">Name</label>
                                                                        <input class="form-control" type="text"
                                                                            value="{{ $item->name }}" readonly
                                                                            id="name">
                                                                    </div>

                                                                    <div class="form-group mb-2">
                                                                        <label for="remark">Remark*</label>
                                                                        <textarea required name="remark" id="remark" cols="30" rows="2" class="form-control">{{ $item->remark }}</textarea>
                                                                    </div>

                                                                    <div class="form-group mb-2">
                                                                        <label for="block_type">Block Type</label>
                                                                        <select name="block_type" class="form-control"
                                                                            id="block_type">
                                                                            <option
                                                                                {{ $item->block_type == 'spacific_time' ? 'selected' : '' }}
                                                                                value="spacific_time">Spacific Time
                                                                            </option>
                                                                            <option
                                                                                {{ $item->block_type == 'all_time' ? 'selected' : '' }}
                                                                                value="all_time">All Time</option>
                                                                        </select>
                                                                    </div>

                                                                    <div class="form-group mb-2">
                                                                        <label for="valid_till">Valid Till</label>
                                                                        <input type="date" class="form-control"
                                                                            name="valid_till" id="valid_till"
                                                                            value="{{ $item->valid_till }}" />
                                                                    </div>
                                                                    <div class="py-3 text-right">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-dismiss="modal">Close</button>
                                                                        <button type="submit"
                                                                            class="btn btn-primary">Save
                                                                            changes</button>

                                                                        <a href="{{ route('wah.un.block.artist', $item->id) }}"
                                                                            class="btn btn-success">Un Block Artist
                                                                        </a>
                                                                    </div>

                                                                </form>

                                                            </div>


                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- UnBlock Artist Report Form Model --}}
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                            <div class="d-flex justify-content-center">
                                {{ $artists->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                        <!-- END table-responsive -->
                    </div>
                    <!-- END panel-body -->
                </div>
                <!-- END panel -->
            </div>
            <!-- END col-6 -->
            <div class="col-xl-9">
                <!-- BEGIN panel -->
                <div class="panel panel-inverse" data-sortable-id="form-validation-1">
                    <!-- BEGIN panel-body -->
                    <div class="panel-body">
                        @if (Auth::guard('bdm')->user()->email == 'isaac@zoylee.com')
                            <h3>Trashed Artist</h3>
                            <table class="table text-nowrap">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Reg. Date</th>
                                        <th>Phone</th>
                                        <th>Steps</th>
                                        <th>Image</th>
                                        <th>Gender</th>
                                        <th>Status</th>
                                        <th>IAB</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($trashed_artist as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ date('d-M-Y', strtotime($item->created_at)) }}</td>
                                            <td>{{ $item->phone }}</td>
                                            <td>{{ $item->steps }}</td>
                                            <!-- <td>{{ implode(',', $item->services) ?? '' }}</td> -->
                                            <td><img src="{{ $item->image ? cdn($item->image) : '' }}" height="50"
                                                    alt="NO IMAGE" />
                                            </td>
                                            <td>{{ $item->gender }} </td>
                                            <td>
                                                <a href="{{ route('wah.artist.update.status', $item->id) }}"
                                                    onclick="return confirm('Are you sure! you want to change status?')"
                                                    class="{{ $item->status ? 'circle-success' : 'circle-warning' }}"></a>
                                            </td>
                                            <td>
                                                <a href="{{ route('wah.artist.update.is.booking.status', $item->id) }}"
                                                    onclick="return confirm('Are you sure! you want to change status?')"
                                                    class="{{ $item->is_booking_accepted ? 'circle-success' : 'circle-warning' }}"></a>
                                            </td>

                                            <td>
                                                <a class="text-primary" onclick="return confirm('Are you sure?')"
                                                    href="{{ route('wah.artist.restore', $item->id) }}">re-store</a>
                                                |
                                                <a class="text-danger" onclick="return confirm('Are you sure?')"
                                                    href="{{ route('wah.artist.force.delete', $item->id) }}">delete</a>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        @endif
                        {{-- <div class="d-flex justify-content-center">
                            {{ $trashed_artist->links('pagination::bootstrap-4') }}
                        </div> --}}
                    </div>
                    <!-- END panel-body -->
                </div>
                <!-- END panel -->
            </div>
            <!-- END row -->
        </div>
        <!-- END #content -->
    </div>
@endsection
