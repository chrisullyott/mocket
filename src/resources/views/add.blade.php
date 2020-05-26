@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Add New Item') }}</div>

                <div class="card-body">
                    <form method="POST" action="/item/">
                        @csrf
                        <div class="form-group row">
                            <div class="col-md-10">
                                <input id="url" type="url" class="form-control" name="url" required placeholder="URL" autocomplete="url" autofocus>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary">{{ __('Add') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
