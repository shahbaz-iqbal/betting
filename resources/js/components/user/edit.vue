<template>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4>User Edit</h4>
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
                    v-model="category.name"
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
                    v-model="category.email"
                    placeholder="Email"
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
                    v-model="category.country"
                    :country="country"
                    topCountry="US"
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
                    v-model="category.password"
                    placeholder="Password"
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
import { BSpinner } from "bootstrap-vue";
Vue.component("b-spinner", BSpinner);
export default {
  props: ["identifier"],
  mounted() {
    this.showCategory();
  },
  data() {
    return {
      show: this.identifier,
      loading: false,
      errors: [],
      edit_data1: [],
      country:"",
      category: {
        name: "",
        email: "",
        // phone: "",
        password: "",
        country: "",
        id: "",
      },
    };
  },
  methods: {
    formSubmit(e) {
      var self = this;
      var spinner = this;
      this.errors = [];
      // if (
      //   this.name &&
      //   this.email &&
      //   // this.phone &&
      //   this.password &&
      //   this.country
      // ) {
      let currentObj = this;
      this.loading = true;
      axios
        .post(Laravel.baseUrl + "user_update", this.category)
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
      //  }

      // if (!this.name) {
      //   this.errors.push("Name required.");
      // }
      // if (!this.email) {
      //   this.errors.push("Email required.");
      // }
      // if (!this.phone) {
      //   this.errors.push("Phone required.");
      // }
      // if (!this.password) {
      //   this.errors.push("Password required.");
      // }
      // if (!this.country) {
      //   this.errors.push("Country required.");
      // }
      e.preventDefault();
    },
    async showCategory() {
      await axios
        .get(
          Laravel.baseUrl +
            "user_edit_data/" +
            document.getElementById("hello").innerHTML
        )
        .then((response) => {
          console.log(response.data);
          const { name, email, password, country, id } = response.data;
          this.category.id = id;
          this.category.name = name;
          this.category.email = email;
          this.category.password = password;
          this.country = country;
          this.category.country = country;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    spinner() {
      this.loading = false;
    },
    emailValidation() {
      this.errors.push("Somethig Went Wrong!");
    },
  },
};
</script>