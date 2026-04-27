@extends('superadmin.layout')
@section('title', '— ' . $company->name)

@section('content')
<div style="display:flex;align-items:center;gap:12px;margin-bottom:4px">
    <a href="{{ route('superadmin.companies') }}" style="color:#64748B;font-size:13px"><i class="fas fa-arrow-left"></i> Retour</a>
</div>
<div class="sa-page-title">{{ $company->name }}</div>
<div class="sa-page-sub">Gestion du garage et de l'abonnement</div>

<div class="sa-grid-2">

    {{-- Info + Edit plan --}}
    <div class="sa-card">
        <div style="font-size:14px;font-weight:700;color:#0D1B3E;margin-bottom:16px"><i class="fas fa-store" style="color:#F97316"></i> Informations</div>
        <table style="width:100%;font-size:13px;border-collapse:collapse">
            <tr><td style="color:#64748B;padding:5px 0;width:120px">Email</td><td style="font-weight:500">{{ $company->email ?? '—' }}</td></tr>
            <tr><td style="color:#64748B;padding:5px 0">Téléphone</td><td>{{ $company->phone ?? '—' }}</td></tr>
            <tr><td style="color:#64748B;padding:5px 0">Adresse</td><td>{{ $company->address ?? '—' }}</td></tr>
            <tr><td style="color:#64748B;padding:5px 0">Slug</td><td style="font-family:monospace;font-size:12px">{{ $company->slug }}</td></tr>
            <tr><td style="color:#64748B;padding:5px 0">Inscription</td><td>{{ $company->created_at->format('d/m/Y H:i') }}</td></tr>
        </table>

        <div style="margin-top:20px;border-top:1px solid #F1F5F9;padding-top:16px">
            <div style="font-size:13px;font-weight:700;color:#0D1B3E;margin-bottom:12px">Modifier l'abonnement</div>
            <form method="POST" action="{{ route('superadmin.company.update', $company) }}">
                @csrf @method('PATCH')
                <div style="display:flex;flex-direction:column;gap:10px">
                    <div class="sa-form-group">
                        <label>Plan</label>
                        <select name="plan">
                            @foreach(\App\Models\Company::plans() as $key => $info)
                            <option value="{{ $key }}" {{ $company->plan === $key ? 'selected' : '' }}>{{ $info['label'] }} ({{ number_format($info['price']) }} FCFA/mois)</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="sa-form-group">
                        <label>Statut</label>
                        <select name="status">
                            <option value="active"    {{ $company->status === 'active'    ? 'selected' : '' }}>Actif</option>
                            <option value="suspended" {{ $company->status === 'suspended' ? 'selected' : '' }}>Suspendu</option>
                            <option value="inactive"  {{ $company->status === 'inactive'  ? 'selected' : '' }}>Inactif</option>
                        </select>
                    </div>
                    <div class="sa-form-group">
                        <label>Expiration abonnement</label>
                        <input type="date" name="plan_expires_at" value="{{ $company->plan_expires_at?->format('Y-m-d') }}">
                    </div>
                    <div class="sa-form-group">
                        <label>Max agents</label>
                        <input type="number" name="max_agents" value="{{ $company->max_agents }}" min="1" max="9999">
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Enregistrer</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Users --}}
    <div>
        <div class="sa-card" style="margin-bottom:20px">
            <div style="font-size:14px;font-weight:700;color:#0D1B3E;margin-bottom:14px">
                <i class="fas fa-users" style="color:#F97316"></i> Agents ({{ count($users) }} / {{ $company->max_agents }})
            </div>
            @forelse($users as $u)
            @php $ri = $u->role_info; @endphp
            <div style="display:flex;align-items:center;gap:10px;padding:7px 0;border-bottom:1px solid #F8FAFC">
                <div style="width:32px;height:32px;border-radius:50%;background:{{ $ri['color'] }}22;color:{{ $ri['color'] }};display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;flex-shrink:0">
                    {{ strtoupper(substr($u->name,0,1)) }}
                </div>
                <div style="flex:1;min-width:0">
                    <div style="font-size:13px;font-weight:600;color:#0D1B3E">{{ $u->name }}</div>
                    <div style="font-size:11px;color:#94A3B8">{{ $u->email }}</div>
                </div>
                <span class="badge" style="background:{{ $ri['color'] }}22;color:{{ $ri['color'] }};font-size:10px">{{ $ri['label'] }}</span>
                @if(!$u->is_active)<span class="badge badge-red" style="font-size:10px">Inactif</span>@endif
            </div>
            @empty
            <div style="color:#94A3B8;font-size:13px;text-align:center;padding:16px">Aucun agent</div>
            @endforelse
        </div>

        {{-- Renewals history --}}
        <div class="sa-card">
            <div style="font-size:14px;font-weight:700;color:#0D1B3E;margin-bottom:14px">
                <i class="fas fa-history" style="color:#F97316"></i> Historique abonnements
            </div>
            @forelse($renewals as $r)
            <div style="display:flex;align-items:center;gap:10px;padding:7px 0;border-bottom:1px solid #F8FAFC;font-size:12px">
                <div style="flex:1">
                    <span style="font-weight:600">{{ strtoupper($r->plan) }}</span> · {{ $r->duration_months }}mois · {{ number_format($r->amount) }} FCFA
                    <div style="color:#94A3B8;font-size:11px">{{ $r->created_at->format('d/m/Y') }}</div>
                </div>
                @if($r->status === 'approved')  <span class="badge badge-green">Approuvé</span>
                @elseif($r->status === 'rejected') <span class="badge badge-red">Rejeté</span>
                @else <span class="badge badge-orange">En attente</span>
                @endif
            </div>
            @empty
            <div style="color:#94A3B8;font-size:13px;text-align:center;padding:16px">Aucune demande</div>
            @endforelse
        </div>
    </div>

</div>
@endsection
