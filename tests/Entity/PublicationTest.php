<?php

namespace GScholarProfileParser\Entity;

use GScholarProfileParser\DomCrawler\ProfilePageCrawler;
use PHPUnit\Framework\TestCase;

class PublicationTest extends TestCase
{
    private $properties;

    protected function setUp(): void
    {
        $this->properties = [
            'title' => 'A Title',
            'publicationPath' => 'a-publication-path',
            'authors' => 'Author 1, Author 2',
            'publisherDetails' => 'A Journal, volume 1, issue 1, pages 1-10',
            'nbCitations' => 1,
            'citationsURL' => 'http://domain.tld/citation',
            'year' => 2019,
        ];
    }

    private function createUnitUnderTest(array $properties): Publication
    {
        return new Publication(...$properties);
    }

    public function testGetTitle(): void
    {
        $uut = $this->createUnitUnderTest($this->properties);

        $this->assertSame($this->properties['title'], $uut->title);
    }

    public function testGetPublicationPath(): void
    {
        $uut = $this->createUnitUnderTest($this->properties);

        $this->assertSame($this->properties['publicationPath'], $uut->publicationPath);
    }

    public function testGetPublicationURL(): void
    {
        $uut = $this->createUnitUnderTest($this->properties);

        $this->assertSame(ProfilePageCrawler::getSchemeAndHostname() . $this->properties['publicationPath'], $uut->getPublicationURL());
    }

    public function testGetAuthors(): void
    {
        $uut = $this->createUnitUnderTest($this->properties);

        $this->assertSame($this->properties['authors'], $uut->authors);
    }

    public function testGetPublisherDetails(): void
    {
        $uut = $this->createUnitUnderTest($this->properties);

        $this->assertSame($this->properties['publisherDetails'], $uut->publisherDetails);
    }

    public function testGetNbCitations(): void
    {
        $uut = $this->createUnitUnderTest($this->properties);

        $this->assertSame((int)$this->properties['nbCitations'], $uut->nbCitations);
    }

    public function testGetNbCitationsWhenNull(): void
    {
        $this->properties['nbCitations'] = null;
        $uut = $this->createUnitUnderTest($this->properties);

        $this->assertSame($this->properties['nbCitations'], $uut->nbCitations);
    }

    public function testGetCitationsURL(): void
    {
        $uut = $this->createUnitUnderTest($this->properties);

        $this->assertSame($this->properties['citationsURL'], $uut->citationsURL);
    }

    public function testGetCitationsURLWhenNull(): void
    {
        $this->properties['citationsURL'] = null;
        $uut = $this->createUnitUnderTest($this->properties);

        $this->assertSame($this->properties['citationsURL'], $uut->citationsURL);
    }

    public function testGetYear(): void
    {
        $uut = $this->createUnitUnderTest($this->properties);

        $this->assertSame((int)$this->properties['year'], $uut->year);
    }
}
