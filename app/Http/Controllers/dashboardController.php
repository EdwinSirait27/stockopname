<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

use App\Models\Mtokosoglo;
use App\Models\Buttons;
use App\Models\Mtokodetsoglo;
use Illuminate\Support\Facades\Log;
class dashboardController extends Controller
{
    public function index(){
        
       $buttons = Buttons::where('url', '/')->first();

    if (!$buttons || !$buttons->start_date || !$buttons->end_date) {
        return view('pages.error');
    }

    $start_date = Carbon::parse($buttons->start_date);
    $end_date = Carbon::parse($buttons->end_date);

    if (Carbon::now()->between($start_date, $end_date)) {
        return view('pages.dashboard');
    }

    return view('pages.error');
}
    // public function index(){

    //     return view('pages.dashboard');
    // }

    public function getMtokosoglo(Request $request)
    {
        $query = Mtokosoglo::select(['kdtoko', 'kettoko', 'personil', 'inpmasuk']);

        // Jika ada input search, filter di sini
        if ($search = $request->input('search.value')) {
            $query->where(function ($q) use ($search) {
                $q->where('kdtoko', 'like', "%{$search}%")
                    ->orWhere('kettoko', 'like', "%{$search}%")
                    ->orWhere('personil', 'like', "%{$search}%");
            });
        }

        return DataTables::of($query)
            ->addColumn('action', function ($mtokosoglo) {
                return '
                <a href="' . route('pages.editdashboard', $mtokosoglo->kdtoko) . '" class="btn btn-sm btn-outline-primary mx-1" data-bs-toggle="tooltip" title="Edit mtokosoglo: ' . e($mtokosoglo->kdtoko) . '">
                    <i class="fas fa-user-edit"></i> Edit
                </a>
                <a href="' . route('pages.showdashboard', $mtokosoglo->kdtoko) . '" class="btn btn-sm btn-outline-info mx-1" data-bs-toggle="tooltip" title="Show mtokosoglo: ' . e($mtokosoglo->kdtoko) . '">
                    <i class="fas fa-eye"></i> Show
                </a>
            ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    // public function getMtokodetsoglo()
    // {
    //     $mtokodetsoglos = Mtokodetsoglo::select(['KDTOKO', 'BARA', 'NOURUT', 'FISIK','BARCODE','ID'])
    //         ->get()
    //         ->map(function ($mtokodetsoglo) {
    //             $mtokodetsoglo->action = '

    //              <button type="submit" class="btn btn-sm btn-outline-secondary mx-1" data-bs-toggle="tooltip" title="Scan mtokodetsoglo: {{ e($mtokodetsoglo->KDTOKO) }}">
    //     Scan
    // </button>
    //             ';
    //             return $mtokodetsoglo;
    //         });
    //     return DataTables::of($mtokodetsoglos)
    //         ->rawColumns(['action'])
    //         ->make(true);
    // }
    public function getMtokodetsoglo(Request $request)
    {
        $query = Mtokodetsoglo::select(['KDTOKO', 'BARA', 'NOURUT', 'FISIK', 'BARCODE', 'ID']);
        // Jika ada input search, filter di sini
        if ($search = $request->input('search.value')) {
            $query->where(function ($q) use ($search) {
                $q->where('KDTOKO', 'like', "%{$search}%")
                    ->orWhere('BARA', 'like', "%{$search}%")
                    ->orWhere('NOURUT', 'like', "%{$search}%")
                    ->orWhere('FISIK', 'like', "%{$search}%")
                    ->orWhere('BARCODE', 'like', "%{$search}%")
                    ->orWhere('ID', 'like', "%{$search}%");
            });
        }
        return DataTables::of($query)
            ->addColumn('action', function ($mtokodetsoglo) {
                return '
                 <button type="submit" class="btn btn-sm btn-outline-secondary mx-1" data-bs-toggle="tooltip" title="Scan mtokodetsoglo: {{ e($mtokodetsoglo->KDTOKO) }}">Edit Scan</button>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    public function edit($kdtoko)
    {
        Log::info('Masuk ke method editRole', ['kdtoko' => $kdtoko]);
        $mtokosoglo = Mtokosoglo::find($kdtoko);
        if (!$mtokosoglo) {
            Log::warning('Data tidak ditemukan di method edit', ['kdtoko' => $kdtoko]);
            abort(404, 'Data not found.');
        }
        $userName = Auth::user()->name;
        return view('pages.editdashboard', compact('mtokosoglo', 'kdtoko', 'userName'));
    }
    public function show($kdtoko)
    {
        Log::info('Masuk ke method editRole', ['kdtoko' => $kdtoko]);
        $mtokosoglo = Mtokosoglo::find($kdtoko);
        if (!$mtokosoglo) {
            Log::warning('Data tidak ditemukan di method show', ['kdtoko' => $kdtoko]);
            abort(404, 'Data not found.');
        }
        return view('pages.showdashboard', compact('mtokosoglo', 'kdtoko'));
    }
    public function update(Request $request, $kdtoko)
    {
        Log::info('Masuk ke method update', ['kdtoko' => $kdtoko]);
        // Validasi data input
        $validated = $request->validate([
            'kdtoko' => 'required|string|max:255',
            'kettoko' => 'required|string|max:255',
            'personil' => 'required|string|max:255',
            // tambahkan field lainnya sesuai kebutuhan tabel mtokosoglo
        ]);
        // Cari data berdasarkan primary key kdtoko
        $mtokosoglo = Mtokosoglo::find($kdtoko);
        if (!$mtokosoglo) {
            Log::warning('Data tidak ditemukan di method update', ['kdtoko' => $kdtoko]);
            abort(404, 'Data not found.');
        }
        $validated['inpmasuk'] = Auth::user()->name;
        // Update sekaligus
        $mtokosoglo->update($validated);
        // return view('pages.dashboard', [
        //     'success' => 'Data berhasil diperbarui.',
        // ]);
        return redirect()->route('dashboard')->with('success', 'Data berhasil diperbarui.');
    }

}

// public function getMtokosoglo()
// {
//     $mtokosoglos = Mtokosoglo::select(['kdtoko', 'kettoko', 'personil', 'inpmasuk',])
//         ->get()
//         ->map(function ($mtokosoglo) {
//             $mtokosoglo->action = '
//             <a href="' . route('pages.editdashboard', $mtokosoglo->kdtoko) . '" class="mx-3" data-bs-toggle="tooltip" data-bs-original-title="Edit mtokosoglo" title="Edit mtokosoglo: ' . e($mtokosoglo->kdtoko) . '">
//                 <i class="fas fa-user-edit text-secondary"></i>
//             </a>
//             <a href="' . route('pages.showdashboard', $mtokosoglo->kdtoko) . '" class="mx-3" data-bs-toggle="tooltip" data-bs-original-title="Edit mtokosoglo" title="Show mtokosoglo: ' . e($mtokosoglo->kdtoko) . '">
//                 <i class="fas fa-user-edit text-dark"></i>
//             </a>
//              <button type="submit" class="btn btn-sm btn-outline-secondary mx-1" data-bs-toggle="tooltip" title="Edit mtokosoglo: {{ e($mtokosoglo->kdtoko) }}">
//     Edit
// </button>
//             ';
//             return $mtokosoglo;
//         });
//     return DataTables::of($mtokosoglos)
//         ->rawColumns(['action'])
//         ->make(true);
// }
//     public function getMtokosoglo()
// {
//     // Jangan gunakan ->get() dulu, biarkan DataTables yang handle query
//     $query = Mtokosoglo::select(['kdtoko', 'kettoko', 'personil', 'inpmasuk']);

//     return DataTables::of($query)
//         ->addColumn('action', function ($mtokosoglo) {
//             return '
//                 <a href="' . route('pages.editdashboard', $mtokosoglo->kdtoko) . '" class="btn btn-sm btn-outline-primary mx-1" data-bs-toggle="tooltip" title="Edit mtokosoglo: ' . e($mtokosoglo->kdtoko) . '">
//                     <i class="fas fa-user-edit"></i> Edit
//                 </a>
//                 <a href="' . route('pages.showdashboard', $mtokosoglo->kdtoko) . '" class="btn btn-sm btn-outline-info mx-1" data-bs-toggle="tooltip" title="Show mtokosoglo: ' . e($mtokosoglo->kdtoko) . '">
//                     <i class="fas fa-eye"></i> Show
//                 </a>
//             ';
//         })
//         ->rawColumns(['action'])
//         ->make(true);
// }