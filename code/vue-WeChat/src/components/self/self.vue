<template>
  <!--我 组件-->
  <div id="self">
    <div class="weui-tab__content" style="display: block;">
      <div class="weui-cells">

        <router-link to="/self/profile" class="weui-cell weui-cell_access">
          <div class="weui-cell__hd">
            <img :src="userInfo.img" alt="" class="self-header">
          </div>
          <div class="weui-cell__bd">
            <h4 class="self-nickname">{{ userInfo.nickname }}</h4>

            <p class="self-wxid">微信号: {{  userInfo.users.name }}</p>
          </div>
          <div class="weui-cell__ft">
            <img src="../../assets/images/chat-info-qr.png">
          </div>
        </router-link>
      </div>
      <div class="weui-cells">
          <router-link to="/moments/moments" class="weui-cell weui-cell_access" tag="div" v-on:click.native="momentNewMsg=false">
            <div class="weui-cell__hd">
              <img src="../../assets/images/find_icon-circle.png" >
            </div>
            <div class="weui-cell__bd" >
              朋友圈
            </div>
            <div class="weui-cell__ft">
              <div class="home__notice" v-show="momentNewMsg">
                <img src="https://sinacloud.net/vue-wechat/images/headers/yehua.jpg" alt="" class="">
                <!-- <i class="new-msg-dot"></i> -->
              </div>
            </div>
          </router-link>


        <router-link to="/self/album" class="weui-cell weui-cell_access">
          <div class="weui-cell__hd">
            <img src="../../assets/images/me_more-my-album.png">
          </div>
          <div class="weui-cell__bd">
            <p>相册</p>
          </div>
        </router-link>

        <router-link to="/self/settings" class="weui-cell weui-cell_access">
          <div class="weui-cell__hd">
            <img src="../../assets/images/me_more-setting.png">
          </div>
          <div class="weui-cell__bd">
            <p>设置</p>
          </div>
        </router-link>
    </div>
  </div>
  </div>
</template>
<script>
    export default {
        mixins: [window.mixin],
        data () {
            const _this = this
            return {
                pageName: "我",
                userInfo: this.$store.state.userInfo,
                edit: false,
                intros: '',
                sheetVisible: false,
                momentNewMsg: true
            }
        },
        created () {
            console.log('self-create');
        },
        mounted() {
            this.$store.commit("toggleTipsStatus", -1)
        },
        activated() {
            this.$store.commit("toggleTipsStatus", -1)
        },
        methods:{
            test(){
;
            }

        }
    }
</script>
<style>
    @import "../../assets/css/self.css";
</style>
