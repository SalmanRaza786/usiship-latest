


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
                                <input type="text" class="form-control" id="basiInput" name="container_no" required>
                            </div>
                        </div>
                        <!--end col-->
                        <div class="col-md-6">
                            <div>
                                <label for="labelInput" class="form-label">Upload Container Photo</label>
                                <input class="form-control" type="file" id="formFile" name="containerImages[]" multiple required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div>
                                <label for="basiInput" class="form-label">Seal #</label>
                                <input type="text" class="form-control" id="basiInput" name="seal_no" required>
                            </div>
                        </div><div class="col-md-6">
                            <div>
                                <label for="labelInput" class="form-label">Upload Seal Photo</label>
                                <input class="form-control" type="file" id="formFile" name="sealImages[]" multiple required>
                            </div>
                        </div><div class="col-md-6">
                            <div>
                                <label for="basiInput" class="form-label">Delivery Order Signature</label>
                                <input type="text" class="form-control" id="basiInput" name="do_signature" required>
                            </div>
                        </div><div class="col-md-6">
                            <div>
                                <label for="labelInput" class="form-label">Upload Delivery Order Signature Image</label>
                                <input class="form-control" type="file" id="formFile" name="do_signatureImages[]" multiple required>
                            </div>
                        </div><div class="col-md-6">
                            <div>
                                <label for="basiInput" class="form-label">Other Document</label>
                                <input type="text" class="form-control" id="basiInput" name="other_doc" required>
                            </div>
                        </div><div class="col-md-6">
                            <div>
                                <label for="labelInput" class="form-label">Upload Other Document Image</label>
                                <input class="form-control" type="file" id="formFile" name="other_docImages[]" multiple >
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
            </form>
        </div>
    </div>
</div>



