<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class TeamController extends Controller
{
	public function index()
	{
		return view('team/index');
	}
	public function add()
	{
		return view('team/add');
	}
	public function edit($id)
	{
		return view('team/edit', ['id' => $id]);
	}
}
