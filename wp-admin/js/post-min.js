var commentsBox,WPSetThumbnailHTML,WPSetThumbnailID,WPRemoveThumbnail,wptitlehint,makeSlugeditClickable,editPermalink;makeSlugeditClickable=editPermalink=function(){},window.wp=window.wp||{},function($){var t=!1;commentsBox={st:0,get:function(t,e){var i=this.st,n;return e||(e=20),this.st+=e,this.total=t,$("#commentsdiv .spinner").addClass("is-active"),n={action:"get-comments",mode:"single",_ajax_nonce:$("#add_comment_nonce").val(),p:$("#post_ID").val(),start:i,number:e},$.post(ajaxurl,n,function(t){return t=wpAjax.parseAjaxResponse(t),$("#commentsdiv .widefat").show(),$("#commentsdiv .spinner").removeClass("is-active"),"object"==typeof t&&t.responses[0]?($("#the-comment-list").append(t.responses[0].data),theList=theExtraList=null,$("a[className*=':']").unbind(),void(commentsBox.st>commentsBox.total?$("#show-comments").hide():$("#show-comments").show().children("a").html(postL10n.showcomm))):1==t?void $("#show-comments").html(postL10n.endcomm):void $("#the-comment-list").append('<tr><td colspan="2">'+wpAjax.broken+"</td></tr>")}),!1},load:function(t){this.st=jQuery("#the-comment-list tr.comment:visible").length,this.get(t)}},WPSetThumbnailHTML=function(t){$(".inside","#postimagediv").html(t)},WPSetThumbnailID=function(t){var e=$('input[value="_thumbnail_id"]',"#list-table");e.length>0&&$("#meta\\["+e.attr("id").match(/[0-9]+/)+"\\]\\[value\\]").text(t)},WPRemoveThumbnail=function(t){$.post(ajaxurl,{action:"set-post-thumbnail",post_id:$("#post_ID").val(),thumbnail_id:-1,_ajax_nonce:t,cookie:encodeURIComponent(document.cookie)},function(t){"0"==t?alert(setPostThumbnailL10n.error):WPSetThumbnailHTML(t)})},$(document).on("heartbeat-send.refresh-lock",function(t,e){var i=$("#active_post_lock").val(),n=$("#post_ID").val(),a={};n&&$("#post-lock-dialog").length&&(a.post_id=n,i&&(a.lock=i),e["wp-refresh-post-lock"]=a)}).on("heartbeat-tick.refresh-lock",function(t,e){var i,n,a;e["wp-refresh-post-lock"]&&(i=e["wp-refresh-post-lock"],i.lock_error?(n=$("#post-lock-dialog"),n.length&&!n.is(":visible")&&(wp.autosave&&($(document).one("heartbeat-tick",function(){wp.autosave.server.suspend(),n.removeClass("saving").addClass("saved"),$(window).off("beforeunload.edit-post")}),n.addClass("saving"),wp.autosave.server.triggerSave()),i.lock_error.avatar_src&&(a=$('<img class="avatar avatar-64 photo" width="64" height="64" alt="" />').attr("src",i.lock_error.avatar_src.replace(/&amp;/g,"&")),n.find("div.post-locked-avatar").empty().append(a)),n.show().find(".currently-editing").text(i.lock_error.text),n.find(".wp-tab-first").focus())):i.new_lock&&$("#active_post_lock").val(i.new_lock))}).on("before-autosave.update-post-slug",function(){t=document.activeElement&&"title"===document.activeElement.id}).on("after-autosave.update-post-slug",function(){$("#edit-slug-box > *").length||t||$.post(ajaxurl,{action:"sample-permalink",post_id:$("#post_ID").val(),new_title:$("#title").val(),samplepermalinknonce:$("#samplepermalinknonce").val()},function(t){"-1"!=t&&$("#edit-slug-box").html(t)})})}(jQuery),function($){function t(){e=!1,window.clearTimeout(i),i=window.setTimeout(function(){e=!0},3e5)}var e,i;$(document).on("heartbeat-send.wp-refresh-nonces",function(t,i){var n,a=$("#wp-auth-check-wrap");(e||a.length&&!a.hasClass("hidden"))&&(n=$("#post_ID").val())&&$("#_wpnonce").val()&&(i["wp-refresh-post-nonces"]={post_id:n})}).on("heartbeat-tick.wp-refresh-nonces",function(e,i){var n=i["wp-refresh-post-nonces"];n&&(t(),n.replace&&$.each(n.replace,function(t,e){$("#"+t).val(e)}),n.heartbeatNonce&&(window.heartbeatSettings.nonce=n.heartbeatNonce))}).ready(function(){t()})}(jQuery),jQuery(document).ready(function($){function t(){var t,e,i,n,a=0,s=$("#post_name"),o=s.val(),l=$("#sample-permalink"),c=l.html(),p=$("#sample-permalink a").html(),d=$("#edit-slug-buttons"),u=d.html(),h=$("#editable-post-name-full");for(h.find("img").replaceWith(function(){return this.alt}),h=h.html(),l.html(p),i=$("#editable-post-name"),n=i.html(),d.html('<button type="button" class="save button button-small">'+postL10n.ok+'</button> <button type="button" class="cancel button-link">'+postL10n.cancel+"</button>"),d.children(".save").click(function(){var t=i.children("input").val();if(t==$("#editable-post-name-full").text())return void d.children(".cancel").click();$.post(ajaxurl,{action:"sample-permalink",post_id:r,new_slug:t,new_title:$("#title").val(),samplepermalinknonce:$("#samplepermalinknonce").val()},function(e){var i=$("#edit-slug-box");i.html(e),i.hasClass("hidden")&&i.fadeIn("fast",function(){i.removeClass("hidden")}),d.html(u),l.html(c),s.val(t),$(".edit-slug").focus(),wp.a11y.speak(postL10n.permalinkSaved)})}),d.children(".cancel").click(function(){$("#view-post-btn").show(),i.html(n),d.html(u),l.html(c),s.val(o),$(".edit-slug").focus()}),t=0;t<h.length;++t)"%"==h.charAt(t)&&a++;e=a>h.length/4?"":h,i.html('<input type="text" id="new-post-slug" value="'+e+'" autocomplete="off" />').children("input").keydown(function(t){var e=t.which;13===e&&(t.preventDefault(),d.children(".save").click()),27===e&&d.children(".cancel").click()}).keyup(function(){s.val(this.value)}).focus()}var e,i,n,a,s,o="",l=$("#content"),c=$(document),r=$("#post_ID").val()||0,p=$("#submitpost"),d=!0,u=$("#post-visibility-select"),h=$("#timestampdiv"),f=$("#post-status-select"),v=!!window.navigator.platform&&-1!==window.navigator.platform.indexOf("Mac");if(postboxes.add_postbox_toggles(pagenow),window.name="",$("#post-lock-dialog .notification-dialog").on("keydown",function(t){if(9==t.which){var e=$(t.target);e.hasClass("wp-tab-first")&&t.shiftKey?($(this).find(".wp-tab-last").focus(),t.preventDefault()):e.hasClass("wp-tab-last")&&!t.shiftKey&&($(this).find(".wp-tab-first").focus(),t.preventDefault())}}).filter(":visible").find(".wp-tab-first").focus(),wp.heartbeat&&$("#post-lock-dialog").length&&wp.heartbeat.interval(15),n=p.find(":submit, a.submitdelete, #post-preview").on("click.edit-post",function(t){var e=$(this);if(e.hasClass("disabled"))return void t.preventDefault();e.hasClass("submitdelete")||e.is("#post-preview")||$("form#post").off("submit.edit-post").on("submit.edit-post",function(t){if(!t.isDefaultPrevented()){if(wp.autosave&&wp.autosave.server.suspend(),"undefined"!=typeof commentReply){if(!commentReply.discardCommentChanges())return!1;commentReply.close()}d=!1,$(window).off("beforeunload.edit-post"),n.addClass("disabled"),"publish"===e.attr("id")?p.find("#major-publishing-actions .spinner").addClass("is-active"):p.find("#minor-publishing .spinner").addClass("is-active")}})}),$("#post-preview").on("click.post-preview",function(t){var e=$(this),i=$("form#post"),n=$("input#wp-preview"),a=e.attr("target")||"wp-preview",s=navigator.userAgent.toLowerCase();t.preventDefault(),e.hasClass("disabled")||(wp.autosave&&wp.autosave.server.tempBlockSave(),n.val("dopreview"),i.attr("target",a).submit().attr("target",""),-1!==s.indexOf("safari")&&-1===s.indexOf("chrome")&&i.attr("action",function(t,e){return e+"?t="+(new Date).getTime()}),n.val(""))}),$("#title").on("keydown.editor-focus",function(t){var e;if(9===t.keyCode&&!t.ctrlKey&&!t.altKey&&!t.shiftKey){if((e="undefined"!=typeof tinymce&&tinymce.get("content"))&&!e.isHidden())e.focus();else{if(!l.length)return;l.focus()}t.preventDefault()}}),$("#auto_draft").val()&&$("#title").blur(function(){var t;this.value&&!$("#edit-slug-box > *").length&&($("form#post").one("submit",function(){t=!0}),window.setTimeout(function(){!t&&wp.autosave&&wp.autosave.server.triggerSave()},200))}),c.on("autosave-disable-buttons.edit-post",function(){n.addClass("disabled")}).on("autosave-enable-buttons.edit-post",function(){wp.heartbeat&&wp.heartbeat.hasConnectionError()||n.removeClass("disabled")}).on("before-autosave.edit-post",function(){$(".autosave-message").text(postL10n.savingText)}).on("after-autosave.edit-post",function(t,e){$(".autosave-message").text(e.message),$(document.body).hasClass("post-new-php")&&$(".submitbox .submitdelete").show()}),$(window).on("beforeunload.edit-post",function(){var t="undefined"!=typeof tinymce&&tinymce.get("content");if(t&&!t.isHidden()&&t.isDirty()||wp.autosave&&wp.autosave.server.postChanged())return postL10n.saveAlert}).on("unload.edit-post",function(t){if(d&&(!t.target||"#document"==t.target.nodeName)){var e=$("#post_ID").val(),i=$("#active_post_lock").val();if(e&&i){var n={action:"wp-remove-post-lock",_wpnonce:$("#_wpnonce").val(),post_ID:e,active_post_lock:i};if(window.FormData&&window.navigator.sendBeacon){var a=new window.FormData;if($.each(n,function(t,e){a.append(t,e)}),window.navigator.sendBeacon(ajaxurl,a))return}$.post({async:!1,data:n,url:ajaxurl})}}}),$("#tagsdiv-post_tag").length?window.tagBox&&window.tagBox.init():$(".meta-box-sortables").children("div.postbox").each(function(){if(0===this.id.indexOf("tagsdiv-"))return window.tagBox&&window.tagBox.init(),!1}),$(".categorydiv").each(function(){var t=$(this).attr("id"),e,i,n,a,s;n=t.split("-"),n.shift(),a=n.join("-"),s=a+"_tab","category"==a&&(s="cats"),$("a","#"+a+"-tabs").click(function(t){t.preventDefault();var e=$(this).attr("href");$(this).parent().addClass("tabs").siblings("li").removeClass("tabs"),$("#"+a+"-tabs").siblings(".tabs-panel").hide(),$(e).show(),"#"+a+"-all"==e?deleteUserSetting(s):setUserSetting(s,"pop")}),getUserSetting(s)&&$('a[href="#'+a+'-pop"]',"#"+a+"-tabs").click(),$("#new"+a).one("focus",function(){$(this).val("").removeClass("form-input-tip")}),$("#new"+a).keypress(function(t){13===t.keyCode&&(t.preventDefault(),$("#"+a+"-add-submit").click())}),$("#"+a+"-add-submit").click(function(){$("#new"+a).focus()}),e=function(t){return!!$("#new"+a).val()&&(t.data+="&"+$(":checked","#"+a+"checklist").serialize(),$("#"+a+"-add-submit").prop("disabled",!0),t)},i=function(t,e){var i,n=$("#new"+a+"_parent");$("#"+a+"-add-submit").prop("disabled",!1),"undefined"!=e.parsed.responses[0]&&(i=e.parsed.responses[0].supplemental.newcat_parent)&&(n.before(i),n.remove())},$("#"+a+"checklist").wpList({alt:"",response:a+"-ajax-response",addBefore:e,addAfter:i}),$("#"+a+"-add-toggle").click(function(t){t.preventDefault(),$("#"+a+"-adder").toggleClass("wp-hidden-children"),$('a[href="#'+a+'-all"]',"#"+a+"-tabs").click(),$("#new"+a).focus()}),$("#"+a+"checklist, #"+a+"checklist-pop").on("click",'li.popular-category > label input[type="checkbox"]',function(){var t=$(this),e=t.is(":checked"),i=t.val();i&&t.parents("#taxonomy-"+a).length&&$("#in-"+a+"-"+i+", #in-popular-"+a+"-"+i).prop("checked",e)})}),$("#postcustom").length&&$("#the-list").wpList({addBefore:function(t){return t.data+="&post_id="+$("#post_ID").val(),t},addAfter:function(){$("table#list-table").show()}}),$("#submitdiv").length&&(e=$("#timestamp").html(),i=$("#post-visibility-display").html(),a=function(){"public"!=u.find("input:radio:checked").val()?($("#sticky").prop("checked",!1),$("#sticky-span").hide()):$("#sticky-span").show(),"password"!=u.find("input:radio:checked").val()?$("#password-span").hide():$("#password-span").show()},s=function(){if(!h.length)return!0;var t,i,n,a,s=$("#post_status"),o=$('option[value="publish"]',s),l=$("#aa").val(),c=$("#mm").val(),r=$("#jj").val(),p=$("#hh").val(),d=$("#mn").val();return t=new Date(l,c-1,r,p,d),i=new Date($("#hidden_aa").val(),$("#hidden_mm").val()-1,$("#hidden_jj").val(),$("#hidden_hh").val(),$("#hidden_mn").val()),n=new Date($("#cur_aa").val(),$("#cur_mm").val()-1,$("#cur_jj").val(),$("#cur_hh").val(),$("#cur_mn").val()),t.getFullYear()!=l||1+t.getMonth()!=c||t.getDate()!=r||t.getMinutes()!=d?(h.find(".timestamp-wrap").addClass("form-invalid"),!1):(h.find(".timestamp-wrap").removeClass("form-invalid"),t>n&&"future"!=$("#original_post_status").val()?(a=postL10n.publishOnFuture,$("#publish").val(postL10n.schedule)):t<=n&&"publish"!=$("#original_post_status").val()?(a=postL10n.publishOn,$("#publish").val(postL10n.publish)):(a=postL10n.publishOnPast,$("#publish").val(postL10n.update)),i.toUTCString()==t.toUTCString()?$("#timestamp").html(e):$("#timestamp").html("\n"+a+" <b>"+postL10n.dateFormat.replace("%1$s",$('option[value="'+c+'"]',"#mm").attr("data-text")).replace("%2$s",parseInt(r,10)).replace("%3$s",l).replace("%4$s",("00"+p).slice(-2)).replace("%5$s",("00"+d).slice(-2))+"</b> "),"private"==u.find("input:radio:checked").val()?($("#publish").val(postL10n.update),0===o.length?s.append('<option value="publish">'+postL10n.privatelyPublished+"</option>"):o.html(postL10n.privatelyPublished),$('option[value="publish"]',s).prop("selected",!0),$("#misc-publishing-actions .edit-post-status").hide()):("future"==$("#original_post_status").val()||"draft"==$("#original_post_status").val()?o.length&&(o.remove(),s.val($("#hidden_post_status").val())):o.html(postL10n.published),s.is(":hidden")&&$("#misc-publishing-actions .edit-post-status").show()),$("#post-status-display").html($("option:selected",s).text()),"private"==$("option:selected",s).val()||"publish"==$("option:selected",s).val()?$("#save-post").hide():($("#save-post").show(),"pending"==$("option:selected",s).val()?$("#save-post").show().val(postL10n.savePending):$("#save-post").show().val(postL10n.saveDraft)),!0)},$("#visibility .edit-visibility").click(function(t){t.preventDefault(),u.is(":hidden")&&(a(),u.slideDown("fast",function(){u.find('input[type="radio"]').first().focus()}),$(this).hide())}),u.find(".cancel-post-visibility").click(function(t){u.slideUp("fast"),$("#visibility-radio-"+$("#hidden-post-visibility").val()).prop("checked",!0),$("#post_password").val($("#hidden-post-password").val()),$("#sticky").prop("checked",$("#hidden-post-sticky").prop("checked")),$("#post-visibility-display").html(i),$("#visibility .edit-visibility").show().focus(),s(),t.preventDefault()}),u.find(".save-post-visibility").click(function(t){u.slideUp("fast"),$("#visibility .edit-visibility").show().focus(),s(),"public"!=u.find("input:radio:checked").val()&&$("#sticky").prop("checked",!1),o=$("#sticky").prop("checked")?"Sticky":"",$("#post-visibility-display").html(postL10n[u.find("input:radio:checked").val()+o]),t.preventDefault()}),u.find("input:radio").change(function(){a()}),h.siblings("a.edit-timestamp").click(function(t){h.is(":hidden")&&(h.slideDown("fast",function(){$("input, select",h.find(".timestamp-wrap")).first().focus()}),$(this).hide()),t.preventDefault()}),h.find(".cancel-timestamp").click(function(t){h.slideUp("fast").siblings("a.edit-timestamp").show().focus(),$("#mm").val($("#hidden_mm").val()),$("#jj").val($("#hidden_jj").val()),$("#aa").val($("#hidden_aa").val()),$("#hh").val($("#hidden_hh").val()),$("#mn").val($("#hidden_mn").val()),s(),t.preventDefault()}),h.find(".save-timestamp").click(function(t){s()&&(h.slideUp("fast"),h.siblings("a.edit-timestamp").show().focus()),t.preventDefault()}),$("#post").on("submit",function(t){s()||(t.preventDefault(),h.show(),wp.autosave&&wp.autosave.enableButtons(),$("#publishing-action .spinner").removeClass("is-active"))}),f.siblings("a.edit-post-status").click(function(t){f.is(":hidden")&&(f.slideDown("fast",function(){f.find("select").focus()}),$(this).hide()),t.preventDefault()}),f.find(".save-post-status").click(function(t){f.slideUp("fast").siblings("a.edit-post-status").show().focus(),s(),t.preventDefault()}),f.find(".cancel-post-status").click(function(t){f.slideUp("fast").siblings("a.edit-post-status").show().focus(),$("#post_status").val($("#hidden_post_status").val()),s(),t.preventDefault()})),$("#titlediv").on("click",".edit-slug",function(){t()}),wptitlehint=function(t){t=t||"title";var e=$("#"+t),i=$("#"+t+"-prompt-text");""===e.val()&&i.removeClass("screen-reader-text"),i.click(function(){$(this).addClass("screen-reader-text"),e.focus()}),e.blur(function(){""===this.value&&i.removeClass("screen-reader-text")}).focus(function(){i.addClass("screen-reader-text")}).keydown(function(t){i.addClass("screen-reader-text"),$(this).unbind(t)})},wptitlehint(),function(){function t(t){o.hasClass("wp-editor-expand")||(a?i.theme.resizeTo(null,n+t.pageY):l.height(Math.max(50,n+t.pageY)),t.preventDefault())}function e(){var t,e;o.hasClass("wp-editor-expand")||(a?(i.focus(),e=parseInt($("#wp-content-editor-container .mce-toolbar-grp").height(),10),(e<10||e>200)&&(e=30),t=parseInt($("#content_ifr").css("height"),10)+e-28):(l.focus(),t=parseInt(l.css("height"),10)),c.off(".wp-editor-resize"),t&&t>50&&t<5e3&&setUserSetting("ed_size",t))}var i,n,a,s=$("#post-status-info"),o=$("#postdivrich");if(!l.length||"ontouchstart"in window)return void $("#content-resize-handle").hide();s.on("mousedown.wp-editor-resize",function(s){"undefined"!=typeof tinymce&&(i=tinymce.get("content")),i&&!i.isHidden()?(a=!0,n=$("#content_ifr").height()-s.pageY):(a=!1,n=l.height()-s.pageY,l.blur()),c.on("mousemove.wp-editor-resize",t).on("mouseup.wp-editor-resize mouseleave.wp-editor-resize",e),s.preventDefault()}).on("mouseup.wp-editor-resize",e)}(),"undefined"!=typeof tinymce&&($("#post-formats-select input.post-format").on("change.set-editor-class",function(){var t,e,i=this.id;i&&$(this).prop("checked")&&(t=tinymce.get("content"))&&(e=t.getBody(),e.className=e.className.replace(/\bpost-format-[^ ]+/,""),t.dom.addClass(e,"post-format-0"==i?"post-format-standard":i),$(document).trigger("editor-classchange"))}),$("#page_template").on("change.set-editor-class",function(){var t,e,i=$(this).val()||"";(i=i.substr(i.lastIndexOf("/")+1,i.length).replace(/\.php$/,"").replace(/\./g,"-"))&&(t=tinymce.get("content"))&&(e=t.getBody(),e.className=e.className.replace(/\bpage-template-[^ ]+/,""),t.dom.addClass(e,"page-template-"+i),$(document).trigger("editor-classchange"))})),l.on("keydown.wp-autosave",function(t){if(83===t.which){if(t.shiftKey||t.altKey||v&&(!t.metaKey||t.ctrlKey)||!v&&!t.ctrlKey)return;wp.autosave&&wp.autosave.server.triggerSave(),t.preventDefault()}}),"auto-draft"===$("#original_post_status").val()&&window.history.replaceState){var m;$("#publish").on("click",function(){m=window.location.href,m+=-1!==m.indexOf("?")?"&":"?",m+="wp-post-new-reload=true",window.history.replaceState(null,null,m)})}}),function($,t){$(function(){function e(){var e,o;e=!s||s.isHidden()?i.val():s.getContent({format:"raw"}),o=t.count(e),o!==a&&n.text(o),a=o}var i=$("#content"),n=$("#wp-word-count").find(".word-count"),a=0,s;$(document).on("tinymce-editor-init",function(t,i){"content"===i.id&&(s=i,i.on("nodechange keyup",_.debounce(e,1e3)))}),i.on("input keyup",_.debounce(e,1e3)),e()})}(jQuery,new wp.utils.WordCounter);