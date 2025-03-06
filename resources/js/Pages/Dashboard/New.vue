<template>
    <div class="flex flex-col gap-4">
        <h2 class="font-bold text-primary text-2xl">Nový argument</h2>

        <template v-if="!isWriting">
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
                    Argument bude po odovzdaní ohodnotený a dostaneš instantnú
                    spätnú väzbu.
                </p>
            </div>

            <button @click="startWriting" class="btn btn-primary w-min">
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
                    @click="submitArgument"
                    :disabled="isJudging"
                    class="btn btn-primary w-min"
                >
                    Odovzdať
                </button>
                <p v-show="error" class="text-sm font-bold text-error">
                    {{ error }}
                </p>
                <div v-show="isJudging" class="bg-primary p-2 rounded-sm">
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
import { computed, ref } from "vue";
import axios from "axios";

// Variables
const isWriting = ref(false);
const isJudging = ref(false);
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
        (timeLeft.value % 60 ? timeLeft.value % 60 : "00")
    );
});

// Functions
async function startWriting() {
    error.value = "";

    thesis.value = await loadRandomThesis();
    if (!thesis.value) {
        error.value = "Nastala chyba, skúste znova.";
        thesis.value = "";
        return;
    }

    timeLeft.value = 300;

    isWriting.value = true;

    clockInterval = setInterval(() => {
        timeLeft.value -= 1;
        if (timeLeft.value == 0) {
            clearInterval(clockInterval);
        }
    }, 1000);
}

async function submitArgument() {
    const argumentValue = argument.value.value;

    // Too short argument
    if (argumentValue.length < 30) {
        error.value = "Tento argument je moc krátky.";
        return;
    }
    // Too long argument
    else if (argumentValue.length > 3000) {
        error.value = "Tento argument je príliš dlhý.";
        return;
    }

    clearInterval(clockInterval);

    isJudging.value = true;

    try {
        const response = await axios.post("/api/judge", {
            thesis: thesis.value.content,
            argument: argument.value.value,
        });

        judgement.value = response.data;
    } catch (error) {
        error.value = "Nastala chyba pri hodnotení.";
    } finally {
        isJudging.value = false;
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
<style scoped>
.judgement >>> p {
    font-weight: var(--font-weight-bold);
    font-size: var(--text-lg);
    line-height: var(--tw-leading, var(--text-lg--line-height));
}
.judgement >>> p:last-of-type {
    margin-top: 16px;
}
.judgement >>> ol {
    list-style-type: decimal;
    list-style-position: inside;
}
.judgement >>> ul {
    list-style-type: disc;
    list-style-position: inside;
}
</style>
