@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <?php
                if (!empty($_GET['host'])) {
                    $subTitle = ' : Filtered';
                } elseif (!empty($_GET['favorites']) && $_GET['favorites']) {
                    $subTitle = ' : Favorites';
                } else {
                    $subTitle = '';
                }
                ?>
                <div class="card-header">Saved Items{{ $subTitle }}</div>

                <div class="card-body">

                        @each('partials.list-item', $items, 'item')

                </div><!-- card-body -->
            </div>
        </div>
    </div>
</div>
@endsection
