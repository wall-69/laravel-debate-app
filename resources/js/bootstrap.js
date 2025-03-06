import axios from "axios";
window.axios = axios;

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

axios.defaults.baseURL = "http://127.0.0.1:8000";
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
    (err) => Promise.reject(err)
);
