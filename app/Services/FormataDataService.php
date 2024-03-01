<?php

namespace App\Services;

use Carbon\Carbon;

class FormataDataService
{
    /**
     * Register services.
     *
     * @return void
     */
    public function handle($data)
    {
        $data = Carbon::createFromFormat('d/m/Y', $data)->format('Y-m-d');

        return $data;
    }

}
