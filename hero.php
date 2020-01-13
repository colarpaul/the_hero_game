<?php

$hero = array();

$hero['name'] = 'Orderus';
$hero['stats'] = array(
  'hp' => rand(70, 100),
  'str' => rand(70, 80),
  'def' => rand(45, 55),
  'speed' => rand(40, 50),
  'luck' => rand(10, 30),
);
$hero['skills'] = array(
  '2x' => array(
    'name' => 'Rapid Strike',
    'description' => 'Strike twice while it’s his turn to attack; there’s a 10% chance he’ll use this skill every time he attacks',
    'chance' => 10,
  ),
  'shield' => array(
    'name' => 'Magic Shield',
    'description' => 'Takes only half of the usual damage when an enemy attacks; there’s a 20% change he’ll use this skill every time he defends',
    'chance' => 20,
  )
);
