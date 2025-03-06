<template>
    <div class="flex items-center justify-center grow gap-8 flex-col">
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
        <div class="bg-primary p-4 text-primary-content rounded-sm w-xl">
            <div v-html="arg.judgement.content" class="judgement"></div>
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
    loadArgument();
});

// Variables
const arg = ref({});
const error = ref("");

// Functions
async function loadArgument() {
    await axios
        .get("/api/arguments/" + route.params.id)
        .then((response) => {
            arg.value = response.data;
        })
        .catch((err) => {
            error.value = "Tento argument neexistuje.";
        });
}
</script>
<style scoped>
.judgement :deep(p) {
    font-weight: var(--font-weight-bold);
    font-size: var(--text-lg);
    line-height: var(--tw-leading, var(--text-lg--line-height));
}
.judgement :deep(p:last-of-type) {
    margin-top: 16px;
}
.judgement :deep(ol) {
    list-style-type: decimal;
    list-style-position: inside;
}
.judgement :deep(ul) {
    list-style-type: disc;
    list-style-position: inside;
}
</style>
