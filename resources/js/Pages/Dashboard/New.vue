<template>
    <div class="flex flex-col gap-4">
        <h1 class="font-bold text-primary text-3xl">Nový argument</h1>

        <template v-if="state == ''">
            <div class="bg-base-300 rounded-sm px-3 py-2 text-base-content">
                <h3 class="text-secondary text-lg font-bold">
                    Ako to funguje?
                </h3>
                <p>
                    Po kliknutí na tlačítko
                    <span class="font-medium">Začať</span> sa vyberie náhodná
                    téza na ktorú musíš napísať argument.
                    <br />
                    Na napísanie argumentu budeš mať 5 mínut.
                    <br />
                    Argument bude po odovzdaní ohodnotený a dostaneš spätnú
                    väzbu (v čom je argument dobrý, ako by sa dal zlepšiť, ...).
                    <br />
                    <span class="text-xs"
                        >(Argument je hodnotený umelou inteligenciou. Hodnotenie
                        by nemalo byť brané vážne a má slúžiť ako simulácia
                        hodnotenia OKM. Umelá inteligencia môže robiť chyby, byť
                        nepresná a vymýšľať si nepravdy)</span
                    >
                </p>
            </div>

            <button @click="startWriting" class="btn btn-primary w-fit">
                Začať
            </button>
            <p v-show="error" class="text-sm font-bold text-error">
                {{ error }}
            </p>
        </template>
        <template v-else>
            <div
                class="flex flex-col items-center min-w-full gap-2 bg-base-300 rounded-sm px-3 py-2 text-base-content"
            >
                <h3 class="text-lg">
                    <span class="text-secondary font-bold">Téza:</span>
                    {{ thesis.content }}
                </h3>

                <p class="text-lg">
                    Zostávajúci čas:
                    <span class="font-bold">{{ timeLeftFormatted }}</span>
                </p>
            </div>

            <div class="flex flex-col gap-2 text-base-content">
                <textarea
                    ref="argument"
                    @focus="error = ''"
                    rows="5"
                    placeholder="Píš svoj argument sem!"
                    minlength="30"
                    :disabled="timeLeft <= 0"
                    class="textarea focus:outline-0 w-full"
                ></textarea>
                <button
                    v-show="state != 'finished'"
                    @click="submitArgument"
                    :disabled="state != 'writing'"
                    class="btn btn-primary w-min"
                >
                    Odovzdať
                </button>
                <p v-show="error" class="text-sm font-bold text-error">
                    {{ error }}
                </p>
                <button
                    v-if="error && state == 'out of time'"
                    @click="startWriting"
                    class="btn btn-primary w-fit"
                >
                    Skúsiť znova
                </button>
                <div
                    v-show="state == 'judging'"
                    class="bg-primary p-2 rounded-sm"
                >
                    <p class="font-bold text-primary-content">
                        Hodnotím argument...
                    </p>
                </div>
                <div
                    v-if="judgement"
                    class="bg-primary text-primary-content rounded-sm p-2"
                >
                    <div v-html="judgement" class="judgement"></div>
                </div>
            </div>
        </template>
    </div>
</template>
<script setup>
import { computed, inject, ref } from "vue";
import axios from "axios";

// Define
const user = inject("user");

// Variables
const state = ref("");
const argument = ref(null);
const timeLeft = ref(0);
const thesis = ref("");
const judgement = ref("");
const error = ref("");

let clockInterval = -1;

// Computed
const timeLeftFormatted = computed(() => {
    return (
        Math.floor(timeLeft.value / 60) +
        ":" +
        (timeLeft.value % 60 >= 10
            ? timeLeft.value % 60
            : "0" + (timeLeft.value % 60))
    );
});

// Functions
async function startWriting() {
    if (state.value != "" && state.value != "out of time") {
        return;
    }
    if (argument.value) {
        argument.value.value = "";
    }
    error.value = "";

    state.value = "writing";

    thesis.value = await loadRandomThesis();
    if (!thesis.value) {
        error.value = "Nastala chyba, skúste znova.";
        thesis.value = "";
        return;
    }

    timeLeft.value = 300;

    clockInterval = setInterval(() => {
        timeLeft.value -= 1;
        if (timeLeft.value == 0) {
            clearInterval(clockInterval);

            submitArgument();

            state.value = "out of time";
        }
    }, 1000);
}

async function submitArgument() {
    if (state.value == "out of time" || !argument.value) {
        return;
    }

    const argumentValue = argument.value.value;

    // Too short argument
    if (argumentValue.length < 30) {
        error.value = "Tento argument je príliš krátky.";
        return;
    }
    // Too long argument
    else if (argumentValue.length > 3000) {
        error.value = "Tento argument je príliš dlhý.";
        return;
    }

    clearInterval(clockInterval);

    state.value = "judging";

    try {
        const response = await axios.post("/api/judge", {
            thesis: thesis.value.content,
            argument: argument.value.value,
        });

        judgement.value = response.data;
    } catch (err) {
        error.value = "Nastala chyba pri hodnotení.";
    } finally {
        state.value = "saving";

        await axios
            .post("/api/arguments", {
                user_id: user.id,
                thesis_id: thesis.value.id,
                content: argument.value.value,
            })
            .then(async (response) => {
                await axios
                    .post("/api/judgements", {
                        argument_id: response.data.id,
                        content: judgement.value,
                    })
                    .then((response) => {
                        state.value = "finished";
                    });
            });
    }
}

async function loadRandomThesis() {
    try {
        const response = await axios.get("/api/theses/random");
        return response.data;
    } catch (err) {
        return null;
    }
}
</script>
