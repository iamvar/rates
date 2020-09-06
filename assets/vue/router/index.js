import Vue from "vue";
import VueRouter from "vue-router";
import Convertor from "../views/Convertor";
import Admin from "../views/Admin";

Vue.use(VueRouter);

export default new VueRouter({
    mode: "history",
    routes: [
        { path: "/convertor", component: Convertor },
        { path: "/admin", component: Admin },
        { path: "*", redirect: "/convertor" }
    ]
});