<script>
    import {mapGetters} from "vuex";
    export default {
        methods: {
            $canedit(permissionName,status) {

                let permstat =  window.perm.indexOf(permissionName) !== -1;
                console.log("This is the status of the availability of the permission " , permstat);

                if(permstat === true && status === 9)
                {
                    console.log("Edit permission is present");
                    return true
                }
            },
            $candelete(permissionName,status) {

                let permstat =  window.perm.indexOf(permissionName) !== -1;
                console.log("This is the status of the availability of the permission " , permstat);

                if(permstat === true && status === 9)
                {
                    console.log("delete permission is present");
                    return true
                }
            },
            $canborrow(permissionName,status) {

                let permstat =  window.perm.indexOf(permissionName) !== -1;
                console.log("This is the status of the availability of the permission " , permstat);

                if(permstat === true && status === 9)
                {
                    console.log("borrow permission is present and the book status is " + status);
                    return true
                }
            },
            $canreserve(permissionName,status) {

                let permstat =  window.perm.indexOf(permissionName) !== -1;
                console.log("This is the status of the availability of the permission " , permstat);

                if(permstat === true && status === 10)
                {
                    console.log("reserve permission is present and the book status is " + status);
                    return true
                }
            },


        },

    };
</script>

