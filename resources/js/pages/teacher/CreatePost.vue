<script setup lang="ts">
import { Form } from '@inertiajs/vue3';
import Quill from 'quill';
import { ref, onBeforeUnmount, onMounted } from 'vue';
import { store } from '@/routes/exchange/post';
import 'quill/dist/quill.snow.css';

const props = defineProps<{
  exchangeId: number
}>()

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

const fileInput = ref<HTMLInputElement | null>(null)
const selectedFiles = ref<File[]>([])
const previews = ref<string[]>([])
const editorRef = ref<HTMLDivElement | null>(null)
const description = ref('')
let quill: Quill | null = null

const fileSignature = (file: File) => `${file.name}-${file.size}-${file.lastModified}`

const refreshPreviews = () => {
  previews.value.forEach((url) => URL.revokeObjectURL(url))
  previews.value = selectedFiles.value.map((file) => URL.createObjectURL(file))
}

const handleFileChange = (event: Event) => {
  const input = event.target as HTMLInputElement

  if (!input.files || input.files.length === 0) {
    return
  }

  const existingSignatures = new Set(selectedFiles.value.map((file) => fileSignature(file)))
  const incomingFiles = Array.from(input.files)

  incomingFiles.forEach((file) => {
    const signature = fileSignature(file)

    if (!existingSignatures.has(signature)) {
      selectedFiles.value.push(file)
      existingSignatures.add(signature)
    }
  })

  const dataTransfer = new DataTransfer()
  selectedFiles.value.forEach((file) => dataTransfer.items.add(file))
  input.files = dataTransfer.files

  refreshPreviews()
}

onMounted(() => {
  if (!editorRef.value) {
    return
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
  })

  quill.on('text-change', () => {
    if (!quill) {
      return
    }

    const html = quill.root.innerHTML
    description.value = html === '<p><br></p>' ? '' : html
  })
})

onBeforeUnmount(() => {
  previews.value.forEach((url) => URL.revokeObjectURL(url))
  quill = null
})
</script>
<template>
  <div class="sm:min-h-screen lg:min-h-screen flex pt-6 justify-center">
    <div class="w-full max-w-md">

      <div class="mb-7 text-center">
        <h1 class="font-hp text-6xl text-hp-primary">Anunci</h1>
      </div>

      <!-- Card -->
      <div class="">
        <Form :action="store({ exchange: props.exchangeId })" method="post" enctype="multipart/form-data" class="space-y-5">
          <!-- Títol -->
          <div>
            <label class="text-sm font-medium text-hp-text">Títol</label>
            <input type="text" name="title" placeholder="Anunci..."
              class="mt-1 w-full px-3 py-2 text-sm border rounded-md focus:outline-none focus:ring-2 focus:ring-teal-400 dark:bg-gray-900 dark:border-gray-700 dark:text-white" />
          </div>

          <!-- Descripció -->
          <div>
            <label class="text-sm font-medium text-hp-text">Descripció</label>
            <div class="quill-wrapper mt-1">
              <div ref="editorRef" class="quill-container"></div>
            </div>
            <input type="hidden" name="description" :value="description" />
          </div>

          <!-- Dates -->
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <div>
              <label class="text-sm font-medium text-hp-text">Comença</label>
              <input type="datetime-local" name="start_date"
                class="mt-1 w-full px-3 py-2 rounded-md border bg-hp-bg border-hp-bg-icon text-sm focus:outline-none focus:ring-2 focus:ring-teal-400" />
            </div>

            <div>
              <label class="text-sm font-medium text-hp-text">Acaba</label>
              <input type="datetime-local" name="end_date"
                class="mt-1 w-full px-3 py-2 rounded-md border bg-hp-bg border-hp-bg-icon text-sm focus:outline-none focus:ring-2 focus:ring-teal-400" />
            </div>
          </div>
          <!-- Imatge -->
          <div>
            <label class="mb-3 block text-sm font-medium text-hp-text">
              Imatge
            </label>
            <label
              class="flex flex-col items-center justify-center w-full h-40 border-2 border-dashed border-teal-300 rounded-2xl cursor-pointer hover:border-teal-500 hover:bg-teal-50 transition">
              <span class="text-sm text-gray-600">Fes clic per pujar una o més imatges</span>
              <input ref="fileInput" type="file" name="files[]" placeholder="" class="hidden" accept="image/*" multiple @change="handleFileChange" />
            </label>
            <!-- Preview -->
            <div v-if="previews.length" class="mt-4 grid grid-cols-2 gap-3">
              <img v-for="(preview, index) in previews" :key="`${preview}-${index}`" :src="preview" :alt="`Preview ${index + 1}`"
                class="w-full h-32 object-contain rounded-2xl border border-hp-primary shadow-[inset_0_0_20px_5px_rgba(0,0,0,0.3)] inset-shadow-lg shadow-hp-primary bg-hp-primary/30 p-1" />
            </div>
          </div>

          <!-- Botó enviar -->
          <div class="flex gap-3 pt-2 w-full">
            <button type="button" class="flex-1 py-2 rounded-md border border-hp-bg-icon text-sm">
              Cancel·lar
            </button>
            <button type="submit" class="flex-1 py-2 rounded-md bg-hp-primary hover:bg-teal-300 text-sm font-semibold">
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