<?php

namespace App\Helpers;

use Carbon\Carbon;

class ExcelHelper extends \Maatwebsite\Excel\Files\NewExcelFile
{

    public function getFilename()
    {
        $data = new Carbon('now');
        return 'export_' . $data->format('d_m_Y-H_i');
    }
}
