!function(e){function t(t){for(var s,i,l=t[0],o=t[1],c=t[2],d=0,m=[];d<l.length;d++)i=l[d],Object.prototype.hasOwnProperty.call(a,i)&&a[i]&&m.push(a[i][0]),a[i]=0
for(s in o)Object.prototype.hasOwnProperty.call(o,s)&&(e[s]=o[s])
for(u&&u(t);m.length;)m.shift()()
return r.push.apply(r,c||[]),n()}function n(){for(var e,t=0;t<r.length;t++){for(var n=r[t],s=!0,l=1;l<n.length;l++){var o=n[l]
0!==a[o]&&(s=!1)}s&&(r.splice(t--,1),e=i(i.s=n[0]))}return e}var s={},a={0:0},r=[]
function i(t){if(s[t])return s[t].exports
var n=s[t]={i:t,l:!1,exports:{}}
return e[t].call(n.exports,n,n.exports,i),n.l=!0,n.exports}i.m=e,i.c=s,i.d=function(e,t,n){i.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:n})},i.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},i.t=function(e,t){if(1&t&&(e=i(e)),8&t)return e
if(4&t&&"object"==typeof e&&e&&e.__esModule)return e
var n=Object.create(null)
if(i.r(n),Object.defineProperty(n,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var s in e)i.d(n,s,function(t){return e[t]}.bind(null,s))
return n},i.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e}
return i.d(t,"a",t),t},i.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},i.p=""
var l=window.contentFieldJsonp=window.contentFieldJsonp||[],o=l.push.bind(l)
l.push=t,l=l.slice()
for(var c=0;c<l.length;c++)t(l[c])
var u=o
r.push([116,1]),n()}(Array(31).concat([function(e,t,n){},function(e,t,n){},,,function(e,t){e.exports=jQuery},,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,function(e,t,n){},function(e,t,n){},function(e,t,n){},function(e,t,n){},function(e,t,n){},function(e,t,n){},function(e,t,n){},function(e,t,n){},function(e,t,n){},function(e,t,n){},function(e,t,n){},function(e,t,n){},function(e,t,n){},,function(e,t,n){},function(e,t,n){},function(e,t,n){},function(e,t,n){},function(e,t,n){},function(e,t,n){},function(e,t,n){},function(e,t,n){},function(e,t,n){},function(e,t,n){},function(e,t,n){},function(e,t,n){},function(e,t,n){},function(e,t,n){},function(e,t,n){},function(e,t,n){},function(e,t,n){},function(e,t,n){},function(e,t,n){},function(e,t,n){},function(e,t,n){},function(e,t,n){},function(e,t,n){},function(e,t,n){},function(e,t,n){},function(e,t,n){},function(e,t,n){},function(e,t,n){},function(e,t,n){},function(e,t,n){},function(e,t,n){},function(e,t,n){"use strict"
function s(e,t,n){t.classList.toggle("tcfDetailsToggle--collapsed",e.isCollapsed),n.classList.toggle("focus",e.isCollapsed)}!function(){const e=function(){try{let t=JSON.parse(sessionStorage.getItem("tcfDetailsToggleState")||"{}")
if("object"!=typeof(e=t)||"boolean"!=typeof e.isCollapsed)throw new Error("Invalid details state.")
return t}catch(e){return{isCollapsed:!1}}var e}(),t=document.getElementById("main-content")
if(!t)return
const n=document.createElement("div")
n.className="tcfDetailsToggle btn",n.innerHTML='<div class="tcfIcon craft">general</div>',n.addEventListener("click",()=>{e.isCollapsed=!e.isCollapsed,function(e){sessionStorage.setItem("tcfDetailsToggleState",JSON.stringify(e))}(e),s(e,t,n)}),t.insertBefore(n,t.firstElementChild),s(e,t,n)}()},function(e,t,n){},function(e,t,n){"use strict"
n.r(t)
var s=n(0),a=n(11),r=n(33),i=n(9),l=n(4)
function o(e,t){const n=e.schemas[t.__type]
if(!n)throw new Error(`Could not resolve schema "${t.__type}".`)
return n}function c(e){return e&&"object"==typeof e&&"__type"in e&&"__uuid"in e}function u(e,t){return function e(t,n,s){if(c(s)&&s.__uuid===n)return{model:s,path:[],uuid:n}
const a=o(t,s)
for(const r of Object.keys(a.fields)){const i=a.fields[r]
if("array"===i.type&&"instance"===i.member.type){const a=s[r]
if(!Array.isArray(a))continue
for(let s=0;s<a.length;s++){const i=e(t,n,a[s])
if(null!==i)return i.path.unshift({type:"index",name:r,index:s}),i}}else if("instance"===i.type){const a=e(t,n,s[r])
if(null!==a)return a.path.unshift({type:"property",name:r}),a}else if("layout"===i.type){const{columns:a}=s[r]
for(let s=0;s<a.length;s++){const i=e(t,n,a[s])
if(null!==i)return i.path.unshift({type:"property",name:r},{type:"index",name:"columns",index:s}),i}}}return null}(e,t,e.model)}function d(e){const t=[]
let n=e
for(;n.length;){const s=/^([^\[\.]+)(?:\[(\d+)\])?\.?/.exec(n)
if(!s)throw new Error(`Invalid path segment "${n}" in path "${e}".`)
n=n.substr(s[0].length),3===s.length?t.push({index:parseInt(s[1]),name:s[2],type:"index"}):t.push({name:s[1],type:"property"})}return t}function m(e,t){if(!(t.name in e))return null
const n=e[t.name]
return"index"===t.type?!Array.isArray(n)||t.index<0||t.index>=n.length?null:n[t.index]:n}function h(e,t){"string"==typeof t&&(t=d(t))
let n=e
for(let e=0;e<t.length;e++)if(n=m(n,t[e]),!n)return null
return c(n)?n:null}function p(e,t){const n=(t="string"==typeof t?d(t):t.slice()).pop()
if(!n)return null
const s=h(e.model,t)
if(!s)throw new Error("Could not resolve owner")
const a=o(e,s),r="index"===n.type?n.index:void 0,i=a.fields[n.name]
if(!i)throw new Error(`Could not resolve field "${n.name}" on schema "${a.qualifier}".`)
return{field:i,index:r,owner:s,path:t,schema:a}}function f(e,t){return Craft.t("contentfield",e,t)}function g(e){return{references:e,type:"addReferences"}}var b=new class{initialize(e){this.definitions=e}createValue(e){return this.getDefinition(e.field).createValue(e)}getDefinition(e){return this.definitions["object"==typeof e?e.type:e]}}
function y(){return"10000000-1000-4000-8000-100000000000".replace(/[018]/g,e=>(e^crypto.getRandomValues(new Uint8Array(1))[0]&15>>e/4).toString(16))}function v({schemas:e,schema:t,oldModel:n}){const s={__errors:{},__type:t.qualifier,__uuid:y(),__visible:!0}
for(const a of Object.keys(t.fields)){const r=t.fields[a],i=b.getDefinition(r)
let l=n&&a in n?n[a]:void 0
void 0!==l&&i.isValue(r,l)||(l=i.createValue({field:r,schemas:e})),s[a]=l}return s}function E(e,t,n){if(!t)return n(e)
const s=e[t.name]
let a
if("index"===t.type){if(!Array.isArray(s))throw new Error("Invalid array access.")
if(t.index<0||t.index>=s.length)throw new Error(`Invalid array index ${t.index}".`)
a=s.slice(),a[t.index]=n(s[t.index])}else{if(Array.isArray(s))throw new Error("Invalid array access.")
a=n(s)}const r=Object.assign({},e)
return r[t.name]=a,r}function w(e,t,n){const s="string"==typeof t?d(t):t.slice()
let a=s.shift()
return E(e,a,(function e(t){return a=s.shift(),a?t?E(t,a,e):t:n(t)}))}function O(e,t){return e.name===t.name&&e.type===t.type&&("index"!==e.type||"index"!==t.type||e.index===t.index)}function C(e){const{sourcePath:t,sourceSegment:n,targetPath:s,targetSegment:a}=e,r=[...s,a]
if(r.length>t.length&&t.every((e,t)=>O(e,r[t]))){const s=r[t.length]
if("index"!=s.type)throw new Error("Path segment type mismatch")
if(s.name==n.name&&s.index>n.index){r[t.length]=Object.assign(Object.assign({},s),{index:s.index-1})
const n=r.pop()
if(!n||"index"!==n.type)throw new Error("Unsupported operation")
return Object.assign(Object.assign({},e),{targetPath:r,targetSegment:n})}}return e}function j(e,t){return e.length===t.length&&e.every((e,n)=>O(e,t[n]))}function S(e,t){const{sourcePath:n,sourceSegment:s,targetPath:a,targetSegment:r}=t,i=[...n,s],l=[...a,r],c=h(e.model,a)
if(!c)return!1
const u=o(e,c).fields[r.name],d=c[r.name]
if(!Array.isArray(d)||!u||"array"!==u.type)return!1
const m=C(t)
if(j(i,l)||j(i,[...m.targetPath,m.targetSegment]))return!1
if(!(j(n,a)&&r.name===s.name)&&u.limit>0&&d.length>=u.limit)return!1
const{member:p}=u,f=b.getDefinition(p.type),g=h(e.model,i)
return f.isValue(p,g)}function x(e){return Object.assign(Object.assign({},e),{type:"moveModel"})}function _(e){return{overlay:e,type:"setOverlay"}}function N(e,t){if(!c(t))return
const n=e.schemas[t.__type]
n&&(t.__errors=Object.keys(n.fields).reduce((e,s)=>{const a=function(e,t,n){const{validatorId:s}=e.fields[n]
if(!s)return null
const a=Es.getValidator(s)
if(!a)return null
const r=[]
return a(n,t[n],r),r}(n,t,s)
return a&&a.length&&(e[s]=a),e},{}))}function k(e,t){return{direction:t,type:"uuidOrder",uuid:e}}function M(e){return{type:"uuidVisibility",uuid:e}}function I(e,t,n){return{path:e,key:t,type:"updateValue",value:n}}function L(e){return{sync:e,type:"updateSync"}}var A=n(1)
function P(e){var{source:t}=e,n=Object(A.c)(e,["source"])
return Object(A.a)(this,void 0,void 0,(function*(){const e=n.schemas[t.__type]
if(!e)throw new Error("Invalid source schema.")
const s={__errors:{},__originalUuid:t.__uuid,__type:e.qualifier,__uuid:y(),__visible:t.__visible}
for(const a of Object.keys(e.fields)){const r=e.fields[a],i=b.getDefinition(r)
s[a]=yield i.cloneValue(Object.assign(Object.assign({},n),{field:r,value:t[a]}))}return s}))}function T(e){var{apiEndpoint:t}=e,n=Object(A.c)(e,["apiEndpoint"])
const s=Object.keys(n).map(e=>`${e}=${encodeURIComponent(n[e])}`).join("&")
return new Promise((e,n)=>{fetch(`${t}&${s}`).then(e=>e.json()).then(t=>{!function(e){return"object"==typeof e&&"object"==typeof e.data&&!0===e.result&&Array.isArray(e.references)}(t)?n(t&&t.message?""+t.message:"An unknown error has occured."):e(t)}).catch(e=>{n(""+e)})})}function R(e){return c(e)?`[${e.__type}, ${e.__uuid}]`:"[no model]"}const U={group:console.groupCollapsed,groupEnd:console.groupEnd,info:console.info,model:R},F={group(){},groupEnd(){},info(){},model:R}
function D(e){return e&&e.verbose?U:F}function V(e){if(!Array.isArray(e))return[]
const t=[]
for(const n of e)c(n)&&t.push(n)
return t}function W(e,t){const n=null!==e.__originalUuid,s=null!==t.__originalUuid
return e.__uuid===t.__uuid||s&&e.__uuid===t.__originalUuid||n&&e.__originalUuid===t.__uuid||n&&s&&e.__originalUuid===t.__originalUuid}function H(e){var{field:t,source:n,target:s}=e,a=Object(A.c)(e,["field","source","target"])
return Object(A.a)(this,void 0,void 0,(function*(){if("instance"!==t.member.type)return n||[]
const e=V(n),r=V(s),i=D(a),l=[]
for(const t of e){const e=r.findIndex(e=>W(e,t))
let n
if(-1===e)i.info("No array match for "+i.model(t)),n=yield P(Object.assign(Object.assign({},a),{source:t}))
else{const s=r[e]
i.info(`Array match for ${i.model(t)} is ${i.model(s)}`),r.splice(e,1),n=yield Y(Object.assign(Object.assign({},a),{source:t,target:s}))}n&&l.push(n)}if("remove"!==a.arrayOrphanMode)for(const e of r)"hide"===a.arrayOrphanMode?l.push(Object.assign(Object.assign({},e),{__visible:!1})):l.push(e)
return l}))}function B(e,t,n,s){const{key:a}=e.breakpoints[0]
return{__errors:{},__role:"layoutColumn",__type:e.columnTypeQualifier,__uuid:y(),__visible:!0,offset:n?Object.assign({},n.offset):{[a]:0},order:n?Object.assign({},n.order):{[a]:0},value:s||z(e,t),width:n?Object.assign({},n.width):{[a]:e.constraints.minColumnWidth}}}function z(e,t){const n=X(e,t)
return b.getDefinition(n).createValue({field:n,schemas:t})}function q(e,{breakpoints:t,current:n}){for(let s=n.index;s>=0;s--){const{key:n}=t[s]
if(n in e)return e[n]}return 0}function X(e,t){return t[e.columnTypeQualifier].fields.value}function J(e,t,n){const{current:s}=n
return function(e,t,{breakpoints:n}){let s=NaN
return n.reduce((n,{key:a})=>{let r=isNaN(s)?t:s
return a in e&&(r=e[a]),r!==s&&(s=r,n[a]=r),n},{})}(Object.assign(Object.assign({},e),{[s.key]:t}),0,n)}function K(e){return"object"==typeof e&&"__uuid"in e&&"__role"in e&&"layout"===e.__role}function G(e){var{field:t,source:n,target:s}=e,a=Object(A.c)(e,["field","source","target"])
return Object(A.a)(this,void 0,void 0,(function*(){const e=D(a)
if(!K(n))return e.info("No source, skipping "+t.name),s
if(!K(s))return s?e.info("Type missmatch, cloning "+t.name):e.info("No target, cloning "+t.name),function(e){var{source:t}=e,n=Object(A.c)(e,["source"])
return Object(A.a)(this,void 0,void 0,(function*(){const e=[]
for(let s=0;s<t.columns.length;s++){const a=t.columns[s],r=yield P(Object.assign(Object.assign({},n),{source:a}))
e.push(Object.assign(Object.assign({},r),{__role:"layoutColumn",offset:Object.assign({},a.offset),order:Object.assign({},a.order),width:Object.assign({},a.width)}))}return{__role:"layout",__uuid:y(),columns:e,preset:t.preset}}))}(Object.assign(Object.assign({},a),{source:n}))
e.group("Syncing layouts "+t.name)
const r=[]
for(let e=0;e<n.columns.length;e++){const t=n.columns[e],i=yield Y(Object.assign(Object.assign({},a),{source:t,target:s.columns[e]}))
r.push(Object.assign(Object.assign({},i),{__role:"layoutColumn",offset:Object.assign({},t.offset),order:Object.assign({},t.order),width:Object.assign({},t.width)}))}return e.groupEnd(),Object.assign(Object.assign({},s),{columns:r,preset:n.preset})}))}function Y(e){var{source:t,target:n}=e,s=Object(A.c)(e,["source","target"])
return Object(A.a)(this,void 0,void 0,(function*(){const e=D(s)
if(!c(t))return e.info("No source, skipping "+e.model(n)),n
if(!c(n)||n.__type!==t.__type)return n?e.info("Type missmatch, cloning "+e.model(t)):e.info("No target, cloning "+e.model(t)),P(Object.assign(Object.assign({},s),{source:t}))
const a=s.schemas[t.__type]
if(!a)throw new Error("Invalid schema")
const r=Object.assign({},n)
e.group(`Syncing model ${e.model(t)} > ${e.model(n)}`)
for(const i of Object.keys(a.fields)){const l=a.fields[i]
"layout"===l.type?(e.group("Layout "+i),r[i]=yield G(Object.assign(Object.assign({},s),{field:l,source:t[i],target:n[i]})),e.groupEnd()):"array"===l.type?(e.group("Array "+i),r[i]=yield H(Object.assign(Object.assign({},s),{field:l,source:t[i],target:n[i]})),e.groupEnd()):"instance"===l.type&&(e.group("Instance "+i),r[i]=yield Y(Object.assign(Object.assign({},s),{source:t[i],target:n[i]})),e.groupEnd())}return e.groupEnd(),r}))}function Q(e){return(t,n)=>Object(A.a)(this,void 0,void 0,(function*(){try{yield function(e,t,n){var{siteId:s}=e,a=Object(A.c)(e,["siteId"])
return Object(A.a)(this,void 0,void 0,(function*(){t(L({status:"working"}))
const{config:e,model:r,schemas:i}=n()
if("number"!=typeof e.elementId)throw new Error("Entry must be saved before it can be synchronized.")
const{data:l,references:o}=yield T({apiEndpoint:e.apiEndpoints.fetchSite,elementId:e.elementId,fieldHandle:e.fieldHandle,siteId:s})
if(!c(l)||!e.rootSchemas.some(e=>e===l.__type))throw new Error("Selected target site does not contain a valid model.")
const u=!c(r)||r.__type!==l.__type?yield P(Object.assign(Object.assign({},a),{schemas:i,source:l})):yield Y(Object.assign(Object.assign({},a),{schemas:i,source:l,target:r}))
t(g(o)),t(I([],void 0,u)),t(L({status:"finished"}))}))}(e,t,n)}catch(e){t(L({status:"error",message:""+e}))}}))}const Z={addReferences:function(e,t){const n=e.config.references.slice(),s=document.createElement("div")
for(const e of t.references)if(!n.some(({id:t,type:n})=>e.id===t&&e.type===n)){s.innerHTML=e.element
const t=s.firstElementChild
t&&(t.removeAttribute("style"),e.element=t.outerHTML),e.$element=$(e.element),e.hasThumb=e.$element.hasClass("hasthumb"),n.push(e)}return Object.assign(Object.assign({},e),{config:Object.assign(Object.assign({},e.config),{references:n})})},changeType:function(e,{expandedState:t,newType:n,path:s}){const a=e.schemas[n]
if(!a)return e
const r=h(e.model,s),i=v({oldModel:r,schema:a,schemas:e.schemas})
return r&&t&&t.isExpanded(r.__uuid)&&(t.toggleExpanded(r.__uuid,!1),t.toggleExpanded(i.__uuid,!0)),Object.assign(Object.assign({},e),{model:w(e.model,s,()=>i)})},moveModel:function(e,t){let{model:n}=e
if(!S(e,t))throw new Error("Invalid operation")
const{sourcePath:s,sourceSegment:a,targetPath:r,targetSegment:i}=C(t),l=h(n,[...s,a])
return n=w(n,s,e=>{if(!e)throw new Error("Invalid operation")
let t=e[a.name]
if(!Array.isArray(t))throw new Error("Invalid operation")
return t=t.slice(),t.splice(a.index,1),Object.assign(Object.assign({},e),{[a.name]:t})}),n=w(n,r,e=>{if(!e)throw new Error("Could not find target")
let t=e[i.name]
if(!Array.isArray(t))throw new Error("Unsupported operation")
return t=t.slice(),i.index>=t.length?t.push(l):t.splice(i.index,0,l),Object.assign(Object.assign({},e),{[i.name]:t})}),Object.assign(Object.assign({},e),{model:n})},setOverlay:function(e,{overlay:t}){return Object.assign(Object.assign({},e),{overlay:t})},setUser:function(e,{user:t}){const n=Object.assign(Object.assign({},e.user),t)
try{window.localStorage.setItem("tcfUserState",JSON.stringify(n))}catch(e){console.error(e)}return Object.assign(Object.assign({},e),{user:n})},uuidInsert:function(e,{position:t,uuid:n,value:s}){const a=u(e,n)
if(!a)return e
const r=p(e,a.path)
if(!r||"array"!==r.field.type||void 0===r.index)return e
const{field:i,index:l,path:o}=r,{name:c}=i
return Object.assign(Object.assign({},e),{model:w(e.model,o,n=>{if(!n||!(c in n))return n
const a=n[c]
if(!Array.isArray(a))return n
const r=[...a],i=l+("after"===t?1:0)
r.splice(i,0,s)
const o=Object.assign(Object.assign({},n),{[c]:r})
return N(e,o),o})})},uuidOrder:function(e,{direction:t,uuid:n}){const s=u(e,n)
if(!s)return e
const a=p(e,s.path)
if(!a||"array"!==a.field.type||void 0===a.index)return e
const{field:r,index:i,path:l}=a,{name:o}=r
return Object.assign(Object.assign({},e),{model:w(e.model,l,n=>{if(!n||!(o in n))return n
const s=n[o]
if(!Array.isArray(s))return n
const a=i+("up"===t?-1:1),r=[...s],l=r.splice(i,1)
r.splice(a,0,...l)
const c=Object.assign(Object.assign({},n),{[o]:r})
return N(e,c),c})})},uuidRemove:function(e,{uuid:t}){const n=u(e,t)
if(!n)return e
const s=p(e,n.path)
if(!s||"array"!==s.field.type||void 0===s.index)return e
const{field:a,index:r,path:i}=s,{name:l}=a
return Object.assign(Object.assign({},e),{model:w(e.model,i,t=>{if(!t||!(l in t))return t
const n=t[l]
if(!Array.isArray(n))return t
const s=[...n]
s.splice(r,1)
const a=Object.assign(Object.assign({},t),{[l]:s})
return N(e,a),a})})},uuidVisibility:function(e,{uuid:t}){const n=u(e,t)
return n?Object.assign(Object.assign({},e),{model:w(e.model,n.path,e=>e?Object.assign(Object.assign({},e),{__visible:!e.__visible}):e)}):e},updateSync:function(e,{sync:t}){let{overlay:n}=e
return n&&"synchronize"===n.type&&(n=Object.assign(Object.assign({},n),{preventClose:"working"===t.status})),Object.assign(Object.assign({},e),{overlay:n,sync:t})},updateValue:function(e,{path:t,key:n,value:s}){return Object.assign(Object.assign({},e),{model:w(e.model,t,t=>{const a=n?Object.assign(Object.assign({},t),{[n]:s}):s
return N(e,a),a})})}}
const ee=[function({location:{uuid:e},owner:t}){return t&&"array"===t.field.type?{group:te.Manipulation,icon:"material:add",id:"create",invoke:(t,n=!1)=>{t(_({afterCreate:n?"layer":"expand",type:"create",uuid:e}))},label:f("Create")}:null},function({location:{uuid:e}}){return{group:te.Manipulation,icon:"material:edit",id:"edit",invoke:t=>{t(_({type:"edit",uuid:e}))},label:f("Edit")}},function({owner:e,location:{uuid:t}}){return e&&"array"===e.field.type?{group:te.Manipulation,icon:"material:delete",id:"delete",invoke:e=>{e(function(e){return{type:"uuidRemove",uuid:e}}(t))},label:f("Delete")}:null},function({location:{uuid:e,model:{__visible:t}}}){return{group:te.Visibility,icon:t?"material:visibility_off":"material:visibility",id:"visibility",invoke:t=>{t(M(e))},label:f(t?"Hide":"Show")}},function({location:{uuid:e},owner:t}){if(!t||"array"!==t.field.type)return null
const n=t.owner[t.field.name]
return!Array.isArray(n)||void 0===t.index||t.index<=0?null:{group:te.Movement,icon:"material:arrow_upward",id:"moveUp",invoke:t=>t(k(e,"up")),label:f("Move up")}},function({location:{uuid:e},owner:t}){if(!t||"array"!==t.field.type)return null
const n=t.owner[t.field.name]
return!Array.isArray(n)||void 0===t.index||t.index>=n.length-1?null:{group:te.Movement,icon:"material:arrow_downward",id:"moveDown",invoke:t=>t(k(e,"down")),label:f("Move down")}},function(){return null},function({owner:e}){return null},function({owner:e}){return null}]
var te
function ne(e,t){const n=u(e,t)
if(!n)return[]
const s={location:n,owner:p(e,n.path),state:e}
return ee.map(e=>e(s)).filter(e=>null!==e)}function se(e,{uuid:t}){let n=null
return{getCommands:()=>ne(e.getState(),t).map(t=>Object.assign(Object.assign({},t),{invoke:()=>t.invoke(e.dispatch,!0)})),subscribe:t=>{n&&n(),n=e.subscribe(t)},unsubscribe:()=>{n&&n(),n=null}}}!function(e){e[e.Manipulation=0]="Manipulation",e[e.Visibility=1]="Visibility",e[e.Movement=2]="Movement",e[e.Clipboard=3]="Clipboard"}(te||(te={}))
var ae,re=n(35),ie=n.n(re),le=n(5),oe=n.n(le)
let ce
!function(e){e[e.Idle=0]="Idle",e[e.Loading=1]="Loading",e[e.Loaded=2]="Loaded"}(ae||(ae={}))
let ue=null,de=ae.Idle
function me(e){return e&&"object"==typeof e&&"__uuid"in e}function he(e,t){if(me(e))return e
const n=function(e){switch(typeof e){case"boolean":return new Boolean(e)
case"number":return new Number(e)
case"object":return e
default:return new String(e)}}(e)
return Object.defineProperty(n,"__uuid",{value:t&&me(t)?t.__uuid:y()}),n}function pe(e){return"string"==typeof e&&""!==e.trim()?oe.a.compile(e):null}function fe(e,t){const n=JSON.parse(e.innerHTML)
n.user=function(){try{const t=window.localStorage.getItem("tcfUserState")
if(null===t)throw new Error("User state missing")
const{favoriteSchemas:n={}}=JSON.parse(t)
return{favoriteSchemas:(e=n,Object.keys(e).reduce((t,n)=>Array.isArray(e[n])?Object.assign(Object.assign({},t),{[n]:e[n]}):t,{}))}}catch(e){}var e
return{favoriteSchemas:{}}}(),n.sync={status:"idle"},n.config.references=n.config.references.map(e=>{const t=ie()(e.element)
return Object.assign(Object.assign({},e),{$element:t,hasThumb:t.hasClass("hasthumb")})})
for(const e of Object.keys(n.schemas)){const t=n.schemas[e]
t.previewTemplate=pe(t.preview),t.previewLabelTemplate=pe(t.previewLabel)||t.previewTemplate}var s
s=n.config.googleMapsApiKey,ce=s
let a=void 0
1===n.config.rootSchemas.length&&(a=n.schemas[n.config.rootSchemas[0]])
try{n.model=function e(t,n,s){const{fields:a}=n[t.__type]
s&&s.uniqueUuids&&(-1===s.uniqueUuids.indexOf(t.__uuid)?s.uniqueUuids.push(t.__uuid):(console.error(`Found duplicate uuid "${t.__uuid}".`),t.__uuid=y()))
for(const r of Object.keys(a)){const i=a[r]
"array"===i.type?t[r]=t[r].map(t=>"instance"===i.member.type?e(t,n,s):he(t)):"instance"===i.type&&(t[r]=e(t[r],n,s))}return t}(JSON.parse(t.value),n.schemas,{uniqueUuids:[]})}catch(e){}return!a||c(n.model)&&n.model.__type===a.qualifier||(n.model=v({oldModel:n.model,schema:a,schemas:n.schemas})),n}var ge=n(37),be=n(118),ye=n(2),ve=n.n(ye)
n(69)
function Ee(e){var{children:t,className:n,outline:a,secondary:r}=e,i=Object(A.c)(e,["children","className","outline","secondary"])
return s.createElement("div",Object.assign({},i,{className:ve()("tcfButtonFlat",n,{outline:a,secondary:r})}),t)}const we=s.createContext({expanded:[],isExpanded:()=>!1,toggleExpanded:function(){}})
function Oe({children:e}){const[t,n]=s.useState([])
return s.createElement(we.Provider,{value:{expanded:t,isExpanded:e=>-1!==t.indexOf(e),toggleExpanded:(e,s)=>{let a=[...t]
void 0===s&&(s=-1===t.indexOf(e)),s?a.push(e):a=a.filter(t=>t!==e),n(a)}}},e)}n(70)
function Ce({children:e,disabled:t,onClick:n,primary:a,secondary:r}){return s.createElement("div",{className:ve()("tcfButton btn",{disabled:t,submit:a,secondary:r}),onClick:e=>{e.preventDefault(),t||n(e)}},e)}function je({className:e,params:t,value:n}){return s.createElement("span",{className:e},f(n,t))}function Se({children:e,className:t}){return s.createElement("div",{className:ve()("tcfWindow--content",t)},e)}function xe({children:e,className:t,flex:n=!0}){return s.createElement("div",{className:ve()("tcfWindow--footer flex-nowrap",t,{flex:n})},e)}var _e
n(71)
function Ne({children:e,className:t,width:n}){return s.createElement("div",{className:ve()("tcfWindow",t),style:{width:n}},e)}(_e=Ne||(Ne={})).Content=Se,_e.Footer=xe
var ke=Ne
function Me({onClose:e}){return s.createElement(ke,{width:600},s.createElement(ke.Content,null,s.createElement(je,{value:"Cannot create an element at the given location."})),s.createElement(ke.Footer,null,s.createElement(Ce,{onClick:e,secondary:!0},s.createElement(je,{value:"Cancel"}))))}n(72)
function Ie({children:e,isBorderless:t,label:n,style:a}){return n&&""!==n&&"toolbar"!==n?s.createElement("div",{className:"tcfFieldGroup",style:a},s.createElement("div",{className:"tcfFieldGroup--label"},n),s.createElement("div",{className:"tcfFieldGroup--content"},e)):s.createElement("div",{className:ve()("tcfFieldGroup--content",{isBorderless:t}),style:a},e)}n(73)
function Le({children:e,className:t,errors:n,instructions:a,isPlainField:r,isRequired:i,label:l,style:o}){if(r)return s.createElement(s.Fragment,null,e)
const c=n&&n.length
return s.createElement("div",{className:ve()("tcfFieldPanel",t),style:o},s.createElement("div",{className:ve()("tcfFieldPanel--label",{hasErrors:c,isRequired:i})},l),a?s.createElement("div",{className:"tcfFieldPanel--instructions"},a):null,n&&n.length?s.createElement("ul",{className:"tcfFieldPanel--errors"},n.map((e,t)=>s.createElement("li",{className:"tcfFieldPanel--error",key:t},e))):null,e)}n(74)
function Ae(e,t){return e.label.localeCompare(t.label)}function Pe({allowUndecided:e,disabled:t=!1,options:n,value:a,onChange:r}){const i=n.findIndex(e=>e.key==a),l=e||-1===i
return s.createElement("div",{className:"tcfSelect"},s.createElement("select",{className:"tcfSelect--select",disabled:t,value:-1==i?void 0:i,onChange:t?void 0:function(t){let s=t.target.selectedIndex,a=null
l&&(s-=1),s>=0&&s<n.length&&(a=n[s].key),(null!==a||e)&&r(a)}},l?s.createElement("option",null,"(None)"):null,n.map((e,t)=>s.createElement("option",{key:t,value:t},e.indent?"--".repeat(e.indent)+" ":null,e.label))))}const Te=[{key:"before",label:"Before selected element"},{key:"after",label:"After selected element"}]
function Re({Factory:e,field:t,onCreate:n,scope:a}){const[r,i]=s.useState("before")
return s.createElement(ke,{width:600},s.createElement(ke.Content,null,s.createElement(Ie,null,s.createElement(Le,{instructions:f("Select where the new element should be inserted."),label:f("Position")},s.createElement(Pe,{onChange:i,options:Te.map(e=>Object.assign(Object.assign({},e),{label:f(e.label)})),value:r})))),s.createElement(ke.Footer,{flex:!1},s.createElement(e,{field:t,onCreate:e=>n(e,r),scope:a})))}function Ue({afterCreate:e="expand",uuid:t}){const n=Object(l.c)(),a=s.useContext(we),r=Object(l.d)(e=>{const n=u(e,t)
if(!n||!n.path.length)return null
const s=p(e,n.path)
return s&&"array"===s.field.type&&void 0!==s.index?{field:s.field,model:s.owner}:null})
if(null===r)return s.createElement(Me,{onClose:function(){n(_(null))}})
const{field:i,model:o}=r,{factory:d}=b.getDefinition(i.member.type)
return s.createElement(Re,{Factory:d,field:i.member,onCreate:function(s,r){let i=null
c(s)&&("expand"===e?a.toggleExpanded(s.__uuid,!0):i={type:"edit",uuid:s.__uuid}),n(function(e,t,n){return{position:n,type:"uuidInsert",uuid:e,value:t}}(t,s,r)),n(_(i))},scope:o.__type})}function Fe(e){const{field:t}=e,{widget:n}=b.getDefinition(t)
return s.createElement(n,e)}function $e(e,t){if(t)switch(e){case 0:return t.small
case 2:return t.large
default:return t.medium}}const De=s.createContext(2)
function Ve(e){var{children:t}=e,n=Object(A.c)(e,["children"])
const[a,r]=s.useState(2),i=s.useRef(null)
return s.useEffect(()=>{const{ResizeObserver:e}=window,{current:t}=i
let n=-1,s=0
if(!t)return
const a=()=>{const e=t.offsetWidth
e!==s&&(s=e,r(s>920?2:s>580?1:0))}
if(e){const n=new e(a)
return n.observe(t),()=>n.unobserve(t)}{const e=()=>{n=window.requestAnimationFrame(e),a()}
return e(),()=>window.cancelAnimationFrame(n)}},[]),s.createElement("div",Object.assign({ref:i},n),s.createElement(De.Provider,{value:a},t))}n(75)
function We(e,t){return e.index-t.index}var He=Object(l.b)((e,t)=>({schema:e.schemas[t.model.__type]}),(e,t)=>({onUpdate:(n,s)=>{e(I(t.path,n,s))}}))((function({disabled:e=!1,isBorderless:t,model:n,onUpdate:a,path:r,schema:i}){const l=s.useContext(De)
if(!i)return s.createElement("div",null,`Could not resolve schema for "${n.__type}"`)
const o=[],c=Object.keys(i.fields)
let u=void 0
if(0===c.length)return s.createElement("div",{className:"tcfInstanceForm--empty"},s.createElement(je,{value:"This element has no properties."}))
for(const d of c){const c=i.fields[d],m=n.__errors[d]||null,{isAlwaysPlainField:h}=b.getDefinition(c)
if(!u||c.group){const e=c.group?c.group.label:void 0,t=c.group?$e(l,c.group.style):void 0
u={index:"toolbar"===e?-1:o.length,label:e,fields:[],style:t},o.push(u)}u.fields.push(s.createElement(Le,{errors:m,instructions:c.instructions,isPlainField:t||h,isRequired:c.isRequired,key:c.name,label:c.label,style:$e(l,c.style)},s.createElement(Fe,{data:n[c.name],disabled:e,errors:m,field:c,model:n,onUpdate:e=>a(d,e),path:r})))}const d=o.sort(We).map(e=>s.createElement(Ie,{isBorderless:t,key:e.index,label:e.label,style:e.style},e.fields)),m=$e(l,i.style)
return m?s.createElement("div",{className:"tcfInstanceForm",style:m},d):s.createElement(s.Fragment,null,d)}))
class Be extends s.Component{constructor(e){super(e),this.originalModel=null,this.handleCancel=()=>{this.close()},this.handleApply=()=>{this.close()},this.originalModel=e.model}close(){this.props.setOverlay(null)}render(){const{model:e,path:t}=this.props
return s.createElement(Oe,null,s.createElement(ke,null,s.createElement(ke.Content,null,s.createElement(He,{model:e,path:t})),s.createElement(ke.Footer,null,s.createElement(Ce,{onClick:this.handleApply},s.createElement(je,{value:"Apply"})))))}}var ze=Object(l.b)((e,t)=>u(e,t.uuid),e=>({setOverlay:t=>e(_(t))}))(Be)
n(76)
function qe({className:e,name:t,size:n}){let a="craft"
return t.startsWith("material:")?(a="material",t=t.substr("material:".length)):t.startsWith("craft:")&&(t=t.substr("craft:".length)),s.createElement("div",{className:ve()("tcfIcon",e,a,n)},t)}function Xe({message:e,onClose:t}){return s.createElement(s.Fragment,null,s.createElement(ke.Content,null,s.createElement("div",{className:"tcfSynchronize--message"},s.createElement(qe,{className:"tcfSynchronize--messageIcon error",name:"material:error",size:"huge"}),s.createElement("div",{className:"tcfSynchronize--title"},"An error has occured"),e?s.createElement("div",{className:"tcfSynchronize--message"},e):null)),s.createElement(ke.Footer,null,s.createElement(Ce,{onClick:t},"Close")))}function Je({onClose:e}){return s.createElement(s.Fragment,null,s.createElement(ke.Content,null,s.createElement("div",{className:"tcfSynchronize--message"},s.createElement(qe,{className:"tcfSynchronize--messageIcon finished",name:"material:check_circle",size:"huge"}),s.createElement("div",{className:"tcfSynchronize--title"},s.createElement(je,{value:"Sites have been synchronized"})),s.createElement("div",{className:"tcfSynchronize--message"},s.createElement(je,{value:"If you are not happy with the results, do not save the entry. Reload this page to revert all changes."})))),s.createElement(ke.Footer,null,s.createElement(Ce,{onClick:e},s.createElement(je,{value:"Close"}))))}class Ke extends s.Component{constructor(){super(...arguments),this.element=null,this.lightswitch=null,this.handleChange=()=>{const{disabled:e,onChange:t}=this.props,{lightswitch:n}=this
!e&&n&&t(n.on)},this.setElement=e=>{this.element!==e&&(this.element=e,this.updateInstance())}}componentDidUpdate(e){const{value:t}=this.props,{lightswitch:n}=this
e.disabled!==this.props.disabled?this.updateInstance():n&&n.on!==t&&n.toggle()}render(){const{className:e,disabled:t,small:n,value:a}=this.props
return s.createElement("div",null,s.createElement("div",{className:ve()("lightswitch",e,{disabled:t,on:a,small:n}),ref:this.setElement,tabIndex:0},s.createElement("div",{className:"lightswitch-container"},s.createElement("div",{className:"label on"}),s.createElement("div",{className:"handle"}),s.createElement("div",{className:"label off"}))))}updateInstance(){const{element:e,handleChange:t,lightswitch:n}=this,{disabled:s,value:a}=this.props
n&&(n.destroy(),this.lightswitch=null),!s&&e&&(this.lightswitch=new Craft.LightSwitch(e,{onChange:t,value:a}))}}class Ge extends s.Component{constructor(e){super(e),this.handleApply=e=>{const{currentSite:t,endpoint:n}=this.props,{arrayOrphanMode:s,site:a,useTranslator:r}=this.state
if(!a)return
let i
r&&t&&a.language!==t.language&&(i={endpoint:n,source:a.language,target:t.language}),this.props.onSynchronize({arrayOrphanMode:s,siteId:a.id,translate:i,verbose:"altKey"in e&&e.altKey})},this.handleArrayOrphanModeChange=e=>{this.setState({arrayOrphanMode:e})},this.handleSiteChange=e=>{this.setState({site:e})},this.handleToggleTranslator=e=>{this.setState({useTranslator:e})},this.state={arrayOrphanMode:"hide",site:e.availableSites[0]||null,useTranslator:!1}}render(){const{availableSites:e,currentSite:t,hasTranslator:n,onClose:a}=this.props,{arrayOrphanMode:r,site:i,useTranslator:l}=this.state,o=e.map(e=>({label:e.label,key:e}))
return s.createElement(s.Fragment,null,s.createElement(ke.Content,null,s.createElement("div",{className:"tcfSynchronize--title"},s.createElement(je,{value:"Synchronize translations"})),s.createElement(Ie,null,s.createElement(Le,{instructions:f("Select the site the content should be copied from."),label:f("Site")},s.createElement(Pe,{onChange:this.handleSiteChange,options:o,value:i})),s.createElement(Le,{instructions:f("Defines what happens to elements that do not exist in the selected language."),label:f("Orphaned elements")},s.createElement(Pe,{onChange:this.handleArrayOrphanModeChange,options:[{key:"hide",label:f("Hide orphaned elements")},{key:"none",label:f("Do nothing")},{key:"remove",label:f("Remove orphaned elements")}],value:r})),i&&t&&i.language!==t.language?s.createElement(Le,{instructions:f(n?"Uses a webservice to automatically translate texts.":"A matching webservice must be configured in the options of this field in order to use this feature."),label:f("Translate texts automatically")},s.createElement(Ke,{disabled:!n,onChange:this.handleToggleTranslator,value:l})):null)),s.createElement(ke.Footer,null,s.createElement(Ce,{onClick:a,secondary:!0},s.createElement(je,{value:"Cancel"})),s.createElement(Ce,{onClick:this.handleApply,primary:!0},s.createElement(je,{value:"Apply"}))))}}var Ye=Object(l.b)(e=>{const{apiEndpoints:t,elementSiteId:n,hasTranslator:s,supportedSites:a}=e.config
return{availableSites:a.filter(e=>e.id!==n),currentSite:a.find(e=>e.id===n),endpoint:t.translate,hasTranslator:s}},e=>({onSynchronize:t=>e(Q(t))}))(Ge)
n(77)
function Qe(){return s.createElement("div",{className:"tcfActivityIndicator"},s.createElement("div",{className:"tcfActivityIndicator--bounce first"}),s.createElement("div",{className:"tcfActivityIndicator--bounce second"}),s.createElement("div",{className:"tcfActivityIndicator--bounce third"}))}function Ze(){return s.createElement(ke.Content,null,s.createElement("div",{className:"tcfSynchronize--working"},s.createElement(Qe,null)))}n(78)
function et(){const e=Object(l.d)(e=>e.sync),t=Object(l.c)(),n=()=>t(_(null))
let a
return a="working"===e.status?s.createElement(Ze,null):"error"===e.status?s.createElement(Xe,{message:e.message,onClose:n}):"finished"===e.status?s.createElement(Je,{onClose:n}):s.createElement(Ye,{onClose:n}),s.createElement(ke,{width:600},a)}const tt=s.createContext(0)
function nt({children:e}){const t=s.useContext(tt)
return s.createElement(tt.Provider,{value:t+1},e)}function st({disabled:e,dispatch:t,model:n,path:a,schemas:r}){const i=s.useContext(we),l=r.map(({qualifier:e,label:t})=>({key:e,label:t}))
return l.sort(Ae),s.createElement(Le,{className:"tcfInstance--controlsSchema",label:"Type"},s.createElement(Pe,{disabled:e,onChange:e=>t(function(e,t,n){return{expandedState:n,newType:t,path:e,type:"changeType"}}(a,e,i)),options:l,value:n?n.__type:null}))}function at({disabled:e,dispatch:t,model:n}){const a=n.__visible?"material:visibility":"material:visibility_off",r=s.createElement(s.Fragment,null,s.createElement(je,{value:"Visibility"}),s.createElement(qe,{className:ve()("tcfInstance--controlsVisibilityIcon",{off:!n.__visible}),name:a}))
return s.createElement(Le,{label:r,className:"tcfInstance--controlsVisibility"},s.createElement(Ce,{disabled:e,onClick:()=>t(M(n.__uuid))},s.createElement(je,{value:n.__visible?"Hide":"Show"})))}n(79)
var rt=s.memo((function({canChangeVisibility:e=!1,canChangeType:t=!0,disabled:n=!1,isBorderless:a,model:r,path:i,schemaNames:o}){const u=Object(l.c)(),d=Object(l.d)(e=>o.map(t=>e.schemas[t]))
let m=!1
c(r)&&(m=d.some(e=>e.qualifier===r.__type))
const h=t&&d.length>1,p=e&&m&&!r.__visible
return s.createElement(nt,null,s.createElement(Ve,null,h||p?s.createElement("div",{className:"tcfInstance--controls"},h?s.createElement(st,{disabled:n,dispatch:u,model:m?r:null,path:i,schemas:d}):null,p?s.createElement(at,{disabled:n,dispatch:u,model:r}):null):null,m?s.createElement(He,{disabled:n,model:r,isBorderless:a,path:i}):null))}))
n(80)
class it extends s.Component{constructor(e){super(e),this.element=null,this.handleMouseDown=e=>{const{onClick:t}=this.props
e.target===this.element&&t&&t()}
const t=document.createElement("div")
t.className="tcfOverlay",t.addEventListener("mousedown",this.handleMouseDown),document.body.appendChild(t),this.element=t}componentWillUnmount(){const{element:e}=this
e&&(document.body.removeChild(e),e.removeEventListener("mousedown",this.handleMouseDown),this.element=null)}render(){const{children:e}=this.props,{element:t}=this
return t?Object(a.createPortal)(e,t):null}}n(81)
function lt(){const e=Object(l.c)(),t=Object(l.d)(e=>e.model),n=Object(l.d)(e=>e.overlay),{disabled:a,rootSchemas:r,supportedSites:i}=Object(l.d)(e=>e.config),o=i.length>1
return s.createElement(be.a,{backend:ge.a},s.createElement(Oe,null,o&&!a?s.createElement("div",{className:"tcfRoot--options"},s.createElement(Ee,{onClick:()=>{e(L({status:"idle"})),e(_({type:"synchronize"}))},outline:!0},s.createElement(qe,{name:"material:sync"}),s.createElement(je,{value:"Synchronize translations"}))):null,s.createElement(rt,{disabled:a,model:t,path:[],schemaNames:r}),n?s.createElement(it,{onClick:()=>{n&&!n.preventClose&&e(_(null))}},function(e){if(!e)return null
switch(e.type){case"create":return s.createElement(Ue,Object.assign({},e))
case"edit":return s.createElement(ze,Object.assign({},e))
case"synchronize":return s.createElement(et,null)}}(n)):null))}var ot=function(e={config:{apiEndpoints:{fetchSite:"",oembed:"",translate:""},disabled:!1,elementId:null,elementSiteId:0,fieldHandle:"",hasTranslator:!1,references:[],rootSchemas:[],supportedSites:[]},model:{__errors:{},__type:"unknown",__uuid:"0",__visible:!0},overlay:null,schemas:{},sync:{status:"idle"},user:{favoriteSchemas:{}}},t){return t.type in Z?Z[t.type](e,t):e}
function ct(e){for(;"string"!=typeof e;)e=e.toHTML()
return e}const ut={},dt={},mt=(e,t)=>{ut[String(t)]=!0},ht=(e,t)=>{dt[String(t)]=!0}
function pt(){return{allowedProtoMethods:ut,allowedProtoProperties:dt}}class ft extends Array{constructor(e){super(...function({context:e,field:t,value:n}){if(!t)return[]
const{member:s}=t,a=b.getDefinition(s)
return n.map(t=>a.preview({value:t,field:s,context:e}))}(e))}get asColumn(){return this.toList("flexColumn")}get asList(){return this.toList("")}get asRow(){return this.toList("flexRow")}get first(){return new le.SafeString(this.length?ct(this[0]):"")}get one(){return this.first}toHTML(){return new le.SafeString(this.toString())}toList(e){return new le.SafeString(`<ul class="${e}">${this.map(e=>`<li>${ct(e)}</li>`).join("")}</ul>`)}toString(){return this.map(e=>ct(e)).join("")}}Object(A.b)([ht],ft.prototype,"asColumn",null),Object(A.b)([ht],ft.prototype,"asList",null),Object(A.b)([ht],ft.prototype,"asRow",null),Object(A.b)([ht],ft.prototype,"first",null),Object(A.b)([ht],ft.prototype,"one",null),Object(A.b)([mt],ft.prototype,"toHTML",null),Object(A.b)([mt],ft.prototype,"toList",null),Object(A.b)([mt],ft.prototype,"toString",null)
var gt=n(119)
function bt(e,t){const n={data:e.child,height:100,path:e.path,type:"MEMBER"}
return Object(gt.a)({item:n,begin:()=>({data:e.child,height:t.current?t.current.clientHeight:100,path:e.path,type:"MEMBER"}),canDrag:()=>!e.disabled,collect:e=>({isDragging:e.isDragging()}),isDragging:t=>j(e.path,t.getItem().path)})}var yt=n(120)
function vt(e,t){const n=Object(l.e)()
return Object(yt.a)({accept:"MEMBER",drop:e=>({item:e}),hover:(s,a)=>{if(!a.isOver({shallow:!0}))return
const r=function(e,t,n){const{current:s}=n,a=t.getClientOffset()
if(!s||!a||!e)return null
const{bottom:r,top:i}=s.getBoundingClientRect(),l=a.y-i
return s.classList.contains("isExpanded")&&l>32&&l<r-i-32?null:(l>(r-i)/2&&(e.targetSegment=Object.assign(Object.assign({},e.targetSegment),{index:e.targetSegment.index+1})),e)}(function(e,t){const n=e.path.slice(),s=n.pop()
if(!s||"index"!==s.type)return null
const a=t.path.slice(),r=a.pop()
return r&&"index"===r.type?{sourcePath:a,sourceSegment:r,targetPath:n,targetSegment:s}:null}(e,s),a,t)
if(!r||!S(n.getState(),r))return
const i=x(r),{targetPath:l,targetSegment:o}=C(i)
s.path=[...l,o],n.dispatch(i)}})}n(83)
function Et(e){const{child:t,depth:n,disabled:a,field:r,index:i,model:l,onDelete:o,onUpdate:c,path:u}=e,d=s.useRef(null),[{isDragging:m},h,p]=bt(e,d),[,f]=vt(e,d)
f(d)
return s.createElement("div",{className:ve()("tcfArrayWidgetMember depth-"+n,{isDragging:m}),ref:d},p(s.createElement("div",{className:"tcfArrayWidgetMember--panel tcfArrayWidgetMember--single"},h(s.createElement("div",{className:ve()("tcfArrayWidgetMember--singleHandle",{enabled:!a})},s.createElement(qe,{className:"tcfArrayWidgetMember--singleHandleIcon",key:"handle",name:"move"}))),s.createElement("div",{className:"tcfArrayWidgetMember--singleBody"},s.createElement(Fe,{data:t,disabled:a,errors:[],field:r,model:l,onUpdate:e=>{c(i,e)},path:u})),a?null:s.createElement("div",{className:"tcfArrayWidgetMember--singleActions"},s.createElement("div",{className:"tcfArrayWidgetMember--singleActionsButton",onClick:()=>{o(i)}},s.createElement(qe,{name:"remove"}))))))}function wt(e){const t=s.useRef(null),[,n]=function(e){const t=Object(l.e)()
return Object(yt.a)({accept:"MEMBER",drop:e=>({item:e}),hover:(n,s)=>{if(!s.isOver({shallow:!0}))return
const a=function(e,t){const n=t.path.slice(),s=n.pop()
return s&&"index"===s.type?{sourcePath:n,sourceSegment:s,targetPath:e.path,targetSegment:{type:"index",index:0,name:e.field.name}}:null}(e,n)
if(!a||!S(t.getState(),a))return
const r=x(a),{targetPath:i,targetSegment:l}=C(r)
n.path=[...i,l],t.dispatch(r)}})}(e)
return n(t),s.createElement("div",{className:"tcfArrayWidgetList--empty",key:"empty",ref:t},s.createElement(je,{value:"Drop elements here"}))}n(84)
class Ot extends s.Component{constructor(e){super(e),this.element=null,this.handleAnimationEnd=()=>{const{element:e}=this
e&&(e.style.height="",e.style.transition=""),this.setState({inTransition:!1,lastChildren:null,lastUri:null})},this.setElement=e=>{this.element=e},this.state={currentChildren:e.children,currentUri:e.uri,inTransition:!1,lastChildren:null,lastUri:null}}componentDidUpdate(e,t,n){const{element:s}=this
s&&n&&setTimeout(()=>{s.style.height=""
const e=s.offsetHeight
s.style.height=n.height+"px",s.getBoundingClientRect(),s.style.transition="height 200ms",s.style.height=e+"px"},0)}getSnapshotBeforeUpdate(e,t){const{element:n}=this
if(t.currentUri!==this.state.currentUri&&n){const e=n.offsetHeight
return n.style.height=e+"px",{height:e}}return null}render(){const{className:e,itemClassName:t}=this.props,{currentChildren:n,currentUri:a,inTransition:r,lastChildren:i,lastUri:l}=this.state,o=[]
return r&&l&&o.push(s.createElement("div",{className:ve()(t,"tcfDetailsPanel--item","from"),key:l},i)),o.push(s.createElement("div",{className:ve()(t,"tcfDetailsPanel--item",{to:r}),key:a,onAnimationEnd:this.handleAnimationEnd},n)),s.createElement("div",{className:ve()(e,"tcfDetailsPanel"),ref:this.setElement},o)}static getDerivedStateFromProps(e,t){return e.uri===t.currentUri?Object.assign(Object.assign({},t),{currentChildren:e.children}):e.uri===t.currentUri||t.inTransition?null:{inTransition:!0,lastChildren:t.currentChildren,lastUri:t.currentUri,currentChildren:e.children,currentUri:e.uri}}}n(31)
function Ct({children:e,onClick:t,primary:n}){return s.createElement("div",{className:ve()("tcfArrayWidgetMember--headerActionsButton",{primary:n}),onClick:e=>{e.preventDefault(),t()}},e)}let jt=null
function St(){return null===jt&&(jt=new Craft.ElementThumbLoader),jt}n(85)
function xt({className:e,model:t,schema:n,size:a="small"}){const r=s.useRef(null),i=Object(l.d)(e=>e.config.references),o=function(e,t){const{previewImage:n}=t
if(!n)return null
const s=n in e?e[n]:null
if(!Array.isArray(s)||0===s.length)return null
const a=s[0]
return"number"==typeof a?a:null}(t,n),c=i.find(e=>e.id===o)
return s.useEffect(()=>{if(r.current){const e=$(".element",r.current)
Craft.setElementSize(e,a),St().load(e)}},[r.current,c]),c&&c.hasThumb?s.createElement("div",{className:ve()("tcfInstancePreviewImage",e,a),dangerouslySetInnerHTML:{__html:c.element},ref:r}):s.createElement("div",{className:ve()("tcfInstancePreviewImage empty",e,a)})}var _t=s.memo((function(e){var{field:t,model:n,references:a,schemas:r}=e,i=Object(A.c)(e,["field","model","references","schemas"])
const l=ct(b.getDefinition("instance").preview({context:{depth:0,references:a,schemas:r},field:t,mode:"label",value:n})).replace(/<[^>]*>?/gm,"").replace(/[\n\t\r]+/g,"").trim().substr(0,256)
return s.createElement("div",Object.assign({},i),l)}),(function(e,t){return e.model===t.model}))
function Nt(e){const[t,n]=Object(l.d)(e=>[e.config.references,e.schemas])
return s.createElement(_t,Object.assign({},e,{references:t,schemas:n}))}function kt({command:e,onClick:t}){return s.createElement("div",{className:"tcfArrayWidgetMember--headerMoreItem",onMouseUp:t},s.createElement(qe,{className:"tcfArrayWidgetMember--headerMoreItemIcon",name:e.icon}),s.createElement("span",{className:"tcfArrayWidgetMember--headerMoreItemLabel"},e.label))}var Mt=Object(l.b)((e,{uuid:t})=>({commands:ne(e,t)}),e=>({dispatch:e}))((function({commands:e,dispatch:t,onClose:n}){const a=[]
let r
for(const i of e)"edit"!==i.id&&(void 0!==r&&r!==i.group&&a.push(s.createElement("div",{className:"tcfArrayWidgetMember--headerMoreDivider",key:i.id+"-divider"})),r=i.group,a.push(s.createElement(kt,{command:i,key:i.id,onClick:()=>{n(),i.invoke(t)}})))
return s.createElement("div",{className:"tcfArrayWidgetMember--headerMoreMenu"},a)}))
n(86),n(87)
class It extends s.Component{constructor(){super(...arguments),this.handle=null,this.handleStyle={left:"0px"},this.origin=null,this.panel=null,this.panelClassName="tcfFlyout--panel",this.panelStyle={left:"0px",top:"0px"},this.handleResize=()=>{this.update()},this.setHandle=e=>{this.handle=e,this.update()},this.setOrigin=e=>{this.origin=e,this.update()},this.setPanel=e=>{this.panel=e,this.update()}}componentDidMount(){window.addEventListener("resize",this.handleResize)}componentWillUnmount(){window.removeEventListener("resize",this.handleResize)}render(){const{children:e,onClick:t}=this.props
return s.createElement("div",{className:"tcfFlyout",ref:this.setOrigin},s.createElement(it,{onClick:t},s.createElement("div",{className:this.panelClassName,ref:this.setPanel,style:Object.assign({},this.panelStyle)},s.createElement("div",{className:"tcfFlyout--handle",ref:this.setHandle,style:Object.assign({},this.handleStyle)}),s.createElement("div",{className:"tcfFlyout--body"},e))))}update(){const{handle:e,handleStyle:t,origin:n,panel:s,panelStyle:a}=this
if(!n||!s||!e)return
const r=n.getBoundingClientRect(),i=s.getBoundingClientRect()
let l="tcfFlyout--panel"
const o=Math.max(10,Math.min(window.innerWidth-i.width-10,r.left+.5*(r.width-i.width))),c=Math.max(10,Math.min(i.width-10,r.left+.5*r.width-o))
t.left=c+"px",a.left=o+"px",r.top+.5*r.height>.5*window.innerHeight?(l+=" above",a.top=r.top-i.height-5+"px"):(l+=" below",a.top=r.top+r.height+5+"px"),e.style.left=t.left,s.className=this.panelClassName=l,s.style.left=a.left,s.style.top=a.top}}class Lt extends s.Component{constructor(){super(...arguments),this.state={isExpanded:!1},this.handleClose=()=>{this.setState({isExpanded:!1})},this.handleMouseDown=()=>{this.setState({isExpanded:!0})}}render(){const{uuid:e}=this.props,{isExpanded:t}=this.state
return s.createElement("div",{className:"tcfArrayWidgetMember--headerMore"},s.createElement("div",{className:"tcfArrayWidgetMember--headerMoreButton",onMouseDown:this.handleMouseDown},s.createElement(qe,{name:"material:more_vert"})),t?s.createElement(It,{onClick:this.handleClose},s.createElement(Mt,{onClose:this.handleClose,uuid:e})):null)}}function At(e){return e}function Pt(e,t){return t?e?"minus":"plus":e?"done":"edit"}function Tt({disabled:e,dragSource:t=At,field:n,hasPreview:a,isCollapsible:r,isExpanded:i,model:l,onToggleExpanded:o,schema:c}){const u=[]
return c?(u.push(s.createElement(qe,{key:"icon",name:c.icon})),c.previewImage&&u.push(s.createElement(xt,{key:"image",model:l,schema:c})),u.push(s.createElement("div",{className:ve()("tcfArrayWidgetMember--headerLabel",{isHidden:!l.__visible}),key:"label"},c.label)),a&&c.previewLabelTemplate&&u.push(s.createElement("div",{className:"tcfArrayWidgetMember--headerPreview",key:"preview"},s.createElement(Nt,{field:n,model:l})))):u.push(s.createElement(qe,{className:"tcfArrayWidgetMember--headerHandleIcon",key:"handle",name:"move"})),s.createElement("div",{className:"tcfArrayWidgetMember--header"},t(s.createElement("div",{className:ve()("tcfArrayWidgetMember--headerHandle",{enabled:!e}),onClick:o},u)),l.__visible?null:s.createElement(qe,{className:"tcfArrayWidgetMember--headerVisibility",name:"material:visibility_off"}),s.createElement("div",{className:"tcfArrayWidgetMember--headerActions"},r?s.createElement(Ct,{onClick:o,primary:!e},s.createElement(qe,{name:Pt(i,e)})):null,e?null:s.createElement(Lt,{uuid:l.__uuid})))}n(32)
var Rt=s.memo((function({field:e,model:t,mode:n="default",references:a,schemas:r}){const i=b.getDefinition("instance").preview({context:{depth:0,references:a,schemas:r},field:e,mode:n,value:t})
try{const e={__html:ct(i)}
return s.createElement("div",{className:ve()("tcfInstancePreview--content",n),dangerouslySetInnerHTML:e})}catch(e){return s.createElement(s.Fragment,null,s.createElement("p",null,s.createElement("span",{className:"tcfIcon material"},"error"),s.createElement("span",null,"Could not render preview.")),e&&"object"==typeof e&&"message"in e?s.createElement("pre",null,e.message):null)}}),(function(e,t){return e.model===t.model}))
function Ut({className:e,field:t,model:n,mode:a,onClick:r}){const{references:i,schemas:o}=Object(l.d)(e=>({references:e.config.references,schemas:e.schemas}))
return s.createElement("div",{className:ve()("tcfInstancePreview",e,{isClickable:!!r}),onClick:r},s.createElement(Rt,{field:t,model:n,mode:a,references:i,schemas:o}))}function Ft(e){const{isExpanded:t,toggleExpanded:n}=s.useContext(we),a=s.useRef(null),[{isDragging:r},i,l]=bt(e,a),[,o]=vt(e,a)
o(a)
const{child:c,depth:u,disabled:d,field:m,isCollapsible:h,path:p,previewMode:f,schema:g}=e,b=()=>{n(c.__uuid)}
let y=!0,v=!1
if(g){const e=Object.keys(g.fields)
y=e.length>0,v=1===e.length&&"redactor"===g.fields[e[0]].type}const E=g&&g.preview&&function(e,t){switch(e){case"always":return!0
case"root":return 1===t}}(f,u),w=y&&(!h||t(c.__uuid))
let O
return w?O=s.createElement("div",{className:"tcfArrayWidgetMember--body"},s.createElement(rt,{canChangeType:!1,disabled:d,isBorderless:v,key:"details",model:c,path:p,schemaNames:m.schemas})):E&&(O=s.createElement(Ut,{className:"tcfArrayWidgetMember--preview",field:m,key:"summary",model:c,onClick:y?b:void 0})),s.createElement("div",{className:ve()("tcfArrayWidgetMember depth-"+u,w?"isExpanded":"isCollapsed",{isDragging:r}),ref:a},l(s.createElement("div",{className:"tcfArrayWidgetMember--panel"},s.createElement(Tt,{disabled:d,dragSource:i,field:m,hasPreview:!w&&!E,isCollapsible:y&&h,isExpanded:w,model:c,onToggleExpanded:b,schema:g}),s.createElement(Ot,{uri:w?"details":"summary"},O))))}n(88)
function $t({children:e,data:t,disabled:n,field:a,model:r,onDelete:i,onUpdate:o,path:c}){const{member:u,collapsible:d,previewMode:m}=a,h=s.useRef(null),p=Object(l.d)(e=>e.schemas),f=s.useContext(tt),g=t.map((e,t)=>{const a=[...c,{index:t,name:u.name,type:"index"}],l={child:e,depth:f,disabled:n,path:a}
return"instance"===u.type?s.createElement(Ft,Object.assign({},l,{isCollapsible:d,field:u,key:e.__uuid,previewMode:m,schema:p[e.__type]})):s.createElement(Et,Object.assign({},l,{field:u,index:t,key:me(e)?e.__uuid:t,model:r,onDelete:i,onUpdate:o}))})
return 0===g.length&&g.push(s.createElement(wt,{field:a,key:"droplet",path:c})),s.createElement(s.Fragment,null,s.createElement("div",{className:"tcfArrayWidgetList",ref:h},g),s.createElement("div",{className:"tcfArrayWidgetList--footer"},e))}class Dt extends s.Component{constructor(){super(...arguments),this.handleAdd=e=>{const{context:t}=this,{data:n,disabled:s,onUpdate:a}=this.props
if(s)return
const r=Array.isArray(n)?n.slice():[]
r.push(he(e)),a(r),c(e)&&t&&t.toggleExpanded(e.__uuid,!0)},this.handleDelete=e=>{const{data:t,disabled:n,onUpdate:s}=this.props
if(n||!Array.isArray(t))return
const a=t.slice()
a.splice(e,1),s(a)},this.handleUpdate=(e,t)=>{const{data:n,disabled:s,onUpdate:a}=this.props
if(s||!Array.isArray(n))return
const r=n.slice()
r[e]=he(t,r[e]),a(r)}}render(){const{data:e,disabled:t,field:n,model:a,path:r}=this.props,{limit:i}=n
if(!n.member)return null
const l=Array.isArray(e)?e:[],o=i>0&&l.length>=i,c=b.getDefinition(n.member)
let u
return t||!c||o||(u=s.createElement(c.factory,{field:n.member,onCreate:this.handleAdd,scope:a.__type})),s.createElement($t,{data:l,disabled:t,field:n,limit:i,model:a,onDelete:this.handleDelete,onUpdate:this.handleUpdate,path:r},u)}}Dt.contextType=we
n(89)
function Vt({field:e,onCreate:t}){const n=Object(l.d)(e=>e.schemas)
return s.createElement("div",{className:"tcfFactory"},s.createElement(Ee,{className:"tcfFactory--primaryButton",onClick:()=>{const s=b.createValue({field:e,schemas:n})
t(s)},secondary:!0},s.createElement(qe,{name:"plus"}),s.createElement(je,{value:"Create"})))}class Wt{constructor({factory:e,widget:t}){this.factory=e||Vt,this.widget=t}cloneValue(e){return Object(A.a)(this,void 0,void 0,(function*(){const{field:t,value:n}=e
return this.isValue(t,n)?function e(t){if(!t)return t
if(Array.isArray(t))return t.map(t=>e(t))
if("object"==typeof t){const n={}
for(const s in t)n[s]=e(t[s])
return n}return t}(n):this.createValue(e)}))}}class Ht extends Wt{createValue(e){return!!e.field.defaultValue}isValue(e,t){return"boolean"==typeof t||t instanceof Boolean}preview({value:e}){return e}}n(90)
class Bt extends s.Component{constructor(){super(...arguments),this.id=y()}render(){const{id:e}=this,{className:t,children:n,disabled:a,onChange:r,value:i}=this.props
return s.createElement("dl",{className:ve()("tcfCheckbox",t)},s.createElement("dd",{className:"tcfCheckbox--input"},s.createElement("input",{checked:i,disabled:a,id:e,onChange:a?void 0:()=>r(!i),type:"checkbox"})),s.createElement("dt",{className:"tcfCheckbox--label"},s.createElement("label",{htmlFor:e},n)))}}function zt({data:e,disabled:t,field:n,onUpdate:a}){return s.createElement(Bt,{disabled:t,onChange:a,value:!!e},n.label)}function qt({red:e,green:t,blue:n,alpha:s}){return{max:Math.max(e,t,n),min:Math.min(e,t,n),red:e/255,green:t/255,blue:n/255,alpha:s}}function Xt(e){return"object"==typeof e&&"number"==typeof e.alpha&&"number"==typeof e.blue&&"number"==typeof e.green&&"number"==typeof e.red}function Jt(e){e=e.replace(/^#?([a-f\d])([a-f\d])([a-f\d])$/i,(function(e,t,n,s){return t+t+n+n+s+s}))
const t=/^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(e)
return t?{red:parseInt(t[1],16),green:parseInt(t[2],16),blue:parseInt(t[3],16),alpha:1}:null}function Kt(e){return`rgba(${e.red},${e.green},${e.blue},${e.alpha})`}function Gt(e){const{alpha:t,blue:n,green:s,max:a,min:r,red:i}=qt(e),l=0===a?0:(a-r)/a,o=(a-r)/255
let c=0,u=a/255
return a===r||(c=a===e.red?(s-n)/o+(s<n?6:0):a===e.green?(n-i)/o+2:(i-s)/o+4,c/=6),{hue:c,saturation:l,value:u,alpha:t}}const Yt=s.createContext({css:"#000",hsv:{hue:0,saturation:0,value:0,alpha:0},rgb:{red:0,green:0,blue:0,alpha:0},onHsvColor:e=>{},onRgbColor:e=>{}})
function Qt(e){return function(t){return s.createElement(Yt.Consumer,null,n=>s.createElement(e,Object.assign({},t,n)))}}class Zt extends s.Component{constructor(e){super(e),this.timeout=null,this.commit=()=>{null!==this.timeout&&window.clearTimeout(this.timeout),this.timeout=window.setTimeout(this.handleTimeout,250)},this.handleHsvColor=e=>{const t=function({alpha:e,hue:t,saturation:n,value:s}){let a=0,r=0,i=0
const l=Math.floor(6*t),o=6*t-l,c=s*(1-n),u=s*(1-o*n),d=s*(1-(1-o)*n)
switch(l%6){case 0:a=s,r=d,i=c
break
case 1:a=u,r=s,i=c
break
case 2:a=c,r=s,i=d
break
case 3:a=c,r=u,i=s
break
case 4:a=d,r=c,i=s
break
case 5:a=s,r=c,i=u}return{alpha:e,red:Math.round(255*a),green:Math.round(255*r),blue:Math.round(255*i)}}(e)
this.setState({css:Kt(t),rgb:t,hsv:e}),this.commit()},this.handleRgbColor=e=>{this.setState({css:Kt(e),rgb:e,hsv:Gt(e)}),this.commit()},this.handleTimeout=()=>{this.timeout=null,this.props.onChange(this.state.rgb)},this.state={css:Kt(e.color),hsv:Gt(e.color),rgb:Object.assign({},e.color)}}render(){const{children:e}=this.props
return s.createElement(Yt.Provider,{value:Object.assign(Object.assign({},this.state),{onHsvColor:this.handleHsvColor,onRgbColor:this.handleRgbColor})},e)}}n(91)
function en(e){var{className:t}=e,n=Object(A.c)(e,["className"])
return s.createElement("input",Object.assign({className:ve()("tcfInput",t)},n))}class tn extends s.Component{constructor(){super(...arguments),this.state={hasFocus:!1},this.handleBlur=()=>{this.setState({hasFocus:!1})},this.handleChange=e=>{const{value:t}=e.target,{onRgbColor:n}=this.props
n(this.getColor(t))},this.handleFocus=()=>{this.setState({hasFocus:!0})}}getValue(){const{rgb:e,type:t}=this.props
switch(t){case"alpha":case"blue":case"green":case"red":return""+e[t]
case"hex":return"#"+(16777216+((n=e).blue|n.green<<8|n.red<<16)).toString(16).slice(1)}var n}getColor(e){const{rgb:t,type:n}=this.props
switch(n){case"blue":case"green":case"red":const s=parseInt(e)
return Object.assign(Object.assign({},t),{[n]:isFinite(s)?Math.max(0,Math.min(255,s)):t[n]})
case"alpha":const a=parseFloat(e)
return Object.assign(Object.assign({},t),{alpha:isFinite(a)?Math.max(0,Math.min(1,a)):t.alpha})
case"hex":const r=Jt(e)
return r?Object.assign(Object.assign({},r),{alpha:t.alpha}):t}}render(){const{hasFocus:e}=this.state,t={className:"tcfColorInputInput",onBlur:this.handleBlur,onChange:this.handleChange,onFocus:this.handleFocus}
return e?t.defaultValue=this.getValue():t.value=this.getValue(),s.createElement(en,t)}}var nn=Qt(tn)
n(92)
class sn extends s.Component{constructor(){super(...arguments),this.element=null,this.state={initialHue:0,isMouseDown:!1,mouseX:0,mouseY:0},this.handleMouseDown=e=>{const{hsv:t}=this.props
window.addEventListener("mousemove",this.handleMouseMove),window.addEventListener("mouseup",this.handleMouseUp),this.setState(Object.assign(Object.assign({},this.update(e.clientX,e.clientY,t.hue)),{initialHue:t.hue,isMouseDown:!0}))},this.handleMouseMove=e=>{this.setState(this.update(e.clientX,e.clientY))},this.handleMouseUp=e=>{this.stopListening(),this.setState(Object.assign(Object.assign({},this.update(e.clientX,e.clientY)),{isMouseDown:!1}))},this.setElement=e=>{this.element=e}}componentWillUnmount(){this.stopListening()}render(){const{hsv:e}=this.props,{initialHue:t,isMouseDown:n,mouseX:a,mouseY:r}=this.state
return s.createElement("div",{className:"tcfColorInputSaturation",onMouseDown:this.handleMouseDown,ref:this.setElement,style:{background:`hsl(${360*(n?t:e.hue)}, 100%, 50%)`}},s.createElement("div",{className:"tcfColorInputSaturation--value",style:{left:100*(n?a:e.saturation)+"%",top:100*(n?r:1-e.value)+"%"}}))}stopListening(){window.removeEventListener("mousemove",this.handleMouseMove),window.removeEventListener("mouseup",this.handleMouseUp)}update(e,t,n=this.state.initialHue){const{element:s}=this
if(!s)return{mouseX:this.state.mouseX,mouseY:this.state.mouseY}
const{hsv:a,onHsvColor:r}=this.props,i=s.getBoundingClientRect(),l=Math.max(0,Math.min(1,(e-i.left)/i.width)),o=Math.max(0,Math.min(1,(t-i.top)/i.height))
return r({alpha:a.alpha,hue:n,saturation:l,value:1-o}),{mouseX:l,mouseY:o}}}var an=Qt(sn)
n(93)
class rn extends s.Component{constructor(){super(...arguments),this.element=null,this.handleMouseDown=e=>{window.addEventListener("mousemove",this.handleMouseMove),window.addEventListener("mouseup",this.handleMouseUp),this.update(e.clientX)},this.handleMouseMove=e=>{this.update(e.clientX)},this.handleMouseUp=e=>{this.stopListening(),this.update(e.clientX)},this.setElement=e=>{this.element=e}}componentWillUnmount(){this.stopListening()}render(){const{rgb:e,hsv:t,type:n}=this.props,a=t[n]
let r
if("alpha"===n){const{red:t,green:n,blue:a}=e,i=`rgba(${t}, ${n}, ${a}, 0)`,l=`rgba(${t}, ${n}, ${a}, 1)`
r=s.createElement("div",{className:"tcfColorInputSlider--gradient",style:{background:`linear-gradient(to right, ${i}, ${l})`}})}return s.createElement("div",{className:"tcfColorInputSlider "+n,onMouseDown:this.handleMouseDown},r,s.createElement("div",{className:"tcfColorInputSlider--track",ref:this.setElement},s.createElement("div",{className:"tcfColorInputSlider--handle",style:{left:100*a+"%"}})))}stopListening(){window.removeEventListener("mousemove",this.handleMouseMove),window.removeEventListener("mouseup",this.handleMouseUp)}update(e){const{element:t}=this
if(!t)return
const{hsv:n,onHsvColor:s,type:a}=this.props,r=t.getBoundingClientRect(),i=Math.max(0,Math.min(1,(e-r.left)/r.width))
s(Object.assign(Object.assign({},n),{[a]:i}))}}var ln=Qt(rn)
n(94)
var on=Qt((function({children:e,className:t,color:n,css:a,disabled:r,onClick:i,onRgbColor:l}){if(n){const e=Jt(n)
e&&(i=function(){l(e)})}return s.createElement("div",{className:ve()("tcfColorInputSwatch",t),onClick:r?void 0:i},s.createElement("div",{className:"tcfColorInputSwatch--color",style:{background:n||a}}),e)}))
n(95)
function cn({disableAlpha:e,presetColors:t}){const n=[s.createElement("div",{className:"tcfColorInputPicker--value wide",key:"hex"},s.createElement(nn,{type:"hex"}),s.createElement("div",{className:"tcfColorInputPicker--valueCaption"},"Hex")),s.createElement("div",{className:"tcfColorInputPicker--value",key:"red"},s.createElement(nn,{type:"red"}),s.createElement("div",{className:"tcfColorInputPicker--valueCaption"},"R")),s.createElement("div",{className:"tcfColorInputPicker--value",key:"green"},s.createElement(nn,{type:"green"}),s.createElement("div",{className:"tcfColorInputPicker--valueCaption"},"G")),s.createElement("div",{className:"tcfColorInputPicker--value",key:"blue"},s.createElement(nn,{type:"blue"}),s.createElement("div",{className:"tcfColorInputPicker--valueCaption"},"B"))]
e||n.push(s.createElement("div",{className:"tcfColorInputPicker--value",key:"alpha"},s.createElement(nn,{type:"alpha"}),s.createElement("div",{className:"tcfColorInputPicker--valueCaption"},"A")))
let a=null
return t&&t.length&&(a=s.createElement("div",{className:"tcfColorInputPicker--presets"},t.map(e=>s.createElement(on,{className:"tcfColorInputPicker--presetsSwatch",color:e})))),s.createElement("div",{className:"tcfColorInputPicker"},s.createElement(an,null),s.createElement("div",{className:"tcfColorInputPicker--controls"},s.createElement("div",{className:"tcfColorInputPicker--sliders"},s.createElement(ln,{type:"hue"}),e?null:s.createElement(ln,{type:"alpha"})),s.createElement(on,{className:"tcfColorInputPicker--swatch"})),s.createElement("div",{className:"tcfColorInputPicker--values"},n),a)}n(96)
class un extends s.Component{constructor(){super(...arguments),this.state={hasColorPicker:!1},this.handleChange=e=>{this.props.onChange(e)},this.handleSwatchClick=()=>{this.setState({hasColorPicker:!0})},this.handleOverlayClick=()=>{this.setState({hasColorPicker:!1})}}render(){const{hasColorPicker:e}=this.state,{color:t,disableAlpha:n,disabled:a,onChange:r,presetColors:i}=this.props
return s.createElement(Zt,{color:t,onChange:r},s.createElement("div",{className:"tcfColorInput"},s.createElement(on,{className:"tcfColorInput--swatch",disabled:a,onClick:this.handleSwatchClick},e&&!a?s.createElement(It,{onClick:this.handleOverlayClick},s.createElement(cn,{disableAlpha:n,presetColors:i})):null),s.createElement(nn,{type:"hex"})))}}function dn({data:e,disabled:t,field:n,onUpdate:a}){const r=Xt(e)?e:{alpha:1,blue:255,green:255,red:255}
return s.createElement(un,{color:r,disableAlpha:!n.alpha,disabled:t,onChange:a,presetColors:n.swatches})}n(97)
function mn({children:e,className:t,icon:n}){return s.createElement("div",{className:ve()("tcfTextAndIcon",t)},s.createElement(qe,{className:"tcfTextAndIcon--icon",name:n}),s.createElement(je,{className:"tcfTextAndIcon--text",value:e}))}function hn({children:e,title:t}){return s.createElement("div",{className:"tcfErrorMessage"},s.createElement(mn,{icon:"material:error"},t),e)}function pn(e){return"object"==typeof e&&"string"==typeof e.url}n(98)
class fn extends s.Component{constructor(){super(...arguments),this.request=null,this.state={mode:"idle"},this.handleChange=e=>{this.updateOEmbed(),this.setState({mode:"typing"}),this.props.onUpdate(Object.assign(Object.assign({},this.getOEmbed()),{url:e.target.value}))},this.updateOEmbed=function(e,t,n){let s,a,r=null,i=null,l=null
function o(){const c=Date.now()-s
c<t&&c>=0?r=window.setTimeout(o,t-c):(r=null,n||(a=e.apply(l,i),r||(l=i=null)))}return function(){l=this,i=arguments,s=Date.now()
const c=n&&!r
return r||(r=window.setTimeout(o,t)),c&&(a=e.apply(l,i),l=i=null),a}}(()=>{this.setState({mode:"loading"})
const{apiEndpoint:e,model:t,field:n}=this.props,s=["schema="+encodeURIComponent(t.__type),"field="+encodeURIComponent(n.name),"url="+encodeURIComponent(this.getOEmbed().url)],a=new XMLHttpRequest
a.onreadystatechange=()=>this.handleRequestStateChange(a),a.onerror=()=>this.handleRequestError(),a.open("GET",`${e}&${s.join("&")}`),a.send(),this.request&&this.request.abort(),this.request=a},500)}getOEmbed(){const{data:e}=this.props
return pn(e)?e:{url:""}}handleRequestStateChange(e){if(e.readyState!==XMLHttpRequest.DONE)return
if(200!==e.status)return this.handleRequestError()
let t
try{t=JSON.parse(e.responseText)}catch(e){return this.handleRequestError()}this.setState({mode:"idle"}),this.request=null,this.props.onUpdate(Object.assign(Object.assign({},this.getOEmbed()),{info:t.data}))}handleRequestError(){this.setState({mode:"idle"}),this.request=null,this.props.onUpdate(Object.assign(Object.assign({},this.getOEmbed()),{info:null}))}render(){const e=this.getOEmbed(),{disabled:t}=this.props,{mode:n}=this.state
let a
if("typing"===n||"loading"===n)a=s.createElement("div",{className:"tcfOEmbedWidget--activity"},s.createElement("div",{className:"tcfOEmbedWidget--activityBounce first"}),s.createElement("div",{className:"tcfOEmbedWidget--activityBounce second"}),s.createElement("div",{className:"tcfOEmbedWidget--activityBounce third"}))
else if(e.info){const{title:t,author_name:n,thumbnail_url:r}=e.info
a=s.createElement("div",{className:"tcfOEmbedWidget--info"},r?s.createElement("img",{className:"tcfOEmbedWidget--infoImage",src:r}):null,s.createElement("div",{className:"tcfOEmbedWidget--infoContent"},s.createElement("div",{className:"tcfOEmbedWidget--infoTitle"},t),s.createElement("div",{className:"tcfOEmbedWidget--infoAuthor"},n)))}else a=s.createElement(hn,{title:"Invalid embed url"})
return s.createElement("div",{className:"tcfOEmbedWidget"},s.createElement("div",{className:"tcfOEmbedWidget--input"},s.createElement("input",{autoComplete:"off",className:"text fullwidth",disabled:t,onChange:t?void 0:this.handleChange,value:e.url})),a)}}var gn=Object(l.b)(e=>({apiEndpoint:e.config.apiEndpoints.oembed}))(fn)
class bn{constructor(e){this.value=e}get author(){return this.value.info?this.value.info.author_name:""}get thumbnail(){const{info:e}=this.value
return e&&e.thumbnail_url?new le.SafeString(`<img width="100" src=${e.thumbnail_url} />`):""}get title(){return this.value.info?this.value.info.title:""}toHTML(){const{info:e}=this.value
if(!e)return new le.SafeString("")
let t=""
return e.thumbnail_url&&(t=`<img class="tcfOEmbedWidget--infoImage" src="${e.thumbnail_url}" />`),new le.SafeString(`\n      <div class="tcfOEmbedWidget--info">\n        ${t}\n        <div class="tcfOEmbedWidget--infoContent">\n          <div class="tcfOEmbedWidget--infoTitle">${e.title}</div>\n          <div class="tcfOEmbedWidget--infoAuthor">${e.author_name}</div>\n        </div>\n      </div>\n    `)}}Object(A.b)([ht],bn.prototype,"value",void 0),Object(A.b)([ht],bn.prototype,"author",null),Object(A.b)([ht],bn.prototype,"thumbnail",null),Object(A.b)([ht],bn.prototype,"title",null),Object(A.b)([mt],bn.prototype,"toHTML",null)
n(99)
function yn({favorites:e,onSchema:t,onToggleFavorite:n,schemas:a}){const r=a.map(a=>{const r=-1!==e.indexOf(a.qualifier)
return s.createElement("div",{className:"tcfSchemaList--row",key:a.qualifier},s.createElement("div",{className:"tcfSchemaList--schema",onMouseUp:()=>t(a)},s.createElement(qe,{className:"tcfSchemaList--schemaIcon",name:a.icon}),s.createElement("div",{className:"tcfSchemaList--schemaLabel"},a.label)),n?s.createElement("div",{className:"tcfSchemaList-favorite",onClick:()=>n(a)},s.createElement(qe,{name:r?"material:star":"material:star_border"})):null)})
return s.createElement("div",{className:"tcfSchemaList"},r)}function vn({onCreate:e,schemas:t,scope:n}){const[a,r]=s.useState(!1),i=Object(l.c)()
let o,c=[],u=null
if(n){const{favoriteSchemas:a}=Object(l.d)(e=>e.user)
c=n in a?a[n]:[],c.length&&(u=t.filter(e=>-1!==c.indexOf(e.qualifier)).map(t=>s.createElement(Ee,{className:"tcfFactory--quickButton",key:t.qualifier,onClick:()=>e(t),secondary:!0},s.createElement(qe,{name:t.icon}),s.createElement("div",null,t.label)))),o=e=>{i(function(e,t){return(n,s)=>{const{favoriteSchemas:a}=s().user
let r=e in a?a[e]:[]
r=-1===r.indexOf(t)?[...r,t]:r.filter(e=>e!==t),n({type:"setUser",user:{favoriteSchemas:Object.assign(Object.assign({},a),{[e]:r})}})}}(n,e.qualifier))}}return s.createElement("div",{className:"tcfFactory multiple"},s.createElement(Ee,{className:"tcfFactory--primaryButton",onMouseDown:()=>r(!0)},s.createElement(qe,{name:"plus"}),s.createElement(je,{value:"Create"}),a?s.createElement(It,{onClick:()=>r(!1)},s.createElement(yn,{favorites:c,onSchema:t=>{r(!1),e(t)},onToggleFavorite:o,schemas:t})):null),u)}function En({onCreate:e,schema:t}){return s.createElement("div",{className:"tcfFactory"},s.createElement(Ee,{className:"tcfFactory--primaryButton",onClick:()=>e(t)},s.createElement(qe,{name:"plus"}),s.createElement(je,{params:{schema:t.label},value:"Create {schema}"})))}function wn({field:e,onCreate:t,scope:n}){const a=Object(l.d)(e=>e.schemas),r=e.schemas.map(e=>a[e]).sort((e,t)=>e.label.localeCompare(t.label))
if(!r.length)return null
const i=e=>{if(-1!==r.indexOf(e))return t(v({schemas:a,schema:e}))}
return r.length>1?s.createElement(vn,{onCreate:i,schemas:r,scope:n}):s.createElement(En,{onCreate:i,schema:r[0]})}function On({children:e,disabled:t,field:n,model:a}){const r=s.useContext(tt),i=Object(l.d)(e=>e.schemas),{isExpanded:o,toggleExpanded:c}=s.useContext(we),u=i[a.__type],d=o(a.__uuid),m=u&&u.preview,h=()=>c(a.__uuid)
let p=null
return d?p=s.createElement("div",{className:"tcfArrayWidgetMember--body"},e):m&&(p=s.createElement(Ut,{field:n,model:a,onClick:h})),s.createElement("div",{className:"tcfInstanceWidget--collapsiblePanel depth-"+r},s.createElement(Tt,{disabled:t,field:n,hasPreview:!d&&!m,isCollapsible:!0,isExpanded:d,model:a,onToggleExpanded:h,schema:u}),s.createElement(Ot,{uri:d?"details":"summary"},p))}n(100)
function Cn({className:e,data:t,disabled:n,field:a,path:r}){const i=s.createElement(rt,{canChangeVisibility:!0,disabled:n,model:t,path:[...r,{type:"property",name:a.name}],schemaNames:a.schemas})
return a.collapsible&&c(t)?s.createElement(On,{model:t,disabled:n,field:a},i):s.createElement("div",{className:ve()("tcfInstanceWidget",e)},i)}function jn(e){var{attribute:t,column:n,max:a,min:r,onUpdate:i}=e,l=Object(A.c)(e,["attribute","column","max","min","onUpdate"])
const[o,c]=s.useState(null),u=n[t],d=q(u,l),m=l.current.key in u
return s.createElement("div",{className:"tcfLayoutEditor--columnInput"},s.createElement("div",{className:ve()("tcfLayoutEditor--columnInputLabel",{hasOwnValue:m})},(h=t).charAt(0).toUpperCase()+h.slice(1)),s.createElement(en,{className:"tcfLayoutEditor--columnInputField",max:a,min:r,onBlur:()=>c(null),onChange:function({target:e}){c(e.value)
const s=parseInt(e.value)
!isFinite(s)||"number"==typeof r&&s<r||"number"==typeof a&&s>a||i(n.__uuid,{[t]:J(u,s,l)})},type:"number",value:null===o?d:o}))
var h}function Sn(e,t=0,n=1){return e<t?t:e>n?n:e}function xn({columnsPerRow:e}){const t=[]
for(let n=0;n<e;n++)t.push(s.createElement("div",{className:"tcfLayoutPreview--gridColumn",key:n}))
return s.createElement("div",{className:"tcfLayoutPreview--grid"},t)}n(101)
function _n(e){const t=String.fromCharCode(65+e%25),n=Math.floor(e/25)
return f("Column {num}",{num:`${t}${n>1?n:""}`})}function Nn(e){var{columns:t,columnsPerRow:n,isSelected:a,onClick:r}=e,i=Object(A.c)(e,["columns","columnsPerRow","isSelected","onClick"])
return s.createElement("div",{className:ve()("tcfLayoutPreview",{isClickable:!!r,isSelected:a}),onClick:r},s.createElement(xn,{columnsPerRow:n}),t.map((e,t)=>{const a=q(e.offset,i),r=q(e.order,i),l=q(e.width,i)
return s.createElement("div",{className:"tcfLayoutPreview--col",key:t,style:{marginLeft:(a/n*100).toFixed(6)+"%",order:r,width:(l/n*100).toFixed(6)+"%"}},s.createElement("div",{className:"tcfLayoutPreview--colPanel"},_n(t)))}))}class kn extends s.Component{constructor(){super(...arguments),this.element=null,this.initialHandle=!1,this.initialPosition=0,this.isListening=!1,this.state={dragDelta:0,dragMode:"none"},this.handleMouseDown=e=>{this.initialHandle=!1,this.initialPosition=e.clientX,this.startListening()
let t=e.target
for(;t;){if(t.classList.contains("tcfLayoutRowEditor--colHandle")){this.initialHandle=!0
break}t=t.parentElement}},this.handleMouseMove=e=>{const{dragMode:t}=this.state,n=e.clientX-this.initialPosition
"none"===t&&Math.abs(n)>3&&(this.initialPosition=e.clientX,this.setState({dragDelta:0,dragMode:this.initialHandle?"size":"move"})),"none"!==t&&this.setState({dragDelta:n,dragMode:t})},this.handleMouseUp=()=>{const{column:e,onSelect:t}=this.props,{dragDelta:n,dragMode:s}=this.state,a=this.toColumns(n)
"size"===s?this.applySize(a):"move"===s?this.applyMove(a):t(e.__uuid),this.stopListening(),this.setState({dragDelta:0,dragMode:"none"})},this.setElement=e=>{this.element=e}}applyMove(e){const{props:t}=this,{column:n,columnsPerRow:s,onUpdate:a}=t,r=Sn(this.sample(n.offset)+e,0,s)
a(n.__uuid,{offset:J(n.offset,r,t)})}applySize(e){const{props:t}=this,{column:n,constraints:{maxColumnWidth:s,minColumnWidth:a},onUpdate:r}=t,i=Sn(this.sample(n.width)+e,a,s)
r(n.__uuid,{width:J(n.width,i,t)})}componentWillUnmount(){this.stopListening()}render(){const{dragDelta:e,dragMode:t}=this.state,{column:n,columnsPerRow:a,index:r,isSelected:i}=this.props,l=this.sample(n.offset),o=this.sample(n.width),c=this.sample(n.order)
let u=(o/a*100).toFixed(6)+"%",d=(l/a*100).toFixed(6)+"%"
return"move"===t?d=`calc(${d} + ${e}px)`:"size"===t&&(u=`calc(${u} + ${e}px)`),s.createElement("div",{className:ye("tcfLayoutRowEditor--col",{isSelected:i}),onMouseDown:this.handleMouseDown,ref:this.setElement,style:{marginLeft:d,order:c,width:u}},s.createElement("div",{className:"tcfLayoutRowEditor--colPanel"},s.createElement("div",{className:"tcfLayoutRowEditor--colLabel"},_n(r)),s.createElement("div",{className:"tcfLayoutRowEditor--colHandle"})))}sample(e){return q(e,this.props)}startListening(){this.isListening||(this.isListening=!0,document.addEventListener("mousemove",this.handleMouseMove),document.addEventListener("mouseup",this.handleMouseUp))}stopListening(){this.isListening=!1,document.removeEventListener("mousemove",this.handleMouseMove),document.removeEventListener("mouseup",this.handleMouseUp)}toColumns(e){const{element:t}=this,{columnsPerRow:n}=this.props,s=t?t.parentElement:null
if(!s)return 0
const a=s.offsetWidth/n
return Math.round(e/a)}}n(102)
function Mn(e){var{columns:t,selected:n}=e,a=Object(A.c)(e,["columns","selected"])
const{columnsPerRow:r}=a
return s.createElement("div",{className:"tcfLayoutRowEditor"},s.createElement(xn,{columnsPerRow:r}),t.map((e,t)=>s.createElement(kn,Object.assign({},a,{column:e,index:t,isSelected:null!==n&&n.__uuid===e.__uuid,key:e.__uuid}))))}const In={xs:"material:smartphone",sm:"material:tablet_mac",md:"material:tablet",lg:"material:laptop",xl:"material:desktop_mac"}
function Ln(e){const{columnsPerRow:t,constraints:n,current:a,selected:r}=e
let i
if(r){const a={breakpoints:e.breakpoints,column:r,current:e.current,onUpdate:e.onUpdate}
i=s.createElement("div",{className:"tcfLayoutEditor--rowAttributes"},s.createElement(jn,Object.assign({},a,{attribute:"width",max:Math.min(t,n.maxColumnWidth),min:Math.max(1,n.minColumnWidth)})),s.createElement(jn,Object.assign({},a,{attribute:"offset",min:0,max:t})),s.createElement(jn,Object.assign({},a,{attribute:"order"})))}else i=s.createElement("div",{className:"tcfLayoutEditor--rowAttributes"})
return s.createElement("div",{className:"tcfLayoutEditor--row"},s.createElement("div",{className:"tcfLayoutEditor--rowHead"},a.key in In?s.createElement(qe,{name:In[a.key]}):null,s.createElement("span",null,a.label)),s.createElement("div",{className:"tcfLayoutEditor--rowBody"},s.createElement(Mn,Object.assign({},e)),i))}n(103)
function An(e){var{onClose:t,onCreate:n,onDelete:a}=e,r=Object(A.c)(e,["onClose","onCreate","onDelete"])
const{breakpoints:i,columns:l,constraints:{maxColumns:o,minColumns:c}}=r,[u,d]=s.useState(l.length?l[0].__uuid:null),m=u&&l.find(e=>e.__uuid===u)||null
function h(e){d(e===u?null:e)}return s.createElement(ke,null,s.createElement(ke.Content,null,s.createElement("div",{className:"tcfLayoutEditor--title"},s.createElement(je,{value:"Edit columns"})),i.map(e=>s.createElement(Ln,Object.assign({},r,{current:e,key:e.key,selected:m,onSelect:h})))),s.createElement(ke.Footer,null,s.createElement("div",{className:"btngroup"},l.length<o?s.createElement(Ce,{onClick:()=>d(n())},s.createElement(qe,{name:"plus"}),s.createElement(je,{value:"Create"})):null,m&&l.length>c?s.createElement(Ce,{onClick:()=>a(m.__uuid)},s.createElement(qe,{name:"minus"}),s.createElement(je,{value:"Delete"})):null),s.createElement(Ce,{onClick:t,primary:!0},s.createElement(je,{value:"Close"}))))}n(104)
function Pn(e){var{onClose:t,onPreset:n,preset:a,presets:r}=e,i=Object(A.c)(e,["onClose","onPreset","preset","presets"])
return s.createElement(It,{onClick:t},s.createElement("div",{className:"tcfLayoutSelect--flyout"},r.map(e=>s.createElement(Nn,Object.assign({},i,{columns:e.columns,isSelected:e.key===a,key:e.key,onClick:()=>n(e)})))))}function Tn(e){var{canEdit:t,onPreset:n,preset:a,presets:r}=e,i=Object(A.c)(e,["canEdit","onPreset","preset","presets"])
const{breakpoints:l,columns:o,columnsPerRow:c}=i,[u,d]=s.useState(null),m=l[l.length-1]
function h(){d(null)}let p=null
return r.length?p="flyout":t&&(p="editor"),s.createElement("div",{className:"tcfLayoutSelect"},s.createElement("div",{className:"tcfLayoutSelect--widget"},s.createElement(Nn,{breakpoints:l,columns:o,columnsPerRow:c,current:m,onClick:p?()=>d(p):void 0}),"flyout"===u?s.createElement(Pn,{breakpoints:i.breakpoints,columnsPerRow:i.columnsPerRow,current:m,onClose:h,onPreset:function(e){n(e),d(null)},preset:a,presets:r}):null),t?s.createElement("div",{className:"tcfLayoutSelect--edit",onClick:()=>d("editor")},s.createElement(qe,{name:"material:edit"})):null,"editor"===u?s.createElement(it,{onClick:h},s.createElement(An,Object.assign({},i,{onClose:h}))):null)}n(105)
class Rn extends s.Component{constructor(){super(...arguments),this.handleCreate=()=>{const{data:e,disabled:t,field:n,onUpdate:s}=this.props
if(!K(e)||t||e.columns.length>=n.constraints.maxColumns)return null
const a=this.createColumn()
return s(Object.assign(Object.assign({},e),{columns:[...e.columns,a]})),a.__uuid},this.handleDelete=e=>{const{data:t,disabled:n,field:s,onUpdate:a}=this.props
!K(t)||n||t.columns.length<=s.constraints.minColumns||a(Object.assign(Object.assign({},t),{columns:t.columns.filter(t=>t.__uuid!==e)}))},this.handlePreset=e=>{const{data:t,disabled:n,field:s,onUpdate:a,schemas:r}=this.props
if(n||!K(t))return
const i=t.columns.map(e=>e.value)
a(Object.assign(Object.assign({},t),{preset:e.key,columns:e.columns.map((e,t)=>B(s,r,e,i.length>t?i[t]:void 0))}))},this.handleUpdate=(e,t)=>{const{data:n,disabled:s,onUpdate:a}=this.props
if(s||!K(n))return
const r=Object.keys(t).every(e=>"value"===e)
a(Object.assign(Object.assign({},n),{preset:r?n.preset:null,columns:n.columns.map(n=>n.__uuid===e?Object.assign(Object.assign({},n),t):n)}))}}createColumn(){const{field:e,schemas:t}=this.props
return B(e,t)}createColumnValue(){const{field:e,schemas:t}=this.props
return z(e,t)}render(){const{data:e,disabled:t,field:n,model:a,path:r,schemas:i}=this.props,l=X(n,i),o=this.context+1,{preset:c,columns:u}=K(e)?e:{columns:[],preset:null}
return s.createElement("div",{className:"tcfLayoutWidget"},s.createElement(Tn,{breakpoints:n.breakpoints,canEdit:n.canEdit,constraints:n.constraints,columns:u,columnsPerRow:n.columnsPerRow,onCreate:this.handleCreate,onDelete:this.handleDelete,onPreset:this.handlePreset,onUpdate:this.handleUpdate,preset:c,presets:n.presets}),s.createElement("div",{className:ve()("tcfLayoutWidget--columns",{isStacked:u.length<=o})},u.map((e,i)=>s.createElement(Le,{key:e.__uuid,label:_n(i)},s.createElement(Fe,{data:e.value,disabled:t,errors:null,field:l,model:a,onUpdate:t=>this.handleUpdate(e.__uuid,{value:t}),path:[...r,{name:n.name,type:"property"},{index:i,name:"columns",type:"index"}]})))))}}Rn.contextType=De
var Un=Object(l.b)((e,t)=>({schemas:e.schemas}))(Rn)
function Fn({data:e,disabled:t,onUpdate:n}){return s.createElement(Ke,{disabled:t,onChange:n,value:!!e})}function $n(e){const t=s.useRef(null)
return s.useEffect(()=>{const{current:n}=t
if(!n)return
const s=St()
for(const t of function(e){const{data:t,elementType:n,references:s}=e,a=[]
if(Array.isArray(t))for(const e of t){const t=s.find(t=>t.id===e&&t.type===n)
t&&a.push(t)}return a}(e)){const a=t.$element.clone(!1,!0)
a.appendTo(n),Craft.setElementSize(a,e.viewMode),s.load(a)}},[]),s.createElement("div",{className:"elementselect"},s.createElement("div",{className:"elements",ref:t}))}class Dn extends s.Component{constructor(){super(...arguments),this.element=null,this.renderedIds=[],this.uuid="element-"+y(),this.instance=null,this.isRendering=!1,this.handleAdd=({elements:e})=>{const{elementType:t,onAddReferences:n}=this.props
this.handleChange(),n(e.map(e=>Object.assign(Object.assign({},e),{$element:$(e.$element[0].outerHTML),element:e.$element[0].outerHTML,type:t})))},this.handleChange=()=>{if(this.isRendering)return
const{onUpdate:e}=this.props,t=this.getSelectedIds()
this.renderedIds=t,e(t)},this.setElement=e=>{if(this.element===e)return
this.element=e
let{instance:t}=this
if(t&&(t.off("selectElements",this.handleAdd),t.off("removeElements",this.handleChange),t.elementSort&&t.elementSort.off("sortChange",this.handleChange),t.destroy(),this.instance=t=null),e){const{criteria:e,elementType:n,limit:s=null,modalStorageKey:a=null,sourceElementId:r,sources:i,viewMode:l="small"}=this.props
t=new Craft.BaseElementSelectInput({criteria:e,elementType:n,id:this.uuid,limit:s,modalStorageKey:a,name:this.uuid,sources:i,sourceElementId:r,viewMode:l}),this.instance=t,this.createReferences(),t.on("selectElements",this.handleAdd),t.on("removeElements",this.handleChange),t.elementSort&&t.elementSort.on("sortChange",this.handleChange)}}}componentDidUpdate(){const{renderedIds:e}=this,t=this.props.data||[]
t.length===e.length&&t.every((t,n)=>t===e[n])||this.createReferences()}createReferences(){const{instance:e}=this
if(!e)return
this.isRendering=!0
const t=[]
e.$elementsContainer.empty()
for(const n of this.getStoredReferences()){const s=e.createNewElement(n)
s.find("input").prop("disabled",!0),e.appendElement(s),t.push(n.id)}e.resetElements(),this.renderedIds=t,this.isRendering=!1}getStoredReferences(){const{data:e,elementType:t,references:n}=this.props,s=[]
if(!Array.isArray(e))return s
for(const a of e){const e=n.find(e=>e.id===a&&e.type===t)
e&&s.push(e)}return s}getSelectedIds(){const{instance:e}=this
if(!e)return[]
const t=[],n=e.getSelectedElementIds(),s=e.getElements()
for(let e=0;e<s.length;e++){const a=parseInt(s.eq(e).data("id"));-1!==n.indexOf(a)&&t.push(a)}return t}render(){return s.createElement("div",{id:this.uuid,className:"elementselect",ref:this.setElement},s.createElement("div",{className:"elements"}),s.createElement("div",{className:"btn add icon dashed"},"Choose"))}}var Vn=Object(l.b)(e=>({references:e.config.references,sourceElementId:e.config.elementId}),e=>({onAddReferences:t=>{e(g(t))}}))((function(e){return e.disabled?s.createElement($n,Object.assign({},e)):s.createElement(Dn,Object.assign({},e))}))
function Wn({disabled:e,link:t,linkType:n,modalStorageKey:a=null,onUpdate:r}){return s.createElement("div",{className:"tcfLinkWidget--editor"},s.createElement(Vn,{criteria:n.criteria,data:[t.elementId],disabled:e,elementType:n.elementType,limit:1,modalStorageKey:a,onUpdate:e=>r(Object.assign(Object.assign({},t),{elementId:e.length?e[0]:0})),sources:n.sources,viewMode:"small"}),n.allowHash?s.createElement("div",{className:"tcfLinkWidget--editorHash tcfInput--group"},s.createElement("div",{className:"tcfInput--groupLabel"},"#"),s.createElement(en,{disabled:e,value:t.hash,onChange:e=>r(Object.assign(Object.assign({},t),{hash:e.currentTarget.value}))})):null)}function Hn({disabled:e,link:t,linkType:n,onUpdate:a}){return s.createElement("div",{className:"tcfLinkWidget--editor"},s.createElement(en,{disabled:e,type:n.inputType,value:t.url,onChange:e=>a(Object.assign(Object.assign({},t),{url:e.currentTarget.value}))}))}function Bn(e){return"object"==typeof e&&"number"==typeof e.elementId&&"string"==typeof e.hash&&"string"==typeof e.type&&"string"==typeof e.url}n(106)
function zn({data:e,disabled:t,field:n,model:a,onUpdate:r}){let i
i=Bn(e)?e:{elementId:0,hash:"",openInNewWindow:!1,type:"",url:""}
const l=n.linkTypes[i.type]
let o
l&&"input"===l.type?o=s.createElement(Hn,{disabled:t,key:i.type,link:i,linkType:l,onUpdate:r}):l&&"element"===l.type&&(o=s.createElement(Wn,{disabled:t,key:i.type,link:i,linkType:l,modalStorageKey:`tcf_${a.__type}_${n.name}_${l.type}`,onUpdate:r}))
const{allowNewWindow:c}=n
return s.createElement("div",{className:"tcfLinkWidget"},s.createElement("div",{className:"tcfLinkWidget--type"},s.createElement(Pe,{disabled:t,options:Object.keys(n.linkTypes).map(e=>({key:e,label:n.linkTypes[e].label})),value:i.type,onChange:e=>r(Object.assign(Object.assign({},i),{type:e}))})),o,c?s.createElement(Bt,{disabled:t,onChange:e=>r(Object.assign(Object.assign({},i),{openInNewWindow:e})),value:i.openInNewWindow},s.createElement(je,{value:"New window"})):null)}class qn{constructor(e){this.latitude=e.latitude,this.longitude=e.longitude}createStaticMap(e=100,t=75){const{latitude:n,longitude:s}=this,a=ce
if(!a)return new le.SafeString("")
const r=["key="+a,"center="+encodeURIComponent(`${n},${s}`),"markers="+encodeURIComponent(`size:small|${n},${s}`),`size=${e}x${t}`,"zoom=15","maptype=roadmap"].join("&")
return new le.SafeString(`\n      <img src="https://maps.googleapis.com/maps/api/staticmap?${r}" width="${e}" height="${t}" />\n    `)}toHTML(){return this.createStaticMap()}}Object(A.b)([ht],qn.prototype,"latitude",void 0),Object(A.b)([ht],qn.prototype,"longitude",void 0),Object(A.b)([mt],qn.prototype,"createStaticMap",null),Object(A.b)([mt],qn.prototype,"toHTML",null)
n(107),n(108)
function Xn({results:e,onSelect:t}){return s.createElement("div",{className:""},e.map(e=>s.createElement("div",{onClick:()=>t(e)},e.formatted_address)))}const Jn=["address","street","country","zip","city"]
class Kn extends s.Component{constructor(){super(...arguments),this.autocomplete=null,this.input=null,this.state={isSearching:!1},this.handlePlaceChanged=()=>{const{autocomplete:e}=this
if(!e)return
const t=e.getPlace()
t.geometry&&this.props.onLocation({latitude:t.geometry.location.lat(),longitude:t.geometry.location.lng()})},this.handleResolve=()=>{const{places:e}=this.props
e&&(this.setState({isSearching:!0}),e.findPlaceFromQuery({query:this.getResolveQuery(),fields:["formatted_address","geometry"]},this.handleResolveResults))},this.handleResolveResults=e=>{this.setState({isSearching:!1}),e||(e=[]),1===e.length?this.handleResultsSelect(e[0]):this.setState({results:e})},this.handleResultsSelect=({geometry:e})=>{if(!e)return
const{location:t}=e
this.props.onLocation({latitude:t.lat(),longitude:t.lng()}),this.handleResultsCancel()},this.handleResultsCancel=()=>{this.state.results&&this.setState({results:void 0})},this.setInput=e=>{let{autocomplete:t}=this
this.input=e,t&&(t.unbindAll(),t=null),e&&(t=new google.maps.places.Autocomplete(e),t.setFields(["geometry"]),t.addListener("place_changed",this.handlePlaceChanged)),this.autocomplete=t}}canResolve(){return""!==this.getResolveQuery()}getResolveQuery(){const{model:e}=this.props,t=[]
for(const n of Jn)n in e&&"string"==typeof e[n]&&t.push(e[n].trim())
return t.join(", ")}render(){let e
if(this.canResolve()){const{results:t}=this.state
let n
t&&0===t.length?n=s.createElement(mn,{icon:"material:error"},"No locations found"):t&&(n=s.createElement(Xn,{onSelect:this.handleResultsSelect,results:t})),e=s.createElement("div",{className:"tcfLocationFieldSearch--resolve"},n?s.createElement(It,{onClick:this.handleResultsCancel},n):null,s.createElement(Ce,{onClick:this.handleResolve},s.createElement(je,{value:"Resolve address"})))}return s.createElement("div",{className:"tcfLocationFieldSearch"},e,s.createElement("input",{className:"tcfLocationFieldSearch--input tcfInput",ref:this.setInput,type:"search"}))}}function Gn(e){return"object"==typeof e&&"number"==typeof e.latitude&&"number"==typeof e.longitude}n(109)
var Yn
!function(e){e[e.Loading=0]="Loading",e[e.Error=1]="Error",e[e.Ready=2]="Ready"}(Yn||(Yn={}))
class Qn extends s.Component{constructor(){super(...arguments),this.element=null,this.marker=null,this.state={instance:null,loadState:Yn.Loading},this.handleLocation=e=>{const{instance:t}=this.state
t&&(t.map.setZoom(17),t.map.setCenter({lat:e.latitude,lng:e.longitude})),this.props.onUpdate(e)},this.handleMarkerDragEnd=()=>{const{marker:e}=this
if(!e)return
const t=e.getPosition()
t&&this.props.onUpdate({latitude:t.lat(),longitude:t.lng()})},this.setElement=e=>{const{disabled:t}=this.props
let{instance:n}=this.state,{marker:s}=this
if(n&&(Qn.stashInstance(n),n=null),s&&(s.setMap(null),s.unbindAll(),s=null),e){n=Qn.createInstance(),e.appendChild(n.element)
const{map:a}=n
a.setZoom(17),a.setCenter(this.getLatLng()),s=new google.maps.Marker({draggable:!t,position:this.getLatLng(),map:a}),s.addListener("dragend",this.handleMarkerDragEnd)}this.element=e,this.marker=s,this.setState({instance:n})}}componentDidUpdate(e){const{marker:t}=this
e.disabled!==this.props.disabled&&t&&t.setOptions({draggable:!this.props.disabled})}componentWillMount(){try{(ue||(ue=new Promise(e=>{window.onGoogleMapsReady=()=>{de=ae.Loaded,e(google.maps)}
const t=document.createElement("script")
t.src=`https://maps.googleapis.com/maps/api/js?key=${ce}&libraries=places&callback=onGoogleMapsReady`,(document.head||document.body).appendChild(t),ue=ue,de=ae.Loading}))).then(()=>{this.setState({loadState:Yn.Ready})})}catch(e){this.setState({loadState:Yn.Error})}}getLatLng(){const{data:e}=this.props
return Gn(e)?{lat:e.latitude,lng:e.longitude}:{lat:0,lng:0}}render(){const{loadState:e,instance:t}=this.state,{disabled:n,model:a}=this.props,{marker:r}=this
let i
return r&&r.setPosition(this.getLatLng()),i=e===Yn.Loading?s.createElement(Qe,null):e===Yn.Error?s.createElement(hn,{title:"Could not load Google Maps"}):s.createElement(s.Fragment,null,n?null:s.createElement(Kn,{model:a,onLocation:this.handleLocation,places:t?t.places:null}),s.createElement("div",{className:"tcfLocation--map",ref:this.setElement})),s.createElement("div",{className:"tcfLocation"},i)}static createInstance(){let e=this.instanceStash.pop()
if(!e){const t=document.createElement("div")
t.className="tcfLocation--mapInstance"
const n=new google.maps.Map(t,{mapTypeControl:!1,streetViewControl:!1})
e={element:t,map:n,places:new google.maps.places.PlacesService(n)}}return e}static stashInstance(e){const{element:t}=e,{parentElement:n}=t
n&&n.removeChild(t),this.instanceStash.push(e)}}Qn.instanceStash=[]
n(110)
function Zn({data:e,disabled:t,errors:n,field:a,onUpdate:r}){const[i,l]=s.useState(!1),[o,c]=s.useState(e),{max:u,min:d,placeholder:m,unit:h}=a,p=i?o:e
const f=s.createElement("input",{autoComplete:"off",className:ve()("tcfNumberWidget--input text fullwidth",{error:n&&n.length}),disabled:t,max:null===u?void 0:u,min:null===d?void 0:d,onBlur:function(){l(!1),c(e)},onChange:function(e){const{value:t}=e.target
c(t),r(function({dataType:e,defaultValue:t,max:n,min:s,optional:a},r){let i="integer"===e?parseInt(r):parseFloat(r)
if(isFinite(i))"number"==typeof n&&i>n&&(i=n),"number"==typeof s&&i<s&&(i=s)
else{if(a)return null
i=t}return i}(a,t))},onFocus:function(){l(!0)},placeholder:m,type:"number",value:p})
return h?s.createElement("div",{className:"tcfNumberWidget"},f,s.createElement("div",{className:"tcfNumberWidget--unit"},h)):f}class es extends Wt{cloneValue(e){return Object(A.a)(this,void 0,void 0,(function*(){const{field:t,schemas:n,value:s}=e
return this.isValue(t,s)?s:this.createValue({field:t,schemas:n})}))}createValue({field:e}){return e.defaultValue}isValue({optional:e},t){return!(!e||null!==t)||("number"==typeof t||t instanceof Number)}preview({value:e}){return e}}class ts{constructor(e){this.value=e}get summary(){return new le.SafeString(`<div class="snippet">${this.value}</div>`)}toHTML(){return new le.SafeString(this.value)}}function ns({value:e}){return s.createElement("div",{className:"redactor-box redactor-styles-on redactor-toolbar-on focusable-input redactor-focus focus"},s.createElement("div",{className:"redactor-styles redactor-in redactor-in-0",dangerouslySetInnerHTML:{__html:e}}))}Object(A.b)([ht],ts.prototype,"value",void 0),Object(A.b)([ht],ts.prototype,"summary",null),Object(A.b)([mt],ts.prototype,"toHTML",null)
n(111)
class ss extends s.Component{constructor(){super(...arguments),this.element=null,this.hasFocus=!1,this.instance=null,this.renderedValue="",this.uuid="element-"+y(),this.handleBlur=()=>{this.hasFocus=!1},this.handleChange=(e,...t)=>{this.hasFocus&&(this.renderedValue=e,this.props.onUpdate(e))},this.handleFocus=()=>{this.hasFocus=!0},this.setElement=e=>{if(this.element===e)return
this.element=e
const{elementSiteId:t,options:n}=this.props
let{instance:s}=this
s&&(s.redactor&&(s.redactor.off("blur",this.handleBlur),s.redactor.off("changed",this.handleChange),s.redactor.off("focus",this.handleFocus)),s.destroy(),s=null),e&&(s=new Craft.RedactorInput(Object.assign(Object.assign({},n),{elementSiteId:t,id:this.uuid,redactorConfig:Object.assign({},n.redactorConfig)})),e.removeAttribute("name"),s.redactor&&(s.redactor.on("blur",this.handleBlur),s.redactor.on("changed",this.handleChange),s.redactor.on("focus",this.handleFocus))),this.instance=s}}componentDidUpdate(){const{hasFocus:e,instance:t,props:n,renderedValue:s}=this
t&&!e&&n.value!=s&&(this.renderedValue=n.value,t.redactor.source.setCode(n.value))}render(){const{value:e}=this.props
return s.createElement("div",{className:"tcfRedactorWidget"},s.createElement("textarea",{defaultValue:"string"==typeof e?e:"",id:this.uuid,ref:this.setElement}))}}function as(e){return e.disabled?s.createElement(ns,Object.assign({},e)):s.createElement(ss,Object.assign({},e))}var rs=Object(l.b)(e=>({elementSiteId:e.config.elementSiteId}))((function({data:e,disabled:t,elementSiteId:n,field:a,onUpdate:r}){return a.redactor?s.createElement(as,{disabled:t,elementSiteId:n,onUpdate:r,options:a.redactor,value:e}):null}))
let is=0
class ls extends Wt{cloneValue(e){return Object(A.a)(this,void 0,void 0,(function*(){const{field:t,translate:n,value:s}=e
return this.isValue(t,s)?t.translatable&&n?function(e,t){return Object(A.a)(this,void 0,void 0,(function*(){if(is>2)return console.warn(`Translator has returned to many errors, skipping translation for text "${e}".`),e
const{endpoint:n}=t,s=Object(A.c)(t,["endpoint"]),a=Object.assign(Object.assign({},s),{text:e}),r=Object.keys(a).map(e=>`${e}=${encodeURIComponent(a[e])}`).join("&")
return new Promise(t=>{fetch(`${n}&${r}`).then(e=>e.json()).then(n=>{t(n&&n.data?n.data:e)}).catch(n=>{console.error("Translator returned an error: "+n),is+=1,t(e)})})}))}(s,n):s:""}))}createValue(e){return""}isValue(e,t){return"string"==typeof t||t instanceof String}preview({value:e}){return e}}class os{constructor(e){this.reference=e}createPreview(e="large",t=!0){const{reference:n}=this,s=n.$element.clone(!1,!0)
s.removeClass("large removable small"),s.addClass(e)
const a=s.find(".elementthumb")
if(a.length){let t=a.find("img")[0]
t||(t=document.createElement("img"),t.srcset=a.attr("data-srcset")||"",a.append(t)),t.sizes="small"===e?"30px":"100px"}return t?`<div class="tcfInstancePreview--thumb ${e}">${a?a.html():""}</div>`:s[0].outerHTML}createSafePreview(e="large",t=!0){return new le.SafeString(this.createPreview(e,t))}get asBackground(){const{reference:e}=this,t=e.$element.find(".elementthumb").attr("data-srcset")
if(!t)return null
const n=t.split(",").pop()
return n?new le.SafeString(`<div class="tcfInstancePreview--background" style="background-image: url('${n.trim()}');"></div><div class="tcfInstancePreview--background blur" style="background-image: url('${n.trim()}');"></div>`):null}get asLargeElement(){return this.createSafePreview("large",!1)}get asLargeImage(){return this.createSafePreview("large",!0)}get asSmallElement(){return this.createSafePreview("small",!1)}get asSmallImage(){return this.createSafePreview("small",!0)}get label(){return this.reference.label}toHTML(){return new le.SafeString(this.toString())}toString(){return this.createPreview()}}Object(A.b)([ht],os.prototype,"reference",void 0),Object(A.b)([mt],os.prototype,"createPreview",null),Object(A.b)([mt],os.prototype,"createSafePreview",null),Object(A.b)([ht],os.prototype,"asBackground",null),Object(A.b)([ht],os.prototype,"asLargeElement",null),Object(A.b)([ht],os.prototype,"asLargeImage",null),Object(A.b)([ht],os.prototype,"asSmallElement",null),Object(A.b)([ht],os.prototype,"asSmallImage",null),Object(A.b)([ht],os.prototype,"label",null),Object(A.b)([mt],os.prototype,"toHTML",null),Object(A.b)([mt],os.prototype,"toString",null)
class cs extends Array{constructor(e){super(...function({context:{references:e},field:t,value:n}){const s=[]
if(!t)return s
const{elementType:a}=t
for(const t of n){const n=e.find(e=>e.id===t&&e.type===a)
n&&s.push(new os(n))}return s}(e))}get asBackground(){return this.length?this[0].asBackground:null}get asLargeElement(){return this.length?this[0].asLargeElement:null}get asLargeImage(){return this.length?this[0].asLargeImage:null}get asSmallElement(){return this.length?this[0].asSmallElement:null}get asSmallImage(){return this.length?this[0].asSmallImage:null}get firstLabel(){return this.length?this[0].label:""}get label(){return this._map(e=>e.label).join(", ")}toHTML(){return new le.SafeString(`<div class="tcfInstancePreview--elements">${this.toString()}</div>`)}toString(){return this._map(e=>ct(e)).join("")}_map(e){const t=[]
for(let n=0;n<this.length;n++)t.push(e(this[n],n))
return t}}function us({data:e,disabled:t,field:n,model:a,onUpdate:r}){return s.createElement(Vn,{criteria:n.criteria,disabled:t,data:e,elementType:n.elementType,limit:n.limit||null,modalStorageKey:n.modalStorageKey||`tcf_${a.__type}_${n.name}`,onUpdate:r,sources:n.sources||null,viewMode:n.viewMode})}Object(A.b)([ht],cs.prototype,"asBackground",null),Object(A.b)([ht],cs.prototype,"asLargeElement",null),Object(A.b)([ht],cs.prototype,"asLargeImage",null),Object(A.b)([ht],cs.prototype,"asSmallElement",null),Object(A.b)([ht],cs.prototype,"asSmallImage",null),Object(A.b)([ht],cs.prototype,"firstLabel",null),Object(A.b)([ht],cs.prototype,"label",null),Object(A.b)([mt],cs.prototype,"toHTML",null),Object(A.b)([mt],cs.prototype,"toString",null)
class ds extends Wt{createValue({field:e}){return e.defaultValue&&this.isValue(e,e.defaultValue)?e.defaultValue:e.options[0].key}isValue(e,t){return e.options.some(e=>e.key==t)}preview({field:e,value:t}){const n=e?e.options.find(e=>e.key===t):void 0
return n?n.label:"-"}}function ms({data:e,disabled:t,onUpdate:n,field:a}){return s.createElement(Pe,{disabled:t,onChange:n,options:a.options,value:e})}n(112)
function hs(e){let t
return e&&(t="color"in e?e.color:e.label),"string"==typeof t?t:"transparent"}class ps extends s.Component{constructor(){super(...arguments),this.state={isExpanded:!1},this.handleFlyoutClick=()=>{this.setState({isExpanded:!1})},this.handleSelect=e=>{this.props.onUpdate(e.key),this.setState({isExpanded:!1})},this.handleSwatchClick=e=>{e.currentTarget===e.target&&this.setState({isExpanded:!0})}}render(){const{data:e,disabled:t,field:n}=this.props,{isExpanded:a}=this.state,r=n.options.find(t=>t.key===e)
return s.createElement("div",{className:ve()("tcfSwatchColorWidget",{isUndecided:!r}),onClick:t?void 0:this.handleSwatchClick,style:{background:r?hs(r):void 0}},a&&!t?this.renderFlyout(r):null)}renderFlyout(e){const{field:t}=this.props
return s.createElement(It,{onClick:this.handleFlyoutClick},s.createElement("div",{className:"tcfSwatchColorWidget--swatches"},t.options.map(t=>s.createElement("div",{className:ve()("tcfSwatchColorWidget--swatch",{isSelected:t===e}),key:t.key,onClick:()=>this.handleSelect(t),style:{background:hs(t)}}))))}}function fs({data:e,disabled:t,errors:n,field:{maxLength:a,minLength:r,placeholder:i,inputType:l},onUpdate:o}){return s.createElement("input",{autoComplete:"off",className:ve()("tcfTextWidget text fullwidth",{error:n&&n.length}),disabled:t,maxLength:a,minLength:r,onChange:e=>o(e.target.value),placeholder:i,type:l,value:e?""+e:""})}n(113)
function gs({data:e,disabled:t,field:{maxLength:n,minLength:a,monospace:r,placeholder:i,rows:l},onUpdate:o}){return s.createElement("textarea",{className:ve()("tcfTextareaWidget text fullwidth",{monospace:r}),disabled:t,maxLength:n,minLength:a,onChange:e=>o(e.target.value),placeholder:i,rows:l,value:e})}b.initialize({array:new class extends Wt{constructor(){super({widget:Dt})}cloneValue(e){return Object(A.a)(this,void 0,void 0,(function*(){const{field:t,value:n}=e,s=Object(A.c)(e,["field","value"])
if(this.isValue(t,n)){const e=b.getDefinition(t.member.type),a=[]
for(const r of n)a.push(yield e.cloneValue(Object.assign(Object.assign({},s),{field:t.member,value:r})))
return a}return this.createValue(e)}))}createValue(e){return[]}isValue(e,t){return Array.isArray(t)}preview(e){return new ft(e)}},checkbox:new class extends Ht{constructor(){super({widget:zt}),this.isAlwaysPlainField=!0}},color:new class extends Wt{constructor(){super({widget:dn})}createValue(e){return{alpha:1,blue:255,green:255,red:255}}isValue(e,t){return Xt(t)}preview({context:e,value:t}){return""}},instance:new class extends Wt{constructor(){super({factory:wn,widget:Cn})}cloneValue(e){return Object(A.a)(this,void 0,void 0,(function*(){const{field:t,value:n}=e,s=Object(A.c)(e,["field","value"])
return this.isValue(t,n)?P(Object.assign(Object.assign({},s),{source:n})):this.createValue(e)}))}createValue({field:e,schema:t,schemas:n}){if(t||(t=n[e.schemas[0]]),!t)throw new Error("The option `schema` is required when creating instances.")
return v({schema:t,schemas:n})}isValue(e,t){return c(t)&&-1!==e.schemas.indexOf(t.__type)}preview({context:e,mode:t="default",value:n}){if(!c(n))return""
const s=e.schemas[n.__type]
if(!s)return""
const a="label"===t?s.previewLabelTemplate:s.previewTemplate
if(null===a)return s.label
const r={toHTML:()=>new le.SafeString(a(r,pt())),toString:()=>a(r,pt())}
r.depth=e.depth
for(const t of Object.keys(s.fields)){const a=s.fields[t],i=b.getDefinition(a)
i&&(r[t]=i.preview({context:Object.assign(Object.assign({},e),{depth:e.depth+1}),field:a,value:n[t]}))}return r}},layout:new class extends Wt{constructor(){super({widget:Un})}cloneValue(e){return Object(A.a)(this,void 0,void 0,(function*(){const{field:t,value:n}=e,s=Object(A.c)(e,["field","value"]),{schemas:a}=s
if(!this.isValue(t,n))return this.createValue(e)
const r=X(t,a),i=b.getDefinition(r),l=[]
for(let e=0;e<n.columns.length;e++){const o=n.columns[e],c=yield i.cloneValue(Object.assign({field:r,value:o.value},s))
l.push(B(t,a,o,c))}return{__role:"layout",__uuid:y(),preset:n.preset,columns:l}}))}createValue({field:e,schemas:t}){const n=this.getDefaultPreset(e)
let s
if(n)s=n.columns.map(n=>B(e,t,n))
else for(s=[];s.length<e.constraints.minColumns;)s.push(B(e,t))
return{__role:"layout",__uuid:y(),preset:n?n.key:null,columns:s}}getDefaultPreset({defaultPreset:e,presets:t}){const n=t.length?t[0]:null
return t.find(t=>t.key===e)||n}isValue(e,t){return K(t)}preview({context:e,field:t,value:n}){if(!t)return""
const{breakpoints:s,columnsPerRow:a}=t,r=X(t,e.schemas),i=b.getDefinition(r),l={breakpoints:s,current:s[s.length-1]},o=n.columns.map(t=>{const n=q(t.order,l),s=q(t.offset,l)/a,o=q(t.width,l)/a
return`<div style="${[`margin-left:${(100*s).toFixed(6)}%`,"order:"+n,`width:${(100*o).toFixed(6)}%`].join(";")}">${ct(i.preview({context:e,field:r,value:t.value}))}</div>`})
return new le.SafeString(`<div class="tcpRow">${o.join("")}</div>`)}},lightswitch:new class extends Ht{constructor(){super({widget:Fn})}},link:new class extends Wt{constructor(){super({widget:zn})}createValue(){return{elementId:0,hash:"",openInNewWindow:!1,type:"url",url:""}}isValue(e,t){return Bn(t)}preview(){return""}},location:new class extends Wt{constructor(){super({widget:Qn})}createValue({field:e}){return Gn(e.defaultValue)?Object.assign({},e.defaultValue):{latitude:0,longitude:0}}isValue(e,t){return Gn(t)}preview({value:e}){return new qn(e)}},number:new class extends es{constructor(){super({widget:Zn})}},oembed:new class extends Wt{constructor(){super({widget:gn})}createValue(e){return{url:""}}isValue(e,t){return pn(t)}preview({value:e}){return new bn(pn(e)?e:{url:""})}},redactor:new class extends ls{constructor(){super({widget:rs})}preview({value:e}){return new ts(e)}},reference:new class extends Wt{constructor(){super({widget:us})}createValue(e){return[]}isValue(e,t){return Array.isArray(t)&&t.every(e=>"number"==typeof e)}preview(e){return new cs(e)}},select:new class extends ds{constructor(){super({widget:ms})}},swatchcolor:new class extends ds{constructor(){super({widget:ps})}},text:new class extends ls{constructor(){super({widget:fs})}},textarea:new class extends ls{constructor(){super({widget:gs})}}})
n(114),n(115)
const bs=[],ys={},vs={create:e=>{try{let t=null
const n=document.getElementById(e)
if(!n)throw new Error("Root element not found.")
const o=n.querySelector(".tcfField--app"),c=n.querySelector('script[type="application/json"]'),u=n.querySelector("input.tcfField--model")
if(!u||!o||!c)throw new Error("Missing components.")
const d=Object(i.c)(ot,fe(c,u),Object(i.a)(r.a))
bs.push(d),d.subscribe(()=>{const{draftEditor:e}=window,n=JSON.stringify(d.getState().model)
u.value!==n&&e&&(t&&window.clearTimeout(t),t=window.setTimeout(()=>{e.checkForm(),t=null},500)),u.value=n}),a.render(s.createElement(l.a,{store:d},s.createElement(lt,null)),o)}catch(e){console.error("Could not start content editor: "+e.message)}},getInstanceApi:e=>{for(const t of bs){const n=u(t.getState(),e)
return n?se(t,n):null}},getValidator:function(e){return e in ys?ys[e]:null},registerValidator:(e,t)=>{ys[e]=t}}
if(window){const e=window;(e.lenz||(e.lenz={})).contentField=vs}var Es=t.default=vs}]))
