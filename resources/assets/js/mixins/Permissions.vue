<script>
    import {mapGetters} from "vuex";
    export default {
        methods: {
            $canedit(permissionName,status) {
                console.log("The permisions granted are in mixins " , window.perm);
                console.log("This is the status of the book " , status);
                console.log("Thses is the permission we have been given " , permissionName);
                let permstat =  window.perm.indexOf(permissionName) !== -1;
                console.log("This is the status of the availability of the permission " , permstat);

                if(permstat === true && status === 9)
                {
                    console.log("Edit permission is present");
                    return true
                }
            },
            $candelete(permissionName,status) {
                console.log("The permisions granted are in mixins " , window.perm);
                console.log("This is the status of the book " , status);
                console.log("Thses is the permission we have been given " , permissionName);
                let permstat =  window.perm.indexOf(permissionName) !== -1;
                console.log("This is the status of the availability of the permission " , permstat)

                if(permstat === true && status === 9)
                {
                    console.log("delete permission is present");
                    return true
                }
            },
            $canborrow(permissionName,status) {
                console.log("The permisions granted are in mixins " , window.perm);
                console.log("This is the status of the book " , status);
                console.log("Thses is the permission we have been given " , permissionName);
                let permstat =  window.perm.indexOf(permissionName) !== -1;
                console.log("This is the status of the availability of the permission " , permstat)

                if(permstat === true && status === 9)
                {
                    console.log("borrow permission is present");
                    return true
                }
            },
            $canreserve(permissionName,status) {
                console.log("The permisions granted are in mixins " , window.perm);
                console.log("This is the status of the book " , status);
                console.log("Thses is the permission we have been given " , permissionName);
                let permstat =  window.perm.indexOf(permissionName) !== -1;
                console.log("This is the status of the availability of the permission " , permstat)

                if(permstat === true && status === 10)
                {
                    console.log("reserve permission is present");
                    return true
                }
            },


        },

    };
</script>

