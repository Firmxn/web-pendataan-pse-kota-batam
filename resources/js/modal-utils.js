/**
 * Modal Utilities - Reusable functions untuk modal management
 * 
 * Features:
 * - Auto-reset form saat modal ditutup
 * - Auto-open modal dengan error validation
 * - Reset input values dan error messages
 * 
 * ===== CARA PENGGUNAAN =====
 * 
 * 1. SETUP MODAL (Tambahkan attribute data-auto-reset):
 *    <dialog id="modal_example" class="modal" data-auto-reset>
 *        <form>
 *            <input name="field" 
 *                   value="{{ old('field', $data->field) }}"
 *                   data-original-value="{{ $data->field }}"
 *                   class="{{ $errors->has('field') ? 'input-error' : '' }}" />
 *            
 *            @if($errors->has('field'))
 *                <div class="text-error" data-error-message>
 *                    {{ $errors->first('field') }}
 *                </div>
 *            @endif
 *            
 *            <button type="button" onclick="closeAndResetModal('modal_example')">
 *                Batal
 *            </button>
 *        </form>
 *    </dialog>
 * 
 * 2. AUTO-OPEN MODAL DENGAN ERROR (Di controller):
 *    return redirect()->back()
 *        ->withErrors($validator)
 *        ->withInput()
 *        ->with('editing_item_uuid', $item->uuid);
 * 
 *    (Di blade):
 *    @if (session('editing_item_uuid'))
 *        <script>
 *            document.addEventListener('DOMContentLoaded', function() {
 *                autoOpenModalWithError('modal_{{ session('editing_item_uuid') }}');
 *            });
 *        </script>
 *    @endif
 * 
 * 3. MANUAL RESET (Opsional):
 *    <button onclick="resetModalForm('modal_id')">Reset</button>
 * 
 * ===== CATATAN PENTING =====
 * - Input harus punya attribute 'data-original-value' untuk reset
 * - Error message harus punya attribute 'data-error-message' atau class 'text-error'
 * - Modal harus punya attribute 'data-auto-reset' untuk auto-initialization
 * - Functions tersedia global: resetModalForm, closeAndResetModal, autoOpenModalWithError
 */

/**
 * Reset form di dalam modal ke nilai original
 * @param {string|HTMLElement} modalElement - Modal ID atau element
 */
export function resetModalForm(modalElement) {
    const modal = typeof modalElement === 'string'
        ? document.getElementById(modalElement)
        : modalElement;

    if (!modal) {
        console.warn('Modal tidak ditemukan:', modalElement);
        return;
    }

    const form = modal.querySelector('form');
    if (!form) {
        console.warn('Form tidak ditemukan di modal');
        return;
    }

    // Reset semua input ke nilai original
    const inputs = form.querySelectorAll('input[type="text"], input[type="email"], input[type="number"], input[type="password"], textarea, select');

    inputs.forEach(input => {
        const originalValue = input.getAttribute('data-original-value') || input.defaultValue || '';
        input.value = originalValue;
    });

    // Hapus class error dari input dan tambahkan kembali class normal
    const errorInputs = form.querySelectorAll('.input-error');
    errorInputs.forEach(input => {
        // Ambil semua class yang ada
        const currentClasses = input.className.split(' ');

        // Filter: hapus class error-related
        const cleanedClasses = currentClasses.filter(cls =>
            !cls.includes('input-error') &&
            !cls.includes('ring-error')
        );

        // Tambahkan class normal jika belum ada
        if (!cleanedClasses.includes('input-bordered')) {
            cleanedClasses.push('input-bordered');
        }
        if (!cleanedClasses.includes('focus:border-primary')) {
            cleanedClasses.push('focus:border-primary');
        }
        if (!cleanedClasses.includes('focus:outline-none')) {
            cleanedClasses.push('focus:outline-none');
        }
        if (!cleanedClasses.includes('focus:ring-2')) {
            cleanedClasses.push('focus:ring-2');
        }
        if (!cleanedClasses.includes('focus:ring-primary/20')) {
            cleanedClasses.push('focus:ring-primary/20');
        }

        // Set ulang class attribute
        input.className = cleanedClasses.join(' ');
    });

    // Hapus semua error messages
    const errorMessages = form.querySelectorAll('.text-error, [data-error-message]');
    errorMessages.forEach(errorMsg => {
        errorMsg.remove();
    });

}

/**
 * Close modal dan reset form
 * @param {string|HTMLElement} modalElement - Modal ID atau element
 */
export function closeAndResetModal(modalElement) {
    const modal = typeof modalElement === 'string'
        ? document.getElementById(modalElement)
        : modalElement;

    if (!modal) return;

    resetModalForm(modal);
    modal.close();
}

/**
 * Auto-initialize semua modal dengan attribute data-auto-reset
 * Dipanggil saat DOMContentLoaded
 */
export function initAutoResetModals() {
    const modals = document.querySelectorAll('dialog.modal[data-auto-reset]');

    modals.forEach(modal => {
        // Listen event 'close' untuk auto-reset
        modal.addEventListener('close', function (e) {
            // Cek apakah modal ditutup karena submit atau cancel
            const form = modal.querySelector('form');
            if (form && !modal.dataset.submitted) {
                // Delay kecil untuk memastikan modal sudah tertutup
                setTimeout(() => {
                    resetModalForm(modal);
                }, 100);
            }
            // Reset flag
            delete modal.dataset.submitted;
        });

        // Track form submission
        const form = modal.querySelector('form');
        if (form) {
            form.addEventListener('submit', function () {
                modal.dataset.submitted = 'true';
            });
        }
    });
}

/**
 * Auto-open modal berdasarkan session error
 * @param {string} modalId - ID modal yang akan dibuka
 */
export function autoOpenModalWithError(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.showModal();
    }
}

/**
 * Auto-open modal yang ditandai dengan data-auto-open="true"
 */
export function initAutoOpenModals() {
    const modalsToOpen = document.querySelectorAll('dialog.modal[data-auto-open="true"]');
    modalsToOpen.forEach(modal => {
        if (typeof modal.showModal === 'function') {
            modal.showModal();
        }
    });
}

// Auto-initialize saat DOM ready
if (typeof window !== 'undefined') {
    document.addEventListener('DOMContentLoaded', () => {
        initAutoResetModals();
        initAutoOpenModals();
    });
}

// Export sebagai global functions untuk inline onclick
window.resetModalForm = resetModalForm;
window.closeAndResetModal = closeAndResetModal;
window.autoOpenModalWithError = autoOpenModalWithError;
window.initAutoOpenModals = initAutoOpenModals;
