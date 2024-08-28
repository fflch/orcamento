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
    public static function handle($data)
    {
        return Carbon::createFromFormat('d/m/Y', $data)->format('Y-m-d');
    }

}
