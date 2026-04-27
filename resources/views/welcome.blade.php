<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>GaragePro Afrique — Gérez votre garage intelligemment</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
*{margin:0;padding:0;box-sizing:border-box}
:root{--navy:#0D1B3E;--navy2:#152648;--orange:#F97316;--orange2:#fb923c;--bg:#F1F5F9;--white:#fff;--text:#0F172A;--muted:#64748B;--border:#E2E8F0}
body{font-family:'Inter',sans-serif;color:var(--text);background:var(--white);overflow-x:hidden}

/* NAV */
nav{position:fixed;top:0;left:0;right:0;z-index:100;background:rgba(255,255,255,.92);backdrop-filter:blur(12px);border-bottom:1px solid var(--border);height:68px;display:flex;align-items:center;padding:0 40px}
.nav-inner{max-width:1200px;margin:0 auto;width:100%;display:flex;align-items:center;justify-content:space-between}
.nav-logo{display:flex;align-items:center;gap:10px;text-decoration:none}
.nav-logo .icon{width:40px;height:40px;background:linear-gradient(135deg,var(--orange),var(--orange2));border-radius:11px;display:flex;align-items:center;justify-content:center;color:#fff;font-size:18px;box-shadow:0 4px 14px rgba(249,115,22,.35)}
.nav-logo strong{font-size:16px;font-weight:800;color:var(--navy);letter-spacing:-.3px}
.nav-logo span{font-size:10px;font-weight:600;color:var(--muted);letter-spacing:.8px;text-transform:uppercase;display:block}
.nav-links{display:flex;align-items:center;gap:8px}
.nav-link{padding:8px 16px;border-radius:8px;font-size:13.5px;font-weight:600;text-decoration:none;transition:.15s}
.nav-link.outline{color:var(--navy);border:1.5px solid var(--border)}
.nav-link.outline:hover{border-color:var(--orange);color:var(--orange)}
.nav-link.primary{background:var(--navy);color:#fff}
.nav-link.primary:hover{background:var(--navy2)}

/* HERO */
.hero{min-height:100vh;display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;padding:120px 24px 80px;background:linear-gradient(160deg,#f8faff 0%,#fff7f0 50%,#f8faff 100%);position:relative;overflow:hidden}
.hero::before{content:'';position:absolute;top:-200px;right:-200px;width:600px;height:600px;background:radial-gradient(circle,rgba(249,115,22,.08) 0%,transparent 70%);pointer-events:none}
.hero::after{content:'';position:absolute;bottom:-200px;left:-200px;width:500px;height:500px;background:radial-gradient(circle,rgba(13,27,62,.06) 0%,transparent 70%);pointer-events:none}
.hero-badge{display:inline-flex;align-items:center;gap:8px;background:rgba(249,115,22,.1);color:var(--orange);font-size:12px;font-weight:700;padding:6px 14px;border-radius:20px;letter-spacing:.6px;text-transform:uppercase;margin-bottom:28px;border:1px solid rgba(249,115,22,.2)}
.hero h1{font-size:clamp(36px,6vw,72px);font-weight:900;line-height:1.08;letter-spacing:-2px;color:var(--navy);max-width:820px;margin-bottom:24px}
.hero h1 span{background:linear-gradient(135deg,var(--orange),var(--orange2));-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text}
.hero p{font-size:18px;color:var(--muted);max-width:560px;line-height:1.7;margin-bottom:44px;font-weight:400}
.hero-actions{display:flex;align-items:center;gap:14px;flex-wrap:wrap;justify-content:center}
.btn-hero{display:inline-flex;align-items:center;gap:9px;padding:14px 28px;border-radius:10px;font-size:15px;font-weight:700;text-decoration:none;transition:.18s;letter-spacing:-.2px}
.btn-hero.primary{background:linear-gradient(135deg,var(--orange),var(--orange2));color:#fff;box-shadow:0 8px 28px rgba(249,115,22,.35)}
.btn-hero.primary:hover{transform:translateY(-2px);box-shadow:0 12px 36px rgba(249,115,22,.45)}
.btn-hero.secondary{background:#fff;color:var(--navy);border:2px solid var(--border)}
.btn-hero.secondary:hover{border-color:var(--navy);transform:translateY(-1px)}
.hero-stats{display:flex;align-items:center;gap:40px;margin-top:64px;padding-top:48px;border-top:1px solid var(--border);flex-wrap:wrap;justify-content:center}
.hero-stat strong{display:block;font-size:32px;font-weight:900;color:var(--navy);letter-spacing:-1px}
.hero-stat span{font-size:13px;color:var(--muted);font-weight:500;margin-top:2px}

/* SECTION */
section{padding:96px 24px;max-width:1200px;margin:0 auto}
.section-tag{display:inline-flex;align-items:center;gap:6px;font-size:11px;font-weight:700;letter-spacing:.8px;text-transform:uppercase;color:var(--orange);margin-bottom:16px;background:rgba(249,115,22,.08);padding:5px 12px;border-radius:20px;border:1px solid rgba(249,115,22,.15)}
.section-title{font-size:clamp(28px,4vw,44px);font-weight:800;color:var(--navy);letter-spacing:-1px;line-height:1.15;margin-bottom:14px}
.section-sub{font-size:16px;color:var(--muted);line-height:1.65;max-width:560px}

/* FEATURES GRID */
.features-wrap{background:linear-gradient(180deg,#fff 0%,#F8FAFD 100%);padding:96px 0}
.features-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:24px;margin-top:56px}
.feat-card{background:#fff;border:1.5px solid var(--border);border-radius:16px;padding:28px;transition:.2s;position:relative;overflow:hidden}
.feat-card::before{content:'';position:absolute;top:0;left:0;right:0;height:3px;background:linear-gradient(90deg,var(--orange),var(--orange2));opacity:0;transition:.2s}
.feat-card:hover{transform:translateY(-4px);box-shadow:0 16px 48px rgba(13,27,62,.1);border-color:rgba(249,115,22,.2)}
.feat-card:hover::before{opacity:1}
.feat-icon{width:48px;height:48px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:20px;margin-bottom:18px}
.feat-icon.orange{background:rgba(249,115,22,.1);color:var(--orange)}
.feat-icon.navy{background:rgba(13,27,62,.08);color:var(--navy)}
.feat-icon.green{background:rgba(16,185,129,.1);color:#10B981}
.feat-icon.blue{background:rgba(59,130,246,.1);color:#3B82F6}
.feat-icon.purple{background:rgba(139,92,246,.1);color:#8B5CF6}
.feat-icon.yellow{background:rgba(245,158,11,.1);color:#F59E0B}
.feat-card h3{font-size:15.5px;font-weight:700;color:var(--text);margin-bottom:8px}
.feat-card p{font-size:13.5px;color:var(--muted);line-height:1.65}

/* ROLES */
.roles-wrap{background:var(--navy);padding:96px 0}
.roles-wrap .section-tag{background:rgba(249,115,22,.15);color:var(--orange2);border-color:rgba(249,115,22,.3)}
.roles-wrap .section-title{color:#fff}
.roles-wrap .section-sub{color:rgba(255,255,255,.55)}
.roles-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:16px;margin-top:48px}
.role-card{background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.1);border-radius:14px;padding:22px 18px;text-align:center;transition:.18s}
.role-card:hover{background:rgba(255,255,255,.09);border-color:rgba(249,115,22,.35);transform:translateY(-2px)}
.role-av{width:52px;height:52px;border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:22px;margin:0 auto 14px}
.role-card h4{font-size:14px;font-weight:700;color:#fff;margin-bottom:6px}
.role-card p{font-size:12px;color:rgba(255,255,255,.45);line-height:1.5}

/* PLANS */
.plans-wrap{background:var(--bg);padding:96px 0}
.plans-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:24px;margin-top:56px;max-width:900px;margin-left:auto;margin-right:auto}
.plan-card{background:#fff;border:2px solid var(--border);border-radius:18px;padding:32px;position:relative;transition:.2s}
.plan-card.popular{border-color:var(--orange);transform:scale(1.03)}
.plan-popular-badge{position:absolute;top:-14px;left:50%;transform:translateX(-50%);background:linear-gradient(135deg,var(--orange),var(--orange2));color:#fff;font-size:11px;font-weight:700;padding:5px 16px;border-radius:20px;white-space:nowrap;letter-spacing:.4px}
.plan-name{font-size:13px;font-weight:700;letter-spacing:.8px;text-transform:uppercase;color:var(--muted);margin-bottom:10px}
.plan-price{font-size:42px;font-weight:900;color:var(--navy);letter-spacing:-2px}
.plan-price sup{font-size:18px;font-weight:700;vertical-align:super;letter-spacing:0}
.plan-price span{font-size:14px;font-weight:500;color:var(--muted);letter-spacing:0}
.plan-desc{font-size:13px;color:var(--muted);margin-top:8px;margin-bottom:24px;line-height:1.5}
.plan-features{list-style:none;margin-bottom:28px}
.plan-features li{font-size:13.5px;color:var(--text);padding:7px 0;display:flex;align-items:center;gap:10px;border-bottom:1px solid #F1F5F9}
.plan-features li:last-child{border-bottom:none}
.plan-features li i{color:var(--orange);font-size:12px;width:16px}
.plan-btn{display:block;text-align:center;padding:12px;border-radius:9px;font-size:14px;font-weight:700;text-decoration:none;transition:.15s}
.plan-btn.outline{border:2px solid var(--border);color:var(--navy)}
.plan-btn.outline:hover{border-color:var(--orange);color:var(--orange)}
.plan-btn.filled{background:linear-gradient(135deg,var(--orange),var(--orange2));color:#fff;box-shadow:0 6px 20px rgba(249,115,22,.3)}
.plan-btn.filled:hover{transform:translateY(-1px);box-shadow:0 10px 28px rgba(249,115,22,.4)}

/* CTA BANNER */
.cta-wrap{background:linear-gradient(135deg,var(--navy) 0%,var(--navy2) 100%);padding:80px 24px;text-align:center;position:relative;overflow:hidden}
.cta-wrap::before{content:'';position:absolute;top:-100px;right:-100px;width:400px;height:400px;background:radial-gradient(circle,rgba(249,115,22,.15),transparent 70%);pointer-events:none}
.cta-wrap h2{font-size:clamp(26px,4vw,46px);font-weight:900;color:#fff;letter-spacing:-1px;margin-bottom:14px}
.cta-wrap p{font-size:16px;color:rgba(255,255,255,.55);margin-bottom:36px;max-width:500px;margin-left:auto;margin-right:auto;line-height:1.6}

/* FOOTER */
footer{background:var(--navy);padding:32px 40px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;border-top:1px solid rgba(255,255,255,.06)}
footer .foot-logo{display:flex;align-items:center;gap:9px;text-decoration:none}
footer .foot-logo .icon{width:30px;height:30px;background:linear-gradient(135deg,var(--orange),var(--orange2));border-radius:8px;display:flex;align-items:center;justify-content:center;color:#fff;font-size:14px}
footer .foot-logo span{font-size:13px;font-weight:700;color:rgba(255,255,255,.7)}
footer p{font-size:12px;color:rgba(255,255,255,.3)}

@media(max-width:640px){
  nav{padding:0 20px}
  .hero{padding:100px 20px 60px}
  .hero-stats{gap:24px}
  .plans-grid{grid-template-columns:1fr}
  .plan-card.popular{transform:none}
  footer{flex-direction:column;text-align:center;padding:24px 20px}
}
</style>
</head>
<body>

<!-- NAV -->
<nav>
  <div class="nav-inner">
    <a class="nav-logo" href="/">
      <div class="icon"><i class="fas fa-car-side"></i></div>
      <div>
        <strong>GaragePro</strong>
        <span>Afrique</span>
      </div>
    </a>
    <div class="nav-links">
      @auth
        <a href="{{ url('/dashboard') }}" class="nav-link outline">Mon tableau de bord</a>
      @else
        <a href="{{ route('login') }}" class="nav-link outline">Connexion</a>
        <a href="{{ route('register') }}" class="nav-link primary"><i class="fas fa-rocket"></i> Créer mon garage</a>
      @endauth
    </div>
  </div>
</nav>

<!-- HERO -->
<div class="hero">
  <div class="hero-badge"><i class="fas fa-star"></i> Conçu pour l'Afrique</div>
  <h1>Gérez votre garage<br><span>intelligemment</span></h1>
  <p>La plateforme tout-en-un pour les garages et agences de location d'Afrique. Réparations, clients, stock, comptabilité — tout en un seul endroit.</p>
  <div class="hero-actions">
    @auth
      <a href="{{ url('/dashboard') }}" class="btn-hero primary"><i class="fas fa-th-large"></i> Accéder au tableau de bord</a>
    @else
      <a href="{{ route('register') }}" class="btn-hero primary"><i class="fas fa-rocket"></i> Démarrer gratuitement</a>
      <a href="{{ route('login') }}" class="btn-hero secondary"><i class="fas fa-sign-in-alt"></i> Se connecter</a>
    @endauth
  </div>
  <div class="hero-stats">
    <div class="hero-stat"><strong>500+</strong><span>Garages actifs</span></div>
    <div class="hero-stat"><strong>15 000+</strong><span>Véhicules gérés</span></div>
    <div class="hero-stat"><strong>98%</strong><span>Satisfaction client</span></div>
    <div class="hero-stat"><strong>12</strong><span>Pays d'Afrique</span></div>
  </div>
</div>

<!-- FEATURES -->
<div class="features-wrap">
  <section>
    <div class="section-tag"><i class="fas fa-bolt"></i> Fonctionnalités</div>
    <h2 class="section-title">Tout ce dont votre garage a besoin</h2>
    <p class="section-sub">Une solution complète pensée pour simplifier votre quotidien et booster votre productivité.</p>
    <div class="features-grid">
      <div class="feat-card">
        <div class="feat-icon orange"><i class="fas fa-wrench"></i></div>
        <h3>Gestion des réparations</h3>
        <p>Suivez chaque intervention en temps réel. Assignez des mécaniciens, gérez les pièces et générez des bons de travail en quelques clics.</p>
      </div>
      <div class="feat-card">
        <div class="feat-icon navy"><i class="fas fa-users"></i></div>
        <h3>Base clients</h3>
        <p>Centralisez tous vos clients et leur historique. Retrouvez rapidement leurs véhicules, réparations passées et préférences.</p>
      </div>
      <div class="feat-card">
        <div class="feat-icon green"><i class="fas fa-key"></i></div>
        <h3>Location de véhicules</h3>
        <p>Gérez votre flotte de location avec planning de disponibilité, contrats et suivi des retours.</p>
      </div>
      <div class="feat-card">
        <div class="feat-icon blue"><i class="fas fa-boxes"></i></div>
        <h3>Stock & Pièces</h3>
        <p>Contrôlez votre inventaire en temps réel. Alertes de seuil bas, historique des mouvements et réapprovisionnement simplifié.</p>
      </div>
      <div class="feat-card">
        <div class="feat-icon purple"><i class="fas fa-wallet"></i></div>
        <h3>Comptabilité intégrée</h3>
        <p>Suivez vos revenus et dépenses, générez des rapports financiers et exportez en PDF ou Excel pour votre comptable.</p>
      </div>
      <div class="feat-card">
        <div class="feat-icon yellow"><i class="fas fa-user-shield"></i></div>
        <h3>Gestion des accès</h3>
        <p>Créez des comptes pour votre équipe avec des permissions personnalisées. Chaque employé voit uniquement ce dont il a besoin.</p>
      </div>
    </div>
  </section>
</div>

<!-- ROLES -->
<div class="roles-wrap">
  <section>
    <div class="section-tag"><i class="fas fa-users-cog"></i> Rôles &amp; Équipe</div>
    <h2 class="section-title">Un accès adapté à chaque membre</h2>
    <p class="section-sub">Le propriétaire décide exactement ce que chaque agent peut voir et faire dans l'application.</p>
    <div class="roles-grid">
      <div class="role-card">
        <div class="role-av" style="background:rgba(139,92,246,.15)"><i class="fas fa-crown" style="color:#8B5CF6"></i></div>
        <h4>Propriétaire</h4>
        <p>Accès total. Gère l'abonnement et toute l'équipe.</p>
      </div>
      <div class="role-card">
        <div class="role-av" style="background:rgba(249,115,22,.15)"><i class="fas fa-shield" style="color:var(--orange)"></i></div>
        <h4>Administrateur</h4>
        <p>Mêmes droits que le propriétaire sans la gestion du plan.</p>
      </div>
      <div class="role-card">
        <div class="role-av" style="background:rgba(59,130,246,.15)"><i class="fas fa-briefcase" style="color:#3B82F6"></i></div>
        <h4>Manager</h4>
        <p>Supervise les opérations et l'équipe au quotidien.</p>
      </div>
      <div class="role-card">
        <div class="role-av" style="background:rgba(249,115,22,.15)"><i class="fas fa-wrench" style="color:var(--orange)"></i></div>
        <h4>Mécanicien</h4>
        <p>Accède aux réparations et au stock de pièces.</p>
      </div>
      <div class="role-card">
        <div class="role-av" style="background:rgba(16,185,129,.15)"><i class="fas fa-calculator" style="color:#10B981"></i></div>
        <h4>Comptable</h4>
        <p>Gère la comptabilité et génère les rapports financiers.</p>
      </div>
      <div class="role-card">
        <div class="role-av" style="background:rgba(245,158,11,.15)"><i class="fas fa-headset" style="color:#F59E0B"></i></div>
        <h4>Réceptionniste</h4>
        <p>Accueille les clients, gère les rendez-vous et locations.</p>
      </div>
    </div>
  </section>
</div>

<!-- PLANS -->
<div class="plans-wrap">
  <section>
    <div style="text-align:center">
      <div class="section-tag" style="display:inline-flex"><i class="fas fa-tags"></i> Tarifs</div>
      <h2 class="section-title">Des plans pour chaque taille de garage</h2>
      <p class="section-sub" style="margin:0 auto">Commencez gratuitement. Évoluez à votre rythme.</p>
    </div>
    <div class="plans-grid">
      <div class="plan-card">
        <div class="plan-name">Starter</div>
        <div class="plan-price"><sup>FCFA</sup>0 <span>/ mois</span></div>
        <div class="plan-desc">Parfait pour démarrer votre garage.</div>
        <ul class="plan-features">
          <li><i class="fas fa-check"></i> 3 agents maximum</li>
          <li><i class="fas fa-check"></i> Réparations & Clients</li>
          <li><i class="fas fa-check"></i> Stock de base</li>
          <li><i class="fas fa-check"></i> Accès au tableau de bord</li>
        </ul>
        <a href="{{ route('register') }}" class="plan-btn outline">Commencer gratuitement</a>
      </div>
      <div class="plan-card popular">
        <div class="plan-popular-badge"><i class="fas fa-star"></i> Le plus populaire</div>
        <div class="plan-name">Pro</div>
        <div class="plan-price"><sup>FCFA</sup>15 000 <span>/ mois</span></div>
        <div class="plan-desc">Pour les garages en pleine croissance.</div>
        <ul class="plan-features">
          <li><i class="fas fa-check"></i> 10 agents</li>
          <li><i class="fas fa-check"></i> Toutes les fonctionnalités</li>
          <li><i class="fas fa-check"></i> Locations de véhicules</li>
          <li><i class="fas fa-check"></i> Rapports avancés</li>
          <li><i class="fas fa-check"></i> Export PDF & Excel</li>
        </ul>
        <a href="{{ route('register') }}" class="plan-btn filled">Essayer 14 jours gratuits</a>
      </div>
      <div class="plan-card">
        <div class="plan-name">Entreprise</div>
        <div class="plan-price"><sup>FCFA</sup>35 000 <span>/ mois</span></div>
        <div class="plan-desc">Pour les grands garages et flottes.</div>
        <ul class="plan-features">
          <li><i class="fas fa-check"></i> Agents illimités</li>
          <li><i class="fas fa-check"></i> Multi-site</li>
          <li><i class="fas fa-check"></i> Support prioritaire</li>
          <li><i class="fas fa-check"></i> Formation incluse</li>
          <li><i class="fas fa-check"></i> API & intégrations</li>
        </ul>
        <a href="{{ route('register') }}" class="plan-btn outline">Contacter les ventes</a>
      </div>
    </div>
  </section>
</div>

<!-- CTA -->
<div class="cta-wrap">
  <h2>Prêt à transformer votre garage ?</h2>
  <p>Rejoignez des centaines de garages qui font confiance à GaragePro Afrique pour gérer leur activité.</p>
  <a href="{{ route('register') }}" class="btn-hero primary" style="display:inline-flex">
    <i class="fas fa-rocket"></i> Créer mon garage gratuitement
  </a>
</div>

<!-- FOOTER -->
<footer>
  <a class="foot-logo" href="/">
    <div class="icon"><i class="fas fa-car-side"></i></div>
    <span>GaragePro Afrique</span>
  </a>
  <p>&copy; {{ date('Y') }} GaragePro Afrique. Tous droits réservés.</p>
</footer>

</body>
</html>
