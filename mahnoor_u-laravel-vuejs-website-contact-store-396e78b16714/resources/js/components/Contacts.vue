<template>
  <div>
    <head>

      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta name="description" content="">
      <meta name="author" content="">

      <title> The Contact Diary</title>

      <!-- Bootstrap core CSS -->
      <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

      <!-- Custom styles for this template -->
      <link href="css/scrolling-nav.css" rel="stylesheet">

    </head>


    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark" id="mainNav">
      <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="#home">Home</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#about">About</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#list">List</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#contact">New Contact</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <header id="#home" class="bg-primary text-white">
      <div class="container text-center">
        <h1>Welcome to our Online Contact Diary Website</h1>
        <p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor</p>
      </div>
    </header>

    <section id="about"class="bg-info text-white text-center">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 mx-auto">
            <h2>About our website</h2>
            <p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

          </div>
        </div>
      </div>
    </section>

    <section class="bg-primary text-white" id="contact">
      <div class="container ">
        <div class="row">
          <div class="col-lg-8 mx-auto">
            <h1 class="text-center">New Contact</h1>
            <form action="#" @submit.prevent="edit ? updateContact(contact.id) : createContact()">
              <div class="form-group">
                <label>Name</label>
                <input v-model="contact.name" type="text" name="name" class="form-control">
              </div>
              <div class="form-group">
                <label>Email</label>
                <input v-model="contact.email" type="text" name="email" class="form-control">
              </div>
              <div class="form-group">
                <label>Phone</label>
                <input v-model="contact.phone" type="text" name="phone" class="form-control">
              </div>
              <br>
              <div class="form-group text-center">
                <button v-show="!edit" type="submit" class="btn btn-light">Add Contact</button>
                <button v-show="edit" type="submit" class="btn btn-warning">Update Contact</button>
              </div>
            </form>
            </ul>
          </div>
        </div>
      </div>
    </section>

    <section id="list" class="bg-info text-white text-center">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 mx-auto">
            <h1>Contact Diary List </h1>
            <br>
            <ul class="list-group">
                <li v-for="contact in list" class="list-group-item list-group-item-action list-group-item-light">
                    <strong>{{ contact.name}}</strong> {{contact.email }} {{ contact.phone }}
                    <button @click="showContact(contact.id)" class="btn btn-warning btn-sm">Edit</button>
                    <button @click="deleteContact(contact.id)" class="btn btn-danger btn-sm">Delete</button>
                </li>
            </ul>
          </div>
        </div>
      </div>
    </section>








    <!-- Footer -->
    <footer class="py-5 bg-dark">
      <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; Your Website 2019</p>
      </div>
      <!-- /.container -->
    </footer>
  </body>
  </div>

</template>

<script>
  export default {
    data: function(){
      return {
        edit:false,
        list:[],
        contact:{
          id:'',
          name:'',
          email:'',
          phone:''
        }
      }
    },
    mounted: function(){
      console.log('Contacts Component Loaded...');
      this.fetchContactList();
    },
    methods: {
      fetchContactList:function(){
        console.log('Fetching contacts...');
        axios.get('api/contacts')
          .then((response) => {
            console.log(response.data);
            this.list = response.data;
          }).catch((error) => {
            console.log(error);
          });
      },
      createContact: function(){
        console.log('Creating contact...');
        let self = this;
        let params =Object.assign({}, self.contact);
        axios.post('api/contact/store', params)
          .then(function(){
            self.contact.name = '';
            self.contact.email = '';
            self.contact.phone = '';
            self.edit = false;
            self.fetchContactList();
          })
          .catch(function(error){
            console.log(error);
          });
      },
      showContact: function(id){
        let self = this;

        axios.get('api/contact/'+id)
            .then(function(response){
                self.contact.id = response.data.id;
                self.contact.name = response.data.name;
                self.contact.email = response.data.email;
                self.contact.phone = response.data.phone;
            })
            self.edit = true;
      },
      updateContact: function(id){
        console.log('Updating contact '+id+'...');
        let self = this;
        let params =Object.assign({}, self.contact);
        axios.patch('api/contact/'+id, params)
          .then(function(){
            self.contact.name = '';
            self.contact.email = '';
            self.contact.phone = '';
            self.edit = false;
            self.fetchContactList();
          })
          .catch(function(error){
            console.log(error);
          });
      },
      deleteContact: function(id){
        console.log('Deleting contact' + id);
        let self = this;

        axios.delete('api/contact/' +id)
        .then(function(response){
            self.fetchContactList();
        })
        .catch(function(error){
          console.log(error);
        });
      }
    }
  }
</script>
