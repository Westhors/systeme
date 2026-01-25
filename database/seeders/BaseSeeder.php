<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Model::unguard();

        DB::table('pages')->insert(
            [
                ['name' => 'Home', 'title' => 'Home', 'slug' => 'home', 'position' => 1, 'des' => null],
                ['name' => 'About', 'title' => 'About', 'slug' => 'about', 'position' => 2, 'des' => null],
                ['name' => 'Services', 'title' => 'Services', 'slug' => 'services', 'position' => 3, 'des' => null],
                ['name' => 'Membership Guidelines', 'title' => 'Membership Guidelines', 'slug' => 'membership', 'position' => 4, 'des' => null],
                ['name' => 'Events', 'title' => 'Events', 'slug' => 'events', 'position' => 5, 'des' => 'LNF events are essential opportunities for sharing insights and knowledge in a specialized freight networks forum, addressing the challenges and emerging trends in the freight forwarding industry.'],
                ['name' => 'News', 'title' => 'News', 'slug' => 'news', 'position' => 6, 'des' => null],
                ['name' => 'Contact', 'title' => 'Contact', 'slug' => 'contact', 'position' => 7, 'des' => null],
                ['name' => 'Policies', 'title' => 'Policies', 'slug' => 'policies', 'position' => 8, 'des' => null],
                ['name' => 'FAQ', 'title' => 'FAQ', 'slug' => 'faq', 'position' => 9, 'des' => null],
                ['name' => 'Terms & Conditions', 'title' => 'Terms & Conditions', 'slug' => 'terms-and-conditions', 'position' => 10, 'des' => null],
            ]
        );

        DB::table('page_sections')->insert(
            [
                [
                    'id' => 1,
                    'title' => 'Who We Are',
                    'slug' => Str::slug('Who We Are'),
                    'type' => 'about-no-image',
                    'description' => 'In an era where change is the only constant,
                     and innovation is the engine of growth,
                      we find ourselves at a crossroads.
                      How do we navigate the complexities of global trade,
                       regulatory landscapes, and technological disruptions?
                        The answer lies in unity, collaboration, and collective innovation.<br>LNF,
                         the Logistics Networks Federation of Freight Forwarders, is a non-governmental,
                         membership-based organization founded in 2023 and headquartered in New York, USA.
                         We represent service providers in logistics and freight networks and supply chain management.
                         <br> Through our services and publications,
                         we support various areas of logistics activity and help formulate industry policy on critical logistics issues.
                         We promote trade facilitation and best practices among the freight-forwarding community.',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id' => 2,
                    'title' => 'The Core Idea',
                    'slug' => Str::slug('The Core Idea'),
                    'type' => 'about-no-image',
                    'description' => 'The Logistics Network Federation (LNF) stands as a beacon of cooperative strength and shared vision transcending the traditional boundaries of competition.  It is the embodiment of a powerful idea:<br> At the heart of the LNF lies a simple yet profound idea: unity in diversity. By bringing together freight and logistics networks from across the globe, we harness a wealth of experience, perspectives, and capabilities. However, with this vast potential also come our shared challenges—increasing member networks, ensuring profitability, solidifying the credibility of our financial protection schemes, and organizing hallmark events that epitomize our collaborative spirit and shared expertise.<br> The LNF is about creating a symbiotic ecosystem where every network flourishes, transforming individual successes into shared victories to achieve unprecedented success.',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id' => 3,
                    'title' => 'Mission and Vision',
                    'slug' => Str::slug('Mission and Vision'),
                    'type' => 'about-no-image',
                    'description' => "Vision: To establish the most trusted and innovative Federation that sets global freight network industry standards and unites respected networks from every corner of the globe, setting international benchmarks within our industry.<br> Mission: To bring together freight networks from around the globe, offering them strong support, resources, and opportunities to work together. We aim to lead in innovation and standards by valuing the diverse ideas and methods our members offer. Through promoting, learning, and sustainable actions, we strive to improve our members' competitiveness and efficiency worldwide, creating a welcoming space where everyone's input matters, and working towards a stronger and united industry.",
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id' => 4,
                    'title' => 'Governance',
                    'slug' => Str::slug('Governance'),
                    'type' => 'about-no-image',
                    'description' => "<h3>Governance Structure of LNF</h3><br> The governance of LNF is structured around the General Meeting, the Presidency, the Extended Board, and the Headquarters Team, each playing a vital role in the organization's operations and strategic direction.<br> <h3>General Meeting</h3><br> The LNF General Meeting is the paramount governing body of the organization, convening annually to establish the course for LNF's work through the passage of key resolutions. It is responsible for electing leadership and members, validating the annual report, budget, and financial statements, and approving essential business conditions and regulations. This annual assembly sets strategic priorities and ensures accountability within the organization.",
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id' => 5,
                    'title' => 'Board Team',
                    'slug' => Str::slug('Board Team'),
                    'type' => 'about-no-image',
                    'description' => "The LNF board consists of a President, Vice President, Secretary, and Treasurer, elected by the Board of Directors from its members. Each board member serves a term of two years. The Board of Directors is responsible for adopting resolutions according to the voting procedures outlined in the by-laws.<br><h3>Presidency</h3><br>The Presidency is responsible for the executive management of LNF, overseeing daily operations, and ensuring the implementation of strategic plans and policies set by the General Meeting. The Presidency drives the organization toward its objectives, makes critical decisions, and maintains overall organizational health.<h3>Headquarters Team</h3><br>Under the direction of the Presidency, the Headquarters Team is responsible for determining and executing LNF's strategic plan. This team manages the day-to-day implementation of strategies, projects, and initiatives that align with the organization's goals and objectives, playing a crucial role in translating the strategic vision into actionable plans.",
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id' => 6,
                    'title' => 'The CoreIdea',
                    'slug' => Str::slug('The CoreIdea'),
                    'type' => 'about-no-image',
                    'description' => "The Logistics Network Federation (LNF) stands as a beacon of cooperative strength and shared vision transcending the traditional boundaries of competition. It is the embodiment of a powerful idea: At the heart of the LNF lies a simple yet profound idea: unity in diversity. By bringing together freight and logistics networks from across the globe, we harness a wealth of experience, perspectives, and capabilities. However, with this vast potential also come our shared challenges—increasing member networks, ensuring profitability, solidifying the credibility of our financial protection schemes, and organizing hallmark events that epitomize our collaborative spirit and shared expertise. The LNF is about creating a symbiotic ecosystem where every network flourishes, transforming individual successes into shared victories to achieve unprecedented success.",
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id' => 7,
                    'title' => 'About LNF',
                    'slug' => Str::slug('About LNF'),
                    'type' => 'about-no-image',
                    'description' => "In an era where change is the only constant, and innovation is the engine of growth, we find ourselves at a crossroads. How do we navigate the complexities of global trade, regulatory landscapes, and technological disruptions? The answer lies in unity, collaboration, and collective innovation. LNF, the Logistics Networks Federation of Freight Forwarders, is a non-governmental, membership-based organization founded in 2023 and headquartered in New York, USA. We represent service providers in logistics and freight networks and supply chain management. Through our services and publications, we support various areas of logistics activity and help formulate industry policy on critical logistics issues. We promote trade facilitation and best practices among the freight-forwarding community.",
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            ]
        );

        DB::table('pages_page_sections')->insert(
            [
                ['page_id' => 2, 'page_section_id' => 1, 'position' => 1],
                ['page_id' => 2, 'page_section_id' => 2, 'position' => 2],
                ['page_id' => 2, 'page_section_id' => 3, 'position' => 3],
                ['page_id' => 2, 'page_section_id' => 4, 'position' => 4],
                ['page_id' => 2, 'page_section_id' => 5, 'position' => 5],
                ['page_id' => 1, 'page_section_id' => 6, 'position' => 6],
                ['page_id' => 1, 'page_section_id' => 7, 'position' => 7],

            ]
        );

        DB::table('services')->insert([
            [
                'name' => 'Increasing Membership',
                'slug' => 'increasing-membership',
                'icon' => null,
                'short_description' => null,
                'description' => 'We aim to significantly amplify the membership of each network within our alliance, crafting compelling value propositions that echo globally. In the heart of our collective lies a unique and transformative goal: not merely to expand our federation\'s reach, but to significantly amplify the membership of each network within our alliance. Our collective identity and unified strength serve as a powerful amplifier, echoing the value and appeal of each member network on a global stage. The pivotal question we address today is: How do we craft and communicate a value proposition so compelling that it not only elevates our federation as a whole but also becomes a catalyst for growth within each member network? This is about creating a system where every network\'s success is propelled by our unified efforts, ensuring that the growth and prosperity of one is the triumph of all.',
                'type' => null
            ],
            [
                'name' => 'Catalyzing Network Profitability',
                'slug' => 'catalyzing-network-profitability',
                'icon' => null,
                'short_description' => null,
                'description' => 'Our collective bargaining power and financial innovation are key to enhancing the financial health of each member network. The prosperity of our federation is directly tied to the financial health of each member network. It is imperative that we collaboratively design and implement financial strategies that bolster not just the federation\'s reserves but importantly, enhance the bottom lines of our networks. This involves leveraging our collective bargaining power, for example, to reduce operational costs. Our collective financial innovation serves as the engine for each network\'s growth and sustainability.',
                'type' => null
            ],
            [
                'name' => 'Solidifying Trust through Financial Protection',
                'slug' => 'solidifying-trust-through-financial-protection',
                'icon' => null,
                'short_description' => null,
                'description' => 'We commit to showcasing the robustness of our financial protection mechanisms and building trust within our network. The foundation of our federation\'s promise lies in the reliability and robustness of our financial protection mechanisms. Beyond mere safety nets, these schemes represent our commitment to resilience and mutual support. Our task is to rigorously validate and transparently showcase the strength of these protections, affirming our federation\'s dedication to safeguarding the interests and investments of each network. This is about building an unshakeable trust that each network, by its membership, is fortified against unforeseen adversities.',
                'type' => null
            ],
            [
                'name' => 'Revolutionizing Conferences for Mutual Benefit',
                'slug' => 'revolutionizing-conferences-for-mutual-benefit',
                'icon' => null,
                'short_description' => null,
                'description' => 'By remaining our conferences, we create platforms for growth, visibility, and collaboration, elevating every member network. Our federation\'s conferences are more than events; they are a manifestation of our collective intellect and ambition. The imperative is to orchestrate these gatherings not just for knowledge exchange but as platforms for mutual economic benefit and industry leadership. By adopting innovative cost-sharing models, securing strategic sponsorships, and curating content that showcases the federation\'s and members\' capabilities, we transform these conferences into pivotal moments for growth, visibility, and collaboration.',
                'type' => null
            ],
            [
                'name' => 'Unified Payment Gateway',
                'slug' => 'unified-payment-gateway',
                'icon' => null,
                'short_description' => null,
                'description' => 'The development of a streamlined financial transaction system will enhance our operational efficiency and financial health.',
                'type' => null
            ],
            [
                'name' => 'Blacklist Management and Shared Resources',
                'slug' => 'blacklist-management-and-shared-resources',
                'icon' => null,
                'short_description' => null,
                'description' => 'Implementing a system for sharing crucial information and resources will safeguard our interests and foster operational excellence.',
                'type' => null
            ],
            [
                'name' => '',
                'slug' => '',
                'icon' => null,
                'short_description' => null,
                'description' => 'However, as we look into the benefits we\'re proposing, it\'s important to point out that each one is aimed at boosting members\' profits. These benefits are meant to improve how it works and help our members increase financial returns.',
                'type' => null
            ]
        ]);

        DB::table('guide_lines')->insert(
            [
                [
                    'title' => 'Supporting Businesses of All Sizes',
                    'slug' => Str::slug('Supporting Businesses of All Sizes'),
                    'description' => '
                <p>LNF collaborates with businesses of any size, providing smaller networks or alliances with the same advantages as their larger counterparts. This ensures all members have access to advanced tools for managing relationships and operations, enabling them to operate efficiently and deliver top-notch service to their customers. LNF offers tailored solutions that address the unique needs of each business, ensuring the use of specialized tools designed for success rather than generic ones.</p>',
                    'position' => 1,
                ],
                [
                    'title' => 'Eligibility',
                    'slug' => Str::slug('Eligibility'),
                    'description' => '
                <ul>
                    <li>Proven Excellence: A demonstrated track record of excellence and professionalism in logistics.</li>
                    <li>Legal Constitution: The network must be a legally constituted entity.</li>
                    <li>Established History: Each network must have been established for at least 2 years.</li>
                    <li>Active Members: The network must have a minimum of 50 active members.</li>
                    <li>Successful Events: Each network must have hosted 2 successful events.</li>
                    <li>Code of Ethics: Adherence to the LNF Code of Ethics is required.</li>
                    <li>Online Application: An online application form must be prepared for new LNF members.</li>
                </ul>
                ',
                    'position' => 2,
                ],
                [
                    'title' => 'Rights and Responsibilities',
                    'slug' => Str::slug('Rights and Responsibilities'),
                    'description' => '
                <p>Members have the right to:</p>
                <ul>
                    <li>Participate in federation activities.</li>
                    <li>Receive benefits and services as determined by the Board of Directors.</li>
                    <li>Vote on matters presented to the membership.</li>
                </ul>
                <p>Members also have the responsibility to:</p>
                <ul>
                    <li>Uphold the values and principles of LNF.</li>
                    <li>Adhere to the LNF Code of Conduct.</li>
                </ul>
                ',
                    'position' => 3,
                ],
                [
                    'title' => 'Admission Process',
                    'slug' => Str::slug('Admission Process'),
                    'description' => '
                <p>The LNF Board of Directors reviews membership applications and grants membership based on the outlined eligibility criteria.</p>
                ',
                    'position' => 4,
                ],
                [
                    'title' => 'Termination of Membership',
                    'slug' => Str::slug('Termination of Membership'),
                    'description' => '
                <p>Membership may be terminated if a member:</p>
                <ul>
                    <li>Fails to pay membership dues within the specified time frame.</li>
                    <li>Engages in conduct detrimental to LNF or its members.</li>
                    <li>Violates the LNF Code of Ethics.</li>
                </ul>
                ',
                    'position' => 5,
                ],
                [
                    'title' => 'Termination Process',
                    'slug' => Str::slug('Termination Process'),
                    'description' => '
                <p>The Board of Directors proposes the termination of membership. The member in question is given notice of the proposed termination and an opportunity to present their case before the Board of Directors. The Board of Directors makes the final decision regarding termination.</p>
                ',
                    'position' => 6,
                ],
                [
                    'title' => 'Permitted Uses for Members',
                    'slug' => Str::slug('Permitted Uses for Members'),
                    'description' => '
                <p><strong>Stationery and Digital Presence:</strong> Members are allowed to use the LNF logo on corporate documents, business cards, and websites.</p>
                <p><strong>Exclusions:</strong> The LNF logo should not appear on members\' own house transport documents, except for recognized LNF documents published and licensed through its federation Members.</p>
                <p><strong>Promotional Activities:</strong> Members may use the LNF logo for promotional activities, provided it only signifies their membership with LNF. No other use is permitted without specific written authorization from LNF.</p>',
                    'position' => 7,
                ],
            ]

        );


        DB::table('menus')->insert(
            [
                ['name' => 'Header Menu', 'position' => 1],
                ['name' => 'About LNF', 'position' => 2],
                ['name' => 'What We Do', 'position' => 3],
            ]

        );

        DB::table('menu_items')->insert(
            [
                ['id' => 1, 'name' => 'home', 'menu_id' => 1, 'link' => '/', 'position' => 1, 'parent_id' => null],
                ['id' => 2, 'name' => 'about', 'menu_id' => 1, 'link' => '/about', 'position' => 2, 'parent_id' => null],
                ['id' => 3, 'name' => 'services', 'menu_id' => 1, 'link' => '/services', 'position' => 3, 'parent_id' => null],
                ['id' => 4, 'name' => 'membership Guidelines', 'menu_id' => 1, 'link' => '/membership', 'position' => 4, 'parent_id' => null],
                ['id' => 5, 'name' => 'events', 'menu_id' => 1, 'link' => '/events', 'position' => 5, 'parent_id' => null],
                ['id' => 6, 'name' => 'news', 'menu_id' => 1, 'link' => '/news', 'position' => 6, 'parent_id' => null],
                ['id' => 7, 'name' => 'contact', 'menu_id' => 1, 'link' => '/contact', 'position' => 7, 'parent_id' => null],
                ['id' => 14, 'name' => 'Who we are', 'menu_id' => 2, 'link' => '/about#who-we-are', 'position' => 8, 'parent_id' => null],
                ['id' => 15, 'name' => 'Governance', 'menu_id' => 2, 'link' => '/about#governance', 'position' => 9, 'parent_id' => null],
                ['id' => 16, 'name' => 'Membership Guidelines', 'menu_id' => 2, 'link' => '/membership', 'position' => 10, 'parent_id' => null],
                ['id' => 17, 'name' => 'The Core Idea', 'menu_id' => 3, 'link' => '/about#the-core-idea', 'position' => 11, 'parent_id' => null],
                ['id' => 18, 'name' => 'Services', 'menu_id' => 3, 'link' => '/services', 'position' => 12, 'parent_id' => null],
                ['id' => 19, 'name' => 'Events', 'menu_id' => 3, 'link' => '/events', 'position' => 13, 'parent_id' => null],
                //  menu_items service
                ['id' => 8, 'name' => 'Increasing Membership', 'menu_id' => 1, 'link' => '/service/increasing-membership', 'position' => 1, 'parent_id' => 3],
                ['id' => 9, 'name' => 'Catalyzing Network Profitability', 'menu_id' => 1, 'link' => '/service/catalyzing-network-profitability', 'position' => 2, 'parent_id' => 3],
                ['id' => 10, 'name' => 'Solidifying Trust through Financial Protection', 'menu_id' => 1, 'link' => '/service/solidifying-trust-through-financial-protection', 'position' => 3, 'parent_id' => 3],
                ['id' => 11, 'name' => 'Revolutionizing Conferences for Mutual Benefit', 'menu_id' => 1, 'link' => '/service/revolutionizing-conferences-for-mutual-benefit', 'position' => 4, 'parent_id' => 3],
                ['id' => 12, 'name' => 'Unified Payment Gateway', 'menu_id' => 1, 'link' => '/service/unified-payment-gateway', 'position' => 5, 'parent_id' => 3],
                ['id' => 13, 'name' => 'Blacklist Management and Shared Resources', 'menu_id' => 1, 'link' => '/service/blacklist-management-and-shared-resources', 'position' => 6, 'parent_id' => 3],
            ]
        );
    }
}
