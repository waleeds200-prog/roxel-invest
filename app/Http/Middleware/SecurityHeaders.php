<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // 1. X-Content-Type-Options: يمنع المتصفح من تخمين نوع الملفات (يصلح خطأ -5)
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // 2. X-Frame-Options & CSP frame-ancestors: يمنع عرض موقعك داخل Iframe في مواقع أخرى (Clickjacking) (يصلح خطأ -20)
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');

        // 3. Referrer-Policy: يحمي مسارات موقعك عند انتقال المستخدم لموقع آخر
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // 4. Cross-Origin Resource Policy (CORP)
        $response->headers->set('Cross-Origin-Resource-Policy', 'same-origin');

        // 5. Strict-Transport-Security (HSTS): يجبر المتصفح على استخدام HTTPS دائماً (يصلح خطأ -20)
        // ملاحظة: يفضل تفعيله فقط في بيئة الإنتاج (Production) حتى لا يزعجك في التطوير المحلي (Localhost)
        if (app()->environment('production')) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');
        }

        // 6. Content Security Policy (CSP): سياسة أمان المحتوى (يصلح خطأ -20)
        // لقد قمت بضبطها لتسمح بصور Unsplash التي تستخدمها في موقعك، وتمنع 'unsafe-inline' من السكربتات
        $csp = "default-src 'self'; ".
               "script-src 'self' https://cdnjs.cloudflare.com https://cdn.tailwindcss.com https://challenges.cloudflare.com; ".
               "frame-src 'self' https://challenges.cloudflare.com; ".
               "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://cdnjs.cloudflare.com; ".
               "img-src 'self' data: https://images.unsplash.com; ".
               "font-src 'self' https://fonts.gstatic.com https://cdnjs.cloudflare.com; ".
               "object-src 'none'; ". // منع مشغلات الفلاش والجافا القديمة
               "frame-ancestors 'self';";

        $response->headers->set('Content-Security-Policy', $csp);

        return $response;
    }
}
