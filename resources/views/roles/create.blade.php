@extends('layouts.dashboard')
@section('content')
<h2 style="margin-top: 10pt;">
    Create New Role
</h2>

{{-- @if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif --}}

<form action="{{ route('roles.store') }}" method="post">
    @csrf
    @include('roles._form')
</form>
@endsection
