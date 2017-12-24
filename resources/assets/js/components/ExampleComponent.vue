<template>
    <div class="box-content">
        <form class="form-horizontal" enctype="multipart/form-data">
            <fieldset>
                <div class="control-group">
                    <label class="control-label">Категория имущества</label>
                    <div class="controls">
                        <label class="radio">
                                    <span class="checked">
                                        <input type="radio" value="nomovable" v-model="mov" class="radio">
                                    </span>
                            недвижимое
                        </label>
                        <div style="clear:both"></div>
                        <label class="radio">
                                    <span class="checked">
                                        <input type="radio" v-model="mov" value="movable" class="radio">
                                    </span>
                            движимое
                        </label>
                        <div style="clear:both"></div>
                        <label class="radio">
                                    <span class="checked">
                                        <input type="radio" v-model="mov" value="mixed" class="radio">
                                    </span>
                            смешанное
                        </label>
                        <div style="clear:both"></div>
                        <label class="radio">
                                    <span class="checked">
                                        <input type="radio" v-model="mov" value="vehicle" class="radio">
                                    </span>
                            транспортное средство
                        </label>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Новый договор?</label>
                    <div class="controls">
                        <label class="radio">
                                    <span class="checked"><input type="radio" v-model="dog" value="new"
                                                                 class="radio"></span>
                            новый договор
                        </label>
                        <div style="clear:both"></div>
                        <label class="radio">
                                    <span class="checked"><input type="radio" v-model="dog" value="old"
                                                                 class="radio"></span>
                            дополнительное соглашение
                        </label>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Вид аренды</label>
                    <div class="controls">
                        <label class="radio">
                                    <span class="checked"><input type="radio" v-model="type" value="pay"
                                                                 class="radio"></span>
                            возмездно
                        </label>
                        <div style="clear:both"></div>
                        <label class="radio">
                                    <span class="checked"><input type="radio" v-model="type" value="free"
                                                                 class="radio"></span>
                            безвозмездно
                        </label>
                        <div style="clear:both"></div>
                        <label class="radio">
                            <span class="checked"><input type="radio" v-model="type" value="payfree" class="radio"></span>
                            смешанное
                        </label>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Период аренды</label>
                    <div class="controls">
                        <label class="radio">
                                    <span class="checked"><input type="radio" v-model="cont" value="mounthly"
                                                                 class="radio"></span>
                            Длительная
                        </label>
                        <div style="clear:both"></div>
                        <label class="radio">
                            <span class="checked"><input type="radio" v-model="cont" value="hourly" class="radio"></span>
                            Почасовая
                        </label>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Наличие стен, потолка</label>
                    <div class="controls">
                        <label class="radio">
                                    <span class="checked"><input type="radio" v-model="wall" value="true"
                                                                 class="radio"></span>
                            Eсть
                        </label>
                        <div style="clear:both"></div>
                        <label class="radio">
                                    <span class="checked"><input type="radio" v-model="wall" value="false"
                                                                 class="radio"></span>
                            Нет
                        </label>
                        <div style="clear:both"></div>
                        <label class="radio">
                            <span class="checked"><input type="radio" v-model="wall" value="mix" class="radio"></span>
                            смешанное
                        </label>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="typeahead">Номер письма организации</label>
                    <div class="controls">
                        <input type="text" name="number" class="input-xlarge datepicker" id="typeahead">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="date01">Дата письма организации</label>
                    <div class="controls">
                        <input type="text" name="date" class="input-xlarge datepicker" id="date01"
                               placeholder="xx.xx.xxxx">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="period">на срок по</label>
                    <div class="controls">
                        <input type="text" name="period" class="input-xlarge datepicker" id="period"
                               placeholder="xx.xx.xxxx">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="property">Имущество</label>
                    <div class="controls">
                        <input type="text" name="property" class="input-xlarge datepicker" id="property">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="arendodatel">Арендодатель:</label>
                    <div class="controls">
                        <input type="text" name="filial" class="input-xlarge datepicker" id="arendodatel"
                               placeholder="филиал">
                        <input type="text" name="arendodatel" class="input-xlarge datepicker" id=""
                               placeholder="организация">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="address">Расположенной:</label>
                    <div class="controls">
                        <input type="text" name="address" class="input-xlarge datepicker" id="address"
                               placeholder="адрес">
                    </div>
                </div>
                <div class="control-group" v-if="!advert">
                    <label class="control-label" for="contractor">Арендатору:</label>
                    <div class="controls">
                        <input type="text" v-model="contractor" name="contractor" class="input-xlarge datepicker"
                               id="contractor"
                               placeholder="наименование юр. лица">
                    </div>
                </div>

                <div v-if="!contractor" class="control-group" id="advert">
                    <label class="control-label">Объявление в интернет</label>
                    <div class="controls">
                        <label class="radio">
                            <span class="checked">
                                <input type="checkbox" v-model="advert" value="true">
                            </span>
                        </label>
                        <div style="clear:both"></div>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="target">Для размещения:</label>
                    <div class="controls">
                        <input type="text" v-model="target" class="input-xlarge datepicker" id="target"
                               placeholder="цель">
                    </div>
                </div>
                <div class="form-actions">
                    <button  type="button" @click="createletter" class="btn btn-large btn-info">Создать</button>
                    <button type="reset" class="btn btn-large btn-danger">отмена</button>
                </div>
            </fieldset>
        </form>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mount.')
        },
        methods: {
            createletter: function () {
                axios.get('/make_lease_letter/', {
                    contractor: this.contractor,
                    advert: this.advert,
                    move: this.move,
                    type: this.type,
                    dog: this.dog,
                    cont: this.cont,
                    wall: this.wall,
                    target: this.target,
                }).then(response => {
                    console.log(response.data);
                }).catch(function (error) {
                    console.log(error.response);
                });
            },
        },
        data() {
            return {
                contractor: '',
                advert: false,
                mov: '',
                dog: '',
                type: '',
                cont: '',
                wall: '',
                target: '',
            }
        },
    }
</script>
