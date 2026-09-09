<?php

namespace Database\Seeders;

use App\Models\ContentItem;
use Illuminate\Database\Seeder;

class ContentSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'type' => 'news', 'title' => 'ValueMap begins its work across Europe',
                'slug' => 'valuemap-begins-its-work-across-europe', 'category' => 'Project update',
                'excerpt' => 'Nine partners from six countries are starting a shared effort to map how European health data ecosystems create value.',
                'body' => "The ValueMap consortium has officially begun its work. The project brings together nine partners from six European countries to examine the actors, resources, relationships and conditions that shape health data ecosystems.\n\nThis initial update is draft website content and will be replaced with the consortium-approved announcement and partner quotations.",
                'published_at' => '2026-09-08', 'status' => 'published', 'is_public' => true,
            ],
            [
                'type' => 'event', 'title' => 'ValueMap consortium meeting in Budapest',
                'slug' => 'valuemap-consortium-meeting-budapest', 'category' => 'Consortium meeting',
                'excerpt' => 'The consortium will meet in Budapest in early October to align the research programme and review the advanced website version.',
                'body' => "The ValueMap partners will convene in Budapest in early October. The meeting will align the next implementation steps and provide a shared space to review the project's public communication platform.\n\nThe exact date, venue and public participation details are pending confirmation.",
                'published_at' => '2026-09-08', 'event_date' => '2026-10-01 09:00:00', 'status' => 'forthcoming', 'is_public' => true,
            ],
            [
                'type' => 'deliverable', 'title' => 'ValueMap public results library',
                'slug' => 'valuemap-public-results-library', 'reference_code' => 'Coming soon',
                'excerpt' => 'Public deliverables and supporting project outputs will be released here as the project progresses.',
                'body' => "This record demonstrates how a public deliverable will appear. Each item can include a reference number, responsible partner, publication date, status, full description and downloadable document.\n\nThe first consortium-approved public materials are expected from late October.",
                'published_at' => '2026-09-08', 'status' => 'forthcoming', 'is_public' => true,
            ],
            [
                'type' => 'newsletter', 'title' => 'The ValueMap newsletter archive is ready',
                'slug' => 'valuemap-newsletter-archive', 'category' => 'Newsletter',
                'excerpt' => 'Every edition of the ValueMap newsletter will be available to read and download from this communication hub.',
                'body' => 'Newsletter editions will be published here with a short summary, publication date and downloadable PDF. This draft item marks the future archive location.',
                'published_at' => '2026-09-08', 'status' => 'forthcoming', 'is_public' => true,
            ],
        ];

        foreach ($items as $item) {
            ContentItem::updateOrCreate(['slug' => $item['slug']], $item);
        }
    }
}
