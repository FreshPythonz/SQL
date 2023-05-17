<?php
    include_once 'DBLogin.php';
    include 'Skaityti.php';
    include 'Ieskoti.php';
    include 'Irasymas.php';
    include 'Redaguoti.php';
    include 'Istrinti.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <style>
        label,button, select, input, td
        {
            font-size: 22px;
        }
    </style>
    <h1> Taxi duomenu baze: </h1>
    <form name = "main">
    <label>Pasirinkitę ką norite daryti:<br></label>
        <select name="veiksmas">
            <option <?php if(isset($_GET['veiksmas'])){if($_GET['veiksmas'] == "Skaityti"){echo "selected";}} ?> >Skaityti</option>
            <option <?php if(isset($_GET['veiksmas'])){if($_GET['veiksmas'] == "Įrašyti"){echo "selected";} }?>>Įrašyti</option>
            <option <?php if(isset($_GET['veiksmas'])){if($_GET['veiksmas'] == "Redaguouti"){echo "selected";} }?>>Redaguouti</option>
            <option <?php if(isset($_GET['veiksmas'])){if($_GET['veiksmas'] == "Trinti"){echo "selected";} }?>>Trinti</option>
        </select>
        <br>
        <br>
        <label>Pasirinkitę kokią lentelę norite naudoti:<br></label>
        <select name="lentele">
            <option <?php if(isset($_GET['lentele'])){ if($_GET['lentele'] == "darbolaikas"){echo "selected";} }?>>Darbo Laikas</option>
            <option <?php if(isset($_GET['lentele'])){if($_GET['lentele'] == "kainos"){echo "selected";} }?>>Kainos</option>
            <option <?php if(isset($_GET['lentele'])){if($_GET['lentele'] == "keleivis"){echo "selected";} }?>>Keleivis</option>
            <option <?php if(isset($_GET['lentele'])){if($_GET['lentele'] == "keliones"){echo "selected";}} ?>>Keliones</option>
            <option <?php if(isset($_GET['lentele'])){if($_GET['lentele'] == "masinos"){echo "selected";}} ?>>Masinos</option>
            <option <?php if(isset($_GET['lentele'])){if($_GET['lentele'] == "vairuotojai"){echo "selected";}}?>>Vairuotojai</option>
        </select>
        <br><br>
        <button type="submit" name ="submit" value="veiksmas">Vykdyti</button>
<?php 

if(isset($_GET['submit']))
{
    $veiksmas = $_GET['veiksmas'];
    $lentele = $_GET['lentele'];
    $sql = "SELECT * FROM " . $lentele . ";";
    switch ($veiksmas)
    {
        case "Skaityti":
            $stulpelis = "";
            if($_GET['submit'] == "ieskoti")
            {
                $stulpelis = $_GET['stulpelis'];
                $raktazodis = $_GET['raktazodis'];
                $sql = "SELECT * FROM " . $lentele . " WHERE " . $stulpelis .  " LIKE '%" . $raktazodis . "%' ;";
            }
            $result = mysqli_query($conn,$sql);
            Ieskoti($lentele);
            Skaityti($result,$lentele);
            break;
        case "Įrašyti":
            Irasyti($lentele,$conn);
            $result = mysqli_query($conn,$sql);
            Skaityti($result,$lentele);
            break;
        case "Redaguouti":
            Redaguoti($lentele, $conn);
            $result = mysqli_query($conn,$sql);
            Skaityti($result,$lentele);
            break;
        case "Trinti":
            Trinti($lentele, $conn);
            $result = mysqli_query($conn,$sql);
            Skaityti($result,$lentele);
            break;
    }
}
else
{
    echo '</form>
    <br>';
}

?>
</body>
</html>