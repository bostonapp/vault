<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Documentation;
use App\Models\DocumentFile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Intervention\Image\Laravel\Facades\Image;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class UserDocumentController extends Controller
{

    public function dashboard()
    {

        $mytotalpost = Documentation::where('user_id', Auth::user()->id)->count();
        $mytotalpublicpost = Documentation::where('user_id', Auth::user()->id)->where('status', 'public')->count();
        $mytotalprivatepost = Documentation::where('user_id', Auth::user()->id)->where('status', 'private')->count();

        return view('user.dashboard.dashboard', compact('mytotalpost', 'mytotalpublicpost', 'mytotalprivatepost'));
    }


    public function index()
    {
        $alldocuments = Documentation::with('user')->where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->paginate(5);

        return view('user.documents.index', compact('alldocuments'));
    }

    public function allDocument()
    {

        $alldocuments = Documentation::whereHas('user', function($query){
            $query->whereNot('id', Auth::user()->id);
        })->where('is_approved', 'approved')->where('status', 'public')->orderBy('created_at', 'DESC')->paginate(5);

        return view('user.documents.allDocument', compact('alldocuments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('user.documents.create', compact('categories'));
    }

    /**user
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'topic' => ['required'],
            'category_id' => ['required'],
            'source' => ['nullable'],
            'description' => ['required'],
            'status' => ['required'],
            'files' => ['nullable']
        ]);

        // Initialize the data array
        $data = [
            'topic' => $request->topic,
            'category_id' => $request->category_id,
            'source' => $request->source,
            'description' => $request->description,
            'status' => $request->status,
            'user_id' => Auth::user()->id,
        ];

        $document = Documentation::create($data);

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $ext = $file->getClientOriginalExtension();
                $fileName = 'document' . '-' . rand() . '.' . $ext;
                $file->move(public_path('uploads'), $fileName);

                DocumentFile::create([
                    'files' => 'uploads/' . $fileName,
                    'documentation_id' => $document->id

                ]);
            }
        }

        toastr()->success('Data has been saved successfully!');

        return redirect()->route('user.documents.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $item = Documentation::with('files')->findOrFail($id);

        if ($item->user_id !== Auth::user()->id && $item->status === 'private') {
            toastr()->error('Unauthorized');
            return redirect()->back();
        }

        return view('user.documents.show', compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $categories = Category::all();
        $document = Documentation::findOrFail($id);

        if ($document->user_id !== Auth::user()->id) {
            toastr()->error('Unauthorized');
            return redirect()->back();
        }

        return view('user.documents.edit', compact('document','categories'));
    }



    public function update(Request $request, string $id)
    {
        // Find the documentation record
        $document = Documentation::findOrFail($id);

        // Check if the authenticated user owns the document
        if ($document->user_id !== Auth::user()->id) {
            toastr()->error('Unauthorized');
            return redirect()->back();
        }

        // Validate the request
        $request->validate([
            'topic' => ['required'],
            'category_id' => ['nullable'],
            'source' => ['nullable'],
            'description' => ['required'],
            'status' => ['required'],
            'files.*' => ['nullable', 'file'],
        ]);


        $data = [
            'topic' => $request->topic,
            'category_id' => $request->category_id,
            'source' => $request->source,
            'description' => $request->description,
            'status' => $request->status,
        ];

        $document->update($data);


        if ($request->hasFile('files')) {

            foreach ($document->files as $existingFile) {

                if (File::exists(public_path($existingFile->files))) {
                    File::delete(public_path($existingFile->files));
                }

                $existingFile->delete();
            }

            foreach ($request->file('files') as $file) {
                $ext = $file->getClientOriginalExtension();
                $fileName = 'document-' . rand() . '.' . $ext;
                $file->move(public_path('uploads'), $fileName);

                $document->files()->create([
                    'files' => 'uploads/' . $fileName,
                ]);
            }
        }

        toastr()->success('Data has been updated successfully!');
        return redirect()->route('user.documents.index');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $document = Documentation::findOrFail($id);

        if ($document->user_id !== Auth::user()->id) {
            toastr()->error('Unauthorized');
            return redirect()->back();
        }

        foreach ($document->files as $existingFile) {

            if (File::exists(public_path($existingFile->files))) {
                File::delete(public_path($existingFile->files));
            }
            $existingFile->delete();
        }

        Documentation::findOrFail($id)->delete();

        toastr()->success('Data has been deleted successfully!');

        return response(['status' => 'success', 'message' => 'Deleted Successfully']);
    }
}
