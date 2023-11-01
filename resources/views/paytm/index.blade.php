@extends('layouts.app')
@section('content')
    <!-- BEGIN #content -->
    <div id="content" class="app-content">
        <!-- BEGIN row -->
        <h1>Check Payment Status</h1>
        <div class="row">
            <!-- BEGIN col-6 -->
                <div class="col-md-6 offset-md-3">
                    <!--  -->
                    <div class="tab-content" id="pills-tabContent">
                        <!-- Payment Status Tab -->
                        <div class="tab-pane fade show active" id="pills-profile" role="tabpanel"
                            aria-labelledby="pills-profile-tab">
                            <!-- Order Id input -->
                            <form action="#">
                                <div class="card p-5">
                                    <div class="card-body">
                                        <label for="order_id">Order ID</label>
                                        <input type="text" name="order_id" placeholder="Enter Order Id" id="order_id"
                                            class="form-control" value="{{ $order_id ?? '' }}">
                                        <span id="msg"></span>
                                    </div>
                                    <div class="text-right mt-3">
                                        <a href="{{ route('dashboard') }}" class="btn btn-primary">Back</a>
                                        <button name="verify" class="btn btn-info">Verify</button>
                                    </div>
                                </div>
                            </form>
                            <!-- !!Order Id input -->
                            <div class="card">
                                <div class="card-body">
                                    <ul class="list-data"></ul>
                                </div>
                            </div>
                        </div>
                        <!-- !!Payment Status Tab -->
                    </div>
                    <!--  -->
                </div>
        </div>
        <!-- END row -->
    </div>
    <!-- END #content -->

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).on('click', "[name='verify']", function(e) {
            // e.preventDefault();
            $(this).attr('disabled', 'disabled');
            let order_id = $("[name='order_id']").val();
            // if (order_id != '' && order_id.length >= 10) {
            $("#msg").html('');
            $.ajax({
                type: 'GET',
                url: "{{ route('check-status') }}",
                data: {
                    order_id: order_id
                },
                success: function(data) {
                    $("[name='verify']").removeAttr('disabled');
                    if (data.status) {
                        let detail = data.data;
                        let body = detail[0].body;
                        let li = '';
                        $.each(body, function(key, val) {
                            // console.log(val);
                            if (key == 'resultInfo') {
                                li = li + `<li>Status : ` + val.resultStatus + `</li>` +
                                    `<li>Message : ` + val.resultMsg + `</li>`;
                            }
                            li = li + `<li>` + key + ' : ' + val + `</li>`;
                        });
                        $('.list-data').html(li);
                    } else {
                        $("#msg").html(`<small class='text-danger'>` + data.data.order_id[0] +
                            `</small>`)
                    }
                }
            })
            // } else {
            //     $("#msg").html(`<small class='text-danger'>Order Id is required</small>`)
            // }
        });
    </script>
@endsection

