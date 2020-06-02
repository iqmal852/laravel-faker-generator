@extends('laravel-faker-generator::app')

@section('content')
<div class="card-header">
    <span class="float-md-left"> <h3>Generate Faker</h3>  </span>

    <span class="float-md-right"><a href="{{ route('laravel-faker-generator.create') }}" class="btn btn-info text-white">Back</a></span>
</div>

<div class="card-body">
    <form action="{{ route('laravel-faker-generator.generate.faker', [ 'table' => $table ]) }}" method="post">
        {{ csrf_field() }}
        @foreach($columns as $key => $value)
        <div class="form-group">
            <div class="row">
                <div class="col">
                    <label for="">{{ $key }} (<i> {{$value}} </i> )</label>
                </div>
                <div class="col">
                    <select name="{{ $key }}" class="form-control selection2">
                        <option value="" selected> Please Select </option>
                        <optgroup label="Primary">
                            <option value="increment">Auto-Increment</option>
                        </optgroup>
                        <optgroup label="String">
                            <option value="name">Random String</option>
                            <option value="name">Name</option>
                            <option value="email">Email (Unique)</option>
                            <option value="address">Address</option>
                            <option value="password">Password</option>
                        </optgroup>
                        <optgroup label="Integer">
                        </optgroup>
                        <optgroup label="Text">
                        </optgroup>
                        <optgroup label="Datetime">
                            <option value="now">Now</option>
                        </optgroup>
<!--                        <optgroup label="Random Data From Table">-->
<!--                            @foreach($tables as $table)-->
<!--                            <option value="{{ $table }}"> {{ $table }} </option>-->
<!--                            @endforeach-->
<!--                        </optgroup>-->
                    </select>
                </div>
            </div>
        </div>
        <hr>
        @endforeach

        <div class="form-group">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="truncate" value="true" id="truncate">
                <label class="form-check-label" for="truncate">
                    Truncate Before Populate Fake Data
                </label>
            </div>
        </div>
        <div class="form-group">
            <label for="rows">Number of Rows (Records)</label>
            <input type="number" class="form-control" name="rows" id="rows" value="100">
            <small id="emailHelp" class="form-text text-muted">Number of fake data that going to be generate. Current limit is 100k, if you need more, please untick Truncate option and you will be able to re-run Faker.</small>
        </div>
        <div class="form-group float-right">
            <button type="submit" class="btn btn-success">Generate</button>
        </div>
    </form>
</div>
@endsection
