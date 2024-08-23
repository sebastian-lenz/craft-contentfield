(()=>{"use strict"
var e,t={920:(e,t,n)=>{n.d(t,{A:()=>jr})
var s=n(540),r=n(961),a=n(265),i=n(829),l=n(48)
function o(e,t){const n=e.schemas[t.__type]
if(!n)throw new Error(`Could not resolve schema "${t.__type}".`)
return n}function c(e){return e&&"object"==typeof e&&"__type"in e&&"__uuid"in e}function u(e,t,n){if(c(n)&&n.__uuid===t)return{model:n,path:[],uuid:t}
const s=o(e,n)
for(const r of Object.keys(s.fields)){const a=s.fields[r]
if("array"===a.type&&"instance"===a.member.type){const s=n[r]
if(!Array.isArray(s))continue
for(let n=0;n<s.length;n++){const a=u(e,t,s[n])
if(null!==a)return a.path.unshift({type:"index",name:r,index:n}),a}}else if("instance"===a.type){const s=u(e,t,n[r])
if(null!==s)return s.path.unshift({type:"property",name:r}),s}else if("layout"===a.type){const{columns:s}=n[r]
for(let n=0;n<s.length;n++){const a=u(e,t,s[n])
if(null!==a)return a.path.unshift({type:"property",name:r},{type:"index",name:"columns",index:n}),a}}}return null}function d(e,t){return u(e,t,e.model)}function m(e){const t=[]
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
const r=o(e,s),a="index"===n.type?n.index:void 0,i=r.fields[n.name]
if(!i)throw new Error(`Could not resolve field "${n.name}" on schema "${r.qualifier}".`)
return{field:i,index:a,owner:s,path:t,schema:r}}function g(e,t){return Craft.t("contentfield",e,t)}let y,v=0
function b(e,t){const n=e.cards[t],s="pageContent-action-menu-"+v++,r=e=>e.replace(/pageContent-action-menu/g,s)
return n.script&&setTimeout((()=>{const e=document.createElement("script")
e.innerHTML=r(n.script),document.body.append(e)}),100),a=r(n.html),(y||(y=new DOMParser)).parseFromString(a,"text/html").body.firstElementChild||document.createElement("div")
var a}function E(e,t){switch(t){case"large":return b(e,"largeChip")
case"list":return b(e,"smallChip")
default:return b(e,"card")}}function w(e){return"object"==typeof e&&"id"in e&&"siteId"in e&&"number"==typeof e.id&&"number"==typeof e.siteId}function C(e,t){return e.id==t.id&&e.siteId==t.siteId}function S(e){switch(e){case"large":return"elements chips inline-chips"
case"list":return"elements chips"
case"grid":return"elements card-grid"
default:return"elements cards"}}function x(e){return{references:e,type:"addReferences"}}const O=new class{initialize(e){this.definitions=e}createValue(e){return this.getDefinition(e.field).createValue(e)}getDefinition(e){const t="string"==typeof e?e:e.type
return this.definitions[t]}}
function _(){return"10000000-1000-4000-8000-100000000000".replace(/[018]/g,(e=>(e^crypto.getRandomValues(new Uint8Array(1))[0]&15>>e/4).toString(16)))}function N({schemas:e,schema:t,oldModel:n}){const s={__errors:{},__type:t.qualifier,__uuid:_(),__visible:!0}
for(const r of Object.keys(t.fields)){const a=t.fields[r],i=O.getDefinition(a)
let l=n&&r in n?n[r]:void 0
void 0!==l&&i.isValue(a,l)||(l=i.createValue({field:a,schemas:e})),s[r]=l}return s}function k(e,t,n){if(!t)return n(e)
const s=e[t.name]
let r
if("index"===t.type){if(!Array.isArray(s))throw new Error("Invalid array access.")
if(t.index<0||t.index>=s.length)throw new Error(`Invalid array index ${t.index}".`)
r=s.slice(),r[t.index]=n(s[t.index])}else{if(Array.isArray(s))throw new Error("Invalid array access.")
r=n(s)}const a=Object.assign({},e)
return a[t.name]=r,a}function j(e,t,n){const s="string"==typeof t?m(t):t.slice()
let r=s.shift()
return k(e,r,(function e(t){return r=s.shift(),r?t?k(t,r,e):t:n(t)}))}function I(e,t){return e.name===t.name&&e.type===t.type&&("index"!==e.type||"index"!==t.type||e.index===t.index)}function M(e){const{sourcePath:t,sourceSegment:n,targetPath:s,targetSegment:r}=e,a=[...s,r]
if(a.length>t.length&&t.every(((e,t)=>I(e,a[t])))){const s=a[t.length]
if("index"!=s.type)throw new Error("Path segment type mismatch")
if(s.name==n.name&&s.index>n.index){a[t.length]=Object.assign(Object.assign({},s),{index:s.index-1})
const n=a.pop()
if(!n||"index"!==n.type)throw new Error("Unsupported operation")
return Object.assign(Object.assign({},e),{targetPath:a,targetSegment:n})}}return e}function L(e,t){return e.length===t.length&&e.every(((e,n)=>I(e,t[n])))}function A(e,t){const{sourcePath:n,sourceSegment:s,targetPath:r,targetSegment:a}=t,i=[...n,s],l=[...r,a],c=p(e.model,r)
if(!c)return!1
const u=o(e,c).fields[a.name],d=c[a.name]
if(!Array.isArray(d)||!u||"array"!==u.type)return!1
const m=M(t)
if(L(i,l)||L(i,[...m.targetPath,m.targetSegment]))return!1
if(!(L(n,r)&&a.name===s.name)&&u.limit>0&&d.length>=u.limit)return!1
const{member:h}=u,f=O.getDefinition(h.type),g=p(e.model,i)
return f.isValue(h,g)}function P(e){return Object.assign(Object.assign({},e),{type:"moveModel"})}function T(e){return{overlay:e,type:"setOverlay"}}const R="tcfUserState"
function U(e,t){if(!c(t))return
const n=e.schemas[t.__type]
n&&(t.__errors=Object.keys(n.fields).reduce(((e,s)=>{const r=function(e,t,n){const{validatorId:s}=e.fields[n]
if(!s)return null
const r=jr.getValidator(s)
if(!r)return null
const a=[]
return r(n,t[n],a),a}(n,t,s)
return r&&r.length&&(e[s]=r),e}),{}))}function F(e,t){return{direction:t,type:"uuidOrder",uuid:e}}function D(e){return{type:"uuidVisibility",uuid:e}}function V(e,t,n){return{path:e,key:t,type:"updateValue",value:n}}function H(e){return{sync:e,type:"updateSync"}}var W=n(635)
function B(e,t){const n=-1===e.indexOf("?")?"?":"&"
return`${e}${n}${Object.keys(t).filter((e=>!!t[e])).map((e=>`${e}=${encodeURIComponent(t[e])}`)).join("&")}`}function z(e){return(t,n)=>(0,W.sH)(this,void 0,void 0,(function*(){try{yield function(e,t,n){return(0,W.sH)(this,void 0,void 0,(function*(){const{config:{apiEndpoints:s,elementSiteId:r}}=n(),a=e.map((e=>fetch(B(s.reference,{id:e.id,siteId:e.siteId||r})).then((e=>e.json()))))
Promise.all(a).then((e=>t(x(e))))}))}(e,t,n)}catch(e){}}))}function q(e){return(0,W.sH)(this,void 0,void 0,(function*(){var{source:t}=e,n=(0,W.Tt)(e,["source"])
const s=n.schemas[t.__type]
if(!s)throw new Error("Invalid source schema.")
const r={__errors:{},__originalUuid:t.__uuid,__type:s.qualifier,__uuid:_(),__visible:t.__visible}
for(const e of Object.keys(s.fields)){const a=s.fields[e],i=O.getDefinition(a)
r[e]=yield i.cloneValue(Object.assign(Object.assign({},n),{field:a,value:t[e]}))}return r}))}function X(e){var{apiEndpoint:t}=e,n=(0,W.Tt)(e,["apiEndpoint"])
return new Promise(((e,s)=>{fetch(B(t,n)).then((e=>e.json())).then((t=>{!function(e){return"object"==typeof e&&"object"==typeof e.data&&!0===e.result&&Array.isArray(e.references)}(t)?s(t&&t.message?`${t.message}`:"An unknown error has occured."):e(t)})).catch((e=>{s(`${e}`)}))}))}function K(e){return c(e)?`[${e.__type}, ${e.__uuid}]`:"[no model]"}const Y={group:console.groupCollapsed,groupEnd:console.groupEnd,info:console.info,model:K},G={group(){},groupEnd(){},info(){},model:K}
function Q(e){return e&&e.verbose?Y:G}function J(e){if(!Array.isArray(e))return[]
const t=[]
for(const n of e)c(n)&&t.push(n)
return t}function Z(e,t){const n=null!==e.__originalUuid,s=null!==t.__originalUuid
return e.__uuid===t.__uuid||s&&e.__uuid===t.__originalUuid||n&&e.__originalUuid===t.__uuid||n&&s&&e.__originalUuid===t.__originalUuid}function ee(e){return(0,W.sH)(this,void 0,void 0,(function*(){var{field:t,source:n,target:s}=e,r=(0,W.Tt)(e,["field","source","target"])
if("instance"!==t.member.type)return n||[]
const a=J(n),i=J(s),l=Q(r),o=[]
for(const e of a){const t=i.findIndex((t=>Z(t,e)))
let n
if(-1===t)l.info(`No array match for ${l.model(e)}`),n=yield q(Object.assign(Object.assign({},r),{source:e}))
else{const s=i[t]
l.info(`Array match for ${l.model(e)} is ${l.model(s)}`),i.splice(t,1),n=yield oe(Object.assign(Object.assign({},r),{source:e,target:s}))}n&&o.push(n)}if("remove"!==r.arrayOrphanMode)for(const e of i)"hide"===r.arrayOrphanMode?o.push(Object.assign(Object.assign({},e),{__visible:!1})):o.push(e)
return o}))}function te(e,t,n,s){const{key:r}=e.breakpoints[0]
return{__errors:{},__role:"layoutColumn",__type:e.columnTypeQualifier,__uuid:_(),__visible:!0,offset:n?Object.assign({},n.offset):{[r]:0},order:n?Object.assign({},n.order):{[r]:0},value:s||ne(e,t),width:n?Object.assign({},n.width):{[r]:e.constraints.minColumnWidth}}}function ne(e,t){const n=re(e,t)
return O.getDefinition(n).createValue({field:n,schemas:t})}function se(e,{breakpoints:t,current:n}){for(let s=n.index;s>=0;s--){const{key:n}=t[s]
if(n in e)return e[n]}return 0}function re(e,t){return t[e.columnTypeQualifier].fields.value}function ae(e,t,n){const{current:s}=n
return function(e,t,{breakpoints:n}){let s=NaN
return n.reduce(((n,{key:r})=>{let a=isNaN(s)?t:s
return r in e&&(a=e[r]),a!==s&&(s=a,n[r]=a),n}),{})}(Object.assign(Object.assign({},e),{[s.key]:t}),0,n)}function ie(e){return"object"==typeof e&&"__uuid"in e&&"__role"in e&&"layout"===e.__role}function le(e){return(0,W.sH)(this,void 0,void 0,(function*(){var{field:t,source:n,target:s}=e,r=(0,W.Tt)(e,["field","source","target"])
const a=Q(r)
if(!ie(n))return a.info(`No source, skipping ${t.name}`),s
if(!ie(s))return s?a.info(`Type missmatch, cloning ${t.name}`):a.info(`No target, cloning ${t.name}`),function(e){return(0,W.sH)(this,void 0,void 0,(function*(){var{source:t}=e,n=(0,W.Tt)(e,["source"])
const s=[]
for(let e=0;e<t.columns.length;e++){const r=t.columns[e],a=yield q(Object.assign(Object.assign({},n),{source:r}))
s.push(Object.assign(Object.assign({},a),{__role:"layoutColumn",offset:Object.assign({},r.offset),order:Object.assign({},r.order),width:Object.assign({},r.width)}))}return{__role:"layout",__uuid:_(),columns:s,preset:t.preset}}))}(Object.assign(Object.assign({},r),{source:n}))
a.group(`Syncing layouts ${t.name}`)
const i=[]
for(let e=0;e<n.columns.length;e++){const t=n.columns[e],a=yield oe(Object.assign(Object.assign({},r),{source:t,target:s.columns[e]}))
i.push(Object.assign(Object.assign({},a),{__role:"layoutColumn",offset:Object.assign({},t.offset),order:Object.assign({},t.order),width:Object.assign({},t.width)}))}return a.groupEnd(),Object.assign(Object.assign({},s),{columns:i,preset:n.preset})}))}function oe(e){return(0,W.sH)(this,void 0,void 0,(function*(){var{source:t,target:n}=e,s=(0,W.Tt)(e,["source","target"])
const r=Q(s)
if(!c(t))return r.info(`No source, skipping ${r.model(n)}`),n
if(!c(n)||n.__type!==t.__type)return n?r.info(`Type missmatch, cloning ${r.model(t)}`):r.info(`No target, cloning ${r.model(t)}`),q(Object.assign(Object.assign({},s),{source:t}))
const a=s.schemas[t.__type]
if(!a)throw new Error("Invalid schema")
const i=Object.assign({},n)
r.group(`Syncing model ${r.model(t)} > ${r.model(n)}`)
for(const e of Object.keys(a.fields)){const l=a.fields[e]
"layout"===l.type?(r.group(`Layout ${e}`),i[e]=yield le(Object.assign(Object.assign({},s),{field:l,source:t[e],target:n[e]})),r.groupEnd()):"array"===l.type?(r.group(`Array ${e}`),i[e]=yield ee(Object.assign(Object.assign({},s),{field:l,source:t[e],target:n[e]})),r.groupEnd()):"instance"===l.type&&(r.group(`Instance ${e}`),i[e]=yield oe(Object.assign(Object.assign({},s),{source:t[e],target:n[e]})),r.groupEnd())}return r.groupEnd(),i}))}function ce(e){return(t,n)=>(0,W.sH)(this,void 0,void 0,(function*(){try{yield function(e,t,n){return(0,W.sH)(this,void 0,void 0,(function*(){var{siteId:s,syncMode:r}=e,a=(0,W.Tt)(e,["siteId","syncMode"])
t(H({status:"working"}))
const{config:i,model:l,schemas:o}=n()
if("number"!=typeof i.elementId)throw new Error("Entry must be saved before it can be synchronized.")
const{data:u,references:d}=yield X({apiEndpoint:i.apiEndpoints.fetchSite,elementId:i.elementId,fieldHandle:i.fieldHandle,siteId:s})
if(!c(u)||!i.rootSchemas.some((e=>e===u.__type)))throw new Error("Selected target site does not contain a valid model.")
a.translate&&(a.translate.csrfParams={[i.csrfTokenName]:i.csrfTokenValue})
const m=c(l)&&l.__type===u.__type&&"clone"!==r?yield oe(Object.assign(Object.assign({},a),{config:i,references:d,schemas:o,source:u,sourceSiteId:s,target:l,targetSiteId:i.elementSiteId})):yield q(Object.assign(Object.assign({},a),{config:i,references:d,schemas:o,source:u,sourceSiteId:s,targetSiteId:i.elementSiteId}))
t(x(d)),t(V([],void 0,m)),t(H({status:"finished"}))}))}(e,t,n)}catch(e){t(H({status:"error",message:`${e}`}))}}))}const ue={addReferences:function(e,t){const n=e.config.references.slice()
document.createElement("div")
for(const e of t.references){const t=n.findIndex((t=>C(t,e)));-1!==t&&n.slice(t,1),n.push(e)}return Object.assign(Object.assign({},e),{config:Object.assign(Object.assign({},e.config),{references:n})})},changeType:function(e,{expandedState:t,newType:n,path:s}){const r=e.schemas[n]
if(!r)return e
const a=p(e.model,s),i=N({oldModel:a,schema:r,schemas:e.schemas})
return a&&t&&t.isExpanded(a.__uuid)&&(t.toggleExpanded(a.__uuid,!1),t.toggleExpanded(i.__uuid,!0)),Object.assign(Object.assign({},e),{model:j(e.model,s,(()=>i))})},moveModel:function(e,t){let{model:n}=e
if(!A(e,t))throw new Error("Invalid operation")
const{sourcePath:s,sourceSegment:r,targetPath:a,targetSegment:i}=M(t),l=p(n,[...s,r])
return n=j(n,s,(e=>{if(!e)throw new Error("Invalid operation")
let t=e[r.name]
if(!Array.isArray(t))throw new Error("Invalid operation")
return t=t.slice(),t.splice(r.index,1),Object.assign(Object.assign({},e),{[r.name]:t})})),n=j(n,a,(e=>{if(!e)throw new Error("Could not find target")
let t=e[i.name]
if(!Array.isArray(t))throw new Error("Unsupported operation")
return t=t.slice(),i.index>=t.length?t.push(l):t.splice(i.index,0,l),Object.assign(Object.assign({},e),{[i.name]:t})})),Object.assign(Object.assign({},e),{model:n})},setOverlay:function(e,{overlay:t}){return Object.assign(Object.assign({},e),{overlay:t})},setUser:function(e,{user:t}){const n=Object.assign(Object.assign({},e.user),t)
try{window.localStorage.setItem(R,JSON.stringify(n))}catch(e){console.error(e)}return Object.assign(Object.assign({},e),{user:n})},uuidInsert:function(e,{position:t,uuid:n,value:s}){const r=d(e,n)
if(!r)return e
const a=f(e,r.path)
if(!a||"array"!==a.field.type||void 0===a.index)return e
const{field:i,index:l,path:o}=a,{name:c}=i
return Object.assign(Object.assign({},e),{model:j(e.model,o,(n=>{if(!n||!(c in n))return n
const r=n[c]
if(!Array.isArray(r))return n
const a=[...r],i=l+("after"===t?1:0)
a.splice(i,0,s)
const o=Object.assign(Object.assign({},n),{[c]:a})
return U(e,o),o}))})},uuidOrder:function(e,{direction:t,uuid:n}){const s=d(e,n)
if(!s)return e
const r=f(e,s.path)
if(!r||"array"!==r.field.type||void 0===r.index)return e
const{field:a,index:i,path:l}=r,{name:o}=a
return Object.assign(Object.assign({},e),{model:j(e.model,l,(n=>{if(!n||!(o in n))return n
const s=n[o]
if(!Array.isArray(s))return n
const r=i+("up"===t?-1:1),a=[...s],l=a.splice(i,1)
a.splice(r,0,...l)
const c=Object.assign(Object.assign({},n),{[o]:a})
return U(e,c),c}))})},uuidRemove:function(e,{uuid:t}){const n=d(e,t)
if(!n)return e
const s=f(e,n.path)
if(!s||"array"!==s.field.type||void 0===s.index)return e
const{field:r,index:a,path:i}=s,{name:l}=r
return Object.assign(Object.assign({},e),{model:j(e.model,i,(t=>{if(!t||!(l in t))return t
const n=t[l]
if(!Array.isArray(n))return t
const s=[...n]
s.splice(a,1)
const r=Object.assign(Object.assign({},t),{[l]:s})
return U(e,r),r}))})},uuidVisibility:function(e,{uuid:t}){const n=d(e,t)
return n?Object.assign(Object.assign({},e),{model:j(e.model,n.path,(e=>e?Object.assign(Object.assign({},e),{__visible:!e.__visible}):e))}):e},updateSync:function(e,{sync:t}){let{overlay:n}=e
return n&&"synchronize"===n.type&&(n=Object.assign(Object.assign({},n),{preventClose:"working"===t.status})),Object.assign(Object.assign({},e),{overlay:n,sync:t})},updateValue:function(e,{path:t,key:n,value:s}){return Object.assign(Object.assign({},e),{model:j(e.model,t,(t=>{const r=n?Object.assign(Object.assign({},t),{[n]:s}):s
return U(e,r),r}))})}}
const de=[function({location:{uuid:e},owner:t}){return t&&"array"===t.field.type?{group:me.Manipulation,icon:"material:add",id:"create",invoke:(t,n=!1)=>{t(T({afterCreate:n?"layer":"expand",type:"create",uuid:e}))},label:g("Create")}:null},function({location:{uuid:e}}){return{group:me.Manipulation,icon:"material:edit",id:"edit",invoke:t=>{t(T({type:"edit",uuid:e}))},label:g("Edit")}},function({owner:e,location:{uuid:t}}){return e&&"array"===e.field.type?{group:me.Manipulation,icon:"material:delete",id:"delete",invoke:e=>{e(function(e){return{type:"uuidRemove",uuid:e}}(t))},label:g("Delete")}:null},function({location:{uuid:e,model:{__visible:t}}}){return{group:me.Visibility,icon:t?"material:visibility_off":"material:visibility",id:"visibility",invoke:t=>{t(D(e))},label:g(t?"Hide":"Show")}},function({location:{uuid:e},owner:t}){if(!t||"array"!==t.field.type)return null
const n=t.owner[t.field.name]
return!Array.isArray(n)||void 0===t.index||t.index<=0?null:{group:me.Movement,icon:"material:arrow_upward",id:"moveUp",invoke:t=>t(F(e,"up")),label:g("Move up")}},function({location:{uuid:e},owner:t}){if(!t||"array"!==t.field.type)return null
const n=t.owner[t.field.name]
return!Array.isArray(n)||void 0===t.index||t.index>=n.length-1?null:{group:me.Movement,icon:"material:arrow_downward",id:"moveDown",invoke:t=>t(F(e,"down")),label:g("Move down")}},function(){return null},function({owner:e}){return null},function({owner:e}){return null}]
var me
function he(e,t){const n=d(e,t)
if(!n)return[]
const s={location:n,owner:f(e,n.path),state:e}
return de.map((e=>e(s))).filter((e=>null!==e))}function pe(e,{uuid:t}){let n=null
return{getCommands:()=>he(e.getState(),t).map((t=>Object.assign(Object.assign({},t),{invoke:()=>t.invoke(e.dispatch,!0)}))),subscribe:t=>{n&&n(),n=e.subscribe(t)},unsubscribe:()=>{n&&n(),n=null}}}!function(e){e[e.Manipulation=0]="Manipulation",e[e.Visibility=1]="Visibility",e[e.Movement=2]="Movement",e[e.Clipboard=3]="Clipboard"}(me||(me={}))
var fe,ge=n(596),ye=n.n(ge)
let ve
!function(e){e[e.Idle=0]="Idle",e[e.Loading=1]="Loading",e[e.Loaded=2]="Loaded"}(fe||(fe={}))
let be=null,Ee=fe.Idle
function we(e){return e&&"object"==typeof e&&"__uuid"in e}function Ce(e,t){if(we(e))return e
const n=function(e){switch(typeof e){case"boolean":return new Boolean(e)
case"number":return new Number(e)
case"object":return e
default:return new String(e)}}(e)
return Object.defineProperty(n,"__uuid",{value:t&&we(t)?t.__uuid:_()}),n}function Se(e,t,n){const{fields:s}=t[e.__type]
n&&n.uniqueUuids&&(-1===n.uniqueUuids.indexOf(e.__uuid)?n.uniqueUuids.push(e.__uuid):(console.error(`Found duplicate uuid "${e.__uuid}".`),e.__uuid=_()))
for(const r of Object.keys(s)){const a=s[r]
"array"===a.type?e[r]=e[r].map((e=>"instance"===a.member.type?Se(e,t,n):Ce(e))):"instance"===a.type&&(e[r]=Se(e[r],t,n))}return e}function xe(e){return"string"==typeof e&&""!==e.trim()?ye().compile(e):null}function Oe(e,t){const n=decodeURIComponent(escape(atob(e.innerText))),s=JSON.parse(n)
s.user=function(){try{const t=window.localStorage.getItem(R)
if(null===t)throw new Error("User state missing")
const{favoriteSchemas:n={}}=JSON.parse(t)
return{favoriteSchemas:(e=n,Object.keys(e).reduce(((t,n)=>Array.isArray(e[n])?Object.assign(Object.assign({},t),{[n]:e[n]}):t),{}))}}catch(e){}var e
return{favoriteSchemas:{}}}(),s.sync={status:"idle"}
for(const e of Object.keys(s.schemas)){const t=s.schemas[e]
t.previewTemplate=xe(t.preview),t.previewLabelTemplate=xe(t.previewLabel)||t.previewTemplate}var r
let a
r=s.config.googleMapsApiKey,ve=r,1===s.config.rootSchemas.length&&(a=s.schemas[s.config.rootSchemas[0]])
try{s.model=Se(JSON.parse(t.value),s.schemas,{uniqueUuids:[]})}catch(e){}return!a||c(s.model)&&s.model.__type===a.qualifier||(s.model=N({oldModel:s.model,schema:a,schemas:s.schemas})),s}var _e=n(200),Ne=n(909),ke=n(942),je=n.n(ke)
function Ie(e){var{children:t,className:n,outline:r,secondary:a}=e,i=(0,W.Tt)(e,["children","className","outline","secondary"])
return s.createElement("div",Object.assign({},i,{className:je()("tcfButtonFlat",n,{outline:r,secondary:a})}),t)}const Me=s.createContext({expanded:[],isExpanded:()=>!1,toggleExpanded:function(){}})
function Le({children:e}){const[t,n]=s.useState([])
return s.createElement(Me.Provider,{value:{expanded:t,isExpanded:e=>-1!==t.indexOf(e),toggleExpanded:(e,s)=>{let r=[...t]
void 0===s&&(s=-1===t.indexOf(e)),s?r.push(e):r=r.filter((t=>t!==e)),n(r)}}},e)}function Ae({children:e,disabled:t,onClick:n,primary:r,secondary:a}){return s.createElement("div",{className:je()("tcfButton btn",{disabled:t,submit:r,secondary:a}),onClick:e=>{e.preventDefault(),t||n(e)}},e)}function Pe({className:e,params:t,value:n}){return s.createElement("span",{className:e},g(n,t))}function Te({children:e,className:t}){return s.createElement("div",{className:je()("tcfWindow--content",t)},e)}function $e({children:e,className:t,flex:n=!0}){return s.createElement("div",{className:je()("tcfWindow--footer flex-nowrap",t,{flex:n})},e)}function Re({children:e,className:t,width:n}){return s.createElement("div",{className:je()("tcfWindow",t),style:{width:n}},e)}!function(e){e.Content=Te,e.Footer=$e}(Re||(Re={}))
const Ue=Re
function Fe({onClose:e}){return s.createElement(Ue,{width:600},s.createElement(Ue.Content,null,s.createElement(Pe,{value:"Cannot create an element at the given location."})),s.createElement(Ue.Footer,null,s.createElement(Ae,{onClick:e,secondary:!0},s.createElement(Pe,{value:"Cancel"}))))}const De="craft:",Ve="material:"
function He({className:e,name:t,size:n}){let r="craft"
return t.startsWith(Ve)?(r="material",t=t.substr(Ve.length)):t.startsWith(De)&&(t=t.substr(De.length)),s.createElement("div",{className:je()("tcfIcon",e,r,n)},t)}function We({children:e,label:t}){const[n,r]=s.useState(!1)
return s.createElement("div",{className:je()("tcfFieldGroup tcfAccordion",{isExpanded:n})},s.createElement("div",{className:"tcfAccordion--label",onClick:()=>r(!n)},s.createElement(He,{name:n?"material:expand_less":"material:expand_more"}),s.createElement("span",null,t)),s.createElement("div",{className:"tcfAccordion--content"},s.createElement("div",{className:"tcfFieldGroup--content"},e)))}const Be="toolbar"
function ze({children:e,isBorderless:t,label:n,style:r,type:a}){return"accordion"===a?s.createElement(We,{label:n||"Details"},e):"panel"===a?s.createElement("div",{className:"tcfFieldGroup shadowed",style:r},s.createElement("div",{className:"tcfFieldGroup--content"},e)):n&&""!==n&&n!==Be&&"default"!==n?s.createElement("div",{className:"tcfFieldGroup shadowed",style:r},s.createElement("div",{className:"tcfFieldGroup--label"},n),s.createElement("div",{className:"tcfFieldGroup--content"},e)):s.createElement("div",{className:je()("tcfFieldGroup--content",{isBorderless:t}),style:r},e)}function qe({children:e,className:t,errors:n,instructions:r,isPlainField:a,isRequired:i,label:l,style:o}){if(a)return s.createElement(s.Fragment,null,e)
const c=n&&n.length
return s.createElement("div",{className:je()("tcfFieldPanel",t),style:o},s.createElement("div",{className:je()("tcfFieldPanel--label",{hasErrors:c,isRequired:i})},l),r?s.createElement("div",{className:"tcfFieldPanel--instructions"},r):null,n&&n.length?s.createElement("ul",{className:"tcfFieldPanel--errors"},n.map(((e,t)=>s.createElement("li",{className:"tcfFieldPanel--error",key:t},e)))):null,e)}function Xe(e,t){return e.label.localeCompare(t.label)}function Ke({allowUndecided:e,className:t,disabled:n=!1,options:r,selectClassName:a,value:i,onChange:l}){const o=r.findIndex((e=>e.key==i)),c=e||-1===o
return s.createElement("div",{className:je()("tcfSelect",t)},s.createElement("select",{className:je()("tcfSelect--select",a),disabled:n,value:-1==o?void 0:o,onChange:n?void 0:function(t){let n=t.target.selectedIndex,s=null
c&&(n-=1),n>=0&&n<r.length&&(s=r[n].key),(null!==s||e)&&l(s)}},c?s.createElement("option",null,g("(No selection)")):null,r.map(((e,t)=>s.createElement("option",{key:t,value:t},e.indent?"--".repeat(e.indent)+" ":null,e.label)))))}const Ye=[{key:"before",label:"Before selected element"},{key:"after",label:"After selected element"}]
function Ge({Factory:e,field:t,onCreate:n,scope:r}){const[a,i]=s.useState("before")
return s.createElement(Ue,{width:600},s.createElement(Ue.Content,null,s.createElement(ze,null,s.createElement(qe,{instructions:g("Select where the new element should be inserted."),label:g("Position")},s.createElement(Ke,{onChange:i,options:Ye.map((e=>Object.assign(Object.assign({},e),{label:g(e.label)}))),value:a})))),s.createElement(Ue.Footer,{flex:!1},s.createElement(e,{field:t,onCreate:e=>n(e,a),scope:r})))}function Qe({afterCreate:e="expand",uuid:t}){const n=(0,l.wA)(),r=s.useContext(Me),a=(0,l.d4)((e=>{const n=d(e,t)
if(!n||!n.path.length)return null
const s=f(e,n.path)
return s&&"array"===s.field.type&&void 0!==s.index?{field:s.field,model:s.owner}:null}))
if(null===a)return s.createElement(Fe,{onClose:function(){n(T(null))}})
const{field:i,model:o}=a,{factory:u}=O.getDefinition(i.member.type)
return s.createElement(Ge,{Factory:u,field:i.member,onCreate:function(s,a){let i=null
c(s)&&("expand"===e?r.toggleExpanded(s.__uuid,!0):i={type:"edit",uuid:s.__uuid}),n(function(e,t,n){return{position:n,type:"uuidInsert",uuid:e,value:t}}(t,s,a)),n(T(i))},scope:o.__type})}function Je(e){const{field:t}=e,{widget:n}=O.getDefinition(t)
return s.createElement(n,e)}function Ze(e,t){if(t)switch(e){case 0:return t.small
case 2:return t.large
default:return t.medium}}const et=s.createContext(2)
function tt(e){var{children:t}=e,n=(0,W.Tt)(e,["children"])
const[r,a]=s.useState(2),i=s.useRef(null)
return s.useEffect((()=>{const{ResizeObserver:e}=window,{current:t}=i
let n=-1,s=0
if(!t)return
const r=()=>{const e=t.offsetWidth
e!==s&&(s=e,a(s>920?2:s>580?1:0))}
if(e){const n=new e(r)
return n.observe(t),()=>n.unobserve(t)}{const e=()=>{n=window.requestAnimationFrame(e),r()}
return e(),()=>window.cancelAnimationFrame(n)}}),[]),s.createElement("div",Object.assign({ref:i},n),s.createElement(et.Provider,{value:r},t))}function nt(e,t){return e.index-t.index}const st=(0,l.Ng)(((e,t)=>({schema:e.schemas[t.model.__type]})),((e,t)=>({onUpdate:(n,s)=>{e(V(t.path,n,s))}})))((function({disabled:e=!1,isBorderless:t,model:n,onUpdate:r,path:a,schema:i}){const l=s.useContext(et)
if(!i)return s.createElement("div",null,`Could not resolve schema for "${n.__type}"`)
const o=[],c=Object.keys(i.fields)
let u
if(0===c.length)return s.createElement("div",{className:"tcfInstanceForm--empty"},s.createElement(Pe,{value:"This element has no properties."}))
for(const d of c){const c=i.fields[d],m=n.__errors.hasOwnProperty(d)&&n.__errors[d]||null,{isAlwaysPlainField:h}=O.getDefinition(c)
if(!u||c.group){const e=c.group?c.group.label:void 0,t=c.group?c.group.type:void 0,n=c.group?Ze(l,c.group.style):void 0
u={index:e===Be?-1:o.length,label:e,fields:[],style:n,type:t},o.push(u)}u.fields.push(s.createElement(qe,{errors:m,instructions:c.instructions,isPlainField:t||h,isRequired:c.isRequired,key:c.name,label:c.label,style:Ze(l,c.style)},s.createElement(Je,{data:n[c.name],disabled:e,errors:m,field:c,model:n,onUpdate:e=>r(d,e),path:a})))}const d=o.sort(nt).map((e=>s.createElement(ze,{isBorderless:t,key:e.index,label:e.label,style:e.style,type:e.type},e.fields))),m=Ze(l,i.style)
return m?s.createElement("div",{className:"tcfInstanceForm",style:m},d):s.createElement(s.Fragment,null,d)}))
class rt extends s.Component{constructor(e){super(e),this.originalModel=null,this.handleCancel=()=>{this.close()},this.handleApply=()=>{this.close()},this.originalModel=e.model}close(){this.props.setOverlay(null)}render(){const{model:e,path:t}=this.props
return s.createElement(Le,null,s.createElement(Ue,null,s.createElement(Ue.Content,null,s.createElement(st,{model:e,path:t})),s.createElement(Ue.Footer,null,s.createElement(Ae,{onClick:this.handleApply},s.createElement(Pe,{value:"Apply"})))))}}const at=(0,l.Ng)(((e,t)=>d(e,t.uuid)),(e=>({setOverlay:t=>e(T(t))})))(rt)
function it({message:e,onClose:t}){return s.createElement(s.Fragment,null,s.createElement(Ue.Content,null,s.createElement("div",{className:"tcfSynchronize--message"},s.createElement(He,{className:"tcfSynchronize--messageIcon error",name:"material:error",size:"huge"}),s.createElement("div",{className:"tcfSynchronize--title"},"An error has occured"),e?s.createElement("div",{className:"tcfSynchronize--message"},e):null)),s.createElement(Ue.Footer,null,s.createElement(Ae,{onClick:t},"Close")))}function lt({onClose:e}){return s.createElement(s.Fragment,null,s.createElement(Ue.Content,null,s.createElement("div",{className:"tcfSynchronize--message"},s.createElement(He,{className:"tcfSynchronize--messageIcon finished",name:"material:check_circle",size:"huge"}),s.createElement("div",{className:"tcfSynchronize--title"},s.createElement(Pe,{value:"Sites have been synchronized"})),s.createElement("div",{className:"tcfSynchronize--message"},s.createElement(Pe,{value:"If you are not happy with the results, do not save the entry. Reload this page to revert all changes."})))),s.createElement(Ue.Footer,null,s.createElement(Ae,{onClick:e},s.createElement(Pe,{value:"Close"}))))}class ot extends s.Component{constructor(){super(...arguments),this.element=null,this.lightswitch=null,this.handleChange=()=>{const{disabled:e,onChange:t}=this.props,{lightswitch:n}=this
!e&&n&&t(n.on)},this.setElement=e=>{this.element!==e&&(this.element=e,this.updateInstance())}}componentDidUpdate(e){const{value:t}=this.props,{lightswitch:n}=this
e.disabled!==this.props.disabled?this.updateInstance():n&&n.on!==t&&n.toggle()}render(){const{className:e,disabled:t,small:n,value:r}=this.props
return s.createElement("div",null,s.createElement("div",{className:je()("lightswitch",e,{disabled:t,on:r,small:n}),ref:this.setElement,tabIndex:0},s.createElement("div",{className:"lightswitch-container"},s.createElement("div",{className:"label on"}),s.createElement("div",{className:"handle"}),s.createElement("div",{className:"label off"}))))}updateInstance(){const{element:e,handleChange:t,lightswitch:n}=this,{disabled:s,value:r}=this.props
n&&(n.destroy(),this.lightswitch=null),!s&&e&&(this.lightswitch=new Craft.LightSwitch(e,{onChange:t,value:r}))}}class ct extends s.Component{constructor(e){super(e),this.handleApply=e=>{const{currentSite:t,endpoint:n}=this.props,{arrayOrphanMode:s,site:r,syncMode:a,useTranslator:i}=this.state
if(!r)return
let l
i&&t&&r.language!==t.language&&(l={endpoint:n,source:r.language,target:t.language}),this.props.onSynchronize({arrayOrphanMode:s,siteId:r.id,syncMode:a,translate:l,verbose:"altKey"in e&&e.altKey})},this.handleArrayOrphanModeChange=e=>{this.setState({arrayOrphanMode:e})},this.handleSiteChange=e=>{this.setState({site:e})},this.handleSyncModeChange=e=>{this.setState({syncMode:e})},this.handleToggleTranslator=e=>{this.setState({useTranslator:e})},this.state={arrayOrphanMode:"hide",site:e.availableSites[0]||null,syncMode:"sync",useTranslator:!1}}render(){const{availableSites:e,currentSite:t,hasTranslator:n,onClose:r}=this.props,{arrayOrphanMode:a,site:i,syncMode:l,useTranslator:o}=this.state,c=e.map((e=>({label:e.label,key:e})))
return s.createElement(s.Fragment,null,s.createElement(Ue.Content,null,s.createElement("div",{className:"tcfSynchronize--title"},s.createElement(Pe,{value:"Synchronize translations"})),s.createElement(ze,null,s.createElement(qe,{instructions:g("Select the site the content should be copied from."),label:g("Site")},s.createElement(Ke,{onChange:this.handleSiteChange,options:c,value:i})),s.createElement(qe,{instructions:g("Defines whether the synchronization should compare individual elements or clone the entire source."),label:g("Synchronization mode")},s.createElement(Ke,{onChange:this.handleSyncModeChange,options:[{key:"sync",label:g("Compare elements, adds newly created elements")},{key:"clone",label:g("Clone the source, overwrites everything")}],value:l})),"sync"===l?s.createElement(qe,{instructions:g("Defines what happens to elements that do not exist in the selected language."),label:g("Orphaned elements")},s.createElement(Ke,{onChange:this.handleArrayOrphanModeChange,options:[{key:"hide",label:g("Hide orphaned elements")},{key:"none",label:g("Do nothing")},{key:"remove",label:g("Remove orphaned elements")}],value:a})):null,i&&t&&i.language!==t.language?s.createElement(qe,{instructions:g(n?"Uses a webservice to automatically translate texts.":"A matching webservice must be configured in the options of this field in order to use this feature."),label:g("Translate texts automatically")},s.createElement(ot,{disabled:!n,onChange:this.handleToggleTranslator,value:o})):null)),s.createElement(Ue.Footer,null,s.createElement(Ae,{onClick:r,secondary:!0},s.createElement(Pe,{value:"Cancel"})),s.createElement(Ae,{onClick:this.handleApply,primary:!0},s.createElement(Pe,{value:"Apply"}))))}}const ut=(0,l.Ng)((e=>{const{apiEndpoints:t,elementSiteId:n,hasTranslator:s,supportedSites:r}=e.config
return{availableSites:r.filter((e=>e.id!==n)),currentSite:r.find((e=>e.id===n)),endpoint:t.translate,hasTranslator:s}}),(e=>({onSynchronize:t=>e(ce(t))})))(ct)
function dt(){return s.createElement("div",{className:"tcfActivityIndicator"},s.createElement("div",{className:"tcfActivityIndicator--bounce first"}),s.createElement("div",{className:"tcfActivityIndicator--bounce second"}),s.createElement("div",{className:"tcfActivityIndicator--bounce third"}))}function mt(){return s.createElement(Ue.Content,null,s.createElement("div",{className:"tcfSynchronize--working"},s.createElement(dt,null)))}function ht(){const e=(0,l.d4)((e=>e.sync)),t=(0,l.wA)(),n=()=>t(T(null))
let r
return r="working"===e.status?s.createElement(mt,null):"error"===e.status?s.createElement(it,{message:e.message,onClose:n}):"finished"===e.status?s.createElement(lt,{onClose:n}):s.createElement(ut,{onClose:n}),s.createElement(Ue,{width:600},r)}const pt=s.createContext(0)
function ft({children:e}){const t=s.useContext(pt)
return s.createElement(pt.Provider,{value:t+1},e)}function gt({disabled:e,dispatch:t,model:n,path:r,schemas:a}){const i=s.useContext(Me),l=a.map((({qualifier:e,label:t})=>({key:e,label:t})))
return l.sort(Xe),s.createElement(qe,{className:"tcfInstance--controlsSchema",label:"Type"},s.createElement(Ke,{disabled:e,onChange:e=>t(function(e,t,n){return{expandedState:n,newType:t,path:e,type:"changeType"}}(r,e,i)),options:l,value:n?n.__type:null}))}function yt({disabled:e,dispatch:t,model:n}){const r=n.__visible?"material:visibility":"material:visibility_off",a=s.createElement(s.Fragment,null,s.createElement(Pe,{value:"Visibility"}),s.createElement(He,{className:je()("tcfInstance--controlsVisibilityIcon",{off:!n.__visible}),name:r}))
return s.createElement(qe,{label:a,className:"tcfInstance--controlsVisibility"},s.createElement(Ae,{disabled:e,onClick:()=>t(D(n.__uuid))},s.createElement(Pe,{value:n.__visible?"Hide":"Show"})))}const vt=s.memo((function({canChangeVisibility:e=!1,canChangeType:t=!0,disabled:n=!1,isBorderless:r,model:a,path:i,schemaNames:o}){const u=(0,l.wA)(),d=(0,l.d4)((e=>o.map((t=>e.schemas[t]))))
let m=!1
c(a)&&(m=d.some((e=>e.qualifier===a.__type)))
const h=t&&d.length>1,p=e&&m&&!a.__visible
return s.createElement(ft,null,s.createElement(tt,null,h||p?s.createElement("div",{className:"tcfInstance--controls"},h?s.createElement(gt,{disabled:n,dispatch:u,model:m?a:null,path:i,schemas:d}):null,p?s.createElement(yt,{disabled:n,dispatch:u,model:a}):null):null,m?s.createElement(st,{disabled:n,model:a,isBorderless:r,path:i}):null))}))
class bt extends s.Component{constructor(e){super(e),this.element=null,this.handleMouseDown=e=>{const{onClick:t}=this.props
e.target===this.element&&t&&t()}
const t=document.createElement("div")
t.className="tcfOverlay",t.addEventListener("mousedown",this.handleMouseDown),document.body.appendChild(t),this.element=t}componentWillUnmount(){const{element:e}=this
e&&(document.body.removeChild(e),e.removeEventListener("mousedown",this.handleMouseDown),this.element=null)}render(){const{children:e}=this.props,{element:t}=this
return t?(0,r.createPortal)(e,t):null}}function Et(){const e=(0,l.wA)(),t=(0,l.d4)((e=>e.model)),n=(0,l.d4)((e=>e.overlay)),{disabled:r,hideSyncButton:a,rootSchemas:i,supportedSites:o}=(0,l.d4)((e=>e.config)),c=o.length>1
return s.createElement(_e.Q,{backend:Ne.t2},s.createElement(Le,null,!c||r||a?null:s.createElement("div",{className:"tcfRoot--options"},s.createElement(Ie,{onClick:()=>{e(H({status:"idle"})),e(T({type:"synchronize"}))},outline:!0},s.createElement(He,{name:"material:sync"}),s.createElement(Pe,{value:"Synchronize translations"}))),s.createElement(vt,{disabled:r,model:t,path:[],schemaNames:i}),n?s.createElement(bt,{onClick:()=>{n&&!n.preventClose&&e(T(null))}},function(e){if(!e)return null
switch(e.type){case"create":return s.createElement(Qe,Object.assign({},e))
case"edit":return s.createElement(at,Object.assign({},e))
case"synchronize":return s.createElement(ht,null)}}(n)):null))}function wt(e={config:{apiEndpoints:{anchors:"",fetchSite:"",hotspotAsset:"",oembed:"",reference:"",translate:""},csrfTokenName:"",csrfTokenValue:"",disabled:!1,elementId:null,elementSiteId:0,fieldHandle:"",hasTranslator:!1,references:[],rootSchemas:[],supportedSites:[]},model:{__errors:{},__type:"unknown",__uuid:"0",__visible:!0},overlay:null,schemas:{},sync:{status:"idle"},user:{favoriteSchemas:{}}},t){return t.type in ue?ue[t.type](e,t):e}function Ct(e){for(;"string"!=typeof e;)e=e.toHTML()
return e}const St={},xt={},Ot=(e,t)=>{St[String(t)]=!0},_t=(e,t)=>{xt[String(t)]=!0}
function Nt(){return{allowedProtoMethods:St,allowedProtoProperties:xt}}class kt extends Array{constructor(e){super(...function({context:e,field:t,value:n}){if(!t)return[]
const{member:s}=t,r=O.getDefinition(s)
return n.map((t=>r.preview({value:t,field:s,context:e})))}(e))}get asColumn(){return this.toList("flexColumn")}get asList(){return this.toList("")}get asRow(){return this.toList("flexRow")}get first(){return new ge.SafeString(this.length?Ct(this[0]):"")}get one(){return this.first}toHTML(){return new ge.SafeString(this.toString())}toList(e){return new ge.SafeString(`<ul class="${e}">${this.map((e=>`<li>${Ct(e)}</li>`)).join("")}</ul>`)}toString(){return this.map((e=>Ct(e))).join("")}}(0,W.Cg)([_t],kt.prototype,"asColumn",null),(0,W.Cg)([_t],kt.prototype,"asList",null),(0,W.Cg)([_t],kt.prototype,"asRow",null),(0,W.Cg)([_t],kt.prototype,"first",null),(0,W.Cg)([_t],kt.prototype,"one",null),(0,W.Cg)([Ot],kt.prototype,"toHTML",null),(0,W.Cg)([Ot],kt.prototype,"toList",null),(0,W.Cg)([Ot],kt.prototype,"toString",null)
var jt=n(728)
const It="tcf:Member"
function Mt(e,t){return(0,jt.i)({type:It,item:()=>({data:e.child,height:t.current?t.current.clientHeight:100,path:e.path}),canDrag:()=>!e.disabled,collect:e=>({isDragging:e.isDragging()}),isDragging:t=>L(e.path,t.getItem().path)})}var Lt=n(210)
function At(e,t){const n=(0,l.Pj)()
return(0,Lt.H)({accept:It,drop:e=>({item:e}),hover:(s,r)=>{if(!r.isOver({shallow:!0}))return
const a=function(e,t,n){const{current:s}=n,r=t.getClientOffset()
if(!s||!r||!e)return null
const{bottom:a,top:i}=s.getBoundingClientRect(),l=r.y-i
return s.classList.contains("isExpanded")&&l>32&&l<a-i-32?null:(l>(a-i)/2&&(e.targetSegment=Object.assign(Object.assign({},e.targetSegment),{index:e.targetSegment.index+1})),e)}(function(e,t){const n=e.path.slice(),s=n.pop()
if(!s||"index"!==s.type)return null
const r=t.path.slice(),a=r.pop()
return a&&"index"===a.type?{sourcePath:r,sourceSegment:a,targetPath:n,targetSegment:s}:null}(e,s),r,t)
if(!a||!A(n.getState(),a))return
const i=P(a),{targetPath:l,targetSegment:o}=M(i)
s.path=[...l,o],n.dispatch(i)}})}function Pt(e){const{child:t,depth:n,disabled:r,field:a,index:i,model:l,onDelete:o,onUpdate:c,path:u}=e,d=s.useRef(null),[{isDragging:m},h,p]=Mt(e,d),[,f]=At(e,d)
f(d)
return s.createElement("div",{className:je()(`tcfArrayWidgetMember depth-${n}`,{isDragging:m}),ref:d},p(s.createElement("div",{className:"tcfArrayWidgetMember--panel tcfArrayWidgetMember--single"},h(s.createElement("div",{className:je()("tcfArrayWidgetMember--singleHandle",{enabled:!r})},s.createElement(He,{className:"tcfArrayWidgetMember--singleHandleIcon",key:"handle",name:"move"}))),s.createElement("div",{className:"tcfArrayWidgetMember--singleBody"},s.createElement(Je,{data:t,disabled:r,errors:[],field:a,model:l,onUpdate:e=>{c(i,e)},path:u})),r?null:s.createElement("div",{className:"tcfArrayWidgetMember--singleActions"},s.createElement("div",{className:"tcfArrayWidgetMember--singleActionsButton",onClick:()=>{o(i)}},s.createElement(He,{name:"remove"}))))))}function Tt(e){const t=s.useRef(null),[,n]=function(e){const t=(0,l.Pj)()
return(0,Lt.H)({accept:It,drop:e=>({item:e}),hover:(n,s)=>{if(!s.isOver({shallow:!0}))return
const r=function(e,t){const n=t.path.slice(),s=n.pop()
return s&&"index"===s.type?{sourcePath:n,sourceSegment:s,targetPath:e.path,targetSegment:{type:"index",index:0,name:e.field.name}}:null}(e,n)
if(!r||!A(t.getState(),r))return
const a=P(r),{targetPath:i,targetSegment:l}=M(a)
n.path=[...i,l],t.dispatch(a)}})}(e)
return n(t),s.createElement("div",{className:"tcfArrayWidgetList--empty",key:"empty",ref:t},s.createElement(Pe,{value:"Drop elements here"}))}class $t extends s.Component{constructor(e){super(e),this.element=null,this.handleAnimationEnd=()=>{const{element:e}=this
e&&(e.style.height="",e.style.transition=""),this.setState({inTransition:!1,lastChildren:null,lastUri:null})},this.setElement=e=>{this.element=e},this.state={currentChildren:e.children,currentUri:e.uri,inTransition:!1,lastChildren:null,lastUri:null}}componentDidUpdate(e,t,n){const{element:s}=this
s&&n&&setTimeout((()=>{s.style.height=""
const e=s.offsetHeight
s.style.height=`${n.height}px`,s.getBoundingClientRect(),s.style.transition="height 200ms",s.style.height=`${e}px`}),0)}getSnapshotBeforeUpdate(e,t){const{element:n}=this
if(t.currentUri!==this.state.currentUri&&n){const e=n.offsetHeight
return n.style.height=`${e}px`,{height:e}}return null}render(){const{className:e,itemClassName:t}=this.props,{currentChildren:n,currentUri:r,inTransition:a,lastChildren:i,lastUri:l}=this.state,o=[]
return a&&l&&o.push(s.createElement("div",{className:je()(t,"tcfDetailsPanel--item","from"),key:l},i)),o.push(s.createElement("div",{className:je()(t,"tcfDetailsPanel--item",{to:a}),key:r,onAnimationEnd:this.handleAnimationEnd},n)),s.createElement("div",{className:je()(e,"tcfDetailsPanel"),ref:this.setElement},o)}static getDerivedStateFromProps(e,t){return e.uri===t.currentUri?Object.assign(Object.assign({},t),{currentChildren:e.children}):e.uri===t.currentUri||t.inTransition?null:{inTransition:!0,lastChildren:t.currentChildren,lastUri:t.currentUri,currentChildren:e.children,currentUri:e.uri}}}function Rt({children:e,onClick:t,primary:n}){return s.createElement("div",{className:je()("tcfArrayWidgetMember--headerActionsButton",{primary:n}),onClick:e=>{e.preventDefault(),t()}},e)}let Ut=null
function Ft(){return null===Ut&&(Ut=new Craft.ElementThumbLoader),Ut}function Dt({className:e,reference:t,size:n="small"}){const r=s.useRef(null)
s.useEffect((()=>{if(r.current){const e=$(".element",r.current)
Ft().load(e)}}),[r.current,t])
const a=t.cards["large"===n?"largeChip":"smallChip"]
return s.createElement("div",{className:je()("tcfInstancePreviewImage",e,n),dangerouslySetInnerHTML:{__html:a.html},ref:r})}function Vt(e){return"object"==typeof e&&"string"==typeof e.url}function Ht({className:e,size:t="small",src:n}){return s.createElement("div",{className:je()("tcfInstancePreviewImage",e,t)},s.createElement("img",{className:"oembed",src:n}))}function Wt(e,t,n){const r=n.indexOf(".")
let a="";-1!==r&&(a=n.substring(r+1),n=n.substring(0,r))
const i=e.schema.fields[n]
if(!i||!(n in e.model))return null
const l=e.model[n]
switch(i.type){case"oembed":return function(e,t){return Vt(t)&&t.info&&t.info.thumbnail_url?s.createElement(Ht,Object.assign({src:t.info.thumbnail_url},e)):null}(e,l)
case"reference":return function(e,t,n){if(!Array.isArray(t)||0===t.length)return null
const r=n.find((e=>C(e,t[0])))
return r?s.createElement(Dt,Object.assign({},e,{reference:r})):null}(e,l,t.config.references)
case"instance":const n=a?o(t,l):null
return n?Wt(Object.assign(Object.assign({},e),{model:l,schema:n}),t,a):null
default:return null}}function Bt(e){const t=function(e,t){const{previewImages:n}=e.schema
return n?n.reduce(((n,s)=>n||Wt(e,t,s)),null):null}(e,(0,l.d4)((e=>e)))
return t||s.createElement("div",{className:je()("tcfInstancePreviewImage empty",e.className,e.size||"small")})}const zt=s.memo((function(e){var{field:t,model:n,references:r,schemas:a}=e,i=(0,W.Tt)(e,["field","model","references","schemas"])
const l=Ct(O.getDefinition("instance").preview({context:{depth:0,references:r,schemas:a},field:t,mode:"label",value:n})).replace(/<[^>]*>?/gm,"").replace(/[\n\t\r]+/g,"").trim().substr(0,256)
return s.createElement("div",Object.assign({},i),l)}),(function(e,t){return e.model===t.model}))
function qt(e){const{references:t,schemas:n}=(0,l.d4)((e=>({references:e.config.references,schemas:e.schemas})))
return s.createElement(zt,Object.assign({},e,{references:t,schemas:n}))}function Xt({command:e,onClick:t}){return s.createElement("div",{className:"tcfArrayWidgetMember--headerMoreItem",onMouseUp:t},s.createElement(He,{className:"tcfArrayWidgetMember--headerMoreItemIcon",name:e.icon}),s.createElement("span",{className:"tcfArrayWidgetMember--headerMoreItemLabel"},e.label))}const Kt=(0,l.Ng)(((e,{uuid:t})=>({commands:he(e,t)})),(e=>({dispatch:e})))((function({commands:e,dispatch:t,onClose:n}){const r=[]
let a
for(const i of e)"edit"!==i.id&&(void 0!==a&&a!==i.group&&r.push(s.createElement("div",{className:"tcfArrayWidgetMember--headerMoreDivider",key:`${i.id}-divider`})),a=i.group,r.push(s.createElement(Xt,{command:i,key:i.id,onClick:()=>{n(),i.invoke(t)}})))
return s.createElement("div",{className:"tcfArrayWidgetMember--headerMoreMenu"},r)}))
class Yt extends s.Component{constructor(){super(...arguments),this.handle=null,this.handleStyle={left:"0px"},this.origin=null,this.panel=null,this.panelClassName="tcfFlyout--panel",this.panelStyle={left:"0px",top:"0px"},this.handleResize=()=>{this.update()},this.setHandle=e=>{this.handle=e,this.update()},this.setOrigin=e=>{this.origin=e,this.update()},this.setPanel=e=>{this.panel=e,this.update()}}componentDidMount(){window.addEventListener("resize",this.handleResize)}componentWillUnmount(){window.removeEventListener("resize",this.handleResize)}render(){const{children:e,onClick:t}=this.props
return s.createElement("div",{className:"tcfFlyout",ref:this.setOrigin},s.createElement(bt,{onClick:t},s.createElement("div",{className:this.panelClassName,ref:this.setPanel,style:Object.assign({},this.panelStyle)},s.createElement("div",{className:"tcfFlyout--handle",ref:this.setHandle,style:Object.assign({},this.handleStyle)}),s.createElement("div",{className:"tcfFlyout--body"},e))))}update(){const{handle:e,handleStyle:t,origin:n,panel:s,panelStyle:r}=this
if(!n||!s||!e)return
const a=n.getBoundingClientRect(),i=s.getBoundingClientRect()
let l="tcfFlyout--panel"
const o=Math.max(10,Math.min(window.innerWidth-i.width-10,a.left+.5*(a.width-i.width))),c=Math.max(10,Math.min(i.width-10,a.left+.5*a.width-o))
t.left=`${c}px`,r.left=`${o}px`,a.top+.5*a.height>.5*window.innerHeight?(l+=" above",r.top=a.top-i.height-5+"px"):(l+=" below",r.top=`${a.top+a.height+5}px`),e.style.left=t.left,s.className=this.panelClassName=l,s.style.left=r.left,s.style.top=r.top}}class Gt extends s.Component{constructor(){super(...arguments),this.state={isExpanded:!1},this.handleClose=()=>{this.setState({isExpanded:!1})},this.handleMouseDown=()=>{this.setState({isExpanded:!0})}}render(){const{uuid:e}=this.props,{isExpanded:t}=this.state
return s.createElement("div",{className:"tcfArrayWidgetMember--headerMore"},s.createElement("div",{className:"tcfArrayWidgetMember--headerMoreButton",onMouseDown:this.handleMouseDown},s.createElement(He,{name:"material:more_vert"})),t?s.createElement(Yt,{onClick:this.handleClose},s.createElement(Kt,{onClose:this.handleClose,uuid:e})):null)}}function Qt(e){return e}function Jt(e,t){return t?e?"minus":"plus":e?"done":"edit"}function Zt({disabled:e,dragSource:t=Qt,field:n,hasPreview:r,isCollapsible:a,isExpanded:i,model:l,onToggleExpanded:o,schema:c}){const u=[]
return c?(u.push(s.createElement(He,{key:"icon",name:c.icon})),c.previewImages&&c.previewImages.length&&u.push(s.createElement(Bt,{key:"image",model:l,schema:c})),u.push(s.createElement("div",{className:je()("tcfArrayWidgetMember--headerLabel",{isHidden:!l.__visible}),key:"label"},c.label)),r&&c.previewLabelTemplate&&u.push(s.createElement("div",{className:"tcfArrayWidgetMember--headerPreview",key:"preview"},s.createElement(qt,{field:n,model:l})))):u.push(s.createElement(He,{className:"tcfArrayWidgetMember--headerHandleIcon",key:"handle",name:"move"})),s.createElement("div",{className:"tcfArrayWidgetMember--header"},t(s.createElement("div",{className:je()("tcfArrayWidgetMember--headerHandle",{enabled:!e}),onClick:o},u)),l.__visible?null:s.createElement(He,{className:"tcfArrayWidgetMember--headerVisibility",name:"material:visibility_off"}),s.createElement("div",{className:"tcfArrayWidgetMember--headerActions"},a?s.createElement(Rt,{onClick:o,primary:!e},s.createElement(He,{name:Jt(i,e)})):null,e?null:s.createElement(Gt,{uuid:l.__uuid})))}const en=s.memo((function({field:e,model:t,mode:n="default",references:r,schemas:a}){const i=O.getDefinition("instance").preview({context:{depth:0,references:r,schemas:a},field:e,mode:n,value:t})
try{const e={__html:Ct(i)}
return s.createElement("div",{className:je()("tcfInstancePreview--content",n),dangerouslySetInnerHTML:e})}catch(e){return s.createElement(s.Fragment,null,s.createElement("p",null,s.createElement("span",{className:"tcfIcon material"},"error"),s.createElement("span",null,"Could not render preview.")),(l=e)&&"object"==typeof l&&"message"in l?s.createElement("pre",null,e.message):null)}var l}),(function(e,t){return e.model===t.model}))
function tn({className:e,field:t,model:n,mode:r,onClick:a}){const{references:i,schemas:o}=(0,l.d4)((e=>({references:e.config.references,schemas:e.schemas})))
return s.createElement("div",{className:je()("tcfInstancePreview",e,{isClickable:!!a}),onClick:a},s.createElement(en,{field:t,model:n,mode:r,references:i,schemas:o}))}function nn(e){const{isExpanded:t,toggleExpanded:n}=s.useContext(Me),r=s.useRef(null),[{isDragging:a},i,l]=Mt(e,r),[,o]=At(e,r)
o(r)
const{child:c,depth:u,disabled:d,field:m,isCollapsible:h,path:p,previewMode:f,schema:g}=e,y=()=>{n(c.__uuid)}
let v=!0,b=!1
if(g){const e=Object.keys(g.fields)
v=e.length>0,b=1===e.length&&"redactor"===g.fields[e[0]].type}const E=g&&g.preview&&function(e,t){switch(e){case"always":return!0
case"root":return 1===t}}(f,u),w=v&&(!h||t(c.__uuid))
let C
return w?C=s.createElement("div",{className:"tcfArrayWidgetMember--body"},s.createElement(vt,{canChangeType:!1,disabled:d,isBorderless:b,key:"details",model:c,path:p,schemaNames:m.schemas})):E&&(C=s.createElement(tn,{className:"tcfArrayWidgetMember--preview",field:m,key:"summary",model:c,onClick:v?y:void 0})),s.createElement("div",{className:je()(`tcfArrayWidgetMember depth-${u}`,w?"isExpanded":"isCollapsed",{isDragging:a}),ref:r},l(s.createElement("div",{className:"tcfArrayWidgetMember--panel"},s.createElement(Zt,{disabled:d,dragSource:i,field:m,hasPreview:!w&&!E,isCollapsible:v&&h,isExpanded:w,model:c,onToggleExpanded:y,schema:g}),s.createElement($t,{uri:w?"details":"summary"},C))))}function sn({children:e,data:t,disabled:n,field:r,model:a,onDelete:i,onUpdate:o,path:c}){const{member:u,collapsible:d,previewMode:m}=r,h=s.useRef(null),p=(0,l.d4)((e=>e.schemas)),f=s.useContext(pt),g=t.map(((e,t)=>{const r=[...c,{index:t,name:u.name,type:"index"}],l={child:e,depth:f,disabled:n,path:r}
return"instance"===u.type?s.createElement(nn,Object.assign({},l,{isCollapsible:d,field:u,key:e.__uuid,previewMode:m,schema:p[e.__type]})):s.createElement(Pt,Object.assign({},l,{field:u,index:t,key:we(e)?e.__uuid:t,model:a,onDelete:i,onUpdate:o}))}))
return 0===g.length&&g.push(s.createElement(Tt,{field:r,key:"droplet",path:c})),s.createElement(s.Fragment,null,s.createElement("div",{className:"tcfArrayWidgetList",ref:h},g),s.createElement("div",{className:"tcfArrayWidgetList--footer"},e))}class rn extends s.Component{constructor(){super(...arguments),this.handleAdd=e=>{const{context:t}=this,{data:n,disabled:s,onUpdate:r}=this.props
if(s)return
const a=Array.isArray(n)?n.slice():[]
a.push(Ce(e)),r(a),c(e)&&t&&t.toggleExpanded(e.__uuid,!0)},this.handleDelete=e=>{const{data:t,disabled:n,onUpdate:s}=this.props
if(n||!Array.isArray(t))return
const r=t.slice()
r.splice(e,1),s(r)},this.handleUpdate=(e,t)=>{const{data:n,disabled:s,onUpdate:r}=this.props
if(s||!Array.isArray(n))return
const a=n.slice()
a[e]=Ce(t,a[e]),r(a)}}render(){const{data:e,disabled:t,field:n,model:r,path:a}=this.props,{limit:i}=n
if(!n.member)return null
const l=Array.isArray(e)?e:[],o=i>0&&l.length>=i,c=O.getDefinition(n.member)
let u
return t||!c||o||(u=s.createElement(c.factory,{field:n.member,onCreate:this.handleAdd,scope:r.__type})),s.createElement(sn,{data:l,disabled:t,field:n,limit:i,model:r,onDelete:this.handleDelete,onUpdate:this.handleUpdate,path:a},u)}}rn.contextType=Me
const an=rn
function ln(e){if(!e)return e
if(Array.isArray(e))return e.map((e=>ln(e)))
if("object"==typeof e){const t={}
for(const n in e)t[n]=ln(e[n])
return t}return e}function on({field:e,onCreate:t}){const n=(0,l.d4)((e=>e.schemas))
return s.createElement("div",{className:"tcfFactory"},s.createElement(Ie,{className:"tcfFactory--primaryButton",onClick:()=>{const s=O.createValue({field:e,schemas:n})
t(s)},secondary:!0},s.createElement(He,{name:"plus"}),s.createElement(Pe,{value:"Create"})))}class cn{constructor({factory:e,widget:t}){this.factory=e||on,this.widget=t}cloneValue(e){return(0,W.sH)(this,void 0,void 0,(function*(){const{field:t,value:n}=e
return this.isValue(t,n)?ln(n):this.createValue(e)}))}}class un extends cn{createValue(e){return!!e.field.defaultValue}isValue(e,t){return"boolean"==typeof t||t instanceof Boolean}preview({value:e}){return e}}class dn extends s.Component{constructor(){super(...arguments),this.id=_()}render(){const{id:e}=this,{className:t,children:n,disabled:r,onChange:a,value:i}=this.props
return s.createElement("dl",{className:je()("tcfCheckbox",t)},s.createElement("dd",{className:"tcfCheckbox--input"},s.createElement("input",{checked:i,disabled:r,id:e,onChange:r?void 0:()=>a(!i),type:"checkbox"})),s.createElement("dt",{className:"tcfCheckbox--label"},s.createElement("label",{htmlFor:e},n)))}}function mn({data:e,disabled:t,field:n,onUpdate:r}){return s.createElement(dn,{disabled:t,onChange:r,value:!!e},n.label)}class hn{constructor(e){this.value=e}get summary(){return new ge.SafeString(`<div class="snippet">${this.value}</div>`)}toHTML(){return new ge.SafeString(this.value)}}(0,W.Cg)([_t],hn.prototype,"value",void 0),(0,W.Cg)([_t],hn.prototype,"summary",null),(0,W.Cg)([Ot],hn.prototype,"toHTML",null)
class pn extends s.Component{constructor(){super(...arguments),this.editor=null,this.setElement=e=>{const{editor:t}=this
if(this.editor=null,t&&t.destroy(),e){const t=jr.getCKEditor(this.props.field.configId)
CKEditor5.craftcms.create(e,t).then((t=>{t.model.document.on("change",(()=>{this.props.onUpdate(e.value)})),this.editor=t}))}}}onChange(){}render(){const{data:e,disabled:t,field:n,onUpdate:r}=this.props
return t?s.createElement("div",{className:"noteditable",dangerouslySetInnerHTML:{__html:e}}):s.createElement("div",{className:je()(n.editorClass,{"ck-with-show-word-count":n.showWordCount})},s.createElement("textarea",{defaultValue:e,onInput:e=>{r(e.currentTarget.value)},ref:this.setElement}),n.showWordCount?s.createElement("div",{className:"ck-word-count light smalltext"},"&nbps;"):null)}}let fn=0
class gn extends cn{cloneValue(e){return(0,W.sH)(this,void 0,void 0,(function*(){const{field:t,translate:n,value:s}=e
return this.isValue(t,s)?t.translatable&&n?function(e,t){return(0,W.sH)(this,void 0,void 0,(function*(){if(fn>2)return console.warn(`Translator has returned to many errors, skipping translation for text "${e}".`),e
const{endpoint:n,csrfParams:s={}}=t,r=(0,W.Tt)(t,["endpoint","csrfParams"]),a=Object.assign(Object.assign(Object.assign({},r),s),{text:e}),i=new FormData
return Object.keys(a).forEach((e=>i.append(e,a[e]))),new Promise((t=>{fetch(n,{body:i,method:"post"}).then((e=>e.json())).then((n=>{t(n&&n.data?n.data:e)})).catch((n=>{console.error(`Translator returned an error: ${n}`),fn+=1,t(e)}))}))}))}(s,n):s:""}))}createValue(e){return""}isValue(e,t){return"string"==typeof t||t instanceof String}preview({value:e}){return e}}function yn({red:e,green:t,blue:n,alpha:s}){return{max:Math.max(e,t,n),min:Math.min(e,t,n),red:e/255,green:t/255,blue:n/255,alpha:s}}function vn(e){return"object"==typeof e&&"number"==typeof e.alpha&&"number"==typeof e.blue&&"number"==typeof e.green&&"number"==typeof e.red}function bn(e){e=e.replace(/^#?([a-f\d])([a-f\d])([a-f\d])$/i,(function(e,t,n,s){return t+t+n+n+s+s}))
const t=/^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(e)
return t?{red:parseInt(t[1],16),green:parseInt(t[2],16),blue:parseInt(t[3],16),alpha:1}:null}function En(e){return`rgba(${e.red},${e.green},${e.blue},${e.alpha})`}function wn(e){const{alpha:t,blue:n,green:s,max:r,min:a,red:i}=yn(e),l=0===r?0:(r-a)/r,o=(r-a)/255
let c=0,u=r/255
return r===a||(c=r===e.red?(s-n)/o+(s<n?6:0):r===e.green?(n-i)/o+2:(i-s)/o+4,c/=6),{hue:c,saturation:l,value:u,alpha:t}}const Cn=s.createContext({css:"#000",hsv:{hue:0,saturation:0,value:0,alpha:0},rgb:{red:0,green:0,blue:0,alpha:0},onHsvColor:e=>{},onRgbColor:e=>{}})
function Sn(e){return function(t){return s.createElement(Cn.Consumer,null,(n=>s.createElement(e,Object.assign({},t,n))))}}class xn extends s.Component{constructor(e){super(e),this.timeout=null,this.commit=()=>{null!==this.timeout&&window.clearTimeout(this.timeout),this.timeout=window.setTimeout(this.handleTimeout,250)},this.handleHsvColor=e=>{const t=function({alpha:e,hue:t,saturation:n,value:s}){let r=0,a=0,i=0
const l=Math.floor(6*t),o=6*t-l,c=s*(1-n),u=s*(1-o*n),d=s*(1-(1-o)*n)
switch(l%6){case 0:r=s,a=d,i=c
break
case 1:r=u,a=s,i=c
break
case 2:r=c,a=s,i=d
break
case 3:r=c,a=u,i=s
break
case 4:r=d,a=c,i=s
break
case 5:r=s,a=c,i=u}return{alpha:e,red:Math.round(255*r),green:Math.round(255*a),blue:Math.round(255*i)}}(e)
this.setState({css:En(t),rgb:t,hsv:e}),this.commit()},this.handleRgbColor=e=>{this.setState({css:En(e),rgb:e,hsv:wn(e)}),this.commit()},this.handleTimeout=()=>{this.timeout=null,this.props.onChange(this.state.rgb)},this.state={css:En(e.color),hsv:wn(e.color),rgb:Object.assign({},e.color)}}render(){const{children:e}=this.props
return s.createElement(Cn.Provider,{value:Object.assign(Object.assign({},this.state),{onHsvColor:this.handleHsvColor,onRgbColor:this.handleRgbColor})},e)}}function On(e){var{className:t}=e,n=(0,W.Tt)(e,["className"])
return s.createElement("input",Object.assign({className:je()("tcfInput",t)},n))}class _n extends s.Component{constructor(){super(...arguments),this.state={hasFocus:!1},this.handleBlur=()=>{this.setState({hasFocus:!1})},this.handleChange=e=>{const{value:t}=e.target,{onRgbColor:n}=this.props
n(this.getColor(t))},this.handleFocus=()=>{this.setState({hasFocus:!0})}}getValue(){const{rgb:e,type:t}=this.props
switch(t){case"alpha":case"blue":case"green":case"red":return`${e[t]}`
case"hex":return"#"+(16777216+((n=e).blue|n.green<<8|n.red<<16)).toString(16).slice(1)}var n}getColor(e){const{rgb:t,type:n}=this.props
switch(n){case"blue":case"green":case"red":const s=parseInt(e)
return Object.assign(Object.assign({},t),{[n]:isFinite(s)?Math.max(0,Math.min(255,s)):t[n]})
case"alpha":const r=parseFloat(e)
return Object.assign(Object.assign({},t),{alpha:isFinite(r)?Math.max(0,Math.min(1,r)):t.alpha})
case"hex":const a=bn(e)
return a?Object.assign(Object.assign({},a),{alpha:t.alpha}):t}}render(){const{hasFocus:e}=this.state,t={className:"tcfColorInputInput",onBlur:this.handleBlur,onChange:this.handleChange,onFocus:this.handleFocus}
return e?t.defaultValue=this.getValue():t.value=this.getValue(),s.createElement(On,t)}}const Nn=Sn(_n)
class kn extends s.Component{constructor(){super(...arguments),this.element=null,this.state={initialHue:0,isMouseDown:!1,mouseX:0,mouseY:0},this.handleMouseDown=e=>{const{hsv:t}=this.props
window.addEventListener("mousemove",this.handleMouseMove),window.addEventListener("mouseup",this.handleMouseUp),this.setState(Object.assign(Object.assign({},this.update(e.clientX,e.clientY,t.hue)),{initialHue:t.hue,isMouseDown:!0}))},this.handleMouseMove=e=>{this.setState(this.update(e.clientX,e.clientY))},this.handleMouseUp=e=>{this.stopListening(),this.setState(Object.assign(Object.assign({},this.update(e.clientX,e.clientY)),{isMouseDown:!1}))},this.setElement=e=>{this.element=e}}componentWillUnmount(){this.stopListening()}render(){const{hsv:e}=this.props,{initialHue:t,isMouseDown:n,mouseX:r,mouseY:a}=this.state
return s.createElement("div",{className:"tcfColorInputSaturation",onMouseDown:this.handleMouseDown,ref:this.setElement,style:{background:`hsl(${360*(n?t:e.hue)}, 100%, 50%)`}},s.createElement("div",{className:"tcfColorInputSaturation--value",style:{left:100*(n?r:e.saturation)+"%",top:100*(n?a:1-e.value)+"%"}}))}stopListening(){window.removeEventListener("mousemove",this.handleMouseMove),window.removeEventListener("mouseup",this.handleMouseUp)}update(e,t,n=this.state.initialHue){const{element:s}=this
if(!s)return{mouseX:this.state.mouseX,mouseY:this.state.mouseY}
const{hsv:r,onHsvColor:a}=this.props,i=s.getBoundingClientRect(),l=Math.max(0,Math.min(1,(e-i.left)/i.width)),o=Math.max(0,Math.min(1,(t-i.top)/i.height))
return a({alpha:r.alpha,hue:n,saturation:l,value:1-o}),{mouseX:l,mouseY:o}}}const jn=Sn(kn)
class In extends s.Component{constructor(){super(...arguments),this.element=null,this.handleMouseDown=e=>{window.addEventListener("mousemove",this.handleMouseMove),window.addEventListener("mouseup",this.handleMouseUp),this.update(e.clientX)},this.handleMouseMove=e=>{this.update(e.clientX)},this.handleMouseUp=e=>{this.stopListening(),this.update(e.clientX)},this.setElement=e=>{this.element=e}}componentWillUnmount(){this.stopListening()}render(){const{rgb:e,hsv:t,type:n}=this.props,r=t[n]
let a
if("alpha"===n){const{red:t,green:n,blue:r}=e,i=`rgba(${t}, ${n}, ${r}, 0)`,l=`rgba(${t}, ${n}, ${r}, 1)`
a=s.createElement("div",{className:"tcfColorInputSlider--gradient",style:{background:`linear-gradient(to right, ${i}, ${l})`}})}return s.createElement("div",{className:`tcfColorInputSlider ${n}`,onMouseDown:this.handleMouseDown},a,s.createElement("div",{className:"tcfColorInputSlider--track",ref:this.setElement},s.createElement("div",{className:"tcfColorInputSlider--handle",style:{left:100*r+"%"}})))}stopListening(){window.removeEventListener("mousemove",this.handleMouseMove),window.removeEventListener("mouseup",this.handleMouseUp)}update(e){const{element:t}=this
if(!t)return
const{hsv:n,onHsvColor:s,type:r}=this.props,a=t.getBoundingClientRect(),i=Math.max(0,Math.min(1,(e-a.left)/a.width))
s(Object.assign(Object.assign({},n),{[r]:i}))}}const Mn=Sn(In)
const Ln=Sn((function({children:e,className:t,color:n,css:r,disabled:a,onClick:i,onRgbColor:l}){if(n){const e=bn(n)
e&&(i=function(){l(e)})}return s.createElement("div",{className:je()("tcfColorInputSwatch",t),onClick:a?void 0:i},s.createElement("div",{className:"tcfColorInputSwatch--color",style:{background:n||r}}),e)}))
function An({disableAlpha:e,presetColors:t}){const n=[s.createElement("div",{className:"tcfColorInputPicker--value wide",key:"hex"},s.createElement(Nn,{type:"hex"}),s.createElement("div",{className:"tcfColorInputPicker--valueCaption"},"Hex")),s.createElement("div",{className:"tcfColorInputPicker--value",key:"red"},s.createElement(Nn,{type:"red"}),s.createElement("div",{className:"tcfColorInputPicker--valueCaption"},"R")),s.createElement("div",{className:"tcfColorInputPicker--value",key:"green"},s.createElement(Nn,{type:"green"}),s.createElement("div",{className:"tcfColorInputPicker--valueCaption"},"G")),s.createElement("div",{className:"tcfColorInputPicker--value",key:"blue"},s.createElement(Nn,{type:"blue"}),s.createElement("div",{className:"tcfColorInputPicker--valueCaption"},"B"))]
e||n.push(s.createElement("div",{className:"tcfColorInputPicker--value",key:"alpha"},s.createElement(Nn,{type:"alpha"}),s.createElement("div",{className:"tcfColorInputPicker--valueCaption"},"A")))
let r=null
return t&&t.length&&(r=s.createElement("div",{className:"tcfColorInputPicker--presets"},t.map((e=>s.createElement(Ln,{className:"tcfColorInputPicker--presetsSwatch",color:e}))))),s.createElement("div",{className:"tcfColorInputPicker"},s.createElement(jn,null),s.createElement("div",{className:"tcfColorInputPicker--controls"},s.createElement("div",{className:"tcfColorInputPicker--sliders"},s.createElement(Mn,{type:"hue"}),e?null:s.createElement(Mn,{type:"alpha"})),s.createElement(Ln,{className:"tcfColorInputPicker--swatch"})),s.createElement("div",{className:"tcfColorInputPicker--values"},n),r)}class Pn extends s.Component{constructor(){super(...arguments),this.state={hasColorPicker:!1},this.handleChange=e=>{this.props.onChange(e)},this.handleSwatchClick=()=>{this.setState({hasColorPicker:!0})},this.handleOverlayClick=()=>{this.setState({hasColorPicker:!1})}}render(){const{hasColorPicker:e}=this.state,{color:t,disableAlpha:n,disabled:r,onChange:a,presetColors:i}=this.props
return s.createElement(xn,{color:t,onChange:a},s.createElement("div",{className:"tcfColorInput"},s.createElement(Ln,{className:"tcfColorInput--swatch",disabled:r,onClick:this.handleSwatchClick},e&&!r?s.createElement(Yt,{onClick:this.handleOverlayClick},s.createElement(An,{disableAlpha:n,presetColors:i})):null),s.createElement(Nn,{type:"hex"})))}}function Tn({data:e,disabled:t,field:n,onUpdate:r}){const a=vn(e)?e:{alpha:1,blue:255,green:255,red:255}
return s.createElement(Pn,{color:a,disableAlpha:!n.alpha,disabled:t,onChange:r,presetColors:n.swatches})}function $n({children:e,className:t,icon:n}){return s.createElement("div",{className:je()("tcfTextAndIcon",t)},s.createElement(He,{className:"tcfTextAndIcon--icon",name:n}),s.createElement(Pe,{className:"tcfTextAndIcon--text",value:e}))}function Rn({children:e,title:t}){return s.createElement("div",{className:"tcfErrorMessage"},s.createElement($n,{icon:"material:error"},t),e)}class Un extends s.Component{constructor(){super(...arguments),this.request=null,this.state={mode:"idle"},this.handleChange=e=>{this.updateOEmbed(),this.setState({mode:"typing"}),this.props.onUpdate(Object.assign(Object.assign({},this.getOEmbed()),{url:e.target.value}))},this.updateOEmbed=function(e,t,n){let s,r,a=null,i=null,l=null
function o(){const c=Date.now()-s
c<t&&c>=0?a=window.setTimeout(o,t-c):(a=null,n||(r=e.apply(l,i),a||(l=i=null)))}return function(){l=this,i=arguments,s=Date.now()
const c=n&&!a
return a||(a=window.setTimeout(o,t)),c&&(r=e.apply(l,i),l=i=null),r}}((()=>{this.setState({mode:"loading"})
const{apiEndpoint:e,model:t,field:n}=this.props,s={schema:t.__type,field:n.name,url:this.getOEmbed().url.replace(/\?/g,"___@CTF_URL_QUERY___")},r=new XMLHttpRequest
r.onreadystatechange=()=>this.handleRequestStateChange(r),r.onerror=()=>this.handleRequestError(),r.open("GET",B(e,s)),r.send(),this.request&&this.request.abort(),this.request=r}),500)}getOEmbed(){const{data:e}=this.props
return Vt(e)?e:{url:""}}handleRequestStateChange(e){if(e.readyState!==XMLHttpRequest.DONE)return
if(200!==e.status)return this.handleRequestError()
let t
try{t=JSON.parse(e.responseText)}catch(e){return this.handleRequestError()}this.setState({mode:"idle"}),this.request=null,this.props.onUpdate(Object.assign(Object.assign({},this.getOEmbed()),{info:t.data}))}handleRequestError(){this.setState({mode:"idle"}),this.request=null,this.props.onUpdate(Object.assign(Object.assign({},this.getOEmbed()),{info:null}))}render(){const e=this.getOEmbed(),{disabled:t}=this.props,{mode:n}=this.state
let r
if("typing"===n||"loading"===n)r=s.createElement("div",{className:"tcfOEmbedWidget--activity"},s.createElement("div",{className:"tcfOEmbedWidget--activityBounce first"}),s.createElement("div",{className:"tcfOEmbedWidget--activityBounce second"}),s.createElement("div",{className:"tcfOEmbedWidget--activityBounce third"}))
else if(e.info){const{title:t,author_name:n,thumbnail_url:a}=e.info
r=s.createElement("div",{className:"tcfOEmbedWidget--info"},a?s.createElement("div",{className:"tcfOEmbedWidget--infoImagePanel"},s.createElement("img",{className:"tcfOEmbedWidget--infoImage",src:a})):null,s.createElement("div",{className:"tcfOEmbedWidget--infoContent"},s.createElement("div",{className:"tcfOEmbedWidget--infoTitle"},t),s.createElement("div",{className:"tcfOEmbedWidget--infoAuthor"},n)))}else e.url&&(r=s.createElement(Rn,{title:"Invalid embed url"}))
return s.createElement("div",{className:"tcfOEmbedWidget"},s.createElement("div",{className:"tcfOEmbedWidget--input"},s.createElement("input",{autoComplete:"off",className:"text fullwidth",disabled:t,onChange:t?void 0:this.handleChange,value:e.url})),r)}}const Fn=(0,l.Ng)((e=>({apiEndpoint:e.config.apiEndpoints.oembed})))(Un)
class Dn{constructor(e){this.value=e}get author(){return this.value.info?this.value.info.author_name:""}get thumbnail(){const{info:e}=this.value
return e&&e.thumbnail_url?new ge.SafeString(`<img width="100" src=${e.thumbnail_url} />`):""}get title(){return this.value.info?this.value.info.title:""}toHTML(){const{info:e}=this.value
if(!e)return new ge.SafeString("")
let t=""
return e.thumbnail_url&&(t=`<img class="tcfOEmbedWidget--infoImage" src="${e.thumbnail_url}" />`),new ge.SafeString(`\n      <div class="tcfOEmbedWidget--info">\n        ${t}\n        <div class="tcfOEmbedWidget--infoContent">\n          <div class="tcfOEmbedWidget--infoTitle">${e.title}</div>\n          <div class="tcfOEmbedWidget--infoAuthor">${e.author_name}</div>\n        </div>\n      </div>\n    `)}}(0,W.Cg)([_t],Dn.prototype,"value",void 0),(0,W.Cg)([_t],Dn.prototype,"author",null),(0,W.Cg)([_t],Dn.prototype,"thumbnail",null),(0,W.Cg)([_t],Dn.prototype,"title",null),(0,W.Cg)([Ot],Dn.prototype,"toHTML",null)
function Vn({favorites:e,onSchema:t,onToggleFavorite:n,schemas:r}){const a=r.map((r=>{const a=-1!==e.indexOf(r.qualifier)
return s.createElement("div",{className:"tcfSchemaList--row",key:r.qualifier},s.createElement("div",{className:"tcfSchemaList--schema",onMouseUp:()=>t(r)},s.createElement(He,{className:"tcfSchemaList--schemaIcon",name:r.icon}),s.createElement("div",{className:"tcfSchemaList--schemaLabel"},r.label)),n?s.createElement("div",{className:"tcfSchemaList-favorite",onClick:()=>n(r)},s.createElement(He,{name:a?"material:star":"material:star_border"})):null)}))
return s.createElement("div",{className:"tcfSchemaList"},a)}function Hn({onCreate:e,schemas:t,scope:n}){const[r,a]=s.useState(!1),i=(0,l.wA)()
let o,c=[],u=null
if(n){const{favoriteSchemas:r}=(0,l.d4)((e=>e.user))
c=n in r?r[n]:[],c.length&&(u=t.filter((e=>-1!==c.indexOf(e.qualifier))).map((t=>s.createElement(Ie,{className:"tcfFactory--quickButton",key:t.qualifier,onClick:()=>e(t),secondary:!0},s.createElement(He,{name:t.icon}),s.createElement("div",null,t.label))))),o=e=>{i(function(e,t){return(n,s)=>{const{favoriteSchemas:r}=s().user
let a=e in r?r[e]:[]
a=-1===a.indexOf(t)?[...a,t]:a.filter((e=>e!==t)),n({type:"setUser",user:{favoriteSchemas:Object.assign(Object.assign({},r),{[e]:a})}})}}(n,e.qualifier))}}return s.createElement("div",{className:"tcfFactory multiple"},s.createElement(Ie,{className:"tcfFactory--primaryButton",onMouseDown:()=>a(!0)},s.createElement(He,{name:"plus"}),s.createElement(Pe,{value:"Create"}),r?s.createElement(Yt,{onClick:()=>a(!1)},s.createElement(Vn,{favorites:c,onSchema:t=>{a(!1),e(t)},onToggleFavorite:o,schemas:t})):null),u)}function Wn({onCreate:e,schema:t}){return s.createElement("div",{className:"tcfFactory"},s.createElement(Ie,{className:"tcfFactory--primaryButton",onClick:()=>e(t)},s.createElement(He,{name:"plus"}),s.createElement(Pe,{params:{schema:t.label},value:"Create {schema}"})))}function Bn({field:e,onCreate:t,scope:n}){const r=(0,l.d4)((e=>e.schemas)),a=e.schemas.map((e=>r[e])).sort(((e,t)=>e.label.localeCompare(t.label)))
if(!a.length)return null
const i=e=>{if(-1!==a.indexOf(e))return t(N({schemas:r,schema:e}))}
return a.length>1?s.createElement(Hn,{onCreate:i,schemas:a,scope:n}):s.createElement(Wn,{onCreate:i,schema:a[0]})}function zn({children:e,disabled:t,field:n,model:r}){const a=s.useContext(pt),i=(0,l.d4)((e=>e.schemas)),{isExpanded:o,toggleExpanded:c}=s.useContext(Me),u=i[r.__type],d=o(r.__uuid),m=u&&u.preview,h=()=>c(r.__uuid)
let p=null
return d?p=s.createElement("div",{className:"tcfArrayWidgetMember--body"},e):m&&(p=s.createElement(tn,{field:n,model:r,onClick:h})),s.createElement("div",{className:`tcfInstanceWidget--collapsiblePanel depth-${a}`},s.createElement(Zt,{disabled:t,field:n,hasPreview:!d&&!m,isCollapsible:!0,isExpanded:d,model:r,onToggleExpanded:h,schema:u}),s.createElement($t,{uri:d?"details":"summary"},p))}function qn({className:e,data:t,disabled:n,field:r,path:a}){const i=s.createElement(vt,{canChangeVisibility:!0,disabled:n,model:t,path:[...a,{type:"property",name:r.name}],schemaNames:r.schemas})
return r.collapsible&&c(t)?s.createElement(zn,{model:t,disabled:n,field:r},i):s.createElement("div",{className:je()("tcfInstanceWidget",e)},i)}function Xn(e){var{attribute:t,column:n,max:r,min:a,onUpdate:i}=e,l=(0,W.Tt)(e,["attribute","column","max","min","onUpdate"])
const[o,c]=s.useState(null),u=n[t],d=se(u,l),m=l.current.key in u
return s.createElement("div",{className:"tcfLayoutEditor--columnInput"},s.createElement("div",{className:je()("tcfLayoutEditor--columnInputLabel",{hasOwnValue:m})},(h=t).charAt(0).toUpperCase()+h.slice(1)),s.createElement(On,{className:"tcfLayoutEditor--columnInputField",max:r,min:a,onBlur:()=>c(null),onChange:function({target:e}){c(e.value)
const s=parseInt(e.value)
!isFinite(s)||"number"==typeof a&&s<a||"number"==typeof r&&s>r||i(n.__uuid,{[t]:ae(u,s,l)})},type:"number",value:null===o?d:o}))
var h}function Kn(e,t=0,n=1){return e<t?t:e>n?n:e}function Yn({columnsPerRow:e}){const t=[]
for(let n=0;n<e;n++)t.push(s.createElement("div",{className:"tcfLayoutPreview--gridColumn",key:n}))
return s.createElement("div",{className:"tcfLayoutPreview--grid"},t)}function Gn(e){const t=String.fromCharCode(65+e%25),n=Math.floor(e/25)
return g("Column {num}",{num:`${t}${n>1?n:""}`})}function Qn(e){var{columns:t,columnsPerRow:n,isSelected:r,onClick:a}=e,i=(0,W.Tt)(e,["columns","columnsPerRow","isSelected","onClick"])
return s.createElement("div",{className:je()("tcfLayoutPreview",{isClickable:!!a,isSelected:r}),onClick:a},s.createElement(Yn,{columnsPerRow:n}),t.map(((e,t)=>{const r=se(e.offset,i),a=se(e.order,i),l=se(e.width,i)
return s.createElement("div",{className:"tcfLayoutPreview--col",key:t,style:{marginLeft:`${(r/n*100).toFixed(6)}%`,order:a,width:`${(l/n*100).toFixed(6)}%`}},s.createElement("div",{className:"tcfLayoutPreview--colPanel"},Gn(t)))})))}class Jn extends s.Component{constructor(){super(...arguments),this.element=null,this.initialHandle=!1,this.initialPosition=0,this.isListening=!1,this.state={dragDelta:0,dragMode:"none"},this.handleMouseDown=e=>{this.initialHandle=!1,this.initialPosition=e.clientX,this.startListening()
let t=e.target
for(;t;){if(t.classList.contains("tcfLayoutRowEditor--colHandle")){this.initialHandle=!0
break}t=t.parentElement}},this.handleMouseMove=e=>{const{dragMode:t}=this.state,n=e.clientX-this.initialPosition
"none"===t&&Math.abs(n)>3&&(this.initialPosition=e.clientX,this.setState({dragDelta:0,dragMode:this.initialHandle?"size":"move"})),"none"!==t&&this.setState({dragDelta:n,dragMode:t})},this.handleMouseUp=()=>{const{column:e,onSelect:t}=this.props,{dragDelta:n,dragMode:s}=this.state,r=this.toColumns(n)
"size"===s?this.applySize(r):"move"===s?this.applyMove(r):t(e.__uuid),this.stopListening(),this.setState({dragDelta:0,dragMode:"none"})},this.setElement=e=>{this.element=e}}applyMove(e){const{props:t}=this,{column:n,columnsPerRow:s,onUpdate:r}=t,a=Kn(this.sample(n.offset)+e,0,s)
r(n.__uuid,{offset:ae(n.offset,a,t)})}applySize(e){const{props:t}=this,{column:n,constraints:{maxColumnWidth:s,minColumnWidth:r},onUpdate:a}=t,i=Kn(this.sample(n.width)+e,r,s)
a(n.__uuid,{width:ae(n.width,i,t)})}componentWillUnmount(){this.stopListening()}render(){const{dragDelta:e,dragMode:t}=this.state,{column:n,columnsPerRow:r,index:a,isSelected:i}=this.props,l=this.sample(n.offset),o=this.sample(n.width),c=this.sample(n.order)
let u=`${(o/r*100).toFixed(6)}%`,d=`${(l/r*100).toFixed(6)}%`
return"move"===t?d=`calc(${d} + ${e}px)`:"size"===t&&(u=`calc(${u} + ${e}px)`),s.createElement("div",{className:je()("tcfLayoutRowEditor--col",{isSelected:i}),onMouseDown:this.handleMouseDown,ref:this.setElement,style:{marginLeft:d,order:c,width:u}},s.createElement("div",{className:"tcfLayoutRowEditor--colPanel"},s.createElement("div",{className:"tcfLayoutRowEditor--colLabel"},Gn(a)),s.createElement("div",{className:"tcfLayoutRowEditor--colHandle"})))}sample(e){return se(e,this.props)}startListening(){this.isListening||(this.isListening=!0,document.addEventListener("mousemove",this.handleMouseMove),document.addEventListener("mouseup",this.handleMouseUp))}stopListening(){this.isListening=!1,document.removeEventListener("mousemove",this.handleMouseMove),document.removeEventListener("mouseup",this.handleMouseUp)}toColumns(e){const{element:t}=this,{columnsPerRow:n}=this.props,s=t?t.parentElement:null
if(!s)return 0
const r=s.offsetWidth/n
return Math.round(e/r)}}function Zn(e){var{columns:t,selected:n}=e,r=(0,W.Tt)(e,["columns","selected"])
const{columnsPerRow:a}=r
return s.createElement("div",{className:"tcfLayoutRowEditor"},s.createElement(Yn,{columnsPerRow:a}),t.map(((e,t)=>s.createElement(Jn,Object.assign({},r,{column:e,index:t,isSelected:null!==n&&n.__uuid===e.__uuid,key:e.__uuid})))))}const es={xs:"material:smartphone",sm:"material:tablet_mac",md:"material:tablet",lg:"material:laptop",xl:"material:desktop_mac"}
function ts(e){const{columnsPerRow:t,constraints:n,current:r,selected:a}=e
let i
if(a){const r={breakpoints:e.breakpoints,column:a,current:e.current,onUpdate:e.onUpdate}
i=s.createElement("div",{className:"tcfLayoutEditor--rowAttributes"},s.createElement(Xn,Object.assign({},r,{attribute:"width",max:Math.min(t,n.maxColumnWidth),min:Math.max(1,n.minColumnWidth)})),s.createElement(Xn,Object.assign({},r,{attribute:"offset",min:0,max:t})),s.createElement(Xn,Object.assign({},r,{attribute:"order"})))}else i=s.createElement("div",{className:"tcfLayoutEditor--rowAttributes"})
return s.createElement("div",{className:"tcfLayoutEditor--row"},s.createElement("div",{className:"tcfLayoutEditor--rowHead"},r.key in es?s.createElement(He,{name:es[r.key]}):null,s.createElement("span",null,r.label)),s.createElement("div",{className:"tcfLayoutEditor--rowBody"},s.createElement(Zn,Object.assign({},e)),i))}function ns(e){var{onClose:t,onCreate:n,onDelete:r}=e,a=(0,W.Tt)(e,["onClose","onCreate","onDelete"])
const{breakpoints:i,columns:l,constraints:{maxColumns:o,minColumns:c}}=a,[u,d]=s.useState(l.length?l[0].__uuid:null),m=u&&l.find((e=>e.__uuid===u))||null
function h(e){d(e===u?null:e)}return s.createElement(Ue,null,s.createElement(Ue.Content,null,s.createElement("div",{className:"tcfLayoutEditor--title"},s.createElement(Pe,{value:"Edit columns"})),i.map((e=>s.createElement(ts,Object.assign({},a,{current:e,key:e.key,selected:m,onSelect:h}))))),s.createElement(Ue.Footer,null,s.createElement("div",{className:"btngroup"},l.length<o?s.createElement(Ae,{onClick:()=>d(n())},s.createElement(He,{name:"plus"}),s.createElement(Pe,{value:"Create"})):null,m&&l.length>c?s.createElement(Ae,{onClick:()=>r(m.__uuid)},s.createElement(He,{name:"minus"}),s.createElement(Pe,{value:"Delete"})):null),s.createElement(Ae,{onClick:t,primary:!0},s.createElement(Pe,{value:"Close"}))))}function ss(e){var{onClose:t,onPreset:n,preset:r,presets:a}=e,i=(0,W.Tt)(e,["onClose","onPreset","preset","presets"])
return s.createElement(Yt,{onClick:t},s.createElement("div",{className:"tcfLayoutSelect--flyout"},a.map((e=>s.createElement(Qn,Object.assign({},i,{columns:e.columns,isSelected:e.key===r,key:e.key,onClick:()=>n(e)}))))))}function rs(e){var{canEdit:t,onPreset:n,preset:r,presets:a}=e,i=(0,W.Tt)(e,["canEdit","onPreset","preset","presets"])
const{breakpoints:l,columns:o,columnsPerRow:c}=i,[u,d]=s.useState(null),m=l[l.length-1]
function h(){d(null)}let p=null
return a.length?p="flyout":t&&(p="editor"),s.createElement("div",{className:"tcfLayoutSelect"},s.createElement("div",{className:"tcfLayoutSelect--widget"},s.createElement(Qn,{breakpoints:l,columns:o,columnsPerRow:c,current:m,onClick:p?()=>d(p):void 0}),"flyout"===u?s.createElement(ss,{breakpoints:i.breakpoints,columnsPerRow:i.columnsPerRow,current:m,onClose:h,onPreset:function(e){n(e),d(null)},preset:r,presets:a}):null),t?s.createElement("div",{className:"tcfLayoutSelect--edit",onClick:()=>d("editor")},s.createElement(He,{name:"material:edit"})):null,"editor"===u?s.createElement(bt,{onClick:h},s.createElement(ns,Object.assign({},i,{onClose:h}))):null)}class as extends s.Component{constructor(){super(...arguments),this.handleCreate=()=>{const{data:e,disabled:t,field:n,onUpdate:s}=this.props
if(!ie(e)||t||e.columns.length>=n.constraints.maxColumns)return null
const r=this.createColumn()
return s(Object.assign(Object.assign({},e),{columns:[...e.columns,r]})),r.__uuid},this.handleDelete=e=>{const{data:t,disabled:n,field:s,onUpdate:r}=this.props
!ie(t)||n||t.columns.length<=s.constraints.minColumns||r(Object.assign(Object.assign({},t),{columns:t.columns.filter((t=>t.__uuid!==e))}))},this.handlePreset=e=>{const{data:t,disabled:n,field:s,onUpdate:r,schemas:a}=this.props
if(n||!ie(t))return
const i=t.columns.map((e=>e.value))
r(Object.assign(Object.assign({},t),{preset:e.key,columns:e.columns.map(((e,t)=>te(s,a,e,i.length>t?i[t]:void 0)))}))},this.handleUpdate=(e,t)=>{const{data:n,disabled:s,onUpdate:r}=this.props
if(s||!ie(n))return
const a=Object.keys(t).every((e=>"value"===e))
r(Object.assign(Object.assign({},n),{preset:a?n.preset:null,columns:n.columns.map((n=>n.__uuid===e?Object.assign(Object.assign({},n),t):n))}))}}createColumn(){const{field:e,schemas:t}=this.props
return te(e,t)}createColumnValue(){const{field:e,schemas:t}=this.props
return ne(e,t)}render(){const{data:e,disabled:t,field:n,model:r,path:a,schemas:i}=this.props,l=re(n,i),o=this.context+1,{preset:c,columns:u}=ie(e)?e:{columns:[],preset:null}
return s.createElement("div",{className:"tcfLayoutWidget"},s.createElement(rs,{breakpoints:n.breakpoints,canEdit:n.canEdit,constraints:n.constraints,columns:u,columnsPerRow:n.columnsPerRow,onCreate:this.handleCreate,onDelete:this.handleDelete,onPreset:this.handlePreset,onUpdate:this.handleUpdate,preset:c,presets:n.presets}),s.createElement("div",{className:je()("tcfLayoutWidget--columns",{isStacked:u.length<=o})},u.map(((e,i)=>s.createElement(qe,{key:e.__uuid,label:Gn(i)},s.createElement(Je,{data:e.value,disabled:t,errors:null,field:l,model:r,onUpdate:t=>this.handleUpdate(e.__uuid,{value:t}),path:[...a,{name:n.name,type:"property"},{index:i,name:"columns",type:"index"}]}))))))}}as.contextType=et
const is=(0,l.Ng)(((e,t)=>({schemas:e.schemas})))(as)
function ls({data:e,disabled:t,onUpdate:n}){return s.createElement(ot,{disabled:t,onChange:n,value:!!e})}function os(e){const t=s.useRef(null)
return s.useEffect((()=>{const{current:n}=t
if(!n)return
const s=Ft()
for(const t of function(e){const{data:t,elementType:n,references:s}=e,r=[]
if(Array.isArray(t))for(const e of t){const t=s.find((t=>C(e,t)&&t.type===n))
t&&r.push(t)}return r}(e)){const r=E(t,e.viewMode)
n.append(r),s.load($(r))}}),[]),s.createElement("div",{className:"elementselect"},s.createElement("ul",{className:S(e.viewMode),ref:t}))}class cs extends s.Component{constructor(){super(...arguments),this.element=null,this.rendered=[],this.uuid=`element-${_()}`,this.instance=null,this.isRendering=!1,this.handleAdd=({elements:e})=>{const{onAddReferences:t}=this.props
this.handleChange(),t(e.map((e=>({id:e.id,siteId:e.siteId}))))},this.handleChange=()=>{if(this.isRendering)return
const{onUpdate:e}=this.props,t=this.getSelected()
this.rendered=t,e(t)},this.setElement=e=>{if(this.element===e)return
this.element=e
let{instance:t}=this
if(t&&(t.off("selectElements",this.handleAdd),t.off("removeElements",this.handleChange),t.elementSort&&t.elementSort.off("sortChange",this.handleChange),t.destroy(),this.instance=t=null),e){const{allowSelfReference:e,condition:n=null,criteria:s,elementType:r,limit:a=null,modalStorageKey:i=null,referenceElementId:l=null,referenceElementSiteId:o=null,showActionMenu:c=!0,showSiteMenu:u,sourceElementId:d,sources:m,viewMode:h="list"}=this.props
t=new Craft.BaseElementSelectInput({condition:n,criteria:s,elementType:r,id:this.uuid,limit:a,modalStorageKey:i,name:this.uuid,referenceElementId:l,referenceElementSiteId:o,showActionMenu:c,showSiteMenu:u,sources:m,sourceElementId:e?null:d,viewMode:"grid"==h?"cards":h}),this.instance=t,this.createReferences(),t.on("selectElements",this.handleAdd),t.on("removeElements",this.handleChange),t.elementSort&&t.elementSort.on("sortChange",this.handleChange)}}}componentDidUpdate(){const{rendered:e}=this,t=this.props.data||[]
t.length===e.length&&t.every(((t,n)=>C(t,e[n])))||this.createReferences()}createReferences(){const{instance:e}=this
if(!e)return
const{viewMode:t}=this.props,n=[]
this.isRendering=!0,e.$elementsContainer.empty()
for(const s of this.getStoredReferences()){const r=e.createNewElement({$element:$(E(s,t)),id:s.id,label:s.label})
r.find("input").prop("disabled",!0),e.appendElement(r),n.push({id:s.id,siteId:s.siteId})}e.resetElements(),this.rendered=n,this.isRendering=!1}getStoredReferences(){const{data:e,elementType:t,references:n}=this.props,s=[]
if(!Array.isArray(e))return s
for(const r of e){const e=n.find((e=>C(e,r)&&e.type===t))
e&&s.push(e)}return s}getSelected(){const{instance:e}=this
if(!e)return[]
const t=[],n=e.getElements(),s=e.getSelectedElementIds()
for(let e=0;e<n.length;e++){const r=n.eq(e),a=parseInt(r.data("id"));-1!==s.indexOf(a)&&t.push({id:a,siteId:parseInt(r.data("site-id"))})}return t}render(){return s.createElement("div",{id:this.uuid,className:"tcfElementSelect elementselect",ref:this.setElement},s.createElement("ul",{className:S(this.props.viewMode)}),s.createElement("div",{className:"flex flex-nowrap"},s.createElement("button",{className:"btn add icon dashed"},g("Choose")),s.createElement("div",{className:"spinner hidden"})))}}const us=(0,l.Ng)((e=>({references:e.config.references,sourceElementId:e.config.elementId})),(e=>({onAddReferences:t=>{e(z(t))}})))((function(e){return e.disabled?s.createElement(os,Object.assign({},e)):s.createElement(cs,Object.assign({},e))}))
let ds=0
function ms(e){var{className:t,suggestions:n}=e,r=(0,W.Tt)(e,["className","suggestions"])
const[a]=s.useState("tcfAutoCompleteList_"+ds++)
return s.createElement(s.Fragment,null,s.createElement("input",Object.assign({className:je()("tcfInput",t),list:a},r)),s.createElement("datalist",{id:a},n.map(((e,t)=>s.createElement("option",{key:t},e)))))}function hs(e){var{apiEndpoint:t}=e,n=(0,W.Tt)(e,["apiEndpoint"])
return new Promise(((e,s)=>{fetch(B(t,n)).then((e=>e.json())).then((t=>{!function(e){return"object"==typeof e&&!0===e.result&&Array.isArray(e.anchors)}(t)?s(t&&t.message?`${t.message}`:"An unknown error has occured."):e(t)})).catch((e=>{s(`${e}`)}))}))}const ps={anchors:[],options:[],suggestions:[]}
const fs=(0,l.Ng)((e=>({apiEndpoint:e.config.apiEndpoints.anchors,defaultSiteId:e.config.elementSiteId})))((function({apiEndpoint:e,defaultSiteId:t,disabled:n,elementId:r,mode:a,onChange:i,siteId:l,value:o}){const{options:c,suggestions:u}=function(e){const[t,n]=(0,s.useState)(ps)
return(0,s.useEffect)((()=>{n(ps),e.elementId&&hs(e).then((({anchors:e})=>{n({anchors:e,options:e.map((e=>({key:e.id?e.id:e.anchor,label:e.title||e.anchor}))),suggestions:e.map((e=>e.anchor))})}))}),[e.siteId,e.elementId]),t}({apiEndpoint:e,elementId:r,siteId:l||t})
return"select"===a?s.createElement(Ke,{allowUndecided:!0,className:"tcfLinkWidget--hashEditorSelectWrap",disabled:n,onChange:e=>i(null===e?"":e),options:c,selectClassName:"tcfLinkWidget--hashEditorSelect",value:o}):s.createElement(ms,{disabled:n,onChange:e=>i(e.currentTarget.value),suggestions:u,value:o})}))
function gs({disabled:e,link:t,linkType:n,modalStorageKey:r=null,onUpdate:a}){const i=t.elementId?[{id:t.elementId,siteId:t.siteId}]:[]
return s.createElement("div",{className:"tcfLinkWidget--editor"},s.createElement(us,{allowSelfReference:n.allowSelf,criteria:n.criteria,data:i,disabled:e,elementType:n.elementType,limit:1,modalStorageKey:r,onUpdate:e=>a(Object.assign(Object.assign({},t),{elementId:e.length?e[0].id:0,siteId:e.length?e[0].siteId:0})),showSiteMenu:n.showSiteMenu,sources:n.sources,viewMode:"list"}),n.allowHash?s.createElement("div",{className:"tcfLinkWidget--editorHash tcfInput--group"},s.createElement("div",{className:"tcfInput--groupLabel"},"#"),s.createElement(fs,{disabled:e,elementId:t.elementId,mode:n.allowHash,onChange:e=>a(Object.assign(Object.assign({},t),{hash:e})),siteId:t.siteId,value:t.hash})):null)}function ys({disabled:e,link:t,linkType:n,onUpdate:r}){return s.createElement("div",{className:"tcfLinkWidget--editor"},s.createElement(On,{disabled:e,type:n.inputType,value:t.url,onChange:e=>r(Object.assign(Object.assign({},t),{url:e.currentTarget.value}))}))}function vs(e){return"object"==typeof e&&"number"==typeof e.elementId&&"string"==typeof e.hash&&"string"==typeof e.type&&"string"==typeof e.url}function bs({data:e,disabled:t,field:n,model:r,onUpdate:a}){let i
i=vs(e)?e:{elementId:0,hash:"",openInNewWindow:!1,siteId:0,type:"",url:""}
const l=n.linkTypes[i.type]
let o
l&&"input"===l.type?o=s.createElement(ys,{disabled:t,key:i.type,link:i,linkType:l,onUpdate:a}):l&&"element"===l.type&&(o=s.createElement(gs,{disabled:t,key:i.type,link:i,linkType:l,modalStorageKey:`tcf_${r.__type}_${n.name}_${l.type}`,onUpdate:a}))
const{allowNewWindow:c}=n
return s.createElement("div",{className:"tcfLinkWidget"},s.createElement("div",{className:"tcfLinkWidget--type"},s.createElement(Ke,{disabled:t,options:Object.keys(n.linkTypes).map((e=>({key:e,label:n.linkTypes[e].label}))),value:i.type,onChange:e=>a(Object.assign(Object.assign({},i),{type:e}))})),o,c?s.createElement(dn,{disabled:t,onChange:e=>a(Object.assign(Object.assign({},i),{openInNewWindow:e})),value:i.openInNewWindow},s.createElement(Pe,{value:"New window"})):null)}function Es(e,t,n){return(0,W.sH)(this,arguments,void 0,(function*(e,t,{config:n,references:s,sourceSiteId:r,targetSiteId:a}){if(t!==r||!a)return t
if(!s.find((t=>t.id===e&&t.siteId===a)))try{const t=yield fetch(B(n.apiEndpoints.reference,{id:e,siteId:a}))
s.push(yield t.json())}catch(e){return t}return a}))}class ws{constructor(e){this.latitude=e.latitude,this.longitude=e.longitude}createStaticMap(e=100,t=75){const{latitude:n,longitude:s}=this,r=ve
if(!r)return new ge.SafeString("")
const a=B("https://maps.googleapis.com/maps/api/staticmap",{key:r,center:`${n},${s}`,markers:`size:small|${n},${s}`,size:`${e}x${t}`,zoom:15,maptype:"roadmap"})
return new ge.SafeString(`\n      <img src="${a}" width="${e}" height="${t}" />\n    `)}toHTML(){return this.createStaticMap()}}function Cs({results:e,onSelect:t}){return s.createElement("div",{className:""},e.map((e=>s.createElement("div",{onClick:()=>t(e)},e.formatted_address))))}(0,W.Cg)([_t],ws.prototype,"latitude",void 0),(0,W.Cg)([_t],ws.prototype,"longitude",void 0),(0,W.Cg)([Ot],ws.prototype,"createStaticMap",null),(0,W.Cg)([Ot],ws.prototype,"toHTML",null)
const Ss=["address","street","country","zip","city"]
class xs extends s.Component{constructor(){super(...arguments),this.autocomplete=null,this.input=null,this.state={isSearching:!1},this.handlePlaceChanged=()=>{const{autocomplete:e}=this
if(!e)return
const t=e.getPlace()
t.geometry&&this.props.onLocation({latitude:t.geometry.location.lat(),longitude:t.geometry.location.lng()})},this.handleResolve=()=>{const{places:e}=this.props
e&&(this.setState({isSearching:!0}),e.findPlaceFromQuery({query:this.getResolveQuery(),fields:["formatted_address","geometry"]},this.handleResolveResults))},this.handleResolveResults=e=>{this.setState({isSearching:!1}),e||(e=[]),1===e.length?this.handleResultsSelect(e[0]):this.setState({results:e})},this.handleResultsSelect=({geometry:e})=>{if(!e)return
const{location:t}=e
this.props.onLocation({latitude:t.lat(),longitude:t.lng()}),this.handleResultsCancel()},this.handleResultsCancel=()=>{this.state.results&&this.setState({results:void 0})},this.setInput=e=>{let{autocomplete:t}=this
this.input=e,t&&(t.unbindAll(),t=null),e&&(t=new google.maps.places.Autocomplete(e),t.setFields(["geometry"]),t.addListener("place_changed",this.handlePlaceChanged)),this.autocomplete=t}}canResolve(){return""!==this.getResolveQuery()}getResolveQuery(){const{model:e}=this.props,t=[]
for(const n of Ss)n in e&&"string"==typeof e[n]&&t.push(e[n].trim())
return t.join(", ")}render(){let e
if(this.canResolve()){const{results:t}=this.state
let n
t&&0===t.length?n=s.createElement($n,{icon:"material:error"},"No locations found"):t&&(n=s.createElement(Cs,{onSelect:this.handleResultsSelect,results:t})),e=s.createElement("div",{className:"tcfLocationFieldSearch--resolve"},n?s.createElement(Yt,{onClick:this.handleResultsCancel},n):null,s.createElement(Ae,{onClick:this.handleResolve},s.createElement(Pe,{value:"Resolve address"})))}return s.createElement("div",{className:"tcfLocationFieldSearch"},e,s.createElement("input",{className:"tcfLocationFieldSearch--input tcfInput",ref:this.setInput,type:"search"}))}}function Os(e){return"object"==typeof e&&"number"==typeof e.latitude&&"number"==typeof e.longitude}var _s
!function(e){e[e.Loading=0]="Loading",e[e.Error=1]="Error",e[e.Ready=2]="Ready"}(_s||(_s={}))
class Ns extends s.Component{constructor(){super(...arguments),this.element=null,this.marker=null,this.state={instance:null,loadState:_s.Loading},this.handleLocation=e=>{const{instance:t}=this.state
t&&(t.map.setZoom(17),t.map.setCenter({lat:e.latitude,lng:e.longitude})),this.props.onUpdate(e)},this.handleMarkerDragEnd=()=>{const{marker:e}=this
if(!e)return
const t=e.getPosition()
t&&this.props.onUpdate({latitude:t.lat(),longitude:t.lng()})},this.setElement=e=>{const{disabled:t}=this.props
let{instance:n}=this.state,{marker:s}=this
if(n&&(Ns.stashInstance(n),n=null),s&&(s.setMap(null),s.unbindAll(),s=null),e){n=Ns.createInstance(),e.appendChild(n.element)
const{map:r}=n
r.setZoom(17),r.setCenter(this.getLatLng()),s=new google.maps.Marker({draggable:!t,position:this.getLatLng(),map:r}),s.addListener("dragend",this.handleMarkerDragEnd)}this.element=e,this.marker=s,this.setState({instance:n})}}componentDidUpdate(e){const{marker:t}=this
e.disabled!==this.props.disabled&&t&&t.setOptions({draggable:!this.props.disabled})}componentWillMount(){try{(be||(be=new Promise((e=>{window.onGoogleMapsReady=()=>{Ee=fe.Loaded,e(google.maps)}
const t=document.createElement("script")
t.src=`https://maps.googleapis.com/maps/api/js?key=${ve}&libraries=places&callback=onGoogleMapsReady`,(document.head||document.body).appendChild(t),Ee=fe.Loading})))).then((()=>{this.setState({loadState:_s.Ready})}))}catch(e){this.setState({loadState:_s.Error})}}getLatLng(){const{data:e}=this.props
return Os(e)?{lat:e.latitude,lng:e.longitude}:{lat:0,lng:0}}render(){const{loadState:e,instance:t}=this.state,{disabled:n,model:r}=this.props,{marker:a}=this
let i
return a&&a.setPosition(this.getLatLng()),i=e===_s.Loading?s.createElement(dt,null):e===_s.Error?s.createElement(Rn,{title:"Could not load Google Maps"}):s.createElement(s.Fragment,null,n?null:s.createElement(xs,{model:r,onLocation:this.handleLocation,places:t?t.places:null}),s.createElement("div",{className:"tcfLocation--map",ref:this.setElement})),s.createElement("div",{className:"tcfLocation"},i)}static createInstance(){let e=this.instanceStash.pop()
if(!e){const t=document.createElement("div")
t.className="tcfLocation--mapInstance"
const n=new google.maps.Map(t,{mapTypeControl:!1,streetViewControl:!1})
e={element:t,map:n,places:new google.maps.places.PlacesService(n)}}return e}static stashInstance(e){const{element:t}=e,{parentElement:n}=t
n&&n.removeChild(t),this.instanceStash.push(e)}}Ns.instanceStash=[]
const ks=Ns
function js({data:e,disabled:t,errors:n,field:r,onUpdate:a}){const[i,l]=s.useState(!1),[o,c]=s.useState(e),{max:u,min:d,placeholder:m,unit:h}=r,p=i?o:e
const f=s.createElement("input",{autoComplete:"off",className:je()("tcfNumberWidget--input text fullwidth",{error:n&&n.length}),disabled:t,max:null===u?void 0:u,min:null===d?void 0:d,onBlur:function(){l(!1),c(e)},onChange:function(e){const{value:t}=e.target
c(t),a(function({dataType:e,defaultValue:t,max:n,min:s,optional:r},a){let i="integer"===e?parseInt(a):parseFloat(a)
if(isFinite(i))"number"==typeof n&&i>n&&(i=n),"number"==typeof s&&i<s&&(i=s)
else{if(r)return null
i=t}return i}(r,t))},onFocus:function(){l(!0)},placeholder:m,type:"number",value:p})
return h?s.createElement("div",{className:"tcfNumberWidget"},f,s.createElement("div",{className:"tcfNumberWidget--unit"},h)):f}class Is extends cn{cloneValue(e){return(0,W.sH)(this,void 0,void 0,(function*(){const{field:t,schemas:n,value:s}=e
return this.isValue(t,s)?s:this.createValue({field:t,schemas:n})}))}createValue({field:e}){return e.defaultValue}isValue({optional:e},t){return!(!e||null!==t)||("number"==typeof t||t instanceof Number)}preview({value:e}){return e}}class Ms{constructor(e){this.value=e}get summary(){return new ge.SafeString(`<div class="snippet">${this.value}</div>`)}toHTML(){return new ge.SafeString(this.value)}}function Ls({value:e}){return s.createElement("div",{className:"redactor-box redactor-styles-on redactor-toolbar-on focusable-input redactor-focus focus"},s.createElement("div",{className:"redactor-styles redactor-in redactor-in-0",dangerouslySetInnerHTML:{__html:e}}))}(0,W.Cg)([_t],Ms.prototype,"value",void 0),(0,W.Cg)([_t],Ms.prototype,"summary",null),(0,W.Cg)([Ot],Ms.prototype,"toHTML",null)
class As extends s.Component{constructor(){super(...arguments),this.element=null,this.hasFocus=!1,this.instance=null,this.renderedValue="",this.uuid=`element-${_()}`,this.handleBlur=()=>{this.hasFocus=!1},this.handleChange=(e,...t)=>{this.hasFocus&&(this.renderedValue=e,this.props.onUpdate(e))},this.handleFocus=()=>{this.hasFocus=!0},this.setElement=e=>{if(this.element===e)return
this.element=e
const{elementSiteId:t,options:n}=this.props
let{instance:s}=this
s&&(s.redactor&&(s.redactor.off("blur",this.handleBlur),s.redactor.off("changed",this.handleChange),s.redactor.off("focus",this.handleFocus)),s.destroy(),s=null),e&&(s=new Craft.RedactorInput(Object.assign(Object.assign({},n),{elementSiteId:t,id:this.uuid,redactorConfig:Object.assign({},n.redactorConfig)})),e.removeAttribute("name"),s.redactor&&(s.redactor.on("blur",this.handleBlur),s.redactor.on("changed",this.handleChange),s.redactor.on("focus",this.handleFocus))),this.instance=s}}componentDidUpdate(){const{hasFocus:e,instance:t,props:n,renderedValue:s}=this
t&&!e&&n.value!=s&&(this.renderedValue=n.value,t.redactor.source.setCode(n.value))}render(){const{value:e}=this.props
return s.createElement("div",{className:"tcfRedactorWidget"},s.createElement("textarea",{defaultValue:"string"==typeof e?e:"",id:this.uuid,ref:this.setElement}))}}function Ps(e){return e.disabled?s.createElement(Ls,Object.assign({},e)):s.createElement(As,Object.assign({},e))}const Ts=(0,l.Ng)((e=>({elementSiteId:e.config.elementSiteId})))((function({data:e,disabled:t,elementSiteId:n,field:r,onUpdate:a}){return r.redactor?s.createElement(Ps,{disabled:t,elementSiteId:n,onUpdate:a,options:r.redactor,value:e}):null}))
class $s{constructor(e){this.reference=e}createPreview(e="large",t=!0){const n=E(this.reference,"large"===e?"large":"list")
if(!n)return""
n.classList.remove("removable")
const s=$(n).find(".thumb")
if(s.length){let t=s.find("img")[0]
t||(t=document.createElement("img"),t.srcset=s.attr("data-srcset")||"",s.append(t)),t.sizes="small"===e?"30px":"100px"}return t?`<div class="tcfInstancePreview--thumb ${e}">${s?s.html():""}</div>`:n.outerHTML}createSafePreview(e="large",t=!0){return new ge.SafeString(this.createPreview(e,t))}get asBackground(){const e=E(this.reference,"large")
if(!e)return null
const t=$(e).find(".elementthumb").attr("data-srcset")
if(!t)return null
const n=t.split(",").pop()
return n?new ge.SafeString(`<div class="tcfInstancePreview--background" style="background-image: url('${n.trim()}');"></div><div class="tcfInstancePreview--background blur" style="background-image: url('${n.trim()}');"></div>`):null}get asLargeElement(){return this.createSafePreview("large",!1)}get asLargeImage(){return this.createSafePreview("large",!0)}get asSmallElement(){return this.createSafePreview("small",!1)}get asSmallImage(){return this.createSafePreview("small",!0)}get label(){return this.reference.label}toHTML(){return new ge.SafeString(this.toString())}toString(){return this.createPreview()}}(0,W.Cg)([_t],$s.prototype,"reference",void 0),(0,W.Cg)([Ot],$s.prototype,"createPreview",null),(0,W.Cg)([Ot],$s.prototype,"createSafePreview",null),(0,W.Cg)([_t],$s.prototype,"asBackground",null),(0,W.Cg)([_t],$s.prototype,"asLargeElement",null),(0,W.Cg)([_t],$s.prototype,"asLargeImage",null),(0,W.Cg)([_t],$s.prototype,"asSmallElement",null),(0,W.Cg)([_t],$s.prototype,"asSmallImage",null),(0,W.Cg)([_t],$s.prototype,"label",null),(0,W.Cg)([Ot],$s.prototype,"toHTML",null),(0,W.Cg)([Ot],$s.prototype,"toString",null)
class Rs extends Array{constructor(e){super(...function({context:{references:e},field:t,value:n}){const s=[]
if(!t)return s
const{elementType:r}=t
for(const t of n){const n=e.find((e=>C(e,t)&&e.type===r))
n&&s.push(new $s(n))}return s}(e))}get asBackground(){return this.length?this[0].asBackground:null}get asLargeElement(){return this.length?this[0].asLargeElement:null}get asLargeImage(){return this.length?this[0].asLargeImage:null}get asSmallElement(){return this.length?this[0].asSmallElement:null}get asSmallImage(){return this.length?this[0].asSmallImage:null}get firstLabel(){return this.length?this[0].label:""}get label(){return this._map((e=>e.label)).join(", ")}toHTML(){return new ge.SafeString(`<div class="tcfInstancePreview--elements">${this.toString()}</div>`)}toString(){return this._map((e=>Ct(e))).join("")}_map(e){const t=[]
for(let n=0;n<this.length;n++)t.push(e(this[n],n))
return t}}function Us({data:e,disabled:t,field:n,model:r,onUpdate:a}){return s.createElement(us,{allowSelfReference:n.allowSelfReference,condition:n.condition,criteria:n.criteria,disabled:t,data:e,elementType:n.elementType,limit:n.limit||null,modalStorageKey:n.modalStorageKey||`tcf_${r.__type}_${n.name}`,onUpdate:a,referenceElementId:n.referenceElementId,referenceElementSiteId:n.referenceElementSiteId,showSiteMenu:n.showSiteMenu,sources:n.sources||null,viewMode:n.viewMode})}(0,W.Cg)([_t],Rs.prototype,"asBackground",null),(0,W.Cg)([_t],Rs.prototype,"asLargeElement",null),(0,W.Cg)([_t],Rs.prototype,"asLargeImage",null),(0,W.Cg)([_t],Rs.prototype,"asSmallElement",null),(0,W.Cg)([_t],Rs.prototype,"asSmallImage",null),(0,W.Cg)([_t],Rs.prototype,"firstLabel",null),(0,W.Cg)([_t],Rs.prototype,"label",null),(0,W.Cg)([Ot],Rs.prototype,"toHTML",null),(0,W.Cg)([Ot],Rs.prototype,"toString",null)
class Fs extends cn{createValue({field:e}){return e.defaultValue&&this.isValue(e,e.defaultValue)?e.defaultValue:e.options[0].key}isValue(e,t){return e.options.some((e=>e.key==t))}preview({field:e,value:t}){const n=e?e.options.find((e=>e.key===t)):void 0
return n?n.label:"-"}}function Ds({data:e,disabled:t,onUpdate:n,field:r}){return s.createElement(Ke,{disabled:t,onChange:n,options:r.options,value:e})}function Vs(e){let t
return e&&(t="color"in e?e.color:e.label),"string"==typeof t?t:"transparent"}class Hs extends s.Component{constructor(){super(...arguments),this.state={isExpanded:!1},this.handleFlyoutClick=()=>{this.setState({isExpanded:!1})},this.handleSelect=e=>{this.props.onUpdate(e.key),this.setState({isExpanded:!1})},this.handleSwatchClick=e=>{e.currentTarget===e.target&&this.setState({isExpanded:!0})}}render(){const{data:e,disabled:t,field:n}=this.props,{isExpanded:r}=this.state,a=n.options.find((t=>t.key===e))
return s.createElement("div",{className:je()("tcfSwatchColorWidget",{isUndecided:!a}),onClick:t?void 0:this.handleSwatchClick,style:{background:a?Vs(a):void 0}},r&&!t?this.renderFlyout(a):null)}renderFlyout(e){const{field:t}=this.props
return s.createElement(Yt,{onClick:this.handleFlyoutClick},s.createElement("div",{className:"tcfSwatchColorWidget--swatches"},t.options.map((t=>s.createElement("div",{className:je()("tcfSwatchColorWidget--swatch",{isSelected:t===e}),key:t.key,onClick:()=>this.handleSelect(t),style:{background:Vs(t)}})))))}}function Ws({data:e,disabled:t,errors:n,field:{maxLength:r,minLength:a,placeholder:i,inputType:l},onUpdate:o}){return s.createElement("input",{autoComplete:"off",className:je()("tcfTextWidget text fullwidth",{error:n&&n.length}),disabled:t,maxLength:r,minLength:a,onChange:e=>o(e.target.value),placeholder:i,type:l,value:e?`${e}`:""})}function Bs({data:e,disabled:t,field:{maxLength:n,minLength:r,monospace:a,placeholder:i,rows:l},onUpdate:o}){return s.createElement("textarea",{className:je()("tcfTextareaWidget text fullwidth",{monospace:a}),disabled:t,maxLength:n,minLength:r,onChange:e=>o(e.target.value),placeholder:i,rows:l,value:e})}function zs(e,t){const n=[],s=d(e,t.__uuid)
if(!s)return n
const{path:r}=s
let a,i=e.model
for(;i&&(a=r.shift());)c(i)&&n.push(i),i=h(i,a)
return n}function qs(e){return e.replace(/[.*+?^${}()|[\]\\]/g,"\\$&")}function Xs(e){const t=e.indexOf(":")
let n,s=-1===t?e.trim():e.substring(t+1).trim()
return n=-1===t?"template:":e.substring(0,t+1),s=function(e,t){return"template:"===t&&(e=e.replace(/\\/,"/")).endsWith(".twig")&&(e=e.substring(0,e.length-5)),e}(s,n),{loader:n,name:s,uri:`${n}${s}`}}function Ks(e){const t=e.split("*").map(qs).join("[A-Za-z0-9-_]+")
return new RegExp(`/^${t}$/`)}const Ys=[{prefix:"\\\\",handler:function(e,t,n){return t.reduce(((t,s)=>{const r=zs(e,s.model).reverse(),a=r.findIndex((e=>function(e,t){const n=Xs(e)
for(const e of Array.isArray(t)?t:t.split(",")){const t=Xs(e)
if(n.uri==t.uri)return!0
if(t.loader==n.loader&&-1!==t.name.indexOf("*")&&Ks(t.name).test(n.name))return!0}return!1}(e.__type,n)))
return-1===a?t:[...t,{model:r[a],distance:s.distance+a}]}),[])}},{prefix:"\\",handler:function(e,t,n){return t.reduce(((e,t)=>e),[])}}]
function Gs(e,t,n){const s=n.lastIndexOf(".")
if(-1===s)return console.error(`Missing field: ${n}`),null
const r=n.substring(s+1),a=function(e,t,n){let s=[{distance:0,model:t}]
e:for(;n.length;){for(const{prefix:t,handler:r}of Ys){if(!n.startsWith(t))continue
const a=(n=n.substring(t.length)).indexOf("\\"),i=-1==a?n:n.substring(0,a)
s=r(e,s,i),n=n.substring(i.length)
continue e}return console.error(`Invalid query: ${n}`),null}return s.sort(((e,t)=>e.distance-t.distance)),s.length?s[0].model:null}(e,t,n.substring(0,s))
return a&&r in a?a[r]:null}const Qs=function(){const e=document?document.currentScript:null
return e&&"src"in e?function(e){const t=e.lastIndexOf("/")
return-1!==t?e.substring(0,t):e}(e.src):""}(),Js=[],Zs=`${Qs}/images/empty-pattern.webp`,er={editUrl:Zs,height:500,listeners:[],previewUrl:Zs,url:Zs,width:500}
function tr(e,t,n){const[r,a]=(0,s.useState)(er),i=function(e,t,n){let s=null
for(const r of n){const n=Gs(e,t,r)
if(null!=n){s=Array.isArray(n)?n[0]:n
break}}if(!w(s))return null
const r=e.config.references.find((e=>C(e,s)))
return r&&"craft\\elements\\Asset"===r.type?r:null}(e,t,n)
let l
return i&&(l=Js.find((e=>e.url===i.url)),l||(l=function(e,t){const n=B(e.config.apiEndpoints.hotspotAsset,{id:t.id,siteId:t.siteId})
fetch(n).then((e=>e.json())).then((e=>{Object.assign(s,e)
for(const e of s.listeners)e()}))
const s={editUrl:t.url,height:0,listeners:[],previewUrl:t.url,url:t.url,width:0}
return Js.push(s),s}(e,i))),(0,s.useEffect)((()=>{if(l){if(!l.width)return function(e,t){return e.listeners.push(t),()=>{const n=e.listeners.indexOf(t);-1!==n&&e.listeners.splice(n,1)}}(l,(()=>a(l)))
a(l)}else a(er)}),[l]),r}const nr=16,sr={scale:(e,t)=>Object.assign(Object.assign({},e),{x:e.x+t.x,y:e.y+t.y}),toBounds:(e,t)=>({height:2*nr,width:2*nr,x:t.x*e.width-nr,y:t.y*e.height-nr})}
function rr(e){const t={x:e.clientX,y:e.clientY}
let n=e.target
for(;n;){if("svg"===n.nodeName){const e=n.getBoundingClientRect()
t.x-=e.left,t.y-=e.top
break}n=n.parentElement}return t}function ar(e){return Array.isArray(e)&&e.every(ir)}function ir(e){return e&&"object"==typeof e&&"type"in e&&"uuid"in e}function lr(e,t,n){const r=(0,s.useRef)(n)
r.current=n,(0,s.useEffect)((()=>{const n=e=>r.current(e)
return e.addEventListener(t,n),()=>{e.removeEventListener(t,n)}}),[])}function or(e,t,n=null){const s=n?1/n.width:1,r=n?1/n.height:1
return{height:Math.abs(e.y-t.y)*r,width:Math.abs(e.x-t.x)*s,x:Math.min(e.x,t.x)*s,y:Math.min(e.y,t.y)*r}}function cr(e){const[t,n]=s.useState({active:!1,from:{x:0,y:0},to:{x:0,y:0}})
return lr(window,"pointerup",(()=>{t.active&&(e.onTool(null),e.onChange([...e.shapes,Object.assign(Object.assign({},or(t.from,t.to,e.viewport)),{type:"rectangle",uuid:_()})]))})),s.createElement("g",null,t.active?s.createElement("rect",Object.assign({className:"tcfHotspotEditor__shapeRectangle"},or(t.from,t.to))):null,s.createElement("rect",{fillOpacity:"0",x:"0",y:"0",width:"100%",height:"100%",onPointerDown:function(e){const t=rr(e)
n((e=>Object.assign(Object.assign({},e),{active:!0,from:t,to:t})))},onPointerMove:function(e){n((t=>Object.assign(Object.assign({},t),{to:rr(e)})))}}))}function ur(e,t){return{x:e.x+e.width*t.x,y:e.y+e.height*t.y}}const dr={scale(e,t,n){const s=ur(e,n),r=ur(e,{x:(a=n).x?0:1,y:a.y?0:1})
var a
return s.x+=t.x,s.y+=t.y,Object.assign(Object.assign({},e),or(s,r))},toBounds(e,t,n){const s=t.height*e.height,r=t.width*e.width,a=n?0:Math.max(0,32-r),i=n?0:Math.max(0,32-s)
return{height:s+i,width:r+a,x:t.x*e.width-.5*a,y:t.y*e.height-.5*i}}}
const mr={point:function({isPreview:e,onSelect:t,shape:n,viewport:r}){return s.createElement("circle",{className:"tcfHotspotEditor__shapePoint",cx:n.x*r.width,cy:n.y*r.height,onPointerDown:t?e=>t(n,{x:e.screenX,y:e.screenY}):void 0,r:e?5:nr})},rectangle:function({isPreview:e,onSelect:t,shape:n,viewport:r}){return s.createElement("rect",Object.assign({className:"tcfHotspotEditor__shapeRectangle",onPointerDown:t?e=>t(n,{x:e.screenX,y:e.screenY}):void 0},dr.toBounds(r,n,e)))}},hr={point:sr,rectangle:dr}
function pr(e,t){return e.map((e=>s.createElement(mr[e.type],Object.assign(Object.assign({},t),{key:e.uuid,shape:e}))))}function fr(e){var{children:t}=e,n=(0,W.Tt)(e,["children"])
const r=s.useRef(null)
return s.useLayoutEffect((()=>{const{current:e}=r
e&&e.showModal()}),[]),s.createElement("dialog",Object.assign({},n,{className:"tcfHotspotEditor__dialog",ref:r}),s.createElement("button",{className:"tcfHotspotEditor__dialogCloser",onClick:n.onClose},s.createElement(He,{name:"material:close"})),t)}const gr=s.forwardRef(((e,t)=>{var{children:n,onImagePointerDown:r,url:a}=e,i=(0,W.Tt)(e,["children","onImagePointerDown","url"])
return s.createElement("svg",Object.assign({},i,{ref:t}),s.createElement("image",{href:a,height:i.height,onPointerDown:r,width:i.width}),n)}))
function yr(e){const[t,n]=s.useState({active:!1,x:0,y:0})
return lr(window,"pointerup",(()=>{t.active&&(e.onTool(null),e.onChange([...e.shapes,{type:"point",uuid:_(),x:t.x/e.viewport.width,y:t.y/e.viewport.height}]))})),s.createElement("g",null,t.active?s.createElement("circle",{className:"tcfHotspotEditor__shapePoint",r:nr,cx:t.x,cy:t.y}):null,s.createElement("rect",{fillOpacity:"0",x:"0",y:"0",width:"100%",height:"100%",onPointerDown:function(e){n((t=>Object.assign(Object.assign(Object.assign({},t),rr(e)),{active:!0})))},onPointerMove:function(e){n((t=>Object.assign(Object.assign({},t),rr(e))))}}))}function vr({allowCreate:e,allowDelete:t,allowedShapes:n,currentTool:r,onChange:a,onTool:i}){function l(e){return!n||n.some((t=>t===e))}return s.createElement("div",{className:"tcfHotspotEditor__toolbar"},l("point")?s.createElement("button",{className:je()("tcfHotspotEditor__toolbarButton",{active:r===yr}),disabled:!e,type:"button",onClick:()=>i({Component:yr,props:{}})},s.createElement(He,{name:"material:gps_fixed"}),s.createElement("span",null,"Hotspot")):null,l("rectangle")?s.createElement("button",{className:je()("tcfHotspotEditor__toolbarButton",{active:r===cr}),disabled:!e,type:"button",onClick:()=>i({Component:cr,props:{}})},s.createElement(He,{name:"material:crop"}),s.createElement("span",null,"Ausschnitt")):null,s.createElement("button",{className:"tcfHotspotEditor__toolbarButton",disabled:!t,type:"button",onClick:()=>{i(null),a([])}},s.createElement(He,{name:"material:delete"}),s.createElement("span",null,"Alle löschen")))}const br=12,Er=[{x:0,y:0},{x:1,y:0},{x:0,y:1},{x:1,y:1}]
function wr(e){const t=e.shapes.find((t=>t.uuid===e.uuid))
if(!t)return null
const{viewport:n}=e,r=function(e){return hr[e.type]}(t),a=r.toBounds(n,t),[i,l]=s.useState({handle:{x:0,y:0},mode:e.origin?"translate":null,origin:e.origin||{x:0,y:0},shape:t}),o=t=>{e.onChange([...e.shapes.filter((e=>e.uuid!==i.shape.uuid)),...t?[t]:[]])}
return lr(e.svg,"pointermove",(({screenX:e,screenY:t})=>{const{origin:s,shape:a}=i,l=(e-s.x)/n.width,c=(t-s.y)/n.height
"translate"===i.mode?o(Object.assign(Object.assign({},a),{x:a.x+l,y:a.y+c})):"scale"===i.mode&&o(r.scale(a,{x:l,y:c},i.handle))})),lr(window,"pointerup",(()=>{l((e=>Object.assign(Object.assign({},e),{mode:null})))})),lr(window,"keydown",(({key:t})=>{"Delete"===t&&(e.onTool(null),o(null))})),s.createElement("g",null,s.createElement("rect",{className:"tcfHotspotEditor__hitArea",onPointerDown:e=>{l((n=>Object.assign(Object.assign({},n),{mode:"translate",origin:{x:e.screenX,y:e.screenY},shape:t})))},x:a.x,y:a.y,width:a.width,height:a.height}),Er.map(((e,n)=>s.createElement("rect",{className:"tcfHotspotEditor__handle",key:`handle_${n}`,onPointerDown:n=>((e,n)=>{l((s=>Object.assign(Object.assign({},s),{handle:n,mode:"scale",origin:{x:e.screenX,y:e.screenY},shape:t})))})(n,e),height:br,width:br,x:a.x+(e.x?a.width:-br),y:a.y+(e.y?a.height:-br)}))))}function Cr(e){const{asset:t,maxShapes:n,onClose:r,shapes:a}=e,i=function(e,t=80){const[n,r]=(0,s.useState)(a)
function a(){const n=window.innerHeight-2*t,s=window.innerWidth-2*t,r=Math.min(1,n/e.height,s/e.width)
return{scale:r,height:Math.round(e.height*r),width:Math.round(e.width*r)}}return(0,s.useEffect)((()=>{function e(){r(a())}return window.addEventListener("resize",e),e(),()=>window.removeEventListener("resize",e)}),[e]),n}(t),l=s.useRef(null),[o,c]=(0,s.useState)(null)
return s.createElement(fr,{onClose:r},s.createElement("div",{className:"tcfHotspotEditor"},s.createElement(vr,{allowCreate:!n||a.length<n,allowDelete:a.length>0,allowedShapes:e.allowedShapes,currentTool:o?o.Component:null,onChange:e.onChange,onTool:c}),s.createElement(gr,{height:i.height,ref:l,url:t.editUrl,width:i.width,onImagePointerDown:()=>c(null)},pr(a,{onSelect:function(e,t=null){c({Component:wr,props:{key:e.uuid,origin:t,uuid:e.uuid}})},viewport:i}),o?s.createElement(o.Component,Object.assign({},o.props,e,{onTool:c,svg:l.current,viewport:i})):null)))}function Sr({asset:e,onClick:t,shapes:n}){const r=Math.min(120/e.width,120/e.height),a={height:Math.round(e.height*r),scale:r,width:Math.round(e.width*r)}
return s.createElement("div",{className:je()("tcfHotspotPreview",{clickable:!!t}),onClick:t},s.createElement("div",{className:"tcfHotspotPreview__thumb"},s.createElement(gr,{height:Math.round(a.height),url:e.previewUrl,width:Math.round(a.width)},pr(n,{isPreview:!0,viewport:a}))))}const xr=(0,l.Ng)((e=>({state:e})))((function({data:e,disabled:t,field:n,model:r,onUpdate:a,state:i}){const[l,o]=s.useState(!1),c=tr(i,r,n.assetQuery),u=ar(e)?e:[]
return s.createElement(s.Fragment,null,s.createElement(Sr,{asset:c,onClick:t?void 0:()=>o(!0),shapes:u}),l?s.createElement(Cr,{allowedShapes:n.allowedShapes,asset:c,maxShapes:n.maxShapes,onChange:e=>a(e),onClose:()=>o(!1),shapes:u}):null)}))
O.initialize({array:new class extends cn{constructor(){super({widget:an})}cloneValue(e){return(0,W.sH)(this,void 0,void 0,(function*(){const{field:t,value:n}=e,s=(0,W.Tt)(e,["field","value"])
if(this.isValue(t,n)){const e=O.getDefinition(t.member.type),r=[]
for(const a of n)r.push(yield e.cloneValue(Object.assign(Object.assign({},s),{field:t.member,value:a})))
return r}return this.createValue(e)}))}createValue(e){return[]}isValue(e,t){return Array.isArray(t)}preview(e){return new kt(e)}},checkbox:new class extends un{constructor(){super({widget:mn}),this.isAlwaysPlainField=!0}},ckeditor:new class extends gn{constructor(){super({widget:pn})}preview({value:e}){return new hn(e)}},color:new class extends cn{constructor(){super({widget:Tn})}createValue(e){return{alpha:1,blue:255,green:255,red:255}}isValue(e,t){return vn(t)}preview({context:e,value:t}){return""}},hotspot:new class extends cn{constructor(){super({widget:xr})}createValue(e){return[]}isValue(e,t){return ar(t)}preview({context:e,value:t}){return""}},instance:new class extends cn{constructor(){super({factory:Bn,widget:qn})}cloneValue(e){return(0,W.sH)(this,void 0,void 0,(function*(){const{field:t,value:n}=e,s=(0,W.Tt)(e,["field","value"])
return this.isValue(t,n)?q(Object.assign(Object.assign({},s),{source:n})):this.createValue(e)}))}createValue({field:e,schema:t,schemas:n}){if(t||(t=n[e.defaultSchema]),!t)throw new Error("The option `schema` is required when creating instances.")
return N({schema:t,schemas:n})}isValue(e,t){return c(t)&&-1!==e.schemas.indexOf(t.__type)}preview({context:e,mode:t="default",value:n}){if(!c(n))return""
const s=e.schemas[n.__type]
if(!s)return""
const r="label"===t?s.previewLabelTemplate:s.previewTemplate
if(null===r)return s.label
const a={toHTML:()=>new ge.SafeString(r(a,Nt())),toString:()=>r(a,Nt())}
a.depth=e.depth
for(const t of Object.keys(s.fields)){const r=s.fields[t],i=O.getDefinition(r)
i&&(a[t]=i.preview({context:Object.assign(Object.assign({},e),{depth:e.depth+1}),field:r,value:n[t]}))}return a}},layout:new class extends cn{constructor(){super({widget:is})}cloneValue(e){return(0,W.sH)(this,void 0,void 0,(function*(){const{field:t,value:n}=e,s=(0,W.Tt)(e,["field","value"]),{schemas:r}=s
if(!this.isValue(t,n))return this.createValue(e)
const a=re(t,r),i=O.getDefinition(a),l=[]
for(let e=0;e<n.columns.length;e++){const o=n.columns[e],c=yield i.cloneValue(Object.assign({field:a,value:o.value},s))
l.push(te(t,r,o,c))}return{__role:"layout",__uuid:_(),preset:n.preset,columns:l}}))}createValue({field:e,schemas:t}){const n=this.getDefaultPreset(e)
let s
if(n)s=n.columns.map((n=>te(e,t,n)))
else for(s=[];s.length<e.constraints.minColumns;)s.push(te(e,t))
return{__role:"layout",__uuid:_(),preset:n?n.key:null,columns:s}}getDefaultPreset({defaultPreset:e,presets:t}){const n=t.length?t[0]:null
return t.find((t=>t.key===e))||n}isValue(e,t){return ie(t)}preview({context:e,field:t,value:n}){if(!t)return""
const{breakpoints:s,columnsPerRow:r}=t,a=re(t,e.schemas),i=O.getDefinition(a),l={breakpoints:s,current:s[s.length-1]},o=n.columns.map((t=>{const n=se(t.order,l),s=se(t.offset,l)/r,o=se(t.width,l)/r
return`<div style="${[`margin-left:${(100*s).toFixed(6)}%`,`order:${n}`,`width:${(100*o).toFixed(6)}%`].join(";")}">${Ct(i.preview({context:e,field:a,value:t.value}))}</div>`}))
return new ge.SafeString(`<div class="tcpRow">${o.join("")}</div>`)}},lightswitch:new class extends un{constructor(){super({widget:ls})}},link:new class extends cn{constructor(){super({widget:bs})}cloneValue(e){const t=Object.create(null,{cloneValue:{get:()=>super.cloneValue}})
return(0,W.sH)(this,void 0,void 0,(function*(){const n=yield t.cloneValue.call(this,e)
return n.siteId=yield Es(n.elementId,n.siteId,e),n}))}createValue(){return{elementId:0,hash:"",openInNewWindow:!1,siteId:0,type:"url",url:""}}isValue(e,t){return vs(t)}preview(){return""}},location:new class extends cn{constructor(){super({widget:ks})}createValue({field:e}){return Os(e.defaultValue)?Object.assign({},e.defaultValue):{latitude:0,longitude:0}}isValue(e,t){return Os(t)}preview({value:e}){return new ws(e)}},number:new class extends Is{constructor(){super({widget:js})}},oembed:new class extends cn{constructor(){super({widget:Fn})}createValue(e){return{url:""}}isValue(e,t){return Vt(t)}preview({value:e}){return new Dn(Vt(e)?e:{url:""})}},redactor:new class extends gn{constructor(){super({widget:Ts})}preview({value:e}){return new Ms(e)}},reference:new class extends cn{constructor(){super({widget:Us})}cloneValue(e){const t=Object.create(null,{cloneValue:{get:()=>super.cloneValue}})
return(0,W.sH)(this,void 0,void 0,(function*(){const n=yield t.cloneValue.call(this,e)
for(const t of n)t.siteId=yield Es(t.id,t.siteId,e)
return n}))}createValue(e){return[]}isValue(e,t){return Array.isArray(t)&&t.every(w)}preview(e){return new Rs(e)}},select:new class extends Fs{constructor(){super({widget:Ds})}},swatchcolor:new class extends Fs{constructor(){super({widget:Hs})}},text:new class extends gn{constructor(){super({widget:Ws})}},textarea:new class extends gn{constructor(){super({widget:Bs})}}})
const Or={},_r=[],Nr={},kr={create:e=>{try{let t=null
const n=document.getElementById(e)
if(!n)throw new Error("Root element not found.")
const o=n.querySelector(".tcfField--app"),c=n.querySelector('script[type="application/json"]'),u=n.querySelector("input.tcfField--model")
if(!u||!o||!c)throw new Error("Missing components.")
const d=(0,i.y$)(wt,Oe(c,u),(0,i.Tw)(a.A))
_r.push(d),d.subscribe((()=>{const{draftEditor:e}=window,n=JSON.stringify(d.getState().model)
u.value!==n&&e&&(t&&window.clearTimeout(t),t=window.setTimeout((()=>{e.checkForm(),t=null}),500)),u.value=n})),r.render(s.createElement(l.Kq,{store:d},s.createElement(Et,null)),o)}catch(e){console.error("Could not start content editor.",e)}},getCKEditor:function(e){return e in Or?Or[e]:null},getInstanceApi:e=>{for(const t of _r){const n=d(t.getState(),e)
return n?pe(t,n):null}},getValidator:function(e){return e in Nr?Nr[e]:null},registerValidator:(e,t)=>{Nr[e]=t},registerCKEditor:(e,t)=>{Or[e]=t}}
if(window){const e=window;(e.lenz||(e.lenz={})).contentField=kr}const jr=kr}},n={}
function s(e){var r=n[e]
if(void 0!==r)return r.exports
var a=n[e]={exports:{}}
return t[e].call(a.exports,a,a.exports,s),a.exports}s.m=t,e=[],s.O=(t,n,r,a)=>{if(!n){var i=1/0
for(u=0;u<e.length;u++){for(var[n,r,a]=e[u],l=!0,o=0;o<n.length;o++)(!1&a||i>=a)&&Object.keys(s.O).every((e=>s.O[e](n[o])))?n.splice(o--,1):(l=!1,a<i&&(i=a))
if(l){e.splice(u--,1)
var c=r()
void 0!==c&&(t=c)}}return t}a=a||0
for(var u=e.length;u>0&&e[u-1][2]>a;u--)e[u]=e[u-1]
e[u]=[n,r,a]},s.n=e=>{var t=e&&e.__esModule?()=>e.default:()=>e
return s.d(t,{a:t}),t},s.d=(e,t)=>{for(var n in t)s.o(t,n)&&!s.o(e,n)&&Object.defineProperty(e,n,{enumerable:!0,get:t[n]})},s.g=function(){if("object"==typeof globalThis)return globalThis
try{return this||new Function("return this")()}catch(e){if("object"==typeof window)return window}}(),s.o=(e,t)=>Object.prototype.hasOwnProperty.call(e,t),s.r=e=>{"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},(()=>{var e={853:0}
s.O.j=t=>0===e[t]
var t=(t,n)=>{var r,a,[i,l,o]=n,c=0
if(i.some((t=>0!==e[t]))){for(r in l)s.o(l,r)&&(s.m[r]=l[r])
if(o)var u=o(s)}for(t&&t(n);c<i.length;c++)a=i[c],s.o(e,a)&&e[a]&&e[a][0](),e[a]=0
return s.O(u)},n=globalThis.webpackChunkcraft_contentfield_ui=globalThis.webpackChunkcraft_contentfield_ui||[]
n.forEach(t.bind(null,0)),n.push=t.bind(null,n.push.bind(n))})()
var r=s.O(void 0,[121],(()=>s(920)))
r=s.O(r)})()
