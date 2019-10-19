<template>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Permissions | <button class="btn btn-default" data-toggle="modal" data-target="#addNewPermission">Add new <i class="nav-icon fas fa-key"></i></button></h3>

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
                            <i class="fas fa-user-edit edit" @click="editPermission(permission)" data-toggle="modal" v-bind:data-target="'#editPermission'+permission.id"></i>&nbsp; |&nbsp;
                            <i class="fas fa-user-minus delete" @click="deletePermission(permission.id)"></i>
                            <!-- Modal edit role -->
                            <div class="modal fade" :id="'editPermission'+permission.id" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content border-0">
                                        <div class="modal-header bg-warning-gradient">
                                            <h5 class="modal-title">New Permission</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <input type="text" name="name" class="form-control" placeholder="Name" v-model="editPermissionForm.name"
                                                       :class="{ 'is-invalid': editPermissionForm.errors.has('name') }" @keydown="editPermissionForm.onKeydown($event)">
                                                <has-error :form="editPermissionForm" field="name"></has-error>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                            <button type="button" class="btn btn-warning" @click="updatePermission(permission.id)">Save Changes</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

        <!-- Modal add new role -->
        <div class="modal fade" id="addNewPermission" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-dark-gradient">
                        <h5 class="modal-title" id="exampleModalLabel2">New Permission</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" class="text-white">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" name="name" class="form-control" placeholder="Name" v-model="permissionForm.name"
                                   :class="{ 'is-invalid': permissionForm.errors.has('name') }" @keydown="permissionForm.onKeydown($event)">
                            <has-error :form="permissionForm" field="name"></has-error>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-success" @click="addPermission">Add Permission</button>
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
              }),
              editPermissionForm: new Form({
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
            },
            addPermission() {
                this.permissionForm.post('admin/permissions')
                    .then(() => {
                        toast.fire({
                            type: 'success',
                            text: 'Add permission successfully'
                        })
                        $('#addNewPermission').modal('toggle');
                        this.loadPermissions();
                        this.permissionForm.reset();
                    })
                    .catch(() => {
                        toast.fire({
                            type: 'error',
                            title: 'There was something wrong.'
                        })
                    })
            },
            editPermission(permission) {
                this.editPermissionForm.fill(permission);
            },
            updatePermission(id) {
                this.editPermissionForm.put('admin/permissions/' + id)
                    .then(() => {
                        this.loadPermissions();
                        $('#editPermission'+id).modal('toggle');
                        toast.fire({
                            type: 'success',
                            title: 'Your permission was successfully updated!'
                        })
                        this.editPermissionForm.reset();
                    })
                    .catch(() => {
                        toast.fire({
                            type: 'error',
                            title: 'There was something wrong.'
                        })
                    })
            },
            deletePermission(id) {
                swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonClass: 'cancel-btn-class'
                }).then((result) => {
                    if(result.value) {
                        // send request to server
                        this.editPermissionForm.delete('admin/permissions/' + id)
                            .then(() => {
                                swal.fire(
                                    'Deleted!',
                                    'Your permission has been deleted.',
                                    'success'
                                )
                                //helper.$emit('AfterAction');
                                this.loadPermissions();
                            })
                            .catch(() => {
                                swal("Failed!", "There was something wronge.", "warning");
                            })
                    }
                })
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