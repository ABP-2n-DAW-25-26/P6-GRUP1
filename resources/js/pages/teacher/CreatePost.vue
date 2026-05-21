<script setup lang="ts">
import { Form } from '@inertiajs/vue3';
import Quill from 'quill';
import { ref, onBeforeUnmount, onMounted } from 'vue';
import { store } from '@/routes/exchange/post';
import 'quill/dist/quill.snow.css';

const props = defineProps<{
    exchangeId: number;
}>();

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Crear una activitat',
                // href: schedule(),
            },
        ],
    },
});

const fileInput = ref<HTMLInputElement | null>(null);
const selectedFiles = ref<File[]>([]);
const previews = ref<string[]>([]);
const editorRef = ref<HTMLDivElement | null>(null);
const description = ref('');
let quill: Quill | null = null;

const fileSignature = (file: File) =>
    `${file.name}-${file.size}-${file.lastModified}`;

const refreshPreviews = () => {
    previews.value.forEach((url) => URL.revokeObjectURL(url));
    previews.value = selectedFiles.value.map((file) =>
        URL.createObjectURL(file),
    );
};

const handleFileChange = (event: Event) => {
    const input = event.target as HTMLInputElement;

    if (!input.files || input.files.length === 0) {
        return;
    }

    const existingSignatures = new Set(
        selectedFiles.value.map((file) => fileSignature(file)),
    );
    const incomingFiles = Array.from(input.files);

    incomingFiles.forEach((file) => {
        const signature = fileSignature(file);

        if (!existingSignatures.has(signature)) {
            selectedFiles.value.push(file);
            existingSignatures.add(signature);
        }
    });

    const dataTransfer = new DataTransfer();
    selectedFiles.value.forEach((file) => dataTransfer.items.add(file));
    input.files = dataTransfer.files;

    refreshPreviews();
};

onMounted(() => {
    if (!editorRef.value) {
        return;
    }

    quill = new Quill(editorRef.value, {
        theme: 'snow',
        placeholder: "Explica l'anunci aquí...",
        modules: {
            toolbar: [
                ['bold', 'italic', 'underline'],
                [{ list: 'ordered' }, { list: 'bullet' }],
                ['link'],
            ],
        },
    });

    quill.on('text-change', () => {
        if (!quill) {
            return;
        }

        const html = quill.root.innerHTML;
        description.value = html === '<p><br></p>' ? '' : html;
    });
});

onBeforeUnmount(() => {
    previews.value.forEach((url) => URL.revokeObjectURL(url));
    quill = null;
});
</script>

