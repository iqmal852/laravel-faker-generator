@extends('laravel-faker-generator::app')

@section('content')
<div class="card-header">
    <span class="float-md-left"> <h3>Table List</h3>  </span>

    <span class="float-md-right"><a href="{{ route('laravel-faker-generator.index') }}" class="btn btn-info text-white">Back</a></span>
</div>

<div class="card-body">
    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Table(s)</th>
            <th scope="col">Create Faker</th>
        </tr>
        </thead>
        <tbody>
        @foreach($tables as $table)
        <tr>
            <th scope="row">{{ @++$x }}</th>
            <td>{{ $table }}</td>
            <td>
                <a href="{{ route('laravel-faker-generator.create.faker', ['table' => $table]) }}"
                   class="btn btn-success btn-sm">
                    <svg class="bi bi-plus" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor"
                         xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                              d="M8 3.5a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-.5.5H4a.5.5 0 0 1 0-1h3.5V4a.5.5 0 0 1 .5-.5z"/>
                        <path fill-rule="evenodd"
                              d="M7.5 8a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1H8.5V12a.5.5 0 0 1-1 0V8z"/>
                    </svg>
                </a>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
