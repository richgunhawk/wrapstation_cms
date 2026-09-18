<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($title ?? 'Wrapstation Shop') ?></title>
    <style>
        :root { --ink:#16212b; --muted:#607080; --accent:#ee6c4d; --accent-dark:#c94f35; --paper:#fffdf8; --line:#eadfd3; }
        * { box-sizing:border-box; } body { margin:0; color:var(--ink); background:linear-gradient(135deg,#f8efe6 0%,#fffdf8 48%,#e5f1ef 100%); font:16px/1.5 Georgia,serif; }
        header { padding:28px clamp(20px,6vw,80px); display:flex; justify-content:space-between; align-items:center; border-bottom:1px solid var(--line); }
        header a { color:var(--ink); text-decoration:none; font-weight:bold; } nav a { margin-left:18px; color:var(--muted); font-family:system-ui,sans-serif; font-size:14px; }
        main { max-width:1100px; margin:0 auto; padding:50px 20px 80px; } h1 { margin:0 0 8px; font-size:clamp(32px,5vw,58px); letter-spacing:-.04em; } h2 { margin-top:0; } .lede { color:var(--muted); max-width:650px; }
        .notice { padding:12px 16px; border-radius:10px; background:#e8f5ec; color:#1c6336; margin:20px 0; font-family:system-ui,sans-serif; } .error { background:#fff0ec; color:#963a24; }
        .toolbar { display:flex; justify-content:space-between; align-items:center; gap:12px; margin:32px 0 14px; } .btn { display:inline-block; border:0; border-radius:999px; padding:11px 17px; background:var(--accent); color:white; text-decoration:none; cursor:pointer; font-family:system-ui,sans-serif; font-weight:600; } .btn:hover { background:var(--accent-dark); } .btn.secondary { background:#dcebe8; color:#24514b; } .btn.danger { background:#8d3b35; }
        .grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(230px,1fr)); gap:18px; } .card { background:rgba(255,255,255,.82); border:1px solid var(--line); border-radius:18px; padding:22px; box-shadow:0 12px 35px rgba(64,47,35,.08); } .price { color:var(--accent-dark); font-size:23px; font-weight:bold; } .stock { color:var(--muted); font-family:system-ui,sans-serif; font-size:14px; } .actions { display:flex; flex-wrap:wrap; gap:8px; margin-top:18px; }
        form { max-width:620px; background:rgba(255,255,255,.84); border:1px solid var(--line); padding:26px; border-radius:18px; } label { display:block; margin:14px 0 6px; font-family:system-ui,sans-serif; font-size:14px; font-weight:600; } input,select { width:100%; border:1px solid #cfc3b7; border-radius:9px; padding:11px; font:inherit; background:#fff; } .form-actions { margin-top:22px; display:flex; gap:10px; }
        @media (max-width:600px) { header { align-items:flex-start; flex-direction:column; gap:10px; } nav a { margin:0 14px 0 0; } .toolbar { align-items:flex-start; flex-direction:column; } }
    </style>
</head>
<body>
<header><a href="<?= site_url('/') ?>">WRAPSTATION / SHOP</a><nav><a href="<?= site_url('/') ?>">Products</a><a href="<?= site_url('products/new') ?>">Add product</a></nav></header>
<main><?= $this->renderSection('content') ?></main>
</body>
</html>
