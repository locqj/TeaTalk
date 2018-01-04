<template>
    <div id="contact">

            <!--联系人集合-->
            <template v-for="(value,key) in friends">
                <!--首字母-->
                <div :ref="`key_${key}`" class="weui-cells__title">{{key}}</div>
                <div class="weui-cells">
                    <router-link  :to="{path:'/contact/details',query:{code: item.friend_code}}" class="weui-cell weui-cell_access"
                        v-for="item in value" tag="div">
                        <div class="weui-cell__hd">
                            <img :src="item.head_img" class="home__mini-avatar___1nSrW">
                        </div>
                        <div class="weui-cell__bd">
                            {{ item.w_user_details.nickname }}
                        </div>
                    </router-link>
                </div>
            </template>
    </div>
</template>
<script>
    export default {
        mixins: [window.mixin],
        data() {
            return {
                userInfo: JSON.parse(this.$store.state.user)
                friends: this.$store.getters.getFriendsList

            }
        },
        created () {
        },
        methods: {

        },
    }
</script>
<style>
    @import "../../assets/css/contact.css";
</style>
