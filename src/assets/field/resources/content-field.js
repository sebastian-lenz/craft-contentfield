!function(e){function t(t){for(var r,c,o=t[0],l=t[1],u=t[2],f=0,d=[];f<o.length;f++)c=o[f],Object.prototype.hasOwnProperty.call(a,c)&&a[c]&&d.push(a[c][0]),a[c]=0
for(r in l)Object.prototype.hasOwnProperty.call(l,r)&&(e[r]=l[r])
for(s&&s(t);d.length;)d.shift()()
return i.push.apply(i,u||[]),n()}function n(){for(var e,t=0;t<i.length;t++){for(var n=i[t],r=!0,o=1;o<n.length;o++){var l=n[o]
0!==a[l]&&(r=!1)}r&&(i.splice(t--,1),e=c(c.s=n[0]))}return e}var r={},a={0:0},i=[]
function c(t){if(r[t])return r[t].exports
var n=r[t]={i:t,l:!1,exports:{}}
return e[t].call(n.exports,n,n.exports,c),n.l=!0,n.exports}c.m=e,c.c=r,c.d=function(e,t,n){c.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:n})},c.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},c.t=function(e,t){if(1&t&&(e=c(e)),8&t)return e
if(4&t&&"object"==typeof e&&e&&e.__esModule)return e
var n=Object.create(null)
if(c.r(n),Object.defineProperty(n,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var r in e)c.d(n,r,function(t){return e[t]}.bind(null,r))
return n},c.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e}
return c.d(t,"a",t),t},c.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},c.p=""
var o=window.contentFieldJsonp=window.contentFieldJsonp||[],l=o.push.bind(o)
o.push=t,o=o.slice()
for(var u=0;u<o.length;u++)t(o[u])
var s=l
i.push([315,1]),n()}({165:function(e,t,n){},166:function(e,t,n){},170:function(e,t){e.exports=jQuery},262:function(e,t,n){},266:function(e,t,n){},267:function(e,t,n){},268:function(e,t,n){},269:function(e,t,n){},272:function(e,t,n){},273:function(e,t,n){},277:function(e,t,n){},278:function(e,t,n){},279:function(e,t,n){},280:function(e,t,n){},281:function(e,t,n){},282:function(e,t,n){},287:function(e,t,n){},288:function(e,t,n){},289:function(e,t,n){},290:function(e,t,n){},291:function(e,t,n){},292:function(e,t,n){},293:function(e,t,n){},294:function(e,t,n){},295:function(e,t,n){},296:function(e,t,n){},297:function(e,t,n){},298:function(e,t,n){},299:function(e,t,n){},300:function(e,t,n){},301:function(e,t,n){},302:function(e,t,n){},303:function(e,t,n){},304:function(e,t,n){},305:function(e,t,n){},306:function(e,t,n){},307:function(e,t,n){},308:function(e,t,n){},309:function(e,t,n){},310:function(e,t,n){},312:function(e,t,n){},313:function(e,t,n){},314:function(e,t,n){},315:function(e,t,n){"use strict"
n.r(t)
var r=n(0),a=n(61),i=n(168),c=n(51),o=n(9)
n(16),n(10),n(70),n(33)
function l(e,t){var n=e.schemas[t.__type]
if(!n)throw new Error('Could not resolve schema "'.concat(t.__type,'".'))
return n}var u=n(18),s=n.n(u)
function f(e){return e&&"object"===s()(e)&&"__type"in e&&"__uuid"in e}function d(e,t){return function e(t,n,r){if(f(r)&&r.__uuid===n)return{model:r,path:[],uuid:n}
for(var a=l(t,r),i=0,c=Object.keys(a.fields);i<c.length;i++){var o=c[i],u=a.fields[o]
if("array"===u.type&&"instance"===u.member.type){var s=r[o]
if(!Array.isArray(s))continue
for(var d=0;d<s.length;d++){var m=e(t,n,s[d])
if(null!==m)return m.path.unshift({type:"index",name:o,index:d}),m}}else if("instance"===u.type){var p=e(t,n,r[o])
if(null!==p)return p.path.unshift({type:"property",name:o}),p}}return null}(e,t,e.model)}n(17),n(44),n(23),n(57)
function m(e){for(var t=[],n=e;n.length;){var r=/^([^\[\.]+)(?:\[(\d+)\])?\.?/.exec(n)
if(!r)throw new Error('Invalid path segment "'.concat(n,'" in path "').concat(e,'".'))
n=n.substr(r[0].length),3===r.length?t.push({index:parseInt(r[1]),name:r[2],type:"index"}):t.push({name:r[1],type:"property"})}return t}function p(e,t){if(!(t.name in e))return null
var n=e[t.name]
return"index"===t.type?!Array.isArray(n)||t.index<0||t.index>=n.length?null:n[t.index]:n}function h(e,t){"string"==typeof t&&(t=m(t))
for(var n=e,r=0;r<t.length;r++)if(!(n=p(n,t[r])))return n
return n}function v(e,t){var n=(t="string"==typeof t?m(t):t.slice()).pop()
if(!n)return null
var r=h(e.model,t)
if(!r)throw new Error("Could not resolve owner")
var a=l(e,r),i="index"===n.type?n.index:void 0,c=a.fields[n.name]
if(!c)throw new Error('Could not resolve field "'.concat(n.name,'" on schema "').concat(a.qualifier,'".'))
return{field:c,index:i,owner:r,path:t,schema:a}}function y(e,t){return Craft.t("contentfield",e,t)}n(80)
function g(e,t){var n
if("undefined"==typeof Symbol||null==e[Symbol.iterator]){if(Array.isArray(e)||(n=function(e,t){if(!e)return
if("string"==typeof e)return b(e,t)
var n=Object.prototype.toString.call(e).slice(8,-1)
"Object"===n&&e.constructor&&(n=e.constructor.name)
if("Map"===n||"Set"===n)return Array.from(e)
if("Arguments"===n||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n))return b(e,t)}(e))||t&&e&&"number"==typeof e.length){n&&(e=n)
var r=0,a=function(){}
return{s:a,n:function(){return r>=e.length?{done:!0}:{done:!1,value:e[r++]}},e:function(e){throw e},f:a}}throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}var i,c=!0,o=!1
return{s:function(){n=e[Symbol.iterator]()},n:function(){var e=n.next()
return c=e.done,e},e:function(e){o=!0,i=e},f:function(){try{c||null==n.return||n.return()}finally{if(o)throw i}}}}function b(e,t){(null==t||t>e.length)&&(t=e.length)
for(var n=0,r=new Array(t);n<t;n++)r[n]=e[n]
return r}function E(e){return{references:e,type:"addReferences"}}var w=n(2),k=n.n(w),S=n(6),O=n.n(S),C=new(function(){function e(){k()(this,e)}return O()(e,[{key:"initialize",value:function(e){this.definitions=e}},{key:"createValue",value:function(e){return this.getDefinition(e.field).createValue(e)}},{key:"getDefinition",value:function(e){return this.definitions["object"===s()(e)?e.type:e]}}]),e}())
n(81),n(48),n(86),n(110),n(195),n(202),n(204),n(205),n(206),n(207),n(208),n(209),n(210),n(211),n(212),n(213),n(214),n(216),n(217),n(218),n(219),n(220),n(221),n(222),n(223),n(224),n(225),n(226)
function j(){return"10000000-1000-4000-8000-100000000000".replace(/[018]/g,(function(e){return(e^crypto.getRandomValues(new Uint8Array(1))[0]&15>>e/4).toString(16)}))}function x(e){for(var t=e.schemas,n=e.schema,r=e.oldModel,a={__errors:{},__type:n.qualifier,__uuid:j(),__visible:!0},i=0,c=Object.keys(n.fields);i<c.length;i++){var o=c[i],l=n.fields[o],u=C.getDefinition(l),s=r&&o in r?r[o]:void 0
void 0!==s&&u.isValue(l,s)||(s=u.createValue({field:l,schemas:t})),a[o]=s}return a}function R(e,t,n){if(!t)return n(e)
var r,a=e[t.name]
if("index"===t.type){if(!Array.isArray(a))throw new Error("Invalid array access.")
if(t.index<0||t.index>=a.length)throw new Error("Invalid array index ".concat(t.index,'".'));(r=a.slice())[t.index]=n(a[t.index])}else{if(Array.isArray(a))throw new Error("Invalid array access.")
r=n(a)}var i=Object.assign({},e)
return i[t.name]=r,i}function N(e,t,n){var r="string"==typeof t?m(t):t.slice(),a=r.shift()
return R(e,a,(function e(t){return(a=r.shift())?t?R(t,a,e):t:n(t)}))}n(60)
var _=n(25),I=n.n(_),M=n(12),A=n.n(M)
n(87)
function D(e,t){return e.name===t.name&&e.type===t.type&&("index"!==e.type||"index"!==t.type||e.index===t.index)}function P(e){var t=e.sourcePath,n=e.sourceSegment,r=e.targetPath,a=e.targetSegment,i=[].concat(A()(r),[a])
if(i.length>t.length&&t.every((function(e,t){return D(e,i[t])}))){var c=i[t.length]
if("index"!=c.type)throw new Error("Path segment type mismatch")
if(c.name==n.name&&c.index>n.index){i[t.length]=Object.assign(Object.assign({},c),{index:c.index-1})
var o=i.pop()
if(!o||"index"!==o.type)throw new Error("Unsupported operation")
return Object.assign(Object.assign({},e),{targetPath:i,targetSegment:o})}}return e}function L(e,t){return e.length===t.length&&e.every((function(e,n){return D(e,t[n])}))}function T(e,t){var n=t.sourcePath,r=t.sourceSegment,a=t.targetPath,i=t.targetSegment,c=[].concat(A()(n),[r]),o=[].concat(A()(a),[i]),l=h(e.model,a)
if(!l)return!1
var u=e.schemas[l.__type].fields[i.name],s=l[i.name]
if("array"!==u.type||!Array.isArray(s))return!1
var f=P(t)
if(L(c,o)||L(c,[].concat(A()(f.targetPath),[f.targetSegment])))return!1
if(!(L(n,a)&&i.name===r.name)&&u.limit>0&&s.length>=u.limit)return!1
var d=u.member,m=C.getDefinition(d.type),p=h(e.model,c)
return m.isValue(d,p)}function U(e){return Object.assign(Object.assign({},e),{type:"moveModel"})}function F(e){return{overlay:e,type:"setOverlay"}}n(147)
function V(e,t){if(f(t)){var n=e.schemas[t.__type]
n&&(t.__errors=Object.keys(n.fields).reduce((function(e,r){var a=function(e,t,n){var r=e.fields[n].validatorId
if(!r)return null
var a=Wa.getValidator(r)
if(!a)return null
var i=[]
return a(n,t[n],i),i}(n,t,r)
return a&&a.length&&(e[r]=a),e}),{}))}}function W(e,t){return{direction:t,type:"uuidOrder",uuid:e}}function H(e){return{type:"uuidVisibility",uuid:e}}function B(e,t,n){return{path:e,key:t,type:"updateValue",value:n}}function q(e){return{sync:e,type:"updateSync"}}var z=n(11),X=n.n(z),K=(n(39),n(3))
function G(e){var t=e.source,n=Object(K.c)(e,["source"])
return Object(K.a)(this,void 0,void 0,X.a.mark((function e(){var r,a,i,c,o,l,u
return X.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:if(r=n.schemas[t.__type]){e.next=3
break}throw new Error("Invalid source schema.")
case 3:a={__errors:{},__originalUuid:t.__uuid,__type:r.qualifier,__uuid:j(),__visible:t.__visible},i=0,c=Object.keys(r.fields)
case 5:if(!(i<c.length)){e.next=15
break}return o=c[i],l=r.fields[o],u=C.getDefinition(l),e.next=11,u.cloneValue(Object.assign(Object.assign({},n),{field:l,value:t[o]}))
case 11:a[o]=e.sent
case 12:i++,e.next=5
break
case 15:return e.abrupt("return",a)
case 16:case"end":return e.stop()}}),e)})))}n(49),n(113)
function Y(e){var t=e.apiEndpoint,n=Object(K.c)(e,["apiEndpoint"]),r=Object.keys(n).map((function(e){return"".concat(e,"=").concat(encodeURIComponent(n[e]))})).join("&")
return new Promise((function(e,n){fetch("".concat(t,"&").concat(r)).then((function(e){return e.json()})).then((function(t){!function(e){return"object"===s()(e)&&"object"===s()(e.data)&&!0===e.result&&Array.isArray(e.references)}(t)?n(t&&t.message?"".concat(t.message):"An unknown error has occured."):e(t)})).catch((function(e){n("".concat(e))}))}))}function J(e){return f(e)?"[".concat(e.__type,", ").concat(e.__uuid,"]"):"[no model]"}var Q={group:console.groupCollapsed,groupEnd:console.groupEnd,info:console.info,model:J},Z={group:function(){},groupEnd:function(){},info:function(){},model:J}
function ee(e){return e&&e.verbose?Q:Z}n(151),n(237),n(238)
function te(e,t){var n
if("undefined"==typeof Symbol||null==e[Symbol.iterator]){if(Array.isArray(e)||(n=function(e,t){if(!e)return
if("string"==typeof e)return ne(e,t)
var n=Object.prototype.toString.call(e).slice(8,-1)
"Object"===n&&e.constructor&&(n=e.constructor.name)
if("Map"===n||"Set"===n)return Array.from(e)
if("Arguments"===n||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n))return ne(e,t)}(e))||t&&e&&"number"==typeof e.length){n&&(e=n)
var r=0,a=function(){}
return{s:a,n:function(){return r>=e.length?{done:!0}:{done:!1,value:e[r++]}},e:function(e){throw e},f:a}}throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}var i,c=!0,o=!1
return{s:function(){n=e[Symbol.iterator]()},n:function(){var e=n.next()
return c=e.done,e},e:function(e){o=!0,i=e},f:function(){try{c||null==n.return||n.return()}finally{if(o)throw i}}}}function ne(e,t){(null==t||t>e.length)&&(t=e.length)
for(var n=0,r=new Array(t);n<t;n++)r[n]=e[n]
return r}function re(e){if(!Array.isArray(e))return[]
var t,n=[],r=te(e)
try{for(r.s();!(t=r.n()).done;){var a=t.value
f(a)&&n.push(a)}}catch(e){r.e(e)}finally{r.f()}return n}function ae(e){var t=e.field,n=e.source,r=e.target,a=Object(K.c)(e,["field","source","target"])
return Object(K.a)(this,void 0,void 0,X.a.mark((function e(){var i,c,o,l,u,s,f,d,m,p
return X.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:if("instance"===t.member.type){e.next=2
break}return e.abrupt("return",n||[])
case 2:i=re(n),c=re(r),o=ee(a),l=[],u=te(i),e.prev=7,f=X.a.mark((function e(){var t,n,r,i
return X.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:if(t=s.value,n=c.findIndex((function(e){return r=t,a=null!==(n=e).__originalUuid,i=null!==r.__originalUuid,n.__uuid===r.__uuid||i&&n.__uuid===r.__originalUuid||a&&n.__originalUuid===r.__uuid||a&&i&&n.__originalUuid===r.__originalUuid
var n,r,a,i})),r=void 0,-1!==n){e.next=10
break}return o.info("No array match for ".concat(o.model(t))),e.next=7,G(Object.assign(Object.assign({},a),{source:t}))
case 7:r=e.sent,e.next=16
break
case 10:return i=c[n],o.info("Array match for ".concat(o.model(t)," is ").concat(o.model(i))),c.splice(n,1),e.next=15,ie(Object.assign(Object.assign({},a),{source:t,target:i}))
case 15:r=e.sent
case 16:r&&l.push(r)
case 17:case"end":return e.stop()}}),e)})),u.s()
case 10:if((s=u.n()).done){e.next=14
break}return e.delegateYield(f(),"t0",12)
case 12:e.next=10
break
case 14:e.next=19
break
case 16:e.prev=16,e.t1=e.catch(7),u.e(e.t1)
case 19:return e.prev=19,u.f(),e.finish(19)
case 22:if("remove"!==a.arrayOrphanMode){d=te(c)
try{for(d.s();!(m=d.n()).done;)p=m.value,"hide"===a.arrayOrphanMode?l.push(Object.assign(Object.assign({},p),{__visible:!1})):l.push(p)}catch(e){d.e(e)}finally{d.f()}}return e.abrupt("return",l)
case 24:case"end":return e.stop()}}),e,null,[[7,16,19,22]])})))}function ie(e){var t=e.source,n=e.target,r=Object(K.c)(e,["source","target"])
return Object(K.a)(this,void 0,void 0,X.a.mark((function e(){var a,i,c,o,l,u,s
return X.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:if(a=ee(r),f(t)){e.next=4
break}return a.info("No source, skipping ".concat(a.model(n))),e.abrupt("return",n)
case 4:if(f(n)&&n.__type===t.__type){e.next=7
break}return n?a.info("Type missmatch, cloning ".concat(a.model(t))):a.info("No target, cloning ".concat(a.model(t))),e.abrupt("return",G(Object.assign(Object.assign({},r),{source:t})))
case 7:if(i=r.schemas[t.__type]){e.next=10
break}throw new Error("Invalid schema")
case 10:c=Object.assign({},n),a.group("Syncing model ".concat(a.model(t)," > ").concat(a.model(n))),o=0,l=Object.keys(i.fields)
case 13:if(!(o<l.length)){e.next=33
break}if(u=l[o],"array"!==(s=i.fields[u]).type){e.next=24
break}return a.group("Array ".concat(u)),e.next=20,ae(Object.assign(Object.assign({},r),{field:s,source:t[u],target:n[u]}))
case 20:c[u]=e.sent,a.groupEnd(),e.next=30
break
case 24:if("instance"!==s.type){e.next=30
break}return a.group("Instance ".concat(u)),e.next=28,ie(Object.assign(Object.assign({},r),{source:t[u],target:n[u]}))
case 28:c[u]=e.sent,a.groupEnd()
case 30:o++,e.next=13
break
case 33:return a.groupEnd(),e.abrupt("return",c)
case 35:case"end":return e.stop()}}),e)})))}function ce(e,t,n){var r=e.siteId,a=Object(K.c)(e,["siteId"])
return Object(K.a)(this,void 0,void 0,X.a.mark((function e(){var i,c,o,l,u,s,d,m
return X.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:if(t(q({status:"working"})),i=n(),c=i.config,o=i.model,l=i.schemas,"number"==typeof c.elementId){e.next=4
break}throw new Error("Entry must be saved before it can be synchronized.")
case 4:return e.next=6,Y({apiEndpoint:c.apiEndpoints.fetchSite,elementId:c.elementId,fieldHandle:c.fieldHandle,siteId:r})
case 6:if(u=e.sent,s=u.data,d=u.references,f(s)&&c.rootSchemas.some((function(e){return e===s.__type}))){e.next=11
break}throw new Error("Selected target site does not contain a valid model.")
case 11:if(!(!f(o)||o.__type!==s.__type)){e.next=18
break}return e.next=15,G(Object.assign(Object.assign({},a),{schemas:l,source:s}))
case 15:e.t0=e.sent,e.next=21
break
case 18:return e.next=20,ie(Object.assign(Object.assign({},a),{schemas:l,source:s,target:o}))
case 20:e.t0=e.sent
case 21:m=e.t0,t(E(d)),t(B([],void 0,m)),t(q({status:"finished"}))
case 25:case"end":return e.stop()}}),e)})))}n(45)
var oe={addReferences:function(e,t){var n,r=e.config.references.slice(),a=document.createElement("div"),i=g(t.references)
try{var c=function(){var e=n.value
if(!r.some((function(t){var n=t.id,r=t.type
return e.id===n&&e.type===r}))){a.innerHTML=e.element
var t=a.firstElementChild
t&&(t.removeAttribute("style"),e.element=t.outerHTML),e.$element=$(e.element),e.hasThumb=e.$element.hasClass("hasthumb"),r.push(e)}}
for(i.s();!(n=i.n()).done;)c()}catch(e){i.e(e)}finally{i.f()}return Object.assign(Object.assign({},e),{config:Object.assign(Object.assign({},e.config),{references:r})})},changeType:function(e,t){var n=t.expandedState,r=t.newType,a=t.path,i=e.schemas[r]
if(!i)return e
var c=h(e.model,a),o=x({oldModel:c,schema:i,schemas:e.schemas})
return c&&n&&n.isExpanded(c.__uuid)&&(n.toggleExpanded(c.__uuid,!1),n.toggleExpanded(o.__uuid,!0)),Object.assign(Object.assign({},e),{model:N(e.model,a,(function(){return o}))})},moveModel:function(e,t){var n=e.model
if(!T(e,t))throw new Error("Invalid operation")
var r=P(t),a=r.sourcePath,i=r.sourceSegment,c=r.targetPath,o=r.targetSegment,l=h(n,[].concat(A()(a),[i]))
return n=N(n,a,(function(e){if(!e)throw new Error("Invalid operation")
var t=e[i.name]
if(!Array.isArray(t))throw new Error("Invalid operation")
return(t=t.slice()).splice(i.index,1),Object.assign(Object.assign({},e),I()({},i.name,t))})),n=N(n,c,(function(e){if(!e)throw new Error("Could not find target")
var t=e[o.name]
if(!Array.isArray(t))throw new Error("Unsupported operation")
return t=t.slice(),o.index>=t.length?t.push(l):t.splice(o.index,0,l),Object.assign(Object.assign({},e),I()({},o.name,t))})),Object.assign(Object.assign({},e),{model:n})},setOverlay:function(e,t){var n=t.overlay
return Object.assign(Object.assign({},e),{overlay:n})},setUser:function(e,t){var n=t.user,r=Object.assign(Object.assign({},e.user),n)
try{window.localStorage.setItem("tcfUserState",JSON.stringify(r))}catch(e){console.error(e)}return Object.assign(Object.assign({},e),{user:r})},uuidInsert:function(e,t){var n=t.position,r=t.uuid,a=t.value,i=d(e,r)
if(!i)return e
var c=v(e,i.path)
if(!c||"array"!==c.field.type||void 0===c.index)return e
var o=c.field,l=c.index,u=c.path,s=o.name
return Object.assign(Object.assign({},e),{model:N(e.model,u,(function(t){if(!t||!(s in t))return t
var r=t[s]
if(!Array.isArray(r))return t
var i=A()(r),c=l+("after"===n?1:0)
i.splice(c,0,a)
var o=Object.assign(Object.assign({},t),I()({},s,i))
return V(e,o),o}))})},uuidOrder:function(e,t){var n=t.direction,r=t.uuid,a=d(e,r)
if(!a)return e
var i=v(e,a.path)
if(!i||"array"!==i.field.type||void 0===i.index)return e
var c=i.field,o=i.index,l=i.path,u=c.name
return Object.assign(Object.assign({},e),{model:N(e.model,l,(function(t){if(!t||!(u in t))return t
var r=t[u]
if(!Array.isArray(r))return t
var a=o+("up"===n?-1:1),i=A()(r),c=i.splice(o,1)
i.splice.apply(i,[a,0].concat(A()(c)))
var l=Object.assign(Object.assign({},t),I()({},u,i))
return V(e,l),l}))})},uuidRemove:function(e,t){var n=t.uuid,r=d(e,n)
if(!r)return e
var a=v(e,r.path)
if(!a||"array"!==a.field.type||void 0===a.index)return e
var i=a.field,c=a.index,o=a.path,l=i.name
return Object.assign(Object.assign({},e),{model:N(e.model,o,(function(t){if(!t||!(l in t))return t
var n=t[l]
if(!Array.isArray(n))return t
var r=A()(n)
r.splice(c,1)
var a=Object.assign(Object.assign({},t),I()({},l,r))
return V(e,a),a}))})},uuidVisibility:function(e,t){var n=d(e,t.uuid)
return n?Object.assign(Object.assign({},e),{model:N(e.model,n.path,(function(e){return e?Object.assign(Object.assign({},e),{__visible:!e.__visible}):e}))}):e},updateSync:function(e,t){var n=t.sync,r=e.overlay
return r&&"synchronize"===r.type&&(r=Object.assign(Object.assign({},r),{preventClose:"working"===n.status})),Object.assign(Object.assign({},e),{overlay:r,sync:n})},updateValue:function(e,t){var n=t.path,r=t.key,a=t.value
return Object.assign(Object.assign({},e),{model:N(e.model,n,(function(t){var n=r?Object.assign(Object.assign({},t),I()({},r,a)):a
return V(e,n),n}))})}}
var le,ue=[function(e){var t=e.location.uuid,n=e.owner
return n&&"array"===n.field.type?{group:le.Manipulation,icon:"material:add",id:"create",invoke:function(e){var n=arguments.length>1&&void 0!==arguments[1]&&arguments[1]
e(F({afterCreate:n?"layer":"expand",type:"create",uuid:t}))},label:y("Create")}:null},function(e){var t=e.location.uuid
return{group:le.Manipulation,icon:"material:edit",id:"edit",invoke:function(e){e(F({type:"edit",uuid:t}))},label:y("Edit")}},function(e){var t=e.owner,n=e.location.uuid
return t&&"array"===t.field.type?{group:le.Manipulation,icon:"material:delete",id:"delete",invoke:function(e){e(function(e){return{type:"uuidRemove",uuid:e}}(n))},label:y("Delete")}:null},function(e){var t=e.location,n=t.uuid,r=t.model.__visible
return{group:le.Visibility,icon:r?"material:visibility_off":"material:visibility",id:"visibility",invoke:function(e){e(H(n))},label:y(r?"Hide":"Show")}},function(e){var t=e.location.uuid,n=e.owner
if(!n||"array"!==n.field.type)return null
var r=n.owner[n.field.name]
return!Array.isArray(r)||void 0===n.index||n.index<=0?null:{group:le.Movement,icon:"material:arrow_upward",id:"moveUp",invoke:function(e){return e(W(t,"up"))},label:y("Move up")}},function(e){var t=e.location.uuid,n=e.owner
if(!n||"array"!==n.field.type)return null
var r=n.owner[n.field.name]
return!Array.isArray(r)||void 0===n.index||n.index>=r.length-1?null:{group:le.Movement,icon:"material:arrow_downward",id:"moveDown",invoke:function(e){return e(W(t,"down"))},label:y("Move down")}},function(){return null},function(e){return e.owner,null},function(e){return e.owner,null}]
function se(e,t){var n=d(e,t)
if(!n)return[]
var r={location:n,owner:v(e,n.path),state:e}
return ue.map((function(e){return e(r)})).filter((function(e){return null!==e}))}function fe(e,t){var n=t.uuid,r=null
return{getCommands:function(){return se(e.getState(),n).map((function(t){return Object.assign(Object.assign({},t),{invoke:function(){return t.invoke(e.dispatch,!0)}})}))},subscribe:function(t){r&&r(),r=e.subscribe(t)},unsubscribe:function(){r&&r(),r=null}}}!function(e){e[e.Manipulation=0]="Manipulation",e[e.Visibility=1]="Visibility",e[e.Movement=2]="Movement",e[e.Clipboard=3]="Clipboard"}(le||(le={}))
n(89)
var de,me,pe=n(170),he=n.n(pe),ve=n(20),ye=n.n(ve)
!function(e){e[e.Idle=0]="Idle",e[e.Loading=1]="Loading",e[e.Loaded=2]="Loaded"}(de||(de={}))
var ge=null
de.Idle
function be(){return me}n(160)
function Ee(e){return e&&"object"===s()(e)&&"__uuid"in e}function we(e,t){if(Ee(e))return e
var n=function(e){switch(s()(e)){case"boolean":return new Boolean(e)
case"number":return new Number(e)
case"object":return e
default:return new String(e)}}(e)
return Object.defineProperty(n,"__uuid",{value:t&&Ee(t)?t.__uuid:j()}),n}function ke(e){return"string"==typeof e&&""!==e.trim()?ye.a.compile(e):null}function Se(e,t){var n,r=JSON.parse(e.innerHTML)
r.user=function(){try{var e=window.localStorage.getItem("tcfUserState")
if(null===e)throw new Error("User state missing")
var t=JSON.parse(e).favoriteSchemas
return{favoriteSchemas:(n=void 0===t?{}:t,Object.keys(n).reduce((function(e,t){return Array.isArray(n[t])?Object.assign(Object.assign({},e),I()({},t,n[t])):e}),{}))}}catch(e){}var n
return{favoriteSchemas:{}}}(),r.sync={status:"idle"},r.config.references=r.config.references.map((function(e){var t=he()(e.element)
return Object.assign(Object.assign({},e),{$element:t,hasThumb:t.hasClass("hasthumb")})}))
for(var a=0,i=Object.keys(r.schemas);a<i.length;a++){var c=i[a],o=r.schemas[c]
o.previewTemplate=ke(o.preview),o.previewLabelTemplate=ke(o.previewLabel)||o.previewTemplate}n=r.config.googleMapsApiKey,me=n
var l=void 0
1===r.config.rootSchemas.length&&(l=r.schemas[r.config.rootSchemas[0]])
try{r.model=function e(t,n,r){var a=n[t.__type].fields
r&&r.uniqueUuids&&(-1===r.uniqueUuids.indexOf(t.__uuid)?r.uniqueUuids.push(t.__uuid):(console.error('Found duplicate uuid "'.concat(t.__uuid,'".')),t.__uuid=j()))
for(var i=function(){var i=o[c],l=a[i]
"array"===l.type?t[i]=t[i].map((function(t){return"instance"===l.member.type?e(t,n,r):we(t)})):"instance"===l.type&&(t[i]=e(t[i],n,r))},c=0,o=Object.keys(a);c<o.length;c++)i()
return t}(JSON.parse(t.value),r.schemas,{uniqueUuids:[]})}catch(e){}return!l||f(r.model)&&r.model.__type===l.qualifier||(r.model=x({oldModel:r.model,schema:l,schemas:r.schemas})),r}var Oe=n(172),Ce=n(317),je=n(7),xe=n.n(je)
n(262)
function Re(e){var t=e.children,n=e.className,a=e.outline,i=e.secondary,c=Object(K.c)(e,["children","className","outline","secondary"])
return r.createElement("div",Object.assign({},c,{className:xe()("tcfButtonFlat",n,{outline:a,secondary:i})}),t)}var Ne=n(22),_e=n.n(Ne),Ie=r.createContext({expanded:[],isExpanded:function(){return!1},toggleExpanded:function(){}})
function Me(e){var t=e.children,n=r.useState([]),a=_e()(n,2),i=a[0],c=a[1]
return r.createElement(Ie.Provider,{value:{expanded:i,isExpanded:function(e){return-1!==i.indexOf(e)},toggleExpanded:function(e,t){var n=A()(i)
void 0===t&&(t=-1===i.indexOf(e)),t?n.push(e):n=n.filter((function(t){return t!==e})),c(n)}}},t)}n(266)
function Ae(e){var t=e.children,n=e.disabled,a=e.onClick,i=e.primary,c=e.secondary
return r.createElement("div",{className:xe()("tcfButton btn",{disabled:n,submit:i,secondary:c}),onClick:function(e){e.preventDefault(),n||a(e)}},t)}function De(e){var t=e.className,n=e.params,a=e.value
return r.createElement("span",{className:t},y(a,n))}function Pe(e){var t=e.children,n=e.className
return r.createElement("div",{className:xe()("tcfWindow--content",n)},t)}function Le(e){var t=e.children,n=e.className,a=e.flex,i=void 0===a||a
return r.createElement("div",{className:xe()("tcfWindow--footer",n,{flex:i})},t)}var Te
n(267)
function Ue(e){var t=e.children,n=e.className,a=e.width
return r.createElement("div",{className:xe()("tcfWindow",n),style:{width:a}},t)}(Te=Ue||(Ue={})).Content=Pe,Te.Footer=Le
var Fe=Ue
function Ve(e){var t=e.onClose
return r.createElement(Fe,{width:600},r.createElement(Fe.Content,null,r.createElement(De,{value:"Cannot create an element at the given location."})),r.createElement(Fe.Footer,null,r.createElement(Ae,{onClick:t,secondary:!0},r.createElement(De,{value:"Cancel"}))))}n(268)
function We(e){var t=e.children,n=e.isBorderless,a=e.label,i=e.style
return a&&""!==a&&"toolbar"!==a?r.createElement("div",{className:"tcfFieldGroup",style:i},r.createElement("div",{className:"tcfFieldGroup--label"},a),r.createElement("div",{className:"tcfFieldGroup--content"},t)):r.createElement("div",{className:xe()("tcfFieldGroup--content",{isBorderless:n}),style:i},t)}n(269)
function He(e){var t=e.children,n=e.className,a=e.errors,i=e.instructions,c=e.isPlainField,o=e.isRequired,l=e.label,u=e.style
if(c)return r.createElement(r.Fragment,null,t)
var s=a&&a.length
return r.createElement("div",{className:xe()("tcfFieldPanel",n),style:u},r.createElement("div",{className:xe()("tcfFieldPanel--label",{hasErrors:s,isRequired:o})},l),i?r.createElement("div",{className:"tcfFieldPanel--instructions"},i):null,a&&a.length?r.createElement("ul",{className:"tcfFieldPanel--errors"},a.map((function(e,t){return r.createElement("li",{className:"tcfFieldPanel--error",key:t},e)}))):null,t)}n(270),n(272)
function Be(e,t){return e.label.localeCompare(t.label)}function qe(e){var t=e.allowUndecided,n=e.disabled,a=void 0!==n&&n,i=e.options,c=e.value,o=e.onChange,l=i.findIndex((function(e){return e.key==c})),u=t||-1===l
return r.createElement("div",{className:"tcfSelect"},r.createElement("select",{className:"tcfSelect--select",disabled:a,value:-1==l?void 0:l,onChange:a?void 0:function(e){var n=e.target.selectedIndex,r=null
u&&(n-=1),n>=0&&n<i.length&&(r=i[n].key),(null!==r||t)&&o(r)}},u?r.createElement("option",null,"(None)"):null,i.map((function(e,t){return r.createElement("option",{key:t,value:t},e.indent?"--".repeat(e.indent)+" ":null,e.label)}))))}var ze=[{key:"before",label:"Before selected element"},{key:"after",label:"After selected element"}]
function $e(e){var t=e.Factory,n=e.field,a=e.onCreate,i=e.scope,c=r.useState("before"),o=_e()(c,2),l=o[0],u=o[1]
return r.createElement(Fe,{width:600},r.createElement(Fe.Content,null,r.createElement(We,null,r.createElement(He,{instructions:y("Select where the new element should be inserted."),label:y("Position")},r.createElement(qe,{onChange:u,options:ze.map((function(e){return Object.assign(Object.assign({},e),{label:y(e.label)})})),value:l})))),r.createElement(Fe.Footer,{flex:!1},r.createElement(t,{field:n,onCreate:function(e){return a(e,l)},scope:i})))}function Xe(e){var t=e.afterCreate,n=void 0===t?"expand":t,a=e.uuid,i=Object(o.c)(),c=r.useContext(Ie),l=Object(o.d)((function(e){var t=d(e,a)
if(!t||!t.path.length)return null
var n=v(e,t.path)
return n&&"array"===n.field.type&&void 0!==n.index?{field:n.field,model:n.owner}:null}))
if(null===l)return r.createElement(Ve,{onClose:function(){i(F(null))}})
var u=l.field,s=l.model,m=C.getDefinition(u.member.type).factory
return r.createElement($e,{Factory:m,field:u.member,onCreate:function(e,t){var r=null
f(e)&&("expand"===n?c.toggleExpanded(e.__uuid,!0):r={type:"edit",uuid:e.__uuid}),i(function(e,t,n){return{position:n,type:"uuidInsert",uuid:e,value:t}}(a,e,t)),i(F(r))},scope:s.__type})}var Ke=n(4),Ge=n.n(Ke),Ye=n(5),Je=n.n(Ye),Qe=n(1),Ze=n.n(Qe)
function et(e){var t=e.field,n=C.getDefinition(t).widget
return r.createElement(n,e)}n(161)
function tt(e,t){if(t)switch(e){case 0:return t.small
case 2:return t.large
default:return t.medium}}var nt=r.createContext(2)
function rt(e){var t=e.children,n=Object(K.c)(e,["children"]),a=r.useState(2),i=_e()(a,2),c=i[0],o=i[1],l=r.useRef(null)
return r.useEffect((function(){var e=window.ResizeObserver,t=l.current,n=-1,r=0
if(t){var a=function(){var e=t.offsetWidth
e!==r&&o((r=e)>920?2:r>580?1:0)}
if(e){var i=new e(a)
return i.observe(t),function(){return i.unobserve(t)}}return function e(){n=window.requestAnimationFrame(e),a()}(),function(){return window.cancelAnimationFrame(n)}}}),[]),r.createElement("div",Object.assign({ref:l},n),r.createElement(nt.Provider,{value:c},t))}n(273)
function at(e,t){return e.index-t.index}var it=Object(o.b)((function(e,t){return{schema:e.schemas[t.model.__type]}}),(function(e,t){return{onUpdate:function(n,r){e(B(t.path,n,r))}}}))((function(e){var t=e.disabled,n=void 0!==t&&t,a=e.isBorderless,i=e.model,c=e.onUpdate,o=e.path,l=e.schema,u=r.useContext(nt)
if(!l)return r.createElement("div",null,'Could not resolve schema for "'.concat(i.__type,'"'))
var s=[],f=Object.keys(l.fields),d=void 0
if(0===f.length)return r.createElement("div",{className:"tcfInstanceForm--empty"},r.createElement(De,{value:"This element has no properties."}))
for(var m=function(){var e=h[p],t=l.fields[e],f=i.__errors[e]||null,m=C.getDefinition(t).isAlwaysPlainField
if(!d||t.group){var v=t.group?t.group.label:void 0,y=t.group?tt(u,t.group.style):void 0
d={index:"toolbar"===v?-1:s.length,label:v,fields:[],style:y},s.push(d)}d.fields.push(r.createElement(He,{errors:f,instructions:t.instructions,isPlainField:a||m,isRequired:t.isRequired,key:t.name,label:t.label,style:tt(u,t.style)},r.createElement(et,{data:i[t.name],disabled:n,errors:f,field:t,model:i,onUpdate:function(t){return c(e,t)},path:o})))},p=0,h=f;p<h.length;p++)m()
var v=s.sort(at).map((function(e){return r.createElement(We,{isBorderless:a,key:e.index,label:e.label,style:e.style},e.fields)})),y=tt(u,l.style)
return y?r.createElement("div",{className:"tcfInstanceForm",style:y},v):r.createElement(r.Fragment,null,v)}))
function ct(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1
if(Reflect.construct.sham)return!1
if("function"==typeof Proxy)return!0
try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}()
return function(){var n,r=Ze()(e)
if(t){var a=Ze()(this).constructor
n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments)
return Je()(this,n)}}var ot=function(e){Ge()(n,e)
var t=ct(n)
function n(e){var r
return k()(this,n),(r=t.call(this,e)).originalModel=null,r.handleCancel=function(){r.close()},r.handleApply=function(){r.close()},r.originalModel=e.model,r}return O()(n,[{key:"close",value:function(){this.props.setOverlay(null)}},{key:"render",value:function(){var e=this.props,t=e.model,n=e.path
return r.createElement(Me,null,r.createElement(Fe,null,r.createElement(Fe.Content,null,r.createElement(it,{model:t,path:n})),r.createElement(Fe.Footer,null,r.createElement(Ae,{onClick:this.handleApply},r.createElement(De,{value:"Apply"})))))}}]),n}(r.Component),lt=Object(o.b)((function(e,t){return d(e,t.uuid)}),(function(e){return{setOverlay:function(t){return e(F(t))}}}))(ot)
n(274),n(277)
function ut(e){var t=e.className,n=e.name,a=e.size,i="craft"
return n.startsWith("material:")?(i="material",n=n.substr("material:".length)):n.startsWith("craft:")&&(n=n.substr("craft:".length)),r.createElement("div",{className:xe()("tcfIcon",t,i,a)},n)}function st(e){var t=e.message,n=e.onClose
return r.createElement(r.Fragment,null,r.createElement(Fe.Content,null,r.createElement("div",{className:"tcfSynchronize--message"},r.createElement(ut,{className:"tcfSynchronize--messageIcon error",name:"material:error",size:"huge"}),r.createElement("div",{className:"tcfSynchronize--title"},"An error has occured"),t?r.createElement("div",{className:"tcfSynchronize--message"},t):null)),r.createElement(Fe.Footer,null,r.createElement(Ae,{onClick:n},"Close")))}function ft(e){var t=e.onClose
return r.createElement(r.Fragment,null,r.createElement(Fe.Content,null,r.createElement("div",{className:"tcfSynchronize--message"},r.createElement(ut,{className:"tcfSynchronize--messageIcon finished",name:"material:check_circle",size:"huge"}),r.createElement("div",{className:"tcfSynchronize--title"},r.createElement(De,{value:"Sites have been synchronized"})),r.createElement("div",{className:"tcfSynchronize--message"},r.createElement(De,{value:"If you are not happy with the results, do not save the entry. Reload this page to revert all changes."})))),r.createElement(Fe.Footer,null,r.createElement(Ae,{onClick:t},r.createElement(De,{value:"Close"}))))}n(50)
var dt=n(26),mt=n.n(dt)
function pt(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1
if(Reflect.construct.sham)return!1
if("function"==typeof Proxy)return!0
try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}()
return function(){var n,r=Ze()(e)
if(t){var a=Ze()(this).constructor
n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments)
return Je()(this,n)}}var ht=function(e){Ge()(n,e)
var t=pt(n)
function n(){var e
return k()(this,n),(e=t.apply(this,arguments)).element=null,e.lightswitch=null,e.handleChange=function(){var t=e.props,n=t.disabled,r=t.onChange,a=mt()(e).lightswitch
!n&&a&&r(a.on)},e.setElement=function(t){e.element!==t&&(e.element=t,e.updateInstance())},e}return O()(n,[{key:"componentDidUpdate",value:function(e){var t=this.props.value,n=this.lightswitch
e.disabled!==this.props.disabled?this.updateInstance():n&&n.on!==t&&n.toggle()}},{key:"render",value:function(){var e=this.props,t=e.className,n=e.disabled,a=e.small,i=e.value
return r.createElement("div",null,r.createElement("div",{className:xe()("lightswitch",t,{disabled:n,on:i,small:a}),ref:this.setElement,tabIndex:0},r.createElement("div",{className:"lightswitch-container"},r.createElement("div",{className:"label on"}),r.createElement("div",{className:"handle"}),r.createElement("div",{className:"label off"}))))}},{key:"updateInstance",value:function(){var e=this.element,t=this.handleChange,n=this.lightswitch,r=this.props,a=r.disabled,i=r.value
n&&(n.destroy(),this.lightswitch=null),!a&&e&&(this.lightswitch=new Craft.LightSwitch(e,{onChange:t,value:i}))}}]),n}(r.Component)
function vt(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1
if(Reflect.construct.sham)return!1
if("function"==typeof Proxy)return!0
try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}()
return function(){var n,r=Ze()(e)
if(t){var a=Ze()(this).constructor
n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments)
return Je()(this,n)}}var yt=function(e){Ge()(n,e)
var t=vt(n)
function n(e){var r
return k()(this,n),(r=t.call(this,e)).handleApply=function(e){var t,n=r.props,a=n.currentSite,i=n.endpoint,c=r.state,o=c.arrayOrphanMode,l=c.site,u=c.useTranslator
l&&(u&&a&&l.language!==a.language&&(t={endpoint:i,source:l.language,target:a.language}),r.props.onSynchronize({arrayOrphanMode:o,siteId:l.id,translate:t,verbose:"altKey"in e&&e.altKey}))},r.handleArrayOrphanModeChange=function(e){r.setState({arrayOrphanMode:e})},r.handleSiteChange=function(e){r.setState({site:e})},r.handleToggleTranslator=function(e){r.setState({useTranslator:e})},r.state={arrayOrphanMode:"hide",site:e.availableSites[0]||null,useTranslator:!1},r}return O()(n,[{key:"render",value:function(){var e=this.props,t=e.availableSites,n=e.currentSite,a=e.hasTranslator,i=e.onClose,c=this.state,o=c.arrayOrphanMode,l=c.site,u=c.useTranslator,s=t.map((function(e){return{label:e.label,key:e}}))
return r.createElement(r.Fragment,null,r.createElement(Fe.Content,null,r.createElement("div",{className:"tcfSynchronize--title"},r.createElement(De,{value:"Synchronize translations"})),r.createElement(We,null,r.createElement(He,{instructions:y("Select the site the content should be copied from."),label:y("Site")},r.createElement(qe,{onChange:this.handleSiteChange,options:s,value:l})),r.createElement(He,{instructions:y("Defines what happens to elements that do not exist in the selected language."),label:y("Orphaned elements")},r.createElement(qe,{onChange:this.handleArrayOrphanModeChange,options:[{key:"hide",label:y("Hide orphaned elements")},{key:"none",label:y("Do nothing")},{key:"remove",label:y("Remove orphaned elements")}],value:o})),l&&n&&l.language!==n.language?r.createElement(He,{instructions:y(a?"Uses a webservice to automatically translate texts.":"A matching webservice must be configured in the options of this field in order to use this feature."),label:y("Translate texts automatically")},r.createElement(ht,{disabled:!a,onChange:this.handleToggleTranslator,value:u})):null)),r.createElement(Fe.Footer,null,r.createElement(Ae,{onClick:i,secondary:!0},r.createElement(De,{value:"Cancel"})),r.createElement(Ae,{onClick:this.handleApply,primary:!0},r.createElement(De,{value:"Apply"}))))}}]),n}(r.Component),gt=Object(o.b)((function(e){var t=e.config,n=t.apiEndpoints,r=t.elementSiteId,a=t.hasTranslator,i=t.supportedSites
return{availableSites:i.filter((function(e){return e.id!==r})),currentSite:i.find((function(e){return e.id===r})),endpoint:n.translate,hasTranslator:a}}),(function(e){return{onSynchronize:function(t){return e(function(e){var t=this
return function(n,r){return Object(K.a)(t,void 0,void 0,X.a.mark((function t(){return X.a.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return t.prev=0,t.next=3,ce(e,n,r)
case 3:t.next=8
break
case 5:t.prev=5,t.t0=t.catch(0),n(q({status:"error",message:"".concat(t.t0)}))
case 8:case"end":return t.stop()}}),t,null,[[0,5]])})))}}(t))}}}))(yt)
n(278)
function bt(){return r.createElement("div",{className:"tcfActivityIndicator"},r.createElement("div",{className:"tcfActivityIndicator--bounce first"}),r.createElement("div",{className:"tcfActivityIndicator--bounce second"}),r.createElement("div",{className:"tcfActivityIndicator--bounce third"}))}function Et(){return r.createElement(Fe.Content,null,r.createElement("div",{className:"tcfSynchronize--working"},r.createElement(bt,null)))}n(279)
function wt(){var e,t=Object(o.d)((function(e){return e.sync})),n=Object(o.c)(),a=function(){return n(F(null))}
return e="working"===t.status?r.createElement(Et,null):"error"===t.status?r.createElement(st,{message:t.message,onClose:a}):"finished"===t.status?r.createElement(ft,{onClose:a}):r.createElement(gt,{onClose:a}),r.createElement(Fe,{width:600},e)}var kt=r.createContext(0)
function St(e){var t=e.children,n=r.useContext(kt)
return r.createElement(kt.Provider,{value:n+1},t)}function Ot(e){var t=e.disabled,n=e.dispatch,a=e.model,i=e.path,c=e.schemas,o=r.useContext(Ie),l=c.map((function(e){return{key:e.qualifier,label:e.label}}))
return l.sort(Be),r.createElement(He,{className:"tcfInstance--controlsSchema",label:"Type"},r.createElement(qe,{disabled:t,onChange:function(e){return n(function(e,t,n){return{expandedState:n,newType:t,path:e,type:"changeType"}}(i,e,o))},options:l,value:a?a.__type:null}))}function Ct(e){var t=e.disabled,n=e.dispatch,a=e.model,i=a.__visible?"material:visibility":"material:visibility_off",c=r.createElement(r.Fragment,null,r.createElement(De,{value:"Visibility"}),r.createElement(ut,{className:xe()("tcfInstance--controlsVisibilityIcon",{off:!a.__visible}),name:i}))
return r.createElement(He,{label:c,className:"tcfInstance--controlsVisibility"},r.createElement(Ae,{disabled:t,onClick:function(){return n(H(a.__uuid))}},r.createElement(De,{value:a.__visible?"Hide":"Show"})))}n(280)
var jt=r.memo((function(e){var t=e.canChangeVisibility,n=void 0!==t&&t,a=e.canChangeType,i=void 0===a||a,c=e.disabled,l=void 0!==c&&c,u=e.isBorderless,s=e.model,d=e.path,m=e.schemaNames,p=Object(o.c)(),h=Object(o.d)((function(e){return m.map((function(t){return e.schemas[t]}))})),v=!1
f(s)&&(v=h.some((function(e){return e.qualifier===s.__type})))
var y=i&&h.length>1,g=n&&v&&!s.__visible
return r.createElement(St,null,r.createElement(rt,null,y||g?r.createElement("div",{className:"tcfInstance--controls"},y?r.createElement(Ot,{disabled:l,dispatch:p,model:v?s:null,path:d,schemas:h}):null,g?r.createElement(Ct,{disabled:l,dispatch:p,model:s}):null):null,v?r.createElement(it,{disabled:l,model:s,isBorderless:u,path:d}):null))}))
n(281)
function xt(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1
if(Reflect.construct.sham)return!1
if("function"==typeof Proxy)return!0
try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}()
return function(){var n,r=Ze()(e)
if(t){var a=Ze()(this).constructor
n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments)
return Je()(this,n)}}var Rt=function(e){Ge()(n,e)
var t=xt(n)
function n(e){var r
k()(this,n),(r=t.call(this,e)).element=null,r.handleMouseDown=function(e){var t=r.props.onClick
e.target===r.element&&t&&t()}
var a=document.createElement("div")
return a.className="tcfOverlay",a.addEventListener("mousedown",r.handleMouseDown),document.body.appendChild(a),r.element=a,r}return O()(n,[{key:"componentWillUnmount",value:function(){var e=this.element
e&&(document.body.removeChild(e),e.removeEventListener("mousedown",this.handleMouseDown),this.element=null)}},{key:"render",value:function(){var e=this.props.children,t=this.element
return t?Object(a.createPortal)(e,t):null}}]),n}(r.Component)
n(282)
function Nt(){var e=Object(o.c)(),t=Object(o.d)((function(e){return e.model})),n=Object(o.d)((function(e){return e.overlay})),a=Object(o.d)((function(e){return e.config})),i=a.disabled,c=a.rootSchemas,l=a.supportedSites.length>1
return r.createElement(Ce.a,{backend:Oe.a},r.createElement(Me,null,l&&!i?r.createElement("div",{className:"tcfRoot--options"},r.createElement(Re,{onClick:function(){e(q({status:"idle"})),e(F({type:"synchronize"}))},outline:!0},r.createElement(ut,{name:"material:sync"}),r.createElement(De,{value:"Synchronize translations"}))):null,r.createElement(jt,{disabled:i,model:t,path:[],schemaNames:c}),n?r.createElement(Rt,{onClick:function(){n&&!n.preventClose&&e(F(null))}},function(e){if(!e)return null
switch(e.type){case"create":return r.createElement(Xe,Object.assign({},e))
case"edit":return r.createElement(lt,Object.assign({},e))
case"synchronize":return r.createElement(wt,null)}}(n)):null))}var _t=function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:{config:{apiEndpoints:{fetchSite:"",oembed:"",translate:""},disabled:!1,elementId:null,elementSiteId:0,fieldHandle:"",hasTranslator:!1,references:[],rootSchemas:[],supportedSites:[]},model:{__errors:{},__type:"unknown",__uuid:"0",__visible:!0},overlay:null,schemas:{},sync:{status:"idle"},user:{favoriteSchemas:{}}},t=arguments.length>1?arguments[1]:void 0
return t.type in oe?oe[t.type](e,t):e},It=n(90),Mt=n.n(It)
function At(e){for(;"string"!=typeof e;)e=e.toHTML()
return e}var Dt={},Pt={},Lt=function(e,t){Dt[String(t)]=!0},Tt=function(e,t){Pt[String(t)]=!0}
function Ut(){return{allowedProtoMethods:Dt,allowedProtoProperties:Pt}}function Ft(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1
if(Reflect.construct.sham)return!1
if("function"==typeof Proxy)return!0
try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}()
return function(){var n,r=Ze()(e)
if(t){var a=Ze()(this).constructor
n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments)
return Je()(this,n)}}var Vt=function(e){Ge()(n,e)
var t=Ft(n)
function n(e){return k()(this,n),t.call.apply(t,[this].concat(A()(function(e){var t=e.context,n=e.field,r=e.value
if(!n)return[]
var a=n.member,i=C.getDefinition(a)
return r.map((function(e){return i.preview({value:e,field:a,context:t})}))}(e))))}return O()(n,[{key:"toHTML",value:function(){return new ve.SafeString(this.toString())}},{key:"toList",value:function(e){return new ve.SafeString('<ul class="'.concat(e,'">').concat(this.map((function(e){return"<li>".concat(At(e),"</li>")})).join(""),"</ul>"))}},{key:"toString",value:function(){return this.map((function(e){return At(e)})).join("")}},{key:"asColumn",get:function(){return this.toList("flexColumn")}},{key:"asList",get:function(){return this.toList("")}},{key:"asRow",get:function(){return this.toList("flexRow")}},{key:"first",get:function(){return new ve.SafeString(this.length?At(this[0]):"")}},{key:"one",get:function(){return this.first}}]),n}(Mt()(Array))
Object(K.b)([Tt],Vt.prototype,"asColumn",null),Object(K.b)([Tt],Vt.prototype,"asList",null),Object(K.b)([Tt],Vt.prototype,"asRow",null),Object(K.b)([Tt],Vt.prototype,"first",null),Object(K.b)([Tt],Vt.prototype,"one",null),Object(K.b)([Lt],Vt.prototype,"toHTML",null),Object(K.b)([Lt],Vt.prototype,"toList",null),Object(K.b)([Lt],Vt.prototype,"toString",null)
var Wt=n(318)
function Ht(e,t){var n={data:e.child,height:100,path:e.path,type:"MEMBER"}
return Object(Wt.a)({item:n,begin:function(){return{data:e.child,height:t.current?t.current.clientHeight:100,path:e.path,type:"MEMBER"}},canDrag:function(){return!e.disabled},collect:function(e){return{isDragging:e.isDragging()}},isDragging:function(t){return L(e.path,t.getItem().path)}})}var Bt=n(319)
function qt(e,t){var n=Object(o.e)()
return Object(Bt.a)({accept:"MEMBER",drop:function(e){return{item:e}},hover:function(r,a){if(a.isOver({shallow:!0})){var i=function(e,t,n){var r=n.current,a=t.getClientOffset()
if(!r||!a||!e)return null
var i=r.getBoundingClientRect(),c=i.bottom,o=i.top,l=a.y-o
return r.classList.contains("isExpanded")&&l>32&&l<c-o-32?null:(l>(c-o)/2&&(e.targetSegment=Object.assign(Object.assign({},e.targetSegment),{index:e.targetSegment.index+1})),e)}(function(e,t){var n=e.path.slice(),r=n.pop()
if(!r||"index"!==r.type)return null
var a=t.path.slice(),i=a.pop()
return i&&"index"===i.type?{sourcePath:a,sourceSegment:i,targetPath:n,targetSegment:r}:null}(e,r),a,t)
if(i&&T(n.getState(),i)){var c=U(i),o=P(c),l=o.targetPath,u=o.targetSegment
r.path=[].concat(A()(l),[u]),n.dispatch(c)}}}})}n(287)
function zt(e){var t=e.child,n=e.depth,a=e.disabled,i=e.field,c=e.index,o=e.model,l=e.onDelete,u=e.onUpdate,s=e.path,f=r.useRef(null),d=Ht(e,f),m=_e()(d,3),p=m[0].isDragging,h=m[1],v=m[2],y=qt(e,f);(0,_e()(y,2)[1])(f)
return r.createElement("div",{className:xe()("tcfArrayWidgetMember depth-".concat(n),{isDragging:p}),ref:f},v(r.createElement("div",{className:"tcfArrayWidgetMember--panel tcfArrayWidgetMember--single"},h(r.createElement("div",{className:xe()("tcfArrayWidgetMember--singleHandle",{enabled:!a})},r.createElement(ut,{className:"tcfArrayWidgetMember--singleHandleIcon",key:"handle",name:"move"}))),r.createElement("div",{className:"tcfArrayWidgetMember--singleBody"},r.createElement(et,{data:t,disabled:a,errors:[],field:i,model:o,onUpdate:function(e){u(c,e)},path:s})),a?null:r.createElement("div",{className:"tcfArrayWidgetMember--singleActions"},r.createElement("div",{className:"tcfArrayWidgetMember--singleActionsButton",onClick:function(){l(c)}},r.createElement(ut,{name:"remove"}))))))}function $t(e){var t=r.useRef(null),n=function(e){var t=Object(o.e)()
return Object(Bt.a)({accept:"MEMBER",drop:function(e){return{item:e}},hover:function(n,r){if(r.isOver({shallow:!0})){var a=function(e,t){var n=t.path.slice(),r=n.pop()
return r&&"index"===r.type?{sourcePath:n,sourceSegment:r,targetPath:e.path,targetSegment:{type:"index",index:0,name:e.field.name}}:null}(e,n)
if(a&&T(t.getState(),a)){var i=U(a),c=P(i),o=c.targetPath,l=c.targetSegment
n.path=[].concat(A()(o),[l]),t.dispatch(i)}}}})}(e)
return(0,_e()(n,2)[1])(t),r.createElement("div",{className:"tcfArrayWidgetList--empty",key:"empty",ref:t},r.createElement(De,{value:"Drop elements here"}))}n(288)
function Xt(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1
if(Reflect.construct.sham)return!1
if("function"==typeof Proxy)return!0
try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}()
return function(){var n,r=Ze()(e)
if(t){var a=Ze()(this).constructor
n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments)
return Je()(this,n)}}var Kt=function(e){Ge()(n,e)
var t=Xt(n)
function n(e){var r
return k()(this,n),(r=t.call(this,e)).element=null,r.handleAnimationEnd=function(){var e=mt()(r).element
e&&(e.style.height="",e.style.transition=""),r.setState({inTransition:!1,lastChildren:null,lastUri:null})},r.setElement=function(e){r.element=e},r.state={currentChildren:e.children,currentUri:e.uri,inTransition:!1,lastChildren:null,lastUri:null},r}return O()(n,[{key:"componentDidUpdate",value:function(e,t,n){var r=this.element
r&&n&&setTimeout((function(){r.style.height=""
var e=r.offsetHeight
r.style.height="".concat(n.height,"px"),r.getBoundingClientRect(),r.style.transition="height 200ms",r.style.height="".concat(e,"px")}),0)}},{key:"getSnapshotBeforeUpdate",value:function(e,t){var n=this.element
if(t.currentUri!==this.state.currentUri&&n){var r=n.offsetHeight
return n.style.height="".concat(r,"px"),{height:r}}return null}},{key:"render",value:function(){var e=this.props,t=e.className,n=e.itemClassName,a=this.state,i=a.currentChildren,c=a.currentUri,o=a.inTransition,l=a.lastChildren,u=a.lastUri,s=[]
return o&&u&&s.push(r.createElement("div",{className:xe()(n,"tcfDetailsPanel--item","from"),key:u},l)),s.push(r.createElement("div",{className:xe()(n,"tcfDetailsPanel--item",{to:o}),key:c,onAnimationEnd:this.handleAnimationEnd},i)),r.createElement("div",{className:xe()(t,"tcfDetailsPanel"),ref:this.setElement},s)}}],[{key:"getDerivedStateFromProps",value:function(e,t){return e.uri===t.currentUri?Object.assign(Object.assign({},t),{currentChildren:e.children}):e.uri===t.currentUri||t.inTransition?null:{inTransition:!0,lastChildren:t.currentChildren,lastUri:t.currentUri,currentChildren:e.children,currentUri:e.uri}}}]),n}(r.Component)
n(165)
function Gt(e){var t=e.children,n=e.onClick,a=e.primary
return r.createElement("div",{className:xe()("tcfArrayWidgetMember--headerActionsButton",{primary:a}),onClick:function(e){e.preventDefault(),n()}},t)}var Yt=null
function Jt(){return null===Yt&&(Yt=new Craft.ElementThumbLoader),Yt}n(289)
function Qt(e){var t=e.className,n=e.model,a=e.schema,i=e.size,c=void 0===i?"small":i,l=r.useRef(null),u=Object(o.d)((function(e){return e.config.references})),s=function(e,t){var n=t.previewImage
if(!n)return null
var r=n in e?e[n]:null
if(!Array.isArray(r)||0===r.length)return null
var a=r[0]
return"number"==typeof a?a:null}(n,a),f=u.find((function(e){return e.id===s}))
return r.useEffect((function(){if(l.current){var e=$(".element",l.current)
Craft.setElementSize(e,c),Jt().load(e)}}),[l.current,f]),f&&f.hasThumb?r.createElement("div",{className:xe()("tcfInstancePreviewImage",t,c),dangerouslySetInnerHTML:{__html:f.element},ref:l}):r.createElement("div",{className:xe()("tcfInstancePreviewImage empty",t,c)})}var Zt=r.memo((function(e){var t=e.field,n=e.model,a=e.references,i=e.schemas,c=Object(K.c)(e,["field","model","references","schemas"]),o=At(C.getDefinition("instance").preview({context:{depth:0,references:a,schemas:i},field:t,mode:"label",value:n})).replace(/<[^>]*>?/gm,"").replace(/[\n\t\r]+/g,"").trim().substr(0,256)
return r.createElement("div",Object.assign({},c),o)}),(function(e,t){return e.model===t.model}))
function en(e){var t=Object(o.d)((function(e){return[e.config.references,e.schemas]})),n=_e()(t,2),a=n[0],i=n[1]
return r.createElement(Zt,Object.assign({},e,{references:a,schemas:i}))}function tn(e){var t=e.command,n=e.onClick
return r.createElement("div",{className:"tcfArrayWidgetMember--headerMoreItem",onMouseUp:n},r.createElement(ut,{className:"tcfArrayWidgetMember--headerMoreItemIcon",name:t.icon}),r.createElement("span",{className:"tcfArrayWidgetMember--headerMoreItemLabel"},t.label))}function nn(e,t){var n
if("undefined"==typeof Symbol||null==e[Symbol.iterator]){if(Array.isArray(e)||(n=function(e,t){if(!e)return
if("string"==typeof e)return rn(e,t)
var n=Object.prototype.toString.call(e).slice(8,-1)
"Object"===n&&e.constructor&&(n=e.constructor.name)
if("Map"===n||"Set"===n)return Array.from(e)
if("Arguments"===n||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n))return rn(e,t)}(e))||t&&e&&"number"==typeof e.length){n&&(e=n)
var r=0,a=function(){}
return{s:a,n:function(){return r>=e.length?{done:!0}:{done:!1,value:e[r++]}},e:function(e){throw e},f:a}}throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}var i,c=!0,o=!1
return{s:function(){n=e[Symbol.iterator]()},n:function(){var e=n.next()
return c=e.done,e},e:function(e){o=!0,i=e},f:function(){try{c||null==n.return||n.return()}finally{if(o)throw i}}}}function rn(e,t){(null==t||t>e.length)&&(t=e.length)
for(var n=0,r=new Array(t);n<t;n++)r[n]=e[n]
return r}var an=Object(o.b)((function(e,t){return{commands:se(e,t.uuid)}}),(function(e){return{dispatch:e}}))((function(e){var t,n,a=e.commands,i=e.dispatch,c=e.onClose,o=[],l=nn(a)
try{var u=function(){var e=n.value
if("edit"===e.id)return"continue"
void 0!==t&&t!==e.group&&o.push(r.createElement("div",{className:"tcfArrayWidgetMember--headerMoreDivider",key:"".concat(e.id,"-divider")})),t=e.group,o.push(r.createElement(tn,{command:e,key:e.id,onClick:function(){c(),e.invoke(i)}}))}
for(l.s();!(n=l.n()).done;)u()}catch(e){l.e(e)}finally{l.f()}return r.createElement("div",{className:"tcfArrayWidgetMember--headerMoreMenu"},o)}))
n(290),n(291)
function cn(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1
if(Reflect.construct.sham)return!1
if("function"==typeof Proxy)return!0
try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}()
return function(){var n,r=Ze()(e)
if(t){var a=Ze()(this).constructor
n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments)
return Je()(this,n)}}var on=function(e){Ge()(n,e)
var t=cn(n)
function n(){var e
return k()(this,n),(e=t.apply(this,arguments)).handle=null,e.handleStyle={left:"0px"},e.origin=null,e.panel=null,e.panelClassName="tcfFlyout--panel",e.panelStyle={left:"0px",top:"0px"},e.handleResize=function(){e.update()},e.setHandle=function(t){e.handle=t,e.update()},e.setOrigin=function(t){e.origin=t,e.update()},e.setPanel=function(t){e.panel=t,e.update()},e}return O()(n,[{key:"componentDidMount",value:function(){window.addEventListener("resize",this.handleResize)}},{key:"componentWillUnmount",value:function(){window.removeEventListener("resize",this.handleResize)}},{key:"render",value:function(){var e=this.props,t=e.children,n=e.onClick
return r.createElement("div",{className:"tcfFlyout",ref:this.setOrigin},r.createElement(Rt,{onClick:n},r.createElement("div",{className:this.panelClassName,ref:this.setPanel,style:Object.assign({},this.panelStyle)},r.createElement("div",{className:"tcfFlyout--handle",ref:this.setHandle,style:Object.assign({},this.handleStyle)}),r.createElement("div",{className:"tcfFlyout--body"},t))))}},{key:"update",value:function(){var e=this.handle,t=this.handleStyle,n=this.origin,r=this.panel,a=this.panelStyle
if(n&&r&&e){var i=n.getBoundingClientRect(),c=r.getBoundingClientRect(),o="tcfFlyout--panel",l=Math.max(10,Math.min(window.innerWidth-c.width-10,i.left+.5*(i.width-c.width))),u=Math.max(10,Math.min(c.width-10,i.left+.5*i.width-l))
t.left="".concat(u,"px"),a.left="".concat(l,"px"),i.top+.5*i.height>.5*window.innerHeight?(o+=" above",a.top="".concat(i.top-c.height-5,"px")):(o+=" below",a.top="".concat(i.top+i.height+5,"px")),e.style.left=t.left,r.className=this.panelClassName=o,r.style.left=a.left,r.style.top=a.top}}}]),n}(r.Component)
function ln(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1
if(Reflect.construct.sham)return!1
if("function"==typeof Proxy)return!0
try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}()
return function(){var n,r=Ze()(e)
if(t){var a=Ze()(this).constructor
n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments)
return Je()(this,n)}}var un=function(e){Ge()(n,e)
var t=ln(n)
function n(){var e
return k()(this,n),(e=t.apply(this,arguments)).state={isExpanded:!1},e.handleClose=function(){e.setState({isExpanded:!1})},e.handleMouseDown=function(){e.setState({isExpanded:!0})},e}return O()(n,[{key:"render",value:function(){var e=this.props.uuid,t=this.state.isExpanded
return r.createElement("div",{className:"tcfArrayWidgetMember--headerMore"},r.createElement("div",{className:"tcfArrayWidgetMember--headerMoreButton",onMouseDown:this.handleMouseDown},r.createElement(ut,{name:"material:more_vert"})),t?r.createElement(on,{onClick:this.handleClose},r.createElement(an,{onClose:this.handleClose,uuid:e})):null)}}]),n}(r.Component)
function sn(e){return e}function fn(e,t){return t?e?"minus":"plus":e?"done":"edit"}function dn(e){var t=e.disabled,n=e.dragSource,a=void 0===n?sn:n,i=e.field,c=e.hasPreview,o=e.isCollapsible,l=e.isExpanded,u=e.model,s=e.onToggleExpanded,f=e.schema,d=[]
return f?(d.push(r.createElement(ut,{key:"icon",name:f.icon})),f.previewImage&&d.push(r.createElement(Qt,{key:"image",model:u,schema:f})),d.push(r.createElement("div",{className:xe()("tcfArrayWidgetMember--headerLabel",{isHidden:!u.__visible}),key:"label"},f.label)),c&&f.previewLabelTemplate&&d.push(r.createElement("div",{className:"tcfArrayWidgetMember--headerPreview",key:"preview"},r.createElement(en,{field:i,model:u})))):d.push(r.createElement(ut,{className:"tcfArrayWidgetMember--headerHandleIcon",key:"handle",name:"move"})),r.createElement("div",{className:"tcfArrayWidgetMember--header"},a(r.createElement("div",{className:xe()("tcfArrayWidgetMember--headerHandle",{enabled:!t}),onClick:s},d)),u.__visible?null:r.createElement(ut,{className:"tcfArrayWidgetMember--headerVisibility",name:"material:visibility_off"}),r.createElement("div",{className:"tcfArrayWidgetMember--headerActions"},o?r.createElement(Gt,{onClick:s,primary:!t},r.createElement(ut,{name:fn(l,t)})):null,t?null:r.createElement(un,{uuid:u.__uuid})))}n(166)
var mn=r.memo((function(e){var t=e.field,n=e.model,a=e.mode,i=void 0===a?"default":a,c=e.references,o=e.schemas,l=C.getDefinition("instance").preview({context:{depth:0,references:c,schemas:o},field:t,mode:i,value:n})
try{var u={__html:At(l)}
return r.createElement("div",{className:xe()("tcfInstancePreview--content",i),dangerouslySetInnerHTML:u})}catch(e){return r.createElement(r.Fragment,null,r.createElement("p",null,r.createElement("span",{className:"tcfIcon material"},"error"),r.createElement("span",null,"Could not render preview.")),e&&"object"===s()(e)&&"message"in e?r.createElement("pre",null,e.message):null)}}),(function(e,t){return e.model===t.model}))
function pn(e){var t=e.className,n=e.field,a=e.model,i=e.mode,c=e.onClick,l=Object(o.d)((function(e){return{references:e.config.references,schemas:e.schemas}})),u=l.references,s=l.schemas
return r.createElement("div",{className:xe()("tcfInstancePreview",t,{isClickable:!!c}),onClick:c},r.createElement(mn,{field:n,model:a,mode:i,references:u,schemas:s}))}function hn(e){var t=r.useContext(Ie),n=t.isExpanded,a=t.toggleExpanded,i=r.useRef(null),c=Ht(e,i),o=_e()(c,3),l=o[0].isDragging,u=o[1],s=o[2],f=qt(e,i);(0,_e()(f,2)[1])(i)
var d=e.child,m=e.depth,p=e.disabled,h=e.field,v=e.isCollapsible,y=e.path,g=e.previewMode,b=e.schema,E=function(){a(d.__uuid)},w=!0,k=!1
if(b){var S=Object.keys(b.fields)
w=S.length>0,k=1===S.length&&"redactor"===b.fields[S[0]].type}var O,C=b&&b.preview&&function(e,t){switch(e){case"always":return!0
case"root":return 1===t}}(g,m),j=w&&(!v||n(d.__uuid))
return j?O=r.createElement("div",{className:"tcfArrayWidgetMember--body"},r.createElement(jt,{canChangeType:!1,disabled:p,isBorderless:k,key:"details",model:d,path:y,schemaNames:h.schemas})):C&&(O=r.createElement(pn,{className:"tcfArrayWidgetMember--preview",field:h,key:"summary",model:d,onClick:w?E:void 0})),r.createElement("div",{className:xe()("tcfArrayWidgetMember depth-".concat(m),j?"isExpanded":"isCollapsed",{isDragging:l}),ref:i},s(r.createElement("div",{className:"tcfArrayWidgetMember--panel"},r.createElement(dn,{disabled:p,dragSource:u,field:h,hasPreview:!j&&!C,isCollapsible:w&&v,isExpanded:j,model:d,onToggleExpanded:E,schema:b}),r.createElement(Kt,{uri:j?"details":"summary"},O))))}n(292)
function vn(e){var t=e.children,n=e.data,a=e.disabled,i=e.field,c=e.model,l=e.onDelete,u=e.onUpdate,s=e.path,f=i.member,d=i.collapsible,m=i.previewMode,p=r.useRef(null),h=Object(o.d)((function(e){return e.schemas})),v=r.useContext(kt),y=n.map((function(e,t){var n=[].concat(A()(s),[{index:t,name:f.name,type:"index"}]),i={child:e,depth:v,disabled:a,path:n}
return"instance"===f.type?r.createElement(hn,Object.assign({},i,{isCollapsible:d,field:f,key:e.__uuid,previewMode:m,schema:h[e.__type]})):r.createElement(zt,Object.assign({},i,{field:f,index:t,key:Ee(e)?e.__uuid:t,model:c,onDelete:l,onUpdate:u}))}))
return 0===y.length&&y.push(r.createElement($t,{field:i,key:"droplet",path:s})),r.createElement(r.Fragment,null,r.createElement("div",{className:"tcfArrayWidgetList",ref:p},y),r.createElement("div",{className:"tcfArrayWidgetList--footer"},t))}function yn(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1
if(Reflect.construct.sham)return!1
if("function"==typeof Proxy)return!0
try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}()
return function(){var n,r=Ze()(e)
if(t){var a=Ze()(this).constructor
n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments)
return Je()(this,n)}}var gn=function(e){Ge()(n,e)
var t=yn(n)
function n(){var e
return k()(this,n),(e=t.apply(this,arguments)).handleAdd=function(t){var n=mt()(e).context,r=e.props,a=r.data,i=r.disabled,c=r.onUpdate
if(!i){var o=Array.isArray(a)?a.slice():[]
o.push(we(t)),c(o),f(t)&&n&&n.toggleExpanded(t.__uuid,!0)}},e.handleDelete=function(t){var n=e.props,r=n.data,a=n.disabled,i=n.onUpdate
if(!a&&Array.isArray(r)){var c=r.slice()
c.splice(t,1),i(c)}},e.handleUpdate=function(t,n){var r=e.props,a=r.data,i=r.disabled,c=r.onUpdate
if(!i&&Array.isArray(a)){var o=a.slice()
o[t]=we(n,o[t]),c(o)}},e}return O()(n,[{key:"render",value:function(){var e=this.props,t=e.data,n=e.disabled,a=e.field,i=e.model,c=e.path,o=a.limit
if(!a.member)return null
var l,u=Array.isArray(t)?t:[],s=o>0&&u.length>=o,f=C.getDefinition(a.member)
return n||!f||s||(l=r.createElement(f.factory,{field:a.member,onCreate:this.handleAdd,scope:i.__type})),r.createElement(vn,{data:u,disabled:n,field:a,limit:o,model:i,onDelete:this.handleDelete,onUpdate:this.handleUpdate,path:c},l)}}]),n}(r.Component)
function bn(e){if(!e)return e
if(Array.isArray(e))return e.map((function(e){return bn(e)}))
if("object"===s()(e)){var t={}
for(var n in e)t[n]=bn(e[n])
return t}return e}gn.contextType=Ie
n(293)
function En(e){var t=e.field,n=e.onCreate,a=Object(o.d)((function(e){return e.schemas}))
return r.createElement("div",{className:"tcfFactory"},r.createElement(Re,{className:"tcfFactory--primaryButton",onClick:function(){var e=C.createValue({field:t,schemas:a})
n(e)},secondary:!0},r.createElement(ut,{name:"plus"}),r.createElement(De,{value:"Create"})))}var wn=function(){function e(t){var n=t.factory,r=t.widget
k()(this,e),this.factory=n||En,this.widget=r}return O()(e,[{key:"cloneValue",value:function(e){return Object(K.a)(this,void 0,void 0,X.a.mark((function t(){var n,r
return X.a.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:if(n=e.field,r=e.value,!this.isValue(n,r)){t.next=5
break}return t.abrupt("return",bn(r))
case 5:return t.abrupt("return",this.createValue(e))
case 6:case"end":return t.stop()}}),t,this)})))}}]),e}()
function kn(e,t){var n
if("undefined"==typeof Symbol||null==e[Symbol.iterator]){if(Array.isArray(e)||(n=function(e,t){if(!e)return
if("string"==typeof e)return Sn(e,t)
var n=Object.prototype.toString.call(e).slice(8,-1)
"Object"===n&&e.constructor&&(n=e.constructor.name)
if("Map"===n||"Set"===n)return Array.from(e)
if("Arguments"===n||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n))return Sn(e,t)}(e))||t&&e&&"number"==typeof e.length){n&&(e=n)
var r=0,a=function(){}
return{s:a,n:function(){return r>=e.length?{done:!0}:{done:!1,value:e[r++]}},e:function(e){throw e},f:a}}throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}var i,c=!0,o=!1
return{s:function(){n=e[Symbol.iterator]()},n:function(){var e=n.next()
return c=e.done,e},e:function(e){o=!0,i=e},f:function(){try{c||null==n.return||n.return()}finally{if(o)throw i}}}}function Sn(e,t){(null==t||t>e.length)&&(t=e.length)
for(var n=0,r=new Array(t);n<t;n++)r[n]=e[n]
return r}function On(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1
if(Reflect.construct.sham)return!1
if("function"==typeof Proxy)return!0
try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}()
return function(){var n,r=Ze()(e)
if(t){var a=Ze()(this).constructor
n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments)
return Je()(this,n)}}var Cn=function(e){Ge()(n,e)
var t=On(n)
function n(){return k()(this,n),t.call(this,{widget:gn})}return O()(n,[{key:"cloneValue",value:function(e){return Object(K.a)(this,void 0,void 0,X.a.mark((function t(){var n,r,a,i,c,o,l,u
return X.a.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:if(n=e.field,r=e.value,a=Object(K.c)(e,["field","value"]),!this.isValue(n,r)){t.next=27
break}i=C.getDefinition(n.member.type),c=[],o=kn(r),t.prev=5,o.s()
case 7:if((l=o.n()).done){t.next=16
break}return u=l.value,t.t0=c,t.next=12,i.cloneValue(Object.assign(Object.assign({},a),{field:n.member,value:u}))
case 12:t.t1=t.sent,t.t0.push.call(t.t0,t.t1)
case 14:t.next=7
break
case 16:t.next=21
break
case 18:t.prev=18,t.t2=t.catch(5),o.e(t.t2)
case 21:return t.prev=21,o.f(),t.finish(21)
case 24:return t.abrupt("return",c)
case 27:return t.abrupt("return",this.createValue(e))
case 28:case"end":return t.stop()}}),t,this,[[5,18,21,24]])})))}},{key:"createValue",value:function(e){return[]}},{key:"isValue",value:function(e,t){return Array.isArray(t)}},{key:"preview",value:function(e){return new Vt(e)}}]),n}(wn)
function jn(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1
if(Reflect.construct.sham)return!1
if("function"==typeof Proxy)return!0
try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}()
return function(){var n,r=Ze()(e)
if(t){var a=Ze()(this).constructor
n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments)
return Je()(this,n)}}var xn=function(e){Ge()(n,e)
var t=jn(n)
function n(){return k()(this,n),t.apply(this,arguments)}return O()(n,[{key:"createValue",value:function(e){return!!e.field.defaultValue}},{key:"isValue",value:function(e,t){return"boolean"==typeof t||t instanceof Boolean}},{key:"preview",value:function(e){return e.value}}]),n}(wn)
n(294)
function Rn(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1
if(Reflect.construct.sham)return!1
if("function"==typeof Proxy)return!0
try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}()
return function(){var n,r=Ze()(e)
if(t){var a=Ze()(this).constructor
n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments)
return Je()(this,n)}}var Nn=function(e){Ge()(n,e)
var t=Rn(n)
function n(){var e
return k()(this,n),(e=t.apply(this,arguments)).id=j(),e}return O()(n,[{key:"render",value:function(){var e=this.id,t=this.props,n=t.className,a=t.children,i=t.disabled,c=t.onChange,o=t.value
return r.createElement("dl",{className:xe()("tcfCheckbox",n)},r.createElement("dd",{className:"tcfCheckbox--input"},r.createElement("input",{checked:o,disabled:i,id:e,onChange:i?void 0:function(){return c(!o)},type:"checkbox"})),r.createElement("dt",{className:"tcfCheckbox--label"},r.createElement("label",{htmlFor:e},a)))}}]),n}(r.Component)
function _n(e){var t=e.data,n=e.disabled,a=e.field,i=e.onUpdate
return r.createElement(Nn,{disabled:n,onChange:i,value:!!t},a.label)}function In(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1
if(Reflect.construct.sham)return!1
if("function"==typeof Proxy)return!0
try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}()
return function(){var n,r=Ze()(e)
if(t){var a=Ze()(this).constructor
n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments)
return Je()(this,n)}}var Mn=function(e){Ge()(n,e)
var t=In(n)
function n(){var e
return k()(this,n),(e=t.call(this,{widget:_n})).isAlwaysPlainField=!0,e}return n}(xn)
function An(e){var t=e.red,n=e.green,r=e.blue,a=e.alpha
return{max:Math.max(t,n,r),min:Math.min(t,n,r),red:t/255,green:n/255,blue:r/255,alpha:a}}function Dn(e){return"object"===s()(e)&&"number"==typeof e.alpha&&"number"==typeof e.blue&&"number"==typeof e.green&&"number"==typeof e.red}function Pn(e){e=e.replace(/^#?([a-f\d])([a-f\d])([a-f\d])$/i,(function(e,t,n,r){return t+t+n+n+r+r}))
var t=/^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(e)
return t?{red:parseInt(t[1],16),green:parseInt(t[2],16),blue:parseInt(t[3],16),alpha:1}:null}function Ln(e){return"rgba(".concat(e.red,",").concat(e.green,",").concat(e.blue,",").concat(e.alpha,")")}function Tn(e){var t=An(e),n=t.alpha,r=t.blue,a=t.green,i=t.max,c=t.min,o=t.red,l=0===i?0:(i-c)/i,u=(i-c)/255,s=0,f=i/255
return i===c?{hue:s,saturation:l,value:f,alpha:n}:(s=i===e.red?(a-r)/u+(a<r?6:0):i===e.green?(r-o)/u+2:(o-a)/u+4,{hue:s/=6,saturation:l,value:f,alpha:n})}function Un(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1
if(Reflect.construct.sham)return!1
if("function"==typeof Proxy)return!0
try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}()
return function(){var n,r=Ze()(e)
if(t){var a=Ze()(this).constructor
n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments)
return Je()(this,n)}}var Fn=r.createContext({css:"#000",hsv:{hue:0,saturation:0,value:0,alpha:0},rgb:{red:0,green:0,blue:0,alpha:0},onHsvColor:function(e){},onRgbColor:function(e){}})
function Vn(e){return function(t){return r.createElement(Fn.Consumer,null,(function(n){return r.createElement(e,Object.assign({},t,n))}))}}var Wn=function(e){Ge()(n,e)
var t=Un(n)
function n(e){var r
return k()(this,n),(r=t.call(this,e)).timeout=null,r.commit=function(){null!==r.timeout&&window.clearTimeout(r.timeout),r.timeout=window.setTimeout(r.handleTimeout,250)},r.handleHsvColor=function(e){var t=function(e){var t=e.alpha,n=e.hue,r=e.saturation,a=e.value,i=0,c=0,o=0,l=Math.floor(6*n),u=6*n-l,s=a*(1-r),f=a*(1-u*r),d=a*(1-(1-u)*r)
switch(l%6){case 0:i=a,c=d,o=s
break
case 1:i=f,c=a,o=s
break
case 2:i=s,c=a,o=d
break
case 3:i=s,c=f,o=a
break
case 4:i=d,c=s,o=a
break
case 5:i=a,c=s,o=f}return{alpha:t,red:Math.round(255*i),green:Math.round(255*c),blue:Math.round(255*o)}}(e)
r.setState({css:Ln(t),rgb:t,hsv:e}),r.commit()},r.handleRgbColor=function(e){r.setState({css:Ln(e),rgb:e,hsv:Tn(e)}),r.commit()},r.handleTimeout=function(){r.timeout=null,r.props.onChange(r.state.rgb)},r.state={css:Ln(e.color),hsv:Tn(e.color),rgb:Object.assign({},e.color)},r}return O()(n,[{key:"render",value:function(){var e=this.props.children
return r.createElement(Fn.Provider,{value:Object.assign(Object.assign({},this.state),{onHsvColor:this.handleHsvColor,onRgbColor:this.handleRgbColor})},e)}}]),n}(r.Component)
n(295)
function Hn(e){var t=e.className,n=Object(K.c)(e,["className"])
return r.createElement("input",Object.assign({className:xe()("tcfInput",t)},n))}function Bn(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1
if(Reflect.construct.sham)return!1
if("function"==typeof Proxy)return!0
try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}()
return function(){var n,r=Ze()(e)
if(t){var a=Ze()(this).constructor
n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments)
return Je()(this,n)}}var qn=Vn(function(e){Ge()(n,e)
var t=Bn(n)
function n(){var e
return k()(this,n),(e=t.apply(this,arguments)).state={hasFocus:!1},e.handleBlur=function(){e.setState({hasFocus:!1})},e.handleChange=function(t){var n=t.target.value;(0,e.props.onRgbColor)(e.getColor(n))},e.handleFocus=function(){e.setState({hasFocus:!0})},e}return O()(n,[{key:"getValue",value:function(){var e,t=this.props,n=t.rgb,r=t.type
switch(r){case"alpha":case"blue":case"green":case"red":return"".concat(n[r])
case"hex":return"#"+(16777216+((e=n).blue|e.green<<8|e.red<<16)).toString(16).slice(1)}}},{key:"getColor",value:function(e){var t=this.props,n=t.rgb,r=t.type
switch(r){case"blue":case"green":case"red":var a=parseInt(e)
return Object.assign(Object.assign({},n),I()({},r,isFinite(a)?Math.max(0,Math.min(255,a)):n[r]))
case"alpha":var i=parseFloat(e)
return Object.assign(Object.assign({},n),{alpha:isFinite(i)?Math.max(0,Math.min(1,i)):n.alpha})
case"hex":var c=Pn(e)
return c?Object.assign(Object.assign({},c),{alpha:n.alpha}):n}}},{key:"render",value:function(){var e=this.state.hasFocus,t={className:"tcfColorInputInput",onBlur:this.handleBlur,onChange:this.handleChange,onFocus:this.handleFocus}
return e?t.defaultValue=this.getValue():t.value=this.getValue(),r.createElement(Hn,t)}}]),n}(r.Component))
n(296)
function zn(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1
if(Reflect.construct.sham)return!1
if("function"==typeof Proxy)return!0
try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}()
return function(){var n,r=Ze()(e)
if(t){var a=Ze()(this).constructor
n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments)
return Je()(this,n)}}var $n=Vn(function(e){Ge()(n,e)
var t=zn(n)
function n(){var e
return k()(this,n),(e=t.apply(this,arguments)).element=null,e.state={initialHue:0,isMouseDown:!1,mouseX:0,mouseY:0},e.handleMouseDown=function(t){var n=e.props.hsv
window.addEventListener("mousemove",e.handleMouseMove),window.addEventListener("mouseup",e.handleMouseUp),e.setState(Object.assign(Object.assign({},e.update(t.clientX,t.clientY,n.hue)),{initialHue:n.hue,isMouseDown:!0}))},e.handleMouseMove=function(t){e.setState(e.update(t.clientX,t.clientY))},e.handleMouseUp=function(t){e.stopListening(),e.setState(Object.assign(Object.assign({},e.update(t.clientX,t.clientY)),{isMouseDown:!1}))},e.setElement=function(t){e.element=t},e}return O()(n,[{key:"componentWillUnmount",value:function(){this.stopListening()}},{key:"render",value:function(){var e=this.props.hsv,t=this.state,n=t.initialHue,a=t.isMouseDown,i=t.mouseX,c=t.mouseY
return r.createElement("div",{className:"tcfColorInputSaturation",onMouseDown:this.handleMouseDown,ref:this.setElement,style:{background:"hsl(".concat(360*(a?n:e.hue),", 100%, 50%)")}},r.createElement("div",{className:"tcfColorInputSaturation--value",style:{left:"".concat(100*(a?i:e.saturation),"%"),top:"".concat(100*(a?c:1-e.value),"%")}}))}},{key:"stopListening",value:function(){window.removeEventListener("mousemove",this.handleMouseMove),window.removeEventListener("mouseup",this.handleMouseUp)}},{key:"update",value:function(e,t){var n=arguments.length>2&&void 0!==arguments[2]?arguments[2]:this.state.initialHue,r=this.element
if(!r)return{mouseX:this.state.mouseX,mouseY:this.state.mouseY}
var a=this.props,i=a.hsv,c=a.onHsvColor,o=r.getBoundingClientRect(),l=Math.max(0,Math.min(1,(e-o.left)/o.width)),u=Math.max(0,Math.min(1,(t-o.top)/o.height))
return c({alpha:i.alpha,hue:n,saturation:l,value:1-u}),{mouseX:l,mouseY:u}}}]),n}(r.Component))
n(297)
function Xn(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1
if(Reflect.construct.sham)return!1
if("function"==typeof Proxy)return!0
try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}()
return function(){var n,r=Ze()(e)
if(t){var a=Ze()(this).constructor
n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments)
return Je()(this,n)}}var Kn=Vn(function(e){Ge()(n,e)
var t=Xn(n)
function n(){var e
return k()(this,n),(e=t.apply(this,arguments)).element=null,e.handleMouseDown=function(t){window.addEventListener("mousemove",e.handleMouseMove),window.addEventListener("mouseup",e.handleMouseUp),e.update(t.clientX)},e.handleMouseMove=function(t){e.update(t.clientX)},e.handleMouseUp=function(t){e.stopListening(),e.update(t.clientX)},e.setElement=function(t){e.element=t},e}return O()(n,[{key:"componentWillUnmount",value:function(){this.stopListening()}},{key:"render",value:function(){var e,t=this.props,n=t.rgb,a=t.hsv,i=t.type,c=a[i]
if("alpha"===i){var o=n.red,l=n.green,u=n.blue,s="rgba(".concat(o,", ").concat(l,", ").concat(u,", 0)"),f="rgba(".concat(o,", ").concat(l,", ").concat(u,", 1)")
e=r.createElement("div",{className:"tcfColorInputSlider--gradient",style:{background:"linear-gradient(to right, ".concat(s,", ").concat(f,")")}})}return r.createElement("div",{className:"tcfColorInputSlider ".concat(i),onMouseDown:this.handleMouseDown},e,r.createElement("div",{className:"tcfColorInputSlider--track",ref:this.setElement},r.createElement("div",{className:"tcfColorInputSlider--handle",style:{left:"".concat(100*c,"%")}})))}},{key:"stopListening",value:function(){window.removeEventListener("mousemove",this.handleMouseMove),window.removeEventListener("mouseup",this.handleMouseUp)}},{key:"update",value:function(e){var t=this.element
if(t){var n=this.props,r=n.hsv,a=n.onHsvColor,i=n.type,c=t.getBoundingClientRect(),o=Math.max(0,Math.min(1,(e-c.left)/c.width))
a(Object.assign(Object.assign({},r),I()({},i,o)))}}}]),n}(r.Component))
n(298)
var Gn=Vn((function(e){var t=e.children,n=e.className,a=e.color,i=e.css,c=e.disabled,o=e.onClick,l=e.onRgbColor
if(a){var u=Pn(a)
u&&(o=function(){l(u)})}return r.createElement("div",{className:xe()("tcfColorInputSwatch",n),onClick:c?void 0:o},r.createElement("div",{className:"tcfColorInputSwatch--color",style:{background:a||i}}),t)}))
n(299)
function Yn(e){var t=e.disableAlpha,n=e.presetColors,a=[r.createElement("div",{className:"tcfColorInputPicker--value wide",key:"hex"},r.createElement(qn,{type:"hex"}),r.createElement("div",{className:"tcfColorInputPicker--valueCaption"},"Hex")),r.createElement("div",{className:"tcfColorInputPicker--value",key:"red"},r.createElement(qn,{type:"red"}),r.createElement("div",{className:"tcfColorInputPicker--valueCaption"},"R")),r.createElement("div",{className:"tcfColorInputPicker--value",key:"green"},r.createElement(qn,{type:"green"}),r.createElement("div",{className:"tcfColorInputPicker--valueCaption"},"G")),r.createElement("div",{className:"tcfColorInputPicker--value",key:"blue"},r.createElement(qn,{type:"blue"}),r.createElement("div",{className:"tcfColorInputPicker--valueCaption"},"B"))]
t||a.push(r.createElement("div",{className:"tcfColorInputPicker--value",key:"alpha"},r.createElement(qn,{type:"alpha"}),r.createElement("div",{className:"tcfColorInputPicker--valueCaption"},"A")))
var i=null
return n&&n.length&&(i=r.createElement("div",{className:"tcfColorInputPicker--presets"},n.map((function(e){return r.createElement(Gn,{className:"tcfColorInputPicker--presetsSwatch",color:e})})))),r.createElement("div",{className:"tcfColorInputPicker"},r.createElement($n,null),r.createElement("div",{className:"tcfColorInputPicker--controls"},r.createElement("div",{className:"tcfColorInputPicker--sliders"},r.createElement(Kn,{type:"hue"}),t?null:r.createElement(Kn,{type:"alpha"})),r.createElement(Gn,{className:"tcfColorInputPicker--swatch"})),r.createElement("div",{className:"tcfColorInputPicker--values"},a),i)}n(300)
function Jn(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1
if(Reflect.construct.sham)return!1
if("function"==typeof Proxy)return!0
try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}()
return function(){var n,r=Ze()(e)
if(t){var a=Ze()(this).constructor
n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments)
return Je()(this,n)}}var Qn=function(e){Ge()(n,e)
var t=Jn(n)
function n(){var e
return k()(this,n),(e=t.apply(this,arguments)).state={hasColorPicker:!1},e.handleChange=function(t){e.props.onChange(t)},e.handleSwatchClick=function(){e.setState({hasColorPicker:!0})},e.handleOverlayClick=function(){e.setState({hasColorPicker:!1})},e}return O()(n,[{key:"render",value:function(){var e=this.state.hasColorPicker,t=this.props,n=t.color,a=t.disableAlpha,i=t.disabled,c=t.onChange,o=t.presetColors
return r.createElement(Wn,{color:n,onChange:c},r.createElement("div",{className:"tcfColorInput"},r.createElement(Gn,{className:"tcfColorInput--swatch",disabled:i,onClick:this.handleSwatchClick},e&&!i?r.createElement(on,{onClick:this.handleOverlayClick},r.createElement(Yn,{disableAlpha:a,presetColors:o})):null),r.createElement(qn,{type:"hex"})))}}]),n}(r.Component)
function Zn(e){var t=e.data,n=e.disabled,a=e.field,i=e.onUpdate,c=Dn(t)?t:{alpha:1,blue:255,green:255,red:255}
return r.createElement(Qn,{color:c,disableAlpha:!a.alpha,disabled:n,onChange:i,presetColors:a.swatches})}function er(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1
if(Reflect.construct.sham)return!1
if("function"==typeof Proxy)return!0
try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}()
return function(){var n,r=Ze()(e)
if(t){var a=Ze()(this).constructor
n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments)
return Je()(this,n)}}var tr=function(e){Ge()(n,e)
var t=er(n)
function n(){return k()(this,n),t.call(this,{widget:Zn})}return O()(n,[{key:"createValue",value:function(e){return{alpha:1,blue:255,green:255,red:255}}},{key:"isValue",value:function(e,t){return Dn(t)}},{key:"preview",value:function(e){e.context,e.value
return""}}]),n}(wn)
function nr(e,t,n){var r,a,i=null,c=null,o=null
function l(){var u=Date.now()-r
u<t&&u>=0?i=window.setTimeout(l,t-u):(i=null,n||(a=e.apply(o,c),i||(o=c=null)))}return function(){o=this,c=arguments,r=Date.now()
var u=n&&!i
return i||(i=window.setTimeout(l,t)),u&&(a=e.apply(o,c),o=c=null),a}}n(301)
function rr(e){var t=e.children,n=e.className,a=e.icon
return r.createElement("div",{className:xe()("tcfTextAndIcon",n)},r.createElement(ut,{className:"tcfTextAndIcon--icon",name:a}),r.createElement(De,{className:"tcfTextAndIcon--text",value:t}))}function ar(e){var t=e.children,n=e.title
return r.createElement("div",{className:"tcfErrorMessage"},r.createElement(rr,{icon:"material:error"},n),t)}function ir(e){return"object"===s()(e)&&"string"==typeof e.url}n(302)
function cr(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1
if(Reflect.construct.sham)return!1
if("function"==typeof Proxy)return!0
try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}()
return function(){var n,r=Ze()(e)
if(t){var a=Ze()(this).constructor
n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments)
return Je()(this,n)}}var or=function(e){Ge()(n,e)
var t=cr(n)
function n(){var e
return k()(this,n),(e=t.apply(this,arguments)).request=null,e.state={mode:"idle"},e.handleChange=function(t){e.updateOEmbed(),e.setState({mode:"typing"}),e.props.onUpdate(Object.assign(Object.assign({},e.getOEmbed()),{url:t.target.value}))},e.updateOEmbed=nr((function(){e.setState({mode:"loading"})
var t=e.props,n=t.apiEndpoint,r=t.model,a=t.field,i=["schema=".concat(encodeURIComponent(r.__type)),"field=".concat(encodeURIComponent(a.name)),"url=".concat(encodeURIComponent(e.getOEmbed().url))],c=new XMLHttpRequest
c.onreadystatechange=function(){return e.handleRequestStateChange(c)},c.onerror=function(){return e.handleRequestError()},c.open("GET","".concat(n,"&").concat(i.join("&"))),c.send(),e.request&&e.request.abort(),e.request=c}),500),e}return O()(n,[{key:"getOEmbed",value:function(){var e=this.props.data
return ir(e)?e:{url:""}}},{key:"handleRequestStateChange",value:function(e){if(e.readyState===XMLHttpRequest.DONE){if(200!==e.status)return this.handleRequestError()
var t
try{t=JSON.parse(e.responseText)}catch(e){return this.handleRequestError()}this.setState({mode:"idle"}),this.request=null,this.props.onUpdate(Object.assign(Object.assign({},this.getOEmbed()),{info:t.data}))}}},{key:"handleRequestError",value:function(){this.setState({mode:"idle"}),this.request=null,this.props.onUpdate(Object.assign(Object.assign({},this.getOEmbed()),{info:null}))}},{key:"render",value:function(){var e,t=this.getOEmbed(),n=this.props.disabled,a=this.state.mode
if("typing"===a||"loading"===a)e=r.createElement("div",{className:"tcfOEmbedWidget--activity"},r.createElement("div",{className:"tcfOEmbedWidget--activityBounce first"}),r.createElement("div",{className:"tcfOEmbedWidget--activityBounce second"}),r.createElement("div",{className:"tcfOEmbedWidget--activityBounce third"}))
else if(t.info){var i=t.info,c=i.title,o=i.author_name,l=i.thumbnail_url
e=r.createElement("div",{className:"tcfOEmbedWidget--info"},l?r.createElement("img",{className:"tcfOEmbedWidget--infoImage",src:l}):null,r.createElement("div",{className:"tcfOEmbedWidget--infoContent"},r.createElement("div",{className:"tcfOEmbedWidget--infoTitle"},c),r.createElement("div",{className:"tcfOEmbedWidget--infoAuthor"},o)))}else e=r.createElement(ar,{title:"Invalid embed url"})
return r.createElement("div",{className:"tcfOEmbedWidget"},r.createElement("div",{className:"tcfOEmbedWidget--input"},r.createElement("input",{autoComplete:"off",className:"text fullwidth",disabled:n,onChange:n?void 0:this.handleChange,value:t.url})),e)}}]),n}(r.Component),lr=Object(o.b)((function(e){return{apiEndpoint:e.config.apiEndpoints.oembed}}))(or),ur=function(){function e(t){k()(this,e),this.value=t}return O()(e,[{key:"toHTML",value:function(){var e=this.value.info
if(!e)return new ve.SafeString("")
var t=""
return e.thumbnail_url&&(t='<img class="tcfOEmbedWidget--infoImage" src="'.concat(e.thumbnail_url,'" />')),new ve.SafeString('\n      <div class="tcfOEmbedWidget--info">\n        '.concat(t,'\n        <div class="tcfOEmbedWidget--infoContent">\n          <div class="tcfOEmbedWidget--infoTitle">').concat(e.title,'</div>\n          <div class="tcfOEmbedWidget--infoAuthor">').concat(e.author_name,"</div>\n        </div>\n      </div>\n    "))}},{key:"author",get:function(){return this.value.info?this.value.info.author_name:""}},{key:"thumbnail",get:function(){var e=this.value.info
return e&&e.thumbnail_url?new ve.SafeString('<img width="100" src='.concat(e.thumbnail_url," />")):""}},{key:"title",get:function(){return this.value.info?this.value.info.title:""}}]),e}()
function sr(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1
if(Reflect.construct.sham)return!1
if("function"==typeof Proxy)return!0
try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}()
return function(){var n,r=Ze()(e)
if(t){var a=Ze()(this).constructor
n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments)
return Je()(this,n)}}Object(K.b)([Tt],ur.prototype,"value",void 0),Object(K.b)([Tt],ur.prototype,"author",null),Object(K.b)([Tt],ur.prototype,"thumbnail",null),Object(K.b)([Tt],ur.prototype,"title",null),Object(K.b)([Lt],ur.prototype,"toHTML",null)
var fr=function(e){Ge()(n,e)
var t=sr(n)
function n(){return k()(this,n),t.call(this,{widget:lr})}return O()(n,[{key:"createValue",value:function(e){return{url:""}}},{key:"isValue",value:function(e,t){return ir(t)}},{key:"preview",value:function(e){var t=e.value
return new ur(ir(t)?t:{url:""})}}]),n}(wn)
n(303)
function dr(e){var t=e.favorites,n=e.onSchema,a=e.onToggleFavorite,i=e.schemas.map((function(e){var i=-1!==t.indexOf(e.qualifier)
return r.createElement("div",{className:"tcfSchemaList--row",key:e.qualifier},r.createElement("div",{className:"tcfSchemaList--schema",onMouseUp:function(){return n(e)}},r.createElement(ut,{className:"tcfSchemaList--schemaIcon",name:e.icon}),r.createElement("div",{className:"tcfSchemaList--schemaLabel"},e.label)),a?r.createElement("div",{className:"tcfSchemaList-favorite",onClick:function(){return a(e)}},r.createElement(ut,{name:i?"material:star":"material:star_border"})):null)}))
return r.createElement("div",{className:"tcfSchemaList"},i)}function mr(e){var t,n=e.onCreate,a=e.schemas,i=e.scope,c=r.useState(!1),l=_e()(c,2),u=l[0],s=l[1],f=Object(o.c)(),d=[],m=null
if(i){var p=Object(o.d)((function(e){return e.user})).favoriteSchemas;(d=i in p?p[i]:[]).length&&(m=a.filter((function(e){return-1!==d.indexOf(e.qualifier)})).map((function(e){return r.createElement(Re,{className:"tcfFactory--quickButton",key:e.qualifier,onClick:function(){return n(e)},secondary:!0},r.createElement(ut,{name:e.icon}),r.createElement("div",null,e.label))}))),t=function(e){f(function(e,t){return function(n,r){var a=r().user.favoriteSchemas,i=e in a?a[e]:[]
i=-1===i.indexOf(t)?[].concat(A()(i),[t]):i.filter((function(e){return e!==t})),n({type:"setUser",user:{favoriteSchemas:Object.assign(Object.assign({},a),I()({},e,i))}})}}(i,e.qualifier))}}return r.createElement("div",{className:"tcfFactory multiple"},r.createElement(Re,{className:"tcfFactory--primaryButton",onMouseDown:function(){return s(!0)}},r.createElement(ut,{name:"plus"}),r.createElement(De,{value:"Create"}),u?r.createElement(on,{onClick:function(){return s(!1)}},r.createElement(dr,{favorites:d,onSchema:function(e){s(!1),n(e)},onToggleFavorite:t,schemas:a})):null),m)}function pr(e){var t=e.onCreate,n=e.schema
return r.createElement("div",{className:"tcfFactory"},r.createElement(Re,{className:"tcfFactory--primaryButton",onClick:function(){return t(n)}},r.createElement(ut,{name:"plus"}),r.createElement(De,{params:{schema:n.label},value:"Create {schema}"})))}function hr(e){var t=e.field,n=e.onCreate,a=e.scope,i=Object(o.d)((function(e){return e.schemas})),c=t.schemas.map((function(e){return i[e]})).sort((function(e,t){return e.label.localeCompare(t.label)}))
if(!c.length)return null
var l=function(e){if(-1!==c.indexOf(e))return n(x({schemas:i,schema:e}))}
return c.length>1?r.createElement(mr,{onCreate:l,schemas:c,scope:a}):r.createElement(pr,{onCreate:l,schema:c[0]})}function vr(e){var t=e.children,n=e.disabled,a=e.field,i=e.model,c=r.useContext(kt),l=Object(o.d)((function(e){return e.schemas})),u=r.useContext(Ie),s=u.isExpanded,f=u.toggleExpanded,d=l[i.__type],m=s(i.__uuid),p=d&&d.preview,h=function(){return f(i.__uuid)},v=null
return m?v=r.createElement("div",{className:"tcfArrayWidgetMember--body"},t):p&&(v=r.createElement(pn,{field:a,model:i,onClick:h})),r.createElement("div",{className:"tcfInstanceWidget--collapsiblePanel depth-".concat(c)},r.createElement(dn,{disabled:n,field:a,hasPreview:!m&&!p,isCollapsible:!0,isExpanded:m,model:i,onToggleExpanded:h,schema:d}),r.createElement(Kt,{uri:m?"details":"summary"},v))}n(304)
function yr(e){var t=e.className,n=e.data,a=e.disabled,i=e.field,c=e.path,o=r.createElement(jt,{canChangeVisibility:!0,disabled:a,model:n,path:[].concat(A()(c),[{type:"property",name:i.name}]),schemaNames:i.schemas})
return i.collapsible&&f(n)?r.createElement(vr,{model:n,disabled:a,field:i},o):r.createElement("div",{className:xe()("tcfInstanceWidget",t)},o)}function gr(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1
if(Reflect.construct.sham)return!1
if("function"==typeof Proxy)return!0
try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}()
return function(){var n,r=Ze()(e)
if(t){var a=Ze()(this).constructor
n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments)
return Je()(this,n)}}var br=function(e){Ge()(n,e)
var t=gr(n)
function n(){return k()(this,n),t.call(this,{factory:hr,widget:yr})}return O()(n,[{key:"cloneValue",value:function(e){return Object(K.a)(this,void 0,void 0,X.a.mark((function t(){var n,r,a
return X.a.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:if(n=e.field,r=e.value,a=Object(K.c)(e,["field","value"]),!this.isValue(n,r)){t.next=5
break}return t.abrupt("return",G(Object.assign(Object.assign({},a),{source:r})))
case 5:return t.abrupt("return",this.createValue(e))
case 6:case"end":return t.stop()}}),t,this)})))}},{key:"createValue",value:function(e){var t=e.field,n=e.schema,r=e.schemas
if(n||(n=r[t.schemas[0]]),!n)throw new Error("The option `schema` is required when creating instances.")
return x({schema:n,schemas:r})}},{key:"isValue",value:function(e,t){return f(t)&&-1!==e.schemas.indexOf(t.__type)}},{key:"preview",value:function(e){var t=e.context,n=e.mode,r=void 0===n?"default":n,a=e.value
if(!f(a))return""
var i=t.schemas[a.__type]
if(!i)return""
var c="label"===r?i.previewLabelTemplate:i.previewTemplate
if(null===c)return i.label
var o={toHTML:function(){return new ve.SafeString(c(o,Ut()))},toString:function(){return c(o,Ut())}}
o.depth=t.depth
for(var l=0,u=Object.keys(i.fields);l<u.length;l++){var s=u[l],d=i.fields[s],m=C.getDefinition(d)
m&&(o[s]=m.preview({context:Object.assign(Object.assign({},t),{depth:t.depth+1}),field:d,value:a[s]}))}return o}}]),n}(wn)
function Er(e){var t=e.data,n=e.disabled,a=e.onUpdate
return r.createElement(ht,{disabled:n,onChange:a,value:!!t})}function wr(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1
if(Reflect.construct.sham)return!1
if("function"==typeof Proxy)return!0
try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}()
return function(){var n,r=Ze()(e)
if(t){var a=Ze()(this).constructor
n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments)
return Je()(this,n)}}var kr=function(e){Ge()(n,e)
var t=wr(n)
function n(){return k()(this,n),t.call(this,{widget:Er})}return n}(xn)
n(167)
function Sr(e,t){var n
if("undefined"==typeof Symbol||null==e[Symbol.iterator]){if(Array.isArray(e)||(n=function(e,t){if(!e)return
if("string"==typeof e)return Or(e,t)
var n=Object.prototype.toString.call(e).slice(8,-1)
"Object"===n&&e.constructor&&(n=e.constructor.name)
if("Map"===n||"Set"===n)return Array.from(e)
if("Arguments"===n||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n))return Or(e,t)}(e))||t&&e&&"number"==typeof e.length){n&&(e=n)
var r=0,a=function(){}
return{s:a,n:function(){return r>=e.length?{done:!0}:{done:!1,value:e[r++]}},e:function(e){throw e},f:a}}throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}var i,c=!0,o=!1
return{s:function(){n=e[Symbol.iterator]()},n:function(){var e=n.next()
return c=e.done,e},e:function(e){o=!0,i=e},f:function(){try{c||null==n.return||n.return()}finally{if(o)throw i}}}}function Or(e,t){(null==t||t>e.length)&&(t=e.length)
for(var n=0,r=new Array(t);n<t;n++)r[n]=e[n]
return r}function Cr(e){var t=r.useRef(null)
return r.useEffect((function(){var n=t.current
if(n){var r,a=Jt(),i=Sr(function(e){var t=e.data,n=e.elementType,r=e.references,a=[]
if(Array.isArray(t)){var i,c=Sr(t)
try{var o=function(){var e=i.value,t=r.find((function(t){return t.id===e&&t.type===n}))
t&&a.push(t)}
for(c.s();!(i=c.n()).done;)o()}catch(e){c.e(e)}finally{c.f()}}return a}(e))
try{for(i.s();!(r=i.n()).done;){var c=r.value.$element.clone(!1,!0)
c.appendTo(n),Craft.setElementSize(c,e.viewMode),a.load(c)}}catch(e){i.e(e)}finally{i.f()}}}),[]),r.createElement("div",{className:"elementselect"},r.createElement("div",{className:"elements",ref:t}))}function jr(e,t){var n
if("undefined"==typeof Symbol||null==e[Symbol.iterator]){if(Array.isArray(e)||(n=function(e,t){if(!e)return
if("string"==typeof e)return xr(e,t)
var n=Object.prototype.toString.call(e).slice(8,-1)
"Object"===n&&e.constructor&&(n=e.constructor.name)
if("Map"===n||"Set"===n)return Array.from(e)
if("Arguments"===n||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n))return xr(e,t)}(e))||t&&e&&"number"==typeof e.length){n&&(e=n)
var r=0,a=function(){}
return{s:a,n:function(){return r>=e.length?{done:!0}:{done:!1,value:e[r++]}},e:function(e){throw e},f:a}}throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}var i,c=!0,o=!1
return{s:function(){n=e[Symbol.iterator]()},n:function(){var e=n.next()
return c=e.done,e},e:function(e){o=!0,i=e},f:function(){try{c||null==n.return||n.return()}finally{if(o)throw i}}}}function xr(e,t){(null==t||t>e.length)&&(t=e.length)
for(var n=0,r=new Array(t);n<t;n++)r[n]=e[n]
return r}function Rr(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1
if(Reflect.construct.sham)return!1
if("function"==typeof Proxy)return!0
try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}()
return function(){var n,r=Ze()(e)
if(t){var a=Ze()(this).constructor
n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments)
return Je()(this,n)}}var Nr=function(e){Ge()(n,e)
var t=Rr(n)
function n(){var e
return k()(this,n),(e=t.apply(this,arguments)).element=null,e.renderedIds=[],e.uuid="element-".concat(j()),e.instance=null,e.isRendering=!1,e.handleAdd=function(t){var n=t.elements,r=e.props,a=r.elementType,i=r.onAddReferences
e.handleChange(),i(n.map((function(e){return Object.assign(Object.assign({},e),{$element:$(e.$element[0].outerHTML),element:e.$element[0].outerHTML,type:a})})))},e.handleChange=function(){if(!e.isRendering){var t=e.props.onUpdate,n=e.getSelectedIds()
e.renderedIds=n,t(n)}},e.setElement=function(t){if(e.element!==t){e.element=t
var n=mt()(e).instance
if(n&&(n.off("selectElements",e.handleAdd),n.off("removeElements",e.handleChange),n.elementSort&&n.elementSort.off("sortChange",e.handleChange),n.destroy(),e.instance=n=null),t){var r=e.props,a=r.criteria,i=r.elementType,c=r.limit,o=void 0===c?null:c,l=r.modalStorageKey,u=void 0===l?null:l,s=r.sourceElementId,f=r.sources,d=r.viewMode,m=void 0===d?"small":d
n=new Craft.BaseElementSelectInput({criteria:a,elementType:i,id:e.uuid,limit:o,modalStorageKey:u,name:e.uuid,sources:f,sourceElementId:s,viewMode:m}),e.instance=n,e.createReferences(),n.on("selectElements",e.handleAdd),n.on("removeElements",e.handleChange),n.elementSort&&n.elementSort.on("sortChange",e.handleChange)}}},e}return O()(n,[{key:"componentDidUpdate",value:function(){var e=this.renderedIds,t=this.props.data||[]
t.length===e.length&&t.every((function(t,n){return t===e[n]}))||this.createReferences()}},{key:"createReferences",value:function(){var e=this.instance
if(e){this.isRendering=!0
var t=[]
e.$elementsContainer.empty()
var n,r=jr(this.getStoredReferences())
try{for(r.s();!(n=r.n()).done;){var a=n.value,i=e.createNewElement(a)
i.find("input").prop("disabled",!0),e.appendElement(i),t.push(a.id)}}catch(e){r.e(e)}finally{r.f()}e.resetElements(),this.renderedIds=t,this.isRendering=!1}}},{key:"getStoredReferences",value:function(){var e=this.props,t=e.data,n=e.elementType,r=e.references,a=[]
if(!Array.isArray(t))return a
var i,c=jr(t)
try{var o=function(){var e=i.value,t=r.find((function(t){return t.id===e&&t.type===n}))
t&&a.push(t)}
for(c.s();!(i=c.n()).done;)o()}catch(e){c.e(e)}finally{c.f()}return a}},{key:"getSelectedIds",value:function(){var e=this.instance
if(!e)return[]
for(var t=[],n=e.getSelectedElementIds(),r=e.getElements(),a=0;a<r.length;a++){var i=parseInt(r.eq(a).data("id"));-1!==n.indexOf(i)&&t.push(i)}return t}},{key:"render",value:function(){return r.createElement("div",{id:this.uuid,className:"elementselect",ref:this.setElement},r.createElement("div",{className:"elements"}),r.createElement("div",{className:"btn add icon dashed"},"Choose"))}}]),n}(r.Component)
var _r=Object(o.b)((function(e){return{references:e.config.references,sourceElementId:e.config.elementId}}),(function(e){return{onAddReferences:function(t){e(E(t))}}}))((function(e){return e.disabled?r.createElement(Cr,Object.assign({},e)):r.createElement(Nr,Object.assign({},e))}))
function Ir(e){var t=e.disabled,n=e.link,a=e.linkType,i=e.modalStorageKey,c=void 0===i?null:i,o=e.onUpdate
return r.createElement("div",{className:"tcfLinkWidget--editor"},r.createElement(_r,{criteria:a.criteria,data:[n.elementId],disabled:t,elementType:a.elementType,limit:1,modalStorageKey:c,onUpdate:function(e){return o(Object.assign(Object.assign({},n),{elementId:e.length?e[0]:0}))},sources:a.sources,viewMode:"small"}),a.allowHash?r.createElement("div",{className:"tcfLinkWidget--editorHash tcfInput--group"},r.createElement("div",{className:"tcfInput--groupLabel"},"#"),r.createElement(Hn,{disabled:t,value:n.hash,onChange:function(e){return o(Object.assign(Object.assign({},n),{hash:e.currentTarget.value}))}})):null)}function Mr(e){var t=e.disabled,n=e.link,a=e.linkType,i=e.onUpdate
return r.createElement("div",{className:"tcfLinkWidget--editor"},r.createElement(Hn,{disabled:t,type:a.inputType,value:n.url,onChange:function(e){return i(Object.assign(Object.assign({},n),{url:e.currentTarget.value}))}}))}function Ar(e){return"object"===s()(e)&&"number"==typeof e.elementId&&"string"==typeof e.hash&&"string"==typeof e.type&&"string"==typeof e.url}n(305)
function Dr(e){var t,n=e.data,a=e.disabled,i=e.field,c=e.model,o=e.onUpdate
t=Ar(n)?n:{elementId:0,hash:"",openInNewWindow:!1,type:"",url:""}
var l,u=i.linkTypes[t.type]
u&&"input"===u.type?l=r.createElement(Mr,{disabled:a,key:t.type,link:t,linkType:u,onUpdate:o}):u&&"element"===u.type&&(l=r.createElement(Ir,{disabled:a,key:t.type,link:t,linkType:u,modalStorageKey:"tcf_".concat(c.__type,"_").concat(i.name,"_").concat(u.type),onUpdate:o}))
var s=i.allowNewWindow
return r.createElement("div",{className:"tcfLinkWidget"},r.createElement("div",{className:"tcfLinkWidget--type"},r.createElement(qe,{disabled:a,options:Object.keys(i.linkTypes).map((function(e){return{key:e,label:i.linkTypes[e].label}})),value:t.type,onChange:function(e){return o(Object.assign(Object.assign({},t),{type:e}))}})),l,s?r.createElement(Nn,{disabled:a,onChange:function(e){return o(Object.assign(Object.assign({},t),{openInNewWindow:e}))},value:t.openInNewWindow},r.createElement(De,{value:"New window"})):null)}function Pr(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1
if(Reflect.construct.sham)return!1
if("function"==typeof Proxy)return!0
try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}()
return function(){var n,r=Ze()(e)
if(t){var a=Ze()(this).constructor
n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments)
return Je()(this,n)}}var Lr=function(e){Ge()(n,e)
var t=Pr(n)
function n(){return k()(this,n),t.call(this,{widget:Dr})}return O()(n,[{key:"createValue",value:function(){return{elementId:0,hash:"",openInNewWindow:!1,type:"url",url:""}}},{key:"isValue",value:function(e,t){return Ar(t)}},{key:"preview",value:function(){return""}}]),n}(wn),Tr=function(){function e(t){k()(this,e),this.latitude=t.latitude,this.longitude=t.longitude}return O()(e,[{key:"createStaticMap",value:function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:100,t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:75,n=this.latitude,r=this.longitude,a=be()
if(!a)return new ve.SafeString("")
var i=["key=".concat(a),"center=".concat(encodeURIComponent("".concat(n,",").concat(r))),"markers=".concat(encodeURIComponent("size:small|".concat(n,",").concat(r))),"size=".concat(e,"x").concat(t),"zoom=15","maptype=roadmap"].join("&")
return new ve.SafeString('\n      <img src="https://maps.googleapis.com/maps/api/staticmap?'.concat(i,'" width="').concat(e,'" height="').concat(t,'" />\n    '))}},{key:"toHTML",value:function(){return this.createStaticMap()}}]),e}()
Object(K.b)([Tt],Tr.prototype,"latitude",void 0),Object(K.b)([Tt],Tr.prototype,"longitude",void 0),Object(K.b)([Lt],Tr.prototype,"createStaticMap",null),Object(K.b)([Lt],Tr.prototype,"toHTML",null)
n(306),n(307)
function Ur(e){var t=e.results,n=e.onSelect
return r.createElement("div",{className:""},t.map((function(e){return r.createElement("div",{onClick:function(){return n(e)}},e.formatted_address)})))}function Fr(e,t){var n
if("undefined"==typeof Symbol||null==e[Symbol.iterator]){if(Array.isArray(e)||(n=function(e,t){if(!e)return
if("string"==typeof e)return Vr(e,t)
var n=Object.prototype.toString.call(e).slice(8,-1)
"Object"===n&&e.constructor&&(n=e.constructor.name)
if("Map"===n||"Set"===n)return Array.from(e)
if("Arguments"===n||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n))return Vr(e,t)}(e))||t&&e&&"number"==typeof e.length){n&&(e=n)
var r=0,a=function(){}
return{s:a,n:function(){return r>=e.length?{done:!0}:{done:!1,value:e[r++]}},e:function(e){throw e},f:a}}throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}var i,c=!0,o=!1
return{s:function(){n=e[Symbol.iterator]()},n:function(){var e=n.next()
return c=e.done,e},e:function(e){o=!0,i=e},f:function(){try{c||null==n.return||n.return()}finally{if(o)throw i}}}}function Vr(e,t){(null==t||t>e.length)&&(t=e.length)
for(var n=0,r=new Array(t);n<t;n++)r[n]=e[n]
return r}function Wr(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1
if(Reflect.construct.sham)return!1
if("function"==typeof Proxy)return!0
try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}()
return function(){var n,r=Ze()(e)
if(t){var a=Ze()(this).constructor
n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments)
return Je()(this,n)}}var Hr=["address","street","country","zip","city"],Br=function(e){Ge()(n,e)
var t=Wr(n)
function n(){var e
return k()(this,n),(e=t.apply(this,arguments)).autocomplete=null,e.input=null,e.state={isSearching:!1},e.handlePlaceChanged=function(){var t=mt()(e).autocomplete
if(t){var n=t.getPlace()
n.geometry&&e.props.onLocation({latitude:n.geometry.location.lat(),longitude:n.geometry.location.lng()})}},e.handleResolve=function(){var t=e.props.places
t&&(e.setState({isSearching:!0}),t.findPlaceFromQuery({query:e.getResolveQuery(),fields:["formatted_address","geometry"]},e.handleResolveResults))},e.handleResolveResults=function(t){e.setState({isSearching:!1}),t||(t=[]),1===t.length?e.handleResultsSelect(t[0]):e.setState({results:t})},e.handleResultsSelect=function(t){var n=t.geometry
if(n){var r=n.location
e.props.onLocation({latitude:r.lat(),longitude:r.lng()}),e.handleResultsCancel()}},e.handleResultsCancel=function(){e.state.results&&e.setState({results:void 0})},e.setInput=function(t){var n=mt()(e).autocomplete
e.input=t,n&&(n.unbindAll(),n=null),t&&((n=new google.maps.places.Autocomplete(t)).setFields(["geometry"]),n.addListener("place_changed",e.handlePlaceChanged)),e.autocomplete=n},e}return O()(n,[{key:"canResolve",value:function(){return""!==this.getResolveQuery()}},{key:"getResolveQuery",value:function(){var e,t=this.props.model,n=[],r=Fr(Hr)
try{for(r.s();!(e=r.n()).done;){var a=e.value
a in t&&"string"==typeof t[a]&&n.push(t[a].trim())}}catch(e){r.e(e)}finally{r.f()}return n.join(", ")}},{key:"render",value:function(){var e
if(this.canResolve()){var t,n=this.state.results
n&&0===n.length?t=r.createElement(rr,{icon:"material:error"},"No locations found"):n&&(t=r.createElement(Ur,{onSelect:this.handleResultsSelect,results:n})),e=r.createElement("div",{className:"tcfLocationFieldSearch--resolve"},t?r.createElement(on,{onClick:this.handleResultsCancel},t):null,r.createElement(Ae,{onClick:this.handleResolve},r.createElement(De,{value:"Resolve address"})))}return r.createElement("div",{className:"tcfLocationFieldSearch"},e,r.createElement("input",{className:"tcfLocationFieldSearch--input tcfInput",ref:this.setInput,type:"search"}))}}]),n}(r.Component)
function qr(e){return"object"===s()(e)&&"number"==typeof e.latitude&&"number"==typeof e.longitude}n(308)
function zr(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1
if(Reflect.construct.sham)return!1
if("function"==typeof Proxy)return!0
try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}()
return function(){var n,r=Ze()(e)
if(t){var a=Ze()(this).constructor
n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments)
return Je()(this,n)}}var $r
!function(e){e[e.Loading=0]="Loading",e[e.Error=1]="Error",e[e.Ready=2]="Ready"}($r||($r={}))
var Xr=function(e){Ge()(n,e)
var t=zr(n)
function n(){var e
return k()(this,n),(e=t.apply(this,arguments)).element=null,e.marker=null,e.state={instance:null,loadState:$r.Loading},e.handleLocation=function(t){var n=e.state.instance
n&&(n.map.setZoom(17),n.map.setCenter({lat:t.latitude,lng:t.longitude})),e.props.onUpdate(t)},e.handleMarkerDragEnd=function(){var t=mt()(e).marker
if(t){var n=t.getPosition()
n&&e.props.onUpdate({latitude:n.lat(),longitude:n.lng()})}},e.setElement=function(t){var r=e.props.disabled,a=e.state.instance,i=mt()(e).marker
if(a&&(n.stashInstance(a),a=null),i&&(i.setMap(null),i.unbindAll(),i=null),t){a=n.createInstance(),t.appendChild(a.element)
var c=a.map
c.setZoom(17),c.setCenter(e.getLatLng()),(i=new google.maps.Marker({draggable:!r,position:e.getLatLng(),map:c})).addListener("dragend",e.handleMarkerDragEnd)}e.element=t,e.marker=i,e.setState({instance:a})},e}return O()(n,[{key:"componentDidUpdate",value:function(e){var t=this.marker
e.disabled!==this.props.disabled&&t&&t.setOptions({draggable:!this.props.disabled})}},{key:"componentWillMount",value:function(){var e=this
try{(ge||(ge=new Promise((function(e){window.onGoogleMapsReady=function(){de.Loaded,e(google.maps)}
var t=document.createElement("script")
t.src="https://maps.googleapis.com/maps/api/js?key=".concat(me,"&libraries=places&callback=onGoogleMapsReady"),(document.head||document.body).appendChild(t),ge=ge,de.Loading})))).then((function(){e.setState({loadState:$r.Ready})}))}catch(e){this.setState({loadState:$r.Error})}}},{key:"getLatLng",value:function(){var e=this.props.data
return qr(e)?{lat:e.latitude,lng:e.longitude}:{lat:0,lng:0}}},{key:"render",value:function(){var e,t=this.state,n=t.loadState,a=t.instance,i=this.props,c=i.disabled,o=i.model,l=this.marker
return l&&l.setPosition(this.getLatLng()),e=n===$r.Loading?r.createElement(bt,null):n===$r.Error?r.createElement(ar,{title:"Could not load Google Maps"}):r.createElement(r.Fragment,null,c?null:r.createElement(Br,{model:o,onLocation:this.handleLocation,places:a?a.places:null}),r.createElement("div",{className:"tcfLocation--map",ref:this.setElement})),r.createElement("div",{className:"tcfLocation"},e)}}],[{key:"createInstance",value:function(){var e=this.instanceStash.pop()
if(!e){var t=document.createElement("div")
t.className="tcfLocation--mapInstance"
var n=new google.maps.Map(t,{mapTypeControl:!1,streetViewControl:!1})
e={element:t,map:n,places:new google.maps.places.PlacesService(n)}}return e}},{key:"stashInstance",value:function(e){var t=e.element,n=t.parentElement
n&&n.removeChild(t),this.instanceStash.push(e)}}]),n}(r.Component)
function Kr(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1
if(Reflect.construct.sham)return!1
if("function"==typeof Proxy)return!0
try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}()
return function(){var n,r=Ze()(e)
if(t){var a=Ze()(this).constructor
n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments)
return Je()(this,n)}}Xr.instanceStash=[]
var Gr=function(e){Ge()(n,e)
var t=Kr(n)
function n(){return k()(this,n),t.call(this,{widget:Xr})}return O()(n,[{key:"createValue",value:function(e){var t=e.field
return qr(t.defaultValue)?Object.assign({},t.defaultValue):{latitude:0,longitude:0}}},{key:"isValue",value:function(e,t){return qr(t)}},{key:"preview",value:function(e){var t=e.value
return new Tr(t)}}]),n}(wn)
n(309)
function Yr(e){var t=e.data,n=e.disabled,a=e.errors,i=e.field,c=e.onUpdate,o=r.useState(!1),l=_e()(o,2),u=l[0],s=l[1],f=r.useState(t),d=_e()(f,2),m=d[0],p=d[1],h=i.max,v=i.min,y=i.placeholder,g=i.unit,b=u?m:t
var E=r.createElement("input",{autoComplete:"off",className:xe()("tcfNumberWidget--input text fullwidth",{error:a&&a.length}),disabled:n,max:null===h?void 0:h,min:null===v?void 0:v,onBlur:function(){s(!1),p(t)},onChange:function(e){var t=e.target.value
p(t),c(function(e,t){var n=e.dataType,r=e.defaultValue,a=e.max,i=e.min,c=e.optional,o="integer"===n?parseInt(t):parseFloat(t)
if(isFinite(o))"number"==typeof a&&o>a&&(o=a),"number"==typeof i&&o<i&&(o=i)
else{if(c)return null
o=r}return o}(i,t))},onFocus:function(){s(!0)},placeholder:y,type:"number",value:b})
return g?r.createElement("div",{className:"tcfNumberWidget"},E,r.createElement("div",{className:"tcfNumberWidget--unit"},g)):E}function Jr(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1
if(Reflect.construct.sham)return!1
if("function"==typeof Proxy)return!0
try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}()
return function(){var n,r=Ze()(e)
if(t){var a=Ze()(this).constructor
n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments)
return Je()(this,n)}}function Qr(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1
if(Reflect.construct.sham)return!1
if("function"==typeof Proxy)return!0
try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}()
return function(){var n,r=Ze()(e)
if(t){var a=Ze()(this).constructor
n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments)
return Je()(this,n)}}var Zr=function(e){Ge()(n,e)
var t=Qr(n)
function n(){return k()(this,n),t.call(this,{widget:Yr})}return n}(function(e){Ge()(n,e)
var t=Jr(n)
function n(){return k()(this,n),t.apply(this,arguments)}return O()(n,[{key:"cloneValue",value:function(e){return Object(K.a)(this,void 0,void 0,X.a.mark((function t(){var n,r,a
return X.a.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return n=e.field,r=e.schemas,a=e.value,t.abrupt("return",this.isValue(n,a)?a:this.createValue({field:n,schemas:r}))
case 2:case"end":return t.stop()}}),t,this)})))}},{key:"createValue",value:function(e){return e.field.defaultValue}},{key:"isValue",value:function(e,t){return!(!e.optional||null!==t)||("number"==typeof t||t instanceof Number)}},{key:"preview",value:function(e){return e.value}}]),n}(wn)),ea=function(){function e(t){k()(this,e),this.value=t}return O()(e,[{key:"toHTML",value:function(){return new ve.SafeString(this.value)}},{key:"summary",get:function(){return new ve.SafeString('<div class="snippet">'.concat(this.value,"</div>"))}}]),e}()
function ta(e){var t=e.value
return r.createElement("div",{className:"redactor-box redactor-styles-on redactor-toolbar-on focusable-input redactor-focus focus"},r.createElement("div",{className:"redactor-styles redactor-in redactor-in-0",dangerouslySetInnerHTML:{__html:t}}))}Object(K.b)([Tt],ea.prototype,"value",void 0),Object(K.b)([Lt],ea.prototype,"summary",null),Object(K.b)([Lt],ea.prototype,"toHTML",null)
n(310)
function na(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1
if(Reflect.construct.sham)return!1
if("function"==typeof Proxy)return!0
try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}()
return function(){var n,r=Ze()(e)
if(t){var a=Ze()(this).constructor
n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments)
return Je()(this,n)}}var ra=function(e){Ge()(n,e)
var t=na(n)
function n(){var e
return k()(this,n),(e=t.apply(this,arguments)).element=null,e.hasFocus=!1,e.instance=null,e.renderedValue="",e.uuid="element-".concat(j()),e.handleBlur=function(){e.hasFocus=!1},e.handleChange=function(t){e.hasFocus&&(e.renderedValue=t,e.props.onUpdate(t))},e.handleFocus=function(){e.hasFocus=!0},e.setElement=function(t){if(e.element!==t){e.element=t
var n=e.props,r=n.elementSiteId,a=n.options,i=mt()(e).instance
i&&(i.redactor&&(i.redactor.off("blur",e.handleBlur),i.redactor.off("changed",e.handleChange),i.redactor.off("focus",e.handleFocus)),i.destroy(),i=null),t&&(i=new Craft.RedactorInput(Object.assign(Object.assign({},a),{elementSiteId:r,id:e.uuid,redactorConfig:Object.assign({},a.redactorConfig)})),t.removeAttribute("name"),i.redactor&&(i.redactor.on("blur",e.handleBlur),i.redactor.on("changed",e.handleChange),i.redactor.on("focus",e.handleFocus))),e.instance=i}},e}return O()(n,[{key:"componentDidUpdate",value:function(){var e=this.hasFocus,t=this.instance,n=this.props,r=this.renderedValue
t&&!e&&n.value!=r&&(this.renderedValue=n.value,t.redactor.source.setCode(n.value))}},{key:"render",value:function(){var e=this.props.value
return r.createElement("div",{className:"tcfRedactorWidget"},r.createElement("textarea",{defaultValue:"string"==typeof e?e:"",id:this.uuid,ref:this.setElement}))}}]),n}(r.Component)
function aa(e){return e.disabled?r.createElement(ta,Object.assign({},e)):r.createElement(ra,Object.assign({},e))}var ia=Object(o.b)((function(e){return{elementSiteId:e.config.elementSiteId}}))((function(e){var t=e.data,n=e.disabled,a=e.elementSiteId,i=e.field,c=e.onUpdate
return i.redactor?r.createElement(aa,{disabled:n,elementSiteId:a,onUpdate:c,options:i.redactor,value:t}):null})),ca=0
function oa(e,t){return Object(K.a)(this,void 0,void 0,X.a.mark((function n(){var r,a,i,c
return X.a.wrap((function(n){for(;;)switch(n.prev=n.next){case 0:if(!(ca>2)){n.next=3
break}return console.warn('Translator has returned to many errors, skipping translation for text "'.concat(e,'".')),n.abrupt("return",e)
case 3:return r=t.endpoint,a=Object(K.c)(t,["endpoint"]),i=Object.assign(Object.assign({},a),{text:e}),c=Object.keys(i).map((function(e){return"".concat(e,"=").concat(encodeURIComponent(i[e]))})).join("&"),n.abrupt("return",new Promise((function(t){fetch("".concat(r,"&").concat(c)).then((function(e){return e.json()})).then((function(n){t(n&&n.data?n.data:e)})).catch((function(n){console.error("Translator returned an error: ".concat(n)),ca+=1,t(e)}))})))
case 7:case"end":return n.stop()}}),n)})))}function la(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1
if(Reflect.construct.sham)return!1
if("function"==typeof Proxy)return!0
try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}()
return function(){var n,r=Ze()(e)
if(t){var a=Ze()(this).constructor
n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments)
return Je()(this,n)}}var ua=function(e){Ge()(n,e)
var t=la(n)
function n(){return k()(this,n),t.apply(this,arguments)}return O()(n,[{key:"cloneValue",value:function(e){return Object(K.a)(this,void 0,void 0,X.a.mark((function t(){var n,r,a
return X.a.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:if(n=e.field,r=e.translate,a=e.value,!this.isValue(n,a)){t.next=9
break}if(!n.translatable||!r){t.next=6
break}return t.abrupt("return",oa(a,r))
case 6:return t.abrupt("return",a)
case 7:t.next=10
break
case 9:return t.abrupt("return","")
case 10:case"end":return t.stop()}}),t,this)})))}},{key:"createValue",value:function(e){return""}},{key:"isValue",value:function(e,t){return"string"==typeof t||t instanceof String}},{key:"preview",value:function(e){return e.value}}]),n}(wn)
function sa(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1
if(Reflect.construct.sham)return!1
if("function"==typeof Proxy)return!0
try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}()
return function(){var n,r=Ze()(e)
if(t){var a=Ze()(this).constructor
n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments)
return Je()(this,n)}}var fa=function(e){Ge()(n,e)
var t=sa(n)
function n(){return k()(this,n),t.call(this,{widget:ia})}return O()(n,[{key:"preview",value:function(e){var t=e.value
return new ea(t)}}]),n}(ua)
n(311)
function da(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1
if(Reflect.construct.sham)return!1
if("function"==typeof Proxy)return!0
try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}()
return function(){var n,r=Ze()(e)
if(t){var a=Ze()(this).constructor
n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments)
return Je()(this,n)}}function ma(e,t){var n
if("undefined"==typeof Symbol||null==e[Symbol.iterator]){if(Array.isArray(e)||(n=function(e,t){if(!e)return
if("string"==typeof e)return pa(e,t)
var n=Object.prototype.toString.call(e).slice(8,-1)
"Object"===n&&e.constructor&&(n=e.constructor.name)
if("Map"===n||"Set"===n)return Array.from(e)
if("Arguments"===n||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n))return pa(e,t)}(e))||t&&e&&"number"==typeof e.length){n&&(e=n)
var r=0,a=function(){}
return{s:a,n:function(){return r>=e.length?{done:!0}:{done:!1,value:e[r++]}},e:function(e){throw e},f:a}}throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}var i,c=!0,o=!1
return{s:function(){n=e[Symbol.iterator]()},n:function(){var e=n.next()
return c=e.done,e},e:function(e){o=!0,i=e},f:function(){try{c||null==n.return||n.return()}finally{if(o)throw i}}}}function pa(e,t){(null==t||t>e.length)&&(t=e.length)
for(var n=0,r=new Array(t);n<t;n++)r[n]=e[n]
return r}var ha=function(){function e(t){k()(this,e),this.reference=t}return O()(e,[{key:"createPreview",value:function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"large",t=!(arguments.length>1&&void 0!==arguments[1])||arguments[1],n=this.reference,r=n.$element.clone(!1,!0)
r.removeClass("large removable small"),r.addClass(e)
var a=r.find(".elementthumb")
if(a.length){var i=a.find("img")[0]
i||((i=document.createElement("img")).srcset=a.attr("data-srcset")||"",a.append(i)),i.sizes="small"===e?"30px":"100px"}return t?'<div class="tcfInstancePreview--thumb '.concat(e,'">').concat(a?a.html():"","</div>"):r[0].outerHTML}},{key:"createSafePreview",value:function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"large",t=!(arguments.length>1&&void 0!==arguments[1])||arguments[1]
return new ve.SafeString(this.createPreview(e,t))}},{key:"toHTML",value:function(){return new ve.SafeString(this.toString())}},{key:"toString",value:function(){return this.createPreview()}},{key:"asBackground",get:function(){var e=this.reference.$element.find(".elementthumb").attr("data-srcset")
if(!e)return null
var t=e.split(",").pop()
return t?new ve.SafeString('<div class="tcfInstancePreview--background" style="background-image: url(\''.concat(t.trim(),'\');"></div><div class="tcfInstancePreview--background blur" style="background-image: url(\'').concat(t.trim(),"');\"></div>")):null}},{key:"asLargeElement",get:function(){return this.createSafePreview("large",!1)}},{key:"asLargeImage",get:function(){return this.createSafePreview("large",!0)}},{key:"asSmallElement",get:function(){return this.createSafePreview("small",!1)}},{key:"asSmallImage",get:function(){return this.createSafePreview("small",!0)}},{key:"label",get:function(){return this.reference.label}}]),e}()
Object(K.b)([Tt],ha.prototype,"reference",void 0),Object(K.b)([Lt],ha.prototype,"createPreview",null),Object(K.b)([Lt],ha.prototype,"createSafePreview",null),Object(K.b)([Tt],ha.prototype,"asBackground",null),Object(K.b)([Tt],ha.prototype,"asLargeElement",null),Object(K.b)([Tt],ha.prototype,"asLargeImage",null),Object(K.b)([Tt],ha.prototype,"asSmallElement",null),Object(K.b)([Tt],ha.prototype,"asSmallImage",null),Object(K.b)([Tt],ha.prototype,"label",null),Object(K.b)([Lt],ha.prototype,"toHTML",null),Object(K.b)([Lt],ha.prototype,"toString",null)
var va=function(e){Ge()(n,e)
var t=da(n)
function n(e){return k()(this,n),t.call.apply(t,[this].concat(A()(function(e){var t=e.context.references,n=e.field,r=e.value,a=[]
if(!n)return a
var i,c=n.elementType,o=ma(r)
try{var l=function(){var e=i.value,n=t.find((function(t){return t.id===e&&t.type===c}))
n&&a.push(new ha(n))}
for(o.s();!(i=o.n()).done;)l()}catch(e){o.e(e)}finally{o.f()}return a}(e))))}return O()(n,[{key:"toHTML",value:function(){return new ve.SafeString('<div class="tcfInstancePreview--elements">'.concat(this.toString(),"</div>"))}},{key:"toString",value:function(){return this._map((function(e){return At(e)})).join("")}},{key:"_map",value:function(e){for(var t=[],n=0;n<this.length;n++)t.push(e(this[n],n))
return t}},{key:"asBackground",get:function(){return this.length?this[0].asBackground:null}},{key:"asLargeElement",get:function(){return this.length?this[0].asLargeElement:null}},{key:"asLargeImage",get:function(){return this.length?this[0].asLargeImage:null}},{key:"asSmallElement",get:function(){return this.length?this[0].asSmallElement:null}},{key:"asSmallImage",get:function(){return this.length?this[0].asSmallImage:null}},{key:"firstLabel",get:function(){return this.length?this[0].label:""}},{key:"label",get:function(){return this._map((function(e){return e.label})).join(", ")}}]),n}(Mt()(Array))
function ya(e){var t=e.data,n=e.disabled,a=e.field,i=e.model,c=e.onUpdate
return r.createElement(_r,{criteria:a.criteria,disabled:n,data:t,elementType:a.elementType,limit:a.limit||null,modalStorageKey:a.modalStorageKey||"tcf_".concat(i.__type,"_").concat(a.name),onUpdate:c,sources:a.sources||null,viewMode:a.viewMode})}function ga(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1
if(Reflect.construct.sham)return!1
if("function"==typeof Proxy)return!0
try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}()
return function(){var n,r=Ze()(e)
if(t){var a=Ze()(this).constructor
n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments)
return Je()(this,n)}}Object(K.b)([Tt],va.prototype,"asBackground",null),Object(K.b)([Tt],va.prototype,"asLargeElement",null),Object(K.b)([Tt],va.prototype,"asLargeImage",null),Object(K.b)([Tt],va.prototype,"asSmallElement",null),Object(K.b)([Tt],va.prototype,"asSmallImage",null),Object(K.b)([Tt],va.prototype,"firstLabel",null),Object(K.b)([Tt],va.prototype,"label",null),Object(K.b)([Lt],va.prototype,"toHTML",null),Object(K.b)([Lt],va.prototype,"toString",null)
var ba=function(e){Ge()(n,e)
var t=ga(n)
function n(){return k()(this,n),t.call(this,{widget:ya})}return O()(n,[{key:"createValue",value:function(e){return[]}},{key:"isValue",value:function(e,t){return Array.isArray(t)&&t.every((function(e){return"number"==typeof e}))}},{key:"preview",value:function(e){return new va(e)}}]),n}(wn)
function Ea(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1
if(Reflect.construct.sham)return!1
if("function"==typeof Proxy)return!0
try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}()
return function(){var n,r=Ze()(e)
if(t){var a=Ze()(this).constructor
n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments)
return Je()(this,n)}}var wa=function(e){Ge()(n,e)
var t=Ea(n)
function n(){return k()(this,n),t.apply(this,arguments)}return O()(n,[{key:"createValue",value:function(e){var t=e.field
return t.defaultValue&&this.isValue(t,t.defaultValue)?t.defaultValue:t.options[0].key}},{key:"isValue",value:function(e,t){return e.options.some((function(e){return e.key==t}))}},{key:"preview",value:function(e){var t=e.field,n=e.value,r=t?t.options.find((function(e){return e.key===n})):void 0
return r?r.label:"-"}}]),n}(wn)
function ka(e){var t=e.data,n=e.disabled,a=e.onUpdate,i=e.field
return r.createElement(qe,{disabled:n,onChange:a,options:i.options,value:t})}function Sa(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1
if(Reflect.construct.sham)return!1
if("function"==typeof Proxy)return!0
try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}()
return function(){var n,r=Ze()(e)
if(t){var a=Ze()(this).constructor
n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments)
return Je()(this,n)}}var Oa=function(e){Ge()(n,e)
var t=Sa(n)
function n(){return k()(this,n),t.call(this,{widget:ka})}return n}(wa)
n(312)
function Ca(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1
if(Reflect.construct.sham)return!1
if("function"==typeof Proxy)return!0
try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}()
return function(){var n,r=Ze()(e)
if(t){var a=Ze()(this).constructor
n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments)
return Je()(this,n)}}function ja(e){var t
return e&&(t="color"in e?e.color:e.label),"string"==typeof t?t:"transparent"}var xa=function(e){Ge()(n,e)
var t=Ca(n)
function n(){var e
return k()(this,n),(e=t.apply(this,arguments)).state={isExpanded:!1},e.handleFlyoutClick=function(){e.setState({isExpanded:!1})},e.handleSelect=function(t){e.props.onUpdate(t.key),e.setState({isExpanded:!1})},e.handleSwatchClick=function(t){t.currentTarget===t.target&&e.setState({isExpanded:!0})},e}return O()(n,[{key:"render",value:function(){var e=this.props,t=e.data,n=e.disabled,a=e.field,i=this.state.isExpanded,c=a.options.find((function(e){return e.key===t}))
return r.createElement("div",{className:xe()("tcfSwatchColorWidget",{isUndecided:!c}),onClick:n?void 0:this.handleSwatchClick,style:{background:c?ja(c):void 0}},i&&!n?this.renderFlyout(c):null)}},{key:"renderFlyout",value:function(e){var t=this,n=this.props.field
return r.createElement(on,{onClick:this.handleFlyoutClick},r.createElement("div",{className:"tcfSwatchColorWidget--swatches"},n.options.map((function(n){return r.createElement("div",{className:xe()("tcfSwatchColorWidget--swatch",{isSelected:n===e}),key:n.key,onClick:function(){return t.handleSelect(n)},style:{background:ja(n)}})}))))}}]),n}(r.Component)
function Ra(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1
if(Reflect.construct.sham)return!1
if("function"==typeof Proxy)return!0
try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}()
return function(){var n,r=Ze()(e)
if(t){var a=Ze()(this).constructor
n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments)
return Je()(this,n)}}var Na=function(e){Ge()(n,e)
var t=Ra(n)
function n(){return k()(this,n),t.call(this,{widget:xa})}return n}(wa)
function _a(e){var t=e.data,n=e.disabled,a=e.errors,i=e.field,c=i.maxLength,o=i.minLength,l=i.placeholder,u=i.inputType,s=e.onUpdate
return r.createElement("input",{autoComplete:"off",className:xe()("tcfTextWidget text fullwidth",{error:a&&a.length}),disabled:n,maxLength:c,minLength:o,onChange:function(e){return s(e.target.value)},placeholder:l,type:u,value:t?"".concat(t):""})}function Ia(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1
if(Reflect.construct.sham)return!1
if("function"==typeof Proxy)return!0
try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}()
return function(){var n,r=Ze()(e)
if(t){var a=Ze()(this).constructor
n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments)
return Je()(this,n)}}var Ma=function(e){Ge()(n,e)
var t=Ia(n)
function n(){return k()(this,n),t.call(this,{widget:_a})}return n}(ua)
n(313)
function Aa(e){var t=e.data,n=e.disabled,a=e.field,i=a.maxLength,c=a.minLength,o=a.monospace,l=a.placeholder,u=a.rows,s=e.onUpdate
return r.createElement("textarea",{className:xe()("tcfTextareaWidget text fullwidth",{monospace:o}),disabled:n,maxLength:i,minLength:c,onChange:function(e){return s(e.target.value)},placeholder:l,rows:u,value:t})}function Da(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1
if(Reflect.construct.sham)return!1
if("function"==typeof Proxy)return!0
try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}()
return function(){var n,r=Ze()(e)
if(t){var a=Ze()(this).constructor
n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments)
return Je()(this,n)}}var Pa=function(e){Ge()(n,e)
var t=Da(n)
function n(){return k()(this,n),t.call(this,{widget:Aa})}return n}(ua)
C.initialize({array:new Cn,checkbox:new Mn,color:new tr,instance:new br,lightswitch:new kr,link:new Lr,location:new Gr,number:new Zr,oembed:new fr,redactor:new fa,reference:new ba,select:new Oa,swatchcolor:new Na,text:new Ma,textarea:new Pa})
n(314)
function La(e,t){var n
if("undefined"==typeof Symbol||null==e[Symbol.iterator]){if(Array.isArray(e)||(n=function(e,t){if(!e)return
if("string"==typeof e)return Ta(e,t)
var n=Object.prototype.toString.call(e).slice(8,-1)
"Object"===n&&e.constructor&&(n=e.constructor.name)
if("Map"===n||"Set"===n)return Array.from(e)
if("Arguments"===n||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n))return Ta(e,t)}(e))||t&&e&&"number"==typeof e.length){n&&(e=n)
var r=0,a=function(){}
return{s:a,n:function(){return r>=e.length?{done:!0}:{done:!1,value:e[r++]}},e:function(e){throw e},f:a}}throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}var i,c=!0,o=!1
return{s:function(){n=e[Symbol.iterator]()},n:function(){var e=n.next()
return c=e.done,e},e:function(e){o=!0,i=e},f:function(){try{c||null==n.return||n.return()}finally{if(o)throw i}}}}function Ta(e,t){(null==t||t>e.length)&&(t=e.length)
for(var n=0,r=new Array(t);n<t;n++)r[n]=e[n]
return r}var Ua=[],Fa={},Va={create:function(e){try{var t=null,n=document.getElementById(e)
if(!n)throw new Error("Root element not found.")
var l=n.querySelector(".tcfField--app"),u=n.querySelector('script[type="application/json"]'),s=n.querySelector("input.tcfField--model")
if(!s||!l||!u)throw new Error("Missing components.")
var f=Object(c.c)(_t,Se(u,s),Object(c.a)(i.a))
Ua.push(f),f.subscribe((function(){var e=window.draftEditor,n=JSON.stringify(f.getState().model)
s.value!==n&&e&&(t&&window.clearTimeout(t),t=window.setTimeout((function(){e.checkForm(),t=null}),500)),s.value=n})),a.render(r.createElement(o.a,{store:f},r.createElement(Nt,null)),l)}catch(e){console.error("Could not start content editor: "+e.message)}},getInstanceApi:function(e){var t,n=La(Ua)
try{for(n.s();!(t=n.n()).done;){var r=t.value,a=d(r.getState(),e)
return a?fe(r,a):null}}catch(e){n.e(e)}finally{n.f()}},getValidator:function(e){return e in Fa?Fa[e]:null},registerValidator:function(e,t){Fa[e]=t}}
window&&(window.contentField=Va)
var Wa=t.default=Va}})
