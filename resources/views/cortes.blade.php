@extends('layouts.site')

@section('title', 'Cortes de Pelo | Thiago Barber')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/cortes.css') }}">
@endpush

@section('content')
    @include('partials.catalog-navbar')

    <main class="gallery-page">
        <section class="container intro">
            <p class="kicker">Catalogo de estilos</p>
            <h1>Cortes de Pelo</h1>
            <p>
                Esta vista esta dedicada solo a cortes. Puedes reemplazar cada imagen por tus fotos reales
                cuando las tengas listas y mantener el mismo orden del catalogo.
            </p>
            <div class="intro-actions">
                <button class="catalog-button" type="button" data-open-corte-modal>Agregar Nuevo Corte</button>
            </div>
        </section>

        @if (session('success'))
            <section class="container success-banner" role="status" aria-live="polite">
                {{ session('success') }}
            </section>
        @endif

        @if (session('error'))
            <section class="container error-banner" role="alert" aria-live="assertive">
                {{ session('error') }}
            </section>
        @endif

        <section class="container cuts-grid" aria-label="Galeria de cortes de pelo">
            @forelse ($cortes as $corte)
                <article class="cut-card">
                    <div class="card-actions" aria-label="Acciones de tarjeta">
                        <button
                            type="button"
                            class="card-icon-button"
                            data-open-edit-modal
                            data-corte-id="{{ $corte->id }}"
                            data-corte-title="{{ $corte->titulo }}"
                            data-corte-image="{{ asset($corte->imagen_path) }}"
                            aria-label="Editar tarjeta {{ $corte->titulo }}"
                            title="Editar tarjeta"
                        >
                            &#9998;
                        </button>
                        <button
                            type="button"
                            class="card-icon-button danger"
                            data-open-delete-modal
                            data-corte-id="{{ $corte->id }}"
                            data-corte-title="{{ $corte->titulo }}"
                            aria-label="Eliminar tarjeta {{ $corte->titulo }}"
                            title="Eliminar tarjeta"
                        >
                            &times;
                        </button>
                    </div>

                    <img src="{{ asset($corte->imagen_path) }}" alt="{{ $corte->titulo }}">
                    <h2>{{ $corte->titulo }}</h2>
                </article>
            @empty
                <article class="empty-state">
                    <h2>Aun no hay cortes registrados</h2>
                    <p>Agrega el primer corte usando el boton superior.</p>
                </article>
            @endforelse
        </section>
    </main>

    <div class="modal-overlay" data-corte-modal hidden>
        <div class="modal-panel" role="dialog" aria-modal="true" aria-labelledby="corte-modal-title">
            <div class="modal-header">
                <div>
                    <p class="kicker">Nuevo corte</p>
                    <h2 id="corte-modal-title">Agregar Nuevo Corte</h2>
                </div>
                <button type="button" class="modal-close" aria-label="Cerrar formulario" data-close-corte-modal>&times;</button>
            </div>

            <form class="corte-form" action="{{ route('cortes.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="submission_token" value="{{ $submissionToken }}">

                <label>
                    <span>Titulo</span>
                    <input type="text" name="titulo" value="{{ old('titulo') }}" placeholder="Ej: Mid Fade" required>
                    @error('titulo', 'storeCorte')
                        <small class="field-error">{{ $message }}</small>
                    @enderror
                </label>

                <label>
                    <span>Imagen</span>
                    <input type="file" name="imagen" accept="image/*" data-image-input required>
                    @error('imagen', 'storeCorte')
                        <small class="field-error">{{ $message }}</small>
                    @enderror
                </label>

                <div class="image-preview" data-image-preview>
                    <span>Vista previa de la imagen</span>
                    <img src="{{ asset('images/placeholder-card.svg') }}" alt="Vista previa del nuevo corte">
                </div>

                <div class="form-actions">
                    <button type="button" class="ghost-button" data-close-corte-modal>Cancelar</button>
                    <button type="submit" class="catalog-button">Guardar corte</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal-overlay" data-edit-modal hidden>
        <div class="modal-panel" role="dialog" aria-modal="true" aria-labelledby="edit-corte-modal-title">
            <div class="modal-header">
                <div>
                    <p class="kicker">Editar corte</p>
                    <h2 id="edit-corte-modal-title">Editar Tarjeta</h2>
                </div>
                <button type="button" class="modal-close" aria-label="Cerrar edicion" data-close-edit-modal>&times;</button>
            </div>

            <form class="corte-form" data-edit-form method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="corte_id" value="{{ old('corte_id') }}" data-edit-corte-id>

                <label>
                    <span>Titulo</span>
                    <input type="text" name="titulo" value="{{ old('titulo') }}" placeholder="Ej: Mid Fade" required data-edit-title>
                    @error('titulo', 'updateCorte')
                        <small class="field-error">{{ $message }}</small>
                    @enderror
                </label>

                <label>
                    <span>Imagen (opcional)</span>
                    <input type="file" name="imagen" accept="image/*" data-edit-image-input>
                    @error('imagen', 'updateCorte')
                        <small class="field-error">{{ $message }}</small>
                    @enderror
                </label>

                <div class="image-preview" data-edit-image-preview>
                    <span>Vista previa de la imagen</span>
                    <img src="{{ asset('images/placeholder-card.svg') }}" alt="Vista previa de la edicion">
                </div>

                <div class="form-actions">
                    <button type="button" class="ghost-button" data-close-edit-modal>Cancelar</button>
                    <button type="submit" class="catalog-button" data-edit-submit>Guardar cambios</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal-overlay" data-delete-modal hidden>
        <div class="modal-panel modal-panel-small" role="dialog" aria-modal="true" aria-labelledby="delete-corte-modal-title">
            <div class="modal-header">
                <div>
                    <p class="kicker">Eliminar corte</p>
                    <h2 id="delete-corte-modal-title">Confirmar eliminacion</h2>
                </div>
                <button type="button" class="modal-close" aria-label="Cerrar eliminacion" data-close-delete-modal>&times;</button>
            </div>

            <p class="delete-copy">Vas a eliminar la tarjeta <strong data-delete-title></strong>. Esta accion no se puede deshacer.</p>

            <form data-delete-form method="POST">
                @csrf
                @method('DELETE')
                <div class="form-actions">
                    <button type="button" class="ghost-button" data-close-delete-modal>Cancelar</button>
                    <button type="submit" class="danger-button">Eliminar tarjeta</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.querySelector('[data-corte-modal]');
            const openButton = document.querySelector('[data-open-corte-modal]');
            const closeButtons = document.querySelectorAll('[data-close-corte-modal]');
            const imageInput = document.querySelector('[data-image-input]');
            const previewImage = document.querySelector('[data-image-preview] img');
            const corteForm = document.querySelector('.corte-form');
            const submitButton = corteForm?.querySelector('button[type="submit"]');

            const editModal = document.querySelector('[data-edit-modal]');
            const openEditButtons = document.querySelectorAll('[data-open-edit-modal]');
            const closeEditButtons = document.querySelectorAll('[data-close-edit-modal]');
            const editForm = document.querySelector('[data-edit-form]');
            const editTitleInput = document.querySelector('[data-edit-title]');
            const editImageInput = document.querySelector('[data-edit-image-input]');
            const editPreviewImage = document.querySelector('[data-edit-image-preview] img');
            const editCorteIdInput = document.querySelector('[data-edit-corte-id]');
            const editSubmitButton = document.querySelector('[data-edit-submit]');

            const deleteModal = document.querySelector('[data-delete-modal]');
            const openDeleteButtons = document.querySelectorAll('[data-open-delete-modal]');
            const closeDeleteButtons = document.querySelectorAll('[data-close-delete-modal]');
            const deleteForm = document.querySelector('[data-delete-form]');
            const deleteTitle = document.querySelector('[data-delete-title]');
            const deleteSubmitButton = deleteForm?.querySelector('button[type="submit"]');

            const routeTemplates = {
                update: '{{ route('cortes.update', ['corte' => '__ID__']) }}',
                destroy: '{{ route('cortes.destroy', ['corte' => '__ID__']) }}',
            };

            const openModal = () => {
                modal.hidden = false;
                document.body.classList.add('modal-open');
            };

            const closeModal = () => {
                modal.hidden = true;
                document.body.classList.remove('modal-open');
            };

            const openEditModal = () => {
                editModal.hidden = false;
                document.body.classList.add('modal-open');
            };

            const closeEditModal = () => {
                editModal.hidden = true;
                if (modal.hidden && deleteModal.hidden) {
                    document.body.classList.remove('modal-open');
                }
            };

            const openDeleteModal = () => {
                deleteModal.hidden = false;
                document.body.classList.add('modal-open');
            };

            const closeDeleteModal = () => {
                deleteModal.hidden = true;
                if (modal.hidden && editModal.hidden) {
                    document.body.classList.remove('modal-open');
                }
            };

            if (openButton) {
                openButton.addEventListener('click', openModal);
            }

            openEditButtons.forEach((button) => {
                button.addEventListener('click', () => {
                    const corteId = button.dataset.corteId;
                    const corteTitle = button.dataset.corteTitle;
                    const corteImage = button.dataset.corteImage;

                    if (!corteId || !editForm || !editTitleInput || !editPreviewImage || !editCorteIdInput) {
                        return;
                    }

                    editForm.action = routeTemplates.update.replace('__ID__', corteId);
                    editTitleInput.value = corteTitle || '';
                    editPreviewImage.src = corteImage || '{{ asset('images/placeholder-card.svg') }}';
                    editCorteIdInput.value = corteId;
                    openEditModal();
                });
            });

            openDeleteButtons.forEach((button) => {
                button.addEventListener('click', () => {
                    const corteId = button.dataset.corteId;
                    const corteTitle = button.dataset.corteTitle;

                    if (!corteId || !deleteForm || !deleteTitle) {
                        return;
                    }

                    deleteForm.action = routeTemplates.destroy.replace('__ID__', corteId);
                    deleteTitle.textContent = corteTitle || 'seleccionada';
                    openDeleteModal();
                });
            });

            closeButtons.forEach((button) => button.addEventListener('click', closeModal));
            closeEditButtons.forEach((button) => button.addEventListener('click', closeEditModal));
            closeDeleteButtons.forEach((button) => button.addEventListener('click', closeDeleteModal));

            modal.addEventListener('click', (event) => {
                if (event.target === modal) {
                    closeModal();
                }
            });

            editModal.addEventListener('click', (event) => {
                if (event.target === editModal) {
                    closeEditModal();
                }
            });

            deleteModal.addEventListener('click', (event) => {
                if (event.target === deleteModal) {
                    closeDeleteModal();
                }
            });

            imageInput?.addEventListener('change', (event) => {
                const [file] = event.target.files || [];

                if (!file) {
                    previewImage.src = '{{ asset('images/placeholder-card.svg') }}';
                    return;
                }

                const reader = new FileReader();
                reader.onload = (loadEvent) => {
                    previewImage.src = loadEvent.target.result;
                };
                reader.readAsDataURL(file);
            });

            editImageInput?.addEventListener('change', (event) => {
                const [file] = event.target.files || [];

                if (!file) {
                    return;
                }

                const reader = new FileReader();
                reader.onload = (loadEvent) => {
                    editPreviewImage.src = loadEvent.target.result;
                };
                reader.readAsDataURL(file);
            });

            corteForm?.addEventListener('submit', () => {
                if (!submitButton || submitButton.disabled) {
                    return;
                }

                submitButton.disabled = true;
                submitButton.textContent = 'Guardando...';
            });

            editForm?.addEventListener('submit', () => {
                if (!editSubmitButton || editSubmitButton.disabled) {
                    return;
                }

                editSubmitButton.disabled = true;
                editSubmitButton.textContent = 'Guardando...';
            });

            deleteForm?.addEventListener('submit', () => {
                if (!deleteSubmitButton || deleteSubmitButton.disabled) {
                    return;
                }

                deleteSubmitButton.disabled = true;
                deleteSubmitButton.textContent = 'Eliminando...';
            });

            @if ($errors->storeCorte->any())
                openModal();
            @endif

            @if ($errors->updateCorte->any())
                const oldCorteId = '{{ old('corte_id') }}';
                const oldCorteButton = document.querySelector(`[data-open-edit-modal][data-corte-id="${oldCorteId}"]`);

                if (oldCorteButton) {
                    oldCorteButton.click();
                }
            @endif
        });
    </script>
@endpush
