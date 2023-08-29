<?php

declare(strict_types=1);

namespace App\Crud\Users;

use App\Functions;
use App\WebPage;

require_once dirname(__DIR__) . '/../../vendor/autoload.php';

class Login
{
    public function __construct()
    {
        echo 'Login User';
    }

    public static function authentication(array $data): void
    {
        $page = WebPage::init("Login", "User Login Page");
        array_map('trim', $data);
        $username = htmlspecialchars($data['username']);
        $password = $data['password'];
        $salt = "s4lty-s4lt-4nd-p3pp3r-4r3-1mp0rt4nt-1n-cr3d3nt14ls";
        $userDummy = [
            'id' => 1,
            'username' => 'admin',
            'encryptedPassword' => password_hash('super-password-secret' . $salt, PASSWORD_BCRYPT),
            'email' => 'admin@localhost',
            'name' => 'Administrator',
            'role' => 'admin',
            'status' => 'active',
            'created_at' => '2020-01-01 00:00:00',
            'updated_at' => '2020-01-01 00:00:00'
        ];
        try {
            if (empty($userDummy)) {
                throw new \Exception('User not found');
            }
            if (!password_verify($password . $salt, $userDummy['encryptedPassword']) || $userDummy['username'] !== $username || $userDummy['status'] !== 'active' || $userDummy['role'] !== 'admin') {
                throw new \Exception('The credentials are not valid, please verify the user data, to continue');
            }
            $currentUser = [
                'id' => $userDummy['id'],
                'username' => $userDummy['username'],
                'email' => $userDummy['email'],
                'name' => $userDummy['name'],
                'role' => $userDummy['role'],
                'status' => $userDummy['status'],
                'session_id' => session_id(),
                'authenticated_at' => date('Y-m-d H:i:s'),
                'is_authorized' => true
            ];
            $_SESSION['current_user'] = $currentUser;
            Functions::createNotification('success', sprintf('User %s logged in successfully', $currentUser['username']));
            Functions::redirect('/index');
        } catch (\Exception $e) {
            Functions::createNotification('error', $e->getMessage());
        } catch (\PDOException $e) {
            $page->getFramework()->error(sprintf("Error: %s", $e->getMessage()));
            Functions::createNotification('error', 'Server error');
        }
    }

    public static function getCurrentUser(): void
    {
        $page = WebPage::init("Get Current User", "/users/current");
        try {
            $user = [];
            if (isset($_SESSION['current_user'])) {
                $user = $_SESSION['current_user'];
                $_SESSION['current_user'] = $user;
                Functions::createNotification('success', sprintf('User %s loaded successfully', $user['username']));
                Functions::redirect('/index');
            }
        } catch (\Exception $e) {
            Functions::createNotification('error', $e->getMessage());
        } catch (\PDOException $e) {
            $page->getFramework()->error(sprintf("Error: %s", $e->getMessage()));
            Functions::createNotification('error', 'Server error');
        }
    }

    public static function logoutSession(): void
    {
        $page = WebPage::init("Logout", "/users/logout");
        $actionLogout = $_GET['action'] ?? '';
        if ($actionLogout === 'logout' && isset($_SESSION['current_user'])) {
            unset($_SESSION['current_user']);
            Functions::createNotification('success', 'User logged out successfully');
            $page->getFramework()->info('User logged out successfully');
            Functions::redirect('/login');
        }
    }
}
