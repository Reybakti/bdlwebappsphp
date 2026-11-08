@extends('layouts.app')

@section('title', 'Whistleblowing System (WBS) | ' . ($profile->name ?? 'Bank Daerah Lamongan'))

@section('content')
<!-- Hero Header Section Khusus Kepatuhan Integritas -->
<section class="relative min-h-[360px] lg:min-h-[400px] flex items-center bg-slate-900 overflow-hidden">
    <img src="https://images.unsplash.com/photo-1450133064473-71024230f91b?auto=format&fit=crop&w=1920&q=80" 
         alt="Whistleblowing System Bank Daerah Lamongan" 
         class="absolute inset-0 w-full h-full object-cover object-center filter brightness-[0.35]">

    <div class="absolute inset-0 bg-gradient-to-r from-black/85 via-black/60 to-black/30"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 lg:px-8 w-full pt-36 pb-14 text-white">
        <div class="max-w-2xl space-y-4">
            <div class="inline-flex items-center gap-2 px-3 py-1 bg-rose-500/20 backdrop-blur-md border border-rose-400/30 rounded-full text-[11px] font-semibold text-rose-300 tracking-wider uppercase">
                Anti-Fraud & Budaya Integritas
            </div>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight leading-tight">
                Whistleblowing System (WBS)
            </h1>
            <p class="text-white/80 text-xs sm:text-sm leading-relaxed max-w-lg">
                Kanal resmi pelaporan rahasia atas indikasi kecurangan (fraud), gratifikasi, korupsi, atau pelanggaran etika perbankan dengan jaminan perlindungan penuh kerahasiaan identitas pelapor.
            </p>
        </div>
    </div>
</section>

<!-- Sub-Navigasi Tab -->
<nav class="sticky top-20 z-40 bg-white/95 backdrop-blur-md border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 lg:px-8">
        <div class="flex items-center gap-6 overflow-x-auto text-xs font-semibold text-slate-600 py-3.5 scrollbar-none">
            <a href="{{ route('services.complaint') }}" class="hover:text-bdl-primary transition whitespace-nowrap font-medium text-slate-500">&larr; Pengaduan Nasabah</a>
            <span class="text-rose-600 font-bold border-b-2 border-rose-600 pb-1 whitespace-nowrap">Form Pelaporan WBS</span>
            <a href="#komitmen-perlindungan" class="hover:text-bdl-primary transition whitespace-nowrap">Jaminan Kerahasiaan Pelapor</a>
            <a href="#kategori-pelanggaran" class="hover:text-bdl-primary transition whitespace-nowrap">Ruang Lingkup Pelanggaran</a>
        </div>
    </div>
</nav>

