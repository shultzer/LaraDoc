<template>
    <div class="box span6">
        <div class="box-header">
            <h2><i class="halflings-icon white align-justify"></i><span class="break"></span>Пользователи</h2>

        </div>
        <div class="container-fluid">
            <input type="text" placeholder="name" v-model="username"/>
            <input type="email" placeholder="email" v-model="email"/>
            <input type="password" placeholder="password" v-model="pwd"/>
            <select v-model="role">
                <option value="1">guest</option>
                <option value="2">rup</option>
                <option value="3">spa</option>
                <option value="4">min</option>
                <option value="5">admin</option>
            </select>
            <button @click="adduser()" class="btn-success">Добавить</button>
        </div>
        <div class="box-content">
            <table class="table table-bordered">

                <thead>
                <tr>
                    <th>Пользователь</th>
                    <th>Роль</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>

                <tr v-for="user in users">
                    <td>{{ user.name}}</td>
                    <td>{{ user.roles[0].role}}</td>
                    <td>
                        <div class="box-icon">
                            <button @click="destroy(user.id)" class="btn-danger">удалить</button>
                            <button @click="edit(user.id)" class="btn-primary">редактировать</button>
                        </div>
                    </td>
                    <div class="modal fade" id="updateuser" data-backdrop="false">
                        <div class="modal-header">
                            <h4 class="modal-title">Редактирование</h4>
                        </div>
                        <div class="modal-body">
                            <input type="text" placeholder="name" v-model="user_update"/>
                            <input type="email" placeholder="email" v-model="email_update"/>
                            <!--<input type="password" placeholder="password" v-model="pwd_update"/>-->
                            <select v-model="role_update">
                                <option value="1">guest</option>
                                <option value="2">rup</option>
                                <option value="3">spa</option>
                                <option value="4">min</option>
                                <option value="5">admin</option>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close
                            </button>
                            <button type="button" data-toggle="modal" data-target="updateuser" @click="update()"
                                    class="btn btn-primary">
                                Изменить
                            </button>
                        </div>
                    </div><!-- /.modal-content --><!-- /.modal-dialog -->
                </tr>
                </tbody>
            </table>
        </div>
    </div><!--/span-->
</template>

<script>
    export default {
        name: "adduser",
        created() {
            this.getuserslist()
        },
        data() {
            return {
                users: [],
                username: '',
                email: '',
                pwd: '',
                role: '',
                user_update: '',
                id_update: '',
                email_update: '',
                role_update: '',
                pwd_update: '',
            }
        },
        methods: {
            adduser() {
                axios.post('/adduser', {
                    name: this.username,
                    email: this.email,
                    password: this.pwd,
                    role: this.role
                }).then(response => {
                    this.getuserslist()
                })
            },
            getuserslist() {
                axios.get('/getuserslist').then(response => {
                    this.users = response.data;

                })
            },
            destroy(id) {
                axios.post('/destroyuser/' + id).then(response => {
                    this.getuserslist()
                })
            },
            edit: function (id) {
                axios.post('/find/' + id).then(response => {
                    this.user_update = response.data.name;
                    this.id_update = response.data.id;
                    this.email_update = response.data.email;
                    this.pwd_update = response.data.password;
                    this.role_update = response.data.roles[0].id;

                });

                $("#updateuser").modal("show");
            },
            update() {
                axios.post('/updateuser', {
                    user: this.user_update,
                    email: this.email_update,
                    password: this.pwd_update,
                    role: this.role_update,
                    id: this.id_update
                }).then(response => {
                    console.log(response.data);
                    this.getuserslist();
                    $("#updateuser").modal("hide");
                })

            }
        }
    }
</script>

<style scoped>

</style>