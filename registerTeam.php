<?php
ini_set('display_errors', 1);
require('./connect.php');
$status['registerParticipant'] = "";

if (isset($_POST['register']) && isset($_POST['sports']) && $_POST['sports'] === 'athletics') {
    $captainId = $_POST['captainId'];
    $sport  = $_POST['sports'];
    $members = $_POST['noPlayers'];
    $aux = $_POST['athleticsEvents'];
    $team = array();
    $addCaptain  = $pdo->prepare('UPDATE participants SET isCaptain = 1 WHERE InfCode = ?');
    $addCaptain->execute([$captainId]);
    array_push($team, $captainId);
    $i = 1;
    $flag = 1;
    while ($i <= $members) {
        if (in_array($_POST["mem$i"], $team)) {
            $flag = 0;
            $status["registerParticipant"] = "Cannot have same id for two players";
            break;
        }
        array_push($team, $_POST["mem$i"]);
        $i++;
    }
    foreach ($team as $member) {
        $check1 = $pdo->prepare('SELECT * FROM participants WHERE InfCode = ?');
        $check1->execute([$member]);
        if ($check1->rowCount() == 0) {
            $status['registerParticipant'] = "Id $team not found . First register individually for Infinito";
            $flag = 0;
            break;
        }
        $check2 = $pdo->prepare('SELECT * FROM registered WHERE InfCode = ? AND Sport = ? AND Aux = ?');
        $check2->execute([$member, $sport, $aux]);
        if ($check2->rowCount() !== 0) {
            $status['registerParticipant'] = "Infinito Id $member already registered for $sport in $aux ";
            $flag = 0;
            break;
        }
    }
    if ($flag === 1) {
        $addCaptain  = $pdo->prepare('UPDATE participants SET isCaptain = 1 WHERE InfCode = ?');
        $addCaptain->execute([$captainId]);
        foreach ($team as $member) {
            $stmt = $pdo->prepare('INSERT INTO registered (`Sport`,`InfCode`,`Aux`) VALUES (?,?,?)');
            $val = $stmt->execute([$sport, $member, $aux]);
        }
    }
    if ($flag === 1) $status['registerParticipant'] = "Successfully registered team for $sport in $aux";

} else if (isset($_POST['register']) && isset($_POST['sports']) && $_POST['sports'] !== 'athletics') {
    $captainId = $_POST['captainId'];
    $sport  = $_POST['sports'];
    $members = $_POST['noPlayers'];
    $aux = "";
    if(isset($_POST['Gender']))
    $aux = $_POST['Gender'];
    $team = array();
    array_push($team, $captainId);
    $i = 1;
    $flag = 1;
    while ($i <= $members) {
        if (in_array($_POST["mem$i"], $team)) {
            $flag = 0;
            $status["registerParticipant"] = "Cannot have same id for two players";
            break;
        }
        array_push($team, $_POST["mem$i"]);
        $i++;
    }

    $val = 0;
    foreach ($team as $member) {
        $check1 = $pdo->prepare('SELECT * FROM participants WHERE InfCode = ?');
        $check1->execute([$member]);
        if ($check1->rowCount() == 0) {
            $status['registerParticipant'] = "No $member found . First register individually for Infinito";
            $flag = 0;
            break;
        }
        $check2 = $pdo->prepare('SELECT * FROM registered WHERE InfCode = ? AND Sport = ? AND Aux= ?');
        $check2->execute([$member, $sport, $aux]);
        if ($check2->rowCount() !== 0) {
            $status['registerParticipant'] = "Infinito Id $member already registered for $sport  ";
            $flag = 0;
            break;
        }
    }
    if ($flag == 1) {
        $addCaptain  = $pdo->prepare('UPDATE participants SET isCaptain = 1 WHERE InfCode = ?');
        $addCaptain->execute([$captainId]);
        foreach ($team as $member) {
            $stmt = $pdo->prepare('INSERT INTO registered (`Sport`,`InfCode`,`Aux`) VALUES (?,?,?)');
            $val = $stmt->execute([$sport, $member,$aux]);
        }
    }
    if ($flag === 1) $status['registerParticipant'] = "Successfully registered team for $sport ";
}
//   $teamcode = '';
//   $captaincode = '';
//   while (isset($_POST["team$i"]) && strlen($_POST["team$i"]) !== 0) {
//     try {
//       $stmt = $pdo->prepare('INSERT INTO Participants (`Name`,`College`,`Sports`,`isCaptain`,`InfCode`) VALUES (?,?,?,?,?);');
//       $result =  $stmt->execute([$_POST["team$i"], $collegeName, $sports, 0, 0]);
//       $stmt2 = $pdo->prepare('SELECT * FROM Participants WHERE Name = ? AND College = ? AND Sports = ?');
//       $result =  $stmt2->execute([$_POST["team$i"], $collegeName, $sports]);
//       $data = $stmt2->fetch();
//       $id = 3000 + $data['Id'];
//       $id = "INFN_$id";
//       $partname = $data['Name'];
//       $teamcode .= 'Team Member ' . $i . '\n Name : ' . $partname . '   InfinitoId : ' . $id . '\n\n';
//       $stmt3 = $pdo->prepare('UPDATE Participants SET InfCode = ? WHERE Name = ? AND College = ? AND Sports = ?');
//       $result =  $stmt3->execute([$id, $_POST["team$i"], $collegeName, $sports]);
//       echo "runs     " . $result . "\n";
//     } catch (PDOException $e) {
//       echo $e;
//     }

