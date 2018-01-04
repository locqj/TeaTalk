<template>
    <!--微信组件-->
  <div id="wechat">
    <ul class="wechat-list">
        <!--props传递消息对象 baseMsgObj -->
        <msg-item v-for="baseMsgObj in $store.state.msgList.baseMsg" :item="baseMsgObj" class="list-row line-bottom" :key="baseMsgObj.mid"></msg-item>
    </ul>
    <!-- tests -->
    <hr style="margin-top: 120px">
    <ul>
        <li v-for="user in users" track-by="id" v-bind:id="user.id" v-on:click="changeSession(user.id)">
            <img v-bind:src="user.avatar" v-bind:alt="user.name" width="30">
            <p>{{ user.nickname }} <span v-if="user.id == 0">({{ currentCount }})</span></p>
            <div v-bind:class="[ user.has_message ? 'dot' : '' ]"></div>
        </li>
    </ul>
  </div>
</template>
<script>
    import search from "../common/search"
    import msgItem from "../wechat/msg-item"
    export default {
        components: {
            search,
            msgItem
        },
        mixins: [window.mixin],
        data() {
            return {
                pageName: "微信",
                users: this.$store.getters.users,
                currentCount: this.$store.getters.currentCount

            }
        },

        created : function(){
            let conn = new WebSocket('ws://127.0.0.1:9502')
            let _this = this
            conn.onopen = function(evt){
                console.log("connect open")
                _this.$store.dispatch('changeStatus', true)
            }
            conn.onclose = function(evt){
                console.log("connect close")
                _this.$store.dispatch('changeStatus', false)
            }
            conn.onmessage = function(evt){
                console.log("message")
                let msg = JSON.parse(evt.data)
                switch(msg.type){
                    case 'connect':
                        _this.$store.dispatch('addUser', msg.data);
                        _this.$store.dispatch('setCount', msg.data.count);
                        console.log("message-conn")
                        break;
                    case 'disconnect':
                        _this.$store.dispatch('removeUser', msg.data.id);
                        _this.$store.dispatch('setCount', msg.data.count);
                        console.log("message-disconn")
                        break;
                    case 'self_init':
                        _this.$store.dispatch('setUser', msg.data);
                        _this.$store.dispatch('setCount', msg.data.count);
                        console.log("message-self-init");
                        break;
                    case 'other_init':
                        _this.$store.dispatch('addUser', msg.data);
                        console.log("message-adduser");
                        break;
                    case 'message':
                        _this.$store.dispatch('addMessage', msg.data);
                        console.log("message-addMsg");
                        break;
                }
            }
            // 保存conn
            _this.$store.dispatch('SETCONN', conn)
        },

        methods : {
            changeSession (userId) {
                if (typeof userId == 'number') {
                    this.selectSession(userId);
                    this.setHasMessageStatus(userId,false);
                }
            }
        }
    }
</script>
<style>
    @import "../../assets/css/wechat.css";
    #wechat {
        margin-top: 7%;
    }

    /*  */
    .list{
        height: 479px;
        overflow-y: scroll;
        overflow-x: hidden;
        &::-webkit-scrollbar-button{
            display: none;
        }
        &::-webkit-scrollbar{
            width: 8px;
            background-color: #4d4d4d;
        }

        /*定义滚动条轨道 内阴影+圆角*/
        &::-webkit-scrollbar-track{
            background-color: #2e3238;
        }

        /*定义滑块 内阴影+圆角*/
        &::-webkit-scrollbar-thumb{
            border-radius: 10px;
            background: rgba(255,255,255,0.1);
        }

        ul{
            margin: 0; padding: 0;
        }
        li{
            display: flex;
            flex-direction: row;
            align-items: center;
            height: 60px;
            cursor: pointer;
            border-bottom: 1px solid #292c33;
            padding: 15px;
            &:hover{
                background: rgba(255,255,255,0.03);
            }
            &.active{
                background: rgba(255,255,255,0.1);
            }

            img{
                width: 30px;
                height: 30px;
            }
            p{
                margin-left: 15px;
                font-size: 16px;
            }
            .dot{
                width: 8px;
                height: 8px;
                border-radius: 50%;
                align-self: center;
                margin-left: 10px;
                background: #ff0000;
            }
        }
    }
</style>
