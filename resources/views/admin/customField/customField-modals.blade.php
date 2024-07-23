

<div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-light p-3">
                <h5 class="modal-title add-lang-title" id="exampleModalLabel" >Add Custom Field</h5>
                <h5 class="modal-title edit-lang-title" id="exampleModalLabel" style="display: none">Edit Custom Field</h5>
                <button type="button" class="btn-close btn-modal-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
            </div>
            <div>
            </div>
            <form method="post" class=" g-3 needs-validation" action="{{route('admin.customField.store')}}" autocomplete="off" id="addForm">
                @csrf
                <div class="modal-body">

                    <div class="mb-3">
                        <input type="number" name="id" value="0" class="d-none">

                        <label for="validationCustom01" class="form-label">Label</label>
                        <input type="text" class="form-control" name="labal" id="label" placeholder="Enter label name"  required>
                        <div class="valid-feedback">
                        </div>
                        <div class="invalid-feedback">Please enter a label name.</div>
                    </div>
                    <div class="mb-3">
                        <label for="status-field" class="form-label">Input Type</label>
                        <select  class="form-select" id="status_field" required data-trigger name="input_type" >
                            <option value="">Choose One</option>

                            <option value="text">Text</option>
                            <option value="email">Email</option>
                            <option value="number">Number</option>
                            <option value="file">File</option>
                            <option value="date">Date</option>
                            <option value="time">Time</option>

                        </select>
                    </div>
                    <div class="mb-3">

                        <label for="validationCustom01" class="form-label">Place Holder</label>
                        <input type="text" class="form-control" name="place_holder" id="place_holder" placeholder="Enter place holder name"  required>
                        <div class="valid-feedback">
                        </div>
                        <div class="invalid-feedback">Please enter a place holder name.</div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Order By</label>
                        <input type="number" class="form-control" name="order_by" placeholder="Enter order number" required>


                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea type="text" class="form-control" name="description" id="description" placeholder="Enter description name" required></textarea>
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback">Please enter a description.</div>
                    </div>



                    <div class="form-check form-switch form-switch-right form-switch-md">
                        <input class="form-check-input" type="checkbox" id="floating-form-require_type" value="1" name="require_type">
                        <label class="form-check-label" for="floating-form-require_type">Require Type</label>
                    </div>


                </div>
                <div class="modal-footer">
                    <div class="hstack gap-2 justify-content-end">
                        <button type="button" class="btn btn-light btn-modal-close" data-bs-dismiss="modal">{{__('translation.close')}}</button>
                        <button type="submit" class="btn btn-success btn-submit btn-add" id="add-btn">Save</button>
                        <button type="submit" class="btn btn-success btn-submit btn-save-changes" id="add-btn" style="display: none">{{__('translation.btn_update')}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>





