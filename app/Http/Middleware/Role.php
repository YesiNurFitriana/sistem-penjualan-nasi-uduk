<?php
namespace App\Http\Middleware;
use Closure;
class Role {
  public function handle($request, Closure $next, ...$roles) {
    if (!$request->user() || !in_array($request->user()->role, $roles)) abort(403, 'Anda tidak memiliki akses ke halaman ini.');
    return $next($request);
  }
}
