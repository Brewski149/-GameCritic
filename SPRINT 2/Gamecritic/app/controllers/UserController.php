<?php
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../models/UserModel.php';

class UserController extends BaseController {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    public function profile() {
        $this->ensureSessionStarted();
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }

        $user = $this->userModel->findById((int)$_SESSION['user_id']);
        if (!$user) {
            $this->redirect('/login');
        }

        return $this->render('user/profile', [
            'user' => $user,
            'currentUser' => $this->getCurrentUser()
        ]);
    }

    public function updateProfile() {
        $this->ensureSessionStarted();
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/profile');
        }

        $userId = (int)$_SESSION['user_id'];
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $currentPassword = $_POST['current_password'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';

        // Validate required fields
        if (empty($username) || empty($email)) {
            $_SESSION['error'] = 'Username and email are required.';
            $this->redirect('/profile');
        }

        // Check if username or email already exists (excluding current user)
        $existingUser = $this->userModel->findByUsernameOrEmail($username, $email, $userId);
        if ($existingUser) {
            $_SESSION['error'] = 'Username or email already exists.';
            $this->redirect('/profile');
        }

        // Handle profile picture upload
        $profilePicture = null;
        if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../../public/uploads/profiles/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $fileInfo = pathinfo($_FILES['profile_picture']['name']);
            $extension = strtolower($fileInfo['extension']);
            
            // Validate file type
            $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
            if (!in_array($extension, $allowedTypes)) {
                $_SESSION['error'] = 'Only JPG, PNG, and GIF files are allowed.';
                $this->redirect('/profile');
            }

            // Generate unique filename
            $filename = 'profile_' . $userId . '_' . time() . '.' . $extension;
            $uploadPath = $uploadDir . $filename;

            if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $uploadPath)) {
                $profilePicture = '/uploads/profiles/' . $filename;
            }
        }

        // Prepare update data
        $updateData = [
            'username' => $username,
            'email' => $email,
            'phone' => $phone
        ];

        if ($profilePicture) {
            $updateData['profile_picture'] = $profilePicture;
        }

        // Update profile
        if ($this->userModel->updateUser($userId, $updateData)) {
            // Update password if provided
            if (!empty($currentPassword) && !empty($newPassword)) {
                if ($this->userModel->changePassword($userId, $currentPassword, $newPassword)) {
                    $_SESSION['success'] = 'Profile and password updated successfully.';
                } else {
                    $_SESSION['error'] = 'Current password is incorrect.';
                }
            } else {
                $_SESSION['success'] = 'Profile updated successfully.';
            }

            // Update session data
            $_SESSION['user_name'] = $username;
            $_SESSION['user_email'] = $email;
        } else {
            $_SESSION['error'] = 'Failed to update profile.';
        }

        $this->redirect('/profile');
    }
}
?>
