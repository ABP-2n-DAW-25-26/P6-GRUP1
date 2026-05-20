import { mount } from '@vue/test-utils';
import { describe, it, expect } from 'vitest';
import Heading from '@/components/Heading.vue';

describe('Heading component', () => {

    // Title prop is rendered inside h2
    it('renders the title prop', () => {
        const wrapper = mount(Heading, {
            props: { title: 'CendraQuest' },
        });
        expect(wrapper.html()).toContain('CendraQuest');
    });

    // Description is visible when the prop is passed
    it('renders the description when provided', () => {
        const wrapper = mount(Heading, {
            props: { title: 'Exchanges', description: 'All available exchanges' },
        });
        const p = wrapper.find('p');
        expect(p.exists()).toBe(true);
        expect(p.text()).toContain('All available exchanges');
    });

    // No description prop means no <p> element is rendered
    it('does not render description when not provided', () => {
        const wrapper = mount(Heading, {
            props: { title: 'No description' },
        });
        expect(wrapper.find('p').exists()).toBe(false);
    });

    // variant prop controls the CSS class applied to h2
    it('applies small variant class when variant is small', async () => {
        const wrapper = mount(Heading, {
            props: { title: 'Small', variant: 'small' },
        });
        const h2 = wrapper.find('h2');
        expect(h2.classes()).toContain('text-base');

        await wrapper.setProps({ variant: 'default' });
        expect(h2.classes()).toContain('text-xl');
    });

});
