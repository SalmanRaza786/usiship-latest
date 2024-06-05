
<div class="row">

    <div class="col-xl-12">

        <div class="card">
            <div class="card-body checkout-tab">
                <form action="{{route('order.store')}}" method="post" id="OrderForm" enctype="multipart/form-data" >

                    @csrf
                    <div class="step-arrow-nav mt-n3 mx-n3 mb-3">
                        <input type="number" class="d-none" name="customer_id" value="{{$data['customerId']}}">
                        <select name="order_status" id="" class="form-control d-none">
                            <option value="">Choose One</option>
                            @foreach($data['status'] as $row)
                                <option value="{{ $row->id }}" {{($data['selectStatus']==$row->id)?'selected':''}}>{{ $row->status_title }}</option>
                            @endforeach
                        </select>
                        <input type="text" name="created_by" class="d-none" value="{{$data['createdBy']}}">
                        <input type="text" name="guard" class="d-none" value="{{$data['guard']}}">

                        <ul class="nav nav-pills nav-justified custom-nav" role="tablist">
                            <li class="nav-item disabled" role="presentation">
                                <button
                                    class="nav-link fs-12 p-3 active"
                                    id="pills-bill-info-tab"
                                    data-bs-toggle="pill"
                                    data-bs-target="#pills-bill-info"
                                    type="button"
                                    role="tab"
                                    aria-controls="pills-bill-info"
                                    aria-selected="false"
                                    data-position="0"
                                    tabindex="-1"

                                >
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <i class="ri-building-line fs-48 p-2 bg-primary-subtle text-primary rounded-circle align-middle me-2"></i>
                                        </div>
                                        <div class="flex-grow-1 ms-2">
                                            <h5 class="card-title mb-1">Warehouse</h5>
                                            <p class="text-muted mb-0">Eternal Beverages, Inc.</p>
                                        </div>
                                    </div>
                                </button>
                            </li>
                            <li class="nav-item disabled" role="presentation">
                                <button
                                    class="nav-link fs-12 p-3 "
                                    id="pills-bill-address-tab"
                                    data-bs-toggle="pill"
                                    data-bs-target="#pills-bill-address"
                                    type="button"
                                    role="tab"
                                    aria-controls="pills-bill-address"
                                    aria-selected="true"
                                    data-position="1"
                                >
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <i class="ri-truck-line fs-48 p-2 bg-primary-subtle text-primary rounded-circle align-middle me-2"></i>
                                        </div>
                                        <div class="flex-grow-1 ms-2">
                                            <h5 class="card-title mb-1">Load Type</h5>
                                            <p class="text-muted mb-0">Select Load Type</p>
                                        </div>
                                    </div>
                                </button>
                            </li>
                            <li class="nav-item disabled" role="presentation">
                                <button
                                    class="nav-link fs-12 p-3 "
                                    id="pills-dock-tab"
                                    data-bs-toggle="pill"
                                    data-bs-target="#pills-dock"
                                    type="button"
                                    role="tab"
                                    aria-controls="pills-dock"
                                    aria-selected="false"
                                    data-position="2"
                                    tabindex="-1"
                                >
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <i class="ri-map-pin-line fs-48 p-2 bg-primary-subtle text-primary rounded-circle align-middle me-2"></i>
                                        </div>
                                        <div class="flex-grow-1 ms-2">
                                            <h5 class="card-title mb-1">Dock</h5>
                                            <p class="text-muted mb-0">Auto Selected</p>
                                        </div>
                                    </div>
                                </button>
                            </li>
                            <li class="nav-item disabled" role="presentation">
                                <button
                                    class="nav-link fs-12 p-3"
                                    id="pills-payment-tab"
                                    data-bs-toggle="pill"
                                    data-bs-target="#pills-payment"
                                    type="button"
                                    role="tab"
                                    aria-controls="pills-payment"
                                    aria-selected="false"
                                    data-position="2"
                                    tabindex="-1"
                                >
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <i class="ri-time-line fs-48 p-2 bg-primary-subtle text-primary rounded-circle align-middle me-2"></i>
                                        </div>
                                        <div class="flex-grow-1 ms-2">
                                            <h5 class="card-title mb-1">Date / Time</h5>
                                            <p class="text-muted mb-0">Select Load Type</p>
                                        </div>
                                    </div>
                                </button>
                            </li>
                            <li class="nav-item disabled" role="presentation">
                                <button
                                    class="nav-link fs-12 p-3"
                                    id="pills-finish-tab"
                                    data-bs-toggle="pill"
                                    data-bs-target="#pills-finish"
                                    type="button"
                                    role="tab"
                                    aria-controls="pills-finish"
                                    aria-selected="false"
                                    data-position="3"
                                    tabindex="-1"
                                >
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <i class="ri-checkbox-circle-line fs-48 p-2 bg-primary-subtle text-primary rounded-circle align-middle me-2"></i>
                                        </div>
                                        <div class="flex-grow-1 ms-2">
                                            <h5 class="card-title mb-1">Details</h5>
                                            <p class="text-muted mb-0">Appointment Details</p>
                                        </div>
                                    </div>
                                </button>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="pills-bill-info" role="tabpanel" aria-labelledby="pills-bill-info-tab">
                            @include('client.screens.appointment.components.warehouse-info')
                        </div>
                        <!-- end tab pane -->

                        <div class="tab-pane fade " id="pills-bill-address" role="tabpanel" aria-labelledby="pills-bill-address-tab">
                            @include('client.screens.appointment.components.loadType-info')
                        </div>
                        <!-- end tab pane -->

                        <div class="tab-pane fade" id="pills-dock" role="tabpanel" aria-labelledby="pills-dock-tab">
                            @include('client.screens.appointment.components.dock')
                        </div>
                        <div class="tab-pane fade" id="pills-payment" role="tabpanel" aria-labelledby="pills-payment-tab">
                            @include('client.screens.appointment.components.date-time-schedual')
                        </div>
                        <!-- end tab pane -->

                        <div class="tab-pane fade" id="pills-finish" role="tabpanel" aria-labelledby="pills-finish-tab">
                            @include('client.screens.appointment.components.detail-form')
                        </div>
                        <!-- end tab pane -->
                    </div>
                    <!-- end tab content -->

                </form>
            </div>
            <!-- end card body -->
        </div>
    </div>
    <!-- end col -->
</div>
