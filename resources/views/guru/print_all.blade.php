<!DOCTYPE html>
<html>

<head>
    <title>Print Semua Data Guru</title>
    <style>
        /* CSS styling for the PDF content */
        /* Add your own custom styling here */
        body {
            font-family: Arial, sans-serif;
        }

        h1 {
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th,
        table td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }
    </style>
</head>

<body>
    <h1>Daftar Guru</h1>
    <table>
        <tr>
            <th>NIP</th>
            <th>Nama Guru</th>
            <th>Mata Pelajaran</th>
        </tr>
        @foreach ($guru as $g)
        <tr>
            <td>{{ $g->nip }}</td>
            <td>{{ $g->nama_guru }}</td>
            <td>{{ $g->mapel }}</td>
        </tr>
        @endforeach
    </table>
</body>

</html>