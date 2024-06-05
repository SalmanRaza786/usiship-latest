@extends('layouts.master')
@section('title') WareHouses @endsection
@section('css')
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('routeUrl') {{url('/')}} @endslot
        @slot('li_1') Dashboard @endslot
        @slot('title') WareHouses @endslot
    @endcomponent

    <div class="row">

        <div id="loadTypeSelectBox"></div>
    </div>

@endsection


@section('script')
    <script>
        $(document).ready(function() {
            multiSelectBox();
            function multiSelectBox(){
                var html = '';
                html += '<select  class="form-select" data-choices data-choices-removeItem multiple id="status_field" required data-trigger  name="load_type_id[]">' +
                    '<option value="">Choose One</option>' +
                    '<option value="1">RTL</option>' +
                    '<option value="2">FTL</option>' +
                    '<option value="2">ATL</option>' +
                    '<option value="2">MTL</option>' +
                    '</select>';

                $('#loadTypeSelectBox').html(html);
            }


            // Initialize Choices.js for the new select element
            new Choices('#status_field', {
                removeItemButton: true,
            });
        });
    </script>
@endsection


