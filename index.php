<?php require_once('hero.php'); ?>
<?php require_once('beast.php'); ?>
<?php require_once('battle_simulation.php'); ?>

<!DOCTYPE html>
<html>
<head>
<title>Emag - The Hero Game</title>
<link rel="stylesheet" type="text/css" href="main.css">
</head>
<body>

<div class="hero_container">
  <h1>Hero: <span class="hero_name"><?php echo $hero['name']; ?></span></h1>

  <h2>Stats: </h2>
  <table>
    <?php foreach($hero['stats'] as $stats_name => $stats_value): ?>
    <tr>
      <td>
        <span class="hero_stats_<?php echo $stats_name; ?>">
          <?php echo mb_strtoupper($stats_name); ?>
        </span>
      </td>
      <td>
        <span class="hero_stats_<?php echo $stats_name; ?>">
          <?php echo $stats_value; ?>
        </span>
      </td>
    </tr>
    <?php endforeach; ?>
  </table>

  <h2>Current skills: </h2>
  <?php foreach($hero['skills'] as $skills => $skills_info): ?>
    <div><span class="skill_name"><?php echo $skills_info['name']; ?></span> => <?php echo $skills_info['description']; ?></div>
  <?php endforeach; ?>

</div>

<div class="beast_container">
  <h1>Beast: <span class="beast_name"><?php echo $beast['name']; ?></span></h1>

  <h2>Stats: </h2>
  <table>
    <?php foreach($beast['stats'] as $stats_name => $stats_value): ?>
    <tr>
      <td>
        <span class="beast_stats_<?php echo $stats_name; ?>">
          <?php echo mb_strtoupper($stats_name); ?>
        </span>
      </td>
      <td>
        <span class="hero_stats_<?php echo $stats_name; ?>">
          <?php echo $stats_value; ?>
        </span>
      </td>
    </tr>
    <?php endforeach; ?>
  </table>
</div>

<div class="battle_simulation_container">
  <h1>Battle simulation:</h1>
  <h2><span class="battle_simulation_title"><?php echo $hero['name'].' vs '.$beast['name']?></span></h2>

  <?php $battle_info = check_battle_info($hero, $beast); ?>
</div>

</body>

</html>
