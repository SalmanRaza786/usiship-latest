@extends('layouts.master')
@section('title') Carriers @endsection
@section('content')
<style>
    #toastPlacement {
        display: none;
    }
</style>

<button onclick="showToast()">Show Toast</button>
@endsection

<script>
    function showToast() {
        var toastPlacement = $('#toastPlacement');
        toastPlacement.show(); // Show the toast container
        var toastEl = new bootstrap.Toast($('#myToast'));
        toastEl.show();
        toastEl._element.addEventListener('hidden.bs.toast', function () {
            toastPlacement.hide(); // Hide the toast container when the toast is hidden
        });
    }
</script>

