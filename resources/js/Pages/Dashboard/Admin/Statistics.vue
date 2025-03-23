<template>
    <div class="flex flex-col gap-4">
        <h2 class="font-bold text-primary text-3xl">Štatistiky</h2>

        <div class="stats stats-vertical lg:stats-horizontal shadow">
            <div class="stat">
                <div class="stat-title">Užívatelia</div>
                <div class="stat-value">{{ usersAmount }}</div>
                <div class="stat-desc">Počet zaregistrovaných užívateľov</div>
            </div>

            <div class="stat">
                <div class="stat-title">Tézy</div>
                <div class="stat-value">{{ thesesAmount }}</div>
                <div class="stat-desc">Počet vytvorených téz</div>
            </div>

            <div class="stat">
                <div class="stat-title">Argumenty</div>
                <div class="stat-value">{{ argumentsAmount }}</div>
                <div class="stat-desc">
                    Počet vytvorených argumentov užívateľmi
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import { onMounted, ref } from "vue";

// Lifecycle
onMounted(async () => {
    loadData();
});

// Variables
const usersAmount = ref(0);
const thesesAmount = ref(0);
const argumentsAmount = ref(0);

// Functions
async function loadData() {
    await axios
        .get("/api/admin/statistics")
        .then((response) => {
            usersAmount.value = response.data.users_amount;
            thesesAmount.value = response.data.theses_amount;
            arguments.value = response.data.arguments_amount;
        })
        .catch((err) => {
            // TODO
        });
}
</script>
