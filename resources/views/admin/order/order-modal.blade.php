<div class="modal fade" id="event-modal" tabindex="-1">
    <div class="modal-dialog  modal-xl modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header p-3 bg-soft-info">
                <h5 class="modal-title" id="modal-title">Add New  Order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body p-4">
                <form class="needs-validation" name="event-form" id="form-event" novalidate>
                    <div class="text-end">
                        <button type="button" class="btn btn-sm btn-soft-primary"  role="button">Detail</button>
                    </div>
                    <div class="row event-form">
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label">WareHouse</label>
                                <select class="form-select " name="category" id="event-category" required>
                                    <option value="">Choose One</option>
                                    @foreach($data['wareHouse'] as $row)
                                        <option value="{{ $row->id }}">{{ $row->working_hour}}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select a valid event category</div>
                            </div>
                        </div>
                        <!--end col-->
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label">Event Name</label>
                                <input class="form-control d-none" placeholder="Enter event name" type="text" name="title" id="event-title" required value="" />
                                <div class="invalid-feedback">Please provide a valid event name</div>
                            </div>
                        </div>
                        <!--end col-->
                        <div class="col-12">
                            <div class="mb-3">
                                <label>Event Date</label>
                                <div class="input-group d-none">
                                    <input type="text" id="event-start-date" class="form-control flatpickr flatpickr-input" placeholder="Select date" readonly required>
                                    <span class="input-group-text"><i class="ri-calendar-event-line"></i></span>
                                </div>
                            </div>
                        </div>
                        <!--end col-->
                        <div class="col-12" id="event-time">
                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label">Start Time</label>
                                        <div class="input-group d-none">
                                            <input id="timepicker1" type="text" class="form-control flatpickr flatpickr-input" placeholder="Select start time" readonly>
                                            <span class="input-group-text"><i class="ri-time-line"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label">End Time</label>
                                        <div class="input-group d-none">
                                            <input id="timepicker2" type="text" class="form-control flatpickr flatpickr-input" placeholder="Select end time" readonly>
                                            <span class="input-group-text"><i class="ri-time-line"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end col-->
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="event-location">Location</label>
                                <div>
                                    <input type="text" class="form-control d-none" name="event-location" id="event-location" placeholder="Event location">
                                </div>
                            </div>
                        </div>
                        <!--end col-->
                        <input type="hidden" id="eventid" name="eventid" value="" />
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea class="form-control d-none" id="event-description" placeholder="Enter a description" rows="3" spellcheck="false"></textarea>
                            </div>
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->
                    <div class="hstack gap-2 justify-content-end">
                        <button type="button" class="btn btn-soft-danger" id="btn-delete-event"><i class="ri-close-line align-bottom"></i> Delete</button>
                        <button type="submit" class="btn btn-success" id="btn-save-event">Add Event</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- end modal-content-->
    </div>
    <!-- end modal dialog-->
</div>

<div class="modal fade" id="orderDetailModal" tabindex="-1">

    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header p-3 bg-soft-info">
                <h5 class="modal-title" id="modal-title">Order information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body p-4">
                <form class="needs-validation" name="event-form" id="form-event" novalidate>
                    <div class="text-end">
                        <button type="button" class="btn btn-sm btn-soft-primary" id="btn-detail"   role="button">Detail</button>
                        <button type="button" class="btn btn-sm btn-soft-primary "  id="btn-reschedule" role="button"  data-bs-toggle="modal"  data-bs-target="#showModalReschedule">Reschedule</button>
                    </div>

                    <div class="event-details">
                        <div class="d-flex mb-2">
                            <div class="flex-grow-1 d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <i class="ri-recycle-line text-muted fs-16"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="d-block fw-semibold mb-0" id="currentStatus"></h6>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex mb-2">
                            <div class="flex-grow-1 d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <i class="ri-file-user-line text-muted fs-16"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="d-block fw-semibold mb-0" id="customerName"></h6>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex mb-2">
                            <div class="flex-grow-1 d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <i class="ri-calendar-event-line text-muted fs-16"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="d-block fw-semibold mb-0" id="orderDate"></h6>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <div class="flex-shrink-0 me-3">
                                <i class="ri-time-line text-muted fs-16"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="d-block fw-semibold mb-0">
                                    <span id="slotFrom"></span> -
                                    <span id="slotTo"></span></h6>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <div class="flex-shrink-0 me-3">
                                <i class="ri-map-pin-line text-muted fs-16 wh-name"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="d-block fw-semibold mb-0"> <span id="whDock"></span></h6>
                            </div>
                        </div>

                    </div>
                    <div class="hstack gap-2 justify-content-end">
                        <button type="button" class="btn btn-soft-danger" data-bs-toggle="modal"  data-bs-target="#confirmRejectModal"><i class="ri-close-line align-bottom"></i> Rejected</button>
                        <button type="button" class="btn btn-success"  data-bs-toggle="modal"  data-bs-target="#confirmAcceptModal">Accepted</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- end modal-content-->
    </div>
    <!-- end modal dialog-->
</div>

<div class="modal fade" id="addOrderModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header p-3 bg-soft-info">
                <h5 class="modal-title" id="modal-title">Add New  Order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body p-4">
                <form class="needs-validation" novalidate method="Get" action="{{route('admin.order.create')}}">
                    <div class="col-12">
                        <div class="mb-3">
                            <label class="form-label">Customers</label>
                            <select class="form-select " name="customer_id" >
                                <option value="">Choose One</option>
                                @foreach($data['customers'] as $row)
                                    <option value="{{ $row->id }}">{{ $row->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-6">
                            <div class="mb-3">
                                <label class="form-label">Date</label>
                                <input type="date" name="order_date" class="form-control">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select class="form-select wareHouse" name="order_status" required>
                                    <option value="">Choose One</option>
                                    @foreach($data['status'] as $row)
                                        <option value="{{ $row->id }}" {{($row->id==6)?'selected':''}}>{{ $row->status_title}}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select a valid event category</div>
                            </div>
                        </div>
                    </div>
                    <div class="hstack gap-2 justify-content-end">
                        <button type="submit" class="btn btn-success" id="btn-save-event">Next</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- end modal-content-->
    </div>
    <!-- end modal dialog-->
</div>

<div class="modal fade zoomIn" id="confirmRejectModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close btn-modal-close" data-bs-dismiss="modal" aria-label="Close" id="btn-close"></button>
            </div>
            <div class="modal-body">
                <div class="mt-2 text-center">
                    <lord-icon  src="https://cdn.lordicon.com/pithnlch.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                    <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                        <h4>Are you sure</h4>
                        <p class="text-muted mx-4 mb-0">You want to reject this order ?</p>
                    </div>
                </div>
                <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                    <button type="button" class="btn w-sm btn-light btn-modal-close" data-bs-dismiss="modal">No</button>
                    <button type="button" class="btn w-sm btn-danger" id="btn-reject">Yes</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade zoomIn" id="confirmAcceptModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close btn-modal-close" data-bs-dismiss="modal" aria-label="Close" id="btn-close"></button>
            </div>
            <div class="modal-body">
                <div class="mt-2 text-center">
                    <lord-icon  src="https://cdn.lordicon.com/pithnlch.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                    <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                        <h4>Are you sure</h4>
                        <p class="text-muted mx-4 mb-0">You want to accept this order ?</p>
                    </div>
                </div>
                <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                    <button type="button" class="btn w-sm btn-light btn-modal-close" data-bs-dismiss="modal">No</button>
                    <button type="button" class="btn w-sm btn-success" id="btn-accept">Yes</button>
                </div>
            </div>
        </div>
    </div>
</div>



