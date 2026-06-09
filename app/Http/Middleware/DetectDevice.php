<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * Server-side device detection.
 *
 * Mobile phones are served the dedicated templates in resources/views/mobile,
 * everything else gets resources/views/desktop. Shared partials and layouts
 * live in the views root and resolve for both. The same view name (e.g.
 * "pages.home") therefore renders a different file per device.
 *
 * A ?view=mobile|desktop query override is honoured to make QA trivial.
 */
class DetectDevice
{
    public function handle(Request $request, Closure $next): Response
    {
        $isMobile = $this->resolveIsMobile($request);

        $finder = View::getFinder();
        $finder->flush();
        // Order matters: last prepended wins (sits at the front of the path list).
        $finder->prependLocation(resource_path('views/desktop'));
        if ($isMobile) {
            $finder->prependLocation(resource_path('views/mobile'));
        }

        View::share('isMobile', $isMobile);

        return $next($request);
    }

    protected function resolveIsMobile(Request $request): bool
    {
        $override = $request->query('view');
        if ($override === 'mobile') {
            return true;
        }
        if ($override === 'desktop') {
            return false;
        }

        $agent = (string) $request->userAgent();
        if ($agent === '') {
            return false;
        }

        // Tablets are treated as desktop on purpose (the desktop grid suits them).
        if (preg_match('/iPad|Tablet|Nexus (?:7|9|10)/i', $agent)) {
            return false;
        }

        return (bool) preg_match(
            '/Mobile|Android.*Mobile|iPhone|iPod|BlackBerry|IEMobile|Opera Mini|webOS|Windows Phone/i',
            $agent
        );
    }
}
