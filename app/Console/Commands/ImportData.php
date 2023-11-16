<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use League\Csv\Reader;
use App\Models\TipoConta;

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
        $tipo_conta = Reader::createFromPath( $path . '/tipo_conta.csv', 'r');
        $tipo_conta->setHeaderOffset(0);
        $records_tipo_conta = $tipo_conta->getRecords();

        // 2. Varrer cada linha do arquivo csv
        foreach($records_tipo_conta as $row){
            $new = new TipoConta;

            if(!empty($row['DHMODIFICACAO'])){
                $date = explode('.',$row['DHMODIFICACAO'])[0];
            } else {
                $date = now();
                dd($date);
            }

            

            $new->id = $row['CODIGO'];
            $new->descricao = $row['DESCRICAO'];
            $new->cpfo = $row['FICHAORCAMENTARIA'] == 'S'? 1:0 ;
            $new->user_id = 1;
            $new->created_at = $date;
            $new->updated_at = $date;
            $new->save();
              
        }

         // Importação da tabela conta
         // flavias works...

        return 0;
    }
}
