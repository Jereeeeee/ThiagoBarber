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
