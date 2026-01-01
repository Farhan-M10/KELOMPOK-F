<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\JenisBarang;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SupplierController extends Controller
{
    protected $whatsappService;

    public function __construct(WhatsAppService $whatsappService)
    {
        $this->whatsappService = $whatsappService;
    }

    public function index(Request $request)
    {
        $query = Supplier::with(['jenisBarang.kategori']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_supplier', 'like', "%{$search}%")
                  ->orWhere('nib', 'like', "%{$search}%")
                  ->orWhere('kontak', 'like', "%{$search}%")
                  ->orWhere('alamat', 'like', "%{$search}%");
            });
        }

        if ($request->filled('jenis_barang_id')) {
            $query->where('jenis_barang_id', $request->jenis_barang_id);
        }

        $suppliers = $query->latest()->paginate(10);
        $jenisBarangs = JenisBarang::with('kategori')->get();

        return view('admin.suppliers.index', compact('suppliers', 'jenisBarangs'));
    }

    public function create()
    {
        $jenisBarangs = JenisBarang::with('kategori')
            ->orderBy('kategori_id')
            ->orderBy('nama_jenis')
            ->get();

        return view('admin.suppliers.create', compact('jenisBarangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_supplier' => 'required|string|max:255',
            'nib' => 'required|string|unique:suppliers,nib',
            'jenis_barang_id' => 'required|exists:jenis_barangs,id',
            'alamat' => 'required|string',
            'kontak' => 'required|string|max:20',
            'status' => 'required|in:aktif,tidak_aktif'
        ]);

        Supplier::create($request->all());

        return redirect()->route('admin.suppliers.index')
            ->with('success', 'Supplier berhasil ditambahkan');
    }

    public function show(Supplier $supplier)
    {
        $supplier->load(['jenisBarang.kategori']);
        return view('admin.suppliers.show', compact('supplier'));
    }

    public function edit(Supplier $supplier)
    {
        $jenisBarangs = JenisBarang::with('kategori')->get();
        return view('admin.suppliers.edit', compact('supplier', 'jenisBarangs'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'nama_supplier' => 'required|string|max:255',
            'nib' => 'required|string|unique:suppliers,nib,' . $supplier->id,
            'jenis_barang_id' => 'required|exists:jenis_barangs,id',
            'alamat' => 'required|string',
            'kontak' => 'required|string|max:20',
            'status' => 'required|in:aktif,tidak_aktif'
        ]);

        $supplier->update($request->all());

        return redirect()->route('admin.suppliers.index')
            ->with('success', 'Supplier berhasil diupdate');
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return redirect()->route('admin.suppliers.index')
            ->with('success', 'Supplier berhasil dihapus');
    }


    public function sendWhatsApp(Request $request, $id)
    {
        $request->validate([
            'template_type' => 'required|in:info,order,payment,reminder'
        ]);

        try {
            $supplier = Supplier::with(['jenisBarang.kategori'])->findOrFail($id);

            $result = $this->whatsappService->sendSupplierNotification(
                $supplier,
                $request->template_type
            );

            return response()->json($result);

        } catch (\Exception $e) {
            Log::error('WhatsApp Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengirim WhatsApp: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Kirim WhatsApp - Custom Message
     */
    public function sendCustomWhatsApp(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|string|min:10'
        ]);

        try {
            $supplier = Supplier::findOrFail($id);

            $result = $this->whatsappService->sendMessage(
                $supplier->kontak,
                $request->message
            );

            return response()->json($result);

        } catch (\Exception $e) {
            Log::error('Custom WhatsApp Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengirim WhatsApp: ' . $e->getMessage()
            ], 500);
        }
    }


    public function checkWhatsAppStatus()
    {
        $result = $this->whatsappService->checkDevice();
        return response()->json($result);
    }
}
