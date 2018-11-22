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
        $developer = DeveloperContact::find($id);

        $resource = new Item($developer, new DeveloperContactTransformer);

        return $this->fractal->createData($resource)->toArray();
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

        $resource = new Item($developer, new DeveloperContactTransformer);

        return $this->fractal->createData($resource)->toArray();
    }

    public function update( Request $request, $id)
    {
      $this->validate($request, [
          'firstname' => 'required',
          'lastname' => 'required',
          'email' => 'required|email|unique:developer_contacts,id,'.$request->get('id'),
          'phoneno' => 'required',
          'skypeid' => 'required|unique:developer_contacts,id,'.$request->get('id'),
          'linkedin' => 'required|unique:developer_contacts,id,'.$request->get('id'),
          'country' => 'required|alpha',
      ]);
        $developer = DeveloperContact::findOrFail($id);
        $developer->update($request->all());

        if($developer){
            //return updated data
            $resource = new Item(DeveloperContact::find($id), new DeveloperContactTransformer);
            return $this->fractal->createData($resource)->toArray();
        }
        //Return error 400 response if updated was not successful
        return $this->errorResponse('Failed to update Developer Contact!', 400);
    }

    public function delete($id)
    {
        if(!DeveloperContact::find($id))
          return $this->errorResponse('Developer not found!', 404);

        $developer = DeveloperContact::find($id);

        $developerCategory = $developer->developerCategory();

        $developerCategory->delete();

        if($developer->delete())
          return $this->customResponse('Developer deleted successfully!', 410);

        return $this->errorResponse('Failed to delete developer!', 400);
    }

    public function customResponse($message = 'success', $status = 200)
    {
        return response(['status' =>  $status, 'message' => $message], $status);
    }

    public function errorResponse($message = 'fail', $status = 404)
    {
        return response(['status' =>  $status, 'message' => $message], $status);
    }
}
