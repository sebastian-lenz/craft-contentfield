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
i.push([322,1]),n()}({167:function(e,t,n){},168:function(e,t,n){},172:function(e,t){e.exports=jQuery},264:function(e,t,n){},268:function(e,t,n){},269:function(e,t,n){},270:function(e,t,n){},271:function(e,t,n){},273:function(e,t,n){},274:function(e,t,n){},278:function(e,t,n){},279:function(e,t,n){},280:function(e,t,n){},281:function(e,t,n){},282:function(e,t,n){},283:function(e,t,n){},288:function(e,t,n){},289:function(e,t,n){},290:function(e,t,n){},291:function(e,t,n){},292:function(e,t,n){},293:function(e,t,n){},294:function(e,t,n){},295:function(e,t,n){},296:function(e,t,n){},297:function(e,t,n){},298:function(e,t,n){},299:function(e,t,n){},300:function(e,t,n){},301:function(e,t,n){},302:function(e,t,n){},303:function(e,t,n){},304:function(e,t,n){},305:function(e,t,n){},307:function(e,t,n){},308:function(e,t,n){},309:function(e,t,n){},310:function(e,t,n){},311:function(e,t,n){},312:function(e,t,n){},313:function(e,t,n){},314:function(e,t,n){},315:function(e,t,n){},316:function(e,t,n){},317:function(e,t,n){},319:function(e,t,n){},320:function(e,t,n){},321:function(e,t,n){},322:function(e,t,n){"use strict"
n.r(t)
var r=n(0),a=n(62),i=n(170),c=n(51),o=n(10)
n(13),n(9),n(57),n(29)
function l(e,t){var n=e.schemas[t.__type]
if(!n)throw new Error('Could not resolve schema "'.concat(t.__type,'".'))
return n}var u=n(16),s=n.n(u)
function f(e){return e&&"object"===s()(e)&&"__type"in e&&"__uuid"in e}function d(e,t){return function e(t,n,r){if(f(r)&&r.__uuid===n)return{model:r,path:[],uuid:n}
for(var a=l(t,r),i=0,c=Object.keys(a.fields);i<c.length;i++){var o=c[i],u=a.fields[o]
if("array"===u.type&&"instance"===u.member.type){var s=r[o]
if(!Array.isArray(s))continue
for(var d=0;d<s.length;d++){var m=e(t,n,s[d])
if(null!==m)return m.path.unshift({type:"index",name:o,index:d}),m}}else if("instance"===u.type){var p=e(t,n,r[o])
if(null!==p)return p.path.unshift({type:"property",name:o}),p}else if("layout"===u.type)for(var h=r[o].columns,v=0;v<h.length;v++){var y=e(t,n,h[v])
if(null!==y)return y.path.unshift({type:"property",name:o},{type:"index",name:"columns",index:v}),y}}return null}(e,t,e.model)}n(14),n(42),n(24),n(58)
function m(e){for(var t=[],n=e;n.length;){var r=/^([^\[\.]+)(?:\[(\d+)\])?\.?/.exec(n)
if(!r)throw new Error('Invalid path segment "'.concat(n,'" in path "').concat(e,'".'))
n=n.substr(r[0].length),3===r.length?t.push({index:parseInt(r[1]),name:r[2],type:"index"}):t.push({name:r[1],type:"property"})}return t}function p(e,t){if(!(t.name in e))return null
var n=e[t.name]
return"index"===t.type?!Array.isArray(n)||t.index<0||t.index>=n.length?null:n[t.index]:n}function h(e,t){"string"==typeof t&&(t=m(t))
for(var n=e,r=0;r<t.length;r++)if(!(n=p(n,t[r])))return null
return f(n)?n:null}function v(e,t){var n=(t="string"==typeof t?m(t):t.slice()).pop()
if(!n)return null
var r=h(e.model,t)
if(!r)throw new Error("Could not resolve owner")
var a=l(e,r),i="index"===n.type?n.index:void 0,c=a.fields[n.name]
if(!c)throw new Error('Could not resolve field "'.concat(n.name,'" on schema "').concat(a.qualifier,'".'))
return{field:c,index:i,owner:r,path:t,schema:a}}function y(e,t){return Craft.t("contentfield",e,t)}n(81)
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
return r}function E(e){return{references:e,type:"addReferences"}}var w=n(3),k=n.n(w),S=n(6),O=n.n(S),C=new(function(){function e(){k()(this,e)}return O()(e,[{key:"initialize",value:function(e){this.definitions=e}},{key:"createValue",value:function(e){return this.getDefinition(e.field).createValue(e)}},{key:"getDefinition",value:function(e){return this.definitions["object"===s()(e)?e.type:e]}}]),e}())
n(82),n(50),n(87),n(110),n(197),n(204),n(206),n(207),n(208),n(209),n(210),n(211),n(212),n(213),n(214),n(215),n(216),n(218),n(219),n(220),n(221),n(222),n(223),n(224),n(225),n(226),n(227),n(228)
function j(){return"10000000-1000-4000-8000-100000000000".replace(/[018]/g,(function(e){return(e^crypto.getRandomValues(new Uint8Array(1))[0]&15>>e/4).toString(16)}))}function x(e){for(var t=e.schemas,n=e.schema,r=e.oldModel,a={__errors:{},__type:n.qualifier,__uuid:j(),__visible:!0},i=0,c=Object.keys(n.fields);i<c.length;i++){var o=c[i],l=n.fields[o],u=C.getDefinition(l),s=r&&o in r?r[o]:void 0
void 0!==s&&u.isValue(l,s)||(s=u.createValue({field:l,schemas:t})),a[o]=s}return a}function R(e,t,n){if(!t)return n(e)
var r,a=e[t.name]
if("index"===t.type){if(!Array.isArray(a))throw new Error("Invalid array access.")
if(t.index<0||t.index>=a.length)throw new Error("Invalid array index ".concat(t.index,'".'));(r=a.slice())[t.index]=n(a[t.index])}else{if(Array.isArray(a))throw new Error("Invalid array access.")
r=n(a)}var i=Object.assign({},e)
return i[t.name]=r,i}function _(e,t,n){var r="string"==typeof t?m(t):t.slice(),a=r.shift()
return R(e,a,(function e(t){return(a=r.shift())?t?R(t,a,e):t:n(t)}))}n(61)
var N=n(20),M=n.n(N),I=n(12),A=n.n(I)
n(73)
function P(e,t){return e.name===t.name&&e.type===t.type&&("index"!==e.type||"index"!==t.type||e.index===t.index)}function D(e){var t=e.sourcePath,n=e.sourceSegment,r=e.targetPath,a=e.targetSegment,i=[].concat(A()(r),[a])
if(i.length>t.length&&t.every((function(e,t){return P(e,i[t])}))){var c=i[t.length]
if("index"!=c.type)throw new Error("Path segment type mismatch")
if(c.name==n.name&&c.index>n.index){i[t.length]=Object.assign(Object.assign({},c),{index:c.index-1})
var o=i.pop()
if(!o||"index"!==o.type)throw new Error("Unsupported operation")
return Object.assign(Object.assign({},e),{targetPath:i,targetSegment:o})}}return e}function L(e,t){return e.length===t.length&&e.every((function(e,n){return P(e,t[n])}))}function T(e,t){var n=t.sourcePath,r=t.sourceSegment,a=t.targetPath,i=t.targetSegment,c=[].concat(A()(n),[r]),o=[].concat(A()(a),[i]),u=h(e.model,a)
if(!u)return!1
var s=l(e,u).fields[i.name],f=u[i.name]
if(!Array.isArray(f)||!s||"array"!==s.type)return!1
var d=D(t)
if(L(c,o)||L(c,[].concat(A()(d.targetPath),[d.targetSegment])))return!1
if(!(L(n,a)&&i.name===r.name)&&s.limit>0&&f.length>=s.limit)return!1
var m=s.member,p=C.getDefinition(m.type),v=h(e.model,c)
return p.isValue(m,v)}function U(e){return Object.assign(Object.assign({},e),{type:"moveModel"})}function F(e){return{overlay:e,type:"setOverlay"}}n(113)
function V(e,t){if(f(t)){var n=e.schemas[t.__type]
n&&(t.__errors=Object.keys(n.fields).reduce((function(e,r){var a=function(e,t,n){var r=e.fields[n].validatorId
if(!r)return null
var a=vi.getValidator(r)
if(!a)return null
var i=[]
return a(n,t[n],i),i}(n,t,r)
return a&&a.length&&(e[r]=a),e}),{}))}}function W(e,t){return{direction:t,type:"uuidOrder",uuid:e}}function H(e){return{type:"uuidVisibility",uuid:e}}function B(e,t,n){return{path:e,key:t,type:"updateValue",value:n}}function z(e){return{sync:e,type:"updateSync"}}var q=n(11),X=n.n(q),J=(n(30),n(2))
function K(e){var t=e.source,n=Object(J.c)(e,["source"])
return Object(J.a)(this,void 0,void 0,X.a.mark((function e(){var r,a,i,c,o,l,u
return X.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:if(r=n.schemas[t.__type]){e.next=3
break}throw new Error("Invalid source schema.")
case 3:a={__errors:{},__originalUuid:t.__uuid,__type:r.qualifier,__uuid:j(),__visible:t.__visible},i=0,c=Object.keys(r.fields)
case 5:if(!(i<c.length)){e.next=15
break}return o=c[i],l=r.fields[o],u=C.getDefinition(l),e.next=11,u.cloneValue(Object.assign(Object.assign({},n),{field:l,value:t[o]}))
case 11:a[o]=e.sent
case 12:i++,e.next=5
break
case 15:return e.abrupt("return",a)
case 16:case"end":return e.stop()}}),e)})))}n(47),n(114)
function G(e){var t=e.apiEndpoint,n=Object(J.c)(e,["apiEndpoint"]),r=Object.keys(n).map((function(e){return"".concat(e,"=").concat(encodeURIComponent(n[e]))})).join("&")
return new Promise((function(e,n){fetch("".concat(t,"&").concat(r)).then((function(e){return e.json()})).then((function(t){!function(e){return"object"===s()(e)&&"object"===s()(e.data)&&!0===e.result&&Array.isArray(e.references)}(t)?n(t&&t.message?"".concat(t.message):"An unknown error has occured."):e(t)})).catch((function(e){n("".concat(e))}))}))}function Y(e){return f(e)?"[".concat(e.__type,", ").concat(e.__uuid,"]"):"[no model]"}var Q={group:console.groupCollapsed,groupEnd:console.groupEnd,info:console.info,model:Y},Z={group:function(){},groupEnd:function(){},info:function(){},model:Y}
function ee(e){return e&&e.verbose?Q:Z}n(152),n(239),n(240)
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
f(a)&&n.push(a)}}catch(e){r.e(e)}finally{r.f()}return n}function ae(e){var t=e.field,n=e.source,r=e.target,a=Object(J.c)(e,["field","source","target"])
return Object(J.a)(this,void 0,void 0,X.a.mark((function e(){var i,c,o,l,u,s,f,d,m,p
return X.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:if("instance"===t.member.type){e.next=2
break}return e.abrupt("return",n||[])
case 2:i=re(n),c=re(r),o=ee(a),l=[],u=te(i),e.prev=7,f=X.a.mark((function e(){var t,n,r,i
return X.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:if(t=s.value,n=c.findIndex((function(e){return r=t,a=null!==(n=e).__originalUuid,i=null!==r.__originalUuid,n.__uuid===r.__uuid||i&&n.__uuid===r.__originalUuid||a&&n.__originalUuid===r.__uuid||a&&i&&n.__originalUuid===r.__originalUuid
var n,r,a,i})),r=void 0,-1!==n){e.next=10
break}return o.info("No array match for ".concat(o.model(t))),e.next=7,K(Object.assign(Object.assign({},a),{source:t}))
case 7:r=e.sent,e.next=16
break
case 10:return i=c[n],o.info("Array match for ".concat(o.model(t)," is ").concat(o.model(i))),c.splice(n,1),e.next=15,me(Object.assign(Object.assign({},a),{source:t,target:i}))
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
case 24:case"end":return e.stop()}}),e,null,[[7,16,19,22]])})))}function ie(e){var t=e.source,n=Object(J.c)(e,["source"])
return Object(J.a)(this,void 0,void 0,X.a.mark((function e(){var r,a,i,c,o
return X.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:r=[],a=0
case 2:if(!(a<t.columns.length)){e.next=11
break}return i=t.columns[a],e.next=6,K(Object.assign(Object.assign({},n),{source:i}))
case 6:c=e.sent,r.push(Object.assign(Object.assign({},c),{__role:"layoutColumn",offset:Object.assign({},i.offset),order:Object.assign({},i.order),width:Object.assign({},i.width)}))
case 8:a++,e.next=2
break
case 11:return o={__role:"layout",__uuid:j(),columns:r,preset:t.preset},e.abrupt("return",o)
case 13:case"end":return e.stop()}}),e)})))}function ce(e,t,n,r){var a=e.breakpoints[0].key
return{__errors:{},__role:"layoutColumn",__type:e.columnTypeQualifier,__uuid:j(),__visible:!0,offset:n?Object.assign({},n.offset):M()({},a,0),order:n?Object.assign({},n.order):M()({},a,0),value:r||oe(e,t),width:n?Object.assign({},n.width):M()({},a,e.constraints.minColumnWidth)}}function oe(e,t){var n=ue(e,t)
return C.getDefinition(n).createValue({field:n,schemas:t})}function le(e,t){for(var n=t.breakpoints,r=t.current.index;r>=0;r--){var a=n[r].key
if(a in e)return e[a]}return 0}function ue(e,t){return t[e.columnTypeQualifier].fields.value}function se(e,t,n){var r=n.current
return function(e,t,n){var r=n.breakpoints,a=NaN
return r.reduce((function(n,r){var i=r.key,c=isNaN(a)?t:a
return i in e&&(c=e[i]),c!==a&&(a=c,n[i]=c),n}),{})}(Object.assign(Object.assign({},e),M()({},r.key,t)),0,n)}function fe(e){return"object"===s()(e)&&"__uuid"in e&&"__role"in e&&"layout"===e.__role}function de(e){var t=e.field,n=e.source,r=e.target,a=Object(J.c)(e,["field","source","target"])
return Object(J.a)(this,void 0,void 0,X.a.mark((function e(){var i,c,o,l,u
return X.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:if(i=ee(a),fe(n)){e.next=4
break}return i.info("No source, skipping ".concat(t.name)),e.abrupt("return",r)
case 4:if(fe(r)){e.next=7
break}return r?i.info("Type missmatch, cloning ".concat(t.name)):i.info("No target, cloning ".concat(t.name)),e.abrupt("return",ie(Object.assign(Object.assign({},a),{source:n})))
case 7:i.group("Syncing layouts ".concat(t.name)),c=[],o=0
case 10:if(!(o<n.columns.length)){e.next=19
break}return l=n.columns[o],e.next=14,me(Object.assign(Object.assign({},a),{source:l,target:r.columns[o]}))
case 14:u=e.sent,c.push(Object.assign(Object.assign({},u),{__role:"layoutColumn",offset:Object.assign({},l.offset),order:Object.assign({},l.order),width:Object.assign({},l.width)}))
case 16:o++,e.next=10
break
case 19:return i.groupEnd(),e.abrupt("return",Object.assign(Object.assign({},r),{columns:c,preset:n.preset}))
case 21:case"end":return e.stop()}}),e)})))}function me(e){var t=e.source,n=e.target,r=Object(J.c)(e,["source","target"])
return Object(J.a)(this,void 0,void 0,X.a.mark((function e(){var a,i,c,o,l,u,s
return X.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:if(a=ee(r),f(t)){e.next=4
break}return a.info("No source, skipping ".concat(a.model(n))),e.abrupt("return",n)
case 4:if(f(n)&&n.__type===t.__type){e.next=7
break}return n?a.info("Type missmatch, cloning ".concat(a.model(t))):a.info("No target, cloning ".concat(a.model(t))),e.abrupt("return",K(Object.assign(Object.assign({},r),{source:t})))
case 7:if(i=r.schemas[t.__type]){e.next=10
break}throw new Error("Invalid schema")
case 10:c=Object.assign({},n),a.group("Syncing model ".concat(a.model(t)," > ").concat(a.model(n))),o=0,l=Object.keys(i.fields)
case 13:if(!(o<l.length)){e.next=41
break}if(u=l[o],"layout"!==(s=i.fields[u]).type){e.next=24
break}return a.group("Layout ".concat(u)),e.next=20,de(Object.assign(Object.assign({},r),{field:s,source:t[u],target:n[u]}))
case 20:c[u]=e.sent,a.groupEnd(),e.next=38
break
case 24:if("array"!==s.type){e.next=32
break}return a.group("Array ".concat(u)),e.next=28,ae(Object.assign(Object.assign({},r),{field:s,source:t[u],target:n[u]}))
case 28:c[u]=e.sent,a.groupEnd(),e.next=38
break
case 32:if("instance"!==s.type){e.next=38
break}return a.group("Instance ".concat(u)),e.next=36,me(Object.assign(Object.assign({},r),{source:t[u],target:n[u]}))
case 36:c[u]=e.sent,a.groupEnd()
case 38:o++,e.next=13
break
case 41:return a.groupEnd(),e.abrupt("return",c)
case 43:case"end":return e.stop()}}),e)})))}function pe(e,t,n){var r=e.siteId,a=Object(J.c)(e,["siteId"])
return Object(J.a)(this,void 0,void 0,X.a.mark((function e(){var i,c,o,l,u,s,d,m
return X.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:if(t(z({status:"working"})),i=n(),c=i.config,o=i.model,l=i.schemas,"number"==typeof c.elementId){e.next=4
break}throw new Error("Entry must be saved before it can be synchronized.")
case 4:return e.next=6,G({apiEndpoint:c.apiEndpoints.fetchSite,elementId:c.elementId,fieldHandle:c.fieldHandle,siteId:r})
case 6:if(u=e.sent,s=u.data,d=u.references,f(s)&&c.rootSchemas.some((function(e){return e===s.__type}))){e.next=11
break}throw new Error("Selected target site does not contain a valid model.")
case 11:if(!(!f(o)||o.__type!==s.__type)){e.next=18
break}return e.next=15,K(Object.assign(Object.assign({},a),{schemas:l,source:s}))
case 15:e.t0=e.sent,e.next=21
break
case 18:return e.next=20,me(Object.assign(Object.assign({},a),{schemas:l,source:s,target:o}))
case 20:e.t0=e.sent
case 21:m=e.t0,t(E(d)),t(B([],void 0,m)),t(z({status:"finished"}))
case 25:case"end":return e.stop()}}),e)})))}n(48)
var he={addReferences:function(e,t){var n,r=e.config.references.slice(),a=document.createElement("div"),i=g(t.references)
try{var c=function(){var e=n.value
if(!r.some((function(t){var n=t.id,r=t.type
return e.id===n&&e.type===r}))){a.innerHTML=e.element
var t=a.firstElementChild
t&&(t.removeAttribute("style"),e.element=t.outerHTML),e.$element=$(e.element),e.hasThumb=e.$element.hasClass("hasthumb"),r.push(e)}}
for(i.s();!(n=i.n()).done;)c()}catch(e){i.e(e)}finally{i.f()}return Object.assign(Object.assign({},e),{config:Object.assign(Object.assign({},e.config),{references:r})})},changeType:function(e,t){var n=t.expandedState,r=t.newType,a=t.path,i=e.schemas[r]
if(!i)return e
var c=h(e.model,a),o=x({oldModel:c,schema:i,schemas:e.schemas})
return c&&n&&n.isExpanded(c.__uuid)&&(n.toggleExpanded(c.__uuid,!1),n.toggleExpanded(o.__uuid,!0)),Object.assign(Object.assign({},e),{model:_(e.model,a,(function(){return o}))})},moveModel:function(e,t){var n=e.model
if(!T(e,t))throw new Error("Invalid operation")
var r=D(t),a=r.sourcePath,i=r.sourceSegment,c=r.targetPath,o=r.targetSegment,l=h(n,[].concat(A()(a),[i]))
return n=_(n,a,(function(e){if(!e)throw new Error("Invalid operation")
var t=e[i.name]
if(!Array.isArray(t))throw new Error("Invalid operation")
return(t=t.slice()).splice(i.index,1),Object.assign(Object.assign({},e),M()({},i.name,t))})),n=_(n,c,(function(e){if(!e)throw new Error("Could not find target")
var t=e[o.name]
if(!Array.isArray(t))throw new Error("Unsupported operation")
return t=t.slice(),o.index>=t.length?t.push(l):t.splice(o.index,0,l),Object.assign(Object.assign({},e),M()({},o.name,t))})),Object.assign(Object.assign({},e),{model:n})},setOverlay:function(e,t){var n=t.overlay
return Object.assign(Object.assign({},e),{overlay:n})},setUser:function(e,t){var n=t.user,r=Object.assign(Object.assign({},e.user),n)
try{window.localStorage.setItem("tcfUserState",JSON.stringify(r))}catch(e){console.error(e)}return Object.assign(Object.assign({},e),{user:r})},uuidInsert:function(e,t){var n=t.position,r=t.uuid,a=t.value,i=d(e,r)
if(!i)return e
var c=v(e,i.path)
if(!c||"array"!==c.field.type||void 0===c.index)return e
var o=c.field,l=c.index,u=c.path,s=o.name
return Object.assign(Object.assign({},e),{model:_(e.model,u,(function(t){if(!t||!(s in t))return t
var r=t[s]
if(!Array.isArray(r))return t
var i=A()(r),c=l+("after"===n?1:0)
i.splice(c,0,a)
var o=Object.assign(Object.assign({},t),M()({},s,i))
return V(e,o),o}))})},uuidOrder:function(e,t){var n=t.direction,r=t.uuid,a=d(e,r)
if(!a)return e
var i=v(e,a.path)
if(!i||"array"!==i.field.type||void 0===i.index)return e
var c=i.field,o=i.index,l=i.path,u=c.name
return Object.assign(Object.assign({},e),{model:_(e.model,l,(function(t){if(!t||!(u in t))return t
var r=t[u]
if(!Array.isArray(r))return t
var a=o+("up"===n?-1:1),i=A()(r),c=i.splice(o,1)
i.splice.apply(i,[a,0].concat(A()(c)))
var l=Object.assign(Object.assign({},t),M()({},u,i))
return V(e,l),l}))})},uuidRemove:function(e,t){var n=t.uuid,r=d(e,n)
if(!r)return e
var a=v(e,r.path)
if(!a||"array"!==a.field.type||void 0===a.index)return e
var i=a.field,c=a.index,o=a.path,l=i.name
return Object.assign(Object.assign({},e),{model:_(e.model,o,(function(t){if(!t||!(l in t))return t
var n=t[l]
if(!Array.isArray(n))return t
var r=A()(n)
r.splice(c,1)
var a=Object.assign(Object.assign({},t),M()({},l,r))
return V(e,a),a}))})},uuidVisibility:function(e,t){var n=d(e,t.uuid)
return n?Object.assign(Object.assign({},e),{model:_(e.model,n.path,(function(e){return e?Object.assign(Object.assign({},e),{__visible:!e.__visible}):e}))}):e},updateSync:function(e,t){var n=t.sync,r=e.overlay
return r&&"synchronize"===r.type&&(r=Object.assign(Object.assign({},r),{preventClose:"working"===n.status})),Object.assign(Object.assign({},e),{overlay:r,sync:n})},updateValue:function(e,t){var n=t.path,r=t.key,a=t.value
return Object.assign(Object.assign({},e),{model:_(e.model,n,(function(t){var n=r?Object.assign(Object.assign({},t),M()({},r,a)):a
return V(e,n),n}))})}}
var ve,ye=[function(e){var t=e.location.uuid,n=e.owner
return n&&"array"===n.field.type?{group:ve.Manipulation,icon:"material:add",id:"create",invoke:function(e){var n=arguments.length>1&&void 0!==arguments[1]&&arguments[1]
e(F({afterCreate:n?"layer":"expand",type:"create",uuid:t}))},label:y("Create")}:null},function(e){var t=e.location.uuid
return{group:ve.Manipulation,icon:"material:edit",id:"edit",invoke:function(e){e(F({type:"edit",uuid:t}))},label:y("Edit")}},function(e){var t=e.owner,n=e.location.uuid
return t&&"array"===t.field.type?{group:ve.Manipulation,icon:"material:delete",id:"delete",invoke:function(e){e(function(e){return{type:"uuidRemove",uuid:e}}(n))},label:y("Delete")}:null},function(e){var t=e.location,n=t.uuid,r=t.model.__visible
return{group:ve.Visibility,icon:r?"material:visibility_off":"material:visibility",id:"visibility",invoke:function(e){e(H(n))},label:y(r?"Hide":"Show")}},function(e){var t=e.location.uuid,n=e.owner
if(!n||"array"!==n.field.type)return null
var r=n.owner[n.field.name]
return!Array.isArray(r)||void 0===n.index||n.index<=0?null:{group:ve.Movement,icon:"material:arrow_upward",id:"moveUp",invoke:function(e){return e(W(t,"up"))},label:y("Move up")}},function(e){var t=e.location.uuid,n=e.owner
if(!n||"array"!==n.field.type)return null
var r=n.owner[n.field.name]
return!Array.isArray(r)||void 0===n.index||n.index>=r.length-1?null:{group:ve.Movement,icon:"material:arrow_downward",id:"moveDown",invoke:function(e){return e(W(t,"down"))},label:y("Move down")}},function(){return null},function(e){return e.owner,null},function(e){return e.owner,null}]
function ge(e,t){var n=d(e,t)
if(!n)return[]
var r={location:n,owner:v(e,n.path),state:e}
return ye.map((function(e){return e(r)})).filter((function(e){return null!==e}))}function be(e,t){var n=t.uuid,r=null
return{getCommands:function(){return ge(e.getState(),n).map((function(t){return Object.assign(Object.assign({},t),{invoke:function(){return t.invoke(e.dispatch,!0)}})}))},subscribe:function(t){r&&r(),r=e.subscribe(t)},unsubscribe:function(){r&&r(),r=null}}}!function(e){e[e.Manipulation=0]="Manipulation",e[e.Visibility=1]="Visibility",e[e.Movement=2]="Movement",e[e.Clipboard=3]="Clipboard"}(ve||(ve={}))
n(89)
var Ee,we,ke=n(172),Se=n.n(ke),Oe=n(21),Ce=n.n(Oe)
!function(e){e[e.Idle=0]="Idle",e[e.Loading=1]="Loading",e[e.Loaded=2]="Loaded"}(Ee||(Ee={}))
var je=null
Ee.Idle
function xe(){return we}n(161)
function Re(e){return e&&"object"===s()(e)&&"__uuid"in e}function _e(e,t){if(Re(e))return e
var n=function(e){switch(s()(e)){case"boolean":return new Boolean(e)
case"number":return new Number(e)
case"object":return e
default:return new String(e)}}(e)
return Object.defineProperty(n,"__uuid",{value:t&&Re(t)?t.__uuid:j()}),n}function Ne(e){return"string"==typeof e&&""!==e.trim()?Ce.a.compile(e):null}function Me(e,t){var n,r=JSON.parse(e.innerHTML)
r.user=function(){try{var e=window.localStorage.getItem("tcfUserState")
if(null===e)throw new Error("User state missing")
var t=JSON.parse(e).favoriteSchemas
return{favoriteSchemas:(n=void 0===t?{}:t,Object.keys(n).reduce((function(e,t){return Array.isArray(n[t])?Object.assign(Object.assign({},e),M()({},t,n[t])):e}),{}))}}catch(e){}var n
return{favoriteSchemas:{}}}(),r.sync={status:"idle"},r.config.references=r.config.references.map((function(e){var t=Se()(e.element)
return Object.assign(Object.assign({},e),{$element:t,hasThumb:t.hasClass("hasthumb")})}))
for(var a=0,i=Object.keys(r.schemas);a<i.length;a++){var c=i[a],o=r.schemas[c]
o.previewTemplate=Ne(o.preview),o.previewLabelTemplate=Ne(o.previewLabel)||o.previewTemplate}n=r.config.googleMapsApiKey,we=n
var l=void 0
1===r.config.rootSchemas.length&&(l=r.schemas[r.config.rootSchemas[0]])
try{r.model=function e(t,n,r){var a=n[t.__type].fields
r&&r.uniqueUuids&&(-1===r.uniqueUuids.indexOf(t.__uuid)?r.uniqueUuids.push(t.__uuid):(console.error('Found duplicate uuid "'.concat(t.__uuid,'".')),t.__uuid=j()))
for(var i=function(){var i=o[c],l=a[i]
"array"===l.type?t[i]=t[i].map((function(t){return"instance"===l.member.type?e(t,n,r):_e(t)})):"instance"===l.type&&(t[i]=e(t[i],n,r))},c=0,o=Object.keys(a);c<o.length;c++)i()
return t}(JSON.parse(t.value),r.schemas,{uniqueUuids:[]})}catch(e){}return!l||f(r.model)&&r.model.__type===l.qualifier||(r.model=x({oldModel:r.model,schema:l,schemas:r.schemas})),r}var Ie=n(174),Ae=n(324),Pe=n(7),De=n.n(Pe)
n(264)
function Le(e){var t=e.children,n=e.className,a=e.outline,i=e.secondary,c=Object(J.c)(e,["children","className","outline","secondary"])
return r.createElement("div",Object.assign({},c,{className:De()("tcfButtonFlat",n,{outline:a,secondary:i})}),t)}var Te=n(17),Ue=n.n(Te),Fe=r.createContext({expanded:[],isExpanded:function(){return!1},toggleExpanded:function(){}})
function Ve(e){var t=e.children,n=r.useState([]),a=Ue()(n,2),i=a[0],c=a[1]
return r.createElement(Fe.Provider,{value:{expanded:i,isExpanded:function(e){return-1!==i.indexOf(e)},toggleExpanded:function(e,t){var n=A()(i)
void 0===t&&(t=-1===i.indexOf(e)),t?n.push(e):n=n.filter((function(t){return t!==e})),c(n)}}},t)}n(268)
function We(e){var t=e.children,n=e.disabled,a=e.onClick,i=e.primary,c=e.secondary
return r.createElement("div",{className:De()("tcfButton btn",{disabled:n,submit:i,secondary:c}),onClick:function(e){e.preventDefault(),n||a(e)}},t)}function He(e){var t=e.className,n=e.params,a=e.value
return r.createElement("span",{className:t},y(a,n))}function Be(e){var t=e.children,n=e.className
return r.createElement("div",{className:De()("tcfWindow--content",n)},t)}function ze(e){var t=e.children,n=e.className,a=e.flex,i=void 0===a||a
return r.createElement("div",{className:De()("tcfWindow--footer flex-nowrap",n,{flex:i})},t)}var qe
n(269)
function $e(e){var t=e.children,n=e.className,a=e.width
return r.createElement("div",{className:De()("tcfWindow",n),style:{width:a}},t)}(qe=$e||($e={})).Content=Be,qe.Footer=ze
var Xe=$e
function Je(e){var t=e.onClose
return r.createElement(Xe,{width:600},r.createElement(Xe.Content,null,r.createElement(He,{value:"Cannot create an element at the given location."})),r.createElement(Xe.Footer,null,r.createElement(We,{onClick:t,secondary:!0},r.createElement(He,{value:"Cancel"}))))}n(270)
function Ke(e){var t=e.children,n=e.isBorderless,a=e.label,i=e.style
return a&&""!==a&&"toolbar"!==a?r.createElement("div",{className:"tcfFieldGroup",style:i},r.createElement("div",{className:"tcfFieldGroup--label"},a),r.createElement("div",{className:"tcfFieldGroup--content"},t)):r.createElement("div",{className:De()("tcfFieldGroup--content",{isBorderless:n}),style:i},t)}n(271)
function Ge(e){var t=e.children,n=e.className,a=e.errors,i=e.instructions,c=e.isPlainField,o=e.isRequired,l=e.label,u=e.style
if(c)return r.createElement(r.Fragment,null,t)
var s=a&&a.length
return r.createElement("div",{className:De()("tcfFieldPanel",n),style:u},r.createElement("div",{className:De()("tcfFieldPanel--label",{hasErrors:s,isRequired:o})},l),i?r.createElement("div",{className:"tcfFieldPanel--instructions"},i):null,a&&a.length?r.createElement("ul",{className:"tcfFieldPanel--errors"},a.map((function(e,t){return r.createElement("li",{className:"tcfFieldPanel--error",key:t},e)}))):null,t)}n(272),n(273)
function Ye(e,t){return e.label.localeCompare(t.label)}function Qe(e){var t=e.allowUndecided,n=e.disabled,a=void 0!==n&&n,i=e.options,c=e.value,o=e.onChange,l=i.findIndex((function(e){return e.key==c})),u=t||-1===l
return r.createElement("div",{className:"tcfSelect"},r.createElement("select",{className:"tcfSelect--select",disabled:a,value:-1==l?void 0:l,onChange:a?void 0:function(e){var n=e.target.selectedIndex,r=null
u&&(n-=1),n>=0&&n<i.length&&(r=i[n].key),(null!==r||t)&&o(r)}},u?r.createElement("option",null,"(None)"):null,i.map((function(e,t){return r.createElement("option",{key:t,value:t},e.indent?"--".repeat(e.indent)+" ":null,e.label)}))))}var Ze=[{key:"before",label:"Before selected element"},{key:"after",label:"After selected element"}]
function et(e){var t=e.Factory,n=e.field,a=e.onCreate,i=e.scope,c=r.useState("before"),o=Ue()(c,2),l=o[0],u=o[1]
return r.createElement(Xe,{width:600},r.createElement(Xe.Content,null,r.createElement(Ke,null,r.createElement(Ge,{instructions:y("Select where the new element should be inserted."),label:y("Position")},r.createElement(Qe,{onChange:u,options:Ze.map((function(e){return Object.assign(Object.assign({},e),{label:y(e.label)})})),value:l})))),r.createElement(Xe.Footer,{flex:!1},r.createElement(t,{field:n,onCreate:function(e){return a(e,l)},scope:i})))}function tt(e){var t=e.afterCreate,n=void 0===t?"expand":t,a=e.uuid,i=Object(o.c)(),c=r.useContext(Fe),l=Object(o.d)((function(e){var t=d(e,a)
if(!t||!t.path.length)return null
var n=v(e,t.path)
return n&&"array"===n.field.type&&void 0!==n.index?{field:n.field,model:n.owner}:null}))
if(null===l)return r.createElement(Je,{onClose:function(){i(F(null))}})
var u=l.field,s=l.model,m=C.getDefinition(u.member.type).factory
return r.createElement(et,{Factory:m,field:u.member,onCreate:function(e,t){var r=null
f(e)&&("expand"===n?c.toggleExpanded(e.__uuid,!0):r={type:"edit",uuid:e.__uuid}),i(function(e,t,n){return{position:n,type:"uuidInsert",uuid:e,value:t}}(a,e,t)),i(F(r))},scope:s.__type})}var nt=n(4),rt=n.n(nt),at=n(5),it=n.n(at),ct=n(1),ot=n.n(ct)
function lt(e){var t=e.field,n=C.getDefinition(t).widget
return r.createElement(n,e)}n(163)
function ut(e,t){if(t)switch(e){case 0:return t.small
case 2:return t.large
default:return t.medium}}var st=r.createContext(2)
function ft(e){var t=e.children,n=Object(J.c)(e,["children"]),a=r.useState(2),i=Ue()(a,2),c=i[0],o=i[1],l=r.useRef(null)
return r.useEffect((function(){var e=window.ResizeObserver,t=l.current,n=-1,r=0
if(t){var a=function(){var e=t.offsetWidth
e!==r&&o((r=e)>920?2:r>580?1:0)}
if(e){var i=new e(a)
return i.observe(t),function(){return i.unobserve(t)}}return function e(){n=window.requestAnimationFrame(e),a()}(),function(){return window.cancelAnimationFrame(n)}}}),[]),r.createElement("div",Object.assign({ref:l},n),r.createElement(st.Provider,{value:c},t))}n(274)
function dt(e,t){return e.index-t.index}var mt=Object(o.b)((function(e,t){return{schema:e.schemas[t.model.__type]}}),(function(e,t){return{onUpdate:function(n,r){e(B(t.path,n,r))}}}))((function(e){var t=e.disabled,n=void 0!==t&&t,a=e.isBorderless,i=e.model,c=e.onUpdate,o=e.path,l=e.schema,u=r.useContext(st)
if(!l)return r.createElement("div",null,'Could not resolve schema for "'.concat(i.__type,'"'))
var s=[],f=Object.keys(l.fields),d=void 0
if(0===f.length)return r.createElement("div",{className:"tcfInstanceForm--empty"},r.createElement(He,{value:"This element has no properties."}))
for(var m=function(){var e=h[p],t=l.fields[e],f=i.__errors[e]||null,m=C.getDefinition(t).isAlwaysPlainField
if(!d||t.group){var v=t.group?t.group.label:void 0,y=t.group?ut(u,t.group.style):void 0
d={index:"toolbar"===v?-1:s.length,label:v,fields:[],style:y},s.push(d)}d.fields.push(r.createElement(Ge,{errors:f,instructions:t.instructions,isPlainField:a||m,isRequired:t.isRequired,key:t.name,label:t.label,style:ut(u,t.style)},r.createElement(lt,{data:i[t.name],disabled:n,errors:f,field:t,model:i,onUpdate:function(t){return c(e,t)},path:o})))},p=0,h=f;p<h.length;p++)m()
var v=s.sort(dt).map((function(e){return r.createElement(Ke,{isBorderless:a,key:e.index,label:e.label,style:e.style},e.fields)})),y=ut(u,l.style)
return y?r.createElement("div",{className:"tcfInstanceForm",style:y},v):r.createElement(r.Fragment,null,v)}))
function pt(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1
if(Reflect.construct.sham)return!1
if("function"==typeof Proxy)return!0
try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}()
return function(){var n,r=ot()(e)
if(t){var a=ot()(this).constructor
n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments)
return it()(this,n)}}var ht=function(e){rt()(n,e)
var t=pt(n)
function n(e){var r
return k()(this,n),(r=t.call(this,e)).originalModel=null,r.handleCancel=function(){r.close()},r.handleApply=function(){r.close()},r.originalModel=e.model,r}return O()(n,[{key:"close",value:function(){this.props.setOverlay(null)}},{key:"render",value:function(){var e=this.props,t=e.model,n=e.path
return r.createElement(Ve,null,r.createElement(Xe,null,r.createElement(Xe.Content,null,r.createElement(mt,{model:t,path:n})),r.createElement(Xe.Footer,null,r.createElement(We,{onClick:this.handleApply},r.createElement(He,{value:"Apply"})))))}}]),n}(r.Component),vt=Object(o.b)((function(e,t){return d(e,t.uuid)}),(function(e){return{setOverlay:function(t){return e(F(t))}}}))(ht)
n(275),n(278)
function yt(e){var t=e.className,n=e.name,a=e.size,i="craft"
return n.startsWith("material:")?(i="material",n=n.substr("material:".length)):n.startsWith("craft:")&&(n=n.substr("craft:".length)),r.createElement("div",{className:De()("tcfIcon",t,i,a)},n)}function gt(e){var t=e.message,n=e.onClose
return r.createElement(r.Fragment,null,r.createElement(Xe.Content,null,r.createElement("div",{className:"tcfSynchronize--message"},r.createElement(yt,{className:"tcfSynchronize--messageIcon error",name:"material:error",size:"huge"}),r.createElement("div",{className:"tcfSynchronize--title"},"An error has occured"),t?r.createElement("div",{className:"tcfSynchronize--message"},t):null)),r.createElement(Xe.Footer,null,r.createElement(We,{onClick:n},"Close")))}function bt(e){var t=e.onClose
return r.createElement(r.Fragment,null,r.createElement(Xe.Content,null,r.createElement("div",{className:"tcfSynchronize--message"},r.createElement(yt,{className:"tcfSynchronize--messageIcon finished",name:"material:check_circle",size:"huge"}),r.createElement("div",{className:"tcfSynchronize--title"},r.createElement(He,{value:"Sites have been synchronized"})),r.createElement("div",{className:"tcfSynchronize--message"},r.createElement(He,{value:"If you are not happy with the results, do not save the entry. Reload this page to revert all changes."})))),r.createElement(Xe.Footer,null,r.createElement(We,{onClick:t},r.createElement(He,{value:"Close"}))))}n(45)
var Et=n(26),wt=n.n(Et)
function kt(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1
if(Reflect.construct.sham)return!1
if("function"==typeof Proxy)return!0
try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}()
return function(){var n,r=ot()(e)
if(t){var a=ot()(this).constructor
n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments)
return it()(this,n)}}var St=function(e){rt()(n,e)
var t=kt(n)
function n(){var e
return k()(this,n),(e=t.apply(this,arguments)).element=null,e.lightswitch=null,e.handleChange=function(){var t=e.props,n=t.disabled,r=t.onChange,a=wt()(e).lightswitch
!n&&a&&r(a.on)},e.setElement=function(t){e.element!==t&&(e.element=t,e.updateInstance())},e}return O()(n,[{key:"componentDidUpdate",value:function(e){var t=this.props.value,n=this.lightswitch
e.disabled!==this.props.disabled?this.updateInstance():n&&n.on!==t&&n.toggle()}},{key:"render",value:function(){var e=this.props,t=e.className,n=e.disabled,a=e.small,i=e.value
return r.createElement("div",null,r.createElement("div",{className:De()("lightswitch",t,{disabled:n,on:i,small:a}),ref:this.setElement,tabIndex:0},r.createElement("div",{className:"lightswitch-container"},r.createElement("div",{className:"label on"}),r.createElement("div",{className:"handle"}),r.createElement("div",{className:"label off"}))))}},{key:"updateInstance",value:function(){var e=this.element,t=this.handleChange,n=this.lightswitch,r=this.props,a=r.disabled,i=r.value
n&&(n.destroy(),this.lightswitch=null),!a&&e&&(this.lightswitch=new Craft.LightSwitch(e,{onChange:t,value:i}))}}]),n}(r.Component)
function Ot(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1
if(Reflect.construct.sham)return!1
if("function"==typeof Proxy)return!0
try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}()
return function(){var n,r=ot()(e)
if(t){var a=ot()(this).constructor
n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments)
return it()(this,n)}}var Ct=function(e){rt()(n,e)
var t=Ot(n)
function n(e){var r
return k()(this,n),(r=t.call(this,e)).handleApply=function(e){var t,n=r.props,a=n.currentSite,i=n.endpoint,c=r.state,o=c.arrayOrphanMode,l=c.site,u=c.useTranslator
l&&(u&&a&&l.language!==a.language&&(t={endpoint:i,source:l.language,target:a.language}),r.props.onSynchronize({arrayOrphanMode:o,siteId:l.id,translate:t,verbose:"altKey"in e&&e.altKey}))},r.handleArrayOrphanModeChange=function(e){r.setState({arrayOrphanMode:e})},r.handleSiteChange=function(e){r.setState({site:e})},r.handleToggleTranslator=function(e){r.setState({useTranslator:e})},r.state={arrayOrphanMode:"hide",site:e.availableSites[0]||null,useTranslator:!1},r}return O()(n,[{key:"render",value:function(){var e=this.props,t=e.availableSites,n=e.currentSite,a=e.hasTranslator,i=e.onClose,c=this.state,o=c.arrayOrphanMode,l=c.site,u=c.useTranslator,s=t.map((function(e){return{label:e.label,key:e}}))
return r.createElement(r.Fragment,null,r.createElement(Xe.Content,null,r.createElement("div",{className:"tcfSynchronize--title"},r.createElement(He,{value:"Synchronize translations"})),r.createElement(Ke,null,r.createElement(Ge,{instructions:y("Select the site the content should be copied from."),label:y("Site")},r.createElement(Qe,{onChange:this.handleSiteChange,options:s,value:l})),r.createElement(Ge,{instructions:y("Defines what happens to elements that do not exist in the selected language."),label:y("Orphaned elements")},r.createElement(Qe,{onChange:this.handleArrayOrphanModeChange,options:[{key:"hide",label:y("Hide orphaned elements")},{key:"none",label:y("Do nothing")},{key:"remove",label:y("Remove orphaned elements")}],value:o})),l&&n&&l.language!==n.language?r.createElement(Ge,{instructions:y(a?"Uses a webservice to automatically translate texts.":"A matching webservice must be configured in the options of this field in order to use this feature."),label:y("Translate texts automatically")},r.createElement(St,{disabled:!a,onChange:this.handleToggleTranslator,value:u})):null)),r.createElement(Xe.Footer,null,r.createElement(We,{onClick:i,secondary:!0},r.createElement(He,{value:"Cancel"})),r.createElement(We,{onClick:this.handleApply,primary:!0},r.createElement(He,{value:"Apply"}))))}}]),n}(r.Component),jt=Object(o.b)((function(e){var t=e.config,n=t.apiEndpoints,r=t.elementSiteId,a=t.hasTranslator,i=t.supportedSites
return{availableSites:i.filter((function(e){return e.id!==r})),currentSite:i.find((function(e){return e.id===r})),endpoint:n.translate,hasTranslator:a}}),(function(e){return{onSynchronize:function(t){return e(function(e){var t=this
return function(n,r){return Object(J.a)(t,void 0,void 0,X.a.mark((function t(){return X.a.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return t.prev=0,t.next=3,pe(e,n,r)
case 3:t.next=8
break
case 5:t.prev=5,t.t0=t.catch(0),n(z({status:"error",message:"".concat(t.t0)}))
case 8:case"end":return t.stop()}}),t,null,[[0,5]])})))}}(t))}}}))(Ct)
n(279)
function xt(){return r.createElement("div",{className:"tcfActivityIndicator"},r.createElement("div",{className:"tcfActivityIndicator--bounce first"}),r.createElement("div",{className:"tcfActivityIndicator--bounce second"}),r.createElement("div",{className:"tcfActivityIndicator--bounce third"}))}function Rt(){return r.createElement(Xe.Content,null,r.createElement("div",{className:"tcfSynchronize--working"},r.createElement(xt,null)))}n(280)
function _t(){var e,t=Object(o.d)((function(e){return e.sync})),n=Object(o.c)(),a=function(){return n(F(null))}
return e="working"===t.status?r.createElement(Rt,null):"error"===t.status?r.createElement(gt,{message:t.message,onClose:a}):"finished"===t.status?r.createElement(bt,{onClose:a}):r.createElement(jt,{onClose:a}),r.createElement(Xe,{width:600},e)}var Nt=r.createContext(0)
function Mt(e){var t=e.children,n=r.useContext(Nt)
return r.createElement(Nt.Provider,{value:n+1},t)}function It(e){var t=e.disabled,n=e.dispatch,a=e.model,i=e.path,c=e.schemas,o=r.useContext(Fe),l=c.map((function(e){return{key:e.qualifier,label:e.label}}))
return l.sort(Ye),r.createElement(Ge,{className:"tcfInstance--controlsSchema",label:"Type"},r.createElement(Qe,{disabled:t,onChange:function(e){return n(function(e,t,n){return{expandedState:n,newType:t,path:e,type:"changeType"}}(i,e,o))},options:l,value:a?a.__type:null}))}function At(e){var t=e.disabled,n=e.dispatch,a=e.model,i=a.__visible?"material:visibility":"material:visibility_off",c=r.createElement(r.Fragment,null,r.createElement(He,{value:"Visibility"}),r.createElement(yt,{className:De()("tcfInstance--controlsVisibilityIcon",{off:!a.__visible}),name:i}))
return r.createElement(Ge,{label:c,className:"tcfInstance--controlsVisibility"},r.createElement(We,{disabled:t,onClick:function(){return n(H(a.__uuid))}},r.createElement(He,{value:a.__visible?"Hide":"Show"})))}n(281)
var Pt=r.memo((function(e){var t=e.canChangeVisibility,n=void 0!==t&&t,a=e.canChangeType,i=void 0===a||a,c=e.disabled,l=void 0!==c&&c,u=e.isBorderless,s=e.model,d=e.path,m=e.schemaNames,p=Object(o.c)(),h=Object(o.d)((function(e){return m.map((function(t){return e.schemas[t]}))})),v=!1
f(s)&&(v=h.some((function(e){return e.qualifier===s.__type})))
var y=i&&h.length>1,g=n&&v&&!s.__visible
return r.createElement(Mt,null,r.createElement(ft,null,y||g?r.createElement("div",{className:"tcfInstance--controls"},y?r.createElement(It,{disabled:l,dispatch:p,model:v?s:null,path:d,schemas:h}):null,g?r.createElement(At,{disabled:l,dispatch:p,model:s}):null):null,v?r.createElement(mt,{disabled:l,model:s,isBorderless:u,path:d}):null))}))
n(282)
function Dt(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1
if(Reflect.construct.sham)return!1
if("function"==typeof Proxy)return!0
try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}()
return function(){var n,r=ot()(e)
if(t){var a=ot()(this).constructor
n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments)
return it()(this,n)}}var Lt=function(e){rt()(n,e)
var t=Dt(n)
function n(e){var r
k()(this,n),(r=t.call(this,e)).element=null,r.handleMouseDown=function(e){var t=r.props.onClick
e.target===r.element&&t&&t()}
var a=document.createElement("div")
return a.className="tcfOverlay",a.addEventListener("mousedown",r.handleMouseDown),document.body.appendChild(a),r.element=a,r}return O()(n,[{key:"componentWillUnmount",value:function(){var e=this.element
e&&(document.body.removeChild(e),e.removeEventListener("mousedown",this.handleMouseDown),this.element=null)}},{key:"render",value:function(){var e=this.props.children,t=this.element
return t?Object(a.createPortal)(e,t):null}}]),n}(r.Component)
n(283)
function Tt(){var e=Object(o.c)(),t=Object(o.d)((function(e){return e.model})),n=Object(o.d)((function(e){return e.overlay})),a=Object(o.d)((function(e){return e.config})),i=a.disabled,c=a.rootSchemas,l=a.supportedSites.length>1
return r.createElement(Ae.a,{backend:Ie.a},r.createElement(Ve,null,l&&!i?r.createElement("div",{className:"tcfRoot--options"},r.createElement(Le,{onClick:function(){e(z({status:"idle"})),e(F({type:"synchronize"}))},outline:!0},r.createElement(yt,{name:"material:sync"}),r.createElement(He,{value:"Synchronize translations"}))):null,r.createElement(Pt,{disabled:i,model:t,path:[],schemaNames:c}),n?r.createElement(Lt,{onClick:function(){n&&!n.preventClose&&e(F(null))}},function(e){if(!e)return null
switch(e.type){case"create":return r.createElement(tt,Object.assign({},e))
case"edit":return r.createElement(vt,Object.assign({},e))
case"synchronize":return r.createElement(_t,null)}}(n)):null))}var Ut=function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:{config:{apiEndpoints:{fetchSite:"",oembed:"",translate:""},disabled:!1,elementId:null,elementSiteId:0,fieldHandle:"",hasTranslator:!1,references:[],rootSchemas:[],supportedSites:[]},model:{__errors:{},__type:"unknown",__uuid:"0",__visible:!0},overlay:null,schemas:{},sync:{status:"idle"},user:{favoriteSchemas:{}}},t=arguments.length>1?arguments[1]:void 0
return t.type in he?he[t.type](e,t):e},Ft=n(90),Vt=n.n(Ft)
function Wt(e){for(;"string"!=typeof e;)e=e.toHTML()
return e}var Ht={},Bt={},zt=function(e,t){Ht[String(t)]=!0},qt=function(e,t){Bt[String(t)]=!0}
function $t(){return{allowedProtoMethods:Ht,allowedProtoProperties:Bt}}function Xt(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1
if(Reflect.construct.sham)return!1
if("function"==typeof Proxy)return!0
try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}()
return function(){var n,r=ot()(e)
if(t){var a=ot()(this).constructor
n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments)
return it()(this,n)}}var Jt=function(e){rt()(n,e)
var t=Xt(n)
function n(e){return k()(this,n),t.call.apply(t,[this].concat(A()(function(e){var t=e.context,n=e.field,r=e.value
if(!n)return[]
var a=n.member,i=C.getDefinition(a)
return r.map((function(e){return i.preview({value:e,field:a,context:t})}))}(e))))}return O()(n,[{key:"toHTML",value:function(){return new Oe.SafeString(this.toString())}},{key:"toList",value:function(e){return new Oe.SafeString('<ul class="'.concat(e,'">').concat(this.map((function(e){return"<li>".concat(Wt(e),"</li>")})).join(""),"</ul>"))}},{key:"toString",value:function(){return this.map((function(e){return Wt(e)})).join("")}},{key:"asColumn",get:function(){return this.toList("flexColumn")}},{key:"asList",get:function(){return this.toList("")}},{key:"asRow",get:function(){return this.toList("flexRow")}},{key:"first",get:function(){return new Oe.SafeString(this.length?Wt(this[0]):"")}},{key:"one",get:function(){return this.first}}]),n}(Vt()(Array))
Object(J.b)([qt],Jt.prototype,"asColumn",null),Object(J.b)([qt],Jt.prototype,"asList",null),Object(J.b)([qt],Jt.prototype,"asRow",null),Object(J.b)([qt],Jt.prototype,"first",null),Object(J.b)([qt],Jt.prototype,"one",null),Object(J.b)([zt],Jt.prototype,"toHTML",null),Object(J.b)([zt],Jt.prototype,"toList",null),Object(J.b)([zt],Jt.prototype,"toString",null)
var Kt=n(325)
function Gt(e,t){var n={data:e.child,height:100,path:e.path,type:"MEMBER"}
return Object(Kt.a)({item:n,begin:function(){return{data:e.child,height:t.current?t.current.clientHeight:100,path:e.path,type:"MEMBER"}},canDrag:function(){return!e.disabled},collect:function(e){return{isDragging:e.isDragging()}},isDragging:function(t){return L(e.path,t.getItem().path)}})}var Yt=n(326)
function Qt(e,t){var n=Object(o.e)()
return Object(Yt.a)({accept:"MEMBER",drop:function(e){return{item:e}},hover:function(r,a){if(a.isOver({shallow:!0})){var i=function(e,t,n){var r=n.current,a=t.getClientOffset()
if(!r||!a||!e)return null
var i=r.getBoundingClientRect(),c=i.bottom,o=i.top,l=a.y-o
return r.classList.contains("isExpanded")&&l>32&&l<c-o-32?null:(l>(c-o)/2&&(e.targetSegment=Object.assign(Object.assign({},e.targetSegment),{index:e.targetSegment.index+1})),e)}(function(e,t){var n=e.path.slice(),r=n.pop()
if(!r||"index"!==r.type)return null
var a=t.path.slice(),i=a.pop()
return i&&"index"===i.type?{sourcePath:a,sourceSegment:i,targetPath:n,targetSegment:r}:null}(e,r),a,t)
if(i&&T(n.getState(),i)){var c=U(i),o=D(c),l=o.targetPath,u=o.targetSegment
r.path=[].concat(A()(l),[u]),n.dispatch(c)}}}})}n(288)
function Zt(e){var t=e.child,n=e.depth,a=e.disabled,i=e.field,c=e.index,o=e.model,l=e.onDelete,u=e.onUpdate,s=e.path,f=r.useRef(null),d=Gt(e,f),m=Ue()(d,3),p=m[0].isDragging,h=m[1],v=m[2],y=Qt(e,f);(0,Ue()(y,2)[1])(f)
return r.createElement("div",{className:De()("tcfArrayWidgetMember depth-".concat(n),{isDragging:p}),ref:f},v(r.createElement("div",{className:"tcfArrayWidgetMember--panel tcfArrayWidgetMember--single"},h(r.createElement("div",{className:De()("tcfArrayWidgetMember--singleHandle",{enabled:!a})},r.createElement(yt,{className:"tcfArrayWidgetMember--singleHandleIcon",key:"handle",name:"move"}))),r.createElement("div",{className:"tcfArrayWidgetMember--singleBody"},r.createElement(lt,{data:t,disabled:a,errors:[],field:i,model:o,onUpdate:function(e){u(c,e)},path:s})),a?null:r.createElement("div",{className:"tcfArrayWidgetMember--singleActions"},r.createElement("div",{className:"tcfArrayWidgetMember--singleActionsButton",onClick:function(){l(c)}},r.createElement(yt,{name:"remove"}))))))}function en(e){var t=r.useRef(null),n=function(e){var t=Object(o.e)()
return Object(Yt.a)({accept:"MEMBER",drop:function(e){return{item:e}},hover:function(n,r){if(r.isOver({shallow:!0})){var a=function(e,t){var n=t.path.slice(),r=n.pop()
return r&&"index"===r.type?{sourcePath:n,sourceSegment:r,targetPath:e.path,targetSegment:{type:"index",index:0,name:e.field.name}}:null}(e,n)
if(a&&T(t.getState(),a)){var i=U(a),c=D(i),o=c.targetPath,l=c.targetSegment
n.path=[].concat(A()(o),[l]),t.dispatch(i)}}}})}(e)
return(0,Ue()(n,2)[1])(t),r.createElement("div",{className:"tcfArrayWidgetList--empty",key:"empty",ref:t},r.createElement(He,{value:"Drop elements here"}))}n(289)
function tn(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1
if(Reflect.construct.sham)return!1
if("function"==typeof Proxy)return!0
try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}()
return function(){var n,r=ot()(e)
if(t){var a=ot()(this).constructor
n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments)
return it()(this,n)}}var nn=function(e){rt()(n,e)
var t=tn(n)
function n(e){var r
return k()(this,n),(r=t.call(this,e)).element=null,r.handleAnimationEnd=function(){var e=wt()(r).element
e&&(e.style.height="",e.style.transition=""),r.setState({inTransition:!1,lastChildren:null,lastUri:null})},r.setElement=function(e){r.element=e},r.state={currentChildren:e.children,currentUri:e.uri,inTransition:!1,lastChildren:null,lastUri:null},r}return O()(n,[{key:"componentDidUpdate",value:function(e,t,n){var r=this.element
r&&n&&setTimeout((function(){r.style.height=""
var e=r.offsetHeight
r.style.height="".concat(n.height,"px"),r.getBoundingClientRect(),r.style.transition="height 200ms",r.style.height="".concat(e,"px")}),0)}},{key:"getSnapshotBeforeUpdate",value:function(e,t){var n=this.element
if(t.currentUri!==this.state.currentUri&&n){var r=n.offsetHeight
return n.style.height="".concat(r,"px"),{height:r}}return null}},{key:"render",value:function(){var e=this.props,t=e.className,n=e.itemClassName,a=this.state,i=a.currentChildren,c=a.currentUri,o=a.inTransition,l=a.lastChildren,u=a.lastUri,s=[]
return o&&u&&s.push(r.createElement("div",{className:De()(n,"tcfDetailsPanel--item","from"),key:u},l)),s.push(r.createElement("div",{className:De()(n,"tcfDetailsPanel--item",{to:o}),key:c,onAnimationEnd:this.handleAnimationEnd},i)),r.createElement("div",{className:De()(t,"tcfDetailsPanel"),ref:this.setElement},s)}}],[{key:"getDerivedStateFromProps",value:function(e,t){return e.uri===t.currentUri?Object.assign(Object.assign({},t),{currentChildren:e.children}):e.uri===t.currentUri||t.inTransition?null:{inTransition:!0,lastChildren:t.currentChildren,lastUri:t.currentUri,currentChildren:e.children,currentUri:e.uri}}}]),n}(r.Component)
n(167)
function rn(e){var t=e.children,n=e.onClick,a=e.primary
return r.createElement("div",{className:De()("tcfArrayWidgetMember--headerActionsButton",{primary:a}),onClick:function(e){e.preventDefault(),n()}},t)}var an=null
function cn(){return null===an&&(an=new Craft.ElementThumbLoader),an}n(290)
function on(e){var t=e.className,n=e.model,a=e.schema,i=e.size,c=void 0===i?"small":i,l=r.useRef(null),u=Object(o.d)((function(e){return e.config.references})),s=function(e,t){var n=t.previewImage
if(!n)return null
var r=n in e?e[n]:null
if(!Array.isArray(r)||0===r.length)return null
var a=r[0]
return"number"==typeof a?a:null}(n,a),f=u.find((function(e){return e.id===s}))
return r.useEffect((function(){if(l.current){var e=$(".element",l.current)
Craft.setElementSize(e,c),cn().load(e)}}),[l.current,f]),f&&f.hasThumb?r.createElement("div",{className:De()("tcfInstancePreviewImage",t,c),dangerouslySetInnerHTML:{__html:f.element},ref:l}):r.createElement("div",{className:De()("tcfInstancePreviewImage empty",t,c)})}var ln=r.memo((function(e){var t=e.field,n=e.model,a=e.references,i=e.schemas,c=Object(J.c)(e,["field","model","references","schemas"]),o=Wt(C.getDefinition("instance").preview({context:{depth:0,references:a,schemas:i},field:t,mode:"label",value:n})).replace(/<[^>]*>?/gm,"").replace(/[\n\t\r]+/g,"").trim().substr(0,256)
return r.createElement("div",Object.assign({},c),o)}),(function(e,t){return e.model===t.model}))
function un(e){var t=Object(o.d)((function(e){return[e.config.references,e.schemas]})),n=Ue()(t,2),a=n[0],i=n[1]
return r.createElement(ln,Object.assign({},e,{references:a,schemas:i}))}function sn(e){var t=e.command,n=e.onClick
return r.createElement("div",{className:"tcfArrayWidgetMember--headerMoreItem",onMouseUp:n},r.createElement(yt,{className:"tcfArrayWidgetMember--headerMoreItemIcon",name:t.icon}),r.createElement("span",{className:"tcfArrayWidgetMember--headerMoreItemLabel"},t.label))}function fn(e,t){var n
if("undefined"==typeof Symbol||null==e[Symbol.iterator]){if(Array.isArray(e)||(n=function(e,t){if(!e)return
if("string"==typeof e)return dn(e,t)
var n=Object.prototype.toString.call(e).slice(8,-1)
"Object"===n&&e.constructor&&(n=e.constructor.name)
if("Map"===n||"Set"===n)return Array.from(e)
if("Arguments"===n||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n))return dn(e,t)}(e))||t&&e&&"number"==typeof e.length){n&&(e=n)
var r=0,a=function(){}
return{s:a,n:function(){return r>=e.length?{done:!0}:{done:!1,value:e[r++]}},e:function(e){throw e},f:a}}throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}var i,c=!0,o=!1
return{s:function(){n=e[Symbol.iterator]()},n:function(){var e=n.next()
return c=e.done,e},e:function(e){o=!0,i=e},f:function(){try{c||null==n.return||n.return()}finally{if(o)throw i}}}}function dn(e,t){(null==t||t>e.length)&&(t=e.length)
for(var n=0,r=new Array(t);n<t;n++)r[n]=e[n]
return r}var mn=Object(o.b)((function(e,t){return{commands:ge(e,t.uuid)}}),(function(e){return{dispatch:e}}))((function(e){var t,n,a=e.commands,i=e.dispatch,c=e.onClose,o=[],l=fn(a)
try{var u=function(){var e=n.value
if("edit"===e.id)return"continue"
void 0!==t&&t!==e.group&&o.push(r.createElement("div",{className:"tcfArrayWidgetMember--headerMoreDivider",key:"".concat(e.id,"-divider")})),t=e.group,o.push(r.createElement(sn,{command:e,key:e.id,onClick:function(){c(),e.invoke(i)}}))}
for(l.s();!(n=l.n()).done;)u()}catch(e){l.e(e)}finally{l.f()}return r.createElement("div",{className:"tcfArrayWidgetMember--headerMoreMenu"},o)}))
n(291),n(292)
function pn(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1
if(Reflect.construct.sham)return!1
if("function"==typeof Proxy)return!0
try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}()
return function(){var n,r=ot()(e)
if(t){var a=ot()(this).constructor
n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments)
return it()(this,n)}}var hn=function(e){rt()(n,e)
var t=pn(n)
function n(){var e
return k()(this,n),(e=t.apply(this,arguments)).handle=null,e.handleStyle={left:"0px"},e.origin=null,e.panel=null,e.panelClassName="tcfFlyout--panel",e.panelStyle={left:"0px",top:"0px"},e.handleResize=function(){e.update()},e.setHandle=function(t){e.handle=t,e.update()},e.setOrigin=function(t){e.origin=t,e.update()},e.setPanel=function(t){e.panel=t,e.update()},e}return O()(n,[{key:"componentDidMount",value:function(){window.addEventListener("resize",this.handleResize)}},{key:"componentWillUnmount",value:function(){window.removeEventListener("resize",this.handleResize)}},{key:"render",value:function(){var e=this.props,t=e.children,n=e.onClick
return r.createElement("div",{className:"tcfFlyout",ref:this.setOrigin},r.createElement(Lt,{onClick:n},r.createElement("div",{className:this.panelClassName,ref:this.setPanel,style:Object.assign({},this.panelStyle)},r.createElement("div",{className:"tcfFlyout--handle",ref:this.setHandle,style:Object.assign({},this.handleStyle)}),r.createElement("div",{className:"tcfFlyout--body"},t))))}},{key:"update",value:function(){var e=this.handle,t=this.handleStyle,n=this.origin,r=this.panel,a=this.panelStyle
if(n&&r&&e){var i=n.getBoundingClientRect(),c=r.getBoundingClientRect(),o="tcfFlyout--panel",l=Math.max(10,Math.min(window.innerWidth-c.width-10,i.left+.5*(i.width-c.width))),u=Math.max(10,Math.min(c.width-10,i.left+.5*i.width-l))
t.left="".concat(u,"px"),a.left="".concat(l,"px"),i.top+.5*i.height>.5*window.innerHeight?(o+=" above",a.top="".concat(i.top-c.height-5,"px")):(o+=" below",a.top="".concat(i.top+i.height+5,"px")),e.style.left=t.left,r.className=this.panelClassName=o,r.style.left=a.left,r.style.top=a.top}}}]),n}(r.Component)
function vn(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1
if(Reflect.construct.sham)return!1
if("function"==typeof Proxy)return!0
try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}()
return function(){var n,r=ot()(e)
if(t){var a=ot()(this).constructor
n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments)
return it()(this,n)}}var yn=function(e){rt()(n,e)
var t=vn(n)
function n(){var e
return k()(this,n),(e=t.apply(this,arguments)).state={isExpanded:!1},e.handleClose=function(){e.setState({isExpanded:!1})},e.handleMouseDown=function(){e.setState({isExpanded:!0})},e}return O()(n,[{key:"render",value:function(){var e=this.props.uuid,t=this.state.isExpanded
return r.createElement("div",{className:"tcfArrayWidgetMember--headerMore"},r.createElement("div",{className:"tcfArrayWidgetMember--headerMoreButton",onMouseDown:this.handleMouseDown},r.createElement(yt,{name:"material:more_vert"})),t?r.createElement(hn,{onClick:this.handleClose},r.createElement(mn,{onClose:this.handleClose,uuid:e})):null)}}]),n}(r.Component)
function gn(e){return e}function bn(e,t){return t?e?"minus":"plus":e?"done":"edit"}function En(e){var t=e.disabled,n=e.dragSource,a=void 0===n?gn:n,i=e.field,c=e.hasPreview,o=e.isCollapsible,l=e.isExpanded,u=e.model,s=e.onToggleExpanded,f=e.schema,d=[]
return f?(d.push(r.createElement(yt,{key:"icon",name:f.icon})),f.previewImage&&d.push(r.createElement(on,{key:"image",model:u,schema:f})),d.push(r.createElement("div",{className:De()("tcfArrayWidgetMember--headerLabel",{isHidden:!u.__visible}),key:"label"},f.label)),c&&f.previewLabelTemplate&&d.push(r.createElement("div",{className:"tcfArrayWidgetMember--headerPreview",key:"preview"},r.createElement(un,{field:i,model:u})))):d.push(r.createElement(yt,{className:"tcfArrayWidgetMember--headerHandleIcon",key:"handle",name:"move"})),r.createElement("div",{className:"tcfArrayWidgetMember--header"},a(r.createElement("div",{className:De()("tcfArrayWidgetMember--headerHandle",{enabled:!t}),onClick:s},d)),u.__visible?null:r.createElement(yt,{className:"tcfArrayWidgetMember--headerVisibility",name:"material:visibility_off"}),r.createElement("div",{className:"tcfArrayWidgetMember--headerActions"},o?r.createElement(rn,{onClick:s,primary:!t},r.createElement(yt,{name:bn(l,t)})):null,t?null:r.createElement(yn,{uuid:u.__uuid})))}n(168)
var wn=r.memo((function(e){var t=e.field,n=e.model,a=e.mode,i=void 0===a?"default":a,c=e.references,o=e.schemas,l=C.getDefinition("instance").preview({context:{depth:0,references:c,schemas:o},field:t,mode:i,value:n})
try{var u={__html:Wt(l)}
return r.createElement("div",{className:De()("tcfInstancePreview--content",i),dangerouslySetInnerHTML:u})}catch(e){return r.createElement(r.Fragment,null,r.createElement("p",null,r.createElement("span",{className:"tcfIcon material"},"error"),r.createElement("span",null,"Could not render preview.")),e&&"object"===s()(e)&&"message"in e?r.createElement("pre",null,e.message):null)}}),(function(e,t){return e.model===t.model}))
function kn(e){var t=e.className,n=e.field,a=e.model,i=e.mode,c=e.onClick,l=Object(o.d)((function(e){return{references:e.config.references,schemas:e.schemas}})),u=l.references,s=l.schemas
return r.createElement("div",{className:De()("tcfInstancePreview",t,{isClickable:!!c}),onClick:c},r.createElement(wn,{field:n,model:a,mode:i,references:u,schemas:s}))}function Sn(e){var t=r.useContext(Fe),n=t.isExpanded,a=t.toggleExpanded,i=r.useRef(null),c=Gt(e,i),o=Ue()(c,3),l=o[0].isDragging,u=o[1],s=o[2],f=Qt(e,i);(0,Ue()(f,2)[1])(i)
var d=e.child,m=e.depth,p=e.disabled,h=e.field,v=e.isCollapsible,y=e.path,g=e.previewMode,b=e.schema,E=function(){a(d.__uuid)},w=!0,k=!1
if(b){var S=Object.keys(b.fields)
w=S.length>0,k=1===S.length&&"redactor"===b.fields[S[0]].type}var O,C=b&&b.preview&&function(e,t){switch(e){case"always":return!0
case"root":return 1===t}}(g,m),j=w&&(!v||n(d.__uuid))
return j?O=r.createElement("div",{className:"tcfArrayWidgetMember--body"},r.createElement(Pt,{canChangeType:!1,disabled:p,isBorderless:k,key:"details",model:d,path:y,schemaNames:h.schemas})):C&&(O=r.createElement(kn,{className:"tcfArrayWidgetMember--preview",field:h,key:"summary",model:d,onClick:w?E:void 0})),r.createElement("div",{className:De()("tcfArrayWidgetMember depth-".concat(m),j?"isExpanded":"isCollapsed",{isDragging:l}),ref:i},s(r.createElement("div",{className:"tcfArrayWidgetMember--panel"},r.createElement(En,{disabled:p,dragSource:u,field:h,hasPreview:!j&&!C,isCollapsible:w&&v,isExpanded:j,model:d,onToggleExpanded:E,schema:b}),r.createElement(nn,{uri:j?"details":"summary"},O))))}n(293)
function On(e){var t=e.children,n=e.data,a=e.disabled,i=e.field,c=e.model,l=e.onDelete,u=e.onUpdate,s=e.path,f=i.member,d=i.collapsible,m=i.previewMode,p=r.useRef(null),h=Object(o.d)((function(e){return e.schemas})),v=r.useContext(Nt),y=n.map((function(e,t){var n=[].concat(A()(s),[{index:t,name:f.name,type:"index"}]),i={child:e,depth:v,disabled:a,path:n}
return"instance"===f.type?r.createElement(Sn,Object.assign({},i,{isCollapsible:d,field:f,key:e.__uuid,previewMode:m,schema:h[e.__type]})):r.createElement(Zt,Object.assign({},i,{field:f,index:t,key:Re(e)?e.__uuid:t,model:c,onDelete:l,onUpdate:u}))}))
return 0===y.length&&y.push(r.createElement(en,{field:i,key:"droplet",path:s})),r.createElement(r.Fragment,null,r.createElement("div",{className:"tcfArrayWidgetList",ref:p},y),r.createElement("div",{className:"tcfArrayWidgetList--footer"},t))}function Cn(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1
if(Reflect.construct.sham)return!1
if("function"==typeof Proxy)return!0
try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}()
return function(){var n,r=ot()(e)
if(t){var a=ot()(this).constructor
n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments)
return it()(this,n)}}var jn=function(e){rt()(n,e)
var t=Cn(n)
function n(){var e
return k()(this,n),(e=t.apply(this,arguments)).handleAdd=function(t){var n=wt()(e).context,r=e.props,a=r.data,i=r.disabled,c=r.onUpdate
if(!i){var o=Array.isArray(a)?a.slice():[]
o.push(_e(t)),c(o),f(t)&&n&&n.toggleExpanded(t.__uuid,!0)}},e.handleDelete=function(t){var n=e.props,r=n.data,a=n.disabled,i=n.onUpdate
if(!a&&Array.isArray(r)){var c=r.slice()
c.splice(t,1),i(c)}},e.handleUpdate=function(t,n){var r=e.props,a=r.data,i=r.disabled,c=r.onUpdate
if(!i&&Array.isArray(a)){var o=a.slice()
o[t]=_e(n,o[t]),c(o)}},e}return O()(n,[{key:"render",value:function(){var e=this.props,t=e.data,n=e.disabled,a=e.field,i=e.model,c=e.path,o=a.limit
if(!a.member)return null
var l,u=Array.isArray(t)?t:[],s=o>0&&u.length>=o,f=C.getDefinition(a.member)
return n||!f||s||(l=r.createElement(f.factory,{field:a.member,onCreate:this.handleAdd,scope:i.__type})),r.createElement(On,{data:u,disabled:n,field:a,limit:o,model:i,onDelete:this.handleDelete,onUpdate:this.handleUpdate,path:c},l)}}]),n}(r.Component)
function xn(e){if(!e)return e
if(Array.isArray(e))return e.map((function(e){return xn(e)}))
if("object"===s()(e)){var t={}
for(var n in e)t[n]=xn(e[n])
return t}return e}jn.contextType=Fe
n(294)
function Rn(e){var t=e.field,n=e.onCreate,a=Object(o.d)((function(e){return e.schemas}))
return r.createElement("div",{className:"tcfFactory"},r.createElement(Le,{className:"tcfFactory--primaryButton",onClick:function(){var e=C.createValue({field:t,schemas:a})
n(e)},secondary:!0},r.createElement(yt,{name:"plus"}),r.createElement(He,{value:"Create"})))}var _n=function(){function e(t){var n=t.factory,r=t.widget
k()(this,e),this.factory=n||Rn,this.widget=r}return O()(e,[{key:"cloneValue",value:function(e){return Object(J.a)(this,void 0,void 0,X.a.mark((function t(){var n,r
return X.a.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:if(n=e.field,r=e.value,!this.isValue(n,r)){t.next=5
break}return t.abrupt("return",xn(r))
case 5:return t.abrupt("return",this.createValue(e))
case 6:case"end":return t.stop()}}),t,this)})))}}]),e}()
function Nn(e,t){var n
if("undefined"==typeof Symbol||null==e[Symbol.iterator]){if(Array.isArray(e)||(n=function(e,t){if(!e)return
if("string"==typeof e)return Mn(e,t)
var n=Object.prototype.toString.call(e).slice(8,-1)
"Object"===n&&e.constructor&&(n=e.constructor.name)
if("Map"===n||"Set"===n)return Array.from(e)
if("Arguments"===n||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n))return Mn(e,t)}(e))||t&&e&&"number"==typeof e.length){n&&(e=n)
var r=0,a=function(){}
return{s:a,n:function(){return r>=e.length?{done:!0}:{done:!1,value:e[r++]}},e:function(e){throw e},f:a}}throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}var i,c=!0,o=!1
return{s:function(){n=e[Symbol.iterator]()},n:function(){var e=n.next()
return c=e.done,e},e:function(e){o=!0,i=e},f:function(){try{c||null==n.return||n.return()}finally{if(o)throw i}}}}function Mn(e,t){(null==t||t>e.length)&&(t=e.length)
for(var n=0,r=new Array(t);n<t;n++)r[n]=e[n]
return r}function In(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1
if(Reflect.construct.sham)return!1
if("function"==typeof Proxy)return!0
try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}()
return function(){var n,r=ot()(e)
if(t){var a=ot()(this).constructor
n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments)
return it()(this,n)}}var An=function(e){rt()(n,e)
var t=In(n)
function n(){return k()(this,n),t.call(this,{widget:jn})}return O()(n,[{key:"cloneValue",value:function(e){return Object(J.a)(this,void 0,void 0,X.a.mark((function t(){var n,r,a,i,c,o,l,u
return X.a.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:if(n=e.field,r=e.value,a=Object(J.c)(e,["field","value"]),!this.isValue(n,r)){t.next=27
break}i=C.getDefinition(n.member.type),c=[],o=Nn(r),t.prev=5,o.s()
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
case 28:case"end":return t.stop()}}),t,this,[[5,18,21,24]])})))}},{key:"createValue",value:function(e){return[]}},{key:"isValue",value:function(e,t){return Array.isArray(t)}},{key:"preview",value:function(e){return new Jt(e)}}]),n}(_n)
function Pn(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1
if(Reflect.construct.sham)return!1
if("function"==typeof Proxy)return!0
try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}()
return function(){var n,r=ot()(e)
if(t){var a=ot()(this).constructor
n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments)
return it()(this,n)}}var Dn=function(e){rt()(n,e)
var t=Pn(n)
function n(){return k()(this,n),t.apply(this,arguments)}return O()(n,[{key:"createValue",value:function(e){return!!e.field.defaultValue}},{key:"isValue",value:function(e,t){return"boolean"==typeof t||t instanceof Boolean}},{key:"preview",value:function(e){return e.value}}]),n}(_n)
n(295)
function Ln(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1
if(Reflect.construct.sham)return!1
if("function"==typeof Proxy)return!0
try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}()
return function(){var n,r=ot()(e)
if(t){var a=ot()(this).constructor
n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments)
return it()(this,n)}}var Tn=function(e){rt()(n,e)
var t=Ln(n)
function n(){var e
return k()(this,n),(e=t.apply(this,arguments)).id=j(),e}return O()(n,[{key:"render",value:function(){var e=this.id,t=this.props,n=t.className,a=t.children,i=t.disabled,c=t.onChange,o=t.value
return r.createElement("dl",{className:De()("tcfCheckbox",n)},r.createElement("dd",{className:"tcfCheckbox--input"},r.createElement("input",{checked:o,disabled:i,id:e,onChange:i?void 0:function(){return c(!o)},type:"checkbox"})),r.createElement("dt",{className:"tcfCheckbox--label"},r.createElement("label",{htmlFor:e},a)))}}]),n}(r.Component)
function Un(e){var t=e.data,n=e.disabled,a=e.field,i=e.onUpdate
return r.createElement(Tn,{disabled:n,onChange:i,value:!!t},a.label)}function Fn(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1
if(Reflect.construct.sham)return!1
if("function"==typeof Proxy)return!0
try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}()
return function(){var n,r=ot()(e)
if(t){var a=ot()(this).constructor
n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments)
return it()(this,n)}}var Vn=function(e){rt()(n,e)
var t=Fn(n)
function n(){var e
return k()(this,n),(e=t.call(this,{widget:Un})).isAlwaysPlainField=!0,e}return n}(Dn)
function Wn(e){var t=e.red,n=e.green,r=e.blue,a=e.alpha
return{max:Math.max(t,n,r),min:Math.min(t,n,r),red:t/255,green:n/255,blue:r/255,alpha:a}}function Hn(e){return"object"===s()(e)&&"number"==typeof e.alpha&&"number"==typeof e.blue&&"number"==typeof e.green&&"number"==typeof e.red}function Bn(e){e=e.replace(/^#?([a-f\d])([a-f\d])([a-f\d])$/i,(function(e,t,n,r){return t+t+n+n+r+r}))
var t=/^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(e)
return t?{red:parseInt(t[1],16),green:parseInt(t[2],16),blue:parseInt(t[3],16),alpha:1}:null}function zn(e){return"rgba(".concat(e.red,",").concat(e.green,",").concat(e.blue,",").concat(e.alpha,")")}function qn(e){var t=Wn(e),n=t.alpha,r=t.blue,a=t.green,i=t.max,c=t.min,o=t.red,l=0===i?0:(i-c)/i,u=(i-c)/255,s=0,f=i/255
return i===c?{hue:s,saturation:l,value:f,alpha:n}:(s=i===e.red?(a-r)/u+(a<r?6:0):i===e.green?(r-o)/u+2:(o-a)/u+4,{hue:s/=6,saturation:l,value:f,alpha:n})}function $n(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1
if(Reflect.construct.sham)return!1
if("function"==typeof Proxy)return!0
try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}()
return function(){var n,r=ot()(e)
if(t){var a=ot()(this).constructor
n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments)
return it()(this,n)}}var Xn=r.createContext({css:"#000",hsv:{hue:0,saturation:0,value:0,alpha:0},rgb:{red:0,green:0,blue:0,alpha:0},onHsvColor:function(e){},onRgbColor:function(e){}})
function Jn(e){return function(t){return r.createElement(Xn.Consumer,null,(function(n){return r.createElement(e,Object.assign({},t,n))}))}}var Kn=function(e){rt()(n,e)
var t=$n(n)
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
r.setState({css:zn(t),rgb:t,hsv:e}),r.commit()},r.handleRgbColor=function(e){r.setState({css:zn(e),rgb:e,hsv:qn(e)}),r.commit()},r.handleTimeout=function(){r.timeout=null,r.props.onChange(r.state.rgb)},r.state={css:zn(e.color),hsv:qn(e.color),rgb:Object.assign({},e.color)},r}return O()(n,[{key:"render",value:function(){var e=this.props.children
return r.createElement(Xn.Provider,{value:Object.assign(Object.assign({},this.state),{onHsvColor:this.handleHsvColor,onRgbColor:this.handleRgbColor})},e)}}]),n}(r.Component)
n(296)
function Gn(e){var t=e.className,n=Object(J.c)(e,["className"])
return r.createElement("input",Object.assign({className:De()("tcfInput",t)},n))}function Yn(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1
if(Reflect.construct.sham)return!1
if("function"==typeof Proxy)return!0
try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}()
return function(){var n,r=ot()(e)
if(t){var a=ot()(this).constructor
n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments)
return it()(this,n)}}var Qn=Jn(function(e){rt()(n,e)
var t=Yn(n)
function n(){var e
return k()(this,n),(e=t.apply(this,arguments)).state={hasFocus:!1},e.handleBlur=function(){e.setState({hasFocus:!1})},e.handleChange=function(t){var n=t.target.value;(0,e.props.onRgbColor)(e.getColor(n))},e.handleFocus=function(){e.setState({hasFocus:!0})},e}return O()(n,[{key:"getValue",value:function(){var e,t=this.props,n=t.rgb,r=t.type
switch(r){case"alpha":case"blue":case"green":case"red":return"".concat(n[r])
case"hex":return"#"+(16777216+((e=n).blue|e.green<<8|e.red<<16)).toString(16).slice(1)}}},{key:"getColor",value:function(e){var t=this.props,n=t.rgb,r=t.type
switch(r){case"blue":case"green":case"red":var a=parseInt(e)
return Object.assign(Object.assign({},n),M()({},r,isFinite(a)?Math.max(0,Math.min(255,a)):n[r]))
case"alpha":var i=parseFloat(e)
return Object.assign(Object.assign({},n),{alpha:isFinite(i)?Math.max(0,Math.min(1,i)):n.alpha})
case"hex":var c=Bn(e)
return c?Object.assign(Object.assign({},c),{alpha:n.alpha}):n}}},{key:"render",value:function(){var e=this.state.hasFocus,t={className:"tcfColorInputInput",onBlur:this.handleBlur,onChange:this.handleChange,onFocus:this.handleFocus}
return e?t.defaultValue=this.getValue():t.value=this.getValue(),r.createElement(Gn,t)}}]),n}(r.Component))
n(297)
function Zn(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1
if(Reflect.construct.sham)return!1
if("function"==typeof Proxy)return!0
try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}()
return function(){var n,r=ot()(e)
if(t){var a=ot()(this).constructor
n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments)
return it()(this,n)}}var er=Jn(function(e){rt()(n,e)
var t=Zn(n)
function n(){var e
return k()(this,n),(e=t.apply(this,arguments)).element=null,e.state={initialHue:0,isMouseDown:!1,mouseX:0,mouseY:0},e.handleMouseDown=function(t){var n=e.props.hsv
window.addEventListener("mousemove",e.handleMouseMove),window.addEventListener("mouseup",e.handleMouseUp),e.setState(Object.assign(Object.assign({},e.update(t.clientX,t.clientY,n.hue)),{initialHue:n.hue,isMouseDown:!0}))},e.handleMouseMove=function(t){e.setState(e.update(t.clientX,t.clientY))},e.handleMouseUp=function(t){e.stopListening(),e.setState(Object.assign(Object.assign({},e.update(t.clientX,t.clientY)),{isMouseDown:!1}))},e.setElement=function(t){e.element=t},e}return O()(n,[{key:"componentWillUnmount",value:function(){this.stopListening()}},{key:"render",value:function(){var e=this.props.hsv,t=this.state,n=t.initialHue,a=t.isMouseDown,i=t.mouseX,c=t.mouseY
return r.createElement("div",{className:"tcfColorInputSaturation",onMouseDown:this.handleMouseDown,ref:this.setElement,style:{background:"hsl(".concat(360*(a?n:e.hue),", 100%, 50%)")}},r.createElement("div",{className:"tcfColorInputSaturation--value",style:{left:"".concat(100*(a?i:e.saturation),"%"),top:"".concat(100*(a?c:1-e.value),"%")}}))}},{key:"stopListening",value:function(){window.removeEventListener("mousemove",this.handleMouseMove),window.removeEventListener("mouseup",this.handleMouseUp)}},{key:"update",value:function(e,t){var n=arguments.length>2&&void 0!==arguments[2]?arguments[2]:this.state.initialHue,r=this.element
if(!r)return{mouseX:this.state.mouseX,mouseY:this.state.mouseY}
var a=this.props,i=a.hsv,c=a.onHsvColor,o=r.getBoundingClientRect(),l=Math.max(0,Math.min(1,(e-o.left)/o.width)),u=Math.max(0,Math.min(1,(t-o.top)/o.height))
return c({alpha:i.alpha,hue:n,saturation:l,value:1-u}),{mouseX:l,mouseY:u}}}]),n}(r.Component))
n(298)
function tr(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1
if(Reflect.construct.sham)return!1
if("function"==typeof Proxy)return!0
try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}()
return function(){var n,r=ot()(e)
if(t){var a=ot()(this).constructor
n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments)
return it()(this,n)}}var nr=Jn(function(e){rt()(n,e)
var t=tr(n)
function n(){var e
return k()(this,n),(e=t.apply(this,arguments)).element=null,e.handleMouseDown=function(t){window.addEventListener("mousemove",e.handleMouseMove),window.addEventListener("mouseup",e.handleMouseUp),e.update(t.clientX)},e.handleMouseMove=function(t){e.update(t.clientX)},e.handleMouseUp=function(t){e.stopListening(),e.update(t.clientX)},e.setElement=function(t){e.element=t},e}return O()(n,[{key:"componentWillUnmount",value:function(){this.stopListening()}},{key:"render",value:function(){var e,t=this.props,n=t.rgb,a=t.hsv,i=t.type,c=a[i]
if("alpha"===i){var o=n.red,l=n.green,u=n.blue,s="rgba(".concat(o,", ").concat(l,", ").concat(u,", 0)"),f="rgba(".concat(o,", ").concat(l,", ").concat(u,", 1)")
e=r.createElement("div",{className:"tcfColorInputSlider--gradient",style:{background:"linear-gradient(to right, ".concat(s,", ").concat(f,")")}})}return r.createElement("div",{className:"tcfColorInputSlider ".concat(i),onMouseDown:this.handleMouseDown},e,r.createElement("div",{className:"tcfColorInputSlider--track",ref:this.setElement},r.createElement("div",{className:"tcfColorInputSlider--handle",style:{left:"".concat(100*c,"%")}})))}},{key:"stopListening",value:function(){window.removeEventListener("mousemove",this.handleMouseMove),window.removeEventListener("mouseup",this.handleMouseUp)}},{key:"update",value:function(e){var t=this.element
if(t){var n=this.props,r=n.hsv,a=n.onHsvColor,i=n.type,c=t.getBoundingClientRect(),o=Math.max(0,Math.min(1,(e-c.left)/c.width))
a(Object.assign(Object.assign({},r),M()({},i,o)))}}}]),n}(r.Component))
n(299)
var rr=Jn((function(e){var t=e.children,n=e.className,a=e.color,i=e.css,c=e.disabled,o=e.onClick,l=e.onRgbColor
if(a){var u=Bn(a)
u&&(o=function(){l(u)})}return r.createElement("div",{className:De()("tcfColorInputSwatch",n),onClick:c?void 0:o},r.createElement("div",{className:"tcfColorInputSwatch--color",style:{background:a||i}}),t)}))
n(300)
function ar(e){var t=e.disableAlpha,n=e.presetColors,a=[r.createElement("div",{className:"tcfColorInputPicker--value wide",key:"hex"},r.createElement(Qn,{type:"hex"}),r.createElement("div",{className:"tcfColorInputPicker--valueCaption"},"Hex")),r.createElement("div",{className:"tcfColorInputPicker--value",key:"red"},r.createElement(Qn,{type:"red"}),r.createElement("div",{className:"tcfColorInputPicker--valueCaption"},"R")),r.createElement("div",{className:"tcfColorInputPicker--value",key:"green"},r.createElement(Qn,{type:"green"}),r.createElement("div",{className:"tcfColorInputPicker--valueCaption"},"G")),r.createElement("div",{className:"tcfColorInputPicker--value",key:"blue"},r.createElement(Qn,{type:"blue"}),r.createElement("div",{className:"tcfColorInputPicker--valueCaption"},"B"))]
t||a.push(r.createElement("div",{className:"tcfColorInputPicker--value",key:"alpha"},r.createElement(Qn,{type:"alpha"}),r.createElement("div",{className:"tcfColorInputPicker--valueCaption"},"A")))
var i=null
return n&&n.length&&(i=r.createElement("div",{className:"tcfColorInputPicker--presets"},n.map((function(e){return r.createElement(rr,{className:"tcfColorInputPicker--presetsSwatch",color:e})})))),r.createElement("div",{className:"tcfColorInputPicker"},r.createElement(er,null),r.createElement("div",{className:"tcfColorInputPicker--controls"},r.createElement("div",{className:"tcfColorInputPicker--sliders"},r.createElement(nr,{type:"hue"}),t?null:r.createElement(nr,{type:"alpha"})),r.createElement(rr,{className:"tcfColorInputPicker--swatch"})),r.createElement("div",{className:"tcfColorInputPicker--values"},a),i)}n(301)
function ir(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1
if(Reflect.construct.sham)return!1
if("function"==typeof Proxy)return!0
try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}()
return function(){var n,r=ot()(e)
if(t){var a=ot()(this).constructor
n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments)
return it()(this,n)}}var cr=function(e){rt()(n,e)
var t=ir(n)
function n(){var e
return k()(this,n),(e=t.apply(this,arguments)).state={hasColorPicker:!1},e.handleChange=function(t){e.props.onChange(t)},e.handleSwatchClick=function(){e.setState({hasColorPicker:!0})},e.handleOverlayClick=function(){e.setState({hasColorPicker:!1})},e}return O()(n,[{key:"render",value:function(){var e=this.state.hasColorPicker,t=this.props,n=t.color,a=t.disableAlpha,i=t.disabled,c=t.onChange,o=t.presetColors
return r.createElement(Kn,{color:n,onChange:c},r.createElement("div",{className:"tcfColorInput"},r.createElement(rr,{className:"tcfColorInput--swatch",disabled:i,onClick:this.handleSwatchClick},e&&!i?r.createElement(hn,{onClick:this.handleOverlayClick},r.createElement(ar,{disableAlpha:a,presetColors:o})):null),r.createElement(Qn,{type:"hex"})))}}]),n}(r.Component)
function or(e){var t=e.data,n=e.disabled,a=e.field,i=e.onUpdate,c=Hn(t)?t:{alpha:1,blue:255,green:255,red:255}
return r.createElement(cr,{color:c,disableAlpha:!a.alpha,disabled:n,onChange:i,presetColors:a.swatches})}function lr(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1
if(Reflect.construct.sham)return!1
if("function"==typeof Proxy)return!0
try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}()
return function(){var n,r=ot()(e)
if(t){var a=ot()(this).constructor
n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments)
return it()(this,n)}}var ur=function(e){rt()(n,e)
var t=lr(n)
function n(){return k()(this,n),t.call(this,{widget:or})}return O()(n,[{key:"createValue",value:function(e){return{alpha:1,blue:255,green:255,red:255}}},{key:"isValue",value:function(e,t){return Hn(t)}},{key:"preview",value:function(e){e.context,e.value
return""}}]),n}(_n)
function sr(e,t,n){var r,a,i=null,c=null,o=null
function l(){var u=Date.now()-r
u<t&&u>=0?i=window.setTimeout(l,t-u):(i=null,n||(a=e.apply(o,c),i||(o=c=null)))}return function(){o=this,c=arguments,r=Date.now()
var u=n&&!i
return i||(i=window.setTimeout(l,t)),u&&(a=e.apply(o,c),o=c=null),a}}n(302)
function fr(e){var t=e.children,n=e.className,a=e.icon
return r.createElement("div",{className:De()("tcfTextAndIcon",n)},r.createElement(yt,{className:"tcfTextAndIcon--icon",name:a}),r.createElement(He,{className:"tcfTextAndIcon--text",value:t}))}function dr(e){var t=e.children,n=e.title
return r.createElement("div",{className:"tcfErrorMessage"},r.createElement(fr,{icon:"material:error"},n),t)}function mr(e){return"object"===s()(e)&&"string"==typeof e.url}n(303)
function pr(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1
if(Reflect.construct.sham)return!1
if("function"==typeof Proxy)return!0
try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}()
return function(){var n,r=ot()(e)
if(t){var a=ot()(this).constructor
n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments)
return it()(this,n)}}var hr=function(e){rt()(n,e)
var t=pr(n)
function n(){var e
return k()(this,n),(e=t.apply(this,arguments)).request=null,e.state={mode:"idle"},e.handleChange=function(t){e.updateOEmbed(),e.setState({mode:"typing"}),e.props.onUpdate(Object.assign(Object.assign({},e.getOEmbed()),{url:t.target.value}))},e.updateOEmbed=sr((function(){e.setState({mode:"loading"})
var t=e.props,n=t.apiEndpoint,r=t.model,a=t.field,i=["schema=".concat(encodeURIComponent(r.__type)),"field=".concat(encodeURIComponent(a.name)),"url=".concat(encodeURIComponent(e.getOEmbed().url))],c=new XMLHttpRequest
c.onreadystatechange=function(){return e.handleRequestStateChange(c)},c.onerror=function(){return e.handleRequestError()},c.open("GET","".concat(n,"&").concat(i.join("&"))),c.send(),e.request&&e.request.abort(),e.request=c}),500),e}return O()(n,[{key:"getOEmbed",value:function(){var e=this.props.data
return mr(e)?e:{url:""}}},{key:"handleRequestStateChange",value:function(e){if(e.readyState===XMLHttpRequest.DONE){if(200!==e.status)return this.handleRequestError()
var t
try{t=JSON.parse(e.responseText)}catch(e){return this.handleRequestError()}this.setState({mode:"idle"}),this.request=null,this.props.onUpdate(Object.assign(Object.assign({},this.getOEmbed()),{info:t.data}))}}},{key:"handleRequestError",value:function(){this.setState({mode:"idle"}),this.request=null,this.props.onUpdate(Object.assign(Object.assign({},this.getOEmbed()),{info:null}))}},{key:"render",value:function(){var e,t=this.getOEmbed(),n=this.props.disabled,a=this.state.mode
if("typing"===a||"loading"===a)e=r.createElement("div",{className:"tcfOEmbedWidget--activity"},r.createElement("div",{className:"tcfOEmbedWidget--activityBounce first"}),r.createElement("div",{className:"tcfOEmbedWidget--activityBounce second"}),r.createElement("div",{className:"tcfOEmbedWidget--activityBounce third"}))
else if(t.info){var i=t.info,c=i.title,o=i.author_name,l=i.thumbnail_url
e=r.createElement("div",{className:"tcfOEmbedWidget--info"},l?r.createElement("img",{className:"tcfOEmbedWidget--infoImage",src:l}):null,r.createElement("div",{className:"tcfOEmbedWidget--infoContent"},r.createElement("div",{className:"tcfOEmbedWidget--infoTitle"},c),r.createElement("div",{className:"tcfOEmbedWidget--infoAuthor"},o)))}else e=r.createElement(dr,{title:"Invalid embed url"})
return r.createElement("div",{className:"tcfOEmbedWidget"},r.createElement("div",{className:"tcfOEmbedWidget--input"},r.createElement("input",{autoComplete:"off",className:"text fullwidth",disabled:n,onChange:n?void 0:this.handleChange,value:t.url})),e)}}]),n}(r.Component),vr=Object(o.b)((function(e){return{apiEndpoint:e.config.apiEndpoints.oembed}}))(hr),yr=function(){function e(t){k()(this,e),this.value=t}return O()(e,[{key:"toHTML",value:function(){var e=this.value.info
if(!e)return new Oe.SafeString("")
var t=""
return e.thumbnail_url&&(t='<img class="tcfOEmbedWidget--infoImage" src="'.concat(e.thumbnail_url,'" />')),new Oe.SafeString('\n      <div class="tcfOEmbedWidget--info">\n        '.concat(t,'\n        <div class="tcfOEmbedWidget--infoContent">\n          <div class="tcfOEmbedWidget--infoTitle">').concat(e.title,'</div>\n          <div class="tcfOEmbedWidget--infoAuthor">').concat(e.author_name,"</div>\n        </div>\n      </div>\n    "))}},{key:"author",get:function(){return this.value.info?this.value.info.author_name:""}},{key:"thumbnail",get:function(){var e=this.value.info
return e&&e.thumbnail_url?new Oe.SafeString('<img width="100" src='.concat(e.thumbnail_url," />")):""}},{key:"title",get:function(){return this.value.info?this.value.info.title:""}}]),e}()
function gr(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1
if(Reflect.construct.sham)return!1
if("function"==typeof Proxy)return!0
try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}()
return function(){var n,r=ot()(e)
if(t){var a=ot()(this).constructor
n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments)
return it()(this,n)}}Object(J.b)([qt],yr.prototype,"value",void 0),Object(J.b)([qt],yr.prototype,"author",null),Object(J.b)([qt],yr.prototype,"thumbnail",null),Object(J.b)([qt],yr.prototype,"title",null),Object(J.b)([zt],yr.prototype,"toHTML",null)
var br=function(e){rt()(n,e)
var t=gr(n)
function n(){return k()(this,n),t.call(this,{widget:vr})}return O()(n,[{key:"createValue",value:function(e){return{url:""}}},{key:"isValue",value:function(e,t){return mr(t)}},{key:"preview",value:function(e){var t=e.value
return new yr(mr(t)?t:{url:""})}}]),n}(_n)
n(304)
function Er(e){var t=e.favorites,n=e.onSchema,a=e.onToggleFavorite,i=e.schemas.map((function(e){var i=-1!==t.indexOf(e.qualifier)
return r.createElement("div",{className:"tcfSchemaList--row",key:e.qualifier},r.createElement("div",{className:"tcfSchemaList--schema",onMouseUp:function(){return n(e)}},r.createElement(yt,{className:"tcfSchemaList--schemaIcon",name:e.icon}),r.createElement("div",{className:"tcfSchemaList--schemaLabel"},e.label)),a?r.createElement("div",{className:"tcfSchemaList-favorite",onClick:function(){return a(e)}},r.createElement(yt,{name:i?"material:star":"material:star_border"})):null)}))
return r.createElement("div",{className:"tcfSchemaList"},i)}function wr(e){var t,n=e.onCreate,a=e.schemas,i=e.scope,c=r.useState(!1),l=Ue()(c,2),u=l[0],s=l[1],f=Object(o.c)(),d=[],m=null
if(i){var p=Object(o.d)((function(e){return e.user})).favoriteSchemas;(d=i in p?p[i]:[]).length&&(m=a.filter((function(e){return-1!==d.indexOf(e.qualifier)})).map((function(e){return r.createElement(Le,{className:"tcfFactory--quickButton",key:e.qualifier,onClick:function(){return n(e)},secondary:!0},r.createElement(yt,{name:e.icon}),r.createElement("div",null,e.label))}))),t=function(e){f(function(e,t){return function(n,r){var a=r().user.favoriteSchemas,i=e in a?a[e]:[]
i=-1===i.indexOf(t)?[].concat(A()(i),[t]):i.filter((function(e){return e!==t})),n({type:"setUser",user:{favoriteSchemas:Object.assign(Object.assign({},a),M()({},e,i))}})}}(i,e.qualifier))}}return r.createElement("div",{className:"tcfFactory multiple"},r.createElement(Le,{className:"tcfFactory--primaryButton",onMouseDown:function(){return s(!0)}},r.createElement(yt,{name:"plus"}),r.createElement(He,{value:"Create"}),u?r.createElement(hn,{onClick:function(){return s(!1)}},r.createElement(Er,{favorites:d,onSchema:function(e){s(!1),n(e)},onToggleFavorite:t,schemas:a})):null),m)}function kr(e){var t=e.onCreate,n=e.schema
return r.createElement("div",{className:"tcfFactory"},r.createElement(Le,{className:"tcfFactory--primaryButton",onClick:function(){return t(n)}},r.createElement(yt,{name:"plus"}),r.createElement(He,{params:{schema:n.label},value:"Create {schema}"})))}function Sr(e){var t=e.field,n=e.onCreate,a=e.scope,i=Object(o.d)((function(e){return e.schemas})),c=t.schemas.map((function(e){return i[e]})).sort((function(e,t){return e.label.localeCompare(t.label)}))
if(!c.length)return null
var l=function(e){if(-1!==c.indexOf(e))return n(x({schemas:i,schema:e}))}
return c.length>1?r.createElement(wr,{onCreate:l,schemas:c,scope:a}):r.createElement(kr,{onCreate:l,schema:c[0]})}function Or(e){var t=e.children,n=e.disabled,a=e.field,i=e.model,c=r.useContext(Nt),l=Object(o.d)((function(e){return e.schemas})),u=r.useContext(Fe),s=u.isExpanded,f=u.toggleExpanded,d=l[i.__type],m=s(i.__uuid),p=d&&d.preview,h=function(){return f(i.__uuid)},v=null
return m?v=r.createElement("div",{className:"tcfArrayWidgetMember--body"},t):p&&(v=r.createElement(kn,{field:a,model:i,onClick:h})),r.createElement("div",{className:"tcfInstanceWidget--collapsiblePanel depth-".concat(c)},r.createElement(En,{disabled:n,field:a,hasPreview:!m&&!p,isCollapsible:!0,isExpanded:m,model:i,onToggleExpanded:h,schema:d}),r.createElement(nn,{uri:m?"details":"summary"},v))}n(305)
function Cr(e){var t=e.className,n=e.data,a=e.disabled,i=e.field,c=e.path,o=r.createElement(Pt,{canChangeVisibility:!0,disabled:a,model:n,path:[].concat(A()(c),[{type:"property",name:i.name}]),schemaNames:i.schemas})
return i.collapsible&&f(n)?r.createElement(Or,{model:n,disabled:a,field:i},o):r.createElement("div",{className:De()("tcfInstanceWidget",t)},o)}function jr(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1
if(Reflect.construct.sham)return!1
if("function"==typeof Proxy)return!0
try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}()
return function(){var n,r=ot()(e)
if(t){var a=ot()(this).constructor
n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments)
return it()(this,n)}}var xr=function(e){rt()(n,e)
var t=jr(n)
function n(){return k()(this,n),t.call(this,{factory:Sr,widget:Cr})}return O()(n,[{key:"cloneValue",value:function(e){return Object(J.a)(this,void 0,void 0,X.a.mark((function t(){var n,r,a
return X.a.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:if(n=e.field,r=e.value,a=Object(J.c)(e,["field","value"]),!this.isValue(n,r)){t.next=5
break}return t.abrupt("return",K(Object.assign(Object.assign({},a),{source:r})))
case 5:return t.abrupt("return",this.createValue(e))
case 6:case"end":return t.stop()}}),t,this)})))}},{key:"createValue",value:function(e){var t=e.field,n=e.schema,r=e.schemas
if(n||(n=r[t.schemas[0]]),!n)throw new Error("The option `schema` is required when creating instances.")
return x({schema:n,schemas:r})}},{key:"isValue",value:function(e,t){return f(t)&&-1!==e.schemas.indexOf(t.__type)}},{key:"preview",value:function(e){var t=e.context,n=e.mode,r=void 0===n?"default":n,a=e.value
if(!f(a))return""
var i=t.schemas[a.__type]
if(!i)return""
var c="label"===r?i.previewLabelTemplate:i.previewTemplate
if(null===c)return i.label
var o={toHTML:function(){return new Oe.SafeString(c(o,$t()))},toString:function(){return c(o,$t())}}
o.depth=t.depth
for(var l=0,u=Object.keys(i.fields);l<u.length;l++){var s=u[l],d=i.fields[s],m=C.getDefinition(d)
m&&(o[s]=m.preview({context:Object.assign(Object.assign({},t),{depth:t.depth+1}),field:d,value:a[s]}))}return o}}]),n}(_n)
n(117)
function Rr(e){var t,n=e.attribute,a=e.column,i=e.max,c=e.min,o=e.onUpdate,l=Object(J.c)(e,["attribute","column","max","min","onUpdate"]),u=r.useState(null),s=Ue()(u,2),f=s[0],d=s[1],m=a[n],p=le(m,l),h=l.current.key in m
return r.createElement("div",{className:"tcfLayoutEditor--columnInput"},r.createElement("div",{className:De()("tcfLayoutEditor--columnInputLabel",{hasOwnValue:h})},(t=n).charAt(0).toUpperCase()+t.slice(1)),r.createElement(Gn,{className:"tcfLayoutEditor--columnInputField",max:i,min:c,onBlur:function(){return d(null)},onChange:function(e){var t=e.target
d(t.value)
var r=parseInt(t.value)
!isFinite(r)||"number"==typeof c&&r<c||"number"==typeof i&&r>i||o(a.__uuid,M()({},n,se(m,r,l)))},type:"number",value:null===f?p:f}))}function _r(e){var t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:0,n=arguments.length>2&&void 0!==arguments[2]?arguments[2]:1
return e<t?t:e>n?n:e}function Nr(e){for(var t=e.columnsPerRow,n=[],a=0;a<t;a++)n.push(r.createElement("div",{className:"tcfLayoutPreview--gridColumn",key:a}))
return r.createElement("div",{className:"tcfLayoutPreview--grid"},n)}n(307)
function Mr(e){var t=String.fromCharCode(65+e%25),n=Math.floor(e/25)
return y("Column {num}",{num:"".concat(t).concat(n>1?n:"")})}function Ir(e){var t=e.columns,n=e.columnsPerRow,a=e.isSelected,i=e.onClick,c=Object(J.c)(e,["columns","columnsPerRow","isSelected","onClick"])
return r.createElement("div",{className:De()("tcfLayoutPreview",{isClickable:!!i,isSelected:a}),onClick:i},r.createElement(Nr,{columnsPerRow:n}),t.map((function(e,t){var a=le(e.offset,c),i=le(e.order,c),o=le(e.width,c)
return r.createElement("div",{className:"tcfLayoutPreview--col",key:t,style:{marginLeft:"".concat((a/n*100).toFixed(6),"%"),order:i,width:"".concat((o/n*100).toFixed(6),"%")}},r.createElement("div",{className:"tcfLayoutPreview--colPanel"},Mr(t)))})))}function Ar(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1
if(Reflect.construct.sham)return!1
if("function"==typeof Proxy)return!0
try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}()
return function(){var n,r=ot()(e)
if(t){var a=ot()(this).constructor
n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments)
return it()(this,n)}}var Pr=function(e){rt()(n,e)
var t=Ar(n)
function n(){var e
return k()(this,n),(e=t.apply(this,arguments)).element=null,e.initialHandle=!1,e.initialPosition=0,e.isListening=!1,e.state={dragDelta:0,dragMode:"none"},e.handleMouseDown=function(t){e.initialHandle=!1,e.initialPosition=t.clientX,e.startListening()
for(var n=t.target;n;){if(n.classList.contains("tcfLayoutRowEditor--colHandle")){e.initialHandle=!0
break}n=n.parentElement}},e.handleMouseMove=function(t){var n=e.state.dragMode,r=t.clientX-e.initialPosition
"none"===n&&Math.abs(r)>3&&(e.initialPosition=t.clientX,e.setState({dragDelta:0,dragMode:e.initialHandle?"size":"move"})),"none"!==n&&e.setState({dragDelta:r,dragMode:n})},e.handleMouseUp=function(){var t=e.props,n=t.column,r=t.onSelect,a=e.state,i=a.dragDelta,c=a.dragMode,o=e.toColumns(i)
"size"===c?e.applySize(o):"move"===c?e.applyMove(o):r(n.__uuid),e.stopListening(),e.setState({dragDelta:0,dragMode:"none"})},e.setElement=function(t){e.element=t},e}return O()(n,[{key:"applyMove",value:function(e){var t=this.props,n=t.column,r=t.columnsPerRow,a=t.onUpdate,i=_r(this.sample(n.offset)+e,0,r)
a(n.__uuid,{offset:se(n.offset,i,t)})}},{key:"applySize",value:function(e){var t=this.props,n=t.column,r=t.constraints,a=r.maxColumnWidth,i=r.minColumnWidth,c=t.onUpdate,o=_r(this.sample(n.width)+e,i,a)
c(n.__uuid,{width:se(n.width,o,t)})}},{key:"componentWillUnmount",value:function(){this.stopListening()}},{key:"render",value:function(){var e=this.state,t=e.dragDelta,n=e.dragMode,a=this.props,i=a.column,c=a.columnsPerRow,o=a.index,l=a.isSelected,u=this.sample(i.offset),s=this.sample(i.width),f=this.sample(i.order),d="".concat((s/c*100).toFixed(6),"%"),m="".concat((u/c*100).toFixed(6),"%")
return"move"===n?m="calc(".concat(m," + ").concat(t,"px)"):"size"===n&&(d="calc(".concat(d," + ").concat(t,"px)")),r.createElement("div",{className:Pe("tcfLayoutRowEditor--col",{isSelected:l}),onMouseDown:this.handleMouseDown,ref:this.setElement,style:{marginLeft:m,order:f,width:d}},r.createElement("div",{className:"tcfLayoutRowEditor--colPanel"},r.createElement("div",{className:"tcfLayoutRowEditor--colLabel"},Mr(o)),r.createElement("div",{className:"tcfLayoutRowEditor--colHandle"})))}},{key:"sample",value:function(e){return le(e,this.props)}},{key:"startListening",value:function(){this.isListening||(this.isListening=!0,document.addEventListener("mousemove",this.handleMouseMove),document.addEventListener("mouseup",this.handleMouseUp))}},{key:"stopListening",value:function(){this.isListening=!1,document.removeEventListener("mousemove",this.handleMouseMove),document.removeEventListener("mouseup",this.handleMouseUp)}},{key:"toColumns",value:function(e){var t=this.element,n=this.props.columnsPerRow,r=t?t.parentElement:null
if(!r)return 0
var a=r.offsetWidth/n
return Math.round(e/a)}}]),n}(r.Component)
n(308)
function Dr(e){var t=e.columns,n=e.selected,a=Object(J.c)(e,["columns","selected"]),i=a.columnsPerRow
return r.createElement("div",{className:"tcfLayoutRowEditor"},r.createElement(Nr,{columnsPerRow:i}),t.map((function(e,t){return r.createElement(Pr,Object.assign({},a,{column:e,index:t,isSelected:null!==n&&n.__uuid===e.__uuid,key:e.__uuid}))})))}var Lr={xs:"material:smartphone",sm:"material:tablet_mac",md:"material:tablet",lg:"material:laptop",xl:"material:desktop_mac"}
function Tr(e){var t,n=e.columnsPerRow,a=e.constraints,i=e.current,c=e.selected
if(c){var o={breakpoints:e.breakpoints,column:c,current:e.current,onUpdate:e.onUpdate}
t=r.createElement("div",{className:"tcfLayoutEditor--rowAttributes"},r.createElement(Rr,Object.assign({},o,{attribute:"width",max:Math.min(n,a.maxColumnWidth),min:Math.max(1,a.minColumnWidth)})),r.createElement(Rr,Object.assign({},o,{attribute:"offset",min:0,max:n})),r.createElement(Rr,Object.assign({},o,{attribute:"order"})))}else t=r.createElement("div",{className:"tcfLayoutEditor--rowAttributes"})
return r.createElement("div",{className:"tcfLayoutEditor--row"},r.createElement("div",{className:"tcfLayoutEditor--rowHead"},i.key in Lr?r.createElement(yt,{name:Lr[i.key]}):null,r.createElement("span",null,i.label)),r.createElement("div",{className:"tcfLayoutEditor--rowBody"},r.createElement(Dr,Object.assign({},e)),t))}n(309)
function Ur(e){var t=e.onClose,n=e.onCreate,a=e.onDelete,i=Object(J.c)(e,["onClose","onCreate","onDelete"]),c=i.breakpoints,o=i.columns,l=i.constraints,u=l.maxColumns,s=l.minColumns,f=r.useState(o.length?o[0].__uuid:null),d=Ue()(f,2),m=d[0],p=d[1],h=m&&o.find((function(e){return e.__uuid===m}))||null
function v(e){p(e===m?null:e)}return r.createElement(Xe,null,r.createElement(Xe.Content,null,r.createElement("div",{className:"tcfLayoutEditor--title"},r.createElement(He,{value:"Edit columns"})),c.map((function(e){return r.createElement(Tr,Object.assign({},i,{current:e,key:e.key,selected:h,onSelect:v}))}))),r.createElement(Xe.Footer,null,r.createElement("div",{className:"btngroup"},o.length<u?r.createElement(We,{onClick:function(){return p(n())}},r.createElement(yt,{name:"plus"}),r.createElement(He,{value:"Create"})):null,h&&o.length>s?r.createElement(We,{onClick:function(){return a(h.__uuid)}},r.createElement(yt,{name:"minus"}),r.createElement(He,{value:"Delete"})):null),r.createElement(We,{onClick:t,primary:!0},r.createElement(He,{value:"Close"}))))}n(310)
function Fr(e){var t=e.onClose,n=e.onPreset,a=e.preset,i=e.presets,c=Object(J.c)(e,["onClose","onPreset","preset","presets"])
return r.createElement(hn,{onClick:t},r.createElement("div",{className:"tcfLayoutSelect--flyout"},i.map((function(e){return r.createElement(Ir,Object.assign({},c,{columns:e.columns,isSelected:e.key===a,key:e.key,onClick:function(){return n(e)}}))}))))}function Vr(e){var t=e.canEdit,n=e.onPreset,a=e.preset,i=e.presets,c=Object(J.c)(e,["canEdit","onPreset","preset","presets"]),o=c.breakpoints,l=c.columns,u=c.columnsPerRow,s=r.useState(null),f=Ue()(s,2),d=f[0],m=f[1],p=o[o.length-1]
function h(){m(null)}var v=null
return i.length?v="flyout":t&&(v="editor"),r.createElement("div",{className:"tcfLayoutSelect"},r.createElement("div",{className:"tcfLayoutSelect--widget"},r.createElement(Ir,{breakpoints:o,columns:l,columnsPerRow:u,current:p,onClick:v?function(){return m(v)}:void 0}),"flyout"===d?r.createElement(Fr,{breakpoints:c.breakpoints,columnsPerRow:c.columnsPerRow,current:p,onClose:h,onPreset:function(e){n(e),m(null)},preset:a,presets:i}):null),t?r.createElement("div",{className:"tcfLayoutSelect--edit",onClick:function(){return m("editor")}},r.createElement(yt,{name:"material:edit"})):null,"editor"===d?r.createElement(Lt,{onClick:h},r.createElement(Ur,Object.assign({},c,{onClose:h}))):null)}n(311)
function Wr(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1
if(Reflect.construct.sham)return!1
if("function"==typeof Proxy)return!0
try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}()
return function(){var n,r=ot()(e)
if(t){var a=ot()(this).constructor
n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments)
return it()(this,n)}}var Hr=function(e){rt()(n,e)
var t=Wr(n)
function n(){var e
return k()(this,n),(e=t.apply(this,arguments)).handleCreate=function(){var t=e.props,n=t.data,r=t.disabled,a=t.field,i=t.onUpdate
if(!fe(n)||r||n.columns.length>=a.constraints.maxColumns)return null
var c=e.createColumn()
return i(Object.assign(Object.assign({},n),{columns:[].concat(A()(n.columns),[c])})),c.__uuid},e.handleDelete=function(t){var n=e.props,r=n.data,a=n.disabled,i=n.field,c=n.onUpdate
!fe(r)||a||r.columns.length<=i.constraints.minColumns||c(Object.assign(Object.assign({},r),{columns:r.columns.filter((function(e){return e.__uuid!==t}))}))},e.handlePreset=function(t){var n=e.props,r=n.data,a=n.disabled,i=n.field,c=n.onUpdate,o=n.schemas
if(!a&&fe(r)){var l=r.columns.map((function(e){return e.value}))
c(Object.assign(Object.assign({},r),{preset:t.key,columns:t.columns.map((function(e,t){return ce(i,o,e,l.length>t?l[t]:void 0)}))}))}},e.handleUpdate=function(t,n){var r=e.props,a=r.data,i=r.disabled,c=r.onUpdate
if(!i&&fe(a)){var o=Object.keys(n).every((function(e){return"value"===e}))
c(Object.assign(Object.assign({},a),{preset:o?a.preset:null,columns:a.columns.map((function(e){return e.__uuid===t?Object.assign(Object.assign({},e),n):e}))}))}},e}return O()(n,[{key:"createColumn",value:function(){var e=this.props
return ce(e.field,e.schemas)}},{key:"createColumnValue",value:function(){var e=this.props
return oe(e.field,e.schemas)}},{key:"render",value:function(){var e=this,t=this.props,n=t.data,a=t.disabled,i=t.field,c=t.model,o=t.path,l=t.schemas,u=ue(i,l),s=this.context+1,f=fe(n)?n:{columns:[],preset:null},d=f.preset,m=f.columns
return r.createElement("div",{className:"tcfLayoutWidget"},r.createElement(Vr,{breakpoints:i.breakpoints,canEdit:i.canEdit,constraints:i.constraints,columns:m,columnsPerRow:i.columnsPerRow,onCreate:this.handleCreate,onDelete:this.handleDelete,onPreset:this.handlePreset,onUpdate:this.handleUpdate,preset:d,presets:i.presets}),r.createElement("div",{className:De()("tcfLayoutWidget--columns",{isStacked:m.length<=s})},m.map((function(t,n){return r.createElement(Ge,{key:t.__uuid,label:Mr(n)},r.createElement(lt,{data:t.value,disabled:a,errors:null,field:u,model:c,onUpdate:function(n){return e.handleUpdate(t.__uuid,{value:n})},path:[].concat(A()(o),[{name:i.name,type:"property"},{index:n,name:"columns",type:"index"}])}))}))))}}]),n}(r.Component)
Hr.contextType=st
var Br=Object(o.b)((function(e,t){return{schemas:e.schemas}}))(Hr)
function zr(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1
if(Reflect.construct.sham)return!1
if("function"==typeof Proxy)return!0
try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}()
return function(){var n,r=ot()(e)
if(t){var a=ot()(this).constructor
n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments)
return it()(this,n)}}var qr=function(e){rt()(n,e)
var t=zr(n)
function n(){return k()(this,n),t.call(this,{widget:Br})}return O()(n,[{key:"cloneValue",value:function(e){return Object(J.a)(this,void 0,void 0,X.a.mark((function t(){var n,r,a,i,c,o,l,u,s,f
return X.a.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:if(n=e.field,r=e.value,a=Object(J.c)(e,["field","value"]),i=a.schemas,this.isValue(n,r)){t.next=4
break}return t.abrupt("return",this.createValue(e))
case 4:c=ue(n,i),o=C.getDefinition(c),l=[],u=0
case 8:if(!(u<r.columns.length)){t.next=17
break}return s=r.columns[u],t.next=12,o.cloneValue(Object.assign({field:c,value:s.value},a))
case 12:f=t.sent,l.push(ce(n,i,s,f))
case 14:u++,t.next=8
break
case 17:return t.abrupt("return",{__role:"layout",__uuid:j(),preset:r.preset,columns:l})
case 18:case"end":return t.stop()}}),t,this)})))}},{key:"createValue",value:function(e){var t,n=e.field,r=e.schemas,a=this.getDefaultPreset(n)
if(a)t=a.columns.map((function(e){return ce(n,r,e)}))
else for(t=[];t.length<n.constraints.minColumns;)t.push(ce(n,r))
return{__role:"layout",__uuid:j(),preset:a?a.key:null,columns:t}}},{key:"getDefaultPreset",value:function(e){var t=e.defaultPreset,n=e.presets,r=n.length?n[0]:null
return n.find((function(e){return e.key===t}))||r}},{key:"isValue",value:function(e,t){return fe(t)}},{key:"preview",value:function(e){var t=e.context,n=e.field,r=e.value
if(!n)return""
var a=n.breakpoints,i=n.columnsPerRow,c=ue(n,t.schemas),o=C.getDefinition(c),l={breakpoints:a,current:a[a.length-1]},u=r.columns.map((function(e){var n=le(e.order,l),r=le(e.offset,l)/i,a=le(e.width,l)/i,u=["margin-left:".concat((100*r).toFixed(6),"%"),"order:".concat(n),"width:".concat((100*a).toFixed(6),"%")].join(";"),s=o.preview({context:t,field:c,value:e.value})
return'<div style="'.concat(u,'">').concat(Wt(s),"</div>")}))
return new Oe.SafeString('<div class="row">'.concat(u.join(""),"</div>"))}}]),n}(_n)
function $r(e){var t=e.data,n=e.disabled,a=e.onUpdate
return r.createElement(St,{disabled:n,onChange:a,value:!!t})}function Xr(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1
if(Reflect.construct.sham)return!1
if("function"==typeof Proxy)return!0
try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}()
return function(){var n,r=ot()(e)
if(t){var a=ot()(this).constructor
n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments)
return it()(this,n)}}var Jr=function(e){rt()(n,e)
var t=Xr(n)
function n(){return k()(this,n),t.call(this,{widget:$r})}return n}(Dn)
n(169)
function Kr(e,t){var n
if("undefined"==typeof Symbol||null==e[Symbol.iterator]){if(Array.isArray(e)||(n=function(e,t){if(!e)return
if("string"==typeof e)return Gr(e,t)
var n=Object.prototype.toString.call(e).slice(8,-1)
"Object"===n&&e.constructor&&(n=e.constructor.name)
if("Map"===n||"Set"===n)return Array.from(e)
if("Arguments"===n||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n))return Gr(e,t)}(e))||t&&e&&"number"==typeof e.length){n&&(e=n)
var r=0,a=function(){}
return{s:a,n:function(){return r>=e.length?{done:!0}:{done:!1,value:e[r++]}},e:function(e){throw e},f:a}}throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}var i,c=!0,o=!1
return{s:function(){n=e[Symbol.iterator]()},n:function(){var e=n.next()
return c=e.done,e},e:function(e){o=!0,i=e},f:function(){try{c||null==n.return||n.return()}finally{if(o)throw i}}}}function Gr(e,t){(null==t||t>e.length)&&(t=e.length)
for(var n=0,r=new Array(t);n<t;n++)r[n]=e[n]
return r}function Yr(e){var t=r.useRef(null)
return r.useEffect((function(){var n=t.current
if(n){var r,a=cn(),i=Kr(function(e){var t=e.data,n=e.elementType,r=e.references,a=[]
if(Array.isArray(t)){var i,c=Kr(t)
try{var o=function(){var e=i.value,t=r.find((function(t){return t.id===e&&t.type===n}))
t&&a.push(t)}
for(c.s();!(i=c.n()).done;)o()}catch(e){c.e(e)}finally{c.f()}}return a}(e))
try{for(i.s();!(r=i.n()).done;){var c=r.value.$element.clone(!1,!0)
c.appendTo(n),Craft.setElementSize(c,e.viewMode),a.load(c)}}catch(e){i.e(e)}finally{i.f()}}}),[]),r.createElement("div",{className:"elementselect"},r.createElement("div",{className:"elements",ref:t}))}function Qr(e,t){var n
if("undefined"==typeof Symbol||null==e[Symbol.iterator]){if(Array.isArray(e)||(n=function(e,t){if(!e)return
if("string"==typeof e)return Zr(e,t)
var n=Object.prototype.toString.call(e).slice(8,-1)
"Object"===n&&e.constructor&&(n=e.constructor.name)
if("Map"===n||"Set"===n)return Array.from(e)
if("Arguments"===n||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n))return Zr(e,t)}(e))||t&&e&&"number"==typeof e.length){n&&(e=n)
var r=0,a=function(){}
return{s:a,n:function(){return r>=e.length?{done:!0}:{done:!1,value:e[r++]}},e:function(e){throw e},f:a}}throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}var i,c=!0,o=!1
return{s:function(){n=e[Symbol.iterator]()},n:function(){var e=n.next()
return c=e.done,e},e:function(e){o=!0,i=e},f:function(){try{c||null==n.return||n.return()}finally{if(o)throw i}}}}function Zr(e,t){(null==t||t>e.length)&&(t=e.length)
for(var n=0,r=new Array(t);n<t;n++)r[n]=e[n]
return r}function ea(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1
if(Reflect.construct.sham)return!1
if("function"==typeof Proxy)return!0
try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}()
return function(){var n,r=ot()(e)
if(t){var a=ot()(this).constructor
n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments)
return it()(this,n)}}var ta=function(e){rt()(n,e)
var t=ea(n)
function n(){var e
return k()(this,n),(e=t.apply(this,arguments)).element=null,e.renderedIds=[],e.uuid="element-".concat(j()),e.instance=null,e.isRendering=!1,e.handleAdd=function(t){var n=t.elements,r=e.props,a=r.elementType,i=r.onAddReferences
e.handleChange(),i(n.map((function(e){return Object.assign(Object.assign({},e),{$element:$(e.$element[0].outerHTML),element:e.$element[0].outerHTML,type:a})})))},e.handleChange=function(){if(!e.isRendering){var t=e.props.onUpdate,n=e.getSelectedIds()
e.renderedIds=n,t(n)}},e.setElement=function(t){if(e.element!==t){e.element=t
var n=wt()(e).instance
if(n&&(n.off("selectElements",e.handleAdd),n.off("removeElements",e.handleChange),n.elementSort&&n.elementSort.off("sortChange",e.handleChange),n.destroy(),e.instance=n=null),t){var r=e.props,a=r.criteria,i=r.elementType,c=r.limit,o=void 0===c?null:c,l=r.modalStorageKey,u=void 0===l?null:l,s=r.sourceElementId,f=r.sources,d=r.viewMode,m=void 0===d?"small":d
n=new Craft.BaseElementSelectInput({criteria:a,elementType:i,id:e.uuid,limit:o,modalStorageKey:u,name:e.uuid,sources:f,sourceElementId:s,viewMode:m}),e.instance=n,e.createReferences(),n.on("selectElements",e.handleAdd),n.on("removeElements",e.handleChange),n.elementSort&&n.elementSort.on("sortChange",e.handleChange)}}},e}return O()(n,[{key:"componentDidUpdate",value:function(){var e=this.renderedIds,t=this.props.data||[]
t.length===e.length&&t.every((function(t,n){return t===e[n]}))||this.createReferences()}},{key:"createReferences",value:function(){var e=this.instance
if(e){this.isRendering=!0
var t=[]
e.$elementsContainer.empty()
var n,r=Qr(this.getStoredReferences())
try{for(r.s();!(n=r.n()).done;){var a=n.value,i=e.createNewElement(a)
i.find("input").prop("disabled",!0),e.appendElement(i),t.push(a.id)}}catch(e){r.e(e)}finally{r.f()}e.resetElements(),this.renderedIds=t,this.isRendering=!1}}},{key:"getStoredReferences",value:function(){var e=this.props,t=e.data,n=e.elementType,r=e.references,a=[]
if(!Array.isArray(t))return a
var i,c=Qr(t)
try{var o=function(){var e=i.value,t=r.find((function(t){return t.id===e&&t.type===n}))
t&&a.push(t)}
for(c.s();!(i=c.n()).done;)o()}catch(e){c.e(e)}finally{c.f()}return a}},{key:"getSelectedIds",value:function(){var e=this.instance
if(!e)return[]
for(var t=[],n=e.getSelectedElementIds(),r=e.getElements(),a=0;a<r.length;a++){var i=parseInt(r.eq(a).data("id"));-1!==n.indexOf(i)&&t.push(i)}return t}},{key:"render",value:function(){return r.createElement("div",{id:this.uuid,className:"elementselect",ref:this.setElement},r.createElement("div",{className:"elements"}),r.createElement("div",{className:"btn add icon dashed"},"Choose"))}}]),n}(r.Component)
var na=Object(o.b)((function(e){return{references:e.config.references,sourceElementId:e.config.elementId}}),(function(e){return{onAddReferences:function(t){e(E(t))}}}))((function(e){return e.disabled?r.createElement(Yr,Object.assign({},e)):r.createElement(ta,Object.assign({},e))}))
function ra(e){var t=e.disabled,n=e.link,a=e.linkType,i=e.modalStorageKey,c=void 0===i?null:i,o=e.onUpdate
return r.createElement("div",{className:"tcfLinkWidget--editor"},r.createElement(na,{criteria:a.criteria,data:[n.elementId],disabled:t,elementType:a.elementType,limit:1,modalStorageKey:c,onUpdate:function(e){return o(Object.assign(Object.assign({},n),{elementId:e.length?e[0]:0}))},sources:a.sources,viewMode:"small"}),a.allowHash?r.createElement("div",{className:"tcfLinkWidget--editorHash tcfInput--group"},r.createElement("div",{className:"tcfInput--groupLabel"},"#"),r.createElement(Gn,{disabled:t,value:n.hash,onChange:function(e){return o(Object.assign(Object.assign({},n),{hash:e.currentTarget.value}))}})):null)}function aa(e){var t=e.disabled,n=e.link,a=e.linkType,i=e.onUpdate
return r.createElement("div",{className:"tcfLinkWidget--editor"},r.createElement(Gn,{disabled:t,type:a.inputType,value:n.url,onChange:function(e){return i(Object.assign(Object.assign({},n),{url:e.currentTarget.value}))}}))}function ia(e){return"object"===s()(e)&&"number"==typeof e.elementId&&"string"==typeof e.hash&&"string"==typeof e.type&&"string"==typeof e.url}n(312)
function ca(e){var t,n=e.data,a=e.disabled,i=e.field,c=e.model,o=e.onUpdate
t=ia(n)?n:{elementId:0,hash:"",openInNewWindow:!1,type:"",url:""}
var l,u=i.linkTypes[t.type]
u&&"input"===u.type?l=r.createElement(aa,{disabled:a,key:t.type,link:t,linkType:u,onUpdate:o}):u&&"element"===u.type&&(l=r.createElement(ra,{disabled:a,key:t.type,link:t,linkType:u,modalStorageKey:"tcf_".concat(c.__type,"_").concat(i.name,"_").concat(u.type),onUpdate:o}))
var s=i.allowNewWindow
return r.createElement("div",{className:"tcfLinkWidget"},r.createElement("div",{className:"tcfLinkWidget--type"},r.createElement(Qe,{disabled:a,options:Object.keys(i.linkTypes).map((function(e){return{key:e,label:i.linkTypes[e].label}})),value:t.type,onChange:function(e){return o(Object.assign(Object.assign({},t),{type:e}))}})),l,s?r.createElement(Tn,{disabled:a,onChange:function(e){return o(Object.assign(Object.assign({},t),{openInNewWindow:e}))},value:t.openInNewWindow},r.createElement(He,{value:"New window"})):null)}function oa(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1
if(Reflect.construct.sham)return!1
if("function"==typeof Proxy)return!0
try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}()
return function(){var n,r=ot()(e)
if(t){var a=ot()(this).constructor
n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments)
return it()(this,n)}}var la=function(e){rt()(n,e)
var t=oa(n)
function n(){return k()(this,n),t.call(this,{widget:ca})}return O()(n,[{key:"createValue",value:function(){return{elementId:0,hash:"",openInNewWindow:!1,type:"url",url:""}}},{key:"isValue",value:function(e,t){return ia(t)}},{key:"preview",value:function(){return""}}]),n}(_n),ua=function(){function e(t){k()(this,e),this.latitude=t.latitude,this.longitude=t.longitude}return O()(e,[{key:"createStaticMap",value:function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:100,t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:75,n=this.latitude,r=this.longitude,a=xe()
if(!a)return new Oe.SafeString("")
var i=["key=".concat(a),"center=".concat(encodeURIComponent("".concat(n,",").concat(r))),"markers=".concat(encodeURIComponent("size:small|".concat(n,",").concat(r))),"size=".concat(e,"x").concat(t),"zoom=15","maptype=roadmap"].join("&")
return new Oe.SafeString('\n      <img src="https://maps.googleapis.com/maps/api/staticmap?'.concat(i,'" width="').concat(e,'" height="').concat(t,'" />\n    '))}},{key:"toHTML",value:function(){return this.createStaticMap()}}]),e}()
Object(J.b)([qt],ua.prototype,"latitude",void 0),Object(J.b)([qt],ua.prototype,"longitude",void 0),Object(J.b)([zt],ua.prototype,"createStaticMap",null),Object(J.b)([zt],ua.prototype,"toHTML",null)
n(313),n(314)
function sa(e){var t=e.results,n=e.onSelect
return r.createElement("div",{className:""},t.map((function(e){return r.createElement("div",{onClick:function(){return n(e)}},e.formatted_address)})))}function fa(e,t){var n
if("undefined"==typeof Symbol||null==e[Symbol.iterator]){if(Array.isArray(e)||(n=function(e,t){if(!e)return
if("string"==typeof e)return da(e,t)
var n=Object.prototype.toString.call(e).slice(8,-1)
"Object"===n&&e.constructor&&(n=e.constructor.name)
if("Map"===n||"Set"===n)return Array.from(e)
if("Arguments"===n||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n))return da(e,t)}(e))||t&&e&&"number"==typeof e.length){n&&(e=n)
var r=0,a=function(){}
return{s:a,n:function(){return r>=e.length?{done:!0}:{done:!1,value:e[r++]}},e:function(e){throw e},f:a}}throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}var i,c=!0,o=!1
return{s:function(){n=e[Symbol.iterator]()},n:function(){var e=n.next()
return c=e.done,e},e:function(e){o=!0,i=e},f:function(){try{c||null==n.return||n.return()}finally{if(o)throw i}}}}function da(e,t){(null==t||t>e.length)&&(t=e.length)
for(var n=0,r=new Array(t);n<t;n++)r[n]=e[n]
return r}function ma(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1
if(Reflect.construct.sham)return!1
if("function"==typeof Proxy)return!0
try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}()
return function(){var n,r=ot()(e)
if(t){var a=ot()(this).constructor
n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments)
return it()(this,n)}}var pa=["address","street","country","zip","city"],ha=function(e){rt()(n,e)
var t=ma(n)
function n(){var e
return k()(this,n),(e=t.apply(this,arguments)).autocomplete=null,e.input=null,e.state={isSearching:!1},e.handlePlaceChanged=function(){var t=wt()(e).autocomplete
if(t){var n=t.getPlace()
n.geometry&&e.props.onLocation({latitude:n.geometry.location.lat(),longitude:n.geometry.location.lng()})}},e.handleResolve=function(){var t=e.props.places
t&&(e.setState({isSearching:!0}),t.findPlaceFromQuery({query:e.getResolveQuery(),fields:["formatted_address","geometry"]},e.handleResolveResults))},e.handleResolveResults=function(t){e.setState({isSearching:!1}),t||(t=[]),1===t.length?e.handleResultsSelect(t[0]):e.setState({results:t})},e.handleResultsSelect=function(t){var n=t.geometry
if(n){var r=n.location
e.props.onLocation({latitude:r.lat(),longitude:r.lng()}),e.handleResultsCancel()}},e.handleResultsCancel=function(){e.state.results&&e.setState({results:void 0})},e.setInput=function(t){var n=wt()(e).autocomplete
e.input=t,n&&(n.unbindAll(),n=null),t&&((n=new google.maps.places.Autocomplete(t)).setFields(["geometry"]),n.addListener("place_changed",e.handlePlaceChanged)),e.autocomplete=n},e}return O()(n,[{key:"canResolve",value:function(){return""!==this.getResolveQuery()}},{key:"getResolveQuery",value:function(){var e,t=this.props.model,n=[],r=fa(pa)
try{for(r.s();!(e=r.n()).done;){var a=e.value
a in t&&"string"==typeof t[a]&&n.push(t[a].trim())}}catch(e){r.e(e)}finally{r.f()}return n.join(", ")}},{key:"render",value:function(){var e
if(this.canResolve()){var t,n=this.state.results
n&&0===n.length?t=r.createElement(fr,{icon:"material:error"},"No locations found"):n&&(t=r.createElement(sa,{onSelect:this.handleResultsSelect,results:n})),e=r.createElement("div",{className:"tcfLocationFieldSearch--resolve"},t?r.createElement(hn,{onClick:this.handleResultsCancel},t):null,r.createElement(We,{onClick:this.handleResolve},r.createElement(He,{value:"Resolve address"})))}return r.createElement("div",{className:"tcfLocationFieldSearch"},e,r.createElement("input",{className:"tcfLocationFieldSearch--input tcfInput",ref:this.setInput,type:"search"}))}}]),n}(r.Component)
function va(e){return"object"===s()(e)&&"number"==typeof e.latitude&&"number"==typeof e.longitude}n(315)
function ya(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1
if(Reflect.construct.sham)return!1
if("function"==typeof Proxy)return!0
try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}()
return function(){var n,r=ot()(e)
if(t){var a=ot()(this).constructor
n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments)
return it()(this,n)}}var ga
!function(e){e[e.Loading=0]="Loading",e[e.Error=1]="Error",e[e.Ready=2]="Ready"}(ga||(ga={}))
var ba=function(e){rt()(n,e)
var t=ya(n)
function n(){var e
return k()(this,n),(e=t.apply(this,arguments)).element=null,e.marker=null,e.state={instance:null,loadState:ga.Loading},e.handleLocation=function(t){var n=e.state.instance
n&&(n.map.setZoom(17),n.map.setCenter({lat:t.latitude,lng:t.longitude})),e.props.onUpdate(t)},e.handleMarkerDragEnd=function(){var t=wt()(e).marker
if(t){var n=t.getPosition()
n&&e.props.onUpdate({latitude:n.lat(),longitude:n.lng()})}},e.setElement=function(t){var r=e.props.disabled,a=e.state.instance,i=wt()(e).marker
if(a&&(n.stashInstance(a),a=null),i&&(i.setMap(null),i.unbindAll(),i=null),t){a=n.createInstance(),t.appendChild(a.element)
var c=a.map
c.setZoom(17),c.setCenter(e.getLatLng()),(i=new google.maps.Marker({draggable:!r,position:e.getLatLng(),map:c})).addListener("dragend",e.handleMarkerDragEnd)}e.element=t,e.marker=i,e.setState({instance:a})},e}return O()(n,[{key:"componentDidUpdate",value:function(e){var t=this.marker
e.disabled!==this.props.disabled&&t&&t.setOptions({draggable:!this.props.disabled})}},{key:"componentWillMount",value:function(){var e=this
try{(je||(je=new Promise((function(e){window.onGoogleMapsReady=function(){Ee.Loaded,e(google.maps)}
var t=document.createElement("script")
t.src="https://maps.googleapis.com/maps/api/js?key=".concat(we,"&libraries=places&callback=onGoogleMapsReady"),(document.head||document.body).appendChild(t),je=je,Ee.Loading})))).then((function(){e.setState({loadState:ga.Ready})}))}catch(e){this.setState({loadState:ga.Error})}}},{key:"getLatLng",value:function(){var e=this.props.data
return va(e)?{lat:e.latitude,lng:e.longitude}:{lat:0,lng:0}}},{key:"render",value:function(){var e,t=this.state,n=t.loadState,a=t.instance,i=this.props,c=i.disabled,o=i.model,l=this.marker
return l&&l.setPosition(this.getLatLng()),e=n===ga.Loading?r.createElement(xt,null):n===ga.Error?r.createElement(dr,{title:"Could not load Google Maps"}):r.createElement(r.Fragment,null,c?null:r.createElement(ha,{model:o,onLocation:this.handleLocation,places:a?a.places:null}),r.createElement("div",{className:"tcfLocation--map",ref:this.setElement})),r.createElement("div",{className:"tcfLocation"},e)}}],[{key:"createInstance",value:function(){var e=this.instanceStash.pop()
if(!e){var t=document.createElement("div")
t.className="tcfLocation--mapInstance"
var n=new google.maps.Map(t,{mapTypeControl:!1,streetViewControl:!1})
e={element:t,map:n,places:new google.maps.places.PlacesService(n)}}return e}},{key:"stashInstance",value:function(e){var t=e.element,n=t.parentElement
n&&n.removeChild(t),this.instanceStash.push(e)}}]),n}(r.Component)
function Ea(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1
if(Reflect.construct.sham)return!1
if("function"==typeof Proxy)return!0
try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}()
return function(){var n,r=ot()(e)
if(t){var a=ot()(this).constructor
n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments)
return it()(this,n)}}ba.instanceStash=[]
var wa=function(e){rt()(n,e)
var t=Ea(n)
function n(){return k()(this,n),t.call(this,{widget:ba})}return O()(n,[{key:"createValue",value:function(e){var t=e.field
return va(t.defaultValue)?Object.assign({},t.defaultValue):{latitude:0,longitude:0}}},{key:"isValue",value:function(e,t){return va(t)}},{key:"preview",value:function(e){var t=e.value
return new ua(t)}}]),n}(_n)
n(316)
function ka(e){var t=e.data,n=e.disabled,a=e.errors,i=e.field,c=e.onUpdate,o=r.useState(!1),l=Ue()(o,2),u=l[0],s=l[1],f=r.useState(t),d=Ue()(f,2),m=d[0],p=d[1],h=i.max,v=i.min,y=i.placeholder,g=i.unit,b=u?m:t
var E=r.createElement("input",{autoComplete:"off",className:De()("tcfNumberWidget--input text fullwidth",{error:a&&a.length}),disabled:n,max:null===h?void 0:h,min:null===v?void 0:v,onBlur:function(){s(!1),p(t)},onChange:function(e){var t=e.target.value
p(t),c(function(e,t){var n=e.dataType,r=e.defaultValue,a=e.max,i=e.min,c=e.optional,o="integer"===n?parseInt(t):parseFloat(t)
if(isFinite(o))"number"==typeof a&&o>a&&(o=a),"number"==typeof i&&o<i&&(o=i)
else{if(c)return null
o=r}return o}(i,t))},onFocus:function(){s(!0)},placeholder:y,type:"number",value:b})
return g?r.createElement("div",{className:"tcfNumberWidget"},E,r.createElement("div",{className:"tcfNumberWidget--unit"},g)):E}function Sa(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1
if(Reflect.construct.sham)return!1
if("function"==typeof Proxy)return!0
try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}()
return function(){var n,r=ot()(e)
if(t){var a=ot()(this).constructor
n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments)
return it()(this,n)}}function Oa(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1
if(Reflect.construct.sham)return!1
if("function"==typeof Proxy)return!0
try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}()
return function(){var n,r=ot()(e)
if(t){var a=ot()(this).constructor
n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments)
return it()(this,n)}}var Ca=function(e){rt()(n,e)
var t=Oa(n)
function n(){return k()(this,n),t.call(this,{widget:ka})}return n}(function(e){rt()(n,e)
var t=Sa(n)
function n(){return k()(this,n),t.apply(this,arguments)}return O()(n,[{key:"cloneValue",value:function(e){return Object(J.a)(this,void 0,void 0,X.a.mark((function t(){var n,r,a
return X.a.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return n=e.field,r=e.schemas,a=e.value,t.abrupt("return",this.isValue(n,a)?a:this.createValue({field:n,schemas:r}))
case 2:case"end":return t.stop()}}),t,this)})))}},{key:"createValue",value:function(e){return e.field.defaultValue}},{key:"isValue",value:function(e,t){return!(!e.optional||null!==t)||("number"==typeof t||t instanceof Number)}},{key:"preview",value:function(e){return e.value}}]),n}(_n)),ja=function(){function e(t){k()(this,e),this.value=t}return O()(e,[{key:"toHTML",value:function(){return new Oe.SafeString(this.value)}},{key:"summary",get:function(){return new Oe.SafeString('<div class="snippet">'.concat(this.value,"</div>"))}}]),e}()
function xa(e){var t=e.value
return r.createElement("div",{className:"redactor-box redactor-styles-on redactor-toolbar-on focusable-input redactor-focus focus"},r.createElement("div",{className:"redactor-styles redactor-in redactor-in-0",dangerouslySetInnerHTML:{__html:t}}))}Object(J.b)([qt],ja.prototype,"value",void 0),Object(J.b)([zt],ja.prototype,"summary",null),Object(J.b)([zt],ja.prototype,"toHTML",null)
n(317)
function Ra(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1
if(Reflect.construct.sham)return!1
if("function"==typeof Proxy)return!0
try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}()
return function(){var n,r=ot()(e)
if(t){var a=ot()(this).constructor
n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments)
return it()(this,n)}}var _a=function(e){rt()(n,e)
var t=Ra(n)
function n(){var e
return k()(this,n),(e=t.apply(this,arguments)).element=null,e.hasFocus=!1,e.instance=null,e.renderedValue="",e.uuid="element-".concat(j()),e.handleBlur=function(){e.hasFocus=!1},e.handleChange=function(t){e.hasFocus&&(e.renderedValue=t,e.props.onUpdate(t))},e.handleFocus=function(){e.hasFocus=!0},e.setElement=function(t){if(e.element!==t){e.element=t
var n=e.props,r=n.elementSiteId,a=n.options,i=wt()(e).instance
i&&(i.redactor&&(i.redactor.off("blur",e.handleBlur),i.redactor.off("changed",e.handleChange),i.redactor.off("focus",e.handleFocus)),i.destroy(),i=null),t&&(i=new Craft.RedactorInput(Object.assign(Object.assign({},a),{elementSiteId:r,id:e.uuid,redactorConfig:Object.assign({},a.redactorConfig)})),t.removeAttribute("name"),i.redactor&&(i.redactor.on("blur",e.handleBlur),i.redactor.on("changed",e.handleChange),i.redactor.on("focus",e.handleFocus))),e.instance=i}},e}return O()(n,[{key:"componentDidUpdate",value:function(){var e=this.hasFocus,t=this.instance,n=this.props,r=this.renderedValue
t&&!e&&n.value!=r&&(this.renderedValue=n.value,t.redactor.source.setCode(n.value))}},{key:"render",value:function(){var e=this.props.value
return r.createElement("div",{className:"tcfRedactorWidget"},r.createElement("textarea",{defaultValue:"string"==typeof e?e:"",id:this.uuid,ref:this.setElement}))}}]),n}(r.Component)
function Na(e){return e.disabled?r.createElement(xa,Object.assign({},e)):r.createElement(_a,Object.assign({},e))}var Ma=Object(o.b)((function(e){return{elementSiteId:e.config.elementSiteId}}))((function(e){var t=e.data,n=e.disabled,a=e.elementSiteId,i=e.field,c=e.onUpdate
return i.redactor?r.createElement(Na,{disabled:n,elementSiteId:a,onUpdate:c,options:i.redactor,value:t}):null})),Ia=0
function Aa(e,t){return Object(J.a)(this,void 0,void 0,X.a.mark((function n(){var r,a,i,c
return X.a.wrap((function(n){for(;;)switch(n.prev=n.next){case 0:if(!(Ia>2)){n.next=3
break}return console.warn('Translator has returned to many errors, skipping translation for text "'.concat(e,'".')),n.abrupt("return",e)
case 3:return r=t.endpoint,a=Object(J.c)(t,["endpoint"]),i=Object.assign(Object.assign({},a),{text:e}),c=Object.keys(i).map((function(e){return"".concat(e,"=").concat(encodeURIComponent(i[e]))})).join("&"),n.abrupt("return",new Promise((function(t){fetch("".concat(r,"&").concat(c)).then((function(e){return e.json()})).then((function(n){t(n&&n.data?n.data:e)})).catch((function(n){console.error("Translator returned an error: ".concat(n)),Ia+=1,t(e)}))})))
case 7:case"end":return n.stop()}}),n)})))}function Pa(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1
if(Reflect.construct.sham)return!1
if("function"==typeof Proxy)return!0
try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}()
return function(){var n,r=ot()(e)
if(t){var a=ot()(this).constructor
n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments)
return it()(this,n)}}var Da=function(e){rt()(n,e)
var t=Pa(n)
function n(){return k()(this,n),t.apply(this,arguments)}return O()(n,[{key:"cloneValue",value:function(e){return Object(J.a)(this,void 0,void 0,X.a.mark((function t(){var n,r,a
return X.a.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:if(n=e.field,r=e.translate,a=e.value,!this.isValue(n,a)){t.next=9
break}if(!n.translatable||!r){t.next=6
break}return t.abrupt("return",Aa(a,r))
case 6:return t.abrupt("return",a)
case 7:t.next=10
break
case 9:return t.abrupt("return","")
case 10:case"end":return t.stop()}}),t,this)})))}},{key:"createValue",value:function(e){return""}},{key:"isValue",value:function(e,t){return"string"==typeof t||t instanceof String}},{key:"preview",value:function(e){return e.value}}]),n}(_n)
function La(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1
if(Reflect.construct.sham)return!1
if("function"==typeof Proxy)return!0
try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}()
return function(){var n,r=ot()(e)
if(t){var a=ot()(this).constructor
n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments)
return it()(this,n)}}var Ta=function(e){rt()(n,e)
var t=La(n)
function n(){return k()(this,n),t.call(this,{widget:Ma})}return O()(n,[{key:"preview",value:function(e){var t=e.value
return new ja(t)}}]),n}(Da)
n(318)
function Ua(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1
if(Reflect.construct.sham)return!1
if("function"==typeof Proxy)return!0
try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}()
return function(){var n,r=ot()(e)
if(t){var a=ot()(this).constructor
n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments)
return it()(this,n)}}function Fa(e,t){var n
if("undefined"==typeof Symbol||null==e[Symbol.iterator]){if(Array.isArray(e)||(n=function(e,t){if(!e)return
if("string"==typeof e)return Va(e,t)
var n=Object.prototype.toString.call(e).slice(8,-1)
"Object"===n&&e.constructor&&(n=e.constructor.name)
if("Map"===n||"Set"===n)return Array.from(e)
if("Arguments"===n||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n))return Va(e,t)}(e))||t&&e&&"number"==typeof e.length){n&&(e=n)
var r=0,a=function(){}
return{s:a,n:function(){return r>=e.length?{done:!0}:{done:!1,value:e[r++]}},e:function(e){throw e},f:a}}throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}var i,c=!0,o=!1
return{s:function(){n=e[Symbol.iterator]()},n:function(){var e=n.next()
return c=e.done,e},e:function(e){o=!0,i=e},f:function(){try{c||null==n.return||n.return()}finally{if(o)throw i}}}}function Va(e,t){(null==t||t>e.length)&&(t=e.length)
for(var n=0,r=new Array(t);n<t;n++)r[n]=e[n]
return r}var Wa=function(){function e(t){k()(this,e),this.reference=t}return O()(e,[{key:"createPreview",value:function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"large",t=!(arguments.length>1&&void 0!==arguments[1])||arguments[1],n=this.reference,r=n.$element.clone(!1,!0)
r.removeClass("large removable small"),r.addClass(e)
var a=r.find(".elementthumb")
if(a.length){var i=a.find("img")[0]
i||((i=document.createElement("img")).srcset=a.attr("data-srcset")||"",a.append(i)),i.sizes="small"===e?"30px":"100px"}return t?'<div class="tcfInstancePreview--thumb '.concat(e,'">').concat(a?a.html():"","</div>"):r[0].outerHTML}},{key:"createSafePreview",value:function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"large",t=!(arguments.length>1&&void 0!==arguments[1])||arguments[1]
return new Oe.SafeString(this.createPreview(e,t))}},{key:"toHTML",value:function(){return new Oe.SafeString(this.toString())}},{key:"toString",value:function(){return this.createPreview()}},{key:"asBackground",get:function(){var e=this.reference.$element.find(".elementthumb").attr("data-srcset")
if(!e)return null
var t=e.split(",").pop()
return t?new Oe.SafeString('<div class="tcfInstancePreview--background" style="background-image: url(\''.concat(t.trim(),'\');"></div><div class="tcfInstancePreview--background blur" style="background-image: url(\'').concat(t.trim(),"');\"></div>")):null}},{key:"asLargeElement",get:function(){return this.createSafePreview("large",!1)}},{key:"asLargeImage",get:function(){return this.createSafePreview("large",!0)}},{key:"asSmallElement",get:function(){return this.createSafePreview("small",!1)}},{key:"asSmallImage",get:function(){return this.createSafePreview("small",!0)}},{key:"label",get:function(){return this.reference.label}}]),e}()
Object(J.b)([qt],Wa.prototype,"reference",void 0),Object(J.b)([zt],Wa.prototype,"createPreview",null),Object(J.b)([zt],Wa.prototype,"createSafePreview",null),Object(J.b)([qt],Wa.prototype,"asBackground",null),Object(J.b)([qt],Wa.prototype,"asLargeElement",null),Object(J.b)([qt],Wa.prototype,"asLargeImage",null),Object(J.b)([qt],Wa.prototype,"asSmallElement",null),Object(J.b)([qt],Wa.prototype,"asSmallImage",null),Object(J.b)([qt],Wa.prototype,"label",null),Object(J.b)([zt],Wa.prototype,"toHTML",null),Object(J.b)([zt],Wa.prototype,"toString",null)
var Ha=function(e){rt()(n,e)
var t=Ua(n)
function n(e){return k()(this,n),t.call.apply(t,[this].concat(A()(function(e){var t=e.context.references,n=e.field,r=e.value,a=[]
if(!n)return a
var i,c=n.elementType,o=Fa(r)
try{var l=function(){var e=i.value,n=t.find((function(t){return t.id===e&&t.type===c}))
n&&a.push(new Wa(n))}
for(o.s();!(i=o.n()).done;)l()}catch(e){o.e(e)}finally{o.f()}return a}(e))))}return O()(n,[{key:"toHTML",value:function(){return new Oe.SafeString('<div class="tcfInstancePreview--elements">'.concat(this.toString(),"</div>"))}},{key:"toString",value:function(){return this._map((function(e){return Wt(e)})).join("")}},{key:"_map",value:function(e){for(var t=[],n=0;n<this.length;n++)t.push(e(this[n],n))
return t}},{key:"asBackground",get:function(){return this.length?this[0].asBackground:null}},{key:"asLargeElement",get:function(){return this.length?this[0].asLargeElement:null}},{key:"asLargeImage",get:function(){return this.length?this[0].asLargeImage:null}},{key:"asSmallElement",get:function(){return this.length?this[0].asSmallElement:null}},{key:"asSmallImage",get:function(){return this.length?this[0].asSmallImage:null}},{key:"firstLabel",get:function(){return this.length?this[0].label:""}},{key:"label",get:function(){return this._map((function(e){return e.label})).join(", ")}}]),n}(Vt()(Array))
function Ba(e){var t=e.data,n=e.disabled,a=e.field,i=e.model,c=e.onUpdate
return r.createElement(na,{criteria:a.criteria,disabled:n,data:t,elementType:a.elementType,limit:a.limit||null,modalStorageKey:a.modalStorageKey||"tcf_".concat(i.__type,"_").concat(a.name),onUpdate:c,sources:a.sources||null,viewMode:a.viewMode})}function za(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1
if(Reflect.construct.sham)return!1
if("function"==typeof Proxy)return!0
try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}()
return function(){var n,r=ot()(e)
if(t){var a=ot()(this).constructor
n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments)
return it()(this,n)}}Object(J.b)([qt],Ha.prototype,"asBackground",null),Object(J.b)([qt],Ha.prototype,"asLargeElement",null),Object(J.b)([qt],Ha.prototype,"asLargeImage",null),Object(J.b)([qt],Ha.prototype,"asSmallElement",null),Object(J.b)([qt],Ha.prototype,"asSmallImage",null),Object(J.b)([qt],Ha.prototype,"firstLabel",null),Object(J.b)([qt],Ha.prototype,"label",null),Object(J.b)([zt],Ha.prototype,"toHTML",null),Object(J.b)([zt],Ha.prototype,"toString",null)
var qa=function(e){rt()(n,e)
var t=za(n)
function n(){return k()(this,n),t.call(this,{widget:Ba})}return O()(n,[{key:"createValue",value:function(e){return[]}},{key:"isValue",value:function(e,t){return Array.isArray(t)&&t.every((function(e){return"number"==typeof e}))}},{key:"preview",value:function(e){return new Ha(e)}}]),n}(_n)
function $a(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1
if(Reflect.construct.sham)return!1
if("function"==typeof Proxy)return!0
try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}()
return function(){var n,r=ot()(e)
if(t){var a=ot()(this).constructor
n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments)
return it()(this,n)}}var Xa=function(e){rt()(n,e)
var t=$a(n)
function n(){return k()(this,n),t.apply(this,arguments)}return O()(n,[{key:"createValue",value:function(e){var t=e.field
return t.defaultValue&&this.isValue(t,t.defaultValue)?t.defaultValue:t.options[0].key}},{key:"isValue",value:function(e,t){return e.options.some((function(e){return e.key==t}))}},{key:"preview",value:function(e){var t=e.field,n=e.value,r=t?t.options.find((function(e){return e.key===n})):void 0
return r?r.label:"-"}}]),n}(_n)
function Ja(e){var t=e.data,n=e.disabled,a=e.onUpdate,i=e.field
return r.createElement(Qe,{disabled:n,onChange:a,options:i.options,value:t})}function Ka(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1
if(Reflect.construct.sham)return!1
if("function"==typeof Proxy)return!0
try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}()
return function(){var n,r=ot()(e)
if(t){var a=ot()(this).constructor
n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments)
return it()(this,n)}}var Ga=function(e){rt()(n,e)
var t=Ka(n)
function n(){return k()(this,n),t.call(this,{widget:Ja})}return n}(Xa)
n(319)
function Ya(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1
if(Reflect.construct.sham)return!1
if("function"==typeof Proxy)return!0
try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}()
return function(){var n,r=ot()(e)
if(t){var a=ot()(this).constructor
n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments)
return it()(this,n)}}function Qa(e){var t
return e&&(t="color"in e?e.color:e.label),"string"==typeof t?t:"transparent"}var Za=function(e){rt()(n,e)
var t=Ya(n)
function n(){var e
return k()(this,n),(e=t.apply(this,arguments)).state={isExpanded:!1},e.handleFlyoutClick=function(){e.setState({isExpanded:!1})},e.handleSelect=function(t){e.props.onUpdate(t.key),e.setState({isExpanded:!1})},e.handleSwatchClick=function(t){t.currentTarget===t.target&&e.setState({isExpanded:!0})},e}return O()(n,[{key:"render",value:function(){var e=this.props,t=e.data,n=e.disabled,a=e.field,i=this.state.isExpanded,c=a.options.find((function(e){return e.key===t}))
return r.createElement("div",{className:De()("tcfSwatchColorWidget",{isUndecided:!c}),onClick:n?void 0:this.handleSwatchClick,style:{background:c?Qa(c):void 0}},i&&!n?this.renderFlyout(c):null)}},{key:"renderFlyout",value:function(e){var t=this,n=this.props.field
return r.createElement(hn,{onClick:this.handleFlyoutClick},r.createElement("div",{className:"tcfSwatchColorWidget--swatches"},n.options.map((function(n){return r.createElement("div",{className:De()("tcfSwatchColorWidget--swatch",{isSelected:n===e}),key:n.key,onClick:function(){return t.handleSelect(n)},style:{background:Qa(n)}})}))))}}]),n}(r.Component)
function ei(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1
if(Reflect.construct.sham)return!1
if("function"==typeof Proxy)return!0
try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}()
return function(){var n,r=ot()(e)
if(t){var a=ot()(this).constructor
n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments)
return it()(this,n)}}var ti=function(e){rt()(n,e)
var t=ei(n)
function n(){return k()(this,n),t.call(this,{widget:Za})}return n}(Xa)
function ni(e){var t=e.data,n=e.disabled,a=e.errors,i=e.field,c=i.maxLength,o=i.minLength,l=i.placeholder,u=i.inputType,s=e.onUpdate
return r.createElement("input",{autoComplete:"off",className:De()("tcfTextWidget text fullwidth",{error:a&&a.length}),disabled:n,maxLength:c,minLength:o,onChange:function(e){return s(e.target.value)},placeholder:l,type:u,value:t?"".concat(t):""})}function ri(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1
if(Reflect.construct.sham)return!1
if("function"==typeof Proxy)return!0
try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}()
return function(){var n,r=ot()(e)
if(t){var a=ot()(this).constructor
n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments)
return it()(this,n)}}var ai=function(e){rt()(n,e)
var t=ri(n)
function n(){return k()(this,n),t.call(this,{widget:ni})}return n}(Da)
n(320)
function ii(e){var t=e.data,n=e.disabled,a=e.field,i=a.maxLength,c=a.minLength,o=a.monospace,l=a.placeholder,u=a.rows,s=e.onUpdate
return r.createElement("textarea",{className:De()("tcfTextareaWidget text fullwidth",{monospace:o}),disabled:n,maxLength:i,minLength:c,onChange:function(e){return s(e.target.value)},placeholder:l,rows:u,value:t})}function ci(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1
if(Reflect.construct.sham)return!1
if("function"==typeof Proxy)return!0
try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}()
return function(){var n,r=ot()(e)
if(t){var a=ot()(this).constructor
n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments)
return it()(this,n)}}var oi=function(e){rt()(n,e)
var t=ci(n)
function n(){return k()(this,n),t.call(this,{widget:ii})}return n}(Da)
C.initialize({array:new An,checkbox:new Vn,color:new ur,instance:new xr,layout:new qr,lightswitch:new Jr,link:new la,location:new wa,number:new Ca,oembed:new br,redactor:new Ta,reference:new qa,select:new Ga,swatchcolor:new ti,text:new ai,textarea:new oi})
function li(e,t,n){t.classList.toggle("tcfDetailsToggle--collapsed",e.isCollapsed),n.classList.toggle("focus",e.isCollapsed)}function ui(){try{var e=JSON.parse(sessionStorage.getItem("tcfDetailsToggleState")||"{}")
if(t=e,"object"!==s()(t)||"boolean"!=typeof t.isCollapsed)throw new Error("Invalid details state.")
return e}catch(e){return{isCollapsed:!1}}var t}!function(){var e=ui(),t=document.getElementById("main-content")
if(t){var n=document.createElement("div")
n.className="tcfDetailsToggle btn",n.innerHTML='<div class="tcfIcon craft">general</div>',n.addEventListener("click",(function(){e.isCollapsed=!e.isCollapsed,function(e){sessionStorage.setItem("tcfDetailsToggleState",JSON.stringify(e))}(e),li(e,t,n)})),t.insertBefore(n,t.firstElementChild),li(e,t,n)}}()
n(321)
function si(e,t){var n
if("undefined"==typeof Symbol||null==e[Symbol.iterator]){if(Array.isArray(e)||(n=function(e,t){if(!e)return
if("string"==typeof e)return fi(e,t)
var n=Object.prototype.toString.call(e).slice(8,-1)
"Object"===n&&e.constructor&&(n=e.constructor.name)
if("Map"===n||"Set"===n)return Array.from(e)
if("Arguments"===n||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n))return fi(e,t)}(e))||t&&e&&"number"==typeof e.length){n&&(e=n)
var r=0,a=function(){}
return{s:a,n:function(){return r>=e.length?{done:!0}:{done:!1,value:e[r++]}},e:function(e){throw e},f:a}}throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}var i,c=!0,o=!1
return{s:function(){n=e[Symbol.iterator]()},n:function(){var e=n.next()
return c=e.done,e},e:function(e){o=!0,i=e},f:function(){try{c||null==n.return||n.return()}finally{if(o)throw i}}}}function fi(e,t){(null==t||t>e.length)&&(t=e.length)
for(var n=0,r=new Array(t);n<t;n++)r[n]=e[n]
return r}var di=[],mi={},pi={create:function(e){try{var t=null,n=document.getElementById(e)
if(!n)throw new Error("Root element not found.")
var l=n.querySelector(".tcfField--app"),u=n.querySelector('script[type="application/json"]'),s=n.querySelector("input.tcfField--model")
if(!s||!l||!u)throw new Error("Missing components.")
var f=Object(c.c)(Ut,Me(u,s),Object(c.a)(i.a))
di.push(f),f.subscribe((function(){var e=window.draftEditor,n=JSON.stringify(f.getState().model)
s.value!==n&&e&&(t&&window.clearTimeout(t),t=window.setTimeout((function(){e.checkForm(),t=null}),500)),s.value=n})),a.render(r.createElement(o.a,{store:f},r.createElement(Tt,null)),l)}catch(e){console.error("Could not start content editor: "+e.message)}},getInstanceApi:function(e){var t,n=si(di)
try{for(n.s();!(t=n.n()).done;){var r=t.value,a=d(r.getState(),e)
return a?be(r,a):null}}catch(e){n.e(e)}finally{n.f()}},getValidator:function(e){return e in mi?mi[e]:null},registerValidator:function(e,t){mi[e]=t}}
if(window){var hi=window;(hi.lenz||(hi.lenz={})).contentField=pi}var vi=t.default=pi}})
