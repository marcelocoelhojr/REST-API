<?php

namespace App\Traits;

use App\Models\Logs;

trait LogsTrait
{

    public function saveLog(...$param) {
        $log = [
            'message' =>  $param[0],
            'line' => $param[1],
            'code' => $param[2],
            'file' => $param[3]
        ];
        $saveLog = new Logs();
        $saveLog->insert($log);
    }

}