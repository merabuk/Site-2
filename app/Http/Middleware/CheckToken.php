<?php

namespace App\Http\Middleware;

use App\Models\Token;
use Closure;
use Illuminate\Http\Request;

class CheckToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        //получаем токен из заголовка - схема Bearer
        $bearerToken = $request->bearerToken();
        //проверка наличия токена в базе
        if (Token::isTokenExists($bearerToken)) {
            return $next($request);
        }
        //токен не найден - отклоняем запрос
        return response('Access denied', 403);
    }
}
