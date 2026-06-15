@extends('layouts.admin')

@section('title', 'Category List')

@section('content')

<div class="container-fluid">

    <div class="card">

        <div class="card-header d-flex justify-content-between align-items-center">

            <h4 class="mb-0">
                Category Management
            </h4>

            <a href="{{ route('categories.create') }}"
               class="btn btn-primary">

                Add Category

            </a>

        </div>

        <div class="card-body">

            @if(session('success'))

                <div class="alert alert-success">

                    {{ session('success') }}

                </div>

            @endif

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-dark">

                        <tr>

                            <th>ID</th>

                            <th>Image</th>

                            <th>Name</th>

                            <th>Slug</th>

                            <th>Status</th>

                            <th width="220">
                                Action
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($categories as $category)

                            <tr>

                                <td>
                                    {{ $category->id }}
                                </td>

                                <td>

                                    @if($category->icon)

                                        <img src="{{ asset('storage/'.$category->icon) }}"
                                             width="60"
                                             height="60"
                                             class="rounded">

                                    @else

                                        <span class="text-muted">
                                            No Image
                                        </span>

                                    @endif

                                </td>

                                <td>
                                    {{ $category->name }}
                                </td>

                                <td>
                                    {{ $category->slug }}
                                </td>

                                <td>

                                    @if($category->status)

                                        <span class="badge bg-success">

                                            Active

                                        </span>

                                    @else

                                        <span class="badge bg-danger">

                                            Inactive

                                        </span>

                                    @endif

                                </td>

                                <td>

                                    <a href="{{ route('categories.show', $category->id) }}"
                                       class="btn btn-info btn-sm">

                                        View

                                    </a>

                                    <a href="{{ route('categories.edit', $category->id) }}"
                                       class="btn btn-warning btn-sm">

                                        Edit

                                    </a>

                                    <form action="{{ route('categories.destroy', $category->id) }}"
                                          method="POST"
                                          class="d-inline">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn btn-danger btn-sm"
                                                onclick="return confirm('Are you sure you want to delete this category?')">

                                            Delete

                                        </button>

                                    </form>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6"
                                    class="text-center text-danger">

                                    No Categories Found

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="mt-3">

                {{ $categories->links() }}

            </div>

        </div>

    </div>

</div>

@endsection