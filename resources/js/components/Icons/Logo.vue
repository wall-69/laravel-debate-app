<template>
    <div class="flex items-center gap-2">
        <svg
            :fill="fillColor"
            version="1.1"
            id="Layer_1"
            xmlns="http://www.w3.org/2000/svg"
            xmlns:xlink="http://www.w3.org/1999/xlink"
            viewBox="0 0 256 256"
            enable-background="new 0 0 256 256"
            xml:space="preserve"
            class="h-12 w-12 md:h-16 md:w-16"
        >
            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
            <g
                id="SVGRepo_tracerCarrier"
                stroke-linecap="round"
                stroke-linejoin="round"
            ></g>
            <g id="SVGRepo_iconCarrier">
                <path
                    d="M98.6,32.6c24,0,43.4,19.4,43.4,43.4s-19.4,43.6-43.4,43.6s-43.4-19.4-43.4-43.4S74.6,32.6,98.6,32.6z M221.8,215.6h-54.4 l25.4-43.8c5.2-9.2,2-20.8-7-26s-20.6-2-25.8,7l-25.4,43.8l-37.8-64.8C93.2,125,86,121.6,77,121.6c-1.2,0-3.8,0.4-5.2,0.8 c-1.2,0.2-3,0.8-4.4,1.2C31,135.6,2.2,193.8,2.2,254c1,0,87.4,0,109.4,0c-0.8-1.2-1.6-2.2-2.4-3.4L65.4,175c-1.4-2.6-0.4-6,2-7.4 c2.6-1.4,6-0.4,7.4,2l43.4,75c3.2,5.6,9.2,9.4,16.2,9.4h87.4c10.6,0,19-8.6,19-19C241,224,232.2,215.6,221.8,215.6z M238.216,27.773 l3.74-5.932l-8.849-5.578l-3.675,5.829c-4.227-2.064-8.835-3.465-13.687-4.066v-5.564h6.438V2h-22.934v10.461h6.035v5.526 c-21.695,2.517-38.592,21-38.592,43.359c0,24.071,19.583,43.654,43.654,43.654S254,85.417,254,61.346 C254,47.861,247.853,35.786,238.216,27.773z M210.346,94.547c-18.307,0-33.201-14.894-33.201-33.201s14.894-33.201,33.201-33.201 s33.201,14.894,33.201,33.201S228.653,94.547,210.346,94.547z M237.471,61.145h-26.957V34.188 C225.372,34.258,237.312,46.308,237.471,61.145z"
                ></path>
            </g>
        </svg>

        <div
            class="flex flex-col items-start justify-between"
            :class="['text-' + color]"
        >
            <span class="text-lg font-bold md:text-2xl lg:text-3xl">
                QuickLogic
            </span>

            <span class="hidden text-base md:block md:text-lg">
                make arguments under pressure
            </span>
        </div>
    </div>
</template>
<script setup>
import { computed } from "vue";

// Define
const props = defineProps({
    color: String,
});

// Computed
const fillColor = computed(() => {
    return {
        primary: "#00d157",
        secondary: "#ffc466",
        accent: "#22b5d3",
    }[props.color];
});
</script>
