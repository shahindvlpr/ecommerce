@extends('layouts.admin')

@section('title', 'Edit Category')

@section('content')

<div class="container">

    <div class="card">

        <div class="card-header">
            <h4>Edit Category</h4>
        </div>

        <div class="card-body">

            <form action="{{ route('categories.update',$category->id) }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <div class="mb-3">

                    <label class="form-label">

                        Category Name

                    </label>

                    <input type="text"
                           name="name"
                           class="form-control"
                           value="{{ old('name',$category->name) }}">

                </div>

                <div class="mb-3">

                    <label class="form-label">

                        Current Icon

                    </label>

                    <br>

                    @if($category->icon)

                        <img src="{{ asset('storage/'.$category->icon) }}"
                             width="80">

                    @else

                        No Image

                    @endif

                </div>

                <div class="mb-3">

                    <label class="form-label">

                        Change Icon

                    </label>

                    <input type="file"
                           name="icon"
                           class="form-control">

                </div>

                <div class="mb-3">

                    <label class="form-label">

                        Status

                    </label>

                    <select name="status"
                            class="form-select">

                        <option value="1"
                        {{ $category->status == 1 ? 'selected' : '' }}>
                            Active
                        </option>

                        <option value="0"
                        {{ $category->status == 0 ? 'selected' : '' }}>
                            Inactive
                        </option>

                    </select>

                </div>

                <button type="submit"
                        class="btn btn-primary">

                    Update Category

                </button>

                <a href="{{ route('categories.index') }}"
                   class="btn btn-secondary">

                    Back

                </a>

            </form>

        </div>

    </div>

</div>

@endsection