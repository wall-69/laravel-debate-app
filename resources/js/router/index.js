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
                        name: "admin-statistics",
                        path: "statistics",
                        component: () =>
                            import("../Pages/Dashboard/Admin/Statistics.vue"),
                    },
                    {
                        path: "theses",
                        children: [
                            {
                                path: "",
                                name: "admin-theses",
                                component: () =>
                                    import(
                                        "../Pages/Dashboard/Admin/Theses/Index.vue"
                                    ),
                            },
                            {
                                path: "create",
                                name: "admin-theses-create",
                                component: () =>
                                    import(
                                        "../Pages/Dashboard/Admin/Theses/Create.vue"
                                    ),
                            },
                            {
                                path: "edit/:id",
                                name: "admin-theses-edit",
                                component: () =>
                                    import(
                                        "../Pages/Dashboard/Admin/Theses/Edit.vue"
                                    ),
                            },
                        ],
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
