<script setup lang="ts">
import { Form, Head } from '@inertiajs/vue3';
import { Icon } from '@iconify/vue';
import gmailIcon from '@iconify-icons/logos/google-gmail';
import AppNavbar from '@/components/AppNavbar.vue';
import InputError from '@/components/InputError.vue';
import PasswordInput from '@/components/PasswordInput.vue';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Spinner } from '@/components/ui/spinner';
import { store } from '@/routes/login';

defineOptions({ layout: undefined });

defineProps<{
    status?: string;
    canResetPassword: boolean;
}>();
</script>

<template>
    <Head title="Accedir" />

    <div class="min-h-screen bg-hp-bg flex flex-col">
        <AppNavbar />
        <div class="flex flex-1 items-center justify-center p-4">
            <div class="w-full max-w-sm flex flex-col gap-4">

                <div class="bg-hp-bg-card rounded-3xl shadow-lg p-8 flex flex-col gap-6">

                <div class="flex items-center gap-4">
                    <img src="/cendraquest-256.png" alt="CendraQuest" class="w-14 h-14 rounded-full shrink-0" />
                    <div>
                        <p class="text-2xl font-black text-hp-text tracking-wide uppercase">CendraQuest</p>
                        <p class="text-xs font-semibold tracking-widest text-hp-primary uppercase mt-0.5">Institut Cendrassos</p>
                    </div>
                </div>

                <p class="text-sm text-hp-text-dim">Introdueix les teves credencials per accedir</p>

                <div v-if="status" class="text-center text-sm font-medium text-green-600">
                    {{ status }}
                </div>

                <Form
                    v-bind="store.form()"
                    :reset-on-success="['password']"
                    v-slot="{ errors, processing }"
                    class="flex flex-col gap-4"
                >
                    <div>
                        <Input
                            id="email"
                            type="email"
                            name="email"
                            required
                            autofocus
                            :tabindex="1"
                            autocomplete="email"
                            placeholder="Correu electrònic"
                            class="w-full rounded-xl border-hp-border bg-hp-surface px-4 py-3 text-sm"
                        />
                        <InputError :message="errors.email" />
                    </div>

                    <div>
                        <PasswordInput
                            id="password"
                            name="password"
                            required
                            :tabindex="2"
                            autocomplete="current-password"
                            placeholder="Contrasenya"
                            class="w-full rounded-xl border-hp-border bg-hp-surface px-4 py-3 text-sm"
                        />
                        <InputError :message="errors.password" />
                    </div>

                    <div class="flex items-center gap-2">
                        <Checkbox id="remember" name="remember" :tabindex="3" />
                        <label for="remember" class="text-sm text-hp-text-dim cursor-pointer">Recorda'm</label>
                    </div>

                    <button
                        type="submit"
                        :disabled="processing"
                        :tabindex="4"
                        data-test="login-button"
                        class="w-full py-3 rounded-xl bg-hp-primary hover:bg-hp-primary-dark text-white font-semibold text-sm transition flex items-center justify-center gap-2"
                    >
                        <Spinner v-if="processing" />
                        Accedir
                    </button>
                </Form>

                <div class="flex items-center gap-3">
                    <div class="flex-1 h-px bg-hp-border"></div>
                    <span class="text-xs text-hp-text-dim uppercase tracking-widest">O continua amb</span>
                    <div class="flex-1 h-px bg-hp-border"></div>
                </div>

                <a
                    href="/auth/gmail"
                    class="w-full flex items-center justify-center gap-3 py-3 rounded-xl border border-hp-border hover:bg-hp-surface transition text-sm font-medium text-hp-text"
                >
                    <Icon :icon="gmailIcon" class="w-5 h-5" />
                    Continua amb Gmail
                </a>
            </div>
            </div>
        </div>
    </div>
</template>
