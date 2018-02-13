<template>
    <!--朋友圈组件 后期开发的核心-->
    <div id="moments">
        <header id="wx-header">
            <div class="center">
                <span class="iconfont left" @click="back">取消</span>
                <span class="iconfont  right" @click="send">发送</span>
            </div>
        </header>
            <div class="weui-cells weui-cells_form">
                <div class="weui-cell">
                    <div class="weui-cell__bd">
                        <textarea class="weui-textarea" placeholder="这一刻的想法" rows="3" v-model="moment.content"></textarea>
                        <div class="weui-textarea-counter"><span>0</span>/200</div>
                    </div>
                </div>
            </div>
            <Uploads :src="'/test/api/uploadheadimg'" v-on:imgfilename="setimgsfilname"></Uploads>
        <div class="emply-block"></div>
        <div class="weui-cells">

            <mt-cell title="所在位置">
                <mt-switch v-model="moment.sharenear"></mt-switch>
            </mt-cell>

            <mt-radio
              title="发布的类型"
              v-model="moment.int_tag"
              :options="int_tags">
            </mt-radio>
            <div>
               <mt-cell title="选中的项">{{ moment.int_tag }}</mt-cell>
             </div>
        </div>
    </div>
</template>
<script>
import { Switch, Toast, Radio } from 'mint-ui'
import Uploads from './../Uploads/UploadsMore.vue'

export default {
     data(){
        return{
            moment:{
                img: "",
                content: "",
                sharenear: false,
                sharepublic: true,
                user_code: "",
                int_tag: ""
            },

        }
    },
    methods:{
        setimgsfilname (data) {
            this.moment.img = data
        },

        send () {
            if (!this.moment.content) {
                Toast({
                    message: "请输入内容",
                    position: 'bottom'
                })
            } else if (!this.moment.int_tag){
                Toast({
                    message: "请选择类型",
                    position: 'bottom'
                })
            } else {
                this.$http.post('/test/api/addintmoment', this.moment)
                .then((res) => {
                    let data = res.data.original
                    Toast({
                        message: data.msg,
                        position: 'bottom'
                    })
                this.$router.push('/')
                })
            }
        },
        back () {
            this.$router.push('/')
        }
    },
    created () {
        this.userInfo = this.$store.state.userInfo
        this.moment.user_code = this.userInfo.user_code
        let ins_code = this.$store.state.userInfo.ins_code
        let arr = []
        for (let index in ins_code)
        {
            arr.push(ins_code[index])
        }
        console.log(arr);
        this.int_tags = arr
    },
    components: {
      Uploads
    }
}

</script>
<style>
    @import "../../assets/css/moments.css";
    #moments{
        background: #eee
    }
    .left{
        float: left;
    }
    .right{
        float: right;
        color: #09bb07
    }
</style>
