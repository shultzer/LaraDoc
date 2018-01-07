<template>
    <div class="box span6">
        <div class="box-header">
            <h2>
                <i class="halflings-icon white align-justify"></i>
                <span class="break"></span>
                Категории имущества
            </h2>
        </div>
        <div class="container-fluid">
            <input type="text" v-model="companyname"/>
            <button @click="addcompany" class="btn-success">Добавить</button>
        </div>
        <div class="box-content">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Организация</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>

                <tr v-for="company in companies">
                    <td>{{ company.name}}</td>
                    <td>
                        <div class="box-icon">
                            <button @click="destroy(company.id)" class="btn-danger">удалить</button>
                            <!--
                                                            <button @click="edit(company.id)" class="btn-primary">редактировать</button>
                            -->
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div><!--/span-->
</template>

<script>
    export default {
        name: "properties",
        created() {
            axios.get('/properties').then(response => {
                this.companies = response.data
            })
        },
        data() {
            return {
                companies: [],
                companyname: '',
            }
        },
        methods: {

            addcompany() {
                axios.post('addproperty', {name: this.companyname}).then(response => {
                    axios.get('/properties').then(response => {
                        this.companies = response.data
                    })
                })
            },
            destroy(id) {
                axios.post('destroy/' + id).then(response => {
                    axios.get('/properties').then(response => {
                        this.companies = response.data
                    })
                })
            },
            edit(id) {
                $("#" + id).modal("show");
            },
            update(id) {
                axios.post('update/' + id).then(response => {
                    axios.get('/properties').then(response => {
                        this.companies = response.data
                    })
                })
            }
        }
    }
</script>

<style scoped>

</style>