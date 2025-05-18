<x-app-layout>
    <x-notify::notify />

    <div class="flex mt-10">
        <div class="container sm:mx-12 md:mx-28">
            <button data-bs-toggle="modal" data-bs-target="#AddModal" class="bg-[#28a745] text-white px-3 py-2 rounded-md hover:bg-[#971c00] ms15">+ Tambah</button>
            {{-- add modal --}}
            <div class="modal fade" id="AddModal" tabindex="-1" aria-labelledby="AddModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Tambah Data</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Form untuk Simpan ke Laravel -->
                            <form action="{{ route('trees.store') }}" method="POST">
                                @csrf <!-- Token keamanan Laravel -->
                                
                                <div class="mb-3">
                                    <label for="tree_name" class="form-label">Nama Trah</label>
                                    <input type="text" class="form-control" id="tree_name" name="tree_name" required>
                                </div>
            
                                <div class="mb-3">
                                    <label for="description" class="form-label">Deskripsi</label>
                                    <textarea class="form-control" id="description" name="description"></textarea>
                                </div>
            
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    
            <div class="overflow-x-auto mt-3 bg-[#ffffff] p-5 rounded-md">
                <table class="bg-white shadow-md">
                    <thead>
                    <tr class="bg-blue-gray-100 text-gray-700">
                        <th class="py-3 px-4 text-center text-white border" scope="col">No</th>
                        <th class="py-3 px-12 text-center text-white border border-orange-300" scope="col">Nama Trah</th>
                        <th class="py-3 px-8 text-center text-white border border-orange-300" scope="col">Deskripsi</th>
                        <th class="py-3 px-8 text-center text-white border border-orange-300" scope="col">Jumlah Anggota</th>
                        <th class="py-3 px-4 text-center text-white border border-orange-300" scope="col">Aksi</th>
                    </tr>
                    </thead>
                    <tbody class="text-blue-gray-900">
                    @foreach ($trees as $tree)
                    <tr class="border-separate border border-[#CFAD82]">
                        <td class="py-3 px-4 text-center border border-[#CFAD82]">{{ $loop -> iteration }}</td>
                        <td class="py-3 px-4 border border-[#CFAD82] text-center w-60">{{$tree->tree_name}}</td>
                        <td class="py-3 px-4 border border-[#CFAD82] text-center w-80">{{ $tree->description ?? 'data kosong' }}</td>
                        <td class="py-3 px-4 border border-[#CFAD82] text-center">{{ $tree->familyMembers->count() }}</td>
                        <td class="py-3 px-8 border border-[#CFAD82] flex gap-3">
                                <a href="{{ route('trees.show', $tree->id) }}" class="btn btn-primary text-white px-3 py-2 rounded-md hover:bg-blue-600 flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-up-right-square" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M15 2a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1zM0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm5.854 8.803a.5.5 0 1 1-.708-.707L9.243 6H6.475a.5.5 0 1 1 0-1h3.975a.5.5 0 0 1 .5.5v3.975a.5.5 0 1 1-1 0V6.707z"/>
                                    </svg>
                                    {{-- Detail --}}
                                </a>
    
                                <button class="btn btn-warning text-white px-3 py-2 flex items-center gap-2"
                                data-bs-toggle="modal"
                                data-bs-target="#EditModal-{{ $tree->id }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                </svg>
                                {{-- Edit --}}
                                </button>
    
                                <div class="modal fade" id="EditModal-{{ $tree->id }}" tabindex="-1" aria-labelledby="EditModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Data</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('trees.update', $tree->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                            
                                                    <div class="mb-3">
                                                        <label for="tree_name_{{ $tree->id }}" class="form-label">Nama Trah</label>
                                                        <input type="text" class="form-control" id="tree_name_{{ $tree->id }}" name="tree_name" value="{{ $tree->tree_name }}" required>
                                                    </div>
                            
                                                    <div class="mb-3">
                                                        <label for="description_{{ $tree->id }}" class="form-label">Deskripsi</label>
                                                        <textarea class="form-control" id="description_{{ $tree->id }}" name="description">{{ $tree->description }}</textarea>
                                                    </div>
                            
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <button class="bg-red-500 text-white px-3 py-2 rounded-md hover:bg-red-600 flex items-center gap-2" data-bs-toggle="modal"
                                data-bs-target="#deleteModal-{{ $tree->id }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                    <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                </svg>
                                {{-- Delete --}}
                                </button>
    
                                <div class="modal fade" id="deleteModal-{{ $tree->id }}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Konfirmasi Hapus</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Apakah Anda yakin ingin menghapus 
                                                <span class="font-semibold">
                                                    {{ $tree->tree_name }}
                                                </span>?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <form action="{{ route('trees.delete', $tree->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <button class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 flex items-center gap-2"
                                onclick="copyToClipboard({{ $tree->id }})">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-share" viewBox="0 0 16 16">
                                    <path d="M13.5 1a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3M11 2.5a2.5 2.5 0 1 1 .603 1.628l-6.718 3.12a2.5 2.5 0 0 1 0 1.504l6.718 3.12a2.5 2.5 0 1 1-.488.876l-6.718-3.12a2.5 2.5 0 1 1 0-3.256l6.718-3.12A2.5 2.5 0 0 1 11 2.5m-8.5 4a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3m11 5.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3"/>
                                </svg>
                                {{-- Share --}}
                                </button>
                            </td>
                        </tr>
                    </tbody>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    

    <script>
        function copyToClipboard(id) {
            let url = `http://127.0.0.1:8000/detail/${id}`;
    
            navigator.clipboard.writeText(url).then(() => {
                Notify.success("Link berhasil disalin!");
            }).catch(err => {
                Notify.error("Gagal menyalin link.");
            });
        }
    </script>
    
</x-app-layout>
