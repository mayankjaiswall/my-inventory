@extends('layouts.admin')

@section('title', 'Products')

@section('content')
<div class="panel">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;">
    <h2>Products</h2>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">Add Product</a>
  </div>

  @if(session('success'))
    <div class="card" style="background:#ecfdf5;border-color:#a7f3d0;color:#065f46;padding:10px;margin-bottom:12px;">{{ session('success') }}</div>
  @endif

  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Price</th>
        <th>Stock</th>
        <th>Status</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach($products as $p)
        <tr>
          <td>{{ $p->id }}</td>
          <td>{{ $p->name }}</td>
          <td>{{ $p->price }}</td>
          <td>{{ $p->stock_quantity }}</td>
          <td>{{ $p->status }}</td>
          <td>
            <a class="btn btn-success" href="{{ route('admin.products.edit', $p) }}">Edit</a>
            <form action="{{ route('admin.products.destroy', $p) }}" method="POST" style="display:inline-block;">
              @csrf
              @method('DELETE')
              <button class="btn btn-danger" type="submit">Delete</button>
            </form>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>

  <div style="margin-top:12px;">{{ $products->links() }}</div>
</div>
@endsection
