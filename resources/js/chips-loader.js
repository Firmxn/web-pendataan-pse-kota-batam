/**
 * Chips Input Loader
 * Inisialisasi input chip (tagging) dari atribut data-* pada '.chips-input-container'.
 * Keamanan: tanpa inline script (patuh CSP), render teks via textContent (cegah DOM XSS).
 */

export function initChipsInput(container) {
    if (!container) return;

    const id = container.getAttribute('data-id');
    const inputName = container.getAttribute('data-name');
    const defaultPlaceholder = container.getAttribute('data-placeholder') || '';
    const utamaLabel = container.getAttribute('data-utama-label') || 'UTAMA';
    
    let chips = [];
    try {
        chips = JSON.parse(container.getAttribute('data-initial') || '[]');
    } catch (e) {
        console.error('Gagal mengurai nilai awal chip:', e);
    }

    const inputField = container.querySelector('.chips-input');
    const chipsList = container.querySelector('.chips-list');
    const hiddenInputs = container.querySelector('.hidden-inputs');

    if (!inputField || !chipsList || !hiddenInputs) return;

    function render() {
        chipsList.innerHTML = '';
        hiddenInputs.innerHTML = '';
        inputField.placeholder = chips.length === 0 ? defaultPlaceholder : '';

        chips.forEach((chip, index) => {
            const badge = document.createElement('div');
            badge.className = 'badge badge-primary bg-primary/10 text-primary border-none gap-1 py-3 px-2 flex items-center animate-in fade-in zoom-in duration-200';
            
            let label = '';
            if (index === 0) {
                label = `<span class="text-[9px] font-black mr-1 opacity-70 underline decoration-1 tracking-tighter">${utamaLabel}</span>`;
            }

            badge.innerHTML = `
                ${label}
                <span class="chip-text text-xs font-semibold whitespace-nowrap"></span>
                <button type="button" class="remove-chip-btn hover:text-error focus:outline-none transition-colors p-0.5 rounded-full">
                    <svg class="h-3 w-3" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            `;
            
            // Keamanan: textContent (bukan innerHTML) mencegah DOM XSS dari input user
            badge.querySelector('.chip-text').textContent = chip;

            // Tambahkan handler hapus chip
            badge.querySelector('.remove-chip-btn').addEventListener('click', (e) => {
                e.stopPropagation();
                removeChip(index);
            });

            chipsList.appendChild(badge);

            const hidden = document.createElement('input');
            hidden.type = 'hidden';
            hidden.name = inputName.endsWith('[]') ? inputName : `${inputName}[]`;
            hidden.value = chip;
            hiddenInputs.appendChild(hidden);
        });
    }

    function addChip() {
        const val = inputField.value.trim().replace(/,+$/, '');
        if (val && !chips.includes(val)) {
            chips.push(val);
            inputField.value = '';
            render();
        } else {
            inputField.value = '';
        }
    }

    function removeChip(index) {
        chips.splice(index, 1);
        render();
    }

    // Event listener focus klik pada area visual
    const visual = container.querySelector('.input');
    if (visual) {
        visual.addEventListener('click', () => {
            inputField.focus();
        });
    }

    inputField.addEventListener('keydown', (e) => {
        if (['Enter', ' ', ','].includes(e.key)) {
            if (inputField.value.trim() !== '') {
                e.preventDefault();
                addChip();
            }
        }
        if (e.key === 'Backspace' && inputField.value === '' && chips.length > 0) {
            chips.pop();
            render();
        }
    });

    inputField.addEventListener('blur', addChip);
    render();
}

export function initAllChipsInputs() {
    const containers = document.querySelectorAll('.chips-input-container');
    containers.forEach(container => {
        if (container.classList.contains('chips-initialized')) return;
        container.classList.add('chips-initialized');
        initChipsInput(container);
    });
}

// Auto-initialize saat DOM ready
if (typeof window !== 'undefined') {
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initAllChipsInputs);
    } else {
        initAllChipsInputs();
    }
}
