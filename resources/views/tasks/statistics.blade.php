<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Statistiques des Tâches</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-icons.min.css') }}" rel="stylesheet">
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            --success-gradient: linear-gradient(135deg, #059669 0%, #16a34a 100%);
            --warning-gradient: linear-gradient(135deg, #ea580c 0%, #d97706 100%);
        }

        body {
            background-color: #f1f5f9;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        }

        .card {
            border: none;
            border-radius: 1.25rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        .header-card {
            background: var(--primary-gradient);
        }

        .stats-value {
            font-size: 3rem;
            font-weight: 700;
            line-height: 1.2;
            margin: 1rem 0;
        }

        .stats-label {
            font-weight: 600;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .progress {
            height: 1.5rem;
            border-radius: 1rem;
            background-color: #e2e8f0;
            overflow: hidden;
        }

        .progress-bar {
            background: var(--success-gradient);
            transition: width 1.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-light {
            background: rgba(255, 255, 255, 0.9);
            border: none;
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            border-radius: 0.75rem;
            transition: all 0.3s ease;
        }

        .btn-light:hover {
            background: white;
            transform: translateY(-2px);
        }

        .stat-card-total {
            background: var(--primary-gradient);
            color: white;
        }

        .stat-card-total .stats-label,
        .stat-card-total .small-stats {
            color: rgba(255, 255, 255, 0.8);
        }

        .stat-card-total .stats-value {
            color: white;
        }

        .stat-card-completed {
            background: var(--success-gradient);
            color: white;
        }

        .stat-card-completed .stats-label,
        .stat-card-completed .small-stats {
            color: rgba(255, 255, 255, 0.8);
        }

        .stat-card-completed .stats-value {
            color: white;
        }

        .stat-card-pending {
            background: var(--warning-gradient);
            color: white;
        }

        .stat-card-pending .stats-label,
        .stat-card-pending .small-stats {
            color: rgba(255, 255, 255, 0.8);
        }

        .stat-card-pending .stats-value {
            color: white;
        }

        .completion-badge {
            background: var(--primary-gradient);
            padding: 0.75rem 1.25rem;
            font-weight: 600;
            font-size: 1.125rem;
            border-radius: 1rem;
        }

        .small-stats {
            font-size: 0.875rem;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="card header-card shadow-lg mb-5">
            <div class="card-body p-5">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="display-6 text-white mb-2">Statistiques des Tâches</h1>
                        <p class="text-white-50 mb-0 lead">Vue d'ensemble de la progression des tâches</p>
                    </div>
                    <a href="{{ route('tasks') }}" class="btn btn-light">
                        <i class="bi bi-arrow-left me-2"></i>Retour aux Tâches
                    </a>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-md-6 col-lg-4">
                <div class="card stat-card-total h-100">
                    <div class="card-body p-4">
                        <p class="stats-label mb-2">Total des Tâches</p>
                        <h2 class="stats-value mb-0">{{ $stats['total'] }}</h2>
                        <div class="small-stats">
                            <i class="bi bi-info-circle me-2"></i>Nombre total de tâches créées
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="card stat-card-completed h-100">
                    <div class="card-body p-4">
                        <p class="stats-label mb-2">Tâches Terminées</p>
                        <h2 class="stats-value mb-0">{{ $stats['completed'] }}</h2>
                        <div class="small-stats">
                            <i class="bi bi-graph-up me-2"></i>
                            {{ $stats['total'] > 0 ? number_format(($stats['completed'] / $stats['total']) * 100, 1) : 0 }}% du total
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="card stat-card-pending h-100">
                    <div class="card-body p-4">
                        <p class="stats-label mb-2">Tâches En Cours</p>
                        <h2 class="stats-value mb-0">{{ $stats['pending'] }}</h2>
                        <div class="small-stats">
                            <i class="bi bi-clock me-2"></i>
                            {{ $stats['total'] > 0 ? number_format(($stats['pending'] / $stats['total']) * 100, 1) : 0 }}% du total
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow">
            <div class="card-body p-5">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h3 class="mb-1">Taux de Réalisation des Tâches</h3>
                        <p class="text-muted mb-0">Progression globale du projet</p>
                    </div>
                    @php
                        $completionRate = $stats['total'] > 0 ? ($stats['completed'] / $stats['total']) * 100 : 0;
                    @endphp
                    <span class="badge completion-badge">{{ number_format($completionRate, 1) }}%</span>
                </div>

                <div class="progress">
                    <div class="progress-bar" role="progressbar"
                        style="width: {{ $completionRate }}%"
                        aria-valuenow="{{ $completionRate }}"
                        aria-valuemin="0"
                        aria-valuemax="100">
                        {{ number_format($completionRate, 1) }}%
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-3">
                    <small class="text-muted">0 tâches</small>
                    <small class="text-muted">{{ $stats['total'] }} tâches</small>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
