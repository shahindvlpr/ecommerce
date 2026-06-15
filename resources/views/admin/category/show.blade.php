@extends('layouts.admin')

@section('title','Category Details')

@section('content')

<div class="container">

    <div class="card">

        <div class="card-header">

            <h4>

                Category Details

            </h4>

        </div>

        <div class="card-body">

            <table class="table table-bordered">

                <tr>
                    <th>ID</th>
                    <td>{{ $category->id }}</td>
                </tr>

                <tr>
                    <th>Name</th>
                    <td>{{ $category->name }}</td>
                </tr>

                <tr>
                    <th>Slug</th>
                    <td>{{ $category->slug }}</td>
                </tr>

                <tr>
                    <th>Status</th>
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
                </tr>

                <tr>
                    <th>Icon</th>

                    <td>

                        @if($category->icon)

                            <img src="{{ asset('storage/'.$category->icon) }}"
                                 width="100">

                        @else

                            No Image

                        @endif

                    </td>
                </tr>

                <tr>
                    <th>Created At</th>
                    <td>{{ $category->created_at }}</td>
                </tr>

                <tr>
                    <th>Updated At</th>
                    <td>{{ $category->updated_at }}</td>
                </tr>

            </table>

            <a href="{{ route('categories.index') }}"
               class="btn btn-primary">

                Back

            </a>

        </div>

    </div>

</div>

@endsection