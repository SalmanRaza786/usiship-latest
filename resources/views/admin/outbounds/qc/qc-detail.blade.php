@extends('layouts.master')
@section('title') Picking Q/C Detail @endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Dashboard @endslot
        @slot('routeUrl') {{url('/')}} @endslot
        @slot('title') Picking Q/C Detail - {{$data['orderInfo']->workOrder->order_reference}} @endslot
    @endcomponent
    @include('components.common-error')
    <div class="container-fluid">

        <input type="hidden" name="missedId" value="{{$data['orderInfo']->id}}">
        <input type="hidden" name="isStartPicking" value="{{$data['orderInfo']->start_time!=null?1:0}}">

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex ">
                        <div class="col">
                            <h4 class="card-title mb-0">Picking Q/C  Detail</h4>

                        </div>
                        <div class="col-auto justify-content-sm-end">

{{--                            <button type="button" class="btn btn-warning add-btn me-2"><i class="ri-eye-line align-bottom me-1"></i> Report Missing</button>--}}
                            <button type="button" class="btn btn-success btn-close-resolve me-2"><i class="ri-eye-line align-bottom me-1"></i> Close Q/C</button>


                            <button type="submit" class="btn btn-success btn-start-resolve" updateType="1" ><i class="ri-add-line align-bottom me-1"></i> Start  Q/C Now</button>

                        </div>

                    </div>

                    <div class="card-body">


                        <div class="live-preview">
                            <div class="row gy-4">
                                <div class="col-xxl-3 col-md-6">
                                    <div>
                                        <label for="basiInput" class="form-label">Order Reference #</label>
                                        <input type="text" class="form-control" id="basiInput" value="{{$data['orderInfo']->workOrder->order_reference}}" disabled="">
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-xxl-3 col-md-6">
                                    <div>
                                        <label for="labelInput" class="form-label">Customer Name</label>
                                        <input type="text" class="form-control" id="labelInput" value="{{$data['orderInfo']->workOrder->client->name}}" disabled="">
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-xxl-3 col-md-6">
                                    <div>
                                        <label for="placeholderInput" class="form-label">Picking Start Date/Time</label>
                                        <input type="text" class="form-control" name="start_pick_time" value="{{$data['orderInfo']->start_time}}" disabled="">
                                    </div>
                                </div>
                                <div class="col-xxl-3 col-md-6">
                                    <div>
                                        <label for="valueInput" class="form-label">Load Type</label>
                                        <input type="text" class="form-control" id="valueInput" value="{{$data['orderInfo']->workOrder->loadType->eqType->value}}" disabled="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row d-none pick-item-section">
            @php
            $key=0;
            @endphp
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="live-preview">
                            <form action="{{route('admin.save.qc')}}" method="post" enctype="multipart/form-data" id="CloseQCForm">
                                @csrf
                                <input type="hidden" name="w_order_id" value="{{$data['orderInfo']->workOrder->id}}">
                                <input type="hidden" name="staff_id" value="{{$data['orderInfo']->orderPicker->picker_id}}">
                                <input type="hidden" name="qc_id" value="{{$data['orderInfo']->id }}">
                                <input type="hidden" name="status_code" value="205">


                                <table class="invoice-table table table-borderless table-nowrap mb-0">
                                    <thead class="align-middle">
                                    <tr class="table-active">
                                        <th scope="col" style="width: 50px;">#</th>
                                        <th scope="col">
                                            Product SKU
                                        </th>
                                        <th scope="col" style="">
                                            <div class="d-flex currency-select input-light align-items-center">Order Qty
                                            </div>
                                        </th>
                                        <th scope="col" style="">Pallet Number</th>
                                        <th scope="col" style="">Pick From</th>
                                        <th scope="col" style="">Q/C Qty
                                        </th>
                                        <th scope="col" class="text-end" style="width: 105px;"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <form action="{{route('admin.save-picked.items')}}" method="post" enctype="multipart/form-data" id="ClosePickingForm">
                                        <input type="hidden" name="work_order_id" value="{{$data['orderInfo']->work_order_id}}">

                                        @csrf
                                        @isset($data['qcItems'])
                                            @foreach($data['qcItems'] as $key=>$row)
                                                <input type="hidden" name="hidden_id[]" value="{{$row->id}}">

                                                <tr>
                                                    <th scope="row" class="product-id align-middle">{{$key + 1}}</th>
                                                    <th scope="row" class="product-id align-middle">{{$row->workOrderItem->inventory->item_name}} - {{$row->workOrderItem->inventory->sku}}</th>
                                                    <th scope="row" class="product-id align-middle">{{$row->workOrderItem->qty}}</th>
                                                    <th scope="row" class="product-id align-middle">{{$row->workOrderItem->pallet_number}}</th>
                                                    <th scope="row" class="product-id align-middle">{{$row->workOrderItem->location->loc_title}}</th>


                                                    <td>
                                                        <input class="form-control bg-light border-0" name="qcQty[]" type="number" placeholder="Qty" value="0" required>
                                                    </td>



                                                    <td class="text-start" style="width: 150px;">
                                                        <div class="mb-2">
                                                            <input class="form-control bg-light border-0" style="width: 170px;" type="file" name="qcItemImages[{{$key}}][]" placeholder="Damage" multiple accept="image/*">
                                                        </div>

                                                    </td>
                                                </tr>


                                            @endforeach
                                        @endisset

                                        <button type="submit">Save</button>
                                    </form>

                                    </tbody>

                                </table>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
    @section('script')
    <script src="{{ URL::asset('build/js/custom-js/missedItems/missedItems.js') }}"></script>
    @endsection


