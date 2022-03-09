<template>
  <div class="row" id="app">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4>
            Teams<a v-bind:href="url" class="btn btn-success float-right"
              >Team Add</a
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
                    <th>Category</th>
                    <th>Draw</th>
                    <th>Win</th>
                    <th>Lose</th>
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
import $ from "jquery";
import { BSpinner } from "bootstrap-vue";
Vue.component("b-spinner", BSpinner);
import { getFirestore } from "firebase/firestore";
import { collection, query, where, getDocs } from "firebase/firestore";
const db = getFirestore();
export default {
  mounted() {
    this.get();
  },
  data() {
    return {
      loading: true,
      url: Laravel.baseUrl + "team_add",
    };
  },
  methods: {
    async get() {
      var response_data = [];
      // const querySnapshot = await getDocs(collection(db, "users"),where("type", "==", "user"));
      const q = query(collection(db, "Teams"));
      const querySnapshot = await getDocs(q);
      querySnapshot.forEach((doc) => {
        response_data.push(doc.data());
      });
      this.loading = false;
      console.log(response_data);
      $("#myTable").DataTable({
        responsive: true,
        data: response_data,
        columns: [
          {
            data: "icon",
            render: function (data) {
              return (
                '<img src="' +
                data +
                '" alt="user" width="40" class="rounded-circle">'
              );
            },
          },
          { data: "name" },
          { data: "type" },
          { data: "draw" },
          { data: "win" },
          { data: "lose" },
          { data: "country" },
          {
            data: "teamid",
            render: function (data) {
              return (
                '<a href="' +
                Laravel.baseUrl +
                "team_edit/" +
                data +
                '"  class="btn btn-primary">Edit</a><button class="btn btn-danger ml-1" onclick="delete_this(' +
                data +
                ')">Delete</button>'
              );
            },
          },
        ],
      });
    },
    // getUsers() {
    //   this.loading = true;
    //   axios
    //     .get(Laravel.baseUrl + "showAll")
    //     .then((response) => {
    //       this.loading = false;
    //       console.log(response.data);
    //       $("#myTable").DataTable({
    //         responsive: true,
    //         data: response.data,
    //         columns: [
    //           { data: "id" },
    //           { data: "name" },
    //           { data: "email" },
    //           { data: "country" },
    //           {
    //             data: "id",
    //             render: function (data) {
    //               return (
    //                 '<a href="' +
    //                 Laravel.baseUrl +
    //                 "user_edit/" +
    //                 data +
    //                 '"  class="btn btn-primary">Edit</a><button class="btn btn-danger ml-1" onclick="delete_this(' +
    //                 data +
    //                 ')">Delete</button>'
    //               );
    //             },
    //           },
    //         ],
    //       });
    //     })
    //     .catch((error) => console.log(error.response));
    // },
  },
};
</script>

<style></style>