@extends('layouts.admin')

@section('title', 'Utilisateurs')
@section('page-title', 'Liste des Utilisateurs')

@section('content')
<style>
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: white;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        transition: transform 0.2s ease;
        border-left: 4px solid #667eea;
        text-align: center;
    }

    .stat-label {
        color: #666;
        font-size: 0.9rem;
        margin-bottom: 10px;
    }

    .stat-value {
        color: #333;
        font-size: 2rem;
        font-weight: 700;
    }

    .card {
        background: white;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        text-align: left;
        padding: 15px;
        border-bottom: 1px solid #e0e0e0;
    }

    th {
        background: #f8f9fa;
        font-weight: 600;
        color: #333;
    }

    tr:hover {
        background: #f8f9fa;
    }

    .badge {
        display: inline-block;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .badge-success {
        background: #d4edda;
        color: #155724;
    }

    .badge-warning {
        background: #fff3cd;
        color: #856404;
    }

    .badge-danger {
        background: #f8d7da;
        color: #721c24;
    }

    .pagination {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-top: 20px;
    }

    .pagination a {
        padding: 8px 12px;
        background: #f8f9fa;
        color: #667eea;
        text-decoration: none;
        border-radius: 5px;
        font-weight: 600;
    }

    .pagination a:hover {
        background: #e0e0e0;
    }

    .pagination .active {
        background: #667eea;
        color: white;
    }

    .empty-state {
        text-align: center;
        padding: 40px;
        color: #999;
    }
</style>

<div class="stats-grid" style="display: none;"></div>

<div class="card">
    <h3 style="font-size: 1.3rem; color: #333; margin-bottom: 20px; font-weight: 600;">
        Liste des Utilisateurs ({{ $users->total() }})
    </h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Téléphone</th>
                <th>Email</th>
                <th>Statut</th>
                <th>Inscrit le</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                    <td>{{ $user->phone_number }}</td>
                    <td>{{ $user->email ?? '-' }}</td>
                    <td>
                        @if($user->is_verified)
                            <span class="badge badge-success">Vérifié</span>
                        @else
                            <span class="badge badge-warning">Non vérifié</span>
                        @endif
                        @if($user->is_active)
                            <span class="badge badge-success">Actif</span>
                        @else
                            <span class="badge badge-danger">Inactif</span>
                        @endif
                    </td>
                    <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="empty-state">Aucun utilisateur trouvé</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="pagination">
        {{ $users->links() }}
    </div>
</div>
@endsection

