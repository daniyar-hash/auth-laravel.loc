@extends('layouts.main')

@section('title', 'Login page')

@section('content')

<div class="alert alert-info" role="alert">
    Thank you for registering! A link to confirm your registration has been sent to your email.

</div>

<div>
    Didn't recieve the link!
    <form action="{{route('verification.send')}}" method="post">
        @csrf
        <button type="submit" class="btn btn-link ps-0">Send link</button>
    </form>
</div>



@endsection