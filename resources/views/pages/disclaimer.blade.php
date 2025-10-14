@extends('layouts.app')

@section('title', 'Disclaimer | QwikHom')

@section('styles')
    <style>
        body {
            background-color: black !important;
            color: white !important;
        }

        .card {
            background-color: #333 !important;
            border-color: #666 !important;
        }

        .card-title,
        .card-text {
            color: white !important;
        }
    </style>
@endsection

@section('content')
    <div class="container my-5">
        <div class="row">
            @foreach ($disclaimers as $disclaimer)
                <div class="col-md-12">
                    <h1 class="mb-4">{{ $disclaimer->title }}</h1>
                    <div class="card">
                        <div class="card-body">

                            <p class="card-text">
                                {{ $disclaimer->content }}
                            </p>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
