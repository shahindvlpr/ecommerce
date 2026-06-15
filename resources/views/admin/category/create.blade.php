@extends('layouts.admin')

@section('title', 'Create Category')

@section('content')

<div class="container">

    <div class="card">

        <div class="card-header">
            <h4>Create Category</h4>
        </div>

        <div class="card-body">

            <form action="{{ route('categories.store') }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf

                <div class="mb-3">
                    <label class="form-label">
                        Category Name
                    </label>

                    <input type="text"
                           name="name"
                           class="form-control"
                           value="{{ old('name') }}"
                           required>

                    @error('name')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Category Icon
                    </label>

                    <input type="file"
                           name="icon"
                           class="form-control">

                    @error('icon')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                    @enderror
                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Status
                    </label>

                    <select name="status"
                            class="form-select">

                        <option value="1">
                            Active
                        </option>

                        <option value="0">
                            Inactive
                        </option>

                    </select>

                </div>

                <button type="submit"
                        class="btn btn-success">

                    Save Category

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