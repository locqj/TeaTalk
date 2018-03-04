<template>
    <div class="album">
        <header id="wx-header">
            <div class="center">
                <router-link to="/self" tag="div" class="iconfont icon-return-arrow">
                    <span>我</span>
                </router-link>
                <span>相册</span>
            </div>
        </header>
        <div class="home-pic">
            <div class="home-pic-base">
                <div class="top-pic">
                    <div class="top-pic-inner">
                        <img :src="userInfo.img">
                    </div>
                </div>
                <div class="top-name _ellipsis">{{userInfo.nickname}}</div>
            </div>
        </div>
        <section class="album-box clearfix" v-for="(item, key) in moments">
            <div class="post-date">
                <b class="day">{{item.day}}</b>
                <b class="month">{{item.month}}月</b>
            </div>
            <div class="post-content">
                <div class="tumb-box">
                    <img :src="item.img[0]" alt="" v-if="item.img_count !== 0">
                </div>
                <div class="thumb-desc">
                    {{item.content}}
                    <p class="number" v-if="item.img_count !== 0">共{{item.img_count}}张</p>
                </div>
            </div>
        </section>

    </div>
</template>
<script>
    export default {
        data () {
            return {
                pageName: "我的相册",
                userInfo: this.$store.state.userInfo,
                edit: false,
                intros: '',
                sheetVisible: false,
                moments: {}
            }
        },
        created () {
            console.log(this.userInfo);
            this.$http.post('/test/api/own/moments', {user_code: this.userInfo.user_code}).then((res) => {
                console.log(res);
                this.moments = res.data
            })
        },
    }
</script>
<style>
    @import "../../assets/css/album.css";
</style>
