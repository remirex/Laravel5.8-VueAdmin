<template>
    <!-- Info boxes -->
    <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">New Members</span>
                    <span class="info-box-number">{{resultCount}}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</template>

<script>
    export default {
        data() {
          return {
              users: {}
          }
        },
        methods: {
            loadUsers() {
                axios.get('admin/users')
                    .then(response => {
                        this.users = response.data.data
                    })
                    .catch()
            },
        },
        created() {
            this.loadUsers();
        },
        computed: {
            resultCount () {
                return this.users.length
            }
        },
        name: "Dashboard"
    }
</script>

<style scoped>

</style>