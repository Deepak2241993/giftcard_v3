@extends('layouts.front-master')

@section('body')
    @push('css')
        <style>
            html, body {
                height: 100%;
                margin: 0;
                padding: 0;
            }

            body {
                display: flex;
                flex-direction: column;
                min-height: 100vh;
            }

            main {
                flex: 1;
                display: flex;
                justify-content: center;
                align-items: center;
                padding: 20px 15px;
            }

            fieldset {
                border: none;
                margin: 0;
                padding: 0;
            }

            .form-card {
                text-align: center;
                width: 100%;
                max-width: 420px;
                padding: 40px 30px;
                background-color: #fff;
                border-radius: 16px;
                box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
                position: relative;
            }

            .icon-failed {
                background-color: #ffeded;
                border-radius: 50%;
                padding: 20px;
                display: inline-block;
                margin-bottom: 20px;
                box-shadow: 0 0 12px rgba(255, 0, 0, 0.3);
                animation: pulse 1.2s infinite;
            }

            .icon-failed i {
                color: red;
                font-size: 28px;
            }

            @keyframes pulse {
                0% {
                    transform: scale(1);
                    box-shadow: 0 0 12px rgba(255, 0, 0, 0.3);
                }
                50% {
                    transform: scale(1.05);
                    box-shadow: 0 0 20px rgba(255, 0, 0, 0.5);
                }
                100% {
                    transform: scale(1);
                    box-shadow: 0 0 12px rgba(255, 0, 0, 0.3);
                }
            }

            .form-card h4 {
                font-size: 22px;
                font-weight: 700;
                color: #d9534f;
                margin-bottom: 15px;
            }

            .form-card p {
                font-size: 16px;
                color: #444;
                margin-bottom: 30px;
                line-height: 1.5;
            }

            .form-card a {
                text-decoration: none;
            }

            .form-card .btn-primary {
                background-color: #d9534f;
                border: none;
                padding: 10px 25px;
                border-radius: 25px;
                font-weight: 600;
                color: #fff;
                transition: background-color 0.3s ease;
                box-shadow: 0 4px 10px rgba(217, 83, 79, 0.2);
            }

            .form-card .btn-primary:hover {
                background-color: #c9302c;
            }

            @media screen and (max-width: 768px) {
                .form-card {
                    padding: 30px 20px;
                }

                .form-card h4 {
                    font-size: 20px;
                }

                .form-card p {
                    font-size: 15px;
                }
            }

            @media print {
                body * {
                    visibility: hidden;
                }

                #printableContent,
                #printableContent * {
                    visibility: visible;
                }

                #printableContent {
                    position: absolute;
                    left: 0;
                    top: 0;
                }
            }
        </style>

        {{-- Font Awesome CDN (for icons) --}}
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    @endpush

    <main>
        <div class="form-card" id="printableContent">
            {{-- Alert Icon --}}
            <div class="icon-failed">
                <i class="fas fa-exclamation-circle"></i>
            </div>

            {{-- Title --}}
            <h4>The Payment has failed.</h4>

            {{-- Message --}}
            <p>
                Please consult the Medspa Wellness Centre<br>
                via Email:
                <a href="mailto:admin@forevermedspanj.com"><strong>admin@forevermedspanj.com</strong></a>
            </p>

            {{-- Home Button --}}
            <a href="{{ url('/') }}" class="btn btn-primary">Home</a>

            {{-- Session Error --}}
            @if (session('error'))
                <div class="alert alert-danger mt-3">
                    {{ session('error') }}
                </div>
            @endif
        </div>
    </main>
@endsection
