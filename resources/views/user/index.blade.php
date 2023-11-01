@extends('layouts.app')
@section('content')
    <!-- BEGIN #content -->
    <div id="content" class="app-content">

        <!-- BEGIN panel -->
        <div class="panel panel-inverse" data-sortable-id="table-basic-9">
            <!-- BEGIN panel-heading -->
            <div class="panel-heading">
                <h4 class="panel-title">User's Table</h4>
                <td>
                    <a href={{ route('register') }} class="btn btn-success"><i class="fa fa-plus"></i>Add</a>
                </td>
            </div>
            <!-- END panel-heading -->
            <!-- BEGIN panel-body -->
            <div class="panel-body">
                <!-- BEGIN table-responsive -->
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Created On</th>
                                <th>Is active</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $counter = 1;
                            @endphp
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $counter++ }}</td>
                                    <td>{{ $user->name ?? '' }}</td>
                                    <td>{{ $user->email ?? '' }}</td>
                                    <td>{{ $user->created_at->format('d/m/Y') ?? '' }}</td>
                                    <td>
                                        @if ($user->status == 'Active')
                                            <a href="{{ route('user.status', $user->_id) }}"
                                                onclick="return confirm('InActive?')" class="fas fa-toggle-on"
                                                onclick="if(confirm('Are you sure you want to InAtive this field?')) { event.preventDefault(); this.closest('form').submit(); }"
                                                style="font-size: 20px; color:green; text-decoration: none;">
                                            </a>
                                        @else
                                            <a href="{{ route('user.status', $user->_id) }}"
                                                onclick="return confirm('Active?')" class="fas fa-toggle-off"
                                                onclick="if(confirm('Are you sure you want to Active this field?')) { event.preventDefault(); this.closest('form').submit(); }"
                                                style="font-size: 20px; color:red; text-decoration: none;"></a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex mt-2 justify-content-center">
                    {{ $users->links('pagination::bootstrap-4') }}
                </div>
                <!-- END table-responsive -->
            </div>
            <!-- END panel-body -->
        </div>
        <!-- END panel -->
    </div>
    <!-- END #content -->
@endsection
