<template>
    <!--新的朋友组件 交互没写完-->
    <div :class="{'search-open-contact':!$store.state.headerStatus}">
        <header id="wx-header">
            <div class="other" @click="newfriend"><span>添加朋友</span></div>
            <div class="center">
                <router-link to="/contact" tag="div" class="iconfont icon-return-arrow">
                    <span>通讯录</span>
                </router-link>
                <span>新的朋友</span>
            </div>
        </header>
        <div class="weui-cells message-list">
            <!-- 已接受列表 -->
            <div class="weui-cell" v-for="(item, key) in acceptusers">
                <div class="weui-cell__hd">
                    <img :src="item.head_img" alt=""> </div>
                <div class="weui-cell__bd weui-cell_primary">
                    <p><b>{{item.nickname}}</b></p>
                    <p><span>{{item.school_name}}-{{item.department_name}}</span></p>
                </div>
                <div class="weui-cell__ft">已添加</div>
            </div>

            <!-- 已拒绝列表 -->
            <div class="weui-cell" v-for="(item, key) in refuseusers">
                <div class="weui-cell__hd">
                    <img :src="item.head_img" alt=""></div>
                <div class="weui-cell__bd weui-cell_primary">
                    <p><b>{{item.nickname}}</b></p>
                    <p><span>{{item.school_name}}-{{item.department_name}}</span></p>
                </div>
                <div class="weui-cell_ft">已拒绝</div>
            </div>
            <!-- 等待操作列表 -->
            <div class="weui-cell" v-for="(item, key) in waitacceptusers">
                <div class="weui-cell__hd">
                    <img :src="item.head_img" alt=""></div>
                <div class="weui-cell__bd weui-cell_primary">
                    <p><b>{{ item.nickname }}</b></p>
                    <p><span>{{item.school_name}}</span></p>
                    <p><span>{{item.department_name}}</span></p>
                </div>
                <div class="weui-cell_ft">
                    <mt-button size="small"　@click="acceptfriend(item.user_code, key, item)"　class="addfriend">接受</mt-button>
                    <mt-button size="small"　 @click="refuse(item.user_code, key, item)" type="danger">拒绝</mt-button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import search from "../common/search"
    import { Toast, Radio } from 'mint-ui'

    export default {
        components: {
            search
        },
        data() {
            return {
                pageName: "新的朋友",
                waitacceptusers: {},
                acceptusers: {},
                refuseusers: {},
                userInfo: this.$store.state.userInfo,
            }
        },
        methods: {
            newfriend() {
                this.$router.push("/contact/add-friend")
            },
            acceptfriend(friend_code, key, data) {
                this.$http.post('/test/api/friends/doaccept', {
                    'user_code': this.userInfo.user_code,
                    'friend_code': friend_code
                }).then((res) => {
                    Toast({
                        message: res.data.original.msg,
                        position: 'bottom'
                    })
                    this.waitacceptusers.splice(key)
                    this.acceptusers.push(data)
                })
            },
            refuse(friend_code, key, data)　{
                this.$http.post('/test/api/friends/dorefuse', {
                    'user_code': this.userInfo.user_code,
                    'friend_code':　friend_code
                }).then((res) => {
                    Toast({
                        message: res.data.original.msg,
                        position: 'bottom'
                    })
                    this.waitacceptusers.splice(key)
                    this.refuseusers.push(data)
                })
            }
        },
        created() {
            this.$http.get('/test/api/friends/getlist?user_code='+this.userInfo.user_code)
            .then((res) => {
                this.waitacceptusers = res.data.getWaitFriends
                this.acceptusers = res.data.getFriends
                this.refuseusers = res.data.getRefuse
            })
        }
    }
</script>
<style>
    @import "../../assets/css/new-friends.css";
    .addfriend {
        background-color: #1aad19;
        color: #fff
    }
</style>
