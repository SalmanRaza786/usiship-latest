@extends('layouts.master')
@section('title') Check-In List @endsection
@section('css')

@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('routeUrl') {{url('/')}} @endslot
        @slot('li_1') Dashboard @endslot
        @slot('title') Check-In List @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Update Check In</h4>

                </div>
                <div class="card-body">
                    <form method="post" class=" g-3 needs-validation" action="{{route('admin.checkin.store')}}" autocomplete="off" id="UpdateCheckInForm" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="orderCheckInId"  value="{{$data['orderContacts']['check_in_id']}}">
                        <input type="hidden" name="order_contact_id" id="orderContactId" value="{{$data['orderContacts']['order_contact_id']}}">
                        <input type="hidden" name="order_id" id="orderId" value="{{$data['orderContacts']['order_id']}}">

                        <div class="modal-body">

                            <div class="row gy-4">
                                <div class="col-md-12">
                                    <label for="status-field" class="form-label">Assign Door</label>
                                    <select  class="form-select" id="status_field" required data-trigger name="whDoors" >
                                        <option value="">Choose One</option>
                                        @isset($data['doors'])
                                            @foreach($data['doors'] as $door)
                                                <option value="{{$door->id}}"
                                                @if($door->id==$data['orderContacts']['door_id'])
                                                    {{ 'selected' }}
                                                    @endif
                                                >{{$door->door_title}}</option>
                                            @endforeach
                                        @endisset

                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <div>
                                        <label for="basiInput" class="form-label">Container #</label>
                                        <input type="text" class="form-control" name="container_no" id="checkInContainerNumber" required placeholder="Container #" value="{{$data['orderContacts']['container_number']}}">
                                        <div id="containerError"></div>
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-md-6">
                                    <div>
                                        <label for="labelInput" class="form-label">Upload Container Photo</label>
                                        <input class="form-control" type="file" id="formFile" name="containerImages"   accept="image/*" >
                                        <input type="hidden" name="containerFileId" value="{{$data['orderContacts']['containerFileId']}}">
                                    </div>

                                    <div class="element-item col-xxl-3 col-xl-4 col-sm-6 photography" data-category="photography">
                                        <div class="gallery-box card">
                                            <div class="gallery-container">
                                                <a class="image-popup" href="{{ URL::asset('storage/uploads/'.$data['orderContacts']['container_image'])}}" title="">
                                                    <img class="gallery-img img-fluid mx-auto" src="{{ URL::asset('storage/uploads/'.$data['orderContacts']['container_image'])}}" alt="" />
                                                    <div class="gallery-overlay">
                                                        <h5 class="overlay-caption">Container Image</h5>
                                                    </div>
                                                </a>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div>
                                        <label for="basiInput" class="form-label">Seal #</label>
                                        <input type="text" class="form-control" id="basiInput" name="seal_no" required placeholder="Seal #" value="{{$data['orderContacts']['seal_number']}}">
                                    </div>
                                </div><div class="col-md-6">
                                    <div>
                                        <label for="labelInput" class="form-label">Upload Seal Photo</label>
                                        <input class="form-control" type="file" id="formFile" name="sealImages"  accept="image/*"  >
                                        <input type="hidden" name="sealFileId" value="{{$data['orderContacts']['sealFileId']}}">
                                    </div>

                                    <div class="element-item col-xxl-3 col-xl-4 col-sm-6 photography" data-category="photography">
                                        <div class="gallery-box card">
                                            <div class="gallery-container">
                                                <a class="image-popup" href="{{ URL::asset('storage/uploads/'.$data['orderContacts']['seal_image'])}}" title="">
                                                    <img class="gallery-img img-fluid mx-auto" src="{{ URL::asset('storage/uploads/'.$data['orderContacts']['seal_image'])}}" alt="" />
                                                    <div class="gallery-overlay">
                                                        <h5 class="overlay-caption">Seal Image</h5>
                                                    </div>
                                                </a>
                                            </div>

                                        </div>
                                    </div>
                                </div><div class="col-md-6">
                                    <div>
                                        <label for="basiInput" class="form-label">Delivery Number</label>
                                        <input type="text" class="form-control" id="basiInput" name="do_signature"   required placeholder="Delivery Number" value="{{$data['orderContacts']['delivery_number']}}">
                                    </div>
                                </div><div class="col-md-6">
                                    <div>
                                        <label for="labelInput" class="form-label">Upload Delivery Order Signature Image</label>
                                        <input class="form-control" type="file" id="formFile" name="do_signatureImages"  accept="image/*"  >
                                        <input type="hidden" name="doFileId" value="{{$data['orderContacts']['deliverySignatureId']}}">
                                    </div>


                                    <div class="element-item col-xxl-3 col-xl-4 col-sm-6 photography" data-category="photography">
                                        <div class="gallery-box card">
                                            <div class="gallery-container">
                                                <a class="image-popup" href="{{ URL::asset('storage/uploads/'.$data['orderContacts']['delivery_signature_image'])}}" title="">
                                                    <img class="gallery-img img-fluid mx-auto" src="{{ URL::asset('storage/uploads/'.$data['orderContacts']['delivery_signature_image'])}}" alt="" />
                                                    <div class="gallery-overlay">
                                                        <h5 class="overlay-caption">Delivery Order Signature Image</h5>
                                                    </div>
                                                </a>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div>
                                        <label for="basiInput" class="form-label">Other Document</label>
                                        <input type="text" class="form-control" id="basiInput" name="other_doc" placeholder="Other Document" value="{{$data['orderContacts']['other_document']}}">
                                    </div>
                                </div><div class="col-md-6">
                                    <div>
                                        <label for="labelInput" class="form-label">Upload Other Document Image</label>
                                        <input class="form-control" type="file" id="formFile" name="other_docImages"  accept="image/*" >
                                        <input type="hidden" name="otherFileId" value="{{$data['orderContacts']['otherDocFileId']}}">
                                    </div>

                                    <div class="element-item col-xxl-3 col-xl-4 col-sm-6 photography" data-category="photography">
                                        <div class="gallery-box card">
                                            <div class="gallery-container">
                                                <a class="image-popup" href="{{ URL::asset('storage/uploads/'.$data['orderContacts']['other_document_image'])}}" title="">
                                                    <img class="gallery-img img-fluid mx-auto" src="{{ URL::asset('storage/uploads/'.$data['orderContacts']['other_document_image'])}}" alt="" />
                                                    <div class="gallery-overlay">
                                                        <h5 class="overlay-caption">Other Document Image</h5>
                                                    </div>
                                                </a>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>


                        </div>
                        <div class="modal-footer">
                            <div class="hstack gap-2 justify-content-end">
                                <a href="{{session('previous_url', route('admin.check-in.index'))}}"><button type="button" class="btn btn-light btn-modal-close" data-bs-dismiss="modal">Back</button></a>
                                <button type="submit" class="btn btn-success btn-submit btn-add" id="add-btn">Save Changes</button>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')

    <script src="{{ URL::asset('build/js/custom-js/checkin/updateCheckIn.js') }}"></script>
@endsection
