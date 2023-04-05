<?php

declare(strict_types=1);

namespace Framework\Templating\Blade;

use Framework\Templating\Integration\IntegrationInterface;
use Framework\Templating\Response\TemplatingResponseInterface;
use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;
use Illuminate\View\Compilers\BladeCompiler;
use Illuminate\View\Engines\CompilerEngine;
use Illuminate\View\Engines\EngineResolver;
use Illuminate\View\Factory;
use Illuminate\View\ViewName;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\Response;

class BladeIntegration implements IntegrationInterface
{
    private Factory $factory;

    private InMemoryViewFinder $viewFinder;

    private InMemoryFilesystem $filesystem;

    private BladeCompiler $bladeCompiler;

    public function __construct(private readonly string $root)
    {
        $this->filesystem = new InMemoryFilesystem();
        $viewResolver = new EngineResolver();
        $bladeCompiler = new BladeCompiler($this->filesystem, '/cache');
        $this->bladeCompiler = $bladeCompiler;
        $viewResolver->register('blade', function () use ($bladeCompiler) {
            return new CompilerEngine($bladeCompiler, $this->filesystem);
        });
        $this->viewFinder = new InMemoryViewFinder();
        $this->factory = new Factory($viewResolver, $this->viewFinder, new Dispatcher(new Container()));
    }

    public function boot(): void
    {
        foreach ((new Finder())->files()->in($this->root)->name('*.blade.php') as $file) {
            $path = $file->getRelativePath() . '/' . $file->getFilename();
            $name = ViewName::normalize(str_replace('.blade.php', '', $path));
            $this->viewFinder->addView($name, $path);
            $this->filesystem->put($path, $file->getContents());
            $this->bladeCompiler->compile($path);
        }
    }

    /** @return array<int, string> */
    public function templates(): array
    {
        return $this->viewFinder->all();
    }

    public function provides(string $identifier): bool
    {
        return $this->factory->exists($identifier);
    }

    public function render(TemplatingResponseInterface $response): Response
    {
        return new Response(
            $this->factory->make($response::template(), ['data' => $response])->render()
        );
    }
}
