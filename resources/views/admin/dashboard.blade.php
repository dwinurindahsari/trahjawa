<x-app-layout>
    <style>
        .border-start-primary {
            border-left: 4px solid #00b067 !important; /* Warna Primary Bootstrap */
            border-top: none !important;
            border-right: none !important;
            border-bottom: none !important;
        }
        .border-start-secondary {
            border-left: 4px solid #FFD700 !important; /* Warna Primary Bootstrap */
            border-top: none !important;
            border-right: none !important;
            border-bottom: none !important;
        }
        .border-start-tertiary {
            border-left: 4px solid #0077C8 !important; /* Warna Primary Bootstrap */
            border-top: none !important;
            border-right: none !important;
            border-bottom: none !important;
        }
        
    </style>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight sm:mx-5 md:mx-0">
            {{-- {{ __('Dashboard Admin') }} --}}
            {{ __('Dashboard ' . ucfirst(auth()->user()->role)) }}
        </h2>
    </x-slot>
    
    <x-notify::notify />

    <div class="container-fluid p-0 h-5">
        <img src="{{ asset('img/wayang-bg.png') }}" alt="Wayang Background" class="img-fluid" style="width: 100%; height: 5.5rem; object-fit: cover; filter: brightness(80%);">
    </div>
    

    <div class="container-fluid my-3">
        <div class="row d-flex justify-center gap-x-16">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-start-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-success text-capitalize mb-1">
                                    <h2 class="fw-semibold fs-5">
                                        Total User
                                    </h2>
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalUsers }} User</div>
                            </div>
                            <div class="col-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#dddfeb" class="bi bi-people-fill" viewBox="0 0 16 16">
                                    <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5.784 6A2.24 2.24 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.3 6.3 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1zM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5"/>
                                  </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-start-secondary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-warning text-capitalize mb-1">
                                    <h2 class="fw-semibold fs-6">
                                        Jumlah Silsilah Keluarga
                                    </h2>
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalFamilyTrees }} Family Tree</div>
                            </div>
                            <div class="col-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#dddfeb" class="bi bi-diagram-3-fill" viewBox="0 0 16 12">
                                    <path fill-rule="evenodd" d="M6 3.5A1.5 1.5 0 0 1 7.5 2h1A1.5 1.5 0 0 1 10 3.5v1A1.5 1.5 0 0 1 8.5 6v1H14a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-1 0V8h-5v.5a.5.5 0 0 1-1 0V8h-5v.5a.5.5 0 0 1-1 0v-1A.5.5 0 0 1 2 7h5.5V6A1.5 1.5 0 0 1 6 4.5zm-6 8A1.5 1.5 0 0 1 1.5 10h1A1.5 1.5 0 0 1 4 11.5v1A1.5 1.5 0 0 1 2.5 14h-1A1.5 1.5 0 0 1 0 12.5zm6 0A1.5 1.5 0 0 1 7.5 10h1a1.5 1.5 0 0 1 1.5 1.5v1A1.5 1.5 0 0 1 8.5 14h-1A1.5 1.5 0 0 1 6 12.5zm6 0a1.5 1.5 0 0 1 1.5-1.5h1a1.5 1.5 0 0 1 1.5 1.5v1a1.5 1.5 0 0 1-1.5 1.5h-1a1.5 1.5 0 0 1-1.5-1.5z"/>
                                  </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-start-tertiary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-primary text-capitalize mb-1">
                                    <h2 class="fw-semibold fs-6">
                                        Jumlah Silsilah Keluarga
                                    </h2>
                                </div>
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">50%</div>
                                    </div>
                                    <div class="col">
                                        <div class="progress progress-sm mr-2">
                                            <div class="progress-bar bg-info" role="progressbar"
                                                style="width: 50%" aria-valuenow="50" aria-valuemin="0"
                                                aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="container-fluid md:my-3 d-flex justify-content-center">
        <input type="text" class="form-input rounded-lg border-green-700 col-sm-12 col-md-10 ">
    </div>

    <div class="overflow-x-auto mt-3 mx-36 bg-[#ffffff] p-5 rounded-md">
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
            @foreach ($familyTrees as $tree)
            {{-- @foreach(auth()->user()->role === 'admin' ? $familyTrees : $UserfamilyTrees as $tree) --}}
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
    {{-- <div class="container mx-28">
    </div> --}}
</x-app-layout>

{{-- todo
-   dahsboard
-   filter data
-   search bar
-   pagination

--}}


