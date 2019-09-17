import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex)

export const store = new Vuex.Store({
    state: {
        siteUrl:document.querySelector("meta[name='site-url']").getAttribute("content"),
        company: {
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
    },
    getters: {
        getSiteUrl: state => state.siteUrl,
        getCompany: state => state.company,
    },
    mutations:{
        setCompany(state, company) {
            state.company.id = company.id;
            state.company.name = company.name;
            state.company.owner_name = company.owner_name;
            state.company.owner_phone = company.owner_phone;
            state.company.type = company.type;
            state.company.address = company.address;
            state.company.establish_date = company.establish_date;
            state.company.logo = company.logo;
            state.company.logoObj = company.logoObj;
        }
    }
})