<template>
    <div>
        <div class="d-flex flex-column bd-highlight mb-3">
            <div>
                <label>
                    Email Address:
                    <input v-if="enableEdditing" type="email" v-model="emailAddress" style="width:300px" class="input-field-profile">
                    <input v-else type="email" v-model="emailAddress" style="width:300px" disabled class="input-field-profile">
                </label>
                <div v-if="errorStates.email">
                    {{errors.email[0]}}
                </div>
            </div>
            <div>
                <label>
                    Show Email: 
                    <input v-if="enableEdditing" type="checkbox" v-model="userData.show_email" class="input-field-profile"> 
                    <input v-else type="checkbox" v-model="userData.show_email" disabled class="input-field-profile"> 
                </label>
                <div v-if="errorStates.show_email">
                    {{errors.show_email[0]}}
                </div>
            </div>
            <div>
                <label>
                    Date of Birth:
                    <input v-if="enableEdditing" type="date" v-model="userData.date_of_birth" class="input-field-profile">
                    <input v-else type="date" v-model="userData.date_of_birth" disabled class="input-field-profile">
                </label>
                <div v-if="errorStates.date_of_birth">
                    {{errors.date_of_birth[0]}}
                </div>
            </div>
            <div>
                <label>
                    Gender:
                    <input v-if="enableEdditing" type="text" v-model="userData.gender" class="input-field-profile">
                    <input v-else type="text" v-model="userData.gender" disabled class="input-field-profile">
                </label>
                <div v-if="errorStates.gender">
                    {{errors.gender[0]}}
                </div>
            </div>
            <div>
                <label>
                    Country:
                    <input v-if="enableEdditing" type="text" v-model="userData.country" class="input-field-profile">
                    <input v-else type="text" v-model="userData.country" disabled class="input-field-profile">
                </label>
                <div v-if="errorStates.country">
                    {{errors.country[0]}}
                </div>
            </div>
        </div>
        <div v-if="success">
            <div class="d-flex justify-content-center">
                <div class="p-2 bd-highlight">
                    <h3 class="green-text">Profile Updated Successfuly</h3>
                </div>
            </div>
        </div>
        <div class="d-flex flex-row-reverse bd-highlight mb-3">
            <div class="p-2 bd-highlight"></div>
            <div v-if="!enableEdditing">
                <button class="p-2 bd-highlight btn btn-secondary btn-large mx-2" v-on:click="editUserData()">Edit</button>
            </div>
            <div v-if="enableEdditing">
                <button class="p-2 bd-highlight btn btn-primary btn-large mx-2" v-on:click="saveChanges()">Save Changes</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            user_data: Object,
            api_user_data_post: String,
            email: String
        },

        data: function(){
            return {
                userData: this.user_data,
                emailAddress: this.email,
                apiUserDataPost: this.api_user_data_post,
                enableEdditing: false,
                success: false,
                errorStates: {'email':  false, 'country': false, 'gender': false, 'date_of_birth': false, 'show_email': false},
                errors: {}
            }
        },

        watch: {
            errors: function () {
                const errorKeys = Object.keys(this.errors)

                errorKeys.forEach(key => {
                    this.errorStates[key] = true;
                });
            }
        },

        methods: {
            editUserData: function(){
                this.enableEdditing = true;
            },
            saveChanges: function(){
                axios.post(this.apiUserDataPost, {
                    email: this.emailAddress,
                    show_email: this.userData.show_email,
                    date_of_birth: this.userData.date_of_birth,
                    country: this.userData.country,
                    gender: this.userData.gender
                    })
                    .then((response) => {
                        this.enableEdditing = false;
                        this.success = true;
                    }).catch((error) => {
                        this.errors = error.response.data.errors;
                    }
                )
            },
        }
    }
</script>