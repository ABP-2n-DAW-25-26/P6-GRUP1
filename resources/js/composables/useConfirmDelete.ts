import Swal from 'sweetalert2';

interface ConfirmDeleteOptions {
    title?: string;
    text?: string;
    successTitle?: string;
}

export function useConfirmDelete() {
    const confirmDelete = async (
        onConfirm: () => void,
        options: ConfirmDeleteOptions = {},
    ) => {
        const {
            title = 'Eliminar element?',
            text = 'Aquesta acció no es pot desfer.',
            successTitle = 'Eliminat',
        } = options;

        const result = await Swal.fire({
            title,
            text,
            showCancelButton: true,
            confirmButtonText: 'Eliminar',
            cancelButtonText: 'Cancel·lar',
            icon: undefined,
            background: '#fff',
            color: '#111827',
            buttonsStyling: false,
            customClass: {
                popup: 'rounded-xl border border-gray-100',
                title: 'text-base font-medium',
                htmlContainer: 'text-sm text-gray-400',
                confirmButton:
                    'text-red-600 font-medium px-3 py-2 rounded-lg transition hover:bg-red-50 hover:text-red-700 focus:outline-none',
                cancelButton:
                    'text-gray-500 px-3 py-2 rounded-lg transition hover:bg-gray-100 hover:text-gray-700 ml-2 focus:outline-none',
            },
        });

        if (result.isConfirmed) {
            onConfirm();

            Swal.fire({
                title: successTitle,
                timer: 1200,
                showConfirmButton: false,
                background: '#fff',
                color: '#111827',
                customClass: { popup: 'rounded-xl border border-gray-100' },
            });
        }
    };

    return { confirmDelete };
}
