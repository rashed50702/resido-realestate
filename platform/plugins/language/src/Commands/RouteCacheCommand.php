<?php

namespace Botble\Language\Commands;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Foundation\Console\RouteCacheCommand as BaseRouteCacheCommand;
use Illuminate\Routing\RouteCollection;
use Language;

class RouteCacheCommand extends BaseRouteCacheCommand
{
    /**
     * Execute the console command.
     *
     * @return int
     * @throws FileNotFoundException
     */
    public function handle()
    {
        $this->call('route:clear');

        foreach (Language::getSupportedLanguagesKeys() as $locale) {
            $path = $this->makeLocaleRoutesPath($locale);

            if ($this->files->exists($path)) {
                $this->files->delete($path);
            }
        }

        $path = $this->laravel->getCachedRoutesPath();

        if ($this->files->exists($path)) {
            $this->files->delete($path);
        }

        $this->cacheRoutesPerLocale();

        $this->info('Routes cached successfully!');

        return 0;
    }

    /**
     * Cache the routes separately for each locale.
     * @throws FileNotFoundException
     */
    protected function cacheRoutesPerLocale(): int
    {
        // Store the default routes cache,
        // this way the Application will detect that routes are cached.
        $allLocales = Language::getSupportedLanguagesKeys();

        $allLocales[] = null;

        foreach ($allLocales as $locale) {
            if (Language::hideDefaultLocaleInURL() && $locale == Language::getCurrentLocale()) {
                continue;
            }

            $routes = $this->getFreshApplicationRoutesForLocale($locale);

            if (count($routes) == 0) {
                $this->error("Your application doesn't have any routes.");

                return 1;
            }

            foreach ($routes as $route) {
                $route->prepareForSerialization();
            }

            $this->files->put(
                $this->makeLocaleRoutesPath($locale),
                $this->buildRouteCacheFile($routes)
            );
        }

        return 0;
    }

    /**
     * Boot a fresh copy of the application and get the routes for a given locale.
     *
     * @param string|null $locale
     * @return RouteCollection
     */
    protected function getFreshApplicationRoutesForLocale(?string $locale = null): RouteCollection
    {
        if ($locale === null) {
            return $this->getFreshApplicationRoutes();
        }

        putenv('ROUTING_LOCALE=' . $locale);

        $routes = $this->getFreshApplicationRoutes();

        putenv('ROUTING_LOCALE=');

        return $routes;
    }

    /**
     * Build the route cache file.
     *
     * @param RouteCollection $routes
     * @return string
     * @throws FileNotFoundException
     */
    protected function buildRouteCacheFile(RouteCollection $routes): string
    {
        $stub = $this->files->get(realpath(__DIR__ . '/../../stubs/routes.stub'));

        return str_replace(
            [
                '{{routes}}',
                '{{translatedRoutes}}',
            ],
            [
                base64_encode(serialize($routes)),
                Language::getSerializedTranslatedRoutes(),
            ],
            $stub
        );
    }

    /**
     * @param string|null $locale
     * @return string
     */
    protected function makeLocaleRoutesPath(?string $locale = ''): string
    {
        $path = $this->laravel->getCachedRoutesPath();

        if (!$locale) {
            $locale = Language::getDefaultLocale();
        }

        return substr($path, 0, -4) . '_' . $locale . '.php';
    }
}
