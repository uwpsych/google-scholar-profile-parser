# Google Scholar Profile Parser

[![Latest Stable Version](https://poser.pugx.org/bborrel/google-scholar-profile-parser/v/stable)](https://packagist.org/packages/bborrel/google-scholar-profile-parser)
[![Minimum PHP Version](https://img.shields.io/packagist/php-v/bborrel/google-scholar-profile-parser.svg?maxAge=3600)](https://packagist.org/packages/bborrel/google-scholar-profile-parser)
[![Total Downloads](https://poser.pugx.org/bborrel/google-scholar-profile-parser/downloads)](https://packagist.org/packages/bborrel/google-scholar-profile-parser)
[![License](https://poser.pugx.org/bborrel/google-scholar-profile-parser/license)](https://packagist.org/packages/bborrel/google-scholar-profile-parser)

[![Tested on PHP 7.2 to 7.4](https://img.shields.io/badge/tested%20on-PHP%207.2%20|%207.3%20|%207.4%20-brightgreen.svg?maxAge=2419200)](https://travis-ci.com/bborrel/google-scholar-profile-parser)
[![Build Status](https://travis-ci.com/bborrel/google-scholar-profile-parser.svg?branch=master)](https://travis-ci.com/bborrel/google-scholar-profile-parser)
[![Coverage Status](https://coveralls.io/repos/github/bborrel/google-scholar-profile-parser/badge.svg?branch=master)](https://coveralls.io/github/bborrel/google-scholar-profile-parser?branch=master)
[![Mutation testing badge](https://badge.stryker-mutator.io/github.com/bborrel/google-scholar-profile-parser/master)](https://stryker-mutator.github.io)
[![Maintainability](https://api.codeclimate.com/v1/badges/a99a88d28ad37a79dbf6/maintainability)](https://codeclimate.com/github/codeclimate/codeclimate/maintainability)

Google Scholar Profile Parser is a PHP library which parses the HTML of a scholar's profile page from Google Scholar 
website and transforms its data into a regular PHP data structure.

The parsed data from a scholar is:

- his/her list of publications (title, link, authors, publisher details, citations)
- his/her citations' statistics (number of citations, h-index, i10-index)

## Table of content

- [Google Scholar Profile Parser](#google-scholar-profile-parser)
  - [Table of content](#table-of-content)
  - [Project Rationale](#project-rationale)
  - [Requirements](#requirements)
  - [Installation](#installation)
  - [Usage](#usage)
    - [Publications](#publications)
    - [Statistics](#statistics)
  - [Versioning](#versioning)
  - [Code Quality](#code-quality)
  - [Author](#author)
  - [License](#license)

## Project Rationale

As explained by this [Wikipedia page][1]:

> Google Scholar is a freely accessible web search engine that indexes the full text or metadata of scholarly literature
> across an array of publishing formats and disciplines.Google Scholar is a website which indexes scholars' publications
> and citations.

Unfortunately [Google Scholar][2] website doesn't provide an API and I needed a way to fetch a scholar's data.

So, while I was looking for a PHP library which parses a profile page from Google Scholar website, I only found 
[Scholar parser][3] from [Daniel Schreij][4]. But I was unhappy with this library's dependency upon [PhantomJS][5] 
which development is suspended (and will likely not resume, leaving users without support). So I decided to rewrite this
library redesigning it to depend only on PHP, and no more Javascript.

## Requirements

As stated in [composer.json][6], it requires:

- PHP 7.1+
- PHP DOM extension

To run this library on PHP 5.6+, install its version 1.x.

## Installation

Use [Composer][7] to download and install this library as well as its dependencies.

```bash
composer require bborrel/google-scholar-profile-parser
```

## Usage

### Publications
```php
use GScholarProfileParser\DomCrawler\ProfilePageCrawler;
use GScholarProfileParser\Parser\PublicationParser;
use GScholarProfileParser\Entity\Publication;

$crawler = new ProfilePageCrawler(profileId: '8daWuo4AAAAJ');

$parser = new PublicationParser($crawler);
$publications = $parser->parse();

$latestPublication = $publications[0];

// displays latest publication data
echo $latestPublication->title, "\n";
echo $latestPublication->getPublicationURL(), "\n";
echo $latestPublication->authors, "\n";
echo $latestPublication->publisherDetails, "\n";
echo $latestPublication->nbCitations, "\n";
echo $latestPublication->citationsURL, "\n";
echo $latestPublication->year, "\n";
```

### Statistics
```php
use GScholarProfileParser\DomCrawler\ProfilePageCrawler;
use GScholarProfileParser\Entity\Statistics;
use GScholarProfileParser\Parser\StatisticsParser;

$crawler = new ProfilePageCrawler(profileId: '8daWuo4AAAAJ');

$parser = new StatisticsParser($crawler);
$statistics = new Statistics(...$parser->parse());

$nbCitationsPerYear = $statistics->nbCitationsPerYear;
$sinceYear = $statistics->sinceYear;

$nbCitationsSinceYear = 0;
foreach ($nbCitationsPerYear as $year => $nbCitations) {
    if ($year >= $sinceYear) {
        $nbCitationsSinceYear += $nbCitations;
    }
}

// display statistics
echo sprintf("           All\t%4d\n", $sinceYear);
echo sprintf("Citations: %4d\t%4d\n", $statistics->nbCitations, $nbCitationsSinceYear);
echo sprintf("h-index  : %4d\t%4d\n", $statistics->hIndex, $statistics->hIndexSince);
echo sprintf("i10-index: %4d\t%4d\n", $statistics->i10Index, $statistics->i10IndexSince);
echo "\n";
echo implode("\t", array_keys($nbCitationsPerYear));
echo "\n";
echo implode("\t", array_values($nbCitationsPerYear));
echo "\n";
```

## Versioning

This library use [SemVer][9] for versioning. For available versions, see the [tags on this repository][10]. For feature
changes, see the [CHANGELOG.md][11] file for details.

## Code Quality

The code of this library:

- follows the [PSR-1][12] and [PSR-12][13] coding standards
- follows the [PSR-4][14] autoloading standard
- is statically analysed with [PHPQA][15] (which wraps several tools, notably [PHPCS][16], [PHPMD][17], [PHPStan][18] 
and [Psalm][19]), and by Code Climate (which is setup with plugins [Phan][20], [PHPMD][17], [SonarPHP][21])
- is unit tested with [PHPUnit][22] (code coverage on [Coveralls][23])
- is mutation tested with [Infection][24]
- is tested for compatibility with different versions of PHP (see [.travis.yml][25] for details)
- has some of its dependencies (those listed by the [PHP Security Advisories Database][26]) checked for known security 
issues
- is continuously integrated on [TravisCI][27]

These tools are installed with the library as long as you do not specify the option `--no-dev` when running the 
`install` or `update` [Composer][7] commands.

To run the static analysis tools and the unit tests via [PHPQA][15]:

```bash
./vendor/bin/phpqa --analyzedDirs=. --ignoredDirs=build,tests,vendor --report
```

To see the reports generated by [PHPQA][15] use a browser to open the file `./build/phpqa.html`. 

## Author

[Benoit Borrel][28]

## License

This library is licensed under the GPL-3.0-only License, see the [LICENSE.md][29] file for details.

[1]: https://en.wikipedia.org/wiki/Google_Scholar
[2]: https://scholar.google.com/
[3]: https://github.com/dschreij/scholar_parser
[4]: https://github.com/dschreij
[5]: http://phantomjs.org/
[6]: composer.json
[7]: https://getcomposer.org/
[8]: doc
[9]: http://semver.org/
[10]: https://github.com/bborrel/google-scholar-profile-parser/tags
[11]: CHANGELOG.md
[12]: https://www.php-fig.org/psr/psr-1/
[13]: https://www.php-fig.org/psr/psr-12/
[14]: https://www.php-fig.org/psr/psr-4/
[15]: https://github.com/EdgedesignCZ/phpqa
[16]: https://github.com/squizlabs/PHP_CodeSniffer
[17]: https://phpmd.org/
[18]: https://github.com/phpstan/phpstan
[19]: https://psalm.dev/
[20]: https://github.com/phan/phan
[21]: https://www.sonarsource.com/products/codeanalyzers/sonarphp.html
[22]: https://phpunit.de/
[23]: https://coveralls.io/github/bborrel/google-scholar-profile-parser?branch=master
[24]: https://github.com/infection/infection
[25]: .travis.yml
[26]: https://github.com/FriendsOfPHP/security-advisories
[27]: https://travis-ci.com/bborrel/google-scholar-profile-parser
[28]: https://github.com/bborrel
[29]: LICENSE.md
