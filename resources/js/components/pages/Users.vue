<template>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Users | <button class="btn btn-default" data-toggle="modal" data-target="#addNewUser">Add new <i class="fas fa-user-plus"></i></button></h3>

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
                        <th>Email</th>
                        <th>Role</th>
                        <th>Permission</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="user in users.data" :key="user.id">
                        <td>{{user.id}}</td>
                        <td>{{user.name}}</td>
                        <td>{{user.email}}</td>
                        <td><label class="badge badge-success mr-1" v-for="rv in user.role">{{rv.name}}</label></td>
                        <td><label class="badge badge-success mr-1" v-for="pv in user.permission">{{pv.name}}</label></td>
                        <td>
                            <i class="fas fa-user-edit edit" data-toggle="modal" v-bind:data-target="'#editUser'+user.id" @click="fillUserDetails(user)"></i>&nbsp; |&nbsp;
                            <i class="fas fa-user-minus delete"></i>
                            <!-- Modal edit user -->
                            <div class="modal fade" :id="'editUser'+user.id" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">New User</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <input type="text" name="name" class="form-control" placeholder="Name" v-model="userForm.name">
                                            </div>
                                            <div class="form-group">
                                                <input type="email" name="email" class="form-control" placeholder="Email" v-model="userForm.email">
                                            </div>
                                            <div class="form-group">
                                                <multiselect
                                                        v-model="userForm.role"
                                                        :options="roles"
                                                        label="name"
                                                        track-by="id"
                                                        :searchable="false"
                                                        :multiple="true"
                                                        :taggable="true"
                                                        :close-on-select="false"
                                                        :clear-on-select="false"
                                                        placeholder="Select role"
                                                        @tag="addTag">
                                                </multiselect>
                                            </div>
                                            <div class="form-group">
                                                <multiselect
                                                        v-model="userForm.permission"
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
                                            <button type="button" class="btn btn-success" @click="addUser">Save changes</button>
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

        <!-- Modal add new user -->
        <div class="modal fade" id="addNewUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel2">New User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" name="name" class="form-control" placeholder="Name">
                        </div>
                        <div class="form-group">
                            <input type="email" name="email" class="form-control" placeholder="Email">
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" class="form-control" placeholder="Password">
                        </div>
                        <div class="form-group">
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Password Confirm">
                        </div>
                        <div class="form-group">
                            <multiselect
                                    v-model="userForm.role"
                                    :options="roles"
                                    label="name"
                                    track-by="id"
                                    :searchable="false"
                                    :multiple="true"
                                    :taggable="true"
                                    :close-on-select="false"
                                    :clear-on-select="false"
                                    placeholder="Select role"
                                    @tag="addTag">
                            </multiselect>
                        </div>
                        <div class="form-group">
                            <multiselect
                                    v-model="userForm.permission"
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
                        <button type="button" class="btn btn-success" @click="addUser">Add User</button>
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
              roles: [],
              permissions: [],
              users: {},
              userForm: new Form({
                  name: '',
                  email: '',
                  password: '',
                  role: [],
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
            getUsers() {
                axios.get('admin/users')
                    .then(response => {
                        this.users = response.data
                    })
                    .catch()
            },
            addUser() {

            },
            fillUserDetails(user) {
                //this.userForm.fill(user);
                this.userForm = Object.assign({}, user);
            },
            loadRoles() {
                axios.get('admin/roles')
                    .then(response => {
                        this.roles = response.data
                    })
                    .catch()
            },
            loadPermissions() {
                axios.get('admin/permissions')
                    .then(response => {
                        this.permissions = response.data
                    })
                    .catch()
            }
        },
        created() {
            this.getUsers();
            this.loadRoles();
            this.loadPermissions();
        },
        computed: {
            rolesArray() {
                return _.map(this.roles, function (num, key) {
                    return num.name;
                })
            },
            permissionsArray() {
                return _.map(this.permissions, function (num, key) {
                    return num.name;
                })
            }
        },
        name: "Users"
    }
</script>

<style scoped>

</style>