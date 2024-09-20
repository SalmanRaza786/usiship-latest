@extends('layouts.master')
@section('title') Processing Detail @endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Dashboard @endslot
        @slot('routeUrl') {{url('/')}} @endslot
        @slot('title') Processing Detail - {{$data['orderInfo']->workOrder->order_reference}} @endslot
    @endcomponent
    @include('components.common-error')
    <div class="container-fluid">

        <input type="hidden" name="isStartPicking" value="{{$data['orderInfo']->start_time!=null?1:0}}">

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex ">
                        <div class="col">
                            <h4 class="card-title mb-0">Processing  Detail</h4>

                        </div>
                        <div class="col-auto justify-content-sm-end">
                            @if($data['orderInfo']->end_time==NULL)
                            <button type="button" class="btn btn-success btn-close-qc me-2 d-none"><i class="ri-eye-line align-bottom me-1"></i> Close Processing Now</button>
                            @endif

{{--                            <button type="button" class="btn btn-success btn-start-qc d-none" updateType="1" ><i class="ri-add-line align-bottom me-1"></i> Start  Q/C Now</button>--}}

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
                            <form action="{{route('admin.process.start')}}" method="post" enctype="multipart/form-data"
                                  id="CloseProcessingForm">
                                @csrf
                                <input type="hidden" name="w_order_id" value="{{$data['orderInfo']->workOrder->id}}">
                                <input type="hidden" name="process_id" value="{{$data['orderInfo']->id}}">
{{--                                <input type="hidden" name="staff_id"--}}
{{--                                       value="{{$data['orderInfo']->orderPicker->picker_id}}">--}}
{{--                                <input type="hidden" name="missed_id" value="{{$data['orderInfo']->id }}">--}}
                                <input type="hidden" name="status_code" value="204">


                                <table class="invoice-table table table-borderless table-nowrap mb-0">
                                    <thead class="align-middle">
                                    <tr class="table-active">
                                        <th scope="col" style="width: 50px;">#</th>
                                        <th scope="col">Tasks</th>
                                        <th scope="col" style="">Qty (if any)</th>
                                        <th scope="col" class=>Other comments (if any) </th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Photos</th>
                                        <th scope="col"></th>
                                        <th scope="col">Action</th>

                                    </tr>
                                    </thead>

                                    <tbody id="clonedSection">

                                    @if($data['processItems']->count() > 0)
                                        @foreach($data['processItems'] as $key=>$resolve)
                                            <input type="hidden" name="process_detail_id" class="process-id"
                                                   value="{{$resolve->id}}">

                                            <tr>
                                                <td>{{$key+1}}</td>
                                                <td>
                                                        <select name="itemId[]" id="" class="form-control item-id" required>
                                                            <option value="">Select Your Task</option>
                                                            <option value="1" {{$resolve->task_id =='1'? "selected":""}}>Task A</option>
                                                            <option value="2" {{$resolve->task_id =='2'? "selected":""}}>Task B</option>

                                                    </select>
                                                </td>

                                                <td>
                                                    <input class="form-control bg-light border-0 qty"
                                                           name="Qty[]" type="number" placeholder="Qty"
                                                           value="{{$resolve->qty}}">
                                                </td>
                                                <td class="text-start" style="width: 150px;">
                                                    <div class="mb-2">
                                                        <textarea rows="4" cols="30" class="form-control comments" value="{{$resolve->comment}}" name="comments">{{$resolve->comment}}</textarea>
                                                    </div>

                                                </td>
                                                <td class="text-end">
                                                    <select name="status[]" id="" class="form-select status" required>
                                                        <option value="">Choose Status</option>
                                                        <option value="205" {{$resolve->status_code =='205'? "selected":""}}>Pending</option>
                                                        <option value="203" {{$resolve->status_code =='203'? "selected":""}}>InProgress</option>
                                                        <option value="204" {{$resolve->status_code =='204'? "selected":""}}>Processed</option>
                                                    </select>
                                                </td>
                                                <td class="text-start" style="width: 150px;">
                                                    <div class="mb-2">
                                                        <input class="form-control bg-light border-0" style="width: 170px;"
                                                               type="file" name="processingItemImages[{{$key}}][]"
                                                               placeholder="Damage" multiple accept="image/*">
                                                    </div>
                                                    @isset($resolve->media)
                                                        <div
                                                            class="d-flex flex-grow-1 gap-2 mt-2 preview-container sealImagesPreview"
                                                            id="sealImagesPreview">
                                                            @foreach($resolve->media as $image)
                                                                @if($image->field_name == 'processingItemImages')
                                                                    <div class="preview">
                                                                        <img
                                                                            src="{{asset('storage/uploads/'.$image->file_name)}}"
                                                                            alt="Image Preview"
                                                                            class="avatar-sm rounded object-fit-cover">
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    @endisset
                                                </td>
                                                <td>
                                                    @canany('admin-putaway-delete')
                                                        <i class="ri-delete-bin-6-line align-bottom delete-row text-danger cursor-pointer fs-2"
                                                           title="Remove" data="{{$resolve->id}}"></i>
                                                    @endcanany

                                                </td>

                                                <td class="text-end  cursor-pointer text-success btn-save-row"
                                                    title="Save" data="{{$resolve->id}}"><i class="ri-save-2-fill fs-1"></i>
                                                </td>

                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <input type="hidden" name="hidden_process_detail_id" class="process-id" value="0">
                                            <td>1</td>
                                            <td>
                                                <select name="itemId[]" id="" class="form-control item-id" required>
                                                    <option value="">Select Your Task</option>
                                                    <option value="1">Task A</option>
                                                    <option value="2">Task B</option>
                                                </select>
                                            </td>


                                            <td><input class="form-control bg-light border-0 qty"
                                                       name="Qty[]" type="number" placeholder="Qty"
                                                       value=""></td>
                                            <td class="text-start" style="width: 150px;">
                                                <div class="mb-2">
                                                    <textarea rows="4" class="form-control comments" cols="30" name="comments"></textarea>
                                                </div>
                                            </td>
                                            <td class="text-end">
                                                <select name="status[]" id="" class="form-select status" required>
                                                    <option value="">Choose Status</option>
                                                    <option value="205">Pending</option>
                                                    <option value="203">InProgress</option>
                                                    <option value="204">Processed</option>
                                                </select>
                                            </td>
                                            <td class="text-start" style="width: 150px;">
                                                <div class="mb-2">
                                                    <input class="form-control bg-light border-0" style="width: 170px;"
                                                           type="file" name="processingItemImages[{{$key}}][]"
                                                           placeholder="Damage" multiple accept="image/*">
                                                </div>
                                                @isset($row->media)
                                                    <div
                                                        class="d-flex flex-grow-1 gap-2 mt-2 preview-container sealImagesPreview"
                                                        id="sealImagesPreview">
                                                        @foreach($row->media as $image)
                                                            @if($image->field_name == 'resolveItemImages')
                                                                <div class="preview">
                                                                    <img
                                                                        src="{{asset('storage/uploads/'.$image->file_name)}}"
                                                                        alt="Image Preview"
                                                                        class="avatar-sm rounded object-fit-cover">
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                @endisset

                                            </td>
                                            <td>
                                                @canany('admin-putaway-delete')
                                                    <i class="ri-delete-bin-6-line align-bottom delete-row text-danger cursor-pointer fs-2"
                                                       title="Remove" data="0"></i>
                                                @endcanany

                                            </td>

                                            <td class="text-start  cursor-pointer text-success btn-save-row" title="Save"
                                                data="0"><i class="ri-save-2-fill fs-1"></i></td>

                                        </tr>
                                    @endif


                                    </tbody>

                                    <tr>
                                        <td colspan="5">
                                            @canany('admin-putaway-create')
                                                @if($data['orderInfo']->end_time==NULL)
                                                    <button type="button" class="btn btn-outline-success btn-add-row"
                                                            data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                            title="Add New Row"><i
                                                            class="ri-add-fill me-1 align-bottom"></i>New Row
                                                    </button>
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
@endsection
    @section('script')
    <script src="{{ URL::asset('build/js/custom-js/processing/processing.js') }}"></script>
    @endsection


