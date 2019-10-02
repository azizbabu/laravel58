<template>
    <div id="post-wrapper">
         <div v-if="isLoading">
            <div class="overlay">
                <clip-loader size="100px" class="overlay-content"></clip-loader>
            </div>
        </div>

        <div v-if="isPostList" id="postListArea">
            <h3>All Posts
				<button class="btn btn-sm btn-info float-right" @click.prevent="showPostCreateForm">Add New</button>
			</h3>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th width="7%">Type</th>
                            <th width="10%">Posted Date</th>
                            <th width="22%">Created at</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template v-if="posts.hasOwnProperty('data') && posts.data.length">
                        <tr v-for="post in posts.data" :key="post.id">
                            <td>{{ post.title }}</td>
                            <td>{{ postTypeList[post.type] }}</td>
                            <td>{{ post.post_date }}</td>
                            <td>{{ formatDate(new Date(post.created_at), true) }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button class="btn btn-sm btn-primary" @click.prevent="showEditForm(post.id)">Edit</button>
                                    <button class="btn btn-sm btn-danger" @click.prevent="deletePost(post.id)">Delete</button>
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
				
				<pagination :data="posts" @pagination-change-page="getPostList"></pagination>
            </div>
        </div>

		
        <!-- Post Modal -->
        <div class="modal fade" id="postModal" tabindex="-1" role="dialog" aria-labelledby="postModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form> 
                        <div class="modal-header">
                            <template v-if="isAddPost">
                                <h3 class="text-center">Add Post</h3>
                            </template>
                            <template v-else>
                                <h3 class="text-center">Edit Post</h3>
                            </template>	
                        </div>

                        <div class="modal-body"> 
                            <div class="form-group">
                                <label for="name">Post Title</label>
                                <input type="text" name="title" v-model="post.title" id="name" class="form-control" placeholder="Enter Post Title">
                                <div v-if="errors.title" class="text-danger">
                                    {{ errors.title[0] }}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="content">Content</label>
                                <textarea type="text" name="content" v-model="post.content" id="content" class="form-control" placeholder="Enter Post Content" rows="5"></textarea>
                                <!-- <vue-ckeditor 
                                v-model="post.address" 
                                :config="config" /> -->
                            </div>
                            <div class="form-group">
                                <label for="post-types">Post Types:</label>
                                <v-select placeholder="Select a Post Type" v-model="post.type" :value="$store.getters.getPost.type"  @input="setSelected" :options="postTypes" :reduce="label => label.code" label="label"></v-select>
                                <div v-if="errors.type" class="text-danger">
                                    {{ errors.type[0] }}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="post_date">Posted Date:</label>
                                <vuejs-datepicker v-model="post.post_date" input-class="form-control bg-light" format="yyyy-MM-dd" placeholder="YYYY-MM-DD"></vuejs-datepicker>
                                <div v-if="errors.post_date" class="text-danger">
                                    {{ errors.post_date[0] }}
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <template v-if="isAddPost">	
                                <button class="btn btn-primary" @click.prevent="addPost" :disabled="readOnly">Add Post</button>
                            </template>
                            <template v-else>	
                                <button class="btn btn-primary" @click.prevent="editPost" :disabled="readOnly">Edit Post</button>
                            </template>  
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /Post Modal -->
		
    </div>
</template>

<script>
	import ClipLoader from 'vue-spinner/src/ClipLoader';
	import Datepicker from 'vuejs-datepicker';
	import vSelect from 'vue-select'
	import 'vue-select/dist/vue-select.css';

	export default {
		data() {
			return {
				posts:{},
				postTypes: [
					{label:'Type 1', code : 1},
					{label:'Type 2', code : 2},
					{label:'Type 3', code : 3}
				],
				postTypeList: {
					1:'Type 1',
					2:'Type 2',
					3:'Type 3',
				},
				isLoading:true,
				isPostList:true,
				isAddPost:false,
				errors:[],
				readOnly:false,
                siteUrl:this.$store.getters.getSiteUrl,
                selected:'',
                currentPost:{},
			}
		},
		computed: {
			post:{
				get() {
					return this.$store.getters.getPost
				},
				set(post) {
					this.$store.commit('setPost', post)
				}
			}
		},
		components: {
			ClipLoader,
			'vuejs-datepicker' : Datepicker,
            'v-select':vSelect,
		},
		created() {
			this.getPostList()
		},
		methods: {
			getPostList(page = 1) {
				axios.get(this.siteUrl + '/api/posts?page=' + page)
				  .then(response => {
				  	this.posts = response.data
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
			showPostCreateForm() {
				this.isAddPost = true
                this.errors = []
                $('#postModal').modal()
			},
			formatDate(date, createdAt = false) {
				const monthNames = ["January", "February", "March", "April", "May", "June",
					"July", "August", "September", "October", "November", "December"
				];

				let years = date.getFullYear()
				let months = date.getMonth()+1
				months = months < 10 ? `0${months}` : months
				let days = date.getDate()
				days = days < 10 ? `0${days}` : days			
				let hours = date.getHours();
				let minutes = date.getMinutes();
				let ampm = hours >= 12 ? 'pm' : 'am';
				hours = hours % 12;
				hours = hours ? hours : 12; // the hour '0' should be '12'
				hours = hours < 10 ? '0'+hours : hours;
				minutes = minutes < 10 ? '0'+minutes : minutes;
				let strTime = hours + ':' + minutes + ' ' + ampm;
				
				if(createdAt) {
					return `${days} ${monthNames[date.getMonth()]}, ${years} ${strTime}`
				}

				return `${years}-${months}-${days}`
			},
			resetPostData() {
				this.post = {
					id:'',
					title:'',
					content:'',
					type:'',
					post_date:''
				}
				this.$store.commit('setPost', this.post)
			},
			addPost() {
				this.isLoading = true
				this.readOnly = true
				
				axios.post(`${this.siteUrl}/api/posts`,this.post)
					 .then(response => {
						 if(response.data.success) {
							 setTimeout(()=> {
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
                                this.resetPostData()
                                $('#postModal').modal('hide')
								this.isAddPost = false
								this.errors = []
								this.getPostList()
							 }, 1000)
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
						if(error.response.status == 422){
							this.errors = error.response.data.errors;
						} else{
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
						}
					 })
					 .finally(() => {
						 this.isLoading = false
						 this.readOnly = false
					 })
            },
            setSelected(value) {
                this.post.type = value
                this.$store.commit('setPost', this.post)
            },
			showEditForm(postId) {
				let matchArr = []
				matchArr = this.posts.data.filter(post => {
					return post.id === postId ? post: ''
				})
				if(matchArr.length) {
					this.currentPost = matchArr[0]
					this.post = this.currentPost
					this.$store.commit('setPost', this.post)
					this.isAddPost = false
					$('#postModal').modal()
				}
				this.errors = []
            },
            updated() {
                this.$store.commit('setPost', this.post)
            },
			editPost() {
				this.isLoading = true
				this.readOnly = true
				
				axios.patch(`${this.siteUrl}/api/posts/${this.post.id}`,this.post)
					 .then(response => {
						 if(response.data.success) {
							 setTimeout(()=> {
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
								this.resetPostData()
								this.isPostList = true
								this.isAddPost = false
								this.errors = []
                                this.getPostList()
                                $('#postModal').modal('hide')
							 }, 1000)
						 } else {
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
						if(error.response.status == 422){
							this.errors = error.response.data.errors;
						} else{
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
						}
					 })
					 .finally(() => {
						 this.isLoading = false
						 this.readOnly = false
					  })
			},
			deletePost(id) {
				let confirmMsg = confirm('Are you sure to delete this post?');
				if(!confirmMsg) {
					return;
				}
				this.isLoading = true
				axios.delete(`${this.siteUrl}/api/posts/${id}`)
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
                             let i = this.posts.data.map(item => item.id).indexOf(id); // find index of your object
					 		 this.posts.data.splice(i, 1) // remove one post with i index
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