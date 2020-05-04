<template>
    <div>
        <p v-if="$can('edit post')"> These is only for the pople with the permissions </p>
        <form v-on:submit.prevent="create">
            <p>Add a book to library</p>
            <div class="grid-container">
                <div class="grid-x grid-padding-x">
                    <div class="cell medium-12 large-12 small-12">
                        <label>Name
                            <input type="text" v-model="form.name">
                        </label>
                    </div>
                    <div class="cell medium-12 large-12 small-12">
                        <label>Category
                            <input type="text" v-model="form.category">
                        </label>
                    </div>
                    <div class="cell medium-12 large-12 small-12">
                        <label>Year of release
                            <input v-model="form.year" >
                        </label>
                    </div>
                    <div class="cell medium-12 large-12 small-12">
                        <label>Book Image Url
                            <input v-model="form.url" type="text">
                        </label>
                    </div>
                    <div class="cell medium-12 large-12 small-12">
                        <button class="primary button expanded">Create Book</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
    import {mapGetters} from "vuex";

    export default {
        name: "Add_book",
        data() {
            return {
                form:{}
            }
        },
        methods: {
            create() {
                this.$store.dispatch('addbook',this.form);
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
