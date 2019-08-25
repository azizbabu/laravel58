<template>
	<div>
		<h3 class="text-center">Add Library</h3>
		<div class="row">
			<div class="col-md-6">
				<form @submit.prevent="addLibrary">
					<div class="form-group">
						<label for="title">Name</label>
						<input type="text" name="title" v-model="library.title" id="title" class="form-control" placeholder="Enter Library Title">
					</div>
					<div class="form-group">
						<label for="owner">Owner</label>
						<input type="text" name="owner" v-model="library.owner" id="owner" class="form-control" placeholder="Enter Owner Name">
					</div>
					<button class="btn btn-primary">Add Library</button>
				</form>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				library:{}
			}
		},
		methods: {
			addLibrary() {
				const siteUrl = document.querySelector("meta[name='site-url']").getAttribute("content")
				axios.post(`${siteUrl}/api/library/create`, this.library)
					 .then(response => (
					 	this.$router.push({name: 'home'})
					 ))
					 .catch(error => console.log(error))
					 .finally(() => this.loading = false)
			}
		}
	}
</script>