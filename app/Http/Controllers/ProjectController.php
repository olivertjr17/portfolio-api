<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    /**
     * Display a listing of all projects.
     */
    public function index()
    {
        $projects = Project::orderBy('created_at', 'desc')->paginate(5); // 5 per page
        return response()->json($projects);
    }

    public function allProjects()
    {
        $projects = Project::orderBy('created_at', 'desc')->get();

        return response()->json($projects);
    }

    public function allFeaturedProjects()
    {
        $projects = Project::where('is_featured', true)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($projects);
    }


    /**
     * Store a newly created project.
     */
    public function store(Request $request)
    {
        $request->merge([
            'is_featured' => filter_var($request->input('is_featured'), FILTER_VALIDATE_BOOLEAN),
        ]);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'tech_stack' => 'nullable|string',
            'demo_link' => 'nullable|url',
            'github_link' => 'nullable|url',
            'image' => 'nullable|file|image|max:2048', // optional image upload
            'is_featured' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();

        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('projects', 'public');
        }

        $project = Project::create($data);

        return response()->json([
            'message' => 'Project created successfully!',
            'project' => $project,
        ], 201);
    }

    /**
     * Display the specified project.
     */
    public function show(Project $project)
    {
        return response()->json($project);
    }

    /**
     * Update the specified project.
     */
    public function update(Request $request, Project $project)
    {
        $request->merge([
            'is_featured' => filter_var($request->input('is_featured'), FILTER_VALIDATE_BOOLEAN),
        ]);

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'tech_stack' => 'nullable|string',
            'demo_link' => 'nullable|url',
            'github_link' => 'nullable|url',
            'image' => 'nullable|file|image|max:2048',
            'is_featured' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();

        // Handle new image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($project->image && Storage::disk('public')->exists($project->image)) {
                Storage::disk('public')->delete($project->image);
            }

            $data['image'] = $request->file('image')->store('projects', 'public');
        }

        $project->update($data);

        return response()->json([
            'message' => 'Project updated successfully!',
            'project' => $project,
        ]);
    }

    /**
     * Remove the specified project from storage.
     */
    public function destroy(Project $project)
    {
        // Delete image if exists
        if ($project->image && Storage::disk('public')->exists($project->image)) {
            Storage::disk('public')->delete($project->image);
        }

        $project->delete();

        return response()->json(['message' => 'Project deleted successfully.']);
    }
}
