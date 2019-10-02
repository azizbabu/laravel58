<h2 align="center">Laravel58</h2>



## About Laravel58

Laravel58 is a testing and helping project built on laravel 5.8. Here three vue crud have been done - <strong>Library, Company and Post CRUD</strong>. 

We install <strong>vue-router</strong>, <strong>vue-select</strong>, <strong>vue-spinner</strong>, <strong>vue-toasted</strong>, <strong>vuejs-datepicker</strong> and <strong>vuex</strong> npm package.

The main web route for vue crud is /test-vue/{any?} in web.php and corresponding api routes exist in api.php. Three differenet model files named Library, Company and Post are created to handle different query and corresponding contrllers named LibraryController, CompanyController and PostController are created to control full functionalities and these controllers exist in API folder. All necessary vue files and necessary other js file exists in resoures/js folder. 

* API Resource - Library.php, LibraryCollection.php, Company.php, CompanyCollection.php, Post.php and     PostCollection.php files in app/Http/Resources folder perform corresponding resource and resource       collection functionalities for proper transformation between model and response.

* Requests - Companies and Posts folders in app/Http/Requests/API folders perform corresponding custom    request functionalities i.e these allow to add rues and authorization.

* Policies - CompanyPolicy.php and PostPolicy.php in app/Policies folders perform corresponding 
  authorization functionalities.

* components/libraries folder contains all necessary library vue files for library crud 

* components/Companiues.vue handles all compoany view.  

* components/Posts.vue handles all compoany view.  

* store/store.js handle vuex state menagement

* routes.js is contain vue routing info.

* app.vue is the nery point of main vue

* test-vue.js is the main js file where all necessary components, router, states are loaded.




