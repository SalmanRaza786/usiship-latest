@extends('layouts.master')
@section('title')
    Packing List Confirmation
@endsection
@section('css')

@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('routeUrl')
            {{url('/')}}
        @endslot
        @slot('li_1')
            Dashboard
        @endslot
        @slot('title')
            Packing List Confirmation
        @endslot
    @endcomponent

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex ">
                        <div class="col">
                            <h4 class="card-title mb-0">Packing List Confirmation</h4>
                        </div>
                        <div class="col-auto justify-content-sm-end">
                            <button type="button" class="btn btn-warning add-btn me-2" data-bs-toggle="modal"
                                    id="create-btn" data-bs-target="#loadTypeModal" style=""><i class="ri-alert-line align-bottom me-1"></i> Report Exception/Damages
                            </button>
                            <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal" id="create-btn"
                                    data-bs-target="#loadTypeModal" style=""><i class="ri-save-line align-bottom me-1"></i> Save/Close Packing List
                            </button>
                        </div>

                    </div>

                    <div class="card-body">

                        <div class="live-preview">
                            <div class="row gy-4">
                                <div class="col-xxl-3 col-md-6">
                                    <div>
                                        <label for="basiInput" class="form-label">Container #</label>
                                        <input type="text" class="form-control" id="basiInput" value="2311212"
                                               disabled="">
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
                                        <input type="text" class="form-control" id="placeholderInput"
                                               value="23-04-2024 11:30 PM" disabled="">
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
                                <table class="invoice-table table table-borderless table-nowrap mb-0 position-relative"
                                       style="">
                                    <thead class="align-middle">
                                    <tr class="table-active">
                                        <th scope="col">#</th>
                                        <th scope="col">
                                            Product Name
                                        </th>
                                        <th scope="col">
                                            Product SKU
                                        </th>
                                        <th scope="col">
                                            Qty Per packing Slip
                                        </th>
                                        <th scope="col" class="text-center">
                                            Action
                                        </th>
                                        <th scope="col" class="text-center">
                                            Qty Received Cartons
                                        </th>
                                        <th scope="col" class="text-center">
                                            Qty Received Each
                                        </th>
                                        <th scope="col" class="text-center">
                                            Exception Qty
                                        </th>
                                        <th scope="col" class="text-center">
                                            Damage
                                        </th>
                                        <th scope="col" class="text-center">Ti
                                        </th>
                                        <th scope="col" class="text-center">Hi</th>
                                        <th scope="col" class="text-center">Total Pallets</th>
                                        <th scope="col" class="text-center">Lot 3</th>
                                        <th scope="col" class="text-center">Serial #</th>
                                        <th scope="col" class="text-center">UPC Label</th>
                                        <th scope="col" class="text-center">UPC Label Photo</th>
                                        <th scope="col" class="text-center">Expiry Date</th>
                                        <th scope="col" class="text-center">Lenght</th>
                                        <th scope="col" class="text-center">Width</th>
                                        <th scope="col" class="text-center">Height</th>
                                        <th scope="col" class="text-center">Weight</th>
                                        <th scope="col" class="text-center">Custome Field 1</th>
                                        <th scope="col" class="text-center">Custom Field 2</th>
                                        <th scope="col" class="text-center">Custome Field 3</th>
                                        <th scope="col" class="text-center">Custom Field 4</th>
                                        <th scope="col" class="text-end">Put Away Location</th>
                                        <th scope="col" class="text-center"></th>
                                    </tr>
                                    </thead>
                                    <tbody id="newlink">

                                    <tr id="1" class="product">
                                        <td class="d-none" colspan="5"><p>Add New Form</p></td>
                                        <td scope="row" class="product-id align-middle" style="">1
                                        </td>
                                        <td scope="row" class="product-id align-middle">Item Name</td>
                                        <td scope="row" class="product-id align-middle">SKU223892</td>
                                        <td scope="row" class="product-id align-middle">100</td>
                                        <td class="product-id align-middle">
                                            <div class="hstack gap-3">
                                                <a href="javascript:void(0);" class="link-success fs-15"><i
                                                        class="ri-edit-2-line fs-24"></i></a>
                                                <a href="javascript:void(0);" class="link-danger fs-15"><i
                                                        class="ri-save-line fs-24"></i></a>
                                            </div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0" type="text"
                                                                     style="width: 150px;" id="productName-2"
                                                                     placeholder="Catons Qty"></div>
                                        </td>
                                        <td><input class="form-control bg-light border-0 product-price"
                                                   style="width: 150px;" type="number" id="productRate-2" step="0.01"
                                                   placeholder="Qty Each"></td>
                                        <td><input class="form-control bg-light border-0 product-price"
                                                   style="width: 150px;" type="number" id="productRate-2" step="0.01"
                                                   placeholder="Exception Qty"></td>
                                        <td class="product-removal"><a class="btn btn-success">Upload Photo</a></td>
                                        <td class="text-start" style="width: 150px;">
                                            <div class="mb-2"><input class="form-control bg-light border-0"
                                                                     style="width: 150px;" type="text"
                                                                     id="productName-2" placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0"
                                                                     style="width: 150px;" type="text"
                                                                     id="productName-2" placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0"
                                                                     style="width: 150px;" type="text"
                                                                     id="productName-2" placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0"
                                                                     style="width: 150px;" type="text"
                                                                     id="productName-2" placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0" type="text"
                                                                     id="productName-2" style="width: 150px;"
                                                                     placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0"
                                                                     style="width: 150px;" type="text"
                                                                     id="productName-2" placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="product-removal"><a class="btn btn-success">Upload Photo</a></td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0" type="text"
                                                                     id="productName-2" style="width: 150px;"
                                                                     placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0"
                                                                     style="width: 150px;" type="text"
                                                                     id="productName-2" placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0" type="text"
                                                                     style="width: 150px;" id="productName-2"
                                                                     placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0" type="text"
                                                                     id="productName-2" style="width: 150px;"
                                                                     placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0"
                                                                     style="width: 150px;" type="text"
                                                                     id="productName-2" placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-center">
                                            <div class="mb-2"><input class="form-control bg-light border-0" type="text"
                                                                     id="productName-2" style="width: 150px;"
                                                                     placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-center">
                                            <div class="mb-2"><input class="form-control bg-light border-0" type="text"
                                                                     id="productName-2" style="width: 150px;"
                                                                     placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-center">
                                            <div class="mb-2"><input class="form-control bg-light border-0" type="text"
                                                                     id="productName-2" style="width: 150px;"
                                                                     placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-center">
                                            <div class="mb-2"><input class="form-control bg-light border-0" type="text"
                                                                     id="productName-2" style="width: 150px;"
                                                                     placeholder="Catons Qty"></div>
                                        </td>
                                    </tr>
                                    <tr id="1" class="product">
                                        <td class="d-none" colspan="5"><p>Add New Form</p></td>
                                        <td scope="row" class="product-id align-middle" style="">1
                                        </td>
                                        <td scope="row" class="product-id align-middle">Item Name</td>
                                        <td scope="row" class="product-id align-middle">SKU223892</td>
                                        <td scope="row" class="product-id align-middle">100</td>
                                        <td class="product-id align-middle">
                                            <div class="hstack gap-3">
                                                <a href="javascript:void(0);" class="link-success fs-15"><i
                                                        class="ri-edit-2-line fs-24"></i></a>
                                                <a href="javascript:void(0);" class="link-danger fs-15"><i
                                                        class="ri-save-line fs-24"></i></a>
                                            </div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0" type="text"
                                                                     style="width: 150px;" id="productName-2"
                                                                     placeholder="Catons Qty"></div>
                                        </td>
                                        <td><input class="form-control bg-light border-0 product-price"
                                                   style="width: 150px;" type="number" id="productRate-2" step="0.01"
                                                   placeholder="Qty Each"></td>
                                        <td><input class="form-control bg-light border-0 product-price"
                                                   style="width: 150px;" type="number" id="productRate-2" step="0.01"
                                                   placeholder="Exception Qty"></td>
                                        <td class="product-removal"><a class="btn btn-success">Upload Photo</a></td>
                                        <td class="text-start" style="width: 150px;">
                                            <div class="mb-2"><input class="form-control bg-light border-0"
                                                                     style="width: 150px;" type="text"
                                                                     id="productName-2" placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0"
                                                                     style="width: 150px;" type="text"
                                                                     id="productName-2" placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0"
                                                                     style="width: 150px;" type="text"
                                                                     id="productName-2" placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0"
                                                                     style="width: 150px;" type="text"
                                                                     id="productName-2" placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0" type="text"
                                                                     id="productName-2" style="width: 150px;"
                                                                     placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0"
                                                                     style="width: 150px;" type="text"
                                                                     id="productName-2" placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="product-removal"><a class="btn btn-success">Upload Photo</a></td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0" type="text"
                                                                     id="productName-2" style="width: 150px;"
                                                                     placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0"
                                                                     style="width: 150px;" type="text"
                                                                     id="productName-2" placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0" type="text"
                                                                     style="width: 150px;" id="productName-2"
                                                                     placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0" type="text"
                                                                     id="productName-2" style="width: 150px;"
                                                                     placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0"
                                                                     style="width: 150px;" type="text"
                                                                     id="productName-2" placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-center">
                                            <div class="mb-2"><input class="form-control bg-light border-0" type="text"
                                                                     id="productName-2" style="width: 150px;"
                                                                     placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-center">
                                            <div class="mb-2"><input class="form-control bg-light border-0" type="text"
                                                                     id="productName-2" style="width: 150px;"
                                                                     placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-center">
                                            <div class="mb-2"><input class="form-control bg-light border-0" type="text"
                                                                     id="productName-2" style="width: 150px;"
                                                                     placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-center">
                                            <div class="mb-2"><input class="form-control bg-light border-0" type="text"
                                                                     id="productName-2" style="width: 150px;"
                                                                     placeholder="Catons Qty"></div>
                                        </td>
                                    </tr>
                                    <tr id="1" class="product">
                                        <td class="d-none" colspan="5"><p>Add New Form</p></td>
                                        <td scope="row" class="product-id align-middle" style="">1
                                        </td>
                                        <td scope="row" class="product-id align-middle">Item Name</td>
                                        <td scope="row" class="product-id align-middle">SKU223892</td>
                                        <td scope="row" class="product-id align-middle">100</td>
                                        <td class="product-id align-middle">
                                            <div class="hstack gap-3">
                                                <a href="javascript:void(0);" class="link-success fs-15"><i
                                                        class="ri-edit-2-line fs-24"></i></a>
                                                <a href="javascript:void(0);" class="link-danger fs-15"><i
                                                        class="ri-save-line fs-24"></i></a>
                                            </div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0" type="text"
                                                                     style="width: 150px;" id="productName-2"
                                                                     placeholder="Catons Qty"></div>
                                        </td>
                                        <td><input class="form-control bg-light border-0 product-price"
                                                   style="width: 150px;" type="number" id="productRate-2" step="0.01"
                                                   placeholder="Qty Each"></td>
                                        <td><input class="form-control bg-light border-0 product-price"
                                                   style="width: 150px;" type="number" id="productRate-2" step="0.01"
                                                   placeholder="Exception Qty"></td>
                                        <td class="product-removal"><a class="btn btn-success">Upload Photo</a></td>
                                        <td class="text-start" style="width: 150px;">
                                            <div class="mb-2"><input class="form-control bg-light border-0"
                                                                     style="width: 150px;" type="text"
                                                                     id="productName-2" placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0"
                                                                     style="width: 150px;" type="text"
                                                                     id="productName-2" placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0"
                                                                     style="width: 150px;" type="text"
                                                                     id="productName-2" placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0"
                                                                     style="width: 150px;" type="text"
                                                                     id="productName-2" placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0" type="text"
                                                                     id="productName-2" style="width: 150px;"
                                                                     placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0"
                                                                     style="width: 150px;" type="text"
                                                                     id="productName-2" placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="product-removal"><a class="btn btn-success">Upload Photo</a></td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0" type="text"
                                                                     id="productName-2" style="width: 150px;"
                                                                     placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0"
                                                                     style="width: 150px;" type="text"
                                                                     id="productName-2" placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0" type="text"
                                                                     style="width: 150px;" id="productName-2"
                                                                     placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0" type="text"
                                                                     id="productName-2" style="width: 150px;"
                                                                     placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0"
                                                                     style="width: 150px;" type="text"
                                                                     id="productName-2" placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-center">
                                            <div class="mb-2"><input class="form-control bg-light border-0" type="text"
                                                                     id="productName-2" style="width: 150px;"
                                                                     placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-center">
                                            <div class="mb-2"><input class="form-control bg-light border-0" type="text"
                                                                     id="productName-2" style="width: 150px;"
                                                                     placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-center">
                                            <div class="mb-2"><input class="form-control bg-light border-0" type="text"
                                                                     id="productName-2" style="width: 150px;"
                                                                     placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-center">
                                            <div class="mb-2"><input class="form-control bg-light border-0" type="text"
                                                                     id="productName-2" style="width: 150px;"
                                                                     placeholder="Catons Qty"></div>
                                        </td>
                                    </tr>
                                    <tr id="1" class="product">
                                        <td class="d-none" colspan="5"><p>Add New Form</p></td>
                                        <td scope="row" class="product-id align-middle" style="">1
                                        </td>
                                        <td scope="row" class="product-id align-middle">Item Name</td>
                                        <td scope="row" class="product-id align-middle">SKU223892</td>
                                        <td scope="row" class="product-id align-middle">100</td>
                                        <td class="product-id align-middle">
                                            <div class="hstack gap-3">
                                                <a href="javascript:void(0);" class="link-success fs-15"><i
                                                        class="ri-edit-2-line fs-24"></i></a>
                                                <a href="javascript:void(0);" class="link-danger fs-15"><i
                                                        class="ri-save-line fs-24"></i></a>
                                            </div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0" type="text"
                                                                     style="width: 150px;" id="productName-2"
                                                                     placeholder="Catons Qty"></div>
                                        </td>
                                        <td><input class="form-control bg-light border-0 product-price"
                                                   style="width: 150px;" type="number" id="productRate-2" step="0.01"
                                                   placeholder="Qty Each"></td>
                                        <td><input class="form-control bg-light border-0 product-price"
                                                   style="width: 150px;" type="number" id="productRate-2" step="0.01"
                                                   placeholder="Exception Qty"></td>
                                        <td class="product-removal"><a class="btn btn-success">Upload Photo</a></td>
                                        <td class="text-start" style="width: 150px;">
                                            <div class="mb-2"><input class="form-control bg-light border-0"
                                                                     style="width: 150px;" type="text"
                                                                     id="productName-2" placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0"
                                                                     style="width: 150px;" type="text"
                                                                     id="productName-2" placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0"
                                                                     style="width: 150px;" type="text"
                                                                     id="productName-2" placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0"
                                                                     style="width: 150px;" type="text"
                                                                     id="productName-2" placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0" type="text"
                                                                     id="productName-2" style="width: 150px;"
                                                                     placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0"
                                                                     style="width: 150px;" type="text"
                                                                     id="productName-2" placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="product-removal"><a class="btn btn-success">Upload Photo</a></td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0" type="text"
                                                                     id="productName-2" style="width: 150px;"
                                                                     placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0"
                                                                     style="width: 150px;" type="text"
                                                                     id="productName-2" placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0" type="text"
                                                                     style="width: 150px;" id="productName-2"
                                                                     placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0" type="text"
                                                                     id="productName-2" style="width: 150px;"
                                                                     placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0"
                                                                     style="width: 150px;" type="text"
                                                                     id="productName-2" placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-center">
                                            <div class="mb-2"><input class="form-control bg-light border-0" type="text"
                                                                     id="productName-2" style="width: 150px;"
                                                                     placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-center">
                                            <div class="mb-2"><input class="form-control bg-light border-0" type="text"
                                                                     id="productName-2" style="width: 150px;"
                                                                     placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-center">
                                            <div class="mb-2"><input class="form-control bg-light border-0" type="text"
                                                                     id="productName-2" style="width: 150px;"
                                                                     placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-center">
                                            <div class="mb-2"><input class="form-control bg-light border-0" type="text"
                                                                     id="productName-2" style="width: 150px;"
                                                                     placeholder="Catons Qty"></div>
                                        </td>
                                    </tr>
                                    <tr id="1" class="product">
                                        <td class="d-none" colspan="5"><p>Add New Form</p></td>
                                        <td scope="row" class="product-id align-middle" style="">1
                                        </td>
                                        <td scope="row" class="product-id align-middle">Item Name</td>
                                        <td scope="row" class="product-id align-middle">SKU223892</td>
                                        <td scope="row" class="product-id align-middle">100</td>
                                        <td class="product-id align-middle">
                                            <div class="hstack gap-3">
                                                <a href="javascript:void(0);" class="link-success fs-15"><i
                                                        class="ri-edit-2-line fs-24"></i></a>
                                                <a href="javascript:void(0);" class="link-danger fs-15"><i
                                                        class="ri-save-line fs-24"></i></a>
                                            </div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0" type="text"
                                                                     style="width: 150px;" id="productName-2"
                                                                     placeholder="Catons Qty"></div>
                                        </td>
                                        <td><input class="form-control bg-light border-0 product-price"
                                                   style="width: 150px;" type="number" id="productRate-2" step="0.01"
                                                   placeholder="Qty Each"></td>
                                        <td><input class="form-control bg-light border-0 product-price"
                                                   style="width: 150px;" type="number" id="productRate-2" step="0.01"
                                                   placeholder="Exception Qty"></td>
                                        <td class="product-removal"><a class="btn btn-success">Upload Photo</a></td>
                                        <td class="text-start" style="width: 150px;">
                                            <div class="mb-2"><input class="form-control bg-light border-0"
                                                                     style="width: 150px;" type="text"
                                                                     id="productName-2" placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0"
                                                                     style="width: 150px;" type="text"
                                                                     id="productName-2" placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0"
                                                                     style="width: 150px;" type="text"
                                                                     id="productName-2" placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0"
                                                                     style="width: 150px;" type="text"
                                                                     id="productName-2" placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0" type="text"
                                                                     id="productName-2" style="width: 150px;"
                                                                     placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0"
                                                                     style="width: 150px;" type="text"
                                                                     id="productName-2" placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="product-removal"><a class="btn btn-success">Upload Photo</a></td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0" type="text"
                                                                     id="productName-2" style="width: 150px;"
                                                                     placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0"
                                                                     style="width: 150px;" type="text"
                                                                     id="productName-2" placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0" type="text"
                                                                     style="width: 150px;" id="productName-2"
                                                                     placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0" type="text"
                                                                     id="productName-2" style="width: 150px;"
                                                                     placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0"
                                                                     style="width: 150px;" type="text"
                                                                     id="productName-2" placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-center">
                                            <div class="mb-2"><input class="form-control bg-light border-0" type="text"
                                                                     id="productName-2" style="width: 150px;"
                                                                     placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-center">
                                            <div class="mb-2"><input class="form-control bg-light border-0" type="text"
                                                                     id="productName-2" style="width: 150px;"
                                                                     placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-center">
                                            <div class="mb-2"><input class="form-control bg-light border-0" type="text"
                                                                     id="productName-2" style="width: 150px;"
                                                                     placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-center">
                                            <div class="mb-2"><input class="form-control bg-light border-0" type="text"
                                                                     id="productName-2" style="width: 150px;"
                                                                     placeholder="Catons Qty"></div>
                                        </td>
                                    </tr>
                                    <tr id="1" class="product">
                                        <td class="d-none" colspan="5"><p>Add New Form</p></td>
                                        <td scope="row" class="product-id align-middle" style="">1
                                        </td>
                                        <td scope="row" class="product-id align-middle">Item Name</td>
                                        <td scope="row" class="product-id align-middle">SKU223892</td>
                                        <td scope="row" class="product-id align-middle">100</td>
                                        <td class="product-id align-middle">
                                            <div class="hstack gap-3">
                                                <a href="javascript:void(0);" class="link-success fs-15"><i
                                                        class="ri-edit-2-line fs-24"></i></a>
                                                <a href="javascript:void(0);" class="link-danger fs-15"><i
                                                        class="ri-save-line fs-24"></i></a>
                                            </div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0" type="text"
                                                                     style="width: 150px;" id="productName-2"
                                                                     placeholder="Catons Qty"></div>
                                        </td>
                                        <td><input class="form-control bg-light border-0 product-price"
                                                   style="width: 150px;" type="number" id="productRate-2" step="0.01"
                                                   placeholder="Qty Each"></td>
                                        <td><input class="form-control bg-light border-0 product-price"
                                                   style="width: 150px;" type="number" id="productRate-2" step="0.01"
                                                   placeholder="Exception Qty"></td>
                                        <td class="product-removal"><a class="btn btn-success">Upload Photo</a></td>
                                        <td class="text-start" style="width: 150px;">
                                            <div class="mb-2"><input class="form-control bg-light border-0"
                                                                     style="width: 150px;" type="text"
                                                                     id="productName-2" placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0"
                                                                     style="width: 150px;" type="text"
                                                                     id="productName-2" placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0"
                                                                     style="width: 150px;" type="text"
                                                                     id="productName-2" placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0"
                                                                     style="width: 150px;" type="text"
                                                                     id="productName-2" placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0" type="text"
                                                                     id="productName-2" style="width: 150px;"
                                                                     placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0"
                                                                     style="width: 150px;" type="text"
                                                                     id="productName-2" placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="product-removal"><a class="btn btn-success">Upload Photo</a></td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0" type="text"
                                                                     id="productName-2" style="width: 150px;"
                                                                     placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0"
                                                                     style="width: 150px;" type="text"
                                                                     id="productName-2" placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0" type="text"
                                                                     style="width: 150px;" id="productName-2"
                                                                     placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0" type="text"
                                                                     id="productName-2" style="width: 150px;"
                                                                     placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0"
                                                                     style="width: 150px;" type="text"
                                                                     id="productName-2" placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-center">
                                            <div class="mb-2"><input class="form-control bg-light border-0" type="text"
                                                                     id="productName-2" style="width: 150px;"
                                                                     placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-center">
                                            <div class="mb-2"><input class="form-control bg-light border-0" type="text"
                                                                     id="productName-2" style="width: 150px;"
                                                                     placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-center">
                                            <div class="mb-2"><input class="form-control bg-light border-0" type="text"
                                                                     id="productName-2" style="width: 150px;"
                                                                     placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-center">
                                            <div class="mb-2"><input class="form-control bg-light border-0" type="text"
                                                                     id="productName-2" style="width: 150px;"
                                                                     placeholder="Catons Qty"></div>
                                        </td>
                                    </tr>
                                    <tr id="1" class="product">
                                        <td class="d-none" colspan="5"><p>Add New Form</p></td>
                                        <td scope="row" class="product-id align-middle" style="">1
                                        </td>
                                        <td scope="row" class="product-id align-middle">Item Name</td>
                                        <td scope="row" class="product-id align-middle">SKU223892</td>
                                        <td scope="row" class="product-id align-middle">100</td>
                                        <td class="product-id align-middle">
                                            <div class="hstack gap-3">
                                                <a href="javascript:void(0);" class="link-success fs-15"><i
                                                        class="ri-edit-2-line fs-24"></i></a>
                                                <a href="javascript:void(0);" class="link-danger fs-15"><i
                                                        class="ri-save-line fs-24"></i></a>
                                            </div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0" type="text"
                                                                     style="width: 150px;" id="productName-2"
                                                                     placeholder="Catons Qty"></div>
                                        </td>
                                        <td><input class="form-control bg-light border-0 product-price"
                                                   style="width: 150px;" type="number" id="productRate-2" step="0.01"
                                                   placeholder="Qty Each"></td>
                                        <td><input class="form-control bg-light border-0 product-price"
                                                   style="width: 150px;" type="number" id="productRate-2" step="0.01"
                                                   placeholder="Exception Qty"></td>
                                        <td class="product-removal"><a class="btn btn-success">Upload Photo</a></td>
                                        <td class="text-start" style="width: 150px;">
                                            <div class="mb-2"><input class="form-control bg-light border-0"
                                                                     style="width: 150px;" type="text"
                                                                     id="productName-2" placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0"
                                                                     style="width: 150px;" type="text"
                                                                     id="productName-2" placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0"
                                                                     style="width: 150px;" type="text"
                                                                     id="productName-2" placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0"
                                                                     style="width: 150px;" type="text"
                                                                     id="productName-2" placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0" type="text"
                                                                     id="productName-2" style="width: 150px;"
                                                                     placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0"
                                                                     style="width: 150px;" type="text"
                                                                     id="productName-2" placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="product-removal"><a class="btn btn-success">Upload Photo</a></td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0" type="text"
                                                                     id="productName-2" style="width: 150px;"
                                                                     placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0"
                                                                     style="width: 150px;" type="text"
                                                                     id="productName-2" placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0" type="text"
                                                                     style="width: 150px;" id="productName-2"
                                                                     placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0" type="text"
                                                                     id="productName-2" style="width: 150px;"
                                                                     placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0"
                                                                     style="width: 150px;" type="text"
                                                                     id="productName-2" placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-center">
                                            <div class="mb-2"><input class="form-control bg-light border-0" type="text"
                                                                     id="productName-2" style="width: 150px;"
                                                                     placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-center">
                                            <div class="mb-2"><input class="form-control bg-light border-0" type="text"
                                                                     id="productName-2" style="width: 150px;"
                                                                     placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-center">
                                            <div class="mb-2"><input class="form-control bg-light border-0" type="text"
                                                                     id="productName-2" style="width: 150px;"
                                                                     placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-center">
                                            <div class="mb-2"><input class="form-control bg-light border-0" type="text"
                                                                     id="productName-2" style="width: 150px;"
                                                                     placeholder="Catons Qty"></div>
                                        </td>
                                    </tr>
                                    <tr id="1" class="product">
                                        <td class="d-none" colspan="5"><p>Add New Form</p></td>
                                        <td scope="row" class="product-id align-middle" style="">1
                                        </td>
                                        <td scope="row" class="product-id align-middle">Item Name</td>
                                        <td scope="row" class="product-id align-middle">SKU223892</td>
                                        <td scope="row" class="product-id align-middle">100</td>
                                        <td class="product-id align-middle">
                                            <div class="hstack gap-3">
                                                <a href="javascript:void(0);" class="link-success fs-15"><i
                                                        class="ri-edit-2-line fs-24"></i></a>
                                                <a href="javascript:void(0);" class="link-danger fs-15"><i
                                                        class="ri-save-line fs-24"></i></a>
                                            </div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0" type="text"
                                                                     style="width: 150px;" id="productName-2"
                                                                     placeholder="Catons Qty"></div>
                                        </td>
                                        <td><input class="form-control bg-light border-0 product-price"
                                                   style="width: 150px;" type="number" id="productRate-2" step="0.01"
                                                   placeholder="Qty Each"></td>
                                        <td><input class="form-control bg-light border-0 product-price"
                                                   style="width: 150px;" type="number" id="productRate-2" step="0.01"
                                                   placeholder="Exception Qty"></td>
                                        <td class="product-removal"><a class="btn btn-success">Upload Photo</a></td>
                                        <td class="text-start" style="width: 150px;">
                                            <div class="mb-2"><input class="form-control bg-light border-0"
                                                                     style="width: 150px;" type="text"
                                                                     id="productName-2" placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0"
                                                                     style="width: 150px;" type="text"
                                                                     id="productName-2" placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0"
                                                                     style="width: 150px;" type="text"
                                                                     id="productName-2" placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0"
                                                                     style="width: 150px;" type="text"
                                                                     id="productName-2" placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0" type="text"
                                                                     id="productName-2" style="width: 150px;"
                                                                     placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0"
                                                                     style="width: 150px;" type="text"
                                                                     id="productName-2" placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="product-removal"><a class="btn btn-success">Upload Photo</a></td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0" type="text"
                                                                     id="productName-2" style="width: 150px;"
                                                                     placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0"
                                                                     style="width: 150px;" type="text"
                                                                     id="productName-2" placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0" type="text"
                                                                     style="width: 150px;" id="productName-2"
                                                                     placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0" type="text"
                                                                     id="productName-2" style="width: 150px;"
                                                                     placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0"
                                                                     style="width: 150px;" type="text"
                                                                     id="productName-2" placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-center">
                                            <div class="mb-2"><input class="form-control bg-light border-0" type="text"
                                                                     id="productName-2" style="width: 150px;"
                                                                     placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-center">
                                            <div class="mb-2"><input class="form-control bg-light border-0" type="text"
                                                                     id="productName-2" style="width: 150px;"
                                                                     placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-center">
                                            <div class="mb-2"><input class="form-control bg-light border-0" type="text"
                                                                     id="productName-2" style="width: 150px;"
                                                                     placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-center">
                                            <div class="mb-2"><input class="form-control bg-light border-0" type="text"
                                                                     id="productName-2" style="width: 150px;"
                                                                     placeholder="Catons Qty"></div>
                                        </td>
                                    </tr>
                                    <tr id="1" class="product">
                                        <td class="d-none" colspan="5"><p>Add New Form</p></td>
                                        <td scope="row" class="product-id align-middle" style="">1
                                        </td>
                                        <td scope="row" class="product-id align-middle">Item Name</td>
                                        <td scope="row" class="product-id align-middle">SKU223892</td>
                                        <td scope="row" class="product-id align-middle">100</td>
                                        <td class="product-id align-middle">
                                            <div class="hstack gap-3">
                                                <a href="javascript:void(0);" class="link-success fs-15"><i
                                                        class="ri-edit-2-line fs-24"></i></a>
                                                <a href="javascript:void(0);" class="link-danger fs-15"><i
                                                        class="ri-save-line fs-24"></i></a>
                                            </div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0" type="text"
                                                                     style="width: 150px;" id="productName-2"
                                                                     placeholder="Catons Qty"></div>
                                        </td>
                                        <td><input class="form-control bg-light border-0 product-price"
                                                   style="width: 150px;" type="number" id="productRate-2" step="0.01"
                                                   placeholder="Qty Each"></td>
                                        <td><input class="form-control bg-light border-0 product-price"
                                                   style="width: 150px;" type="number" id="productRate-2" step="0.01"
                                                   placeholder="Exception Qty"></td>
                                        <td class="product-removal"><a class="btn btn-success">Upload Photo</a></td>
                                        <td class="text-start" style="width: 150px;">
                                            <div class="mb-2"><input class="form-control bg-light border-0"
                                                                     style="width: 150px;" type="text"
                                                                     id="productName-2" placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0"
                                                                     style="width: 150px;" type="text"
                                                                     id="productName-2" placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0"
                                                                     style="width: 150px;" type="text"
                                                                     id="productName-2" placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0"
                                                                     style="width: 150px;" type="text"
                                                                     id="productName-2" placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0" type="text"
                                                                     id="productName-2" style="width: 150px;"
                                                                     placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0"
                                                                     style="width: 150px;" type="text"
                                                                     id="productName-2" placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="product-removal"><a class="btn btn-success">Upload Photo</a></td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0" type="text"
                                                                     id="productName-2" style="width: 150px;"
                                                                     placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0"
                                                                     style="width: 150px;" type="text"
                                                                     id="productName-2" placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0" type="text"
                                                                     style="width: 150px;" id="productName-2"
                                                                     placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0" type="text"
                                                                     id="productName-2" style="width: 150px;"
                                                                     placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-start">
                                            <div class="mb-2"><input class="form-control bg-light border-0"
                                                                     style="width: 150px;" type="text"
                                                                     id="productName-2" placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-center">
                                            <div class="mb-2"><input class="form-control bg-light border-0" type="text"
                                                                     id="productName-2" style="width: 150px;"
                                                                     placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-center">
                                            <div class="mb-2"><input class="form-control bg-light border-0" type="text"
                                                                     id="productName-2" style="width: 150px;"
                                                                     placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-center">
                                            <div class="mb-2"><input class="form-control bg-light border-0" type="text"
                                                                     id="productName-2" style="width: 150px;"
                                                                     placeholder="Catons Qty"></div>
                                        </td>
                                        <td class="text-center">
                                            <div class="mb-2"><input class="form-control bg-light border-0" type="text"
                                                                     id="productName-2" style="width: 150px;"
                                                                     placeholder="Catons Qty"></div>
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
    <!--end row-->
    {{--    @include('admin.checkin.checkin-modals')--}}
    {{--    @include('admin.components.comon-modals.common-modal')--}}

@endsection
@section('script')
    <script src="{{ URL::asset('build/js/custom-js/offloading/offloading.js') }}"></script>
    <script>


    </script>

@endsection
