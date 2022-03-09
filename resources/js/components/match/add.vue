<template>
  <div class="row">
    <div class="col-12">
      <div class="card text-left">
        <div class="card-header">
          <h4>Match Add</h4>
          <div v-if="loading">
            <div class="d-flex justify-content-center mb-3">
              <b-spinner label="Loading..."></b-spinner>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <div v-for="(error, key) in errors" :key="key">
                <div class="alert alert-danger" role="alert">
                  {{ error }}
                </div>
              </div>
            </div>
          </div>
          <div class="row mb-4">
            <div class="col-md-6">
              <h4 class="card-title">Category</h4>
              <select class="form-control" @change="changeCategory">
                <option :selected="true">Choose Category</option>
                <option
                  v-for="(item, key) in options"
                  :value="item.name"
                  v-text="item.name"
                  :key="key"
                ></option>
              </select>
            </div>
            <div class="col-md-6">
              <h4 class="card-title">Approved Status</h4>
              <select class="form-control" @change="changeStatus">
                <option :selected="true">Select Option</option>
                <option value="Approved">Approved</option>
                <option value="Pending">Pending</option>
              </select>
            </div>
          </div>
          <div class="row mb-4">
            <div class="col-md-6">
              <h4 class="card-title">Team A</h4>
              <select class="form-control" @change="changeteama">
                <option :selected="true">Select Option</option>
                <option
                  v-for="(item, key) in teams"
                  :value="item.teamid"
                  v-text="item.name"
                  :key="key"
                ></option>
              </select>
            </div>
            <div class="col-md-6">
              <h4 class="card-title">Team B</h4>
              <select class="form-control" @change="changeteamb">
                <option :selected="true">Select Option</option>
                <option
                  v-for="(item, key) in teams"
                  :value="item.teamid"
                  v-text="item.name"
                  :key="key"
                ></option>
              </select>
            </div>
          </div>
          <div class="card-header mb-4">
            <h4>Championship</h4>
          </div>
          <div class="row mb-4">
            <div class="col-md-6">
              <h4 class="card-title">Name</h4>
              <div class="form-group">
                <input
                  type="text"
                  class="form-control"
                  id=""
                  v-model="formdata.championship.name"
                  placeholder="Name"
                />
              </div>
            </div>
            <div class="col-md-6">
              <h4 class="card-title">Icon</h4>
              <input
                type="file"
                class="form-control"
                v-on:change="onFileChange"
              />
            </div>
          </div>

          <div class="row mb-4">
            <div class="col-md-6">
              <h4 class="card-title">Draw Points</h4>
              <div class="form-group">
                <input
                  type="number"
                  class="form-control"
                  id=""
                  v-model="formdata.points.draw"
                  placeholder="Draw Points"
                />
              </div>
            </div>
            <div class="col-md-6">
              <h4 class="card-title">Losing Points</h4>
              <div class="form-group">
                <input
                  type="number"
                  class="form-control"
                  id=""
                  v-model="formdata.points.losing"
                  placeholder="Losing Points"
                />
              </div>
            </div>
          </div>

          <div class="row mb-4">
            <div class="col-md-6">
              <h4 class="card-title">Winning Points</h4>
              <div class="form-group">
                <input
                  type="number"
                  class="form-control"
                  id=""
                  v-model="formdata.points.winning"
                  placeholder="Winning Points"
                />
              </div>
            </div>
            <div class="col-md-6">
              <h4 class="card-title">Location</h4>
              <div class="form-group">
                <input
                  type="text"
                  class="form-control"
                  id=""
                  v-model="formdata.championship.location"
                  placeholder="Location"
                />
              </div>
            </div>
          </div>

          <div class="card-header mb-4">
            <h4>Duration</h4>
          </div>
          <div class="row mb-4">
            <div class="col-md-6">
              <h4 class="card-title">Match Start</h4>
              <div class="input-group">
                <input
                  type="text"
                  id="startdate"
                  class="form-control mydatepicker"
                  placeholder="mm/dd/yyyy"
                />
                <div class="input-group-append">
                  <span class="input-group-text"
                    ><i class="icon-calender"></i
                  ></span>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <h4 class="card-title">Match End</h4>
              <div class="input-group">
                <input
                  type="text"
                  id="enddate"
                  class="form-control mydatepicker"
                  placeholder="mm/dd/yyyy"
                />
                <div class="input-group-append">
                  <span class="input-group-text"
                    ><i class="icon-calender"></i
                  ></span>
                </div>
              </div>
            </div>
          </div>
          <div class="row mb-4">
            <div class="col-md-6">
              <h4 class="card-title">Win Percentage</h4>
              <div class="form-group">
                <input
                  type="number"
                  class="form-control"
                  v-model="formdata.win_percentage"
                  placeholder="Win Percentage"
                />
              </div>
            </div>
          </div>
          <button type="button" @click="formSubmit" class="btn btn-success">
            Submit
          </button>
          <!-- </form> -->
        </div>
      </div>
    </div>
  </div>
</template>
 
