<?php

namespace App\Http\Controllers;

use App\Library;
use Illuminate\Http\Request;
use App\Http\Resource\Library as LibraryResource;
use App\Http\Resource\LibraryCollection;

class LibraryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $libraries = Library::all()->toArray();

        // return response()->json($libraries);
        // $libraries = Library::whereUserId(request()->user()->id)->get();
        dd(\Auth::user());
        // return new LibraryCollection($libraries);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        dd($request->all());
        $library = new Library(request()->all());
        $library->save();

        return response()->json('Library successfully added');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $library = Library::find($id);
        return response()->json($library);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $library = Library::find($id);
        $library->fill($request->all());
        $library->save();

        return response()->json('The library successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $library = Library::find($id);
        $library->delete();

        return response()->json('The library successfully deleted');
    }
}
