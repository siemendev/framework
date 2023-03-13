<?php

declare(strict_types=1);

namespace Framework\Templating\Twig;

use Framework\Templating\Integration\IntegrationInterface;
use Framework\Templating\Response\TemplatingResponseInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class TwigIntegration implements IntegrationInterface
{
    private TemplateStorage $templates;

    private Environment $twig;

    public function __construct(
        private readonly string $root,
    ) {
        $this->templates = new TemplateStorage();
        $this->twig = new Environment($this->templates);
    }

    public function boot(): void
    {
        foreach ((new Finder())->files()->in($this->root)->name('*.twig') as $file) {
            $name = $file->getRelativePath() . '/' . $file->getFilenameWithoutExtension();
            // add the template to the template storage
            $this->templates->setTemplate($name, $file->getContents());
            // load the template to warm up the compiled template cache
            $this->twig->loadTemplate($this->twig->getTemplateClass($name), $name);
        }
    }

    /** @return array<string, string> */
    public function templates(): array
    {
        return $this->templates->getTemplates();
    }

    public function provides(string $identifier): bool
    {
        return $this->templates->exists($identifier);
    }

    public function render(TemplatingResponseInterface $response): Response
    {
        return new Response(
            $this->twig->render($response::template(), ['data' => $response])
        );
    }
}
