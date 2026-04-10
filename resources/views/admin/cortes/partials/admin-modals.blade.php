<div class="modal-overlay" data-corte-modal hidden>
    <div class="modal-panel" role="dialog" aria-modal="true" aria-labelledby="corte-modal-title">
        <div class="modal-header">
            <div>
                <p class="kicker">Nuevo corte</p>
                <h2 id="corte-modal-title">Agregar Nuevo Corte</h2>
            </div>
            <button type="button" class="modal-close" aria-label="Cerrar formulario" data-close-corte-modal>&times;</button>
        </div>

        <form class="corte-form" action="{{ route('cortes.store') }}" method="POST" enctype="multipart/form-data" data-store-form>
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
                <h2 id="delete-corte-modal-title">Eliminar corte</h2>
            </div>
            <button type="button" class="modal-close" aria-label="Cerrar eliminacion" data-close-delete-modal>&times;</button>
        </div>

        <p class="delete-copy">Vas a eliminar el corte <strong data-delete-title></strong>. Esta accion no se puede deshacer.</p>

        <form data-delete-form method="POST">
            @csrf
            @method('DELETE')
            <div class="form-actions">
                <button type="button" class="ghost-button" data-close-delete-modal>Cancelar</button>
                <button type="submit" class="danger-button">Eliminar corte</button>
            </div>
        </form>
    </div>
</div>
