<template>
    <!--添加好友组件 还需要完善-->
    <div class="add-friend">
        <header id="wx-header">
            <div class="center">
                <div v-on:click="$router.back()" class="iconfont icon-return-arrow">
                    <span>返回</span>
                </div>
                <span>添加朋友</span>
            </div>
        </header>
        <div class="search-line">
            <span class="iconfont icon-search"></span>
            <input type="text" placeholder="Tea-talk号"  @keyup="getusers" v-model="talkname">
        </div>
        <p style="padding-top:8px;text-align: center;">
            <span>我的Tea-talk号:</span>
            <span>{{ userInfo.users.name }}</span>
            <router-link to="/self/profile/my-qrcode">&nbsp;<img src="../../assets/images/contact_add-friend-my-qr.png" style="vertical-align: middle;;width:24px" class="_align-middle"></router-link>
        </p>
        <div class="weui-cells" >
            <a v-if="disusers" class="weui-cell weui-cell_access" v-for="item in users">
                <div class="weui-cell__hd"><img :src="item.head_img" alt=""></div>
                <div class="weui-cell__bd">
                    <p>{{ item.name }}</p>
                    <p>{{ item.school_name }} - {{ item.department_name }}</p>
                </div>
                <mt-button type="default" size="small" class="addfriend" @click="addfriend(item.code)">添加朋友</mt-button>
            </a>
        </div>
        <div class="weui-cells" >
            <a class="weui-cell weui-cell_access" v-for="item in waitacceptusers">
                <div class="weui-cell__hd"><img :src="item.head_img" alt=""></div>
                <div class="weui-cell__bd">
                    <p>{{ item.w_users.name }}</p>
                    <p>{{ item.school_name }} - {{ item.department_name }}</p>
                </div>
                <mt-button type="default" size="small" >等待通过</mt-button>
            </a>
        </div>

    </div>
</template>
<script>
    import { Toast, Radio } from 'mint-ui'
    export default {
        mixins: [window.mixin],
        data() {
            return {
                talkname: '',
                users: {},
                waitacceptusers: {},
                userInfo: this.$store.state.userInfo,
                disusers: false
            }
        },
        created () {
            this.$http.get('/test/api/friends/getwaitacceptusers?user_code='+this.userInfo.user_code)
            .then((res) => {
                this.waitacceptusers = res.data.user_manages
            })


        },
        mounted() {

        },
        methods: {
            getusers() {
                this.users = {}
                if (this.talkname) {
                    this.$http.get('/test/api/friends/getusers?talkname='+this.talkname+'&own_code='+this.userInfo.user_code)
                    .then((res) => {
                        this.users = res.data.users
                        this.disusers = true
                    })
                }
            },
            addfriend(friend_code) {
                this.$http.post('/test/api/friends/doadd', {
                    'user_code': this.userInfo.user_code,
                    'friend_code': friend_code
                }).then((res) => {
                    Toast({
                        message: res.data.original.msg,
                        position: 'bottom'
                    })
                })
            }

        }
    }

</script>
<style>
    .add-friend .search-line {
        position: relative;
        height: 50px;
        padding-left: 30px;
        padding-top: 5px;
        padding-bottom: 5px;
        background-color: #fff;
        border-top: 1px solid #d9d9d9;
        border-bottom: 1px solid #d9d9d9;
        margin-top: 20px;
    }

    .add-friend .icon-search {
        color: #40b938;
    }

    .add-friend .search-line input {
        width: calc(100% - 30px);
        font-size: 16px;
        height: 100%;
        border: 0;
        outline: none;
        vertical-align: middle;
    }

    .add-friend .weui-cell__hd img {
        width: 35px;
        display: block;
        margin-right: 10px;
    }

    .add-friend .weui-cell__bd p:last-child {
        font-size: 12px;
        color: #b7b7b7;
    }

    .add-friend.weui-cell__bd p:first-child {
        font-size: 15px
    }
    .addfriend {
        background-color: #1aad19;
        color: #fff
    }
    .note-users {
        margin-top: 10%;
        text-align: center;
        color: #b2b2b2;
        font-size: 18px

    }
</style>
