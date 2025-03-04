<template>
    <Layout>
        <RouterView></RouterView>
    </Layout>
</template>

<script setup>
import Layout from "./Layouts/Dashboard.vue";
import { RouterView } from "vue-router";
import useAuth from "../composables/useAuth";
import { provide } from "vue";

// Composables
const { user } = useAuth();

// Define
provide("user", user.value);
</script>
