module.exports=function(t){var e={};function a(n){if(e[n])return e[n].exports;var r=e[n]={i:n,l:!1,exports:{}};return t[n].call(r.exports,r,r.exports,a),r.l=!0,r.exports}return a.m=t,a.c=e,a.d=function(t,e,n){a.o(t,e)||Object.defineProperty(t,e,{enumerable:!0,get:n})},a.r=function(t){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(t,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(t,"__esModule",{value:!0})},a.t=function(t,e){if(1&e&&(t=a(t)),8&e)return t;if(4&e&&"object"==typeof t&&t&&t.__esModule)return t;var n=Object.create(null);if(a.r(n),Object.defineProperty(n,"default",{enumerable:!0,value:t}),2&e&&"string"!=typeof t)for(var r in t)a.d(n,r,function(e){return t[e]}.bind(null,r));return n},a.n=function(t){var e=t&&t.__esModule?function(){return t.default}:function(){return t};return a.d(e,"a",e),e},a.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},a.p="",a(a.s=15)}([function(t,e){t.exports=flarum.core.compat.Model},function(t,e){t.exports=flarum.core.compat["components/Button"]},function(t,e){t.exports=flarum.core.compat.Component},function(t,e){t.exports=flarum.core.compat.extend},function(t,e){t.exports=flarum.core.compat.app},function(t,e){t.exports=flarum.core.compat["utils/mixin"]},function(t,e){t.exports=flarum.core.compat["components/AdminNav"]},function(t,e){t.exports=flarum.core.compat["components/AdminLinkButton"]},function(t,e){t.exports=flarum.core.compat["components/Page"]},function(t,e){t.exports=flarum.core.compat["components/LoadingIndicator"]},function(t,e){t.exports=flarum.core.compat["components/Placeholder"]},function(t,e){t.exports=flarum.core.compat["components/Checkbox"]},function(t,e){t.exports=flarum.core.compat["components/Modal"]},function(t,e){t.exports=flarum.core.compat["components/PermissionGrid"]},function(t,e){t.exports=flarum.core.compat["utils/string"]},function(t,e,a){"use strict";a.r(e);var n=a(3),r=a(4),o=a.n(r);function i(t,e){t.prototype=Object.create(e.prototype),t.prototype.constructor=t,t.__proto__=e}var l=a(0),u=a.n(l),s=a(5),c=a.n(s),p=(a(14),function(t){function e(){return t.apply(this,arguments)||this}return i(e,t),e}(c()(u.a,{type:u.a.attribute("type"),name:u.a.attribute("name"),regex:u.a.attribute("regex"),replacement:u.a.attribute("replacement"),flag:u.a.attribute("flag"),event:u.a.attribute("event"),time:u.a.attribute("time",u.a.transformDate),editTime:u.a.attribute("editTime",u.a.transformDate)}))),d=a(6),f=a.n(d),h=a(7),b=a.n(h),g=a(8),v=a.n(g),_=a(2),y=a.n(_),x=a(9),N=a.n(x),w=a(10),D=a.n(w),B=a(1),F=a.n(B),P=a(11),k=a.n(P),M=a(12),j=function(t){function e(){return t.apply(this,arguments)||this}i(e,t);var a=e.prototype;return a.init=function(){t.prototype.init.call(this),this.rule=this.props.rule||app.store.createRecord("decontaminator"),this.regex=m.prop(this.rule.regex()||""),this.name=m.prop(this.rule.name()||""),this.replacement=m.prop(this.rule.replacement()||""),this.flag=m.prop(this.rule.flag()||""),this.event=m.prop(this.rule.event()||"save")},a.className=function(){return"EditDecontaminatorModal Modal--medium"},a.title=function(){return app.translator.trans("flarumite-decontaminator.admin.edit_rule.title")},a.content=function(){var t=this;return m("div",{className:"Modal-body"},m("div",{className:"Form"},m("div",{className:"Form-group"},m("label",null,app.translator.trans("flarumite-decontaminator.admin.edit_rule.name_label"),m("input",{className:"FormControl",placeholder:"",value:this.name(),oninput:function(e){t.name(e.target.value)}})),app.translator.trans("flarumite-decontaminator.admin.edit_rule.name_help")),m("div",{className:"Form-group"},m("label",null,app.translator.trans("flarumite-decontaminator.admin.edit_rule.regex_label"),m("input",{className:"FormControl",placeholder:"",value:this.regex(),oninput:function(e){t.regex(e.target.value)}})),app.translator.trans("flarumite-decontaminator.admin.edit_rule.regex_help"),m("br",null),m("a",{href:"https://regex101.com",target:"_blank"},"regex101.com")),m("div",{className:"Form-group"},m("label",null,app.translator.trans("flarumite-decontaminator.admin.edit_rule.replacement_label"),m("input",{className:"FormControl",placeholder:"",value:this.replacement(),oninput:function(e){t.replacement(e.target.value)}})),app.translator.trans("flarumite-decontaminator.admin.edit_rule.replacement_help")),m("div",{className:"Form-group"},m("label",null,app.translator.trans("flarumite-decontaminator.admin.edit_rule.flag_label")),m("input",{type:"checkbox",checked:this.flag(),onclick:function(e){t.flag(e.target.checked)}}),m("p",null,app.translator.trans("flarumite-decontaminator.admin.edit_rule.flag_help"))),m("div",{className:"Form-group"},m("label",null,app.translator.trans("flarumite-decontaminator.admin.edit_rule.applywhen_label"),m("select",{className:"FormControl",oninput:m.withAttr("value",this.event),value:this.event()},m("option",{value:"save"},app.translator.trans("flarumite-decontaminator.admin.edit_rule.action.save")),m("option",{value:"load"},app.translator.trans("flarumite-decontaminator.admin.edit_rule.action.load")))),app.translator.trans("flarumite-decontaminator.admin.edit_rule.applywhen_help")),m("div",{className:"Form-group"},F.a.component({type:"submit",className:"Button Button--primary EditDecontaminatorModal-save",loading:this.loading,children:app.translator.trans("flarumite-decontaminator.admin.edit_rule.submit_button")}),this.rule.exists?m("button",{type:"button",className:"Button EditDecontaminatorModal-delete",onclick:this.delete.bind(this)},app.translator.trans("flarumite-decontaminator.admin.edit_rule.delete_button")):"")))},a.onsubmit=function(t){var e=this;t.preventDefault(),this.loading=!0,this.rule.save({name:this.name(),regex:this.regex(),event:this.event(),flag:this.flag(),replacement:this.replacement(),type:"decontaminator"},{errorHandler:this.onerror.bind(this)}).then(this.hide.bind(this)).catch((function(){e.loading=!1,m.redraw()}))},a.onhide=function(){m.route(app.route("decontaminator"))},a.delete=function(){confirm(app.translator.trans("flarumite-decontaminator.admin.edit_rule.delete_confirmation"))&&(this.rule.delete().then((function(){return m.redraw()})),this.hide())},e}(a.n(M).a),O=function(t){function e(){return t.apply(this,arguments)||this}i(e,t);var a=e.prototype;return a.view=function(){var t=this.props.rule;return m("tr",{key:t.data.id},m("th",null,t.data.attributes.name),m("th",null,t.data.attributes.regex),m("th",null,t.data.attributes.replacement),m("th",null,k.a.component({state:t.data.attributes.flag,onchange:this.updateFlag.bind(this)})),m("td",{className:"Decontaminator-actions"},m("div",{className:"ButtonGroup"},F.a.component({className:"Button Button--Decontaminator-edit",icon:"fas fa-pencil-alt",onclick:function(){return app.modal.show(new j({rule:t}))}}),F.a.component({className:"Button Button--danger Button--Decontaminator-delete",icon:"fas fa-times",onclick:this.delete.bind(this)}))))},a.updateFlag=function(){this.props.rule.save({name:this.props.rule.data.attributes.name,flag:this.props.rule.data.attributes.flag?0:1,regex:this.props.rule.data.attributes.regex,event:this.props.rule.data.attributes.event,replacement:this.props.rule.data.attributes.replacement,type:"decontaminator"}).then((function(){return m.redraw()}))},a.delete=function(){confirm(app.translator.trans("flarumite-decontaminator.admin.delete_rule_confirmation"))&&(this.props.rule.delete().then((function(){return m.redraw()})),m.route(app.route("decontaminator")))},e}(y.a),C=function(t){function e(){return t.apply(this,arguments)||this}i(e,t);var a=e.prototype;return a.init=function(){this.loading=!0,this.decontaminator=[],this.page=0,this.refresh()},a.view=function(){if(this.loading)return m("div",{className:"DecontaminatorList-loading"},N.a.component());if(0===this.decontaminator.length){var t=app.translator.trans("flarumite-decontaminator.admin.list.empty_text");return D.a.component({text:t})}return m("div",{className:"DecontaminatorList"},m("table",{className:"DecontaminatorList-results"},m("thead",null,m("tr",null,m("th",null,app.translator.trans("flarumite-decontaminator.admin.edit_rule.name_label")),m("th",null,app.translator.trans("flarumite-decontaminator.admin.edit_rule.regex_label")),m("th",null,app.translator.trans("flarumite-decontaminator.admin.edit_rule.replacement_label")),m("th",null,app.translator.trans("flarumite-decontaminator.admin.edit_rule.flag_label")),m("th",null))),m("tbody",null,this.decontaminator.map((function(t){return O.component({rule:t})})))))},a.refresh=function(t){return void 0===t&&(t=!0),t&&(this.loading=!0,this.decontaminator=[]),this.loadResults().then(this.parseResults.bind(this))},a.loadResults=function(){return app.store.find("decontaminator")},a.parseResults=function(t){return[].push.apply(this.decontaminator,t),this.loading=!1,m.lazyRedraw(),t},a.loadNext=function(){},a.loadPrev=function(){},e}(y.a),R=function(t){function e(){return t.apply(this,arguments)||this}return i(e,t),e.prototype.view=function(){return m("div",{className:"container"},m("p",null,app.translator.trans("flarumite-decontaminator.admin.decontaminator.about_text")),F.a.component({className:"Button Button--primary",icon:"fas fa-plus",children:app.translator.trans("flarumite-decontaminator.admin.decontaminator.create_button"),onclick:function(){return app.modal.show(new j)}}))},e}(y.a),S=function(t){function e(){return t.apply(this,arguments)||this}return i(e,t),e.prototype.view=function(){return m("div",{className:"DecontaminatorPage"},m("div",{className:"DecontaminatorPage-header"},R.component()),m("div",{className:"DecontaminatorPage-list"},m("div",{className:"container"},C.component())))},e}(v.a),L=function(){app.routes.decontaminator={path:"decontaminator",component:S.component()},app.extensionSettings["decontaminator-manager"]=function(){return m.route(app.route("decontaminator"))},Object(n.extend)(f.a.prototype,"items",(function(t){t.add("decontaminator-manager",b.a.component({href:app.route("decontaminator"),icon:"fas fa-file-alt",children:"Decontaminator",description:"Powerful content replacement tool"}))}))},T=a(13),A=a.n(T);o.a.initializers.add("flarumite/decontaminator",(function(t){t.store.models.decontaminator=p,Object(n.extend)(A.a.prototype,"moderateItems",(function(e){e.add("bypassDecontaminator",{icon:"far fa-eye-slash",label:t.translator.trans("flarumite-decontaminator.admin.permissions.bypass-filter"),permission:"user.bypassDecontaminator"})})),L()}))}]);
//# sourceMappingURL=admin.js.map