import { describe, it, expect, vi, beforeEach } from 'vitest';
import Swal from 'sweetalert2';
import { useConfirmDelete } from '@/composables/useConfirmDelete';

vi.mock('sweetalert2', () => ({
    default: {
        fire: vi.fn(),
    },
}));

describe('useConfirmDelete', () => {
    beforeEach(() => {
        vi.clearAllMocks();
    });

    it('calls onConfirm when user confirms', async () => {
        vi.mocked(Swal.fire)
            .mockResolvedValueOnce({ isConfirmed: true } as any)
            .mockResolvedValueOnce({} as any); // success toast

        const { confirmDelete } = useConfirmDelete();
        const onConfirm = vi.fn();

        await confirmDelete(onConfirm);

        expect(onConfirm).toHaveBeenCalledOnce();
    });

    it('does not call onConfirm when user cancels', async () => {
        vi.mocked(Swal.fire).mockResolvedValueOnce({ isConfirmed: false } as any);

        const { confirmDelete } = useConfirmDelete();
        const onConfirm = vi.fn();

        await confirmDelete(onConfirm);

        expect(onConfirm).not.toHaveBeenCalled();
    });

    it('shows success toast after confirming', async () => {
        vi.mocked(Swal.fire)
            .mockResolvedValueOnce({ isConfirmed: true } as any)
            .mockResolvedValueOnce({} as any);

        const { confirmDelete } = useConfirmDelete();
        await confirmDelete(() => {}, { successTitle: 'Eliminat!' });

        expect(Swal.fire).toHaveBeenCalledTimes(2);
        expect(vi.mocked(Swal.fire).mock.calls[1][0]).toMatchObject({
            title: 'Eliminat!',
            showConfirmButton: false,
        });
    });

    it('uses default texts when no options provided', async () => {
        vi.mocked(Swal.fire)
            .mockResolvedValueOnce({ isConfirmed: true } as any)
            .mockResolvedValueOnce({} as any);

        const { confirmDelete } = useConfirmDelete();
        await confirmDelete(() => {});

        expect(vi.mocked(Swal.fire).mock.calls[0][0]).toMatchObject({
            title: 'Eliminar element?',
            text: 'Aquesta acció no es pot desfer.',
        });
    });

    it('uses custom title and text when provided', async () => {
        vi.mocked(Swal.fire)
            .mockResolvedValueOnce({ isConfirmed: true } as any)
            .mockResolvedValueOnce({} as any);

        const { confirmDelete } = useConfirmDelete();
        await confirmDelete(() => {}, {
            title: 'Eliminar activitat?',
            text: 'Text personalitzat',
        });

        expect(vi.mocked(Swal.fire).mock.calls[0][0]).toMatchObject({
            title: 'Eliminar activitat?',
            text: 'Text personalitzat',
        });
    });
});