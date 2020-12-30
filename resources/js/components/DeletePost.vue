<template>
    <div class="container align-middle">
            <div v-if="authUser !== null">
                <div v-if="authUser.id === postUserId || adminRole">
                    <div class="d-flex flex-row-reverse bd-highlight mb-3">
                        <button class="p-2 bd-highlight btn btn-secondary btn-large mx-2" v-on:click="deletePost()">Delete Post</button>
                        <label class="p-2 bd-highlight" v-if="deleteError">Error Occured</label>
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
            post_user_id: Number,
            api_post_delete: String,
            admin: Number,
        },
        data: function(){
            return {
                authUser: this.auth_user ?? null,
                adminRole: this.admin === 1 ? true : false,
                postUserId: this.post_user_id,
                apiPostDelete: this.api_post_delete,
                deleteError: false,
            }
        },

        methods: {
            deletePost: function() {
                axios.delete(this.apiPostDelete
                    ).then((response) => {
                        window.location.href = response.data.url;
                    }).catch((error) => {
                        this.deleteError = true;
                    }
                )
            }
        }
    }
</script>
