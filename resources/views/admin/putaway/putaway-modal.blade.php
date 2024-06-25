


<div class="modal fade" id="loadTypeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-light p-3">
                <h5 class="modal-title add-lang-title" id="exampleModalLabel" >Add Custom Field</h5>
                <h5 class="modal-title edit-lang-title" id="exampleModalLabel" style="display: none">Edit Custom Field</h5>
                <button type="button" class="btn-close btn-modal-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
            </div>
            <div>
            </div>

                <div class="modal-body">
                    <table class="table table-sm table-nowrap">
                        <thead>
                        <tr>
                            <th scope="col">Item Name</th>
                            <th scope="col">SKU</th>
                            <th scope="col">Qty Received</th>
                            <th scope="col">Qty Put Away</th>
                            <th scope="col">Pending</th>
                        </tr>
                        </thead>
                        <tbody id="putAwayItems">
                        </tbody>
                    </table>

                    <div class="modal-footer">
                        <div class="hstack gap-2 justify-content-end">
                            <button type="button" class="btn btn-light btn-modal-close" data-bs-dismiss="modal">{{__('translation.close')}}</button>
                            @canany('admin-putaway-create')
                            <button  type="button" class="btn btn-success btn-close-putaway" data="{{$data['offLoadingInfo']->id}}">Close Put Away</button>
                            @endcanany

                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>


