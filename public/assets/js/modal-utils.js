/**
 * Modal and Alert Utilities for iWellCare
 * Provides consistent modal and alert functionality across the application
 */

class ModalUtils {
    /**
     * Show a confirmation modal
     * @param {string} title - Modal title
     * @param {string} message - Modal message
     * @param {string} type - Modal type (danger, warning, info, success)
     * @param {Function} onConfirm - Callback function when confirmed
     * @param {Function} onCancel - Callback function when cancelled
     */
    static showConfirmation(title, message, type = 'danger', onConfirm = null, onCancel = null) {
        const modalId = 'confirmationModal';
        const modalHtml = `
            <div class="modal fade" id="${modalId}" tabindex="-1" aria-labelledby="${modalId}Label" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-${type} text-white">
                            <h5 class="modal-title" id="${modalId}Label">
                                <i class="fas fa-exclamation-triangle me-2"></i>${title}
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-${type === 'danger' ? 'warning' : type}">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <strong>Warning:</strong> This action cannot be undone!
                            </div>
                            <p>${message}</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="fas fa-times me-1"></i>Cancel
                            </button>
                            <button type="button" class="btn btn-${type}" id="confirmActionBtn">
                                <i class="fas fa-check me-1"></i>Confirm
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;

        // Remove existing modal if any
        const existingModal = document.getElementById(modalId);
        if (existingModal) {
            existingModal.remove();
        }

        // Add modal to body
        document.body.insertAdjacentHTML('beforeend', modalHtml);

        // Get modal element
        const modal = document.getElementById(modalId);
        const modalInstance = new bootstrap.Modal(modal);

        // Add event listeners
        const confirmBtn = document.getElementById('confirmActionBtn');
        confirmBtn.addEventListener('click', () => {
            modalInstance.hide();
            if (onConfirm) onConfirm();
        });

        modal.addEventListener('hidden.bs.modal', () => {
            if (onCancel) onCancel();
            modal.remove();
        });

        // Show modal
        modalInstance.show();
    }

    /**
     * Show a success modal
     * @param {string} title - Modal title
     * @param {string} message - Modal message
     * @param {Function} onClose - Callback function when modal is closed
     */
    static showSuccess(title, message, onClose = null) {
        const modalId = 'successModal';
        const modalHtml = `
            <div class="modal fade" id="${modalId}" tabindex="-1" aria-labelledby="${modalId}Label" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-success text-white">
                            <h5 class="modal-title" id="${modalId}Label">
                                <i class="fas fa-check-circle me-2"></i>${title}
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="text-center">
                                <i class="fas fa-check-circle text-success" style="font-size: 3rem;"></i>
                                <h5 class="mt-3">${title}</h5>
                                <p class="text-muted">${message}</p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success" data-bs-dismiss="modal">
                                <i class="fas fa-check me-1"></i>OK
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;

        // Remove existing modal if any
        const existingModal = document.getElementById(modalId);
        if (existingModal) {
            existingModal.remove();
        }

        // Add modal to body
        document.body.insertAdjacentHTML('beforeend', modalHtml);

        // Get modal element
        const modal = document.getElementById(modalId);
        const modalInstance = new bootstrap.Modal(modal);

        // Add event listener
        modal.addEventListener('hidden.bs.modal', () => {
            if (onClose) onClose();
            modal.remove();
        });

        // Show modal
        modalInstance.show();
    }