//     $i = $i + 1;
//   }

//   $stmt = $pdo->prepare('INSERT INTO Participants (`Name`,`College`,`Sports`,`isCaptain`,`InfCode`) VALUES (?,?,?,?,?);');
//   $result =  $stmt->execute([$captain, $collegeName, $sports, 1, 0]);
//   $stmt2 = $pdo->prepare("SELECT * FROM Participants WHERE Name = ? AND isCaptain = 1 AND Sports = ?");
//   $result = $stmt2->execute([$captain, $sports]);
//   $data = $stmt2->fetch();
//   $id = 3000 + $data['Id'];
//   $id = "INFN_$id";
//   $message = 'Captain ' . $i . '\n Name : ' . $captain . '   InfinitoId : ' . $id . '   Sport : ' . $sports . '\n\n\n' . $teamcode;
//   $stmt3 = $pdo->prepare('INSERT INTO Captains (`Id`,`Name`,`Email`,`College`) VALUES (?,?,?,?)');
//   $result2 = $stmt3->execute([$id, $captain, $captainsEmail, $collegeName]);
//   if ($result && $result2) {
//     require('./mail.php');
//   } else {
//     $status["registerparticipant"] = "Please register again";
//   }

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>Team Registration</title>
    <?php
    require('./templates/header.php');
    ?>
</head>

