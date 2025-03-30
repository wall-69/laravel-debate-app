<template>
    <div class="flex flex-col gap-4">
        <h1 class="text-primary text-3xl font-bold">Vitaj, {{ user.name }}!</h1>

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
</template>
<script setup>
import { inject } from "vue";
import { RouterLink } from "vue-router";

// Define
const user = inject("user");
</script>
