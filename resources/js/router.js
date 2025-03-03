import { createRouter, createWebHistory } from "vue-router";

const routes = [
    {
        path: "/",
        name: "home",
        component: () => import("./Pages/Home.vue"),
    },
    {
        path: "/login",
        name: "login",
        component: () => import("./Pages/Login.vue"),
    },
    {
        path: "/register",
        name: "register",
        component: () => import("./Pages/Register.vue"),
    },
    {
        // TODO: auth guard
        path: "/dashboard",
        component: () => import("./Pages/Dashboard.vue"),
        children: [
            {
                path: "",
                name: "dashboard",
                component: () => import("./Pages/Dashboard/Index.vue"),
            },
            {
                path: "/new",
                name: "new-argument",
                component: () => import("./Pages/Dashboard/New.vue"),
            },
        ],
    },
];

export default createRouter({
    history: createWebHistory(),
    routes,
});
