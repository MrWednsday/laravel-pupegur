<template>
	<div>
		<div v-if="selectedImage !== ''">
			<img class="mx-auto d-block img-fluid" v-bind:src="selectedImage"/>
		</div>
		<div class="d-flex justify-content-center">
			<div class="p-2 bd-highlight">
				<label class="btn btn-secondary btn-large" style="background-color=transparent">
					<input type="file" style="display:none" v-on:change="selectImage">
					<div v-if="selectedImage === ''">
						<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-folder2-open" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
							<path fill-rule="evenodd" d="M1 3.5A1.5 1.5 0 0 1 2.5 2h2.764c.958 0 1.76.56 2.311 1.184C7.985 3.648 8.48 4 9 4h4.5A1.5 1.5 0 0 1 15 5.5v.64c.57.265.94.876.856 1.546l-.64 5.124A2.5 2.5 0 0 1 12.733 15H3.266a2.5 2.5 0 0 1-2.481-2.19l-.64-5.124A1.5 1.5 0 0 1 1 6.14V3.5zM2 6h12v-.5a.5.5 0 0 0-.5-.5H9c-.964 0-1.71-.629-2.174-1.154C6.374 3.334 5.82 3 5.264 3H2.5a.5.5 0 0 0-.5.5V6zm-.367 1a.5.5 0 0 0-.496.562l.64 5.124A1.5 1.5 0 0 0 3.266 14h9.468a1.5 1.5 0 0 0 1.489-1.314l.64-5.124A.5.5 0 0 0 14.367 7H1.633z"/>
						</svg>
					</div>
					<div v-else>
						<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-folder-check" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
							<path fill-rule="evenodd" d="M9.828 4H2.19a1 1 0 0 0-.996 1.09l.637 7a1 1 0 0 0 .995.91H9v1H2.826a2 2 0 0 1-1.991-1.819l-.637-7a1.99 1.99 0 0 1 .342-1.31L.5 3a2 2 0 0 1 2-2h3.672a2 2 0 0 1 1.414.586l.828.828A2 2 0 0 0 9.828 3h3.982a2 2 0 0 1 1.992 2.181L15.546 8H14.54l.265-2.91A1 1 0 0 0 13.81 4H9.828zm-2.95-1.707L7.587 3H2.19c-.24 0-.47.042-.684.12L1.5 2.98a1 1 0 0 1 1-.98h3.672a1 1 0 0 1 .707.293z"/>
							<path fill-rule="evenodd" d="M15.854 10.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708l1.146 1.147 2.646-2.647a.5.5 0 0 1 .708 0z"/>
						</svg>
					</div>
				</label>
			</div>
		</div>
	</div>
</template>

<script>
    export default {
        data () {
            return {
				selectedImage: '',
            }
        },  
        methods: {
			selectImage (event) {
				var reader = new FileReader();
				var file = event.target.files[0];

				reader.readAsDataURL(file);

				reader.onload = () => {
					var imageData = reader.result;
					this.selectedImage = imageData;
					this.$emit('imageUpdate', imageData);
				};
			}
        }
    }
</script>