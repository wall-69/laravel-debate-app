<template>
    <div class="flex flex-col gap-4">
        <div class="flex justify-between gap-4">
            <!-- Search bar -->
            <label class="input">
                <i class="bx bx-search"></i>
                <input v-model="search" type="search" placeholder="Vyhľadať" />
            </label>

            <!-- New -->
            <slot name="new-button"></slot>
        </div>

        <template v-if="data.length > 0">
            <div
                class="rounded-box border-base-content/5 bg-base-100 overflow-x-auto border"
            >
                <table class="table">
                    <!-- head -->
                    <thead>
                        <tr>
                            <th v-for="column in Object.keys(data[0])">
                                {{ column }}
                            </th>
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
                            <td class="flex items-center justify-start gap-4">
                                <RouterLink
                                    :to="{
                                        name: 'admin-theses-edit',
                                        params: { id: row.id },
                                    }"
                                    class="btn btn-square btn-info btn-sm"
                                >
                                    <i class="bx bxs-edit text-sm"></i>
                                </RouterLink>
                                <button
                                    @click="handleDelete(row.id)"
                                    class="btn btn-square btn-sm btn-error"
                                >
                                    <i
                                        class="bx bxs-trash text-sm text-white"
                                    ></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <div class="join self-center">
                <button
                    @click="previousPage"
                    class="join-item btn"
                    :disabled="page == 1"
                >
                    <i class="bx bx-chevron-left"></i>
                </button>
                <button class="join-item btn">{{ page }}</button>
                <button
                    @click="nextPage"
                    class="join-item btn"
                    :disabled="page == lastPage"
                >
                    <i class="bx bx-chevron-right"></i>
                </button>
            </div>
        </template>
        <p v-else class="w-fit p-2">Žiadne dáta neboli nájdené.</p>
    </div>
</template>
<script setup>
import axios from "axios";
import { onMounted, ref, watch } from "vue";

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
const page = ref(1);
const lastPage = ref(1);
const search = ref("");

// Functions
async function loadData() {
    let apiURL = "/api/" + props.modelName;
    apiURL += "?page=" + page.value;
    if (search.value) {
        apiURL += "&search=" + search.value;
    }

    await axios
        .get(apiURL)
        .then((response) => {
            // Get data from the paginator object
            data.value = response.data.data;

            // Set the last possible page
            lastPage.value = response.data.last_page;
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

async function previousPage() {
    if (page.value <= 1) {
        page.value = 1;
    }

    page.value -= 1;

    loadData();
}

async function nextPage() {
    if (page.value >= lastPage.value) {
        page.value = lastPage.value;
    }

    page.value += 1;

    loadData();
}

// Watcher
watch(
    () => search.value,
    (newSearch, oldSearch) => {
        page.value = 1;

        loadData();
    },
);
</script>
