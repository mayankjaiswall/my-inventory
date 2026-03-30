@extends('layouts.admin')

@section('title', 'Edit Product')

@section('content')
<div class="form">
  <div class="card">
    <div class="card-header">
      <h2 style="margin:0">Edit Product</h2>
      <a href="{{ route('admin.products.index') }}" class="btn" style="background:#eef2f1;color:#065f46;border-radius:8px;padding:8px 12px">Back</a>
    </div>

    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')
      <div class="form-grid">
        <div class="field">
          <label class="field-label">Name</label>
          <input type="text" name="name" value="{{ $product->name }}" placeholder="Name" required>
        </div>

        <div class="field">
          <label class="field-label">Slug</label>
            <div style="display:flex;gap:8px;align-items:center">
              <input id="slugInput" type="text" name="slug" value="{{ $product->slug }}">
              <button id="generateSlugBtn" type="button" class="btn" style="background:#eef2f1;color:#065f46;border-radius:8px;padding:8px 10px">Generate</button>
            </div>
            <div id="generatedSlug" style="margin-top:6px;color:#065f46;font-weight:600;display:none">Generated: <span></span></div>
        </div>

        <div class="field">
          <label class="field-label">Price</label>
          <input type="number" step="0.01" name="price" value="{{ $product->price }}" placeholder="Price" required>
        </div>

        <div class="field">
          <label class="field-label">Stock Quantity</label>
          <input type="number" name="stock_quantity" value="{{ $product->stock_quantity }}" placeholder="Stock" required>
        </div>

        <div class="field">
          <label class="field-label">Product Image</label>
          <input type="file" name="image" id="imageInput" accept="image/*">
          <div id="imagePreview" style="margin-top:8px;">
            @if($product->image)
              <img src="{{ asset('storage/'.$product->image) }}" style="max-width:200px;border-radius:8px;box-shadow:0 8px 20px rgba(0,0,0,0.06);">
            @endif
          </div>
        </div>

        <div class="field">
          <label class="field-label">Shipping Class</label>
          <input type="text" name="shipping_class" value="{{ $product->shipping_class }}" placeholder="Shipping Class">
        </div>

        <div class="field full">
          <label class="field-label">Status</label>
          <select name="status">
            <option value="active" {{ $product->status === 'active' ? 'selected' : '' }}>Active</option>
            <option value="draft" {{ $product->status === 'draft' ? 'selected' : '' }}>Draft</option>
          </select>
        </div>

        <div class="field full">
          <label class="field-label">Description</label>
          <textarea name="description" rows="4">{{ $product->description }}</textarea>
        </div>
      </div>

      <div style="margin-top:12px;display:flex;gap:10px;align-items:center">
        <button class="btn btn-primary" type="submit">Update Product</button>
        <a href="{{ route('admin.products.index') }}" class="btn" style="background:#eef2f1;color:#065f46;border-radius:8px;padding:8px 12px">Cancel</a>
      </div>
    </form>

    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Delete this product?');" style="margin-top:10px">
      @csrf
      @method('DELETE')
      <button class="btn btn-danger" type="submit">Delete Product</button>
    </form>
  </div>
</div>

<script>
  // auto-generate slug if empty
  const nameInput = document.querySelector('input[name="name"]');
  const slugInput = document.querySelector('input[name="slug"]');
  nameInput.addEventListener('input', () => {
    if (!slugInput.value) {
      slugInput.value = nameInput.value.toLowerCase().trim().replace(/[^a-z0-9]+/g,'-').replace(/(^-|-$)/g,'');
    }
  });

  // image preview for edit
  const imageInput = document.getElementById('imageInput');
  const imagePreview = document.getElementById('imagePreview');
  imageInput?.addEventListener('change', (e) => {
    imagePreview.innerHTML = '';
    const file = e.target.files[0];
    if (!file) return;
    const img = document.createElement('img');
    img.style.maxWidth = '200px';
    img.style.borderRadius = '8px';
    img.style.boxShadow = '0 8px 20px rgba(0,0,0,0.06)';
    img.src = URL.createObjectURL(file);
    imagePreview.appendChild(img);
  });
  
    // auto-generate slug if empty
    const nameInput = document.querySelector('input[name="name"]');
    const slugInput = document.querySelector('input[name="slug"]');
    nameInput.addEventListener('input', function(e){
      if(!slugInput.value) slugInput.value = nameInput.value.toLowerCase().trim().replace(/[^a-z0-9]+/g,'-').replace(/(^-|-$)/g,'');
    });
  
    // generate slug via server for uniqueness
    const generateBtn = document.getElementById('generateSlugBtn');
    const generatedDiv = document.getElementById('generatedSlug');
    const genSpan = generatedDiv.querySelector('span');
    generateBtn.addEventListener('click', async function(){
      const name = document.getElementById('name').value || '';
      const url = '/admin/products/generate-slug?name=' + encodeURIComponent(name);
      generateBtn.disabled = true;
      generateBtn.textContent = 'Generating...';
      try{
        const res = await fetch(url);
        if(!res.ok) throw new Error('Network');
        const data = await res.json();
        if(data.slug){
          document.getElementById('slugInput').value = data.slug;
          genSpan.textContent = data.slug;
          generatedDiv.style.display = 'block';
        }
      }catch(err){
        alert('Could not generate slug.');
      }finally{
        generateBtn.disabled = false;
        generateBtn.textContent = 'Generate';
      }
    });
</script>
    </form>
  </div>
</div>
@endsection
