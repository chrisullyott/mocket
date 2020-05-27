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
                <div class="card-header">Saved Items<?=$subTitle?></div>

                <div class="card-body">

                    @foreach ($items as $item)

                    <div class="row item">

                        <!-- First column -->
                        <div class="col-md-3">
                            <a href="{{ $item->url }}" target="_blank">
                                <figure class="figure">
                                @if ($item->meta->image_url)
                                    <img src="{{ $item->meta->image_url }}" class="figure-img img-fluid rounded" alt="thumbnail">
                                @else
                                    <img src="/images/placeholder.png" class="figure-img img-fluid rounded" alt="placeholder">
                                @endif
                                </figure>
                            </a>
                        </div>

                        <!-- Second column -->
                        <div class="col-md-6">
                            <p class="title"><a href="{{ $item->url }}" target="_blank">{{ $item->meta->title }}</a></p>
                            @if($item->meta->description)
                                <p class="description"><em>{{ $item->meta->short_host }}</em> &mdash; {{ $item->meta->description }}</p>
                            @else
                                <p class="description"><em>{{ $item->meta->short_host }}</em></p>
                            @endif
                        </div>

                        <!-- Third column -->
                        <div class="col-md-3">
                            <div class="btn-group" role="group">

                                <!-- Favorite/Unfavorite -->
                                <form action="/item/{{ $item->id }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    @if ($item->is_favorite)
                                        <input type="hidden" name="is_favorite" value="0">
                                        <button class="btn btn-primary" title="Unfavorite">
                                            <svg class="bi bi-star-fill" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/></svg>
                                        </button>
                                    @else
                                        <input type="hidden" name="is_favorite" value="1">
                                        <button class="btn btn-primary" title="Favorite">
                                            <svg class="bi bi-star" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.523-3.356c.329-.314.158-.888-.283-.95l-4.898-.696L8.465.792a.513.513 0 00-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767l-3.686 1.894.694-3.957a.565.565 0 00-.163-.505L1.71 6.745l4.052-.576a.525.525 0 00.393-.288l1.847-3.658 1.846 3.658a.525.525 0 00.393.288l4.052.575-2.906 2.77a.564.564 0 00-.163.506l.694 3.957-3.686-1.894a.503.503 0 00-.461 0z" clip-rule="evenodd"/></svg>
                                        </button>
                                    @endif
                                </form>

                                <!-- Filter -->
                                @if (!empty($_GET['host']))
                                <form action="{{ route('home') }}" method="GET">
                                    <input type="hidden" name="host" value="">
                                    <button class="btn btn-primary" title="Unfilter">
                                        <svg class="bi bi-funnel-fill" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M2 3.5v-2h12v2l-4.5 5v5l-3 1v-6L2 3.5z"/><path fill-rule="evenodd" d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5v-2zm1 .5v1.308l4.372 4.858A.5.5 0 0 1 7 8.5v5.306l2-.666V8.5a.5.5 0 0 1 .128-.334L13.5 3.308V2h-11z"/></svg>
                                    </button>
                                </form>
                                @else
                                <form action="{{ route('home') }}" method="GET">
                                    <input type="hidden" name="host" value="{{ $item->meta->host }}">
                                    <button class="btn btn-primary" title="Filter">
                                        <svg class="bi bi-funnel" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5v-2zm1 .5v1.308l4.372 4.858A.5.5 0 0 1 7 8.5v5.306l2-.666V8.5a.5.5 0 0 1 .128-.334L13.5 3.308V2h-11z"/></svg>
                                    </button>
                                </form>
                                @endif

                                <!-- Delete -->
                                <form action="/item/{{ $item->id }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-primary" title="Delete">
                                        <svg class="bi bi-trash" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M5.5 5.5A.5.5 0 016 6v6a.5.5 0 01-1 0V6a.5.5 0 01.5-.5zm2.5 0a.5.5 0 01.5.5v6a.5.5 0 01-1 0V6a.5.5 0 01.5-.5zm3 .5a.5.5 0 00-1 0v6a.5.5 0 001 0V6z"/><path fill-rule="evenodd" d="M14.5 3a1 1 0 01-1 1H13v9a2 2 0 01-2 2H5a2 2 0 01-2-2V4h-.5a1 1 0 01-1-1V2a1 1 0 011-1H6a1 1 0 011-1h2a1 1 0 011 1h3.5a1 1 0 011 1v1zM4.118 4L4 4.059V13a1 1 0 001 1h6a1 1 0 001-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" clip-rule="evenodd"/></svg>
                                    </button>
                                </form>

                            </div><!-- .row -->
                        </div>

                    </div><!-- .row -->

                    @endforeach

                </div><!-- card-body -->
            </div>
        </div>
    </div>
</div>
@endsection
