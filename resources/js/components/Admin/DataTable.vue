<template>
    <div
        v-if="data.length > 0"
        class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100"
    >
        <table class="table">
            <!-- head -->
            <thead>
                <tr>
                    <th v-for="column in Object.keys(data[0])">{{ column }}</th>
                    <th>Akcie</th>
                </tr>
            </thead>
            <!-- body -->
            <tbody>
                <tr v-for="row in data">
                    <component
                        v-for="(val, column) in row"
                        :is="column == 'id' ? 'th' : 'td'"
                    >
                        {{ val }}
                    </component>
                    <td class="flex justify-start items-center gap-4">
                        <RouterLink
                            :to="{
                                name: 'admin-theses-edit',
                                params: { id: row.id },
                            }"
                            class="btn btn-square btn-info btn-sm"
                        >
                            <i class="bx text-sm bxs-edit"></i>
                        </RouterLink>
                        <button
                            @click="handleDelete(row.id)"
                            class="btn btn-square btn-sm btn-error"
                        >
                            <i class="bx text-sm text-white bxs-trash"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <p v-else class="p-2 w-fit">Žiadne dáta neboli nájdené.</p>
</template>
<script setup>
import axios from "axios";
import { onMounted, ref } from "vue";

// Define
const props = defineProps({
    modelName: String,
});

// Lifecycle
onMounted(async () => {
    loadData();
});

// Variables
const data = ref([]);

// Functions
async function loadData() {
    await axios
        .get("/api/" + props.modelName)
        .then((response) => {
            data.value = response.data;
        })
        .catch((err) => {
            // TODO
        });
}

async function handleDelete(id) {
    confirm("Ste si istý?");
    await axios
        .delete("/api/" + props.modelName + "/" + id)
        .then((response) => {
            loadData();
        });
}
</script>
