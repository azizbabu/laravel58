<template>
	<div>
		<h3 class="text-center">All Libraries</h3>

		<div class="table-responsive">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>ID</th>
						<th>Name</th>
						<th>Owner</th>
						<th>Created at</th>
						<th>Updated at</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					<template v-if="libraries.length">
					<tr v-for="library in libraries" :key="library.id">
						<td>{{ library.id }}</td>
						<td>{{ library.title }}</td>
						<td>{{ library.owner }}</td>
						<td>{{ library.created_at }}</td>
						<td>{{ library.updated_at }}</td>
						<td>
							<div class="btn-group" role="group">
								<router-link :to="{name:'edit', params:{ id:library.id } }" class="btn btn-primary">Edit</router-link>
								<button class="btn btn-danger" @click="deleteLibrary(library.id)">Delete</button>
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
	export default {
		data() {
			return {
				libraries:[]
			}
		},
		created() {
			const siteUrl = document.querySelector("meta[name='site-url']").getAttribute("content")
			axios.get(siteUrl + '/api/libraries')
				  .then(response => {
				  	this.libraries = response.data
				  })
		},
		methods: {
			deleteLibrary(id) {
				const siteUrl = document.querySelector("meta[name='site-url']").getAttribute("content")
				axios.delete(`${siteUrl}/api/library/delete/${id}`)
					 .then(response => {
					 	let i = this.libraries.map(item => item.id).indexOf(id); // find index of your object
					 	console.log(i)
					 	this.libraries.splice(i, 1)
					 })
			}
		}
	}
</script>