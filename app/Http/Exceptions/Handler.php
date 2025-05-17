<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Inertia\Inertia;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

class Handler extends ExceptionHandler
{
    public function render($request, Throwable $exception)
    {
        if ($request->expectsJson() ||
            ! ($exception instanceof HttpExceptionInterface)
        ) {
            return parent::render($request, $exception);
        }

        $status = $exception->getStatusCode();

        if (in_array($status, [403, 404, 419, 429, 500, 503])) {
            return Inertia::render("errors/{$status}", [
                'status' => $status,
                'message' => __('errors.' . $status),
            ])->toResponse($request)->setStatusCode($status);
        }

        return parent::render($request, $exception);
    }
}
