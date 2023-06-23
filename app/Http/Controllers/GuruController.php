<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GuruModel;
use Dompdf\Dompdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class GuruController extends Controller
{

    public function __construct()
    {
        $this->GuruModel = new GuruModel();
    }
    public function index()
    {
        $data = [
            'guru' => $this->GuruModel->allData(),
        ];

        return view('guru.index', $data);
    }

    public function detail($id_guru)
    {
        if (!$this->GuruModel->detailData($id_guru)) {
            abort(404);
        }

        $data = [
            'guru' => $this->GuruModel->detailData($id_guru),
        ];

        return view('guru.detail', $data);
    }

    public function add()
    {
        return view('guru.add');
    }

    public function insert()
    {
        //create validation
        Request()->validate([
            'nip' => 'required|unique:tbl_guru|min:4|max:10',
            'nama_guru' => 'required',
            'mapel' => 'required',
            'foto_guru' => 'required|mimes:jpg,png,jpeg|max:1024',
        ], [
            'nip.required' => 'NIP harus diisi',
            'nip.unique' => 'NIP sudah digunakan',
            'nip.min' => 'NIP minimal 4 karakter',
            'nip.max' => 'NIP maksimal 10 karakter',
            'nama_guru.required' => 'Nama guru harus diisi',
            'mapel.required' => 'Mata pelajaran harus diisi',
            'foto_guru.required' => 'Foto harus diisi',
            'foto_guru.mimes' => 'Format foto harus jpg,png,jpeg',
            'foto_guru.max' => 'Ukuran foto maksimal 1MB',
        ]);

        $file = Request()->file('foto_guru');
        $fileName = Request()->nip . '.' . $file->extension();
        $file->move(public_path('foto_guru'), $fileName);

        $data = [
            'nip' => Request()->nip,
            'nama_guru' => Request()->nama_guru,
            'mapel' => Request()->mapel,
            'foto_guru' => $fileName,
        ];

        $this->GuruModel->addData($data);
        return redirect()->route('guru.index')->with('pesan', 'Data berhasil ditambah');
    }

    public function edit($id_guru)
    {
        if (!$this->GuruModel->detailData($id_guru)) {
            abort(404);
        }

        $data = [
            'guru' => $this->GuruModel->detailData($id_guru),
        ];

        return view('guru.edit', $data);
    }

    public function update($id_guru)
    {
        //create validation
        Request()->validate([
            'nip' => 'required|min:4|max:10',
            'nama_guru' => 'required',
            'mapel' => 'required',
            'foto_guru' => 'mimes:jpg,png,jpeg|max:1024',
        ], [
            'nip.required' => 'NIP harus diisi',
            'nip.min' => 'NIP minimal 4 karakter',
            'nip.max' => 'NIP maksimal 10 karakter',
            'nama_guru.required' => 'Nama guru harus diisi',
            'mapel.required' => 'Mata pelajaran harus diisi',
        ]);

        if (Request()->foto_guru <> "") {

            //delete foto
            $guru = $this->GuruModel->detailData($id_guru);
            if ($guru->foto_guru <> "") {
                unlink(public_path('foto_guru') . '/' . $guru->foto_guru);
            }
            //ganti foto
            $file = Request()->file('foto_guru');
            $fileName = Request()->nip . '.' . $file->extension();
            $file->move(public_path('foto_guru'), $fileName);

            $data = [
                'nip' => Request()->nip,
                'nama_guru' => Request()->nama_guru,
                'mapel' => Request()->mapel,
                'foto_guru' => $fileName,
            ];

            $this->GuruModel->editData($data, $id_guru);
        } else {

            //tidak ganti foto
            $data = [
                'nip' => Request()->nip,
                'nama_guru' => Request()->nama_guru,
                'mapel' => Request()->mapel,
            ];

            $this->GuruModel->editData($data, $id_guru);
        }

        return redirect()->route('guru.index')->with('pesan', 'Data berhasil di Update');
    }

    public function delete($id_guru)
    {
        //delete foto
        $guru = $this->GuruModel->detailData($id_guru);
        if ($guru->foto_guru <> "") {
            unlink(public_path('foto_guru') . '/' . $guru->foto_guru);
        }

        //hapus data
        $this->GuruModel->deleteData($id_guru);

        return redirect()->route('guru.index')->with('pesan', 'Data berhasil di Hapus');
    }

    public function printAllPDF()
    {
        $data = [
            'guru' => $this->GuruModel->allData(),
        ];

        // Generate HTML content for PDF
        $html = view('guru.print_all', $data)->render();

        // Instantiate Dompdf class
        $dompdf = new Dompdf();

        // Load HTML content
        $dompdf->loadHtml($html);

        // (Optional) Set paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // Render HTML to PDF
        $dompdf->render();

        // Output PDF to browser for download
        $dompdf->stream('guru_all.pdf', ['Attachment' => false]);
    }

    public function printAllExcel()
    {
        $data = [
            'guru' => $this->GuruModel->allData(),
        ];

        // Create a new Spreadsheet instance
        $spreadsheet = new Spreadsheet();

        // Get the active sheet in the spreadsheet
        $sheet = $spreadsheet->getActiveSheet();

        // Set the column headers
        $sheet->setCellValue('A1', 'NIP');
        $sheet->setCellValue('B1', 'Nama Guru');
        $sheet->setCellValue('C1', 'Mata Pelajaran');
        $sheet->setCellValue('D1', 'Foto Guru');

        // Add data to the spreadsheet
        $row = 2;
        foreach ($data['guru'] as $guru) {
            $sheet->setCellValue('A' . $row, $guru->nip);
            $sheet->setCellValue('B' . $row, $guru->nama_guru);
            $sheet->setCellValue('C' . $row, $guru->mapel);
            $sheet->setCellValue('D' . $row, $guru->foto_guru);
            $row++;
        }

        // Create a new Excel file writer
        $writer = new Xlsx($spreadsheet);

        // Set the file name and save the spreadsheet to a file
        $filename = 'guru_all.xlsx';
        $writer->save($filename);

        // Set the appropriate headers for Excel file download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        // Output the file to the browser
        $writer->save('php://output');
    }
}
