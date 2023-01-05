<?php

namespace App\Exports;

use App\Models\Stock;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithEvents;

class StockExport implements FromCollection, WithMapping, WithColumnFormatting, ShouldAutoSize, WithHeadings, WithStyles, WithEvents
{
    public $stockItems;

    public function __construct($stockItems)
    {
        $this->stockItems = $stockItems;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Stock::whereIn('id', $this->stockItems)->get();
    }

    public function headings(): array
    {
        return [
            'NO',
            'PRODUCT NAME',
            'BATCH NUMBER',
            'PURCHASED QUANTITY',
            'SOLD QUANTITY',
            'QUANTITY',
            'COST',
            'PRICE',
            'EXPIRY DATE'
        ];
    }

    /**
     * @var Stock $stockItem
     */
    public function map($stockItem): array
    {
        return [
            $stockItem->id,
            $stockItem->product->name,
            $stockItem->batch_number,
            $stockItem->purchased_quantity,
            $stockItem->sold_quantity,
            $stockItem->available_quantity,
            $stockItem->purchase_price,
            $stockItem->selling_price,
            Date::dateTimeToExcel(Carbon::parse($stockItem->expiry_date)),
        ];
    }

    public function columnFormats(): array
    {
        return [
            'I' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],

            /* // Styling a specific cell by coordinate.
            'B2' => ['font' => ['italic' => true]],

            // Styling an entire column.
            'C'  => ['font' => ['size' => 16]], */
        ];
    }

    /* public function registerEvents(): array
    {
        $alphabetRange = range('A', 'Z');
        $alphabet = $alphabetRange[$this->totalValue + 6]; // returns Alphabet

        $totalRow = (count($this->attributeSets) * 3) + count($this->allItems) + 1;
        $cellRange = 'A1:' . $alphabet . $totalRow;

        return [
            AfterSheet::class => function (AfterSheet $event) use ($cellRange) {
                $event->sheet->getStyle($cellRange)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ])->getAlignment()->setWrapText(true);
            },
        ];
    } */
}
