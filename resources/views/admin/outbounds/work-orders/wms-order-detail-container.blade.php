<div class="container-fluid">
    <div class="profile-foreground position-relative mx-n4 mt-n4">
        <div class="profile-wid-bg">
            <img src="{{asset('build/images/profile-bg.jpg')}}" alt="" class="profile-wid-img">
        </div>
    </div>


    <div class="pt-4 mb-4 mb-lg-3 pb-lg-4 profile-wrapper">
        <div class="row g-4">
            <div class="col-auto">
                <div class="avatar-xl">
                    <div class="avatar-title rounded-circle bg-success-subtle text-primary"><i class="ri-building-line display-2"></i></div>
                </div>
            </div>
            <!--end col-->
            <div class="col">
                <div class="p-2">
                    <h3 class="text-white mb-1">Order Ref#: {{$data['orderDetail']['order_reference'] ?? "-"}}</h3>
                    <p class="text-white text-opacity-75">Order ID: {{$data['orderDetail']['wms_transaction_id'] ?? "-"}}</p>
                    <div class="hstack text-white-50 gap-1">
                        <div class="me-2"><i class="ri-map-pin-user-line me-1 text-white text-opacity-75 fs-16 align-middle"></i>{{$data['orderDetail']['client']->address ?? "-"}}</div>
                        <div>
                            <i class="ri-mail-line me-1 text-white text-opacity-75 fs-16 align-middle"></i>{{$data['orderDetail']['client']->email ?? "-"}}</div>
                        <div>
                            <i class="ri-phone-line me-1 text-white text-opacity-75 fs-16 align-middle"></i>{{$data['orderDetail']['client']->contact ?? "-"}}</div>
                    </div>
                </div>
            </div>

            <!--end col-->
            <div class="col-12 col-lg-auto order-last order-lg-0">
                <div class="row text text-white-50 text-center">
                    <div class="col-lg-12 col-8">
                        <div class="p-2">
                            <h4 class="text-white mb-1">Customer Name</h4>
                            <p class="fs-14 mb-0">{{$data['orderDetail']['client']->title ?? "-"}}</p>
                        </div>
                    </div>

                </div>
            </div>
            <!--end col-->

        </div>
        <!--end row-->
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div>
                <div class="d-flex profile-wrapper">
                    <!-- Nav tabs -->
                    <ul class="nav nav-pills animation-nav profile-nav gap-2 gap-lg-3 flex-grow-1" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link fs-14 active" data-bs-toggle="tab" href="#overview-tab" role="tab" aria-selected="true">
                                <i class="ri-airplay-fill d-inline-block d-md-none"></i> <span class="d-none d-md-inline-block">Overview</span>
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link fs-14" data-bs-toggle="tab" href="#activities" role="tab" aria-selected="false" tabindex="-1">
                                <i class="ri-list-unordered d-inline-block d-md-none"></i> <span class="d-none d-md-inline-block">Order Items</span>
                            </a>
                        </li>
                    </ul>
                    <div class="flex-shrink-0 d-none">
                        <a href="javascript:void(0);" class="btn btn-success" ><i class="ri-edit-box-line align-bottom"></i> Edit Order</a>
                    </div>
                </div>

                <div class="tab-content pt-4 text-muted">

                    <div class="tab-pane active show" id="overview-tab" role="tabpanel">
                        <div class="row">
                            <div class="col-xxl-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title mb-4">Order Status</h5>
                                        <div class="progress animated-progress custom-progress progress-label">
                                            <div class="progress-bar {{$data['orderDetail']['status']['status_title']=="Processed"?'bg-success':'bg-danger'}}" role="progressbar" style="width: {{$data['orderDetail']['status']['status_title']=="Processed"?'100%':'30%'}} " aria-valuenow="{{$data['orderDetail']['status']['status_title']=="Processed"?'100':'30'}}" aria-valuemin="0" aria-valuemax="100">
                                                <div class="label">{{$data['orderDetail']['status']['status_title']=="Processed"?'100%':'30%'}}</div>
                                            </div>
                                        </div><p class="mt-3 mb-2">Order Status: {{$data['orderDetail']['status']['status_title'] ?? "-"}}
                                        </p>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title mb-3">{{$data['orderDetail']['order_date'] ?? "-"}}</h5>
                                        <div class="table-responsive">
                                            <table class="table table-borderless mb-0">
                                                <tbody>

                                                <tr>
                                                    <th class="ps-0" scope="row">Ref#</th>
                                                    <td class="text-muted">{{$data['orderDetail']['order_reference'] ?? "-"}}</td>
                                                </tr>
                                                <tr>
                                                    <th class="ps-0" scope="row">Customer</th>
                                                    <td class="text-muted">{{$data['orderDetail']['client']->title ?? "-"}}</td>
                                                </tr>
                                                <tr>
                                                    <th class="ps-0" scope="row">Carrier</th>
                                                    <td class="text-muted">{{$data['orderDetail']['ship_method'] ?? "-"}}</td>
                                                </tr>
                                                <tr>
                                                    <th class="ps-0" scope="row">Order Date</th>
                                                    <td class="text-muted">{{$data['orderDetail']['order_date'] ?? "-"}}</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div><!-- end card body -->
                                </div><!-- end card -->


                                <!--end card-->
                            </div>
                            <div class="col-xxl-9">
                                <div class="card text-center">







                                    <!--end card-body-->
                                </div>





                            </div>
                        </div>
                        <!--end row-->
                    </div>
                    <div class="tab-pane fade" id="activities" role="tabpanel">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title mb-3">Order Items</h5>
                                <div class="acitivity-timeline">
                                    @if(Auth::guard('admin')->check())
                                        @if(count($data['orderDetail']['wOrderItems']) > 0)
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-center mb-4">
                                                        <h5 class="card-title flex-grow-1 mb-0">Work Orders Item List</h5>
                                                        <div class="flex-shrink-0">
{{--                                                            <a href="{{route('admin.put-away.export',['orderId'=>$data['orderDetail']['data']['id']])}}" type="button"  class="btn btn-primary" title="Download Excel file for WMS"><i class="ri-download-2-fill me-1 align-bottom"></i>Export Excel</a>--}}
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            @if(count($data['orderDetail']['wOrderItems']) > 0)
                                                                <div class="table-responsive">
                                                                    <table class="table table-borderless align-middle mb-0">
                                                                        <thead class="table-light">
                                                                        <tr >
                                                                            <th scope="col">#</th>
                                                                            <th scope="col">
                                                                                Product Name
                                                                            </th>  <th scope="col">
                                                                                Product SKU
                                                                            </th>
                                                                            <th scope="col" style="">
                                                                                <div class="d-flex currency-select input-light align-items-center">Quantity
                                                                                </div>
                                                                            </th>
                                                                            <th scope="col" style="">Pallet Number</th>
                                                                            <th scope="col" style="">Location</th>

                                                                        </tr>
                                                                        </thead>
                                                                        <tbody id="packagingTable">
                                                                        @foreach($data['orderDetail']['wOrderItems'] as $key => $row)
                                                                            <tr>
                                                                                <td class="d-none"><input type="hidden" name="id[]" value="{{$row->id}}"></td>
                                                                                <td>{{++$key}}</td>
                                                                                <td>{{$row->inventory->item_name ?? "-"}}</td>
                                                                                <td>{{$row->inventory->sku ?? "-"}}</td>
                                                                                <td>{{$row->qty ?? "-"}}</td>
                                                                                <td>{{$row->pallet_number ?? "-"}}</td>
                                                                                <td>{{$row->location->loc_title ?? "-"}}</td>
                                                                            </tr>

                                                                        @endforeach

                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            @else
                                                                <div class="text-center mt-3">
                                                                    <h4>Work Orders Item List Not Found</h4>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                            <!--end card-body-->
                        </div>
                        <!--end card-->
                    </div>

                </div>

            </div>
        </div>

    </div>

</div>

{{--@include('admin.order.detail-modal')--}}
