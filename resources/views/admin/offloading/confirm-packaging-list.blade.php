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
    @isset($data)
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
                                        <input type="text" class="form-control" id="basiInput" value="{{$data->checkin->container_no ?? "-"}}"
                                               disabled="">
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-xxl-3 col-md-6">
                                    <div>
                                        <label for="labelInput" class="form-label">Staged Location</label>
                                        <input type="text" class="form-control" id="labelInput" value="{{$data->p_staged_location ?? "-"}}" disabled="">
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-xxl-3 col-md-6">
                                    <div>
                                        <label for="placeholderInput" class="form-label">Off Loading Start Date/Time</label>
                                        <input type="text" class="form-control" id="placeholderInput"
                                               value="{{$data->start_time ?? "-"}}" disabled="">
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-xxl-3 col-md-6">
                                    <div>
                                        <label for="valueInput" class="form-label">Load Type</label>
                                        <input type="text" class="form-control" id="valueInput" value="{{$data->order->dock->loadType->eqType->value ?? "-"}}" disabled="">
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
    @isset($data->order->packgingList)
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
                                        <th scope="col" class="text-center">Length</th>
                                        <th scope="col" class="text-center">Width</th>
                                        <th scope="col" class="text-center">Height</th>
                                        <th scope="col" class="text-center">Weight</th>
                                        <th scope="col" class="text-center">Custom Field 1</th>
                                        <th scope="col" class="text-center">Custom Field 2</th>
                                        <th scope="col" class="text-center">Custom Field 3</th>
                                        <th scope="col" class="text-center">Custom Field 4</th>
                                    </tr>
                                    </thead>
                                    <tbody id="newlink">

                                    @isset($data->order->packgingList)
                                        @foreach($data->order->packgingList as $key => $list)

                                            <tr id="row-{{ $key }}" class="product">
                                                <td class="product-id align-middle">{{$key + 1}}</td>
                                                <td class="product-id align-middle">{{$list->inventory->item_name ?? "-"}}</td>
                                                <td class="product-id align-middle">{{$list->inventory->sku ?? "-"}}</td>
                                                <td class="product-id align-middle">{{$list->qty ?? "-"}}</td>
                                                <td class="product-id align-middle">
                                                    <div class="hstack gap-3">
                                                        <a href="javascript:void(0);" data-row-id="{{ $key }}" class="link-success fs-15 edit-row"><i class="ri-edit-2-line fs-24"></i></a>
                                                        <a href="javascript:void(0);" data-row-id="{{ $key }}" data-id ="{{$list->id}}" class="link-danger fs-15 save-row" style="display:none;"><i class="ri-save-line fs-24"></i></a>
                                                    </div>
                                                </td>
                                                <td class="text-start">
                                                    <div class="mb-2"><input class="form-control bg-light border-0" type="text" style="width: 150px;" name="cartons_qty"  placeholder="Cartons Qty" disabled></div>
                                                </td>
                                                <td><input class="form-control bg-light border-0 product-price" style="width: 150px;" type="number" name="received_each" step="0.01"   placeholder="Qty Each" disabled></td>
                                                <td><input class="form-control bg-light border-0 product-price" style="width: 150px;" type="number" name="exception_qty" step="0.01" placeholder="Exception Qty" disabled></td>
                                                <td class="text-start" style="width: 150px;">
                                                    <div class="mb-2"><input class="form-control bg-light border-0" style="width: 170px;" type="file" name="damage[]" placeholder="Damage" multiple accept="image/*" disabled></div>
                                                </td>
                                                <td class="text-start" style="width: 150px;">
                                                    <div class="mb-2"><input class="form-control bg-light border-0" style="width: 150px;" type="text"  name="ti" placeholder="TI" disabled></div>
                                                </td>
                                                <td class="text-start">
                                                    <div class="mb-2"><input class="form-control bg-light border-0" style="width: 150px;" type="text"  name="hi" placeholder="HI" disabled></div>
                                                </td>
                                                <td class="text-start">
                                                    <div class="mb-2"><input class="form-control bg-light border-0" style="width: 150px;" type="number" name="total_pallets" placeholder="Total Pallets" disabled></div>
                                                </td>
                                                <td class="text-start">
                                                    <div class="mb-2"><input class="form-control bg-light border-0" style="width: 150px;" type="text" name="lot_3" placeholder="Lot 3" disabled></div>
                                                </td>
                                                <td class="text-start">
                                                    <div class="mb-2"><input class="form-control bg-light border-0" style="width: 150px;" type="text" name="serial_number" placeholder="Serial #" disabled></div>
                                                </td>
                                                <td class="text-start">
                                                    <div class="mb-2"><input class="form-control bg-light border-0" style="width: 150px;" type="text" name="upc_label" placeholder="UPC Label" disabled></div>
                                                </td>
                                                <td class="text-start" style="width: 150px;">
                                                    <div class="mb-2"><input class="form-control bg-light border-0" style="width: 170px;" type="file" name="upc_label_photo[]" placeholder="UPC Label Photo" multiple accept="image/*" disabled></div>
                                                </td>
                                                <td class="text-start">
                                                    <div class="mb-2"><input class="form-control bg-light border-0" style="width: 150px;" type="date" name="expiry_date" placeholder="Expiry Date" disabled></div>
                                                </td>
                                                <td class="text-start">
                                                    <div class="mb-2"><input class="form-control bg-light border-0" style="width: 150px;" type="number" step="0.01" name="length" placeholder="Length" disabled></div>
                                                </td>
                                                <td class="text-start">
                                                    <div class="mb-2"><input class="form-control bg-light border-0" style="width: 150px;" type="number" step="0.01" name="width" placeholder="Width" disabled></div>
                                                </td>
                                                <td class="text-start">
                                                    <div class="mb-2"><input class="form-control bg-light border-0" style="width: 150px;" type="number" step="0.01" name="height" placeholder="Height" disabled></div>
                                                </td>
                                                <td class="text-start">
                                                    <div class="mb-2"><input class="form-control bg-light border-0" style="width: 150px;" type="number" step="0.01" name="weight" placeholder="Weight" disabled></div>
                                                </td>
                                                <td class="text-start">
                                                    <div class="mb-2"><input class="form-control bg-light border-0" style="width: 150px;" type="text" name="custom_field_1" placeholder="Custom Field 1" disabled></div>
                                                </td>
                                                <td class="text-start">
                                                    <div class="mb-2"><input class="form-control bg-light border-0" style="width: 150px;" type="text" name="custom_field_2" placeholder="Custom Field 2" disabled></div>
                                                </td>
                                                <td class="text-start">
                                                    <div class="mb-2"><input class="form-control bg-light border-0" style="width: 150px;" type="text" name="custom_field_3" placeholder="Custom Field 3" disabled></div>
                                                </td>
                                                <td class="text-start">
                                                    <div class="mb-2"><input class="form-control bg-light border-0" style="width: 150px;" type="text" name="custom_field_4" placeholder="Custom Field 4" disabled></div>
                                                </td>
                                            </tr>



                                        @endforeach
                                    @endisset

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
    @endisset
    @endisset
    <!--end row-->
    {{--    @include('admin.checkin.checkin-modals')--}}
    {{--    @include('admin.components.comon-modals.common-modal')--}}

@endsection
@section('script')
    <script src="{{ URL::asset('build/js/custom-js/confirm-packging-list/confirm-packging-list.js') }}"></script>
    <script>


    </script>

@endsection
