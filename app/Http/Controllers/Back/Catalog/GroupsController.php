<?php

namespace App\Http\Controllers\Back\Catalog;

use App\Http\Controllers\Controller;
use App\Models\Back\Catalog\Groups\Groups;

use Illuminate\Http\Request;

class GroupsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('search') && ! empty($request->search)) {
            $groups = Groups::query()->groupBy('group')->paginate(12);
        } else {
            $groups = Groups::query()->paginate(12);
        }

        return view('back.catalog.groups.index', compact('groups'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('back.catalog.groups.edit');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $groups = new Groups();

        $stored = $groups->validateRequest($request)->create();

        if ($stored) {
            return redirect()->route('groups.edit', ['groups' => $stored])->with(['success' => 'Attribute was succesfully saved!']);
        }

        return redirect()->back()->with(['error' => 'Whoops..! There was an error saving the attribute.']);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param Author $author
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Groups $groups)
    {
        //dd($attributes->toArray());
        return view('back.catalog.groups.edit', compact('groups'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Groups               $attributes
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Groups $groups)
    {
        $updated = $groups->validateRequest($request)->edit();

        if ($updated) {
            return redirect()->route('groups.edit', ['groups' => $groups->id])->with(['success' => 'groups was succesfully saved!']);
        }

        return redirect()->back()->with(['error' => 'Whoops..! There was an error saving the attribute.']);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Groups $groups)
    {
        $for_d     = Groups::query()->where('group', $groups->group)->pluck('id');
        $destroyed = Groups::query()->where('group', $groups->group)->delete();

        if ($destroyed) {
            AttributesTranslation::query()->whereIn('attribute_id', $for_d)->delete();

            return redirect()->route('groups')->with(['success' => 'Attribute was succesfully deleted!']);
        }

        return redirect()->back()->with(['error' => 'Whoops..! There was an error deleting the attribute .']);
    }
}
