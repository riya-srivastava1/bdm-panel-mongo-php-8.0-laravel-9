{{-- @extends('layouts.app')
@section('content')
    <div class="app-main">
        <!-- BEGIN .main-content -->
        <div class="main-content">
            <!-- Row start -->
            <div class="row gutters">
                <div class="col-12 pb-3">
                    <h3>WAH Service Price</h3>
                    <hr style="border-color: black">
                </div>
                <div class="col-md-6">
                    <h6 class="text-muted mb-3">
                        {{ $subService->service->name ?? '' }} > {{ $subService->name }}
                    </h6>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Location</th>
                                <th>List Price</th>
                                <th>ZPC</th>
                                <th>Artist Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($prices as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->location }}</td>
                                    <td>{{ $item->list_price }}</td>
                                    <td>{{ $item->zoylee_product_charge }}</td>
                                    <td>{{ $item->artist_price }}</td>
                                    <td>
                                        <a class="text-primary"
                                            href="{{ route('wah.service.price.edit', $item->id) }}">edit</a>
                                        @if ($item->location != 'Default')
                                            |
                                            <a class="text-danger" onclick="return confirm('Are you sure?')"
                                                href="{{ route('wah.service.price.delete', $item->id) }}">delete</a>
                                        @endif

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="offset-md-2 col-md-3 text-center">
                    @php
                        $location = ['Delhi', 'Noida', 'Greater Noida', 'New Delhi', 'Ghaziabad'];
                        if ($prices->count()) {
                            $data = collect($prices->pluck('location'))->toArray();
                            $location = array_diff($location, $data);
                        }
                    @endphp
                    @if ($isEdit)
                        <h4>Edit Service Price</h4><br />
                        <form action="{{ route('wah.service.price.update', $editServicePrice->id) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="wah_sub_service_id" value="{{ $subService->id }}">
                            @if ($editServicePrice->location == 'Default')
                                <div class="form-group pb-2 text-left">
                                    <label for="location" class=" small">Location</label>
                                    <input type="text" class="form-control" name="location" value="Default" readonly>
                                </div>
                            @else
                                <div class="form-group pb-2 text-left">
                                    <select name="location" id="location" required>
                                        <option value="">Select location</option>
                                        <option selected value="{{ $editServicePrice->location }}">
                                            {{ $editServicePrice->location }}</option>
                                        @foreach ($location as $item)
                                            <option value="{{ $item }}">
                                                {{ $item }}</option>
                                        @endforeach

                                    </select>
                                </div>
                            @endif


                            <div class="form-group pb-2 text-left">
                                <label for="location" class=" small">List Price</label>
                                <input type="text" value="{{ $editServicePrice->list_price }}" maxlength="5"
                                    name="list_price" class="list_price form-control number" placeholder="List Price" />
                            </div>
                            <div class="form-group pb-2 text-left">
                                <label for="location" class=" small">Zoylee Product Charge</label>
                                <input type="text" value="{{ $editServicePrice->zoylee_product_charge }}" maxlength="5"
                                    name="zoylee_product_charge" class="zoylee_product_charge form-control number"
                                    placeholder="Zoylee Product Charge" />
                            </div>
                            <div class="form-group pb-2 text-left">
                                <label for="location" class=" small">Artist Price</label>
                                <input type="text" value="{{ $editServicePrice->artist_price }}" readonly maxlength="5"
                                    name="artist_price" class="form-control number artist_price"
                                    placeholder="Artist Price" />
                            </div>


                            <div class="form-group pt-2 text-right">
                                <input type="submit" class="btn btn-info" value="Submit" />
                            </div>
                        </form>
                    @else
                        <h4>ADD Service Price</h4><br />
                        <form action="{{ route('wah.service.price.store') }}" method="post" enctype="multipart/form-data">

                            @csrf
                            <input type="hidden" name="wah_sub_service_id" value="{{ $subService->id }}">
                            @if ($prices->count())
                                <div class="form-group pb-2 text-left">
                                    <select name="location" id="location" required>
                                        <option value="">Select location</option>
                                        @foreach ($location as $item)
                                            <option value="{{ $item }}">
                                                {{ $item }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @else
                                <div class="form-group pb-2 text-left">
                                    <label for="location" class=" small">Location</label>
                                    <input type="text" class="form-control" name="location" value="Default" readonly>
                                </div>
                            @endif
                            <div class="form-group pb-2 text-left">
                                <label for="location" class=" small">List Price</label>
                                <input type="text" maxlength="5" name="list_price"
                                    class="list_price form-control number" placeholder="List Price" />
                            </div>
                            <div class="form-group pb-2 text-left">
                                <label for="location" class="small">Zoylee Product Charge</label>
                                <input type="text" value="0" maxlength="5" name="zoylee_product_charge"
                                    class="zoylee_product_charge form-control number" placeholder="Zoylee Product Charge" />
                            </div>
                            <div class="form-group pb-2 text-left">
                                <label for="location" class=" small">Artist Price</label>
                                <input type="text" readonly maxlength="5" name="artist_price"
                                    class="form-control number artist_price" placeholder="Artist Price" />
                            </div>


                            <div class="form-group pt-2 text-right">
                                <input type="submit" class="btn btn-info" value="Submit" />
                            </div>
                        </form>
                    @endif

                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script>
        $('.list_price').keyup(function() {
            var val = parseInt($(this).val());
            if (val) {
                $('.artist_price').val(val - val / 10);
            } else {
                $('.artist_price').val('');
            }
        });

        $('.zoylee_product_charge').keyup(function() {
            var product_charge = parseInt($(this).val());
            var list_price = parseInt($('.list_price').val());
            if (list_price && product_charge && parseInt($('.artist_price').val()) > product_charge) {
                $('.artist_price').val(list_price - product_charge - list_price / 10);
            } else {
                // $(this).val(0);
                $('.artist_price').val(list_price - list_price / 10);
            }

        });
    </script>
@endsection --}}


