@extends('layouts.app')
@section('content')
    <!-- BEGIN #content -->
    <div id="content" class="app-content">
        <!-- BEGIN row -->
        <div class="row">
            <div class="col-xl-14">
                <!-- BEGIN panel -->
                <div class="panel panel-inverse" data-sortable-id="form-validation-1">
                    <!-- BEGIN panel-body -->
                    <div class="panel-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>FIRST_IMAGE</th>
                                    <th>SECOND_IMAGE</th>
                                    <th>THIRD_IMAGE</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td><img class="img-fluid" src="{{ cdn($image->first_image) }}" alt="No Image"
                                            srcset="">
                                    </td>
                                    <td><img class="img-fluid" src="{{ cdn($image->second_image) }}" alt="No Image"></td>
                                    <td><img class="img-fluid" src="{{ cdn($image->third_image) }}" alt="NO IMAGE"></td>
                                </tr>
                            </tbody>
                        </table>
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
