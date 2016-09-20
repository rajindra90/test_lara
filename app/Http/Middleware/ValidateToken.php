<?php
/**
 * Created by PhpStorm.
 * User: prasanna_j
 * Date: 14-Jan-2016
 * Time: 11:58 AM
 */

namespace App\Http\Middleware;

use Closure;
use App\Libraries\TokenValidator;
use App\Libraries\Helper;
class ValidateToken
{
    private $tokenValidator;
    private $helper;
    public static $staticContent = null;

    public function __construct(
        TokenValidator $tokenValidator,
        Helper $helper
    ) {

        $this->tokenValidator = $tokenValidator;
        $this->helper = $helper;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  string|null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if ($request->headers->has('x-auth-token')) {
            if ($this->tokenValidator->validateToken($request->headers->get('x-auth-token'))) {

                return $next($request);
            } else {
                return $this->helper->response(
                    $this->helper->getConstants('general', 'forbidden_code'),
                    ['message' => trans('auth.failed')]
                );
            }
        } else {
            return $this->helper->response(
                $this->helper->getConstants('general', 'forbidden_code'),
                ['message' => trans('auth.failed')]
            );
        }
    }
}
