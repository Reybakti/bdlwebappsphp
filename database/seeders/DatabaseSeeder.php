<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\Banner;
use App\Models\Branch;
use App\Models\CareerPosting;
use App\Models\CompanyProfile;
use App\Models\CustomerComplaint;
use App\Models\FinancialReport;
use App\Models\LpsInterestRate;
use App\Models\ManagementMember;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductSimulationParam;
use App\Models\Role;
use App\Models\User;
use App\Models\WbsReport;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ==========================================
        // 1. Roles & Users (RBAC)
        // ==========================================
        $superAdminRole = Role::firstOrCreate(
            ['name' => 'super_admin'],
            ['description' => 'Administrator Utama Sistem & IT']
        );
        $editorRole = Role::firstOrCreate(
            ['name' => 'content_editor'],
            ['description' => 'Admin Pemasaran, Berita & Media']
        );
        $complianceRole = Role::firstOrCreate(
            ['name' => 'compliance_officer'],
            ['description' => 'Admin Kepatuhan, Pengaduan, WBS & Regulasi']
        );

        $adminUser = User::firstOrCreate(
            ['email' => 'admin@bdl.co.id'],
            [
                'role_id' => $superAdminRole->id,
                'name' => 'Super Administrator BDL',
                'password' => Hash::make('AdminBDL2026!'),
                'is_active' => true,
            ]
        );

        $complianceUser = User::firstOrCreate(
            ['email' => 'kepatuhan@bdl.co.id'],
            [
                'role_id' => $complianceRole->id,
                'name' => 'Satuan Kerja Kepatuhan',
                'password' => Hash::make('KepatuhanBDL2026!'),
                'is_active' => true,
            ]
        );

        // ==========================================
        // 2. Profil Lembaga & Legalitas Statis
        // ==========================================
        CompanyProfile::updateOrCreate(
            ['id' => 1],
            [
                'name' => 'PT BPR Bank Daerah Lamongan (Perseroda)',
                'history' => 'PT BPR Bank Daerah Lamongan (Perseroda) merupakan Badan Usaha Milik Daerah (BUMD) Pemerintah Kabupaten Lamongan yang bertransformasi menjadi mitra perbankan andal bagi pertumbuhan ekonomi daerah dan pemberdayaan UMKM.',
                'vision' => 'Menjadi Bank Perekonomian Rakyat yang sehat, mandiri, berdaya saing tinggi, dan menjadi pilar utama inklusi keuangan di Kabupaten Lamongan.',
                'mission' => 'Memberikan layanan keuangan yang transparan, mudah, dan aman serta berkontribusi nyata pada pendapatan asli daerah (PAD) dan kesejahteraan masyarakat Lamongan.',
                'phone' => '(0322) 321175',
                'email' => 'sekretariat@bdl.co.id',
                'head_office_address' => 'Jl. Panglima Sudirman No. 85, Sukorejo, Kec. Lamongan, Kabupaten Lamongan, Jawa Timur 62215',
                'ojk_lps_statement' => 'PT BPR Bank Daerah Lamongan (Perseroda) berizin dan diawasi oleh Otoritas Jasa Keuangan (OJK) serta merupakan peserta penjaminan Lembaga Penjamin Simpanan (LPS).',
            ]
        );

        // ==========================================
        // 3. Dewan Direksi & Komisaris
        // ==========================================
        $managementData = [
            [
                'name' => 'Drs. H. Moh. Nalikan, M.M.',
                'title' => 'Komisaris Utama',
                'type' => 'COMMISSIONER',
                'photo_url' => 'assets/images/management/komisaris-utama.jpg',
                'bio' => 'Berpengalaman luas dalam tata kelola birokrasi pemerintahan daerah dan kepatuhan regulasi BUMD.',
                'order_index' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Dra. Hj. Farida Rahmawati, M.M.',
                'title' => 'Komisaris',
                'type' => 'COMMISSIONER',
                'photo_url' => 'assets/images/management/komisaris.jpg',
                'bio' => 'Praktisi pengawasan tata kelola perusahaan perbankan dan manajemen risiko.',
                'order_index' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Drs. H. Suhartono, M.Si.',
                'title' => 'Direktur Utama',
                'type' => 'DIRECTOR',
                'photo_url' => 'assets/images/management/direktur-utama.jpg',
                'bio' => 'Memimpin transformasi bisnis perbankan, percepatan digitalisasi operasional, dan perluasan portofolio pembiayaan UMKM BDL.',
                'order_index' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Agus Harianto, S.E., M.M.',
                'title' => 'Direktur Operasional & Kepatuhan',
                'type' => 'DIRECTOR',
                'photo_url' => 'assets/images/management/direktur-operasional.jpg',
                'bio' => 'Membawahi bidang kepatuhan regulasi OJK/LPS, audit internal, operasional perbankan cabang, dan manajemen risiko teknologi informasi.',
                'order_index' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($managementData as $member) {
            ManagementMember::firstOrCreate(['name' => $member['name']], $member);
        }

        // ==========================================
        // 4. Jaringan Kantor Cabang & Kas
        // ==========================================
        $branchData = [
            [
                'name' => 'Kantor Pusat Lamongan',
                'type' => 'HEAD_OFFICE',
                'address' => 'Jl. Panglima Sudirman No. 85, Sukorejo, Kec. Lamongan, Kab. Lamongan',
                'phone' => '(0322) 321175',
                'whatsapp' => '081234567890',
                'latitude' => -7.11985400,
                'longitude' => 112.41432100,
                'google_maps_url' => 'https://maps.google.com/?q=-7.119854,112.414321',
                'is_active' => true,
            ],
            [
                'name' => 'Kantor Cabang Babat',
                'type' => 'BRANCH',
                'address' => 'Jl. Raya Babat - Surabaya No. 120, Kec. Babat, Kab. Lamongan',
                'phone' => '(0322) 451230',
                'whatsapp' => '081234567891',
                'latitude' => -7.11452100,
                'longitude' => 112.16321400,
                'google_maps_url' => 'https://maps.google.com/?q=-7.114521,112.163214',
                'is_active' => true,
            ],
            [
                'name' => 'Kantor Cabang Ngimbang',
                'type' => 'BRANCH',
                'address' => 'Jl. Babat - Jombang No. 45, Kec. Ngimbang, Kab. Lamongan',
                'phone' => '(0322) 456781',
                'whatsapp' => '081234567892',
                'latitude' => -7.26123000,
                'longitude' => 112.24152000,
                'google_maps_url' => 'https://maps.google.com/?q=-7.261230,112.241520',
                'is_active' => true,
            ],
            [
                'name' => 'Kantor Kas Karanggeneng',
                'type' => 'CASH_OFFICE',
                'address' => 'Pasar Karanggeneng Blok A No. 3, Kec. Karanggeneng, Kab. Lamongan',
                'phone' => '(0322) 332145',
                'whatsapp' => '081234567893',
                'latitude' => -7.02145200,
                'longitude' => 112.38125400,
                'google_maps_url' => 'https://maps.google.com/?q=-7.021452,112.381254',
                'is_active' => true,
            ],
        ];

        foreach ($branchData as $branch) {
            Branch::firstOrCreate(['name' => $branch['name']], $branch);
        }

        // ==========================================
        // 5. Banner Slider Beranda
        // ==========================================
        $banners = [
            [
                'title' => 'Tumbuh Bersama Bank Daerah Lamongan',
                'subtitle' => 'Solusi permodalan usaha UMKM dan simpanan aman terpercaya yang dijamin LPS.',
                'image_desktop_url' => 'assets/images/banners/banner-1-desktop.webp',
                'image_mobile_url' => 'assets/images/banners/banner-1-mobile.webp',
                'button_text' => 'Simulasi Kredit',
                'button_url' => '/produk/kredit',
                'order_index' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Deposito Berjangka BDL: Imbal Hasil Maksimal',
                'subtitle' => 'Bunga kompetitif dengan penjaminan penuh sesuai Tingkat Bunga Penjaminan LPS.',
                'image_desktop_url' => 'assets/images/banners/banner-2-desktop.webp',
                'image_mobile_url' => 'assets/images/banners/banner-2-mobile.webp',
                'button_text' => 'Hitung Deposito',
                'button_url' => '/produk/deposito',
                'order_index' => 2,
                'is_active' => true,
            ],
        ];

        foreach ($banners as $banner) {
            Banner::firstOrCreate(['title' => $banner['title']], $banner);
        }

        // ==========================================
        // 6. Kategori Produk, Produk, & Parameter Simulasi
        // ==========================================
        $catTabungan = ProductCategory::firstOrCreate(
            ['slug' => 'tabungan'],
            ['name' => 'Tabungan']
        );
        $catDeposito = ProductCategory::firstOrCreate(
            ['slug' => 'deposito'],
            ['name' => 'Deposito']
        );
        $catKredit = ProductCategory::firstOrCreate(
            ['slug' => 'kredit'],
            ['name' => 'Kredit']
        );

        // Produk 1: Tabungan SIMAPAN
        Product::firstOrCreate(
            ['slug' => 'tabungan-simapan'],
            [
                'category_id' => $catTabungan->id,
                'name' => 'Tabungan SIMAPAN (Simpanan Masa Depan)',
                'short_description' => 'Tabungan fleksibel dengan setoran awal ringan dan bebas biaya administrasi bulanan.',
                'full_description' => 'Tabungan SIMAPAN dirancang untuk masyarakat Lamongan yang menginginkan kemudahan menabung harian dengan bunga simpanan harian yang kompetitif.',
                'terms_and_conditions' => "1. Fotokopi KTP/e-KTP yang masih berlaku.\n2. Setoran awal minimal Rp20.000,-.\n3. Saldo minimum mengendap Rp10.000,-.",
                'riplay_file_url' => 'documents/riplay/riplay-tabungan-simapan.pdf',
                'is_featured' => true,
                'is_active' => true,
            ]
        );

        // Produk 2: Deposito Berjangka
        $prodDeposito = Product::firstOrCreate(
            ['slug' => 'deposito-berjangka-bdl'],
            [
                'category_id' => $catDeposito->id,
                'name' => 'Deposito Berjangka BDL',
                'short_description' => 'Investasi berjangka dengan bunga optimal hingga 6.75% p.a. yang aman dan dijamin LPS.',
                'full_description' => 'Pilihan penempatan dana jangka pendek hingga menengah dengan tenor 1, 3, 6, dan 12 bulan yang aman dengan jaminan LPS.',
                'terms_and_conditions' => "1. Fotokopi identitas diri (KTP/SIM/Paspor).\n2. Penempatan nominal minimal Rp1.000.000,-.\n3. Pajak bunga 20% berlaku untuk nominal penempatan di atas Rp7.500.000,-.",
                'riplay_file_url' => 'documents/riplay/riplay-deposito-berjangka.pdf',
                'is_featured' => true,
                'is_active' => true,
            ]
        );

        ProductSimulationParam::updateOrCreate(
            ['product_id' => $prodDeposito->id],
            [
                'min_amount' => 1000000.00,
                'max_amount' => 2000000000.00,
                'min_tenor_months' => 1,
                'max_tenor_months' => 12,
                'base_interest_rate_pa' => 6.75,
                'interest_type' => 'FLAT',
                'provision_fee_percent' => 0.00,
                'admin_fee_amount' => 0.00,
            ]
        );

        // Produk 3: Kredit Modal Kerja UMKM
        $prodKredit = Product::firstOrCreate(
            ['slug' => 'kredit-modal-kerja-umkm'],
            [
                'category_id' => $catKredit->id,
                'name' => 'Kredit Modal Kerja UMKM',
                'short_description' => 'Pembiayaan ekspansi usaha mikro, kecil, dan menengah dengan proses cepat dan angsuran fleksibel.',
                'full_description' => 'Fasilitas kredit modal kerja dengan skema suku bunga flat bersaing, ditujukan untuk pedagang pasar, peternak, petani tambak, dan wirausaha di Kabupaten Lamongan.',
                'terms_and_conditions' => "1. Fotokopi KTP Pemohon & Pasangan, KK, dan Surat Nikah.\n2. Surat Izin Usaha / NIB / Surat Keterangan Usaha (SKU) dari Desa.\n3. Agunan berupa SHM, SHGB, atau BPKB Kendaraan Bermotor.\n4. Usaha telah berjalan aktif minimal 1 tahun.",
                'riplay_file_url' => 'documents/riplay/riplay-kredit-umkm.pdf',
                'is_featured' => true,
                'is_active' => true,
            ]
        );

        ProductSimulationParam::updateOrCreate(
            ['product_id' => $prodKredit->id],
            [
                'min_amount' => 5000000.00,
                'max_amount' => 500000000.00,
                'min_tenor_months' => 6,
                'max_tenor_months' => 60,
                'base_interest_rate_pa' => 10.50,
                'interest_type' => 'FLAT',
                'provision_fee_percent' => 1.00,
                'admin_fee_amount' => 150000.00,
            ]
        );

        // ==========================================
        // 7. Suku Bunga Penjaminan LPS Aktif
        // ==========================================
        LpsInterestRate::firstOrCreate(
            ['rate_idr' => 6.75, 'effective_start_date' => '2026-10-01'],
            [
                'rate_valas' => 0.00,
                'effective_end_date' => '2027-01-31',
                'is_current' => true,
            ]
        );

        // ==========================================
        // 8. Kategori & Artikel Berita
        // ==========================================
        $catBerita = ArticleCategory::firstOrCreate(
            ['slug' => 'berita-perusahaan'],
            ['name' => 'Berita Perusahaan']
        );
        $catEdukasi = ArticleCategory::firstOrCreate(
            ['slug' => 'literasi-keuangan'],
            ['name' => 'Literasi Keuangan']
        );
        ArticleCategory::firstOrCreate(
            ['slug' => 'lelang-agunan'],
            ['name' => 'Lelang Agunan']
        );

        Article::firstOrCreate(
            ['slug' => 'bpr-bank-daerah-lamongan-dorong-digitalisasi-umkm-daerah'],
            [
                'category_id' => $catBerita->id,
                'author_id' => $adminUser->id,
                'title' => 'BPR Bank Daerah Lamongan Dorong Digitalisasi Layanan untuk UMKM Daerah',
                'thumbnail_url' => 'assets/images/articles/berita-digitalisasi.webp',
                'content' => '<p>PT BPR Bank Daerah Lamongan (Perseroda) terus memperkuat komitmen pendampingan kepada pelaku UMKM di Kabupaten Lamongan melalui penyediaan kalkulator simulasi pembiayaan transparan dan layanan aduan konsumen terpadu berbasis web.</p>',
                'status' => 'PUBLISHED',
                'published_at' => now(),
                'views_count' => 128,
            ]
        );

        Article::firstOrCreate(
            ['slug' => 'tips-aman-menghindari-penipuan-berkedok-pinjaman-online-ilegal'],
            [
                'category_id' => $catEdukasi->id,
                'author_id' => $adminUser->id,
                'title' => 'Tips Aman Mengenali dan Menghindari Bahaya Pinjol Ilegal',
                'thumbnail_url' => 'assets/images/articles/edukasi-literasi.webp',
                'content' => '<p>Masyarakat dihimbau untuk selalu memeriksa legalitas lembaga pembiayaan di situs resmi OJK dan memastikan bahwa suku bunga penjaminan simpanan mematuhi batas maksimum yang ditetapkan LPS.</p>',
                'status' => 'PUBLISHED',
                'published_at' => now(),
                'views_count' => 245,
            ]
        );

        // ==========================================
        // 9. Laporan Keuangan Wajib & GCG (Transparansi)
        // ==========================================
        FinancialReport::firstOrCreate(
            ['title' => 'Laporan Keuangan Publikasi Triwulan II 2026'],
            [
                'created_by' => $complianceUser->id,
                'year' => 2026,
                'type' => 'TRIWULAN_2',
                'file_url' => 'documents/reports/laporan-keuangan-tw2-2026.pdf',
                'published_at' => '2026-07-31',
            ]
        );

        FinancialReport::firstOrCreate(
            ['title' => 'Laporan Pelaksanaan Good Corporate Governance (GCG) 2025'],
            [
                'created_by' => $complianceUser->id,
                'year' => 2025,
                'type' => 'GCG',
                'file_url' => 'documents/reports/laporan-gcg-2025.pdf',
                'published_at' => '2026-04-15',
            ]
        );

        // ==========================================
        // 10. Karier / Rekrutmen Pegawai
        // ==========================================
        CareerPosting::firstOrCreate(
            ['slug' => 'account-officer-umkm-2026'],
            [
                'title' => 'Account Officer (AO) Pembiayaan UMKM',
                'description' => 'Menganalisis kelayakan kredit usaha mikro dan menjalin kemitraan strategis dengan sentra UMKM di wilayah Babat dan Ngimbang.',
                'requirements' => "1. Pendidikan minimal D3/S1 semua jurusan.\n2. Memiliki integritas tinggi dan kemampuan komunikasi persuasif.\n3. Memiliki kendaraan bermotor dan SIM C.\n4. Berdomisili di Kabupaten Lamongan atau sekitarnya.",
                'deadline' => '2026-12-31',
                'is_active' => true,
            ]
        );

        // ==========================================
        // 11. Contoh Tiket Pengaduan Nasabah (POJK 22/2023)
        // ==========================================
        CustomerComplaint::firstOrCreate(
            ['ticket_code' => 'BDL-20261103-0001'],
            [
                'handled_by' => $complianceUser->id,
                'full_name' => 'Bambang Sugiarto',
                'nik' => '3524011203850001',
                'phone' => '081298765432',
                'email' => 'bambang.sugiarto@gmail.com',
                'account_number' => '1001-2024-00918',
                'category' => 'Layanan Tabungan',
                'description' => 'Buku tabungan belum tercetak otomatis pada transaksi tanggal 2 November 2026 di kantor kas.',
                'attachment_url' => null,
                'status' => 'IN_REVIEW',
                'resolution_notes' => 'Petugas CS telah mengonfirmasi dan menjadwalkan pencetakan ulang buku tabungan di Kantor Pusat.',
                'resolved_at' => null,
            ]
        );

        // ==========================================
        // 12. Contoh Rekam Whistleblowing System (WBS)
        // ==========================================
        WbsReport::firstOrCreate(
            ['tracking_code' => 'WBS-2026-X8Y9Z1A2'],
            [
                'reporter_name' => null, // Pelaporan anonim
                'reporter_contact' => null,
                'incident_type' => 'Benturan Kepentingan',
                'reported_person' => 'Bagian Logistik & Pengadaan',
                'incident_date' => '2026-10-25',
                'incident_location' => 'Kantor Cabang Babat',
                'description' => 'Dugaan ketidaksesuaian prosedur pengadaan perlengkapan kantor cabang yang tidak melalui komite pengadaan.',
                'evidence_file_url' => null,
                'status' => 'RECEIVED',
            ]
        );
    }
}