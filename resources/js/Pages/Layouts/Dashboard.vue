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
                    <details>
                        <summary><i class="bx bx-history"></i>História</summary>
                        <ul>
                            <li>
                                <RouterLink :to="{ name: 'home' }"
                                    >Argument #1</RouterLink
                                >
                            </li>
                            <li>
                                <RouterLink :to="{ name: 'home' }"
                                    >Argument #2</RouterLink
                                >
                            </li>
                        </ul>
                    </details>
                </li>
                <li>
                    <RouterLink :to="{ name: 'home' }">
                        <i class="bx bxs-cog"></i>Nastavenia
                    </RouterLink>
                </li>
                <li>
                    <RouterLink :to="{ name: 'home' }">
                        <i class="bx bxs-log-out"></i>Odhlásiť sa
                    </RouterLink>
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
</script>
