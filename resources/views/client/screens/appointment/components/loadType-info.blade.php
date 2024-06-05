<div>
    <input type="hidden" name="wh_id" >
    <h5 class="mt-5 mb-1 text-center wh_name" id="wh_name">Selected Warehouse Name</h5>
    <p class="text-muted mb-1 text-center wh_address" id="wh_address">Selcted Warehouse Address</p>
</div>

<div class="mt-4">
    <div class="table-responsive table-card mt-5 mb-5">

        <table class="table align-middle table-nowrap table-striped-columns mb-0" >
            <thead class="table-light">
            <tr>

                <th scope="col">Direction</th>
                <th scope="col">Operation</th>
                <th scope="col">Equipment Type</th>
                <th scope="col">Transportation Mode</th>
                <th scope="col" style="width: 150px;">Action</th>
            </tr>
            </thead>
            <tbody id="loadTypeTable">

            </tbody>
        </table>
        <div id="noresult">

        </div>
    </div>
</div>

<div class="d-flex align-items-start gap-3 mt-4">
    <button type="button" class="btn btn-light btn-label previestab" data-previous="pills-bill-info-tab">
        <i class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i>Back to Warehouse
    </button>
</div>

