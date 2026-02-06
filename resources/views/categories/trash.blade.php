@extends('layouts.dashboard')
@section('content')
<h1 class="mb-3">Categories Trash</h1>
<div class="d-grid gap-2 d-md-flex justify-content-md-end">
    <small><a class="btn btn-primary" href="{{ route('categories.create') }}">New Category</a></small>
</div>

<x-flash-message />

<div class="table-responsive" style="margin-top: 5px">
    <table class="table table-bordered border-success">
        <thead class="table-success">
            <tr>
                <th>ID</th>
                <th>NAME</th>
                <th>SLUG</th>
                <th>PARENT ID</th>
                <th>DELETED AT</th>
                <th>ACTION</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
            <tr>
                <td>{{$category->id}}</td>
                <td><a href="{{route('categories.show', $category->id)}}">{{$category->name}}</a></td>
                <td>{{$category->slug}}</td>
                <td>{{$category->parent_name ?? 'no parent'}}</td>
                <td>{{$category->deleted_at}}</td>
                <td>
                    <div class="btn-group">
                        <form action="{{ route('categories.restore', $category->id) }}" method="post">
                            @csrf
                            @method('put')
                            <button type="submit" class="btn btn-sm btn-outline-info">Restore</button>
                        </form>

                        <form action="{{ route('categories.forceDelete', $category->id) }}" method="post">
                            @csrf
                            <!-- Form Method Spoofing -->
                            {{-- <input type="hidden" name="_method" value="delete"> --}}
                            @method('delete')
                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete For Ever</button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
{{ $categories->links() }}
@endsection