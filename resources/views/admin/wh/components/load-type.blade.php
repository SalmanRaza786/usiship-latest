<div class="d-flex align-items-start gap-3 mt-4">
    <div>
        <h5 class="mb-1">Load Type Information</h5>
        <p class="text-muted mb-4">Please fill all information below</p>
    </div>
    <button type="button" class="btn btn-success add-btn right ms-auto" data-bs-toggle="modal" id="create-btn" data-bs-target="#loadTypeModal"><i class="ri-add-line align-bottom me-1"></i> Add Load Type</button>

</div>

<div class="table-responsive table-card mt-3 mb-5">
    <table class="table align-middle table-nowrap table-striped-columns mb-0">
        <thead class="table-light">
        <tr>


            <th scope="col">Direction</th>
            <th scope="col">Operation</th>
            <th scope="col">Equipment Type</th>
            <th scope="col">Transportation Mode</th>
            <th scope="col">Duration</th>
            <th scope="col">Status</th>
            <th scope="col" style="width: 150px;">Action</th>
        </tr>
        </thead>
        <tbody id="loadTypeTable"></tbody>
    </table>
</div>

<div class="d-flex align-items-start gap-3 mt-4">
    <button type="button" class="btn btn-light btn-label previestab" data-previous="pills-bill-info-tab"><i class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i>Back to General Info</button>
    <button type="button" class="btn btn-primary btn-label right ms-auto nexttab" data-nexttab="pills-payment-tab"><i class="ri-map-pin-line label-icon align-middle fs-16 ms-2"></i>Continue to Dock Info</button>
</div>





