@extends('admin.layouts.masterlayout')
  
@section('title', 'View Push Notification')
  
@section('content')
<style>
    .details-container { max-width: 1000px; margin: 0 auto; padding: 20px; }
    .header { background: #ffffff; border-radius: 20px; padding: 24px; border:1px solid #e2e8f0; display:flex; align-items:center; justify-content:space-between; gap:16px; margin-bottom:20px; }
    .header-left { display:flex; gap:16px; align-items:center; }
    .header-icon { width:56px; height:56px; border-radius:14px; background: linear-gradient(135deg,#00d4ff,#0099cc); color:#fff; display:flex; align-items:center; justify-content:center; font-size:22px; box-shadow:0 8px 25px rgba(0,212,255,0.3); }
    .header-title { margin:0; color:#1e293b; font-size:22px; font-weight:700; }
    .actions { display:flex; gap:10px; }
    .btn { display:inline-flex; align-items:center; gap:8px; padding:10px 16px; border-radius:10px; font-weight:600; border:2px solid transparent; text-decoration:none; transition:all .2s ease; }
    .btn-outline { background:transparent; color:#475569; border-color: #cbd5e1; }
    .btn-outline:hover { background: #f1f5f9; border-color: #94a3b8; }
    .btn-primary { background: linear-gradient(135deg,#00d4ff,#0099cc); color:#fff; box-shadow:0 8px 25px rgba(0,212,255,0.3); }
    .card { background: #ffffff; border-radius: 16px; padding: 24px; border:1px solid #e2e8f0; }
    .row { display:grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap:20px; }
    .field { display:flex; flex-direction:column; gap:6px; }
    .label { color:#64748b; font-size:12px; font-weight:700; letter-spacing:.4px; text-transform:uppercase; }
    .value { color:#334155; font-size:15px; }
    .thumb { width:180px; height:140px; object-fit:cover; border-radius:12px; border:2px solid #bfdbfe; }
    .description { white-space:pre-line; }
</style>
  
<div class="details-container">
    <div class="header">
        <div class="header-left">
            <div class="header-icon"><i class="fas fa-bell"></i></div>
            <div>
                <h2 class="header-title">Notification Details</h2>
                <div style="color:#64748b; font-size:13px;">Created on {{ $notification->created_at->format('M d, Y H:i') }}</div>
            </div>
        </div>
        <div class="actions">
            <a href="{{ route('push-notifications.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back</a>
            <a href="{{ route('push-notifications.edit', $notification) }}" class="btn btn-primary"><i class="fas fa-edit"></i> Edit</a>
        </div>
    </div>
  
    <div class="card">
        <div class="row">
            <div class="field">
                <div class="label">Audience</div>
                <div class="value">{{ ucfirst($notification->audience === 'user' ? 'customer' : $notification->audience) }}</div>
            </div>
            <div class="field">
                <div class="label">Title</div>
                <div class="value">{{ $notification->title }}</div>
            </div>
            <div class="field">
                <div class="label">Created By</div>
                <div class="value">{{ optional($notification->creator)->name ?? '—' }}</div>
            </div>
            <div class="field">
                <div class="label">Image</div>
                <div class="value">
                    @if($notification->image)
                        <img src="{{ asset('Notification_images/'.$notification->image) }}" class="thumb" alt="image">
                    @else
                        <span style="color:#94a3b8">None</span>
                    @endif
                </div>
            </div>
        </div>
        <div class="field" style="margin-top:20px;">
            <div class="label">Description</div>
            <div class="value description">{!! nl2br(e($notification->description)) !!}</div>
        </div>
    </div>
</div>
@endsection
