<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;
use App\Exceptions\BusinessException;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
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
        // 422 - Erro de validação
        $this->renderable(function (ValidationException $e, $request) {
            return response()->json([
                'success' => false,
                'message' => 'Dados inválidos',
                'errors' => $e->errors(),
            ], 422);
        });

        // 401 - Não autenticado
        $this->renderable(function (AuthenticationException $e, $request) {
            return response()->json([
                'success' => false,
                'message' => 'Não autenticado',
            ], 401);
        });

        // 400 - Regra de negócio
        $this->renderable(function (BusinessException $e, $request) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], $e->getStatusCode());
        });

        // 403, 404 e outros erros HTTP
        $this->renderable(function (HttpExceptionInterface $e, $request) {

            $message = $e->getMessage() ?: match ($e->getStatusCode()) {
                403 => 'Acesso não autorizado',
                404 => 'Recurso não encontrado',
                default => 'Erro na requisição'
            };

            return response()->json([
                'success' => false,
                'message' => $message,
            ], $e->getStatusCode());
        });

        // 500 - Erro inesperado
        $this->renderable(function (Throwable $e, $request) {
            return response()->json([
                'success' => false,
                'message' => app()->isProduction()
                    ? 'Erro interno no servidor'
                    : $e->getMessage(),
            ], 500);
        });
    }
}
