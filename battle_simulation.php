<?php

function check_battle_info($hero, $beast){

  $battle_info = array(
    'counter_actions' => 0,
    'counter_attacks' => 0,
    'counter_missed_attacks' => 0,
    'attacker' => array(),
    'defender' => array(),
  );

  $counter_actions = 0;
  $counter_attacks = 0;
  $counter_missed_attacks = 0;

  // hero has higher speed
  if($hero['stats']['speed'] > $beast['stats']['speed']) {

    $attacker = $hero;
    $defender = $beast;
  }

  // beast has higher speed
  if($hero['stats']['speed'] < $beast['stats']['speed']) {

    $attacker = $beast;
    $defender = $hero;
  }

  // hero & beast are equal in speed
  if($hero['stats']['speed'] == $beast['stats']['speed']) {

    // hero has higher luck
    if($hero['stats']['luck'] > $beast['stats']['luck']) {

      $attacker = $hero;
      $defender = $beast;

    // beast has higher luck
    } elseif($hero['stats']['luck'] < $beast['stats']['luck']) {

      $attacker = $beast;
      $defender = $hero;

    // hero & beast are equal in luck
    } else {

      // no info in gameplay (hero choice)
      $attacker = $hero;
      $defender = $beast;
    }
  }

  $stats = get_attacker_and_defender_stats($attacker, $defender);

  $str_saver = 0;
  $hp_saver = 0;
  $def_saver = 0;

  $atk_def_str_saver = 0;
  $atk_def_hp_saver = 0;

  $atk_def_saver = array();

  while($counter_actions < 20 && ($stats['attacker_hp'] > 0 && $stats['defender_hp'] > 0)) {

    $damage = get_damage_info($attacker, $defender, $stats);

    show_beggining_info($attacker, $defender, $damage, $stats);

    // 0 = attaker will miss, 1 = attaker won't miss
    $defender_is_lucky = rand(0, 1);

    defender_is_lucky_info($defender_is_lucky);

    if(!$defender_is_lucky){

      show_defender_hp_after_battle($stats, $damage);
      $stats['defender_hp'] = $stats['defender_hp'] - $damage;

      $counter_attacks++;

    } else {

      show_defender_hp_after_missed_battle($stats);
      $counter_missed_attacks++;
    }

    $str_saver = $stats['attacker_str'];
    $stats['attacker_str'] = $stats['defender_str'];
    $stats['defender_str'] = $str_saver;

    $hp_saver =  $stats['attacker_hp'];
    $stats['attacker_hp'] =  $stats['defender_hp'];
    $stats['defender_hp'] = $hp_saver;

    $def_saver =  $stats['attacker_def'];
    $stats['attacker_def'] =  $stats['defender_def'];
    $stats['defender_def'] = $def_saver;

    $atk_def_hp_saver = 0;

    $atk_def_saver = $attacker;
    $attacker = $defender;
    $defender = $atk_def_saver;

    $counter_actions++;
    echo '<hr>';
  }

  echo 'TOTAL FIGHTS: '. $counter_actions;
  echo '<br>';

  if($counter_actions <= 20) {

    if($stats['attacker_hp'] < $stats['defender_hp']) {
      echo 'WINNER: '. $defender['name'];
    } elseif($stats['attacker_hp'] > $stats['defender_hp']) {
      echo 'WINNER: '. $attacker['name'];
    } else {
      echo 'NO WINNERS!';
    }
  } else {

    if($stats['attacker_hp'] < 0) {
      echo 'WINNER: '. $defender['name'];
    } else {
      echo 'WINNER: '. $attacker['name'];
    }
  }

  $battle_info['attacker'] = $attacker;
  $battle_info['defender'] = $defender;

  return $battle_info;
}

function show_beggining_info($attacker, $defender, $damage, $stats) {

  echo '<span class="info_attacker_name">Attacker: '. $attacker['name'] .'</span>';
  echo '<br>';

  echo 'HP: '. $stats['attacker_hp'];
  echo '<br>';
  echo 'STR: '. $stats['attacker_str'];
  echo '<br>';
  echo 'DEF: '. $stats['attacker_def'];
  echo '<br>';
  echo 'DAMAGE: '. $damage;
  echo '<br>';

  echo '<span class="info_defender_name">Defender: '. $defender['name'] .'</span>';
  echo '<br>';
  echo 'HP: '. $stats['defender_hp'];
  echo '<br>';
  echo 'STR: '. $stats['defender_str'];
  echo '<br>';
  echo 'DEF: '. $stats['defender_def'];
  echo '<br>';
}

function defender_is_lucky_info($number) {

  if($number == 1) {

    echo 'Attacker will miss his attack';
    echo '<br>';
  } else {

    echo 'Attacker won`t miss his attack!';
    echo '<br>';
  }
}

function show_defender_hp_after_battle($stats, $damage) {

  $hp_after_battle = $stats['defender_hp'] - $damage;
  echo 'HP after battle: '. $hp_after_battle;
  echo '<br>';
}

function show_defender_hp_after_missed_battle($stats) {

  echo 'HP after a missed battle: '. $stats['defender_hp'];
  echo '<br>';
}

function get_attacker_and_defender_stats($attacker, $defender) {

  return array(
    'attacker_str' => $attacker['stats']['str'],
    'attacker_hp' => $attacker['stats']['hp'],
    'attacker_def' => $attacker['stats']['def'],
    'defender_str' => $defender['stats']['str'],
    'defender_hp' => $defender['stats']['hp'],
    'defender_def' => $defender['stats']['def'],
  );
}

function get_damage_info($attacker, $defender, $stats) {

  $damage = $stats['attacker_str'] - $stats['defender_def'];

  //attacker will have double damage
  if(isset($attacker['skills'])) {

    $double_damage_chance = rand(0, 100);
    if($attacker['skills']['2x']['chance'] >= $double_damage_chance) {

      echo 'INFO | Attacker will have double damage.';
      echo '<br>';
      $damage = $damage * 2;
    }
  }

  //defender will block half of damage
  if(isset($defender['skills'])) {

    $block_half_damage_chance = rand(0, 100);
    if($defender['skills']['shield']['chance'] >= $block_half_damage_chance) {

      echo 'INFO | Defender will block half of damage.';
      echo '<br>';
      $damage = $damage / 2;
    }
  }

  return $damage;
}
