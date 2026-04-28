<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>AutoAfrik — Logiciel de gestion garage pour l'Afrique</title>
<meta name="description" content="AutoAfrik est la plateforme SaaS tout-en-un pour gérer votre garage en Afrique. Réparations, locations, stock, comptabilité et équipe.">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
*{margin:0;padding:0;box-sizing:border-box}
:root{--navy:#0D1B3E;--navy2:#152648;--orange:#F97316;--orange2:#fb923c;--bg:#F8FAFC;--white:#fff;--text:#0F172A;--muted:#64748B;--border:#E2E8F0}
html{scroll-behavior:smooth}
body{font-family:'Inter',sans-serif;color:var(--text);background:var(--white);overflow-x:hidden}
a{text-decoration:none}

/* ── NAV ── */
nav{position:fixed;top:0;left:0;right:0;z-index:200;height:68px;display:flex;align-items:center;padding:0 40px;transition:.3s;background:rgba(255,255,255,.96);backdrop-filter:blur(16px);border-bottom:1px solid rgba(226,232,240,.8);box-shadow:0 1px 16px rgba(0,0,0,.04)}
.nav-inner{max-width:1200px;margin:0 auto;width:100%;display:flex;align-items:center;justify-content:space-between}
.nav-logo{display:flex;align-items:center;gap:11px;text-decoration:none}
.nav-logo .icon{width:40px;height:40px;background:linear-gradient(135deg,var(--orange),var(--orange2));border-radius:11px;display:flex;align-items:center;justify-content:center;color:#fff;font-size:18px;box-shadow:0 4px 14px rgba(249,115,22,.35);flex-shrink:0}
.nav-logo strong{font-size:17px;font-weight:800;color:var(--navy);letter-spacing:-.4px}
.nav-logo strong span{color:var(--orange)}
.nav-logo em{font-size:10px;font-weight:600;color:var(--muted);letter-spacing:.8px;text-transform:uppercase;display:block;font-style:normal}
.nav-links{display:flex;align-items:center;gap:6px}
.nav-link{padding:8px 16px;border-radius:8px;font-size:13.5px;font-weight:600;color:var(--muted);transition:.15s}
.nav-link:hover{color:var(--navy)}
.nav-link.outline{border:1.5px solid var(--border);color:var(--navy)}
.nav-link.outline:hover{border-color:var(--orange);color:var(--orange)}
.nav-link.cta{background:linear-gradient(135deg,var(--orange),var(--orange2));color:#fff;padding:9px 20px;box-shadow:0 3px 12px rgba(249,115,22,.3)}
.nav-link.cta:hover{transform:translateY(-1px);box-shadow:0 6px 20px rgba(249,115,22,.4)}
.nav-mobile{display:none}
@media(max-width:640px){
  nav{padding:0 20px}
  .nav-links .nav-link:not(.outline):not(.cta){display:none}
}

/* ── HERO ── */
.hero{min-height:100vh;display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;padding:120px 24px 80px;background:linear-gradient(170deg,#f0f4ff 0%,#fff8f3 55%,#f0f9f4 100%);position:relative;overflow:hidden}
.hero-blob1{position:absolute;top:-160px;right:-120px;width:560px;height:560px;background:radial-gradient(circle,rgba(249,115,22,.09) 0%,transparent 70%);pointer-events:none}
.hero-blob2{position:absolute;bottom:-160px;left:-100px;width:480px;height:480px;background:radial-gradient(circle,rgba(13,27,62,.07) 0%,transparent 70%);pointer-events:none}
.hero-badge{display:inline-flex;align-items:center;gap:7px;background:rgba(249,115,22,.1);color:var(--orange);font-size:11.5px;font-weight:700;padding:6px 14px;border-radius:20px;letter-spacing:.6px;text-transform:uppercase;margin-bottom:28px;border:1px solid rgba(249,115,22,.22)}
.hero h1{font-size:clamp(38px,6.5vw,74px);font-weight:900;line-height:1.07;letter-spacing:-2.5px;color:var(--navy);max-width:860px;margin-bottom:22px}
.hero h1 .grad{background:linear-gradient(135deg,var(--orange),var(--orange2));-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text}
.hero-sub{font-size:18px;color:var(--muted);max-width:580px;line-height:1.72;margin-bottom:42px;font-weight:400}
.hero-actions{display:flex;align-items:center;gap:14px;flex-wrap:wrap;justify-content:center;margin-bottom:64px}
.btn-hero{display:inline-flex;align-items:center;gap:9px;padding:14px 28px;border-radius:11px;font-size:15px;font-weight:700;transition:.2s;letter-spacing:-.2px}
.btn-hero.primary{background:linear-gradient(135deg,var(--orange),var(--orange2));color:#fff;box-shadow:0 8px 28px rgba(249,115,22,.35)}
.btn-hero.primary:hover{transform:translateY(-2px);box-shadow:0 14px 38px rgba(249,115,22,.45)}
.btn-hero.ghost{background:#fff;color:var(--navy);border:2px solid var(--border);box-shadow:0 2px 8px rgba(0,0,0,.06)}
.btn-hero.ghost:hover{border-color:var(--navy);transform:translateY(-1px)}
.hero-stats{display:flex;align-items:center;gap:48px;padding-top:40px;border-top:1px solid var(--border);flex-wrap:wrap;justify-content:center}
.hero-stat strong{display:block;font-size:34px;font-weight:900;color:var(--navy);letter-spacing:-1.5px}
.hero-stat span{font-size:12.5px;color:var(--muted);font-weight:500;margin-top:2px}

/* ── TRUST BAR ── */
.trust-bar{background:#fff;border-top:1px solid var(--border);border-bottom:1px solid var(--border);padding:20px 24px;text-align:center}
.trust-inner{max-width:900px;margin:0 auto;display:flex;align-items:center;justify-content:center;gap:36px;flex-wrap:wrap;font-size:13px;font-weight:600;color:var(--muted)}
.trust-inner i{color:var(--orange);margin-right:6px}

/* ── SHARED ── */
.wrap{padding:100px 24px;max-width:1200px;margin:0 auto}
.section-tag{display:inline-flex;align-items:center;gap:6px;font-size:11px;font-weight:700;letter-spacing:.8px;text-transform:uppercase;color:var(--orange);margin-bottom:16px;background:rgba(249,115,22,.08);padding:5px 12px;border-radius:20px;border:1px solid rgba(249,115,22,.15)}
.section-title{font-size:clamp(28px,4vw,44px);font-weight:800;color:var(--navy);letter-spacing:-1.2px;line-height:1.15;margin-bottom:14px}
.section-sub{font-size:16px;color:var(--muted);line-height:1.68;max-width:560px}

/* ── FEATURES ── */
.features-bg{background:linear-gradient(180deg,#fff 0%,var(--bg) 100%);padding:100px 0}
.features-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:22px;margin-top:56px}
.feat{background:#fff;border:1.5px solid var(--border);border-radius:16px;padding:28px;transition:.2s;position:relative;overflow:hidden}
.feat::after{content:'';position:absolute;top:0;left:0;right:0;height:3px;background:linear-gradient(90deg,var(--orange),var(--orange2));transform:scaleX(0);transition:.25s;transform-origin:left}
.feat:hover{transform:translateY(-4px);box-shadow:0 16px 44px rgba(13,27,62,.09);border-color:rgba(249,115,22,.18)}
.feat:hover::after{transform:scaleX(1)}
.feat-ico{width:48px;height:48px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:20px;margin-bottom:18px}
.feat h3{font-size:15.5px;font-weight:700;color:var(--text);margin-bottom:8px}
.feat p{font-size:13.5px;color:var(--muted);line-height:1.65}

/* ── HOW IT WORKS ── */
.how-bg{background:var(--navy);padding:100px 0}
.how-bg .section-tag{background:rgba(249,115,22,.15);border-color:rgba(249,115,22,.3)}
.how-bg .section-title,.how-bg .section-sub{color:rgba(255,255,255,.9)}
.how-bg .section-sub{color:rgba(255,255,255,.55)}
.steps{display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:0;margin-top:60px;position:relative}
.steps::before{content:'';position:absolute;top:36px;left:12.5%;right:12.5%;height:2px;background:rgba(249,115,22,.25);z-index:0}
.step{text-align:center;padding:0 20px;position:relative;z-index:1}
.step-num{width:72px;height:72px;border-radius:50%;background:linear-gradient(135deg,var(--orange),var(--orange2));color:#fff;font-size:26px;font-weight:900;display:flex;align-items:center;justify-content:center;margin:0 auto 20px;box-shadow:0 6px 24px rgba(249,115,22,.4)}
.step h3{font-size:15px;font-weight:700;color:#fff;margin-bottom:8px}
.step p{font-size:13px;color:rgba(255,255,255,.5);line-height:1.6}

/* ── ROLES ── */
.roles-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(170px,1fr));gap:16px;margin-top:48px}
.role{background:var(--bg);border:1.5px solid var(--border);border-radius:14px;padding:22px 16px;text-align:center;transition:.18s}
.role:hover{border-color:rgba(249,115,22,.35);background:#fff;transform:translateY(-2px);box-shadow:0 8px 24px rgba(0,0,0,.06)}
.role-av{width:52px;height:52px;border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:22px;margin:0 auto 14px}
.role h4{font-size:14px;font-weight:700;color:var(--navy);margin-bottom:6px}
.role p{font-size:12px;color:var(--muted);line-height:1.5}

/* ── PLANS ── */
.plans-bg{background:var(--bg);padding:100px 0}
.plans-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:24px;margin-top:56px;max-width:1100px;margin-left:auto;margin-right:auto}
.plan{background:#fff;border:2px solid var(--border);border-radius:20px;padding:32px;position:relative;transition:.2s;display:flex;flex-direction:column}
.plan:hover{transform:translateY(-4px);box-shadow:0 20px 56px rgba(13,27,62,.1)}
.plan.hot{border-color:var(--orange);transform:scale(1.03)}
.plan.hot:hover{transform:scale(1.03) translateY(-4px)}
.plan-badge{position:absolute;top:-14px;left:50%;transform:translateX(-50%);background:linear-gradient(135deg,var(--orange),var(--orange2));color:#fff;font-size:10.5px;font-weight:700;padding:5px 16px;border-radius:20px;white-space:nowrap;letter-spacing:.4px;box-shadow:0 4px 14px rgba(249,115,22,.35)}
.plan-label{font-size:11px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:var(--muted);margin-bottom:12px}
.plan-price{font-size:42px;font-weight:900;color:var(--navy);letter-spacing:-2px;line-height:1}
.plan-price sup{font-size:16px;font-weight:700;vertical-align:super;letter-spacing:0}
.plan-price .per{font-size:14px;font-weight:500;color:var(--muted);letter-spacing:0}
.plan-free{font-size:38px;font-weight:900;color:#10B981;letter-spacing:-1px}
.plan-desc{font-size:13px;color:var(--muted);margin-top:10px;margin-bottom:24px;line-height:1.55;flex:1}
.plan-feats{list-style:none;margin-bottom:28px}
.plan-feats li{font-size:13.5px;color:var(--text);padding:8px 0;display:flex;align-items:center;gap:10px;border-bottom:1px solid #F8FAFC}
.plan-feats li:last-child{border-bottom:none}
.plan-feats li i.fa-check{color:var(--orange);font-size:11px;width:16px;flex-shrink:0}
.plan-feats li i.fa-times{color:#CBD5E1;font-size:11px;width:16px;flex-shrink:0}
.plan-feats li.dim{color:var(--muted)}
.plan-btn{display:block;text-align:center;padding:13px;border-radius:10px;font-size:14px;font-weight:700;transition:.15s;margin-top:auto}
.plan-btn.line{border:2px solid var(--border);color:var(--navy)}
.plan-btn.line:hover{border-color:var(--orange);color:var(--orange)}
.plan-btn.fill{background:linear-gradient(135deg,var(--orange),var(--orange2));color:#fff;box-shadow:0 6px 20px rgba(249,115,22,.3)}
.plan-btn.fill:hover{transform:translateY(-1px);box-shadow:0 10px 28px rgba(249,115,22,.4)}
.plan-btn.navy{background:var(--navy);color:#fff}
.plan-btn.navy:hover{background:var(--navy2)}
.plan-note{text-align:center;margin-top:24px;font-size:13px;color:var(--muted)}
.plan-note i{color:var(--orange);margin-right:4px}

/* ── TESTIMONIALS ── */
.testi-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:22px;margin-top:48px}
.testi{background:#fff;border:1.5px solid var(--border);border-radius:16px;padding:26px;transition:.2s}
.testi:hover{box-shadow:0 12px 36px rgba(0,0,0,.07);transform:translateY(-2px)}
.testi-stars{color:var(--orange);font-size:12px;margin-bottom:14px;letter-spacing:2px}
.testi p{font-size:14px;color:var(--text);line-height:1.7;margin-bottom:18px;font-style:italic}
.testi-author{display:flex;align-items:center;gap:12px}
.testi-av{width:40px;height:40px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:15px;font-weight:700;color:#fff;flex-shrink:0}
.testi-name{font-size:13.5px;font-weight:700;color:var(--navy)}
.testi-role{font-size:12px;color:var(--muted)}

/* ── FAQ ── */
.faq-list{max-width:740px;margin:48px auto 0;display:flex;flex-direction:column;gap:12px}
.faq-item{background:#fff;border:1.5px solid var(--border);border-radius:12px;overflow:hidden}
.faq-q{padding:18px 20px;font-size:14.5px;font-weight:700;color:var(--navy);cursor:pointer;display:flex;align-items:center;justify-content:space-between;gap:12px}
.faq-q i{color:var(--orange);transition:.2s;flex-shrink:0}
.faq-a{display:none;padding:0 20px 18px;font-size:13.5px;color:var(--muted);line-height:1.7}
.faq-item.open .faq-q i{transform:rotate(45deg)}
.faq-item.open .faq-a{display:block}

/* ── CTA ── */
.cta-bg{background:linear-gradient(135deg,var(--navy) 0%,#1e3a8a 50%,var(--navy) 100%);padding:96px 24px;text-align:center;position:relative;overflow:hidden}
.cta-bg::before{content:'';position:absolute;top:-120px;right:-80px;width:500px;height:500px;background:radial-gradient(circle,rgba(249,115,22,.18),transparent 70%);pointer-events:none}
.cta-bg::after{content:'';position:absolute;bottom:-120px;left:-80px;width:400px;height:400px;background:radial-gradient(circle,rgba(255,255,255,.05),transparent 70%);pointer-events:none}
.cta-bg h2{font-size:clamp(28px,4.5vw,50px);font-weight:900;color:#fff;letter-spacing:-1.5px;margin-bottom:16px;position:relative;z-index:1}
.cta-bg p{font-size:16px;color:rgba(255,255,255,.6);margin-bottom:40px;max-width:480px;margin-left:auto;margin-right:auto;line-height:1.65;position:relative;z-index:1}
.cta-actions{display:flex;align-items:center;gap:14px;justify-content:center;flex-wrap:wrap;position:relative;z-index:1}
.btn-cta-primary{display:inline-flex;align-items:center;gap:9px;padding:15px 30px;border-radius:11px;font-size:15px;font-weight:700;background:linear-gradient(135deg,var(--orange),var(--orange2));color:#fff;box-shadow:0 8px 28px rgba(249,115,22,.4);transition:.2s}
.btn-cta-primary:hover{transform:translateY(-2px);box-shadow:0 14px 40px rgba(249,115,22,.5)}
.btn-cta-ghost{display:inline-flex;align-items:center;gap:9px;padding:14px 24px;border-radius:11px;font-size:15px;font-weight:700;border:2px solid rgba(255,255,255,.2);color:#fff;transition:.2s}
.btn-cta-ghost:hover{border-color:rgba(255,255,255,.5);background:rgba(255,255,255,.06)}

/* ── FOOTER ── */
footer{background:var(--navy);padding:48px 40px 32px;border-top:1px solid rgba(255,255,255,.06)}
.foot-inner{max-width:1200px;margin:0 auto;display:grid;grid-template-columns:1.5fr 1fr 1fr 1fr;gap:40px;margin-bottom:40px}
.foot-brand .logo{display:flex;align-items:center;gap:10px;margin-bottom:16px}
.foot-brand .logo .ico{width:36px;height:36px;background:linear-gradient(135deg,var(--orange),var(--orange2));border-radius:9px;display:flex;align-items:center;justify-content:center;color:#fff;font-size:15px}
.foot-brand .logo strong{font-size:15px;font-weight:800;color:#fff}
.foot-brand .logo strong span{color:var(--orange)}
.foot-brand p{font-size:13px;color:rgba(255,255,255,.35);line-height:1.7}
.foot-col h5{font-size:11px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:rgba(255,255,255,.4);margin-bottom:16px}
.foot-col a{display:block;font-size:13.5px;color:rgba(255,255,255,.55);margin-bottom:10px;transition:.15s}
.foot-col a:hover{color:var(--orange)}
.foot-bottom{border-top:1px solid rgba(255,255,255,.07);padding-top:24px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;max-width:1200px;margin:0 auto}
.foot-bottom p{font-size:12px;color:rgba(255,255,255,.25)}

@media(max-width:900px){
  .foot-inner{grid-template-columns:1fr 1fr}
  .steps::before{display:none}
}
@media(max-width:640px){
  .hero{padding:100px 20px 60px}
  .hero-stats{gap:24px}
  .plan.hot{transform:none}
  .plan.hot:hover{transform:translateY(-4px)}
  .plans-grid{grid-template-columns:1fr}
  footer{padding:40px 20px 28px}
  .foot-inner{grid-template-columns:1fr}
}
</style>
</head>
<body>

<!-- ── NAV ── -->
<nav>
  <div class="nav-inner">
    <a class="nav-logo" href="/">
      <div class="icon"><i class="fas fa-car-side"></i></div>
      <div>
        <strong>Auto<span>Afrik</span></strong>
        <em>Gestion de garage</em>
      </div>
    </a>
    <div class="nav-links">
      <a href="#fonctionnalites" class="nav-link">Fonctionnalités</a>
      <a href="#tarifs" class="nav-link">Tarifs</a>
      <a href="#faq" class="nav-link">FAQ</a>
      @auth
        <a href="{{ route('dashboard') }}" class="nav-link outline">Mon garage</a>
      @else
        <a href="{{ route('login') }}" class="nav-link outline">Connexion</a>
        <a href="{{ route('register') }}" class="nav-link cta"><i class="fas fa-rocket"></i> Créer mon garage</a>
      @endauth
    </div>
  </div>
</nav>

<!-- ── HERO ── -->
<div class="hero">
  <div class="hero-blob1"></div>
  <div class="hero-blob2"></div>
  <div class="hero-badge"><i class="fas fa-map-marker-alt"></i> Conçu pour l'Afrique</div>
  <h1>La gestion de votre garage,<br><span class="grad">enfin simple</span></h1>
  <p class="hero-sub">AutoAfrik est la plateforme SaaS tout-en-un pour les garages et agences de location d'Afrique. Réparations, stock, comptabilité, équipe — tout en un seul endroit.</p>
  <div class="hero-actions">
    @auth
      <a href="{{ route('dashboard') }}" class="btn-hero primary"><i class="fas fa-th-large"></i> Accéder à mon garage</a>
    @else
      <a href="{{ route('register') }}" class="btn-hero primary"><i class="fas fa-rocket"></i> Démarrer l'essai gratuit</a>
      <a href="{{ route('login') }}" class="btn-hero ghost"><i class="fas fa-sign-in-alt"></i> Se connecter</a>
    @endauth
  </div>
  <div class="hero-stats">
    <div class="hero-stat"><strong>500+</strong><span>Garages inscrits</span></div>
    <div class="hero-stat"><strong>12 000+</strong><span>Réparations gérées</span></div>
    <div class="hero-stat"><strong>14 jours</strong><span>d'essai gratuit</span></div>
    <div class="hero-stat"><strong>6 pays</strong><span>d'Afrique de l'Ouest</span></div>
  </div>
</div>

<!-- ── TRUST BAR ── -->
<div class="trust-bar">
  <div class="trust-inner">
    <span><i class="fas fa-shield-alt"></i> Données sécurisées</span>
    <span><i class="fas fa-globe-africa"></i> Hébergé en Afrique</span>
    <span><i class="fas fa-mobile-alt"></i> Accessible sur mobile</span>
    <span><i class="fas fa-headset"></i> Support en français</span>
    <span><i class="fas fa-sync-alt"></i> Mises à jour automatiques</span>
  </div>
</div>

<!-- ── FEATURES ── -->
<div class="features-bg" id="fonctionnalites">
  <div class="wrap" style="padding-top:0;padding-bottom:0">
    <div class="section-tag"><i class="fas fa-bolt"></i> Fonctionnalités</div>
    <h2 class="section-title">Tout ce dont votre garage a besoin</h2>
    <p class="section-sub">Une solution complète pensée pour les réalités des garages africains, du petit atelier aux grandes enseignes.</p>
    <div class="features-grid">
      <div class="feat">
        <div class="feat-ico" style="background:rgba(249,115,22,.1);color:var(--orange)"><i class="fas fa-wrench"></i></div>
        <h3>Ordres de réparation</h3>
        <p>Créez et suivez chaque intervention. Assignez des mécaniciens, ajoutez les pièces utilisées et notifiez le client quand c'est prêt.</p>
      </div>
      <div class="feat">
        <div class="feat-ico" style="background:rgba(13,27,62,.08);color:var(--navy)"><i class="fas fa-users"></i></div>
        <h3>Gestion des clients</h3>
        <p>Fiche client complète avec historique de véhicules, réparations, locations et contacts. Retrouvez n'importe quel client en 2 secondes.</p>
      </div>
      <div class="feat">
        <div class="feat-ico" style="background:rgba(16,185,129,.1);color:#10B981"><i class="fas fa-key"></i></div>
        <h3>Location de véhicules</h3>
        <p>Gérez votre flotte de location : planning de disponibilité, contrats, tarification et suivi des retours.</p>
      </div>
      <div class="feat">
        <div class="feat-ico" style="background:rgba(59,130,246,.1);color:#3B82F6"><i class="fas fa-boxes"></i></div>
        <h3>Stock & Pièces</h3>
        <p>Contrôle en temps réel de votre inventaire. Alertes de stock bas, historique des mouvements et déstockage automatique à la réparation.</p>
      </div>
      <div class="feat">
        <div class="feat-ico" style="background:rgba(139,92,246,.1);color:#8B5CF6"><i class="fas fa-wallet"></i></div>
        <h3>Comptabilité</h3>
        <p>Recettes, dépenses, solde en temps réel. Exportez vos rapports financiers en PDF ou Excel pour votre comptable.</p>
      </div>
      <div class="feat">
        <div class="feat-ico" style="background:rgba(245,158,11,.1);color:#F59E0B"><i class="fas fa-hard-hat"></i></div>
        <h3>Gestion des employés</h3>
        <p>Fiches employés, paie, congés et permissions d'accès personnalisées par rôle. Chacun voit uniquement ce dont il a besoin.</p>
      </div>
      <div class="feat">
        <div class="feat-ico" style="background:rgba(239,68,68,.1);color:#EF4444"><i class="fas fa-chart-line"></i></div>
        <h3>Rapports & Statistiques</h3>
        <p>Tableaux de bord avec KPI en temps réel : chiffre d'affaires, taux d'occupation, véhicules les plus réparés, top clients.</p>
      </div>
      <div class="feat">
        <div class="feat-ico" style="background:rgba(6,182,212,.1);color:#06B6D4"><i class="fas fa-comments"></i></div>
        <h3>Messagerie équipe</h3>
        <p>Chat interne entre membres de l'équipe, avec notifications en temps réel et messagerie directe ou broadcast.</p>
      </div>
      <div class="feat">
        <div class="feat-ico" style="background:rgba(249,115,22,.08);color:var(--orange)"><i class="fas fa-bell"></i></div>
        <h3>Notifications intelligentes</h3>
        <p>Alertes automatiques pour les réparations terminées, stocks bas, véhicules en retard de location et plus encore.</p>
      </div>
    </div>
  </div>
</div>

<!-- ── HOW IT WORKS ── -->
<div class="how-bg">
  <div class="wrap" style="padding-top:0;padding-bottom:0">
    <div class="section-tag"><i class="fas fa-play-circle"></i> Comment ça marche</div>
    <h2 class="section-title">Opérationnel en 5 minutes</h2>
    <p class="section-sub">Pas d'installation, pas de serveur. Votre garage en ligne en quelques clics.</p>
    <div class="steps">
      <div class="step">
        <div class="step-num">1</div>
        <h3>Créez votre compte</h3>
        <p>Inscrivez-vous gratuitement. Aucune carte bancaire requise pour l'essai.</p>
      </div>
      <div class="step">
        <div class="step-num">2</div>
        <h3>Configurez votre garage</h3>
        <p>Ajoutez vos informations, logo, équipe et premières données en quelques minutes.</p>
      </div>
      <div class="step">
        <div class="step-num">3</div>
        <h3>Gérez au quotidien</h3>
        <p>Réparations, clients, stock, facturation — tout depuis une seule interface.</p>
      </div>
      <div class="step">
        <div class="step-num">4</div>
        <h3>Choisissez votre plan</h3>
        <p>À la fin de l'essai, choisissez le plan adapté à la taille de votre garage.</p>
      </div>
    </div>
  </div>
</div>

<!-- ── ROLES ── -->
<div style="background:#fff;padding:100px 0">
  <div class="wrap" style="padding-top:0;padding-bottom:0">
    <div class="section-tag"><i class="fas fa-users-cog"></i> Rôles & Équipe</div>
    <h2 class="section-title">Un accès adapté à chaque membre</h2>
    <p class="section-sub">Le propriétaire contrôle exactement ce que chaque agent peut voir et faire.</p>
    <div class="roles-grid">
      <div class="role">
        <div class="role-av" style="background:rgba(139,92,246,.1)"><i class="fas fa-crown" style="color:#8B5CF6"></i></div>
        <h4>Propriétaire</h4>
        <p>Accès total. Gère l'abonnement et toute l'équipe.</p>
      </div>
      <div class="role">
        <div class="role-av" style="background:rgba(13,27,62,.08)"><i class="fas fa-shield" style="color:var(--navy)"></i></div>
        <h4>Administrateur</h4>
        <p>Mêmes droits que le propriétaire sans la gestion du plan.</p>
      </div>
      <div class="role">
        <div class="role-av" style="background:rgba(59,130,246,.1)"><i class="fas fa-briefcase" style="color:#3B82F6"></i></div>
        <h4>Manager</h4>
        <p>Supervise les opérations et l'équipe au quotidien.</p>
      </div>
      <div class="role">
        <div class="role-av" style="background:rgba(249,115,22,.1)"><i class="fas fa-wrench" style="color:var(--orange)"></i></div>
        <h4>Mécanicien</h4>
        <p>Accède aux réparations et au stock de pièces.</p>
      </div>
      <div class="role">
        <div class="role-av" style="background:rgba(16,185,129,.1)"><i class="fas fa-calculator" style="color:#10B981"></i></div>
        <h4>Comptable</h4>
        <p>Gère la comptabilité et génère les rapports financiers.</p>
      </div>
      <div class="role">
        <div class="role-av" style="background:rgba(245,158,11,.1)"><i class="fas fa-headset" style="color:#F59E0B"></i></div>
        <h4>Réceptionniste</h4>
        <p>Accueille les clients, gère les rendez-vous et locations.</p>
      </div>
    </div>
  </div>
</div>

<!-- ── PLANS ── -->
<div class="plans-bg" id="tarifs">
  <div class="wrap" style="padding-top:0;padding-bottom:0">
    <div style="text-align:center">
      <div class="section-tag" style="display:inline-flex"><i class="fas fa-tags"></i> Tarifs transparents</div>
      <h2 class="section-title">Un plan pour chaque taille de garage</h2>
      <p class="section-sub" style="margin:0 auto 12px">Démarrez gratuitement 14 jours. Sans carte bancaire.</p>
    </div>
    <div class="plans-grid">

      {{-- Trial --}}
      <div class="plan">
        <div class="plan-label"><i class="fas fa-gift" style="color:var(--orange)"></i> Essai gratuit</div>
        <div class="plan-free">14 jours</div>
        <p class="plan-desc">Testez AutoAfrik sans engagement. Accédez à toutes les fonctionnalités pendant 14 jours.</p>
        <ul class="plan-feats">
          <li><i class="fas fa-check"></i> 3 agents maximum</li>
          <li><i class="fas fa-check"></i> Toutes les fonctionnalités</li>
          <li><i class="fas fa-check"></i> Sans carte bancaire</li>
          <li><i class="fas fa-check"></i> Support par email</li>
        </ul>
        <a href="{{ route('register') }}" class="plan-btn line">Commencer gratuitement</a>
      </div>

      {{-- Starter --}}
      <div class="plan">
        <div class="plan-label"><i class="fas fa-rocket" style="color:#3B82F6"></i> Starter</div>
        <div class="plan-price"><sup>FCFA </sup>15 000<span class="per"> / mois</span></div>
        <p class="plan-desc">Idéal pour les petits garages et ateliers familiaux qui veulent se digitaliser.</p>
        <ul class="plan-feats">
          <li><i class="fas fa-check"></i> 5 agents maximum</li>
          <li><i class="fas fa-check"></i> Réparations & Clients</li>
          <li><i class="fas fa-check"></i> Stock & Pièces</li>
          <li><i class="fas fa-check"></i> Comptabilité de base</li>
          <li class="dim"><i class="fas fa-times"></i> Export PDF/Excel</li>
          <li class="dim"><i class="fas fa-times"></i> Location de véhicules</li>
        </ul>
        <a href="{{ route('register') }}" class="plan-btn navy">Choisir Starter</a>
      </div>

      {{-- Pro --}}
      <div class="plan hot">
        <div class="plan-badge"><i class="fas fa-star"></i> Le plus populaire</div>
        <div class="plan-label"><i class="fas fa-star" style="color:var(--orange)"></i> Pro</div>
        <div class="plan-price"><sup>FCFA </sup>35 000<span class="per"> / mois</span></div>
        <p class="plan-desc">Pour les garages en croissance qui ont besoin de toutes les fonctionnalités.</p>
        <ul class="plan-feats">
          <li><i class="fas fa-check"></i> 20 agents maximum</li>
          <li><i class="fas fa-check"></i> Toutes les fonctionnalités</li>
          <li><i class="fas fa-check"></i> Location de véhicules</li>
          <li><i class="fas fa-check"></i> Export PDF & Excel</li>
          <li><i class="fas fa-check"></i> Rapports avancés</li>
          <li><i class="fas fa-check"></i> Messagerie équipe</li>
        </ul>
        <a href="{{ route('register') }}" class="plan-btn fill">Essayer 14 jours gratuits</a>
      </div>

      {{-- Enterprise --}}
      <div class="plan">
        <div class="plan-label"><i class="fas fa-crown" style="color:#8B5CF6"></i> Enterprise</div>
        <div class="plan-price"><sup>FCFA </sup>80 000<span class="per"> / mois</span></div>
        <p class="plan-desc">Pour les grandes enseignes et groupes de garages avec besoins avancés.</p>
        <ul class="plan-feats">
          <li><i class="fas fa-check"></i> Agents illimités</li>
          <li><i class="fas fa-check"></i> Toutes les fonctionnalités Pro</li>
          <li><i class="fas fa-check"></i> Support prioritaire</li>
          <li><i class="fas fa-check"></i> Formation incluse</li>
          <li><i class="fas fa-check"></i> Onboarding personnalisé</li>
          <li><i class="fas fa-check"></i> SLA garanti</li>
        </ul>
        <a href="{{ route('register') }}" class="plan-btn line">Nous contacter</a>
      </div>

    </div>
    <p class="plan-note"><i class="fas fa-percent"></i> Économisez jusqu'à <strong>20%</strong> avec un abonnement annuel</p>
  </div>
</div>

<!-- ── TESTIMONIALS ── -->
<div style="background:#fff;padding:100px 0">
  <div class="wrap" style="padding-top:0;padding-bottom:0">
    <div class="section-tag"><i class="fas fa-quote-left"></i> Témoignages</div>
    <h2 class="section-title">Ce que disent nos clients</h2>
    <p class="section-sub">Des centaines de garages à travers l'Afrique de l'Ouest font confiance à AutoAfrik.</p>
    <div class="testi-grid">
      <div class="testi">
        <div class="testi-stars">★★★★★</div>
        <p>"Avant AutoAfrik je perdais des heures à chercher dans des cahiers. Maintenant je retrouve l'historique d'un client en 5 secondes. Incroyable !"</p>
        <div class="testi-author">
          <div class="testi-av" style="background:linear-gradient(135deg,#F97316,#fb923c)">AM</div>
          <div>
            <div class="testi-name">Amadou Mbaye</div>
            <div class="testi-role">Propriétaire — Garage Central, Dakar</div>
          </div>
        </div>
      </div>
      <div class="testi">
        <div class="testi-stars">★★★★★</div>
        <p>"La gestion du stock était notre plus grand problème. Maintenant on reçoit une alerte automatique quand une pièce est basse. On ne tombe plus jamais à court."</p>
        <div class="testi-author">
          <div class="testi-av" style="background:linear-gradient(135deg,#3B82F6,#60a5fa)">FK</div>
          <div>
            <div class="testi-name">Fatou Koné</div>
            <div class="testi-role">Gérante — AutoService Abidjan</div>
          </div>
        </div>
      </div>
      <div class="testi">
        <div class="testi-stars">★★★★★</div>
        <p>"Le module location est parfait pour notre agence. Les contrats, les disponibilités, tout est automatisé. Mon équipe gagne 3h par jour."</p>
        <div class="testi-author">
          <div class="testi-av" style="background:linear-gradient(135deg,#10B981,#34d399)">OD</div>
          <div>
            <div class="testi-name">Oumar Diallo</div>
            <div class="testi-role">Directeur — Fleet Bamako</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- ── FAQ ── -->
<div style="background:var(--bg);padding:100px 0" id="faq">
  <div class="wrap" style="padding-top:0;padding-bottom:0;text-align:center">
    <div class="section-tag" style="display:inline-flex"><i class="fas fa-question-circle"></i> FAQ</div>
    <h2 class="section-title">Questions fréquentes</h2>
    <p class="section-sub" style="margin:0 auto">Vous avez d'autres questions ? Contactez-nous.</p>
  </div>
  <div class="faq-list">
    <div class="faq-item open">
      <div class="faq-q" onclick="toggleFaq(this)">
        Comment fonctionne l'essai gratuit ? <i class="fas fa-plus"></i>
      </div>
      <div class="faq-a">Créez votre compte, configurez votre garage et profitez de <strong>14 jours d'accès complet</strong> à toutes les fonctionnalités. Aucune carte bancaire n'est requise. À la fin de la période d'essai, choisissez le plan qui vous convient ou contactez-nous pour continuer.</div>
    </div>
    <div class="faq-item">
      <div class="faq-q" onclick="toggleFaq(this)">
        Puis-je changer de plan à tout moment ? <i class="fas fa-plus"></i>
      </div>
      <div class="faq-a">Oui. Vous pouvez upgrader ou downgrader votre plan à tout moment depuis votre espace abonnement. La mise à jour prend effet immédiatement après validation par notre équipe.</div>
    </div>
    <div class="faq-item">
      <div class="faq-q" onclick="toggleFaq(this)">
        Comment sont hébergées mes données ? <i class="fas fa-plus"></i>
      </div>
      <div class="faq-a">Vos données sont hébergées sur des serveurs sécurisés avec sauvegardes quotidiennes. Elles vous appartiennent entièrement et ne sont jamais partagées avec des tiers.</div>
    </div>
    <div class="faq-item">
      <div class="faq-q" onclick="toggleFaq(this)">
        L'application fonctionne-t-elle sur mobile ? <i class="fas fa-plus"></i>
      </div>
      <div class="faq-a">AutoAfrik est entièrement responsive. Vous pouvez y accéder depuis n'importe quel navigateur mobile (Chrome, Firefox, Safari) sans rien installer.</div>
    </div>
    <div class="faq-item">
      <div class="faq-q" onclick="toggleFaq(this)">
        Comment puis-je payer mon abonnement ? <i class="fas fa-plus"></i>
      </div>
      <div class="faq-a">Vous soumettez votre demande de renouvellement depuis l'application. Notre équipe valide le paiement par virement, Mobile Money (Orange Money, Wave) ou d'autres méthodes locales disponibles.</div>
    </div>
  </div>
</div>

<!-- ── CTA ── -->
<div class="cta-bg">
  <h2>Prêt à transformer votre garage ?</h2>
  <p>Rejoignez des centaines de garages qui font déjà confiance à AutoAfrik. Démarrez gratuitement dès aujourd'hui.</p>
  <div class="cta-actions">
    <a href="{{ route('register') }}" class="btn-cta-primary">
      <i class="fas fa-rocket"></i> Créer mon garage gratuitement
    </a>
    <a href="{{ route('login') }}" class="btn-cta-ghost">
      <i class="fas fa-sign-in-alt"></i> J'ai déjà un compte
    </a>
  </div>
</div>

<!-- ── FOOTER ── -->
<footer>
  <div class="foot-inner">
    <div class="foot-brand">
      <div class="logo">
        <div class="ico"><i class="fas fa-car-side"></i></div>
        <strong>Auto<span>Afrik</span></strong>
      </div>
      <p>La plateforme SaaS de gestion de garage pensée pour les entrepreneurs africains.</p>
    </div>
    <div class="foot-col">
      <h5>Produit</h5>
      <a href="#fonctionnalites">Fonctionnalités</a>
      <a href="#tarifs">Tarifs</a>
      <a href="#faq">FAQ</a>
    </div>
    <div class="foot-col">
      <h5>Compte</h5>
      <a href="{{ route('register') }}">Créer un garage</a>
      <a href="{{ route('login') }}">Se connecter</a>
    </div>
    <div class="foot-col">
      <h5>Contact</h5>
      <a href="mailto:support@autoafrik.com">support@autoafrik.com</a>
      <a href="#">WhatsApp</a>
    </div>
  </div>
  <div class="foot-bottom">
    <p>&copy; {{ date('Y') }} AutoAfrik. Tous droits réservés.</p>
    <p>Conçu avec <i class="fas fa-heart" style="color:var(--orange)"></i> pour l'Afrique</p>
  </div>
</footer>

<script>
function toggleFaq(el) {
  const item = el.closest('.faq-item');
  const isOpen = item.classList.contains('open');
  document.querySelectorAll('.faq-item').forEach(i => i.classList.remove('open'));
  if (!isOpen) item.classList.add('open');
}
</script>
</body>
</html>
