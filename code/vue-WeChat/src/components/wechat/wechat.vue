<template>
    <!--微信组件-->
  <div id="wechat">
    <ul class="wechat-list">
        <!--props传递消息对象 baseMsgObj -->
        <msg-item1 v-for="baseMsgObj in $store.state.msgList.baseMsg" :item="baseMsgObj" class="list-row line-bottom" :key="baseMsgObj.mid"></msg-item1>
    </ul>
    <hr style="margin-top: 120px">

    <ul class="wechat-list">
        <!--props传递消息对象 baseMsgObj -->
        <msg-item v-for="baseMsgObj in $store.state.users" :item="baseMsgObj" class="list-row line-bottom" ></msg-item>
    </ul>
    <!-- tests -->
    <hr style="margin-top: 120px">

    <ul>
        <li v-for="user in users" track-by="id" v-bind:id="user.id" v-on:click="changeSession(user.id, user.nickname)" v-if="user.id != $store.state.currentUser.id">
            <img v-bind:src="user.avatar" v-bind:alt="user.name" width="30">
            <p>{{ user.nickname }} <span v-if="user.id == 0">({{ currentCount }})</span></p>
            <div v-if="user.has_message">
                有
            </div>
            <div v-else>
                无
            </div>
        </li>
    </ul>
  </div>
</template>
<script>
    import search from "../common/search"
    import msgItem from "../wechat/msg-item"
    import msgItem1 from "../wechat/msg-item1"


    // Vue.use(baiduLocation)
    export default {
        components: {
            search,
            msgItem,
            msgItem1,
        },
        mixins: [window.mixin],
        data() {
            return {
                pageName: "微信",
                users: this.$store.getters.users,
                currentCount: this.$store.getters.currentCount

            }
        },
        created : function () {
            const storage = window.localStorage
            console.log(storage.getItem('position'));
            let user_code = this.$store.state.userInfo.user_code
            let nickname = this.$store.state.userInfo.nickname
            let img = this.$store.state.userInfo.img
            let _this = this
            // this.$http.post('/test/api/friends/getownfriends', {own_code: this.$store.state.userInfo.user_code})
            //   .then((res) => {
            //       _this.$store.dispatch('ownFriends', res.data.user_manages)
                  // let friends = res.data.user_manages

                  let conn = new WebSocket("ws://127.0.0.1:9502?user_code=" + user_code + "&nickname=" + nickname + "&img="+ img)
                  conn.onopen = function(evt){
                      _this.$store.dispatch('changeStatus', true)
                  }
                  conn.onclose = function(evt){
                      _this.$store.dispatch('changeStatus', false)
                  }
                  conn.onmessage = function(evt){
                      let msg = JSON.parse(evt.data)
                      switch(msg.type){
                          case 'connect':
                              _this.$store.dispatch('addUser', msg.data);
                              _this.$store.dispatch('setCount', msg.data.count);
                              break;
                          case 'disconnect':
                              _this.$store.dispatch('removeUser', msg.data.id);
                              _this.$store.dispatch('setCount', msg.data.count);
                              break;
                          case 'self_init':
                              console.log('count');
                              _this.$store.dispatch('setUser', msg.data);
                              _this.$store.dispatch('setCount', msg.data.count);
                              break;
                          case 'other_init':
                              _this.$store.dispatch('addUser', msg.data);

                              break;
                          case 'message':
                              _this.$store.dispatch('addMessage', msg.data);
                              break;
                      }
                  }
                  // 保存conn
                  this.$store.dispatch('SETCONN', conn)
                  console.log(this.$store.getters.users)
              // })


        },

        methods : {
            changeSession (userId, nickname) {
                this.$router.push({path: '/wechat/dialogue1', query: { name: nickname}})
                if (typeof userId == 'number') {
                    this.$store.dispatch('selectSession', userId)
                    this.$store.dispatch('setHasMessageStatus', userId)
                    // this.setHasMessageStatus(userId,false);
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
