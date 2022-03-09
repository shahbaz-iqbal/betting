<template>
  <div class="row" id="app">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4>
            Users<a v-bind:href="url" class="btn btn-success float-right"
              >User Add</a
            >
            <div v-if="loading">
              <div class="d-flex justify-content-center mb-3">
                <b-spinner label="Loading..."></b-spinner>
              </div>
            </div>
          </h4>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <table id="myTable" class="table table-bordered mt-5">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Country</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody></tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import axios from "axios";
import $ from "jquery";
import { BSpinner } from "bootstrap-vue";
Vue.component("b-spinner", BSpinner);
export default {
  mounted() {
    this.getUsers();
  },
  data() {
    return {
      loading: true,
      url: Laravel.baseUrl + "user_add",
    };
  },
  methods: {
    getUsers() {
      this.loading = true;
      axios
        .get(Laravel.baseUrl + "showAll")
        .then((response) => {
          this.loading = false;
          $("#myTable").DataTable({
            // dom: "Bfrtip",
            responsive: true,
            data: response.data,
            columns: [
              { data: "id" },
              { data: "name" },
              { data: "email" },
              { data: "country" },
              {
                data: "id",
                render: function (data) {
                  return (
                    "<a href=" +
                    Laravel.baseUrl +
                    "user_edit/" +
                    data +
                    ' class="btn btn-primary" id="edit">  edit</a>'
                  );
                },
              },
            ],
          });
        })
        .catch((error) => console.log(error.response));
    },
  },
};
</script>

<style></style>