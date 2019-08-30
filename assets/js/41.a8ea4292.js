(window.webpackJsonp=window.webpackJsonp||[]).push([[41],{329:function(t,a,s){"use strict";s.r(a);var e=s(38),n=Object(e.a)({},function(){var t=this,a=t.$createElement,s=t._self._c||a;return s("ContentSlotsDistributor",{attrs:{"slot-key":t.$parent.slotKey}},[s("h1",{attrs:{id:"create-block-templates"}},[s("a",{staticClass:"header-anchor",attrs:{href:"#create-block-templates","aria-hidden":"true"}},[t._v("#")]),t._v(" Create block templates")]),t._v(" "),s("p",[t._v("Head back to your templates directory and create a new directory named\n"),s("code",[t._v("blocks")]),t._v(". Inside that directory, create a new file called\n"),s("code",[t._v("text.twig")]),t._v(" and paste the following code.")]),t._v(" "),s("p",[s("strong",[t._v("templates/blocks/text.twig")])]),t._v(" "),s("div",{staticClass:"language-twig extra-class"},[s("pre",{pre:!0,attrs:{class:"language-twig"}},[s("code",[s("span",{pre:!0,attrs:{class:"token other"}},[t._v("label: Text block\nicon: material:format_align_left\npreview: >")]),t._v("\n  "),s("span",{pre:!0,attrs:{class:"token tag"}},[s("span",{pre:!0,attrs:{class:"token ld"}},[s("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v("{{")])]),t._v(" "),s("span",{pre:!0,attrs:{class:"token property"}},[t._v("body")]),s("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v(".")]),s("span",{pre:!0,attrs:{class:"token property"}},[t._v("snippet")]),t._v(" "),s("span",{pre:!0,attrs:{class:"token rd"}},[s("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v("}}")])])]),t._v("\n"),s("span",{pre:!0,attrs:{class:"token other"}},[t._v("fields:\n  body:\n    type: redactor\n---\n"),s("span",{pre:!0,attrs:{class:"token tag"}},[s("span",{pre:!0,attrs:{class:"token tag"}},[s("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v("<")]),t._v("div")]),t._v(" "),s("span",{pre:!0,attrs:{class:"token attr-name"}},[t._v("class")]),s("span",{pre:!0,attrs:{class:"token attr-value"}},[s("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v("=")]),s("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v('"')]),t._v("container"),s("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v('"')])]),s("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v(">")])])]),t._v("\n  "),s("span",{pre:!0,attrs:{class:"token tag"}},[s("span",{pre:!0,attrs:{class:"token ld"}},[s("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v("{{")])]),t._v(" "),s("span",{pre:!0,attrs:{class:"token property"}},[t._v("body")]),s("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v(".")]),s("span",{pre:!0,attrs:{class:"token property"}},[t._v("html")]),t._v(" "),s("span",{pre:!0,attrs:{class:"token rd"}},[s("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v("}}")])])]),t._v("\n"),s("span",{pre:!0,attrs:{class:"token other"}},[s("span",{pre:!0,attrs:{class:"token tag"}},[s("span",{pre:!0,attrs:{class:"token tag"}},[s("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v("</")]),t._v("div")]),s("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v(">")])])]),t._v("\n")])])]),s("p",[t._v("There are two new attributes in the Yaml block:")]),t._v(" "),s("ul",[s("li",[s("p",[t._v("The "),s("code",[t._v("icon")]),t._v(" attribute defines an icon for the template type in order to\nmake blocks easier to distinguish in the control panel. A list of\nall available icons can be found in the control panel\n"),s("code",[t._v("Utilities")]),t._v(" > "),s("code",[t._v("Content field utilities")]),t._v(".")])]),t._v(" "),s("li",[s("p",[t._v("The "),s("code",[t._v("preview")]),t._v(" attribute contains a simple preview of the block that\nwill be shown to the editor in the control panel. It's a handlebars template\nthat has access to all fields defined in the current template.")])])]),t._v(" "),s("div",{staticClass:"tip custom-block"},[s("p",[t._v("You can learn more about handlebars templates on their official site:\n"),s("a",{attrs:{href:"https://handlebarsjs.com/",target:"_blank",rel:"noopener noreferrer"}},[t._v("handlebarsjs.com"),s("OutboundLink")],1)])]),t._v(" "),s("p",[t._v("Next create a new file called "),s("code",[t._v("image.twig")]),t._v(" in the same directory\nand paste the following code.")]),t._v(" "),s("p",[s("strong",[t._v("templates/blocks/image.twig")])]),t._v(" "),s("div",{staticClass:"language-twig extra-class"},[s("pre",{pre:!0,attrs:{class:"language-twig"}},[s("code",[s("span",{pre:!0,attrs:{class:"token other"}},[t._v("label: Image block\nicon: material:picture\npreview: >")]),t._v("\n  "),s("span",{pre:!0,attrs:{class:"token tag"}},[s("span",{pre:!0,attrs:{class:"token ld"}},[s("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v("{{")])]),t._v(" "),s("span",{pre:!0,attrs:{class:"token property"}},[t._v("image")]),t._v(" "),s("span",{pre:!0,attrs:{class:"token rd"}},[s("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v("}}")])])]),t._v("\n"),s("span",{pre:!0,attrs:{class:"token other"}},[t._v("fields:\n  image:\n    type: image\n    rules: required\n---\n"),s("span",{pre:!0,attrs:{class:"token tag"}},[s("span",{pre:!0,attrs:{class:"token tag"}},[s("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v("<")]),t._v("div")]),t._v(" "),s("span",{pre:!0,attrs:{class:"token attr-name"}},[t._v("class")]),s("span",{pre:!0,attrs:{class:"token attr-value"}},[s("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v("=")]),s("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v('"')]),t._v("container"),s("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v('"')])]),s("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v(">")])]),t._v('\n  <img src="')]),s("span",{pre:!0,attrs:{class:"token tag"}},[s("span",{pre:!0,attrs:{class:"token ld"}},[s("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v("{{")])]),t._v(" "),s("span",{pre:!0,attrs:{class:"token property"}},[t._v("image")]),s("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v(".")]),s("span",{pre:!0,attrs:{class:"token property"}},[t._v("first")]),s("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v(".")]),s("span",{pre:!0,attrs:{class:"token property"}},[t._v("url")]),t._v(" "),s("span",{pre:!0,attrs:{class:"token rd"}},[s("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v("}}")])])]),s("span",{pre:!0,attrs:{class:"token other"}},[t._v('" />\n'),s("span",{pre:!0,attrs:{class:"token tag"}},[s("span",{pre:!0,attrs:{class:"token tag"}},[s("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v("</")]),t._v("div")]),s("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v(">")])])]),t._v("\n")])])]),s("p",[t._v("The image field type is a field that allows editors to select assets. Note\nthe "),s("code",[t._v("rule")]),t._v(" attribute on the image field, it marks the field as being\nrequired.")])])},[],!1,null,null,null);a.default=n.exports}}]);