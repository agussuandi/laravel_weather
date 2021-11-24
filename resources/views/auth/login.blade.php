@extends('layouts.app')
@section('content')
    <form action="{{ url('/login') }}" method="POST">
        @csrf
        <div class="m-5 p-5">
            <div class="form-group mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required placeholder="Masukan username" autofocus autocomplete="off" maxlength="25" />
            </div>
            <div class="form-group mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required placeholder="Masukan password" />
            </div>
            <div class="form-group mb-3">
                <button type="submit" class="btn btn-primary">Login</button>
            </div>
        </div>
    </form>
@stop
@section('javascript')

@endsection