<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>GaragePro Afrique — Connexion</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
*{margin:0;padding:0;box-sizing:border-box}
body{font-family:'Inter',sans-serif;min-height:100vh;display:flex;background:#F1F5F9}
.left{width:480px;min-height:100vh;background:linear-gradient(160deg,#0D1B3E 0%,#1e3a8a 60%,#0D1B3E 100%);display:flex;flex-direction:column;justify-content:space-between;padding:48px;position:relative;overflow:hidden}
.left::before{content:'';position:absolute;top:-80px;right:-80px;width:320px;height:320px;border-radius:50%;border:60px solid rgba(249,115,22,.1)}
.left::after{content:'';position:absolute;bottom:-100px;left:-60px;width:280px;height:280px;border-radius:50%;border:50px solid rgba(255,255,255,.04)}
.logo-wrap{display:flex;align-items:center;gap:14px;position:relative;z-index:1}
.logo-icon{width:50px;height:50px;background:linear-gradient(135deg,#F97316,#fb923c);border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:22px;color:#fff;box-shadow:0 6px 20px rgba(249,115,22,.4)}
.logo-text strong{display:block;font-size:20px;font-weight:800;color:#fff;letter-spacing:.3px}
.logo-text span{font-size:11px;color:rgba(255,255,255,.45);letter-spacing:1.2px;text-transform:uppercase;font-weight:500}
.left-content{position:relative;z-index:1}
.left-content h1{font-size:32px;font-weight:800;color:#fff;line-height:1.25;margin-bottom:16px}
.left-content h1 span{color:#F97316}
.left-content p{font-size:15px;color:rgba(255,255,255,.55);line-height:1.7}
.features{margin-top:36px;display:flex;flex-direction:column;gap:16px}
.feat{display:flex;align-items:center;gap:12px}
.feat-icon{width:36px;height:36px;background:rgba(255,255,255,.08);border-radius:9px;display:flex;align-items:center;justify-content:center;color:#F97316;font-size:14px;flex-shrink:0}
.feat p{font-size:13.5px;color:rgba(255,255,255,.65);font-weight:500}
.left-footer{font-size:12px;color:rgba(255,255,255,.25);position:relative;z-index:1}
.right{flex:1;display:flex;align-items:center;justify-content:center;padding:40px}
.login-box{width:100%;max-width:440px}
.login-box h2{font-size:26px;font-weight:800;color:#0F172A;margin-bottom:6px}
.login-box .sub{font-size:14px;color:#64748B;margin-bottom:36px}
.form-group{margin-bottom:20px}
.form-label{display:block;font-size:13px;font-weight:600;color:#0F172A;margin-bottom:7px}
.input-wrap{position:relative}
.input-wrap i{position:absolute;left:14px;top:50%;transform:translateY(-50%);color:#94A3B8;font-size:14px}
.form-control{width:100%;padding:12px 14px 12px 40px;border:1.5px solid #E2E8F0;border-radius:10px;font-size:14px;color:#0F172A;background:#fff;font-family:'Inter',sans-serif;outline:none;transition:.15s}
.form-control:focus{border-color:#F97316;box-shadow:0 0 0 3px rgba(249,115,22,.12)}
.form-control.error{border-color:#EF4444;box-shadow:0 0 0 3px rgba(239,68,68,.1)}
.error-msg{font-size:12px;color:#EF4444;margin-top:5px;display:flex;align-items:center;gap:4px}
.remember-row{display:flex;align-items:center;justify-content:space-between;margin-bottom:24px}
.check-wrap{display:flex;align-items:center;gap:8px;cursor:pointer;font-size:13.5px;color:#475569}
.check-wrap input{width:16px;height:16px;accent-color:#0D1B3E;cursor:pointer}
.btn-login{width:100%;padding:13px;background:linear-gradient(135deg,#0D1B3E,#1e3a8a);color:#fff;border:none;border-radius:10px;font-size:15px;font-weight:700;cursor:pointer;font-family:'Inter',sans-serif;transition:.18s;display:flex;align-items:center;justify-content:center;gap:8px}
.btn-login:hover{background:linear-gradient(135deg,#1e3a8a,#0D1B3E);box-shadow:0 6px 20px rgba(13,27,62,.3)}
.divider{text-align:center;margin:24px 0;position:relative}
.divider::before{content:'';position:absolute;left:0;top:50%;width:100%;height:1px;background:#E2E8F0}
.divider span{background:#F1F5F9;padding:0 12px;position:relative;font-size:12px;color:#94A3B8}
.demo-creds{background:#F8FAFC;border:1.5px solid #E2E8F0;border-radius:10px;padding:14px 16px}
.demo-creds p{font-size:12px;color:#64748B;margin-bottom:8px;font-weight:600;text-transform:uppercase;letter-spacing:.5px}
.demo-cred{display:flex;align-items:center;gap:8px;margin-bottom:4px}
.demo-cred span{font-size:13px;color:#0F172A;font-family:monospace}
.demo-cred .copy{font-size:11px;color:#F97316;cursor:pointer;margin-left:auto;font-weight:600}
</style>
</head>
<body>

<div class="left">
  <div class="logo-wrap">
    <div class="logo-icon"><i class="fas fa-car"></i></div>
    <div class="logo-text">
      <strong>GaragePro</strong>
      <span>Afrique</span>
    </div>
  </div>

  <div class="left-content">
    <h1>Gérez votre garage avec <span>précision</span></h1>
    <p>La plateforme SaaS tout-en-un pour les garages africains. Réparations, locations, stock et comptabilité au même endroit.</p>
    <div class="features">
      <div class="feat"><div class="feat-icon"><i class="fas fa-wrench"></i></div><p>Suivi des réparations en temps réel</p></div>
      <div class="feat"><div class="feat-icon"><i class="fas fa-key"></i></div><p>Module location de voitures intégré</p></div>
      <div class="feat"><div class="feat-icon"><i class="fas fa-chart-pie"></i></div><p>Comptabilité et rapports automatisés</p></div>
      <div class="feat"><div class="feat-icon"><i class="fas fa-boxes"></i></div><p>Gestion des stocks avec alertes</p></div>
    </div>
  </div>

  <div class="left-footer">© 2026 GaragePro Afrique · Tous droits réservés</div>
</div>

<div class="right">
  <div class="login-box">
    <h2>Bienvenue 👋</h2>
    <p class="sub">Connectez-vous à votre espace de gestion</p>

    @if($errors->any())
    <div style="background:rgba(239,68,68,.06);border:1.5px solid rgba(239,68,68,.2);border-radius:10px;padding:12px 16px;margin-bottom:20px;display:flex;align-items:center;gap:10px">
      <i class="fas fa-exclamation-circle" style="color:#EF4444"></i>
      <span style="font-size:13.5px;color:#DC2626">{{ $errors->first() }}</span>
    </div>
    @endif

    <form method="POST" action="{{ route('login.post') }}">
      @csrf
      <div class="form-group">
        <label class="form-label">Adresse email</label>
        <div class="input-wrap">
          <i class="fas fa-envelope"></i>
          <input class="form-control {{ $errors->has('email') ? 'error' : '' }}"
                 type="email" name="email" value="{{ old('email') }}"
                 placeholder="admin@garagepro.sn" autocomplete="email" required>
        </div>
      </div>

      <div class="form-group">
        <label class="form-label">Mot de passe</label>
        <div class="input-wrap">
          <i class="fas fa-lock"></i>
          <input class="form-control" type="password" name="password"
                 placeholder="••••••••" autocomplete="current-password" required>
        </div>
      </div>

      <div class="remember-row">
        <label class="check-wrap">
          <input type="checkbox" name="remember"> Se souvenir de moi
        </label>
      </div>

      <button type="submit" class="btn-login">
        <i class="fas fa-sign-in-alt"></i> Se connecter
      </button>
    </form>

    <div class="divider"><span>Identifiants de démonstration</span></div>

    <div class="demo-creds">
      <p>Accès rapide</p>
      <div class="demo-cred">
        <i class="fas fa-user-shield" style="color:#0D1B3E;font-size:13px"></i>
        <span>admin@garagepro.sn</span>
        <span class="copy" onclick="fillLogin('admin@garagepro.sn')">Utiliser</span>
      </div>
      <div class="demo-cred">
        <i class="fas fa-key" style="color:#64748B;font-size:13px"></i>
        <span>password</span>
      </div>
    <p style="text-align:center;margin-top:20px;font-size:13.5px;color:#64748B">
      Pas encore de compte ? <a href="{{ route('register') }}" style="color:#F97316;font-weight:600;text-decoration:none">Créer mon garage</a>
    </p>
  </div>
</div>

<script>
function fillLogin(email) {
  document.querySelector('input[name="email"]').value = email;
  document.querySelector('input[name="password"]').value = 'password';
}
</script>
</body>
</html>
