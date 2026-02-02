
@extends('layouts.master')
@section('title') Scheduling Detail  @endsection
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
    @component('components.breadcrumb')
        @slot('li_1') Dashboard @endslot
        @slot('routeUrl') {{url('/')}} @endslot
        @slot('li_2') Transactions @endslot
        @slot('routeUrl2') {{route('admin.transactions.index')}} @endslot
        @slot('title') Scheduling Detail @endslot
    @endcomponent
    <input type="number" class="d-none" value="{{$data['orderDetail']['data']['id'] ?? "-"}}" name="hidden_order_id" placeholder="hidden order id">
    @include('admin.order.order-detail-container')
    @include('admin.components.comon-modals.common-modal')
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

