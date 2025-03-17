import useAuth from "../../composables/useAuth";

export default function adminGuard(to, from, next) {
    const { user } = useAuth();

    if (user.value && user.value.admin) {
        return next();
    }

    return next({ name: "dashboard" });
}
