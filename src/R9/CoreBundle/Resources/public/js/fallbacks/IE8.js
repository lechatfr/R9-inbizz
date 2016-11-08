/*---------------------------*/
/*    MatchMedia Polyfill    */
/*---------------------------*/

/*---Full enquire support but doesn't work with respond---*/

/* MediaMatch v.2.0.2 - Testing css media queries in Javascript. Authors & copyright (c) 2013: WebLinc, David Knight. */
window.matchMedia||(window.matchMedia=function(c){var a=c.document,w=a.documentElement,l=[],t=0,x="",h={},G=/\s*(only|not)?\s*(screen|print|[a-z\-]+)\s*(and)?\s*/i,H=/^\s*\(\s*(-[a-z]+-)?(min-|max-)?([a-z\-]+)\s*(:?\s*([0-9]+(\.[0-9]+)?|portrait|landscape)(px|em|dppx|dpcm|rem|%|in|cm|mm|ex|pt|pc|\/([0-9]+(\.[0-9]+)?))?)?\s*\)\s*$/,y=0,A=function(b){var z=-1!==b.indexOf(",")&&b.split(",")||[b],e=z.length-1,j=e,g=null,d=null,c="",a=0,l=!1,m="",f="",g=null,d=0,f=null,k="",p="",q="",n="",r="",k=!1;if(""===b)return!0;do{g=z[j-e];l=!1;if(d=g.match(G))c=d[0],a=d.index;if(!d||-1===g.substring(0,a).indexOf("(")&&(a||!d[3]&&c!==d.input))k=!1;else{f=g;l="not"===d[1];a||(m=d[2],f=g.substring(c.length));k=m===x||"all"===m||""===m;g=-1!==f.indexOf(" and ")&&f.split(" and ")||[f];d=g.length-1;if(k&&0<=d&&""!==f){do{f=g[d].match(H);if(!f||!h[f[3]]){k=!1;break}k=f[2];n=p=f[5];q=f[7];r=h[f[3]];q&&(n="px"===q?Number(p):"em"===q||"rem"===q?16*p:f[8]?(p/f[8]).toFixed(2):"dppx"===q?96*p:"dpcm"===q?0.3937*p:Number(p));k="min-"===k&&n?r>=n:"max-"===k&&n?r<=n:n?r===n:!!r;if(!k)break}while(d--)}if(k)break}}while(e--);return l?!k:k},B=function(){var b=c.innerWidth||w.clientWidth,a=c.innerHeight||w.clientHeight,e=c.screen.width,j=c.screen.height,g=c.screen.colorDepth,d=c.devicePixelRatio;h.width=b;h.height=a;h["aspect-ratio"]=(b/a).toFixed(2);h["device-width"]=e;h["device-height"]=j;h["device-aspect-ratio"]=(e/j).toFixed(2);h.color=g;h["color-index"]=Math.pow(2,g);h.orientation=a>=b?"portrait":"landscape";h.resolution=d&&96*d||c.screen.deviceXDPI||96;h["device-pixel-ratio"]=d||1},C=function(){clearTimeout(y);y=setTimeout(function(){var b=null,a=t-1,e=a,j=!1;if(0<=a){B();do if(b=l[e-a])if((j=A(b.mql.media))&&!b.mql.matches||!j&&b.mql.matches)if(b.mql.matches=j,b.listeners)for(var j=0,g=b.listeners.length;j<g;j++)b.listeners[j]&&b.listeners[j].call(c,b.mql);while(a--)}},10)},D=a.getElementsByTagName("head")[0],a=a.createElement("style"),E=null,u="screen print speech projection handheld tv braille embossed tty".split(" "),m=0,I=u.length,s="#mediamatchjs { position: relative; z-index: 0; }",v="",F=c.addEventListener||(v="on")&&c.attachEvent;a.type="text/css";a.id="mediamatchjs";D.appendChild(a);for(E=c.getComputedStyle&&c.getComputedStyle(a)||a.currentStyle;m<I;m++)s+="@media "+u[m]+" { #mediamatchjs { position: relative; z-index: "+m+" } }";a.styleSheet?a.styleSheet.cssText=s:a.textContent=s;x=u[1*E.zIndex||0];D.removeChild(a);B();F(v+"resize",C);F(v+"orientationchange",C);return function(a){var c=t,e={matches:!1,media:a,addListener:function(a){l[c].listeners||(l[c].listeners=[]);a&&l[c].listeners.push(a)},removeListener:function(a){var b=l[c],d=0,e=0;if(b)for(e=b.listeners.length;d<e;d++)b.listeners[d]===a&&b.listeners.splice(d,1)}};if(""===a)return e.matches=!0,e;e.matches=A(a);t=l.push({mql:e,listeners:null});return e}}(window));


