"use strict"
function _wrapNativeSuper(e){var t="function"==typeof Map?new Map:void 0
return(_wrapNativeSuper=function(e){function n(){return _construct(e,arguments,_getPrototypeOf(this).constructor)}if(null===e||!_isNativeFunction(e))return e
if("function"!=typeof e)throw new TypeError("Super expression must either be null or a function")
if(void 0!==t){if(t.has(e))return t.get(e)
t.set(e,n)}return n.prototype=Object.create(e.prototype,{constructor:{value:n,enumerable:!1,writable:!0,configurable:!0}}),_setPrototypeOf(n,e)})(e)}function isNativeReflectConstruct(){if("undefined"==typeof Reflect||!Reflect.construct)return!1
if(Reflect.construct.sham)return!1
if("function"==typeof Proxy)return!0
try{return Date.prototype.toString.call(Reflect.construct(Date,[],function(){})),!0}catch(e){return!1}}function _construct(e,t,n){return(_construct=isNativeReflectConstruct()?Reflect.construct:function(e,t,n){var r=[null]
r.push.apply(r,t)
var a=new(Function.bind.apply(e,r))
return n&&_setPrototypeOf(a,n.prototype),a}).apply(null,arguments)}function _isNativeFunction(e){return-1!==Function.toString.call(e).indexOf("[native code]")}function _possibleConstructorReturn(e,t){return!t||"object"!==_typeof(t)&&"function"!=typeof t?_assertThisInitialized(e):t}function _assertThisInitialized(e){if(void 0===e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called")
return e}function _getPrototypeOf(e){return(_getPrototypeOf=Object.setPrototypeOf?Object.getPrototypeOf:function(e){return e.__proto__||Object.getPrototypeOf(e)})(e)}function _inherits(e,t){if("function"!=typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function")
e.prototype=Object.create(t&&t.prototype,{constructor:{value:e,writable:!0,configurable:!0}}),t&&_setPrototypeOf(e,t)}function _setPrototypeOf(e,t){return(_setPrototypeOf=Object.setPrototypeOf||function(e,t){return e.__proto__=t,e})(e,t)}function _slicedToArray(e,t){return _arrayWithHoles(e)||_iterableToArrayLimit(e,t)||_nonIterableRest()}function _nonIterableRest(){throw new TypeError("Invalid attempt to destructure non-iterable instance")}function _iterableToArrayLimit(e,t){var n=[],r=!0,a=!1,i=void 0
try{for(var l,o=e[Symbol.iterator]();!(r=(l=o.next()).done)&&(n.push(l.value),!t||n.length!==t);r=!0);}catch(e){a=!0,i=e}finally{try{r||null==o.return||o.return()}finally{if(a)throw i}}return n}function _arrayWithHoles(e){if(Array.isArray(e))return e}function _classCallCheck(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}function _defineProperties(e,t){for(var n=0;n<t.length;n++){var r=t[n]
r.enumerable=r.enumerable||!1,r.configurable=!0,"value"in r&&(r.writable=!0),Object.defineProperty(e,r.key,r)}}function _createClass(e,t,n){return t&&_defineProperties(e.prototype,t),n&&_defineProperties(e,n),e}function _defineProperty(e,t,n){return t in e?Object.defineProperty(e,t,{value:n,enumerable:!0,configurable:!0,writable:!0}):e[t]=n,e}function _toConsumableArray(e){return _arrayWithoutHoles(e)||_iterableToArray(e)||_nonIterableSpread()}function _nonIterableSpread(){throw new TypeError("Invalid attempt to spread non-iterable instance")}function _iterableToArray(e){if(Symbol.iterator in Object(e)||"[object Arguments]"===Object.prototype.toString.call(e))return Array.from(e)}function _arrayWithoutHoles(e){if(Array.isArray(e)){for(var t=0,n=new Array(e.length);t<e.length;t++)n[t]=e[t]
return n}}function _typeof(e){return(_typeof="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e})(e)}var contentField=function(e,t,n,r,a,i,l,o,s,c){function u(e,t){var n=e.schemas[t.__type]
if(!n)throw new Error('Could not resolve schema "'.concat(t.__type,'".'))
return n}function d(e){return e&&"object"===_typeof(e)&&"__type"in e&&"__uuid"in e}function f(e,t,n){if(d(n)&&n.__uuid===t)return{model:n,path:[],uuid:t}
for(var r=u(e,n),a=0,i=Object.keys(r.fields);a<i.length;a++){var l=i[a],o=r.fields[l]
if("array"===o.type&&"instance"===o.member.type){var s=n[l]
if(!Array.isArray(s))continue
for(var c=0;c<s.length;c++){var m=f(e,t,s[c])
if(null!==m)return m.path.unshift({type:"index",name:l,index:c}),m}}else if("instance"===o.type){var h=f(e,t,n[l])
if(null!==h)return h.path.unshift({type:"property",name:l}),h}}return null}function m(e,t){return f(e,t,e.model)}function h(e){for(var t=[],n=e;n.length;){var r=/^([^\[\.]+)(?:\[(\d+)\])?\.?/.exec(n)
if(!r)throw new Error('Invalid path segment "'.concat(n,'" in path "').concat(e,'".'))
n=n.substr(r[0].length),3===r.length?t.push({index:parseInt(r[1]),name:r[2],type:"index"}):t.push({name:r[1],type:"property"})}return t}function p(e,t){if(!(t.name in e))return null
var n=e[t.name]
return"index"===t.type?!Array.isArray(n)||t.index<0||t.index>=n.length?null:n[t.index]:n}function v(e,t){"string"==typeof t&&(t=h(t))
for(var n=e,r=0;r<t.length;r++)if(!(n=p(n,t[r])))return n
return n}function y(e,t){var n=(t="string"==typeof t?h(t):t.slice()).pop()
if(!n)return null
var r=v(e.model,t)
if(!r)throw new Error("Could not resolve owner")
var a=u(e,r),i="index"===n.type?n.index:void 0,l=a.fields[n.name]
if(!l)throw new Error('Could not resolve field "'.concat(n.name,'" on schema "').concat(a.qualifier,'".'))
return{field:l,index:i,owner:r,path:t,schema:a}}function g(e,t){return Craft.t("contentfield",e,t)}function b(){return null}function E(e){e.owner
return null}function C(e){e.owner
return null}function _(e,t,n){if(!t)return n(e)
var r,a=e[t.name]
if("index"===t.type){if(!Array.isArray(a))throw new Error("Invalid array access.")
if(t.index<0||t.index>=a.length)throw new Error("Invalid array index ".concat(t.index,'".'));(r=a.slice())[t.index]=n(a[t.index])}else{if(Array.isArray(a))throw new Error("Invalid array access.")
r=n(a)}var i=Object.assign({},e)
return i[t.name]=r,i}function w(e,t,n){function r(e){return i=a.shift(),i?e?_(e,i,r):e:n(e)}var a="string"==typeof t?h(t):t.slice(),i=a.shift()
return _(e,i,r)}function k(e,t,n){var r=e.fields[n].validatorId
if(!r)return null
var a=Xr.getValidator(r)
if(!a)return null
var i=[]
return a(n,t[n],i),i}function S(e,t){if(d(t)){var n=e.schemas[t.__type]
n&&(t.__errors=Object.keys(n.fields).reduce(function(e,r){var a=k(n,t,r)
return a&&a.length&&(e[r]=a),e},{}))}}function x(e,t){var n=t.uuid,r=m(e,n)
if(!r)return e
var a=y(e,r.path)
if(!a||"array"!==a.field.type||void 0===a.index)return e
var i=a.field,l=a.index,o=a.path,s=i.name
return Object.assign({},e,{model:w(e.model,o,function(t){if(!(t&&s in t))return t
var n=t[s]
if(!Array.isArray(n))return t
var r=_toConsumableArray(n)
r.splice(l,1)
var a=Object.assign({},t,_defineProperty({},s,r))
return S(e,a),a})})}function N(e){return{type:"uuidRemove",uuid:e}}function O(e){var t=e.owner,n=e.location.uuid
return t&&"array"===t.field.type?{group:bn.Manipulation,icon:"material:delete",id:"delete",invoke:function(e){e(N(n))},label:g("Delete")}:null}function I(e,t){var n=e.config.references.slice(),r=!0,a=!1,i=void 0
try{for(var l,o=t.references[Symbol.iterator]();!(r=(l=o.next()).done);r=!0)!function(){var e=l.value
n.some(function(t){var n=t.id,r=t.type
return e.id===n&&e.type===r})||(e.$element=$(e.element),e.hasThumb=e.$element.hasClass("hasthumb"),n.push(e))}()}catch(e){a=!0,i=e}finally{try{r||null==o.return||o.return()}finally{if(a)throw i}}return Object.assign({},e,{config:Object.assign({},e.config,{references:n})})}function R(e){return{references:e,type:"addReferences"}}function A(){return"10000000-1000-4000-8000-100000000000".replace(/[018]/g,function(e){return(e^crypto.getRandomValues(new Uint8Array(1))[0]&15>>e/4).toString(16)})}function M(e){for(var t=e.schemas,n=e.schema,r=e.oldModel,a={__errors:{},__type:n.qualifier,__uuid:A()},i=0,l=Object.keys(n.fields);i<l.length;i++){var o=l[i],s=n.fields[o],c=En.getDefinition(s),u=r&&o in r?r[o]:void 0
void 0!==u&&c.isValue(s,u)||(u=c.createValue({field:s,schemas:t})),a[o]=u}return a}function P(e,t){var n=e.schemas[t.newType]
return n?Object.assign({},e,{model:w(e.model,t.path,function(t){return M({oldModel:t,schema:n,schemas:e.schemas})})}):e}function T(e,t){return{newType:t,path:e,type:"changeType"}}function j(e,t){return e.name===t.name&&e.type===t.type&&("index"!==e.type||"index"!==t.type||e.index===t.index)}function L(e){var t=e.sourcePath,n=e.sourceSegment,r=e.targetPath,a=e.targetSegment,i=[].concat(_toConsumableArray(r),[a])
if(i.length>t.length&&t.every(function(e,t){return j(e,i[t])})){var l=i[t.length]
if("index"!=l.type)throw new Error("Path segment type mismatch")
if(l.name==n.name&&l.index>n.index){i[t.length]=Object.assign({},l,{index:l.index-1})
var o=i.pop()
if(!o||"index"!==o.type)throw new Error("Unsupported operation")
return Object.assign({},e,{targetPath:i,targetSegment:o})}}return e}function U(e,t){return e.length===t.length&&e.every(function(e,n){return j(e,t[n])})}function F(e,t){var n=t.sourcePath,r=t.sourceSegment,a=t.targetPath,i=t.targetSegment,l=[].concat(_toConsumableArray(n),[r]),o=[].concat(_toConsumableArray(a),[i]),s=v(e.model,a)
if(!s)return!1
var c=e.schemas[s.__type].fields[i.name],u=s[i.name]
if("array"!==c.type||!Array.isArray(u))return!1
var d=L(t)
if(U(l,o)||U(l,[].concat(_toConsumableArray(d.targetPath),[d.targetSegment])))return!1
if(!(U(n,a)&&i.name===r.name)&&c.limit>0&&u.length>=c.limit)return!1
var f=c.member,m=En.getDefinition(f.type),h=v(e.model,l)
return m.isValue(f,h)}function W(e,t){var n=e.model
if(!F(e,t))throw new Error("Invalid operation")
var r=L(t),a=r.sourcePath,i=r.sourceSegment,l=r.targetPath,o=r.targetSegment,s=v(n,[].concat(_toConsumableArray(a),[i]))
return n=w(n,a,function(e){if(!e)throw new Error("Invalid operation")
var t=e[i.name]
if(!Array.isArray(t))throw new Error("Invalid operation")
return(t=t.slice()).splice(i.index,1),Object.assign({},e,_defineProperty({},i.name,t))}),n=w(n,l,function(e){if(!e)throw new Error("Could not find target")
var t=e[o.name]
if(!Array.isArray(t))throw new Error("Unsupported operation")
return t=t.slice(),o.index>=t.length?t.push(s):t.splice(o.index,0,s),Object.assign({},e,_defineProperty({},o.name,t))}),Object.assign({},e,{model:n})}function D(e){return Object.assign({},e,{type:"moveModel"})}function V(e,t){var n=t.overlay
return Object.assign({},e,{overlay:n})}function z(e){return{overlay:e,type:"setOverlay"}}function B(e,t){var n=t.user,r=Object.assign({},e.user,n)
try{window.localStorage.setItem(Cn,JSON.stringify(r))}catch(e){console.error(e)}return Object.assign({},e,{user:r})}function H(e){return{type:"setUser",user:e}}function q(e,t){var n=t.direction,r=t.uuid,a=m(e,r)
if(!a)return e
var i=y(e,a.path)
if(!i||"array"!==i.field.type||void 0===i.index)return e
var l=i.field,o=i.index,s=i.path,c=l.name
return Object.assign({},e,{model:w(e.model,s,function(t){if(!(t&&c in t))return t
var r=t[c]
if(!Array.isArray(r))return t
var a=o+("up"===n?-1:1),i=_toConsumableArray(r),l=i.splice(o,1)
i.splice.apply(i,[a,0].concat(_toConsumableArray(l)))
var s=Object.assign({},t,_defineProperty({},c,i))
return S(e,s),s})})}function X(e,t){return{direction:t,type:"uuidOrder",uuid:e}}function G(e,t){var n=t.path,r=t.key,a=t.value
return Object.assign({},e,{model:w(e.model,n,function(t){var n=r?Object.assign({},t,_defineProperty({},r,a)):a
return S(e,n),n})})}function Y(e,t,n){return{path:e,key:t,type:"updateValue",value:n}}function J(e,t){var n=t.sync,r=e.overlay
return r&&"synchronize"===r.type&&(r=Object.assign({},r,{preventClose:"working"===n.status})),Object.assign({},e,{overlay:r,sync:n})}function Q(e){return{sync:e,type:"updateSync"}}function K(e,t){var n={}
for(var r in e)Object.prototype.hasOwnProperty.call(e,r)&&t.indexOf(r)<0&&(n[r]=e[r])
if(null!=e&&"function"==typeof Object.getOwnPropertySymbols)for(var a=0,r=Object.getOwnPropertySymbols(e);a<r.length;a++)t.indexOf(r[a])<0&&Object.prototype.propertyIsEnumerable.call(e,r[a])&&(n[r[a]]=e[r[a]])
return n}function Z(e,t,n,r){return new(n||(n=Promise))(function(a,i){function l(e){try{s(r.next(e))}catch(e){i(e)}}function o(e){try{s(r.throw(e))}catch(e){i(e)}}function s(e){e.done?a(e.value):new n(function(t){t(e.value)}).then(l,o)}s((r=r.apply(e,t||[])).next())})}function ee(e){var t=e.source,n=K(e,["source"])
return Z(this,void 0,void 0,regeneratorRuntime.mark(function e(){var r,a,i,l,o,s,c
return regeneratorRuntime.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:if(r=n.schemas[t.__type]){e.next=3
break}throw new Error("Invalid source schema.")
case 3:a={__errors:{},__originalUuid:t.__uuid,__type:r.qualifier,__uuid:A()},i=0,l=Object.keys(r.fields)
case 5:if(!(i<l.length)){e.next=15
break}return o=l[i],s=r.fields[o],c=En.getDefinition(s),e.next=11,c.cloneValue(Object.assign({},n,{field:s,value:t[o]}))
case 11:a[o]=e.sent
case 12:i++,e.next=5
break
case 15:return e.abrupt("return",a)
case 16:case"end":return e.stop()}},e)}))}function te(e){return"object"===_typeof(e)&&"object"===_typeof(e.data)&&!0===e.result&&Array.isArray(e.references)}function ne(e){var t=e.apiEndpoint,n=K(e,["apiEndpoint"]),r=Object.keys(n).map(function(e){return"".concat(e,"=").concat(encodeURIComponent(n[e]))}).join("&")
return new Promise(function(e,n){fetch("".concat(t,"&").concat(r)).then(function(e){return e.json()}).then(function(t){te(t)?e(t):n(t&&t.message?"".concat(t.message):"An unknown error has occured.")}).catch(function(e){n("".concat(e))})})}function re(e){if(!Array.isArray(e))return[]
var t=[],n=!0,r=!1,a=void 0
try{for(var i,l=e[Symbol.iterator]();!(n=(i=l.next()).done);n=!0){var o=i.value
d(o)&&t.push(o)}}catch(e){r=!0,a=e}finally{try{n||null==l.return||l.return()}finally{if(r)throw a}}return t}function ae(e,t){return e.__uuid===t.__uuid||e.__uuid===t.__originalUuid||e.__originalUuid===t.__uuid||e.__originalUuid===t.__originalUuid}function ie(e){var t=e.field,n=e.source,r=e.target,a=K(e,["field","source","target"])
return Z(this,void 0,void 0,regeneratorRuntime.mark(function e(){var i,l,o,s,c,u,d,f,m
return regeneratorRuntime.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:if("instance"===t.member.type){e.next=2
break}return e.abrupt("return",n||[])
case 2:i=re(n),l=re(r),o=[],s=!0,c=!1,u=void 0,e.prev=8,d=regeneratorRuntime.mark(function e(){var t,n,r
return regeneratorRuntime.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:if(t=m.value,n=l.findIndex(function(e){return ae(e,t)}),r=void 0,-1!==n){e.next=9
break}return e.next=6,ee(Object.assign({},a,{source:t}))
case 6:r=e.sent,e.next=12
break
case 9:return e.next=11,le(Object.assign({},a,{source:t,target:l[n]}))
case 11:r=e.sent
case 12:r&&o.push(r)
case 13:case"end":return e.stop()}},e)}),f=i[Symbol.iterator]()
case 11:if(s=(m=f.next()).done){e.next=16
break}return e.delegateYield(d(),"t0",13)
case 13:s=!0,e.next=11
break
case 16:e.next=22
break
case 18:e.prev=18,e.t1=e.catch(8),c=!0,u=e.t1
case 22:e.prev=22,e.prev=23,s||null==f.return||f.return()
case 25:if(e.prev=25,!c){e.next=28
break}throw u
case 28:return e.finish(25)
case 29:return e.finish(22)
case 30:return e.abrupt("return",o)
case 31:case"end":return e.stop()}},e,null,[[8,18,22,30],[23,,25,29]])}))}function le(e){var t=e.source,n=e.target,r=K(e,["source","target"])
return Z(this,void 0,void 0,regeneratorRuntime.mark(function e(){var a,i,l,o,s,c
return regeneratorRuntime.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:if(d(t)){e.next=2
break}return e.abrupt("return",n)
case 2:if(d(n)&&n.__type===t.__type){e.next=4
break}return e.abrupt("return",ee(Object.assign({},r,{source:t})))
case 4:if(a=r.schemas[t.__type]){e.next=7
break}throw new Error("Invalid schema")
case 7:i=Object.assign({},n),l=0,o=Object.keys(a.fields)
case 9:if(!(l<o.length)){e.next=25
break}if(s=o[l],"array"!==(c=a.fields[s]).type){e.next=18
break}return e.next=15,ie(Object.assign({},r,{field:c,source:t[s],target:n[s]}))
case 15:i[s]=e.sent,e.next=22
break
case 18:if("instance"!==c.type){e.next=22
break}return e.next=21,le(Object.assign({},r,{source:t[s],target:n[s]}))
case 21:i[s]=e.sent
case 22:l++,e.next=9
break
case 25:return e.abrupt("return",i)
case 26:case"end":return e.stop()}},e)}))}function oe(e,t,n){var r=e.siteId,a=e.translate
return Z(this,void 0,void 0,regeneratorRuntime.mark(function e(){var i,l,o,s,c,u,f,m
return regeneratorRuntime.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:if(t(Q({status:"working"})),i=n(),l=i.config,o=i.model,s=i.schemas,"number"==typeof l.elementId){e.next=4
break}throw new Error("Entry must be saved before it can be synchronized.")
case 4:return e.next=6,ne({apiEndpoint:l.apiEndpoints.fetchSite,elementId:l.elementId,fieldHandle:l.fieldHandle,siteId:r})
case 6:if(c=e.sent,u=c.data,f=c.references,d(u)&&l.rootSchemas.some(function(e){return e===u.__type})){e.next=11
break}throw new Error("Selected target site does not contain a valid model.")
case 11:if(d(o)&&o.__type===u.__type){e.next=17
break}return e.next=14,ee({schemas:s,source:u,translate:a})
case 14:e.t0=e.sent,e.next=20
break
case 17:return e.next=19,le({schemas:s,source:u,target:o,translate:a})
case 19:e.t0=e.sent
case 20:m=e.t0,t(R(f)),t(Y([],void 0,m)),t(Q({status:"finished"}))
case 24:case"end":return e.stop()}},e)}))}function se(e){var t=this
return function(n,r){return Z(t,void 0,void 0,regeneratorRuntime.mark(function t(){return regeneratorRuntime.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:return t.prev=0,t.next=3,oe(e,n,r)
case 3:t.next=8
break
case 5:t.prev=5,t.t0=t.catch(0),n(Q({status:"error",message:"".concat(t.t0)}))
case 8:case"end":return t.stop()}},t,null,[[0,5]])}))}}function ce(e,t){return function(n,r){var a=r().user.favoriteSchemas,i=e in a?a[e]:[]
i=-1===i.indexOf(t)?[].concat(_toConsumableArray(i),[t]):i.filter(function(e){return e!==t}),n(H({favoriteSchemas:Object.assign({},a,_defineProperty({},e,i))}))}}function ue(e){var t=e.location.uuid
return{group:bn.Manipulation,icon:"material:edit",id:"edit",invoke:function(e){e(z({type:"edit",uuid:t}))},label:g("Edit")}}function de(e){var t=e.location.uuid,n=e.owner
if(!n||"array"!==n.field.type)return null
var r=n.owner[n.field.name]
return!Array.isArray(r)||void 0===n.index||n.index>=r.length-1?null:{group:bn.Movement,icon:"material:arrow_downward",id:"moveDown",invoke:function(e){return e(X(t,"down"))},label:g("Move down")}}function fe(e){var t=e.location.uuid,n=e.owner
if(!n||"array"!==n.field.type)return null
var r=n.owner[n.field.name]
return!Array.isArray(r)||void 0===n.index||n.index<=0?null:{group:bn.Movement,icon:"material:arrow_upward",id:"moveUp",invoke:function(e){return e(X(t,"up"))},label:g("Move up")}}function me(e){e.owner
return null}function he(e,t){var n=m(e,t),r=[]
if(!n)return r
var a={location:n,owner:y(e,n.path),state:e}
return wn.map(function(e){return e(a)}).filter(function(e){return null!==e})}function pe(e,t){var n=t.uuid,r=null
return{getCommands:function(){return he(e.getState(),n).map(function(t){return Object.assign({},t,{invoke:function(){return t.invoke(e.dispatch)}})})},subscribe:function(t){r&&r(),r=e.subscribe(t)},unsubscribe:function(){r&&r(),r=null}}}function ve(e){Sn=e}function ye(){return Sn}function ge(){return Nn||(Nn=new Promise(function(e){window.onGoogleMapsReady=function(){On=kn.Loaded,e(google.maps)}
var t=document.createElement("script")
t.src="https://maps.googleapis.com/maps/api/js?key=".concat(Sn,"&libraries=places&callback=onGoogleMapsReady"),(document.head||document.body).appendChild(t),Nn=Nn,On=kn.Loading}))}function be(e){return e&&"object"===_typeof(e)&&"__uuid"in e}function Ee(e){switch(_typeof(e)){case"boolean":return new Boolean(e)
case"number":return new Number(e)
case"object":return e
default:return new String(e)}}function Ce(e,t){if(be(e))return e
var n=Ee(e)
return Object.defineProperty(n,"__uuid",{value:t&&be(t)?t.__uuid:A()}),n}function _e(e,t){for(var n=t[e.__type].fields,r=0,a=Object.keys(n);r<a.length;r++)!function(){var i=a[r],l=n[i]
"array"===l.type?e[i]=e[i].map(function(e){return"instance"===l.member.type?_e(e,t):Ce(e)}):"instance"===l.type&&(e[i]=_e(e[i],t))}()
return e}function we(e){return"string"==typeof e&&""!==e.trim()?gn.compile(e):null}function ke(e){return Object.keys(e).reduce(function(t,n){return Array.isArray(e[n])?Object.assign({},t,_defineProperty({},n,e[n])):t},{})}function Se(){try{var e=window.localStorage.getItem(Cn)
if(null===e)throw new Error("User state missing")
var t=JSON.parse(e).favoriteSchemas
return{favoriteSchemas:ke(void 0===t?{}:t)}}catch(e){}return{favoriteSchemas:{}}}function xe(e,t){var n=JSON.parse(e.innerHTML)
n.user=Se(),n.sync={status:"idle"},n.config.references=n.config.references.map(function(e){var t=l(e.element)
return Object.assign({},e,{$element:t,hasThumb:t.hasClass("hasthumb")})})
for(var r=0,a=Object.keys(n.schemas);r<a.length;r++){var i=a[r],o=n.schemas[i]
o.previewTemplate=we(o.preview),o.previewLabelTemplate=we(o.previewLabel)||o.previewTemplate}ve(n.config.googleMapsApiKey)
var s=void 0
1===n.config.rootSchemas.length&&(s=n.schemas[n.config.rootSchemas[0]])
try{n.model=_e(JSON.parse(t.value),n.schemas)}catch(e){}return!s||d(n.model)&&n.model.__type===s.qualifier||(n.model=M({oldModel:n.model,schema:s,schemas:n.schemas})),n}function Ne(e){var n=e.children,r=e.className,a=e.outline,i=e.secondary,l=K(e,["children","className","outline","secondary"])
return t.createElement("div",Object.assign({},l,{className:In("tcfButtonFlat",r,{outline:a,secondary:i})}),n)}function Oe(e){var n=e.children,r=e.onClick,a=e.primary,i=e.secondary
return t.createElement("div",{className:In("tcfButton btn",{submit:a,secondary:i}),onClick:function(e){e.preventDefault(),r()}},n)}function Ie(e){var n=e.field,r=En.getDefinition(n).widget
return t.createElement(r,e)}function Re(e){var n=e.children,r=e.isBorderless,a=e.label,i=e.style
return a&&""!==a&&a!==Rn?t.createElement("div",{className:"tcfFieldGroup",style:i},t.createElement("div",{className:"tcfFieldGroup--label"},a),t.createElement("div",{className:"tcfFieldGroup--content"},n)):t.createElement("div",{className:In("tcfFieldGroup--content",{isBorderless:r}),style:i},n)}function Ae(e){var n=e.children,r=e.className,a=e.errors,i=e.instructions,l=e.isPlainField,o=e.isRequired,s=e.label,c=e.style
if(l)return t.createElement(t.Fragment,null,n)
var u=a&&a.length
return t.createElement("div",{className:In("tcfFieldPanel",r),style:c},t.createElement("div",{className:In("tcfFieldPanel--label",{hasErrors:u,isRequired:o})},s),i?t.createElement("div",{className:"tcfFieldPanel--instructions"},i):null,a&&a.length?t.createElement("ul",{className:"tcfFieldPanel--errors"},a.map(function(e,n){return t.createElement("li",{className:"tcfFieldPanel--error",key:n},e)})):null,n)}function Me(e){var n=e.children,r=K(e,["children"]),a=_slicedToArray(t.useState(xn.Large),2),i=a[0],l=a[1],o=t.useRef(null)
return t.useEffect(function(){var e=window.ResizeObserver,t=o.current,n=-1,r=0
if(t){var a=function(){var e=t.offsetWidth
e!==r&&l((r=e)>920?xn.Large:r>580?xn.Medium:xn.Small)}
if(e){var i=new e(a)
return i.observe(t),function(){return i.unobserve(t)}}return function e(){n=window.requestAnimationFrame(e),a()}(),function(){return window.cancelAnimationFrame(n)}}},[]),t.createElement("div",Object.assign({ref:o},r),t.createElement(An.Provider,{value:i},n))}function Pe(e,t){if(t)switch(e){case xn.Small:return t.small
case xn.Large:return t.large
default:return t.medium}}function Te(e){var n=e.className,r=e.params,a=e.value
return t.createElement("span",{className:n},g(a,r))}function je(e,t){return e.index-t.index}function Le(e){var n=e.disabled,r=void 0!==n&&n,a=e.isBorderless,i=e.model,l=e.onUpdate,o=e.path,s=e.schema,c=t.useContext(An)
if(!s)return t.createElement("div",null,'Could not resolve schema for "'.concat(i.__type,'"'))
var u=[],d=Object.keys(s.fields),f=void 0
if(0===d.length)return t.createElement("div",{className:"tcfInstanceForm--empty"},t.createElement(Te,{value:"This element has no properties."}))
for(var m=0,h=d;m<h.length;m++)!function(){var e=h[m],n=s.fields[e],d=i.__errors[e]||null,p=En.getDefinition(n).isAlwaysPlainField
if(!f||n.group){var v=n.group?n.group.label:void 0,y=n.group?Pe(c,n.group.style):void 0
f={index:v===Rn?-1:u.length,label:v,fields:[],style:y},u.push(f)}f.fields.push(t.createElement(Ae,{errors:d,instructions:n.instructions,isPlainField:a||p,isRequired:n.isRequired,key:n.name,label:n.label,style:Pe(c,n.style)},t.createElement(Ie,{data:i[n.name],disabled:r,errors:d,field:n,model:i,onUpdate:function(t){return l(e,t)},path:o})))}()
var p=u.sort(je).map(function(e){return t.createElement(Re,{isBorderless:a,key:e.index,label:e.label,style:e.style},e.fields)}),v=Pe(c,s.style)
return v?t.createElement("div",{className:"tcfInstanceForm",style:v},p):t.createElement(t.Fragment,null,p)}function Ue(e){var n=e.children,r=e.width
return t.createElement("div",{className:"tcfWindow",style:{width:r}},n)}function Fe(e){var n=e.children,r=_slicedToArray(t.useState([]),2),a=r[0],i=r[1],l=function(e){return-1!==a.indexOf(e)},o=function(e,t){var n=_toConsumableArray(a)
void 0===t&&(t=-1===a.indexOf(e)),t?n.push(e):n=n.filter(function(t){return t!==e}),i(n)}
return t.createElement(Tn.Provider,{value:{expanded:a,isExpanded:l,toggleExpanded:o}},n)}function We(e){var n=e.className,r=e.name,a=e.size,i="craft"
return r.startsWith(Fn)?(i="material",r=r.substr(Fn.length)):r.startsWith(Un)&&(r=r.substr(Un.length)),t.createElement("div",{className:In("tcfIcon",n,i,a)},r)}function De(e){var n=e.message,r=e.onClose
return t.createElement(t.Fragment,null,t.createElement(Pn.Content,null,t.createElement("div",{className:"tcfSynchronize--message"},t.createElement(We,{className:"tcfSynchronize--messageIcon error",name:"material:error",size:"huge"}),t.createElement("div",{className:"tcfSynchronize--title"},"An error has occured"),n?t.createElement("div",{className:"tcfSynchronize--message"},n):null)),t.createElement(Pn.Footer,null,t.createElement(Oe,{onClick:r},"Close")))}function Ve(e){var n=e.onClose
return t.createElement(t.Fragment,null,t.createElement(Pn.Content,null,t.createElement("div",{className:"tcfSynchronize--message"},t.createElement(We,{className:"tcfSynchronize--messageIcon finished",name:"material:check_circle",size:"huge"}),t.createElement("div",{className:"tcfSynchronize--title"},t.createElement(Te,{value:"Sites have been synchronized"})),t.createElement("div",{className:"tcfSynchronize--message"},t.createElement(Te,{value:"If you are not happy with the results, do not save the entry. Reload this page to revert all changes."})))),t.createElement(Pn.Footer,null,t.createElement(Oe,{onClick:n},t.createElement(Te,{value:"Close"}))))}function ze(e,t){return e.label.localeCompare(t.label)}function Be(e){function n(e){var t=e.target.selectedIndex,n=null
u&&(t-=1),t>=0&&t<l.length&&(n=l[t].key),(null!==n||r)&&s(n)}var r=e.allowUndecided,a=e.disabled,i=void 0!==a&&a,l=e.options,o=e.value,s=e.onChange,c=l.findIndex(function(e){return e.key==o}),u=r||-1===c
return t.createElement("div",{className:"tcfSelect"},t.createElement("select",{className:"tcfSelect--select",disabled:i,value:-1==c?void 0:c,onChange:i?void 0:n},u?t.createElement("option",null,"(None)"):null,l.map(function(e,n){return t.createElement("option",{key:n,value:n},e.indent?"--".repeat(e.indent)+" ":null,e.label)})))}function He(){return t.createElement("div",{className:"tcfActivityIndicator"},t.createElement("div",{className:"tcfActivityIndicator--bounce first"}),t.createElement("div",{className:"tcfActivityIndicator--bounce second"}),t.createElement("div",{className:"tcfActivityIndicator--bounce third"}))}function qe(){return t.createElement(Pn.Content,null,t.createElement("div",{className:"tcfSynchronize--working"},t.createElement(He,null)))}function $e(){var e,n=i.useSelector(function(e){return e.sync}),r=i.useDispatch(),a=function(){return r(z(null))}
return e="working"===n.status?t.createElement(qe,null):"error"===n.status?t.createElement(De,{message:n.message,onClose:a}):"finished"===n.status?t.createElement(Ve,{onClose:a}):t.createElement(Vn,{onClose:a}),t.createElement(Pn,{width:600},e)}function Xe(e){if(!e)return null
switch(e.type){case"edit":return t.createElement(Ln,Object.assign({},e))
case"synchronize":return t.createElement($e,null)}}function Ge(e){var n=e.children,r=t.useContext(zn)
return t.createElement(zn.Provider,{value:r+1},n)}function Ye(){var e=i.useDispatch(),n=i.useSelector(function(e){return e.model}),r=i.useSelector(function(e){return e.overlay}),a=i.useSelector(function(e){return e.config}),l=a.disabled,o=a.rootSchemas,u=a.supportedSites.length>1,d=function(){r&&!r.preventClose&&e(z(null))},f=function(){e(Q({status:"idle"})),e(z({type:"synchronize"}))}
return t.createElement(c.DndProvider,{backend:s},t.createElement(Fe,null,u&&!l?t.createElement("div",{className:"tcfRoot--options"},t.createElement(Ne,{onClick:f,outline:!0},t.createElement(We,{name:"material:sync"}),t.createElement(Te,{value:"Synchronize translations"}))):null,t.createElement(Bn,{disabled:l,model:n,path:[],schemaNames:o}),r?t.createElement(Hn,{onClick:d},Xe(r)):null))}function Je(){return{config:{apiEndpoints:{fetchSite:"",oembed:"",translate:""},disabled:!1,elementId:null,elementSiteId:0,fieldHandle:"",hasTranslator:!1,references:[],rootSchemas:[],supportedSites:[]},model:{__errors:{},__type:"unknown",__uuid:"0"},overlay:null,schemas:{},sync:{status:"idle"},user:{favoriteSchemas:{}}}}function Qe(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:Je(),t=arguments.length>1?arguments[1]:void 0
return t.type in _n?_n[t.type](e,t):e}function Ke(e){for(;"string"!=typeof e;)e=e.toHTML()
return e}function Ze(e){var t=e.context,n=e.field,r=e.value
if(!n)return[]
var a=n.member,i=En.getDefinition(a)
return r.map(function(e){return i.preview({value:e,field:a,context:t})})}function et(e,t){var n={data:e.child,height:100,path:e.path,type:"MEMBER"}
return c.useDrag({item:n,begin:function(){return{data:e.child,height:t.current?t.current.clientHeight:100,path:e.path,type:"MEMBER"}},canDrag:function(){return!e.disabled},collect:function(e){return{isDragging:e.isDragging()}},isDragging:function(t){return U(e.path,t.getItem().path)}})}function tt(e,t,n){var r=n.current,a=t.getClientOffset()
if(!r||!a||!e)return null
var i=r.getBoundingClientRect(),l=i.bottom,o=i.top,s=a.y-o
return r.classList.contains("isExpanded")&&s>32&&s<l-o-32?null:(s>(l-o)/2&&(e.targetSegment=Object.assign({},e.targetSegment,{index:e.targetSegment.index+1})),e)}function nt(e,t){var n=e.path.slice(),r=n.pop()
if(!r||"index"!==r.type)return null
var a=t.path.slice(),i=a.pop()
return i&&"index"===i.type?{sourcePath:a,sourceSegment:i,targetPath:n,targetSegment:r}:null}function rt(e,t){var n=i.useStore()
return c.useDrop({accept:"MEMBER",drop:function(e){return{item:e}},hover:function(r,a){if(a.isOver({shallow:!0})){var i=tt(nt(e,r),a,t)
if(i&&F(n.getState(),i)){var l=D(i),o=L(l),s=o.targetPath,c=o.targetSegment
r.path=[].concat(_toConsumableArray(s),[c]),n.dispatch(l)}}}})}function at(e){var n=e.child,r=e.depth,a=e.disabled,i=e.field,l=e.index,o=e.model,s=e.onDelete,c=e.onUpdate,u=e.path,d=t.useRef(null),f=_slicedToArray(et(e,d),3),m=f[0].isDragging,h=f[1],p=f[2];(0,_slicedToArray(rt(e,d),2)[1])(d)
var v=function(){s(l)},y=function(e){c(l,e)}
return t.createElement("div",{className:In("tcfArrayWidgetMember depth-".concat(r),{isDragging:m}),ref:d},p(t.createElement("div",{className:"tcfArrayWidgetMember--panel tcfArrayWidgetMember--single"},h(t.createElement("div",{className:In("tcfArrayWidgetMember--singleHandle",{enabled:!a})},t.createElement(We,{className:"tcfArrayWidgetMember--singleHandleIcon",key:"handle",name:"move"}))),t.createElement("div",{className:"tcfArrayWidgetMember--singleBody"},t.createElement(Ie,{data:n,disabled:a,errors:[],field:i,model:o,onUpdate:y,path:u})),a?null:t.createElement("div",{className:"tcfArrayWidgetMember--singleActions"},t.createElement("div",{className:"tcfArrayWidgetMember--singleActionsButton",onClick:v},t.createElement(We,{name:"remove"}))))))}function it(e,t){var n=t.path.slice(),r=n.pop()
return r&&"index"===r.type?{sourcePath:n,sourceSegment:r,targetPath:e.path,targetSegment:{type:"index",index:0,name:e.field.name}}:null}function lt(e){var t=i.useStore()
return c.useDrop({accept:"MEMBER",drop:function(e){return{item:e}},hover:function(n,r){if(r.isOver({shallow:!0})){var a=it(e,n)
if(a&&F(t.getState(),a)){var i=D(a),l=L(i),o=l.targetPath,s=l.targetSegment
n.path=[].concat(_toConsumableArray(o),[s]),t.dispatch(i)}}}})}function ot(e){var n=t.useRef(null)
return(0,_slicedToArray(lt(e),2)[1])(n),t.createElement("div",{className:"tcfArrayWidgetList--empty",key:"empty",ref:n},t.createElement(Te,{value:"Drop elements here"}))}function st(e){var n=e.children,r=e.onClick,a=e.primary
return t.createElement("div",{className:In("tcfArrayWidgetMember--headerActionsButton",{primary:a}),onClick:function(e){e.preventDefault(),r()}},n)}function ct(){return null===Xn&&(Xn=new Craft.ElementThumbLoader),Xn}function ut(e,t){var n=t.previewImage
if(!n)return null
var r=n in e?e[n]:null
if(!Array.isArray(r)||0===r.length)return null
var a=r[0]
return"number"==typeof a?a:null}function dt(e){var n=e.className,r=e.model,a=e.schema,l=e.size,o=void 0===l?"small":l,s=t.useRef(null),c=i.useSelector(function(e){return e.config.references}),u=ut(r,a),d=c.find(function(e){return e.id===u})
return t.useEffect(function(){if(s.current){var e=$(".element",s.current)
Craft.setElementSize(e,o),ct().load(e)}},[s.current]),d&&d.hasThumb?t.createElement("div",{className:In("tcfInstancePreviewImage",n,o),dangerouslySetInnerHTML:{__html:d.element},ref:s}):t.createElement("div",{className:In("tcfInstancePreviewImage empty",n,o)})}function ft(e){var n=_slicedToArray(i.useSelector(function(e){return[e.config.references,e.schemas]}),2),r=n[0],a=n[1]
return t.createElement(Gn,Object.assign({},e,{references:r,schemas:a}))}function mt(e){var n=e.command,r=e.onClick
return t.createElement("div",{className:"tcfArrayWidgetMember--headerMoreItem",onMouseUp:r},t.createElement(We,{className:"tcfArrayWidgetMember--headerMoreItemIcon",name:n.icon}),t.createElement("span",{className:"tcfArrayWidgetMember--headerMoreItemLabel"},n.label))}function ht(e){var n,r=e.commands,a=e.dispatch,i=e.onClose,l=[],o=!0,s=!1,c=void 0
try{for(var u,d=r[Symbol.iterator]();!(o=(u=d.next()).done);o=!0){(function(){var e=u.value
if("edit"===e.id)return"continue"
void 0!==n&&n!==e.group&&l.push(t.createElement("div",{className:"tcfArrayWidgetMember--headerMoreDivider",key:"".concat(e.id,"-divider")})),n=e.group,l.push(t.createElement(mt,{command:e,key:e.id,onClick:function(){i(),e.invoke(a)}}))})()}}catch(e){s=!0,c=e}finally{try{o||null==d.return||d.return()}finally{if(s)throw c}}return t.createElement("div",{className:"tcfArrayWidgetMember--headerMoreMenu"},l)}function pt(e){return e}function vt(e,t){return t?e?"minus":"plus":e?"done":"edit"}function yt(e,t){return t?e?"Collapse":"Expand":e?"Apply":"Edit"}function gt(e){var n=e.disabled,r=e.dragSource,a=void 0===r?pt:r,i=e.field,l=e.hasMenu,o=void 0===l||l,s=e.hasPreview,c=e.isCollapsible,u=e.isExpanded,d=e.model,f=e.onToggleExpanded,m=e.schema,h=[]
return m?(h.push(t.createElement(We,{key:"icon",name:m.icon})),m.previewImage&&h.push(t.createElement(dt,{key:"image",model:d,schema:m})),h.push(t.createElement("div",{className:"tcfArrayWidgetMember--headerLabel",key:"label"},m.label)),s&&m.previewLabelTemplate&&h.push(t.createElement("div",{className:"tcfArrayWidgetMember--headerPreview"},t.createElement(ft,{field:i,key:"preview",model:d})))):h.push(t.createElement(We,{className:"tcfArrayWidgetMember--headerHandleIcon",key:"handle",name:"move"})),t.createElement("div",{className:"tcfArrayWidgetMember--header"},a(t.createElement("div",{className:In("tcfArrayWidgetMember--headerHandle",{enabled:!n&&o})},h)),t.createElement("div",{className:"tcfArrayWidgetMember--headerActions"},c?t.createElement(st,{onClick:f,primary:!n},t.createElement(We,{name:vt(u,n)}),t.createElement(Te,{value:yt(u,n)})):null,!n&&o?t.createElement(Qn,{uuid:d.__uuid}):null))}function bt(e){var n=e.className,r=e.field,a=e.model,l=e.mode,o=e.onClick,s=_slicedToArray(i.useSelector(function(e){return[e.config.references,e.schemas]}),2),c=s[0],u=s[1]
return t.createElement("div",{className:In("tcfInstancePreview",n,{isClickable:!!o}),onClick:o},t.createElement(Kn,{field:r,model:a,mode:l,references:c,schemas:u}))}function Et(e,t){switch(e){case"always":return!0
case"root":return 1===t}}function Ct(e){var n=t.useContext(Tn),r=n.isExpanded,a=n.toggleExpanded,i=t.useRef(null),l=_slicedToArray(et(e,i),3),o=l[0].isDragging,s=l[1],c=l[2];(0,_slicedToArray(rt(e,i),2)[1])(i)
var u=e.child,d=e.depth,f=e.disabled,m=e.field,h=e.isCollapsible,p=e.path,v=e.previewMode,y=e.schema,g=function(){a(u.__uuid)},b=!0,E=!1
if(y){var C=Object.keys(y.fields)
b=C.length>0,E=1===C.length&&"redactor"===y.fields[C[0]].type}var _,w=y&&y.preview&&Et(v,d),k=b&&(!h||r(u.__uuid))
return k?_=t.createElement("div",{className:"tcfArrayWidgetMember--body"},t.createElement(Bn,{canChangeType:!1,disabled:f,isBorderless:E,key:"details",model:u,path:p,schemaNames:m.schemas})):w&&(_=t.createElement(bt,{className:"tcfArrayWidgetMember--preview",field:m,key:"summary",model:u,onClick:b?g:void 0})),t.createElement("div",{className:In("tcfArrayWidgetMember depth-".concat(d),k?"isExpanded":"isCollapsed",{isDragging:o}),ref:i},c(t.createElement("div",{className:"tcfArrayWidgetMember--panel"},t.createElement(gt,{disabled:f,dragSource:s,field:m,hasPreview:!k&&!w,isCollapsible:b&&h,isExpanded:k,model:u,onToggleExpanded:g,schema:y}),t.createElement($n,{uri:k?"details":"summary"},_))))}function _t(e){var n=e.children,r=e.data,a=e.disabled,l=e.field,o=e.model,s=e.onDelete,c=e.onUpdate,u=e.path,d=l.member,f=l.collapsible,m=l.previewMode,h=t.useRef(null),p=i.useSelector(function(e){return e.schemas}),v=t.useContext(zn),y=r.map(function(e,n){var r=[].concat(_toConsumableArray(u),[{index:n,name:d.name,type:"index"}]),i={child:e,depth:v,disabled:a,path:r}
return"instance"===d.type?t.createElement(Ct,Object.assign({},i,{isCollapsible:f,field:d,key:e.__uuid,previewMode:m,schema:p[e.__type]})):t.createElement(at,Object.assign({},i,{field:d,index:n,key:be(e)?e.__uuid:n,model:o,onDelete:s,onUpdate:c}))})
return 0===y.length&&y.push(t.createElement(ot,{field:l,key:"droplet",path:u})),t.createElement(t.Fragment,null,t.createElement("div",{className:"tcfArrayWidgetList",ref:h},y),t.createElement("div",{className:"tcfArrayWidgetList--footer"},n))}function wt(e){if(!e)return e
if(Array.isArray(e))return e.map(function(e){return wt(e)})
if("object"===_typeof(e)){var t={}
for(var n in e)t[n]=wt(e[n])
return t}return e}function kt(e){var n=e.field,r=e.onCreate,a=i.useSelector(function(e){return e.schemas})
return t.createElement("div",{className:"tcfFactory"},t.createElement(Ne,{className:"tcfFactory--primaryButton",onClick:function(){var e=En.createValue({field:n,schemas:a})
r(e)},secondary:!0},t.createElement(We,{name:"plus"}),t.createElement(Te,{value:"Create"})))}function St(e){var n=e.data,r=e.disabled,a=e.field,i=e.onUpdate
return t.createElement(ar,{disabled:r,onChange:i,value:!!n},a.label)}function xt(e){var t=e.red,n=e.green,r=e.blue,a=e.alpha
return{max:Math.max(t,n,r),min:Math.min(t,n,r),red:t/255,green:n/255,blue:r/255,alpha:a}}function Nt(){return{alpha:1,blue:255,green:255,red:255}}function Ot(e){return"object"===_typeof(e)&&"number"==typeof e.alpha&&"number"==typeof e.blue&&"number"==typeof e.green&&"number"==typeof e.red}function It(e){e=e.replace(/^#?([a-f\d])([a-f\d])([a-f\d])$/i,function(e,t,n,r){return t+t+n+n+r+r})
var t=/^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(e)
return t?{red:parseInt(t[1],16),green:parseInt(t[2],16),blue:parseInt(t[3],16),alpha:1}:null}function Rt(e){var t=e.alpha,n=e.hue,r=e.saturation,a=e.value,i=0,l=0,o=0,s=Math.floor(6*n),c=6*n-s,u=a*(1-r),d=a*(1-c*r),f=a*(1-(1-c)*r)
switch(s%6){case 0:i=a,l=f,o=u
break
case 1:i=d,l=a,o=u
break
case 2:i=u,l=a,o=f
break
case 3:i=u,l=d,o=a
break
case 4:i=f,l=u,o=a
break
case 5:i=a,l=u,o=d}return{alpha:t,red:Math.round(255*i),green:Math.round(255*l),blue:Math.round(255*o)}}function At(e){return"rgba(".concat(e.red,",").concat(e.green,",").concat(e.blue,",").concat(e.alpha,")")}function Mt(e){return"#"+(16777216+(e.blue|e.green<<8|e.red<<16)).toString(16).slice(1)}function Pt(e){var t=xt(e),n=t.alpha,r=t.blue,a=t.green,i=t.max,l=t.min,o=t.red,s=0===i?0:(i-l)/i,c=(i-l)/255,u=0,d=i/255
return i===l?{hue:u,saturation:s,value:d,alpha:n}:(u=i===e.red?(a-r)/c+(a<r?6:0):i===e.green?(r-o)/c+2:(o-a)/c+4,u/=6,{hue:u,saturation:s,value:d,alpha:n})}function Tt(e){return function(n){return t.createElement(lr.Consumer,null,function(r){return t.createElement(e,Object.assign({},n,r))})}}function jt(e){var n=e.className,r=K(e,["className"])
return t.createElement("input",Object.assign({className:In("tcfInput",n)},r))}function Lt(e){var n=e.children,r=e.className,a=e.color,i=e.css,l=e.disabled,o=e.onClick,s=e.onRgbColor
if(a){var c=It(a)
c&&(o=function(){s(c)})}return t.createElement("div",{className:In("tcfColorInputSwatch",r),onClick:l?void 0:o},t.createElement("div",{className:"tcfColorInputSwatch--color",style:{background:a||i}}),n)}function Ut(e){var n=e.disableAlpha,r=e.presetColors,a=[t.createElement("div",{className:"tcfColorInputPicker--value wide",key:"hex"},t.createElement(sr,{type:"hex"}),t.createElement("div",{className:"tcfColorInputPicker--valueCaption"},"Hex")),t.createElement("div",{className:"tcfColorInputPicker--value",key:"red"},t.createElement(sr,{type:"red"}),t.createElement("div",{className:"tcfColorInputPicker--valueCaption"},"R")),t.createElement("div",{className:"tcfColorInputPicker--value",key:"green"},t.createElement(sr,{type:"green"}),t.createElement("div",{className:"tcfColorInputPicker--valueCaption"},"G")),t.createElement("div",{className:"tcfColorInputPicker--value",key:"blue"},t.createElement(sr,{type:"blue"}),t.createElement("div",{className:"tcfColorInputPicker--valueCaption"},"B"))]
n||a.push(t.createElement("div",{className:"tcfColorInputPicker--value",key:"alpha"},t.createElement(sr,{type:"alpha"}),t.createElement("div",{className:"tcfColorInputPicker--valueCaption"},"A")))
var i=null
return r&&r.length&&(i=t.createElement("div",{className:"tcfColorInputPicker--presets"},r.map(function(e){return t.createElement(dr,{className:"tcfColorInputPicker--presetsSwatch",color:e})}))),t.createElement("div",{className:"tcfColorInputPicker"},t.createElement(cr,null),t.createElement("div",{className:"tcfColorInputPicker--controls"},t.createElement("div",{className:"tcfColorInputPicker--sliders"},t.createElement(ur,{type:"hue"}),n?null:t.createElement(ur,{type:"alpha"})),t.createElement(dr,{className:"tcfColorInputPicker--swatch"})),t.createElement("div",{className:"tcfColorInputPicker--values"},a),i)}function Ft(e){var n=e.data,r=e.disabled,a=e.field,i=e.onUpdate,l=Ot(n)?n:Nt()
return t.createElement(fr,{color:l,disableAlpha:!a.alpha,disabled:r,onChange:i,presetColors:a.swatches})}function Wt(e,t,n){function r(){var c=Date.now()-a
c<t&&c>=0?l=window.setTimeout(r,t-c):(l=null,n||(i=e.apply(s,o),l||(s=o=null)))}var a,i,l=null,o=null,s=null
return function(){s=this,o=arguments,a=Date.now()
var c=n&&!l
return l||(l=window.setTimeout(r,t)),c&&(i=e.apply(s,o),s=o=null),i}}function Dt(e){var n=e.children,r=e.className,a=e.icon
return t.createElement("div",{className:In("tcfTextAndIcon",r)},t.createElement(We,{className:"tcfTextAndIcon--icon",name:a}),t.createElement(Te,{className:"tcfTextAndIcon--text",value:n}))}function Vt(e){var n=e.children,r=e.title
return t.createElement("div",{className:"tcfErrorMessage"},t.createElement(Dt,{icon:"material:error"},r),n)}function zt(e){return"object"===_typeof(e)&&"string"==typeof e.url}function Bt(e){var n=e.favorites,r=e.onSchema,a=e.onToggleFavorite,i=e.schemas.map(function(e){var i=-1!==n.indexOf(e.qualifier)
return t.createElement("div",{className:"tcfSchemaList--row",key:e.qualifier},t.createElement("div",{className:"tcfSchemaList--schema",onMouseUp:function(){return r(e)}},t.createElement(We,{className:"tcfSchemaList--schemaIcon",name:e.icon}),t.createElement("div",{className:"tcfSchemaList--schemaLabel"},e.label)),a?t.createElement("div",{className:"tcfSchemaList-favorite",onClick:function(){return a(e)}},t.createElement(We,{name:i?"material:star":"material:star_border"})):null)})
return t.createElement("div",{className:"tcfSchemaList"},i)}function Ht(e){var n,r=e.onCreate,a=e.schemas,l=e.scope,o=_slicedToArray(t.useState(!1),2),s=o[0],c=o[1],u=i.useDispatch(),d=[],f=null
if(l){var m=i.useSelector(function(e){return e.user}).favoriteSchemas;(d=l in m?m[l]:[]).length&&(f=a.filter(function(e){return-1!==d.indexOf(e.qualifier)}).map(function(e){return t.createElement(Ne,{className:"tcfFactory--quickButton",key:e.qualifier,onClick:function(){return r(e)},secondary:!0},t.createElement(We,{name:e.icon}),t.createElement("div",null,e.label))})),n=function(e){u(ce(l,e.qualifier))}}var h=function(e){c(!1),r(e)}
return t.createElement("div",{className:"tcfFactory multiple"},t.createElement(Ne,{className:"tcfFactory--primaryButton",onMouseDown:function(){return c(!0)}},t.createElement(We,{name:"plus"}),t.createElement(Te,{value:"Create"}),s?t.createElement(Jn,{onClick:function(){return c(!1)}},t.createElement(Bt,{favorites:d,onSchema:h,onToggleFavorite:n,schemas:a})):null),f)}function qt(e){var n=e.onCreate,r=e.schema
return t.createElement("div",{className:"tcfFactory"},t.createElement(Ne,{className:"tcfFactory--primaryButton",onClick:function(){return n(r)}},t.createElement(We,{name:"plus"}),t.createElement(Te,{params:{schema:r.label},value:"Create {schema}"})))}function $t(e){var n=e.field,r=e.onCreate,a=e.scope,l=i.useSelector(function(e){return e.schemas}),o=n.schemas.map(function(e){return l[e]}).sort(function(e,t){return e.label.localeCompare(t.label)})
if(!o.length)return null
var s=function(e){if(-1!==o.indexOf(e))return r(M({schemas:l,schema:e}))}
return o.length>1?t.createElement(Ht,{onCreate:s,schemas:o,scope:a}):t.createElement(qt,{onCreate:s,schema:o[0]})}function Xt(e){var n=e.children,r=e.disabled,a=e.field,l=e.model,o=t.useContext(zn),s=i.useSelector(function(e){return e.schemas}),c=t.useContext(Tn),u=c.isExpanded,d=c.toggleExpanded,f=s[l.__type],m=u(l.__uuid),h=f&&f.preview,p=function(){return d(l.__uuid)},v=null
return m?v=t.createElement("div",{className:"tcfArrayWidgetMember--body"},n):h&&(v=t.createElement(bt,{field:a,model:l})),t.createElement("div",{className:"tcfInstanceWidget--collapsiblePanel depth-".concat(o)},t.createElement(gt,{disabled:r,field:a,hasMenu:!1,hasPreview:!m&&!h,isCollapsible:!0,isExpanded:m,model:l,onToggleExpanded:p,schema:f}),t.createElement($n,{uri:m?"details":"summary"},v))}function Gt(e){var n=e.className,r=e.data,a=e.disabled,i=e.field,l=e.path,o=t.createElement(Bn,{disabled:a,model:r,path:[].concat(_toConsumableArray(l),[{type:"property",name:i.name}]),schemaNames:i.schemas})
return i.collapsible&&d(r)?t.createElement(Xt,{model:r,disabled:a,field:i},o):t.createElement("div",{className:In("tcfInstanceWidget",n)},o)}function Yt(e){var n=e.data,r=e.disabled,a=e.onUpdate
return t.createElement(Wn,{disabled:r,onChange:a,value:!!n})}function Jt(e){var t=e.data,n=e.elementType,r=e.references,a=[]
if(Array.isArray(t)){var i=!0,l=!1,o=void 0
try{for(var s,c=t[Symbol.iterator]();!(i=(s=c.next()).done);i=!0)!function(){var e=s.value,t=r.find(function(t){return t.id===e&&t.type===n})
t&&a.push(t)}()}catch(e){l=!0,o=e}finally{try{i||null==c.return||c.return()}finally{if(l)throw o}}}return a}function Qt(e){var n=t.useRef(null)
return t.useEffect(function(){var t=n.current
if(t){var r=ct(),a=!0,i=!1,l=void 0
try{for(var o,s=Jt(e)[Symbol.iterator]();!(a=(o=s.next()).done);a=!0){var c=o.value.$element.clone(!1,!0)
c.appendTo(t),Craft.setElementSize(c,e.viewMode),r.load(c)}}catch(e){i=!0,l=e}finally{try{a||null==s.return||s.return()}finally{if(i)throw l}}}},[]),t.createElement("div",{className:"elementselect"},t.createElement("div",{className:"elements",ref:n}))}function Kt(e){return e.disabled?t.createElement(Qt,Object.assign({},e)):t.createElement(Er,Object.assign({},e))}function Zt(e){var n=e.disabled,r=e.link,a=e.linkType,i=e.onUpdate
return t.createElement(Cr,{criteria:a.criteria,data:[r.elementId],disabled:n,elementType:a.elementType,limit:1,onUpdate:function(e){return i(Object.assign({},r,{elementId:e.length?e[0]:0}))},sources:a.sources,viewMode:"small"})}function en(e){var n=e.disabled,r=e.link,a=e.linkType,i=e.onUpdate
return t.createElement(jt,{disabled:n,type:a.inputType,value:r.url,onChange:function(e){return i(Object.assign({},r,{url:e.currentTarget.value}))}})}function tn(e){return"object"===_typeof(e)&&"number"==typeof e.elementId&&"string"==typeof e.type&&"string"==typeof e.url}function nn(e){var n,r=e.data,a=e.disabled,i=e.field,l=e.onUpdate
n=tn(r)?r:{elementId:0,openInNewWindow:!1,type:"",url:""}
var o,s=i.linkTypes[n.type]
s&&"input"===s.type?o=t.createElement(en,{disabled:a,key:n.type,link:n,linkType:s,onUpdate:l}):s&&"element"===s.type&&(o=t.createElement(Zt,{disabled:a,key:n.type,link:n,linkType:s,onUpdate:l}))
var c=i.allowNewWindow
return t.createElement("div",{className:"tcfLinkWidget"},t.createElement("div",{className:"tcfLinkWidget--type"},t.createElement(Be,{disabled:a,options:Object.keys(i.linkTypes).map(function(e){return{key:e,label:i.linkTypes[e].label}}),value:n.type,onChange:function(e){return l(Object.assign({},n,{type:e}))}})),t.createElement("div",{className:"tcfLinkWidget--editor"},o),c?t.createElement(ar,{disabled:a,onChange:function(e){return l(Object.assign({},n,{openInNewWindow:e}))},value:n.openInNewWindow},t.createElement(Te,{value:"Open in new window"})):null)}function rn(e){var n=e.results,r=e.onSelect
return t.createElement("div",{className:""},n.map(function(e){return t.createElement("div",{onClick:function(){return r(e)}},e.formatted_address)}))}function an(e){return"object"===_typeof(e)&&"number"==typeof e.latitude&&"number"==typeof e.longitude}function ln(e,t){var n=e.dataType,r=e.defaultValue,a=e.max,i=e.min,l=e.optional,o="integer"===n?parseInt(t):parseFloat(t)
if(isFinite(o))"number"==typeof a&&o>a&&(o=a),"number"==typeof i&&o<i&&(o=i)
else{if(l)return null
o=r}return o}function on(e){function n(){f(!1),p(i)}function r(e){var t=e.target.value
p(t),c(ln(s,t))}function a(){f(!0)}var i=e.data,l=e.disabled,o=e.errors,s=e.field,c=e.onUpdate,u=_slicedToArray(t.useState(!1),2),d=u[0],f=u[1],m=_slicedToArray(t.useState(i),2),h=m[0],p=m[1],v=s.max,y=s.min,g=s.placeholder,b=s.unit,E=d?h:i,C=t.createElement("input",{autoComplete:"off",className:In("tcfNumberWidget--input text fullwidth",{error:o&&o.length}),disabled:l,max:v,min:y,onBlur:n,onChange:r,onFocus:a,placeholder:g,type:"number",value:E})
return b?t.createElement("div",{className:"tcfNumberWidget"},C,t.createElement("div",{className:"tcfNumberWidget--unit"},b)):C}function sn(e){var n=e.value
return t.createElement("div",{className:"redactor-box redactor-styles-on redactor-toolbar-on focusable-input redactor-focus focus"},t.createElement("div",{className:"redactor-styles redactor-in redactor-in-0",dangerouslySetInnerHTML:{__html:n}}))}function cn(e){return e.disabled?t.createElement(sn,Object.assign({},e)):t.createElement(Ar,Object.assign({},e))}function un(e){var n=e.data,r=e.disabled,a=e.elementSiteId,i=e.field,l=e.onUpdate
return i.redactor?t.createElement(cn,{disabled:r,elementSiteId:a,onUpdate:l,options:i.redactor,value:n}):null}function dn(e,t){return Z(this,void 0,void 0,regeneratorRuntime.mark(function n(){var r,a,i,l
return regeneratorRuntime.wrap(function(n){for(;;)switch(n.prev=n.next){case 0:if(!(Pr>2)){n.next=3
break}return console.warn('Translator has returned to many errors, skipping translation for text "'.concat(e,'".')),n.abrupt("return",e)
case 3:return r=t.endpoint,a=K(t,["endpoint"]),i=Object.assign({},a,{text:e}),l=Object.keys(i).map(function(e){return"".concat(e,"=").concat(encodeURIComponent(i[e]))}).join("&"),n.abrupt("return",new Promise(function(t){fetch("".concat(r,"&").concat(l)).then(function(e){return e.json()}).then(function(n){t(n&&n.data?n.data:e)}).catch(function(n){console.error("Translator returned an error: ".concat(n)),Pr+=1,t(e)})}))
case 7:case"end":return n.stop()}},n)}))}function fn(e){var t=e.context.references,n=e.field,r=e.value,a=[]
if(!n)return a
var i=n.elementType,l=!0,o=!1,s=void 0
try{for(var c,u=r[Symbol.iterator]();!(l=(c=u.next()).done);l=!0)!function(){var e=c.value,n=t.find(function(t){return t.id===e&&t.type===i})
n&&a.push(new Lr(n))}()}catch(e){o=!0,s=e}finally{try{l||null==u.return||u.return()}finally{if(o)throw s}}return a}function mn(e){var n=e.data,r=e.disabled,a=e.field,i=e.model,l=e.onUpdate
return t.createElement(Cr,{criteria:a.criteria,disabled:r,data:n,elementType:a.elementType,limit:a.limit,modalStorageKey:"tcf_".concat(i.__type,"_").concat(a.name),onUpdate:l,sources:a.sources,viewMode:a.viewMode})}function hn(e){var n=e.data,r=e.disabled,a=e.onUpdate,i=e.field
return t.createElement(Be,{disabled:r,onChange:a,options:i.options,value:n})}function pn(e){var t
return e&&(t="color"in e?e.color:e.label),"string"==typeof t?t:"transparent"}function vn(e){var n=e.data,r=e.disabled,a=e.errors,i=e.field,l=i.maxLength,o=i.minLength,s=i.placeholder,c=i.inputType,u=e.onUpdate
return t.createElement("input",{autoComplete:"off",className:In("tcfTextWidget text fullwidth",{error:a&&a.length}),disabled:r,maxLength:l,minLength:o,onChange:function(e){return u(e.target.value)},placeholder:s,type:c,value:n?"".concat(n):""})}function yn(e){var n=e.data,r=e.disabled,a=e.field,i=a.maxLength,l=a.minLength,o=a.monospace,s=a.placeholder,c=a.rows,u=e.onUpdate
return t.createElement("textarea",{className:In("tcfTextareaWidget text fullwidth",{monospace:o}),disabled:r,maxLength:i,minLength:l,onChange:function(e){return u(e.target.value)},placeholder:s,rows:c,value:n})}r=r&&r.hasOwnProperty("default")?r.default:r,l=l&&l.hasOwnProperty("default")?l.default:l
var gn="default"in o?o.default:o
s=s&&s.hasOwnProperty("default")?s.default:s
var bn,En=new(function(){function e(){_classCallCheck(this,e)}return _createClass(e,[{key:"initialize",value:function(e){this.definitions=e}},{key:"createValue",value:function(e){return this.getDefinition(e.field).createValue(e)}},{key:"getDefinition",value:function(e){return this.definitions["object"===_typeof(e)?e.type:e]}}]),e}()),Cn="tcfUserState",_n={addReferences:I,changeType:P,moveModel:W,setOverlay:V,setUser:B,uuidOrder:q,uuidRemove:x,updateSync:J,updateValue:G},wn=[ue,O,E,fe,de,b,C,me]
!function(e){e[e.Manipulation=0]="Manipulation",e[e.Movement=1]="Movement",e[e.Clipboard=2]="Clipboard"}(bn||(bn={}))
var kn
!function(e){e[e.Idle=0]="Idle",e[e.Loading=1]="Loading",e[e.Loaded=2]="Loaded"}(kn||(kn={}))
var Sn,xn,Nn=null,On=kn.Idle,In=function(e,t){return t={exports:{}},e(t,t.exports),t.exports}(function(e){!function(){function t(){for(var e=[],r=0;r<arguments.length;r++){var a=arguments[r]
if(a){var i=_typeof(a)
if("string"===i||"number"===i)e.push(a)
else if(Array.isArray(a)&&a.length){var l=t.apply(null,a)
l&&e.push(l)}else if("object"===i)for(var o in a)n.call(a,o)&&a[o]&&e.push(o)}}return e.join(" ")}var n={}.hasOwnProperty
e.exports?(t.default=t,e.exports=t):window.classNames=t}()}),Rn="toolbar"
!function(e){e[e.Small=0]="Small",e[e.Medium=1]="Medium",e[e.Large=2]="Large"}(xn||(xn={}))
var An=t.createContext(xn.Large),Mn=i.connect(function(e,t){return{schema:e.schemas[t.model.__type]}},function(e,t){return{onUpdate:function(n,r){e(Y(t.path,n,r))}}})(Le)
!function(e){function n(e){var n=e.children
return t.createElement("div",{className:"tcfWindow--content"},n)}function r(e){var n=e.children
return t.createElement("div",{className:"tcfWindow--footer"},n)}e.Content=n,e.Footer=r}(Ue||(Ue={}))
var Pn=Ue,Tn=t.createContext({expanded:[],isExpanded:function(){return!1},toggleExpanded:function(){}}),jn=function(e){function n(e){var t
return _classCallCheck(this,n),t=_possibleConstructorReturn(this,_getPrototypeOf(n).call(this,e)),t.originalModel=null,t.handleCancel=function(){t.close()},t.handleApply=function(){t.close()},t.originalModel=e.model,t}return _inherits(n,e),_createClass(n,[{key:"close",value:function(){this.props.setOverlay(null)}},{key:"render",value:function(){var e=this.props,n=e.model,r=e.path
return t.createElement(Fe,null,t.createElement(Pn,null,t.createElement(Pn.Content,null,t.createElement(Mn,{model:n,path:r})),t.createElement(Pn.Footer,null,t.createElement(Oe,{onClick:this.handleApply},t.createElement(Te,{value:"Apply"})))))}}]),n}(t.Component),Ln=i.connect(function(e,t){return m(e,t.uuid)},function(e){return{setOverlay:function(t){return e(z(t))}}})(jn),Un="craft:",Fn="material:",Wn=function(e){function n(){var e
return _classCallCheck(this,n),e=_possibleConstructorReturn(this,_getPrototypeOf(n).apply(this,arguments)),e.element=null,e.lightswitch=null,e.handleChange=function(){var t=e.props,n=t.disabled,r=t.onChange,a=_assertThisInitialized(e).lightswitch
!n&&a&&r(a.on)},e.setElement=function(t){e.element!==t&&(e.element=t,e.updateInstance())},e}return _inherits(n,e),_createClass(n,[{key:"componentDidUpdate",value:function(e){var t=this.props.value,n=this.lightswitch
e.disabled!==this.props.disabled?this.updateInstance():n&&n.on!==t&&n.toggle()}},{key:"render",value:function(){var e=this.props,n=e.className,r=e.disabled,a=e.small,i=e.value
return t.createElement("div",null,t.createElement("div",{className:In("lightswitch",n,{disabled:r,on:i,small:a}),ref:this.setElement,tabIndex:0},t.createElement("div",{className:"lightswitch-container"},t.createElement("div",{className:"label on"}),t.createElement("div",{className:"handle"}),t.createElement("div",{className:"label off"}))))}},{key:"updateInstance",value:function(){var e=this.element,t=this.handleChange,n=this.lightswitch,r=this.props,a=r.disabled,i=r.value
n&&(n.destroy(),this.lightswitch=null),!a&&e&&(this.lightswitch=new Craft.LightSwitch(e,{onChange:t,value:i}))}}]),n}(t.Component),Dn=function(e){function n(e){var t
return _classCallCheck(this,n),t=_possibleConstructorReturn(this,_getPrototypeOf(n).call(this,e)),t.handleApply=function(){var e=t.props,n=e.currentSite,r=e.endpoint,a=t.state,i=a.site,l=a.useTranslator
if(i){var o
l&&n&&i.language!==n.language&&(o={endpoint:r,source:i.language,target:n.language}),t.props.onSynchronize({siteId:i.id,translate:o})}},t.handleSiteChange=function(e){t.setState({site:e})},t.handleToggleTranslator=function(e){t.setState({useTranslator:e})},t.state={site:e.availableSites[0]||null,useTranslator:!1},t}return _inherits(n,e),_createClass(n,[{key:"render",value:function(){var e=this.props,n=e.availableSites,r=e.currentSite,a=e.hasTranslator,i=e.onClose,l=this.state,o=l.site,s=l.useTranslator,c=n.map(function(e){return{label:e.label,key:e}})
return t.createElement(t.Fragment,null,t.createElement(Pn.Content,null,t.createElement("div",{className:"tcfSynchronize--title"},t.createElement(Te,{value:"Synchronize translations"})),t.createElement(Re,null,t.createElement(Ae,{instructions:g("Select the site the content should be copied from."),label:g("Site")},t.createElement(Be,{onChange:this.handleSiteChange,options:c,value:o})),o&&r&&o.language!==r.language?t.createElement(Ae,{instructions:g(a?"Uses a webservice to automatically translate texts.":"A matching webservice must be configured in the options of this field in order to use this feature."),label:g("Translate texts automatically")},t.createElement(Wn,{disabled:!a,onChange:this.handleToggleTranslator,value:s})):null)),t.createElement(Pn.Footer,null,t.createElement(Oe,{onClick:i,secondary:!0},t.createElement(Te,{value:"Cancel"})),t.createElement("div",{className:"spacer"}),t.createElement(Oe,{onClick:this.handleApply,primary:!0},t.createElement(Te,{value:"Apply"}))))}}]),n}(t.Component),Vn=i.connect(function(e){var t=e.config,n=t.apiEndpoints,r=t.elementSiteId,a=t.hasTranslator,i=t.supportedSites
return{availableSites:i.filter(function(e){return e.id!==r}),currentSite:i.find(function(e){return e.id===r}),endpoint:n.translate,hasTranslator:a}},function(e){return{onSynchronize:function(t){return e(se(t))}}})(Dn),zn=t.createContext(0),Bn=t.memo(function(e){var n,r=e.canChangeType,a=void 0===r||r,l=e.disabled,o=void 0!==l&&l,s=e.isBorderless,c=e.model,u=e.path,f=e.schemaNames,m=i.useDispatch(),h=i.useSelector(function(e){return f.map(function(t){return e.schemas[t]})}),p=!1
if(d(c)&&(p=h.some(function(e){return e.qualifier===c.__type})),a&&h.length>1){var v=function(e){return m(T(u,e))},y=h.map(function(e){return{key:e.qualifier,label:e.label}})
y.sort(ze),n=t.createElement(Ae,{className:"tcfInstance--typeSelect",label:"Type"},t.createElement(Be,{disabled:o,onChange:v,options:y,value:p?c.__type:null}))}return t.createElement(Ge,null,t.createElement(Me,null,n,p?t.createElement(Mn,{disabled:o,model:c,isBorderless:s,path:u}):null))}),Hn=function(e){function t(e){var n
_classCallCheck(this,t),(n=_possibleConstructorReturn(this,_getPrototypeOf(t).call(this,e))).element=null,n.handleMouseDown=function(e){var t=n.props.onClick
e.target===n.element&&t&&t()}
var r=document.createElement("div")
return r.className="tcfOverlay",r.addEventListener("mousedown",n.handleMouseDown),document.body.appendChild(r),n.element=r,n}return _inherits(t,e),_createClass(t,[{key:"componentWillUnmount",value:function(){var e=this.element
e&&(document.body.removeChild(e),e.removeEventListener("mousedown",this.handleMouseDown),this.element=null)}},{key:"render",value:function(){var e=this.props.children,t=this.element
return t?n.createPortal(e,t):null}}]),t}(t.Component),qn=function(e){function t(e){var n
return _classCallCheck(this,t),_possibleConstructorReturn(this,(n=_getPrototypeOf(t)).call.apply(n,[this].concat(_toConsumableArray(Ze(e)))))}return _inherits(t,e),_createClass(t,[{key:"toHTML",value:function(){return new o.SafeString(this.toString())}},{key:"toList",value:function(e){return new o.SafeString('<ul class="'.concat(e,'">').concat(this.map(function(e){return"<li>".concat(Ke(e),"</li>")}).join(""),"</ul>"))}},{key:"toString",value:function(){return this.map(function(e){return Ke(e)}).join("")}},{key:"asColumn",get:function(){return this.toList("flexColumn")}},{key:"asList",get:function(){return this.toList("")}},{key:"asRow",get:function(){return this.toList("flexRow")}}]),t}(_wrapNativeSuper(Array)),$n=function(e){function n(e){var t
return _classCallCheck(this,n),t=_possibleConstructorReturn(this,_getPrototypeOf(n).call(this,e)),t.element=null,t.handleAnimationEnd=function(){var e=_assertThisInitialized(t).element
e&&(e.style.height="",e.style.transition=""),t.setState({inTransition:!1,lastChildren:null,lastUri:null})},t.setElement=function(e){t.element=e},t.state={currentChildren:e.children,currentUri:e.uri,inTransition:!1,lastChildren:null,lastUri:null},t}return _inherits(n,e),_createClass(n,[{key:"componentDidUpdate",value:function(e,t,n){var r=this.element
r&&n&&setTimeout(function(){r.style.height=""
var e=r.offsetHeight
r.style.height="".concat(n.height,"px"),r.getBoundingClientRect(),r.style.transition="height 200ms",r.style.height="".concat(e,"px")},0)}},{key:"getSnapshotBeforeUpdate",value:function(e,t){var n=this.element
if(t.currentUri!==this.state.currentUri&&n){var r=n.offsetHeight
return n.style.height="".concat(r,"px"),{height:r}}return null}},{key:"render",value:function(){var e=this.props,n=e.className,r=e.itemClassName,a=this.state,i=a.currentChildren,l=a.currentUri,o=a.inTransition,s=a.lastChildren,c=a.lastUri,u=[]
return o&&c&&u.push(t.createElement("div",{className:In(r,"tcfDetailsPanel--item","from"),key:c},s)),u.push(t.createElement("div",{className:In(r,"tcfDetailsPanel--item",{to:o}),key:l,onAnimationEnd:this.handleAnimationEnd},i)),t.createElement("div",{className:In(n,"tcfDetailsPanel"),ref:this.setElement},u)}}],[{key:"getDerivedStateFromProps",value:function(e,t){return e.uri===t.currentUri?Object.assign({},t,{currentChildren:e.children}):e.uri===t.currentUri||t.inTransition?null:{inTransition:!0,lastChildren:t.currentChildren,lastUri:t.currentUri,currentChildren:e.children,currentUri:e.uri}}}]),n}(t.Component),Xn=null,Gn=t.memo(function(e){var n=e.field,r=e.model,a=e.references,i=e.schemas,l=K(e,["field","model","references","schemas"]),o=Ke(En.getDefinition("instance").preview({context:{depth:0,references:a,schemas:i},field:n,mode:"label",value:r})).replace(/<[^>]*>?/gm,"").replace(/[\n\t\r]+/g,"").trim().substr(0,256)
return t.createElement("div",Object.assign({},l),o)},function(e,t){return e.model===t.model}),Yn=i.connect(function(e,t){return{commands:he(e,t.uuid)}},function(e){return{dispatch:e}})(ht),Jn=function(e){function n(){var e
return _classCallCheck(this,n),e=_possibleConstructorReturn(this,_getPrototypeOf(n).apply(this,arguments)),e.handle=null,e.handleStyle={left:"0px"},e.origin=null,e.panel=null,e.panelClassName="tcfFlyout--panel",e.panelStyle={left:"0px",top:"0px"},e.handleResize=function(){e.update()},e.setHandle=function(t){e.handle=t,e.update()},e.setOrigin=function(t){e.origin=t,e.update()},e.setPanel=function(t){e.panel=t,e.update()},e}return _inherits(n,e),_createClass(n,[{key:"componentDidMount",value:function(){window.addEventListener("resize",this.handleResize)}},{key:"componentWillUnmount",value:function(){window.removeEventListener("resize",this.handleResize)}},{key:"render",value:function(){var e=this.props,n=e.children,r=e.onClick
return t.createElement("div",{className:"tcfFlyout",ref:this.setOrigin},t.createElement(Hn,{onClick:r},t.createElement("div",{className:this.panelClassName,ref:this.setPanel,style:Object.assign({},this.panelStyle)},t.createElement("div",{className:"tcfFlyout--handle",ref:this.setHandle,style:Object.assign({},this.handleStyle)}),t.createElement("div",{className:"tcfFlyout--body"},n))))}},{key:"update",value:function(){var e=this.handle,t=this.handleStyle,n=this.origin,r=this.panel,a=this.panelStyle
if(n&&r&&e){var i=n.getBoundingClientRect(),l=r.getBoundingClientRect(),o="tcfFlyout--panel",s=Math.max(10,Math.min(window.innerWidth-l.width-10,i.left+.5*(i.width-l.width))),c=Math.max(10,Math.min(l.width-10,i.left+.5*i.width-s))
t.left="".concat(c,"px"),a.left="".concat(s,"px"),i.top+.5*i.height>.5*window.innerHeight?(o+=" above",a.top="".concat(i.top-l.height-5,"px")):(o+=" below",a.top="".concat(i.top+i.height+5,"px")),e.style.left=t.left,r.className=this.panelClassName=o,r.style.left=a.left,r.style.top=a.top}}}]),n}(t.Component),Qn=function(e){function n(){var e
return _classCallCheck(this,n),e=_possibleConstructorReturn(this,_getPrototypeOf(n).apply(this,arguments)),e.state={isExpanded:!1},e.handleClose=function(){e.setState({isExpanded:!1})},e.handleMouseDown=function(){e.setState({isExpanded:!0})},e}return _inherits(n,e),_createClass(n,[{key:"render",value:function(){var e=this.props.uuid,n=this.state.isExpanded
return t.createElement("div",{className:"tcfArrayWidgetMember--headerMore"},t.createElement("div",{className:"tcfArrayWidgetMember--headerMoreButton",onMouseDown:this.handleMouseDown},t.createElement(We,{name:"material:more_vert"})),n?t.createElement(Jn,{onClick:this.handleClose},t.createElement(Yn,{onClose:this.handleClose,uuid:e})):null)}}]),n}(t.Component),Kn=t.memo(function(e){var n=e.field,r=e.model,a=e.mode,i=void 0===a?"default":a,l=e.references,o=e.schemas,s=En.getDefinition("instance").preview({context:{depth:0,references:l,schemas:o},field:n,mode:i,value:r})
try{var c={__html:Ke(s)}
return t.createElement("div",{className:In("tcfInstancePreview--content",i),dangerouslySetInnerHTML:c})}catch(e){return t.createElement(t.Fragment,null,t.createElement("p",null,t.createElement("span",{className:"tcfIcon material"},"error"),t.createElement("span",null,"Could not render preview.")),e&&"object"===_typeof(e)&&"message"in e?t.createElement("pre",null,e.message):null)}},function(e,t){return e.model===t.model}),Zn=function(e){function n(){var e
return _classCallCheck(this,n),e=_possibleConstructorReturn(this,_getPrototypeOf(n).apply(this,arguments)),e.handleAdd=function(t){var n=_assertThisInitialized(e).context,r=e.props,a=r.data,i=r.disabled,l=r.onUpdate
if(!i){var o=Array.isArray(a)?a.slice():[]
o.push(Ce(t)),l(o),d(t)&&n&&n.toggleExpanded(t.__uuid,!0)}},e.handleDelete=function(t){var n=e.props,r=n.data,a=n.disabled,i=n.onUpdate
if(!a&&Array.isArray(r)){var l=r.slice()
l.splice(t,1),i(l)}},e.handleUpdate=function(t,n){var r=e.props,a=r.data,i=r.disabled,l=r.onUpdate
if(!i&&Array.isArray(a)){var o=a.slice()
o[t]=Ce(n,o[t]),l(o)}},e}return _inherits(n,e),_createClass(n,[{key:"render",value:function(){var e=this.props,n=e.data,r=e.disabled,a=e.field,i=e.model,l=e.path,o=a.limit
if(!a.member)return null
var s,c=Array.isArray(n)?n:[],u=o>0&&c.length>=o,d=En.getDefinition(a.member)
return r||!d||u||(s=t.createElement(d.factory,{field:a.member,onCreate:this.handleAdd,scope:i.__type})),t.createElement(_t,{data:c,disabled:r,field:a,limit:o,model:i,onDelete:this.handleDelete,onUpdate:this.handleUpdate,path:l},s)}}]),n}(t.Component)
Zn.contextType=Tn
var er,tr=function(){function e(t){var n=t.factory,r=t.widget
_classCallCheck(this,e),this.factory=n||kt,this.widget=r}return _createClass(e,[{key:"cloneValue",value:function(e){return Z(this,void 0,void 0,regeneratorRuntime.mark(function t(){var n,r
return regeneratorRuntime.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:if(n=e.field,r=e.value,!this.isValue(n,r)){t.next=5
break}return t.abrupt("return",wt(r))
case 5:return t.abrupt("return",this.createValue(e))
case 6:case"end":return t.stop()}},t,this)}))}}]),e}(),nr=function(e){function t(){return _classCallCheck(this,t),_possibleConstructorReturn(this,_getPrototypeOf(t).call(this,{widget:Zn}))}return _inherits(t,e),_createClass(t,[{key:"cloneValue",value:function(e){return Z(this,void 0,void 0,regeneratorRuntime.mark(function t(){var n,r,a,i,l,o,s,c,u,d,f
return regeneratorRuntime.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:if(n=e.field,r=e.value,a=K(e,["field","value"]),!this.isValue(n,r)){t.next=36
break}i=En.getDefinition(n.member.type),l=[],o=!0,s=!1,c=void 0,t.prev=7,u=r[Symbol.iterator]()
case 9:if(o=(d=u.next()).done){t.next=19
break}return f=d.value,t.t0=l,t.next=14,i.cloneValue(Object.assign({},a,{field:n.member,value:f}))
case 14:t.t1=t.sent,t.t0.push.call(t.t0,t.t1)
case 16:o=!0,t.next=9
break
case 19:t.next=25
break
case 21:t.prev=21,t.t2=t.catch(7),s=!0,c=t.t2
case 25:t.prev=25,t.prev=26,o||null==u.return||u.return()
case 28:if(t.prev=28,!s){t.next=31
break}throw c
case 31:return t.finish(28)
case 32:return t.finish(25)
case 33:return t.abrupt("return",l)
case 36:return t.abrupt("return",this.createValue(e))
case 37:case"end":return t.stop()}},t,this,[[7,21,25,33],[26,,28,32]])}))}},{key:"createValue",value:function(e){return[]}},{key:"isValue",value:function(e,t){return Array.isArray(t)}},{key:"preview",value:function(e){return new qn(e)}}]),t}(tr),rr=function(e){function t(){return _classCallCheck(this,t),_possibleConstructorReturn(this,_getPrototypeOf(t).apply(this,arguments))}return _inherits(t,e),_createClass(t,[{key:"createValue",value:function(e){return!!e.field.defaultValue}},{key:"isValue",value:function(e,t){return"boolean"==typeof t||t instanceof Boolean}},{key:"preview",value:function(e){return e.value}}]),t}(tr),ar=function(e){function n(){var e
return _classCallCheck(this,n),e=_possibleConstructorReturn(this,_getPrototypeOf(n).apply(this,arguments)),e.id=A(),e}return _inherits(n,e),_createClass(n,[{key:"render",value:function(){var e=this.id,n=this.props,r=n.className,a=n.children,i=n.disabled,l=n.onChange,o=n.value
return t.createElement("dl",{className:In("tcfCheckbox",r)},t.createElement("dd",{className:"tcfCheckbox--input"},t.createElement("input",{checked:o,disabled:i,id:e,onChange:i?void 0:function(){return l(!o)},type:"checkbox"})),t.createElement("dt",{className:"tcfCheckbox--label"},t.createElement("label",{htmlFor:e},a)))}}]),n}(t.Component),ir=function(e){function t(){var e
return _classCallCheck(this,t),e=_possibleConstructorReturn(this,_getPrototypeOf(t).call(this,{widget:St})),e.isAlwaysPlainField=!0,e}return _inherits(t,e),t}(rr),lr=t.createContext({css:"#000",hsv:{hue:0,saturation:0,value:0,alpha:0},rgb:{red:0,green:0,blue:0,alpha:0},onHsvColor:function(e){},onRgbColor:function(e){}}),or=function(e){function n(e){var t
return _classCallCheck(this,n),t=_possibleConstructorReturn(this,_getPrototypeOf(n).call(this,e)),t.timeout=null,t.commit=function(){null!==t.timeout&&window.clearTimeout(t.timeout),t.timeout=window.setTimeout(t.handleTimeout,250)},t.handleHsvColor=function(e){var n=Rt(e)
t.setState({css:At(n),rgb:n,hsv:e}),t.commit()},t.handleRgbColor=function(e){t.setState({css:At(e),rgb:e,hsv:Pt(e)}),t.commit()},t.handleTimeout=function(){t.timeout=null,t.props.onChange(t.state.rgb)},t.state={css:At(e.color),hsv:Pt(e.color),rgb:Object.assign({},e.color)},t}return _inherits(n,e),_createClass(n,[{key:"render",value:function(){var e=this.props.children
return t.createElement(lr.Provider,{value:Object.assign({},this.state,{onHsvColor:this.handleHsvColor,onRgbColor:this.handleRgbColor})},e)}}]),n}(t.Component),sr=Tt(function(e){function n(){var e
return _classCallCheck(this,n),e=_possibleConstructorReturn(this,_getPrototypeOf(n).apply(this,arguments)),e.state={hasFocus:!1},e.handleBlur=function(){e.setState({hasFocus:!1})},e.handleChange=function(t){var n=t.target.value;(0,e.props.onRgbColor)(e.getColor(n))},e.handleFocus=function(){e.setState({hasFocus:!0})},e}return _inherits(n,e),_createClass(n,[{key:"getValue",value:function(){var e=this.props,t=e.rgb,n=e.type
switch(n){case"alpha":case"blue":case"green":case"red":return"".concat(t[n])
case"hex":return Mt(t)}}},{key:"getColor",value:function(e){var t=this.props,n=t.rgb,r=t.type
switch(r){case"blue":case"green":case"red":var a=parseInt(e)
return Object.assign({},n,_defineProperty({},r,isFinite(a)?Math.max(0,Math.min(255,a)):n[r]))
case"alpha":var i=parseFloat(e)
return Object.assign({},n,{alpha:isFinite(i)?Math.max(0,Math.min(1,i)):n.alpha})
case"hex":var l=It(e)
return l?Object.assign({},l,{alpha:n.alpha}):n}}},{key:"render",value:function(){var e=this.state.hasFocus,n={className:"tcfColorInputInput",onBlur:this.handleBlur,onChange:this.handleChange,onFocus:this.handleFocus}
return e?n.defaultValue=this.getValue():n.value=this.getValue(),t.createElement(jt,n)}}]),n}(t.Component)),cr=Tt(function(e){function n(){var e
return _classCallCheck(this,n),e=_possibleConstructorReturn(this,_getPrototypeOf(n).apply(this,arguments)),e.element=null,e.state={initialHue:0,isMouseDown:!1,mouseX:0,mouseY:0},e.handleMouseDown=function(t){var n=e.props.hsv
window.addEventListener("mousemove",e.handleMouseMove),window.addEventListener("mouseup",e.handleMouseUp),e.setState(Object.assign({},e.update(t.clientX,t.clientY,n.hue),{initialHue:n.hue,isMouseDown:!0}))},e.handleMouseMove=function(t){e.setState(e.update(t.clientX,t.clientY))},e.handleMouseUp=function(t){e.stopListening(),e.setState(Object.assign({},e.update(t.clientX,t.clientY),{isMouseDown:!1}))},e.setElement=function(t){e.element=t},e}return _inherits(n,e),_createClass(n,[{key:"componentWillUnmount",value:function(){this.stopListening()}},{key:"render",value:function(){var e=this.props.hsv,n=this.state,r=n.initialHue,a=n.isMouseDown,i=n.mouseX,l=n.mouseY
return t.createElement("div",{className:"tcfColorInputSaturation",onMouseDown:this.handleMouseDown,ref:this.setElement,style:{background:"hsl(".concat(360*(a?r:e.hue),", 100%, 50%)")}},t.createElement("div",{className:"tcfColorInputSaturation--value",style:{left:"".concat(100*(a?i:e.saturation),"%"),top:"".concat(100*(a?l:1-e.value),"%")}}))}},{key:"stopListening",value:function(){window.removeEventListener("mousemove",this.handleMouseMove),window.removeEventListener("mouseup",this.handleMouseUp)}},{key:"update",value:function(e,t){var n=arguments.length>2&&void 0!==arguments[2]?arguments[2]:this.state.initialHue,r=this.element
if(!r)return{mouseX:this.state.mouseX,mouseY:this.state.mouseY}
var a=this.props,i=a.hsv,l=a.onHsvColor,o=r.getBoundingClientRect(),s=Math.max(0,Math.min(1,(e-o.left)/o.width)),c=Math.max(0,Math.min(1,(t-o.top)/o.height))
return l({alpha:i.alpha,hue:n,saturation:s,value:1-c}),{mouseX:s,mouseY:c}}}]),n}(t.Component)),ur=Tt(function(e){function n(){var e
return _classCallCheck(this,n),e=_possibleConstructorReturn(this,_getPrototypeOf(n).apply(this,arguments)),e.element=null,e.handleMouseDown=function(t){window.addEventListener("mousemove",e.handleMouseMove),window.addEventListener("mouseup",e.handleMouseUp),e.update(t.clientX)},e.handleMouseMove=function(t){e.update(t.clientX)},e.handleMouseUp=function(t){e.stopListening(),e.update(t.clientX)},e.setElement=function(t){e.element=t},e}return _inherits(n,e),_createClass(n,[{key:"componentWillUnmount",value:function(){this.stopListening()}},{key:"render",value:function(){var e,n=this.props,r=n.rgb,a=n.hsv,i=n.type,l=a[i]
if("alpha"===i){var o=r.red,s=r.green,c=r.blue,u="rgba(".concat(o,", ").concat(s,", ").concat(c,", 0)"),d="rgba(".concat(o,", ").concat(s,", ").concat(c,", 1)")
e=t.createElement("div",{className:"tcfColorInputSlider--gradient",style:{background:"linear-gradient(to right, ".concat(u,", ").concat(d,")")}})}return t.createElement("div",{className:"tcfColorInputSlider ".concat(i),onMouseDown:this.handleMouseDown},e,t.createElement("div",{className:"tcfColorInputSlider--track",ref:this.setElement},t.createElement("div",{className:"tcfColorInputSlider--handle",style:{left:"".concat(100*l,"%")}})))}},{key:"stopListening",value:function(){window.removeEventListener("mousemove",this.handleMouseMove),window.removeEventListener("mouseup",this.handleMouseUp)}},{key:"update",value:function(e){var t=this.element
if(t){var n=this.props,r=n.hsv,a=n.onHsvColor,i=n.type,l=t.getBoundingClientRect(),o=Math.max(0,Math.min(1,(e-l.left)/l.width))
a(Object.assign({},r,_defineProperty({},i,o)))}}}]),n}(t.Component)),dr=Tt(Lt),fr=function(e){function n(){var e
return _classCallCheck(this,n),e=_possibleConstructorReturn(this,_getPrototypeOf(n).apply(this,arguments)),e.state={hasColorPicker:!1},e.handleChange=function(t){e.props.onChange(t)},e.handleSwatchClick=function(){e.setState({hasColorPicker:!0})},e.handleOverlayClick=function(){e.setState({hasColorPicker:!1})},e}return _inherits(n,e),_createClass(n,[{key:"render",value:function(){var e=this.state.hasColorPicker,n=this.props,r=n.color,a=n.disableAlpha,i=n.disabled,l=n.onChange,o=n.presetColors
return t.createElement(or,{color:r,onChange:l},t.createElement("div",{className:"tcfColorInput"},t.createElement(dr,{className:"tcfColorInput--swatch",disabled:i,onClick:this.handleSwatchClick},e&&!i?t.createElement(Jn,{onClick:this.handleOverlayClick},t.createElement(Ut,{disableAlpha:a,presetColors:o})):null),t.createElement(sr,{type:"hex"})))}}]),n}(t.Component),mr=function(e){function t(){return _classCallCheck(this,t),_possibleConstructorReturn(this,_getPrototypeOf(t).call(this,{widget:Ft}))}return _inherits(t,e),_createClass(t,[{key:"createValue",value:function(e){return Nt()}},{key:"isValue",value:function(e,t){return Ot(t)}},{key:"preview",value:function(e){e.context,e.value
return""}}]),t}(tr),hr=function(e){function n(){var e
return _classCallCheck(this,n),e=_possibleConstructorReturn(this,_getPrototypeOf(n).apply(this,arguments)),e.request=null,e.state={mode:"idle"},e.handleChange=function(t){e.updateOEmbed(),e.setState({mode:"typing"}),e.props.onUpdate(Object.assign({},e.getOEmbed(),{url:t.target.value}))},e.updateOEmbed=Wt(function(){e.setState({mode:"loading"})
var t=e.props,n=t.apiEndpoint,r=t.model,a=t.field,i=["schema=".concat(encodeURIComponent(r.__type)),"field=".concat(encodeURIComponent(a.name)),"url=".concat(encodeURIComponent(e.getOEmbed().url))],l=new XMLHttpRequest
l.onreadystatechange=function(){return e.handleRequestStateChange(l)},l.onerror=function(){return e.handleRequestError()},l.open("GET","".concat(n,"&").concat(i.join("&"))),l.send(),e.request&&e.request.abort(),e.request=l},500),e}return _inherits(n,e),_createClass(n,[{key:"getOEmbed",value:function(){var e=this.props.data
return zt(e)?e:{url:""}}},{key:"handleRequestStateChange",value:function(e){if(e.readyState===XMLHttpRequest.DONE){if(200!==e.status)return this.handleRequestError()
var t
try{t=JSON.parse(e.responseText)}catch(e){return this.handleRequestError()}this.setState({mode:"idle"}),this.request=null,this.props.onUpdate(Object.assign({},this.getOEmbed(),{info:t.data}))}}},{key:"handleRequestError",value:function(){this.setState({mode:"idle"}),this.request=null,this.props.onUpdate(Object.assign({},this.getOEmbed(),{info:null}))}},{key:"render",value:function(){var e,n=this.getOEmbed(),r=this.props.disabled,a=this.state.mode
if("typing"===a||"loading"===a)e=t.createElement("div",{className:"tcfOEmbedWidget--activity"},t.createElement("div",{className:"tcfOEmbedWidget--activityBounce first"}),t.createElement("div",{className:"tcfOEmbedWidget--activityBounce second"}),t.createElement("div",{className:"tcfOEmbedWidget--activityBounce third"}))
else if(n.info){var i=n.info,l=i.title,o=i.author_name,s=i.thumbnail_url
e=t.createElement("div",{className:"tcfOEmbedWidget--info"},s?t.createElement("img",{className:"tcfOEmbedWidget--infoImage",src:s}):null,t.createElement("div",{className:"tcfOEmbedWidget--infoContent"},t.createElement("div",{className:"tcfOEmbedWidget--infoTitle"},l),t.createElement("div",{className:"tcfOEmbedWidget--infoAuthor"},o)))}else e=t.createElement(Vt,{title:"Invalid embed url"})
return t.createElement("div",{className:"tcfOEmbedWidget"},t.createElement("div",{className:"tcfOEmbedWidget--input"},t.createElement("input",{autoComplete:"off",className:"text fullwidth",disabled:r,onChange:r?void 0:this.handleChange,value:n.url})),e)}}]),n}(t.Component),pr=i.connect(function(e){return{apiEndpoint:e.config.apiEndpoints.oembed}})(hr),vr=function(){function e(t){_classCallCheck(this,e),this.value=t}return _createClass(e,[{key:"toHTML",value:function(){var e=this.value.info
if(!e)return new o.SafeString("")
var t=""
return e.thumbnail_url&&(t='<img class="tcfOEmbedWidget--infoImage" src="'.concat(e.thumbnail_url,'" />')),new o.SafeString('\n      <div class="tcfOEmbedWidget--info">\n        '.concat(t,'\n        <div class="tcfOEmbedWidget--infoContent">\n          <div class="tcfOEmbedWidget--infoTitle">').concat(e.title,'</div>\n          <div class="tcfOEmbedWidget--infoAuthor">').concat(e.author_name,"</div>\n        </div>\n      </div>\n    "))}},{key:"author",get:function(){return this.value.info?this.value.info.author_name:""}},{key:"thumbnail",get:function(){var e=this.value.info
return e&&e.thumbnail_url?new o.SafeString('<img width="100" src='.concat(e.thumbnail_url," />")):""}},{key:"title",get:function(){return this.value.info?this.value.info.title:""}}]),e}(),yr=function(e){function t(){return _classCallCheck(this,t),_possibleConstructorReturn(this,_getPrototypeOf(t).call(this,{widget:pr}))}return _inherits(t,e),_createClass(t,[{key:"createValue",value:function(e){return{url:""}}},{key:"isValue",value:function(e,t){return zt(t)}},{key:"preview",value:function(e){var t=e.value
return new vr(zt(t)?t:{url:""})}}]),t}(tr),gr=function(e){function t(){return _classCallCheck(this,t),_possibleConstructorReturn(this,_getPrototypeOf(t).call(this,{factory:$t,widget:Gt}))}return _inherits(t,e),_createClass(t,[{key:"cloneValue",value:function(e){return Z(this,void 0,void 0,regeneratorRuntime.mark(function t(){var n,r,a
return regeneratorRuntime.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:if(n=e.field,r=e.value,a=K(e,["field","value"]),!this.isValue(n,r)){t.next=5
break}return t.abrupt("return",ee(Object.assign({},a,{source:r})))
case 5:return t.abrupt("return",this.createValue(e))
case 6:case"end":return t.stop()}},t,this)}))}},{key:"createValue",value:function(e){var t=e.field,n=e.schema,r=e.schemas
if(n||(n=r[t.schemas[0]]),!n)throw new Error("The option `schema` is required when creating instances.")
return M({schema:n,schemas:r})}},{key:"isValue",value:function(e,t){return d(t)&&-1!==e.schemas.indexOf(t.__type)}},{key:"preview",value:function(e){var t=e.context,n=e.mode,r=void 0===n?"default":n,a=e.value
if(!d(a))return""
var i=t.schemas[a.__type]
if(!i)return""
var l="label"===r?i.previewLabelTemplate:i.previewTemplate
if(null===l)return i.label
var s={toHTML:function(){return new o.SafeString(l(s))},toString:function(){return l(s)}}
s.depth=t.depth
for(var c=0,u=Object.keys(i.fields);c<u.length;c++){var f=u[c],m=i.fields[f],h=En.getDefinition(m)
h&&(s[f]=h.preview({context:Object.assign({},t,{depth:t.depth+1}),field:m,value:a[f]}))}return s}}]),t}(tr),br=function(e){function t(){return _classCallCheck(this,t),_possibleConstructorReturn(this,_getPrototypeOf(t).call(this,{widget:Yt}))}return _inherits(t,e),t}(rr),Er=function(e){function n(){var e
return _classCallCheck(this,n),e=_possibleConstructorReturn(this,_getPrototypeOf(n).apply(this,arguments)),e.element=null,e.renderedIds=[],e.uuid="element-".concat(A()),e.instance=null,e.isRendering=!1,e.handleAdd=function(t){var n=t.elements,r=e.props,a=r.elementType,i=r.onAddReferences
e.handleChange(),i(n.map(function(e){return Object.assign({},e,{$element:$(e.$element[0].outerHTML),element:e.$element[0].outerHTML,type:a})}))},e.handleChange=function(){if(!e.isRendering){var t=e.props.onUpdate,n=e.getSelectedIds()
e.renderedIds=n,t(n)}},e.setElement=function(t){if(e.element!==t){e.element=t
var n=_assertThisInitialized(e).instance
if(n&&(n.off("selectElements",e.handleAdd),n.off("removeElements",e.handleChange),n.elementSort&&n.elementSort.off("sortChange",e.handleChange),n.destroy(),e.instance=n=null),t){var r=e.props,a=r.criteria,i=r.elementType,l=r.limit,o=void 0===l?null:l,s=r.modalStorageKey,c=void 0===s?null:s,u=r.sourceElementId,d=r.sources,f=r.viewMode,m=void 0===f?"small":f
n=new Craft.BaseElementSelectInput({criteria:a,elementType:i,id:e.uuid,limit:o,modalStorageKey:c,name:e.uuid,sources:d,sourceElementId:u,viewMode:m}),e.instance=n,e.createReferences(),n.on("selectElements",e.handleAdd),n.on("removeElements",e.handleChange),n.elementSort&&n.elementSort.on("sortChange",e.handleChange)}}},e}return _inherits(n,e),_createClass(n,[{key:"componentDidUpdate",value:function(){var e=this.renderedIds,t=this.props.data||[]
t.length===e.length&&t.every(function(t,n){return t===e[n]})||this.createReferences()}},{key:"createReferences",value:function(){var e=this.instance
if(e){this.isRendering=!0
var t=[]
e.$elementsContainer.empty()
var n=!0,r=!1,a=void 0
try{for(var i,l=this.getStoredReferences()[Symbol.iterator]();!(n=(i=l.next()).done);n=!0){var o=i.value,s=e.createNewElement(o)
s.find("input").prop("disabled",!0),e.appendElement(s),t.push(o.id)}}catch(e){r=!0,a=e}finally{try{n||null==l.return||l.return()}finally{if(r)throw a}}e.resetElements(),this.renderedIds=t,this.isRendering=!1}}},{key:"getStoredReferences",value:function(){var e=this.props,t=e.data,n=e.elementType,r=e.references,a=[]
if(!Array.isArray(t))return a
var i=!0,l=!1,o=void 0
try{for(var s,c=t[Symbol.iterator]();!(i=(s=c.next()).done);i=!0)!function(){var e=s.value,t=r.find(function(t){return t.id===e&&t.type===n})
t&&a.push(t)}()}catch(e){l=!0,o=e}finally{try{i||null==c.return||c.return()}finally{if(l)throw o}}return a}},{key:"getSelectedIds",value:function(){var e=this.instance
if(!e)return[]
for(var t=[],n=e.getSelectedElementIds(),r=e.getElements(),a=0;a<r.length;a++){var i=parseInt(r.eq(a).data("id"));-1!==n.indexOf(i)&&t.push(i)}return t}},{key:"render",value:function(){return t.createElement("div",{id:this.uuid,className:"elementselect",ref:this.setElement},t.createElement("div",{className:"elements"}),t.createElement("div",{className:"btn add icon dashed"},"Choose"))}}]),n}(t.Component),Cr=i.connect(function(e){return{references:e.config.references,sourceElementId:e.config.elementId}},function(e){return{onAddReferences:function(t){e(R(t))}}})(Kt),_r=function(e){function t(){return _classCallCheck(this,t),_possibleConstructorReturn(this,_getPrototypeOf(t).call(this,{widget:nn}))}return _inherits(t,e),_createClass(t,[{key:"createValue",value:function(){return{elementId:0,openInNewWindow:!1,type:"url",url:""}}},{key:"isValue",value:function(e,t){return tn(t)}},{key:"preview",value:function(){return""}}]),t}(tr),wr=function(){function e(t){_classCallCheck(this,e),this.latitude=t.latitude,this.longitude=t.longitude}return _createClass(e,[{key:"createStaticMap",value:function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:100,t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:75,n=this.latitude,r=this.longitude,a=ye()
if(!a)return new o.SafeString("")
var i=["key=".concat(a),"center=".concat(encodeURIComponent("".concat(n,",").concat(r))),"markers=".concat(encodeURIComponent("size:small|".concat(n,",").concat(r))),"size=".concat(e,"x").concat(t),"zoom=15","maptype=roadmap"].join("&")
return new o.SafeString('\n      <img src="https://maps.googleapis.com/maps/api/staticmap?'.concat(i,'" width="').concat(e,'" height="').concat(t,'" />\n    '))}},{key:"toHTML",value:function(){return this.createStaticMap()}}]),e}(),kr=["address","street","country","zip","city"],Sr=function(e){function n(){var e
return _classCallCheck(this,n),e=_possibleConstructorReturn(this,_getPrototypeOf(n).apply(this,arguments)),e.autocomplete=null,e.input=null,e.state={isSearching:!1},e.handlePlaceChanged=function(){var t=_assertThisInitialized(e).autocomplete
if(t){var n=t.getPlace()
n.geometry&&e.props.onLocation({latitude:n.geometry.location.lat(),longitude:n.geometry.location.lng()})}},e.handleResolve=function(){var t=e.props.places
t&&(e.setState({isSearching:!0}),t.findPlaceFromQuery({query:e.getResolveQuery(),fields:["formatted_address","geometry"]},e.handleResolveResults))},e.handleResolveResults=function(t){e.setState({isSearching:!1}),t||(t=[]),1===t.length?e.handleResultsSelect(t[0]):e.setState({results:t})},e.handleResultsSelect=function(t){var n=t.geometry
if(n){var r=n.location
e.props.onLocation({latitude:r.lat(),longitude:r.lng()}),e.handleResultsCancel()}},e.handleResultsCancel=function(){e.state.results&&e.setState({results:void 0})},e.setInput=function(t){var n=_assertThisInitialized(e).autocomplete
e.input=t,n&&(n.unbindAll(),n=null),t&&((n=new google.maps.places.Autocomplete(t)).setFields(["geometry"]),n.addListener("place_changed",e.handlePlaceChanged)),e.autocomplete=n},e}return _inherits(n,e),_createClass(n,[{key:"canResolve",value:function(){return""!==this.getResolveQuery()}},{key:"getResolveQuery",value:function(){for(var e=this.props.model,t=[],n=0,r=kr;n<r.length;n++){var a=r[n]
a in e&&"string"==typeof e[a]&&t.push(e[a].trim())}return t.join(", ")}},{key:"render",value:function(){var e
if(this.canResolve()){var n,r=this.state.results
r&&0===r.length?n=t.createElement(Dt,{icon:"material:error"},"No locations found"):r&&(n=t.createElement(rn,{onSelect:this.handleResultsSelect,results:r})),e=t.createElement("div",{className:"tcfLocationFieldSearch--resolve"},n?t.createElement(Jn,{onClick:this.handleResultsCancel},n):null,t.createElement(Oe,{onClick:this.handleResolve},t.createElement(Te,{value:"Resolve address"})))}return t.createElement("div",{className:"tcfLocationFieldSearch"},e,t.createElement("input",{className:"tcfLocationFieldSearch--input tcfInput",ref:this.setInput,type:"search"}))}}]),n}(t.Component),xr=17
!function(e){e[e.Loading=0]="Loading",e[e.Error=1]="Error",e[e.Ready=2]="Ready"}(er||(er={}))
var Nr=function(e){function n(){var e
return _classCallCheck(this,n),e=_possibleConstructorReturn(this,_getPrototypeOf(n).apply(this,arguments)),e.element=null,e.marker=null,e.state={instance:null,loadState:er.Loading},e.handleLocation=function(t){var n=e.state.instance
n&&(n.map.setZoom(xr),n.map.setCenter({lat:t.latitude,lng:t.longitude})),e.props.onUpdate(t)},e.handleMarkerDragEnd=function(){var t=_assertThisInitialized(e).marker
if(t){var n=t.getPosition()
n&&e.props.onUpdate({latitude:n.lat(),longitude:n.lng()})}},e.setElement=function(t){var r=e.props.disabled,a=e.state.instance,i=_assertThisInitialized(e).marker
if(a&&(n.stashInstance(a),a=null),i&&(i.setMap(null),i.unbindAll(),i=null),t){a=n.createInstance(),t.appendChild(a.element)
var l=a.map
l.setZoom(xr),l.setCenter(e.getLatLng()),(i=new google.maps.Marker({draggable:!r,position:e.getLatLng(),map:l})).addListener("dragend",e.handleMarkerDragEnd)}e.element=t,e.marker=i,e.setState({instance:a})},e}return _inherits(n,e),_createClass(n,[{key:"componentDidUpdate",value:function(e){var t=this.marker
e.disabled!==this.props.disabled&&t&&t.setOptions({draggable:!this.props.disabled})}},{key:"componentWillMount",value:function(){var e=this
try{ge().then(function(){e.setState({loadState:er.Ready})})}catch(e){this.setState({loadState:er.Error})}}},{key:"getLatLng",value:function(){var e=this.props.data
return an(e)?{lat:e.latitude,lng:e.longitude}:{lat:0,lng:0}}},{key:"render",value:function(){var e=this.state,n=e.loadState,r=e.instance,a=this.props,i=a.disabled,l=a.model,o=this.marker
o&&o.setPosition(this.getLatLng())
var s
return s=n===er.Loading?t.createElement(He,null):n===er.Error?t.createElement(Vt,{title:"Could not load Google Maps"}):t.createElement(t.Fragment,null,i?null:t.createElement(Sr,{model:l,onLocation:this.handleLocation,places:r?r.places:null}),t.createElement("div",{className:"tcfLocation--map",ref:this.setElement})),t.createElement("div",{className:"tcfLocation"},s)}}],[{key:"createInstance",value:function(){var e=this.instanceStash.pop()
if(!e){var t=document.createElement("div")
t.className="tcfLocation--mapInstance"
var n=new google.maps.Map(t,{mapTypeControl:!1,streetViewControl:!1})
e={element:t,map:n,places:new google.maps.places.PlacesService(n)}}return e}},{key:"stashInstance",value:function(e){var t=e.element,n=t.parentElement
n&&n.removeChild(t),this.instanceStash.push(e)}}]),n}(t.Component)
Nr.instanceStash=[]
var Or=function(e){function t(){return _classCallCheck(this,t),_possibleConstructorReturn(this,_getPrototypeOf(t).call(this,{widget:Nr}))}return _inherits(t,e),_createClass(t,[{key:"createValue",value:function(e){var t=e.field
return an(t.defaultValue)?Object.assign({},t.defaultValue):{latitude:0,longitude:0}}},{key:"isValue",value:function(e,t){return an(t)}},{key:"preview",value:function(e){var t=e.value
return new wr(t)}}]),t}(tr),Ir=function(e){function t(){return _classCallCheck(this,t),_possibleConstructorReturn(this,_getPrototypeOf(t).call(this,{widget:on}))}return _inherits(t,e),t}(function(e){function t(){return _classCallCheck(this,t),_possibleConstructorReturn(this,_getPrototypeOf(t).apply(this,arguments))}return _inherits(t,e),_createClass(t,[{key:"cloneValue",value:function(e){return Z(this,void 0,void 0,regeneratorRuntime.mark(function t(){var n,r,a
return regeneratorRuntime.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:return n=e.field,r=e.schemas,a=e.value,t.abrupt("return",this.isValue(n,a)?a:this.createValue({field:n,schemas:r}))
case 2:case"end":return t.stop()}},t,this)}))}},{key:"createValue",value:function(e){return e.field.defaultValue}},{key:"isValue",value:function(e,t){return!(!e.optional||null!==t)||("number"==typeof t||t instanceof Number)}},{key:"preview",value:function(e){return e.value}}]),t}(tr)),Rr=function(){function e(t){_classCallCheck(this,e),this.value=t}return _createClass(e,[{key:"toHTML",value:function(){return new o.SafeString(this.value)}},{key:"summary",get:function(){return new o.SafeString('<div class="snippet">'.concat(this.value,"</div>"))}}]),e}(),Ar=function(e){function n(){var e
return _classCallCheck(this,n),e=_possibleConstructorReturn(this,_getPrototypeOf(n).apply(this,arguments)),e.element=null,e.hasFocus=!1,e.instance=null,e.renderedValue="",e.uuid="element-".concat(A()),e.handleBlur=function(){e.hasFocus=!1},e.handleChange=function(t){e.hasFocus&&(e.renderedValue=t,e.props.onUpdate(t))},e.handleFocus=function(){e.hasFocus=!0},e.setElement=function(t){if(e.element!==t){e.element=t
var n=e.props,r=n.elementSiteId,a=n.options,i=_assertThisInitialized(e).instance
i&&(i.redactor&&(i.redactor.off("blur",e.handleBlur),i.redactor.off("changed",e.handleChange),i.redactor.off("focus",e.handleFocus)),i.destroy(),i=null),t&&(i=new Craft.RedactorInput(Object.assign({},a,{elementSiteId:r,id:e.uuid,redactorConfig:Object.assign({},a.redactorConfig)}))).redactor&&(i.redactor.on("blur",e.handleBlur),i.redactor.on("changed",e.handleChange),i.redactor.on("focus",e.handleFocus)),e.instance=i}},e}return _inherits(n,e),_createClass(n,[{key:"componentDidUpdate",value:function(){var e=this.hasFocus,t=this.instance,n=this.props,r=this.renderedValue
t&&!e&&n.value!=r&&(this.renderedValue=n.value,t.redactor.source.setCode(n.value))}},{key:"render",value:function(){var e=this.props.value
return t.createElement("div",{className:"tcfRedactorWidget"},t.createElement("textarea",{defaultValue:"string"==typeof e?e:"",disabled:!0,id:this.uuid,ref:this.setElement}))}}]),n}(t.Component),Mr=i.connect(function(e){return{elementSiteId:e.config.elementSiteId}})(un),Pr=0,Tr=function(e){function t(){return _classCallCheck(this,t),_possibleConstructorReturn(this,_getPrototypeOf(t).apply(this,arguments))}return _inherits(t,e),_createClass(t,[{key:"cloneValue",value:function(e){return Z(this,void 0,void 0,regeneratorRuntime.mark(function t(){var n,r,a
return regeneratorRuntime.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:if(n=e.field,r=e.translate,a=e.value,!this.isValue(n,a)){t.next=9
break}if(!n.translatable||!r){t.next=6
break}return t.abrupt("return",dn(a,r))
case 6:return t.abrupt("return",a)
case 7:t.next=10
break
case 9:return t.abrupt("return","")
case 10:case"end":return t.stop()}},t,this)}))}},{key:"createValue",value:function(e){return""}},{key:"isValue",value:function(e,t){return"string"==typeof t||t instanceof String}},{key:"preview",value:function(e){return e.value}}]),t}(tr),jr=function(e){function t(){return _classCallCheck(this,t),_possibleConstructorReturn(this,_getPrototypeOf(t).call(this,{widget:Mr}))}return _inherits(t,e),_createClass(t,[{key:"preview",value:function(e){var t=e.value
return new Rr(t)}}]),t}(Tr),Lr=function(){function e(t){_classCallCheck(this,e),this.reference=t}return _createClass(e,[{key:"createPreview",value:function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"large",t=!(arguments.length>1&&void 0!==arguments[1])||arguments[1],n=this.reference.$element.clone(!1,!0)
n.removeClass("large removable small"),n.addClass(e)
var r=n.find(".elementthumb")
if(r.length){var a=r.find("img")[0]
a||((a=document.createElement("img")).srcset=r.attr("data-srcset")||"",r.append(a)),a.sizes="small"===e?"30px":"100px"}return t?'<div class="tcfInstancePreview--thumb '.concat(e,'">').concat(r?r.html():"","</div>"):n[0].outerHTML}},{key:"createSafePreview",value:function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"large",t=!(arguments.length>1&&void 0!==arguments[1])||arguments[1]
return new o.SafeString(this.createPreview(e,t))}},{key:"toHTML",value:function(){return new o.SafeString(this.toString())}},{key:"toString",value:function(){return this.createPreview()}},{key:"asBackground",get:function(){var e=this.reference.$element.find(".elementthumb").attr("data-srcset")
if(!e)return null
var t=e.split(",").pop()
return t?new o.SafeString('<div class="tcfInstancePreview--background" style="background-image: url(\''.concat(t.trim(),'\');"></div><div class="tcfInstancePreview--background blur" style="background-image: url(\'').concat(t.trim(),"');\"></div>")):null}},{key:"asLargeElement",get:function(){return this.createSafePreview("large",!1)}},{key:"asLargeImage",get:function(){return this.createSafePreview("large",!0)}},{key:"asSmallElement",get:function(){return this.createSafePreview("small",!1)}},{key:"asSmallImage",get:function(){return this.createSafePreview("small",!0)}}]),e}(),Ur=function(e){function t(e){var n
return _classCallCheck(this,t),_possibleConstructorReturn(this,(n=_getPrototypeOf(t)).call.apply(n,[this].concat(_toConsumableArray(fn(e)))))}return _inherits(t,e),_createClass(t,[{key:"toHTML",value:function(){return new o.SafeString('<div class="tcfInstancePreview--elements">'.concat(this.toString(),"</div>"))}},{key:"toString",value:function(){for(var e=[],t=0;t<this.length;t++)e.push(Ke(this[t]))
return e.join("")}},{key:"asBackground",get:function(){return this.length?this[0].asBackground:null}},{key:"asLargeElement",get:function(){return this.length?this[0].asLargeElement:null}},{key:"asLargeImage",get:function(){return this.length?this[0].asLargeImage:null}},{key:"asSmallElement",get:function(){return this.length?this[0].asSmallElement:null}},{key:"asSmallImage",get:function(){return this.length?this[0].asSmallImage:null}}]),t}(_wrapNativeSuper(Array)),Fr=function(e){function t(){return _classCallCheck(this,t),_possibleConstructorReturn(this,_getPrototypeOf(t).call(this,{widget:mn}))}return _inherits(t,e),_createClass(t,[{key:"createValue",value:function(e){return[]}},{key:"isValue",value:function(e,t){return Array.isArray(t)&&t.every(function(e){return"number"==typeof e})}},{key:"preview",value:function(e){return new Ur(e)}}]),t}(tr),Wr=function(e){function t(){return _classCallCheck(this,t),_possibleConstructorReturn(this,_getPrototypeOf(t).apply(this,arguments))}return _inherits(t,e),_createClass(t,[{key:"createValue",value:function(e){var t=e.field
return t.defaultValue&&this.isValue(t,t.defaultValue)?t.defaultValue:t.options[0].key}},{key:"isValue",value:function(e,t){return e.options.some(function(e){return e.key==t})}},{key:"preview",value:function(e){var t=e.field,n=e.value,r=t?t.options.find(function(e){return e.key===n}):void 0
return r?r.label:"-"}}]),t}(tr),Dr=function(e){function t(){return _classCallCheck(this,t),_possibleConstructorReturn(this,_getPrototypeOf(t).call(this,{widget:hn}))}return _inherits(t,e),t}(Wr),Vr=function(e){function n(){var e
return _classCallCheck(this,n),e=_possibleConstructorReturn(this,_getPrototypeOf(n).apply(this,arguments)),e.state={isExpanded:!1},e.handleFlyoutClick=function(){e.setState({isExpanded:!1})},e.handleSelect=function(t){e.props.onUpdate(t.key),e.setState({isExpanded:!1})},e.handleSwatchClick=function(t){t.currentTarget===t.target&&e.setState({isExpanded:!0})},e}return _inherits(n,e),_createClass(n,[{key:"render",value:function(){var e=this.props,n=e.data,r=e.disabled,a=e.field,i=this.state.isExpanded,l=a.options.find(function(e){return e.key===n})
return t.createElement("div",{className:In("tcfSwatchColorWidget",{isUndecided:!l}),onClick:r?void 0:this.handleSwatchClick,style:{background:l?pn(l):void 0}},i&&!r?this.renderFlyout(l):null)}},{key:"renderFlyout",value:function(e){var n=this,r=this.props.field
return t.createElement(Jn,{onClick:this.handleFlyoutClick},t.createElement("div",{className:"tcfSwatchColorWidget--swatches"},r.options.map(function(r){return t.createElement("div",{className:In("tcfSwatchColorWidget--swatch",{isSelected:r===e}),key:r.key,onClick:function(){return n.handleSelect(r)},style:{background:pn(r)}})})))}}]),n}(t.Component),zr=function(e){function t(){return _classCallCheck(this,t),_possibleConstructorReturn(this,_getPrototypeOf(t).call(this,{widget:Vr}))}return _inherits(t,e),t}(Wr),Br=function(e){function t(){return _classCallCheck(this,t),_possibleConstructorReturn(this,_getPrototypeOf(t).call(this,{widget:vn}))}return _inherits(t,e),t}(Tr),Hr=function(e){function t(){return _classCallCheck(this,t),_possibleConstructorReturn(this,_getPrototypeOf(t).call(this,{widget:yn}))}return _inherits(t,e),t}(Tr)
En.initialize({array:new nr,checkbox:new ir,color:new mr,instance:new gr,lightswitch:new br,link:new _r,location:new Or,number:new Ir,oembed:new yr,redactor:new jr,reference:new Fr,select:new Dr,swatchcolor:new zr,text:new Br,textarea:new Hr})
var qr=[],$r={},Xr={create:function(e){try{var l=document.getElementById(e)
if(!l)throw new Error("Root element not found.")
var o=l.querySelector(".tcfField--app"),s=l.querySelector('script[type="application/json"]'),c=l.querySelector("input.tcfField--model")
if(!c||!o||!s)throw new Error("Missing components.")
var u=a.createStore(Qe,xe(s,c),a.applyMiddleware(r))
qr.push(u),u.subscribe(function(){var e=JSON.stringify(u.getState().model)
c.value!==e&&(c.value=e)}),n.render(t.createElement(i.Provider,{store:u},t.createElement(Ye,null)),o)}catch(e){console.error("Could not start content editor: "+e.message)}},getInstanceApi:function(e){for(var t=0,n=qr;t<n.length;t++){var r=n[t],a=m(r.getState(),e)
return a?pe(r,a):null}},getValidator:function(e){return e in $r?$r[e]:null},registerValidator:function(e,t){$r[e]=t}}
return Xr}(_babelPolyfill,React,ReactDOM,ReduxThunk,Redux,ReactRedux,jQuery,Handlebars,ReactDnDHTML5Backend,ReactDnD)
