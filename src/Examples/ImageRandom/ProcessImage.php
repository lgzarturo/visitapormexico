<?php

declare(strict_types=1);

namespace App\Examples\ImageRandom;

require_once dirname(__DIR__) . '/../../vendor/autoload.php';

use App\WebPage;

class ProcessImage
{

    private float $width;
    private float $height;
    private string $filter;
    private string $baseUrl;

    private function __construct(float $width, float $height, string $filter)
    {
        $this->width = $width;
        $this->height = $height;
        $this->filter = $filter;
        $this->baseUrl = 'https://picsum.photos';
    }

    private function getImageUrl(): string
    {
        $url = "{$this->baseUrl}/{$this->width}/{$this->height}?{$this->filter}";
        return $url;
    }

    private function getSquareImageUrl(): string
    {
        $url = "{$this->baseUrl}/{$this->width}?{$this->filter}";
        return $url;
    }

    public function getUrl(): string
    {
        if ($this->width === $this->height) {
            return $this->getSquareImageUrl();
        }
        return $this->getImageUrl();
    }

    public static function create(float $width, float $height, string $filter = ''): ProcessImage
    {
        return new ProcessImage($width, $height, $filter);
    }

    public static function createSquareImage(float $size, string $filter = ''): ProcessImage
    {
        return new ProcessImage($size, $size, $filter);
    }
}

try {
    $page = WebPage::init("VisitaPorMexico", "Random Image App");

    if ($_POST) {
        array_map('trim', $_POST);
        $width = (float) $_POST['width'];
        $height = (float) $_POST['height'];
        $filter = $_POST['filter'];

        if (!isset($width) || !isset($height)) {
            $page->getFramework()->error('Width and height are required');
            throw new \Exception('Width and height are required');
        }

        if ($width < 10 || $width > 2000) {
            $page->getFramework()->error('Width ' . $width . ' is not valid.');
            throw new \Exception('Width must be between 10 and 2000');
        }

        if ($height < 10 || $height > 2000) {
            $page->getFramework()->error('Height ' . $height . ' is not valid.');
            throw new \Exception('Height must be between 10 and 2000');
        }

        $image = ProcessImage::create($width, $height, $filter);
        $url = $image->getUrl();
        $_SESSION['image'] = [
            'url' => $url,
            'width' => $width,
            'height' => $height,
            'filter' => $filter
        ];
        $_SESSION['notification'] = [
            'type' => 'success',
            'content' => 'Image generated successfully'
        ];
        header('Location: /index.php');
        exit;
    }
} catch (\Exception $e) {
    $error = $e->getMessage();
    $page->getFramework()->error($error);
    $_SESSION['notification'] = [
        'type' => 'error',
        'content' => $error
    ];
    header('Location: /index.php?error=true');
}
