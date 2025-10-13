@extends('admin.layouts.masterlayout')

@section('title', 'Create Push Notification')

@section('content')
<style>
    .modern-form-container { max-width: 1100px; margin: 0 auto; padding:20px; }
    .form-header-section { background: rgba(255,255,255,0.05); backdrop-filter: blur(10px); border-radius: 20px 20px 0 0; padding: 30px; border: 1px solid rgba(255,255,255,0.1); display:flex; align-items:center; gap:20px; justify-content:space-between; }
    .header-content { display:flex; align-items:center; gap:20px; }
    .header-icon-wrapper { width:60px; height:60px; background:linear-gradient(135deg,#00d4ff,#0099cc); border-radius:15px; display:flex; align-items:center; justify-content:center; font-size:24px; color:#fff; box-shadow:0 8px 25px rgba(0,212,255,0.3); }
    .header-title { font-size:24px; font-weight:700; color:#fff; margin:0; }
    .modern-form-card { background: rgba(255,255,255,0.08); backdrop-filter: blur(15px); border-radius: 0 0 20px 20px; padding: 30px; border: 1px solid rgba(255,255,255,0.1); }
    .form-grid { display:grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 24px; margin-bottom: 20px; }
    .form-group-modern { position:relative; }
    .form-group-modern label { display:flex; align-items:center; gap:8px; font-weight:600; color:#fff; margin-bottom:8px; }
    .modern-input, .modern-select, .modern-textarea { width:100%; padding: 14px 16px; background: rgba(255,255,255,0.05); border:2px solid rgba(255,255,255,0.1); border-radius:12px; color:#fff; font-size:14px; transition: all .3s ease; }
    .modern-input:focus, .modern-select:focus, .modern-textarea:focus { outline:none; border-color:#00d4ff; background: rgba(255,255,255,0.08); box-shadow:0 0 20px rgba(0,212,255,0.2); transform: translateY(-2px); }
    .modern-textarea { min-height:140px; resize:vertical; }
    .form-actions { display:flex; gap:12px; justify-content:flex-end; margin-top:10px; }
    .modern-btn { display:inline-flex; align-items:center; gap:8px; padding:12px 22px; border-radius:12px; font-size:14px; font-weight:600; transition: all .3s ease; border:none; text-decoration:none; }
    .modern-btn-primary { background: linear-gradient(135deg, #00d4ff, #0099cc); color:#fff; box-shadow: 0 8px 25px rgba(0,212,255,0.3); }
    .modern-btn-primary:hover { transform: translateY(-2px); box-shadow:0 12px 35px rgba(0,212,255,0.4); }
    .modern-btn-outline { background: transparent; color:#fff; border:2px solid rgba(255,255,255,0.2); }
    .modern-btn-outline:hover { background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.3); }
    .error-text { color:#ff4757; font-size:12px; margin-top:6px; }
    .hint { color: rgba(255,255,255,0.7); font-size:12px; margin-top:6px; }
</style>

<div class="modern-form-container">
    <div class="form-header-section">
        <div class="header-content">
            <div class="header-icon-wrapper"><i class="fas fa-bell"></i></div>
            <div>
                <h1 class="header-title">Create Push Notification</h1>
                <div class="hint">Broadcast an update or offer to selected users</div>
            </div>
        </div>
        <div>
            <a href="{{ route('push-notifications.index') }}" class="modern-btn modern-btn-outline"><i class="fas fa-arrow-left"></i> Back</a>
        </div>
    </div>

    <div class="modern-form-card">
        <form action="{{ route('push-notifications.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-grid">
                <div class="form-group-modern">
                    <label><i class="fas fa-users"></i> Audience</label>
                    <select name="audience" class="modern-select" required>
                        <option value="">Select audience</option>
                        <option value="all" {{ old('audience')==='all' ? 'selected' : '' }}>All Users</option>
                        <option value="vendor" {{ old('audience')==='vendor' ? 'selected' : '' }}>Vendors</option>
                        <option value="serviceprovider" {{ old('audience')==='serviceprovider' ? 'selected' : '' }}>Service Providers</option>
                        <option value="user" {{ old('audience')==='user' ? 'selected' : '' }}>Customers</option>
                    </select>
                    @error('audience')<div class="error-text">{{ $message }}</div>@enderror
                </div>

                <div class="form-group-modern">
                    <label><i class="fas fa-heading"></i> Offer Title</label>
                    <input type="text" name="title" value="{{ old('title') }}" class="modern-input" placeholder="Enter offer title" required>
                    @error('title')<div class="error-text">{{ $message }}</div>@enderror
                </div>

                <div class="form-group-modern full-width" style="grid-column:1 / -1;">
                    <label><i class="fas fa-align-left"></i> Description</label>
                    <textarea name="description" class="modern-textarea" placeholder="Write description..." required>{{ old('description') }}</textarea>
                    @error('description')<div class="error-text">{{ $message }}</div>@enderror
                </div>

                <div class="form-group-modern">
                    <label><i class="fas fa-image"></i> Optional Image</label>
                    <input type="file" name="image" class="modern-input" accept="image/*">
                    <div class="hint">PNG, JPG up to 4MB</div>
                    @error('image')<div class="error-text">{{ $message }}</div>@enderror
                </div>

                <div class="form-group-modern">
                    <label><i class="fas fa-paper-plane"></i> Send Now</label>
                    <div style="display:flex; align-items:center; gap:12px;">
                        <input type="checkbox" name="send_now" value="1" id="send_now">
                        <label for="send_now" style="margin:0; color:rgba(255,255,255,0.85);">Dispatch immediately to selected audience</label>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('push-notifications.index') }}" class="modern-btn modern-btn-outline"><i class="fas fa-times"></i> Cancel</a>
                <button type="submit" class="modern-btn modern-btn-primary"><i class="fas fa-paper-plane"></i> Create Notification</button>
            </div>
        </form>
    </div>
</div>
@endsection
