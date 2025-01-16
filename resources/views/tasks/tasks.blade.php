<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gestion des Tâches</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-icons.min.css') }}" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4f46e5;
            --success-color: #059669;
            --warning-color: #ea580c;
            --danger-color: #dc2626;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        body {
            background-color: #f8f9fa;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        }

        .card {
            border-radius: 1rem;
            border: none;
            box-shadow: var(--shadow);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        .card-header {
            border-top-left-radius: 1rem !important;
            border-top-right-radius: 1rem !important;
            background: var(--primary-color);
            color: white;
        }

        .table th {
            font-weight: 600;
            background-color: #f8f9fa;
        }

        .badge {
            font-weight: 500;
            padding: 0.5em 1em;
            border-radius: 0.75rem;
        }

        .btn-action {
            transition: all 0.3s;
            border-radius: 0.75rem;
        }

        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow);
        }

        .bg-orange {
            background-color: #ff8c42 !important;
            color: white;
        }

        .form-control, .form-select {
            border-radius: 0.75rem;
            padding: 0.75rem 1rem;
        }

        .input-group-text {
            border-radius: 0.75rem 0 0 0.75rem;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .pagination .page-link {
            border-radius: 0.75rem;
            margin: 0 0.25rem;
        }

        .modal-content {
            border-radius: 1rem;
        }

        .modal-header {
            border-top-left-radius: 1rem;
            border-top-right-radius: 1rem;
            background: var(--primary-color);
            color: white;
        }

        .modal-footer .btn {
            border-radius: 0.75rem;
        }

        @media (max-width: 768px) {
            .card-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .btn-action {
                width: 100%;
                margin-top: 0.5rem;
            }

            .table th, .table td {
                white-space: nowrap;
            }
        }
    </style>
</head>

<body class="bg-light">
    <div class="container py-5">
        <!-- Filter Card -->
        <div class="card shadow mb-4">
            <div class="card-body">
                <form class="row g-3">
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                            <input type="text" class="form-control" placeholder="Rechercher une tâche..." name="search" value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" name="status">
                            <option value="">Tous les statuts</option>
                            <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>En cours</option>
                            <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Terminée</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-danger w-100">Filtrer</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tasks Card -->
        <div class="card shadow">
            <div class="card-header d-flex justify-content-between align-items-center p-3">
                <h1 class="h3 mb-0">Tâches</h1>
                <div>
                    <a href="{{ route('tasks.statistics') }}" class="btn btn-light me-2 btn-action">
                        <i class="bi bi-graph-up me-2"></i>Statistiques
                    </a>
                    <a href="{{ route('createTask') }}" class="btn btn-light btn-action">
                        <i class="bi bi-plus-circle me-2"></i>Créer une Nouvelle Tâche
                    </a>
                </div>
            </div>

            <div class="card-body">
                @if($tasks->isEmpty())
                    <div class="text-center py-5">
                        <i class="bi bi-inbox display-1 text-muted"></i>
                        <p class="h4 mt-3 text-muted">Aucune tâche trouvée</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Titre</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Statut</th>
                                    <th scope="col">Date de création</th>
                                    <th scope="col">Date de mise à jour</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tasks as $task)
                                    <tr>
                                        <td>{{ $task->id }}</td>
                                        <td class="fw-medium">{{ $task->title }}</td>
                                        <td>
                                            <span class="text-truncate d-inline-block" style="max-width: 300px;">
                                                {{ $task->description }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge {{ $task->is_completed ? 'bg-success' : 'bg-orange' }}">
                                                {{ $task->is_completed ? 'Terminée' : 'En cours' }}
                                            </span>
                                        </td>
                                        <td>{{ $task->created_at->format('d/m/Y H:i') }}</td>
                                        <td>{{ $task->updated_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('editTask', ['id' => $task->id]) }}"
                                                    class="btn btn-sm btn-outline-primary btn-action">
                                                    <i class="bi bi-pencil-square me-1"></i>Modifier
                                                </a>
                                                <form action="{{ route('deleteTask', ['id' => $task->id]) }}"
                                                    method="POST" class="d-inline delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-sm btn-outline-danger btn-action delete-button">
                                                        <i class="bi bi-trash me-1"></i>Supprimer
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $tasks->withQueryString()->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteConfirmModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmer la suppression</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    Êtes-vous sûr de vouloir supprimer cette tâche ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">Supprimer</button>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let formToSubmit = null;
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));

            // Handle delete button clicks
            document.querySelectorAll('.delete-form').forEach(form => {
                form.addEventListener('submit', function(event) {
                    event.preventDefault();
                    formToSubmit = form;
                    deleteModal.show();
                });
            });

            // Handle confirmation button click
            document.getElementById('confirmDelete').addEventListener('click', function() {
                if (formToSubmit) {
                    formToSubmit.submit();
                }
                deleteModal.hide();
            });
        });
    </script>
</body>
</html>
