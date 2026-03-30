@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
  <section class="cards">
    <article class="card">
      <h3>Total Products</h3>
      <p>120</p>
    </article>
    <article class="card">
      <h3>Low Stock</h3>
      <p>8</p>
    </article>
    <article class="card">
      <h3>Total Value</h3>
      <p>Rs 50,000</p>
    </article>
  </section>

  <section class="panel">
    <table>
      <thead>
        <tr>
          <th>Name</th>
          <th>Category</th>
          <th>Price</th>
          <th>Stock</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Product A</td>
          <td>Electronics</td>
          <td>Rs 1000</td>
          <td>50</td>
          <td>
            <div class="actions">
              <button class="btn btn-success" type="button">Edit</button>
              <button class="btn btn-danger" type="button">Delete</button>
            </div>
          </td>
        </tr>
        <tr>
          <td>Product B</td>
          <td>Clothing</td>
          <td>Rs 500</td>
          <td>20</td>
          <td>
            <div class="actions">
              <button class="btn btn-success" type="button">Edit</button>
              <button class="btn btn-danger" type="button">Delete</button>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </section>

  <section class="form">
    <h2>Add Product</h2>
    <form action="#" method="post">
      <div class="form-grid">
        <input type="text" placeholder="Product Name" class="full">
        <input type="number" placeholder="Price">
        <input type="number" placeholder="Quantity">
        <select class="full">
          <option>Select Category</option>
          <option>Electronics</option>
          <option>Clothing</option>
        </select>
      </div>
      <button class="btn btn-primary" type="submit">Save</button>
    </form>
  </section>
@endsection
