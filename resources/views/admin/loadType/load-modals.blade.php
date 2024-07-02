


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


            <form method="post" class=" g-3 needs-validation" action="{{route('admin.load.store')}}" autocomplete="off" id="addForm">
                @csrf
                <div class="modal-body">

                    <div class="mb-3">
                        <input type="number" name="hidden_wh_id_load_type" value="0" placeholder="wh_id" class="d-none">
                        <input type="number" name="hidden_load_type_id" value="0" placeholder="load_type_id" class="d-none">


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
                            <option value="30">30 Minutes</option>
                            <option value="60">60 Minutes</option>
                            <option value="90">90 Minutes</option>
                            <option value="120">120 Minutes</option>
                            <option value="150">150 Minutes</option>
                            <option value="180">180 Minutes</option>
                            <option value="210">210 Minutes</option>
                            <option value="240">240 Minutes</option>
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
                        <button type="submit" class="btn btn-success btn-submit btn-add" id="add-btn">Add Load</button>
                        <button type="submit" class="btn btn-success btn-submit btn-save-changes" id="add-btn" style="display: none">{{__('translation.btn_update')}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>



