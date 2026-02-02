

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
            <form method="post" class=" g-3 needs-validation" action="{{route('admin.carriers.store')}}" autocomplete="off" id="addFrom"  >
                @csrf
                <div class="modal-body">

                    <div class="mb-3">
                        <input type="number" name="id" value="0" style="display:none">
                        <label for="company_id">Company ID</label>
                        <select  class="form-select"  required  name="company_id" id="company-dropdown">
                            <option value="">Choose One</option>
                            @isset($data['companies'])
                                @foreach ($data['companies']['data']['data'] as $company)

                                        <option value="{{$company->id}}">{{$company->company_title}}</option>

                                @endforeach
                            @endisset
                        </select>
                    </div>

                    <div class="mb-3">
                        <input type="number" name="id" value="0" style="display:none">

                        <label for="validationCustom01" class="form-label">Carrier Company Name </label>
                        <input type="text" class="form-control" name="carrier_company_name" id="carrier_company_name" placeholder="Enter The Carrier Company Name"  required>
                        <div class="valid-feedback">
                        </div>
                        <div class="invalid-feedback">Please enter a Carrier Company Name.</div>
                    </div>

                    <div class="mb-3">
                        <input type="number" name="id" value="0" style="display:none">

                        <label for="validationCustom01" class="form-label">email </label>
                        <input type="text" class="form-control" name="email" id="email" placeholder="Enter The Email"  required>
                        <div class="valid-feedback">
                        </div>
                        <div class="invalid-feedback">Please enter a email.</div>
                    </div>


                    <div class="mb-3">
                        <input type="number" name="id" value="0" style="display:none">
                        <label for="contacts" class="form-label">Contacts</label>
                        <input type="text" class="form-control" name="contacts" id="contacts" placeholder="Enter The contacts"  required>
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback">Please enter a contacts.</div>
                    </div>

                    {{--                    <div class="form-check form-switch form-switch-right form-switch-md">--}}
                    {{--                        <label for="status-field" class="form-label">require_type</label>--}}
                    {{--                        <label for="floating-form-require_type" class="form-label">Require Type</label>--}}
                    {{--                        <input class="form-check-input code-switcher" type="checkbox" id="floating-form-require_type">--}}

                    {{--                    </div>--}}

                <div class="modal-footer">
                    <div class="hstack gap-2 justify-content-end">
                        <button type="button" class="btn btn-light btn-modal-close" data-bs-dismiss="modal">{{__('translation.close')}}</button>
                        <button type="submit" class="btn btn-success btn-submit btn-add" id="add-btn">Add Load</button>
                        <button type="submit" class="btn btn-success btn-submit btn-save-changes" id="add-btn" style="display: none">{{__('translation.btn_update')}}</button>
                    </div>
                </div>
                </div>
            </form>
        </div>
    </div>
</div>





