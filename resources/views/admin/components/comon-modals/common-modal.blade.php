


<div class="modal fade zoomIn" id="deleteRecordModal" tabindex="-1" aria-hidden="true">
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
                        <p class="text-muted mx-4 mb-0">Are you Sure You want to remove this Record ?</p>
                    </div>
                </div>
                <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                    <button type="button" class="btn w-sm btn-light btn-modal-close" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn w-sm btn-danger confirm-delete " id="delete-record">Yes, Delete It!</button>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="showModalUpoad" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-light p-3">
                <h5 class="modal-title edit-lang-title" id="exampleModalLabel" >Upload Packaging list</h5>
                <button type="button" class="btn-close btn-modal-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
            </div>
            <div>
            </div>
            <form method="post" class=" g-3 needs-validation" action="{{route('appointment.upload-list')}}" autocomplete="off" id="uploadForm" enctype="multipart/form-data"   >
                @csrf
                <div class="modal-body" >
                    <input type="hidden" name="id" value="0" >
                    <div class="mb-3">
                        <label class="form-label" for="upload">Upload Packaging List</label>
                        <div class="position-relative auth-pass-inputgroup">
                            <input type="file" id="upload"  name="import_file" accept=".xlsx, .xls" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="hstack gap-2 justify-content-end">
                            <button type="button" class="btn btn-light btn-modal-close" data-bs-dismiss="modal">{{__('translation.close')}}</button>
                            <button type="submit" class="btn btn-success btn-submit " >Upload</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="addImagesModal" tabindex="-1">
    <div class="modal-dialog  modal-xl modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header p-3 bg-soft-info">
                <h5 class="modal-title" id="modal-title">Add Images</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body p-4">
                <div class="container">
{{--                    <h2 class="text-center">Dropzone Multiple Images Upload</h2>--}}
                    <form class="needs-validation dropzone" method="post" enctype="multipart/form-data" action="{{ route('packaging.images.store') }}">
                        @csrf
                        <input type="hidden" name="packging_id" id="packging_id" value="0">
                        <div class="fallback">
                            <input name="file" type="file" accept=".jpeg,.jpg,.png,.gif"  multiple="multiple">
                        </div>
                        <div class="dz-message needsclick">
                            <div class="mb-3">
                                <i class="display-4 text-muted ri-upload-cloud-2-fill"></i>
                            </div>
                            <h4>Drop files here or click to upload.</h4>
                        </div>
                    </form>
                    <ul class="list-unstyled mb-0" id="dropzone-preview">
                        <li class="mt-2" id="dropzone-preview-list">

                        </li>
                    </ul>
                </div>

            </div>
        </div>
        <!-- end modal-content-->
    </div>
    <!-- end modal dialog-->
</div>



