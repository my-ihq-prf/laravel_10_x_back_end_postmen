<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',

    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Prepare exception for rendering.
     *
     * @param Throwable $e
     * @return JsonResponse|Response
     */
    public function render($request, Throwable $e): JsonResponse|Response
    {
        $response = parent::render($request, $e);
        $statusCode = $response->getStatusCode();

        if (!app()->environment(['local', 'testing']) && in_array($statusCode, [500, 503, 404, 403])) {
            return Inertia::render('Error', ['status' => $response . ''])
                ->toResponse($request)
                ->setStatusCode($statusCode);
        } elseif ($statusCode === 419) {
            return back()->with([
                'message' => 'The page expired, please try again.',
            ]);
        }

        return $response;
    }
}
