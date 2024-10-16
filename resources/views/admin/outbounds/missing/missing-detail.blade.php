@extends('layouts.master')
@section('title') Missing Detail @endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Dashboard @endslot
        @slot('routeUrl') {{url('/')}} @endslot
        @slot('title') Missing Detail - {{$data['orderInfo']->workOrder->order_reference}} @endslot
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
                            <h4 class="card-title mb-0">Missing  Detail</h4>

                        </div>
                        <div class="col-auto justify-content-sm-end">

                            @if($data['orderInfo']->end_time==null)
                            <button type="button" class="btn btn-success btn-close-resolve me-2 d-none" data-bs-toggle="modal" data-bs-target="#confirmCloseModal"><i class="ri-eye-line align-bottom me-1"></i> Close Resolve</button>
                            @endif


                            <button type="submit" class="btn btn-success btn-start-resolve d-none" updateType="1" ><i class="ri-add-line align-bottom me-1"></i> Start Resolve</button>

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
                            <form action="{{route('admin.save.resolve')}}" method="post" enctype="multipart/form-data" id="CloseResolveForm">
                                @csrf
                                <input type="hidden" name="w_order_id" value="{{$data['orderInfo']->workOrder->id}}">
                                <input type="hidden" name="staff_id" value="{{$data['orderInfo']->orderPicker->picker_id}}">
                                <input type="hidden" name="missed_id" value="{{$data['orderInfo']->id }}">
                                <input type="hidden" name="status_code" value="205">


                       <table class="invoice-table table table-borderless table-nowrap mb-0">
                                    <thead class="align-middle">
                                    <tr class="table-active">
                                        <th scope="col" style="width: 50px;">#</th>
                                        <th scope="col">Product SKU</th>


                                        <th scope="col" style="">Resolve Qty</th>
                                        <th scope="col" class= >Photo</th>
                                        <th scope="col" >New Location</th>
                                        <th scope="col" >Photo</th>

                                        <th scope="col" ></th>
                                        <th scope="col" >Action</th>

                                    </tr>
                                    </thead>

                           <tbody id="clonedSection">

                           @if($data['resolveItems']->count() > 0)
                               @foreach($data['resolveItems'] as $key=>$resolve)
                                   <input type="hidden" name="hidden_resolve_id" class="resolve-id" value="{{$resolve->id}}">

                                        <tr>
                                            <td>{{$key+1}}</td>
                                        <td>
                                            <select name="itemId[]" id="" class="form-control item-id" required>
                                                <option value="">Choose SKU</option>
                                                @isset($data['missedItems'])
                                                    @foreach($data['missedItems'] as $row)
                                                        <option
                                                            @if($resolve->missed_detail_parent_id==$row->id)
                                                                {{"selected"}}
                                                            @endif
                                                            value="{{$row->pickedItem->inventory->id}},{{$row->pickedItem->w_order_item_id}},{{$row->id}}">{{$row->pickedItem->inventory->item_name}} - {{$row->pickedItem->inventory->sku}} ({{$row->missed_qty}})</option>
                                                    @endforeach
                                                @endisset
                                            </select>
                                        </td>


                                        <td><input class="form-control bg-light border-0 resolve-qty" name="resolveQty[]" type="number" placeholder="Resolve Qty" value="{{$resolve->resolve_qty}}"></td>
                                        <td class="text-start" style="width: 150px;">
                                                <div class="mb-2">
                                                    <input class="form-control bg-light border-0" style="width: 170px;" type="file" name="pickedItemImages[{{$key}}][]" placeholder="Damage" multiple accept="image/*">
                                                </div>

                                            @isset($resolve->media)
                                                <div class="d-flex flex-grow-1 gap-2 mt-2 preview-container sealImagesPreview" id="sealImagesPreview">
                                                    @foreach($resolve->media as $image)
                                                        @if($image->field_name == 'resolveItemImages')
                                                            <i class="ri ri-close-fill text-danger fs-2 cursor-pointer btn-delete-file" data="{{$image->id}}" data-bs-toggle="modal" data-bs-target="#deleteRecordModal"></i>
                                                            <div class="preview">
                                                                <img src="{{asset('storage/uploads/'.$image->file_name)}}" alt="Image Preview" class="avatar-sm rounded object-fit-cover">
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            @endisset
                                            </td>

                                        <td class="text-end">
                                                <select name="newLocId[]" id="" class="form-select new-loc-id" required>
                                                    <option value="">Choose One</option>
                                                    @isset($data['missedItems'])
                                                        @foreach($data['locations'] as $loc)
                                                            <option value="{{$loc->id}}"
                                                            @if($resolve->new_loc_id==$loc->id)
                                                                {{"selected"}}
                                                                @endif
                                                                >{{$loc->loc_title}}</option>
                                                        @endforeach
                                                    @endisset
                                                </select>
                                            </td>
                                         <td class="text-start" style="width: 150px;">
                                                <div class="mb-2">
                                                    <input class="form-control bg-light border-0" style="width: 170px;" type="file" name="newLocationItemImages[{{$key}}][]" placeholder="Damage" multiple accept="image/*">
                                                </div>

                                             @isset($resolve->media)
                                                 <div class="d-flex flex-grow-1 gap-2 mt-2 preview-container sealImagesPreview" id="sealImagesPreview">
                                                     @foreach($resolve->media as $image)
                                                         @if($image->field_name == 'newLocationItemImages')
                                                             <i class="ri ri-close-fill text-danger fs-2 cursor-pointer btn-delete-file" data="{{$image->id}}" data-bs-toggle="modal" data-bs-target="#deleteRecordModal"></i>
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

                                            <td class="text-end  cursor-pointer text-success btn-save-row" title="Save" data="{{$row->id}}"><i class="ri-save-2-fill fs-1"></i></td>

                                    </tr>
                               @endforeach
                           @else
                               <tr>
                                   <input type="hidden" name="hidden_resolve_id" class="resolve-id" value="0">
                                   <td>1</td>
                                   <td>
                                       <select name="itemId[]" id="" class="form-control item-id" required>
                                           <option value="">Choose SKU</option>
                                           @isset($data['missedItems'])
                                               @foreach($data['missedItems'] as $row)
                                                   <option

                                                       value="{{$row->pickedItem->inventory->id}},{{$row->pickedItem->w_order_item_id}},{{$row->id}}">{{$row->pickedItem->inventory->item_name}} - {{$row->pickedItem->inventory->sku}} ({{$row->missed_qty}})</option>
                                               @endforeach
                                           @endisset
                                       </select>
                                   </td>


                                   <td><input class="form-control bg-light border-0 resolve-qty" name="resolveQty[]" type="number" placeholder="Resolve Qty" value="0"></td>
                                   <td class="text-start" style="width: 150px;">
                                       <div class="mb-2">
                                           <input class="form-control bg-light border-0" style="width: 170px;" type="file" name="resolveItemImages[{{$key}}][]" placeholder="Damage" multiple accept="image/*">
                                       </div>
                                                                                       @isset($row->media)
                                                                                           <div class="d-flex flex-grow-1 gap-2 mt-2 preview-container sealImagesPreview" id="sealImagesPreview">
                                                                                               @foreach($row->media as $image)
                                                                                                   @if($image->field_name == 'resolveItemImages')
                                                                                                       <div class="preview">
                                                                                                           <img src="{{asset('storage/uploads/'.$image->file_name)}}" alt="Image Preview" class="avatar-sm rounded object-fit-cover">
                                                                                                       </div>
                                                                                                   @endif
                                                                                               @endforeach
                                                                                           </div>
                                                                                       @endisset
                                   </td>

                                   <td class="text-end">
                                       <select name="newLocId[]" id="" class="form-select new-loc-id" required>
                                           <option value="">Choose One</option>
                                           @isset($data['missedItems'])
                                               @foreach($data['locations'] as $loc)
                                                   <option value="{{$loc->id}}"
                                                   >{{$loc->loc_title}}</option>
                                               @endforeach
                                           @endisset
                                       </select>
                                   </td>
                                   <td class="text-start" style="width: 150px;">
                                       <div class="mb-2">
                                           <input class="form-control bg-light border-0" style="width: 170px;" type="file" name="newLocationItemImages[{{$key}}][]" placeholder="Damage" multiple accept="image/*">
                                       </div>

                                   </td>
                                   <td>
                                       @canany('admin-putaway-delete')
                                           <i class="ri-delete-bin-6-line align-bottom delete-row text-danger cursor-pointer fs-2"  title="Remove" data="{{$row->id}}"></i>
                                       @endcanany

                                   </td>

                                   <td class="text-end  cursor-pointer text-success btn-save-row" title="Save" data="{{$row->id}}"><i class="ri-save-2-fill fs-1"></i></td>

                               </tr>
                           @endif




                                    </tbody>

                           <tr>
                               <td colspan="5">
                                   @canany('admin-putaway-create')
                                       @if($data['orderInfo']->end_time==NULL)
                                       <button type="button" class="btn btn-outline-success btn-add-row" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Add New Row"><i class="ri-add-fill me-1 align-bottom"></i>New Row</button>
                                       @endif
                                  @endcanany
                               </td>
                           </tr>

                                </table>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    @include('admin.components.comon-modals.common-modal')
    @include('admin.outbounds.missing.missing-modals')
@endsection
    @section('script')
    <script src="{{ URL::asset('build/js/custom-js/missedItems/missedItems.js') }}"></script>
    @endsection


