<template>
    <div class="control-group">
        <label class="control-label" for="selectError">Приказ Минэнерго, №</label>
        <div class="controls">
            <select @change="getletters()" id="selectError" name="order" data-rel="chosen" v-model="order">
                <option name="" hidden selected></option>
                <option v-for="order in orders" v-bind:value="order.id">{{ order.number }}</option>
            </select>
        </div>
        <div class="control-group">
            <label class="control-label" for="selectError">Ходатайство организации, №</label>
            <div class="controls">
                <select name="company[]" multiple v-model="letter">
                    <option name="" hidden selected></option>
                    <option v-for="letter in letters" v-bind:value="letter.id">{{ letter.company}}, письмо №{{ letter.number }}</option>
                </select>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        name: "addreports",

        created() {
            this.getorders()
        },
        data() {
            return {
                letters: [],
                letter: [],
                order: {},
                orders: [],
            }
        },
        methods: {
            getorders() {
                axios.get('/getnoncompleteorders').then(response => {
                    this.orders = response.data;
                }).catch(function (error) {
                    console.log(error.response);
                });
            },
            getletters() {
                axios.post('/getnoncompleteletters/' + this.order).then(response => {
                    this.letters = response.data;
                }).catch(function (error) {
                    console.log(error.response);
                })
            }
        }
    }
</script>

<style scoped>

</style>