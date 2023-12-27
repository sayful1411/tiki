@extends('layouts.frontend')

@section('content')
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card custom-bg w-100 p-4 mt-5 d-flex">
                <div class="row">
                    <div class="pb-3 h3 text-left">Bus Search &#128652;</div>
                </div>
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                <form id="flight-form" action="{{ route('frontend.search') }}" method="GET" onsubmit="return validateForm()">
                    <div class="row">
                        {{-- <input type="hidden" name="search"> --}}
                        <div class="form-group col-md align-items-start flex-column">
                            <label for="fromCity" class="d-inline-flex">From</label>
                            <select name="fromCity" class="form-select" id="fromCity"
                                onchange="javascript: dynamicDropDown(this.options[this.selectedIndex].value);">
                                <option selected disabled>Select a City</option>
                                @foreach ($locations as $location)
                                    <option value="{{ $location->name }}" @selected(old('fromCity') == $location->name)>
                                        {{ $location->name }}</option>
                                @endforeach
                            </select>
                            @error('fromCity')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md align-items-start flex-column">
                            <label for="toCity" class="d-inline-flex">To</label>
                            <select name="toCity" class="form-select" id="toCity"
                                onchange="javascript: dynamicDropDown(this.options[this.selectedIndex].value);">
                                <option selected disabled>Select a City</option>
                                @foreach ($locations as $location)
                                    <option value="{{ $location->name }}" @selected(old('toCity') == $location->name)>
                                        {{ $location->name }}</option>
                                @endforeach
                            </select>
                            @error('toCity')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md align-items-start flex-column">
                            <label for="departure-date" class=" d-inline-flex">Travel date</label>
                            <input type="date" class="form-control" id="departure-date" name="departure-date"
                                onkeydown="return true" value="{{ old('departure-date') }}">
                            @error('departure-date')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md align-items-start flex-column">
                            <label for="return-date" class="d-inline-flex">Return date</label>
                            <input type="date" placeholder="Round way" class="form-control"
                                onChange="this.setAttribute('value', this.value)" id="return-date" name="return-date"
                                value="{{ old('return-date') }}">
                            @error('return-date')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="text-left col-auto">
                            <button type="submit" class="btn btn-primary">Search Buses</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <style>
        .form-group {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 20px;
        }

        label {
            width: 100px;
            text-align: right;
            margin-right: 5px;
            margin-left: 5px;
        }

        .sublabel {
            color: gray;
            margin: 4px;
            font-size: 11px;
        }

        input[type="text"],
        input[type="date"] {
            padding: 10px;
            font-size: 14px;
        }

        button[type="submit"] {
            padding: 10px 20px;
            background-color: #0050A0;
            border: none;
            cursor: pointer;
        }

        input[type="date"] {
            position: relative;
        }

        /* input[type="date"]:before {
            content: attr(placeholder);
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: #fff;
            color: rgba(0, 0, 0, 0.65);
            pointer-events: none;
            line-height: 1.5;
            padding: 10px 0.5rem 0 0.5rem;
        } */

        input[type="date"]:focus:before,
        input[type="date"]:not([value=""]):before {
            display: none;
        }

        .custom-bg {
            background-color: #F7F7F9;
        }
    </style>
@endpush

@push('js')
    <script>
        function dynamicDropDown(listIndex) {

            document.getElementById("infants").length = 0;
            document.getElementById("children").length = 0;

            for (let i = 0; i < Number(listIndex) + 1; i++) {
                document.getElementById("infants").options[i] = new Option(i.toString(), i);
            }

            for (let i = 0; i < 9 - Number(listIndex) + 1; i++) {
                document.getElementById("children").options[i] = new Option(i.toString(), i);
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            var dtToday = new Date();
            var day = dtToday.getDate();
            var month = dtToday.getMonth() + 1;
            var year = dtToday.getFullYear();

            if (day < 10) {
                day = '0' + day.toString();
            }

            if (month < 10) {
                month = '0' + month.toString();
            }

            var maxDate = year + '-' + month + '-' + day;
            var next30Days = new Date(dtToday);
            next30Days.setDate(dtToday.getDate() + 30);

            var next30DaysDay = next30Days.getDate();
            var next30DaysMonth = next30Days.getMonth() + 1;
            var next30DaysYear = next30Days.getFullYear();

            if (next30DaysDay < 10) {
                next30DaysDay = '0' + next30DaysDay.toString();
            }

            if (next30DaysMonth < 10) {
                next30DaysMonth = '0' + next30DaysMonth.toString();
            }

            var maxNext30Days = next30DaysYear + '-' + next30DaysMonth + '-' + next30DaysDay;

            var departureDate = document.getElementById('departure-date');
            departureDate.setAttribute('min', maxDate);
            departureDate.setAttribute('max', maxNext30Days);

            var returnDate = document.getElementById('return-date');
            returnDate.setAttribute('min', maxDate);
            returnDate.setAttribute('max', maxNext30Days);
        });
    </script>
@endpush
