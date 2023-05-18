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
    } elseif (isset($_POST["irasyti"])) {
        echo "<h2>Add New Data</h2>";
        echo "<form method='post'>";
        echo "<select name='data_type'>";
        echo "<option value='keleivis'>Keleivis</option>";
        echo "<option value='keliones'>Kelionės</option>";
        echo "<option value='masinos'>Mašinos</option>";
        echo "<option value='vairuotojai'>Vairuotojai</option>";
        echo "</select><br><br>";

        if (isset($_POST["data_type"])) {
            $selectedDataType = $_POST["data_type"];

            if ($selectedDataType === 'keleivis') {
                echo "Vardas: <input type='text' name='vardas'><br>";
                echo "Pavarde: <input type='text' name='pavarde'><br>";
                echo "Tel. Nr.: <input type='text' name='tel_nr'><br>";
            } elseif ($selectedDataType === 'keliones') {
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
            } elseif ($selectedDataType === 'masinos') {
                echo "Nr: <input type='text' name='nr'><br>";
                echo "Modelis: <input type='text' name='modelis'><br>";
                echo "Spalva: <input type='text' name='spalva'><br>";
            } elseif ($selectedDataType === 'vairuotojai') {
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
            }
        } else {
            echo "No data type selected.";
        }

        echo "<input type='submit' name='insert_data' value='Insert Data'>";
        echo "</form>";
    } elseif (isset($_POST["insert_data"])) {
        // Code for inserting new data into the database
        $selectedDataType = $_POST["data_type"];

        if ($selectedDataType === 'keleivis') {
            $vardas = $_POST["vardas"];
            $pavarde = $_POST["pavarde"];
            $telNr = $_POST["tel_nr"];

            // Insert the data into the 'keleivis' table
            $insertSql = "INSERT INTO keleivis (Vardas, Pavarde, TelNr) VALUES ('$vardas', '$pavarde', '$telNr')";
            if (mysqli_query($conn, $insertSql)) {
                echo "New record inserted successfully.";
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        } elseif ($selectedDataType === 'keliones') {
            $keleivioID = $_POST["keleivio_id"];
            $vairuotojoID = $_POST["vairuotojo_id"];
            $paemimoAdresas = $_POST["paemimo_adresas"];
            $nuvezimoAdresas = $_POST["nuvezimo_adresas"];
            $kaina = $_POST["kaina"];

            // Insert the data into the 'keliones' table
            $insertSql = "INSERT INTO keliones (KeleivioID, VairuotojoID, PaemimoAdresas, NuvezimoAdresas, Kaina) VALUES ('$keleivioID', '$vairuotojoID', '$paemimoAdresas', '$nuvezimoAdresas', '$kaina')";
            if (mysqli_query($conn, $insertSql)) {
                echo "New record inserted successfully.";
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        } elseif ($selectedDataType === 'masinos') {
            $nr = $_POST["nr"];
            $modelis = $_POST["modelis"];
            $spalva = $_POST["spalva"];

            // Insert the data into the 'masinos' table
            $insertSql = "INSERT INTO masinos (Nr, Modelis, Spalva) VALUES ('$nr', '$modelis', '$spalva')";
            if (mysqli_query($conn, $insertSql)) {
                echo "New record inserted successfully.";
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        } elseif ($selectedDataType === 'vairuotojai') {
            $vardas = $_POST["vardas"];
            $pavarde = $_POST["pavarde"];
            $asmensKodas = $_POST["asmens_kodas"];
            $telNr = $_POST["tel_nr"];
            $email = $_POST["email"];
            $adresas = $_POST["adresas"];
            $masinosID = $_POST["masinos_id"];
            $darboLaikasID = $_POST["darbo_laikas_id"];

            // Insert the data into the 'vairuotojai' table
            $insertSql = "INSERT INTO vairuotojai (Vardas, Pavarde, AsmensKodas, TelNr, Email, Adresas, MasinosID, DarboLaikas_ID) VALUES ('$vardas', '$pavarde', '$asmensKodas', '$telNr', '$email', '$adresas', '$masinosID', '$darboLaikasID')";
            if (mysqli_query($conn, $insertSql)) {
                echo "New record inserted successfully.";
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        }
    }
}
?>

<!-- User interface -->
<h2>Taxi Company Database</h2>
<form method="post">
    <input type="submit" name="skaityti" value="Skaityti">
    <input type="submit" name="irasyti" value="Įrašyti">
</form>
</body>
</html>
