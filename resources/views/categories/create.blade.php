@extends('layouts.dashboard')
@section('content')
<h2 style="margin-top: 10pt;">
    Create New Category
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

<form action="{{ route('categories.store') }}" method="post">
    @csrf
    @include('categories._form')
</form>
@endsection