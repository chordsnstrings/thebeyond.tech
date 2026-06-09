<?php

namespace Database\Seeders;

use App\Models\Capability;
use App\Models\PortfolioCompany;
use App\Models\ResearchArticle;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedAdmin();
        $this->seedCapabilities();
        $this->seedCompanies();
        $this->seedResearch();
    }

    protected function seedAdmin(): void
    {
        User::updateOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@thebeyond.tech')],
            [
                'name' => 'Beyond Admin',
                'password' => Hash::make(env('ADMIN_PASSWORD', 'change-me-now')),
            ]
        );
    }

    protected function seedCapabilities(): void
    {
        $items = [
            [
                'title' => 'Applied AI',
                'icon' => 'ai',
                'summary' => 'Production machine learning, LLM systems, computer vision and optimization that run live operations — not demos.',
                'body' => 'We design, ship and operate models in production: demand forecasting, routing and pricing engines, document and vision AI, and retrieval-augmented assistants embedded directly into our products.',
            ],
            [
                'title' => 'Applied Research',
                'icon' => 'research',
                'summary' => 'A research practice that turns frontier ideas into deployable advantage across the portfolio.',
                'body' => 'Our research team evaluates emerging methods, prototypes rapidly, and hardens what works into shared infrastructure every ARKS company can build on.',
            ],
            [
                'title' => 'Product Engineering',
                'icon' => 'engineering',
                'summary' => 'Full-stack platforms, mobile apps and cloud infrastructure built to scale across markets.',
                'body' => 'From driver and customer apps to internal operating systems, we build resilient, secure software with a shared component library and a single deployment backbone.',
            ],
            [
                'title' => 'Data & Platforms',
                'icon' => 'data',
                'summary' => 'Unified data, analytics and decision systems that give every company a real-time operating picture.',
                'body' => 'A common data platform connects mobility, energy, migration and wellness — powering dashboards, experimentation and the models that sit on top.',
            ],
        ];

        foreach ($items as $i => $item) {
            Capability::updateOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($item['title'])],
                array_merge($item, ['sort_order' => $i, 'is_published' => true])
            );
        }
    }

    protected function seedCompanies(): void
    {
        $items = [
            [
                'name' => 'Ecosine',
                'sector' => 'Sustainable Mobility',
                'summary' => 'Operator of one of Dubai’s largest electric limousine fleets, redefining premium zero-emission transport.',
                'site_url' => 'https://www.arks.ae',
                'capabilities_delivered' => ['Fleet intelligence', 'Demand forecasting', 'Driver app', 'Routing & dispatch'],
                'metrics' => ['fleet' => 'EV fleet', 'focus' => 'Premium mobility'],
            ],
            [
                'name' => 'Powerdrive',
                'sector' => 'EV Charging · CPO',
                'summary' => 'A fast-scaling charging-point operator expanding its network of public and fleet charging across the UAE.',
                'site_url' => 'https://www.arks.ae',
                'capabilities_delivered' => ['Charge-point orchestration', 'Energy analytics', 'Driver app', 'IoT telemetry'],
                'metrics' => ['network' => '100+ points target', 'role' => 'CPO licence holder'],
            ],
            [
                'name' => 'Migration Services',
                'sector' => 'Global Mobility',
                'summary' => 'End-to-end immigration and relocation services for individuals and businesses seeking global mobility.',
                'site_url' => 'https://www.arks.ae',
                'capabilities_delivered' => ['Case automation', 'Document AI', 'Client portal', 'Workflow engine'],
                'metrics' => ['since' => 'Est. 2015'],
            ],
            [
                'name' => 'Wellness',
                'sector' => 'D2C · Health',
                'summary' => 'A direct-to-consumer wellness platform offering premium natural products for health-conscious consumers.',
                'site_url' => 'https://www.arks.ae',
                'capabilities_delivered' => ['Commerce platform', 'Personalization', 'Growth analytics', 'Subscriptions'],
                'metrics' => ['since' => 'Est. 2021'],
            ],
        ];

        foreach ($items as $i => $item) {
            PortfolioCompany::updateOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($item['name'])],
                array_merge($item, ['sort_order' => $i, 'is_published' => true])
            );
        }
    }

    protected function seedResearch(): void
    {
        $items = [
            [
                'title' => 'Operating models in production: lessons from fleet-scale AI',
                'category' => 'Applied AI',
                'author' => 'Beyond Research',
                'read_minutes' => 7,
                'excerpt' => 'What it takes to move forecasting and routing models from notebooks to a live electric fleet — and keep them honest.',
            ],
            [
                'title' => 'A shared data backbone across four industries',
                'category' => 'Data & Platforms',
                'author' => 'Beyond Research',
                'read_minutes' => 6,
                'excerpt' => 'How a single data platform connects mobility, energy, migration and wellness — and why that compounds.',
            ],
            [
                'title' => 'Document AI for high-stakes workflows',
                'category' => 'Research',
                'author' => 'Beyond Research',
                'read_minutes' => 5,
                'excerpt' => 'Designing extraction and review systems where accuracy, auditability and trust are non-negotiable.',
            ],
        ];

        foreach ($items as $i => $item) {
            ResearchArticle::updateOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($item['title'])],
                array_merge($item, [
                    'body' => $this->sampleBody(),
                    'is_published' => true,
                    'published_at' => now()->subDays(($i + 1) * 9),
                    'meta_description' => $item['excerpt'],
                ])
            );
        }
    }

    protected function sampleBody(): string
    {
        return <<<'HTML'
<p>At Beyond, research is not a side project — it is the mechanism by which the ARKS portfolio stays ahead. Every model, platform and product decision is grounded in evidence and pressure-tested against real operations.</p>
<h2>From frontier to floor</h2>
<p>We treat the gap between a promising method and a dependable production system as the real work. That means rigorous evaluation, careful instrumentation, and a bias toward systems that degrade gracefully.</p>
<blockquote>The goal is not the most sophisticated model. It is the most dependable advantage.</blockquote>
<h3>What we measure</h3>
<ul>
<li>Operational impact, not benchmark scores in isolation.</li>
<li>Latency and cost at the scale our companies actually run.</li>
<li>Auditability and trust for high-stakes decisions.</li>
</ul>
<p>This is how a single technology engine can compound advantage across mobility, energy, migration and wellness at once.</p>
HTML;
    }
}
