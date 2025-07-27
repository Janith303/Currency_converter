<?php
include 'db_connect.php';

$converted = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = $_POST['amount'];
    $from = $_POST['from_currency'];
    $to = $_POST['to_currency'];

    $from_rate = $conn->query("SELECT rate_to_usd FROM rate WHERE currency_code = '$from'")->fetch_assoc()['rate_to_usd'] ?? null;
    $to_rate = $conn->query("SELECT rate_to_usd FROM rate WHERE currency_code = '$to'")->fetch_assoc()['rate_to_usd'] ?? null;

    if ($from_rate && $to_rate) {
        $converted = round(($amount / $from_rate) * $to_rate, 2);
    } else {
        $converted = "Invalid currency selection!";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Currency Converter</title>
    
       <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: linear-gradient(135deg, #2c1b47 0%, #1a0d2e 100%);
            color: #e0e0e0;
            text-align: center;
            padding-top: 50px;
            min-height: 100vh;
            margin: 0;
            background-attachment: fixed;
        }

        .box {
            background: rgba(40, 30, 60, 0.95);
            display: inline-block;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        input,
        select,
        button {
            margin: 15px 0;
            padding: 12px;
            width: 250px;
            border-radius: 8px;
            border: none;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        input {
            background: rgba(255, 255, 255, 0.1);
            color: #e0e0e0;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        input:focus {
            outline: none;
            border-color: #9b59b6;
            box-shadow: 0 0 8px rgba(155, 89, 182, 0.5);
        }

        select {
            background: rgba(255, 255, 255, 0.1);
            color: #e0e0e0;
            border: 1px solid rgba(255, 255, 255, 0.2);
            appearance: none;
            background-image: url('data:image/svg+xml;utf8,<svg fill="white" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M7 10l5 5 5-5z"/></svg>');
            background-repeat: no-repeat;
            background-position: right 10px top 50%;
        }
        select option{
            background: #a36cb9d3;
            color: #ece1e1ff;
        }

        select:focus {
            outline: none;
            border-color: #9b59b6;
            box-shadow: 0 0 8px rgba(155, 89, 182, 0.5);
        }

        button {
            background: linear-gradient(45deg, #9b59b6, #8e44ad);
            color: #fff;
            cursor: pointer;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        button:hover {
            background: linear-gradient(45deg, #8e44ad, #9b59b6);
            transform: translateY(-2px);
        }

        .result {
            margin-top: 20px;
            font-size: 18px;
            color: #1abc9c;
            font-weight: bold;
            text-shadow: 0 0 5px rgba(26, 188, 156, 0.5);
        }

        table {
            margin: 40px auto;
            width: 400px;
            border-collapse: collapse;
            background: rgba(40, 30, 60, 0.9);
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        }

        th,
        td {
            padding: 15px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #e0e0e0;
        }

        th {
            background: linear-gradient(45deg, #9b59b6, #8e44ad);
            font-weight: bold;
            text-transform: uppercase;
        }

        tr:nth-child(even) {
            background: rgba(255, 255, 255, 0.05);
        }

        tr:hover {
            background: rgba(155, 89, 182, 0.2);
        }

        h2 {
            color: #fff;
            text-shadow: 0 0 10px rgba(155, 89, 182, 0.7);
            font-size: 2.5em;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

    <h2>💱 Currency Converter</h2>

    <div class="box">
        <form method="post">
            <input type="number" name="amount" step="0.01" placeholder="Amount" required><br>

            <select name="from_currency" required>
                <option value="">From Currency</option>
                <option>USD</option>
                <option>LKR</option>
                <option>EUR</option>
                <option>INR</option>
            </select><br>

            <select name="to_currency" required>
                <option value="">To Currency</option>
                <option>USD</option>
                <option>LKR</option>
                <option>EUR</option>
                <option>INR</option>
            </select><br>

            <button type="submit">Convert</button>
        </form>

        <?php if ($converted !== ''): ?>
            <div class="result">
                <?= is_numeric($converted)
                    ? "Converted: {$_POST['amount']} {$_POST['from_currency']} = $converted {$_POST['to_currency']}"
                    : $converted; ?>
            </div>
        <?php endif; ?>
    </div>

    <?php
    include 'db_connect.php'; // Your database connection file

    // Fetch all currency rates
    $sql = "SELECT * FROM rate";
    $result = $conn->query($sql);
    ?>

    <table>
        <tr>
            <th>Currency Code</th>
            <th>Rate to USD</th>
        </tr>

        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['currency_code']); ?></td>
                    <td><?php echo htmlspecialchars($row['rate_to_usd']); ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="2">No currency rates found.</td>
            </tr>
        <?php endif; ?>
    </table>

</body>

</html>