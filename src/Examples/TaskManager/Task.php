<?php

declare(strict_types=1);

namespace App\Examples\TaskManager;

require_once dirname(__DIR__) . '/../../vendor/autoload.php';

use App\WebPage;
use Exception;

class Task
{
    private string $id;
    private string $content;
    private bool $isCompleted;

    private function __construct(string $content)
    {
        $this->id = uniqid();
        $this->content = $content;
        $this->isCompleted = false;
    }

    public function __toString(): string
    {
        return sprintf(
            '%s',
            $this->content
        );
    }

    public static function create(string $content): Task
    {
        return new Task($content);
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function setComplete(): void
    {
        $this->isCompleted = true;
    }

    public function isCompleted(): bool
    {
        return $this->isCompleted;
    }
}

function findObjectById($id, $array): Task|null
{
    $item = null;
    foreach ($array as $element) {
        if ($id == $element->getId()) {
            $item = $element;
            break;
        }
    }
    return $item;
}

function getNewArrayRemoveElementById($id, $array): array
{
    $newArray = [];
    foreach ($array as $element) {
        if ($id != $element->getId()) {
            $newArray[] = $element;
        }
    }
    return $newArray;
}

try {
    $page = WebPage::init("Create Task", "Add Task");

    if (isset($_GET['action']) && isset($_GET['id'])) {
        array_map('trim', $_GET);
        $action = $_GET['action'];
        $id = $_GET['id'];
        $tasks = $_SESSION['tasks'];

        $task = findObjectById($id, $tasks);
        $message = '';
        switch ($action) {
            case 'delete':
                $_SESSION['tasks'] = getNewArrayRemoveElementById($id, $tasks);
                $message = 'Se ha eliminado la tarea ' . $id . ' correctamente.';
                break;
            case 'edit':
                $task->setContent('New content');
                $tasks[] = $task;
                $message = 'Se ha editado la tarea ' . $id . ' correctamente.';
                break;
            case 'complete':
                $task->setComplete();
                $tasks[] = $task;
                $message = 'Se ha completado la tarea ' . $id . ' correctamente.';
                break;
            default:
                throw new Exception('This operation ' . $action . ' is unsupported');
                break;
        }

        $_SESSION['notification'] = [
            'type' => 'success',
            'content' => $message
        ];
        header('Location: /tasks.php');
        exit;
    }

    if ($_POST) {
        if (!isset($_POST['task'])) {
            throw new Exception('Please fill the form with the task');
        }

        array_map('trim', $_POST);
        $taskContent = $_POST['task'];

        if (strlen($taskContent) < 10) {
            throw new Exception('Task is too short, must be greater than 10 chars');
        }

        $task = Task::create($taskContent);
        $tasks = $_SESSION['tasks'];
        $tasks[] = $task;
        $_SESSION['tasks'] = $tasks;
        $_SESSION['notification'] = [
            'type' => 'success',
            'content' => 'Task added'
        ];
        header('Location: /tasks.php');
        exit;
    }
} catch (\Exception $e) {
    $error = $e->getMessage();
    $page->getFramework()->error($error);
    $_SESSION['notification'] = [
        'type' => 'error',
        'content' => $error
    ];
    header('Location: /tasks.php?error=true');
}
