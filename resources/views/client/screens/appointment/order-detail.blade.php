
@extends('client.layouts.master')
@section('title') Appointment Detail  @endsection
@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.0/min/dropzone.min.css" rel="stylesheet">
    <style>
        .dropzone {
            border: 2px dashed #0087F7;
            border-radius: 5px;
            background: white;
            padding: 20px;
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Appointment Detail</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{route('user.appointment.show-list')}}">Appointment List</a></li>
                        <li class="breadcrumb-item active">Appointment Detail</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-xl-12">
    @include('admin.order.order-detail-container')
    @include('admin.components.comon-modals.common-modal')
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('build/js/custom-js/appointment/orderList.js') }}"></script>
    <script src="{{ URL::asset('build/js/custom-js/appointment/orderDetail.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.0/min/dropzone.min.js"></script>
    <script type="text/javascript">
        Dropzone.options.dropzone = {
            url: "{{ route('packaging.images.store') }}",
            method: "post",
            maxFilesize: 2,
            acceptedFiles: ".jpeg,.jpg,.png,.gif",
            timeout: 50000,
            previewTemplate: document.querySelector('#dropzone-preview-list').innerHTML,
            previewsContainer: "#dropzone-preview",
            clickable: true,
            init: function() {
                this.on("sending", function(file, xhr, formData) {
                    formData.append("packging_id", document.getElementById("packging_id").value);
                });
            },
            success: function(file, response) {
                console.log(response);
            },
            error: function(file, response) {
                console.log(response);
                return false;
            }
        };
        $("#dropzone-preview").addClass('d-none');
    </script>
@endsection
