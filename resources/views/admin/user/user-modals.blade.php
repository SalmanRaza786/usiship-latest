

<div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-light p-3">
                <h5 class="modal-title add-lang-title" id="exampleModalLabel" >Add @lang('translation.user')</h5>
                <h5 class="modal-title edit-lang-title" id="exampleModalLabel" style="display: none">Edit @lang('translation.user')</h5>
                <button type="button" class="btn-close btn-modal-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
            </div>
            <div>
            </div>
            <form method="post" class=" g-3 needs-validation" action="{{route('admin.user.store')}}" autocomplete="off" id="addFrom" >
                @csrf
                <div class="modal-body">

                    <div class="mb-3">
                        <input type="number" name="id" value="0" style="display:none">

                        <label for="validationCustom01" class="form-label">{{__('translation.name')}}</label>
                        <input type="text" class="form-control" name="first_name" id="first_name" placeholder="Enter first name"  required>
                        <div class="valid-feedback">
                        </div>
                        <div class="invalid-feedback">Please enter a first name.</div>
                    </div>
                    <div class="mb-3">
                        <label for="validationCustom01" class="form-label">{{__('translation.email')}}</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Enter email" autocomplete="off" required>
                        <div class="valid-feedback">
                        </div>
                        <div class="invalid-feedback">Please enter a email.</div>
                    </div>
                    <div class="mb-3">
                        <label for="validationCustom01" class="form-label">{{__('translation.phone')}}</label>
                        <input type="text" class="form-control" name="contact" id="phone" placeholder="Enter phone" autocomplete="off"  required>
                        <div class="valid-feedback">
                        </div>
                        <div class="invalid-feedback">Please enter a phone.</div>
                    </div>
                    <div class="mb-3 password-section">
                        <label for="validationCustom01" class="form-label">{{__('translation.password')}}</label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="Enter password" autocomplete="off"  >
                        <div class="valid-feedback">

                        </div>
                        <div class="invalid-feedback">Please enter a password.</div>
                    </div>
                    <div class="mb-3 password-section">
                        <label for="validationCustom01" class="form-label">{{__('translation.confirm_password')}}</label>
                        <input type="password" class="form-control" name="password_confirmation" id="confirm_password" placeholder="Enter confirm password" autocomplete="off"  >
                        <div class="valid-feedback">

                        </div>
                        <div class="invalid-feedback">Please enter a confirm password.</div>
                    </div>
                    <div class="mb-3">
                        <label for="status-field" class="form-label">{{__('translation.user_roles')}}</label>
                        <select  class="form-select"  required name="roles">
                            <option value="">{{__('translation.roles')}}</option>
                            @isset($data)
                            @foreach ($data['roles'] as $row)
                                    @foreach ($row as $role)
                                <option value="{{$role->id}}">{{$role->name}}</option>
                            @endforeach
                            @endforeach
                            @endisset
                        </select>
                        <div class="invalid-feedback">Please enter a confirm password.</div>
                    </div>

                    <div>
                        <label for="status-field" class="form-label">{{__('translation.status')}}</label>
                        <select  class="form-select" id="status_field" required data-trigger name="status" >
                            <option value="">Choose One</option>
                            <option value="1">Active</option>
                            <option value="2">In-Active</option>
                        </select>

                    </div>
                </div>
                <div class="modal-footer">
                    <div class="hstack gap-2 justify-content-end">
                        <button type="button" class="btn btn-light btn-modal-close" data-bs-dismiss="modal">{{__('translation.close')}}</button>
                        <button type="submit" class="btn btn-success btn-submit btn-add" id="add-btn">@lang('translation.btn_add_user')</button>
                        <button type="submit" class="btn btn-success btn-submit btn-save-changes" id="add-btn" style="display: none">{{__('translation.btn_update')}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>





