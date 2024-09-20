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

        <input type="hidden" name="isStartPicking" value="{{$data['orderInfo']->start_time!=null?1:0}}">

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex ">
                        <div class="col">
                            <h4 class="card-title mb-0">Picking Q/C  Detail</h4>

                        </div>
                        <div class="col-auto justify-content-sm-end">
                            @if($data['orderInfo']->end_time==NULL)
                            <button type="button" class="btn btn-success btn-close-qc me-2 d-none"><i class="ri-eye-line align-bottom me-1"></i> Close Q/C</button>
                            @endif


                            <button type="button" class="btn btn-success btn-start-qc d-none" updateType="1" ><i class="ri-add-line align-bottom me-1"></i> Start  Q/C Now</button>

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
                                        <input type="text" class="form-control" id="labelInput" value="{{$data['orderInfo']->workOrder->client->title}}" disabled="">
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
                            <form action="{{route('admin.update.qc')}}" method="post" enctype="multipart/form-data" id="CloseQCForm">
                                @csrf


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
                                        <th scope="col" style="">Picked Qty</th>
                                        <th scope="col" style="">Q/C Qty</th>

                                        <th scope="col" class="text-start" style="width: 105px;">Image</th>
                                        <th scope="col" class="text-end" style="width: 105px;">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody id="qcTable">
                                    <form action="{{route('admin.update.qc')}}" method="post" enctype="multipart/form-data" id="CloseQcForm">
                                        <input type="hidden" name="work_order_id" value="{{$data['orderInfo']->work_order_id}}">
                                        <input type="hidden" name="qc_id" value="{{$data['orderInfo']->id }}">
                                        <input type="hidden" name="status_code" value="22">
                                        <input type="hidden" name="updateType" value="2">

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
                                                    <th scope="row" class="product-id align-middle">{{$row->picked_qty}}</th>


                                                    <td>
                                                        <input class="form-control bg-light border-0 qcQty" name="qcQty[]" type="number" placeholder="Qty" value="{{isset($row->picked_qty)?$row->picked_qty:0}}" required>
                                                    </td>




                                                    <td class="text-start" style="width: 150px;">
                                                        <div class="mb-2">
                                                            <input class="form-control bg-light border-0" style="width: 170px;" type="file" name="pickedItemImages[{{$key}}][]" placeholder="Damage" multiple accept="image/*">
                                                        </div>
                                                        @isset($row->media)
                                                            <div class="d-flex flex-grow-1 gap-2 mt-2 preview-container sealImagesPreview">
                                                                @foreach($row->media as $image)
                                                                    @if($image->field_name == 'qcItemImages')
                                                                        <i class="ri ri-close-fill text-danger fs-2 cursor-pointer btn-delete-file" data="{{$image->id}}" data-bs-toggle="modal" data-bs-target="#deleteRecordModal"></i>
                                                                        <div class="preview">
                                                                            <img src="{{asset('storage/uploads/'.$image->file_name)}}" alt="Image Preview" class="avatar-sm rounded object-fit-cover">
                                                                        </div>


                                                                    @endif
                                                                @endforeach
                                                            </div>
                                                        @endisset
                                                    </td>
                                                    <td class="text-end  cursor-pointer text-success btn-save-row" title="Save" data="{{$row->id}}"><i class="ri-save-2-fill fs-1"></i></td>
                                                </tr>


                                            @endforeach
                                        @endisset

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
    @include('admin.components.comon-modals.common-modal')
@endsection
    @section('script')
    <script src="{{ URL::asset('build/js/custom-js/qc/qc.js') }}"></script>
    @endsection


