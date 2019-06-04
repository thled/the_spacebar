<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use App\Service\MarkdownHelper;

class AppExtension extends AbstractExtension
{
    private $markdownHelper;

    public function __construct(MarkdownHelper $markdownHelper) {
        $this->markdownHelper = $markdownHelper;
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('cached_markdown', [$this, 'processMarkdown'], ['is_safe' => ['html']]),
        ];
    }

    public function processMarkdown($value)
    {
        return $this->markdownHelper->parse($value);
    }
}
