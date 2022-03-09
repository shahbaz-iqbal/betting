<template>
  <div class="row" id="app">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4>
            Matches<a v-bind:href="url" class="btn btn-success float-right"
              >Match Add</a
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
                    <th>Location</th>
                    <th>Status</th>
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
// import { TablePlugin } from 'bootstrap-vue'
// Vue.use(TablePlugin)
import { BTable } from "bootstrap-vue";
Vue.component("b-table", BTable);

import { getFirestore } from "firebase/firestore";
import { collection, query, where, getDocs } from "firebase/firestore";
const db = getFirestore();
export default {
  mounted() {
    this.get();
  },
  data() {
    return {
      // items: [],
      loading: true,
      url: Laravel.baseUrl + "match_add",
    };
  },
  methods: {
    async get() {
      var response_data = [];
      const q = query(collection(db, "Matches"));
      const querySnapshot = await getDocs(q);
      querySnapshot.forEach((doc) => {
        response_data.push(doc.data());
      });
      console.log(response_data);
      this.loading = false;
      $("#myTable").DataTable({
        columnDefs: [
          {
            defaultContent: "-",
            targets: "_all",
          },
        ],
        responsive: true,
        data: response_data,
        columns: [
          {
            data: "championship.icon",
            render: function (data) {
              return (
                '<div class="p-2"><img src="' +
                data +
                '" alt="user" width="50" class="rounded-circle"></div>'
              );
            },
          },
          { data: "championship.name" },
          { data: "category_name" },
          { data: "championship.location" },
          { data: "approval_status" },
          {
            data: "matchid",
            render: function (data, type, row) {
              console.log(data);
              console.log(row);
              return (
                '<a href="' +
                Laravel.baseUrl +
                "match_edit/" +
                data +
                '"  class="btn btn-primary">Edit</a> ' +
                (row.match_status == "Live"
                  ? '<a href="' +
                    Laravel.baseUrl +
                    "score_edit/" +
                    data +
                    '"  class="btn btn-success">Score Update</a>'
                  : "") +
                ' <button type="button" class="btn btn-danger ml-1 delete" dalete_id="' +
                data +
                '">Delete</button>'
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