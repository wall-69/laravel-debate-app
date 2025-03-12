<template>
    <main class="flex grow">
        <!-- Sidebar -->
        <aside class="bg-base-200 flex flex-col">
            <ul class="h-full menu w-56 mt-8 text-lg">
                <li>
                    <RouterLink :to="{ name: 'dashboard' }">
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
                    <RouterLink :to="{ name: 'settings' }">
                        <i class="bx bxs-cog"></i>Nastavenia
                    </RouterLink>
                </li>
                <li>
                    <button @click="handleLogout">
                        <i class="bx bxs-log-out"></i>Odhlásiť sa
                    </button>
                </li>
            </ul>
        </aside>

        <div class="p-8 grow">
            <slot></slot>
        </div>
    </main>

    <footer
        class="footer sm:footer-horizontal footer-center bg-base-300 text-base-content p-4"
    >
        <p>Copyright © {{ new Date().getFullYear() }} - Tomáš Kriško</p>
    </footer>
</template>
<script setup>
import { RouterLink } from "vue-router";
import useAuth from "../../composables/useAuth";
import { ref, onMounted } from "vue";
import axios from "axios";

// Composables
const { logout } = useAuth();

// Lifecycle
onMounted(async () => {
    loadArguments();
});

// Variables
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
