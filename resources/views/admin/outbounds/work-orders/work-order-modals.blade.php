
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
                            <select name="staff_id" id="" class="form-select">
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


