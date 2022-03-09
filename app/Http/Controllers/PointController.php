<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class PointController extends Controller
{
	public function index()
	{
		return view('point/index');
	}
	public function view($id)
	{
		return view('point/view', ['id' => $id]);
	}

	public function withdraw()
	{
		return view('point/withdraw');
	}
	public function withdraw_view($id)
	{
		return view('point/withdraw_view', ['id' => $id]);
	}
}
