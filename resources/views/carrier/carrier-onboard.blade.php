@extends('layouts.master-without-nav')
@section('title') Carrier Onboard @endsection

<style>
    #my-qr-reader {
        padding: 20px !important;
        border: 1.5px solid #b2b2b2 !important;
        border-radius: 8px;
    }

    #my-qr-reader img[alt="Info icon"] {
        display: none;
    }

    #my-qr-reader img[alt="Camera based scan"] {
        width: 100px !important;
        height: 100px !important;
    }

    button {
        padding: 10px 20px;
        border: 1px solid #b2b2b2;
        outline: none;
        border-radius: 0.25em;
        color: white;
        font-size: 15px;
        cursor: pointer;
        margin-top: 15px;
        margin-bottom: 10px;
        background-color: #008000ad;
        transition: 0.3s background-color;
    }

    button:hover {
        background-color: #008000;
    }


    video {
        width: 100% !important;
        border: 1px solid #b2b2b2 !important;
        border-radius: 0.25em;
    }

</style>

@section('content')
    <div class="auth-page-wrapper pt-5">
        <!-- auth page bg -->
        <div class="auth-one-bg-position auth-one-bg" id="auth-particles">
            <div class="bg-overlay"></div>

            <div class="shape">
                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                     viewBox="0 0 1440 120">
                    <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
                </svg>
            </div>
            <canvas class="particles-js-canvas-el" width="1583" height="380" style="width: 100%; height: 100%;"></canvas>
        </div>

        <!-- auth page content -->
        <div class="auth-page-content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center mt-sm-5 mb-4 text-white-50">
                            <div>
                                <a href="#" class="d-inline-block auth-logo">
                                    @if($appInfo->count() > 0)
                                        @include('components.auth-logo')
                                    @else
                                        <img src="{{ URL::asset('build/images/logo-light.png')}}" alt="" height="50">
                                    @endif
                                </a>
                            </div>
                            <p class="mt-3 fs-15 fw-medium">Your Delivery Partners</p>
                        </div>
                    </div>
                </div>
                <!-- end row -->
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-8">
                        <div class="card mt-4">

                            <div class="card-body">
                                <form action="{{route('carrier.info.store')}}" method="post" id="CarrierForm" enctype="multipart/form-data" class="form-steps" autocomplete="off">
                                    @csrf
                                    @isset($order)
                                    <input type="hidden" name="order_id" id="id" value="{{$order->id??"0"}}">
                                    @endisset
                                    <div class="text-center pt-3 pb-4 mb-1">
                                        <h5>Driver's Self Check In</h5>
                                    </div>
                                    <div id="custom-progress-bar" class="progress-nav mb-4">
                                        <div class="progress" style="height: 1px;">
                                            <div class="progress-bar" role="progressbar" style="width: 0%;"
                                                 aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>

                                        <ul class="nav nav-pills progress-bar-tab custom-nav" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link rounded-pill active disabled"
                                                        data-progressbar="custom-progress-bar" id="pills-gen-info-tab"
                                                        data-bs-toggle="pill" data-bs-target="#pills-gen-info" type="button"
                                                        role="tab" aria-controls="pills-gen-info" aria-selected="true"
                                                        data-position="0">1
                                                </button>
                                            </li>
                                            <li class="nav-item " role="presentation">
                                                <button class="nav-link rounded-pill disabled" data-progressbar="custom-progress-bar"
                                                        id="pills-info-desc-tab" data-bs-toggle="pill"
                                                        data-bs-target="#pills-info-desc" type="button" role="tab"
                                                        aria-controls="pills-info-desc" aria-selected="false"
                                                        data-position="1" tabindex="-1">2
                                                </button>
                                            </li>
                                            <li class="nav-item " role="presentation">
                                                <button class="nav-link rounded-pill disabled" data-progressbar="custom-progress-bar"
                                                        id="pills-success-tab" data-bs-toggle="pill"
                                                        data-bs-target="#pills-success" type="button" role="tab"
                                                        aria-controls="pills-success" aria-selected="false"
                                                        data-position="2" tabindex="-1">3
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="tab-content">
                                        <div class="tab-pane fade active show" id="pills-gen-info" role="tabpanel"
                                             aria-labelledby="pills-gen-info-tab">
                                            <div>
                                                <div class="mb-4">
                                                    <div>
                                                        <h5 class="mb-1">Scan QR Code</h5>
                                                        <p class="text-muted">For Self Check In, please scan the QR Code,
                                                            available on Warehouse main gate.</p>
                                                    </div>
                                                </div>
                                                <div class="row">

                                                    <div id="my-qr-reader" style="display: none" ></div>


                                                    <div class="input-group input-group-lg mb-4 form-icon right d-grid col-12">
                                                        <button class="btn btn-outline-success pe-5 btn-scan-now" type="button" id="start-camera"><i class="ri-camera-line fs-24"></i>Scan Now</button>
                                                    </div>
                                                </div>

                                                <hr>
                                                <div>
                                                    <h5 class="mb-1">Or Enter the Warehouse ID</h5>
                                                    <p class="text-muted">In case, if you are not able to scan QR Code,
                                                        Enter the warehouse ID</p>
                                                </div>
                                                <div class="input-group input-group-lg mb-4 form-icon right">
                                                    <input type="text" class="form-control"  id="warehouseId"  aria-label="Sizing example input" name="wh_id"  aria-describedby="inputGroup-sizing-lg">


                                                    <button class="btn btn-outline-success pe-5 " type="button" id="verifyButton"  data-nexttab="pills-info-desc-tab"><i class=" ri-refresh-line fs-24"></i> Verify Now  </button>


                                                </div>
                                            </div>
                                            <div class="d-flex align-items-start gap-3 mt-4">
                                                <button type="button" style="visibility: hidden"
                                                        class="btn btn-success btn-label right ms-auto  nexttab"
                                                        data-nexttab="pills-info-desc-tab"><i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Go to more info
                                                </button>
                                            </div>
                                        </div>
                                        <!-- end tab pane -->
                                        <div class="tab-pane fade" id="pills-info-desc" role="tabpanel"
                                             aria-labelledby="pills-info-desc-tab">
                                            <div>
                                                <div class="mb-4">
                                                    <div>
                                                        <h5 class="mb-1">Review Below Details</h5>
                                                        <p class="text-muted">Please provide the requested document to
                                                            proceed.</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <label for="address" class="form-label fs-16">Arrival Time</label>
                                                    <div class="input-group input-group-lg mb-4 form-icon right">
                                                        <input type="text" class="form-control" id="currentDateTime"
                                                               aria-label="Sizing example input" name="currentdatetime"
                                                               aria-describedby="inputGroup-sizing-lg"
                                                               data-provider="flatpickr" data-date-format="d.m.y"
                                                               data-enable-time="" readonly="">
                                                        <button class="btn btn-success pe-5 disabled" type="button"
                                                                id="button-addon2"><i class="ri-time-line fs-24"></i>
                                                            <span id="timeDiff"> 5 minutes late </span>
                                                        </button>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div>
                                                    <label for="formSizeLarge" class="form-label">Order Reference
                                                        No.</label>
                                                    <p class="text-muted">Please check order reference number from your
                                                        carrier email.</p>
                                                </div>
                                                <div class="input-group input-group-lg mb-2 form-icon right">
                                                    <input type="text" class="form-control" id="order_id" name="order_no"
                                                           aria-label="Sizing example input"
                                                           aria-describedby="inputGroup-sizing-lg" required></div>
                                                <div id="orderIdFeedback" ></div>


                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div  class="mt-2">
                                                            <label for="formSizeLarge" class="form-label">Company Name</label>
                                                            <input class="form-control form-control-lg" id="formSizeLarge" name="company_name" type="text" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div  class="mt-2">
                                                            <label for="formSizeLarge" class="form-label">Company Phone No.</label>
                                                            <input class="form-control form-control-lg" id="formSizeLarge" name="company_phone_no" type="text" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div  class="mt-2">
                                                            <label for="formSizeLarge" class="form-label">Driver's Name</label>
                                                            <input class="form-control form-control-lg" id="formSizeLarge" name="driver_name" type="text" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div  class="mt-2">
                                                            <label for="formSizeLarge" class="form-label">Driver's Phone No.</label>
                                                            <input class="form-control form-control-lg" id="formSizeLarge" name="phone_no" type="text" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div  class="mt-2">
                                                            <label for="formSizeLarge" class="form-label">Container/Trailer #</label>
                                                            <input class="form-control form-control-lg" id="formSizeLarge" name="vehicle_no" type="text" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div  class="mt-2">
                                                            <label for="formSizeLarge" class="form-label">Vehicle License Plate #</label>
                                                            <input class="form-control form-control-lg" id="formSizeLarge" name="license_no" type="text" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div  class="mt-2">
                                                            <label for="formSizeLarge" class="form-label">BOL #</label>
                                                            <input class="form-control form-control-lg" id="formSizeLarge" name="bol_no" multiple type="text" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div  class="mt-2">
                                                            <label for="formSizeLarge" class="form-label">BOL Image</label>
                                                            <input class="form-control form-control-lg" id="formSizeLarge" name="bol_image[]" type="file" multiple  required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div  class="mt-2">
                                                            <label for="formSizeLarge" class="form-label">Do #</label>
                                                            <input class="form-control form-control-lg" id="formSizeLarge" name="do_no" type="text" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div  class="mt-2">
                                                            <label for="formSizeLarge" class="form-label">Do Document</label>
                                                            <input class="form-control form-control-lg" id="formSizeLarge" name="do_document[]" type="file" multiple  accept="image/*" required>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div  class="mt-2">
                                                            <label for="formSizeLarge" class="form-label">Upload Driver's ID</label>
                                                            <input class="form-control form-control-lg" id="formSizeLarge" name="driver_id_pic[]" type="file"  accept="image/*" multiple required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div  class="mt-2">
                                                            <label for="formSizeLarge" class="form-label">Upload Driver's Other Docs</label>
                                                            <input class="form-control form-control-lg" id="formSizeLarge" name="other_document[]"  accept="image/*" multiple type="file">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="d-flex align-items-start gap-3 mt-4 ">
                                                <button type="button"
                                                        class="btn btn-link text-decoration-none btn-label previestab"
                                                        data-previous="pills-gen-info-tab"><i
                                                        class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i>
                                                    Back to General
                                                </button>
                                                <button type="submit"
                                                        class="btn btn-success btn-label right ms-auto btn-submit"
                                                        data-nexttab="pills-success-tab" style="" id="btn-carrier-submit"><i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Checked In
                                                </button>
                                            </div>
                                        </div>
                                        <!-- end tab pane -->

                                        <div class="tab-pane fade" id="pills-success" role="tabpanel"
                                             aria-labelledby="pills-success-tab">
                                            <div>
                                                <div class="text-center">

                                                    <div class="mb-4">
                                                        <lord-icon src="https://cdn.lordicon.com/lupuorrc.json"
                                                                   trigger="loop" colors="primary:#0ab39c,secondary:#405189"
                                                                   style="width:120px;height:120px"></lord-icon>
                                                    </div>
                                                    <h5>Well Done !</h5>
                                                    <p class="text-muted">You have successfully requested for Check-In</p>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end tab pane -->
                                    </div>
                                    <!-- end tab content -->
                                </form>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->

                        <div class="mt-4 text-center">

                        </div>

                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end auth page content -->

        <!-- footer -->
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <p class="mb-0 text-muted">©
                                <script>document.write(new Date().getFullYear())</script>
                                {{date('Y')}} USI Ship. Crafted with <i class="mdi mdi-heart text-danger"></i> by MAIT
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    @endsection
    @section('script')
