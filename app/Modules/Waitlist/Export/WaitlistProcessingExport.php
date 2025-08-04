<?php

namespace App\Modules\Waitlist\Export;

use Maatwebsite\Excel\Concerns\{Exportable,WithEvents,FromView,ShouldAutoSize};
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Contracts\View\View;

class WaitlistProcessingExport implements FromView, ShouldAutoSize, WithEvents
{
    protected $data;
    
    // protected $ts_count = 0;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function view(): View
    {
        $data = $this->data;
        return view('Waitlist::export.export_processing', compact('data'));
    }

    public function registerEvents(): array
    {

    	return [
    		AfterSheet::class    => function(AfterSheet $event)  {
                $head_count = count($this->data);;//10;
                $total_row = 1;//count($this->data);
    			$event->sheet->getDelegate()->getRowDimension(1)->setRowHeight(25);
                $styleArray1 = [
                    'alignment' => [
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                        'wraptext' => true
                    ],
                ];
                
                $total_application_row = [
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,

                    ],
                    'font' => [
                            'family' => 'Open Sans',
                            'size' =>  11,
                            'bold' => true,
                        ],
                        'background' => [
                        'color'=> '#CCCCCC'
                    ]
                ];

                $aligh_right = [
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                    'font' => [
                            'family' => 'Open Sans',
                            'size' =>  11,
                            'bold' => true,
                        ]
                ];

                $align_center = [
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                        'wraptext' => true
                    ],
                    
                ];

               
    			$styleArray = [
                    'font' => [
                        'family' => 'Open Sans',
                        'size' =>  11,
                        'bold' => false,
                        ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                        'wraptext' => true
                    ],
                ];
                $to = $event->sheet->getDelegate()->getHighestColumn();
                // $toC = $event->sheet->getDelegate()->getHighestRow();
                $sheet = $event->sheet->getDelegate();
               // $sheet->setAutoSize(true);              
                $sheet->getStyle('B2:'.$to.$head_count)->applyFromArray($styleArray);
                $sheet->getStyle('A1:'.$to.$total_row)->applyFromArray($total_application_row);
                // $sheet->getStyle('A'.$total_row.':D'.($total_row+1))->applyFromArray($total_application_row);
                // $sheet->getStyle('A'.($total_row+2).':A'.($total_row+2))->applyFromArray($aligh_right);
                // $sheet->getStyle('B'.($total_row+2).':D'.($total_row+2))->applyFromArray($align_center);
                // $sheet->getRowDimension(2)->setRowHeight(60);
                //  $sheet->getStyle('B'.($total_row+3).':D'.($total_row+3))->applyFromArray($align_center);
                //   $sheet->getStyle('B4:V'.($total_row+3))->applyFromArray($align_center);
    		}
         ];
    }

}
