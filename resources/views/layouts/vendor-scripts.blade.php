{{--<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>--}}
<script src="{{ URL::asset('build/js/jquery.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ URL::asset('build/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
    <script type="text/javascript" src="{{ asset('build/data-table/js/jquery.dataTables.js') }}"></script>
    <script src="{{ URL::asset('build/libs/choices.js/public/assets/scripts/choices.min.js')}}"></script>
    <script src="{{ URL::asset('build/libs/fullcalendar/main.min.js')}}"></script>
    <script src="{{ URL::asset('build/js/plugins.js') }}"></script>
    <script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
    <script src="{{ URL::asset('build/js/pages/ecommerce-product-checkout.init.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/js/pages/form-wizard.init.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>

    <script src="{{ URL::asset('build/libs/sortablejs/Sortable.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/nestable.init.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('build/libs/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/invoicecreate.init.js') }}"></script>
    <script src="{{ URL::asset('build/libs/quill/quill.min.js')}}"></script>
    <script src="{{ URL::asset('build/js/pages/form-editor.init.js')}}"></script>

    <script src="{{ URL::asset('build/js/pages/profile-setting.init.js') }}"></script>>


    <script src="{{ URL::asset('build/js/custom-js/notification/notification.js') }}"></script>



    <script src="{{ URL::asset('build/libs/glightbox/js/glightbox.min.js')}}"></script>
    <script src="{{ URL::asset('build/libs/isotope-layout/isotope.pkgd.min.js')}}"></script>
    <script src="{{ URL::asset('build/js/pages/gallery.init.js')}}"></script>

    @vite(['resources/js/app.js'])
    @yield('script')
    @yield('script-bottom')
