



<div class="modal fade" id="dockModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-light p-3">
                <h5 class="modal-title add-lang-title" id="exampleModalLabel" >Add Doc Info</h5>
                <h5 class="modal-title edit-lang-title" id="exampleModalLabel" style="display: none">Edit @lang('translation.user')</h5>
                <button type="button" class="btn-close btn-dock-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
            </div>
            <div>
            </div>
            <form method="post" class=" g-3 needs-validation" action="{{route('admin.dock.store')}}" autocomplete="off" id="addDockInfo" >
                @csrf
                <div class="modal-body">

                    <input type="number" value="{{(isset($data['wh']))? $data['wh']->id:0}}" class="d-none" name="hidden_wh_id_dock">
                    <input type="number" name="hidden_dock_id" value="0" class="d-none" >
                    <div class="mb-3">


                        <label for="status-field" class="form-label">Load Type</label>
                        <div id="loadTypeSelectBoxDropdown"></div>


                    </div>
                    <div class="mb-3">
                        <label for="status-field" class="form-label">Title</label>
                        <input type="text" class="form-control" name="doc_title" placeholder="Title">
                    </div>
                    <div class="mb-3">
                        <label for="status-field" class="form-label">Slot</label>
                        <input type="number" class="form-control" name="slot" placeholder="Slot">
                    </div>
                    <div class="mb-3">
                        <label for="job-category-Input" class="form-label">Scheduling Limitation</label>
                        <div class="input-group">
                            <span class="input-group-text">Customer can schedule </span>
                            <select class="form-select" id="inputGroupSelect01" name="schedule_limit">
                                <option selected="">Choose...</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                                <option value="4">Four</option>
                                <option value="5">Five</option>
                                <option value="6">Six</option>
                                <option value="7">Seven</option>
                                <option value="8">Eight</option>
                                <option value="9">Nine</option>
                                <option value="10">Ten</option>
                                <option value="11">Eleven</option>
                                <option value="12">Twelve</option>
                                <option value="13">Thirteen</option>
                                <option value="14">Fourteen</option>
                                <option value="15">Fifteen</option>
                                <option value="16">Sixteen</option>
                                <option value="17">Seventeen</option>
                                <option value="18">Eighteen</option>
                                <option value="19">Nineteen</option>
                                <option value="20">Twenty</option>
                                <option value="21">Twenty One</option>
                                <option value="22">Twenty Two</option>
                                <option  value="23">Twenty Three</option>
                                <option value="24">Twenty Four</option>
                                <option value="25">Twenty Five</option>
                                <option value="26">Twenty Six</option>
                                <option value="27">Twenty Seven</option>
                                <option value="28">Twenty Eight</option>
                                <option value="29">Twenty Nine</option>
                                <option value="30">Thirty</option>

                            </select>
                            <span class="input-group-text">Days In Advance</span>

                        </div>
                    </div>

                    <div class="mb-3">

                        <label for="job-category-Input" class="form-label">Scheduling Cancellation</label>
                        <div class="input-group">
                            <span class="input-group-text">Customer can not edit/reschedule before </span>
                            <input type="number" class="form-control" placeholder="Hours" aria-label="Username" name="reschedule_before">
                            <span class="input-group-text">hours</span>

                        </div>
                    </div>


                    <div>
                        <label for="status-field" class="form-label">{{__('translation.status')}}</label>
                        <select  class="form-select" id="dockStatus" required data-trigger name="status" >
                            <option value="">Choose One</option>
                            <option value="1">Active</option>
                            <option value="2">In-Active</option>
                        </select>

                    </div>
                </div>
                <div class="modal-footer">
                    <div class="hstack gap-2 justify-content-end">
                        <button type="button" class="btn btn-light btn-dock-close" data-bs-dismiss="modal">{{__('translation.close')}}</button>
                        <button type="submit" class="btn btn-success btn-submit btn-add" id="add-btn">Save</button>
                        <button type="submit" class="btn btn-success btn-submit btn-save-changes" id="add-btn" style="display: none">{{__('translation.btn_update')}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


{{--custom field modal--}}
<div class="modal fade" id="customFieldModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-light p-3">
                <h5 class="modal-title add-lang-title" id="exampleModalLabel" >Assign Fields</h5>
                <h5 class="modal-title edit-lang-title" id="exampleModalLabel" style="display: none">Edit @lang('translation.user')</h5>
                <button type="button" class="btn-close btn-filed-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
            </div>
            <div>
            </div>
            <form method="post" class=" g-3 needs-validation" action="{{route('admin.wh.assign.fields')}}" autocomplete="off" id="assignFieldsForm">
                @csrf
                <div class="modal-body">

                    <input type="number" name="hidden_assigned_field_id" value="0" class="d-none">
                    <input type="number" value="{{(isset($data['wh']))? $data['wh']->id:0}}" class="d-none" name="hidden_wh_id_fields">

                    <div class="mb-3">
                        <label for="status-field" class="form-label">Fields</label>
                        <div id="defaultCustomFieldDropDown"></div>


                    </div>

                    <div class="mb-3">
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
                        <button type="button" class="btn btn-light btn-filed-close" data-bs-dismiss="modal">{{__('translation.close')}}</button>
                        <button type="submit" class="btn btn-success btn-submit btn-add" id="add-btn">Save</button>
                        <button type="submit" class="btn btn-success btn-submit btn-save-changes" id="add-btn" style="display: none">{{__('translation.btn_update')}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="loadTypeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-light p-3">
                <h5 class="modal-title add-lang-title" id="exampleModalLabel" >Add Load Type</h5>
                <h5 class="modal-title edit-lang-title" id="exampleModalLabel" style="display: none">Edit Load Type</h5>
                <button type="button" class="btn-close btn-modal-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
            </div>
            <div>
            </div>


            <form method="post" class=" g-3 needs-validation" action="{{route('admin.load.store')}}" autocomplete="off" id="addLoadTypeForm">
                @csrf
                <div class="modal-body">

                    <div class="mb-3">
                        <input type="number" value="{{(isset($data['wh']))? $data['wh']->id:0}}" class="d-none" name="hidden_wh_id_load_type" placeholder="WH Id">
                        <input type="number" name="hidden_load_type_id" value="0" class="d-none" placeholder="Load Type Id">


                        <label for="status-field" class="form-label">Direction</label>
                        <select  class="form-select" id="status_field" required data-trigger name="direction" >
                            <option value="">Choose One</option>

                            @foreach($data['ltMaterial']['direction'] as $key => $value)
                                <option value="{{ $value->id }}">{{ $value->value }}</option>
                            @endforeach

                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="status-field" class="form-label">Operation</label>
                        <select  class="form-select" id="status_field" required data-trigger name="operation" >
                            <option value="">Choose One</option>
                            @foreach($data['ltMaterial']['operations'] as $key => $value)
                                <option value="{{ $value->id }}">{{ $value->value }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="status-field" class="form-label">Equipment Type</label>
                        <select  class="form-select" id="status_field" required data-trigger name="equipment_type" >
                            <option value="">Choose One</option>
                            @foreach($data['ltMaterial']['equipmentType'] as $key => $value)
                                <option value="{{ $value->id }}">{{ $value->value }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="status-field" class="form-label">Transportation Mode</label>
                        <select  class="form-select" id="status_field" required data-trigger name="trans_mode" >
                            <option value="">Choose One</option>
                            @foreach($data['ltMaterial']['transportationMode'] as $key => $value)
                                <option value="{{ $value->id }}">{{ $value->value }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="status-field" class="form-label">Duration</label>

                        <select name="duration" id="" class="form-control" required>
                            <option value="">Choose One</option>
                            <option value="30">30 Minute</option>
                            <option value="30">60 Minute</option>
                            <option value="30">90 Minute</option>
                            <option value="30">120 Minute</option>
                            <option value="30">150 Minute</option>
                            <option value="30">180 Minute</option>
                        </select>
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
                        <button type="submit" class="btn btn-success btn-submit btn-add" id="add-btn">Save</button>
                        <button type="submit" class="btn btn-success btn-submit btn-save-changes" id="add-btn" style="display: none">{{__('translation.btn_update')}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade zoomIn" id="deleteLoadTypeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close btn-modal-close" data-bs-dismiss="modal" aria-label="Close" id="btn-close"></button>
            </div>
            <div class="modal-body">
                <div class="mt-2 text-center">
                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                    <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                        <h4>Are you Sure ?</h4>
                        <p class="text-muted mx-4 mb-0">Are you Sure You want to Remove this Record ?</p>
                    </div>
                </div>
                <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                    <button type="button" class="btn w-sm btn-light btn-modal-close" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn w-sm btn-danger confirm-delete-load" id="delete-record">Yes, Delete It!</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade zoomIn" id="deleteAssignedFieldsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close btn-modal-close" data-bs-dismiss="modal" aria-label="Close" id="btn-close"></button>
            </div>
            <div class="modal-body">
                <div class="mt-2 text-center">
                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                    <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                        <h4>Are you Sure ?</h4>
                        <p class="text-muted mx-4 mb-0">Are you Sure You want to Remove this Record ?</p>
                    </div>
                </div>
                <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                    <button type="button" class="btn w-sm btn-light btn-modal-close" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn w-sm btn-danger confirm-delete-assigned-fields " id="delete-record">Yes, Delete It!</button>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade zoomIn" id="deleteDockModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close btn-modal-close" data-bs-dismiss="modal" aria-label="Close" id="btn-close"></button>
            </div>
            <div class="modal-body">
                <div class="mt-2 text-center">
                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                    <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                        <h4>Are you Sure ?</h4>
                        <p class="text-muted mx-4 mb-0">Are you Sure You want to Remove this Record ?</p>
                    </div>
                </div>
                <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                    <button type="button" class="btn w-sm btn-light btn-modal-close" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn w-sm btn-danger confirm-delete-dock" id="delete-record">Yes, Delete It!</button>
                </div>
            </div>
        </div>
    </div>
</div>







