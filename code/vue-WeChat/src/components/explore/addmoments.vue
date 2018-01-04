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
            <mt-cell title="共享于附近">
                <mt-switch v-model="moment.sharenear"></mt-switch>
            </mt-cell>
            <mt-cell :title="sharepublic_title">
                <mt-switch v-model="moment.sharepublic" @change="changesharetitle"></mt-switch>
            </mt-cell>
        </div>
    </div>
</template>
<script>
import { Switch, Toast } from 'mint-ui'

import Uploads from './../Uploads/UploadsMore.vue'

export default {
     data(){
        return{
            sharepublic_title: "公开",
            moment:{
                img: "",
                content: "",
                sharenear: false,
                sharepublic: true,
                user_code: ""
            }
        }
    },
    methods:{
        setimgsfilname (data) {
            this.moment.img = data
        },
        changesharetitle () {
            if(this.moment.sharepublic) {
                this.sharepublic_title = "公开"
            } else {
                this.sharepublic_title = "隐藏"
            }
        },
        send () {
            if (!this.moment.content) {
                Toast({
                    message: "请输入内容",
                    position: 'bottom'
                })
            } else {
                if (this.moment.sharenear) {
                    this.moment.sharenear = 1
                } else {
                    this.moment.sharenear = 0
                }
                if (this.moment.sharepublic) {
                    this.moment.sharepublic = 1
                } else {
                    this.moment.sharepublic = 0
                }
                this.$http.post('/test/api/addmoment', this.moment)
                .then((res) => {

                    let data = res.data.original

                    Toast({
                        message: data.msg,
                        position: 'bottom'

                    })
                this.$router.push('/explore/moments')


                })
            }
        },
        back () {
            this.$router.push('/explore/moments')
        }
    },
      created () {
            this.userInfo = this.$store.state.userInfo
            this.moment.user_code = this.userInfo.user_code
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
