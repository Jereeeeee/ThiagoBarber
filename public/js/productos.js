document.addEventListener('DOMContentLoaded', () => {
    const page = document.querySelector('[data-productos-page]');

    if (!page) {
        return;
    }

    const config = parseConfig(page.dataset.productosConfig);
    const placeholderImage = config.placeholderImage || '';
    const routeTemplates = config.routeTemplates || {};

    const modal = document.querySelector('[data-producto-modal]');
    const editModal = document.querySelector('[data-edit-modal]');
    const deleteModal = document.querySelector('[data-delete-modal]');
    const managedModals = [modal, editModal, deleteModal].filter(Boolean);

    const openButton = document.querySelector('[data-open-producto-modal]');
    const closeButtons = document.querySelectorAll('[data-close-producto-modal]');

    const imageInput = document.querySelector('[data-image-input]');
    const previewImage = document.querySelector('[data-image-preview] img');
    const storeForm = document.querySelector('[data-store-form]');
    const storeSubmitButton = storeForm?.querySelector('button[type="submit"]');

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

    openEditButtons.forEach((button) => {
        button.addEventListener('click', () => {
            const productoId = button.dataset.productoId;

            if (!productoId) {
                return;
            }

            if (!editForm || !editTitleInput || !editDescriptionInput || !editBadgeInput || !editPriceInput || !editPreviewImage || !editProductoIdInput) {
                return;
            }

            editForm.action = buildRoute(routeTemplates.update, productoId);
            editTitleInput.value = button.dataset.productoTitle || '';
            editDescriptionInput.value = button.dataset.productoDescription || '';
            editBadgeInput.value = button.dataset.productoBadge || '';
            editPriceInput.value = button.dataset.productoPrice || '';
            editPreviewImage.src = button.dataset.productoImage || placeholderImage;
            editProductoIdInput.value = productoId;
            setModalState(editModal, true);
        });
    });

    openDeleteButtons.forEach((button) => {
        button.addEventListener('click', () => {
            const productoId = button.dataset.productoId;

            if (!productoId || !deleteForm || !deleteTitle) {
                return;
            }

            deleteForm.action = buildRoute(routeTemplates.destroy, productoId);
            deleteTitle.textContent = button.dataset.productoTitle || 'seleccionada';
            setModalState(deleteModal, true);
        });
    });

    if (config.shouldOpenStoreModal) {
        setModalState(modal, true);
    }

    if (config.shouldOpenUpdateModal && config.oldProductoId) {
        const oldProductoButton = document.querySelector('[data-open-edit-modal][data-producto-id="' + config.oldProductoId + '"]');
        oldProductoButton?.click();
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
