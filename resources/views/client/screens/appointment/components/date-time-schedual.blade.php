<div>
    <input type="hidden" name="dock_id">
    <input type="text" class="d-none" name="order_date">
</div>

<div class="container mt-5">
    <input name="opra_id" type="hidden">
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
</div>

<div class="d-flex align-items-start gap-3 mt-4">

    <button type="button" class="btn btn-light btn-label previestab" data-previous="pills-dock-tab">
        <i class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i>Back to Dock
    </button>
</div>
{{--<div class="d-flex align-items-start gap-3 mt-3">--}}
{{--    <button type="button" class="btn btn-primary btn-label right ms-auto nexttab" data-nexttab="pills-finish-tab" >--}}
{{--        <i class="ri-truck-line label-icon align-middle fs-16 ms-2"></i>Proceed to Details--}}
{{--    </button>--}}
{{--</div>--}}
