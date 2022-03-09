<template>
  <div class="row" id="app">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4>
            Users Withdraws
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
import $ from "jquery";
import { BSpinner } from "bootstrap-vue";
Vue.component("b-spinner", BSpinner);

import { getFirestore } from "firebase/firestore";
import { collection, query, where, getDocs } from "firebase/firestore";

const db = getFirestore();
export default {
  mounted() {
    // this.getUsers();
    this.userget();
  },
  data() {
    return {
      loading: true,
      url: Laravel.baseUrl + "user_add",
    };
  },
  methods: {
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
          { data: "id" },
          { data: "name" },
          { data: "email" },
          { data: "country" },
          {
            data: "id",
            render: function (data) {
              return (
                '<a href="' +
                Laravel.baseUrl +
                "withdraw_view/" +
                data +
                '"  class="btn btn-primary">History</a>'
              );
            },
          },
        ],
      });
    },
  },
};
</script>

<style></style>