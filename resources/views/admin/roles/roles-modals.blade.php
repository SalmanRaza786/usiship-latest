
<div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light p-3">
                <h5 class="modal-title add-lang-title" id="exampleModalLabel" >{{__('translation.add')}} @lang('translation.roles')</h5>
                <h5 class="modal-title edit-lang-title" id="exampleModalLabel" style="display: none">{{__('translation.edit')}} @lang('translation.roles')</h5>
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="btn-close btn-modal-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
            </div>
            <div>
            </div>
            <form method="post" class=" g-3 needs-validation" action="{{route('admin.roles.add')}}" autocomplete="off" id="RolesForm" >
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <input type="number" name="id" value="0" class="d-none">
                        <label for="validationCustom01" class="form-label">  {{__('translation.title')}}</label>
                        <input type="text" class="form-control" name="title" id="validationCustom01" placeholder="{{__('translation.title')}}"  required>
                        <div class="valid-feedback">
                            Valid
                        </div>
                        <div class="invalid-feedback">Required</div>
                    </div>
                    <div>
                        <label for="status-field" class="form-label">{{__('translation.status')}}</label>
                        <select  class="form-select" id="validationCustom04" required data-trigger name="status" >
                            <option value="">{{__('translation.status')}}</option>
                            <option value="1">Active</option>
                            <option value="2">In-Active</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="hstack gap-2 justify-content-end">
                        <button type="button" class="btn btn-light btn-modal-close" data-bs-dismiss="modal">{{__('translation.close')}}</button>
                        <button type="submit" class="btn btn-success btn-submit btn-add" id="add-btn">@lang('translation.btn_add_role') </button>
                        <button type="submit" class="btn btn-success btn-submit btn-save-changes" id="add-btn" style="display: none">@lang('translation.btn_update')</button>

                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

