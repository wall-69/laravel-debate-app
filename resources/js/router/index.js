import { createRouter, createWebHistory } from "vue-router";
import guestGuard from "./guards/guestGuard";
import authGuard from "./guards/authGuard";
import adminGuard from "./guards/adminGuard";

const routes = [
    {
        path: "/",
        name: "home",
        component: () => import("../Pages/Home.vue"),
    },
    {
        path: "/login",
        name: "login",
        beforeEnter: guestGuard,
        component: () => import("../Pages/Login.vue"),
    },
    {
        path: "/register",
        name: "register",
        beforeEnter: guestGuard,
        component: () => import("../Pages/Register.vue"),
    },
    {
        path: "/dashboard",
        component: () => import("../Pages/Dashboard.vue"),
        beforeEnter: authGuard,
        children: [
            {
                path: "",
                name: "dashboard",
                component: () => import("../Pages/Dashboard/Index.vue"),
            },
            {
                path: "/new",
                name: "argument-new",
                component: () => import("../Pages/Dashboard/New.vue"),
            },
            {
                path: "/settings",
                name: "settings",
                component: () => import("../Pages/Dashboard/Settings.vue"),
            },
            // Admin
            {
                path: "/admin",
                beforeEnter: adminGuard,
                children: [
                    {
                        name: "admin",
                        path: "",
                        component: () =>
                            import("../Pages/Dashboard/Admin/Index.vue"),
                    },
                    {
                        name: "admin-theses",
                        path: "theses",
                        component: () =>
                            import("../Pages/Dashboard/Admin/Theses.vue"),
                    },
                ],
            },
        ],
    },
    {
        path: "/argument/:id",
        name: "argument-show",
        component: () => import("../Pages/Argument.vue"),
    },
];

export default createRouter({
    history: createWebHistory(),
    routes,
});
