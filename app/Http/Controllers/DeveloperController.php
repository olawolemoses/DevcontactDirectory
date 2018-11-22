<?php

namespace App\Http\Controllers;

use App\DeveloperContact;
use App\DeveloperCategory;
use App\Category;
use Illuminate\Http\Request;

class DeveloperController extends Controller
{

  public function showAllDevelopersByCategory($id)
  {
      $developers = DeveloperContact::whereHas('developerCategory.category', function ($query) use($id) {
                        $query->where('id', '=', $id)
                        ->orWhere('slug', $id);
                    })->get();


      return response()->json($developers);
  }

    public function showAllDevelopers()
    {
        $developers = DeveloperContact::with('developerCategory.category')->get();
        return response()->json($developers);
    }

    public function showOneDeveloper($id)
    {
        return response()->json(DeveloperContact::find($id));
    }

    public function create(Request $request, $id)
    {
      $category = Category::where('id', $id)->orWhere('slug', $id)->firstOrFail();

      $this->validate($request, [
          'firstname' => 'required',
          'lastname' => 'required',
          'email' => 'required|email|unique:developer_contacts',
          'phoneno' => 'required|numeric',
          'skypeid' => 'required|unique:developer_contacts',
          'linkedin' => 'required|unique:developer_contacts',
          'country' => 'required|alpha',
      ]);

        $developer = DeveloperContact::create($request->all());

        $developerCategory = new DeveloperCategory;
        $developerCategory->developer_id = $developer->id;
        $developerCategory->category_id = $category->id;
        $developerCategory->save();

        return response()->json($developer, 201);
    }

    public function update($id, Request $request)
    {
        $developer = DeveloperContact::findOrFail($id);
        $developer->update($request->all());

        return response()->json($developer, 200);
    }

    public function delete($id)
    {
        $developer = DeveloperContact::findOrFail($id);
        $developerCategory = $developer->developerCategory();
        $developerCategory->delete();

        $developer->delete();
        return response('Deleted Successfully', 200);
    }
}
