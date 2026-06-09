<?php

/**
 * Glossary terms. Rendered at /glossary with DefinedTermSet + DefinedTerm
 * JSON-LD — a concentrated source of long-tail definitions that both search
 * snippets and LLM answer engines can extract cleanly.
 *
 * Each entry: term, definition, optional 'link' to a fuller article.
 */
return [
    [
        'term' => 'Applied AI',
        'definition' => 'The discipline of turning machine-learning models into dependable production systems that run real operations — handling data, evaluation, monitoring, latency, cost and failure modes, not just model accuracy.',
        'link' => '/research/what-is-applied-ai-from-models-to-production-systems',
    ],
    [
        'term' => 'Retrieval-Augmented Generation (RAG)',
        'definition' => 'An AI architecture where a language model retrieves relevant documents from a knowledge base and uses them as context to generate grounded, source-backed answers, reducing hallucination.',
        'link' => '/research/retrieval-augmented-generation-rag-explained-for-operators',
    ],
    [
        'term' => 'Document AI',
        'definition' => 'Technology that reads documents, extracts key fields, validates them and passes structured data into downstream systems — also called intelligent document processing (IDP).',
        'link' => '/research/document-ai-automating-high-stakes-paperwork',
    ],
    [
        'term' => 'AI Agent',
        'definition' => 'A system that uses a language model to plan steps and take actions — calling tools, querying data or triggering workflows — to accomplish a goal, rather than only producing text.',
        'link' => '/research/ai-agents-explained-what-they-are-and-how-they-work',
    ],
    [
        'term' => 'Vector Database',
        'definition' => 'A database that stores embeddings — numerical representations of meaning — and finds the most similar items to a query, enabling semantic search and powering RAG systems.',
        'link' => '/research/vector-databases-explained-the-memory-behind-ai-search',
    ],
    [
        'term' => 'Embedding',
        'definition' => 'A numerical representation of text or other data that captures its meaning, so that similar meanings produce similar vectors. Embeddings underpin semantic search and recommendations.',
    ],
    [
        'term' => 'Large Language Model (LLM)',
        'definition' => 'A machine-learning model trained on vast text data that can understand and generate language, used for tasks from writing and summarising to reasoning and tool use.',
        'link' => '/research/llms-in-production-managing-cost-latency-and-reliability',
    ],
    [
        'term' => 'Prompt Engineering',
        'definition' => 'The practice of writing clear, well-structured instructions and context so an AI model produces useful, reliable outputs for a specific task.',
        'link' => '/research/prompt-engineering-for-business-teams-a-practical-primer',
    ],
    [
        'term' => 'Predictive Maintenance',
        'definition' => 'Using sensor and usage data to forecast when equipment is likely to fail, so it can be serviced just in time — avoiding both breakdowns and unnecessary servicing.',
        'link' => '/research/predictive-maintenance-with-ai-fixing-things-before-they-break',
    ],
    [
        'term' => 'Generative Engine Optimization (GEO)',
        'definition' => 'The practice of structuring and writing content so AI answer engines can understand, trust and cite it within generated responses.',
        'link' => '/research/generative-engine-optimization-geo-how-to-show-up-in-ai-answers',
    ],
    [
        'term' => 'Answer Engine Optimization (AEO)',
        'definition' => 'Optimising content to be surfaced as a direct answer in search engines and AI assistants — in featured snippets, voice results and generated responses — rather than just a link.',
        'link' => '/research/what-is-answer-engine-optimization-aeo-a-2026-guide',
    ],
    [
        'term' => 'Charge Point Operator (CPO)',
        'definition' => 'The company that installs, operates and maintains EV charging stations, including the back-end software that authorises sessions, processes payments and monitors uptime.',
        'link' => '/research/what-is-a-charge-point-operator-cpo-how-ev-charging-networks-work',
    ],
    [
        'term' => 'e-Mobility Service Provider (eMSP)',
        'definition' => 'The company that provides the EV driver experience — the app, account and billing that let drivers access and pay for charging across networks.',
        'link' => '/research/what-is-a-charge-point-operator-cpo-how-ev-charging-networks-work',
    ],
    [
        'term' => 'AC Charging',
        'definition' => 'Alternating-current EV charging, typically slower and cheaper, used at home and destinations where a vehicle is parked for a while.',
        'link' => '/research/ev-charging-in-dubai-the-complete-2026-guide',
    ],
    [
        'term' => 'DC Fast Charging',
        'definition' => 'High-power direct-current EV charging that delivers a rapid top-up — often 20% to 80% in 20–40 minutes — used on highways and quick stops.',
        'link' => '/research/how-long-does-it-take-to-charge-an-electric-car',
    ],
    [
        'term' => 'Wallbox',
        'definition' => 'A wall-mounted AC EV charger (commonly 7–22 kW) installed at home or work, charging faster and more safely than a standard socket.',
        'link' => '/research/ev-home-charging-in-dubai-wallbox-installation-guide',
    ],
    [
        'term' => 'State of Charge (SoC)',
        'definition' => "An electric vehicle battery's current charge level, expressed as a percentage of its capacity — the EV equivalent of a fuel gauge.",
    ],
    [
        'term' => 'Total Cost of Ownership (TCO)',
        'definition' => 'The full cost of owning an asset over time — purchase, energy or fuel, maintenance and depreciation — used to compare options like EV versus petrol fairly.',
        'link' => '/research/ev-vs-petrol-in-the-uae-total-cost-of-ownership',
    ],
    [
        'term' => 'UAE Golden Visa',
        'definition' => 'A long-term UAE residence permit for investors, entrepreneurs, specialised talent and other high achievers, issued for extended renewable terms.',
        'link' => '/research/uae-golden-visa-2026-eligibility-cost-and-how-to-apply',
    ],
    [
        'term' => 'Emirates ID',
        'definition' => 'The central identity document for UAE residents, tied to a residence visa and required for banking, telecoms, tenancy and government services.',
        'link' => '/research/moving-to-dubai-in-2026-the-complete-relocation-checklist',
    ],
    [
        'term' => 'Demand Forecasting',
        'definition' => 'Using historical and real-time data to predict future demand by time and location, so resources such as vehicles or inventory can be positioned ahead of need.',
        'link' => '/research/ai-in-fleet-management-how-electric-fleets-cut-costs-and-emissions',
    ],
    [
        'term' => 'Smart Charging',
        'definition' => 'Scheduling EV charging sessions to minimise energy cost and protect battery health, while balancing load so many vehicles can charge without overloading a connection.',
        'link' => '/research/ai-in-fleet-management-how-electric-fleets-cut-costs-and-emissions',
    ],
    [
        'term' => 'Churn Prediction',
        'definition' => 'Modelling behavioural and transactional data to identify customers at risk of lapsing, so a business can intervene before they leave.',
        'link' => '/research/customer-retention-analytics-for-d2c-brands',
    ],
    [
        'term' => 'Modern Data Stack',
        'definition' => 'A set of cloud tools that ingest, store, transform and activate data — turning scattered raw data into reliable, decision-ready information.',
        'link' => '/research/building-a-modern-data-stack-a-starter-guide',
    ],
];
