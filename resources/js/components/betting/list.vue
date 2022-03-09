<template>
  <div class="row" id="app">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4>
            User Betting
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
                    <!-- <th>Image</th> -->
                    <th>Name</th>
                    <th>Total Points</th>
                    <th>Total Win</th>
                    <th>Total Spend</th>
                    <th>Total lose</th>
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
  },
  data() {
    return {
      loading: true,
    };
  },
  methods: {
    async get_user(id) {
      const docRef = doc(db, "users", id);
      const docSnap = await getDoc(docRef);
      if (docSnap.exists()) {
        return docSnap.data();
      }
    },
    async get() {
      var response_data = [];
      const q = query(collection(db, "UserBettings"));
      const querySnapshot = await getDocs(q);
       if (querySnapshot) {
        // wrap loop in async function call iife so we can use await inside
        (async () => {
          for (var i = 0; i < querySnapshot.length; i++) {
            const doc = querySnapshot[i];
            myobject = doc.data();
            myobject.id = doc.id;
            // this will be synchronous now
            let eqp = await fb.equiposCollection.doc(myobject.id).get();
            console.log(eqp.id);
            // myarray.push(myobject)
          }
        })();
      }
      querySnapshot.forEach(async function (docss, index) {
        // console.log(index);
        response_data.push(docss.data());
        // const docRef = doc(db, "users", docss.id);
        // const docSnap = await getDoc(docRef);

        // console.log(docSnap.data());
        // var dcj = await get_user("docss.id");

        //   response_data.push({ index: docSnap.data() });
        //   response_data.push({ detail: docss.data() }, { user: docSnap.data() });
      });
      console.log(response_data);
      this.loading = false;
      $("#myTable").DataTable({
        responsive: true,
        data: response_data,
        columns: [
          //   {
          //     data: "championship.icon",
          //     render: function (data) {
          //       return (
          //         '<div class="p-2"><img src="' +
          //         data +
          //         '" alt="user" width="50" class="rounded-circle"></div>'
          //       );
          //     },
          //   },
          { data: "userid" },
          { data: "points.total" },
          { data: "points.win" },
          { data: "points.spend" },
          { data: "points.lose" },
          {
            data: "matchid",
            render: function (data) {
              return (
                '<a href="' +
                Laravel.baseUrl +
                "match_edit/" +
                data +
                '"  class="btn btn-primary">View</a><button type="button" class="btn btn-danger ml-1 delete" dalete_id="' +
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