<template>
    <div>
        <textarea-auto-size
            :data="{ 
                    text: postTitle, 
                    enable: edditing,
                    inputHeight: 0,
                    error: titleError,
                    placeholder: textPlaceholder
                }"
            v-on:input="updateValue"
        />
        <div v-if="authUser !== null">
            <div v-if="authUser.id === postUserId ">
                <div class="d-flex flex-row-reverse bd-highlight mb-3">
                    <div class="p-2 bd-highlight"></div>
                    <div v-if="!edditing">
                        <button class="p-2 bd-highlight btn btn-secondary btn-large mx-2" 
                            v-on:click="editTitle()">Edit</button>
                    </div>
                    <div v-if="edditing">
                        <button class="p-2 bd-highlight btn btn-primary btn-large mx-2" 
                            v-on:click="saveEdit()">Save Comment</button>
                    </div>
                </div>
            </div>
        </div> 
    </div>
</template>

<script>
    export default {
        props: {
            auth_user: Object,
            api_post_update: String,
            post_title: String,
            post_id: Number,
            post_user_id: Number
        },
        data: function(){
            return {
                postTitle: this.post_title,
                postUserId: this.post_user_id,
                authUser: this.auth_user,
                edditing: false,
                titleError: '',
                textPlaceholder: "Enter post name here"
            }
        },

        methods: {
            updateValue: function(data) {
                this.postTitle = data.text;
            },
            editTitle: function() {
                this.edditing = true;
            },
            saveEdit: function() {
                axios.post(this.api_post_update, {
                    post_id: this.post_id,
                    post_title: this.postTitle
                    })
                    .then((response) => {
                        this.edditing = false;
                        this.titleError = '';
                    }).catch((error) => {
                        this.titleError = error.response.data.errors.post_title[0];
                    }
                )
            },
        }
    }
</script>