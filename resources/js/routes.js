import AllLibraries from './components/libraries/AllLibraries.vue'
import AddLibrary from './components/libraries/AddLibrary.vue'
import EditLibrary from './components/libraries/EditLibrary.vue'
import Companies from './components/Companies.vue'
import NotFound from './components/pages/NotFound.vue'

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
	},
	{
		name:'companies',
		path:'/companies',
		component:Companies
	},
	{
		name:'404',
		path:'*',
		component:NotFound
	},
]