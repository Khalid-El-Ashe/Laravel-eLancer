<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\ProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class ProjectsController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth:sanctum'])->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get the project by EgerLoading

        $entries = Project::latest()
            ->with(['user:id,name,email', 'category:id,name', 'tags:id,name'])
            ->paginate(5);
        // ->get([
        //     'id',
        //     'title',
        //     'category_id'
        // ]);
        // return $entries;
        return ProjectResource::collection($entries); // return a Resource collection of data
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProjectRequest $request)
    {
        /**
         * we know have a relation between User and Project Models
         * So we can use the relation to create the project for the authenticated user
         */
        $user = User::findOrFail(1); // Auth::user()
        // $request->merge([
        //     'user_id' => $user->id // Auth::id()
        // ]);

        $data = $request->except('attachments');

        // now i created the project using the relation
        $project = $user->projects()->create($data);
        // now need to save tags and call the syncTags() function from (ProjectModel)
        $tags = explode(',', $request->input('tags')); // now this tags is return a (type of Array[])
        $project->syncTags($tags);

        /**
         * all that ways is a return a same data, same perforance.
         */
        return $project; //return a collection json
        // return response(content: $project, status: 201);
        // return response()->json(data: $project, status: 201);
        // return Response::json(data: $project, status: 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        // get the project by EgerLoading
        // return Project::with('category')->findOrFail($id);

        // get the project by EgerLoading using Model pindening
        // return $project->load(['category:id,name', 'user:id,name', 'tags', 'proposals']);

        //return by using a Api Resource
        return new ProjectResource($project);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            'description' => ['sometimes', 'required', 'string'],
            'type' => ['sometimes', 'required', 'in:fixed,hourly'],
            'budget' => ['nullable', 'numeric', 'min:0'],
        ]);
        $project = Project::findOrFail($id);
        $project->update($request->all());
        return $project;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $user = Auth::guard('sanctum')->user();
        if (!$user->tokenCan('project.delete')) {
            return response()->json([
                'message' => 'Permission Denied!'
            ], 403);
        }
        $project->delete();

        if ($project->attachments) {
            foreach ($project->attachments as $file) {
                Storage::disk('public')->delete($file);
            }
        }
        return [
            'message' => "Project $project->title is Deleted"
        ];
    }
}
