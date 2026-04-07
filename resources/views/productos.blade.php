@extends('layouts.site')

@section('title', 'Productos | Thiago Barber')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/productos.css') }}">
@endpush

@section('content')
    @include('partials.catalog-navbar')

    <main class="products-page">
        <section class="container intro">
            <p class="kicker">Cuidado y estilo diario</p>
            <h1>Productos Disponibles</h1>
            <p>
                Seleccionamos productos profesionales para peinar, hidratar y mantener tu look de barberia.
                Administra este catalogo desde aqui para agregar, editar o eliminar productos cuando quieras.
            </p>
            @if ($administradores)
                <div class="intro-actions">
                    <button class="catalog-button" type="button" data-open-producto-modal>Agregar Nuevo Producto</button>
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

        <section class="container products-grid" aria-label="Catalogo de productos disponibles">
            @forelse ($productos as $producto)
                <article class="product-card">
                    @if ($administradores)
                        <div class="card-actions" aria-label="Acciones de tarjeta">
                            <button
                                type="button"
                                class="card-icon-button"
                                data-open-edit-modal
                                data-producto-id="{{ $producto->id }}"
                                data-producto-title="{{ $producto->titulo }}"
                                data-producto-description="{{ $producto->descripcion }}"
                                data-producto-badge="{{ $producto->etiqueta }}"
                                data-producto-price="{{ $producto->precio }}"
                                data-producto-image="{{ asset($producto->imagen_path) }}"
                                aria-label="Editar tarjeta {{ $producto->titulo }}"
                                title="Editar tarjeta"
                            >
                                &#9998;
                            </button>
                            <button
                                type="button"
                                class="card-icon-button danger"
                                data-open-delete-modal
                                data-producto-id="{{ $producto->id }}"
                                data-producto-title="{{ $producto->titulo }}"
                                aria-label="Eliminar tarjeta {{ $producto->titulo }}"
                                title="Eliminar tarjeta"
                            >
                                &times;
                            </button>
                        </div>
                    @endif

                    <img src="{{ asset($producto->imagen_path) }}" alt="{{ $producto->titulo }}">
                    <h2>{{ $producto->titulo }}</h2>
                    <p>{{ $producto->descripcion }}</p>
                    <div class="product-meta">
                        <span class="badge">{{ $producto->etiqueta }}</span>
                        <p class="price">${{ number_format($producto->precio, 0, ',', '.') }}</p>
                    </div>
                </article>
            @empty
                <article class="empty-state">
                    <h2>Aun no hay productos registrados</h2>
                    <p>Agrega el primer producto usando el boton superior.</p>
                </article>
            @endforelse
        </section>
    </main>

    @if ($administradores)
    <div class="modal-overlay" data-producto-modal hidden>
        <div class="modal-panel" role="dialog" aria-modal="true" aria-labelledby="producto-modal-title">
            <div class="modal-header">
                <div>
                    <p class="kicker">Nuevo producto</p>
                    <h2 id="producto-modal-title">Agregar Nuevo Producto</h2>
                </div>
                <button type="button" class="modal-close" aria-label="Cerrar formulario" data-close-producto-modal>&times;</button>
            </div>

            <form class="producto-form" action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data" data-store-form>
                @csrf
                <input type="hidden" name="submission_token" value="{{ $submissionToken }}">

                <label>
                    <span>Titulo</span>
                    <input type="text" name="titulo" value="{{ old('titulo') }}" placeholder="Ej: Cera Mate" required>
                    @error('titulo', 'storeProducto')
                        <small class="field-error">{{ $message }}</small>
                    @enderror
                </label>

                <label>
                    <span>Descripcion</span>
                    <textarea name="descripcion" rows="3" placeholder="Describe el producto" required>{{ old('descripcion') }}</textarea>
                    @error('descripcion', 'storeProducto')
                        <small class="field-error">{{ $message }}</small>
                    @enderror
                </label>

                <label>
                    <span>Etiqueta</span>
                    <input type="text" name="etiqueta" value="{{ old('etiqueta') }}" placeholder="Ej: Top Ventas" required>
                    @error('etiqueta', 'storeProducto')
                        <small class="field-error">{{ $message }}</small>
                    @enderror
                </label>

                <label>
                    <span>Precio (CLP)</span>
                    <input type="number" name="precio" min="0" step="1" value="{{ old('precio') }}" placeholder="8990" required>
                    @error('precio', 'storeProducto')
                        <small class="field-error">{{ $message }}</small>
                    @enderror
                </label>

                <label>
                    <span>Imagen</span>
                    <input type="file" name="imagen" accept="image/*" data-image-input required>
                    @error('imagen', 'storeProducto')
                        <small class="field-error">{{ $message }}</small>
                    @enderror
                </label>

                <div class="image-preview" data-image-preview>
                    <span>Vista previa de la imagen</span>
                    <img src="{{ asset('images/placeholder-card.svg') }}" alt="Vista previa del nuevo producto">
                </div>

                <div class="form-actions">
                    <button type="button" class="ghost-button" data-close-producto-modal>Cancelar</button>
                    <button type="submit" class="catalog-button">Guardar producto</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal-overlay" data-edit-modal hidden>
        <div class="modal-panel" role="dialog" aria-modal="true" aria-labelledby="edit-producto-modal-title">
            <div class="modal-header">
                <div>
                    <p class="kicker">Editar producto</p>
                    <h2 id="edit-producto-modal-title">Editar Tarjeta</h2>
                </div>
                <button type="button" class="modal-close" aria-label="Cerrar edicion" data-close-edit-modal>&times;</button>
            </div>

            <form class="producto-form" data-edit-form method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="producto_id" value="{{ old('producto_id') }}" data-edit-producto-id>

                <label>
                    <span>Titulo</span>
                    <input type="text" name="titulo" value="{{ old('titulo') }}" placeholder="Ej: Cera Mate" required data-edit-title>
                    @error('titulo', 'updateProducto')
                        <small class="field-error">{{ $message }}</small>
                    @enderror
                </label>

                <label>
                    <span>Descripcion</span>
                    <textarea name="descripcion" rows="3" placeholder="Describe el producto" required data-edit-description>{{ old('descripcion') }}</textarea>
                    @error('descripcion', 'updateProducto')
                        <small class="field-error">{{ $message }}</small>
                    @enderror
                </label>

                <label>
                    <span>Etiqueta</span>
                    <input type="text" name="etiqueta" value="{{ old('etiqueta') }}" placeholder="Ej: Top Ventas" required data-edit-badge>
                    @error('etiqueta', 'updateProducto')
                        <small class="field-error">{{ $message }}</small>
                    @enderror
                </label>

                <label>
                    <span>Precio (CLP)</span>
                    <input type="number" name="precio" min="0" step="1" value="{{ old('precio') }}" placeholder="8990" required data-edit-price>
                    @error('precio', 'updateProducto')
                        <small class="field-error">{{ $message }}</small>
                    @enderror
                </label>

                <label>
                    <span>Imagen (opcional)</span>
                    <input type="file" name="imagen" accept="image/*" data-edit-image-input>
                    @error('imagen', 'updateProducto')
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
        <div class="modal-panel modal-panel-small" role="dialog" aria-modal="true" aria-labelledby="delete-producto-modal-title">
            <div class="modal-header">
                <div>
                    <p class="kicker">Eliminar producto</p>
                    <h2 id="delete-producto-modal-title">Eliminar producto</h2>
                </div>
                <button type="button" class="modal-close" aria-label="Cerrar eliminacion" data-close-delete-modal>&times;</button>
            </div>

            <p class="delete-copy">Vas a eliminar el producto <strong data-delete-title></strong>. Esta accion no se puede deshacer.</p>

            <form data-delete-form method="POST">
                @csrf
                @method('DELETE')
                <div class="form-actions">
                    <button type="button" class="ghost-button" data-close-delete-modal>Cancelar</button>
                    <button type="submit" class="danger-button">Eliminar producto</button>
                </div>
            </form>
        </div>
    </div>
    @endif
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.querySelector('[data-producto-modal]');
            const openButton = document.querySelector('[data-open-producto-modal]');
            const closeButtons = document.querySelectorAll('[data-close-producto-modal]');
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
            const editBadgeInput = document.querySelector('[data-edit-badge]');
            const editPriceInput = document.querySelector('[data-edit-price]');
            const editImageInput = document.querySelector('[data-edit-image-input]');
            const editPreviewImage = document.querySelector('[data-edit-image-preview] img');
            const editProductoIdInput = document.querySelector('[data-edit-producto-id]');
            const editSubmitButton = document.querySelector('[data-edit-submit]');

            const deleteModal = document.querySelector('[data-delete-modal]');
            const openDeleteButtons = document.querySelectorAll('[data-open-delete-modal]');
            const closeDeleteButtons = document.querySelectorAll('[data-close-delete-modal]');
            const deleteForm = document.querySelector('[data-delete-form]');
            const deleteTitle = document.querySelector('[data-delete-title]');
            const deleteSubmitButton = deleteForm?.querySelector('button[type="submit"]');

            const routeTemplates = {
                update: '{{ route('productos.update', ['producto' => '__ID__']) }}',
                destroy: '{{ route('productos.destroy', ['producto' => '__ID__']) }}',
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
                    const productoId = button.dataset.productoId;
                    const productoTitle = button.dataset.productoTitle;
                    const productoDescription = button.dataset.productoDescription;
                    const productoBadge = button.dataset.productoBadge;
                    const productoPrice = button.dataset.productoPrice;
                    const productoImage = button.dataset.productoImage;

                    if (!productoId || !editForm || !editTitleInput || !editDescriptionInput || !editBadgeInput || !editPriceInput || !editPreviewImage || !editProductoIdInput) {
                        return;
                    }

                    editForm.action = routeTemplates.update.replace('__ID__', productoId);
                    editTitleInput.value = productoTitle || '';
                    editDescriptionInput.value = productoDescription || '';
                    editBadgeInput.value = productoBadge || '';
                    editPriceInput.value = productoPrice || '';
                    editPreviewImage.src = productoImage || '{{ asset('images/placeholder-card.svg') }}';
                    editProductoIdInput.value = productoId;
                    openEditModal();
                });
            });

            openDeleteButtons.forEach((button) => {
                button.addEventListener('click', () => {
                    const productoId = button.dataset.productoId;
                    const productoTitle = button.dataset.productoTitle;

                    if (!productoId || !deleteForm || !deleteTitle) {
                        return;
                    }

                    deleteForm.action = routeTemplates.destroy.replace('__ID__', productoId);
                    deleteTitle.textContent = productoTitle || 'seleccionada';
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

            @if ($administradores && $errors->storeProducto->any())
                openModal();
            @endif

            @if ($administradores && $errors->updateProducto->any())
                const oldProductoId = '{{ old('producto_id') }}';
                const oldProductoButton = document.querySelector(`[data-open-edit-modal][data-producto-id="${oldProductoId}"]`);

                if (oldProductoButton) {
                    oldProductoButton.click();
                }
            @endif
        });
    </script>
@endpush
