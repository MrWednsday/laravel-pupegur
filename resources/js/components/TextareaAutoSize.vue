<template>
  <div class="textarea">
    <div v-if="edditable">
        <textarea 
            v-model="currentValue" 
            type="text" 
            class=".form-control transparent textarea-comment" 
            control::-ms-expand 
            autofocus 
            :placeholder="[[ placeholder ]]"
            ref="input" 
            :style="inputStyle"
            maxlength="255"
        />
        <textarea class="shadow" v-model="currentValue" ref="shadow" tabindex="0"></textarea>
    </div>
    <div v-else>
        <textarea 
            v-model="currentValue" 
            type="text" 
            class=".form-control transparent textarea-comment" 
            control::-ms-expand 
            autofocus 
            :placeholder="[[ placeholder ]]"
            ref="input" 
            :style="inputStyle"
            disabled="true"
            maxlength="255"
        />
        <textarea class="shadow" v-model="currentValue" ref="shadow" tabindex="0"></textarea>
    </div>
    <div v-if="error.length>3">{{error}}</div>
  </div>
</template>

<script>
    export default {
        props: {
            data: Object
        },
        data: function(){
            return {
                currentValue: this.data.text,
                edditable: this.data.enable,
                inputHeight: this.data.inputHeight,
                error: this.data.error,
                placeholder: this.data.placeholder
            }
        },
    watch: {
        currentValue () {
            this.resize();
            this.$emit('input', {text: this.currentValue});
        },
        data () {
            this.currentValue = this.data.text;
            this.edditable = this.data.enable;
            this.error = this.data.error;
            this.resize();
        }
    },
    computed: {
        inputStyle () {
            return {
                'min-height': this.inputHeight + ""
            }
        }
    },
    mounted () {
        this.resize()
        },
    methods: {
        resize: function() {
            this.inputHeight = `${this.$refs.input.scrollHeight}px`;
            }
        }
    }
</script>