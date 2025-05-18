<li>
    <a href="#" data-bs-toggle="modal" data-bs-target="#PopUpModal{{ $member->id }}">
        <div class="absolute">{{ $member->urutan }}</div>
        @if ($member->photo)
            <div class="d-flex">
                <!-- Foto Anggota -->
                <img src="{{ asset('storage/' . $member->photo) }}" alt="Foto Anggota"
                     style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">

                <!-- Foto Pasangan atau Foto Default -->
                @if ($member->partner_photo)
                    <img src="{{ asset('storage/' . $member->partner_photo) }}" alt="Foto Pasangan"
                         style="width: 40px; height: 40px; object-fit: cover; border-radius: 50%;">
                @else
                    @if ($member->gender == 'Laki-Laki')
                        <img src="{{ asset('../img/female.png') }}" alt="Foto Default Laki-laki"
                             style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">
                    @elseif ($member->gender == 'Perempuan')
                        <img src="{{ asset('../img/male.png') }}" alt="Foto Default Perempuan"
                             style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">
                    @endif
                @endif
            </div>
        @else
            <!-- Jika tidak ada foto anggota, tampilkan foto default berdasarkan gender -->
            @if ($member->gender == 'Laki-Laki')
                <img src="{{ asset('../img/male.png') }}" alt="Foto Default Laki-laki"
                     style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">
            @elseif ($member->gender == 'Perempuan')
                <img src="{{ asset('../img/female.png') }}" alt="Foto Default Perempuan"
                     style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">
            @endif
        @endif
        <span class="capitalize">{{ $member->name }}</span>
    </a>

    <!-- Jika anggota memiliki anak, tampilkan daftar anak -->
    @if ($member->children->count() > 0)
        <ul>
            @foreach ($member->children->sortBy('urutan') as $child)
                @include('partials.family-member', ['member' => $child])
            @endforeach
        </ul>
    @endif

    <!-- Modal untuk menampilkan biodata anggota -->
    <div class="modal fade" id="PopUpModal{{ $member->id }}" tabindex="-1" aria-labelledby="PopUpModal{{ $member->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Biodata {{ $member->name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if ($member->photo)
                        <div class="card w-full">
                            <div class="card-body d-flex justify-content-center">
                                <!-- Foto Anggota -->
                                <img src="{{ asset('storage/' . $member->photo) }}" alt="Foto Anggota"
                                     style="width: 100px; height: 100px; object-fit: cover; border-radius: 50%;">

                                <!-- Foto Pasangan atau Foto Default -->
                                @if ($member->partner_photo)
                                    <img src="{{ asset('storage/' . $member->partner_photo) }}" alt="Foto Pasangan"
                                         style="width: 40px; height: 40px; object-fit: cover; border-radius: 50%;">
                                @else
                                    @if ($member->gender == 'Laki-Laki')
                                        <img src="{{ asset('../img/female.png') }}" alt="Foto Default Laki-laki"
                                             style="width: 100px; height: 100px; object-fit: cover; border-radius: 50%;">
                                    @elseif ($member->gender == 'Perempuan')
                                        <img src="{{ asset('../img/male.png') }}" alt="Foto Default Perempuan"
                                             style="width: 100px; height: 100px; object-fit: cover; border-radius: 50%;">
                                    @endif
                                @endif
                            </div>
                        </div>
                    @else
                        <!-- Jika tidak ada foto anggota, tampilkan foto default berdasarkan gender -->
                        <div class="d-flex justify-content-center">
                            @if ($member->gender == 'Laki-Laki')
                                <img src="{{ asset('../img/male.png') }}" alt="Foto Default Laki-laki"
                                     style="width: 100px; height: 100px; object-fit: cover; border-radius: 50%;">
                            @elseif ($member->gender == 'Perempuan')
                                <img src="{{ asset('../img/female.png') }}" alt="Foto Default Perempuan"
                                     style="width: 100px; height: 100px; object-fit: cover; border-radius: 50%;">
                            @endif
                        </div>
                    @endif

                    <div class="container d-flex justify-content-start">
                        <div class="col text-start">
                            <p>Nama</p>
                            <p>Tanggal Lahir</p>
                        </div>
                        <div class="col text-start">
                            <p>{{ $member->name }}</p>
                            <p>{{ \Carbon\Carbon::parse($member->birth_date)->format('d-m-Y') }}</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</li>