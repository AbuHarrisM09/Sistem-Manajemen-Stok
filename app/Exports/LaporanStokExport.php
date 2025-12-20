<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Carbon\Carbon;

class LaporanStokExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths, WithTitle, ShouldAutoSize
{
    protected $transaksis;
    protected $title;

    public function __construct($transaksis, $title = 'Laporan Stok')
    {
        $this->transaksis = $transaksis;
        $this->title = $title;
    }

    public function collection()
    {
        return $this->transaksis->map(function ($transaksi, $index) {
            return [
                'no' => $index + 1,
                'tanggal' => Carbon::parse($transaksi->tanggal)->format('d-m-Y'),
                'nama_bahan' => $transaksi->bahan->nama_bahan ?? '-',
                'jenis_transaksi' => ucfirst($transaksi->jenis_transaksi),
                'jumlah' => $transaksi->jumlah_bahan,
                'satuan' => $transaksi->bahan->satuan ?? '-',
                'pegawai' => $transaksi->pengguna->nama ?? '-',
                'keterangan' => $transaksi->keterangan ?? '-',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No',
            'Tanggal',
            'Nama Bahan',
            'Jenis Transaksi',
            'Jumlah',
            'Satuan',
            'Pegawai',
            'Keterangan',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Style untuk header
        $sheet->getStyle('A1:H1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 12,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '0D6EFD'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ]);

        // Style untuk seluruh data
        $lastRow = $this->transaksis->count() + 1;
        $sheet->getStyle('A2:H' . $lastRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'CCCCCC'],
                ],
            ],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Alignment untuk kolom tertentu
        $sheet->getStyle('A2:A' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('B2:B' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('D2:D' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('E2:E' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

        // Set row height untuk header
        $sheet->getRowDimension(1)->setRowHeight(25);

        return [];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 8,   // No
            'B' => 15,  // Tanggal
            'C' => 25,  // Nama Bahan
            'D' => 18,  // Jenis Transaksi
            'E' => 12,  // Jumlah
            'F' => 12,  // Satuan
            'G' => 20,  // Pegawai
            'H' => 30,  // Keterangan
        ];
    }

    public function title(): string
    {
        return $this->title;
    }
}