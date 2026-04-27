@extends('superadmin.layout')
@section('title', '— Demandes de renouvellement')

@section('content')
<div class="sa-page-title">Demandes de renouvellement</div>
<div class="sa-page-sub">{{ $renewals->total() }} demande(s) au total</div>

{{-- Filter --}}
<form method="GET" class="sa-form-row">
    <div class="sa-form-group">
        <label>Statut</label>
        <select name="status">
            <option value="">Tous</option>
            <option value="pending"  {{ request('status') === 'pending'  ? 'selected' : '' }}>En attente</option>
            <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approuvé</option>
            <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejeté</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary"><i class="fas fa-filter"></i> Filtrer</button>
    @if(request('status'))<a href="{{ route('superadmin.renewals') }}" class="btn btn-outline">Réinitialiser</a>@endif
</form>

<div class="sa-table-wrap">
    <table class="sa-table">
        <thead>
            <tr><th>Garage</th><th>Plan demandé</th><th>Durée</th><th>Montant</th><th>Statut</th><th>Date</th><th>Actions</th></tr>
        </thead>
        <tbody>
        @forelse($renewals as $r)
        <tr>
            <td>
                <div style="font-weight:600;color:#0D1B3E">{{ $r->company->name }}</div>
                <div style="font-size:11px;color:#94A3B8">{{ $r->company->email }}</div>
            </td>
            <td>
                @php $pi = \App\Models\Company::plans()[$r->plan] ?? []; @endphp
                <span class="badge" style="background:{{ ($pi['color'] ?? '#64748B') . '22' }};color:{{ $pi['color'] ?? '#64748B' }}">
                    <i class="fas {{ $pi['icon'] ?? 'fa-tag' }}"></i> {{ strtoupper($r->plan) }}
                </span>
            </td>
            <td style="font-size:13px">{{ $r->duration_months }} mois</td>
            <td style="font-size:13px;font-weight:600;color:#0D1B3E">{{ number_format($r->amount) }} FCFA</td>
            <td>
                @if($r->status === 'pending')  <span class="badge badge-orange"><i class="fas fa-clock"></i> En attente</span>
                @elseif($r->status === 'approved') <span class="badge badge-green"><i class="fas fa-check"></i> Approuvé</span>
                @else <span class="badge badge-red"><i class="fas fa-times"></i> Rejeté</span>
                @endif
            </td>
            <td style="font-size:12px;color:#64748B">{{ $r->created_at->format('d/m/Y H:i') }}</td>
            <td>
                @if($r->status === 'pending')
                <div style="display:flex;gap:6px;align-items:center;flex-wrap:wrap">
                    <form method="POST" action="{{ route('superadmin.renewal.approve', $r) }}" style="display:inline" onsubmit="return confirm('Approuver cet abonnement ?')">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-success"><i class="fas fa-check"></i> Approuver</button>
                    </form>
                    <button type="button" class="btn btn-sm btn-danger" onclick="showReject({{ $r->id }})"><i class="fas fa-times"></i> Rejeter</button>
                </div>
                {{-- Reject form (hidden) --}}
                <form id="reject-form-{{ $r->id }}" method="POST" action="{{ route('superadmin.renewal.reject', $r) }}" style="display:none;margin-top:8px">
                    @csrf
                    <div style="display:flex;gap:6px;align-items:flex-start;flex-direction:column">
                        <textarea name="reason" placeholder="Motif du rejet…" required style="width:100%;border:1.5px solid #FECACA;border-radius:8px;padding:6px;font-size:12px;resize:vertical" rows="2"></textarea>
                        <div style="display:flex;gap:6px">
                            <button type="submit" class="btn btn-sm btn-danger">Confirmer</button>
                            <button type="button" class="btn btn-sm btn-outline" onclick="hideReject({{ $r->id }})">Annuler</button>
                        </div>
                    </div>
                </form>
                @else
                    <a href="{{ route('superadmin.company.show', $r->company) }}" class="btn btn-sm btn-outline"><i class="fas fa-store"></i> Garage</a>
                @endif
            </td>
        </tr>
        @empty
        <tr><td colspan="7" style="text-align:center;color:#94A3B8;padding:30px">Aucune demande</td></tr>
        @endforelse
        </tbody>
    </table>
</div>

<div style="margin-top:16px">{{ $renewals->links() }}</div>

<script>
function showReject(id) {
    document.getElementById('reject-form-' + id).style.display = 'block';
}
function hideReject(id) {
    document.getElementById('reject-form-' + id).style.display = 'none';
}
</script>
@endsection
