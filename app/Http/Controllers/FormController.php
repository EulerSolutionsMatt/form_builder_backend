<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Form;

class FormController extends Controller {

    public function index() {
        return Form::all();
    }

    public function show(Form $form) {
        return $form;
    }

    public function store(Request $request) {
        $form = Form::create($request->all);

        return response()->json($form, 201);
    }

    public function update(Request $request, Form $form) {
        $form->update($request->all());
        return response()->json($form, 200);
    }

    public function delete(Form $form) {
        $form->delete();

        return response()->json(null, 204);
    }

}
