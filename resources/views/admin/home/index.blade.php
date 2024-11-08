@extends('adminlte::page')

@section('title', 'Inicio')

@section('content_header')
    <h1>Panel</h1>
@stop

@section('content')
    @livewire('admin.home-index')
@stop

@section('footer')
@stop

@section('css')
    <style>
        .footer {
            background-color: #f8f9fa;
            padding: 20px;
            bottom: 0;
            width: 100%;
            z-index: 1030; /* Ensure it is above other elements */
            box-shadow: 0 -1px 5px rgba(0,0,0,.1); /* Optional shadow for better separation */
        }
    </style>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
@stop