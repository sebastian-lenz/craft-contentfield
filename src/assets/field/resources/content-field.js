!function(){"use strict"
var e,t={400:function(e,t,n){n.d(t,{Z:function(){return Ls}})
var s=n(294),a=n(935),r=n(894),l=n(857),i=n(928)
function o(e,t){const n=e.schemas[t.__type]
if(!n)throw new Error(`Could not resolve schema "${t.__type}".`)
return n}function c(e){return e&&"object"==typeof e&&"__type"in e&&"__uuid"in e}function u(e,t,n){if(c(n)&&n.__uuid===t)return{model:n,path:[],uuid:t}
const s=o(e,n)
for(const a of Object.keys(s.fields)){const r=s.fields[a]
if("array"===r.type&&"instance"===r.member.type){const s=n[a]
if(!Array.isArray(s))continue
for(let n=0;n<s.length;n++){const r=u(e,t,s[n])
if(null!==r)return r.path.unshift({type:"index",name:a,index:n}),r}}else if("instance"===r.type){const s=u(e,t,n[a])
if(null!==s)return s.path.unshift({type:"property",name:a}),s}else if("layout"===r.type){const{columns:s}=n[a]
for(let n=0;n<s.length;n++){const r=u(e,t,s[n])
if(null!==r)return r.path.unshift({type:"property",name:a},{type:"index",name:"columns",index:n}),r}}}return null}function d(e,t){return u(e,t,e.model)}function m(e){const t=[]
let n=e
for(;n.length;){const s=/^([^\[\.]+)(?:\[(\d+)\])?\.?/.exec(n)
if(!s)throw new Error(`Invalid path segment "${n}" in path "${e}".`)
n=n.substr(s[0].length),3===s.length?t.push({index:parseInt(s[1]),name:s[2],type:"index"}):t.push({name:s[1],type:"property"})}return t}function h(e,t){if(!(t.name in e))return null
const n=e[t.name]
return"index"===t.type?!Array.isArray(n)||t.index<0||t.index>=n.length?null:n[t.index]:n}function p(e,t){"string"==typeof t&&(t=m(t))
let n=e
for(let e=0;e<t.length;e++)if(n=h(n,t[e]),!n)return null
return c(n)?n:null}function f(e,t){const n=(t="string"==typeof t?m(t):t.slice()).pop()
if(!n)return null
const s=p(e.model,t)
if(!s)throw new Error("Could not resolve owner")
const a=o(e,s),r="index"===n.type?n.index:void 0,l=a.fields[n.name]
if(!l)throw new Error(`Could not resolve field "${n.name}" on schema "${a.qualifier}".`)
return{field:l,index:r,owner:s,path:t,schema:a}}function g(e,t){return Craft.t("contentfield",e,t)}function y(e){return{references:e,type:"addReferences"}}var v=new class{initialize(e){this.definitions=e}createValue(e){return this.getDefinition(e.field).createValue(e)}getDefinition(e){return this.definitions["object"==typeof e?e.type:e]}}
function b(){return"10000000-1000-4000-8000-100000000000".replace(/[018]/g,(e=>(e^crypto.getRandomValues(new Uint8Array(1))[0]&15>>e/4).toString(16)))}function E(e){let{schemas:t,schema:n,oldModel:s}=e
const a={__errors:{},__type:n.qualifier,__uuid:b(),__visible:!0}
for(const e of Object.keys(n.fields)){const r=n.fields[e],l=v.getDefinition(r)
let i=s&&e in s?s[e]:void 0
void 0!==i&&l.isValue(r,i)||(i=l.createValue({field:r,schemas:t})),a[e]=i}return a}function w(e,t,n){if(!t)return n(e)
const s=e[t.name]
let a
if("index"===t.type){if(!Array.isArray(s))throw new Error("Invalid array access.")
if(t.index<0||t.index>=s.length)throw new Error(`Invalid array index ${t.index}".`)
a=s.slice(),a[t.index]=n(s[t.index])}else{if(Array.isArray(s))throw new Error("Invalid array access.")
a=n(s)}const r=Object.assign({},e)
return r[t.name]=a,r}function C(e,t,n){const s="string"==typeof t?m(t):t.slice()
let a=s.shift()
return w(e,a,(function e(t){return a=s.shift(),a?t?w(t,a,e):t:n(t)}))}function S(e,t){return e.name===t.name&&e.type===t.type&&("index"!==e.type||"index"!==t.type||e.index===t.index)}function _(e){const{sourcePath:t,sourceSegment:n,targetPath:s,targetSegment:a}=e,r=[...s,a]
if(r.length>t.length&&t.every(((e,t)=>S(e,r[t])))){const s=r[t.length]
if("index"!=s.type)throw new Error("Path segment type mismatch")
if(s.name==n.name&&s.index>n.index){r[t.length]=Object.assign(Object.assign({},s),{index:s.index-1})
const n=r.pop()
if(!n||"index"!==n.type)throw new Error("Unsupported operation")
return Object.assign(Object.assign({},e),{targetPath:r,targetSegment:n})}}return e}function O(e,t){return e.length===t.length&&e.every(((e,n)=>S(e,t[n])))}function x(e,t){const{sourcePath:n,sourceSegment:s,targetPath:a,targetSegment:r}=t,l=[...n,s],i=[...a,r],c=p(e.model,a)
if(!c)return!1
const u=o(e,c).fields[r.name],d=c[r.name]
if(!Array.isArray(d)||!u||"array"!==u.type)return!1
const m=_(t)
if(O(l,i)||O(l,[...m.targetPath,m.targetSegment]))return!1
if(!(O(n,a)&&r.name===s.name)&&u.limit>0&&d.length>=u.limit)return!1
const{member:h}=u,f=v.getDefinition(h.type),g=p(e.model,l)
return f.isValue(h,g)}function k(e){return Object.assign(Object.assign({},e),{type:"moveModel"})}function N(e){return{overlay:e,type:"setOverlay"}}const j="tcfUserState"
function M(e,t){if(!c(t))return
const n=e.schemas[t.__type]
n&&(t.__errors=Object.keys(n.fields).reduce(((e,s)=>{const a=function(e,t,n){const{validatorId:s}=e.fields[n]
if(!s)return null
const a=Ls.getValidator(s)
if(!a)return null
const r=[]
return a(n,t[n],r),r}(n,t,s)
return a&&a.length&&(e[s]=a),e}),{}))}function I(e,t){return{direction:t,type:"uuidOrder",uuid:e}}function L(e){return{type:"uuidVisibility",uuid:e}}function T(e,t,n){return{path:e,key:t,type:"updateValue",value:n}}function A(e){return{sync:e,type:"updateSync"}}var P=n(655)
function R(e){var{source:t}=e,n=(0,P._T)(e,["source"])
return(0,P.mG)(this,void 0,void 0,(function*(){const e=n.schemas[t.__type]
if(!e)throw new Error("Invalid source schema.")
const s={__errors:{},__originalUuid:t.__uuid,__type:e.qualifier,__uuid:b(),__visible:t.__visible}
for(const a of Object.keys(e.fields)){const r=e.fields[a],l=v.getDefinition(r)
s[a]=yield l.cloneValue(Object.assign(Object.assign({},n),{field:r,value:t[a]}))}return s}))}function U(e){var{apiEndpoint:t}=e,n=(0,P._T)(e,["apiEndpoint"])
const s=Object.keys(n).map((e=>`${e}=${encodeURIComponent(n[e])}`)).join("&")
return new Promise(((e,n)=>{fetch(`${t}&${s}`).then((e=>e.json())).then((t=>{!function(e){return"object"==typeof e&&"object"==typeof e.data&&!0===e.result&&Array.isArray(e.references)}(t)?n(t&&t.message?`${t.message}`:"An unknown error has occured."):e(t)})).catch((e=>{n(`${e}`)}))}))}function F(e){return c(e)?`[${e.__type}, ${e.__uuid}]`:"[no model]"}const D={group:console.groupCollapsed,groupEnd:console.groupEnd,info:console.info,model:F},W={group(){},groupEnd(){},info(){},model:F}
function V(e){return e&&e.verbose?D:W}function H(e){if(!Array.isArray(e))return[]
const t=[]
for(const n of e)c(n)&&t.push(n)
return t}function B(e,t){const n=null!==e.__originalUuid,s=null!==t.__originalUuid
return e.__uuid===t.__uuid||s&&e.__uuid===t.__originalUuid||n&&e.__originalUuid===t.__uuid||n&&s&&e.__originalUuid===t.__originalUuid}function z(e){var{field:t,source:n,target:s}=e,a=(0,P._T)(e,["field","source","target"])
return(0,P.mG)(this,void 0,void 0,(function*(){if("instance"!==t.member.type)return n||[]
const e=H(n),r=H(s),l=V(a),i=[]
for(const t of e){const e=r.findIndex((e=>B(e,t)))
let n
if(-1===e)l.info(`No array match for ${l.model(t)}`),n=yield R(Object.assign(Object.assign({},a),{source:t}))
else{const s=r[e]
l.info(`Array match for ${l.model(t)} is ${l.model(s)}`),r.splice(e,1),n=yield Z(Object.assign(Object.assign({},a),{source:t,target:s}))}n&&i.push(n)}if("remove"!==a.arrayOrphanMode)for(const e of r)"hide"===a.arrayOrphanMode?i.push(Object.assign(Object.assign({},e),{__visible:!1})):i.push(e)
return i}))}function q(e,t,n,s){const{key:a}=e.breakpoints[0]
return{__errors:{},__role:"layoutColumn",__type:e.columnTypeQualifier,__uuid:b(),__visible:!0,offset:n?Object.assign({},n.offset):{[a]:0},order:n?Object.assign({},n.order):{[a]:0},value:s||G(e,t),width:n?Object.assign({},n.width):{[a]:e.constraints.minColumnWidth}}}function G(e,t){const n=K(e,t)
return v.getDefinition(n).createValue({field:n,schemas:t})}function X(e,t){let{breakpoints:n,current:s}=t
for(let t=s.index;t>=0;t--){const{key:s}=n[t]
if(s in e)return e[s]}return 0}function K(e,t){return t[e.columnTypeQualifier].fields.value}function J(e,t,n){const{current:s}=n
return function(e,t,n){let{breakpoints:s}=n,a=NaN
return s.reduce(((n,s)=>{let{key:r}=s,l=isNaN(a)?t:a
return r in e&&(l=e[r]),l!==a&&(a=l,n[r]=l),n}),{})}(Object.assign(Object.assign({},e),{[s.key]:t}),0,n)}function Y(e){return"object"==typeof e&&"__uuid"in e&&"__role"in e&&"layout"===e.__role}function Q(e){var{field:t,source:n,target:s}=e,a=(0,P._T)(e,["field","source","target"])
return(0,P.mG)(this,void 0,void 0,(function*(){const e=V(a)
if(!Y(n))return e.info(`No source, skipping ${t.name}`),s
if(!Y(s))return s?e.info(`Type missmatch, cloning ${t.name}`):e.info(`No target, cloning ${t.name}`),function(e){var{source:t}=e,n=(0,P._T)(e,["source"])
return(0,P.mG)(this,void 0,void 0,(function*(){const e=[]
for(let s=0;s<t.columns.length;s++){const a=t.columns[s],r=yield R(Object.assign(Object.assign({},n),{source:a}))
e.push(Object.assign(Object.assign({},r),{__role:"layoutColumn",offset:Object.assign({},a.offset),order:Object.assign({},a.order),width:Object.assign({},a.width)}))}return{__role:"layout",__uuid:b(),columns:e,preset:t.preset}}))}(Object.assign(Object.assign({},a),{source:n}))
e.group(`Syncing layouts ${t.name}`)
const r=[]
for(let e=0;e<n.columns.length;e++){const t=n.columns[e],l=yield Z(Object.assign(Object.assign({},a),{source:t,target:s.columns[e]}))
r.push(Object.assign(Object.assign({},l),{__role:"layoutColumn",offset:Object.assign({},t.offset),order:Object.assign({},t.order),width:Object.assign({},t.width)}))}return e.groupEnd(),Object.assign(Object.assign({},s),{columns:r,preset:n.preset})}))}function Z(e){var{source:t,target:n}=e,s=(0,P._T)(e,["source","target"])
return(0,P.mG)(this,void 0,void 0,(function*(){const e=V(s)
if(!c(t))return e.info(`No source, skipping ${e.model(n)}`),n
if(!c(n)||n.__type!==t.__type)return n?e.info(`Type missmatch, cloning ${e.model(t)}`):e.info(`No target, cloning ${e.model(t)}`),R(Object.assign(Object.assign({},s),{source:t}))
const a=s.schemas[t.__type]
if(!a)throw new Error("Invalid schema")
const r=Object.assign({},n)
e.group(`Syncing model ${e.model(t)} > ${e.model(n)}`)
for(const l of Object.keys(a.fields)){const i=a.fields[l]
"layout"===i.type?(e.group(`Layout ${l}`),r[l]=yield Q(Object.assign(Object.assign({},s),{field:i,source:t[l],target:n[l]})),e.groupEnd()):"array"===i.type?(e.group(`Array ${l}`),r[l]=yield z(Object.assign(Object.assign({},s),{field:i,source:t[l],target:n[l]})),e.groupEnd()):"instance"===i.type&&(e.group(`Instance ${l}`),r[l]=yield Z(Object.assign(Object.assign({},s),{source:t[l],target:n[l]})),e.groupEnd())}return e.groupEnd(),r}))}function ee(e){return(t,n)=>(0,P.mG)(this,void 0,void 0,(function*(){try{yield function(e,t,n){var{siteId:s,syncMode:a}=e,r=(0,P._T)(e,["siteId","syncMode"])
return(0,P.mG)(this,void 0,void 0,(function*(){t(A({status:"working"}))
const{config:e,model:l,schemas:i}=n()
if("number"!=typeof e.elementId)throw new Error("Entry must be saved before it can be synchronized.")
const{data:o,references:u}=yield U({apiEndpoint:e.apiEndpoints.fetchSite,elementId:e.elementId,fieldHandle:e.fieldHandle,siteId:s})
if(!c(o)||!e.rootSchemas.some((e=>e===o.__type)))throw new Error("Selected target site does not contain a valid model.")
r.translate&&(r.translate.csrfParams={[e.csrfTokenName]:e.csrfTokenValue})
const d=c(l)&&l.__type===o.__type&&"clone"!==a?yield Z(Object.assign(Object.assign({},r),{schemas:i,source:o,target:l})):yield R(Object.assign(Object.assign({},r),{schemas:i,source:o}))
t(y(u)),t(T([],void 0,d)),t(A({status:"finished"}))}))}(e,t,n)}catch(e){t(A({status:"error",message:`${e}`}))}}))}const te={addReferences:function(e,t){const n=e.config.references.slice(),s=document.createElement("div")
for(const e of t.references)if(!n.some((t=>{let{id:n,type:s}=t
return e.id===n&&e.type===s}))){s.innerHTML=e.element
const t=s.firstElementChild
t&&(t.removeAttribute("style"),e.element=t.outerHTML),e.$element=$(e.element),e.hasThumb=e.$element.hasClass("hasthumb"),n.push(e)}return Object.assign(Object.assign({},e),{config:Object.assign(Object.assign({},e.config),{references:n})})},changeType:function(e,t){let{expandedState:n,newType:s,path:a}=t
const r=e.schemas[s]
if(!r)return e
const l=p(e.model,a),i=E({oldModel:l,schema:r,schemas:e.schemas})
return l&&n&&n.isExpanded(l.__uuid)&&(n.toggleExpanded(l.__uuid,!1),n.toggleExpanded(i.__uuid,!0)),Object.assign(Object.assign({},e),{model:C(e.model,a,(()=>i))})},moveModel:function(e,t){let{model:n}=e
if(!x(e,t))throw new Error("Invalid operation")
const{sourcePath:s,sourceSegment:a,targetPath:r,targetSegment:l}=_(t),i=p(n,[...s,a])
return n=C(n,s,(e=>{if(!e)throw new Error("Invalid operation")
let t=e[a.name]
if(!Array.isArray(t))throw new Error("Invalid operation")
return t=t.slice(),t.splice(a.index,1),Object.assign(Object.assign({},e),{[a.name]:t})})),n=C(n,r,(e=>{if(!e)throw new Error("Could not find target")
let t=e[l.name]
if(!Array.isArray(t))throw new Error("Unsupported operation")
return t=t.slice(),l.index>=t.length?t.push(i):t.splice(l.index,0,i),Object.assign(Object.assign({},e),{[l.name]:t})})),Object.assign(Object.assign({},e),{model:n})},setOverlay:function(e,t){let{overlay:n}=t
return Object.assign(Object.assign({},e),{overlay:n})},setUser:function(e,t){let{user:n}=t
const s=Object.assign(Object.assign({},e.user),n)
try{window.localStorage.setItem(j,JSON.stringify(s))}catch(e){console.error(e)}return Object.assign(Object.assign({},e),{user:s})},uuidInsert:function(e,t){let{position:n,uuid:s,value:a}=t
const r=d(e,s)
if(!r)return e
const l=f(e,r.path)
if(!l||"array"!==l.field.type||void 0===l.index)return e
const{field:i,index:o,path:c}=l,{name:u}=i
return Object.assign(Object.assign({},e),{model:C(e.model,c,(t=>{if(!t||!(u in t))return t
const s=t[u]
if(!Array.isArray(s))return t
const r=[...s],l=o+("after"===n?1:0)
r.splice(l,0,a)
const i=Object.assign(Object.assign({},t),{[u]:r})
return M(e,i),i}))})},uuidOrder:function(e,t){let{direction:n,uuid:s}=t
const a=d(e,s)
if(!a)return e
const r=f(e,a.path)
if(!r||"array"!==r.field.type||void 0===r.index)return e
const{field:l,index:i,path:o}=r,{name:c}=l
return Object.assign(Object.assign({},e),{model:C(e.model,o,(t=>{if(!t||!(c in t))return t
const s=t[c]
if(!Array.isArray(s))return t
const a=i+("up"===n?-1:1),r=[...s],l=r.splice(i,1)
r.splice(a,0,...l)
const o=Object.assign(Object.assign({},t),{[c]:r})
return M(e,o),o}))})},uuidRemove:function(e,t){let{uuid:n}=t
const s=d(e,n)
if(!s)return e
const a=f(e,s.path)
if(!a||"array"!==a.field.type||void 0===a.index)return e
const{field:r,index:l,path:i}=a,{name:o}=r
return Object.assign(Object.assign({},e),{model:C(e.model,i,(t=>{if(!t||!(o in t))return t
const n=t[o]
if(!Array.isArray(n))return t
const s=[...n]
s.splice(l,1)
const a=Object.assign(Object.assign({},t),{[o]:s})
return M(e,a),a}))})},uuidVisibility:function(e,t){let{uuid:n}=t
const s=d(e,n)
return s?Object.assign(Object.assign({},e),{model:C(e.model,s.path,(e=>e?Object.assign(Object.assign({},e),{__visible:!e.__visible}):e))}):e},updateSync:function(e,t){let{sync:n}=t,{overlay:s}=e
return s&&"synchronize"===s.type&&(s=Object.assign(Object.assign({},s),{preventClose:"working"===n.status})),Object.assign(Object.assign({},e),{overlay:s,sync:n})},updateValue:function(e,t){let{path:n,key:s,value:a}=t
return Object.assign(Object.assign({},e),{model:C(e.model,n,(t=>{const n=s?Object.assign(Object.assign({},t),{[s]:a}):a
return M(e,n),n}))})}}
const ne=[function(e){let{location:{uuid:t},owner:n}=e
return n&&"array"===n.field.type?{group:se.Manipulation,icon:"material:add",id:"create",invoke:function(e){let n=arguments.length>1&&void 0!==arguments[1]&&arguments[1]
e(N({afterCreate:n?"layer":"expand",type:"create",uuid:t}))},label:g("Create")}:null},function(e){let{location:{uuid:t}}=e
return{group:se.Manipulation,icon:"material:edit",id:"edit",invoke:e=>{e(N({type:"edit",uuid:t}))},label:g("Edit")}},function(e){let{owner:t,location:{uuid:n}}=e
return t&&"array"===t.field.type?{group:se.Manipulation,icon:"material:delete",id:"delete",invoke:e=>{e(function(e){return{type:"uuidRemove",uuid:e}}(n))},label:g("Delete")}:null},function(e){let{location:{uuid:t,model:{__visible:n}}}=e
return{group:se.Visibility,icon:n?"material:visibility_off":"material:visibility",id:"visibility",invoke:e=>{e(L(t))},label:g(n?"Hide":"Show")}},function(e){let{location:{uuid:t},owner:n}=e
if(!n||"array"!==n.field.type)return null
const s=n.owner[n.field.name]
return!Array.isArray(s)||void 0===n.index||n.index<=0?null:{group:se.Movement,icon:"material:arrow_upward",id:"moveUp",invoke:e=>e(I(t,"up")),label:g("Move up")}},function(e){let{location:{uuid:t},owner:n}=e
if(!n||"array"!==n.field.type)return null
const s=n.owner[n.field.name]
return!Array.isArray(s)||void 0===n.index||n.index>=s.length-1?null:{group:se.Movement,icon:"material:arrow_downward",id:"moveDown",invoke:e=>e(I(t,"down")),label:g("Move down")}},function(){return null},function(e){let{owner:t}=e
return null},function(e){let{owner:t}=e
return null}]
var se
function ae(e,t){const n=d(e,t)
if(!n)return[]
const s={location:n,owner:f(e,n.path),state:e}
return ne.map((e=>e(s))).filter((e=>null!==e))}function re(e,t){let{uuid:n}=t,s=null
return{getCommands:()=>ae(e.getState(),n).map((t=>Object.assign(Object.assign({},t),{invoke:()=>t.invoke(e.dispatch,!0)}))),subscribe:t=>{s&&s(),s=e.subscribe(t)},unsubscribe:()=>{s&&s(),s=null}}}!function(e){e[e.Manipulation=0]="Manipulation",e[e.Visibility=1]="Visibility",e[e.Movement=2]="Movement",e[e.Clipboard=3]="Clipboard"}(se||(se={}))
var le,ie=jQuery,oe=n.n(ie),ce=n(675),ue=n.n(ce)
let de
!function(e){e[e.Idle=0]="Idle",e[e.Loading=1]="Loading",e[e.Loaded=2]="Loaded"}(le||(le={}))
let me=null,he=le.Idle
function pe(e){return e&&"object"==typeof e&&"__uuid"in e}function fe(e,t){if(pe(e))return e
const n=function(e){switch(typeof e){case"boolean":return new Boolean(e)
case"number":return new Number(e)
case"object":return e
default:return new String(e)}}(e)
return Object.defineProperty(n,"__uuid",{value:t&&pe(t)?t.__uuid:b()}),n}function ge(e,t,n){const{fields:s}=t[e.__type]
n&&n.uniqueUuids&&(-1===n.uniqueUuids.indexOf(e.__uuid)?n.uniqueUuids.push(e.__uuid):(console.error(`Found duplicate uuid "${e.__uuid}".`),e.__uuid=b()))
for(const a of Object.keys(s)){const r=s[a]
"array"===r.type?e[a]=e[a].map((e=>"instance"===r.member.type?ge(e,t,n):fe(e))):"instance"===r.type&&(e[a]=ge(e[a],t,n))}return e}function ye(e){return"string"==typeof e&&""!==e.trim()?ue().compile(e):null}function ve(e,t){const n=JSON.parse(e.innerHTML)
n.user=function(){try{const t=window.localStorage.getItem(j)
if(null===t)throw new Error("User state missing")
const{favoriteSchemas:n={}}=JSON.parse(t)
return{favoriteSchemas:(e=n,Object.keys(e).reduce(((t,n)=>Array.isArray(e[n])?Object.assign(Object.assign({},t),{[n]:e[n]}):t),{}))}}catch(e){}var e
return{favoriteSchemas:{}}}(),n.sync={status:"idle"},n.config.references=n.config.references.map((e=>{const t=oe()(e.element)
return Object.assign(Object.assign({},e),{$element:t,hasThumb:t.hasClass("hasthumb")})}))
for(const e of Object.keys(n.schemas)){const t=n.schemas[e]
t.previewTemplate=ye(t.preview),t.previewLabelTemplate=ye(t.previewLabel)||t.previewTemplate}var s
let a
s=n.config.googleMapsApiKey,de=s,1===n.config.rootSchemas.length&&(a=n.schemas[n.config.rootSchemas[0]])
try{n.model=ge(JSON.parse(t.value),n.schemas,{uniqueUuids:[]})}catch(e){}return!a||c(n.model)&&n.model.__type===a.qualifier||(n.model=E({oldModel:n.model,schema:a,schemas:n.schemas})),n}var be=n(698),Ee=n(865),we=n(184),Ce=n.n(we)
function Se(e){var{children:t,className:n,outline:a,secondary:r}=e,l=(0,P._T)(e,["children","className","outline","secondary"])
return s.createElement("div",Object.assign({},l,{className:Ce()("tcfButtonFlat",n,{outline:a,secondary:r})}),t)}const _e=s.createContext({expanded:[],isExpanded:()=>!1,toggleExpanded:function(){}})
function Oe(e){let{children:t}=e
const[n,a]=s.useState([])
return s.createElement(_e.Provider,{value:{expanded:n,isExpanded:e=>-1!==n.indexOf(e),toggleExpanded:(e,t)=>{let s=[...n]
void 0===t&&(t=-1===n.indexOf(e)),t?s.push(e):s=s.filter((t=>t!==e)),a(s)}}},t)}function xe(e){let{children:t,disabled:n,onClick:a,primary:r,secondary:l}=e
return s.createElement("div",{className:Ce()("tcfButton btn",{disabled:n,submit:r,secondary:l}),onClick:e=>{e.preventDefault(),n||a(e)}},t)}function ke(e){let{className:t,params:n,value:a}=e
return s.createElement("span",{className:t},g(a,n))}function Ne(e){let{children:t,className:n}=e
return s.createElement("div",{className:Ce()("tcfWindow--content",n)},t)}function je(e){let{children:t,className:n,flex:a=!0}=e
return s.createElement("div",{className:Ce()("tcfWindow--footer flex-nowrap",n,{flex:a})},t)}function Me(e){let{children:t,className:n,width:a}=e
return s.createElement("div",{className:Ce()("tcfWindow",n),style:{width:a}},t)}!function(e){e.Content=Ne,e.Footer=je}(Me||(Me={}))
var Ie=Me
function Le(e){let{onClose:t}=e
return s.createElement(Ie,{width:600},s.createElement(Ie.Content,null,s.createElement(ke,{value:"Cannot create an element at the given location."})),s.createElement(Ie.Footer,null,s.createElement(xe,{onClick:t,secondary:!0},s.createElement(ke,{value:"Cancel"}))))}const Te="toolbar"
function $e(e){let{children:t,isBorderless:n,label:a,style:r}=e
return a&&""!==a&&a!==Te?s.createElement("div",{className:"tcfFieldGroup",style:r},s.createElement("div",{className:"tcfFieldGroup--label"},a),s.createElement("div",{className:"tcfFieldGroup--content"},t)):s.createElement("div",{className:Ce()("tcfFieldGroup--content",{isBorderless:n}),style:r},t)}function Ae(e){let{children:t,className:n,errors:a,instructions:r,isPlainField:l,isRequired:i,label:o,style:c}=e
if(l)return s.createElement(s.Fragment,null,t)
const u=a&&a.length
return s.createElement("div",{className:Ce()("tcfFieldPanel",n),style:c},s.createElement("div",{className:Ce()("tcfFieldPanel--label",{hasErrors:u,isRequired:i})},o),r?s.createElement("div",{className:"tcfFieldPanel--instructions"},r):null,a&&a.length?s.createElement("ul",{className:"tcfFieldPanel--errors"},a.map(((e,t)=>s.createElement("li",{className:"tcfFieldPanel--error",key:t},e)))):null,t)}function Pe(e,t){return e.label.localeCompare(t.label)}function Re(e){let{allowUndecided:t,className:n,disabled:a=!1,options:r,selectClassName:l,value:i,onChange:o}=e
const c=r.findIndex((e=>e.key==i)),u=t||-1===c
return s.createElement("div",{className:Ce()("tcfSelect",n)},s.createElement("select",{className:Ce()("tcfSelect--select",l),disabled:a,value:-1==c?void 0:c,onChange:a?void 0:function(e){let n=e.target.selectedIndex,s=null
u&&(n-=1),n>=0&&n<r.length&&(s=r[n].key),(null!==s||t)&&o(s)}},u?s.createElement("option",null,g("(No selection)")):null,r.map(((e,t)=>s.createElement("option",{key:t,value:t},e.indent?"--".repeat(e.indent)+" ":null,e.label)))))}const Ue=[{key:"before",label:"Before selected element"},{key:"after",label:"After selected element"}]
function Fe(e){let{Factory:t,field:n,onCreate:a,scope:r}=e
const[l,i]=s.useState("before")
return s.createElement(Ie,{width:600},s.createElement(Ie.Content,null,s.createElement($e,null,s.createElement(Ae,{instructions:g("Select where the new element should be inserted."),label:g("Position")},s.createElement(Re,{onChange:i,options:Ue.map((e=>Object.assign(Object.assign({},e),{label:g(e.label)}))),value:l})))),s.createElement(Ie.Footer,{flex:!1},s.createElement(t,{field:n,onCreate:e=>a(e,l),scope:r})))}function De(e){let{afterCreate:t="expand",uuid:n}=e
const a=(0,i.I0)(),r=s.useContext(_e),l=(0,i.v9)((e=>{const t=d(e,n)
if(!t||!t.path.length)return null
const s=f(e,t.path)
return s&&"array"===s.field.type&&void 0!==s.index?{field:s.field,model:s.owner}:null}))
if(null===l)return s.createElement(Le,{onClose:function(){a(N(null))}})
const{field:o,model:u}=l,{factory:m}=v.getDefinition(o.member.type)
return s.createElement(Fe,{Factory:m,field:o.member,onCreate:function(e,s){let l=null
c(e)&&("expand"===t?r.toggleExpanded(e.__uuid,!0):l={type:"edit",uuid:e.__uuid}),a(function(e,t,n){return{position:n,type:"uuidInsert",uuid:e,value:t}}(n,e,s)),a(N(l))},scope:u.__type})}function We(e){const{field:t}=e,{widget:n}=v.getDefinition(t)
return s.createElement(n,e)}function Ve(e,t){if(t)switch(e){case 0:return t.small
case 2:return t.large
default:return t.medium}}const He=s.createContext(2)
function Be(e){var{children:t}=e,n=(0,P._T)(e,["children"])
const[a,r]=s.useState(2),l=s.useRef(null)
return s.useEffect((()=>{const{ResizeObserver:e}=window,{current:t}=l
let n=-1,s=0
if(!t)return
const a=()=>{const e=t.offsetWidth
e!==s&&(s=e,r(s>920?2:s>580?1:0))}
if(e){const n=new e(a)
return n.observe(t),()=>n.unobserve(t)}{const e=()=>{n=window.requestAnimationFrame(e),a()}
return e(),()=>window.cancelAnimationFrame(n)}}),[]),s.createElement("div",Object.assign({ref:l},n),s.createElement(He.Provider,{value:a},t))}function ze(e,t){return e.index-t.index}var qe=(0,i.$j)(((e,t)=>({schema:e.schemas[t.model.__type]})),((e,t)=>({onUpdate:(n,s)=>{e(T(t.path,n,s))}})))((function(e){let{disabled:t=!1,isBorderless:n,model:a,onUpdate:r,path:l,schema:i}=e
const o=s.useContext(He)
if(!i)return s.createElement("div",null,`Could not resolve schema for "${a.__type}"`)
const c=[],u=Object.keys(i.fields)
let d
if(0===u.length)return s.createElement("div",{className:"tcfInstanceForm--empty"},s.createElement(ke,{value:"This element has no properties."}))
for(const e of u){const u=i.fields[e],m=a.__errors.hasOwnProperty(e)&&a.__errors[e]||null,{isAlwaysPlainField:h}=v.getDefinition(u)
if(!d||u.group){const e=u.group?u.group.label:void 0,t=u.group?Ve(o,u.group.style):void 0
d={index:e===Te?-1:c.length,label:e,fields:[],style:t},c.push(d)}d.fields.push(s.createElement(Ae,{errors:m,instructions:u.instructions,isPlainField:n||h,isRequired:u.isRequired,key:u.name,label:u.label,style:Ve(o,u.style)},s.createElement(We,{data:a[u.name],disabled:t,errors:m,field:u,model:a,onUpdate:t=>r(e,t),path:l})))}const m=c.sort(ze).map((e=>s.createElement($e,{isBorderless:n,key:e.index,label:e.label,style:e.style},e.fields))),h=Ve(o,i.style)
return h?s.createElement("div",{className:"tcfInstanceForm",style:h},m):s.createElement(s.Fragment,null,m)}))
class Ge extends s.Component{constructor(e){super(e),this.originalModel=null,this.handleCancel=()=>{this.close()},this.handleApply=()=>{this.close()},this.originalModel=e.model}close(){this.props.setOverlay(null)}render(){const{model:e,path:t}=this.props
return s.createElement(Oe,null,s.createElement(Ie,null,s.createElement(Ie.Content,null,s.createElement(qe,{model:e,path:t})),s.createElement(Ie.Footer,null,s.createElement(xe,{onClick:this.handleApply},s.createElement(ke,{value:"Apply"})))))}}var Xe=(0,i.$j)(((e,t)=>d(e,t.uuid)),(e=>({setOverlay:t=>e(N(t))})))(Ge)
const Ke="craft:",Je="material:"
function Ye(e){let{className:t,name:n,size:a}=e,r="craft"
return n.startsWith(Je)?(r="material",n=n.substr(Je.length)):n.startsWith(Ke)&&(n=n.substr(Ke.length)),s.createElement("div",{className:Ce()("tcfIcon",t,r,a)},n)}function Qe(e){let{message:t,onClose:n}=e
return s.createElement(s.Fragment,null,s.createElement(Ie.Content,null,s.createElement("div",{className:"tcfSynchronize--message"},s.createElement(Ye,{className:"tcfSynchronize--messageIcon error",name:"material:error",size:"huge"}),s.createElement("div",{className:"tcfSynchronize--title"},"An error has occured"),t?s.createElement("div",{className:"tcfSynchronize--message"},t):null)),s.createElement(Ie.Footer,null,s.createElement(xe,{onClick:n},"Close")))}function Ze(e){let{onClose:t}=e
return s.createElement(s.Fragment,null,s.createElement(Ie.Content,null,s.createElement("div",{className:"tcfSynchronize--message"},s.createElement(Ye,{className:"tcfSynchronize--messageIcon finished",name:"material:check_circle",size:"huge"}),s.createElement("div",{className:"tcfSynchronize--title"},s.createElement(ke,{value:"Sites have been synchronized"})),s.createElement("div",{className:"tcfSynchronize--message"},s.createElement(ke,{value:"If you are not happy with the results, do not save the entry. Reload this page to revert all changes."})))),s.createElement(Ie.Footer,null,s.createElement(xe,{onClick:t},s.createElement(ke,{value:"Close"}))))}class et extends s.Component{constructor(){super(...arguments),this.element=null,this.lightswitch=null,this.handleChange=()=>{const{disabled:e,onChange:t}=this.props,{lightswitch:n}=this
!e&&n&&t(n.on)},this.setElement=e=>{this.element!==e&&(this.element=e,this.updateInstance())}}componentDidUpdate(e){const{value:t}=this.props,{lightswitch:n}=this
e.disabled!==this.props.disabled?this.updateInstance():n&&n.on!==t&&n.toggle()}render(){const{className:e,disabled:t,small:n,value:a}=this.props
return s.createElement("div",null,s.createElement("div",{className:Ce()("lightswitch",e,{disabled:t,on:a,small:n}),ref:this.setElement,tabIndex:0},s.createElement("div",{className:"lightswitch-container"},s.createElement("div",{className:"label on"}),s.createElement("div",{className:"handle"}),s.createElement("div",{className:"label off"}))))}updateInstance(){const{element:e,handleChange:t,lightswitch:n}=this,{disabled:s,value:a}=this.props
n&&(n.destroy(),this.lightswitch=null),!s&&e&&(this.lightswitch=new Craft.LightSwitch(e,{onChange:t,value:a}))}}class tt extends s.Component{constructor(e){super(e),this.handleApply=e=>{const{currentSite:t,endpoint:n}=this.props,{arrayOrphanMode:s,site:a,syncMode:r,useTranslator:l}=this.state
if(!a)return
let i
l&&t&&a.language!==t.language&&(i={endpoint:n,source:a.language,target:t.language}),this.props.onSynchronize({arrayOrphanMode:s,siteId:a.id,syncMode:r,translate:i,verbose:"altKey"in e&&e.altKey})},this.handleArrayOrphanModeChange=e=>{this.setState({arrayOrphanMode:e})},this.handleSiteChange=e=>{this.setState({site:e})},this.handleSyncModeChange=e=>{this.setState({syncMode:e})},this.handleToggleTranslator=e=>{this.setState({useTranslator:e})},this.state={arrayOrphanMode:"hide",site:e.availableSites[0]||null,syncMode:"sync",useTranslator:!1}}render(){const{availableSites:e,currentSite:t,hasTranslator:n,onClose:a}=this.props,{arrayOrphanMode:r,site:l,syncMode:i,useTranslator:o}=this.state,c=e.map((e=>({label:e.label,key:e})))
return s.createElement(s.Fragment,null,s.createElement(Ie.Content,null,s.createElement("div",{className:"tcfSynchronize--title"},s.createElement(ke,{value:"Synchronize translations"})),s.createElement($e,null,s.createElement(Ae,{instructions:g("Select the site the content should be copied from."),label:g("Site")},s.createElement(Re,{onChange:this.handleSiteChange,options:c,value:l})),s.createElement(Ae,{instructions:g("Defines whether the synchronization should compare individual elements or clone the entire source."),label:g("Synchronization mode")},s.createElement(Re,{onChange:this.handleSyncModeChange,options:[{key:"sync",label:g("Compare elements, adds newly created elements")},{key:"clone",label:g("Clone the source, overwrites everything")}],value:i})),"sync"===i?s.createElement(Ae,{instructions:g("Defines what happens to elements that do not exist in the selected language."),label:g("Orphaned elements")},s.createElement(Re,{onChange:this.handleArrayOrphanModeChange,options:[{key:"hide",label:g("Hide orphaned elements")},{key:"none",label:g("Do nothing")},{key:"remove",label:g("Remove orphaned elements")}],value:r})):null,l&&t&&l.language!==t.language?s.createElement(Ae,{instructions:g(n?"Uses a webservice to automatically translate texts.":"A matching webservice must be configured in the options of this field in order to use this feature."),label:g("Translate texts automatically")},s.createElement(et,{disabled:!n,onChange:this.handleToggleTranslator,value:o})):null)),s.createElement(Ie.Footer,null,s.createElement(xe,{onClick:a,secondary:!0},s.createElement(ke,{value:"Cancel"})),s.createElement(xe,{onClick:this.handleApply,primary:!0},s.createElement(ke,{value:"Apply"}))))}}var nt=(0,i.$j)((e=>{const{apiEndpoints:t,elementSiteId:n,hasTranslator:s,supportedSites:a}=e.config
return{availableSites:a.filter((e=>e.id!==n)),currentSite:a.find((e=>e.id===n)),endpoint:t.translate,hasTranslator:s}}),(e=>({onSynchronize:t=>e(ee(t))})))(tt)
function st(){return s.createElement("div",{className:"tcfActivityIndicator"},s.createElement("div",{className:"tcfActivityIndicator--bounce first"}),s.createElement("div",{className:"tcfActivityIndicator--bounce second"}),s.createElement("div",{className:"tcfActivityIndicator--bounce third"}))}function at(){return s.createElement(Ie.Content,null,s.createElement("div",{className:"tcfSynchronize--working"},s.createElement(st,null)))}function rt(){const e=(0,i.v9)((e=>e.sync)),t=(0,i.I0)(),n=()=>t(N(null))
let a
return a="working"===e.status?s.createElement(at,null):"error"===e.status?s.createElement(Qe,{message:e.message,onClose:n}):"finished"===e.status?s.createElement(Ze,{onClose:n}):s.createElement(nt,{onClose:n}),s.createElement(Ie,{width:600},a)}const lt=s.createContext(0)
function it(e){let{children:t}=e
const n=s.useContext(lt)
return s.createElement(lt.Provider,{value:n+1},t)}function ot(e){let{disabled:t,dispatch:n,model:a,path:r,schemas:l}=e
const i=s.useContext(_e),o=l.map((e=>{let{qualifier:t,label:n}=e
return{key:t,label:n}}))
return o.sort(Pe),s.createElement(Ae,{className:"tcfInstance--controlsSchema",label:"Type"},s.createElement(Re,{disabled:t,onChange:e=>n(function(e,t,n){return{expandedState:n,newType:t,path:e,type:"changeType"}}(r,e,i)),options:o,value:a?a.__type:null}))}function ct(e){let{disabled:t,dispatch:n,model:a}=e
const r=a.__visible?"material:visibility":"material:visibility_off",l=s.createElement(s.Fragment,null,s.createElement(ke,{value:"Visibility"}),s.createElement(Ye,{className:Ce()("tcfInstance--controlsVisibilityIcon",{off:!a.__visible}),name:r}))
return s.createElement(Ae,{label:l,className:"tcfInstance--controlsVisibility"},s.createElement(xe,{disabled:t,onClick:()=>n(L(a.__uuid))},s.createElement(ke,{value:a.__visible?"Hide":"Show"})))}var ut=s.memo((function(e){let{canChangeVisibility:t=!1,canChangeType:n=!0,disabled:a=!1,isBorderless:r,model:l,path:o,schemaNames:u}=e
const d=(0,i.I0)(),m=(0,i.v9)((e=>u.map((t=>e.schemas[t]))))
let h=!1
c(l)&&(h=m.some((e=>e.qualifier===l.__type)))
const p=n&&m.length>1,f=t&&h&&!l.__visible
return s.createElement(it,null,s.createElement(Be,null,p||f?s.createElement("div",{className:"tcfInstance--controls"},p?s.createElement(ot,{disabled:a,dispatch:d,model:h?l:null,path:o,schemas:m}):null,f?s.createElement(ct,{disabled:a,dispatch:d,model:l}):null):null,h?s.createElement(qe,{disabled:a,model:l,isBorderless:r,path:o}):null))}))
class dt extends s.Component{constructor(e){super(e),this.element=null,this.handleMouseDown=e=>{const{onClick:t}=this.props
e.target===this.element&&t&&t()}
const t=document.createElement("div")
t.className="tcfOverlay",t.addEventListener("mousedown",this.handleMouseDown),document.body.appendChild(t),this.element=t}componentWillUnmount(){const{element:e}=this
e&&(document.body.removeChild(e),e.removeEventListener("mousedown",this.handleMouseDown),this.element=null)}render(){const{children:e}=this.props,{element:t}=this
return t?(0,a.createPortal)(e,t):null}}function mt(){const e=(0,i.I0)(),t=(0,i.v9)((e=>e.model)),n=(0,i.v9)((e=>e.overlay)),{disabled:a,hideSyncButton:r,rootSchemas:l,supportedSites:o}=(0,i.v9)((e=>e.config)),c=o.length>1
return s.createElement(be.W,{backend:Ee.PD},s.createElement(Oe,null,!c||a||r?null:s.createElement("div",{className:"tcfRoot--options"},s.createElement(Se,{onClick:()=>{e(A({status:"idle"})),e(N({type:"synchronize"}))},outline:!0},s.createElement(Ye,{name:"material:sync"}),s.createElement(ke,{value:"Synchronize translations"}))),s.createElement(ut,{disabled:a,model:t,path:[],schemaNames:l}),n?s.createElement(dt,{onClick:()=>{n&&!n.preventClose&&e(N(null))}},function(e){if(!e)return null
switch(e.type){case"create":return s.createElement(De,Object.assign({},e))
case"edit":return s.createElement(Xe,Object.assign({},e))
case"synchronize":return s.createElement(rt,null)}}(n)):null))}function ht(){let e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:{config:{apiEndpoints:{anchors:"",fetchSite:"",oembed:"",translate:""},csrfTokenName:"",csrfTokenValue:"",disabled:!1,elementId:null,elementSiteId:0,fieldHandle:"",hasTranslator:!1,references:[],rootSchemas:[],supportedSites:[]},model:{__errors:{},__type:"unknown",__uuid:"0",__visible:!0},overlay:null,schemas:{},sync:{status:"idle"},user:{favoriteSchemas:{}}},t=arguments.length>1?arguments[1]:void 0
return t.type in te?te[t.type](e,t):e}function pt(e){for(;"string"!=typeof e;)e=e.toHTML()
return e}const ft={},gt={},yt=(e,t)=>{ft[String(t)]=!0},vt=(e,t)=>{gt[String(t)]=!0}
function bt(){return{allowedProtoMethods:ft,allowedProtoProperties:gt}}class Et extends Array{constructor(e){super(...function(e){let{context:t,field:n,value:s}=e
if(!n)return[]
const{member:a}=n,r=v.getDefinition(a)
return s.map((e=>r.preview({value:e,field:a,context:t})))}(e))}get asColumn(){return this.toList("flexColumn")}get asList(){return this.toList("")}get asRow(){return this.toList("flexRow")}get first(){return new ce.SafeString(this.length?pt(this[0]):"")}get one(){return this.first}toHTML(){return new ce.SafeString(this.toString())}toList(e){return new ce.SafeString(`<ul class="${e}">${this.map((e=>`<li>${pt(e)}</li>`)).join("")}</ul>`)}toString(){return this.map((e=>pt(e))).join("")}}(0,P.gn)([vt],Et.prototype,"asColumn",null),(0,P.gn)([vt],Et.prototype,"asList",null),(0,P.gn)([vt],Et.prototype,"asRow",null),(0,P.gn)([vt],Et.prototype,"first",null),(0,P.gn)([vt],Et.prototype,"one",null),(0,P.gn)([yt],Et.prototype,"toHTML",null),(0,P.gn)([yt],Et.prototype,"toList",null),(0,P.gn)([yt],Et.prototype,"toString",null)
var wt=n(200)
const Ct="tcf:Member"
function St(e,t){return(0,wt.c)({type:Ct,item:()=>({data:e.child,height:t.current?t.current.clientHeight:100,path:e.path}),canDrag:()=>!e.disabled,collect:e=>({isDragging:e.isDragging()}),isDragging:t=>O(e.path,t.getItem().path)})}var _t=n(240)
function Ot(e,t){const n=(0,i.oR)()
return(0,_t.L)({accept:Ct,drop:e=>({item:e}),hover:(s,a)=>{if(!a.isOver({shallow:!0}))return
const r=function(e,t,n){const{current:s}=n,a=t.getClientOffset()
if(!s||!a||!e)return null
const{bottom:r,top:l}=s.getBoundingClientRect(),i=a.y-l
return s.classList.contains("isExpanded")&&i>32&&i<r-l-32?null:(i>(r-l)/2&&(e.targetSegment=Object.assign(Object.assign({},e.targetSegment),{index:e.targetSegment.index+1})),e)}(function(e,t){const n=e.path.slice(),s=n.pop()
if(!s||"index"!==s.type)return null
const a=t.path.slice(),r=a.pop()
return r&&"index"===r.type?{sourcePath:a,sourceSegment:r,targetPath:n,targetSegment:s}:null}(e,s),a,t)
if(!r||!x(n.getState(),r))return
const l=k(r),{targetPath:i,targetSegment:o}=_(l)
s.path=[...i,o],n.dispatch(l)}})}function xt(e){const{child:t,depth:n,disabled:a,field:r,index:l,model:i,onDelete:o,onUpdate:c,path:u}=e,d=s.useRef(null),[{isDragging:m},h,p]=St(e,d),[,f]=Ot(e,d)
f(d)
return s.createElement("div",{className:Ce()(`tcfArrayWidgetMember depth-${n}`,{isDragging:m}),ref:d},p(s.createElement("div",{className:"tcfArrayWidgetMember--panel tcfArrayWidgetMember--single"},h(s.createElement("div",{className:Ce()("tcfArrayWidgetMember--singleHandle",{enabled:!a})},s.createElement(Ye,{className:"tcfArrayWidgetMember--singleHandleIcon",key:"handle",name:"move"}))),s.createElement("div",{className:"tcfArrayWidgetMember--singleBody"},s.createElement(We,{data:t,disabled:a,errors:[],field:r,model:i,onUpdate:e=>{c(l,e)},path:u})),a?null:s.createElement("div",{className:"tcfArrayWidgetMember--singleActions"},s.createElement("div",{className:"tcfArrayWidgetMember--singleActionsButton",onClick:()=>{o(l)}},s.createElement(Ye,{name:"remove"}))))))}function kt(e){const t=s.useRef(null),[,n]=function(e){const t=(0,i.oR)()
return(0,_t.L)({accept:Ct,drop:e=>({item:e}),hover:(n,s)=>{if(!s.isOver({shallow:!0}))return
const a=function(e,t){const n=t.path.slice(),s=n.pop()
return s&&"index"===s.type?{sourcePath:n,sourceSegment:s,targetPath:e.path,targetSegment:{type:"index",index:0,name:e.field.name}}:null}(e,n)
if(!a||!x(t.getState(),a))return
const r=k(a),{targetPath:l,targetSegment:i}=_(r)
n.path=[...l,i],t.dispatch(r)}})}(e)
return n(t),s.createElement("div",{className:"tcfArrayWidgetList--empty",key:"empty",ref:t},s.createElement(ke,{value:"Drop elements here"}))}class Nt extends s.Component{constructor(e){super(e),this.element=null,this.handleAnimationEnd=()=>{const{element:e}=this
e&&(e.style.height="",e.style.transition=""),this.setState({inTransition:!1,lastChildren:null,lastUri:null})},this.setElement=e=>{this.element=e},this.state={currentChildren:e.children,currentUri:e.uri,inTransition:!1,lastChildren:null,lastUri:null}}componentDidUpdate(e,t,n){const{element:s}=this
s&&n&&setTimeout((()=>{s.style.height=""
const e=s.offsetHeight
s.style.height=`${n.height}px`,s.getBoundingClientRect(),s.style.transition="height 200ms",s.style.height=`${e}px`}),0)}getSnapshotBeforeUpdate(e,t){const{element:n}=this
if(t.currentUri!==this.state.currentUri&&n){const e=n.offsetHeight
return n.style.height=`${e}px`,{height:e}}return null}render(){const{className:e,itemClassName:t}=this.props,{currentChildren:n,currentUri:a,inTransition:r,lastChildren:l,lastUri:i}=this.state,o=[]
return r&&i&&o.push(s.createElement("div",{className:Ce()(t,"tcfDetailsPanel--item","from"),key:i},l)),o.push(s.createElement("div",{className:Ce()(t,"tcfDetailsPanel--item",{to:r}),key:a,onAnimationEnd:this.handleAnimationEnd},n)),s.createElement("div",{className:Ce()(e,"tcfDetailsPanel"),ref:this.setElement},o)}static getDerivedStateFromProps(e,t){return e.uri===t.currentUri?Object.assign(Object.assign({},t),{currentChildren:e.children}):e.uri===t.currentUri||t.inTransition?null:{inTransition:!0,lastChildren:t.currentChildren,lastUri:t.currentUri,currentChildren:e.children,currentUri:e.uri}}}function jt(e){let{children:t,onClick:n,primary:a}=e
return s.createElement("div",{className:Ce()("tcfArrayWidgetMember--headerActionsButton",{primary:a}),onClick:e=>{e.preventDefault(),n()}},t)}let Mt=null
function It(){return null===Mt&&(Mt=new Craft.ElementThumbLoader),Mt}function Lt(e){let{className:t,model:n,schema:a,size:r="small"}=e
const l=s.useRef(null),o=(0,i.v9)((e=>e.config.references)),c=function(e,t){const{previewImage:n}=t
if(!n)return null
const s=n in e?e[n]:null
if(!Array.isArray(s)||0===s.length)return null
const a=s[0]
return"number"==typeof a?a:null}(n,a),u=o.find((e=>e.id===c))
return s.useEffect((()=>{if(l.current){const e=$(".element",l.current)
Craft.setElementSize(e,r),It().load(e)}}),[l.current,u]),u&&u.hasThumb?s.createElement("div",{className:Ce()("tcfInstancePreviewImage",t,r),dangerouslySetInnerHTML:{__html:u.element},ref:l}):s.createElement("div",{className:Ce()("tcfInstancePreviewImage empty",t,r)})}var Tt=s.memo((function(e){var{field:t,model:n,references:a,schemas:r}=e,l=(0,P._T)(e,["field","model","references","schemas"])
const i=pt(v.getDefinition("instance").preview({context:{depth:0,references:a,schemas:r},field:t,mode:"label",value:n})).replace(/<[^>]*>?/gm,"").replace(/[\n\t\r]+/g,"").trim().substr(0,256)
return s.createElement("div",Object.assign({},l),i)}),(function(e,t){return e.model===t.model}))
function $t(e){const{references:t,schemas:n}=(0,i.v9)((e=>({references:e.config.references,schemas:e.schemas})))
return s.createElement(Tt,Object.assign({},e,{references:t,schemas:n}))}function At(e){let{command:t,onClick:n}=e
return s.createElement("div",{className:"tcfArrayWidgetMember--headerMoreItem",onMouseUp:n},s.createElement(Ye,{className:"tcfArrayWidgetMember--headerMoreItemIcon",name:t.icon}),s.createElement("span",{className:"tcfArrayWidgetMember--headerMoreItemLabel"},t.label))}var Pt=(0,i.$j)(((e,t)=>{let{uuid:n}=t
return{commands:ae(e,n)}}),(e=>({dispatch:e})))((function(e){let{commands:t,dispatch:n,onClose:a}=e
const r=[]
let l
for(const e of t)"edit"!==e.id&&(void 0!==l&&l!==e.group&&r.push(s.createElement("div",{className:"tcfArrayWidgetMember--headerMoreDivider",key:`${e.id}-divider`})),l=e.group,r.push(s.createElement(At,{command:e,key:e.id,onClick:()=>{a(),e.invoke(n)}})))
return s.createElement("div",{className:"tcfArrayWidgetMember--headerMoreMenu"},r)}))
class Rt extends s.Component{constructor(){super(...arguments),this.handle=null,this.handleStyle={left:"0px"},this.origin=null,this.panel=null,this.panelClassName="tcfFlyout--panel",this.panelStyle={left:"0px",top:"0px"},this.handleResize=()=>{this.update()},this.setHandle=e=>{this.handle=e,this.update()},this.setOrigin=e=>{this.origin=e,this.update()},this.setPanel=e=>{this.panel=e,this.update()}}componentDidMount(){window.addEventListener("resize",this.handleResize)}componentWillUnmount(){window.removeEventListener("resize",this.handleResize)}render(){const{children:e,onClick:t}=this.props
return s.createElement("div",{className:"tcfFlyout",ref:this.setOrigin},s.createElement(dt,{onClick:t},s.createElement("div",{className:this.panelClassName,ref:this.setPanel,style:Object.assign({},this.panelStyle)},s.createElement("div",{className:"tcfFlyout--handle",ref:this.setHandle,style:Object.assign({},this.handleStyle)}),s.createElement("div",{className:"tcfFlyout--body"},e))))}update(){const{handle:e,handleStyle:t,origin:n,panel:s,panelStyle:a}=this
if(!n||!s||!e)return
const r=n.getBoundingClientRect(),l=s.getBoundingClientRect()
let i="tcfFlyout--panel"
const o=Math.max(10,Math.min(window.innerWidth-l.width-10,r.left+.5*(r.width-l.width))),c=Math.max(10,Math.min(l.width-10,r.left+.5*r.width-o))
t.left=`${c}px`,a.left=`${o}px`,r.top+.5*r.height>.5*window.innerHeight?(i+=" above",a.top=r.top-l.height-5+"px"):(i+=" below",a.top=`${r.top+r.height+5}px`),e.style.left=t.left,s.className=this.panelClassName=i,s.style.left=a.left,s.style.top=a.top}}class Ut extends s.Component{constructor(){super(...arguments),this.state={isExpanded:!1},this.handleClose=()=>{this.setState({isExpanded:!1})},this.handleMouseDown=()=>{this.setState({isExpanded:!0})}}render(){const{uuid:e}=this.props,{isExpanded:t}=this.state
return s.createElement("div",{className:"tcfArrayWidgetMember--headerMore"},s.createElement("div",{className:"tcfArrayWidgetMember--headerMoreButton",onMouseDown:this.handleMouseDown},s.createElement(Ye,{name:"material:more_vert"})),t?s.createElement(Rt,{onClick:this.handleClose},s.createElement(Pt,{onClose:this.handleClose,uuid:e})):null)}}function Ft(e){return e}function Dt(e,t){return t?e?"minus":"plus":e?"done":"edit"}function Wt(e){let{disabled:t,dragSource:n=Ft,field:a,hasPreview:r,isCollapsible:l,isExpanded:i,model:o,onToggleExpanded:c,schema:u}=e
const d=[]
return u?(d.push(s.createElement(Ye,{key:"icon",name:u.icon})),u.previewImage&&d.push(s.createElement(Lt,{key:"image",model:o,schema:u})),d.push(s.createElement("div",{className:Ce()("tcfArrayWidgetMember--headerLabel",{isHidden:!o.__visible}),key:"label"},u.label)),r&&u.previewLabelTemplate&&d.push(s.createElement("div",{className:"tcfArrayWidgetMember--headerPreview",key:"preview"},s.createElement($t,{field:a,model:o})))):d.push(s.createElement(Ye,{className:"tcfArrayWidgetMember--headerHandleIcon",key:"handle",name:"move"})),s.createElement("div",{className:"tcfArrayWidgetMember--header"},n(s.createElement("div",{className:Ce()("tcfArrayWidgetMember--headerHandle",{enabled:!t}),onClick:c},d)),o.__visible?null:s.createElement(Ye,{className:"tcfArrayWidgetMember--headerVisibility",name:"material:visibility_off"}),s.createElement("div",{className:"tcfArrayWidgetMember--headerActions"},l?s.createElement(jt,{onClick:c,primary:!t},s.createElement(Ye,{name:Dt(i,t)})):null,t?null:s.createElement(Ut,{uuid:o.__uuid})))}var Vt=s.memo((function(e){let{field:t,model:n,mode:a="default",references:r,schemas:l}=e
const i=v.getDefinition("instance").preview({context:{depth:0,references:r,schemas:l},field:t,mode:a,value:n})
try{const e={__html:pt(i)}
return s.createElement("div",{className:Ce()("tcfInstancePreview--content",a),dangerouslySetInnerHTML:e})}catch(e){return s.createElement(s.Fragment,null,s.createElement("p",null,s.createElement("span",{className:"tcfIcon material"},"error"),s.createElement("span",null,"Could not render preview.")),(o=e)&&"object"==typeof o&&"message"in o?s.createElement("pre",null,e.message):null)}var o}),(function(e,t){return e.model===t.model}))
function Ht(e){let{className:t,field:n,model:a,mode:r,onClick:l}=e
const{references:o,schemas:c}=(0,i.v9)((e=>({references:e.config.references,schemas:e.schemas})))
return s.createElement("div",{className:Ce()("tcfInstancePreview",t,{isClickable:!!l}),onClick:l},s.createElement(Vt,{field:n,model:a,mode:r,references:o,schemas:c}))}function Bt(e){const{isExpanded:t,toggleExpanded:n}=s.useContext(_e),a=s.useRef(null),[{isDragging:r},l,i]=St(e,a),[,o]=Ot(e,a)
o(a)
const{child:c,depth:u,disabled:d,field:m,isCollapsible:h,path:p,previewMode:f,schema:g}=e,y=()=>{n(c.__uuid)}
let v=!0,b=!1
if(g){const e=Object.keys(g.fields)
v=e.length>0,b=1===e.length&&"redactor"===g.fields[e[0]].type}const E=g&&g.preview&&function(e,t){switch(e){case"always":return!0
case"root":return 1===t}}(f,u),w=v&&(!h||t(c.__uuid))
let C
return w?C=s.createElement("div",{className:"tcfArrayWidgetMember--body"},s.createElement(ut,{canChangeType:!1,disabled:d,isBorderless:b,key:"details",model:c,path:p,schemaNames:m.schemas})):E&&(C=s.createElement(Ht,{className:"tcfArrayWidgetMember--preview",field:m,key:"summary",model:c,onClick:v?y:void 0})),s.createElement("div",{className:Ce()(`tcfArrayWidgetMember depth-${u}`,w?"isExpanded":"isCollapsed",{isDragging:r}),ref:a},i(s.createElement("div",{className:"tcfArrayWidgetMember--panel"},s.createElement(Wt,{disabled:d,dragSource:l,field:m,hasPreview:!w&&!E,isCollapsible:v&&h,isExpanded:w,model:c,onToggleExpanded:y,schema:g}),s.createElement(Nt,{uri:w?"details":"summary"},C))))}function zt(e){let{children:t,data:n,disabled:a,field:r,model:l,onDelete:o,onUpdate:c,path:u}=e
const{member:d,collapsible:m,previewMode:h}=r,p=s.useRef(null),f=(0,i.v9)((e=>e.schemas)),g=s.useContext(lt),y=n.map(((e,t)=>{const n=[...u,{index:t,name:d.name,type:"index"}],r={child:e,depth:g,disabled:a,path:n}
return"instance"===d.type?s.createElement(Bt,Object.assign({},r,{isCollapsible:m,field:d,key:e.__uuid,previewMode:h,schema:f[e.__type]})):s.createElement(xt,Object.assign({},r,{field:d,index:t,key:pe(e)?e.__uuid:t,model:l,onDelete:o,onUpdate:c}))}))
return 0===y.length&&y.push(s.createElement(kt,{field:r,key:"droplet",path:u})),s.createElement(s.Fragment,null,s.createElement("div",{className:"tcfArrayWidgetList",ref:p},y),s.createElement("div",{className:"tcfArrayWidgetList--footer"},t))}class qt extends s.Component{constructor(){super(...arguments),this.handleAdd=e=>{const{context:t}=this,{data:n,disabled:s,onUpdate:a}=this.props
if(s)return
const r=Array.isArray(n)?n.slice():[]
r.push(fe(e)),a(r),c(e)&&t&&t.toggleExpanded(e.__uuid,!0)},this.handleDelete=e=>{const{data:t,disabled:n,onUpdate:s}=this.props
if(n||!Array.isArray(t))return
const a=t.slice()
a.splice(e,1),s(a)},this.handleUpdate=(e,t)=>{const{data:n,disabled:s,onUpdate:a}=this.props
if(s||!Array.isArray(n))return
const r=n.slice()
r[e]=fe(t,r[e]),a(r)}}render(){const{data:e,disabled:t,field:n,model:a,path:r}=this.props,{limit:l}=n
if(!n.member)return null
const i=Array.isArray(e)?e:[],o=l>0&&i.length>=l,c=v.getDefinition(n.member)
let u
return t||!c||o||(u=s.createElement(c.factory,{field:n.member,onCreate:this.handleAdd,scope:a.__type})),s.createElement(zt,{data:i,disabled:t,field:n,limit:l,model:a,onDelete:this.handleDelete,onUpdate:this.handleUpdate,path:r},u)}}function Gt(e){if(!e)return e
if(Array.isArray(e))return e.map((e=>Gt(e)))
if("object"==typeof e){const t={}
for(const n in e)t[n]=Gt(e[n])
return t}return e}function Xt(e){let{field:t,onCreate:n}=e
const a=(0,i.v9)((e=>e.schemas))
return s.createElement("div",{className:"tcfFactory"},s.createElement(Se,{className:"tcfFactory--primaryButton",onClick:()=>{const e=v.createValue({field:t,schemas:a})
n(e)},secondary:!0},s.createElement(Ye,{name:"plus"}),s.createElement(ke,{value:"Create"})))}qt.contextType=_e
class Kt{constructor(e){let{factory:t,widget:n}=e
this.factory=t||Xt,this.widget=n}cloneValue(e){return(0,P.mG)(this,void 0,void 0,(function*(){const{field:t,value:n}=e
return this.isValue(t,n)?Gt(n):this.createValue(e)}))}}class Jt extends Kt{createValue(e){return!!e.field.defaultValue}isValue(e,t){return"boolean"==typeof t||t instanceof Boolean}preview(e){let{value:t}=e
return t}}class Yt extends s.Component{constructor(){super(...arguments),this.id=b()}render(){const{id:e}=this,{className:t,children:n,disabled:a,onChange:r,value:l}=this.props
return s.createElement("dl",{className:Ce()("tcfCheckbox",t)},s.createElement("dd",{className:"tcfCheckbox--input"},s.createElement("input",{checked:l,disabled:a,id:e,onChange:a?void 0:()=>r(!l),type:"checkbox"})),s.createElement("dt",{className:"tcfCheckbox--label"},s.createElement("label",{htmlFor:e},n)))}}function Qt(e){let{data:t,disabled:n,field:a,onUpdate:r}=e
return s.createElement(Yt,{disabled:n,onChange:r,value:!!t},a.label)}function Zt(e){let{red:t,green:n,blue:s,alpha:a}=e
return{max:Math.max(t,n,s),min:Math.min(t,n,s),red:t/255,green:n/255,blue:s/255,alpha:a}}function en(e){return"object"==typeof e&&"number"==typeof e.alpha&&"number"==typeof e.blue&&"number"==typeof e.green&&"number"==typeof e.red}function tn(e){e=e.replace(/^#?([a-f\d])([a-f\d])([a-f\d])$/i,(function(e,t,n,s){return t+t+n+n+s+s}))
const t=/^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(e)
return t?{red:parseInt(t[1],16),green:parseInt(t[2],16),blue:parseInt(t[3],16),alpha:1}:null}function nn(e){return`rgba(${e.red},${e.green},${e.blue},${e.alpha})`}function sn(e){const{alpha:t,blue:n,green:s,max:a,min:r,red:l}=Zt(e),i=0===a?0:(a-r)/a,o=(a-r)/255
let c=0,u=a/255
return a===r||(c=a===e.red?(s-n)/o+(s<n?6:0):a===e.green?(n-l)/o+2:(l-s)/o+4,c/=6),{hue:c,saturation:i,value:u,alpha:t}}const an=s.createContext({css:"#000",hsv:{hue:0,saturation:0,value:0,alpha:0},rgb:{red:0,green:0,blue:0,alpha:0},onHsvColor:e=>{},onRgbColor:e=>{}})
function rn(e){return function(t){return s.createElement(an.Consumer,null,(n=>s.createElement(e,Object.assign({},t,n))))}}class ln extends s.Component{constructor(e){super(e),this.timeout=null,this.commit=()=>{null!==this.timeout&&window.clearTimeout(this.timeout),this.timeout=window.setTimeout(this.handleTimeout,250)},this.handleHsvColor=e=>{const t=function(e){let{alpha:t,hue:n,saturation:s,value:a}=e,r=0,l=0,i=0
const o=Math.floor(6*n),c=6*n-o,u=a*(1-s),d=a*(1-c*s),m=a*(1-(1-c)*s)
switch(o%6){case 0:r=a,l=m,i=u
break
case 1:r=d,l=a,i=u
break
case 2:r=u,l=a,i=m
break
case 3:r=u,l=d,i=a
break
case 4:r=m,l=u,i=a
break
case 5:r=a,l=u,i=d}return{alpha:t,red:Math.round(255*r),green:Math.round(255*l),blue:Math.round(255*i)}}(e)
this.setState({css:nn(t),rgb:t,hsv:e}),this.commit()},this.handleRgbColor=e=>{this.setState({css:nn(e),rgb:e,hsv:sn(e)}),this.commit()},this.handleTimeout=()=>{this.timeout=null,this.props.onChange(this.state.rgb)},this.state={css:nn(e.color),hsv:sn(e.color),rgb:Object.assign({},e.color)}}render(){const{children:e}=this.props
return s.createElement(an.Provider,{value:Object.assign(Object.assign({},this.state),{onHsvColor:this.handleHsvColor,onRgbColor:this.handleRgbColor})},e)}}function on(e){var{className:t}=e,n=(0,P._T)(e,["className"])
return s.createElement("input",Object.assign({className:Ce()("tcfInput",t)},n))}class cn extends s.Component{constructor(){super(...arguments),this.state={hasFocus:!1},this.handleBlur=()=>{this.setState({hasFocus:!1})},this.handleChange=e=>{const{value:t}=e.target,{onRgbColor:n}=this.props
n(this.getColor(t))},this.handleFocus=()=>{this.setState({hasFocus:!0})}}getValue(){const{rgb:e,type:t}=this.props
switch(t){case"alpha":case"blue":case"green":case"red":return`${e[t]}`
case"hex":return"#"+(16777216+((n=e).blue|n.green<<8|n.red<<16)).toString(16).slice(1)}var n}getColor(e){const{rgb:t,type:n}=this.props
switch(n){case"blue":case"green":case"red":const s=parseInt(e)
return Object.assign(Object.assign({},t),{[n]:isFinite(s)?Math.max(0,Math.min(255,s)):t[n]})
case"alpha":const a=parseFloat(e)
return Object.assign(Object.assign({},t),{alpha:isFinite(a)?Math.max(0,Math.min(1,a)):t.alpha})
case"hex":const r=tn(e)
return r?Object.assign(Object.assign({},r),{alpha:t.alpha}):t}}render(){const{hasFocus:e}=this.state,t={className:"tcfColorInputInput",onBlur:this.handleBlur,onChange:this.handleChange,onFocus:this.handleFocus}
return e?t.defaultValue=this.getValue():t.value=this.getValue(),s.createElement(on,t)}}var un=rn(cn)
class dn extends s.Component{constructor(){super(...arguments),this.element=null,this.state={initialHue:0,isMouseDown:!1,mouseX:0,mouseY:0},this.handleMouseDown=e=>{const{hsv:t}=this.props
window.addEventListener("mousemove",this.handleMouseMove),window.addEventListener("mouseup",this.handleMouseUp),this.setState(Object.assign(Object.assign({},this.update(e.clientX,e.clientY,t.hue)),{initialHue:t.hue,isMouseDown:!0}))},this.handleMouseMove=e=>{this.setState(this.update(e.clientX,e.clientY))},this.handleMouseUp=e=>{this.stopListening(),this.setState(Object.assign(Object.assign({},this.update(e.clientX,e.clientY)),{isMouseDown:!1}))},this.setElement=e=>{this.element=e}}componentWillUnmount(){this.stopListening()}render(){const{hsv:e}=this.props,{initialHue:t,isMouseDown:n,mouseX:a,mouseY:r}=this.state
return s.createElement("div",{className:"tcfColorInputSaturation",onMouseDown:this.handleMouseDown,ref:this.setElement,style:{background:`hsl(${360*(n?t:e.hue)}, 100%, 50%)`}},s.createElement("div",{className:"tcfColorInputSaturation--value",style:{left:100*(n?a:e.saturation)+"%",top:100*(n?r:1-e.value)+"%"}}))}stopListening(){window.removeEventListener("mousemove",this.handleMouseMove),window.removeEventListener("mouseup",this.handleMouseUp)}update(e,t){let n=arguments.length>2&&void 0!==arguments[2]?arguments[2]:this.state.initialHue
const{element:s}=this
if(!s)return{mouseX:this.state.mouseX,mouseY:this.state.mouseY}
const{hsv:a,onHsvColor:r}=this.props,l=s.getBoundingClientRect(),i=Math.max(0,Math.min(1,(e-l.left)/l.width)),o=Math.max(0,Math.min(1,(t-l.top)/l.height))
return r({alpha:a.alpha,hue:n,saturation:i,value:1-o}),{mouseX:i,mouseY:o}}}var mn=rn(dn)
class hn extends s.Component{constructor(){super(...arguments),this.element=null,this.handleMouseDown=e=>{window.addEventListener("mousemove",this.handleMouseMove),window.addEventListener("mouseup",this.handleMouseUp),this.update(e.clientX)},this.handleMouseMove=e=>{this.update(e.clientX)},this.handleMouseUp=e=>{this.stopListening(),this.update(e.clientX)},this.setElement=e=>{this.element=e}}componentWillUnmount(){this.stopListening()}render(){const{rgb:e,hsv:t,type:n}=this.props,a=t[n]
let r
if("alpha"===n){const{red:t,green:n,blue:a}=e,l=`rgba(${t}, ${n}, ${a}, 0)`,i=`rgba(${t}, ${n}, ${a}, 1)`
r=s.createElement("div",{className:"tcfColorInputSlider--gradient",style:{background:`linear-gradient(to right, ${l}, ${i})`}})}return s.createElement("div",{className:`tcfColorInputSlider ${n}`,onMouseDown:this.handleMouseDown},r,s.createElement("div",{className:"tcfColorInputSlider--track",ref:this.setElement},s.createElement("div",{className:"tcfColorInputSlider--handle",style:{left:100*a+"%"}})))}stopListening(){window.removeEventListener("mousemove",this.handleMouseMove),window.removeEventListener("mouseup",this.handleMouseUp)}update(e){const{element:t}=this
if(!t)return
const{hsv:n,onHsvColor:s,type:a}=this.props,r=t.getBoundingClientRect(),l=Math.max(0,Math.min(1,(e-r.left)/r.width))
s(Object.assign(Object.assign({},n),{[a]:l}))}}var pn=rn(hn)
var fn=rn((function(e){let{children:t,className:n,color:a,css:r,disabled:l,onClick:i,onRgbColor:o}=e
if(a){const e=tn(a)
e&&(i=function(){o(e)})}return s.createElement("div",{className:Ce()("tcfColorInputSwatch",n),onClick:l?void 0:i},s.createElement("div",{className:"tcfColorInputSwatch--color",style:{background:a||r}}),t)}))
function gn(e){let{disableAlpha:t,presetColors:n}=e
const a=[s.createElement("div",{className:"tcfColorInputPicker--value wide",key:"hex"},s.createElement(un,{type:"hex"}),s.createElement("div",{className:"tcfColorInputPicker--valueCaption"},"Hex")),s.createElement("div",{className:"tcfColorInputPicker--value",key:"red"},s.createElement(un,{type:"red"}),s.createElement("div",{className:"tcfColorInputPicker--valueCaption"},"R")),s.createElement("div",{className:"tcfColorInputPicker--value",key:"green"},s.createElement(un,{type:"green"}),s.createElement("div",{className:"tcfColorInputPicker--valueCaption"},"G")),s.createElement("div",{className:"tcfColorInputPicker--value",key:"blue"},s.createElement(un,{type:"blue"}),s.createElement("div",{className:"tcfColorInputPicker--valueCaption"},"B"))]
t||a.push(s.createElement("div",{className:"tcfColorInputPicker--value",key:"alpha"},s.createElement(un,{type:"alpha"}),s.createElement("div",{className:"tcfColorInputPicker--valueCaption"},"A")))
let r=null
return n&&n.length&&(r=s.createElement("div",{className:"tcfColorInputPicker--presets"},n.map((e=>s.createElement(fn,{className:"tcfColorInputPicker--presetsSwatch",color:e}))))),s.createElement("div",{className:"tcfColorInputPicker"},s.createElement(mn,null),s.createElement("div",{className:"tcfColorInputPicker--controls"},s.createElement("div",{className:"tcfColorInputPicker--sliders"},s.createElement(pn,{type:"hue"}),t?null:s.createElement(pn,{type:"alpha"})),s.createElement(fn,{className:"tcfColorInputPicker--swatch"})),s.createElement("div",{className:"tcfColorInputPicker--values"},a),r)}class yn extends s.Component{constructor(){super(...arguments),this.state={hasColorPicker:!1},this.handleChange=e=>{this.props.onChange(e)},this.handleSwatchClick=()=>{this.setState({hasColorPicker:!0})},this.handleOverlayClick=()=>{this.setState({hasColorPicker:!1})}}render(){const{hasColorPicker:e}=this.state,{color:t,disableAlpha:n,disabled:a,onChange:r,presetColors:l}=this.props
return s.createElement(ln,{color:t,onChange:r},s.createElement("div",{className:"tcfColorInput"},s.createElement(fn,{className:"tcfColorInput--swatch",disabled:a,onClick:this.handleSwatchClick},e&&!a?s.createElement(Rt,{onClick:this.handleOverlayClick},s.createElement(gn,{disableAlpha:n,presetColors:l})):null),s.createElement(un,{type:"hex"})))}}function vn(e){let{data:t,disabled:n,field:a,onUpdate:r}=e
const l=en(t)?t:{alpha:1,blue:255,green:255,red:255}
return s.createElement(yn,{color:l,disableAlpha:!a.alpha,disabled:n,onChange:r,presetColors:a.swatches})}function bn(e){let{children:t,className:n,icon:a}=e
return s.createElement("div",{className:Ce()("tcfTextAndIcon",n)},s.createElement(Ye,{className:"tcfTextAndIcon--icon",name:a}),s.createElement(ke,{className:"tcfTextAndIcon--text",value:t}))}function En(e){let{children:t,title:n}=e
return s.createElement("div",{className:"tcfErrorMessage"},s.createElement(bn,{icon:"material:error"},n),t)}function wn(e){return"object"==typeof e&&"string"==typeof e.url}class Cn extends s.Component{constructor(){super(...arguments),this.request=null,this.state={mode:"idle"},this.handleChange=e=>{this.updateOEmbed(),this.setState({mode:"typing"}),this.props.onUpdate(Object.assign(Object.assign({},this.getOEmbed()),{url:e.target.value}))},this.updateOEmbed=function(e,t,n){let s,a,r=null,l=null,i=null
function o(){const c=Date.now()-s
c<t&&c>=0?r=window.setTimeout(o,t-c):(r=null,n||(a=e.apply(i,l),r||(i=l=null)))}return function(){i=this,l=arguments,s=Date.now()
const c=n&&!r
return r||(r=window.setTimeout(o,t)),c&&(a=e.apply(i,l),i=l=null),a}}((()=>{this.setState({mode:"loading"})
const{apiEndpoint:e,model:t,field:n}=this.props,s=-1===e.indexOf("?")?"?":"&",a=[`schema=${encodeURIComponent(t.__type)}`,`field=${encodeURIComponent(n.name)}`,`url=${encodeURIComponent(this.getOEmbed().url)}`],r=new XMLHttpRequest
r.onreadystatechange=()=>this.handleRequestStateChange(r),r.onerror=()=>this.handleRequestError(),r.open("GET",`${e}${s}${a.join("&")}`),r.send(),this.request&&this.request.abort(),this.request=r}),500)}getOEmbed(){const{data:e}=this.props
return wn(e)?e:{url:""}}handleRequestStateChange(e){if(e.readyState!==XMLHttpRequest.DONE)return
if(200!==e.status)return this.handleRequestError()
let t
try{t=JSON.parse(e.responseText)}catch(e){return this.handleRequestError()}this.setState({mode:"idle"}),this.request=null,this.props.onUpdate(Object.assign(Object.assign({},this.getOEmbed()),{info:t.data}))}handleRequestError(){this.setState({mode:"idle"}),this.request=null,this.props.onUpdate(Object.assign(Object.assign({},this.getOEmbed()),{info:null}))}render(){const e=this.getOEmbed(),{disabled:t}=this.props,{mode:n}=this.state
let a
if("typing"===n||"loading"===n)a=s.createElement("div",{className:"tcfOEmbedWidget--activity"},s.createElement("div",{className:"tcfOEmbedWidget--activityBounce first"}),s.createElement("div",{className:"tcfOEmbedWidget--activityBounce second"}),s.createElement("div",{className:"tcfOEmbedWidget--activityBounce third"}))
else if(e.info){const{title:t,author_name:n,thumbnail_url:r}=e.info
a=s.createElement("div",{className:"tcfOEmbedWidget--info"},r?s.createElement("img",{className:"tcfOEmbedWidget--infoImage",src:r}):null,s.createElement("div",{className:"tcfOEmbedWidget--infoContent"},s.createElement("div",{className:"tcfOEmbedWidget--infoTitle"},t),s.createElement("div",{className:"tcfOEmbedWidget--infoAuthor"},n)))}else a=s.createElement(En,{title:"Invalid embed url"})
return s.createElement("div",{className:"tcfOEmbedWidget"},s.createElement("div",{className:"tcfOEmbedWidget--input"},s.createElement("input",{autoComplete:"off",className:"text fullwidth",disabled:t,onChange:t?void 0:this.handleChange,value:e.url})),a)}}var Sn=(0,i.$j)((e=>({apiEndpoint:e.config.apiEndpoints.oembed})))(Cn)
class _n{constructor(e){this.value=e}get author(){return this.value.info?this.value.info.author_name:""}get thumbnail(){const{info:e}=this.value
return e&&e.thumbnail_url?new ce.SafeString(`<img width="100" src=${e.thumbnail_url} />`):""}get title(){return this.value.info?this.value.info.title:""}toHTML(){const{info:e}=this.value
if(!e)return new ce.SafeString("")
let t=""
return e.thumbnail_url&&(t=`<img class="tcfOEmbedWidget--infoImage" src="${e.thumbnail_url}" />`),new ce.SafeString(`\n      <div class="tcfOEmbedWidget--info">\n        ${t}\n        <div class="tcfOEmbedWidget--infoContent">\n          <div class="tcfOEmbedWidget--infoTitle">${e.title}</div>\n          <div class="tcfOEmbedWidget--infoAuthor">${e.author_name}</div>\n        </div>\n      </div>\n    `)}}(0,P.gn)([vt],_n.prototype,"value",void 0),(0,P.gn)([vt],_n.prototype,"author",null),(0,P.gn)([vt],_n.prototype,"thumbnail",null),(0,P.gn)([vt],_n.prototype,"title",null),(0,P.gn)([yt],_n.prototype,"toHTML",null)
function On(e){let{favorites:t,onSchema:n,onToggleFavorite:a,schemas:r}=e
const l=r.map((e=>{const r=-1!==t.indexOf(e.qualifier)
return s.createElement("div",{className:"tcfSchemaList--row",key:e.qualifier},s.createElement("div",{className:"tcfSchemaList--schema",onMouseUp:()=>n(e)},s.createElement(Ye,{className:"tcfSchemaList--schemaIcon",name:e.icon}),s.createElement("div",{className:"tcfSchemaList--schemaLabel"},e.label)),a?s.createElement("div",{className:"tcfSchemaList-favorite",onClick:()=>a(e)},s.createElement(Ye,{name:r?"material:star":"material:star_border"})):null)}))
return s.createElement("div",{className:"tcfSchemaList"},l)}function xn(e){let{onCreate:t,schemas:n,scope:a}=e
const[r,l]=s.useState(!1),o=(0,i.I0)()
let c,u=[],d=null
if(a){const{favoriteSchemas:e}=(0,i.v9)((e=>e.user))
u=a in e?e[a]:[],u.length&&(d=n.filter((e=>-1!==u.indexOf(e.qualifier))).map((e=>s.createElement(Se,{className:"tcfFactory--quickButton",key:e.qualifier,onClick:()=>t(e),secondary:!0},s.createElement(Ye,{name:e.icon}),s.createElement("div",null,e.label))))),c=e=>{o(function(e,t){return(n,s)=>{const{favoriteSchemas:a}=s().user
let r=e in a?a[e]:[]
r=-1===r.indexOf(t)?[...r,t]:r.filter((e=>e!==t)),n({type:"setUser",user:{favoriteSchemas:Object.assign(Object.assign({},a),{[e]:r})}})}}(a,e.qualifier))}}return s.createElement("div",{className:"tcfFactory multiple"},s.createElement(Se,{className:"tcfFactory--primaryButton",onMouseDown:()=>l(!0)},s.createElement(Ye,{name:"plus"}),s.createElement(ke,{value:"Create"}),r?s.createElement(Rt,{onClick:()=>l(!1)},s.createElement(On,{favorites:u,onSchema:e=>{l(!1),t(e)},onToggleFavorite:c,schemas:n})):null),d)}function kn(e){let{onCreate:t,schema:n}=e
return s.createElement("div",{className:"tcfFactory"},s.createElement(Se,{className:"tcfFactory--primaryButton",onClick:()=>t(n)},s.createElement(Ye,{name:"plus"}),s.createElement(ke,{params:{schema:n.label},value:"Create {schema}"})))}function Nn(e){let{field:t,onCreate:n,scope:a}=e
const r=(0,i.v9)((e=>e.schemas)),l=t.schemas.map((e=>r[e])).sort(((e,t)=>e.label.localeCompare(t.label)))
if(!l.length)return null
const o=e=>{if(-1!==l.indexOf(e))return n(E({schemas:r,schema:e}))}
return l.length>1?s.createElement(xn,{onCreate:o,schemas:l,scope:a}):s.createElement(kn,{onCreate:o,schema:l[0]})}function jn(e){let{children:t,disabled:n,field:a,model:r}=e
const l=s.useContext(lt),o=(0,i.v9)((e=>e.schemas)),{isExpanded:c,toggleExpanded:u}=s.useContext(_e),d=o[r.__type],m=c(r.__uuid),h=d&&d.preview,p=()=>u(r.__uuid)
let f=null
return m?f=s.createElement("div",{className:"tcfArrayWidgetMember--body"},t):h&&(f=s.createElement(Ht,{field:a,model:r,onClick:p})),s.createElement("div",{className:`tcfInstanceWidget--collapsiblePanel depth-${l}`},s.createElement(Wt,{disabled:n,field:a,hasPreview:!m&&!h,isCollapsible:!0,isExpanded:m,model:r,onToggleExpanded:p,schema:d}),s.createElement(Nt,{uri:m?"details":"summary"},f))}function Mn(e){let{className:t,data:n,disabled:a,field:r,path:l}=e
const i=s.createElement(ut,{canChangeVisibility:!0,disabled:a,model:n,path:[...l,{type:"property",name:r.name}],schemaNames:r.schemas})
return r.collapsible&&c(n)?s.createElement(jn,{model:n,disabled:a,field:r},i):s.createElement("div",{className:Ce()("tcfInstanceWidget",t)},i)}function In(e){var{attribute:t,column:n,max:a,min:r,onUpdate:l}=e,i=(0,P._T)(e,["attribute","column","max","min","onUpdate"])
const[o,c]=s.useState(null),u=n[t],d=X(u,i),m=i.current.key in u
return s.createElement("div",{className:"tcfLayoutEditor--columnInput"},s.createElement("div",{className:Ce()("tcfLayoutEditor--columnInputLabel",{hasOwnValue:m})},(h=t).charAt(0).toUpperCase()+h.slice(1)),s.createElement(on,{className:"tcfLayoutEditor--columnInputField",max:a,min:r,onBlur:()=>c(null),onChange:function(e){let{target:s}=e
c(s.value)
const o=parseInt(s.value)
!isFinite(o)||"number"==typeof r&&o<r||"number"==typeof a&&o>a||l(n.__uuid,{[t]:J(u,o,i)})},type:"number",value:null===o?d:o}))
var h}function Ln(e){let t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:0,n=arguments.length>2&&void 0!==arguments[2]?arguments[2]:1
return e<t?t:e>n?n:e}function Tn(e){let{columnsPerRow:t}=e
const n=[]
for(let e=0;e<t;e++)n.push(s.createElement("div",{className:"tcfLayoutPreview--gridColumn",key:e}))
return s.createElement("div",{className:"tcfLayoutPreview--grid"},n)}function $n(e){const t=String.fromCharCode(65+e%25),n=Math.floor(e/25)
return g("Column {num}",{num:`${t}${n>1?n:""}`})}function An(e){var{columns:t,columnsPerRow:n,isSelected:a,onClick:r}=e,l=(0,P._T)(e,["columns","columnsPerRow","isSelected","onClick"])
return s.createElement("div",{className:Ce()("tcfLayoutPreview",{isClickable:!!r,isSelected:a}),onClick:r},s.createElement(Tn,{columnsPerRow:n}),t.map(((e,t)=>{const a=X(e.offset,l),r=X(e.order,l),i=X(e.width,l)
return s.createElement("div",{className:"tcfLayoutPreview--col",key:t,style:{marginLeft:`${(a/n*100).toFixed(6)}%`,order:r,width:`${(i/n*100).toFixed(6)}%`}},s.createElement("div",{className:"tcfLayoutPreview--colPanel"},$n(t)))})))}class Pn extends s.Component{constructor(){super(...arguments),this.element=null,this.initialHandle=!1,this.initialPosition=0,this.isListening=!1,this.state={dragDelta:0,dragMode:"none"},this.handleMouseDown=e=>{this.initialHandle=!1,this.initialPosition=e.clientX,this.startListening()
let t=e.target
for(;t;){if(t.classList.contains("tcfLayoutRowEditor--colHandle")){this.initialHandle=!0
break}t=t.parentElement}},this.handleMouseMove=e=>{const{dragMode:t}=this.state,n=e.clientX-this.initialPosition
"none"===t&&Math.abs(n)>3&&(this.initialPosition=e.clientX,this.setState({dragDelta:0,dragMode:this.initialHandle?"size":"move"})),"none"!==t&&this.setState({dragDelta:n,dragMode:t})},this.handleMouseUp=()=>{const{column:e,onSelect:t}=this.props,{dragDelta:n,dragMode:s}=this.state,a=this.toColumns(n)
"size"===s?this.applySize(a):"move"===s?this.applyMove(a):t(e.__uuid),this.stopListening(),this.setState({dragDelta:0,dragMode:"none"})},this.setElement=e=>{this.element=e}}applyMove(e){const{props:t}=this,{column:n,columnsPerRow:s,onUpdate:a}=t,r=Ln(this.sample(n.offset)+e,0,s)
a(n.__uuid,{offset:J(n.offset,r,t)})}applySize(e){const{props:t}=this,{column:n,constraints:{maxColumnWidth:s,minColumnWidth:a},onUpdate:r}=t,l=Ln(this.sample(n.width)+e,a,s)
r(n.__uuid,{width:J(n.width,l,t)})}componentWillUnmount(){this.stopListening()}render(){const{dragDelta:e,dragMode:t}=this.state,{column:n,columnsPerRow:a,index:r,isSelected:l}=this.props,i=this.sample(n.offset),o=this.sample(n.width),c=this.sample(n.order)
let u=`${(o/a*100).toFixed(6)}%`,d=`${(i/a*100).toFixed(6)}%`
return"move"===t?d=`calc(${d} + ${e}px)`:"size"===t&&(u=`calc(${u} + ${e}px)`),s.createElement("div",{className:Ce()("tcfLayoutRowEditor--col",{isSelected:l}),onMouseDown:this.handleMouseDown,ref:this.setElement,style:{marginLeft:d,order:c,width:u}},s.createElement("div",{className:"tcfLayoutRowEditor--colPanel"},s.createElement("div",{className:"tcfLayoutRowEditor--colLabel"},$n(r)),s.createElement("div",{className:"tcfLayoutRowEditor--colHandle"})))}sample(e){return X(e,this.props)}startListening(){this.isListening||(this.isListening=!0,document.addEventListener("mousemove",this.handleMouseMove),document.addEventListener("mouseup",this.handleMouseUp))}stopListening(){this.isListening=!1,document.removeEventListener("mousemove",this.handleMouseMove),document.removeEventListener("mouseup",this.handleMouseUp)}toColumns(e){const{element:t}=this,{columnsPerRow:n}=this.props,s=t?t.parentElement:null
if(!s)return 0
const a=s.offsetWidth/n
return Math.round(e/a)}}function Rn(e){var{columns:t,selected:n}=e,a=(0,P._T)(e,["columns","selected"])
const{columnsPerRow:r}=a
return s.createElement("div",{className:"tcfLayoutRowEditor"},s.createElement(Tn,{columnsPerRow:r}),t.map(((e,t)=>s.createElement(Pn,Object.assign({},a,{column:e,index:t,isSelected:null!==n&&n.__uuid===e.__uuid,key:e.__uuid})))))}const Un={xs:"material:smartphone",sm:"material:tablet_mac",md:"material:tablet",lg:"material:laptop",xl:"material:desktop_mac"}
function Fn(e){const{columnsPerRow:t,constraints:n,current:a,selected:r}=e
let l
if(r){const a={breakpoints:e.breakpoints,column:r,current:e.current,onUpdate:e.onUpdate}
l=s.createElement("div",{className:"tcfLayoutEditor--rowAttributes"},s.createElement(In,Object.assign({},a,{attribute:"width",max:Math.min(t,n.maxColumnWidth),min:Math.max(1,n.minColumnWidth)})),s.createElement(In,Object.assign({},a,{attribute:"offset",min:0,max:t})),s.createElement(In,Object.assign({},a,{attribute:"order"})))}else l=s.createElement("div",{className:"tcfLayoutEditor--rowAttributes"})
return s.createElement("div",{className:"tcfLayoutEditor--row"},s.createElement("div",{className:"tcfLayoutEditor--rowHead"},a.key in Un?s.createElement(Ye,{name:Un[a.key]}):null,s.createElement("span",null,a.label)),s.createElement("div",{className:"tcfLayoutEditor--rowBody"},s.createElement(Rn,Object.assign({},e)),l))}function Dn(e){var{onClose:t,onCreate:n,onDelete:a}=e,r=(0,P._T)(e,["onClose","onCreate","onDelete"])
const{breakpoints:l,columns:i,constraints:{maxColumns:o,minColumns:c}}=r,[u,d]=s.useState(i.length?i[0].__uuid:null),m=u&&i.find((e=>e.__uuid===u))||null
function h(e){d(e===u?null:e)}return s.createElement(Ie,null,s.createElement(Ie.Content,null,s.createElement("div",{className:"tcfLayoutEditor--title"},s.createElement(ke,{value:"Edit columns"})),l.map((e=>s.createElement(Fn,Object.assign({},r,{current:e,key:e.key,selected:m,onSelect:h}))))),s.createElement(Ie.Footer,null,s.createElement("div",{className:"btngroup"},i.length<o?s.createElement(xe,{onClick:()=>d(n())},s.createElement(Ye,{name:"plus"}),s.createElement(ke,{value:"Create"})):null,m&&i.length>c?s.createElement(xe,{onClick:()=>a(m.__uuid)},s.createElement(Ye,{name:"minus"}),s.createElement(ke,{value:"Delete"})):null),s.createElement(xe,{onClick:t,primary:!0},s.createElement(ke,{value:"Close"}))))}function Wn(e){var{onClose:t,onPreset:n,preset:a,presets:r}=e,l=(0,P._T)(e,["onClose","onPreset","preset","presets"])
return s.createElement(Rt,{onClick:t},s.createElement("div",{className:"tcfLayoutSelect--flyout"},r.map((e=>s.createElement(An,Object.assign({},l,{columns:e.columns,isSelected:e.key===a,key:e.key,onClick:()=>n(e)}))))))}function Vn(e){var{canEdit:t,onPreset:n,preset:a,presets:r}=e,l=(0,P._T)(e,["canEdit","onPreset","preset","presets"])
const{breakpoints:i,columns:o,columnsPerRow:c}=l,[u,d]=s.useState(null),m=i[i.length-1]
function h(){d(null)}let p=null
return r.length?p="flyout":t&&(p="editor"),s.createElement("div",{className:"tcfLayoutSelect"},s.createElement("div",{className:"tcfLayoutSelect--widget"},s.createElement(An,{breakpoints:i,columns:o,columnsPerRow:c,current:m,onClick:p?()=>d(p):void 0}),"flyout"===u?s.createElement(Wn,{breakpoints:l.breakpoints,columnsPerRow:l.columnsPerRow,current:m,onClose:h,onPreset:function(e){n(e),d(null)},preset:a,presets:r}):null),t?s.createElement("div",{className:"tcfLayoutSelect--edit",onClick:()=>d("editor")},s.createElement(Ye,{name:"material:edit"})):null,"editor"===u?s.createElement(dt,{onClick:h},s.createElement(Dn,Object.assign({},l,{onClose:h}))):null)}class Hn extends s.Component{constructor(){super(...arguments),this.handleCreate=()=>{const{data:e,disabled:t,field:n,onUpdate:s}=this.props
if(!Y(e)||t||e.columns.length>=n.constraints.maxColumns)return null
const a=this.createColumn()
return s(Object.assign(Object.assign({},e),{columns:[...e.columns,a]})),a.__uuid},this.handleDelete=e=>{const{data:t,disabled:n,field:s,onUpdate:a}=this.props
!Y(t)||n||t.columns.length<=s.constraints.minColumns||a(Object.assign(Object.assign({},t),{columns:t.columns.filter((t=>t.__uuid!==e))}))},this.handlePreset=e=>{const{data:t,disabled:n,field:s,onUpdate:a,schemas:r}=this.props
if(n||!Y(t))return
const l=t.columns.map((e=>e.value))
a(Object.assign(Object.assign({},t),{preset:e.key,columns:e.columns.map(((e,t)=>q(s,r,e,l.length>t?l[t]:void 0)))}))},this.handleUpdate=(e,t)=>{const{data:n,disabled:s,onUpdate:a}=this.props
if(s||!Y(n))return
const r=Object.keys(t).every((e=>"value"===e))
a(Object.assign(Object.assign({},n),{preset:r?n.preset:null,columns:n.columns.map((n=>n.__uuid===e?Object.assign(Object.assign({},n),t):n))}))}}createColumn(){const{field:e,schemas:t}=this.props
return q(e,t)}createColumnValue(){const{field:e,schemas:t}=this.props
return G(e,t)}render(){const{data:e,disabled:t,field:n,model:a,path:r,schemas:l}=this.props,i=K(n,l),o=this.context+1,{preset:c,columns:u}=Y(e)?e:{columns:[],preset:null}
return s.createElement("div",{className:"tcfLayoutWidget"},s.createElement(Vn,{breakpoints:n.breakpoints,canEdit:n.canEdit,constraints:n.constraints,columns:u,columnsPerRow:n.columnsPerRow,onCreate:this.handleCreate,onDelete:this.handleDelete,onPreset:this.handlePreset,onUpdate:this.handleUpdate,preset:c,presets:n.presets}),s.createElement("div",{className:Ce()("tcfLayoutWidget--columns",{isStacked:u.length<=o})},u.map(((e,l)=>s.createElement(Ae,{key:e.__uuid,label:$n(l)},s.createElement(We,{data:e.value,disabled:t,errors:null,field:i,model:a,onUpdate:t=>this.handleUpdate(e.__uuid,{value:t}),path:[...r,{name:n.name,type:"property"},{index:l,name:"columns",type:"index"}]}))))))}}Hn.contextType=He
var Bn=(0,i.$j)(((e,t)=>({schemas:e.schemas})))(Hn)
function zn(e){let{data:t,disabled:n,onUpdate:a}=e
return s.createElement(et,{disabled:n,onChange:a,value:!!t})}function qn(e){const t=s.useRef(null)
return s.useEffect((()=>{const{current:n}=t
if(!n)return
const s=It()
for(const t of function(e){const{data:t,elementType:n,references:s}=e,a=[]
if(Array.isArray(t))for(const e of t){const t=s.find((t=>t.id===e&&t.type===n))
t&&a.push(t)}return a}(e)){const a=t.$element.clone(!1,!0)
a.appendTo(n),Craft.setElementSize(a,e.viewMode),s.load(a)}}),[]),s.createElement("div",{className:"elementselect"},s.createElement("div",{className:"elements",ref:t}))}class Gn extends s.Component{constructor(){super(...arguments),this.element=null,this.renderedIds=[],this.uuid=`element-${b()}`,this.instance=null,this.isRendering=!1,this.handleAdd=e=>{let{elements:t}=e
const{elementType:n,onAddReferences:s}=this.props
this.handleChange(),s(t.map((e=>Object.assign(Object.assign({},e),{$element:$(e.$element[0].outerHTML),element:e.$element[0].outerHTML,type:n}))))},this.handleChange=()=>{if(this.isRendering)return
const{onUpdate:e}=this.props,t=this.getSelectedIds()
this.renderedIds=t,e(t)},this.setElement=e=>{if(this.element===e)return
this.element=e
let{instance:t}=this
if(t&&(t.off("selectElements",this.handleAdd),t.off("removeElements",this.handleChange),t.elementSort&&t.elementSort.off("sortChange",this.handleChange),t.destroy(),this.instance=t=null),e){const{allowSelfReference:e,criteria:n,elementType:s,limit:a=null,modalStorageKey:r=null,sourceElementId:l,sources:i,viewMode:o="small"}=this.props
t=new Craft.BaseElementSelectInput({criteria:n,elementType:s,id:this.uuid,limit:a,modalStorageKey:r,name:this.uuid,sources:i,sourceElementId:e?null:l,viewMode:o}),this.instance=t,this.createReferences(),t.on("selectElements",this.handleAdd),t.on("removeElements",this.handleChange),t.elementSort&&t.elementSort.on("sortChange",this.handleChange)}}}componentDidUpdate(){const{renderedIds:e}=this,t=this.props.data||[]
t.length===e.length&&t.every(((t,n)=>t===e[n]))||this.createReferences()}createReferences(){const{instance:e}=this
if(!e)return
this.isRendering=!0
const t=[]
e.$elementsContainer.empty()
for(const n of this.getStoredReferences()){const s=e.createNewElement(n)
s.find("input").prop("disabled",!0),e.appendElement(s),t.push(n.id)}e.resetElements(),this.renderedIds=t,this.isRendering=!1}getStoredReferences(){const{data:e,elementType:t,references:n}=this.props,s=[]
if(!Array.isArray(e))return s
for(const a of e){const e=n.find((e=>e.id===a&&e.type===t))
e&&s.push(e)}return s}getSelectedIds(){const{instance:e}=this
if(!e)return[]
const t=[],n=e.getSelectedElementIds(),s=e.getElements()
for(let e=0;e<s.length;e++){const a=parseInt(s.eq(e).data("id"));-1!==n.indexOf(a)&&t.push(a)}return t}render(){return s.createElement("div",{id:this.uuid,className:"elementselect",ref:this.setElement},s.createElement("div",{className:"elements"}),s.createElement("div",{className:"btn add icon dashed"},"Choose"))}}var Xn=(0,i.$j)((e=>({references:e.config.references,sourceElementId:e.config.elementId})),(e=>({onAddReferences:t=>{e(y(t))}})))((function(e){return e.disabled?s.createElement(qn,Object.assign({},e)):s.createElement(Gn,Object.assign({},e))}))
let Kn=0
function Jn(e){var{className:t,suggestions:n}=e,a=(0,P._T)(e,["className","suggestions"])
const[r]=s.useState("tcfAutoCompleteList_"+Kn++)
return s.createElement(s.Fragment,null,s.createElement("input",Object.assign({className:Ce()("tcfInput",t),list:r},a)),s.createElement("datalist",{id:r},n.map(((e,t)=>s.createElement("option",{key:t},e)))))}function Yn(e){var{apiEndpoint:t}=e,n=(0,P._T)(e,["apiEndpoint"])
const s=Object.keys(n).filter((e=>!!n[e])).map((e=>`${e}=${encodeURIComponent(n[e])}`)).join("&")
return new Promise(((e,n)=>{fetch(`${t}&${s}`).then((e=>e.json())).then((t=>{!function(e){return"object"==typeof e&&!0===e.result&&Array.isArray(e.anchors)}(t)?n(t&&t.message?`${t.message}`:"An unknown error has occured."):e(t)})).catch((e=>{n(`${e}`)}))}))}const Qn={anchors:[],options:[],suggestions:[]}
var Zn=(0,i.$j)((e=>({apiEndpoint:e.config.apiEndpoints.anchors,siteId:e.config.elementSiteId})))((function(e){let{apiEndpoint:t,disabled:n,elementId:a,mode:r,onChange:l,siteId:i,value:o}=e
const{options:c,suggestions:u}=function(e){const[t,n]=(0,s.useState)(Qn)
return(0,s.useEffect)((()=>{n(Qn),e.elementId&&Yn(e).then((e=>{let{anchors:t}=e
n({anchors:t,options:t.map((e=>({key:e.id?e.id:e.anchor,label:e.title||e.anchor}))),suggestions:t.map((e=>e.anchor))})}))}),[e.siteId,e.elementId]),t}({apiEndpoint:t,elementId:a,siteId:i})
return"select"===r?s.createElement(Re,{allowUndecided:!0,className:"tcfLinkWidget--hashEditorSelectWrap",disabled:n,onChange:e=>l(null===e?"":e),options:c,selectClassName:"tcfLinkWidget--hashEditorSelect",value:o}):s.createElement(Jn,{disabled:n,onChange:e=>l(e.currentTarget.value),suggestions:u,value:o})}))
function es(e){let{disabled:t,link:n,linkType:a,modalStorageKey:r=null,onUpdate:l}=e
return a.allowHash,s.createElement("div",{className:"tcfLinkWidget--editor"},s.createElement(Xn,{allowSelfReference:a.allowSelf,criteria:a.criteria,data:[n.elementId],disabled:t,elementType:a.elementType,limit:1,modalStorageKey:r,onUpdate:e=>l(Object.assign(Object.assign({},n),{elementId:e.length?e[0]:0})),sources:a.sources,viewMode:"small"}),a.allowHash?s.createElement("div",{className:"tcfLinkWidget--editorHash tcfInput--group"},s.createElement("div",{className:"tcfInput--groupLabel"},"#"),s.createElement(Zn,{disabled:t,elementId:n.elementId,mode:a.allowHash,onChange:e=>l(Object.assign(Object.assign({},n),{hash:e})),value:n.hash})):null)}function ts(e){let{disabled:t,link:n,linkType:a,onUpdate:r}=e
return s.createElement("div",{className:"tcfLinkWidget--editor"},s.createElement(on,{disabled:t,type:a.inputType,value:n.url,onChange:e=>r(Object.assign(Object.assign({},n),{url:e.currentTarget.value}))}))}function ns(e){return"object"==typeof e&&"number"==typeof e.elementId&&"string"==typeof e.hash&&"string"==typeof e.type&&"string"==typeof e.url}function ss(e){let t,{data:n,disabled:a,field:r,model:l,onUpdate:i}=e
t=ns(n)?n:{elementId:0,hash:"",openInNewWindow:!1,type:"",url:""}
const o=r.linkTypes[t.type]
let c
o&&"input"===o.type?c=s.createElement(ts,{disabled:a,key:t.type,link:t,linkType:o,onUpdate:i}):o&&"element"===o.type&&(c=s.createElement(es,{disabled:a,key:t.type,link:t,linkType:o,modalStorageKey:`tcf_${l.__type}_${r.name}_${o.type}`,onUpdate:i}))
const{allowNewWindow:u}=r
return s.createElement("div",{className:"tcfLinkWidget"},s.createElement("div",{className:"tcfLinkWidget--type"},s.createElement(Re,{disabled:a,options:Object.keys(r.linkTypes).map((e=>({key:e,label:r.linkTypes[e].label}))),value:t.type,onChange:e=>i(Object.assign(Object.assign({},t),{type:e}))})),c,u?s.createElement(Yt,{disabled:a,onChange:e=>i(Object.assign(Object.assign({},t),{openInNewWindow:e})),value:t.openInNewWindow},s.createElement(ke,{value:"New window"})):null)}class as{constructor(e){this.latitude=e.latitude,this.longitude=e.longitude}createStaticMap(){let e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:100,t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:75
const{latitude:n,longitude:s}=this,a=de
if(!a)return new ce.SafeString("")
const r=[`key=${a}`,`center=${encodeURIComponent(`${n},${s}`)}`,`markers=${encodeURIComponent(`size:small|${n},${s}`)}`,`size=${e}x${t}`,"zoom=15","maptype=roadmap"].join("&")
return new ce.SafeString(`\n      <img src="https://maps.googleapis.com/maps/api/staticmap?${r}" width="${e}" height="${t}" />\n    `)}toHTML(){return this.createStaticMap()}}function rs(e){let{results:t,onSelect:n}=e
return s.createElement("div",{className:""},t.map((e=>s.createElement("div",{onClick:()=>n(e)},e.formatted_address))))}(0,P.gn)([vt],as.prototype,"latitude",void 0),(0,P.gn)([vt],as.prototype,"longitude",void 0),(0,P.gn)([yt],as.prototype,"createStaticMap",null),(0,P.gn)([yt],as.prototype,"toHTML",null)
const ls=["address","street","country","zip","city"]
class is extends s.Component{constructor(){super(...arguments),this.autocomplete=null,this.input=null,this.state={isSearching:!1},this.handlePlaceChanged=()=>{const{autocomplete:e}=this
if(!e)return
const t=e.getPlace()
t.geometry&&this.props.onLocation({latitude:t.geometry.location.lat(),longitude:t.geometry.location.lng()})},this.handleResolve=()=>{const{places:e}=this.props
e&&(this.setState({isSearching:!0}),e.findPlaceFromQuery({query:this.getResolveQuery(),fields:["formatted_address","geometry"]},this.handleResolveResults))},this.handleResolveResults=e=>{this.setState({isSearching:!1}),e||(e=[]),1===e.length?this.handleResultsSelect(e[0]):this.setState({results:e})},this.handleResultsSelect=e=>{let{geometry:t}=e
if(!t)return
const{location:n}=t
this.props.onLocation({latitude:n.lat(),longitude:n.lng()}),this.handleResultsCancel()},this.handleResultsCancel=()=>{this.state.results&&this.setState({results:void 0})},this.setInput=e=>{let{autocomplete:t}=this
this.input=e,t&&(t.unbindAll(),t=null),e&&(t=new google.maps.places.Autocomplete(e),t.setFields(["geometry"]),t.addListener("place_changed",this.handlePlaceChanged)),this.autocomplete=t}}canResolve(){return""!==this.getResolveQuery()}getResolveQuery(){const{model:e}=this.props,t=[]
for(const n of ls)n in e&&"string"==typeof e[n]&&t.push(e[n].trim())
return t.join(", ")}render(){let e
if(this.canResolve()){const{results:t}=this.state
let n
t&&0===t.length?n=s.createElement(bn,{icon:"material:error"},"No locations found"):t&&(n=s.createElement(rs,{onSelect:this.handleResultsSelect,results:t})),e=s.createElement("div",{className:"tcfLocationFieldSearch--resolve"},n?s.createElement(Rt,{onClick:this.handleResultsCancel},n):null,s.createElement(xe,{onClick:this.handleResolve},s.createElement(ke,{value:"Resolve address"})))}return s.createElement("div",{className:"tcfLocationFieldSearch"},e,s.createElement("input",{className:"tcfLocationFieldSearch--input tcfInput",ref:this.setInput,type:"search"}))}}function os(e){return"object"==typeof e&&"number"==typeof e.latitude&&"number"==typeof e.longitude}var cs
!function(e){e[e.Loading=0]="Loading",e[e.Error=1]="Error",e[e.Ready=2]="Ready"}(cs||(cs={}))
class us extends s.Component{constructor(){super(...arguments),this.element=null,this.marker=null,this.state={instance:null,loadState:cs.Loading},this.handleLocation=e=>{const{instance:t}=this.state
t&&(t.map.setZoom(17),t.map.setCenter({lat:e.latitude,lng:e.longitude})),this.props.onUpdate(e)},this.handleMarkerDragEnd=()=>{const{marker:e}=this
if(!e)return
const t=e.getPosition()
t&&this.props.onUpdate({latitude:t.lat(),longitude:t.lng()})},this.setElement=e=>{const{disabled:t}=this.props
let{instance:n}=this.state,{marker:s}=this
if(n&&(us.stashInstance(n),n=null),s&&(s.setMap(null),s.unbindAll(),s=null),e){n=us.createInstance(),e.appendChild(n.element)
const{map:a}=n
a.setZoom(17),a.setCenter(this.getLatLng()),s=new google.maps.Marker({draggable:!t,position:this.getLatLng(),map:a}),s.addListener("dragend",this.handleMarkerDragEnd)}this.element=e,this.marker=s,this.setState({instance:n})}}componentDidUpdate(e){const{marker:t}=this
e.disabled!==this.props.disabled&&t&&t.setOptions({draggable:!this.props.disabled})}componentWillMount(){try{(me||(me=new Promise((e=>{window.onGoogleMapsReady=()=>{he=le.Loaded,e(google.maps)}
const t=document.createElement("script")
t.src=`https://maps.googleapis.com/maps/api/js?key=${de}&libraries=places&callback=onGoogleMapsReady`,(document.head||document.body).appendChild(t),me=me,he=le.Loading})))).then((()=>{this.setState({loadState:cs.Ready})}))}catch(e){this.setState({loadState:cs.Error})}}getLatLng(){const{data:e}=this.props
return os(e)?{lat:e.latitude,lng:e.longitude}:{lat:0,lng:0}}render(){const{loadState:e,instance:t}=this.state,{disabled:n,model:a}=this.props,{marker:r}=this
let l
return r&&r.setPosition(this.getLatLng()),l=e===cs.Loading?s.createElement(st,null):e===cs.Error?s.createElement(En,{title:"Could not load Google Maps"}):s.createElement(s.Fragment,null,n?null:s.createElement(is,{model:a,onLocation:this.handleLocation,places:t?t.places:null}),s.createElement("div",{className:"tcfLocation--map",ref:this.setElement})),s.createElement("div",{className:"tcfLocation"},l)}static createInstance(){let e=this.instanceStash.pop()
if(!e){const t=document.createElement("div")
t.className="tcfLocation--mapInstance"
const n=new google.maps.Map(t,{mapTypeControl:!1,streetViewControl:!1})
e={element:t,map:n,places:new google.maps.places.PlacesService(n)}}return e}static stashInstance(e){const{element:t}=e,{parentElement:n}=t
n&&n.removeChild(t),this.instanceStash.push(e)}}us.instanceStash=[]
function ds(e){let{data:t,disabled:n,errors:a,field:r,onUpdate:l}=e
const[i,o]=s.useState(!1),[c,u]=s.useState(t),{max:d,min:m,placeholder:h,unit:p}=r,f=i?c:t
const g=s.createElement("input",{autoComplete:"off",className:Ce()("tcfNumberWidget--input text fullwidth",{error:a&&a.length}),disabled:n,max:null===d?void 0:d,min:null===m?void 0:m,onBlur:function(){o(!1),u(t)},onChange:function(e){const{value:t}=e.target
u(t),l(function(e,t){let{dataType:n,defaultValue:s,max:a,min:r,optional:l}=e,i="integer"===n?parseInt(t):parseFloat(t)
if(isFinite(i))"number"==typeof a&&i>a&&(i=a),"number"==typeof r&&i<r&&(i=r)
else{if(l)return null
i=s}return i}(r,t))},onFocus:function(){o(!0)},placeholder:h,type:"number",value:f})
return p?s.createElement("div",{className:"tcfNumberWidget"},g,s.createElement("div",{className:"tcfNumberWidget--unit"},p)):g}class ms extends Kt{cloneValue(e){return(0,P.mG)(this,void 0,void 0,(function*(){const{field:t,schemas:n,value:s}=e
return this.isValue(t,s)?s:this.createValue({field:t,schemas:n})}))}createValue(e){let{field:t}=e
return t.defaultValue}isValue(e,t){let{optional:n}=e
return!(!n||null!==t)||("number"==typeof t||t instanceof Number)}preview(e){let{value:t}=e
return t}}class hs{constructor(e){this.value=e}get summary(){return new ce.SafeString(`<div class="snippet">${this.value}</div>`)}toHTML(){return new ce.SafeString(this.value)}}function ps(e){let{value:t}=e
return s.createElement("div",{className:"redactor-box redactor-styles-on redactor-toolbar-on focusable-input redactor-focus focus"},s.createElement("div",{className:"redactor-styles redactor-in redactor-in-0",dangerouslySetInnerHTML:{__html:t}}))}(0,P.gn)([vt],hs.prototype,"value",void 0),(0,P.gn)([vt],hs.prototype,"summary",null),(0,P.gn)([yt],hs.prototype,"toHTML",null)
class fs extends s.Component{constructor(){var e
super(...arguments),e=this,this.element=null,this.hasFocus=!1,this.instance=null,this.renderedValue="",this.uuid=`element-${b()}`,this.handleBlur=()=>{this.hasFocus=!1},this.handleChange=function(t){e.hasFocus&&(e.renderedValue=t,e.props.onUpdate(t))},this.handleFocus=()=>{this.hasFocus=!0},this.setElement=e=>{if(this.element===e)return
this.element=e
const{elementSiteId:t,options:n}=this.props
let{instance:s}=this
s&&(s.redactor&&(s.redactor.off("blur",this.handleBlur),s.redactor.off("changed",this.handleChange),s.redactor.off("focus",this.handleFocus)),s.destroy(),s=null),e&&(s=new Craft.RedactorInput(Object.assign(Object.assign({},n),{elementSiteId:t,id:this.uuid,redactorConfig:Object.assign({},n.redactorConfig)})),e.removeAttribute("name"),s.redactor&&(s.redactor.on("blur",this.handleBlur),s.redactor.on("changed",this.handleChange),s.redactor.on("focus",this.handleFocus))),this.instance=s}}componentDidUpdate(){const{hasFocus:e,instance:t,props:n,renderedValue:s}=this
t&&!e&&n.value!=s&&(this.renderedValue=n.value,t.redactor.source.setCode(n.value))}render(){const{value:e}=this.props
return s.createElement("div",{className:"tcfRedactorWidget"},s.createElement("textarea",{defaultValue:"string"==typeof e?e:"",id:this.uuid,ref:this.setElement}))}}function gs(e){return e.disabled?s.createElement(ps,Object.assign({},e)):s.createElement(fs,Object.assign({},e))}var ys=(0,i.$j)((e=>({elementSiteId:e.config.elementSiteId})))((function(e){let{data:t,disabled:n,elementSiteId:a,field:r,onUpdate:l}=e
return r.redactor?s.createElement(gs,{disabled:n,elementSiteId:a,onUpdate:l,options:r.redactor,value:t}):null}))
let vs=0
class bs extends Kt{cloneValue(e){return(0,P.mG)(this,void 0,void 0,(function*(){const{field:t,translate:n,value:s}=e
return this.isValue(t,s)?t.translatable&&n?function(e,t){return(0,P.mG)(this,void 0,void 0,(function*(){if(vs>2)return console.warn(`Translator has returned to many errors, skipping translation for text "${e}".`),e
const{endpoint:n,csrfParams:s={}}=t,a=(0,P._T)(t,["endpoint","csrfParams"]),r=Object.assign(Object.assign(Object.assign({},a),s),{text:e}),l=new FormData
return Object.keys(r).forEach((e=>l.append(e,r[e]))),new Promise((t=>{fetch(n,{body:l,method:"post"}).then((e=>e.json())).then((n=>{t(n&&n.data?n.data:e)})).catch((n=>{console.error(`Translator returned an error: ${n}`),vs+=1,t(e)}))}))}))}(s,n):s:""}))}createValue(e){return""}isValue(e,t){return"string"==typeof t||t instanceof String}preview(e){let{value:t}=e
return t}}class Es{constructor(e){this.reference=e}createPreview(){let e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"large",t=!(arguments.length>1&&void 0!==arguments[1])||arguments[1]
const{reference:n}=this,s=n.$element.clone(!1,!0)
s.removeClass("large removable small"),s.addClass(e)
const a=s.find(".elementthumb")
if(a.length){let t=a.find("img")[0]
t||(t=document.createElement("img"),t.srcset=a.attr("data-srcset")||"",a.append(t)),t.sizes="small"===e?"30px":"100px"}return t?`<div class="tcfInstancePreview--thumb ${e}">${a?a.html():""}</div>`:s[0].outerHTML}createSafePreview(){let e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"large",t=!(arguments.length>1&&void 0!==arguments[1])||arguments[1]
return new ce.SafeString(this.createPreview(e,t))}get asBackground(){const{reference:e}=this,t=e.$element.find(".elementthumb").attr("data-srcset")
if(!t)return null
const n=t.split(",").pop()
return n?new ce.SafeString(`<div class="tcfInstancePreview--background" style="background-image: url('${n.trim()}');"></div><div class="tcfInstancePreview--background blur" style="background-image: url('${n.trim()}');"></div>`):null}get asLargeElement(){return this.createSafePreview("large",!1)}get asLargeImage(){return this.createSafePreview("large",!0)}get asSmallElement(){return this.createSafePreview("small",!1)}get asSmallImage(){return this.createSafePreview("small",!0)}get label(){return this.reference.label}toHTML(){return new ce.SafeString(this.toString())}toString(){return this.createPreview()}}(0,P.gn)([vt],Es.prototype,"reference",void 0),(0,P.gn)([yt],Es.prototype,"createPreview",null),(0,P.gn)([yt],Es.prototype,"createSafePreview",null),(0,P.gn)([vt],Es.prototype,"asBackground",null),(0,P.gn)([vt],Es.prototype,"asLargeElement",null),(0,P.gn)([vt],Es.prototype,"asLargeImage",null),(0,P.gn)([vt],Es.prototype,"asSmallElement",null),(0,P.gn)([vt],Es.prototype,"asSmallImage",null),(0,P.gn)([vt],Es.prototype,"label",null),(0,P.gn)([yt],Es.prototype,"toHTML",null),(0,P.gn)([yt],Es.prototype,"toString",null)
class ws extends Array{constructor(e){super(...function(e){let{context:{references:t},field:n,value:s}=e
const a=[]
if(!n)return a
const{elementType:r}=n
for(const e of s){const n=t.find((t=>t.id===e&&t.type===r))
n&&a.push(new Es(n))}return a}(e))}get asBackground(){return this.length?this[0].asBackground:null}get asLargeElement(){return this.length?this[0].asLargeElement:null}get asLargeImage(){return this.length?this[0].asLargeImage:null}get asSmallElement(){return this.length?this[0].asSmallElement:null}get asSmallImage(){return this.length?this[0].asSmallImage:null}get firstLabel(){return this.length?this[0].label:""}get label(){return this._map((e=>e.label)).join(", ")}toHTML(){return new ce.SafeString(`<div class="tcfInstancePreview--elements">${this.toString()}</div>`)}toString(){return this._map((e=>pt(e))).join("")}_map(e){const t=[]
for(let n=0;n<this.length;n++)t.push(e(this[n],n))
return t}}function Cs(e){let{data:t,disabled:n,field:a,model:r,onUpdate:l}=e
return s.createElement(Xn,{allowSelfReference:a.allowSelfReference,criteria:a.criteria,disabled:n,data:t,elementType:a.elementType,limit:a.limit||null,modalStorageKey:a.modalStorageKey||`tcf_${r.__type}_${a.name}`,onUpdate:l,sources:a.sources||null,viewMode:a.viewMode})}(0,P.gn)([vt],ws.prototype,"asBackground",null),(0,P.gn)([vt],ws.prototype,"asLargeElement",null),(0,P.gn)([vt],ws.prototype,"asLargeImage",null),(0,P.gn)([vt],ws.prototype,"asSmallElement",null),(0,P.gn)([vt],ws.prototype,"asSmallImage",null),(0,P.gn)([vt],ws.prototype,"firstLabel",null),(0,P.gn)([vt],ws.prototype,"label",null),(0,P.gn)([yt],ws.prototype,"toHTML",null),(0,P.gn)([yt],ws.prototype,"toString",null)
class Ss extends Kt{createValue(e){let{field:t}=e
return t.defaultValue&&this.isValue(t,t.defaultValue)?t.defaultValue:t.options[0].key}isValue(e,t){return e.options.some((e=>e.key==t))}preview(e){let{field:t,value:n}=e
const s=t?t.options.find((e=>e.key===n)):void 0
return s?s.label:"-"}}function _s(e){let{data:t,disabled:n,onUpdate:a,field:r}=e
return s.createElement(Re,{disabled:n,onChange:a,options:r.options,value:t})}function Os(e){let t
return e&&(t="color"in e?e.color:e.label),"string"==typeof t?t:"transparent"}class xs extends s.Component{constructor(){super(...arguments),this.state={isExpanded:!1},this.handleFlyoutClick=()=>{this.setState({isExpanded:!1})},this.handleSelect=e=>{this.props.onUpdate(e.key),this.setState({isExpanded:!1})},this.handleSwatchClick=e=>{e.currentTarget===e.target&&this.setState({isExpanded:!0})}}render(){const{data:e,disabled:t,field:n}=this.props,{isExpanded:a}=this.state,r=n.options.find((t=>t.key===e))
return s.createElement("div",{className:Ce()("tcfSwatchColorWidget",{isUndecided:!r}),onClick:t?void 0:this.handleSwatchClick,style:{background:r?Os(r):void 0}},a&&!t?this.renderFlyout(r):null)}renderFlyout(e){const{field:t}=this.props
return s.createElement(Rt,{onClick:this.handleFlyoutClick},s.createElement("div",{className:"tcfSwatchColorWidget--swatches"},t.options.map((t=>s.createElement("div",{className:Ce()("tcfSwatchColorWidget--swatch",{isSelected:t===e}),key:t.key,onClick:()=>this.handleSelect(t),style:{background:Os(t)}})))))}}function ks(e){let{data:t,disabled:n,errors:a,field:{maxLength:r,minLength:l,placeholder:i,inputType:o},onUpdate:c}=e
return s.createElement("input",{autoComplete:"off",className:Ce()("tcfTextWidget text fullwidth",{error:a&&a.length}),disabled:n,maxLength:r,minLength:l,onChange:e=>c(e.target.value),placeholder:i,type:o,value:t?`${t}`:""})}function Ns(e){let{data:t,disabled:n,field:{maxLength:a,minLength:r,monospace:l,placeholder:i,rows:o},onUpdate:c}=e
return s.createElement("textarea",{className:Ce()("tcfTextareaWidget text fullwidth",{monospace:l}),disabled:n,maxLength:a,minLength:r,onChange:e=>c(e.target.value),placeholder:i,rows:o,value:t})}v.initialize({array:new class extends Kt{constructor(){super({widget:qt})}cloneValue(e){return(0,P.mG)(this,void 0,void 0,(function*(){const{field:t,value:n}=e,s=(0,P._T)(e,["field","value"])
if(this.isValue(t,n)){const e=v.getDefinition(t.member.type),a=[]
for(const r of n)a.push(yield e.cloneValue(Object.assign(Object.assign({},s),{field:t.member,value:r})))
return a}return this.createValue(e)}))}createValue(e){return[]}isValue(e,t){return Array.isArray(t)}preview(e){return new Et(e)}},checkbox:new class extends Jt{constructor(){super({widget:Qt}),this.isAlwaysPlainField=!0}},color:new class extends Kt{constructor(){super({widget:vn})}createValue(e){return{alpha:1,blue:255,green:255,red:255}}isValue(e,t){return en(t)}preview(e){let{context:t,value:n}=e
return""}},instance:new class extends Kt{constructor(){super({factory:Nn,widget:Mn})}cloneValue(e){return(0,P.mG)(this,void 0,void 0,(function*(){const{field:t,value:n}=e,s=(0,P._T)(e,["field","value"])
return this.isValue(t,n)?R(Object.assign(Object.assign({},s),{source:n})):this.createValue(e)}))}createValue(e){let{field:t,schema:n,schemas:s}=e
if(n||(n=s[t.schemas[0]]),!n)throw new Error("The option `schema` is required when creating instances.")
return E({schema:n,schemas:s})}isValue(e,t){return c(t)&&-1!==e.schemas.indexOf(t.__type)}preview(e){let{context:t,mode:n="default",value:s}=e
if(!c(s))return""
const a=t.schemas[s.__type]
if(!a)return""
const r="label"===n?a.previewLabelTemplate:a.previewTemplate
if(null===r)return a.label
const l={toHTML:()=>new ce.SafeString(r(l,bt())),toString:()=>r(l,bt())}
l.depth=t.depth
for(const e of Object.keys(a.fields)){const n=a.fields[e],r=v.getDefinition(n)
r&&(l[e]=r.preview({context:Object.assign(Object.assign({},t),{depth:t.depth+1}),field:n,value:s[e]}))}return l}},layout:new class extends Kt{constructor(){super({widget:Bn})}cloneValue(e){return(0,P.mG)(this,void 0,void 0,(function*(){const{field:t,value:n}=e,s=(0,P._T)(e,["field","value"]),{schemas:a}=s
if(!this.isValue(t,n))return this.createValue(e)
const r=K(t,a),l=v.getDefinition(r),i=[]
for(let e=0;e<n.columns.length;e++){const o=n.columns[e],c=yield l.cloneValue(Object.assign({field:r,value:o.value},s))
i.push(q(t,a,o,c))}return{__role:"layout",__uuid:b(),preset:n.preset,columns:i}}))}createValue(e){let{field:t,schemas:n}=e
const s=this.getDefaultPreset(t)
let a
if(s)a=s.columns.map((e=>q(t,n,e)))
else for(a=[];a.length<t.constraints.minColumns;)a.push(q(t,n))
return{__role:"layout",__uuid:b(),preset:s?s.key:null,columns:a}}getDefaultPreset(e){let{defaultPreset:t,presets:n}=e
const s=n.length?n[0]:null
return n.find((e=>e.key===t))||s}isValue(e,t){return Y(t)}preview(e){let{context:t,field:n,value:s}=e
if(!n)return""
const{breakpoints:a,columnsPerRow:r}=n,l=K(n,t.schemas),i=v.getDefinition(l),o={breakpoints:a,current:a[a.length-1]},c=s.columns.map((e=>{const n=X(e.order,o),s=X(e.offset,o)/r,a=X(e.width,o)/r
return`<div style="${[`margin-left:${(100*s).toFixed(6)}%`,`order:${n}`,`width:${(100*a).toFixed(6)}%`].join(";")}">${pt(i.preview({context:t,field:l,value:e.value}))}</div>`}))
return new ce.SafeString(`<div class="tcpRow">${c.join("")}</div>`)}},lightswitch:new class extends Jt{constructor(){super({widget:zn})}},link:new class extends Kt{constructor(){super({widget:ss})}createValue(){return{elementId:0,hash:"",openInNewWindow:!1,type:"url",url:""}}isValue(e,t){return ns(t)}preview(){return""}},location:new class extends Kt{constructor(){super({widget:us})}createValue(e){let{field:t}=e
return os(t.defaultValue)?Object.assign({},t.defaultValue):{latitude:0,longitude:0}}isValue(e,t){return os(t)}preview(e){let{value:t}=e
return new as(t)}},number:new class extends ms{constructor(){super({widget:ds})}},oembed:new class extends Kt{constructor(){super({widget:Sn})}createValue(e){return{url:""}}isValue(e,t){return wn(t)}preview(e){let{value:t}=e
return new _n(wn(t)?t:{url:""})}},redactor:new class extends bs{constructor(){super({widget:ys})}preview(e){let{value:t}=e
return new hs(t)}},reference:new class extends Kt{constructor(){super({widget:Cs})}createValue(e){return[]}isValue(e,t){return Array.isArray(t)&&t.every((e=>"number"==typeof e))}preview(e){return new ws(e)}},select:new class extends Ss{constructor(){super({widget:_s})}},swatchcolor:new class extends Ss{constructor(){super({widget:xs})}},text:new class extends bs{constructor(){super({widget:ks})}},textarea:new class extends bs{constructor(){super({widget:Ns})}}})
n(524)
const js=[],Ms={},Is={create:e=>{try{let t=null
const n=document.getElementById(e)
if(!n)throw new Error("Root element not found.")
const o=n.querySelector(".tcfField--app"),c=n.querySelector('script[type="application/json"]'),u=n.querySelector("input.tcfField--model")
if(!u||!o||!c)throw new Error("Missing components.")
const d=(0,l.MT)(ht,ve(c,u),(0,l.md)(r.Z))
js.push(d),d.subscribe((()=>{const{draftEditor:e}=window,n=JSON.stringify(d.getState().model)
u.value!==n&&e&&(t&&window.clearTimeout(t),t=window.setTimeout((()=>{e.checkForm(),t=null}),500)),u.value=n})),a.render(s.createElement(i.zt,{store:d},s.createElement(mt,null)),o)}catch(e){console.error("Could not start content editor.",e)}},getInstanceApi:e=>{for(const t of js){const n=d(t.getState(),e)
return n?re(t,n):null}},getValidator:function(e){return e in Ms?Ms[e]:null},registerValidator:(e,t)=>{Ms[e]=t}}
if(window){const e=window;(e.lenz||(e.lenz={})).contentField=Is}var Ls=Is},524:function(){const e="tcfDetailsToggleState"
function t(e,t,n){t.classList.toggle("tcfDetailsToggle--collapsed",e.isCollapsed),n.classList.toggle("focus",e.isCollapsed)}!function(){const n=function(){try{let n=JSON.parse(sessionStorage.getItem(e)||"{}")
if("object"!=typeof(t=n)||"boolean"!=typeof t.isCollapsed)throw new Error("Invalid details state.")
return n}catch(e){return{isCollapsed:!1}}var t}(),s=document.getElementById("main-content"),a=document.getElementById("action-buttons")
if(!a||!s)return
const r=document.createElement("button")
r.className="btn",r.type="button",r.innerHTML='<span class="tcfIcon craft">sidebar-right</span>',r.addEventListener("click",(()=>{n.isCollapsed=!n.isCollapsed,function(t){sessionStorage.setItem(e,JSON.stringify(t))}(n),t(n,s,r)}))
const l=document.createElement("div")
l.className="tcfDetailsToggle",l.append(r),a.insertBefore(l,a.querySelector("#save-btn-container")||a.firstElementChild),t(n,s,r)}()}},n={}
function s(e){var a=n[e]
if(void 0!==a)return a.exports
var r=n[e]={exports:{}}
return t[e].call(r.exports,r,r.exports,s),r.exports}s.m=t,e=[],s.O=function(t,n,a,r){if(!n){var l=1/0
for(u=0;u<e.length;u++){n=e[u][0],a=e[u][1],r=e[u][2]
for(var i=!0,o=0;o<n.length;o++)(!1&r||l>=r)&&Object.keys(s.O).every((function(e){return s.O[e](n[o])}))?n.splice(o--,1):(i=!1,r<l&&(l=r))
if(i){e.splice(u--,1)
var c=a()
void 0!==c&&(t=c)}}return t}r=r||0
for(var u=e.length;u>0&&e[u-1][2]>r;u--)e[u]=e[u-1]
e[u]=[n,a,r]},s.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e}
return s.d(t,{a:t}),t},s.d=function(e,t){for(var n in t)s.o(t,n)&&!s.o(e,n)&&Object.defineProperty(e,n,{enumerable:!0,get:t[n]})},s.g=function(){if("object"==typeof globalThis)return globalThis
try{return this||new Function("return this")()}catch(e){if("object"==typeof window)return window}}(),s.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},s.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},function(){var e={131:0}
s.O.j=function(t){return 0===e[t]}
var t=function(t,n){var a,r,l=n[0],i=n[1],o=n[2],c=0
if(l.some((function(t){return 0!==e[t]}))){for(a in i)s.o(i,a)&&(s.m[a]=i[a])
if(o)var u=o(s)}for(t&&t(n);c<l.length;c++)r=l[c],s.o(e,r)&&e[r]&&e[r][0](),e[l[c]]=0
return s.O(u)},n=self.webpackChunkcraft_contentfield_ui=self.webpackChunkcraft_contentfield_ui||[]
n.forEach(t.bind(null,0)),n.push=t.bind(null,n.push.bind(n))}()
var a=s.O(void 0,[736],(function(){return s(400)}))
a=s.O(a)}()
