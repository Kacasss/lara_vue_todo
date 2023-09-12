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
        if ($request->input('csrf') !== 'csrfトークン') {
            return response()->json('不正な処理です');
        }

        $inputs = request()->validate([
            "name" => 'required',
            "age" => 'required | min:0 | numeric',
        ]);

        // file_put_contents('test.txt', print_r($request->input('csrf'), true));

        Todo::create([
            "name" => $inputs["name"],
            "age" => $inputs["age"],
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
