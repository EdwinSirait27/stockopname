{{-- <!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Print Stock Opname - {{ $form_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        h2 {
            margin: 0;
            padding: 0;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 4px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .header td {
            border: none;
            padding: 2px 4px;
        }

        @media print {
            .no-print {
                display: none;
            }

            thead {
                display: table-header-group;
            }

            tfoot {
                display: table-footer-group;
                /* footer hanya muncul di akhir */
            }
        }
    </style>
</head>

<body>

    <div class="no-print">
        <button onclick="window.print()">🖨 Print</button>
        <a href="{{ url()->previous() }}">⬅ Kembali</a>
    </div>

    <table>
        <thead>
            <tr>
                <th colspan="6" style="border:none; background:none; padding:0;">
                    <h2>Stock Opname - {{ $form_number }}</h2>
                    <table class="header" style="width:100%; border:none;">
                        <tr>
                            <td><strong>Tanggal</strong></td>
                            <td>{{ $posopname->date ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Lokasi</strong></td>
                            <td>{{ $posopname->location->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Note</strong></td>
                            <td>{{ $posopname->note ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>User</strong></td>
                            <td>{{ $posopnameitems->first()->user_id ?? '-' }}</td>
                        </tr>
                    </table>
                </th>
            </tr>
            <tr>
                <th>No</th>
                <th>Kode Item</th>
                <th>Barcode</th>
                <th>Nama Item</th>
                <th>Qty Real</th>
                <th>Catatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($posopnameitems as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->item->code ?? '-' }}</td>
                    <td>{{ $item->item->barcode ?? '-' }}</td>
                    <td>{{ $item->item->name ?? '-' }}</td>
                    <td>{{ $item->qty_real }}</td>
                    <td></td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4" style="text-align:right;">TOTAL ITEM</th>
                <th colspan="2">{{ $posopnameitems->count() }}</th>
            </tr>

        </tfoot>

    </table>

</body>

</html> --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Print Stock Opname - {{ $form_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        h2 { margin: 0; padding: 0; }
        table { border-collapse: collapse; width: 100%; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 4px; text-align: left; }
        th { background-color: #f2f2f2; }
        .header-row td { border: none; padding: 2px 4px; background: #fff; }
        @media print {
            .no-print { display: none; }
            thead { display: table-header-group; }
            tfoot { display: table-footer-group; }
        }
    </style>
</head>
<body>

<div class="no-print">
    <button onclick="window.print()">🖨 Print</button>
     <a href="{{ route('pages.showdashboard', ['opname_id' => $posopname->opname_id]) }}"
                                class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back
                            </a>
</div>

<table>
    <thead>
        <tr>
            <th colspan="6" style="background:none;">
                <h2>Stock Opname - {{ $form_number }}</h2>
            </th>
        </tr>
        
        <tr class="header-row">
            <td><strong>Tanggal</strong></td>
            <td>{{ $posopname->date ?? '-' }}</td>
            <td><strong>Lokasi</strong></td>
            <td>{{ $posopname->location->name ?? '-' }}</td>
            <td><strong>User</strong></td>
            <td>{{ $posopnamesublocation->first()->users->name ?? '-' }}</td>
        </tr>
        <tr class="header-row">
            <td><strong>Note</strong></td>
            <td colspan="5">{{ $posopname->note ?? '-' }}</td>
        </tr>
        <br>
        <tr>
            <th>No</th>
            <th>Kode Item</th>
            <th>Barcode</th>
            <th>Nama Item</th>
            <th>Qty Real</th>
            <th>Catatan</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($posopnameitems as $index => $item)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $item->item->code ?? '-' }}</td>
            <td>{{ $item->item->barcode ?? '-' }}</td>
            <td>{{ $item->item->name ?? '-' }}</td>
            <td>{{ $item->qty_real }}</td>
            <td></td>
        </tr>
        @endforeach
    </tbody>

    <tfoot>
        <tr>
            <th colspan="4" style="text-align:right;">TOTAL ITEM</th>
            <th colspan="2">{{ $posopnameitems->count() }}</th>
        </tr>
        {{-- <tr>
            <th colspan="4" style="text-align:right;">TOTAL QTY REAL</th>
            <th>{{ $posopnameitems->sum('qty_real') }}</th>
            <th></th>
        </tr> --}}
    </tfoot>
</table>

</body>
</html>
