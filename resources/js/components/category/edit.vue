<template>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4>Update Category</h4>
        </div>
        <div class="card-body">
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
                <input type="hidden" v-model="oldfile" />
                <input type="hidden" v-model="id" />
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
    this.showCategory();
  },
  data() {
    return {
      loading: false,
      errors: [],
      oldfile: "",
      file: "",
      name: "",
      discription: "",
      id: "",
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
      formData.append("oldfile", this.oldfile);
      formData.append("id", this.id);
      var spinner = this;
      this.errors = [];
      if (this.name && this.discription) {
        let currentObj = this;
        this.loading = true;
        axios
          .post(Laravel.baseUrl + "category_update", formData, config)
          .then(function (response) {
            console.log(response.data);
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
    async showCategory() {
      await axios
        .get(
          Laravel.baseUrl +
            "category_edit_data/" +
            document.getElementById("hello").innerHTML
        )
        .then((response) => {
          console.log(response.data);
          const { name, discription, categoryid, icon } = response.data;
          this.id = categoryid;
          this.name = name;
          this.discription = discription;
          this.oldfile = icon;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    spinner() {
      this.loading = false;
    },
  },
};
</script>