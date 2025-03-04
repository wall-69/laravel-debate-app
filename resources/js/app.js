import "./bootstrap";
import { createApp } from "vue";
import App from "./App.vue";
import router from "./router/index";
import useAuth from "./composables/useAuth";

const { attempt } = useAuth();

// Attempt to get the user, if he is logged in
await attempt();

const app = createApp(App);

app.use(router);

app.mount("#app");
