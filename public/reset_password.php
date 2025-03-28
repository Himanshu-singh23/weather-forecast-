<?php
$error = isset($_SESSION["reset_password_error"]) ? $_SESSION["reset_password_error"] : null;
$success = isset($_SESSION["reset_password_success"]) ? $_SESSION["reset_password_success"] : null;

$error_message = $error ? $error[array_key_first($error)] : null;
$success_message = $success ? $success[array_key_first($success)] : null;



?>

<div class="flex items-center justify-center min-h-screen bg-gray-100">
    <form action="../backend/auth/reset_password.php" method="post" class="bg-white p-6 rounded-lg shadow-lg w-80">
        <h1 class="text-2xl font-bold text-orange-500 text-center mb-4">
            Reset Password
        </h1>
        <section class="mb-4">
            <label for="password" class="block text-gray-700 font-medium mb-1">New Password</label>
            <input type="password" id="password" name="password" placeholder="Enter new password"
                class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
        </section>
        <section class="mb-4">
            <label for="confirm_password" class="block text-gray-700 font-medium mb-1">Confirm Password</label>
            <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm new password"
                class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
        </section>
        <button type="submit"
            class="w-full bg-orange-500 text-white py-2 rounded-lg hover:bg-orange-600 transition">
            Reset Password
        </button>

        <?php
        if (!empty($error)) {
            display_error_message($error_message, "reset_password_error");
        }
        if (!empty($success)) {
            display_success_message($success_message, "reset_password_success");
        }
        ?>
    </form>
</div>