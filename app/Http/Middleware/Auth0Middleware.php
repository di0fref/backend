<?php

namespace App\Http\Middleware;

use Closure;
use Auth0\SDK\Exception\InvalidTokenException;
use Auth0\SDK\Helpers\JWKFetcher;
use Auth0\SDK\Helpers\Tokens\AsymmetricVerifier;
use Auth0\SDK\Helpers\Tokens\TokenVerifier;


class Auth0Middleware
{
    /**
     * Run the request filter.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
//        $token = $request->bearerToken();
//        if (!$token) {
//            return response()->json('No token provided', 401);
//        }
//
//        try {
//            $this->validateToken($token);
//        } catch (InvalidTokenException $e) {
//            return response()->json($e->getMessage(), 401);
//        }
        return $next($request);
    }

    //eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCIsImtpZCI6IjRUaE1WaUdxOU9XTkRjNTI2eldFTiJ9.eyJpc3MiOiJodHRwczovL2Rldi1sMnZ0LTc5MS5ldS5hdXRoMC5jb20vIiwic3ViIjoiaE1ZZFFsb3JZS2hHbWxwNWZSSE5DcE9SZjBVR3M3V2hAY2xpZW50cyIsImF1ZCI6Imh0dHBzOi8vYXBpLmZhaGxzdGFkLnNlIiwiaWF0IjoxNjQwMDQwMjg2LCJleHAiOjE2NDAxMjY2ODYsImF6cCI6ImhNWWRRbG9yWUtoR21scDVmUkhOQ3BPUmYwVUdzN1doIiwiZ3R5IjoiY2xpZW50LWNyZWRlbnRpYWxzIn0.ilEf0d5rvpLt_GoCy-wHYGhpyeEB7S0qzTFAwxW2Bb7wzFjQ68wBi3BTTkog6JCf6KeoisKPwlV_0J2duqz29uqEU0C8RNGHtf6sQ4L_YcgtBNC-6lQJrl3qwzXXD8RDA5NSXnXuije12XT9H3oHOiFlbYxQpRsbOJT9JwRNGB4JUCPxLkFIFaskw7UMEgyvJVdgGRNlGTAvd44ebYEXx2twALqkN4RL0ksrRWrlc26WBXryKNhzvyj7ktQnUjQbCMjyKKXdTXGOmlE_6d6ajgaECV0eptYe3V3eUyQVvpTvucep_As4YmnN5c4NUY4u433CQ9P0la24q1h-R3wT8w

    public function validateToken($token)
    {
        try {
            $jwksUri = env('AUTH0_DOMAIN') . '.well-known/jwks.json';
            $jwksFetcher = new JWKFetcher(null, ['base_uri' => $jwksUri]);
            $signatureVerifier = new AsymmetricVerifier($jwksFetcher);
            $tokenVerifier = new TokenVerifier(env('AUTH0_DOMAIN'), env('AUTH0_AUD'), $signatureVerifier);

            $decoded = $tokenVerifier->verify($token);
        } catch (InvalidTokenException $e) {
            throw $e;
        };
    }
}
