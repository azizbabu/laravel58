<h2 align="center">Laravel58</h2>



## About Laravel58

Laravel58 is a testing and helping project built on laravel 5.8. Here two vue crud have been done - <strong>Library and Company CRUD</strong>. 

We install <strong>vue-router</strong>, <strong>vue-select</strong>, <strong>vue-spinner</strong>, <strong>vue-toasted</strong>, <strong>vuejs-datepicker</strong> and <strong>vuex</strong> npm package.

The main web route for vue crud is /test-vue/{any?} in web.php and corresponding api routes exist in api.php. Two differenet model files named Library and Company are created to handle different query and corresponding contrllers named LibraryController and CompanyController are created to control full functionalities and these controllers exist in API folder. All necessary vue files and necessary other js file exists in resoures/js folder. 

components/libraries folder contains all necessary library vue files for library crud 

components/companiues.vue handles all compoany view.  

store/store.js handle vuex state menagement

routes.js is contain vue routing info.

app.vue is the nery point of main vue

test-vue.js is the main js file where all necessary components, router, states are loaded.




