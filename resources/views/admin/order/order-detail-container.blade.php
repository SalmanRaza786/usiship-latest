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
                    <h3 class="text-white mb-1">{{$data['orderDetail']['data']['warehouse']->title ?? "-"}}</h3>
                    <p class="text-white text-opacity-75">Order ID: {{$data['orderDetail']['data']['order_id'] ?? "-"}}</p>
                    <div class="hstack text-white-50 gap-1">
                        <div class="me-2"><i class="ri-map-pin-user-line me-1 text-white text-opacity-75 fs-16 align-middle"></i>{{$data['orderDetail']['data']['warehouse']->address ?? "-"}}</div>
                        <div>
                            <i class="ri-phone-line me-1 text-white text-opacity-75 fs-16 align-middle"></i>{{$data['orderDetail']['data']['warehouse']->phone ?? "-"}}</div>
                    </div>
                </div>
            </div>

            <!--end col-->
            <div class="col-12 col-lg-auto order-last order-lg-0">
                <div class="row text text-white-50 text-center">
                    <div class="col-lg-12 col-8">
                        <div class="p-2">
                            <h4 class="text-white mb-1">Load Type</h4>
                            <p class="fs-14 mb-0">{{$data['orderDetail']['data']['loadType'] ?? "-"}}</p>
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
                                <i class="ri-list-unordered d-inline-block d-md-none"></i> <span class="d-none d-md-inline-block">Activities</span>
                            </a>
                        </li>

                        <li class="nav-item" role="presentation">
                            <a class="nav-link fs-14" data-bs-toggle="tab" href="#documents" role="tab" aria-selected="false" tabindex="-1">
                                <i class="ri-folder-4-line d-inline-block d-md-none"></i> <span class="d-none d-md-inline-block">Documents</span>
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link fs-14" data-bs-toggle="tab" href="#packgingList" role="tab" aria-selected="false" tabindex="-1">
                                <i class="ri-folder-4-line d-inline-block d-md-none"></i> <span class="d-none d-md-inline-block">Packaging List</span>
                            </a>
                        </li>


                        <li class="nav-item" role="presentation">
                            <a class="nav-link fs-14 " data-bs-toggle="tab" href="#orderDetail" role="tab" aria-selected="true">
                                <i class="ri-airplay-fill d-inline-block d-md-none"></i> <span class="d-none d-md-inline-block">Order Detail</span>
                            </a>
                        </li>


                        <li class="nav-item" role="presentation">
                            <a class="nav-link fs-14 tab-carrier" data-bs-toggle="tab" href="#carrierDocument" role="tab" aria-selected="true">
                                <i class="ri-airplay-fill d-inline-block d-md-none"></i> <span class="d-none d-md-inline-block">Carrier Document</span>
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
                                            <div class="progress-bar bg-danger" role="progressbar" style="width: 30%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">
                                                <div class="label">30%</div>
                                            </div>
                                        </div><p class="mt-3 mb-2">Order Status: {{$data['orderDetail']['data']['status'] ?? "-"}}
                                        </p>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title mb-3">{{$data['orderDetail']['data']['order_date'] ?? "-"}}</h5>
                                        <div class="table-responsive">
                                            <table class="table table-borderless mb-0">
                                                <tbody>

                                                <tr>
                                                    <th class="ps-0" scope="row">Ref#</th>
                                                    <td class="text-muted">{{$data['orderDetail']['data']['order_id'] ?? "-"}}</td>
                                                </tr>
                                                <tr>
                                                    <th class="ps-0" scope="row">Load Type</th>
                                                    <td class="text-muted">{{$data['orderDetail']['data']['loadType'] ?? "-"}}</td>
                                                </tr>
                                                <tr>
                                                    <th class="ps-0" scope="row">Dock</th>
                                                    <td class="text-muted">{{$data['orderDetail']['data']['dock'] ?? "-"}}</td>
                                                </tr>
                                                <tr>
                                                    <th class="ps-0" scope="row">Appointment Date</th>
                                                    <td class="text-muted">{{$data['orderDetail']['data']['order_date'] ?? "-"}}</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div><!-- end card body -->
                                </div><!-- end card -->

                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-4">
                                            <div class="flex-grow-1">
                                                <h5 class="card-title mb-0">Order Contacts</h5>
                                            </div>

                                        </div>
                                        <div>
                                            <div class="d-flex align-items-center py-1">
                                                <div class="flex-grow-1">
                                                    <div>
                                                        <h5 class="fs-14 mb-1">{{$data['orderDetail']['data']['customer_name'] ?? "-"}}</h5>
                                                        <p class="fs-13 text-muted mb-0">{{$data['orderDetail']['data']['customer_email'] ?? "-"}}</p>
                                                    </div>
                                                </div>
                                                <div class="flex-shrink-0 ms-2">
                                                    <button type="button" class="btn btn-sm btn-outline-success"><i class="ri-phone-line align-middle"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- end card body -->
                                </div>
                                <!--end card-->
                            </div>
                            <div class="col-xxl-9">
                                <div class="card text-center">
                                    <div class="card-body">
                                        <h5 class="card-title mb-3">Order Actions</h5>

                                        <input type="hidden" name="current_status_id" value="{{$data['orderDetail']['data']['status_id']}}">

                                        <div class="row align-items-end requested-section">
                                            <div class="col-md-12">
                                                <div class="">
                                                    <button type="button" class="btn btn-success btn-label btn-action" data="1"  btn-text="Accept"  data-bs-toggle="modal"  data-bs-target="#orderConfirmModal"><i class="ri-check-double-line label-icon align-middle fs-16 me-2"></i> Accept</button>
                                                    <button type="button" class="btn btn-danger btn-label btn-action" data="2" btn-text="Reject"  data-bs-toggle="modal"  data-bs-target="#orderConfirmModal"><i class="ri-error-warning-line label-icon align-middle fs-16 me-2 "></i> Reject</button>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row align-items-end mb-2 accepted-section d-none">

                                            <div class="col-md-12 g-3">
                                                <div class="">

                                                    <button type="button" class="btn btn-outline-success btn-label disabled"><i class="ri-check-double-line label-icon align-middle fs-16 me-2"></i> Accepted</button>
                                                    <button type="button" class="btn btn-warning btn-label btn-undo"><i class="ri-error-warning-line label-icon align-middle fs-16 me-2 "></i> Undo</button>
                                                    <button type="button" class="btn btn-primary btn-label btn-action" data="8" btn-text="request packaging list of"  data-bs-toggle="modal"  data-bs-target="#orderConfirmModal"><i class="ri-error-warning-line label-icon align-middle fs-16 me-2 "></i> Request Packing List </button>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row align-items-end mb-2 requested-package-section d-none">

                                            <div class="col-md-12 g-3">
                                                <div class="">

                                                    <button type="button" class="btn btn-outline-success btn-label disabled"><i class="ri-check-double-line label-icon align-middle fs-16 me-2"></i> Requested Packaging List</button>
                                                    <button type="button" class="btn btn-primary btn-label btn-action" data="8" btn-text="request packaging list of"  data-bs-toggle="modal"  data-bs-target="#orderConfirmModal"><i class="ri-error-warning-line label-icon align-middle fs-16 me-2 "></i> Request Packing List </button>

                                                </div>
                                            </div>

                                        </div>

                                        <div class="row align-items-end mb-2 rejected-section d-none">

                                            <div class="col-md-12 g-3">
                                                <div class="">

                                                    <button type="button" class="btn btn-outline-danger btn-label disabled"><i class="ri-check-double-line label-icon align-middle fs-16 me-2"></i> Rejected</button>
                                                    <button type="button" class="btn btn-warning btn-label btn-undo"><i class="ri-error-warning-line label-icon align-middle fs-16 me-2 "></i> Undo</button>

                                                </div>
                                            </div>

                                        </div>

                                        <div class="row align-items-end mb-2 arrived-section d-none">

                                            <div class="col-md-12">
                                                <div class="">

                                                    <button type="button" class="btn btn-outline-success btn-label disabled"><i class="ri-check-double-line label-icon align-middle fs-16 me-2"></i> Carrier Arrived</button>
                                                    <button type="button" class="btn btn-primary btn-label"><i class="ri-error-warning-line label-icon align-middle fs-16 me-2 "></i> View Carrier Documents </button>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row align-items-end mb-2 progress-section d-none">

                                            <div class="col-md-12">
                                                <div class="">

                                                    <button type="button" class="btn btn-outline-success btn-label disabled"><i class="ri-check-double-line label-icon align-middle fs-16 me-2"></i> In Progress</button>
                                                    <button type="button" class="btn btn-primary btn-label btn-action"   data="10" btn-text="complete"  data-bs-toggle="modal"  data-bs-target="#orderConfirmModal"><i class="ri-error-warning-line label-icon align-middle fs-16 me-2 "></i> Mark Completed</button>
                                                </div>
                                            </div>

                                        </div>


                                        <div class="row align-items-end mb-2 recv-package-section d-none">

                                            <div class="col-md-12">
                                                <div class="">

                                                    <button type="button" class="btn btn-outline-success btn-label disabled"><i class="ri-check-double-line label-icon align-middle fs-16 me-2"></i>Package List Received</button>

                                                </div>
                                            </div>

                                        </div>

                                        <div class="row align-items-end mb-2 completed-section d-none">
                                            <div class="col-md-12">
                                                <div class="">
                                                    <button type="button" class="btn btn-success btn-label disabled"><i class="ri-check-double-line label-icon align-middle fs-16 me-2"></i> Completed</button>

                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                    <!--end card-body-->
                                </div>

