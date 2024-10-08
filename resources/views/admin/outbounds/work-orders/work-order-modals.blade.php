
<div class="modal fade" id="checkInModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light p-3">
                <h5 class="modal-title add-lang-title" id="exampleModalLabel" >Assign Picker</h5>
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="btn-close btn-modal-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
            </div>
            <div>
            </div>


            <form method="post" class=" g-3 needs-validation" action="{{route('admin.picker.assign')}}" autocomplete="off" id="AssignForm" enctype="multipart/form-data">

               @csrf
                <div class="modal-body">
                    <input type="hidden" name="w_order_id"  value="0">

                    <div class="row gy-4">
                        <select name="status_code" id="" class="form-select d-none">
                            <option value="">Choose One</option>
                            @isset($data['status'])
                                @foreach($data['status'] as $row)
                                    <option value="{{$row->order_by}}"
                                    @if($row->order_by==205)
                                        {{'selected'}}
                                        @endif
                                    >{{$row->status_title}}</option>
                                @endforeach
                            @endisset
                        </select>

                        <div class="col-md-12">
                            <label for="status-field" class="form-label" data-choice>Assign Picker</label>
                            <select name="staff_id" id="" class="form-select" required>
                                <option value="">Choose One</option>
                                @isset($data['staff'])
                                    @foreach($data['staff'] as $row)
                                <option value="{{$row->id}}">{{$row->name}}</option>
                                    @endforeach
                                @endisset
                            </select>
                        </div>




                    </div>


                </div>
                <div class="modal-footer">
                    <div class="hstack gap-2 justify-content-end">
                        <button type="button" class="btn btn-light btn-modal-close" data-bs-dismiss="modal">Close</button>

                        <button type="submit" class="btn btn-success btn-submit" id="add-btn" >Assign Picker </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light p-3">
                <h5 class="modal-title add-lang-title" id="exampleModalLabel" >Import Work Orders From WMS</h5>
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="btn-close btn-modal-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
            </div>
            <div>
            </div>


            <form method="post" class=" g-3 needs-validation" action="{{route('admin.work.orders.import')}}" autocomplete="off" id="ImportForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row gy-4">
                        <div class="col-md-12">
                            <label for="status-field" class="form-label" data-choice>Select the Date</label>
                            <input type="date" name="import_date" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="hstack gap-2 justify-content-end">
                        <button type="button" class="btn btn-light btn-modal-close" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success btn-submit" id="add-btn" >Import WMS Orders</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="UploadBOLDoc" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light p-3">
                <h5 class="modal-title add-lang-title" id="exampleModalLabel" >Upload BOL Document</h5>
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="btn-close btn-modal-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
            </div>
            <div>
            </div>


            <form method="post" class=" g-3 needs-validation" action="{{route('admin.upload.bol')}}" autocomplete="off" id="UploadBOLForm" enctype="multipart/form-data">

                @csrf
                <div class="modal-body">
                    <input type="hidden" name="w_order_id"  value="0">
                    <div class="row gy-4">
                        <div class="col-md-12">
                            <label for="status-field" class="form-label" data-choice>Select and Upload Bol Document</label>
                            <input type="file" name="BOLDocument" class="form-control" required/>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <div class="hstack gap-2 justify-content-end">
                        <button type="button" class="btn btn-light btn-modal-close" data-bs-dismiss="modal">Close</button>

                        <button type="submit" class="btn btn-success btn-submit" id="add-btn" >Upload</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="showModalSchedule" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-light p-3">
                <h5 class="modal-title edit-lang-title" id="exampleModalLabel" >Schedule Order</h5>
                <button type="button" class="btn-close btn-modal-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
            </div>
            <div>
                @include('combine')
            </div>
            <form action="{{route('order.store')}}" method="post" id="scheduleForm" enctype="multipart/form-data" >
                @csrf
                <input type="hidden"  name="work_order_id" >
                <input type="hidden"  name="customer_id" >
                <input type="number" class="d-none" name="order_status" value="6">
                <input type="text" name="created_by" class="d-none" value="{{auth()->user()->id}}">
                <input type="text" name="guard" class="d-none" id="authGuard" value="{{\Illuminate\Support\Facades\Auth::getDefaultDriver()}}">
                <input type="hidden" name="dock_id" value="1">
                <input type="hidden" name="wh_id" >
                <input type="hidden" name="load_type_id" >
                <input type="hidden"  name="order_type" value="2">
                <input type="hidden"  name="order_date">
                <input name="opra_id" type="hidden">
                <div class="modal-body" id="showErrorMsg" >
                    <h2 class="text-center">Select Date & Time</h2>
                    <div class="d-flex justify-content-between my-3">
                        <button type="button" class="btn btn-light" id="prev-week"><</button>
                        <div class="text-center" id="date-range">
                            <i class="bi bi-calendar"></i> <span id="current-week-range"></span>
                        </div>
                        <button type="button" class="btn btn-light" id="next-week">></button>
                    </div>
                    <div class="row dates-container" id="dates-container">
                        <!-- Dynamic content will be inserted here -->
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

