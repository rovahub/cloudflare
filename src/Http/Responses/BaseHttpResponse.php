<?php

namespace Rovahub\Cloudflare\Http\Responses;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Resources\Json\JsonResource;
use URL;

class BaseHttpResponse implements Responsable
{

    protected $error = false;

    protected $data;

    protected $message;

    protected $previousUrl = '';

    protected $nextUrl = '';

    protected $withInput = false;

    protected $code = 200;

    public function setData($data): self
    {
        $this->data = $data;
        return $this;
    }

    public function setPreviousUrl($previous_url): self
    {
        $this->previousUrl = $previous_url;
        return $this;
    }

    public function setNextUrl($next_url): self
    {
        $this->nextUrl = $next_url;
        return $this;
    }

    public function withInput(bool $with_input = true): self
    {
        $this->withInput = $with_input;
        return $this;
    }

    public function setCode(int $code): self
    {
        $this->code = $code;
        return $this;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage($message): self
    {
        $this->message = $message;
        return $this;
    }

    public function isError(): bool
    {
        return $this->error;
    }

    public function setError(bool $error = true): self
    {
        $this->error = $error;
        return $this;
    }

    public function toApiResponse()
    {
        if ($this->data instanceof JsonResource) {
            return $this->data->additional([
                'error' => $this->error,
                'message' => $this->message,
            ]);
        }

        return $this->toResponse(request());
    }

    public function toResponse($request)
    {
        if ($request->expectsJson()) {
            return response()
                ->json([
                    'error' => $this->error,
                    'data' => $this->data,
                    'message' => $this->message,
                ], $this->code);
        }

        if ($request->input('submit') === 'save' && !empty($this->previousUrl)) {
            return $this->responseRedirect($this->previousUrl);
        } elseif (!empty($this->nextUrl)) {
            return $this->responseRedirect($this->nextUrl);
        }

        return $this->responseRedirect(URL::previous());
    }

    protected function responseRedirect($url)
    {
        if ($this->withInput) {
            return redirect()
                ->to($url)
                ->with($this->error ? 'error_msg' : 'success_msg', $this->message)
                ->withInput();
        }

        return redirect()
            ->to($url)
            ->with($this->error ? 'error_msg' : 'success_msg', $this->message);
    }
}
