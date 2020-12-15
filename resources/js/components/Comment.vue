<template>
    <div class="container align-middle" :key="commentId">
        <div class="jumbotron col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-0">
            <div class="d-flex bd-highlight">
                <div class="p-2 flex-grow-1 bd-highlight">
                    <a class="m-0" href="/">
                        <p>{{commentUser}}</p>
                    </a>
                </div>
                <div class="p-2 bd-highlight">
                    <p>Commented at: {{commentDate | formatDate}}</p>
                </div>
            </div>
            <div v-if="enableEdditing">
                <textarea-auto-size
                    :data="{ 
                            text: commentText, 
                            enable: true,
                            inputHeight: 0,
                            error: commentError,
                            placeholder: textPlaceholder
                        }"
                    v-on:input="updateValue"
                /> 
            </div>
            <div v-else>
                <textarea-auto-size
                        :data="{ 
                        text: commentText, 
                        enable: false,
                        inputHeight: 0,
                        error: commentError,
                        placeholder: textPlaceholder
                        }"
                />
            </div>
            <div v-if="authUser !== null">
                <div v-if="authUser.id === commentUserId ">
                    <div class="d-flex flex-row-reverse bd-highlight mb-3">
                        <div class="p-2 bd-highlight"></div>
                        <div v-if="!enableEdditing">
                            <button class="p-2 bd-highlight btn btn-secondary btn-large mx-2" :id="commentUserId" v-on:click="deleteComment()">Delete Comment</button>
                            <button class="p-2 bd-highlight btn btn-secondary btn-large mx-2" :id="commentUserId" v-on:click="editComment()">Edit</button>
                        </div>
                        <div v-if="enableEdditing">
                            <button class="p-2 bd-highlight btn btn-primary btn-large mx-2" :id="commentUserId" v-on:click="saveEdit()">Save Comment</button>
                        </div>
                    </div>
                </div>
                <div v-else-if="admin">
                    <button class="p-2 bd-highlight btn btn-secondary btn-large mx-2" :id="commentUserId" v-on:click="deleteComment()">Delete Comment</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            data: Object,
        },
        data: function(){
            return {
                authUser: this.data.auth_user ?? null,
                admin: this.data.admin,
                commentText: this.data.comment_data.text,
                commentUser: this.data.comment_data.user.name,
                commentDate: this.data.comment_data.created_at,
                commentId: this.data.comment_data.id,
                commentUserId: this.data.comment_data.user.id,
                enableEdditing: false,
                commentError: '',
                textPlaceholder : '',
            }
        },

        methods: {
            deleteComment: function() {
                return axios.delete(this.data.api_comment_delete + this.commentId
                    ).then((response) => {
                        this.$emit('updateComments')
                    }).catch(function (error){
                        
                    }
                )
            },

            updateValue: function(data) {
                this.commentText = data.text;
            },
            editComment: function() {
                this.enableEdditing = true;
            },
            saveEdit: function() {
                axios.post(this.data.api_comment_edit, {
                    comment_id: this.commentId,
                    comment_text: this.commentText
                    })
                    .then((response) => {
                        this.$emit('updateComments');
                        this.enableEdditing = false;
                        this.commentError = '';
                    }).catch((error) => {
                        this.commentError = error.response.data.errors.comment_text[0];
                    }
                )
            },
        }
    }
</script>