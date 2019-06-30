# Handler.php

## protected $dontReport

A list of the exception types that are not reported.

@var array

## protected $dontFlash

A list of the inputs that are never flashed for validation exceptions.

@var array

## public function report(Exception $exception)

Report or log an exception.

@param  \Exception  $exception

@return void

## public function render($request, Exception $exception)

Render an exception into an HTTP response.

@param  \Illuminate\Http\Request  $request

@param  \Exception  $exception

@return \Illuminate\Http\Response