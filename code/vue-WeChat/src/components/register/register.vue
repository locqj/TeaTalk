<template>
<div class="container" id="container">
    <div class="page home js_show">
        <div align="center"><img width="60" src="./../../assets/images/header/header01.png"></div>
        <div class="weui-loadmore weui-loadmore_line weui-loadmore_dot">
            <span class="weui-loadmore__tips"></span>
        </div>
        <div class="page__bd page__bd_spacing">
            <!--  -->
            <p class="upload-title">上传头像</p>
            <Uploads :src="'/test/api/uploadheadimg'" v-on:imgfilename="setimgsfilname"></Uploads>
            <div class="page-part">
                <mt-field label="Tea-talk号" placeholder="请输入Tea-talk号" v-model="userInfo.name"></mt-field>
                <mt-field label="昵称" placeholder="请输入昵称" v-model="userInfo.nickname"></mt-field>
                <mt-field label="密码" type="password" placeholder="请输入密码" v-model="userInfo.password"></mt-field>
                <mt-field label="确认密码" type="password" placeholder="请输入确认密码" v-model="userInfo.surpassword"></mt-field>
                <mt-field label="电话" placeholder="请输入电话" v-model="userInfo.phone"></mt-field>
                <mt-field label="邮箱" placeholder="请输入邮箱" v-model="userInfo.email"></mt-field>
                <mt-field label="生日" placeholder="请输入生日" type="date" v-model="userInfo.birthday"></mt-field>
                <mt-field label="自我介绍" placeholder="自我介绍" type="textarea" rows="4" v-model="userInfo.signlog"></mt-field>
            </div>
            
            <div class="page-radio">
                <mt-radio title="性别" v-model="userInfo.sex" :options="this.sexoption"></mt-radio>
            </div>
            

            <p>
                <mt-cell class="upload-title" title="选择学校,系别">
                    <span></span>
                </mt-cell>
                <SelectSchool v-on="{school: getschool, province_school: getprovince, major: getmajor}"></SelectSchool>
            </p>
            
        </div>
        <div class="weui-btn-area">
            <a class="weui-btn weui-btn_primary" href="javascript:" id="showTooltips" @click="register">注册</a>
        </div>
        
    </div>

    
    <div class="weui-footer weui-footer_fixed-bottom locqj-footer">
            <p class="weui-footer__links">
                <a href="javascript:home();" class="weui-footer__link">Tea-talk</a>
            </p>
            <p class="weui-footer__text">Copyright © 2014-2018 locqj.top</p>
    </div>   
</div>

</template>
<script>
import { Toast, Radio } from 'mint-ui'
import Uploads from './../Uploads/Uploads.vue'
import SelectSchool from './SelectSchool.vue'

export default {
    data(){
        return{    
            userInfo: {
                name: '',
                nickname: '',
                password: '',
                sex: '',
                school: '',
                email: '',
                school_province: '',
                department: '',
                phone: '',
                birthday: '',
                code: '',
                img: '',
                signlog: ''
            }
        }
    },
    methods: {
         
        setimgsfilname (data) {
            this.userInfo.img = data
        },
        register () {
            const storage = window.localStorage
            const phoneReg = /^1[34578]\d{9}$/        
            //const userInfo = storage.getItem('userInfo')
            if (!this.userInfo.name) {
                Toast({
                    message: '用户名不能为空',
                    position: 'bottom'
                })
            } else if (!this.userInfo.password) {
                Toast({
                    message: '密码不能为空',
                    position: 'bottom'

                })
            } else if (this.userInfo.password != this.userInfo.surpassword) {
                Toast({
                    message: '两次密码不一致',
                    position: 'bottom'

                })
            } else if (!this.userInfo.phone || !phoneReg.test(this.userInfo.phone)) {
                Toast({
                    message: '手机格式不正确',
                    iconClass: 'bottom'
                })
            } else if (!this.userInfo.sex) {
                Toast({
                    message: '请选择性别',
                    iconClass: 'bottom'
                })
            } else if (!this.userInfo.school) {
                Toast({
                    message: '学校不得为空',
                    position: 'bottom'

                })
            } else if (!this.userInfo.department) {
                Toast({
                    message: '院系不能为空',
                    position: 'bottom'

                })
            } else {
                this.$http.post('/test/api/user/register', this.userInfo)
                .then((res) => {
                const data = res.data.original
                    if (data.code) {
                        this.$router.push({path: data.data.url})
                    } else {
                        Toast({
                            message: data.data.msg,
                            position: 'bottom'
                        })
                    }
                })
            } 
        },
        sex ($sex) {
            if ($sex == 1) {
                console.log('asd')
            } else {
                // checked="checked"
            }
        },
        getschool (data) {
            this.userInfo.school = data
        },
        getprovince (data) {
            this.userInfo.school_province = data
        },
        getmajor (data) {
            this.userInfo.department = data
        },
        getimg (data) {
            this.userInfo.img = data
        },
        open (picker) {
            this.$refs[picker].open()
        },
    },
    created() {
        this.sexoption = [
            {
              label: '男',
              value: 1,
            },
            {
              label: '女',
              value: 2
            },
        ]
    },
    components: {
      SelectSchool,
      Uploads
    }

}
</script>
<style>
    .locqj-footer {
        position: static;
        margin-top: 10%    
    }
    .upload-title{
        
        margin-left: 2%;
        color: #888;
        display: block;
        font-size: 12px;
        
    }
</style>