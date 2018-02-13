import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import vuex from 'vue'
import App from './App'
import router from './router'
import store from './vuex/store'
import FastClick from 'fastclick' //使用 fastclick 解决移动端 300ms 点击延迟
import filters from './filters' //将全部过滤器放在 filters/index.js 中便于管理
import MintUI from 'mint-ui'
import 'mint-ui/lib/style.css'


//技巧 同时 use 多个插件 被依赖的插件应放在偏后方
Vue.use(MintUI)
Vue.use(VueAxios, axios, vuex)
    // 注册全局过滤器
filters(Vue)
// Vue.prototype.$http = axios
Vue.config.productionTip = false //将此值设置为 false ,会关闭 Vue 启动时的提示信息，推荐

FastClick.attach(document.body)


// 每次请求页面先赋值，　因为store是不持久的
if (window.localStorage.getItem('token')) {
  store.dispatch('DOLOGIN', window.localStorage.getItem('token'))//调用DOLOGIN的store
}

router.beforeEach((to, from, next) => {
    if (to.meta.requireAuth) {  // 判断该路由是否需要登录权限
        if (store.state.token || window.localStorage.getItem('token')) {  // 通过vuex state获取当前的token是否存在
            next()
            let friends = store.getters.friendslist
            // 添加朋友列表
            if (JSON.stringify(friends) == "{}") {
                let user = store.state.userInfo
                // 后台请求通讯录
                store.dispatch("getFriendsList", user.user_code)
            }
        } else {
            next({
                path: '/login'
            })
        }
    } else {
        next();
    }
})
// http request 拦截器
axios.interceptors.request.use(
    config => {
        if (store.state.token) {  // 判断是否存在token，如果存在的话，则每个http header都加上token
            config.headers.Authorization = `token ${store.state.token}`;
        }
        return config;
    },
    err => {
        return Promise.reject(err);
    });

// http response 拦截器
axios.interceptors.response.use(
    response => {
        return response;
    },
    error => {
        if (error.response) {
            switch (error.response.status) {
                case 401:
                    // 返回 401 清除token信息并跳转到登录页面
                    store.commit(types.LOGOUT);
                    router.replace({
                        path: 'login',
                        query: {redirect: router.currentRoute.fullPath}
                    })
            }
        }
        return Promise.reject(error.response.data)   // 返回接口返回的错误信息
    });



// axios.defaults.baseURL = 'http://localhost:8000'  // 配置axios默认的baseURL
// axios.defaults.headers['Content-Type'] = 'application/x-www-form-urlencoded'; //都变成string了臭嗨
/*axios 拦截器*/
new Vue({
        el: '#app',
        router,
        store,
        render: h => h(App)
    })
    // 运行 vue init webpack命令新建项目时 可以选择关闭 ESLint
    // 若新建项目时开启了 ESLint .eslintignore 文件，告诉 ESLint 去忽略特定的文件和目录。
    // .eslintignore 文件是一个纯文本文件，其中的每一行都是一个 glob 模式表明哪些路径应该忽略检测
