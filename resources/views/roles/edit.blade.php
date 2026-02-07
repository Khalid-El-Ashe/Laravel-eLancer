@extends('layouts.dashboard')
@section('content')
<h2 style="margin-top: 10pt;">
    Edit Role {{ $role->name }}
</h2>

<form action="{{ route('roles.update', $role->id) }}" method="post">
    @csrf
    {{-- <input type="hidden" name="_method" value="put"> this method is name spofing method --}}
    @method('put')

    @include('roles._form')
</form>
@endsection
