<?php

namespace Modules\Survey\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TracerStudyQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // First create a default tracer study session
        $sessionId = DB::table('tracer_study_sessions')->insertGetId([
            'year' => 2024,
            'start_date' => '2024-01-01',
            'end_date' => '2024-12-31',
            'description' => 'Tracer Study Alumni 2024 - Standar BAN-PT',
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $questions = [
            // A. Data Alumni
            [
                'question_text' => 'Nama Lengkap',
                'question_type' => 'text',
                'display_order' => 1,
                'is_required' => true,
            ],
            [
                'question_text' => 'NIM',
                'question_type' => 'text',
                'display_order' => 2,
                'is_required' => true,
            ],
            [
                'question_text' => 'Tahun Lulus',
                'question_type' => 'select',
                'display_order' => 3,
                'is_required' => true,
            ],
            [
                'question_text' => 'IPK',
                'question_type' => 'text',
                'display_order' => 4,
                'is_required' => true,
                'validation_rules' => json_encode(['numeric', 'min:0', 'max:4']),
            ],

            // B. Riwayat Pendidikan
            [
                'question_text' => 'Apakah anda melanjutkan studi setelah lulus?',
                'question_type' => 'radio',
                'display_order' => 5,
                'is_required' => true,
            ],
            [
                'question_text' => 'Jika ya, jenjang pendidikan yang sedang/telah ditempuh',
                'question_type' => 'select',
                'display_order' => 6,
                'is_required' => false,
            ],

            // C. Riwayat Pekerjaan
            [
                'question_text' => 'Berapa lama waktu tunggu Anda untuk memperoleh pekerjaan pertama? (dalam bulan)',
                'question_type' => 'text',
                'display_order' => 7,
                'is_required' => true,
                'validation_rules' => json_encode(['numeric', 'min:0']),
            ],
            [
                'question_text' => 'Bagaimana Anda mencari pekerjaan pertama?',
                'question_type' => 'checkbox',
                'display_order' => 8,
                'is_required' => true,
            ],
            [
                'question_text' => 'Berapa rata-rata pendapatan Anda per bulan? (dalam rupiah)',
                'question_type' => 'select',
                'display_order' => 9,
                'is_required' => true,
            ],
            [
                'question_text' => 'Dimana lokasi tempat Anda bekerja?',
                'question_type' => 'text',
                'display_order' => 10,
                'is_required' => true,
            ],
            [
                'question_text' => 'Apa jenis perusahaan/instansi/institusi tempat Anda bekerja sekarang?',
                'question_type' => 'radio',
                'display_order' => 11,
                'is_required' => true,
            ],
            [
                'question_text' => 'Kira-kira berapa besar perusahaan/instansi/institusi tempat Anda bekerja?',
                'question_type' => 'radio',
                'display_order' => 12,
                'is_required' => true,
            ],

            // D. Kompetensi
            [
                'question_text' => 'Pada saat lulus, pada tingkat mana kompetensi di bawah ini Anda kuasai? - Etika',
                'question_type' => 'rating',
                'display_order' => 13,
                'is_required' => true,
            ],
            [
                'question_text' => 'Pada saat lulus, pada tingkat mana kompetensi di bawah ini Anda kuasai? - Keahlian berdasarkan bidang ilmu',
                'question_type' => 'rating',
                'display_order' => 14,
                'is_required' => true,
            ],
            [
                'question_text' => 'Pada saat lulus, pada tingkat mana kompetensi di bawah ini Anda kuasai? - Bahasa Inggris',
                'question_type' => 'rating',
                'display_order' => 15,
                'is_required' => true,
            ],
            [
                'question_text' => 'Pada saat lulus, pada tingkat mana kompetensi di bawah ini Anda kuasai? - Penggunaan teknologi informasi',
                'question_type' => 'rating',
                'display_order' => 16,
                'is_required' => true,
            ],
            [
                'question_text' => 'Pada saat lulus, pada tingkat mana kompetensi di bawah ini Anda kuasai? - Komunikasi',
                'question_type' => 'rating',
                'display_order' => 17,
                'is_required' => true,
            ],
            [
                'question_text' => 'Pada saat lulus, pada tingkat mana kompetensi di bawah ini Anda kuasai? - Kerjasama tim',
                'question_type' => 'rating',
                'display_order' => 18,
                'is_required' => true,
            ],
            [
                'question_text' => 'Pada saat lulus, pada tingkat mana kompetensi di bawah ini Anda kuasai? - Pengembangan diri',
                'question_type' => 'rating',
                'display_order' => 19,
                'is_required' => true,
            ],

            // E. Relevansi Pendidikan dengan Pekerjaan
            [
                'question_text' => 'Seberapa erat hubungan antara bidang studi dengan pekerjaan Anda?',
                'question_type' => 'radio',
                'display_order' => 20,
                'is_required' => true,
            ],
            [
                'question_text' => 'Tingkat pendidikan apa yang paling tepat/sesuai untuk pekerjaan Anda saat ini?',
                'question_type' => 'radio',
                'display_order' => 21,
                'is_required' => true,
            ],

            // F. Saran dan Kritik
            [
                'question_text' => 'Saran untuk pengembangan kurikulum program studi',
                'question_type' => 'textarea',
                'display_order' => 22,
                'is_required' => false,
            ],
            [
                'question_text' => 'Saran untuk pengembangan fasilitas dan sarana pembelajaran',
                'question_type' => 'textarea',
                'display_order' => 23,
                'is_required' => false,
            ],
        ];

        foreach ($questions as $question) {
            $questionId = DB::table('survey_questions')->insertGetId([
                'session_id' => $sessionId,
                'question_text' => $question['question_text'],
                'question_type' => $question['question_type'],
                'display_order' => $question['display_order'],
                'is_required' => $question['is_required'],
                'validation_rules' => $question['validation_rules'] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Add options for specific questions
            if ($question['question_type'] === 'radio' || $question['question_type'] === 'select' || $question['question_type'] === 'checkbox') {
                $this->addOptionsForQuestion($questionId, $question['display_order']);
            }
        }
    }

    private function addOptionsForQuestion($questionId, $displayOrder)
    {
        $options = [];

        switch ($displayOrder) {
            case 3: // Tahun Lulus
                $options = [
                    ['option_text' => '2020', 'weight' => 0, 'display_order' => 1],
                    ['option_text' => '2021', 'weight' => 0, 'display_order' => 2],
                    ['option_text' => '2022', 'weight' => 0, 'display_order' => 3],
                    ['option_text' => '2023', 'weight' => 0, 'display_order' => 4],
                    ['option_text' => '2024', 'weight' => 0, 'display_order' => 5],
                ];
                break;

            case 5: // Melanjutkan studi
                $options = [
                    ['option_text' => 'Ya', 'weight' => 1, 'display_order' => 1],
                    ['option_text' => 'Tidak', 'weight' => 0, 'display_order' => 2],
                ];
                break;

            case 6: // Jenjang pendidikan lanjutan
                $options = [
                    ['option_text' => 'S2', 'weight' => 0, 'display_order' => 1],
                    ['option_text' => 'S3', 'weight' => 0, 'display_order' => 2],
                    ['option_text' => 'Profesi', 'weight' => 0, 'display_order' => 3],
                ];
                break;

            case 8: // Cara mencari pekerjaan
                $options = [
                    ['option_text' => 'Melalui iklan di koran/majalah/internet', 'weight' => 0, 'display_order' => 1],
                    ['option_text' => 'Melamar ke perusahaan tanpa mengetahui lowongan yang ada', 'weight' => 0, 'display_order' => 2],
                    ['option_text' => 'Pergi ke bursa/pameran kerja', 'weight' => 0, 'display_order' => 3],
                    ['option_text' => 'Mencari lewat internet/iklan online/situs web', 'weight' => 0, 'display_order' => 4],
                    ['option_text' => 'Dihubungi oleh perusahaan', 'weight' => 0, 'display_order' => 5],
                    ['option_text' => 'Menghubungi Kemenakertrans', 'weight' => 0, 'display_order' => 6],
                    ['option_text' => 'Melalui relasi (saudara, teman, dll)', 'weight' => 0, 'display_order' => 7],
                    ['option_text' => 'Membangun bisnis sendiri', 'weight' => 0, 'display_order' => 8],
                    ['option_text' => 'Melalui penempatan kerja atau magang', 'weight' => 0, 'display_order' => 9],
                ];
                break;

            case 9: // Rata-rata pendapatan
                $options = [
                    ['option_text' => 'Di bawah 2 juta', 'weight' => 1, 'display_order' => 1],
                    ['option_text' => '2 - 4 juta', 'weight' => 2, 'display_order' => 2],
                    ['option_text' => '4 - 6 juta', 'weight' => 3, 'display_order' => 3],
                    ['option_text' => '6 - 8 juta', 'weight' => 4, 'display_order' => 4],
                    ['option_text' => '8 - 10 juta', 'weight' => 5, 'display_order' => 5],
                    ['option_text' => 'Di atas 10 juta', 'weight' => 6, 'display_order' => 6],
                ];
                break;

            case 11: // Jenis perusahaan
                $options = [
                    ['option_text' => 'Instansi pemerintah', 'weight' => 0, 'display_order' => 1],
                    ['option_text' => 'Organisasi non-profit/Lembaga Swadaya Masyarakat', 'weight' => 0, 'display_order' => 2],
                    ['option_text' => 'Perusahaan swasta', 'weight' => 0, 'display_order' => 3],
                    ['option_text' => 'Wiraswasta/perusahaan sendiri', 'weight' => 0, 'display_order' => 4],
                    ['option_text' => 'BUMN/BUMD', 'weight' => 0, 'display_order' => 5],
                ];
                break;

            case 12: // Ukuran perusahaan
                $options = [
                    ['option_text' => 'Kurang dari 15 orang', 'weight' => 1, 'display_order' => 1],
                    ['option_text' => '15-75 orang', 'weight' => 2, 'display_order' => 2],
                    ['option_text' => '76-300 orang', 'weight' => 3, 'display_order' => 3],
                    ['option_text' => 'Lebih dari 300 orang', 'weight' => 4, 'display_order' => 4],
                ];
                break;

            case 20: // Hubungan bidang studi dengan pekerjaan
                $options = [
                    ['option_text' => 'Sangat erat', 'weight' => 5, 'display_order' => 1],
                    ['option_text' => 'Erat', 'weight' => 4, 'display_order' => 2],
                    ['option_text' => 'Cukup erat', 'weight' => 3, 'display_order' => 3],
                    ['option_text' => 'Kurang erat', 'weight' => 2, 'display_order' => 4],
                    ['option_text' => 'Tidak sama sekali', 'weight' => 1, 'display_order' => 5],
                ];
                break;

            case 21: // Tingkat pendidikan yang sesuai
                $options = [
                    ['option_text' => 'Setingkat lebih tinggi', 'weight' => 3, 'display_order' => 1],
                    ['option_text' => 'Tingkat yang sama', 'weight' => 2, 'display_order' => 2],
                    ['option_text' => 'Setingkat lebih rendah', 'weight' => 1, 'display_order' => 3],
                    ['option_text' => 'Tidak perlu pendidikan tinggi', 'weight' => 0, 'display_order' => 4],
                ];
                break;
        }

        foreach ($options as $option) {
            DB::table('survey_options')->insert([
                'question_id' => $questionId,
                'option_text' => $option['option_text'],
                'weight' => $option['weight'],
                'display_order' => $option['display_order'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
