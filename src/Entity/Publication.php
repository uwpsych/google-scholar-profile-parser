<?php

namespace GScholarProfileParser\Entity;

use GScholarProfileParser\DomCrawler\ProfilePageCrawler;

class Publication
{
    public function __construct(
        /** Title */
        public readonly string $title,
        
        /** Relative path on Google Scholar to publication's detail web page */
        public readonly string $publicationPath,
        
        /** List of authors, comma separated */
        public readonly string $authors,
        
        /** Journal name, volume, issue, pages */
        public readonly string $publisherDetails,
        
        /** Year of publication */
        public readonly int $year,
        
        /** Number of citations */
        public readonly ?int $nbCitations = null,
        
        /** URL on Google Scholar to publication's citations web page */
        public readonly ?string $citationsURL = null,
    )
    {
        // 
    }

    public function getPublicationURL(): string
    {
        return ProfilePageCrawler::getSchemeAndHostname() . $this->publicationPath;
    }
}
