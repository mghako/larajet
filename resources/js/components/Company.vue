<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-dark">
                        <h3 class="card-title">Company List</h3>
                        <div class="card-tools">
                            <button class="btn btn-success"  data-toggle="modal" data-target="#popCompanyInfoModal" @click="popNewCompanyModal">Add New <i class="fas fa-building fa-fw"></i></button>
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
                                    <th>Phone</th>
                                    <th>Setting</th>
                                </tr>
                                <tr v-for="company in companies" :key="company.id">
                                    <td>{{ company.id }}</td>
                                    <td>{{ company.name }}</td>
                                    <td>{{ company.type}}</td>
                                    <td>{{ company.email }}</td>
                                    <td>{{ company.phone }}</td>
                                    <td>
                                        <a href="#" class="text-warning" @click="popEditCompanyModal(company)">                                            <i class="fas fa-edit"></i>
                                        </a> /
                                        <a href="#" class="text-danger" @click="deleteCompany(company.id)">
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
            <div class="col-md-6"></div>
        </div>


        <!-- Modal -->
        <div class="modal fade" id="popCompanyInfoModal" tabindex="-1" role="dialog" aria-labelledby="popUserModalTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 v-show="!editStatus" class="modal-title" id="popModalTitle">Create New Company Info</h5>
                        <h5 v-show="editStatus" class="modal-title" id="popModalTitle">Edit Company Info</h5>
                        <!-- <h5 v-show="editStatus" class="modal-title" id="popUserModalTitle">Edit User Account</h5> -->
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editStatus ? editCompany() : createCompany()">
                    <div class="modal-body">
                        <!-- Company Name -->
                        <div class="form-group">
                            <label>Company Info</label>
                            <input v-model="form.name" type="text" name="name" placeholder="Company Name"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                            <has-error :form="form" field="name"></has-error>
                        </div>
                        <!-- Company Email -->
                        <div class="form-group">
                            <input v-model="form.email" type="email" name="email"
                            placeholder="Email"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                            <has-error :form="form" field="email"></has-error>
                        </div>
                         <!-- Company Address -->
                        <div class="form-group">
                            <input v-model="form.address" type="text" name="address"
                            placeholder="Address"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('address') }">
                            <has-error :form="form" field="address"></has-error>
                        </div>
                        <!-- Company Type -->
                        <div class="form-group">
                            <select  v-model="form.type" name="type" id="type" class="form-control" :class="{ 'is-invalid': form.errors.has('type') }">
                                <option value="">Select Compay Type</option>
                                <option value="it">IT</option>
                                <option value="gov">Gov</option>
                                <option value="ngo">Ngo</option>
                            </select>
                            <has-error :form="form" field="type"></has-error>
                        </div>
                        <!-- Company Phone -->
                        <div class="form-group">
                            <label>Phone</label>
                            <input v-model="form.phone" type="text" name="name"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                            <has-error :form="form" field="name"></has-error>
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
                editStatus: false,
                companies: '',
                form: new Form({
                id: '',
                name: '',
                type: '',
                email: '',
                phone: '',
                address: ''
            })
            }
        },
        methods: {
            getCompanies() {
                this.$Progress.start()
                axios.get('api/company')
                    .then(
                        ({ data }) => (this.companies = data.data ))
                    .catch( ()=> {
                        console.log('no data')
                        this.$Progress.fail()
                    })
                    this.$Progress.finish()
            },
            createCompany() {                
                this.$Progress.start()
                this.form.post('api/company')
                    .then(()=> {                       
                        this.form.reset()
                        $('#popCompanyInfoModal').modal('hide') 
                        Start.$emit('refreshCompany')                       
                        toast({
                            type: 'success',
                            title: 'New Company Info Created Successfully'
                        })
                        this.$Progress.finish()
                    })
                    .catch(() => {
                        this.$Progress.fail()
                    })
            },
            editCompany() {
                this.$Progress.start()
                this.form.put('api/company/'+this.form.id)
                    .then( () => {
                        $('#popCompanyInfoModal').modal('hide') 
                        Start.$emit('refreshCompany')                       
                        toast({
                            type: 'success',
                            title: 'Company Info Updated Successfully'
                        })
                        this.$Progress.finish()
                    })
                    .catch( () => {
                        this.$Progress.fail()
                    })
            },
            deleteCompany(id){                
                this.$Progress.start()
                swal({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                    }).then( (result) => {
                        this.form.delete('api/company/'+id)
                            .then( ()=> {
                                if (result.value) {
                                     swal(
                                        'Deleted!',
                                        'Company Info have been deleted.',
                                        'success'
                                    )
                                     Start.$emit('refreshCompany')
                                }
                                this.$Progress.finish()
                            })
                            .catch( ()=> {
                                this.$Progress.fail()
                            })
                    })                     
            },
            popNewCompanyModal() {
                this.editStatus = false
                this.form.reset()
                $('#popCompanyInfoModal').modal('show')
            },
            popEditCompanyModal(company) {
                this.editStatus = true
                $('#popCompanyInfoModal').modal('show')
                this.form.reset()
                this.form.fill(company)

            }
        },
        created() {
                this.getCompanies()
                Start.$on('refreshCompany', () => {
                this.getCompanies()
                })
                this.$Progress.finish()
            
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
