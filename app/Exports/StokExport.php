<?php

namespace App\Exports;

use App\Models\TransaksiStok;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Carbon\Carbon;

class StokExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths
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
        return $this->transaksis;
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
            'Keterangan'
        ];
    }

    public function map($transaksi): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            Carbon::parse($transaksi->tanggal)->format('d-m-Y'),
            $transaksi->bahan->nama_bahan ?? '-',
            ucfirst($transaksi->jenis_transaksi),
            $transaksi->jumlah_bahan,
            $transaksi->bahan->satuan ?? '-',
            $transaksi->pengguna->nama ?? '-',
            $transaksi->keterangan ?? '-'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Style untuk header
        $sheet->getStyle('A1:H1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 12
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '0d6efd']
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ]
        ]);

        // Style untuk semua data
        $lastRow = $this->transaksis->count() + 1;
        $sheet->getStyle('A1:H' . $lastRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'CCCCCC']
                ]
            ]
        ]);

        // Alignment untuk kolom tertentu
        $sheet->getStyle('A2:A' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('E2:E' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

        // Set tinggi baris header
        $sheet->getRowDimension(1)->setRowHeight(25);

        return [];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 8,  // No
            'B' => 15, // Tanggal
            'C' => 30, // Nama Bahan
            'D' => 18, // Jenis Transaksi
            'E' => 12, // Jumlah
            'F' => 12, // Satuan
            'G' => 25, // Pegawai
            'H' => 35, // Keterangan
        ];
    }
}