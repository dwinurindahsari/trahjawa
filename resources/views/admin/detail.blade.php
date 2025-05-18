<x-app-layout>
    <x-slot name="header" style="background-color: #">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight sm:mx-5 md:mx-0">
            {{ __('Detail') }}
        </h2>
    </x-slot>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
        * {
            padding: 0px;
            margin: 0px;
            box-sizing: border-box;
        }
        body {
            align-items: center;
            font-family: 'Poppins', sans-serif;
            overflow: visible;
        }
        .tree {
            height: auto;
            text-align: center;
            overflow-x: auto;
            white-space: nowrap; /* Mencegah konten untuk turun ke baris berikutnya */
            width: 100%;
        }
        .tree ul {
            padding-top: 20px;
            position: relative;
            transition: .5s;
        }
        .tree li {
            display: inline-table;
            text-align: center;
            list-style-type: none;
            position: relative;
            padding: 10px;
            transition: .5s;
        }
        .tree li::before, .tree li::after {
            content: '';
            position: absolute;
            top: 0;
            right: 50%;
            border-top: 1px solid #ccc;
            width: 51%;
            height: 10px;
        }
        .tree li::after {
            right: auto;
            left: 50%;
            border-left: 1px solid #ccc;
        }
        .tree li:only-child::after, .tree li:only-child::before {
            display: none;
        }
        .tree li:only-child {
            padding-top: 0;
        }
        .tree li:first-child::before, .tree li:last-child::after {
            border: 0 none;
        }
        .tree li:last-child::before {
            border-right: 1px solid #ccc;
            border-radius: 0 5px 0 0;
            -webkit-border-radius: 0 5px 0 0;
            -moz-border-radius: 0 5px 0 0;
        }
        .tree li:first-child::after {
            border-radius: 5px 0 0 0;
            -webkit-border-radius: 5px 0 0 0;
            -moz-border-radius: 5px 0 0 0;
        }
        .tree ul ul::before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            border-left: 1px solid #ccc;
            width: 0;
            height: 20px;
        }
        .tree li a {
            background: whitesmoke;
            border: 1px solid #00963c;
            padding: 10px;
            display: inline-grid;
            border-radius: 5px;
            text-decoration-line: none;
            border-radius: 5px;
            transition: .5s;
        }
        .tree li a img {
            width: 50px;
            height: 50px;
            margin-bottom: 10px !important;
            border-radius: 100px;
            margin: auto;
        }
        .tree li a span {
            border: 1px solid #ccc;
            border-radius: 5px;
            color: #666;
            padding: 8px;
            font-size: 12px;
            text-transform: capitalize;
            letter-spacing: 1px;
            font-weight: 500;
        }
        /*Hover-Section*/
        .tree li a:hover, .tree li a:hover i, .tree li a:hover span, .tree li a:hover+ul li a {
            background: #c8e4f8;
            color: #000;
            border: 1px solid #94a0b4;
        }
        .tree li a:hover+ul li::after, .tree li a:hover+ul li::before, .tree li a:hover+ul::before, .tree li a:hover+ul ul::before {
            border-color: #94a0b4;
        }

        .nav-link {
            color: #000; /* Warna teks default */
            background-color: transparent; /* Latar belakang default */
        }
        
        .active{
            background: transparent !important ;
            color: green !important ;
            font-weight: 800 !important;
            text-decoration: none !important;
        }

       .nav-link:hover {
            color: #007bff; /* Warna teks ketika hover */
            background-color: rgba(0, 123, 255, 0.1); /* Latar belakang ketika hover */
        }
        table{
            color: #000;
            font-weight: 200;
        }

        .wrap-text {
            white-space: normal; 
            word-wrap: break-word;
            max-width: 200px; 
        }

        .container {
            max-width: 100%; 
            overflow: hidden; 
            padding: 16px; 
        }

        #tab2-nav-item {
        display: none; /* Sembunyikan tab navigation secara default */
        }

        #tab2 {
            visibility: hidden; /* Sembunyikan konten Tab 2 tanpa memengaruhi tata letak */
            height: 0; /* Hilangkan tinggi */
            overflow: hidden; /* Pastikan konten tidak meluber */
            transition: visibility 0.3s, height 0.3s; /* Animasi transisi */
        }

        #tab2.active {
            visibility: visible; /* Tampilkan konten Tab 2 */
            height: auto; /* Kembalikan tinggi ke ukuran asli */
        }
       
    </style>

    @if(session('success'))
        <x-notify::notify />
    @endif

    

    <div class="flex mt-10">
        <div class="container sm:mx-12 md:mx-28">
            {{-- Button Add --}}
            <button data-bs-toggle="modal" data-bs-target="#AddModal" class="bg-[#28a745] text-white px-3 py-2 rounded-md hover:bg-[#971c00] ms15">Tambah</button>

            {{-- Modal Input --}}
            <div class="modal fade" id="AddModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Data Anggota Keluarga</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Data Pribadi</button>
                            </li>
                            <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Data Pasangan</button>
                            </li>
                        </ul>
                        <form action="{{ route('family.store') }}" method="POST" enctype="multipart/form-data" class="mt-3">
                            @csrf
                            <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
                                {{-- form data diri pribadi --}}
                                <input type="hidden" class="form-control" id="tree_id" name="tree_id" value="{{ $tree->id }}" required>
                                                
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                
                                <div class="mb-3">
                                    <label for="parent_id" class="form-label">Pilih Orang Tua</label>
                                    <select class="form-control" id="parent_id" name="parent_id">
                                        <option value="" selected>Belum Diketahui</option>
                                        @foreach ($tree->familyMembers as $member)
                                            <option value="{{ $member->id }}" {{ isset($familyMember) && $familyMember->parent_id == $member->id ? 'selected' : '' }}>
                                                {{ $member->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                
                                <div class="mb-3"> 
                                    <div class="flex items-center mb-4">
                                        <input id="has-partner-checkbox" name="has-partner-checkbox" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500" onchange="toggleTab2()">
                                        <label for="has-partner-checkbox" class="ms-2 text-sm font-normal">Memiliki Pasangan</label>
                                    </div>
                                </div>
                                
                
                                <div class="mb-3">
                                    <label for="urutan" class="form-label">Anak Ke</label>
                                    <select class="form-select" id="urutan" name="urutan" required>
                                        <option value="" disabled selected>Anak Ke</option>
                                        <option value="1">Pertama</option>
                                        <option value="2">Kedua</option>
                                        <option value="3">Ketiga</option>
                                        <option value="4">Keempat</option>
                                        <option value="5">Kelima</option>
                                        <option value="6">Keenam</option>
                                        <option value="7">Ketujuh</option>
                                        <option value="8">Kedelapan</option>
                                        <option value="9">Kesembilan</option>
                                        <option value="10">Kesepuluh</option>
                                    </select>
                                </div>
                
                                <div class="mb-3"> 
                                    <label for="birth_date" class="form-label">Tanggal Lahir</label>
                                    <input type="date" class="form-control" id="birth_date" name="birth_date" required>
                                </div>
                
                                <div class="mb-3">
                                    <label for="gender" class="form-label">Jenis Kelamin</label>
                                    <select class="form-select" id="gender" name="gender" required>
                                        <option value="" disabled selected>Pilih Jenis Kelamin</option>
                                        <option value="Laki-Laki">Laki-Laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </div>
                
                                <div class="mb-3">
                                    <label for="address" class="form-label">Alamat</label>
                                    <textarea class="form-control" id="address" name="address" required></textarea>
                                </div>
                
                                <div class="mb-3">
                                    <label for="photo" class="form-label">Unggah Foto</label>
                                    <div class="input-group">
                                        <input type="file" class="form-control" id="photo" name="photo" accept="image/*" onchange="previewImage(event)">
                                        <label class="input-group-text" for="photo">Pilih File</label>
                                    </div>
                                    
                                    <div class="mt-2">
                                        <img id="imagePreview" src="" alt="Pratinjau Gambar" class="img-thumbnail" style="display: none; max-width: 200px;">
                                    </div>
                                </div>
                                
                            </div>
                            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">
                                <input type="hidden" class="form-control" id="tree_id" name="tree_id" value="{{ $tree->id }}" required>
                                                
                                <div class="mb-3">
                                    <label for="partner_name" class="form-label">Nama Pasangan</label>
                                    <input type="text" class="form-control" id="partner_name" name="partner_name">
                                </div>
                
                                <div class="mb-3">
                                    <label for="urutan" class="form-label">Anak Ke</label>
                                    <select class="form-select" id="urutan" name="urutan">
                                        <option value="" disabled selected>Anak Ke</option>
                                        <option value="1">Pertama</option>
                                        <option value="2">Kedua</option>
                                        <option value="3">Ketiga</option>
                                        <option value="4">Keempat</option>
                                        <option value="5">Kelima</option>
                                        <option value="6">Keenam</option>
                                        <option value="7">Ketujuh</option>
                                        <option value="8">Kedelapan</option>
                                        <option value="9">Kesembilan</option>
                                        <option value="10">Kesepuluh</option>
                                    </select>
                                </div>
                
                                <div class="mb-3"> 
                                    <label for="partner_birth_date" class="form-label">Tanggal Lahir</label>
                                    <input type="date" class="form-control" id="partner_birth_date" name="partner_birth_date">
                                </div>
                
                                <div class="mb-3">
                                    <label for="partner_address" class="form-label">Alamat</label>
                                    <textarea class="form-control" id="partner_address" name="partner_address"></textarea>
                                </div>
                
                                <div class="mb-3">
                                    <label for="partner_photo" class="form-label">Unggah Foto</label>
                                    <div class="input-group">
                                        <input type="file" class="form-control" id="partner_photo" name="partner_photo" accept="image/*" onchange="previewImage2(event)">
                                        <label class="input-group-text" for="partner_photo">Pilih File</label>
                                    </div>
                                    
                                    <div class="mt-2">
                                        <img id="imagePreview2" src="" alt="Pratinjau Gambar" class="img-thumbnail" style="display: none; max-width: 200px;">
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
                </div>
            </div>

            <div class="overflow-x-auto mt-3 bg-white p-5 rounded-md">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ !request()->has('compare') ? 'active' : '' }}" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button">Anggota Keluarga</button>
                        <!-- <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Anggota Keluarga</button> -->
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button">Pohon Keluarga</button>
                        <!-- <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Pohon Keluarga</button> -->
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ request()->has('compare') ? 'active' : '' }}" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-tab-pane" type="button">Hubungan Keluarga</button>
                        <!-- <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-tab-pane" type="button" role="tab" aria-controls="contact-tab-pane" aria-selected="false">Hubungan Keluarga</button> -->
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade {{ !request()->has('compare') ? 'show active' : '' }}" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab">
                    <!-- <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0"> -->
                        <table class="shadow-md mt-3">
                            <thead class="">
                            <tr class="bg-blue-gray-100 text-gray-700">
                                <th class="py-3 px-4 text-center text-white border border-orange-300">No</th>
                                <th class="py-3 px-20 text-center text-white border border-orange-300">Nama Lengkap</th>
                                <th class="py-3 px-12 text-center text-white border border-orange-300">Tanggal Lahir</th>
                                <th class="py-3 px-12 text-center text-white border border-orange-300">Jenis Kelamin</th>
                                <th class="py-3 px-4 text-center text-white border border-orange-300 ">Alamat</th>
                                <th class="py-3 px-4 text-center text-white border border-orange-300">Orang tua</th>
                                <th class="py-3 px-4 text-center text-white border border-orange-300">Aksi</th>
                            </tr>
        
                            @foreach ($tree->familyMembers as $member)
                            <tr class="border-separate border bg-white justify-center align-middle">
                                <td class="py-3 px-4 text-center border border-[#CFAD82]">{{ $loop -> iteration }}</td>
                                <td class="py-3 px-4 border border-[#CFAD82] text-center wrap-text">{{$member->name}}</td>
                                <td class="py-3 px-4 border border-[#CFAD82] text-center">{{ $member->birth_date }}</td>
                                <td class="py-3 px-4 border border-[#CFAD82] text-center">{{ $member->gender }}</td>
                                <td class="py-3 px-4 border border-[#CFAD82] text-center wrap-text">{{ $member->address }}</td>
                                <td class="py-3 px-4 border border-[#CFAD82] text-center ">{{ $member->parent ? $member->parent->name : 'Belum Diketahui' }}</td>
                                <td class="py-4 px-4 border border-[#CFAD82] flex gap-3">
        
                                    <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#DetailModal{{ $member->id }}">
                                        Detail
                                    </button>
        
                                    <div class="modal fade" id="DetailModal{{ $member->id }}" tabindex="-1" aria-labelledby="DetailModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="DetailModalLabel">Detail</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body flex items-center">
                                                    @if($member->photo)
                                                        <img src="{{ asset('storage/' . $member->photo) }}" alt="Foto Anggota" class="img-fluid" style="width: 300px; height: 300px; object-fit: cover">
                                                    @else
                                                        <p><strong>Foto:</strong> Tidak ada foto</p>
                                                    @endif
                                                    <ul class="list-group">
                                                        <li class="list-group-item"><strong>Nama:</strong> {{ $member->name }}</li>
                                                        <li class="list-group-item"><strong>Tanggal Lahir:</strong> {{ $member->birth_date }}</li>
                                                        <li class="list-group-item"><strong>Jenis Kelamin:</strong> {{ $member->gender }}</li>
                                                        <li class="list-group-item"><strong>Alamat:</strong> {{ $member->address }}</li>
                                                        <li class="list-group-item"><strong>Orang Tua:</strong> {{ $member->parent ? $member->parent->name : 'Tidak Ada' }}</li>
                                                    </ul>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
        
                                
                                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#EditModal{{ $member->id }}">
                                         Edit
                                    </button>

                                    <div class="modal fade" id="EditModal{{ $member->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Data Anggota Keluarga</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <!-- Tab Navigation -->
                                                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                                        <li class="nav-item" role="presentation">
                                                            <button class="nav-link active" id="pills-home-tab-2" data-bs-toggle="pill" data-bs-target="#pills-home-2" type="button" role="tab" aria-controls="pills-home-2" aria-selected="true">Data Pribadi</button>
                                                        </li>
                                                        <li class="nav-item" role="presentation">
                                                            <button class="nav-link" id="pills-profile-tab-2" data-bs-toggle="pill" data-bs-target="#pills-profile-2" type="button" role="tab" aria-controls="pills-profile-2" aria-selected="false">Data Pasangan</button>
                                                        </li>
                                                    </ul>
                                    
                                                    <!-- Form -->
                                                    <form action="{{ route('family_members.update', $member->id) }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')
                                    
                                                        <!-- Tab Content -->
                                                        <div class="tab-content" id="pills-tabContent-2">
                                                            <!-- Tab 1: Data Pribadi -->
                                                            <div class="tab-pane fade show active" id="pills-home-2" role="tabpanel" aria-labelledby="pills-home-tab-2" tabindex="0">
                                                                <!-- Konten Data Pribadi -->
                                                                <input type="hidden" class="form-control" id="tree_id" name="tree_id" value="{{ $tree->id }}" required>
                                    
                                                                <div class="mb-3">
                                                                    <label for="name" class="form-label">Nama</label>
                                                                    <input type="text" class="form-control" id="name" name="name" value="{{ $member->name }}" required>
                                                                </div>
                                    
                                                                <div class="mb-3">
                                                                    <label for="parent_id" class="form-label">Pilih Orang Tua</label>
                                                                    <select class="form-control" id="parent_id" name="parent_id">
                                                                        <option value="" selected>Tidak Ada</option>
                                                                        @foreach ($tree->familyMembers as $parent)
                                                                            <option value="{{ $parent->id }}" {{ $member->parent_id == $parent->id ? 'selected' : '' }}>
                                                                                {{ $parent->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                    
                                                                <div class="mb-3">
                                                                    <div class="flex items-center mb-4">
                                                                        <input id="has-partner-checkbox" name="has-partner-checkbox" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500" onchange="toggleTab2()">
                                                                        <label for="has-partner-checkbox" class="ms-2 text-sm font-normal">Memiliki Pasangan</label>
                                                                    </div>
                                                                </div>
                                    
                                                                <div class="mb-3">
                                                                    <label for="birth_date" class="form-label">Tanggal Lahir</label>
                                                                    <input type="date" class="form-control" id="birth_date" name="birth_date" value="{{ $member->birth_date }}" required>
                                                                </div>
                                    
                                                                <div class="mb-3">
                                                                    <label for="urutan" class="form-label">Anak Ke</label>
                                                                    <select class="form-select" id="urutan" name="urutan" required>
                                                                        <option value="" disabled selected>Anak Ke</option>
                                                                        @for ($i = 1; $i <= 10; $i++)
                                                                            <option value="{{ $i }}" {{ $member->urutan == $i ? 'selected' : '' }}>Ke-{{ $i }}</option>
                                                                        @endfor
                                                                    </select>
                                                                </div>
                                    
                                                                <div class="mb-3">
                                                                    <label for="gender" class="form-label">Jenis Kelamin</label>
                                                                    <select class="form-select" id="gender" name="gender" required>
                                                                        <option value="Laki-Laki" {{ $member->gender == 'Laki-Laki' ? 'selected' : '' }}>Laki-Laki</option>
                                                                        <option value="Perempuan" {{ $member->gender == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                                                    </select>
                                                                </div>
                                    
                                                                <div class="mb-3">
                                                                    <label for="address" class="form-label">Alamat</label>
                                                                    <textarea class="form-control" id="address" name="address" required>{{ $member->address }}</textarea>
                                                                </div>
                                    
                                                                <div class="mb-3">
                                                                    <label for="photo" class="form-label">Unggah Foto</label>
                                                                    <div class="input-group">
                                                                        <input type="file" class="form-control" id="photo" name="photo" accept="image/*" onchange="previewImage3(event)">
                                                                    </div>
                                                                    
                                                                    <!-- Tampilkan foto yang sudah ada -->
                                                                    @if($member->photo)
                                                                        <div class="mt-2">
                                                                            <img id="existingPhoto" src="{{ asset('storage/' . $member->photo) }}" alt="Foto Anggota" class="img-thumbnail" style="max-width: 200px;">
                                                                        </div>
                                                                    @endif
                                                                
                                                                    <!-- Tampilkan pratinjau gambar baru -->
                                                                    <div class="mt-2">
                                                                        <img id="imagePreview3" src="" alt="Pratinjau Gambar" class="img-thumbnail" style="display: none; max-width: 200px;">
                                                                    </div>
                                                                </div>
                                                            </div>
                                    
                                                            <!-- Tab 2: Data Pasangan -->
                                                            <div class="tab-pane fade" id="pills-profile-2" role="tabpanel" aria-labelledby="pills-profile-tab-2" tabindex="0">
                                                                <!-- Konten Data Pasangan -->
                                                                <input type="hidden" class="form-control" id="tree_id" name="tree_id" value="{{ $tree->id }}" required>
                                    
                                                                <div class="mb-3">
                                                                    <label for="partner_name" class="form-label">Nama Pasangan</label>
                                                                    <input type="text" class="form-control" id="partner_name" name="partner_name" value="{{ $member->partner_name }}">
                                                                </div>
                                    
                                                                <div class="mb-3">
                                                                    <label for="partner_birth_date" class="form-label">Tanggal Lahir</label>
                                                                    <input type="date" class="form-control" id="partner_birth_date" name="partner_birth_date" value="{{ $member->partner_birth_date }}">
                                                                </div>
                                    
                                                                <div class="mb-3">
                                                                    <label for="partner_address" class="form-label">Alamat</label>
                                                                    <textarea class="form-control" id="partner_address" name="partner_address">{{ $member->partner_address }}</textarea>
                                                                </div>
                                    
                                                                <div class="mb-3">
                                                                    <label for="partner_photo" class="form-label">Unggah Foto</label>
                                                                    <div class="input-group">
                                                                        <input type="file" class="form-control" id="partner_photo" name="partner_photo" accept="image/*" onchange="previewImage2(event)">
                                                                        <label class="input-group-text" for="partner_photo">Pilih File</label>
                                                                    </div>
                                                                    
                                                                    <div class="mt-2">
                                                                        <img id="imagePreview2" src="" alt="Pratinjau Gambar" class="img-thumbnail" style="display: none; max-width: 200px;">
                                                                    </div>
                                                                </div>
                                                            </div>
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
                     
                                     <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#DeleteModal{{ $member->id }}">
                                        Hapus
                                    </button>
                            
                                    <!-- Modal Konfirmasi Hapus -->
                                    <div class="modal fade" id="DeleteModal{{ $member->id }}" tabindex="-1" aria-labelledby="DeleteModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="DeleteModalLabel">Konfirmasi Hapus</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Apakah Anda yakin ingin menghapus <strong>{{ $member->name }}</strong> dari keluarga?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <!-- Form untuk menghapus data -->
                                                    <form action="{{ route('family_members.destroy', $member->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
        
        
                                </td>
                            </tr>
                            @endforeach
                            </thead>
                        </table>
                    </div>

                    <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab">
                    <!-- <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0"> -->
                        <div class="container flex-wrap overflow-hidden">
                            <div class="row justify-center">
                                <h1 class="fw-bold" style="color: #000 !important; text-transform: capitalize;">{{ $tree->tree_name }}</h1>
                                <div class="tree">
                                    <ul>
                                        @foreach ($rootMembers as $member)
                                            @include('partials.family-member', ['member' => $member])
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade {{ request()->has('compare') ? 'show active' : '' }}" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab">
                    <!-- <div class="tab-pane fade" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab" tabindex="0"> -->
                        <!-- HUBUNGAN KELUARGA -->
                        <div class="flex mt-10">
                            <div class="container sm:mx-12 md:mx-28">
                                
                                @if(session('error'))
                                    <div class="alert alert-danger">
                                        {{ session('error') }}
                                    </div>
                                @endif

                                <div class="bg-[#FEEEBD] p-5 rounded-md">

                                    <form action="{{ route('trees.detail', $tree_id) }}" method="GET">
                                    @csrf
                                        <input type="hidden" name="tree_id" value="{{ $tree_id }}">
                                        <input type="hidden" name="compare" value="true">

                                        <div class="container px-4">
                                            <div class="row gx-5">
                                                <div class="col">
                                                    <div class="mb-3">
                                                        <label for="person1" class="form-label text-center w-100">Pilih Anggota Keluarga 1:</label>
                                                        <div class="d-flex justify-content-center">
                                                        <select name="name1" id="person1" class="form-control" style="width: 450px;" required>
                                                        <option value="">-- Pilih --</option>
                                                        @foreach ($members as $member)
                                                            <option value="{{ $member->name }}" {{ old('name1', $person1->name ?? '') == $member->name ? 'selected' : '' }}>
                                                            {{ $member->name }}
                                                            </option>
                                                        @endforeach
                                                        </select>

                                                        </div>

                                                    </div>
                                                </div>

                                                <div class="col d-flex justify-content-center align-items-center">
                                                    <button type="submit" class="btn btn-primary rounded-circle" style="width: 50px; height: 50px; font-size: 24px;">&#x1F50E;&#xFE0E;</button>
                                                </div>


                                                <div class="col">
                                                    <div class="mb-3">
                                                        <label for="person2" class="form-label text-center w-100">Pilih Anggota Keluarga 2:</label>
                                                        <select name="name2" id="person2" class="form-control" style="width: 450px;" required>
                                                        <option value="">-- Pilih --</option>
                                                        @foreach ($members as $member)
                                                            <option value="{{ $member->name }}" {{ old('name2', $person2->name ?? '') == $member->name ? 'selected' : '' }}>
                                                            {{ $member->name }}
                                                            </option>
                                                        @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        

                                    </form>

                                    <!-- tabel hasil hubungan -->

                                    @if(isset($relationshipDetails) && isset($relationshipDetailsReversed))

                                        <div class="row" id="relationship-details">
                                            <h3 class="text-center text-lg font-semibold mb-1 mt-1">Hasil Perbandingan</h3>

                                            <!-- Kolom hubungan anggota 1 -->
                                            <div class="col-md-6">
                                                <div class="bg-white shadow-md p-5 rounded-md mt-3">
                                                    @if(isset($person1->photo) && $person1->photo)
                                                    <div class="flex justify-center mb-3">
                                                        <img src="{{ asset('storage/' . $person1->photo) }}" 
                                                            alt="{{ $person1->name }}" 
                                                            class="w-48 h-48 rounded-full object-cover border-4 border-green-700" />
                                                    </div>
                                                    @endif
                                                    @if(is_array($relationshipDetails))
                                                        <div class="bg-[#FEF3C7] flex justify-center text-gray-800 p-3 rounded-md mb-3">
                                                            {{ $relationshipDetails['relation'] }}
                                                        </div>
                                                        @if(!empty($relationshipDetails['detailedPath']))
                                                            <div class="bg-[#FEF3C7] text-gray-800 p-3 rounded-md mb-3">
                                                                <strong class="flex justify-center mb-3">Jalur Hubungan Keluarga:</strong>
                                                                <ul class="list-group mt-2">
                                                                    @foreach ($relationshipDetails['detailedPath'] as $detail)
                                                                        <li class="list-group-item">{{ $detail }}</li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        @elseif(isset($path) && count($path))
                                                            <div class="bg-[#FEF3C7] text-gray-800 p-3 rounded-md mb-3">
                                                                <strong>Jalur (BFS fallback):</strong>
                                                                <p>
                                                                    {{ implode(' → ', array_map(fn($m) => $m->name, $path)) }}
                                                                </p>
                                                            </div>
                                                        @endif
                                                    @else
                                                        <div class="alert alert-warning">{{ $relationshipDetails }}</div>    
                                                    @endif  
                                                </div>
                                            </div>

                                            <!-- Kolom hubungan keluarga 2 -->
                                            <div class="col-md-6 mt-4 mt-md-0">
                                                <div class="bg-white shadow-md p-5 rounded-md mt-3">
                                                    @if(isset($person2->photo) && $person2->photo)
                                                        <div class="flex justify-center mb-3">
                                                            <img src="{{ asset('storage/' . $person2->photo) }}" 
                                                                alt="{{ $person2->name }}" 
                                                                class="w-48 h-48 rounded-full object-cover border-4 border-green-700" />
                                                        </div>
                                                    @endif
                                                    @if(is_array($relationshipDetailsReversed))
                                                        <div class="bg-[#FEF3C7] flex justify-center text-gray-800 p-3 rounded-md mb-3">
                                                            {{ $relationshipDetailsReversed['relation'] }}
                                                        </div>
                                                        @if(!empty($relationshipDetailsReversed['detailedPath']))
                                                            <div class="bg-[#FEF3C7] text-gray-800 p-3 rounded-md mb-3">
                                                                <strong class="flex justify-center mb-3">Jalur Hubungan Keluarga:</strong>
                                                                <ul class="list-group mt-2">
                                                                    @foreach ($relationshipDetailsReversed['detailedPath'] as $detail)
                                                                        <li class="list-group-item">{{ $detail }}</li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        @elseif(isset($path) && count($path))
                                                            <div class="bg-[#FEF3C7] text-gray-800 p-3 rounded-md mb-3">
                                                                <strong>Jalur (BFS fallback):</strong>
                                                                <p>
                                                                    {{ implode(' → ', array_map(fn($m) => $m->name, $path)) }}
                                                                </p>
                                                            </div>
                                                        @endif
                                                    @else
                                                        <div class="alert alert-warning">{{ $relationshipDetailsReversed }}</div>    
                                                    @endif 

                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="d-grid gap-2 mt-4">
                                        <button type="button" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-700" onclick="resetForm();">Reset</button>
                                    </div>


                                    

                                       
                                    

                                    @if(isset($relationshipDetails) && isset($relationshipDetailsReversed))
                                    <script>
                                        window.onload = () => {
                                            document.getElementById('relationship-details')?.scrollIntoView({ behavior: 'smooth' });
                                        }
                                    </script>
                                    @endif

                                    <script>
                                        function resetForm() {
                                            document.querySelector("form").reset();
                                            document.querySelector("#person1").selectedIndex = 0;
                                            document.querySelector("#person2").selectedIndex = 0;
                                            document.getElementById("relationship-details").innerHTML = '';  // Clear results
                                        }
                                    </script> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewImage(event) {
            const input = event.target;
            const preview = document.getElementById("imagePreview");
        
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.style.display = "block";
                };
        
                reader.readAsDataURL(input.files[0]);
            } else {
                preview.src = "";
                preview.style.display = "none";
            }
        }

        function previewImage2(event) {
            const input = event.target;
            const preview = document.getElementById("imagePreview2");
        
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.style.display = "block";
                };
        
                reader.readAsDataURL(input.files[0]);
            } else {
                preview.src = "";
                preview.style.display = "none";
            }
        }
        
        function previewImage3(event) {
        const input = event.target;
        const preview = document.getElementById("imagePreview3");
        const existingPhoto = document.getElementById("existingPhoto");

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.style.display = "block";

                // Sembunyikan gambar lama jika ada
                if (existingPhoto) {
                    existingPhoto.style.display = "none";
                }
            };

            reader.readAsDataURL(input.files[0]);
        } else {
            preview.src = "";
            preview.style.display = "none";

            // Tampilkan kembali gambar lama jika tidak ada file baru yang dipilih
            if (existingPhoto) {
                existingPhoto.style.display = "block";
            }
        }
    }

        function toggleTab2Edit() {
        const hasPartnerCheckbox = document.getElementById('has-partner-checkbox-edit');
        const partnerTab = document.getElementById('pills-profile-tab');
        if (hasPartnerCheckbox.checked) {
            partnerTab.classList.remove('disabled');
        } else {
            partnerTab.classList.add('disabled');
        }
    }

    </script>
</x-app-layout>