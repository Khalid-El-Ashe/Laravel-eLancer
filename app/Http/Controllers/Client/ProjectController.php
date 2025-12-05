<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\ProjectRequest;
use App\Models\Category;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        // $projects = Project::with('category')->where('user_id', '=', $user->id)->paginate(10);
        $projects = $user->projects()->with('category.parent')->paginate(10); // using the Nested-Eager-Loading (with())
        return view('client.projects.index', ['projects' => $projects]);
    }

    public function create()
    {


        return view('client.projects.create', [
            'project' => new Project(),
            'types' => Project::types(),
            'categories' => $this->categories()
        ]);
    }

    /**
     * Summary of store
     * @param ProjectRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ProjectRequest $request)
    {
        /**
         * we know have a relation between User and Project Models
         * So we can use the relation to create the project for the authenticated user
         */
        $user = $request->user(); // Auth::user()
        // $request->merge([
        //     'user_id' => $user->id // Auth::id()
        // ]);

        // now i created the project using the relation
        $project = $user->projects()->create($request->all());
        return redirect()->route('client.projects.index', $project->id)
            ->with('success', 'Project created successfully.')->setStatusCode(201);
    }

    public function show($id)
    {
        $user = Auth::user();
        $project = $user->projects()->firstOrFail($id);
        return view('client.projects.show', ['project' => $project]);
    }

    public function edit($id)
    {
        $user = Auth::user();
        $project = $user->projects()->findOrFail($id);
        return view('client.projects.edit', [
            'project' => $project,
            'types' => Project::types(),
            'categories' => $this->categories(),
        ]);
    }

    public function update(ProjectRequest $request, $id)
    {
        $user = Auth::user();
        $project = $user->projects()->firstOrFail($id);

        $project->update($request->all());
        return redirect()->route('client.projects.index')
            ->with('success', 'Project updated successfully.')->setStatusCode(200);
    }

    public function destroy($id)
    {
        // $user = Auth::user();
        // $project = $user->projects()->firstOrFail($id);
        // Project::where('user_id', Auth::id())->where('id', $id)->firstOrFail()->delete();

        /**
         * or delete by relation
         */
        $user = Auth::user();
        $user->projects()->where('id', $id)->delete();

        return redirect()->route('client.projects.index')
            ->with('success', 'Project deleted successfully.')->setStatusCode(200);
    }

    protected function categories()
    {
        return Category::pluck('name', 'id')->toArray();
    }
}
