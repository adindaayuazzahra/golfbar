@extends('layout.web')
@section('cssPage')
<style>
    #canvas {
        height: 100vh;
    }
</style>
@endsection
@section('content')
<div class="card p-5 rounded">
    <div class="card-body">
        @if (session('error'))
        <div class="alert alert-warning alert-dismissible fade show mb-3" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        <form action="{{ route('login.do') }}" method="POST">
            {{ csrf_field() }}
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username"
                    autocomplete="off">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password"
                    placeholder="Enter your password">
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>
</div>
@endsection