-- VALUEMAP kick-off News article. Import through phpMyAdmin after the content_items table exists.
-- Repeated imports update the same article and do not create duplicates.
SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci;
SET collation_connection = 'utf8mb4_unicode_ci';
START TRANSACTION;

SET @article_title = 'VALUEMAP Project Officially Kicks Off: Towards Sustainable Value-Sharing in European Health Data';
SET @article_slug = 'valuemap-project-officially-kicks-off';
SET @article_excerpt = 'The online kick-off meeting officially launched VALUEMAP’s 18-month journey towards sustainable value-sharing in the secondary use of health data across Europe.';
SET @article_body = 'The online kick-off meeting of the Horizon Europe project **VALUEMAP – Enabling Value-Sharing and Adoption of Health Data Business Models** has officially marked the beginning of an 18-month journey towards more sustainable, interoperable and collaborative approaches to the secondary use of health data across Europe.

As Europe advances the implementation of the European Health Data Space (EHDS), enabling the secondary use of electronic health data is becoming increasingly important for health research, innovation and the development of data-driven solutions. However, unlocking the full potential of health data requires more than access alone. Sustainable implementation also depends on viable business models, effective value-sharing mechanisms, stronger connections between stakeholders and approaches that can be adapted across different national and regional health ecosystems.

The project will explore how secondary health data can move beyond fragmented practices towards a shared, actionable European approach, supported by sustainable business models and solutions capable of creating and distributing long-term value for health research and innovation.

## From Fragmented Practices to Shared Action

Over the course of the project, the VALUEMAP consortium will map existing practices and business models related to the secondary use of health data, engage stakeholders across European health data ecosystems, and identify key barriers, opportunities and enabling factors for sustainable adoption. The findings will be translated into practical pathways and recommendations that can support stakeholders in developing and implementing effective health data business models while fostering collaboration across different European ecosystems.

A central question guiding the project is: **How can we ensure that the value generated from secondary health data is created and shared fairly, sustainably and effectively?**

By bringing together expertise from research, healthcare, industry and innovation ecosystems, VALUEMAP aims to contribute to a more connected European health data landscape, where data can support innovation while creating sustainable value for the stakeholders and communities involved.

With the EHDS providing an important European framework for health data sharing and secondary use, VALUEMAP will focus on the practical and economic dimensions needed to support its long-term adoption. The project will examine how existing initiatives and approaches can be connected, scaled and translated into solutions that work across diverse healthcare and innovation environments. Through stakeholder engagement and evidence-based analysis, VALUEMAP will contribute to identifying pathways that can help bridge the gap between policy ambitions and sustainable implementation.

Over the next 18 months, the project will share insights, activities, events, resources and results, creating opportunities for stakeholders across Europe to follow the project’s progress and contribute to the conversation around the future of health data.';

UPDATE `content_items` SET
    `title`=@article_title,
    `excerpt`=@article_excerpt,
    `body`=@article_body,
    `published_at`='2026-10-01',
    `category`='Project update',
    `image_path`='images/valuemap-kickoff-2026.jpg',
    `status`='published',
    `is_public`=1,
    `approval_status`='approved',
    `approved_at`=NOW(),
    `updated_at`=NOW()
WHERE `slug`=@article_slug;

UPDATE `content_items` SET
    `title`=@article_title,
    `slug`=@article_slug,
    `excerpt`=@article_excerpt,
    `body`=@article_body,
    `published_at`='2026-10-01',
    `category`='Project update',
    `image_path`='images/valuemap-kickoff-2026.jpg',
    `status`='published',
    `is_public`=1,
    `approval_status`='approved',
    `approved_at`=NOW(),
    `updated_at`=NOW()
WHERE `slug`='valuemap-begins-its-work-across-europe'
  AND `body` LIKE '%draft website content%'
  AND NOT EXISTS (
      SELECT 1
      FROM (SELECT `id` FROM `content_items` WHERE `slug`=@article_slug) AS existing_article
  );

INSERT INTO `content_items`
    (`type`,`title`,`slug`,`excerpt`,`body`,`published_at`,`category`,`image_path`,`status`,`is_public`,`approval_status`,`approved_at`,`sort_order`,`created_at`,`updated_at`)
SELECT
    'news',@article_title,@article_slug,@article_excerpt,@article_body,'2026-10-01','Project update','images/valuemap-kickoff-2026.jpg','published',1,'approved',NOW(),0,NOW(),NOW()
WHERE NOT EXISTS (
    SELECT 1 FROM `content_items` WHERE `slug`=@article_slug
);

UPDATE `content_items` SET
    `status`='draft',
    `is_public`=0,
    `approval_status`='draft',
    `updated_at`=NOW()
WHERE `slug`='valuemap-begins-its-work-across-europe'
  AND `body` LIKE '%draft website content%'
  AND EXISTS (
      SELECT 1
      FROM (SELECT `id` FROM `content_items` WHERE `slug`=@article_slug) AS existing_article
  );

COMMIT;
