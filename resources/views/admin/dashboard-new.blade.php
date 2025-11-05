@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<style>
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
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
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    }

    .stat-label {
        color: #666;
        font-size: 0.9rem;
        margin-bottom: 10px;
        font-weight: 500;
    }

    .stat-value {
        color: #333;
        font-size: 2.5rem;
        font-weight: 700;
    }

    .card {
        background: white;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        margin-bottom: 30px;
    }

    .card-title {
        font-size: 1.3rem;
        color: #333;
        margin-bottom: 20px;
        font-weight: 600;
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

    .empty-state {
        text-align: center;
        padding: 40px;
        color: #999;
    }
</style>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-label">📊 Total Utilisateurs</div>
        <div class="stat-value">{{ $totalUsers }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">✅ Utilisateurs Actifs</div>
        <div class="stat-value">{{ $activeUsers }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">✓ Utilisateurs Vérifiés</div>
        <div class="stat-value">{{ $verifiedUsers }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">💰 Total Transactions</div>
        <div class="stat-value">{{ $totalTransactions }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">💳 Solde Total</div>
        <div class="stat-value">{{ number_format($totalBalance, 0, ',', ' ') }}</div>
    </div>
</div>

<div class="stats-grid" style="grid-template-columns: 1fr 1fr;">
    <div class="card">
        <h3 class="card-title">👥 Utilisateurs Récents</h3>
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Téléphone</th>
                    <th>Statut</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentUsers as $user)
                    <tr>
                        <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                        <td>{{ $user->phone_number }}</td>
                        <td>
                            @if($user->is_verified)
                                <span class="badge badge-success">Vérifié</span>
                            @else
                                <span class="badge badge-warning">Non vérifié</span>
                            @endif
                        </td>
                        <td>{{ $user->created_at->format('d/m/Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="empty-state">Aucun utilisateur</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="card">
        <h3 class="card-title">💰 Transactions Récentes</h3>
        <table>
            <thead>
                <tr>
                    <th>Utilisateur</th>
                    <th>Type</th>
                    <th>Montant</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentTransactions as $transaction)
                    <tr>
                        <td>{{ $transaction->user->first_name ?? '' }} {{ $transaction->user->last_name ?? '' }}</td>
                        <td>{{ ucfirst($transaction->transaction_type) }}</td>
                        <td>{{ number_format($transaction->amount, 0, ',', ' ') }}</td>
                        <td>
                            @if($transaction->status === 'completed')
                                <span class="badge badge-success">Complété</span>
                            @elseif($transaction->status === 'pending')
                                <span class="badge badge-warning">En attente</span>
                            @else
                                <span class="badge badge-danger">Échoué</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="empty-state">Aucune transaction</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

