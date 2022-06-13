<!doctype html>
<html lang="fr">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="UTF-8">
  <meta http-equiv="refresh" content="10">
  <title>Projet Snir 2022 - Montgolfière</title>
  <link rel="stylesheet" href="Test.css">
  <script src="Test.js"></script>
</head>

<body>
  <style>
    body {
      background-image: url('/image/background.jpg');
      background-repeat: no-repeat;
      background-attachment: fixed;
      background-size: cover;
    }
  </style>

  <center>
    <h1> <strong style="background-color: rgb(51, 45, 45); padding: 0 5px; color: #fff;"> Projet Snir 2022 - Montgolfière : </strong> </h1>
    <center>

      <p> <strong style="background-color: rgb(51, 45, 45); padding: 0 5px; color: #fff;"> Affichage des valeurs des capteurs : </strong> </p>
      <center>

        <div id="myDIV">

          <?php

          $host = '192.168.107.136';
          $user = 'usersnir2';
          $pwd = 'projetmontgolfiere';
          $db = 'projet';

          $mysqli = new mysqli($host, $user, $pwd, $db);

          if (!$mysqli) {
            echo "Erreur de connexion";
          }

          $mysqli->set_charset("utf8");

          $result = $mysqli->query("SELECT * FROM ProjetMontgolfiere ORDER BY Date DESC;");

          echo "<table border='1'>";
          echo "<tr><td>Humidite</td><td>Temperature</td><td>Debit</td><td>Son</td><td>Pression</td><td>Date</td><td>Heure</td></tr>\n";
          while ($data = mysqli_fetch_array($result)) {
            echo "<tr><td>{$data['Humidite']}</td><td>{$data['Temperature']}</td><td>{$data['Debit']}</td><td>{$data['Son']}</td><td>{$data['Pression']}</td><td>{$data['Date']}</td><td>{$data['Heure']}</td></tr>\n";
          }
          echo "</table>";
          ?>

        </div>

        <p> <strong style="background-color: rgb(51, 45, 45); padding: 0 5px; color: #fff;"> Affichage photo de la caméra thermique : </strong> </p>
        <center>

          <div id="myDIV2">

            <?php

            $host = '192.168.107.136';
            $user = 'root';
            $pwd = 'adminx';
            $db = 'projet';

            $mysqli = new mysqli($host, $user, $pwd, $db);

            if (!$mysqli) {
              echo "Erreur de connexion";
            }

            $result = $mysqli->query("SELECT * FROM tb_upload");

            echo "<table border='1' width='0%' >";
            while ($row = mysqli_fetch_array($result)) {
              echo "<tr>";
              echo "<td><img src='/image/" . $row['src'] . " 'width=\"200\" height=\"200\"' /></td>";
              echo "</tr>";
            }
            echo "</table>";
            mysqli_close($con);

            ?>

          </div>

          <p> <strong style="background-color: rgb(51, 45, 45); padding: 0 5px; color: #fff;"> Affichage vidéo de la caméra thermique : </strong> </p>
          <center>

            <div id="myDIV3">

              <center>
                <video controls width="425">

                  <source src="/video/video.mp4" type="video/mp4">
                </video>
              </center>

            </div>

</body>