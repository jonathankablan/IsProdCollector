<?php

namespace App\DataCollector;

use Symfony\Bundle\FrameworkBundle\DataCollector\AbstractDataCollector;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

//check if database url is localhost or prod
class IsProdCollector extends AbstractDataCollector
{
    public static function getTemplate(): ?string
    {
        return 'data_collector/is_prod.html.twig';
    }

    public function collect(Request $request, Response $response, \Throwable $exception = null): void
    {
        $databaseUrl = $request->server->get('DATABASE_URL');
        $urlKeys = ['127.0.0.1', 'localhost'];
        $is_prod = !$this->checkUrl($databaseUrl, $urlKeys);

        $this->data = [
            'is_prod' => $is_prod,
            'database_url' => $databaseUrl
        ];
    }

    public function isProd(): bool
    {
        return $this->data['is_prod'];
    }

    public function getDatabaseUrl(): string
    {
        return $this->data['database_url'];
    }

    private function checkUrl($chaine, $valeurs): bool
    {
        foreach ($valeurs as $valeur) {
            if (str_contains($chaine, $valeur)) {
                return true;
            }
        }
        return false;
    }
}
