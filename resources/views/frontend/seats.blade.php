@extends('layouts.frontend')

@section('content')
    <div class="row">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <h1 class="my-4 text-center text-white">Book Seats</h1>

                <div class="theatre">

                    <div class="screen-side">
                        <div class="screen">Screen</div>
                        <h3 class="select-text">Please select a seat</h3>
                    </div>

                    <!-- Display validation errors and success message -->
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('book.seats', ['trip' => $trip]) }}" method="post">
                        @csrf
                        <ol class="cabin">
                            @for ($row = 1; $row <= $totalRows; $row++)
                                <li class="row row--{{ $row }}">
                                    <ol class="seats" type="1">
                                        @for ($seatNumber = 1; $seatNumber <= $seatsPerRow; $seatNumber++)
                                            @php
                                                $seatId = ($row - 1) * $seatsPerRow + $seatNumber;
                                                $disabled = in_array($seatId, $bookedSeats) ? 'disabled' : '';
                                            @endphp

                                            <li class="seat">
                                                <input type="checkbox" name="selectedSeats[]" id="{{ $seatId }}"
                                                    value="{{ $seatId }}" {{ $disabled }} />
                                                <label for="{{ $seatId }}">{{ $seatId }}</label>
                                            </li>
                                        @endfor
                                    </ol>
                                </li>
                            @endfor
                        </ol>
                        <button class="btn btn-primary mt-4" type="submit">Book Selected Seats</button>
                    </form>

                </div>

            </div>
        </div>
    </div>
    </div>
@endsection

@push('css')
    <style>
        *,
        *:before,
        *:after {
            box-sizing: border-box;
        }

        ::selection {
            background-color: #eee;
        }

        ::-moz-selection {
            background-color: #eee;
        }

        body {
            font-size: 16px;
            background-color: #269686;
        }

        .theatre {
            margin: 20px auto;
            width: 100%;
            max-width: 350px;
            border-radius: 5px;
            background-color: #fff;
            padding: 20px 10px;
            box-shadow: 0px 0px 17px -4px #000;
        }

        .screen-side {
            text-align: center;
        }

        .screen-side .screen {
            height: 25px;
            margin: 0 20px;
            border-radius: 50%;
            box-shadow: 0px -3px 0px 1px #ccc;
            color: #ccc;
        }

        .screen-side .select-text {
            color: #969696;
        }

        .exit {
            position: relative;
            height: 50px;
        }

        .exit:before,
        .exit:after {
            content: "EXIT";
            font-size: 14px;
            line-height: 18px;
            padding: 0px 5px;
            font-family: "Arial Narrow", Arial, sans-serif;
            display: block;
            position: absolute;
            background: #81c784;
            color: white;
            top: 50%;
            transform: translate(0, -50%);
        }

        .exit:before {
            left: 0;
        }

        .exit:after {
            right: 0;
        }

        ol {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .seats {
            display: flex;
            flex-direction: row;
            flex-wrap: nowrap;
            justify-content: flex-start;
        }

        .seat {
            display: flex;
            flex: 0 0 14.28571%;
            padding: 5px;
            position: relative;
        }

        .seat:nth-child(3) {
            margin-right: 14.28571%;
        }

        .seat input[type="checkbox"] {
            position: absolute;
            opacity: 0;
        }

        .seat input[type="checkbox"]:checked+label {
            background: #bada55;
            -webkit-animation-name: rubberBand;
            animation-name: rubberBand;
            animation-duration: 300ms;
            animation-fill-mode: both;
        }

        .seat input[type="checkbox"]:disabled+label {
            background: #ddd;
            text-indent: -9999px;
            overflow: hidden;
        }

        .seat input[type="checkbox"]:disabled+label:after {
            content: "X";
            text-indent: 0;
            position: absolute;
            top: 4px;
            left: 50%;
            transform: translate(-50%, 0%);
        }

        .seat input[type="checkbox"]:disabled+label:hover {
            box-shadow: none;
            cursor: not-allowed;
        }

        .seat label {
            display: block;
            position: relative;
            width: 100%;
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            line-height: 1.5rem;
            padding: 4px 0;
            color: #fff;
            background: #26a69a;
            border-radius: 2px;
            animation-duration: 300ms;
            animation-fill-mode: both;
            transition-duration: 300ms;
        }

        .seat label:hover {
            cursor: pointer;
            box-shadow: 0px 0 7px 3px #ccc;
        }

        @-webkit-keyframes rubberBand {
            0% {
                -webkit-transform: scale3d(1, 1, 1);
                transform: scale3d(1, 1, 1);
            }

            30% {
                -webkit-transform: scale3d(1.25, 0.75, 1);
                transform: scale3d(1.25, 0.75, 1);
            }

            40% {
                -webkit-transform: scale3d(0.75, 1.25, 1);
                transform: scale3d(0.75, 1.25, 1);
            }

            50% {
                -webkit-transform: scale3d(1.15, 0.85, 1);
                transform: scale3d(1.15, 0.85, 1);
            }

            65% {
                -webkit-transform: scale3d(0.95, 1.05, 1);
                transform: scale3d(0.95, 1.05, 1);
            }

            75% {
                -webkit-transform: scale3d(1.05, 0.95, 1);
                transform: scale3d(1.05, 0.95, 1);
            }

            100% {
                -webkit-transform: scale3d(1, 1, 1);
                transform: scale3d(1, 1, 1);
            }
        }

        @keyframes rubberBand {
            0% {
                -webkit-transform: scale3d(1, 1, 1);
                transform: scale3d(1, 1, 1);
            }

            30% {
                -webkit-transform: scale3d(1.25, 0.75, 1);
                transform: scale3d(1.25, 0.75, 1);
            }

            40% {
                -webkit-transform: scale3d(0.75, 1.25, 1);
                transform: scale3d(0.75, 1.25, 1);
            }

            50% {
                -webkit-transform: scale3d(1.15, 0.85, 1);
                transform: scale3d(1.15, 0.85, 1);
            }

            65% {
                -webkit-transform: scale3d(0.95, 1.05, 1);
                transform: scale3d(0.95, 1.05, 1);
            }

            75% {
                -webkit-transform: scale3d(1.05, 0.95, 1);
                transform: scale3d(1.05, 0.95, 1);
            }

            100% {
                -webkit-transform: scale3d(1, 1, 1);
                transform: scale3d(1, 1, 1);
            }
        }

        .rubberBand {
            -webkit-animation-name: rubberBand;
            animation-name: rubberBand;
        }
    </style>
@endpush
