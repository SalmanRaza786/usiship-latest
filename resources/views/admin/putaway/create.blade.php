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

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex ">
                    <div class="col">
                        <h4 class="card-title mb-0">Item Put Away Detail</h4>
                    </div>
                    <div class="col-auto justify-content-sm-end">
                        @canany('admin-putaway-create')
                        <button type="button" class="btn btn-info add-btn me-2 checkPutAwayStatus" id="savePutAwayStatus" ><i class="ri-eye-line align-bottom me-1"></i> Save Put Away Items</button>
                        <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal" id="checkPutAwayStatus" orderId="{{isset($data['offLoadingInfo'])?$data['offLoadingInfo']->order_id:''}}" data="{{isset($data['offLoadingInfo'])?$data['offLoadingInfo']->id:''}}" data-bs-target="#loadTypeModal" ><i class="ri-add-line align-bottom me-1"></i> Check Put Away Status</button>
                        @endcanany
                    </div>
                </div>
                <div class="card-body">
                    <div class="live-preview">
                        <div class="row gy-4">
                            <div class="col-xxl-3 col-md-6">
                                <div>
                                    <label for="basiInput" class="form-label">Container #</label>

                                    <input type="text" class="form-control" value="{{isset($data['offLoadingInfo']->orderCheckIn)?$data['offLoadingInfo']->orderCheckIn->container_no:''}}" disabled>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-3 col-md-6">
                                <div>
                                    <label for="labelInput" class="form-label">Staged Location</label>
                                    <input type="text" class="form-control" id="labelInput" value="{{isset($data['offLoadingInfo'])?$data['offLoadingInfo']->p_staged_location:''}}" disabled>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-3 col-md-6">
                                <div>
                                    <label for="placeholderInput" class="form-label">Arrival Date/Time</label>
                                    <input type="text" class="form-control" id="placeholderInput" value="{{isset($data['offLoadingInfo']->orderCheckIn)?$data['offLoadingInfo']->orderCheckIn->orderContact->arrival_time:''}}" disabled>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-3 col-md-6">
                                <div>
                                    <label for="valueInput" class="form-label">Load Type</label>
                                    <input type="text" class="form-control" id="valueInput" value="{{isset($data['offLoadingInfo']->order)?$data['offLoadingInfo']->order->loadType->transMode->value:''}}" disabled>
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

                        <form action="{{route('admin.put-away.store')}}" method="post" id="PutAwayForm" enctype="multipart/form-data">
                            @csrf
                            <input type="number" class="d-none" name="hidden_order_id" value="{{isset($data['offLoadingInfo'])?$data['offLoadingInfo']->order_id:''}}" placeholder="order_id">
                            <input type="number" class="d-none" name="order_off_loading_id" value="{{isset($data['offLoadingInfo'])?$data['offLoadingInfo']->id:''}}" placeholder="off_loading_id">
                        <table class="invoice-table table table-borderless table-nowrap mb-0">
                            <thead class="align-middle">
                            <tr class="table-active">
                                <th scope="col" style="width: 50px;">#</th>
                                <th scope="col">Product SKU</th>
                                <th scope="col">
                                    <div class="d-flex currency-select input-light align-items-center">Quantity</div>
                                </th>
                                <th>Pallet Number</th>
                                <th>Put Away Location</th>
                                <th>Photo</th>
                                <th>Action</th>
                            </tr>
                            </thead>


                            <tbody id="clonedSection">
                            @if($data['putAwayItems']->count() > 0)
                                @foreach($data['putAwayItems'] as $key=>$row)
                            <tr>
                                <th>{{$key+1}}</th>
                                <td class="text-start">
                                    <input type="number" class="d-none" name="putAwayId[]" value="{{$row->id}}">

                                        <select name="inventory_id[]" class="form-control"  data-choices required>
                                            <option value="">Choose SKU</option>
                                            @foreach($data['inventory'] as  $inventory)
                                                <option value="{{ $inventory->id }}"
                                                @if($row->inventory_id==$inventory->id)
                                                    {{ "selected"}}
                                                    @endif
                                                    >{{ $inventory->item_name .'('.$inventory->sku.')' }}</option>
                                            @endforeach
                                        </select>

                                </td>
                                <td>
                                    <input class="form-control qty" type="number" step="0.01" placeholder="Qty" name="qty[]" required value="{{$row->qty}}">
                                </td>
                                <td>
                                    <input class="form-control" type="number" step="0.01" placeholder="Pallet #" name="pallet_number[]" required value="{{$row->pallet_number}}">
                                </td>
                                <td>
                                    <select name="loc_id[]" class="form-control" required>
                                        <option value="">Choose Location</option>
                                        @foreach($data['locations'] as  $loc)
                                            <option value="{{ $loc->id }}"
                                            @if($row->location_id==$loc->id)
                                                {{ "selected"}}
                                                @endif
                                            >{{ $loc->loc_title}}</option>
                                        @endforeach
                                    </select>
                                </td>

                                <td class="text-start" style="width: 150px;">
                                    <div class="mb-2">
                                        <input class="form-control bg-light border-0" style="width: 170px;" type="file" name="putawayImages[{{$key}}][]" placeholder="Damage" multiple accept="image/*">
                                    </div>
                                    @isset($row->putAwayMedia)
                                        <div class="d-flex flex-grow-1 gap-2 mt-2 preview-container sealImagesPreview" id="sealImagesPreview">
                                            @foreach($row->putAwayMedia as $image)
                                                @if($image->field_name == 'putawayImages')
                                                    <div class="preview">
                                                        <img src="{{asset('storage/uploads/'.$image->file_name)}}" alt="Image Preview" class="avatar-sm rounded object-fit-cover">
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    @endisset
                                </td>
                                <td>
                                    @canany('admin-putaway-delete')
                                    <i class="ri-delete-bin-6-line align-bottom delete-row text-danger cursor-pointer fs-2"  title="Remove" data="{{$row->id}}"></i>
                                        @endcanany

                                </td>
                            </tr>
                            @endforeach
                                @else
                                <tr>
                                    <th>1</th>
                                    <td class="text-start">
                                        <input type="number" class="d-none" name="putAwayId[]" value="0">

                                        <select name="inventory_id[]" class="form-control"  data-choices required>
                                            <option value="">Choose SKU</option>
                                            @foreach($data['inventory'] as  $inventory)
                                                <option value="{{ $inventory->id }}"

                                                >{{ $inventory->item_name .'('.$inventory->sku.')' }}</option>
                                            @endforeach
                                        </select>

                                    </td>
                                    <td>
                                        <input class="form-control qty" type="number" step="0.01" placeholder="Qty" name="qty[]" required value="}">
                                    </td>
                                    <td>
                                        <input class="form-control" type="number" step="0.01" placeholder="Pallet #" name="pallet_number[]" required value="">
                                    </td>
                                    <td>
                                        <select name="loc_id[]" class="form-control" required>
                                            <option value="">Choose Location</option>
                                            @foreach($data['locations'] as  $loc)
                                                <option value="{{ $loc->id }}"

                                                >{{ $loc->loc_title}}</option>
                                            @endforeach
                                        </select>
                                    </td>

                                    <td class="text-start" style="width: 150px;">
                                        <div class="mb-2">
                                            <input class="form-control bg-light border-0" style="width: 170px;" type="file" name="putawayImages[0][]"  multiple accept="image/*" >
                                        </div>

                                        @isset($row->putAwayMedia)
                                            <div class="d-flex flex-grow-1 gap-2 mt-2 preview-container sealImagesPreview" id="sealImagesPreview">
                                                @foreach($row->putAwayMedia as $image)
                                                    @if($image->field_name == 'putawayImages')
                                                        <div class="preview">
                                                            <img src="{{asset('storage/uploads/'.$image->file_name)}}" alt="Image Preview" class="avatar-sm rounded object-fit-cover">
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        @endisset
                                    </td>
                                    <td>
                                        @canany('admin-putaway-delete')
                                        <i class="ri-delete-bin-6-line align-bottom delete-row text-danger cursor-pointer fs-2" data="0" title="Remove"></i>
                                        @endcanany

                                    </td>
                                </tr>
                            @endempty

                            </tbody>

                            <tbody>
                            <tr>
                                <td colspan="5">
                                    @canany('admin-putaway-create')
                                    <button type="button" class="btn btn-outline-success btn-add-row" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Add New Row"><i class="ri-add-fill me-1 align-bottom"></i>New Row</button>
                                    @endcanany
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        </form>


                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('admin.putaway.putaway-modal')
    @include('admin.components.comon-modals.common-modal')
    @endsection

    @section('script')
    <script src="{{ URL::asset('build/js/custom-js/putaway/putaway.js') }}"></script>
    @endsection

