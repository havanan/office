<template>
    <select class="form-control input-sm">
        <slot></slot>
    </select>
</template>
<script>
export default {
    data() {
        return {
            classObject: this.class
        }
    },
    props: ['options', 'value'],
    mounted: function () {
    var vm = this
    $(this.$el)
        .val(this.value)
        // init select2
        .select2({ data: this.options })
        // emit event on change.
        .on('change', function () {
        vm.$emit('input', this.value)
        })
    },
    watch: {
        value: function (value) {
            // update value
            $(this.$el).val(value).trigger('change', [true])
        },
        options: function (options) {
            // update options
            $(this.$el).empty();
            $(this.$el).select2({ data: options })
        },
        class(value) {
            this.classObject = value
        }
    },
    destroyed: function () {
        $(this.$el).off().select2('destroy')
    }
}
</script>