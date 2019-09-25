<template>
    <div id="not-found" class="text-center">
        <h1>Oops!</h1>
         <h2>404 Not Found</h2> 
         <p>Sorry, an error has occured, Requested page not found!</p>
         <router-link :to="{name:'/'}" class="btn btn-primary">Take me Home</router-link>
    </div>
</template>

<script>
	import ClipLoader from 'vue-spinner/src/ClipLoader';
	import Datepicker from 'vuejs-datepicker';
	import vSelect from 'vue-select'
	import 'vue-select/dist/vue-select.css';

	export default {
		
	}
</script>