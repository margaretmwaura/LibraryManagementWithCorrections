<template>
    <v-container class="my-12">
        <h4 class="subheading grey--text">Roles and Permissions</h4>
        <v-layout row justify-space-around>
            <v-flex xs12 md5>
                <p>Add a permission</p>
                <v-form v-model="valid" ref="form" >
                    <v-text-field label="Permission" v-model="form.name" :rules="permRules" :counter="10"  color="purple darken-2" > </v-text-field>
                    <v-btn @click="addPermission" :class="{ red: !valid, blue: valid }">submit</v-btn>
                </v-form>
            </v-flex>
            <v-flex xs12 md5>
                <p>Add a Role</p>
                <v-form v-model="valid_one" ref="form">
                    <v-text-field label="Role" v-model="forma.name" :rules="roleRules" :counter="10" color="purple darken-2"> </v-text-field>
                    <v-btn @click="addRole" :class="{ red: !valid_one, blue: valid_one }">submit</v-btn>
                </v-form>
            </v-flex>
        </v-layout>
        <v-layout row>
            <v-flex md12>
                <p>Connect or disconnect roles and permissions </p>
                <form>
                    <v-autocomplete v-model="formAssign.role" :items="getallRolesg"  label="Role"
                              required>
                    </v-autocomplete>
                    <v-autocomplete v-model="formAssign.permission" :items="getallPermissions"  label="Permission"
                    > </v-autocomplete>
                    <v-btn class="mr-4" @click="assign">Connect </v-btn>
                    <v-btn class="mr-4" @click="remove">Disconnect </v-btn>
                </form>
            </v-flex>
        </v-layout>

        <v-layout row >

                 <v-flex>
                    <div v-for="role in getrolesnperms">
                        <p>The role <span style="color: indianred">{{role.name}}</span> has permissions</p>
                           <div v-for="perm in role.permissions" style="display: inline-block ; margin-right:10px">
                               <p> <span style="color : indigo"> {{perm.name}} </span></p>
                           </div>
                    </div>
                 </v-flex>
        </v-layout>
        <v-card class="pa-5" v-for="user in getallUsersg" :key="user.id">
                <v-layout row :class="`${roleidname(user.role_id)}`">
                    <v-flex xs12 md6 >
                        <div class="cption grey--text">Name of user</div>
                        <div>{{user.id}}</div>
                    </v-flex>
                    <v-flex xs6 sm4 md2>
                        <div class="cption grey--text">User ID</div>
                        <div>{{user.name}}</div>
                    </v-flex>
                    <v-flex xs6 sm4 md2>
                        <div class="cption grey--text">User Role</div>
                        <div>{{roleidname(user.role_id)}}</div>
                    </v-flex>
                    <v-flex xs6 sm4 md2>
                        <div class="cption grey--text">Change Status</div>
                        <div>
<!--                                                    <v-chip small :class="`${roleidname(user.role_id)} white&#45;&#45;text caption my-2`">-->
<!--                                                    Change role status-->
<!--                                                   </v-chip>-->
                            <popup :user="user"></popup>
                        </div>
                    </v-flex>
                </v-layout>
            </v-card>
    </v-container>
</template>

<script>
    import Popup from "./Popup";
    import { validationMixin } from 'vuelidate'
    import { required, maxLength, email } from 'vuelidate/lib/validators'
    import {mapGetters} from "vuex";
    import notificationmixin from "../../mixins/notificationmixin";
    export default {
        components: {Popup},
        mixins: [validationMixin,notificationmixin],
        validations: {
            select: { required },
        },
        name: "RolesAndPermissions",
        data()
        {
            return{
                valid: false,
                valid_one: false,
                permRules: [
                    (v) => !!v || 'A permission is required',
                    (v) => v && v.length <= 10 || 'Permission must be less than 2 characters'
                ],
                roleRules: [
                    (v) => !!v || 'A role is required',
                    (v) => v && v.length <= 10 || 'Role must be less than 2 characters'
                ],
                // This is data that doesnt interact with the validations
                form:{},
                forma:{},
                formAssign:{},
                formChange:{},
                Role:"Pick a new role",
                Permissions:"Pick a permission"

            }
        },
        computed: {
            ...mapGetters(['getallPermissions','getallRolesg','getallpermsroles','getallUsersg','getrolesnperms']),
            selectErrors () {
                const errors = [];
                if (!this.$v.select.$dirty) return errors
                !this.$v.select.required && errors.push('Item is required');
                return errors
            },
        },
        methods: {
            addPermission()
            {
                if(this.valid)
                {
                    this.$store.dispatch('addPermission',this.form);
                }
                else
                {
                    this.informwithnotification("Ensure you add all the details");
                }

            },
            addRole()
            {
                if(this.valid_one)
                {
                    this.$store.dispatch('addRole',this.forma);
                }
                else
                {
                    this.informwithnotification("Ensure you add all the details");
                }
            },
            assign()
            {
                console.log("What we will be using for the assigning" + this.formAssign);
                this.$store.dispatch('assignPermissionToRole',this.formAssign);
            },
            remove()
            {
                console.log("What we will be using for the assigning" + this.formAssign);
                this.$store.dispatch('removePermissionToRole',this.formAssign);
            },
            togglingPermissions: function(user)
            {
                console.log("This is the choosen permission " + this.formChange.role);
                this.$store.dispatch('toggleRoles',user);
            },
            roleidname(id)
            {

                if(id === 36)
                {
                    return "User";
                }
                if(id === 35)
                {
                    return "Normal";
                }
                if(id === 37)
                {
                    return "Admin"
                }
            },
            showSubscriptions() {
                console.log("Opening the modal " + this.showModal);
                this.showModal = true;
            },
        },
        mounted() {
            this.$store.dispatch('getallRolesPermissions');
            this.$store.dispatch('getallRoles');
            this.$store.dispatch('getallPermissions');
            this.$store.dispatch('getAllUsers');
            this.$store.dispatch('getrolesnperms');
        },
        watch: {
            '$store.state.addrolesuccess' : function () {

                this.informwithnotification("Success" , "You have to add a role");
                this.$store.dispatch('clearAddRoleSuccess');
            },
            '$store.state.addrolefail' : function () {

                this.informwithnotification("Fail" , "You have not managed to add a role");
                this.$store.dispatch('addrolefail');
            },
            '$store.state.addpermsuccess' : function () {

                this.informwithnotification("Success" , "You have to add a permission");
                this.$store.dispatch('clearAddPermSuccess');
            },
            '$store.state.addpermfail' : function () {

                this.informwithnotification("Fail" , "You have not managed to add a permission");
                this.$store.dispatch('clearAddPermFail');
            },
        },

    }
</script>

<style scoped>
    .Admin
    {
        border-left: 4px solid #3cd1c2;
    }
    .User
    {
        border-left: 4px solid orange;
    }
    .Normal
    {
        border-left: 4px solid tomato;
    }

</style>
