@extends('layouts.main')

@section('title', 'Login page')

@section('content')

<h1 class="h2">Login Form</h1>

<form action="{{route('login.auth')}}" method="post">
            @csrf
        
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input name="email" type="email" class="form-control" id="email" placeholder="Email">
          
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input name="password" type="password" class="form-control " id="password" placeholder="Password">
                     
            </div>
          
           
            <div class="form-check mb-3">
                <input name="remember" class="form-check-input" type="checkbox"  id="remember">
                <label class="form-check-label" for="remember">
                   Remember me
                </label>
            </div>

             <button type="submit" class="btn btn-primary">Login</button>
        </form>
@endsection