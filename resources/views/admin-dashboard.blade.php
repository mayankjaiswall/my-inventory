<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inventory Admin Panel</title>
  <style>
    :root {
      --bg: #f4f6fb;
      --surface: #ffffff;
      --surface-alt: #f8fafc;
      --text: #1f2937;
      --muted: #6b7280;
      --line: #e5e7eb;
      --brand: #0f766e;
      --brand-dark: #115e59;
      --danger: #dc2626;
      --success: #15803d;
      --shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
      --radius: 14px;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
      background:
        radial-gradient(circle at 85% 5%, #d9f99d 0, transparent 28%),
        radial-gradient(circle at 10% 90%, #bfdbfe 0, transparent 25%),
        var(--bg);
      color: var(--text);
      min-height: 100vh;
    }

    .layout {
      display: grid;
      grid-template-columns: 260px 1fr;
      min-height: 100vh;
    }

    .sidebar {
      background: linear-gradient(170deg, #0f172a 0%, #1e293b 100%);
      color: #fff;
      padding: 28px 20px;
      border-right: 1px solid rgba(255, 255, 255, 0.12);
      position: sticky;
      top: 0;
      height: 100vh;
    }

    .brand {
      font-size: 1.25rem;
      font-weight: 700;
      letter-spacing: 0.4px;
      margin-bottom: 28px;
      color: #f8fafc;
    }

    .sidebar ul {
      list-style: none;
      display: grid;
      gap: 8px;
    }

    .sidebar li {
      padding: 12px 14px;
      border-radius: 10px;
      color: #cbd5e1;
      font-weight: 500;
      cursor: pointer;
      transition: all 0.2s ease;
    }

    .sidebar li:hover,
    .sidebar li.active {
      background: rgba(255, 255, 255, 0.14);
      color: #ffffff;
      transform: translateX(2px);
    }

    .main {
      padding: 28px;
      animation: fade-in 0.5s ease;
    }

    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 22px;
      gap: 12px;
      flex-wrap: wrap;
    }

    .header h1 {
      font-size: 1.75rem;
      font-weight: 700;
    }

    .header-actions {
      display: flex;
      gap: 10px;
      flex-wrap: wrap;
      align-items: center;
    }

    .btn {
      border: none;
      border-radius: 10px;
      padding: 10px 16px;
      font-weight: 600;
      color: #fff;
      cursor: pointer;
      transition: transform 0.15s ease, opacity 0.2s ease;
    }

    .btn:hover {
      transform: translateY(-1px);
      opacity: 0.95;
    }

    .btn-primary { background: linear-gradient(135deg, var(--brand), var(--brand-dark)); }
    .btn-success { background: var(--success); }
    .btn-danger { background: var(--danger); }

    .cards {
      display: grid;
      grid-template-columns: repeat(3, minmax(0, 1fr));
      gap: 16px;
      margin-bottom: 22px;
    }

    .card {
      background: var(--surface);
      border: 1px solid var(--line);
      border-radius: var(--radius);
      padding: 18px;
      box-shadow: var(--shadow);
      animation: rise 0.5s ease;
    }

    .card h3 {
      color: var(--muted);
      font-size: 0.95rem;
      font-weight: 600;
      margin-bottom: 8px;
    }

    .card p {
      font-size: 1.6rem;
      font-weight: 700;
    }

    .panel {
      background: var(--surface);
      border: 1px solid var(--line);
      border-radius: var(--radius);
      padding: 18px;
      box-shadow: var(--shadow);
      margin-bottom: 22px;
      overflow-x: auto;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      min-width: 640px;
    }

    th, td {
      text-align: left;
      padding: 12px;
      border-bottom: 1px solid var(--line);
      vertical-align: middle;
    }

    thead th {
      color: #334155;
      background: var(--surface-alt);
      font-size: 0.9rem;
      font-weight: 700;
    }

    td {
      color: #374151;
    }

    .actions {
      display: flex;
      gap: 8px;
      flex-wrap: wrap;
    }

    .form {
      background: var(--surface);
      border: 1px solid var(--line);
      border-radius: var(--radius);
      padding: 20px;
      box-shadow: var(--shadow);
    }

    .form h2 {
      margin-bottom: 14px;
      font-size: 1.2rem;
    }

    .form-grid {
      display: grid;
      grid-template-columns: repeat(2, minmax(0, 1fr));
      gap: 12px;
      margin-bottom: 12px;
    }

    .form input,
    .form select {
      width: 100%;
      padding: 11px 12px;
      border: 1px solid #cbd5e1;
      border-radius: 10px;
      outline: none;
      background: #fff;
      transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .form input:focus,
    .form select:focus {
      border-color: #14b8a6;
      box-shadow: 0 0 0 3px rgba(20, 184, 166, 0.15);
    }

    .full {
      grid-column: span 2;
    }

    @keyframes fade-in {
      from { opacity: 0; transform: translateY(8px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @keyframes rise {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 980px) {
      .layout {
        grid-template-columns: 1fr;
      }

      .sidebar {
        position: relative;
        height: auto;
      }

      .cards {
        grid-template-columns: 1fr;
      }
    }

    @media (max-width: 640px) {
      .main {
        padding: 18px;
      }

      .form-grid {
        grid-template-columns: 1fr;
      }

      .full {
        grid-column: span 1;
      }
    }
  </style>
</head>
<body>
  <div class="layout">
    <aside class="sidebar">
      <div class="brand">Inventory Admin</div>
      <ul>
        <li class="active">Dashboard</li>
        <li>Products</li>
        <li>Categories</li>
        <li>Stock</li>
        <li>Users</li>
      </ul>
    </aside>

    <main class="main">
      <div class="header">
        <h1>Dashboard</h1>
        <div class="header-actions">
          <button class="btn btn-primary" type="button">Add Product</button>
          <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button class="btn btn-danger" type="submit">Logout</button>
          </form>
        </div>
      </div>

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
    </main>
  </div>
</body>
</html>
