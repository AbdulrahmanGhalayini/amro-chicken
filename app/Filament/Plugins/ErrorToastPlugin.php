<?php

namespace App\Filament\Plugins;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Illuminate\Database\QueryException;

class ErrorToastPlugin implements Plugin
{
    public function getId(): string
    {
        return 'error-toast';
    }

    public function register(Panel $panel): void
    {
        //
    }

    public function boot(Panel $panel): void
    {
        $this->registerErrorHandler();
    }

    public static function make(): static
    {
        return app(static::class);
    }

    protected function registerErrorHandler(): void
    {
        // Hook into Laravel exception handling
        app('Illuminate\Contracts\Debug\ExceptionHandler')->renderable(function (\Throwable $e) {
            if (request()->is('admin/*')) {
                // Display validation errors and database errors as toasts
                if ($this->shouldDisplayAsToast($e)) {
                    $message = $this->getErrorMessage($e);

                    \Filament\Notifications\Notification::make()
                        ->danger()
                        ->title('Error')
                        ->body($message)
                        ->persistent()
                        ->send();
                    
                    // Return a response to prevent default error handling
                    if (request()->wantsJson()) {
                        return response()->json(['message' => $message], 422);
                    }
                }
            }

            return null;
        });
    }

    protected function getErrorMessage(\Throwable $e): string
    {
        // Handle database constraint violations
        if ($e instanceof QueryException) {
            if (str_contains($e->getMessage(), 'Duplicate entry')) {
                return 'This value already exists. Please use a different value.';
            }
            if (str_contains($e->getMessage(), 'FOREIGN KEY constraint failed')) {
                return 'Cannot delete this record as it is referenced by other records.';
            }
            if (str_contains($e->getMessage(), 'Integrity constraint')) {
                return 'Database integrity constraint violation. Please check your input.';
            }
        }

        // Handle validation errors
        if ($e instanceof \Illuminate\Validation\ValidationException) {
            $errors = $e->errors();
            if (is_array($errors)) {
                $firstError = reset($errors);
                if (is_array($firstError)) {
                    return implode(' ', $firstError);
                }
                return $firstError;
            }
        }

        // Default error message
        return $e->getMessage() ?: 'An error occurred. Please try again.';
    }

    protected function shouldDisplayAsToast(\Throwable $e): bool
    {
        // Display database and validation errors as toasts
        return $e instanceof QueryException ||
               $e instanceof \Illuminate\Validation\ValidationException ||
               $e instanceof \Exception;
    }
}
