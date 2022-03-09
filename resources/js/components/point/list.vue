<template>
  <div class="row" id="app">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4>
            User Points
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
                    <th>Id</th>
                    <th>Total Points</th>
                    <th>Update At</th>
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
    async get_user(id) {
      const docRef = doc(db, "users", id);
      const docSnap = await getDoc(docRef);
      if (docSnap.exists()) {
        return docSnap.data();
      }
    },
    async get() {
      const q = query(collection(db, "Points"));
      const querySnapshot = await getDocs(q);
      const collections = querySnapshot;
      var tempCollection = [];
      var response_data = [];
      collections.forEach((collectionss) => {
        tempCollection.push(collectionss.data());
      });
      for (const collectionsss of tempCollection) {
        var userInfo = await this.get_user(collectionsss.userid);
        response_data.push({ detail: collectionsss, user: userInfo });
      }
      // async get() {
      //   var response_data = [];
      //   const q = query(collection(db, "Points"));
      //   const querySnapshot = await getDocs(q);
      //   querySnapshot.forEach(async function (docss, index) {
      //     // const docRef = doc(db, "users", docss.id);
      //     // const docSnap = await getDoc(docRef);
      //     // console.log(docSnap);
      //     response_data.push(docss.data());
      //     //   response_data.push({ detail: docss.data() }, { user: docSnap.data() });
      //   });
      this.loading = false;
      $("#myTable").DataTable({
        responsive: true,
        data: response_data,
        columns: [
          { data: "detail.userid" },
          { data: "detail.points" },
          { data: "detail.created" },
          {
            data: "detail.userid",
            render: function (data) {
              return (
                '<a href="' +
                Laravel.baseUrl +
                "point_view/" +
                data +
                '"class="btn btn-primary">History</a>'
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