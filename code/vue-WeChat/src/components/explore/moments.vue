<template>
    <!--朋友圈组件 后期开发的核心-->
    <div id="moments">

        <header id="wx-header">
            <div class="center">
                <router-link to="/explore" tag="div" class="iconfont icon-return-arrow">
                    <span>发现</span>
                </router-link>
                <span>朋友圈</span>
                <router-link to="/explore/moments/new" style="color:#fff">
                    <span class="iconfont icon-tips-jia other"></span>
                </router-link>

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

        <!-- moments -->
        <div class="weui-cell moments__post" v-for="(item, key) in moment">
            <div class="weui-cell__hd">
                <img :src="userInfo.img">
            </div>
            <div class="weui-cell__bd" >
                <!-- 人名链接 -->
                <a class="title">
                    <span>{{ item.user_details.nickname }}</span>
                </a>
                <!-- post内容 -->
                <p id="paragraph" class="paragraph">{{ item.content }}</p>
                <!-- 伸张链接 -->
                <!-- <a id="paragraphExtender" class="paragraphExtender">显示全文</a> -->
                <!-- 相册 -->
                <div class="thumbnails my-gallery" v-if="item.img">
                    <figure itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject" class="thumbnail" v-for="(it, k) in item.img">

                        <a :href="it" itemprop="contentUrl" data-size="400x400">
                            <img :src="it" itemprop="thumbnail" alt="Image description" />
                        </a>
                        <figcaption itemprop="caption description">Image {{ k }}</figcaption>
                    </figure>
                </div>
                <!-- 资料条 -->
                <div class="toolbar">
                    <p class="timestamp">{{ item.time }}</p>
                    <mt-button id="actionToggle" class="actionToggle" @click.native="sheetVisible = true" @click="changecode(item.code, item.user_code, key, item.user_details.nickname)" v-if="item.dis_zan">...</mt-button>
                    <mt-button id="actionToggle" class="actionToggle" @click.native="sheetVisible1 = true" @click="changecode(item.code, item.user_code, key, item.user_details.nickname)" v-else>...</mt-button>
                </div>
                <!-- 赞／评论区 -->
                <p class="liketext"><i class="iconfont">&#xe874;</i><span class="nickname" v-for="it in item.zan">{{ it.name }},</span></p>
                <!-- 评论 -->

                <span v-for="it in item.comment">

                <p  class="contenttext" @click="replayComment(it, item)" > <span v-if="!it.status_first">回复</span><span class="nickname">{{ it.user_name }}</span>To<span class="nickname">{{ it.to_user_name }}:</span><span class="content">{{ it.content }}</span></p>



                </span>
                <!-- end 评论 -->
                <mt-actionsheet :actions="actions" v-model="sheetVisible" v-if="item.dis_zan"></mt-actionsheet>
                <mt-actionsheet :actions="actions2" v-model="sheetVisible1" v-else></mt-actionsheet>
            </div>
            <!-- 结束 post -->
        </div>
        <!-- end moments -->


        <!-- PhotoSwipe插件需要的元素， 一定要有类名 pswp -->
        <div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="pswp__bg"></div>
            <div class="pswp__scroll-wrap">
                <div class="pswp__container">
                    <div class="pswp__item"></div>
                    <div class="pswp__item"></div>
                    <div class="pswp__item"></div>
                </div>
                <!-- 预览区域顶部的默认UI，可以修改 -->
                <div class="pswp__ui pswp__ui--hidden">
                    <div class="pswp__top-bar">
                        <!--  与图片相关的操作 -->
                        <div class="pswp__counter"></div>
                        <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>
                        <!--将分享按钮去掉 -->
                        <!--<button class="pswp__button pswp__button--share" title="Share"></button>-->
                        <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>
                        <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>
                        <div class="pswp__preloader">
                            <div class="pswp__preloader__icn">
                                <div class="pswp__preloader__cut">
                                    <div class="pswp__preloader__donut"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                        <div class="pswp__share-tooltip"></div>
                    </div>
                    <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)"></button>
                    <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)"></button>
                    <div class="pswp__caption">
                        <div class="pswp__caption__center"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import { Actionsheet, Toast, MessageBox } from 'mint-ui';
    import PhotoSwipe from 'photoswipe'
    import PhotoSwipeUI_Default from 'photoswipe/dist/photoswipe-ui-default'
    import 'photoswipe/dist/photoswipe.css'
    import 'photoswipe/dist/default-skin/default-skin.css'
    export default {
        data() {
            return {
                sheetVisible: false,
                sheetVisible1: false,
                user_zan: false,
                moment_code:'',
                moment_user_code:'',
                userInfo: this.$store.state.userInfo,
                moment: {},
                actions: [],
                actions2: [],
                firstcomment: {}
            }
        },
        methods: {
            initPhotoSwipeFromDOM (gallerySelector) {
                var parseThumbnailElements = function (el) {
                    var thumbElements = el.childNodes,
                        numNodes = thumbElements.length,
                        items = [],
                        figureEl,
                        linkEl,
                        size,
                        item
                    for (var i = 0; i < numNodes; i++) {
                        figureEl = thumbElements[i];
                        if (figureEl.nodeType !== 1) {
                            continue
                        }
                        linkEl = figureEl.children[0];
                        size = linkEl.getAttribute('data-size').split('x')
                        item = {
                            src: linkEl.getAttribute('href'),
                            w: parseInt(size[0], 10),
                            h: parseInt(size[1], 10)
                        };
                        if (figureEl.children.length > 1) {
                            item.title = figureEl.children[1].innerHTML
                        }
                        if (linkEl.children.length > 0) {
                            item.msrc = linkEl.children[0].getAttribute('src')
                        }
                        item.el = figureEl
                        items.push(item)
                    }
                    return items
                }
                var closest = function closest(el, fn) {
                    return el && (fn(el) ? el : closest(el.parentNode, fn))
                }
                var onThumbnailsClick = function (e) {
                    e = e || window.event
                    e.preventDefault ? e.preventDefault() : e.returnValue = false
                    var eTarget = e.target || e.srcElement
                    var clickedListItem = closest(eTarget, function (el) {
                        return (el.tagName && el.tagName.toUpperCase() === 'FIGURE')
                    });

                    if (!clickedListItem) {
                        return;
                    }
                    var clickedGallery = clickedListItem.parentNode,
                        childNodes = clickedListItem.parentNode.childNodes,
                        numChildNodes = childNodes.length,
                        nodeIndex = 0,
                        index
                    for (var i = 0; i < numChildNodes; i++) {
                        if (childNodes[i].nodeType !== 1) {
                            continue
                        }
                        if (childNodes[i] === clickedListItem) {
                            index = nodeIndex
                            break
                        }
                        nodeIndex++
                    }

                    if (index >= 0) {
                        openPhotoSwipe(index, clickedGallery)
                    }
                    return false;
                }
                var photoswipeParseHash = function () {
                    var hash = window.location.hash.substring(1),
                        params = {}
                    if (hash.length < 5) {
                        return params;
                    }
                    var vars = hash.split('&');
                    for (var i = 0; i < vars.length; i++) {
                        if (!vars[i]) {
                            continue
                        }
                        var pair = vars[i].split('=');
                        if (pair.length < 2) {
                            continue
                        }
                        params[pair[0]] = pair[1];
                    }
                    if (params.gid) {
                        params.gid = parseInt(params.gid, 10)
                    }
                    return params
                }

                var openPhotoSwipe = function (index, galleryElement, disableAnimation, fromURL) {
                    var pswpElement = document.querySelectorAll('.pswp')[0],
                        gallery,
                        options,
                        items
                    items = parseThumbnailElements(galleryElement);
                    options = {
                        history:false,
                        galleryUID: galleryElement.getAttribute('data-pswp-uid'),
                        getThumbBoundsFn: function (index) {
                            var thumbnail = items[index].el.getElementsByTagName('img')[0],
                                pageYScroll = window.pageYOffset || document.documentElement.scrollTop,
                                rect = thumbnail.getBoundingClientRect()
                            return { x: rect.left, y: rect.top + pageYScroll, w: rect.width }
                        }

                    }
                    if (fromURL) {
                        if (options.galleryPIDs) {
                            for (var j = 0; j < items.length; j++) {
                                if (items[j].pid == index) {
                                    options.index = j
                                    break
                                }
                            }
                        } else {
                            options.index = parseInt(index, 10) - 1
                        }
                    } else {
                        options.index = parseInt(index, 10)
                    }
                    if (isNaN(options.index)) {
                        return ''
                    }
                    if (disableAnimation) {
                        options.showAnimationDuration = 0
                    }

                    gallery = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, items, options)
                    gallery.init()
                }
                var galleryElements = document.querySelectorAll(gallerySelector)
                for (var i = 0, l = galleryElements.length; i < l; i++) {
                    galleryElements[i].setAttribute('data-pswp-uid', i + 1)
                    galleryElements[i].onclick = onThumbnailsClick
                }
                var hashData = photoswipeParseHash()
                if (hashData.pid && hashData.gid) {
                    openPhotoSwipe(hashData.pid, galleryElements[hashData.gid - 1], true, true)
                }
            },
            zan () {
                this.$http.get('/test/api/dozan?moment_code='+this.moment_code+'&user_code='+this.userInfo.user_code)
                .then((res) => {
                    Toast({
                        message: '赞',
                        position: 'bottom'
                    })
                    let addzan = { name: this.userInfo.nickname }
                    for (let i in this.moment) {
                        if (i == this.firstcomment.key) {
                            this.moment[i].dis_zan = false
                            this.moment[i].zan.push(addzan)
                        }
                    }
                })


            },
            zan1 () {
                this.$http.get('/test/api/dozan?moment_code='+this.moment_code+'&user_code='+this.userInfo.user_code)
                .then((res) => {
                    Toast({
                        message: '取消点赞',
                        position: 'bottom'
                    })
                    let addzan = { name: this.userInfo.nickname }
                    for (let i in this.moment) {
                        if (i == this.firstcomment.key) {
                            let data =  this.moment[i].zan
                            for (let j in data) {
                                if (data[j].name == this.userInfo.nickname ) {
                                    this.moment[i].dis_zan = true
                                    data.pop()
                                }
                            }
                        }
                    }
                })



            },
            comment () {

                MessageBox.prompt(' ', '请输入评论').then(({ value }) => {
                    if (value) {
                        this.$http.post('/test/api/docomment', {
                         'content': value,
                         'moment_code': this.moment_code,
                         'user_code': this.userInfo.user_code,
                         'to_user_code': this.moment_user_code,
                         'parent_code': 'FMC0'+this.moment_code
                        })
                        .then((res) => {
                            Toast({
                                message: '评论成功',
                                position: 'bottom'
                            })
                            let addcomment = { user_name:this.userInfo.nickname, to_user_name: this.firstcomment.to_user_name, content: value, status_first: 1}
                            for (let i in this.moment) {
                                if (i == this.firstcomment.key) {
                                    this.moment[i].comment.push(addcomment)
                                }
                            }


                        })
                    }
                });
            },
            changecode (data, to_user_code, key, to_user_name) {
                this.moment_code = data
                this.moment_user_code = to_user_code
                this.firstcomment.key = key
                this.firstcomment.to_user_name = to_user_name
            },
            replayComment(it, item) {

                MessageBox.prompt(' ', '请输入回复').then(({ value }) => {
                    if (value) {
                        this.$http.post('/test/api/docomment', {
                         'content': value,
                         'moment_code': item.code,
                         'user_code': this.userInfo.user_code,
                         'to_user_code': it.to_user_code,
                         'parent_code': it.code
                        })
                        .then((res) => {
                            Toast({
                                message: '回复成功',
                                position: 'bottom'
                            })
                            for (let i in item) {
                                if (i == 'comment') {
                                    let addcomment = { user_name:this.userInfo.nickname, to_user_name: it.user_name, content: value, status_first: 0}
                                    item[i].push(addcomment)
                                }
                            }
                        })
                    }
                });

            }
        },
        mounted() {
            this.initPhotoSwipeFromDOM('.my-gallery');
            this.actions = [{
                name: '点赞',
                method: this.zan
            }, {
                name: '评论',
                method: this.comment
            }];
            this.actions2 = [{
                name: '取消点赞',
                method: this.zan1
            }, {
                name: '评论',
                method: this.comment
            }];

        },
        created () {
            this.$http.get('/test/api/getmoment/'+this.userInfo.user_code)
                .then((res) => {
                    this.moment = res.data.moments
                })
        }
    }

</script>
<style>
    @import "../../assets/css/moments.css";
    @import url('//at.alicdn.com/t/font_8d5l8fzk5b87iudi.css');
</style>
