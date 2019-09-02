<template>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Permissions | <button class="btn btn-default" data-toggle="modal" data-target="#addNewUser">Add new <i class="nav-icon fas fa-key"></i></button></h3>

                <div class="card-tools d-flex">
                    <i class="fas fa-sync-alt p-2"></i>
                    <div class="input-group input-group-sm" style="width: 150px;">
                        <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="permission in permissions" :key="permission.id">
                        <td>{{permission.id}}</td>
                        <td>{{permission.name}}</td>
                        <td>
                            <i class="fas fa-user-edit edit"></i>&nbsp; |&nbsp;
                            <i class="fas fa-user-minus delete"></i>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

        <!-- Modal add new role -->
        <div class="modal fade" id="addNewUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel2">New Permission</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" name="name" class="form-control" placeholder="Name">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-success">Add Permission</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
          return {
              permissions: [],
              permissionForm: new Form({
                  name: ''
              })
          }
        },
        methods: {
            loadPermissions() {
                axios.get('admin/permissions')
                    .then(response => {
                        this.permissions = response.data.data
                    })
                    .catch()
            }
        },
        created() {
            this.loadPermissions();
        },
        name: "Permissions"
    }
</script>

<style scoped>

</style>