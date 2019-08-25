<template>
	<div class="container">
		<div class="text-center">
			<h3><a href="#/">Test Vue</a></h3>
			<span class="text-secondary">Laravel & Vue CRUD single Page Application(SPA)</span>
		</div>
		<nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
			<div class="collapse navbar-collapse">
				<div class="navbar-nav">
					<router-link to="/" class="nav-item nav-link">Home</router-link>
					<router-link to="/add" class="nav-item nav-link">Add Library</router-link>
				</div>
			</div>
		</nav>
		<router-view></router-view>	
	</div>
</template>

<script>
	export default {}
</script>