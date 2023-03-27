<?php

namespace App\Http\Controllers;

use App\Models\Plante;
use Illuminate\Http\Request;
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
        $plante=Plante::create($request->all());
        return response()->json([
            'status'=>'success',
            'message'=>'Plante created succesfully',
            'plante'=>$plante
        ],201);    
    }
    public function show(Plante $plante){
        //get id from the route
        $plante=Plante::find($plante->id);
        //check if not success
        if(!$plante){
            return response()->json(['status'=>'error','message'=>'Plante not found'],404);
        }
        return response()->json([
            'status'=>'success',
            'message'=>'Plante found succesfully',
            'plante'=>$plante],200);
    }
    public function edit(Request $request){
        //
        //get id from the route
        $plante=Plante::find($request->id);
        //check if not success
        if(!$plante){
            return response()->json(['status'=>'error','message'=>'Plante not found'],404);
        }
        return response()->json([
            'status'=>'success',
            'message'=>'Plante found succesfully',
            'plante'=>$plante],200);
    }
    public function update(UpdatePlanteRequest $request, Plante $plante){
        //
        $plante->update($request->all());
        
        //check if the article is updated
        if($plante->wasChanged()){
            return response()->json([
                'status'=>'success',
                'message'=>'Plante updated succesfully',
                'plante'=>$plante],200);
        }
    }
    public function destroy(Plante $plante)
    {
        //
        $plante->delete();
        //check if not success
        if(!$plante){
            return response()->json(['status'=>'error','message'=>'Plante not found'],404);
        }
        return response()->json([
            'status'=>'success',
            'message'=>'Plante deleted succesfully'],200);

    }
}
