
<div class="modal fade zoomIn" id="orderConfirmModal" tabindex="-1" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close btn-modal-close" data-bs-dismiss="modal" aria-label="Close" id="btn-close"></button>
            </div>
            <div class="modal-body">
                <div class="mt-2 text-center">
                    <lord-icon  src="https://cdn.lordicon.com/pithnlch.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                    <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                        <h4>Are you sure</h4>
                        <p class="text-muted mx-4 mb-0">You want to <span id="confirmText"></span> this order ?</p>
                    </div>
                </div>
                <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                    <button type="button" class="btn w-sm btn-light btn-modal-close" data-bs-dismiss="modal">No</button>
                    <button type="button" class="btn w-sm btn-success btn-confirm-order" >Yes</button>
                </div>
            </div>
        </div>
    </div>
</div>









