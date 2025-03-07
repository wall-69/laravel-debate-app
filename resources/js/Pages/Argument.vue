<template>
    <div class="flex items-center justify-center p-8 grow gap-8 flex-col">
        <div class="p-4 bg-base-300 w-xl rounded-sm">
            <template v-if="Object.keys(arg).length != 0">
                <h1 class="text-2xl font-bold text-primary">Argument</h1>
                <h2 class="text-lg">
                    <span class="text-secondary font-bold">Téza:</span>
                    {{ arg.thesis.content }}
                </h2>
                <h3 class="text-secondary text-lg font-bold">Argument:</h3>
                <p>
                    {{ arg.content }}
                </p>
            </template>
            <div v-show="error">
                {{ error }}
            </div>
        </div>
        <div
            v-if="Object.keys(arg).length != 0"
            class="bg-primary p-4 text-primary-content rounded-sm w-xl"
        >
            <div v-html="arg.judgement.content" class="judgement"></div>
        </div>

        <div class="bg-base-100 flex flex-col gap-4">
            <h2 class="text-center text-2xl font-bold text-primary">
                Skús si napísať argument aj ty!
            </h2>
            <div class="flex gap-4">
                <button class="btn btn-primary">
                    <RouterLink :to="{ name: 'argument-new' }">
                        Nový argument
                    </RouterLink>
                </button>

                <button class="btn btn-secondary">
                    <a
                        href="http://www.okm.sk/kurzy/argumentacne-zrucnosti/#/"
                        target="_blank"
                    >
                        Ako napísať dobrý argument?
                    </a>
                </button>

                <button class="btn btn-secondary">
                    <a
                        href="http://www.okm.sk/kurzy/argumentacne-chyby-a-fauly/#/"
                        target="_blank"
                    >
                        Argumentačné chyby
                    </a>
                </button>
            </div>
        </div>
    </div>
</template>
<script setup>
import axios from "axios";
import { onMounted, ref } from "vue";
import { useRoute } from "vue-router";

// Composables
const route = useRoute();

// Lifecycle
onMounted(async () => {
    await loadArgument();
});

// Variables
const arg = ref({});
const error = ref("");

// Functions
async function loadArgument() {
    await axios
        .get("/api/arguments/" + route.params.id)
        .then((response) => {
            console.log(response);
            arg.value = response.data;
        })
        .catch((err) => {
            error.value = "Tento argument neexistuje.";
        });
}
</script>
