<template>
    <div>
        <div class="control-group">
            <label class="control-label" for="contractor">Арендатору:</label>
            <div class="controls">
                <input type="text" :disabled="this.advert" v-model="contractor" name="contractor"
                       class="input-xlarge datepicker"
                       id="contractor"
                       placeholder="наименование юр. лица">
            </div>
        </div>

        <div class="control-group" id="advert">
            <label class="control-label">Объявление в интернет</label>
            <div class="controls">
                <label class="radio">
                            <span class="checked">
                                <input :disabled="!!this.contractor" type="checkbox" name="advert" v-model="advert"
                                       value="true">
                            </span>
                </label>
                <div style="clear:both"></div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                contractor: '',
                advert: false
            }
        }

    }
</script>
