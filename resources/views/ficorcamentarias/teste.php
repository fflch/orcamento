<input list="contas_{{ $tipocontaid_quantidades_key }}_{{ $i }}" name="conta_id[]" id="conta_id_{{ $tipocontaid_quantidades_key }}_{{ $i }}" class="form-control" value="{{ $lancamento->conta_id ?? old('conta_id') }}">
                    <datalist id="contas_{{ $tipocontaid_quantidades_key }}_{{ $i }}">
                        @foreach($tipocontaid_descricaoconta as $tipocontaid_descricaoconta_key=>$tipocontaid_descricaoconta_value)
                            @foreach($lista_contas_ativas as $lista_conta)
                                @if(($tipocontaid_quantidades_key == $lista_conta->tipoconta_id) and ($tipocontaid_descricaoconta_key == $lista_conta->tipoconta_id))
                                    <option value="{{ $lista_conta->id }}">{{ $lista_conta->nome }}</option>
                                @endif
                            @endforeach
                        @endforeach
                    </datalist>