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
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($equipments as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>
                                                <a class="text-primary"
                                                    href="{{ route('wah.equipment.edit', $item->id) }}">edit</a>
                                                |
                                                <a class="text-danger" onclick="return confirm('Are you sure?')"
                                                    href="{{ route('wah.equipment.delete', $item->id) }}">delete</a>
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
                    <!-- BEGIN panel-body -->
                    <div class="panel-body">
                        @if ($isEdit)
                        <h4>Edit Equipment</h4><br />
                        <form action="{{ route('wah.equipment.update', $editEquipment->id) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <div class="form-group">
                                <input type="text" value="{{ $editEquipment->name }}" name="name" class="form-control"
                                    placeholder="Enter category name" />
                            </div>

                            <div class="form-group pt-2 text-right">
                                <input type="submit" class="btn btn-info" value="Update" />
                            </div>
                        </form>
                    @else
                        <h4>Create Equipment</h4><br />
                        <form action="{{ route('wah.equipment.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <input type="text" name="name" class="form-control" placeholder="Enter name" />
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

        </div>
        <!-- END row -->
    </div>
    <!-- END #content -->
@endsection

