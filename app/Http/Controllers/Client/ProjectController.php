<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\ProjectRequest;
use App\Models\Category;
use App\Models\Project;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProjectController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        // $projects = Project::with('category')->where('user_id', '=', $user->id)->paginate(10);
        $projects = $user->projects()
            /** if you need turned the once Globel Scope or all Global Scope ->withoutGlobalScopes()   */
            ->withoutGlobalScope('active')
            // ->hourly() /** calling the Local Scope */
            // ->filter(['status' => 'open', 'budget_min' => 1000, 'budget_max' => 4000])
            ->highestBudget()
            ->with('category.parent', 'tags')->paginate(3); // using the Nested-Eager-Loading (with())
        return view('client.projects.index', ['projects' => $projects]);
    }

    public function create()
    {
        return view('client.projects.create', [
            'project' => new Project(),
            'types' => Project::types(),
            'categories' => $this->categories(),
            'tags' => [],
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

        $data = $request->except('attachments');
        /**
         * saving a multiFiles
         */
        $data['attachments'] = $this->uploadAttachments($request);

        // now i created the project using the relation
        $project = $user->projects()->create($data);
        // now need to save tags and call the syncTags() function from (ProjectModel)
        $tags = explode(',', $request->input('tags')); // now this tags is return a (type of Array[])
        $project->syncTags($tags);

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

        // dd($project->attachments);
        return view('client.projects.edit', [
            'project' => $project,
            'types' => Project::types(),
            'categories' => $this->categories(),
            'tags' => $project->tags()->pluck('name')->toArray()
        ]);
    }

    public function update(ProjectRequest $request, $id)
    {
        $user = Auth::user();
        $project = $user->projects()->findOrFail($id);


        $data = $request->except('attachments');
        /**
         * saving a multiFiles
         */
        $data['attachments'] = array_merge(($project->attachments ?? []), $this->uploadAttachments($request));
        $project->update($data);


        // now need to save tags and call the syncTags() function from (ProjectModel)
        $tags = explode(',', $request->input('tags')); // now this tags is return a (type of Array[])
        $project->syncTags($tags);

        return redirect()->route('client.projects.index')
            ->with('success', __('Project updated successfully.'))->setStatusCode(200);
    }

    public function destroy($id)
    {
        // $user = Auth::user();
        // $project = $user->projects()->firstOrFail($id);
        // Project::where('user_id', Auth::id())->where('id', $id)->firstOrFail()->delete();

        /**
         * or delete by relation
         * when delete i need delete the files for this project
         */
        $user = Auth::user();
        $project = $user->projects()->findOrFail($id);
        $project->delete();
        foreach ($project->attachments as $file) {
            Storage::disk('public')->delete($file);
        }

        return redirect()->route('client.projects.index')
            ->with('success', 'Project deleted successfully.')->setStatusCode(200);
    }

    protected function categories()
    {
        return Category::pluck('name', 'id')->toArray();
    }

    protected function uploadAttachments(ProjectRequest $request)
    {
        /**
         * saving a multiFiles
         */
        if (!$request->hasFile('attachments')) {
            return;
        }
        $files = $request->file('attachments');
        $attachments = [];
        foreach ($files as $file) {
            if ($file->isValid()) {
                // $file->getClientOriginalName();
                // $file->getClientOriginalExtension();
                // $file->getSize();
                // $file->getMTime(); // last-time update for this file
                $path = $file->store('/attachments', [
                    'disk' => 'uploads'
                ]);
                $attachments[] = $path;
            }
        }
        return $attachments;
    }
}
