document.addEventListener('DOMContentLoaded', () => {
    const page = document.querySelector('[data-cursos-page]');

    if (!page) {
        return;
    }

    const config = parseConfig(page.dataset.cursosConfig);
    const placeholderImage = config.placeholderImage || '';
    const routeTemplates = config.routeTemplates || {};

    const modal = document.querySelector('[data-curso-modal]');
    const editModal = document.querySelector('[data-edit-modal]');
    const deleteModal = document.querySelector('[data-delete-modal]');
    const managedModals = [modal, editModal, deleteModal].filter(Boolean);

    const openButton = document.querySelector('[data-open-curso-modal]');
    const closeButtons = document.querySelectorAll('[data-close-curso-modal]');

    const imageInput = document.querySelector('[data-image-input]');
    const previewImage = document.querySelector('[data-image-preview] img');
    const storeForm = document.querySelector('[data-store-form]');
    const storeSubmitButton = storeForm?.querySelector('button[type="submit"]');

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

    const openDeleteButtons = document.querySelectorAll('[data-open-delete-modal]');
    const closeDeleteButtons = document.querySelectorAll('[data-close-delete-modal]');
    const deleteForm = document.querySelector('[data-delete-form]');
    const deleteTitle = document.querySelector('[data-delete-title]');
    const deleteSubmitButton = deleteForm?.querySelector('button[type="submit"]');

    const setModalState = (targetModal, isOpen) => {
        if (!targetModal) {
            return;
        }

        targetModal.hidden = !isOpen;
        syncBodyModalState(managedModals);
    };

    openButton?.addEventListener('click', () => setModalState(modal, true));
    closeButtons.forEach((button) => {
        button.addEventListener('click', () => setModalState(modal, false));
    });

    closeEditButtons.forEach((button) => {
        button.addEventListener('click', () => setModalState(editModal, false));
    });

    closeDeleteButtons.forEach((button) => {
        button.addEventListener('click', () => setModalState(deleteModal, false));
    });

    managedModals.forEach((modalElement) => {
        modalElement.addEventListener('click', (event) => {
            if (event.target === modalElement) {
                setModalState(modalElement, false);
            }
        });
    });

    bindImagePreview(imageInput, previewImage, placeholderImage, true);
    bindImagePreview(editImageInput, editPreviewImage, placeholderImage, false);

    bindSubmitLock(storeForm, storeSubmitButton, 'Guardando...');
    bindSubmitLock(editForm, editSubmitButton, 'Guardando...');
    bindSubmitLock(deleteForm, deleteSubmitButton, 'Eliminando...');

    editActiveInput?.addEventListener('change', () => {
        if (editSwitchPill) {
            editSwitchPill.textContent = editActiveInput.checked ? 'Activo' : 'Inactivo';
        }
    });

    openEditButtons.forEach((button) => {
        button.addEventListener('click', () => {
            const cursoId = button.dataset.cursoId;

            if (!cursoId) {
                return;
            }

            if (!editForm || !editTitleInput || !editDescriptionInput || !editPriceInput || !editPreviewImage || !editCursoIdInput || !editActiveInput) {
                return;
            }

            editForm.action = buildRoute(routeTemplates.update, cursoId);
            editTitleInput.value = button.dataset.cursoTitulo || '';
            editDescriptionInput.value = button.dataset.cursoDescripcion || '';
            editPriceInput.value = button.dataset.cursoPrecio || '';
            editActiveInput.checked = button.dataset.cursoActivo === '1';
            if (editSwitchPill) {
                editSwitchPill.textContent = editActiveInput.checked ? 'Activo' : 'Inactivo';
            }
            editPreviewImage.src = button.dataset.cursoImage || placeholderImage;
            editCursoIdInput.value = cursoId;
            setModalState(editModal, true);
        });
    });

    openDeleteButtons.forEach((button) => {
        button.addEventListener('click', () => {
            const cursoId = button.dataset.cursoId;

            if (!cursoId || !deleteForm || !deleteTitle) {
                return;
            }

            deleteForm.action = buildRoute(routeTemplates.destroy, cursoId);
            deleteTitle.textContent = button.dataset.cursoTitulo || 'seleccionado';
            setModalState(deleteModal, true);
        });
    });

    if (config.shouldOpenStoreModal) {
        setModalState(modal, true);
    }

    if (config.shouldOpenUpdateModal && config.oldCursoId) {
        const oldCursoButton = document.querySelector('[data-open-edit-modal][data-curso-id="' + config.oldCursoId + '"]');
        oldCursoButton?.click();
    }
});

function parseConfig(configString) {
    if (!configString) {
        return {};
    }

    try {
        return JSON.parse(configString);
    } catch (_error) {
        return {};
    }
}

function syncBodyModalState(modals) {
    const hasOpenModal = modals.some((modalElement) => !modalElement.hidden);
    document.body.classList.toggle('modal-open', hasOpenModal);
}

function buildRoute(template, id) {
    if (!template) {
        return '';
    }

    return template.replace('__ID__', String(id));
}

function bindImagePreview(fileInput, previewImage, fallbackSource, resetOnEmpty) {
    if (!fileInput || !previewImage) {
        return;
    }

    fileInput.addEventListener('change', (event) => {
        const [file] = event.target.files || [];

        if (!file) {
            if (resetOnEmpty) {
                previewImage.src = fallbackSource;
            }

            return;
        }

        const reader = new FileReader();
        reader.onload = (loadEvent) => {
            const imageSource = loadEvent.target?.result;
            if (typeof imageSource === 'string') {
                previewImage.src = imageSource;
            }
        };
        reader.readAsDataURL(file);
    });
}

function bindSubmitLock(form, submitButton, loadingText) {
    if (!form || !submitButton) {
        return;
    }

    form.addEventListener('submit', () => {
        if (submitButton.disabled) {
            return;
        }

        submitButton.disabled = true;
        submitButton.textContent = loadingText;
    });
}
