

<div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-light p-3">
                <h5 class="modal-title edit-lang-title" id="exampleModalLabel" >Edit Appointment</h5>
                <button type="button" class="btn-close btn-modal-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
            </div>
            <div>
            </div>
            <form method="post" class=" g-3 needs-validation" action="{{route('appointment.update')}}" autocomplete="off" id="UpdateForm"  >
                @csrf
                <div class="modal-body" >
                    <input type="hidden" name="order_id" value="0" >
                    <div id="editForm">

                    </div>
                <div class="modal-footer">
                    <div class="hstack gap-2 justify-content-end">
                        <button type="button" class="btn btn-light btn-modal-close" data-bs-dismiss="modal">{{__('translation.close')}}</button>
                        <button type="submit" class="btn btn-success btn-submit btn-add" id="add-btn">Save Changes</button>
                        <button type="submit" class="btn btn-success btn-submit btn-save-changes" id="add-btn" style="display: none">{{__('translation.btn_update')}}</button>
                    </div>
                </div>
                </div>
            </form>
        </div>
    </div>
</div>



<div class="modal fade" id="showModalReschedule" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-light p-3">
                <h5 class="modal-title edit-lang-title" id="exampleModalLabel" >Reschedule Appointment</h5>
                <button type="button" class="btn-close btn-modal-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
            </div>
            <div>
                @include('combine')
            </div>
            <form method="post" class=" g-3 needs-validation" action="{{route('appointment.updateScheduling')}}" autocomplete="off" id="rescheduleForm"  >
                @csrf
                <div class="modal-body" id="showErrorMsg" >
                    <input type="hidden" name="id" value="0" >
                    <input type="hidden" name="order_date" value="0" >
                    <input type="hidden" name="opra_id" value="0" >
                    <div class="container mt-2" id="rescheduleContainer">
                        <h2 class="text-center">Select Date & Time</h2>
                        <div class="d-flex justify-content-between my-3">
                            <button type="button" class="btn btn-light" id="prev-week"><</button>
                            <div class="text-center" id="date-range">
                                <i class="bi bi-calendar"></i> <span id="current-week-range"></span>
                            </div>
                            <button type="button" class="btn btn-light" id="next-week">></button>
                        </div>
                        <div class="row" id="dates-container">
                            <!-- Dynamic content will be inserted here -->
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="hstack gap-2 justify-content-end">
                            <button type="button" class="btn btn-light btn-modal-close" data-bs-dismiss="modal">{{__('translation.close')}}</button>
                            <button type="submit" class="btn btn-success btn-submit btn-add" id="add-btn">Save Changes</button>
                            <button type="submit" class="btn btn-success btn-submit btn-save-changes" id="add-btn" style="display: none">{{__('translation.btn_update')}}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>












