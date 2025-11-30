@extends('layouts.dashboard')
@section('content')
<h2 style="margin-top: 10pt;">
    Edit Category {{ $category->name }}
</h2>

<form action="{{ route('categories.update', $category->id) }}" method="post">
    @csrf
    {{-- <input type="hidden" name="_method" value="put"> this method is name spofing method --}}
    @method('put')

    @include('categories._form')
</form>
@endsection