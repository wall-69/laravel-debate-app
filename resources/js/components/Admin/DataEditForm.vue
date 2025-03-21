<template>
    <form
        v-if="!error"
        @submit.prevent="handleSubmit"
        class="flex flex-col items-center p-4 gap-4 bg-base-300"
    >
        <div class="flex flex-col items-center">
            <h2 class="text-primary font-bold text-3xl">
                <slot name="header"></slot>
            </h2>
        </div>

        <div
            v-for="slotName in inputSlots"
            :key="slotName"
            class="flex flex-col"
        >
            <label
                :for="slotNameToInputName(slotName)"
                class="text-primary font-bold"
            >
                {{
                    slotNameToInputName(slotName).charAt(0).toUpperCase() +
                    slotNameToInputName(slotName).slice(1).replace("_", " ")
                }}:
            </label>
            <slot :name="slotName" :form="form"></slot>
            <!-- Error -->
            <p
                v-show="errors[slotNameToInputName(slotName)]"
                class="text-error"
            >
                {{ errors[slotNameToInputName(slotName)] }}
            </p>
        </div>

        <!-- CREATE BUTTON -->
        <button type="submit" class="btn btn-primary">Upraviť</button>
    </form>
    <p v-else class="text-error">{{ error }}</p>
</template>
<script setup>
import { computed, onMounted, reactive, ref, useSlots, watchEffect } from "vue";
import { handleFormErrors } from "../../utils/errorHandler";
import router from "../../router";
import { useRoute } from "vue-router";

// Composables
const slots = useSlots();
const route = useRoute();

// Define
const props = defineProps({
    modelName: String,
    redirectRouteName: String,
});

// Lifecycle
onMounted(async () => {
    await axios
        .get("/api/" + props.modelName + "/" + route.params.id)
        .then((response) => {
            data.value = response.data;
        })
        .catch((err) => {
            if (err.response.status == 404) {
                error.value = "Tento záznam neexistuje.";
            } else {
                error.value = "Nastala chyba.";
            }
        });

    for (let key of Object.keys(data.value)) {
        if (key in form) {
            form[key] = data.value[key];
        }
    }
});

// Variables
const form = reactive({});
const errors = reactive({});
const data = ref({});
const error = ref("");

// Computed
const inputSlots = computed(() => {
    return Object.keys(slots).filter((slot) => slot.startsWith("input-"));
});

// Functions
function slotNameToInputName(slotName) {
    return slotName.replace("input-", "");
}

async function handleSubmit(e) {
    Object.keys(form).forEach((key) => {
        errors[key] = "";
    });

    let formData = new FormData();
    formData.append("_method", "PATCH");
    inputSlots.value.forEach((slotName) => {
        const inputName = slotNameToInputName(slotName);

        if (!form[inputName]) {
            return;
        }

        formData.append(inputName, form[inputName]);
    });

    await axios
        .post("/api/" + props.modelName + "/" + route.params.id, formData)
        .then((response) => {
            router.replace({ name: props.redirectRouteName });
        })
        .catch((err) => {
            handleFormErrors(errors, err.response.data.errors || {});
        });
}

// Watchers
watchEffect(() => {
    inputSlots.value.forEach((slotName) => {
        const inputName = slotNameToInputName(slotName);
        if (!(inputName in form)) {
            form[inputName] = "";
        }
        if (!(inputName in errors)) {
            errors[inputName] = "";
        }
    });
});
</script>
