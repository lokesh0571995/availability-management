@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 class="mb-4 text-center">Category List</h1>

            <!-- Success Message -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            <div class="mb-4 text-center">
                <a
                    href="{{ url('/admin/categories/create') }}"
                    class="rounded-md px-4 py-2 bg-blue-500 transition hover:bg-blue-600 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 dark:bg-blue-700 dark:hover:bg-blue-800"
                >
                    Add New Category
                </a>
            </div>

            @if($categories && $categories->count())
                <ul class="list-group">
                    @foreach($categories as $category)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                      
                            {{ $category->name }}
                            <!-- Optionally, you can add edit/delete buttons here -->
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="alert alert-warning text-center">
                    No Category Available
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
