
<div class="modal fade" id="checkInModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-light p-3">
                <h5 class="modal-title add-lang-title" id="exampleModalLabel" >Start Processing</h5>
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="btn-close btn-modal-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
            </div>
            <div>
            </div>


            <form method="post" class=" g-3 needs-validation" action="{{route('admin.process.start')}}" autocomplete="off" id="ProcessStart" enctype="multipart/form-data">

               @csrf
                <div class="modal-body">
                    <input type="hidden" name="process_id">
                    <input type="hidden" name="updateType" value="1"/>
                    <div class="row gy-4">
                        <dv class="col-md-6">
                            <div>
                                <label for="disabledInput" class="form-label">WMS Order Number</label>
                                <input type="text" class="form-control" name="order_ref" id="disabledInput" disabled="">
                            </div>
                        </dv>
                        <div class="col-md-6">
                            <label for="status-field" class="form-label">Customer</label>
                            <input type="text" class="form-control" id="disabledInput" name="customer_name" value="Customer Name" disabled="">
                        </div>
                        <div class="col-md-6">
                            <div>
                                <label for="labelInput" class="form-label">Q/C Start Time</label>
                                <input type="text" class="form-control" id="disabledInput" name="qc_start_time" value="24-07-2024 13:30:45" disabled="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div>
                                <label for="labelInput" class="form-label">Staged Location</label>
                                <input type="text" class="form-control" id="disabledInput" name="staged_location" value="Location Name" disabled="">
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div>
                                <label for="status-field" class="form-label" data-choice>Select Load Type</label>
                                <select name="staff_id" id="" class="form-select">
                                    <option value="">Choose One</option>
                                    @isset($data['loadTypes'])
                                        @foreach($data['loadTypes'] as $row)
                                            <option value="{{$row->id}}">{{$row->name}}</option>
                                        @endforeach
                                    @endisset
                                </select>
                             </div>
                        </div>
                        <div class="col-md-6">

                        </div>
                        <div class="col-md-6">
                            <div class="form-check form-switch form-switch-lg" dir="ltr">
                                <input type="checkbox" class="form-check-input" id="customSwitchsizelg" name="carton_label_req">
                                <label class="form-check-label" for="customSwitchsizelg">Carton Label Required</label>
                            </div>
                        </div><div class="col-md-6">
                            <div class="form-check form-switch form-switch-lg" dir="ltr">
                                <input type="checkbox" class="form-check-input" id="customSwitchsizelg"  name="pallet_label_req">
                                <label class="form-check-label" for="customSwitchsizelg">Pallet Label Required</label>
                            </div>
                        </div><div class="col-md-12">
                            <div>
                                <label for="exampleFormControlTextarea5" class="form-label">Other Requirements</label>
                                <textarea class="form-control" name="other_reqs" id="exampleFormControlTextarea5" rows="3"></textarea>
                            </div>
                        </div>


                    </div>


                </div>
                <div class="modal-footer">
                    <div class="hstack gap-2 justify-content-end">
                        <button type="button" class="btn btn-light btn-modal-close" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success btn-submit btn-start" id="add-btn" style="display: block;">Start Processing Now</button>
                        <button type="submit" class="btn btn-success btn-submit btn-save-changes" id="add-btn" style="display: none;">Assign Picker Now</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


