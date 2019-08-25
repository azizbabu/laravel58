import AllLibraries from './components/libraries/AllLibraries.vue'
import AddLibrary from './components/libraries/AddLibrary.vue'
import EditLibrary from './components/libraries/EditLibrary.vue'

export const routes = [
	{
		name:'home',
		path:'/',
		component:AllLibraries
	},
	{
		name:'add',
		path:'/add',
		component:AddLibrary
	},
	{
		name:'edit',
		path:'/edit/:id',
		component:EditLibrary
	}
]