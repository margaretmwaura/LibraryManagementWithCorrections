<template>
    <div class="grid-frame">
        <div class="grid-container">
            <form v-on:submit.prevent="addRole">
                <p>Adding a role </p>
                <div class="grid-container">
                    <div class="grid-x grid-padding-x">
                        <div class="cell medium-12 large-12 small-12">
                            <label>Name
                                <input type="text" v-model="form.name">
                            </label>
                        </div>
                        <div class="cell medium-12 large-12 small-12">
                            <button class="primary button expanded">Add role</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="grid-container">
            <form v-on:submit.prevent="addPermission">
                <p>Adding a permission</p>
                <div class="grid-container">
                    <div class="grid-x grid-padding-x">
                        <div class="cell medium-12 large-12 small-12">
                            <label>Name
                                <input type="text" v-model="form.name">
                            </label>
                        </div>
                        <div class="cell medium-12 large-12 small-12">
                            <button class="primary button expanded">Add permission</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="grid-container">
            <form v-on:submit.prevent="assign">
                <p>Assign a role to a permission</p>
                <div class="grid-container">
                    <div class="grid-x grid-padding-x">
                        <div class="cell medium-12 large-12 small-12">
                            <label>Select a role</label>
                            <select v-model="formAssign.role">
                                <option v-for="role in getallRolesg" v-bind:value="role">{{role}}</option>
                            </select>
                        </div>
                        <div class="cell medium-12 large-12 small-12">
                            <label>Select a permission</label>
                            <select v-model="formAssign.permission">
                                <option v-for="permission in getallPermissions" v-bind:value="permission">{{permission}}</option>
                            </select>
                        </div>
                        <div class="cell medium-12 large-12 small-12">
                            <button class="primary button expanded">Assign a permission to a role </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="grid-x grid-container">
            <div class="cell large-6 small-6 medium-6">
                <p>The following are roles</p>
                <div v-for="role in getallRolesg">
                    <p>{{role}}</p>
                </div>
            </div>
            <div class="cell large-6 small-6 medium-6">
                <p>The following are the permissions of the role</p>
                <div v-for="perm in getallpermsroles">
                    <div v-for="one in perm" style="display: inline-block; margin-right: 30px">
                        <p>{{one}}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="grid-container">
            <table class="table">
                <tr>
                    <th>User Id</th>
                    <th> User Name </th>
                    <th> User Role </th>
                    <th>Change Role</th>
                </tr>
                <tr v-for="user in getallUsersg">
                  <td>{{user.id}}</td>
                    <td>{{user.name}}</td>
                    <td>{{user.role_id}}</td>
                    <td><button v-on:click="togglingPermissions(user)">Toggle Role</button></td>
                </tr>
            </table>
        </div>
        <div class="grid-container">
            <table class="table" v-for="books in getallorderednreserved">
                <tr>
                    <th>Book name</th>
                    <th> Book Category </th>
                    <th> Book Release year </th>
                    <th> Book Borrow Date </th>
                    <th>Book Due Date</th>
                    <th>Book Reserve date</th>
                    <th>Assoicated User </th>
                </tr>
                    <tr v-for="book in books">
                        <td>{{book.name}}</td>
                        <td>{{book.category}}</td>
                        <td>{{book.year}}</td>
                        <td>{{book.borrow_date}}</td>
                        <td>{{book.due_date}}</td>
                        <td>{{book.reserve_date}}</td>
                        <td>{{book.pivot.email}}</td>
                    </tr>

            </table>
        </div>

    </div>

</template>

<script>
    import {mapGetters} from "vuex";

    export default {
        name: "Dashboard",
        data() {
            return {
                form:{},
                formAssign:{},
            }
        },
        methods: {
            addRole() {
                console.log("Adding roles");
                this.$store.dispatch('addRole',this.form);
            },
            addPermission()
            {
                console.log("Adding permissions");
                this.$store.dispatch('addPermission',this.form);
            },
            assign()
            {
                console.log("What we will be using for the assigning" + this.formAssign);
                this.$store.dispatch('assignPermissionToRole',this.formAssign);
            },
            togglingPermissions: function(user)
            {
                this.$store.dispatch('toggleRoles',user);
            }
        },
        computed: {
            ...mapGetters(['getallPermissions','getallRolesg','getallpermsroles','getallUsersg','getallorderednreserved'])
        },
        mounted() {
            this.$store.dispatch('getallRolesPermissions');
            this.$store.dispatch('getallRoles');
            this.$store.dispatch('getallPermissions');
            this.$store.dispatch('getAllUsers');
            this.$store.dispatch('getallorderedandreservedbooks');
        },
    }
</script>

<style scoped>

</style>
