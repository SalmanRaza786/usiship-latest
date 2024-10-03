@extends('layouts.master')
@section('title') On Loading Detail @endsection
@section('css')
    <style>
        .preview-container {
            display: flex;
            flex-wrap: wrap;
        }
        .preview {
            margin: 10px;
            border: 1px solid #ddd;
            padding: 5px;
            border-radius: 4px;
        }
        .preview img {
            max-width: 200px;
            max-height: 200px;
        }
    </style>
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('routeUrl') {{url('/')}} @endslot
        @slot('li_1') Dashboard @endslot
        @slot('title') On Loading Detail @endslot
    @endcomponent
    @isset($data)
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex ">
                    <div class="col">
                        <h4 class="card-title mb-0">On Loading Detail - {{$data->order->order_id ?? '-'}}</h4>
                        <input type="hidden" name="off_loading_id" id="off_loading_id" value="0">
                    </div>
                    <div class="col-auto justify-content-sm-end">
                        <form method="post" class=" g-3 needs-validation" action="{{route('admin.off-loading.store')}}" autocomplete="off" id="addForm" >
                        @csrf
                            <input type="hidden" name="order_checkin_id" id="order_checkin_id" value="{{$data->id}}"/>
                            <input type="hidden" name="order_id" id="order_id" value="{{$data->order_id}}"/>
                                @canany('admin-offloading-create')<button type="submit" class="btn btn-success btn-submit"  style=""><i class="ri-add-line align-bottom me-1"></i> Start On Loading Now</button>@endcanany
                        </form>
                        <div class="col-auto justify-content-sm-end">
                            <form method="post" class=" g-3 needs-validation" action="{{route('admin.on-loading.close')}}" autocomplete="off" id="addFormClose" >
                                @csrf
                                <input type="hidden" name="order_checkin_id" id="order_checkin_id" value="{{$data->id}}"/>
                                <input type="hidden" name="order_id" id="order_id" value="{{$data->order_id}}"/>
                                @canany('admin-offloading-create')<button type="submit" class="btn btn-success btn-loading-close"  style=""> <i class="ri-save-line align-bottom me-1"></i> Close On Loading Now</button>@endcanany
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="live-preview">
                        <div class="row gy-4">
                            <div class="col-xxl-3 col-md-6">
                                <div>
                                    <label for="basiInput" class="form-label">Container #</label>
                                    <input type="text" class="form-control" id="basiInput" value="{{$data->container_no ?? '-'}}" disabled="" name="db_container_number">
                                    <input type="hidden" class="form-control"  value="{{$data->seal_no ?? '-'}}" disabled="" name="db_seal_no" placeholder="Db Seal Number">
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-3 col-md-6">
                                <div>
                                    <label for="labelInput" class="form-label">Door Assigned</label>
                                    <input type="text" class="form-control" id="labelInput" value="{{$data->door->door_title ?? '-'}}" disabled="">
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-3 col-md-6">
                                <div>
                                    <label for="placeholderInput" class="form-label">Arrival Date/Time</label>
                                    <input type="text" class="form-control" id="placeholderInput" value="{{$data->orderContact->arrival_time ?? '-'}}" disabled="">
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-3 col-md-6">
                                <div>
                                    <label for="valueInput" class="form-label">Load Type</label>
                                    <input type="text" class="form-control" id="valueInput" value="{{$data->order->dock->loadType->eqType->value ?? '-'}}" disabled="">
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
    <div class="row d-none" id="offloadingContainer">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="live-preview">
                        <div class="row gy-4">
{{--                            <div class="col-md-6">--}}
{{--                                <div>--}}
{{--                                    <label for="basiInput" class="form-label">Order #</label>--}}
{{--                                    <input type="text" class="form-control" id="basicInput" name="order_no">--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col-md-6">--}}
{{--                                <div>--}}
{{--                                    <label for="labelInput" class="form-label">Upload Order Photo</label>--}}
{{--                                    <input type="file" class="form-control" id="orderImages" name="orderImages[]" multiple accept="image/*">--}}
{{--                                </div>--}}
{{--                                <div class="d-flex flex-grow-1 gap-2 mt-2 preview-container" id="orderImagesPreview" >--}}

{{--                                </div>--}}
{{--                            </div>--}}
                            <div class="col-md-6">
                                <div>
                                    <label for="basiInput" class="form-label">Container/Trailer #</label>
                                    <input type="text" class="form-control"  id="basicInput" name="type_container_number">
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-md-6">
                                <div>
                                    <label for="labelInput" class="form-label">Upload Container Photo</label>
                                    <input type="file" class="form-control" id="containerImages" name="containerImages[]" multiple accept="image/*">
                                </div>
                                <div class="d-flex flex-grow-1 gap-2 mt-2 preview-container" id="containerImagesPreview" >

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div>
                                    <label for="basiInput" class="form-label">Seal #</label>
                                    <input type="text" class="form-control"  id="input" name="seal_no">
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-md-6">
                                <div>
                                    <label for="labelInput" class="form-label">Upload Seal # Photo</label>
                                    <input type="file" class="form-control" id="sealImages" name="sealImages[]" multiple accept="image/*">
                                </div>
                                <div class="d-flex flex-grow-1 gap-2 mt-2 preview-container" id="sealImagesPreview" >

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div>
                                    <label for="basiInput" class="form-label">Pallets staged</label>
                                    <input type="text" class="form-control" id="inputpalletsStagedImages" disabled="" value="" >
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div>
                                    <label for="labelInput" class="form-label">Upload Pallets staged Photo</label>
                                    <input type="file" class="form-control" id="palletsStagedImages" name="palletsStagedImages[]" multiple accept="image/*">
                                </div>
                                <div class="d-flex flex-grow-1 gap-2 mt-2 preview-container" id="palletsStagedImagesPreview" >

                                </div>
                            </div>

                            <div class="col-md-6">
                                <div>
                                    <label for="basiInput" class="form-label">1st Hour Time</label>
                                    <input type="text" class="form-control" id="input1stHourImages" disabled="" value="" >
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-md-6">
                                <div>
                                    <label for="labelInput" class="form-label">Upload 1st Hour Photo</label>
                                    <input type="file" class="form-control" id="1stHourImages" name="1stHourImages[]" multiple accept="image/*">
                                </div>
                                <div class="d-flex flex-grow-1 gap-2 mt-2 preview-container" id="1stHourImagesPreview" >

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div>
                                    <label for="basiInput" class="form-label">2nd Hour Time</label>
                                    <input type="text" class="form-control" disabled="" id="input2ndHourImages" value="" >
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-md-6">
                                <div>
                                    <label for="labelInput" class="form-label">Upload 2nd Hour Photo</label>
                                    <input type="file" class="form-control" id="2ndHourImages" name="2ndHourImages[]" multiple accept="image/*">
                                </div>
                                <div class="d-flex flex-grow-1 gap-2 mt-2 preview-container" id="2ndHourImagesPreview" >

                                </div>
                            </div><div class="col-md-6">
                                <div>
                                    <label for="basiInput" class="form-label">3rd Hour Time</label>
                                    <input type="text" class="form-control" disabled="" id="input3rdHourImages" value="">
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-md-6">
                                <div>
                                    <label for="labelInput" class="form-label">Upload 3rd Hour Photo</label>
                                    <input type="file" class="form-control" id="3rdHourImages" name="3rdHourImages[]" multiple accept="image/*">
                                </div>
                                <div class="d-flex flex-grow-1 gap-2 mt-2 preview-container" id="3rdHourImagesPreview" >

                                </div>
                            </div><div class="col-md-6">
                                <div>
                                    <label for="basiInput" class="form-label">4th Hour Time</label>
                                    <input type="text" class="form-control" disabled="" id="input4thHourImages" value="">
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-md-6">
                                <div>
                                    <label for="labelInput" class="form-label">Upload 4th Hour Photo</label>
                                    <input type="file" class="form-control" id="4thHourImages" name="4thHourImages[]" multiple accept="image/*">
                                </div>
                                <div class="d-flex flex-grow-1 gap-2 mt-2 preview-container" id="4thHourImagesPreview" >

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div>
                                    <label for="labelInput" class="form-label">Signed BOL</label>
                                    <input type="file" class="form-control" id="signedBolImages" name="signedBolImages[]" multiple accept="image/*">
                                </div>
                                <div class="d-flex flex-grow-1 gap-2 mt-2 preview-container" id="signedBolImagesPreview" >

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div>
                                    <label for="labelInput" class="form-label">Upload Signed loading Slip Photo</label>
                                    <input type="file" class="form-control" id="singedLoadingSlipImages" name="singedLoadingSlipImages[]" multiple accept="image/*">
                                </div>
                                <div class="d-flex flex-grow-1 gap-2 mt-2 preview-container" id="singedLoadingSlipImagesPreview" >

                                </div>
                            </div>


                        </div>
                        <!--end row-->
                    </div>
                </div>
                <div class="card-footer">
{{--                    @canany('admin-offloading-create')<a href="{{route('admin.off-loading.confirm.packaging.list',$data->id)}}" class="btn btn-success float-end btn-confirm">Confirm Packing List<i class="ri-arrow-right-s-line align-middle ms-1 lh-1"></i></a>@endcanany--}}
{{--                    @canany('admin-offloading-create')<button data="{{$data->id}}" class="btn btn-success float-end" id="confirmPackgingList">Confirm Packing List<i class="ri-arrow-right-s-line align-middle ms-1 lh-1"></i></button>@endcanany--}}
                </div>
            </div>
        </div>
        <!--end col-->
    </div>
    @endisset
    <!--end row-->
{{--    @include('admin.checkin.checkin-modals')--}}
{{--    @include('admin.components.comon-modals.common-modal')--}}


@endsection
@section('script')
    <script src="{{ URL::asset('build/js/custom-js/offloading/onloading.js') }}"></script>
<script>



</script>

@endsection
