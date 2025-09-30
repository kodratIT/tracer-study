<?php

namespace App\Filament\Resources\Alumnis\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Repeater;

class AlumniForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // SECTION 1: PROFIL (Profile Information)
                Section::make('👤 Informasi Profil Alumni')
                    ->description('Data pribadi dan informasi dasar alumni')
                    ->icon('heroicon-m-user-circle')
                    ->columns(3)
                    ->schema([
                        TextInput::make('student_id')
                            ->label('Student ID / NIM')
                            ->placeholder('Masukkan Student ID')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(20)
                            ->columnSpan(1),
                            
                        TextInput::make('name')
                            ->label('Nama Lengkap')
                            ->placeholder('Masukkan nama lengkap alumni')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(1),
                            
                        TextInput::make('email')
                            ->label('Alamat Email')
                            ->placeholder('contoh@email.com')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->columnSpan(1),
                            
                        TextInput::make('phone')
                            ->label('Nomor Telepon')
                            ->placeholder('+62 812-3456-7890')
                            ->tel()
                            ->maxLength(20)
                            ->columnSpan(1),
                            
                        Select::make('gender')
                            ->label('Jenis Kelamin')
                            ->options([
                                'male' => 'Laki-laki',
                                'female' => 'Perempuan',
                            ])
                            ->placeholder('Pilih jenis kelamin')
                            ->columnSpan(1),
                            
                        DatePicker::make('birth_date')
                            ->label('Tanggal Lahir')
                            ->placeholder('Pilih tanggal lahir')
                            ->columnSpan(1),
                            
                        TextInput::make('graduation_year')
                            ->label('Tahun Lulus')
                            ->placeholder('2023')
                            ->numeric()
                            ->required()
                            ->minValue(1900)
                            ->maxValue(date('Y') + 5)
                            ->columnSpan(1),
                            
                        TextInput::make('gpa')
                            ->label('IPK / GPA')
                            ->placeholder('3.75')
                            ->numeric()
                            ->step(0.01)
                            ->minValue(0)
                            ->maxValue(4)
                            ->columnSpan(1),
                            
                        TextInput::make('program_id')
                            ->label('Program Studi ID')
                            ->placeholder('ID Program Studi')
                            ->numeric()
                            ->required()
                            ->columnSpan(1),
                    ])
                     ->columnSpanFull(),

                // SECTION 2: ALAMAT (Address Information)
                Section::make('🏠 Informasi Alamat')
                    ->description('Data alamat tempat tinggal alumni')
                    ->icon('heroicon-m-home-modern')
                    ->collapsed()
                    ->schema([
                        Select::make('address_id')
                            ->label('Alamat Alumni')
                            ->relationship('address', 'street')
                            ->searchable()
                            ->preload()
                            ->placeholder('Pilih alamat atau tambah alamat baru')
                            ->createOptionForm([
                                TextInput::make('street')
                                    ->label('Alamat Jalan')
                                    ->placeholder('Contoh: Jl. Merdeka No. 123, RT/RW 01/02')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpanFull(),
                                    
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('city')
                                            ->label('Kota/Kabupaten')
                                            ->placeholder('Contoh: Jakarta Selatan')
                                            ->required()
                                            ->maxLength(100),
                                            
                                        TextInput::make('province')
                                            ->label('Provinsi')
                                            ->placeholder('Contoh: DKI Jakarta')
                                            ->required()
                                            ->maxLength(100),
                                    ]),
                                    
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('postal_code')
                                            ->label('Kode Pos')
                                            ->placeholder('12345')
                                            ->required()
                                            ->maxLength(10),
                                            
                                        TextInput::make('country')
                                            ->label('Negara')
                                            ->default('Indonesia')
                                            ->required()
                                            ->maxLength(100),
                                    ]),
                            ])
                            ->columnSpanFull(),
                    ])
                     ->columnSpanFull(),

                // SECTION 3: KONTAK (Contact Methods)
                Section::make('📞 Metode Kontak Alumni')
                    ->description('Berbagai cara menghubungi alumni (email alternatif, media sosial, dll)')
                    ->icon('heroicon-m-chat-bubble-bottom-center-text')
                    ->collapsed()
                    ->schema([
                        Repeater::make('contactMethods')
                            ->relationship()
                            ->schema([
                                Select::make('contact_type')
                                    ->label('Jenis Kontak')
                                    ->options([
                                        'email' => '📧 Email Alternatif',
                                        'phone' => '📱 Telepon Alternatif',
                                        'whatsapp' => '💬 WhatsApp',
                                        'linkedin' => '💼 LinkedIn',
                                        'instagram' => '📷 Instagram',
                                        'facebook' => '📘 Facebook',
                                        'twitter' => '🐦 Twitter',
                                        'youtube' => '🎥 YouTube',
                                        'tiktok' => '🎵 TikTok',
                                        'github' => '💻 GitHub',
                                        'website' => '🌐 Website/Blog',
                                        'other' => '🔗 Lainnya',
                                    ])
                                    ->required()
                                    ->placeholder('Pilih jenis kontak')
                                    ->columnSpan(1),
                                    
                                TextInput::make('contact_value')
                                    ->label('Detail Kontak')
                                    ->placeholder('Masukkan alamat/nomor/username/URL')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpan(2),
                                    
                                Toggle::make('is_primary')
                                    ->label('Kontak Utama')
                                    ->helperText('Tandai sebagai kontak utama untuk jenis ini')
                                    ->columnSpan(1),
                            ])
                            ->columns(4)
                            ->defaultItems(0)
                            ->itemLabel(fn (array $state): ?string => 
                                (!empty($state['contact_type']) ? 
                                    match($state['contact_type']) {
                                        'email' => '📧 Email',
                                        'phone' => '📱 Phone',
                                        'whatsapp' => '💬 WhatsApp',
                                        'linkedin' => '💼 LinkedIn',
                                        'instagram' => '📷 Instagram',
                                        'facebook' => '📘 Facebook',
                                        'twitter' => '🐦 Twitter',
                                        'youtube' => '🎥 YouTube',
                                        'tiktok' => '🎵 TikTok',
                                        'github' => '💻 GitHub',
                                        'website' => '🌐 Website',
                                        default => '🔗 ' . ucfirst($state['contact_type'])
                                    } : 'Kontak Baru') . 
                                (!empty($state['contact_value']) ? 
                                    ': ' . (strlen($state['contact_value']) > 25 
                                        ? substr($state['contact_value'], 0, 25) . '...' 
                                        : $state['contact_value']) : '')
                            )
                            ->addActionLabel('+ Tambah Kontak Baru')
                            ->reorderableWithButtons()
                            ->collapsible()
                            ->columnSpanFull(),
                    ])
                     ->columnSpanFull(),

                // SECTION 4: RIWAYAT PEKERJAAN (Employment History)
                Section::make('💼 Riwayat Pekerjaan Alumni')
                    ->description('Pengalaman kerja dan karir profesional alumni')
                    ->icon('heroicon-m-briefcase')
                    ->collapsed()
                    ->schema([
                        Repeater::make('employmentHistories')
                            ->relationship()
                            ->schema([
                                TextInput::make('job_title')
                                    ->label('Jabatan/Posisi')
                                    ->placeholder('Contoh: Software Engineer, Marketing Manager')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpan(2),
                                    
                                Select::make('employer_id')
                                    ->label('Perusahaan')
                                    ->relationship('employer', 'employer_name')
                                    ->searchable()
                                    ->preload()
                                    ->placeholder('Pilih perusahaan atau kosongkan jika tidak terdaftar')
                                    ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->employer_name} ({$record->industry_type})")
                                    ->createOptionForm([
                                        TextInput::make('employer_name')
                                            ->label('Nama Perusahaan')
                                            ->required()
                                            ->maxLength(255),
                                            
                                        Select::make('industry_type')
                                            ->label('Jenis Industri')
                                            ->options([
                                                'Technology' => '💻 Teknologi & IT',
                                                'Finance' => '💰 Keuangan & Perbankan',
                                                'Healthcare' => '🏥 Kesehatan & Medis',
                                                'Education' => '🎓 Pendidikan',
                                                'Manufacturing' => '🏭 Manufaktur',
                                                'Retail' => '🛒 Retail & E-commerce',
                                                'Construction' => '🏗️ Konstruksi',
                                                'Transportation' => '🚛 Transportasi & Logistik',
                                                'Energy' => '⚡ Energi & Utility',
                                                'Agriculture' => '🌾 Pertanian',
                                                'Media' => '📺 Media & Entertainment',
                                                'Consulting' => '💼 Konsultan',
                                                'Government' => '🏛️ Pemerintahan',
                                                'Non-Profit' => '🤝 Non-Profit',
                                                'Startup' => '🚀 Startup',
                                                'Other' => '🔄 Lainnya',
                                            ])
                                            ->required(),
                                            
                                        TextInput::make('website')
                                            ->label('Website Perusahaan')
                                            ->url()
                                            ->maxLength(255),
                                    ])
                                    ->columnSpan(1),
                                    
                                TextInput::make('company_name')
                                    ->label('Nama Perusahaan (Manual)')
                                    ->placeholder('Isi jika perusahaan tidak ada dalam daftar')
                                    ->maxLength(255)
                                    ->helperText('Alternatif jika perusahaan belum terdaftar')
                                    ->columnSpan(1),
                                    
                                Select::make('job_level')
                                    ->label('Level Jabatan')
                                    ->options([
                                        'entry' => '🎯 Entry Level',
                                        'junior' => '🔰 Junior',
                                        'mid' => '📈 Mid Level',
                                        'senior' => '⭐ Senior',
                                        'lead' => '👑 Lead/Team Leader',
                                        'supervisor' => '📋 Supervisor',
                                        'manager' => '🎖️ Manager',
                                        'director' => '🏛️ Director',
                                        'vp' => '🚀 Vice President',
                                        'ceo' => '👔 CEO/Founder',
                                    ])
                                    ->required()
                                    ->placeholder('Pilih level jabatan')
                                    ->columnSpan(1),
                                    
                                Select::make('contract_type')
                                    ->label('Jenis Kontrak')
                                    ->options([
                                        'full_time' => '⏰ Full Time',
                                        'part_time' => '🕐 Part Time',
                                        'contract' => '📋 Kontrak',
                                        'freelance' => '🆓 Freelance',
                                        'internship' => '🎓 Magang/Intern',
                                        'volunteer' => '🤝 Volunteer',
                                        'remote' => '🏠 Remote Work',
                                    ])
                                    ->required()
                                    ->placeholder('Pilih jenis kontrak')
                                    ->columnSpan(1),
                                    
                                DatePicker::make('start_date')
                                    ->label('Tanggal Mulai')
                                    ->required()
                                    ->placeholder('Pilih tanggal mulai bekerja')
                                    ->columnSpan(1),
                                    
                                DatePicker::make('end_date')
                                    ->label('Tanggal Selesai')
                                    ->placeholder('Kosongkan jika masih bekerja')
                                    ->helperText('Biarkan kosong jika masih aktif bekerja')
                                    ->columnSpan(1),
                                    
                                TextInput::make('salary_range')
                                    ->label('Rentang Gaji')
                                    ->placeholder('Contoh: 5-10 juta, $3000-5000, Negotiable')
                                    ->maxLength(100)
                                    ->helperText('Opsional - bisa dikosongkan')
                                    ->columnSpan(4),
                            ])
                            ->columns(4)
                            ->defaultItems(0)
                            ->itemLabel(fn (array $state): ?string => 
                                (!empty($state['job_title']) ? $state['job_title'] : 'Pekerjaan Baru') .
                                (!empty($state['employer_id']) ? ' di ' . (\Modules\Employment\Models\Employer::find($state['employer_id'])?->employer_name ?? 'Perusahaan') : 
                                    (!empty($state['company_name']) ? ' di ' . $state['company_name'] : '')) .
                                (!empty($state['start_date']) ? ' (' . $state['start_date'] . ')' : '') .
                                (empty($state['end_date']) ? ' - Sekarang' : '')
                            )
                            ->addActionLabel('+ Tambah Pengalaman Kerja')
                            ->reorderableWithButtons()
                            ->collapsible()
                            ->columnSpanFull(),
                    ])
                     ->columnSpanFull(),

                // SECTION 5: RIWAYAT PENDIDIKAN (Education History)
                Section::make('🎓 Riwayat Pendidikan Alumni')
                    ->description('Latar belakang akademik dan kualifikasi pendidikan formal')
                    ->icon('heroicon-m-building-library')
                    ->collapsed()
                    ->schema([
                        Repeater::make('educationHistories')
                            ->relationship()
                            ->schema([
                                TextInput::make('gpa')
                                    ->label('IPK/GPA')
                                    ->placeholder('3.75')
                                    ->numeric()
                                    ->step(0.01)
                                    ->minValue(0)
                                    ->maxValue(4)
                                    ->helperText('Skala 4.00')
                                    ->columnSpan(2),
                                    
                                DatePicker::make('start_date')
                                    ->label('Tanggal Mulai')
                                    ->required()
                                    ->placeholder('Tanggal mulai kuliah')
                                    ->columnSpan(1),
                                    
                                DatePicker::make('end_date')
                                    ->label('Tanggal Lulus')
                                    ->placeholder('Tanggal lulus')
                                    ->helperText('Kosongkan jika masih kuliah')
                                    ->columnSpan(1),
                                    
                                Textarea::make('thesis_title')
                                    ->label('Judul Tugas Akhir/Skripsi/Thesis')
                                    ->placeholder('Masukkan judul tugas akhir, skripsi, thesis, atau proyek akhir')
                                    ->maxLength(500)
                                    ->rows(3)
                                    ->helperText('Judul karya ilmiah terakhir (opsional)')
                                    ->columnSpanFull(),
                            ])
                            ->columns(4)
                            ->defaultItems(0)
                            ->itemLabel(fn (array $state): ?string => 
                                'Pendidikan' .
                                (!empty($state['start_date']) ? ' (' . $state['start_date'] . ')' : '') .
                                (!empty($state['gpa']) ? ' - IPK: ' . $state['gpa'] : '') .
                                (!empty($state['end_date']) ? ' - ' . $state['end_date'] : ' - Sekarang')
                            )
                            ->addActionLabel('+ Tambah Riwayat Pendidikan')
                            ->reorderableWithButtons()
                            ->collapsible()
                            ->columnSpanFull(),
                    ])
                     ->columnSpanFull(),
            ]);
    }
}
