import { computed, reactive, ref } from "vue";
import axios from "axios";
import router from "../router";
import { handleFormErrors } from "../utils/errorHandler";

const state = reactive({
    authenticated: false,
    user: {},
});

export default function useAuth() {
    const authenticated = computed(() => state.authenticated);
    const user = computed(() => state.user);

    const setAuthenticated = (authenticated) => {
        state.authenticated = authenticated;
    };

    const setUser = (user) => {
        state.user = user;
    };

    async function attempt() {
        await axios
            .get("/api/user")
            .then((response) => {
                setAuthenticated(true);
                setUser(response.data);
            })
            .catch((err) => {
                setAuthenticated(false);
                setUser({});
            });
    }

    async function login(data, errors) {
        await axios
            .post("/api/auth/login", data)
            .then((response) => {
                setAuthenticated(true);
                setUser(response.data.user);

                router.replace({ name: "dashboard" });
            })
            .catch((err) => {
                handleFormErrors(errors, error.response.data.errors || {});
            });
    }

    async function logout() {
        await axios.post("/api/auth/logout").then((response) => {
            setAuthenticated(false);
            setUser({});

            router.replace({ name: "home" });
        });
    }

    async function register(data, errors) {
        await axios
            .post("/api/users", data)
            .then((response) => {
                router.replace({ name: "login" });
            })
            .catch((err) => {
                handleFormErrors(errors, error.response.data.errors || {});
            });
    }

    return {
        authenticated,
        user,

        setAuthenticated,
        setUser,

        attempt,
        login,
        logout,
        register,
    };
}
