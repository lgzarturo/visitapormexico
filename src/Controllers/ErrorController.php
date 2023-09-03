<?php

declare(strict_types=1);

namespace App\Controllers;
use App\Helpers\Functions;

/**
 * ErrorController class.
 *
 * Represents a error page.
 *
 * @package App\Controllers
 *
 */
class ErrorController implements ControllerInterface
{
    public function index(): void
    {
        echo 'error';
    }

    public function serverError(): void
    {
        echo 'server error';
    }

    public function notFound(): void
    {
        Functions::render('errors.not_found');
    }

    public function unauthorized(): void
    {
        echo 'unauthorized';
    }

    public function forbidden(): void
    {
        echo 'forbidden';
    }

    public function badRequest(): void
    {
        echo 'bad request';
    }

    public function methodNotAllowed(): void
    {
        echo 'method not allowed';
    }

    public function notAcceptable(): void
    {
        echo 'not acceptable';
    }

    public function conflict(): void
    {
        echo 'conflict';
    }

    public function gone(): void
    {
        echo 'gone';
    }

    public function lengthRequired(): void
    {
        echo 'length required';
    }

    public function preconditionFailed(): void
    {
        echo 'precondition failed';
    }

    public function payloadTooLarge(): void
    {
        echo 'payload too large';
    }

    public function uriTooLong(): void
    {
        echo 'uri too long';
    }

    public function unsupportedMediaType(): void
    {
        echo 'unsupported media type';
    }

    public function rangeNotSatisfiable(): void
    {
        echo 'range not satisfiable';
    }

    public function expectationFailed(): void
    {
        echo 'expectation failed';
    }

    public function notImplemented(): void
    {
        echo 'not implemented yet';
    }
}
