<template>
  <div class="row">
    <div class="col-12">
      <div class="card text-left">
        <div class="card-header">
          <h4>User Add</h4>
          <div v-if="loading">
            <div class="d-flex justify-content-center mb-3">
              <b-spinner label="Loading..."></b-spinner>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <div v-for="(error, key) in errors" :key="key">
                <div class="alert alert-danger" role="alert">
                  {{ error }}
                </div>
              </div>
            </div>
          </div>
          <form @submit="formSubmit">
            <div class="row">
              <div class="col-md-6">
                <h4 class="card-title">Name</h4>
                <div class="form-group">
                  <input
                    type="text"
                    class="form-control"
                    id=""
                    v-model="name"
                    placeholder="Name"
                  />
                </div>
              </div>
              <div class="col-md-6">
                <h4 class="card-title">Email</h4>
                <div class="form-group">
                  <input
                    type="text"
                    class="form-control"
                    id=""
                    v-model="email"
                    placeholder="Email"
                  />
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <h4 class="card-title">Phone No</h4>
                <div class="form-group">
                  <input
                    type="text"
                    class="form-control"
                    id=""
                    v-model="phone"
                    placeholder="Phone No"
                  />
                </div>
              </div>
              <div class="col-md-6">
                <h4 class="card-title">Password</h4>
                <div class="form-group">
                  <input
                    type="text"
                    class="form-control"
                    id=""
                    v-model="password"
                    placeholder="Password"
                  />
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <h4 class="card-title">Country</h4>
                <div class="form-group">
                  <country-select
                    class="form-control"
                    v-model="country"
                    :country="country"
                    topCountry="US"
                  />
                </div>
              </div>
            </div>
            <button class="btn btn-success">Submit</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>
 
<script>
export default {
  mounted() {
    console.log("Component mounted.");
  },
  data() {
    return {
      loading: false,
      errors: [],
      name: "",
      email: "",
      phone: "",
      password: "",
      country: "",
    };
  },
  methods: {
    formSubmit(e) {
      var self = this;
      var spinner = this;
      this.errors = [];
      if (
        this.name &&
        this.email &&
        this.phone &&
        this.password &&
        this.country
      ) {
        let currentObj = this;
        this.loading = true;
        axios
          .post(Laravel.baseUrl + "user_insert", {
            name: this.name,
            email: this.email,
            phone: this.phone,
            country: this.country.name,
            password: this.password,
          })
          .then(function (response) {
            if (response.data == "error") {
              console.log(response.data);
              spinner.spinner();
              self.emailValidation();
            } else {
              console.log(response.data);
              spinner.spinner();
              window.location = Laravel.baseUrl + "users";
            }
          })
          .catch(function (error) {
            currentObj.output = error;
          });
      }

      if (!this.name) {
        this.errors.push("Name required.");
      }
      if (!this.email) {
        this.errors.push("Email required.");
      }
      if (!this.phone) {
        this.errors.push("Phone required.");
      }
      if (!this.password) {
        this.errors.push("Password required.");
      }
      if (!this.country) {
        this.errors.push("Country required.");
      }
      e.preventDefault();
    },
    spinner() {
      this.loading = false;
    },
    emailValidation() {
      this.errors.push("Email Already Exist!");
    },
  },
};
</script>