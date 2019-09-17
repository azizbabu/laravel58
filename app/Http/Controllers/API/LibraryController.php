<?php

namespace App\Http\Controllers\API;

use App\Library;
use Illuminate\Http\Request;
use App\Http\Resources\Library as LibraryResource;
use App\Http\Resources\LibraryCollection;
use App\Http\Controllers\Controller;
use Carbon;

class LibraryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $libraries = Library::whereUserId(request()->user()->id)->get();

        return new LibraryCollection($libraries);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $rules = [
            'title'  => 'required|string|max:255',
            'owner'  => 'required|string|max:255',
            'type'  => 'required|integer|min:1',
            'establish_date'  => 'required|date',
        ];

        request()->validate($rules);

        $requestAll = request()->all();
        $requestAll['user_id'] = request()->user()->id;
        $requestAll['establish_date'] = Carbon::parse($requestAll['establish_date'])->format('Y-m-d');
        $library = new Library($requestAll);
        
        if($library->save()) {
            return response()->json([
                'success' => true,
                'message' => 'Library successfully added'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Library not added'
        ]);
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
        $rules = [
            'title'  => 'required|string|max:255',
            'owner'  => 'required|string|max:255',
            'type'  => 'required|integer|min:1',
            'establish_date'  => 'required|date',
        ];

        request()->validate($rules);

        $requestAll = request()->all();
        $requestAll['user_id'] = request()->user()->id;
        $requestAll['establish_date'] = Carbon::parse($requestAll['establish_date'])->format('Y-m-d');
        $library = Library::find($id);
        $library->fill($requestAll);
        $library->save();

        if($library->save()) {
            return response()->json([
                'success' => true,
                'message' => 'Library successfully updated'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Library not updated'
        ]);
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
        
        if($library->delete()) {
            return response()->json([
                'success' => true,
                'message' => 'Library successfully deleted'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Library not deleted'
        ]);
    }
}