<template>
    <div class="flex justify-center pt-6 sm:min-h-screen lg:min-h-screen">
        <div class="w-full max-w-md">
            <div class="mb-6 text-center">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                    Crea un anunci
                </h1>

                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Completa la informació per crear una nova activitat
                </p>
            </div>

            <div class="">
                <Form
                    :action="store({ exchange: props.exchangeId })"
                    method="post"
                    enctype="multipart/form-data"
                    class="space-y-5"
                >
                    <div>
                        <label
                            for="title"
                            class="text-sm font-medium text-hp-text"
                        >
                            Títol
                        </label>

                        <input
                            id="title"
                            type="text"
                            name="title"
                            placeholder="Anunci..."
                            autocomplete="off"
                            class="mt-1 w-full rounded-md border px-3 py-2 text-sm focus:ring-2 focus:ring-teal-400 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white"
                        />
                    </div>

                    <div>
                        <label
                            for="description"
                            class="text-sm font-medium text-hp-text"
                        >
                            Descripció
                        </label>

                        <div class="quill-wrapper mt-1">
                            <div
                                id="description"
                                ref="editorRef"
                                class="quill-container"
                                role="textbox"
                                aria-multiline="true"
                                aria-label="Descripció de l'anunci"
                            ></div>
                        </div>

                        <input
                            type="hidden"
                            name="description"
                            :value="description"
                        />
                    </div>

                    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                        <div>
                            <label
                                for="start_date"
                                class="text-sm font-medium text-hp-text"
                            >
                                Comença
                            </label>

                            <input
                                id="start_date"
                                type="datetime-local"
                                name="start_date"
                                class="mt-1 w-full rounded-md border border-hp-bg-icon bg-hp-bg px-3 py-2 text-sm focus:ring-2 focus:ring-teal-400 focus:outline-none"
                            />
                        </div>

                        <div>
                            <label
                                for="end_date"
                                class="text-sm font-medium text-hp-text"
                            >
                                Acaba
                            </label>

                            <input
                                id="end_date"
                                type="datetime-local"
                                name="end_date"
                                class="mt-1 w-full rounded-md border border-hp-bg-icon bg-hp-bg px-3 py-2 text-sm focus:ring-2 focus:ring-teal-400 focus:outline-none"
                            />
                        </div>
                    </div>

                    <div>
                        <label
                            for="files"
                            class="mb-3 block text-sm font-medium text-hp-text"
                        >
                            Imatge
                        </label>

                        <label
                            for="files"
                            class="flex h-40 w-full cursor-pointer flex-col items-center justify-center rounded-2xl border-2 border-dashed border-teal-300 transition hover:border-teal-500 hover:bg-teal-50"
                        >
                            <span class="text-sm text-gray-600">
                                Fes clic per pujar una o més imatges
                            </span>

                            <input
                                id="files"
                                ref="fileInput"
                                type="file"
                                name="files[]"
                                placeholder=""
                                class="hidden"
                                accept="image/*"
                                multiple
                                aria-label="Pujar imatges"
                                @change="handleFileChange"
                            />
                        </label>

                        <div
                            v-if="previews.length"
                            class="mt-4 grid grid-cols-2 gap-3"
                        >
                            <img
                                v-for="(preview, index) in previews"
                                :key="`${preview}-${index}`"
                                :src="preview"
                                :alt="`Vista prèvia imatge ${index + 1}`"
                                class="inset-shadow-lg h-32 w-full rounded-2xl border border-hp-primary bg-hp-primary/30 object-contain p-1 shadow-[inset_0_0_20px_5px_rgba(0,0,0,0.3)] shadow-hp-primary"
                            />
                        </div>
                    </div>

                    <div class="flex w-full gap-3 pt-2">
                        <button
                            type="button"
                            aria-label="Cancel·lar creació activitat"
                            class="flex-1 rounded-md border border-hp-bg-icon py-2 text-sm"
                        >
                            Cancel·lar
                        </button>
                        <button
                            type="submit"
                            aria-label="Crear activitat"
                            class="flex-1 rounded-md bg-hp-primary py-2 text-sm font-semibold hover:bg-teal-300"
                        >
                            Crear Activitat
                        </button>
                    </div>
                </Form>
            </div>
        </div>
    </div>
</template>

<style>
.quill-wrapper {
    overflow: hidden;
    border-radius: 0.5rem;
    border: 1px solid var(--hp-bg-icon, #d1d5db);
}

.quill-container {
    min-height: 100px;
    max-height: 220px;
    overflow-y: auto;
    background: var(--hp-bg, #f8fafc);
    color: var(--hp-text, #0f172a);
}

.ql-toolbar.ql-snow {
    background: var(--hp-bg-card, #ffffff);
    border: none;
    border-bottom: 1px solid var(--hp-bg-icon, #d1d5db);
}

.ql-container.ql-snow {
    border: none;
}

.ql-toolbar button .ql-stroke {
    stroke: var(--hp-text-dim, #64748b);
}

.ql-toolbar button:hover .ql-stroke,
.ql-toolbar button.ql-active .ql-stroke {
    stroke: var(--hp-primary, #14b8a6);
}

.ql-toolbar button .ql-fill {
    fill: var(--hp-text-dim, #64748b);
}

.ql-toolbar button:hover .ql-fill,
.ql-toolbar button.ql-active .ql-fill {
    fill: var(--hp-primary, #14b8a6);
}

.ql-snow .ql-editor.ql-blank::before {
    color: var(--hp-text-dim, #64748b);
}
</style>
