@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Saved Items{{ $subTitle }}</div>

                <div class="card-body">

                        @each('partials.list-item', $items, 'item')

                </div><!-- card-body -->
            </div>
        </div>
    </div>
</div>
@endsection
