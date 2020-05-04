<template>
    <v-app>
        <v-content>
    <div>
        <router-link to="/add"> Add Book</router-link>
        <router-link to="/display"> Display books</router-link>
        <router-link to="/dashboard"> Navigate To DashBoard </router-link>
        <button v-on:click="login">Login</button>
        <button  v-on:click="register">Register</button>
        <router-view></router-view>

    </div>
        </v-content>
   </v-app>
</template>

<script>
    export default {
        name: "App.vue",
        methods: {
            login() {
                this.$store.dispatch('loginuser');
            },
            register()
            {
                this.$store.dispatch('registeruser');
            }
        },
    }
</script>

<style scoped>

</style>
