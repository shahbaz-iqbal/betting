<template>
  <div class="row">
    <div class="col-12">
      <div class="card text-left">
        <div class="card-header">
          <h4>Team Edit</h4>
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
          <!-- <form @submit="formSubmit"> -->
          <div class="row">
            <div class="col-md-6">
              <h4 class="card-title">Name</h4>
              <div class="form-group">
                <input
                  type="text"
                  class="form-control"
                  id=""
                  v-model="name"
                  placeholder="Name"
                />
              </div>
            </div>
            <div class="col-md-6">
              <h4 class="card-title">Category</h4>
              <select
                class="form-control"
                :required="true"
                @change="changeCategory"
              >
                <option :selected="true">Choose Category</option>
                <option
                  v-for="(item, key) in options"
                  :value="item.name"
                  v-text="item.name"
                  :key="key"
                  :selected="item.name === selectedOpt"
                ></option>
              </select>
            </div>
          </div>
          <div class="row mb-4">
            <div class="col-md-6">
              <h4 class="card-title">Country</h4>
              <div class="form-group">
                <country-select
                  class="form-control"
                  v-model="country"
                  :country="country"
                  topCountry="US"
                />
              </div>
            </div>
            <div class="col-md-6">
              <h4 class="card-title">Logo</h4>
              <input
                type="file"
                class="form-control"
                v-on:change="onFileChange"
              />
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
import { getFirestore } from "firebase/firestore";
import {
  collection,
  addDoc,
  serverTimestamp,
  query,
  where,
  getDocs,
  getDoc,
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

// Create the file metadata
/** @type {any} */
const metadata = {
  contentType: "image/jpeg",
};
export default {
  mounted() {
    this.get_team();
    this.getCategories();
  },
  data() {
    return {
      loading: false,
      options: [],
      selected: "",
      selectedOpt: "",
      errors: [],
      name: "",
      category: "",
      imageUrl: "",
      country: "",
    };
  },
  methods: {
    async get_team() {
      const docRef = doc(db, "Teams", document.getElementById("id").innerHTML);
      const docSnap = await getDoc(docRef);
      this.imageUrl = docSnap.data().icon;
      this.country = docSnap.data().country;
      this.category = docSnap.data().type;
      this.selectedOpt = docSnap.data().type;
      this.name = docSnap.data().name;
    },
    changeCategory(event) {
      console.log(event.target.value);
      this.category = event.target.value;
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
            this.imageUrl = downloadURL;
            this.spinner();
          });
        }
      );
    },
    async formSubmit() {
      this.loading = true;
      this.errors = [];
      if (this.name && this.category && this.country) {
        this.loading = true;
        const UpdateRef = doc(
          db,
          "Teams",
          document.getElementById("id").innerHTML
        );
        // Set the "capital" field of the city 'DC'
        await updateDoc(UpdateRef, {
          name: this.name,
          country: this.country,
          icon: this.imageUrl,
          type: this.category,
          updated: serverTimestamp(),
        });

        // session()->flash('success', 'Your User Update Successfully!');
        window.location = Laravel.baseUrl + "teams";
      }

      if (!this.name) {
        this.errors.push("Name required.");
      }
      if (!this.category) {
        this.errors.push("Category required.");
      }
      if (!this.country) {
        this.errors.push("Country required.");
      }
      e.preventDefault();
    },
    spinner() {
      this.loading = false;
    },
  },
};
</script>
