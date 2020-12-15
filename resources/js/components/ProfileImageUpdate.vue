<template>
    <div>
    </div>
</template>

<script>
    export default {
        props: {

        },
        data:  function(){
            return {
                imageError: ""
            }
        },

        methods: {
            updateProfile: function() {
                return axios.put(this.apiCommentStore, 
                    {comment: this.comment, post_id: this.post_id}
                ).then((response) => {
                    this.imageError = "";
                }).catch((error) => {
                    this.imageError = error.response.data.errors.image[0];
                })
            },
        }
    }
</script>