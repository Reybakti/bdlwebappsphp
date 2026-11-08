<footer class="bg-bdl-navy text-white pt-16 pb-8 border-t-4 border-bdl-primary">
    <div class="max-w-7xl mx-auto px-4 lg:px-8 space-y-12">
        
        <!-- 4 Kolom Utama -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-8 lg:gap-10 text-xs">
            
            <!-- Kolom 1: Identitas & Kantor Pusat -->
            <div class="lg:col-span-4 space-y-4">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('assets/images/logo-bdl.png') }}" 
                         alt="Logo {{ $companyProfile->name ?? 'Bank Daerah Lamongan' }}" 
                         class="h-11 w-auto bg-white/10 p-1.5 rounded-lg object-contain">
                    <div>
                        <h3 class="font-extrabold text-sm sm:text-base text-white leading-tight">
                            {{ $companyProfile->name ?? 'PT BPR Bank Daerah Lamongan (Perseroda)' }}
                        </h3>
                        <span class="text-[11px] text-bdl-soft font-medium tracking-wide">
                            Bank Perekonomian Rakyat Terpercaya
                        </span>
                    </div>
                </div>

                <div class="space-y-2.5 text-slate-300 leading-relaxed pt-1">
                    <p class="flex items-start gap-2">
                        <svg class="w-4 h-4 text-bdl-soft shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span>{{ $companyProfile->head_office_address ?? 'Jl. Panglima Sudirman No. 85, Sukorejo, Kec. Lamongan, Kab. Lamongan, Jawa Timur 62215' }}</span>
                    </p>
                    
                    <p class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-bdl-soft shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        <span>Telepon: <strong class="font-num text-white">{{ $companyProfile->phone ?? '(0322) 321175' }}</strong></span>
                    </p>

                    @php
                        $rawWa = $companyProfile->whatsapp_hotline ?? $companyProfile->phone ?? '081234567890';
                        $cleanWaFooter = preg_replace('/[^0-9]/', '', (string)$rawWa);
                        if (str_starts_with($cleanWaFooter, '0')) {
                            $cleanWaFooter = '62' . substr($cleanWaFooter, 1);
                        }
                    @endphp
                    @if(!empty($companyProfile->whatsapp_hotline))
                        <p class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                            <span>WhatsApp Hotline: <a href="https://wa.me/{{ $cleanWaFooter }}" target="_blank" rel="noopener noreferrer" class="font-num text-emerald-400 hover:underline">{{ $companyProfile->whatsapp_hotline }}</a></span>
                        </p>
                    @endif

                    <p class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-bdl-soft shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        <span>Email: <a href="mailto:{{ $companyProfile->email ?? 'sekretariat@bdl.co.id' }}" class="text-white hover:underline">{{ $companyProfile->email ?? 'sekretariat@bdl.co.id' }}</a></span>
                    </p>

                    <!-- Kontak Media / Humas (Jika Diisi di Admin) -->
                    @if(!empty($companyProfile->media_contact_email) || !empty($companyProfile->media_contact_phone))
                        <div class="mt-2.5 p-2.5 rounded-xl bg-white/5 border border-white/10 space-y-1 text-[11px]">
                            <span class="font-bold text-amber-300 block uppercase tracking-wider text-[10px]">
                                {{ $companyProfile->media_contact_person ?? 'Kontak Pers & Media Relations' }}
                            </span>
                            @if(!empty($companyProfile->media_contact_phone))
                                <div class="text-slate-300">
                                    <span>Telp/WA: </span>
                                    <span class="font-num text-white font-semibold">{{ $companyProfile->media_contact_phone }}</span>
                                </div>
                            @endif
                            @if(!empty($companyProfile->media_contact_email))
                                <div class="text-slate-300 truncate">
                                    <span>Email: </span>
                                    <a href="mailto:{{ $companyProfile->media_contact_email }}" class="text-bdl-soft hover:underline">
                                        {{ $companyProfile->media_contact_email }}
                                    </a>
                                </div>
                            @endif
                        </div>
                    @endif

                    <p class="flex items-center gap-2 pt-1 text-slate-400">
                        <svg class="w-4 h-4 text-bdl-soft shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Jam Operasional: Senin – Jumat (08.00 – 15.00 WIB)</span>
                    </p>
                </div>
            </div>

            <!-- Kolom 2: Produk & Layanan -->
            <div class="lg:col-span-3 space-y-3">
                <h4 class="font-bold text-bdl-soft uppercase tracking-wider text-xs border-b border-white/10 pb-2">
                    Produk & Layanan
                </h4>
                <ul class="space-y-2 text-slate-300">
                    <li><a href="{{ route('products.savings') }}" class="hover:text-white transition">Tabungan Umum & Simapan</a></li>
                    <li><a href="{{ route('products.savings') }}#persyaratan" class="hover:text-white transition">Simpanan Pelajar (SimPel)</a></li>
                    <li><a href="{{ route('products.deposit') }}" class="hover:text-white transition">Deposito Berjangka</a></li>
                    <li><a href="{{ route('products.loan') }}" class="hover:text-white transition">Kredit Modal Kerja & UMKM</a></li>
                    <li><a href="{{ route('products.loan') }}#persyaratan" class="hover:text-white transition">Kredit Multiguna / Konsumtif</a></li>
                    <li><a href="{{ route('home') }}#simulasi-section" class="hover:text-white text-bdl-soft font-semibold transition">Simulasi Kredit & Deposito</a></li>
                </ul>
            </div>

            <!-- Kolom 3: Kepatuhan & Transparansi -->
            <div class="lg:col-span-3 space-y-3">
                <h4 class="font-bold text-bdl-soft uppercase tracking-wider text-xs border-b border-white/10 pb-2">
                    Kepatuhan & Transparansi
                </h4>
                <ul class="space-y-2 text-slate-300">
                    <li><a href="{{ route('transparency.financial') }}" class="hover:text-white transition">Laporan Keuangan Publikasi</a></li>
                    <li><a href="{{ route('transparency.gcg') }}" class="hover:text-white transition">Laporan Tata Kelola (GCG)</a></li>
                    <li><a href="{{ route('transparency.lps') }}" class="hover:text-white transition">Tingkat Bunga Penjaminan LPS</a></li>
                    <li><a href="{{ route('transparency.riplay') }}" class="hover:text-white transition">Ringkasan Informasi Produk (RIPLAY)</a></li>
                    <li><a href="{{ route('services.complaint') }}" class="hover:text-white transition">Pengaduan Nasabah (POJK 22/2023)</a></li>
                    <li><a href="{{ route('services.wbs') }}" class="hover:text-white transition">Whistleblowing System (WBS)</a></li>
                    <li><a href="https://kontak157.ojk.go.id" target="_blank" rel="noopener noreferrer" class="hover:text-white transition inline-flex items-center gap-1">Portal APPK OJK <span class="text-[10px]">&#x2197;</span></a></li>
                </ul>
            </div>

            <!-- Kolom 4: Tautan Penting & Media Sosial -->
            <div class="lg:col-span-2 space-y-3">
                <h4 class="font-bold text-bdl-soft uppercase tracking-wider text-xs border-b border-white/10 pb-2">
                    Tautan Penting
                </h4>
                <ul class="space-y-2 text-slate-300 mb-4">
                    <li><a href="{{ route('about.management') }}" class="hover:text-white transition">Dewan Direksi & Komisaris</a></li>
                    <li><a href="{{ route('about.csr') }}" class="hover:text-white transition">Tanggung Jawab Sosial (CSR)</a></li>
                    <li><a href="{{ route('services.branches') }}" class="hover:text-white transition">Jaringan Kantor Pelayanan</a></li>
                    <li><a href="{{ route('media.news') }}" class="hover:text-white transition">Warta & Berita Terkini</a></li>
                    <li><a href="{{ route('media.education') }}" class="hover:text-white transition">Edukasi & Literasi Keuangan</a></li>
                    <li><a href="{{ route('media.announcements') }}" class="hover:text-white transition">Pengumuman & Lelang Agunan</a></li>
                    <li><a href="{{ route('services.career') }}" class="hover:text-white transition font-medium text-bdl-soft">Karier & Rekrutmen</a></li>
                </ul>

                <!-- Ikon Media Sosial Resmi Dinamis dari Database -->
                <div class="pt-2">
                    <span class="text-[11px] text-slate-400 block mb-2 font-medium">Ikuti Saluran Resmi:</span>
                    <div class="flex flex-wrap items-center gap-2">
                        @if(!empty($companyProfile->facebook_url))
                            <a href="{{ $companyProfile->facebook_url }}" target="_blank" rel="noopener noreferrer" aria-label="Facebook BDL" class="w-8 h-8 rounded-lg bg-white/10 hover:bg-bdl-primary flex items-center justify-center text-white transition" title="Facebook">
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                            </a>
                        @endif

                        @if(!empty($companyProfile->instagram_url))
                            <a href="{{ $companyProfile->instagram_url }}" target="_blank" rel="noopener noreferrer" aria-label="Instagram BDL" class="w-8 h-8 rounded-lg bg-white/10 hover:bg-bdl-primary flex items-center justify-center text-white transition" title="Instagram">
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                            </a>
                        @endif

                        @if(!empty($companyProfile->youtube_url))
                            <a href="{{ $companyProfile->youtube_url }}" target="_blank" rel="noopener noreferrer" aria-label="YouTube BDL" class="w-8 h-8 rounded-lg bg-white/10 hover:bg-bdl-primary flex items-center justify-center text-white transition" title="YouTube">
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                            </a>
                        @endif

                        @if(!empty($companyProfile->linkedin_url))
                            <a href="{{ $companyProfile->linkedin_url }}" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn BDL" class="w-8 h-8 rounded-lg bg-white/10 hover:bg-bdl-primary flex items-center justify-center text-white transition" title="LinkedIn">
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                            </a>
                        @endif

                        @if(!empty($companyProfile->tiktok_url))
                            <a href="{{ $companyProfile->tiktok_url }}" target="_blank" rel="noopener noreferrer" aria-label="TikTok BDL" class="w-8 h-8 rounded-lg bg-white/10 hover:bg-bdl-primary flex items-center justify-center text-white transition" title="TikTok">
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.24 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/></svg>
                            </a>
                        @endif
                    </div>
                </div>
            </div>

        </div>

        <!-- 5. Bar Kepatuhan Regulasi (Mandatory Compliance Bar) -->
        <div class="bg-white/5 border border-white/10 rounded-2xl p-4 sm:p-5">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                <!-- Logo Berdampingan OJK & LPS -->
                <div class="flex items-center gap-4 bg-white px-4 py-2 rounded-xl shadow-sm shrink-0">
                    <img src="{{ asset('assets/images/logo-ojk.png') }}" 
                         alt="Otoritas Jasa Keuangan" 
                         class="h-7 w-auto object-contain">
                    <span class="text-slate-300 font-bold">|</span>
                    <img src="{{ asset('assets/images/logo-lps.png') }}" 
                         alt="Lembaga Penjamin Simpanan" 
                         class="h-7 w-auto object-contain">
                </div>

                <!-- Teks Pernyataan Regulasi -->
                <p class="text-xs text-slate-300 text-center md:text-left leading-relaxed">
                    {{ $companyProfile->ojk_lps_statement ?? 'PT BPR Bank Daerah Lamongan (Perseroda) berizin dan diawasi oleh Otoritas Jasa Keuangan (OJK) serta merupakan peserta penjaminan Lembaga Penjamin Simpanan (LPS).' }}
                </p>
            </div>
        </div>

        <!-- 6. Sub-Footer (Bottom Bar) -->
        <div class="pt-6 border-t border-white/10 flex flex-col sm:flex-row items-center justify-between gap-4 text-[11px] text-slate-400">
            <div>
                &copy; {{ date('Y') }} {{ $companyProfile->name ?? 'PT BPR Bank Daerah Lamongan (Perseroda)' }}. Seluruh Hak Cipta Dilindungi.
            </div>
            
            <div class="flex flex-wrap items-center gap-4 text-slate-300 font-medium">
                <a href="{{ route('home') }}#kebijakan-privasi" class="hover:text-white transition">Kebijakan Privasi (UU PDP)</a>
                <span class="text-white/20">•</span>
                <a href="{{ route('home') }}#syarat-ketentuan" class="hover:text-white transition">Syarat & Ketentuan</a>
                <span class="text-white/20">•</span>
                <a href="{{ route('home') }}#peta-situs" class="hover:text-white transition">Peta Situs (Sitemap)</a>
            </div>
        </div>

    </div>
</footer>