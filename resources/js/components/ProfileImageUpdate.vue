<template>
    <div>
        <div class="d-flex flex-row bd-highlight mb-3">
            <div class="p-2 bd-highlight">
                <input type="image" class="mx-auto d-block img-fluid img_profile" 
                    :src="srcPath"
                    alt="user.image.path" 
                />
            </div>
            <div class="p-2 bd-highlight">
                <h2 style="color: black"> {{user.name}} </h2>
            </div>
            <div v-if="imageError.length > 3" class="p-2 bd-highlight">
                <h2 style="color: black"> {{imageError}} </h2>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            current_user: Object,
            current_user_image: Object,
        },
        data:  function(){
            return {
                user: this.current_user,
                userImage: this.current_user_image,
                imageError: "",
                srcPath: '',
            }
        },

        mounted() {
            this.setUrl();
        },

        methods: {
            setUrl: function() {
                this.srcPath = "/storage/images/" + this.userImage.path;
            },
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