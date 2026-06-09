<?php

namespace Tests\Feature;

use App\Models\ContactSubmission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SiteTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_public_pages_load(): void
    {
        foreach (['/', '/about', '/capabilities', '/portfolio', '/research', '/contact'] as $path) {
            $this->get($path)->assertOk();
        }
    }

    public function test_home_exposes_organization_structured_data(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('"@type":"Organization"', false)
            ->assertSee('parentOrganization', false);
    }

    public function test_research_detail_renders_with_article_schema(): void
    {
        $slug = \App\Models\ResearchArticle::query()->value('slug');

        $this->get('/research/'.$slug)
            ->assertOk()
            ->assertSee('"@type":"Article"', false);
    }

    public function test_sitemap_is_xml(): void
    {
        $this->get('/sitemap.xml')
            ->assertOk()
            ->assertHeader('Content-Type', 'application/xml; charset=utf-8')
            ->assertSee('<urlset', false);
    }

    public function test_llms_txt_is_served(): void
    {
        $this->get('/llms.txt')
            ->assertOk()
            ->assertHeader('Content-Type', 'text/plain; charset=utf-8')
            ->assertSee('# Beyond')
            ->assertSee('## Research & guides', false);
    }

    public function test_rss_feed_is_served(): void
    {
        $this->get('/feed.xml')
            ->assertOk()
            ->assertSee('<rss', false)
            ->assertSee('Research', false);
    }

    public function test_article_emits_faq_and_breadcrumb_schema(): void
    {
        $slug = \App\Models\ResearchArticle::published()
            ->whereNotNull('faqs')->value('slug');

        $this->get('/research/'.$slug)
            ->assertOk()
            ->assertSee('"@type":"FAQPage"', false)
            ->assertSee('"@type":"BreadcrumbList"', false)
            ->assertSee('Key takeaways');
    }

    public function test_research_search_filters_results(): void
    {
        $this->get('/research?q=charging')
            ->assertOk()
            ->assertSee('Charging');

        $this->get('/research?q=zzzznomatch')
            ->assertOk()
            ->assertSee('No articles match');
    }

    public function test_home_emits_website_schema_with_search_action(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('"@type":"WebSite"', false)
            ->assertSee('SearchAction', false);
    }

    public function test_mobile_user_agent_receives_mobile_templates(): void
    {
        $mobileUa = 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_0 like Mac OS X) AppleWebKit/605.1.15 Mobile/15E148';

        $this->get('/', ['User-Agent' => $mobileUa])
            ->assertOk()
            ->assertSee('m-drawer', false)
            ->assertSee('hero--mobile', false);

        $this->get('/', ['User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15)'])
            ->assertOk()
            ->assertDontSee('hero--mobile', false);
    }

    public function test_contact_form_stores_submission(): void
    {
        $this->post('/contact', [
            'name' => 'Jane Partner',
            'email' => 'jane@fund.com',
            'inquiry_type' => 'investor',
            'message' => 'Keen to learn more about the thesis.',
        ])->assertRedirect();

        $this->assertDatabaseHas('contact_submissions', ['email' => 'jane@fund.com']);
        $this->assertSame(1, ContactSubmission::count());
    }

    public function test_contact_form_rejects_honeypot_spam(): void
    {
        $this->post('/contact', [
            'name' => 'Bot',
            'email' => 'bot@spam.com',
            'inquiry_type' => 'general',
            'message' => 'spam',
            'company_website' => 'http://spam.example',
        ])->assertSessionHasErrors('company_website');

        $this->assertSame(0, ContactSubmission::count());
    }

    public function test_glossary_loads_with_defined_term_schema(): void
    {
        $this->get('/glossary')
            ->assertOk()
            ->assertSee('"@type":"DefinedTermSet"', false)
            ->assertSee('"@type":"DefinedTerm"', false)
            ->assertSee('Applied AI');
    }

    public function test_category_hub_shows_intro_copy(): void
    {
        $this->get('/research?category=Applied AI')
            ->assertOk()
            ->assertSee('topic-intro', false);
    }

    public function test_content_library_is_substantial(): void
    {
        $this->assertGreaterThanOrEqual(30, \App\Models\ResearchArticle::published()->count());
    }

    public function test_admin_requires_authentication(): void
    {
        $this->get('/admin')->assertRedirect('/admin/login');
    }

    public function test_admin_can_sign_in_with_seeded_credentials(): void
    {
        $this->post('/admin/login', [
            'email' => 'admin@thebeyond.tech',
            'password' => 'change-me-now',
        ])->assertRedirect('/admin');

        $this->get('/admin')->assertOk()->assertSee('Dashboard');
    }
}
