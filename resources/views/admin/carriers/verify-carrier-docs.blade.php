@extends('layouts.master')
@section('title') Carriers @endsection
@section('css')

@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('routeUrl') {{url('/')}} @endslot
        @slot('li_1') Dashboard @endslot
        @slot('title') Carriers Verify @endslot
    @endcomponent


    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <form action="{{route('carrier.info.store')}}" method="post" id="CarrierVerifyForm" enctype="multipart/form-data" class="form-steps" autocomplete="off">
                    @csrf

                        <input type="hidden" name="order_id" id="id" value="{{$data['orderContacts']['order_id']}}">
                        <input type="hidden" name="order_no" id="id" value="{{$data['orderContacts']['order_reference']}}">
                        <input type="hidden" name="company_id" id="id" value="{{$data['orderContacts']['company_id']}}">
                        <input type="hidden" name="carrier_id" id="id" value="{{$data['orderContacts']['carrier_id']}}">
                        <input type="hidden" name="orderContactId" id="id" value="{{$data['orderContacts']['orderContactId']}}">
                        <input type="hidden" name="from" id="id" value="1">

                    <div class="card-header">
                        <h5 class="card-title mb-0"> Carriers Verify </h5>


                            <div class="col-lg-12">
                                <div class="hstack justify-content-end gap-2">

                                    @if($data['orderContacts']['is_verify']=='Verified')
                                        <span class="text-success"> Verified</span>
                                    @else
                                        <span class="text-danger">Not Verified</span>
                                    @endif
                                </div>
                            </div>


                    </div>
                    <div class="card-body">
                        <div class="row g-4 mt-1">


                            <div class="row">
                                <div class="col-md-6">
                                    <div  class="mt-2">
                                        <label for="formSizeLarge" class="form-label">Company Name</label>
                                        <input class="form-control form-control-lg" id="formSizeLarge" name="company_name" type="text" required value="{{$data['orderContacts']['company_name']}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div  class="mt-2">
                                        <label for="formSizeLarge" class="form-label">Company Phone No.</label>
                                        <input class="form-control form-control-lg" id="formSizeLarge" name="company_phone_no" type="text" required value="{{$data['orderContacts']['company_phone']}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div  class="mt-2">
                                        <label for="formSizeLarge" class="form-label">Driver's Name</label>
                                        <input class="form-control form-control-lg" id="formSizeLarge" name="driver_name" type="text" required value="{{$data['orderContacts']['driver_name']}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div  class="mt-2">
                                        <label for="formSizeLarge" class="form-label">Driver's Phone No.</label>
                                        <input class="form-control form-control-lg" id="formSizeLarge" name="phone_no" type="text" required value="{{$data['orderContacts']['driver_phone']}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div  class="mt-2">
                                        <label for="formSizeLarge" class="form-label">Container/Trailer #</label>
                                        <input class="form-control form-control-lg" id="formSizeLarge" name="vehicle_no" type="text" required value="{{$data['orderContacts']['vehicle_number']}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div  class="mt-2">
                                        <label for="formSizeLarge" class="form-label">Vehicle License Plate #</label>
                                        <input class="form-control form-control-lg" id="formSizeLarge" name="license_no" type="text" required value="{{$data['orderContacts']['vehicle_licence_plate']}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div  class="mt-2">
                                        <label for="formSizeLarge" class="form-label">BOL #</label>
                                        <input class="form-control form-control-lg" id="formSizeLarge" name="bol_no" multiple type="text" required value="{{$data['orderContacts']['bol_number']}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div  class="mt-2">
                                        <label for="formSizeLarge" class="form-label">BOL Image</label>
                                        <input class="form-control form-control-lg" id="formSizeLarge" name="bol_image" type="file"   >
                                        <input type="text" class="d-none"  name="bolFileId" value="{{$data['orderContacts']['bolFileId']}}">
                                    </div>

                                    <div class="element-item col-xxl-3 col-xl-4 col-sm-6 photography" data-category="photography">
                                        <div class="gallery-box card">
                                            <div class="gallery-container">
                                                <a class="image-popup" href="{{ URL::asset('storage/uploads/'.$data['orderContacts']['bol_thumbnail'])}}" title="">
                                                    <img class="gallery-img img-fluid mx-auto" src="{{ URL::asset('storage/uploads/'.$data['orderContacts']['bol_thumbnail'])}}" alt="" />
                                                    <div class="gallery-overlay">
                                                        <h5 class="overlay-caption">BOL Image</h5>
                                                    </div>
                                                </a>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div  class="mt-2">
                                        <label for="formSizeLarge" class="form-label">Do #</label>
                                        <input class="form-control form-control-lg" id="formSizeLarge" name="do_no" type="text" required value="{{$data['orderContacts']['do_number']}}">
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div  class="mt-2">
                                        <label for="formSizeLarge" class="form-label">Do Document</label>
                                        <input class="form-control form-control-lg" id="formSizeLarge" name="do_document" type="file" multiple  accept="image/*" >
                                        <input type="text" class="d-none" name="doFileId" value="{{$data['orderContacts']['doFileId']}}">
                                    </div>

                                    <div class="element-item col-xxl-3 col-xl-4 col-sm-6 photography" data-category="photography">
                                        <div class="gallery-box card">
                                            <div class="gallery-container">
                                                <a class="image-popup" href="{{ URL::asset('storage/uploads/'.$data['orderContacts']['do_document'])}}" title="">
                                                    <img class="gallery-img img-fluid mx-auto" src="{{ URL::asset('storage/uploads/'.$data['orderContacts']['do_document'])}}" alt="" />
                                                    <div class="gallery-overlay">
                                                        <h5 class="overlay-caption">Do Document</h5>
                                                    </div>
                                                </a>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div  class="mt-2">
                                        <label for="formSizeLarge" class="form-label">Upload Driver's ID</label>
                                        <input class="form-control form-control-lg" id="formSizeLarge" name="driver_id_pic" type="file"  accept="image/*"  >
                                        <input type="text" class="d-none"  name="driverFileId" value="{{$data['orderContacts']['driverFileId']}}">
                                    </div>

                                    <div class="element-item col-xxl-3 col-xl-4 col-sm-6 photography" data-category="photography">
                                        <div class="gallery-box card">
                                            <div class="gallery-container">
                                                <a class="image-popup" href="{{ URL::asset('storage/uploads/'.$data['orderContacts']['driver_id_thumbnail'])}}" title="">
                                                    <img class="gallery-img img-fluid mx-auto" src="{{ URL::asset('storage/uploads/'.$data['orderContacts']['driver_id_thumbnail'])}}" alt="" />
                                                    <div class="gallery-overlay">
                                                        <h5 class="overlay-caption">Driver's ID</h5>
                                                    </div>
                                                </a>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div  class="mt-2">
                                        <label for="formSizeLarge" class="form-label">Upload Driver's Other Docs</label>
                                        <input class="form-control form-control-lg" id="formSizeLarge" name="other_document"  accept="image/*"  type="file">
                                        <input type="text" class="d-none"  name="otherDocFileId" value="{{$data['orderContacts']['otherDocFileId']}}">
                                    </div>

                                    <div class="element-item col-xxl-3 col-xl-4 col-sm-6 photography" data-category="photography">
                                        <div class="gallery-box card">
                                            <div class="gallery-container">
                                                <a class="image-popup" href="{{ URL::asset('storage/uploads/'.$data['orderContacts']['other_docs'])}}" title="">
                                                    <img class="gallery-img img-fluid mx-auto" src="{{ URL::asset('storage/uploads/'.$data['orderContacts']['other_docs'])}}" alt="" />
                                                    <div class="gallery-overlay">
                                                        <h5 class="overlay-caption">Driver's Other Docs</h5>
                                                    </div>
                                                </a>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-lg-12">
                                <div class="hstack justify-content-end gap-2">
                                    <a  href="{{session('previous_url', route('admin.check-in.index'))}}" class="btn btn-primary"><i class="ri-arrow-go-back-fill align-bottom"></i> Back</a>
                                    @if($data['orderContacts']['is_verify']=='Verified')
                                        <button type="submit" class="btn btn-success" >Save Changes</button>
                                    @else
                                    <button type="submit" class="btn btn-primary btn-submit">Verify & Save</button>
                                        @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection


@section('script')
 <script src="{{ URL::asset('build/js/custom-js/checkin/checkin.js') }}"></script>
@endsection
