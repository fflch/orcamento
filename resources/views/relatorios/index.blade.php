@extends('master')

@section('title')
    Relatórios
@stop

@section('content')
    @include('messages.flash')
    @include('messages.errors')

<div class="card p-3">
    <h2><strong>Relatórios</strong></h2>
</div>
<br>    
<div class="form-row">
  <div class="form-group col-md-4">
    <!--label-->
      <form method="get" action="/relatorios/balancete">
        @csrf
        <div class="row">
          <div class=" col-sm input-group">
              <input type="text" class="form-control datepicker data" name="data" value="{{ Request()->data ?? old('data') ?? Carbon\Carbon::now()->format('d/m/Y') }}" placeholder="[ Ex: 01/01/2020 ]">
            <span class="input-group-btn">
              <button type="submit" class="btn btn-success"><strong>OK</strong></button>
            </span>
          </div>
        </div>
      </form>
    <!--/label-->
  </div>

  <div class="form-group col-md-4">
    <!--label-->
      <form method="get" action="/relatorios/acompanhmaneto">
        @csrf
        <div class="row">
          <div class=" col-sm input-group">
              <input type="text" class="form-control datepicker data" name="data" value="{{ Request()->data ?? old('data') ?? Carbon\Carbon::now()->format('d/m/Y') }}" placeholder="[ Ex: 01/01/2020 ]">
            <span class="input-group-btn">
              <button type="submit" class="btn btn-success"><strong>OK</strong></button>
            </span>
          </div>
        </div>
      </form>
    <!--/label-->
  </div>
</div>
@stop
