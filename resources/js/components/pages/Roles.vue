<template>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Roles | <button class="btn btn-default" data-toggle="modal" data-target="#addNewUser">Add new <i class="nav-icon fas fa-key"></i></button></h3>

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
                        <td><label class="badge badge-success mr-1" v-for="pv in role.permissions">{{pv.name}}</label></td>
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
                        <h5 class="modal-title" id="exampleModalLabel2">New Role</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" name="name" class="form-control" placeholder="Name">
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
                        <button type="button" class="btn btn-success">Add Role</button>
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
                  permission: ''
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