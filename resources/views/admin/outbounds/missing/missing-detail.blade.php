@extends('layouts.master')
@section('title') Item Picking Detail @endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Dashboard @endslot
        @slot('routeUrl') {{url('/')}} @endslot
        @slot('title') Item Picking - {{$data['orderInfo']->workOrder->order_reference}} @endslot
    @endcomponent
    @include('components.common-error')
    <div class="container-fluid">

        <input type="hidden" name="pickerId" value="{{$data['orderInfo']->id}}">
        <input type="hidden" name="isStartPicking" value="{{$data['orderInfo']->start_time!=null?1:0}}">

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex ">
                        <div class="col">
                            <h4 class="card-title mb-0">Item Picking Detail</h4>

                        </div>
                        <div class="col-auto justify-content-sm-end">

                            <button type="button" class="btn btn-warning add-btn me-2"><i class="ri-eye-line align-bottom me-1"></i> Report Missing</button>
                            <button type="button" class="btn btn-success btn-close-picking me-2"><i class="ri-eye-line align-bottom me-1"></i> Close Picking</button>


                            <button type="submit" class="btn btn-success btn-start-picking" updateType="1" ><i class="ri-add-line align-bottom me-1"></i> Start Picking Now</button>

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
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="live-preview">
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
                                        <th scope="col" style="">Pick From</th>
                                        <th scope="col" style="">Missing Qty
                                        </th>
                                        <th scope="col" class="text-end" style="width: 150px;">Picked Location</th>
                                        <th scope="col" class="text-end" style="width: 105px;"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <form action="{{route('admin.save-picked.items')}}" method="post" enctype="multipart/form-data" id="ClosePickingForm">
                                        @csrf
                                    @isset($data['pickingItems'])
                                        @foreach($data['pickingItems'] as $key=>$row)
                                                <input type="hidden" name="hidden_id[]" value="{{$row->id}}">

                                        <tr>
                                        <th scope="row" class="product-id align-middle">{{$key + 1}}</th>
                                        <th scope="row" class="product-id align-middle">{{$row->inventory->item_name}} - {{$row->inventory->sku}}</th>
                                        <th scope="row" class="product-id align-middle">{{$row->order_qty}}</th>
                                        <th scope="row" class="product-id align-middle">{{$row->wOrderItems->pallet_number}}</th>
                                        <th scope="row" class="product-id align-middle">{{$row->location->loc_title}}</th>


                                        <td>
                                            <input class="form-control bg-light border-0" name="missedQty[]" type="number" placeholder="Qty" value="0">
                                        </td>
                                        <td class="text-end">
                                            <select name="pickedLocId[]" id="" class="form-select" required>
                                                <option value="">Choose One</option>
                                                @isset($data['pickingItems'])
                                                    @foreach($data['locations'] as $loc)
                                                        <option value="{{$loc->id}}">{{$loc->loc_title}}</option>
                                                    @endforeach
                                                @endisset
                                            </select>
                                        </td>



                                            <td class="text-start" style="width: 150px;">
                                                <div class="mb-2">
                                                    <input class="form-control bg-light border-0" style="width: 170px;" type="file" name="pickedItemImages[{{$key}}][]" placeholder="Damage" multiple accept="image/*">
                                                </div>
{{--                                                @isset($row->putAwayMedia)--}}
{{--                                                    <div class="d-flex flex-grow-1 gap-2 mt-2 preview-container sealImagesPreview" id="sealImagesPreview">--}}
{{--                                                        @foreach($row->putAwayMedia as $image)--}}
{{--                                                            @if($image->field_name == 'putawayImages')--}}
{{--                                                                <div class="preview">--}}
{{--                                                                    <img src="{{asset('storage/uploads/'.$image->file_name)}}" alt="Image Preview" class="avatar-sm rounded object-fit-cover">--}}
{{--                                                                </div>--}}
{{--                                                            @endif--}}
{{--                                                        @endforeach--}}
{{--                                                    </div>--}}
{{--                                                @endisset--}}
                                            </td>
                                    </tr>


                                        @endforeach
                                    @endisset
                                    </form>

                                    </tbody>

                                </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
    @section('script')
    <script src="{{ URL::asset('build/js/custom-js/pickingItems/pickingItems.js') }}"></script>
    @endsection


