<template>
  <div class="row">
    <div class="col-12">
      <div class="card text-left">
        <div class="card-header">
          <h4>Category Add</h4>
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
          <form @submit="formSubmit" enctype="multipart/form-data">
            <!-- <input type="hidden" name="_token" :value="csrf"> -->
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
                <h4 class="card-title">Discription</h4>
                <div class="form-group">
                  <input
                    type="text"
                    class="form-control"
                    id=""
                    v-model="discription"
                    placeholder="Discription"
                  />
                </div>
              </div>
            </div>
            <div class="row mb-4">
              <div class="col-md-6">
                <h4 class="card-title">Image</h4>
                <input
                  type="file"
                  class="form-control"
                  v-on:change="onFileChange"
                />
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
      file: "",
        name: "",
        discription: "",
    };
  },
  methods: {
    onFileChange(e) {
      console.log(e.target.files[0]);
      this.file = e.target.files[0];
    },
    formSubmit(e) {
      const config = {
        headers: { "content-type": "multipart/form-data" },
      };
      let formData = new FormData();
      formData.append("file", this.file);
      formData.append("name", this.name);
      formData.append("discription", this.discription);
      var spinner = this;
      this.errors = [];
      if (this.name && this.discription) {
        let currentObj = this;
        this.loading = true;
        axios
          .post(
            Laravel.baseUrl + "category_insert",
            formData,
            config
          )
          .then(function (response) {
                window.location = Laravel.baseUrl + "categories";
          })
          .catch(function (error) {
            currentObj.output = error;
          });
      }

      if (!this.name) {
        this.errors.push("Name required.");
      }
      if (!this.discription) {
        this.errors.push("Discription required.");
      }
      // if (!this.data.image) {
      //   this.errors.push("Image required.");
      // }
      e.preventDefault();
    },
    spinner() {
      this.loading = false;
    },
  },
};
</script>