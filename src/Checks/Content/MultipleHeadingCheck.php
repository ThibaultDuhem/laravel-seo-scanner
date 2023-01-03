<?php

namespace Vormkracht10\Seo\Checks\Content;

use Illuminate\Http\Client\Response;
use Symfony\Component\DomCrawler\Crawler;
use Vormkracht10\Seo\Interfaces\Check;
use Vormkracht10\Seo\Traits\PerformCheck;

class MultipleHeadingCheck implements Check
{
    use PerformCheck;

    public string $title = 'The page has an H1 tag and if it is used only once per page';

    public string $priority = 'low';

    public int $timeToFix = 1;

    public int $scoreWeight = 5;

    public bool $continueAfterFailure = true;

    public function check(Response $response, Crawler $crawler): bool
    {
        if (! $this->validateContent($crawler)) {
            return false;
        }

        return true;
    }

    public function validateContent(Crawler $crawler): bool
    {
        $content = $crawler->filterXPath('//h1')->each(function (Crawler $node, $i) {
            return $node->text();
        });

        if (! $content) {
            return false;
        }

        if (is_array($content) && count($content) > 1) {
            return false;
        }

        return true;
    }
}
