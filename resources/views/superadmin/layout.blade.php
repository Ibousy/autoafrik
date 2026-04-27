<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>AutoAfrik — Super Admin @yield('title')</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:'Segoe UI',system-ui,sans-serif;background:#F1F5F9;color:#1E293B;min-height:100vh;display:flex;flex-direction:column}
a{text-decoration:none;color:inherit}

/* Topbar */
.sa-topbar{background:#0D1B3E;color:#fff;height:60px;display:flex;align-items:center;padding:0 24px;gap:16px;position:sticky;top:0;z-index:100;box-shadow:0 2px 8px rgba(0,0,0,.3)}
.sa-logo{font-size:20px;font-weight:800;color:#F97316;letter-spacing:-0.5px}
.sa-logo span{color:#fff}
.sa-badge{background:#DC2626;color:#fff;font-size:10px;font-weight:700;padding:2px 8px;border-radius:20px;margin-left:8px;letter-spacing:.5px}
.sa-topbar-right{margin-left:auto;display:flex;align-items:center;gap:12px;font-size:13px;color:#94A3B8}
.sa-logout{background:#DC2626;color:#fff;border:none;padding:6px 14px;border-radius:8px;cursor:pointer;font-size:12px;font-weight:700;display:flex;align-items:center;gap:6px;transition:.15s}
.sa-logout:hover{background:#B91C1C}

/* Layout */
.sa-body{display:flex;flex:1}

/* Sidebar */
.sa-sidebar{width:220px;background:#fff;border-right:1px solid #E2E8F0;padding:20px 0;display:flex;flex-direction:column;gap:4px;position:sticky;top:60px;height:calc(100vh - 60px);overflow-y:auto;flex-shrink:0}
.sa-nav-item{display:flex;align-items:center;gap:10px;padding:10px 20px;font-size:13px;font-weight:500;color:#64748B;border-radius:0;transition:.15s;cursor:pointer}
.sa-nav-item:hover{background:#FFF7ED;color:#F97316}
.sa-nav-item.active{background:#FFF7ED;color:#F97316;border-right:3px solid #F97316;font-weight:700}
.sa-nav-item i{width:16px;text-align:center;font-size:13px}
.sa-nav-section{padding:14px 20px 6px;font-size:10px;font-weight:700;color:#94A3B8;letter-spacing:1px;text-transform:uppercase}

/* Main */
.sa-main{flex:1;padding:28px 32px;overflow-y:auto}
.sa-page-title{font-size:22px;font-weight:800;color:#0D1B3E;margin-bottom:4px}
.sa-page-sub{font-size:13px;color:#64748B;margin-bottom:24px}

/* Cards */
.sa-card{background:#fff;border-radius:12px;border:1px solid #E2E8F0;padding:20px;box-shadow:0 1px 4px rgba(0,0,0,.04)}
.sa-stat-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:16px;margin-bottom:24px}
.sa-stat{background:#fff;border-radius:12px;border:1px solid #E2E8F0;padding:18px 16px;display:flex;flex-direction:column;gap:6px}
.sa-stat-icon{width:36px;height:36px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:15px;margin-bottom:4px}
.sa-stat-val{font-size:26px;font-weight:800;color:#0D1B3E;line-height:1}
.sa-stat-lbl{font-size:11px;color:#64748B;font-weight:500}

/* Table */
.sa-table-wrap{overflow-x:auto;border-radius:12px;border:1px solid #E2E8F0;background:#fff}
table.sa-table{width:100%;border-collapse:collapse;font-size:13px}
table.sa-table th{background:#F8FAFC;padding:10px 14px;font-size:11px;font-weight:700;color:#64748B;text-align:left;border-bottom:1px solid #E2E8F0;white-space:nowrap;text-transform:uppercase;letter-spacing:.5px}
table.sa-table td{padding:10px 14px;border-bottom:1px solid #F1F5F9;color:#334155;vertical-align:middle}
table.sa-table tr:last-child td{border-bottom:none}
table.sa-table tr:hover td{background:#FAFCFF}

/* Badges */
.badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700}
.badge-green{background:#DCFCE7;color:#166534}
.badge-orange{background:#FFF7ED;color:#C2410C}
.badge-red{background:#FEF2F2;color:#DC2626}
.badge-blue{background:#EFF6FF;color:#1D4ED8}
.badge-gray{background:#F1F5F9;color:#64748B}
.badge-purple{background:#F3E8FF;color:#7E22CE}

/* Buttons */
.btn{display:inline-flex;align-items:center;gap:6px;padding:7px 16px;border-radius:9px;font-size:13px;font-weight:600;border:none;cursor:pointer;transition:.15s}
.btn-primary{background:#F97316;color:#fff}
.btn-primary:hover{background:#EA6C0A}
.btn-success{background:#10B981;color:#fff}
.btn-success:hover{background:#059669}
.btn-danger{background:#EF4444;color:#fff}
.btn-danger:hover{background:#DC2626}
.btn-outline{background:#fff;color:#334155;border:1.5px solid #E2E8F0}
.btn-outline:hover{border-color:#94A3B8}
.btn-sm{padding:5px 12px;font-size:12px;border-radius:7px}

/* Forms */
.sa-form-row{display:flex;flex-wrap:wrap;gap:12px;align-items:flex-end;margin-bottom:20px}
.sa-form-group{display:flex;flex-direction:column;gap:4px}
.sa-form-group label{font-size:11px;font-weight:600;color:#64748B;text-transform:uppercase;letter-spacing:.5px}
.sa-form-group select,.sa-form-group input{border:1.5px solid #E2E8F0;border-radius:8px;padding:7px 10px;font-size:13px;color:#334155;background:#fff;outline:none}
.sa-form-group select:focus,.sa-form-group input:focus{border-color:#F97316}

/* Alerts */
.sa-alert{padding:12px 16px;border-radius:10px;font-size:13px;margin-bottom:16px;display:flex;align-items:center;gap:10px}
.sa-alert-success{background:#DCFCE7;color:#166534;border:1px solid #BBF7D0}
.sa-alert-error{background:#FEF2F2;color:#DC2626;border:1px solid #FECACA}

/* Grid helpers */
.sa-grid-2{display:grid;grid-template-columns:1fr 1fr;gap:20px}
@media(max-width:900px){.sa-grid-2{grid-template-columns:1fr}}
</style>
</head>
<body>

<div class="sa-topbar">
    <div class="sa-logo">Auto<span>Afrik</span></div>
    <span class="sa-badge"><i class="fas fa-user-shield"></i> SUPER ADMIN</span>
    <div class="sa-topbar-right">
        <span><i class="fas fa-user-circle"></i> {{ auth()->user()->name }}</span>
        <form method="POST" action="{{ route('logout') }}" style="margin:0">
            @csrf
            <button type="submit" class="sa-logout"><i class="fas fa-sign-out-alt"></i> Déconnexion</button>
        </form>
    </div>
</div>

<div class="sa-body">
    <nav class="sa-sidebar">
        <div class="sa-nav-section">Navigation</div>
        <a href="{{ route('superadmin.dashboard') }}" class="sa-nav-item {{ request()->routeIs('superadmin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt"></i> Tableau de bord
        </a>
        <a href="{{ route('superadmin.companies') }}" class="sa-nav-item {{ request()->routeIs('superadmin.companies') || request()->routeIs('superadmin.company.show') ? 'active' : '' }}">
            <i class="fas fa-store"></i> Garages
        </a>
        <div class="sa-nav-section">Abonnements</div>
        <a href="{{ route('superadmin.renewals') }}" class="sa-nav-item {{ request()->routeIs('superadmin.renewals') ? 'active' : '' }}">
            <i class="fas fa-file-invoice"></i> Demandes
            @php $pending = \App\Models\RenewalRequest::where('status','pending')->count() @endphp
            @if($pending > 0)
                <span style="margin-left:auto;background:#DC2626;color:#fff;border-radius:20px;padding:1px 8px;font-size:10px;font-weight:700">{{ $pending }}</span>
            @endif
        </a>
    </nav>

    <main class="sa-main">
        @if(session('success'))
            <div class="sa-alert sa-alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="sa-alert sa-alert-error"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
        @endif

        @yield('content')
    </main>
</div>

</body>
</html>
