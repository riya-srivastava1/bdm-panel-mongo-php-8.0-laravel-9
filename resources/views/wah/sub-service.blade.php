@extends('layouts.app')
@section('content')
    <!-- BEGIN #content -->
    <div id="content" class="app-content">
        <!-- BEGIN row -->
        <div class="row">
            <!-- BEGIN col-6 -->
            <div class="col-xl-4">
                <!-- BEGIN panel -->
                <div class="panel panel-inverse" data-sortable-id="table-basic-6">
                    <!-- BEGIN panel-body -->
                    <div class="panel-body">
                        <div class="col-md-12 p-3 rounded" style="background-color:aliceblue">
                            <h4>
                                Fliter :
                                <hr>
                            </h4>
                            <a href="{{ route('wah.sub.services') }}"
                                class="float-right badge badge-pill badge-danger"><small>CLEAR</small></a>
                            <form action="" method="get">
                                <strong>SEARCH</strong>
                                <br><br>
                                <input type="text" value="{{ request()->get('search') }}" name="search"
                                    class="form-control" placeholder="Search with sub service name">
                                <hr>
                                <strong>WITH Service</strong>
                                <br><br>
                                <select name="service" class="form-select">
                                    <option value="">Select Service</option>
                                    @foreach ($services as $item)
                                        <option value="{{ $item->id }}"
                                            {{ request()->get('service') == $item->id ? 'selected' : '' }}>
                                            <small>{{ $item->category->name ?? '' }}</small> >
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <br>
                                <hr>
                                <strong>GENDER</strong>
                                <div class="custom-control custom-checkbox mt-2">
                                    <input type="radio" {{ request()->get('gender') == 'Male' ? 'checked' : '' }}
                                        class="form-check-input" id="male" name="gender" value="Male">
                                    <label class="custom-control-label" for="male"> Male</label>
                                </div>
                                <div class="custom-control custom-checkbox mt-2">
                                    <input type="radio" {{ request()->get('gender') == 'Female' ? 'checked' : '' }}
                                        class="form-check-input" id="female" name="gender" value="Female">
                                    <label class="custom-control-label" for="female"> Female</label>
                                </div>
                                <br><br>
                                <input type="submit" value="Apply" class="btn btn-primary">
                            </form>
                        </div>
                    </div>
                    <!-- END panel-body -->
                </div>
                <!-- END panel -->
            </div>

            <!-- END col-6 -->
            <div class="col-xl-8">
                <!-- BEGIN panel -->
                <div class="panel panel-inverse" data-sortable-id="form-validation-1">
                    <div class="panel-heading">
                        <h4 class="panel-title">WAH SUB Services &mdash; {{ $subServices->total() }}</h4>
                        <a href="#add_edit_service" class="btn btn-success float-right">Create</a>
                    </div>
                    <!-- BEGIN panel-body -->
                    <div class="panel-body">
                        <div class="col-md-12 table-responsive">
                            <table class="table align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>LP</th>
                                        <th>GENDER</th>
                                        <th>Service</th>
                                        <th>Name</th>
                                        <th>Duration</th>
                                        <th>Image</th>
                                        <th>Summery</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($subServices as $item)
                                        @php
                                            $priceCount = $item->price->count();
                                        @endphp
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <span
                                                    class="badge badge-pill {{ $priceCount ? 'badge-success' : 'badge-danger' }}">{{ $priceCount }}</span>
                                            </td>
                                            <td>{{ $item->service->category->gender ?? '' }}</td>
                                            <td>{{ $item->service->name ?? '' }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->duration }} min</td>
                                            <td><img src="{{ cdn($item->image) }}" height="50" alt="icon" /></td>
                                            <td style="width:280px">
                                                @if (is_array($item->summery))
                                                    @foreach ($item->summery as $SUM)
                                                        {{ $SUM }},
                                                    @endforeach
                                                @else
                                                    {{ $item->summery }}
                                                @endif
                                            </td>
                                            <td>
                                                <div class="text-nowrap">
                                                    <a class="badge-warning "
                                                        href="{{ route('wah.service.price', $item->id) }}">price</a>
                                                    |
                                                    <a class="text-primary"
                                                        href="{{ route('wah.sub.services.edit', $item->id) . '#add_edit_service' }}">edit</a>
                                                    |
                                                    <a class="text-danger" onclick="return confirm('Are you sure?')"
                                                        href="{{ route('wah.sub.services.delete', $item->id) }}">delete</a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- END panel-body -->

                </div>
                <!-- END panel -->
            </div>

            <div class="col-xl-6">
                <div class="col-12 pb-5" id="add_edit_service">
                    <hr class="border-dark">
                </div>

                <div class="offset-md-3 col-md-6 text-center " style="  margin-bottom: 25px !important;">
                    @if ($isEdit)
                        <h4>Edit SUB Service</h4><br />
                        <form action="{{ route('wah.sub.services.update', $editSubService->id) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <div class="form-group">
                                <select name="wah_service_id" required class="form-select">
                                    <option value="">Select Service</option>
                                    @foreach ($services as $item)
                                        <option value="{{ $item->id }}"
                                            {{ $item->id == $editSubService->wah_service_id ? 'selected' : '' }}>
                                            <small>{{ $item->category->name ?? '' }}</small> >
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group pt-2">
                                <input type="text" value="{{ $editSubService->name }}" name="name"
                                    class="form-control" placeholder="Enter service name" />
                            </div>
                            <div class="form-group pt-2">
                                <input type="number" min="10" value="{{ $editSubService->duration }}"
                                    name="duration" class="form-control" placeholder="Duration in minute" required />
                            </div>
                            <div class="form-group pt-2 text-left">
                                <label for="image" class="small">Image | Max:200kb</label>
                                <input type="file" name="image" id="image" class="form-control" />
                            </div>
                            <div class="form-group pt-2 text-left">
                                <textarea name="summery" class="form-control editor" placeholder="Summery(Optional) Enter step wise data"
                                    cols="30" rows="5">
                                </textarea>
                            </div>
                            <div class="form-group pt-2 text-right">
                                <input type="submit" class="btn btn-info" value="Update" />
                            </div>
                        </form>
                    @else
                        <h4>Create SUB Service</h4><br />
                        <form action="{{ route('wah.sub.services.store') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <select name="wah_service_id" required class="form-select">
                                    <option value="">Select Service</option>
                                    @foreach ($services as $item)
                                        <option value="{{ $item->id }}">
                                            <small>{{ $item->category->name ?? '' }}</small> >
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group pt-2">
                                <input type="text" name="name" class="form-control"
                                    placeholder="Enter SUB service name" />
                            </div>
                            <div class="form-group pt-2">
                                <input type="number" min="10" name="duration" class="form-control"
                                    placeholder="Duration in minute" required />
                            </div>
                            <div class="form-group pt-2 text-left">
                                <label for="image" class="small">Image | Max:200Kb</label>
                                <input type="file" name="image" id="image" class="form-control" required />
                            </div>
                            <div class="form-group pt-2 text-left">
                                <textarea name="summery" class="form-control editor" placeholder="Summery(Optional) Enter step wise data"
                                    cols="30" rows="5"></textarea>
                            </div>
                            <div class="form-group pt-2 text-right pb-5 ">
                                <input type="submit" class="btn btn-info" value="Submit" />
                            </div>
                        </form>
                    @endif
                </div>
            </div>

        </div>
        <!-- END row -->
    </div>
    <!-- END #content -->
@endsection
