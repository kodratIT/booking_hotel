@extends('layouts.app')

@section('content')
    <h1 style="text-align: center; margin-bottom: 30px; background-color: #6b1e11; color: white; padding: 20px; border-radius: 8px;">
        Mudah Pesan Kamar di Penginapan STeZe
    </h1>

    <!-- Wrapper untuk pusatkan konten -->
    <div style="display: flex; justify-content: center;">
        <div class="grid-cabangs" style="
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
            max-width: 1000px;
            width: 100%;
            padding: 0 20px;
        ">
            @foreach($cabangs as $cabang)
                @php
                    $kamarsTersedia = $cabang->kamars->filter(fn($kamar) => $kamar->stok > 0);
                @endphp

                <div style="
                    border: 1px solid #ddd;
                    border-radius: 12px;
                    overflow: hidden;
                    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
                    background-color: #fff;
                    display: flex;
                    flex-direction: column;
                    height: 100%;
                ">
                    <img 
                        src="{{ $cabang->gambar ? asset('storage/' . $cabang->gambar) : asset('images/default.jpg') }}"
                        alt="{{ $cabang->nama }}"
                        style="width: 100%; height: 200px; object-fit: cover;"
                    >

                    <div style="padding: 16px; flex: 1; display: flex; flex-direction: column; justify-content: space-between;">
                        <div>
                            <h2 style="font-size: 1.2rem; font-weight: 600; margin-bottom: 8px; color: #5a1d12;">{{ $cabang->nama }}</h2>
                            <p style="margin-bottom: 12px; color: #555;">{{ $cabang->alamat }}</p>
                        </div>

                        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: auto;">
                            @if($kamarsTersedia->isNotEmpty())
                                <p style="font-weight: 500; color: #333;">
                                    Mulai dari <span style="font-weight: bold;">Rp {{ number_format($kamarsTersedia->min('harga_per_malam')) }}</span> /malam
                                </p>
                                <a href="{{ route('cabang.show', $cabang->id) }}" style="
                                    background-color: #6b1e11;
                                    color: white;
                                    padding: 8px 14px;
                                    text-decoration: none;
                                    border-radius: 6px;
                                    font-weight: 500;
                                ">Pilih Cabang</a>
                            @else
                                <p style="font-weight: bold; color: #888;">Kamar Penuh</p>
                                <span style="
                                    background-color: #ccc;
                                    color: #666;
                                    padding: 8px 14px;
                                    border-radius: 6px;
                                    font-weight: 500;
                                    cursor: not-allowed;
                                ">Tidak Tersedia</span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
