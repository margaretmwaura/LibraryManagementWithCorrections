<template>
    <div class="text-center">
        <v-dialog v-model="dialog" width="500">
            <template v-slot:activator="{ on }">
                <v-btn class="ma-2" outlined color="indigo" dark v-on="on">Change role</v-btn>
            </template>
               <v-card>
                <v-card-title class="headline grey lighten-2" primary-title>
                    Privacy Policy
                </v-card-title>
                <v-card-text>
                    <v-autocomplete v-model="formAssign.role" :items="getallRolesg" label="role"
                              required>
                    </v-autocomplete>
                </v-card-text>
                <v-divider></v-divider>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="primary" text @click="togglingPermissions">
                       Change
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>
<script>
    import {mapGetters} from "vuex";

    export default {
        name: "Popup",
        data()
        {
            return{
                dialog:false,
                formAssign:{},

            }
        },
        computed: {
            ...mapGetters(['getallRolesg']),
        },
        props: {
            user: Array,
        },
        methods: {
            togglingPermissions: function(user)
            {
                // console.log("This is the choosen permission " + this.formChange.role);
                this.formAssign.id= this.user.id;
                this.$store.dispatch('toggleRoles',this.formAssign);
                console.log("This is what you have choose " + this.formAssign.role);
                console.log("This is what we have gotten from the Main component " + this.user.email);
                this.dialog = false;
            },
            }
    }
</script>

<style scoped>

</style>
