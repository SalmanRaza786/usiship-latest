


<div class="modal fade" id="checkInModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-light p-3">
                <h5 class="modal-title add-lang-title" id="exampleModalLabel" >Complete Check In</h5>
                <h5 class="modal-title edit-lang-title" id="exampleModalLabel" style="display: none">Complete Check In</h5>
                <button type="button" class="btn-close btn-modal-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
            </div>
            <div>
            </div>

            <form method="post" class=" g-3 needs-validation" action="{{route('admin.checkin.store')}}" autocomplete="off" id="addForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="order_contact_id" value="0">
                <input type="hidden" name="order_id" value="0">
                <div class="modal-body">

                    <div class="row gy-4">
                        <div class="col-md-12">
                            <label for="status-field" class="form-label">Assign Door</label>
                            <select  class="form-select" id="status_field" required data-trigger name="whDoors" >
                                <option value="">Choose One</option>

                            </select>
                        </div>
                        <div class="col-md-6">
                            <div>
                                <label for="basiInput" class="form-label">Container #</label>
                                <input type="text" class="form-control" id="basiInput" name="container_no" required placeholder="Container #">
                            </div>
                        </div>
                        <!--end col-->
                        <div class="col-md-6">
                            <div>
                                <label for="labelInput" class="form-label">Upload Container Photo</label>
                                <input class="form-control" type="file" id="formFile" name="containerImages[]" multiple  accept="image/*" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div>
                                <label for="basiInput" class="form-label">Seal #</label>
                                <input type="text" class="form-control" id="basiInput" name="seal_no" required placeholder="Seal #">
                            </div>
                        </div><div class="col-md-6">
                            <div>
                                <label for="labelInput" class="form-label">Upload Seal Photo</label>
                                <input class="form-control" type="file" id="formFile" name="sealImages[]"  accept="image/*" multiple required>
                            </div>
                        </div><div class="col-md-6">
                            <div>
                                <label for="basiInput" class="form-label">Delivery Order Signature</label>
                                <input type="text" class="form-control" id="basiInput" name="do_signature"   required placeholder="Delivery Order Signature">
                            </div>
                        </div><div class="col-md-6">
                            <div>
                                <label for="labelInput" class="form-label">Upload Delivery Order Signature Image</label>
                                <input class="form-control" type="file" id="formFile" name="do_signatureImages[]"  accept="image/*" multiple required>
                            </div>
                        </div><div class="col-md-6">
                            <div>
                                <label for="basiInput" class="form-label">Other Document</label>
                                <input type="text" class="form-control" id="basiInput" name="other_doc" placeholder="Other Document">
                            </div>
                        </div><div class="col-md-6">
                            <div>
                                <label for="labelInput" class="form-label">Upload Other Document Image</label>
                                <input class="form-control" type="file" id="formFile" name="other_docImages[]"  accept="image/*" multiple >
                            </div>
                        </div>

                    </div>


                </div>
                <div class="modal-footer">
                    <div class="hstack gap-2 justify-content-end">
                        <button type="button" class="btn btn-light btn-modal-close" data-bs-dismiss="modal">{{__('translation.close')}}</button>
                        <button type="submit" class="btn btn-success btn-submit btn-add" id="add-btn">Close Arrival</button>
                        <button type="submit" class="btn btn-success btn-submit btn-save-changes" id="add-btn" style="display: none">Close Arrivals</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>




<div class="modal fade" id="documentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-light p-3">
                <h5 class="modal-title add-lang-title" id="exampleModalLabel" >Carrier Documents</h5>
                <h5 class="modal-title edit-lang-title" id="exampleModalLabel" style="display: none">Carrier Documents</h5>
                <button type="button" class="btn-close btn-modal-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
            </div>
            <div>
            </div>

            <form method="post" class=" g-3 needs-validation" action="{{route('admin.orderContact.update')}}" autocomplete="off" id="verifyForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="0">
                <input type="hidden" name="order_id" value="0">
                <div class="modal-body">
                    <div id="job-list">
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
                                                <h5 class="job-title"></h5>
                                            </a>
                                            <p class="company-name text-muted mb-0"> </p>
                                        </div>
                                        <div>
                                            <button type="button" class="btn btn-ghost-primary btn-icon custom-toggle" data-bs-toggle="button">
                                                <span class="icon-on"><i class="ri-bookmark-line"></i></span>
                                                <span class="icon-off"><i class="ri-bookmark-fill"></i></span>
                                            </button>
                                        </div>
                                    </div>
                                    {{--                                                    <p class="text-muted job-description">A UI/UX designer's job is to create user-friendly interfaces that enable users to understand how to use complex technical products. If you're passionate about the latest technology trends and devices, you'll find great fulfillment in being involved in the design process for the next hot gadget.</p>--}}
                                    <div class="row g-3" id="media">

                                    </div>
                                    <table class="table table-nowrap align-middle">
                                        <thead class="text-muted table-light">
                                        <tr class="text-uppercase">
                                            <th class="sort" data-sort="id">Ttile</th>
                                            <th class="sort" data-sort="id">File</th>
                                            <th class="sort" data-sort="id">Action</th>

                                        </tr>
                                        </thead>
                                        <tbody id="dockTable"></tbody>

                                    </table>
                                </div>
                                <div class="card-footer border-top-dashed">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                                        <div><i class="ri-phone-line align-bottom me-1"></i> <span class="phone_no"></span></div>
                                        <div class="d-none"><span class="job-experience">1 - 2 Year</span></div>
                                        <div class="d-none"><i class="ri-map-pin-2-line align-bottom me-1 "></i>  <span class="job-location">Warehouse</span></div>
                                        <div><i class="ri-star-line align-bottom me-1"></i><span class="verify"></span> </div>
                                        <div><i class="ri-time-line align-bottom me-1"></i> <span class="arrive_time"> </span></div>
                                        <div><button type="submit" class="btn btn-primary viewjob-list btn-verify " id="add-btn">Verify<i class="ri-chat-check-line align-bottom ms-1"></i></button>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="hstack gap-2 justify-content-end">
                        <button type="button" class="btn btn-light btn-modal-close" data-bs-dismiss="modal">{{__('translation.close')}}</button>
{{--                        <button type="submit" class="btn btn-success btn-submit btn-add" id="add-btn">Close Arrival</button>--}}
{{--                        <button type="submit" class="btn btn-success btn-submit btn-save-changes" id="add-btn" style="display: none">Close Arrival</button>--}}
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>



