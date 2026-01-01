<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use App\Models\JenisBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SupplierApiController extends Controller
{
    /**
     * Get all suppliers with filters and pagination
     * GET /api/v1/suppliers
     */
    public function index(Request $request)
    {
        try {
            $query = Supplier::with(['jenisBarang.kategori']);

            // Filter: Search
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('nama_supplier', 'like', "%{$search}%")
                      ->orWhere('nib', 'like', "%{$search}%")
                      ->orWhere('kontak', 'like', "%{$search}%")
                      ->orWhere('alamat', 'like', "%{$search}%");
                });
            }

            // Filter: Jenis Barang
            if ($request->filled('jenis_barang_id')) {
                $query->where('jenis_barang_id', $request->jenis_barang_id);
            }

            // Filter: Status
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            // Filter: Kategori (medis/non-medis)
            if ($request->filled('kategori')) {
                $query->whereHas('jenisBarang.kategori', function($q) use ($request) {
                    $q->where('jenis', $request->kategori);
                });
            }

            // Pagination
            $perPage = $request->get('per_page', 10);
            $suppliers = $query->latest()->paginate($perPage);

            return response()->json([
                'success' => true,
                'message' => 'Data supplier berhasil diambil',
                'data' => $suppliers->items(),
                'pagination' => [
                    'total' => $suppliers->total(),
                    'per_page' => $suppliers->perPage(),
                    'current_page' => $suppliers->currentPage(),
                    'last_page' => $suppliers->lastPage(),
                    'from' => $suppliers->firstItem(),
                    'to' => $suppliers->lastItem(),
                    'next_page_url' => $suppliers->nextPageUrl(),
                    'prev_page_url' => $suppliers->previousPageUrl(),
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data supplier',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get supplier statistics
     * GET /api/v1/suppliers/stats
     */
    public function stats()
    {
        try {
            $stats = [
                'total_supplier' => Supplier::count(),
                'supplier_aktif' => Supplier::where('status', 'aktif')->count(),
                'supplier_tidak_aktif' => Supplier::where('status', 'tidak_aktif')->count(),
                'supplier_medis' => Supplier::whereHas('jenisBarang.kategori', function($q) {
                    $q->where('jenis', 'medis');
                })->count(),
                'supplier_non_medis' => Supplier::whereHas('jenisBarang.kategori', function($q) {
                    $q->where('jenis', 'non-medis');
                })->count(),
                'total_jenis_barang' => JenisBarang::count(),
            ];

            return response()->json([
                'success' => true,
                'message' => 'Statistik supplier berhasil diambil',
                'data' => $stats
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil statistik',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get single supplier detail
     * GET /api/v1/suppliers/{id}
     */
    public function show($id)
    {
        try {
            $supplier = Supplier::with(['jenisBarang.kategori'])->find($id);

            if (!$supplier) {
                return response()->json([
                    'success' => false,
                    'message' => 'Supplier tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Detail supplier berhasil diambil',
                'data' => $supplier
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil detail supplier',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Create new supplier
     * POST /api/v1/suppliers
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_supplier' => 'required|string|max:255',
            'nib' => 'required|string|max:50|unique:suppliers,nib',
            'alamat' => 'required|string',
            'kontak' => 'required|string|max:20',
            'jenis_barang_id' => 'required|exists:jenis_barangs,id',
            'status' => 'required|in:aktif,tidak_aktif'
        ], [
            'nama_supplier.required' => 'Nama supplier wajib diisi',
            'nib.required' => 'NIB wajib diisi',
            'nib.unique' => 'NIB sudah terdaftar',
            'alamat.required' => 'Alamat wajib diisi',
            'kontak.required' => 'Kontak wajib diisi',
            'kontak.max' => 'Kontak maksimal 20 karakter',
            'jenis_barang_id.required' => 'Jenis barang wajib dipilih',
            'jenis_barang_id.exists' => 'Jenis barang tidak valid',
            'status.required' => 'Status wajib dipilih',
            'status.in' => 'Status harus aktif atau tidak_aktif'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $supplier = Supplier::create($request->all());
            $supplier->load(['jenisBarang.kategori']);

            return response()->json([
                'success' => true,
                'message' => 'Supplier berhasil ditambahkan',
                'data' => $supplier
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan supplier',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update supplier
     * PUT/PATCH /api/v1/suppliers/{id}
     */
    public function update(Request $request, $id)
    {
        $supplier = Supplier::find($id);

        if (!$supplier) {
            return response()->json([
                'success' => false,
                'message' => 'Supplier tidak ditemukan'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nama_supplier' => 'required|string|max:255',
            'nib' => 'required|string|max:50|unique:suppliers,nib,' . $id,
            'alamat' => 'required|string',
            'kontak' => 'required|string|max:20',
            'jenis_barang_id' => 'required|exists:jenis_barangs,id',
            'status' => 'required|in:aktif,tidak_aktif'
        ], [
            'nama_supplier.required' => 'Nama supplier wajib diisi',
            'nib.required' => 'NIB wajib diisi',
            'nib.unique' => 'NIB sudah terdaftar',
            'alamat.required' => 'Alamat wajib diisi',
            'kontak.required' => 'Kontak wajib diisi',
            'kontak.max' => 'Kontak maksimal 20 karakter',
            'jenis_barang_id.required' => 'Jenis barang wajib dipilih',
            'jenis_barang_id.exists' => 'Jenis barang tidak valid',
            'status.required' => 'Status wajib dipilih'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $supplier->update($request->all());
            $supplier->load(['jenisBarang.kategori']);

            return response()->json([
                'success' => true,
                'message' => 'Supplier berhasil diupdate',
                'data' => $supplier
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupdate supplier',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete supplier
     * DELETE /api/v1/suppliers/{id}
     */
    public function destroy($id)
    {
        try {
            $supplier = Supplier::find($id);

            if (!$supplier) {
                return response()->json([
                    'success' => false,
                    'message' => 'Supplier tidak ditemukan'
                ], 404);
            }

            $namaSupplier = $supplier->nama_supplier;
            $supplier->delete();

            return response()->json([
                'success' => true,
                'message' => "Supplier {$namaSupplier} berhasil dihapus"
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus supplier',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Bulk delete suppliers
     * POST /api/v1/suppliers/bulk-delete
     */
    public function bulkDelete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ids' => 'required|array',
            'ids.*' => 'exists:suppliers,id'
        ], [
            'ids.required' => 'ID supplier wajib diisi',
            'ids.array' => 'ID harus berupa array',
            'ids.*.exists' => 'Salah satu ID supplier tidak valid'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $count = Supplier::whereIn('id', $request->ids)->delete();

            return response()->json([
                'success' => true,
                'message' => "{$count} supplier berhasil dihapus"
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus supplier',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update supplier status only
     * PATCH /api/v1/suppliers/{id}/status
     */
    public function updateStatus(Request $request, $id)
    {
        $supplier = Supplier::find($id);

        if (!$supplier) {
            return response()->json([
                'success' => false,
                'message' => 'Supplier tidak ditemukan'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'status' => 'required|in:aktif,tidak_aktif'
        ], [
            'status.required' => 'Status wajib diisi',
            'status.in' => 'Status harus aktif atau tidak_aktif'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $supplier->update(['status' => $request->status]);

            return response()->json([
                'success' => true,
                'message' => 'Status supplier berhasil diupdate',
                'data' => [
                    'id' => $supplier->id,
                    'nama_supplier' => $supplier->nama_supplier,
                    'status' => $supplier->status,
                    'updated_at' => $supplier->updated_at
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupdate status',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
