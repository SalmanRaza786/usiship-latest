@extends('layouts.master')
@section('title') Off Loading Detail @endsection
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
        @slot('title') Off Loading Detail @endslot
    @endcomponent
    @isset($data)
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex ">
                    <div class="col">
                        <h4 class="card-title mb-0">Off Loading Detail - {{$data->order->order_id ?? '-'}}</h4>
                        <input type="hidden" name="off_loading_id" id="off_loading_id" value="0">
                    </div>
                    <div class="col-auto justify-content-sm-end">
                        <form method="post" class=" g-3 needs-validation" action="{{route('admin.off-loading.store')}}" autocomplete="off" id="addForm" >
                        @csrf
                            <input type="hidden" name="order_checkin_id" id="order_checkin_id" value="{{$data->id}}"/>
                            <input type="hidden" name="order_id" id="order_id" value="{{$data->order_id}}"/>
                            @canany('admin-offloading-create')<button type="submit" class="btn btn-success btn-submit"  style=""><i class="ri-add-line align-bottom me-1"></i> Start Off Loading Now</button>@endcanany
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <div class="live-preview">
                        <div class="row gy-4">
                            <div class="col-xxl-3 col-md-6">
                                <div>
                                    <label for="basiInput" class="form-label">Container #</label>
                                    <input type="text" class="form-control" id="basiInput" value="{{$data->container_no ?? '-'}}" disabled="">
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
                            <div class="col-md-6">
                                <div>
                                    <label for="basiInput" class="form-label">Container #</label>
                                    <input type="text" class="form-control"  id="basicInput">
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
                                    <input type="text" class="form-control"  id="input">
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
                            </div><div class="col-md-6">
                                <div>
                                    <label for="basiInput" class="form-label">Container Open Time</label>
                                    <input type="text" class="form-control" id="inputopenTimeImages" disabled="" value="">
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-md-6">
                                <div>
                                    <label for="labelInput" class="form-label">Upload Container Open Photo</label>
                                    <input type="file" class="form-control" id="openTimeImages" name="openTimeImages[]" multiple accept="image/*">
                                </div>
                                <div class="d-flex flex-grow-1 gap-2 mt-2 preview-container" id="openTimeImagesPreview" >

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
                            </div><div class="col-md-6">
                                <div>
                                    <label for="basiInput" class="form-label">5th Hour Time</label>
                                    <input type="text" class="form-control" disabled="" id="input5thHourImages" value="">
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-md-6">
                                <div>
                                    <label for="labelInput" class="form-label">Upload 5th Hour Photo</label>
                                    <input type="file" class="form-control" id="5thHourImages" name="5thHourImages[]" multiple accept="image/*">
                                </div>
                                <div class="d-flex flex-grow-1 gap-2 mt-2 preview-container" id="5thHourImagesPreview" >

                                </div>
                            </div><div class="col-md-6">
                                <div>
                                    <label for="basiInput" class="form-label">6th Hour Time</label>
                                    <input type="text" class="form-control" disabled="" id="input6thHourImages" value="">
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-md-6">
                                <div>
                                    <label for="labelInput" class="form-label">Upload 6th Hour Photo</label>
                                    <input type="file" class="form-control" id="6thHourImages" name="6thHourImages[]" multiple accept="image/*">
                                </div>
                                <div class="d-flex flex-grow-1 gap-2 mt-2 preview-container" id="6thHourImagesPreview" >

                                </div>
                            </div><div class="col-md-6">
                                <div>
                                    <label for="basiInput" class="form-label">7th Hour Time</label>
                                    <input type="text" class="form-control" disabled=""  id="input7thHourImages" value="">
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-md-6">
                                <div>
                                    <label for="labelInput" class="form-label">Upload 7th Hour Photo</label>
                                    <input type="file" class="form-control" id="7thHourImages" name="7thHourImages[]" multiple accept="image/*">
                                </div>
                                <div class="d-flex flex-grow-1 gap-2 mt-2 preview-container" id="7thHourImagesPreview" >

                                </div>
                            </div><div class="col-md-6">
                                <div>
                                    <label for="basiInput" class="form-label">8th Hour Time</label>
                                    <input type="text" class="form-control" disabled="" id="input8thHourImages" value="">
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-md-6">
                                <div>
                                    <label for="labelInput" class="form-label">Upload 8th Hour Photo</label>
                                    <input type="file" class="form-control" id="8thHourImages" name="8thHourImages[]" multiple accept="image/*">
                                </div>
                                <div class="d-flex flex-grow-1 gap-2 mt-2 preview-container" id="8thHourImagesPreview" >

                                </div>
                            </div><div class="col-md-6">
                                <div>
                                    <label for="basiInput" class="form-label">Product Staged Location</label>
                                    <input type="text" class="form-control" id="product_staged_loc" name="product_staged_loc" >
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div>
                                    <label for="labelInput" class="form-label">Upload Product Staged Location Photo</label>
                                    <input type="file" class="form-control" id="productStagedLocImages" name="productStagedLocImages[]" multiple accept="image/*">
                                </div>
                                <div class="d-flex flex-grow-1 gap-2 mt-2 preview-container" id="productStagedLocImagesPreview" >

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div>
                                    <label for="labelInput" class="form-label">Upload Signed Off-loading Slip Photo</label>
                                    <input type="file" class="form-control" id="singedOffLoadingSlipImages" name="openTimeImages[]" multiple accept="image/*">
                                </div>
                                <div class="d-flex flex-grow-1 gap-2 mt-2 preview-container" id="singedOffLoadingSlipImagesPreview" >

                                </div>
                            </div><div class="col-md-6">
                                <div>
                                    <label for="labelInput" class="form-label">Upload Pallets Photos</label>
                                    <input type="file" class="form-control" id="palletsImages" name="palletsImages[]" multiple accept="image/*">
                                </div>
                                <div class="d-flex flex-grow-1 gap-2 mt-2 preview-container" id="palletsImagesPreview" >

                                </div>
                            </div>
                        </div>
                        <!--end row-->
                    </div>
                </div>
                <div class="card-footer">
                    @canany('admin-offloading-create')<a href="{{route('admin.off-loading.confirm.packaging.list',$data->id)}}" class="btn btn-success float-end btn-confirm">Confirm Packing List<i class="ri-arrow-right-s-line align-middle ms-1 lh-1"></i></a>@endcanany
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
    <script src="{{ URL::asset('build/js/custom-js/offloading/offloading.js') }}"></script>
<script>



</script>

@endsection
