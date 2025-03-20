<template>
    <form
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
        <button type="submit" class="btn btn-primary">Vytvoriť</button>
    </form>
</template>
<script setup>
import { computed, reactive, useSlots, watchEffect } from "vue";
import { handleFormErrors } from "../../utils/errorHandler";
import router from "../../router";

// Composables
const slots = useSlots();

// Define
const props = defineProps({
    modelName: String,
    redirectRouteName: String,
});

// Variables
const form = reactive({});
const errors = reactive({});

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
    inputSlots.value.forEach((slotName) => {
        const inputName = slotNameToInputName(slotName);

        if (!form[inputName]) {
            return;
        }

        formData.append(inputName, form[inputName]);
    });

    await axios
        .post("/api/" + props.modelName, formData)
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
