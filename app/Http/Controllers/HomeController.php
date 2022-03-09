<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Google\Cloud\Firestore\FirestoreClient;
use Illuminate\Http\Request;

class HomeController extends Controller
{
	public function index()
	{
		return view('login');
	}
	public function dashboard()
	{
		return view('layout/index');
	}
	public function dashboard_count()
	{
		$db = new FirestoreClient([
			'projectId' => 'bettingapp-70c54',
		]);
		$count_users = $db->collection('users')->documents();
		foreach ($count_users as $keyusers => $count_user) {
			$total_user = $keyusers += 1;
		}
		$count_songs = $db->collection('Teams')->documents();
		foreach ($count_songs as $keysongs => $counts_songs) {
			$total_song = $keysongs += 1;
		}
		$count_playlist = $db->collection('Matches')->documents();
		foreach ($count_playlist as $keyplaylist => $counts_playlist) {
			$total_playlist = $keyplaylist += 1;
		}
		$count_artist = $db->collection('Categories')->documents();
		foreach ($count_artist as $keyartist => $counts_artist) {
			$total_artist = $keyartist += 1;
		}
		$data = [
			'total_user' => $total_user,
			'total_team' => $total_song,
			'total_match' => $total_playlist,
			'total_category' => $total_artist,
		];
		return response()->json($data);
	}
	public function login(Request $request)
	{
		if (empty($request->session()->get('email'))) {
			return view('system/login');
		} else {
			return redirect('/dashboard');
		}
	}
	public function check_login(Request $request)
	{
		$db = new FirestoreClient([
			'projectId' => 'bettingapp-70c54',
		]);
		$name = $_POST['email'];
		$password = $_POST['password'];
		$citiesRef = $db->collection('users')->document('admin')->snapshot()->data();
		if ($citiesRef['email'] == $name && $citiesRef['password'] == $password) {
			$session_data = [
				'first_name' => $citiesRef['first_name'],
				'last_name' => $citiesRef['last_name'],
				'password' => $citiesRef['password'],
				'email' => $citiesRef['email'],
				'image' => $citiesRef['image'],
			];
			$request->session()->put($session_data);
			return redirect('/dashboard');
		} else {
			$request->session()->flash('error', 'Invalid! Email Or Password');
			return redirect('/');
		}
	}

	public function admin_edit()
	{
		$db = new FirestoreClient([
			'projectId' => 'bettingapp-70c54',
		]);
		$citiesRef = $db->collection('users')->document('admin')->snapshot()->data();

		//, ['admin' => $citiesRef]
		return view('system/edit', ['admin' => $citiesRef]);
	}
	public function admin_update(Request $request)
	{
		$session = session();
		$first_name = $_POST['first_name'];
		$last_name = $_POST['last_name'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		// $file = $_POST['img'];
		$file = $request->file('img');

		if ($_FILES['img']['name']) {
			$fileName = time() . $file->getClientOriginalName();
			$file->move('uploads/', $fileName);

			// $fileName = $file->getRandomName();
			// $file->move(ROOTPATH . 'assets/uploads/', $fileName);
		} else {
			$fileName = $_POST['oldimg'];
		}
		$session_data = [
			'last_name' => $last_name,
			'first_name' => $first_name,
			'password' => $password,
			'email' => $email,
			'image' => $fileName,
		];
		$request->session()->put($session_data);
		// $session->set($session_data);
		$data = [
			['path' => 'first_name', 'value' => $first_name],
			['path' => 'last_name', 'value' => $last_name],
			['path' => 'email', 'value' => $email],
			['path' => 'password', 'value' => $password],
			['path' => 'image', 'value' => $fileName],
		];
		$db = new FirestoreClient([
			'projectId' => 'bettingapp-70c54',
		]);
		$db->collection('users')->document('admin')->update($data);
		return redirect('/dashboard');
	}
	public function logout(Request $request)
	{
		$request->session()->flush();
		return redirect('/');
	}
}
