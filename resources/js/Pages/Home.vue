<template>
    <div class="flex min-h-screen flex-col">
        <!-- Header -->
        <header ref="headerEl" class="sticky top-0 z-50 rounded-sm px-8 py-4">
            <nav
                class="navbar border-base-300 justify-between rounded-md px-4 py-2 transition-all duration-75"
                :class="{
                    'border-x-2 border-b-4 bg-white shadow-xs':
                        scrollTopY > 150 || windowWidth < 640,
                }"
            >
                <RouterLink
                    :to="{ name: authenticated ? 'dashboard' : 'home' }"
                >
                    <Logo color="primary"></Logo>
                </RouterLink>

                <ul class="hidden items-center gap-8 md:flex">
                    <li v-if="authenticated">
                        <RouterLink
                            :to="{ name: 'argument-new' }"
                            class="btn btn-primary"
                        >
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
                <details
                    class="dropdown dropdown-end block marker:hidden md:hidden"
                >
                    <summary class="btn btn-square btn-primary p-5">
                        <i class="bx bx-menu bx-md"></i>
                    </summary>
                    <ul
                        class="menu dropdown-content bg-base-200 rounded-box z-1 w-52 gap-4 p-2 shadow-sm"
                    >
                        <li v-if="authenticated">
                            <RouterLink
                                :to="{ name: 'argument-new' }"
                                class="btn btn-primary"
                            >
                                Nový argument
                            </RouterLink>
                        </li>
                        <template v-else>
                            <li>
                                <RouterLink
                                    :to="{ name: 'register' }"
                                    class="bg-primary"
                                >
                                    Zaregistrovať sa
                                </RouterLink>
                            </li>
                            <li>
                                <RouterLink
                                    :to="{ name: 'login' }"
                                    class="bg-secondary"
                                >
                                    Prihlásiť sa
                                </RouterLink>
                            </li>
                        </template>
                    </ul>
                </details>
            </nav>
        </header>

        <!-- Main -->
        <main class="flex grow flex-col">
            <!-- Hero -->
            <section
                class="from-base-100 to-base-300 flex flex-col items-center justify-center gap-4 bg-gradient-to-b p-4 text-center"
                :style="{
                    height: heroSectionHeight,
                }"
            >
                <h2
                    class="text-accent-content bg-accent rounded-sm p-4 text-xl font-bold md:text-3xl"
                >
                    5 minútové argumenty:
                    <span class="text-xl font-normal md:text-3xl">
                        naučte sa písať argumenty pod tlakom.
                    </span>
                </h2>
                <p
                    id="thesis-animated"
                    class="bg-secondary text-secondary-content rounded-sm p-4 text-xl font-bold md:p-8 md:text-3xl"
                ></p>

                <RouterLink
                    :to="{ name: 'register' }"
                    class="btn btn-lg btn-primary"
                >
                    Zaregistrovať sa
                </RouterLink>
            </section>

            <!-- Why? -->
            <section
                class="flex flex-col items-center justify-center gap-8 bg-white px-8 py-16"
            >
                <h2 class="text-3xl">Prečo písať argumenty?</h2>

                <ul
                    class="grid grid-cols-1 items-center justify-center gap-8 md:grid-cols-2 xl:grid-cols-4"
                >
                    <li
                        class="card bg-primary text-primary-content h-full w-full shadow-sm"
                    >
                        <div class="card-body">
                            <h2 class="card-title">Kritické myslenie</h2>
                            <p>
                                Schopnosť hľadať súvislosti medzi rôznymi
                                informáciami, usporiadať si myšlienky, odhaliť
                                silné a slabé stránky argumentov a posúdiť ich
                                silu a dôležitosť v kontexte diskusie.
                            </p>
                        </div>
                    </li>

                    <li
                        class="card bg-secondary text-secondary-content h-full w-full shadow-sm"
                    >
                        <div class="card-body">
                            <h2 class="card-title">Argumentačné schopnosti</h2>
                            <p>
                                Schopnosť vysvetliť svoje postoje a názory
                                presvedčivo tak, aby boli zrozumiteľné aj ľuďom
                                s iným pohľadom, schopnosť vyhýbať sa logickým
                                chybám.
                            </p>
                        </div>
                    </li>

                    <li
                        class="card bg-accent text-accent-content h-full w-full shadow-sm"
                    >
                        <div class="card-body">
                            <h2 class="card-title">Mediálna gramotnosť</h2>
                            <p>
                                Návyk overovať informácie z viacerých zdrojov,
                                vyhľadávať pôvod správ, štatistík a fotografií.
                                Schopnosť správne interpretovať dáta a grafy a
                                nepodľahnúť manipuláciám.
                            </p>
                        </div>
                    </li>

                    <li
                        class="card bg-base-300 text-base-bg-base-300-content h-full w-full shadow-sm"
                    >
                        <div class="card-body">
                            <h2 class="card-title">Rozmýšľanie pod nátlakom</h2>
                            <p>
                                Schopnosť jasne formulovať svoje myšlienky a
                                pohoto reagovať. Časové obmedzenie vytvára
                                nátlak, ktorým sa dosiahne kritické myslenie a
                                rozloženie času.
                            </p>
                        </div>
                    </li>
                </ul>
            </section>

            <!-- Pros -->
            <section
                class="bg-base-200 flex flex-col items-center justify-center gap-8 px-8 py-16"
            >
                <h2 class="text-3xl font-bold">Výhody</h2>

                <ul class="flex max-w-lg flex-col gap-4">
                    <li
                        class="collapse-arrow border-base-300 collapse border bg-white"
                    >
                        <input
                            type="radio"
                            name="my-accordion-2"
                            checked="checked"
                        />
                        <div class="collapse-title font-semibold">
                            Len 5 minút!
                        </div>
                        <div class="collapse-content">
                            V dnešnom svete, kde nikto nemá na nič čas a zároveň
                            sa nikomu nič nechce sa tieto dva problémy riešia
                            časovým obmedzením na 5 minút. Keď začneš písať, tak
                            veľmi rýchlo zistíš ako 5 minút je strašne málo času
                            a zároveň dostatok času na napísanie dobrého
                            argumentu.
                        </div>
                    </li>
                    <li
                        class="collapse-arrow border-base-300 collapse border bg-white"
                    >
                        <input type="radio" name="my-accordion-2" />
                        <div class="collapse-title font-semibold">
                            Okamžité ohodnotenie a spätná väzba
                            <span class="text-accent">*</span>
                        </div>
                        <div class="collapse-content">
                            Po dopísaní argumentu bude tvoj argument ohodnotený
                            od 0 do 15 bodov podľa kritérií, ako vysvetlenie,
                            dôkazov a stratégie. Neboj, toto hodnotenie je čisto
                            orientačné a nemal by si si ho brať k srdcu.

                            <br />
                            <br />

                            <span class="text-accent text-sm">
                                *Spätná väzba je tvorená umelou inteligenciou,
                                ktorá môže robiť chyby.
                            </span>
                        </div>
                    </li>
                    <li
                        class="collapse-arrow border-base-300 collapse border bg-white"
                    >
                        <input type="radio" name="my-accordion-2" />
                        <div class="collapse-title font-semibold">
                            Zdieľanie argumentov
                        </div>
                        <div class="collapse-content">
                            Svoje argumenty môžeš zdieľať s kýmkoľvek chceš,
                            nakoľko každý argument je verejne dostupný, ak máš
                            naň odkaz 😊
                        </div>
                    </li>
                </ul>
            </section>
        </main>

        <!-- Footer -->
        <footer
            class="footer sm:footer-horizontal bg-base-300 text-base-300-content p-10"
        >
            <nav>
                <h6 class="footer-title">QuickLogic</h6>
                <RouterLink to="" class="link link-hover">Kontakt</RouterLink>
                <RouterLink to="" class="link link-hover">
                    Podmienky používania
                </RouterLink>
                <RouterLink to="" class="link link-hover">
                    Zásady ochrany osobných údajov
                </RouterLink>

                <p class="mt-4">
                    Copyright © {{ new Date().getFullYear() }} - Tomáš Kriško
                </p>
            </nav>
        </footer>
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
            "Školy by mali úplne zrušiť známkovanie a hodnotiť študentov iným spôsobom.",
        )
        .pauseFor(5000)
        .deleteAll()
        .typeString(
            "Sociálne siete spôsobujú viac škody ako úžitku v modernej spoločnosti.",
        )
        .pauseFor(5000)
        .deleteAll()
        .typeString(
            "Pracovný týždeň by mal byť skrátený na štyri dni bez zníženia platu.",
        )
        .pauseFor(5000)
        .deleteAll()
        .typeString("Volebné právo by malo byť podmienené testom inteligencie.")
        .pauseFor(5000)
        .start();

    // Scroll
    window.addEventListener("scroll", onScroll);

    // Resize
    window.addEventListener("resize", onResize);
    windowWidth.value = window.innerWidth;
});

onUnmounted(() => {
    // Scroll
    window.removeEventListener("scroll", onScroll);

    // Resize
    window.removeEventListener("resize", onResize);
});

// Variables
const headerEl = ref(null);
const scrollTopY = ref(0);
const windowWidth = ref(0);

// Computed
const headerHeight = computed(() => {
    return (headerEl.value ? headerEl.value.offsetHeight : 0) + "px";
});
const heroSectionHeight = computed(() => {
    return (
        "calc(100svh - " +
        (headerEl.value ? headerEl.value.offsetHeight : 0) +
        "px)"
    );
});

// Functions
function onScroll() {
    scrollTopY.value = window.top.scrollY;
}
function onResize() {
    windowWidth.value = window.innerWidth;
}
</script>
