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
          'email' => 'required|email|unique:developer_contacts'
          'phoneno' => 'required|numeric',
          'skypeid' => 'required|unique:developer_contacts',
          'linkedin' => 'required|unique:developer_contacts',
          'country' => 'required|alpha',
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
