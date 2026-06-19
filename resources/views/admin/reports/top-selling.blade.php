@extends('layouts.admin')

@section('title', 'Top Selling Products - EktaMart Admin')

@section('content')
<div class="container-fluid px-4">
    <h4 class="fw-bold mb-4">
        <i class="fas fa-trophy text-primary me-2"></i>Top Selling Products
    </h4>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th>#</th>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Rating</th>
                            <th>Total Sold</th>
                            <th>Revenue</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topProducts as $product)
                        <tr>
                            <td>
                                @if($loop->iteration <= 3)
                                    <span class="badge bg-warning rounded-circle p-2">🏆</span>
                                @else
                                    <span>{{ $loop->iteration }}</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <img src="{{ $product->thumbnail_url ?? asset('images/default-product.png') }}" 
                                         alt="{{ $product->name }}" 
                                         style="width: 40px; height: 40px; object-fit: cover; border-radius: 8px;">
                                    <span>{{ $product->name }}</span>
                                </div>
                            </td>
                            <td>${{ number_format($product->price, 2) }}</td>
                            <td>
                                @php $rating = round($product->rating ?? 0); @endphp
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= $rating ? 'text-warning' : 'text-muted' }}" style="font-size: 0.7rem;"></i>
                                @endfor
                            </td>
                            <td class="fw-bold">{{ $product->total_sold }}</td>
                            <td class="fw-bold text-success">${{ number_format($product->total_revenue, 2) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-3">No data available</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection