<?php

declare(strict_types=1);

namespace App\Examples\Password;

require_once dirname(__DIR__) . '/../../vendor/autoload.php';

use App\Functions;
use App\WebPage;

/**
 * RandomNumber class.
 *
 * The RandomNumber class generates a random number between a minimum and maximum value.
 * The generated number is stored in the session and can be retrieved as a string.
 *
 * @property int $min The minimum value for the generated number.
 * @property int $max The maximum value for the generated number.
 * @property int $num The generated number.
 * @property int $result The result of the generated number.
 * @property array $numbers An array of previously generated numbers stored in the session.
 *
 * @package App\Examples\Password
 *
 */
class RandomNumber
{
    private int $min = 4;
    private int $max = 1000000;
    private int $num = 0;
    private int $result;
    private array $numbers = [];

    private function __construct()
    {
        $this->numbers = isset($_SESSION['numbers']) ? $_SESSION['numbers'] : [];
        $this->result = $this->generateRandomNumber();
    }

    private function generateRandomNumber(): int
    {
        $this->num = mt_rand($this->min, $this->max);
        $_SESSION['numbers'][] = $this->num;
        $this->result = $this->num;
        return $this->result;
    }

    public function __toString(): string
    {
        return sprintf(
            '%s',
            $this->result
        );
    }

    public static function create(): RandomNumber
    {
        return new RandomNumber();
    }
}

// In the following snippet, we are using the RandomNumber class to generate a random number.

try {
    $page = WebPage::init('Random Number', 'Generate Random Number');

    if ($_POST) {
        $randomNumber = RandomNumber::create();
        $_SESSION['number'] = $randomNumber->__toString();
        Functions::createNotification('success', 'Random Number Generated Successfully');
        Functions::redirect('/password');
    }
} catch (\Exception $e) {
    $error = $e->getMessage();
    $page->getFramework()->error($error);
    Functions::createNotification('error', $error);
    Functions::redirect('/password', ['error' => true]);
}
