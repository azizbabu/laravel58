<template>
    <div id="company-wrapper">
         <div v-if="isLoading">
            <div class="overlay">
                <clip-loader size="100px" class="overlay-content"></clip-loader>
            </div>
        </div>

        <div v-if="isCompanyList" id="companyListArea">
            <h3>All Companies
				<button class="btn btn-sm btn-info float-right" @click.prevent="showCompanyCreateForm">Add New</button>
			</h3>
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
                        <template v-if="companies.hasOwnProperty('data') && companies.data.length">
                        <tr v-for="company in companies.data" :key="company.id">
                            <td>{{ company.name }}</td>
                            <td>{{ company.owner_name }}</td>
                            <td>{{ companyTypeList[company.type] }}</td>
                            <td>{{ company.establish_date }}</td>
                            <td>{{ company.created_at }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button class="btn btn-sm btn-primary" @click.prevent="showEditForm(company.id)">Edit</button>
                                    <button class="btn btn-sm btn-danger" @click.prevent="deleteCompany(company.id)">Delete</button>
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
				
				<pagination :data="companies" @pagination-change-page="getCompanyList"></pagination>
            </div>
        </div>

		<div v-else id="companyFormArea">
			<template v-if="isAddCompany">
				<h3 class="text-center">Add Company</h3>
			</template>
			<template v-else>
				<h3 class="text-center">Edit Company</h3>
			</template>	
			<div class="row">
				<div class="col-md-6">
					<form>
						<div class="form-group">
							<label for="name">Company Name</label>
							<input type="text" name="name" v-model="company.name" id="name" class="form-control" placeholder="Enter Company name">
							<div v-if="errors.name" class="text-danger">
								{{ errors.name[0] }}
							</div>
						</div>
						<div class="form-group">
							<label for="owner">Owner Name</label>
							<input type="text" name="owner_name" v-model="company.owner_name" id="owner_name" class="form-control" placeholder="Enter Owner Name">
							<div v-if="errors.owner_name" class="text-danger">
								{{ errors.owner_name[0] }}
							</div>
						</div>
						<div class="form-group">
							<label for="owner">Owner Phone</label>
							<input type="text" name="owner_phone" v-model="company.owner_phone" id="owner_phone" class="form-control" placeholder="Enter Owner Phone">
							<div v-if="errors.owner_phone" class="text-danger">
								{{ errors.owner_phone[0] }}
							</div>
						</div>
						<div class="form-group">
							<label for="address">Address</label>
							<textarea type="text" name="address" v-model="company.address" id="address" class="form-control" placeholder="Enter Company Address"></textarea>
							<!-- <vue-ckeditor 
							v-model="company.address" 
							:config="config" /> -->
						</div>
						<div class="form-group">
							<label for="company-types">Company Types:</label>
							<v-select placeholder="Select a Company Type" v-model="company.type" :options="companyTypes" :reduce="label => label.code" label="label"></v-select>
							<div v-if="errors.type" class="text-danger">
								{{ errors.type[0] }}
							</div>
						</div>
						<div class="form-group">
							<label for="establish_date">Established Date:</label>
							<vuejs-datepicker v-model="company.establish_date" input-class="form-control bg-light" format="yyyy-MM-dd" placeholder="YYYY-MM-DD"></vuejs-datepicker>
							<div v-if="errors.establish_date" class="text-danger">
								{{ errors.establish_date[0] }}
							</div>
						</div>
						<div class="form-group">
							<label for="logo">Upload Logo</label>
							<input type="file" name="logo" id="logo" @change="onFileChange" class="form-control-file">
							<div v-if="errors.logo" class="text-danger">
								{{ errors.logo[0] }}
							</div>
							<template v-if="!isAddCompany && this.company.logo">
								<img :src="siteUrl+'/uploads/'+this.company.logo" alt="Logo" width="200">
							</template>
						</div>		
						<template v-if="isAddCompany">	
							<button class="btn btn-primary" @click.prevent="addCompany">Add Company</button>
							<button class="btn btn-danger" @click.prevent="isCompanyList=true">Back</button>
						</template>
						<template v-else>	
							<button class="btn btn-primary" @click.prevent="editCompany">Edit Company</button>
							<button class="btn btn-danger" @click.prevent="isCompanyList=true">Back</button>
						</template>
					</form>
				</div>
			</div>
		</div>
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
				companies:{},
				companyTypes: [
					{label:'Type 1', code : 1},
					{label:'Type 2', code : 2},
					{label:'Type 3', code : 3}
				],
				companyTypeList: {
					1:'Type 1',
					2:'Type 2',
					3:'Type 3',
				},
				file:'',
				isLoading:true,
				isCompanyList:true,
				isAddCompany:false,
				// company:{},
				errors:[],
				siteUrl:this.$store.getters.getSiteUrl
			}
		},
		computed: {
			company:{
				get() {
					return this.$store.getters.getCompany
				},
				set(company) {
					this.$store.commit('setCompany', company)
				}
			}
		},
		components: {
			ClipLoader,
			'vuejs-datepicker' : Datepicker,
            'v-select':vSelect,
		},
		created() {
			// const siteUrl = document.querySelector("meta[name='site-url']").getAttribute("content")
			// const siteUrl = this.$store.getters.getSiteUrl
			// axios.get(this.siteUrl + '/api/companies')
			// 	  .then(response => {
			// 	  	this.companies = response.data.data
			// 	  })
			// 	  .catch(error => {
			// 			this.$toasted.error(error,{
			// 				position: 'top-center',
			// 				theme: 'bubble',
			// 				duration: 10000,
			// 				action : {
			// 					text : 'Close',
			// 					onClick : (e, toastObject) => {
			// 						toastObject.goAway(0);
			// 					}
			// 				},
			// 			});
			// 		 })
			// 	  .finally(() => this.isLoading = false)
			this.getCompanyList()
		},
		methods: {
			getCompanyList(page = 1) {
				const siteUrl = this.$store.getters.getSiteUrl
				axios.get(this.siteUrl + '/api/companies?page=' + page)
				  .then(response => {
				  	this.companies = response.data
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
			showCompanyCreateForm() {
				this.isCompanyList = false
				this.isAddCompany = true
				this.errors = []
			},
			onFileChange(e) {
				// console.log(e.target.files[0])
				this.file = e.target.files[0]
				this.company.logoObj = this.file
				this.$store.commit('setCompany', this.company)
			},
			formatDate(date) {
				var hours = date.getHours();
				var minutes = date.getMinutes();
				var ampm = hours >= 12 ? 'pm' : 'am';
				hours = hours % 12;
				hours = hours ? hours : 12; // the hour '0' should be '12'
				minutes = minutes < 10 ? '0'+minutes : minutes;
				var strTime = hours + ':' + minutes + ' ' + ampm;
				/* return date.getMonth()+1 + "/" + date.getDate() + "/" + date.getFullYear() + " " + strTime; */
				return `${date.getFullYear()}-${date.getMonth()+1}-${date.getDate()}`
			},
			resetCompanyData() {
				this.company = {
					id:'',
					name:'',
					owner_name:'',
					owner_phone:'',
					type:'',
					address:'',
					establish_date:'',
					logo:'',
					logoObj:''
				}
				this.$store.commit('setCompany', this.company)
			},
			addCompany() {
				var _this = this
				this.isLoading = true
				const siteUrl = this.$store.getters.getSiteUrl
				
				const formData = new FormData();
				if(this.company.name) {
					formData.append('name', this.company.name);
				}
				if( this.company.owner_name) {
					formData.append('owner_name', this.company.owner_name);
				}
                if(this.company.owner_phone) {
					formData.append('owner_phone', this.company.owner_phone);
				}
                if(this.company.address) {
					formData.append('address', this.company.address);
				}
                if(this.company.type) {
					formData.append('type', this.company.type);
				}
				if(this.company.establish_date) {
					formData.append('establish_date', this.formatDate((new Date(this.company.establish_date))));
				}
				// formData.append('logo', this.file);
				formData.append('logo', this.company.logoObj);
				
				axios.post(`${siteUrl}/api/companies`,formData)
					 .then(response => {
						 if(response.data.success) {
							 this.companies = response.data.companies.data;
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
								this.resetCompanyData()
								this.isCompanyList = true
								this.isAddCompany = false
								this.errors = []
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
					 .finally(() => this.isLoading = false)
			},
			showEditForm(companyId) {
				let matchArr = []
				matchArr = this.companies.filter(company => {
					return company.id === companyId ? company: ''
				})
				if(matchArr.length) {
					this.company = matchArr[0]
					this.company.logoObj = ''
					this.$store.commit('setCompany', this.company)
					this.isCompanyList = false
					this.isAddCompany = false
				}
				this.errors = []
			},
			editCompany() {
				var _this = this
				this.isLoading = true
				const siteUrl = this.$store.getters.getSiteUrl
				
				const formData = new FormData();
				if(this.company.name) {
					formData.append('name', this.company.name);
				}
				if( this.company.owner_name) {
					formData.append('owner_name', this.company.owner_name);
				}
                if(this.company.owner_phone) {
					formData.append('owner_phone', this.company.owner_phone);
				}
                if(this.company.address) {
					formData.append('address', this.company.address);
				}
                if(this.company.type) {
					formData.append('type', this.company.type);
				}
				if(this.company.establish_date) {
					formData.append('establish_date', this.formatDate((new Date(this.company.establish_date))));
				}
				// formData.append('logo', this.file);
				formData.append('logo', this.company.logoObj);
				formData.append('_method', 'PATCH');
				
				axios.post(`${siteUrl}/api/companies/${this.company.id}`,formData,{ withCredentials: true })
					 .then(response => {
						 if(response.data.success) {
							 this.companies = response.data.companies.data;
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
								this.resetCompanyData()
								this.isCompanyList = true
								this.isAddCompany = false
								this.errors = []
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
					 .finally(() => this.isLoading = false)
			},
			deleteCompany(id) {
				let confirmMsg = confirm('Are you sure to delete this company?');
				if(!confirmMsg) {
					return;
				}
				this.isLoading = true
				const siteUrl = this.$store.getters.getSiteUrl
				axios.delete(`${siteUrl}/api/companies/${id}`)
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
							 let i = this.companies.map(item => item.id).indexOf(id); // find index of your object
					 		 this.companies.splice(i, 1) // remove one company with i index
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