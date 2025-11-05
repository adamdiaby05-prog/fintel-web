@extends('layouts.admin')

@section('title', 'Transactions')
@section('page-title', 'Liste des Transactions')

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
        text-align: center;
        border-left: 4px solid #667eea;
    }

    .stat-label {
        color: #666;
        font-size: 0.9rem;
        margin-bottom: 10px;
    }

    .stat-value {
        color: #333;
        font-size: 1.8rem;
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

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-label">Total</div>
        <div class="stat-value">{{ $stats['total'] }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Complétées</div>
        <div class="stat-value">{{ $stats['completed'] }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">En attente</div>
        <div class="stat-value">{{ $stats['pending'] }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Échouées</div>
        <div class="stat-value">{{ $stats['failed'] }}</div>
    </div>
</div>

<div class="card">
    <h3 style="font-size: 1.3rem; color: #333; margin-bottom: 20px; font-weight: 600;">
        Liste des Transactions
    </h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Utilisateur</th>
                <th>Type</th>
                <th>Montant</th>
                <th>Statut</th>
                <th>Réseau</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->id }}</td>
                    <td>{{ $transaction->user->first_name ?? '' }} {{ $transaction->user->last_name ?? '' }}</td>
                    <td>{{ ucfirst($transaction->transaction_type) }}</td>
                    <td>{{ number_format($transaction->amount, 0, ',', ' ') }} {{ $transaction->currency }}</td>
                    <td>
                        @if($transaction->status === 'completed')
                            <span class="badge badge-success">Complété</span>
                        @elseif($transaction->status === 'pending')
                            <span class="badge badge-warning">En attente</span>
                        @else
                            <span class="badge badge-danger">Échoué</span>
                        @endif
                    </td>
                    <td>{{ $transaction->network ?? '-' }}</td>
                    <td>{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="empty-state">Aucune transaction trouvée</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="pagination">
        {{ $transactions->links() }}
    </div>
</div>
@endsection

