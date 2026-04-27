<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>AutoAfrik — Renouveler l'abonnement</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:'Segoe UI',system-ui,sans-serif;background:#F1F5F9;color:#1E293B;min-height:100vh}
.topbar{background:#0D1B3E;color:#fff;height:56px;display:flex;align-items:center;padding:0 24px;gap:12px}
.logo{font-size:18px;font-weight:800;color:#F97316}
.logo span{color:#fff}
.topbar-right{margin-left:auto;display:flex;align-items:center;gap:12px;font-size:13px;color:#94A3B8}
.back-btn{display:flex;align-items:center;gap:6px;padding:6px 14px;background:rgba(255,255,255,.1);border:none;color:#fff;border-radius:8px;cursor:pointer;font-size:12px;font-weight:600;text-decoration:none;transition:.15s}
.back-btn:hover{background:rgba(255,255,255,.2)}
.container{max-width:780px;margin:32px auto;padding:0 20px}
.page-title{font-size:22px;font-weight:800;color:#0D1B3E;margin-bottom:4px}
.page-sub{font-size:13px;color:#64748B;margin-bottom:24px}
.card{background:#fff;border-radius:14px;border:1px solid #E2E8F0;padding:24px;margin-bottom:20px;box-shadow:0 1px 4px rgba(0,0,0,.04)}
.card-title{font-size:15px;font-weight:700;color:#0D1B3E;margin-bottom:16px;display:flex;align-items:center;gap:8px}
/* Current plan */
.plan-current{display:flex;align-items:center;gap:16px;padding:14px;border-radius:10px;background:#FFF7ED;border:1px solid #FED7AA}
.plan-icon{width:44px;height:44px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:20px;flex-shrink:0}
/* Plans grid */
.plans-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:14px}
.plan-card{border:2px solid #E2E8F0;border-radius:12px;padding:16px;cursor:pointer;transition:.15s;position:relative}
.plan-card:hover{border-color:#F97316;background:#FFFBF5}
.plan-card.selected{border-color:#F97316;background:#FFF7ED}
.plan-card input[type=radio]{position:absolute;opacity:0;pointer-events:none}
.plan-price{font-size:20px;font-weight:800;color:#0D1B3E;margin:8px 0 4px}
.plan-price span{font-size:12px;font-weight:400;color:#64748B}
/* Duration */
.dur-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:10px}
.dur-card{border:2px solid #E2E8F0;border-radius:10px;padding:12px;cursor:pointer;text-align:center;transition:.15s;position:relative}
.dur-card:hover{border-color:#F97316}
.dur-card.selected{border-color:#F97316;background:#FFF7ED}
.dur-card input[type=radio]{position:absolute;opacity:0;pointer-events:none}
.dur-disc{display:inline-block;background:#DCFCE7;color:#16A34A;font-size:10px;font-weight:700;padding:2px 7px;border-radius:20px;margin-top:4px}
/* Submit */
.btn-submit{width:100%;padding:14px;background:#F97316;color:#fff;border:none;border-radius:12px;font-size:15px;font-weight:700;cursor:pointer;transition:.15s;display:flex;align-items:center;justify-content:center;gap:8px}
.btn-submit:hover{background:#EA6C0A}
.btn-submit:disabled{background:#94A3B8;cursor:not-allowed}
/* Alert */
.alert{padding:12px 16px;border-radius:10px;font-size:13px;margin-bottom:16px;display:flex;align-items:center;gap:10px}
.alert-success{background:#DCFCE7;color:#166534;border:1px solid #BBF7D0}
.alert-error{background:#FEF2F2;color:#DC2626;border:1px solid #FECACA}
.alert-warning{background:#FEF9C3;color:#B45309;border:1px solid #FDE68A}
/* History */
.badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700}
.badge-green{background:#DCFCE7;color:#166534}
.badge-orange{background:#FFF7ED;color:#C2410C}
.badge-red{background:#FEF2F2;color:#DC2626}
</style>
</head>
<body>

<div class="topbar">
    <div class="logo">Auto<span>Afrik</span></div>
    <div class="topbar-right">
        <a href="{{ route('dashboard') }}" class="back-btn"><i class="fas fa-arrow-left"></i> Retour au garage</a>
    </div>
</div>

<div class="container">
    <div class="page-title">Abonnement</div>
    <div class="page-sub">Gérez l'abonnement de votre garage</div>

    @if(session('success'))
        <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}</div>
    @endif

    {{-- Current plan --}}
    <div class="card">
        <div class="card-title"><i class="fas fa-star" style="color:#F97316"></i> Abonnement actuel</div>
        @php $pi = $company->plan_info; @endphp
        <div class="plan-current">
            <div class="plan-icon" style="background:{{ $pi['color'] }}22;color:{{ $pi['color'] }}">
                <i class="fas {{ $pi['icon'] }}"></i>
            </div>
            <div>
                <div style="font-size:16px;font-weight:800;color:#0D1B3E">{{ $pi['label'] }}</div>
                <div style="font-size:12px;color:#64748B;margin-top:2px">
                    Max {{ $company->max_agents }} agents ·
                    @if($company->plan_expires_at)
                        Expire le {{ $company->plan_expires_at->format('d/m/Y') }}
                        @if($company->plan_expires_at->isPast())
                            <span style="color:#DC2626;font-weight:700"> (EXPIRÉ)</span>
                        @elseif($company->plan_expires_at->diffInDays(now()) < 30)
                            <span style="color:#F59E0B;font-weight:700"> (expire bientôt)</span>
                        @endif
                    @else
                        Sans expiration
                    @endif
                </div>
            </div>
            <div style="margin-left:auto">
                @if($company->status === 'active')
                    <span class="badge badge-green"><i class="fas fa-circle" style="font-size:7px"></i> Actif</span>
                @else
                    <span class="badge badge-red"><i class="fas fa-ban"></i> {{ ucfirst($company->status) }}</span>
                @endif
            </div>
        </div>
    </div>

    @if($pending)
    {{-- Pending request warning --}}
    <div class="alert alert-warning">
        <i class="fas fa-clock"></i>
        Une demande de renouvellement est en cours de traitement par notre équipe. Vous serez notifié dès validation.
    </div>
    @else
    {{-- Renewal form --}}
    <div class="card">
        <div class="card-title"><i class="fas fa-sync-alt" style="color:#F97316"></i> Demander un renouvellement</div>

        <form method="POST" action="{{ route('renewal.store') }}" id="renewal-form">
            @csrf

            {{-- Plan selection --}}
            <div style="font-size:13px;font-weight:700;color:#0D1B3E;margin-bottom:10px">1. Choisissez un plan</div>
            <div class="plans-grid" style="margin-bottom:20px">
                @foreach($plans as $key => $info)
                @if($key === 'trial') @continue @endif
                <label class="plan-card {{ old('plan', $company->plan) === $key ? 'selected' : '' }}" onclick="selectPlan('{{ $key }}')">
                    <input type="radio" name="plan" value="{{ $key }}" {{ old('plan', $company->plan) === $key ? 'checked' : '' }} onchange="calcTotal()">
                    <div style="font-size:11px;font-weight:700;color:{{ $info['color'] }};text-transform:uppercase"><i class="fas {{ $info['icon'] }}"></i> {{ $info['label'] }}</div>
                    <div class="plan-price">{{ number_format($info['price']) }} <span>FCFA/mois</span></div>
                    <div style="font-size:11px;color:#64748B">Max {{ $info['max_agents'] }} agents</div>
                </label>
                @endforeach
            </div>

            {{-- Duration selection --}}
            <div style="font-size:13px;font-weight:700;color:#0D1B3E;margin-bottom:10px">2. Durée de l'abonnement</div>
            <div class="dur-grid" style="margin-bottom:20px">
                @foreach([1 => ['label'=>'1 mois','disc'=>null], 3 => ['label'=>'3 mois','disc'=>'-5%'], 6 => ['label'=>'6 mois','disc'=>'-10%'], 12 => ['label'=>'12 mois','disc'=>'-20%']] as $months => $info)
                <label class="dur-card {{ old('duration_months', 1) == $months ? 'selected' : '' }}" onclick="selectDur({{ $months }})">
                    <input type="radio" name="duration_months" value="{{ $months }}" {{ old('duration_months', 1) == $months ? 'checked' : '' }} onchange="calcTotal()">
                    <div style="font-size:14px;font-weight:700;color:#0D1B3E">{{ $info['label'] }}</div>
                    @if($info['disc']) <div class="dur-disc">{{ $info['disc'] }}</div> @endif
                </label>
                @endforeach
            </div>

            {{-- Total --}}
            <div style="background:#F8FAFC;border-radius:10px;padding:14px;margin-bottom:20px;display:flex;justify-content:space-between;align-items:center">
                <div style="font-size:13px;color:#64748B">Montant total estimé</div>
                <div id="total-display" style="font-size:22px;font-weight:800;color:#F97316">—</div>
            </div>

            <button type="submit" class="btn-submit" id="submit-btn">
                <i class="fas fa-paper-plane"></i> Envoyer la demande de renouvellement
            </button>
        </form>
    </div>
    @endif

    {{-- History --}}
    @if($history->isNotEmpty())
    <div class="card">
        <div class="card-title"><i class="fas fa-history" style="color:#F97316"></i> Historique des demandes</div>
        @foreach($history as $r)
        <div style="display:flex;align-items:center;gap:12px;padding:8px 0;border-bottom:1px solid #F1F5F9;font-size:13px">
            <div style="flex:1">
                <span style="font-weight:600">{{ strtoupper($r->plan) }}</span> · {{ $r->duration_months }} mois · {{ number_format($r->amount) }} FCFA
                <div style="font-size:11px;color:#94A3B8">{{ $r->created_at->format('d/m/Y H:i') }}</div>
                @if($r->rejection_reason)
                    <div style="font-size:11px;color:#DC2626;margin-top:2px"><i class="fas fa-info-circle"></i> {{ $r->rejection_reason }}</div>
                @endif
            </div>
            @if($r->status === 'approved')  <span class="badge badge-green"><i class="fas fa-check"></i> Approuvé</span>
            @elseif($r->status === 'rejected') <span class="badge badge-red"><i class="fas fa-times"></i> Rejeté</span>
            @else <span class="badge badge-orange"><i class="fas fa-clock"></i> En attente</span>
            @endif
        </div>
        @endforeach
    </div>
    @endif
</div>

<script>
const PRICES = @json(collect($plans)->mapWithKeys(fn($v,$k)=>[$k=>$v['price']]));
const DISCOUNTS = {1:1.0, 3:0.95, 6:0.90, 12:0.80};

function getSelected(name) {
    const el = document.querySelector(`input[name="${name}"]:checked`);
    return el ? el.value : null;
}

function calcTotal() {
    const plan = getSelected('plan');
    const dur  = parseInt(getSelected('duration_months') || 1);
    if (!plan || !PRICES[plan]) { document.getElementById('total-display').textContent = '—'; return; }
    const total = Math.round(PRICES[plan] * dur * (DISCOUNTS[dur] || 1));
    document.getElementById('total-display').textContent = total.toLocaleString('fr-FR') + ' FCFA';
}

function selectPlan(key) {
    document.querySelectorAll('.plan-card').forEach(c => c.classList.remove('selected'));
    event.currentTarget.classList.add('selected');
    setTimeout(calcTotal, 0);
}

function selectDur(months) {
    document.querySelectorAll('.dur-card').forEach(c => c.classList.remove('selected'));
    event.currentTarget.classList.add('selected');
    setTimeout(calcTotal, 0);
}

// Init
calcTotal();
</script>
</body>
</html>
