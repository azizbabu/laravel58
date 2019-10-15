<template>
	<div id="libraryListArea">
		<div v-if="isLoading">
            <div class="overlay">
                <clip-loader size="100px" class="overlay-content"></clip-loader>
            </div>
        </div>
		<h3 class="text-center">All Libraries</h3>

		<div class="table-responsive">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>Name</th>
						<th>Owner</th>
						<th>Type</th>
						<th>Established Date</th>
						<th>Created at</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					<template v-if="libraries.length">
					<tr v-for="library in libraries" :key="library.id">
						<td>{{ library.title }}</td>
						<td>{{ library.owner }}</td>
						<td>{{ libraryTypes[library.type] }}</td>
						<td>{{ library.establish_date }}</td>
						<td>{{ library.created_at }}</td>
						<td>
							<div class="btn-group" role="group">
								<router-link :to="{name:'edit', params:{ id:library.id } }" class="btn btn-primary">Edit</router-link>
								<button type="button" class="btn btn-danger" @click="deleteLibrary(library.id)">Delete</button>
							</div>
						</td>
					</tr>
					</template>
					<template v-else>
						<tr>
							<td align="center" colspan="6">No Record Found</td>
						</tr>
					</template>
				</tbody>
			</table>
		</div>
	</div>
</template>

<script>
	import ClipLoader from 'vue-spinner/src/ClipLoader';

	export default {
		data() {
			return {
				libraries:[],
				libraryTypes: {
					1:'Type 1',
					2:'Type 2',
					3:'Type 3',
				},
				isLoading:true
			}
		},
		components: {
			ClipLoader
		},
		created() {
			const siteUrl = document.querySelector("meta[name='site-url']").getAttribute("content")
			axios.get(siteUrl + '/api/libraries')
				  .then(response => {
				  	this.libraries = response.data.data
				  })
				  .catch(error => {
						this.$toasted.error(error,{
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
					 })
				  .finally(() => this.isLoading = false)
		},
		methods: {
			deleteLibrary(id) {
				let confirmMsg = confirm('Are you sure to delete this library?');
				if(!confirmMsg) {
					return;
				}
				this.isLoading = true
				const siteUrl = document.querySelector("meta[name='site-url']").getAttribute("content")
				axios.delete(`${siteUrl}/api/library/delete/${id}`)
					 .then(response => {
						 if(response.data.success) {
							 this.$toasted.success(response.data.message,{
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
							 let i = this.libraries.map(item => item.id).indexOf(id); // find index of your object
					 		 this.libraries.splice(i, 1)
						 }else {
							 this.$toasted.error(response.data.message,{
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
						this.$toasted.error(error,{
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
					 })
				  .finally(() => this.isLoading = false)
			}
		}
	}
</script>