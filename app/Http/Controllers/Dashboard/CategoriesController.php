<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Rules\FilterRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{
    protected $rules = [
        'name' => ['required', 'string', 'min:2', 'max:50', 'filter'],
        'parent_id' => ['nullable', 'int', 'exists:categories,id'],
        'description' => ['required', 'string', 'min:5'],
        'art_path' => ['nullable', 'mimes:jpeg,jpg,png,gif,svg,webp']
    ];
    protected $messages = [
        'name.required' => 'The name field is mandatory',
        'image' => 'The art file should be image type'
    ];

    // in here build the Action Methods for route
    public function index()
    {
        // using the DB Builder to make queries in the database
        // $entries = DB::table('categories')->get(); // get collectoin of data
        // return $entries->count();
        // return $entries->first();
        // return $entries->last();
        // dd($entries[0]);
        // dd($entries);

        // $categories = Category::get();

        //todo using (inner-join) for relations to get the data from the two table
        // $categories = Category::join('categories as parents', 'parents.id', '=', 'categories.parent_id')
        //     ->select(['categories.*', 'parents.name as parent_name'])->get();

        $categories = Category::leftJoin('categories as parents', 'parents.id', '=', 'categories.parent_id')
            ->select(['categories.*', 'parents.name as parent_name'])->paginate(10);


        return view('categories.index', [
            'categories' => $categories,
            'flash_message' => session('success')
        ]);
        // return view('categories.index')->with([
        //     'categories' => $entries
        // ]);
    }

    // if the parameter in route is optional should add a default value
    public function show(Category $category)
    {
        // $category = DB::table('categories')->where('id', '=', $id)->first();
        // $category = Category::where('id', '=', $id)->first();
        // $category = Category::find($id);
        // if ($category == null) {
        //     abort(404);
        // }
        // $category = Category::where('id', '=', $category->id)->firstOrFail();
        // $category = Category::findOrFail($id); // is get the method abort 404 if the $id is null
        return view('categories.show', ['category' => $category]);
    }

    public function create()
    {
        $parents = Category::get();
        $category = new Category();

        return view('categories.create', ['parents' => $parents, 'category' => $category]);
    }

    public function store(Request $request)
    {
        // DB::table('categories')->create([]);

        // $clean = $request->validate([
        //     'name' => 'required|string|max:50',
        //     'parent_id' => ['nullable', 'int', 'exists:categories,id'],
        //     'description' => ['nullable', 'string'],
        //     'art_path' => ['nullable', 'mimes:jpeg,jpg,png,gif,svg,webp']
        // ]);
        $clean = $request->validate($this->rules, $this->messages); // the message is a default value. not required
        // $validator = Validator::make($request->all(), $rules, $messages);
        // if ($validator->fails()) {
        //     return redirect()->back()->withErrors($validator);
        // }
        // $category = new Category();
        // $category->name = $request->input('name');
        // $category->description = $request->input('description');
        // $category->parent_id = $request->input('parent_id');
        // $category->slug = Str::slug($category->name);

        // $category = Category::create([
        //     'name' => $request->input('name'),
        //     'description' => $request->input('description'),
        //     'parent_id' => $request->input('parent_id'),
        //     'slug' => Str::slug($request->input('name')),
        // ]);
        $data = $request->all();
        // dd($data);

        // if (!$data['slug']) {
        //     $data['slug'] = Str::slug($data['name']);
        // }

        $category = Category::create($data);
        // $category = Category::create($request->only('name', 'parent_id', 'slug'));
        // $category = Category::create($request->except('name', 'parent_id', 'slug'));

        $category->save();

        //todo when the category is saved success (i need do the PRG: Post Redirect Get )
        return redirect()->route('categories.index')->with('success', 'Category is Created')->setStatusCode(201);

        // if ($validate) {
        //     $category = Category::create($request);
        //     $category->save();
        // }
        // return $request;
    }
    public function edit(Category $category)
    {
        // $category = Category::where('id', '=', $id)->firstOrFail();
        // $category = Category::findOrFail($id);

        $parents = Category::get();
        // $parents->pluck('name', 'id')->toArray();
        return view('categories.edit', ['category' => $category, 'parents' => $parents]);
    }
    public function update(Request $request, Category $category)
    {


        // $clean = $request->validate([
        //     'name' => 'required|string|max:50',
        //     'parent_id' => ['nullable', 'int', 'exists:categories,id'],
        //     'description' => ['nullable', 'string'],
        //     'art_path' => ['nullable', 'mimes:jpeg,jpg,png,gif,svg,webp']
        // ]);
        $clean = $request->validate($this->rules, $this->messages); // the message is a default value. not required

        // $category = Category::findOrFail($category->id);
        // $category->name = $request->input('name');
        // $category->description = $request->input('description');
        // $category->parent_id = $request->input('parent_id');
        // $category->slug = Str::slug($category->name);
        // $category->save();

        $category->update($request->all());

        return redirect()->route('categories.index')->with('success', 'Category is Updated')->setStatusCode(200);
    }
    public function destroy($id)
    {
        // DB::table('categories')->where('id', '=', $id)->delete();
        // Category::where('id', '=', $id)->delete();
        // Category::destroy($id);
        $category = Category::findOrFail($id);
        $category->delete();
        // session()->flash('success', 'Category is Deleted');
        // Session::flash('success', 'Category is Deleted');
        return redirect()->route('categories.index')->with('success', 'Category is Deleted')->setStatusCode(200);
    }

    public function trash()
    {
        // Category::withTrashed();
        $categories = Category::onlyTrashed()->paginate();
        return view('categories.trash', ['categories' => $categories]);
    }
    public function restore(Request $request, $id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->restore();
        return to_route('categories.index')->with('success', 'Category is Restored!');
    }
    public function forceDelete($id)
    {
        $category = Category::withTrashed()->findOrFail($id);
        $category->forceDelete();
        return to_route('categories.index')->with('success', 'Category is Deleted for ever!');
    }

    protected function rules()
    {
        $rules = $this->rules;
        // $rules['name'] = function ($attribute, $value, $fail) {
        //     if ($value == 'god') {
        //         $fail('This word is not allowed');
        //     }
        // };
        $rules['name'] = new FilterRule();
        return $rules;
    }
}
