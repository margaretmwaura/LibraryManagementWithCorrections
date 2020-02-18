<script>
    import {mapGetters} from "vuex";
    export default {
        methods: {
            $can_edit(permissionName,status) {

                let perm_stat =  window.perm.indexOf(permissionName) !== -1;
                console.log("This is the status of the availability of the permission " , perm_stat ,"and the book availability is ",status);

                if(perm_stat && status)
                {
                    console.log("Edit permission is present");
                    return true
                }
            },
            $can_delete(permissionName,status) {

                let perm_stat =  window.perm.indexOf(permissionName) !== -1;
                console.log("This is the status of the availability of the permission " , perm_stat,"and the book availability is ",status);

                if(perm_stat && status)
                {
                    console.log("delete permission is present");
                    return true
                }
            },
            $can_borrow(permissionName,status) {

                let perm_stat =  window.perm.indexOf(permissionName) !== -1;
                console.log("This is the status of the availability of the permission " , perm_stat,"and the book availability is ",status);

                if(perm_stat && status)
                {
                    console.log("borrow permission is present and the book status is " + status);
                    return true
                }
            },
            $can_reserve(permissionName,status) {

                let perm_stat =  window.perm.indexOf(permissionName) !== -1;
                console.log("This is the status of the availability of the permission " , perm_stat,"and the book availability is ",status);

                if(perm_stat && status)
                {
                    console.log("reserve permission is present and the book status is " + status);
                    return true
                }
            },


        },

    };
</script>

