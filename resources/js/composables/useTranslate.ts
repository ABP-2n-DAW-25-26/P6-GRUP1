import { router } from '@inertiajs/vue3';
import { ref } from 'vue';

let savedNodes: { node: Text; originalText: string }[] = [];
export const currentLang = ref('ca');

function getCsrf(): string {
    const meta = document.querySelector('meta[name="csrf-token"]') as HTMLMetaElement | null;

    return meta?.content ?? '';
}

// Tags whose content is code, styles or form values should never be translated
const SKIP_TAGS = ['SCRIPT', 'STYLE', 'SELECT', 'OPTION'];

function isTranslatable(text: string, tag: string): boolean {
    if (text.length < 2) {
return false;
}

    if (SKIP_TAGS.includes(tag)) {
return false;
}

    return true;
}

// Collects all visible text nodes from the page
function getTextNodes(): Text[] {
    const root = document.getElementById('app') ?? document.body;
    const walker = document.createTreeWalker(root, 4);
    const nodes: Text[] = [];
    let node: Node | null;

    while ((node = walker.nextNode())) {
        const text = node.textContent?.trim() ?? '';
        const tag = node.parentElement?.tagName ?? '';

        if (isTranslatable(text, tag)) {
            nodes.push(node as Text);
        }
    }

    return nodes;
}

function restoreOriginals() {
    for (const item of savedNodes) {
        item.node.textContent = item.originalText;
    }

    savedNodes = [];
}

// Sends texts to the backend, applies returned translations to the DOM
async function applyTranslation(lang: string) {
    const nodes = getTextNodes();

    if (nodes.length === 0) {
return;
}

    const texts = nodes.map(n => n.textContent!);
    const url = window.location.pathname;

    const response = await fetch('/api/translate', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': getCsrf(),
        },
        body: JSON.stringify({ texts, lang, url }),
    });

    const translations: Record<string, string> = await response.json();

    for (const node of nodes) {
        const translation = translations[node.textContent!];

        if (translation && translation !== node.textContent) {
            savedNodes.push({ node, originalText: node.textContent! });
            node.textContent = translation;
        }
    }
}

// Public function used by the language selector
export async function translatePage(lang: string) {
    restoreOriginals();
    currentLang.value = lang;

    if (lang === 'ca') {
return;
}

    await applyTranslation(lang);
}

// Re-translate after an Inertia navigation
router.on('navigate', () => {
    if (currentLang.value === 'ca') {
return;
}

    restoreOriginals();
    setTimeout(() => applyTranslation(currentLang.value), 150);
});

// Re-translate when Vue updates the DOM
let timer: ReturnType<typeof setTimeout> | null = null;

function onDomChange() {
    if (currentLang.value === 'ca') {
return;
}

    if (timer) {
clearTimeout(timer);
}

    timer = setTimeout(() => {
        restoreOriginals();
        applyTranslation(currentLang.value);
    }, 300);
}

new MutationObserver(onDomChange).observe(
    document.getElementById('app') ?? document.body,
    { childList: true, subtree: true },
);