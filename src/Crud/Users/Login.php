<?php

declare(strict_types=1);

namespace App\Crud\Users;

use App\Functions;
use App\WebPage;

require_once dirname(__DIR__) . '/../../vendor/autoload.php';

/**
 * Login class.
 *
 * This class represents a user login utility.
 *
 * @package App\Crud\Users
 *
 */
class Login
{
    /**
     * Authenticates a user with the provided credentials.
     *
     * @param array $data An array containing the user's login credentials.
     * Commonly the data comes from the $_POST super global.
     *
     * @return void
     *
     * @throws \Exception If the user is not found or the credentials are invalid.
     * @throws \PDOException If there is an error with the database connection.
     */
    public static function authentication(array $data): void
    {
        $page = WebPage::init("Login", "User Login Page");
        array_map('trim', $data);
        $username = htmlspecialchars($data['username']);
        $password = $data['password'];
        $salt = "s4lty-s4lt-4nd-p3pp3r-4r3-1mp0rt4nt-1n-cr3d3nt14ls";
        // This is a dummy user, replace it with your own user data.
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

    /**
     * Retrieves the current user from the session and redirects to the index page.
     *
     * @return void
     *
     * @throws \Exception If an error occurs while retrieving the user.
     * @throws \PDOException If a database error occurs.
     */
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

    /**
     * Logout the current user session.
     *
     * @return void
     *
     */
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
