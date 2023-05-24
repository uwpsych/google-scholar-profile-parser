<?php

namespace GScholarProfileParser\Entity;

use PHPUnit\Framework\TestCase;

class StatisticsTest extends TestCase
{
    private $properties;

    protected function setUp(): void
    {
        $this->properties = [
            'nbCitations' => 1,
            'nbCitationsSince' => 1,
            'hIndex' => 1,
            'hIndexSince' => 1,
            'i10Index' => 1,
            'i10IndexSince' => 1,
            'sinceYear' => 2010,
            'nbCitationsPerYear' => [2018 => 10, 2019 => 20],
        ];
    }

    private function createUnitUnderTest(array $properties): Statistics
    {
        return new Statistics(...$properties);
    }

    public function testGetNbCitations(): void
    {
        $uut = $this->createUnitUnderTest($this->properties);

        $this->assertSame((int)$this->properties['nbCitations'], $uut->nbCitations);
    }

    public function testGetNbCitationsSince(): void
    {
        $uut = $this->createUnitUnderTest($this->properties);

        $this->assertSame((int)$this->properties['nbCitationsSince'], $uut->nbCitationsSince);
    }

    public function testGetHIndex(): void
    {
        $uut = $this->createUnitUnderTest($this->properties);

        $this->assertSame((int)$this->properties['hIndex'], $uut->hIndex);
    }

    public function testGetHIndexSince(): void
    {
        $uut = $this->createUnitUnderTest($this->properties);

        $this->assertSame((int)$this->properties['hIndexSince'], $uut->hIndexSince);
    }

    public function testGetI10Index(): void
    {
        $uut = $this->createUnitUnderTest($this->properties);

        $this->assertSame((int)$this->properties['i10Index'], $uut->i10Index);
    }

    public function testGetI10IndexSince(): void
    {
        $uut = $this->createUnitUnderTest($this->properties);

        $this->assertSame((int)$this->properties['i10IndexSince'], $uut->i10IndexSince);
    }

    public function testGetSinceYear(): void
    {
        $uut = $this->createUnitUnderTest($this->properties);

        $this->assertSame((int)$this->properties['sinceYear'], $uut->sinceYear);
    }

    public function testGetNbCitationsPerYear(): void
    {
        $uut = $this->createUnitUnderTest($this->properties);

        $this->assertSame($this->properties['nbCitationsPerYear'], $uut->nbCitationsPerYear);
    }
}
