@extends('layouts.master')
@section('title') Item Put away List @endsection
@section('css')

@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('routeUrl') {{url('/')}} @endslot
        @slot('li_1') Dashboard @endslot
        @slot('title') Item Put away List @endslot
    @endcomponent

    <div class="container-fluid">


        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex ">
                        <div class="col">
                            <h4 class="card-title mb-0">Item Put Away Detail</h4>

                        </div>
                        <div class="col-auto justify-content-sm-end">

                            <button type="button" class="btn btn-info add-btn me-2" data-bs-toggle="modal" id="create-btn" data-bs-target="#loadTypeModal" style="
"><i class="ri-eye-line align-bottom me-1"></i> Check Put Away Status</button><button type="button" class="btn btn-success add-btn" data-bs-toggle="modal" id="create-btn" data-bs-target="#loadTypeModal" style="
"><i class="ri-add-line align-bottom me-1"></i> Start Put Away Now</button>
                        </div>

                    </div>

                    <div class="card-body">


                        <div class="live-preview">
                            <div class="row gy-4">
                                <div class="col-xxl-3 col-md-6">
                                    <div>
                                        <label for="basiInput" class="form-label">Container #</label>
                                        <input type="text" class="form-control" id="basiInput" value="2311212" disabled="">
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-xxl-3 col-md-6">
                                    <div>
                                        <label for="labelInput" class="form-label">Staged Location</label>
                                        <input type="text" class="form-control" id="labelInput" value="12" disabled="">
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-xxl-3 col-md-6">
                                    <div>
                                        <label for="placeholderInput" class="form-label">Arrival Date/Time</label>
                                        <input type="text" class="form-control" id="placeholderInput" value="23-04-2024 11:30 PM" disabled="">
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-xxl-3 col-md-6">
                                    <div>
                                        <label for="valueInput" class="form-label">Load Type</label>
                                        <input type="text" class="form-control" id="valueInput" value="LTL" disabled="">
                                    </div>
                                </div>
                                <!--end col-->






























                            </div>
                            <!--end row-->
                        </div>


                    </div>


                </div>
            </div>
            <!--end col-->
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">

                    <div class="card-body">
                        <div class="live-preview">
                            <div class="table-responsive">
                                <table class="invoice-table table table-borderless table-nowrap mb-0">
                                    <thead class="align-middle">
                                    <tr class="table-active">
                                        <th scope="col" style="width: 50px;">#</th>
                                        <th scope="col">
                                            Product SKU
                                        </th>
                                        <th scope="col" style="">
                                            <div class="d-flex currency-select input-light align-items-center">Quantity
                                            </div>
                                        </th>
                                        <th scope="col" style="">Pallet Number</th>
                                        <th scope="col" class="text-end" style="width: 150px;">Put Away Location</th>
                                        <th scope="col" class="text-end" style="width: 105px;"></th>
                                    </tr>
                                    </thead>
                                    <tbody id="newlink">

                                    <tr id="2" class="product"><td class="d-none" colspan="5"><p>Add New Form</p></td><th scope="row" class="product-id">1</th><td class="text-start"><div class="mb-2"><input class="form-control bg-light border-0" type="text" id="productName-2" placeholder="Product SKU"></div></td><td><input class="form-control bg-light border-0 product-price" type="number" id="productRate-2" step="0.01" placeholder="Qty"></td><td><input class="form-control bg-light border-0 product-price" type="number" id="productRate-2" step="0.01" placeholder="Pallet #"></td><td class="text-end"><div class="input-light">
                                                <div class="choices" data-type="select-one" tabindex="0" role="listbox" aria-haspopup="true" aria-expanded="false"><div class="choices__inner"><select class="form-control bg-light border-0 choices__input" data-choices="" data-choices-search-false="" data-choices-removeitem="" id="choices-payment-type" hidden="" tabindex="-1" data-choice="active"><option value="" data-custom-properties="[object Object]">Payment Method</option></select><div class="choices__list choices__list--single"><div class="choices__item choices__placeholder choices__item--selectable" data-item="" data-id="1" data-value="" data-custom-properties="[object Object]" aria-selected="true" data-deletable="">Select Location<button type="button" class="choices__button" aria-label="Remove item: ''" data-button="">Remove item</button></div></div></div><div class="choices__list choices__list--dropdown" aria-expanded="false"><div class="choices__list" role="listbox"><div id="choices--choices-payment-type-item-choice-3" class="choices__item choices__item--choice is-selected choices__placeholder choices__item--selectable is-highlighted" role="option" data-choice="" data-id="3" data-value="" data-select-text="Press to select" data-choice-selectable="" aria-selected="true">Payment Method</div><div id="choices--choices-payment-type-item-choice-1" class="choices__item choices__item--choice choices__item--selectable" role="option" data-choice="" data-id="1" data-value="Credit Card" data-select-text="Press to select" data-choice-selectable="">Credit Card</div><div id="choices--choices-payment-type-item-choice-2" class="choices__item choices__item--choice choices__item--selectable" role="option" data-choice="" data-id="2" data-value="Mastercard" data-select-text="Press to select" data-choice-selectable="">Mastercard</div><div id="choices--choices-payment-type-item-choice-4" class="choices__item choices__item--choice choices__item--selectable" role="option" data-choice="" data-id="4" data-value="Paypal" data-select-text="Press to select" data-choice-selectable="">Paypal</div><div id="choices--choices-payment-type-item-choice-5" class="choices__item choices__item--choice choices__item--selectable" role="option" data-choice="" data-id="5" data-value="Visa" data-select-text="Press to select" data-choice-selectable="">Visa</div></div></div></div>
                                            </div></td><td class="product-removal"><a class="btn btn-success">Upload Photo</a></td></tr><tr id="3" class="product"><td class="d-none" colspan="5"><p>Add New Form</p></td><th scope="row" class="product-id">2</th><td class="text-start"><div class="mb-2"><input class="form-control bg-light border-0" type="text" id="productName-3" placeholder="Product Name"></div></td><td><input class="form-control bg-light border-0 product-price" type="number" id="productRate-3" step="0.01" placeholder="Qty"></td><td><input class="form-control bg-light border-0 product-price" type="number" id="productRate-2" step="0.01" placeholder="Pallet #"></td><td class="text-end"><div class="input-light">
                                                <div class="choices" data-type="select-one" tabindex="0" role="listbox" aria-haspopup="true" aria-expanded="false"><div class="choices__inner"><select class="form-control bg-light border-0 choices__input" data-choices="" data-choices-search-false="" data-choices-removeitem="" id="choices-payment-type" hidden="" tabindex="-1" data-choice="active"><option value="" data-custom-properties="[object Object]">Payment Method</option></select><div class="choices__list choices__list--single"><div class="choices__item choices__placeholder choices__item--selectable" data-item="" data-id="1" data-value="" data-custom-properties="[object Object]" aria-selected="true" data-deletable="">Select Location<button type="button" class="choices__button" aria-label="Remove item: ''" data-button="">Remove item</button></div></div></div><div class="choices__list choices__list--dropdown" aria-expanded="false"><div class="choices__list" role="listbox"><div id="choices--choices-payment-type-item-choice-3" class="choices__item choices__item--choice is-selected choices__placeholder choices__item--selectable is-highlighted" role="option" data-choice="" data-id="3" data-value="" data-select-text="Press to select" data-choice-selectable="" aria-selected="true">Payment Method</div><div id="choices--choices-payment-type-item-choice-1" class="choices__item choices__item--choice choices__item--selectable" role="option" data-choice="" data-id="1" data-value="Credit Card" data-select-text="Press to select" data-choice-selectable="">Credit Card</div><div id="choices--choices-payment-type-item-choice-2" class="choices__item choices__item--choice choices__item--selectable" role="option" data-choice="" data-id="2" data-value="Mastercard" data-select-text="Press to select" data-choice-selectable="">Mastercard</div><div id="choices--choices-payment-type-item-choice-4" class="choices__item choices__item--choice choices__item--selectable" role="option" data-choice="" data-id="4" data-value="Paypal" data-select-text="Press to select" data-choice-selectable="">Paypal</div><div id="choices--choices-payment-type-item-choice-5" class="choices__item choices__item--choice choices__item--selectable" role="option" data-choice="" data-id="5" data-value="Visa" data-select-text="Press to select" data-choice-selectable="">Visa</div></div></div></div>
                                            </div></td><td class="product-removal"><a class="btn btn-success">Upload Photo</a></td></tr></tbody>
                                    <tbody>
                                    <tr id="newForm" style="display: none;"><td class="d-none" colspan="5"><p>Add New Form</p></td></tr>
                                    <tr>
                                        <td colspan="5">
                                            <a href="javascript:new_link()" id="add-item" class="btn btn-soft-secondary fw-medium"><i class="ri-add-fill me-1 align-bottom"></i> Add Item</a>
                                        </td>
                                    </tr>

                                    </tbody>
                                </table>
                                <!--end table-->
                            </div>
                            <!--end row-->
                        </div>

                    </div>
                </div>
            </div>
            <!--end col-->
        </div>

        <div class="modal fade " id="loadTypeModal" tabindex="-1" aria-labelledby="exampleModalLabel" data-keyboard="false" data-backdrop="static" style="display: block; padding-left: 0px;" aria-modal="true" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-light p-3">
                        <h5 class="modal-title add-lang-title" id="exampleModalLabel">Check Put Away Status</h5>
                        <h5 class="modal-title edit-lang-title" id="exampleModalLabel" style="display: none">Edit Load Type</h5>
                        <button type="button" class="btn-close btn-modal-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                    </div>
                    <div>
                    </div>


                    <form method="post" class=" g-3 needs-validation" action="https://usiship.designkorner.com/admin/save-update-load-type" autocomplete="off" id="addForm">
                        <input type="hidden" name="_token" value="W1cdIaY3jBeOJy68fbRPSLM6nhuGMkPdflPwWfwW" autocomplete="off">                <div class="modal-body">

                            <div class="row gy-4">



                                <!-- Small Tables -->
                                <table class="table table-sm table-nowrap">
                                    <thead>
                                    <tr>
                                        <th scope="col">Item Name</th>
                                        <th scope="col">SKU</th>
                                        <th scope="col">Qty In Packing Slip</th>
                                        <th scope="col">Qty Put Away</th>
                                        <th scope="col">Pending</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>

                                        <td>Implement new UX</td>
                                        <td>234345223</td>
                                        <td>100</td>
                                        <td>80</td>
                                        <td>20</td>
                                    </tr><tr>

                                        <td>Implement new UX</td>
                                        <td>234345223</td>
                                        <td>100</td>
                                        <td>80</td>
                                        <td>20</td>
                                    </tr><tr>

                                        <td>Implement new UX</td>
                                        <td>234345223</td>
                                        <td>100</td>
                                        <td>80</td>
                                        <td>20</td>
                                    </tr><tr>

                                        <td>Implement new UX</td>
                                        <td>234345223</td>
                                        <td>100</td>
                                        <td>80</td>
                                        <td>20</td>
                                    </tr><tr>

                                        <td>Implement new UX</td>
                                        <td>234345223</td>
                                        <td>100</td>
                                        <td>80</td>
                                        <td>20</td>
                                    </tr><tr>

                                        <td>Implement new UX</td>
                                        <td>234345223</td>
                                        <td>100</td>
                                        <td>80</td>
                                        <td>20</td>
                                    </tr><tr>

                                        <td>Implement new UX</td>
                                        <td>234345223</td>
                                        <td>100</td>
                                        <td>80</td>
                                        <td>20</td>
                                    </tr><tr>

                                        <td>Implement new UX</td>
                                        <td>234345223</td>
                                        <td>100</td>
                                        <td>80</td>
                                        <td>20</td>
                                    </tr><tr>

                                        <td>Implement new UX</td>
                                        <td>234345223</td>
                                        <td>100</td>
                                        <td>80</td>
                                        <td>20</td>
                                    </tr><tr>

                                        <td>Implement new UX</td>
                                        <td>234345223</td>
                                        <td>100</td>
                                        <td>80</td>
                                        <td>20</td>
                                    </tr><tr>

                                        <td>Implement new UX</td>
                                        <td>234345223</td>
                                        <td>100</td>
                                        <td>80</td>
                                        <td>20</td>
                                    </tr><tr>

                                        <td>Implement new UX</td>
                                        <td>234345223</td>
                                        <td>200</td>
                                        <td>200</td>
                                        <td>0</td>
                                    </tr>




                                    </tbody>
                                </table>


































                            </div>






                        </div>
                        <div class="modal-footer">
                            <div class="hstack gap-2 justify-content-end">
                                <button type="button" class="btn btn-light btn-modal-close" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success btn-submit btn-add" id="add-btn">Complete Put Away</button>
                                <button type="submit" class="btn btn-success btn-submit btn-save-changes" id="add-btn" style="display: none">Save Changes</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>




    </div>
@endsection

