<?php

namespace Modules\Employment\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employers = [
            // Tech Companies
            ['company_name' => 'PT Gojek Indonesia', 'industry_type' => 'Technology', 'company_size' => 'Large', 'location' => 'Jakarta', 'description' => 'Super app platform'],
            ['company_name' => 'PT Tokopedia', 'industry_type' => 'E-commerce', 'company_size' => 'Large', 'location' => 'Jakarta', 'description' => 'E-commerce marketplace platform'],
            ['company_name' => 'PT Shopee International Indonesia', 'industry_type' => 'E-commerce', 'company_size' => 'Large', 'location' => 'Jakarta', 'description' => 'Social commerce platform'],
            ['company_name' => 'PT Traveloka Indonesia', 'industry_type' => 'Travel Technology', 'company_size' => 'Large', 'location' => 'Jakarta', 'description' => 'Travel booking platform'],
            ['company_name' => 'PT Bukalapak.com', 'industry_type' => 'E-commerce', 'company_size' => 'Large', 'location' => 'Jakarta', 'description' => 'E-commerce and digital payment platform'],
            ['company_name' => 'PT OVO (PT Visionet Internasional)', 'industry_type' => 'Fintech', 'company_size' => 'Large', 'location' => 'Jakarta', 'description' => 'Digital payment platform'],
            ['company_name' => 'PT Dana Indonesia', 'industry_type' => 'Fintech', 'company_size' => 'Medium', 'location' => 'Jakarta', 'description' => 'Digital wallet platform'],
            ['company_name' => 'PT Ruangguru Indonesia', 'industry_type' => 'EdTech', 'company_size' => 'Medium', 'location' => 'Jakarta', 'description' => 'Online learning platform'],
            
            // Banking & Finance
            ['company_name' => 'PT Bank Central Asia Tbk', 'industry_type' => 'Banking', 'company_size' => 'Large', 'location' => 'Jakarta', 'description' => 'Commercial bank'],
            ['company_name' => 'PT Bank Mandiri (Persero) Tbk', 'industry_type' => 'Banking', 'company_size' => 'Large', 'location' => 'Jakarta', 'description' => 'State-owned commercial bank'],
            ['company_name' => 'PT Bank Rakyat Indonesia (Persero) Tbk', 'industry_type' => 'Banking', 'company_size' => 'Large', 'location' => 'Jakarta', 'description' => 'State-owned commercial bank'],
            ['company_name' => 'PT Bank Negara Indonesia (Persero) Tbk', 'industry_type' => 'Banking', 'company_size' => 'Large', 'location' => 'Jakarta', 'description' => 'State-owned commercial bank'],
            
            // Consulting & Professional Services
            ['company_name' => 'McKinsey & Company Indonesia', 'industry_type' => 'Management Consulting', 'company_size' => 'Medium', 'location' => 'Jakarta', 'description' => 'Global management consulting firm'],
            ['company_name' => 'Boston Consulting Group Indonesia', 'industry_type' => 'Management Consulting', 'company_size' => 'Medium', 'location' => 'Jakarta', 'description' => 'Global management consulting firm'],
            ['company_name' => 'PwC Indonesia', 'industry_type' => 'Professional Services', 'company_size' => 'Large', 'location' => 'Jakarta', 'description' => 'Professional services network'],
            ['company_name' => 'Deloitte Indonesia', 'industry_type' => 'Professional Services', 'company_size' => 'Large', 'location' => 'Jakarta', 'description' => 'Professional services network'],
            ['company_name' => 'KPMG Indonesia', 'industry_type' => 'Professional Services', 'company_size' => 'Large', 'location' => 'Jakarta', 'description' => 'Professional services network'],
            ['company_name' => 'EY Indonesia', 'industry_type' => 'Professional Services', 'company_size' => 'Large', 'location' => 'Jakarta', 'description' => 'Professional services network'],
            
            // Manufacturing & Industrial
            ['company_name' => 'PT Astra International Tbk', 'industry_type' => 'Automotive', 'company_size' => 'Large', 'location' => 'Jakarta', 'description' => 'Automotive and heavy equipment manufacturer'],
            ['company_name' => 'PT Unilever Indonesia Tbk', 'industry_type' => 'Consumer Goods', 'company_size' => 'Large', 'location' => 'Jakarta', 'description' => 'Fast-moving consumer goods'],
            ['company_name' => 'PT Indofood Sukses Makmur Tbk', 'industry_type' => 'Food & Beverage', 'company_size' => 'Large', 'location' => 'Jakarta', 'description' => 'Food and beverage manufacturer'],
            ['company_name' => 'PT Kalbe Farma Tbk', 'industry_type' => 'Pharmaceutical', 'company_size' => 'Large', 'location' => 'Jakarta', 'description' => 'Pharmaceutical company'],
            
            // Telecommunications
            ['company_name' => 'PT Telekomunikasi Indonesia (Persero) Tbk', 'industry_type' => 'Telecommunications', 'company_size' => 'Large', 'location' => 'Jakarta', 'description' => 'State-owned telecommunications company'],
            ['company_name' => 'PT XL Axiata Tbk', 'industry_type' => 'Telecommunications', 'company_size' => 'Large', 'location' => 'Jakarta', 'description' => 'Telecommunications operator'],
            ['company_name' => 'PT Indosat Ooredoo Hutchison', 'industry_type' => 'Telecommunications', 'company_size' => 'Large', 'location' => 'Jakarta', 'description' => 'Telecommunications operator'],
            
            // Energy & Mining
            ['company_name' => 'PT Pertamina (Persero)', 'industry_type' => 'Oil & Gas', 'company_size' => 'Large', 'location' => 'Jakarta', 'description' => 'State-owned oil and gas company'],
            ['company_name' => 'PT PLN (Persero)', 'industry_type' => 'Energy', 'company_size' => 'Large', 'location' => 'Jakarta', 'description' => 'State-owned electricity company'],
            ['company_name' => 'PT Adaro Energy Tbk', 'industry_type' => 'Mining', 'company_size' => 'Large', 'location' => 'Jakarta', 'description' => 'Coal mining company'],
            
            // Media & Creative
            ['company_name' => 'PT Media Nusantara Citra Tbk', 'industry_type' => 'Media', 'company_size' => 'Large', 'location' => 'Jakarta', 'description' => 'Media and entertainment company'],
            ['company_name' => 'PT Kompas Gramedia', 'industry_type' => 'Media', 'company_size' => 'Medium', 'location' => 'Jakarta', 'description' => 'Media and publishing company'],
            
            // Government Agencies
            ['company_name' => 'Kementerian Komunikasi dan Informatika', 'industry_type' => 'Government', 'company_size' => 'Large', 'location' => 'Jakarta', 'description' => 'Ministry of Communication and Informatics'],
            ['company_name' => 'Badan Pusat Statistik', 'industry_type' => 'Government', 'company_size' => 'Large', 'location' => 'Jakarta', 'description' => 'Statistics Indonesia'],
            ['company_name' => 'Badan Siber dan Sandi Negara', 'industry_type' => 'Government', 'company_size' => 'Medium', 'location' => 'Jakarta', 'description' => 'National Cyber and Crypto Agency'],
            
            // Regional Companies
            ['company_name' => 'PT Telkom Akses', 'industry_type' => 'Telecommunications', 'company_size' => 'Medium', 'location' => 'Bandung', 'description' => 'Telecommunications infrastructure'],
            ['company_name' => 'PT Inti (Persero)', 'industry_type' => 'Technology', 'company_size' => 'Medium', 'location' => 'Bandung', 'description' => 'ICT solutions provider'],
            ['company_name' => 'PT Len Industri (Persero)', 'industry_type' => 'Technology', 'company_size' => 'Medium', 'location' => 'Bandung', 'description' => 'Electronics and defense industry'],
            ['company_name' => 'PT Bank Jatim', 'industry_type' => 'Banking', 'company_size' => 'Medium', 'location' => 'Surabaya', 'description' => 'Regional development bank'],
            ['company_name' => 'PT PAL Indonesia (Persero)', 'industry_type' => 'Defense', 'company_size' => 'Medium', 'location' => 'Surabaya', 'description' => 'Shipbuilding and naval defense'],
            
            // Startups & SMEs
            ['company_name' => 'PT Xendit Indonesia', 'industry_type' => 'Fintech', 'company_size' => 'Medium', 'location' => 'Jakarta', 'description' => 'Payment gateway solutions'],
            ['company_name' => 'PT Kawan Lama Group', 'industry_type' => 'Retail', 'company_size' => 'Large', 'location' => 'Jakarta', 'description' => 'Retail and distribution'],
            ['company_name' => 'PT Matahari Department Store', 'industry_type' => 'Retail', 'company_size' => 'Large', 'location' => 'Jakarta', 'description' => 'Department store chain'],
        ];

        foreach ($employers as $employer) {
            DB::table('employers')->insert([
                'company_name' => $employer['company_name'],
                'industry_type' => $employer['industry_type'],
                'company_size' => $employer['company_size'],
                'location' => $employer['location'],
                'description' => $employer['description'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
