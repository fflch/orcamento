<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\FicOrcamentaria;
use App\Models\Lancamento;

class ValorRule implements Rule
{
    private $ficorcamentaria_id;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($ficorcamentaria_id)
    {
        $this->ficorcamentaria_id = $ficorcamentaria_id;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $ficorcamentaria = FicOrcamentaria::find($this->ficorcamentaria_id);
        $lancamentos = Lancamento::where('ficorcamentaria_id', $this->ficorcamentaria_id)->get();

        if($ficorcamentaria->credito != 0){
            $soma = array_sum($lancamentos->pluck('credito')->toArray());
        }
        if($ficorcamentaria->debito != 0){
            $soma = array_sum($lancamentos->pluck('debito')->toArray());
        }

        $soma = $soma + str_replace(',', '.', $value);

        if($ficorcamentaria->credito != 0 && $soma > $ficorcamentaria->credito){
            return false;
        }
        elseif($ficorcamentaria->debito != 0 && $soma > $ficorcamentaria->debito){
            return false;
        }
            
        return true;

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'O valor deve ser menor ou igual ao cadastrado na Ficha Orçamentária';
    }
}
