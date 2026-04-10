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
