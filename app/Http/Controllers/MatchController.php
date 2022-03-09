<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Google\Cloud\Firestore\FirestoreClient;
use Google\Cloud\Firestore\FieldValue;
use Illuminate\Http\Request;

class MatchController extends Controller
{
	public function index()
	{
		return view('match/index');
	}
	public function add()
	{
		return view('match/add');
	}
	public function edit($id)
	{
		return view('match/edit', ['id' => $id]);
	}
	public function annoucement()
	{
		$db = new FirestoreClient([
			'projectId' => 'bettingapp-70c54',
		]);
		$categoriesRef = $db->collection('Matches');
		$query = $categoriesRef->where('match_result.result', 'in', ['Draw', 'win']);
		// $query = $query->where('match_result.result', '==', 'Draw');
		$matches = [];
		foreach ($query->documents() as $document2) {
			if ($document2->exists()) {
				$matches[] = $document2->data();
			}
		}
		return view('match/annoucement', ['matches' => $matches]);
	}

	public function match_prize($id, Request $request)
	{
		$db = new FirestoreClient([
			'projectId' => 'bettingapp-70c54',
		]);
		$match = $db->collection('Matches')->document($id)->snapshot()->data();
		$bets = $db->collection('Matches')->document($id)->collection('Bets');
		foreach ($bets->documents() as $document2) {
			if ($document2->exists()) {
				//Match Winnig
				if ($match['match_result']['result'] == "win") {
					// if ($document2->data()['bet_for'] == "Winning") {
					if ($match['match_result']['win_by'] == $document2->data()['bet_on']) {
						//Update Match Bets Update Status
						$update_match_bets_history_status = [
							['path' => 'status', 'value' => 'win'],
						];
						$db->collection('Matches')->document($id)->collection('Bets')->document($document2->id())->update($update_match_bets_history_status);
						//Update Match Bets Update Status
						//Update Points table point
						$total_point = $db->collection('Points')->document($document2->data()['by'])->snapshot()->data();
						$point_update = $total_point['points'] + $document2->data()['points'] + $document2->data()['points'] / 2;
						$update_point_data = [
							['path' => 'points', 'value' => $point_update],
						];
						$db->collection('Points')->document($document2->data()['by'])->update($update_point_data);
						//Update Points table point

						//Add Points History table point
						$history_total_point = $document2->data()['points'] / 2;
						$created = FieldValue::serverTimestamp();
						$updated = FieldValue::serverTimestamp();
						$insert_point_history_data = [
							'created' => $created,
							'points' => $history_total_point,
							'pointsSource' => "Win Bet",
							'status' => "distributed",
							'updated' => $updated,
						];
						$db->collection('Points')->document($document2->data()['by'])->collection('PointsHistory')->add($insert_point_history_data);
						//Add Points History table point

						//Update UserBeting Points table
						$user_betting_point = $db->collection('UserBettings')->document($document2->data()['by'])->snapshot()->data();
						$total_user_betting_points = $user_betting_point['points']['total'] + $document2->data()['points'] + $document2->data()['points'] / 2;
						$win_user_betting_points = $user_betting_point['points']['win'] + $document2->data()['points'] + $document2->data()['points'] / 2;
						$update_user_betting_point_data = [
							['path' => 'points.total', 'value' => $win_user_betting_points],
							['path' => 'points.win', 'value' => $total_user_betting_points],
						];
						$db->collection('UserBettings')->document($document2->data()['by'])->update($update_user_betting_point_data);
						//Update UserBeting Points table

						//Update UserBeting History Status table
						$user_betting_history_query = $db->collection('UserBettings')->document($document2->data()['by'])->collection('History');
						$user_betting_history = $user_betting_history_query->where('matchid', '=', $id);
						foreach ($user_betting_history->documents() as $user_betting_history_value) {
							if ($user_betting_history_value->exists()) {
								if ($user_betting_history_value->data()['bet_for'] == "Winning") {
									$update_user_betting_history_status = [
										['path' => 'bet_status', 'value' => 'win'],
									];
									$db->collection('UserBettings')->document($document2->data()['by'])->collection('History')->document($user_betting_history_value->id())->update($update_user_betting_history_status);
								}
							}
						}
						//Update UserBeting History Status table
					} else {
						//Update Match Bets Update Status
						$update_match_bets_history_status = [
							['path' => 'status', 'value' => 'lose'],
						];
						$db->collection('Matches')->document($id)->collection('Bets')->document($document2->id())->update($update_match_bets_history_status);
						$user_betting_history_query = $db->collection('Matches')->document($id)->collection('Bets')->document($document2->id())->snapshot()->data();
						//Update Match Bets Update Status

						//Update UserBeting History Status table Losing Team
						$user_betting_history_query = $db->collection('UserBettings')->document($document2->data()['by'])->collection('History');
						$user_betting_history = $user_betting_history_query->where('matchid', '=', $id);
						foreach ($user_betting_history->documents() as $user_betting_history_value) {
							if ($user_betting_history_value->exists()) {
								if ($user_betting_history_value->data()['bet_for'] == "Winning") {
									$update_user_betting_history_status = [
										['path' => 'bet_status', 'value' => 'lose'],
									];
									$db->collection('UserBettings')->document($document2->data()['by'])->collection('History')->document($user_betting_history_value->id())->update($update_user_betting_history_status);
								}
							}
						}
						//Update UserBeting History Status table Losing Team
					}
					// }
				}

				//Match Winnig
				//Match Draw

				if ($match['match_result']['result'] == "Draw") {
					if ($document2->data()['bet_for'] == "Draw") {
						//Update Match Bets Update Status
						$update_match_bets_history_status = [
							['path' => 'status', 'value' => 'win'],
						];
						$db->collection('Matches')->document($id)->collection('Bets')->document($document2->id())->update($update_match_bets_history_status);
						//Update Match Bets Update Status
						//Update Points table point
						$total_point = $db->collection('Points')->document($document2->data()['by'])->snapshot()->data();
						$point_update = $total_point['points'] + $document2->data()['points'] / 2;
						$update_point_data = [
							['path' => 'points', 'value' => $point_update],
						];
						$db->collection('Points')->document($document2->data()['by'])->update($update_point_data);
						//Update Points table point

						//Add Points History table point
						$history_total_point = $document2->data()['points'] / 2;
						$created = FieldValue::serverTimestamp();
						$updated = FieldValue::serverTimestamp();
						$insert_point_history_data = [
							'created' => $created,
							'points' => $history_total_point,
							'pointsSource' => "Win Bet",
							'status' => "distributed",
							'updated' => $updated,
						];
						$db->collection('Points')->document($document2->data()['by'])->collection('PointsHistory')->add($insert_point_history_data);
						//Add Points History table point

						//Update UserBeting Points table
						$user_betting_point = $db->collection('UserBettings')->document($document2->data()['by'])->snapshot()->data();
						$total_user_betting_points = $user_betting_point['points']['total'] + $document2->data()['points'] / 2;
						$win_user_betting_points = $user_betting_point['points']['win'] + $document2->data()['points'] / 2;
						$update_user_betting_point_data = [
							['path' => 'points.total', 'value' => $win_user_betting_points],
							['path' => 'points.win', 'value' => $total_user_betting_points],
						];
						$db->collection('UserBettings')->document($document2->data()['by'])->update($update_user_betting_point_data);
						//Update UserBeting Points table

						//Update UserBeting History Status table
						$user_betting_history_query = $db->collection('UserBettings')->document($document2->data()['by'])->collection('History');
						$user_betting_history = $user_betting_history_query->where('matchid', '=', $id);
						foreach ($user_betting_history->documents() as $user_betting_history_value) {
							if ($user_betting_history_value->exists()) {
								if ($user_betting_history_value->data()['bet_for'] == "Winning") {
									$update_user_betting_history_status = [
										['path' => 'bet_status', 'value' => 'win'],
									];
									$db->collection('UserBettings')->document($document2->data()['by'])->collection('History')->document($user_betting_history_value->id())->update($update_user_betting_history_status);
								}
							}
						}
						//Update UserBeting History Status table
					} else {

						//Update Match Bets Update Status
						$update_match_bets_history_status = [
							['path' => 'status', 'value' => 'lose'],
						];
						$db->collection('Matches')->document($id)->collection('Bets')->document($document2->id())->update($update_match_bets_history_status);
						//Update Match Bets Update Status

						//Update UserBeting History Status table Losing Team
						$user_betting_history_query = $db->collection('UserBettings')->document($document2->data()['by'])->collection('History');
						$user_betting_history = $user_betting_history_query->where('matchid', '=', $id);
						foreach ($user_betting_history->documents() as $user_betting_history_value) {
							if ($user_betting_history_value->exists()) {
								if ($user_betting_history_value->data()['bet_for'] == "Winning") {
									$update_user_betting_history_status = [
										['path' => 'bet_status', 'value' => 'lose'],
									];
									$db->collection('UserBettings')->document($document2->data()['by'])->collection('History')->document($user_betting_history_value->id())->update($update_user_betting_history_status);
								}
							}
						}
						//Update UserBeting History Status table Losing Team
					}
				}
			}
			//Match Draw
		}
		//Update Match Status
		$update_match_status = [
			['path' => 'match_result.result', 'value' => 'distributed'],
			['path' => 'match_status', 'value' => 'distributed'],
		];
		$db->collection('Matches')->document($id)->update($update_match_status);
		//Update Match Status
		$request->session()->flash('success', 'Your Prize Distribute Successfully!');
		return redirect('/match_result');
	}
	public function championship(Request $request)
	{
		$db = new FirestoreClient([
			'projectId' => 'bettingapp-70c54',
		]);
		$categoriesRef = $db->collection('Championships');
		// $query = $categoriesRef->where('match_result.result', 'in', ['Draw', 'win']);
		// $query = $query->where('match_result.result', '==', 'Draw');
		$championships = [];
		foreach ($categoriesRef->documents() as $document2) {
			if ($document2->exists()) {
				$championships[] = $document2->data();
			}
		}
		return view('match/championships', ['championships' => $championships]);
	}
	public function championship_add()
	{

		return view('match/championship_add');
	}
	public function championship_insert(Request $request)
	{
		// $id = $this->generateRandomString();
		if (!empty($_FILES['img']['tmp_name']) && $_FILES['img']['tmp_name'] != "") {
			$filename = uniqid();
			$post_fields = file_get_contents($_FILES['img']['tmp_name']);
			$url = 'https://firebasestorage.googleapis.com/v0/b/bettingapp-70c54.appspot.com/o?uploadType=media&name=' . $filename;
			$header = array('X-HTTP-Method-Override: POST', 'Content-Type: image/png');
			$resource = curl_init();
			curl_setopt($resource, CURLOPT_URL, $url);
			curl_setopt($resource, CURLOPT_HTTPHEADER, $header);
			curl_setopt($resource, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($resource, CURLOPT_POST, 1);
			curl_setopt($resource, CURLOPT_POSTFIELDS, $post_fields);
			$result = json_decode(curl_exec($resource));
			curl_close($resource);
			$image_url = 'https://firebasestorage.googleapis.com/v0/b/bettingapp-70c54.appspot.com/o/' . $result->name . '?alt=media&token=' . $result->downloadTokens;
		} else {
			$image_url = "";
		}

		// $timestamp = FieldValue::serverTimestamp();
		$data = [
			'id' => "",
			'name' => $request['name'],
			'region' => $request['region'],
			'icon' => $image_url,
		];
		$db = new FirestoreClient([
			'projectId' => 'bettingapp-70c54',
		]);
		$docRef = $db->collection('Championships')->add($data);
		$data = [
			['path' => 'id', 'value' => $docRef->id()],
		];
		$db->collection('Championships')->document($docRef->id())->update($data);
		$request->session()->flash('success', 'Your Championship add Successfully!');
		return redirect('/championship');
	}
	public function championship_edit($id)
	{
		$db = new FirestoreClient([
			'projectId' => 'bettingapp-70c54',
		]);
		$championship = $db->collection('Championships')->document($id)->snapshot()->data();
		return view('match/championship_edit', ['id' => $id, 'championship' => $championship]);
	}
	public function championship_update(Request $request)
	{
		if (!empty($_FILES['img']['tmp_name']) && $_FILES['img']['tmp_name'] != "") {

			$filename = uniqid();
			$post_fields = file_get_contents($_FILES['img']['tmp_name']);
			$url = 'https://firebasestorage.googleapis.com/v0/b/bettingapp-70c54.appspot.com/o?uploadType=media&name=' . $filename;
			$header = array('X-HTTP-Method-Override: POST', 'Content-Type: image/png');
			$resource = curl_init();
			curl_setopt($resource, CURLOPT_URL, $url);
			curl_setopt($resource, CURLOPT_HTTPHEADER, $header);
			curl_setopt($resource, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($resource, CURLOPT_POST, 1);
			curl_setopt($resource, CURLOPT_POSTFIELDS, $post_fields);
			$result = json_decode(curl_exec($resource));
			curl_close($resource);
			$image_url = 'https://firebasestorage.googleapis.com/v0/b/bettingapp-70c54.appspot.com/o/' . $result->name . '?alt=media&token=' . $result->downloadTokens;
		} else {
			$image_url = $request['old_img'];
		}

		$data = [
			['path' => 'name', 'value' => $request['name']],
			['path' => 'region', 'value' => $request['region']],
			['path' => 'icon', 'value' => $image_url],
		];
		$db = new FirestoreClient([
			'projectId' => 'bettingapp-70c54',
		]);
		$docRef = $db->collection('Championships')->document($request['id'])->update($data);
		if ($docRef) {
			$request->session()->flash('success', 'Your Championship Update Successfully!');
			return redirect('/championship');
		} else {
			$request->session()->flash('error', 'Something Went Wrong!');
			return redirect('/championship');
		}
	}
	public function score_edit($id)
	{
		$db = new FirestoreClient([
			'projectId' => 'bettingapp-70c54',
		]);
		$championship = $db->collection('Matches')->document($id)->snapshot()->data();
		$team1 = $db->collection('Teams')->document($championship['score']['team1']['id'])->snapshot()->data();
		$team2 = $db->collection('Teams')->document($championship['score']['team2']['id'])->snapshot()->data();
		return view('match/score_edit', ['id' => $id, 'match' => $championship, 'team1' => $team1, 'team2' => $team2]);
	}
	public function score_update(Request $request)
	{
		$data = [
			['path' => 'score.team1.score', 'value' => $request['team1']],
			['path' => 'score.team2.score', 'value' => $request['team2']],
		];
		$db = new FirestoreClient([
			'projectId' => 'bettingapp-70c54',
		]);
		$docRef = $db->collection('Matches')->document($request['id'])->update($data);
		if ($docRef) {
			$request->session()->flash('success', 'Your Score Update Successfully!');
			return redirect('/matches');
		} else {
			$request->session()->flash('error', 'Something Went Wrong!');
			return redirect('/matches');
		}
	}
	//Widthdraw Update
	public function withdraw_edit($withdraw_id, $id)
	{
		$db = new FirestoreClient([
			'projectId' => 'bettingapp-70c54',
		]);
		$withdraw = $db->collection('Withdraws')->document($id)->collection('WithdrawalHistory')->document($withdraw_id)->snapshot()->data();
	
		return view('match/widthdraw_edit', ['id' => $id, 'withdraw_id' => $withdraw_id, 'withdraw' => $withdraw]);
	}
	public function widthdraw_update(Request $request)
	{
		$data = [
			['path' => 'status', 'value' => $request['status']],
		];
		$db = new FirestoreClient([
			'projectId' => 'bettingapp-70c54',
		]);
		$docRef = $db->collection('Withdraws')->document($request['id'])->collection('WithdrawalHistory')->document($request['withdraw_id'])->update($data);
		if ($docRef) {
			$request->session()->flash('success', 'Your Widthdraw Update Successfully!');
			return redirect('/withdraw_view'. '/' . $request['id']);
		} else {
			$request->session()->flash('error', 'Something Went Wrong!');
			return redirect('/withdraw_view'. '/' . $request['id']);
		}
	}
	//Widthdraw Update
}



// $data = [
// 	'id' => "",
// ];
// $docRef = $db->collection('products')->add($data);



// $data = [
// 	['path' => 'name', 'value' => $request['name']],
// ];
// $docRef = $db->collection('products')->document($request['id'])->update($data);