<!-- Konten Utama WBS -->
<div class="max-w-7xl mx-auto px-4 lg:px-8 py-16 space-y-16">

    <!-- Notifikasi Sukses Pendaftaran Laporan -->
    @if(session('wbs_success'))
        <div class="p-6 sm:p-8 rounded-3xl bg-emerald-50 border border-emerald-200 text-emerald-950 space-y-3 shadow-sm">
            <div class="flex items-center gap-2.5 font-extrabold text-base text-emerald-800">
                <svg class="w-6 h-6 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                <span>{{ session('wbs_success') }}</span>
            </div>
            <p class="text-xs text-emerald-800 leading-relaxed max-w-2xl">
                Laporan Anda telah diteruskan langsung kepada <strong>Tim Satuan Kerja Audit Intern (SKAI) & Komite Audit</strong>. Harap simpan kode registrasi rahasia berikut sebagai bukti pelaporan:
            </p>
            <div class="p-4 bg-white rounded-2xl border border-emerald-200 inline-block font-num font-extrabold text-xl text-bdl-navy tracking-widest shadow-sm">
                {{ session('registration_code') }}
            </div>
            <span class="block text-[11px] text-emerald-700 italic">
                *Demi keamanan Anda, tidak ada konfirmasi email atau SMS yang dikirimkan. Simpan kode ini secara mandiri.
            </span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
        
        <!-- Formulir Pelaporan WBS (Kolom Kiri) -->
        <div class="lg:col-span-8 bg-white rounded-3xl border border-slate-200 p-6 sm:p-10 shadow-sm space-y-8">
            <div class="border-b border-slate-100 pb-4">
                <span class="text-xs font-bold text-rose-600 uppercase tracking-wider block">Kanal Rahasia Kepatuhan</span>
                <h2 class="text-2xl font-extrabold text-bdl-navy mt-1">Formulir Pelaporan Pelanggaran</h2>
                <p class="text-xs text-slate-500 mt-1">
                    Laporan diproses secara independen tanpa campur tangan pihak terlapor.
                </p>
            </div>

            @if($errors->any())
                <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs space-y-1">
                    <strong class="font-bold block">Mohon perbaiki formulir Anda:</strong>
                    <ul class="list-disc list-inside space-y-0.5 text-[11px]">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('services.wbs.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Pilihan Anonimitas -->
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-3">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_anonymous" id="toggleAnonymous" value="1" 
                               {{ old('is_anonymous', '1') ? 'checked' : '' }} 
                               onchange="handleAnonymousToggle(this)"
                               class="accent-rose-600 w-4 h-4 rounded">
                        <span class="text-xs font-bold text-slate-800">
                            Laporkan Secara Anonim (Identitas Saya Disembunyikan)
                        </span>
                    </label>
                    <p class="text-[11px] text-slate-500 leading-relaxed pl-7">
                        Jika dicentang, nama dan kontak Anda tidak akan dicatat atau disimpan pada sistem.
                    </p>
                </div>

                <!-- Kolom Identitas Opsional (Tampil jika centang anonim dicabut) -->
                <div id="reporterFields" class="grid grid-cols-1 sm:grid-cols-2 gap-4 hidden">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Nama Pelapor (Opsional)</label>
                        <input type="text" name="reporter_name" value="{{ old('reporter_name') }}" placeholder="Nama Anda"
                               class="w-full text-xs text-slate-800 bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:border-bdl-primary focus:bg-white transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">No. HP / WhatsApp / Email (Opsional)</label>
                        <input type="text" name="reporter_contact" value="{{ old('reporter_contact') }}" placeholder="Untuk kebutuhan tindak lanjut bukti"
                               class="w-full text-xs text-slate-800 bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:border-bdl-primary focus:bg-white transition">
                    </div>
                </div>

                <!-- Rincian Pelanggaran -->
                <div class="space-y-4">
                    <h3 class="text-xs font-bold text-bdl-navy uppercase tracking-wider border-b border-slate-100 pb-2">
                        Rincian Dugaan Pelanggaran (5W + 1H)
                    </h3>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">
                            Jenis Dugaan Pelanggaran <span class="text-rose-500">*</span>
                        </label>
                        <select name="violation_type" required 
                                class="w-full text-xs text-slate-800 bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:border-bdl-primary focus:bg-white transition">
                            <option value="">-- Pilih Klasifikasi Pelanggaran --</option>
                            <option value="FRAUD_KORUPSI" {{ old('violation_type') == 'FRAUD_KORUPSI' ? 'selected' : '' }}>Kecurangan Transaksi / Fraud Finansial / Korupsi</option>
                            <option value="SUAP_GRATIFIKASI" {{ old('violation_type') == 'SUAP_GRATIFIKASI' ? 'selected' : '' }}>Penerimaan Suap / Gratifikasi / Pemerasan</option>
                            <option value="PENGGELAPAN_DANA" {{ old('violation_type') == 'PENGGELAPAN_DANA' ? 'selected' : '' }}>Penyalahgunaan Kas / Penggelapan Simpanan Nasabah</option>
                            <option value="BENTURAN_KEPENTINGAN" {{ old('violation_type') == 'BENTURAN_KEPENTINGAN' ? 'selected' : '' }}>Benturan Kepentingan (Conflict of Interest)</option>
                            <option value="PELANGGARAN_SOP" {{ old('violation_type') == 'PELANGGARAN_SOP' ? 'selected' : '' }}>Pelanggaran Berat SOP Perbankan & Etika Kerja</option>
                            <option value="LAINNYA" {{ old('violation_type') == 'LAINNYA' ? 'selected' : '' }}>Pelanggaran Hukum Lainnya</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">
                                Pihak yang Terlibat / Terlapor <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="involved_parties" value="{{ old('involved_parties') }}" required 
                                   placeholder="Sebutkan nama dan/atau jabatan pihak terkait"
                                   class="w-full text-xs text-slate-800 bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:border-bdl-primary focus:bg-white transition">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">
                                Lokasi Kejadian (Cabang / Unit Kerja) <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="incident_location" value="{{ old('incident_location') }}" required 
                                   placeholder="Contoh: Kantor Kas Babat / Kantor Pusat"
                                   class="w-full text-xs text-slate-800 bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:border-bdl-primary focus:bg-white transition">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">
                            Perkiraan Tanggal / Periode Kejadian <span class="text-rose-500">*</span>
                        </label>
                        <input type="date" name="incident_date" value="{{ old('incident_date') }}" required 
                               class="w-full text-xs text-slate-800 bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 font-num focus:outline-none focus:border-bdl-primary focus:bg-white transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">
                            Uraian Kronologi Kejadian <span class="text-rose-500">*</span>
                        </label>
                        <textarea name="chronology" rows="6" required 
                                  placeholder="Jelaskan secara runtut bagaimana tindakan tersebut dilakukan, perkiraan nilai kerugian jika ada, serta saksi-saksi terkait..."
                                  class="w-full text-xs text-slate-800 bg-slate-50 border border-slate-200 rounded-xl p-4 focus:outline-none focus:border-bdl-primary focus:bg-white transition leading-relaxed">{{ old('chronology') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">
                            Unggah Bukti Pendukung (Dokumen / Foto / Tangkapan Layar)
                        </label>
                        <input type="file" name="evidence_file" accept=".pdf,.jpg,.jpeg,.png,.zip" 
                               class="w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-rose-50 file:text-rose-700 hover:file:bg-rose-100 cursor-pointer">
                        <span class="text-[10px] text-slate-400 block mt-1">Format didukung: PDF, JPG, PNG, ZIP (Maksimal 10 MB).</span>
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full sm:w-auto px-8 py-3.5 rounded-xl text-xs font-bold text-white bg-rose-700 hover:bg-rose-800 transition shadow-md">
                        Kirim Laporan WBS Secara Aman & Rahasia
                    </button>
                </div>
            </form>
        </div>

        <!-- Sidebar Prinsip Perlindungan & SOP (Kolom Kanan) -->
        <div class="lg:col-span-4 space-y-6">
            
            <div id="komitmen-perlindungan" class="bg-bdl-navy text-white rounded-3xl p-6 sm:p-7 shadow-sm space-y-4">
                <span class="text-[10px] font-bold uppercase tracking-wider text-bdl-soft block">Whistleblower Protection</span>
                <h3 class="text-base font-bold">Jaminan Kerahasiaan & Keamanan</h3>
                <p class="text-xs text-slate-300 leading-relaxed">
                    Sesuai kebijakan Anti-Fraud, <strong>{{ $profile->name ?? 'PT BPR Bank Daerah Lamongan (Perseroda)' }}</strong> memberikan perlindungan penuh terhadap:
                </p>
                <ul class="space-y-2 text-xs text-slate-200 list-disc list-inside leading-relaxed pt-1">
                    <li>Kerahasiaan identitas dan data pribadi pelapor.</li>
                    <li>Perlindungan dari segala bentuk intimidasi, pembalasan, atau diskriminasi.</li>
                    <li>Pemeriksaan dilakukan secara independen oleh Tim Audit Intern (SKAI).</li>
                </ul>
            </div>

            <div id="kategori-pelanggaran" class="bg-slate-50 rounded-3xl border border-slate-200 p-6 sm:p-7 space-y-4">
                <h4 class="text-xs font-bold text-bdl-navy uppercase tracking-wider border-b border-slate-200 pb-2">
                    Kriteria Laporan yang Ditindaklanjuti
                </h4>
                
                <p class="text-xs text-slate-600 leading-relaxed">
                    Kanal WBS diperuntukkan bagi dugaan pelanggaran hukum dan integritas, bukan untuk keluhan operasional umum seperti permohonan kredit atau buku tabungan rusak.
                </p>

                <div class="p-3 bg-white rounded-xl border border-slate-200 text-[11px] text-slate-600 space-y-1">
                    <span class="font-bold text-bdl-navy block">Punya keluhan layanan nasabah biasa?</span>
                    <a href="{{ route('services.complaint') }}" class="text-bdl-primary font-bold hover:underline inline-block">
                        Gunakan Form Pengaduan Nasabah &rarr;
                    </a>
                </div>
            </div>

        </div>

    </div>
</div>

<script>
function handleAnonymousToggle(checkbox) {
    const fields = document.getElementById('reporterFields');
    if (checkbox.checked) {
        fields.classList.add('hidden');
    } else {
        fields.classList.remove('hidden');
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const cb = document.getElementById('toggleAnonymous');
    if (cb) handleAnonymousToggle(cb);
});
</script>
@endsection