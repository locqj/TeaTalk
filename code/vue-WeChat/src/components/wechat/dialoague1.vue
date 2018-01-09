<template>
    <div class="dialogue">
        <header id="wx-header">

            <div class="center">
                <router-link to="/" tag="div" class="iconfont icon-return-arrow">
                    <span>微信</span>
                </router-link>
                <span>{{pageName}}</span>
                <span class="parentheses" v-show='$route.query.group_num&&$route.query.group_num!=1'>{{$route.query.group_num}}</span>
            </div>
        </header>
        <section class="dialogue-section clearfix" id="wechat-content" v-on:click="MenuOutsideClick">
            <div class="row clearfix" :class="$store.getters.currentUser.id == item.user.id ? 'self' : ''" v-for="item in msgInfo[$store.getters.currentSession.id]">
                <img v-bind:src="item.user.avatar" v-bind:alt="item.user.nickname" :class="$store.getters.currentUser.id == item.user.id ? 'selfheader' : 'header'">
                <p :class="$store.getters.currentUser.id == item.user.id ? 'textself' : 'text'" v-more>{{ item.msg }}</p>
            </div>
            <span class="msg-more" id="msg-more">
                <ul>
                    <li>复制</li>
                    <li>转发</li>
                    <li>收藏</li>
                    <li>删除</li>
                </ul>
            </span>
        </section>
        <footer class="dialogue-footer">
            <div class="component-dialogue-bar-person">
                <span class="iconfont icon-dialogue-jianpan" v-show="!currentChatWay" v-on:click="currentChatWay=true"></span>
                <span class="more iconfont icon-dialogue-jia"></span>
                <!-- <span class="iconfont icon-dialogue-voice" v-show="currentChatWay" v-on:click="currentChatWay=false"></span> -->
                <div class="chat-way" v-show="!currentChatWay">
                    <div class="chat-say" v-press>
                        <span class="one">按住 说话</span>
                        <span class="two">松开 结束</span>
                    </div>
                </div>
                <div class="chat-way" v-show="currentChatWay">
                    <input class="chat-txt" type="text" v-model="msg" v-on:focus="focusIpt" v-on:blur="blurIpt"/>
                </div>
                <!-- <span class="expression iconfont icon-dialogue-smile">发送</span> -->
                <mt-button size="small" style="width: 14.5%; margin-top:0.8%; margin-left:1%;  margin-right:1%" @click="send">send</mt-button>
                <div class="recording" style="display: none;" id="recording">
                    <div class="recording-voice" style="display: none;" id="recording-voice">
                        <div class="voice-inner">
                            <div class="voice-icon"></div>
                            <div class="voice-volume">
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </div>
                        <p>手指上划,取消发送</p>
                    </div>
                    <div class="recording-cancel" style="display: none;">
                        <div class="cancel-inner"></div>
                        <p>松开手指,取消发送</p>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                pageName: this.$route.query.name,
                currentChatWay: true, //ture为键盘打字 false为语音输入
                timer: null,
                    // sayActive: false // false 键盘打字 true 语音输入
                msg: "",
            }
        },
        beforeRouteEnter(to, from, next) {
            next(vm => {
                vm.$store.commit("setPageName", vm.$route.query.name)
            })
        },
        computed: {
            msgInfo() {
                return this.$store.getters.broadcast
            }
        },
        directives: {
            press: {
                inserted(element, binding) {
                    var recording = document.querySelector('.recording'),
                        recordingVoice = document.querySelector('.recording-voice'),
                        recordingCancel = document.querySelector('.recording-cancel'),
                        startTx, startTy;

                    element.addEventListener('touchstart', function(e) {
                        // 用bind时，vue还没插入到dom,故dom获取为 undefine，用 inserted 代替 bind,也可以开个0秒的定时器
                        element.className = "chat-say say-active"
                        recording.style.display = recordingVoice.style.display = "block"
                            // console.log('start')
                        var touches = e.touches[0]
                        startTx = touches.clientX
                        startTy = touches.clientY
                        e.preventDefault()
                    }, false)
                    element.addEventListener('touchend', function(e) {
                        /*var touches = e.changedTouches[0];
                        var distanceY = startTy - touches.clientY;
                        if (distanceY > 50) {
                            console.log("取消发送信息");
                        }else{
                            console.log("发送信息");
                        }*/

                        element.className = "chat-say"
                        recordingCancel.style.display = recording.style.display = recordingVoice.style.display = "none"
                            // console.log('end')
                        e.preventDefault()
                    }, false)
                    element.addEventListener('touchmove', function(e) {
                        var touches = e.changedTouches[0],
                            endTx = touches.clientX,
                            endTy = touches.clientY,
                            distanceX = startTx - endTx,
                            distanceY = startTy - endTy;

                        if (distanceY > 50) {
                            element.className = "chat-say"
                            recordingVoice.style.display = "none"
                            recordingCancel.style.display = "block"
                        }else{
                            element.className = "chat-say say-active"
                            recordingVoice.style.display = "block"
                            recordingCancel.style.display = "none"
                        }
                        // 阻断事件冒泡 防止页面被一同向上滑动
                        e.preventDefault()
                    }, false);
                }
            },
            // 长按信息拦操作
            more: {
                bind(element, binding) {
                    var startTx, startTy
                    element.addEventListener('touchstart', function(e) {
                        var msgMore = document.getElementById('msg-more'),
                            touches = e.touches[0];
                        startTx = touches.clientX
                        startTy = touches.clientY

                        clearTimeout(this.timer)
                        this.timer = setTimeout(()=>{
                            // 控制菜单的位置
                            msgMore.style.left = ((startTx - 18) > 180 ? 180 : (startTx - 18)) + 'px'
                            msgMore.style.top = (element.offsetTop - 33) + 'px'
                            msgMore.style.display = "block"
                            element.style.backgroundColor = '#e5e5e5'
                        },500)

                    }, false)
                    element.addEventListener('touchmove', function(e) {
                        var touches = e.changedTouches[0],
                            disY = touches.clientY;
                        if (Math.abs(disY-startTy)>10) {
                            clearTimeout(this.timer)
                        }
                    }, false)
                    element.addEventListener('touchend', function(e) {
                        clearTimeout(this.timer)
                    }, false)
                }
            }
        },
        methods: {
            // 解决输入法被激活时 底部输入框被遮住问题
            focusIpt() {
                this.timer = setInterval(function() {
                    document.body.scrollTop = document.body.scrollHeight
                }, 100)
            },
            blurIpt() {
                clearInterval(this.timer)
            },
            // 点击空白区域，菜单被隐藏
            MenuOutsideClick(e) {
                var container = document.querySelectorAll('.text'),
                    msgMore = document.getElementById('msg-more')
                if (e.target.className === 'text') {

                } else {
                    msgMore.style.display = 'none'
                    container.forEach(item=>item.style.backgroundColor='#fff')
                }
            },
            // 信息发送
            send(e){
                let date = new Date().toLocaleString();
                let _this = this;
                let msg = {
                        from : _this.$store.getters.currentUser.id,
                        to :  _this.$store.getters.currentSession.id,
                        msg : this.msg,//_this.$store.getters.content,
                        date : date
                };
                // console.log(msg);
                if ( this.msg !== '' ) {
                     _this.$store.getters.conn.send(JSON.stringify(msg));
                     this.msg = '';
                     msg.is_self = 1;
                     _this.$store.dispatch('addMessage', msg);
                     console.log('done');
                }else{
                    console.log("msg not null");
                     // _this.$store.getters.showNotice(' 消息不能为空!','warning');
                }

            }
        }
    }
</script>
<style>
    @import "../../assets/css/dialogue.css";
    .say-active {
        background: #c6c7ca;
    }
    /* #wx-header {
        position: fixed;
        top: 0;
        width: 100%
    }
    #wechat-content {
        margin-top: 12%
    } */
</style>
