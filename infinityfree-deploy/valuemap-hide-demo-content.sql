-- Hide the original example content; keep the records available in the admin panel.
-- An edited real publication with the same slug is not changed.
START TRANSACTION;
UPDATE `content_items` SET `status`='draft', `is_public`=0, `approval_status`='draft', `updated_at`=NOW() WHERE `slug`='valuemap-newsletter-archive' AND `body` LIKE '%This draft item marks the future archive location.%';
UPDATE `content_items` SET `status`='draft', `is_public`=0, `approval_status`='draft', `updated_at`=NOW() WHERE `slug`='valuemap-consortium-meeting-budapest' AND `body` LIKE '%The exact date, venue and public participation details are pending confirmation.%';
UPDATE `content_items` SET `status`='draft', `is_public`=0, `approval_status`='draft', `updated_at`=NOW() WHERE `slug`='valuemap-public-results-library' AND `body` LIKE '%This record demonstrates how a public deliverable will appear.%';
UPDATE `content_items` SET `status`='draft', `is_public`=0, `approval_status`='draft', `updated_at`=NOW() WHERE `slug`='valuemap-begins-its-work-across-europe' AND `body` LIKE '%This initial update is draft website content%';
COMMIT;
