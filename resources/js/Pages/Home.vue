<template>
    <h1>Homepage</h1>
    <RouterLink :to="{ name: 'dashboard' }" class="btn w-min">
        Dashboard
    </RouterLink>
    <RouterLink :to="{ name: 'login' }" class="btn w-min"> Login </RouterLink>
    <RouterLink :to="{ name: 'register' }" class="btn w-min">
        Register
    </RouterLink>
</template>
<script setup>
import { RouterLink } from "vue-router";
</script>
