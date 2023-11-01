@extends('layouts.app')
@section('content')
    <!-- BEGIN #content -->
    <div id="content" class="app-content">
        <!-- BEGIN row -->
        <div class="row">
            <!-- BEGIN col-6 -->
            <div class="col-xl-5">
                <!-- BEGIN panel -->
                <div class="panel panel-inverse" data-sortable-id="form-validation-1">
                    <!-- BEGIN panel-body -->
                    <div class="panel-body">
                        @if ($isEdit)
                            <h4>Edit Category</h4><br />
                            <form action="{{ route('wah.category.update', $editCategory->id) }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')
                                <div class="form-group">
                                    <input type="text" value="{{ $editCategory->name }}" name="name"
                                        class="form-control" placeholder="Enter category name" />
                                </div>
                                <div class="form-group pt-2 text-left">
                                    <label for="icon" class=" small">Icon</label>
                                    <input type="file" name="icon" id="icon" class="form-control" />
                                </div>
                                <div class="form-group pt-2 text-left">
                                    <label for="gender" class=" small">Gender</label>
                                    <select class="form-select" name="gender" id="gender" required>
                                        <option value="">Select gender</option>
                                        <option {{ $editCategory->gender == 'Male' ? 'selected' : '' }} value="Male">Male
                                        </option>
                                        <option {{ $editCategory->gender == 'Female' ? 'selected' : '' }} value="Female">
                                            Female
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group pt-2 text-right">
                                    <input type="submit" class="btn btn-info" value="Update" />
                                </div>
                            </form>
                        @else
                            <h4>Create Category</h4><br />
                            <form action="{{ route('wah.category.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <input type="text" name="name" class="form-control"
                                        placeholder="Enter category name" />
                                </div>
                                <div class="form-group pt-2 text-left">
                                    <label for="icon" class=" small">Icon</label>
                                    <input type="file" name="icon" id="icon" class="form-control" required />
                                </div>
                                <div class="form-group pt-2 text-left">
                                    <label for="gender" class="small">Gender</label>
                                    <select class="form-select" name="gender" id="gender" required>
                                        <option value="">Select gender</option>
                                        <option value="Male">Male
                                        </option>
                                        <option value="Female">
                                            Female
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group pt-2 text-right">
                                    <input type="submit" class="btn btn-info" value="Submit" />
                                </div>
                            </form>
                        @endif
                    </div>
                    <!-- END panel-body -->

                </div>
                <!-- END panel -->
            </div>
            <!-- END col-6 -->
            <div class="col-xl-7">
                <!-- BEGIN panel -->
                <div class="panel panel-inverse" data-sortable-id="table-basic-6">
                    <!-- BEGIN panel-body -->
                    <div class="panel-body">
                        <!-- BEGIN table-responsive -->
                        <div class="table-responsive">
                            <table class="table mb-0 text-nowrap">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Gender</th>
                                        <th>Icon</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($category as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->gender }}</td>
                                            <td><img src="{{ cdn($item->icon) }}" height="50" alt="icon" /></td>
                                            <td>
                                                <a class="text-primary" style="text-decoration: none;"
                                                    href="{{ route('wah.category.edit', $item->id) }}">edit</a>
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
        </div>
        <!-- END row -->
    </div>
    <!-- END #content -->
@endsection


@section('scripts')
    <script src="{{ asset('bs-select/bs-select.min.js') }}"></script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC3tBEtsH0JPA8Hh-lbBphyfgZM5KY0Hko&libraries=places&callback=initMap"
        async defer></script>
    <script src="{{ asset('js/map.js') }}"></script>
@endsection
