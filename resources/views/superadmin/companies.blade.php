@extends('superadmin.layout')
@section('title', '— Garages')

@section('content')
<div class="sa-page-title">Garages</div>
<div class="sa-page-sub">{{ $companies->total() }} garage(s) inscrits sur la plateforme</div>

{{-- Filters --}}
<form method="GET" class="sa-form-row">
    <div class="sa-form-group">
        <label>Recherche</label>
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Nom, email…" style="width:220px">
    </div>
    <div class="sa-form-group">
        <label>Plan</label>
        <select name="plan">
            <option value="">Tous les plans</option>
            @foreach(\App\Models\Company::plans() as $key => $info)
            <option value="{{ $key }}" {{ request('plan') === $key ? 'selected' : '' }}>{{ $info['label'] }}</option>
            @endforeach
        </select>
    </div>
    <div class="sa-form-group">
        <label>Statut</label>
        <select name="status">
            <option value="">Tous</option>
            <option value="active"    {{ request('status') === 'active'    ? 'selected' : '' }}>Actif</option>
            <option value="suspended" {{ request('status') === 'suspended' ? 'selected' : '' }}>Suspendu</option>
            <option value="inactive"  {{ request('status') === 'inactive'  ? 'selected' : '' }}>Inactif</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Filtrer</button>
    @if(request('q') || request('plan') || request('status'))
        <a href="{{ route('superadmin.companies') }}" class="btn btn-outline">Réinitialiser</a>
    @endif
</form>

<div class="sa-table-wrap">
    <table class="sa-table">
        <thead>
            <tr>
                <th>Garage</th>
                <th>Plan</th>
                <th>Statut</th>
                <th>Expiration</th>
                <th>Agents</th>
                <th>Créé</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @forelse($companies as $c)
        @php $planInfo = $c->plan_info; @endphp
        <tr>
            <td>
                <div style="font-weight:600;color:#0D1B3E">{{ $c->name }}</div>
                <div style="font-size:11px;color:#94A3B8">{{ $c->email }} · {{ $c->phone }}</div>
            </td>
            <td><span class="badge" style="background:{{ $planInfo['color'] }}22;color:{{ $planInfo['color'] }}"><i class="fas {{ $planInfo['icon'] }}"></i> {{ $planInfo['label'] }}</span></td>
            <td>
                @if($c->status === 'active') <span class="badge badge-green"><i class="fas fa-circle" style="font-size:7px"></i> Actif</span>
                @elseif($c->status === 'suspended') <span class="badge badge-red"><i class="fas fa-ban"></i> Suspendu</span>
                @else <span class="badge badge-gray">Inactif</span>
                @endif
            </td>
            <td style="font-size:12px;color:{{ $c->plan_expires_at && $c->plan_expires_at->isPast() ? '#DC2626' : '#334155' }}">
                {{ $c->plan_expires_at ? $c->plan_expires_at->format('d/m/Y') : '—' }}
                @if($c->plan_expires_at && $c->plan_expires_at->isPast()) <span style="font-size:10px;color:#DC2626;font-weight:700"> EXPIRÉ</span> @endif
            </td>
            <td style="font-size:13px">{{ $c->users_count ?? 0 }} / {{ $c->max_agents }}</td>
            <td style="font-size:12px;color:#64748B">{{ $c->created_at->format('d/m/Y') }}</td>
            <td>
                <a href="{{ route('superadmin.company.show', $c) }}" class="btn btn-sm btn-outline"><i class="fas fa-eye"></i> Détails</a>
            </td>
        </tr>
        @empty
        <tr><td colspan="7" style="text-align:center;color:#94A3B8;padding:30px">Aucun garage trouvé</td></tr>
        @endforelse
        </tbody>
    </table>
</div>

{{-- Pagination --}}
<div style="margin-top:16px">{{ $companies->links() }}</div>
@endsection