    /**
     * Show an error modal
     * @param {string} title - Modal title
     * @param {string} message - Modal message
     * @param {Function} onClose - Callback function when modal is closed
     */
    static showError(title, message, onClose = null) {
        const modalId = 'errorModal';
        const modalHtml = `
            <div class="modal fade" id="${modalId}" tabindex="-1" aria-labelledby="${modalId}Label" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-danger text-white">
                            <h5 class="modal-title" id="${modalId}Label">
                                <i class="fas fa-exclamation-circle me-2"></i>${title}
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="text-center">
                                <i class="fas fa-exclamation-circle text-danger" style="font-size: 3rem;"></i>
                                <h5 class="mt-3">${title}</h5>
                                <p class="text-muted">${message}</p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="fas fa-times me-1"></i>Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;

        // Remove existing modal if any
        const existingModal = document.getElementById(modalId);
        if (existingModal) {
            existingModal.remove();
        }

        // Add modal to body
        document.body.insertAdjacentHTML('beforeend', modalHtml);

        // Get modal element
        const modal = document.getElementById(modalId);
        const modalInstance = new bootstrap.Modal(modal);

        // Add event listener
        modal.addEventListener('hidden.bs.modal', () => {
            if (onClose) onClose();
            modal.remove();
        });

        // Show modal
        modalInstance.show();
    }

    /**
     * Show an info modal
     * @param {string} title - Modal title
     * @param {string} message - Modal message
     * @param {Function} onClose - Callback function when modal is closed
     */
    static showInfo(title, message, onClose = null) {
        const modalId = 'infoModal';
        const modalHtml = `
            <div class="modal fade" id="${modalId}" tabindex="-1" aria-labelledby="${modalId}Label" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-info text-white">
                            <h5 class="modal-title" id="${modalId}Label">
                                <i class="fas fa-info-circle me-2"></i>${title}
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="text-center">
                                <i class="fas fa-info-circle text-info" style="font-size: 3rem;"></i>
                                <h5 class="mt-3">${title}</h5>
                                <p class="text-muted">${message}</p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-info" data-bs-dismiss="modal">
                                <i class="fas fa-check me-1"></i>OK
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;

        // Remove existing modal if any
        const existingModal = document.getElementById(modalId);
        if (existingModal) {
            existingModal.remove();
        }

        // Add modal to body
        document.body.insertAdjacentHTML('beforeend', modalHtml);

        // Get modal element
        const modal = document.getElementById(modalId);
        const modalInstance = new bootstrap.Modal(modal);

        // Add event listener
        modal.addEventListener('hidden.bs.modal', () => {
            if (onClose) onClose();
            modal.remove();
        });

        // Show modal
        modalInstance.show();
    }

    /**
     * Show a loading modal
     * @param {string} message - Loading message
     */
    static showLoading(message = 'Loading...') {
        const modalId = 'loadingModal';
        const modalHtml = `
            <div class="modal fade" id="${modalId}" tabindex="-1" aria-labelledby="${modalId}Label" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                <div class="modal-dialog modal-dialog-centered modal-sm">
                    <div class="modal-content">
                        <div class="modal-body text-center">
                            <div class="spinner-border text-primary mb-3" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="mb-0">${message}</p>
                        </div>
                    </div>
                </div>
            </div>
        `;

        // Remove existing modal if any
        const existingModal = document.getElementById(modalId);
        if (existingModal) {
            existingModal.remove();
        }

        // Add modal to body
        document.body.insertAdjacentHTML('beforeend', modalHtml);

        // Get modal element and show it
        const modal = document.getElementById(modalId);
        const modalInstance = new bootstrap.Modal(modal);
        modalInstance.show();

        return modalInstance;
    }

    /**
     * Hide loading modal
     */
    static hideLoading() {
        const modal = document.getElementById('loadingModal');
        if (modal) {
            const modalInstance = bootstrap.Modal.getInstance(modal);
            if (modalInstance) {
                modalInstance.hide();
            }
            modal.remove();
        }
    }

    /**
     * Show a custom modal with HTML content
     * @param {string|HTMLElement} content - Modal content (HTML string or DOM element)
     */
    static showModal(content) {
        const modalId = 'customModal';
        
        // Remove existing modal if any
        const existingModal = document.getElementById(modalId);
        if (existingModal) {
            existingModal.remove();
        }

        // Create modal HTML
        const modalHtml = `
            <div class="modal fade" id="${modalId}" tabindex="-1" aria-labelledby="${modalId}Label" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="${modalId}Content">
                        </div>
                    </div>
                </div>
            </div>
        `;

        // Add modal to body
        document.body.insertAdjacentHTML('beforeend', modalHtml);

        // Get modal element
        const modal = document.getElementById(modalId);
        const modalContent = document.getElementById(modalId + 'Content');
        const modalInstance = new bootstrap.Modal(modal);

        // Set content
        if (typeof content === 'string') {
            modalContent.innerHTML = content;
        } else if (content instanceof HTMLElement) {
            modalContent.appendChild(content);
        }

        // Add event listener for cleanup
        modal.addEventListener('hidden.bs.modal', () => {
            modal.remove();
        });

        // Show modal
        modalInstance.show();
    }

    /**
     * Hide the current modal
     */
    static hideModal() {
        const modal = document.querySelector('.modal.show');
        if (modal) {
            const modalInstance = bootstrap.Modal.getInstance(modal);
            if (modalInstance) {
                modalInstance.hide();
            }
        }
    }
}

// Make ModalUtils available globally
window.ModalUtils = ModalUtils; 