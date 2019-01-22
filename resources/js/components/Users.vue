<template>
    <div class="container">
        <div class="row justify-content-center" v-if="$gate.isAdmin()">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-dark">
                        <h3 class="card-title">Users List</h3>
                        <div class="card-tools">
                            <button class="btn btn-success"  data-toggle="modal" data-target="#popUserInfoModal" @click="popUserNewModal()">Add New <i class="fas fa-user-plus fa-fw"></i></button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <tbody>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Email</th>
                                    <th>Setting</th>
                                </tr>
                                <tr v-for="user in users" :key="user.id">
                                    <td>{{ user.id }}</td>
                                    <td>{{ user.name}}</td>
                                    <td>{{ user.type}}</td>
                                    <td>{{ user.email}}</td>
                                    <td>
                                        <a href="#" class="text-warning" @click="popUserEditModal(user)">
                                            <i class="fas fa-edit"></i>
                                        </a> /
                                        <a href="#" class="text-danger" @click="deleteUser(user.id)">
                                            <i class="fas fa-trash"></i>
                                        </a> |
                                        <a href="#" class="text-dark">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <div class="col-md-4">&nbsp;</div>
        </div>
        <div v-if="!$gate.isAdmin()">
        <not-found></not-found>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="popUserInfoModal" tabindex="-1" role="dialog" aria-labelledby="popUserModalTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 v-show="!editStatus" class="modal-title" id="popUserModalTitle">Create New User Account</h5>
                        <h5 v-show="editStatus" class="modal-title" id="popUserModalTitle">Edit User Account</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editStatus ? updateUser() :createUser()">
                    <div class="modal-body">
                       
                            <!-- User Name -->
                            <div class="form-group">
                                <label>Username</label>
                                <input v-model="form.name" type="text" name="name"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                <has-error :form="form" field="name"></has-error>
                            </div>
                            <!-- User Email -->
                            <div class="form-group">
                                <input v-model="form.email" type="email" name="email"
                                placeholder="Email Address"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                                <has-error :form="form" field="email"></has-error>
                            </div>
                            <!-- User Password -->
                            <div class="form-group">
                                <label>Password</label>
                                <input v-model="form.password" type="password" name="password"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                                <has-error :form="form" field="password"></has-error>
                            </div>
                            <!-- User Type -->
                            <div class="form-group">
                                <select  v-model="form.type" name="type" id="type" class="form-control" :class="{ 'is-invalid': form.errors.has('type') }">
                                    <option value="">Select User Role</option>
                                    <option value="admin">Admin</option>
                                    <option value="teacher">Teacher</option>
                                    <option value="parent">Parent</option>
                                    <option value="student">Student</option>
                                </select>
                                <has-error :form="form" field="type"></has-error>
                            </div>                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                        <button v-show="!editStatus" type="submit" class="btn btn-primary">Create</button>
                        <button v-show="editStatus" type="submit" class="btn btn-primary">Update</button>
                    </div>
                    </form>      
                </div>
            </div>
        </div>    
    </div>
</template>

<script>
    export default {
        data() {
            return {
                users:{},
                // Create a new form instance
                form: new Form({
                    id: '',
                    name: '',
                    email: '',
                    password: '',
                    type: '',
                    bio: '',
                    photo: ''
                }),
                editStatus: false
                
            }
        },
        methods : {
            getUsers() {
                this.$Progress.start()
                if(this.$gate.isAdmin()) {
                    axios.get('api/user')
                    .then(
                        ({ data }) => (this.users = data.data ))
                    .catch( ()=> {
                        console.log('no data')
                        this.$Progress.fail()
                    })
                    this.$Progress.finish()
                }
            },
            createUser() {
                this.form.post('api/user')
                    .then( () => {
                        Start.$emit('refreshUsers')
                        $('#popUserInfoModal').modal('hide')
                        this.form.reset()
                        toast({
                            type: 'success',
                            title: 'New User Created Successfully'
                        })
                    })
                    // .catch( () => {})
            },
            updateUser() {
                this.$Progress.start()
                this.form.put('api/user/'+this.form.id)
                    .then( () => {
                        Start.$emit('refreshUsers')
                        $('#popUserInfoModal').modal('hide')
                         toast({
                            type: 'success',
                            title: 'User Account Updated Successfully'
                        })
                        
                        this.$Progress.finish()
                    })
                    .catch( () => {
                        this.$Progress.fail()
                    })
            },
            deleteUser(id){
                this.$Progress.start()
                this.form.delete('api/user/'+id)
                    .then( () => {
                        Start.$emit('refreshUsers')
                         toast({
                            type: 'success',
                            title: 'User Account Deleted Successfully'
                        })
                        this.$Progress.finish()
                    })
                    .catch(() => {
                        this.$Progress.fail()
                    })
            },
            popUserNewModal(){
                this.editStatus = false
                this.form.reset()
                $('#popUserInfoModal').modal('show')
            },
            popUserEditModal(user) {
                this.editStatus = true
                this.form.reset()
                $('#popUserInfoModal').modal('show')
                this.form.fill(user)
            }
        },
        created() {
            this.getUsers()
            this.$Progress.start()
            Start.$on('refreshUsers', () => {
                this.getUsers()
            })
            this.$Progress.finish()
        }
    }
</script>
