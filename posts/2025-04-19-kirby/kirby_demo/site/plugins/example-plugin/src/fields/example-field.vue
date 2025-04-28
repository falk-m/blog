<template>
    <div>
        <k-text-field class="mt-1" v-model="value" name="value" :label="label" @input="onInput" />

        <k-button class="mt-1" icon="check" @click="testCall">same action</k-button>
    </div>
</template>

<script>
export default {
    props: {
        label: '',
        value: '',
        sameValue: ''
    },
    data: () => {
      return {
        title: '',
      };
    },
    methods: {
        testCall(){
            this.$api.get(`example/plugin/${this.sameValue}`).then(res => {
                this.value = res.slug;
                this.onInput();
            })
        },
        onInput(event) {
            this.$emit("input", this.value);
        }
    }
}
</script>

<style>

</style>