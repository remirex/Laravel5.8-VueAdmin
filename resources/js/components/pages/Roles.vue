<template>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Roles | <button class="btn btn-default" data-toggle="modal" data-target="#addNewRole">Add new <i class="nav-icon fas fa-key"></i></button></h3>

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
                        <th>Permissions</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="role in roles" :key="role.id">
                        <td>{{role.id}}</td>
                        <td>{{role.name}}</td>
                        <td><label class="badge badge-success mr-1" v-for="pv in role.permission">{{pv.name}}</label></td>
                        <td>
                            <i class="fas fa-user-edit edit" data-toggle="modal" v-bind:data-target="'#editRole'+role.id" @click="fillRoleDetails(role)"></i>&nbsp; |&nbsp;
                            <i class="fas fa-user-minus delete" @click="deleteRole(role.id)"></i>
                            <!-- Modal edit user -->
                            <div class="modal fade" :id="'editRole'+role.id" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Edit Role</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <input type="text" name="name" class="form-control" placeholder="Name" v-model="editRole.name"
                                                       :class="{ 'is-invalid': editRole.errors.has('name') }" @keydown="editRole.onKeydown($event)">
                                                <has-error :form="editRole" field="name"></has-error>
                                            </div>
                                            <div class="form-group">
                                                <multiselect
                                                        v-model="editRole.permission"
                                                        :options="permissions"
                                                        label="name"
                                                        track-by="id"
                                                        :searchable="false"
                                                        :multiple="true"
                                                        :taggable="true"
                                                        :close-on-select="false"
                                                        :clear-on-select="false"
                                                        placeholder="Select permission"
                                                        @tag="addTag">
                                                </multiselect>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                            <button type="button" class="btn btn-success" @click="updateRole(role.id)">Save changes</button>
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
        <div class="modal fade" id="addNewRole" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel2">New Role</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" name="name" class="form-control" placeholder="Name" v-model="roleForm.name"
                                   :class="{ 'is-invalid': roleForm.errors.has('name') }" @keydown="roleForm.onKeydown($event)">
                            <has-error :form="roleForm" field="name"></has-error>
                        </div>
                        <div class="form-group">
                            <multiselect
                                    v-model="roleForm.permission"
                                    :options="permissions"
                                    label="name"
                                    track-by="id"
                                    :searchable="false"
                                    :multiple="true"
                                    :taggable="true"
                                    :close-on-select="false"
                                    :clear-on-select="false"
                                    placeholder="Select permission"
                                    @tag="addTag"
                            >
                            </multiselect>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-success" @click="addRole">Add Role</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect';
    export default {
        components: {
            Multiselect
        },
        data() {
          return {
              roles: {},
              permissions: [],
              roleForm: new Form({
                  name: '',
                  permission: []
              }),
              editRole: new Form({
                  name: '',
                  permission: []
              })
          }
        },
        methods: {
            addTag (newTag) {
                const tag = {
                    name: newTag
                }
                this.options.push(tag)
                this.role.push(tag)
                this.permission.push(tag)
            },
            loadRoles() {
                axios.get('admin/roles')
                    .then(response => {
                        this.roles = response.data.data
                    })
                    .catch()
            },
            loadPermissions() {
                axios.get('admin/permissions')
                    .then(response => {
                        this.permissions = response.data.data
                    })
                    .catch()
            },
            addRole() {
                this.roleForm.post('admin/roles')
                    .then(() => {
                        toast.fire({
                            type: 'success',
                            text: 'Add role successfully'
                        })
                        $('#addNewRole').modal('toggle');
                        this.loadRoles();
                        this.roleForm.reset();
                    })
                    .catch(() => {
                        toast.fire({
                            type: 'error',
                            title: 'There was something wrong.'
                        })
                    })
            },
            fillRoleDetails(role) {
                this.editRole.fill(role);
            },
            updateRole(id) {
                this.editRole.put('admin/roles/' + id)
                    .then(() => {
                        this.loadRoles();
                        $('#editRole'+id).modal('toggle');
                        toast.fire({
                            type: 'success',
                            title: 'Your role was successfully updated!'
                        })
                        this.editRole.reset();
                    })
                    .catch(() => {
                        toast.fire({
                            type: 'error',
                            title: 'There was something wrong.'
                        })
                    })
            },
            deleteRole(id) {
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
                        this.editRole.delete('admin/roles/' + id)
                            .then(() => {
                                swal.fire(
                                    'Deleted!',
                                    'Your role has been deleted.',
                                    'success'
                                )
                                //helper.$emit('AfterAction');
                                this.loadRoles();
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
            this.loadRoles();
        },
        name: "Roles"
    }
</script>

<style scoped>

</style>