import axios from "axios";
window.axios = axios;

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

axios.defaults.withCredentials = true;
axios.defaults.withXSRFToken = true;
// Fetch CSRF cookie automatically, if none is set
axios.interceptors.request.use(
    async (config) => {
        // Prevent infinite loop
        if (config.url === "/api/csrf-cookie") {
            return config;
        }

        // If CSRF cookie is missing, fetch it
        if (!document.cookie.includes("XSRF-TOKEN")) {
            await axios.get("/api/csrf-cookie");
        }

        return config;
    },
    (error) => Promise.reject(error)
);
