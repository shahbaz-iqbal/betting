<template>
  <div class="row" id="app">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4>
            Categories<a v-bind:href="url" class="btn btn-success float-right"
              >Category Add</a
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
                    <th>Image</th>
                    <th>Name</th>
                    <th>Discription</th>
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
      userData: "",
      url: Laravel.baseUrl + "category_add",
    };
  },
  methods: {
    getUsers() {
      this.loading = true;
      axios
        .get(Laravel.baseUrl + "category_all")
        .then((response) => {
          this.loading = false;
          $("#myTable").DataTable({
            responsive: true,
            data: response.data,
            columns: [
              {
                data: "icon",
                render: function (data) {
                  return (
                    '<div class="p-2"><img src="' +
                    data +
                    '"alt="user" width="50" class="rounded-circle"></div>'
                  );
                },
              },
              { data: "name" },
              { data: "discription" },
              {
                data: "categoryid",
                render: function (data) {
                  return (
                    '<a href="' +
                    Laravel.baseUrl +
                    "category_edit/" +
                    data +
                    '"  class="btn btn-primary">Edit</a><button type="button" class="btn btn-danger ml-1 delete" dalete_id="' +
                    data +
                    '">Delete</button>'
                  );
                },
              },
            ],
          });
        })
        .catch((error) => console.log(error.response));
      var userVue = this;
      $("#myTable").on("click", "tbody .delete", function () {
        var delete_id = $(this).attr("dalete_id");
        swal({
          title: "Are you sure?",
          text: "Once deleted, you will not be able to recover this imaginary file!",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        }).then((willDelete) => {
          if (willDelete) {
            axios
              .get(Laravel.baseUrl + "category_delete/" + delete_id)
              .then((response) => {
                // swal("Poof! Your imaginary file has been deleted!", {
                //   icon: "success",
                // });
                location.reload();
              })
              .catch((error) => {
                console.log(error);
              });
          } else {
            swal("Your imaginary file is safe!");
          }
        });
      });
    },
  },
};
</script>

<style></style>