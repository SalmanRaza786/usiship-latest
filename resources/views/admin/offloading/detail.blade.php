@extends('layouts.master')
@section('title') Off Loading Detail @endsection
@section('css')

@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('routeUrl') {{url('/')}} @endslot
        @slot('li_1') Dashboard @endslot
        @slot('title') Off Loading Detail @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex ">
                    <div class="col">
                        <h4 class="card-title mb-0">Off Loading Detail {{$data->order->order_id ?? '-'}}</h4>

                    </div>
                    <div class="col-auto justify-content-sm-end">
                        <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal" id="create-btn" data-bs-target="#loadTypeModal" style=""><i class="ri-add-line align-bottom me-1"></i> Start Off Loading Now</button>
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
    <div class="row">
        <div class="col-lg-12">
            <div class="card">

                <div class="card-body">
                    <div class="live-preview">
                        <div class="row gy-4">
                            <div class="col-md-6">
                                <div>
                                    <label for="basiInput" class="form-label">Container #</label>
                                    <input type="text" class="form-control" id="basiInput">
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-md-6">
                                <div>
                                    <label for="labelInput" class="form-label">Upload Container Photo</label>
                                    <input class="form-control" type="file" id="formFile">
                                </div>
                            </div><div class="col-md-6">
                                <div>
                                    <label for="basiInput" class="form-label">Seal #</label>
                                    <input type="text" class="form-control" id="basiInput">
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-md-6">
                                <div>
                                    <label for="labelInput" class="form-label">Upload Seal # Photo</label>
                                    <input class="form-control" type="file" id="formFile">
                                </div>
                            </div><div class="col-md-6">
                                <div>
                                    <label for="basiInput" class="form-label">Container Open Time</label>
                                    <input type="text" class="form-control" id="basiInput" disabled="" value="11:23 AM">
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-md-6">
                                <div>
                                    <label for="labelInput" class="form-label">Upload Container Open Photo</label>
                                    <input class="form-control" type="file" id="formFile" >
                                </div><div class="d-flex flex-grow-1 gap-2 mt-2">
                                    <a href="#" class="d-block">
                                        <img src="https://usiship.com/wp-content/uploads/2015/11/Fotolia_66820150_Subscription_Monthly_M-255x170-1.jpg" alt="" class="avatar-sm rounded object-fit-cover">
                                    </a>


                                </div>
                            </div>

                            <div class="col-md-6">
                                <div>
                                    <label for="basiInput" class="form-label">1st Hour Time</label>
                                    <input type="text" class="form-control" disabled="" value="12:22 PM" >
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-md-6">
                                <div>
                                    <label for="labelInput" class="form-label">Upload 1st Hour Photo</label>
                                    <input class="form-control" type="file" id="formFile">
                                </div><div class="d-flex flex-grow-1 gap-2 mt-2">
                                    <a href="#" class="d-block">
                                        <img src="https://usiship.com/wp-content/uploads/2015/11/Fotolia_66820150_Subscription_Monthly_M-255x170-1.jpg" alt="" class="avatar-sm rounded object-fit-cover">
                                    </a>


                                </div>
                            </div>
                            <div class="col-md-6">
                                <div>
                                    <label for="basiInput" class="form-label">2nd Hour Time</label>
                                    <input type="text" class="form-control" disabled="" value="01:20 PM" >
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-md-6">
                                <div>
                                    <label for="labelInput" class="form-label">Upload 2nd Hour Photo</label>
                                    <input class="form-control" type="file" id="formFile" >
                                </div><div class="d-flex flex-grow-1 gap-2 mt-2">
                                    <a href="#" class="d-block">
                                        <img src="https://usiship.com/wp-content/uploads/2015/11/Fotolia_66820150_Subscription_Monthly_M-255x170-1.jpg" alt="" class="avatar-sm rounded object-fit-cover">
                                    </a>


                                </div>
                            </div><div class="col-md-6">
                                <div>
                                    <label for="basiInput" class="form-label">3rd Hour Time</label>
                                    <input type="text" class="form-control" disabled="" value="">
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-md-6">
                                <div>
                                    <label for="labelInput" class="form-label">Upload 3rd Hour Photo</label>
                                    <input class="form-control" type="file"  id="formFile">
                                </div>
                            </div><div class="col-md-6">
                                <div>
                                    <label for="basiInput" class="form-label">4th Hour Time</label>
                                    <input type="text" class="form-control" disabled="" value="">
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-md-6">
                                <div>
                                    <label for="labelInput" class="form-label">Upload 4th Hour Photo</label>
                                    <input class="form-control" type="file"  id="formFile">
                                </div>
                            </div><div class="col-md-6">
                                <div>
                                    <label for="basiInput" class="form-label">5th Hour Time</label>
                                    <input type="text" class="form-control" disabled="" value="">
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-md-6">
                                <div>
                                    <label for="labelInput" class="form-label">Upload 5th Hour Photo</label>
                                    <input class="form-control" type="file" id="formFile">
                                </div>
                            </div><div class="col-md-6">
                                <div>
                                    <label for="basiInput" class="form-label">6th Hour Time</label>
                                    <input type="text" class="form-control" disabled="" value="">
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-md-6">
                                <div>
                                    <label for="labelInput" class="form-label">Upload 6th Hour Photo</label>
                                    <input class="form-control" type="file" id="formFile">
                                </div>
                            </div><div class="col-md-6">
                                <div>
                                    <label for="basiInput" class="form-label">7th Hour Time</label>
                                    <input type="text" class="form-control" disabled="" value="">
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-md-6">
                                <div>
                                    <label for="labelInput" class="form-label">Upload 7th Hour Photo</label>
                                    <input class="form-control" type="file" id="formFile">
                                </div>
                            </div><div class="col-md-6">
                                <div>
                                    <label for="basiInput" class="form-label">8th Hour Time</label>
                                    <input type="text" class="form-control" disabled="" value="">
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-md-6">
                                <div>
                                    <label for="labelInput" class="form-label">Upload 8th Hour Photo</label>
                                    <input class="form-control" type="file" id="formFile">
                                </div>
                            </div><div class="col-md-6">
                                <div>
                                    <label for="basiInput" class="form-label">Product Staged Location</label>
                                    <input type="text" class="form-control" value="">
                                </div>
                            </div><div class="col-md-6">
                                <div>
                                    <label for="labelInput" class="form-label">Upload Product Staged Location Photo</label>
                                    <input class="form-control" type="file" id="formFile">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div>
                                    <label for="labelInput" class="form-label">Upload Signed Off-loading Slip Photo</label>
                                    <input class="form-control" type="file" id="formFile">
                                </div>
                            </div><div class="col-md-6">
                                <div>
                                    <label for="labelInput" class="form-label">Upload Pallets Photos</label>
                                    <input class="form-control" type="file" id="formFile">
                                </div>
                            </div>


                        </div>
                        <!--end row-->
                    </div>

                </div><div class="card-footer">
                    <a href="javascript:void(0);" class="btn btn-success float-end">Confirm Packing List<i class="ri-arrow-right-s-line align-middle ms-1 lh-1"></i></a>

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


@endsection
