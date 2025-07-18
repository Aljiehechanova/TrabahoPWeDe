<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>PWD Registration - Step 3 (Optional Resume Upload)</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-size: 1.3rem; }
        .btn { padding: 1rem; font-size: 1.2rem; }
        .form-control { font-size: 1.2rem; }
        label { font-weight: bold; }
    </style>
</head>
<body>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <h2 class="text-center mb-4">Step 3: Upload Your Resume (Optional)</h2>

            <p class="text-center text-muted">Uploading a resume helps employers match your skills to the right jobs, but it is not required.</p>

            <form action="registration_complete.php" method="POST" enctype="multipart/form-data" aria-label="PWD Resume Upload Form">

                <div class="mb-4">
                    <label for="resume">Select Resume File (Optional):</label>
                    <input 
                        type="file" 
                        name="resume" 
                        id="resume" 
                        class="form-control" 
                        accept=".pdf,.doc,.docx"
                        aria-describedby="resumeHelp"
                    >
                    <small id="resumeHelp" class="form-text text-muted">
                        Accepted formats: .pdf, .doc, .docx | Max size: 5MB
                    </small>
                </div>

                <button type="submit" class="btn btn-success w-100 mb-2">Complete Registration</button>
                <a href="registration_step2.php" class="btn btn-secondary w-100">Previous Step</a>

            </form>

        </div>
    </div>
</div>

</body>
</html>
