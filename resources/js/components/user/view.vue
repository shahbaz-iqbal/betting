<template>
  <div id="app">
    <div class="row">
      <div class="col-md-4">
        <div class="card">
          <div class="card-body text-center">
            <h4 class="card-title">User Info</h4>
            <div class="profile-pic m-b-20 m-t-20">
              <img
                v-bind:src="user_icon"
                width="100"
                class="rounded-circle"
                alt="user"
              />
              <h4 class="m-t-20 m-b-0">{{ user_name }}</h4>
              <a href="javascript:void(0)">email</a>
            </div>
            <div class="row text-center m-t-40">
              <div class="col-md-3">
                <a :href="win_check">
                  <div class="col-12">
                    <h3 class="font-bold">{{ win }}</h3>
                    <h6>Win</h6>
                  </div>
                </a>
              </div>
              <div class="col-md-3">
                <a :href="lose_check">
                  <div class="col-12">
                    <h3 class="font-bold">{{ lose }}</h3>
                    <h6>Lose</h6>
                  </div>
                </a>
              </div>
              <div class="col-md-3">
                <a :href="draw_check">
                  <div class="col-12">
                    <h3 class="font-bold">{{ spend }}</h3>
                    <h6>Draw</h6>
                  </div>
                </a>
              </div>
              <div class="col-md-3">
                <div class="col-12">
                  <h3 class="font-bold">{{ total }}</h3>
                  <h6>Total</h6>
                </div>
              </div>
            </div>
          </div>
          <div class="p-25 border-top m-t-15">
            <div class="row text-center">
              <div class="col-6 border-right">
                <a
                  href="#"
                  class="
                    link
                    d-flex
                    align-items-center
                    justify-content-center
                    font-medium
                  "
                  ><i class="mdi mdi-developer-board font-20 m-r-5"></i>Total
                  Bets</a
                >
              </div>
              <div class="col-6">
                <a
                  href="javascript:void(0)"
                  class="
                    link
                    d-flex
                    align-items-center
                    justify-content-center
                    font-medium
                  "
                  >{{ total_bets }}</a
                >
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-8">
        <div class="card">
          <div class="card-body text-center">
            <h4 class="card-title">Shop</h4>
            <table id="myTable1" class="table table-bordered mt-5">
              <thead>
                <tr>
                  <th>Point Bought</th>
                  <th>Amount</th>
                  <th>Currency</th>
                  <th>Purchased at</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="card-header">
          <h4>
            User Betting Info
            <div v-if="loading">
              <div class="d-flex justify-content-center mb-3">
                <b-spinner label="Loading..."></b-spinner>
              </div>
            </div>
          </h4>
        </div>
        <div class="row" v-if="isHidden">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">Champianship...</h4>
                <div class="d-flex flex-row">
                  <div>
                    <img
                      v-bind:src="detail.champianimage"
                      width="100"
                      class="rounded-circle"
                      alt="user"
                    />
                  </div>
                  <div class="p-l-20">
                    <h3 class="font-medium">{{ detail.champianName }}</h3>
                    <h6>{{ detail.champianLocation }}</h6>
                    <button class="btn btn-success">
                      {{ detail.champianStatus }}
                    </button>
                    <h6 class="mt-2">Category : {{ detail.champianCat }}</h6>
                  </div>
                  <div class="p-l-20">
                    <h4 class="card-title">Points</h4>
                    <h5 class="card-subtitle">
                      Winning : {{ detail.winPoint }}
                    </h5>
                    <h5 class="card-subtitle">
                      Losing : {{ detail.losePoint }}
                    </h5>
                    <h5 class="card-subtitle">Draw : {{ detail.drawPoint }}</h5>

                    <h4 class="card-title">Other</h4>
                    <h5 class="card-subtitle">
                      Win Percentage : {{ detail.winPercentage }}
                    </h5>
                    <h5 class="card-subtitle">
                      Min Betting Points : {{ detail.minBatting }}
                    </h5>
                    <h5 class="card-subtitle">
                      Total Bets : {{ detail.totalBets }}
                    </h5>
                  </div>
                  <div class="p-l-20">
                    <h4 class="card-title">Duration</h4>
                    <h5 class="card-subtitle">
                      Start : {{ detail.startMatch }}
                    </h5>
                    <h5 class="card-subtitle">End : {{ detail.endMatch }}</h5>
                    <h5 class="card-subtitle">
                      Played At : {{ detail.playedAt }}
                    </h5>
                  </div>
                </div>
                <h4 class="card-title">Team...</h4>
                <div class="row m-t-40">
                  <div class="col b-r text-center">
                    <div class="">
                      <img
                        v-bind:src="detailTeam.teamImage"
                        width="50"
                        class="rounded-circle"
                        alt="user"
                      />
                    </div>
                    <h3 class="font-medium">{{ detailTeam.teamName }}</h3>
                    <h6>{{ detailTeam.teamCountry }}</h6>
                  </div>
                  <div class="col b-r text-center">
                    <h2 class="font-light">{{ detailTeam.totalMatch }}</h2>
                    <h6>Total Matches</h6>
                  </div>
                  <div class="col text-center">
                    <h2 class="font-light">{{ detailTeam.draw }}</h2>
                    <h6>Draw</h6>
                  </div>
                  <div class="col text-center">
                    <h2 class="font-light">{{ detailTeam.win }}</h2>
                    <h6>Win</h6>
                  </div>
                  <div class="col text-center">
                    <h2 class="font-light">{{ detailTeam.lose }}</h2>
                    <h6>lose</h6>
                  </div>
                </div>
              </div>
              <div>
                <hr />
              </div>
              <div class="card-body">
                <ul
                  class="
                    list-style-none list-icons
                    d-flex
                    flex-item
                    text-center
                    p-t-10
                  "
                >
                  <li class="col">
                    <h2 class="font-light">{{ detailBet.betFor }}</h2>
                    <h6>Bet For</h6>
                  </li>
                  <li class="col">
                    <h2 class="font-light">{{ detailBet.betPoints }}</h2>
                    <h6>Bet Points</h6>
                  </li>
                  <li class="col">
                    <h2 class="font-light">{{ detailBet.betStatus }}</h2>
                    <h6>Bet Status</h6>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-body">
            <table id="myTable" class="table table-bordered mt-5">
              <thead>
                <tr>
                  <th>Id</th>
                  <th>Bet For</th>
                  <th>Champianship</th>
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
</template>
<script>
// $(document).ready(function () {
//   var dT = $("#myTable1").DataTable();
// });
import $ from "jquery";
import { BSpinner } from "bootstrap-vue";
Vue.component("b-spinner", BSpinner);

