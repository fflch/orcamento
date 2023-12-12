<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use League\Csv\Reader;
use App\Models\TipoConta;
use App\Models\Conta;
use App\Models\ContaUsuario;
use App\Models\DotOrcamentaria;
use App\Models\Nota;
use App\Models\Movimento;
use App\Models\FicOrcamentaria;
use App\Models\Lancamento;
use Carbon\Carbon;
use DB;

class ImportData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'importdata {path}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import data from olde system';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $path = $this->argument('path');

        // Importação da tabela tipo conta
        // 1. Ler o arquivo csv
        $tipo_conta = Reader::createFromPath( $path . '/tipocontas.csv', 'r');
        $tipo_conta->setHeaderOffset(0);
        $records_tipo_conta = $tipo_conta->getRecords();

        // 2. Varrer cada linha do arquivo csv
        foreach($records_tipo_conta as $row){
            $new = new TipoConta;

            if(!empty($row['DHMODIFICACAO'])){
                $date = explode('.',$row['DHMODIFICACAO'])[0];
            } else {
                $date = now();
            }

            $new->id = $row['CODIGO'];
            $new->descricao = $row['DESCRICAO'];
            $new->cpfo = $row['FICHAORCAMENTARIA'] == 'S'? 1:0 ;
            $new->user_id = 1;
            $new->created_at = $date;
            $new->updated_at = $date;
            $new->save();
      
        }
        
        $conta = Reader::createFromPath( $path . '/contas.csv', 'r');
        $conta->setHeaderOffset(0);
        $records_conta = $conta->getRecords();

        foreach($records_conta as $row){
            $new = new Conta;

            if(!empty($row['DHMODIFICACAO'])){
                $date = explode('.',$row['DHMODIFICACAO'])[0];
            } else {
                $date = now();
            }

            $new->id = $row['CODIGO'];
            $new->tipoconta_id = $row['CODIGOTIPOCONTA'];
            $new->nome = $row['DESCRICAO'];
            $new->email = $row['EMAIL'];
            $new->numero = $row['NUMERO'] == '1'? 1:0;
            $new->ativo = $row['ATIVO'] == 'S'? 1:0;
            $new->user_id = 1;
            $new->created_at = $date;
            $new->updated_at = $date;
            $new->save();
              
        }

        $notas = Reader::createFromPath( $path . '/descriobservacoes.csv', 'r');
        $notas->setHeaderOffset(0);
        $records_notas = $notas->getRecords();

        foreach($records_notas as $row){
            $new = new Nota;

            if(!empty($row['DHMODIFICACAO'])){
                $date = explode('.',$row['DHMODIFICACAO'])[0];
            } else {
                $date = now();
            }

            $new->id = $row['CODIGO'];
            $new->tipo = 'Descrição';
            $new->texto = $row['DESCRICAO'];
            $new->user_id = 1;
            $new->created_at = $date;
            $new->updated_at = $date;
            $new->save();
              
        }

        $dotacao = Reader::createFromPath( $path . '/dotacao.csv', 'r');
        $dotacao->setHeaderOffset(0);
        $records_dotacao = $dotacao->getRecords();

        foreach($records_dotacao as $row){
            $new = new DotOrcamentaria;

            if(!empty($row['DHMODIFICACAO'])){
                $date = explode('.',$row['DHMODIFICACAO'])[0];
            } else {
                $date = now();
            }

            $new->id = $row['CODIGO'];
            $new->dotacao = $row['DOTACAO'];
            $new->grupo = $row['GRUPO'];
            $new->descricaogrupo = $row['DESCRICAOGRUPO'];
            $new->item = $row['ITEM'];
            $new->descricaoitem = $row['DESCRICAOITEM'];
            $new->receita = $row['RECEITA'] == 'S'? 1:0;
            $new->ativo = 1;
            $new->user_id = 1;
            $new->created_at = $date;
            $new->updated_at = $date;
            $new->save();
              
        }

        $movimento = Reader::createFromPath( $path . '/movimento.csv', 'r');
        $movimento->setHeaderOffset(0);
        $records_movimento = $movimento->getRecords();

        foreach($records_movimento as $row){
            $new = new Movimento;

            if(!empty($row['DHMODIFICACAO'])){
                $date = explode('.',$row['DHMODIFICACAO'])[0];
            } else {
                $date = now();
            }

            $new->id = $row['CODIGO'];
            $new->ano = $row['ANO'];
            $new->ativo = $row['ATIVO'] == 'S'? 1:0;
            $new->user_id = 1;
            $new->created_at = $date;
            $new->updated_at = $date;
            $new->save();
              
        }

        $fic_orcamentaria = Reader::createFromPath( $path . '/fichaorcamentaria.csv', 'r');
        $fic_orcamentaria->setHeaderOffset(0);
        $records_fic_orcamentaria = $fic_orcamentaria->getRecords();

        foreach($records_fic_orcamentaria as $row){
            $new = new FicOrcamentaria;

            if(!empty($row['DHMODIFICACAO'])){
                $date = explode('.',$row['DHMODIFICACAO'])[0];
            } else {
                $date = now();
            }

            $new->id = $row['CODIGO'];
            $new->movimento_id = $row['CODIGOMOVIMENTO'];
            $new->dotacao_id = $row['CODIGODOTACAO'];
            $new->data = $row['DATA'];
            $new->empenho = (int)$row['NEMPENHO'];
            $new->descricao = $row['DESCRICAO'];
            $new->debito = (float)$row['DEBITO'];
            $new->credito = (float)$row['CREDITO'];
            $new->saldo = (float)$row['SALDO'];
            $new->observacao = $row['OBSERVACAO'];
            $new->user_id = 1;
            $new->created_at = $date;
            $new->updated_at = $date;
            $new->save();
              
        }
        
        $lancamento = Reader::createFromPath( $path . '/lancamentos.csv', 'r');
        $lancamento->setHeaderOffset(0);
        $records_lancamento = $lancamento->getRecords();

        foreach($records_lancamento as $row){
            $new = new Lancamento;

            if(!empty($row['DHMODIFICACAO'])){
                $date = explode('.',$row['DHMODIFICACAO'])[0];
            } else {
                $date = now();                
            }
            
            $new->id = $row['CODIGO'];
            $new->movimento_id = $row['CODIGOMOVIMENTO'];
            if(!empty($row['CODIGOORCAMENTO'])){
            $new->ficorcamentaria_id = intval($row['CODIGOORCAMENTO']);
            }
            $new->grupo = $row['GRUPO'];
            $new->receita = $row['RECEITA']== 'S'? 1:0;
            $new->data = $row['DATA'];
            $new->empenho = intval($row['NEMPENHO']);
            $new->descricao = $row['DESCRICAO'];
            $new->debito = (float)$row['DEBITO'];
            $new->credito = (float)$row['CREDITO'];
            $new->saldo = (float)$row['SALDO'];
            $new->estornado = $row['ESTORNADO']== 'S'? 1:0;
            $new->observacao = $row['OBSERVACAO'];
            $new->user_id = 1;
            $new->created_at = $date;
            $new->updated_at = $date;
            $new->save();
      
            DB::table('conta_lancamento')->insert([
            'lancamento_id' => $row['CODIGO'],
            'conta_id' => $row['CODIGOCONTA'],
            'percentual' => 100,
            'created_at' => $date,
            'updated_at' => $date
            ]);
      
        }   
        
        return 0;
    }
}
