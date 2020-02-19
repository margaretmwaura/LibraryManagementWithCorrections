import Add_book from "../components/Add_book";
import Edit_book from "../components/Edit_book";
import Display_books from "../components/Displaybooks";
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
        component: Display_books,

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
        name : 'Roles_Perm',
        path: '/roles_perm',
        component: RolesAndPermissions,

    },
    {
        name : 'BookMan',
        path: '/book_man',
        component: BookManagement,

    },
    {
        name : 'MyAccount',
        path: '/my_account',
        component: MyAccount,

    },
];

const router = new VueRouter({
    routes
});

export default router;
