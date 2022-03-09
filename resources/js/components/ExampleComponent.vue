<template>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4>Category</h4>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table id="zero_config" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody v-if="categories.data !== ''">
                <tr v-for="(category, key) in categories.data" :key="key">
                  <td>{{ category.ID }}</td>
                  <td>{{ category.first_name }}</td>
                  <td>{{ category.email }}</td>
                  <td>action</td>
                </tr>
              </tbody>
              <tbody v-else>
                <tr>
                  <td colspan="4" align="center">No Categories Found.</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "categories",
  data() {
    return {
      categories: [],
      fields: ["first_name", "last_name", "age"],
      item: [
        {
          isActive: true,
          age: 40,
          first_name: "Dickerson",
          last_name: "Macdonald",
        },
        { isActive: false, age: 21, first_name: "Larsen", last_name: "Shaw" },
        { isActive: false, age: 89, first_name: "Geneva", last_name: "Wilson" },
        { isActive: true, age: 38, first_name: "Jami", last_name: "Carney" },
      ],
    };
  },
  mounted() {
    this.getCategories();
  },
  methods: {
    async getCategories() {
      axios
        .get("http://localhost/betting/public/showAll")
        // .then((response) => (this.categories = response))
        .then(function (response) {
          console.log(response.data);
        })
        .catch((error) => {
          this.errorMessage = error.message;
          console.error("There was an error!", error);
        });
    },
  },
};
</script>
