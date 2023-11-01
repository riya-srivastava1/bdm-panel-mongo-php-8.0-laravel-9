@extends('layouts.app')
@section('content')

    <!-- BEGIN #content -->
    <div id="content" class="app-content">
        <!-- BEGIN row -->
        <div class="row">
            <!-- BEGIN col-6 -->
            <!-- END col-6 -->
            <div class="col-xl-4">
                <!-- BEGIN panel -->
                <div class="panel panel-inverse" data-sortable-id="form-validation-1">
                    <!-- BEGIN panel-body -->
                    <div class="panel-body">
                        @if ($isEdit)
                            <h4>Edit Service</h4><br />
                            <form action="{{ route('wah.service.update', $editService->id) }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')
                                <div class="form-group">
                                    <select class="form-select" name="wah_category_id" required >
                                        <option value="">Select Category</option>
                                        @foreach ($category as $item)
                                            <option value="{{ $item->id }}"
                                                {{ $editService->wah_category_id == $item->id ? 'selected' : '' }}>
                                                {{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group pt-2">
                                    <input type="text" value="{{ $editService->name }}" name="name"
                                        class="form-control" placeholder="Enter service name" />
                                </div>
                                <div class="form-group pt-2 text-left">
                                    <label for="image" class="small">Image</label>
                                    <input type="file" name="image" id="image" class="form-control" />
                                </div>
                                <div class="form-group pt-2 text-left">
                                    <textarea name="summery" class="form-control" cols="30" rows="5">{{ $editService->summery }}</textarea>
                                </div>
                                <div class="form-group pt-2 text-right">
                                    <input type="submit" class="btn btn-info" value="Update" />
                                </div>
                            </form>
                        @else
                            <h4>Create Service</h4><br />
                            <form action="{{ route('wah.service.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <select name="wah_category_id" required class="custom-select">
                                        <option value="">Select Category</option>
                                        @foreach ($category as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group pt-2">
                                    <input type="text" name="name" class="form-control"
                                        placeholder="Enter service name" />
                                </div>
                                <div class="form-group pt-2 text-left">
                                    <label for="image" class=" small">Image</label>
                                    <input type="file" name="image" id="image" class="form-control" required />
                                </div>
                                <div class="form-group pt-2 text-left">
                                    <textarea name="summery" class="form-control" placeholder="Summery(Optional)" cols="30" rows="5"></textarea>
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
            <div class="col-xl-8">
                <!-- BEGIN panel -->
                <div class="panel panel-inverse" data-sortable-id="table-basic-6">
                    <!-- BEGIN panel-body -->
                    <div class="panel-body">
                        <!-- BEGIN table-responsive -->
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>IS_PS</th>
                                        <th>Category</th>
                                        <th>Name</th>
                                        <th>Icon</th>
                                        <th>Summery</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($services as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <a href="{{ route('wah.service.update.ps', $item->id) }}">
                                                    <i class="{{ $item->is_popular_service ? 'icon-star text-success' : 'icon-star-empty' }}"
                                                        style="cursor: pointer;font-size:17px"></i>
                                                </a>
                                            </td>
                                            <td>{{ $item->category->name ?? '' }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td><img src="{{ cdn($item->image) }}" height="50" alt="icon" /></td>
                                            <td>{{ $item->summery }}</td>
                                            <td>
                                                <a class="text-primary"
                                                    href="{{ route('wah.service.edit', $item->id) }}">edit</a>
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
