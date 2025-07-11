<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('departments')->insert([
            [
                'name' => 'C Suite',
                'slug' => Str::slug('C Suite'),
                'description' => 'Executive management team overseeing the entire organization.',
                'is_default' => true,
                'is_archived' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'dept_lead' => null,
            ],
            [
                'name' => 'Directorship',
                'slug' => Str::slug('Directorship'),
                'description' => 'Senior management team responsible for strategic direction.',
                'is_default' => false,
                'is_archived' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'dept_lead' => null,
            ],
            [
                'name' => 'Human Resources',
                'slug' => Str::slug('Human Resources'),
                'description' => 'Handles employee relations and hiring.',
                'is_default' => false,
                'is_archived' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'dept_lead' => null,
            ],
            [
                'name' => 'IT Department',
                'slug' => Str::slug('IT Department'),
                'description' => 'Manages technology and support.',
                'is_default' => false,
                'is_archived' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'dept_lead' => null,
            ],
            [
                'name' => 'Finance',
                'slug' => Str::slug('Finance'),
                'description' => 'Oversees budgeting, accounting, and financial reporting.',
                'is_default' => false,
                'is_archived' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'dept_lead' => null,
            ],
            [
                'name' => 'Marketing',
                'slug' => Str::slug('Marketing'),
                'description' => 'Handles advertising, branding, and promotions.',
                'is_default' => false,
                'is_archived' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'dept_lead' => null,
            ],
            [
                'name' => 'Sales',
                'slug' => Str::slug('Sales'),
                'description' => 'Drives revenue through client acquisition and relationships.',
                'is_default' => false,
                'is_archived' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'dept_lead' => null,
            ],
            [
                'name' => 'Customer Support',
                'slug' => Str::slug('Customer Support'),
                'description' => 'Provides assistance to customers and resolves issues.',
                'is_default' => false,
                'is_archived' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'dept_lead' => null,
            ],
            [
                'name' => 'Research and Development',
                'slug' => Str::slug('Research and Development'),
                'description' => 'Focuses on innovation and product development.',
                'is_default' => false,
                'is_archived' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'dept_lead' => null,
            ],
            [
                'name' => 'Legal',
                'slug' => Str::slug('Legal'),
                'description' => 'Handles legal matters and compliance.',
                'is_default' => false,
                'is_archived' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'dept_lead' => null,
            ],
            [
                'name' => 'Operations',
                'slug' => Str::slug('Operations'),
                'description' => 'Manages day-to-day business activities and processes.',
                'is_default' => false,
                'is_archived' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'dept_lead' => null,
            ],
            [
                'name' => 'Administration',
                'slug' => Str::slug('Administration'),
                'description' => 'Oversees office management and administrative tasks.',
                'is_default' => false,
                'is_archived' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'dept_lead' => null,
            ],
            [
                'name' => 'Procurement',
                'slug' => Str::slug('Procurement'),
                'description' => 'Manages purchasing and vendor relationships.',
                'is_default' => false,
                'is_archived' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'dept_lead' => null,
            ],
            [
                'name' => 'Quality Assurance',
                'slug' => Str::slug('Quality Assurance'),
                'description' => 'Ensures products and services meet standards.',
                'is_default' => false,
                'is_archived' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'dept_lead' => null,
            ],
            [
                'name' => 'Training and Development',
                'slug' => Str::slug('Training and Development'),
                'description' => 'Manages employee learning programs.',
                'is_default' => false,
                'is_archived' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'dept_lead' => null,
            ],
            [
                'name' => 'Public Relations',
                'slug' => Str::slug('Public Relations'),
                'description' => 'Manages media and public communications.',
                'is_default' => false,
                'is_archived' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'dept_lead' => null,
            ],
            [
                'name' => 'Facilities',
                'slug' => Str::slug('Facilities'),
                'description' => 'Oversees physical infrastructure and maintenance.',
                'is_default' => false,
                'is_archived' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'dept_lead' => null,
            ],
            [
                'name' => 'Compliance',
                'slug' => Str::slug('Compliance'),
                'description' => 'Ensures adherence to laws and regulations.',
                'is_default' => false,
                'is_archived' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'dept_lead' => null,
            ],
            [
                'name' => 'Security',
                'slug' => Str::slug('Security'),
                'description' => 'Manages physical and cybersecurity protocols.',
                'is_default' => false,
                'is_archived' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'dept_lead' => null,
            ],
            [
                'name' => 'Product Management',
                'slug' => Str::slug('Product Management'),
                'description' => 'Leads product planning, roadmap, and features.',
                'is_default' => false,
                'is_archived' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'dept_lead' => null,
            ],
            [
                'name' => 'Data Analytics',
                'slug' => Str::slug('Data Analytics'),
                'description' => 'Handles data insights and reporting.',
                'is_default' => false,
                'is_archived' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'dept_lead' => null,
            ],
            [
                'name' => 'Strategic Planning',
                'slug' => Str::slug('Strategic Planning'),
                'description' => 'Focuses on long-term organizational goals and direction.',
                'is_default' => false,
                'is_archived' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'dept_lead' => null,
            ],
            [
                'name' => 'Business Intelligence',
                'slug' => Str::slug('Business Intelligence'),
                'description' => 'Transforms data into actionable insights to support decision-making.',
                'is_default' => false,
                'is_archived' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'dept_lead' => null,
            ],
            [
                'name' => 'Innovation',
                'slug' => Str::slug('Innovation'),
                'description' => 'Drives new initiatives and explores disruptive ideas and technologies.',
                'is_default' => false,
                'is_archived' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'dept_lead' => null,
            ],
            [
                'name' => 'Sustainability',
                'slug' => Str::slug('Sustainability'),
                'description' => 'Focuses on environmental impact and sustainable practices.',
                'is_default' => false,
                'is_archived' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'dept_lead' => null,
            ],
            [
                'name' => 'Investor Relations',
                'slug' => Str::slug('Investor Relations'),
                'description' => 'Manages communication and relationships with investors and stakeholders.',
                'is_default' => false,
                'is_archived' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'dept_lead' => null,
            ],
            [
                'name' => 'UX/UI Design',
                'slug' => Str::slug('UX UI Design'),
                'description' => 'Improves user experience and interface design for products and services.',
                'is_default' => false,
                'is_archived' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'dept_lead' => null,
            ],
            [
                'name' => 'Content Strategy',
                'slug' => Str::slug('Content Strategy'),
                'description' => 'Plans and manages digital content aligned with brand goals.',
                'is_default' => false,
                'is_archived' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'dept_lead' => null,
            ],
            [
                'name' => 'Community Engagement',
                'slug' => Str::slug('Community Engagement'),
                'description' => 'Builds and nurtures relationships with the broader community and partners.',
                'is_default' => false,
                'is_archived' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'dept_lead' => null,
            ],
            [
                'name' => 'Logistics',
                'slug' => Str::slug('Logistics'),
                'description' => 'Coordinates transportation, inventory, and supply chain operations.',
                'is_default' => false,
                'is_archived' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'dept_lead' => null,
            ],
            [
                'name' => 'Customer Experience',
                'slug' => Str::slug('Customer Experience'),
                'description' => 'Optimizes end-to-end customer interactions and satisfaction.',
                'is_default' => false,
                'is_archived' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'dept_lead' => null,
            ],
            [
                'name' => 'Change Management',
                'slug' => Str::slug('Change Management'),
                'description' => 'Manages organizational change initiatives and communication strategies.',
                'is_default' => false,
                'is_archived' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'dept_lead' => null,
            ]
        ]);
    }
}
