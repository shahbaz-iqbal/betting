<template>
  <div class="row">
    <div class="col-md-12">
      <div class="row">
        <div class="col-lg-3 col-md-6">
          <div class="card">
            <div class="card-body">
              <div class="row align-items-center">
                <div class="col-7">
                  <i class="mdi mdi-emoticon font-20 text-info"></i>
                  <p class="font-16 m-b-5">Total Users</p>
                </div>
                <div class="col-5">
                  <h1 class="font-light text-right mb-0">{{ user }}</h1>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6">
          <div class="card">
            <div class="card-body">
              <div class="row align-items-center">
                <div class="col-7">
                  <i class="mdi mdi-image font-20 text-success"></i>
                  <p class="font-16 m-b-5">Total Teams</p>
                </div>
                <div class="col-5">
                  <h1 class="font-light text-right mb-0">{{ team }}</h1>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6">
          <div class="card">
            <div class="card-body">
              <div class="row align-items-center">
                <div class="col-7">
                  <i class="mdi mdi-currency-eur font-20 text-purple"></i>
                  <p class="font-16 m-b-5">Total Matches</p>
                </div>
                <div class="col-5">
                  <h1 class="font-light text-right mb-0">{{ match }}</h1>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6">
          <div class="card">
            <div class="card-body">
              <div class="row align-items-center">
                <div class="col-7">
                  <i class="mdi mdi-poll font-20 text-danger"></i>
                  <p class="font-16 m-b-5">Total Categories</p>
                </div>
                <div class="col-5">
                  <h1 class="font-light text-right mb-0">{{ cat }}</h1>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <!-- column -->
        <div class="col-lg-6">
          <div class="card">
            <div class="card-header">
              <h4>
                Users
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
                        <th>Name</th>
                        <th>Email</th>
                        <th>Country</th>
                        <!-- <th>Action</th> -->
                      </tr>
                    </thead>
                    <tbody></tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- column -->
        <div class="col-lg-6">
          <div class="card">
            <div class="card-header">
              <h4>
                Teams
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
                  <table id="myTable1" class="table table-bordered mt-5">
                    <thead>
                      <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Category</th>
                        <!-- <th>Draw</th> -->
                        <!-- <th>Win</th> -->
                        <!-- <th>Lose</th> -->
                        <th>Country</th>
                        <!-- <th>Action</th> -->
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
  name: "categories",
  data() {
    return {
      loading: true,
      user: "",
      team: "",
      match: "",
      cat: "",
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
    this.userget();
    this.get();
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
      $("#myTable1").DataTable({
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
          // { data: "draw" },
          // { data: "win" },
          // { data: "lose" },
          { data: "country" },
          // {
          //   data: "teamid",
          //   render: function (data) {
          //     return (
          //       '<a href="' +
          //       Laravel.baseUrl +
          //       "team_edit/" +
          //       data +
          //       '"  class="btn btn-primary">Edit</a><button class="btn btn-danger ml-1" onclick="delete_this(' +
          //       data +
          //       ')">Delete</button>'
          //     );
          //   },
          // },
        ],
      });
    },
    async getCategories() {
      var set = this;
      axios
        .get(Laravel.baseUrl + "dashboard_count")
        .then(function (response) {
          console.log(response);
          set.user = response.data.total_user;
          set.team = response.data.total_team;
          set.match = response.data.total_match;
          set.cat = response.data.total_category;
        })
        .catch((error) => {
          this.errorMessage = error.message;
          console.error("There was an error!", error);
        });
    },
    async userget() {
      var response_data = [];
      // const querySnapshot = await getDocs(collection(db, "users"),where("type", "==", "user"));
      const q = query(collection(db, "users"), where("type", "==", "user"));
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
          // { data: "id" },
          { data: "name" },
          { data: "email" },
          { data: "country" },
          // {
          //   data: "id",
          //   render: function (data) {
          //     return (
          //       '<a href="' +
          //       Laravel.baseUrl +
          //       "user_edit/" +
          //       data +
          //       '"  class="btn btn-primary">Edit</a><button class="btn btn-danger ml-1" onclick="delete_this(' +
          //       data +
          //       ')">Delete</button>'
          //     );
          //   },
          // },
        ],
      });
    },
  },
};
</script>
