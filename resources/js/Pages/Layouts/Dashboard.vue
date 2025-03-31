<template>
    <main class="drawer md:drawer-open grow">
        <!-- Hidden drawer checkbox -->
        <input
            id="sidebar"
            type="checkbox"
            class="drawer-toggle"
            v-model="sidebarOpened"
        />

        <!-- Page -->
        <div class="drawer-content flex grow flex-col">
            <!-- Header -->
            <header class="bg-secondary p-4 md:hidden">
                <nav class="flex items-center justify-between">
                    <RouterLink
                        :to="{ name: authenticated ? 'home' : 'dashboard' }"
                    >
                    </RouterLink>

                    <button
                        @click="sidebarOpened = !sidebarOpened"
                        class="btn btn-square p-5"
                    >
                        <i class="bx bx-menu bx-md"></i>
                    </button>
                </nav>
            </header>

            <!-- Dashboard content -->
            <div class="grow p-8">
                <slot></slot>
            </div>

            <!-- Footer -->
            <footer
                class="footer sm:footer-horizontal footer-center bg-base-300 text-base-content p-4"
            >
                <p>
                    Copyright © {{ new Date().getFullYear() }} - Tomáš Kriško
                </p>
            </footer>
        </div>

        <!-- Sidebar -->
        <div class="drawer-side">
            <label
                for="sidebar"
                aria-label="close sidebar"
                class="drawer-overlay"
            ></label>
            <ul class="menu bg-base-200 min-h-full w-56 pt-8 text-lg">
                <li>
                    <RouterLink
                        :to="{ name: 'dashboard' }"
                        @click="sidebarOpened = !sidebarOpened"
                    >
                        <i class="bx bx-home"></i>Domov
                    </RouterLink>
                </li>
                <li>
                    <details v-if="args.length > 0">
                        <summary><i class="bx bx-history"></i>História</summary>
                        <ul>
                            <li v-for="arg in args">
                                <RouterLink
                                    :to="{
                                        name: 'argument-show',
                                        params: { id: arg.ulid },
                                    }"
                                    @click="sidebarOpened = !sidebarOpened"
                                    class="text-xs"
                                >
                                    {{ arg.thesis.content }}
                                </RouterLink>
                            </li>
                        </ul>
                    </details>
                    <p v-else><i class="bx bx-history"></i>História</p>
                </li>
                <li>
                    <RouterLink
                        :to="{ name: 'settings' }"
                        @click="sidebarOpened = !sidebarOpened"
                    >
                        <i class="bx bxs-cog"></i>Nastavenia
                    </RouterLink>
                </li>
                <li>
                    <button @click="handleLogout">
                        <i class="bx bxs-log-out"></i>Odhlásiť sa
                    </button>
                </li>

                <!-- Admin -->
                <template v-if="user.admin">
                    <li class="menu-title">Admin</li>
                    <li>
                        <RouterLink
                            :to="{ name: 'admin-statistics' }"
                            @click="sidebarOpened = !sidebarOpened"
                        >
                            <i class="bx bx-trending-up"></i>Štatistiky
                        </RouterLink>
                    </li>
                    <li>
                        <RouterLink
                            :to="{ name: 'admin-theses' }"
                            @click="sidebarOpened = !sidebarOpened"
                        >
                            <i class="bx bx-text"></i>Tézy
                        </RouterLink>
                    </li>
                </template>
            </ul>
        </div>
    </main>
</template>
<script setup>
import Logo from "../../components/Icons/Logo.vue";
import { RouterLink } from "vue-router";
import useAuth from "../../composables/useAuth";
import { ref, onMounted } from "vue";
import axios from "axios";
import { provide } from "vue";

// Composables
const { user, logout } = useAuth();

// Define
provide("user", user.value);

// Lifecycle
onMounted(async () => {
    loadArguments();
});

// Variables
const sidebarOpened = ref(false);
const args = ref([]);

// Functions
async function handleLogout() {
    await logout();
}

async function loadArguments() {
    await axios
        .get("/api/arguments")
        .then((response) => {
            args.value = response.data;
        })
        .catch((err) => {
            args.value = [];
        });
}
</script>
<style scoped>
.hideAfter {
    content: "";
}
</style>
