import Vue from 'vue'
import Vuex from 'vuex'
import axios from "axios";
Vue.use(Vuex);
export default new Vuex.Store({

    state: {
        books:[],
        permissions:[],
        roles:[],
        permsroles:[],
        rolesnperms:[],
        allUsers:[],
        allorderednreserved:[],
        bookscount:" ",
        statases:[],

        // The below variables hold the values that show the status of the result
        ordersuccess:'',
        orderfail:'',
        reservesuccess:'',
        reservefail:'',
        deletesuccess:'',
        deletefail:'',
        addfail:'',
        addsuccess:'',
        addrolesuccess:'',
        addrolefail:'',
        addpermfail:'',
        addpermsuccess:''
    },
    mutations: {
        setPermissionmut(permission)
        {
            this.state.permissions = permission
        },
        addbookmut(state,data)
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
        addPermissionmut(state,data)
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
        addRolemut(state,data)
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
        getallbooksmut()
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
        getallPermissionsmut()
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
        getallRolesmut()
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
        getallRolesPermissionsmut()
        {
            axios.get('/allperms')
                .then(response => {
                    this.state.permsroles = response.data;
                    console.log("This is the data I have gotten in regards to roles " + this.books)
                })
                .catch(error =>
                {
                })
        },
        getrolesnpermsmut()
        {
            axios.get('/rolenperms')
                .then(response => {
                    this.state.rolesnperms = response.data;
                })
                .catch(error =>
                {
                })
        },
        getAllUsersmut()
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
        assignPermissionToRolemut(state,data)
        {
            axios.post('/assign',data)
                .then(response => {
                    this.state.rolesnperms = response.data;
                })
                .catch(error =>
                {
                })
        },
        removePermissionToRolemut(state,data)
        {
            axios.post('/remove',data)
                .then(response => {
                    this.state.rolesnperms = response.data;
                })
                .catch(error =>
                {
                })
        },
        deleteABookMut(state,id)
        {
            axios
                .delete('/books/' + id,{
                })
                .then(response => {
                    const code = response.status;
                    if(code === 200)
                    {
                        this.state.books = response.data;
                         this.state.deletesuccess = "Sucess"
                    }
                    else
                    {
                        this.state.deletefail = "Failed"
                    }
                })
                .catch(error =>
                {
                    this.state.deletefail = "Failed"
                })
        },
        editABookMut(state,data)
        {
            axios
                .post('/booksedit',data)
                .then(response => {
                    const code = response.status;
                    if(code === 200)
                    {

                    }
                    else
                    {

                    }
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
        orderBookmut(state,book)
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
        reserveBookmut(state,book)
        {
            axios
                .post('/reservebook',book)
                .then(response => {
                    var code = response.status;
                    if(code === 200)
                    {
                        this.state.books = response.data.original;
                        console.log("This is the response after receive " , response.data.original);
                       this.state.reservesuccess = "Success"
                    }
                    else
                    {
                        this.state.reservefail = "Fail"
                    }
                })
                .catch(error =>
                {
                    this.state.reservefail = "Fail"
                })
        },
        getallorderedandreservedbooksmut()
        {
            axios.get('/getallbooks')
                .then(response => {
                    this.state.allorderednreserved = response.data;
                })
                .catch(error =>
                {
                })
        },
        loginusermut()
        {
            axios.get('/login')
                .then(response => {

                })
                .catch(error =>
                {
                })
        },
        registerusermut()
        {
            axios.get('/register')
                .then(response => {

                })
                .catch(error =>
                {
                })
        },
        returnbookmut(state,data)
        {
            console.log(data);
            axios
                .post('/returnbook',data)
                .then(response => {
                    var code = response.status;
                    if(code === 200)
                    {
                        this.state.allorderednreserved = response.data;
                    }
                })
                .catch(error =>
                {
                })
        },
        getallusersbooksmut()
        {
            axios
                .get('/bookscount')
                .then(response => {
                        console.log("This is the response " + response);
                        this.state.bookscount = response.data;

                })
                .catch(error =>
                {
                })
        },
        clearOrderFailMut()
        {
            this.state.orderfail = " "
        },
        clearOrderSuccessMut()
        {
            this.state.ordersuccess = " "
        },
        clearReserveFailMut()
        {
            this.state.reservefail = " "
        },
        clearReserveSuccessMut()
        {
            this.state.reservesuccess = " "
        },
        clearDeleteFailMut()
        {
            this.state.deletefail = " "
        },
        clearDeleteSuccessMut()
        {
            this.state.deletesuccess = " "
        },
        clearAddSuccessMut()
        {
            this.state.addsuccess = " "
        },
        clearAddFailMut()
        {
            this.state.addfail = " "
        },
        clearAddRoleSuccessMut()
        {
            this.state.addrolesuccess= " "
        },
        clearAddRoleFailMut()
        {
            this.state.addrolefail = " "
        },
        clearAddPermSuccessMut()
        {
            this.state.addpermsuccess= " "
        },
        clearAddPermFailMut()
        {
            this.state.addpermfail = " "
        },
        getallstatasesmut()
        {
            axios.get('/statases')
                .then(response => {
                    this.state.statases = response.data;
                    console.log("This is the data I have gotten in regards to roles " + this.books)
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
            getallPermissions:state => {
                return state.permissions
            },
            getallRolesg:state => {
                return state.roles
            },
            getallpermsroles:state => {
                return state.permsroles;
            },
            getallUsersg:state => {
                return state.allUsers;
            },
            getallorderednreserved:state => {
                return state.allorderednreserved;
            },
            getbookscount:state => {
                return state.bookscount;
            },
            getrolesnperms:state => {
                return state.rolesnperms
            },
            returnstatuses:state => {
                return state.statases;
            }

        },
    actions:
        {
            setPermission({commit},permissions)
            {
                commit('setPermissionmut',permissions)
            },
            addbook(state,data)
            {
                // console.log("What I am passing to the database " + name + " " + category + "year of release "  + year + " the url" + url);
                state.commit('addbookmut',data)
            },
            getallbooks(state)
            {
                state.commit('getallbooksmut')
            },
            deleteABook(state,id)
            {
                state.commit('deleteABookMut',id)
            },
            addPermission(state,data)
            {
                state.commit('addPermissionmut',data)
            },
            addRole(state,data)
            {
                state.commit('addRolemut',data)
            },
            getallPermissions(state)
            {
                state.commit('getallPermissionsmut')
            },
            getallRoles(state)
            {
                state.commit('getallRolesmut')
            },
            getallRolesPermissions(state)
            {
                state.commit('getallRolesPermissionsmut');
            },
            getrolesnperms(state)
            {
                state.commit('getrolesnpermsmut');
            },
            getAllUsers(state)
            {
                state.commit('getAllUsersmut')
            },
            assignPermissionToRole(state,data)
            {
                state.commit('assignPermissionToRolemut',data)
            },
            removePermissionToRole(state,data)
            {
                state.commit('removePermissionToRolemut',data)
            },
            toggleRoles(state,user)
            {
                state.commit('toggleRolesMut',user)
            },
            orderBook(state,book)
            {
                state.commit('orderBookmut',book)
            },
            reserveBook(state,book)
            {
                state.commit('reserveBookmut',book)
            },
            getallorderedandreservedbooks(state)
            {
                state.commit('getallorderedandreservedbooksmut')
            },
            loginuser(state)
            {
                state.commit('loginusermut')
            },
            registeruser(state)
            {
                state.commit('registerusermut')
            },
            returnbook(state,data)
            {
                state.commit("returnbookmut",data)
            },
            getallusersbooks(state)
            {
                state.commit("getallusersbooksmut")
            },
            clearOrderFail(state)
            {
                state.commit("clearOrderFailMut")
            },
            clearOrderSuccess(state)
            {
                state.commit("clearOrderSuccessMut")
            },
            clearReserveFail(state)
            {
                state.commit("clearReserveFailMut")
            },
            clearReserveSuccess(state)
            {
                state.commit("clearReserveSuccessMut")
            },
            clearDeleteFail(state)
            {
                state.commit("clearDeleteFailMut")
            },
            clearDeleteSuccess(state)
            {
                state.commit("clearDeleteSuccessMut")
            },
            clearAddSuccess(state)
            {
                state.commit("clearAddSuccessMut")
            },
            clearAddFail(state)
            {
                state.commit("clearAddFailMut")
            },
            clearAddRoleSuccess(state)
            {
                state.commit("clearAddRoleSuccessMut");
            },
            clearAddRoleFailMut(state)
            {
                state.commit("clearAddRoleFailMut");
            },
            clearAddPermSuccess(state)
            {
                state.commit("clearAddPermSuccessMut")
            },
            clearAddPermFail(state)
            {
               state.commit("clearAddPermFailMut")
            },
            editABook(state,data)
            {
                state.commit("editABookMut",data)
            },
            getallstatasesmut(state)
            {
                state.commit("getallstatasesmut");
            }

        },


});
