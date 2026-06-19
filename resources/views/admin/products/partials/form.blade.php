<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label fw-bold">Product Name <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                   placeholder="Enter product name" value="{{ old('name', $product->name ?? '') }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label fw-bold">Slug</label>
            <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" 
                   placeholder="auto-generated from name" value="{{ old('slug', $product->slug ?? '') }}">
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
                @foreach($categories ?? [] as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id ?? '') == $category->id ? 'selected' : '' }}>
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
                @foreach($brands ?? [] as $brand)
                    <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id ?? '') == $brand->id ? 'selected' : '' }}>
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
            <input type="text" name="sku" class="form-control @error('sku') is-invalid @enderror" 
                   placeholder="Product SKU" value="{{ old('sku', $product->sku ?? '') }}">
            @error('sku')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-12">
        <div class="mb-3">
            <label class="form-label fw-bold">Short Description</label>
            <input type="text" name="short_description" class="form-control @error('short_description') is-invalid @enderror" 
                   placeholder="Brief product description" value="{{ old('short_description', $product->short_description ?? '') }}">
            @error('short_description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-12">
        <div class="mb-3">
            <label class="form-label fw-bold">Description</label>
            <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                      rows="5" placeholder="Full product description">{{ old('description', $product->description ?? '') }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-3">
        <div class="mb-3">
            <label class="form-label fw-bold">Price <span class="text-danger">*</span></label>
            <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" 
                   placeholder="0.00" value="{{ old('price', $product->price ?? '') }}" step="0.01" required>
            @error('price')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-3">
        <div class="mb-3">
            <label class="form-label fw-bold">Sale Price</label>
            <input type="number" name="sale_price" class="form-control @error('sale_price') is-invalid @enderror" 
                   placeholder="0.00" value="{{ old('sale_price', $product->sale_price ?? '') }}" step="0.01">
            @error('sale_price')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-3">
        <div class="mb-3">
            <label class="form-label fw-bold">Stock <span class="text-danger">*</span></label>
            <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror" 
                   placeholder="0" value="{{ old('stock', $product->stock ?? 0) }}" required>
            @error('stock')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-3">
        <div class="mb-3">
            <label class="form-label fw-bold">Status</label>
            <select name="status" class="form-control @error('status') is-invalid @enderror">
                <option value="1" {{ old('status', $product->status ?? 1) ? 'selected' : '' }}>Active</option>
                <option value="0" {{ old('status', $product->status ?? 1) ? '' : 'selected' }}>Inactive</option>
            </select>
            @error('status')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label fw-bold">Featured</label>
            <select name="featured" class="form-control @error('featured') is-invalid @enderror">
                <option value="0" {{ old('featured', $product->featured ?? 0) ? '' : 'selected' }}>No</option>
                <option value="1" {{ old('featured', $product->featured ?? 0) ? 'selected' : '' }}>Yes</option>
            </select>
            @error('featured')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label fw-bold">Trending</label>
            <select name="trending" class="form-control @error('trending') is-invalid @enderror">
                <option value="0" {{ old('trending', $product->trending ?? 0) ? '' : 'selected' }}>No</option>
                <option value="1" {{ old('trending', $product->trending ?? 0) ? 'selected' : '' }}>Yes</option>
            </select>
            @error('trending')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-12">
        <div class="mb-3">
            <label class="form-label fw-bold">Thumbnail Image</label>
            @if(isset($product) && $product->thumbnail)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->name }}" width="100" height="100" style="object-fit:cover; border-radius:8px;">
                </div>
            @endif
            <input type="file" name="thumbnail" class="form-control @error('thumbnail') is-invalid @enderror" accept="image/*">
            <small class="text-muted">Recommended: 500x500px, max 2MB</small>
            @error('thumbnail')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<div class="d-flex gap-2">
    <button type="submit" class="btn btn-primary">
        <i class="fas fa-save"></i> {{ isset($product) ? 'Update' : 'Create' }} Product
    </button>
    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">Cancel</a>
</div>