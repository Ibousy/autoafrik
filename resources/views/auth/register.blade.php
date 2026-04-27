<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>AutoAfrik — Créer mon entreprise</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
*{margin:0;padding:0;box-sizing:border-box}
body{font-family:'Inter',sans-serif;min-height:100vh;display:flex;background:#F1F5F9}
.left{width:420px;min-height:100vh;background:linear-gradient(160deg,#0D1B3E 0%,#1e3a8a 60%,#0D1B3E 100%);display:flex;flex-direction:column;justify-content:space-between;padding:48px;position:relative;overflow:hidden}
.left::before{content:'';position:absolute;top:-80px;right:-80px;width:320px;height:320px;border-radius:50%;border:60px solid rgba(249,115,22,.1)}
.left::after{content:'';position:absolute;bottom:-100px;left:-60px;width:280px;height:280px;border-radius:50%;border:50px solid rgba(255,255,255,.04)}
.logo-wrap{display:flex;align-items:center;gap:14px;position:relative;z-index:1}
.logo-icon{width:50px;height:50px;background:linear-gradient(135deg,#F97316,#fb923c);border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:22px;color:#fff;box-shadow:0 6px 20px rgba(249,115,22,.4)}
.logo-text strong{display:block;font-size:20px;font-weight:800;color:#fff;letter-spacing:.3px}
.logo-text span{font-size:11px;color:rgba(255,255,255,.45);letter-spacing:1.2px;text-transform:uppercase;font-weight:500}
.left-content{position:relative;z-index:1}
.left-content h1{font-size:28px;font-weight:800;color:#fff;line-height:1.25;margin-bottom:16px}
.left-content h1 span{color:#F97316}
.left-content p{font-size:14px;color:rgba(255,255,255,.55);line-height:1.7}
.plans{margin-top:32px;display:flex;flex-direction:column;gap:12px}
.plan-item{display:flex;align-items:flex-start;gap:12px;background:rgba(255,255,255,.06);border-radius:12px;padding:14px 16px}
.plan-badge{font-size:10px;font-weight:700;letter-spacing:.8px;text-transform:uppercase;padding:3px 8px;border-radius:20px;white-space:nowrap;flex-shrink:0;margin-top:1px}
.plan-badge.trial{background:rgba(249,115,22,.2);color:#fdba74}
.plan-badge.starter{background:rgba(34,197,94,.15);color:#86efac}
.plan-badge.pro{background:rgba(99,102,241,.2);color:#a5b4fc}
.plan-badge.enterprise{background:rgba(245,158,11,.15);color:#fcd34d}
.plan-info p{font-size:13px;color:#fff;font-weight:600;margin-bottom:2px}
.plan-info span{font-size:12px;color:rgba(255,255,255,.45)}
.left-footer{font-size:12px;color:rgba(255,255,255,.25);position:relative;z-index:1}
.right{flex:1;display:flex;align-items:center;justify-content:center;padding:40px;overflow-y:auto}
.box{width:100%;max-width:500px;padding:4px 0}
.box h2{font-size:24px;font-weight:800;color:#0F172A;margin-bottom:4px}
.box .sub{font-size:14px;color:#64748B;margin-bottom:28px}
.section-title{font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.8px;color:#94A3B8;margin-bottom:14px;margin-top:4px;display:flex;align-items:center;gap:8px}
.section-title::after{content:'';flex:1;height:1px;background:#E2E8F0}
.form-grid{display:grid;gap:16px}
.form-grid.two{grid-template-columns:1fr 1fr}
.form-group{display:flex;flex-direction:column;gap:6px}
.form-label{font-size:13px;font-weight:600;color:#0F172A}
.input-wrap{position:relative}
.input-wrap i.ic{position:absolute;left:13px;top:50%;transform:translateY(-50%);color:#94A3B8;font-size:13px}
.form-control{width:100%;padding:11px 13px 11px 38px;border:1.5px solid #E2E8F0;border-radius:9px;font-size:14px;color:#0F172A;background:#fff;font-family:'Inter',sans-serif;outline:none;transition:.15s}
.form-control:focus{border-color:#F97316;box-shadow:0 0 0 3px rgba(249,115,22,.12)}
.form-control.error{border-color:#EF4444}
.err{font-size:12px;color:#EF4444;display:flex;align-items:center;gap:4px}
.btn-submit{width:100%;padding:13px;background:linear-gradient(135deg,#F97316,#ea580c);color:#fff;border:none;border-radius:10px;font-size:15px;font-weight:700;cursor:pointer;font-family:'Inter',sans-serif;transition:.18s;display:flex;align-items:center;justify-content:center;gap:8px;margin-top:8px}
.btn-submit:hover{background:linear-gradient(135deg,#ea580c,#F97316);box-shadow:0 6px 20px rgba(249,115,22,.35)}
.login-link{text-align:center;margin-top:18px;font-size:13.5px;color:#64748B}
.login-link a{color:#F97316;font-weight:600;text-decoration:none}
.login-link a:hover{text-decoration:underline}
.alert-err{background:rgba(239,68,68,.06);border:1.5px solid rgba(239,68,68,.2);border-radius:10px;padding:12px 16px;margin-bottom:20px;display:flex;align-items:center;gap:10px;font-size:13.5px;color:#DC2626}
</style>
</head>
<body>

<div class="left">
  <div class="logo-wrap">
    <div class="logo-icon"><i class="fas fa-car"></i></div>
    <div class="logo-text">
      <strong>AutoAfrik</strong>
      <span>Plateforme SaaS</span>
    </div>
  </div>

  <div class="left-content">
    <h1>Lancez votre garage en <span>5 minutes</span></h1>
    <p>Créez votre espace, invitez votre équipe et gérez tout depuis un seul tableau de bord.</p>
    <div class="plans">
      <div class="plan-item">
        <span class="plan-badge trial">Essai</span>
        <div class="plan-info"><p>14 jours gratuits</p><span>3 agents · toutes les fonctionnalités</span></div>
      </div>
      <div class="plan-item">
        <span class="plan-badge starter">Starter</span>
        <div class="plan-info"><p>15 000 FCFA / mois</p><span>5 agents · accès complet</span></div>
      </div>
      <div class="plan-item">
        <span class="plan-badge pro">Pro</span>
        <div class="plan-info"><p>35 000 FCFA / mois</p><span>20 agents · exports PDF & Excel</span></div>
      </div>
      <div class="plan-item">
        <span class="plan-badge enterprise">Enterprise</span>
        <div class="plan-info"><p>80 000 FCFA / mois</p><span>Agents illimités · support dédié</span></div>
      </div>
    </div>
  </div>

  <div class="left-footer">© 2026 AutoAfrik · Tous droits réservés</div>
</div>

<div class="right">
  <div class="box">
    <h2>Créer mon entreprise</h2>
    <p class="sub">Commencez votre essai gratuit de 14 jours — sans carte bancaire</p>

    @if($errors->any())
    <div class="alert-err">
      <i class="fas fa-exclamation-circle"></i>
      <span>{{ $errors->first() }}</span>
    </div>
    @endif

    <form method="POST" action="{{ route('register.post') }}">
      @csrf

      <div class="section-title">Votre entreprise</div>
      <div class="form-grid" style="margin-bottom:20px">
        <div class="form-group">
          <label class="form-label">Nom du garage / entreprise</label>
          <div class="input-wrap">
            <i class="fas fa-building ic"></i>
            <input class="form-control {{ $errors->has('company_name') ? 'error' : '' }}"
                   type="text" name="company_name" value="{{ old('company_name') }}"
                   placeholder="Garage Central Dakar" required>
          </div>
          @error('company_name')<p class="err"><i class="fas fa-circle-exclamation"></i>{{ $message }}</p>@enderror
        </div>
      </div>

      <div class="section-title">Votre compte administrateur</div>
      <div class="form-grid two" style="margin-bottom:16px">
        <div class="form-group">
          <label class="form-label">Votre nom complet</label>
          <div class="input-wrap">
            <i class="fas fa-user ic"></i>
            <input class="form-control {{ $errors->has('name') ? 'error' : '' }}"
                   type="text" name="name" value="{{ old('name') }}"
                   placeholder="Mamadou Diallo" required>
          </div>
          @error('name')<p class="err"><i class="fas fa-circle-exclamation"></i>{{ $message }}</p>@enderror
        </div>
        <div class="form-group">
          <label class="form-label">Téléphone</label>
          <div class="input-wrap">
            <i class="fas fa-phone ic"></i>
            <input class="form-control" type="text" name="phone"
                   value="{{ old('phone') }}" placeholder="+221 77 000 00 00">
          </div>
        </div>
      </div>

      <div class="form-grid" style="margin-bottom:16px">
        <div class="form-group">
          <label class="form-label">Adresse email</label>
          <div class="input-wrap">
            <i class="fas fa-envelope ic"></i>
            <input class="form-control {{ $errors->has('email') ? 'error' : '' }}"
                   type="email" name="email" value="{{ old('email') }}"
                   placeholder="vous@votre-garage.com" required>
          </div>
          @error('email')<p class="err"><i class="fas fa-circle-exclamation"></i>{{ $message }}</p>@enderror
        </div>
      </div>

      <div class="form-grid two" style="margin-bottom:24px">
        <div class="form-group">
          <label class="form-label">Mot de passe</label>
          <div class="input-wrap">
            <i class="fas fa-lock ic"></i>
            <input class="form-control {{ $errors->has('password') ? 'error' : '' }}"
                   type="password" name="password" placeholder="8+ caractères" required>
          </div>
          @error('password')<p class="err"><i class="fas fa-circle-exclamation"></i>{{ $message }}</p>@enderror
        </div>
        <div class="form-group">
          <label class="form-label">Confirmer le mot de passe</label>
          <div class="input-wrap">
            <i class="fas fa-lock ic"></i>
            <input class="form-control" type="password" name="password_confirmation"
                   placeholder="Répétez le mot de passe" required>
          </div>
        </div>
      </div>

      <button type="submit" class="btn-submit">
        <i class="fas fa-rocket"></i> Créer mon garage gratuitement
      </button>
    </form>

    <p class="login-link">Déjà un compte ? <a href="{{ route('login') }}">Se connecter</a></p>
  </div>
</div>

</body>
</html>
