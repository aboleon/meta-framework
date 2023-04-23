@extends('layouts.'. (auth()->check() ? 'app' : 'front'))

@if (isset($header))
<x-slot name="header">
    <div class="p-2">
        404
    </div>
</x-slot>
@else
    @section('slot_header')
        <div class="p-2">
            404
        </div>
    @endsection
@endif

@push('css')
    <style>
        .div {
            margin-top: 20%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .div h1 {
            font-size: 50px;
            margin-bottom: 50px;
            font-weight: 700;
            line-height: 30px;
        }

        .div div {
            font-size: 22px;
        }
    </style>
@endpush

@section('slot')
<div class="div">
    <h1>404</h1>
    <div class="mb-5">
        {{ $exception->getMessage() }}
    </div>
</div>
@endsection
