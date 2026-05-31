@extends('layouts.main')

@section('title', 'Login page')

@section('content')

<h1 class="h2">Reset Password</h1>

<form action="{{route('password.update')}}" method="post">
            @csrf
        <input type="hidden" name="token", value="{{ $token}}">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input name="email"
                 type="email" class="form-control @error('email') is-invalid @enderror"
                  id="email" 
                  placeholder="Email">
             @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input name="password" type="password" class="form-control " id="password" placeholder="Password">
                     
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Password Confirm</label>
                <input name="password_confirmation" type="password" class="form-control" id="password_confirmation" placeholder="Password Confirm">
            </div>
           
             <button type="submit" class="btn btn-primary">Reset password</button>
        </form>
@endsection