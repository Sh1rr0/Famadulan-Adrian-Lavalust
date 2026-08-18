<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Profile</title>
</head>
<body>

    <nav>
        <a href="/student">Home</a> |
        <a href="/student/profile">Student Profile</a>
    </nav>

    <h1>Student Information</h1>

    <p>Student ID: <?= $student_id; ?></p>
    <p>Name: <?= $name; ?></p>
    <p>Course: <?= $course; ?></p>
    <p>Year Level: <?= $year; ?></p>
    <p>Section: <?= $section; ?></p>
    <p>Email: <?= $email; ?></p>
    <p>Address: <?= $address; ?></p>
    <p>Contact Number: <?= $ContactNumber; ?></p>
    <p>hobbies: <?= $hobbies; ?></p>
    <p>Social Media:</p>
    <ul>
        <?php foreach ($social_media as $platform => $link): ?>
            <li>
                <?= ucfirst($platform); ?>: 
                <a href="<?= $link; ?>" target="_blank"><?= $link; ?></a>
            </li>
        <?php endforeach; ?>
    </ul>

   
</body>
</html>