<?php

require __DIR__ . '/../vendor/autoload.php';

use GScholarProfileParser\DomCrawler\ProfilePageCrawler;
use GScholarProfileParser\Iterator\PublicationYearFilterIterator;
use GScholarProfileParser\Parser\PublicationParser;
use GScholarProfileParser\Entity\Publication;
use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\HttpClient\HttpClient;

/** @var HttpBrowser $browser */
$browser = new HttpBrowser(HttpClient::create());

/** @var ProfilePageCrawler $crawler */
$crawler = new ProfilePageCrawler($browser, '8daWuo4AAAAJ'); // the second parameter is the scholar's profile id

/** @var PublicationParser $parser */
$parser = new PublicationParser($crawler->getCrawler());

/** @var array<int, array<string, string>> $publications */
$publications = $parser->parse();

// hydrates items of $publications into Publication
foreach ($publications as &$publication) {
    $publication = new Publication(...$publication);
}
unset($publication);

/** @var Publication $latestPublication */
$latestPublication = $publications[0];

// displays latest publication data
echo $latestPublication->title, "\n";
echo $latestPublication->getPublicationURL(), "\n";
echo $latestPublication->authors, "\n";
echo $latestPublication->publisherDetails, "\n";
echo $latestPublication->nbCitations, "\n";
echo $latestPublication->citationsURL, "\n";
echo $latestPublication->year, "\n";

/** @var PublicationYearFilterIterator $publications2018 */
$publications2018 = new PublicationYearFilterIterator(new ArrayIterator($publications), 2018);

// displays list of publications published in 2018
/** @var Publication $publication */
foreach ($publications2018 as $publication) {
    echo $publication->title, "\n";
    echo $publication->getPublicationURL(), "\n";
    echo $publication->authors, "\n";
    echo $publication->publisherDetails, "\n";
    echo $publication->nbCitations, "\n";
    echo $publication->citationsURL, "\n";
    echo $publication->year, "\n";
}