@extends('layouts.app')
@section('content')
    <!-- BEGIN #content -->
    <div id="content" class="app-content">
        <!-- BEGIN row -->
        <div class="row">
            <!-- BEGIN col-6 -->
            <div class="col-xl-6">

                <h4>{{ $subService->service->name ?? '' }} > {{ $subService->name }}</h4>
                <!-- BEGIN panel -->
                <div class="panel panel-inverse" data-sortable-id="table-basic-6">
                    <!-- BEGIN panel-body -->
                    <div class="panel-body">
                        <!-- BEGIN table-responsive -->
                        <div class="table-responsive">
                            <table class="table ">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Location</th>
                                        <th>List Price</th>
                                        <th>ZPC</th>
                                        <th>Artist Price</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($prices as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->location }}</td>
                                            <td>{{ $item->list_price }}</td>
                                            <td>{{ $item->zoylee_product_charge }}</td>
                                            <td>{{ $item->artist_price }}</td>
                                            <td>
                                                <a class="text-primary"
                                                    href="{{ route('wah.service.price.edit', $item->id) }}">edit</a>
                                                @if ($item->location != 'Default')
                                                    |
                                                    <a class="text-danger" onclick="return confirm('Are you sure?')"
                                                        href="{{ route('wah.service.price.delete', $item->id) }}">delete</a>
                                                @endif

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
                        @php
                        $location = ['Delhi', 'Noida', 'Greater Noida', 'New Delhi', 'Ghaziabad'];
                        if ($prices->count()) {
                            $data = collect($prices->pluck('location'))->toArray();
                            $location = array_diff($location, $data);
                        }
                    @endphp
                    @if ($isEdit)
                        <h4>Edit Service Price</h4><br />
                        <form action="{{ route('wah.service.price.update', $editServicePrice->id) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="wah_sub_service_id" value="{{ $subService->id }}">
                            @if ($editServicePrice->location == 'Default')
                                <div class="form-group pb-2 text-left">
                                    <label for="location" class=" small">Location</label>
                                    <input type="text" class="form-control" name="location" value="Default" readonly>
                                </div>
                            @else
                                <div class="form-group pb-2 text-left">
                                    <select name="location" id="location" required>
                                        <option value="">Select location</option>
                                        <option selected value="{{ $editServicePrice->location }}">
                                            {{ $editServicePrice->location }}</option>
                                        @foreach ($location as $item)
                                            <option value="{{ $item }}">
                                                {{ $item }}</option>
                                        @endforeach

                                    </select>
                                </div>
                            @endif


                            <div class="form-group pb-2 text-left">
                                <label for="location" class=" small">List Price</label>
                                <input type="text" value="{{ $editServicePrice->list_price }}" maxlength="5"
                                    name="list_price" class="list_price form-control number" placeholder="List Price" />
                            </div>
                            <div class="form-group pb-2 text-left">
                                <label for="location" class=" small">Zoylee Product Charge</label>
                                <input type="text" value="{{ $editServicePrice->zoylee_product_charge }}" maxlength="5"
                                    name="zoylee_product_charge" class="zoylee_product_charge form-control number"
                                    placeholder="Zoylee Product Charge" />
                            </div>
                            <div class="form-group pb-2 text-left">
                                <label for="location" class=" small">Artist Price</label>
                                <input type="text" value="{{ $editServicePrice->artist_price }}" readonly maxlength="5"
                                    name="artist_price" class="form-control number artist_price"
                                    placeholder="Artist Price" />
                            </div>


                            <div class="form-group pt-2 text-right">
                                <input type="submit" class="btn btn-info" value="Submit" />
                            </div>
                        </form>
                    @else
                        <h4>ADD Service Price</h4><br />
                        <form action="{{ route('wah.service.price.store') }}" method="post" enctype="multipart/form-data">

                            @csrf
                            <input type="hidden" name="wah_sub_service_id" value="{{ $subService->id }}">
                            @if ($prices->count())
                                <div class="form-group pb-2 text-left">
                                    <select name="location" id="location" required>
                                        <option value="">Select location</option>
                                        @foreach ($location as $item)
                                            <option value="{{ $item }}">
                                                {{ $item }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @else
                                <div class="form-group pb-2 text-left">
                                    <label for="location" class=" small">Location</label>
                                    <input type="text" class="form-control" name="location" value="Default" readonly>
                                </div>
                            @endif
                            <div class="form-group pb-2 text-left">
                                <label for="location" class=" small">List Price</label>
                                <input type="text" maxlength="5" name="list_price"
                                    class="list_price form-control number" placeholder="List Price" />
                            </div>
                            <div class="form-group pb-2 text-left">
                                <label for="location" class="small">Zoylee Product Charge</label>
                                <input type="text" value="0" maxlength="5" name="zoylee_product_charge"
                                    class="zoylee_product_charge form-control number" placeholder="Zoylee Product Charge" />
                            </div>
                            <div class="form-group pb-2 text-left">
                                <label for="location" class=" small">Artist Price</label>
                                <input type="text" readonly maxlength="5" name="artist_price"
                                    class="form-control number artist_price" placeholder="Artist Price" />
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

