@extends('admin.layout')

@section('admin-title', 'Manajemen User')
@section('admin-kicker', 'Akun dan saldo poin')

@section('admin-content')
<div class="admin-stat-grid">
    <div class="admin-card admin-stat"><span>Total User</span><strong>{{ number_format($stats['total_users']) }}</strong></div>
    <div class="admin-card admin-stat"><span>Voter</span><strong>{{ number_format($stats['voters']) }}</strong></div>
    <div class="admin-card admin-stat"><span>Admin</span><strong>{{ number_format($stats['admins']) }}</strong></div>
    <div class="admin-card admin-stat"><span>Total Saldo Poin</span><strong>{{ number_format($stats['total_points']) }}</strong></div>
</div>

<div class="admin-card admin-card-pad">
    <h2 class="admin-section-title">Daftar User</h2>
    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>WhatsApp</th>
                    <th>Role</th>
                    <th>Poin</th>
                    <th>Bergabung</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td><strong>{{ $user->name ?? trim($user->first_name . ' ' . $user->last_name) ?: '-' }}</strong></td>
                        <td>{{ $user->username ? '@' . $user->username : '-' }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->whatsapp ?? '-' }}</td>
                        <td><span class="admin-badge {{ $user->role === 'admin' ? 'info' : 'success' }}">{{ $user->role }}</span></td>
                        <td><strong>{{ number_format($user->points ?? 0) }} PTS</strong></td>
                        <td>{{ $user->created_at->format('d/m/Y') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="admin-empty">Belum ada user.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
