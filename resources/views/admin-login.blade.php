<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login | Inventory</title>
  <style>
    :root {
      --bg: #eef2ff;
      --surface: #ffffff;
      --text: #1f2937;
      --muted: #6b7280;
      --line: #dbe4f0;
      --brand: #0f766e;
      --brand-dark: #115e59;
      --danger: #dc2626;
      --radius: 14px;
      --shadow: 0 12px 28px rgba(15, 23, 42, 0.12);
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      min-height: 100vh;
      display: grid;
      place-items: center;
      padding: 22px;
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
      color: var(--text);
      background:
        radial-gradient(circle at 12% 15%, #99f6e4 0, transparent 28%),
        radial-gradient(circle at 85% 88%, #c7d2fe 0, transparent 25%),
        var(--bg);
    }

    .auth-card {
      width: min(420px, 100%);
      background: var(--surface);
      border: 1px solid var(--line);
      border-radius: var(--radius);
      box-shadow: var(--shadow);
      padding: 24px;
      animation: lift 0.35s ease;
    }

    h1 {
      font-size: 1.45rem;
      margin-bottom: 8px;
    }

    p {
      color: var(--muted);
      margin-bottom: 18px;
      font-size: 0.95rem;
    }

    .field {
      display: grid;
      gap: 6px;
      margin-bottom: 12px;
    }

    label {
      font-size: 0.9rem;
      color: #334155;
      font-weight: 600;
    }

    input[type="email"],
    input[type="password"] {
      border: 1px solid #cbd5e1;
      border-radius: 10px;
      padding: 11px 12px;
      font-size: 0.95rem;
      outline: none;
      transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    input[type="email"]:focus,
    input[type="password"]:focus {
      border-color: #14b8a6;
      box-shadow: 0 0 0 3px rgba(20, 184, 166, 0.15);
    }

    .remember {
      display: flex;
      align-items: center;
      gap: 8px;
      margin-bottom: 14px;
      color: #334155;
      font-size: 0.9rem;
    }

    button {
      width: 100%;
      border: none;
      border-radius: 10px;
      padding: 11px 14px;
      color: #fff;
      font-weight: 600;
      cursor: pointer;
      background: linear-gradient(135deg, var(--brand), var(--brand-dark));
      transition: transform 0.15s ease, opacity 0.2s ease;
    }

    button:hover {
      transform: translateY(-1px);
      opacity: 0.96;
    }

    .error {
      margin-bottom: 12px;
      background: #fee2e2;
      color: var(--danger);
      border: 1px solid #fecaca;
      border-radius: 10px;
      padding: 10px 12px;
      font-size: 0.9rem;
    }

    .hint {
      margin-top: 12px;
      color: #64748b;
      font-size: 0.82rem;
    }

    @keyframes lift {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body>
  <main class="auth-card">
    <h1>Admin Login</h1>
    <p>Sign in with the configured admin email and password.</p>

    @if ($errors->any())
      <div class="error">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('admin.login.submit') }}">
      @csrf

      <div class="field">
        <label for="email">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
      </div>

      <div class="field">
        <label for="password">Password</label>
        <input id="password" type="password" name="password" required>
      </div>

      <label class="remember" for="remember">
        <input id="remember" type="checkbox" name="remember" value="1">
        Remember me
      </label>

      <button type="submit">Login</button>
    </form>

    <div class="hint">Set ADMIN_EMAIL in your .env file to control who is allowed to access this panel.</div>
  </main>
</body>
</html>
