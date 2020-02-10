import Add_book from "../components/Add_book";
import Edit_book from "../components/Edit_book";
import Displaybooks from "../components/Displaybooks";
import Dashboard from "../components/Dashboard";
import Vue from "vue";
import VueRouter from "vue-router";
import RolesAndPermissions from "../components/RolesAndPermissions";
import BookManagement from "../components/BookManagement";
import MyAccount from "../components/MyAccount";
Vue.use(VueRouter);


const routes = [
    {
        name : 'Add',
        path: '/add',
        component: Dashboard,

    },
    {
        name : 'Display',
        path: '/',
        component: Displaybooks,

    },
    {
        name : 'Edit',
        path: '/edit',
        component: Edit_book,

    },
    {
        name : 'DashBoard',
        path: '/dashboard',
        component: Dashboard,

    },
    {
        name : 'RolesnPerm',
        path: '/rolesnperm',
        component: RolesAndPermissions,

    },
    {
        name : 'BookMan',
        path: '/bookman',
        component: BookManagement,

    },
    {
        name : 'MyAccount',
        path: '/myaccount',
        component: MyAccount,

    },
];

const router = new VueRouter({
    routes
});

export default router;
