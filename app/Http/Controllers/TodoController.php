<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;

class TodoController extends Controller
{
    public function index() {
        $todos = Todo::orderBy('id')->paginate(50);
        return $todos;
    }

    public function add(Request $request) {
        Todo::create([
            "name" => $request->input('name'),
            "age" => $request->input('age'),
        ]);
    }

    public function update(Request $request) {
        Todo::where("id", "=", $request->input('id'))->update([
            "name" => $request->input('name'),
            "age" => $request->input('age'),
        ]);
    }

    public function delete(Request $request) {
        Todo::where("id", "=", $request->input('id'))->delete();
    }
}
