<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cities = City::all();
        //echo $cities;
        return response()->view('cms.cities.index',['cities'=>$cities]);
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return response()->view('cms.cities.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name_en'=>'required|string|min:3|max:100',
            'name_ar'=>'required|string|min:3|max:100',
            'active'=>'nullable|in:on'
        ],[
            'name_en.min'=>'Please, city name must be at least 3 characters',
            'name_en.required'=>'You must Enter city name',
        ]);
        $city = new City();
        $city->name_en = $request->input('name_en');
        $city->name_ar = $request->input('name_ar');
        $city->active = $request->has('active');
        $isSaved = $city->save();
        if($isSaved){
            session()->flash('message','City created successfully');
            return redirect()->back();
        }
        // dd($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(City $city)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(City $city)
    {
        //
        return response()->view('cms.cities.edit',['city' => $city]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, City $city)
    {
        //
        //dd($request->all());
        $request->validate([
            'name_en'=>'required|string|min:3',
            'name_ar'=>'required|string|min:3',
            'active'=>'nullable|in:on',
        ]);
        $city->name_en=$request->input('name_en');
        $city->name_ar=$request->input('name_ar');
        $city->active=$request->has('active');
        $isSaved=$city->save();
        if($isSaved){
            return redirect()->route('cities.index');
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(City $city)
    {
        //
        $isDeleted = $city->delete();
        if($isDeleted){
            return redirect()->route('cities.index');
        }
    }
}
