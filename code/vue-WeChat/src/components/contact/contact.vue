<template>
    <div id="contact">
        <section>
            <search></search>
            <div class="weui-cells_contact-head weui-cells weui-cells_access" style="margin-top:-1px">
                <router-link to="/contact/new-friends" class="weui-cell">
                    <div class="weui-cell_hd"> <img class="img-obj-cover" src="../../assets/images/contact_top-friend-notify.png"> </div>
                    <div class="weui-cell_bd weui-cell_primary">
                        <p>新的朋友</p>
                    </div>
                </router-link>
                <router-link to="/contact/group-list" class="weui-cell">
                    <div class="weui-cell_hd"> <img class="img-obj-cover" src="../../assets/images/contact_top-addgroup.png"> </div>
                    <div class="weui-cell_bd weui-cell_primary">
                        <p>群聊</p>
                    </div>
                </router-link>
                <router-link to="/contact/tags" class="weui-cell">
                    <div class="weui-cell_hd"> <img class="img-obj-cover" src="../../assets/images/contact_top-tag.png"> </div>
                    <div class="weui-cell_bd weui-cell_primary">
                        <p>标签</p>
                    </div>
                    
                </router-link>
            </div>
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
</section>
<!--检索-->
</div>
</template>
<script>
    import search from '../common/search'
    export default {
        mixins: [window.mixin],
        data() {
            return {
                pageName: "通讯录",
                userInfo: this.$store.state.user,
                friends: this.$store.state.friendslist

            }
        },
        methods: {
        },
        created() {
            console.log('test');
        },

        components: {
            search
        },
    }
</script>
<style>
    @import "../../assets/css/contact.css";
    
</style>