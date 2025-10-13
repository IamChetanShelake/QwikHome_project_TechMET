@extends('admin.layouts.masterlayout')

@section('title', 'Push Notifications')

@section('content')
    <style>
        .modern-index-container { max-width: 1400px; margin: 0 auto; padding: 20px; }
        .index-header-section { background: rgba(255,255,255,0.05); backdrop-filter: blur(10px); border-radius: 20px; padding: 30px; border: 1px solid rgba(255,255,255,0.1); display:flex; justify-content:space-between; align-items:center; gap:20px; margin-bottom:20px; }
        .header-content { display:flex; align-items:center; gap:20px; }
        .header-icon-wrapper { width:60px; height:60px; background:linear-gradient(135deg,#00d4ff,#0099cc); border-radius:15px; display:flex; align-items:center; justify-content:center; font-size:24px; color:#fff; box-shadow:0 8px 25px rgba(0,212,255,0.3); }
        .header-title { font-size:28px; font-weight:700; color:#fff; margin:0; }
        .header-subtitle { font-size:14px; color:rgba(255,255,255,0.8); margin:5px 0 0 0; }
        .filters-section { background: rgba(255,255,255,0.08); backdrop-filter: blur(15px); border-radius: 15px; padding: 25px; border: 1px solid rgba(255,255,255,0.1); margin-bottom: 20px; }
        .filters-form { display:flex; gap:20px; align-items:end; flex-wrap:wrap; }
        .filter-group { display:flex; flex-direction:column; gap:8px; min-width:220px; }
        .filter-label { display:flex; align-items:center; gap:8px; font-size:14px; font-weight:600; color:#fff; }
        .modern-filter-input, .modern-filter-select { padding:12px 16px; background:rgba(255,255,255,0.05); border:2px solid rgba(255,255,255,0.1); border-radius:10px; color:#fff; font-size:14px; transition:all .3s ease; }
        .modern-filter-input:focus, .modern-filter-select:focus { outline:none; border-color:#00d4ff; background:rgba(255,255,255,0.08); box-shadow:0 0 15px rgba(0,212,255,0.2); }
        .filter-actions { display:flex; gap:10px; align-items:end; }
        .modern-btn { display:inline-flex; align-items:center; gap:8px; padding:12px 20px; border:none; border-radius:10px; font-size:14px; font-weight:600; text-decoration:none; cursor:pointer; transition:all .3s ease; }
        .modern-btn-primary { background:linear-gradient(135deg,#00d4ff,#0099cc); color:#fff; box-shadow:0 4px 15px rgba(0,212,255,0.3); }
        .modern-btn-primary:hover { transform: translateY(-2px); box-shadow:0 8px 25px rgba(0,212,255,0.4); color:#fff; }
        .modern-btn-outline { background:transparent; color:rgba(255,255,255,0.7); border:2px solid rgba(255,255,255,0.2); }
        .modern-btn-outline:hover { background: rgba(255,255,255,0.05); color:#fff; border-color: rgba(255,255,255,0.3); }
        .table-section { background: rgba(255,255,255,0.08); backdrop-filter: blur(15px); border-radius: 15px; border:1px solid rgba(255,255,255,0.1); overflow:hidden; }
        .table-header { padding:25px; border-bottom:1px solid rgba(255,255,255,0.1); display:flex; justify-content:space-between; align-items:center; }
        .table-title { display:flex; align-items:center; gap:10px; font-size:18px; font-weight:600; color:#fff; margin:0; }
        .modern-table-container { overflow-x:auto; }
        .modern-table { width:100%; border-collapse: collapse; }
        .modern-table th { background: rgba(0,212,255,0.1); padding:15px; text-align:left; font-weight:600; color:#00d4ff; border-bottom: 2px solid rgba(0,212,255,0.2); font-size:14px; }
        .modern-table td { padding:15px; border-bottom:1px solid rgba(255,255,255,0.05); color:#fff; vertical-align:middle; }
        .action-buttons { display:flex; gap:8px; }
        .action-btn { width:35px; height:35px; border-radius:8px; border:none; display:flex; align-items:center; justify-content:center; cursor:pointer; transition:all .3s ease; font-size:14px; }
        .action-view { background: rgba(0,212,255,0.2); color:#00d4ff; text-decoration:none; }
        .action-edit { background: rgba(59,130,246,0.2); color:#3b82f6; text-decoration:none; }
        .action-delete { background: rgba(239,68,68,0.2); color:#ef4444; }
        .thumb { width:40px; height:40px; border-radius:8px; object-fit:cover; border:2px solid rgba(0,212,255,0.3); }
    </style>

    <div class="modern-index-container">
        <div class="index-header-section">
            <div class="header-content">
                <div class="header-icon-wrapper"><i class="fas fa-bell"></i></div>
                <div class="header-text">
                    <h1 class="header-title">Push Notifications</h1>
                    <p class="header-subtitle">Create and manage broadcast notifications</p>
                </div>
            </div>
            <div class="header-actions">
                <a href="{{ route('push-notifications.create') }}" class="modern-btn modern-btn-primary">
                    <i class="fas fa-plus"></i> Create Notification
                </a>
            </div>
        </div>

        <div class="filters-section">
            <form method="GET" class="filters-form" id="filtersForm">
                <div class="filter-group">
                    <label class="filter-label"><i class="fas fa-search"></i> Search</label>
                    <input type="text" name="search" value="{{ $search }}" placeholder="Search title or description..." class="modern-filter-input">
                </div>
                <div class="filter-group">
                    <label class="filter-label"><i class="fas fa-users"></i> Audience</label>
                    <select name="audience" class="modern-filter-select">
                        <option value="">All</option>
                        <option value="all" {{ $audience==='all' ? 'selected' : '' }}>All Users</option>
                        <option value="vendor" {{ $audience==='vendor' ? 'selected' : '' }}>Vendors</option>
                        <option value="serviceprovider" {{ $audience==='serviceprovider' ? 'selected' : '' }}>Service Providers</option>
                        <option value="user" {{ $audience==='user' ? 'selected' : '' }}>Customers</option>
                    </select>
                </div>
                <div class="filter-actions">
                    <button type="submit" class="modern-btn modern-btn-outline"><i class="fas fa-filter"></i> Filter</button>
                    <a href="{{ route('push-notifications.index') }}" class="modern-btn modern-btn-outline"><i class="fas fa-times"></i> Clear</a>
                </div>
            </form>
        </div>

        <div class="table-section">
            <div class="table-header">
                <h3 class="table-title"><i class="fas fa-list"></i> Notifications List</h3>
                <div class="table-info"><span class="record-count">{{ $notifications->total() }} found</span></div>
            </div>

            <div class="modern-table-container">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th><i class="fas fa-hashtag"></i> ID</th>
                            <th><i class="fas fa-users"></i> Audience</th>
                            <th><i class="fas fa-heading"></i> Title</th>
                            <th><i class="fas fa-image"></i> Image</th>
                            <th><i class="fas fa-user"></i> Created By</th>
                            <th><i class="fas fa-calendar"></i> Created</th>
                            <th><i class="fas fa-cogs"></i> Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($notifications as $n)
                            <tr class="table-row">
                                <td>{{ $n->id }}</td>
                                <td>{{ ucfirst($n->audience === 'user' ? 'customer' : $n->audience) }}</td>
                                <td>{{ $n->title }}</td>
                                <td>
                                    @if($n->image)
                                        <img src="{{ asset('Notification_images/'.$n->image) }}" class="thumb" alt="img">
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>{{ optional($n->creator)->name ?? '—' }}</td>
                                <td>
                                    <span class="date-text">{{ $n->created_at->format('M d, Y') }}</span>
                                    <span class="time-text">{{ $n->created_at->format('H:i') }}</span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('push-notifications.show', $n) }}" class="action-btn action-view" title="View"><i class="fas fa-eye"></i></a>
                                        <a href="{{ route('push-notifications.edit', $n) }}" class="action-btn action-edit" title="Edit"><i class="fas fa-edit"></i></a>
                                        <form method="POST" action="{{ route('push-notifications.destroy', $n) }}" onsubmit="return confirm('Delete this notification?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="action-btn action-delete" title="Delete"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-center p-4" style="color:rgba(255,255,255,0.7)">No notifications found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($notifications->hasPages())
                <div class="pagination-section p-3">{{ $notifications->appends(request()->query())->links() }}</div>
            @endif
        </div>
    </div>
@endsection
