<template>
    <div class="flex flex-col gap-4">
        <DataCreateForm model-name="theses" redirect-route-name="admin-theses">
            <template #header>Nová téza</template>
            <template #input-content="{ form }">
                <textarea
                    v-model="form.content"
                    name="content"
                    class="textarea min-w-sm"
                ></textarea>
            </template>
        </DataCreateForm>
    </div>
</template>
<script setup>
import { onMounted, ref } from "vue";
import DataCreateForm from "../../../../components/Admin/DataCreateForm.vue";
import { RouterLink } from "vue-router";
</script>