<body>
    <!--
	=============================================
		Theme Header
	==============================================
    -->
    <div class="bac" style="background: #172134; position:fixed; width:100%; top:0px; z-index:100; margin-bottom:100px;">
        <div class="container" style="padding:10px 0">
            <a href="index.php" class="logo float-left tran4s"><img src="images/logo/logo.png" alt="Logo" style="border-radius:100%; height:56px; width:56px;" /></a>

            <!-- ========================= Theme Feature Page Menu ======================= -->
            <nav class="navbar float-right theme-main-menu one-page-menu">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-1" aria-expanded="false" style="margin-top:8px;">
                        <span class="sr-only">Toggle navigation</span>
                        Menu
                        <i class="fa fa-bars" aria-hidden="true"></i>
                    </button>
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="navbar-collapse-1">
                    <ul class="nav navbar-nav" style="margin-top:8px;">
                        <li><a href="./index.php">Home</a></li>
                        <li><a href="./events.php">Events</a></li>
                        <li><a href="./team.php">Team</a></li>
                        <li><a href="./gallery.php">Gallery</a></li>
                        <li class="active"><a href="./registration.php">Register</a></li>
                        <?php
                                if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
                                    echo '<li><a href="./profile.php">Profile</a></li>
                                          <li><a href="./logout.php">Logout</a></li>';
                                }
                                else{
                                    echo '
                                    <li><a href="./signIn.php">Sign In</a></li>';
                                }
                            ?>
                        
                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </nav>
            <!-- /.theme-feature-menu -->
        </div>
    </div>


    <!-- /.theme-main-header -->
    <div class="container">
        <?php if ($status['registerParticipant'] !== "") { ?>
            <div class="alert alert-info">
                <?php echo $status['registerParticipant'] ?>
            </div>
        <?php } ?>
        <div id="register" style="height:100vh">
            <div class="theme-title">
              <h2>Register</h2>
            </div>


            <form action="" method="POST" id="form">
                <div class="form-row" style="padding-top:40px">
                    <div class="form-group col-md-6 col-sm-12 col-xs-12 ">
                        <label for="captainId">Enter Captains Infinito Id</label>
                        <input type="text" class="form-control" name="captainId" placeholder="Infinito Id" required>
                    </div>
                    <div class="form-group col-md-6 col-sm-12 col-xs-12">
                        <label for="College">Enter Your College Name</label>
                        <input type="text" class="form-control" name="collegeName" required>
                    </div>
                </div>

              <div class="form-row">
                  <div class="form-group col-md-6 col-sm-12 col-xs-12">
                      <label for="Sports">Select your sport</label>
                      <select name="sports" class="form-control" id="sport">
                          <option value="basketball">Basketball</option>
                          <option value="football">Football</option>
                          <option value="tabletennis">Table Tennis</option>
                          <option value="volleyball">Volleyball</option>
                          <option value="cricket">Cricket</option>
                          <option value="athletics">Athletics</option>
                    </select>
                  </div>
                  <div class="form-group col-md-6 col-sm-12 col-xs-12">
                      <label for="numberOfPlayers">Number of Players in Team</label>
                      <input type="number" name="noPlayers" class="form-control" placeholder="Number  of Players except Captain" max="20" min="0" id="noPlayers" required>
                  </div>
                </div>
                <div class="form-row">
                    <div style="padding-left:1%">
                        <button type="button" class="btn btn-primary" name="cont" onclick="regBoxShow()">Next</button>
                    </div>
                </div>
                <div id="members" style="padding-top:5%">

                </div>
                <div id="athleticsType" style="padding-top:5%">

                </div>

            </form>
        </div>
    </div>

    <!-- Js File_________________________________ -->
    <script>
        function regBoxShow() {
            const data = document.getElementById('noPlayers').value
            let string = "";
            let i = 1;
            while (i <= data) {
                string += '<div class="form-row"><div class="col-md-6 col-sm-12 col-xs-12" ><label for="teamMember">Enter Id of Member ' + i + '</label><input type="text" class="form-control" name="mem' + i + '" required></div></div>'
                i++;
            }
            document.getElementById('members').innerHTML = string;
            const sport = document.getElementById('sport').value;
            console.log(document.getElementById('athleticsType'))
            const string2 = '<div class="form-row"><div class="col-md-12 col-sm-12 col-xs-12" style="padding-top:20px"><button type="submit" class="btn btn-primary" name="register">Register</button></div></div>';

            if (sport === 'athletics') {
                document.getElementById('athleticsType').innerHTML = '<div class="form-group col-md-12 col-sm-12 col-xs-12"><label for="numberOfPlayers">Athletics Event</label><select name="athleticsEvents" id="" class="form-control"><option value="Boys 100m">Boys 100m</option><option value="Boys 200m">Boys 200m</option><option value="Boys 400m">Boys 400m</option><option value="Boys 800m">Boys 800m</option><option value="Boys 1500m">Boys 1500m</option><option value="Boys Long Jump">Boys Long Jump</option><option value="Boys shotput">Boys shotput</option><option value="Boys javellin">Boys javellin</option><option value="Boys Discuss Throw">Boys Discuss Throw</option><option value="Boys 100 X 4">Boys 100 X 4</option><option value="Boys 400 X 4">Boys 400 X 4</option><option value="Girls 100m">Girls 100m</option><option value="Girls 200m">Girls 200m</option><option value="Girls 400m">Girls 400m</option><option value="Girls 800m">Girls 800m</option><option value="Girls 1500m">Girls 1500m</option><option value="Girls Long Jump">Girls Long Jump</option></select></div>' + string2
            } else if(sport === 'basketball' || sport === 'volleyball' || sport === 'tabletennis') {
                document.getElementById('athleticsType').innerHTML = '<div class="form-group col-md-12 col-sm-12 col-xs-12"><label for="Gender">Gender</label><select name="Gender" class="form-control" id="gender"><option value="Male">Male</option><option value="Female">Female</option></select></div>'  + string2;
            }
            else{
                document.getElementById('athleticsType').innerHTML = string2;
            }
        }
    </script>
    <?php 
    require('./templates/footer.php');
    ?>

</body>
</html>
