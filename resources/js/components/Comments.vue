<template>
    <div>
        <div v-if="authUser !== null">
            <div class="container align-middle">
                <div class="jumbotron col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-0">
                    <div class="d-flex bd-highlight">
                        <div class="p-2 flex-grow-1 bd-highlight">
                            <textarea-auto-size
                                :data="{ 
                                    text: comment, 
                                    enable: true,
                                    inputHeight: 0,
                                    error: commentError,
                                    placeholder: 'Please be nice when making comments'
                                }"
                                v-on:input="updateValue"
                            />
                        </div>
                    </div>
                    <div class="d-flex flex-row-reverse bd-highlight mb-3">
                        <div class="p-2 bd-highlight"></div>
                        <button class="p-2 bd-highlight btn btn-primary btn-large" v-on:click="sendComment">Post Comment</button>
                    </div>
                </div>
            </div>
        </div>
        <div v-for="comment in comments" :key="comment.id">
            <comment :data="{
                auth_user: authUser,
                admin: adminRole,
                comment_data: comment,
                api_comment_edit: apiCommentEdit,
                api_comment_delete: apiCommentDelete
            }"
            v-on:updateComments="loadComments"/>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            post_id: Number,
            auth_user: Object,
            admin: Number,
            api_comment_get: String,
            api_comment_store: String,
            api_comment_edit: String,
        },
        data:  function(){
            return {
                comments: [],
                authUser: this.auth_user ?? null,
                adminRole: this.admin === 1 ? true : false, 
                comment: '',
                commentError: '',
                apiCommentGet: this.api_comment_get,
                apiCommentStore: this.api_comment_store,
                apiCommentEdit: this.api_comment_edit,
                apiCommentDelete: 'http://pupegur.test/api/comments/'
            }
        },

        mounted(){
            this.loadComments();
        },

        methods: {
            loadComments: function() {
                axios.get(this.apiCommentGet)
                .then((response) => {
                    this.comments = response.data
                }).catch(function (error){
                    console.log(error)
                })
            },

            updateValue: function(data) {
                this.comment = data.text;
            },

            sendComment: function() {
                return axios.put(this.apiCommentStore, 
                    {comment: this.comment, post_id: this.post_id}
                ).then((response) => {
                    this.comment = "";
                    this.commentError = "";
                    this.loadComments()
                }).catch((error) => {
                    this.commentError = error.response.data.errors.comment[0];
                })
            },
        }
    }
</script>