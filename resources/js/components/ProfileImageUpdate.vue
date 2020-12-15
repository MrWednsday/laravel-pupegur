<template>
    <div>
        <div class="d-flex flex-row bd-highlight mb-3">
            <div class="p-2 bd-highlight">
                <label class="btn btn-secondary btn-large">
                    <input type="file" style="display:none" v-on:change="selectImage">
                    <img class="mx-auto d-block img-fluid img_profile" 
                        :src="srcPath"
                        alt="user.image.path" 
                    />
                </label>
            </div>
            <div class="p-2 bd-highlight">
                <h2 style="color: black"> {{user.name}} </h2>
            </div>
            <div v-if="imageError.length > 3" class="p-2 bd-highlight">
                <p style="color: black"> {{imageError}} </p>
            </div>
        </div>
        <div v-if="showSave" class="d-flex justify-content-end">
            <div class="p-2 bd-highlight">
                <button class="btn btn-primary" v-on:click="updateProfileImage">Upload Profile Image</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            current_user: Object,
            current_user_image: Object,
            api_profile_image_update: String,
        },
        data:  function(){
            return {
                user: this.current_user,
                userImage: this.current_user_image,
                imageError: "",
                srcPath: '',
                showSave: false,
            }
        },

        mounted(){
            this.setUrl();
        },

        methods: {
            setUrl: function() {
                this.srcPath = window.location.origin + '/storage/images/' + this.userImage.path
            },
            selectImage: function(event) {
                var reader = new FileReader();
				var file = event.target.files[0];

				reader.readAsDataURL(file);

				reader.onload = () => {
					var imageData = reader.result;
                    this.srcPath = imageData;
                    this.showSave = true;
				};
            },

            updateProfileImage: function() {
                return axios.post(this.api_profile_image_update, 
                    {image: this.srcPath}
                ).then((response) => {
                    this.imageError = "";
                }).catch((error) => {
                    this.imageError = error.response.data.errors.image[0];
                })
            },
        }
    }
</script>