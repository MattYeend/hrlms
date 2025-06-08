<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class BusinessTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            // Format: [name,slug, short_code]
            ["Agriculture", "agriculture", "AGR"],
            ["Apparel and Fashion", "apparel-fashion", "APF"],
            ["Automotive", "automotive", "AUT"],
            ["Cleaning Services", "cleaning-services", "CLS"],
            ["Construction", "construction", "CON"],
            ["Consulting", "consulting", "CNS"],
            ["Creative and Design Services", "creative-design", "CRD"],
            ["Cybersecurity", "cybersecurity", "CYB"],
            ["Data Analytics", "data-analytics", "DAT"],
            ["E-commerce", "ecommerce", "ECM"],
            ["Education and Training", "education-training", "EDU"],
            ["Education Technology", "education-technology", "EDT"],
            ["Energy and Utilities", "energy-utilities", "ENU"],
            ["Entertainment and Media", "entertainment-media", "EMD"],
            ["Environmental Services", "environmental-services", "ENV"],
            ["Executive Consulting", "executive-consulting", "EXC"],
            ["Fashion and Beauty", "fashion-beauty", "FAB"],
            ["Financial Services", "financial-services", "FIN"],
            ["Fishing", "fishing", "FSH"],
            ["Food and Beverage Services", "food-beverage", "FBS"],
            ["Food Processing", "food-processing", "FDP"],
            ["Forestry", "forestry", "FOR"],
            ["Gaming Industry", "gaming-industry", "GAM"],
            ["Government Services", "government-services", "GOV"],
            ["Healthcare and Social Assistance", "healthcare-social", "HCS"],
            ["Hospitality and Tourism", "hospitality-tourism", "HST"],
            ["Industrial Equipment Production", "industrial-equipment", "IEP"],
            ["Information Technology", "information-technology", "IT"],
            ["Legal Services", "legal-services", "LEG"],
            ["Logistics and Supply Chain", "logistics-supply", "LSC"],
            ["Manufacturing", "manufacturing", "MFG"],
            ["Marketing and Advertising", "marketing-advertising", "MKT"],
            ["Media and Publishing", "media-publishing", "MAP"],
            ["Mining", "mining", "MIN"],
            ["Mobile Apps and Platforms", "mobile-apps", "MAPL"],
            ["Nonprofits and Charities", "nonprofits-charities", "NPC"],
            ["Oil and Gas Extraction", "oil-gas-extraction", "OGE"],
            ["Personal Services", "personal-services", "PER"],
            ["Pharmaceuticals", "pharmaceuticals", "PHR"],
            ["Professional Services", "professional-services", "PRS"],
            ["Real Estate", "real-estate", "REA"],
            ["Renewable Energy", "renewable-energy", "REN"],
            ["Repair and Maintenance", "repair-maintenance", "RPM"],
            ["Research and Development", "research-development", "RND"],
            ["Retail and Wholesale", "retail-wholesale", "RWS"],
            ["Security Services", "security-services", "SEC"],
            ["Software Development", "software-development", "SWD"],
            ["Sports and Recreation", "sports-recreation", "SPR"],
            ["Staffing and Recruitment", "staffing-recruitment", "STF"],
            ["Telecommunications", "telecommunications", "TEL"],
            ["Think Tanks", "think-tanks", "TTK"],
            ["Transportation and Logistics", "transportation-logistics", "TNL"],
            ["Waste Management", "waste-management", "WMT"],
            ["Wellness and Fitness", "wellness-fitness", "WLF"],
        ];

        $now = Carbon::now();

        foreach ($types as [$name, $short_code, $slug]) {
            DB::table('business_types')->insert([
                'name' => $name,
                'slug' => $slug,
                'short_code' => $short_code,
                'created_by' => null,
                'updated_by' => null,
                'deleted_by' => null,
                'restored_by' => null,
                'restored_at' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ]);    
        }
    }
}
