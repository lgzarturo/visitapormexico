<?php

declare(strict_types=1);

namespace App\Examples\ImageRandom;

require_once dirname(__DIR__) . '/../../vendor/autoload.php';

use App\Functions;
use App\WebPage;

/**
 * ProcessImage class.
 *
 * This class represents an image processing utility that generates image URLs based on the provided width, height, and filter.
 * The generated URLs can be used to fetch images from the Picsum.photos API.
 *
 * @package App\Examples\ImageRandom
 *
 */
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

    /**
     * Creates a new ProcessImage instance with the specified width, height and filter.
     *
     * @param float $width The width of the image.
     * @param float $height The height of the image.
     * @param string $filter The filter to apply to the image.
     *
     * @return ProcessImage A new ProcessImage instance.
     *
     */
    public static function create(float $width, float $height, string $filter = ''): ProcessImage
    {
        return new ProcessImage($width, $height, $filter);
    }

    /**
     * Creates a new square image with the specified size and filter.
     *
     * @param float $size The size of the square image.
     * @param string $filter The filter to apply to the image.
     *
     * @return ProcessImage The new ProcessImage instance.
     *
     */
    public static function createSquareImage(float $size, string $filter = ''): ProcessImage
    {
        return new ProcessImage($size, $size, $filter);
    }
}

// In the following snippet, we are using the ProcessImage class to generate a random image.

try {
    $page = WebPage::init('VisitaPorMexico', 'Random Image App');

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
        Functions::createNotification('success', 'Image generated successfully');
        Functions::redirect('/process_image');
    }
} catch (\Exception $e) {
    $error = $e->getMessage();
    $page->getFramework()->error($error);
    Functions::createNotification('error', $error);
    Functions::redirect('/process_image', ['error' => true]);
}
