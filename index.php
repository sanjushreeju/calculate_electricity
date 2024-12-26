<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Electricity Calculator</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center">Electricity Rate Calculator</h1>
    <form method="POST" class="mt-4">
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="voltage">Voltage (V):</label>
                <input type="number" step="0.01" class="form-control" name="voltage" id="voltage" required>
            </div>
            <div class="form-group col-md-4">
                <label for="current">Current (A):</label>
                <input type="number" step="0.01" class="form-control" name="current" id="current" required>
            </div>
            <div class="form-group col-md-4">
                <label for="rate">Rate (sen/kWh):</label>
                <input type="number" step="0.01" class="form-control" name="rate" id="rate" required>
            </div>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Calculate</button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $voltage = $_POST['voltage'];
        $current = $_POST['current'];
        $rate = $_POST['rate'];

        // Calculate Power and Rate
        $power = $voltage * $current; // Power in Watts
        $rate_per_kwh = $rate / 100; // Convert rate to RM per kWh

        echo "
        <div class='mt-4'>
            <h3>Calculation Results</h3>
            <p><strong>Power:</strong> {$power} W</p>
            <p><strong>Rate:</strong> RM {$rate_per_kwh} per kWh</p>
        </div>
        ";

        // Display table for each hour
        echo "
        <div class='mt-4'>
            <h4>Hourly Energy Usage and Total Cost</h4>
            <table class='table table-bordered'>
                <thead>
                    <tr>
                        <th>Hour</th>
                        <th>Energy (kWh)</th>
                        <th>Total Cost (RM)</th>
                    </tr>
                </thead>
                <tbody>
        ";

        for ($hour = 1; $hour <= 24; $hour++) {
            $energy = ($power * $hour) / 1000; // Energy in kWh
            $total = round($energy * $rate_per_kwh, 2); // Total Cost in RM
            echo "
                <tr>
                    <td>{$hour}</td>
                    <td>" . number_format($energy, 2) . "</td>
                    <td>" . number_format($total, 2) . "</td>
                </tr>
            ";
        }

        echo "
                </tbody>
            </table>
        </div>
        ";
    }
    ?>
</div>

<!-- Include Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
