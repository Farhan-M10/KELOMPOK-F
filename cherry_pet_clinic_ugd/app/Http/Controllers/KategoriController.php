<?php
namespace App\Http\Controllers;
use App\Models\JenisBarang;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
public function index(Request $request)
{
    // Ambil kategori_id dari query string
    $kategori_id = $request->get('kategori_id');

    // Ambil semua kategori (buat filter & breadcrumb)
    $kategoris = Kategori::all();

    // Query jenis barang
    $jenisBarangs = JenisBarang::with('kategori')
        ->when($kategori_id, function ($query) use ($kategori_id) {
            $query->where('kategori_id', $kategori_id);
        })
        ->paginate(10);

    return view('admin.jenis-barang.index', compact(
        'jenisBarangs',
        'kategoris',
        'kategori_id'
    ));
}
}