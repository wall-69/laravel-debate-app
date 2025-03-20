<template>
    <div class="flex flex-col gap-4">
        <div class="flex justify-between">
            <h2 class="text-2xl font-bold text-primary">Tézy</h2>
            <RouterLink :to="{ name: 'admin-theses-create' }" class="btn"
                >Nová téza</RouterLink
            >
        </div>

        <DataTable model-name="theses"></DataTable>
    </div>
</template>
<script setup>
import { onMounted, ref } from "vue";
import DataTable from "../../../../components/Admin/DataTable.vue";
import { RouterLink } from "vue-router";
</script>
