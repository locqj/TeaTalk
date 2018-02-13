<template>
    <div>
        <mt-checklist
        class="page-part"
        title="最多选四个"
        :max="4"
        v-model="interest_value"
        :options="options"
        >
      </mt-checklist>

      <div>
        <mt-cell title="选中的项">{{ interest_value }}</mt-cell>
      </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
             interest_value: [],
             options: []
        }
    },
    created() {
        let _this = this
        this.$http.get('/test/api/user/register/interesttag')
            .then((res) => {
                let data = res.data
                let options = []
                data.forEach((value, key) => {
                    options.push(value.code+'['+value.name+']')
                })
                _this.options = options
            })
    },
    watch: {
        interest_value: function(val) {
            console.log(val);
            this.$emit("interesttag", val)
        }
    },
}
</script>

<style lang="css">
</style>
