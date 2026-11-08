@extends('layouts.admin')

@section('title', 'Profil Lembaga & Kontak Media')
@section('page_title', 'Profil Lembaga & Kontak Media')
@section('page_subtitle', 'Kelola informasi legalitas, alamat kantor pusat, narahubung pers, dan tautan media sosial resmi.')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    @if(session('success'))
        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center justify-between">
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs">
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6 text-xs">
        @csrf
        @method('PUT')

        <!-- KARTU 1: IDENTITAS & LEGALITAS KANTOR PUSAT -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm space-y-5">
            <div class="border-b border-slate-100 pb-3">
                <span class="text-[10px] font-bold text-[#0066B2] uppercase tracking-wider block">Identitas Resmi</span>
                <h2 class="text-base font-extrabold text-[#0A2540]">Informasi Lembaga & Alamat Operasional</h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <label class="block font-bold text-slate-700 mb-1">Nama Resmi Lembaga <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $profile->name) }}" required
                           class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-2.5 focus:outline-none focus:border-[#0066B2] focus:bg-white transition text-slate-800 font-semibold">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Telepon Utama Kantor Pusat <span class="text-rose-500">*</span></label>
                    <input type="text" name="phone" value="{{ old('phone', $profile->phone) }}" required
                           class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-2.5 focus:outline-none focus:border-[#0066B2] focus:bg-white transition font-mono text-slate-800">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Email Sekretariat Resmi <span class="text-rose-500">*</span></label>
                    <input type="email" name="email" value="{{ old('email', $profile->email) }}" required
                           class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-2.5 focus:outline-none focus:border-[#0066B2] focus:bg-white transition text-slate-800">
                </div>

                <div class="sm:col-span-2">
                    <label class="block font-bold text-slate-700 mb-1">Alamat Kantor Pusat <span class="text-rose-500">*</span></label>
                    <textarea name="head_office_address" rows="2" required
                              class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl p-3.5 focus:outline-none focus:border-[#0066B2] focus:bg-white transition text-slate-800 leading-relaxed">{{ old('head_office_address', $profile->head_office_address) }}</textarea>
                </div>

                <div class="sm:col-span-2">
                    <label class="block font-bold text-slate-700 mb-1">Pernyataan Regulasi OJK & LPS <span class="text-rose-500">*</span></label>
                    <textarea name="ojk_lps_statement" rows="2" required
                              class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl p-3.5 focus:outline-none focus:border-[#0066B2] focus:bg-white transition text-slate-800 leading-relaxed">{{ old('ojk_lps_statement', $profile->ojk_lps_statement) }}</textarea>
                </div>
            </div>
        </div>

        <!-- KARTU PENGELOLAAN VIDEO PROFIL PERUSAHAAN -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm space-y-5">
            <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
                <div>
                    <span class="text-[10px] font-bold text-[#0066B2] uppercase tracking-wider block">Media Interaktif</span>
                    <h2 class="text-base font-extrabold text-[#0A2540]">Video Profil Perusahaan (Company Profile)</h2>
                    <p class="text-slate-400 text-[11px] mt-0.5">Tampilkan video pengenalan profil bank di halaman Tentang Kami.</p>
                </div>
            </div>

            <div class="space-y-4">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Judul / Keterangan Video</label>
                    <input type="text" name="video_title" value="{{ old('video_title', $profile->video_title) }}" 
                           placeholder="Contoh: Profil Perjalanan PT BPR Bank Daerah Lamongan (Perseroda)"
                           class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-2.5 focus:outline-none focus:border-[#0066B2] focus:bg-white transition text-slate-800">
                </div>

                <!-- Pilihan Tipe Sumber Video -->
                <div>
                    <label class="block font-bold text-slate-700 mb-2">Pilih Sumber Video <span class="text-rose-500">*</span></label>
                    <div class="flex items-center gap-6">
                        <label class="inline-flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="video_source_type" value="URL" 
                                   {{ old('video_source_type', $profile->video_source_type ?? 'URL') === 'URL' ? 'checked' : '' }}
                                   onchange="toggleVideoSource('URL')"
                                   class="accent-[#0066B2] w-4 h-4">
                            <span class="text-slate-700 font-semibold">Tautan URL (YouTube / Video Web)</span>
                        </label>
                        <label class="inline-flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="video_source_type" value="UPLOAD" 
                                   {{ old('video_source_type', $profile->video_source_type ?? 'URL') === 'UPLOAD' ? 'checked' : '' }}
                                   onchange="toggleVideoSource('UPLOAD')"
                                   class="accent-[#0066B2] w-4 h-4">
                            <span class="text-slate-700 font-semibold">Unggah File Video Sendiri</span>
                        </label>
                    </div>
                </div>

                <!-- Input Opsi 1: URL Video / YouTube -->
                <div id="videoUrlSection" class="{{ old('video_source_type', $profile->video_source_type ?? 'URL') === 'URL' ? '' : 'hidden' }}">
                    <label class="block font-bold text-slate-700 mb-1">URL Video YouTube</label>
                    <input type="url" name="video_url" value="{{ old('video_url', $profile->video_url) }}" 
                           placeholder="https://www.youtube.com/watch?v=..."
                           class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-2.5 focus:outline-none focus:border-[#0066B2] focus:bg-white transition text-slate-800 font-mono">
                    <span class="text-[11px] text-slate-400 block mt-1">Mendukung tautan standar YouTube (`youtube.com/watch?v=...`) maupun format pendek (`youtu.be/...`).</span>
                </div>

                <!-- Input Opsi 2: Upload File Video -->
                <div id="videoUploadSection" class="{{ old('video_source_type', $profile->video_source_type ?? 'URL') === 'UPLOAD' ? '' : 'hidden' }}">
                    <label class="block font-bold text-slate-700 mb-1">Pilih Berkas Video (Format MP4 / WebM, Maks. 60 MB)</label>
                    <input type="file" name="video_file" accept="video/mp4,video/webm,video/ogg"
                           class="w-full text-slate-500 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#0066B2]/10 file:text-[#0066B2] hover:file:bg-[#0066B2]/20 cursor-pointer border border-slate-200 rounded-xl p-2 bg-[#F4F7FC]">
                    
                    @if($profile->video_file_path)
                        <div class="mt-2 text-[11px] text-emerald-700 font-semibold flex items-center gap-2">
                            <span>&#10003; Berkas video sudah tersimpan:</span>
                            <span class="font-mono text-slate-600">{{ basename($profile->video_file_path) }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- KARTU 2: PENGELOLAAN SALURAN MEDIA SOSIAL RESMI -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm space-y-5">
            <div class="border-b border-slate-100 pb-3">
                <span class="text-[10px] font-bold text-emerald-600 uppercase tracking-wider block">Publikasi Digital</span>
                <h2 class="text-base font-extrabold text-[#0A2540]">Saluran Media Sosial Resmi</h2>
                <p class="text-slate-400 text-[11px] mt-0.5">Tautan yang diisi di sini akan otomatis tampil dan aktif pada bilah footer serta navigasi situs.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-slate-700 mb-1 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        WhatsApp Layanan / Hotline
                    </label>
                    <input type="text" name="whatsapp_hotline" value="{{ old('whatsapp_hotline', $profile->whatsapp_hotline) }}" 
                           placeholder="Contoh: 081234567890"
                           class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-2.5 focus:outline-none focus:border-[#0066B2] focus:bg-white transition font-mono text-slate-800">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                        URL Facebook Resmi
                    </label>
                    <input type="url" name="facebook_url" value="{{ old('facebook_url', $profile->facebook_url) }}" 
                           placeholder="https://facebook.com/bankdaerahlamongan"
                           class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-2.5 focus:outline-none focus:border-[#0066B2] focus:bg-white transition text-slate-800">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-pink-600"></span>
                        URL Instagram Resmi
                    </label>
                    <input type="url" name="instagram_url" value="{{ old('instagram_url', $profile->instagram_url) }}" 
                           placeholder="https://instagram.com/bankdaerahlamongan"
                           class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-2.5 focus:outline-none focus:border-[#0066B2] focus:bg-white transition text-slate-800">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-rose-600"></span>
                        URL YouTube Resmi
                    </label>
                    <input type="url" name="youtube_url" value="{{ old('youtube_url', $profile->youtube_url) }}" 
                           placeholder="https://youtube.com/@bankdaerahlamongan"
                           class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-2.5 focus:outline-none focus:border-[#0066B2] focus:bg-white transition text-slate-800">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-sky-700"></span>
                        URL LinkedIn Resmi
                    </label>
                    <input type="url" name="linkedin_url" value="{{ old('linkedin_url', $profile->linkedin_url) }}" 
                           placeholder="https://linkedin.com/company/bank-daerah-lamongan"
                           class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-2.5 focus:outline-none focus:border-[#0066B2] focus:bg-white transition text-slate-800">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-slate-900"></span>
                        URL TikTok Resmi
                    </label>
                    <input type="url" name="tiktok_url" value="{{ old('tiktok_url', $profile->tiktok_url) }}" 
                           placeholder="https://tiktok.com/@bankdaerahlamongan"
                           class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-2.5 focus:outline-none focus:border-[#0066B2] focus:bg-white transition text-slate-800">
                </div>
            </div>
        </div>

        <!-- KARTU 3: NARAHUBUNG MEDIA / HUBUNGAN MASYARAKAT (PERS & PELIPUTAN) -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm space-y-5">
            <div class="border-b border-slate-100 pb-3">
                <span class="text-[10px] font-bold text-amber-600 uppercase tracking-wider block">Media Relations & Humas</span>
                <h2 class="text-base font-extrabold text-[#0A2540]">Kontak Khusus Peliputan & Siaran Pers</h2>
                <p class="text-slate-400 text-[11px] mt-0.5">Kontak yang ditujukan bagi jurnalis, wartawan, atau media massa untuk konfirmasi siaran pers dan publikasi lembaga.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Nama PIC / Bagian Humas</label>
                    <input type="text" name="media_contact_person" value="{{ old('media_contact_person', $profile->media_contact_person) }}" 
                           placeholder="Contoh: Bagian Sekretariat & Humas"
                           class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-2.5 focus:outline-none focus:border-[#0066B2] focus:bg-white transition text-slate-800">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Telepon / WhatsApp Pers</label>
                    <input type="text" name="media_contact_phone" value="{{ old('media_contact_phone', $profile->media_contact_phone) }}" 
                           placeholder="Contoh: 0812-3456-7890"
                           class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-2.5 focus:outline-none focus:border-[#0066B2] focus:bg-white transition font-mono text-slate-800">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Email Khusus Media / Pers</label>
                    <input type="email" name="media_contact_email" value="{{ old('media_contact_email', $profile->media_contact_email) }}" 
                           placeholder="Contoh: humas@bdl.co.id"
                           class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-2.5 focus:outline-none focus:border-[#0066B2] focus:bg-white transition text-slate-800">
                </div>
            </div>
        </div>

        <!-- KARTU PENGELOLAAN BAGAN STRUKTUR ORGANISASI -->
<div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm space-y-5">
    <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
        <div>
            <span class="text-[10px] font-bold text-indigo-600 uppercase tracking-wider block">Tata Kelola & Regulasi (GCG)</span>
            <h2 class="text-base font-extrabold text-[#0A2540]">Bagan Struktur Organisasi Lembaga</h2>
            <p class="text-slate-400 text-[11px] mt-0.5">Unggah bagan alur komando, dasar hukum penetapan, dan catatan penataan organisasi bank.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label class="block font-bold text-slate-700 mb-1">Nomor Surat Keputusan / Dasar Penetapan</label>
            <input type="text" name="org_structure_decree" value="{{ old('org_structure_decree', $profile->org_structure_decree) }}" 
                   placeholder="Contoh: SK Direksi No. 018/SK/DIR/2026"
                   class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-2.5 focus:outline-none focus:border-[#0066B2] focus:bg-white transition text-slate-800 font-mono">
        </div>

        <div>
            <label class="block font-bold text-slate-700 mb-1">Tanggal Mulai Berlaku</label>
            <input type="date" name="org_structure_effective_date" 
                   value="{{ old('org_structure_effective_date', $profile->org_structure_effective_date ? \Carbon\Carbon::parse($profile->org_structure_effective_date)->format('Y-m-d') : '') }}" 
                   class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl px-3.5 py-2.5 focus:outline-none focus:border-[#0066B2] focus:bg-white transition font-mono text-slate-800">
        </div>

        <div class="sm:col-span-2">
            <label class="block font-bold text-slate-700 mb-1">Unggah Gambar Bagan Struktur Organisasi (JPG, PNG, WebP, SVG - Maks. 5 MB)</label>
            <input type="file" name="org_chart_image" accept="image/*"
                   class="w-full text-slate-500 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#0066B2]/10 file:text-[#0066B2] hover:file:bg-[#0066B2]/20 cursor-pointer border border-slate-200 rounded-xl p-2 bg-[#F4F7FC]">
            
            @if($profile->org_chart_image)
                <div class="mt-3 flex items-center justify-between p-3 bg-[#F4F7FC] rounded-2xl border border-slate-200 w-full sm:w-fit gap-4">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('storage/' . $profile->org_chart_image) }}" alt="Bagan Struktur Aktif" class="w-16 h-12 rounded-lg object-contain bg-white border border-slate-200 p-1">
                        <div>
                            <span class="text-xs font-bold text-slate-800 block">Bagan Struktur Aktif</span>
                            <span class="text-[10px] text-slate-400 font-mono">{{ basename($profile->org_chart_image) }}</span>
                        </div>
                    </div>
                    <a href="{{ asset('storage/' . $profile->org_chart_image) }}" target="_blank" class="text-xs font-bold text-[#0066B2] hover:underline whitespace-nowrap">
                        Buka Gambar Penuh &rarr;
                    </a>
                </div>
            @endif
        </div>

        <div class="sm:col-span-2">
            <label class="block font-bold text-slate-700 mb-1">Catatan Keterangan Struktur & Tata Hubungan Kerja</label>
            <textarea name="org_structure_notes" rows="3" 
                      placeholder="Uraikan pedoman penugasan, hubungan kerja antar satuan kerja kepatuhan, SKAI, dan komite dewan..."
                      class="w-full bg-[#F4F7FC] border border-slate-200 rounded-xl p-3.5 focus:outline-none focus:border-[#0066B2] focus:bg-white transition text-slate-800 leading-relaxed">{{ old('org_structure_notes', $profile->org_structure_notes) }}</textarea>
        </div>
    </div>
</div>

        <div class="flex items-center justify-end gap-3 pt-2">
            <button type="submit" class="px-7 py-3 bg-[#0066B2] hover:bg-[#0A2540] text-white text-xs font-bold rounded-xl transition shadow-md shadow-[#0066B2]/20">
                Simpan Seluruh Pengaturan Profil & Kontak Media
            </button>
        </div>
    </form>
    <script>
function toggleVideoSource(type) {
    const urlSec = document.getElementById('videoUrlSection');
    const upSec = document.getElementById('videoUploadSection');
    if (type === 'URL') {
        urlSec.classList.remove('hidden');
        upSec.classList.add('hidden');
    } else {
        urlSec.classList.add('hidden');
        upSec.classList.remove('hidden');
    }
}
</script>

</div>
@endsection