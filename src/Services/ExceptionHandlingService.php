<?php

namespace Sparkouttech\BugAtlas\Services;

use App\Exceptions\Handler as BaseHandler;
use Throwable;
use Sparkouttech\BugAtlas\Services\BugAtlasReporterService;
use Illuminate\Support\Facades\Log;

class ExceptionHandlingService extends BaseHandler
{
    protected $bugAtlasReporter;

    public function __construct($app, BugAtlasReporterService $bugAtlasReporter)
    {
        parent::__construct($app);
        $this->bugAtlasReporter = $bugAtlasReporter;
    }

    public function render($request, Throwable $exception)
    {
        if ($this->shouldHandleException($exception)) {
            $this->bugAtlasReporter->report($request, $exception);
        }

        return parent::render($request, $exception);
    }

    protected function shouldHandleException(Throwable $exception): bool
    {
        $exceptionName = get_class($exception);

        switch($exceptionName){
            case "SyntaxError":
            case "TypeError":
            case "FileNotFoundError":
            case "AttributeError":
            case "ZeroDivisionError":
            case "ValidationException":
            case "ModelNotFoundException":
            case "MethodNotAllowedHttpException":
            case "NotFoundHttpException":
            case "QueryException":
            case "AuthorizationException":
            case "AuthenticationException":
            case "FileNotFoundException":
            case "HttpException":
            case "TokenMismatchException":
            case "ServiceNotFoundException":
            case "ThrottleRequestsException":
            case "BadMethodCallException":
            case "PDOException":
            case "ConnectException":
            case "PermissionDeniedException":
            case "ReflectionException":
            case "BindingResolutionException": 
            case "InvalidArgumentException":
            case "OutOfBoundsException":
            case "ConnectionException":
            case "ErrorException":        
            case "SuspiciousOperationException":
            case "FatalThrowableError":
            case "RuntimeException":

                Log::info('True Exception : '.$exceptionName);
                return true;
                break;
        }
        log::info('False Exception : '.$exceptionName);
        return false;
    }
}