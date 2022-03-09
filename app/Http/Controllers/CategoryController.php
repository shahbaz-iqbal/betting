<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Google\Cloud\Firestore\FirestoreClient;
use Illuminate\Http\Request;
use Google\Cloud\Firestore\FieldValue;

class CategoryController extends Controller
{
	public function index()
	{

		return view('category/index');
	}
	public function list()
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
		return response()->json($users);
		// echo json_encode($users);
		// return view('category/index');
	}
	function showAll()
	{
		$db = new FirestoreClient([
			'projectId' => 'bettingapp-70c54',
		]);
		$PonitsRef = $db->collection('Categories');
		foreach ($PonitsRef->documents() as $document) {
			if ($document->exists()) {
				$categories[] = $document->data();
			}
		}
		return response()->json($categories);
	}
	public function add()
	{
		return view('category/add');
	}
	public function insert(Request $request)
	{
		if (!empty($_FILES['file']['name'])) {
			$file = $_FILES['file']['name'];
			$filename1 = uniqid();
			$post_fields = file_get_contents($_FILES['file']['tmp_name']);
			$url = 'https://firebasestorage.googleapis.com/v0/b/bettingapp-70c54.appspot.com/o?uploadType=media&name=' . $filename1;
			$header = array('X-HTTP-Method-Override: POST', 'Content-Type: image/png');
			$resource = curl_init();
			curl_setopt($resource, CURLOPT_URL, $url);
			curl_setopt($resource, CURLOPT_HTTPHEADER, $header);
			curl_setopt($resource, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($resource, CURLOPT_POST, 1);
			curl_setopt($resource, CURLOPT_POSTFIELDS, $post_fields);
			$result = json_decode(curl_exec($resource));
			curl_close($resource);
			$fileName = 'https://firebasestorage.googleapis.com/v0/b/bettingapp-70c54.appspot.com/o/' . $result->name . '?alt=media&token=' . $result->downloadTokens;
			// $fileName = time() . '.' . $request->file->getClientOriginalExtension();
			// $request->file->move(public_path('assets/uploads'), $fileName);
		} else {
			$fileName = "";
		}
		$createdtimestamp = FieldValue::serverTimestamp();
		$updatedtimestamp = FieldValue::serverTimestamp();
		$data = [
			'categoryid' => "",
			'name' => $request['name'],
			'discription' => $request['discription'],
			'icon' => $fileName,
			'visited' => 0,
			'created' => $createdtimestamp,
			'updated' => $updatedtimestamp,
		];
		$db = new FirestoreClient([
			'projectId' => 'bettingapp-70c54',
		]);

		$docRef = $db->collection('Categories')->add($data);
		$id = $docRef->id();
		$datares = [
			['path' => 'categoryid', 'value' => $id]
		];
		$res = $db->collection('Categories')->document($id)->update($datares);
		return response()->json($res);
	}
	public function edit($id)
	{
		// $db = new FirestoreClient([
		// 	'projectId' => 'bettingapp-70c54',
		// ]);
		// $users = $db->collection('users')->document($id)->snapshot()->data();
		return view('category/edit', ['id' => $id]);
		//return view('user/edit');
	}
	public function edit_response($id)
	{
		$db = new FirestoreClient([
			'projectId' => 'bettingapp-70c54',
		]);
		$Categories = $db->collection('Categories')->document($id)->snapshot()->data();
		return response()->json($Categories);
	}
	public function update(Request $request)
	{

		if (!empty($_FILES['file']['name'])) {
			$file = $_FILES['file']['name'];
			$filename1 = uniqid();
			$post_fields = file_get_contents($_FILES['file']['tmp_name']);
			$url = 'https://firebasestorage.googleapis.com/v0/b/bettingapp-70c54.appspot.com/o?uploadType=media&name=' . $filename1;
			$header = array('X-HTTP-Method-Override: POST', 'Content-Type: image/png');
			$resource = curl_init();
			curl_setopt($resource, CURLOPT_URL, $url);
			curl_setopt($resource, CURLOPT_HTTPHEADER, $header);
			curl_setopt($resource, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($resource, CURLOPT_POST, 1);
			curl_setopt($resource, CURLOPT_POSTFIELDS, $post_fields);
			$result = json_decode(curl_exec($resource));
			curl_close($resource);
			$fileName = 'https://firebasestorage.googleapis.com/v0/b/bettingapp-70c54.appspot.com/o/' . $result->name . '?alt=media&token=' . $result->downloadTokens;
			// $fileName = time() . '.' . $request->file->getClientOriginalExtension();
			// $request->file->move(public_path('assets/uploads'), $fileName);
		} else {
			$fileName = "";
		}
		// if (!empty($_FILES['file']['name'])) {
		// 	$fileName = time() . '.' . $request->file->getClientOriginalExtension();
		// 	$request->file->move(public_path('assets/uploads'), $fileName);
		// } else {
		// 	$fileName =  $request['oldfile'];
		// }
		$updatedtimestamp = FieldValue::serverTimestamp();

		$data = [
			['path' => 'name', 'value' => $request['name']],
			['path' => 'discription', 'value' => $request['discription']],
			['path' => 'icon', 'value' => $fileName],
			['path' => 'updatedAt', 'value' => $updatedtimestamp],
		];
		$db = new FirestoreClient([
			'projectId' => 'bettingapp-70c54',
		]);


		$db->collection('Categories')->document($request['id'])->update($data);

		return response()->json('success');
	}
	public function delete(request $request, $id)
	{
		$db = new FirestoreClient([
			'projectId' => 'bettingapp-70c54',
		]);
		// $session = session();
		$delete = $db->collection('Categories')->document($id)->delete();
		if ($delete) {
			return response()->json('success');
			// $request->session()->flash('success', 'Your Delete Update Successfully!');
			// return redirect('/users');
		} else {
			return response()->json('error');
			// $request->session()->flash('error', 'Something Went Wrong!');
			// return redirect('/users');
		}
	}
}
