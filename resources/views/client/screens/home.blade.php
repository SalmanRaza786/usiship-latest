@extends('client.layouts.master')
@section('title') @lang('translation.dashboards') @endsection
@section('content')
    Welcome:
    {{Auth::user()->name}}
    <h1>Dashboard</h1>
@endsection
