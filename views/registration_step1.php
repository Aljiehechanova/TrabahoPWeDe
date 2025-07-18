<?php
session_start();
require_once '../config/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $qr_id = $_POST['qr_id'] ?? null;

    if (!$qr_id) {
        die("<script>alert('QR ID is missing.'); window.history.back();</script>");
    }

    $_SESSION['qr_id'] = $qr_id;

    // Use PDO, not bind_param
    $stmt = $conn->prepare("SELECT * FROM users WHERE qr_id = ?");
    $stmt->execute([$qr_id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        die("<script>alert('This QR code is already registered.'); window.location.href = 'login.php';</script>");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>PWD Registration - Step 1</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-size: 1.3rem; }
        label { font-weight: bold; }
        .btn { padding: 1rem; font-size: 1.2rem; }
        .form-control { font-size: 1.2rem; }
        .invalid { color: red; }
        .valid { color: green; }
        .valid::before { content: "✔ "; }
        .invalid::before { content: "✘ "; }
    </style>
</head>
<body>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <h2 class="text-center mb-4">Step 1: Personal Information</h2>

            <form action="registration_step2.php" method="POST" aria-label="PWD Personal Information Form">

                <input type="hidden" name="qr_id" value="<?php echo htmlspecialchars($qr_id); ?>">

                <div class="mb-3">
                    <label for="lastname">Last Name</label>
                    <input type="text" name="lastname" id="lastname" class="form-control" required aria-required="true">
                </div>

                <div class="mb-3">
                    <label for="firstname">First Name</label>
                    <input type="text" name="firstname" id="firstname" class="form-control" required aria-required="true">
                </div>

                <div class="mb-3">
                    <label for="initial">Middle Initial</label>
                    <input type="text" name="initial" id="initial" class="form-control" required aria-required="true">
                </div>

                <div class="mb-3">
                    <label for="suffix">Suffix (Optional)</label>
                    <input type="text" name="suffix" id="suffix" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="birthday">Birthday</label>
                    <input type="date" name="birthday" id="birthday" class="form-control" required aria-required="true">
                </div>

                <div class="mb-3">
                    <label for="address">Address</label>
                    <input type="text" name="address" id="address" class="form-control" required aria-required="true">
                </div>

                <div class="mb-3">
                    <label for="phone">Phone</label>
                    <input type="text" name="phone" id="phone" class="form-control" required aria-required="true">
                </div>

                <div class="mb-3">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control" required aria-required="true">
                </div>

                <div class="mb-3">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required aria-required="true">
                    <ul id="passwordRules" class="mt-2" aria-live="polite">
                        <li id="length" class="invalid">More than 8 characters</li>
                        <li id="uppercase" class="invalid">At least 1 uppercase letter</li>
                        <li id="lowercase" class="invalid">At least 1 lowercase letter</li>
                        <li id="number" class="invalid">At least 1 number</li>
                        <li id="special" class="invalid">At least 1 special character (!@#$%^&*)</li>
                    </ul>
                </div>

                <div class="mb-3">
                    <label for="disability">Disability</label>
                    <select name="disability" id="disability" class="form-select" required aria-required="true">
                        <option value="">Select Disability</option>
                        <option value="Visual - Partial">Visual - Partial</option>
                        <option value="Visual - Full">Visual - Full</option>
                        <option value="Physical - Upper Limb">Physical - Upper Limb</option>
                        <option value="Physical - Lower Limb">Physical - Lower Limb</option>
                        <option value="Hearing Impairment">Hearing Impairment</option>
                        <option value="Speech Impairment">Speech Impairment</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary w-100">Next Step</button>
            </form>

        </div>
    </div>
</div>

<script>
document.querySelector('#password').addEventListener('input', function () {
    const p = this.value;
    document.getElementById('length').className = p.length > 8 ? 'valid' : 'invalid';
    document.getElementById('uppercase').className = /[A-Z]/.test(p) ? 'valid' : 'invalid';
    document.getElementById('lowercase').className = /[a-z]/.test(p) ? 'valid' : 'invalid';
    document.getElementById('number').className = /\d/.test(p) ? 'valid' : 'invalid';
    document.getElementById('special').className = /[!@#$%^&*]/.test(p) ? 'valid' : 'invalid';
});
</script>

</body>
</html>
