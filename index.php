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
    // Function to calculate power, energy, and cost
    function calculateElectricityRate($voltage, $current, $rate) {
        $power = $voltage * $current; // Calculate power in Watts
        $rate_per_kwh = $rate / 100; // Convert rate to RM per kWh

        $hourly_results = [];
        for ($hour = 1; $hour <= 24; $hour++) {
            $energy = ($power * $hour) / 1000; // Energy in kWh
            $cost = $energy * $rate_per_kwh; // Cost in RM
            $hourly_results[] = [
                'hour' => $hour,
                'energy' => $energy,
                'cost' => $cost
            ];
        }

        return [
            'power' => $power,
            'rate_per_kwh' => $rate_per_kwh,
            'hourly_results' => $hourly_results
        ];
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $voltage = filter_input(INPUT_POST, 'voltage', FILTER_VALIDATE_FLOAT);
        $current = filter_input(INPUT_POST, 'current', FILTER_VALIDATE_FLOAT);
        $rate = filter_input(INPUT_POST, 'rate', FILTER_VALIDATE_FLOAT);

        if ($voltage > 0 && $current > 0 && $rate > 0) {
            $results = calculateElectricityRate($voltage, $current, $rate);
            $power = $results['power'];
            $rate_per_kwh = $results['rate_per_kwh'];
            $hourly_results = $results['hourly_results'];

            echo "<div class='mt-4'>
                <h3>Calculation Results</h3>
                <p><strong>Power:</strong> " . number_format($power, 2) . " W</p>
                <p><strong>Rate:</strong> RM " . number_format($rate_per_kwh, 2) . " per kWh</p>
            </div>";

            echo "<div class='mt-4'>
                <h4>Hourly Energy Usage and Cost</h4>
                <table class='table table-bordered'>
                    <thead>
                        <tr>
                            <th>Hour</th>
                            <th>Energy (kWh)</th>
                            <th>Cost (RM)</th>
                        </tr>
                    </thead>
                    <tbody>";

            foreach ($hourly_results as $result) {
                echo "<tr>
                    <td>" . $result['hour'] . "</td>
                    <td>" . number_format($result['energy'], 2) . "</td>
                    <td>" . number_format($result['cost'], 2) . "</td>
                </tr>";
            }

            echo "</tbody>
                </table>
            </div>";
        } else {
            echo "<div class='alert alert-danger mt-4'>Please enter positive values for voltage, current, and rate.</div>";
        }
    }
    ?>
</div>

<!-- Include Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
