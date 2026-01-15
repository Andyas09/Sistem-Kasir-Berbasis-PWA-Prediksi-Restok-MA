<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed  ...$roles
     * @return \Symfony\Component\HttpFoundation\Response
     */
    
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Pastikan user login
        if (!auth()->check()) {
            abort(401, 'Silakan login terlebih dahulu');
        }

        $user = auth()->user();

        // 2. Pastikan user punya role_id
        if (is_null($user->role_id)) {
            abort(403, 'Role user belum ditentukan');
        }

        // 3. Mapping role string ke role_id
        $roleMap = [
            'Admin' => 1,
            'Kasir' => 2,
        ];

        // 4. Validasi role yang dipanggil di route
        $allowedRoleIds = [];

        foreach ($roles as $role) {
            if (!array_key_exists($role, $roleMap)) {
                abort(500, "Role '{$role}' belum terdaftar di middleware");
            }

            $allowedRoleIds[] = $roleMap[$role];
        }
        if (!in_array($user->role_id, $allowedRoleIds, true)) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini');
        }
        return $next($request);
    }
}
