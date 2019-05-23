<?php

namespace app\http\middleware;

use Firebase\JWT\JWT;
use think\facade\Cache;

class JWTVerify
{
    public function handle($request, \Closure $next)
    {
        $key = "example_key";
        $alg = 'HS256';
        $token = $request->header('Authorization');
        $jwt_token = trim(str_replace('Bearer', '', $token));
        try {
            $jwt_value = (array)JWT::decode($jwt_token, $key, [$alg]);
            if ($jwt_value['exp'] < time()) {
                return responseFail('Authorization has expired. Please log in again.');
            }

            $token = \Cache::store('redis')->get($jwt_value['sub']->id);
            if (empty($token)) {
                return responseFail('You have logged out. Please log in again.');
            }
            Cache::store('array')->set('user', $jwt_value['sub']);
        } catch (\InvalidArgumentException $e) {
            return responseFail($e->getMessage());
        } catch (\UnexpectedValueException $e) {
            return responseFail('The Authorization field in the head does not exist');
        } catch (ExpiredException $e) {
            return responseFail($e->getMessage());
        } catch (SignatureInvalidException $e) {
            return responseFail($e->getMessage());
        } catch (BeforeValidException $e) {
            return responseFail($e->getMessage());
        } catch (\DomainException $e) {
            return responseFail($e->getMessage());
        }

        return $next($request);
    }
}
