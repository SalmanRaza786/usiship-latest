
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

            <form method="post" class=" g-3 needs-validation" action="{{route('admin.checkin.store')}}" autocomplete="off" id="checkInForm" enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="orderCheckInId"  value="0">
                <input type="hidden" name="order_contact_id" value="0" id="orderContactId">
                <input type="hidden" name="order_id" value="0" id="orderId">

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
                                <input type="text" class="form-control" name="container_no" id="checkInContainerNumber" required placeholder="Container #">
                                <div id="containerError"></div>
                            </div>
                        </div>
                        <!--end col-->
                        <div class="col-md-6">
                            <div>
                                <label for="labelInput" class="form-label">Upload Container Photo</label>
                                <input class="form-control" type="file" id="formFile" name="containerImages" multiple  accept="image/*" required>
                                <input type="hidden" name="containerFileId" value="0">
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
                                <input class="form-control" type="file" id="formFile" name="sealImages"  accept="image/*" multiple required>
                                <input type="hidden" name="sealFileId" value="0">
                            </div>
                        </div><div class="col-md-6">
                            <div>
                                <label for="basiInput" class="form-label">Delivery Number</label>
                                <input type="text" class="form-control" id="basiInput" name="do_signature"   required placeholder="Delivery Number">
                            </div>
                        </div><div class="col-md-6">
                            <div>
                                <label for="labelInput" class="form-label">Upload Delivery Order Signature Image</label>
                                <input class="form-control" type="file" id="formFile" name="do_signatureImages"  accept="image/*" multiple required>
                                <input type="hidden" name="doFileId" value="0">
                            </div>
                        </div><div class="col-md-6">
                            <div>
                                <label for="basiInput" class="form-label">Other Document</label>
                                <input type="text" class="form-control" id="basiInput" name="other_doc" placeholder="Other Document">
                            </div>
                        </div><div class="col-md-6">
                            <div>
                                <label for="labelInput" class="form-label">Upload Other Document Image</label>
                                <input class="form-control" type="file" id="formFile" name="other_docImages"  accept="image/*" multiple >
                                <input type="hidden" name="otherFileId" value="0">
                            </div>
                        </div>

                    </div>


                </div>
                <div class="modal-footer">
                    <div class="hstack gap-2 justify-content-end">
                        <button type="button" class="btn btn-light btn-modal-close" data-bs-dismiss="modal">{{__('translation.close')}}</button>
                        <button type="submit" class="btn btn-success btn-submit btn-add" id="add-btn">Close Arrival</button>
                        <button type="submit" class="btn btn-success btn-submit btn-save-changes btn-close-arrival" id="add-btn" style="display: none">Close Arrivals</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>




