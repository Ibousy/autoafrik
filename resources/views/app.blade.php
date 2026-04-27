  <!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>GaragePro Afrique</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.8.2/jspdf.plugin.autotable.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<style>
*{margin:0;padding:0;box-sizing:border-box}
:root{--navy:#0D1B3E;--navy2:#152648;--orange:#F97316;--orange-light:#FFF3E8;--bg:#F1F5F9;--white:#FFFFFF;--text:#0F172A;--muted:#64748B;--border:#E2E8F0;--success:#10B981;--danger:#EF4444;--warning:#F59E0B;--info:#3B82F6;--radius:12px;--shadow:0 1px 3px rgba(0,0,0,.06),0 4px 16px rgba(0,0,0,.07);--shadow-lg:0 8px 32px rgba(13,27,62,.12);--sidebar-w:260px}
body{font-family:'Inter',sans-serif;background:var(--bg);color:var(--text);display:flex;height:100vh;overflow:hidden;font-size:14px}
.sidebar{width:var(--sidebar-w);min-width:var(--sidebar-w);background:var(--navy);display:flex;flex-direction:column;height:100vh;overflow-y:auto}
.sidebar::-webkit-scrollbar{width:4px}.sidebar::-webkit-scrollbar-thumb{background:rgba(255,255,255,.1);border-radius:4px}
.sb-logo{padding:24px 20px 20px;border-bottom:1px solid rgba(255,255,255,.07)}
.sb-logo .logo-wrap{display:flex;align-items:center;gap:10px}
.sb-logo .logo-icon{width:38px;height:38px;background:linear-gradient(135deg,var(--orange),#fb923c);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:18px;color:#fff;box-shadow:0 4px 12px rgba(249,115,22,.35)}
.sb-logo .logo-text strong{display:block;font-size:15px;font-weight:700;color:#fff;letter-spacing:.3px}
.sb-logo .logo-text span{font-size:10px;color:rgba(255,255,255,.45);font-weight:500;letter-spacing:.8px;text-transform:uppercase}
.sb-section{padding:20px 12px 4px;font-size:10px;color:rgba(255,255,255,.3);font-weight:600;letter-spacing:1.2px;text-transform:uppercase}
.nav-item{display:flex;align-items:center;gap:12px;padding:10px 14px;margin:2px 8px;border-radius:9px;cursor:pointer;color:rgba(255,255,255,.58);font-size:13.5px;font-weight:500;transition:all .18s;position:relative}
.nav-item:hover{background:rgba(255,255,255,.07);color:rgba(255,255,255,.9)}
.nav-item.active{background:linear-gradient(135deg,rgba(249,115,22,.22),rgba(249,115,22,.12));color:#fff;border:1px solid rgba(249,115,22,.25)}
.nav-item.active .nav-icon{color:var(--orange)}
.nav-item .nav-icon{width:18px;text-align:center;font-size:14px}
.nav-item .badge{margin-left:auto;background:var(--orange);color:#fff;font-size:10px;font-weight:700;padding:2px 7px;border-radius:20px}
.sb-footer{margin-top:auto;padding:16px 12px;border-top:1px solid rgba(255,255,255,.07)}
.sb-user{display:flex;align-items:center;gap:10px;padding:8px 10px;border-radius:9px;cursor:pointer;transition:.15s}
.sb-user:hover{background:rgba(255,255,255,.07)}
.sb-user .av{width:34px;height:34px;border-radius:50%;background:linear-gradient(135deg,var(--orange),#fb923c);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:13px;flex-shrink:0}
.sb-user .info strong{display:block;color:#fff;font-size:13px;font-weight:600}
.sb-user .info span{font-size:11px;color:rgba(255,255,255,.4)}
.sb-user .chevron{margin-left:auto;color:rgba(255,255,255,.3);font-size:11px}
.main{flex:1;display:flex;flex-direction:column;overflow:hidden}
.topbar{height:68px;background:var(--white);border-bottom:1px solid var(--border);display:flex;align-items:center;padding:0 28px;gap:16px;flex-shrink:0}
.page-title h1{font-size:17px;font-weight:700;color:var(--text);min-width:180px}
.page-title p{font-size:12px;color:var(--muted);margin-top:1px}
.search-wrap{flex:1;max-width:420px;position:relative}
.search-wrap input{width:100%;padding:9px 14px 9px 38px;border:1.5px solid var(--border);border-radius:9px;font-size:13.5px;color:var(--text);background:#F8FAFC;outline:none;font-family:'Inter',sans-serif;transition:.15s}
.search-wrap input:focus{border-color:var(--orange);background:#fff;box-shadow:0 0 0 3px rgba(249,115,22,.1)}
.search-wrap .si{position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--muted);font-size:13px}
.tb-actions{margin-left:auto;display:flex;align-items:center;gap:8px}
.tb-btn{width:38px;height:38px;border-radius:9px;border:1.5px solid var(--border);background:#fff;cursor:pointer;display:flex;align-items:center;justify-content:center;color:var(--muted);font-size:15px;position:relative;transition:.15s}
.tb-btn:hover{border-color:var(--orange);color:var(--orange)}
.notif-dot{position:absolute;top:7px;right:7px;width:7px;height:7px;background:var(--orange);border-radius:50%;border:1.5px solid #fff}
.tb-profile{display:flex;align-items:center;gap:9px;padding:6px 12px;border:1.5px solid var(--border);border-radius:9px;cursor:pointer;transition:.15s}
.tb-profile:hover{border-color:var(--orange)}
.tb-profile .av{width:30px;height:30px;border-radius:50%;background:linear-gradient(135deg,var(--navy),var(--navy2));display:flex;align-items:center;justify-content:center;color:#fff;font-size:12px;font-weight:700}
.tb-profile .pname{font-size:13px;font-weight:600;color:var(--text)}
.tb-profile .prole{font-size:11px;color:var(--muted)}
.content{flex:1;overflow-y:auto;padding:28px}
.content::-webkit-scrollbar{width:5px}.content::-webkit-scrollbar-thumb{background:var(--border);border-radius:4px}
.view{display:none}.view.active{display:block;animation:fadeIn .22s ease}
@keyframes fadeIn{from{opacity:0;transform:translateY(8px)}to{opacity:1;transform:translateY(0)}}
.card{background:var(--white);border-radius:var(--radius);box-shadow:var(--shadow);padding:22px}
.card-title{font-size:14px;font-weight:600;color:var(--text);margin-bottom:18px;display:flex;align-items:center;justify-content:space-between}
.card-title .ct-left{display:flex;align-items:center;gap:8px}
.card-title .ct-icon{width:28px;height:28px;border-radius:7px;display:flex;align-items:center;justify-content:center;font-size:12px}
.kpi-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:18px;margin-bottom:24px}
.kpi{background:var(--white);border-radius:var(--radius);box-shadow:var(--shadow);padding:20px;border-left:4px solid transparent;transition:.2s;position:relative;overflow:hidden;cursor:default}
.kpi:hover{transform:translateY(-2px);box-shadow:var(--shadow-lg)}
.kpi.blue{border-left-color:var(--navy)}.kpi.orange{border-left-color:var(--orange)}.kpi.green{border-left-color:var(--success)}.kpi.info{border-left-color:var(--info)}
.kpi-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:10px}
.kpi-icon{width:42px;height:42px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:18px}
.kpi.blue .kpi-icon{background:rgba(13,27,62,.08);color:var(--navy)}.kpi.orange .kpi-icon{background:var(--orange-light);color:var(--orange)}.kpi.green .kpi-icon{background:rgba(16,185,129,.1);color:var(--success)}.kpi.info .kpi-icon{background:rgba(59,130,246,.1);color:var(--info)}
.kpi-badge{font-size:11px;font-weight:600;padding:3px 8px;border-radius:20px}
.kpi-badge.up{background:rgba(16,185,129,.12);color:var(--success)}.kpi-badge.down{background:rgba(239,68,68,.1);color:var(--danger)}
.kpi-value{font-size:26px;font-weight:800;color:var(--text);letter-spacing:-.5px}
.kpi-label{font-size:12.5px;color:var(--muted);font-weight:500}
.kpi-sub{font-size:11.5px;color:var(--muted);margin-top:4px}
.grid-2{display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:24px}
.grid-3{display:grid;grid-template-columns:1fr 1fr 1fr;gap:20px;margin-bottom:24px}
.grid-2-1{display:grid;grid-template-columns:2fr 1fr;gap:20px;margin-bottom:24px}
.grid-3-2{display:grid;grid-template-columns:3fr 2fr;gap:20px;margin-bottom:24px}
.mb24{margin-bottom:24px}
.tbl-wrap{overflow-x:auto}
table{width:100%;border-collapse:collapse}
thead th{padding:10px 14px;text-align:left;font-size:11.5px;font-weight:600;color:var(--muted);text-transform:uppercase;letter-spacing:.6px;border-bottom:1.5px solid var(--border)}
tbody tr{transition:.12s}
tbody tr:hover{background:#F8FAFC}
tbody td{padding:13px 14px;font-size:13.5px;color:var(--text);border-bottom:1px solid #F1F5F9;vertical-align:middle}
tbody tr:last-child td{border-bottom:none}
.badge{display:inline-flex;align-items:center;gap:5px;padding:4px 10px;border-radius:20px;font-size:11.5px;font-weight:600}
.badge::before{content:'';width:6px;height:6px;border-radius:50%;background:currentColor;opacity:.7}
.badge-success{background:rgba(16,185,129,.1);color:#059669}.badge-danger{background:rgba(239,68,68,.1);color:#DC2626}.badge-warning{background:rgba(245,158,11,.1);color:#D97706}.badge-info{background:rgba(59,130,246,.1);color:#2563EB}.badge-gray{background:#F1F5F9;color:#475569}.badge-orange{background:rgba(249,115,22,.1);color:#EA580C}.badge-navy{background:rgba(13,27,62,.08);color:var(--navy)}
.btn{display:inline-flex;align-items:center;gap:7px;padding:9px 16px;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;border:none;font-family:'Inter',sans-serif;transition:.15s}
.btn-primary{background:var(--navy);color:#fff}.btn-primary:hover{background:var(--navy2)}
.btn-orange{background:var(--orange);color:#fff}.btn-orange:hover{background:#ea6c0a}
.btn-outline{background:#fff;color:var(--text);border:1.5px solid var(--border)}.btn-outline:hover{border-color:var(--orange);color:var(--orange)}
.btn-sm{padding:6px 12px;font-size:12px;border-radius:7px}
.btn-ghost{background:transparent;color:var(--muted);border:none;padding:6px 10px;font-size:12.5px;font-weight:500;cursor:pointer;border-radius:7px;transition:.12s}
.btn-ghost:hover{background:#F1F5F9;color:var(--text)}
.sec-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:20px}
.sec-header h2{font-size:18px;font-weight:700}
.sec-header p{font-size:13px;color:var(--muted);margin-top:2px}
.btn-group{display:flex;gap:8px}
.chart-wrap{position:relative;height:220px}
.progress{height:6px;background:#E2E8F0;border-radius:99px;overflow:hidden}
.progress-bar{height:100%;border-radius:99px}
.av{width:32px;height:32px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;color:#fff}
.kanban{display:grid;grid-template-columns:repeat(3,1fr);gap:16px}
.k-col{background:#F8FAFC;border-radius:10px;padding:14px;border:1px solid var(--border)}
.k-col-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:12px}
.k-col-title{font-size:12.5px;font-weight:700;text-transform:uppercase;letter-spacing:.6px}
.k-count{width:22px;height:22px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;color:#fff}
.repair-card{background:#fff;border-radius:9px;padding:14px;margin-bottom:10px;box-shadow:0 1px 3px rgba(0,0,0,.06);border-left:3px solid transparent;cursor:pointer;transition:.15s}
.repair-card:hover{transform:translateY(-1px);box-shadow:var(--shadow)}
.repair-card.pending{border-left-color:var(--warning)}.repair-card.in-progress{border-left-color:var(--info)}.repair-card.done{border-left-color:var(--success)}
.rc-title{font-size:13px;font-weight:600;margin-bottom:4px}
.rc-sub{font-size:12px;color:var(--muted)}
.rc-footer{display:flex;align-items:center;justify-content:space-between;margin-top:10px;padding-top:8px;border-top:1px solid #F1F5F9}
.rc-mech{display:flex;align-items:center;gap:6px;font-size:12px;color:var(--muted)}
.rc-av{width:22px;height:22px;border-radius:50%;font-size:10px;font-weight:700;color:#fff;display:flex;align-items:center;justify-content:center}
.vehicle-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:18px}
.vc{background:#fff;border-radius:var(--radius);box-shadow:var(--shadow);overflow:hidden;transition:.2s;cursor:pointer}
.vc:hover{transform:translateY(-3px);box-shadow:var(--shadow-lg)}
.vc-img{height:150px;background:linear-gradient(135deg,#e2e8f0,#cbd5e1);display:flex;align-items:center;justify-content:center;font-size:48px;position:relative}
.vc-status{position:absolute;top:10px;right:10px}
.vc-body{padding:16px}
.vc-model{font-size:15px;font-weight:700;margin-bottom:2px}
.vc-cat{font-size:12px;color:var(--muted)}
.vc-footer{display:flex;align-items:center;justify-content:space-between;margin-top:12px;padding-top:12px;border-top:1px solid #F1F5F9}
.vc-price{font-size:16px;font-weight:800;color:var(--navy)}
.vc-price span{font-size:11px;font-weight:500;color:var(--muted)}
.emp-card{background:#fff;border-radius:var(--radius);box-shadow:var(--shadow);padding:20px;text-align:center;transition:.2s}
.emp-card:hover{transform:translateY(-2px);box-shadow:var(--shadow-lg)}
.emp-av{width:64px;height:64px;border-radius:50%;margin:0 auto 12px;display:flex;align-items:center;justify-content:center;font-size:22px;font-weight:800;color:#fff}
.emp-name{font-size:14px;font-weight:700;margin-bottom:2px}
.emp-role{font-size:12px;color:var(--muted);margin-bottom:12px}
.emp-stats{display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-bottom:14px}
.emp-stat{background:#F8FAFC;border-radius:7px;padding:8px;text-align:center}
.emp-stat strong{display:block;font-size:15px;font-weight:700}
.emp-stat span{font-size:11px;color:var(--muted)}
.stock-alert{background:rgba(239,68,68,.06);border:1px solid rgba(239,68,68,.2);border-radius:9px;padding:12px 16px;display:flex;align-items:center;gap:10px;margin-bottom:16px}
.fin-row{display:flex;align-items:center;justify-content:space-between;padding:12px 0;border-bottom:1px solid #F1F5F9}
.fin-row:last-child{border-bottom:none}
.fin-val.pos{color:var(--success)}.fin-val.neg{color:var(--danger)}
.res-panel{background:linear-gradient(135deg,var(--navy),#1e3a8a);border-radius:var(--radius);padding:22px;color:#fff}
.res-panel h3{font-size:15px;font-weight:700;margin-bottom:18px;display:flex;align-items:center;gap:8px}
.res-panel .form-label{color:rgba(255,255,255,.7);display:block;font-size:12.5px;font-weight:600;margin-bottom:6px}
.res-panel .form-control{width:100%;padding:10px 13px;border:1.5px solid rgba(255,255,255,.15);border-radius:8px;font-size:13.5px;color:#fff;background:rgba(255,255,255,.1);font-family:'Inter',sans-serif;outline:none;transition:.15s}
.res-panel .form-control:focus{border-color:var(--orange)}
.res-panel .form-control option{color:#0F172A;background:#fff}
.total-box{background:rgba(255,255,255,.1);border-radius:9px;padding:14px;margin-top:16px;display:flex;align-items:center;justify-content:space-between}
.total-box .tl{font-size:13px;color:rgba(255,255,255,.6)}
.total-box .tv{font-size:22px;font-weight:800;color:var(--orange)}
.form-group{margin-bottom:14px}
.form-label{display:block;font-size:12.5px;font-weight:600;color:var(--text);margin-bottom:6px}
.form-control{width:100%;padding:10px 13px;border:1.5px solid var(--border);border-radius:8px;font-size:13.5px;color:var(--text);background:#fff;font-family:'Inter',sans-serif;outline:none;transition:.15s}
.form-control:focus{border-color:var(--orange);box-shadow:0 0 0 3px rgba(249,115,22,.1)}
.form-row{display:grid;grid-template-columns:1fr 1fr;gap:14px}
.mini-stat{display:flex;align-items:center;gap:12px;padding:14px;background:#F8FAFC;border-radius:9px;border:1px solid var(--border);margin-bottom:10px}
.mini-stat .msi{width:38px;height:38px;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:16px;flex-shrink:0}
.mini-stat .msv{font-size:18px;font-weight:700}
.mini-stat .msl{font-size:12px;color:var(--muted)}
::-webkit-scrollbar{width:6px;height:6px}::-webkit-scrollbar-track{background:transparent}::-webkit-scrollbar-thumb{background:#CBD5E1;border-radius:4px}
.modal-overlay{position:fixed;inset:0;background:rgba(0,0,0,.48);z-index:1000;display:none;align-items:center;justify-content:center;padding:16px}
.modal{background:#fff;border-radius:16px;width:100%;max-width:560px;max-height:90vh;overflow-y:auto;box-shadow:0 24px 64px rgba(0,0,0,.22);flex-direction:column;display:none}
.modal.wide{max-width:700px}
.modal.active{display:flex}
.modal-header{padding:20px 24px 16px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;flex-shrink:0;position:sticky;top:0;background:#fff;z-index:1;border-radius:16px 16px 0 0}
.modal-header h3{font-size:15px;font-weight:700}
.modal-close{width:30px;height:30px;border-radius:8px;border:none;background:#F1F5F9;cursor:pointer;display:flex;align-items:center;justify-content:center;color:var(--muted);transition:.12s}
.modal-close:hover{background:#E2E8F0;color:var(--text)}
.modal-body{padding:20px 24px;flex:1}
.modal-footer{padding:14px 24px;border-top:1px solid var(--border);display:flex;justify-content:flex-end;gap:8px;flex-shrink:0;background:#fff;position:sticky;bottom:0;border-radius:0 0 16px 16px}
.agent-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:16px}
.agent-card{background:#fff;border-radius:var(--radius);box-shadow:var(--shadow);padding:20px;display:flex;align-items:center;gap:14px;transition:.2s;position:relative}
.agent-card:hover{transform:translateY(-2px);box-shadow:var(--shadow-lg)}
.agent-card .ag-av{width:48px;height:48px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:18px;font-weight:800;color:#fff;flex-shrink:0}
.agent-card .ag-info{flex:1;min-width:0}
.agent-card .ag-name{font-size:14px;font-weight:700;color:var(--text)}
.agent-card .ag-email{font-size:12px;color:var(--muted);white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.agent-card .ag-actions{display:flex;gap:6px;opacity:0;transition:.15s}
.agent-card:hover .ag-actions{opacity:1}
.plan-card{border-radius:var(--radius);padding:20px;border:2px solid var(--border);cursor:pointer;transition:.18s;position:relative}
.plan-card:hover{border-color:var(--orange)}
.plan-card.active{border-color:var(--orange);background:var(--orange-light)}
.plan-card.active::after{content:'Actuel';position:absolute;top:12px;right:12px;font-size:10px;font-weight:700;color:var(--orange);background:rgba(249,115,22,.12);padding:2px 8px;border-radius:20px}
.plan-name{font-size:15px;font-weight:700;margin-bottom:4px}
.plan-price{font-size:22px;font-weight:800;color:var(--navy);margin-bottom:8px}
.plan-price small{font-size:12px;font-weight:500;color:var(--muted)}
.plan-feature{font-size:12.5px;color:var(--muted);display:flex;align-items:center;gap:6px;margin-bottom:4px}
.plan-feature i{color:var(--success);font-size:11px}
.logo-upload-area{border:2px dashed var(--border);border-radius:10px;padding:24px;text-align:center;cursor:pointer;transition:.15s}
.logo-upload-area:hover{border-color:var(--orange);background:var(--orange-light)}
.logo-upload-area i{font-size:28px;color:var(--muted);margin-bottom:8px}
.perm-item{display:flex;align-items:center;gap:8px;padding:7px 10px;background:#fff;border:1.5px solid var(--border);border-radius:8px;cursor:pointer;transition:.12s;user-select:none}
.perm-item:hover{border-color:var(--orange)}
.perm-item.checked{border-color:var(--orange);background:var(--orange-light)}
.perm-item.checked .perm-dot{background:var(--orange)}
.perm-item.disabled{opacity:.45;cursor:not-allowed}
.detail-section{margin-bottom:20px}
.detail-section-title{font-size:10.5px;font-weight:700;text-transform:uppercase;letter-spacing:.8px;color:var(--muted);margin-bottom:10px;display:flex;align-items:center;gap:7px;padding-bottom:6px;border-bottom:1.5px solid var(--border)}
.detail-grid{display:grid;grid-template-columns:1fr 1fr;gap:10px}
.detail-grid.cols3{grid-template-columns:1fr 1fr 1fr}
.detail-item{background:#F8FAFC;border-radius:8px;padding:10px 12px}
.detail-item .di-label{font-size:10.5px;color:var(--muted);font-weight:600;text-transform:uppercase;letter-spacing:.5px;margin-bottom:4px}
.detail-item .di-value{font-size:13.5px;font-weight:600;color:var(--text)}
.detail-item .di-value.empty{color:var(--border);font-style:italic;font-weight:400}
.detail-banner{border-radius:12px;padding:20px;margin-bottom:20px;display:flex;align-items:center;gap:16px}
.detail-av{width:56px;height:56px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:22px;font-weight:800;color:#fff;flex-shrink:0}
.detail-hist-row{display:flex;align-items:center;justify-content:space-between;padding:9px 0;border-bottom:1px solid #F1F5F9;font-size:13px}
.detail-hist-row:last-child{border-bottom:none}
.perm-dot{width:14px;height:14px;border-radius:4px;border:2px solid #CBD5E1;flex-shrink:0;transition:.12s;display:flex;align-items:center;justify-content:center}
.perm-item.checked .perm-dot{border-color:var(--orange);background:var(--orange)}
.perm-dot::after{content:'✓';font-size:9px;color:#fff;display:none}
.perm-item.checked .perm-dot::after{display:block}
.perm-label{font-size:12.5px;font-weight:500;color:var(--text)}
.perm-icon{font-size:11px;color:var(--muted);width:14px;text-align:center}
</style>
</head>
<body>

<!-- SIDEBAR -->
<aside class="sidebar">
  <div class="sb-logo">
    <div class="logo-wrap">
      <div class="logo-icon" id="sb-logo-icon">
        @if(auth()->user()->company?->logo_path)
          <img src="{{ asset('storage/'.auth()->user()->company->logo_path) }}" style="width:100%;height:100%;object-fit:cover;border-radius:10px">
        @else
          <i class="fas fa-car"></i>
        @endif
      </div>
      <div class="logo-text">
        <strong id="sb-company-name">{{ auth()->user()->company?->name ?? 'AutoAfrik' }}</strong>
        <span id="sb-plan-label">{{ auth()->user()->company?->plan_info['label'] ?? 'SaaS' }}</span>
      </div>
    </div>
  </div>

  @php $u = auth()->user(); @endphp

  <div class="sb-section">Menu Principal</div>
  <div class="nav-item active" data-view="dashboard" onclick="showView('dashboard',this)">
    <i class="fas fa-chart-pie nav-icon"></i> Tableau de bord
  </div>
  @if($u->canView('clients'))
  <div class="nav-item" data-view="clients" onclick="showView('clients',this)">
    <i class="fas fa-users nav-icon"></i> Clients
  </div>
  @endif
  @if($u->canView('vehicules'))
  <div class="nav-item" data-view="vehicules" onclick="showView('vehicules',this)">
    <i class="fas fa-car nav-icon"></i> Véhicules
  </div>
  @endif
  @if($u->canView('reparations'))
  <div class="nav-item" data-view="reparations" onclick="showView('reparations',this)">
    <i class="fas fa-wrench nav-icon"></i> Réparations
    <span class="badge" id="badge-repairs">{{ $stats['repairs_in_progress'] }}</span>
  </div>
  @endif
  @if($u->canView('locations'))
  <div class="nav-item" data-view="locations" onclick="showView('locations',this)">
    <i class="fas fa-key nav-icon"></i> Locations
  </div>
  @endif
  @if($u->canView('stock'))
  <div class="nav-item" data-view="stock" onclick="showView('stock',this)">
    <i class="fas fa-boxes nav-icon"></i> Stock
  </div>
  @endif

  @if($u->canView('comptabilite') || $u->canView('employes') || $u->canView('rapports'))
  <div class="sb-section">Finance & RH</div>
  @endif
  @if($u->canView('comptabilite'))
  <div class="nav-item" data-view="comptabilite" onclick="showView('comptabilite',this)">
    <i class="fas fa-wallet nav-icon"></i> Comptabilité
  </div>
  @endif
  @if($u->canView('employes'))
  <div class="nav-item" data-view="employes" onclick="showView('employes',this)">
    <i class="fas fa-hard-hat nav-icon"></i> Employés
  </div>
  @endif
  @if($u->canView('rapports'))
  <div class="nav-item" data-view="rapports" onclick="showView('rapports',this)">
    <i class="fas fa-chart-bar nav-icon"></i> Rapports
  </div>
  @endif

  @if($u->canView('equipe') || $u->canView('parametres'))
  <div class="sb-section">Système</div>
  @endif
  @if($u->canView('equipe'))
  <div class="nav-item" data-view="equipe" onclick="showView('equipe',this)">
    <i class="fas fa-user-shield nav-icon"></i> Équipe & Accès
  </div>
  @endif
  @if($u->canView('parametres'))
  <div class="nav-item" data-view="parametres" onclick="showView('parametres',this)">
    <i class="fas fa-cog nav-icon"></i> Paramètres
  </div>
  @endif

  <div class="sb-footer">
    @php $company = auth()->user()->company; @endphp
    @if($company && $company->plan === 'trial')
    <div style="background:rgba(249,115,22,.12);border-radius:9px;padding:10px 12px;margin-bottom:10px;border:1px solid rgba(249,115,22,.2)">
      <div style="font-size:11px;color:#fb923c;font-weight:700;margin-bottom:2px">
        <i class="fas fa-clock"></i> Essai gratuit
      </div>
      <div style="font-size:11px;color:rgba(255,255,255,.5)">{{ $company->trialDaysLeft() }} jours restants</div>
      <a href="{{ route('renewal.show') }}" style="font-size:11px;color:var(--orange);font-weight:600;cursor:pointer;margin-top:4px;display:block">Passer au Pro →</a>
    </div>
    @elseif($company && $u->isAdmin())
    <a href="{{ route('renewal.show') }}" style="display:flex;align-items:center;gap:7px;padding:8px 10px;background:rgba(249,115,22,.1);border-radius:9px;margin-bottom:10px;border:1px solid rgba(249,115,22,.15);font-size:12px;color:#fb923c;font-weight:600;text-decoration:none">
      <i class="fas fa-sync-alt"></i> Renouveler l'abonnement
    </a>
    @endif
    <div class="sb-user">
      <div class="av" style="background:linear-gradient(135deg,var(--orange),#fb923c)">
        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}{{ strtoupper(substr(strstr(auth()->user()->name, ' '), 1, 1)) }}
      </div>
      <div class="info">
        <strong>{{ auth()->user()->name }}</strong>
        <span>{{ auth()->user()->role_info['label'] ?? ucfirst(auth()->user()->role) }}</span>
      </div>
      <i class="fas fa-chevron-right chevron"></i>
    </div>
  </div>
</aside>

<!-- MAIN -->
<div class="main">
  <header class="topbar">
    <div class="page-title">
      <h1 id="page-title-text">Tableau de bord</h1>
      <p id="page-title-sub">Vue d'ensemble de votre activité</p>
    </div>
    <div class="search-wrap">
      <i class="fas fa-search si"></i>
      <input type="text" id="global-search" placeholder="Rechercher un client, véhicule, réparation…">
    </div>
    <div class="tb-actions">
      <!-- Bell -->
      <div class="tb-btn" id="btn-notif" onclick="toggleNotifPanel()" title="Notifications">
        <i class="fas fa-bell"></i>
        <span class="notif-dot" id="notif-dot" style="display:none"></span>
      </div>
      <!-- Chat -->
      <div class="tb-btn" id="btn-chat" onclick="toggleChatPanel()" title="Messages & Assistant">
        <i class="fas fa-comments"></i>
        <span class="notif-dot" id="chat-dot" style="display:none"></span>
      </div>
      <div class="tb-profile" style="cursor:default;border:none;background:none;padding:4px 8px;gap:10px">
        <div class="av" style="background:linear-gradient(135deg,var(--navy),#1e3a8a)">
          {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
        </div>
        <div>
          <div class="pname">{{ auth()->user()->name }}</div>
          <div class="prole">{{ ucfirst(auth()->user()->role) }}</div>
        </div>
      </div>
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn-logout" title="Déconnexion">
          <i class="fas fa-sign-out-alt"></i>
          <span>Déconnexion</span>
        </button>
      </form>
    </div>
  </header>

  <div class="content">

    <!-- ═══ DASHBOARD ═══ -->
    <div class="view active" id="view-dashboard">
      <div class="kpi-grid">
        <div class="kpi orange">
          <div class="kpi-header">
            <div class="kpi-icon"><i class="fas fa-coins"></i></div>
            <span class="kpi-badge up"><i class="fas fa-arrow-up" style="font-size:9px"></i> +18%</span>
          </div>
          <div class="kpi-value">{{ number_format($stats['total_revenue'], 0, ',', ' ') }} <small style="font-size:13px;font-weight:600">FCFA</small></div>
          <div class="kpi-label">Revenus du mois</div>
          <div class="kpi-sub">Garage + Location</div>
        </div>
        <div class="kpi blue">
          <div class="kpi-header">
            <div class="kpi-icon"><i class="fas fa-wrench"></i></div>
          </div>
          <div class="kpi-value">{{ $stats['repairs_in_progress'] }}</div>
          <div class="kpi-label">Réparations actives</div>
          <div class="kpi-sub">En attente + En cours</div>
        </div>
        <div class="kpi green">
          <div class="kpi-header">
            <div class="kpi-icon"><i class="fas fa-car-side"></i></div>
          </div>
          <div class="kpi-value">{{ $stats['active_rentals'] }}</div>
          <div class="kpi-label">Voitures louées</div>
          <div class="kpi-sub">Locations actives</div>
        </div>
        <div class="kpi info">
          <div class="kpi-header">
            <div class="kpi-icon"><i class="fas fa-check-circle"></i></div>
          </div>
          <div class="kpi-value">{{ $stats['available_vehicles'] }}</div>
          <div class="kpi-label">Véhicules disponibles</div>
          <div class="kpi-sub">Prêts à être loués</div>
        </div>
      </div>

      <div class="grid-2">
        <div class="card">
          <div class="card-title">
            <div class="ct-left">
              <div class="ct-icon" style="background:rgba(13,27,62,.08);color:var(--navy)"><i class="fas fa-chart-line"></i></div>
              Revenus — 6 derniers mois
            </div>
          </div>
          <div class="chart-wrap"><canvas id="chartRevenu"></canvas></div>
        </div>
        <div class="card">
          <div class="card-title">
            <div class="ct-left">
              <div class="ct-icon" style="background:var(--orange-light);color:var(--orange)"><i class="fas fa-calendar-week"></i></div>
              Activité — 7 derniers jours
            </div>
          </div>
          <div class="chart-wrap"><canvas id="chartActivite"></canvas></div>
        </div>
      </div>

      <div class="grid-2">
        <div class="card">
          <div class="card-title">
            <div class="ct-left">
              <div class="ct-icon" style="background:rgba(59,130,246,.1);color:var(--info)"><i class="fas fa-wrench"></i></div>
              Dernières réparations
            </div>
            <button class="btn btn-ghost btn-sm" onclick="showView('reparations', document.querySelector('.nav-item[onclick*=reparations]'))">Voir tout</button>
          </div>
          <div class="tbl-wrap">
            <table>
              <thead><tr><th>Véhicule</th><th>Description</th><th>Mécanicien</th><th>Statut</th></tr></thead>
              <tbody>
                @forelse($recentRepairs as $r)
                <tr>
                  <td><strong>{{ $r->vehicle->brand }} {{ $r->vehicle->model }}</strong><br><small style="color:var(--muted)">{{ $r->vehicle->registration }}</small></td>
                  <td>{{ Str::limit($r->description, 35) }}</td>
                  <td>{{ $r->employee?->first_name ?? '—' }}</td>
                  <td>
                    @if($r->status === 'done') <span class="badge badge-success">Terminé</span>
                    @elseif($r->status === 'in_progress') <span class="badge badge-info">En cours</span>
                    @else <span class="badge badge-warning">En attente</span>
                    @endif
                  </td>
                </tr>
                @empty
                <tr><td colspan="4" style="text-align:center;color:var(--muted);padding:24px">Aucune réparation</td></tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
        <div class="card">
          <div class="card-title">
            <div class="ct-left">
              <div class="ct-icon" style="background:rgba(16,185,129,.1);color:var(--success)"><i class="fas fa-key"></i></div>
              Dernières locations
            </div>
            <button class="btn btn-ghost btn-sm" onclick="showView('locations', document.querySelector('.nav-item[onclick*=locations]'))">Voir tout</button>
          </div>
          <div class="tbl-wrap">
            <table>
              <thead><tr><th>Client</th><th>Véhicule</th><th>Retour</th><th>Paiement</th></tr></thead>
              <tbody>
                @forelse($recentRentals as $rental)
                <tr>
                  <td><strong>{{ $rental->client->first_name }} {{ $rental->client->last_name }}</strong></td>
                  <td>{{ $rental->vehicle->brand }} {{ $rental->vehicle->model }}</td>
                  <td>{{ $rental->end_date->format('d M') }}</td>
                  <td>
                    @if($rental->payment_status === 'paid') <span class="badge badge-success">Payé</span>
                    @elseif($rental->payment_status === 'partial') <span class="badge badge-info">Acompte</span>
                    @else <span class="badge badge-warning">En attente</span>
                    @endif
                  </td>
                </tr>
                @empty
                <tr><td colspan="4" style="text-align:center;color:var(--muted);padding:24px">Aucune location</td></tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- ═══ CLIENTS ═══ -->
    <div class="view" id="view-clients">
      <div class="sec-header">
        <div><h2>Clients</h2><p>Gestion du portefeuille clients</p></div>
        <div class="btn-group">
          <button class="btn btn-outline" onclick="exportPDF('clients-table','Clients')"><i class="fas fa-file-pdf" style="color:var(--danger)"></i> PDF</button>
          <button class="btn btn-outline" onclick="exportExcel('clients-table','clients')"><i class="fas fa-file-excel" style="color:var(--success)"></i> Excel</button>
          <button class="btn btn-orange" onclick="openModal('modal-client')"><i class="fas fa-plus"></i> Nouveau client</button>
        </div>
      </div>
      <div class="kpi-grid" style="grid-template-columns:repeat(3,1fr)">
        <div class="kpi blue"><div class="kpi-header"><div class="kpi-icon"><i class="fas fa-users"></i></div></div><div class="kpi-value" id="stat-clients-total">—</div><div class="kpi-label">Total clients</div></div>
        <div class="kpi orange"><div class="kpi-header"><div class="kpi-icon"><i class="fas fa-star"></i></div></div><div class="kpi-value" id="stat-clients-vip">—</div><div class="kpi-label">Clients fidèles (>500k)</div></div>
        <div class="kpi green"><div class="kpi-header"><div class="kpi-icon"><i class="fas fa-user-plus"></i></div></div><div class="kpi-value" id="stat-clients-new">—</div><div class="kpi-label">Nouveaux ce mois</div></div>
      </div>
      <div class="card">
        <div class="card-title">Liste des clients</div>
        <div class="tbl-wrap">
          <table id="clients-table">
            <thead><tr><th>Client</th><th>Téléphone</th><th>Type</th><th>Répar.</th><th>Locations</th><th>Statut</th><th>Actions</th></tr></thead>
            <tbody id="clients-tbody"><tr><td colspan="7" style="text-align:center;padding:32px;color:var(--muted)"><i class="fas fa-spinner fa-spin"></i> Chargement…</td></tr></tbody>
          </table>
        </div>
        <div id="clients-pagination" style="display:flex;justify-content:flex-end;gap:6px;margin-top:14px"></div>
      </div>
    </div>

    <!-- ═══ VÉHICULES ═══ -->
    <div class="view" id="view-vehicules">
      <div class="sec-header">
        <div><h2>Véhicules</h2><p>Parc automobile — garage & location</p></div>
        <div class="btn-group">
          <button class="btn btn-outline"><i class="fas fa-filter"></i> Filtrer</button>
          <button class="btn btn-orange" onclick="openModal('modal-vehicle')"><i class="fas fa-plus"></i> Ajouter</button>
        </div>
      </div>
      <div class="vehicle-grid" id="vehicles-grid">
        <div style="grid-column:1/-1;text-align:center;padding:48px;color:var(--muted)"><i class="fas fa-spinner fa-spin fa-2x"></i></div>
      </div>
    </div>

    <!-- ═══ RÉPARATIONS ═══ -->
    <div class="view" id="view-reparations">
      <div class="sec-header">
        <div><h2>Réparations</h2><p>Suivi des ordres de travaux</p></div>
        <div class="btn-group">
          <button class="btn btn-outline"><i class="fas fa-print"></i> Imprimer</button>
          <button class="btn btn-orange" onclick="openModal('modal-repair')"><i class="fas fa-plus"></i> Nouvel ordre</button>
        </div>
      </div>
      <div class="kpi-grid" style="grid-template-columns:repeat(3,1fr);margin-bottom:20px">
        <div class="kpi orange"><div class="kpi-header"><div class="kpi-icon"><i class="fas fa-hourglass-half"></i></div></div><div class="kpi-value" id="stat-r-pending">—</div><div class="kpi-label">En attente</div></div>
        <div class="kpi blue"><div class="kpi-header"><div class="kpi-icon"><i class="fas fa-tools"></i></div></div><div class="kpi-value" id="stat-r-inprogress">—</div><div class="kpi-label">En cours</div></div>
        <div class="kpi green"><div class="kpi-header"><div class="kpi-icon"><i class="fas fa-check-double"></i></div></div><div class="kpi-value" id="stat-r-done">—</div><div class="kpi-label">Terminées ce mois</div></div>
      </div>
      <div class="kanban" id="repairs-kanban">
        <div class="k-col"><div class="k-col-header"><span class="k-col-title" style="color:var(--warning)">En attente</span><div class="k-count" style="background:var(--warning)" id="k-pending-count">0</div></div><div id="k-pending"><div style="text-align:center;padding:24px;color:var(--muted)"><i class="fas fa-spinner fa-spin"></i></div></div></div>
        <div class="k-col"><div class="k-col-header"><span class="k-col-title" style="color:var(--info)">En cours</span><div class="k-count" style="background:var(--info)" id="k-inprogress-count">0</div></div><div id="k-inprogress"></div></div>
        <div class="k-col"><div class="k-col-header"><span class="k-col-title" style="color:var(--success)">Terminé</span><div class="k-count" style="background:var(--success)" id="k-done-count">0</div></div><div id="k-done"></div></div>
      </div>
    </div>

    <!-- ═══ LOCATIONS ═══ -->
    <div class="view" id="view-locations">
      <div class="sec-header">
        <div><h2>Locations</h2><p>Gestion du parc de location</p></div>
        <button class="btn btn-orange" onclick="openModal('modal-rental')"><i class="fas fa-plus"></i> Nouvelle réservation</button>
      </div>
      <div class="kpi-grid" style="grid-template-columns:repeat(3,1fr);margin-bottom:20px">
        <div class="kpi green"><div class="kpi-header"><div class="kpi-icon"><i class="fas fa-car"></i></div></div><div class="kpi-value" id="stat-loc-available">—</div><div class="kpi-label">Disponibles</div></div>
        <div class="kpi orange"><div class="kpi-header"><div class="kpi-icon"><i class="fas fa-road"></i></div></div><div class="kpi-value" id="stat-loc-active">—</div><div class="kpi-label">En location</div></div>
        <div class="kpi blue"><div class="kpi-header"><div class="kpi-icon"><i class="fas fa-chart-line"></i></div></div><div class="kpi-value" id="stat-loc-revenue">—</div><div class="kpi-label">Revenus/mois</div></div>
      </div>
      <div class="card">
        <div class="card-title">Réservations récentes</div>
        <div class="tbl-wrap">
          <table>
            <thead><tr><th>Client</th><th>Véhicule</th><th>Période</th><th>Total</th><th>Paiement</th><th>Statut</th><th>Actions</th></tr></thead>
            <tbody id="rentals-tbody"><tr><td colspan="7" style="text-align:center;padding:32px;color:var(--muted)"><i class="fas fa-spinner fa-spin"></i></td></tr></tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- ═══ STOCK ═══ -->
    <div class="view" id="view-stock">
      <div class="sec-header">
        <div><h2>Stock & Pièces</h2><p>Gestion de l'inventaire</p></div>
        <div class="btn-group">
          <button class="btn btn-outline" onclick="exportPDF('stock-table','Stock & Pièces')"><i class="fas fa-file-pdf" style="color:var(--danger)"></i> PDF</button>
          <button class="btn btn-outline" onclick="exportExcel('stock-table','stock')"><i class="fas fa-file-excel" style="color:var(--success)"></i> Excel</button>
          <button class="btn btn-orange" onclick="openModal('modal-stock')"><i class="fas fa-plus"></i> Ajouter pièce</button>
        </div>
      </div>
      <div id="stock-alert-banner" style="display:none" class="stock-alert">
        <i class="fas fa-exclamation-triangle" style="color:var(--danger)"></i>
        <p id="stock-alert-text" style="color:var(--danger);font-size:13px;font-weight:500"></p>
      </div>
      <div class="kpi-grid">
        <div class="kpi blue"><div class="kpi-header"><div class="kpi-icon"><i class="fas fa-boxes"></i></div></div><div class="kpi-value" id="stat-stock-total">—</div><div class="kpi-label">Références actives</div></div>
        <div class="kpi green"><div class="kpi-header"><div class="kpi-icon"><i class="fas fa-check"></i></div></div><div class="kpi-value" id="stat-stock-normal">—</div><div class="kpi-label">Stock normal</div></div>
        <div class="kpi orange"><div class="kpi-header"><div class="kpi-icon"><i class="fas fa-exclamation"></i></div></div><div class="kpi-value" id="stat-stock-low">—</div><div class="kpi-label">Stock faible</div></div>
        <div class="kpi" style="border-left-color:var(--danger)"><div class="kpi-header"><div class="kpi-icon" style="background:rgba(239,68,68,.1);color:var(--danger)"><i class="fas fa-times-circle"></i></div></div><div class="kpi-value" id="stat-stock-critical">—</div><div class="kpi-label">Stock critique</div></div>
      </div>
      <div class="card">
        <div class="card-title">Inventaire des pièces</div>
        <div class="tbl-wrap">
          <table id="stock-table">
            <thead><tr><th>Référence</th><th>Désignation</th><th>Catégorie</th><th>Qté</th><th>Seuil min.</th><th>Prix unitaire</th><th>Fournisseur</th><th>Statut</th><th>Actions</th></tr></thead>
            <tbody id="stock-tbody"><tr><td colspan="9" style="text-align:center;padding:32px;color:var(--muted)"><i class="fas fa-spinner fa-spin"></i></td></tr></tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- ═══ COMPTABILITÉ ═══ -->
    <div class="view" id="view-comptabilite">
      <div class="sec-header">
        <div><h2>Comptabilité</h2><p id="compta-period">Chargement…</p></div>
        <div class="btn-group">
          <button class="btn btn-outline" onclick="exportPDF('transactions-table','Comptabilité')"><i class="fas fa-file-pdf" style="color:var(--danger)"></i> PDF</button>
          <button class="btn btn-outline" onclick="exportExcel('transactions-table','transactions')"><i class="fas fa-file-excel" style="color:var(--success)"></i> Excel</button>
          <button class="btn btn-orange" onclick="openModal('modal-transaction')"><i class="fas fa-plus"></i> Saisir opération</button>
        </div>
      </div>
      <div class="kpi-grid">
        <div class="kpi orange"><div class="kpi-header"><div class="kpi-icon"><i class="fas fa-arrow-down"></i></div></div><div class="kpi-value" id="stat-rev">—</div><div class="kpi-label">Revenus totaux (FCFA)</div></div>
        <div class="kpi blue"><div class="kpi-header"><div class="kpi-icon"><i class="fas fa-arrow-up"></i></div></div><div class="kpi-value" id="stat-exp">—</div><div class="kpi-label">Dépenses (FCFA)</div></div>
        <div class="kpi green"><div class="kpi-header"><div class="kpi-icon"><i class="fas fa-chart-line"></i></div></div><div class="kpi-value" id="stat-profit">—</div><div class="kpi-label">Bénéfice net (FCFA)</div></div>
        <div class="kpi info"><div class="kpi-header"><div class="kpi-icon"><i class="fas fa-percent"></i></div></div><div class="kpi-value" id="stat-margin">—</div><div class="kpi-label">Marge bénéficiaire</div></div>
      </div>
      <div class="grid-2">
        <div class="card">
          <div class="card-title"><div class="ct-left"><div class="ct-icon" style="background:rgba(16,185,129,.1);color:var(--success)"><i class="fas fa-chart-pie"></i></div>Répartition des revenus</div></div>
          <div class="chart-wrap"><canvas id="chartCompta"></canvas></div>
        </div>
        <div class="card">
          <div class="card-title"><div class="ct-left"><div class="ct-icon" style="background:var(--orange-light);color:var(--orange)"><i class="fas fa-balance-scale"></i></div>Résumé financier</div></div>
          <div id="fin-summary">
            <div style="text-align:center;padding:32px;color:var(--muted)"><i class="fas fa-spinner fa-spin"></i></div>
          </div>
        </div>
      </div>
      <div class="card mb24" style="margin-top:20px">
        <div class="card-title">Transactions récentes</div>
        <div class="tbl-wrap">
          <table id="transactions-table">
            <thead><tr><th>Date</th><th>Type</th><th>Catégorie</th><th>Description</th><th>Montant</th><th>Actions</th></tr></thead>
            <tbody id="transactions-tbody"><tr><td colspan="5" style="text-align:center;padding:24px;color:var(--muted)"><i class="fas fa-spinner fa-spin"></i></td></tr></tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- ═══ EMPLOYÉS ═══ -->
    <div class="view" id="view-employes">
      <div class="sec-header">
        <div><h2>Employés</h2><p>Gestion des ressources humaines</p></div>
        <button class="btn btn-orange" onclick="openModal('modal-employee')"><i class="fas fa-plus"></i> Ajouter employé</button>
      </div>
      <div class="kpi-grid" style="grid-template-columns:repeat(3,1fr)">
        <div class="kpi blue"><div class="kpi-header"><div class="kpi-icon"><i class="fas fa-hard-hat"></i></div></div><div class="kpi-value" id="stat-emp-total">—</div><div class="kpi-label">Employés actifs</div></div>
        <div class="kpi orange"><div class="kpi-header"><div class="kpi-icon"><i class="fas fa-tools"></i></div></div><div class="kpi-value" id="stat-emp-mech">—</div><div class="kpi-label">Mécaniciens</div></div>
        <div class="kpi green"><div class="kpi-header"><div class="kpi-icon"><i class="fas fa-headset"></i></div></div><div class="kpi-value" id="stat-emp-admin">—</div><div class="kpi-label">Personnel admin.</div></div>
      </div>
      <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:18px" id="employees-grid">
        <div style="grid-column:1/-1;text-align:center;padding:48px;color:var(--muted)"><i class="fas fa-spinner fa-spin fa-2x"></i></div>
      </div>
    </div>

    <!-- ═══ RAPPORTS ═══ -->
    <div class="view" id="view-rapports">
      <div class="sec-header">
        <div><h2>Rapports & Analytiques</h2><p>Analyse des performances</p></div>
        <div class="btn-group">
          <button class="btn btn-outline" onclick="exportPDF('rapports-table','Rapports')"><i class="fas fa-file-pdf" style="color:var(--danger)"></i> Export PDF</button>
          <button class="btn btn-outline" onclick="exportExcel('rapports-table','rapports')"><i class="fas fa-file-excel" style="color:var(--success)"></i> Export Excel</button>
        </div>
      </div>
      <div class="grid-2 mb24">
        <div class="card">
          <div class="card-title"><div class="ct-left"><div class="ct-icon" style="background:rgba(13,27,62,.08);color:var(--navy)"><i class="fas fa-chart-bar"></i></div>Revenus par mois ({{ date('Y') }})</div></div>
          <div class="chart-wrap"><canvas id="chartRapport1"></canvas></div>
        </div>
        <div class="card">
          <div class="card-title"><div class="ct-left"><div class="ct-icon" style="background:var(--orange-light);color:var(--orange)"><i class="fas fa-chart-pie"></i></div>Top mécaniciens</div></div>
          <div id="mechanics-perf" style="padding:8px 0"><div style="text-align:center;padding:32px;color:var(--muted)"><i class="fas fa-spinner fa-spin"></i></div></div>
        </div>
      </div>
      <div class="grid-2">
        <div class="card">
          <div class="card-title"><div class="ct-left"><div class="ct-icon" style="background:rgba(16,185,129,.1);color:var(--success)"><i class="fas fa-car"></i></div>Véhicules les plus loués</div></div>
          <div id="top-vehicles"><div style="text-align:center;padding:32px;color:var(--muted)"><i class="fas fa-spinner fa-spin"></i></div></div>
        </div>
        <div class="card">
          <div class="card-title"><div class="ct-left"><div class="ct-icon" style="background:rgba(139,92,246,.1);color:#8B5CF6"><i class="fas fa-users"></i></div>Top clients</div></div>
          <div id="top-clients"><div style="text-align:center;padding:32px;color:var(--muted)"><i class="fas fa-spinner fa-spin"></i></div></div>
        </div>
      </div>
    </div>

    <!-- ═══ PARAMÈTRES ═══ -->
    <!-- ═══ ÉQUIPE & ACCÈS ═══ -->
    <div class="view" id="view-equipe">
      <div class="sec-header">
        <div><h2>Équipe & Accès</h2><p id="equipe-subtitle">Gérez les membres de votre équipe</p></div>
        <div class="btn-group">
          <button class="btn btn-orange" onclick="openModal('modal-agent')"><i class="fas fa-user-plus"></i> Ajouter un agent</button>
        </div>
      </div>

      <!-- Plan limit info -->
      <div id="equipe-plan-info" style="margin-bottom:20px;display:none">
        <div style="background:linear-gradient(135deg,var(--navy),#1e3a8a);border-radius:var(--radius);padding:16px 20px;display:flex;align-items:center;justify-content:space-between;color:#fff">
          <div>
            <div style="font-size:13px;font-weight:700;margin-bottom:4px">Abonnement <span id="plan-label-badge" style="background:rgba(249,115,22,.3);color:#fdba74;padding:2px 10px;border-radius:20px;font-size:11px;margin-left:6px"></span></div>
            <div style="font-size:12px;color:rgba(255,255,255,.55)"><span id="plan-agents-used">0</span> / <span id="plan-agents-max">—</span> agents utilisés</div>
          </div>
          <button class="btn btn-orange btn-sm" onclick="showView('parametres', document.querySelector('.nav-item[onclick*=parametres]'))">Mettre à niveau</button>
        </div>
      </div>

      <div class="agent-grid" id="agents-grid">
        <div style="text-align:center;padding:40px;color:var(--muted);grid-column:1/-1">Chargement…</div>
      </div>
    </div>

    <!-- ═══ PARAMÈTRES ═══ -->
    <div class="view" id="view-parametres">
      <div class="sec-header">
        <div><h2>Paramètres</h2><p>Configuration de votre entreprise</p></div>
        <button class="btn btn-orange" onclick="saveCompanySettings()"><i class="fas fa-save"></i> Sauvegarder</button>
      </div>
      <div class="grid-2">
        <div>
          <div class="card mb24">
            <div class="card-title">Informations de l'entreprise</div>
            <div class="form-group"><label class="form-label">Nom du garage</label><input class="form-control" id="set-name" placeholder="Mon Garage"></div>
            <div class="form-row">
              <div class="form-group"><label class="form-label">Téléphone</label><input class="form-control" id="set-phone" placeholder="+221 77 000 00 00"></div>
              <div class="form-group"><label class="form-label">Email</label><input class="form-control" id="set-email" type="email" placeholder="contact@garage.sn"></div>
            </div>
            <div class="form-group"><label class="form-label">Adresse</label><input class="form-control" id="set-address" placeholder="Rue, Ville, Pays"></div>
            <div class="form-row">
              <div class="form-group"><label class="form-label">Site web</label><input class="form-control" id="set-website" placeholder="https://..."></div>
              <div class="form-group"><label class="form-label">Devise</label>
                <select class="form-control" id="set-currency">
                  <option value="FCFA">Franc CFA (FCFA)</option>
                  <option value="EUR">Euro (€)</option>
                  <option value="USD">Dollar ($)</option>
                  <option value="MAD">Dirham (MAD)</option>
                </select>
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-title">Logo de l'entreprise</div>
            <div id="current-logo" style="margin-bottom:14px;display:none">
              <img id="logo-preview" style="height:60px;border-radius:8px;border:1px solid var(--border)">
            </div>
            <label class="logo-upload-area" for="logo-file-input">
              <i class="fas fa-cloud-upload-alt" style="display:block;font-size:28px;color:var(--muted);margin-bottom:8px"></i>
              <div style="font-size:13px;color:var(--muted)">Cliquez pour uploader votre logo</div>
              <div style="font-size:11px;color:#94A3B8;margin-top:4px">PNG, JPG, SVG · max 2 Mo</div>
            </label>
            <input type="file" id="logo-file-input" accept="image/*" style="display:none" onchange="uploadLogo(this)">
          </div>
        </div>
        <div>
          <div class="card mb24">
            <div class="card-title">Abonnement</div>
            <div id="plans-grid" style="display:grid;grid-template-columns:1fr 1fr;gap:12px"></div>
          </div>
          <div class="card mb24">
            <div class="card-title">Mon compte</div>
            <div class="form-group"><label class="form-label">Nom complet</label><input class="form-control" value="{{ auth()->user()->name }}" readonly style="background:#F8FAFC"></div>
            <div class="form-group"><label class="form-label">Email</label><input class="form-control" value="{{ auth()->user()->email }}" readonly style="background:#F8FAFC"></div>
            <div class="form-group"><label class="form-label">Rôle</label><input class="form-control" value="{{ auth()->user()->role_info['label'] ?? ucfirst(auth()->user()->role) }}" readonly style="background:#F8FAFC"></div>
          </div>
        </div>
      </div>
    </div>

  </div><!-- /content -->
</div><!-- /main -->

<!-- ═══ MODALS ═══ -->
<div class="modal-overlay" id="modal-overlay" onclick="closeModalOnOverlay(event)">

  <!-- CLIENT -->
  <div class="modal wide" id="modal-client">
    <div class="modal-header">
      <h3 id="modal-client-title">Nouveau client</h3>
      <button class="modal-close" onclick="closeModal()"><i class="fas fa-times"></i></button>
    </div>
    <div class="modal-body">
      <!-- Identité -->
      <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.7px;color:var(--muted);margin-bottom:10px;display:flex;align-items:center;gap:8px"><i class="fas fa-user"></i> Identité</div>
      <div class="form-row">
        <div class="form-group"><label class="form-label">Prénom *</label><input class="form-control" id="c-first_name" placeholder="Prénom"></div>
        <div class="form-group"><label class="form-label">Nom *</label><input class="form-control" id="c-last_name" placeholder="Nom de famille"></div>
      </div>
      <div class="form-row">
        <div class="form-group"><label class="form-label">Date de naissance</label><input class="form-control" id="c-date_of_birth" type="date"></div>
        <div class="form-group"><label class="form-label">Nationalité</label><input class="form-control" id="c-nationality" placeholder="Sénégalaise, Française…"></div>
      </div>
      <div class="form-group"><label class="form-label">Profession</label><input class="form-control" id="c-profession" placeholder="Commerçant, Ingénieur…"></div>
      <!-- Pièce d'identité -->
      <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.7px;color:var(--muted);margin:14px 0 10px;display:flex;align-items:center;gap:8px"><i class="fas fa-id-card"></i> Pièce d'identité</div>
      <div class="form-row">
        <div class="form-group">
          <label class="form-label">Type de pièce</label>
          <select class="form-control" id="c-id_type">
            <option value="">— Sélectionner —</option>
            <option value="cni">CNI (Carte Nationale d'Identité)</option>
            <option value="passeport">Passeport</option>
            <option value="permis">Permis de conduire</option>
            <option value="autre">Autre</option>
          </select>
        </div>
        <div class="form-group"><label class="form-label">Numéro de pièce</label><input class="form-control" id="c-id_number" placeholder="Ex: 1234567890123"></div>
      </div>
      <!-- Contact -->
      <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.7px;color:var(--muted);margin:14px 0 10px;display:flex;align-items:center;gap:8px"><i class="fas fa-phone"></i> Contact</div>
      <div class="form-row">
        <div class="form-group"><label class="form-label">Téléphone *</label><input class="form-control" id="c-phone" placeholder="+221 77 000 00 00"></div>
        <div class="form-group"><label class="form-label">Téléphone 2</label><input class="form-control" id="c-phone2" placeholder="+221 76 000 00 00"></div>
      </div>
      <div class="form-row">
        <div class="form-group"><label class="form-label">Email</label><input class="form-control" id="c-email" type="email" placeholder="email@exemple.com"></div>
        <div class="form-group"><label class="form-label">Ville</label><input class="form-control" id="c-city" placeholder="Dakar, Abidjan…"></div>
      </div>
      <div class="form-group"><label class="form-label">Adresse complète</label><input class="form-control" id="c-address" placeholder="Quartier, rue, numéro…"></div>
      <!-- Type client -->
      <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.7px;color:var(--muted);margin:14px 0 10px;display:flex;align-items:center;gap:8px"><i class="fas fa-tag"></i> Catégorie</div>
      <div class="form-row">
        <div class="form-group">
          <label class="form-label">Type *</label>
          <select class="form-control" id="c-type" onchange="toggleCompany()">
            <option value="particulier">Particulier</option>
            <option value="entreprise">Entreprise</option>
          </select>
        </div>
        <div class="form-group" id="c-company-wrap" style="display:none">
          <label class="form-label">Nom de l'entreprise</label>
          <input class="form-control" id="c-company_name" placeholder="Nom de l'entreprise">
        </div>
      </div>
      <div class="form-group"><label class="form-label">Notes</label><textarea class="form-control" id="c-notes" rows="2" placeholder="Observations…"></textarea></div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-outline" onclick="closeModal()">Annuler</button>
      <button class="btn btn-orange" onclick="saveClient()"><i class="fas fa-save"></i> Enregistrer</button>
    </div>
  </div>

  <!-- VEHICLE -->
  <div class="modal wide" id="modal-vehicle">
    <div class="modal-header">
      <h3 id="modal-vehicle-title">Ajouter un véhicule</h3>
      <button class="modal-close" onclick="closeModal()"><i class="fas fa-times"></i></button>
    </div>
    <div class="modal-body">
      <!-- Véhicule -->
      <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.7px;color:var(--muted);margin-bottom:10px;display:flex;align-items:center;gap:8px"><i class="fas fa-car"></i> Informations du véhicule</div>
      <div class="form-row">
        <div class="form-group"><label class="form-label">Type *</label><select class="form-control" id="v-type"><option value="rental">Location</option><option value="garage">Garage</option></select></div>
        <div class="form-group"><label class="form-label">Statut *</label><select class="form-control" id="v-status"><option value="available">Disponible</option><option value="rented">Loué</option><option value="maintenance">Maintenance</option><option value="repair">En réparation</option></select></div>
      </div>
      <div class="form-row">
        <div class="form-group"><label class="form-label">Marque *</label><input class="form-control" id="v-brand" placeholder="Toyota, Renault…"></div>
        <div class="form-group"><label class="form-label">Modèle *</label><input class="form-control" id="v-model" placeholder="Corolla, Duster…"></div>
      </div>
      <div class="form-row">
        <div class="form-group"><label class="form-label">Immatriculation *</label><input class="form-control" id="v-registration" placeholder="DK-1234-AA"></div>
        <div class="form-group"><label class="form-label">Année *</label><input class="form-control" id="v-year" type="number" min="1990" max="2026" placeholder="2020"></div>
      </div>
      <div class="form-row">
        <div class="form-group"><label class="form-label">Carburant *</label><select class="form-control" id="v-fuel_type"><option value="essence">Essence</option><option value="diesel">Diesel</option><option value="electrique">Électrique</option><option value="hybride">Hybride</option></select></div>
        <div class="form-group"><label class="form-label">Transmission *</label><select class="form-control" id="v-transmission"><option value="manuel">Manuelle</option><option value="automatique">Automatique</option></select></div>
      </div>
      <div class="form-row">
        <div class="form-group"><label class="form-label">Nb places *</label><input class="form-control" id="v-seats" type="number" min="2" max="9" value="5"></div>
        <div class="form-group"><label class="form-label">Kilométrage *</label><input class="form-control" id="v-mileage" type="number" min="0" placeholder="0"></div>
      </div>
      <div class="form-row">
        <div class="form-group"><label class="form-label">Prix/jour (FCFA)</label><input class="form-control" id="v-price_per_day" type="number" min="0" placeholder="25000"></div>
        <div class="form-group"><label class="form-label">Couleur</label><input class="form-control" id="v-color" placeholder="Blanc, Noir…"></div>
      </div>
      <div class="form-group"><label class="form-label">Notes</label><textarea class="form-control" id="v-notes" rows="2"></textarea></div>
      <!-- Propriétaire -->
      <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.7px;color:var(--muted);margin:18px 0 10px;display:flex;align-items:center;gap:8px"><i class="fas fa-user-tie"></i> Informations du propriétaire</div>
      <div class="form-row">
        <div class="form-group"><label class="form-label">Nom complet du propriétaire</label><input class="form-control" id="v-owner_name" placeholder="Prénom Nom"></div>
        <div class="form-group"><label class="form-label">Téléphone</label><input class="form-control" id="v-owner_phone" placeholder="+221 77 000 00 00"></div>
      </div>
      <div class="form-row">
        <div class="form-group"><label class="form-label">Téléphone 2</label><input class="form-control" id="v-owner_phone2" placeholder="+221 76 000 00 00"></div>
        <div class="form-group"><label class="form-label">Email</label><input class="form-control" id="v-owner_email" type="email" placeholder="proprietaire@email.com"></div>
      </div>
      <div class="form-group"><label class="form-label">Adresse du propriétaire</label><input class="form-control" id="v-owner_address" placeholder="Adresse complète"></div>
      <div class="form-row">
        <div class="form-group">
          <label class="form-label">Type de pièce d'identité</label>
          <select class="form-control" id="v-owner_id_type">
            <option value="">— Sélectionner —</option>
            <option value="cni">CNI (Carte Nationale d'Identité)</option>
            <option value="passeport">Passeport</option>
            <option value="permis">Permis de conduire</option>
            <option value="autre">Autre</option>
          </select>
        </div>
        <div class="form-group"><label class="form-label">Numéro de pièce</label><input class="form-control" id="v-owner_id_number" placeholder="Ex: 1234567890123"></div>
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-outline" onclick="closeModal()">Annuler</button>
      <button class="btn btn-orange" onclick="saveVehicle()"><i class="fas fa-save"></i> Enregistrer</button>
    </div>
  </div>

  <!-- REPAIR -->
  <div class="modal wide" id="modal-repair">
    <div class="modal-header">
      <h3 id="modal-repair-title">Nouvel ordre de réparation</h3>
      <button class="modal-close" onclick="closeModal()"><i class="fas fa-times"></i></button>
    </div>
    <div class="modal-body">
      <div class="form-row">
        <div class="form-group"><label class="form-label">Client *</label><select class="form-control" id="r-client_id"><option value="">Chargement…</option></select></div>
        <div class="form-group"><label class="form-label">Véhicule *</label><select class="form-control" id="r-vehicle_id" onchange="onRepairVehicleChange()"><option value="">Chargement…</option></select></div>
      </div>
      <!-- Owner info panel — shown when vehicle has owner data -->
      <div id="r-owner-panel" style="display:none;background:linear-gradient(135deg,rgba(249,115,22,.06),rgba(249,115,22,.02));border:1.5px solid rgba(249,115,22,.2);border-radius:10px;padding:12px 14px;margin-bottom:12px">
        <div style="font-size:10.5px;font-weight:700;text-transform:uppercase;letter-spacing:.6px;color:var(--orange);margin-bottom:8px;display:flex;align-items:center;gap:6px"><i class="fas fa-user-tie"></i> Propriétaire du véhicule</div>
        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:8px" id="r-owner-content"></div>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label class="form-label">Type d'ordre *</label>
          <select class="form-control" id="r-type">
            <option value="reparation">🔧 Réparation</option>
            <option value="maintenance">🛠️ Maintenance</option>
          </select>
        </div>
        <div class="form-group"><label class="form-label">Priorité *</label><select class="form-control" id="r-priority"><option value="normal">Normal</option><option value="high">Priorité haute</option><option value="urgent">Urgent</option></select></div>
      </div>
      <div class="form-row">
        <div class="form-group"><label class="form-label">Mécanicien</label><select class="form-control" id="r-employee_id"><option value="">Non assigné</option></select></div>
      </div>
      <div class="form-row">
        <div class="form-group"><label class="form-label">Statut *</label><select class="form-control" id="r-status"><option value="pending">En attente</option><option value="in_progress">En cours</option><option value="done">Terminé</option></select></div>
        <div class="form-group"><label class="form-label">Paiement *</label><select class="form-control" id="r-payment_status"><option value="pending">En attente</option><option value="partial">Acompte</option><option value="paid">Payé</option></select></div>
      </div>
      <div class="form-group"><label class="form-label">Description *</label><textarea class="form-control" id="r-description" rows="2" placeholder="Description des travaux…"></textarea></div>
      <div class="form-group"><label class="form-label">Diagnostic</label><textarea class="form-control" id="r-diagnosis" rows="2" placeholder="Diagnostic technique…"></textarea></div>
      <div class="form-row">
        <div class="form-group"><label class="form-label">Coût main d'œuvre (FCFA) *</label><input class="form-control" id="r-labor_cost" type="number" min="0" value="0"></div>
        <div class="form-group"><label class="form-label">Date d'entrée *</label><input class="form-control" id="r-entered_at" type="date"></div>
      </div>
      <div class="form-group"><label class="form-label">Date de fin</label><input class="form-control" id="r-completed_at" type="date"></div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-outline" onclick="closeModal()">Annuler</button>
      <button class="btn btn-orange" onclick="saveRepair()"><i class="fas fa-save"></i> Enregistrer</button>
    </div>
  </div>

  <!-- RENTAL -->
  <div class="modal" id="modal-rental">
    <div class="modal-header">
      <h3 id="modal-rental-title">Nouvelle réservation</h3>
      <button class="modal-close" onclick="closeModal()"><i class="fas fa-times"></i></button>
    </div>
    <div class="modal-body">
      <div class="form-group"><label class="form-label">Client *</label><select class="form-control" id="mr-client_id"><option value="">Chargement…</option></select></div>
      <div class="form-group"><label class="form-label">Véhicule disponible *</label><select class="form-control" id="mr-vehicle_id" onchange="updateModalRentalTotal()"><option value="">Chargement…</option></select></div>
      <div class="form-row">
        <div class="form-group"><label class="form-label">Départ *</label><input class="form-control" id="mr-start" type="date" onchange="updateModalRentalTotal()"></div>
        <div class="form-group"><label class="form-label">Retour *</label><input class="form-control" id="mr-end" type="date" onchange="updateModalRentalTotal()"></div>
      </div>
      <div class="form-row">
        <div class="form-group"><label class="form-label">Mode de paiement</label><select class="form-control" id="mr-pay-method"><option value="especes">Espèces</option><option value="virement">Virement bancaire</option><option value="mobile_money">Mobile Money</option></select></div>
        <div class="form-group"><label class="form-label">Statut paiement</label><select class="form-control" id="mr-pay-status"><option value="paid">Payé intégralement</option><option value="partial">Acompte versé</option><option value="pending">En attente</option></select></div>
      </div>
      <div class="total-box" style="background:var(--navy);border-radius:9px;padding:14px;margin-top:8px;display:flex;align-items:center;justify-content:space-between">
        <div><div style="font-size:13px;color:rgba(255,255,255,.6)">Total à payer</div><div style="font-size:11px;color:rgba(255,255,255,.4);margin-top:2px" id="mr-calc-detail">Sélectionner un véhicule et des dates</div></div>
        <div style="font-size:22px;font-weight:800;color:var(--orange)" id="mr-total-display">— FCFA</div>
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-outline" onclick="closeModal()">Annuler</button>
      <button class="btn btn-orange" onclick="saveRental()" id="mr-save-btn"><i class="fas fa-check"></i> Confirmer</button>
    </div>
  </div>

  <!-- RENTAL DETAIL -->
  <div class="modal wide" id="modal-rental-detail">
    <div class="modal-header">
      <h3><i class="fas fa-car-side" style="color:var(--orange);margin-right:8px"></i> Détails de la location</h3>
      <button class="modal-close" onclick="closeModal()"><i class="fas fa-times"></i></button>
    </div>
    <div class="modal-body" id="rental-detail-body" style="padding:20px"></div>
    <div class="modal-footer">
      <button class="btn btn-outline" onclick="closeModal()">Fermer</button>
    </div>
  </div>

  <!-- STOCK -->
  <div class="modal" id="modal-stock">
    <div class="modal-header">
      <h3 id="modal-stock-title">Ajouter une pièce</h3>
      <button class="modal-close" onclick="closeModal()"><i class="fas fa-times"></i></button>
    </div>
    <div class="modal-body">
      <div class="form-row">
        <div class="form-group"><label class="form-label">Référence *</label><input class="form-control" id="s-reference" placeholder="REF-001"></div>
        <div class="form-group"><label class="form-label">Catégorie *</label><select class="form-control" id="s-category"><option value="freinage">Freinage</option><option value="moteur">Moteur</option><option value="climatisation">Climatisation</option><option value="pneumatiques">Pneumatiques</option><option value="electrique">Électrique</option><option value="transmission">Transmission</option><option value="carrosserie">Carrosserie</option><option value="echappement">Échappement</option><option value="autre">Autre</option></select></div>
      </div>
      <div class="form-group"><label class="form-label">Désignation *</label><input class="form-control" id="s-name" placeholder="Nom de la pièce"></div>
      <div class="form-row">
        <div class="form-group"><label class="form-label">Quantité *</label><input class="form-control" id="s-quantity" type="number" min="0" value="0"></div>
        <div class="form-group"><label class="form-label">Stock minimum *</label><input class="form-control" id="s-min_quantity" type="number" min="0" value="2"></div>
      </div>
      <div class="form-row">
        <div class="form-group"><label class="form-label">Prix unitaire (FCFA) *</label><input class="form-control" id="s-unit_price" type="number" min="0" placeholder="0"></div>
        <div class="form-group"><label class="form-label">Fournisseur</label><input class="form-control" id="s-supplier" placeholder="Nom du fournisseur"></div>
      </div>
      <div class="form-group"><label class="form-label">Notes</label><textarea class="form-control" id="s-notes" rows="2"></textarea></div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-outline" onclick="closeModal()">Annuler</button>
      <button class="btn btn-orange" onclick="saveStock()"><i class="fas fa-save"></i> Enregistrer</button>
    </div>
  </div>

  <!-- EMPLOYEE -->
  <div class="modal" id="modal-employee">
    <div class="modal-header">
      <h3 id="modal-employee-title">Ajouter un employé</h3>
      <button class="modal-close" onclick="closeModal()"><i class="fas fa-times"></i></button>
    </div>
    <div class="modal-body">
      <div class="form-row">
        <div class="form-group"><label class="form-label">Prénom *</label><input class="form-control" id="e-first_name" placeholder="Prénom"></div>
        <div class="form-group"><label class="form-label">Nom *</label><input class="form-control" id="e-last_name" placeholder="Nom"></div>
      </div>
      <div class="form-row">
        <div class="form-group"><label class="form-label">Rôle *</label><select class="form-control" id="e-role"><option value="chef_mecanicien">Chef mécanicien</option><option value="mecanicien_senior">Mécanicien senior</option><option value="mecanicien">Mécanicien</option><option value="electricien">Électricien</option><option value="magasinier">Magasinier</option><option value="receptionniste">Réceptionniste</option><option value="gerant">Gérant</option><option value="comptable">Comptable</option></select></div>
        <div class="form-group"><label class="form-label">Statut *</label><select class="form-control" id="e-status"><option value="active">Actif</option><option value="inactive">Inactif</option><option value="on_leave">En congé</option></select></div>
      </div>
      <div class="form-row">
        <div class="form-group"><label class="form-label">Téléphone *</label><input class="form-control" id="e-phone" placeholder="+221 77 000 00 00"></div>
        <div class="form-group"><label class="form-label">Email</label><input class="form-control" id="e-email" type="email" placeholder="email@exemple.com"></div>
      </div>
      <div class="form-row">
        <div class="form-group"><label class="form-label">Salaire (FCFA) *</label><input class="form-control" id="e-salary" type="number" min="0" placeholder="150000"></div>
        <div class="form-group"><label class="form-label">Date d'embauche *</label><input class="form-control" id="e-hired_at" type="date"></div>
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-outline" onclick="closeModal()">Annuler</button>
      <button class="btn btn-orange" onclick="saveEmployee()"><i class="fas fa-save"></i> Enregistrer</button>
    </div>
  </div>

  <!-- TRANSACTION -->
  <div class="modal" id="modal-transaction">
    <div class="modal-header">
      <h3>Saisir une opération</h3>
      <button class="modal-close" onclick="closeModal()"><i class="fas fa-times"></i></button>
    </div>
    <div class="modal-body">
      <div class="form-row">
        <div class="form-group"><label class="form-label">Type *</label><select class="form-control" id="t-type"><option value="revenue">Revenu</option><option value="expense">Dépense</option></select></div>
        <div class="form-group"><label class="form-label">Catégorie *</label><select class="form-control" id="t-category"><option value="reparation">Réparation</option><option value="location">Location</option><option value="salaires">Salaires</option><option value="fournitures">Fournitures</option><option value="charges">Charges</option><option value="achat_pieces">Achat pièces</option><option value="autre">Autre</option></select></div>
      </div>
      <div class="form-row">
        <div class="form-group"><label class="form-label">Montant (FCFA) *</label><input class="form-control" id="t-amount" type="number" min="1" placeholder="0"></div>
        <div class="form-group"><label class="form-label">Date *</label><input class="form-control" id="t-date" type="date"></div>
      </div>
      <div class="form-group"><label class="form-label">Description *</label><input class="form-control" id="t-description" placeholder="Description de l'opération"></div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-outline" onclick="closeModal()">Annuler</button>
      <button class="btn btn-orange" onclick="saveTransaction()"><i class="fas fa-save"></i> Enregistrer</button>
    </div>
  </div>

  <!-- AGENT -->
  <div class="modal" id="modal-agent">
    <div class="modal-header">
      <h3 id="modal-agent-title">Nouvel agent</h3>
      <button class="modal-close" onclick="closeModal()"><i class="fas fa-times"></i></button>
    </div>
    <div class="modal-body">
      <div class="form-row">
        <div class="form-group"><label class="form-label">Nom complet *</label><input class="form-control" id="ag-name" placeholder="Prénom Nom"></div>
        <div class="form-group"><label class="form-label">Téléphone</label><input class="form-control" id="ag-phone" placeholder="+221 77 000 00 00"></div>
      </div>
      <div class="form-group"><label class="form-label">Email *</label><input class="form-control" id="ag-email" type="email" placeholder="agent@garage.sn"></div>
      <div class="form-row">
        <div class="form-group">
          <label class="form-label">Rôle *</label>
          <select class="form-control" id="ag-role" onchange="updateRolePreview(this.value)">
            <option value="admin">Administrateur</option>
            <option value="manager">Manager</option>
            <option value="mechanic">Mécanicien</option>
            <option value="accountant">Comptable</option>
            <option value="receptionist">Réceptionniste</option>
          </select>
        </div>
        <div class="form-group" id="ag-status-group" style="display:none">
          <label class="form-label">Statut</label>
          <select class="form-control" id="ag-is_active">
            <option value="1">Actif</option>
            <option value="0">Inactif</option>
          </select>
        </div>
      </div>
      <div style="background:#F8FAFC;border:1.5px solid var(--border);border-radius:9px;padding:14px;margin-top:4px">
        <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.6px;color:var(--muted);margin-bottom:12px;display:flex;align-items:center;justify-content:space-between">
          <span>Accès accordés</span>
          <span style="font-size:10px;font-weight:500;color:var(--muted);text-transform:none">Cochez les sections autorisées</span>
        </div>
        <div id="permission-checkboxes" style="display:grid;grid-template-columns:1fr 1fr;gap:8px"></div>
      </div>
      <div class="form-group" id="ag-password-group">
        <label class="form-label">Mot de passe *</label>
        <input class="form-control" id="ag-password" type="password" placeholder="8+ caractères">
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-outline btn-sm" onclick="closeModal()">Annuler</button>
      <button class="btn btn-orange btn-sm" onclick="saveAgent()"><i class="fas fa-save"></i> Enregistrer</button>
    </div>
  </div>

  <!-- CLIENT DETAIL -->
  <div class="modal wide" id="modal-client-detail">
    <div class="modal-header">
      <h3>Fiche client</h3>
      <button class="modal-close" onclick="closeModal()"><i class="fas fa-times"></i></button>
    </div>
    <div class="modal-body" id="client-detail-body">
      <div style="text-align:center;padding:40px;color:var(--muted)"><i class="fas fa-spinner fa-spin"></i> Chargement…</div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-outline btn-sm" onclick="closeModal()">Fermer</button>
      <button class="btn btn-orange btn-sm" id="btn-edit-client-from-detail"><i class="fas fa-edit"></i> Modifier</button>
    </div>
  </div>

  <!-- VEHICLE DETAIL -->
  <div class="modal wide" id="modal-vehicle-detail">
    <div class="modal-header">
      <h3>Fiche véhicule</h3>
      <button class="modal-close" onclick="closeModal()"><i class="fas fa-times"></i></button>
    </div>
    <div class="modal-body" id="vehicle-detail-body">
      <div style="text-align:center;padding:40px;color:var(--muted)"><i class="fas fa-spinner fa-spin"></i> Chargement…</div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-outline btn-sm" onclick="closeModal()">Fermer</button>
      <button class="btn btn-orange btn-sm" id="btn-edit-vehicle-from-detail"><i class="fas fa-edit"></i> Modifier</button>
    </div>
  </div>

</div><!-- /modal-overlay -->

<!-- ══════════════════════════════════════════
     NOTIFICATION PANEL
════════════════════════════════════════════ -->
<div id="notif-panel" style="display:none;position:fixed;top:64px;right:16px;width:360px;height:500px;background:#fff;border-radius:14px;box-shadow:0 12px 40px rgba(0,0,0,.18);z-index:2000;overflow:hidden">
  <div style="padding:14px 18px;border-bottom:1px solid #F1F5F9;display:flex;align-items:center;justify-content:space-between;flex-shrink:0">
    <div style="font-size:14px;font-weight:700;color:var(--navy)"><i class="fas fa-bell" style="color:var(--orange);margin-right:8px"></i>Notifications</div>
    <div style="display:flex;gap:8px;align-items:center">
      <button onclick="readAllNotifs()" style="font-size:11px;color:var(--muted);background:none;border:none;cursor:pointer;padding:4px 8px;border-radius:6px;hover:background:#F1F5F9">Tout lire</button>
      <button onclick="closeNotifPanel()" style="background:none;border:none;cursor:pointer;color:var(--muted);font-size:16px"><i class="fas fa-times"></i></button>
    </div>
  </div>
  <div id="notif-list" style="overflow-y:auto;flex:1;padding:8px 0">
    <div style="text-align:center;padding:32px;color:var(--muted)"><i class="fas fa-spinner fa-spin"></i></div>
  </div>
</div>

<!-- ══════════════════════════════════════════
     CHAT PANEL
════════════════════════════════════════════ -->
<div id="chat-panel" style="display:none;position:fixed;bottom:0;right:0;width:380px;height:560px;background:#fff;border-radius:16px 16px 0 0;box-shadow:0 -4px 32px rgba(0,0,0,.15);z-index:2000;overflow:hidden">
  <!-- Header -->
  <div style="background:var(--navy);padding:12px 16px;display:flex;align-items:center;justify-content:space-between;flex-shrink:0">
    <div style="display:flex;align-items:center;gap:10px">
      <div style="width:36px;height:36px;border-radius:50%;background:var(--orange);display:flex;align-items:center;justify-content:center;font-size:16px;color:#fff"><i class="fas fa-robot"></i></div>
      <div>
        <div style="font-size:13px;font-weight:700;color:#fff">AfricaERP</div>
        <div style="font-size:11px;color:rgba(255,255,255,.6)">Assistant IA + Messagerie</div>
      </div>
    </div>
    <button onclick="closeChatPanel()" style="background:none;border:none;cursor:pointer;color:rgba(255,255,255,.7);font-size:18px"><i class="fas fa-times"></i></button>
  </div>
  <!-- Tabs -->
  <div style="display:flex;border-bottom:1px solid #F1F5F9;flex-shrink:0">
    <button id="chat-tab-bot" onclick="switchChatTab('bot')" style="flex:1;padding:10px;font-size:12px;font-weight:600;border:none;background:#fff;cursor:pointer;border-bottom:2px solid var(--orange);color:var(--orange)"><i class="fas fa-robot" style="margin-right:5px"></i>AfricaBot</button>
    <button id="chat-tab-team" onclick="switchChatTab('team')" style="flex:1;padding:10px;font-size:12px;font-weight:600;border:none;background:#fff;cursor:pointer;border-bottom:2px solid transparent;color:var(--muted)"><i class="fas fa-users" style="margin-right:5px"></i>Équipe</button>
  </div>
  <!-- Contacts bar (Équipe tab only) -->
  <div id="chat-contacts-bar" style="display:none;padding:6px 10px;border-bottom:1px solid #F1F5F9;flex-shrink:0;background:#fff;align-items:center;gap:0">
    <div id="chat-contacts-list" style="display:flex;gap:5px;overflow-x:auto;padding:2px 0;scrollbar-width:none"></div>
  </div>
  <!-- Bot messages -->
  <div id="chat-bot-body" style="flex:1;overflow-y:auto;padding:12px;display:flex;flex-direction:column;gap:8px;background:#F8FAFC"></div>
  <!-- Team messages -->
  <div id="chat-team-body" style="flex:1;overflow-y:auto;padding:12px;display:none;flex-direction:column;gap:8px;background:#F8FAFC"></div>
  <!-- Input area -->
  <div style="border-top:1px solid #F1F5F9;padding:10px 12px;background:#fff;flex-shrink:0">
    <div style="display:flex;gap:8px;align-items:flex-end">
      <div style="flex:1;background:#F1F5F9;border-radius:20px;padding:8px 14px;display:flex;align-items:center;gap:6px">
        <textarea id="chat-input" placeholder="Tapez un message…" rows="1" onkeydown="chatKeydown(event)" style="flex:1;border:none;background:none;resize:none;font-size:13px;outline:none;max-height:80px;font-family:inherit"></textarea>
        <!-- Voice -->
        <button id="btn-voice" onclick="toggleVoice()" title="Entrée vocale" style="background:none;border:none;cursor:pointer;color:var(--muted);font-size:16px;flex-shrink:0;transition:.2s"><i class="fas fa-microphone"></i></button>
        <!-- File -->
        <button onclick="document.getElementById('chat-file-input').click()" title="Envoyer un fichier" style="background:none;border:none;cursor:pointer;color:var(--muted);font-size:15px;flex-shrink:0"><i class="fas fa-paperclip"></i></button>
        <input type="file" id="chat-file-input" style="display:none" onchange="chatUploadFile(this)">
      </div>
      <button onclick="chatSend()" style="width:38px;height:38px;border-radius:50%;background:var(--orange);border:none;cursor:pointer;color:#fff;font-size:15px;flex-shrink:0;display:flex;align-items:center;justify-content:center"><i class="fas fa-paper-plane"></i></button>
    </div>
  </div>
</div>

<style>
/* ── Logout button */
.btn-logout{display:flex;align-items:center;gap:7px;padding:7px 14px;background:#FEF2F2;border:1.5px solid #FECACA;border-radius:9px;cursor:pointer;color:#DC2626;font-size:12px;font-weight:700;transition:.15s;white-space:nowrap}
.btn-logout:hover{background:#FEE2E2;border-color:#F87171;color:#B91C1C}
.btn-logout i{font-size:13px}
/* ── Panel flex layouts */
#notif-panel{flex-direction:column}
#chat-panel{flex-direction:column}
/* ── Notification list items */
.notif-item{display:flex;align-items:flex-start;gap:10px;padding:10px 18px;cursor:pointer;transition:.12s;border-bottom:1px solid #F8FAFC}
.notif-item:hover{background:#F8FAFC}
.notif-item.unread{background:#FFF7ED}
.notif-icon{width:34px;height:34px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:14px;flex-shrink:0}
.notif-title{font-size:12px;font-weight:600;color:var(--text)}
.notif-body{font-size:11px;color:var(--muted);margin-top:2px}
.notif-ago{font-size:10px;color:var(--muted);margin-top:3px}
/* ── Chat bubbles */
.chat-bubble{max-width:82%;padding:8px 12px;border-radius:14px;font-size:12.5px;line-height:1.5;word-break:break-word;white-space:pre-wrap}
.chat-bubble.mine{background:var(--orange);color:#fff;align-self:flex-end;border-bottom-right-radius:4px}
.chat-bubble.bot{background:#fff;color:var(--text);align-self:flex-start;border-bottom-left-radius:4px;box-shadow:0 1px 4px rgba(0,0,0,.08)}
.chat-bubble.other{background:#fff;color:var(--text);align-self:flex-start;border-bottom-left-radius:4px;box-shadow:0 1px 4px rgba(0,0,0,.08)}
.chat-sender{font-size:10px;color:var(--muted);margin-bottom:2px;align-self:flex-start}
.chat-file-card{display:flex;align-items:center;gap:8px;background:rgba(255,255,255,.25);border-radius:8px;padding:6px 10px;text-decoration:none;color:inherit}
.chat-file-card i{font-size:20px}
.chat-time{font-size:10px;color:var(--muted);margin-top:2px;align-self:flex-end}
.voice-active{color:var(--danger) !important;animation:pulse 1s infinite}
@keyframes pulse{0%,100%{opacity:1}50%{opacity:.5}}
/* ── Contact pills */
.contact-pill{border:none;padding:5px 11px;border-radius:20px;font-size:11px;font-weight:600;cursor:pointer;background:#F1F5F9;color:var(--muted);white-space:nowrap;transition:.15s;flex-shrink:0;display:flex;align-items:center;gap:4px}
.contact-pill.active{background:var(--orange);color:#fff}
.contact-pill:hover:not(.active){background:#E2E8F0;color:var(--text)}
.contact-pill .cp-av{width:18px;height:18px;border-radius:50%;font-size:9px;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0}
#chat-contacts-list::-webkit-scrollbar{display:none}
</style>

<script>
const CSRF        = document.querySelector('meta[name="csrf-token"]').content;
const USER_ROLE   = '{{ auth()->user()->role }}';
const USER_VIEWS  = @json(auth()->user()->allowed_views);
const USER_CAN_WRITE_STOCK = {{ in_array(auth()->user()->role, ['owner','admin','manager']) ? 'true' : 'false' }};
const USER_CAN_WRITE_COMPTA = {{ in_array(auth()->user()->role, ['owner','admin','accountant']) ? 'true' : 'false' }};

const pageTitles = {
  dashboard:    ['Tableau de bord',       "Vue d'ensemble de votre activité"],
  clients:      ['Clients',               'Gestion du portefeuille clients'],
  vehicules:    ['Véhicules',             'Parc automobile'],
  reparations:  ['Réparations',           'Ordres de travaux'],
  locations:    ['Locations',             'Gestion du parc de location'],
  stock:        ['Stock & Pièces',        "Gestion de l'inventaire"],
  comptabilite: ['Comptabilité',          'Suivi financier — ' + new Date().toLocaleString('fr', {month:'long', year:'numeric'})],
  employes:     ['Employés',              'Ressources humaines'],
  rapports:     ['Rapports',              'Analytiques & performances'],
  equipe:       ['Équipe & Accès',        'Gestion des agents et des permissions'],
  parametres:   ['Paramètres',            'Configuration du système'],
};

// ── Data loaded flags
const _loaded = {};

function showView(id, el) {
  if (!USER_VIEWS.includes(id)) {
    console.warn('Accès refusé à la vue:', id);
    return;
  }
  document.querySelectorAll('.view').forEach(v => v.classList.remove('active'));
  document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('active'));
  const viewEl = document.getElementById('view-' + id);
  if (!viewEl) return;
  viewEl.classList.add('active');
  if (el) el.classList.add('active');
  const t = pageTitles[id] || [id, ''];
  document.getElementById('page-title-text').textContent = t[0];
  document.getElementById('page-title-sub').textContent  = t[1];
  if (!_loaded[id]) { loadView(id); _loaded[id] = true; }
}

// Hide write buttons for read-only roles
document.addEventListener('DOMContentLoaded', function () {
  // Stock: mechanic can't add/delete items
  if (!USER_CAN_WRITE_STOCK) {
    document.querySelectorAll('#view-stock .btn-orange, #view-stock .fa-trash').forEach(el => {
      el.closest('button')?.remove() || el.remove();
    });
  }
  // Comptabilité: manager can't add/delete transactions
  if (!USER_CAN_WRITE_COMPTA) {
    document.querySelectorAll('[onclick="openModal(\'modal-transaction\')"]').forEach(el => el.remove());
  }
});

async function api(url, opts = {}) {
  const r = await fetch('/api/' + url, {
    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
    ...opts,
  });
  const json = await r.json();
  if (!r.ok) {
    console.error('API ' + r.status + ' — ' + url, json);
    if (r.status === 401) { window.location.href = '/login'; return {}; }
  }
  return json;
}

function fmt(n) { return Number(n).toLocaleString('fr'); }

function loadView(id) {
  switch (id) {
    case 'clients':      loadClients(); loadClientStats(); break;
    case 'vehicules':    loadVehicles(); break;
    case 'reparations':  loadRepairs(); loadRepairStats(); break;
    case 'locations':    loadRentals(); loadRentalStats(); break;
    case 'stock':        loadStock(); loadStockStats(); break;
    case 'comptabilite': loadCompta(); loadTransactionsList(); break;
    case 'employes':     loadEmployees(); loadEmployeeStats(); break;
    case 'rapports':     loadReports(); break;
    case 'equipe':       loadAgents(); break;
    case 'parametres':   loadCompanySettings(); break;
  }
}

// ── CLIENTS
async function loadClientStats() {
  const d = await api('clients/stats');
  document.getElementById('stat-clients-total').textContent = d.total;
  document.getElementById('stat-clients-vip').textContent   = d.vip;
  document.getElementById('stat-clients-new').textContent   = d.new_this_month;
}

async function loadClients(page = 1) {
  const d = await api(`clients?page=${page}`);
  if (!d.data) { document.getElementById('clients-tbody').innerHTML = `<tr><td colspan="7" style="text-align:center;padding:24px;color:var(--danger)">Erreur de chargement</td></tr>`; return; }
  const colors = ['#0D1B3E','#F97316','#10B981','#3B82F6','#8B5CF6','#EC4899','#F59E0B','#6B7280'];
  document.getElementById('clients-tbody').innerHTML = d.data.map((c, i) => `
    <tr>
      <td><div style="display:flex;align-items:center;gap:10px">
        <div class="av" style="background:${colors[i % colors.length]}">${c.first_name[0]}${c.last_name[0]}</div>
        <div><strong>${c.first_name} ${c.last_name}</strong><br><small style="color:var(--muted)">${c.email || '—'}</small></div>
      </div></td>
      <td>${c.phone}</td>
      <td><span class="badge ${c.type === 'entreprise' ? 'badge-navy' : 'badge-gray'}">${c.type}</span></td>
      <td>${c.repairs_count ?? '—'}</td>
      <td>${c.rentals_count ?? '—'}</td>
      <td><span class="badge badge-success">Actif</span></td>
      <td>
        <button class="btn btn-ghost btn-sm" onclick="viewClientDetail(${c.id})" title="Voir détails"><i class="fas fa-eye" style="color:var(--navy)"></i></button>
        <button class="btn btn-ghost btn-sm" onclick="editClient(${c.id})" title="Modifier"><i class="fas fa-edit" style="color:var(--info)"></i></button>
        <button class="btn btn-ghost btn-sm" onclick="deleteClient(${c.id})" title="Supprimer"><i class="fas fa-trash" style="color:var(--danger)"></i></button>
      </td>
    </tr>`).join('') || `<tr><td colspan="7" style="text-align:center;padding:24px;color:var(--muted)">Aucun client</td></tr>`;
}

// ── VEHICLES
async function loadVehicles() {
  const d = await api('vehicles?page=1');
  if (!d.data) { document.getElementById('vehicles-grid').innerHTML = '<div style="grid-column:1/-1;text-align:center;padding:48px;color:var(--danger)">Erreur de chargement</div>'; return; }
  const brandColors = {
    Toyota:['#EB0A1E','#9b0512'], Hyundai:['#002C5F','#001535'], Kia:['#BB162B','#7a0e1c'],
    Dacia:['#3d5a80','#1e3a5f'], Nissan:['#C3002F','#8b001f'], Peugeot:['#0D1B3E','#060f25'],
    Renault:['#F7B731','#d4860e'], Ford:['#003087','#001855'], Volkswagen:['#001E50','#000e2b'],
    Suzuki:['#004B87','#002d52'], Mitsubishi:['#CC2229','#8a1519'], Honda:['#CC0000','#880000'],
    Mercedes:['#1a1a1a','#333'], BMW:['#1c69d4','#0e4a99'], Audi:['#BB0A30','#7a0620'],
  };
  const statusCfg = {
    available:   { badge:'badge-success', label:'Disponible',    bg:'rgba(16,185,129,.12)', dot:'#10B981' },
    rented:      { badge:'badge-warning', label:'Loué',          bg:'rgba(245,158,11,.12)', dot:'#F59E0B' },
    maintenance: { badge:'badge-danger',  label:'Maintenance',   bg:'rgba(239,68,68,.12)',  dot:'#EF4444' },
    repair:      { badge:'badge-info',    label:'En réparation', bg:'rgba(59,130,246,.12)', dot:'#3B82F6' },
  };
  const fuelIcon = { essence:'fa-gas-pump', diesel:'fa-droplet', electrique:'fa-bolt', hybride:'fa-leaf' };
  document.getElementById('vehicles-grid').innerHTML = d.data.map(v => {
    const [c1, c2] = brandColors[v.brand] || ['#0D1B3E','#152648'];
    const sc = statusCfg[v.status] || statusCfg.available;
    return `
    <div class="vc" style="border-top:3px solid ${sc.dot}">
      <div class="vc-img" style="background:linear-gradient(135deg,${c1} 0%,${c2} 100%);display:flex;align-items:center;padding:0 20px;gap:16px;position:relative;overflow:hidden">
        <div style="width:56px;height:56px;border-radius:50%;background:rgba(255,255,255,.15);border:2px solid rgba(255,255,255,.25);display:flex;align-items:center;justify-content:center;font-size:24px;font-weight:800;color:#fff;flex-shrink:0;z-index:1">
          ${v.brand[0]}
        </div>
        <div style="z-index:1">
          <div style="font-size:16px;font-weight:800;color:#fff;line-height:1.2">${v.brand}</div>
          <div style="font-size:12px;color:rgba(255,255,255,.6);font-weight:500">${v.model} · ${v.year}</div>
          <div style="margin-top:6px"><span class="badge ${sc.badge}" style="font-size:11px">${sc.label}</span></div>
        </div>
        <i class="fas fa-car-side" style="position:absolute;right:-14px;bottom:-14px;font-size:110px;color:rgba(255,255,255,.06);z-index:0"></i>
        <div style="position:absolute;top:10px;right:10px;display:flex;gap:4px;z-index:2">
          <button class="btn btn-sm" style="background:rgba(255,255,255,.15);color:#fff;border:1px solid rgba(255,255,255,.25);padding:4px 8px;border-radius:6px;font-size:11px" onclick="viewVehicleDetail(${v.id})" title="Voir détails"><i class="fas fa-eye"></i></button>
          <button class="btn btn-sm" style="background:rgba(255,255,255,.15);color:#fff;border:1px solid rgba(255,255,255,.25);padding:4px 8px;border-radius:6px;font-size:11px" onclick="editVehicle(${v.id})" title="Modifier"><i class="fas fa-edit"></i></button>
          <button class="btn btn-sm" style="background:rgba(239,68,68,.25);color:#fca5a5;border:1px solid rgba(239,68,68,.3);padding:4px 8px;border-radius:6px;font-size:11px" onclick="deleteVehicle(${v.id})" title="Supprimer"><i class="fas fa-trash"></i></button>
        </div>
      </div>
      <div class="vc-body">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-bottom:12px">
          <div style="background:#F8FAFC;border-radius:7px;padding:8px;text-align:center">
            <div style="font-size:10px;color:var(--muted);font-weight:600;text-transform:uppercase;letter-spacing:.5px;margin-bottom:2px">Immat.</div>
            <div style="font-size:12px;font-weight:700;font-family:monospace">${v.registration}</div>
          </div>
          <div style="background:#F8FAFC;border-radius:7px;padding:8px;text-align:center">
            <div style="font-size:10px;color:var(--muted);font-weight:600;text-transform:uppercase;letter-spacing:.5px;margin-bottom:2px">Km</div>
            <div style="font-size:12px;font-weight:700">${fmt(v.mileage)}</div>
          </div>
        </div>
        <div style="display:flex;align-items:center;gap:10px;font-size:12px;color:var(--muted);flex-wrap:wrap;margin-bottom:12px">
          <span><i class="fas ${fuelIcon[v.fuel_type] || 'fa-gas-pump'}" style="color:var(--orange)"></i> ${v.fuel_type}</span>
          <span><i class="fas fa-sliders" style="color:var(--navy)"></i> ${v.transmission}</span>
          <span><i class="fas fa-users" style="color:var(--success)"></i> ${v.seats} places</span>
        </div>
        <div class="vc-footer">
          <div>
            <div style="font-size:11px;color:var(--muted);font-weight:500">Prix / jour</div>
            <div class="vc-price" style="margin-top:0">${v.price_per_day ? fmt(v.price_per_day) : '—'} <span>FCFA</span></div>
          </div>
          <span class="badge badge-gray" style="font-size:11px">${v.type === 'rental' ? 'Location' : 'Garage'}</span>
        </div>
      </div>
    </div>`;
  }).join('');
}

// ── REPAIRS
async function loadRepairStats() {
  const d = await api('repairs/stats');
  document.getElementById('stat-r-pending').textContent    = d.pending;
  document.getElementById('stat-r-inprogress').textContent = d.in_progress;
  document.getElementById('stat-r-done').textContent       = d.done_month;
}

async function loadRepairs() {
  const d = await api('repairs?page=1');
  const cols = { pending: [], in_progress: [], done: [] };
  d.data.forEach(r => { if (cols[r.status]) cols[r.status].push(r); });
  const colors = ['#0D1B3E','#F97316','#10B981','#3B82F6','#8B5CF6'];
  const card = (r, i) => `
    <div class="repair-card ${r.status}">
      <div class="rc-title">${r.vehicle?.brand ?? '?'} ${r.vehicle?.model ?? ''} · ${r.vehicle?.registration ?? ''}</div>
      <div class="rc-sub">${(r.description ?? '').substring(0, 55)}…</div>
      <div style="margin-top:8px">
        <span class="badge ${r.priority === 'urgent' ? 'badge-danger' : r.priority === 'high' ? 'badge-warning' : 'badge-gray'}" style="font-size:11px">
          ${r.priority === 'urgent' ? 'Urgent' : r.priority === 'high' ? 'Priorité haute' : 'Normal'}
        </span>
      </div>
      <div class="rc-footer">
        <div class="rc-mech">
          <div class="rc-av" style="background:${colors[i % colors.length]}">${r.employee ? r.employee.first_name[0] + r.employee.last_name[0] : '?'}</div>
          ${r.employee ? r.employee.first_name + ' ' + r.employee.last_name[0] + '.' : 'Non assigné'}
        </div>
        <div style="display:flex;gap:2px">
          <button class="btn btn-ghost btn-sm" onclick="editRepair(${r.id})" title="Modifier"><i class="fas fa-edit" style="color:var(--info)"></i></button>
          <button class="btn btn-ghost btn-sm" onclick="deleteRepair(${r.id})" title="Supprimer"><i class="fas fa-trash" style="color:var(--danger)"></i></button>
        </div>
      </div>
    </div>`;
  document.getElementById('k-pending').innerHTML    = cols.pending.map((r,i) => card(r,i)).join('') || '<p style="text-align:center;color:var(--muted);padding:16px;font-size:13px">Aucune</p>';
  document.getElementById('k-inprogress').innerHTML = cols.in_progress.map((r,i) => card(r,i)).join('') || '<p style="text-align:center;color:var(--muted);padding:16px;font-size:13px">Aucune</p>';
  document.getElementById('k-done').innerHTML       = cols.done.map((r,i) => card(r,i)).join('') || '<p style="text-align:center;color:var(--muted);padding:16px;font-size:13px">Aucune</p>';
  document.getElementById('k-pending-count').textContent    = cols.pending.length;
  document.getElementById('k-inprogress-count').textContent = cols.in_progress.length;
  document.getElementById('k-done-count').textContent       = cols.done.length;
}

// ── RENTALS
async function loadRentalStats() {
  const d = await api('rentals/stats');
  document.getElementById('stat-loc-available').textContent = d.available;
  document.getElementById('stat-loc-active').textContent    = d.active;
  document.getElementById('stat-loc-revenue').textContent   = fmt(d.revenue_month);
}

function fmtDate(iso) {
  if (!iso) return '—';
  const d = new Date(iso);
  return d.toLocaleDateString('fr-FR', { day: '2-digit', month: '2-digit', year: 'numeric' });
}

async function loadRentals() {
  const d = await api('rentals?page=1');
  if (!d.data) { document.getElementById('rentals-tbody').innerHTML = `<tr><td colspan="7" style="text-align:center;padding:24px;color:var(--danger)">Erreur de chargement</td></tr>`; return; }
  document.getElementById('rentals-tbody').innerHTML = d.data.map(r => `
    <tr>
      <td><strong>${r.client?.first_name ?? ''} ${r.client?.last_name ?? ''}</strong></td>
      <td>${r.vehicle?.brand ?? ''} ${r.vehicle?.model ?? ''}<br><small style="color:var(--muted)">${r.vehicle?.registration ?? ''}</small></td>
      <td style="font-size:12px;white-space:nowrap">${fmtDate(r.start_date)} → ${fmtDate(r.end_date)}</td>
      <td style="font-weight:700">${fmt(r.total_price)} FCFA</td>
      <td><span class="badge ${r.payment_status === 'paid' ? 'badge-success' : r.payment_status === 'partial' ? 'badge-info' : 'badge-warning'}">${r.payment_status === 'paid' ? 'Payé' : r.payment_status === 'partial' ? 'Acompte' : 'En attente'}</span></td>
      <td><span class="badge ${r.status === 'active' ? 'badge-info' : r.status === 'completed' ? 'badge-success' : 'badge-danger'}">${r.status === 'active' ? 'En cours' : r.status === 'completed' ? 'Terminée' : 'Annulée'}</span></td>
      <td style="white-space:nowrap">
        <button class="btn btn-ghost btn-sm" onclick="viewRentalDetail(${r.id})" title="Voir détails"><i class="fas fa-eye" style="color:var(--navy)"></i></button>
        ${r.status === 'active' ? `<button class="btn btn-ghost btn-sm" onclick="editRental(${r.id})" title="Modifier"><i class="fas fa-edit" style="color:var(--orange)"></i></button>` : ''}
        ${r.status === 'active' ? `<button class="btn btn-ghost btn-sm" onclick="completeRental(${r.id})" title="Terminer la location"><i class="fas fa-flag-checkered" style="color:var(--success)"></i></button>` : ''}
        <button class="btn btn-ghost btn-sm" onclick="deleteRental(${r.id})" title="Supprimer"><i class="fas fa-trash" style="color:var(--danger)"></i></button>
      </td>
    </tr>`).join('') || `<tr><td colspan="7" style="text-align:center;padding:24px;color:var(--muted)">Aucune location</td></tr>`;
}


// ── STOCK
async function loadStockStats() {
  const d = await api('stock/stats');
  document.getElementById('stat-stock-total').textContent    = d.total;
  document.getElementById('stat-stock-normal').textContent   = d.normal;
  document.getElementById('stat-stock-low').textContent      = d.low;
  document.getElementById('stat-stock-critical').textContent = d.critical;
  if (d.critical > 0 || d.low > 0) {
    document.getElementById('stock-alert-banner').style.display = 'flex';
    document.getElementById('stock-alert-text').textContent = `${d.critical} article(s) critique(s) et ${d.low} article(s) en stock faible — Réapprovisionnement recommandé`;
  }
}

async function loadStock() {
  const d = await api('stock?page=1');
  document.getElementById('stock-tbody').innerHTML = d.data.map(s => `
    <tr>
      <td style="font-family:monospace;font-size:12px">${s.reference}</td>
      <td><strong>${s.name}</strong></td>
      <td>${s.category_label ?? s.category}</td>
      <td style="font-weight:700;color:${s.quantity === 0 ? 'var(--danger)' : s.quantity <= s.min_quantity ? 'var(--warning)' : 'inherit'}">${s.quantity}</td>
      <td>${s.min_quantity}</td>
      <td>${fmt(s.unit_price)} FCFA</td>
      <td>${s.supplier || '—'}</td>
      <td><span class="badge ${s.quantity === 0 ? 'badge-danger' : s.quantity <= s.min_quantity ? 'badge-warning' : 'badge-success'}">${s.quantity === 0 ? 'Critique' : s.quantity <= s.min_quantity ? 'Faible' : 'Normal'}</span></td>
      <td>
        <button class="btn btn-ghost btn-sm" title="Modifier" onclick="editStock(${s.id})"><i class="fas fa-edit" style="color:var(--info)"></i></button>
        <button class="btn btn-ghost btn-sm" title="Réapprovisionner" onclick="restockItem(${s.id}, '${s.name}')"><i class="fas fa-plus-circle" style="color:var(--success)"></i></button>
        <button class="btn btn-ghost btn-sm" title="Supprimer" onclick="deleteStock(${s.id})"><i class="fas fa-trash" style="color:var(--danger)"></i></button>
      </td>
    </tr>`).join('');
}

async function restockItem(id, name) {
  const qty = prompt(`Quantité à ajouter pour "${name}" :`);
  if (!qty || isNaN(qty) || +qty <= 0) return;
  const cost = prompt(`Coût total de l'achat (FCFA, laisser vide pour ignorer) :`);
  const r = await api(`stock/${id}/restock`, { method: 'POST', body: JSON.stringify({ quantity: +qty, cost: cost ? +cost : null }) });
  alert(r.message);
  _loaded['stock'] = false; loadStock(); loadStockStats();
}

// ── COMPTABILITÉ
let comptaChart = null;
const CAT_LABEL = { reparation:'Réparation', location:'Location', salaires:'Salaires', fournitures:'Fournitures', charges:'Charges', achat_pieces:'Achat pièces' };
async function loadTransactionsList() {
  const tbody = document.getElementById('transactions-tbody');
  const d = await api('transactions?page=1');
  if (!d.data) {
    tbody.innerHTML = `<tr><td colspan="5" style="text-align:center;padding:24px;color:var(--danger)">Erreur de chargement</td></tr>`;
    return;
  }
  if (d.data.length === 0) {
    tbody.innerHTML = `<tr><td colspan="5" style="text-align:center;padding:24px;color:var(--muted)">Aucune transaction enregistrée</td></tr>`;
    return;
  }
  const typeColor = { revenue: 'badge-success', expense: 'badge-danger' };
  const typeLabel = { revenue: 'Revenu', expense: 'Dépense' };
  tbody.innerHTML = d.data.map(t => `
    <tr>
      <td>${t.date ? new Date(t.date).toLocaleDateString('fr') : '—'}</td>
      <td><span class="badge ${typeColor[t.type] || 'badge-gray'}">${typeLabel[t.type] || t.type}</span></td>
      <td>${CAT_LABEL[t.category] || t.category}</td>
      <td>${t.description}</td>
      <td style="font-weight:700;color:${t.type === 'revenue' ? 'var(--success)' : 'var(--danger)'}">
        ${t.type === 'expense' ? '-' : '+'}${fmt(t.amount)} FCFA
      </td>
      <td>
        <button class="btn btn-ghost btn-sm" onclick="editTransaction(${t.id})" title="Modifier"><i class="fas fa-edit"></i></button>
        <button class="btn btn-ghost btn-sm" onclick="deleteTransaction(${t.id})" title="Supprimer"><i class="fas fa-trash" style="color:var(--danger)"></i></button>
      </td>
    </tr>`).join('');
}

async function loadCompta() {
  const d = await api('transactions/summary');
  document.getElementById('stat-rev').textContent    = fmt(d.total_revenue);
  document.getElementById('stat-exp').textContent    = fmt(d.total_expense);
  document.getElementById('stat-profit').textContent = fmt(d.net_profit);
  document.getElementById('stat-margin').textContent = d.margin + '%';
  const period = new Date().toLocaleString('fr', { month: 'long', year: 'numeric' });
  document.getElementById('compta-period').textContent = 'Suivi financier — ' + period;
  // Donut chart
  const ctx = document.getElementById('chartCompta');
  if (comptaChart) comptaChart.destroy();
  const cats = d.revenue_by_category;
  comptaChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
      labels: Object.keys(cats).map(k => ({ reparation: 'Réparations', location: 'Location', autre: 'Autre' }[k] || k)),
      datasets: [{ data: Object.values(cats), backgroundColor: ['#0D1B3E','#F97316','#10B981','#3B82F6'], borderWidth: 0, hoverOffset: 6 }],
    },
    options: { responsive: true, maintainAspectRatio: false, cutout: '65%', plugins: { legend: { position: 'bottom', labels: { boxWidth: 10, font: { size: 12 }, padding: 16 } } } },
  });
  // Summary
  const r = d.revenue_by_category;
  const e = d.expense_by_category;
  document.getElementById('fin-summary').innerHTML = `
    <div style="font-size:12px;color:var(--muted);font-weight:600;text-transform:uppercase;letter-spacing:.5px;margin-bottom:10px">Revenus</div>
    ${Object.entries(r).map(([k,v]) => `<div class="fin-row"><span class="fin-label"><i class="fas fa-${k === 'reparation' ? 'wrench' : 'key'}" style="color:var(--orange);margin-right:8px"></i>${{ reparation:'Garage — Réparations', location:'Location', autre:'Autre' }[k] || k}</span><span class="fin-val pos">${fmt(v)} FCFA</span></div>`).join('')}
    <div style="font-size:12px;color:var(--muted);font-weight:600;text-transform:uppercase;letter-spacing:.5px;margin:14px 0 10px">Dépenses</div>
    ${Object.entries(e).map(([k,v]) => `<div class="fin-row"><span class="fin-label">${{ salaires:'<i class="fas fa-users" style="color:var(--info);margin-right:8px"></i>Salaires', achat_pieces:'<i class="fas fa-boxes" style="color:var(--warning);margin-right:8px"></i>Achat pièces', charges:'<i class="fas fa-bolt" style="color:var(--warning);margin-right:8px"></i>Charges' }[k] || k}</span><span class="fin-val neg">-${fmt(v)} FCFA</span></div>`).join('')}
    <div style="background:linear-gradient(135deg,var(--navy),#1e3a8a);border-radius:10px;padding:14px;margin-top:16px;display:flex;justify-content:space-between;align-items:center">
      <span style="color:rgba(255,255,255,.7);font-size:13px">Bénéfice net</span>
      <span style="color:var(--orange);font-size:20px;font-weight:800">${fmt(d.net_profit)} FCFA</span>
    </div>`;
}

// ── EMPLOYEES
async function loadEmployeeStats() {
  const d = await api('employees/stats');
  document.getElementById('stat-emp-total').textContent = d.total;
  document.getElementById('stat-emp-mech').textContent  = d.mechanics;
  document.getElementById('stat-emp-admin').textContent = d.admin;
}

async function loadEmployees() {
  const d = await api('employees?page=1');
  const palette = ['#0D1B3E','#F97316','#10B981','#3B82F6','#8B5CF6','#EC4899','#F59E0B','#6B7280'];
  document.getElementById('employees-grid').innerHTML = d.data.map((e, i) => `
    <div class="emp-card">
      <div class="emp-av" style="background:${palette[i % palette.length]}">${e.first_name[0]}${e.last_name[0]}</div>
      <div class="emp-name">${e.first_name} ${e.last_name}</div>
      <div class="emp-role"><span class="badge badge-gray">${e.role_label ?? e.role}</span></div>
      <div class="emp-stats">
        <div class="emp-stat"><strong>${e.repairs_this_month ?? 0}</strong><span>Ce mois</span></div>
        <div class="emp-stat"><strong>${e.performance ?? 0}%</strong><span>Perf.</span></div>
      </div>
      <div style="margin-bottom:10px">
        <div style="display:flex;justify-content:space-between;font-size:12px;margin-bottom:5px"><span style="color:var(--muted)">Performance</span><strong>${e.performance ?? 0}%</strong></div>
        <div class="progress"><div class="progress-bar" style="width:${e.performance ?? 0}%;background:${palette[i % palette.length]}"></div></div>
      </div>
      <span class="badge ${e.status === 'active' ? 'badge-success' : 'badge-gray'}" style="width:100%;justify-content:center">${e.status === 'active' ? 'Actif' : 'Inactif'}</span>
      <div style="display:flex;gap:6px;margin-top:10px;justify-content:center">
        <button class="btn btn-outline btn-sm" onclick="editEmployee(${e.id})"><i class="fas fa-edit"></i> Modifier</button>
        <button class="btn btn-ghost btn-sm" onclick="deleteEmployee(${e.id})"><i class="fas fa-trash" style="color:var(--danger)"></i></button>
      </div>
    </div>`).join('');
}

// ── REPORTS
let rChart1 = null;
async function loadReports() {
  const [monthly, mechanics, vehicles, clients] = await Promise.all([
    api('reports/monthly'),
    api('reports/top-mechanics'),
    api('reports/top-vehicles'),
    api('reports/top-clients'),
  ]);
  // Monthly chart
  const ctx1 = document.getElementById('chartRapport1');
  if (rChart1) rChart1.destroy();
  rChart1 = new Chart(ctx1, {
    type: 'bar',
    data: {
      labels: monthly.labels,
      datasets: [
        { label: 'Garage', data: monthly.garage, backgroundColor: '#0D1B3E', borderRadius: 6 },
        { label: 'Location', data: monthly.rental, backgroundColor: '#F97316', borderRadius: 6 },
      ],
    },
    options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom', labels: { boxWidth: 10 } } }, scales: { x: { grid: { display: false } }, y: { grid: { color: '#F1F5F9' } } } },
  });
  // Top mechanics
  const palette = ['#0D1B3E','#F97316','#10B981','#3B82F6','#8B5CF6'];
  document.getElementById('mechanics-perf').innerHTML = mechanics.map((m, i) => `
    <div style="margin-bottom:12px">
      <div style="display:flex;justify-content:space-between;font-size:13px;margin-bottom:5px">
        <strong>${m.name}</strong><span style="color:${m.performance >= 80 ? 'var(--success)' : 'var(--warning)'};font-weight:700">${m.performance}%</span>
      </div>
      <div class="progress"><div class="progress-bar" style="width:${m.performance}%;background:${palette[i % palette.length]}"></div></div>
      <div style="font-size:11px;color:var(--muted);margin-top:3px">${m.role} · ${m.done_repairs}/${m.total_repairs} réparations</div>
    </div>`).join('') || '<p style="color:var(--muted);text-align:center">Aucune donnée</p>';
  // Top vehicles
  document.getElementById('top-vehicles').innerHTML = vehicles.map((v, i) => `
    <div class="mini-stat">
      <div class="msi" style="background:${['var(--orange-light)','rgba(13,27,62,.08)','rgba(16,185,129,.1)','rgba(59,130,246,.1)','rgba(139,92,246,.1)','rgba(245,158,11,.1)'][i % 6]};color:${palette[i % palette.length]}"><i class="fas fa-car"></i></div>
      <div><div class="msv">${v.rentals_count} fois</div><div class="msl">${v.name}</div></div>
      <span style="margin-left:auto;font-size:12px;font-weight:700;color:var(--orange)">${fmt(v.total_revenue)} FCFA</span>
    </div>`).join('') || '<p style="color:var(--muted);text-align:center">Aucune donnée</p>';
  // Top clients
  document.getElementById('top-clients').innerHTML = clients.map((c, i) => `
    <div class="fin-row">
      <div style="display:flex;align-items:center;gap:10px">
        <div class="av" style="width:30px;height:30px;background:${palette[i % palette.length]};font-size:11px">${c.name.split(' ').map(w=>w[0]).join('').substring(0,2)}</div>
        <strong>${c.name}</strong>
      </div>
      <span style="font-weight:700;color:var(--orange)">${fmt(c.total)} FCFA</span>
    </div>`).join('') || '<p style="color:var(--muted);text-align:center">Aucune donnée</p>';
}

// ── MODALS
let _modal = { mode: 'create', id: null };

function openModal(id, data = null) {
  document.querySelectorAll('.modal').forEach(m => m.classList.remove('active'));
  document.getElementById('modal-overlay').style.display = 'flex';
  const modal = document.getElementById(id);
  if (!modal) return;
  modal.classList.add('active');
  _modal = { mode: data ? 'edit' : 'create', id: data?.id ?? null };
  if (id === 'modal-client')      setupClientModal(data);
  if (id === 'modal-vehicle')     setupVehicleModal(data);
  if (id === 'modal-repair')      setupRepairModal(data);
  if (id === 'modal-rental')      setupRentalModal(data);
  if (id === 'modal-stock')       setupStockModal(data);
  if (id === 'modal-employee')    setupEmployeeModal(data);
  if (id === 'modal-transaction') setupTransactionModal();
  if (id === 'modal-agent')       setupAgentModal(data);
}

function closeModal() {
  document.getElementById('modal-overlay').style.display = 'none';
  document.querySelectorAll('.modal').forEach(m => m.classList.remove('active'));
}

function closeModalOnOverlay(e) {
  if (e.target.id === 'modal-overlay') closeModal();
}

// ─── Client
function setupClientModal(data) {
  document.getElementById('modal-client-title').textContent = data ? 'Modifier le client' : 'Nouveau client';
  const textFields = ['first_name','last_name','phone','phone2','email','city','address','nationality','profession','id_number','company_name','notes'];
  if (data) {
    textFields.forEach(f => { const el = document.getElementById('c-' + f); if (el) el.value = data[f] ?? ''; });
    document.getElementById('c-type').value      = data.type ?? 'particulier';
    document.getElementById('c-id_type').value   = data.id_type ?? '';
    document.getElementById('c-date_of_birth').value = data.date_of_birth ? data.date_of_birth.substring(0,10) : '';
  } else {
    document.querySelectorAll('#modal-client input,#modal-client textarea,#modal-client select').forEach(el => {
      if (el.tagName === 'SELECT') el.selectedIndex = 0; else el.value = '';
    });
    document.getElementById('c-type').value = 'particulier';
  }
  toggleCompany();
}

function toggleCompany() {
  document.getElementById('c-company-wrap').style.display =
    document.getElementById('c-type').value === 'entreprise' ? '' : 'none';
}

async function saveClient() {
  const g = id => document.getElementById(id)?.value.trim() || null;
  const payload = {
    first_name:    document.getElementById('c-first_name').value.trim(),
    last_name:     document.getElementById('c-last_name').value.trim(),
    phone:         document.getElementById('c-phone').value.trim(),
    phone2:        g('c-phone2'),
    email:         g('c-email'),
    city:          g('c-city'),
    address:       g('c-address'),
    nationality:   g('c-nationality'),
    profession:    g('c-profession'),
    date_of_birth: g('c-date_of_birth'),
    id_type:       document.getElementById('c-id_type').value || null,
    id_number:     g('c-id_number'),
    type:          document.getElementById('c-type').value,
    company_name:  g('c-company_name'),
    notes:         g('c-notes'),
  };
  if (!payload.first_name || !payload.last_name || !payload.phone) {
    alert('Prénom, nom et téléphone sont obligatoires.'); return;
  }
  const r = _modal.mode === 'edit'
    ? await api(`clients/${_modal.id}`, { method: 'PUT', body: JSON.stringify(payload) })
    : await api('clients', { method: 'POST', body: JSON.stringify(payload) });
  if (r.errors) { alert(Object.values(r.errors).flat().join('\n')); return; }
  alert(r.message ?? 'Enregistré.');
  closeModal();
  _loaded['clients'] = false;
  loadClients(); loadClientStats();
}

async function editClient(id) {
  const data = await api(`clients/${id}`);
  openModal('modal-client', data);
}

function viewClient(id) { viewClientDetail(id); }

async function viewClientDetail(id) {
  document.getElementById('client-detail-body').innerHTML = '<div style="text-align:center;padding:40px;color:var(--muted)"><i class="fas fa-spinner fa-spin"></i> Chargement…</div>';
  document.getElementById('modal-overlay').style.display = 'flex';
  document.querySelectorAll('.modal').forEach(m => m.classList.remove('active'));
  document.getElementById('modal-client-detail').classList.add('active');
  const c = await api(`clients/${id}`);
  const idTypeLabel = { cni:'CNI', passeport:'Passeport', permis:'Permis de conduire', autre:'Autre' };
  const colors = ['#0D1B3E','#F97316','#10B981','#3B82F6','#8B5CF6','#EC4899'];
  const color  = colors[id % colors.length];
  const val = (v, fallback = '—') => v ? `<span class="di-value">${v}</span>` : `<span class="di-value empty">${fallback}</span>`;
  document.getElementById('client-detail-body').innerHTML = `
    <div class="detail-banner" style="background:linear-gradient(135deg,${color}18,${color}08);border:1.5px solid ${color}22">
      <div class="detail-av" style="background:linear-gradient(135deg,${color},${color}bb)">${c.first_name?.[0] ?? '?'}${c.last_name?.[0] ?? ''}</div>
      <div>
        <div style="font-size:20px;font-weight:800;color:var(--navy)">${c.first_name} ${c.last_name}</div>
        <div style="font-size:13px;color:var(--muted);margin-top:2px">${c.type === 'entreprise' ? (c.company_name ?? 'Entreprise') : 'Particulier'}</div>
        <div style="margin-top:8px;display:flex;gap:8px;flex-wrap:wrap">
          ${c.repairs_count ? `<span class="badge badge-info">${c.repairs_count} réparation${c.repairs_count > 1?'s':''}</span>` : ''}
          ${c.rentals_count ? `<span class="badge badge-warning">${c.rentals_count} location${c.rentals_count > 1?'s':''}</span>` : ''}
        </div>
      </div>
    </div>
    <div class="detail-section">
      <div class="detail-section-title"><i class="fas fa-user"></i> Identité</div>
      <div class="detail-grid">
        <div class="detail-item"><div class="di-label">Prénom</div>${val(c.first_name)}</div>
        <div class="detail-item"><div class="di-label">Nom</div>${val(c.last_name)}</div>
        <div class="detail-item"><div class="di-label">Date de naissance</div>${val(c.date_of_birth ? new Date(c.date_of_birth).toLocaleDateString('fr-FR') : null)}</div>
        <div class="detail-item"><div class="di-label">Nationalité</div>${val(c.nationality)}</div>
        <div class="detail-item" style="grid-column:1/-1"><div class="di-label">Profession</div>${val(c.profession)}</div>
      </div>
    </div>
    <div class="detail-section">
      <div class="detail-section-title"><i class="fas fa-id-card"></i> Pièce d'identité</div>
      <div class="detail-grid">
        <div class="detail-item"><div class="di-label">Type de pièce</div>${val(c.id_type ? idTypeLabel[c.id_type] : null)}</div>
        <div class="detail-item"><div class="di-label">Numéro de pièce</div>${val(c.id_number)}</div>
      </div>
    </div>
    <div class="detail-section">
      <div class="detail-section-title"><i class="fas fa-phone"></i> Contact</div>
      <div class="detail-grid">
        <div class="detail-item"><div class="di-label">Téléphone</div>${val(c.phone)}</div>
        <div class="detail-item"><div class="di-label">Téléphone 2</div>${val(c.phone2)}</div>
        <div class="detail-item"><div class="di-label">Email</div>${val(c.email)}</div>
        <div class="detail-item"><div class="di-label">Ville</div>${val(c.city)}</div>
        <div class="detail-item" style="grid-column:1/-1"><div class="di-label">Adresse</div>${val(c.address)}</div>
      </div>
    </div>
    ${c.notes ? `<div class="detail-section"><div class="detail-section-title"><i class="fas fa-sticky-note"></i> Notes</div><div style="background:#fffbf0;border:1.5px solid #fde68a;border-radius:8px;padding:12px;font-size:13px;line-height:1.6">${c.notes}</div></div>` : ''}
    ${(c.repairs?.length || c.rentals?.length) ? `
    <div class="detail-section">
      <div class="detail-section-title"><i class="fas fa-history"></i> Historique</div>
      ${(c.repairs ?? []).map(r => `<div class="detail-hist-row"><span><i class="fas fa-wrench" style="color:var(--orange);margin-right:6px"></i>${r.vehicle?.brand ?? ''} ${r.vehicle?.model ?? ''} — ${(r.description ?? '').substring(0,40)}</span><span class="badge badge-info" style="font-size:11px">${fmt(r.total_cost ?? 0)} FCFA</span></div>`).join('')}
      ${(c.rentals ?? []).map(r => `<div class="detail-hist-row"><span><i class="fas fa-key" style="color:var(--success);margin-right:6px"></i>${r.vehicle?.brand ?? ''} ${r.vehicle?.model ?? ''}</span><span class="badge badge-warning" style="font-size:11px">${fmt(r.total_price ?? 0)} FCFA</span></div>`).join('')}
    </div>` : ''}
  `;
  document.getElementById('btn-edit-client-from-detail').onclick = () => { closeModal(); editClient(id); };
}

function deleteClient(id) {
  if (!confirm('Supprimer ce client ?')) return;
  api(`clients/${id}`, { method: 'DELETE' }).then(r => {
    alert(r.message);
    _loaded['clients'] = false;
    loadClients(); loadClientStats();
  });
}

// ─── Vehicle
function setupVehicleModal(data) {
  document.getElementById('modal-vehicle-title').textContent = data ? 'Modifier le véhicule' : 'Ajouter un véhicule';
  const allFields = ['type','brand','model','registration','year','fuel_type','transmission','seats','mileage','price_per_day','status','color','notes',
                     'owner_name','owner_phone','owner_phone2','owner_email','owner_address','owner_id_type','owner_id_number'];
  if (data) {
    allFields.forEach(f => { const el = document.getElementById('v-' + f); if (el) el.value = data[f] ?? ''; });
  } else {
    document.querySelectorAll('#modal-vehicle input,#modal-vehicle textarea,#modal-vehicle select').forEach(el => {
      if (el.tagName === 'SELECT') el.selectedIndex = 0; else el.value = '';
    });
    document.getElementById('v-type').value         = 'rental';
    document.getElementById('v-status').value       = 'available';
    document.getElementById('v-fuel_type').value    = 'essence';
    document.getElementById('v-transmission').value = 'manuel';
    document.getElementById('v-seats').value        = '5';
    document.getElementById('v-mileage').value      = '0';
  }
}

async function saveVehicle() {
  const gv = id => document.getElementById(id)?.value.trim() || null;
  const payload = {
    type:             document.getElementById('v-type').value,
    brand:            document.getElementById('v-brand').value.trim(),
    model:            document.getElementById('v-model').value.trim(),
    registration:     document.getElementById('v-registration').value.trim(),
    year:             parseInt(document.getElementById('v-year').value),
    fuel_type:        document.getElementById('v-fuel_type').value,
    transmission:     document.getElementById('v-transmission').value,
    seats:            parseInt(document.getElementById('v-seats').value),
    mileage:          parseInt(document.getElementById('v-mileage').value) || 0,
    price_per_day:    parseInt(document.getElementById('v-price_per_day').value) || null,
    status:           document.getElementById('v-status').value,
    color:            gv('v-color'),
    notes:            gv('v-notes'),
    owner_name:       gv('v-owner_name'),
    owner_phone:      gv('v-owner_phone'),
    owner_phone2:     gv('v-owner_phone2'),
    owner_email:      gv('v-owner_email'),
    owner_address:    gv('v-owner_address'),
    owner_id_type:    document.getElementById('v-owner_id_type').value || null,
    owner_id_number:  gv('v-owner_id_number'),
  };
  if (!payload.brand || !payload.model || !payload.registration) {
    alert('Marque, modèle et immatriculation sont obligatoires.'); return;
  }
  const r = _modal.mode === 'edit'
    ? await api(`vehicles/${_modal.id}`, { method: 'PUT', body: JSON.stringify(payload) })
    : await api('vehicles', { method: 'POST', body: JSON.stringify(payload) });
  if (r.errors) { alert(Object.values(r.errors).flat().join('\n')); return; }
  alert(r.message ?? 'Enregistré.');
  closeModal();
  _loaded['vehicules'] = false;
  loadVehicles();
}

async function editVehicle(id) {
  const data = await api(`vehicles/${id}`);
  openModal('modal-vehicle', data);
}

async function deleteVehicle(id) {
  if (!confirm('Supprimer ce véhicule ?')) return;
  const r = await api(`vehicles/${id}`, { method: 'DELETE' });
  alert(r.message);
  _loaded['vehicules'] = false;
  loadVehicles();
}

async function viewVehicleDetail(id) {
  document.getElementById('vehicle-detail-body').innerHTML = '<div style="text-align:center;padding:40px;color:var(--muted)"><i class="fas fa-spinner fa-spin"></i> Chargement…</div>';
  document.getElementById('modal-overlay').style.display = 'flex';
  document.querySelectorAll('.modal').forEach(m => m.classList.remove('active'));
  document.getElementById('modal-vehicle-detail').classList.add('active');
  const v = await api(`vehicles/${id}`);
  const idTypeLabel = { cni:'CNI', passeport:'Passeport', permis:'Permis de conduire', autre:'Autre' };
  const statusCfg   = { available:{label:'Disponible',color:'#10B981'}, rented:{label:'Loué',color:'#F59E0B'}, maintenance:{label:'Maintenance',color:'#EF4444'}, repair:{label:'En réparation',color:'#3B82F6'} };
  const sc = statusCfg[v.status] || statusCfg.available;
  const fuelLabel = { essence:'Essence', diesel:'Diesel', electrique:'Électrique', hybride:'Hybride' };
  const val = (x) => x ? `<span class="di-value">${x}</span>` : `<span class="di-value empty">—</span>`;
  document.getElementById('vehicle-detail-body').innerHTML = `
    <div class="detail-banner" style="background:linear-gradient(135deg,${sc.color}18,${sc.color}08);border:1.5px solid ${sc.color}22">
      <div class="detail-av" style="background:linear-gradient(135deg,var(--navy),var(--navy2));font-size:18px">${v.brand?.[0] ?? '?'}</div>
      <div style="flex:1">
        <div style="font-size:20px;font-weight:800;color:var(--navy)">${v.brand} ${v.model} <span style="font-size:13px;color:var(--muted);font-weight:500">${v.year}</span></div>
        <div style="font-family:monospace;font-size:15px;font-weight:700;color:var(--orange);margin-top:2px">${v.registration}</div>
        <div style="margin-top:8px;display:flex;gap:8px;flex-wrap:wrap">
          <span class="badge" style="background:${sc.color}18;color:${sc.color}">${sc.label}</span>
          <span class="badge badge-gray">${v.type === 'rental' ? 'Location' : 'Garage'}</span>
          ${v.repairs_count ? `<span class="badge badge-info">${v.repairs_count} réparation${v.repairs_count>1?'s':''}</span>` : ''}
        </div>
      </div>
    </div>
    <div class="detail-section">
      <div class="detail-section-title"><i class="fas fa-car"></i> Informations du véhicule</div>
      <div class="detail-grid cols3">
        <div class="detail-item"><div class="di-label">Marque</div>${val(v.brand)}</div>
        <div class="detail-item"><div class="di-label">Modèle</div>${val(v.model)}</div>
        <div class="detail-item"><div class="di-label">Année</div>${val(v.year)}</div>
        <div class="detail-item"><div class="di-label">Immatriculation</div><span class="di-value" style="font-family:monospace">${v.registration}</span></div>
        <div class="detail-item"><div class="di-label">Couleur</div>${val(v.color)}</div>
        <div class="detail-item"><div class="di-label">Kilométrage</div>${val(fmt(v.mileage) + ' km')}</div>
        <div class="detail-item"><div class="di-label">Carburant</div>${val(fuelLabel[v.fuel_type])}</div>
        <div class="detail-item"><div class="di-label">Transmission</div>${val(v.transmission === 'manuel' ? 'Manuelle' : 'Automatique')}</div>
        <div class="detail-item"><div class="di-label">Places</div>${val(v.seats)}</div>
        ${v.price_per_day ? `<div class="detail-item" style="grid-column:1/-1"><div class="di-label">Prix / jour</div><span class="di-value" style="color:var(--orange);font-size:16px;font-weight:800">${fmt(v.price_per_day)} FCFA</span></div>` : ''}
      </div>
    </div>
    ${(v.owner_name || v.owner_phone || v.owner_id_number) ? `
    <div class="detail-section">
      <div class="detail-section-title"><i class="fas fa-user-tie"></i> Propriétaire</div>
      <div class="detail-grid">
        <div class="detail-item"><div class="di-label">Nom complet</div>${val(v.owner_name)}</div>
        <div class="detail-item"><div class="di-label">Téléphone</div>${val(v.owner_phone)}</div>
        <div class="detail-item"><div class="di-label">Téléphone 2</div>${val(v.owner_phone2)}</div>
        <div class="detail-item"><div class="di-label">Email</div>${val(v.owner_email)}</div>
        <div class="detail-item" style="grid-column:1/-1"><div class="di-label">Adresse</div>${val(v.owner_address)}</div>
        <div class="detail-item"><div class="di-label">Type de pièce</div>${val(v.owner_id_type ? idTypeLabel[v.owner_id_type] : null)}</div>
        <div class="detail-item"><div class="di-label">Numéro de pièce</div>${val(v.owner_id_number)}</div>
      </div>
    </div>` : ''}
    ${v.notes ? `<div class="detail-section"><div class="detail-section-title"><i class="fas fa-sticky-note"></i> Notes</div><div style="background:#fffbf0;border:1.5px solid #fde68a;border-radius:8px;padding:12px;font-size:13px;line-height:1.6">${v.notes}</div></div>` : ''}
    ${(v.repairs?.length) ? `
    <div class="detail-section">
      <div class="detail-section-title"><i class="fas fa-wrench"></i> Dernières réparations</div>
      ${v.repairs.map(r => `<div class="detail-hist-row"><span><i class="fas fa-wrench" style="color:var(--orange);margin-right:6px"></i>${r.client?.first_name ?? ''} ${r.client?.last_name ?? ''} — ${(r.description ?? '').substring(0,45)}</span><span class="badge badge-info" style="font-size:11px">${fmt(r.total_cost ?? 0)} FCFA</span></div>`).join('')}
    </div>` : ''}
  `;
  document.getElementById('btn-edit-vehicle-from-detail').onclick = () => { closeModal(); editVehicle(id); };
}

// ─── Repair
let _repairVehicles = []; // cached for owner lookup

function onRepairVehicleChange() {
  const vid = parseInt(document.getElementById('r-vehicle_id').value);
  const panel   = document.getElementById('r-owner-panel');
  const content = document.getElementById('r-owner-content');
  const v = _repairVehicles.find(x => x.id === vid);
  if (!v || !v.owner_name) { panel.style.display = 'none'; return; }
  const idLabel = { cni:'CNI', passeport:'Passeport', permis:'Permis', autre:'Autre' };
  const cell = (label, value) => value
    ? `<div style="background:rgba(249,115,22,.06);border-radius:7px;padding:8px 10px"><div style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:var(--orange);margin-bottom:3px">${label}</div><div style="font-size:13px;font-weight:600;color:var(--navy)">${value}</div></div>`
    : '';
  content.innerHTML = [
    cell('Propriétaire', v.owner_name),
    cell('Téléphone', v.owner_phone),
    cell('Tél. 2', v.owner_phone2),
    cell('Email', v.owner_email),
    cell('Adresse', v.owner_address),
    cell('Pièce d\'identité', v.owner_id_type ? `${idLabel[v.owner_id_type]} — ${v.owner_id_number ?? ''}` : null),
  ].filter(Boolean).join('');
  panel.style.display = content.innerHTML ? '' : 'none';
}

async function setupRepairModal(data) {
  document.getElementById('modal-repair-title').textContent = data ? 'Modifier la réparation' : 'Nouvel ordre de réparation';
  document.getElementById('r-owner-panel').style.display = 'none';
  const [clients, vehicles, employees] = await Promise.all([
    api('clients?page=1'), api('vehicles?page=1'), api('employees?page=1'),
  ]);
  _repairVehicles = vehicles.data ?? [];
  document.getElementById('r-client_id').innerHTML =
    '<option value="">Sélectionner un client…</option>' +
    clients.data.map(c => `<option value="${c.id}">${c.first_name} ${c.last_name}</option>`).join('');
  document.getElementById('r-vehicle_id').innerHTML =
    '<option value="">Sélectionner un véhicule…</option>' +
    vehicles.data.map(v => `<option value="${v.id}">${v.brand} ${v.model} — ${v.registration}</option>`).join('');
  document.getElementById('r-employee_id').innerHTML =
    '<option value="">Non assigné</option>' +
    employees.data.map(e => `<option value="${e.id}">${e.first_name} ${e.last_name}</option>`).join('');
  if (data) {
    document.getElementById('r-client_id').value      = data.client_id ?? '';
    document.getElementById('r-vehicle_id').value     = data.vehicle_id ?? '';
    onRepairVehicleChange();
    document.getElementById('r-employee_id').value    = data.employee_id ?? '';
    document.getElementById('r-type').value           = data.type ?? 'reparation';
    document.getElementById('r-priority').value       = data.priority ?? 'normal';
    document.getElementById('r-status').value         = data.status ?? 'pending';
    document.getElementById('r-payment_status').value = data.payment_status ?? 'pending';
    document.getElementById('r-description').value    = data.description ?? '';
    document.getElementById('r-diagnosis').value      = data.diagnosis ?? '';
    document.getElementById('r-labor_cost').value     = data.labor_cost ?? 0;
    document.getElementById('r-entered_at').value     = (data.entered_at ?? '').substring(0, 10);
    document.getElementById('r-completed_at').value   = (data.completed_at ?? '').substring(0, 10);
  } else {
    document.getElementById('r-client_id').value      = '';
    document.getElementById('r-vehicle_id').value     = '';
    document.getElementById('r-employee_id').value    = '';
    document.getElementById('r-type').value           = 'reparation';
    document.getElementById('r-priority').value       = 'normal';
    document.getElementById('r-status').value         = 'pending';
    document.getElementById('r-payment_status').value = 'pending';
    document.getElementById('r-description').value    = '';
    document.getElementById('r-diagnosis').value      = '';
    document.getElementById('r-labor_cost').value     = 0;
    document.getElementById('r-entered_at').value     = new Date().toISOString().split('T')[0];
    document.getElementById('r-completed_at').value   = '';
  }
}

async function saveRepair() {
  const payload = {
    client_id:      document.getElementById('r-client_id').value,
    vehicle_id:     document.getElementById('r-vehicle_id').value,
    employee_id:    document.getElementById('r-employee_id').value || null,
    type:           document.getElementById('r-type').value,
    priority:       document.getElementById('r-priority').value,
    status:         document.getElementById('r-status').value,
    payment_status: document.getElementById('r-payment_status').value,
    description:    document.getElementById('r-description').value.trim(),
    diagnosis:      document.getElementById('r-diagnosis').value.trim() || null,
    labor_cost:     parseInt(document.getElementById('r-labor_cost').value) || 0,
    entered_at:     document.getElementById('r-entered_at').value,
    completed_at:   document.getElementById('r-completed_at').value || null,
  };
  if (!payload.client_id || !payload.vehicle_id || !payload.description) {
    alert('Client, véhicule et description sont obligatoires.'); return;
  }
  const r = _modal.mode === 'edit'
    ? await api(`repairs/${_modal.id}`, { method: 'PUT', body: JSON.stringify(payload) })
    : await api('repairs', { method: 'POST', body: JSON.stringify(payload) });
  if (r.errors) { alert(Object.values(r.errors).flat().join('\n')); return; }
  alert(r.message ?? 'Enregistré.');
  closeModal();
  _loaded['reparations'] = false;
  loadRepairs(); loadRepairStats();
}

async function editRepair(id) {
  const data = await api(`repairs/${id}`);
  openModal('modal-repair', data);
}

async function deleteRepair(id) {
  if (!confirm('Supprimer cet ordre de réparation ?')) return;
  const r = await api(`repairs/${id}`, { method: 'DELETE' });
  alert(r.message);
  _loaded['reparations'] = false;
  loadRepairs(); loadRepairStats();
}

// ─── Rental modal
window._editingRentalId = null;

async function setupRentalModal(data = null) {
  window._editingRentalId = data ? data.id : null;
  document.getElementById('modal-rental-title').textContent = data ? 'Modifier la réservation' : 'Nouvelle réservation';
  document.getElementById('mr-save-btn').textContent = data ? 'Enregistrer' : 'Confirmer';

  // For edits, include the current vehicle even if not "available"
  const vehicleParam = data ? `type=rental` : `status=available&type=rental`;
  const [clients, vehicles] = await Promise.all([
    api('clients?page=1'), api(`vehicles?${vehicleParam}`),
  ]);
  document.getElementById('mr-client_id').innerHTML =
    '<option value="">Sélectionner un client…</option>' +
    clients.data.map(c => `<option value="${c.id}" ${data?.client_id == c.id ? 'selected' : ''}>${c.first_name} ${c.last_name}</option>`).join('');
  document.getElementById('mr-vehicle_id').innerHTML =
    '<option value="">Sélectionner un véhicule…</option>' +
    vehicles.data.map(v => `<option value="${v.id}" data-ppd="${v.price_per_day}" ${data?.vehicle_id == v.id ? 'selected' : ''}>${v.brand} ${v.model} — ${fmt(v.price_per_day)} FCFA/j</option>`).join('');

  if (data) {
    document.getElementById('mr-start').value = data.start_date ? data.start_date.split('T')[0] : '';
    document.getElementById('mr-end').value   = data.end_date   ? data.end_date.split('T')[0]   : '';
    document.getElementById('mr-pay-status').value = data.payment_status ?? 'paid';
    document.getElementById('mr-pay-method').value = data.payment_method ?? 'especes';
    document.getElementById('mr-total-display').textContent = fmt(data.total_price) + ' FCFA';
    document.getElementById('mr-total-display').dataset.total = data.total_price;
    document.getElementById('mr-total-display').dataset.ppd   = data.price_per_day;
    document.getElementById('mr-calc-detail').textContent = `${data.days ?? ''} jour(s) × ${fmt(data.price_per_day)} FCFA`;
  } else {
    document.getElementById('mr-start').value  = new Date().toISOString().split('T')[0];
    document.getElementById('mr-end').value    = '';
    document.getElementById('mr-pay-status').value = 'paid';
    document.getElementById('mr-pay-method').value = 'especes';
    document.getElementById('mr-total-display').textContent = '— FCFA';
    document.getElementById('mr-calc-detail').textContent = 'Sélectionner un véhicule et des dates';
    delete document.getElementById('mr-total-display').dataset.total;
  }
}

function updateModalRentalTotal() {
  const sel = document.getElementById('mr-vehicle_id');
  const ppd = parseInt(sel.options[sel.selectedIndex]?.dataset?.ppd || 0);
  const s = document.getElementById('mr-start').value;
  const e = document.getElementById('mr-end').value;
  if (ppd && s && e) {
    const days = Math.max(1, Math.round((new Date(e) - new Date(s)) / 86400000));
    const total = days * ppd;
    document.getElementById('mr-total-display').textContent = fmt(total) + ' FCFA';
    document.getElementById('mr-calc-detail').textContent = `${days} jour(s) × ${fmt(ppd)} FCFA`;
    document.getElementById('mr-total-display').dataset.total = total;
    document.getElementById('mr-total-display').dataset.ppd   = ppd;
  }
}

async function saveRental() {
  const clientId  = document.getElementById('mr-client_id').value;
  const vehicleId = document.getElementById('mr-vehicle_id').value;
  const start     = document.getElementById('mr-start').value;
  const end       = document.getElementById('mr-end').value;
  const total     = document.getElementById('mr-total-display').dataset.total;
  const ppd       = document.getElementById('mr-total-display').dataset.ppd;
  if (!clientId || !vehicleId || !start || !end) { alert('Veuillez remplir tous les champs.'); return; }
  const editId = window._editingRentalId;
  const r = await api(editId ? `rentals/${editId}` : 'rentals', {
    method: editId ? 'PUT' : 'POST',
    body: JSON.stringify({
      client_id: clientId, vehicle_id: vehicleId,
      start_date: start, end_date: end,
      price_per_day: ppd, total_price: total,
      status: 'active',
      payment_status: document.getElementById('mr-pay-status').value,
      payment_method: document.getElementById('mr-pay-method').value,
    }),
  });
  if (r.errors) { alert(Object.values(r.errors).flat().join('\n')); return; }
  alert(r.message ?? (editId ? 'Réservation mise à jour.' : 'Réservation confirmée.'));
  closeModal();
  _loaded['locations'] = false;
  loadRentals(); loadRentalStats();
}

async function deleteRental(id) {
  if (!confirm('Annuler cette location ?')) return;
  const r = await api(`rentals/${id}`, { method: 'DELETE' });
  alert(r.message);
  _loaded['locations'] = false;
  loadRentals(); loadRentalStats();
}

async function editRental(id) {
  const rental = await api(`rentals/${id}`);
  openModal('modal-rental', rental);
}

async function completeRental(id) {
  if (!confirm('Marquer cette location comme terminée ?')) return;
  const rental = await api(`rentals/${id}`);
  const r = await api(`rentals/${id}`, {
    method: 'PUT',
    body: JSON.stringify({ ...rental, status: 'completed' }),
  });
  if (r.errors) { alert(Object.values(r.errors).flat().join('\n')); return; }
  alert(r.message ?? 'Location terminée.');
  _loaded['locations'] = false;
  loadRentals(); loadRentalStats();
}

async function viewRentalDetail(id) {
  const r = await api(`rentals/${id}`);
  const payBadge = r.payment_status === 'paid' ? 'badge-success' : r.payment_status === 'partial' ? 'badge-info' : 'badge-warning';
  const payLabel = r.payment_status === 'paid' ? 'Payé' : r.payment_status === 'partial' ? 'Acompte' : 'En attente';
  const stBadge  = r.status === 'active' ? 'badge-info' : r.status === 'completed' ? 'badge-success' : 'badge-danger';
  const stLabel  = r.status === 'active' ? 'En cours' : r.status === 'completed' ? 'Terminée' : 'Annulée';
  document.getElementById('rental-detail-body').innerHTML = `
    <div class="detail-banner" style="background:var(--navy);color:#fff;border-radius:10px;padding:18px 20px;margin-bottom:18px;display:flex;align-items:center;gap:16px">
      <div style="background:var(--orange);border-radius:50%;width:48px;height:48px;display:flex;align-items:center;justify-content:center;font-size:22px"><i class="fas fa-car-side"></i></div>
      <div>
        <div style="font-size:18px;font-weight:700">${r.vehicle?.brand ?? ''} ${r.vehicle?.model ?? ''}</div>
        <div style="font-size:13px;opacity:.7">${r.vehicle?.registration ?? ''} · ${r.client?.first_name ?? ''} ${r.client?.last_name ?? ''}</div>
      </div>
      <div style="margin-left:auto;text-align:right">
        <span class="badge ${stBadge}">${stLabel}</span>
        <div style="margin-top:6px"><span class="badge ${payBadge}">${payLabel}</span></div>
      </div>
    </div>
    <div class="detail-section">
      <div class="detail-section-title">Période</div>
      <div class="detail-grid">
        <div class="detail-item"><span class="detail-label">Départ</span><span class="detail-value">${fmtDate(r.start_date)}</span></div>
        <div class="detail-item"><span class="detail-label">Retour</span><span class="detail-value">${fmtDate(r.end_date)}</span></div>
        <div class="detail-item"><span class="detail-label">Durée</span><span class="detail-value">${r.days ?? '—'} jour(s)</span></div>
      </div>
    </div>
    <div class="detail-section">
      <div class="detail-section-title">Paiement</div>
      <div class="detail-grid">
        <div class="detail-item"><span class="detail-label">Prix / jour</span><span class="detail-value">${fmt(r.price_per_day)} FCFA</span></div>
        <div class="detail-item"><span class="detail-label">Total</span><span class="detail-value" style="font-weight:700;color:var(--orange)">${fmt(r.total_price)} FCFA</span></div>
        <div class="detail-item"><span class="detail-label">Mode</span><span class="detail-value">${r.payment_method === 'especes' ? 'Espèces' : r.payment_method === 'virement' ? 'Virement' : 'Mobile Money'}</span></div>
      </div>
    </div>
    ${r.notes ? `<div class="detail-section"><div class="detail-section-title">Notes</div><p style="font-size:14px;color:var(--text);margin:0">${r.notes}</p></div>` : ''}
  `;
  document.getElementById('modal-overlay').style.display = 'flex';
  document.querySelectorAll('.modal').forEach(m => m.classList.remove('active'));
  document.getElementById('modal-rental-detail').classList.add('active');
}

// ─── Stock
function setupStockModal(data) {
  document.getElementById('modal-stock-title').textContent = data ? 'Modifier la pièce' : 'Ajouter une pièce';
  if (data) {
    ['reference','name','category','quantity','min_quantity','unit_price','supplier','notes'].forEach(f => {
      const el = document.getElementById('s-' + f); if (el) el.value = data[f] ?? '';
    });
  } else {
    document.querySelectorAll('#modal-stock input,#modal-stock textarea').forEach(el => el.value = '');
    document.getElementById('s-category').value    = 'freinage';
    document.getElementById('s-quantity').value    = '0';
    document.getElementById('s-min_quantity').value = '2';
  }
}

async function saveStock() {
  const payload = {
    reference:    document.getElementById('s-reference').value.trim(),
    name:         document.getElementById('s-name').value.trim(),
    category:     document.getElementById('s-category').value,
    quantity:     parseInt(document.getElementById('s-quantity').value) || 0,
    min_quantity: parseInt(document.getElementById('s-min_quantity').value) || 0,
    unit_price:   parseInt(document.getElementById('s-unit_price').value) || 0,
    supplier:     document.getElementById('s-supplier').value.trim() || null,
    notes:        document.getElementById('s-notes').value.trim() || null,
  };
  if (!payload.reference || !payload.name) { alert('Référence et désignation sont obligatoires.'); return; }
  const r = _modal.mode === 'edit'
    ? await api(`stock/${_modal.id}`, { method: 'PUT', body: JSON.stringify(payload) })
    : await api('stock', { method: 'POST', body: JSON.stringify(payload) });
  if (r.errors) { alert(Object.values(r.errors).flat().join('\n')); return; }
  alert(r.message ?? 'Enregistré.');
  closeModal();
  _loaded['stock'] = false;
  loadStock(); loadStockStats();
}

async function editStock(id) {
  const data = await api(`stock/${id}`);
  openModal('modal-stock', data);
}

async function deleteStock(id) {
  if (!confirm('Supprimer cette pièce ?')) return;
  const r = await api(`stock/${id}`, { method: 'DELETE' });
  alert(r.message);
  _loaded['stock'] = false;
  loadStock(); loadStockStats();
}

// ─── Employee
function setupEmployeeModal(data) {
  document.getElementById('modal-employee-title').textContent = data ? "Modifier l'employé" : 'Ajouter un employé';
  if (data) {
    ['first_name','last_name','phone','email','salary'].forEach(f => {
      const el = document.getElementById('e-' + f); if (el) el.value = data[f] ?? '';
    });
    document.getElementById('e-role').value     = data.role ?? 'mecanicien';
    document.getElementById('e-status').value   = data.status ?? 'active';
    document.getElementById('e-hired_at').value = (data.hired_at ?? '').substring(0, 10);
  } else {
    document.querySelectorAll('#modal-employee input').forEach(el => el.value = '');
    document.getElementById('e-role').value     = 'mecanicien';
    document.getElementById('e-status').value   = 'active';
    document.getElementById('e-hired_at').value = new Date().toISOString().split('T')[0];
  }
}

async function saveEmployee() {
  const payload = {
    first_name: document.getElementById('e-first_name').value.trim(),
    last_name:  document.getElementById('e-last_name').value.trim(),
    role:       document.getElementById('e-role').value,
    phone:      document.getElementById('e-phone').value.trim(),
    email:      document.getElementById('e-email').value.trim() || null,
    salary:     parseInt(document.getElementById('e-salary').value) || 0,
    hired_at:   document.getElementById('e-hired_at').value,
    status:     document.getElementById('e-status').value,
  };
  if (!payload.first_name || !payload.last_name || !payload.phone) {
    alert('Prénom, nom et téléphone sont obligatoires.'); return;
  }
  const r = _modal.mode === 'edit'
    ? await api(`employees/${_modal.id}`, { method: 'PUT', body: JSON.stringify(payload) })
    : await api('employees', { method: 'POST', body: JSON.stringify(payload) });
  if (r.errors) { alert(Object.values(r.errors).flat().join('\n')); return; }
  alert(r.message ?? 'Enregistré.');
  closeModal();
  _loaded['employes'] = false;
  loadEmployees(); loadEmployeeStats();
}

async function editEmployee(id) {
  const data = await api(`employees/${id}`);
  openModal('modal-employee', data);
}

async function deleteEmployee(id) {
  if (!confirm('Supprimer cet employé ?')) return;
  const r = await api(`employees/${id}`, { method: 'DELETE' });
  alert(r.message);
  _loaded['employes'] = false;
  loadEmployees(); loadEmployeeStats();
}

// ─── Transaction
function setupTransactionModal() {
  document.querySelectorAll('#modal-transaction input').forEach(el => el.value = '');
  document.getElementById('t-type').value     = 'revenue';
  document.getElementById('t-category').value = 'reparation';
  document.getElementById('t-date').value     = new Date().toISOString().split('T')[0];
}

async function saveTransaction() {
  const payload = {
    type:        document.getElementById('t-type').value,
    category:    document.getElementById('t-category').value,
    amount:      parseInt(document.getElementById('t-amount').value) || 0,
    description: document.getElementById('t-description').value.trim(),
    date:        document.getElementById('t-date').value,
  };
  if (!payload.amount || !payload.description || !payload.date) {
    alert('Montant, description et date sont obligatoires.'); return;
  }
  const r = _modal.mode === 'edit'
    ? await api(`transactions/${_modal.id}`, { method: 'PUT', body: JSON.stringify(payload) })
    : await api('transactions', { method: 'POST', body: JSON.stringify(payload) });
  if (r.errors) { alert(Object.values(r.errors).flat().join('\n')); return; }
  alert(r.message ?? 'Opération enregistrée.');
  closeModal();
  _loaded['comptabilite'] = false;
  loadCompta();
  loadTransactionsList();
}

async function editTransaction(id) {
  const t = await api(`transactions/${id}`);
  if (!t.id) return;
  openModal('modal-transaction');
  document.getElementById('modal-transaction').querySelector('h3').textContent = 'Modifier la transaction';
  document.getElementById('t-type').value        = t.type;
  document.getElementById('t-category').value    = t.category;
  document.getElementById('t-amount').value      = t.amount;
  document.getElementById('t-description').value = t.description;
  document.getElementById('t-date').value        = t.date ? t.date.split('T')[0] : '';
  _modal.mode = 'edit';
  _modal.id   = id;
}

async function deleteTransaction(id) {
  if (!confirm('Supprimer cette transaction ?')) return;
  const r = await api(`transactions/${id}`, { method: 'DELETE' });
  alert(r.message ?? 'Supprimée.');
  _loaded['comptabilite'] = false;
  loadCompta();
  loadTransactionsList();
}

function quickRent(vid, ppd, name) { showView('locations', document.querySelector('.nav-item[onclick*=locations]')); }

// ─────────────────────────────────────────────────────────
// AGENTS
// ─────────────────────────────────────────────────────────
const ROLE_COLORS = { owner:'#0D1B3E', admin:'#F97316', manager:'#3B82F6', mechanic:'#10B981', accountant:'#8B5CF6', receptionist:'#F59E0B' };

const ALL_VIEWS = [
  { key:'dashboard',    label:'Tableau de bord', icon:'fa-chart-pie',  required:true  },
  { key:'clients',      label:'Clients',          icon:'fa-users',      required:false },
  { key:'vehicules',    label:'Véhicules',        icon:'fa-car',        required:false },
  { key:'reparations',  label:'Réparations',      icon:'fa-wrench',     required:false },
  { key:'locations',    label:'Locations',        icon:'fa-key',        required:false },
  { key:'stock',        label:'Stock & Pièces',   icon:'fa-boxes',      required:false },
  { key:'employes',     label:'Employés',         icon:'fa-hard-hat',   required:false },
  { key:'comptabilite', label:'Comptabilité',     icon:'fa-wallet',     required:false },
  { key:'rapports',     label:'Rapports',         icon:'fa-chart-bar',  required:false },
  { key:'equipe',       label:'Équipe & Accès',   icon:'fa-user-shield',required:false },
  { key:'parametres',   label:'Paramètres',       icon:'fa-cog',        required:false },
];

const ROLE_DEFAULTS = {
  admin:        ['dashboard','clients','vehicules','reparations','locations','stock','employes','comptabilite','rapports','equipe','parametres'],
  manager:      ['dashboard','clients','vehicules','reparations','locations','stock','employes','rapports'],
  mechanic:     ['dashboard','reparations','stock'],
  accountant:   ['dashboard','comptabilite','rapports'],
  receptionist: ['dashboard','clients','vehicules','locations'],
};

function renderPermissionCheckboxes(checked = [], available = null) {
  const container = document.getElementById('permission-checkboxes');
  const views = available ? ALL_VIEWS.filter(v => available.includes(v.key)) : ALL_VIEWS;
  container.innerHTML = views.map(v => {
    const isChecked  = checked.includes(v.key);
    const isRequired = v.required;
    return `<div class="perm-item ${isChecked ? 'checked' : ''} ${isRequired ? 'disabled' : ''}"
                 data-view="${v.key}"
                 onclick="${isRequired ? '' : 'togglePermission(this)'}">
      <span class="perm-dot"></span>
      <i class="fas ${v.icon} perm-icon"></i>
      <span class="perm-label">${v.label}</span>
    </div>`;
  }).join('');
}

function togglePermission(el) {
  el.classList.toggle('checked');
}

function getCheckedPermissions() {
  return [...document.querySelectorAll('#permission-checkboxes .perm-item.checked')]
    .map(el => el.dataset.view);
}

function updateRolePreview(role) {
  const defaults = ROLE_DEFAULTS[role] ?? ['dashboard'];
  renderPermissionCheckboxes(defaults);
}
const ROLE_LABELS = { owner:'Propriétaire', admin:'Administrateur', manager:'Manager', mechanic:'Mécanicien', accountant:'Comptable', receptionist:'Réceptionniste' };

async function loadAgents() {
  const d = await api('agents');
  if (!d.agents) { document.getElementById('agents-grid').innerHTML = '<div style="text-align:center;padding:40px;color:var(--danger);grid-column:1/-1">Erreur de chargement</div>'; return; }
  // Plan info bar
  const planInfo = document.getElementById('equipe-plan-info');
  planInfo.style.display = 'block';
  document.getElementById('plan-label-badge').textContent = d.plan_info?.label ?? d.plan;
  document.getElementById('plan-agents-used').textContent = d.total;
  document.getElementById('plan-agents-max').textContent  = d.max_agents ?? '∞';
  document.getElementById('equipe-subtitle').textContent  = `${d.total} agent${d.total > 1 ? 's' : ''} — Plan ${d.plan_info?.label ?? d.plan}`;
  document.getElementById('agents-grid').innerHTML = d.agents.map(a => `
    <div class="agent-card">
      <div class="ag-av" style="background:${ROLE_COLORS[a.role] ?? '#6B7280'}">${a.initials}</div>
      <div class="ag-info">
        <div class="ag-name">${a.name}</div>
        <div class="ag-email">${a.email}</div>
        <div style="margin-top:6px"><span class="badge" style="background:${ROLE_COLORS[a.role] ?? '#6B7280'}22;color:${ROLE_COLORS[a.role] ?? '#6B7280'}">${ROLE_LABELS[a.role] ?? a.role}</span>${!a.is_active ? '<span class="badge badge-danger" style="margin-left:4px">Inactif</span>' : ''}</div>
      </div>
      ${a.role !== 'owner' ? `<div class="ag-actions">
        <button class="btn btn-outline btn-sm" onclick="editAgent(${a.id})" title="Modifier"><i class="fas fa-edit"></i></button>
        <button class="btn btn-outline btn-sm" style="color:var(--danger);border-color:var(--danger)" onclick="deleteAgent(${a.id})" title="Supprimer"><i class="fas fa-trash"></i></button>
      </div>` : ''}
    </div>`).join('');
}

function setupAgentModal(data = null) {
  ['ag-name','ag-phone','ag-email','ag-password'].forEach(id => { const el = document.getElementById(id); if (el) el.value = ''; });
  const roleEl = document.getElementById('ag-role');
  roleEl.value = 'mechanic';
  document.getElementById('ag-status-group').style.display = 'none';
  document.getElementById('ag-password-group').querySelector('label').textContent = 'Mot de passe *';
  if (data) {
    document.getElementById('ag-name').value  = data.name  ?? '';
    document.getElementById('ag-phone').value = data.phone ?? '';
    document.getElementById('ag-email').value = data.email ?? '';
    roleEl.value = data.role ?? 'mechanic';
    document.getElementById('ag-status-group').style.display = 'block';
    document.getElementById('ag-is_active').value = data.is_active ? '1' : '0';
    document.getElementById('ag-password-group').querySelector('label').textContent = 'Nouveau mot de passe (laisser vide = inchangé)';
    // Use existing custom permissions or role defaults — all views shown, owner decides
    const perms = (data.permissions && data.permissions.length) ? data.permissions : (ROLE_DEFAULTS[data.role] ?? ['dashboard']);
    renderPermissionCheckboxes(perms);
  } else {
    renderPermissionCheckboxes(ROLE_DEFAULTS[roleEl.value] ?? ['dashboard']);
  }
}

async function saveAgent() {
  const payload = {
    name:        document.getElementById('ag-name').value.trim(),
    email:       document.getElementById('ag-email').value.trim(),
    phone:       document.getElementById('ag-phone').value.trim() || null,
    role:        document.getElementById('ag-role').value,
    permissions: getCheckedPermissions(),
  };
  const pw = document.getElementById('ag-password').value;
  if (pw) payload.password = pw;
  if (_modal.mode === 'edit') {
    payload.is_active = document.getElementById('ag-is_active').value === '1';
  }
  if (!payload.name || !payload.email) { alert('Nom et email sont obligatoires.'); return; }
  if (_modal.mode === 'create' && !pw) { alert('Le mot de passe est obligatoire.'); return; }
  if (payload.permissions.length === 0) { alert('Accordez au moins un accès à cet agent.'); return; }
  const r = _modal.mode === 'edit'
    ? await api(`agents/${_modal.id}`, { method: 'PUT', body: JSON.stringify(payload) })
    : await api('agents', { method: 'POST', body: JSON.stringify(payload) });
  if (r.errors) { alert(Object.values(r.errors).flat().join('\n')); return; }
  if (r.message && r.message.includes('Limite')) { alert(r.message); return; }
  alert(r.message ?? 'Enregistré.');
  closeModal();
  _loaded['equipe'] = false;
  loadAgents();
}

async function editAgent(id) {
  const agents = (await api('agents')).agents;
  const data = agents?.find(a => a.id === id);
  if (data) openModal('modal-agent', data);
}

async function deleteAgent(id) {
  if (!confirm('Supprimer cet agent ?')) return;
  const r = await api(`agents/${id}`, { method: 'DELETE' });
  alert(r.message ?? 'Supprimé.');
  _loaded['equipe'] = false;
  loadAgents();
}

// ─────────────────────────────────────────────────────────
// COMPANY SETTINGS
// ─────────────────────────────────────────────────────────
async function loadCompanySettings() {
  const d = await api('company');
  if (!d.id) return;
  document.getElementById('set-name').value     = d.name     ?? '';
  document.getElementById('set-phone').value    = d.phone    ?? '';
  document.getElementById('set-email').value    = d.email    ?? '';
  document.getElementById('set-address').value  = d.address  ?? '';
  document.getElementById('set-website').value  = d.website  ?? '';
  const cur = document.getElementById('set-currency');
  if (cur) cur.value = d.currency ?? 'FCFA';
  if (d.logo_url) {
    document.getElementById('current-logo').style.display = 'block';
    document.getElementById('logo-preview').src = d.logo_url;
  }
  // Plans
  const plans = await api('plans');
  const planKeys = Object.keys(plans);
  document.getElementById('plans-grid').innerHTML = planKeys.map(key => {
    const p = plans[key];
    const isCurrent = d.plan === key;
    return `<div class="plan-card ${isCurrent ? 'active' : ''}">
      <div class="plan-name">${p.label}</div>
      <div class="plan-price">${p.price === 0 ? 'Gratuit' : Number(p.price).toLocaleString('fr') + ' FCFA'}<small>/mois</small></div>
      <div class="plan-feature"><i class="fas fa-users"></i> ${p.max_agents < 999 ? p.max_agents + ' agents' : 'Illimité'}</div>
      ${isCurrent ? '' : `<button class="btn btn-orange btn-sm" style="width:100%;margin-top:10px;justify-content:center" onclick="alert('Contactez-nous pour changer de plan.')">Choisir</button>`}
    </div>`;
  }).join('');
}

async function saveCompanySettings() {
  const payload = {
    name:     document.getElementById('set-name').value.trim(),
    phone:    document.getElementById('set-phone').value.trim() || null,
    email:    document.getElementById('set-email').value.trim() || null,
    address:  document.getElementById('set-address').value.trim() || null,
    website:  document.getElementById('set-website').value.trim() || null,
    currency: document.getElementById('set-currency').value,
  };
  if (!payload.name) { alert('Le nom de l\'entreprise est obligatoire.'); return; }
  const r = await api('company', { method: 'PUT', body: JSON.stringify(payload) });
  if (r.errors) { alert(Object.values(r.errors).flat().join('\n')); return; }
  alert(r.message ?? 'Mis à jour.');
  if (r.company) {
    document.getElementById('sb-company-name').textContent = r.company.name;
  }
}

async function uploadLogo(input) {
  const file = input.files[0];
  if (!file) return;
  const form = new FormData();
  form.append('logo', file);
  const r = await fetch('/api/company/logo', {
    method: 'POST',
    headers: { 'X-CSRF-TOKEN': CSRF },
    body: form,
  });
  const json = await r.json();
  if (!r.ok) { alert(json.message ?? 'Erreur upload'); return; }
  alert(json.message ?? 'Logo mis à jour.');
  if (json.logo_url) {
    document.getElementById('current-logo').style.display = 'block';
    document.getElementById('logo-preview').src = json.logo_url;
    document.getElementById('sb-logo-icon').innerHTML = `<img src="${json.logo_url}" style="width:100%;height:100%;object-fit:cover;border-radius:10px">`;
  }
}

// ─────────────────────────────────────────────────────────
// EXPORT PDF & EXCEL
// ─────────────────────────────────────────────────────────
function exportPDF(tableId, title) {
  const table = document.getElementById(tableId);
  if (!table) { alert('Aucune donnée à exporter.'); return; }
  const { jsPDF } = window.jspdf;
  const doc = new jsPDF({ orientation: 'landscape' });
  doc.setFontSize(14);
  doc.text(title + ' — ' + new Date().toLocaleDateString('fr'), 14, 15);
  doc.autoTable({ html: '#' + tableId, startY: 22, styles: { fontSize: 9, cellPadding: 3 }, headStyles: { fillColor: [13, 27, 62], textColor: 255, fontStyle: 'bold' }, alternateRowStyles: { fillColor: [248, 250, 252] }, didParseCell: (data) => { if (data.section === 'body' && data.column.index === data.table.columns.length - 1) data.cell.styles.fillColor = 255; } });
  doc.save(title.toLowerCase().replace(/\s+/g,'-') + '-' + new Date().toISOString().slice(0,10) + '.pdf');
}

function exportExcel(tableId, filename) {
  const table = document.getElementById(tableId);
  if (!table) { alert('Aucune donnée à exporter.'); return; }
  const wb = XLSX.utils.book_new();
  const ws = XLSX.utils.table_to_sheet(table);
  XLSX.utils.book_append_sheet(wb, ws, filename);
  XLSX.writeFile(wb, filename + '-' + new Date().toISOString().slice(0,10) + '.xlsx');
}

// ── DASHBOARD CHARTS (initial data from server)
const revenueData = @json($revenueChart);
const weeklyData  = @json($weeklyChart);

const cOpts = {
  responsive: true, maintainAspectRatio: false,
  plugins: { legend: { position: 'bottom', labels: { boxWidth: 10, font: { size: 12 }, padding: 16 } },
    tooltip: { backgroundColor: '#0D1B3E', padding: 10, cornerRadius: 8 } },
  scales: { x: { grid: { display: false }, ticks: { font: { size: 11 }, color: '#94A3B8' } },
            y: { grid: { color: '#F1F5F9' }, ticks: { font: { size: 11 }, color: '#94A3B8' } } }
};
new Chart(document.getElementById('chartRevenu'), {
  type: 'line',
  data: {
    labels: revenueData.labels,
    datasets: [
      { label: 'Garage', data: revenueData.garage, borderColor: '#0D1B3E', backgroundColor: 'rgba(13,27,62,.07)', fill: true, tension: .4, pointRadius: 3, pointBackgroundColor: '#0D1B3E' },
      { label: 'Location', data: revenueData.rental, borderColor: '#F97316', backgroundColor: 'rgba(249,115,22,.07)', fill: true, tension: .4, pointRadius: 3, pointBackgroundColor: '#F97316' },
    ],
  },
  options: cOpts,
});
new Chart(document.getElementById('chartActivite'), {
  type: 'bar',
  data: {
    labels: weeklyData.labels,
    datasets: [
      { label: 'Réparations', data: weeklyData.repairs, backgroundColor: '#0D1B3E', borderRadius: 6 },
      { label: 'Locations',   data: weeklyData.rentals, backgroundColor: '#F97316', borderRadius: 6 },
    ],
  },
  options: { ...cOpts, scales: { x: { grid: { display: false }, ticks: { font: { size: 11 }, color: '#94A3B8' } }, y: { grid: { color: '#F1F5F9' }, ticks: { font: { size: 11 }, color: '#94A3B8' } } } },
});

// ════════════════════════════════════════════
// NOTIFICATIONS
// ════════════════════════════════════════════
const NOTIF_COLORS = { info:'#3B82F6', success:'#10B981', warning:'#F59E0B', danger:'#EF4444' };

let _notifOpen = false;
let _notifData = [];

function toggleNotifPanel() {
  _notifOpen = !_notifOpen;
  const p = document.getElementById('notif-panel');
  p.style.display = _notifOpen ? 'flex' : 'none';
  if (_notifOpen) loadNotifications();
}
function closeNotifPanel() {
  _notifOpen = false;
  document.getElementById('notif-panel').style.display = 'none';
}

async function loadNotifications() {
  const list = document.getElementById('notif-list');
  list.innerHTML = `<div style="text-align:center;padding:32px;color:var(--muted)"><i class="fas fa-spinner fa-spin"></i></div>`;
  try {
    const d = await api('app-notifications');
    if (!d || !d.notifications) throw new Error();
    _notifData = d.notifications;
    document.getElementById('notif-dot').style.display = d.unread > 0 ? 'block' : 'none';
    list.innerHTML = _notifData.length === 0
      ? `<div style="text-align:center;padding:40px 20px;color:var(--muted)">
           <i class="fas fa-bell-slash" style="font-size:32px;display:block;margin-bottom:10px;opacity:.3"></i>
           <div style="font-size:13px;font-weight:500">Aucune notification</div>
           <div style="font-size:11px;margin-top:4px;opacity:.7">Les alertes apparaîtront ici</div>
         </div>`
      : _notifData.map(n => {
          const col = NOTIF_COLORS[n.type] ?? '#6B7280';
          return `<div class="notif-item ${n.read ? '' : 'unread'}" onclick="clickNotif(${n.id},'${n.link_view ?? ''}')">
            <div class="notif-icon" style="background:${col}22;color:${col}">
              <i class="fas fa-${n.icon ?? 'bell'}"></i>
            </div>
            <div style="flex:1;min-width:0;overflow:hidden">
              <div class="notif-title">${n.title}</div>
              ${n.body ? `<div class="notif-body" style="overflow:hidden;text-overflow:ellipsis;white-space:nowrap">${n.body}</div>` : ''}
              <div class="notif-ago">${n.ago}</div>
            </div>
            ${!n.read ? `<div style="width:8px;height:8px;border-radius:50%;background:var(--orange);flex-shrink:0;margin-top:6px"></div>` : ''}
          </div>`;
        }).join('');
  } catch {
    list.innerHTML = `<div style="text-align:center;padding:32px;color:var(--muted)">
      <i class="fas fa-exclamation-circle" style="font-size:24px;display:block;margin-bottom:8px;opacity:.4"></i>
      <div style="font-size:12px">Erreur de chargement</div>
    </div>`;
  }
}

async function clickNotif(id, linkView) {
  await api(`app-notifications/${id}/read`, { method: 'PUT' });
  closeNotifPanel();
  if (linkView) showView(linkView, document.querySelector(`.nav-item[onclick*="${linkView}"]`));
  loadNotifications();
}

async function readAllNotifs() {
  await api('app-notifications/read-all', { method: 'PUT' });
  loadNotifications();
}

// Poll unread count
async function pollNotifDot() {
  try {
    const d = await api('app-notifications');
    if (d && typeof d.unread === 'number') {
      document.getElementById('notif-dot').style.display = d.unread > 0 ? 'block' : 'none';
    }
  } catch {}
}
setInterval(() => { if (!_notifOpen) pollNotifDot(); }, 30000);
setTimeout(pollNotifDot, 1500);


// ════════════════════════════════════════════
// CHAT PANEL
// ════════════════════════════════════════════
let _chatOpen      = false;
let _chatTab       = 'bot';
let _chatPolling   = null;
let _chatRecipient = null;   // null = broadcast, {id, name} = DM
let _teamMembers   = [];

function toggleChatPanel() {
  _chatOpen = !_chatOpen;
  const p = document.getElementById('chat-panel');
  p.style.display = _chatOpen ? 'flex' : 'none';
  if (_chatOpen) {
    loadBotHistory();
    loadTeamMessages();
    startChatPolling();
    document.getElementById('chat-input').focus();
  } else {
    stopChatPolling();
  }
}
function closeChatPanel() {
  _chatOpen = false;
  document.getElementById('chat-panel').style.display = 'none';
  stopChatPolling();
}

function switchChatTab(tab) {
  _chatTab = tab;
  document.getElementById('chat-bot-body').style.display      = tab === 'bot'  ? 'flex' : 'none';
  document.getElementById('chat-team-body').style.display     = tab === 'team' ? 'flex' : 'none';
  document.getElementById('chat-contacts-bar').style.display  = tab === 'team' ? 'flex' : 'none';
  document.getElementById('chat-tab-bot').style.borderBottomColor  = tab === 'bot'  ? 'var(--orange)' : 'transparent';
  document.getElementById('chat-tab-team').style.borderBottomColor = tab === 'team' ? 'var(--orange)' : 'transparent';
  document.getElementById('chat-tab-bot').style.color  = tab === 'bot'  ? 'var(--orange)' : 'var(--muted)';
  document.getElementById('chat-tab-team').style.color = tab === 'team' ? 'var(--orange)' : 'var(--muted)';
  if (tab === 'team') { loadTeamMembers(); loadTeamMessages(); }
  const inp = document.getElementById('chat-input');
  inp.placeholder = tab === 'bot' ? 'Posez une question à AfricaBot…' : (_chatRecipient ? `Message à ${_chatRecipient.name}…` : 'Message à l\'équipe…');
}

// ── Load & render contact pills
async function loadTeamMembers() {
  if (_teamMembers.length > 0) { renderContactsBar(); return; }
  const d = await api('team-members');
  if (!d.members) return;
  _teamMembers = d.members;
  renderContactsBar();
}

function renderContactsBar() {
  const list = document.getElementById('chat-contacts-list');
  const BG_COLORS = ['#F97316','#3B82F6','#10B981','#8B5CF6','#EF4444','#F59E0B','#06B6D4','#EC4899'];
  const colorFor  = id => BG_COLORS[id % BG_COLORS.length];
  const allActive = _chatRecipient === null;

  // "Tous" pill
  const allBtn = document.createElement('button');
  allBtn.className = 'contact-pill' + (allActive ? ' active' : '');
  allBtn.innerHTML = '<i class="fas fa-users" style="font-size:10px"></i>Tous';
  allBtn.addEventListener('click', () => selectRecipient(null));
  list.innerHTML = '';
  list.appendChild(allBtn);

  // Member pills — use addEventListener to avoid HTML-quoting issues
  _teamMembers.forEach(m => {
    const sel = _chatRecipient && _chatRecipient.id === m.id;
    const ini = m.name.split(' ').map(w => w[0]).join('').substring(0, 2).toUpperCase();
    const col = colorFor(m.id);
    const btn = document.createElement('button');
    btn.className = 'contact-pill' + (sel ? ' active' : '');
    btn.innerHTML =
      `<span class="cp-av" style="background:${sel ? 'rgba(255,255,255,.25)' : col};color:#fff">${ini}</span>` +
      m.name.split(' ')[0];
    btn.addEventListener('click', () => selectRecipient(m.id, m.name));
    list.appendChild(btn);
  });
}

function selectRecipient(id, name = null) {
  _chatRecipient = id ? { id, name } : null;
  _teamMessages  = [];
  renderContactsBar();
  document.getElementById('chat-input').placeholder = id ? `Message à ${name}…` : "Message à l'équipe…";
  loadTeamMessages();
}

function startChatPolling() {
  if (_chatPolling) return;
  _chatPolling = setInterval(() => {
    if (_chatTab === 'team') loadTeamMessages(true);
  }, 8000);
}
function stopChatPolling() {
  if (_chatPolling) { clearInterval(_chatPolling); _chatPolling = null; }
}

// ── Render helpers
function fileMimeIcon(mime) {
  if (!mime) return 'fa-file';
  if (mime.startsWith('image/')) return 'fa-file-image';
  if (mime === 'application/pdf') return 'fa-file-pdf';
  if (mime.includes('word')) return 'fa-file-word';
  if (mime.includes('excel') || mime.includes('spreadsheet')) return 'fa-file-excel';
  if (mime.includes('zip') || mime.includes('rar') || mime.includes('7z')) return 'fa-file-archive';
  return 'fa-file-alt';
}

function renderMsg(m, container) {
  const wrap = document.createElement('div');
  wrap.style.cssText = `display:flex;flex-direction:column;align-items:${m.mine ? 'flex-end' : 'flex-start'}`;

  if (!m.mine && m.from) {
    const s = document.createElement('div');
    s.className = 'chat-sender';
    s.textContent = m.from.name;
    wrap.appendChild(s);
  }

  const bubble = document.createElement('div');
  bubble.className = `chat-bubble ${m.mine ? 'mine' : (m.is_bot || !m.from ? 'bot' : 'other')}`;

  if (m.file_url) {
    const isImage = m.file_mime && m.file_mime.startsWith('image/');
    if (isImage) {
      bubble.innerHTML = `<a href="${m.file_url}" target="_blank"><img src="${m.file_url}" style="max-width:200px;max-height:180px;border-radius:8px;display:block"></a>`;
    } else {
      bubble.innerHTML = `<a class="chat-file-card" href="${m.file_url}" target="_blank" download="${m.file_name ?? 'fichier'}"><i class="fas ${fileMimeIcon(m.file_mime)}"></i><div><div style="font-size:12px;font-weight:600">${m.file_name ?? 'Fichier'}</div><div style="font-size:10px;opacity:.7">Télécharger</div></div></a>`;
    }
  } else {
    // Render **bold** markdown
    bubble.innerHTML = (m.content ?? '').replace(/\*\*([^*]+)\*\*/g, '<strong>$1</strong>');
  }

  wrap.appendChild(bubble);

  const time = document.createElement('div');
  time.className = 'chat-time';
  time.textContent = m.ago ?? '';
  wrap.appendChild(time);

  container.appendChild(wrap);
}

function scrollBottom(el) { el.scrollTop = el.scrollHeight; }

// ── Bot
let _botMessages = [];
async function loadBotHistory() {
  const d = await api('messages/bot');
  if (!d.messages) return;
  _botMessages = d.messages;
  const body = document.getElementById('chat-bot-body');
  body.innerHTML = '';
  if (_botMessages.length === 0) {
    body.innerHTML = `<div style="text-align:center;padding:20px;color:var(--muted);font-size:12px"><i class="fas fa-robot" style="font-size:36px;color:var(--orange);display:block;margin-bottom:10px;opacity:.6"></i><strong>AfricaERP Bot</strong><br>Posez-moi vos questions sur votre garage !<br><small>Essayez : "réparations en cours", "stock", "revenus"</small></div>`;
  } else {
    _botMessages.forEach(m => renderMsg(m, body));
    scrollBottom(body);
  }
}

async function sendBotMessage(text) {
  if (!text.trim()) return;
  const body = document.getElementById('chat-bot-body');
  // Render user msg immediately
  renderMsg({ mine: true, content: text, ago: new Date().toLocaleTimeString('fr-FR', {hour:'2-digit',minute:'2-digit'}) }, body);
  scrollBottom(body);

  // Loading indicator
  const loading = document.createElement('div');
  loading.style.cssText = 'align-self:flex-start;padding:8px 14px;background:#fff;border-radius:14px;border-bottom-left-radius:4px;box-shadow:0 1px 4px rgba(0,0,0,.08);font-size:13px;color:var(--muted)';
  loading.innerHTML = '<i class="fas fa-circle" style="font-size:6px;margin:0 2px;animation:pulse 1s infinite"></i><i class="fas fa-circle" style="font-size:6px;margin:0 2px;animation:pulse 1s .2s infinite"></i><i class="fas fa-circle" style="font-size:6px;margin:0 2px;animation:pulse 1s .4s infinite"></i>';
  body.appendChild(loading);
  scrollBottom(body);

  const r = await api('messages/bot', { method: 'POST', body: JSON.stringify({ message: text }) });
  loading.remove();
  if (r.reply) {
    renderMsg({ mine: false, is_bot: true, content: r.reply, ago: new Date().toLocaleTimeString('fr-FR', {hour:'2-digit',minute:'2-digit'}) }, body);
    scrollBottom(body);
  }
}

// ── Team messages
let _teamMessages = [];
async function loadTeamMessages(silent = false) {
  const url = _chatRecipient ? `messages?to_user_id=${_chatRecipient.id}` : 'messages';
  const d = await api(url);
  if (!d.messages) return;
  const body = document.getElementById('chat-team-body');
  const wasAtBottom = body.scrollHeight - body.scrollTop - body.clientHeight < 60;

  if (d.messages.length !== _teamMessages.length || !silent) {
    _teamMessages = d.messages;
    body.innerHTML = '';
    if (_teamMessages.length === 0) {
      body.innerHTML = `<div style="text-align:center;padding:32px;color:var(--muted);font-size:12px"><i class="fas fa-comments" style="font-size:36px;display:block;margin-bottom:10px;opacity:.4"></i>Aucun message d'équipe</div>`;
    } else {
      _teamMessages.forEach(m => renderMsg(m, body));
    }
    if (wasAtBottom || !silent) scrollBottom(body);

    // Update dot
    const unread = d.messages.filter(m => !m.mine && !m.read_at).length;
    document.getElementById('chat-dot').style.display = (unread > 0 && !_chatOpen) ? 'block' : 'none';
  }
}

async function sendTeamMessage(text) {
  if (!text.trim()) return;
  const payload = { content: text };
  if (_chatRecipient) payload.to_user_id = _chatRecipient.id;
  const r = await api('messages', { method: 'POST', body: JSON.stringify(payload) });
  if (r.msg) {
    const body = document.getElementById('chat-team-body');
    renderMsg(r.msg, body);
    scrollBottom(body);
  }
}

// ── Send (dispatches to bot or team tab)
function chatKeydown(e) {
  if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); chatSend(); }
}

async function chatSend() {
  const input = document.getElementById('chat-input');
  const text = input.value.trim();
  if (!text) return;
  input.value = '';
  input.style.height = 'auto';
  if (_chatTab === 'bot') {
    await sendBotMessage(text);
  } else {
    await sendTeamMessage(text);
  }
}

// ── File upload
async function chatUploadFile(input) {
  const file = input.files[0];
  if (!file) return;
  const form = new FormData();
  form.append('file', file);
  if (_chatRecipient) form.append('to_user_id', _chatRecipient.id);
  const res = await fetch('/api/messages/upload', {
    method: 'POST',
    headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
    body: form,
  });
  const r = await res.json();
  if (r.msg) {
    if (_chatTab === 'team') {
      const body = document.getElementById('chat-team-body');
      renderMsg(r.msg, body);
      scrollBottom(body);
    }
  } else {
    alert(r.message ?? 'Erreur upload');
  }
  input.value = '';
}

// ── Voice input (Web Speech API)
let _recognition = null;
let _voiceActive = false;

function toggleVoice() {
  if (!('webkitSpeechRecognition' in window) && !('SpeechRecognition' in window)) {
    alert('Votre navigateur ne supporte pas la reconnaissance vocale. Utilisez Chrome ou Edge.');
    return;
  }
  if (_voiceActive) {
    _recognition?.stop();
    return;
  }
  const SR = window.SpeechRecognition || window.webkitSpeechRecognition;
  _recognition = new SR();
  _recognition.lang = 'fr-FR';
  _recognition.continuous = false;
  _recognition.interimResults = false;

  _recognition.onstart = () => {
    _voiceActive = true;
    document.getElementById('btn-voice').classList.add('voice-active');
  };
  _recognition.onresult = (e) => {
    const transcript = e.results[0][0].transcript;
    document.getElementById('chat-input').value = transcript;
  };
  _recognition.onerror = () => { _voiceActive = false; document.getElementById('btn-voice').classList.remove('voice-active'); };
  _recognition.onend = () => {
    _voiceActive = false;
    document.getElementById('btn-voice').classList.remove('voice-active');
  };
  _recognition.start();
}

// Close panels on outside click
// Use composedPath() so DOM mutations during click handlers don't fool the check
document.addEventListener('click', (e) => {
  const path = e.composedPath ? e.composedPath() : [];

  const np = document.getElementById('notif-panel');
  const nb = document.getElementById('btn-notif');
  const inNotif = path.includes(np) || path.includes(nb) || np.contains(e.target) || nb.contains(e.target);
  if (_notifOpen && !inNotif) closeNotifPanel();

  const cp = document.getElementById('chat-panel');
  const cb = document.getElementById('btn-chat');
  const inChat = path.includes(cp) || path.includes(cb) || cp.contains(e.target) || cb.contains(e.target);
  if (_chatOpen && !inChat) closeChatPanel();
});
</script>
</body>
</html>