/*---Basic enquire support only (must use mobile first way with shouldDegrade parameter) and work with respond---*/

/*! matchMedia() polyfill & addListener/removeListener extension - Test a CSS media type/query in JS. Authors & copyright (c) 2012: Scott Jehl, Paul Irish, Nicholas Zakas, David Knight. Dual MIT/BSD license */
//window.matchMedia||(window.matchMedia=function(){"use strict";var e=window.styleMedia||window.media;if(!e){var t=document.createElement("style"),n=document.getElementsByTagName("script")[0],i=null;t.type="text/css",t.id="matchmediajs-test",n.parentNode.insertBefore(t,n),i="getComputedStyle"in window&&window.getComputedStyle(t,null)||t.currentStyle,e={matchMedium:function(e){var n="@media "+e+"{ #matchmediajs-test { width: 1px; } }";return t.styleSheet?t.styleSheet.cssText=n:t.textContent=n,"1px"===i.width}}}return function(t){return{matches:e.matchMedium(t||"all"),media:t||"all"}}}()),function(){if(window.matchMedia&&window.matchMedia("all").addListener)return!1;var e=window.matchMedia,t=e("only all").matches,n=!1,i=0,a=[],d=function(){clearTimeout(i),i=setTimeout(function(){for(var t=0,n=a.length;n>t;t++){var i=a[t].mql,d=a[t].listeners||[],r=e(i.media).matches;if(r!==i.matches){i.matches=r;for(var c=0,m=d.length;m>c;c++)d[c].call(window,i)}}},30)};window.matchMedia=function(i){var r=e(i),c=[],m=0;return r.addListener=function(e){t&&(n||(n=!0,window.addEventListener("resize",d,!0)),0===m&&(m=a.push({mql:r,listeners:c})),c.push(e))},r.removeListener=function(e){for(var t=0,n=c.length;n>t;t++)c[t]===e&&c.splice(t,1)},r}}();



/*---------------------------*/
/*          Respond          */
/*---------------------------*/

