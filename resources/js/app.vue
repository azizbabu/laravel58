<template>
	<div class="container">
		<div class="text-center">
			<h3><a href="#/">Test Vue</a></h3>
			<span class="text-secondary">Laravel & Vue CRUD single Page Application(SPA)</span>
		</div>
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
			<div class="collapse navbar-collapse">
				<ul class="navbar-nav">
					<li class="nav-item">
						<router-link to="/" class="nav-item nav-link">Library List</router-link>
					</li>
					<li class="nav-item">
						<router-link to="/add" class="nav-item nav-link">Add Library</router-link>
					</li>
					<li class="nav-item">
						<router-link to="/companies" class="nav-item nav-link">Company List</router-link>
					</li>
					<li class="nav-item">
						<router-link to="/posts" class="nav-item nav-link">Post List</router-link>
					</li>
				</ul>
			</div>
		</nav>
		<router-view></router-view>	
	</div>
</template>

<script>
	export default {}
</script>