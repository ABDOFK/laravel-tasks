<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Créer une Tâche</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-icons.min.css') }}" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4f46e5;
            --success-color: #059669;
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
            background: var(--success-color);
            color: white;
        }

        .form-control:focus, .form-check-input:focus {
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
            border-color: var(--primary-color);
        }

        .form-control {
            padding: 0.75rem 1rem;
            border-radius: 0.75rem;
        }

        .form-label {
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: #495057;
        }

        .btn-submit {
            padding: 0.75rem 1.5rem;
            border-radius: 0.75rem;
            transition: all 0.3s ease;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow);
        }

        .btn-outline-secondary {
            border-radius: 0.75rem;
            transition: all 0.3s ease;
        }

        .btn-outline-secondary:hover {
            background-color: #f8f9fa;
            transform: translateY(-2px);
            box-shadow: var(--shadow);
        }

        .input-group-text {
            border-radius: 0.75rem 0 0 0.75rem;
            background-color: #e9ecef;
        }

        .alert {
            border-radius: 0.75rem;
        }

        .alert-success {
            background-color: #d1fae5;
            border-color: #a7f3d0;
            color: #065f46;
        }

        .alert-danger {
            background-color: #fee2e2;
            border-color: #fca5a5;
            color: #991b1b;
        }

        .invalid-feedback {
            font-size: 0.875rem;
            color: var(--danger-color);
        }

        @media (max-width: 768px) {
            .card-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .btn-submit, .btn-outline-secondary {
                width: 100%;
                margin-top: 0.5rem;
            }
        }
    </style>
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if(session('success'))
                    <div class="alert alert-success" role="alert">
                        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger" role="alert">
                        <i class="bi bi-exclamation-circle me-2"></i>Veuillez corriger les erreurs suivantes:
                        <ul class="mb-0 mt-2">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card shadow">
                    <div class="card-header p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <h1 class="h3 mb-0">Créer une Nouvelle Tâche</h1>
                            <a href="{{ route('tasks') }}" class="btn btn-light btn-sm">
                                <i class="bi bi-arrow-left me-1"></i>Retour
                            </a>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <form action="{{ route('formTask') }}" method="post">
                            @csrf
                            <div class="mb-4">
                                <label for="title" class="form-label">
                                    Titre <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-pencil"></i>
                                    </span>
                                    <input type="text"
                                           class="form-control @error('title') is-invalid @enderror"
                                           id="title"
                                           name="title"
                                           value="{{ old('title') }}"
                                           required
                                           minlength="3"
                                           maxlength="100"
                                           placeholder="Entrez le titre de la tâche">
                                    @error('title')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="description" class="form-label">
                                    Description <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-text-paragraph"></i>
                                    </span>
                                    <textarea class="form-control @error('description') is-invalid @enderror"
                                              id="description"
                                              name="description"
                                              rows="4"
                                              required
                                              minlength="10"
                                              maxlength="500"
                                              placeholder="Décrivez la tâche en détail">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label d-block">Statut</label>
                                <div class="form-check">
                                    <input type="checkbox"
                                           class="form-check-input"
                                           id="is_completed"
                                           name="is_completed"
                                           value="1"
                                           {{ old('is_completed') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_completed">
                                        Marquer comme terminée
                                    </label>
                                </div>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-success btn-submit">
                                    <i class="bi bi-plus-circle me-2"></i>Créer la Tâche
                                </button>
                                <button type="reset" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-counterclockwise me-2"></i>Réinitialiser
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