/*! Respond.js v1.4.2: min/max-width media query polyfill * Copyright 2014 Scott Jehl * Licensed under MIT * http://j.mp/respondjs */
//!function(e){"use strict";function t(){E(!0)}var a={};e.respond=a,a.update=function(){};var n=[],r=function(){var t=!1;try{t=new e.XMLHttpRequest}catch(a){t=new e.ActiveXObject("Microsoft.XMLHTTP")}return function(){return t}}(),s=function(e,t){var a=r();a&&(a.open("GET",e,!0),a.onreadystatechange=function(){4!==a.readyState||200!==a.status&&304!==a.status||t(a.responseText)},4!==a.readyState&&a.send(null))},i=function(e){return e.replace(a.regex.minmaxwh,"").match(a.regex.other)};if(a.ajax=s,a.queue=n,a.unsupportedmq=i,a.regex={media:/@media[^\{]+\{([^\{\}]*\{[^\}\{]*\})+/gi,keyframes:/@(?:\-(?:o|moz|webkit)\-)?keyframes[^\{]+\{(?:[^\{\}]*\{[^\}\{]*\})+[^\}]*\}/gi,comments:/\/\*[^*]*\*+([^/][^*]*\*+)*\//gi,urls:/(url\()['"]?([^\/\)'"][^:\)'"]+)['"]?(\))/g,findStyles:/@media *([^\{]+)\{([\S\s]+?)$/,only:/(only\s+)?([a-zA-Z]+)\s?/,minw:/\(\s*min\-width\s*:\s*(\s*[0-9\.]+)(px|em)\s*\)/,maxw:/\(\s*max\-width\s*:\s*(\s*[0-9\.]+)(px|em)\s*\)/,minmaxwh:/\(\s*m(in|ax)\-(height|width)\s*:\s*(\s*[0-9\.]+)(px|em)\s*\)/gi,other:/\([^\)]*\)/g},a.mediaQueriesSupported=e.matchMedia&&null!==e.matchMedia("only all")&&e.matchMedia("only all").matches,!a.mediaQueriesSupported){var o,l,m,h=e.document,d=h.documentElement,u=[],c=[],p=[],f={},g=30,x=h.getElementsByTagName("head")[0]||d,y=h.getElementsByTagName("base")[0],v=x.getElementsByTagName("link"),w=function(){var e,t=h.createElement("div"),a=h.body,n=d.style.fontSize,r=a&&a.style.fontSize,s=!1;return t.style.cssText="position:absolute;font-size:1em;width:1em",a||(a=s=h.createElement("body"),a.style.background="none"),d.style.fontSize="100%",a.style.fontSize="100%",a.appendChild(t),s&&d.insertBefore(a,d.firstChild),e=t.offsetWidth,s?d.removeChild(a):a.removeChild(t),d.style.fontSize=n,r&&(a.style.fontSize=r),e=m=parseFloat(e)},E=function(t){var a="clientWidth",n=d[a],r="CSS1Compat"===h.compatMode&&n||h.body[a]||n,s={},i=v[v.length-1],f=(new Date).getTime();if(t&&o&&g>f-o)return e.clearTimeout(l),void(l=e.setTimeout(E,g));o=f;for(var y in u)if(u.hasOwnProperty(y)){var S=u[y],T=S.minw,$=S.maxw,z=null===T,b=null===$,C="em";T&&(T=parseFloat(T)*(T.indexOf(C)>-1?m||w():1)),$&&($=parseFloat($)*($.indexOf(C)>-1?m||w():1)),S.hasquery&&(z&&b||!(z||r>=T)||!(b||$>=r))||(s[S.media]||(s[S.media]=[]),s[S.media].push(c[S.rules]))}for(var R in p)p.hasOwnProperty(R)&&p[R]&&p[R].parentNode===x&&x.removeChild(p[R]);p.length=0;for(var O in s)if(s.hasOwnProperty(O)){var M=h.createElement("style"),k=s[O].join("\n");M.type="text/css",M.media=O,x.insertBefore(M,i.nextSibling),M.styleSheet?M.styleSheet.cssText=k:M.appendChild(h.createTextNode(k)),p.push(M)}},S=function(e,t,n){var r=e.replace(a.regex.comments,"").replace(a.regex.keyframes,"").match(a.regex.media),s=r&&r.length||0;t=t.substring(0,t.lastIndexOf("/"));var o=function(e){return e.replace(a.regex.urls,"$1"+t+"$2$3")},l=!s&&n;t.length&&(t+="/"),l&&(s=1);for(var m=0;s>m;m++){var h,d,p,f;l?(h=n,c.push(o(e))):(h=r[m].match(a.regex.findStyles)&&RegExp.$1,c.push(RegExp.$2&&o(RegExp.$2))),p=h.split(","),f=p.length;for(var g=0;f>g;g++)d=p[g],i(d)||u.push({media:d.split("(")[0].match(a.regex.only)&&RegExp.$2||"all",rules:c.length-1,hasquery:d.indexOf("(")>-1,minw:d.match(a.regex.minw)&&parseFloat(RegExp.$1)+(RegExp.$2||""),maxw:d.match(a.regex.maxw)&&parseFloat(RegExp.$1)+(RegExp.$2||"")})}E()},T=function(){if(n.length){var t=n.shift();s(t.href,function(a){S(a,t.href,t.media),f[t.href]=!0,e.setTimeout(function(){T()},0)})}},$=function(){for(var t=0;t<v.length;t++){var a=v[t],r=a.href,s=a.media,i=a.rel&&"stylesheet"===a.rel.toLowerCase();r&&i&&!f[r]&&(a.styleSheet&&a.styleSheet.rawCssText?(S(a.styleSheet.rawCssText,r,s),f[r]=!0):(!/^([a-zA-Z:]*\/\/)/.test(r)&&!y||r.replace(RegExp.$1,"").split("/")[0]===e.location.host)&&("//"===r.substring(0,2)&&(r=e.location.protocol+r),n.push({href:r,media:s})))}T()};$(),a.update=$,a.getEmValue=w,e.addEventListener?e.addEventListener("resize",t,!1):e.attachEvent&&e.attachEvent("onresize",t)}}(this);


