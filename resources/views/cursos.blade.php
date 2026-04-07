@extends('layouts.site')

@section('title', 'Cursos | Thiago Barber')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/cursos.css') }}">
@endpush

@section('content')
    @include('partials.catalog-navbar')

    <main class="courses-page">
        <section class="container intro">
            <p class="kicker">Formacion profesional</p>
            <h1>Cursos Disponibles</h1>
            <p>
                Descubre todos los cursos de barberia disponibles para potenciar tu tecnica y avanzar al siguiente nivel.
            </p>

            @if ($administradores)
                <div class="intro-actions">
                    <button class="catalog-button" type="button" data-open-curso-modal>Agregar Nuevo Curso</button>
                </div>
            @endif
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

        <section class="container courses-grid" aria-label="Listado de cursos disponibles">
            @forelse ($cursos as $curso)
                <article class="course-card">
                    @if ($administradores)
                        <div class="card-actions" aria-label="Acciones de tarjeta">
                            <button
                                type="button"
                                class="card-icon-button"
                                data-open-edit-modal
                                data-curso-id="{{ $curso->id }}"
                                data-curso-titulo="{{ $curso->titulo }}"
                                data-curso-descripcion="{{ $curso->descripcion }}"
                                data-curso-precio="{{ (int) $curso->precio }}"
                                data-curso-activo="{{ $curso->is_active ? '1' : '0' }}"
                                data-curso-image="{{ asset($curso->imagen_path ?: 'images/placeholder-card.svg') }}"
                                aria-label="Editar tarjeta {{ $curso->titulo }}"
                                title="Editar tarjeta"
                            >
                                &#9998;
                            </button>
                            <button
                                type="button"
                                class="card-icon-button danger"
                                data-open-delete-modal
                                data-curso-id="{{ $curso->id }}"
                                data-curso-titulo="{{ $curso->titulo }}"
                                aria-label="Eliminar tarjeta {{ $curso->titulo }}"
                                title="Eliminar tarjeta"
                            >
                                &times;
                            </button>
                        </div>
                    @endif

                    <img src="{{ asset($curso->imagen_path ?: 'images/placeholder-card.svg') }}" alt="Curso {{ $curso->titulo }}">
                    <h2>{{ $curso->titulo }}</h2>
                    <p>{{ $curso->descripcion }}</p>
                    <p class="price">Desde ${{ number_format((int) $curso->precio, 0, ',', '.') }}</p>
                    <span class="badge">{{ $curso->is_active ? 'Disponible' : 'No disponible' }}</span>

                    @if ($curso->is_active)
                        <div class="intro-actions">
                            <a
                                class="catalog-button"
                                href="https://api.whatsapp.com/send?phone=56935011486&text={{ $whatsappReserveMessage }}"
                                target="_blank"
                                rel="noopener noreferrer"
                            >
                                Reservar Curso
                            </a>
                        </div>
                    @endif
                </article>
            @empty
                <article class="empty-state">
                    <h2>Aun no hay cursos registrados</h2>
                    <p>Agrega el primer curso usando el boton superior.</p>
                </article>
            @endforelse
        </section>
    </main>

    @if ($administradores)
        <div class="modal-overlay" data-curso-modal hidden>
            <div class="modal-panel" role="dialog" aria-modal="true" aria-labelledby="curso-modal-title">
                <div class="modal-header">
                    <div>
                        <p class="kicker">Nuevo curso</p>
                        <h2 id="curso-modal-title">Agregar Nuevo Curso</h2>
                    </div>
                    <button type="button" class="modal-close" aria-label="Cerrar formulario" data-close-curso-modal>&times;</button>
                </div>

                <form class="corte-form" action="{{ route('cursos.store') }}" method="POST" enctype="multipart/form-data" data-store-form>
                    @csrf
                    <input type="hidden" name="submission_token" value="{{ $submissionToken }}">

                    <label>
                        <span>Titulo</span>
                        <input type="text" name="titulo" value="{{ old('titulo') }}" placeholder="Ej: Curso Inicial" required>
                        @error('titulo', 'storeCurso')
                            <small class="field-error">{{ $message }}</small>
                        @enderror
                    </label>

                    <label>
                        <span>Descripcion</span>
                        <textarea name="descripcion" rows="4" placeholder="Describe el curso" required>{{ old('descripcion') }}</textarea>
                        @error('descripcion', 'storeCurso')
                            <small class="field-error">{{ $message }}</small>
                        @enderror
                    </label>

                    <label>
                        <span>Precio (CLP)</span>
                        <input type="number" name="precio" min="0" step="1" value="{{ old('precio') }}" placeholder="35000" required>
                        @error('precio', 'storeCurso')
                            <small class="field-error">{{ $message }}</small>
                        @enderror
                    </label>

                    <label>
                        <span>Imagen</span>
                        <input type="file" name="imagen" accept="image/*" data-image-input required>
                        @error('imagen', 'storeCurso')
                            <small class="field-error">{{ $message }}</small>
                        @enderror
                    </label>

                    <div class="image-preview" data-image-preview>
                        <span>Vista previa de la imagen</span>
                        <img src="{{ asset('images/placeholder-card.svg') }}" alt="Vista previa del nuevo curso">
                    </div>

                    <div class="form-actions">
                        <button type="button" class="ghost-button" data-close-curso-modal>Cancelar</button>
                        <button type="submit" class="catalog-button">Guardar curso</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="modal-overlay" data-edit-modal hidden>
            <div class="modal-panel" role="dialog" aria-modal="true" aria-labelledby="edit-curso-modal-title">
                <div class="modal-header">
                    <div>
                        <p class="kicker">Editar curso</p>
                        <h2 id="edit-curso-modal-title">Editar Tarjeta</h2>
                    </div>
                    <button type="button" class="modal-close" aria-label="Cerrar edicion" data-close-edit-modal>&times;</button>
                </div>

                <form class="corte-form" data-edit-form method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="curso_id" value="{{ old('curso_id') }}" data-edit-curso-id>

                    <label>
                        <span>Titulo</span>
                        <input type="text" name="titulo" value="{{ old('titulo') }}" placeholder="Ej: Curso Inicial" required data-edit-title>
                        @error('titulo', 'updateCurso')
                            <small class="field-error">{{ $message }}</small>
                        @enderror
                    </label>

                    <label>
                        <span>Descripcion</span>
                        <textarea name="descripcion" rows="4" placeholder="Describe el curso" required data-edit-description>{{ old('descripcion') }}</textarea>
                        @error('descripcion', 'updateCurso')
                            <small class="field-error">{{ $message }}</small>
                        @enderror
                    </label>

                    <label>
                        <span>Precio (CLP)</span>
                        <input type="number" name="precio" min="0" step="1" value="{{ old('precio') }}" placeholder="35000" required data-edit-price>
                        @error('precio', 'updateCurso')
                            <small class="field-error">{{ $message }}</small>
                        @enderror
                    </label>

                    <label class="switch-field">
                        <input type="checkbox" name="is_active" value="1" data-edit-active {{ old('is_active', true) ? 'checked' : '' }}>
                        <span class="switch-ui">
                            <span class="switch-copy">
                                <span class="switch-title">Estado del curso</span>
                                <span class="switch-helper">Habilita o deshabilita la reserva desde la pagina publica</span>
                            </span>
                            <span class="switch-pill" data-switch-pill>Activo</span>
                        </span>
                    </label>

                    <label>
                        <span>Imagen (opcional)</span>
                        <input type="file" name="imagen" accept="image/*" data-edit-image-input>
                        @error('imagen', 'updateCurso')
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
            <div class="modal-panel modal-panel-small" role="dialog" aria-modal="true" aria-labelledby="delete-curso-modal-title">
                <div class="modal-header">
                    <div>
                        <p class="kicker">Eliminar curso</p>
                        <h2 id="delete-curso-modal-title">Eliminar curso</h2>
                    </div>
                    <button type="button" class="modal-close" aria-label="Cerrar eliminacion" data-close-delete-modal>&times;</button>
                </div>

                <p class="delete-copy">Vas a eliminar el curso <strong data-delete-title></strong>. Esta accion no se puede deshacer.</p>

                <form data-delete-form method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="form-actions">
                        <button type="button" class="ghost-button" data-close-delete-modal>Cancelar</button>
                        <button type="submit" class="danger-button">Eliminar curso</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.querySelector('[data-curso-modal]');
            const openButton = document.querySelector('[data-open-curso-modal]');
            const closeButtons = document.querySelectorAll('[data-close-curso-modal]');
            const imageInput = document.querySelector('[data-image-input]');
            const previewImage = document.querySelector('[data-image-preview] img');
            const storeForm = document.querySelector('[data-store-form]');
            const storeSubmitButton = storeForm?.querySelector('button[type="submit"]');

            const editModal = document.querySelector('[data-edit-modal]');
            const openEditButtons = document.querySelectorAll('[data-open-edit-modal]');
            const closeEditButtons = document.querySelectorAll('[data-close-edit-modal]');
            const editForm = document.querySelector('[data-edit-form]');
            const editTitleInput = document.querySelector('[data-edit-title]');
            const editDescriptionInput = document.querySelector('[data-edit-description]');
            const editPriceInput = document.querySelector('[data-edit-price]');
            const editActiveInput = document.querySelector('[data-edit-active]');
            const editSwitchPill = document.querySelector('[data-switch-pill]');
            const editImageInput = document.querySelector('[data-edit-image-input]');
            const editPreviewImage = document.querySelector('[data-edit-image-preview] img');
            const editCursoIdInput = document.querySelector('[data-edit-curso-id]');
            const editSubmitButton = document.querySelector('[data-edit-submit]');

            const deleteModal = document.querySelector('[data-delete-modal]');
            const openDeleteButtons = document.querySelectorAll('[data-open-delete-modal]');
            const closeDeleteButtons = document.querySelectorAll('[data-close-delete-modal]');
            const deleteForm = document.querySelector('[data-delete-form]');
            const deleteTitle = document.querySelector('[data-delete-title]');
            const deleteSubmitButton = deleteForm?.querySelector('button[type="submit"]');

            const routeTemplates = {
                update: '{{ route('cursos.update', ['curso' => '__ID__']) }}',
                destroy: '{{ route('cursos.destroy', ['curso' => '__ID__']) }}',
            };

            const openModal = () => {
                if (!modal) {
                    return;
                }

                modal.hidden = false;
                document.body.classList.add('modal-open');
            };

            const closeModal = () => {
                if (!modal) {
                    return;
                }

                modal.hidden = true;

                if (!editModal || editModal.hidden) {
                    if (!deleteModal || deleteModal.hidden) {
                        document.body.classList.remove('modal-open');
                    }
                }
            };

            const openEditModal = () => {
                if (!editModal) {
                    return;
                }

                editModal.hidden = false;
                document.body.classList.add('modal-open');
            };

            const closeEditModal = () => {
                if (!editModal) {
                    return;
                }

                editModal.hidden = true;

                if (!modal || modal.hidden) {
                    if (!deleteModal || deleteModal.hidden) {
                        document.body.classList.remove('modal-open');
                    }
                }
            };

            const openDeleteModal = () => {
                if (!deleteModal) {
                    return;
                }

                deleteModal.hidden = false;
                document.body.classList.add('modal-open');
            };

            const closeDeleteModal = () => {
                if (!deleteModal) {
                    return;
                }

                deleteModal.hidden = true;

                if (!modal || modal.hidden) {
                    if (!editModal || editModal.hidden) {
                        document.body.classList.remove('modal-open');
                    }
                }
            };

            if (openButton) {
                openButton.addEventListener('click', openModal);
            }

            openEditButtons.forEach((button) => {
                button.addEventListener('click', () => {
                    const cursoId = button.dataset.cursoId;
                    const cursoTitulo = button.dataset.cursoTitulo;
                    const cursoDescripcion = button.dataset.cursoDescripcion;
                    const cursoPrecio = button.dataset.cursoPrecio;
                    const cursoActivo = button.dataset.cursoActivo;
                    const cursoImage = button.dataset.cursoImage;

                    if (!cursoId || !editForm || !editTitleInput || !editDescriptionInput || !editPriceInput || !editPreviewImage || !editCursoIdInput || !editActiveInput) {
                        return;
                    }

                    editForm.action = routeTemplates.update.replace('__ID__', cursoId);
                    editTitleInput.value = cursoTitulo || '';
                    editDescriptionInput.value = cursoDescripcion || '';
                    editPriceInput.value = cursoPrecio || '';
                    editActiveInput.checked = cursoActivo === '1';
                    if (editSwitchPill) {
                        editSwitchPill.textContent = editActiveInput.checked ? 'Activo' : 'Inactivo';
                    }
                    editPreviewImage.src = cursoImage || '{{ asset('images/placeholder-card.svg') }}';
                    editCursoIdInput.value = cursoId;
                    openEditModal();
                });
            });

            openDeleteButtons.forEach((button) => {
                button.addEventListener('click', () => {
                    const cursoId = button.dataset.cursoId;
                    const cursoTitulo = button.dataset.cursoTitulo;

                    if (!cursoId || !deleteForm || !deleteTitle) {
                        return;
                    }

                    deleteForm.action = routeTemplates.destroy.replace('__ID__', cursoId);
                    deleteTitle.textContent = cursoTitulo || 'seleccionado';
                    openDeleteModal();
                });
            });

            closeButtons.forEach((button) => button.addEventListener('click', closeModal));
            closeEditButtons.forEach((button) => button.addEventListener('click', closeEditModal));
            closeDeleteButtons.forEach((button) => button.addEventListener('click', closeDeleteModal));

            modal?.addEventListener('click', (event) => {
                if (event.target === modal) {
                    closeModal();
                }
            });

            editModal?.addEventListener('click', (event) => {
                if (event.target === editModal) {
                    closeEditModal();
                }
            });

            deleteModal?.addEventListener('click', (event) => {
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

            editActiveInput?.addEventListener('change', () => {
                if (editSwitchPill) {
                    editSwitchPill.textContent = editActiveInput.checked ? 'Activo' : 'Inactivo';
                }
            });

            storeForm?.addEventListener('submit', () => {
                if (!storeSubmitButton || storeSubmitButton.disabled) {
                    return;
                }

                storeSubmitButton.disabled = true;
                storeSubmitButton.textContent = 'Guardando...';
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

            @if ($administradores && $errors->storeCurso->any())
                openModal();
            @endif

            @if ($administradores && $errors->updateCurso->any())
                const oldCursoId = '{{ old('curso_id') }}';
                const oldCursoButton = document.querySelector(`[data-open-edit-modal][data-curso-id="${oldCursoId}"]`);

                if (oldCursoButton) {
                    oldCursoButton.click();
                }
            @endif
        });
    </script>
@endpush
