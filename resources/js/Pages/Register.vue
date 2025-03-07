<template>
    <div class="grow flex flex-col items-center gap-4 justify-center">
        <h2 class="text-primary text-3xl font-bold">Zaregistrujte sa</h2>
        <form
            @submit.prevent="handleSubmit"
            class="fieldset w-xs bg-base-200 p-4 rounded-box"
        >
            <!-- Name -->
            <label class="fieldset-label">Meno</label>
            <input
                v-model="form.name"
                type="text"
                class="input"
                placeholder="Meno"
            />
            <p v-show="errors.name" class="text-error">{{ errors.name }}</p>

            <!-- Surname -->
            <label class="fieldset-label">Priezvisko</label>
            <input
                v-model="form.surname"
                type="text"
                class="input"
                placeholder="Priezvisko"
            />
            <p v-show="errors.surname" class="text-error">
                {{ errors.surname }}
            </p>

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

            <!-- Password confirmation -->
            <label class="fieldset-label">Potvrďte heslo</label>
            <input
                v-model="form.password_confirmation"
                type="password"
                class="input"
                placeholder="Potvrďte heslo"
            />
            <p v-show="errors.password_confirmation" class="text-error">
                {{ errors.password_confirmation }}
            </p>

            <!-- TOS -->
            <label class="fieldset-label">
                <input v-model="form.tos" type="checkbox" class="w-4 h-4" />
                Súhlasím s podmienkami používania
            </label>
            <p v-show="errors.tos" class="text-error">{{ errors.tos }}</p>

            <button type="submit" class="btn btn-neutral mt-4">
                Registrovať
            </button>

            <p class="mt-2 text-sm">
                Už máte účet?
                <RouterLink
                    :to="{ name: 'login' }"
                    class="font-bold link link-accent"
                >
                    Prihlásiť sa.
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
const { register } = useAuth();

// Variables
const form = reactive({
    name: "",
    surname: "",
    email: "",
    password: "",
    password_confirmation: "",
    tos: false,
});
const errors = reactive({
    name: "",
    surname: "",
    email: "",
    password: "",
    password_confirmation: "",
    tos: "",
});

// Functions
async function handleSubmit() {
    Object.keys(form).forEach((key) => {
        errors[key] = "";
    });

    await register(form, errors);
}
</script>
