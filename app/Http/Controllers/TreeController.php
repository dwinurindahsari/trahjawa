<?php

namespace App\Http\Controllers;
use App\Models\FamilyMember;
use App\Http\Controllers\LogicController;
use App\Models\FamilyTree;
use App\Models\User;
use Illuminate\Http\Request;

class TreeController extends Controller
{
    public function index()
    {
        // done guard for admin and user
        $totalUsers = User::count();
        $totalFamilyTrees = FamilyTree::count();
        $users = User::pluck('name');
        $namaUser = auth()->user()->name;
        $userRole = auth()->user()->role;

        if ($userRole === 'Admin') {
            $familyTrees = FamilyTree::all();
            notify()->success('Welcome Back Admin', 'Hello 😎');
        } else {
            $familyTrees = FamilyTree::where('created_by', $namaUser)->get();
            // notify()->success('Welcome Back ' . $namaUser, 'Hello 😊');
        }

        return view('admin.dashboard', compact('totalUsers', 'users', 'totalFamilyTrees', 'familyTrees', 'namaUser', 'userRole'));
    }
    public function data()
    {
        // done guard for admin and user
        $namaUser = auth()->user()->name;
        $userRole = auth()->user()->role;

        if ($userRole === 'Admin') {
            $trees = FamilyTree::all();
            notify()->success('Welcome Back Admin', 'Hello 😎');
        } else {
            $trees = FamilyTree::where('created_by', $namaUser)->get();
            notify()->success('Welcome Back ' . $namaUser, 'Hello 😊');
        }
        return view('admin.data', compact('trees', 'namaUser'));
    }

    public function store(Request $request)
    {
        $namaUser = auth()->user()->name;
        $request->validate([
            'tree_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $tree = FamilyTree::create([
            'tree_name' => $request->tree_name,
            'description' => $request->description,
            'created_by' => $namaUser,
        ]);

        notify()->success('Data Berhasil Ditambahkan','Create Data ');
        return redirect()->route('data', ['id' => $tree->id]);
    }

    public function edit($tree_id)
    {
        $tree = FamilyTree::findOrFail($tree_id);
        return view('edit-tree', compact('tree'));
    }

    public function delete($tree_id)
    {
        $tree = FamilyTree::findOrFail($tree_id);
        $tree->delete();
        notify()->success('Data Berhasil Dihapus', 'Delete Data');
        return redirect()->back()->with('success');
    }

    public function update(Request $request, $tree_id)
    {
        
        $tree = FamilyTree::findOrFail($tree_id);
        $tree->update([
            'tree_name' => $request->tree_name,
            'description' => $request->description,
        ]);
        notify()->success('Data Berhasil Diupdate','Update Data');
        return redirect()->route('data');
    }

    public function detail($id, Request $request)
    {
        $tree = FamilyTree::with('familyMembers')->findOrFail($id);
        $members = $tree->familyMembers;
        $tree_id = $id;
        $rootMembers = $members->whereNull('parent_id');
    
        $person1 = null;
        $person2 = null;
        $relationshipDetails = null;
        $relationshipDetailsReversed = null;
    
        if ($request->has('compare') && $request->filled(['name1', 'name2'])) {
            $person1 = FamilyMember::where('name', $request->name1)->where('tree_id', $tree_id)->first();
            $person2 = FamilyMember::where('name', $request->name2)->where('tree_id', $tree_id)->first();
    
            if ($person1 && $person2) {
                $dfs = new \App\Http\Controllers\LogicController;


                //arah person1 -> person2
                $visited = [];
                $path = [];
                $found = $dfs->dfs($person1, $person2->id, $visited, $path);
                $relationshipDetails = $found
                    ? $dfs->relationshipPath($path, $person1->name, $person2->name)
                    : 'Tidak ada hubungan yang ditemukan.';

                
                //reversed
                $visitedRev = [];
                $pathRev = [];
                $foundRev = $dfs->dfs($person2, $person1->id, $visitedRev, $pathRev);
                $relationshipDetailsReversed = $foundRev
                    ? $dfs->relationshipPath($pathRev, $person2->name, $person1->name)
                    : 'Tidak ada hubungan yang ditemukan.';
            }
        }
    
        return view('admin.detail', compact(
            'tree', 'members', 'tree_id', 'rootMembers',
            'person1', 'person2', 'relationshipDetails', 'relationshipDetailsReversed'
        ));
    
    }


    public function secure(){
        $namaUser = auth()->user()->name;
        $userRole = auth()->user()->role;

        if ($userRole === 'Admin') {
            notify()->success('Welcome Back Admin', 'Hello 😎');
            return view('admin.secure');
        } else {
            notify()->success('Gagal', 'Anda tidak memiliki akses ini');
            return redirect()->back()->with('success');
        }   
    }

    public function notFound()
    {
        return response()->view('errors.404', [], 404);
    }
}
