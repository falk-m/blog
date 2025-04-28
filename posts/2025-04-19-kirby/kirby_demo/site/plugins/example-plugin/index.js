(function() {
  "use strict";
  const exampleField_vue_vue_type_style_index_0_lang = "";
  function normalizeComponent(scriptExports, render, staticRenderFns, functionalTemplate, injectStyles, scopeId, moduleIdentifier, shadowMode) {
    var options = typeof scriptExports === "function" ? scriptExports.options : scriptExports;
    if (render) {
      options.render = render;
      options.staticRenderFns = staticRenderFns;
      options._compiled = true;
    }
    if (functionalTemplate) {
      options.functional = true;
    }
    if (scopeId) {
      options._scopeId = "data-v-" + scopeId;
    }
    var hook;
    if (moduleIdentifier) {
      hook = function(context) {
        context = context || this.$vnode && this.$vnode.ssrContext || this.parent && this.parent.$vnode && this.parent.$vnode.ssrContext;
        if (!context && typeof __VUE_SSR_CONTEXT__ !== "undefined") {
          context = __VUE_SSR_CONTEXT__;
        }
        if (injectStyles) {
          injectStyles.call(this, context);
        }
        if (context && context._registeredComponents) {
          context._registeredComponents.add(moduleIdentifier);
        }
      };
      options._ssrRegister = hook;
    } else if (injectStyles) {
      hook = shadowMode ? function() {
        injectStyles.call(
          this,
          (options.functional ? this.parent : this).$root.$options.shadowRoot
        );
      } : injectStyles;
    }
    if (hook) {
      if (options.functional) {
        options._injectStyles = hook;
        var originalRender = options.render;
        options.render = function renderWithStyleInjection(h, context) {
          hook.call(context);
          return originalRender(h, context);
        };
      } else {
        var existing = options.beforeCreate;
        options.beforeCreate = existing ? [].concat(existing, hook) : [hook];
      }
    }
    return {
      exports: scriptExports,
      options
    };
  }
  const _sfc_main$1 = {
    props: {
      label: "",
      value: "",
      sameValue: ""
    },
    data: () => {
      return {
        title: ""
      };
    },
    methods: {
      testCall() {
        this.$api.get(`example/plugin/${this.sameValue}`).then((res) => {
          this.value = res.slug;
          this.onInput();
        });
      },
      onInput(event) {
        this.$emit("input", this.value);
      }
    }
  };
  var _sfc_render$1 = function render() {
    var _vm = this, _c = _vm._self._c;
    return _c("div", [_c("k-text-field", { staticClass: "mt-1", attrs: { "name": "value", "label": _vm.label }, on: { "input": _vm.onInput }, model: { value: _vm.value, callback: function($$v) {
      _vm.value = $$v;
    }, expression: "value" } }), _c("k-button", { staticClass: "mt-1", attrs: { "icon": "check" }, on: { "click": _vm.testCall } }, [_vm._v("same action")])], 1);
  };
  var _sfc_staticRenderFns$1 = [];
  _sfc_render$1._withStripped = true;
  var __component__$1 = /* @__PURE__ */ normalizeComponent(
    _sfc_main$1,
    _sfc_render$1,
    _sfc_staticRenderFns$1,
    false,
    null,
    null,
    null,
    null
  );
  __component__$1.options.__file = "/media/falk/Daten/Projekte/Falk-M/temp/kirby_demo/site/plugins/example-plugin/src/fields/example-field.vue";
  const exampleField = __component__$1.exports;
  const exampleView_vue_vue_type_style_index_0_lang = "";
  const _sfc_main = {};
  var _sfc_render = function render() {
    var _vm = this, _c = _vm._self._c;
    return _c("k-inside", [_c("k-headline", [_vm._v("Example View")])], 1);
  };
  var _sfc_staticRenderFns = [];
  _sfc_render._withStripped = true;
  var __component__ = /* @__PURE__ */ normalizeComponent(
    _sfc_main,
    _sfc_render,
    _sfc_staticRenderFns,
    false,
    null,
    null,
    null,
    null
  );
  __component__.options.__file = "/media/falk/Daten/Projekte/Falk-M/temp/kirby_demo/site/plugins/example-plugin/src/views/example-view.vue";
  const exampleView = __component__.exports;
  panel.plugin("example/plugin", {
    fields: {
      "example-field": exampleField
    },
    components: {
      "example-view": exampleView
    }
  });
})();
