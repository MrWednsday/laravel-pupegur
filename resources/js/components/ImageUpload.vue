<template>
    <div class="form-group">
        <div class="col-md-12">
            <textarea-auto-size
                :data="{ 
                        text: postName, 
                        enable: true,
                        inputHeight: 0,
                        error: postNameError,
                        placeholder: 'Enter post title here'
                    }"
                v-on:input="updatePostName"
            />
            <image-preview
                v-on:imageUpdate="updateImage"
            />

            <add-tags
                v-on:addTag="updateTags"
            />

            <div class="d-flex justify-content-center" v-if="postFileError.length>3">
                <div class="p-2 bd-highlight" >{{postFileError}}</div>
            </div>
            <div class="d-flex justify-content-center">
                <div class="p-2 bd-highlight">
                    <button class="btn btn-primary" v-on:click="uploadImage">Upload Image</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            api_post_create: String
        },
        data: function(){
            return {
                postName: '',
                postNameError: false,
                image: null,
                apiPostCreate: this.api_post_create,
                postFileError: false,
                tags: []
            }
        },

        methods: {
            updatePostName: function(data) {
                this.postName = data.text;
            },
            updateImage: function(imageData) {
                this.image = imageData;
            },
            updateTags: function(tags){
                this.tags = tags
            },
            uploadImage: function() {
                    this.postNameError = false;
                    this.postFileError = false;
                    axios.put(this.apiPostCreate, {
                        post_title: this.postName,
                        image_data: this.image,
                        tags: this.tags
                    }).then((response) => {
                        window.location.href = response.data.url;
                    }).catch((error) => {
                        this.postNameError = (typeof error.response.data.errors.post_title === 'undefined') ? false : error.response.data.errors.post_title[0];
                        this.postFileError = (typeof error.response.data.errors.image_data === 'undefined') ? false : error.response.data.errors.image_data[0];
                    }
                )
            }
        }
    }
</script>
