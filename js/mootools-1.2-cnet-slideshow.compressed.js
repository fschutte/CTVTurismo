/*MooTools, My Object Oriented Javascript Tools. Copyright (c) 2006-2007 Valerio Proietti, <http://mad4milk.net>, MIT Style License.||CNET Libraries Copyright (c) 2006-2008, http://clientside.cnet.com/wiki/cnet-libraries#license*/

var dbug={logged:[],timers:{},firebug:false,enabled:false,log:function(){dbug.logged.push(arguments)},nolog:function(msg){dbug.logged.push(arguments)},time:function(name){dbug.timers[name]=new Date().getTime()},timeEnd:function(name){if(dbug.timers[name]){var end=new Date().getTime()-dbug.timers[name];dbug.timers[name]=false;dbug.log('%s: %s',name,end)}else dbug.log('no such timer: %s',name)},enable:function(silent){if(dbug.firebug){try{dbug.enabled=true;dbug.log=function(){(console.debug||console.log).apply(console,arguments)};dbug.time=function(){console.time.apply(console,arguments)};dbug.timeEnd=function(){console.timeEnd.apply(console,arguments)};if(!silent)dbug.log('enabling dbug');for(var i=0;i<dbug.logged.length;i++){dbug.log.apply(console,dbug.logged[i])}dbug.logged=[]}catch(e){dbug.enable.delay(400)}}},disable:function(){if(dbug.firebug)dbug.enabled=false;dbug.log=dbug.nolog;dbug.time=function(){};dbug.timeEnd=function(){}},cookie:function(set){var value=document.cookie.match('(?:^|;)\\s*jsdebug=([^;]*)');var debugCookie=value?unescape(value[1]):false;if((!$defined(set)&&debugCookie!='true')||($defined(set)&&set)){dbug.enable();dbug.log('setting debugging cookie');var date=new Date();date.setTime(date.getTime()+(24*60*60*1000));document.cookie='jsdebug=true;expires='+date.toGMTString()+';path=/;'}else dbug.disableCookie()},disableCookie:function(){dbug.log('disabling debugging cookie');document.cookie='jsdebug=false;path=/;'}};(function(){var fb=typeof console!="undefined";var debugMethods=['debug','info','warn','error','assert','dir','dirxml'];var otherMethods=['trace','group','groupEnd','profile','profileEnd','count'];function set(methodList,defaultFunction){for(var i=0;i<methodList.length;i++){dbug[methodList[i]]=(fb&&console[methodList[i]])?console[methodList[i]]:defaultFunction}};set(debugMethods,dbug.log);set(otherMethods,function(){})})();if(typeof console!="undefined"&&console.warn){dbug.firebug=true;var value=document.cookie.match('(?:^|;)\\s*jsdebug=([^;]*)');var debugCookie=value?unescape(value[1]):false;if(window.location.href.indexOf("jsdebug=true")>0||debugCookie=='true')dbug.enable();if(debugCookie=='true')dbug.log('debugging cookie enabled');if(window.location.href.indexOf("jsdebugCookie=true")>0){dbug.cookie();if(!dbug.enabled)dbug.enable()}if(window.location.href.indexOf("jsdebugCookie=false")>0)dbug.disableCookie()}Element.implement({isVisible:function(){return this.getStyle('display')!='none'},toggle:function(){return this[this.isVisible()?'hide':'show']()},hide:function(){var d;try{if('none'!=this.getStyle('display'))d=this.getStyle('display')}catch(e){}this.store('originalDisplay',d||'block');this.setStyle('display','none');return this},show:function(display){original=this.retrieve('originalDisplay')?this.retrieve('originalDisplay'):this.get('originalDisplay');this.setStyle('display',(display||original||'block'));return this},swapClass:function(remove,add){return this.removeClass(remove).addClass(add)},fxOpacityOk:function(){return!Browser.Engine.trident4}});var SimpleSlideShow=new Class({Implements:[Events,Options,Chain],options:{startIndex:0,slides:[],currentSlideClass:'currentSlide',currentIndexContainer:false,maxContainer:false,nextLink:false,prevLink:false,wrap:true,disabledLinkClass:'disabled',crossFadeOptions:{}},initialize:function(options){this.setOptions(options);this.slides=this.options.slides;this.makeSlides();this.setCounters();this.setUpNav();this.now=this.options.startIndex;if(this.slides.length>0)this.show(this.now)},setCounters:function(){if($(this.options.currentIndexContainer))$(this.options.currentIndexContainer).set('html',this.now+1);if($(this.options.maxContainer))$(this.options.maxContainer).set('html',this.slides.length)},makeSlides:function(){this.slides.each(function(slide,index){if(index!=this.now)slide.setStyle('display','none');else slide.setStyle('display','block');this.makeSlide(slide)},this)},makeSlide:function(slide){slide.addEvent('click',function(){this.fireEvent('onSlideClick')}.bind(this))},setUpNav:function(){if($(this.options.nextLink)){$(this.options.nextLink).addEvent('click',function(){this.forward()}.bind(this))}if($(this.options.prevLink)){$(this.options.prevLink).addEvent('click',function(){this.back()}.bind(this))}},disableLinks:function(now){if(this.options.wrap)return;now=$pick(now,this.now);var prev=$(this.options.prevLink);var next=$(this.options.nextLink);var dlc=this.options.disabledLinkClass;if(now>0){if(prev)prev.removeClass(dlc);if(now===this.slides.length-1&&next)next.addClass(dlc);else if(next)next.removeClass(dlc)}else{if(this.slides.length>0&&next)next.removeClass(dlc);if(prev)prev.addClass(dlc)}},forward:function(){var fireEvent=false;if($type(this.now)&&this.now<this.slides.length-1)fireEvent=this.show(this.now+1);else if($type(this.now)&&this.options.wrap)fireEvent=this.show(0);else if(!$type(this.now))fireEvent=this.show(this.options.startIndex);if(fireEvent)this.fireEvent('onNext');return this},back:function(){if(this.now>0){this.show(this.now-1);this.fireEvent('onPrev')}else if(this.options.wrap&&this.slides.length>1){this.show(this.slides.length-1);this.fireEvent('onPrev')}return this},show:function(index){if(this.showing)return this.chain(this.show.bind(this,index));var now=this.now;var s=this.slides[index];function fadeIn(s,resetOpacity){s.setStyle('display','block');if(s.fxOpacityOk()){if(resetOpacity)s.setStyle('opacity',0);s.set('tween',this.options.crossFadeOptions).get('tween').start('opacity',1).chain(function(){this.showing=false;this.disableLinks();this.callChain()}.bind(this))}};if(s){if($type(this.now)&&this.now!=index){if(s.fxOpacityOk()){var fx=this.slides[this.now].get('tween');fx.setOptions(this.options.crossFadeOptions);this.showing=true;fx.start('opacity',0).chain(function(){this.slides[now].setStyle('display','none');s.addClass(this.options.currentSlideClass);fadeIn.run([s,true],this)}.bind(this))}else{this.slides[this.now].setStyle('display','none');fadeIn.run(s,this)}}else fadeIn.run(s,this);this.now=index;this.setCounters()}},slideClick:function(){this.fireEvent('onSlideClick',[this.slides[this.now],this.now])}});var SimpleImageSlideShow=new Class({Extends:SimpleSlideShow,options:{imgUrls:[],imgClass:'screenshot',container:false},initialize:function(options){this.parent(options);this.options.imgUrls.each(function(url){this.addImg(url)},this);this.show(this.options.startIndex)},addImg:function(url){if($(this.options.container)){var img=new Element('img',{'src':url,'id':this.options.imgClass+this.slides.length}).addClass(this.options.imgClass).setStyle('display','none').inject($(this.options.container)).addEvent('click',this.slideClick.bind(this));this.slides.push(img);this.makeSlide(img);this.setCounters()}return this}});