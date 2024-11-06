<?php
require_once 'DB.php';         
require_once 'WorkTime.php';   

$db = new DB();
$workTime = new WorkTime($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $arrived_at = isset($_POST['arrived_at']) ? new DateTime($_POST['arrived_at']) : null;
    $leaved_at = isset($_POST['leaved_at']) ? new DateTime($_POST['leaved_at']) : null;

    if ($name && $arrived_at && $leaved_at) {
        $worked_seconds = $workTime->calculateWorkedTime($arrived_at, $leaved_at);
        $remaining_seconds = $workTime->calculateRemainingTime($worked_seconds);
        
        $workTime->addRecord($name, $arrived_at, $leaved_at);
        header("Location: index.php");
        exit;
    }
}

$records = $workTime->getAllRecords();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Work of Tracker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body class="bg-info-subtle">
    <div class="container bg-info-subtle">
        <h1 class="text-danger text-center">Work of Tracker</h1>
        
        <form method="post">
            <div class="mb-3">
                <label for="name" class="form-label">Ism</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Ismingizni kiriting">
            </div>
            <div class="mb-3">
                <label for="arrived_at" class="form-label">Kelgan vaqt</label>
                <input type="datetime-local" class="form-control" id="arrived_at" name="arrived_at">
            </div>
            <div class="mb-3">
                <label for="leaved_at" class="form-label">Ketgan vaqt</label>
                <input type="datetime-local" class="form-control" id="leaved_at" name="leaved_at">
            </div>
            <button type="submit" class="btn btn-warning">Submit</button>
        </form>
        
        <table class="table table-subtle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Ism</th>
                    <th>Keldi</th>
                    <th>Ketdi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($records as $record): ?>
                    <tr>
                        <td><?= $record['id']; ?></td>
                        <td><?= htmlspecialchars($record['name']); ?></td>
                        <td><?= htmlspecialchars($record['arrived_at']); ?></td>
                        <td><?= htmlspecialchars($record['leaved_at']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
