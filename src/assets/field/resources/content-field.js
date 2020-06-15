"use strict"
function _wrapNativeSuper(e){var t="function"==typeof Map?new Map:void 0
return(_wrapNativeSuper=function(e){function n(){return _construct(e,arguments,_getPrototypeOf(this).constructor)}if(null===e||!_isNativeFunction(e))return e
if("function"!=typeof e)throw new TypeError("Super expression must either be null or a function")
if(void 0!==t){if(t.has(e))return t.get(e)
t.set(e,n)}return n.prototype=Object.create(e.prototype,{constructor:{value:n,enumerable:!1,writable:!0,configurable:!0}}),_setPrototypeOf(n,e)})(e)}function _construct(e,t,n){return(_construct=_isNativeReflectConstruct()?Reflect.construct:function(e,t,n){var r=[null]
r.push.apply(r,t)
var a=new(Function.bind.apply(e,r))
return n&&_setPrototypeOf(a,n.prototype),a}).apply(null,arguments)}function _isNativeFunction(e){return-1!==Function.toString.call(e).indexOf("[native code]")}function _inherits(e,t){if("function"!=typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function")
e.prototype=Object.create(t&&t.prototype,{constructor:{value:e,writable:!0,configurable:!0}}),t&&_setPrototypeOf(e,t)}function _setPrototypeOf(e,t){return(_setPrototypeOf=Object.setPrototypeOf||function(e,t){return e.__proto__=t,e})(e,t)}function _createSuper(e){var t=_isNativeReflectConstruct()
return function(){var n,r=_getPrototypeOf(e)
if(t){var a=_getPrototypeOf(this).constructor
n=Reflect.construct(r,arguments,a)}else n=r.apply(this,arguments)
return _possibleConstructorReturn(this,n)}}function _possibleConstructorReturn(e,t){return!t||"object"!==_typeof(t)&&"function"!=typeof t?_assertThisInitialized(e):t}function _assertThisInitialized(e){if(void 0===e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called")
return e}function _isNativeReflectConstruct(){if("undefined"==typeof Reflect||!Reflect.construct)return!1
if(Reflect.construct.sham)return!1
if("function"==typeof Proxy)return!0
try{return Date.prototype.toString.call(Reflect.construct(Date,[],function(){})),!0}catch(e){return!1}}function _getPrototypeOf(e){return(_getPrototypeOf=Object.setPrototypeOf?Object.getPrototypeOf:function(e){return e.__proto__||Object.getPrototypeOf(e)})(e)}function _slicedToArray(e,t){return _arrayWithHoles(e)||_iterableToArrayLimit(e,t)||_unsupportedIterableToArray(e,t)||_nonIterableRest()}function _nonIterableRest(){throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}function _iterableToArrayLimit(e,t){if("undefined"!=typeof Symbol&&Symbol.iterator in Object(e)){var n=[],r=!0,a=!1,i=void 0
try{for(var l,o=e[Symbol.iterator]();!(r=(l=o.next()).done)&&(n.push(l.value),!t||n.length!==t);r=!0);}catch(e){a=!0,i=e}finally{try{r||null==o.return||o.return()}finally{if(a)throw i}}return n}}function _arrayWithHoles(e){if(Array.isArray(e))return e}function _defineProperty(e,t,n){return t in e?Object.defineProperty(e,t,{value:n,enumerable:!0,configurable:!0,writable:!0}):e[t]=n,e}function _toConsumableArray(e){return _arrayWithoutHoles(e)||_iterableToArray(e)||_unsupportedIterableToArray(e)||_nonIterableSpread()}function _nonIterableSpread(){throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}function _iterableToArray(e){if("undefined"!=typeof Symbol&&Symbol.iterator in Object(e))return Array.from(e)}function _arrayWithoutHoles(e){if(Array.isArray(e))return _arrayLikeToArray(e)}function _classCallCheck(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}function _defineProperties(e,t){for(var n=0;n<t.length;n++){var r=t[n]
r.enumerable=r.enumerable||!1,r.configurable=!0,"value"in r&&(r.writable=!0),Object.defineProperty(e,r.key,r)}}function _createClass(e,t,n){return t&&_defineProperties(e.prototype,t),n&&_defineProperties(e,n),e}function _createForOfIteratorHelper(e,t){var n
if("undefined"==typeof Symbol||null==e[Symbol.iterator]){if(Array.isArray(e)||(n=_unsupportedIterableToArray(e))||t&&e&&"number"==typeof e.length){n&&(e=n)
var r=0,a=function(){}
return{s:a,n:function(){return r>=e.length?{done:!0}:{done:!1,value:e[r++]}},e:function(e){throw e},f:a}}throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}var i,l=!0,o=!1
return{s:function(){n=e[Symbol.iterator]()},n:function(){var e=n.next()
return l=e.done,e},e:function(e){o=!0,i=e},f:function(){try{l||null==n.return||n.return()}finally{if(o)throw i}}}}function _unsupportedIterableToArray(e,t){if(e){if("string"==typeof e)return _arrayLikeToArray(e,t)
var n=Object.prototype.toString.call(e).slice(8,-1)
return"Object"===n&&e.constructor&&(n=e.constructor.name),"Map"===n||"Set"===n?Array.from(e):"Arguments"===n||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)?_arrayLikeToArray(e,t):void 0}}function _arrayLikeToArray(e,t){(null==t||t>e.length)&&(t=e.length)
for(var n=0,r=new Array(t);n<t;n++)r[n]=e[n]
return r}function _typeof(e){"@babel/helpers - typeof"
return(_typeof="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e})(e)}var contentField=function(e,t,n,r,a,i,l,o,c,s){function u(e,t){var n=e.schemas[t.__type]
if(!n)throw new Error('Could not resolve schema "'.concat(t.__type,'".'))
return n}function d(e){return e&&"object"===_typeof(e)&&"__type"in e&&"__uuid"in e}function f(e,t,n){if(d(n)&&n.__uuid===t)return{model:n,path:[],uuid:t}
for(var r=u(e,n),a=0,i=Object.keys(r.fields);a<i.length;a++){var l=i[a],o=r.fields[l]
if("array"===o.type&&"instance"===o.member.type){var c=n[l]
if(!Array.isArray(c))continue
for(var s=0;s<c.length;s++){var m=f(e,t,c[s])
if(null!==m)return m.path.unshift({type:"index",name:l,index:s}),m}}else if("instance"===o.type){var p=f(e,t,n[l])
if(null!==p)return p.path.unshift({type:"property",name:l}),p}}return null}function m(e,t){return f(e,t,e.model)}function p(e){for(var t=[],n=e;n.length;){var r=/^([^\[\.]+)(?:\[(\d+)\])?\.?/.exec(n)
if(!r)throw new Error('Invalid path segment "'.concat(n,'" in path "').concat(e,'".'))
n=n.substr(r[0].length),3===r.length?t.push({index:parseInt(r[1]),name:r[2],type:"index"}):t.push({name:r[1],type:"property"})}return t}function h(e,t){if(!(t.name in e))return null
var n=e[t.name]
return"index"===t.type?!Array.isArray(n)||t.index<0||t.index>=n.length?null:n[t.index]:n}function v(e,t){"string"==typeof t&&(t=p(t))
for(var n=e,r=0;r<t.length;r++)if(!(n=h(n,t[r])))return n
return n}function y(e,t){var n=(t="string"==typeof t?p(t):t.slice()).pop()
if(!n)return null
var r=v(e.model,t)
if(!r)throw new Error("Could not resolve owner")
var a=u(e,r),i="index"===n.type?n.index:void 0,l=a.fields[n.name]
if(!l)throw new Error('Could not resolve field "'.concat(n.name,'" on schema "').concat(a.qualifier,'".'))
return{field:l,index:i,owner:r,path:t,schema:a}}function g(e,t){return Craft.t("contentfield",e,t)}function b(){return null}function E(e,t){var n,r=e.config.references.slice(),a=_createForOfIteratorHelper(t.references)
try{for(a.s();!(n=a.n()).done;)!function(){var e=n.value
r.some(function(t){var n=t.id,r=t.type
return e.id===n&&e.type===r})||(e.$element=$(e.element),e.hasThumb=e.$element.hasClass("hasthumb"),r.push(e))}()}catch(e){a.e(e)}finally{a.f()}return Object.assign(Object.assign({},e),{config:Object.assign(Object.assign({},e.config),{references:r})})}function _(e){return{references:e,type:"addReferences"}}function C(){return"10000000-1000-4000-8000-100000000000".replace(/[018]/g,function(e){return(e^crypto.getRandomValues(new Uint8Array(1))[0]&15>>e/4).toString(16)})}function w(e){for(var t=e.schemas,n=e.schema,r=e.oldModel,a={__errors:{},__type:n.qualifier,__uuid:C(),__visible:!0},i=0,l=Object.keys(n.fields);i<l.length;i++){var o=l[i],c=n.fields[o],s=Fn.getDefinition(c),u=r&&o in r?r[o]:void 0
void 0!==u&&s.isValue(c,u)||(u=s.createValue({field:c,schemas:t})),a[o]=u}return a}function k(e,t,n){if(!t)return n(e)
var r,a=e[t.name]
if("index"===t.type){if(!Array.isArray(a))throw new Error("Invalid array access.")
if(t.index<0||t.index>=a.length)throw new Error("Invalid array index ".concat(t.index,'".'));(r=a.slice())[t.index]=n(a[t.index])}else{if(Array.isArray(a))throw new Error("Invalid array access.")
r=n(a)}var i=Object.assign({},e)
return i[t.name]=r,i}function S(e,t,n){function r(e){return i=a.shift(),i?e?k(e,i,r):e:n(e)}var a="string"==typeof t?p(t):t.slice(),i=a.shift()
return k(e,i,r)}function O(e,t){var n=e.schemas[t.newType]
return n?Object.assign(Object.assign({},e),{model:S(e.model,t.path,function(t){return w({oldModel:t,schema:n,schemas:e.schemas})})}):e}function x(e,t){return{newType:t,path:e,type:"changeType"}}function N(e,t){return e.name===t.name&&e.type===t.type&&("index"!==e.type||"index"!==t.type||e.index===t.index)}function I(e){var t=e.sourcePath,n=e.sourceSegment,r=e.targetPath,a=e.targetSegment,i=[].concat(_toConsumableArray(r),[a])
if(i.length>t.length&&t.every(function(e,t){return N(e,i[t])})){var l=i[t.length]
if("index"!=l.type)throw new Error("Path segment type mismatch")
if(l.name==n.name&&l.index>n.index){i[t.length]=Object.assign(Object.assign({},l),{index:l.index-1})
var o=i.pop()
if(!o||"index"!==o.type)throw new Error("Unsupported operation")
return Object.assign(Object.assign({},e),{targetPath:i,targetSegment:o})}}return e}function j(e,t){return e.length===t.length&&e.every(function(e,n){return N(e,t[n])})}function A(e,t){var n=t.sourcePath,r=t.sourceSegment,a=t.targetPath,i=t.targetSegment,l=[].concat(_toConsumableArray(n),[r]),o=[].concat(_toConsumableArray(a),[i]),c=v(e.model,a)
if(!c)return!1
var s=e.schemas[c.__type].fields[i.name],u=c[i.name]
if("array"!==s.type||!Array.isArray(u))return!1
var d=I(t)
if(j(l,o)||j(l,[].concat(_toConsumableArray(d.targetPath),[d.targetSegment])))return!1
if(!(j(n,a)&&i.name===r.name)&&s.limit>0&&u.length>=s.limit)return!1
var f=s.member,m=Fn.getDefinition(f.type),p=v(e.model,l)
return m.isValue(f,p)}function M(e,t){var n=e.model
if(!A(e,t))throw new Error("Invalid operation")
var r=I(t),a=r.sourcePath,i=r.sourceSegment,l=r.targetPath,o=r.targetSegment,c=v(n,[].concat(_toConsumableArray(a),[i]))
return n=S(n,a,function(e){if(!e)throw new Error("Invalid operation")
var t=e[i.name]
if(!Array.isArray(t))throw new Error("Invalid operation")
return(t=t.slice()).splice(i.index,1),Object.assign(Object.assign({},e),_defineProperty({},i.name,t))}),n=S(n,l,function(e){if(!e)throw new Error("Could not find target")
var t=e[o.name]
if(!Array.isArray(t))throw new Error("Unsupported operation")
return t=t.slice(),o.index>=t.length?t.push(c):t.splice(o.index,0,c),Object.assign(Object.assign({},e),_defineProperty({},o.name,t))}),Object.assign(Object.assign({},e),{model:n})}function T(e){return Object.assign(Object.assign({},e),{type:"moveModel"})}function R(e,t){var n=t.overlay
return Object.assign(Object.assign({},e),{overlay:n})}function P(e){return{overlay:e,type:"setOverlay"}}function L(e,t){var n=t.user,r=Object.assign(Object.assign({},e.user),n)
try{window.localStorage.setItem(Un,JSON.stringify(r))}catch(e){console.error(e)}return Object.assign(Object.assign({},e),{user:r})}function F(e){return{type:"setUser",user:e}}function U(e,t,n){var r=e.fields[n].validatorId
if(!r)return null
var a=ya.getValidator(r)
if(!a)return null
var i=[]
return a(n,t[n],i),i}function D(e,t){if(d(t)){var n=e.schemas[t.__type]
n&&(t.__errors=Object.keys(n.fields).reduce(function(e,r){var a=U(n,t,r)
return a&&a.length&&(e[r]=a),e},{}))}}function W(e,t){var n=t.position,r=t.uuid,a=t.value,i=m(e,r)
if(!i)return e
var l=y(e,i.path)
if(!l||"array"!==l.field.type||void 0===l.index)return e
var o=l.field,c=l.index,s=l.path,u=o.name
return Object.assign(Object.assign({},e),{model:S(e.model,s,function(t){if(!(t&&u in t))return t
var r=t[u]
if(!Array.isArray(r))return t
var i=_toConsumableArray(r),l=c+("after"===n?1:0)
i.splice(l,0,a)
var o=Object.assign(Object.assign({},t),_defineProperty({},u,i))
return D(e,o),o})})}function V(e,t,n){return{position:n,type:"uuidInsert",uuid:e,value:t}}function H(e,t){var n=t.direction,r=t.uuid,a=m(e,r)
if(!a)return e
var i=y(e,a.path)
if(!i||"array"!==i.field.type||void 0===i.index)return e
var l=i.field,o=i.index,c=i.path,s=l.name
return Object.assign(Object.assign({},e),{model:S(e.model,c,function(t){if(!(t&&s in t))return t
var r=t[s]
if(!Array.isArray(r))return t
var a=o+("up"===n?-1:1),i=_toConsumableArray(r),l=i.splice(o,1)
i.splice.apply(i,[a,0].concat(_toConsumableArray(l)))
var c=Object.assign(Object.assign({},t),_defineProperty({},s,i))
return D(e,c),c})})}function B(e,t){return{direction:t,type:"uuidOrder",uuid:e}}function z(e,t){var n=t.uuid,r=m(e,n)
if(!r)return e
var a=y(e,r.path)
if(!a||"array"!==a.field.type||void 0===a.index)return e
var i=a.field,l=a.index,o=a.path,c=i.name
return Object.assign(Object.assign({},e),{model:S(e.model,o,function(t){if(!(t&&c in t))return t
var n=t[c]
if(!Array.isArray(n))return t
var r=_toConsumableArray(n)
r.splice(l,1)
var a=Object.assign(Object.assign({},t),_defineProperty({},c,r))
return D(e,a),a})})}function q(e){return{type:"uuidRemove",uuid:e}}function X(e,t){var n=m(e,t.uuid)
return n?Object.assign(Object.assign({},e),{model:S(e.model,n.path,function(e){return e?Object.assign(Object.assign({},e),{__visible:!e.__visible}):e})}):e}function G(e){return{type:"uuidVisibility",uuid:e}}function Y(e,t){var n=t.path,r=t.key,a=t.value
return Object.assign(Object.assign({},e),{model:S(e.model,n,function(t){var n=r?Object.assign(Object.assign({},t),_defineProperty({},r,a)):a
return D(e,n),n})})}function J(e,t,n){return{path:e,key:t,type:"updateValue",value:n}}function K(e,t){var n=t.sync,r=e.overlay
return r&&"synchronize"===r.type&&(r=Object.assign(Object.assign({},r),{preventClose:"working"===n.status})),Object.assign(Object.assign({},e),{overlay:r,sync:n})}function Q(e){return{sync:e,type:"updateSync"}}function Z(e,t){var n={}
for(var r in e)Object.prototype.hasOwnProperty.call(e,r)&&t.indexOf(r)<0&&(n[r]=e[r])
if(null!=e&&"function"==typeof Object.getOwnPropertySymbols)for(var a=0,r=Object.getOwnPropertySymbols(e);a<r.length;a++)t.indexOf(r[a])<0&&Object.prototype.propertyIsEnumerable.call(e,r[a])&&(n[r[a]]=e[r[a]])
return n}function ee(e,t,n,r){var a,i=arguments.length,l=i<3?t:null===r?r=Object.getOwnPropertyDescriptor(t,n):r
if("object"===("undefined"==typeof Reflect?"undefined":_typeof(Reflect))&&"function"==typeof Reflect.decorate)l=Reflect.decorate(e,t,n,r)
else for(var o=e.length-1;o>=0;o--)(a=e[o])&&(l=(i<3?a(l):i>3?a(t,n,l):a(t,n))||l)
return i>3&&l&&Object.defineProperty(t,n,l),l}function te(e,t,n,r){function a(e){return e instanceof n?e:new n(function(t){t(e)})}return new(n||(n=Promise))(function(n,i){function l(e){try{c(r.next(e))}catch(e){i(e)}}function o(e){try{c(r.throw(e))}catch(e){i(e)}}function c(e){e.done?n(e.value):a(e.value).then(l,o)}c((r=r.apply(e,t||[])).next())})}function ne(e){var t=e.source,n=Z(e,["source"])
return te(this,void 0,void 0,regeneratorRuntime.mark(function e(){var r,a,i,l,o,c,s
return regeneratorRuntime.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:if(r=n.schemas[t.__type]){e.next=3
break}throw new Error("Invalid source schema.")
case 3:a={__errors:{},__originalUuid:t.__uuid,__type:r.qualifier,__uuid:C(),__visible:t.__visible},i=0,l=Object.keys(r.fields)
case 5:if(!(i<l.length)){e.next=15
break}return o=l[i],c=r.fields[o],s=Fn.getDefinition(c),e.next=11,s.cloneValue(Object.assign(Object.assign({},n),{field:c,value:t[o]}))
case 11:a[o]=e.sent
case 12:i++,e.next=5
break
case 15:return e.abrupt("return",a)
case 16:case"end":return e.stop()}},e)}))}function re(e){return"object"===_typeof(e)&&"object"===_typeof(e.data)&&!0===e.result&&Array.isArray(e.references)}function ae(e){var t=e.apiEndpoint,n=Z(e,["apiEndpoint"]),r=Object.keys(n).map(function(e){return"".concat(e,"=").concat(encodeURIComponent(n[e]))}).join("&")
return new Promise(function(e,n){fetch("".concat(t,"&").concat(r)).then(function(e){return e.json()}).then(function(t){re(t)?e(t):n(t&&t.message?"".concat(t.message):"An unknown error has occured.")}).catch(function(e){n("".concat(e))})})}function ie(e){return d(e)?"[".concat(e.__type,", ").concat(e.__uuid,"]"):"[no model]"}function le(e){return e&&e.verbose?Dn:Wn}function oe(e){if(!Array.isArray(e))return[]
var t,n=[],r=_createForOfIteratorHelper(e)
try{for(r.s();!(t=r.n()).done;){var a=t.value
d(a)&&n.push(a)}}catch(e){r.e(e)}finally{r.f()}return n}function ce(e,t){var n=null!==e.__originalUuid,r=null!==t.__originalUuid
return e.__uuid===t.__uuid||r&&e.__uuid===t.__originalUuid||n&&e.__originalUuid===t.__uuid||n&&r&&e.__originalUuid===t.__originalUuid}function se(e){var t=e.field,n=e.source,r=e.target,a=Z(e,["field","source","target"])
return te(this,void 0,void 0,regeneratorRuntime.mark(function e(){var i,l,o,c,s,u,d,f,m,p
return regeneratorRuntime.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:if("instance"===t.member.type){e.next=2
break}return e.abrupt("return",n||[])
case 2:i=oe(n),l=oe(r),o=le(a),c=[],s=_createForOfIteratorHelper(i),e.prev=7,d=regeneratorRuntime.mark(function e(){var t,n,r,i
return regeneratorRuntime.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:if(t=u.value,n=l.findIndex(function(e){return ce(e,t)}),r=void 0,-1!==n){e.next=10
break}return o.info("No array match for ".concat(o.model(t))),e.next=7,ne(Object.assign(Object.assign({},a),{source:t}))
case 7:r=e.sent,e.next=16
break
case 10:return i=l[n],o.info("Array match for ".concat(o.model(t)," is ").concat(o.model(i))),l.splice(n,1),e.next=15,ue(Object.assign(Object.assign({},a),{source:t,target:i}))
case 15:r=e.sent
case 16:r&&c.push(r)
case 17:case"end":return e.stop()}},e)}),s.s()
case 10:if((u=s.n()).done){e.next=14
break}return e.delegateYield(d(),"t0",12)
case 12:e.next=10
break
case 14:e.next=19
break
case 16:e.prev=16,e.t1=e.catch(7),s.e(e.t1)
case 19:return e.prev=19,s.f(),e.finish(19)
case 22:if("remove"!==a.arrayOrphanMode){f=_createForOfIteratorHelper(l)
try{for(f.s();!(m=f.n()).done;)p=m.value,"hide"===a.arrayOrphanMode?c.push(Object.assign(Object.assign({},p),{__visible:!1})):c.push(p)}catch(e){f.e(e)}finally{f.f()}}return e.abrupt("return",c)
case 24:case"end":return e.stop()}},e,null,[[7,16,19,22]])}))}function ue(e){var t=e.source,n=e.target,r=Z(e,["source","target"])
return te(this,void 0,void 0,regeneratorRuntime.mark(function e(){var a,i,l,o,c,s,u
return regeneratorRuntime.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:if(a=le(r),d(t)){e.next=4
break}return a.info("No source, skipping ".concat(a.model(n))),e.abrupt("return",n)
case 4:if(d(n)&&n.__type===t.__type){e.next=7
break}return n?a.info("Type missmatch, cloning ".concat(a.model(t))):a.info("No target, cloning ".concat(a.model(t))),e.abrupt("return",ne(Object.assign(Object.assign({},r),{source:t})))
case 7:if(i=r.schemas[t.__type]){e.next=10
break}throw new Error("Invalid schema")
case 10:l=Object.assign({},n),a.group("Syncing model ".concat(a.model(t)," > ").concat(a.model(n))),o=0,c=Object.keys(i.fields)
case 13:if(!(o<c.length)){e.next=33
break}if(s=c[o],"array"!==(u=i.fields[s]).type){e.next=24
break}return a.group("Array ".concat(s)),e.next=20,se(Object.assign(Object.assign({},r),{field:u,source:t[s],target:n[s]}))
case 20:l[s]=e.sent,a.groupEnd(),e.next=30
break
case 24:if("instance"!==u.type){e.next=30
break}return a.group("Instance ".concat(s)),e.next=28,ue(Object.assign(Object.assign({},r),{source:t[s],target:n[s]}))
case 28:l[s]=e.sent,a.groupEnd()
case 30:o++,e.next=13
break
case 33:return a.groupEnd(),e.abrupt("return",l)
case 35:case"end":return e.stop()}},e)}))}function de(e,t,n){var r=e.siteId,a=Z(e,["siteId"])
return te(this,void 0,void 0,regeneratorRuntime.mark(function e(){var i,l,o,c,s,u,f,m,p
return regeneratorRuntime.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:if(t(Q({status:"working"})),i=n(),l=i.config,o=i.model,c=i.schemas,"number"==typeof l.elementId){e.next=4
break}throw new Error("Entry must be saved before it can be synchronized.")
case 4:return e.next=6,ae({apiEndpoint:l.apiEndpoints.fetchSite,elementId:l.elementId,fieldHandle:l.fieldHandle,siteId:r})
case 6:if(s=e.sent,u=s.data,f=s.references,d(u)&&l.rootSchemas.some(function(e){return e===u.__type})){e.next=11
break}throw new Error("Selected target site does not contain a valid model.")
case 11:if(!(m=!d(o)||o.__type!==u.__type)){e.next=18
break}return e.next=15,ne(Object.assign(Object.assign({},a),{schemas:c,source:u}))
case 15:e.t0=e.sent,e.next=21
break
case 18:return e.next=20,ue(Object.assign(Object.assign({},a),{schemas:c,source:u,target:o}))
case 20:e.t0=e.sent
case 21:p=e.t0,t(_(f)),t(J([],void 0,p)),t(Q({status:"finished"}))
case 25:case"end":return e.stop()}},e)}))}function fe(e){var t=this
return function(n,r){return te(t,void 0,void 0,regeneratorRuntime.mark(function t(){return regeneratorRuntime.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:return t.prev=0,t.next=3,de(e,n,r)
case 3:t.next=8
break
case 5:t.prev=5,t.t0=t.catch(0),n(Q({status:"error",message:"".concat(t.t0)}))
case 8:case"end":return t.stop()}},t,null,[[0,5]])}))}}function me(e,t){return function(n,r){var a=r().user.favoriteSchemas,i=e in a?a[e]:[]
i=-1===i.indexOf(t)?[].concat(_toConsumableArray(i),[t]):i.filter(function(e){return e!==t}),n(F({favoriteSchemas:Object.assign(Object.assign({},a),_defineProperty({},e,i))}))}}function pe(e){var t=e.location.uuid,n=e.owner
return n&&"array"===n.field.type?{group:Ln.Manipulation,icon:"material:add",id:"create",invoke:function(e){e(P({afterCreate:arguments.length>1&&void 0!==arguments[1]&&arguments[1]?"layer":"expand",type:"create",uuid:t}))},label:g("Create")}:null}function he(e){e.owner
return null}function ve(e){var t=e.owner,n=e.location.uuid
return t&&"array"===t.field.type?{group:Ln.Manipulation,icon:"material:delete",id:"delete",invoke:function(e){e(q(n))},label:g("Delete")}:null}function ye(e){var t=e.location.uuid
return{group:Ln.Manipulation,icon:"material:edit",id:"edit",invoke:function(e){e(P({type:"edit",uuid:t}))},label:g("Edit")}}function ge(e){var t=e.location.uuid,n=e.owner
if(!n||"array"!==n.field.type)return null
var r=n.owner[n.field.name]
return!Array.isArray(r)||void 0===n.index||n.index>=r.length-1?null:{group:Ln.Movement,icon:"material:arrow_downward",id:"moveDown",invoke:function(e){return e(B(t,"down"))},label:g("Move down")}}function be(e){var t=e.location.uuid,n=e.owner
if(!n||"array"!==n.field.type)return null
var r=n.owner[n.field.name]
return!Array.isArray(r)||void 0===n.index||n.index<=0?null:{group:Ln.Movement,icon:"material:arrow_upward",id:"moveUp",invoke:function(e){return e(B(t,"up"))},label:g("Move up")}}function Ee(e){e.owner
return null}function _e(e){var t=e.location,n=t.uuid,r=t.model.__visible
return{group:Ln.Visibility,icon:r?"material:visibility_off":"material:visibility",id:"visibility",invoke:function(e){e(G(n))},label:g(r?"Hide":"Show")}}function Ce(e,t){var n=m(e,t),r=[]
if(!n)return r
var a={location:n,owner:y(e,n.path),state:e}
return Hn.map(function(e){return e(a)}).filter(function(e){return null!==e})}function we(e,t){var n=t.uuid,r=null
return{getCommands:function(){return Ce(e.getState(),n).map(function(t){return Object.assign(Object.assign({},t),{invoke:function(){return t.invoke(e.dispatch,!0)}})})},subscribe:function(t){r&&r(),r=e.subscribe(t)},unsubscribe:function(){r&&r(),r=null}}}function ke(e){zn=e}function Se(){return zn}function Oe(){return qn||(qn=new Promise(function(e){window.onGoogleMapsReady=function(){$n=Bn.Loaded,e(google.maps)}
var t=document.createElement("script")
t.src="https://maps.googleapis.com/maps/api/js?key=".concat(zn,"&libraries=places&callback=onGoogleMapsReady"),(document.head||document.body).appendChild(t),qn=qn,$n=Bn.Loading}))}function xe(e){return e&&"object"===_typeof(e)&&"__uuid"in e}function Ne(e){switch(_typeof(e)){case"boolean":return new Boolean(e)
case"number":return new Number(e)
case"object":return e
default:return new String(e)}}function Ie(e,t){if(xe(e))return e
var n=Ne(e)
return Object.defineProperty(n,"__uuid",{value:t&&xe(t)?t.__uuid:C()}),n}function je(e,t,n){var r=t[e.__type].fields
n&&n.uniqueUuids&&(-1===n.uniqueUuids.indexOf(e.__uuid)?n.uniqueUuids.push(e.__uuid):(console.error('Found duplicate uuid "'.concat(e.__uuid,'".')),e.__uuid=C()))
for(var a=0,i=Object.keys(r);a<i.length;a++)!function(){var l=i[a],o=r[l]
"array"===o.type?e[l]=e[l].map(function(e){return"instance"===o.member.type?je(e,t,n):Ie(e)}):"instance"===o.type&&(e[l]=je(e[l],t,n))}()
return e}function Ae(e){return"string"==typeof e&&""!==e.trim()?Pn.compile(e):null}function Me(e){return Object.keys(e).reduce(function(t,n){return Array.isArray(e[n])?Object.assign(Object.assign({},t),_defineProperty({},n,e[n])):t},{})}function Te(){try{var e=window.localStorage.getItem(Un)
if(null===e)throw new Error("User state missing")
var t=JSON.parse(e).favoriteSchemas
return{favoriteSchemas:Me(void 0===t?{}:t)}}catch(e){}return{favoriteSchemas:{}}}function Re(e,t){var n=JSON.parse(e.innerHTML)
n.user=Te(),n.sync={status:"idle"},n.config.references=n.config.references.map(function(e){var t=l(e.element)
return Object.assign(Object.assign({},e),{$element:t,hasThumb:t.hasClass("hasthumb")})})
for(var r=0,a=Object.keys(n.schemas);r<a.length;r++){var i=a[r],o=n.schemas[i]
o.previewTemplate=Ae(o.preview),o.previewLabelTemplate=Ae(o.previewLabel)||o.previewTemplate}ke(n.config.googleMapsApiKey)
var c=void 0
1===n.config.rootSchemas.length&&(c=n.schemas[n.config.rootSchemas[0]])
try{n.model=je(JSON.parse(t.value),n.schemas,{uniqueUuids:[]})}catch(e){}return!c||d(n.model)&&n.model.__type===c.qualifier||(n.model=w({oldModel:n.model,schema:c,schemas:n.schemas})),n}function Pe(){throw new Error("Dynamic requires are not currently supported by @rollup/plugin-commonjs")}function Le(e){var n=e.children,r=e.className,a=e.outline,i=e.secondary,l=Z(e,["children","className","outline","secondary"])
return t.createElement("div",Object.assign({},l,{className:Xn("tcfButtonFlat",r,{outline:a,secondary:i})}),n)}function Fe(e){var n=e.children,r=_slicedToArray(t.useState([]),2),a=r[0],i=r[1],l=function(e){return-1!==a.indexOf(e)},o=function(e,t){var n=_toConsumableArray(a)
void 0===t&&(t=-1===a.indexOf(e)),t?n.push(e):n=n.filter(function(t){return t!==e}),i(n)}
return t.createElement(Gn.Provider,{value:{expanded:a,isExpanded:l,toggleExpanded:o}},n)}function Ue(e){var n=e.children,r=e.disabled,a=e.onClick,i=e.primary,l=e.secondary
return t.createElement("div",{className:Xn("tcfButton btn",{disabled:r,submit:i,secondary:l}),onClick:function(e){e.preventDefault(),r||a(e)}},n)}function De(e){var n=e.className,r=e.params,a=e.value
return t.createElement("span",{className:n},g(a,r))}function We(e){var n=e.children,r=e.className
return t.createElement("div",{className:Xn("tcfWindow--content",r)},n)}function Ve(e){var n=e.children,r=e.className,a=e.flex,i=void 0===a||a
return t.createElement("div",{className:Xn("tcfWindow--footer",r,{flex:i})},n)}function He(e){var n=e.children,r=e.className,a=e.width
return t.createElement("div",{className:Xn("tcfWindow",r),style:{width:a}},n)}function Be(e){var n=e.onClose
return t.createElement(Jn,{width:600},t.createElement(Jn.Content,null,t.createElement(De,{value:"Cannot create an element at the given location."})),t.createElement(Jn.Footer,null,t.createElement(Ue,{onClick:n,secondary:!0},t.createElement(De,{value:"Cancel"}))))}function ze(e){var n=e.children,r=e.isBorderless,a=e.label,i=e.style
return a&&""!==a&&a!==Kn?t.createElement("div",{className:"tcfFieldGroup",style:i},t.createElement("div",{className:"tcfFieldGroup--label"},a),t.createElement("div",{className:"tcfFieldGroup--content"},n)):t.createElement("div",{className:Xn("tcfFieldGroup--content",{isBorderless:r}),style:i},n)}function qe(e){var n=e.children,r=e.className,a=e.errors,i=e.instructions,l=e.isPlainField,o=e.isRequired,c=e.label,s=e.style
if(l)return t.createElement(t.Fragment,null,n)
var u=a&&a.length
return t.createElement("div",{className:Xn("tcfFieldPanel",r),style:s},t.createElement("div",{className:Xn("tcfFieldPanel--label",{hasErrors:u,isRequired:o})},c),i?t.createElement("div",{className:"tcfFieldPanel--instructions"},i):null,a&&a.length?t.createElement("ul",{className:"tcfFieldPanel--errors"},a.map(function(e,n){return t.createElement("li",{className:"tcfFieldPanel--error",key:n},e)})):null,n)}function $e(e,t){return e.label.localeCompare(t.label)}function Xe(e){function n(e){var t=e.target.selectedIndex,n=null
u&&(t-=1),t>=0&&t<l.length&&(n=l[t].key),(null!==n||r)&&c(n)}var r=e.allowUndecided,a=e.disabled,i=void 0!==a&&a,l=e.options,o=e.value,c=e.onChange,s=l.findIndex(function(e){return e.key==o}),u=r||-1===s
return t.createElement("div",{className:"tcfSelect"},t.createElement("select",{className:"tcfSelect--select",disabled:i,value:-1==s?void 0:s,onChange:i?void 0:n},u?t.createElement("option",null,"(None)"):null,l.map(function(e,n){return t.createElement("option",{key:n,value:n},e.indent?"--".repeat(e.indent)+" ":null,e.label)})))}function Ge(e){var n=e.Factory,r=e.field,a=e.onCreate,i=e.scope,l=_slicedToArray(t.useState("before"),2),o=l[0],c=l[1]
return t.createElement(Jn,{width:600},t.createElement(Jn.Content,null,t.createElement(ze,null,t.createElement(qe,{instructions:g("Select where the new element should be inserted."),label:g("Position")},t.createElement(Xe,{onChange:c,options:Qn.map(function(e){return Object.assign(Object.assign({},e),{label:g(e.label)})}),value:o})))),t.createElement(Jn.Footer,{flex:!1},t.createElement(n,{field:r,onCreate:function(e){return a(e,o)},scope:i})))}function Ye(e){function n(){c(P(null))}function r(e,t){var n=null
d(e)&&("expand"===l?s.toggleExpanded(e.__uuid,!0):n={type:"edit",uuid:e.__uuid}),c(V(o,e,t)),c(P(n))}var a=e.afterCreate,l=void 0===a?"expand":a,o=e.uuid,c=i.useDispatch(),s=t.useContext(Gn),u=i.useSelector(function(e){var t=m(e,o)
if(!t||!t.path.length)return null
var n=y(e,t.path)
return n&&"array"===n.field.type&&void 0!==n.index?{field:n.field,model:n.owner}:null})
if(null===u)return t.createElement(Be,{onClose:n})
var f=u.field,p=u.model,h=Fn.getDefinition(f.member.type).factory
return t.createElement(Ge,{Factory:h,field:f.member,onCreate:r,scope:p.__type})}function Je(e){var n=e.field,r=Fn.getDefinition(n).widget
return t.createElement(r,e)}function Ke(e){var n=e.children,r=Z(e,["children"]),a=_slicedToArray(t.useState(Yn.Large),2),i=a[0],l=a[1],o=t.useRef(null)
return t.useEffect(function(){var e=window.ResizeObserver,t=o.current,n=-1,r=0
if(t){var a=function(){var e=t.offsetWidth
e!==r&&l((r=e)>920?Yn.Large:r>580?Yn.Medium:Yn.Small)}
if(e){var i=new e(a)
return i.observe(t),function(){return i.unobserve(t)}}return function e(){n=window.requestAnimationFrame(e),a()}(),function(){return window.cancelAnimationFrame(n)}}},[]),t.createElement("div",Object.assign({ref:o},r),t.createElement(Zn.Provider,{value:i},n))}function Qe(e,t){if(t)switch(e){case Yn.Small:return t.small
case Yn.Large:return t.large
default:return t.medium}}function Ze(e,t){return e.index-t.index}function et(e){var n=e.disabled,r=void 0!==n&&n,a=e.isBorderless,i=e.model,l=e.onUpdate,o=e.path,c=e.schema,s=t.useContext(Zn)
if(!c)return t.createElement("div",null,'Could not resolve schema for "'.concat(i.__type,'"'))
var u=[],d=Object.keys(c.fields),f=void 0
if(0===d.length)return t.createElement("div",{className:"tcfInstanceForm--empty"},t.createElement(De,{value:"This element has no properties."}))
for(var m=0,p=d;m<p.length;m++)!function(){var e=p[m],n=c.fields[e],d=i.__errors[e]||null,h=Fn.getDefinition(n).isAlwaysPlainField
if(!f||n.group){var v=n.group?n.group.label:void 0,y=n.group?Qe(s,n.group.style):void 0
f={index:v===Kn?-1:u.length,label:v,fields:[],style:y},u.push(f)}f.fields.push(t.createElement(qe,{errors:d,instructions:n.instructions,isPlainField:a||h,isRequired:n.isRequired,key:n.name,label:n.label,style:Qe(s,n.style)},t.createElement(Je,{data:i[n.name],disabled:r,errors:d,field:n,model:i,onUpdate:function(t){return l(e,t)},path:o})))}()
var h=u.sort(Ze).map(function(e){return t.createElement(ze,{isBorderless:a,key:e.index,label:e.label,style:e.style},e.fields)}),v=Qe(s,c.style)
return v?t.createElement("div",{className:"tcfInstanceForm",style:v},h):t.createElement(t.Fragment,null,h)}function tt(e){var n=e.className,r=e.name,a=e.size,i="craft"
return r.startsWith(ar)?(i="material",r=r.substr(ar.length)):r.startsWith(rr)&&(r=r.substr(rr.length)),t.createElement("div",{className:Xn("tcfIcon",n,i,a)},r)}function nt(e){var n=e.message,r=e.onClose
return t.createElement(t.Fragment,null,t.createElement(Jn.Content,null,t.createElement("div",{className:"tcfSynchronize--message"},t.createElement(tt,{className:"tcfSynchronize--messageIcon error",name:"material:error",size:"huge"}),t.createElement("div",{className:"tcfSynchronize--title"},"An error has occured"),n?t.createElement("div",{className:"tcfSynchronize--message"},n):null)),t.createElement(Jn.Footer,null,t.createElement(Ue,{onClick:r},"Close")))}function rt(e){var n=e.onClose
return t.createElement(t.Fragment,null,t.createElement(Jn.Content,null,t.createElement("div",{className:"tcfSynchronize--message"},t.createElement(tt,{className:"tcfSynchronize--messageIcon finished",name:"material:check_circle",size:"huge"}),t.createElement("div",{className:"tcfSynchronize--title"},t.createElement(De,{value:"Sites have been synchronized"})),t.createElement("div",{className:"tcfSynchronize--message"},t.createElement(De,{value:"If you are not happy with the results, do not save the entry. Reload this page to revert all changes."})))),t.createElement(Jn.Footer,null,t.createElement(Ue,{onClick:n},t.createElement(De,{value:"Close"}))))}function at(){return[{key:"hide",label:g("Hide orphaned elements")},{key:"none",label:g("Do nothing")},{key:"remove",label:g("Remove orphaned elements")}]}function it(){return t.createElement("div",{className:"tcfActivityIndicator"},t.createElement("div",{className:"tcfActivityIndicator--bounce first"}),t.createElement("div",{className:"tcfActivityIndicator--bounce second"}),t.createElement("div",{className:"tcfActivityIndicator--bounce third"}))}function lt(){return t.createElement(Jn.Content,null,t.createElement("div",{className:"tcfSynchronize--working"},t.createElement(it,null)))}function ot(){var e,n=i.useSelector(function(e){return e.sync}),r=i.useDispatch(),a=function(){return r(P(null))}
return e="working"===n.status?t.createElement(lt,null):"error"===n.status?t.createElement(nt,{message:n.message,onClose:a}):"finished"===n.status?t.createElement(rt,{onClose:a}):t.createElement(or,{onClose:a}),t.createElement(Jn,{width:600},e)}function ct(e){if(!e)return null
switch(e.type){case"create":return t.createElement(Ye,Object.assign({},e))
case"edit":return t.createElement(nr,Object.assign({},e))
case"synchronize":return t.createElement(ot,null)}}function st(e){var n=e.children,r=t.useContext(cr)
return t.createElement(cr.Provider,{value:r+1},n)}function ut(e){var n=e.disabled,r=e.dispatch,a=e.model,i=e.path,l=e.schemas.map(function(e){return{key:e.qualifier,label:e.label}})
return l.sort($e),t.createElement(qe,{className:"tcfInstance--controlsSchema",label:"Type"},t.createElement(Xe,{disabled:n,onChange:function(e){return r(x(i,e))},options:l,value:a?a.__type:null}))}function dt(e){var n=e.disabled,r=e.dispatch,a=e.model,i=a.__visible?"material:visibility":"material:visibility_off",l=t.createElement(t.Fragment,null,t.createElement(De,{value:"Visibility"}),t.createElement(tt,{className:Xn("tcfInstance--controlsVisibilityIcon",{off:!a.__visible}),name:i}))
return t.createElement(qe,{label:l,className:"tcfInstance--controlsVisibility"},t.createElement(Ue,{disabled:n,onClick:function(){return r(G(a.__uuid))}},t.createElement(De,{value:a.__visible?"Hide":"Show"})))}function ft(){var e=i.useDispatch(),n=i.useSelector(function(e){return e.model}),r=i.useSelector(function(e){return e.overlay}),a=i.useSelector(function(e){return e.config}),l=a.disabled,o=a.rootSchemas,u=a.supportedSites.length>1,d=function(){r&&!r.preventClose&&e(P(null))},f=function(){e(Q({status:"idle"})),e(P({type:"synchronize"}))}
return t.createElement(s.DndProvider,{backend:c},t.createElement(Fe,null,u&&!l?t.createElement("div",{className:"tcfRoot--options"},t.createElement(Le,{onClick:f,outline:!0},t.createElement(tt,{name:"material:sync"}),t.createElement(De,{value:"Synchronize translations"}))):null,t.createElement(sr,{disabled:l,model:n,path:[],schemaNames:o}),r?t.createElement(ur,{onClick:d},ct(r)):null))}function mt(){return{config:{apiEndpoints:{fetchSite:"",oembed:"",translate:""},disabled:!1,elementId:null,elementSiteId:0,fieldHandle:"",hasTranslator:!1,references:[],rootSchemas:[],supportedSites:[]},model:{__errors:{},__type:"unknown",__uuid:"0",__visible:!0},overlay:null,schemas:{},sync:{status:"idle"},user:{favoriteSchemas:{}}}}function pt(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:mt(),t=arguments.length>1?arguments[1]:void 0
return t.type in Vn?Vn[t.type](e,t):e}function ht(e){for(;"string"!=typeof e;)e=e.toHTML()
return e}function vt(){return{allowedProtoMethods:dr,allowedProtoProperties:fr}}function yt(e){var t=e.context,n=e.field,r=e.value
if(!n)return[]
var a=n.member,i=Fn.getDefinition(a)
return r.map(function(e){return i.preview({value:e,field:a,context:t})})}function gt(e,t){var n={data:e.child,height:100,path:e.path,type:"MEMBER"}
return s.useDrag({item:n,begin:function(){return{data:e.child,height:t.current?t.current.clientHeight:100,path:e.path,type:"MEMBER"}},canDrag:function(){return!e.disabled},collect:function(e){return{isDragging:e.isDragging()}},isDragging:function(t){return j(e.path,t.getItem().path)}})}function bt(e,t,n){var r=n.current,a=t.getClientOffset()
if(!r||!a||!e)return null
var i=r.getBoundingClientRect(),l=i.bottom,o=i.top,c=a.y-o
return r.classList.contains("isExpanded")&&c>32&&c<l-o-32?null:(c>(l-o)/2&&(e.targetSegment=Object.assign(Object.assign({},e.targetSegment),{index:e.targetSegment.index+1})),e)}function Et(e,t){var n=e.path.slice(),r=n.pop()
if(!r||"index"!==r.type)return null
var a=t.path.slice(),i=a.pop()
return i&&"index"===i.type?{sourcePath:a,sourceSegment:i,targetPath:n,targetSegment:r}:null}function _t(e,t){var n=i.useStore()
return s.useDrop({accept:"MEMBER",drop:function(e){return{item:e}},hover:function(r,a){if(a.isOver({shallow:!0})){var i=bt(Et(e,r),a,t)
if(i&&A(n.getState(),i)){var l=T(i),o=I(l),c=o.targetPath,s=o.targetSegment
r.path=[].concat(_toConsumableArray(c),[s]),n.dispatch(l)}}}})}function Ct(e){var n=e.child,r=e.depth,a=e.disabled,i=e.field,l=e.index,o=e.model,c=e.onDelete,s=e.onUpdate,u=e.path,d=t.useRef(null),f=_slicedToArray(gt(e,d),3),m=f[0].isDragging,p=f[1],h=f[2];(0,_slicedToArray(_t(e,d),2)[1])(d)
var v=function(){c(l)},y=function(e){s(l,e)}
return t.createElement("div",{className:Xn("tcfArrayWidgetMember depth-".concat(r),{isDragging:m}),ref:d},h(t.createElement("div",{className:"tcfArrayWidgetMember--panel tcfArrayWidgetMember--single"},p(t.createElement("div",{className:Xn("tcfArrayWidgetMember--singleHandle",{enabled:!a})},t.createElement(tt,{className:"tcfArrayWidgetMember--singleHandleIcon",key:"handle",name:"move"}))),t.createElement("div",{className:"tcfArrayWidgetMember--singleBody"},t.createElement(Je,{data:n,disabled:a,errors:[],field:i,model:o,onUpdate:y,path:u})),a?null:t.createElement("div",{className:"tcfArrayWidgetMember--singleActions"},t.createElement("div",{className:"tcfArrayWidgetMember--singleActionsButton",onClick:v},t.createElement(tt,{name:"remove"}))))))}function wt(e,t){var n=t.path.slice(),r=n.pop()
return r&&"index"===r.type?{sourcePath:n,sourceSegment:r,targetPath:e.path,targetSegment:{type:"index",index:0,name:e.field.name}}:null}function kt(e){var t=i.useStore()
return s.useDrop({accept:"MEMBER",drop:function(e){return{item:e}},hover:function(n,r){if(r.isOver({shallow:!0})){var a=wt(e,n)
if(a&&A(t.getState(),a)){var i=T(a),l=I(i),o=l.targetPath,c=l.targetSegment
n.path=[].concat(_toConsumableArray(o),[c]),t.dispatch(i)}}}})}function St(e){var n=t.useRef(null)
return(0,_slicedToArray(kt(e),2)[1])(n),t.createElement("div",{className:"tcfArrayWidgetList--empty",key:"empty",ref:n},t.createElement(De,{value:"Drop elements here"}))}function Ot(e){var n=e.children,r=e.onClick,a=e.primary
return t.createElement("div",{className:Xn("tcfArrayWidgetMember--headerActionsButton",{primary:a}),onClick:function(e){e.preventDefault(),r()}},n)}function xt(){return null===yr&&(yr=new Craft.ElementThumbLoader),yr}function Nt(e,t){var n=t.previewImage
if(!n)return null
var r=n in e?e[n]:null
if(!Array.isArray(r)||0===r.length)return null
var a=r[0]
return"number"==typeof a?a:null}function It(e){var n=e.className,r=e.model,a=e.schema,l=e.size,o=void 0===l?"small":l,c=t.useRef(null),s=i.useSelector(function(e){return e.config.references}),u=Nt(r,a),d=s.find(function(e){return e.id===u})
return t.useEffect(function(){if(c.current){var e=$(".element",c.current)
Craft.setElementSize(e,o),xt().load(e)}},[c.current,d]),d&&d.hasThumb?t.createElement("div",{className:Xn("tcfInstancePreviewImage",n,o),dangerouslySetInnerHTML:{__html:d.element},ref:c}):t.createElement("div",{className:Xn("tcfInstancePreviewImage empty",n,o)})}function jt(e){var n=_slicedToArray(i.useSelector(function(e){return[e.config.references,e.schemas]}),2),r=n[0],a=n[1]
return t.createElement(gr,Object.assign({},e,{references:r,schemas:a}))}function At(e){var n=e.command,r=e.onClick
return t.createElement("div",{className:"tcfArrayWidgetMember--headerMoreItem",onMouseUp:r},t.createElement(tt,{className:"tcfArrayWidgetMember--headerMoreItemIcon",name:n.icon}),t.createElement("span",{className:"tcfArrayWidgetMember--headerMoreItemLabel"},n.label))}function Mt(e){var n,r,a=e.commands,i=e.dispatch,l=e.onClose,o=[],c=_createForOfIteratorHelper(a)
try{for(c.s();!(r=c.n()).done;){(function(){var e=r.value
if("edit"===e.id)return"continue"
void 0!==n&&n!==e.group&&o.push(t.createElement("div",{className:"tcfArrayWidgetMember--headerMoreDivider",key:"".concat(e.id,"-divider")})),n=e.group,o.push(t.createElement(At,{command:e,key:e.id,onClick:function(){l(),e.invoke(i)}}))})()}}catch(e){c.e(e)}finally{c.f()}return t.createElement("div",{className:"tcfArrayWidgetMember--headerMoreMenu"},o)}function Tt(e){return e}function Rt(e,t){return t?e?"minus":"plus":e?"done":"edit"}function Pt(e){var n=e.disabled,r=e.dragSource,a=void 0===r?Tt:r,i=e.field,l=e.hasPreview,o=e.isCollapsible,c=e.isExpanded,s=e.model,u=e.onToggleExpanded,d=e.schema,f=[]
return d?(f.push(t.createElement(tt,{key:"icon",name:d.icon})),d.previewImage&&f.push(t.createElement(It,{key:"image",model:s,schema:d})),f.push(t.createElement("div",{className:Xn("tcfArrayWidgetMember--headerLabel",{isHidden:!s.__visible}),key:"label"},d.label)),l&&d.previewLabelTemplate&&f.push(t.createElement("div",{className:"tcfArrayWidgetMember--headerPreview",key:"preview"},t.createElement(jt,{field:i,model:s})))):f.push(t.createElement(tt,{className:"tcfArrayWidgetMember--headerHandleIcon",key:"handle",name:"move"})),t.createElement("div",{className:"tcfArrayWidgetMember--header"},a(t.createElement("div",{className:Xn("tcfArrayWidgetMember--headerHandle",{enabled:!n}),onClick:u},f)),s.__visible?null:t.createElement(tt,{className:"tcfArrayWidgetMember--headerVisibility",name:"material:visibility_off"}),t.createElement("div",{className:"tcfArrayWidgetMember--headerActions"},o?t.createElement(Ot,{onClick:u,primary:!n},t.createElement(tt,{name:Rt(c,n)})):null,n?null:t.createElement(_r,{uuid:s.__uuid})))}function Lt(e){var n=e.className,r=e.field,a=e.model,l=e.mode,o=e.onClick,c=_slicedToArray(i.useSelector(function(e){return[e.config.references,e.schemas]}),2),s=c[0],u=c[1]
return t.createElement("div",{className:Xn("tcfInstancePreview",n,{isClickable:!!o}),onClick:o},t.createElement(Cr,{field:r,model:a,mode:l,references:s,schemas:u}))}function Ft(e,t){switch(e){case"always":return!0
case"root":return 1===t}}function Ut(e){var n=t.useContext(Gn),r=n.isExpanded,a=n.toggleExpanded,i=t.useRef(null),l=_slicedToArray(gt(e,i),3),o=l[0].isDragging,c=l[1],s=l[2];(0,_slicedToArray(_t(e,i),2)[1])(i)
var u=e.child,d=e.depth,f=e.disabled,m=e.field,p=e.isCollapsible,h=e.path,v=e.previewMode,y=e.schema,g=function(){a(u.__uuid)},b=!0,E=!1
if(y){var _=Object.keys(y.fields)
b=_.length>0,E=1===_.length&&"redactor"===y.fields[_[0]].type}var C,w=y&&y.preview&&Ft(v,d),k=b&&(!p||r(u.__uuid))
return k?C=t.createElement("div",{className:"tcfArrayWidgetMember--body"},t.createElement(sr,{canChangeType:!1,disabled:f,isBorderless:E,key:"details",model:u,path:h,schemaNames:m.schemas})):w&&(C=t.createElement(Lt,{className:"tcfArrayWidgetMember--preview",field:m,key:"summary",model:u,onClick:b?g:void 0})),t.createElement("div",{className:Xn("tcfArrayWidgetMember depth-".concat(d),k?"isExpanded":"isCollapsed",{isDragging:o}),ref:i},s(t.createElement("div",{className:"tcfArrayWidgetMember--panel"},t.createElement(Pt,{disabled:f,dragSource:c,field:m,hasPreview:!k&&!w,isCollapsible:b&&p,isExpanded:k,model:u,onToggleExpanded:g,schema:y}),t.createElement(vr,{uri:k?"details":"summary"},C))))}function Dt(e){var n=e.children,r=e.data,a=e.disabled,l=e.field,o=e.model,c=e.onDelete,s=e.onUpdate,u=e.path,d=l.member,f=l.collapsible,m=l.previewMode,p=t.useRef(null),h=i.useSelector(function(e){return e.schemas}),v=t.useContext(cr),y=r.map(function(e,n){var r=[].concat(_toConsumableArray(u),[{index:n,name:d.name,type:"index"}]),i={child:e,depth:v,disabled:a,path:r}
return"instance"===d.type?t.createElement(Ut,Object.assign({},i,{isCollapsible:f,field:d,key:e.__uuid,previewMode:m,schema:h[e.__type]})):t.createElement(Ct,Object.assign({},i,{field:d,index:n,key:xe(e)?e.__uuid:n,model:o,onDelete:c,onUpdate:s}))})
return 0===y.length&&y.push(t.createElement(St,{field:l,key:"droplet",path:u})),t.createElement(t.Fragment,null,t.createElement("div",{className:"tcfArrayWidgetList",ref:p},y),t.createElement("div",{className:"tcfArrayWidgetList--footer"},n))}function Wt(e){if(!e)return e
if(Array.isArray(e))return e.map(function(e){return Wt(e)})
if("object"===_typeof(e)){var t={}
for(var n in e)t[n]=Wt(e[n])
return t}return e}function Vt(e){var n=e.field,r=e.onCreate,a=i.useSelector(function(e){return e.schemas})
return t.createElement("div",{className:"tcfFactory"},t.createElement(Le,{className:"tcfFactory--primaryButton",onClick:function(){var e=Fn.createValue({field:n,schemas:a})
r(e)},secondary:!0},t.createElement(tt,{name:"plus"}),t.createElement(De,{value:"Create"})))}function Ht(e){var n=e.data,r=e.disabled,a=e.field,i=e.onUpdate
return t.createElement(xr,{disabled:r,onChange:i,value:!!n},a.label)}function Bt(e){var t=e.red,n=e.green,r=e.blue,a=e.alpha
return{max:Math.max(t,n,r),min:Math.min(t,n,r),red:t/255,green:n/255,blue:r/255,alpha:a}}function zt(){return{alpha:1,blue:255,green:255,red:255}}function qt(e){return"object"===_typeof(e)&&"number"==typeof e.alpha&&"number"==typeof e.blue&&"number"==typeof e.green&&"number"==typeof e.red}function $t(e){e=e.replace(/^#?([a-f\d])([a-f\d])([a-f\d])$/i,function(e,t,n,r){return t+t+n+n+r+r})
var t=/^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(e)
return t?{red:parseInt(t[1],16),green:parseInt(t[2],16),blue:parseInt(t[3],16),alpha:1}:null}function Xt(e){var t=e.alpha,n=e.hue,r=e.saturation,a=e.value,i=0,l=0,o=0,c=Math.floor(6*n),s=6*n-c,u=a*(1-r),d=a*(1-s*r),f=a*(1-(1-s)*r)
switch(c%6){case 0:i=a,l=f,o=u
break
case 1:i=d,l=a,o=u
break
case 2:i=u,l=a,o=f
break
case 3:i=u,l=d,o=a
break
case 4:i=f,l=u,o=a
break
case 5:i=a,l=u,o=d}return{alpha:t,red:Math.round(255*i),green:Math.round(255*l),blue:Math.round(255*o)}}function Gt(e){return"rgba(".concat(e.red,",").concat(e.green,",").concat(e.blue,",").concat(e.alpha,")")}function Yt(e){return"#"+(16777216+(e.blue|e.green<<8|e.red<<16)).toString(16).slice(1)}function Jt(e){var t=Bt(e),n=t.alpha,r=t.blue,a=t.green,i=t.max,l=t.min,o=t.red,c=0===i?0:(i-l)/i,s=(i-l)/255,u=0,d=i/255
return i===l?{hue:u,saturation:c,value:d,alpha:n}:(u=i===e.red?(a-r)/s+(a<r?6:0):i===e.green?(r-o)/s+2:(o-a)/s+4,u/=6,{hue:u,saturation:c,value:d,alpha:n})}function Kt(e){return function(n){return t.createElement(Ir.Consumer,null,function(r){return t.createElement(e,Object.assign({},n,r))})}}function Qt(e){var n=e.className,r=Z(e,["className"])
return t.createElement("input",Object.assign({className:Xn("tcfInput",n)},r))}function Zt(e){var n=e.children,r=e.className,a=e.color,i=e.css,l=e.disabled,o=e.onClick,c=e.onRgbColor
if(a){var s=$t(a)
s&&(o=function(){c(s)})}return t.createElement("div",{className:Xn("tcfColorInputSwatch",r),onClick:l?void 0:o},t.createElement("div",{className:"tcfColorInputSwatch--color",style:{background:a||i}}),n)}function en(e){var n=e.disableAlpha,r=e.presetColors,a=[t.createElement("div",{className:"tcfColorInputPicker--value wide",key:"hex"},t.createElement(Ar,{type:"hex"}),t.createElement("div",{className:"tcfColorInputPicker--valueCaption"},"Hex")),t.createElement("div",{className:"tcfColorInputPicker--value",key:"red"},t.createElement(Ar,{type:"red"}),t.createElement("div",{className:"tcfColorInputPicker--valueCaption"},"R")),t.createElement("div",{className:"tcfColorInputPicker--value",key:"green"},t.createElement(Ar,{type:"green"}),t.createElement("div",{className:"tcfColorInputPicker--valueCaption"},"G")),t.createElement("div",{className:"tcfColorInputPicker--value",key:"blue"},t.createElement(Ar,{type:"blue"}),t.createElement("div",{className:"tcfColorInputPicker--valueCaption"},"B"))]
n||a.push(t.createElement("div",{className:"tcfColorInputPicker--value",key:"alpha"},t.createElement(Ar,{type:"alpha"}),t.createElement("div",{className:"tcfColorInputPicker--valueCaption"},"A")))
var i=null
return r&&r.length&&(i=t.createElement("div",{className:"tcfColorInputPicker--presets"},r.map(function(e){return t.createElement(Rr,{className:"tcfColorInputPicker--presetsSwatch",color:e})}))),t.createElement("div",{className:"tcfColorInputPicker"},t.createElement(Mr,null),t.createElement("div",{className:"tcfColorInputPicker--controls"},t.createElement("div",{className:"tcfColorInputPicker--sliders"},t.createElement(Tr,{type:"hue"}),n?null:t.createElement(Tr,{type:"alpha"})),t.createElement(Rr,{className:"tcfColorInputPicker--swatch"})),t.createElement("div",{className:"tcfColorInputPicker--values"},a),i)}function tn(e){var n=e.data,r=e.disabled,a=e.field,i=e.onUpdate,l=qt(n)?n:zt()
return t.createElement(Pr,{color:l,disableAlpha:!a.alpha,disabled:r,onChange:i,presetColors:a.swatches})}function nn(e,t,n){function r(){var s=Date.now()-a
s<t&&s>=0?l=window.setTimeout(r,t-s):(l=null,n||(i=e.apply(c,o),l||(c=o=null)))}var a,i,l=null,o=null,c=null
return function(){c=this,o=arguments,a=Date.now()
var s=n&&!l
return l||(l=window.setTimeout(r,t)),s&&(i=e.apply(c,o),c=o=null),i}}function rn(e){var n=e.children,r=e.className,a=e.icon
return t.createElement("div",{className:Xn("tcfTextAndIcon",r)},t.createElement(tt,{className:"tcfTextAndIcon--icon",name:a}),t.createElement(De,{className:"tcfTextAndIcon--text",value:n}))}function an(e){var n=e.children,r=e.title
return t.createElement("div",{className:"tcfErrorMessage"},t.createElement(rn,{icon:"material:error"},r),n)}function ln(e){return"object"===_typeof(e)&&"string"==typeof e.url}function on(e){var n=e.favorites,r=e.onSchema,a=e.onToggleFavorite,i=e.schemas.map(function(e){var i=-1!==n.indexOf(e.qualifier)
return t.createElement("div",{className:"tcfSchemaList--row",key:e.qualifier},t.createElement("div",{className:"tcfSchemaList--schema",onMouseUp:function(){return r(e)}},t.createElement(tt,{className:"tcfSchemaList--schemaIcon",name:e.icon}),t.createElement("div",{className:"tcfSchemaList--schemaLabel"},e.label)),a?t.createElement("div",{className:"tcfSchemaList-favorite",onClick:function(){return a(e)}},t.createElement(tt,{name:i?"material:star":"material:star_border"})):null)})
return t.createElement("div",{className:"tcfSchemaList"},i)}function cn(e){var n,r=e.onCreate,a=e.schemas,l=e.scope,o=_slicedToArray(t.useState(!1),2),c=o[0],s=o[1],u=i.useDispatch(),d=[],f=null
if(l){var m=i.useSelector(function(e){return e.user}).favoriteSchemas;(d=l in m?m[l]:[]).length&&(f=a.filter(function(e){return-1!==d.indexOf(e.qualifier)}).map(function(e){return t.createElement(Le,{className:"tcfFactory--quickButton",key:e.qualifier,onClick:function(){return r(e)},secondary:!0},t.createElement(tt,{name:e.icon}),t.createElement("div",null,e.label))})),n=function(e){u(me(l,e.qualifier))}}var p=function(e){s(!1),r(e)}
return t.createElement("div",{className:"tcfFactory multiple"},t.createElement(Le,{className:"tcfFactory--primaryButton",onMouseDown:function(){return s(!0)}},t.createElement(tt,{name:"plus"}),t.createElement(De,{value:"Create"}),c?t.createElement(Er,{onClick:function(){return s(!1)}},t.createElement(on,{favorites:d,onSchema:p,onToggleFavorite:n,schemas:a})):null),f)}function sn(e){var n=e.onCreate,r=e.schema
return t.createElement("div",{className:"tcfFactory"},t.createElement(Le,{className:"tcfFactory--primaryButton",onClick:function(){return n(r)}},t.createElement(tt,{name:"plus"}),t.createElement(De,{params:{schema:r.label},value:"Create {schema}"})))}function un(e){var n=e.field,r=e.onCreate,a=e.scope,l=i.useSelector(function(e){return e.schemas}),o=n.schemas.map(function(e){return l[e]}).sort(function(e,t){return e.label.localeCompare(t.label)})
if(!o.length)return null
var c=function(e){if(-1!==o.indexOf(e))return r(w({schemas:l,schema:e}))}
return o.length>1?t.createElement(cn,{onCreate:c,schemas:o,scope:a}):t.createElement(sn,{onCreate:c,schema:o[0]})}function dn(e){var n=e.children,r=e.disabled,a=e.field,l=e.model,o=t.useContext(cr),c=i.useSelector(function(e){return e.schemas}),s=t.useContext(Gn),u=s.isExpanded,d=s.toggleExpanded,f=c[l.__type],m=u(l.__uuid),p=f&&f.preview,h=function(){return d(l.__uuid)},v=null
return m?v=t.createElement("div",{className:"tcfArrayWidgetMember--body"},n):p&&(v=t.createElement(Lt,{field:a,model:l})),t.createElement("div",{className:"tcfInstanceWidget--collapsiblePanel depth-".concat(o)},t.createElement(Pt,{disabled:r,field:a,hasPreview:!m&&!p,isCollapsible:!0,isExpanded:m,model:l,onToggleExpanded:h,schema:f}),t.createElement(vr,{uri:m?"details":"summary"},v))}function fn(e){var n=e.className,r=e.data,a=e.disabled,i=e.field,l=e.path,o=t.createElement(sr,{canChangeVisibility:!0,disabled:a,model:r,path:[].concat(_toConsumableArray(l),[{type:"property",name:i.name}]),schemaNames:i.schemas})
return i.collapsible&&d(r)?t.createElement(dn,{model:r,disabled:a,field:i},o):t.createElement("div",{className:Xn("tcfInstanceWidget",n)},o)}function mn(e){var n=e.data,r=e.disabled,a=e.onUpdate
return t.createElement(ir,{disabled:r,onChange:a,value:!!n})}function pn(e){var t=e.data,n=e.elementType,r=e.references,a=[]
if(Array.isArray(t)){var i,l=_createForOfIteratorHelper(t)
try{for(l.s();!(i=l.n()).done;)!function(){var e=i.value,t=r.find(function(t){return t.id===e&&t.type===n})
t&&a.push(t)}()}catch(e){l.e(e)}finally{l.f()}}return a}function hn(e){var n=t.useRef(null)
return t.useEffect(function(){var t=n.current
if(t){var r,a=xt(),i=_createForOfIteratorHelper(pn(e))
try{for(i.s();!(r=i.n()).done;){var l=r.value.$element.clone(!1,!0)
l.appendTo(t),Craft.setElementSize(l,e.viewMode),a.load(l)}}catch(e){i.e(e)}finally{i.f()}}},[]),t.createElement("div",{className:"elementselect"},t.createElement("div",{className:"elements",ref:n}))}function vn(e){return e.disabled?t.createElement(hn,Object.assign({},e)):t.createElement(Br,Object.assign({},e))}function yn(e){var n=e.disabled,r=e.link,a=e.linkType,i=e.onUpdate
return t.createElement("div",{className:"tcfLinkWidget--editor"},t.createElement(zr,{criteria:a.criteria,data:[r.elementId],disabled:n,elementType:a.elementType,limit:1,onUpdate:function(e){return i(Object.assign(Object.assign({},r),{elementId:e.length?e[0]:0}))},sources:a.sources,viewMode:"small"}),a.allowHash?t.createElement("div",{className:"tcfLinkWidget--editorHash tcfInput--group"},t.createElement("div",{className:"tcfInput--groupLabel"},"#"),t.createElement(Qt,{disabled:n,value:r.hash,onChange:function(e){return i(Object.assign(Object.assign({},r),{hash:e.currentTarget.value}))}})):null)}function gn(e){var n=e.disabled,r=e.link,a=e.linkType,i=e.onUpdate
return t.createElement("div",{className:"tcfLinkWidget--editor"},t.createElement(Qt,{disabled:n,type:a.inputType,value:r.url,onChange:function(e){return i(Object.assign(Object.assign({},r),{url:e.currentTarget.value}))}}))}function bn(e){return"object"===_typeof(e)&&"number"==typeof e.elementId&&"string"==typeof e.hash&&"string"==typeof e.type&&"string"==typeof e.url}function En(e){var n,r=e.data,a=e.disabled,i=e.field,l=e.onUpdate
n=bn(r)?r:{elementId:0,hash:"",openInNewWindow:!1,type:"",url:""}
var o,c=i.linkTypes[n.type]
c&&"input"===c.type?o=t.createElement(gn,{disabled:a,key:n.type,link:n,linkType:c,onUpdate:l}):c&&"element"===c.type&&(o=t.createElement(yn,{disabled:a,key:n.type,link:n,linkType:c,onUpdate:l}))
var s=i.allowNewWindow
return t.createElement("div",{className:"tcfLinkWidget"},t.createElement("div",{className:"tcfLinkWidget--type"},t.createElement(Xe,{disabled:a,options:Object.keys(i.linkTypes).map(function(e){return{key:e,label:i.linkTypes[e].label}}),value:n.type,onChange:function(e){return l(Object.assign(Object.assign({},n),{type:e}))}})),o,s?t.createElement(xr,{disabled:a,onChange:function(e){return l(Object.assign(Object.assign({},n),{openInNewWindow:e}))},value:n.openInNewWindow},t.createElement(De,{value:"New window"})):null)}function _n(e){var n=e.results,r=e.onSelect
return t.createElement("div",{className:""},n.map(function(e){return t.createElement("div",{onClick:function(){return r(e)}},e.formatted_address)}))}function Cn(e){return"object"===_typeof(e)&&"number"==typeof e.latitude&&"number"==typeof e.longitude}function wn(e,t){var n=e.dataType,r=e.defaultValue,a=e.max,i=e.min,l=e.optional,o="integer"===n?parseInt(t):parseFloat(t)
if(isFinite(o))"number"==typeof a&&o>a&&(o=a),"number"==typeof i&&o<i&&(o=i)
else{if(l)return null
o=r}return o}function kn(e){function n(){f(!1),h(i)}function r(e){var t=e.target.value
h(t),s(wn(c,t))}function a(){f(!0)}var i=e.data,l=e.disabled,o=e.errors,c=e.field,s=e.onUpdate,u=_slicedToArray(t.useState(!1),2),d=u[0],f=u[1],m=_slicedToArray(t.useState(i),2),p=m[0],h=m[1],v=c.max,y=c.min,g=c.placeholder,b=c.unit,E=d?p:i,_=t.createElement("input",{autoComplete:"off",className:Xn("tcfNumberWidget--input text fullwidth",{error:o&&o.length}),disabled:l,max:v,min:y,onBlur:n,onChange:r,onFocus:a,placeholder:g,type:"number",value:E})
return b?t.createElement("div",{className:"tcfNumberWidget"},_,t.createElement("div",{className:"tcfNumberWidget--unit"},b)):_}function Sn(e){var n=e.value
return t.createElement("div",{className:"redactor-box redactor-styles-on redactor-toolbar-on focusable-input redactor-focus focus"},t.createElement("div",{className:"redactor-styles redactor-in redactor-in-0",dangerouslySetInnerHTML:{__html:n}}))}function On(e){return e.disabled?t.createElement(Sn,Object.assign({},e)):t.createElement(ta,Object.assign({},e))}function xn(e){var n=e.data,r=e.disabled,a=e.elementSiteId,i=e.field,l=e.onUpdate
return i.redactor?t.createElement(On,{disabled:r,elementSiteId:a,onUpdate:l,options:i.redactor,value:n}):null}function Nn(e,t){return te(this,void 0,void 0,regeneratorRuntime.mark(function n(){var r,a,i,l
return regeneratorRuntime.wrap(function(n){for(;;)switch(n.prev=n.next){case 0:if(!(ra>2)){n.next=3
break}return console.warn('Translator has returned to many errors, skipping translation for text "'.concat(e,'".')),n.abrupt("return",e)
case 3:return r=t.endpoint,a=Z(t,["endpoint"]),i=Object.assign(Object.assign({},a),{text:e}),l=Object.keys(i).map(function(e){return"".concat(e,"=").concat(encodeURIComponent(i[e]))}).join("&"),n.abrupt("return",new Promise(function(t){fetch("".concat(r,"&").concat(l)).then(function(e){return e.json()}).then(function(n){t(n&&n.data?n.data:e)}).catch(function(n){console.error("Translator returned an error: ".concat(n)),ra+=1,t(e)})}))
case 7:case"end":return n.stop()}},n)}))}function In(e){var t=e.context.references,n=e.field,r=e.value,a=[]
if(!n)return a
var i,l=n.elementType,o=_createForOfIteratorHelper(r)
try{for(o.s();!(i=o.n()).done;)!function(){var e=i.value,n=t.find(function(t){return t.id===e&&t.type===l})
n&&a.push(new la(n))}()}catch(e){o.e(e)}finally{o.f()}return a}function jn(e){var n=e.data,r=e.disabled,a=e.field,i=e.model,l=e.onUpdate
return t.createElement(zr,{criteria:a.criteria,disabled:r,data:n,elementType:a.elementType,limit:a.limit,modalStorageKey:"tcf_".concat(i.__type,"_").concat(a.name),onUpdate:l,sources:a.sources,viewMode:a.viewMode})}function An(e){var n=e.data,r=e.disabled,a=e.onUpdate,i=e.field
return t.createElement(Xe,{disabled:r,onChange:a,options:i.options,value:n})}function Mn(e){var t
return e&&(t="color"in e?e.color:e.label),"string"==typeof t?t:"transparent"}function Tn(e){var n=e.data,r=e.disabled,a=e.errors,i=e.field,l=i.maxLength,o=i.minLength,c=i.placeholder,s=i.inputType,u=e.onUpdate
return t.createElement("input",{autoComplete:"off",className:Xn("tcfTextWidget text fullwidth",{error:a&&a.length}),disabled:r,maxLength:l,minLength:o,onChange:function(e){return u(e.target.value)},placeholder:c,type:s,value:n?"".concat(n):""})}function Rn(e){var n=e.data,r=e.disabled,a=e.field,i=a.maxLength,l=a.minLength,o=a.monospace,c=a.placeholder,s=a.rows,u=e.onUpdate
return t.createElement("textarea",{className:Xn("tcfTextareaWidget text fullwidth",{monospace:o}),disabled:r,maxLength:i,minLength:l,onChange:function(e){return u(e.target.value)},placeholder:c,rows:s,value:n})}r=r&&Object.prototype.hasOwnProperty.call(r,"default")?r.default:r,l=l&&Object.prototype.hasOwnProperty.call(l,"default")?l.default:l
var Pn="default"in o?o.default:o
c=c&&Object.prototype.hasOwnProperty.call(c,"default")?c.default:c
var Ln,Fn=new(function(){function e(){_classCallCheck(this,e)}return _createClass(e,[{key:"initialize",value:function(e){this.definitions=e}},{key:"createValue",value:function(e){return this.getDefinition(e.field).createValue(e)}},{key:"getDefinition",value:function(e){return this.definitions["object"===_typeof(e)?e.type:e]}}]),e}()),Un="tcfUserState",Dn={group:console.groupCollapsed,groupEnd:console.groupEnd,info:console.info,model:ie},Wn={group:function(){},groupEnd:function(){},info:function(){},model:ie},Vn={addReferences:E,changeType:O,moveModel:M,setOverlay:R,setUser:L,uuidInsert:W,uuidOrder:H,uuidRemove:z,uuidVisibility:X,updateSync:K,updateValue:Y},Hn=[pe,ye,ve,_e,be,ge,b,he,Ee]
!function(e){e[e.Manipulation=0]="Manipulation",e[e.Visibility=1]="Visibility",e[e.Movement=2]="Movement",e[e.Clipboard=3]="Clipboard"}(Ln||(Ln={}))
var Bn
!function(e){e[e.Idle=0]="Idle",e[e.Loading=1]="Loading",e[e.Loaded=2]="Loaded"}(Bn||(Bn={}))
var zn,qn=null,$n=Bn.Idle,Xn=function(e,t,n){return n={path:t,exports:{},require:function(e,t){return Pe((void 0===t||null===t)&&n.path)}},e(n,n.exports),n.exports}(function(e){!function(){function t(){for(var e=[],r=0;r<arguments.length;r++){var a=arguments[r]
if(a){var i=_typeof(a)
if("string"===i||"number"===i)e.push(a)
else if(Array.isArray(a)&&a.length){var l=t.apply(null,a)
l&&e.push(l)}else if("object"===i)for(var o in a)n.call(a,o)&&a[o]&&e.push(o)}}return e.join(" ")}var n={}.hasOwnProperty
e.exports?(t.default=t,e.exports=t):window.classNames=t}()}),Gn=t.createContext({expanded:[],isExpanded:function(){return!1},toggleExpanded:function(){}})
!function(e){e.Content=We,e.Footer=Ve}(He||(He={}))
var Yn,Jn=He,Kn="toolbar",Qn=[{key:"before",label:"Before selected element"},{key:"after",label:"After selected element"}]
!function(e){e[e.Small=0]="Small",e[e.Medium=1]="Medium",e[e.Large=2]="Large"}(Yn||(Yn={}))
var Zn=t.createContext(Yn.Large),er=i.connect(function(e,t){return{schema:e.schemas[t.model.__type]}},function(e,t){return{onUpdate:function(n,r){e(J(t.path,n,r))}}})(et),tr=function(e){function n(e){var t
return _classCallCheck(this,n),t=r.call(this,e),t.originalModel=null,t.handleCancel=function(){t.close()},t.handleApply=function(){t.close()},t.originalModel=e.model,t}_inherits(n,e)
var r=_createSuper(n)
return _createClass(n,[{key:"close",value:function(){this.props.setOverlay(null)}},{key:"render",value:function(){var e=this.props,n=e.model,r=e.path
return t.createElement(Fe,null,t.createElement(Jn,null,t.createElement(Jn.Content,null,t.createElement(er,{model:n,path:r})),t.createElement(Jn.Footer,null,t.createElement(Ue,{onClick:this.handleApply},t.createElement(De,{value:"Apply"})))))}}]),n}(t.Component),nr=i.connect(function(e,t){return m(e,t.uuid)},function(e){return{setOverlay:function(t){return e(P(t))}}})(tr),rr="craft:",ar="material:",ir=function(e){function n(){var e
return _classCallCheck(this,n),e=r.apply(this,arguments),e.element=null,e.lightswitch=null,e.handleChange=function(){var t=e.props,n=t.disabled,r=t.onChange,a=_assertThisInitialized(e).lightswitch
!n&&a&&r(a.on)},e.setElement=function(t){e.element!==t&&(e.element=t,e.updateInstance())},e}_inherits(n,e)
var r=_createSuper(n)
return _createClass(n,[{key:"componentDidUpdate",value:function(e){var t=this.props.value,n=this.lightswitch
e.disabled!==this.props.disabled?this.updateInstance():n&&n.on!==t&&n.toggle()}},{key:"render",value:function(){var e=this.props,n=e.className,r=e.disabled,a=e.small,i=e.value
return t.createElement("div",null,t.createElement("div",{className:Xn("lightswitch",n,{disabled:r,on:i,small:a}),ref:this.setElement,tabIndex:0},t.createElement("div",{className:"lightswitch-container"},t.createElement("div",{className:"label on"}),t.createElement("div",{className:"handle"}),t.createElement("div",{className:"label off"}))))}},{key:"updateInstance",value:function(){var e=this.element,t=this.handleChange,n=this.lightswitch,r=this.props,a=r.disabled,i=r.value
n&&(n.destroy(),this.lightswitch=null),!a&&e&&(this.lightswitch=new Craft.LightSwitch(e,{onChange:t,value:i}))}}]),n}(t.Component),lr=function(e){function n(e){var t
return _classCallCheck(this,n),t=r.call(this,e),t.handleApply=function(e){var n=t.props,r=n.currentSite,a=n.endpoint,i=t.state,l=i.arrayOrphanMode,o=i.site,c=i.useTranslator
if(o){var s
c&&r&&o.language!==r.language&&(s={endpoint:a,source:o.language,target:r.language}),t.props.onSynchronize({arrayOrphanMode:l,siteId:o.id,translate:s,verbose:"altKey"in e&&e.altKey})}},t.handleArrayOrphanModeChange=function(e){t.setState({arrayOrphanMode:e})},t.handleSiteChange=function(e){t.setState({site:e})},t.handleToggleTranslator=function(e){t.setState({useTranslator:e})},t.state={arrayOrphanMode:"hide",site:e.availableSites[0]||null,useTranslator:!1},t}_inherits(n,e)
var r=_createSuper(n)
return _createClass(n,[{key:"render",value:function(){var e=this.props,n=e.availableSites,r=e.currentSite,a=e.hasTranslator,i=e.onClose,l=this.state,o=l.arrayOrphanMode,c=l.site,s=l.useTranslator,u=n.map(function(e){return{label:e.label,key:e}})
return t.createElement(t.Fragment,null,t.createElement(Jn.Content,null,t.createElement("div",{className:"tcfSynchronize--title"},t.createElement(De,{value:"Synchronize translations"})),t.createElement(ze,null,t.createElement(qe,{instructions:g("Select the site the content should be copied from."),label:g("Site")},t.createElement(Xe,{onChange:this.handleSiteChange,options:u,value:c})),t.createElement(qe,{instructions:g("Defines what happens to elements that do not exist in the selected language."),label:g("Orphaned elements")},t.createElement(Xe,{onChange:this.handleArrayOrphanModeChange,options:at(),value:o})),c&&r&&c.language!==r.language?t.createElement(qe,{instructions:g(a?"Uses a webservice to automatically translate texts.":"A matching webservice must be configured in the options of this field in order to use this feature."),label:g("Translate texts automatically")},t.createElement(ir,{disabled:!a,onChange:this.handleToggleTranslator,value:s})):null)),t.createElement(Jn.Footer,null,t.createElement(Ue,{onClick:i,secondary:!0},t.createElement(De,{value:"Cancel"})),t.createElement(Ue,{onClick:this.handleApply,primary:!0},t.createElement(De,{value:"Apply"}))))}}]),n}(t.Component),or=i.connect(function(e){var t=e.config,n=t.apiEndpoints,r=t.elementSiteId,a=t.hasTranslator,i=t.supportedSites
return{availableSites:i.filter(function(e){return e.id!==r}),currentSite:i.find(function(e){return e.id===r}),endpoint:n.translate,hasTranslator:a}},function(e){return{onSynchronize:function(t){return e(fe(t))}}})(lr),cr=t.createContext(0),sr=t.memo(function(e){var n=e.canChangeVisibility,r=void 0!==n&&n,a=e.canChangeType,l=void 0===a||a,o=e.disabled,c=void 0!==o&&o,s=e.isBorderless,u=e.model,f=e.path,m=e.schemaNames,p=i.useDispatch(),h=i.useSelector(function(e){return m.map(function(t){return e.schemas[t]})}),v=!1
d(u)&&(v=h.some(function(e){return e.qualifier===u.__type}))
var y=l&&h.length>1,g=r&&v&&!u.__visible
return t.createElement(st,null,t.createElement(Ke,null,y||g?t.createElement("div",{className:"tcfInstance--controls"},y?t.createElement(ut,{disabled:c,dispatch:p,model:v?u:null,path:f,schemas:h}):null,g?t.createElement(dt,{disabled:c,dispatch:p,model:u}):null):null,v?t.createElement(er,{disabled:c,model:u,isBorderless:s,path:f}):null))}),ur=function(e){function t(e){var n
_classCallCheck(this,t),(n=r.call(this,e)).element=null,n.handleMouseDown=function(e){var t=n.props.onClick
e.target===n.element&&t&&t()}
var a=document.createElement("div")
return a.className="tcfOverlay",a.addEventListener("mousedown",n.handleMouseDown),document.body.appendChild(a),n.element=a,n}_inherits(t,e)
var r=_createSuper(t)
return _createClass(t,[{key:"componentWillUnmount",value:function(){var e=this.element
e&&(document.body.removeChild(e),e.removeEventListener("mousedown",this.handleMouseDown),this.element=null)}},{key:"render",value:function(){var e=this.props.children,t=this.element
return t?n.createPortal(e,t):null}}]),t}(t.Component),dr={},fr={},mr=function(e,t){dr[String(t)]=!0},pr=function(e,t){fr[String(t)]=!0},hr=function(e){function t(e){return _classCallCheck(this,t),n.call.apply(n,[this].concat(_toConsumableArray(yt(e))))}_inherits(t,e)
var n=_createSuper(t)
return _createClass(t,[{key:"toHTML",value:function(){return new o.SafeString(this.toString())}},{key:"toList",value:function(e){return new o.SafeString('<ul class="'.concat(e,'">').concat(this.map(function(e){return"<li>".concat(ht(e),"</li>")}).join(""),"</ul>"))}},{key:"toString",value:function(){return this.map(function(e){return ht(e)}).join("")}},{key:"asColumn",get:function(){return this.toList("flexColumn")}},{key:"asList",get:function(){return this.toList("")}},{key:"asRow",get:function(){return this.toList("flexRow")}}]),t}(_wrapNativeSuper(Array))
ee([pr],hr.prototype,"asColumn",null),ee([pr],hr.prototype,"asList",null),ee([pr],hr.prototype,"asRow",null),ee([mr],hr.prototype,"toHTML",null),ee([mr],hr.prototype,"toList",null),ee([mr],hr.prototype,"toString",null)
var vr=function(e){function n(e){var t
return _classCallCheck(this,n),t=r.call(this,e),t.element=null,t.handleAnimationEnd=function(){var e=_assertThisInitialized(t).element
e&&(e.style.height="",e.style.transition=""),t.setState({inTransition:!1,lastChildren:null,lastUri:null})},t.setElement=function(e){t.element=e},t.state={currentChildren:e.children,currentUri:e.uri,inTransition:!1,lastChildren:null,lastUri:null},t}_inherits(n,e)
var r=_createSuper(n)
return _createClass(n,[{key:"componentDidUpdate",value:function(e,t,n){var r=this.element
r&&n&&setTimeout(function(){r.style.height=""
var e=r.offsetHeight
r.style.height="".concat(n.height,"px"),r.getBoundingClientRect(),r.style.transition="height 200ms",r.style.height="".concat(e,"px")},0)}},{key:"getSnapshotBeforeUpdate",value:function(e,t){var n=this.element
if(t.currentUri!==this.state.currentUri&&n){var r=n.offsetHeight
return n.style.height="".concat(r,"px"),{height:r}}return null}},{key:"render",value:function(){var e=this.props,n=e.className,r=e.itemClassName,a=this.state,i=a.currentChildren,l=a.currentUri,o=a.inTransition,c=a.lastChildren,s=a.lastUri,u=[]
return o&&s&&u.push(t.createElement("div",{className:Xn(r,"tcfDetailsPanel--item","from"),key:s},c)),u.push(t.createElement("div",{className:Xn(r,"tcfDetailsPanel--item",{to:o}),key:l,onAnimationEnd:this.handleAnimationEnd},i)),t.createElement("div",{className:Xn(n,"tcfDetailsPanel"),ref:this.setElement},u)}}],[{key:"getDerivedStateFromProps",value:function(e,t){return e.uri===t.currentUri?Object.assign(Object.assign({},t),{currentChildren:e.children}):e.uri===t.currentUri||t.inTransition?null:{inTransition:!0,lastChildren:t.currentChildren,lastUri:t.currentUri,currentChildren:e.children,currentUri:e.uri}}}]),n}(t.Component),yr=null,gr=t.memo(function(e){var n=e.field,r=e.model,a=e.references,i=e.schemas,l=Z(e,["field","model","references","schemas"]),o=ht(Fn.getDefinition("instance").preview({context:{depth:0,references:a,schemas:i},field:n,mode:"label",value:r})).replace(/<[^>]*>?/gm,"").replace(/[\n\t\r]+/g,"").trim().substr(0,256)
return t.createElement("div",Object.assign({},l),o)},function(e,t){return e.model===t.model}),br=i.connect(function(e,t){return{commands:Ce(e,t.uuid)}},function(e){return{dispatch:e}})(Mt),Er=function(e){function n(){var e
return _classCallCheck(this,n),e=r.apply(this,arguments),e.handle=null,e.handleStyle={left:"0px"},e.origin=null,e.panel=null,e.panelClassName="tcfFlyout--panel",e.panelStyle={left:"0px",top:"0px"},e.handleResize=function(){e.update()},e.setHandle=function(t){e.handle=t,e.update()},e.setOrigin=function(t){e.origin=t,e.update()},e.setPanel=function(t){e.panel=t,e.update()},e}_inherits(n,e)
var r=_createSuper(n)
return _createClass(n,[{key:"componentDidMount",value:function(){window.addEventListener("resize",this.handleResize)}},{key:"componentWillUnmount",value:function(){window.removeEventListener("resize",this.handleResize)}},{key:"render",value:function(){var e=this.props,n=e.children,r=e.onClick
return t.createElement("div",{className:"tcfFlyout",ref:this.setOrigin},t.createElement(ur,{onClick:r},t.createElement("div",{className:this.panelClassName,ref:this.setPanel,style:Object.assign({},this.panelStyle)},t.createElement("div",{className:"tcfFlyout--handle",ref:this.setHandle,style:Object.assign({},this.handleStyle)}),t.createElement("div",{className:"tcfFlyout--body"},n))))}},{key:"update",value:function(){var e=this.handle,t=this.handleStyle,n=this.origin,r=this.panel,a=this.panelStyle
if(n&&r&&e){var i=n.getBoundingClientRect(),l=r.getBoundingClientRect(),o="tcfFlyout--panel",c=Math.max(10,Math.min(window.innerWidth-l.width-10,i.left+.5*(i.width-l.width))),s=Math.max(10,Math.min(l.width-10,i.left+.5*i.width-c))
t.left="".concat(s,"px"),a.left="".concat(c,"px"),i.top+.5*i.height>.5*window.innerHeight?(o+=" above",a.top="".concat(i.top-l.height-5,"px")):(o+=" below",a.top="".concat(i.top+i.height+5,"px")),e.style.left=t.left,r.className=this.panelClassName=o,r.style.left=a.left,r.style.top=a.top}}}]),n}(t.Component),_r=function(e){function n(){var e
return _classCallCheck(this,n),e=r.apply(this,arguments),e.state={isExpanded:!1},e.handleClose=function(){e.setState({isExpanded:!1})},e.handleMouseDown=function(){e.setState({isExpanded:!0})},e}_inherits(n,e)
var r=_createSuper(n)
return _createClass(n,[{key:"render",value:function(){var e=this.props.uuid,n=this.state.isExpanded
return t.createElement("div",{className:"tcfArrayWidgetMember--headerMore"},t.createElement("div",{className:"tcfArrayWidgetMember--headerMoreButton",onMouseDown:this.handleMouseDown},t.createElement(tt,{name:"material:more_vert"})),n?t.createElement(Er,{onClick:this.handleClose},t.createElement(br,{onClose:this.handleClose,uuid:e})):null)}}]),n}(t.Component),Cr=t.memo(function(e){var n=e.field,r=e.model,a=e.mode,i=void 0===a?"default":a,l=e.references,o=e.schemas,c=Fn.getDefinition("instance").preview({context:{depth:0,references:l,schemas:o},field:n,mode:i,value:r})
try{var s={__html:ht(c)}
return t.createElement("div",{className:Xn("tcfInstancePreview--content",i),dangerouslySetInnerHTML:s})}catch(e){return t.createElement(t.Fragment,null,t.createElement("p",null,t.createElement("span",{className:"tcfIcon material"},"error"),t.createElement("span",null,"Could not render preview.")),e&&"object"===_typeof(e)&&"message"in e?t.createElement("pre",null,e.message):null)}},function(e,t){return e.model===t.model}),wr=function(e){function n(){var e
return _classCallCheck(this,n),e=r.apply(this,arguments),e.handleAdd=function(t){var n=_assertThisInitialized(e).context,r=e.props,a=r.data,i=r.disabled,l=r.onUpdate
if(!i){var o=Array.isArray(a)?a.slice():[]
o.push(Ie(t)),l(o),d(t)&&n&&n.toggleExpanded(t.__uuid,!0)}},e.handleDelete=function(t){var n=e.props,r=n.data,a=n.disabled,i=n.onUpdate
if(!a&&Array.isArray(r)){var l=r.slice()
l.splice(t,1),i(l)}},e.handleUpdate=function(t,n){var r=e.props,a=r.data,i=r.disabled,l=r.onUpdate
if(!i&&Array.isArray(a)){var o=a.slice()
o[t]=Ie(n,o[t]),l(o)}},e}_inherits(n,e)
var r=_createSuper(n)
return _createClass(n,[{key:"render",value:function(){var e=this.props,n=e.data,r=e.disabled,a=e.field,i=e.model,l=e.path,o=a.limit
if(!a.member)return null
var c,s=Array.isArray(n)?n:[],u=o>0&&s.length>=o,d=Fn.getDefinition(a.member)
return r||!d||u||(c=t.createElement(d.factory,{field:a.member,onCreate:this.handleAdd,scope:i.__type})),t.createElement(Dt,{data:s,disabled:r,field:a,limit:o,model:i,onDelete:this.handleDelete,onUpdate:this.handleUpdate,path:l},c)}}]),n}(t.Component)
wr.contextType=Gn
var kr=function(){function e(t){var n=t.factory,r=t.widget
_classCallCheck(this,e),this.factory=n||Vt,this.widget=r}return _createClass(e,[{key:"cloneValue",value:function(e){return te(this,void 0,void 0,regeneratorRuntime.mark(function t(){var n,r
return regeneratorRuntime.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:if(n=e.field,r=e.value,!this.isValue(n,r)){t.next=5
break}return t.abrupt("return",Wt(r))
case 5:return t.abrupt("return",this.createValue(e))
case 6:case"end":return t.stop()}},t,this)}))}}]),e}(),Sr=function(e){function t(){return _classCallCheck(this,t),n.call(this,{widget:wr})}_inherits(t,e)
var n=_createSuper(t)
return _createClass(t,[{key:"cloneValue",value:function(e){return te(this,void 0,void 0,regeneratorRuntime.mark(function t(){var n,r,a,i,l,o,c,s
return regeneratorRuntime.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:if(n=e.field,r=e.value,a=Z(e,["field","value"]),!this.isValue(n,r)){t.next=27
break}i=Fn.getDefinition(n.member.type),l=[],o=_createForOfIteratorHelper(r),t.prev=5,o.s()
case 7:if((c=o.n()).done){t.next=16
break}return s=c.value,t.t0=l,t.next=12,i.cloneValue(Object.assign(Object.assign({},a),{field:n.member,value:s}))
case 12:t.t1=t.sent,t.t0.push.call(t.t0,t.t1)
case 14:t.next=7
break
case 16:t.next=21
break
case 18:t.prev=18,t.t2=t.catch(5),o.e(t.t2)
case 21:return t.prev=21,o.f(),t.finish(21)
case 24:return t.abrupt("return",l)
case 27:return t.abrupt("return",this.createValue(e))
case 28:case"end":return t.stop()}},t,this,[[5,18,21,24]])}))}},{key:"createValue",value:function(e){return[]}},{key:"isValue",value:function(e,t){return Array.isArray(t)}},{key:"preview",value:function(e){return new hr(e)}}]),t}(kr),Or=function(e){function t(){return _classCallCheck(this,t),n.apply(this,arguments)}_inherits(t,e)
var n=_createSuper(t)
return _createClass(t,[{key:"createValue",value:function(e){return!!e.field.defaultValue}},{key:"isValue",value:function(e,t){return"boolean"==typeof t||t instanceof Boolean}},{key:"preview",value:function(e){return e.value}}]),t}(kr),xr=function(e){function n(){var e
return _classCallCheck(this,n),e=r.apply(this,arguments),e.id=C(),e}_inherits(n,e)
var r=_createSuper(n)
return _createClass(n,[{key:"render",value:function(){var e=this.id,n=this.props,r=n.className,a=n.children,i=n.disabled,l=n.onChange,o=n.value
return t.createElement("dl",{className:Xn("tcfCheckbox",r)},t.createElement("dd",{className:"tcfCheckbox--input"},t.createElement("input",{checked:o,disabled:i,id:e,onChange:i?void 0:function(){return l(!o)},type:"checkbox"})),t.createElement("dt",{className:"tcfCheckbox--label"},t.createElement("label",{htmlFor:e},a)))}}]),n}(t.Component),Nr=function(e){function t(){var e
return _classCallCheck(this,t),e=n.call(this,{widget:Ht}),e.isAlwaysPlainField=!0,e}_inherits(t,e)
var n=_createSuper(t)
return t}(Or),Ir=t.createContext({css:"#000",hsv:{hue:0,saturation:0,value:0,alpha:0},rgb:{red:0,green:0,blue:0,alpha:0},onHsvColor:function(e){},onRgbColor:function(e){}}),jr=function(e){function n(e){var t
return _classCallCheck(this,n),t=r.call(this,e),t.timeout=null,t.commit=function(){null!==t.timeout&&window.clearTimeout(t.timeout),t.timeout=window.setTimeout(t.handleTimeout,250)},t.handleHsvColor=function(e){var n=Xt(e)
t.setState({css:Gt(n),rgb:n,hsv:e}),t.commit()},t.handleRgbColor=function(e){t.setState({css:Gt(e),rgb:e,hsv:Jt(e)}),t.commit()},t.handleTimeout=function(){t.timeout=null,t.props.onChange(t.state.rgb)},t.state={css:Gt(e.color),hsv:Jt(e.color),rgb:Object.assign({},e.color)},t}_inherits(n,e)
var r=_createSuper(n)
return _createClass(n,[{key:"render",value:function(){var e=this.props.children
return t.createElement(Ir.Provider,{value:Object.assign(Object.assign({},this.state),{onHsvColor:this.handleHsvColor,onRgbColor:this.handleRgbColor})},e)}}]),n}(t.Component),Ar=Kt(function(e){function n(){var e
return _classCallCheck(this,n),e=r.apply(this,arguments),e.state={hasFocus:!1},e.handleBlur=function(){e.setState({hasFocus:!1})},e.handleChange=function(t){var n=t.target.value;(0,e.props.onRgbColor)(e.getColor(n))},e.handleFocus=function(){e.setState({hasFocus:!0})},e}_inherits(n,e)
var r=_createSuper(n)
return _createClass(n,[{key:"getValue",value:function(){var e=this.props,t=e.rgb,n=e.type
switch(n){case"alpha":case"blue":case"green":case"red":return"".concat(t[n])
case"hex":return Yt(t)}}},{key:"getColor",value:function(e){var t=this.props,n=t.rgb,r=t.type
switch(r){case"blue":case"green":case"red":var a=parseInt(e)
return Object.assign(Object.assign({},n),_defineProperty({},r,isFinite(a)?Math.max(0,Math.min(255,a)):n[r]))
case"alpha":var i=parseFloat(e)
return Object.assign(Object.assign({},n),{alpha:isFinite(i)?Math.max(0,Math.min(1,i)):n.alpha})
case"hex":var l=$t(e)
return l?Object.assign(Object.assign({},l),{alpha:n.alpha}):n}}},{key:"render",value:function(){var e=this.state.hasFocus,n={className:"tcfColorInputInput",onBlur:this.handleBlur,onChange:this.handleChange,onFocus:this.handleFocus}
return e?n.defaultValue=this.getValue():n.value=this.getValue(),t.createElement(Qt,n)}}]),n}(t.Component)),Mr=Kt(function(e){function n(){var e
return _classCallCheck(this,n),e=r.apply(this,arguments),e.element=null,e.state={initialHue:0,isMouseDown:!1,mouseX:0,mouseY:0},e.handleMouseDown=function(t){var n=e.props.hsv
window.addEventListener("mousemove",e.handleMouseMove),window.addEventListener("mouseup",e.handleMouseUp),e.setState(Object.assign(Object.assign({},e.update(t.clientX,t.clientY,n.hue)),{initialHue:n.hue,isMouseDown:!0}))},e.handleMouseMove=function(t){e.setState(e.update(t.clientX,t.clientY))},e.handleMouseUp=function(t){e.stopListening(),e.setState(Object.assign(Object.assign({},e.update(t.clientX,t.clientY)),{isMouseDown:!1}))},e.setElement=function(t){e.element=t},e}_inherits(n,e)
var r=_createSuper(n)
return _createClass(n,[{key:"componentWillUnmount",value:function(){this.stopListening()}},{key:"render",value:function(){var e=this.props.hsv,n=this.state,r=n.initialHue,a=n.isMouseDown,i=n.mouseX,l=n.mouseY
return t.createElement("div",{className:"tcfColorInputSaturation",onMouseDown:this.handleMouseDown,ref:this.setElement,style:{background:"hsl(".concat(360*(a?r:e.hue),", 100%, 50%)")}},t.createElement("div",{className:"tcfColorInputSaturation--value",style:{left:"".concat(100*(a?i:e.saturation),"%"),top:"".concat(100*(a?l:1-e.value),"%")}}))}},{key:"stopListening",value:function(){window.removeEventListener("mousemove",this.handleMouseMove),window.removeEventListener("mouseup",this.handleMouseUp)}},{key:"update",value:function(e,t){var n=arguments.length>2&&void 0!==arguments[2]?arguments[2]:this.state.initialHue,r=this.element
if(!r)return{mouseX:this.state.mouseX,mouseY:this.state.mouseY}
var a=this.props,i=a.hsv,l=a.onHsvColor,o=r.getBoundingClientRect(),c=Math.max(0,Math.min(1,(e-o.left)/o.width)),s=Math.max(0,Math.min(1,(t-o.top)/o.height))
return l({alpha:i.alpha,hue:n,saturation:c,value:1-s}),{mouseX:c,mouseY:s}}}]),n}(t.Component)),Tr=Kt(function(e){function n(){var e
return _classCallCheck(this,n),e=r.apply(this,arguments),e.element=null,e.handleMouseDown=function(t){window.addEventListener("mousemove",e.handleMouseMove),window.addEventListener("mouseup",e.handleMouseUp),e.update(t.clientX)},e.handleMouseMove=function(t){e.update(t.clientX)},e.handleMouseUp=function(t){e.stopListening(),e.update(t.clientX)},e.setElement=function(t){e.element=t},e}_inherits(n,e)
var r=_createSuper(n)
return _createClass(n,[{key:"componentWillUnmount",value:function(){this.stopListening()}},{key:"render",value:function(){var e,n=this.props,r=n.rgb,a=n.hsv,i=n.type,l=a[i]
if("alpha"===i){var o=r.red,c=r.green,s=r.blue,u="rgba(".concat(o,", ").concat(c,", ").concat(s,", 0)"),d="rgba(".concat(o,", ").concat(c,", ").concat(s,", 1)")
e=t.createElement("div",{className:"tcfColorInputSlider--gradient",style:{background:"linear-gradient(to right, ".concat(u,", ").concat(d,")")}})}return t.createElement("div",{className:"tcfColorInputSlider ".concat(i),onMouseDown:this.handleMouseDown},e,t.createElement("div",{className:"tcfColorInputSlider--track",ref:this.setElement},t.createElement("div",{className:"tcfColorInputSlider--handle",style:{left:"".concat(100*l,"%")}})))}},{key:"stopListening",value:function(){window.removeEventListener("mousemove",this.handleMouseMove),window.removeEventListener("mouseup",this.handleMouseUp)}},{key:"update",value:function(e){var t=this.element
if(t){var n=this.props,r=n.hsv,a=n.onHsvColor,i=n.type,l=t.getBoundingClientRect(),o=Math.max(0,Math.min(1,(e-l.left)/l.width))
a(Object.assign(Object.assign({},r),_defineProperty({},i,o)))}}}]),n}(t.Component)),Rr=Kt(Zt),Pr=function(e){function n(){var e
return _classCallCheck(this,n),e=r.apply(this,arguments),e.state={hasColorPicker:!1},e.handleChange=function(t){e.props.onChange(t)},e.handleSwatchClick=function(){e.setState({hasColorPicker:!0})},e.handleOverlayClick=function(){e.setState({hasColorPicker:!1})},e}_inherits(n,e)
var r=_createSuper(n)
return _createClass(n,[{key:"render",value:function(){var e=this.state.hasColorPicker,n=this.props,r=n.color,a=n.disableAlpha,i=n.disabled,l=n.onChange,o=n.presetColors
return t.createElement(jr,{color:r,onChange:l},t.createElement("div",{className:"tcfColorInput"},t.createElement(Rr,{className:"tcfColorInput--swatch",disabled:i,onClick:this.handleSwatchClick},e&&!i?t.createElement(Er,{onClick:this.handleOverlayClick},t.createElement(en,{disableAlpha:a,presetColors:o})):null),t.createElement(Ar,{type:"hex"})))}}]),n}(t.Component),Lr=function(e){function t(){return _classCallCheck(this,t),n.call(this,{widget:tn})}_inherits(t,e)
var n=_createSuper(t)
return _createClass(t,[{key:"createValue",value:function(e){return zt()}},{key:"isValue",value:function(e,t){return qt(t)}},{key:"preview",value:function(e){e.context,e.value
return""}}]),t}(kr),Fr=function(e){function n(){var e
return _classCallCheck(this,n),e=r.apply(this,arguments),e.request=null,e.state={mode:"idle"},e.handleChange=function(t){e.updateOEmbed(),e.setState({mode:"typing"}),e.props.onUpdate(Object.assign(Object.assign({},e.getOEmbed()),{url:t.target.value}))},e.updateOEmbed=nn(function(){e.setState({mode:"loading"})
var t=e.props,n=t.apiEndpoint,r=t.model,a=t.field,i=["schema=".concat(encodeURIComponent(r.__type)),"field=".concat(encodeURIComponent(a.name)),"url=".concat(encodeURIComponent(e.getOEmbed().url))],l=new XMLHttpRequest
l.onreadystatechange=function(){return e.handleRequestStateChange(l)},l.onerror=function(){return e.handleRequestError()},l.open("GET","".concat(n,"&").concat(i.join("&"))),l.send(),e.request&&e.request.abort(),e.request=l},500),e}_inherits(n,e)
var r=_createSuper(n)
return _createClass(n,[{key:"getOEmbed",value:function(){var e=this.props.data
return ln(e)?e:{url:""}}},{key:"handleRequestStateChange",value:function(e){if(e.readyState===XMLHttpRequest.DONE){if(200!==e.status)return this.handleRequestError()
var t
try{t=JSON.parse(e.responseText)}catch(e){return this.handleRequestError()}this.setState({mode:"idle"}),this.request=null,this.props.onUpdate(Object.assign(Object.assign({},this.getOEmbed()),{info:t.data}))}}},{key:"handleRequestError",value:function(){this.setState({mode:"idle"}),this.request=null,this.props.onUpdate(Object.assign(Object.assign({},this.getOEmbed()),{info:null}))}},{key:"render",value:function(){var e,n=this.getOEmbed(),r=this.props.disabled,a=this.state.mode
if("typing"===a||"loading"===a)e=t.createElement("div",{className:"tcfOEmbedWidget--activity"},t.createElement("div",{className:"tcfOEmbedWidget--activityBounce first"}),t.createElement("div",{className:"tcfOEmbedWidget--activityBounce second"}),t.createElement("div",{className:"tcfOEmbedWidget--activityBounce third"}))
else if(n.info){var i=n.info,l=i.title,o=i.author_name,c=i.thumbnail_url
e=t.createElement("div",{className:"tcfOEmbedWidget--info"},c?t.createElement("img",{className:"tcfOEmbedWidget--infoImage",src:c}):null,t.createElement("div",{className:"tcfOEmbedWidget--infoContent"},t.createElement("div",{className:"tcfOEmbedWidget--infoTitle"},l),t.createElement("div",{className:"tcfOEmbedWidget--infoAuthor"},o)))}else e=t.createElement(an,{title:"Invalid embed url"})
return t.createElement("div",{className:"tcfOEmbedWidget"},t.createElement("div",{className:"tcfOEmbedWidget--input"},t.createElement("input",{autoComplete:"off",className:"text fullwidth",disabled:r,onChange:r?void 0:this.handleChange,value:n.url})),e)}}]),n}(t.Component),Ur=i.connect(function(e){return{apiEndpoint:e.config.apiEndpoints.oembed}})(Fr),Dr=function(){function e(t){_classCallCheck(this,e),this.value=t}return _createClass(e,[{key:"toHTML",value:function(){var e=this.value.info
if(!e)return new o.SafeString("")
var t=""
return e.thumbnail_url&&(t='<img class="tcfOEmbedWidget--infoImage" src="'.concat(e.thumbnail_url,'" />')),new o.SafeString('\n      <div class="tcfOEmbedWidget--info">\n        '.concat(t,'\n        <div class="tcfOEmbedWidget--infoContent">\n          <div class="tcfOEmbedWidget--infoTitle">').concat(e.title,'</div>\n          <div class="tcfOEmbedWidget--infoAuthor">').concat(e.author_name,"</div>\n        </div>\n      </div>\n    "))}},{key:"author",get:function(){return this.value.info?this.value.info.author_name:""}},{key:"thumbnail",get:function(){var e=this.value.info
return e&&e.thumbnail_url?new o.SafeString('<img width="100" src='.concat(e.thumbnail_url," />")):""}},{key:"title",get:function(){return this.value.info?this.value.info.title:""}}]),e}()
ee([pr],Dr.prototype,"value",void 0),ee([pr],Dr.prototype,"author",null),ee([pr],Dr.prototype,"thumbnail",null),ee([pr],Dr.prototype,"title",null),ee([mr],Dr.prototype,"toHTML",null)
var Wr=function(e){function t(){return _classCallCheck(this,t),n.call(this,{widget:Ur})}_inherits(t,e)
var n=_createSuper(t)
return _createClass(t,[{key:"createValue",value:function(e){return{url:""}}},{key:"isValue",value:function(e,t){return ln(t)}},{key:"preview",value:function(e){var t=e.value
return new Dr(ln(t)?t:{url:""})}}]),t}(kr),Vr=function(e){function t(){return _classCallCheck(this,t),n.call(this,{factory:un,widget:fn})}_inherits(t,e)
var n=_createSuper(t)
return _createClass(t,[{key:"cloneValue",value:function(e){return te(this,void 0,void 0,regeneratorRuntime.mark(function t(){var n,r,a
return regeneratorRuntime.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:if(n=e.field,r=e.value,a=Z(e,["field","value"]),!this.isValue(n,r)){t.next=5
break}return t.abrupt("return",ne(Object.assign(Object.assign({},a),{source:r})))
case 5:return t.abrupt("return",this.createValue(e))
case 6:case"end":return t.stop()}},t,this)}))}},{key:"createValue",value:function(e){var t=e.field,n=e.schema,r=e.schemas
if(n||(n=r[t.schemas[0]]),!n)throw new Error("The option `schema` is required when creating instances.")
return w({schema:n,schemas:r})}},{key:"isValue",value:function(e,t){return d(t)&&-1!==e.schemas.indexOf(t.__type)}},{key:"preview",value:function(e){var t=e.context,n=e.mode,r=void 0===n?"default":n,a=e.value
if(!d(a))return""
var i=t.schemas[a.__type]
if(!i)return""
var l="label"===r?i.previewLabelTemplate:i.previewTemplate
if(null===l)return i.label
var c={toHTML:function(){return new o.SafeString(l(c,vt()))},toString:function(){return l(c,vt())}}
c.depth=t.depth
for(var s=0,u=Object.keys(i.fields);s<u.length;s++){var f=u[s],m=i.fields[f],p=Fn.getDefinition(m)
p&&(c[f]=p.preview({context:Object.assign(Object.assign({},t),{depth:t.depth+1}),field:m,value:a[f]}))}return c}}]),t}(kr),Hr=function(e){function t(){return _classCallCheck(this,t),n.call(this,{widget:mn})}_inherits(t,e)
var n=_createSuper(t)
return t}(Or),Br=function(e){function n(){var e
return _classCallCheck(this,n),e=r.apply(this,arguments),e.element=null,e.renderedIds=[],e.uuid="element-".concat(C()),e.instance=null,e.isRendering=!1,e.handleAdd=function(t){var n=t.elements,r=e.props,a=r.elementType,i=r.onAddReferences
e.handleChange(),i(n.map(function(e){return Object.assign(Object.assign({},e),{$element:$(e.$element[0].outerHTML),element:e.$element[0].outerHTML,type:a})}))},e.handleChange=function(){if(!e.isRendering){var t=e.props.onUpdate,n=e.getSelectedIds()
e.renderedIds=n,t(n)}},e.setElement=function(t){if(e.element!==t){e.element=t
var n=_assertThisInitialized(e).instance
if(n&&(n.off("selectElements",e.handleAdd),n.off("removeElements",e.handleChange),n.elementSort&&n.elementSort.off("sortChange",e.handleChange),n.destroy(),e.instance=n=null),t){var r=e.props,a=r.criteria,i=r.elementType,l=r.limit,o=void 0===l?null:l,c=r.modalStorageKey,s=void 0===c?null:c,u=r.sourceElementId,d=r.sources,f=r.viewMode,m=void 0===f?"small":f
n=new Craft.BaseElementSelectInput({criteria:a,elementType:i,id:e.uuid,limit:o,modalStorageKey:s,name:e.uuid,sources:d,sourceElementId:u,viewMode:m}),e.instance=n,e.createReferences(),n.on("selectElements",e.handleAdd),n.on("removeElements",e.handleChange),n.elementSort&&n.elementSort.on("sortChange",e.handleChange)}}},e}_inherits(n,e)
var r=_createSuper(n)
return _createClass(n,[{key:"componentDidUpdate",value:function(){var e=this.renderedIds,t=this.props.data||[]
t.length===e.length&&t.every(function(t,n){return t===e[n]})||this.createReferences()}},{key:"createReferences",value:function(){var e=this.instance
if(e){this.isRendering=!0
var t=[]
e.$elementsContainer.empty()
var n,r=_createForOfIteratorHelper(this.getStoredReferences())
try{for(r.s();!(n=r.n()).done;){var a=n.value,i=e.createNewElement(a)
i.find("input").prop("disabled",!0),e.appendElement(i),t.push(a.id)}}catch(e){r.e(e)}finally{r.f()}e.resetElements(),this.renderedIds=t,this.isRendering=!1}}},{key:"getStoredReferences",value:function(){var e=this.props,t=e.data,n=e.elementType,r=e.references,a=[]
if(!Array.isArray(t))return a
var i,l=_createForOfIteratorHelper(t)
try{for(l.s();!(i=l.n()).done;)!function(){var e=i.value,t=r.find(function(t){return t.id===e&&t.type===n})
t&&a.push(t)}()}catch(e){l.e(e)}finally{l.f()}return a}},{key:"getSelectedIds",value:function(){var e=this.instance
if(!e)return[]
for(var t=[],n=e.getSelectedElementIds(),r=e.getElements(),a=0;a<r.length;a++){var i=parseInt(r.eq(a).data("id"));-1!==n.indexOf(i)&&t.push(i)}return t}},{key:"render",value:function(){return t.createElement("div",{id:this.uuid,className:"elementselect",ref:this.setElement},t.createElement("div",{className:"elements"}),t.createElement("div",{className:"btn add icon dashed"},"Choose"))}}]),n}(t.Component),zr=i.connect(function(e){return{references:e.config.references,sourceElementId:e.config.elementId}},function(e){return{onAddReferences:function(t){e(_(t))}}})(vn),qr=function(e){function t(){return _classCallCheck(this,t),n.call(this,{widget:En})}_inherits(t,e)
var n=_createSuper(t)
return _createClass(t,[{key:"createValue",value:function(){return{elementId:0,hash:"",openInNewWindow:!1,type:"url",url:""}}},{key:"isValue",value:function(e,t){return bn(t)}},{key:"preview",value:function(){return""}}]),t}(kr),$r=function(){function e(t){_classCallCheck(this,e),this.latitude=t.latitude,this.longitude=t.longitude}return _createClass(e,[{key:"createStaticMap",value:function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:100,t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:75,n=this.latitude,r=this.longitude,a=Se()
if(!a)return new o.SafeString("")
var i=["key=".concat(a),"center=".concat(encodeURIComponent("".concat(n,",").concat(r))),"markers=".concat(encodeURIComponent("size:small|".concat(n,",").concat(r))),"size=".concat(e,"x").concat(t),"zoom=15","maptype=roadmap"].join("&")
return new o.SafeString('\n      <img src="https://maps.googleapis.com/maps/api/staticmap?'.concat(i,'" width="').concat(e,'" height="').concat(t,'" />\n    '))}},{key:"toHTML",value:function(){return this.createStaticMap()}}]),e}()
ee([pr],$r.prototype,"latitude",void 0),ee([pr],$r.prototype,"longitude",void 0),ee([mr],$r.prototype,"createStaticMap",null),ee([mr],$r.prototype,"toHTML",null)
var Xr,Gr=["address","street","country","zip","city"],Yr=function(e){function n(){var e
return _classCallCheck(this,n),e=r.apply(this,arguments),e.autocomplete=null,e.input=null,e.state={isSearching:!1},e.handlePlaceChanged=function(){var t=_assertThisInitialized(e).autocomplete
if(t){var n=t.getPlace()
n.geometry&&e.props.onLocation({latitude:n.geometry.location.lat(),longitude:n.geometry.location.lng()})}},e.handleResolve=function(){var t=e.props.places
t&&(e.setState({isSearching:!0}),t.findPlaceFromQuery({query:e.getResolveQuery(),fields:["formatted_address","geometry"]},e.handleResolveResults))},e.handleResolveResults=function(t){e.setState({isSearching:!1}),t||(t=[]),1===t.length?e.handleResultsSelect(t[0]):e.setState({results:t})},e.handleResultsSelect=function(t){var n=t.geometry
if(n){var r=n.location
e.props.onLocation({latitude:r.lat(),longitude:r.lng()}),e.handleResultsCancel()}},e.handleResultsCancel=function(){e.state.results&&e.setState({results:void 0})},e.setInput=function(t){var n=_assertThisInitialized(e).autocomplete
e.input=t,n&&(n.unbindAll(),n=null),t&&((n=new google.maps.places.Autocomplete(t)).setFields(["geometry"]),n.addListener("place_changed",e.handlePlaceChanged)),e.autocomplete=n},e}_inherits(n,e)
var r=_createSuper(n)
return _createClass(n,[{key:"canResolve",value:function(){return""!==this.getResolveQuery()}},{key:"getResolveQuery",value:function(){var e,t=this.props.model,n=[],r=_createForOfIteratorHelper(Gr)
try{for(r.s();!(e=r.n()).done;){var a=e.value
a in t&&"string"==typeof t[a]&&n.push(t[a].trim())}}catch(e){r.e(e)}finally{r.f()}return n.join(", ")}},{key:"render",value:function(){var e
if(this.canResolve()){var n,r=this.state.results
r&&0===r.length?n=t.createElement(rn,{icon:"material:error"},"No locations found"):r&&(n=t.createElement(_n,{onSelect:this.handleResultsSelect,results:r})),e=t.createElement("div",{className:"tcfLocationFieldSearch--resolve"},n?t.createElement(Er,{onClick:this.handleResultsCancel},n):null,t.createElement(Ue,{onClick:this.handleResolve},t.createElement(De,{value:"Resolve address"})))}return t.createElement("div",{className:"tcfLocationFieldSearch"},e,t.createElement("input",{className:"tcfLocationFieldSearch--input tcfInput",ref:this.setInput,type:"search"}))}}]),n}(t.Component),Jr=17
!function(e){e[e.Loading=0]="Loading",e[e.Error=1]="Error",e[e.Ready=2]="Ready"}(Xr||(Xr={}))
var Kr=function(e){function n(){var e
return _classCallCheck(this,n),e=r.apply(this,arguments),e.element=null,e.marker=null,e.state={instance:null,loadState:Xr.Loading},e.handleLocation=function(t){var n=e.state.instance
n&&(n.map.setZoom(Jr),n.map.setCenter({lat:t.latitude,lng:t.longitude})),e.props.onUpdate(t)},e.handleMarkerDragEnd=function(){var t=_assertThisInitialized(e).marker
if(t){var n=t.getPosition()
n&&e.props.onUpdate({latitude:n.lat(),longitude:n.lng()})}},e.setElement=function(t){var r=e.props.disabled,a=e.state.instance,i=_assertThisInitialized(e).marker
if(a&&(n.stashInstance(a),a=null),i&&(i.setMap(null),i.unbindAll(),i=null),t){a=n.createInstance(),t.appendChild(a.element)
var l=a.map
l.setZoom(Jr),l.setCenter(e.getLatLng()),(i=new google.maps.Marker({draggable:!r,position:e.getLatLng(),map:l})).addListener("dragend",e.handleMarkerDragEnd)}e.element=t,e.marker=i,e.setState({instance:a})},e}_inherits(n,e)
var r=_createSuper(n)
return _createClass(n,[{key:"componentDidUpdate",value:function(e){var t=this.marker
e.disabled!==this.props.disabled&&t&&t.setOptions({draggable:!this.props.disabled})}},{key:"componentWillMount",value:function(){var e=this
try{Oe().then(function(){e.setState({loadState:Xr.Ready})})}catch(e){this.setState({loadState:Xr.Error})}}},{key:"getLatLng",value:function(){var e=this.props.data
return Cn(e)?{lat:e.latitude,lng:e.longitude}:{lat:0,lng:0}}},{key:"render",value:function(){var e=this.state,n=e.loadState,r=e.instance,a=this.props,i=a.disabled,l=a.model,o=this.marker
o&&o.setPosition(this.getLatLng())
var c
return c=n===Xr.Loading?t.createElement(it,null):n===Xr.Error?t.createElement(an,{title:"Could not load Google Maps"}):t.createElement(t.Fragment,null,i?null:t.createElement(Yr,{model:l,onLocation:this.handleLocation,places:r?r.places:null}),t.createElement("div",{className:"tcfLocation--map",ref:this.setElement})),t.createElement("div",{className:"tcfLocation"},c)}}],[{key:"createInstance",value:function(){var e=this.instanceStash.pop()
if(!e){var t=document.createElement("div")
t.className="tcfLocation--mapInstance"
var n=new google.maps.Map(t,{mapTypeControl:!1,streetViewControl:!1})
e={element:t,map:n,places:new google.maps.places.PlacesService(n)}}return e}},{key:"stashInstance",value:function(e){var t=e.element,n=t.parentElement
n&&n.removeChild(t),this.instanceStash.push(e)}}]),n}(t.Component)
Kr.instanceStash=[]
var Qr=function(e){function t(){return _classCallCheck(this,t),n.call(this,{widget:Kr})}_inherits(t,e)
var n=_createSuper(t)
return _createClass(t,[{key:"createValue",value:function(e){var t=e.field
return Cn(t.defaultValue)?Object.assign({},t.defaultValue):{latitude:0,longitude:0}}},{key:"isValue",value:function(e,t){return Cn(t)}},{key:"preview",value:function(e){var t=e.value
return new $r(t)}}]),t}(kr),Zr=function(e){function t(){return _classCallCheck(this,t),n.call(this,{widget:kn})}_inherits(t,e)
var n=_createSuper(t)
return t}(function(e){function t(){return _classCallCheck(this,t),n.apply(this,arguments)}_inherits(t,e)
var n=_createSuper(t)
return _createClass(t,[{key:"cloneValue",value:function(e){return te(this,void 0,void 0,regeneratorRuntime.mark(function t(){var n,r,a
return regeneratorRuntime.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:return n=e.field,r=e.schemas,a=e.value,t.abrupt("return",this.isValue(n,a)?a:this.createValue({field:n,schemas:r}))
case 2:case"end":return t.stop()}},t,this)}))}},{key:"createValue",value:function(e){return e.field.defaultValue}},{key:"isValue",value:function(e,t){return!(!e.optional||null!==t)||("number"==typeof t||t instanceof Number)}},{key:"preview",value:function(e){return e.value}}]),t}(kr)),ea=function(){function e(t){_classCallCheck(this,e),this.value=t}return _createClass(e,[{key:"toHTML",value:function(){return new o.SafeString(this.value)}},{key:"summary",get:function(){return new o.SafeString('<div class="snippet">'.concat(this.value,"</div>"))}}]),e}()
ee([pr],ea.prototype,"value",void 0),ee([mr],ea.prototype,"summary",null),ee([mr],ea.prototype,"toHTML",null)
var ta=function(e){function n(){var e
return _classCallCheck(this,n),e=r.apply(this,arguments),e.element=null,e.hasFocus=!1,e.instance=null,e.renderedValue="",e.uuid="element-".concat(C()),e.handleBlur=function(){e.hasFocus=!1},e.handleChange=function(t){e.hasFocus&&(e.renderedValue=t,e.props.onUpdate(t))},e.handleFocus=function(){e.hasFocus=!0},e.setElement=function(t){if(e.element!==t){e.element=t
var n=e.props,r=n.elementSiteId,a=n.options,i=_assertThisInitialized(e).instance
i&&(i.redactor&&(i.redactor.off("blur",e.handleBlur),i.redactor.off("changed",e.handleChange),i.redactor.off("focus",e.handleFocus)),i.destroy(),i=null),t&&(i=new Craft.RedactorInput(Object.assign(Object.assign({},a),{elementSiteId:r,id:e.uuid,redactorConfig:Object.assign({},a.redactorConfig)})),t.removeAttribute("name"),i.redactor&&(i.redactor.on("blur",e.handleBlur),i.redactor.on("changed",e.handleChange),i.redactor.on("focus",e.handleFocus))),e.instance=i}},e}_inherits(n,e)
var r=_createSuper(n)
return _createClass(n,[{key:"componentDidUpdate",value:function(){var e=this.hasFocus,t=this.instance,n=this.props,r=this.renderedValue
t&&!e&&n.value!=r&&(this.renderedValue=n.value,t.redactor.source.setCode(n.value))}},{key:"render",value:function(){var e=this.props.value
return t.createElement("div",{className:"tcfRedactorWidget"},t.createElement("textarea",{defaultValue:"string"==typeof e?e:"",id:this.uuid,ref:this.setElement}))}}]),n}(t.Component),na=i.connect(function(e){return{elementSiteId:e.config.elementSiteId}})(xn),ra=0,aa=function(e){function t(){return _classCallCheck(this,t),n.apply(this,arguments)}_inherits(t,e)
var n=_createSuper(t)
return _createClass(t,[{key:"cloneValue",value:function(e){return te(this,void 0,void 0,regeneratorRuntime.mark(function t(){var n,r,a
return regeneratorRuntime.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:if(n=e.field,r=e.translate,a=e.value,!this.isValue(n,a)){t.next=9
break}if(!n.translatable||!r){t.next=6
break}return t.abrupt("return",Nn(a,r))
case 6:return t.abrupt("return",a)
case 7:t.next=10
break
case 9:return t.abrupt("return","")
case 10:case"end":return t.stop()}},t,this)}))}},{key:"createValue",value:function(e){return""}},{key:"isValue",value:function(e,t){return"string"==typeof t||t instanceof String}},{key:"preview",value:function(e){return e.value}}]),t}(kr),ia=function(e){function t(){return _classCallCheck(this,t),n.call(this,{widget:na})}_inherits(t,e)
var n=_createSuper(t)
return _createClass(t,[{key:"preview",value:function(e){var t=e.value
return new ea(t)}}]),t}(aa),la=function(){function e(t){_classCallCheck(this,e),this.reference=t}return _createClass(e,[{key:"createPreview",value:function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"large",t=!(arguments.length>1&&void 0!==arguments[1])||arguments[1],n=this.reference.$element.clone(!1,!0)
n.removeClass("large removable small"),n.addClass(e)
var r=n.find(".elementthumb")
if(r.length){var a=r.find("img")[0]
a||((a=document.createElement("img")).srcset=r.attr("data-srcset")||"",r.append(a)),a.sizes="small"===e?"30px":"100px"}return t?'<div class="tcfInstancePreview--thumb '.concat(e,'">').concat(r?r.html():"","</div>"):n[0].outerHTML}},{key:"createSafePreview",value:function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"large",t=!(arguments.length>1&&void 0!==arguments[1])||arguments[1]
return new o.SafeString(this.createPreview(e,t))}},{key:"toHTML",value:function(){return new o.SafeString(this.toString())}},{key:"toString",value:function(){return this.createPreview()}},{key:"asBackground",get:function(){var e=this.reference.$element.find(".elementthumb").attr("data-srcset")
if(!e)return null
var t=e.split(",").pop()
return t?new o.SafeString('<div class="tcfInstancePreview--background" style="background-image: url(\''.concat(t.trim(),'\');"></div><div class="tcfInstancePreview--background blur" style="background-image: url(\'').concat(t.trim(),"');\"></div>")):null}},{key:"asLargeElement",get:function(){return this.createSafePreview("large",!1)}},{key:"asLargeImage",get:function(){return this.createSafePreview("large",!0)}},{key:"asSmallElement",get:function(){return this.createSafePreview("small",!1)}},{key:"asSmallImage",get:function(){return this.createSafePreview("small",!0)}},{key:"label",get:function(){return this.reference.label}}]),e}()
ee([pr],la.prototype,"reference",void 0),ee([mr],la.prototype,"createPreview",null),ee([mr],la.prototype,"createSafePreview",null),ee([pr],la.prototype,"asBackground",null),ee([pr],la.prototype,"asLargeElement",null),ee([pr],la.prototype,"asLargeImage",null),ee([pr],la.prototype,"asSmallElement",null),ee([pr],la.prototype,"asSmallImage",null),ee([pr],la.prototype,"label",null),ee([mr],la.prototype,"toHTML",null),ee([mr],la.prototype,"toString",null)
var oa=function(e){function t(e){return _classCallCheck(this,t),n.call.apply(n,[this].concat(_toConsumableArray(In(e))))}_inherits(t,e)
var n=_createSuper(t)
return _createClass(t,[{key:"toHTML",value:function(){return new o.SafeString('<div class="tcfInstancePreview--elements">'.concat(this.toString(),"</div>"))}},{key:"toString",value:function(){for(var e=[],t=0;t<this.length;t++)e.push(ht(this[t]))
return e.join("")}},{key:"asBackground",get:function(){return this.length?this[0].asBackground:null}},{key:"asLargeElement",get:function(){return this.length?this[0].asLargeElement:null}},{key:"asLargeImage",get:function(){return this.length?this[0].asLargeImage:null}},{key:"asSmallElement",get:function(){return this.length?this[0].asSmallElement:null}},{key:"asSmallImage",get:function(){return this.length?this[0].asSmallImage:null}},{key:"firstLabel",get:function(){return this.length?this[0].label:""}},{key:"label",get:function(){return this.map(function(e){return e.label}).join(", ")}}]),t}(_wrapNativeSuper(Array))
ee([pr],oa.prototype,"asBackground",null),ee([pr],oa.prototype,"asLargeElement",null),ee([pr],oa.prototype,"asLargeImage",null),ee([pr],oa.prototype,"asSmallElement",null),ee([pr],oa.prototype,"asSmallImage",null),ee([pr],oa.prototype,"firstLabel",null),ee([pr],oa.prototype,"label",null),ee([mr],oa.prototype,"toHTML",null),ee([mr],oa.prototype,"toString",null)
var ca=function(e){function t(){return _classCallCheck(this,t),n.call(this,{widget:jn})}_inherits(t,e)
var n=_createSuper(t)
return _createClass(t,[{key:"createValue",value:function(e){return[]}},{key:"isValue",value:function(e,t){return Array.isArray(t)&&t.every(function(e){return"number"==typeof e})}},{key:"preview",value:function(e){return new oa(e)}}]),t}(kr),sa=function(e){function t(){return _classCallCheck(this,t),n.apply(this,arguments)}_inherits(t,e)
var n=_createSuper(t)
return _createClass(t,[{key:"createValue",value:function(e){var t=e.field
return t.defaultValue&&this.isValue(t,t.defaultValue)?t.defaultValue:t.options[0].key}},{key:"isValue",value:function(e,t){return e.options.some(function(e){return e.key==t})}},{key:"preview",value:function(e){var t=e.field,n=e.value,r=t?t.options.find(function(e){return e.key===n}):void 0
return r?r.label:"-"}}]),t}(kr),ua=function(e){function t(){return _classCallCheck(this,t),n.call(this,{widget:An})}_inherits(t,e)
var n=_createSuper(t)
return t}(sa),da=function(e){function n(){var e
return _classCallCheck(this,n),e=r.apply(this,arguments),e.state={isExpanded:!1},e.handleFlyoutClick=function(){e.setState({isExpanded:!1})},e.handleSelect=function(t){e.props.onUpdate(t.key),e.setState({isExpanded:!1})},e.handleSwatchClick=function(t){t.currentTarget===t.target&&e.setState({isExpanded:!0})},e}_inherits(n,e)
var r=_createSuper(n)
return _createClass(n,[{key:"render",value:function(){var e=this.props,n=e.data,r=e.disabled,a=e.field,i=this.state.isExpanded,l=a.options.find(function(e){return e.key===n})
return t.createElement("div",{className:Xn("tcfSwatchColorWidget",{isUndecided:!l}),onClick:r?void 0:this.handleSwatchClick,style:{background:l?Mn(l):void 0}},i&&!r?this.renderFlyout(l):null)}},{key:"renderFlyout",value:function(e){var n=this,r=this.props.field
return t.createElement(Er,{onClick:this.handleFlyoutClick},t.createElement("div",{className:"tcfSwatchColorWidget--swatches"},r.options.map(function(r){return t.createElement("div",{className:Xn("tcfSwatchColorWidget--swatch",{isSelected:r===e}),key:r.key,onClick:function(){return n.handleSelect(r)},style:{background:Mn(r)}})})))}}]),n}(t.Component),fa=function(e){function t(){return _classCallCheck(this,t),n.call(this,{widget:da})}_inherits(t,e)
var n=_createSuper(t)
return t}(sa),ma=function(e){function t(){return _classCallCheck(this,t),n.call(this,{widget:Tn})}_inherits(t,e)
var n=_createSuper(t)
return t}(aa),pa=function(e){function t(){return _classCallCheck(this,t),n.call(this,{widget:Rn})}_inherits(t,e)
var n=_createSuper(t)
return t}(aa)
Fn.initialize({array:new Sr,checkbox:new Nr,color:new Lr,instance:new Vr,lightswitch:new Hr,link:new qr,location:new Qr,number:new Zr,oembed:new Wr,redactor:new ia,reference:new ca,select:new ua,swatchcolor:new fa,text:new ma,textarea:new pa})
var ha=[],va={},ya={create:function(e){try{var l=null,o=document.getElementById(e)
if(!o)throw new Error("Root element not found.")
var c=o.querySelector(".tcfField--app"),s=o.querySelector('script[type="application/json"]'),u=o.querySelector("input.tcfField--model")
if(!u||!c||!s)throw new Error("Missing components.")
var d=a.createStore(pt,Re(s,u),a.applyMiddleware(r))
ha.push(d),d.subscribe(function(){var e=window.draftEditor,t=JSON.stringify(d.getState().model)
u.value!==t&&e&&(l&&window.clearTimeout(l),l=window.setTimeout(function(){e.checkForm(),l=null},500)),u.value=t}),n.render(t.createElement(i.Provider,{store:d},t.createElement(ft,null)),c)}catch(e){console.error("Could not start content editor: "+e.message)}},getInstanceApi:function(e){var t,n=_createForOfIteratorHelper(ha)
try{for(n.s();!(t=n.n()).done;){var r=t.value,a=m(r.getState(),e)
return a?we(r,a):null}}catch(e){n.e(e)}finally{n.f()}},getValidator:function(e){return e in va?va[e]:null},registerValidator:function(e,t){va[e]=t}}
return ya}(_babelPolyfill,React,ReactDOM,ReduxThunk,Redux,ReactRedux,jQuery,Handlebars,ReactDnDHTML5Backend,ReactDnD)
