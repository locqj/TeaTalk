# bug

* 点赞的地方当前用户处理点赞，不知如何ajax处理当前状态，所以我先用页面刷新替代 ok
* img全转json上传,不然会不一致 ok
* vue的时间轴看好来改，通讯录　created　请求ajax　不会请求　单页面应用，所以考虑用store, muxxxx的那一套 子路由是可以写在created每次访问 ok
会自动请求，不过在一级路由是不会刷新 ok
* 点赞取消点赞不稳定，觉得全都要用store,muxxx　不然生命周期请求不了ok


* 登陆标志状态，在users表增加一个字段去标示（status_login），根据状态去区分用户是离线还是在线，在线走swoole，离线走关系型数据库的数据。在线的以k-v模式存在mongoDB中，当用户浏览了离线数据，重新插入mongoDB中。
* 登陆跳转模块还是有问题，第一次的token应该是没有去走main.js
* icon标签不统一，后期改标签的时候注意