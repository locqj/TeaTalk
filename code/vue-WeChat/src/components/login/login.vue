<template>
<div class="container" id="container">
    <div class="page home js_show">
        <div align="center"><img width="60" src="./../../assets/images/header/header01.png"></div>
        <div class="weui-loadmore weui-loadmore_line weui-loadmore_dot">
            <span class="weui-loadmore__tips"></span>
        </div>
        <div class="page__bd page__bd_spacing">
            <div class="weui-cells">
                <div class="weui-cell">
                    <div class="weui-cell__hd"><label class="weui-label">账户</label></div>
                    <div class="weui-cell__bd">
                        <input class="weui-input" type="text" placeholder="请输入用户名" v-model="userInfo.name">
                    </div>
                </div>
                <div class="weui-cell">
                    <div class="weui-cell__hd"><label class="weui-label">密码</label></div>
                    <div class="weui-cell__bd">
                        <input class="weui-input" type="password" pattern="[0-9]*" placeholder="请输入密码" v-model="userInfo.password">
                    </div>
                </div>
            </div>
        </div>
        <div class="weui-btn-area">
            <a class="weui-btn weui-btn_primary" href="javascript:" id="showTooltips" @click="login">登录</a>
        </div>
        <div class="weui-footer">
            <p class="weui-footer__links">
                <router-link to="" class="weui-footer__link">忘记密码？</router-link>
                <router-link to="/register" class="weui-footer__link">注册</router-link>
            </p>

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
import { Toast } from 'mint-ui'
import utils from '../../utils'
export default {
    data(){
        return{
            userInfo: {
                name: '',
                password: '',
                code: ''
            }
        }
    },
    methods: {
        getPosition() {
            const storage = window.localStorage
            var geolocation = new BMap.Geolocation();

            geolocation.getCurrentPosition(function(r){
            	if(this.getStatus() == BMAP_STATUS_SUCCESS){
                    var map = new BMap.Map()
                    let position = new BMap.Point(r.point.lng, r.point.lat)
                    position = JSON.stringify(position)
                    storage.setItem('position', position)

                    let position1 = new BMap.Point(106.486654, 29.490295)
                    let position2 = new BMap.Point(106.486654, 29.490295)

                    // let position2 = new BMap.Point(106.586654, 29.490295)
                    console.log(position1);
                    let distance = map.getDistance(position1, position2)

                    console.log('距离'+distance);
            	}
            });
            // utils.getLocation()
            // console.log('ok');
        },
        login () {
            const storage = window.localStorage
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
            } else {
                this.getPosition()
                this.$http.post('/test/api/user/login', this.userInfo)
                .then((res) => {
                    const data = res.data.original
                    if (data.code == 1) {
                        const userInfo = data.data.user
                        const token = data.data.token
                        storage.setItem('token', token)
                        storage.setItem('userInfo', JSON.stringify(userInfo))
                        this.$store.dispatch('DOLOGIN', token)//调用DOLOGIN的store
                        this.$store.dispatch('intMoments', userInfo.user_code)//调用DOLOGIN的store
                        this.$router.push({path: '/tologin'})

                    } else {
                        Toast({
                            message: '用户名或密码错误',
                            position: 'bottom'
                        })
                    }
                })
            }
        }
    }

}
</script>
<style>
    .locqj-footer {
        position: static;
        margin-top: 20%
    }
    .container {
        margin-top: 10%
    }
</style>
