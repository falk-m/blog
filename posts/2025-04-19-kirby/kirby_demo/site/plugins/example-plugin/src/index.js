import exampleField from "./fields/example-field.vue"
import exampleView from "./views/example-view.vue"

panel.plugin('example/plugin', {
    fields: {
        'example-field': exampleField
    },
    components: {
        'example-view': exampleView
    }
});