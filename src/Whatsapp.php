<?php

namespace RocketsLab\LaravelWhatsapp;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Response;

class Whatsapp
{

    protected string $protocol = "";

    protected string $host = "";

    protected string $port = "";

    public function __construct(string $protocol, string $host, string $port)
    {
        $this->protocol = $protocol;

        $this->host = $host;

        $this->port = $port;
    }

    public function createSession(string $name)
    {
        try {

            return Http::acceptJson()->post($this->buildUrl("sessions"), [
                'session' => $name
            ])->json();

        }catch (\Exception $exception) {

            return $this->responseError($exception);

        }
    }

    public function getQRCode()
    {
        try {

            return Http::acceptJson()->get($this->buildUrl("sessions/qrcode"))->json();

        }catch (\Exception $exception) {

            return $this->responseError($exception);

        }
    }

    public function sendMessage(string $instance, string $phone, string $message)
    {
        try {

            return Http::acceptJson()->post($this->buildUrl("chats/send"), [
                'sender' => $instance,
                'receiver' => $phone,
                'message' => $message,
            ])->json();

        }catch (\Exception $exception) {

            return $this->responseError($exception);

        }
    }

    public function getAllSessions()
    {
        try {

            return Http::acceptJson()->get($this->buildUrl("sessions"))->json();

        } catch (\Exception $exception) {

            return $this->responseError($exception);

        }
    }

    protected function buildUrl(string $route): string
    {
        return "$this->protocol://$this->host:$this->port/$route";
    }

    /**
     * @param \Exception $exception
     * @return mixed
     */
    protected function responseError(\Exception $exception)
    {
        return Response::json([
            'error' => true,
            'message' => $exception->getMessage()
        ], 500);
    }
}
