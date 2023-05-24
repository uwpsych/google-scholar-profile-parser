<?php

namespace GScholarProfileParser\Entity;

class Statistics
{
    public function __construct(
        public readonly int $nbCitations,
        public readonly int $nbCitationsSince,
        public readonly int $hIndex,
        public readonly int $hIndexSince,
        public readonly int $i10Index,
        public readonly int $i10IndexSince,
        public readonly int $sinceYear,
        public array $nbCitationsPerYear,
    )
    {
        foreach($nbCitationsPerYear as $key => $count) {
            $this->nbCitationsPerYear[$key] = (int)$count;
        }
    }
}
