<template>
    <!--朋友圈组件 后期开发的核心-->
    <div id="moments">
        <mt-navbar v-model="selected" class="nav-head" >
          <mt-tab-item :id="key" v-for="(item, key) in navs">{{item.nav}}</mt-tab-item>
        </mt-navbar>
        <!-- tab-container -->
        <mt-tab-container v-model="selected" style="margin-top: 1%">
          <mt-tab-container-item :id="key" v-for="(item, key) in navs">
              <!-- moments -->
              <div class="weui-cell moments__post" v-for="(it, ke) in item.data">
                  <div class="weui-cell__hd" @click="redto(it.user_code)">
                      <img :src="it.head_img">
                  </div>
                  <div class="weui-cell__bd" >
                      <!-- 人名链接 -->
                      <a class="title" @click="redto(it.user_code)">
                          <span>{{ it.user_details.nickname }}</span>
                      </a>
                      <!-- post内容 -->
                      <p id="paragraph" class="paragraph">{{ it.content }}</p>
                      <!-- 伸张链接 -->
                      <!-- <a id="paragraphExtender" class="paragraphExtender">显示全文</a> -->
                      <!-- 相册 -->
                      <div class="thumbnails my-gallery" v-if="it.imgs">
                          <figure itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject" class="thumbnail" v-for="(ig, k) in it.imgs">

                              <a :href="ig" itemprop="contentUrl" data-size="400x400">
                                  <img :src="ig" itemprop="thumbnail" alt="Image description" />
                              </a>
                              <figcaption itemprop="caption description">Image {{ k }}</figcaption>
                          </figure>
                      </div>
                      <!-- 资料条 -->
                      <div class="toolbar">
                          <p class="timestamp">{{ it.time }}</p>
                      </div>
                  </div>
                  <!-- 结束 post -->
              </div>
              <!-- end moments -->
          </mt-tab-container-item>
        </mt-tab-container>





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
    import { Actionsheet, Toast, MessageBox, TabItem, Navbar } from 'mint-ui';
    import PhotoSwipe from 'photoswipe'
    import PhotoSwipeUI_Default from 'photoswipe/dist/photoswipe-ui-default'
    import 'photoswipe/dist/photoswipe.css'
    import 'photoswipe/dist/default-skin/default-skin.css'
    export default {
        data() {
            return {
                selected: 0,
                sheetVisible: false,
                sheetVisible1: false,
                user_zan: false,
                moment_code:'',
                moment_user_code:'',
                userInfo: this.$store.state.userInfo,
                moment: {},
                navs:{},
            }
        },
        created () {
            let _this = this
            let navs = []
            this.$http.get('/test/api/getintmoment/'+this.userInfo.user_code).then((res) => {
                let intdata = res.data
                let i = 1
                for (let index in intdata)
                {
                    let data = {}
                    data.nav = index
                    data.data = intdata[index]
                    navs.push(data)
                }
            })
            console.log(navs);
            // 设置导航栏
            this.navs = navs

        },

        methods: {
            redto (code) {
                if (code !== this.userInfo.user_code) {
                    this.$router.push({ path: '/intmoment/addfriend', query: { code: code, own_code:  this.userInfo.user_code}})
                }
            },
            // 请求tag数据
            tag(int_code) {
                console.log(int_code);
            },
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
            }
        },

    }

</script>
<style>
    @import "../../assets/css/moments.css";
    .nav-head {
        margin-top: 4%;
    }
    /* @import url('//at.alicdn.com/t/font_8d5l8fzk5b87iudi.css'); */
</style>
