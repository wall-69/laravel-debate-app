<template>
    <div class="flex flex-col items-start gap-8">
        <h1 class="text-primary text-3xl font-bold">Nastavenia</h1>

        <!-- Change email -->
        <div>
            <h2 class="pb-1 text-xl">Zmena emailu</h2>
            <form
                @submit.prevent="changeEmail"
                class="flex flex-wrap items-end gap-4"
            >
                <div>
                    <label class="label">Nový email</label>
                    <input
                        v-model="changeEmailForm.email"
                        type="email"
                        class="input"
                    />
                </div>

                <div>
                    <label class="label">Heslo</label>
                    <input
                        v-model="changeEmailForm.password"
                        type="password"
                        class="input"
                    />
                </div>

                <button type="submit" class="btn">Zmeniť email</button>
            </form>
            <p v-show="changeEmailErrors.email" class="text-error">
                {{ changeEmailErrors.email }}
            </p>
            <p v-show="changeEmailErrors.password" class="text-error">
                {{ changeEmailErrors.password }}
            </p>
            <p v-show="changeEmailSuccess" class="text-success">
                {{ changeEmailSuccess }}
            </p>
        </div>

        <!-- Change password -->
        <div>
            <h2 class="pb-1 text-xl">Zmena hesla</h2>
            <form
                @submit.prevent="changePassword"
                class="flex flex-wrap items-end gap-4"
            >
                <!-- New password -->
                <div>
                    <label class="label">Nové heslo</label>
                    <input
                        v-model="changePasswordForm.new_password"
                        type="password"
                        class="input"
                    />
                </div>

                <!-- Password -->
                <div>
                    <label class="label">Heslo</label>
                    <input
                        v-model="changePasswordForm.password"
                        type="password"
                        class="input"
                    />
                </div>

                <button type="submit" class="btn">Zmeniť heslo</button>
            </form>
            <p v-show="changePasswordErrors.new_password" class="text-error">
                {{ changePasswordErrors.new_password }}
            </p>
            <p v-show="changePasswordErrors.password" class="text-error">
                {{ changePasswordErrors.password }}
            </p>
            <p v-show="changePasswordSuccess" class="text-success">
                {{ changePasswordSuccess }}
            </p>
        </div>

        <!-- Delete account -->
        <div>
            <h2 class="pb-1 text-xl">Vymazať účet</h2>
            <form
                @submit.prevent="deleteAccount"
                class="flex flex-wrap items-end gap-4"
            >
                <!-- Password -->
                <div>
                    <label class="label">Heslo</label>
                    <input
                        v-model="deleteAccountForm.password"
                        type="password"
                        class="input"
                    />
                </div>

                <button type="submit" class="btn btn-error">
                    Vymazať účet
                </button>
            </form>
            <p v-show="deleteAccountErrors.password" class="text-error">
                {{ deleteAccountErrors.password }}
            </p>
        </div>
    </div>
</template>
<script setup>
import axios from "axios";
import { inject, reactive, ref } from "vue";
import { handleFormErrors } from "../../utils/errorHandler";
import useAuth from "../../composables/useAuth";
import router from "../../router";

// Composables
const { setAuthenticated, setUser } = useAuth();

// Define
const user = inject("user");

// Variables
const changeEmailForm = reactive({
    _method: "PATCH",
    email: "",
    password: "",
});
const changePasswordForm = reactive({
    _method: "PATCH",
    new_password: "",
    password: "",
});
const deleteAccountForm = reactive({
    _method: "DELETE",
    password: "",
});

const changeEmailErrors = reactive({
    email: "",
    password: "",
});
const changePasswordErrors = reactive({
    new_password: "",
    password: "",
});
const deleteAccountErrors = reactive({
    password: "",
});

const changeEmailSuccess = ref("");
const changePasswordSuccess = ref("");

// Functions
async function changeEmail() {
    Object.keys(changeEmailErrors).forEach((key) => {
        changeEmailErrors[key] = "";
    });
    changeEmailSuccess.value = "";

    // PATCH request to API
    await axios
        .post("/api/users/" + user.id, changeEmailForm)
        .then((response) => {
            setUser(response.data);
            changeEmailSuccess.value = "Email bol úspešne zmenený.";
            changeEmailForm.password = "";
        })
        .catch((err) => {
            handleFormErrors(changeEmailErrors, err.response.data.errors || {});
            changeEmailSuccess.value = "";
        });
}

async function changePassword() {
    Object.keys(changePasswordErrors).forEach((key) => {
        changePasswordErrors[key] = "";
    });
    changePasswordSuccess.value = "";

    // PATCH request to API
    await axios
        .post("/api/users/" + user.id, changePasswordForm)
        .then((response) => {
            setUser(response.data);
            changePasswordSuccess.value = "Heslo bolo úspešne zmenené.";
            changePasswordForm.password = "";
        })
        .catch((err) => {
            handleFormErrors(
                changePasswordErrors,
                err.response.data.errors || {},
            );
            changePasswordSuccess.value = "";
        });
}

async function deleteAccount() {
    Object.keys(deleteAccountErrors).forEach((key) => {
        deleteAccountErrors[key] = "";
    });

    // DELETE request to API
    await axios
        .post("/api/users/" + user.id, deleteAccountForm)
        .then((response) => {
            // Logout the user in frontend
            setAuthenticated(false);
            setUser({});

            // Redirect to home
            router.push({ name: "home" });
        })
        .catch((err) => {
            handleFormErrors(
                deleteAccountErrors,
                err.response.data.errors || {},
            );
        });
}
</script>
