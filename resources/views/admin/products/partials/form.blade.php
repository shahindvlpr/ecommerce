<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label fw-bold">Product Name <span class="text-danger">*</span></label>
            <input type="text" name="name" 
                   class="form-control form-control-lg @error('name') is-invalid @enderror" 
                   placeholder="Enter product name" 
                   value="{{ old('name', $product->name ?? '') }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label fw-bold">Slug</label>
            <input type="text" name="slug" 
                   class="form-control @error('slug') is-invalid @enderror" 
                   placeholder="auto-generated from name" 
                   value="{{ old('slug', $product->slug ?? '') }}">
            <small class="text-muted">Leave empty to auto-generate</small>
            @error('slug')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-4">
        <div class="mb-3">
            <label class="form-label fw-bold">Category <span class="text-danger">*</span></label>
            <select name="category_id" class="form-control @error('category_id') is-invalid @enderror" required>
                <option value="">Select Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" 
                        {{ old('category_id', $product->category_id ?? '') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-4">
        <div class="mb-3">
            <label class="form-label fw-bold">Brand</label>
            <select name="brand_id" class="form-control @error('brand_id') is-invalid @enderror">
                <option value="">Select Brand</option>
                @foreach($brands as $brand)
                    <option value="{{ $brand->id }}" 
                        {{ old('brand_id', $product->brand_id ?? '') == $brand->id ? 'selected' : '' }}>
                        {{ $brand->name }}
                    </option>
                @endforeach
            </select>
            @error('brand_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-4">
        <div class="mb-3">
            <label class="form-label fw-bold">SKU</label>
            <input type="text" name="sku" 
                   class="form-control @error('sku') is-invalid @enderror" 
                   placeholder="Product SKU" 
                   value="{{ old('sku', $product->sku ?? '') }}">
            @error('sku')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-3">
        <div class="mb-3">
            <label class="form-label fw-bold">Price <span class="text-danger">*</span></label>
            <input type="number" name="price" 
                   class="form-control @error('price') is-invalid @enderror" 
                   placeholder="0.00" 
                   value="{{ old('price', $product->price ?? '') }}" 
                   step="0.01" required>
            @error('price')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-3">
        <div class="mb-3">
            <label class="form-label fw-bold">Sale Price</label>
            <input type="number" name="sale_price" 
                   class="form-control @error('sale_price') is-invalid @enderror" 
                   placeholder="0.00" 
                   value="{{ old('sale_price', $product->sale_price ?? '') }}" 
                   step="0.01">
            <small class="text-muted">Leave empty if not on sale</small>
            @error('sale_price')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-3">
        <div class="mb-3">
            <label class="form-label fw-bold">Stock <span class="text-danger">*</span></label>
            <input type="number" name="stock" 
                   class="form-control @error('stock') is-invalid @enderror" 
                   placeholder="0" 
                   value="{{ old('stock', $product->stock ?? 0) }}" required>
            @error('stock')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-3">
        <div class="mb-3">
            <label class="form-label fw-bold">Status</label>
            <div class="form-check form-switch mt-2">
                <input type="checkbox" name="status" class="form-check-input" 
                       id="statusSwitch" value="1" 
                       {{ old('status', $product->status ?? true) ? 'checked' : '' }}>
                <label class="form-check-label fw-semibold" for="statusSwitch">
                    <span id="statusLabel" class="badge {{ old('status', $product->status ?? true) ? 'bg-success' : 'bg-secondary' }}">
                        {{ old('status', $product->status ?? true) ? 'Active' : 'Inactive' }}
                    </span>
                </label>
            </div>
            <small class="text-muted">Inactive products won't be visible on the store</small>
        </div>
    </div>

    <div class="col-md-12">
        <div class="mb-3">
            <label class="form-label fw-bold">Short Description</label>
            <input type="text" name="short_description" 
                   class="form-control @error('short_description') is-invalid @enderror" 
                   placeholder="Brief product description" 
                   value="{{ old('short_description', $product->short_description ?? '') }}">
            @error('short_description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-12">
        <div class="mb-3">
            <label class="form-label fw-bold">Description</label>
            <textarea name="description" 
                      class="form-control @error('description') is-invalid @enderror" 
                      rows="5" 
                      placeholder="Full product description">{{ old('description', $product->description ?? '') }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label fw-bold">Featured Product</label>
            <div class="form-check form-switch mt-2">
                <input type="checkbox" name="featured" class="form-check-input" 
                       id="featuredSwitch" value="1" 
                       {{ old('featured', $product->featured ?? 0) ? 'checked' : '' }}>
                <label class="form-check-label" for="featuredSwitch">
                    {{ old('featured', $product->featured ?? 0) ? 'Yes' : 'No' }}
                </label>
            </div>
            <small class="text-muted">Featured products will be highlighted on the homepage</small>
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label fw-bold">Trending Product</label>
            <div class="form-check form-switch mt-2">
                <input type="checkbox" name="trending" class="form-check-input" 
                       id="trendingSwitch" value="1" 
                       {{ old('trending', $product->trending ?? 0) ? 'checked' : '' }}>
                <label class="form-check-label" for="trendingSwitch">
                    {{ old('trending', $product->trending ?? 0) ? 'Yes' : 'No' }}
                </label>
            </div>
            <small class="text-muted">Trending products will appear in trending sections</small>
        </div>
    </div>

    <div class="col-md-12">
        <div class="mb-3">
            <label class="form-label fw-bold">Product Image</label>
            
            @if(isset($product) && $product->thumbnail)
                <div class="mb-2">
                    <img src="{{ $product->thumbnail_url }}" 
                         alt="{{ $product->name }}" 
                         style="max-width: 200px; max-height: 200px; object-fit: contain; border-radius: 8px; border: 1px solid #e5e7eb;">
                    <br>
                    <small class="text-muted">Current image</small>
                </div>
            @endif
            
            <input type="file" name="thumbnail" 
                   class="form-control @error('thumbnail') is-invalid @enderror" 
                   accept="image/*">
            <small class="text-muted">Recommended: 500x500px, max 2MB. Leave empty to keep current image.</small>
            @error('thumbnail')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<hr>

<div class="d-flex gap-2">
    <button type="submit" class="btn btn-primary btn-lg">
        <i class="fas fa-save me-2"></i> {{ isset($product) ? 'Update' : 'Create' }} Product
    </button>
    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary btn-lg">
        Cancel
    </a>
</div>

<script>
    // Status toggle
    document.getElementById('statusSwitch')?.addEventListener('change', function() {
        const label = document.getElementById('statusLabel');
        if (this.checked) {
            label.textContent = 'Active';
            label.className = 'badge bg-success';
        } else {
            label.textContent = 'Inactive';
            label.className = 'badge bg-secondary';
        }
    });

    // Auto-generate slug
    document.querySelector('input[name="name"]')?.addEventListener('input', function() {
        const slugInput = document.querySelector('input[name="slug"]');
        if (slugInput && !slugInput.value) {
            slugInput.value = this.value
                .toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-');
        }
    });
</script>

<style>
    .form-check-input:checked {
        background-color: #8b5cf6;
        border-color: #8b5cf6;
    }
    .form-check-input:focus {
        border-color: #8b5cf6;
        box-shadow: 0 0 0 0.2rem rgba(139, 92, 246, 0.25);
    }
</style>