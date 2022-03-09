<template>
  <div class="row">
    <div class="col-12">
      <div class="card text-left">
        <div class="card-header">
          <h4>Match Update</h4>
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
              <h4 class="card-title">Match Status</h4>
              <select class="form-control" @change="matchStatus">
                <option
                  :selected="'Pending' === formdata.match_status"
                  value="Pending"
                >
                  Pending
                </option>
                <option
                  :selected="'Live' === formdata.match_status"
                  value="Live"
                >
                  Live
                </option>
                <option
                  :selected="'Completed' === formdata.match_status"
                  value="Completed"
                >
                  Completed
                </option>
                <option
                  :selected="'Cancelled' === formdata.match_status"
                  value="Cancelled"
                >
                  Cancelled
                </option>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <h4 class="card-title">Team 1 Score</h4>
              <div class="form-group">
                <input
                  type="text"
                  class="form-control"
                  id=""
                  v-model="formdata.score.team1.score"
                  placeholder="Score"
                />
              </div>
            </div>
            <div class="col-md-6">
              <h4 class="card-title">Team 2 Score</h4>
              <div class="form-group">
                <input
                  type="text"
                  class="form-control"
                  id=""
                  v-model="formdata.score.team2.score"
                  placeholder="Score"
                />
              </div>
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
                  placeholder="Name"
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
                  placeholder="Name"
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
                  placeholder="Name"
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
                  placeholder="Name"
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
                  v-model="formdata.duration.start"
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
                  v-model="formdata.duration.end"
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
            <div class="col-md-6">
              <h4 class="card-title">Approved Status</h4>
              <select class="form-control" @change="changeStatus">
                <option
                  :selected="'Approved' === formdata.approval_status"
                  value="Approved"
                >
                  Approved
                </option>
                <option
                  :selected="'Pending' === formdata.approval_status"
                  value="Pending"
                >
                  Pending
                </option>
              </select>
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
  getDoc,
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
    this.get_match();
  },
  data() {
    return {
      loading: false,
      options: [],
      teams: [],
      errors: [],
      formdata: {
        approval_status: "",
        match_start_time: "",
        match_status: "",
        // approved_at: "",
        category_name: "",
        championship: {
          name: "",
          // id: "",
          icon: "",
          location: "",
        },
        score: {
          team1: {
            id: "",
            score: "",
          },
          team2: {
            id: "",
            score: "",
          },
        },
        // created: "",
        // createdby: "admin",
        duration: {
          start: "",
          end: "",
        },
        // match_result: {
        //   win_by: "",
        //   lose_by: "",
        //   result: "",
        // },
        points: {
          winning: "",
          losing: "",
          draw: "",
        },
        // teams: [],
        // match_status: "pending",
        // matchid: "",
        // played_at: serverTimestamp(),
        min_batting_points: 0,
        // total_bets: 0,
        // win_percentage: 0,
        updated: serverTimestamp(),
      },
    };
  },
  methods: {
    async get_match() {
      const docRef = doc(
        db,
        "Matches",
        document.getElementById("id").innerHTML
      );
      const docSnap = await getDoc(docRef);
      this.formdata.approval_status = docSnap.data().approval_status;
      this.formdata.match_status = docSnap.data().match_status;

      this.formdata.score.team1.id = docSnap.data().teams[0];
      this.formdata.score.team1.score = docSnap.data().score.team1.score;

      this.formdata.score.team2.id = docSnap.data().teams[1];
      this.formdata.score.team2.score = docSnap.data().score.team2.score;

      this.formdata.category_name = docSnap.data().category_name;
      this.formdata.championship.icon = docSnap.data().championship.icon;
      this.formdata.championship.name = docSnap.data().championship.name;
      this.formdata.championship.location =
        docSnap.data().championship.location;
      this.formdata.duration.end = docSnap.data().duration.end;
      this.formdata.duration.start = docSnap.data().duration.start;
      this.formdata.points.winning = docSnap.data().points.winning;
      this.formdata.points.losing = docSnap.data().points.losing;
      this.formdata.points.draw = docSnap.data().points.draw;
      this.formdata.win_percentage = docSnap.data().win_percentage;
    },
    startDate: function () {
      this.formdata.duration.start = document.getElementById("startdate").value;
    },
    endDate: function () {
      this.formdata.duration.end = document.getElementById("enddate").value;
    },
    changeStatus(event) {
      this.formdata.approval_status = event.target.value;
    },
    matchStatus(event) {
      this.formdata.match_status = event.target.value;
      if (event.target.value == "Live") {
        this.formdata.match_start_time = serverTimestamp();
      }
    },
    changeCategory(event) {
      this.category_name = event.target.value;
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
      // if (this.name && this.category && this.country) {
      this.loading = true;
      // const docRef = await addDoc(collection(db, "Matches"), this.formdata);
      // spinner();
      const UpdateRef = doc(
        db,
        "Matches",
        document.getElementById("id").innerHTML
      );
      await updateDoc(UpdateRef, this.formdata);
      window.location = Laravel.baseUrl + "matches";
      // }

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
