import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)
    //app整体由店面页和店内页组成 暂时并没有用到嵌套路由
const routes = [
    {
        path: '/login',
        name: "登录",
        component: resolve => require(["../components/login/login.vue"], resolve)
    },{
        path: '/register',
        name: "注册",
        component: resolve => require(["../components/register/register.vue"], resolve)
    },{
            path: '/',
            name: "兴趣圈",
            components: {
                "default": resolve => require(["../components/intmoment/index.vue"], resolve),
            },
            meta: {
                    requireAuth: true,  // 添加该字段，表示进入这个路由是需要登录的
                }
    },{
            path: '/intmoment/addfriend',
            name: "添加好友",
            components: {
                "default": resolve => require(["../components/intmoment/index.vue"], resolve),
                "subPage": resolve => require(["../components/intmoment/addfriends.vue"], resolve),
            },
            meta: {
                    requireAuth: true,  // 添加该字段，表示进入这个路由是需要登录的
                }

    },{
            path: '/intmoment/add',
            name: "添加",
            components: {
                "default": resolve => require(["../components/intmoment/index.vue"], resolve),
                "subPage": resolve => require(["../components/intmoment/add.vue"], resolve)
            },
            meta: {
                    requireAuth: true,  // 添加该字段，表示进入这个路由是需要登录的
                }
    },{
        path: '/wechat',
        name: "微信",
        components: {
            "default": resolve => require(["../components/wechat/wechat.vue"], resolve),
        },
        meta: {
                requireAuth: true,  // 添加该字段，表示进入这个路由是需要登录的
            }
    },{
        path: '/wechat/dialogue',
        name: "",
        components: {
            "default": resolve => require(["../components/wechat/wechat.vue"], resolve),
            "subPage": resolve => require(["../components/wechat/dialogue.vue"], resolve)
        },
        meta: {
                requireAuth: true,  // 添加该字段，表示进入这个路由是需要登录的
            }
    },{
       path: '/wechat/dialogue1',
       name: "",
       components: {
           "default": resolve => require(["../components/wechat/wechat.vue"], resolve),
           "subPage": resolve => require(["../components/wechat/dialoague1.vue"], resolve)
       },
       meta: {
               requireAuth: true,  // 添加该字段，表示进入这个路由是需要登录的
           }
   },{
        path: '/wehchat/add-friend',
        name: "",
        components: {
            "default": resolve => require(["../components/wechat/wechat.vue"], resolve),
            "subPage": resolve => require(["../components/contact/add-friend.vue"], resolve)
        },
        meta: {
                requireAuth: true,  // 添加该字段，表示进入这个路由是需要登录的
            }
    },
    {
        path: '/wechat/dialogue/dialogue-info',
        name: "",
        components: {
            "subPage": resolve => require(["../components/wechat/dialogue-info.vue"], resolve)
        },
        meta: {
                requireAuth: true,  // 添加该字段，表示进入这个路由是需要登录的
            }
    },
    {
        path: '/wechat/dialogue/dialogue-detail',
        name: "",
        components: {
            "subPage": resolve => require(["../components/wechat/dialogue-detail.vue"], resolve)
        },
        meta: {
                requireAuth: true,  // 添加该字段，表示进入这个路由是需要登录的
            }
    },
    {
        path: '/contact',
        name: "通讯录",
        component: resolve => require(["../components/contact/contact.vue"], resolve),
        meta: {
                requireAuth: true,  // 添加该字段，表示进入这个路由是需要登录的
            }
    },
    {
        path: '/contact/add-friend',
        name: "",
        components: {
            "default": resolve => require(["../components/contact/contact.vue"], resolve),
            "subPage": resolve => require(["../components/contact/add-friend.vue"], resolve)
        },
        meta: {
                requireAuth: true,  // 添加该字段，表示进入这个路由是需要登录的
            }
    },
    {
        path: '/contact/details',
        name: "",
        components: {
            "default": resolve => require(["../components/contact/contact.vue"], resolve),
            "subPage": resolve => require(["../components/contact/details.vue"], resolve)
        },
        meta: {
                requireAuth: true,  // 添加该字段，表示进入这个路由是需要登录的
            }
    }, {
        path: '/contact/official-accounts',
        name: "",
        components: {
            "default": resolve => require(["../components/contact/contact.vue"], resolve),
            "subPage": resolve => require(["../components/contact/official-accounts.vue"], resolve)
        },
        meta: {
                requireAuth: true,  // 添加该字段，表示进入这个路由是需要登录的
            }
    },
    {
        path: '/contact/group-list',
        name: "",
        components: {
            "default": resolve => require(["../components/contact/contact.vue"], resolve),
            "subPage": resolve => require(["../components/contact/group-list.vue"], resolve)
        },
        meta: {
                requireAuth: true,  // 添加该字段，表示进入这个路由是需要登录的
            }
    },
    {
        path: '/contact/new-friends',
        name: "",
        components: {
            "default": resolve => require(["../components/contact/contact.vue"], resolve),
            "subPage": resolve => require(["../components/contact/new-friends.vue"], resolve)
        },
        meta: {
                requireAuth: true,  // 添加该字段，表示进入这个路由是需要登录的
            }
    }, {
        path: '/contact/tags',
        name: "新的朋友",
        components: {
            "default": resolve => require(["../components/contact/contact.vue"], resolve),
            "subPage": resolve => require(["../components/contact/tags.vue"], resolve)
        },
        meta: {
                requireAuth: true,  // 添加该字段，表示进入这个路由是需要登录的
            }
    }, {
        path: '/moments/moments',
        name: "朋友圈",
        components: {
            "default": resolve => require(["../components/self/self.vue"], resolve),
            "subPage": resolve => require(["../components/moments/moments.vue"], resolve)
        },
        meta: {
                requireAuth: true,  // 添加该字段，表示进入这个路由是需要登录的
            }
    }, {
        path: '/moments/moments/new',
        name: "添加朋友圈",
        components: {
            "default": resolve => require(["../components/moments/moments.vue"], resolve),
            "subPage": resolve => require(["../components/moments/addmoments.vue"], resolve)
        },
        meta: {
                requireAuth: true,  // 添加该字段，表示进入这个路由是需要登录的
            }
    }, {
        path: '/self',
        name: "我",
        component: resolve => require(["../components/self/self.vue"], resolve),
        meta: {
                requireAuth: true,  // 添加该字段，表示进入这个路由是需要登录的
            }
    },{
        path: '/self/album',
        components: {
            "default": resolve => require(["../components/self/self.vue"], resolve),
            "subPage": resolve => require(["../components/common/album.vue"], resolve)
        },
        meta: {
                requireAuth: true,  // 添加该字段，表示进入这个路由是需要登录的
            }
    },
    {
        path: '/self/settings',
        components: {
            "default": resolve => require(["../components/self/self.vue"], resolve),
            "subPage": resolve => require(["../components/self/settings.vue"], resolve)
        },
        meta: {
                requireAuth: true,  // 添加该字段，表示进入这个路由是需要登录的
            }
    },

    {
        path: '/self/profile',
        components: { "default": resolve => require(["../components/self/self.vue"], resolve), "subPage": resolve => require(["../components/common/profile.vue"], resolve) },
        meta: {
                requireAuth: true,  // 添加该字段，表示进入这个路由是需要登录的
            }
    }, {
        path: '/self/profile/my-qrcode',
        components: { "subPage": resolve => require(["../components/self/my-qrcode.vue"], resolve) },
        meta: {
                requireAuth: true,  // 添加该字段，表示进入这个路由是需要登录的
            }
    },
    { path: '/tologin', redirect: '/' },
    { path: '/tologout', redirect: '/login' }


]
export default new Router({
    base: "/vue-wechat/",
    routes
})
