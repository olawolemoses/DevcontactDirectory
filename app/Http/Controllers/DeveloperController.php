<?php

namespace App\Http\Controllers;

use League\Fractal;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\Collection;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;

use App\DeveloperContact;
use App\DeveloperCategory;
use App\Category;

use App\Transformers\DeveloperContactTransformer;
use Illuminate\Http\Request;

class DeveloperController extends Controller
{

  private $fractal;

  public function __construct()
  {
      $this->fractal = new Manager();
  }

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
        $developers = DeveloperContact::with('developerCategory.category');

        $developers = $developers->paginate();

        $paginator = DeveloperContact::with('developerCategory.category')->paginate();

        $developers = $paginator->getCollection();
        $resource = new Collection($developers, new DeveloperContactTransformer);
        $resource->setPaginator(new IlluminatePaginatorAdapter($paginator));
        return $this->fractal->createData($resource)->toArray();
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
