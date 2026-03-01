@extends('web::layouts.app')

@section('content')
    <div class="container row">
        <div class="col-lg-4 offset-lg-4 mt-4">
            <div class="card">
                <div class="card-header">
                    Login
                </div>
                <div class="card-body">
                    <div>
                        @include('merlion::components.errors')
                        <form class="d-flex flex-column gap-3" action="{{route('web.login.submit')}}" method="post">
                            @csrf
                            <input class="form-control" type="text" placeholder="email" name="email">
                            <input class="form-control" type="password" placeholder="password" name="password">
                            <button type="submit" class="btn btn-primary">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
