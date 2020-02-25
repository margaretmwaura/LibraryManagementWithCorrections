import Vue from 'vue'
import Vuex from 'vuex'
import axios from "axios";
Vue.use(Vuex);
export default new Vuex.Store({

    state: {
        books:[],
        permissions:[],
        roles:[],
        permsRoles:[],
        rolesPerms:[],
        allUsers:[],
        allOrderedReserved:[],
        aUsersBooks:" ",
        categories:[]
        
    },
    mutations: {
        setPermissionMut(permission)
        {
            this.state.permissions = permission
        },
        addBookMut(state,data)
        {
            console.log(data);
            axios
                .post('/books',data)
                .then(response => {
                    this.state.books = response.data;
                    var code = response.status;
                    if(code === 200)
                    {
                      this.state.addsuccess = "Sucess"
                    }

                })
                .catch(error =>
                {
                    this.state.addfail="Fail"
                })
        },
        addPermissionMut(state,data)
        {
            console.log(data);
            axios
                .post('/permissions',data)
                .then(response => {
                    var code = response.status;
                    if(code === 200)
                    {
                        this.state.permissions = response.data;
                       this.state.addpermsuccess = "success"
                    }
                    else
                    {
                        this.state.addpermfail = "fail"
                    }
                })
                .catch(error =>
                {
                    this.state.addpermfail = "fail"
                })
        },
        addRoleMut(state,data)
        {
            console.log(data);
            axios
                .post('/roles',data)
                .then(response => {
                    var code = response.status;
                    if(code === 200)
                    {
                        this.state.roles = response.data;
                        console.log("This is the data " + response.data);
                      this.state.addrolesuccess = "Success"
                    }
                    else
                    {
                        this.state.addrolefail = "Failed"
                    }
                })
                .catch(error =>
                {
                    this.state.addrolesuccess = "Success"
                })
        },
        getAllBooksMut()
        {
            axios.get('/books')
                .then(response => {
                    this.state.books = response.data;
                    console.log("This is the data I have gotten " + this.books)
                })
                .catch(error =>
                {
                })
        },
        getAllPermissionsMut()
        {
            axios.get('/permissions')
                .then(response => {
                    this.state.permissions = response.data;
                    console.log("This is the data I have gotten in regards to permissions " + this.books)
                })
                .catch(error =>
                {
                })
        },
        getAllRolesMut()
        {
            axios.get('/roles')
                .then(response => {
                    this.state.roles = response.data;
                    console.log("This is the data I have gotten in regards to roles " + this.books)
                })
                .catch(error =>
                {
                })
        },
        getAllRolesPermissionsMut()
        {
            axios.get('/allperms')
                .then(response => {
                    this.state.permsRoles = response.data;
                    console.log("This is the data I have gotten in regards to roles " + this.books)
                })
                .catch(error =>
                {
                })
        },
        getRolesPermsMut()
        {
            axios.get('/rolenperms')
                .then(response => {
                    this.state.rolesPerms = response.data;
                })
                .catch(error =>
                {
                })
        },
        getAllUsersMut()
        {
            axios.get('/users')
                .then(response => {
                    this.state.allUsers = response.data;
                    console.log("This is the data I have gotten in regards to roles " + this.books)
                })
                .catch(error =>
                {
                })
        },
        assignPermissionToRoleMut(state,data)
        {
            axios.post('/assign',data)
                .then(response => {
                    this.state.rolesPerms = response.data;
                })
                .catch(error =>
                {
                })
        },
        removePermissionToRoleMut(state,data)
        {
            axios.post('/remove',data)
                .then(response => {
                    this.state.rolesPerms = response.data;
                })
                .catch(error =>
                {
                })
        },
        toggleRolesMut(state , user)
        {
            console.log(user);
            axios
                .post('/toggle',user)
                .then(response => {
                    const code = response.status;
                    if(code === 200)
                    {
                        this.state.allUsers = response.data;
                    }
                })
                .catch(error =>
                {
                })
        },
        orderBookMut(state,book)
        {
            axios
                .post('/orderbook',book)
                .then(response => {
                    var code = response.status;
                    this.state.books = response.data;
                    if(code === 200)
                    {

                        this.state.books = response.data.original;
                        console.log("This is the response after order " , response.data.original);
                        this.state.ordersuccess = "Successful"
                    }
                    else
                    {
                        this.state.orderfail = "Fail"
                    }
                })
                .catch(error =>
                {
                    this.state.orderfail = "Fail"
                })
        },
        getAllOrderedAndReservedBooksMut()
        {
            axios.get('/get_all_books')
                .then(response => {
                    this.state.allOrderedReserved = response.data;
                })
                .catch(error =>
                {
                })
        },
        loginUserMut()
        {
            axios.get('/login')
                .then(response => {

                })
                .catch(error =>
                {
                })
        },
        registerUserMut()
        {
            axios.get('/register')
                .then(response => {

                })
                .catch(error =>
                {
                })
        },
        getAUsersBooksMut()
        {
            axios
                .get('/users_books')
                .then(response => {
                    this.state.aUsersBooks = response.data;
                    console.log("The data I have gotten on the users books " , this.state.aUsersBooks);
                })
                .catch(error =>
                {
                })
        },
        getCategoriesMut()
        {
            axios
                .get('/categories')
                .then(response => {
                    const code = response.status;
                    if(code === 200)
                    {
                        this.state.categories = response.data;
                    }
                })
                .catch(error =>
                {
                })
        }
        },
    getters:
        {
            getBooks: state => {
                return state.books
            },
            getAllPermissions:state => {
                return state.permissions
            },
            getAllRoles:state => {
                return state.roles
            },
            getAllPermsRoles:state => {
                return state.permsRoles;
            },
            getAllUsers:state => {
                return state.allUsers;
            },
            getAllOrderedReserved:state => {
                return state.allOrderedReserved;
            },
            getRolesPerms:state => {
                return state.rolesPerms
            },
            getAUsersBooks:state=>{
                return state.aUsersBooks
            },
            getCategories:state=>{
                return state.categories
            }
        },
    actions:
        {
            setPermission({commit},permissions)
            {
                commit('setPermissionMut',permissions)
            },
            addBook(state,data)
            {
                // console.log("What I am passing to the database " + name + " " + category + "year of release "  + year + " the url" + url);
                state.commit('addBookMut',data)
            },
            getAllBooks(state)
            {
                state.commit('getAllBooksMut')
            },
            deleteABook(state,id)
            {
                state.commit('deleteABookMut',id)
            },
            addPermission(state,data)
            {
                state.commit('addPermissionMut',data)
            },
            addRole(state,data)
            {
                state.commit('addRoleMut',data)
            },
            getAllPermissions(state)
            {
                state.commit('getAllPermissionsMut')
            },
            getAllRoles(state)
            {
                state.commit('getAllRolesMut')
            },
            getAllRolesPermissions(state)
            {
                state.commit('getAllRolesPermissionsMut');
            },
            getRolesPerms(state)
            {
                state.commit('getRolesPermsMut');
            },
            getAllUsers(state)
            {
                state.commit('getAllUsersMut')
            },
            assignPermissionToRole(state,data)
            {
                state.commit('assignPermissionToRoleMut',data)
            },
            removePermissionToRole(state,data)
            {
                state.commit('removePermissionToRoleMut',data)
            },
            toggleRoles(state,user)
            {
                state.commit('toggleRolesMut',user)
            },
            reserveBook(state,book)
            {
                state.commit('reserveBookMut',book)
            },
            loginUser(state)
            {
                state.commit('loginUserMut')
            },
            registerUser(state)
            {
                state.commit('registerUserMut')
            },
            getAllUsersBooks(state)
            {
                state.commit("getAllUsersBooksMut")
            },
            
            editABook(state,data)
            {
                state.commit("editABookMut",data)
            },
            getAUsersBooks(state)
            {
                state.commit("getAUsersBooksMut")
            },
            getAllOrderedAndReservedBooks(state)
            {
                state.commit("getAllOrderedAndReservedBooksMut")
            },
            getCategories(state)
            {
                state.commit("getCategoriesMut")
            }

        },


});
