@extends('layouts.app')
@section('content')
    <!-- BEGIN #content -->
    <div id="content" class="app-content">
        <!-- BEGIN row -->
        <div class="row">
            <!-- BEGIN col-6 -->
            <div class="col-xl-13">
                <!-- BEGIN panel -->
                <div class="panel panel-inverse" data-sortable-id="table-basic-6">
                    <!-- BEGIN panel-body -->
                    <div class="panel-body">
                        <!-- BEGIN table-responsive -->
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>Name</th>
                                        <td>{{ $artist->name }}</td>
                                        <th>Image</th>
                                        <td><img src="{{ $artist->image ? cdn($artist->image) : '' }}" height="50"
                                                alt="icon" />
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>Email</th>
                                        <td>{{ $artist->email ?? '' }}</td>
                                        <th>Alternate</th>
                                        <td>{{ $artist->alternate_no ?? '' }}</td>
                                    </tr>

                                    <tr>
                                        <th>Gender</th>
                                        <td>{{ $artist->gender }}</td>
                                        <th>Steps</th>
                                        <td>{{ $artist->steps }}</td>
                                    </tr>

                                    <tr>
                                        <th>Phone</th>
                                        <td>{{ $artist->phone }}</td>
                                        <th>Status</th>
                                        <td>
                                            <a href="{{ route('wah.artist.update.status', $artist->id) }}"
                                                onclick="return confirm('Are you sure! you want to change status?')"
                                                style="font-size: 20px; color:red; text-decoration: none;"
                                                class="fas fa-{{ $artist->status ? 'toggle-off' : 'toggle-on' }}"></a>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>IBA</th>
                                        <td>
                                            <a href="{{ route('wah.artist.update.is.booking.status', $artist->id) }}"
                                                onclick="return confirm('Are you sure! you want to change status?')"
                                                style="font-size: 20px; text-decoration: none;
                                                color: {{ $artist->is_booking_accepted ? 'red' : 'green' }};"
                                                class="fas fa-{{ $artist->is_booking_accepted ? 'toggle-off' : 'toggle-on' }}"></a>

                                        </td>
                                        <th>Experience</th>
                                        <td>{{ $artist->experience }}</td>
                                    </tr>

                                    <tr>
                                        <th>Address</th>
                                        <td style="max-width: 100px;overflow:hidden">{{ $artist->address }}</td>
                                        <th>City</th>
                                        <td>{{ $artist->city }}</td>
                                    </tr>

                                    <tr>
                                        <th>Experience</th>
                                        <td>{{ $artist->experience }}</td>
                                        <th>ECNumber</th>
                                        <td>{{ $artist->emergency_contact_number }}</td>
                                    </tr>
                                    <tr>
                                        <th>ECName</th>
                                        <td>{{ $artist->emergency_contact_name }}</td>
                                        <th>Relation</th>
                                        <td>{{ $artist->relation }}</td>
                                    </tr>
                                    <tr>
                                        <th>VRNumber</th>
                                        <td>{{ $artist->vehicle_registration_no }}</td>
                                        <th>VEHICLE_TYPE</th>
                                        <td>{{ $artist->vehicle_type }}</td>
                                    </tr>
                                    <tr>
                                        <th>Services</th>
                                        <td style="max-width: 100px;overflow:hidden">
                                            {{ implode(',', $artist->services) ?? '' }}
                                        </td>
                                        <th>Qualification</th>
                                        <td>{{ $artist->qualification }}</td>
                                    </tr>
                                    <tr>
                                        <th>Equipments</th>
                                        <td style="max-width: 100px;overflow:hidden">
                                            {{ implode(',', $artist->equipments) ?? '' }}</td>
                                        <th>ID PROOF</th>
                                        <td>
                                            @if (strpos($artist->id_proof, '.'))
                                                <a target="_blank" href="{{ cdn($artist->id_proof) }}"
                                                    style="font-size: 20px; color:green; text-decoration: none;"
                                                    class="fas fa-toggle-on"></a>
                                            @else
                                                <span class="fas fa-toggle-off"
                                                    style="font-size: 20px; color:red; text-decoration: none;"></span>
                                            @endif

                                        </td>

                                    </tr>
                                    <tr>
                                        <th>Covid_Certificate</th>
                                        <td>
                                            @if (strpos($artist->covid_certificate, '.'))
                                                <a target="_blank" href="{{ cdn($artist->covid_certificate) }}"
                                                    style="font-size: 20px; color:green; text-decoration: none;"
                                                    class="fas fa-toggle-on"></a>
                                            @else
                                                <span style="font-size: 20px; color:red; text-decoration: none;"
                                                    class="fas fa-toggle-off"></span>
                                            @endif

                                        </td>
                                        <th>PVCertificate</th>
                                        <td>
                                            @if (strpos($artist->police_verification_certificate, '.'))
                                                <a target="_blank"
                                                    href="{{ cdn($artist->police_verification_certificate) }}"
                                                    style="font-size: 20px; color:green; text-decoration: none;"
                                                    class="fas fa-toggle-on"></a>
                                            @else
                                                <span style="font-size: 20px; color:red; text-decoration: none;"
                                                    class="fas fa-toggle-off"></span>
                                            @endif
                                        </td>

                                    </tr>
                                    <tr>
                                        <th colspan="2">DOB</th>
                                        <td colspan="2">
                                            {{ $artist->dob ? date('d-m-Y', strtotime($artist->dob)) : '---' }}</td>
                                    </tr>

                                    <tr style="background: rgb(210, 202, 202);text-align:center">
                                        <th colspan="4">Bank Info</th>
                                    </tr>
                                    <tr>
                                        <th>Bank name</th>
                                        <td>{{ $artist->bank_name }}</td>
                                        <th>Branch name</th>
                                        <td>{{ $artist->branch_name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Account no</th>
                                        <td>{{ $artist->account_no }}</td>
                                        <th>Account Holder name</th>
                                        <td>{{ $artist->account_holder_name }}</td>
                                    </tr>
                                    <tr>
                                        <th>IFSC code</th>
                                        <td>{{ $artist->ifsc_code }}</td>
                                        <th>KYC</th>
                                        <td>{{ $artist->kyc }}</td>
                                    </tr>
                                    <tr>
                                        <th>Action</th>
                                        <td> <a class="text-primary"
                                                href="{{ route('wah.artist.create', $artist->id) }}">edit</a>
                                        </td>
                                    </tr>

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
        </div>
        <!-- END row -->
    </div>
    <!-- END #content -->
@endsection