<div class="modal fade" id="documentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-light p-3">
                <h5 class="modal-title add-lang-title" id="exampleModalLabel" >Carrier Documents</h5>
                <h5 class="modal-title edit-lang-title" id="exampleModalLabel" style="display: none">Carrier Documents</h5>
                <button type="button" class="btn-close btn-modal-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
            </div>
            <div>
            </div>
            <div class="modal-body">

            <div class="row">
                <div class="col-md-6">
                    <div  class="mt-2">
                        <label for="formSizeLarge" class="form-label">Company Name</label>
                        <input class="form-control form-control-lg" id="formSizeLarge" name="company_name" type="text" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div  class="mt-2">
                        <label for="formSizeLarge" class="form-label">Company Phone No.</label>
                        <input class="form-control form-control-lg" id="formSizeLarge" name="company_phone_no" type="text" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div  class="mt-2">
                        <label for="formSizeLarge" class="form-label">Driver's Name</label>
                        <input class="form-control form-control-lg" id="formSizeLarge" name="driver_name" type="text" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div  class="mt-2">
                        <label for="formSizeLarge" class="form-label">Driver's Phone No.</label>
                        <input class="form-control form-control-lg" id="formSizeLarge" name="phone_no" type="text" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div  class="mt-2">
                        <label for="formSizeLarge" class="form-label">Container/Trailer #</label>
                        <input class="form-control form-control-lg" id="formSizeLarge" name="vehicle_no" type="text" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div  class="mt-2">
                        <label for="formSizeLarge" class="form-label">Vehicle License Plate #</label>
                        <input class="form-control form-control-lg" id="formSizeLarge" name="license_no" type="text" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div  class="mt-2">
                        <label for="formSizeLarge" class="form-label">BOL #</label>
                        <input class="form-control form-control-lg" id="formSizeLarge" name="bol_no" multiple type="text" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div  class="mt-2">
                        <label for="formSizeLarge" class="form-label">BOL Image</label>
                        <input class="form-control form-control-lg" id="formSizeLarge" name="bol_image[]" type="file" multiple  required>
                    </div>
                    <div class="element-item col-xxl-3 col-xl-4 col-sm-6 photography" data-category="photography">
                        <div class="gallery-box card">
                            <div class="gallery-container">
                                <a class="image-popup" href="/storage/uploads/off-loading-media/668f8c93d92c0.jpg" title="">
                                    <img class="gallery-img img-fluid mx-auto" src="/storage/uploads/off-loading-media/668f8c93d92c0.jpg" alt="" />
                                    <div class="gallery-overlay">
                                        <h5 class="overlay-caption">BOL Image</h5>
                                    </div>
                                </a>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div  class="mt-2">
                        <label for="formSizeLarge" class="form-label">Do #</label>
                        <input class="form-control form-control-lg" id="formSizeLarge" name="do_no" type="text" required>
                    </div>

                </div>
                <div class="col-md-6">
                    <div  class="mt-2">
                        <label for="formSizeLarge" class="form-label">Do Document</label>
                        <input class="form-control form-control-lg" id="formSizeLarge" name="do_document[]" type="file" multiple  accept="image/*" required>
                    </div>

                    <div class="element-item col-xxl-3 col-xl-4 col-sm-6 photography" data-category="photography">
                        <div class="gallery-box card">
                            <div class="gallery-container">
                                <a class="image-popup" href="/storage/uploads/off-loading-media/668f8c93d92c0.jpg" title="">
                                    <img class="gallery-img img-fluid mx-auto" src="/storage/uploads/off-loading-media/668f8c93d92c0.jpg" alt="" />
                                    <div class="gallery-overlay">
                                        <h5 class="overlay-caption">BOL Image</h5>
                                    </div>
                                </a>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-md-6">
                    <div  class="mt-2">
                        <label for="formSizeLarge" class="form-label">Upload Driver's ID</label>
                        <input class="form-control form-control-lg" id="formSizeLarge" name="driver_id_pic[]" type="file"  accept="image/*" multiple required>
                    </div>

                    <div class="element-item col-xxl-3 col-xl-4 col-sm-6 photography" data-category="photography">
                        <div class="gallery-box card">
                            <div class="gallery-container">
                                <a class="image-popup" href="/storage/uploads/off-loading-media/668f8c93d92c0.jpg" title="">
                                    <img class="gallery-img img-fluid mx-auto" src="/storage/uploads/off-loading-media/668f8c93d92c0.jpg" alt="" />
                                    <div class="gallery-overlay">
                                        <h5 class="overlay-caption">BOL Image</h5>
                                    </div>
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div  class="mt-2">
                        <label for="formSizeLarge" class="form-label">Upload Driver's Other Docs</label>
                        <input class="form-control form-control-lg" id="formSizeLarge" name="other_document[]"  accept="image/*" multiple type="file">
                    </div>

                    <div class="element-item col-xxl-3 col-xl-4 col-sm-6 photography" data-category="photography">
                        <div class="gallery-box card">
                            <div class="gallery-container">
                                <a class="image-popup" href="/storage/uploads/off-loading-media/668f8c93d92c0.jpg" title="">
                                    <img class="gallery-img img-fluid mx-auto" src="/storage/uploads/off-loading-media/668f8c93d92c0.jpg" alt="" />
                                    <div class="gallery-overlay">
                                        <h5 class="overlay-caption">BOL Image</h5>
                                    </div>
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>



            </div>

                            <div class="modal-footer">
                                <div class="hstack gap-2 justify-content-end">
                                    <button type="button" class="btn btn-light btn-modal-close" data-bs-dismiss="modal">{{__('translation.close')}}</button>
                                    <button type="submit" class="btn btn-success btn-submit btn-add" id="add-btn">Close Arrival</button>
                                    <button type="submit" class="btn btn-success btn-submit btn-save-changes" id="add-btn" style="display: none">Close Arrival</button>
                                </div>
                            </div>

        </div>
    </div>
</div>