{{--                                <div class="card">--}}
{{--                                    <div class="card-body">--}}
{{--                                        <h5 class="card-title mb-3">Warehouse Details</h5>--}}


{{--                                        <div class="row">--}}
{{--                                            <div class="col-6 col-md-4">--}}
{{--                                                <div class="d-flex mt-4">--}}
{{--                                                    <div class="flex-shrink-0 avatar-xs align-self-center me-3">--}}
{{--                                                        <div class="avatar-title bg-light rounded-circle fs-16 text-primary">--}}
{{--                                                            <i class="ri-building-2-fill"></i>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                    <div class="flex-grow-1 overflow-hidden">--}}
{{--                                                        <p class="mb-1">Warehouse Name</p>--}}
{{--                                                        <h6 class="text-truncate mb-0">Address, State, Country</h6>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                            <!--end col-->--}}
{{--                                            <div class="col-6 col-md-4">--}}
{{--                                                <div class="d-flex mt-4">--}}
{{--                                                    <div class="flex-shrink-0 avatar-xs align-self-center me-3">--}}
{{--                                                        <div class="avatar-title bg-light rounded-circle fs-16 text-primary">--}}
{{--                                                            <i class="ri-phone-line"></i>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                    <div class="flex-grow-1 overflow-hidden">--}}
{{--                                                        <p class="mb-1">Contact Info</p>--}}
{{--                                                        <a href="#" class="fw-semibold">+49384572909</a>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </div><div class="col-6 col-md-4">--}}
{{--                                                <div class="d-flex mt-4">--}}
{{--                                                    <div class="flex-shrink-0 avatar-xs align-self-center me-3">--}}
{{--                                                        <div class="avatar-title bg-light rounded-circle fs-16 text-primary">--}}
{{--                                                            <i class="ri-mail-line"></i>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                    <div class="flex-grow-1 overflow-hidden">--}}
{{--                                                        <p class="mb-1">Email Info</p>--}}
{{--                                                        <a href="#" class="fw-semibold">info@warehouse.com</a>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                            <!--end col-->--}}
{{--                                        </div>--}}
{{--                                        <!--end row-->--}}
{{--                                    </div>--}}
{{--                                    <!--end card-body-->--}}
{{--                                </div>--}}




                            </div>
                        </div>
                        <!--end row-->
                    </div>
                    <div class="tab-pane fade" id="activities" role="tabpanel">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title mb-3">Activities</h5>
                                <div class="acitivity-timeline">
                                    @isset($data['orderDetail']['data']['orderLogs'])
                                        @foreach($data['orderDetail']['data']['orderLogs'] as $row)
                                            <div class="acitivity-item d-flex">
                                                <div class="flex-shrink-0">
                                                    <img src="{{asset('build/images/users/avatar-1.jpg')}}" alt="" class="avatar-xs rounded-circle acitivity-avatar">
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h6 class="mb-1">{{$data['orderDetail']['data']['order_id'] ?? "-"}} <span class="badge bg-success-subtle text-success align-middle">{{$row->orderStatus->status_title ?? "-"}}</span></h6>
                                                    {{--                                                        <p class="text-muted mb-2">Action By <span class="text-secondary">employee name</span></p>--}}
                                                    <small class="mb-0 text-muted">{{$row->created_at ?? "-"}}</small>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endisset
                                </div>
                            </div>
                            <!--end card-body-->
                        </div>
                        <!--end card-->
                    </div>
                    <div class="tab-pane fade" id="documents" role="tabpanel">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-4">
                                    <h5 class="card-title flex-grow-1 mb-0">Documents</h5>
{{--                                    <div class="flex-shrink-0">--}}
{{--                                        <input class="form-control d-none" type="file" id="formFile">--}}
{{--                                        <label for="formFile" class="btn btn-danger"><i class="ri-upload-2-fill me-1 align-bottom"></i> Upload File</label>--}}
{{--                                    </div>--}}
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="table-responsive">
                                            <table class="table table-borderless align-middle mb-0">
                                                <thead class="table-light">
                                                <tr>
                                                    <th scope="col">File</th>
                                                    <th scope="col">Type</th>
                                                    <th scope="col">Upload Date</th>

                                                </tr>
                                                </thead>
                                                <tbody>
                                                @isset($data['orderDetail']['data']['media'])
                                                    @foreach($data['orderDetail']['data']['media'] as $row)
                                                        <tr>
                                                            <td>
                                                                <div class="d-flex align-items-center">

                                                                    @if($row->file_type == 'Image')
                                                                        <div class="avatar-sm">
                                                                            <div class="avatar-title bg-primary-subtle text-primary rounded fs-20">
                                                                                <img src="{{asset('storage/uploads/'.$row->file_name)}}" alt="" class="avatar-sm  activity-avatar">
                                                                            </div>
                                                                        </div>
                                                                        <div class="ms-3 flex-grow-1">
                                                                            <h6 class="fs-15 mb-0"><a href="{{asset('storage/uploads/'.$row->file_name)}}" target="_blank" >{{$row->file_name ?? "-"}}</a></h6>
                                                                        </div>
                                                                    @else
                                                                        <div class="avatar-sm">
                                                                            <div class="avatar-title bg-primary-subtle text-primary rounded fs-20">
                                                                                <i class="ri-file-fill"></i>
                                                                            </div>
                                                                        </div>
                                                                        <div class="ms-3 flex-grow-1">
                                                                            <h6 class="fs-15 mb-0"><a href="{{asset('storage/uploads/'.$row->file_name)}}" target="_blank" >{{$row->file_name ?? "-"}}</a>
                                                                            </h6>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </td>
                                                            <td>{{$row->file_type ?? "-"}}</td>
                                                            <td>{{$row->created_at ?? "-"}}</td>
                                                            {{--                                                                <td>--}}
                                                            {{--                                                                    <div class="dropdown">--}}
                                                            {{--                                                                        <a href="javascript:void(0);" class="btn btn-light btn-icon" id="dropdownMenuLink15" data-bs-toggle="dropdown" aria-expanded="true">--}}
                                                            {{--                                                                            <i class="ri-equalizer-fill"></i>--}}
                                                            {{--                                                                        </a>--}}
                                                            {{--                                                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink15">--}}
                                                            {{--                                                                            <li><a class="dropdown-item" href="javascript:void(0);"><i class="ri-eye-fill me-2 align-middle text-muted"></i>View</a></li>--}}
                                                            {{--                                                                            <li><a class="dropdown-item" href="javascript:void(0);"><i class="ri-download-2-fill me-2 align-middle text-muted"></i>Download</a></li>--}}
                                                            {{--                                                                            <li class="dropdown-divider"></li>--}}
                                                            {{--                                                                            <li><a class="dropdown-item" href="javascript:void(0);"><i class="ri-delete-bin-5-line me-2 align-middle text-muted"></i>Delete</a></li>--}}
                                                            {{--                                                                        </ul>--}}
                                                            {{--                                                                    </div>--}}
                                                            {{--                                                                </td>--}}
                                                        </tr>
                                                    @endforeach
                                                @endisset
                                                </tbody>
                                            </table>
                                        </div>
                                        {{--                                            <div class="text-center mt-3">--}}
                                        {{--                                                <a href="javascript:void(0);" class="text-success"><i class="mdi mdi-loading mdi-spin fs-20 align-middle me-2"></i> Load more </a>--}}
                                        {{--                                            </div>--}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="packgingList" role="tabpanel">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-4">
                                    <h5 class="card-title flex-grow-1 mb-0">Packaging List</h5>
                                    <div class="flex-shrink-0">
                                        <a href="{{route('appointment.download-list')}}" type="button"  class="btn btn-danger" ><i class="ri-download-2-fill me-1 align-bottom"></i> Download Packaging List Sample file</a>
                                        <button type="button"  class="btn btn-danger" id="btn-upload_pack_list" data="{{$data['orderDetail']['data']['id']}}" data-bs-toggle="modal" data-bs-target="#showModalUpoad"><i class="ri-upload-2-fill me-1 align-bottom"></i> Upload Packaging List</button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        @if(count($data['orderDetail']['data']['packagingList']) > 0)
                                            <form  action="{{route('packaging.info.store')}}" method="post" id="PackagingForm" enctype="multipart/form-data">
                                                @csrf
                                        <div class="table-responsive">
                                            <table class="table table-borderless align-middle mb-0">
                                                <thead class="table-light">
                                                <tr>
                                                    <th scope="col">Sr No.</th>
                                                    <th scope="col">Item Name</th>
                                                    <th scope="col">Sku</th>
                                                    <th scope="col">Qty Per packing Slip</th>
                                                    <th scope="col">Qty Received Cartons</th>
                                                    <th scope="col">Qty Received Each</th>
                                                    <th scope="col">Exception Qty</th>
                                                    <th scope="col">Damage Images</th>
                                                </tr>
                                                </thead>
                                                <tbody id="packagingTable">

                                                        @foreach($data['orderDetail']['data']['packagingList'] as $key => $row)

                                                        <tr>
                                                            <td class="d-none"><input type="hidden" name="id[]" value="{{$row->id}}"></td>
                                                            <td>{{++$key}}</td>
                                                            <td>{{$row->inventory->item_name ?? "-"}}</td>
                                                            <td>{{$row->inventory->sku ?? "-"}}</td>
                                                            <td>{{$row->qty ?? "-"}}</td>
                                                            <td>{{$row->qty_received_cartons ?? "-"}}</td>
                                                            <td>{{$row->qty_received_each ?? "-"}}</td>
                                                            <td>{{$row->exception_qty ?? "-"}}</td>
                                                            <td>
                                                                @isset($row->filemedia)
                                                                <div class="avatar-group">
                                                                    @foreach($row->filemedia as $image)
                                                                        @if($image->field_name == 'damageImages')
                                                                    <a href="{{asset('storage/uploads/'.$image->file_name)}}" class="avatar-group-item popup-img" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Damages" data-bs-original-title="Damages">
                                                                        <img src="{{asset('storage/uploads/'.$image->file_name)}}" alt="" class="rounded-circle avatar-sm">
                                                                    </a>
                                                                        @endif
                                                                    @endforeach

                                                                </div>
                                                                @endisset
                                                            </td>
                                                        </tr>

                                                    @endforeach

                                                </tbody>
                                            </table>

                                        </div>



{{--                                                <div class="hstack gap-2 justify-content-end">--}}
{{--                                                    <button type="submit" class="btn btn-success btn-submit btn-add" id="add-btn">Submit</button>--}}
{{--                                                </div>--}}
                                            </form>
                                        @else
                                            <div class="text-center mt-3">
                                                <h4>Packaging List Not Uploaded</h4>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane" id="orderDetail" role="tabpanel">
                   <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card">
                                            <div class="card-header  d-flex">
                                                <div class="col">
                                                    <h4 class="card-title mb-0">Order Details</h4>
                                                </div>
                                               @if($data['orderDetail']['data']['isAllowEdit'] == 1)
                                                <div class="col-auto justify-content-sm-end">
                                                    <a href="javascript:void(0);" id="editOrderButton" class="btn btn-success" ><i class="ri-edit-box-line align-bottom"></i>Edit Details</a>
                                                </div>
                                                @endif
                                            </div>
                                            <div class="card-body">
                                                <div class="tab-content text-muted">
                                                    <form method="post" class=" g-3 needs-validation" action="{{route('appointment.update')}}" autocomplete="off" id="UpdateForm"  >
                                                        @csrf
                                                        <div class="modal-body" >
                                                            <input type="hidden" name="order_id" value="{{$data['orderDetail']['data']['id']}}" >
                                                            @isset($data['orderDetail']['data']['orderForm'])
                                                                @foreach($data['orderDetail']['data']['orderForm'] as $row)
                                                                    <div class="mb-3">
                                                                        <label for="validationCustom01" class="form-label">{{$row->customFields->label}}</label>
                                                                        <input type="{{$row->customFields->input_type}}" value="{{$row->form_value}}" class="form-control" name="customfield[{{$row->customFields->id}}]" id="{{$row->customFields->id}}" placeholder="{{$row->customFields->place_holder}}" {{$row->customFields->require_type == "Yes"? "required":""  }} readonly>
                                                                    </div>
                                                                @endforeach
                                                            @endisset
                                                            <div class="modal-footer d-none" id="updateButtonArea">
                                                                <div class="hstack gap-2 justify-content-end">
                                                                    <button type="submit" class="btn btn-success btn-submit btn-add " id="add-btn">Save Changes</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>

                                                </div>
                                            </div><!-- end card body -->
                                        </div><!-- end card -->
                                    </div><!-- end col -->
                                </div>
                    </div>

                    <div class="tab-pane" id="carrierDocument" role="tabpanel">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header  d-flex">
                                        <div class="col">
                                            <h4 class="card-title mb-0">Carrier Document</h4>
                                        </div>

                                    </div>
                                    <div class="card-body">

                                        @if(count($data['orderDetail']['data']['orderContacts']) > 0)
                                        <div id="job-list">
                                            @foreach($data['orderDetail']['data']['orderContacts'] as $row)
                                            <div class="card joblist-card">
                                                <div class="card-body">
                                                    <div class="d-flex mb-4">
                                                        <div class="avatar-sm">
                                                            <div class="avatar-title bg-light rounded">
                                                                <img src="{{asset('build/images/companies/img-7.png')}}" alt="" class="avatar-xxs companyLogo-img">
                                                            </div>
                                                        </div>
                                                        <div class="ms-3 flex-grow-1">

                                                            <a href="#!">
                                                                <h5 class="job-title">{{$row->carrier->carrier_company_name??'-'}}</h5>
                                                            </a>
                                                            <p class="company-name text-muted mb-0">{{$row->carrier->company->company_title??'-'}} </p>
                                                        </div>
                                                        <div>
                                                            <button type="button" class="btn btn-ghost-primary btn-icon custom-toggle" data-bs-toggle="button">
                                                                <span class="icon-on"><i class="ri-bookmark-line"></i></span>
                                                                <span class="icon-off"><i class="ri-bookmark-fill"></i></span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="row g-3">
                                                        @foreach($row->filemedia as $image)
                                                            <div class="col-sm-4">
                                                                <figure class="figure mb-0">
                                                                    <img src="{{asset('storage/uploads/'.$image->file_name)}}" alt="Image Preview" class="figure-img img-fluid rounded">
                                                                    <figcaption class="figure-caption">{{$image->field_name}}</figcaption>
                                                                </figure>
                                                            </div>
                                                        @endforeach
                                                        @foreach($row->carrier->docimages as $doc)
                                                                <div class="col-sm-4">
                                                                    <figure class="figure mb-0">
                                                                        <img src="{{asset('storage/uploads/'.$doc->file_name)}}" alt="Image Preview" class="figure-img img-fluid rounded">
                                                                        <figcaption class="figure-caption">{{$doc->field_name}}</figcaption>
                                                                    </figure>
                                                                </div>
                                                            @endforeach
                                                    </div>
{{--                                                    <div><span class="badge bg-primary-subtle text-primary me-1">Design</span><span class="badge bg-primary-subtle text-primary me-1">Remote</span><span class="badge bg-primary-subtle text-primary me-1">UI/UX Designer</span><span class="badge bg-primary-subtle text-primary me-1">Designer</span></div>--}}
                                                </div>
                                                <div class="card-footer border-top-dashed">
                                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                                                        <div><i class="ri-phone-line align-bottom me-1"></i> <span class="job-type">{{$row->carrier->contacts??'-'}}</span></div>
                                                        <div class="d-none"><span class="job-experience">1 - 2 Year</span></div>
                                                        <div><i class="ri-map-pin-2-line align-bottom me-1"></i>  <span class="job-location">Warehouse</span></div>
                                                        <div><i class="ri-star-line align-bottom me-1"></i>{{$row->is_verify??'-'}} </div>
                                                        <div><i class="ri-time-line align-bottom me-1"></i> <span class="job-postdate">Arrive Time: {{$row->arrival_time??'-'}}</span></div>
                                                       @if($row->is_verify === "Not Verified")
                                                        <div>
                                                            <form method="post" class=" g-3 needs-validation" action="{{route('admin.orderContact.update')}}" autocomplete="off" id="verifyForm" enctype="multipart/form-data">
                                                                @csrf
                                                                <input type="hidden" name="id" value="{{$row->id}}">
                                                                <input type="hidden" name="order_id" value="{{$data['orderDetail']['data']['id']}}">
                                                            <button type="submit" class="btn btn-primary viewjob-list btn-verify">Verify<i class="ri-chat-check-line align-bottom ms-1"></i></button>
                                                            </form>
                                                        </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                        @else
                                            <div class="text-center mt-3">
                                                <h4>Carrier Info Not Uploaded</h4>
                                            </div>
                                        @endif
                                        <!-- end row -->
                                    </div>


                                </div>
                            </div><!-- end col -->
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

</div>

@include('admin.order.detail-modal')
