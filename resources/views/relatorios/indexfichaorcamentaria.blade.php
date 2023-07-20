<div class="form-group col-md-6 p-3">
    <div class="card p-3">
        <h3><strong>Ficha Orçamentária</strong></h3>
    </div>
    <br> 
    <form method="get" action="/relatorios/ficha_orcamentaria">
        @csrf
        <div class="form-row">
            <div class="form-group col-md-12">
                <select class="dotacoes_select form-control" name="dotacao_id" tabindex="1">
                        <option value=" ">[ Informe a Dotação ]</option>
                        @foreach($lista_dotorcamentarias as $lista_dotorcamentaria)
                            <option value="{{ $lista_dotorcamentaria->id }}" @if(old('dotacao_id') == $lista_dotorcamentaria->id) {{ 'selected' }} @endif>
                            {{ $lista_dotorcamentaria->dotacao }}
                            </option>
                        @endforeach
        </select>

            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <input type="text" class="form-control datepicker data" name="data_inicial" value="01/01/{{ session('ano') }}" placeholder="[ Ex: 01/01/2020 ]">
            </div>
            <div class="form-group col-md-6">        
                <input type="text" class="form-control datepicker data" name="data_final" value="31/12/{{ session('ano') }}" placeholder="[ Ex: 01/01/2020 ]">
            </div>
        </div>        
        <div class="form-row">
            <div class="form-group col-md-12">        
                <input list="descricoes" name="descricao" id="descricao" class="form-control" value="{{ $lancamento->descricao ?? old('descricao') }}" placeholder="[ Informe a Descrição ]">
                <datalist id="descricoes">
                    @foreach($lista_descricoes as $lista_descricao)
                        <option value="{{ $lista_descricao->texto }}">{{ $lista_descricao->texto }}
                    @endforeach
                </datalist>
            </div>
        </div>        
        <div class="form-row">
            <div class="form-group col-md-11">          
                <input list="observacoes" name="observacao" id="observacao" class="form-control" value="{{ $lancamento->observacao ?? old('observacao') }}" placeholder="[ Informe a Observação ]">
                <datalist id="observacoes">
                @foreach($lista_observacoes as $lista_observacao)
                <option value="{{ $lista_observacao->texto }}">{{ $lista_observacao->texto }}
                @endforeach
                </datalist>
            </div>   
            <div class="form-group col-md-1" align="right">      
                <span class="input-group-btn">
                <button type="submit" class="btn btn-success"><strong>OK</strong></button>
                </span>
            </div>
        </div>
    </form>
</div>