/*! RespondMore.js (work with MediaMatch but not fully tested) */
window.matchMedia||(window.matchMedia=function(e){"use strict";var t=e.document,n=t.documentElement,r=[],i=0,s="",o={},u=/\s*(only|not)?\s*(screen|print|[a-z\-]+)\s*(and)?\s*/i,a=/^\s*\(\s*(-[a-z]+-)?(min-|max-)?([a-z\-]+)\s*(:?\s*([0-9]+(\.[0-9]+)?|portrait|landscape)(px|em|dppx|dpcm|rem|%|in|cm|mm|ex|pt|pc|\/([0-9]+(\.[0-9]+)?))?)?\s*\)\s*$/,f=0,l=function(e){var t=e.indexOf(",")!==-1&&e.split(",")||[e],n=t.length-1,r=n,i=null,f=null,l="",c=0,h=false,p="",d="",v=null,m=0,g=0,y=null,b="",w="",E="",S="",x="",T=false;if(e===""){return true}do{i=t[r-n];h=false;f=i.match(u);if(f){l=f[0];c=f.index}if(!f||i.substring(0,c).indexOf("(")===-1&&(c||!f[3]&&l!==f.input)){T=false;continue}d=i;h=f[1]==="not";if(!c){p=f[2];d=i.substring(l.length)}T=p===s||p==="all"||p==="";v=d.indexOf(" and ")!==-1&&d.split(" and ")||[d];m=v.length-1;g=m;if(T&&m>=0&&d!==""){do{y=v[m].match(a);if(!y||!o[y[3]]){T=false;break}b=y[2];w=y[5];S=w;E=y[7];x=o[y[3]];if(E){if(E==="px"){S=Number(w)}else if(E==="em"||E==="rem"){S=16*w}else if(y[8]){S=(w/y[8]).toFixed(2)}else if(E==="dppx"){S=w*96}else if(E==="dpcm"){S=w*.3937}else{S=Number(w)}}if(b==="min-"&&S){T=x>=S}else if(b==="max-"&&S){T=x<=S}else if(S){T=x===S}else{T=!!x}if(!T){break}}while(m--)}if(T){break}}while(n--);return h?!T:T},c=function(){var t=e.innerWidth||n.clientWidth,r=e.innerHeight||n.clientHeight,i=e.screen.width,s=e.screen.height,u=e.screen.colorDepth,a=e.devicePixelRatio;o.width=t;o.height=r;o["aspect-ratio"]=(t/r).toFixed(2);o["device-width"]=i;o["device-height"]=s;o["device-aspect-ratio"]=(i/s).toFixed(2);o.color=u;o["color-index"]=Math.pow(2,u);o.orientation=r>=t?"portrait":"landscape";o.resolution=a&&a*96||e.screen.deviceXDPI||96;o["device-pixel-ratio"]=a||1},h=function(){clearTimeout(f);f=setTimeout(function(){var t=null,n=i-1,s=n,o=false;if(n>=0){c();do{t=r[s-n];if(t){o=l(t.mql.media);if(o&&!t.mql.matches||!o&&t.mql.matches){t.mql.matches=o;if(t.listeners){for(var u=0,a=t.listeners.length;u<a;u++){if(t.listeners[u]){t.listeners[u].call(e,t.mql)}}}}}}while(n--)}},10)},p=function(){var n=t.getElementsByTagName("head")[0],r=t.createElement("style"),i=null,o=["screen","print","speech","projection","handheld","tv","braille","embossed","tty"],u=0,a=o.length,f="#mediamatchjs { position: relative; z-index: 0; }",l="",p=e.addEventListener||(l="on")&&e.attachEvent;r.type="text/css";r.id="mediamatchjs";n.appendChild(r);i=e.getComputedStyle&&e.getComputedStyle(r)||r.currentStyle;for(;u<a;u++){f+="@media "+o[u]+" { #mediamatchjs { position: relative; z-index: "+u+" } }"}if(r.styleSheet){r.styleSheet.cssText=f}else{r.textContent=f}s=o[i.zIndex*1||0];n.removeChild(r);c();p(l+"resize",h);p(l+"orientationchange",h)};p();return function(e){var t=i,n={matches:false,media:e,addListener:function(n){r[t].listeners||(r[t].listeners=[]);n&&r[t].listeners.push(n)},removeListener:function(n){var i=r[t],s=0,o=0;if(!i){return}o=i.listeners.length;for(;s<o;s++){if(i.listeners[s]===n){i.listeners.splice(s,1)}}}};if(e===""){n.matches=true;return n}n.matches=l(e);i=r.push({mql:n,listeners:null});return n}}(window));(function(e){function S(){b(true)}e.respond={};respond.update=function(){};respond.mediaQueriesSupported=e.matchMedia&&e.matchMedia("only all").matches&&e.matchMedia("(min-monochrome: 0)").matches;if(respond.mediaQueriesSupported){return}var t=e.document,n=t.documentElement,r=[],i=[],s=[],o={},u=30,a=t.getElementsByTagName("head")[0]||n,f=t.getElementsByTagName("base")[0],l=a.getElementsByTagName("link"),c=[],h=function(){var t=l,n=t.length,r=0,i,s,u,a;for(;r<n;r++){i=t[r],s=i.href,u=i.media,a=i.rel&&i.rel.toLowerCase()==="stylesheet";if(!!s&&a&&!o[s]){if(i.styleSheet&&i.styleSheet.rawCssText){d(i.styleSheet.rawCssText,s,u);o[s]=true}else{if(!/^([a-zA-Z:]*\/\/)/.test(s)&&!f||s.replace(RegExp.$1,"").split("/")[0]===e.location.host){c.push({href:s,media:u})}}}}p()},p=function(){if(c.length){var e=c.shift();w(e.href,function(t){d(t,e.href,e.media);o[e.href]=true;p()})}},d=function(e,t,n){var s=e.match(/@media[^\{]+\{([^\{\}]*\{[^\}\{]*\})+/gi),o=s&&s.length||0,t=t.substring(0,t.lastIndexOf("/")),u=function(e){return e.replace(/(url\()['"]?([^\/\)'"][^:\)'"]+)['"]?(\))/g,"$1"+t+"$2$3")},a=!o&&n,f=0,l,c,h,p,d;if(t.length){t+="/"}if(a){o=1}for(;f<o;f++){l=0;if(a){c=n;i.push(u(e))}else{c=s[f].match(/@media *([^\{]+)\{([\S\s]+?)$/)&&RegExp.$1;i.push(RegExp.$2&&u(RegExp.$2))}p=c.split(",");d=p.length;for(;l<d;l++){h=p[l];r.push({media:h.split("(")[0].match(/(only\s+)?([a-zA-Z]+)\s?/)&&RegExp.$2||"all",rules:i.length-1,hasquery:h.indexOf("(")>-1,minw:h.match(/\(min\-width:[\s]*([\s]*[0-9\.]+)(px|em)[\s]*\)/)&&parseFloat(RegExp.$1)+(RegExp.$2||""),maxw:h.match(/\(max\-width:[\s]*([\s]*[0-9\.]+)(px|em)[\s]*\)/)&&parseFloat(RegExp.$1)+(RegExp.$2||"")})}}b()},v,m,g=function(){var e,r=t.createElement("div"),i=t.body,s=false;r.style.cssText="position:absolute;font-size:1em;width:1em";if(!i){i=s=t.createElement("body");i.style.background="none"}i.appendChild(r);n.insertBefore(i,n.firstChild);e=r.offsetWidth;if(s){n.removeChild(i)}else{i.removeChild(r)}e=y=parseFloat(e);return e},y,b=function(e){var o="clientWidth",f=n[o],c=t.compatMode==="CSS1Compat"&&f||t.body[o]||f,h={},p=l[l.length-1],d=(new Date).getTime();if(e&&v&&d-v<u){clearTimeout(m);m=setTimeout(b,u);return}else{v=d}for(var w in r){var E=r[w],S=E.minw,x=E.maxw,T=S===null,N=x===null,C="em";if(!!S){S=parseFloat(S)*(S.indexOf(C)>-1?y||g():1)}if(!!x){x=parseFloat(x)*(x.indexOf(C)>-1?y||g():1)}if(!E.hasquery||(!T||!N)&&(T||c>=S)&&(N||c<=x)){if(!h[E.media]){h[E.media]=[]}h[E.media].push(i[E.rules])}}for(var w in s){if(s[w]&&s[w].parentNode===a){a.removeChild(s[w])}}for(var w in h){var k=t.createElement("style"),L=h[w].join("\n");k.type="text/css";k.media=w;a.insertBefore(k,p.nextSibling);if(k.styleSheet){k.styleSheet.cssText=L}else{k.appendChild(t.createTextNode(L))}s.push(k)}},w=function(e,t){var n=E();if(!n){return}n.open("GET",e,true);n.onreadystatechange=function(){if(n.readyState!=4||n.status!=200&&n.status!=304){return}t(n.responseText)};if(n.readyState==4){return}n.send(null)},E=function(){var e=false;try{e=new XMLHttpRequest}catch(t){e=new ActiveXObject("Microsoft.XMLHTTP")}return function(){return e}}();h();respond.update=h;if(e.addEventListener){e.addEventListener("resize",S,false)}else if(e.attachEvent){e.attachEvent("onresize",S)}})(this)


