<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($_POST as $key => $value) {
        $_SESSION[$key] = $value;
    }
}

$disability = $_SESSION['disability'] ?? '';

$options = [
    'Visual - Partial' => [
        'preferred_work' => ['Customer Support', 'Data Entry', 'Telemarketing'],
        'skills' => ['Typing', 'Screen Reader Usage', 'Basic Computer Skills']
    ],
    'Visual - Full' => [
        'preferred_work' => ['Massage Therapy', 'Music Teacher'],
        'skills' => ['Braille Reading', 'Audio Editing']
    ],
    'Physical - Upper Limb' => [
        'preferred_work' => ['Receptionist', 'Administrative Support'],
        'skills' => ['Communication', 'Clerical Skills']
    ],
    'Physical - Lower Limb' => [
        'preferred_work' => ['Graphic Design', 'Programming', 'Content Writing'],
        'skills' => ['Computer Programming', 'Graphic Design']
    ],
    'Hearing Impairment' => [
        'preferred_work' => ['Graphic Design', 'Data Entry', 'IT Support'],
        'skills' => ['Visual Communication', 'Sign Language', 'Data Management']
    ],
    'Speech Impairment' => [
        'preferred_work' => ['Data Analyst', 'Software Developer'],
        'skills' => ['Analytical Thinking', 'Writing', 'Problem Solving']
    ]
];

$availableWorks = $options[$disability]['preferred_work'] ?? [];
$availableSkills = $options[$disability]['skills'] ?? [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>PWD Registration - Step 2</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-size: 1.3rem; }
        .btn { padding: 1rem; font-size: 1.2rem; }
    </style>
</head>
<body>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <h2 class="text-center mb-4">Step 2: Work & Skills Information</h2>

            <form action="registration_step3.php" method="POST" aria-label="PWD Work & Skills Form">

                <div class="mb-4">
                    <label for="preferred_work">Preferred Work</label>
                    <div id="workContainer">
                        <div class="input-group mb-2">
                            <select name="preferred_work[]" class="form-select" required>
                                <option value="">Select Work</option>
                                <?php foreach ($availableWorks as $work): ?>
                                    <option value="<?= htmlspecialchars($work) ?>"><?= htmlspecialchars($work) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <button type="button" class="btn btn-outline-primary w-100" onclick="addWork()">+ Add Another Work</button>
                </div>

                <div class="mb-4">
                    <label for="skills">Skills</label>
                    <div id="skillsContainer">
                        <div class="input-group mb-2">
                            <select name="skills[]" class="form-select" required>
                                <option value="">Select Skill</option>
                                <?php foreach ($availableSkills as $skill): ?>
                                    <option value="<?= htmlspecialchars($skill) ?>"><?= htmlspecialchars($skill) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <button type="button" class="btn btn-outline-primary w-100" onclick="addSkill()">+ Add Another Skill</button>
                </div>

                <button type="submit" class="btn btn-primary w-100 mb-2">Next Step</button>
                <a href="registration_step1.php" class="btn btn-secondary w-100">Previous</a>

            </form>

        </div>
    </div>
</div>

<script>
// Add more preferred work fields
function addWork() {
    const container = document.getElementById('workContainer');
    const select = container.querySelector('select').cloneNode(true);
    container.appendChild(createInputGroup(select));
}

// Add more skills fields
function addSkill() {
    const container = document.getElementById('skillsContainer');
    const select = container.querySelector('select').cloneNode(true);
    container.appendChild(createInputGroup(select));
}

// Create a new input group with select field
function createInputGroup(selectElement) {
    const div = document.createElement('div');
    div.className = 'input-group mb-2';
    div.appendChild(selectElement);
    return div;
}
</script>

</body>
</html>
