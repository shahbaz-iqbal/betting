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
              <!-- <button variant="danger" @click="makeToast('danger')" class="mb-2">Danger</button> -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import $ from "jquery";

// import { BSpinner } from "bootstrap-vue";
// Vue.component("b-spinner", BSpinner);
// import { BToast } from 'bootstrap-vue'
// Vue.component('b-toast', BToast)

import { getFirestore } from "firebase/firestore";
import { collection, query, where, getDocs } from "firebase/firestore";

const db = getFirestore();
export default {
  mounted() {
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
      // var get_users();
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
                "user_view/" +
                data +
                '"class="btn btn-info">View</a><a href="' +
                Laravel.baseUrl +
                "user_edit/" +
                data +
                '"class="btn btn-primary ml-1">Edit</a><button class="btn btn-danger ml-1 delete" dalete_id="' +
                data +
                '">Delete</button>'
              );
            },
          },
        ],
      });
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
             swal("Poof! Your imaginary file has been deleted!", {
                  icon: "success",
                });
            // location.reload();
            // axios
            //   .get(Laravel.baseUrl + "user_delete/" + delete_id)
            //   .then((response) => {
            //     // swal("Poof! Your imaginary file has been deleted!", {
            //     //   icon: "success",
            //     // });
            //     location.reload();
            //   })
            //   .catch((error) => {
            //     console.log(error);
            //   });
          } else {
            swal("Your imaginary file is safe!");
          }
        });
      });
    },
    // makeToast(variant = null) {
    //     this.$bvToast.toast('Toast body content', {
    //       title: `Variant ${variant || 'default'}`,
    //       variant: variant,
    //       solid: true
    //     })
    //   }
  },
};
</script>

<style></style>