import Add_book from "../components/book_management/Add_book";
import Edit_book from "../components/book_management/Edit_book";
import Display_books from "../components/display/Displaybooks";
import Dashboard from "../components/book_management/Dashboard";
import Vue from "vue";
import VueRouter from "vue-router";
import RolesAndPermissions from "../components/roles_permissions/RolesAndPermissions";
import BookManagement from "../components/book_management/BookManagement";
import MyAccount from "../components/display/MyAccount";
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
