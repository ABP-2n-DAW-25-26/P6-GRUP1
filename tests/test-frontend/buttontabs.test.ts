import { mount } from '@vue/test-utils';
import { describe, it, expect } from 'vitest';
import ButtonTabs from '@/components/ButtonTabs.vue';

describe('ButtonTabs component', () => {
    // Emits assign-teacher when teachers tab button is clicked
    it('emits assign-teacher event', async () => {
        const wrapper = mount(ButtonTabs, {
            props: {
                activeTab: 'teachers',
                exchange: { id: 1 },
            },
            global: {
                mocks: {
                    $page: {
                        props: { auth: { user: { id: 1, role: 'admin' } } },
                    },
                },
            },
        });

        await wrapper.find('button').trigger('click');

        expect(wrapper.emitted('assign-teacher')).toBeTruthy();
    });

    // Emits assign-student when students tab button is clicked
    it('emits assign-student event', async () => {
        const wrapper = mount(ButtonTabs, {
            props: {
                activeTab: 'students',
                exchange: { id: 1 },
            },
            global: {
                mocks: {
                    $page: {
                        props: { auth: { user: { id: 1, role: 'admin' } } },
                    },
                },
            },
        });

        await wrapper.find('button').trigger('click');

        expect(wrapper.emitted('assign-student')).toBeTruthy();
    });

    // Shows dropdown when clicking activities button
    it('toggles activities dropdown', async () => {
        const wrapper = mount(ButtonTabs, {
            props: {
                activeTab: 'activities',
                exchange: { id: 1 },
            },
            global: {
                mocks: {
                    $page: {
                        props: { auth: { user: { id: 1, role: 'admin' } } },
                    },
                },
            },
        });

        await wrapper.find('button').trigger('click');

        expect(wrapper.html()).toContain('Nova activitat');
    });
});
