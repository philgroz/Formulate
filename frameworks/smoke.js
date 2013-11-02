(function(){var e={smoketimeout:[],init:false,zindex:1e3,i:0,bodyload:function(t){var n=document.createElement("div");n.setAttribute("id","smoke-out-"+t);n.className="smoke-base";n.style.zIndex=e.zindex;e.zindex++;document.body.appendChild(n)},newdialog:function(){var t=(new Date).getTime();t=Math.random(1,99)+t;if(!e.init){e.listen(window,"load",function(){e.bodyload(t)})}else{e.bodyload(t)}return t},forceload:function(){},build:function(t,n){e.i++;n.stack=e.i;t=t.replace(/\n/g,"<br />");t=t.replace(/\r/g,"<br />");var r="",i="OK",s="Cancel",o="",u="",a;if(n.type==="prompt"){r='<div class="dialog-prompt">'+'<input id="dialog-input-'+n.newid+'" type="text" '+(n.params.value?'value="'+n.params.value+'"':"")+" />"+"</div>"}if(n.params.ok){i=n.params.ok}if(n.params.cancel){s=n.params.cancel}if(n.params.classname){o=n.params.classname}if(n.type!=="signal"){u='<div class="dialog-buttons">';if(n.type==="alert"){u+='<button id="alert-ok-'+n.newid+'">'+i+"</button>"}else if(n.type==="quiz"){if(n.params.button_1){u+='<button class="quiz-button" id="'+n.type+"-ok1-"+n.newid+'">'+n.params.button_1+"</button>"}if(n.params.button_2){u+='<button class="quiz-button" id="'+n.type+"-ok2-"+n.newid+'">'+n.params.button_2+"</button>"}if(n.params.button_3){u+='<button class="quiz-button" id="'+n.type+"-ok3-"+n.newid+'">'+n.params.button_3+"</button>"}if(n.params.button_cancel){u+='<button id="'+n.type+"-cancel-"+n.newid+'" class="cancel">'+n.params.button_cancel+"</button>"}}else if(n.type==="prompt"||n.type==="confirm"){if(n.params.reverseButtons){u+='<button id="'+n.type+"-ok-"+n.newid+'">'+i+"</button>"+'<button id="'+n.type+"-cancel-"+n.newid+'" class="cancel">'+s+"</button>"}else{u+='<button id="'+n.type+"-cancel-"+n.newid+'" class="cancel">'+s+"</button>"+'<button id="'+n.type+"-ok-"+n.newid+'">'+i+"</button>"}}u+="</div>"}a='<div id="smoke-bg-'+n.newid+'" class="smokebg"></div>'+'<div class="dialog smoke '+o+'">'+'<div class="dialog-inner">'+t+r+u+"</div>"+"</div>";if(!e.init){e.listen(window,"load",function(){e.finishbuild(t,n,a)})}else{e.finishbuild(t,n,a)}},finishbuild:function(t,n,r){var i=document.getElementById("smoke-out-"+n.newid);i.className="smoke-base smoke-visible  smoke-"+n.type;i.innerHTML=r;while(i.innerHTML===""){i.innerHTML=r}if(e.smoketimeout[n.newid]){clearTimeout(e.smoketimeout[n.newid])}e.listen(document.getElementById("smoke-bg-"+n.newid),"click",function(){e.destroy(n.type,n.newid);if(n.type==="prompt"||n.type==="confirm"||n.type==="quiz"){n.callback(false)}else if(n.type==="alert"&&typeof n.callback!=="undefined"){n.callback()}});switch(n.type){case"alert":e.finishbuildAlert(t,n,r);break;case"confirm":e.finishbuildConfirm(t,n,r);break;case"quiz":e.finishbuildQuiz(t,n,r);break;case"prompt":e.finishbuildPrompt(t,n,r);break;case"signal":e.finishbuildSignal(t,n,r);break;default:throw"Unknown type: "+n.type}},finishbuildAlert:function(t,n,r){e.listen(document.getElementById("alert-ok-"+n.newid),"click",function(){e.destroy(n.type,n.newid);if(typeof n.callback!=="undefined"){n.callback()}});document.onkeyup=function(t){if(!t){t=window.event}if(t.keyCode===13||t.keyCode===32||t.keyCode===27){e.destroy(n.type,n.newid);if(typeof n.callback!=="undefined"){n.callback()}}}},finishbuildConfirm:function(t,n,r){e.listen(document.getElementById("confirm-cancel-"+n.newid),"click",function(){e.destroy(n.type,n.newid);n.callback(false)});e.listen(document.getElementById("confirm-ok-"+n.newid),"click",function(){e.destroy(n.type,n.newid);n.callback(true)});document.onkeyup=function(t){if(!t){t=window.event}if(t.keyCode===13||t.keyCode===32){e.destroy(n.type,n.newid);n.callback(true)}else if(t.keyCode===27){e.destroy(n.type,n.newid);n.callback(false)}}},finishbuildQuiz:function(t,n,r){e.listen(document.getElementById("quiz-cancel-"+n.newid),"click",function(){e.destroy(n.type,n.newid);n.callback(false)});if(a=document.getElementById("quiz-ok1-"+n.newid))e.listen(a,"click",function(){e.destroy(n.type,n.newid);n.callback(a.innerHTML)});if(b=document.getElementById("quiz-ok2-"+n.newid))e.listen(b,"click",function(){e.destroy(n.type,n.newid);n.callback(b.innerHTML)});if(c=document.getElementById("quiz-ok3-"+n.newid))e.listen(c,"click",function(){e.destroy(n.type,n.newid);n.callback(c.innerHTML)});document.onkeyup=function(t){if(!t){t=window.event}if(t.keyCode===27){e.destroy(n.type,n.newid);n.callback(false)}}},finishbuildPrompt:function(t,n,r){var i=document.getElementById("dialog-input-"+n.newid);setTimeout(function(){i.focus();i.select()},100);e.listen(document.getElementById("prompt-cancel-"+n.newid),"click",function(){e.destroy(n.type,n.newid);n.callback(false)});e.listen(document.getElementById("prompt-ok-"+n.newid),"click",function(){e.destroy(n.type,n.newid);n.callback(i.value)});document.onkeyup=function(t){if(!t){t=window.event}if(t.keyCode===13){e.destroy(n.type,n.newid);n.callback(i.value)}else if(t.keyCode===27){e.destroy(n.type,n.newid);n.callback(false)}}},finishbuildSignal:function(t,n,r){document.onkeyup=function(t){if(!t){t=window.event}if(t.keyCode===27){e.destroy(n.type,n.newid);if(typeof n.callback!=="undefined"){n.callback()}}};e.smoketimeout[n.newid]=setTimeout(function(){e.destroy(n.type,n.newid);if(typeof n.callback!=="undefined"){n.callback()}},n.timeout)},destroy:function(t,n){var r=document.getElementById("smoke-out-"+n);if(t!=="quiz"){var i=document.getElementById(t+"-ok-"+n)}var s=document.getElementById(t+"-cancel-"+n);r.className="smoke-base";if(i){e.stoplistening(i,"click",function(){});document.onkeyup=null}if(t==="quiz"){var o=document.getElementsByClassName("quiz-button");for(var u=0;u<o.length;u++){e.stoplistening(o[u],"click",function(){});document.onkeyup=null}}if(s){e.stoplistening(s,"click",function(){})}e.i=0;r.innerHTML=""},alert:function(t,n,r){if(typeof r!=="object"){r=false}var i=e.newdialog();e.build(t,{type:"alert",callback:n,params:r,newid:i})},signal:function(t,n,r){if(typeof r!=="object"){r=false}var i=5e3;if(r.duration!=="undefined"){i=r.duration}var s=e.newdialog();e.build(t,{type:"signal",callback:n,timeout:i,params:r,newid:s})},confirm:function(t,n,r){if(typeof r!=="object"){r=false}var i=e.newdialog();e.build(t,{type:"confirm",callback:n,params:r,newid:i})},quiz:function(t,n,r){if(typeof r!=="object"){r=false}var i=e.newdialog();e.build(t,{type:"quiz",callback:n,params:r,newid:i})},prompt:function(t,n,r){if(typeof r!=="object"){r=false}var i=e.newdialog();return e.build(t,{type:"prompt",callback:n,params:r,newid:i})},listen:function(e,t,n){if(e.addEventListener){return e.addEventListener(t,n,false)}if(e.attachEvent){return e.attachEvent("on"+t,n)}return false},stoplistening:function(e,t,n){if(e.removeEventListener){return e.removeEventListener("click",n,false)}if(e.detachEvent){return e.detachEvent("on"+t,n)}return false}};e.init=true;if(typeof module!="undefined"&&module.exports){module.exports=e}else if(typeof define==="function"&&define.amd){define(e)}else{this.smoke=e}})()