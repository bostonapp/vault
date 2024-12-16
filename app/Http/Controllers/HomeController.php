<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Documentation;
use App\Models\User;

class HomeController extends Controller
{

    public function index(){
        return view('Home');
    }


    public function PublicDocument(Request $request)
    {
        $search = $request->search;

        $categorysearch = $request->category_id;

        $usersearch = $request->user;

        $query = Documentation::query();

        if ($search) {

            $query->where(function ($query) use ($search) {

                $query->whereHas('user', function ($query) use ($search) {

                    $query->where('name', 'LIKE', "%{$search}%");

                })->orWhere('topic', 'LIKE', "%{$search}%")
                ->orWhere('category', 'LIKE', "%{$search}%")
                ->orWhere('source', 'LIKE', "%{$search}%")
                ->orWhere('description', 'LIKE', "%{$search}%")
                ->orWhere('status', 'LIKE', "%{$search}%");
            });

        }

        if ($categorysearch) {
            $query->where('category_id', 'LIKE', "%{$categorysearch}%");
        }

    

        if($usersearch){
            $query->where('user_id', 'LIKE', "%{$usersearch}%");
        }

        $alldocuments = $query->where('status', 'public')->where('is_approved', 'approved')->latest()->paginate(5);

        $categories = Category::has('documentations')->get();

        $SearchByuser = User::whereHas('documentations', function($query){
            $query->where('status', 'public ')->where('is_approved', 'approved');
        })->get();

        return view('PublicDocument', compact('alldocuments', 'search', 'categories', 'categorysearch', 'SearchByuser', 'usersearch'));
    }



    public function PublicDocumentDetail(string $id)
    {
        $item = Documentation::with('files')->findOrFail($id);


        if ($item->status === 'private' || $item->status === 'public' && $item->is_approved === 'pending') {
            toastr()->error('Unauthorized');
            return redirect()->back();
        }


        return view('PublicDocumentDetail', compact('item'));
    }

}
