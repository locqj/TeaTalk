import * as types from './types'


import axios from 'axios'

const mutations = {
    //切换语言 后期需要
    switchLang(state, lang) {
        state.currentLang = lang
        Vue.config.lang = lang
        document.cookie = "VR_LANG=" + lang + "; path=/;domain=.snail.com"
            // location.reload()
    },
    //设置当前页面名字
    setPageName(state, name) {
        state.currentPageName = name
    },
    //设置前一页名字 已遗弃
    // setBackPageName(state, name) {
    //     state.backPageName = name
    // },
    //当 search 组件全屏/非全屏时 切换公共头部状态
    toggleHeaderStatus(state, status) {
        state.headerStatus = status
    },
    //切换“微信”页中右上角菜单
    toggleTipsStatus(state, status) {
        if (status == -1) {
            state.tipsStatus = false
        } else {
            state.tipsStatus = !state.tipsStatus
        }
    },
    //增加未读消息数
    addNewMsg(state) {
        state.newMsgCount > 99 ? state.newMsgCount = "99+" : state.newMsgCount++
    },
    //减少未读消息数
    minusNewMsg(state) {
        state.newMsgCount < 1 ? state.newMsgCount = 0 : state.newMsgCount--
    },
    //将消息置顶 待完成
    setMsgStick(state, mid) {

    },
    //取消置顶消息 待完成
    cancelMsgStick(state, mid) {

    },
    //获取通讯录列表
    getFriendsList(state, user_code) {
        axios.get('/test/api/friends/getfriends?own_code='+user_code)
            .then((res) => {
                state.friendslist = res.data
            })
    },
    // 设置连接
    [types.SET_CONN] (state, conn) {
      if (conn != null && state.connection == null) {
          state.connection = conn;
      }
      // console.log(state.connection);

    },
    [types.DOLOGIN] (state, data) {
        state.token = data
        state.user = localStorage.userInfo
    },

    [types.DOLOGOUT] (state) {
        localStorage.removeItem('userInfo')
        localStorage.removeItem('token')
        state.user = {}
        state.token = null
    },
    // 改变在线状态
    [types.CHANGE_STATUS] (state, status) {
        state.online = status
        console.log(state.online)
    },
    // 过滤用户
    [types.FILTER_USER] (state, nickname) {
        state.filterUser = nickname
        console.log(state.filterUser);
    },
    [types.CHANGE_SESSION] (state, userId) {
        for (var i = state.users.length - 1; i >= 0; i--) {
            if (state.users[i].id != userId) {
                continue;
            }
            state.currentSession = state.users[i];
            break;
        }
        console.log(state.currentUser);
    },
    // 设置用户
    [types.SET_USER] (state, user) {
        state.currentUser = user
        console.log("自己的账户");
        console.log(state.currentUser);
    },
    // 添加用户(用户列表)
    [types.ADD_USER] (state, user) {
        if (user instanceof Array) {
            for (var i = user.length - 1; i >= 0; i--) {
                if (user[i].id != state.currentUser.id) {
                    user[i].has_message = false;
                    state.users.push(user[i]);
                }
            }
        }else{
            user.has_message = false;
            state.users.push(user);
        }
        console.log(state.users);
    },
    // 移除用户
    [types.REMOVE_USER] (state, userId) {
        state.users.forEach((item,index) => {
            if (item.id == userId) {
                state.users.$remove(item);
            }
        })
        console.log(state.users);
    },
    // 添加信息
    [types.ADD_MESSAGE] (state, message) {
        let msg = {
            user : {
                id : message.from,
                avatar : '',
                nickname : ''
            },
            msg : message.msg,
            time : message.date
        };
        if (message.from == state.currentUser.id) {
            msg.user = state.currentUser;
        }else{
            for (var i = state.users.length - 1; i >= 0; i--) {
                if (state.users[i].id == message.from) {
                    msg.user = state.users[i];
                    break;
                }
            }
        }

        if (message.to == 0) {
            if (state.broadcast[ 0 ] == undefined) {
                state.broadcast[ 0 ] = new Array;
            }

            state.broadcast[ 0 ].push(msg);

            state.broadcast.$set(0,state.broadcast[0]);
        }else{
            if (message.is_self == 1) {
                message.from = message.to;
            }


            if (state.broadcast[ message.from ] == undefined) {
                state.broadcast[ message.from ] = new Array;
            }

            state.broadcast[ message.from ].push(msg);

            state.broadcast.$set(message.from,state.broadcast[ message.from ]);
        }
        console.log(state.broadcast);
    },
    // 设置信息发送相关
    [types.SET_HAS_MESSAGE] (state, userId, status) {
        for (var i = state.users.length - 1; i >= 0; i--) {
            if (status == false && state.users[i].id == userId || state.users[i].id == userId && state.currentSession.id != userId ) {
                state.users[i].has_message = status;
            }
        }
    },
    // 统计发送个数
    [types.SET_COUNT] (state, count) {
        state.currentCount = count;
    },
    // 提示
    [types.SHOW_NOTICE] (state, msg, type) {
        state.notice = {
            show : true, msg, type
        }
        setTimeout(function(){
            state.notice.show = false;
        },1000);
    }



}
export default mutations
