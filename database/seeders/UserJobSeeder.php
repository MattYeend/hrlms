<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class UserJobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jobs = [
            // Format: [job_title, short_code, description, department_name]

            // C Suite
            ['Chief Executive Officer', '(CEO)', 'Top executive responsible for the overall success and strategic direction of the company.', 'C Suite'],
            ['Chief Operating Officer', '(COO)', 'Oversees day-to-day operations and ensures smooth business execution.', 'C Suite'],
            ['Chief Financial Officer', '(CFO)', 'Manages the company\'s finances, including financial planning, risk management, and reporting.', 'C Suite'],
            ['Chief Marketing Officer', '(CMO)', 'Leads marketing strategy, brand management, and customer outreach.', 'C Suite'],
            ['Chief Technology Officer', '(CTO)', 'Focuses on the company\'s technological needs and product development.', 'C Suite'],
            ['Chief Information Officer', '(CIO)', 'Manages IT strategy and systems supporting enterprise goals.', 'C Suite'],
            ['Chief Human Resources Officer', '(CHRO)', 'Oversees talent acquisition, employee engagement, and HR strategy.', 'C Suite'],
            ['Chief Product Officer', '(CPO)', 'Manages product strategy, development, and lifecycle.', 'C Suite'],
            ['Chief Revenue Officer', '(CRO)', 'Responsible for all revenue-generating departments.', 'C Suite'],
            ['Chief Legal Officer', '(CLO)', 'Oversees legal compliance and corporate legal strategy.', 'C Suite'],
            ['Chief Compliance Officer', '(CCO)', 'Ensures regulatory compliance and risk management.', 'C Suite'],
            ['Chief Data Officer', '(CDO)', 'Focuses on data governance and analytics.', 'C Suite'],
            ['Chief Security Officer', '(CSEO)', 'Manages corporate and IT security.', 'C Suite'],
            ['Chief Experience Officer', '(CXO)', 'Enhances customer experience.', 'C Suite'],
            ['Chief Strategy Officer', '(CSTO)', 'Develops long-term strategic initiatives.', 'C Suite'],
            ['Chief Innovation Officer', '(CINO)', 'Drives innovation and growth.', 'C Suite'],
            ['Human Resources Director', '(HRD)', 'Senior role in HR operations.', 'C Suite'],

            // HR Department
            ['Director of People', '(DoP)', 'Reflects a people-first culture.', 'Human Resources'],
            ['Human Resources Manager', '(HRM)', 'Oversees HR teams and policies.', 'Human Resources'],
            ['Employee Relations Manager', '(ERM)', 'Manages workplace conflict and engagement.', 'Human Resources'],
            ['Talent Acquisition Manager', '(TAM)', 'Leads recruitment.', 'Human Resources'],
            ['HR Business Partner', '(HRBP)', 'Strategic advisor bridging HR and business.', 'Human Resources'],
            ['HR Generalist', '(HRG)', 'Handles various HR tasks.', 'Human Resources'],
            ['HR Administrator', '(HRA)', 'Supports HR records and compliance.', 'Human Resources'],

            // IT
            ['IT Director', '(ITD)', 'Oversees IT strategy and infrastructure.', 'IT Department'],
            ['IT Manager', '(ITM)', 'Manages IT teams and projects.', 'IT Department'],
            ['Systems Administrator', '(SA)', 'Supports IT systems and networks.', 'IT Department'],
            ['Network Engineer', '(NE)', 'Designs network infrastructure.', 'IT Department'],
            ['Database Administrator', '(DBA)', 'Manages databases.', 'IT Department'],
            ['Software Developer', '(SDEV)', 'Develops software applications.', 'IT Department'],
            ['Data Analyst', '(DA)', 'Analyzes business data.', 'IT Department'],

            // Sales
            ['Sales Director', '(SDIR)', 'Leads sales strategy.', 'Sales'],
            ['Sales Manager', '(SM)', 'Oversees sales teams.', 'Sales'],
            ['Account Executive', '(AE)', 'Manages client relationships.', 'Sales'],
            ['Business Development Manager', '(BDM)', 'Finds new business opportunities.', 'Sales'],
            ['Sales Representative', '(SR)', 'Handles customer acquisition.', 'Sales'],
            ['Sales Support Specialist', '(SSS)', 'Supports sales team.', 'Sales'],

            // Customer Support
            ['Customer Support Director', '(CSD)', 'Leads customer support team.', 'Customer Support'],
            ['Customer Service Manager', '(CSERVM)', 'Manages service operations.', 'Customer Support'],
            ['Customer Support Specialist', '(CSS)', 'Handles inquiries and support.', 'Customer Support'],
            ['Technical Support Specialist', '(TSS)', 'Troubleshoots technical issues.', 'Customer Support'],
            ['Customer Success Manager', '(CSUCM)', 'Drives satisfaction and retention.', 'Customer Support'],
            ['Call Center Manager', '(CCM)', 'Manages call center operations.', 'Customer Support'],

            // Finance
            ['Finance Director', '(FD)', 'Oversees financial planning.', 'Finance'],
            ['Financial Analyst', '(FA)', 'Supports forecasting and decisions.', 'Finance'],
            ['Accountant', '(ACC)', 'Handles financial records.', 'Finance'],
            ['Payroll Specialist', '(PS)', 'Manages employee payroll.', 'Finance'],
            ['Treasury Manager', '(TRSM)', 'Handles cash flow and risk.', 'Finance'],
            ['Internal Auditor', '(IA)', 'Evaluates controls and compliance.', 'Finance'],
            ['Tax Manager', '(TAXM)', 'Oversees tax planning.', 'Finance'],

            // Operations
            ['Operations Director', '(OD)', 'Leads ops strategy.', 'Operations'],
            ['Operations Manager', '(OPPM)', 'Manages daily operations.', 'Operations'],
            ['Supply Chain Manager', '(SCM)', 'Oversees procurement and logistics.', 'Operations'],
            ['Logistics Coordinator', '(LC)', 'Coordinates distribution.', 'Operations'],
            ['Quality Assurance Manager', '(QAM)', 'Ensures quality standards.', 'Operations'],
            ['Project Manager', '(PM)', 'Leads project delivery.', 'Operations'],

            // Legal
            ['Legal Director', '(LD)', 'Oversees legal matters.', 'Legal'],
            ['Corporate Counsel', '(CC)', 'Advises on corporate law.', 'Legal'],
            ['Compliance Officer', '(CO)', 'Ensures policy compliance.', 'Legal'],
            ['Paralegal', '(PL)', 'Supports legal team.', 'Legal'],
            ['Contracts Manager', '(CM)', 'Handles contracts.', 'Legal'],
            ['Intellectual Property Manager', '(IPM)', 'Manages IP assets.', 'Legal'],

            // Marketing
            ['Marketing Director', '(MD)', 'Leads branding and campaigns.', 'Marketing'],
            ['Digital Marketing Manager', '(DMM)', 'Handles digital presence.', 'Marketing'],
            ['Content Marketing Specialist', '(CMS)', 'Creates engaging content.', 'Marketing'],
            ['Social Media Manager', '(SMM)', 'Manages social media.', 'Marketing'],
            ['SEO Specialist', '(SEO)', 'Optimizes for search engines.', 'Marketing'],
            ['Brand Manager', '(BM)', 'Drives brand identity.', 'Marketing'],

            // Administration
            ['Administrative Director', '(AD)', 'Leads admin functions.', 'Administration'],
            ['Office Manager', '(OFFM)', 'Oversees office ops.', 'Administration'],
            ['Executive Assistant', '(EA)', 'Supports executives.', 'Administration'],
            ['Receptionist', '(REC)', 'Greets and manages front desk.', 'Administration'],
            ['Data Entry Clerk', '(DEC)', 'Inputs data.', 'Administration'],
            ['Facilities Coordinator', '(FC)', 'Manages building logistics.', 'Administration'],

            // Research and Development
            ['R&D Director', '(R&D)', 'Leads R&D efforts.', 'Research and Development'],
            ['Research Scientist', '(RS)', 'Conducts product research.', 'Research and Development'],
            ['Product Development Manager', '(PDM)', 'Oversees new product dev.', 'Research and Development'],
            ['Quality Control Analyst', '(QCA)', 'Performs quality tests.', 'Research and Development'],
            ['Innovation Manager', '(IM)', 'Drives new ideas.', 'Research and Development'],
            ['Regulatory Affairs Specialist', '(RAS)', 'Ensures regulatory compliance.', 'Research and Development'],
        ];

        $now = Carbon::now();

        foreach ($jobs as [$title, $short_code, $description, $dept_name]) {
            $department = DB::table('departments')->where('name', $dept_name)->first();

            if ($department) {
                DB::table('user_jobs')->insert([
                    'job_title' => $title,
                    'slug' => Str::slug($title),
                    'short_code' => $short_code,
                    'description' => $description,
                    'is_default' => false,
                    'archived' => false,
                    'department_id' => $department->id,
                    'created_by' => null,
                    'updated_by' => null,
                    'deleted_by' => null,
                    'restored_by' => null,
                    'restored_at' => null,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            } else {
                echo "Warning: Department '$dept_name' not found for job '$title'.\n";
            }
        }
    }
}