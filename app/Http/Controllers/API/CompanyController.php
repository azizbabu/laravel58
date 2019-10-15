<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Requests\API\Companies\{ Store, Update, Destroy };
use App\Http\Controllers\Controller;
use App\Company;
use App\Http\Resources\Company as CompanyResource;
use App\Http\Resources\CompanyCollection;
use Illuminate\Support\Str;
use Carbon;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private function getCompanies()
    {
        return Company::whereUserId(request()->user()->id)->latest()->paginate(10);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = $this->getCompanies();

        return new CompanyCollection($companies);
        // return response()->json($companies);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\API\Companies\Store  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Store  $request)
    {
        $requestAll = request()->all();
        $requestAll['user_id'] = request()->user()->id;
        $requestAll['establish_date'] = Carbon::parse($requestAll['establish_date'])->format('Y-m-d');
        $requestAll['logo'] = $this->uploadFile($request);

        $company = new Company($requestAll);
        
        if($company->save()) {          
            return response()->json([
                'success' => true,
                'message' => 'Company successfully added'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Company not added'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\API\Companies\Update  $request
     * @param  \App\Company $company
     * @return \Illuminate\Http\Response
     */
    public function update(Update  $request, Company $company)
    {
        $requestAll = $request->all();
        $requestAll['establish_date'] = Carbon::parse($requestAll['establish_date'])->format('Y-m-d');
        $requestAll['logo'] = $this->uploadFile($request, $company);

        $company->fill($requestAll);
        
        if($company->save()) {
            return response()->json([
                'success' => true,
                'message' => 'Company successfully updated'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Company not updated'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Http\Requests\API\Companies\Destroy  $request
     * @param  int  \App\Company $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Destroy  $request, Company $company)
    {
        if($company->delete()) {
            return response()->json([
                'success' => true,
                'message' => 'Company successfully deleted'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Company not deleted'
        ]);
    }

     /**
     * Upload image to specific folder and return file name.
     *
     * @param  \Illuminate\Http\Request $request
     * @param object $model
     * @return string $imageName 
     */
    private function uploadFile($request, $model = null) 
    {
        try {
            $destinationPath = 'uploads/';
                
            if(!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            if($request->hasFile('logo')) {
                if($model && $model->logo) {
                    $filePath = $destinationPath . $model->logo;

                    if(file_exists($filePath)) {
                        File::delete($filePath);
                    }
                }
                $image = $request->logo;
                $name = (string) Str::uuid() . '.' . $image->extension();
                
                $image->move($destinationPath, $name);

                return $name;
            }else {
                if($model && $model->logo) {
                    return $model->logo;
                }
            }

            return null;
        } catch (\Exception $ex) {
            return null;
        }
    }
}
