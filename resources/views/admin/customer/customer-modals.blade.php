

<div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-light p-3">
                <h5 class="modal-title add-lang-title" id="exampleModalLabel" >Add Customer</h5>
                <h5 class="modal-title edit-lang-title" id="exampleModalLabel" style="display: none">Edit Customer</h5>
                <button type="button" class="btn-close btn-modal-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
            </div>
            <form action="{{route('admin.customer.create')}}"  method="POST" class=" g-3 needs-validation" autocomplete="off"  id="addFrom">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <div class="mb-3">
                            <input type="number" name="id" value="0" style="display:none">
                            <label for="company_id">Company Title</label>
                            <select  class="form-select"  required  name="company_id" id="company-dropdown">
                                <option value="">Choose One</option>
                                @isset($data['companies'])
                                    @foreach ($data['companies']['data']['data'] as $company)

                                        <option value="{{$company->id}}">{{$company->title}}</option>

                                    @endforeach
                                @endisset
                            </select>
                        </div>
                    </div>
                        <div class="mb-3">
                            <label class="form-label" for="std_name">Name</label>
                            <div class="position-relative auth-pass-inputgroup">
                                <input type="text" class="form-control" placeholder="Name" value="" name="name" >
                            </div>
                        </div>
                    <div class="mb-3">
                            <label class="form-label" for="std_name">Company Name</label>
                            <div class="position-relative auth-pass-input group">
                                <input type="text" class="form-control" placeholder="Company Name" value="" name="company_name" >
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="std_name">Email</label>
                            <div class="position-relative auth-pass-inputgroup">
                                <input type="email" class="form-control" placeholder="Email" value="" name="email">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" id="password" placeholder="Password&quot;" >
                        </div>
                        <div class="mb-3">
                            <label for="c_password" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" name="password_confirmation" id="c_password" placeholder="Enter password" >
                        </div>
                    <div class="mb-3">
                        <label for="status-field" class="form-label">{{__('translation.status')}}</label>
                        <select  class="form-select" id="status_field" required data-trigger name="status" >
                            <option value="">Choose One</option>
                            <option value="1">Active</option>
                            <option value="2">In-Active</option>
                        </select>

                    </div>
                    <div class="mb-5">
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="send_email"  id="formCheck1">
                            <label class="form-check-label" for="formCheck1">
                               Send Welcome Email to Customer
                            </label>
                        </div>
                    </div>

                        <div class="modal-footer">
                        <div class="hstack gap-2 justify-content-end">
                            <button type="button" class="btn btn-light btn-modal-close" data-bs-dismiss="modal">{{__('translation.close')}}</button>
                            <button type="submit" class="btn btn-success btn-submit btn-add" id="add-btn">Add customer</button>
                            <button type="submit" class="btn btn-success btn-submit btn-save-changes" id="add-btn" style="display: none">{{__('translation.btn_update')}}</button>
                        </div>
                     </div>
                </div>
            </form>
        </div>
    </div>
</div>





