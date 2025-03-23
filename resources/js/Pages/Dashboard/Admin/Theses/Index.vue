<template>
    <div class="flex flex-col gap-4">
        <h2 class="text-3xl font-bold text-primary">Tézy</h2>

        <DataTable model-name="theses">
            <template #new-button>
                <RouterLink :to="{ name: 'admin-theses-create' }" class="btn">
                    Nová téza
                </RouterLink>
            </template>
        </DataTable>
    </div>
</template>
<script setup>
import { onMounted, ref } from "vue";
import DataTable from "../../../../components/Admin/DataTable.vue";
import { RouterLink } from "vue-router";
</script>
