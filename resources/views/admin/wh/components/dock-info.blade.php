<div class="d-flex align-items-start gap-3 mt-4">
    <div>
        <h5 class="mb-1">Warehouse Dock Information</h5>
        <p class="text-muted mb-4">Please fill all information below</p>
    </div>
    <button type="button" class="btn btn-success add-btn right ms-auto" data-bs-toggle="modal" id="create-btn" data-bs-target="#dockModal"><i class="ri-add-line align-bottom me-1"></i> Add Dock Info</button>
</div>

<table class="table align-middle table-striped-columns mb-0">
    <thead class="table-light">
    <tr>
        <th scope="col">Load Type</th>
        <th scope="col">Title</th>
        <th scope="col">Slot</th>
        <th scope="col">Scheduling</th>
        <th scope="col">Scheduling Edit/Cancel</th>
        <th scope="col">Status</th>
        <th scope="col">Action</th>
    </tr>
    </thead>
    <tbody id="dockTable">


    </tbody>
</table>
<div class="d-flex align-items-start gap-3 mt-4">
    <button type="button" class="btn btn-light btn-label previestab" data-previous="pills-bill-address-tab"><i class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i>Back to Shipping</button>
    <button type="button" class="btn btn-primary btn-label right ms-auto nexttab" data-nexttab="pills-finish-tab"><i class="ri-shopping-basket-line label-icon align-middle fs-16 ms-2"></i>Continue to Appointment Fields</button>
</div>