<script src="{{ URL::asset('build/js/html5-qrcode.min.js')}}"></script>
    <script>
        var startScannerButton = document.getElementById('start-camera');
        var scanSection = document.getElementById('my-qr-reader');
        var qrInputElement = document.getElementById('warehouseId');
        const verifyButton = document.getElementById('verifyButton');
        const stopScannerButton = document.getElementById('html5-qrcode-button-camera-stop');
        let htmlscanner;

        $(document).ready(function() {



            $('#order_id').on('keyup', function() {
                var orderId = $(this).val();
                var id=$('input[name=order_id]').val();

                var errorText='';
                if (orderId.length > 0) {

                    $.ajax({
                        url: '{{ route("checkOrderId") }}',
                        method: 'GET',
                        data: { order_id: orderId,id:id },
                        success: function(response) {

                            if (response.data==1) {
                                $("#btn-carrier-submit").prop("disabled", false);
                                errorText='<span></span>';
                            }
                            if (response.data==0) {
                                $("#btn-carrier-submit").prop("disabled", true);
                                errorText='<span class="text-danger">Invalid Order Reference</span>';
                            }


                            $('#orderIdFeedback').html(errorText)
                        },
                        error: function() {
                            $('#orderIdFeedback').text('An error occurred while checking the Order ID.').css({'color': 'red' });
                        }
                    });
                } else {
                    $('#orderIdFeedback').html(errorText)
                }
            });
            $('#verifyButton').on('click', function(){

                let warehouseId = $('#warehouseId').val();

                if (!warehouseId > 0) {
                    toastr.error('Enter or scan warehouse, please');
                    return false;
                }

                let orderId = $('#id').val();
                var targetTab = $(this).data('nexttab');

                $.ajax({
                    url: '{{ route('verify.warehouse.id') }}',
                    method: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        warehouseId: warehouseId,
                        orderId: orderId
                    },
                    success: function(response){

                        if (response.status == true) {
                            console.log('verify htmlscanner',htmlscanner);
                            if (htmlscanner) {
                                htmlscanner.clear();
                            }
                            toastr.success(response.message);
                            $('#currentDateTime').val(response.data.current_date_time);
                            $('#timeDiff').text(response.data.time_difference);
                            $('#' + targetTab).tab('show');
                        }

                        if (response.status == false) {
                            toastr.error(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        var errors = xhr.responseJSON.errors;
                        toastr.error(error);
                    }
                });
            });
            $('#CarrierForm').on('submit', function(e) {
                e.preventDefault();
                var targetTab = $('#btn-carrier-submit').data('nexttab');

                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: new FormData(this),
                    dataType: 'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function() {
                        $('.btn-submit').text('Processing...');
                        $(".btn-submit").prop("disabled", true);
                    },
                    success: function(response) {
                        if (response.status==true) {
                            toastr.success(response.message);
                            $('.btn-submit').text('>Checked In');
                            $(".btn-submit").prop("disabled", false);
                            $('#' + targetTab).tab('show');
                        }
                        if (response.status==false) {
                            toastr.error(response.message);
                        }
                    },
                    complete: function(data) {
                        $(".btn-submit").html(">Checked In");
                        $(".btn-submit").prop("disabled", false);
                    },
                    error: function() {
                        // toastr.error('something went wrong');
                        $('.btn-submit').text('>Checked In');
                        $(".btn-submit").prop("disabled", false);
                    }
                });

            });
            $('.nexttab').click(function() {
                var targetTab = $(this).data('nexttab');
                $('#' + targetTab).tab('show');
            });
            $('.previestab').click(function() {
                var previousTab = $(this).data('previous');
                $('#' + previousTab).tab('show');
            });


        });




        document.addEventListener('DOMContentLoaded', () => {
            function domReady(fn) {
                if (
                    document.readyState === "complete" ||
                    document.readyState === "interactive"
                ) {
                    setTimeout(fn, 1000);
                } else {
                    document.addEventListener("DOMContentLoaded", fn);
                }
            }

            domReady(function () {

                // If found you qr code
                function onScanSuccess(decodeText, decodeResult) {
                    qrInputElement.value = decodeText;
                    console.log('stopScannerButton',stopScannerButton);
                    console.log('verifyButton',verifyButton);
                    verifyButton.click();
                }

                startScannerButton.addEventListener('click', function () {
                    scanSection.style.display = 'block';
                    startScannerButton.style.display = 'none';
                    htmlscanner = new Html5QrcodeScanner(
                        "my-qr-reader",
                        { fps: 10, qrbos: 250 }
                    );
                    htmlscanner.render(onScanSuccess);
                });

            });
        });
    </script>
    @endsection
