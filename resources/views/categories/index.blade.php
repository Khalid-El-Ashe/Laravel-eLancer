@extends('layouts.dashboard')
@section('content')
<h1 class="mb-3">Categories</h1>
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
                <th>CREATED AT</th>
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
                <td>{{$category->created_at}}</td>
                <td>
                    <div class="btn-group">
                        <a href="{{ route('categories.edit', $category->id) }}"
                            class="btn btn-sm btn-outline-success">Edit</a>

                        <form action="{{ route('categories.destroy', $category->id) }}" method="post">
                            @csrf
                            <!-- Form Method Spoofing -->
                            {{-- <input type="hidden" name="_method" value="delete"> --}}
                            @method('delete')
                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
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