<script>
import { BFormDatepicker } from "bootstrap-vue";
Vue.component("b-form-datepicker", BFormDatepicker);
import { getFirestore } from "firebase/firestore";
import {
  collection,
  addDoc,
  serverTimestamp,
  query,
  where,
  getDocs,
  updateDoc,
  doc,
} from "firebase/firestore";
import {
  getStorage,
  ref,
  uploadBytesResumable,
  getDownloadURL,
} from "firebase/storage";

const db = getFirestore();
const storage = getStorage();
import { v4 as uuidv4 } from "uuid";
// Create the file metadata
/** @type {any} */
const metadata = {
  contentType: "image/jpeg",
};
export default {
  mounted() {
    this.getCategories();
  },
  data() {
    return {
      loading: false,
      options: [],
      teams: [],
      errors: [],
      formdata: {
        match_status: "",
        score:{
          team1:{
            id:"",
            score:"",
          },
          team2:{
            id:"",
            score:"",
          }
        },
        approval_status: "",
        approved_at: "",
        category_name: "",
        championship: {
          name: "",
          id: "",
          icon: "",
          location: "",
        },
        created: "",
        createdby: "admin",
        duration: {
          start: "",
          end: "",
        },
        match_result: {
          win_by: "",
          lose_by: "",
          result: "",
        },
        points: {
          winning: "",
          losing: "",
          draw: "",
        },
        teams: [],
        match_status: "pending",
        matchid: "",
        played_at: serverTimestamp(),
        min_batting_points: 0,
        total_bets: 0,
        win_percentage: 0,
        updated: serverTimestamp(),
      },
    };
  },
  methods: {
    startDate: function () {
      this.formdata.duration.start = document.getElementById("startdate").value;
    },
    endDate: function () {
      this.formdata.duration.end = document.getElementById("enddate").value;
    },
    changeStatus(event) {
      this.formdata.approval_status = event.target.value;
    },
    changeCategory(event) {
      this.formdata.category_name = event.target.value;
      console.log(event.target.value);
      this.get_teams(event.target.value);
    },
    changeteama(event) {
      this.formdata.teams[0] = event.target.value;
    },
    changeteamb(event) {
      this.formdata.teams[1] = event.target.value;
    },
    async getCategories() {
      var response_data = [];
      const q = query(collection(db, "Categories"));
      const querySnapshot = await getDocs(q);
      querySnapshot.forEach((doc) => {
        response_data.push(doc.data());
      });
      this.options = response_data;
    },
    async get_teams(type) {
      var response_teams = [];
      const q = query(collection(db, "Teams"), where("type", "==", type));
      const querySnapshot = await getDocs(q);
      querySnapshot.forEach((doc) => {
        response_teams.push(doc.data());
      });
      console.log(response_teams);
      this.teams = response_teams;
    },
    onFileChange(e) {
      this.loading = true;
      const file = e.target.files[0];
      const storageRef = ref(storage, "images/" + file.name);
      const uploadTask = uploadBytesResumable(storageRef, file, metadata);
      uploadTask.on(
        "state_changed",
        (snapshot) => {
          // Get task progress, including the number of bytes uploaded and the total number of bytes to be uploaded
          const progress =
            (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
          console.log("Upload is " + progress + "% done");
          switch (snapshot.state) {
            case "paused":
              console.log("Upload is paused");
              break;
            case "running":
              console.log("Upload is running");
              break;
          }
        },
        (error) => {
          // A full list of error codes is available at
          // https://firebase.google.com/docs/storage/web/handle-errors
          switch (error.code) {
            case "storage/unauthorized":
              // User doesn't have permission to access the object
              break;
            case "storage/canceled":
              // User canceled the upload
              break;

            // ...

            case "storage/unknown":
              // Unknown error occurred, inspect error.serverResponse
              break;
          }
        },
        () => {
          // Upload completed successfully, now we can get the download URL
          getDownloadURL(uploadTask.snapshot.ref).then((downloadURL) => {
            console.log(downloadURL);
            this.formdata.championship.icon = downloadURL;
            this.spinner();
          });
        }
      );
    },
    async formSubmit(e) {
      this.startDate();
      this.endDate();
      this.formdata.championship.id = uuidv4();
      this.formdata.approved_at = serverTimestamp();
      this.formdata.created = serverTimestamp();
      this.loading = true;
      this.errors = [];
      this.loading = true;
      const docRef = await addDoc(collection(db, "Matches"), this.formdata);
      // spinner();
      console.log(docRef.id);
      const UpdateRef = doc(db, "Matches", docRef.id);
      await updateDoc(UpdateRef, {
        matchid: docRef.id,
      });
      window.location = Laravel.baseUrl + "matches";

      // if (!this.name) {
      //   this.errors.push("Name required.");
      // }
      // if (!this.category) {
      //   this.errors.push("Category required.");
      // }
      // if (!this.country) {
      //   this.errors.push("Country required.");
      // }
      e.preventDefault();
    },
    // spinner() {
    //   this.loading = false;
    // },
  },
};
</script>