import { getFirestore } from "firebase/firestore";
import { doc, getDoc } from "firebase/firestore";

const db = getFirestore();
export default {
  mounted() {
    this.getUserInfo();
    this.getUsers();
  },
  data() {
    return {
      isHidden: false,
      loading: true,
      user_name: "",
      user_icon: "",
      user_email: "",
      total_bets: 0,
      draw_check:
        Laravel.baseUrl + document.getElementById("hello").innerHTML + "/draw",
      lose_check:
        Laravel.baseUrl +
        document.getElementById("hello").innerHTML +
        "/losing",
      win_check:
        Laravel.baseUrl +
        "match_detail/" +
        document.getElementById("hello").innerHTML +
        "/wining",
      lose: 0,
      spend: 0,
      total: 0,
      win: 0,
      detail: {
        champianimage: "",
        champianName: "",
        champianLocation: "",
        champianStatus: "",
        champianCat: "",
        winPoint: "",
        losePoint: "",
        drawPoint: "",
        winPercentage: "",
        minBatting: "",
        totalBets: "",
        startMatch: "",
        endMatch: "",
        playedAt: "",
      },
      detailTeam: {
        teamImage: "",
        teamName: "",
        totalMatch: "",
        teamCountry: "",
        win: "",
        lose: "",
        draw: "",
      },
      detailBet: {
        betFor: "",
        betPoints: "",
        betStatus: "",
      },
      url: Laravel.baseUrl + "user_add",
    };
  },
  methods: {
    async getUserInfo() {
      var response = [];
      const docRef = doc(
        db,
        "users",
        document.getElementById("hello").innerHTML
      );
      const docSnap = await getDoc(docRef);
      response["data"] = docSnap.data();
      const docRef1 = doc(
        db,
        "UserBettings",
        document.getElementById("hello").innerHTML
      );
      const docSnap1 = await getDoc(docRef1);
      response["data"]["betting"] = docSnap1.data();
      if (response["data"]["betting"]) {
        this.total_bets = response.data.betting.totalbets;
        this.lose = response.data.betting.points.lose;
        this.spend = response.data.betting.points.spend;
        this.total = response.data.betting.points.total;
        this.win = response.data.betting.points.win;
      }
      this.user_name = response.data.name;
      if (response.data.icon) {
        this.user_icon = response.data.icon;
      } else {
        this.user_icon = Laravel.baseUrl + "assets/uploads/dummy.png";
      }
    },
    getUsers() {
      this.loading = true;
      var sett = this;
      axios
        .get(
          Laravel.baseUrl +
            "user_detail/" +
            document.getElementById("hello").innerHTML
        )
        .then((response) => {
          console.log(response.data);
          sett.loading = false;
          //   Shop History
          $("#myTable1").DataTable({
            responsive: true,
            data: response.data.shop_ref_history,
            columns: [
              { data: "points_bought" },
              { data: "amount" },
              { data: "currency" },
              // { "September 29, 2021 at 12:00:00 AM" },
              {
                data: "purchased_at",
                render: function (data) {
                  // var t = new Date(1970, 0, 1);
                  // t.setSeconds(data);
                  return "September 29, 2021 at 12:00:00 AM";
                },
              },
            ],
          });
          //   Shop History
          //   Betting history
          var table = $("#myTable").DataTable({
            responsive: true,
            data: response.data.betting_historys,
            columns: [
              { data: "bet_on" },
              { data: "bet_for" },
              { data: "champiosnhip" },
              { data: "points" },
              { data: "bet_status" },
              {
                data: { bet_on: "bet_on", matchid: "matchid", id: "id" },
                render: function (data) {
                  return (
                    '<a href="javascript:void(0);" class="btn btn-primary view_bet_detail" team_id = "' +
                    data.bet_on +
                    '" match_id="' +
                    data.matchid +
                    '"history_id="' +
                    data.id +
                    '">View</a>'
                  );
                },
              },
            ],
          });
          var self = this;
          var history_load = this;
          const isHidden = this;
          $("#myTable tbody").on("click", ".view_bet_detail", function () {
            history_load.loading = true;
            isHidden.isHidden = false;
            var user_id = document.getElementById("hello").innerHTML;
            var team_id = $(this).attr("team_id");
            var match_id = $(this).attr("match_id");
            var betting_history_id = $(this).attr("history_id");
            self.get_betting_detail(
              user_id,
              match_id,
              team_id,
              betting_history_id
            );
          });
        })
        .catch((error) => console.log(error.response));
      //   Betting history
    },
    async get_betting_detail(
      user_id,
      match_id,
      team_id,
      UserBettings_History_id
    ) {
      const history_load = this;
      const isHidden = this;
      const docRef = doc(
        db,
        "UserBettings",
        user_id,
        "History",
        UserBettings_History_id
      );
      const docSnap = await getDoc(docRef);
      var betting_detail = docSnap.data();
      //betting table Detail
      //Match table Detail
      const docRef1 = doc(db, "Matches", match_id);
      const docSnap1 = await getDoc(docRef1);
      var match_detail = docSnap1.data();
      //Match table Detail
      //Team table Detail
      const docRef2 = doc(db, "Teams", team_id);
      const docSnap2 = await getDoc(docRef2);
      var team_detail = docSnap2.data();
      //Team table Detail
      history_load.loading = false;
      //Champion Detail
      (this.detail.champianimage = match_detail.championship.icon),
        (this.detail.champianName = match_detail.championship.name),
        (this.detail.champianStatus = match_detail.match_status),
        (this.detail.champianLocation = match_detail.championship.location),
        (this.detail.champianCat = match_detail.category_name),
        (this.detail.winPoint = match_detail.points.winning),
        (this.detail.losePoint = match_detail.points.losing),
        (this.detail.drawPoint = match_detail.points.draw),
        (this.detail.winPercentage = match_detail.win_percentage),
        (this.detail.minBatting = match_detail.min_batting_points),
        (this.detail.totalBets = match_detail.total_bets),
        (this.detail.startMatch = match_detail.duration.start),
        (this.detail.endMatch = match_detail.duration.end),
        (this.detail.playedAt = match_detail.played_at);
      //Team Detail
      (this.detailTeam.teamImage = team_detail.icon),
        (this.detailTeam.teamName = team_detail.name),
        (this.detailTeam.totalMatch = team_detail.total_matches),
        (this.detailTeam.teamCountry = team_detail.country),
        (this.detailTeam.win = team_detail.win),
        (this.detailTeam.lose = team_detail.lose),
        (this.detailTeam.draw = team_detail.draw);
      //Team betting
      (this.detailBet.betFor = betting_detail.bet_for),
        (this.detailBet.betStatus = betting_detail.bet_status),
        (this.detailBet.betPoints = betting_detail.points);
      isHidden.isHidden = true;
    },
  },
};
</script>

<style></style>