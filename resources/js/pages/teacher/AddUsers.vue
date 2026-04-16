<script setup lang="ts">
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';

const fileInput = ref<HTMLInputElement>();
const selectedFile = ref<File | null>(null);
const isLoading = ref(false);
const error = ref('');

const selectFile = () => {
    fileInput.value?.click();
};

const handleFileSelect = (event: Event) => {
    const target = event.target as HTMLInputElement;
    if (target.files?.length) {
        selectedFile.value = target.files[0];
        error.value = '';
    }
};

const submit = () => {
    if (!selectedFile.value) {
        error.value = 'Por favor selecciona un archivo CSV';
        return;
    }

    isLoading.value = true;
    const formData = new FormData();
    formData.append('import_csv', selectedFile.value);

router.post('/import-csv', formData, {
    forceFormData: true,
            onSuccess: () => {
            selectedFile.value = null;
            if (fileInput.value) {
                fileInput.value.value = '';
            }
            error.value = '';
        },
        onError: (errors) => {
            error.value = errors.import_csv || 'Error al importar el archivo';
        },
        onFinish: () => {
            isLoading.value = false;
        },
    });
};
</script>

<template>
    <div>
        <div>
            <h2 class="text-2xl">Importar usuarios con CSV</h2>

            <form @submit.prevent="submit" class="space-y-4">
                <div>
                    <input
                        ref="fileInput"
                        type="file"
                        accept=".csv,.txt"
                        class="hidden"
                        @change="handleFileSelect"
                    />
                    
                    <div>
                        <p >
                            {{ selectedFile?.name || 'Selecciona un archivo CSV' }}
                        </p>
                        <button
                            class="bg-blue-400 rounded-2xl w-40"
                            type="button"
                            @click="selectFile"
                        >
                            Elegir archivo
                        </button>
                    </div>
                </div>

                <button
                    type="submit"
                    :disabled="!selectedFile"
                >
                    {{ 'Importar CSV' }}
                </button>
            </form>

            <div>
                <p>
                    <strong>Formato esperado:</strong><br>
                    nombre,apellido,email<br>
                    uan,Pérez,juan@example.com
                </p>
            </div>
        </div>
    </div>
</template>