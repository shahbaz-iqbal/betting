<template>
  <div class="row" id="app">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4>
            Withdraws History
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
                    <th>Phone</th>
                    <th>Account No</th>
                    <th>Points</th>
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
import {
  collection,
  query,
  where,
  getDoc,
  getDocs,
  doc,
} from "firebase/firestore";
const db = getFirestore();
export default {
  mounted() {
    this.get();
    // this.created();
  },
  data() {
    return {
      // items: [],
      loading: true,
    };
  },
  methods: {
    // async get_user(id) {
    //   var user_d = [];

    //   const docRef = doc(db, "users", id);
    //   const docSnap = await getDoc(docRef);
    //   if (docSnap.exists()) {
    //     return docSnap.data();
    //   }
    // },
    async get() {
      var response_data = [];
      //   const q = query(collection(db, "Points/PointsHistory"));
      //   const q = doc(db, "Points", "PointsHistory");
      const q = query(
        collection(
          db,
          "Withdraws",
          document.getElementById("hello").innerHTML,
          "WithdrawalHistory"
        )
      );
      const querySnapshot = await getDocs(q);
      querySnapshot.forEach(async function (docss, index) {
        // const docRef = doc(db, "users", docss.id);
        // const docSnap = await getDoc(docRef);
        response_data.push({ data: docss.data(), id: docss.id });
        // response_data.push([index => "Asx"]);
        //   response_data.push({ detail: docss.data() }, { user: docSnap.data() });
      });
      this.loading = false;
      $("#myTable").DataTable({
        responsive: true,
        data: response_data,
        columns: [
          { data: "data.billing_info.name" },
          { data: "data.billing_info.phone" },
          { data: "data.billing_info.acc_number" },
          { data: "data.points" },
          { data: "data.status" },
          {
            data: "id",
            render: function (data, row) {
              var r =
                '<a href="' +
                Laravel.baseUrl +
                "withdraw_edit/" +
                data +
                "/" +
                document.getElementById("hello").innerHTML +
                '"  class="btn btn-primary">Edit</a>';
              //   function toDateTime(secs) {
              var t = new Date(1970, 0, 1); // Epoch
              t.setSeconds(data);
              return r;
              //   }
            },
          },
        ],
      });
    },
  },
};
</script>

<style></style>