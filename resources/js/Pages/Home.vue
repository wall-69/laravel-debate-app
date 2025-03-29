<template>
    <div class="min-h-screen flex flex-col">
        <header ref="headerEl" class="sticky z-50 px-8 py-4 rounded-sm top-0">
            <nav
                class="navbar border-base-300 transition-all duration-75 px-4 py-2 rounded-md justify-between"
                :class="{
                    'shadow-xs border-b-4 border-x-2 bg-white':
                        scrollTopY > 150,
                }"
            >
                <RouterLink
                    :to="{ name: 'home' ? authenticated : 'dashboard' }"
                >
                    <Logo></Logo>
                </RouterLink>

                <ul class="flex items-center gap-8">
                    <li v-if="authenticated">
                        <RouterLink :to="{ name: 'argument-new' }">
                            Nový argument
                        </RouterLink>
                    </li>
                    <template v-else>
                        <RouterLink
                            :to="{ name: 'login' }"
                            class="btn btn-secondary"
                        >
                            Prihlásiť sa
                        </RouterLink>
                        <RouterLink
                            :to="{ name: 'register' }"
                            class="btn btn-primary"
                        >
                            Zaregistrovať sa
                        </RouterLink>
                    </template>
                </ul>
            </nav>
        </header>

        <main class="grow flex flex-col">
            <!-- Hero -->
            <section
                class="text-center bg-gradient-to-b from-base-100 to-base-300 p-4 gap-4 flex flex-col items-center justify-center"
                :style="{
                    height: heroSectionHeight,
                }"
            >
                <h2
                    class="font-bold text-primary-content p-4 rounded-sm text-3xl bg-primary"
                >
                    5 minútové argumenty:
                    <span class="text-3xl font-normal"
                        >naučte sa písať argumenty pod tlakom.</span
                    >
                </h2>
                <p
                    id="thesis-animated"
                    class="font-bold bg-secondary text-secondary-content p-8 rounded-sm text-3xl"
                ></p>
                <div class="flex justify-center gap-8">
                    <RouterLink class="btn btn-wide btn-lg btn-primary">
                        Áno!
                    </RouterLink>
                    <RouterLink class="btn btn-wide btn-lg btn-accent">
                        Nie!
                    </RouterLink>
                </div>
            </section>
        </main>
    </div>
</template>
<script setup>
import { computed, onMounted, onUnmounted, ref } from "vue";
import { RouterLink } from "vue-router";
import Logo from "../components/Icons/Logo.vue";
import useAuth from "../composables/useAuth";

// Composables
const { authenticated } = useAuth();

// Lifecycle
onMounted(() => {
    // Typewriter animation
    const typewriter = new Typewriter("#thesis-animated", {
        loop: true,
        delay: 10,
    });

    typewriter
        .typeString(
            "Školy by mali úplne zrušiť známkovanie a hodnotiť študentov iným spôsobom."
        )
        .pauseFor(5000)
        .deleteAll()
        .typeString(
            "Sociálne siete spôsobujú viac škody ako úžitku v modernej spoločnosti."
        )
        .pauseFor(5000)
        .deleteAll()
        .typeString(
            "Pracovný týždeň by mal byť skrátený na štyri dni bez zníženia platu."
        )
        .pauseFor(5000)
        .deleteAll()
        .typeString("Volebné právo by malo byť podmienené testom inteligencie.")
        .pauseFor(5000)
        .start();

    // Scroll event
    window.addEventListener("scroll", onScroll);
});

onUnmounted(() => {
    window.removeEventListener("scroll", onScroll);
});

// Variables
const headerEl = ref(null);
const scrollTopY = ref(0);

// Computed
const heroSectionHeight = computed(() => {
    return (
        "calc(100svh - " +
        (headerEl.value ? headerEl.value.offsetHeight : 0) +
        "px)"
    );
});

// Functions
function onScroll(e) {
    scrollTopY.value = window.top.scrollY;
    console.log(scrollTopY.value);
}
</script>
