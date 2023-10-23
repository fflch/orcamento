<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Lancamento;

class PercentualRule implements Rule
{
    private $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function passes($attribute, $value)
    {
        $lancamento = Lancamento::where('id', $this->id)->first();
        $lancamento->load('contas');
        $soma = str_replace(',', '.', $value);
        foreach($lancamento->contas as $conta){
            $soma += $conta->pivot->percentual;
            if($soma > 100) return false;
        }
        return true;
    }

    public function message()
    {
        return 'A soma dos percentuais não deve ultrapassar 100.';
    }
}
