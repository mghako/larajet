<template>
    <div class="container">
        <div class="row justify-content-center">
            <h1>User index</h1>
            <table class="table stripped">
                <thead>
                    <tr>
                        <td>Name</td>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="user in users" :key="user.id">
                        <td>{{ user.name }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                users:{}
                
            }
        },
        methods : {
            getUsers() {
                axios.get('/users')
                    .then(({ data }) => (this.users = data.data ))
                    .catch( ()=> {
                        console.log('no data')
                    })
            }
        },
        created() {
            this.getUsers()
            Start.$on('refreshUsers', () => {
                this.getUsers()
            })
        }
    }
</script>
