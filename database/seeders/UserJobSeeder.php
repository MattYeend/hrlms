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
            ['Chief Executive Officer', 'CEO', 'Top executive responsible for the overall success and strategic direction of the company.', 'C Suite'],
            ['Chief Operating Officer', 'COO', 'Oversees day-to-day operations and ensures smooth business execution.', 'C Suite'],
            ['Chief Financial Officer', 'CFO', 'Manages the company\'s finances, including financial planning, risk management, and reporting.', 'C Suite'],
            ['Chief Marketing Officer', 'CMO', 'Leads marketing strategy, brand management, and customer outreach.', 'C Suite'],
            ['Chief Technology Officer', 'CTO', 'Focuses on the company\'s technological needs and product development.', 'C Suite'],
            ['Chief Information Officer', 'CIO', 'Manages IT strategy and systems supporting enterprise goals.', 'C Suite'],
            ['Chief Human Resources Officer', 'CHRO', 'Oversees talent acquisition, employee engagement, and HR strategy.', 'C Suite'],
            ['Chief Product Officer', 'CPRODO', 'Manages product strategy, development, and lifecycle.', 'C Suite'],
            ['Chief Revenue Officer', 'CRO', 'Responsible for all revenue-generating departments.', 'C Suite'],
            ['Chief Legal Officer', 'CLO', 'Oversees legal compliance and corporate legal strategy.', 'C Suite'],
            ['Chief Compliance Officer', 'CCOMPO', 'Ensures regulatory compliance and risk management.', 'C Suite'],
            ['Chief Data Officer', 'CDATAO', 'Focuses on data governance and analytics.', 'C Suite'],
            ['Chief Security Officer', 'CSEO', 'Manages corporate and IT security.', 'C Suite'],
            ['Chief Experience Officer', 'CXO', 'Enhances customer experience.', 'C Suite'],
            ['Chief Strategy Officer', 'CSTO', 'Develops long-term strategic initiatives.', 'C Suite'],
            ['Chief Innovation Officer', 'CINO', 'Drives innovation and growth.', 'C Suite'],
            ['Chief Diversity Officer', 'CDIVO', 'Promotes diversity and inclusion.', 'C Suite'],
            ['Chief Sustainability Officer', 'CSO', 'Oversees sustainability initiatives.', 'C Suite'],
            ['Chief Analytics Officer', 'CAO', 'Manages data analytics and insights.', 'C Suite'],
            ['Chief Risk Officer', 'CRISKO', 'Identifies and mitigates risks.', 'C Suite'],
            ['Chief Investment Officer', 'CINVO', 'Manages investment strategies and portfolios.', 'C Suite'],
            ['Chief Learning Officer', 'CLEARNO', 'Oversees learning and development programs.', 'C Suite'],
            ['Chief Communications Officer', 'CCOMMSO', 'Manages internal and external communications.', 'C Suite'],
            ['Chief Procurement Officer', 'CPO', 'Oversees procurement and supply chain management.', 'C Suite'],
            ['Chief Business Development Officer', 'CBDO', 'Focuses on business growth and partnerships.', 'C Suite'],
            ['Chief Franchise Officer', 'CFRAO', 'Manages franchise operations and relationships.', 'C Suite'],
            ['Chief Investment Relations Officer', 'CIRO', 'Handles investor relations and communications.', 'C Suite'],
            ['Chief Ethics Officer', 'CETHICSO', 'Ensures ethical practices across the organization.', 'C Suite'],
            ['Chief Digital Officer', 'CDIGITO', 'Leads digital transformation initiatives.', 'C Suite'],
            ['Chief Brand Officer', 'CBO', 'Manages brand strategy and positioning.', 'C Suite'],
            ['Chief Customer Officer', 'CCUSTO', 'Focuses on customer satisfaction and loyalty.', 'C Suite'],
            ['Chief Global Officer', 'CGO', 'Oversees global operations and strategy.', 'C Suite'],
            ['Chief Franchise Development Officer', 'CFDO', 'Leads franchise development and expansion.', 'C Suite'],
            ['Chief Corporate Development Officer', 'CCDO', 'Manages mergers, acquisitions, and strategic partnerships.', 'C Suite'],
            ['Chief Transformation Officer', 'CTRANO', 'Drives organizational change and transformation.', 'C Suite'],
            ['Chief People Officer', 'CPEOPLEO', 'Focuses on employee engagement and culture.', 'C Suite'],
            ['Chief Innovation and Technology Officer', 'CITO', 'Combines innovation with technology strategy.', 'C Suite'],
            ['Chief Global Marketing Officer', 'CGMO', 'Leads global marketing initiatives.', 'C Suite'],
            ['Chief Digital Marketing Officer', 'CDMO', 'Oversees digital marketing strategies.', 'C Suite'],
            ['Chief Corporate Affairs Officer', 'CCAO', 'Manages corporate communications and public affairs.', 'C Suite'],

            // Directorship
            ['Director', 'DIR', 'Senior management role overseeing a specific department or function.', 'Directorship'],
            ['Managing Director', 'MD', 'Responsible for the overall management of the company.', 'Directorship'],
            ['Executive Director', 'ED', 'Leads the organization and reports to the board.', 'Directorship'],
            ['Senior Director', 'SDIR', 'Oversees multiple departments or a large division.', 'Directorship'],
            ['Associate Director', 'ASSOCDIR', 'Supports the director in managing a specific area.', 'Directorship'],
            ['Regional Director', 'REGDIR', 'Manages operations in a specific geographic region.', 'Directorship'],
            ['Program Director', 'PDIR', 'Oversees specific programs or projects within the organization.', 'Directorship'],
            ['Project Director', 'PJDIR', 'Leads major projects and initiatives.', 'Directorship'],
            ['Operations Director', 'ODIR', 'Responsible for the overall operations of the organization.', 'Directorship'],
            ['Business Development Director', 'BDDIR', 'Focuses on business growth and partnerships.', 'Directorship'],
            ['Sales Director', 'SALESDIR', 'Leads sales strategy and team.', 'Directorship'],
            ['Marketing Director', 'MDIR', 'Oversees marketing strategy and execution.', 'Directorship'],
            ['Finance Director', 'FINDIR', 'Manages financial planning and reporting.', 'Directorship'],
            ['Human Resources Director', 'HRDIR', 'Leads HR strategy and operations.', 'Directorship'],
            ['IT Director', 'ITDIR', 'Oversees IT strategy and infrastructure.', 'Directorship'],
            ['Legal Director', 'LDIR', 'Manages legal affairs and compliance.', 'Directorship'],
            ['Compliance Director', 'CDIR', 'Ensures regulatory compliance across the organization.', 'Directorship'],
            ['Product Director', 'PRODDIR', 'Oversees product development and lifecycle management.', 'Directorship'],
            ['Customer Experience Director', 'CUSTEXDIR', 'Enhances customer satisfaction and loyalty.', 'Directorship'],
            ['Innovation Director', 'IDIR', 'Drives innovation initiatives within the organization.', 'Directorship'],
            ['Corporate Affairs Director', 'CADIR', 'Manages corporate communications and public relations.', 'Directorship'],
            ['Sustainability Director', 'SUSDIR', 'Leads sustainability initiatives and practices.', 'Directorship'],
            ['Data Analytics Director', 'DADIR', 'Oversees data analytics and business intelligence.', 'Directorship'],
            ['Risk Management Director', 'RMDIR', 'Identifies and mitigates organizational risks.', 'Directorship'],
            ['Investor Relations Director', 'IRDIR', 'Manages relationships with investors and stakeholders.', 'Directorship'],
            ['Training and Development Director', 'TDDIR', 'Oversees employee training and development programs.', 'Directorship'],
            ['Facilities Director', 'FACDIR', 'Manages facilities operations and maintenance.', 'Directorship'],
            ['Security Director', 'SECDIR', 'Oversees security policies and procedures.', 'Directorship'],
            ['Procurement Director', 'PROCDIR', 'Manages procurement and supply chain activities.', 'Directorship'],
            ['Quality Assurance Director', 'QADIR', 'Ensures product and service quality standards.', 'Directorship'],
            ['Public Relations Director', 'PRDIR', 'Manages public relations and media communications.', 'Directorship'],
            ['Community Engagement Director', 'COMMSENGDIR', 'Builds relationships with community stakeholders.', 'Directorship'],
            ['Corporate Strategy Director', 'CORPSTRDIR', 'Develops and implements corporate strategies.', 'Directorship'],
            ['Digital Transformation Director', 'DTDIR', 'Leads digital transformation initiatives.', 'Directorship'],
            ['Global Operations Director', 'GODIR', 'Oversees global operations and strategy.', 'Directorship'],
            ['Franchise Director', 'FRDIR', 'Manages franchise operations and development.', 'Directorship'],
            ['Corporate Development Director', 'CDDIR', 'Focuses on mergers, acquisitions, and strategic partnerships.', 'Directorship'],
            ['Customer Support Director', 'CUSTSUPPDIR', 'Leads customer support team.', 'Directorship'],
            ['Administrative Director', 'ADMINDIR', 'Leads admin functions.', 'Directorship'],
            ['R&D Director', 'RDIR', 'Leads R&D efforts.', 'Directorship'],

            // HR Department
            ['Director of People', 'DOP', 'Reflects a people-first culture.', 'Human Resources'],
            ['Human Resources Manager', 'HRM', 'Oversees HR teams and policies.', 'Human Resources'],
            ['Employee Relations Manager', 'ERM', 'Manages workplace conflict and engagement.', 'Human Resources'],
            ['Talent Acquisition Manager', 'TAM', 'Leads recruitment.', 'Human Resources'],
            ['HR Business Partner', 'HRBP', 'Strategic advisor bridging HR and business.', 'Human Resources'],
            ['HR Generalist', 'HRG', 'Handles various HR tasks.', 'Human Resources'],
            ['HR Administrator', 'HRA', 'Supports HR records and compliance.', 'Human Resources'],

            // IT
            ['IT Manager', 'ITM', 'Manages IT teams and projects.', 'IT Department'],
            ['Systems Administrator', 'SA', 'Supports IT systems and networks.', 'IT Department'],
            ['Network Engineer', 'NE', 'Designs network infrastructure.', 'IT Department'],
            ['Database Administrator', 'DBA', 'Manages databases.', 'IT Department'],
            ['Software Developer', 'SDEV', 'Develops software applications.', 'IT Department'],
            ['Data Analyst', 'DA', 'Analyzes business data.', 'IT Department'],
            ['Cybersecurity Specialist', 'CS', 'Protects IT systems from threats.', 'IT Department'],
            ['Help Desk Technician', 'HDT', 'Provides IT support to users.', 'IT Department'],
            ['Cloud Solutions Architect', 'CSA', 'Designs cloud-based solutions.', 'IT Department'],
            ['IT Support Specialist', 'ITS', 'Provides technical support.', 'IT Department'],
            ['DevOps Engineer', 'DE', 'Facilitates development and operations integration.', 'IT Department'],
            ['Security Analyst', 'SECA', 'Monitors and protects IT security.', 'IT Department'],
            ['Business Intelligence Analyst', 'BIA', 'Transforms data into insights.', 'IT Department'],
            ['IT Project Manager', 'ITPM', 'Manages IT projects.', 'IT Department'],
            ['IT Compliance Officer', 'ITCO', 'Ensures IT compliance with regulations.', 'IT Department'],
            ['IT Trainer', 'ITT', 'Trains staff on IT systems and tools.', 'IT Department'],
            ['IT Procurement Specialist', 'ITPS', 'Manages IT procurement processes.', 'IT Department'],
            ['IT Operations Manager', 'ITOM', 'Oversees IT operations and service delivery.', 'IT Department'],
            ['IT Architect', 'ITA', 'Designs IT systems and solutions.', 'IT Department'],
            ['IT Business Analyst', 'ITBA', 'Analyzes business needs for IT solutions.', 'IT Department'],
            ['Web Developer', 'WD', 'Creates and maintains websites.', 'IT Department'],
            ['Mobile App Developer', 'MAD', 'Develops mobile applications.', 'IT Department'],
            ['IT Systems Analyst', 'ISA', 'Analyzes and improves IT systems.', 'IT Department'],
            ['IT Service Manager', 'ITSM', 'Manages IT service delivery and support.', 'IT Department'],
            ['IT Vendor Manager', 'ITVM', 'Manages relationships with IT vendors.', 'IT Department'],
            ['Change Manager', 'CHANGEM', 'Manages IT change processes.', 'IT Department'],
            ['IT Asset Manager', 'ITAM', 'Oversees IT asset management.', 'IT Department'],
            ['IT Disaster Recovery Specialist', 'ITDRS', 'Plans and implements disaster recovery strategies.', 'IT Department'],
            ['IT Network Administrator', 'ITNA', 'Manages network infrastructure and performance.', 'IT Department'],
            ['IT Systems Engineer', 'ITSE', 'Designs and implements IT systems.', 'IT Department'],
            ['IT Business Continuity Manager', 'ITBCM', 'Ensures business continuity through IT strategies.', 'IT Department'],
            ['IT Quality Assurance Analyst', 'ITQAA', 'Ensures quality in IT processes and systems.', 'IT Department'],
            ['IT Release Manager', 'ITRM', 'Manages software releases and deployments.', 'IT Department'],
            ['Configuration Manager', 'CONFIGM', 'Manages IT configuration items and changes.', 'IT Department'],
            ['IT Performance Analyst', 'ITPA', 'Analyzes IT performance metrics.', 'IT Department'],

            // Sales
            ['Sales Manager', 'SM', 'Oversees sales teams.', 'Sales'],
            ['Account Executive', 'AE', 'Manages client relationships.', 'Sales'],
            ['Business Development Manager', 'BDM', 'Finds new business opportunities.', 'Sales'],
            ['Sales Representative', 'SR', 'Handles customer acquisition.', 'Sales'],
            ['Sales Support Specialist', 'SSS', 'Supports sales team.', 'Sales'],

            // Customer Support
            ['Customer Service Manager', 'CSERVM', 'Manages service operations.', 'Customer Support'],
            ['Customer Support Specialist', 'CSS', 'Handles inquiries and support.', 'Customer Support'],
            ['Technical Support Specialist', 'TSS', 'Troubleshoots technical issues.', 'Customer Support'],
            ['Customer Success Manager', 'CSUCM', 'Drives satisfaction and retention.', 'Customer Support'],
            ['Call Center Manager', 'CCM', 'Manages call center operations.', 'Customer Support'],
            ['Help Desk Manager', 'HDM', 'Oversees help desk operations.', 'Customer Support'],
            ['Customer Experience Manager', 'CEM', 'Enhances customer journey.', 'Customer Support'],

            // Finance
            ['Financial Analyst', 'FA', 'Supports forecasting and decisions.', 'Finance'],
            ['Accountant', 'ACC', 'Handles financial records.', 'Finance'],
            ['Payroll Specialist', 'PS', 'Manages employee payroll.', 'Finance'],
            ['Treasury Manager', 'TRSM', 'Handles cash flow and risk.', 'Finance'],
            ['Internal Auditor', 'IA', 'Evaluates controls and compliance.', 'Finance'],
            ['Tax Manager', 'TAXM', 'Oversees tax planning.', 'Finance'],

            // Operations
            ['Operations Manager', 'OPPM', 'Manages daily operations.', 'Operations'],
            ['Supply Chain Manager', 'SCM', 'Oversees procurement and logistics.', 'Operations'],
            ['Logistics Coordinator', 'LC', 'Coordinates distribution.', 'Operations'],
            ['Quality Assurance Manager', 'QAM', 'Ensures quality standards.', 'Operations'],
            ['Project Manager', 'PM', 'Leads project delivery.', 'Operations'],

            // Legal
            ['Corporate Counsel', 'CC', 'Advises on corporate law.', 'Legal'],
            ['Compliance Officer', 'CO', 'Ensures policy compliance.', 'Legal'],
            ['Paralegal', 'PL', 'Supports legal team.', 'Legal'],
            ['Contracts Manager', 'COM', 'Handles contracts.', 'Legal'],
            ['Intellectual Property Manager', 'IPM', 'Manages IP assets.', 'Legal'],
            ['Litigation Specialist', 'LS', 'Handles legal disputes.', 'Legal'],
            ['Legal Assistant', 'LA', 'Provides administrative support.', 'Legal'],

            // Marketing
            ['Digital Marketing Manager', 'DMM', 'Handles digital presence.', 'Marketing'],
            ['Content Marketing Specialist', 'CMS', 'Creates engaging content.', 'Marketing'],
            ['Social Media Manager', 'SMM', 'Manages social media.', 'Marketing'],
            ['SEO Specialist', 'SEO', 'Optimizes for search engines.', 'Marketing'],
            ['Brand Manager', 'BM', 'Drives brand identity.', 'Marketing'],

            // Administration
            ['Office Manager', 'OFFM', 'Oversees office ops.', 'Administration'],
            ['Executive Assistant', 'EA', 'Supports executives.', 'Administration'],
            ['Receptionist', 'REC', 'Greets and manages front desk.', 'Administration'],
            ['Data Entry Clerk', 'DEC', 'Inputs data.', 'Administration'],
            ['Facilities Coordinator', 'FC', 'Manages building logistics.', 'Administration'],

            // Research and Development
            ['Research Scientist', 'RS', 'Conducts product research.', 'Research and Development'],
            ['Product Development Manager', 'PDM', 'Oversees new product dev.', 'Research and Development'],
            ['Quality Control Analyst', 'QCA', 'Performs quality tests.', 'Research and Development'],
            ['Innovation Manager', 'IM', 'Drives new ideas.', 'Research and Development'],
            ['Regulatory Affairs Specialist', 'RAS', 'Ensures regulatory compliance.', 'Research and Development'],

            // Procurement
            ['Procurement Manager', 'PROCM', 'Oversees procurement activities and vendor management.', 'Procurement'],
            ['Purchasing Officer', 'PO', 'Executes purchase orders and tracks procurement.', 'Procurement'],
            ['Vendor Manager', 'VM', 'Manages supplier relationships and contracts.', 'Procurement'],
            ['Supply Chain Analyst', 'SCA', 'Analyzes supply chain processes and performance.', 'Procurement'],
            ['Category Manager', 'CM', 'Manages specific product categories and sourcing strategies.', 'Procurement'],
            ['Contract Specialist', 'ConS', 'Drafts and negotiates procurement contracts.', 'Procurement'],

            // Quality Assurance
            ['QA Engineer', 'QAE', 'Develops and executes tests to ensure product quality.', 'Quality Assurance'],
            ['QA Coordinator', 'QAC', 'Coordinates quality processes and audits.', 'Quality Assurance'],
            ['Quality Control Inspector', 'QCI', 'Inspects products for quality standards.', 'Quality Assurance'],
            ['QA Analyst', 'QAA', 'Analyzes quality data and reports.', 'Quality Assurance'],
            ['QA Tester', 'QAT', 'Tests software and systems for defects.', 'Quality Assurance'],

            // Training and Development
            ['Training Manager', 'TRM', 'Develops and implements training programs.', 'Training and Development'],
            ['Learning and Development Specialist', 'LDS', 'Focuses on skill development and training.', 'Training and Development'],
            ['Training Coordinator', 'TRC', 'Schedules and organizes training events.', 'Training and Development'],
            ['Instructional Designer', 'INSTDES', 'Creates educational materials and courses.', 'Training and Development'],
            ['Corporate Trainer', 'CT', 'Delivers training sessions to employees.', 'Training and Development'],
            ['E-Learning Specialist', 'ELS', 'Develops online training programs.', 'Training and Development'],

            // Public Relations
            ['PR Manager', 'PRM', 'Manages public image and media relations.', 'Public Relations'],
            ['Media Relations Specialist', 'MRS', 'Handles communication with media outlets.', 'Public Relations'],
            ['Communications Officer', 'COF', 'Creates and distributes press releases.', 'Public Relations'],
            ['Public Affairs Manager', 'PAM', 'Manages public policy and community relations.', 'Public Relations'],
            ['Crisis Communications Manager', 'CCOMM', 'Handles communication during crises.', 'Public Relations'],
            ['Event Coordinator', 'EC', 'Plans and executes public events.', 'Public Relations'],

            // Facilities
            ['Facilities Manager', 'FM', 'Oversees maintenance and building operations.', 'Facilities'],
            ['Maintenance Supervisor', 'MS', 'Supervises repair and maintenance teams.', 'Facilities'],
            ['Custodial Services Coordinator', 'CSC', 'Manages janitorial operations.', 'Facilities'],
            ['Building Operations Manager', 'BOM', 'Ensures building systems function properly.', 'Facilities'],
            ['Safety Officer', 'SOF', 'Ensures workplace safety compliance.', 'Facilities'],
            ['Space Planner', 'SP', 'Plans and optimizes office space usage.', 'Facilities'],

            // Compliance
            ['Regulatory Compliance Officer', 'RCO', 'Ensures operations comply with regulations.', 'Compliance'],
            ['Compliance Analyst', 'CPA', 'Analyzes risk and adherence to laws.', 'Compliance'],
            ['Compliance Coordinator', 'CPC', 'Coordinates compliance activities and reporting.', 'Compliance'],
            ['Data Protection Officer', 'DPO', 'Ensures data privacy and protection compliance.', 'Compliance'],
            ['Ethics Officer', 'EO', 'Promotes ethical practices within the organization.', 'Compliance'],

            // Security
            ['Security Manager', 'SECMM', 'Manages physical and cybersecurity policies.', 'Security'],
            ['Cybersecurity Analyst', 'CSECA', 'Monitors and protects systems from cyber threats.', 'Security'],
            ['Security Officer', 'SO', 'Ensures safety and security of premises.', 'Security'],
            ['Information Security Manager', 'ISM', 'Oversees information security strategy.', 'Security'],
            ['Physical Security Specialist', 'PSS', 'Implements physical security measures.', 'Security'],
            ['Security Systems Administrator', 'SSA', 'Manages security systems and protocols.', 'Security'],

            // Product Management
            ['Product Manager', 'PMGR', 'Oversees product lifecycle.', 'Product Management'],
            ['Technical Product Manager', 'TPM', 'Bridges engineering and business needs.', 'Product Management'],
            ['Product Owner', 'POW', 'Defines product backlog and priorities.', 'Product Management'],
            ['Product Marketing Manager', 'PMM', 'Develops go-to-market strategies.', 'Product Management'],
            ['User Experience Researcher', 'UXR', 'Conducts user research for product design.', 'Product Management'],
            ['Product Development Specialist', 'PDS', 'Supports product development processes.', 'Product Management'],

            // Data Analytics
            ['Data Scientist', 'DS', 'Builds data models and insights.', 'Data Analytics'],
            ['BI Developer', 'BID', 'Creates dashboards and reports.', 'Data Analytics'],
            ['Data Engineer', 'DENG', 'Builds data pipelines and architecture.', 'Data Analytics'],
            ['Data Visualization Specialist', 'DVS', 'Creates visual representations of data.', 'Data Analytics'],
            ['Quantitative Analyst', 'QA', 'Analyzes numerical data for insights.', 'Data Analytics'],
            ['Data Governance Manager', 'DGM', 'Ensures data quality and compliance.', 'Data Analytics'],

            // Strategic Planning
            ['Strategic Planner', 'STP', 'Develops long-term plans.', 'Strategic Planning'],
            ['Business Strategist', 'BS', 'Provides insights for market and growth.', 'Strategic Planning'],
            ['Market Research Analyst', 'MRA', 'Analyzes market trends and competition.', 'Strategic Planning'],
            ['Corporate Development Manager', 'CDM', 'Manages mergers and acquisitions.', 'Strategic Planning'],
            ['Competitive Intelligence Analyst', 'CIA', 'Gathers and analyzes competitive data.', 'Strategic Planning'],

            // Business Intelligence
            ['BI Analyst', 'BIAANALYST', 'Analyzes data to inform decision-making.', 'Business Intelligence'],
            ['BI Architect', 'BIACT', 'Designs BI infrastructure.', 'Business Intelligence'],
            ['BI Manager', 'BIM', 'Leads BI team and strategy.', 'Business Intelligence'],
            ['Data Warehouse Manager', 'DWM', 'Manages data warehousing solutions.', 'Business Intelligence'],
            ['BI Consultant', 'BIC', 'Advises on BI best practices and tools.', 'Business Intelligence'],

            // Innovation
            ['Innovation Strategist', 'INS', 'Identifies and leads new initiatives.', 'Innovation'],
            ['Innovation Lab Manager', 'ILM', 'Runs internal innovation programs.', 'Innovation'],
            ['Disruption Analyst', 'DAI', 'Analyzes trends for innovation.', 'Innovation'],
            ['Innovation Consultant', 'INC', 'Advises on innovation strategies.', 'Innovation'],
            ['R&D Innovation Specialist', 'RDIS', 'Focuses on innovative research and development.', 'Innovation'],
            ['Open Innovation Manager', 'OIM', 'Manages external innovation partnerships.', 'Innovation'],

            // Sustainability
            ['Sustainability Manager', 'SUM', 'Implements eco-friendly practices.', 'Sustainability'],
            ['Environmental Specialist', 'ENVSP', 'Evaluates environmental impact.', 'Sustainability'],
            ['CSR Coordinator', 'CSRC', 'Leads corporate social responsibility efforts.', 'Sustainability'],
            ['Sustainability Analyst', 'SANA', 'Analyzes sustainability metrics.', 'Sustainability'],
            ['Sustainability Consultant', 'SUCO', 'Advises on sustainable practices.', 'Sustainability'],
            ['Green Building Specialist', 'GBS', 'Focuses on eco-friendly building practices.', 'Sustainability'],

            // Investor Relations
            ['IR Manager', 'IRM', 'Communicates with investors.', 'Investor Relations'],
            ['Shareholder Relations Officer', 'SRO', 'Maintains shareholder communications.', 'Investor Relations'],
            ['Financial Communications Specialist', 'FCS', 'Creates financial reports for investors.', 'Investor Relations'],
            ['Investor Relations Analyst', 'IRA', 'Analyzes investor data and trends.', 'Investor Relations'],
            ['Capital Markets Specialist', 'CAPMARKS', 'Manages capital market activities.', 'Investor Relations'],
            ['Equity Research Analyst', 'ERA', 'Conducts research on stocks and investments.', 'Investor Relations'],

            // UX/UI Design
            ['UX Designer', 'UXD', 'Designs user experience for products.', 'UX/UI Design'],
            ['UI Designer', 'UID', 'Creates interfaces and visuals.', 'UX/UI Design'],
            ['Design Lead', 'DL', 'Oversees UX/UI team and vision.', 'UX/UI Design'],
            ['Interaction Designer', 'ISTDESIGN', 'Designs interactive elements.', 'UX/UI Design'],
            ['Visual Designer', 'VD', 'Focuses on aesthetics and branding.', 'UX/UI Design'],
            ['User Researcher', 'UR', 'Conducts user testing and feedback.', 'UX/UI Design'],

            // Content Strategy
            ['Content Strategist', 'CST', 'Plans and structures digital content.', 'Content Strategy'],
            ['Copywriter', 'CW', 'Produces written content.', 'Content Strategy'],
            ['Editorial Manager', 'EDM', 'Oversees publishing and content style.', 'Content Strategy'],
            ['Content Marketing Manager', 'CMM', 'Develops content marketing strategies.', 'Content Strategy'],
            ['SEO Content Specialist', 'SEOCS', 'Optimizes content for search engines.', 'Content Strategy'],
            ['Social Media Content Manager', 'SMCM', 'Manages social media content strategy.', 'Content Strategy'],

            // Community Engagement
            ['Community Manager', 'COMAN', 'Manages external community relations.', 'Community Engagement'],
            ['Partnerships Coordinator', 'PCO', 'Coordinates external collaborations.', 'Community Engagement'],
            ['Outreach Specialist', 'ORS', 'Engages with community and stakeholders.', 'Community Engagement'],
            ['Volunteer Coordinator', 'VCO', 'Manages volunteer programs and activities.', 'Community Engagement'],
            ['Corporate Social Responsibility Manager', 'CSRM', 'Leads CSR initiatives and community impact.', 'Community Engagement'],
            ['Community Relations Specialist', 'CRS', 'Builds relationships with local communities.', 'Community Engagement'],
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
                    'is_archived' => false,
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