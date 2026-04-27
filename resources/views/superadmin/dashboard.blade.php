@extends('superadmin.layout')
@section('title', '— Tableau de bord')

@section('content')
<div class="sa-page-title">Tableau de bord</div>
<div class="sa-page-sub">Vue d'ensemble de la plateforme AutoAfrik</div>

{{-- Stats --}}
<div class="sa-stat-grid">
    <div class="sa-stat">
        <div class="sa-stat-icon" style="background:#FFF7ED;color:#F97316"><i class="fas fa-store"></i></div>
        <div class="sa-stat-val">{{ $stats['total_companies'] }}</div>
        <div class="sa-stat-lbl">Garages total</div>
    </div>
    <div class="sa-stat">
        <div class="sa-stat-icon" style="background:#DCFCE7;color:#16A34A"><i class="fas fa-check-circle"></i></div>
        <div class="sa-stat-val">{{ $stats['active_companies'] }}</div>
        <div class="sa-stat-lbl">Garages actifs</div>
    </div>
    <div class="sa-stat">
        <div class="sa-stat-icon" style="background:#FEF2F2;color:#DC2626"><i class="fas fa-ban"></i></div>
        <div class="sa-stat-val">{{ $stats['suspended'] }}</div>
        <div class="sa-stat-lbl">Suspendus</div>
    </div>
    <div class="sa-stat">
        <div class="sa-stat-icon" style="background:#EFF6FF;color:#3B82F6"><i class="fas fa-users"></i></div>
        <div class="sa-stat-val">{{ $stats['total_users'] }}</div>
        <div class="sa-stat-lbl">Utilisateurs</div>
    </div>
    <div class="sa-stat">
        <div class="sa-stat-icon" style="background:#FEF9C3;color:#B45309"><i class="fas fa-clock"></i></div>
        <div class="sa-stat-val">{{ $stats['pending_renewals'] }}</div>
        <div class="sa-stat-lbl">Renouvellements en attente</div>
    </div>
</div>

{{-- Plans breakdown --}}
<div class="sa-grid-2" style="margin-bottom:24px">
    <div class="sa-card">
        <div style="font-size:14px;font-weight:700;color:#0D1B3E;margin-bottom:14px"><i class="fas fa-chart-pie" style="color:#F97316"></i> Répartition des plans</div>
        @php $plans = \App\Models\Company::plans(); @endphp
        @foreach($plans as $key => $info)
        @php $count = $stats['plans'][$key] ?? 0; $total = max(1, $stats['total_companies']); @endphp
        <div style="margin-bottom:10px">
            <div style="display:flex;justify-content:space-between;font-size:12px;font-weight:600;margin-bottom:4px">
                <span><i class="fas {{ $info['icon'] }}" style="color:{{ $info['color'] }}"></i> {{ $info['label'] }}</span>
                <span>{{ $count }}</span>
            </div>
            <div style="background:#F1F5F9;border-radius:4px;height:6px">
                <div style="width:{{ round($count/$total*100) }}%;background:{{ $info['color'] }};height:6px;border-radius:4px;transition:.3s"></div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Pending renewals --}}
    <div class="sa-card">
        <div style="font-size:14px;font-weight:700;color:#0D1B3E;margin-bottom:14px">
            <i class="fas fa-file-invoice" style="color:#F97316"></i> Renouvellements en attente
            @if(count($pendingRenewals))
                <a href="{{ route('superadmin.renewals') }}" style="float:right;font-size:12px;color:#F97316;font-weight:600">Voir tout</a>
            @endif
        </div>
        @forelse($pendingRenewals as $r)
        <div style="display:flex;align-items:center;gap:10px;padding:8px 0;border-bottom:1px solid #F1F5F9">
            <div style="flex:1;min-width:0">
                <div style="font-size:13px;font-weight:600;color:#0D1B3E;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $r->company->name }}</div>
                <div style="font-size:11px;color:#64748B">Plan {{ strtoupper($r->plan) }} · {{ $r->duration_months }}mois · {{ number_format($r->amount) }} FCFA</div>
            </div>
            <a href="{{ route('superadmin.renewals') }}" class="btn btn-sm btn-outline">Traiter</a>
        </div>
        @empty
        <div style="text-align:center;color:#94A3B8;padding:20px;font-size:13px"><i class="fas fa-check-circle"></i> Aucune demande en attente</div>
        @endforelse
    </div>
</div>

{{-- Recent companies --}}
<div class="sa-card">
    <div style="font-size:14px;font-weight:700;color:#0D1B3E;margin-bottom:14px">
        <i class="fas fa-store" style="color:#F97316"></i> Derniers garages inscrits
        <a href="{{ route('superadmin.companies') }}" style="float:right;font-size:12px;color:#F97316;font-weight:600">Voir tout</a>
    </div>
    <div class="sa-table-wrap" style="border:none">
        <table class="sa-table">
            <thead><tr><th>Garage</th><th>Plan</th><th>Statut</th><th>Expiration</th><th>Inscrits</th><th></th></tr></thead>
            <tbody>
            @foreach($recentCompanies as $c)
            @php $planInfo = $c->plan_info; @endphp
            <tr>
                <td>
                    <div style="font-weight:600;color:#0D1B3E">{{ $c->name }}</div>
                    <div style="font-size:11px;color:#94A3B8">{{ $c->email }}</div>
                </td>
                <td><span class="badge" style="background:{{ $planInfo['color'] }}22;color:{{ $planInfo['color'] }}"><i class="fas {{ $planInfo['icon'] }}"></i> {{ $planInfo['label'] }}</span></td>
                <td>
                    @if($c->status === 'active') <span class="badge badge-green"><i class="fas fa-circle" style="font-size:7px"></i> Actif</span>
                    @elseif($c->status === 'suspended') <span class="badge badge-red">Suspendu</span>
                    @else <span class="badge badge-gray">Inactif</span>
                    @endif
                </td>
                <td style="font-size:12px;color:#64748B">{{ $c->plan_expires_at ? $c->plan_expires_at->format('d/m/Y') : '—' }}</td>
                <td style="font-size:13px;color:#334155">{{ $c->users_count ?? 0 }}</td>
                <td><a href="{{ route('superadmin.company.show', $c) }}" class="btn btn-sm btn-outline"><i class="fas fa-eye"></i></a></td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
