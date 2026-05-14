<script setup lang="ts">
import { Icon } from '@iconify/vue';
import gmailIcon from '@iconify-icons/logos/google-gmail';
import { Form, Head } from '@inertiajs/vue3';
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

    <div class="flex min-h-screen flex-col bg-hp-bg">
        <AppNavbar />
        <div class="flex flex-1 items-center justify-center p-4">
            <div class="flex w-full max-w-sm flex-col gap-4">
                <div
                    class="flex flex-col gap-6 rounded-3xl bg-hp-bg-card p-8 shadow-lg"
                >
                    <div class="flex items-center gap-4">
                        <img
                            src="/cendraquest-256.png"
                            alt="CendraQuest"
                            class="h-14 w-14 shrink-0 rounded-full"
                        />
                        <div>
                            <p
                                class="text-2xl font-black tracking-wide text-hp-text uppercase"
                            >
                                CendraQuest
                            </p>
                            <p
                                class="mt-0.5 text-xs font-semibold tracking-widest text-hp-primary uppercase"
                            >
                                Institut Cendrassos
                            </p>
                        </div>
                    </div>

                    <p class="text-sm text-hp-text-dim">
                        Introdueix les teves credencials per accedir
                    </p>

                    <div
                        v-if="status"
                        class="text-center text-sm font-medium text-green-600"
                    >
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
                            <Checkbox
                                id="remember"
                                name="remember"
                                :tabindex="3"
                            />
                            <label
                                for="remember"
                                class="cursor-pointer text-sm text-hp-text-dim"
                                >Recorda'm</label
                            >
                        </div>

                        <button
                            type="submit"
                            :disabled="processing"
                            :tabindex="4"
                            data-test="login-button"
                            class="flex w-full items-center justify-center gap-2 rounded-xl bg-hp-primary py-3 text-sm font-semibold text-white transition hover:bg-hp-primary-dark"
                        >
                            <Spinner v-if="processing" />
                            Accedir
                        </button>
                    </Form>

                    <div class="flex items-center gap-3">
                        <div class="h-px flex-1 bg-hp-border"></div>
                        <span
                            class="text-xs tracking-widest text-hp-text-dim uppercase"
                            >O continua amb</span
                        >
                        <div class="h-px flex-1 bg-hp-border"></div>
                    </div>

                    <a
                        href="/auth/gmail"
                        class="flex w-full items-center justify-center gap-3 rounded-xl border border-hp-border py-3 text-sm font-medium text-hp-text transition hover:bg-hp-surface"
                    >
                        <Icon :icon="gmailIcon" class="h-5 w-5" />
                        Continua amb Gmail
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>
