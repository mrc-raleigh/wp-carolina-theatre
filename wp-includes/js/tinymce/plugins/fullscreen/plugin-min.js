!function(){var e=function(){"use strict";function e(){}var t=function(e){var n=e,i=function(){return n};return{get:i,set:function(e){n=e},clone:function(){return t(i())}}},n=tinymce.util.Tools.resolve("tinymce.PluginManager"),i=function(e){return{isFullscreen:function(){return null!==e.get()}}},r={get:i},l=tinymce.util.Tools.resolve("tinymce.dom.DOMUtils"),c=function(e,t){e.fire("FullscreenStateChanged",{state:t})},o={fireFullscreenStateChanged:c},u=l.DOM,s=function(){var e,t,n=window,i=document,r=i.body;return r.offsetWidth&&(e=r.offsetWidth,t=r.offsetHeight),n.innerWidth&&n.innerHeight&&(e=n.innerWidth,t=n.innerHeight),{w:e,h:t}},d=function(){var e=u.getViewPort();return{x:e.x,y:e.y}},a=function(e){window.scrollTo(e.x,e.y)},f=function(e,t){var n=document.body,i=document.documentElement,r,l,c,f,h=t.get(),g=function(){u.setStyle(c,"height",s().h-(l.clientHeight-c.clientHeight))},m=function(){u.unbind(window,"resize",g)};if(l=e.getContainer(),r=l.style,c=e.getContentAreaContainer().firstChild,f=c.style,h)f.width=h.iframeWidth,f.height=h.iframeHeight,h.containerWidth&&(r.width=h.containerWidth),h.containerHeight&&(r.height=h.containerHeight),u.removeClass(n,"mce-fullscreen"),u.removeClass(i,"mce-fullscreen"),u.removeClass(l,"mce-fullscreen"),a(h.scrollPos),u.unbind(window,"resize",h.resizeHandler),e.off("remove",h.removeHandler),t.set(null),o.fireFullscreenStateChanged(e,!1);else{var v={scrollPos:d(),containerWidth:r.width,containerHeight:r.height,iframeWidth:f.width,iframeHeight:f.height,resizeHandler:g,removeHandler:m};f.width=f.height="100%",r.width=r.height="",u.addClass(n,"mce-fullscreen"),u.addClass(i,"mce-fullscreen"),u.addClass(l,"mce-fullscreen"),u.bind(window,"resize",g),e.on("remove",m),g(),t.set(v),o.fireFullscreenStateChanged(e,!0)}},h={toggleFullscreen:f},g=function(e,t){e.addCommand("mceFullScreen",function(){h.toggleFullscreen(e,t)})},m={register:g},v=function(e){return function(t){var n=t.control;e.on("FullscreenStateChanged",function(e){n.active(e.state)})}},w=function(e){e.addMenuItem("fullscreen",{text:"Fullscreen",shortcut:"Ctrl+Shift+F",selectable:!0,cmd:"mceFullScreen",onPostRender:v(e),context:"view"}),e.addButton("fullscreen",{active:!1,tooltip:"Fullscreen",cmd:"mceFullScreen",onPostRender:v(e)})},C={register:w};return n.add("fullscreen",function(e){var n=t(null);return e.settings.inline?r.get(n):(m.register(e,n),C.register(e),e.addShortcut("Ctrl+Shift+F","","mceFullScreen"),r.get(n))}),e}()}();