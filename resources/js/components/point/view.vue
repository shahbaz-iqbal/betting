<template>
  <div class="row" id="app">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4>
            Points History
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
                    <th>Points</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Update At</th>
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
      // return id;
      const docRef = doc(db, "users", id);
      const docSnap = await getDoc(docRef);
      // return docSnap.data();
      if (docSnap.exists()) {
        return docSnap.data();
      }
    },
    async getFilePaths() {
      const q = query(
        collection(
          db,
          "Points",
          document.getElementById("hello").innerHTML,
          "PointsHistory"
        )
      );
      const querySnapshot = await getDocs(q);
      return querySnapshot;
    },
    async get() {
      const q = query(
        collection(
          db,
          "Points",
          document.getElementById("hello").innerHTML,
          "PointsHistory"
        )
      );
      const querySnapshot = await getDocs(q);
      const collections = querySnapshot;
      var tempCollection = [];
      var response_data = [];
      collections.forEach((collectionss) => {
        tempCollection.push(collectionss.data());
      });
      for (const collectionsss of tempCollection) {
        var userInfo = await this.get_user(collectionsss.user);
        response_data.push({ detail: collectionsss, user: userInfo });
      }

      // console.log("data posted")
      // return res.status(200).end(JSON.stringify({ status: 200, message: "Support Message fetched successfully.", data: data }))
      // }).catch(error => {
      //   return res.status(500).end(JSON.stringify({ status: 500, message: "Error: " + error }))
      // });

      // await Promise.all(Object.keys(data).map(async (elem) => {
      //   try {
      //     // here candidate data is inserted into
      //     let insertResponse = await this.get_user(elem.id)
      //     // and response need to be added into final response array
      //     // generatedResponse.push(insertResponse)
      //     response_data.push({ detail: docss.data() }, { user: docSnap.data() });
      //   } catch (error) {
      //     console.log('error'+ error);
      //   }
      // }))
      // console.log('complete all')

      //   const files = await this.getFilePaths();
      // // console.log(files);
      // files.forEach(async function (docss, index) {
      //   const dsac = await Promise.all(this.get_user(docss.id));

      // console.log(dsac);

      //         const docRef = doc(db, "users", "IGKzShLuigbcAVorwNsE26repTa2");
      //         const docSnap = await getDoc(docRef);
      // console.log(docSnap.data());

      // var response_data = [];
      //   const q = query(collection(db, "Points" , document.getElementById('hello').innerHTML , "PointsHistory"));
      // const querySnapshot = await getDocs(q);
      // console.log(querySnapshot);
      // querySnapshot.forEach(async function (docss, index) {
      //   const docRef = doc(db, "users", docss.id);
      //   const docSnap = await getDoc(docRef);
      //   console.log(docss.data());
      //   console.log(docSnap.data());
      // response_data.push(docss.data());
      // response_data.push({ detail: docss.data() }, { user: docSnap.data() });
      // });
      // console.log(response_data);
      this.loading = false;
      $("#myTable").DataTable({
        responsive: true,
        data: response_data,
        columns: [
          { data: "detail.points" },
          { data: "detail.status" },
          {
            data: "detail.created.seconds",
            render: function (data) {
              //   function toDateTime(secs) {
              var t = new Date(1970, 0, 1); // Epoch
              t.setSeconds(data);
              return t;
              //   }
            },
          },
          {
            data: "detail.updated.seconds",
            render: function (data) {
              //   function toDateTime(secs) {
              var t = new Date(1970, 0, 1); // Epoch
              t.setSeconds(data);
              return t;
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