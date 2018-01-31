<template>
    <!--设置 组件-->
    <div class="setting">
        <header id="wx-header">
            <div class="center">
                <router-link to="/self" tag="div" class="iconfont icon-return-arrow">
                    <span>我</span>
                </router-link>
                <span>设置</span>
            </div>
        </header>
        <section>

            <div class="weui-cells">
                
            </div>
            <div class="weui-cells">

            </div>
            <div class="weui-btn-area" @click="logout">
                <button class="weui-btn weui-btn_warn" id="exitBtn">退出登录</button>
            </div>
        </section>
    </div>
</template>
<script>
    import { Toast } from 'mint-ui'
    export default {
        data () {
            return{

            }
        },

        methods: {
            logout() {
                this.$router.push({ path: '/tologout' })
                this.$store.dispatch('DOLOGOUT')
                Toast({
                    message: '登出成功',
                    position: 'bottom'
                })
                this.$router.go(0) //刷新页面
          }
        },

    }
</script>
