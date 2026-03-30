<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inventory Admin</title>
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

    * { margin: 0; padding: 0; box-sizing: border-box; }

    body { font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif; background: var(--bg); color: var(--text); min-height:100vh; }

    .layout { display: grid; grid-template-columns: 260px 1fr; min-height: 100vh; }
    .sidebar { background: linear-gradient(170deg,#0f172a 0%,#1e293b 100%); color:#fff; padding:28px 20px; border-right:1px solid rgba(255,255,255,0.12); position:sticky; top:0; height:100vh; }
    .brand { font-size:1.25rem; font-weight:700; margin-bottom:28px; }
    .sidebar ul { list-style:none; display:grid; gap:8px; }
    .sidebar li { padding:8px; border-radius:10px; }
    .sidebar a.menu-item { display:flex; gap:12px; align-items:center; padding:12px 14px; border-radius:10px; color:#cbd5e1; font-weight:600; text-decoration:none; }
    .sidebar a.menu-item svg { width:18px; height:18px; flex-shrink:0; opacity:0.9 }
    .sidebar a.menu-item.active, .sidebar a.menu-item:hover { background: rgba(255,255,255,0.06); color:#fff; transform:translateX(4px); }

    .main { padding:28px; }
    .header { display:flex; justify-content:space-between; align-items:center; margin-bottom:22px; gap:12px; flex-wrap:wrap; }
    .header h1 { font-size:1.75rem; font-weight:700; }
    .header-actions { display:flex; gap:10px; align-items:center; }

    .btn { border:none; border-radius:10px; padding:10px 16px; font-weight:600; color:#fff; cursor:pointer; }
    .btn-primary { background: linear-gradient(135deg,var(--brand),var(--brand-dark)); }
    .btn-danger { background: var(--danger); }
    .btn-success { background: var(--success); }

    .cards { display:grid; grid-template-columns:repeat(3,1fr); gap:16px; margin-bottom:22px; }
    .card { background:var(--surface); border:1px solid var(--line); border-radius:var(--radius); padding:18px; box-shadow:var(--shadow); }
    .panel { background:var(--surface); border:1px solid var(--line); border-radius:var(--radius); padding:18px; box-shadow:var(--shadow); margin-bottom:22px; overflow-x:auto; }

    table { width:100%; border-collapse:collapse; min-width:640px; }
    th, td { text-align:left; padding:12px; border-bottom:1px solid var(--line); }

    .form { background:var(--surface); border:1px solid var(--line); border-radius:var(--radius); padding:20px; box-shadow:var(--shadow); }
    .form-grid { display:grid; grid-template-columns:repeat(2,1fr); gap:16px; margin-bottom:12px; }
    .field { display:flex; flex-direction:column; gap:6px; }
    label.field-label { font-weight:700; color:#334155; font-size:0.9rem; }
    input[type=text], input[type=number], input[type=file], select, textarea { width:100%; padding:10px 12px; border:1px solid #e6edf3; border-radius:8px; background:#fff; outline:none; transition:box-shadow .12s ease, border-color .12s ease; }
    input[type=text]:focus, input[type=number]:focus, select:focus, textarea:focus { box-shadow:0 6px 18px rgba(16,24,40,0.06); border-color:#c7f0e8; }
    .card-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:12px; }
    .card { background:var(--surface); border:1px solid var(--line); border-radius:12px; padding:18px; box-shadow:var(--shadow); }

    @media (max-width:980px) { .layout { grid-template-columns:1fr; } .cards { grid-template-columns:1fr; } }
    @media (max-width:640px) { .main { padding:18px; } .form-grid { grid-template-columns:1fr; } }
  </style>
</head>
<body>
  <div class="layout">
    <aside class="sidebar">
      <div class="brand">Inventory Admin</div>
      <ul>
        <li>
          <a href="{{ route('admin.dashboard') }}" class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3 13h8V3H3v10zM3 21h8v-6H3v6zM13 21h8V11h-8v10zM13 3v6h8V3h-8z" fill="currentColor"/></svg>
            <span>Dashboard</span>
          </a>
        </li>
        <li>
          <a href="{{ route('admin.products.index') }}" class="menu-item {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20 6H4v12h16V6zM8 18H6v-2h2v2zm0-4H6v-2h2v2zM12 18h-2v-2h2v2zm0-4h-2v-2h2v2zM18 18h-4v-2h4v2z" fill="currentColor"/></svg>
            <span>Products</span>
          </a>
        </li>
        <li>
          <a href="#" class="menu-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 2L2 7l10 5 10-5-10-5zm0 13l-10-5v7l10 5 10-5v-7l-10 5z" fill="currentColor"/></svg>
            <span>Categories</span>
          </a>
        </li>
        <li>
          <a href="#" class="menu-item {{ request()->routeIs('admin.stock.*') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3 3h18v2H3V3zm0 14h10v2H3v-2zm0-7h18v2H3V10z" fill="currentColor"/></svg>
            <span>Stock</span>
          </a>
        </li>
        <li>
          <a href="#" class="menu-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 12c2.7 0 5-2.3 5-5s-2.3-5-5-5-5 2.3-5 5 2.3 5 5 5zm0 2c-3.3 0-10 1.7-10 5v3h20v-3c0-3.3-6.7-5-10-5z" fill="currentColor"/></svg>
            <span>Users</span>
          </a>
        </li>
      </ul>
    </aside>

    <main class="main">
      <div class="header">
        <h1>@yield('title', 'Dashboard')</h1>
        <div class="header-actions">
          @yield('header-actions')
          <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button class="btn btn-danger" type="submit">Logout</button>
          </form>
        </div>
      </div>

      @yield('content')
    </main>
  </div>
</body>
</html>
