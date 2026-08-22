<?php

namespace App\Support;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

class SpreadsheetFile
{
    public static function download(array $rows, $filename, array $options = [])
    {
        $workbook = new Spreadsheet();
        $sheet = $workbook->getActiveSheet();
        $sheet->setTitle($options['title'] ?? 'sheetname');
        $sheet->fromArray($rows, null, 'A1', true);

        if (! empty($options['font'])) {
            $workbook->getDefaultStyle()->getFont()->setName($options['font']);
        }

        foreach ($options['widths'] ?? [] as $column => $width) {
            $sheet->getColumnDimension($column)->setWidth($width);
        }

        foreach ($options['heights'] ?? [] as $row => $height) {
            $sheet->getRowDimension($row)->setRowHeight($height);
        }

        foreach ($options['wrap'] ?? [] as $column) {
            $sheet->getStyle($column.':'.$column)->getAlignment()->setWrapText(true);
        }

        foreach ($options['center'] ?? [] as $column) {
            $sheet->getStyle($column.':'.$column)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        }

        $downloadName = str_replace(['/', '\\'], '-', $filename).'.xls';

        return response()->streamDownload(function () use ($workbook) {
            (new Xls($workbook))->save('php://output');
            $workbook->disconnectWorksheets();
        }, $downloadName, [
            'Content-Type' => 'application/vnd.ms-excel',
        ]);
    }

    public static function rows($uploadedFile)
    {
        $path = method_exists($uploadedFile, 'getRealPath')
            ? $uploadedFile->getRealPath()
            : $uploadedFile;

        $workbook = IOFactory::load($path);
        $rows = $workbook->getActiveSheet()->toArray(null, true, true, false);
        $workbook->disconnectWorksheets();

        return $rows;
    }
}
