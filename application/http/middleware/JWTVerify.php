<?php

namespace app\http\middleware;

use app\helper\account\AuthHelper;

class JWTVerify
{
    public function handle($request, \Closure $next)
    {
        $token = $request->header('Authorization');
        $jwt_token = trim(str_replace('Bearer','',$token));
        try {
            $jwt_value = (array)JWT::decode($jwt_token, config('jwt.key'), [config('jwt.alg')]);
            $request->attributes->add(['jwt'=>$jwt_value]);
        }catch (\InvalidArgumentException $e){
            return responseFail($e->getMessage());
        }catch (\UnexpectedValueException $e) {
            return responseFail('The Authorization field in the head does not exist');
        }catch (ExpiredException $e) {
            return responseFail($e->getMessage());
        }catch (SignatureInvalidException $e) {
            return responseFail($e->getMessage());
        }catch (BeforeValidException $e){
            return responseFail($e->getMessage());
        }catch (\DomainException $e) {
            return responseFail($e->getMessage());
        }

        return $next($request);
    }
}
