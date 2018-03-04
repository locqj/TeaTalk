<template>
    <div class="profile">
        <header id="wx-header">
            <div class="center">
                <router-link to="/" tag="div" class="iconfont icon-return-arrow">
                    <span>兴趣圈</span>
                </router-link>

                <span>详细资料</span>
            </div>
        </header>
        <div class="weui-cells head-detail">
            <div class="weui-cell">
                <div class="weui-cell__hd"><img :src="userInfo.head_img" alt="" class="self-header" style="width:60px"></div>
                <div class="weui-cell__bd">
                    <h4 class="self-nickname">{{userInfo.user_details.nickname}}<span class="gender" :class="[userInfo.user_details.sex===1?'gender-male':'gender-female']"></span></h4>
                    <p class="self-wxid" style="font-size: 13px;color: #999;">微信号: {{userInfo.name}}</p>
                    <p class="nickname" style="font-size: 13px;color: #999;">昵称:{{userInfo.user_details.nickname||'无'}}</p>
                </div>
            </div>
        </div>
        <div class="weui-cells">
            <div class="weui-cell weui-cell_access">
                <div class="weui-cell__bd">
                    <p>设置备注和标签</p>
                </div>
                <div class="weui-cell__ft">

                </div>
            </div>
        </div>
        <div class="weui-cells">
            <div class="weui-cell">
                <div class="weui-cell__bd">
                    <p>地区</p>
                </div>
                <div class="weui-cell__ft" style="-webkit-flex: 4;text-align: left;">
                    <span>中国-{{userInfo.user_details.province}}&nbsp;&nbsp;&nbsp;</span>
                </div>
            </div>
            <div class="weui-cell weui-cell_access">
                <div class="weui-cell__bd">
                    <p>个人相册</p>
                </div>
                <div class="weui-cell__ft" style="-webkit-flex: 4;text-align: left;">
                    <div class="album-list">
                    </div>
                </div>
            </div>
            <div class="weui-cell weui-cell_access">
                <div class="weui-cell__bd">
                    <p>更多</p>
                </div>
                <div class="weui-cell__ft">

                </div>
            </div>
        </div>
        <a href="javascript:;" class="weui-btn weui-btn_primary" style="width:90%;margin-top:20px;" @click="addfriend()" v-if="!userInfo.exist_user">添加好友</a>

        <a href="javascript:;" class="weui-btn weui-btn_primary" style="width:90%;margin-top:20px;" @click="send()" v-else>发消息</a>

    </div>
</template>
<script>
    import { Toast } from 'mint-ui'
    import contact from "../../vuex/contacts"
    export default {
        data() {
            return {
                pageName: "",
                userInfo: {},
            }
        },
        created() {
            this.$http.get('/test/api/friends/getuser?user_code='+this.$route.query.code+'&own_code='+this.$route.query.own_code)
            .then((res) => {
                this.userInfo = res.data.user
                console.log(this.userInfo);
            });
        },
        methods: {
            // 添加好友
            addfriend() {
                this.$http.post('/test/api/friends/doadd', {
                    user_code: this.$route.query.own_code,
                    friend_code: this.$route.query.code
                }).then((res) => {
                    let data = res.data.original
                    Toast({
                        message: data.msg,
                        position: 'bottom'
                    })
                })
            },
            // 发送信息
            send() {
                this.$router.push({path: '/wechat/dialogue', query:{ mid: 3, name: this.userInfo.user_details.nickname, group_num: 1}})
            },
        }
    }
</script>
