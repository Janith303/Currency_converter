<!DOCTYPE html>
<html lang="en">

<head>
    <title>Update Currency Rates</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: linear-gradient(rgba(0, 50, 100, 0.58), rgba(2, 13, 24, 0.66)), url('su.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #fff;
            text-align: center;
            padding: 50px;
            margin: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        h2 {
            font-size: 2.5em;
            margin-bottom: 20px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .box {
            background: rgba(255, 255, 255, 0.1);
            /* Transparent white background */
            backdrop-filter: blur(10px);
            /* Glassmorphism effect */
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.2);
            width: 300px;
            transition: transform 0.3s ease;
        }

        .box:hover {
            transform: translateY(-5px);
            /* Subtle lift effect on hover */
        }

        select,
        input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.15);
            /* Transparent input fields */
            color: #fff;
            font-size: 1em;
            outline: none;
            transition: border-color 0.3s ease;
        }

        select:focus,
        input:focus {
            border-color: #1abc9c;
            /* Highlight on focus */
        }

        select option {
            background: #34495e;
            color: #fff;
        }

        input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        button {
            width: 100%;
            padding: 12px;
            background: #1abc9c;
            /* Vibrant teal button */
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 1.1em;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.2s ease;
        }

        button:hover {
            background: #16a085;
            transform: scale(1.05);
        }

        table {
            margin: 30px auto;
            /* Center the table */
            width: 350px;
            border-collapse: collapse;
            background: rgba(255, 255, 255, 0.1);
            /* Transparent table background */
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
        }

        th,
        td {
            padding: 15px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #fff;
        }

        th {
            background: #1abc9c;
            /* Teal header */
            font-weight: bold;
        }

        tr:nth-child(even) {
            background: rgba(255, 255, 255, 0.05);
            /* Subtle striping */
        }

        tr:hover {
            background: rgba(255, 255, 255, 0.15);
            /* Hover effect */
        }
    </style>
</head>

<body>
    <h2>💱 Update Currency Rate</h2>

    <div class="box">
        <form method="post" action="update_rate.php">
            <select name="code" required>
                <option value="">-- Select Currency --</option>
                <option value="USD">USD</option>
                <option value="LKR">LKR</option>
                <option value="EUR">EUR</option>
                <option value="INR">INR</option>
            </select>

            <input type="number" step="0.01" name="rate" placeholder="Rate to USD (e.g., 300.00)" required>

            <button type="submit">Save</button>
        </form>
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