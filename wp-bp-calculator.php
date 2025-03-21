<?php
/*
Plugin Name: Blood Pressure Calculator
Plugin URI: https://thecustomizewindows.com
Description: A simple blood pressure calculator that can be embedded using a shortcode.
Version: 1.0
Author: Dr. Abhishek Ghosh
Author URI: https://abhishekghosh.com
License: GPL2
*/

function bp_calculator_shortcode() {
    ob_start();
    ?>
    <style>
        .bp-meter {
            width: 100%;
            height: 30px;
            background-color: #ddd;
            border-radius: 5px;
            overflow: hidden;
            margin-top: 10px;
        }
        .bp-meter-fill {
            height: 100%;
            text-align: center;
            color: white;
            line-height: 30px;
            font-weight: bold;
        }
    </style>
    <h2>Check Your Blood Pressure Reading</h2>
    <form method="post">
        <label for="systolic">Systolic (Upper) Value:</label>
        <input type="number" name="systolic" required>
        <br>
        <label for="diastolic">Diastolic (Lower) Value:</label>
        <input type="number" name="diastolic" required>
        <br>
        <input type="submit" name="bp_submit" value="Check Blood Pressure">
    </form>
    
    <?php
    if (isset($_POST['bp_submit'])) {
        $systolic = isset($_POST['systolic']) ? (int)$_POST['systolic'] : 0;
        $diastolic = isset($_POST['diastolic']) ? (int)$_POST['diastolic'] : 0;

        function getBPCategory($systolic, $diastolic) {
            if ($systolic < 120 || $diastolic < 80) {
                return ["Low Blood Pressure (Hypotension)", "#3498db"];
            } elseif ($systolic < 130 && $diastolic < 80) {
                return ["Normal Blood Pressure", "#2ecc71"];
            } elseif ($systolic < 140 && $diastolic < 80) {
                return ["Elevated Blood Pressure", "#f1c40f"];
            } elseif ($systolic < 150 || $diastolic < 90) {
                return ["High Blood Pressure (Hypertension Stage 1)", "#e67e22"];
            } elseif ($systolic >= 160 || $diastolic >= 90) {
                return ["High Blood Pressure (Hypertension Stage 2)", "#e74c3c"];
            } else {
                return ["Hypertensive Crisis - Seek Medical Attention Immediately", "#c0392b"];
            }
        }

        list($category, $color) = getBPCategory($systolic, $diastolic);
        ?>
        <h3>Result: <?php echo $category; ?></h3>
        <div class="bp-meter">
            <div class="bp-meter-fill" style="width: 100%; background-color: <?php echo $color; ?>;">
                <?php echo $category; ?>
            </div>
        </div>
        <?php
    }
    return ob_get_clean();
}

add_shortcode('bp_calculator', 'bp_calculator_shortcode');
?>
