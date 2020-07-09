@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header"><a href="/">&larr; go back</a></div>

                <div class="card-body">

                    <h3>{{ $item->meta->title }}</h3>

                    <p>
                        <em>{{ $item->meta->host }}</em>
                    </p>

                    <p>
                        <strong>Description</strong>
                        <br>
                        {{ $item->meta->description }}
                    </p>

                    <p>
                        <strong>Link</strong>
                        <br>
                        <a href="{{ $item->url }}" target="_blank">{{ $item->url }}</a>
                    </p>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
