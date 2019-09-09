<template>
	<div id="addLibraryArea">
		<div v-if="isLoading">
            <div class="overlay">
                <clip-loader size="100px" class="overlay-content"></clip-loader>
            </div>
        </div>
		<h3 class="text-center">Add Library</h3>
		<div class="row">
			<div class="col-md-6">
				<form @submit.prevent="addLibrary">
					<div class="form-group">
						<label for="title">Title</label>
						<input type="text" name="title" v-model="library.title" id="title" class="form-control" placeholder="Enter Library Title">
						<div v-if="errors.title" class="text-danger">
							{{ errors.title[0] }}
						</div>
					</div>
					<div class="form-group">
						<label for="owner">Owner</label>
						<input type="text" name="owner" v-model="library.owner" id="owner" class="form-control" placeholder="Enter Owner Name">
						<div v-if="errors.owner" class="text-danger">
							{{ errors.owner[0] }}
						</div>
					</div>
					<div class="form-group">
						<label for="description">Description</label>
						<textarea type="text" name="description" v-model="library.description" id="description" class="form-control" placeholder="Enter Library Description"></textarea>
						<!-- <vue-ckeditor 
					      v-model="library.description" 
					      :config="config" /> -->
					</div>
					<div class="form-group">
                        <label for="library-types">Library Types:</label>
                        <v-select placeholder="Select a Library Type" v-model="library.type" :options="libraryTypes" :reduce="label => label.code" label="label"></v-select>
						<div v-if="errors.type" class="text-danger">
							{{ errors.type[0] }}
						</div>
                    </div>
                    <div class="form-group">
                        <label for="establish_date">Established Date:</label>
                        <vuejs-datepicker v-model="library.establish_date" input-class="form-control bg-light" format="yyyy-MM-dd" placeholder="YYYY-MM-DD"></vuejs-datepicker>
						<div v-if="errors.establish_date" class="text-danger">
							{{ errors.establish_date[0] }}
						</div>
                    </div>
					<button class="btn btn-primary">Add Library</button>
				</form>
			</div>
		</div>
	</div>
</template>

<script>
	import ClipLoader from 'vue-spinner/src/ClipLoader';
	import Datepicker from 'vuejs-datepicker';
	import vSelect from 'vue-select'
	import 'vue-select/dist/vue-select.css';
	// import VueCkeditor from 'vue-ckeditor2';

	export default {
		data() {
			return {
				library:{},
				libraryTypes:[
					{label:'Type 1', code : 1},
					{label:'Type 2', code : 2},
					{label:'Type 3', code : 3}
				],
				isLoading:false,
				errors:[],
				// config: {
			 //        toolbar: [
			 //          ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript']
			 //        ],
			 //        height: 300
		  //     	}
			}
		},
		components: {
            ClipLoader,
            'vuejs-datepicker' : Datepicker,
            'v-select':vSelect,
            // VueCkeditor
        },
		methods: {
			addLibrary() {
				var _this = this
				_this.isLoading = true
				const siteUrl = document.querySelector("meta[name='site-url']").getAttribute("content")
				axios.post(`${siteUrl}/api/library/create`, _this.library)
					 .then(response => {
						 if(response.data.success) {
							 setTimeout(function() {
								_this.$toasted.success(response.data.message,{
									position: 'top-center',
									theme: 'bubble',
									duration: 10000,
									action : {
										text : 'Close',
										onClick : (e, toastObject) => {
											toastObject.goAway(0);
										}
									},
								});
								_this.$router.push({name: 'home'})
							 }, 1000)
						 }else {
							 _this.$toasted.error(response.data.message,{
								position: 'top-center',
								theme: 'bubble',
								duration: 10000,
								action : {
									text : 'Close',
									onClick : (e, toastObject) => {
										toastObject.goAway(0);
									}
								},
							});
						 }
					 })
					 .catch(error => {
						if(error.response.status == 422){
							_this.errors = error.response.data.errors;
						}
						else{
							_this.$toasted.error(error,{
								position: 'top-center',
								theme: 'bubble',
								duration: 10000,
								action : {
									text : 'Close',
									onClick : (e, toastObject) => {
										toastObject.goAway(0);
									}
								},
							});
						}
					 })
					 .finally(() => _this.isLoading = false)
			}
		}
	}
</script>