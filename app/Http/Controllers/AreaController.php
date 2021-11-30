<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Illuminate\Http\Request;
use App\Http\Requests\AreaRequest;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('Todos');
        if($request->busca != null){
            $areas = Area::where('nome','LIKE',"%{$request->busca}%")->orderBy('nome','desc')->paginate(10);
        }
        else{
            //$areas = Area::all()->sortBy('nome');
            $areas = Area::orderBy('nome')->paginate(10);
        }        

        return view('areas.index')->with('areas', $areas);
    }

    /**
     * Show the form for creating a new resource.        $area->create($validated);

     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('Todos');
        return view('areas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AreaRequest $request)
    {
        $this->authorize('Todos');
        $validated = $request->validated();
        $validated['user_id'] = \Auth::user()->id;
        Area::create($validated);
        
        $request->session()->flash('alert-success', 'Área cadastrada com sucesso!');
        return redirect()->route('areas.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function show(Area $area)
    {
        $this->authorize('Todos');
        return view('areas.show', compact('area'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function edit(Area $area)
    {
        $this->authorize('Administrador');
        return view('areas.edit', compact('area'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function update(AreaRequest $request, Area $area)
    {
        $this->authorize('Administrador');
        $validated = $request->validated();
        $validated['user_id'] = \Auth::user()->id;
        $area->update($validated);
              
        $request->session()->flash('alert-success', 'Área alterada com sucesso!');
        return redirect()->route('areas.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function destroy(Area $area)
    {
        $this->authorize('Administrador');

        if($area->conta->isNotEmpty()){
            request()->session()->flash('alert-danger',"Área não pode ser excluída, 
            pois existem Contas cadastradas nela.");
            return redirect("/areas");    
        }

        $area->delete();
        return redirect()->route('areas.index')->with('alert-success', 'Área deletada com sucesso!');
    }
}