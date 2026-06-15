@extends('layouts.admin')

@section('title','Dashboard')

@section('content')

<div class="row">

    <div class="col-md-3">

        <div class="card bg-primary text-white">

            <div class="card-body">

                <h5>Total Categories</h5>

                <h2>
                    {{ \App\Models\Category::count() }}
                </h2>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card bg-success text-white">

            <div class="card-body">

                <h5>Total Products</h5>

                <h2>
                    {{ \App\Models\Product::count() }}
                </h2>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card bg-warning text-white">

            <div class="card-body">

                <h5>Total Orders</h5>

                <h2>
                    {{ \App\Models\Order::count() }}
                </h2>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card bg-danger text-white">

            <div class="card-body">

                <h5>Total Users</h5>

                <h2>
                    {{ \App\Models\User::count() }}
                </h2>

            </div>

        </div>

    </div>

</div>

@endsection