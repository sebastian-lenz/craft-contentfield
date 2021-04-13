(()=>{"use strict"
var e,t={948:(e,t,n)=>{n.d(t,{Z:()=>Ls})
var s=n(294),a=n(935),r=n(894),i=n(890),l=n(512)
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
const a=o(e,s),r="index"===n.type?n.index:void 0,i=a.fields[n.name]
if(!i)throw new Error(`Could not resolve field "${n.name}" on schema "${a.qualifier}".`)
return{field:i,index:r,owner:s,path:t,schema:a}}function g(e,t){return Craft.t("contentfield",e,t)}function y(e){return{references:e,type:"addReferences"}}const v=new class{initialize(e){this.definitions=e}createValue(e){return this.getDefinition(e.field).createValue(e)}getDefinition(e){return this.definitions["object"==typeof e?e.type:e]}}
function b(){return"10000000-1000-4000-8000-100000000000".replace(/[018]/g,(e=>(e^crypto.getRandomValues(new Uint8Array(1))[0]&15>>e/4).toString(16)))}function E({schemas:e,schema:t,oldModel:n}){const s={__errors:{},__type:t.qualifier,__uuid:b(),__visible:!0}
for(const a of Object.keys(t.fields)){const r=t.fields[a],i=v.getDefinition(r)
let l=n&&a in n?n[a]:void 0
void 0!==l&&i.isValue(r,l)||(l=i.createValue({field:r,schemas:e})),s[a]=l}return s}function w(e,t,n){if(!t)return n(e)
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
return Object.assign(Object.assign({},e),{targetPath:r,targetSegment:n})}}return e}function O(e,t){return e.length===t.length&&e.every(((e,n)=>S(e,t[n])))}function x(e,t){const{sourcePath:n,sourceSegment:s,targetPath:a,targetSegment:r}=t,i=[...n,s],l=[...a,r],c=p(e.model,a)
if(!c)return!1
const u=o(e,c).fields[r.name],d=c[r.name]
if(!Array.isArray(d)||!u||"array"!==u.type)return!1
const m=_(t)
if(O(i,l)||O(i,[...m.targetPath,m.targetSegment]))return!1
if(!(O(n,a)&&r.name===s.name)&&u.limit>0&&d.length>=u.limit)return!1
const{member:h}=u,f=v.getDefinition(h.type),g=p(e.model,i)
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
for(const a of Object.keys(e.fields)){const r=e.fields[a],i=v.getDefinition(r)
s[a]=yield i.cloneValue(Object.assign(Object.assign({},n),{field:r,value:t[a]}))}return s}))}function U(e){var{apiEndpoint:t}=e,n=(0,P._T)(e,["apiEndpoint"])
const s=Object.keys(n).map((e=>`${e}=${encodeURIComponent(n[e])}`)).join("&")
return new Promise(((e,n)=>{fetch(`${t}&${s}`).then((e=>e.json())).then((t=>{!function(e){return"object"==typeof e&&"object"==typeof e.data&&!0===e.result&&Array.isArray(e.references)}(t)?n(t&&t.message?`${t.message}`:"An unknown error has occured."):e(t)})).catch((e=>{n(`${e}`)}))}))}function F(e){return c(e)?`[${e.__type}, ${e.__uuid}]`:"[no model]"}const W={group:console.groupCollapsed,groupEnd:console.groupEnd,info:console.info,model:F},D={group(){},groupEnd(){},info(){},model:F}
function V(e){return e&&e.verbose?W:D}function H(e){if(!Array.isArray(e))return[]
const t=[]
for(const n of e)c(n)&&t.push(n)
return t}function B(e,t){const n=null!==e.__originalUuid,s=null!==t.__originalUuid
return e.__uuid===t.__uuid||s&&e.__uuid===t.__originalUuid||n&&e.__originalUuid===t.__uuid||n&&s&&e.__originalUuid===t.__originalUuid}function z(e){var{field:t,source:n,target:s}=e,a=(0,P._T)(e,["field","source","target"])
return(0,P.mG)(this,void 0,void 0,(function*(){if("instance"!==t.member.type)return n||[]
const e=H(n),r=H(s),i=V(a),l=[]
for(const t of e){const e=r.findIndex((e=>B(e,t)))
let n
if(-1===e)i.info(`No array match for ${i.model(t)}`),n=yield R(Object.assign(Object.assign({},a),{source:t}))
else{const s=r[e]
i.info(`Array match for ${i.model(t)} is ${i.model(s)}`),r.splice(e,1),n=yield Z(Object.assign(Object.assign({},a),{source:t,target:s}))}n&&l.push(n)}if("remove"!==a.arrayOrphanMode)for(const e of r)"hide"===a.arrayOrphanMode?l.push(Object.assign(Object.assign({},e),{__visible:!1})):l.push(e)
return l}))}function q(e,t,n,s){const{key:a}=e.breakpoints[0]
return{__errors:{},__role:"layoutColumn",__type:e.columnTypeQualifier,__uuid:b(),__visible:!0,offset:n?Object.assign({},n.offset):{[a]:0},order:n?Object.assign({},n.order):{[a]:0},value:s||G(e,t),width:n?Object.assign({},n.width):{[a]:e.constraints.minColumnWidth}}}function G(e,t){const n=K(e,t)
return v.getDefinition(n).createValue({field:n,schemas:t})}function X(e,{breakpoints:t,current:n}){for(let s=n.index;s>=0;s--){const{key:n}=t[s]
if(n in e)return e[n]}return 0}function K(e,t){return t[e.columnTypeQualifier].fields.value}function J(e,t,n){const{current:s}=n
return function(e,t,{breakpoints:n}){let s=NaN
return n.reduce(((n,{key:a})=>{let r=isNaN(s)?t:s
return a in e&&(r=e[a]),r!==s&&(s=r,n[a]=r),n}),{})}(Object.assign(Object.assign({},e),{[s.key]:t}),0,n)}function Y(e){return"object"==typeof e&&"__uuid"in e&&"__role"in e&&"layout"===e.__role}function Q(e){var{field:t,source:n,target:s}=e,a=(0,P._T)(e,["field","source","target"])
return(0,P.mG)(this,void 0,void 0,(function*(){const e=V(a)
if(!Y(n))return e.info(`No source, skipping ${t.name}`),s
if(!Y(s))return s?e.info(`Type missmatch, cloning ${t.name}`):e.info(`No target, cloning ${t.name}`),function(e){var{source:t}=e,n=(0,P._T)(e,["source"])
return(0,P.mG)(this,void 0,void 0,(function*(){const e=[]
for(let s=0;s<t.columns.length;s++){const a=t.columns[s],r=yield R(Object.assign(Object.assign({},n),{source:a}))
e.push(Object.assign(Object.assign({},r),{__role:"layoutColumn",offset:Object.assign({},a.offset),order:Object.assign({},a.order),width:Object.assign({},a.width)}))}return{__role:"layout",__uuid:b(),columns:e,preset:t.preset}}))}(Object.assign(Object.assign({},a),{source:n}))
e.group(`Syncing layouts ${t.name}`)
const r=[]
for(let e=0;e<n.columns.length;e++){const t=n.columns[e],i=yield Z(Object.assign(Object.assign({},a),{source:t,target:s.columns[e]}))
r.push(Object.assign(Object.assign({},i),{__role:"layoutColumn",offset:Object.assign({},t.offset),order:Object.assign({},t.order),width:Object.assign({},t.width)}))}return e.groupEnd(),Object.assign(Object.assign({},s),{columns:r,preset:n.preset})}))}function Z(e){var{source:t,target:n}=e,s=(0,P._T)(e,["source","target"])
return(0,P.mG)(this,void 0,void 0,(function*(){const e=V(s)
if(!c(t))return e.info(`No source, skipping ${e.model(n)}`),n
if(!c(n)||n.__type!==t.__type)return n?e.info(`Type missmatch, cloning ${e.model(t)}`):e.info(`No target, cloning ${e.model(t)}`),R(Object.assign(Object.assign({},s),{source:t}))
const a=s.schemas[t.__type]
if(!a)throw new Error("Invalid schema")
const r=Object.assign({},n)
e.group(`Syncing model ${e.model(t)} > ${e.model(n)}`)
for(const i of Object.keys(a.fields)){const l=a.fields[i]
"layout"===l.type?(e.group(`Layout ${i}`),r[i]=yield Q(Object.assign(Object.assign({},s),{field:l,source:t[i],target:n[i]})),e.groupEnd()):"array"===l.type?(e.group(`Array ${i}`),r[i]=yield z(Object.assign(Object.assign({},s),{field:l,source:t[i],target:n[i]})),e.groupEnd()):"instance"===l.type&&(e.group(`Instance ${i}`),r[i]=yield Z(Object.assign(Object.assign({},s),{source:t[i],target:n[i]})),e.groupEnd())}return e.groupEnd(),r}))}function ee(e){return(t,n)=>(0,P.mG)(this,void 0,void 0,(function*(){try{yield function(e,t,n){var{siteId:s}=e,a=(0,P._T)(e,["siteId"])
return(0,P.mG)(this,void 0,void 0,(function*(){t(A({status:"working"}))
const{config:e,model:r,schemas:i}=n()
if("number"!=typeof e.elementId)throw new Error("Entry must be saved before it can be synchronized.")
const{data:l,references:o}=yield U({apiEndpoint:e.apiEndpoints.fetchSite,elementId:e.elementId,fieldHandle:e.fieldHandle,siteId:s})
if(!c(l)||!e.rootSchemas.some((e=>e===l.__type)))throw new Error("Selected target site does not contain a valid model.")
const u=c(r)&&r.__type===l.__type?yield Z(Object.assign(Object.assign({},a),{schemas:i,source:l,target:r})):yield R(Object.assign(Object.assign({},a),{schemas:i,source:l}))
t(y(o)),t(T([],void 0,u)),t(A({status:"finished"}))}))}(e,t,n)}catch(e){t(A({status:"error",message:`${e}`}))}}))}const te={addReferences:function(e,t){const n=e.config.references.slice(),s=document.createElement("div")
for(const e of t.references)if(!n.some((({id:t,type:n})=>e.id===t&&e.type===n))){s.innerHTML=e.element
const t=s.firstElementChild
t&&(t.removeAttribute("style"),e.element=t.outerHTML),e.$element=$(e.element),e.hasThumb=e.$element.hasClass("hasthumb"),n.push(e)}return Object.assign(Object.assign({},e),{config:Object.assign(Object.assign({},e.config),{references:n})})},changeType:function(e,{expandedState:t,newType:n,path:s}){const a=e.schemas[n]
if(!a)return e
const r=p(e.model,s),i=E({oldModel:r,schema:a,schemas:e.schemas})
return r&&t&&t.isExpanded(r.__uuid)&&(t.toggleExpanded(r.__uuid,!1),t.toggleExpanded(i.__uuid,!0)),Object.assign(Object.assign({},e),{model:C(e.model,s,(()=>i))})},moveModel:function(e,t){let{model:n}=e
if(!x(e,t))throw new Error("Invalid operation")
const{sourcePath:s,sourceSegment:a,targetPath:r,targetSegment:i}=_(t),l=p(n,[...s,a])
return n=C(n,s,(e=>{if(!e)throw new Error("Invalid operation")
let t=e[a.name]
if(!Array.isArray(t))throw new Error("Invalid operation")
return t=t.slice(),t.splice(a.index,1),Object.assign(Object.assign({},e),{[a.name]:t})})),n=C(n,r,(e=>{if(!e)throw new Error("Could not find target")
let t=e[i.name]
if(!Array.isArray(t))throw new Error("Unsupported operation")
return t=t.slice(),i.index>=t.length?t.push(l):t.splice(i.index,0,l),Object.assign(Object.assign({},e),{[i.name]:t})})),Object.assign(Object.assign({},e),{model:n})},setOverlay:function(e,{overlay:t}){return Object.assign(Object.assign({},e),{overlay:t})},setUser:function(e,{user:t}){const n=Object.assign(Object.assign({},e.user),t)
try{window.localStorage.setItem(j,JSON.stringify(n))}catch(e){console.error(e)}return Object.assign(Object.assign({},e),{user:n})},uuidInsert:function(e,{position:t,uuid:n,value:s}){const a=d(e,n)
if(!a)return e
const r=f(e,a.path)
if(!r||"array"!==r.field.type||void 0===r.index)return e
const{field:i,index:l,path:o}=r,{name:c}=i
return Object.assign(Object.assign({},e),{model:C(e.model,o,(n=>{if(!n||!(c in n))return n
const a=n[c]
if(!Array.isArray(a))return n
const r=[...a],i=l+("after"===t?1:0)
r.splice(i,0,s)
const o=Object.assign(Object.assign({},n),{[c]:r})
return M(e,o),o}))})},uuidOrder:function(e,{direction:t,uuid:n}){const s=d(e,n)
if(!s)return e
const a=f(e,s.path)
if(!a||"array"!==a.field.type||void 0===a.index)return e
const{field:r,index:i,path:l}=a,{name:o}=r
return Object.assign(Object.assign({},e),{model:C(e.model,l,(n=>{if(!n||!(o in n))return n
const s=n[o]
if(!Array.isArray(s))return n
const a=i+("up"===t?-1:1),r=[...s],l=r.splice(i,1)
r.splice(a,0,...l)
const c=Object.assign(Object.assign({},n),{[o]:r})
return M(e,c),c}))})},uuidRemove:function(e,{uuid:t}){const n=d(e,t)
if(!n)return e
const s=f(e,n.path)
if(!s||"array"!==s.field.type||void 0===s.index)return e
const{field:a,index:r,path:i}=s,{name:l}=a
return Object.assign(Object.assign({},e),{model:C(e.model,i,(t=>{if(!t||!(l in t))return t
const n=t[l]
if(!Array.isArray(n))return t
const s=[...n]
s.splice(r,1)
const a=Object.assign(Object.assign({},t),{[l]:s})
return M(e,a),a}))})},uuidVisibility:function(e,{uuid:t}){const n=d(e,t)
return n?Object.assign(Object.assign({},e),{model:C(e.model,n.path,(e=>e?Object.assign(Object.assign({},e),{__visible:!e.__visible}):e))}):e},updateSync:function(e,{sync:t}){let{overlay:n}=e
return n&&"synchronize"===n.type&&(n=Object.assign(Object.assign({},n),{preventClose:"working"===t.status})),Object.assign(Object.assign({},e),{overlay:n,sync:t})},updateValue:function(e,{path:t,key:n,value:s}){return Object.assign(Object.assign({},e),{model:C(e.model,t,(t=>{const a=n?Object.assign(Object.assign({},t),{[n]:s}):s
return M(e,a),a}))})}}
const ne=[function({location:{uuid:e},owner:t}){return t&&"array"===t.field.type?{group:se.Manipulation,icon:"material:add",id:"create",invoke:(t,n=!1)=>{t(N({afterCreate:n?"layer":"expand",type:"create",uuid:e}))},label:g("Create")}:null},function({location:{uuid:e}}){return{group:se.Manipulation,icon:"material:edit",id:"edit",invoke:t=>{t(N({type:"edit",uuid:e}))},label:g("Edit")}},function({owner:e,location:{uuid:t}}){return e&&"array"===e.field.type?{group:se.Manipulation,icon:"material:delete",id:"delete",invoke:e=>{e(function(e){return{type:"uuidRemove",uuid:e}}(t))},label:g("Delete")}:null},function({location:{uuid:e,model:{__visible:t}}}){return{group:se.Visibility,icon:t?"material:visibility_off":"material:visibility",id:"visibility",invoke:t=>{t(L(e))},label:g(t?"Hide":"Show")}},function({location:{uuid:e},owner:t}){if(!t||"array"!==t.field.type)return null
const n=t.owner[t.field.name]
return!Array.isArray(n)||void 0===t.index||t.index<=0?null:{group:se.Movement,icon:"material:arrow_upward",id:"moveUp",invoke:t=>t(I(e,"up")),label:g("Move up")}},function({location:{uuid:e},owner:t}){if(!t||"array"!==t.field.type)return null
const n=t.owner[t.field.name]
return!Array.isArray(n)||void 0===t.index||t.index>=n.length-1?null:{group:se.Movement,icon:"material:arrow_downward",id:"moveDown",invoke:t=>t(I(e,"down")),label:g("Move down")}},function(){return null},function({owner:e}){return null},function({owner:e}){return null}]
var se
function ae(e,t){const n=d(e,t)
if(!n)return[]
const s={location:n,owner:f(e,n.path),state:e}
return ne.map((e=>e(s))).filter((e=>null!==e))}function re(e,{uuid:t}){let n=null
return{getCommands:()=>ae(e.getState(),t).map((t=>Object.assign(Object.assign({},t),{invoke:()=>t.invoke(e.dispatch,!0)}))),subscribe:t=>{n&&n(),n=e.subscribe(t)},unsubscribe:()=>{n&&n(),n=null}}}!function(e){e[e.Manipulation=0]="Manipulation",e[e.Visibility=1]="Visibility",e[e.Movement=2]="Movement",e[e.Clipboard=3]="Clipboard"}(se||(se={}))
const ie=jQuery
var le,oe=n.n(ie),ce=n(675),ue=n.n(ce)
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
function Se(e){var{children:t,className:n,outline:a,secondary:r}=e,i=(0,P._T)(e,["children","className","outline","secondary"])
return s.createElement("div",Object.assign({},i,{className:Ce()("tcfButtonFlat",n,{outline:a,secondary:r})}),t)}const _e=s.createContext({expanded:[],isExpanded:()=>!1,toggleExpanded:function(){}})
function Oe({children:e}){const[t,n]=s.useState([])
return s.createElement(_e.Provider,{value:{expanded:t,isExpanded:e=>-1!==t.indexOf(e),toggleExpanded:(e,s)=>{let a=[...t]
void 0===s&&(s=-1===t.indexOf(e)),s?a.push(e):a=a.filter((t=>t!==e)),n(a)}}},e)}function xe({children:e,disabled:t,onClick:n,primary:a,secondary:r}){return s.createElement("div",{className:Ce()("tcfButton btn",{disabled:t,submit:a,secondary:r}),onClick:e=>{e.preventDefault(),t||n(e)}},e)}function ke({className:e,params:t,value:n}){return s.createElement("span",{className:e},g(n,t))}function Ne({children:e,className:t}){return s.createElement("div",{className:Ce()("tcfWindow--content",t)},e)}function je({children:e,className:t,flex:n=!0}){return s.createElement("div",{className:Ce()("tcfWindow--footer flex-nowrap",t,{flex:n})},e)}function Me({children:e,className:t,width:n}){return s.createElement("div",{className:Ce()("tcfWindow",t),style:{width:n}},e)}!function(e){e.Content=Ne,e.Footer=je}(Me||(Me={}))
const Ie=Me
function Le({onClose:e}){return s.createElement(Ie,{width:600},s.createElement(Ie.Content,null,s.createElement(ke,{value:"Cannot create an element at the given location."})),s.createElement(Ie.Footer,null,s.createElement(xe,{onClick:e,secondary:!0},s.createElement(ke,{value:"Cancel"}))))}const $e="toolbar"
function Te({children:e,isBorderless:t,label:n,style:a}){return n&&""!==n&&n!==$e?s.createElement("div",{className:"tcfFieldGroup",style:a},s.createElement("div",{className:"tcfFieldGroup--label"},n),s.createElement("div",{className:"tcfFieldGroup--content"},e)):s.createElement("div",{className:Ce()("tcfFieldGroup--content",{isBorderless:t}),style:a},e)}function Ae({children:e,className:t,errors:n,instructions:a,isPlainField:r,isRequired:i,label:l,style:o}){if(r)return s.createElement(s.Fragment,null,e)
const c=n&&n.length
return s.createElement("div",{className:Ce()("tcfFieldPanel",t),style:o},s.createElement("div",{className:Ce()("tcfFieldPanel--label",{hasErrors:c,isRequired:i})},l),a?s.createElement("div",{className:"tcfFieldPanel--instructions"},a):null,n&&n.length?s.createElement("ul",{className:"tcfFieldPanel--errors"},n.map(((e,t)=>s.createElement("li",{className:"tcfFieldPanel--error",key:t},e)))):null,e)}function Pe(e,t){return e.label.localeCompare(t.label)}function Re({allowUndecided:e,className:t,disabled:n=!1,options:a,selectClassName:r,value:i,onChange:l}){const o=a.findIndex((e=>e.key==i)),c=e||-1===o
return s.createElement("div",{className:Ce()("tcfSelect",t)},s.createElement("select",{className:Ce()("tcfSelect--select",r),disabled:n,value:-1==o?void 0:o,onChange:n?void 0:function(t){let n=t.target.selectedIndex,s=null
c&&(n-=1),n>=0&&n<a.length&&(s=a[n].key),(null!==s||e)&&l(s)}},c?s.createElement("option",null,g("(No selection)")):null,a.map(((e,t)=>s.createElement("option",{key:t,value:t},e.indent?"--".repeat(e.indent)+" ":null,e.label)))))}const Ue=[{key:"before",label:"Before selected element"},{key:"after",label:"After selected element"}]
function Fe({Factory:e,field:t,onCreate:n,scope:a}){const[r,i]=s.useState("before")
return s.createElement(Ie,{width:600},s.createElement(Ie.Content,null,s.createElement(Te,null,s.createElement(Ae,{instructions:g("Select where the new element should be inserted."),label:g("Position")},s.createElement(Re,{onChange:i,options:Ue.map((e=>Object.assign(Object.assign({},e),{label:g(e.label)}))),value:r})))),s.createElement(Ie.Footer,{flex:!1},s.createElement(e,{field:t,onCreate:e=>n(e,r),scope:a})))}function We({afterCreate:e="expand",uuid:t}){const n=(0,l.I0)(),a=s.useContext(_e),r=(0,l.v9)((e=>{const n=d(e,t)
if(!n||!n.path.length)return null
const s=f(e,n.path)
return s&&"array"===s.field.type&&void 0!==s.index?{field:s.field,model:s.owner}:null}))
if(null===r)return s.createElement(Le,{onClose:function(){n(N(null))}})
const{field:i,model:o}=r,{factory:u}=v.getDefinition(i.member.type)
return s.createElement(Fe,{Factory:u,field:i.member,onCreate:function(s,r){let i=null
c(s)&&("expand"===e?a.toggleExpanded(s.__uuid,!0):i={type:"edit",uuid:s.__uuid}),n(function(e,t,n){return{position:n,type:"uuidInsert",uuid:e,value:t}}(t,s,r)),n(N(i))},scope:o.__type})}function De(e){const{field:t}=e,{widget:n}=v.getDefinition(t)
return s.createElement(n,e)}function Ve(e,t){if(t)switch(e){case 0:return t.small
case 2:return t.large
default:return t.medium}}const He=s.createContext(2)
function Be(e){var{children:t}=e,n=(0,P._T)(e,["children"])
const[a,r]=s.useState(2),i=s.useRef(null)
return s.useEffect((()=>{const{ResizeObserver:e}=window,{current:t}=i
let n=-1,s=0
if(!t)return
const a=()=>{const e=t.offsetWidth
e!==s&&(s=e,r(s>920?2:s>580?1:0))}
if(e){const n=new e(a)
return n.observe(t),()=>n.unobserve(t)}{const e=()=>{n=window.requestAnimationFrame(e),a()}
return e(),()=>window.cancelAnimationFrame(n)}}),[]),s.createElement("div",Object.assign({ref:i},n),s.createElement(He.Provider,{value:a},t))}function ze(e,t){return e.index-t.index}const qe=(0,l.$j)(((e,t)=>({schema:e.schemas[t.model.__type]})),((e,t)=>({onUpdate:(n,s)=>{e(T(t.path,n,s))}})))((function({disabled:e=!1,isBorderless:t,model:n,onUpdate:a,path:r,schema:i}){const l=s.useContext(He)
if(!i)return s.createElement("div",null,`Could not resolve schema for "${n.__type}"`)
const o=[],c=Object.keys(i.fields)
let u
if(0===c.length)return s.createElement("div",{className:"tcfInstanceForm--empty"},s.createElement(ke,{value:"This element has no properties."}))
for(const d of c){const c=i.fields[d],m=n.__errors[d]||null,{isAlwaysPlainField:h}=v.getDefinition(c)
if(!u||c.group){const e=c.group?c.group.label:void 0,t=c.group?Ve(l,c.group.style):void 0
u={index:e===$e?-1:o.length,label:e,fields:[],style:t},o.push(u)}u.fields.push(s.createElement(Ae,{errors:m,instructions:c.instructions,isPlainField:t||h,isRequired:c.isRequired,key:c.name,label:c.label,style:Ve(l,c.style)},s.createElement(De,{data:n[c.name],disabled:e,errors:m,field:c,model:n,onUpdate:e=>a(d,e),path:r})))}const d=o.sort(ze).map((e=>s.createElement(Te,{isBorderless:t,key:e.index,label:e.label,style:e.style},e.fields))),m=Ve(l,i.style)
return m?s.createElement("div",{className:"tcfInstanceForm",style:m},d):s.createElement(s.Fragment,null,d)}))
class Ge extends s.Component{constructor(e){super(e),this.originalModel=null,this.handleCancel=()=>{this.close()},this.handleApply=()=>{this.close()},this.originalModel=e.model}close(){this.props.setOverlay(null)}render(){const{model:e,path:t}=this.props
return s.createElement(Oe,null,s.createElement(Ie,null,s.createElement(Ie.Content,null,s.createElement(qe,{model:e,path:t})),s.createElement(Ie.Footer,null,s.createElement(xe,{onClick:this.handleApply},s.createElement(ke,{value:"Apply"})))))}}const Xe=(0,l.$j)(((e,t)=>d(e,t.uuid)),(e=>({setOverlay:t=>e(N(t))})))(Ge),Ke="craft:",Je="material:"
function Ye({className:e,name:t,size:n}){let a="craft"
return t.startsWith(Je)?(a="material",t=t.substr(Je.length)):t.startsWith(Ke)&&(t=t.substr(Ke.length)),s.createElement("div",{className:Ce()("tcfIcon",e,a,n)},t)}function Qe({message:e,onClose:t}){return s.createElement(s.Fragment,null,s.createElement(Ie.Content,null,s.createElement("div",{className:"tcfSynchronize--message"},s.createElement(Ye,{className:"tcfSynchronize--messageIcon error",name:"material:error",size:"huge"}),s.createElement("div",{className:"tcfSynchronize--title"},"An error has occured"),e?s.createElement("div",{className:"tcfSynchronize--message"},e):null)),s.createElement(Ie.Footer,null,s.createElement(xe,{onClick:t},"Close")))}function Ze({onClose:e}){return s.createElement(s.Fragment,null,s.createElement(Ie.Content,null,s.createElement("div",{className:"tcfSynchronize--message"},s.createElement(Ye,{className:"tcfSynchronize--messageIcon finished",name:"material:check_circle",size:"huge"}),s.createElement("div",{className:"tcfSynchronize--title"},s.createElement(ke,{value:"Sites have been synchronized"})),s.createElement("div",{className:"tcfSynchronize--message"},s.createElement(ke,{value:"If you are not happy with the results, do not save the entry. Reload this page to revert all changes."})))),s.createElement(Ie.Footer,null,s.createElement(xe,{onClick:e},s.createElement(ke,{value:"Close"}))))}class et extends s.Component{constructor(){super(...arguments),this.element=null,this.lightswitch=null,this.handleChange=()=>{const{disabled:e,onChange:t}=this.props,{lightswitch:n}=this
!e&&n&&t(n.on)},this.setElement=e=>{this.element!==e&&(this.element=e,this.updateInstance())}}componentDidUpdate(e){const{value:t}=this.props,{lightswitch:n}=this
e.disabled!==this.props.disabled?this.updateInstance():n&&n.on!==t&&n.toggle()}render(){const{className:e,disabled:t,small:n,value:a}=this.props
return s.createElement("div",null,s.createElement("div",{className:Ce()("lightswitch",e,{disabled:t,on:a,small:n}),ref:this.setElement,tabIndex:0},s.createElement("div",{className:"lightswitch-container"},s.createElement("div",{className:"label on"}),s.createElement("div",{className:"handle"}),s.createElement("div",{className:"label off"}))))}updateInstance(){const{element:e,handleChange:t,lightswitch:n}=this,{disabled:s,value:a}=this.props
n&&(n.destroy(),this.lightswitch=null),!s&&e&&(this.lightswitch=new Craft.LightSwitch(e,{onChange:t,value:a}))}}class tt extends s.Component{constructor(e){super(e),this.handleApply=e=>{const{currentSite:t,endpoint:n}=this.props,{arrayOrphanMode:s,site:a,useTranslator:r}=this.state
if(!a)return
let i
r&&t&&a.language!==t.language&&(i={endpoint:n,source:a.language,target:t.language}),this.props.onSynchronize({arrayOrphanMode:s,siteId:a.id,translate:i,verbose:"altKey"in e&&e.altKey})},this.handleArrayOrphanModeChange=e=>{this.setState({arrayOrphanMode:e})},this.handleSiteChange=e=>{this.setState({site:e})},this.handleToggleTranslator=e=>{this.setState({useTranslator:e})},this.state={arrayOrphanMode:"hide",site:e.availableSites[0]||null,useTranslator:!1}}render(){const{availableSites:e,currentSite:t,hasTranslator:n,onClose:a}=this.props,{arrayOrphanMode:r,site:i,useTranslator:l}=this.state,o=e.map((e=>({label:e.label,key:e})))
return s.createElement(s.Fragment,null,s.createElement(Ie.Content,null,s.createElement("div",{className:"tcfSynchronize--title"},s.createElement(ke,{value:"Synchronize translations"})),s.createElement(Te,null,s.createElement(Ae,{instructions:g("Select the site the content should be copied from."),label:g("Site")},s.createElement(Re,{onChange:this.handleSiteChange,options:o,value:i})),s.createElement(Ae,{instructions:g("Defines what happens to elements that do not exist in the selected language."),label:g("Orphaned elements")},s.createElement(Re,{onChange:this.handleArrayOrphanModeChange,options:[{key:"hide",label:g("Hide orphaned elements")},{key:"none",label:g("Do nothing")},{key:"remove",label:g("Remove orphaned elements")}],value:r})),i&&t&&i.language!==t.language?s.createElement(Ae,{instructions:g(n?"Uses a webservice to automatically translate texts.":"A matching webservice must be configured in the options of this field in order to use this feature."),label:g("Translate texts automatically")},s.createElement(et,{disabled:!n,onChange:this.handleToggleTranslator,value:l})):null)),s.createElement(Ie.Footer,null,s.createElement(xe,{onClick:a,secondary:!0},s.createElement(ke,{value:"Cancel"})),s.createElement(xe,{onClick:this.handleApply,primary:!0},s.createElement(ke,{value:"Apply"}))))}}const nt=(0,l.$j)((e=>{const{apiEndpoints:t,elementSiteId:n,hasTranslator:s,supportedSites:a}=e.config
return{availableSites:a.filter((e=>e.id!==n)),currentSite:a.find((e=>e.id===n)),endpoint:t.translate,hasTranslator:s}}),(e=>({onSynchronize:t=>e(ee(t))})))(tt)
function st(){return s.createElement("div",{className:"tcfActivityIndicator"},s.createElement("div",{className:"tcfActivityIndicator--bounce first"}),s.createElement("div",{className:"tcfActivityIndicator--bounce second"}),s.createElement("div",{className:"tcfActivityIndicator--bounce third"}))}function at(){return s.createElement(Ie.Content,null,s.createElement("div",{className:"tcfSynchronize--working"},s.createElement(st,null)))}function rt(){const e=(0,l.v9)((e=>e.sync)),t=(0,l.I0)(),n=()=>t(N(null))
let a
return a="working"===e.status?s.createElement(at,null):"error"===e.status?s.createElement(Qe,{message:e.message,onClose:n}):"finished"===e.status?s.createElement(Ze,{onClose:n}):s.createElement(nt,{onClose:n}),s.createElement(Ie,{width:600},a)}const it=s.createContext(0)
function lt({children:e}){const t=s.useContext(it)
return s.createElement(it.Provider,{value:t+1},e)}function ot({disabled:e,dispatch:t,model:n,path:a,schemas:r}){const i=s.useContext(_e),l=r.map((({qualifier:e,label:t})=>({key:e,label:t})))
return l.sort(Pe),s.createElement(Ae,{className:"tcfInstance--controlsSchema",label:"Type"},s.createElement(Re,{disabled:e,onChange:e=>t(function(e,t,n){return{expandedState:n,newType:t,path:e,type:"changeType"}}(a,e,i)),options:l,value:n?n.__type:null}))}function ct({disabled:e,dispatch:t,model:n}){const a=n.__visible?"material:visibility":"material:visibility_off",r=s.createElement(s.Fragment,null,s.createElement(ke,{value:"Visibility"}),s.createElement(Ye,{className:Ce()("tcfInstance--controlsVisibilityIcon",{off:!n.__visible}),name:a}))
return s.createElement(Ae,{label:r,className:"tcfInstance--controlsVisibility"},s.createElement(xe,{disabled:e,onClick:()=>t(L(n.__uuid))},s.createElement(ke,{value:n.__visible?"Hide":"Show"})))}const ut=s.memo((function({canChangeVisibility:e=!1,canChangeType:t=!0,disabled:n=!1,isBorderless:a,model:r,path:i,schemaNames:o}){const u=(0,l.I0)(),d=(0,l.v9)((e=>o.map((t=>e.schemas[t]))))
let m=!1
c(r)&&(m=d.some((e=>e.qualifier===r.__type)))
const h=t&&d.length>1,p=e&&m&&!r.__visible
return s.createElement(lt,null,s.createElement(Be,null,h||p?s.createElement("div",{className:"tcfInstance--controls"},h?s.createElement(ot,{disabled:n,dispatch:u,model:m?r:null,path:i,schemas:d}):null,p?s.createElement(ct,{disabled:n,dispatch:u,model:r}):null):null,m?s.createElement(qe,{disabled:n,model:r,isBorderless:a,path:i}):null))}))
class dt extends s.Component{constructor(e){super(e),this.element=null,this.handleMouseDown=e=>{const{onClick:t}=this.props
e.target===this.element&&t&&t()}
const t=document.createElement("div")
t.className="tcfOverlay",t.addEventListener("mousedown",this.handleMouseDown),document.body.appendChild(t),this.element=t}componentWillUnmount(){const{element:e}=this
e&&(document.body.removeChild(e),e.removeEventListener("mousedown",this.handleMouseDown),this.element=null)}render(){const{children:e}=this.props,{element:t}=this
return t?(0,a.createPortal)(e,t):null}}function mt(){const e=(0,l.I0)(),t=(0,l.v9)((e=>e.model)),n=(0,l.v9)((e=>e.overlay)),{disabled:a,rootSchemas:r,supportedSites:i}=(0,l.v9)((e=>e.config)),o=i.length>1
return s.createElement(be.W,{backend:Ee.PD},s.createElement(Oe,null,o&&!a?s.createElement("div",{className:"tcfRoot--options"},s.createElement(Se,{onClick:()=>{e(A({status:"idle"})),e(N({type:"synchronize"}))},outline:!0},s.createElement(Ye,{name:"material:sync"}),s.createElement(ke,{value:"Synchronize translations"}))):null,s.createElement(ut,{disabled:a,model:t,path:[],schemaNames:r}),n?s.createElement(dt,{onClick:()=>{n&&!n.preventClose&&e(N(null))}},function(e){if(!e)return null
switch(e.type){case"create":return s.createElement(We,Object.assign({},e))
case"edit":return s.createElement(Xe,Object.assign({},e))
case"synchronize":return s.createElement(rt,null)}}(n)):null))}function ht(e={config:{apiEndpoints:{anchors:"",fetchSite:"",oembed:"",translate:""},disabled:!1,elementId:null,elementSiteId:0,fieldHandle:"",hasTranslator:!1,references:[],rootSchemas:[],supportedSites:[]},model:{__errors:{},__type:"unknown",__uuid:"0",__visible:!0},overlay:null,schemas:{},sync:{status:"idle"},user:{favoriteSchemas:{}}},t){return t.type in te?te[t.type](e,t):e}function pt(e){for(;"string"!=typeof e;)e=e.toHTML()
return e}const ft={},gt={},yt=(e,t)=>{ft[String(t)]=!0},vt=(e,t)=>{gt[String(t)]=!0}
function bt(){return{allowedProtoMethods:ft,allowedProtoProperties:gt}}class Et extends Array{constructor(e){super(...function({context:e,field:t,value:n}){if(!t)return[]
const{member:s}=t,a=v.getDefinition(s)
return n.map((t=>a.preview({value:t,field:s,context:e})))}(e))}get asColumn(){return this.toList("flexColumn")}get asList(){return this.toList("")}get asRow(){return this.toList("flexRow")}get first(){return new ce.SafeString(this.length?pt(this[0]):"")}get one(){return this.first}toHTML(){return new ce.SafeString(this.toString())}toList(e){return new ce.SafeString(`<ul class="${e}">${this.map((e=>`<li>${pt(e)}</li>`)).join("")}</ul>`)}toString(){return this.map((e=>pt(e))).join("")}}(0,P.gn)([vt],Et.prototype,"asColumn",null),(0,P.gn)([vt],Et.prototype,"asList",null),(0,P.gn)([vt],Et.prototype,"asRow",null),(0,P.gn)([vt],Et.prototype,"first",null),(0,P.gn)([vt],Et.prototype,"one",null),(0,P.gn)([yt],Et.prototype,"toHTML",null),(0,P.gn)([yt],Et.prototype,"toList",null),(0,P.gn)([yt],Et.prototype,"toString",null)
var wt=n(200)
const Ct="tcf:Member"
function St(e,t){return(0,wt.c)({type:Ct,item:()=>({data:e.child,height:t.current?t.current.clientHeight:100,path:e.path}),canDrag:()=>!e.disabled,collect:e=>({isDragging:e.isDragging()}),isDragging:t=>O(e.path,t.getItem().path)})}var _t=n(240)
function Ot(e,t){const n=(0,l.oR)()
return(0,_t.L)({accept:Ct,drop:e=>({item:e}),hover:(s,a)=>{if(!a.isOver({shallow:!0}))return
const r=function(e,t,n){const{current:s}=n,a=t.getClientOffset()
if(!s||!a||!e)return null
const{bottom:r,top:i}=s.getBoundingClientRect(),l=a.y-i
return s.classList.contains("isExpanded")&&l>32&&l<r-i-32?null:(l>(r-i)/2&&(e.targetSegment=Object.assign(Object.assign({},e.targetSegment),{index:e.targetSegment.index+1})),e)}(function(e,t){const n=e.path.slice(),s=n.pop()
if(!s||"index"!==s.type)return null
const a=t.path.slice(),r=a.pop()
return r&&"index"===r.type?{sourcePath:a,sourceSegment:r,targetPath:n,targetSegment:s}:null}(e,s),a,t)
if(!r||!x(n.getState(),r))return
const i=k(r),{targetPath:l,targetSegment:o}=_(i)
s.path=[...l,o],n.dispatch(i)}})}function xt(e){const{child:t,depth:n,disabled:a,field:r,index:i,model:l,onDelete:o,onUpdate:c,path:u}=e,d=s.useRef(null),[{isDragging:m},h,p]=St(e,d),[,f]=Ot(e,d)
f(d)
return s.createElement("div",{className:Ce()(`tcfArrayWidgetMember depth-${n}`,{isDragging:m}),ref:d},p(s.createElement("div",{className:"tcfArrayWidgetMember--panel tcfArrayWidgetMember--single"},h(s.createElement("div",{className:Ce()("tcfArrayWidgetMember--singleHandle",{enabled:!a})},s.createElement(Ye,{className:"tcfArrayWidgetMember--singleHandleIcon",key:"handle",name:"move"}))),s.createElement("div",{className:"tcfArrayWidgetMember--singleBody"},s.createElement(De,{data:t,disabled:a,errors:[],field:r,model:l,onUpdate:e=>{c(i,e)},path:u})),a?null:s.createElement("div",{className:"tcfArrayWidgetMember--singleActions"},s.createElement("div",{className:"tcfArrayWidgetMember--singleActionsButton",onClick:()=>{o(i)}},s.createElement(Ye,{name:"remove"}))))))}function kt(e){const t=s.useRef(null),[,n]=function(e){const t=(0,l.oR)()
return(0,_t.L)({accept:Ct,drop:e=>({item:e}),hover:(n,s)=>{if(!s.isOver({shallow:!0}))return
const a=function(e,t){const n=t.path.slice(),s=n.pop()
return s&&"index"===s.type?{sourcePath:n,sourceSegment:s,targetPath:e.path,targetSegment:{type:"index",index:0,name:e.field.name}}:null}(e,n)
if(!a||!x(t.getState(),a))return
const r=k(a),{targetPath:i,targetSegment:l}=_(r)
n.path=[...i,l],t.dispatch(r)}})}(e)
return n(t),s.createElement("div",{className:"tcfArrayWidgetList--empty",key:"empty",ref:t},s.createElement(ke,{value:"Drop elements here"}))}class Nt extends s.Component{constructor(e){super(e),this.element=null,this.handleAnimationEnd=()=>{const{element:e}=this
e&&(e.style.height="",e.style.transition=""),this.setState({inTransition:!1,lastChildren:null,lastUri:null})},this.setElement=e=>{this.element=e},this.state={currentChildren:e.children,currentUri:e.uri,inTransition:!1,lastChildren:null,lastUri:null}}componentDidUpdate(e,t,n){const{element:s}=this
s&&n&&setTimeout((()=>{s.style.height=""
const e=s.offsetHeight
s.style.height=`${n.height}px`,s.getBoundingClientRect(),s.style.transition="height 200ms",s.style.height=`${e}px`}),0)}getSnapshotBeforeUpdate(e,t){const{element:n}=this
if(t.currentUri!==this.state.currentUri&&n){const e=n.offsetHeight
return n.style.height=`${e}px`,{height:e}}return null}render(){const{className:e,itemClassName:t}=this.props,{currentChildren:n,currentUri:a,inTransition:r,lastChildren:i,lastUri:l}=this.state,o=[]
return r&&l&&o.push(s.createElement("div",{className:Ce()(t,"tcfDetailsPanel--item","from"),key:l},i)),o.push(s.createElement("div",{className:Ce()(t,"tcfDetailsPanel--item",{to:r}),key:a,onAnimationEnd:this.handleAnimationEnd},n)),s.createElement("div",{className:Ce()(e,"tcfDetailsPanel"),ref:this.setElement},o)}static getDerivedStateFromProps(e,t){return e.uri===t.currentUri?Object.assign(Object.assign({},t),{currentChildren:e.children}):e.uri===t.currentUri||t.inTransition?null:{inTransition:!0,lastChildren:t.currentChildren,lastUri:t.currentUri,currentChildren:e.children,currentUri:e.uri}}}function jt({children:e,onClick:t,primary:n}){return s.createElement("div",{className:Ce()("tcfArrayWidgetMember--headerActionsButton",{primary:n}),onClick:e=>{e.preventDefault(),t()}},e)}let Mt=null
function It(){return null===Mt&&(Mt=new Craft.ElementThumbLoader),Mt}function Lt({className:e,model:t,schema:n,size:a="small"}){const r=s.useRef(null),i=(0,l.v9)((e=>e.config.references)),o=function(e,t){const{previewImage:n}=t
if(!n)return null
const s=n in e?e[n]:null
if(!Array.isArray(s)||0===s.length)return null
const a=s[0]
return"number"==typeof a?a:null}(t,n),c=i.find((e=>e.id===o))
return s.useEffect((()=>{if(r.current){const e=$(".element",r.current)
Craft.setElementSize(e,a),It().load(e)}}),[r.current,c]),c&&c.hasThumb?s.createElement("div",{className:Ce()("tcfInstancePreviewImage",e,a),dangerouslySetInnerHTML:{__html:c.element},ref:r}):s.createElement("div",{className:Ce()("tcfInstancePreviewImage empty",e,a)})}const $t=s.memo((function(e){var{field:t,model:n,references:a,schemas:r}=e,i=(0,P._T)(e,["field","model","references","schemas"])
const l=pt(v.getDefinition("instance").preview({context:{depth:0,references:a,schemas:r},field:t,mode:"label",value:n})).replace(/<[^>]*>?/gm,"").replace(/[\n\t\r]+/g,"").trim().substr(0,256)
return s.createElement("div",Object.assign({},i),l)}),(function(e,t){return e.model===t.model}))
function Tt(e){const{references:t,schemas:n}=(0,l.v9)((e=>({references:e.config.references,schemas:e.schemas})))
return s.createElement($t,Object.assign({},e,{references:t,schemas:n}))}function At({command:e,onClick:t}){return s.createElement("div",{className:"tcfArrayWidgetMember--headerMoreItem",onMouseUp:t},s.createElement(Ye,{className:"tcfArrayWidgetMember--headerMoreItemIcon",name:e.icon}),s.createElement("span",{className:"tcfArrayWidgetMember--headerMoreItemLabel"},e.label))}const Pt=(0,l.$j)(((e,{uuid:t})=>({commands:ae(e,t)})),(e=>({dispatch:e})))((function({commands:e,dispatch:t,onClose:n}){const a=[]
let r
for(const i of e)"edit"!==i.id&&(void 0!==r&&r!==i.group&&a.push(s.createElement("div",{className:"tcfArrayWidgetMember--headerMoreDivider",key:`${i.id}-divider`})),r=i.group,a.push(s.createElement(At,{command:i,key:i.id,onClick:()=>{n(),i.invoke(t)}})))
return s.createElement("div",{className:"tcfArrayWidgetMember--headerMoreMenu"},a)}))
class Rt extends s.Component{constructor(){super(...arguments),this.handle=null,this.handleStyle={left:"0px"},this.origin=null,this.panel=null,this.panelClassName="tcfFlyout--panel",this.panelStyle={left:"0px",top:"0px"},this.handleResize=()=>{this.update()},this.setHandle=e=>{this.handle=e,this.update()},this.setOrigin=e=>{this.origin=e,this.update()},this.setPanel=e=>{this.panel=e,this.update()}}componentDidMount(){window.addEventListener("resize",this.handleResize)}componentWillUnmount(){window.removeEventListener("resize",this.handleResize)}render(){const{children:e,onClick:t}=this.props
return s.createElement("div",{className:"tcfFlyout",ref:this.setOrigin},s.createElement(dt,{onClick:t},s.createElement("div",{className:this.panelClassName,ref:this.setPanel,style:Object.assign({},this.panelStyle)},s.createElement("div",{className:"tcfFlyout--handle",ref:this.setHandle,style:Object.assign({},this.handleStyle)}),s.createElement("div",{className:"tcfFlyout--body"},e))))}update(){const{handle:e,handleStyle:t,origin:n,panel:s,panelStyle:a}=this
if(!n||!s||!e)return
const r=n.getBoundingClientRect(),i=s.getBoundingClientRect()
let l="tcfFlyout--panel"
const o=Math.max(10,Math.min(window.innerWidth-i.width-10,r.left+.5*(r.width-i.width))),c=Math.max(10,Math.min(i.width-10,r.left+.5*r.width-o))
t.left=`${c}px`,a.left=`${o}px`,r.top+.5*r.height>.5*window.innerHeight?(l+=" above",a.top=r.top-i.height-5+"px"):(l+=" below",a.top=`${r.top+r.height+5}px`),e.style.left=t.left,s.className=this.panelClassName=l,s.style.left=a.left,s.style.top=a.top}}class Ut extends s.Component{constructor(){super(...arguments),this.state={isExpanded:!1},this.handleClose=()=>{this.setState({isExpanded:!1})},this.handleMouseDown=()=>{this.setState({isExpanded:!0})}}render(){const{uuid:e}=this.props,{isExpanded:t}=this.state
return s.createElement("div",{className:"tcfArrayWidgetMember--headerMore"},s.createElement("div",{className:"tcfArrayWidgetMember--headerMoreButton",onMouseDown:this.handleMouseDown},s.createElement(Ye,{name:"material:more_vert"})),t?s.createElement(Rt,{onClick:this.handleClose},s.createElement(Pt,{onClose:this.handleClose,uuid:e})):null)}}function Ft(e){return e}function Wt(e,t){return t?e?"minus":"plus":e?"done":"edit"}function Dt({disabled:e,dragSource:t=Ft,field:n,hasPreview:a,isCollapsible:r,isExpanded:i,model:l,onToggleExpanded:o,schema:c}){const u=[]
return c?(u.push(s.createElement(Ye,{key:"icon",name:c.icon})),c.previewImage&&u.push(s.createElement(Lt,{key:"image",model:l,schema:c})),u.push(s.createElement("div",{className:Ce()("tcfArrayWidgetMember--headerLabel",{isHidden:!l.__visible}),key:"label"},c.label)),a&&c.previewLabelTemplate&&u.push(s.createElement("div",{className:"tcfArrayWidgetMember--headerPreview",key:"preview"},s.createElement(Tt,{field:n,model:l})))):u.push(s.createElement(Ye,{className:"tcfArrayWidgetMember--headerHandleIcon",key:"handle",name:"move"})),s.createElement("div",{className:"tcfArrayWidgetMember--header"},t(s.createElement("div",{className:Ce()("tcfArrayWidgetMember--headerHandle",{enabled:!e}),onClick:o},u)),l.__visible?null:s.createElement(Ye,{className:"tcfArrayWidgetMember--headerVisibility",name:"material:visibility_off"}),s.createElement("div",{className:"tcfArrayWidgetMember--headerActions"},r?s.createElement(jt,{onClick:o,primary:!e},s.createElement(Ye,{name:Wt(i,e)})):null,e?null:s.createElement(Ut,{uuid:l.__uuid})))}const Vt=s.memo((function({field:e,model:t,mode:n="default",references:a,schemas:r}){const i=v.getDefinition("instance").preview({context:{depth:0,references:a,schemas:r},field:e,mode:n,value:t})
try{const e={__html:pt(i)}
return s.createElement("div",{className:Ce()("tcfInstancePreview--content",n),dangerouslySetInnerHTML:e})}catch(e){return s.createElement(s.Fragment,null,s.createElement("p",null,s.createElement("span",{className:"tcfIcon material"},"error"),s.createElement("span",null,"Could not render preview.")),e&&"object"==typeof e&&"message"in e?s.createElement("pre",null,e.message):null)}}),(function(e,t){return e.model===t.model}))
function Ht({className:e,field:t,model:n,mode:a,onClick:r}){const{references:i,schemas:o}=(0,l.v9)((e=>({references:e.config.references,schemas:e.schemas})))
return s.createElement("div",{className:Ce()("tcfInstancePreview",e,{isClickable:!!r}),onClick:r},s.createElement(Vt,{field:t,model:n,mode:a,references:i,schemas:o}))}function Bt(e){const{isExpanded:t,toggleExpanded:n}=s.useContext(_e),a=s.useRef(null),[{isDragging:r},i,l]=St(e,a),[,o]=Ot(e,a)
o(a)
const{child:c,depth:u,disabled:d,field:m,isCollapsible:h,path:p,previewMode:f,schema:g}=e,y=()=>{n(c.__uuid)}
let v=!0,b=!1
if(g){const e=Object.keys(g.fields)
v=e.length>0,b=1===e.length&&"redactor"===g.fields[e[0]].type}const E=g&&g.preview&&function(e,t){switch(e){case"always":return!0
case"root":return 1===t}}(f,u),w=v&&(!h||t(c.__uuid))
let C
return w?C=s.createElement("div",{className:"tcfArrayWidgetMember--body"},s.createElement(ut,{canChangeType:!1,disabled:d,isBorderless:b,key:"details",model:c,path:p,schemaNames:m.schemas})):E&&(C=s.createElement(Ht,{className:"tcfArrayWidgetMember--preview",field:m,key:"summary",model:c,onClick:v?y:void 0})),s.createElement("div",{className:Ce()(`tcfArrayWidgetMember depth-${u}`,w?"isExpanded":"isCollapsed",{isDragging:r}),ref:a},l(s.createElement("div",{className:"tcfArrayWidgetMember--panel"},s.createElement(Dt,{disabled:d,dragSource:i,field:m,hasPreview:!w&&!E,isCollapsible:v&&h,isExpanded:w,model:c,onToggleExpanded:y,schema:g}),s.createElement(Nt,{uri:w?"details":"summary"},C))))}function zt({children:e,data:t,disabled:n,field:a,model:r,onDelete:i,onUpdate:o,path:c}){const{member:u,collapsible:d,previewMode:m}=a,h=s.useRef(null),p=(0,l.v9)((e=>e.schemas)),f=s.useContext(it),g=t.map(((e,t)=>{const a=[...c,{index:t,name:u.name,type:"index"}],l={child:e,depth:f,disabled:n,path:a}
return"instance"===u.type?s.createElement(Bt,Object.assign({},l,{isCollapsible:d,field:u,key:e.__uuid,previewMode:m,schema:p[e.__type]})):s.createElement(xt,Object.assign({},l,{field:u,index:t,key:pe(e)?e.__uuid:t,model:r,onDelete:i,onUpdate:o}))}))
return 0===g.length&&g.push(s.createElement(kt,{field:a,key:"droplet",path:c})),s.createElement(s.Fragment,null,s.createElement("div",{className:"tcfArrayWidgetList",ref:h},g),s.createElement("div",{className:"tcfArrayWidgetList--footer"},e))}class qt extends s.Component{constructor(){super(...arguments),this.handleAdd=e=>{const{context:t}=this,{data:n,disabled:s,onUpdate:a}=this.props
if(s)return
const r=Array.isArray(n)?n.slice():[]
r.push(fe(e)),a(r),c(e)&&t&&t.toggleExpanded(e.__uuid,!0)},this.handleDelete=e=>{const{data:t,disabled:n,onUpdate:s}=this.props
if(n||!Array.isArray(t))return
const a=t.slice()
a.splice(e,1),s(a)},this.handleUpdate=(e,t)=>{const{data:n,disabled:s,onUpdate:a}=this.props
if(s||!Array.isArray(n))return
const r=n.slice()
r[e]=fe(t,r[e]),a(r)}}render(){const{data:e,disabled:t,field:n,model:a,path:r}=this.props,{limit:i}=n
if(!n.member)return null
const l=Array.isArray(e)?e:[],o=i>0&&l.length>=i,c=v.getDefinition(n.member)
let u
return t||!c||o||(u=s.createElement(c.factory,{field:n.member,onCreate:this.handleAdd,scope:a.__type})),s.createElement(zt,{data:l,disabled:t,field:n,limit:i,model:a,onDelete:this.handleDelete,onUpdate:this.handleUpdate,path:r},u)}}function Gt(e){if(!e)return e
if(Array.isArray(e))return e.map((e=>Gt(e)))
if("object"==typeof e){const t={}
for(const n in e)t[n]=Gt(e[n])
return t}return e}function Xt({field:e,onCreate:t}){const n=(0,l.v9)((e=>e.schemas))
return s.createElement("div",{className:"tcfFactory"},s.createElement(Se,{className:"tcfFactory--primaryButton",onClick:()=>{const s=v.createValue({field:e,schemas:n})
t(s)},secondary:!0},s.createElement(Ye,{name:"plus"}),s.createElement(ke,{value:"Create"})))}qt.contextType=_e
class Kt{constructor({factory:e,widget:t}){this.factory=e||Xt,this.widget=t}cloneValue(e){return(0,P.mG)(this,void 0,void 0,(function*(){const{field:t,value:n}=e
return this.isValue(t,n)?Gt(n):this.createValue(e)}))}}class Jt extends Kt{createValue(e){return!!e.field.defaultValue}isValue(e,t){return"boolean"==typeof t||t instanceof Boolean}preview({value:e}){return e}}class Yt extends s.Component{constructor(){super(...arguments),this.id=b()}render(){const{id:e}=this,{className:t,children:n,disabled:a,onChange:r,value:i}=this.props
return s.createElement("dl",{className:Ce()("tcfCheckbox",t)},s.createElement("dd",{className:"tcfCheckbox--input"},s.createElement("input",{checked:i,disabled:a,id:e,onChange:a?void 0:()=>r(!i),type:"checkbox"})),s.createElement("dt",{className:"tcfCheckbox--label"},s.createElement("label",{htmlFor:e},n)))}}function Qt({data:e,disabled:t,field:n,onUpdate:a}){return s.createElement(Yt,{disabled:t,onChange:a,value:!!e},n.label)}function Zt({red:e,green:t,blue:n,alpha:s}){return{max:Math.max(e,t,n),min:Math.min(e,t,n),red:e/255,green:t/255,blue:n/255,alpha:s}}function en(e){return"object"==typeof e&&"number"==typeof e.alpha&&"number"==typeof e.blue&&"number"==typeof e.green&&"number"==typeof e.red}function tn(e){e=e.replace(/^#?([a-f\d])([a-f\d])([a-f\d])$/i,(function(e,t,n,s){return t+t+n+n+s+s}))
const t=/^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(e)
return t?{red:parseInt(t[1],16),green:parseInt(t[2],16),blue:parseInt(t[3],16),alpha:1}:null}function nn(e){return`rgba(${e.red},${e.green},${e.blue},${e.alpha})`}function sn(e){const{alpha:t,blue:n,green:s,max:a,min:r,red:i}=Zt(e),l=0===a?0:(a-r)/a,o=(a-r)/255
let c=0,u=a/255
return a===r||(c=a===e.red?(s-n)/o+(s<n?6:0):a===e.green?(n-i)/o+2:(i-s)/o+4,c/=6),{hue:c,saturation:l,value:u,alpha:t}}const an=s.createContext({css:"#000",hsv:{hue:0,saturation:0,value:0,alpha:0},rgb:{red:0,green:0,blue:0,alpha:0},onHsvColor:e=>{},onRgbColor:e=>{}})
function rn(e){return function(t){return s.createElement(an.Consumer,null,(n=>s.createElement(e,Object.assign({},t,n))))}}class ln extends s.Component{constructor(e){super(e),this.timeout=null,this.commit=()=>{null!==this.timeout&&window.clearTimeout(this.timeout),this.timeout=window.setTimeout(this.handleTimeout,250)},this.handleHsvColor=e=>{const t=function({alpha:e,hue:t,saturation:n,value:s}){let a=0,r=0,i=0
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
return e?t.defaultValue=this.getValue():t.value=this.getValue(),s.createElement(on,t)}}const un=rn(cn)
class dn extends s.Component{constructor(){super(...arguments),this.element=null,this.state={initialHue:0,isMouseDown:!1,mouseX:0,mouseY:0},this.handleMouseDown=e=>{const{hsv:t}=this.props
window.addEventListener("mousemove",this.handleMouseMove),window.addEventListener("mouseup",this.handleMouseUp),this.setState(Object.assign(Object.assign({},this.update(e.clientX,e.clientY,t.hue)),{initialHue:t.hue,isMouseDown:!0}))},this.handleMouseMove=e=>{this.setState(this.update(e.clientX,e.clientY))},this.handleMouseUp=e=>{this.stopListening(),this.setState(Object.assign(Object.assign({},this.update(e.clientX,e.clientY)),{isMouseDown:!1}))},this.setElement=e=>{this.element=e}}componentWillUnmount(){this.stopListening()}render(){const{hsv:e}=this.props,{initialHue:t,isMouseDown:n,mouseX:a,mouseY:r}=this.state
return s.createElement("div",{className:"tcfColorInputSaturation",onMouseDown:this.handleMouseDown,ref:this.setElement,style:{background:`hsl(${360*(n?t:e.hue)}, 100%, 50%)`}},s.createElement("div",{className:"tcfColorInputSaturation--value",style:{left:100*(n?a:e.saturation)+"%",top:100*(n?r:1-e.value)+"%"}}))}stopListening(){window.removeEventListener("mousemove",this.handleMouseMove),window.removeEventListener("mouseup",this.handleMouseUp)}update(e,t,n=this.state.initialHue){const{element:s}=this
if(!s)return{mouseX:this.state.mouseX,mouseY:this.state.mouseY}
const{hsv:a,onHsvColor:r}=this.props,i=s.getBoundingClientRect(),l=Math.max(0,Math.min(1,(e-i.left)/i.width)),o=Math.max(0,Math.min(1,(t-i.top)/i.height))
return r({alpha:a.alpha,hue:n,saturation:l,value:1-o}),{mouseX:l,mouseY:o}}}const mn=rn(dn)
class hn extends s.Component{constructor(){super(...arguments),this.element=null,this.handleMouseDown=e=>{window.addEventListener("mousemove",this.handleMouseMove),window.addEventListener("mouseup",this.handleMouseUp),this.update(e.clientX)},this.handleMouseMove=e=>{this.update(e.clientX)},this.handleMouseUp=e=>{this.stopListening(),this.update(e.clientX)},this.setElement=e=>{this.element=e}}componentWillUnmount(){this.stopListening()}render(){const{rgb:e,hsv:t,type:n}=this.props,a=t[n]
let r
if("alpha"===n){const{red:t,green:n,blue:a}=e,i=`rgba(${t}, ${n}, ${a}, 0)`,l=`rgba(${t}, ${n}, ${a}, 1)`
r=s.createElement("div",{className:"tcfColorInputSlider--gradient",style:{background:`linear-gradient(to right, ${i}, ${l})`}})}return s.createElement("div",{className:`tcfColorInputSlider ${n}`,onMouseDown:this.handleMouseDown},r,s.createElement("div",{className:"tcfColorInputSlider--track",ref:this.setElement},s.createElement("div",{className:"tcfColorInputSlider--handle",style:{left:100*a+"%"}})))}stopListening(){window.removeEventListener("mousemove",this.handleMouseMove),window.removeEventListener("mouseup",this.handleMouseUp)}update(e){const{element:t}=this
if(!t)return
const{hsv:n,onHsvColor:s,type:a}=this.props,r=t.getBoundingClientRect(),i=Math.max(0,Math.min(1,(e-r.left)/r.width))
s(Object.assign(Object.assign({},n),{[a]:i}))}}const pn=rn(hn)
const fn=rn((function({children:e,className:t,color:n,css:a,disabled:r,onClick:i,onRgbColor:l}){if(n){const e=tn(n)
e&&(i=function(){l(e)})}return s.createElement("div",{className:Ce()("tcfColorInputSwatch",t),onClick:r?void 0:i},s.createElement("div",{className:"tcfColorInputSwatch--color",style:{background:n||a}}),e)}))
function gn({disableAlpha:e,presetColors:t}){const n=[s.createElement("div",{className:"tcfColorInputPicker--value wide",key:"hex"},s.createElement(un,{type:"hex"}),s.createElement("div",{className:"tcfColorInputPicker--valueCaption"},"Hex")),s.createElement("div",{className:"tcfColorInputPicker--value",key:"red"},s.createElement(un,{type:"red"}),s.createElement("div",{className:"tcfColorInputPicker--valueCaption"},"R")),s.createElement("div",{className:"tcfColorInputPicker--value",key:"green"},s.createElement(un,{type:"green"}),s.createElement("div",{className:"tcfColorInputPicker--valueCaption"},"G")),s.createElement("div",{className:"tcfColorInputPicker--value",key:"blue"},s.createElement(un,{type:"blue"}),s.createElement("div",{className:"tcfColorInputPicker--valueCaption"},"B"))]
e||n.push(s.createElement("div",{className:"tcfColorInputPicker--value",key:"alpha"},s.createElement(un,{type:"alpha"}),s.createElement("div",{className:"tcfColorInputPicker--valueCaption"},"A")))
let a=null
return t&&t.length&&(a=s.createElement("div",{className:"tcfColorInputPicker--presets"},t.map((e=>s.createElement(fn,{className:"tcfColorInputPicker--presetsSwatch",color:e}))))),s.createElement("div",{className:"tcfColorInputPicker"},s.createElement(mn,null),s.createElement("div",{className:"tcfColorInputPicker--controls"},s.createElement("div",{className:"tcfColorInputPicker--sliders"},s.createElement(pn,{type:"hue"}),e?null:s.createElement(pn,{type:"alpha"})),s.createElement(fn,{className:"tcfColorInputPicker--swatch"})),s.createElement("div",{className:"tcfColorInputPicker--values"},n),a)}class yn extends s.Component{constructor(){super(...arguments),this.state={hasColorPicker:!1},this.handleChange=e=>{this.props.onChange(e)},this.handleSwatchClick=()=>{this.setState({hasColorPicker:!0})},this.handleOverlayClick=()=>{this.setState({hasColorPicker:!1})}}render(){const{hasColorPicker:e}=this.state,{color:t,disableAlpha:n,disabled:a,onChange:r,presetColors:i}=this.props
return s.createElement(ln,{color:t,onChange:r},s.createElement("div",{className:"tcfColorInput"},s.createElement(fn,{className:"tcfColorInput--swatch",disabled:a,onClick:this.handleSwatchClick},e&&!a?s.createElement(Rt,{onClick:this.handleOverlayClick},s.createElement(gn,{disableAlpha:n,presetColors:i})):null),s.createElement(un,{type:"hex"})))}}function vn({data:e,disabled:t,field:n,onUpdate:a}){const r=en(e)?e:{alpha:1,blue:255,green:255,red:255}
return s.createElement(yn,{color:r,disableAlpha:!n.alpha,disabled:t,onChange:a,presetColors:n.swatches})}function bn({children:e,className:t,icon:n}){return s.createElement("div",{className:Ce()("tcfTextAndIcon",t)},s.createElement(Ye,{className:"tcfTextAndIcon--icon",name:n}),s.createElement(ke,{className:"tcfTextAndIcon--text",value:e}))}function En({children:e,title:t}){return s.createElement("div",{className:"tcfErrorMessage"},s.createElement(bn,{icon:"material:error"},t),e)}function wn(e){return"object"==typeof e&&"string"==typeof e.url}class Cn extends s.Component{constructor(){super(...arguments),this.request=null,this.state={mode:"idle"},this.handleChange=e=>{this.updateOEmbed(),this.setState({mode:"typing"}),this.props.onUpdate(Object.assign(Object.assign({},this.getOEmbed()),{url:e.target.value}))},this.updateOEmbed=function(e,t,n){let s,a,r=null,i=null,l=null
function o(){const c=Date.now()-s
c<t&&c>=0?r=window.setTimeout(o,t-c):(r=null,n||(a=e.apply(l,i),r||(l=i=null)))}return function(){l=this,i=arguments,s=Date.now()
const c=n&&!r
return r||(r=window.setTimeout(o,t)),c&&(a=e.apply(l,i),l=i=null),a}}((()=>{this.setState({mode:"loading"})
const{apiEndpoint:e,model:t,field:n}=this.props,s=[`schema=${encodeURIComponent(t.__type)}`,`field=${encodeURIComponent(n.name)}`,`url=${encodeURIComponent(this.getOEmbed().url)}`],a=new XMLHttpRequest
a.onreadystatechange=()=>this.handleRequestStateChange(a),a.onerror=()=>this.handleRequestError(),a.open("GET",`${e}&${s.join("&")}`),a.send(),this.request&&this.request.abort(),this.request=a}),500)}getOEmbed(){const{data:e}=this.props
return wn(e)?e:{url:""}}handleRequestStateChange(e){if(e.readyState!==XMLHttpRequest.DONE)return
if(200!==e.status)return this.handleRequestError()
let t
try{t=JSON.parse(e.responseText)}catch(e){return this.handleRequestError()}this.setState({mode:"idle"}),this.request=null,this.props.onUpdate(Object.assign(Object.assign({},this.getOEmbed()),{info:t.data}))}handleRequestError(){this.setState({mode:"idle"}),this.request=null,this.props.onUpdate(Object.assign(Object.assign({},this.getOEmbed()),{info:null}))}render(){const e=this.getOEmbed(),{disabled:t}=this.props,{mode:n}=this.state
let a
if("typing"===n||"loading"===n)a=s.createElement("div",{className:"tcfOEmbedWidget--activity"},s.createElement("div",{className:"tcfOEmbedWidget--activityBounce first"}),s.createElement("div",{className:"tcfOEmbedWidget--activityBounce second"}),s.createElement("div",{className:"tcfOEmbedWidget--activityBounce third"}))
else if(e.info){const{title:t,author_name:n,thumbnail_url:r}=e.info
a=s.createElement("div",{className:"tcfOEmbedWidget--info"},r?s.createElement("img",{className:"tcfOEmbedWidget--infoImage",src:r}):null,s.createElement("div",{className:"tcfOEmbedWidget--infoContent"},s.createElement("div",{className:"tcfOEmbedWidget--infoTitle"},t),s.createElement("div",{className:"tcfOEmbedWidget--infoAuthor"},n)))}else a=s.createElement(En,{title:"Invalid embed url"})
return s.createElement("div",{className:"tcfOEmbedWidget"},s.createElement("div",{className:"tcfOEmbedWidget--input"},s.createElement("input",{autoComplete:"off",className:"text fullwidth",disabled:t,onChange:t?void 0:this.handleChange,value:e.url})),a)}}const Sn=(0,l.$j)((e=>({apiEndpoint:e.config.apiEndpoints.oembed})))(Cn)
class _n{constructor(e){this.value=e}get author(){return this.value.info?this.value.info.author_name:""}get thumbnail(){const{info:e}=this.value
return e&&e.thumbnail_url?new ce.SafeString(`<img width="100" src=${e.thumbnail_url} />`):""}get title(){return this.value.info?this.value.info.title:""}toHTML(){const{info:e}=this.value
if(!e)return new ce.SafeString("")
let t=""
return e.thumbnail_url&&(t=`<img class="tcfOEmbedWidget--infoImage" src="${e.thumbnail_url}" />`),new ce.SafeString(`\n      <div class="tcfOEmbedWidget--info">\n        ${t}\n        <div class="tcfOEmbedWidget--infoContent">\n          <div class="tcfOEmbedWidget--infoTitle">${e.title}</div>\n          <div class="tcfOEmbedWidget--infoAuthor">${e.author_name}</div>\n        </div>\n      </div>\n    `)}}(0,P.gn)([vt],_n.prototype,"value",void 0),(0,P.gn)([vt],_n.prototype,"author",null),(0,P.gn)([vt],_n.prototype,"thumbnail",null),(0,P.gn)([vt],_n.prototype,"title",null),(0,P.gn)([yt],_n.prototype,"toHTML",null)
function On({favorites:e,onSchema:t,onToggleFavorite:n,schemas:a}){const r=a.map((a=>{const r=-1!==e.indexOf(a.qualifier)
return s.createElement("div",{className:"tcfSchemaList--row",key:a.qualifier},s.createElement("div",{className:"tcfSchemaList--schema",onMouseUp:()=>t(a)},s.createElement(Ye,{className:"tcfSchemaList--schemaIcon",name:a.icon}),s.createElement("div",{className:"tcfSchemaList--schemaLabel"},a.label)),n?s.createElement("div",{className:"tcfSchemaList-favorite",onClick:()=>n(a)},s.createElement(Ye,{name:r?"material:star":"material:star_border"})):null)}))
return s.createElement("div",{className:"tcfSchemaList"},r)}function xn({onCreate:e,schemas:t,scope:n}){const[a,r]=s.useState(!1),i=(0,l.I0)()
let o,c=[],u=null
if(n){const{favoriteSchemas:a}=(0,l.v9)((e=>e.user))
c=n in a?a[n]:[],c.length&&(u=t.filter((e=>-1!==c.indexOf(e.qualifier))).map((t=>s.createElement(Se,{className:"tcfFactory--quickButton",key:t.qualifier,onClick:()=>e(t),secondary:!0},s.createElement(Ye,{name:t.icon}),s.createElement("div",null,t.label))))),o=e=>{i(function(e,t){return(n,s)=>{const{favoriteSchemas:a}=s().user
let r=e in a?a[e]:[]
r=-1===r.indexOf(t)?[...r,t]:r.filter((e=>e!==t)),n({type:"setUser",user:{favoriteSchemas:Object.assign(Object.assign({},a),{[e]:r})}})}}(n,e.qualifier))}}return s.createElement("div",{className:"tcfFactory multiple"},s.createElement(Se,{className:"tcfFactory--primaryButton",onMouseDown:()=>r(!0)},s.createElement(Ye,{name:"plus"}),s.createElement(ke,{value:"Create"}),a?s.createElement(Rt,{onClick:()=>r(!1)},s.createElement(On,{favorites:c,onSchema:t=>{r(!1),e(t)},onToggleFavorite:o,schemas:t})):null),u)}function kn({onCreate:e,schema:t}){return s.createElement("div",{className:"tcfFactory"},s.createElement(Se,{className:"tcfFactory--primaryButton",onClick:()=>e(t)},s.createElement(Ye,{name:"plus"}),s.createElement(ke,{params:{schema:t.label},value:"Create {schema}"})))}function Nn({field:e,onCreate:t,scope:n}){const a=(0,l.v9)((e=>e.schemas)),r=e.schemas.map((e=>a[e])).sort(((e,t)=>e.label.localeCompare(t.label)))
if(!r.length)return null
const i=e=>{if(-1!==r.indexOf(e))return t(E({schemas:a,schema:e}))}
return r.length>1?s.createElement(xn,{onCreate:i,schemas:r,scope:n}):s.createElement(kn,{onCreate:i,schema:r[0]})}function jn({children:e,disabled:t,field:n,model:a}){const r=s.useContext(it),i=(0,l.v9)((e=>e.schemas)),{isExpanded:o,toggleExpanded:c}=s.useContext(_e),u=i[a.__type],d=o(a.__uuid),m=u&&u.preview,h=()=>c(a.__uuid)
let p=null
return d?p=s.createElement("div",{className:"tcfArrayWidgetMember--body"},e):m&&(p=s.createElement(Ht,{field:n,model:a,onClick:h})),s.createElement("div",{className:`tcfInstanceWidget--collapsiblePanel depth-${r}`},s.createElement(Dt,{disabled:t,field:n,hasPreview:!d&&!m,isCollapsible:!0,isExpanded:d,model:a,onToggleExpanded:h,schema:u}),s.createElement(Nt,{uri:d?"details":"summary"},p))}function Mn({className:e,data:t,disabled:n,field:a,path:r}){const i=s.createElement(ut,{canChangeVisibility:!0,disabled:n,model:t,path:[...r,{type:"property",name:a.name}],schemaNames:a.schemas})
return a.collapsible&&c(t)?s.createElement(jn,{model:t,disabled:n,field:a},i):s.createElement("div",{className:Ce()("tcfInstanceWidget",e)},i)}function In(e){var{attribute:t,column:n,max:a,min:r,onUpdate:i}=e,l=(0,P._T)(e,["attribute","column","max","min","onUpdate"])
const[o,c]=s.useState(null),u=n[t],d=X(u,l),m=l.current.key in u
return s.createElement("div",{className:"tcfLayoutEditor--columnInput"},s.createElement("div",{className:Ce()("tcfLayoutEditor--columnInputLabel",{hasOwnValue:m})},(h=t).charAt(0).toUpperCase()+h.slice(1)),s.createElement(on,{className:"tcfLayoutEditor--columnInputField",max:a,min:r,onBlur:()=>c(null),onChange:function({target:e}){c(e.value)
const s=parseInt(e.value)
!isFinite(s)||"number"==typeof r&&s<r||"number"==typeof a&&s>a||i(n.__uuid,{[t]:J(u,s,l)})},type:"number",value:null===o?d:o}))
var h}function Ln(e,t=0,n=1){return e<t?t:e>n?n:e}function $n({columnsPerRow:e}){const t=[]
for(let n=0;n<e;n++)t.push(s.createElement("div",{className:"tcfLayoutPreview--gridColumn",key:n}))
return s.createElement("div",{className:"tcfLayoutPreview--grid"},t)}function Tn(e){const t=String.fromCharCode(65+e%25),n=Math.floor(e/25)
return g("Column {num}",{num:`${t}${n>1?n:""}`})}function An(e){var{columns:t,columnsPerRow:n,isSelected:a,onClick:r}=e,i=(0,P._T)(e,["columns","columnsPerRow","isSelected","onClick"])
return s.createElement("div",{className:Ce()("tcfLayoutPreview",{isClickable:!!r,isSelected:a}),onClick:r},s.createElement($n,{columnsPerRow:n}),t.map(((e,t)=>{const a=X(e.offset,i),r=X(e.order,i),l=X(e.width,i)
return s.createElement("div",{className:"tcfLayoutPreview--col",key:t,style:{marginLeft:`${(a/n*100).toFixed(6)}%`,order:r,width:`${(l/n*100).toFixed(6)}%`}},s.createElement("div",{className:"tcfLayoutPreview--colPanel"},Tn(t)))})))}class Pn extends s.Component{constructor(){super(...arguments),this.element=null,this.initialHandle=!1,this.initialPosition=0,this.isListening=!1,this.state={dragDelta:0,dragMode:"none"},this.handleMouseDown=e=>{this.initialHandle=!1,this.initialPosition=e.clientX,this.startListening()
let t=e.target
for(;t;){if(t.classList.contains("tcfLayoutRowEditor--colHandle")){this.initialHandle=!0
break}t=t.parentElement}},this.handleMouseMove=e=>{const{dragMode:t}=this.state,n=e.clientX-this.initialPosition
"none"===t&&Math.abs(n)>3&&(this.initialPosition=e.clientX,this.setState({dragDelta:0,dragMode:this.initialHandle?"size":"move"})),"none"!==t&&this.setState({dragDelta:n,dragMode:t})},this.handleMouseUp=()=>{const{column:e,onSelect:t}=this.props,{dragDelta:n,dragMode:s}=this.state,a=this.toColumns(n)
"size"===s?this.applySize(a):"move"===s?this.applyMove(a):t(e.__uuid),this.stopListening(),this.setState({dragDelta:0,dragMode:"none"})},this.setElement=e=>{this.element=e}}applyMove(e){const{props:t}=this,{column:n,columnsPerRow:s,onUpdate:a}=t,r=Ln(this.sample(n.offset)+e,0,s)
a(n.__uuid,{offset:J(n.offset,r,t)})}applySize(e){const{props:t}=this,{column:n,constraints:{maxColumnWidth:s,minColumnWidth:a},onUpdate:r}=t,i=Ln(this.sample(n.width)+e,a,s)
r(n.__uuid,{width:J(n.width,i,t)})}componentWillUnmount(){this.stopListening()}render(){const{dragDelta:e,dragMode:t}=this.state,{column:n,columnsPerRow:a,index:r,isSelected:i}=this.props,l=this.sample(n.offset),o=this.sample(n.width),c=this.sample(n.order)
let u=`${(o/a*100).toFixed(6)}%`,d=`${(l/a*100).toFixed(6)}%`
return"move"===t?d=`calc(${d} + ${e}px)`:"size"===t&&(u=`calc(${u} + ${e}px)`),s.createElement("div",{className:Ce()("tcfLayoutRowEditor--col",{isSelected:i}),onMouseDown:this.handleMouseDown,ref:this.setElement,style:{marginLeft:d,order:c,width:u}},s.createElement("div",{className:"tcfLayoutRowEditor--colPanel"},s.createElement("div",{className:"tcfLayoutRowEditor--colLabel"},Tn(r)),s.createElement("div",{className:"tcfLayoutRowEditor--colHandle"})))}sample(e){return X(e,this.props)}startListening(){this.isListening||(this.isListening=!0,document.addEventListener("mousemove",this.handleMouseMove),document.addEventListener("mouseup",this.handleMouseUp))}stopListening(){this.isListening=!1,document.removeEventListener("mousemove",this.handleMouseMove),document.removeEventListener("mouseup",this.handleMouseUp)}toColumns(e){const{element:t}=this,{columnsPerRow:n}=this.props,s=t?t.parentElement:null
if(!s)return 0
const a=s.offsetWidth/n
return Math.round(e/a)}}function Rn(e){var{columns:t,selected:n}=e,a=(0,P._T)(e,["columns","selected"])
const{columnsPerRow:r}=a
return s.createElement("div",{className:"tcfLayoutRowEditor"},s.createElement($n,{columnsPerRow:r}),t.map(((e,t)=>s.createElement(Pn,Object.assign({},a,{column:e,index:t,isSelected:null!==n&&n.__uuid===e.__uuid,key:e.__uuid})))))}const Un={xs:"material:smartphone",sm:"material:tablet_mac",md:"material:tablet",lg:"material:laptop",xl:"material:desktop_mac"}
function Fn(e){const{columnsPerRow:t,constraints:n,current:a,selected:r}=e
let i
if(r){const a={breakpoints:e.breakpoints,column:r,current:e.current,onUpdate:e.onUpdate}
i=s.createElement("div",{className:"tcfLayoutEditor--rowAttributes"},s.createElement(In,Object.assign({},a,{attribute:"width",max:Math.min(t,n.maxColumnWidth),min:Math.max(1,n.minColumnWidth)})),s.createElement(In,Object.assign({},a,{attribute:"offset",min:0,max:t})),s.createElement(In,Object.assign({},a,{attribute:"order"})))}else i=s.createElement("div",{className:"tcfLayoutEditor--rowAttributes"})
return s.createElement("div",{className:"tcfLayoutEditor--row"},s.createElement("div",{className:"tcfLayoutEditor--rowHead"},a.key in Un?s.createElement(Ye,{name:Un[a.key]}):null,s.createElement("span",null,a.label)),s.createElement("div",{className:"tcfLayoutEditor--rowBody"},s.createElement(Rn,Object.assign({},e)),i))}function Wn(e){var{onClose:t,onCreate:n,onDelete:a}=e,r=(0,P._T)(e,["onClose","onCreate","onDelete"])
const{breakpoints:i,columns:l,constraints:{maxColumns:o,minColumns:c}}=r,[u,d]=s.useState(l.length?l[0].__uuid:null),m=u&&l.find((e=>e.__uuid===u))||null
function h(e){d(e===u?null:e)}return s.createElement(Ie,null,s.createElement(Ie.Content,null,s.createElement("div",{className:"tcfLayoutEditor--title"},s.createElement(ke,{value:"Edit columns"})),i.map((e=>s.createElement(Fn,Object.assign({},r,{current:e,key:e.key,selected:m,onSelect:h}))))),s.createElement(Ie.Footer,null,s.createElement("div",{className:"btngroup"},l.length<o?s.createElement(xe,{onClick:()=>d(n())},s.createElement(Ye,{name:"plus"}),s.createElement(ke,{value:"Create"})):null,m&&l.length>c?s.createElement(xe,{onClick:()=>a(m.__uuid)},s.createElement(Ye,{name:"minus"}),s.createElement(ke,{value:"Delete"})):null),s.createElement(xe,{onClick:t,primary:!0},s.createElement(ke,{value:"Close"}))))}function Dn(e){var{onClose:t,onPreset:n,preset:a,presets:r}=e,i=(0,P._T)(e,["onClose","onPreset","preset","presets"])
return s.createElement(Rt,{onClick:t},s.createElement("div",{className:"tcfLayoutSelect--flyout"},r.map((e=>s.createElement(An,Object.assign({},i,{columns:e.columns,isSelected:e.key===a,key:e.key,onClick:()=>n(e)}))))))}function Vn(e){var{canEdit:t,onPreset:n,preset:a,presets:r}=e,i=(0,P._T)(e,["canEdit","onPreset","preset","presets"])
const{breakpoints:l,columns:o,columnsPerRow:c}=i,[u,d]=s.useState(null),m=l[l.length-1]
function h(){d(null)}let p=null
return r.length?p="flyout":t&&(p="editor"),s.createElement("div",{className:"tcfLayoutSelect"},s.createElement("div",{className:"tcfLayoutSelect--widget"},s.createElement(An,{breakpoints:l,columns:o,columnsPerRow:c,current:m,onClick:p?()=>d(p):void 0}),"flyout"===u?s.createElement(Dn,{breakpoints:i.breakpoints,columnsPerRow:i.columnsPerRow,current:m,onClose:h,onPreset:function(e){n(e),d(null)},preset:a,presets:r}):null),t?s.createElement("div",{className:"tcfLayoutSelect--edit",onClick:()=>d("editor")},s.createElement(Ye,{name:"material:edit"})):null,"editor"===u?s.createElement(dt,{onClick:h},s.createElement(Wn,Object.assign({},i,{onClose:h}))):null)}class Hn extends s.Component{constructor(){super(...arguments),this.handleCreate=()=>{const{data:e,disabled:t,field:n,onUpdate:s}=this.props
if(!Y(e)||t||e.columns.length>=n.constraints.maxColumns)return null
const a=this.createColumn()
return s(Object.assign(Object.assign({},e),{columns:[...e.columns,a]})),a.__uuid},this.handleDelete=e=>{const{data:t,disabled:n,field:s,onUpdate:a}=this.props
!Y(t)||n||t.columns.length<=s.constraints.minColumns||a(Object.assign(Object.assign({},t),{columns:t.columns.filter((t=>t.__uuid!==e))}))},this.handlePreset=e=>{const{data:t,disabled:n,field:s,onUpdate:a,schemas:r}=this.props
if(n||!Y(t))return
const i=t.columns.map((e=>e.value))
a(Object.assign(Object.assign({},t),{preset:e.key,columns:e.columns.map(((e,t)=>q(s,r,e,i.length>t?i[t]:void 0)))}))},this.handleUpdate=(e,t)=>{const{data:n,disabled:s,onUpdate:a}=this.props
if(s||!Y(n))return
const r=Object.keys(t).every((e=>"value"===e))
a(Object.assign(Object.assign({},n),{preset:r?n.preset:null,columns:n.columns.map((n=>n.__uuid===e?Object.assign(Object.assign({},n),t):n))}))}}createColumn(){const{field:e,schemas:t}=this.props
return q(e,t)}createColumnValue(){const{field:e,schemas:t}=this.props
return G(e,t)}render(){const{data:e,disabled:t,field:n,model:a,path:r,schemas:i}=this.props,l=K(n,i),o=this.context+1,{preset:c,columns:u}=Y(e)?e:{columns:[],preset:null}
return s.createElement("div",{className:"tcfLayoutWidget"},s.createElement(Vn,{breakpoints:n.breakpoints,canEdit:n.canEdit,constraints:n.constraints,columns:u,columnsPerRow:n.columnsPerRow,onCreate:this.handleCreate,onDelete:this.handleDelete,onPreset:this.handlePreset,onUpdate:this.handleUpdate,preset:c,presets:n.presets}),s.createElement("div",{className:Ce()("tcfLayoutWidget--columns",{isStacked:u.length<=o})},u.map(((e,i)=>s.createElement(Ae,{key:e.__uuid,label:Tn(i)},s.createElement(De,{data:e.value,disabled:t,errors:null,field:l,model:a,onUpdate:t=>this.handleUpdate(e.__uuid,{value:t}),path:[...r,{name:n.name,type:"property"},{index:i,name:"columns",type:"index"}]}))))))}}Hn.contextType=He
const Bn=(0,l.$j)(((e,t)=>({schemas:e.schemas})))(Hn)
function zn({data:e,disabled:t,onUpdate:n}){return s.createElement(et,{disabled:t,onChange:n,value:!!e})}function qn(e){const t=s.useRef(null)
return s.useEffect((()=>{const{current:n}=t
if(!n)return
const s=It()
for(const t of function(e){const{data:t,elementType:n,references:s}=e,a=[]
if(Array.isArray(t))for(const e of t){const t=s.find((t=>t.id===e&&t.type===n))
t&&a.push(t)}return a}(e)){const a=t.$element.clone(!1,!0)
a.appendTo(n),Craft.setElementSize(a,e.viewMode),s.load(a)}}),[]),s.createElement("div",{className:"elementselect"},s.createElement("div",{className:"elements",ref:t}))}class Gn extends s.Component{constructor(){super(...arguments),this.element=null,this.renderedIds=[],this.uuid=`element-${b()}`,this.instance=null,this.isRendering=!1,this.handleAdd=({elements:e})=>{const{elementType:t,onAddReferences:n}=this.props
this.handleChange(),n(e.map((e=>Object.assign(Object.assign({},e),{$element:$(e.$element[0].outerHTML),element:e.$element[0].outerHTML,type:t}))))},this.handleChange=()=>{if(this.isRendering)return
const{onUpdate:e}=this.props,t=this.getSelectedIds()
this.renderedIds=t,e(t)},this.setElement=e=>{if(this.element===e)return
this.element=e
let{instance:t}=this
if(t&&(t.off("selectElements",this.handleAdd),t.off("removeElements",this.handleChange),t.elementSort&&t.elementSort.off("sortChange",this.handleChange),t.destroy(),this.instance=t=null),e){const{allowSelfReference:e,criteria:n,elementType:s,limit:a=null,modalStorageKey:r=null,sourceElementId:i,sources:l,viewMode:o="small"}=this.props
t=new Craft.BaseElementSelectInput({criteria:n,elementType:s,id:this.uuid,limit:a,modalStorageKey:r,name:this.uuid,sources:l,sourceElementId:e?null:i,viewMode:o}),this.instance=t,this.createReferences(),t.on("selectElements",this.handleAdd),t.on("removeElements",this.handleChange),t.elementSort&&t.elementSort.on("sortChange",this.handleChange)}}}componentDidUpdate(){const{renderedIds:e}=this,t=this.props.data||[]
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
for(let e=0;e<s.length;e++){const a=parseInt(s.eq(e).data("id"));-1!==n.indexOf(a)&&t.push(a)}return t}render(){return s.createElement("div",{id:this.uuid,className:"elementselect",ref:this.setElement},s.createElement("div",{className:"elements"}),s.createElement("div",{className:"btn add icon dashed"},"Choose"))}}const Xn=(0,l.$j)((e=>({references:e.config.references,sourceElementId:e.config.elementId})),(e=>({onAddReferences:t=>{e(y(t))}})))((function(e){return e.disabled?s.createElement(qn,Object.assign({},e)):s.createElement(Gn,Object.assign({},e))}))
let Kn=0
function Jn(e){var{className:t,suggestions:n}=e,a=(0,P._T)(e,["className","suggestions"])
const[r]=s.useState("tcfAutoCompleteList_"+Kn++)
return s.createElement(s.Fragment,null,s.createElement("input",Object.assign({className:Ce()("tcfInput",t),list:r},a)),s.createElement("datalist",{id:r},n.map(((e,t)=>s.createElement("option",{key:t},e)))))}function Yn(e){var{apiEndpoint:t}=e,n=(0,P._T)(e,["apiEndpoint"])
const s=Object.keys(n).filter((e=>!!n[e])).map((e=>`${e}=${encodeURIComponent(n[e])}`)).join("&")
return new Promise(((e,n)=>{fetch(`${t}&${s}`).then((e=>e.json())).then((t=>{!function(e){return"object"==typeof e&&!0===e.result&&Array.isArray(e.anchors)}(t)?n(t&&t.message?`${t.message}`:"An unknown error has occured."):e(t)})).catch((e=>{n(`${e}`)}))}))}const Qn={anchors:[],options:[],suggestions:[]}
const Zn=(0,l.$j)((e=>({apiEndpoint:e.config.apiEndpoints.anchors,siteId:e.config.elementSiteId})))((function({apiEndpoint:e,disabled:t,elementId:n,mode:a,onChange:r,siteId:i,value:l}){const{options:o,suggestions:c}=function(e){const[t,n]=(0,s.useState)(Qn)
return(0,s.useEffect)((()=>{n(Qn),e.elementId&&Yn(e).then((({anchors:e})=>{n({anchors:e,options:e.map((e=>({key:e.id?e.id:e.anchor,label:e.title||e.anchor}))),suggestions:e.map((e=>e.anchor))})}))}),[e.siteId,e.elementId]),t}({apiEndpoint:e,elementId:n,siteId:i})
return"select"===a?s.createElement(Re,{allowUndecided:!0,className:"tcfLinkWidget--hashEditorSelectWrap",disabled:t,onChange:e=>r(null===e?"":e),options:o,selectClassName:"tcfLinkWidget--hashEditorSelect",value:l}):s.createElement(Jn,{disabled:t,onChange:e=>r(e.currentTarget.value),suggestions:c,value:l})}))
function es({disabled:e,link:t,linkType:n,modalStorageKey:a=null,onUpdate:r}){return n.allowHash,s.createElement("div",{className:"tcfLinkWidget--editor"},s.createElement(Xn,{allowSelfReference:n.allowSelf,criteria:n.criteria,data:[t.elementId],disabled:e,elementType:n.elementType,limit:1,modalStorageKey:a,onUpdate:e=>r(Object.assign(Object.assign({},t),{elementId:e.length?e[0]:0})),sources:n.sources,viewMode:"small"}),n.allowHash?s.createElement("div",{className:"tcfLinkWidget--editorHash tcfInput--group"},s.createElement("div",{className:"tcfInput--groupLabel"},"#"),s.createElement(Zn,{disabled:e,elementId:t.elementId,mode:n.allowHash,onChange:e=>r(Object.assign(Object.assign({},t),{hash:e})),value:t.hash})):null)}function ts({disabled:e,link:t,linkType:n,onUpdate:a}){return s.createElement("div",{className:"tcfLinkWidget--editor"},s.createElement(on,{disabled:e,type:n.inputType,value:t.url,onChange:e=>a(Object.assign(Object.assign({},t),{url:e.currentTarget.value}))}))}function ns(e){return"object"==typeof e&&"number"==typeof e.elementId&&"string"==typeof e.hash&&"string"==typeof e.type&&"string"==typeof e.url}function ss({data:e,disabled:t,field:n,model:a,onUpdate:r}){let i
i=ns(e)?e:{elementId:0,hash:"",openInNewWindow:!1,type:"",url:""}
const l=n.linkTypes[i.type]
let o
l&&"input"===l.type?o=s.createElement(ts,{disabled:t,key:i.type,link:i,linkType:l,onUpdate:r}):l&&"element"===l.type&&(o=s.createElement(es,{disabled:t,key:i.type,link:i,linkType:l,modalStorageKey:`tcf_${a.__type}_${n.name}_${l.type}`,onUpdate:r}))
const{allowNewWindow:c}=n
return s.createElement("div",{className:"tcfLinkWidget"},s.createElement("div",{className:"tcfLinkWidget--type"},s.createElement(Re,{disabled:t,options:Object.keys(n.linkTypes).map((e=>({key:e,label:n.linkTypes[e].label}))),value:i.type,onChange:e=>r(Object.assign(Object.assign({},i),{type:e}))})),o,c?s.createElement(Yt,{disabled:t,onChange:e=>r(Object.assign(Object.assign({},i),{openInNewWindow:e})),value:i.openInNewWindow},s.createElement(ke,{value:"New window"})):null)}class as{constructor(e){this.latitude=e.latitude,this.longitude=e.longitude}createStaticMap(e=100,t=75){const{latitude:n,longitude:s}=this,a=de
if(!a)return new ce.SafeString("")
const r=[`key=${a}`,`center=${encodeURIComponent(`${n},${s}`)}`,`markers=${encodeURIComponent(`size:small|${n},${s}`)}`,`size=${e}x${t}`,"zoom=15","maptype=roadmap"].join("&")
return new ce.SafeString(`\n      <img src="https://maps.googleapis.com/maps/api/staticmap?${r}" width="${e}" height="${t}" />\n    `)}toHTML(){return this.createStaticMap()}}function rs({results:e,onSelect:t}){return s.createElement("div",{className:""},e.map((e=>s.createElement("div",{onClick:()=>t(e)},e.formatted_address))))}(0,P.gn)([vt],as.prototype,"latitude",void 0),(0,P.gn)([vt],as.prototype,"longitude",void 0),(0,P.gn)([yt],as.prototype,"createStaticMap",null),(0,P.gn)([yt],as.prototype,"toHTML",null)
const is=["address","street","country","zip","city"]
class ls extends s.Component{constructor(){super(...arguments),this.autocomplete=null,this.input=null,this.state={isSearching:!1},this.handlePlaceChanged=()=>{const{autocomplete:e}=this
if(!e)return
const t=e.getPlace()
t.geometry&&this.props.onLocation({latitude:t.geometry.location.lat(),longitude:t.geometry.location.lng()})},this.handleResolve=()=>{const{places:e}=this.props
e&&(this.setState({isSearching:!0}),e.findPlaceFromQuery({query:this.getResolveQuery(),fields:["formatted_address","geometry"]},this.handleResolveResults))},this.handleResolveResults=e=>{this.setState({isSearching:!1}),e||(e=[]),1===e.length?this.handleResultsSelect(e[0]):this.setState({results:e})},this.handleResultsSelect=({geometry:e})=>{if(!e)return
const{location:t}=e
this.props.onLocation({latitude:t.lat(),longitude:t.lng()}),this.handleResultsCancel()},this.handleResultsCancel=()=>{this.state.results&&this.setState({results:void 0})},this.setInput=e=>{let{autocomplete:t}=this
this.input=e,t&&(t.unbindAll(),t=null),e&&(t=new google.maps.places.Autocomplete(e),t.setFields(["geometry"]),t.addListener("place_changed",this.handlePlaceChanged)),this.autocomplete=t}}canResolve(){return""!==this.getResolveQuery()}getResolveQuery(){const{model:e}=this.props,t=[]
for(const n of is)n in e&&"string"==typeof e[n]&&t.push(e[n].trim())
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
let i
return r&&r.setPosition(this.getLatLng()),i=e===cs.Loading?s.createElement(st,null):e===cs.Error?s.createElement(En,{title:"Could not load Google Maps"}):s.createElement(s.Fragment,null,n?null:s.createElement(ls,{model:a,onLocation:this.handleLocation,places:t?t.places:null}),s.createElement("div",{className:"tcfLocation--map",ref:this.setElement})),s.createElement("div",{className:"tcfLocation"},i)}static createInstance(){let e=this.instanceStash.pop()
if(!e){const t=document.createElement("div")
t.className="tcfLocation--mapInstance"
const n=new google.maps.Map(t,{mapTypeControl:!1,streetViewControl:!1})
e={element:t,map:n,places:new google.maps.places.PlacesService(n)}}return e}static stashInstance(e){const{element:t}=e,{parentElement:n}=t
n&&n.removeChild(t),this.instanceStash.push(e)}}us.instanceStash=[]
function ds({data:e,disabled:t,errors:n,field:a,onUpdate:r}){const[i,l]=s.useState(!1),[o,c]=s.useState(e),{max:u,min:d,placeholder:m,unit:h}=a,p=i?o:e
const f=s.createElement("input",{autoComplete:"off",className:Ce()("tcfNumberWidget--input text fullwidth",{error:n&&n.length}),disabled:t,max:null===u?void 0:u,min:null===d?void 0:d,onBlur:function(){l(!1),c(e)},onChange:function(e){const{value:t}=e.target
c(t),r(function({dataType:e,defaultValue:t,max:n,min:s,optional:a},r){let i="integer"===e?parseInt(r):parseFloat(r)
if(isFinite(i))"number"==typeof n&&i>n&&(i=n),"number"==typeof s&&i<s&&(i=s)
else{if(a)return null
i=t}return i}(a,t))},onFocus:function(){l(!0)},placeholder:m,type:"number",value:p})
return h?s.createElement("div",{className:"tcfNumberWidget"},f,s.createElement("div",{className:"tcfNumberWidget--unit"},h)):f}class ms extends Kt{cloneValue(e){return(0,P.mG)(this,void 0,void 0,(function*(){const{field:t,schemas:n,value:s}=e
return this.isValue(t,s)?s:this.createValue({field:t,schemas:n})}))}createValue({field:e}){return e.defaultValue}isValue({optional:e},t){return!(!e||null!==t)||("number"==typeof t||t instanceof Number)}preview({value:e}){return e}}class hs{constructor(e){this.value=e}get summary(){return new ce.SafeString(`<div class="snippet">${this.value}</div>`)}toHTML(){return new ce.SafeString(this.value)}}function ps({value:e}){return s.createElement("div",{className:"redactor-box redactor-styles-on redactor-toolbar-on focusable-input redactor-focus focus"},s.createElement("div",{className:"redactor-styles redactor-in redactor-in-0",dangerouslySetInnerHTML:{__html:e}}))}(0,P.gn)([vt],hs.prototype,"value",void 0),(0,P.gn)([vt],hs.prototype,"summary",null),(0,P.gn)([yt],hs.prototype,"toHTML",null)
class fs extends s.Component{constructor(){super(...arguments),this.element=null,this.hasFocus=!1,this.instance=null,this.renderedValue="",this.uuid=`element-${b()}`,this.handleBlur=()=>{this.hasFocus=!1},this.handleChange=(e,...t)=>{this.hasFocus&&(this.renderedValue=e,this.props.onUpdate(e))},this.handleFocus=()=>{this.hasFocus=!0},this.setElement=e=>{if(this.element===e)return
this.element=e
const{elementSiteId:t,options:n}=this.props
let{instance:s}=this
s&&(s.redactor&&(s.redactor.off("blur",this.handleBlur),s.redactor.off("changed",this.handleChange),s.redactor.off("focus",this.handleFocus)),s.destroy(),s=null),e&&(s=new Craft.RedactorInput(Object.assign(Object.assign({},n),{elementSiteId:t,id:this.uuid,redactorConfig:Object.assign({},n.redactorConfig)})),e.removeAttribute("name"),s.redactor&&(s.redactor.on("blur",this.handleBlur),s.redactor.on("changed",this.handleChange),s.redactor.on("focus",this.handleFocus))),this.instance=s}}componentDidUpdate(){const{hasFocus:e,instance:t,props:n,renderedValue:s}=this
t&&!e&&n.value!=s&&(this.renderedValue=n.value,t.redactor.source.setCode(n.value))}render(){const{value:e}=this.props
return s.createElement("div",{className:"tcfRedactorWidget"},s.createElement("textarea",{defaultValue:"string"==typeof e?e:"",id:this.uuid,ref:this.setElement}))}}function gs(e){return e.disabled?s.createElement(ps,Object.assign({},e)):s.createElement(fs,Object.assign({},e))}const ys=(0,l.$j)((e=>({elementSiteId:e.config.elementSiteId})))((function({data:e,disabled:t,elementSiteId:n,field:a,onUpdate:r}){return a.redactor?s.createElement(gs,{disabled:t,elementSiteId:n,onUpdate:r,options:a.redactor,value:e}):null}))
let vs=0
class bs extends Kt{cloneValue(e){return(0,P.mG)(this,void 0,void 0,(function*(){const{field:t,translate:n,value:s}=e
return this.isValue(t,s)?t.translatable&&n?function(e,t){return(0,P.mG)(this,void 0,void 0,(function*(){if(vs>2)return console.warn(`Translator has returned to many errors, skipping translation for text "${e}".`),e
const{endpoint:n}=t,s=(0,P._T)(t,["endpoint"]),a=Object.assign(Object.assign({},s),{text:e}),r=Object.keys(a).map((e=>`${e}=${encodeURIComponent(a[e])}`)).join("&")
return new Promise((t=>{fetch(`${n}&${r}`).then((e=>e.json())).then((n=>{t(n&&n.data?n.data:e)})).catch((n=>{console.error(`Translator returned an error: ${n}`),vs+=1,t(e)}))}))}))}(s,n):s:""}))}createValue(e){return""}isValue(e,t){return"string"==typeof t||t instanceof String}preview({value:e}){return e}}class Es{constructor(e){this.reference=e}createPreview(e="large",t=!0){const{reference:n}=this,s=n.$element.clone(!1,!0)
s.removeClass("large removable small"),s.addClass(e)
const a=s.find(".elementthumb")
if(a.length){let t=a.find("img")[0]
t||(t=document.createElement("img"),t.srcset=a.attr("data-srcset")||"",a.append(t)),t.sizes="small"===e?"30px":"100px"}return t?`<div class="tcfInstancePreview--thumb ${e}">${a?a.html():""}</div>`:s[0].outerHTML}createSafePreview(e="large",t=!0){return new ce.SafeString(this.createPreview(e,t))}get asBackground(){const{reference:e}=this,t=e.$element.find(".elementthumb").attr("data-srcset")
if(!t)return null
const n=t.split(",").pop()
return n?new ce.SafeString(`<div class="tcfInstancePreview--background" style="background-image: url('${n.trim()}');"></div><div class="tcfInstancePreview--background blur" style="background-image: url('${n.trim()}');"></div>`):null}get asLargeElement(){return this.createSafePreview("large",!1)}get asLargeImage(){return this.createSafePreview("large",!0)}get asSmallElement(){return this.createSafePreview("small",!1)}get asSmallImage(){return this.createSafePreview("small",!0)}get label(){return this.reference.label}toHTML(){return new ce.SafeString(this.toString())}toString(){return this.createPreview()}}(0,P.gn)([vt],Es.prototype,"reference",void 0),(0,P.gn)([yt],Es.prototype,"createPreview",null),(0,P.gn)([yt],Es.prototype,"createSafePreview",null),(0,P.gn)([vt],Es.prototype,"asBackground",null),(0,P.gn)([vt],Es.prototype,"asLargeElement",null),(0,P.gn)([vt],Es.prototype,"asLargeImage",null),(0,P.gn)([vt],Es.prototype,"asSmallElement",null),(0,P.gn)([vt],Es.prototype,"asSmallImage",null),(0,P.gn)([vt],Es.prototype,"label",null),(0,P.gn)([yt],Es.prototype,"toHTML",null),(0,P.gn)([yt],Es.prototype,"toString",null)
class ws extends Array{constructor(e){super(...function({context:{references:e},field:t,value:n}){const s=[]
if(!t)return s
const{elementType:a}=t
for(const t of n){const n=e.find((e=>e.id===t&&e.type===a))
n&&s.push(new Es(n))}return s}(e))}get asBackground(){return this.length?this[0].asBackground:null}get asLargeElement(){return this.length?this[0].asLargeElement:null}get asLargeImage(){return this.length?this[0].asLargeImage:null}get asSmallElement(){return this.length?this[0].asSmallElement:null}get asSmallImage(){return this.length?this[0].asSmallImage:null}get firstLabel(){return this.length?this[0].label:""}get label(){return this._map((e=>e.label)).join(", ")}toHTML(){return new ce.SafeString(`<div class="tcfInstancePreview--elements">${this.toString()}</div>`)}toString(){return this._map((e=>pt(e))).join("")}_map(e){const t=[]
for(let n=0;n<this.length;n++)t.push(e(this[n],n))
return t}}function Cs({data:e,disabled:t,field:n,model:a,onUpdate:r}){return s.createElement(Xn,{criteria:n.criteria,disabled:t,data:e,elementType:n.elementType,limit:n.limit||null,modalStorageKey:n.modalStorageKey||`tcf_${a.__type}_${n.name}`,onUpdate:r,sources:n.sources||null,viewMode:n.viewMode})}(0,P.gn)([vt],ws.prototype,"asBackground",null),(0,P.gn)([vt],ws.prototype,"asLargeElement",null),(0,P.gn)([vt],ws.prototype,"asLargeImage",null),(0,P.gn)([vt],ws.prototype,"asSmallElement",null),(0,P.gn)([vt],ws.prototype,"asSmallImage",null),(0,P.gn)([vt],ws.prototype,"firstLabel",null),(0,P.gn)([vt],ws.prototype,"label",null),(0,P.gn)([yt],ws.prototype,"toHTML",null),(0,P.gn)([yt],ws.prototype,"toString",null)
class Ss extends Kt{createValue({field:e}){return e.defaultValue&&this.isValue(e,e.defaultValue)?e.defaultValue:e.options[0].key}isValue(e,t){return e.options.some((e=>e.key==t))}preview({field:e,value:t}){const n=e?e.options.find((e=>e.key===t)):void 0
return n?n.label:"-"}}function _s({data:e,disabled:t,onUpdate:n,field:a}){return s.createElement(Re,{disabled:t,onChange:n,options:a.options,value:e})}function Os(e){let t
return e&&(t="color"in e?e.color:e.label),"string"==typeof t?t:"transparent"}class xs extends s.Component{constructor(){super(...arguments),this.state={isExpanded:!1},this.handleFlyoutClick=()=>{this.setState({isExpanded:!1})},this.handleSelect=e=>{this.props.onUpdate(e.key),this.setState({isExpanded:!1})},this.handleSwatchClick=e=>{e.currentTarget===e.target&&this.setState({isExpanded:!0})}}render(){const{data:e,disabled:t,field:n}=this.props,{isExpanded:a}=this.state,r=n.options.find((t=>t.key===e))
return s.createElement("div",{className:Ce()("tcfSwatchColorWidget",{isUndecided:!r}),onClick:t?void 0:this.handleSwatchClick,style:{background:r?Os(r):void 0}},a&&!t?this.renderFlyout(r):null)}renderFlyout(e){const{field:t}=this.props
return s.createElement(Rt,{onClick:this.handleFlyoutClick},s.createElement("div",{className:"tcfSwatchColorWidget--swatches"},t.options.map((t=>s.createElement("div",{className:Ce()("tcfSwatchColorWidget--swatch",{isSelected:t===e}),key:t.key,onClick:()=>this.handleSelect(t),style:{background:Os(t)}})))))}}function ks({data:e,disabled:t,errors:n,field:{maxLength:a,minLength:r,placeholder:i,inputType:l},onUpdate:o}){return s.createElement("input",{autoComplete:"off",className:Ce()("tcfTextWidget text fullwidth",{error:n&&n.length}),disabled:t,maxLength:a,minLength:r,onChange:e=>o(e.target.value),placeholder:i,type:l,value:e?`${e}`:""})}function Ns({data:e,disabled:t,field:{maxLength:n,minLength:a,monospace:r,placeholder:i,rows:l},onUpdate:o}){return s.createElement("textarea",{className:Ce()("tcfTextareaWidget text fullwidth",{monospace:r}),disabled:t,maxLength:n,minLength:a,onChange:e=>o(e.target.value),placeholder:i,rows:l,value:e})}v.initialize({array:new class extends Kt{constructor(){super({widget:qt})}cloneValue(e){return(0,P.mG)(this,void 0,void 0,(function*(){const{field:t,value:n}=e,s=(0,P._T)(e,["field","value"])
if(this.isValue(t,n)){const e=v.getDefinition(t.member.type),a=[]
for(const r of n)a.push(yield e.cloneValue(Object.assign(Object.assign({},s),{field:t.member,value:r})))
return a}return this.createValue(e)}))}createValue(e){return[]}isValue(e,t){return Array.isArray(t)}preview(e){return new Et(e)}},checkbox:new class extends Jt{constructor(){super({widget:Qt}),this.isAlwaysPlainField=!0}},color:new class extends Kt{constructor(){super({widget:vn})}createValue(e){return{alpha:1,blue:255,green:255,red:255}}isValue(e,t){return en(t)}preview({context:e,value:t}){return""}},instance:new class extends Kt{constructor(){super({factory:Nn,widget:Mn})}cloneValue(e){return(0,P.mG)(this,void 0,void 0,(function*(){const{field:t,value:n}=e,s=(0,P._T)(e,["field","value"])
return this.isValue(t,n)?R(Object.assign(Object.assign({},s),{source:n})):this.createValue(e)}))}createValue({field:e,schema:t,schemas:n}){if(t||(t=n[e.schemas[0]]),!t)throw new Error("The option `schema` is required when creating instances.")
return E({schema:t,schemas:n})}isValue(e,t){return c(t)&&-1!==e.schemas.indexOf(t.__type)}preview({context:e,mode:t="default",value:n}){if(!c(n))return""
const s=e.schemas[n.__type]
if(!s)return""
const a="label"===t?s.previewLabelTemplate:s.previewTemplate
if(null===a)return s.label
const r={toHTML:()=>new ce.SafeString(a(r,bt())),toString:()=>a(r,bt())}
r.depth=e.depth
for(const t of Object.keys(s.fields)){const a=s.fields[t],i=v.getDefinition(a)
i&&(r[t]=i.preview({context:Object.assign(Object.assign({},e),{depth:e.depth+1}),field:a,value:n[t]}))}return r}},layout:new class extends Kt{constructor(){super({widget:Bn})}cloneValue(e){return(0,P.mG)(this,void 0,void 0,(function*(){const{field:t,value:n}=e,s=(0,P._T)(e,["field","value"]),{schemas:a}=s
if(!this.isValue(t,n))return this.createValue(e)
const r=K(t,a),i=v.getDefinition(r),l=[]
for(let e=0;e<n.columns.length;e++){const o=n.columns[e],c=yield i.cloneValue(Object.assign({field:r,value:o.value},s))
l.push(q(t,a,o,c))}return{__role:"layout",__uuid:b(),preset:n.preset,columns:l}}))}createValue({field:e,schemas:t}){const n=this.getDefaultPreset(e)
let s
if(n)s=n.columns.map((n=>q(e,t,n)))
else for(s=[];s.length<e.constraints.minColumns;)s.push(q(e,t))
return{__role:"layout",__uuid:b(),preset:n?n.key:null,columns:s}}getDefaultPreset({defaultPreset:e,presets:t}){const n=t.length?t[0]:null
return t.find((t=>t.key===e))||n}isValue(e,t){return Y(t)}preview({context:e,field:t,value:n}){if(!t)return""
const{breakpoints:s,columnsPerRow:a}=t,r=K(t,e.schemas),i=v.getDefinition(r),l={breakpoints:s,current:s[s.length-1]},o=n.columns.map((t=>{const n=X(t.order,l),s=X(t.offset,l)/a,o=X(t.width,l)/a
return`<div style="${[`margin-left:${(100*s).toFixed(6)}%`,`order:${n}`,`width:${(100*o).toFixed(6)}%`].join(";")}">${pt(i.preview({context:e,field:r,value:t.value}))}</div>`}))
return new ce.SafeString(`<div class="tcpRow">${o.join("")}</div>`)}},lightswitch:new class extends Jt{constructor(){super({widget:zn})}},link:new class extends Kt{constructor(){super({widget:ss})}createValue(){return{elementId:0,hash:"",openInNewWindow:!1,type:"url",url:""}}isValue(e,t){return ns(t)}preview(){return""}},location:new class extends Kt{constructor(){super({widget:us})}createValue({field:e}){return os(e.defaultValue)?Object.assign({},e.defaultValue):{latitude:0,longitude:0}}isValue(e,t){return os(t)}preview({value:e}){return new as(e)}},number:new class extends ms{constructor(){super({widget:ds})}},oembed:new class extends Kt{constructor(){super({widget:Sn})}createValue(e){return{url:""}}isValue(e,t){return wn(t)}preview({value:e}){return new _n(wn(e)?e:{url:""})}},redactor:new class extends bs{constructor(){super({widget:ys})}preview({value:e}){return new hs(e)}},reference:new class extends Kt{constructor(){super({widget:Cs})}createValue(e){return[]}isValue(e,t){return Array.isArray(t)&&t.every((e=>"number"==typeof e))}preview(e){return new ws(e)}},select:new class extends Ss{constructor(){super({widget:_s})}},swatchcolor:new class extends Ss{constructor(){super({widget:xs})}},text:new class extends bs{constructor(){super({widget:ks})}},textarea:new class extends bs{constructor(){super({widget:Ns})}}})
n(524)
const js=[],Ms={},Is={create:e=>{try{let t=null
const n=document.getElementById(e)
if(!n)throw new Error("Root element not found.")
const o=n.querySelector(".tcfField--app"),c=n.querySelector('script[type="application/json"]'),u=n.querySelector("input.tcfField--model")
if(!u||!o||!c)throw new Error("Missing components.")
const d=(0,i.MT)(ht,ve(c,u),(0,i.md)(r.Z))
js.push(d),d.subscribe((()=>{const{draftEditor:e}=window,n=JSON.stringify(d.getState().model)
u.value!==n&&e&&(t&&window.clearTimeout(t),t=window.setTimeout((()=>{e.checkForm(),t=null}),500)),u.value=n})),a.render(s.createElement(l.zt,{store:d},s.createElement(mt,null)),o)}catch(e){console.error("Could not start content editor: "+e.message)}},getInstanceApi:e=>{for(const t of js){const n=d(t.getState(),e)
return n?re(t,n):null}},getValidator:function(e){return e in Ms?Ms[e]:null},registerValidator:(e,t)=>{Ms[e]=t}}
if(window){const e=window;(e.lenz||(e.lenz={})).contentField=Is}const Ls=Is},524:()=>{const e="tcfDetailsToggleState"
function t(e,t,n){t.classList.toggle("tcfDetailsToggle--collapsed",e.isCollapsed),n.classList.toggle("focus",e.isCollapsed)}!function(){const n=function(){try{let n=JSON.parse(sessionStorage.getItem(e)||"{}")
if("object"!=typeof(t=n)||"boolean"!=typeof t.isCollapsed)throw new Error("Invalid details state.")
return n}catch(e){return{isCollapsed:!1}}var t}(),s=document.getElementById("main-content")
if(!s)return
const a=document.createElement("div")
a.className="tcfDetailsToggle btn",a.innerHTML='<div class="tcfIcon craft">general</div>',a.addEventListener("click",(()=>{n.isCollapsed=!n.isCollapsed,function(t){sessionStorage.setItem(e,JSON.stringify(t))}(n),t(n,s,a)})),s.insertBefore(a,s.firstElementChild),t(n,s,a)}()}},n={}
function s(e){var a=n[e]
if(void 0!==a)return a.exports
var r=n[e]={id:e,loaded:!1,exports:{}}
return t[e].call(r.exports,r,r.exports,s),r.loaded=!0,r.exports}s.m=t,e=[],s.O=(t,n,a,r)=>{if(!n){var i=1/0
for(c=0;c<e.length;c++){n=e[c][0],a=e[c][1],r=e[c][2]
for(var l=!0,o=0;o<n.length;o++)(!1&r||i>=r)&&Object.keys(s.O).every((e=>s.O[e](n[o])))?n.splice(o--,1):(l=!1,r<i&&(i=r))
l&&(e.splice(c--,1),t=a())}return t}r=r||0
for(var c=e.length;c>0&&e[c-1][2]>r;c--)e[c]=e[c-1]
e[c]=[n,a,r]},s.n=e=>{var t=e&&e.__esModule?()=>e.default:()=>e
return s.d(t,{a:t}),t},s.d=(e,t)=>{for(var n in t)s.o(t,n)&&!s.o(e,n)&&Object.defineProperty(e,n,{enumerable:!0,get:t[n]})},s.g=function(){if("object"==typeof globalThis)return globalThis
try{return this||new Function("return this")()}catch(e){if("object"==typeof window)return window}}(),s.hmd=e=>((e=Object.create(e)).children||(e.children=[]),Object.defineProperty(e,"exports",{enumerable:!0,set:()=>{throw new Error("ES Modules may not assign module.exports or exports.*, Use ESM export syntax, instead: "+e.id)}}),e),s.o=(e,t)=>Object.prototype.hasOwnProperty.call(e,t),s.r=e=>{"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},(()=>{var e={131:0}
s.O.j=t=>0===e[t]
var t=(t,n)=>{var a,r,i=n[0],l=n[1],o=n[2],c=0
for(a in l)s.o(l,a)&&(s.m[a]=l[a])
for(o&&o(s),t&&t(n);c<i.length;c++)r=i[c],s.o(e,r)&&e[r]&&e[r][0](),e[i[c]]=0
s.O()},n=self.webpackChunkcraft_contentfield_ui=self.webpackChunkcraft_contentfield_ui||[]
n.forEach(t.bind(null,0)),n.push=t.bind(null,n.push.bind(n))})()
var a=s.O(void 0,[736],(()=>s(948)))
a=s.O(a)})()
