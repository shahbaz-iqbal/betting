<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class BettingController extends Controller
{
	public function index()
	{
		return view('betting/index');
	}
	public function add()
	{
		return view('match/add');
	}
	public function edit($id)
	{
		return view('match/edit', ['id' => $id]);
	}
}
