(self.webpackChunk=self.webpackChunk||[]).push([[488],{550:()=>{var o,i,t;"function"!=typeof Object.create&&(Object.create=function(o){function i(){}return i.prototype=o,new i}),o=jQuery,i=window,document,t={init:function(i,t){var e,n=this;n.elem=t,n.$elem=o(t),n.imageSrc=n.$elem.data("zoom-image")?n.$elem.data("zoom-image"):n.$elem.attr("src"),n.options=o.extend({},o.fn.ezPlus.options,n.responsiveConfig(i||{})),n.options.enabled&&(n.options.tint&&(n.options.lensColour="none",n.options.lensOpacity="1"),"inner"===n.options.zoomType&&(n.options.showLens=!1),n.$elem.parent().removeAttr("title").removeAttr("alt"),n.zoomImage=n.imageSrc,n.refresh(1),(e=o(n.options.gallery?"#"+n.options.gallery:n.options.gallerySelector)).on("click.zoom",n.options.galleryItem,(function(i){if(n.options.galleryActiveClass&&(o(n.options.galleryItem,e).removeClass(n.options.galleryActiveClass),o(this).addClass(n.options.galleryActiveClass)),"A"===this.tagName&&i.preventDefault(),o(this).data("zoom-image")?n.zoomImagePre=o(this).data("zoom-image"):n.zoomImagePre=o(this).data("image"),n.swaptheimage(o(this).data("image"),n.zoomImagePre),"A"===this.tagName)return!1})))},refresh:function(o){var i=this;setTimeout((function(){i.fetch(i.imageSrc)}),o||i.options.refresh)},fetch:function(o){var i=this,t=new Image;t.onload=function(){i.largeWidth=t.width,i.largeHeight=t.height,i.startZoom(),i.currentImage=i.imageSrc,i.options.onZoomedImageLoaded(i.$elem)},i.setImageSource(t,o)},setImageSource:function(o,i){o.src=i},startZoom:function(){var i,t,e,n=this;n.nzWidth=n.$elem.width(),n.nzHeight=n.$elem.height(),n.isWindowActive=!1,n.isLensActive=!1,n.isTintActive=!1,n.overWindow=!1,n.options.imageCrossfade&&(n.zoomWrap=n.$elem.wrap('<div style="height:'+n.nzHeight+"px;width:"+n.nzWidth+'px;" class="zoomWrapper" />'),n.$elem.css("position","absolute")),n.zoomLock=1,n.scrollingLock=!1,n.changeBgSize=!1,n.currentZoomLevel=n.options.zoomLevel,n.nzOffset=n.$elem.offset(),n.widthRatio=n.largeWidth/n.currentZoomLevel/n.nzWidth,n.heightRatio=n.largeHeight/n.currentZoomLevel/n.nzHeight,"window"===n.options.zoomType&&(n.zoomWindowStyle="overflow: hidden;background-position: 0px 0px;text-align:center;background-color: "+String(n.options.zoomWindowBgColour)+";width: "+String(n.options.zoomWindowWidth)+"px;height: "+String(n.options.zoomWindowHeight)+"px;float: left;background-size: "+n.largeWidth/n.currentZoomLevel+"px "+n.largeHeight/n.currentZoomLevel+"px;display: none;z-index:100;border: "+String(n.options.borderSize)+"px solid "+n.options.borderColour+";background-repeat: no-repeat;position: absolute;"),"inner"===n.options.zoomType&&(n.zoomWindowStyle=(i=n.$elem.css("border-left-width"),"overflow: hidden;margin-left: "+String(i)+";margin-top: "+String(i)+";background-position: 0px 0px;width: "+String(n.nzWidth)+"px;height: "+String(n.nzHeight)+"px;float: left;display: none;cursor:"+n.options.cursor+";px solid "+n.options.borderColour+";background-repeat: no-repeat;position: absolute;")),"window"===n.options.zoomType&&(n.lensStyle=(t=n.nzHeight<n.options.zoomWindowHeight/n.heightRatio?n.nzHeight:String(n.options.zoomWindowHeight/n.heightRatio),e=n.largeWidth<n.options.zoomWindowWidth?n.nzWidth:String(n.options.zoomWindowWidth/n.widthRatio),"background-position: 0px 0px;width: "+String(n.options.zoomWindowWidth/n.widthRatio)+"px;height: "+String(n.options.zoomWindowHeight/n.heightRatio)+"px;float: right;display: none;overflow: hidden;z-index: 999;opacity:"+n.options.lensOpacity+";filter: alpha(opacity = "+100*n.options.lensOpacity+"); zoom:1;width:"+e+"px;height:"+t+"px;background-color:"+n.options.lensColour+";cursor:"+n.options.cursor+";border: "+n.options.lensBorderSize+"px solid "+n.options.lensBorderColour+";background-repeat: no-repeat;position: absolute;")),n.tintStyle="display: block;position: absolute;background-color: "+n.options.tintColour+";filter:alpha(opacity=0);opacity: 0;width: "+n.nzWidth+"px;height: "+n.nzHeight+"px;",n.lensRound="","lens"===n.options.zoomType&&(n.lensStyle="background-position: 0px 0px;float: left;display: none;border: "+String(n.options.borderSize)+"px solid "+n.options.borderColour+";width:"+String(n.options.lensSize)+"px;height:"+String(n.options.lensSize)+"px;background-repeat: no-repeat;position: absolute;"),"round"===n.options.lensShape&&(n.lensRound="border-top-left-radius: "+String(n.options.lensSize/2+n.options.borderSize)+"px;border-top-right-radius: "+String(n.options.lensSize/2+n.options.borderSize)+"px;border-bottom-left-radius: "+String(n.options.lensSize/2+n.options.borderSize)+"px;border-bottom-right-radius: "+String(n.options.lensSize/2+n.options.borderSize)+"px;"),n.zoomContainer=o('<div class="zoomContainer" style="position:absolute;left:'+n.nzOffset.left+"px;top:"+n.nzOffset.top+"px;height:"+n.nzHeight+"px;width:"+n.nzWidth+"px;z-index:"+n.options.zIndex+'"></div>'),o(n.options.zoomContainerAppendTo).append(n.zoomContainer),n.options.containLensZoom&&"lens"===n.options.zoomType&&n.zoomContainer.css("overflow","hidden"),"inner"!==n.options.zoomType&&(n.zoomLens=o('<div class="zoomLens" style="'+n.lensStyle+n.lensRound+'">&nbsp;</div>').appendTo(n.zoomContainer).click((function(){n.$elem.trigger("click")})),n.options.tint&&(n.tintContainer=o("<div/>").addClass("tintContainer"),n.zoomTint=o('<div class="zoomTint" style="'+n.tintStyle+'"></div>'),n.zoomLens.wrap(n.tintContainer),n.zoomTintcss=n.zoomLens.after(n.zoomTint),n.zoomTintImage=o('<img style="position: absolute; left: 0px; top: 0px; max-width: none; width: '+n.nzWidth+"px; height: "+n.nzHeight+'px;" src="'+n.imageSrc+'">').appendTo(n.zoomLens).click((function(){n.$elem.trigger("click")}))));var s=isNaN(n.options.zoomWindowPosition)?"body":n.zoomContainer;function h(o){n.lastX===o.clientX&&n.lastY===o.clientY||(n.setPosition(o),n.currentLoc=o),n.lastX=o.clientX,n.lastY=o.clientY}n.zoomWindow=o('<div style="z-index:999;left:'+n.windowOffsetLeft+"px;top:"+n.windowOffsetTop+"px;"+n.zoomWindowStyle+'" class="zoomWindow">&nbsp;</div>').appendTo(s).click((function(){n.$elem.trigger("click")})),n.zoomWindowContainer=o("<div/>").addClass("zoomWindowContainer").css("width",n.options.zoomWindowWidth),n.zoomWindow.wrap(n.zoomWindowContainer),"lens"===n.options.zoomType&&n.zoomLens.css("background-image",'url("'+n.imageSrc+'")'),"window"===n.options.zoomType&&n.zoomWindow.css("background-image",'url("'+n.imageSrc+'")'),"inner"===n.options.zoomType&&n.zoomWindow.css("background-image",'url("'+n.imageSrc+'")'),n.options.touchEnabled&&(n.$elem.bind("touchmove",(function(o){o.preventDefault();var i=o.originalEvent.touches[0]||o.originalEvent.changedTouches[0];n.setPosition(i)})),n.zoomContainer.bind("touchmove",(function(o){"inner"===n.options.zoomType&&n.showHideWindow("show"),o.preventDefault();var i=o.originalEvent.touches[0]||o.originalEvent.changedTouches[0];n.setPosition(i)})),n.zoomContainer.bind("touchend",(function(o){n.showHideWindow("hide"),n.options.showLens&&n.showHideLens("hide"),n.options.tint&&"inner"!==n.options.zoomType&&n.showHideTint("hide")})),n.$elem.bind("touchend",(function(o){n.showHideWindow("hide"),n.options.showLens&&n.showHideLens("hide"),n.options.tint&&"inner"!==n.options.zoomType&&n.showHideTint("hide")})),n.options.showLens&&(n.zoomLens.bind("touchmove",(function(o){o.preventDefault();var i=o.originalEvent.touches[0]||o.originalEvent.changedTouches[0];n.setPosition(i)})),n.zoomLens.bind("touchend",(function(o){n.showHideWindow("hide"),n.options.showLens&&n.showHideLens("hide"),n.options.tint&&"inner"!==n.options.zoomType&&n.showHideTint("hide")})))),n.$elem.bind("mousemove",(function(o){!1===n.overWindow&&n.setElements("show"),n.lastX===o.clientX&&n.lastY===o.clientY||(n.setPosition(o),n.currentLoc=o),n.lastX=o.clientX,n.lastY=o.clientY})),n.zoomContainer.bind("click",n.options.onImageClick),n.zoomContainer.bind("mousemove",(function(o){!1===n.overWindow&&n.setElements("show"),h(o)}));var d=null;"inner"!==n.options.zoomType&&(d=n.zoomLens),n.options.tint&&"inner"!==n.options.zoomType&&(d=n.zoomTint),"inner"===n.options.zoomType&&(d=n.zoomWindow),d&&d.bind("mousemove",h),n.zoomContainer.add(n.$elem).mouseenter((function(){!1===n.overWindow&&n.setElements("show")})).mouseleave((function(){n.scrollLock||(n.setElements("hide"),n.options.onDestroy(n.$elem))})),"inner"!==n.options.zoomType&&n.zoomWindow.mouseenter((function(){n.overWindow=!0,n.setElements("hide")})).mouseleave((function(){n.overWindow=!1})),n.options.minZoomLevel?n.minZoomLevel=n.options.minZoomLevel:n.minZoomLevel=2*n.options.scrollZoomIncrement,n.options.scrollZoom&&n.zoomContainer.add(n.$elem).bind("wheel DOMMouseScroll MozMousePixelScroll",(function(i){n.scrollLock=!0,clearTimeout(o.data(this,"timer")),o.data(this,"timer",setTimeout((function(){n.scrollLock=!1}),250));var t=i.originalEvent.deltaY||-1*i.originalEvent.detail;return i.stopImmediatePropagation(),i.stopPropagation(),i.preventDefault(),t/120>0?n.currentZoomLevel>=n.minZoomLevel&&n.changeZoomLevel(n.currentZoomLevel-n.options.scrollZoomIncrement):(n.fullheight||n.fullwidth)&&n.options.mantainZoomAspectRatio||(n.options.maxZoomLevel?n.currentZoomLevel<=n.options.maxZoomLevel&&n.changeZoomLevel(parseFloat(n.currentZoomLevel)+n.options.scrollZoomIncrement):n.changeZoomLevel(parseFloat(n.currentZoomLevel)+n.options.scrollZoomIncrement)),!1}))},setElements:function(o){if(!this.options.zoomEnabled)return!1;"show"===o&&this.isWindowSet&&("inner"===this.options.zoomType&&this.showHideWindow("show"),"window"===this.options.zoomType&&this.showHideWindow("show"),this.options.showLens&&this.showHideLens("show"),this.options.tint&&"inner"!==this.options.zoomType&&this.showHideTint("show")),"hide"===o&&("window"===this.options.zoomType&&this.showHideWindow("hide"),this.options.tint||this.showHideWindow("hide"),this.options.showLens&&this.showHideLens("hide"),this.options.tint&&this.showHideTint("hide"))},setPosition:function(o){var i,t;if(!this.options.zoomEnabled)return!1;if(this.nzHeight=this.$elem.height(),this.nzWidth=this.$elem.width(),this.nzOffset=this.$elem.offset(),this.options.tint&&"inner"!==this.options.zoomType&&this.zoomTint.css({top:0,left:0}),this.options.responsive&&!this.options.scrollZoom&&this.options.showLens&&(i=this.nzHeight<this.options.zoomWindowWidth/this.widthRatio?this.nzHeight:String(this.options.zoomWindowHeight/this.heightRatio),t=this.largeWidth<this.options.zoomWindowWidth?this.nzWidth:this.options.zoomWindowWidth/this.widthRatio,this.widthRatio=this.largeWidth/this.nzWidth,this.heightRatio=this.largeHeight/this.nzHeight,"lens"!==this.options.zoomType&&(i=this.nzHeight<this.options.zoomWindowWidth/this.widthRatio?this.nzHeight:String(this.options.zoomWindowHeight/this.heightRatio),t=this.nzWidth<this.options.zoomWindowHeight/this.heightRatio?this.nzWidth:String(this.options.zoomWindowWidth/this.widthRatio),this.zoomLens.css({width:t,height:i}),this.options.tint&&this.zoomTintImage.css({width:this.nzWidth,height:this.nzHeight})),"lens"===this.options.zoomType&&this.zoomLens.css({width:String(this.options.lensSize)+"px",height:String(this.options.lensSize)+"px"})),this.zoomContainer.css({top:this.nzOffset.top,left:this.nzOffset.left}),this.mouseLeft=parseInt(o.pageX-this.nzOffset.left),this.mouseTop=parseInt(o.pageY-this.nzOffset.top),"window"===this.options.zoomType){var e=this.zoomLens.height()/2,n=this.zoomLens.width()/2;this.Etoppos=this.mouseTop<0+e,this.Eboppos=this.mouseTop>this.nzHeight-e-2*this.options.lensBorderSize,this.Eloppos=this.mouseLeft<0+n,this.Eroppos=this.mouseLeft>this.nzWidth-n-2*this.options.lensBorderSize}"inner"===this.options.zoomType&&(this.Etoppos=this.mouseTop<this.nzHeight/2/this.heightRatio,this.Eboppos=this.mouseTop>this.nzHeight-this.nzHeight/2/this.heightRatio,this.Eloppos=this.mouseLeft<0+this.nzWidth/2/this.widthRatio,this.Eroppos=this.mouseLeft>this.nzWidth-this.nzWidth/2/this.widthRatio-2*this.options.lensBorderSize),this.mouseLeft<0||this.mouseTop<0||this.mouseLeft>this.nzWidth||this.mouseTop>this.nzHeight?this.setElements("hide"):(this.options.showLens&&(this.lensLeftPos=String(Math.floor(this.mouseLeft-this.zoomLens.width()/2)),this.lensTopPos=String(Math.floor(this.mouseTop-this.zoomLens.height()/2))),this.Etoppos&&(this.lensTopPos=0),this.Eloppos&&(this.windowLeftPos=0,this.lensLeftPos=0,this.tintpos=0),"window"===this.options.zoomType&&(this.Eboppos&&(this.lensTopPos=Math.max(this.nzHeight-this.zoomLens.height()-2*this.options.lensBorderSize,0)),this.Eroppos&&(this.lensLeftPos=this.nzWidth-this.zoomLens.width()-2*this.options.lensBorderSize)),"inner"===this.options.zoomType&&(this.Eboppos&&(this.lensTopPos=Math.max(this.nzHeight-2*this.options.lensBorderSize,0)),this.Eroppos&&(this.lensLeftPos=this.nzWidth-this.nzWidth-2*this.options.lensBorderSize)),"lens"===this.options.zoomType&&(this.windowLeftPos=String(-1*((o.pageX-this.nzOffset.left)*this.widthRatio-this.zoomLens.width()/2)),this.windowTopPos=String(-1*((o.pageY-this.nzOffset.top)*this.heightRatio-this.zoomLens.height()/2)),this.zoomLens.css("background-position",this.windowLeftPos+"px "+this.windowTopPos+"px"),this.changeBgSize&&(this.nzHeight>this.nzWidth?("lens"===this.options.zoomType&&this.zoomLens.css("background-size",this.largeWidth/this.newvalueheight+"px "+this.largeHeight/this.newvalueheight+"px"),this.zoomWindow.css("background-size",this.largeWidth/this.newvalueheight+"px "+this.largeHeight/this.newvalueheight+"px")):("lens"===this.options.zoomType&&this.zoomLens.css("background-size",this.largeWidth/this.newvaluewidth+"px "+this.largeHeight/this.newvaluewidth+"px"),this.zoomWindow.css("background-size",this.largeWidth/this.newvaluewidth+"px "+this.largeHeight/this.newvaluewidth+"px")),this.changeBgSize=!1),this.setWindowPosition(o)),this.options.tint&&"inner"!==this.options.zoomType&&this.setTintPosition(o),"window"===this.options.zoomType&&this.setWindowPosition(o),"inner"===this.options.zoomType&&this.setWindowPosition(o),this.options.showLens&&(this.fullwidth&&"lens"!==this.options.zoomType&&(this.lensLeftPos=0),this.zoomLens.css({left:this.lensLeftPos+"px",top:this.lensTopPos+"px"})))},showHideZoomContainer:function(o){"show"===o&&this.zoomContainer&&this.zoomContainer.show(),"hide"===o&&this.zoomContainer&&this.zoomContainer.hide()},showHideWindow:function(o){var i=this;"show"===o&&!i.isWindowActive&&i.zoomWindow&&(i.options.onShow(i),i.options.zoomWindowFadeIn?i.zoomWindow.stop(!0,!0,!1).fadeIn(i.options.zoomWindowFadeIn):i.zoomWindow.show(),i.isWindowActive=!0),"hide"===o&&i.isWindowActive&&(i.options.zoomWindowFadeOut?i.zoomWindow.stop(!0,!0).fadeOut(i.options.zoomWindowFadeOut,(function(){i.loop&&(clearInterval(i.loop),i.loop=!1)})):i.zoomWindow.hide(),i.isWindowActive=!1)},showHideLens:function(o){"show"===o&&(this.isLensActive||(this.options.lensFadeIn&&this.zoomLens?this.zoomLens.stop(!0,!0,!1).fadeIn(this.options.lensFadeIn):this.zoomLens.show(),this.isLensActive=!0)),"hide"===o&&this.isLensActive&&(this.options.lensFadeOut?this.zoomLens.stop(!0,!0).fadeOut(this.options.lensFadeOut):this.zoomLens.hide(),this.isLensActive=!1)},showHideTint:function(o){"show"===o&&!this.isTintActive&&this.zoomTint&&(this.options.zoomTintFadeIn?this.zoomTint.css("opacity",this.options.tintOpacity).animate().stop(!0,!0).fadeIn("slow"):(this.zoomTint.css("opacity",this.options.tintOpacity).animate(),this.zoomTint.show()),this.isTintActive=!0),"hide"===o&&this.isTintActive&&(this.options.zoomTintFadeOut?this.zoomTint.stop(!0,!0).fadeOut(this.options.zoomTintFadeOut):this.zoomTint.hide(),this.isTintActive=!1)},setLensPosition:function(o){},setWindowPosition:function(i){var t=this;if(isNaN(t.options.zoomWindowPosition))t.externalContainer=o("#"+t.options.zoomWindowPosition),t.externalContainerWidth=t.externalContainer.width(),t.externalContainerHeight=t.externalContainer.height(),t.externalContainerOffset=t.externalContainer.offset(),t.windowOffsetTop=t.externalContainerOffset.top,t.windowOffsetLeft=t.externalContainerOffset.left;else switch(t.options.zoomWindowPosition){case 1:t.windowOffsetTop=t.options.zoomWindowOffsetY,t.windowOffsetLeft=+t.nzWidth;break;case 2:t.options.zoomWindowHeight>t.nzHeight?(t.windowOffsetTop=-1*(t.options.zoomWindowHeight/2-t.nzHeight/2),t.windowOffsetLeft=t.nzWidth):o.noop();break;case 3:t.windowOffsetTop=t.nzHeight-t.zoomWindow.height()-2*t.options.borderSize,t.windowOffsetLeft=t.nzWidth;break;case 4:t.windowOffsetTop=t.nzHeight,t.windowOffsetLeft=t.nzWidth;break;case 5:t.windowOffsetTop=t.nzHeight,t.windowOffsetLeft=t.nzWidth-t.zoomWindow.width()-2*t.options.borderSize;break;case 6:t.options.zoomWindowHeight>t.nzHeight?(t.windowOffsetTop=t.nzHeight,t.windowOffsetLeft=-1*(t.options.zoomWindowWidth/2-t.nzWidth/2+2*t.options.borderSize)):o.noop();break;case 7:t.windowOffsetTop=t.nzHeight,t.windowOffsetLeft=0;break;case 8:t.windowOffsetTop=t.nzHeight,t.windowOffsetLeft=-1*(t.zoomWindow.width()+2*t.options.borderSize);break;case 9:t.windowOffsetTop=t.nzHeight-t.zoomWindow.height()-2*t.options.borderSize,t.windowOffsetLeft=-1*(t.zoomWindow.width()+2*t.options.borderSize);break;case 10:t.options.zoomWindowHeight>t.nzHeight?(t.windowOffsetTop=-1*(t.options.zoomWindowHeight/2-t.nzHeight/2),t.windowOffsetLeft=-1*(t.zoomWindow.width()+2*t.options.borderSize)):o.noop();break;case 11:t.windowOffsetTop=t.options.zoomWindowOffsetY,t.windowOffsetLeft=-1*(t.zoomWindow.width()+2*t.options.borderSize);break;case 12:t.windowOffsetTop=-1*(t.zoomWindow.height()+2*t.options.borderSize),t.windowOffsetLeft=-1*(t.zoomWindow.width()+2*t.options.borderSize);break;case 13:t.windowOffsetTop=-1*(t.zoomWindow.height()+2*t.options.borderSize),t.windowOffsetLeft=0;break;case 14:t.options.zoomWindowHeight>t.nzHeight?(t.windowOffsetTop=-1*(t.zoomWindow.height()+2*t.options.borderSize),t.windowOffsetLeft=-1*(t.options.zoomWindowWidth/2-t.nzWidth/2+2*t.options.borderSize)):o.noop();break;case 15:t.windowOffsetTop=-1*(t.zoomWindow.height()+2*t.options.borderSize),t.windowOffsetLeft=t.nzWidth-t.zoomWindow.width()-2*t.options.borderSize;break;case 16:t.windowOffsetTop=-1*(t.zoomWindow.height()+2*t.options.borderSize),t.windowOffsetLeft=t.nzWidth;break;default:t.windowOffsetTop=t.options.zoomWindowOffsetY,t.windowOffsetLeft=t.nzWidth}t.isWindowSet=!0,t.windowOffsetTop=t.windowOffsetTop+t.options.zoomWindowOffsetY,t.windowOffsetLeft=t.windowOffsetLeft+t.options.zoomWindowOffsetX,t.zoomWindow.css({top:t.windowOffsetTop,left:t.windowOffsetLeft}),"inner"===t.options.zoomType&&t.zoomWindow.css({top:0,left:0}),t.windowLeftPos=String(-1*((i.pageX-t.nzOffset.left)*t.widthRatio-t.zoomWindow.width()/2)),t.windowTopPos=String(-1*((i.pageY-t.nzOffset.top)*t.heightRatio-t.zoomWindow.height()/2)),t.Etoppos&&(t.windowTopPos=0),t.Eloppos&&(t.windowLeftPos=0),t.Eboppos&&(t.windowTopPos=-1*(t.largeHeight/t.currentZoomLevel-t.zoomWindow.height())),t.Eroppos&&(t.windowLeftPos=-1*(t.largeWidth/t.currentZoomLevel-t.zoomWindow.width())),t.fullheight&&(t.windowTopPos=0),t.fullwidth&&(t.windowLeftPos=0),"window"!==t.options.zoomType&&"inner"!==t.options.zoomType||(1===t.zoomLock&&(t.widthRatio<=1&&(t.windowLeftPos=0),t.heightRatio<=1&&(t.windowTopPos=0)),"window"===t.options.zoomType&&(t.largeHeight<t.options.zoomWindowHeight&&(t.windowTopPos=0),t.largeWidth<t.options.zoomWindowWidth&&(t.windowLeftPos=0)),t.options.easing?(t.xp||(t.xp=0),t.yp||(t.yp=0),t.loop||(t.loop=setInterval((function(){t.xp+=(t.windowLeftPos-t.xp)/t.options.easingAmount,t.yp+=(t.windowTopPos-t.yp)/t.options.easingAmount,t.scrollingLock?(clearInterval(t.loop),t.xp=t.windowLeftPos,t.yp=t.windowTopPos,t.xp=-1*((i.pageX-t.nzOffset.left)*t.widthRatio-t.zoomWindow.width()/2),t.yp=-1*((i.pageY-t.nzOffset.top)*t.heightRatio-t.zoomWindow.height()/2),t.changeBgSize&&(t.nzHeight>t.nzWidth?("lens"===t.options.zoomType&&t.zoomLens.css("background-size",t.largeWidth/t.newvalueheight+"px "+t.largeHeight/t.newvalueheight+"px"),t.zoomWindow.css("background-size",t.largeWidth/t.newvalueheight+"px "+t.largeHeight/t.newvalueheight+"px")):("lens"!==t.options.zoomType&&t.zoomLens.css("background-size",t.largeWidth/t.newvaluewidth+"px "+t.largeHeight/t.newvalueheight+"px"),t.zoomWindow.css("background-size",t.largeWidth/t.newvaluewidth+"px "+t.largeHeight/t.newvaluewidth+"px")),t.changeBgSize=!1),t.zoomWindow.css("background-position",t.windowLeftPos+"px "+t.windowTopPos+"px"),t.scrollingLock=!1,t.loop=!1):Math.round(Math.abs(t.xp-t.windowLeftPos)+Math.abs(t.yp-t.windowTopPos))<1?(clearInterval(t.loop),t.zoomWindow.css("background-position",t.windowLeftPos+"px "+t.windowTopPos+"px"),t.loop=!1):(t.changeBgSize&&(t.nzHeight>t.nzWidth?("lens"===t.options.zoomType&&t.zoomLens.css("background-size",t.largeWidth/t.newvalueheight+"px "+t.largeHeight/t.newvalueheight+"px"),t.zoomWindow.css("background-size",t.largeWidth/t.newvalueheight+"px "+t.largeHeight/t.newvalueheight+"px")):("lens"!==t.options.zoomType&&t.zoomLens.css("background-size",t.largeWidth/t.newvaluewidth+"px "+t.largeHeight/t.newvaluewidth+"px"),t.zoomWindow.css("background-size",t.largeWidth/t.newvaluewidth+"px "+t.largeHeight/t.newvaluewidth+"px")),t.changeBgSize=!1),t.zoomWindow.css("background-position",t.xp+"px "+t.yp+"px"))}),16))):(t.changeBgSize&&(t.nzHeight>t.nzWidth?("lens"===t.options.zoomType&&t.zoomLens.css("background-size",t.largeWidth/t.newvalueheight+"px "+t.largeHeight/t.newvalueheight+"px"),t.zoomWindow.css("background-size",t.largeWidth/t.newvalueheight+"px "+t.largeHeight/t.newvalueheight+"px")):("lens"===t.options.zoomType&&t.zoomLens.css("background-size",t.largeWidth/t.newvaluewidth+"px "+t.largeHeight/t.newvaluewidth+"px"),t.largeHeight/t.newvaluewidth<t.options.zoomWindowHeight?t.zoomWindow.css("background-size",t.largeWidth/t.newvaluewidth+"px "+t.largeHeight/t.newvaluewidth+"px"):t.zoomWindow.css("background-size",t.largeWidth/t.newvalueheight+"px "+t.largeHeight/t.newvalueheight+"px")),t.changeBgSize=!1),t.zoomWindow.css("background-position",t.windowLeftPos+"px "+t.windowTopPos+"px")))},setTintPosition:function(o){var i=this.zoomLens.width(),t=this.zoomLens.height();this.nzOffset=this.$elem.offset(),this.tintpos=String(-1*(o.pageX-this.nzOffset.left-i/2)),this.tintposy=String(-1*(o.pageY-this.nzOffset.top-t/2)),this.Etoppos&&(this.tintposy=0),this.Eloppos&&(this.tintpos=0),this.Eboppos&&(this.tintposy=-1*(this.nzHeight-t-2*this.options.lensBorderSize)),this.Eroppos&&(this.tintpos=-1*(this.nzWidth-i-2*this.options.lensBorderSize)),this.options.tint&&(this.fullheight&&(this.tintposy=0),this.fullwidth&&(this.tintpos=0),this.zoomTintImage.css({left:this.tintpos+"px",top:this.tintposy+"px"}))},swaptheimage:function(i,t){var e=this,n=new Image;e.options.loadingIcon&&(e.spinner=o("<div style=\"background: url('"+e.options.loadingIcon+"') no-repeat center;height:"+e.nzHeight+"px;width:"+e.nzWidth+'px;z-index: 2000;position: absolute; background-position: center center;"></div>'),e.$elem.after(e.spinner)),e.options.onImageSwap(e.$elem),n.onload=function(){e.largeWidth=n.width,e.largeHeight=n.height,e.zoomImage=t,e.zoomWindow.css("background-size",e.largeWidth+"px "+e.largeHeight+"px"),e.swapAction(i,t)},e.setImageSource(n,t)},swapAction:function(i,t){var e=this,n=e.$elem.width(),s=e.$elem.height(),h=new Image;if(h.onload=function(){e.nzHeight=h.height,e.nzWidth=h.width,e.options.onImageSwapComplete(e.$elem),e.doneCallback()},e.setImageSource(h,i),e.currentZoomLevel=e.options.zoomLevel,e.options.maxZoomLevel=!1,"lens"===e.options.zoomType&&e.zoomLens.css("background-image",'url("'+t+'")'),"window"===e.options.zoomType&&e.zoomWindow.css("background-image",'url("'+t+'")'),"inner"===e.options.zoomType&&e.zoomWindow.css("background-image",'url("'+t+'")'),e.currentImage=t,e.options.imageCrossfade){var d=e.$elem,a=d.clone();if(e.$elem.attr("src",i),e.$elem.after(a),a.stop(!0).fadeOut(e.options.imageCrossfade,(function(){o(this).remove()})),e.$elem.width("auto").removeAttr("width"),e.$elem.height("auto").removeAttr("height"),d.fadeIn(e.options.imageCrossfade),e.options.tint&&"inner"!==e.options.zoomType){var p=e.zoomTintImage,r=p.clone();e.zoomTintImage.attr("src",t),e.zoomTintImage.after(r),r.stop(!0).fadeOut(e.options.imageCrossfade,(function(){o(this).remove()})),p.fadeIn(e.options.imageCrossfade),e.zoomTint.css({height:s,width:n})}e.zoomContainer.css({height:s,width:n}),"inner"===e.options.zoomType&&(e.options.constrainType||(e.zoomWrap.parent().css({height:s,width:n}),e.zoomWindow.css({height:s,width:n}))),e.options.imageCrossfade&&e.zoomWrap.css({height:s,width:n})}else e.$elem.attr("src",i),e.options.tint&&(e.zoomTintImage.attr("src",t),e.zoomTintImage.attr("height",s),e.zoomTintImage.css("height",s),e.zoomTint.css("height",s)),e.zoomContainer.css({height:s,width:n}),e.options.imageCrossfade&&e.zoomWrap.css({height:s,width:n});if(e.options.constrainType){if("height"===e.options.constrainType){var l={height:e.options.constrainSize,width:"auto"};e.zoomContainer.css(l),e.options.imageCrossfade?(e.zoomWrap.css(l),e.constwidth=e.zoomWrap.width()):(e.$elem.css(l),e.constwidth=n);var m={height:e.options.constrainSize,width:e.constwidth};"inner"===e.options.zoomType&&(e.zoomWrap.parent().css(m),e.zoomWindow.css(m)),e.options.tint&&(e.tintContainer.css(m),e.zoomTint.css(m),e.zoomTintImage.css(m))}if("width"===e.options.constrainType){var w={height:"auto",width:e.options.constrainSize};e.zoomContainer.css(w),e.options.imageCrossfade?(e.zoomWrap.css(w),e.constheight=e.zoomWrap.height()):(e.$elem.css(w),e.constheight=s);var g={height:e.constheight,width:e.options.constrainSize};"inner"===e.options.zoomType&&(e.zoomWrap.parent().css(g),e.zoomWindow.css(g)),e.options.tint&&(e.tintContainer.css(g),e.zoomTint.css(g),e.zoomTintImage.css(g))}}},doneCallback:function(){var o,i;this.options.loadingIcon&&this.spinner.hide(),this.nzOffset=this.$elem.offset(),this.nzWidth=this.$elem.width(),this.nzHeight=this.$elem.height(),this.currentZoomLevel=this.options.zoomLevel,this.widthRatio=this.largeWidth/this.nzWidth,this.heightRatio=this.largeHeight/this.nzHeight,"window"===this.options.zoomType&&(o=this.nzHeight<this.options.zoomWindowHeight/this.heightRatio?this.nzHeight:String(this.options.zoomWindowHeight/this.heightRatio),i=this.nzWidth<this.options.zoomWindowWidth?this.nzWidth:this.options.zoomWindowWidth/this.widthRatio,this.zoomLens&&this.zoomLens.css({width:i,height:o}))},getCurrentImage:function(){return this.zoomImage},getGalleryList:function(){var i=this;return i.gallerylist=[],i.options.gallery?o("#"+i.options.gallery+" a").each((function(){var t="";o(this).data("zoom-image")?t=o(this).data("zoom-image"):o(this).data("image")&&(t=o(this).data("image")),t===i.zoomImage?i.gallerylist.unshift({href:""+t,title:o(this).find("img").attr("title")}):i.gallerylist.push({href:""+t,title:o(this).find("img").attr("title")})})):i.gallerylist.push({href:""+i.zoomImage,title:o(this).find("img").attr("title")}),i.gallerylist},changeZoomLevel:function(o){this.scrollingLock=!0,this.newvalue=parseFloat(o).toFixed(2);var i=this.newvalue,t=this.largeHeight/(this.options.zoomWindowHeight/this.nzHeight*this.nzHeight),e=this.largeWidth/(this.options.zoomWindowWidth/this.nzWidth*this.nzWidth);"inner"!==this.options.zoomType&&(t<=i?(this.heightRatio=this.largeHeight/t/this.nzHeight,this.newvalueheight=t,this.fullheight=!0):(this.heightRatio=this.largeHeight/i/this.nzHeight,this.newvalueheight=i,this.fullheight=!1),e<=i?(this.widthRatio=this.largeWidth/e/this.nzWidth,this.newvaluewidth=e,this.fullwidth=!0):(this.widthRatio=this.largeWidth/i/this.nzWidth,this.newvaluewidth=i,this.fullwidth=!1),"lens"===this.options.zoomType&&(t<=i?(this.fullwidth=!0,this.newvaluewidth=t):(this.widthRatio=this.largeWidth/i/this.nzWidth,this.newvaluewidth=i,this.fullwidth=!1))),"inner"===this.options.zoomType&&(i>(t=parseFloat(this.largeHeight/this.nzHeight).toFixed(2))&&(i=t),i>(e=parseFloat(this.largeWidth/this.nzWidth).toFixed(2))&&(i=e),t<=i?(this.heightRatio=this.largeHeight/i/this.nzHeight,this.newvalueheight=i>t?t:i,this.fullheight=!0):(this.heightRatio=this.largeHeight/i/this.nzHeight,this.newvalueheight=i>t?t:i,this.fullheight=!1),e<=i?(this.widthRatio=this.largeWidth/i/this.nzWidth,this.newvaluewidth=i>e?e:i,this.fullwidth=!0):(this.widthRatio=this.largeWidth/i/this.nzWidth,this.newvaluewidth=i,this.fullwidth=!1));var n=!1;"inner"===this.options.zoomType&&(this.nzWidth>=this.nzHeight&&(this.newvaluewidth<=e?n=!0:(n=!1,this.fullheight=!0,this.fullwidth=!0)),this.nzHeight>this.nzWidth&&(this.newvaluewidth<=e?n=!0:(n=!1,this.fullheight=!0,this.fullwidth=!0))),"inner"!==this.options.zoomType&&(n=!0),n&&(this.zoomLock=0,this.changeZoom=!0,this.options.zoomWindowHeight/this.heightRatio<=this.nzHeight&&(this.currentZoomLevel=this.newvalueheight,"lens"!==this.options.zoomType&&"inner"!==this.options.zoomType&&(this.changeBgSize=!0,this.zoomLens.css("height",String(this.options.zoomWindowHeight/this.heightRatio)+"px")),"lens"!==this.options.zoomType&&"inner"!==this.options.zoomType||(this.changeBgSize=!0)),this.options.zoomWindowWidth/this.widthRatio<=this.nzWidth&&("inner"!==this.options.zoomType&&this.newvaluewidth>this.newvalueheight&&(this.currentZoomLevel=this.newvaluewidth),"lens"!==this.options.zoomType&&"inner"!==this.options.zoomType&&(this.changeBgSize=!0,this.zoomLens.css("width",String(this.options.zoomWindowWidth/this.widthRatio)+"px")),"lens"!==this.options.zoomType&&"inner"!==this.options.zoomType||(this.changeBgSize=!0)),"inner"===this.options.zoomType&&(this.changeBgSize=!0,this.nzWidth>this.nzHeight&&(this.currentZoomLevel=this.newvaluewidth),this.nzHeight>this.nzWidth&&(this.currentZoomLevel=this.newvaluewidth))),this.setPosition(this.currentLoc)},closeAll:function(){this.zoomWindow&&this.zoomWindow.hide(),this.zoomLens&&this.zoomLens.hide(),this.zoomTint&&this.zoomTint.hide()},changeState:function(o){"enable"===o&&(this.options.zoomEnabled=!0),"disable"===o&&(this.options.zoomEnabled=!1)},responsiveConfig:function(i){return i.respond&&i.respond.length>0?o.extend({},i,this.configByScreenWidth(i)):i},configByScreenWidth:function(t){var e=o(i).width(),n=o.grep(t.respond,(function(o){var i=o.range.split("-");return e>=i[0]&&e<=i[1]}));return n.length>0?n[0]:t}},o.fn.ezPlus=function(i){return this.each((function(){var e=Object.create(t);e.init(i,this),o.data(this,"ezPlus",e)}))},o.fn.ezPlus.options={borderColour:"#888",borderSize:4,constrainSize:!1,constrainType:!1,containLensZoom:!1,cursor:"inherit",debug:!1,easing:!1,easingAmount:12,enabled:!0,gallery:!1,galleryActiveClass:"zoomGalleryActive",gallerySelector:!1,galleryItem:"a",imageCrossfade:!1,lensBorderColour:"#000",lensBorderSize:1,lensColour:"white",lensFadeIn:!1,lensFadeOut:!1,lensOpacity:.4,lensShape:"square",lensSize:200,lenszoom:!1,loadingIcon:!1,mantainZoomAspectRatio:!1,maxZoomLevel:!1,minZoomLevel:!1,onComplete:o.noop,onDestroy:o.noop,onImageClick:o.noop,onImageSwap:o.noop,onImageSwapComplete:o.noop,onShow:o.noop,onZoomedImageLoaded:o.noop,preloading:1,respond:[],responsive:!0,scrollZoom:!1,scrollZoomIncrement:.1,showLens:!0,tint:!1,tintColour:"#333",tintOpacity:.4,touchEnabled:!0,zoomActivation:"hover",zoomContainerAppendTo:"body",zoomLevel:1,zoomTintFadeIn:!1,zoomTintFadeOut:!1,zoomType:"window",zoomWindowAlwaysShow:!1,zoomWindowBgColour:"#fff",zoomWindowFadeIn:!1,zoomWindowFadeOut:!1,zoomWindowHeight:400,zoomWindowOffsetX:0,zoomWindowOffsetY:0,zoomWindowPosition:1,zoomWindowWidth:400,zoomEnabled:!0,zIndex:999}},3080:()=>{},5708:()=>{}},o=>{var i=i=>o(o.s=i);o.O(0,[336,784],(()=>(i(550),i(3080),i(5708))));o.O()}]);