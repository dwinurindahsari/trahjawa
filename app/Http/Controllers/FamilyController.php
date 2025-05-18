<?php

namespace App\Http\Controllers;

use App\Models\FamilyMember;
use App\Models\FamilyTree;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class FamilyController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'tree_id' => 'required',
            'name' => 'required|string|max:50',
            'birth_date' => 'nullable|date',
            'gender' => 'required|string|in:Laki-Laki,Perempuan',
            'address' => 'nullable|string|max:60',
            'parent_id' => 'nullable|exists:family_members,id',
            'photo' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'urutan' => 'required|integer',
            // Validasi untuk partner (hanya jika checkbox dicentang)
            'partner_name' => $request->has('has-partner-checkbox') ? 'required|string|max:50' : 'nullable',
            'partner_birth_date' => $request->has('has-partner-checkbox') ? 'nullable|date' : 'nullable',
            'partner_gender' => 'nullable',
            'partner_address' => $request->has('has-partner-checkbox') ? 'nullable|string|max:60' : 'nullable',
            'partner_photo' => $request->has('has-partner-checkbox') ? 'nullable|image|mimes:jpg,png,jpeg|max:2048' : 'nullable',
        ]);

        // Simpan gambar anggota keluarga jika ada
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos/family_photos', 'public');
        }

        // Simpan gambar partner jika ada
        $partnerPhotoPath = null;
        if ($request->hasFile('partner_photo')) {
            $partnerPhotoPath = $request->file('partner_photo')->store('photos/partner_photos', 'public');
        }

        // Tentukan partner_gender berdasarkan kebalikan gender yang diinput
        $partnerGender = null;
        if ($request->has('has-partner-checkbox')) {
            $partnerGender = ($request->gender === 'Laki-Laki') ? 'Perempuan' : 'Laki-Laki';
        }

        // Buat record baru
        $data = [
            'tree_id' => $request->tree_id,
            'name' => $request->name,
            'birth_date' => $request->birth_date,
            'gender' => $request->gender,
            'address' => $request->address,
            'parent_id' => $request->parent_id,
            'photo' => $photoPath,
            'urutan' => $request->urutan,
            'partner_name' => $request->has('has-partner-checkbox') ? $request->partner_name : null,
            'partner_birth_date' => $request->has('has-partner-checkbox') ? $request->partner_birth_date : null,
            'partner_gender' => $partnerGender, // Diisi otomatis
            'partner_address' => $request->has('has-partner-checkbox') ? $request->partner_address : null,
            'partner_photo' => $partnerPhotoPath,
        ];

        FamilyMember::create($data);

        notify()->success('Data Berhasil Ditambahkan', 'Data Added');
        return redirect()->back()->with('success', 'Data berhasil disimpan!');
    }

    public function edit($id) {
        $member = FamilyMember::findOrFail($id);
        return view('family_members.edit', compact('member'));
    }
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:50',
            'birth_date' => 'nullable|date',
            'gender' => 'required|string|in:Laki-Laki,Perempuan',
            'address' => 'nullable|string|max:100',
            'photo' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'urutan' => 'required|integer',
            'partner_name' => $request->has('has-partner-checkbox') ? 'required|string|max:50' : 'nullable',
            'partner_birth_date' => $request->has('has-partner-checkbox') ? 'required|date' : 'nullable',
            'partner_gender' => $request->has('has-partner-checkbox') ? 'required|string|in:Laki-Laki,Perempuan' : 'nullable',
            'partner_address' => $request->has('has-partner-checkbox') ? 'nullable|string|max:100' : 'nullable',
            'partner_photo' => $request->has('has-partner-checkbox') ? 'nullable|image|mimes:jpg,png,jpeg|max:2048' : 'nullable',
        ]);

        $member = FamilyMember::findOrFail($id);

        // Handle foto anggota keluarga
        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($member->photo) {
                Storage::delete('public/' . $member->photo);
            }
            // Simpan foto baru
            $photoPath = $request->file('photo')->store('photos/family_photos', 'public');
        } else {
            $photoPath = $member->photo;
        }

        // Handle foto pasangan
        $partnerPhotoPath = $member->partner_photo; // Default: gunakan foto lama
        if ($request->hasFile('partner_photo')) {
            // Hapus foto lama jika ada
            if ($member->partner_photo) {
                Storage::delete('public/' . $member->partner_photo);
            }
            // Simpan foto baru
            $partnerPhotoPath = $request->file('partner_photo')->store('photos/partner_photos', 'public');
        }

        // Update data anggota keluarga
        $member->update([
            'name' => $request->name,
            'birth_date' => $request->birth_date,
            'gender' => $request->gender,
            'address' => $request->address,
            'parent_id' => $request->parent_id,
            'photo' => $photoPath,
            'urutan' => $request->urutan,
            'partner_name' => $request->has('has-partner-checkbox') ? $request->partner_name : null,
            'partner_birth_date' => $request->has('has-partner-checkbox') ? $request->partner_birth_date : null,
            'partner_gender' => $request->has('has-partner-checkbox') ? $request->partner_gender : null,
            'partner_address' => $request->has('has-partner-checkbox') ? $request->partner_address : null,
            'partner_photo' => $partnerPhotoPath,
        ]);

        // Notifikasi sukses
        notify()->success('Data Berhasil Diupdate', 'Update Data');
        return redirect()->back()->with('success', 'Data berhasil diperbarui!');
    }
    public function destroy($id) {
        $member = FamilyMember::findOrFail($id);
        $member->delete();
    
        notify()->success('Data Berhasil Dihapus', 'Delete Data');
        return redirect()->back()->with('success', 'Anggota keluarga berhasil dihapus!');
    }

    public function showFamilyTree($tree_id)
    {
        // Cari tree berdasarkan ID
        $tree = FamilyTree::find($tree_id);

        // Jika tree tidak ditemukan, tampilkan error 404
        if (!$tree) {
            abort(404, 'Tree not found');
        }

        // Ambil semua anggota keluarga yang tidak memiliki parent (root) dan terkait dengan tree_id
        $rootMembers = FamilyMember::where('tree_id', $tree_id)
            ->whereNull('parent_id')
            ->with('children')
            ->get();

        // Kirim data ke view
        return view('family-tree', compact('rootMembers', 'tree'));
    }
}
