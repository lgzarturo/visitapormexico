<?php

declare(strict_types=1);

namespace App\Examples\Calculator;

require_once dirname(__DIR__) . '/../../vendor/autoload.php';

use App\Core\Application;
use App\Helpers\Functions;

/**
 * Operation class.
 *
 * Represents a mathematical operation between two numbers.
 *
 * @package App\Examples\Calculator
 *
 */
class Operation
{
    /**
     * @var string The operation symbol (+, -, *, /)
     *
     */
    private string $operation;

    /**
     * @var float The first number of the operation
     *
     */
    private float $firstNumber;

    /**
     * @var float The second number of the operation
     *
     */
    private float $secondNumber;

    /**
     * @var float The result of the operation
     *
     */
    private float $result;

    /**
     * Creates a new Operation instance.
     *
     * @param float $firstNumber The first number of the operation
     * @param float $secondNumber The second number of the operation
     * @param string $operation The operation symbol (+, -, *, /)
     *
     */
    private function __construct(float $firstNumber, float $secondNumber, string $operation)
    {
        $this->firstNumber = $firstNumber;
        $this->secondNumber = $secondNumber;
        $this->operation = $operation;
        $this->calculate();
    }

    /**
     * Calculates the result of the operation.
     *
     * @throws \InvalidArgumentException If the operation symbol is invalid
     *
     * @return float The result of the operation
     *
     */
    public function calculate(): float
    {
        switch ($this->operation) {
            case '+':
                $this->result = $this->firstNumber + $this->secondNumber;
                break;
            case '-':
                $this->result = $this->firstNumber - $this->secondNumber;
                break;
            case '*':
                $this->result = $this->firstNumber * $this->secondNumber;
                break;
            case '/':
                $this->result = $this->firstNumber / $this->secondNumber;
                break;
            default:
                throw new \InvalidArgumentException('Invalid operation');
        }

        return $this->result;
    }

    public function __toString(): string
    {
        return sprintf(
            '%s %s %s = %s',
            $this->firstNumber,
            $this->operation,
            $this->secondNumber,
            $this->result
        );
    }

    public function getFirstNumber(): float
    {
        return $this->firstNumber;
    }

    public function getSecondNumber(): float
    {
        return $this->secondNumber;
    }

    public function getOperation(): string
    {
        return $this->operation;
    }

    public function getResult(): float
    {
        return $this->result;
    }

    /**
     * Creates a new Operation instance.
     *
     * @param float $firstNumber The first number of the operation
     * @param float $secondNumber The second number of the operation
     * @param string $operation The operation symbol (+, -, *, /)
     *
     * @return self The new Operation instance
     *
     */
    public static function create(float $firstNumber, float $secondNumber, string $operation): self
    {
        return new self($firstNumber, $secondNumber, $operation);
    }
}

// In the following snippet, we are using the Operation class to perform a simple calculation.

$app = Application::init('Operations', '/calculator');
try {
    if ($_POST) {
        array_map('trim', $_POST);
        $firstNumber = (float) $_POST['firstNumber'];
        $secondNumber = (float) $_POST['secondNumber'];
        $operation = $_POST['operation'];

        if (!isset($firstNumber) || !isset($secondNumber)) {
            throw new \InvalidArgumentException('Invalid numbers');
        }

        if (!isset($operation)) {
            throw new \InvalidArgumentException('Invalid operation');
        }

        if ($operation === '/' && $secondNumber === 0.0) {
            throw new \InvalidArgumentException('Division by zero');
        }

        $operation = Operation::create($firstNumber, $secondNumber, $operation);

        $_SESSION['response'] = [
            'firstNumber' => $operation->getFirstNumber(),
            'secondNumber' => $operation->getSecondNumber(),
            'operation' => $operation->getOperation(),
            'result' => $operation->getResult(),
            'human' => $operation->__toString()
        ];
        Functions::createNotification('success', 'Operation generated successfully');
        Functions::redirect('/calculator');
    }
} catch (\Exception $e) {
    $error = $e->getMessage();
    $app->getFramework()->error($error);
    Functions::createNotification('error', $error);
    Functions::redirect('/calculator', ['error' => true]);
}
