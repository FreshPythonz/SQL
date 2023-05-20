<!DOCTYPE html>
<html>
<head>
    <title>Taxi Company</title>
</head>
<body>
<?php
include 'DBLogin.php';

// Handle user actions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["skaityti"])) {
        echo "<h2>Select Data to Read</h2>";
        echo "<form method='post'>";
        echo "<select name='data_type'>";
        echo "<option value='darbolaikas'>Darbolaikas</option>";
        echo "<option value='kainos'>Kainos</option>";
        echo "<option value='keleivis'>Keleivis</option>";
        echo "<option value='keliones'>Kelionės</option>";
        echo "<option value='masinos'>Mašinos</option>";
        echo "<option value='vairuotojai'>Vairuotojai</option>";
        echo "</select>";
        echo "<input type='submit' name='read_data' value='Read Data'>";
        echo "</form>";
    } elseif (isset($_POST["read_data"])) {
        $dataType = $_POST["data_type"];

        // Read data from the selected table
        $sql = "SELECT * FROM $dataType";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            echo "<h2>$dataType</h2>";
            echo "<table>";

            // Retrieve column names from the table
            $columnsSql = "SHOW COLUMNS FROM $dataType";
            $columnsResult = mysqli_query($conn, $columnsSql);

            echo "<tr>";
            while ($columnRow = mysqli_fetch_assoc($columnsResult)) {
                echo "<th>" . $columnRow["Field"] . "</th>";
            }
            echo "</tr>";

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                foreach ($row as $field => $value) {
                    echo "<td>" . $value . "</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "No data found in the selected table.";
        }
    }if (isset($_POST["irasyti"])) {
        echo "<h2>Add New Data</h2>";
        echo "<form method='post'>";
        echo "<select name='data_type'>";
        echo "<option value='keleivis'>Keleivis</option>";
        echo "<option value='keliones'>Kelionės</option>";
        echo "<option value='masinos'>Mašinos</option>";
        echo "<option value='vairuotojai'>Vairuotojai</option>";
        echo "</select><br><br>";

        echo "<input type='submit' name='submit_data_type' value='Select'><br><br>";
        echo "</form>";
    }

    if (isset($_POST["submit_data_type"])) {
        $selectedDataType = $_POST["data_type"];

        if ($selectedDataType === 'keleivis') {
            echo "<h2>Keleivis Data</h2>";
            echo "<form method='post'>";
            echo "Vardas: <input type='text' name='vardas'><br>";
            echo "Pavarde: <input type='text' name='pavarde'><br>";
            echo "Tel. Nr.: <input type='text' name='tel_nr'><br>";
            echo "<input type='submit' name='submit_keleivis' value='Submit'>";
            echo "</form>";
        } elseif ($selectedDataType === 'keliones') {
            echo "<h2>Keliones Data</h2>";
            echo "<form method='post'>";
            // Retrieve KeleivioID and VairuotojoID options from the database
            $keleivioIDSql = "SELECT KeleivioID FROM keleivis";
            $keleivioIDResult = mysqli_query($conn, $keleivioIDSql);

            $vairuotojoIDSql = "SELECT VairuotojoID FROM vairuotojai";
            $vairuotojoIDResult = mysqli_query($conn, $vairuotojoIDSql);

            echo "Keleivio ID: ";
            echo "<select name='keleivio_id'>";
            while ($keleivioIDRow = mysqli_fetch_assoc($keleivioIDResult)) {
                echo "<option value='" . $keleivioIDRow['KeleivioID'] . "'>" . $keleivioIDRow['KeleivioID'] . "</option>";
            }
            echo "</select><br>";

            echo "Vairuotojo ID: ";
            echo "<select name='vairuotojo_id'>";
            while ($vairuotojoIDRow = mysqli_fetch_assoc($vairuotojoIDResult)) {
                echo "<option value='" . $vairuotojoIDRow['VairuotojoID'] . "'>" . $vairuotojoIDRow['VairuotojoID'] . "</option>";
            }
            echo "</select><br>";

            echo "Paemimo Adresas: <input type='text' name='paemimo_adresas'><br>";
            echo "Nuvezimo Adresas: <input type='text' name='nuvezimo_adresas'><br>";
            echo "Kaina: <input type='text' name='kaina'><br>";
            echo "<input type='submit' name='submit_keliones' value='Submit'>";
            echo "</form>";
        } elseif ($selectedDataType === 'masinos') {
            echo "<h2>Masinos Data</h2>";
            echo "<form method='post'>";
            echo "Nr: <input type='text' name='nr'><br>";
            echo "Modelis: <input type='text' name='modelis'><br>";
            echo "Spalva: <input type='text' name='spalva'><br>";
            echo "<input type='submit' name='submit_masinos' value='Submit'>";
            echo "</form>";
        } elseif ($selectedDataType === 'vairuotojai') {
            echo "<h2>Vairuotojai Data</h2>";
            echo "<form method='post'>";
            echo "Vardas: <input type='text' name='vardas'><br>";
            echo "Pavarde: <input type='text' name='pavarde'><br>";
            echo "Asmens Kodas: <input type='text' name='asmens_kodas'><br>";
            echo "Tel. Nr.: <input type='text' name='tel_nr'><br>";
            echo "Email: <input type='text' name='email'><br>";
            echo "Adresas: <input type='text' name='adresas'><br>";

            // Retrieve MasinosID options from the database
            $masinosIDSql = "SELECT MasinosID FROM masinos";
            $masinosIDResult = mysqli_query($conn, $masinosIDSql);

            echo "Masinos ID: ";
            echo "<select name='masinos_id'>";
            while ($masinosIDRow = mysqli_fetch_assoc($masinosIDResult)) {
                echo "<option value='" . $masinosIDRow['MasinosID'] . "'>" . $masinosIDRow['MasinosID'] . "</option>";
            }
            echo "</select><br>";

            // Retrieve DarboLaikas_ID options from the database
            $darboLaikasIDSql = "SELECT DarboLaikas_ID FROM darbolaikas";
            $darboLaikasIDResult = mysqli_query($conn, $darboLaikasIDSql);

            echo "DarboLaikas ID: ";
            echo "<select name='darbo_laikas_id'>";
            while ($darboLaikasIDRow = mysqli_fetch_assoc($darboLaikasIDResult)) {
                echo "<option value='" . $darboLaikasIDRow['DarboLaikas_ID'] . "'>" . $darboLaikasIDRow['DarboLaikas_ID'] . "</option>";
            }
            echo "</select><br>";

            echo "<input type='submit' name='submit_vairuotojai' value='Submit'>";
            echo "</form>";
        }
    }

    if (isset($_POST["submit_keleivis"])) {
        $vardas = $_POST["vardas"];
        $pavarde = $_POST["pavarde"];
        $tel_nr = $_POST["tel_nr"];

        // Find the first available ID for Keleivis
        $availableID = 1;

        // Check if the ID exists
        while (true) {
            $sql = "SELECT * FROM keleivis WHERE KeleivioID = $availableID";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) == 0) {
                // Use the available ID
                $keleivio_id = $availableID;
                break;
            }

            // Increment the available ID
            $availableID++;
        }

        // Insert new Keleivis record into the database
        $sql = "INSERT INTO keleivis (KeleivioID, Vardas, Pavarde, TelNr) VALUES ('$keleivio_id', '$vardas', '$pavarde', '$tel_nr')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            echo "New Keleivis record added successfully.";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
    elseif (isset($_POST["submit_keliones"])) {
        $keleivio_id = $_POST["keleivio_id"];
        $vairuotojo_id = $_POST["vairuotojo_id"];
        $paemimo_adresas = $_POST["paemimo_adresas"];
        $nuvezimo_adresas = $_POST["nuvezimo_adresas"];
        $kaina = $_POST["kaina"];

        // Find the first available ID for Keliones
        $availableID = 1;

        // Check if the ID exists
        while (true) {
            $sql = "SELECT * FROM keliones WHERE KelionesID = $availableID";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) == 0) {
                // Use the available ID
                $keliones_id = $availableID;
                break;
            }

            // Increment the available ID
            $availableID++;
        }

        // Insert new Keliones record into the database
        $sql = "INSERT INTO keliones (KelionesID, KeleivioID, VairuotojoID, PaemimoAdresas, NuvezimoAdresas, Kaina) VALUES ('$keliones_id', '$keleivio_id', '$vairuotojo_id', '$paemimo_adresas', '$nuvezimo_adresas', '$kaina')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            echo "New Keliones record added successfully.";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
    elseif (isset($_POST["submit_masinos"])) {
        $nr = $_POST["nr"];
        $modelis = $_POST["modelis"];
        $spalva = $_POST["spalva"];

        // Find the first available ID for Masinos
        $availableID = 1;

        // Check if the ID exists
        while (true) {
            $sql = "SELECT * FROM masinos WHERE MasinosID = $availableID";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) == 0) {
                // Use the available ID
                $masinos_id = $availableID;
                break;
            }

            // Increment the available ID
            $availableID++;
        }

        // Insert new Masinos record into the database
        $sql = "INSERT INTO masinos (MasinosID, Nr, Modelis, Spalva) VALUES ('$masinos_id', '$nr', '$modelis', '$spalva')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            echo "New Masinos record added successfully.";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
    elseif (isset($_POST["submit_vairuotojai"])) {
        $vardas = $_POST["vardas"];
        $pavarde = $_POST["pavarde"];
        $asmens_kodas = $_POST["asmens_kodas"];
        $tel_nr = $_POST["tel_nr"];
        $email = $_POST["email"];
        $adresas = $_POST["adresas"];
        $masinos_id = $_POST["masinos_id"];
        $darbo_laikas_id = $_POST["darbo_laikas_id"];

        // Find the first available ID for Vairuotojai
        $availableID = 1;

        // Check if the ID exists
        while (true) {
            $sql = "SELECT * FROM vairuotojai WHERE VairuotojoID = $availableID";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) == 0) {
                // Use the available ID
                $vairuotojai_id = $availableID;
                break;
            }

            // Increment the available ID
            $availableID++;
        }

        // Insert new Vairuotojai record into the database
        $sql = "INSERT INTO vairuotojai (VairuotojoID, Vardas, Pavarde, AsmensKodas, TelNr, Email, Adresas, MasinosID, DarboLaikas_ID) VALUES ('$vairuotojai_id', '$vardas', '$pavarde', '$asmens_kodas', '$tel_nr', '$email', '$adresas', '$masinos_id', '$darbo_laikas_id')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            echo "New Vairuotojai record added successfully.";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }

}

mysqli_close($conn);
?>

<h1>Taxi Company</h1>
<h2>Select an Action</h2>
<form method="post">
    <input type="submit" name="skaityti" value="Read Data">
    <input type="submit" name="irasyti" value="Add Data">
</form>

</body>
</html>
