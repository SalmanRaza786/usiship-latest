

<div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-light p-3">
                <h5 class="modal-title add-lang-title" id="exampleModalLabel" >Add Companies</h5>
                <h5 class="modal-title edit-lang-title" id="exampleModalLabel" style="display: none">Edit Companies</h5>
                <button type="button" class="btn-close btn-modal-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
            </div>
            <div>
            </div>
            <form method="post" class=" g-3 needs-validation" action="{{route('admin.companies.store')}}" autocomplete="off" id="addFrom"  >
                @csrf
                <div class="modal-body">

                    <div class="mb-3">
                        <input type="number" name="id" value="0" style="display:none">

                        <label for="validationCustom01" class="form-label">Company Title</label>
                        <input type="text" class="form-control" name="company_title" id="company_title" placeholder="Enter Company Title "  required>
                        <div class="valid-feedback">
                        </div>
                        <div class="invalid-feedback">Please enter a companies.</div>
                    </div>
                    <div class="mb-3">
                        <label for="validationCustom01" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" id="company_title" placeholder="Enter Company Email "  required>
                        <div class="valid-feedback">
                        </div>
                        <div class="invalid-feedback">Please enter a Email.</div>
                    </div>
                    <div class="mb-3">
                        <label for="validationCustom01" class="form-label">Contact</label>
                        <input type="text" class="form-control" name="contact" id="contact" placeholder="Enter Company Contact "  required>
                        <div class="valid-feedback">
                        </div>
                        <div class="invalid-feedback">Please enter a Contact.</div>
                    </div>
                    <div class="mb-3">
                        <label for="validationCustom01" class="form-label">Address</label>
                        <input type="text" class="form-control" name="address" id="address" placeholder="Enter Company Address "  required>
                        <div class="valid-feedback">
                        </div>
                        <div class="invalid-feedback">Please enter a Address.</div>
                    </div>

                <div class="modal-footer">
                    <div class="hstack gap-2 justify-content-end">
                        <button type="button" class="btn btn-light btn-modal-close" data-bs-dismiss="modal">{{__('translation.close')}}</button>
                        <button type="submit" class="btn btn-success btn-submit btn-add" id="add-btn">Add Companies</button>
                        <button type="submit" class="btn btn-success btn-submit " id="add-btn" style="display: none">{{__('translation.btn_update')}}</button>
                    </div>
                </div>
                </div>
            </form>
        </div>
    </div>
</div>





