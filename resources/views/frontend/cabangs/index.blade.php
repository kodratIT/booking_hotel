@extends('layouts.app')

@section('content')
    <h1 style="text-align: center; margin-bottom: 30px; background-color: #6b1e11; color: white; padding: 20px; border-radius: 8px;">
        Mudah Booking Kamar di Penginapan STeZe
    </h1>

    <div class="grid-cabangs" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px;">
        @foreach($cabangs as $cabang)
            @php
                // Ambil kamar yang stoknya masih tersedia
                $kamarsTersedia = $cabang->kamars->filter(function($kamar) {
                    return $kamar->stok > 0;
                });
            @endphp

            <div class="card-cabang" style="border: 1px solid #ccc; border-radius: 10px; overflow: hidden; box-shadow: 2px 2px 10px rgba(0,0,0,0.1);">
                @if($cabang->gambar)
                    <img 
                        src="{{ asset('storage/' . $cabang->gambar) }}" 
                        alt="{{ $cabang->nama }}"
                        style="width: 100%; height: 200px; object-fit: cover;">
                @else
                    <img 
                        src="{{ asset('images/default.jpg') }}" 
                        alt="Default Image"
                        style="width: 100%; height: 200px; object-fit: cover;">
                @endif

                <div class="card-body" style="padding: 15px;">
                    <h2 style="margin-bottom: 10px;">{{ $cabang->nama }}</h2>
                    <p>{{ $cabang->alamat }}</p>
                    <div class="card-footer" style="margin-top: 15px; display: flex; justify-content: space-between; align-items: center;">
                        @if($kamarsTersedia->isNotEmpty())
                            <p class="harga-besar">
                                Mulai dari <span style="font-weight: bold;">Rp {{ number_format($kamarsTersedia->min('harga_per_malam')) }}</span> /malam
                            </p>
                            <a href="{{ route('cabang.show', $cabang->id) }}" class="btn-pilih" style="background-color: #6b1e11; color: white; padding: 8px 15px; text-decoration: none; border-radius: 5px;">Pilih Cabang</a>
                        @else
                            <p style="font-weight: bold; color: #888;">Kamar Penuh</p>
                            <span style="background-color: #ccc; color: #666; padding: 8px 15px; border-radius: 5px; cursor: not-allowed;">Tidak Tersedia</span>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
