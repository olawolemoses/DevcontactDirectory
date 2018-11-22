<?php

namespace App\Http\Controllers;

use App\DevelopersContact;
use Illuminate\Http\Request;

class DeveloperController extends Controller
{

    public function showAllDevelopers()
    {
        return response()->json(DevelopersContact::all());
    }

    public function showOneDeveloper($id)
    {
        return response()->json(DevelopersContact::find($id));
    }

    public function create(Request $request)
    {
      $this->validate($request, [
          'firstname' => 'required',
          'lastname' => 'required',
          'cat' => 'required',
          'phoneno' => 'required|numeric',
          'github' => 'required',
          'country' => 'required|alpha',
          'email' => 'required|email|unique:users'
      ]);

        $author = DevelopersContact::create($request->all());

        return response()->json($author, 201);
    }

    public function update($id, Request $request)
    {
        $author = DevelopersContact::findOrFail($id);
        $author->update($request->all());

        return response()->json($author, 200);
    }

    public function delete($id)
    {
        DevelopersContact::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);
    }
}
