<template>
    <div class="flex flex-col gap-4">
        <DataEditForm model-name="theses" redirect-route-name="admin-theses">
            <template #header>Upraviť tézu</template>
            <template #input-content="{ form }">
                <textarea
                    v-model="form.content"
                    name="content"
                    class="textarea min-w-sm"
                ></textarea>
            </template>
        </DataEditForm>
    </div>
</template>
<script setup>
import DataEditForm from "../../../../components/Admin/DataEditForm.vue";
</script>
