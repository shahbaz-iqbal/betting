<?php

namespace App\Http\Controllers;

use Exception;
use App\Http\Controllers\Controller;
use Google\Cloud\Firestore\FirestoreClient;
use Illuminate\Http\Request;
use Google\Cloud\Firestore\FieldValue;

class UserController extends Controller
{
	public function index()
	{
		return view('user/index');
	}
	function showAll()
	{
		$db = new FirestoreClient([
			'projectId' => 'bettingapp-70c54',
		]);
		$PonitsRef = $db->collection('users');
		foreach ($PonitsRef->documents() as $document) {
			if ($document->exists()) {
				if ($document->id() != 'admin') {
					$users[] = $document->data();
				}
			}
		}
		echo json_encode($users);
	}
	public function add()
	{
		return view('user/add');
	}
	public function insert(Request $request)
	{

		$myObj = [
			'email' => $request['email'],
			'password' => $request['password'],
			'returnSecureToken' => true,
		];
		$myJSON = json_encode($myObj);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://identitytoolkit.googleapis.com/v1/accounts:signUp?key=AIzaSyD1kV-JuRfm6kUOTetE1wfTVeJ6bAub794");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST,           1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,     $myJSON);
		curl_setopt($ch, CURLOPT_HTTPHEADER,     array('Content-Type: text/plain'));
		$results = curl_exec($ch);

		$id = json_decode($results);

		if (empty($id->error)) {
			$user_id = $id->localId;
			$timestamp = FieldValue::serverTimestamp();
			$updatedtimestamp = FieldValue::serverTimestamp();
			$data = [
				'id' => $user_id,
				'name' => $request['name'],
				'email' => $request['email'],
				'password' => $request['password'],
				'country' => $request['country'],
				'createdAt' => $timestamp,
				'updatedAt' => $updatedtimestamp,
			];
			$db = new FirestoreClient([
				'projectId' => 'bettingapp-70c54',
			]);

			$docRef = $db->collection('users')->document($user_id)->set($data);
			if ($docRef) {
				$request->session()->flash('success', 'Your User Add Successfully!');
				return response()->json('success');
			} else {
				$request->session()->flash('error', 'Something Went Wrong!');
				return response()->json('success');
			}
		} else {
			return response()->json('error');
		}
	}
	public function edit($id)
	{
		// $db = new FirestoreClient([
		// 	'projectId' => 'bettingapp-70c54',
		// ]);
		// $users = $db->collection('users')->document($id)->snapshot()->data();
		return view('user/edit', ['id' => $id]);
		//return view('user/edit');
	}
	public function edit_response($id)
	{
		$db = new FirestoreClient([
			'projectId' => 'bettingapp-70c54',
		]);
		$users = $db->collection('users')->document($id)->snapshot()->data();
		return response()->json($users);
	}
	public function update(Request $request)
	{
		$updatedtimestamp = FieldValue::serverTimestamp();
		$data = [
			['path' => 'name', 'value' => $request['name']],
			['path' => 'email', 'value' => $request['email']],
			['path' => 'password', 'value' => $request['password']],
			['path' => 'country', 'value' => $request['country']],
			['path' => 'updatedAt', 'value' => $updatedtimestamp],
		];
		$db = new FirestoreClient([
			'projectId' => 'bettingapp-70c54',
		]);
		$docRef = $db->collection('users')->document($request['id'])->update($data);
		if ($docRef) {
			$request->session()->flash('success', 'Your User Update Successfully!');
			return response()->json('success');
			//return redirect('/users');
		} else {
			$request->session()->flash('error', 'Something Went Wrong!');
			return response()->json('error');
			//return redirect('/users');
		}
	}
	public function view($id)
	{
		return view('user/view', ['id' => $id]);
	}
	public function detail($id)
	{
		try {
			// $this->buildXMLHeader();

			$db = new FirestoreClient([
				'projectId' => 'bettingapp-70c54',
			]);
			// $user = $db->collection('users')->document($id)->snapshot()->data();
			// $betting = $db->collection('UserBettings')->document($id)->snapshot()->data();
			$betting_ref = $db->collection('UserBettings')->document($id)->collection('History');
			foreach ($betting_ref->documents() as $document1) {
				$betting_history[] = $document1->data();
			}

			$shop_ref = $db->collection('Shop')->document($id)->collection('PurchaseHistory');
			foreach ($shop_ref->documents() as $key => $document) {
				$shop_ref_history[] = $document->data();
			}
			$point = $db->collection('Points')->document($id)->snapshot()->data();
			// foreach ($points_ref->documents() as $key => $document) {
			// 	$$points_ref_history[] = $document->data();
			// }
			$data = [
				// 'user' => $user,
				'point' => $point,
				// 'betting' => $bettingdd,
				'betting_historys' => $betting_history,
				'shop_ref_history' => $shop_ref_history,
			];
			return response()->json($data);
		} catch (\Exception $e) {
			return response()->json("error");
			// return $e->getMessage();
		}
	}
	public function specific_match_detail($id, $cat)
	{
		try {
			// $this->buildXMLHeader();

			$db = new FirestoreClient([
				'projectId' => 'bettingapp-70c54',
			]);
			// $user = $db->collection('users')->document($id)->snapshot()->data();
			// $betting = $db->collection('UserBettings')->document($id)->snapshot()->data();
			$betting_ref = $db->collection('UserBettings')->document($id)->collection('History');
			// $query = $betting_ref->where('bet_for', '=', $cat);
			// $snapshot = $query->documents();
			foreach ($betting_ref->documents() as $document1) {
				if ($document1->data()['bet_for'] == $cat) {
					$betting_history[] = $document1->data();
				}
			}
			return response()->json($betting_history);
			// $shop_ref = $db->collection('Shop')->document($id)->collection('PurchaseHistory');
			// foreach ($shop_ref->documents() as $key => $document) {
			// 	$shop_ref_history[] = $document->data();
			// }
			$point = $db->collection('Points')->document($id)->snapshot()->data();
			// foreach ($points_ref->documents() as $key => $document) {
			// 	$$points_ref_history[] = $document->data();
			// }

			$data = [
				// 'user' => $user,
				'point' => $point,
				// 'betting' => $bettingdd,
				'betting_historys' => $betting_history,
				// 'shop_ref_history' => $shop_ref_history,
			];
			return response()->json($data);
		} catch (\Exception $e) {
			// return response()->json("error");
			return $e->getMessage();
		}
	}
	public function user_detail_only($id)
	{
		$db = new FirestoreClient([
			'projectId' => 'bettingapp-70c54',
		]);
		$user = $db->collection('users')->document($id)->snapshot()->data();
		$betting = $db->collection('UserBettings')->document($id)->snapshot()->data();
		$data = [
			'user' => $user,
			'betting' => $betting,
		];
		return response()->json($data);
	}
	public function delete(request $request, $id)
	{
		$db = new FirestoreClient([
			'projectId' => 'bettingapp-70c54',
		]);
		$session = session();
		$delete = $db->collection('users')->document($id)->delete();
		if ($delete) {
			$request->session()->flash('success', 'Your Delete Update Successfully!');
			return redirect('/users');
		} else {
			$request->session()->flash('error', 'Something Went Wrong!');
			return redirect('/users');
		}
	}
	public function match_detail(request $request, $id, $cat)
	{
		return view('user/match', ['id' => $id, 'cat' => $cat]);
	}
}
