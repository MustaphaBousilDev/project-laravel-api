<?php

namespace App\Http\Controllers;

use App\Models\Plante;
use App\Http\Requests\StorePlanteRequest;
use App\Http\Requests\UpdatePlanteRequest;

class PlanteController extends Controller{
    //construct 
    public function __construct(){
        $this->middleware('auth:api');
    }
    /////////////////////////////////////////////////////////////////////////////////////
    public function index(){
        //
        $plants=Plante::with('category')->get();
        return response()->json(['status'=>'success','plants'=>$plants]);
    }
    public function store(StorePlanteRequest $request){
        //
        $this->authorize('create', Plante::class);
        $validated = $request->validated();
        $plante = Plante::create($validated);
        return response()->json([
            'message' => 'Plant created successfully',
            'plant' => $plante
        ]);
    }
    public function show(Plante $plante){
        //
        //find article 
        
        $plante=Plante::with('category')->find($plante->id);
        if(!$plante){
            return response()->json(['status'=>'error','message'=>'Plante not found'],404);
        }
        return response()->json(['status'=>'success','plante'=>$plante],200);
    }
    public function edit(Plante $plante){
        //
    }
    public function update(UpdatePlanteRequest $request, Plante $plante){
        //
        $this->authorize('update', $plante);
        $validated=$request->validated();
        //update 
        $plante->update($validated);
        return response()->json([
            'message'=>'success',
            'plant'=>$plante
        ]);
        
    }
    public function destroy(Plante $plante)
    {
        //
        $this->authorize('delete', $plante);
        //dd($plante);
        $plante->delete();
        return response()->json([
            'message' => 'Plant deleted successfully',
            'plante' => $plante
        ]);
    }
}
