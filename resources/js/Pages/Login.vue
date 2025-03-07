<template>
    <div class="grow flex flex-col items-center gap-4 justify-center">
        <h2 class="text-primary text-3xl font-bold">Prihláste sa</h2>
        <form
            @submit.prevent="handleSubmit"
            class="fieldset w-xs bg-base-200 p-4 rounded-box"
        >
            <!-- Email -->
            <label class="fieldset-label">Email</label>
            <input
                v-model="form.email"
                type="email"
                class="input"
                placeholder="Email"
            />
            <p v-show="errors.email" class="text-error">{{ errors.email }}</p>

            <!-- Password -->
            <label class="fieldset-label">Heslo</label>
            <input
                v-model="form.password"
                type="password"
                class="input"
                placeholder="Heslo"
            />
            <p v-show="errors.password" class="text-error">
                {{ errors.password }}
            </p>

            <button type="submit" class="btn btn-neutral mt-4">
                Prihlásiť sa
            </button>

            <p class="mt-2 text-sm">
                Nemáte účet?
                <RouterLink
                    :to="{ name: 'register' }"
                    class="font-bold link link-accent"
                >
                    Registrovať sa.
                </RouterLink>
            </p>
        </form>
    </div>
</template>
<script setup>
import { RouterLink } from "vue-router";
import { reactive } from "vue";
import useAuth from "../composables/useAuth";

// Composables
const { login } = useAuth();

// Variables
const form = reactive({
    email: "",
    password: "",
});
const errors = reactive({
    email: "",
    password: "",
});

// Functions
async function handleSubmit() {
    Object.keys(form).forEach((key) => {
        errors[key] = "";
    });

    await login(form, errors);
}
</script>
